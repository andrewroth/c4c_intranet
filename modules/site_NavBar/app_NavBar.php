<?php
/**
 * @package NavBar
 */
/*!
 @class moduleNavBar
 @discussion <pre>
 Written By	:	Johnny Hausman
 Date		:   23 Aug 2005
 
 This module manages the navbar information for the site.
 
 </pre>	
*/
class moduleNavBar extends XMLObject_PageContent {
// 		
//
//	CONSTANTS:

        
    /*! const MULTILINGUAL_SERIES_KEY The Multilingual Series key for this application.. */
        const MULTILINGUAL_SERIES_KEY = 'moduleNavBar';
        
    /*! const MULTILINGUAL_PAGE_FIELDS The Multilingual Page key for the fields of this application. */
        const MULTILINGUAL_PAGE_FIELDS = 'fields_NavBar';
        
    /*! const MODULE_KEY The Module Key for this Module.  Used for access */
        const MODULE_KEY = 'NavBar';
        
    /*! const PAGE    The QueryString Page parameter. */
        const PAGE = "P";
        
    /*! const PAGE_GROUPLIST   Display the GroupList Page. */
        const PAGE_GROUPLIST = "P9";

    /*! const PAGE_LINKLIST   Display the LinkList Page. */
        const PAGE_LINKLIST = "P10";

    /*! const PAGE_LINKGROUPS   Display the LinkGroups Page. */
        const PAGE_LINKGROUPS = "P11";

    /*! const PAGE_LINKVIEWER   Display the LinkViewer Page. */
        const PAGE_LINKVIEWER = "P12";

/*[RAD_PAGE_CONST]*/

    /*! const SORTBY    The QueryString SortBy parameter. */
        const SORTBY = "modSort";
                

    /*! const GROUPID   The QueryString GROUPID parameter. */
        const GROUPID = "SV2";

    /*! const LINKID   The QueryString LINKID parameter. */
        const LINKID = "SV3";

    /*! const LINKGROUPID   The QueryString LINKGROUPID parameter. */
        const LINKGROUPID = "SV41";

    /*! const LINKVIEWERID   The QueryString LINKVIEWERID parameter. */
        const LINKVIEWERID = "SV42";

/*[RAD_PAGE_STATEVAR_CONST]*/
        
        
//
//	VARIABLES:
        
    /*! protected $page   [STRING] The current Mode of this Module. */
		protected $page;
		
    /*! protected $sortBy [STRING] Parameter to sort displayed Lists. */
        protected $sortBy;
		
    /*! protected $groupID   [INTEGER] The Unique ID of the group we are working with. */
		protected $groupID;

    /*! protected $linkID   [INTEGER] The Unique ID of the link we are working with. */
		protected $linkID;

    /*! protected $linkGroupID   [INTEGER] The Unique ID of the link<->group we are working with */
		protected $linkGroupID;

    /*! protected $linkViewerID   [INTEGER] The Unique ID of the link<->Viewer we are working with */
		protected $linkViewerID;

/*[RAD_PAGE_STATEVAR_VAR]*/
		
   
    /*! protected $pageDisplay [OBJECT] The display object for the page. */
        protected $pageDisplay;
        
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
//        $this->appID = $this->getQSValue( moduleNavBar::APPID, '' );
        
/*[RAD_COMMON_LOAD]*/
         
        // load the module's page (DEFAULT = WELCOME)
        $this->page = $this->getQSValue( moduleNavBar::PAGE, moduleNavBar::PAGE_GROUPLIST );
        
        // load the module's sortBy parameter (DEFAULT = '')
        $this->sortBy = $this->getQSValue( moduleNavBar::SORTBY, '' );
        
        // load the module's GROUPID variable
        $this->groupID = $this->getQSValue( moduleNavBar::GROUPID, "" );

        // load the module's LINKID variable
        $this->linkID = $this->getQSValue( moduleNavBar::LINKID, "" );

        // load the module's LINKGROUPID variable
        $this->linkGroupID = $this->getQSValue( moduleNavBar::LINKGROUPID, "" );

        // load the module's LINKVIEWERID variable
        $this->linkViewerID = $this->getQSValue( moduleNavBar::LINKVIEWERID, "" );

/*[RAD_PAGE_LOAD_STATEVAR]*/
        
        switch( $this->page ) {
                
            /*
             *  GroupList
             */
            case moduleNavBar::PAGE_GROUPLIST:
                $this->loadGroupList();
                break;

            /*
             *  LinkList
             */
            case moduleNavBar::PAGE_LINKLIST:
                $this->loadLinkList();
                break;

            /*
             *  LinkGroups
             */
            case moduleNavBar::PAGE_LINKGROUPS:
                $this->loadLinkGroups();
                break;

            /*
             *  LinkViewer
             */
            case moduleNavBar::PAGE_LINKVIEWER:
                $this->loadLinkViewer();
                break;

/*[RAD_PAGE_LOAD_CALL]*/
   
                 
            /*
             *  Just to make sure, default the pageDisplay to 
             *  the GroupList page.
             */
            default:
                $this->page = moduleNavBar::PAGE_GROUPLIST;
                $this->loadGroupList();
                break;
        
        }
        
        
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
                
                // now update the viewers Cache info
                $this->loadCache();
            
                // now switch to the proper next page ...
                switch( $this->page ) {
    
                    case moduleNavBar::PAGE_GROUPLIST:
                        // NOTE: after a successful submit on an AdminBox style
                        // form, set the managerInit variable back to ''
                        $this->groupID = '';
                        $this->loadGroupList( true );                     
                        break;

                    case moduleNavBar::PAGE_LINKLIST:
                        // NOTE: after a successful submit on an AdminBox style
                        // form, set the managerInit variable back to ''
                        $this->linkID = '';
                        $this->loadLinkList( true );                     
                        break;

                    case moduleNavBar::PAGE_LINKGROUPS:
                        // NOTE: after a successful submit on an AdminBox style
                        // form, set the managerInit variable back to ''
                        $this->linkGroupID = '';
                        $this->loadLinkGroups( true );                     
                        break;

                    case moduleNavBar::PAGE_LINKVIEWER:
                        // NOTE: after a successful submit on an AdminBox style
                        // form, set the managerInit variable back to ''
                        $this->linkViewerID = '';
                        $this->loadLinkViewer( true );                     
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
        
         
        // Add any necessary javascripts for this page:
        switch( $this->page ) {
        
/*[RAD_PAGE_JAVASCRIPTS]*/
//             case moduleNavBar::PAGE_DEFAULT:
//                $this->addScript('MM_jumpMenu.jsp');
//                break;

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
	 * @param $parameters [ARRAY] An array of parameterName=>Value pairs 
	 * possible parameter values :
	 * 'groupID' [INTEGER] The Desired GROUPID of this Link.
	 * 'linkID' [INTEGER] The Desired LINKID of this Link.
	 * 'linkGroupID' [INTEGER] The Desired LINKGROUPID of this Link.
	 * 'linkViewerID' [INTEGER] The Desired LINKVIEWERID of this Link.
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
            $callBack = moduleNavBar::PAGE.'='.$page;
        }
        
        if ($sortBy != '') {
            if ($callBack != '') {
                $callBack .= '&';
            }
            $callBack .= moduleNavBar::SORTBY.'='.$sortBy;
        }
        
        
        if ( isset( $parameters['groupID']) ) {
            if ( $parameters['groupID'] != '' ) {
                if ($callBack != '') {
                    $callBack .= '&';
                }
                $callBack .= moduleNavBar::GROUPID.'='.$parameters['groupID'];
            }
        }

        if ( isset( $parameters['linkID']) ) {
            if ( $parameters['linkID'] != '' ) {
                if ($callBack != '') {
                    $callBack .= '&';
                }
                $callBack .= moduleNavBar::LINKID.'='.$parameters['linkID'];
            }
        }

        if ( isset( $parameters['linkGroupID']) ) {
            if ( $parameters['linkGroupID'] != '' ) {
                if ($callBack != '') {
                    $callBack .= '&';
                }
                $callBack .= moduleNavBar::LINKGROUPID.'='.$parameters['linkGroupID'];
            }
        }

        if ( isset( $parameters['linkViewerID']) ) {
            if ( $parameters['linkViewerID'] != '' ) {
                if ($callBack != '') {
                    $callBack .= '&';
                }
                $callBack .= moduleNavBar::LINKVIEWERID.'='.$parameters['linkViewerID'];
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
	 * function loadGroupList
	 * <pre>
	 * Initializes the GroupList Page.
	 * </pre>
	 * @param $isCreated [BOOL] "Is THIS pageDisplay object already created?"
	 * @return [void]
	 */
    // RAD Tools: AdminBox Style
    function loadGroupList( $isCreated=false ) 
    {        
        
        $parameters = array('groupID'=>$this->groupID, 'linkID'=>$this->linkID, 'linkGroupID'=>$this->linkGroupID, 'linkViewerID'=>$this->linkViewerID);//[RAD_CALLBACK_PARAMS]
        $formAction = $this->getCallBack(moduleNavBar::PAGE_GROUPLIST, $this->sortBy, $parameters );
        
        $this->setPageCallBack( $formAction );
        
        // if this pageDisplay object isn't already created then 
        if ( !$isCreated ) {
        
            // create a new pageDisplay object
            $this->pageDisplay = new FormProcessor_GroupList( $this->moduleRootPath, $this->viewer, $formAction, $this->sortBy,  $this->groupID );//[RAD_FORMINIT_FOREIGNKEY_INIT]    
        
        } else {
        
            // otherwise just update the formAction value
            $this->pageDisplay->setFormAction( $formAction );
        }
        
        $links = array();
        
//        $parameters = array( 'groupID'=>$this->groupID, 'linkID'=>$this->linkID, 'linkGroupID'=>$this->linkGroupID, 'linkViewerID'=>$this->linkViewerID);//[RAD_CALLBACK_PARAMS]
//        $continueLink = $this->getCallBack( moduleNavBar::PAGE_GROUPLIST, "", $parameters );
//        $links["cont"] = $continueLink;

        $parameters = array( );//[RAD_CALLBACK_PARAMS_EDIT]
        $editLink = $this->getCallBack( moduleNavBar::PAGE_GROUPLIST, $this->sortBy, $parameters );
        $editLink .= "&". moduleNavBar::GROUPID . "=";
        $links[ "edit" ] = $editLink;
        
        // NOTE: delete link is same as edit link for an AdminBox
        $links[ "del" ] = $editLink;

/*[RAD_LINK_INSERT]*/

        $parameters = array('groupID'=>$this->groupID, 'linkID'=>$this->linkID, 'linkGroupID'=>$this->linkGroupID, 'linkViewerID'=>$this->linkViewerID);//[RAD_CALLBACK_PARAMS]
        $sortByLink = $this->getCallBack( moduleNavBar::PAGE_GROUPLIST, '', $parameters );
        $sortByLink .= "&".moduleNavBar::SORTBY."=";
        $links["sortBy"] = $sortByLink;
        
        $parameters = array( 'linkID'=>$this->linkID, 'linkGroupID'=>$this->linkGroupID, 'linkViewerID'=>$this->linkViewerID);//[RAD_CALLBACK_PARAMS]
        $viewLink = $this->getCallBack( moduleNavBar::PAGE_LINKLIST, '', $parameters );
        $viewLink .= "&".moduleNavBar::GROUPID."=";
        $links["viewLink"] = $viewLink;
        

        $this->pageDisplay->setLinks( $links );    
        
    } // end loadGroupList()



    //************************************************************************
	/**
	 * function loadLinkList
	 * <pre>
	 * Initializes the LinkList Page.
	 * </pre>
	 * @param $isCreated [BOOL] "Is THIS pageDisplay object already created?"
	 * @return [void]
	 */
    // RAD Tools: AdminBox Style
    function loadLinkList( $isCreated=false ) 
    {
        $parameters = array('groupID'=>$this->groupID, 'linkID'=>$this->linkID, 'linkGroupID'=>$this->linkGroupID, 'linkViewerID'=>$this->linkViewerID);//[RAD_CALLBACK_PARAMS]
        $formAction = $this->getCallBack(moduleNavBar::PAGE_LINKLIST, $this->sortBy, $parameters );
        
        $this->setPageCallBack( $formAction );
        
        // if this pageDisplay object isn't already created then 
        if ( !$isCreated ) {
        
            // create a new pageDisplay object
            $this->pageDisplay = new FormProcessor_LinkList( $this->moduleRootPath, $this->viewer, $formAction, $this->sortBy,  $this->linkID, $this->groupID );//[RAD_FORMINIT_FOREIGNKEY_INIT]    
        
        } else {
        
            // otherwise just update the formAction value
            $this->pageDisplay->setFormAction( $formAction );
        }
        
        $links = array();
        
        $parameters = array();//[RAD_CALLBACK_PARAMS]
        $continueLink = $this->getCallBack( moduleNavBar::PAGE_GROUPLIST, "", $parameters );
        $links["cont"] = $continueLink;

        $parameters = array( 'groupID'=>$this->groupID );//[RAD_CALLBACK_PARAMS_EDIT]
        $editLink = $this->getCallBack( moduleNavBar::PAGE_LINKLIST, $this->sortBy, $parameters );
        $editLink .= "&". moduleNavBar::LINKID . "=";
        $links[ "edit" ] = $editLink;
        
        // NOTE: delete link is same as edit link for an AdminBox
        $links[ "del" ] = $editLink;

/*[RAD_LINK_INSERT]*/

        $parameters = array( 'groupID'=>$this->groupID );//[RAD_CALLBACK_PARAMS_EDIT]
        $groupLink = $this->getCallBack( moduleNavBar::PAGE_LINKGROUPS, $this->sortBy, $parameters );
        $groupLink .= "&". moduleNavBar::LINKID . "=";
        $links[ "accessGroups" ] = $groupLink;
        
        $parameters = array( 'groupID'=>$this->groupID );//[RAD_CALLBACK_PARAMS_EDIT]
        $viewerLink = $this->getCallBack( moduleNavBar::PAGE_LINKVIEWER, $this->sortBy, $parameters );
        $viewerLink .= "&". moduleNavBar::LINKID . "=";
        $links[ "viewers" ] = $viewerLink;
        

        $parameters = array('groupID'=>$this->groupID, 'linkID'=>$this->linkID, 'linkGroupID'=>$this->linkGroupID, 'linkViewerID'=>$this->linkViewerID);//[RAD_CALLBACK_PARAMS]
        $sortByLink = $this->getCallBack( moduleNavBar::PAGE_LINKLIST, '', $parameters );
        $sortByLink .= "&".moduleNavBar::SORTBY."=";
        $links["sortBy"] = $sortByLink;

        $this->pageDisplay->setLinks( $links );    
        
    } // end loadLinkList()



    //************************************************************************
	/**
	 * function loadLinkGroups
	 * <pre>
	 * Initializes the LinkGroups Page.
	 * </pre>
	 * @param $isCreated [BOOL] "Is THIS pageDisplay object already created?"
	 * @return [void]
	 */
    // RAD Tools: AdminBox Style
    function loadLinkGroups( $isCreated=false ) 
    {
        $parameters = array('groupID'=>$this->groupID, 'linkID'=>$this->linkID, 'linkGroupID'=>$this->linkGroupID, 'linkViewerID'=>$this->linkViewerID);//[RAD_CALLBACK_PARAMS]
        $formAction = $this->getCallBack(moduleNavBar::PAGE_LINKGROUPS, $this->sortBy, $parameters );
        
        $this->setPageCallBack( $formAction );
        
        // if this pageDisplay object isn't already created then 
        if ( !$isCreated ) {
        
            // create a new pageDisplay object
            $this->pageDisplay = new FormProcessor_LinkGroups( $this->moduleRootPath, $this->viewer, $formAction, $this->sortBy,  $this->linkGroupID, $this->linkID );//[RAD_FORMINIT_FOREIGNKEY_INIT]    
        
        } else {
        
            // otherwise just update the formAction value
            $this->pageDisplay->setFormAction( $formAction );
        }
        
        $links = array();
        
        $parameters = array( 'groupID'=>$this->groupID );//[RAD_CALLBACK_PARAMS]
        $continueLink = $this->getCallBack( moduleNavBar::PAGE_LINKLIST, "", $parameters );
        $links["cont"] = $continueLink;

        $parameters = array( 'groupID'=>$this->groupID, 'linkID'=>$this->linkID );//[RAD_CALLBACK_PARAMS_EDIT]
        $editLink = $this->getCallBack( moduleNavBar::PAGE_LINKGROUPS, $this->sortBy, $parameters );
        $editLink .= "&". moduleNavBar::LINKGROUPID . "=";
        $links[ "edit" ] = $editLink;
        
        // NOTE: delete link is same as edit link for an AdminBox
        $links[ "del" ] = $editLink;

/*[RAD_LINK_INSERT]*/

        $parameters = array('groupID'=>$this->groupID, 'linkID'=>$this->linkID, 'linkGroupID'=>$this->linkGroupID, 'linkViewerID'=>$this->linkViewerID);//[RAD_CALLBACK_PARAMS]
        $sortByLink = $this->getCallBack( moduleNavBar::PAGE_LINKGROUPS, '', $parameters );
        $sortByLink .= "&".moduleNavBar::SORTBY."=";
        $links["sortBy"] = $sortByLink;

        $this->pageDisplay->setLinks( $links );    
        
    } // end loadLinkGroups()



    //************************************************************************
	/**
	 * function loadLinkViewer
	 * <pre>
	 * Initializes the LinkViewer Page.
	 * </pre>
	 * @param $isCreated [BOOL] "Is THIS pageDisplay object already created?"
	 * @return [void]
	 */
    // RAD Tools: AdminBox Style
    function loadLinkViewer( $isCreated=false ) 
    {
        
        $parameters = array('groupID'=>$this->groupID, 'linkID'=>$this->linkID, 'linkGroupID'=>$this->linkGroupID, 'linkViewerID'=>$this->linkViewerID);//[RAD_CALLBACK_PARAMS]
        $formAction = $this->getCallBack(moduleNavBar::PAGE_LINKVIEWER, $this->sortBy, $parameters );
        
        $this->setPageCallBack( $formAction );
        
        // if this pageDisplay object isn't already created then 
        if ( !$isCreated ) {
        
            // create a new pageDisplay object
            $this->pageDisplay = new FormProcessor_LinkViewer( $this->moduleRootPath, $this->viewer, $formAction, $this->sortBy,  $this->linkViewerID, $this->linkID );//[RAD_FORMINIT_FOREIGNKEY_INIT]    
        
        } else {
        
            // otherwise just update the formAction value
            $this->pageDisplay->setFormAction( $formAction );
        }
        
        $links = array();
        
        $parameters = array( 'groupID'=>$this->groupID);//[RAD_CALLBACK_PARAMS]
        $continueLink = $this->getCallBack( moduleNavBar::PAGE_LINKLIST, "", $parameters );
        $links["cont"] = $continueLink;

        $parameters = array( 'groupID'=>$this->groupID, 'linkID'=>$this->linkID, 'linkGroupID'=>$this->linkGroupID, 'linkViewerID'=>$this->linkViewerID );//[RAD_CALLBACK_PARAMS_EDIT]
        $editLink = $this->getCallBack( moduleNavBar::PAGE_LINKVIEWER, $this->sortBy, $parameters );
        $editLink .= "&". moduleNavBar::LINKVIEWERID . "=";
        $links[ "edit" ] = $editLink;
        
        // NOTE: delete link is same as edit link for an AdminBox
        $links[ "del" ] = $editLink;

/*[RAD_LINK_INSERT]*/

        $parameters = array('groupID'=>$this->groupID, 'linkID'=>$this->linkID, 'linkGroupID'=>$this->linkGroupID, 'linkViewerID'=>$this->linkViewerID);//[RAD_CALLBACK_PARAMS]
        $sortByLink = $this->getCallBack( moduleNavBar::PAGE_LINKVIEWER, '', $parameters );
        $sortByLink .= "&".moduleNavBar::SORTBY."=";
        $links["sortBy"] = $sortByLink;

        $this->pageDisplay->setLinks( $links );    
        
    } // end loadLinkViewer()



/*[RAD_PAGE_LOAD_FN]*/		

}

?>