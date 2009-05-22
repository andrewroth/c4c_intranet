<?php
/**
 * @package cim_hrdb
 */ 
/**
 * class page_PeoplebyCampuses 
 * <pre> 
 * This is a page that uses the assignments table to generate a people list.
 * </pre>
 * @author CIM Team
 * Date:   07 Apr 2006
 */
class  page_PeoplebyCampuses extends PageDisplay_DisplayList {

	//CONSTANTS:
	
	/** The list of fields to be displayed */
    const DISPLAY_FIELDS = 'person_lname,person_fname';//,viewer_userID';
    
    /** The Multilingual Page Key for labels on this page */
    const MULTILINGUAL_PAGE_KEY = 'page_PeoplebyCampuses';
    
    const DISPLAY_ALL_ID = -1;

	//VARIABLES:
	
	/** @var [OBJECT] The viewer object. */
	protected $viewer;

	/** @var [OBJECT] The campus id. */
	protected $campus_id;

    /** @var [STRING] The path to this module's root directory. */
	protected $pathModuleRoot;
	
	protected $adminManager;
	protected $campusList;
	protected $accessibleCampuses;
	
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
    function __construct($pathModuleRoot, $viewer, $sortBy, $campus_id="" )
    {
        parent::__construct( page_PeoplebyCampuses::DISPLAY_FIELDS );
        
        $this->pathModuleRoot = $pathModuleRoot;
        $this->viewer = $viewer;
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
            
            $multiTableManager = new MultiTableManager();
            $multiTableManager->addRowManager($campusAdminManager);
            $multiTableManager->setSortOrder('campus_desc');
            
            $campusManager = new RowManager_CampusManager();
            $multiTableManager->addRowManager( $campusManager, new JoinPair( $campusManager->getJoinOnCampusID(), $campusAdminManager->getJoinOnCampusID() ) );
            
            $this->campusList = $multiTableManager->getListIterator();
            
            $this->accessibleCampuses = array();
            $this->campusList->setFirst();
            while( $this->campusList->moveNext() )
            {
                $campusAdminObject = $this->campusList->getCurrent(new RowManager_CampusAdminManager());
                $campusObject = $this->campusList->getCurrent(new RowManager_CampusManager());
                $this->accessibleCampuses[$campusAdminObject->getCampusID()] = $campusObject->getLabel();
            }

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
            
            $this->accessibleCampuses = array();
            $this->campusList->setFirst();
            while( $this->campusList->moveNext() )
            {
                $campusAssignObject = $this->campusList->getCurrent(new RowManager_AssignmentsManager());
                $campusObject = $this->campusList->getCurrent(new RowManager_CampusManager());
                $this->accessibleCampuses[$campusAssignObject->getCampusID()] = $campusObject->getLabel();
            }
  		  }
        else
        {
            $campusManager = new RowManager_CampusManager( );
            $campusManager->setSortOrder('campus_desc');
            $this->campusList = $campusManager->getListIterator( );
            $this->accessibleCampuses = $this->campusList->getDropListArray();
        }
        
        // modify the campus_id if necessary
        if ( $this->campus_id == page_PeoplebyCampuses::DISPLAY_ALL_ID  )
        {
            // setting the campus id to blank will get entries from all the campuses
            $this->campus_id = '';
        }
        else if ( $this->campus_id == '' )
        {
            // no campus has been specified
            // choose a default campus if none specified
            // echo 'No campus specified<br/>';
            
            // get the first element from the accessible list
            foreach( $this->accessibleCampuses as $key=>$value )
            {
                $this->campus_id = $key;
                break;
            }
            
            // assert campus_id should now be something
            if ( $this->campus_id == '' )
            {
                die( "ERROR - campusID not set to anything<br/>" );
            }
            
        }
        
        $dataAccessObject = new MultiTableManager();
        
        $assignmentsManager = new RowManager_AssignmentsManager();
        $assignmentsManager->setCampusID($this->campus_id);
        $dataAccessObject->addRowManager( $assignmentsManager );
        
        $personManager = new RowManager_PersonManager();
        $joinPair = new JoinPair($personManager->getJoinOnPersonID(), $assignmentsManager->getJoinOnPersonID());
        $dataAccessObject->addRowManager( $personManager, $joinPair );

        $this->accessManager = new RowManager_AccessManager();
        $joinPair2 = new JoinPair($personManager->getJoinOnPersonID(), $this->accessManager->getJoinOnPersonID(), JOIN_TYPE_LEFT);
        $dataAccessObject->addRowManager( $this->accessManager, $joinPair2 );

        $this->viewerManager = new RowManager_UserManager();
        $joinPair3 = new JoinPair($this->accessManager->getJoinOnViewerID(), $this->viewerManager->getJoinOnViewerID(), JOIN_TYPE_LEFT);
        $dataAccessObject->addRowManager( $this->viewerManager, $joinPair3 );

        if ($sortBy==''){
          $sortBy='person_lname';
        }
        
        $dataAccessObject->setSortOrder( $sortBy );
        $this->listManager = $dataAccessObject->getListIterator();
         
         // now initialize the labels for this page
         // start by loading the default field labels for this Module
         $languageID = $viewer->getLanguageID();
         $seriesKey = modulecim_hrdb::MULTILINGUAL_SERIES_KEY;
         $pageKey = modulecim_hrdb::MULTILINGUAL_PAGE_FIELDS;
         $this->labels = new MultilingualManager( $languageID, $seriesKey, $pageKey );
         
         // then load the page specific labels for this page
         $pageKey = page_PeoplebyCampuses::MULTILINGUAL_PAGE_KEY;
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
        $title = $this->labels->getLabel( '[more_info]');
        $columnLabel = $this->labels->getLabel( '[view_more_info]');
        $link = $this->linkValues[ 'viewmoreinfo' ];
        $fieldName = 'person_id';
        $this->addLinkColumn( $title, $columnLabel, $link, $fieldName);

        $title = $this->labels->getLabel( '[campus_assignments]');
        $columnLabel = $this->labels->getLabel( '[view_campus_assignments]');
        $link = $this->linkValues[ 'campuses' ];
        $fieldName = 'person_id';
        $this->addLinkColumn( $title, $columnLabel, $link, $fieldName);

        
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
            $jumpList[ $jumpLink.page_PeoplebyCampuses::DISPLAY_ALL_ID ] = 'Show All';
        }
        foreach( $this->accessibleCampuses as $key=>$value) {
            $jumpList[ $jumpLink.$key ] = $value;
        }
        $this->template->set( 'jumpList', $jumpList  );
        // echo '<pre>'.print_r($jumpList,true).'</pre>';
        // echo 'jumpLink['.$jumpLink.']<br/>';
        $this->template->set( 'defaultCampus', $jumpLink.$this->campus_id );


        $templateName = 'page_PeoplebyCampuses.php';
		// if you are creating a custom template for this page then 
		// replace $templateName with the following:
		//$templateName = 'page_PeoplebyCampuses.php';
		
		return $this->template->fetch( $templateName );
        
    }
    
    /* Simple function to return the set campus id */
    function getCampusID()
    {
	    return $this->campus_id;
    }
}

?>