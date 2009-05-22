<?php
/**
 * @package cim_hrdb
 */ 
 
/**
 * class page_ViewScheduleCalendar
 * <pre> 
 * This is a page that displays activities from cim_hrdb_staffactivity
 * </pre>
 * @author CIM Team
 * Date:   11 Mar 2008
 */
class  page_ViewScheduleCalendar extends PageDisplay_DisplayList {

	//CONSTANTS:
	const SUNDAY = 0;
	const FIRST_MONTH_DATE = 1;
	const MAX_MONTH_DATE = 31;
 	const UNAUTHORIZED_DIRECTOR = -2;
 	const NON_DIRECTOR = -3;
	
	/** The list of fields to be displayed */
    const DISPLAY_FIELDS = '';//person_lname,person_fname,campus_shortDesc
    
    /** The Multilingual Page Key for labels on this page */
    const MULTILINGUAL_PAGE_KEY = 'page_ViewScheduleCalendar';
    
//     const DISPLAY_ALL_ID = -1;

	//VARIABLES:
	
	/** @var [OBJECT] The viewer object. */
	protected $viewer;

	/** @var [OBJECT] The campus id. */
// 	protected $campus_id;
	
	/** @var [OBJECT] The month id, the year_id, and the first weekday id */
 	protected $month_id;
 	protected $year_id;
 	protected $first_weekday; 	
 	
    /** @var [STRING] The path to this module's root directory. */
	protected $pathModuleRoot;
	
	/** @var [OBJECT] The privilege manager */
 	protected $adminManager;
// 	protected $yearValueList;

	/** @var [ARRAY] The months of the year (1-based index) */
	protected $monthValues;		//$yearValues;
	
	/** @var [ARRAY] The data array of the selected month's events: 
		[weekday_id]->[activitytype_id]->[staffactivity_id]->{activity data} */
	protected $monthEvents;	
	
	protected $UNASSIGNED_IDX;	// generate on the fly
	
	/** @var [INTEGER] The initilization value for the listManager. */
//	protected $managerInit;
/* no List Init Variable defined for this DAObj */
		
	
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
    function __construct($pathModuleRoot, $viewer, $sortBy, $month_id = '' )		//, $year_id="", $campus_id="" )
    {
        parent::__construct( page_ViewScheduleCalendar::DISPLAY_FIELDS );
        
        $this->pathModuleRoot = $pathModuleRoot;
        $this->viewer = $viewer;
        if ($month_id == '')
        {
	        $month_id = date('n');
        }
        $this->month_id = $month_id; 
        $this->year_id = date('Y');
        $this->first_weekday = page_ViewScheduleCalendar::SUNDAY;

			$this->monthValues = $this->getMonthValues();	//$this->yearValueList->getDropListArray();


        // Now load the access Privilege manager of this viewer
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
	        $dataAccessObject = new MultiTableManager();
	        $activities = new RowManager_StaffActivityManager();
	        $activityTypes = new RowManager_ActivityTypeManager();
	        $person_info = new RowManager_PersonManager();
	        
	        $dataAccessObject->addRowManager($activities);
	        $dataAccessObject->addRowManager($activityTypes, new JoinPair($activityTypes->getJoinOnActivityTypeID(), $activities->getJoinOnActivityTypeID()));
	        $dataAccessObject->addRowManager($person_info, new JoinPair($person_info->getJoinOnPersonID(), $activities->getJoinOnPersonID()));
	        	        
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
            
	        
// 	        echo '<pre>'.print_r($staffArray,true).'</pre>';
	        
// 	        // Retrieve the list of staff supervised by current viewer
// 	        $directed_staff = '';
// 	        foreach (array_keys($staffArray) as $key)
// 	        {
// 		        $record = current($staffArray);
// 		        $directed_staff .= $record['person_id'].',';
// 		        next($staffArray);
// 	        }
// 	        $directed_staff = substr($directed_staff,0,-1);
// 	        if ($directed_staff == '')
// 	        {
// 		        $directed_staff = page_FormApprovalListing::NO_SUPERVISEES;	// don't match any person IDs
// 	        }

	        // Filter activities by those staff persons found in the list of staff under the direction of the current viewer
	        $dataAccessObject = new MultiTableManager();
	        $schedules = new RowManager_StaffScheduleManager();
// 	        $schedules->addSearchCondition('person_id in ('.$directed_staff.')');
	        $schedule_activities = new RowManager_ActivityScheduleManager();
	        $activities = new RowManager_StaffActivityManager();
	        $activityTypes = new RowManager_ActivityTypeManager();
	        $person_info = new RowManager_PersonManager();
	        $staff = new RowManager_StaffManager();
	        
	        $dataAccessObject->addRowManager($activities);
	        $dataAccessObject->addRowManager($schedule_activities, new JoinPair($activities->getJoinOnActivityID(), $schedule_activities->getJoinOnActivityID()));
	        $dataAccessObject->addRowManager($schedules, new JoinPair($schedules->getJoinOnScheduleID(), $schedule_activities->getJoinOnScheduleID()));
	        $dataAccessObject->addRowManager($activityTypes, new JoinPair($activityTypes->getJoinOnActivityTypeID(), $activities->getJoinOnActivityTypeID()));
	        $dataAccessObject->addRowManager($person_info, new JoinPair($person_info->getJoinOnPersonID(), $activities->getJoinOnPersonID()));
	        $dataAccessObject->addRowManager($staff, new JoinPair($staff->getJoinOnPersonID(), $person_info->getJoinOnPersonID()));
	        $dataAccessObject->addSearchCondition('staff_id in ('.$directed_staff.')');
	        $dataAccessObject->setSortOrder( $sortBy );	        

	        $this->listManager = $dataAccessObject->getListIterator();
  		  }
  		  else {
	  		  
	        $dataAccessObject = new RowManager_StaffActivityManager(page_ViewScheduleCalendar::UNAUTHORIZED_DIRECTOR);
	        
	        $this->listManager = $dataAccessObject->getListIterator();
        }	
                      
		  $this->monthEvents = array();
// 		  $eventsOfType = array();	// stores events/activities of a specific type
// 		  $eventDetails = array();	// stores details for a specific person's event
        $eventsArray = $this->listManager->getDataList();
        reset($eventsArray);
        if (count($eventsArray) > 0)
        {
	        // Search through found activities
	        foreach (array_keys($eventsArray) as $key)
	        {
		        $record = current($eventsArray);
		        		        
		        $activity_id = $record['staffactivity_id'];
		        $activity_desc = $record['activitytype_desc'];
		        $person_name = $record['person_fname'].' '.$record['person_lname'];
		        $contact_phone = $record['staffactivity_contactPhone'];	
		        $activity_type = $record['activitytype_abbr'];
		        
// 		        $eventDetails[$activity_id][0] = $person_name;
// 		        $eventDetails[$activity_id][1] = $contact_phone;
// 		        
// 		        $eventsOfType[$activity_type] = $eventDetails;	        
		        
		        $startdate_parts = explode('-',$record['staffactivity_startdate']);
		        $enddate_parts  = explode('-',$record['staffactivity_enddate']);
		        
		        // Store event information by weekday
		        for ($month_id=$startdate_parts[1]; $month_id <= $enddate_parts[1]; $month_id++)
		        {
			        if ($this->month_id == $month_id)
			        {
				        $start_day = $startdate_parts[2];
				        if (substr($start_day,0,1)==0)	// determine if date is supposed to be single digit
				        {
					        $start_day = substr($start_day,1);
				        }
				        $end_day = $enddate_parts[2];
				        if (substr($end_day,0,1)==0)	// determine if date is supposed to be single digit
				        {
					        $end_day = substr($end_day,1);
				        }		
				        
				        // Store the event data (name and contact #) for each valid day of the month	
				        $init_day = 	page_ViewScheduleCalendar::FIRST_MONTH_DATE;
				        $last_day = page_ViewScheduleCalendar::MAX_MONTH_DATE;
				        if ($startdate_parts[1] == ($enddate_parts[1]))	// easy to deal with if start & end month are the same
				        {     				        
								$init_day = $start_day;
								$last_day = $end_day;
				        }
				        else if ($month_id == $startdate_parts[1])	// deal with case where start and end month are different and we are in start month
				        {					       
								$init_day = $start_day;
								$last_day = page_ViewScheduleCalendar::MAX_MONTH_DATE;
				        }	
				        else if ($month_id == $enddate_parts[1])	// deal with case where start and end month are different and we are in end month
				        {					         
								$init_day = page_ViewScheduleCalendar::FIRST_MONTH_DATE;
								$last_day = $end_day;
				        }		
				        else 	// deal with case where start and end month are different and we are in neither
				        {

					        $init_day = 	page_ViewScheduleCalendar::FIRST_MONTH_DATE;
					        $last_day = page_ViewScheduleCalendar::MAX_MONTH_DATE;
				        }
				        
				        // Use the init and last day values as set based on above conditions
			        	  for ($day_id=$init_day; $day_id <= $last_day; $day_id++)
				        {
					        $this->monthEvents[$day_id][$activity_type][$activity_id][0] = $activity_desc;
					        $this->monthEvents[$day_id][$activity_type][$activity_id][1] = $person_name;
					        $this->monthEvents[$day_id][$activity_type][$activity_id][2] = $contact_phone;
					        //$this->monthEvents[$day_id] = $eventsOfType;
				        }				        			        
				        				        
			        }
		        }
		        next($eventsArray);
	        }
        }
       
        
        /** TEST **/
//         $values = $this->listManager->getDataList();
//         echo 'values found = <pre>'.print_r($values,true).'</pre>';
		 /** END TEST **/
         
         // now initialize the labels for this page
         // start by loading the default field labels for this Module
         $languageID = $viewer->getLanguageID();
         $seriesKey = modulecim_hrdb::MULTILINGUAL_SERIES_KEY;
         $pageKey = modulecim_hrdb::MULTILINGUAL_PAGE_FIELDS;
         $this->labels = new MultilingualManager( $languageID, $seriesKey, $pageKey );
         
         // then load the page specific labels for this page
         $pageKey = page_ViewScheduleCalendar::MULTILINGUAL_PAGE_KEY;
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
        //$path = SITE_PATH_TEMPLATES;
        $path = $this->pathModuleRoot.'templates/';
        // Replace $path with the following line if you want to create a
        // template tailored for this page:
        //$path = $this->pathModuleRoot.'templates/';
        
        
        // store the link values
        // $this->linkValues[ 'view' ] = 'add/new/href/data/here';

        
        // store the link labels
//         $this->linkLabels[ 'add' ] = $this->labels->getLabel( '[Add]' );
//         $this->linkLabels[ 'edit' ] = $this->labels->getLabel( '[Edit]' );
//         $this->linkLabels[ 'del'  ] = $this->labels->getLabel( '[Delete]' );
//         $this->linkLabels[ 'cont' ] = $this->labels->getLabel( '[Continue]');
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
        // $this->template->set( 'rowManagerXMLNodeName', RowManager_AssignmentsManager::XML_NODE_NAME );
        $this->template->set( 'rowManagerXMLNodeName', $this->listManager->getRowManagerXMLNodeName() );
        
        
        
        // store the primary key field name for the data being displayed
        $this->template->set( 'primaryKeyFieldName', 'staffactivity_id');

        // Set calendar variables
 		  $this->template->set('year_id', $this->year_id);       
		  $this->template->set('month_id', $this->month_id);
		  $this->template->set('first_weekday', $this->first_weekday);		  
        $this->template->set('monthEventDataList', $this->monthEvents);	
        
//         	    echo '<pre>'.print_r($this->monthEvents,true).'</pre>';
	
        
        $activityTypeColors = new RowManager_ActivityTypeManager();
        $typeList = $activityTypeColors->getListIterator();
        $typeArray = $typeList->getDataList();
        
        $eventTypeColorArray = array();
        reset($typeArray);
        foreach (array_keys($typeArray) as $key)
        {
	        $record = current($typeArray);	        
	        $eventTypeColorArray[$record['activitytype_abbr']] = $record['activitytype_color'];
	        next($typeArray);
        }
	     $this->template->set('colorCodeList', $eventTypeColorArray);		   
        
        /*
         *  Set up any additional data transfer to the Template here...
         */

        // now add the data for the Campus Group JumpList
        $jumpLink = $this->linkValues['jumpLink'];
        $jumpList = array();
//         if ( $this->adminManager->hasSitePriv() )
//         {
//             $jumpList[ $jumpLink.page_ViewStudentYearInSchool::DISPLAY_ALL_ID ] = 'Show All';
//         }
        foreach( $this->monthValues as $key=>$value) {
            $jumpList[ $jumpLink.$key ] = $value;
        }
        $this->template->set( 'jumpList', $jumpList  );
        // echo '<pre>'.print_r($jumpList,true).'</pre>';
        // echo 'jumpLink['.$jumpLink.']<br/>';
        $this->template->set( 'defaultMonth', $jumpLink.$this->month_id );


        $templateName = 'page_ViewScheduleCalendar.tpl.php';
		// if you are creating a custom template for this page then 
		// replace $templateName with the following:
		//$templateName = 'page_PeoplebyCampuses.php';
		
		return $this->template->fetch( $templateName );
        
    }
    
    
    // Simple method returning array of month values
    protected function getMonthValues()
    {
	    $month = array();
	    $month[1] = 'January';
	    $month[2] = 'February';
	    $month[3] = 'March';
	    $month[4] = 'April';
	    $month[5] = 'May';
	    $month[6] = 'June';
	    $month[7] = 'July';
	    $month[8] = 'August';
	    $month[9] = 'September';
	    $month[10] = 'October';
	    $month[11] = 'November';
	    $month[12] = 'December';	    
	    
	    return $month;
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
	 
	protected function getCellData($data='')
	{
		$LINES = 4;
	
		$firstline = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br>';
		$line = '<br>';
		
		$cell = $firstline;
		
		if ($data!='')
		{
			$cell .= $data;
		}
		else {
			for ($i=1; $i < 4; $i++)
			{
				$cell .= $line;
			}			
		}
		return $cell;
	}	   
}

?>