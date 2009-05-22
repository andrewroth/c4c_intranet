<?php
/**
 * @package AccountAdmin
 */
/*!
 @class moduleAccountAdmin
 @discussion <pre>
 Written By	:	Johnny Hausman
 Date		:   21 Mar 2005
 
 This module manages the Web Site's login accounts and access priviledges.
 
 </pre>	
*/
class moduleAccountAdmin extends XMLObject_PageContent {
// 		
//
//	CONSTANTS:

        
    /*! const MULTILINGUAL_SERIES_KEY The Multilingual Series key for this application.. */
        const MULTILINGUAL_SERIES_KEY = 'moduleAccountAdmin';
        
    /*! const MULTILINGUAL_PAGE_FIELDS The Multilingual Page key for the fields of this application. */
        const MULTILINGUAL_PAGE_FIELDS = 'fields_AccountAdmin';
        
    /*! const MODULE_KEY The Module Key for this Module.  Used for access */
        const MODULE_KEY = 'AccountAdmin';
        
    /*! const PAGE    The QueryString Page parameter. */
        const PAGE = "P";
        
    /*! const PAGE_ACCESSPRIV   Display the AccessPriv Page. */
        const PAGE_ACCESSPRIV = "AcP";
        
    /*! const PAGE_ACCOUNTLIST   Display the AccountList Page. */
        const PAGE_ACCOUNTLIST = "AL";
        
    /*! const PAGE_ACCOUNTGROUP   Display the AccountGroup Page. */
        const PAGE_ACCOUNTGROUP = "AcG";

    /*! const PAGE_ADDVIEWER   Display the AddViewer Page. */
        const PAGE_ADDVIEWER = "AV";

    /*! const PAGE_EDITVIEWER   Display the EditViewer Page. */
        const PAGE_EDITVIEWER = "EV";

    /*! const PAGE_EDITPASSWORD   Display the EditPassword Page. */
        const PAGE_EDITPASSWORD = "EP";

    /*! const PAGE_PASSWORDCHANGE   Display the PasswordChange Confirmation Page. */
        const PAGE_PASSWORDCHANGED = "EPC";

    /*! const PAGE_DELETEVIEWER   Display the DeleteViewer Page. */
        const PAGE_DELETEVIEWER = "DV";

    /*! const PAGE_ACCESSCATEGORIES   Display the AccessCategories Page. */
        const PAGE_ACCESSCATEGORIES = "AC";

    /*! const PAGE_ACCESSGROUP   Display the AccessGroup Page. */
        const PAGE_ACCESSGROUP = "AG";

    /*! const PAGE_LANGUAGELIST   Display the LanguageList Page. */
        const PAGE_LANGUAGELIST = "LL";

    /*! const PAGE_ACCOUNTACCESS   Display the AccountAccess Page. */
        const PAGE_ACCOUNTACCESS = "AA";
        
    /*! const PAGE_NOTALLOWED   Display the AccountAccess Page. */
        const PAGE_NOTALLOWED = "NA";

/*[RAD_PAGE_CONST]*/

    /*! const SORTBY    The QueryString SortBy parameter. */
        const SORTBY = "modSort";
                

    /*! const ACCOUNTGROUPID   The QueryString ACCOUNTGROUPID parameter. */
        const ACCOUNTGROUPID = "SV6";

    /*! const VIEWERID   The QueryString VIEWERID parameter. */
        const VIEWERID = "SV7";

    /*! const ACCESSCATEGORYID   The QueryString ACCESSCATEGORYID parameter. */
        const ACCESSCATEGORYID = "SV8";

    /*! const ACCESSGROUPID   The QueryString ACCESSGROUPID parameter. */
        const ACCESSGROUPID = "SV9";

    /*! const LANGUAGEID   The QueryString LANGUAGEID parameter. */
        const LANGUAGEID = "SV10";
        
    /*! const VIEWERACCESSGROUPID   The QueryString VIEWERACCESSGROUPID parameter. */
        const VIEWERACCESSGROUPID = "VAG";
        
    /*! const ACCESSPRIVID  The QueryString ACCESSPRIVID parameter. */
        const ACCESSPRIVID = "APID";

/*[RAD_PAGE_STATEVAR_CONST]*/
        
        
//
//	VARIABLES:
        
    /*! protected $page   [STRING] The current Mode of this Module. */
		protected $page;
		
    /*! protected $sortBy [STRING] Parameter to sort displayed Lists. */
                protected $sortBy;
		
    /*! protected $accountGroupID   [INTEGER] Tracks which group of web site accounts we are working with. */
		protected $accountGroupID;

    /*! protected $viewerID   [INTEGER] Tracks which user account we are working with. */
		protected $viewerID;

    /*! protected $accessCategoryID   [INTEGER] Tracks which category of Access Priviledges we are working with. */
		protected $accessCategoryID;

    /*! protected $accessGroupID   [INTEGER] Tracks which Access Group we are working with. */
		protected $accessGroupID;

    /*! protected $languageID   [INTEGER] Tracks which Language entry we are working with. */
		protected $languageID;
		
    /*! protected $viewerAccessGroupID   [INTEGER] Tracks which Viewer-Access Group entry we are working with. */
		protected $viewerAccessGroupID;
		
    /*! protected $accessPrivID [INTEGER] AccessPriv entry we are working with. */
		protected $accessPrivID;
		
    /*! protected $accessPrivManager [OBJECT] the Access Priviledge manager for the module */
		protected $accessPrivManager;

/*[RAD_PAGE_STATEVAR_VAR]*/
		
   
    /*! protected $pageDisplay [OBJECT] The display object for the page. */
        protected $pageDisplay;
        
    /*! protected $sideBar [OBJECT] The display object for the sideBar. */
        protected $sideBar;
        
/*[RAD_PAGE_OBJECT_VAR]*/ 		


//
//	CLASS FUNCTIONS:
//

	
	//************************************************************************
	/*! 
	 @function loadData
	 
	 @abstract Provided function to allow object to load it's data.

	*/
	function loadData( ) 
	{


/*[RAD_PAGE_STATEVAR_INIT]*/
        
        // Now check to see if a Application ID was given
//        $this->appID = $this->getQSValue( moduleAccountAdmin::APPID, '' );
        
/*[RAD_COMMON_LOAD]*/
         
        // load the module's page (DEFAULT = WELCOME)
        $this->page = $this->getQSValue( moduleAccountAdmin::PAGE, moduleAccountAdmin::PAGE_ACCOUNTLIST );
        
        // load the module's sortBy parameter (DEFAULT = '')
        $this->sortBy = $this->getQSValue( moduleAccountAdmin::SORTBY, '' );
        
        // load the module's ACCOUNTGROUPID variable
        $this->accountGroupID = $this->getQSValue( moduleAccountAdmin::ACCOUNTGROUPID, '' );

        // load the module's VIEWERID variable
        $this->viewerID = $this->getQSValue( moduleAccountAdmin::VIEWERID, "" );

        // load the module's ACCESSCATEGORYID variable
        $this->accessCategoryID = $this->getQSValue( moduleAccountAdmin::ACCESSCATEGORYID, "" );

        // load the module's ACCESSGROUPID variable
        $this->accessGroupID = $this->getQSValue( moduleAccountAdmin::ACCESSGROUPID, "" );

        // load the module's LANGUAGEID variable
        $this->languageID = $this->getQSValue( moduleAccountAdmin::LANGUAGEID, "" );
        
        // load the module's VIEWERACCESSGROUPID variable
        $this->viewerAccessGroupID = $this->getQSValue( moduleAccountAdmin::VIEWERACCESSGROUPID, "" );

        // load the module's ACCESSPRIVID variable
        $this->accessPrivID = $this->getQSValue( moduleAccountAdmin::ACCESSPRIVID, "" );

/*[RAD_PAGE_LOAD_STATEVAR]*/

        // Now load the access Priviledge manager of this viewer
        $this->accessPrivManager = new RowManager_AccountAdminAccessManager();
        $this->accessPrivManager->loadByViewerID( $this->viewer->getViewerID() );

//Add below three lines to the class for pages normal users are not allowed to see.
        // if viewer doesn't have an entry then default to NO ENTRY page
//        if ( !$this->accessPrivManager->isLoaded() ) {
//            $this->page = moduleAccountAdmin::PAGE_EDITPASSWORD;
//        }


        switch( $this->page ) {

            /*
             *  AccountList
             */
            case moduleAccountAdmin::PAGE_ACCOUNTLIST:
                if ( !$this->accessPrivManager->isLoaded() ) {
                    $this->page = moduleAccountAdmin::PAGE_EDITPASSWORD;
                }
                $this->loadAccountList();
                break;

            /*
             *  AddViewer
             */
            case moduleAccountAdmin::PAGE_ADDVIEWER:
                if ( !$this->accessPrivManager->isLoaded() ) {
                    $this->page = moduleAccountAdmin::PAGE_EDITPASSWORD;
                }
                $this->loadAddViewer();
                break;

            /*
             *  EditViewer
             */
            case moduleAccountAdmin::PAGE_EDITVIEWER:
                if ( !$this->accessPrivManager->isLoaded() ) {
                    $this->page = moduleAccountAdmin::PAGE_EDITPASSWORD;
                }
                $this->loadEditViewer();
                break;

            /*
             *  EditPassword
             */
            case moduleAccountAdmin::PAGE_EDITPASSWORD:
                $this->loadEditPassword();
                break;

            /*
             *  PasswordChanged
             */
            case moduleAccountAdmin::PAGE_PASSWORDCHANGED:
                $this->loadPasswordChanged();
                break;

            /*
             *  DeleteViewer
             */
            case moduleAccountAdmin::PAGE_DELETEVIEWER:
                if ( !$this->accessPrivManager->isLoaded() ) {
                    $this->page = moduleAccountAdmin::PAGE_EDITPASSWORD;
                }
                $this->loadDeleteViewer();
                break;

            /*
             *  AccessCategories
             */
            case moduleAccountAdmin::PAGE_ACCESSCATEGORIES:
                if ( !$this->accessPrivManager->isLoaded() ) {
                    $this->page = moduleAccountAdmin::PAGE_EDITPASSWORD;
                }
                $this->loadAccessCategories();
                break;

            /*
             *  AccessGroup
             */
            case moduleAccountAdmin::PAGE_ACCESSGROUP:
                if ( !$this->accessPrivManager->isLoaded() ) {
                    $this->page = moduleAccountAdmin::PAGE_EDITPASSWORD;
                }
                $this->loadAccessGroup();
                break;

            /*
             *  LanguageList
             */
            case moduleAccountAdmin::PAGE_LANGUAGELIST:
                if ( !$this->accessPrivManager->isLoaded() ) {
                    $this->page = moduleAccountAdmin::PAGE_EDITPASSWORD;
                }
                $this->loadLanguageList();
                break;

            /*
             *  AccountAccess
             */
            case moduleAccountAdmin::PAGE_ACCOUNTACCESS:
                if ( !$this->accessPrivManager->isLoaded() ) {
                    $this->page = moduleAccountAdmin::PAGE_EDITPASSWORD;
                }
                $this->loadAccountAccess();
                break;

            /*
             *  AccountGroup
             */
            case moduleAccountAdmin::PAGE_ACCOUNTGROUP:
                if ( !$this->accessPrivManager->isLoaded() ) {
                    $this->page = moduleAccountAdmin::PAGE_EDITPASSWORD;
                }
                $this->loadAccountGroup();
                break;

            /*
             *  AccessPriv
             */
            case moduleAccountAdmin::PAGE_ACCESSPRIV:
                if ( !$this->accessPrivManager->isLoaded() ) {
                    $this->page = moduleAccountAdmin::PAGE_EDITPASSWORD;
                }
                $this->loadAccessPriv();
                break;

/*[RAD_PAGE_LOAD_CALL]*/


            /*
             *  Just to make sure, default the pageDisplay to
             *  the AccountList page.
             */
            default:
                if ( !$this->accessPrivManager->isLoaded() ) {
                    $this->page = moduleAccountAdmin::PAGE_EDITPASSWORD;
                }
                $this->page = moduleAccountAdmin::PAGE_ACCOUNTLIST;
                $this->loadAccountList();
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
	/*! 
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
    
                    case moduleAccountAdmin::PAGE_ACCESSCATEGORIES:
                        // NOTE: after a successful submit on an AdminBox style
                        // form, set the managerInit variable back to ''
                        $this->accessCategoryID = '';
                        $formAction = $this->getCallBack(moduleAccountAdmin::PAGE_ACCESSCATEGORIES, $this->sortBy, $this->accountGroupID, $this->viewerID, $this->accessCategoryID, $this->accessGroupID, $this->languageID);//[RAD_CALLBACK_PARAMS]
                        $this->pageDisplay->setFormAction( $formAction );                     
                        break;

                    case moduleAccountAdmin::PAGE_ACCESSGROUP:
                        // NOTE: after a successful submit on an AdminBox style
                        // form, set the managerInit variable back to ''
                        $this->accessGroupID = '';
                        $formAction = $this->getCallBack(moduleAccountAdmin::PAGE_ACCESSGROUP, $this->sortBy, $this->accountGroupID, $this->viewerID, $this->accessCategoryID, $this->accessGroupID, $this->languageID);//[RAD_CALLBACK_PARAMS]
                        $this->pageDisplay->setFormAction( $formAction );                     
                        break;

                    case moduleAccountAdmin::PAGE_LANGUAGELIST:
                        // NOTE: after a successful submit on an AdminBox style
                        // form, set the managerInit variable back to ''
                        $this->languageID = '';
                        $formAction = $this->getCallBack(moduleAccountAdmin::PAGE_LANGUAGELIST, $this->sortBy, $this->accountGroupID, $this->viewerID, $this->accessCategoryID, $this->accessGroupID, $this->languageID);//[RAD_CALLBACK_PARAMS]
                        $this->pageDisplay->setFormAction( $formAction );                     
                        break;
                        
                    case moduleAccountAdmin::PAGE_ACCESSPRIV:
                        // NOTE: after a successful submit on an AdminBox style
                        // form, set the managerInit variable back to ''
                        $this->accessPrivID = '';
                        $formAction = $this->getCallBack(moduleAccountAdmin::PAGE_ACCESSPRIV, $this->sortBy, $this->accountGroupID, $this->viewerID, $this->accessCategoryID, $this->accessGroupID, $this->languageID, $this->viewerAccessGroupID, $this->accessPrivID );//[RAD_CALLBACK_PARAMS]
                        $this->pageDisplay->setFormAction( $formAction );                     
                        break;

//                    case moduleAccountAdmin::PAGE_ACCOUNTACCESS:
//                        $formAction = $this->getCallBack(moduleAccountAdmin::PAGE_ACCOUNTACCESS, $this->accountGroupID, $this->viewerID, $this->accessCategoryID, $this->accessGroupID, $this->languageID);//[RAD_CALLBACK_PARAMS]
//                        $this->pageDisplay->setFormAction( $formAction );                     
//                        break;

                    case moduleAccountAdmin::PAGE_DELETEVIEWER:
                        /* No StateVar given for FormInit. */
                        $this->page = moduleAccountAdmin::PAGE_ACCOUNTLIST;
                        $this->loadAccountList();                       
                        break;

                    case moduleAccountAdmin::PAGE_EDITPASSWORD:
                        //$this->viewerID = '';
                        //Check to see if the viewer has admin privs before going to the AccountList
                        //Comment out below lines to send admins back to the userlist after a password change.
                        //if (( $this->accessPrivManager->hasGroupPriv() ) || ($this->accessPrivManager->hasSitePriv()) ){
                        //$this->page = moduleAccountAdmin::PAGE_ACCOUNTLIST;
                        //$this->loadAccountList();}
                        //else{
                          $this->page = moduleAccountAdmin::PAGE_PASSWORDCHANGED;
                          $this->loadPasswordChanged();
                        //}
                        break;

                    case moduleAccountAdmin::PAGE_ADDVIEWER:
                        $this->viewerID = '';
                        $this->page = moduleAccountAdmin::PAGE_ACCOUNTLIST;
                        $this->loadAccountList();                       
                        break;

                    case moduleAccountAdmin::PAGE_EDITVIEWER:
                        $this->viewerID = '';
                        $this->page = moduleAccountAdmin::PAGE_ACCOUNTLIST;
                        $this->loadAccountList();                       
                        break;

/*[RAD_PAGE_TRANSITION]*/
                        
                 }
            
            } // end if data valid
        
        }  // end if Process

	}
	
	
	
	//************************************************************************
	/*! 
	 * @function prepareDisplayData
	 *
	 * @abstract Provided function to allow an object to prepare it's data 
	 * for displaying (actually done in the <code>Page</code> Object).
     *
	 */
	function prepareDisplayData( ) 
	{
        $content = $this->pageDisplay->getHTML();



        // store HTML content as this page's content Item
        $this->addContent( $content );
        
        
        // add the sidebar content
        $sideBarContent = $this->sideBar->getHTML();
        $this->addSideBarContent( $sideBarContent );
        
         
        // Add any necessary javascripts for this page:
        switch( $this->page ) {
        
/*[RAD_PAGE_JAVASCRIPTS]*/
             case moduleAccountAdmin::PAGE_ACCOUNTLIST:
                $this->addScript('MM_jumpMenu.jsp');
                break;

        }
        
	}
	
	
	
    //************************************************************************
	/**
	 * function getCallBack
	 * <pre>
	 * Builds the proper HREF link for a desired action.
	 * </pre>
	 *
	 * @param $page [STRING] The Desired PAGE of this Link.
	 * @param $sortBy [STRING] The Desired Sort Field for this link.
	 * @param $accountGroupID [INTEGER] The Desired ACCOUNTGROUPID of this Link.
	 * @param $viewerID [INTEGER] The Desired VIEWERID of this Link.
	 * @param $accessCategoryID [INTEGER] The Desired ACCESSCATEGORYID of this Link.
	 * @param $accessGroupID [INTEGER] The Desired ACCESSGROUPID of this Link.
	 * @param $languageID [INTEGER] The Desired LANGUAGEID of this Link.
[RAD_CALLBACK_DOC]
	 * @return [STRING] The Link.
	 */
    function getCallBack($page='', $sortBy='', $accountGroupID='', $viewerID='', $accessCategoryID='', $accessGroupID='', $languageID='', $viewerAccessGroupID='', $accessPrivID='')//RAD_CALLBACK_PARAM
    {
        // NOTE: the RAD tools need the //RAD_CALLBACK_PARAM to be right next
        // to the ending ")" of the function to properly update this function.
        
        $returnValue = $this->baseCallBack;
        
        $callBack = '';
        
        if ($page != '') {
            $callBack = moduleAccountAdmin::PAGE.'='.$page;
        }
        
        if ($sortBy != '') {
            if ($callBack != '') {
                $callBack .= '&';
            }
            $callBack .= moduleAccountAdmin::SORTBY.'='.$sortBy;
        }
        
        
        if ($accountGroupID != '') {
            if ($callBack != '') {
                $callBack .= '&';
            }
            $callBack .= moduleAccountAdmin::ACCOUNTGROUPID.'='.$accountGroupID;
        }

        if ($viewerID != '') {
            if ($callBack != '') {
                $callBack .= '&';
            }
            $callBack .= moduleAccountAdmin::VIEWERID.'='.$viewerID;
        }

        if ($accessCategoryID != '') {
            if ($callBack != '') {
                $callBack .= '&';
            }
            $callBack .= moduleAccountAdmin::ACCESSCATEGORYID.'='.$accessCategoryID;
        }

        if ($accessGroupID != '') {
            if ($callBack != '') {
                $callBack .= '&';
            }
            $callBack .= moduleAccountAdmin::ACCESSGROUPID.'='.$accessGroupID;
        }

        if ($languageID != '') {
            if ($callBack != '') {
                $callBack .= '&';
            }
            $callBack .= moduleAccountAdmin::LANGUAGEID.'='.$languageID;
        }

        if ($viewerAccessGroupID != '') {
            if ($callBack != '') {
                $callBack .= '&';
            }
            $callBack .= moduleAccountAdmin::VIEWERACCESSGROUPID.'='.$viewerAccessGroupID;
        }

        if ($accessPrivID != '') {
            if ($callBack != '') {
                $callBack .= '&';
            }
            $callBack .= moduleAccountAdmin::ACCESSPRIVID.'='.$accessPrivID;
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
	 * <pre>
	 * Returns the value of the Multilingual Series Key
	 * </pre>
	 * @return [STRING]
	 */
    function getMultilingualSeriesKey() 
    {
        return moduleAccountAdmin::MULTILINGUAL_SERIES_KEY;
    }	

    
    
    //************************************************************************
	/**
	 * function loadAccountList
	 * <pre>
	 * Initializes the AccountList Page.
	 * </pre>
	 * @return [void]
	 */
    // RAD Tools: DataListTable Style
    function loadAccountList() 
    {
        $this->pageDisplay = new page_AccountList( $this->moduleRootPath, $this->viewer, $this->sortBy, $this->accountGroupID );
        
        $links = array();
        
        $addLink = $this->getCallBack( moduleAccountAdmin::PAGE_ADDVIEWER, $this->sortBy , $this->accountGroupID, $this->viewerID, $this->accessCategoryID, $this->accessGroupID, $this->languageID);//[RAD_CALLBACK_PARAMS]
        $links["add"] = $addLink;

        $editLink = $this->getCallBack( moduleAccountAdmin::PAGE_EDITVIEWER, $this->sortBy , $this->accountGroupID, "", $this->accessCategoryID, $this->accessGroupID, $this->languageID);//[RAD_CALLBACK_PARAMS_EDIT]
        $editLink .= "&". moduleAccountAdmin::VIEWERID . "=";
        $links["edit"] = $editLink;

        $delLink = $this->getCallBack( moduleAccountAdmin::PAGE_DELETEVIEWER, $this->sortBy , $this->accountGroupID, "", $this->accessCategoryID, $this->accessGroupID, $this->languageID);//[RAD_CALLBACK_PARAMS_EDIT]
        $delLink .= "&". moduleAccountAdmin::VIEWERID . "=";
        $links["del"] = $delLink;
        
        $passwordLink = $this->getCallBack( moduleAccountAdmin::PAGE_EDITPASSWORD, $this->sortBy , "", "", "", "", "");//[RAD_CALLBACK_PARAMS_EDIT]
        $passwordLink .= "&". moduleAccountAdmin::VIEWERID . "=";
        $links["passWord"] = $passwordLink;

        $accessLink = $this->getCallBack( moduleAccountAdmin::PAGE_ACCOUNTACCESS, $this->sortBy , "", "", "", "", "");//[RAD_CALLBACK_PARAMS_EDIT]
        $accessLink .= "&". moduleAccountAdmin::VIEWERID . "=";
        $links["accessLink"] = $accessLink;
        
        $jumpLink = $this->getCallBack( moduleAccountAdmin::PAGE_ACCOUNTLIST, $this->sortBy, '', '', '', '', '', '' );//[RAD_CALLBACK_PARAMS_EDIT]
        $jumpLink .= "&". moduleAccountAdmin::ACCOUNTGROUPID . "=";
        $links["jumpLink"] = $jumpLink;
        
        
/*[RAD_LINK_INSERT]*/

        $sortByLink = $this->getCallBack( moduleAccountAdmin::PAGE_ACCOUNTLIST, '' , $this->accountGroupID, $this->viewerID, $this->accessCategoryID, $this->accessGroupID, $this->languageID);//[RAD_CALLBACK_PARAMS]
        $sortByLink .= "&".moduleAccountAdmin::SORTBY."=";
        $links["sortBy"] = $sortByLink;

        $this->pageDisplay->setLinks( $links ); 
        
        
        $this->addScript('MM_jumpMenu.jsp');
        
    } // end loadAccountList()



    //************************************************************************
	/**
	 * function loadAddViewer
	 * <pre>
	 * Initializes the AddViewer Page.
	 * </pre>
	 * @return [void]
	 */
    function loadAddViewer() 
    {
        
        $formAction = $this->getCallBack(moduleAccountAdmin::PAGE_ADDVIEWER, $this->sortBy , $this->accountGroupID, $this->viewerID, $this->accessCategoryID, $this->accessGroupID, $this->languageID);//[RAD_CALLBACK_PARAMS]
        
        // if accountGroupID is not set then set to the viewer's ID
        //
        if ($this->accountGroupID == '') {
            $this->accountGroupID = $this->viewer->getAccountGroupID();
        }
        
        $this->pageDisplay = new FormProcessor_AddViewer( $this->moduleRootPath, $this->viewer, $formAction, $this->viewerID , $this->accountGroupID);//[RAD_FORMINIT_FOREIGNKEY_INIT]        
        
    } // end loadAddViewer()



    //************************************************************************
	/**
	 * function loadEditViewer
	 * <pre>
	 * Initializes the EditViewer Page.
	 * </pre>
	 * @return [void]
	 */
    function loadEditViewer() 
    {
        
        $formAction = $this->getCallBack(moduleAccountAdmin::PAGE_EDITVIEWER, $this->sortBy , $this->accountGroupID, $this->viewerID, $this->accessCategoryID, $this->accessGroupID, $this->languageID);//[RAD_CALLBACK_PARAMS]
        $this->pageDisplay = new FormProcessor_EditViewer( $this->moduleRootPath, $this->viewer, $formAction, $this->viewerID , $this->accountGroupID);//[RAD_FORMINIT_FOREIGNKEY_INIT]        
        
    } // end loadEditViewer()



    //************************************************************************
	/**
	 * function loadEditPassword
	 * <pre>
	 * Initializes the EditPassword Page.
	 * </pre>
	 * @return [void]
	 */
    function loadEditPassword() 
    {
        
        $formAction = $this->getCallBack(moduleAccountAdmin::PAGE_EDITPASSWORD, $this->sortBy , $this->accountGroupID, $this->viewerID, $this->accessCategoryID, $this->accessGroupID, $this->languageID);//[RAD_CALLBACK_PARAMS]
        $this->pageDisplay = new FormProcessor_EditPassword( $this->moduleRootPath, $this->viewer, $formAction, $this->viewerID , $this->accountGroupID);//[RAD_FORMINIT_FOREIGNKEY_INIT]
        
    } // end loadEditPassword()



    //************************************************************************
	/**
	 * function PasswordChanged
	 * <pre>
	 * Loads the password changed confirmation page.
	 * </pre>
	 * @return [void]
	 */
    // RAD Tools: Custom style
    function loadPasswordChanged()
    {
        $this->pageDisplay = new page_PasswordChanged( $this->moduleRootPath, $this->viewer, $this->viewerID );

        //Add a Continue link to take admins back to the User List page.
        if (( $this->accessPrivManager->hasGroupPriv() ) || ($this->accessPrivManager->hasSitePriv()) ) {
        $links = array();
        $continueLink = $this->getCallBack( moduleAccountAdmin::PAGE_ACCOUNTLIST );
        $links["cont"] = $continueLink;
        $this->pageDisplay->setLinks( $links );
        }

    } // end loadPasswordChanged()



    //************************************************************************
	/**
	 * function loadDeleteViewer
	 * <pre>
	 * Initializes the DeleteViewer Page.
	 * </pre>
	 * @return [void]
	 */
    function loadDeleteViewer() 
    {
        
        $formAction = $this->getCallBack(moduleAccountAdmin::PAGE_DELETEVIEWER, $this->sortBy , $this->accountGroupID, $this->viewerID, $this->accessCategoryID, $this->accessGroupID, $this->languageID);//[RAD_CALLBACK_PARAMS]
        $this->pageDisplay = new page_DeleteViewer( $this->moduleRootPath, $this->viewer, $formAction, $this->viewerID );
                
    } // end loadDeleteViewer()



    //************************************************************************
	/**
	 * function loadAccessCategories
	 * <pre>
	 * Initializes the AccessCategories Page.
	 * </pre>
	 * @return [void]
	 */
    // RAD Tools: AdminBox Style
    function loadAccessCategories() 
    {
        $pageCallBack = $this->getCallBack(moduleAccountAdmin::PAGE_ACCESSCATEGORIES, $this->sortBy);
        $this->setPageCallBack( $pageCallBack );
        
        $formAction = $this->getCallBack(moduleAccountAdmin::PAGE_ACCESSCATEGORIES, $this->sortBy , $this->accountGroupID, $this->viewerID, $this->accessCategoryID, $this->accessGroupID, $this->languageID);//[RAD_CALLBACK_PARAMS]
        $this->pageDisplay = new FormProcessor_AccessCategories( $this->moduleRootPath, $this->viewer, $formAction, $this->sortBy,  $this->accessCategoryID );//[RAD_FORMINIT_FOREIGNKEY_INIT]    
        
        $links = array();
        
        $editLink = $this->getCallBack( moduleAccountAdmin::PAGE_ACCESSCATEGORIES, $this->sortBy );//[RAD_CALLBACK_PARAMS_EDIT]
        $editLink .= "&". moduleAccountAdmin::ACCESSCATEGORYID . "=";
        $links[ "edit" ] = $editLink;
        
        // NOTE: delete link is same as edit link for an AdminBox
        $links[ "del" ] = $editLink;

/*[RAD_LINK_INSERT]*/

        $groupLink = $this->getCallBack( moduleAccountAdmin::PAGE_ACCESSGROUP );//[RAD_CALLBACK_PARAMS_EDIT]
        $groupLink .= "&". moduleAccountAdmin::ACCESSCATEGORYID . "=";
        $links[ "groups" ] = $groupLink;

        $sortByLink = $this->getCallBack( moduleAccountAdmin::PAGE_ACCESSCATEGORIES, '' , $this->accountGroupID, $this->viewerID, $this->accessCategoryID, $this->accessGroupID, $this->languageID);//[RAD_CALLBACK_PARAMS]
        $sortByLink .= "&".moduleAccountAdmin::SORTBY."=";
        $links["sortBy"] = $sortByLink;

        $this->pageDisplay->setLinks( $links );    
        
    } // end loadAccessCategories()



    //************************************************************************
	/**
	 * function loadAccessGroup
	 * <pre>
	 * Initializes the AccessGroup Page.
	 * </pre>
	 * @return [void]
	 */
    // RAD Tools: AdminBox Style
    function loadAccessGroup() 
    {
        
        $formAction = $this->getCallBack(moduleAccountAdmin::PAGE_ACCESSGROUP, $this->sortBy , $this->accountGroupID, $this->viewerID, $this->accessCategoryID, $this->accessGroupID, $this->languageID);//[RAD_CALLBACK_PARAMS]
        
        $this->setPageCallBack( $formAction );
        
        $this->pageDisplay = new FormProcessor_AccessGroup( $this->moduleRootPath, $this->viewer, $formAction, $this->sortBy,  $this->accessGroupID, $this->accessCategoryID );//[RAD_FORMINIT_FOREIGNKEY_INIT]    
        
        $links = array();
        
        $continueLink = $this->getCallBack( moduleAccountAdmin::PAGE_ACCESSCATEGORIES, "" , "", "", "", "", "");//[RAD_CALLBACK_PARAMS]
        $links["cont"] = $continueLink;

        $editLink = $this->getCallBack( moduleAccountAdmin::PAGE_ACCESSGROUP, $this->sortBy, '', '', $this->accessCategoryID );//[RAD_CALLBACK_PARAMS_EDIT]
        $editLink .= "&". moduleAccountAdmin::ACCESSGROUPID . "=";
        $links[ "edit" ] = $editLink;
        
        // NOTE: delete link is same as edit link for an AdminBox
        $links[ "del" ] = $editLink;

/*[RAD_LINK_INSERT]*/

        $sortByLink = $this->getCallBack( moduleAccountAdmin::PAGE_ACCESSGROUP, '' , $this->accountGroupID, $this->viewerID, $this->accessCategoryID, $this->accessGroupID, $this->languageID);//[RAD_CALLBACK_PARAMS]
        $sortByLink .= "&".moduleAccountAdmin::SORTBY."=";
        $links["sortBy"] = $sortByLink;

        $this->pageDisplay->setLinks( $links );    
        
    } // end loadAccessGroup()



    //************************************************************************
	/**
	 * function loadLanguageList
	 * <pre>
	 * Initializes the LanguageList Page.
	 * </pre>
	 * @return [void]
	 */
    // RAD Tools: AdminBox Style
    function loadLanguageList() 
    {
        $formAction = $this->getCallBack(moduleAccountAdmin::PAGE_LANGUAGELIST, $this->sortBy , $this->accountGroupID, $this->viewerID, $this->accessCategoryID, $this->accessGroupID, $this->languageID);//[RAD_CALLBACK_PARAMS]
        
        $this->setPageCallBack( $formAction );
        
        $this->pageDisplay = new FormProcessor_LanguageList( $this->moduleRootPath, $this->viewer, $formAction, $this->sortBy,  $this->languageID );//[RAD_FORMINIT_FOREIGNKEY_INIT]    
        
        $links = array();
        
        $editLink = $this->getCallBack( moduleAccountAdmin::PAGE_LANGUAGELIST, $this->sortBy );//[RAD_CALLBACK_PARAMS_EDIT]
        $editLink .= "&". moduleAccountAdmin::LANGUAGEID . "=";
        $links[ "edit" ] = $editLink;
        
        // NOTE: delete link is same as edit link for an AdminBox
        $links[ "del" ] = $editLink;

/*[RAD_LINK_INSERT]*/

        $sortByLink = $this->getCallBack( moduleAccountAdmin::PAGE_LANGUAGELIST, '' , $this->accountGroupID, $this->viewerID, $this->accessCategoryID, $this->accessGroupID, $this->languageID);//[RAD_CALLBACK_PARAMS]
        $sortByLink .= "&".moduleAccountAdmin::SORTBY."=";
        $links["sortBy"] = $sortByLink;

        $this->pageDisplay->setLinks( $links );    
        
    } // end loadLanguageList()



    //************************************************************************
	/**
	 * function loadAccountAccess
	 * <pre>
	 * Initializes the AccountAccess Page.
	 * </pre>
	 * @return [void]
	 */
    // RAD Tools: AdminBox Style
    function loadAccountAccess() 
    {
        
        $formAction = $this->getCallBack(moduleAccountAdmin::PAGE_ACCOUNTACCESS, $this->sortBy , $this->accountGroupID, $this->viewerID, $this->accessCategoryID, $this->accessGroupID, $this->languageID, $this->viewerAccessGroupID);//[RAD_CALLBACK_PARAMS]
        
        $this->setPageCallBack( $formAction );
        $this->pageDisplay = new form_AccountAccess( $this->moduleRootPath, $this->viewer, $formAction, $this->sortBy,  $this->viewerID );//[RAD_FORMINIT_FOREIGNKEY_INIT]    
        
        $links = array();
        
        $editLink = $this->getCallBack( moduleAccountAdmin::PAGE_ACCOUNTACCESS, $this->sortBy, $this->accountGroupID, $this->viewerID, $this->accessCategoryID, $this->accessGroupID, $this->languageID, '' );//[RAD_CALLBACK_PARAMS_EDIT]
        $editLink .= "&". moduleAccountAdmin::VIEWERACCESSGROUPID . "=";
        
        // NOTE: on this page, "edit"ing an entry doesn't make since.  We 
        // just Add & Delete.
//        $links[ "edit" ] = $editLink;
        
        // NOTE: delete link is same as edit link for an AdminBox
        $links[ "del" ] = $editLink;

/*[RAD_LINK_INSERT]*/

        $sortByLink = $this->getCallBack( moduleAccountAdmin::PAGE_ACCOUNTACCESS, '' , $this->accountGroupID, $this->viewerID, $this->accessCategoryID, $this->accessGroupID, $this->languageID);//[RAD_CALLBACK_PARAMS]
        $sortByLink .= "&".moduleAccountAdmin::SORTBY."=";
        $links["sortBy"] = $sortByLink;

        $this->pageDisplay->setLinks( $links );    
        
    } // end loadAccountAccess()



    //************************************************************************
	/**
	 * function loadAccountGroup
	 * <pre>
	 * Initializes the AccountGroup Page.
	 * </pre>
	 * @return [void]
	 */
    // RAD Tools: AdminBox Style
    function loadAccountGroup() 
    {
        
        $formAction = $this->getCallBack(moduleAccountAdmin::PAGE_ACCOUNTGROUP, $this->sortBy , $this->accountGroupID, $this->viewerID, $this->accessCategoryID, $this->accessGroupID, $this->languageID, $this->viewerAccessGroupID);//[RAD_CALLBACK_PARAMS]
        $this->setPageCallBack( $formAction );
        
        $this->pageDisplay = new form_AccountGroup( $this->moduleRootPath, $this->viewer, $formAction, $this->sortBy,  $this->accountGroupID );//[RAD_FORMINIT_FOREIGNKEY_INIT]    
        
        $links = array();
        
        $editLink = $this->getCallBack( moduleAccountAdmin::PAGE_ACCOUNTGROUP, $this->sortBy, '', '', '', '', '', '' );//[RAD_CALLBACK_PARAMS_EDIT]
        $editLink .= "&". moduleAccountAdmin::ACCOUNTGROUPID . "=";
        
        // NOTE: on this page, "edit"ing an entry doesn't make since.  We 
        // just Add & Delete.
        $links[ "edit" ] = $editLink;
        
        // NOTE: delete link is same as edit link for an AdminBox
        $links[ "del" ] = $editLink;

/*[RAD_LINK_INSERT]*/

        $sortByLink = $this->getCallBack( moduleAccountAdmin::PAGE_ACCOUNTGROUP, '' , $this->accountGroupID, $this->viewerID, $this->accessCategoryID, $this->accessGroupID, $this->languageID);//[RAD_CALLBACK_PARAMS]
        $sortByLink .= "&".moduleAccountAdmin::SORTBY."=";
        $links["sortBy"] = $sortByLink;

        $this->pageDisplay->setLinks( $links );    
        
    } // end loadAccountGroup()



    //************************************************************************
	/**
	 * function loadAccessPriv
	 * <pre>
	 * Initializes the AccessPriv Page.
	 * </pre>
	 * @return [void]
	 */
    // RAD Tools: AdminBox Style
    function loadAccessPriv() 
    {
        
        $formAction = $this->getCallBack(moduleAccountAdmin::PAGE_ACCESSPRIV, $this->sortBy , $this->accountGroupID, $this->viewerID, $this->accessCategoryID, $this->accessGroupID, $this->languageID, $this->viewerAccessGroupID, $this->accessPrivID );//[RAD_CALLBACK_PARAMS]
        
        $this->setPageCallBack( $formAction );
        
        $this->pageDisplay = new FormProcessor_AdminPriv( $this->moduleRootPath, $this->viewer, $this->accessPrivManager, $formAction, $this->sortBy,  $this->accessPrivID );//[RAD_FORMINIT_FOREIGNKEY_INIT]    
        
        $links = array();
        
        $editLink = $this->getCallBack( moduleAccountAdmin::PAGE_ACCESSPRIV, $this->sortBy, '', '', '', '', '', '' );//[RAD_CALLBACK_PARAMS_EDIT]
        $editLink .= "&". moduleAccountAdmin::ACCESSPRIVID . "=";
        
        // NOTE: on this page, "edit"ing an entry doesn't make since.  We 
        // just Add & Delete.
        $links[ "edit" ] = $editLink;
        
        // NOTE: delete link is same as edit link for an AdminBox
        $links[ "del" ] = $editLink;

/*[RAD_LINK_INSERT]*/

        $sortByLink = $this->getCallBack( moduleAccountAdmin::PAGE_ACCESSPRIV, '' , $this->accountGroupID, $this->viewerID, $this->accessCategoryID, $this->accessGroupID, $this->languageID, $this->viewerAccessGroupID, $this->accessPrivID);//[RAD_CALLBACK_PARAMS]
        $sortByLink .= "&".moduleAccountAdmin::SORTBY."=";
        $links["sortBy"] = $sortByLink;

        $this->pageDisplay->setLinks( $links );    
        
    } // end loadAccessPriv()
    
    
    
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

        //All viewers(users) can access this link to change their password.
        $requestLink = $this->getCallBack( moduleAccountAdmin::PAGE_EDITPASSWORD, '' , '', '', '', '', '');
        $links[ '[changeYourPassword]' ] = $requestLink;

        // all admins can access this link
        if (( $this->accessPrivManager->hasGroupPriv() ) || ($this->accessPrivManager->hasSitePriv()) ) {

            $requestLink = $this->getCallBack( moduleAccountAdmin::PAGE_ACCOUNTLIST, '' , '', '', '', '', '');
            $links[ '[accountList]' ] = $requestLink;
            $requestLink = $this->getCallBack( moduleAccountAdmin::PAGE_ACCESSPRIV, '' , '', '', '', '', '');
            $links[ '[accountAdminAccessPriv]' ] = $requestLink;
            
        }
        
        // these links reserved for Site Admins
        if ( $this->accessPrivManager->hasSitePriv() ) {
            
            $requestLink = $this->getCallBack( moduleAccountAdmin::PAGE_ACCOUNTGROUP, '' , '', '', '', '', '');
            $links[ '[accountGroup]' ] = $requestLink;

            $requestLink = $this->getCallBack( moduleAccountAdmin::PAGE_ACCESSCATEGORIES, '' , '', '', '', '', '');
            $links[ '[accessCatagories]' ] = $requestLink;
            
            $requestLink = $this->getCallBack( moduleAccountAdmin::PAGE_LANGUAGELIST, '' , '', '', '', '', '');
            $links[ '[languageList]' ] = $requestLink;

            
        }
             
         
        $this->sideBar->setLinks( $links );
         
        
    } // end loadSideBar()



/*[RAD_PAGE_LOAD_FN]*/		

}

?>