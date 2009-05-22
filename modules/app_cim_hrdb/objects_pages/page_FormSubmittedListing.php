<?php
/**
 * @package cim_hrdb
 */ 
/**
 * class page_FormSubmittedListing 
 * <pre> 
 * Lists the names of people and whether they have submitted a particular HRDB form.
 * </pre>
 * @author CIM Team
 * Date:   25 Mar 2008
 */
class  page_FormSubmittedListing extends PageDisplay_DisplayList {

	//CONSTANTS:
	
	/** Use this constant to ensure that listing must be filtered by some form type **/
	const MISSING_FORMTYPE = '-2';
	
	/** The list of fields to be displayed */
    const DISPLAY_FIELDS = 'person_id,staffscheduletype_id,person_email';		// 'is_missing', 'person_link'
    
    /** The Multilingual Page Key for labels on this page */
    const MULTILINGUAL_PAGE_KEY = 'page_FormSubmittedListing';
    
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
    function __construct($pathModuleRoot, $viewer, $sortBy, $staffscheduletype_id = page_FormSubmittedListing::MISSING_FORMTYPE) 
    {
        parent::__construct( page_FormSubmittedListing::DISPLAY_FIELDS );
        
        $this->pathModuleRoot = $pathModuleRoot;
        $this->sortBy = $sortBy;
        $this->viewer = $viewer;
        
        if ($staffscheduletype_id == '')
        {
	        $this->formtype_id = page_FormSubmittedListing::MISSING_FORMTYPE;
        }
        else 
        {
       	  $this->formtype_id = $staffscheduletype_id;
    	  }
        
                
        if ($this->sortBy == '')
        {
	        $this->sortBy = 'staffscheduletype_id,person_lname';
        }
        else if ($this->sortBy == 'person_id')
        {
	        $this->sortBy = 'person_lname';
        }


        // Now load the access Privilege manager of this viewer
        $this->adminManager = new RowManager_AdminManager( );

        // Get the person ID
        $accessManager = new RowManager_AccessManager( );
        $accessManager->loadByViewerID( $this->viewer->getViewerID( ) );
        $personID = $accessManager->getPersonID();

        // Get the permissions the person has.
        $this->adminManager->loadByPersonID( $personID );

        // Do **NOT** allow anything to be shown if no filter set			(REMOVE IF "VIEW-ALL" REQUIRED)
        if ( $this->formtype_id == page_FormSubmittedListing::MISSING_FORMTYPE )
        {
	        $dataAccessObject = new RowManager_StaffScheduleManager();
	        $dataAccessObject->setFormID(page_FormSubmittedListing::MISSING_FORMTYPE);
// 	        $dataAccessObject->setSortOrder( $this->sortBy );
	//        $this->listManager = new StaffScheduleList( $sortBy );
	        $this->listManager = $dataAccessObject->getListIterator();
        }	        
        else if ( $this->adminManager->hasSitePriv()  )	// Super-admin
        {	        
	        $staff = new RowManager_StaffManager();
	        $person_info = new RowManager_PersonManager();
	        $staff_forms = new RowManager_StaffScheduleManager();
	        $staff_forms->setFormID($this->formtype_id);
	        
	     	  // Create sub-query: returns person_ids that are not associated with the form type
	     	  $forms = new RowManager_StaffScheduleManager();
	     	  $forms->setFormID($this->formtype_id);
	     	  $form_manager = new MultiTableManager();
	     	  $form_manager->addRowManager($forms);
	     	  $form_manager->setFieldList('person_id');		     	  

     	     $staffForm_subQuery = $form_manager->createSQL();
// 			  $formNotSubmitted = MultiTableManager::SQL_OR."cim_hrdb_person.person_id not in (".$staffForm_subQuery.")";		     	  
        
	        $dataAccessObject = new MultiTableManager();
	        $dataAccessObject->addRowManager($staff);
	        $dataAccessObject->addRowManager($person_info, new JoinPair($staff->getJoinOnPersonID(), $person_info->getJoinOnPersonID()));
	        $dataAccessObject->addRowManager($staff_forms, new JoinPair($person_info->getJoinOnPersonID(), $staff_forms->getJoinOnPersonID(), JOIN_TYPE_LEFT));
// 	        $dataAccessObject->addSearchCondition($formNotSubmitted);  	
	        $dataAccessObject->setFieldList('cim_hrdb_staff.person_id,staffscheduletype_id,person_email');    

			  $dataAccessObject->constructSubQuery( 'cim_hrdb_person.person_id', $staffForm_subQuery, true, true, MultiTableManager::SQL_OR );
	        $dataAccessObject->setSortOrder( $this->sortBy );
	        
	        $this->listManager = $dataAccessObject->getListIterator();
// 	        echo 'results: <pre>'.print_r($this->listManager->getDataList(),true).'</pre>';
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
//            if ($directed_staff != '')	// if staff found under director, then simply remove comma
//            {
	          $directed_staff = substr( $directed_staff, 0, -1 );
//            }    
//            else 	// Stop any sub-query errors or accidental loosing of control
//            {
// 	          $directed_staff = page_FormSubmittedListing::NO_SUPERVISEES;
//            } 	        
	        
	        
	        
	        if ($directed_staff == '')
	        {
// 		        $directed_staff = page_FormSubmittedListing::NO_SUPERVISEES;	// don't match any person IDs
		        
		        $dataAccessObject = new RowManager_StaffScheduleManager();
		        $dataAccessObject->setFormID(page_FormSubmittedListing::NO_SUPERVISEES);
// 		        $dataAccessObject->setSortOrder( $this->sortBy );
		//        $this->listManager = new StaffScheduleList( $sortBy );
		        $this->listManager = $dataAccessObject->getListIterator();
	        }
	        else 	/** create two queries and UNION results to get directed people who submitted form and those who haven't **/
	        {	   
		        
		        $staff = new RowManager_StaffManager();
		        $person_info = new RowManager_PersonManager();
		        $staff_forms = new RowManager_StaffScheduleManager();
		        $staff_forms->setFormID($this->formtype_id);		        
		        
		        $dataAccessObject = new MultiTableManager();
		        $dataAccessObject->addRowManager($staff);
		        $dataAccessObject->addRowManager($person_info, new JoinPair($staff->getJoinOnPersonID(), $person_info->getJoinOnPersonID()));
		        $dataAccessObject->addRowManager($staff_forms, new JoinPair($person_info->getJoinOnPersonID(), $staff_forms->getJoinOnPersonID(), JOIN_TYPE_LEFT));	        		        
// 		        $dataAccessObject->addSearchCondition('staff_id in ('.$directed_staff.')');
// 			     $dataAccessObject->constructSubQuery( 'cim_hrdb_person.person_id', $staffForm_subQuery, true, true, MultiTableManager::SQL_OR );
		        $dataAccessObject->setSortOrder( $this->sortBy );
		        		        
		             
		        /** Create query to find directed staff who have submitted the form **/
		        $staff1 = new RowManager_StaffManager();
		        $person_info1 = new RowManager_PersonManager();
		        $staff_forms1 = new RowManager_StaffScheduleManager();
		        $staff_forms1->setFormID($this->formtype_id);
		        
		     	  // Create sub-query: returns person_ids that are not associated with the form type
// 		     	  $forms = new RowManager_StaffScheduleManager();
// 		     	  $forms->setFormID($this->formtype_id);
// 		     	  $form_manager = new MultiTableManager();
// 		     	  $form_manager->addRowManager($forms);
// 		     	  $form_manager->setFieldList('person_id');		     	  
// 	
// 	     	     $staffForm_subQuery = $form_manager->createSQL();
	// 			  $formNotSubmitted = MultiTableManager::SQL_OR."cim_hrdb_person.person_id not in (".$staffForm_subQuery.")";		     	  
	        
		        $formsSubmittedManager = new MultiTableManager();
		        $formsSubmittedManager->addRowManager($staff1);
		        $formsSubmittedManager->addRowManager($person_info1, new JoinPair($staff1->getJoinOnPersonID(), $person_info1->getJoinOnPersonID()));
		        $formsSubmittedManager->addRowManager($staff_forms1, new JoinPair($person_info1->getJoinOnPersonID(), $staff_forms1->getJoinOnPersonID(), JOIN_TYPE_LEFT));
		        $formsSubmittedManager->addSearchCondition('staff_id in ('.$directed_staff.')');
// 				  $dataAccessObject->constructSubQuery( 'cim_hrdb_person.person_id', $staffForm_subQuery, true, true, MultiTableManager::SQL_OR );
// 		        $dataAccessObject->setSortOrder( $this->sortBy );
					$submitted_query = $formsSubmittedManager->createSQL();	        
		        
		        
    			  /** Create query to find directed staff who have NOT submitted the form **/
		        $staff2 = new RowManager_StaffManager();
		        $person_info2 = new RowManager_PersonManager();
		        $staff_forms2 = new RowManager_StaffScheduleManager();
		        
		     	  // Create sub-query: returns person_ids that are not associated with the form type
		     	  $forms = new RowManager_StaffScheduleManager();
		     	  $forms->setFormID($this->formtype_id);
		     	  $form_manager = new MultiTableManager();
		     	  $form_manager->addRowManager($forms);
		     	  $form_manager->setFieldList('person_id');		     	  
	
	     	     $staffForm_subQuery = $form_manager->createSQL();		        
		        
		        
		        $formsUnsubmittedManager = new MultiTableManager();
		        $formsUnsubmittedManager->addRowManager($staff2);
		        $formsUnsubmittedManager->addRowManager($person_info2, new JoinPair($staff2->getJoinOnPersonID(), $person_info2->getJoinOnPersonID()));
		        $formsUnsubmittedManager->addRowManager($staff_forms2, new JoinPair($person_info2->getJoinOnPersonID(), $staff_forms2->getJoinOnPersonID(), JOIN_TYPE_LEFT));
		        $formsUnsubmittedManager->addSearchCondition('staff_id in ('.$directed_staff.')');
 				  $formsUnsubmittedManager->constructSubQuery( 'cim_hrdb_person.person_id', $staffForm_subQuery, true, true, MultiTableManager::SQL_AND );
 				  
 				  $unsubmitted_query = $formsUnsubmittedManager->createSQL();


				  /** Union the two queries together to get the complete yes/no listing of form submissions **/
				  $queries = array();
				  $queries[0] = $submitted_query;
				  $queries[1] = $unsubmitted_query;
// TODO: try this if problems with accented data ==> $dataAccessObject->setFieldList('cim_hrdb_staff.person_id,staffscheduletype_id,person_email');    
				  $dataAccessObject->setUsesQueryUnion(true);
				  $dataAccessObject->setUnionQueries($queries);
// 				  $dataAccessObject->union_find($submitted_query, $unsubmitted_query, $this->sortBy);
			     $this->listManager = $dataAccessObject->getListIterator();			        
		        
		               
// 		        
// 				        /** Use directed staff info to return all directed staff and whether they submitted the specific form **/
// 				        $staff = new RowManager_StaffManager();
// 				        $person_info = new RowManager_PersonManager();
// 				        $staff_forms = new RowManager_StaffScheduleManager();
// 				        $staff_forms->setFormID($this->formtype_id);
// 				        
// 				        // Create sub-query: returns person_ids that are not associated with the form type
// 				        $sub_staff = new RowManager_StaffManager();
// 				        $sub_person = new RowManager_PersonManager();
// 				        $forms = new RowManager_StaffScheduleManager();
// 				        $forms->setFormID($this->formtype_id);		        
// 				        
// 				        $subqueryManager = new MultiTableManager();
// 				        $subqueryManager->addRowManager($sub_staff);
// 				        $subqueryManager->addRowManager($sub_person, new JoinPair($sub_staff->getJoinOnPersonID(), $sub_person->getJoinOnPersonID()));
// 				        $subqueryManager->addRowManager($forms, new JoinPair($sub_person->getJoinOnPersonID(), $forms->getJoinOnPersonID(), JOIN_TYPE_LEFT));	        		        
// 				        $subqueryManager->addSearchCondition('staff_id in ('.$directed_staff.')');
// 				     	  $subqueryManager->setFieldList('cim_hrdb_staffschedule.person_id');	
// 				     	  
// 		       	     $staffForm_subQuery = $subqueryManager->createSQL();	 
// 			        
// 		// 		     	  $forms = new RowManager_StaffScheduleManager();
// 		// 		     	  $forms->setFormID($this->formtype_id);
// 		// 		     	  $form_manager = new MultiTableManager();
// 		// 		     	  $form_manager->addRowManager($forms);
// 		// 		     	  $form_manager->setFieldList('person_id');	
// 		// 		     	  
// 		//        	     $staffForm_subQuery = $form_manager->createSQL();	 
// 				        
// 				        $dataAccessObject = new MultiTableManager();
// 				        $dataAccessObject->addRowManager($staff);
// 				        $dataAccessObject->addRowManager($person_info, new JoinPair($staff->getJoinOnPersonID(), $person_info->getJoinOnPersonID()));
// 				        $dataAccessObject->addRowManager($staff_forms, new JoinPair($person_info->getJoinOnPersonID(), $staff_forms->getJoinOnPersonID(), JOIN_TYPE_LEFT));	        		        
// 				        $dataAccessObject->addSearchCondition('staff_id in ('.$directed_staff.')');
// 					     $dataAccessObject->constructSubQuery( 'cim_hrdb_person.person_id', $staffForm_subQuery, true, true, MultiTableManager::SQL_OR );
// 				        $dataAccessObject->setSortOrder( $this->sortBy );
// 				        $this->listManager = $dataAccessObject->getListIterator();
	        }
  		  }
  		  else {
	        $dataAccessObject = new RowManager_StaffScheduleManager();
	        $dataAccessObject->setFormID(page_FormSubmittedListing::UNAUTHORIZED_DIRECTOR);
// 	        $dataAccessObject->setSortOrder( $this->sortBy );
	//        $this->listManager = new StaffScheduleList( $sortBy );
	        $this->listManager = $dataAccessObject->getListIterator();
        }	  		  

        $this->formLabels = array();

         
         // now initialize the labels for this page
         // start by loading the default field labels for this Module
         $languageID = $viewer->getLanguageID();
         $seriesKey = modulecim_hrdb::MULTILINGUAL_SERIES_KEY;
         $pageKey = modulecim_hrdb::MULTILINGUAL_PAGE_FIELDS;
         $this->labels = new MultilingualManager( $languageID, $seriesKey, $pageKey );
         
         // then load the page specific labels for this page
         $pageKey = page_FormSubmittedListing::MULTILINGUAL_PAGE_KEY;
         $this->labels->loadPageLabels( $pageKey );
         
         $this->labels->setSeriesKey( SITE_LABEL_SERIES_SITE );
         $this->labels->loadPageLabels( SITE_LABEL_PAGE_FORM_LINKS );
  
         // the default label value had to be replaced with 'Form Submitted'
         $this->labels->setLabelTag('[title_staffscheduletype_id]', 'Form Name', 'Form Submitted?');       
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
        // NOTE: (enable below to have links to Edit Person page - only for super-admin)
//          $title = $this->labels->getLabel( '[Access]');
//          $columnLabel = $this->labels->getLabel( '[View]');
//          $link = $this->linkValues[ 'view' ];
//          $fieldName = 'person_id';
//          $this->addLinkColumn( $title, $columnLabel, $link, $fieldName);

        
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
        $formTypeList = new RowManager_StaffScheduleTypeManager();
        $formTypeList_list = $formTypeList->getListIterator();
        $formTypeList_array = $formTypeList_list->getDataList();
        
        // Setup yes/no legend: 'no' for NULL date (user has filled in no form)
        //							  and 'no' if another form filled but not the current one
        $boolArray = array();
        $boolArray[NULL] = 'no';
        foreach( array_keys($formTypeList_array) as $type_id ) {
        		$boolArray[$type_id] = 'no';
        		next($formTypeList_array);
     		}
     		$boolArray[$this->formtype_id] = 'yes';
        
        $this->template->set( 'list_staffscheduletype_id', $boolArray ); 
        
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