<?php
/**
 * @package cim_hrdb
 */ 
/**
 * class page_ViewStaffActivities 
 * <pre> 
 * A simple page to display a list of activities (possibly filtered by type).
 * </pre>
 * @author CIM Team
 * Date:   18 Mar 2008
 */
class  page_ViewStaffActivities extends PageDisplay_DisplayList {

	//CONSTANTS:
	const UNAUTHORIZED_DIRECTOR = -2;
 	const NON_DIRECTOR = -3;
 	const NO_ACTIVITIES = -5;
	
	/** The list of fields to be displayed */
    const DISPLAY_FIELDS = 'person_id,activitytype_id,staffactivity_startdate,staffactivity_enddate,staffactivity_contactPhone';
    
    /** The Multilingual Page Key for labels on this page */
    const MULTILINGUAL_PAGE_KEY = 'page_ViewStaffActivities';
    

	//VARIABLES:
	
	/** @var [OBJECT] The viewer object. */
	protected $viewer;
	
    /** @var [STRING] The path to this module's root directory. */
	protected $pathModuleRoot;
	
	/** @var [INTEGER] The filter values for the listManager. */
	protected $staffactivityID;
	protected $activityTypeID;

	/** @var [BOOLEAN] Whether to disable the heading */
	protected $disableHeading;
	
// 	public $testdate;
				
	
	//CLASS CONSTRUCTOR
	//************************************************************************
	/**
	 * function __construct
	 * <pre>
	 * Initialize the object.
	 * </pre>
	 * @param $pathModuleRoot [STRING] The path to the module's root dir.
	 * @param $viewer [OBJECT] The viewer object.
	 * @param $sortBy [STRING] Field data to sort listManager by.
     * @param $managerInit [INTEGER] Initialization value for the listManager.
	 * @return [void]
	 */
    function __construct($pathModuleRoot, $viewer, $sortBy, $staffactivity_id = '', $activitytype_id = '',  $disable_heading = false, $start_date = '', $end_date = '') 
    {
	    // remove activity types from page listing if there is only one common activity type
	    if ($activitytype_id != '')
	    {
    		 $DISPLAY_FIELDS = 'person_id,staffactivity_startdate,staffactivity_enddate,staffactivity_contactPhone';
    		 parent::__construct($DISPLAY_FIELDS );
 		 }
 		 else
 		 {		    
        	 parent::__construct( page_ViewStaffActivities::DISPLAY_FIELDS );
     	 }
        
//         $this->testdate = $start_date;        
//         echo 'dates = '.$start_date.' and '.$end_date;
        
        $this->pathModuleRoot = $pathModuleRoot;
        $this->viewer = $viewer;
               
       $this->staffactivityID =  $staffactivity_id;
       $this->activityTypeID = $activitytype_id;
       
       $this->disableHeading = $disable_heading;
       
       // Default sorting: person_id, start_date, end_date   // TODO: use person name not person_id
       if ($sortBy == '')
       {
       	$sortBy = 'person_id,staffactivity_startdate,staffactivity_enddate';
    	 }
  
       
        // Now load the access Priviledge manager of this viewer
        $this->adminManager = new RowManager_AdminManager( );

        // Get the person ID
        $accessManager = new RowManager_AccessManager( );
        $accessManager->loadByViewerID( $this->viewer->getViewerID( ) );
        $personID = $accessManager->getPersonID();

        // Get the permissions the person has.
        $this->adminManager->loadByPersonID( $personID );

        // Super-admin
        if ( $this->adminManager->hasSitePriv()  )
        {
	       	/*** Setup basic details for Staff Activity data-access object **/
	        if ($this->staffactivityID != '')
	        {        
	        		$dataAccessObject = new RowManager_StaffActivityManager($this->staffactivityID);   
		     }
		     else 
		     {
	        		$dataAccessObject = new RowManager_StaffActivityManager();   
		     }
		     		         
	        if ($this->activityTypeID != '')
	        {
	        		$dataAccessObject->setActivityTypeID($this->activityTypeID);
	     	  }	
	     	  if (($start_date != '')&&($end_date != ''))
	     	  {
		     	  // Create sub-query 1: activity date-range falls exactly within (or equal to) the date-range parameters
		     	  $activities1 = new RowManager_StaffActivityManager();
		     	  $activities_manager1 = new MultiTableManager();
		     	  $activities_manager1->addRowManager($activities1);
		     	  $activities_manager1->setFieldList('staffactivity_id');		     	  
		     	  $dateWithinRange = "staffactivity_startdate >= '".$start_date."' and staffactivity_enddate <= '".$end_date."'";
		     	  $activities_manager1->addSearchCondition($dateWithinRange);
        	     $internalRange_subQuery = $activities_manager1->createSQL();
	
		     	  // Create sub-query 2: activity date-range encloses (or is equal to) the date-range parameters
		     	  $activities2 = new RowManager_StaffActivityManager();
		     	  $activities_manager2 = new MultiTableManager();
		     	  $activities_manager2->addRowManager($activities2);
		     	  $activities_manager2->setFieldList('staffactivity_id');		     	  
		     	  $dateWithinRange = "staffactivity_startdate <= '".$start_date."' and staffactivity_enddate >= '".$end_date."'";
		     	  $activities_manager2->addSearchCondition($dateWithinRange);
        	     $containsRange_subQuery = $activities_manager2->createSQL();        	     	     	  
		     	  
        	     // Create final query condition which includes Case 3: date-range parameters are intersected by activity date-range
		     	  $validDateConditions = "staffactivity_startdate between '".$start_date."' and '".$end_date."' or ";
		     	  $validDateConditions .= "staffactivity_enddate between '".$start_date."' and '".$end_date."' or ";
		     	  $validDateConditions .= "staffactivity_id in (".$internalRange_subQuery.") or ";
		     	  $validDateConditions .= "staffactivity_id in (".$containsRange_subQuery.")";		     	  
		     	  
	        	  $dataAccessObject->addSearchCondition($validDateConditions);  		
	     	  }			     	          
	        
	        $dataAccessObject->setSortOrder( $sortBy );	        	        
	        $this->listManager = $dataAccessObject->getListIterator();	        
        }        
        else if ( $this->adminManager->isStaff($viewer->getID()) )	// Staff
        {
	        $director_id = $this->getStaffIDfromViewerID();
	        
// 	        $staffPersonManager = new MultiTableManager();	        
	        $staffManager = new RowManager_StaffDirectorManager();
	        $staffManager->setDirectorID($director_id);
// 	        $staffInfoManager = new RowManager_StaffManager();

// 	        $staffPersonManager->addRowManager($staffInfoManager);
// 	        $staffPersonManager->addRowManager($staffManager, new JoinPair($staffManager->getJoinOnStaffID(),$staffInfoManager->getJoinOnStaffID()));        	        
// 	        $staffList = $staffPersonManager->getListIterator();
// 	        $staffArray = $staffList->getDataList();
	        
				/* Retrieve all directors under the current director */
	        $hierarchy_result = $staffManager->getDirectorHierarchy($director_id);	        
	        $hierarchy_result->setFirst();
	        $hierarchy_array = array();
	        $directed_staff = '';
           while( $hierarchy_result->moveNext() ) {
	           $staff_ids = $hierarchy_result->getCurrentRow();
// 	           echo 'array = <pre>'.print_r($hierarchy_array,true).'</pre>';

					for ($lvl = 1; $lvl <= MAX_DIRECTOR_LEVELS; $lvl++)
					{
						$staff_id = $staff_ids['staff_lvl'.$lvl];
						if ($staff_id != null)
						{
							$directed_staff .= $staff_id.',';
						}
					}					
           }   
           if ($directed_staff != '')	// if staff found under director, then simply remove comma
           {
	          $directed_staff .=	$director_id;	//= substr( $directed_staff, 0, -1 );
           }    
           else 	// Stop any sub-query errors or accidental loosing of control
           {
	          $directed_staff = $director_id;	//page_ViewScheduleCalendar::NON_DIRECTOR;
           }    	  	             

	        // Filter activities by those staff persons found in the list of staff under the direction of the current viewer
	        $dataAccessObject = new MultiTableManager();
	        $schedules = new RowManager_StaffScheduleManager();
// 	        $schedules->addSearchCondition('person_id in ('.$directed_staff.')');
	        $schedule_activities = new RowManager_ActivityScheduleManager();
	        $activities = new RowManager_StaffActivityManager();
	        if ($this->staffactivityID != '')
	        {        
	        		$activities = new RowManager_StaffActivityManager($this->staffactivityID);   
		     }        
        	  if ($this->activityTypeID != '')
           {	       
	        		$activities->setActivityTypeID($this->activityTypeID);
        	  }
        	  $validDateConditions = '';
	     	  if (($start_date != '')&&($end_date != ''))
	     	  {
		     	  // Create sub-query 1: activity date-range falls exactly within (or equal to) the date-range parameters
		     	  $activities1 = new RowManager_StaffActivityManager();
		     	  $activities_manager1 = new MultiTableManager();
		     	  $activities_manager1->addRowManager($activities1);
		     	  $activities_manager1->setFieldList('staffactivity_id');		     	  
		     	  $dateWithinRange = "staffactivity_startdate >= '".$start_date."' and staffactivity_enddate <= '".$end_date."'";
		     	  $activities_manager1->addSearchCondition($dateWithinRange);
        	     $internalRange_subQuery = $activities_manager1->createSQL();
	
		     	  // Create sub-query 2: activity date-range falls exactly within (or equal to) the date-range parameters
		     	  $activities2 = new RowManager_StaffActivityManager();
		     	  $activities_manager2 = new MultiTableManager();
		     	  $activities_manager2->addRowManager($activities2);
		     	  $activities_manager2->setFieldList('staffactivity_id');		     	  
		     	  $dateWithinRange = "staffactivity_startdate <= '".$start_date."' and staffactivity_enddate >= '".$end_date."'";
		     	  $activities_manager2->addSearchCondition($dateWithinRange);
        	     $containsRange_subQuery = $activities_manager2->createSQL();        	     	     	  
		     	  
        	     // Create final query condition which includes Case 3: date-range parameters are intersected by activity date-range
		     	  $validDateConditions = "staffactivity_startdate between '".$start_date."' and '".$end_date."' or ";
		     	  $validDateConditions .= "staffactivity_enddate between '".$start_date."' and '".$end_date."' or ";
		     	  $validDateConditions .= "cim_hrdb_staffactivity.staffactivity_id in (".$internalRange_subQuery.") or ";
		     	  $validDateConditions .= "cim_hrdb_staffactivity.staffactivity_id in (".$containsRange_subQuery.")";		     	  
		     	  
// 	        	  $activities->addSearchCondition($validDateConditions);  		
	     	  }	        	  
        	  
        	  
        	  
// 	        $activityTypes = new RowManager_ActivityTypeManager();
	        $person_info = new RowManager_PersonManager();
	        $staff = new RowManager_StaffManager();
	        
	        $dataAccessObject->addRowManager($activities);
	        $dataAccessObject->addRowManager($schedule_activities, new JoinPair($activities->getJoinOnActivityID(), $schedule_activities->getJoinOnActivityID()));
	        $dataAccessObject->addRowManager($schedules, new JoinPair($schedules->getJoinOnScheduleID(), $schedule_activities->getJoinOnScheduleID()));
// 	        $dataAccessObject->addRowManager($activityTypes, new JoinPair($activityTypes->getJoinOnActivityTypeID(), $activities->getJoinOnActivityTypeID()));
	        $dataAccessObject->addRowManager($person_info, new JoinPair($person_info->getJoinOnPersonID(), $activities->getJoinOnPersonID()));
	        $dataAccessObject->addRowManager($staff, new JoinPair($staff->getJoinOnPersonID(), $person_info->getJoinOnPersonID()));
	        $dataAccessObject->addSearchCondition('staff_id in ('.$directed_staff.')');
// 	        $dataAccessObject->setFieldList('cim_hrdb_staffactivity.person_id,staffactivity_startdate,staffactivity_enddate,staffactivity_contactPhone');	//page_ViewStaffActivities::DISPLAY_FIELDS);
	   
			  if ($validDateConditions != '')
			  {
	        	  $dataAccessObject->addSearchCondition($validDateConditions);  		
        	  }
           
// 	    	 if (!isset($sortBy)||($sortBy == ''))
// 			  {
// 				  $sortBy = 'person_lname';		// TODO: remove this once we figure how to sort person even if name is cover for person_id
// 			  }
// 			  $dataAccessObject->setSortOrder( $sortBy );	
 	        
	        $list_iterator = $dataAccessObject->getListIterator();
	        $data_array = $list_iterator->getDataList();
	        
	        // Go through the inefficient process of grabbing staff activity IDs  (could do min. as subquery)
	        $staff_activities = '';
	        reset($data_array);
	        foreach( array_keys($data_array) as $key )
	        {
		        $row = current($data_array);
		        $staff_activities .= $row['staffactivity_id'].',';
		        next($data_array);
	        }
	        
           if ($staff_activities != '')	// if activities found, then simply remove comma
           {
	          $staff_activities = substr($staff_activities,0,-1);
           }    
           else 	// Stop any sub-query errors or accidental loosing of control
           {
	          $staff_activities = page_ViewStaffActivities::NO_ACTIVITIES;
           }  	        
		         
// 	        echo "<pre>".print_r($data_array,true)."</pre>"; 
// 	        echo '<br>activities = '.$staff_activities.'<br>';
	        
	        /** Apparently we need to use single row manager for staff activity table:
	            therefore use found activity IDs... **/
	        $activities2 = new RowManager_StaffActivityManager($this->staffactivityID);         
			  $activities2->addSearchCondition('staffactivity_id in ('.$staff_activities.')');
			  
	    	  if (!isset($sortBy)||($sortBy == '')||($sortBy == 'person_id'))
			  {
				  $sortBy = 'person_lname';		// TODO: remove this once we figure how to sort person even if name is cover for person_id
			  }
			  $activities2->setSortOrder( $sortBy );				  
			  
	        $this->listManager = $activities2->getListIterator();		// dataAccessObject
	        
// 	        echo "<pre>".print_r($this->listManager->getDataList(),true)."</pre>";
  		  }
  		  else {
	  		  
	        $dataAccessObject = new RowManager_StaffActivityManager(page_ViewStaffActivities::UNAUTHORIZED_DIRECTOR);
	        
	        $this->listManager = $dataAccessObject->getListIterator();
        }

         
         // now initialize the labels for this page
         // start by loading the default field labels for this Module
         $languageID = $viewer->getLanguageID();
         $seriesKey = modulecim_hrdb::MULTILINGUAL_SERIES_KEY;
         $pageKey = modulecim_hrdb::MULTILINGUAL_PAGE_FIELDS;
         $this->labels = new MultilingualManager( $languageID, $seriesKey, $pageKey );
         
         // then load the page specific labels for this page
         $pageKey = page_ViewStaffActivities::MULTILINGUAL_PAGE_KEY;
         $this->labels->loadPageLabels( $pageKey );
         
         $this->labels->setSeriesKey( SITE_LABEL_SERIES_SITE );
         $this->labels->loadPageLabels( SITE_LABEL_PAGE_FORM_LINKS );
         
    }



	//CLASS FUNCTIONS:
	//************************************************************************
	/**
	 * function classMethod
	 * <pre>
	 * [classFunction Description]
	 * </pre>
	 * <pre><code>
	 * [Put PseudoCode Here]
	 * </code></pre>
	 * @param $param1 [$param1 type][optional description of $param1]
	 * @param $param2 [$param2 type][optional description of $param2]
	 * @return [returnValue, can be void]
	 */
    function classMethod($param1, $param2) 
    {
        // CODE
    }	    
    
    
    
    //************************************************************************
	/**
	 * function getHTML
	 * <pre>
	 * This method returns the HTML data generated by this object.
	 * </pre>
	 * @return [STRING] HTML Display data.
	 */
    function getHTML() 
    {
    
        // Make a new Template object
        $path = SITE_PATH_TEMPLATES;
        // Replace $path with the following line if you want to create a
        // template tailored for this page:
        //$path = $this->pathModuleRoot.'templates/';
        
        
        // store the link values
        // $this->linkValues[ 'view' ] = 'add/new/href/data/here';

        
        // store the link labels
        $this->linkLabels[ 'add' ] = $this->labels->getLabel( '[Add]' );
        $this->linkLabels[ 'edit' ] = $this->labels->getLabel( '[Edit]' );
        $this->linkLabels[ 'del'  ] = $this->labels->getLabel( '[Delete]' );
        $this->linkLabels[ 'cont' ] = $this->labels->getLabel( '[Continue]');
        // $this->linkLabels[ 'view' ] = 'new link label here';

        
        // store any additional link Columns
        // example:
            //$title = $this->labels->getLabel( '[title_groups]');
            //$columnLabel = $this->labels->getLabel( '[groups]');
            //$link = $this->linkValues[ 'groups' ];
            //$fieldName = 'accessgroup_id';
            //$this->addLinkColumn( $title, $columnLabel, $link, $fieldName);

        
        // store the page labels
        // NOTE: use this location to update any label tags ...
        // example:
            // $name = $user->getName();
            // $this->labels->setLabelTag( '[Title]', '[userName]', $name);
            
        
        $this->prepareTemplate( $path );
        
        // store the Row Manager's XML Node Name
        $this->template->set( 'rowManagerXMLNodeName', RowManager_StaffActivityManager::XML_NODE_NAME );
        
        // store the primary key field name for the data being displayed
        $this->template->set( 'primaryKeyFieldName', 'staffactivity_id');
        
        // disable the heading?
        $this->template->set( 'disableHeading', $this->disableHeading ); 

        
        // Set page sub-heading (i.e. activity type filter)
        if ($this->activityTypeID != '')
        {
	        $activityTypes = new RowManager_ActivityTypeManager($this->activityTypeID);
	        $sub_heading = $activityTypes->getActivityTypeDesc();
	        
 		  		$this->template->set( 'subheading', $sub_heading);
	  	  }

        /*
         *  Set up any additional data transfer to the Template here...
         */
         $person_manager = new RowManager_PersonManager();
         $person_list = $person_manager->getListIterator();
         $person_manager->setLabelTemplateLastNameFirstName();        
         $personArray = $person_list ->getDropListArray();    
          
         $this->template->set( 'list_person_id', $personArray );
         
         $eventtypes_manager = new RowManager_ActivityTypeManager();
         $types_list = $eventtypes_manager->getListIterator();        
         $typesArray = $types_list ->getDropListArray();             
         
         $this->template->set( 'list_activitytype_id', $typesArray );
        
   
        $templateName = 'siteDataList.php';
		// if you are creating a custom template for this page then 
		// replace $templateName with the following:
		//$templateName = 'page_ViewStaffActivities.php';
		
		return $this->template->fetch( $templateName );
        
    }
    
    
        // self-explanatory: system user == potential approval-qualified staff director
    protected function getStaffIDfromViewerID()
    {
	    $staffViewer = new MultiTableManager();
	    
       $accessPriv = new RowManager_AccessManager();
       $accessPriv->setViewerID($this->viewer->getID());      
       $staff = new RowManager_StaffManager();
       
       $staffViewer->addRowManager($staff);
       $staffViewer->addRowManager($accessPriv, new JoinPair($staff->getJoinOnPersonID(), $accessPriv->getJoinOnPersonID()));
       
       $staffViewerList = $staffViewer->getListIterator();
       $staffViewerArray = $staffViewerList->getDataList();
       
       $staffID = '';
       reset($staffViewerArray);
       foreach (array_keys($staffViewerArray) as $k)
       {
       	$record = current($staffViewerArray);
       	$staffID = $record['staff_id'];	// can only be 1 staff_id per viewer_id
       	next($staffViewerArray);
    	 }
       
       return $staffID;
    }       
}

?>