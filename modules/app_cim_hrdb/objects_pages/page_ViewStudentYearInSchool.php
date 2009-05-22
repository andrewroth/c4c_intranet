<?php
/**
 * @package cim_hrdb
 */ 
/**
 * class page_ViewStudentYearInSchool 
 * <pre> 
 * This is a page that uses the cim_hrdb_person_year table to generate a people list.
 * </pre>
 * @author CIM Team
 * Date:   16 Jan 2008
 */
class  page_ViewStudentYearInSchool extends PageDisplay_DisplayList {

	//CONSTANTS:
	const UNASSIGNED = "Unspecified";
	
	/** The list of fields to be displayed */
    const DISPLAY_FIELDS = 'person_lname,person_fname,campus_shortDesc';//,viewer_userID';
    
    /** The Multilingual Page Key for labels on this page */
    const MULTILINGUAL_PAGE_KEY = 'page_ViewStudentYearInSchool';
    
    const DISPLAY_ALL_ID = -1;

	//VARIABLES:
	
	/** @var [OBJECT] The viewer object. */
	protected $viewer;

	/** @var [OBJECT] The campus id. */
	protected $campus_id;
	
	/** @var [OBJECT] The year id. */
	protected $year_id;

    /** @var [STRING] The path to this module's root directory. */
	protected $pathModuleRoot;
	
	protected $adminManager;
	protected $yearValueList;
	protected $yearValues;
	
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
    function __construct($pathModuleRoot, $viewer, $sortBy, $year_id="", $campus_id="" )
    {
        parent::__construct( page_ViewStudentYearInSchool::DISPLAY_FIELDS );
        
        $this->pathModuleRoot = $pathModuleRoot;
        $this->viewer = $viewer;
        $this->year_id = $year_id; 
        $this->campus_id = $campus_id;
        // echo 'campusID['.$this->campus_id.']<br/>';
                
//        $this->managerInit = $managerInit;

        
        // Now load the access Priviledge manager of this viewer
        $this->adminManager = new RowManager_AdminManager( );

        // Get the person ID
        $accessManager = new RowManager_AccessManager( );
        $accessManager->loadByViewerID( $this->viewer->getViewerID( ) );
        $personID = $accessManager->getPersonID();

        // Get the permissions the person has.
        $this->adminManager->loadByPersonID( $personID );
        
        // need to filter displayed data by campus associated with campus admin
        $campusAdminSearchCondition = '';
        

        if ( $this->adminManager->hasSitePriv()  )
        {
            $campusManager = new RowManager_CampusManager( );
            $campusManager->setSortOrder('campus_desc');
            $this->campusList = $campusManager->getListIterator( );
            $this->accessibleCampuses = $this->campusList->getDropListArray();
        }        
        else if ( $this->adminManager->hasCampusPriv()  )
        {	     
            $campusAdminManager = new RowManager_CampusAdminManager();
            $adminID = $this->adminManager->getID();
            // echo 'adminID['.$adminID.']<br/>';
            $campusAdminManager->setAdminID( $adminID );
           
            $campusList = $campusAdminManager->getListIterator();	//$multiTableManager->getListIterator();
            $campusArray = $campusList->getDataList();
            
            $campusIDsList = "";		// init the CSV of campus IDs associated with admin
            reset($campusArray);
            foreach( array_keys($campusArray) as $k)
            {
	            $record = current($campusArray);
	            $campusIDsList .= $record['campus_id'].',';	// create list of admin campuses
	            next($campusArray);
            }
            $campusIDsList = substr($campusIDsList,0,-1);	// remove last comma
	        
	        $campusAdminSearchCondition = 'cim_hrdb_assignment.campus_id in ('.$campusIDsList.')';
        		
     	  } 
        else if ( $this->adminManager->isStaff($viewer->getID()) )
        {  
            $staffManager = new RowManager_StaffManager();
            $staffManager->setPersonID( $personID );
            
            $multiTableManager = new MultiTableManager();
            $multiTableManager->addRowManager($staffManager);
            $multiTableManager->setSortOrder('campus_desc');
            
            $assignmentManager = new RowManager_AssignmentsManager();
            $multiTableManager->addRowManager( $assignmentManager, new JoinPair( $assignmentManager->getJoinOnPersonID(), $staffManager->getJoinOnPersonID() ) );
            
            $campusManager = new RowManager_CampusManager();
            $multiTableManager->addRowManager( $campusManager, new JoinPair( $campusManager->getJoinOnCampusID(), $assignmentManager->getJoinOnCampusID() ) );
            
            $this->campusList = $multiTableManager->getListIterator();
            
            $campusIDsList = "";		// init the CSV of campus IDs associated with admin
            $this->campusList->setFirst();
            while( $this->campusList->moveNext() )
            {
                $campusAssignObject = $this->campusList->getCurrent(new RowManager_AssignmentsManager());
                $campusObject = $this->campusList->getCurrent(new RowManager_CampusManager());
                $campusIDsList .= $campusAssignObject->getCampusID().',';	// create list of admin campuses
            }
            $campusIDsList = substr($campusIDsList,0,-1);	// remove last comma
	        
	         $campusAdminSearchCondition = 'cim_hrdb_assignment.campus_id in ('.$campusIDsList.')';    
  		  }       	         

     
         $yearManager = new RowManager_YearInSchoolManager( );
         $yearManager->setSortOrder('year_id');
         $this->yearValueList = $yearManager->getListIterator( );

			$this->yearValues = $this->yearValueList->getDropListArray();
			
			// Add value to drop-list for showing person data for people not having person_year record
			$keys = array_keys($this->yearValues);
			$this->UNASSIGNED_IDX = $keys[count($this->yearValues)-1]+1;		// assumes autoincrement is active on table
			$this->yearValues[$this->UNASSIGNED_IDX] = page_ViewStudentYearInSchool::UNASSIGNED;
// 					echo 'values = <pre>'.print_r($this->yearValues, true).'</pre>';

        
        // modify the year_id if necessary
        if ( $this->year_id == page_ViewStudentYearInSchool::DISPLAY_ALL_ID  )
        {
            // setting the year_id to blank will get entries from all the years
            $this->year_id = '';
        }
        else if ( $this->year_id == '' )
        {
            // no campus has been specified
            // choose a default campus if none specified
            // echo 'No campus specified<br/>';
            
            // get the first element from the accessible list
            foreach( $this->yearValues as $key=>$value )
            {
                $this->year_id = $key;
                break;
            }
            
            // assert campus_id should now be something
            if ( $this->year_id == '' )
            {
                die( "ERROR - year_id not set to anything<br/>" );
            }
            
        }
        

        $dataAccessObject = new MultiTableManager();
        
        // Check if regular choice made (i.e. person has some year_in_school record)
        if ($this->year_id != $this->UNASSIGNED_IDX)
        {
	        $personYearManager = new RowManager_PersonYearManager();
	        $personYearManager->setYear($this->year_id);	// SOMEWHAT REDUNDANT GIVEN addSearchCondition (which is required)
	        $dataAccessObject->addRowManager( $personYearManager );
	        
	        $yearManager = new RowManager_YearInSchoolManager();
	        $joinPair = new JoinPair($personYearManager->getJoinOnYearID(), $yearManager->getJoinOnYearID());
	        $dataAccessObject->addRowManager( $yearManager, $joinPair );
	        
	        $personManager = new RowManager_PersonManager();
	        $joinPair1 = new JoinPair($personManager->getJoinOnPersonID(), $personYearManager->getJoinOnPersonID());
	        $dataAccessObject->addRowManager( $personManager, $joinPair1 );        
	
	        $assignmentManager = new RowManager_AssignmentsManager();
	        $joinPair2 = new JoinPair($personYearManager->getJoinOnPersonID(), $assignmentManager->getJoinOnPersonID());
	        $dataAccessObject->addRowManager( $assignmentManager, $joinPair2 );
	
	        $campusManager = new RowManager_CampusManager();
	        $joinPair3 = new JoinPair($assignmentManager->getJoinOnCampusID(), $campusManager->getJoinOnCampusID());
	        $dataAccessObject->addRowManager( $campusManager, $joinPair3 );
	
	        if ($sortBy==''){
	          $sortBy='campus_shortDesc,person_lname';
	        }
	        
	        if ($this->year_id != '')		// If super-admin chooses 'Show All' the year_id will equal ''
	        {
	        		$dataAccessObject->addSearchCondition('cim_hrdb_person_year.year_id = '.$this->year_id);
	     	  }
	        
	        // filter by campuses assigned to this campus admin
			  if ($campusAdminSearchCondition != '')
			  {
			  		$dataAccessObject->addSearchCondition($campusAdminSearchCondition);
		  	  }		           
	        
	        $dataAccessObject->setSortOrder( $sortBy );
	        $this->listManager = $dataAccessObject->getListIterator();
        }
        else 	// deal with case where user wants to see students with no year-in-school assigned
        {
// 	        $personYearManager = new RowManager_PersonYearManager();
// 	        $personYearManager->setYear($this->year_id);	// SOMEWHAT REDUNDANT GIVEN addSearchCondition (which is required)
// 	        $dataAccessObject->addRowManager( $personYearManager );
// 	        
// 	        $yearManager = new RowManager_YearInSchoolManager();
// 	        $joinPair = new JoinPair($personYearManager->getJoinOnYearID(), $yearManager->getJoinOnYearID());
// 	        $dataAccessObject->addRowManager( $yearManager, $joinPair );
	        
	        $personManager = new RowManager_PersonManager();
	        $dataAccessObject->addRowManager( $personManager );        
	
	        $assignmentManager = new RowManager_AssignmentsManager();
	        $joinPair2 = new JoinPair($personManager->getJoinOnPersonID(), $assignmentManager->getJoinOnPersonID());
	        $dataAccessObject->addRowManager( $assignmentManager, $joinPair2 );
	
	        $campusManager = new RowManager_CampusManager();
	        $joinPair3 = new JoinPair($assignmentManager->getJoinOnCampusID(), $campusManager->getJoinOnCampusID());
	        $dataAccessObject->addRowManager( $campusManager, $joinPair3 );
	
	        if ($sortBy==''){
	          $sortBy='campus_shortDesc,person_lname';
	        }
	
	        
	         // get sub-query data for filtering out registrants that have already been registered for event
	         $subManager = new RowManager_PersonYearManager();       
	        	        
	         $personYearManager = new MultiTableManager();
	         $personYearManager->addRowManager($subManager);
	         $personYearManager->setFieldList('person_id');
	         $registered_SQL = $personYearManager->createSQL();
	//          echo "<br>CREATED SQL 1 = ".$registered_SQL;
	      
				// actually creates the sub-query ensuring that registrants listed do NOT have personyear records
				$negateSubQuery = true;
				$addSubQuery = true;
	         $dataAccessObject->constructSubQuery( 'person_id', $registered_SQL, $negateSubQuery, $addSubQuery );
	         
	        // filter by campuses assigned to this campus admin
			  if ($campusAdminSearchCondition != '')
			  {
			  		$dataAccessObject->addSearchCondition($campusAdminSearchCondition);
		  	  }		         			        
	        	        
	        $dataAccessObject->setSortOrder( $sortBy );
	        $this->listManager = $dataAccessObject->getListIterator();
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
         $pageKey = page_ViewStudentYearInSchool::MULTILINGUAL_PAGE_KEY;
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
//         $title = $this->labels->getLabel( '[more_info]');
//         $columnLabel = $this->labels->getLabel( '[view_more_info]');
//         $link = $this->linkValues[ 'viewmoreinfo' ];
//         $fieldName = 'person_id';
//         $this->addLinkColumn( $title, $columnLabel, $link, $fieldName);

//         $title = $this->labels->getLabel( '[campus_assignments]');
//         $columnLabel = $this->labels->getLabel( '[view_campus_assignments]');
//         $link = $this->linkValues[ 'campuses' ];
//         $fieldName = 'person_id';
//         $this->addLinkColumn( $title, $columnLabel, $link, $fieldName);

        
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
        $this->template->set( 'primaryKeyFieldName', 'person_id');


        /*
         *  Set up any additional data transfer to the Template here...
         */

        // now add the data for the Campus Group JumpList
        $jumpLink = $this->linkValues['jumpLink'];
        $jumpList = array();
        if ( $this->adminManager->hasSitePriv() )
        {
            $jumpList[ $jumpLink.page_ViewStudentYearInSchool::DISPLAY_ALL_ID ] = 'Show All';
        }
        foreach( $this->yearValues as $key=>$value) {
            $jumpList[ $jumpLink.$key ] = $value;
        }
        $this->template->set( 'jumpList', $jumpList  );
        // echo '<pre>'.print_r($jumpList,true).'</pre>';
        // echo 'jumpLink['.$jumpLink.']<br/>';
        $this->template->set( 'defaultYear', $jumpLink.$this->year_id );


        $templateName = 'page_ViewStudentYearInSchool.tpl.php';
		// if you are creating a custom template for this page then 
		// replace $templateName with the following:
		//$templateName = 'page_PeoplebyCampuses.php';
		
		return $this->template->fetch( $templateName );
        
    }
    
    
}

?>