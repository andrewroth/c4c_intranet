<?php
/**
 * @package cim_sch
 class modulecim_sch
 discussion <pre>
 Written By	:	Calvin Jien & Russ Martin
 Date		:   25 Mar 2008
 
 Campus for Christ Online Scheduler
 
 </pre>	
*/
class modulecim_sch extends XMLObject_PageContent {
// 		
//
//	CONSTANTS:

        
    /** const MULTILINGUAL_SERIES_KEY The Multilingual Series key for this application.. */
        const MULTILINGUAL_SERIES_KEY = 'modulecim_sch';
        
    /** const MULTILINGUAL_PAGE_FIELDS The Multilingual Page key for the fields of this application. */
        const MULTILINGUAL_PAGE_FIELDS = 'fields_cim_sch';
        
    /** const MODULE_KEY The Module Key for this Module.  Used for access */
        const MODULE_KEY = 'cim_sch';
        
    /** const PAGE    The QueryString Page parameter. */
        const PAGE = "P";
        
    /** const PAGE_SCHEDULERHOME   Display the SchedulerHome Page. */
        const PAGE_SCHEDULERHOME = "P108";

    /** const PAGE_MANAGETIMEZONES   Display the ManageTimeZones Page. */
        const PAGE_MANAGETIMEZONES = "P110";

    /** const PAGE_ADMINGROUPTYPE   Display the AdminGroupType Page. */
        const PAGE_ADMINGROUPTYPE = "P111";

    /** const PAGE_MANAGESUPERADMIN   Display the ManageSuperAdmin Page. */
        const PAGE_MANAGESUPERADMIN = "P112";

    /** const PAGE_MYSCHEDULE   Display the MySchedule Page. */
        const PAGE_MYSCHEDULE = "P114";

    /** const PAGE_MANAGEGROUP   Display the ManageGroup Page. */
        const PAGE_MANAGEGROUP = "P118";

    /** const PAGE_MANAGECAMPUSGROUP   Display the ManageCampusGroup Page. */
        const PAGE_MANAGECAMPUSGROUP = "P119";

    /** const PAGE_VIEWGROUPS   Display the ViewGroups Page. */
        const PAGE_VIEWGROUPS = "P120";

/*[RAD_PAGE_CONST]*/

    /** const SORTBY    The QueryString SortBy parameter. */
        const SORTBY = "modSort";
                

    /*! const CAMPUSGROUP_ID   The QueryString CAMPUSGROUP_ID parameter. */
        const CAMPUSGROUP_ID = "SV81";

    /*! const GROUP_ID   The QueryString GROUP_ID parameter. */
        const GROUP_ID = "SV82";

    /*! const GROUPASSOCATION_ID   The QueryString GROUPASSOCATION_ID parameter. */
        const GROUPASSOCATION_ID = "SV83";

    /*! const GROUPTYPE_ID   The QueryString GROUPTYPE_ID parameter. */
        const GROUPTYPE_ID = "SV84";

    /*! const SCHEDULE_ID   The QueryString SCHEDULE_ID parameter. */
        const SCHEDULE_ID = "SV85";

    /*! const GROUPSCHEDULEBLOCKS_ID   The QueryString GROUPSCHEDULEBLOCKS_ID parameter. */
        const SCHEDULEBLOCKS_ID = "SV86";

    /*! const CAMPUS_ID   The QueryString CAMPUS_ID parameter. */
        const CAMPUS_ID = "SV87";

    /*! const PERSON_ID   The QueryString PERSON_ID parameter. */
        const PERSON_ID = "SV88";

    /*! const TIMEZONES_ID   The QueryString TIMEZONES_ID parameter. */
        const TIMEZONES_ID = "SV89";

    /*! const PERMISSIONSCAMPUSADMIN_ID   The QueryString PERMISSIONSCAMPUSADMIN_ID parameter. */
        const PERMISSIONSCAMPUSADMIN_ID = "SV90";

    /*! const PERMISSIONSGROUPADMIN_ID   The QueryString PERMISSIONSGROUPADMIN_ID parameter. */
        const PERMISSIONSGROUPADMIN_ID = "SV91";

    /*! const PERMISSIONSSUPERADMIN_ID   The QueryString PERMISSIONSSUPERADMIN_ID parameter. */
        const PERMISSIONSSUPERADMIN_ID = "SV92";

    /*! const VIEWER_ID   The QueryString VIEWER_ID parameter. */
        const VIEWER_ID = "SV93";

/*[RAD_PAGE_STATEVAR_CONST]*/
        
        
//
//	VARIABLES:
        
    /** protected $page   [STRING] The current Mode of this Module. */
		protected $page;
		
    /** protected $sortBy [STRING] Parameter to sort displayed Lists. */
        protected $sortBy;
		
    /*! protected $CAMPUSGROUP_ID   [INTEGER] ID of a campus group */
		protected $CAMPUSGROUP_ID;

    /*! protected $GROUP_ID   [INTEGER] ID of a group */
		protected $GROUP_ID;

    /*! protected $GROUPASSOCATION_ID   [INTEGER] ID associated to the relationship of the group and person */
		protected $GROUPASSOCATION_ID;

    /*! protected $GROUPTYPE_ID   [INTEGER] ID of the type of group */
		protected $GROUPTYPE_ID;

    /*! protected $SCHEDULE_ID   [INTEGER] ID of the schedule */
		protected $SCHEDULE_ID;

    /*! protected $SCHEDULEBLOCKS_ID   [INTEGER] ID of the schedule blocks */
		protected $SCHEDULEBLOCKS_ID;

    /*! protected $CAMPUS_ID   [INTEGER] ID of the campus */
		protected $CAMPUS_ID;

    /*! protected $PERSON_ID   [INTEGER] ID of the person */
		protected $PERSON_ID;

    /*! protected $TIMEZONES_ID   [INTEGER] ID of the timezones */
		protected $TIMEZONES_ID;

    /*! protected $PERMISSIONSCAMPUSADMIN_ID   [INTEGER] ID of the Campus admin permissions */
		protected $PERMISSIONSCAMPUSADMIN_ID;

    /*! protected $PERMISSIONSGROUPADMIN_ID   [INTEGER] ID of the group admin permissions */
		protected $PERMISSIONSGROUPADMIN_ID;

    /*! protected $PERMISSIONSSUPERADMIN_ID   [INTEGER] ID of the super admin permissions */
		protected $PERMISSIONSSUPERADMIN_ID;

    /*! protected $VIEWER_ID   [INTEGER] ID of the viewer */
		protected $VIEWER_ID;

/*[RAD_PAGE_STATEVAR_VAR]*/
		
   
    /** protected $pageDisplay [OBJECT] The display object for the page. */
        protected $pageDisplay;
        
    /** protected $pageCommonDisplay [OBJECT] The display object for the common page layout. */
        protected $pageCommonDisplay;
        
    /*! protected $sideBar [OBJECT] The display object for the sideBar. */
        protected $sideBar;

/*[RAD_PAGE_OBJECT_VAR]*/ 		


//
//	CLASS FUNCTIONS:
//

	
	//************************************************************************
	/** 
	 * @function loadData
	 *
	 * @abstract Provided function to allow object to load it's data.
     *
	 */
	function loadData( ) 
	{


/*[RAD_PAGE_STATEVAR_INIT]*/
        
        // Now check to see if a Application ID was given
//        $this->appID = $this->getQSValue( modulecim_sch::APPID, '' );
        
        // load the common page layout object
        $this->pageCommonDisplay = new CommonDisplay( $this->moduleRootPath, $this->pathToRoot, $this->viewer);
         
        // load the module's page (DEFAULT = WELCOME)
        $this->page = $this->getQSValue( modulecim_sch::PAGE, modulecim_sch::PAGE_SCHEDULERHOME );
        
        // load the module's sortBy parameter (DEFAULT = '')
        $this->sortBy = $this->getQSValue( modulecim_sch::SORTBY, '' );
        
        // load the module's CAMPUSGROUP_ID variable
        $this->CAMPUSGROUP_ID = $this->getQSValue( modulecim_sch::CAMPUSGROUP_ID, "" );

        // load the module's GROUP_ID variable
        $this->GROUP_ID = $this->getQSValue( modulecim_sch::GROUP_ID, "" );

        // load the module's GROUPASSOCATION_ID variable
        $this->GROUPASSOCATION_ID = $this->getQSValue( modulecim_sch::GROUPASSOCATION_ID, "" );

        // load the module's GROUPTYPE_ID variable
        $this->GROUPTYPE_ID = $this->getQSValue( modulecim_sch::GROUPTYPE_ID, "" );

        // load the module's SCHEDULE_ID variable
        $this->SCHEDULE_ID = $this->getQSValue( modulecim_sch::SCHEDULE_ID, "" );

        // load the module's SCHEDULEBLOCKS_ID variable
        $this->SCHEDULEBLOCKS_ID = $this->getQSValue( modulecim_sch::SCHEDULEBLOCKS_ID, "" );

        // load the module's CAMPUS_ID variable
        $this->CAMPUS_ID = $this->getQSValue( modulecim_sch::CAMPUS_ID, "" );

        // load the module's PERSON_ID variable
        $this->PERSON_ID = $this->getQSValue( modulecim_sch::PERSON_ID, "" );

        // load the module's TIMEZONES_ID variable
        $this->TIMEZONES_ID = $this->getQSValue( modulecim_sch::TIMEZONES_ID, "" );

        // load the module's PERMISSIONSCAMPUSADMIN_ID variable
        $this->PERMISSIONSCAMPUSADMIN_ID = $this->getQSValue( modulecim_sch::PERMISSIONSCAMPUSADMIN_ID, "" );

        // load the module's PERMISSIONSGROUPADMIN_ID variable
        $this->PERMISSIONSGROUPADMIN_ID = $this->getQSValue( modulecim_sch::PERMISSIONSGROUPADMIN_ID, "" );

        // load the module's PERMISSIONSSUPERADMIN_ID variable
        $this->PERMISSIONSSUPERADMIN_ID = $this->getQSValue( modulecim_sch::PERMISSIONSSUPERADMIN_ID, "" );

        // load the module's VIEWER_ID variable
        $this->VIEWER_ID = $this->getQSValue( modulecim_sch::VIEWER_ID, "" );

/*[RAD_PAGE_LOAD_STATEVAR]*/
        
        switch( $this->page ) {
                
            /*
             *  SchedulerHome
             */
            case modulecim_sch::PAGE_SCHEDULERHOME:
                $this->loadSchedulerHome();
                break;

            /*
             *  ManageTimeZones
             */
            case modulecim_sch::PAGE_MANAGETIMEZONES:
                $this->loadManageTimeZones();
                break;

            /*
             *  AdminGroupType
             */
            case modulecim_sch::PAGE_ADMINGROUPTYPE:
                $this->loadAdminGroupType();
                break;

            /*
             *  ManageSuperAdmin
             */
            case modulecim_sch::PAGE_MANAGESUPERADMIN:
                $this->loadManageSuperAdmin();
                break;

            /*
             *  MySchedule
             */
            case modulecim_sch::PAGE_MYSCHEDULE:
                $this->loadMySchedule();
                break;

            /*
             *  ManageGroup
             */
            case modulecim_sch::PAGE_MANAGEGROUP:
                $this->loadManageGroup();
                break;

            /*
             *  ManageCampusGroup
             */
            case modulecim_sch::PAGE_MANAGECAMPUSGROUP:
                $this->loadManageCampusGroup();
                break;

            /*
             *  ViewGroups
             */
            case modulecim_sch::PAGE_VIEWGROUPS:
                $this->loadViewGroups();
                break;

/*[RAD_PAGE_LOAD_CALL]*/
   
                 
            /*
             *  Just to make sure, default the pageDisplay to 
             *  the SchedulerHome page.
             */
            default:
                $this->page = modulecim_sch::PAGE_SCHEDULERHOME;
                $this->loadSchedulerHome();
                break;
        
        }
        
        /*
         * Load SideBar Information
         */
        $this->loadSideBar();
        
        
        /*
         * Load Form Values if a ProcessData field exists
         */
        if (isset( $_REQUEST[ PerlFileUpload::DEF_QSPARAM_SID ]) ) {
            // perlFileUploads don't retain the Process parameter
            // so we add it here
            $_REQUEST[ 'Process' ]  = 'Y';
        }
        
        if (isset( $_REQUEST[ 'Process' ] ) ) {
        
            $this->pageDisplay->loadFromForm();
        }

	}
	
	
	
	//************************************************************************
	/** 
	 * @function processData
	 *
	 * @abstract Provided function to allow an object to process it's data.
	 *
	 */
	function processData( ) 
	{

        // if this was a form submit ... 
        // NOTE: our forms should have a hidden variable named Process on them.
        if (isset( $_REQUEST[ 'Process' ] ) ) {
        
            // if form data is valid ...
            if ( $this->pageDisplay->isDataValid() ) {
            
                // process the data
                $this->pageDisplay->processData();
            
                // now switch to the proper next page ...
                switch( $this->page ) {
    
                    case modulecim_sch::PAGE_MANAGETIMEZONES:
                        // NOTE: after a successful submit on an AdminBox style
                        // form, set the managerInit variable back to ''
                        $this->TIMEZONES_ID = '';
                        $this->loadManageTimeZones( true );                     
                        break;

                    case modulecim_sch::PAGE_ADMINGROUPTYPE:
                        // NOTE: after a successful submit on an AdminBox style
                        // form, set the managerInit variable back to ''
                        $this->GROUPTYPE_ID = '';
                        $this->loadAdminGroupType( true );                     
                        break;

                    case modulecim_sch::PAGE_MANAGESUPERADMIN:
                        // NOTE: after a successful submit on an AdminBox style
                        // form, set the managerInit variable back to ''
                        $this->PERMISSIONSSUPERADMIN_ID = '';
                        $this->loadManageSuperAdmin( true );                     
                        break;
                        
                    case modulecim_sch::PAGE_MYSCHEDULE:
                        // go back to the home page after a successful submit
                        $this->loadSchedulerHome( true );
                        break;

                    case modulecim_sch::PAGE_MANAGECAMPUSGROUP:
                        // NOTE: after a successful submit on an AdminBox style
                        // form, set the managerInit variable back to ''
                        $this->CAMPUSGROUP_ID = '';
                        $this->loadManageCampusGroup( true );                     
                        break;

                    case modulecim_sch::PAGE_MANAGEGROUP:
                        
                        // get the ID of the newly created/modified group
                        $this->GROUP_ID = $this->pageDisplay->getNewGroupID();
                        // echo "groupID[".$this->GROUP_ID."]<br/>";
                        
                        $newGroupType = $this->pageDisplay->getNewGroupTypeID();
                        // TODO - change this magic number (VERY BAD) RM
                        if ( $newGroupType == 1 )
                        {
                            // a campus group
                            // echo "transition - a campus group<br/>";
                            $this->page = modulecim_sch::PAGE_MANAGECAMPUSGROUP;
                            $this->loadManageCampusGroup(); 
                        }
                        // TODO - change this magic number (VERY BAD) RM
                        else if ( $newGroupType == 2 )
                        {
                            // a public group
                            // echo "transition - a public group<br/>";
                            $this->page = modulecim_sch::PAGE_MANAGECAMPUSGROUP;
                            $this->loadSchedulerHome(); 
                        }
                        else
                        {
                            echo "ERROR - not sure what type of group has been created...<br/>";
                        }
                                              
                        break;

/*[RAD_PAGE_TRANSITION]*/
                        
                 }
            
            } // end if data valid
        
        }  // end if Process

	}
	
	
	
	//************************************************************************
	/** 
	 * @function prepareDisplayData
	 *
	 * @abstract Provided function to allow an object to prepare it's data 
	 * for displaying (actually done in the <code>Page</code> Object).
     *
	 */
	function prepareDisplayData( ) 
	{
        $content = $this->pageDisplay->getHTML();

        // wrap current page's html in the common html of the module
        $content = $this->pageCommonDisplay->getHTML( $content );

        // store HTML content as this page's content Item
        $this->addContent( $content );
        
        // add the sidebar content
        $sideBarContent = $this->sideBar->getHTML();
        $this->addSideBarContent( $sideBarContent );
         
        // Add any necessary javascripts for this page:
        switch( $this->page ) {
        
/*[RAD_PAGE_JAVASCRIPTS]*/
//             case modulecim_sch::PAGE_DEFAULT:
//                $this->addScript('MM_jumpMenu.jsp');
//                break;

        }
        
	}
	
	
	
    //************************************************************************
	/**
	 * function getCallBack
	 *
	 * <pre> Builds the proper HREF link for a desired action. </pre>
	 *
	 *
	 * @param $page [STRING] The Desired PAGE of this Link.
	 * @param $sortBy [STRING] The Desired Sort Field for this link.
	 * @param $parameters [ARRAY] An array of parameterName=>Value pairs 
	 * possible parameter values :
	 * 'CAMPUSGROUP_ID' [INTEGER] The Desired CAMPUSGROUP_ID of this Link.
	 * 'GROUP_ID' [INTEGER] The Desired GROUP_ID of this Link.
	 * 'GROUPASSOCATION_ID' [INTEGER] The Desired GROUPASSOCATION_ID of this Link.
	 * 'GROUPTYPE_ID' [INTEGER] The Desired GROUPTYPE_ID of this Link.
	 * 'SCHEDULE_ID' [INTEGER] The Desired SCHEDULE_ID of this Link.
	 * 'SCHEDULEBLOCKS_ID' [INTEGER] The Desired SCHEDULEBLOCKS_ID of this Link.
	 * 'CAMPUS_ID' [INTEGER] The Desired CAMPUS_ID of this Link.
	 * 'PERSON_ID' [INTEGER] The Desired PERSON_ID of this Link.
	 * 'TIMEZONES_ID' [INTEGER] The Desired TIMEZONES_ID of this Link.
	 * 'PERMISSIONSCAMPUSADMIN_ID' [INTEGER] The Desired PERMISSIONSCAMPUSADMIN_ID of this Link.
	 * 'PERMISSIONSGROUPADMIN_ID' [INTEGER] The Desired PERMISSIONSGROUPADMIN_ID of this Link.
	 * 'PERMISSIONSSUPERADMIN_ID' [INTEGER] The Desired PERMISSIONSSUPERADMIN_ID of this Link.
	 * 'VIEWER_ID' [INTEGER] The Desired VIEWER_ID of this Link.
[RAD_CALLBACK_DOC]
	 * @return [STRING] The Link.
	 */
    function getCallBack($page='', $sortBy='', $parameters='')
    {
        if ( $parameters == '') {
            $parameters = array();
        }
        
        $returnValue = $this->baseCallBack;
        
        $callBack = '';
        
        if ($page != '') {
            $callBack = modulecim_sch::PAGE.'='.$page;
        }
        
        if ($sortBy != '') {
            if ($callBack != '') {
                $callBack .= '&';
            }
            $callBack .= modulecim_sch::SORTBY.'='.$sortBy;
        }
        
        
        if ( isset( $parameters['CAMPUSGROUP_ID']) ) {
            if ( $parameters['CAMPUSGROUP_ID'] != '' ) {
                if ($callBack != '') {
                    $callBack .= '&';
                }
                $callBack .= modulecim_sch::CAMPUSGROUP_ID.'='.$parameters['CAMPUSGROUP_ID'];
            }
        }

        if ( isset( $parameters['GROUP_ID']) ) {
            if ( $parameters['GROUP_ID'] != '' ) {
                if ($callBack != '') {
                    $callBack .= '&';
                }
                $callBack .= modulecim_sch::GROUP_ID.'='.$parameters['GROUP_ID'];
            }
        }

        if ( isset( $parameters['GROUPASSOCATION_ID']) ) {
            if ( $parameters['GROUPASSOCATION_ID'] != '' ) {
                if ($callBack != '') {
                    $callBack .= '&';
                }
                $callBack .= modulecim_sch::GROUPASSOCATION_ID.'='.$parameters['GROUPASSOCATION_ID'];
            }
        }

        if ( isset( $parameters['GROUPTYPE_ID']) ) {
            if ( $parameters['GROUPTYPE_ID'] != '' ) {
                if ($callBack != '') {
                    $callBack .= '&';
                }
                $callBack .= modulecim_sch::GROUPTYPE_ID.'='.$parameters['GROUPTYPE_ID'];
            }
        }

        if ( isset( $parameters['SCHEDULE_ID']) ) {
            if ( $parameters['SCHEDULE_ID'] != '' ) {
                if ($callBack != '') {
                    $callBack .= '&';
                }
                $callBack .= modulecim_sch::SCHEDULE_ID.'='.$parameters['SCHEDULE_ID'];
            }
        }

        if ( isset( $parameters['SCHEDULEBLOCKS_ID']) ) {
            if ( $parameters['SCHEDULEBLOCKS_ID'] != '' ) {
                if ($callBack != '') {
                    $callBack .= '&';
                }
                $callBack .= modulecim_sch::SCHEDULEBLOCKS_ID.'='.$parameters['SCHEDULEBLOCKS_ID'];
            }
        }

        if ( isset( $parameters['CAMPUS_ID']) ) {
            if ( $parameters['CAMPUS_ID'] != '' ) {
                if ($callBack != '') {
                    $callBack .= '&';
                }
                $callBack .= modulecim_sch::CAMPUS_ID.'='.$parameters['CAMPUS_ID'];
            }
        }

        if ( isset( $parameters['PERSON_ID']) ) {
            if ( $parameters['PERSON_ID'] != '' ) {
                if ($callBack != '') {
                    $callBack .= '&';
                }
                $callBack .= modulecim_sch::PERSON_ID.'='.$parameters['PERSON_ID'];
            }
        }

        if ( isset( $parameters['TIMEZONES_ID']) ) {
            if ( $parameters['TIMEZONES_ID'] != '' ) {
                if ($callBack != '') {
                    $callBack .= '&';
                }
                $callBack .= modulecim_sch::TIMEZONES_ID.'='.$parameters['TIMEZONES_ID'];
            }
        }

        if ( isset( $parameters['PERMISSIONSCAMPUSADMIN_ID']) ) {
            if ( $parameters['PERMISSIONSCAMPUSADMIN_ID'] != '' ) {
                if ($callBack != '') {
                    $callBack .= '&';
                }
                $callBack .= modulecim_sch::PERMISSIONSCAMPUSADMIN_ID.'='.$parameters['PERMISSIONSCAMPUSADMIN_ID'];
            }
        }

        if ( isset( $parameters['PERMISSIONSGROUPADMIN_ID']) ) {
            if ( $parameters['PERMISSIONSGROUPADMIN_ID'] != '' ) {
                if ($callBack != '') {
                    $callBack .= '&';
                }
                $callBack .= modulecim_sch::PERMISSIONSGROUPADMIN_ID.'='.$parameters['PERMISSIONSGROUPADMIN_ID'];
            }
        }

        if ( isset( $parameters['PERMISSIONSSUPERADMIN_ID']) ) {
            if ( $parameters['PERMISSIONSSUPERADMIN_ID'] != '' ) {
                if ($callBack != '') {
                    $callBack .= '&';
                }
                $callBack .= modulecim_sch::PERMISSIONSSUPERADMIN_ID.'='.$parameters['PERMISSIONSSUPERADMIN_ID'];
            }
        }

        if ( isset( $parameters['VIEWER_ID']) ) {
            if ( $parameters['VIEWER_ID'] != '' ) {
                if ($callBack != '') {
                    $callBack .= '&';
                }
                $callBack .= modulecim_sch::VIEWER_ID.'='.$parameters['VIEWER_ID'];
            }
        }

/*[RAD_CALLBACK_CODE]*/
        
        if ( $callBack != '') {
            $returnValue .= '&'.$callBack;
        }
        
        return $returnValue;
    }    
    
    
    
    //************************************************************************
	/**
	 * function getMultilingualSeriesKey()
	 *
	 * <pre> Returns the value of the Multilingual Series Key </pre>
	 *
	 * @return [STRING]
	 */
    function getMultilingualSeriesKey() 
    {
        return modulecim_sch::MULTILINGUAL_SERIES_KEY;
    }
    
    //************************************************************************
	/**
	 * function loadSideBar
	 * <pre>
	 * Choosses .
	 * </pre>
	 * @return [void]
	 */
    function loadSideBar() 
    {
        $this->sideBar = new obj_AdminSideBar( $this->moduleRootPath, $this->viewer );    
        
        $links = array();
        $adminLinks = array();
//       $campusLevelLinks = array();

        $parameters = array();
        // TODO make an object to do this work
  /*      $sql = "select * from cim_hrdb_access where viewer_id = ".$this->viewer->getViewerID()." limit 1";

        $db = new Database_Site();
        $db->connectToDB( SITE_DB_NAME, SITE_DB_PATH, SITE_DB_USER, SITE_DB_PWORD );

        $db->runSQL($sql);
        // if row retrieved ...
        $personID = -1;
        if ($row = $db->retrieveRow() )
        {
            $personID = $row['person_id'];
        }
        $parameters['PERSON_ID'] = $personID;

        // echo print_r($parameters,true);
*/
        // GROUP 1: EVERYONE.
        // ALL viewers can access this link
       $requestLink = $this->getCallBack( modulecim_sch::PAGE_SCHEDULERHOME, '' , $parameters);
        $links[ '[SchedulerHome]' ] = $requestLink;
       $requestLink = $this->getCallBack( modulecim_sch::PAGE_MYSCHEDULE, '' , $parameters);
        $links[ '[MySchedule]' ] = $requestLink;
        
        $requestLink = $this->getCallBack( modulecim_sch::PAGE_MANAGEGROUP, '' , $parameters);
        $links[ '[CreateAGroup]' ] = $requestLink;
        
        $requestLink = $this->getCallBack( modulecim_sch::PAGE_VIEWGROUPS, '' , $parameters);
        $links[ '[ViewGroups]' ] = $requestLink;

/*        $requestLink = $this->getCallBack( modulecim_hrdb::PAGE_EDITMYCAMPUSASSIGNMENT, '' , $parameters);
        $links[ '[editMyCampusInfo]' ] = $requestLink;
        
        $requestLink = $this->getCallBack( modulecim_hrdb::PAGE_EDITMYYEARINSCHOOL, '' , $parameters);
        $links[ '[editMyYearInSchool]' ] = $requestLink;
        
        $requestLink = $this->getCallBack( modulecim_hrdb::PAGE_EDITMYEMERGINFO, '' , $parameters);
        $links[ '[editMyEmergInfo]' ] = $requestLink;
*/
  /*              // GROUP 2a: STAFF AND ABOVE ONLY.   (access HRDB forms)
        if (( $this->accessPrivManager->hasSitePriv() ) || ( $this->accessPrivManager->isStaff($this->viewer->getID()) ) ){
        
	        $parameters['FORMLIST_TYPE'] = modulecim_hrdb::FORMLIST_ACCESS;
	         $requestLink = $this->getCallBack( modulecim_hrdb::PAGE_HRDBFORMS, '' , $parameters);
	        $links[ '[editMyForms]' ] = $requestLink;    	 
        }       
        
//         $parameters['FORMLIST_TYPE'] = modulecim_hrdb::FORMLIST_ACCESS;
//          $requestLink = $this->getCallBack( modulecim_hrdb::PAGE_HRDBFORMS, '' , $parameters);
//         $links[ '[editMyForms]' ] = $requestLink;       

        // GROUP 2: CAMPUS ADMINS AND ABOVE ONLY.
        if ( ( $this->accessPrivManager->hasSitePriv() ) || ( $this->accessPrivManager->hasCampusPriv($this->viewer->getID()) ) ){
          //$requestLink = $this->getCallBack( modulecim_hrdb::PAGE_PEOPLE );
          //$campusLevelLinks[ '[PeopleList]' ] = $requestLink;
          // TODO if you have 'hrdb campus' group access rights you can see these
            $requestLink = $this->getCallBack( modulecim_hrdb::PAGE_PEOPLEBYCAMPUSES );
        $campusLevelLinks[ '[PeopleByCampuses]' ] = $requestLink;
            $requestLink = $this->getCallBack( modulecim_hrdb::PAGE_EDITSTUDENTYEARINSCHOOL );
        $campusLevelLinks[ '[CampusStudentsByYear]' ] = $requestLink;    
            $requestLink = $this->getCallBack( modulecim_hrdb::PAGE_VIEWSTUDENTYEARINSCHOOL );
        $campusLevelLinks[ '[NationalStudentsByYear]' ] = $requestLink;  
        
                 
        }  */    
        
 /*               // GROUP 2a: STAFF AND ABOVE ONLY.   (approve HRDB forms)
        if (( $this->accessPrivManager->hasSitePriv() ) || ( $this->accessPrivManager->isStaff($this->viewer->getID()) ) ){
        	 $parameters['FORMLIST_TYPE'] = modulecim_hrdb::FORMLIST_APPROVAL;	// modulecim_hrdb::FORMLIST_APPROVAL as well
	       $requestLink = $this->getCallBack( modulecim_hrdb::PAGE_HRDBFORMS, '' , $parameters);
	       $campusLevelLinks[ '[approveForms]' ] = $requestLink;  
	       
// 	       $requestLink = $this->getCallBack( modulecim_hrdb::PAGE_VIEWSCHEDULECALENDAR, '' , $parameters);
// 	       $campusLevelLinks[ '[viewScheduleCalendar]' ] = $requestLink; 		       
	       
	       $requestLink = $this->getCallBack( modulecim_hrdb::PAGE_HRDBACTIVITIES, '' , $parameters);
	       $campusLevelLinks[ '[viewActivitiesByType]' ] = $requestLink;     
	       
	       $requestLink = $this->getCallBack( modulecim_hrdb::PAGE_VIEWACTIVITIESBYDATE, '' , $parameters);
	       $campusLevelLinks[ '[viewActivitiesByDate]' ] = $requestLink; 

        	 $parameters['FORMLIST_TYPE'] = modulecim_hrdb::FORMLIST_SUBMITTED;     
	       $requestLink = $this->getCallBack( modulecim_hrdb::PAGE_HRDBFORMS, '' , $parameters);
	       $campusLevelLinks[ '[viewStaffMissingForms]' ] = $requestLink;  	       	                 
        }*/

        // GROUP 3: SUPER ADMINS ONLY.
        // only display the following links if a viewer is actually a super admin
        $superAdminManager = new RowManager_PermissionsSuperAdminManager();
        if ( $superAdminManager->loadByViewerID( $this->viewer->getViewerID() ) ) 
        {        
            $requestLink = $this->getCallBack( modulecim_sch::PAGE_MANAGETIMEZONES );
            $adminLinks[ '[ManageTimezones]' ] = $requestLink;     
            
            $requestLink = $this->getCallBack( modulecim_sch::PAGE_ADMINGROUPTYPE );
            $adminLinks[ '[ManageGroupTypes]' ] = $requestLink;    
            
            $requestLink = $this->getCallBack( modulecim_sch::PAGE_MANAGESUPERADMIN );
            $adminLinks[ '[ManageSuperAdmin]' ] = $requestLink;       
        }

        // pass the links to the sidebar object
        $this->sideBar->setLinks( $links );
        $this->sideBar->setAdminLinks( $adminLinks );
        // $this->sideBar->setCampusLevelLinks( $campusLevelLinks );

    } // end loadSideBar()


    
    
    //************************************************************************
	/**
	 * function loadSchedulerHome
	 * <pre>
	 * Initializes the SchedulerHome Page.
	 * </pre>
	 * @return [void]
	 */
    // RAD Tools: Custom style
    function loadSchedulerHome() 
    {
        // set the pageCallBack to be without any additional parameters
        // (an AdminBox needs this so Language Switching on a page doesn't
        // pass a previous operations)
        $parameters = array();//[RAD_CALLBACK_PARAMS]
        $pageCallBack = $this->getCallBack(modulecim_sch::PAGE_SCHEDULERHOME, $this->sortBy, $parameters);
        $this->setPageCallBack( $pageCallBack );
        
        
        $this->pageDisplay = new page_SchedulerHome( $this->moduleRootPath, $this->viewer );   
        
        $links = array();
        
/*[RAD_LINK_INSERT]*/

        $this->pageDisplay->setLinks( $links );     
        
    } // end loadSchedulerHome()



    //************************************************************************
	/**
	 * function loadManageTimeZones
	 * <pre>
	 * Initializes the ManageTimeZones Page.
	 * </pre>
	 * @param $isCreated [BOOL] "Is THIS pageDisplay object already created?"
	 * @return [void]
	 */
    // RAD Tools: AdminBox Style
    function loadManageTimeZones( $isCreated=false ) 
    {
        
        // compile a formAction for the adminBox
        $parameters = array('CAMPUSGROUP_ID'=>$this->CAMPUSGROUP_ID, 'GROUP_ID'=>$this->GROUP_ID, 'GROUPASSOCATION_ID'=>$this->GROUPASSOCATION_ID, 'GROUPTYPE_ID'=>$this->GROUPTYPE_ID, 'SCHEDULE_ID'=>$this->SCHEDULE_ID, 'SCHEDULEBLOCKS_ID'=>$this->SCHEDULEBLOCKS_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'PERSON_ID'=>$this->PERSON_ID, 'TIMEZONES_ID'=>$this->TIMEZONES_ID);//[RAD_CALLBACK_PARAMS]
        $formAction = $this->getCallBack(modulecim_sch::PAGE_MANAGETIMEZONES, $this->sortBy, $parameters );
        
        // set the pageCallBack value.  This is used by the Language switching
        // code
        $this->setPageCallBack( $formAction );
        
        // if this pageDisplay object isn't already created then 
        if ( !$isCreated ) {
        
            // create a new pageDisplay object
            $this->pageDisplay = new FormProcessor_ManageTimeZones( $this->moduleRootPath, $this->viewer, $formAction, $this->sortBy,  $this->TIMEZONES_ID, $this->TIMEZONES_ID );//[RAD_FORMINIT_FOREIGNKEY_INIT]    
        
        } else {
        
            // otherwise just update the formAction value
            $this->pageDisplay->setFormAction( $formAction );
        }
        
        $links = array();
        
        $parameters = array( 'CAMPUSGROUP_ID'=>$this->CAMPUSGROUP_ID, 'GROUP_ID'=>$this->GROUP_ID, 'GROUPASSOCATION_ID'=>$this->GROUPASSOCATION_ID, 'GROUPTYPE_ID'=>$this->GROUPTYPE_ID, 'SCHEDULE_ID'=>$this->SCHEDULE_ID, 'SCHEDULEBLOCKS_ID'=>$this->SCHEDULEBLOCKS_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'PERSON_ID'=>$this->PERSON_ID, 'TIMEZONES_ID'=>$this->TIMEZONES_ID);//[RAD_CALLBACK_PARAMS]
        $continueLink = $this->getCallBack( modulecim_sch::PAGE_SCHEDULERHOME, "", $parameters );
        $links["cont"] = $continueLink;

        $parameters = array( );//[RAD_CALLBACK_PARAMS_EDIT]
        $editLink = $this->getCallBack( modulecim_sch::PAGE_MANAGETIMEZONES, $this->sortBy, $parameters );
        $editLink .= "&". modulecim_sch::TIMEZONES_ID . "=";
        $links[ "edit" ] = $editLink;
        
        // NOTE: delete link is same as edit link for an AdminBox
        $links[ "del" ] = $editLink;

/*[RAD_LINK_INSERT]*/

        $parameters = array('CAMPUSGROUP_ID'=>$this->CAMPUSGROUP_ID, 'GROUP_ID'=>$this->GROUP_ID, 'GROUPASSOCATION_ID'=>$this->GROUPASSOCATION_ID, 'GROUPTYPE_ID'=>$this->GROUPTYPE_ID, 'SCHEDULE_ID'=>$this->SCHEDULE_ID, 'SCHEDULEBLOCKS_ID'=>$this->SCHEDULEBLOCKS_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'PERSON_ID'=>$this->PERSON_ID, 'TIMEZONES_ID'=>$this->TIMEZONES_ID);//[RAD_CALLBACK_PARAMS]
        $sortByLink = $this->getCallBack( modulecim_sch::PAGE_MANAGETIMEZONES, '', $parameters );
        $sortByLink .= "&".modulecim_sch::SORTBY."=";
        $links["sortBy"] = $sortByLink;

        $this->pageDisplay->setLinks( $links );    
        
    } // end loadManageTimeZones()



    //************************************************************************
	/**
	 * function loadAdminGroupType
	 * <pre>
	 * Initializes the AdminGroupType Page.
	 * </pre>
	 * @param $isCreated [BOOL] "Is THIS pageDisplay object already created?"
	 * @return [void]
	 */
    // RAD Tools: AdminBox Style
    function loadAdminGroupType( $isCreated=false ) 
    {
        
        // compile a formAction for the adminBox
        $parameters = array('CAMPUSGROUP_ID'=>$this->CAMPUSGROUP_ID, 'GROUP_ID'=>$this->GROUP_ID, 'GROUPASSOCATION_ID'=>$this->GROUPASSOCATION_ID, 'GROUPTYPE_ID'=>$this->GROUPTYPE_ID, 'SCHEDULE_ID'=>$this->SCHEDULE_ID, 'SCHEDULEBLOCKS_ID'=>$this->SCHEDULEBLOCKS_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'PERSON_ID'=>$this->PERSON_ID, 'TIMEZONES_ID'=>$this->TIMEZONES_ID);//[RAD_CALLBACK_PARAMS]
        $formAction = $this->getCallBack(modulecim_sch::PAGE_ADMINGROUPTYPE, $this->sortBy, $parameters );
        
        // set the pageCallBack value.  This is used by the Language switching
        // code
        $this->setPageCallBack( $formAction );
        
        // if this pageDisplay object isn't already created then 
        if ( !$isCreated ) {
        
            // create a new pageDisplay object
            $this->pageDisplay = new FormProcessor_AdminGroupType( $this->moduleRootPath, $this->viewer, $formAction, $this->sortBy,  $this->GROUPTYPE_ID, $this->GROUPTYPE_ID );//[RAD_FORMINIT_FOREIGNKEY_INIT]    
        
        } else {
        
            // otherwise just update the formAction value
            $this->pageDisplay->setFormAction( $formAction );
        }
        
        $links = array();
        
        $parameters = array( 'CAMPUSGROUP_ID'=>$this->CAMPUSGROUP_ID, 'GROUP_ID'=>$this->GROUP_ID, 'GROUPASSOCATION_ID'=>$this->GROUPASSOCATION_ID, 'GROUPTYPE_ID'=>$this->GROUPTYPE_ID, 'SCHEDULE_ID'=>$this->SCHEDULE_ID, 'SCHEDULEBLOCKS_ID'=>$this->SCHEDULEBLOCKS_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'PERSON_ID'=>$this->PERSON_ID, 'TIMEZONES_ID'=>$this->TIMEZONES_ID);//[RAD_CALLBACK_PARAMS]
        $continueLink = $this->getCallBack( modulecim_sch::PAGE_SCHEDULERHOME, "", $parameters );
        $links["cont"] = $continueLink;
        
        $parameters = array( );//[RAD_CALLBACK_PARAMS_EDIT]
        $editLink = $this->getCallBack( modulecim_sch::PAGE_ADMINGROUPTYPE, $this->sortBy, $parameters );
        $editLink .= "&". modulecim_sch::GROUPTYPE_ID . "=";
        $links[ "edit" ] = $editLink;
        
        // NOTE: delete link is same as edit link for an AdminBox
        $links[ "del" ] = $editLink;

/*[RAD_LINK_INSERT]*/

        $parameters = array('CAMPUSGROUP_ID'=>$this->CAMPUSGROUP_ID, 'GROUP_ID'=>$this->GROUP_ID, 'GROUPASSOCATION_ID'=>$this->GROUPASSOCATION_ID, 'GROUPTYPE_ID'=>$this->GROUPTYPE_ID, 'SCHEDULE_ID'=>$this->SCHEDULE_ID, 'SCHEDULEBLOCKS_ID'=>$this->SCHEDULEBLOCKS_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'PERSON_ID'=>$this->PERSON_ID, 'TIMEZONES_ID'=>$this->TIMEZONES_ID);//[RAD_CALLBACK_PARAMS]
        $sortByLink = $this->getCallBack( modulecim_sch::PAGE_ADMINGROUPTYPE, '', $parameters );
        $sortByLink .= "&".modulecim_sch::SORTBY."=";
        $links["sortBy"] = $sortByLink;

        $this->pageDisplay->setLinks( $links );    
        
    } // end loadAdminGroupType()



    //************************************************************************
	/**
	 * function loadManageSuperAdmin
	 * <pre>
	 * Initializes the ManageSuperAdmin Page.
	 * </pre>
	 * @param $isCreated [BOOL] "Is THIS pageDisplay object already created?"
	 * @return [void]
	 */
    // RAD Tools: AdminBox Style
    function loadManageSuperAdmin( $isCreated=false ) 
    {
        
        // compile a formAction for the adminBox
        $parameters = array('CAMPUSGROUP_ID'=>$this->CAMPUSGROUP_ID, 'GROUP_ID'=>$this->GROUP_ID, 'GROUPASSOCATION_ID'=>$this->GROUPASSOCATION_ID, 'GROUPTYPE_ID'=>$this->GROUPTYPE_ID, 'SCHEDULE_ID'=>$this->SCHEDULE_ID, 'SCHEDULEBLOCKS_ID'=>$this->SCHEDULEBLOCKS_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'PERSON_ID'=>$this->PERSON_ID, 'TIMEZONES_ID'=>$this->TIMEZONES_ID, 'PERMISSIONSCAMPUSADMIN_ID'=>$this->PERMISSIONSCAMPUSADMIN_ID, 'PERMISSIONSGROUPADMIN_ID'=>$this->PERMISSIONSGROUPADMIN_ID, 'PERMISSIONSSUPERADMIN_ID'=>$this->PERMISSIONSSUPERADMIN_ID, 'VIEWER_ID'=>$this->VIEWER_ID);//[RAD_CALLBACK_PARAMS]
        $formAction = $this->getCallBack(modulecim_sch::PAGE_MANAGESUPERADMIN, $this->sortBy, $parameters );
        
        // set the pageCallBack value.  This is used by the Language switching
        // code
        $this->setPageCallBack( $formAction );
        
        // if this pageDisplay object isn't already created then 
        if ( !$isCreated ) {
        
            // create a new pageDisplay object
            $this->pageDisplay = new FormProcessor_ManageSuperAdmin( $this->moduleRootPath, $this->viewer, $formAction, $this->sortBy,  $this->PERMISSIONSSUPERADMIN_ID, $this->PERMISSIONSSUPERADMIN_ID , $this->VIEWER_ID);//[RAD_FORMINIT_FOREIGNKEY_INIT]    
        
        } else {
        
            // otherwise just update the formAction value
            $this->pageDisplay->setFormAction( $formAction );
        }
        
        $links = array();
        
        $parameters = array( 'CAMPUSGROUP_ID'=>$this->CAMPUSGROUP_ID, 'GROUP_ID'=>$this->GROUP_ID, 'GROUPASSOCATION_ID'=>$this->GROUPASSOCATION_ID, 'GROUPTYPE_ID'=>$this->GROUPTYPE_ID, 'SCHEDULE_ID'=>$this->SCHEDULE_ID, 'SCHEDULEBLOCKS_ID'=>$this->SCHEDULEBLOCKS_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'PERSON_ID'=>$this->PERSON_ID, 'TIMEZONES_ID'=>$this->TIMEZONES_ID, 'PERMISSIONSCAMPUSADMIN_ID'=>$this->PERMISSIONSCAMPUSADMIN_ID, 'PERMISSIONSGROUPADMIN_ID'=>$this->PERMISSIONSGROUPADMIN_ID, 'PERMISSIONSSUPERADMIN_ID'=>$this->PERMISSIONSSUPERADMIN_ID, 'VIEWER_ID'=>$this->VIEWER_ID);//[RAD_CALLBACK_PARAMS]
        $continueLink = $this->getCallBack( modulecim_sch::PAGE_SCHEDULERHOME, "", $parameters );
        $links["cont"] = $continueLink;

        $parameters = array( );//[RAD_CALLBACK_PARAMS_EDIT]
        $editLink = $this->getCallBack( modulecim_sch::PAGE_MANAGESUPERADMIN, $this->sortBy, $parameters );
        $editLink .= "&". modulecim_sch::PERMISSIONSSUPERADMIN_ID . "=";
        $links[ "edit" ] = $editLink;
        
        // NOTE: delete link is same as edit link for an AdminBox
        $links[ "del" ] = $editLink;

/*[RAD_LINK_INSERT]*/

        $parameters = array('CAMPUSGROUP_ID'=>$this->CAMPUSGROUP_ID, 'GROUP_ID'=>$this->GROUP_ID, 'GROUPASSOCATION_ID'=>$this->GROUPASSOCATION_ID, 'GROUPTYPE_ID'=>$this->GROUPTYPE_ID, 'SCHEDULE_ID'=>$this->SCHEDULE_ID, 'SCHEDULEBLOCKS_ID'=>$this->SCHEDULEBLOCKS_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'PERSON_ID'=>$this->PERSON_ID, 'TIMEZONES_ID'=>$this->TIMEZONES_ID, 'PERMISSIONSCAMPUSADMIN_ID'=>$this->PERMISSIONSCAMPUSADMIN_ID, 'PERMISSIONSGROUPADMIN_ID'=>$this->PERMISSIONSGROUPADMIN_ID, 'PERMISSIONSSUPERADMIN_ID'=>$this->PERMISSIONSSUPERADMIN_ID, 'VIEWER_ID'=>$this->VIEWER_ID);//[RAD_CALLBACK_PARAMS]
        $sortByLink = $this->getCallBack( modulecim_sch::PAGE_MANAGESUPERADMIN, '', $parameters );
        $sortByLink .= "&".modulecim_sch::SORTBY."=";
        $links["sortBy"] = $sortByLink;

        $this->pageDisplay->setLinks( $links );    
        
    } // end loadManageSuperAdmin()



    //************************************************************************
	/**
	 * function loadMySchedule
	 * <pre>
	 * Initializes the MySchedule Page.
	 * </pre>
	 * @return [void]
	 */
    // RAD Tools: Custom style
    function loadMySchedule( $isCreated=false ) 
    {
        // set the pageCallBack to be without any additional parameters
        // (an AdminBox needs this so Language Switching on a page doesn't
        // pass a previous operations)
        
        $parameters = array('CAMPUSGROUP_ID'=>$this->CAMPUSGROUP_ID, 'GROUP_ID'=>$this->GROUP_ID, 'GROUPASSOCATION_ID'=>$this->GROUPASSOCATION_ID, 'GROUPTYPE_ID'=>$this->GROUPTYPE_ID, 'SCHEDULE_ID'=>$this->SCHEDULE_ID, 'SCHEDULEBLOCKS_ID'=>$this->SCHEDULEBLOCKS_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'PERSON_ID'=>$this->PERSON_ID, 'TIMEZONES_ID'=>$this->TIMEZONES_ID, 'PERMISSIONSCAMPUSADMIN_ID'=>$this->PERMISSIONSCAMPUSADMIN_ID, 'PERMISSIONSGROUPADMIN_ID'=>$this->PERMISSIONSGROUPADMIN_ID, 'PERMISSIONSSUPERADMIN_ID'=>$this->PERMISSIONSSUPERADMIN_ID, 'VIEWER_ID'=>$this->VIEWER_ID);//[RAD_CALLBACK_PARAMS]
        
        $formAction = $this->getCallBack(modulecim_sch::PAGE_MYSCHEDULE, $this->sortBy, $parameters );
        
        // set the pageCallBack value.  This is used by the Language switching
        // code
        $this->setPageCallBack( $formAction );
 
        // if this pageDisplay object isn't already created then 
        if ( !$isCreated ) {
        
            // create a new pageDisplay object
            $this->pageDisplay = new page_MySchedule( $this->moduleRootPath, $this->viewer, $formAction, $this->sortBy );   
        } else {
        
            // otherwise just update the formAction value
            $this->pageDisplay->setFormAction( $formAction );
        }      
        
        $links = array();
        
        $parameters = array( 'CAMPUSGROUP_ID'=>$this->CAMPUSGROUP_ID, 'GROUP_ID'=>$this->GROUP_ID, 'GROUPASSOCATION_ID'=>$this->GROUPASSOCATION_ID, 'GROUPTYPE_ID'=>$this->GROUPTYPE_ID, 'SCHEDULE_ID'=>$this->SCHEDULE_ID, 'SCHEDULEBLOCKS_ID'=>$this->SCHEDULEBLOCKS_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'PERSON_ID'=>$this->PERSON_ID, 'TIMEZONES_ID'=>$this->TIMEZONES_ID, 'PERMISSIONSCAMPUSADMIN_ID'=>$this->PERMISSIONSCAMPUSADMIN_ID, 'PERMISSIONSGROUPADMIN_ID'=>$this->PERMISSIONSGROUPADMIN_ID, 'PERMISSIONSSUPERADMIN_ID'=>$this->PERMISSIONSSUPERADMIN_ID, 'VIEWER_ID'=>$this->VIEWER_ID);//[RAD_CALLBACK_PARAMS]
        $continueLink = $this->getCallBack( modulecim_sch::PAGE_SCHEDULERHOME, "", $parameters );
        $links["cont"] = $continueLink;

        $this->addScript('sch_timeblocks.jsp');
/*[RAD_LINK_INSERT]*/

        $this->pageDisplay->setLinks( $links );     
        
    } // end loadMySchedule()



    //************************************************************************
	/**
	 * function loadManageGroup
	 * <pre>
	 * Initializes the ManageGroup Page.
	 * </pre>
	 * @return [void]
	 */
    // RAD Tools: FormSingleEntry style
    function loadManageGroup() 
    {
        // set the pageCallBack to be without any additional parameters
        // (an AdminBox needs this so Language Switching on a page doesn't
        // pass a previous operations)
        $parameters = array('CAMPUSGROUP_ID'=>$this->CAMPUSGROUP_ID, 'GROUP_ID'=>$this->GROUP_ID, 'GROUPASSOCATION_ID'=>$this->GROUPASSOCATION_ID, 'GROUPTYPE_ID'=>$this->GROUPTYPE_ID, 'SCHEDULE_ID'=>$this->SCHEDULE_ID, 'SCHEDULEBLOCKS_ID'=>$this->SCHEDULEBLOCKS_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'PERSON_ID'=>$this->PERSON_ID, 'TIMEZONES_ID'=>$this->TIMEZONES_ID, 'PERMISSIONSCAMPUSADMIN_ID'=>$this->PERMISSIONSCAMPUSADMIN_ID, 'PERMISSIONSGROUPADMIN_ID'=>$this->PERMISSIONSGROUPADMIN_ID, 'PERMISSIONSSUPERADMIN_ID'=>$this->PERMISSIONSSUPERADMIN_ID, 'VIEWER_ID'=>$this->VIEWER_ID);//[RAD_CALLBACK_PARAMS]
        $pageCallBack = $this->getCallBack(modulecim_sch::PAGE_MANAGEGROUP, $this->sortBy, $parameters);
        $this->setPageCallBack( $pageCallBack );
        
        
        $parameters = array('CAMPUSGROUP_ID'=>$this->CAMPUSGROUP_ID, 'GROUP_ID'=>$this->GROUP_ID, 'GROUPASSOCATION_ID'=>$this->GROUPASSOCATION_ID, 'GROUPTYPE_ID'=>$this->GROUPTYPE_ID, 'SCHEDULE_ID'=>$this->SCHEDULE_ID, 'SCHEDULEBLOCKS_ID'=>$this->SCHEDULEBLOCKS_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'PERSON_ID'=>$this->PERSON_ID, 'TIMEZONES_ID'=>$this->TIMEZONES_ID, 'PERMISSIONSCAMPUSADMIN_ID'=>$this->PERMISSIONSCAMPUSADMIN_ID, 'PERMISSIONSGROUPADMIN_ID'=>$this->PERMISSIONSGROUPADMIN_ID, 'PERMISSIONSSUPERADMIN_ID'=>$this->PERMISSIONSSUPERADMIN_ID, 'VIEWER_ID'=>$this->VIEWER_ID);//[RAD_CALLBACK_PARAMS]
        $formAction = $this->getCallBack(modulecim_sch::PAGE_MANAGEGROUP, $this->sortBy, $parameters );
        $this->pageDisplay = new FormProcessor_ManageGroup( $this->moduleRootPath, $this->viewer, $formAction, $this->GROUP_ID , $this->GROUPTYPE_ID);//[RAD_FORMINIT_FOREIGNKEY_INIT]        
        
    } // end loadManageGroup()



    //************************************************************************
	/**
	 * function loadManageCampusGroup
	 * <pre>
	 * Initializes the ManageCampusGroup Page.
	 * </pre>
	 * @param $isCreated [BOOL] "Is THIS pageDisplay object already created?"
	 * @return [void]
	 */
    // RAD Tools: AdminBox Style
    function loadManageCampusGroup( $isCreated=false ) 
    {
        
        // compile a formAction for the adminBox
        $parameters = array('CAMPUSGROUP_ID'=>$this->CAMPUSGROUP_ID, 'GROUP_ID'=>$this->GROUP_ID, 'GROUPASSOCATION_ID'=>$this->GROUPASSOCATION_ID, 'GROUPTYPE_ID'=>$this->GROUPTYPE_ID, 'SCHEDULE_ID'=>$this->SCHEDULE_ID, 'SCHEDULEBLOCKS_ID'=>$this->SCHEDULEBLOCKS_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'PERSON_ID'=>$this->PERSON_ID, 'TIMEZONES_ID'=>$this->TIMEZONES_ID, 'PERMISSIONSCAMPUSADMIN_ID'=>$this->PERMISSIONSCAMPUSADMIN_ID, 'PERMISSIONSGROUPADMIN_ID'=>$this->PERMISSIONSGROUPADMIN_ID, 'PERMISSIONSSUPERADMIN_ID'=>$this->PERMISSIONSSUPERADMIN_ID, 'VIEWER_ID'=>$this->VIEWER_ID);//[RAD_CALLBACK_PARAMS]
        $formAction = $this->getCallBack(modulecim_sch::PAGE_MANAGECAMPUSGROUP, $this->sortBy, $parameters );
        
        // echo "loadManageCampusGroup - groupID[".$this->GROUP_ID."] formAction[".$formAction."]<br/>";
        
        // set the pageCallBack value.  This is used by the Language switching
        // code
        $this->setPageCallBack( $formAction );
        
        // if this pageDisplay object isn't already created then 
        if ( !$isCreated ) {
        
            // create a new pageDisplay object
            $this->pageDisplay = new FormProcessor_ManageCampusGroup( $this->moduleRootPath, $this->viewer, $formAction, $this->sortBy,  $this->CAMPUSGROUP_ID, $this->GROUP_ID , $this->CAMPUS_ID);//[RAD_FORMINIT_FOREIGNKEY_INIT]    
        
        } else {
        
            // otherwise just update the formAction value
            $this->pageDisplay->setFormAction( $formAction );
        }
        
        $links = array();
        
        $parameters = array( 'CAMPUSGROUP_ID'=>$this->CAMPUSGROUP_ID, 'GROUP_ID'=>$this->GROUP_ID, 'GROUPASSOCATION_ID'=>$this->GROUPASSOCATION_ID, 'GROUPTYPE_ID'=>$this->GROUPTYPE_ID, 'SCHEDULE_ID'=>$this->SCHEDULE_ID, 'SCHEDULEBLOCKS_ID'=>$this->SCHEDULEBLOCKS_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'PERSON_ID'=>$this->PERSON_ID, 'TIMEZONES_ID'=>$this->TIMEZONES_ID, 'PERMISSIONSCAMPUSADMIN_ID'=>$this->PERMISSIONSCAMPUSADMIN_ID, 'PERMISSIONSGROUPADMIN_ID'=>$this->PERMISSIONSGROUPADMIN_ID, 'PERMISSIONSSUPERADMIN_ID'=>$this->PERMISSIONSSUPERADMIN_ID, 'VIEWER_ID'=>$this->VIEWER_ID);//[RAD_CALLBACK_PARAMS]
        $continueLink = $this->getCallBack( modulecim_sch::PAGE_SCHEDULERHOME, "", $parameters );
        $links["cont"] = $continueLink;

        // $parameters = array( );//[RAD_CALLBACK_PARAMS_EDIT]
        $editLink = $this->getCallBack( modulecim_sch::PAGE_MANAGECAMPUSGROUP, $this->sortBy, $parameters );
        $editLink .= "&". modulecim_sch::CAMPUSGROUP_ID . "=";
        $links[ "edit" ] = $editLink;
        
        // NOTE: delete link is same as edit link for an AdminBox
        $links[ "del" ] = $editLink;

/*[RAD_LINK_INSERT]*/

        $parameters = array('CAMPUSGROUP_ID'=>$this->CAMPUSGROUP_ID, 'GROUP_ID'=>$this->GROUP_ID, 'GROUPASSOCATION_ID'=>$this->GROUPASSOCATION_ID, 'GROUPTYPE_ID'=>$this->GROUPTYPE_ID, 'SCHEDULE_ID'=>$this->SCHEDULE_ID, 'SCHEDULEBLOCKS_ID'=>$this->SCHEDULEBLOCKS_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'PERSON_ID'=>$this->PERSON_ID, 'TIMEZONES_ID'=>$this->TIMEZONES_ID, 'PERMISSIONSCAMPUSADMIN_ID'=>$this->PERMISSIONSCAMPUSADMIN_ID, 'PERMISSIONSGROUPADMIN_ID'=>$this->PERMISSIONSGROUPADMIN_ID, 'PERMISSIONSSUPERADMIN_ID'=>$this->PERMISSIONSSUPERADMIN_ID, 'VIEWER_ID'=>$this->VIEWER_ID);//[RAD_CALLBACK_PARAMS]
        $sortByLink = $this->getCallBack( modulecim_sch::PAGE_MANAGECAMPUSGROUP, '', $parameters );
        $sortByLink .= "&".modulecim_sch::SORTBY."=";
        $links["sortBy"] = $sortByLink;

        $this->pageDisplay->setLinks( $links );    
        
    } // end loadManageCampusGroup()



    //************************************************************************
	/**
	 * function loadViewGroups
	 * <pre>
	 * Initializes the ViewGroups Page.
	 * </pre>
	 * @return [void]
	 */
    // RAD Tools: DataListTable Style
    function loadViewGroups() 
    {
        // set the pageCallBack to be without any additional parameters
        // (an AdminBox needs this so Language Switching on a page doesn't
        // pass a previous operations)
        $parameters = array('CAMPUSGROUP_ID'=>$this->CAMPUSGROUP_ID, 'GROUP_ID'=>$this->GROUP_ID, 'GROUPASSOCATION_ID'=>$this->GROUPASSOCATION_ID, 'GROUPTYPE_ID'=>$this->GROUPTYPE_ID, 'SCHEDULE_ID'=>$this->SCHEDULE_ID, 'SCHEDULEBLOCKS_ID'=>$this->SCHEDULEBLOCKS_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'PERSON_ID'=>$this->PERSON_ID, 'TIMEZONES_ID'=>$this->TIMEZONES_ID, 'PERMISSIONSCAMPUSADMIN_ID'=>$this->PERMISSIONSCAMPUSADMIN_ID, 'PERMISSIONSGROUPADMIN_ID'=>$this->PERMISSIONSGROUPADMIN_ID, 'PERMISSIONSSUPERADMIN_ID'=>$this->PERMISSIONSSUPERADMIN_ID, 'VIEWER_ID'=>$this->VIEWER_ID);//[RAD_CALLBACK_PARAMS]
        $pageCallBack = $this->getCallBack(modulecim_sch::PAGE_VIEWGROUPS, $this->sortBy, $parameters);
        $this->setPageCallBack( $pageCallBack );
        
        
        $this->pageDisplay = new page_ViewGroups( $this->moduleRootPath, $this->viewer, $this->sortBy, $this->GROUP_ID );    
        
        $links = array();
        
        $parameters = array( 'CAMPUSGROUP_ID'=>$this->CAMPUSGROUP_ID, 'GROUP_ID'=>$this->GROUP_ID, 'GROUPASSOCATION_ID'=>$this->GROUPASSOCATION_ID, 'GROUPTYPE_ID'=>$this->GROUPTYPE_ID, 'SCHEDULE_ID'=>$this->SCHEDULE_ID, 'SCHEDULEBLOCKS_ID'=>$this->SCHEDULEBLOCKS_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'PERSON_ID'=>$this->PERSON_ID, 'TIMEZONES_ID'=>$this->TIMEZONES_ID, 'PERMISSIONSCAMPUSADMIN_ID'=>$this->PERMISSIONSCAMPUSADMIN_ID, 'PERMISSIONSGROUPADMIN_ID'=>$this->PERMISSIONSGROUPADMIN_ID, 'PERMISSIONSSUPERADMIN_ID'=>$this->PERMISSIONSSUPERADMIN_ID, 'VIEWER_ID'=>$this->VIEWER_ID);//[RAD_CALLBACK_PARAMS]
        $continueLink = $this->getCallBack( modulecim_sch::PAGE_SCHEDULERHOME, "", $parameters );
        $links["cont"] = $continueLink;
        
        $parameters = array( );//[RAD_CALLBACK_PARAMS_EDIT]
        $editLink = $this->getCallBack( modulecim_sch::PAGE_MANAGEGROUP, $this->sortBy, $parameters );
        $editLink .= "&". modulecim_sch::GROUP_ID . "=";
        $links[ "edit" ] = $editLink;
        
        // NOTE: delete link is same as edit link for an AdminBox
        // $links[ "del" ] = $editLink;

/*[RAD_LINK_INSERT]*/

        $parameters = array('CAMPUSGROUP_ID'=>$this->CAMPUSGROUP_ID, 'GROUP_ID'=>$this->GROUP_ID, 'GROUPASSOCATION_ID'=>$this->GROUPASSOCATION_ID, 'GROUPTYPE_ID'=>$this->GROUPTYPE_ID, 'SCHEDULE_ID'=>$this->SCHEDULE_ID, 'SCHEDULEBLOCKS_ID'=>$this->SCHEDULEBLOCKS_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'PERSON_ID'=>$this->PERSON_ID, 'TIMEZONES_ID'=>$this->TIMEZONES_ID, 'PERMISSIONSCAMPUSADMIN_ID'=>$this->PERMISSIONSCAMPUSADMIN_ID, 'PERMISSIONSGROUPADMIN_ID'=>$this->PERMISSIONSGROUPADMIN_ID, 'PERMISSIONSSUPERADMIN_ID'=>$this->PERMISSIONSSUPERADMIN_ID, 'VIEWER_ID'=>$this->VIEWER_ID);//[RAD_CALLBACK_PARAMS]
        $sortByLink = $this->getCallBack( modulecim_sch::PAGE_VIEWGROUPS, '', $parameters );
        $sortByLink .= "&".modulecim_sch::SORTBY."=";
        $links["sortBy"] = $sortByLink;

        $this->pageDisplay->setLinks( $links ); 
        
    } // end loadViewGroups()



/*[RAD_PAGE_LOAD_FN]*/		

}

?>