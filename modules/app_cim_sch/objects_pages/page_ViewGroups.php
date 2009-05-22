<?php
/**
 * @package cim_sch
 */ 
/**
 * class page_ViewGroups 
 * <pre> 
 * Listing of all the groups that someone has access to.
 * </pre>
 * @author Calvin Jien & Russ Martin
 * Date:   03 Apr 2008
 */
class  page_ViewGroups extends PageDisplay_DisplayList {

	//CONSTANTS:
	
	/** The list of fields to be displayed */
    const DISPLAY_FIELDS = 'groupType_id,campus_id,group_name';
    
    /** The Multilingual Page Key for labels on this page */
    const MULTILINGUAL_PAGE_KEY = 'page_ViewGroups';
    

	//VARIABLES:
	
	/** @var [OBJECT] The viewer object. */
	protected $viewer;
	
    /** @var [STRING] The path to this module's root directory. */
	protected $pathModuleRoot;
	
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
    function __construct($pathModuleRoot, $viewer, $sortBy ) 
    {
        parent::__construct( page_ViewGroups::DISPLAY_FIELDS );
        
        $this->pathModuleRoot = $pathModuleRoot;
        $this->viewer = $viewer;
        
        //Get person ID
        $accessManager = new RowManager_AccessManager();
        $accessManager->loadByViewerID( $this->viewer->getViewerID( ) );
        $this->personID = $accessManager->getPersonID();
        
        echo "ViewerID: ".$this->viewer->getViewerID( )." <br>personID: ".$this->personID."<br>";
  
        /*
         * The code below contains the different permission cases for view groups.
         * 
         * Check 1 = check if the user is a SUPER ADMIN
         * Check 2 = check if the user is a STAFF and which campuses he/she is assigned to, taken from HRDB
		 * Check 3 =check cim_sch_permissionCampusAdmin for which CAMPUSES this user is ADMIN for
         * Check 4 = check cim_sch_permissionGroupAdmin for which GROUPS this user is ADMIN for
         * If check 1-4 FAIL then ViewGroup will show nothing. (This user is a normal user and have not created any groups .
         */
  
        $multiTableManager = new MultiTableManager();
        $groupManager = new RowManager_GroupManager();
		$superAdminManager = new RowManager_PermissionsSuperAdminManager();
		
//SUPER ADMIN

		//Check if user's Viewer_id is in the PermissionSuperAdmin table
		if ( $superAdminManager->loadByViewerID( $this->viewer->getViewerID( ) ) )
		{
			// the viewer is a super admin
			echo "ViewerID[".$this->viewer->getViewerID( )."] is a super admin<br/>";
			    
            $campusGroupManager = new RowManager_CampusGroupManager();
            $multiTableManager->addRowManager( $groupManager );
            $multiTableManager->addRowManager( $campusGroupManager, new JoinPair( $campusGroupManager->getJoinOnGroupID(), $groupManager->getJoinOnGroupID(), JOIN_TYPE_LEFT ) );
			     
		}
			
		else
		{
//STAFF          

            // This array stores all the campuses associated to the user.
            //This array is continually populated
            $campusArray = array();

			//check HRDB if the user is a staff
		    $assignmentManager = new RowManager_AssignmentsManager();
		    $assignmentManager->setPersonID( $this->personID );
		    $assignmentManager->setAssignmentStatus( CA_STAFF );
		    $assList = new ListIterator( $assignmentManager );
		    $assList->setFirst();
		    while( $assList->moveNext() )
		    {
		         $assMan = $assList->getCurrent( new RowManager_AssignmentsManager() );
		         
		         //for each campuses found, store in array
		         $campusArray[] = $assMan->getCampusID();
		    }
            
//CAMPUS ADMIN

            //Check cim_sch_permissionsCampusAdmin for the viewer id of the user
            $permissionsCampusAdmin = new RowManager_PermissionsCampusAdminManager();
            $permissionsCampusAdmin->setViewerID($this->viewer->getViewerID( ));
            $campusAdminList = new ListIterator( $permissionsCampusAdmin );
            $campusAdminList->setFirst();
            while( $campusAdminList->moveNext() )
            {
                $permCampus = $campusAdminList->getCurrent( new RowManager_PermissionsCampusAdminManager() );
                
                //for each campuses found, store in array
                $campusArray[] = $permCampus->getCampusID();

            }
            
            //remove any duplicate campus ID in the array
            $campusArray = array_unique($campusArray);
            
//GROUP ADMIN    


 			
            $permissionsGroupAdminManager = new RowManager_PermissionsGroupAdminManager();
            $campusGroupManager = new RowManager_CampusGroupManager();
               
            //send a list of campues and the viewer ID to constrict the search condition
            //The Viewer_id is use to check the cim_sch_permissionsGroupAdmin table for 
            // groups that were created by the user
            $searchCond = $campusGroupManager->returnSearchCondition( $campusArray, $this->viewer->getViewerID( ) );
               
			//create the appropriate join between 3 tables 
			//Join cim_sch_group and cim_sch_permissionsGroupAdmin and cim_sch_campusGroup
            $multiTableManager->addRowManager( $groupManager );
            $multiTableManager->addRowManager( $campusGroupManager, new JoinPair( $campusGroupManager->getJoinOnGroupID(), $groupManager->getJoinOnGroupID(), JOIN_TYPE_LEFT ) );
            $multiTableManager->addRowManager($permissionsGroupAdminManager, new JoinPair ($permissionsGroupAdminManager->getJoinOnGroupID(),$groupManager->getJoinOnGroupID(),JOIN_TYPE_LEFT )); 
            $multiTableManager->addSearchCondition($searchCond); 
		}



		/*Case 3: Group Admin - access to an individual group and can create other group admins 
				(ex. DGL)
				Normal User - can only submit schedule, assume this unless given other permissions
					Check the group admin table 
	
				check cim_sch_permissiongroupadmin -> cim_sch_campusgroup -> cim_sch_group
				filter on viewer id 


		Case 4: All staff - implicit access to all groups on all campuses where their status is staff 
				check cim_hrdb_staff table
					if true
						get all campuses from cim_hrdb_assignment where assignment status id = 3


        */
        /*$groupManager = new RowManager_GroupManager();
        $multiTableManager = new MultiTableManager();
        
        $campusGroupManager = new RowManager_CampusGroupManager();
        
        $multiTableManager->addRowManager( $campusGroupManager );
        $multiTableManager->addRowManager( $groupManager, new JoinPair( $campusGroupManager->getJoinOnGroupID(), $groupManager->getJoinOnGroupID(), JOIN_TYPE_RIGHT ) );*/
        
        // $dataAccessObject = $multiTableManager;
        $multiTableManager->setSortOrder( 'campus_id' ); //******Not sure this is the way to do it*****
//       $this->listManager = new GroupList( $sortBy );
        $this->listManager = $multiTableManager->getListIterator();
         
         // now initialize the labels for this page
         // start by loading the default field labels for this Module
         $languageID = $viewer->getLanguageID();
         $seriesKey = modulecim_sch::MULTILINGUAL_SERIES_KEY;
         $pageKey = modulecim_sch::MULTILINGUAL_PAGE_FIELDS;
         $this->labels = new MultilingualManager( $languageID, $seriesKey, $pageKey );
         
         // then load the page specific labels for this page
         $pageKey = page_ViewGroups::MULTILINGUAL_PAGE_KEY;
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
        // $this->template->set( 'rowManagerXMLNodeName', RowManager_GroupManager::XML_NODE_NAME );
        $this->template->set( 'rowManagerXMLNodeName', MultiTableManager::XML_NODE_NAME );
        
        // store the primary key field name for the data being displayed
        $this->template->set( 'primaryKeyFieldName', 'group_id');


        /*
         *  Set up any additional data transfer to the Template here...
         */
        
        // get a list of the different group types 
        $groupType = new RowManager_GroupTypeManager();
        $groupTypeList = new ListIterator($groupType);	
        $groupArray = $groupTypeList->getDropListArray();
        $this->template->set( 'list_groupType_id', $groupArray );
        // echo "<pre>Group:".print_r($groupArray, true)."</pre>";
        
        // get a list of all campus_ids
        $campus = new RowManager_CampusManager();
        $campus->setSortOrder('campus_desc');
        $campusList = new ListIterator($campus);	
        $campusArray = $campusList->getDropListArray();
         //echo "<pre>Campus:".print_r($campusArray, true)."</pre>";
        $this->template->set( 'list_campus_id', $campusArray );
   
        $templateName = 'siteDataList.php';
		// if you are creating a custom template for this page then 
		// replace $templateName with the following:
		//$templateName = 'page_ViewGroups.php';
		
		return $this->template->fetch( $templateName );
        
    }
    
    
}

?>