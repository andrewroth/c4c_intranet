<?php
/**
 * @package cim_hrdb
 */ 
/**
 * class page_FormApprovalListing 
 * <pre> 
 * Lists the names of people and whether they are approved for a particular HRDB form.
 * </pre>
 * @author CIM Team
 * Date:   27 Feb 2008
 */
class  page_FormApprovalListing extends PageDisplay_DisplayList {

	//CONSTANTS:
	
	/** The list of fields to be displayed */
    const DISPLAY_FIELDS = 'person_id,staffschedule_approved';
    
    /** The Multilingual Page Key for labels on this page */
    const MULTILINGUAL_PAGE_KEY = 'page_FormApprovalListing';
    
    /** Constant indicating viewer is not a staff or super-admin => show no data **/
    const UNAUTHORIZED_DIRECTOR = -2;
    
    /** Constant indicating viewer has no underlings => show no data **/
    const NO_SUPERVISEES = -3;    

	//VARIABLES:
	
	/** @var [OBJECT] The viewer object. */
	protected $viewer;
	
    /** @var [STRING] The path to this module's root directory. */
	protected $pathModuleRoot;
	
	/** @var [STRING] Data sorting parameter passed around */
	protected $sortBy;			
	
	/** @var [INTEGER] The initilization value for the listManager. */
	protected $formtype_id;

	/** @var [OBJECT] The admin data access object. */
	protected $adminManager;			
	
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
    function __construct($pathModuleRoot, $viewer, $sortBy, $staffscheduletype_id ) 
    {
        parent::__construct( page_FormApprovalListing::DISPLAY_FIELDS );
        
        $this->pathModuleRoot = $pathModuleRoot;
        $this->viewer = $viewer;
        $this->formtype_id = $staffscheduletype_id;
                
        $this->sortBy = $sortBy;
        if ($this->sortBy == '')
        {
	        $this->sortBy = 'staffschedule_approved,person_lname,person_fname';
        }
        else if ($this->sortBy == 'person_id')
        {
	        $this->sortBy = 'person_lname,person_fname';
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
	        $dataAccessObject = new MultiTableManager();
	        $schedules = new RowManager_StaffScheduleManager();
	        $schedules->setFormID($this->formtype_id);
	        $persons = new RowManager_PersonManager();
	        $dataAccessObject->addRowManager($schedules);
	        $dataAccessObject->addRowManager($persons, new JoinPair($schedules->getJoinOnPersonID(), $persons->getJoinOnPersonID()));
	        $dataAccessObject->setSortOrder($this->sortBy);
	//        $this->listManager = new StaffScheduleList( $sortBy );
	        $this->listManager = $dataAccessObject->getListIterator();
        }        
//         else if ( $this->adminManager->hasCampusPriv()  )		// Campus-admin
//         {
//         }
        else if ( $this->adminManager->isStaff($viewer->getID()) )	// Staff
        {    
	        $director_id = $this->getStaffIDfromViewerID();
	        
	        $staffManager = new RowManager_StaffDirectorManager();
	        $staffManager->setDirectorID($director_id);

	        
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
	          $directed_staff = substr( $directed_staff, 0, -1 );
           }    
           else 	// Stop any sub-query errors or accidental loosing of control
           {
	          $directed_staff = page_FormApprovalListing::NO_SUPERVISEES;
           }    	             

// 	        // Filter approval records by those staff persons found in the list of staff under the direction of the current viewer
	        $schedules = new RowManager_StaffScheduleManager();
	        $schedules->setFormID($this->formtype_id);
	        $person_info = new RowManager_PersonManager();
	        $staff = new RowManager_StaffManager();

	        
	        $dataAccessObject = new MultiTableManager();
	        $dataAccessObject->addRowManager($staff);
	        $dataAccessObject->addRowManager($person_info, new JoinPair($staff->getJoinOnPersonID(), $person_info->getJoinOnPersonID()));
	        $dataAccessObject->addRowManager($schedules, new JoinPair($person_info->getJoinOnPersonID(), $schedules->getJoinOnPersonID()));	        		        
	        $dataAccessObject->addSearchCondition('staff_id in ('.$directed_staff.')');
	        $dataAccessObject->setSortOrder( $this->sortBy );
	        $this->listManager = $dataAccessObject->getListIterator();        
  		  }
  		  else {
	  		  $dataAccessObject = new MultiTableManager();
	        $schedules = new RowManager_StaffScheduleManager();
	        $schedules->setFormID(page_FormApprovalListing::UNAUTHORIZED_DIRECTOR);
	        $dataAccessObject->addRowManager($schedules);
	        $dataAccessObject->setSortOrder( $this->sortBy );
	//        $this->listManager = new StaffScheduleList( $sortBy );
	        $this->listManager = $dataAccessObject->getListIterator();
        }	  		  


         
         // now initialize the labels for this page
         // start by loading the default field labels for this Module
         $languageID = $viewer->getLanguageID();
         $seriesKey = modulecim_hrdb::MULTILINGUAL_SERIES_KEY;
         $pageKey = modulecim_hrdb::MULTILINGUAL_PAGE_FIELDS;
         $this->labels = new MultilingualManager( $languageID, $seriesKey, $pageKey );
         
         // then load the page specific labels for this page
         $pageKey = page_FormApprovalListing::MULTILINGUAL_PAGE_KEY;
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
         $title = $this->labels->getLabel( '[Access]');
         $columnLabel = $this->labels->getLabel( '[View]');
         $link = $this->linkValues[ 'view' ];
         $fieldName = 'staffschedule_id';
         $this->addLinkColumn( $title, $columnLabel, $link, $fieldName);

        
        // store the page labels
        // NOTE: use this location to update any label tags ...
        // example:
            // $name = $user->getName();
            // $this->labels->setLabelTag( '[Title]', '[userName]', $name);
            
        
        $this->prepareTemplate( $path );
        
        // store the Row Manager's XML Node Name
        $this->template->set( 'rowManagerXMLNodeName', MultiTableManager::XML_NODE_NAME );	//RowManager_StaffScheduleManager
        
        // store the primary key field name for the data being displayed
        $this->template->set( 'primaryKeyFieldName', 'staffschedule_id');
        
         // Get the real form name and add to page as sub-heading
        $form_name = '';
        if ($this->formtype_id != '')
        {
	        $formContext = new RowManager_StaffScheduleTypeManager($this->formtype_id);
        	  $form_name = $formContext->getFormName();
     	  }        
        $this->template->set( 'subheading', $form_name);


        /*
         *  Set up any additional data transfer to the Template here...
         */
                 //TODO: replace this with a reference to a multi_lingual label constant array...
        $boolArray = array();
        $boolArray['0'] = 'no';
        $boolArray['1'] = 'yes';
        
        $this->template->set( 'list_staffschedule_approved', $boolArray ); 
        
        $personManager = new RowManager_PersonManager( );
        $personManager->setSortOrder('person_lname');
        $personManager->setLabelTemplateLastNameFirstName();
        $personList = $personManager->getListIterator( );
        $personArray = $personList->getDropListArray( );
        $this->template->set( 'list_person_id', $personArray );        
        
   
        $templateName = 'siteDataList.php';
		// if you are creating a custom template for this page then 
		// replace $templateName with the following:
		//$templateName = 'page_FormApprovalListing.php';
		
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