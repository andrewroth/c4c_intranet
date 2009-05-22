<?php
/**
 * @package RAD
 * class moduleRAD
 * discussion <pre>
 * Written By	:	Johnny Hausman
 * Date		:   23 Mar 2005
 
 * This is a Rapid Application Development Tool application that helps us develope Web Applications using our new framework.</pre>	
*/
class moduleRAD extends XMLObject_PageContent {
// 		
//
//	CONSTANTS:

        
    /** const MULTILINGUAL_SERIES_KEY The Multilingual Series key for this application.. */
        const MULTILINGUAL_SERIES_KEY = 'moduleRAD';
        
    /** const MULTILINGUAL_PAGE_FIELDS The Multilingual Page key for the fields of this application. */
        const MULTILINGUAL_PAGE_FIELDS = 'fields_RAD';
        
    /** const MODULE_KEY The Module Key for this Module.  Used for access */
        const MODULE_KEY = 'RAD';
        
    /** const PAGE    The QueryString Page parameter. */
        const PAGE = "P";
        
    /** const PAGE_MODULELIST   Display the ModuleList Page. */
        const PAGE_MODULELIST = "ML";

    /** const PAGE_ADDMODULE   Display the AddModule Page. */
        const PAGE_ADDMODULE = "AM";

    /** const PAGE_VIEWMODULE   Display the ViewModule Page. */
        const PAGE_VIEWMODULE = "VM";

    /** const PAGE_ADDSTATEVAR   Display the AddStateVar Page. */
        const PAGE_ADDSTATEVAR = "ASV";

    /** const PAGE_DAOBJLIST   Display the DAObjList Page. */
        const PAGE_DAOBJLIST = "DAOL";

    /** const PAGE_ADDDAOBJ   Display the AddDAObj Page. */
        const PAGE_ADDDAOBJ = "ADAO";

    /** const PAGE_EDITDAOBJ   Display the EditDAObj Page. */
        const PAGE_EDITDAOBJ = "EDAO";

    /** const PAGE_ADDDAFIELDS   Display the AddDAFields Page. */
        const PAGE_ADDDAFIELDS = "ADF";

    /** const PAGE_ADDFIELDLABELS   Display the AddFieldLabels Page. */
        const PAGE_ADDFIELDLABELS = "AFL";

    /** const PAGE_VIEWPAGES   Display the ViewPages Page. */
        const PAGE_VIEWPAGES = "VP";

    /** const PAGE_ADDPAGE   Display the AddPage Page. */
        const PAGE_ADDPAGE = "AP";

    /** const PAGE_EDITPAGE   Display the EditPage Page. */
        const PAGE_EDITPAGE = "EP";

    /** const PAGE_ADDPAGEFIELDS   Display the AddPageFields Page. */
        const PAGE_ADDPAGEFIELDS = "APF";

    /** const PAGE_ADDPAGELABELS   Display the AddPageLabels Page. */
        const PAGE_ADDPAGELABELS = "APL";

    /** const PAGE_TRANSITIONS   Display the Transitions Page. */
        const PAGE_TRANSITIONS = "T";

    /** const PAGE_EDITMODULE   Display the EditModule Page. */
        const PAGE_EDITMODULE = "EM";

    /** const PAGE_DELETEMODULE   Display the DeleteModule Page. */
        const PAGE_DELETEMODULE = "DM";

    /** const PAGE_DELETEDAOBJ   Display the DeleteDAObj Page. */
        const PAGE_DELETEDAOBJ = "DDAO";

    /** const PAGE_DELETEPAGE   Display the DeletePage Page. */
        const PAGE_DELETEPAGE = "DP";

/*[RAD_PAGE_CONST]*/

    /** const SORTBY    The QueryString SortBy parameter. */
        const SORTBY = "modSort";
                

    /** const MODULEID   The QueryString MODULEID parameter. */
        const MODULEID = "M";

    /** const STATEVARID   The QueryString STATEVARID parameter. */
        const STATEVARID = "Sid";

    /** const DAOBJID   The QueryString DAOBJID parameter. */
        const DAOBJID = "DAid";

    /** const DAFIELDID   The QueryString DAFIELDID parameter. */
        const DAFIELDID = "DAFid";

    /** const PAGEID   The QueryString PAGEID parameter. */
        const PAGEID = "Pid";

    /** const PAGELABELID   The QueryString PAGELABELID parameter. */
        const PAGELABELID = "PLid";

    /** const TRANSITIONID   The QueryString TRANSITIONID parameter. */
        const TRANSITIONID = "Tid";

    /** const SIDEBARID   The QueryString SIDEBARID parameter. */
        const SIDEBARID = "SV27";

    /** const SIDEBARLINKID   The QueryString SIDEBARLINKID parameter. */
        const SIDEBARLINKID = "SV28";

    /** const SIDEBARLABELID   The QueryString SIDEBARLABELID parameter. */
        const SIDEBARLABELID = "SV29";
        
        
    /** const RETURNMODULEVIEW   The QueryString RETURNMODULEVIEW parameter. */
        const RETURNMODULEVIEW = "RMV";

/*[RAD_PAGE_STATEVAR_CONST]*/
        
        
//
//	VARIABLES:
        
    /** protected $page   [STRING] The current Mode of this Module. */
		protected $page;
		
    /** protected $sortBy [STRING] Parameter to sort displayed Lists. */
        protected $sortBy;
		
    /** protected $moduleID   [INTEGER] The ID of the module we are working with */
		protected $moduleID;

    /** protected $stateVarID   [INTEGER] The ID of the state variable we are working with */
		protected $stateVarID;

    /** protected $daObjID   [INTEGER] The ID of the Data Access Object we are working with */
		protected $daObjID;

    /** protected $daFieldID   [INTEGER] The ID of the Data Access Field Object we are working with */
		protected $daFieldID;

    /** protected $pageID   [INTEGER] The ID of the Page object we are working with. */
		protected $pageID;

    /** protected $pageLabelID   [INTEGER] The ID of the Page Label object we are working with */
		protected $pageLabelID;

    /** protected $transitionID   [INTEGER] The ID of the transition we are working with */
		protected $transitionID;

    /** protected $sideBarID   [INTEGER] The ID of the Side Bar Object we are working with */
		protected $sideBarID;

    /** protected $sideBarLinkID   [INTEGER] The ID of the Side Bar Link we are working with */
		protected $sideBarLinkID;

    /** protected $sideBarLabelID   [INTEGER] The ID of the Side Bar label we are working with */
		protected $sideBarLabelID;
		
    /** protected $isReturnModuleView   [BOOL] Do we return to the Module View after entering a section of information? */
		protected $isReturnModuleView;

/*[RAD_PAGE_STATEVAR_VAR]*/
		
   
    /** protected $pageDisplay [OBJECT] The display object for the page. */
        protected $pageDisplay;
        
/*[RAD_PAGE_OBJECT_VAR]*/ 		


//
//	CLASS FUNCTIONS:
//

	
	//************************************************************************
	/** 
	 @function loadData
	 
	 @abstract Provided function to allow object to load it's data.

	*/
	function loadData( ) 
	{


/*[RAD_PAGE_STATEVAR_INIT]*/
        
        // Now check to see if a Application ID was given
//        $this->appID = $this->getQSValue( moduleRAD::APPID, '' );
        
/*[RAD_COMMON_LOAD]*/
         
        // load the module's page (DEFAULT = WELCOME)
        $this->page = $this->getQSValue( moduleRAD::PAGE, moduleRAD::PAGE_MODULELIST );
        
        // load the module's sortBy parameter (DEFAULT = '')
        $this->sortBy = $this->getQSValue( moduleRAD::SORTBY, '' );
        
        // load the module's MODULEID variable
        $this->moduleID = $this->getQSValue( moduleRAD::MODULEID, "" );

        // load the module's STATEVARID variable
        $this->stateVarID = $this->getQSValue( moduleRAD::STATEVARID, "" );

        // load the module's DAOBJID variable
        $this->daObjID = $this->getQSValue( moduleRAD::DAOBJID, "" );

        // load the module's DAFIELDID variable
        $this->daFieldID = $this->getQSValue( moduleRAD::DAFIELDID, "" );

        // load the module's PAGEID variable
        $this->pageID = $this->getQSValue( moduleRAD::PAGEID, "" );

        // load the module's PAGELABELID variable
        $this->pageLabelID = $this->getQSValue( moduleRAD::PAGELABELID, "" );

        // load the module's TRANSITIONID variable
        $this->transitionID = $this->getQSValue( moduleRAD::TRANSITIONID, "" );

        // load the module's SIDEBARID variable
        $this->sideBarID = $this->getQSValue( moduleRAD::SIDEBARID, "" );

        // load the module's SIDEBARLINKID variable
        $this->sideBarLinkID = $this->getQSValue( moduleRAD::SIDEBARLINKID, "" );

        // load the module's SIDEBARLABELID variable
        $this->sideBarLabelID = $this->getQSValue( moduleRAD::SIDEBARLABELID, "" );
        
        // load the module's RETURNMODULEVIEW variable
        $this->isReturnModuleView = $this->getQSValue( moduleRAD::RETURNMODULEVIEW, 'F' );
        // convert to True / False
        $this->isReturnModuleView = ($this->isReturnModuleView != 'F');
        

/*[RAD_PAGE_LOAD_STATEVAR]*/
        
        switch( $this->page ) {
                
            /*
             *  ModuleList
             */
            case moduleRAD::PAGE_MODULELIST:
                $this->loadModuleList();
                break;

            /*
             *  AddModule
             */
            case moduleRAD::PAGE_ADDMODULE:
                $this->loadAddModule();
                break;

            /*
             *  ViewModule
             */
            case moduleRAD::PAGE_VIEWMODULE:
                $this->loadViewModule();
                break;

            /*
             *  AddStateVar
             */
            case moduleRAD::PAGE_ADDSTATEVAR:
                $this->loadAddStateVar();
                break;

            /*
             *  DAObjList
             */
            case moduleRAD::PAGE_DAOBJLIST:
                $this->loadDAObjList();
                break;

            /*
             *  AddDAObj
             */
            case moduleRAD::PAGE_ADDDAOBJ:
                $this->loadAddDAObj();
                break;

            /*
             *  EditDAObj
             */
            case moduleRAD::PAGE_EDITDAOBJ:
                $this->loadEditDAObj();
                break;

            /*
             *  AddDAFields
             */
            case moduleRAD::PAGE_ADDDAFIELDS:
                $this->loadAddDAFields();
                break;

            /*
             *  AddFieldLabels
             */
            case moduleRAD::PAGE_ADDFIELDLABELS:
                $this->loadAddFieldLabels();
                break;

            /*
             *  ViewPages
             */
            case moduleRAD::PAGE_VIEWPAGES:
                $this->loadViewPages();
                break;

            /*
             *  AddPage
             */
            case moduleRAD::PAGE_ADDPAGE:
                $this->loadAddPage();
                break;

            /*
             *  EditPage
             */
            case moduleRAD::PAGE_EDITPAGE:
                $this->loadEditPage();
                break;

            /*
             *  AddPageFields
             */
            case moduleRAD::PAGE_ADDPAGEFIELDS:
                $this->loadAddPageFields();
                break;

            /*
             *  AddPageLabels
             */
            case moduleRAD::PAGE_ADDPAGELABELS:
                $this->loadAddPageLabels();
                break;

            /*
             *  Transitions
             */
            case moduleRAD::PAGE_TRANSITIONS:
                $this->loadTransitions();
                break;

            /*
             *  EditModule
             */
            case moduleRAD::PAGE_EDITMODULE:
                $this->loadEditModule();
                break;

            /*
             *  DeleteModule
             */
            case moduleRAD::PAGE_DELETEMODULE:
                $this->loadDeleteModule();
                break;

            /*
             *  DeleteDAObj
             */
            case moduleRAD::PAGE_DELETEDAOBJ:
                $this->loadDeleteDAObj();
                break;

            /*
             *  DeletePage
             */
            case moduleRAD::PAGE_DELETEPAGE:
                $this->loadDeletePage();
                break;

/*[RAD_PAGE_LOAD_CALL]*/
   
                 
            /*
             *  Just to make sure, default the pageDisplay to 
             *  the ModuleList page.
             */
            default:
                $this->page = moduleRAD::PAGE_MODULELIST;
                $this->loadModuleList();
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
    
                    case moduleRAD::PAGE_ADDSTATEVAR:
                    
                        // NOTE: after a successful submit on an AdminBox style
                        // form, set the managerInit variable back to ''
                        $this->stateVarID = '';
                        $formAction = $this->getCallBack(moduleRAD::PAGE_ADDSTATEVAR, $this->sortBy, $this->moduleID, '', '', '', '', '', '', '', '', '');//[RAD_CALLBACK_PARAMS]
                        $this->pageDisplay->setFormAction( $formAction );                 
                        break;

                    case moduleRAD::PAGE_ADDDAFIELDS:
                        // NOTE: after a successful submit on an AdminBox style
                        // form, set the managerInit variable back to ''
                        $this->daFieldID = '';
                        $formAction = $this->getCallBack(moduleRAD::PAGE_ADDDAFIELDS, $this->sortBy, $this->moduleID, $this->stateVarID, $this->daObjID, $this->daFieldID, $this->pageID, $this->pageLabelID, $this->transitionID, $this->sideBarID, $this->sideBarLinkID, $this->sideBarLabelID);//[RAD_CALLBACK_PARAMS]
                        $this->pageDisplay->setFormAction( $formAction );                     
                        break;

                    case moduleRAD::PAGE_ADDPAGELABELS:
                        // NOTE: after a successful submit on an AdminBox style
                        // form, set the managerInit variable back to ''
                        $this->pageLabelID = '';
                        $formAction = $this->getCallBack(moduleRAD::PAGE_ADDPAGELABELS, $this->sortBy, $this->moduleID, $this->stateVarID, $this->daObjID, $this->daFieldID, $this->pageID, $this->pageLabelID, $this->transitionID, $this->sideBarID, $this->sideBarLinkID, $this->sideBarLabelID);//[RAD_CALLBACK_PARAMS]
                        $this->pageDisplay->setFormAction( $formAction );                     
                        break;

                    case moduleRAD::PAGE_TRANSITIONS:
                        // NOTE: after a successful submit on an AdminBox style
                        // form, set the managerInit variable back to ''
                        $this->transitionID = '';
                        $formAction = $this->getCallBack(moduleRAD::PAGE_TRANSITIONS, $this->sortBy, $this->moduleID, $this->stateVarID, $this->daObjID, $this->daFieldID, $this->pageID, $this->pageLabelID, $this->transitionID, $this->sideBarID, $this->sideBarLinkID, $this->sideBarLabelID);//[RAD_CALLBACK_PARAMS]
                        $this->pageDisplay->setFormAction( $formAction );                     
                        break;

                    case moduleRAD::PAGE_ADDMODULE:
                        // NOTE: we have not initialized the moduleID yet
                        // so we need to get the new moduleID back from the
                        // page that just created one.
                        $this->moduleID = $this->pageDisplay->getModuleID();
                        $this->mode = moduleRAD::PAGE_ADDSTATEVAR;
                        $this->loadAddStateVar();                       
                        break;

                    case moduleRAD::PAGE_ADDDAOBJ:
                        // NOTE: next page needs the daObjID we just created
                        $this->daObjID = $this->pageDisplay->getDaObjID();
                        $this->mode = moduleRAD::PAGE_ADDDAFIELDS;
                        $this->loadAddDAFields();                       
                        break;

                    case moduleRAD::PAGE_EDITDAOBJ:
                        //$this->daObjID = '';
                        $this->mode = moduleRAD::PAGE_ADDDAFIELDS;
                        $this->loadAddDAFields();                       
                        break;

                    case moduleRAD::PAGE_ADDFIELDLABELS:
                        $this->daObjID = '';
                        $this->daFieldID = '';
                        $this->mode = moduleRAD::PAGE_DAOBJLIST;
                        $this->loadDAObjList();                       
                        break;

                    case moduleRAD::PAGE_ADDPAGE:
                        $this->pageID = $this->pageDisplay->getPageID();
                        $this->mode = moduleRAD::PAGE_ADDPAGEFIELDS;
                        $this->loadAddPageFields();                       
                        break;

                    case moduleRAD::PAGE_EDITPAGE:
                        $this->pageID = $this->pageDisplay->getPageID();
                        $this->mode = moduleRAD::PAGE_ADDPAGEFIELDS;
                        $this->loadAddPageFields();                       
                        break;

                    case moduleRAD::PAGE_ADDPAGEFIELDS:
                        /* No StateVar given for FormInit. */
                        $this->mode = moduleRAD::PAGE_ADDPAGELABELS;
                        $this->loadAddPageLabels();                       
                        break;

                    case moduleRAD::PAGE_DELETEPAGE:
                        $this->pageID = '';
                        $this->mode = moduleRAD::PAGE_VIEWPAGES;
                        $this->loadViewPages();                       
                        break;

                    case moduleRAD::PAGE_DELETEDAOBJ:
                        $this->daObjID = '';
                        $this->mode = moduleRAD::PAGE_DAOBJLIST;
                        $this->loadDAObjList();                       
                        break;

                    case moduleRAD::PAGE_DELETEMODULE:
                        $this->moduleID = '';
                        $this->mode = moduleRAD::PAGE_MODULELIST;
                        $this->loadModuleList();                       
                        break;

                    case moduleRAD::PAGE_EDITMODULE:
                        // if we are to return to the Module View
                        if ($this->isReturnModuleView ) {
                            
                            $this->mode = moduleRAD::PAGE_VIEWMODULE;
                            $this->loadViewModule();
                        
                        } else {
                        
                            // continue on to the StateVar Entry Section
                            $this->mode = moduleRAD::PAGE_ADDSTATEVAR;
                            $this->loadAddStateVar();  
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



        // store HTML content as this page's content Item
        $this->addContent( $content );
        
         
        // Add any necessary javascripts for this page:
        switch( $this->page ) {
        
/*[RAD_PAGE_JAVASCRIPTS]*/
//             case moduleRAD::PAGE_DEFAULT:
//                $this->addScript('MM_jumpMenu.jsp');
//                break;

        }
        
	}
	
	
	
    //************************************************************************
	/**
	 * function getCallBack
	 * <pre>Builds the proper HREF link for a desired action.</pre>
	 * @param $page [STRING] The Desired PAGE of this Link.
	 * @param $sortBy [STRING] The Desired Sort Field for this link.
	 * @param $moduleID [INTEGER] The Desired MODULEID of this Link.
	 * @param $stateVarID [INTEGER] The Desired STATEVARID of this Link.
	 * @param $daObjID [INTEGER] The Desired DAOBJID of this Link.
	 * @param $daFieldID [INTEGER] The Desired DAFIELDID of this Link.
	 * @param $pageID [INTEGER] The Desired PAGEID of this Link.
	 * @param $pageLabelID [INTEGER] The Desired PAGELABELID of this Link.
	 * @param $transitionID [INTEGER] The Desired TRANSITIONID of this Link.
	 * @param $sideBarID [INTEGER] The Desired SIDEBARID of this Link.
	 * @param $sideBarLinkID [INTEGER] The Desired SIDEBARLINKID of this Link.
	 * @param $sideBarLabelID [INTEGER] The Desired SIDEBARLABELID of this Link.
[RAD_CALLBACK_DOC]
	 * @return [STRING] The Link.
	 */
    function getCallBack($page='', $sortBy='', $moduleID='', $stateVarID='', $daObjID='', $daFieldID='', $pageID='', $pageLabelID='', $transitionID='', $sideBarID='', $sideBarLinkID='', $sideBarLabelID='')//RAD_CALLBACK_PARAM
    {
        // NOTE: the RAD tools need the //RAD_CALLBACK_PARAM to be right next
        // to the ending ")" of the function to properly update this function.
        
        $returnValue = $this->baseCallBack;
        
        $callBack = '';
        
        if ($page != '') {
            $callBack = moduleRAD::PAGE.'='.$page;
        }
        
        if ($sortBy != '') {
            if ($callBack != '') {
                $callBack .= '&';
            }
            $callBack .= moduleRAD::SORTBY.'='.$sortBy;
        }
        
        
        if ($moduleID != '') {
            if ($callBack != '') {
                $callBack .= '&';
            }
            $callBack .= moduleRAD::MODULEID.'='.$moduleID;
        }

        if ($stateVarID != '') {
            if ($callBack != '') {
                $callBack .= '&';
            }
            $callBack .= moduleRAD::STATEVARID.'='.$stateVarID;
        }

        if ($daObjID != '') {
            if ($callBack != '') {
                $callBack .= '&';
            }
            $callBack .= moduleRAD::DAOBJID.'='.$daObjID;
        }

        if ($daFieldID != '') {
            if ($callBack != '') {
                $callBack .= '&';
            }
            $callBack .= moduleRAD::DAFIELDID.'='.$daFieldID;
        }

        if ($pageID != '') {
            if ($callBack != '') {
                $callBack .= '&';
            }
            $callBack .= moduleRAD::PAGEID.'='.$pageID;
        }

        if ($pageLabelID != '') {
            if ($callBack != '') {
                $callBack .= '&';
            }
            $callBack .= moduleRAD::PAGELABELID.'='.$pageLabelID;
        }

        if ($transitionID != '') {
            if ($callBack != '') {
                $callBack .= '&';
            }
            $callBack .= moduleRAD::TRANSITIONID.'='.$transitionID;
        }

        if ($sideBarID != '') {
            if ($callBack != '') {
                $callBack .= '&';
            }
            $callBack .= moduleRAD::SIDEBARID.'='.$sideBarID;
        }

        if ($sideBarLinkID != '') {
            if ($callBack != '') {
                $callBack .= '&';
            }
            $callBack .= moduleRAD::SIDEBARLINKID.'='.$sideBarLinkID;
        }

        if ($sideBarLabelID != '') {
            if ($callBack != '') {
                $callBack .= '&';
            }
            $callBack .= moduleRAD::SIDEBARLABELID.'='.$sideBarLabelID;
        }

/*[RAD_CALLBACK_CODE]*/

        // NOTE: Hack Alert!
        // OK this is here because I wanted to add this parameter after
        // all the callback routines were created.  Too much mafan to alter
        // all of them (and possibly break things) so I added it here.
        
        // now add the internally tracked ReturnModuleView Param
        if ( $this->isReturnModuleView ) {
            $returnParam = '&'.moduleRAD::RETURNMODULEVIEW.'=T';
        } else {
            $returnParam = '&'.moduleRAD::RETURNMODULEVIEW.'=F';
        }
        
        $returnValue .= $returnParam;
        
        if ( $callBack != '') {
            $returnValue .= '&'.$callBack;
        }
        
        return $returnValue;
    }

    
    
    //************************************************************************
	/**
	 * function loadModuleList
	 * <pre>Initializes the ModuleList Page.</pre>
	 * @return [void]
	 */
    // RAD Tools: DataListTable Style
    function loadModuleList() 
    {
        // when starting from the Module List we want users to progress
        // through the series of data entry sections before arriving at 
        // the Module List.
        
        // set the "ReturnToModuleView" param to false.
        $this->isReturnModuleView = false;
        
        $this->pageDisplay = new page_ModuleList( $this->moduleRootPath, $this->viewer, $this->sortBy );    
        
        $links = array();

        $addLink = $this->getCallBack( moduleRAD::PAGE_ADDMODULE, $this->sortBy , $this->moduleID, $this->stateVarID, $this->daObjID, $this->daFieldID, $this->pageID, $this->pageLabelID, $this->transitionID, $this->sideBarID, $this->sideBarLinkID, $this->sideBarLabelID);//[RAD_CALLBACK_PARAMS]
        $links["add"] = $addLink;

        $editLink = $this->getCallBack( moduleRAD::PAGE_EDITMODULE, $this->sortBy , "", $this->stateVarID, $this->daObjID, $this->daFieldID, $this->pageID, $this->pageLabelID, $this->transitionID, $this->sideBarID, $this->sideBarLinkID, $this->sideBarLabelID);//[RAD_CALLBACK_PARAMS_EDIT]
        $editLink .= "&". moduleRAD::MODULEID . "=";
        $links["edit"] = $editLink;

        $delLink = $this->getCallBack( moduleRAD::PAGE_DELETEMODULE, $this->sortBy , "", $this->stateVarID, $this->daObjID, $this->daFieldID, $this->pageID, $this->pageLabelID, $this->transitionID, $this->sideBarID, $this->sideBarLinkID, $this->sideBarLabelID);//[RAD_CALLBACK_PARAMS_EDIT]
        $delLink .= "&". moduleRAD::MODULEID . "=";
        $links["del"] = $delLink;

/*[RAD_LINK_INSERT]*/

        $sortByLink = $this->getCallBack( moduleRAD::PAGE_MODULELIST, '' , $this->moduleID, $this->stateVarID, $this->daObjID, $this->daFieldID, $this->pageID, $this->pageLabelID, $this->transitionID, $this->sideBarID, $this->sideBarLinkID, $this->sideBarLabelID);//[RAD_CALLBACK_PARAMS]
        $sortByLink .= "&".moduleRAD::SORTBY."=";
        $links["sortBy"] = $sortByLink;
        
        // Now add the link column link info 
        $viewLink = $this->getCallBack( moduleRAD::PAGE_VIEWMODULE, "" );
        $viewLink .= "&". moduleRAD::MODULEID . "=";
        $links['view'] = $viewLink;
        
        $this->pageDisplay->setLinks( $links ); 
        
    } // end loadModuleList()



    //************************************************************************
	/**
	 * function loadAddModule
	 * <pre>Initializes the AddModule Page.</pre>
	 * @return [void]
	 */
    function loadAddModule() 
    {
        
        $formAction = $this->getCallBack(moduleRAD::PAGE_ADDMODULE, $this->sortBy , $this->moduleID, $this->stateVarID, $this->daObjID, $this->daFieldID, $this->pageID, $this->pageLabelID, $this->transitionID, $this->sideBarID, $this->sideBarLinkID, $this->sideBarLabelID);//[RAD_CALLBACK_PARAMS]
        $this->pageDisplay = new FormProcessor_AddModule( $this->moduleRootPath, $this->viewer, $formAction, $this->moduleID );//[RAD_FORMINIT_FOREIGNKEY_INIT]        
        
    } // end loadAddModule()



    //************************************************************************
	/**
	 * function loadViewModule
	 * <pre>Initializes the ViewModule Page.</pre>
	 * @return [void]
	 */
    function loadViewModule() 
    {
        // Once a viewer goes to the Module View, then each time he updates
        // information sections, he should be returned to the Module View.
        // Set the "ReturnToModuleView" param to true.
        $this->isReturnModuleView = true;
    
        $this->pageDisplay = new page_ViewModule( $this->moduleRootPath, $this->viewer, $this->moduleID );    
        
        $links = array();
        
        /*
         *  Return to module List Link
         */
        $editLink = $this->getCallBack( moduleRAD::PAGE_MODULELIST );
        $links[ 'returnModuleList' ] = $editLink;
         
        /*
         *  Edit Module Link
         */
        $editLink = $this->getCallBack( moduleRAD::PAGE_EDITMODULE, '', $this->moduleID );
        $links[ 'edit' ] = $editLink;

        
        /*
         *  Create Module Link
         */
        $createLink = $this->getCallBack( moduleRAD::PAGE_VIEWMODULE, '', $this->moduleID );
        $createLink .= '&Process=Y';
        $links[ 'create' ] = $createLink;
        
        
        /*
         *  State Var Links
         */
        $stateVarLink = $this->getCallBack( moduleRAD::PAGE_ADDSTATEVAR, '', $this->moduleID );
        $links[ 'stateVarSection' ] = $stateVarLink;

        $stateVarLink .= '&admOpType=U&'.moduleRAD::STATEVARID.'=';
        $links[ 'stateVarEdit' ] = $stateVarLink;
        
        
        /*
         *  Data Access Object Links
         */
        $daObjLink = $this->getCallBack( moduleRAD::PAGE_DAOBJLIST, '', $this->moduleID );
        $links[ 'daObjSection' ] = $daObjLink;
        
        $daObjLink = $this->getCallBack( moduleRAD::PAGE_EDITDAOBJ, '', $this->moduleID );
        $daObjLink .= '&'.moduleRAD::DAOBJID.'=';
        $links[ 'daObjEdit' ] = $daObjLink;
        
        
        /*
         *  Page Links
         */
        $pageLink = $this->getCallBack( moduleRAD::PAGE_VIEWPAGES, '', $this->moduleID );
        $links[ 'pageSection' ] = $pageLink;
        
        $pageLink = $this->getCallBack( moduleRAD::PAGE_EDITPAGE, '', $this->moduleID );
        $pageLink .= '&'.moduleRAD::PAGEID.'=';
        $links[ 'pageEdit' ] = $pageLink;
        
        
        
        /*
         * Update Transition Links
         */
        $transitionLink = $this->getCallBack( moduleRAD::PAGE_TRANSITIONS, '', $this->moduleID );
        $links[ 'transitionSection' ] = $transitionLink;

        $transitionLink .= '&admOpType=U&'.moduleRAD::TRANSITIONID.'=';
        $links[ 'transitionEdit' ] = $transitionLink;
        
        

        // store these links on the page.
        $this->pageDisplay->setLinks( $links );
        
    } // end loadViewModule()



    //************************************************************************
	/**
	 * function loadAddStateVar
	 * <pre>Initializes the AddStateVar Page.</pre>
	 * @return [void]
	 */
    // RAD Tools: AdminBox Style
    function loadAddStateVar() 
    {
        
        $formAction = $this->getCallBack(moduleRAD::PAGE_ADDSTATEVAR, $this->sortBy , $this->moduleID, $this->stateVarID, '', '', '', '', '', '', '', '');//[RAD_CALLBACK_PARAMS]
        $this->pageDisplay = new FormProcessor_AddStateVar( $this->moduleRootPath, $this->viewer, $formAction, $this->sortBy,  $this->stateVarID, $this->moduleID );//[RAD_FORMINIT_FOREIGNKEY_INIT]    
        
        $links = array();
        
        $editLink = $this->getCallBack( moduleRAD::PAGE_ADDSTATEVAR, $this->sortBy, $this->moduleID );//[RAD_CALLBACK_PARAMS_EDIT]
        $editLink .= "&". moduleRAD::STATEVARID . "=";
        $links[ "edit" ] = $editLink;
        
        // NOTE: delete link is same as edit link for an AdminBox
        $links[ "del" ] = $editLink;
        
        // if we are to return to the Module View
        if ($this->isReturnModuleView ) {
            
            // continue on to the View Module Page
            $continueLink = $this->getCallBack( moduleRAD::PAGE_VIEWMODULE, "" , $this->moduleID);//[RAD_CALLBACK_PARAMS]
        
        } else {
            // continue on to the Data Access Object Entry Page
            $continueLink = $this->getCallBack( moduleRAD::PAGE_DAOBJLIST, "" , $this->moduleID);//[RAD_CALLBACK_PARAMS]
        }
        $links["cont"] = $continueLink;

/*[RAD_LINK_INSERT]*/

        $sortByLink = $this->getCallBack( moduleRAD::PAGE_ADDSTATEVAR, '' , $this->moduleID, '', '', '', '', '', '', '', '', '');//[RAD_CALLBACK_PARAMS]
        $sortByLink .= "&".moduleRAD::SORTBY."=";
        $links["sortBy"] = $sortByLink;

        $this->pageDisplay->setLinks( $links );    
        
    } // end loadAddStateVar()



    //************************************************************************
	/**
	 * function loadDAObjList
	 * <pre>Initializes the DAObjList Page.</pre>
	 * @return [void]
	 */
    // RAD Tools: DataListTable Style
    function loadDAObjList() 
    {
        $this->pageDisplay = new page_DAObjList( $this->moduleRootPath, $this->viewer, $this->sortBy, $this->moduleID );    
        
        $links = array();
        
        $addLink = $this->getCallBack( moduleRAD::PAGE_ADDDAOBJ, $this->sortBy , $this->moduleID, $this->stateVarID, $this->daObjID, $this->daFieldID, $this->pageID, $this->pageLabelID, $this->transitionID, $this->sideBarID, $this->sideBarLinkID, $this->sideBarLabelID);//[RAD_CALLBACK_PARAMS]
        $links["add"] = $addLink;

        $editLink = $this->getCallBack( moduleRAD::PAGE_EDITDAOBJ, $this->sortBy , $this->moduleID, $this->stateVarID, "", $this->daFieldID, $this->pageID, $this->pageLabelID, $this->transitionID, $this->sideBarID, $this->sideBarLinkID, $this->sideBarLabelID);//[RAD_CALLBACK_PARAMS_EDIT]
        $editLink .= "&". moduleRAD::DAOBJID . "=";
        $links["edit"] = $editLink;

        $delLink = $this->getCallBack( moduleRAD::PAGE_DELETEDAOBJ, $this->sortBy , $this->moduleID, $this->stateVarID, "", $this->daFieldID, $this->pageID, $this->pageLabelID, $this->transitionID, $this->sideBarID, $this->sideBarLinkID, $this->sideBarLabelID);//[RAD_CALLBACK_PARAMS_EDIT]
        $delLink .= "&". moduleRAD::DAOBJID . "=";
        $links["del"] = $delLink;

        // if we are to return to the Module View
        if ($this->isReturnModuleView ) {
            
            // continue on to the View Module Page
            $continueLink = $this->getCallBack( moduleRAD::PAGE_VIEWMODULE, "" , $this->moduleID);//[RAD_CALLBACK_PARAMS]
        
        } else {
            
            // continue on to the Page Definition series
            $continueLink = $this->getCallBack( moduleRAD::PAGE_VIEWPAGES, "" , $this->moduleID, $this->stateVarID, $this->daObjID, $this->daFieldID, $this->pageID, $this->pageLabelID, $this->transitionID, $this->sideBarID, $this->sideBarLinkID, $this->sideBarLabelID);//[RAD_CALLBACK_PARAMS]
            
        }
        $links["cont"] = $continueLink;

/*[RAD_LINK_INSERT]*/

        $sortByLink = $this->getCallBack( moduleRAD::PAGE_DAOBJLIST, '' , $this->moduleID, $this->stateVarID, $this->daObjID, $this->daFieldID, $this->pageID, $this->pageLabelID, $this->transitionID, $this->sideBarID, $this->sideBarLinkID, $this->sideBarLabelID);//[RAD_CALLBACK_PARAMS]
        $sortByLink .= "&".moduleRAD::SORTBY."=";
        $links["sortBy"] = $sortByLink;

        $this->pageDisplay->setLinks( $links ); 
        
    } // end loadDAObjList()



    //************************************************************************
	/**
	 * function loadAddDAObj
	 * <pre>Initializes the AddDAObj Page.</pre>
	 * @return [void]
	 */
    function loadAddDAObj() 
    {
        
        $formAction = $this->getCallBack(moduleRAD::PAGE_ADDDAOBJ, $this->sortBy , $this->moduleID, $this->stateVarID, $this->daObjID, $this->daFieldID, $this->pageID, $this->pageLabelID, $this->transitionID, $this->sideBarID, $this->sideBarLinkID, $this->sideBarLabelID);//[RAD_CALLBACK_PARAMS]
        $this->pageDisplay = new FormProcessor_AddDAObj( $this->moduleRootPath, $this->viewer, $formAction, $this->daObjID , $this->moduleID);//[RAD_FORMINIT_FOREIGNKEY_INIT]        
        
    } // end loadAddDAObj()



    //************************************************************************
	/**
	 * function loadEditDAObj
	 * <pre>Initializes the EditDAObj Page.</pre>
	 * @return [void]
	 */
    function loadEditDAObj() 
    {
        
        $formAction = $this->getCallBack(moduleRAD::PAGE_EDITDAOBJ, $this->sortBy , $this->moduleID, $this->stateVarID, $this->daObjID, $this->daFieldID, $this->pageID, $this->pageLabelID, $this->transitionID, $this->sideBarID, $this->sideBarLinkID, $this->sideBarLabelID);//[RAD_CALLBACK_PARAMS]
        $this->pageDisplay = new FormProcessor_EditDAObj( $this->moduleRootPath, $this->viewer, $formAction, $this->daObjID , $this->moduleID);//[RAD_FORMINIT_FOREIGNKEY_INIT]        
        
    } // end loadEditDAObj()



    //************************************************************************
	/**
	 * function loadAddDAFields
	 * <pre>Initializes the AddDAFields Page.</pre>
	 * @return [void]
	 */
    // RAD Tools: AdminBox Style
    function loadAddDAFields() 
    {
        
        $formAction = $this->getCallBack(moduleRAD::PAGE_ADDDAFIELDS, $this->sortBy , $this->moduleID, $this->stateVarID, $this->daObjID, $this->daFieldID, $this->pageID, $this->pageLabelID, $this->transitionID, $this->sideBarID, $this->sideBarLinkID, $this->sideBarLabelID);//[RAD_CALLBACK_PARAMS]
        $this->pageDisplay = new FormProcessor_AddDAFields( $this->moduleRootPath, $this->viewer, $formAction, $this->sortBy,  $this->daFieldID, $this->daObjID );//[RAD_FORMINIT_FOREIGNKEY_INIT]    
        
        $links = array();
        
        $continueLink = $this->getCallBack( moduleRAD::PAGE_ADDFIELDLABELS, "" , $this->moduleID, $this->stateVarID, $this->daObjID, $this->daFieldID, $this->pageID, $this->pageLabelID, $this->transitionID, $this->sideBarID, $this->sideBarLinkID, $this->sideBarLabelID);//[RAD_CALLBACK_PARAMS]
        $links["cont"] = $continueLink;

        $editLink = $this->getCallBack( moduleRAD::PAGE_ADDDAFIELDS, $this->sortBy, $this->moduleID, '', $this->daObjID );//[RAD_CALLBACK_PARAMS_EDIT]
        $editLink .= "&". moduleRAD::DAFIELDID . "=";
        $links[ "edit" ] = $editLink;
        
        // NOTE: delete link is same as edit link for an AdminBox
        $links[ "del" ] = $editLink;

/*[RAD_LINK_INSERT]*/

        $sortByLink = $this->getCallBack( moduleRAD::PAGE_ADDDAFIELDS, '' , $this->moduleID, $this->stateVarID, $this->daObjID, $this->daFieldID, $this->pageID, $this->pageLabelID, $this->transitionID, $this->sideBarID, $this->sideBarLinkID, $this->sideBarLabelID);//[RAD_CALLBACK_PARAMS]
        $sortByLink .= "&".moduleRAD::SORTBY."=";
        $links["sortBy"] = $sortByLink;

        $this->pageDisplay->setLinks( $links );    
        
    } // end loadAddDAFields()



    //************************************************************************
	/**
	 * function loadAddFieldLabels
	 * <pre>Initializes the AddFieldLabels Page.</pre>
	 * @return [void]
	 */
    // RAD Tools: Form Grid Style
    function loadAddFieldLabels() 
    {
        
        $formAction = $this->getCallBack(moduleRAD::PAGE_ADDFIELDLABELS, $this->sortBy , $this->moduleID, $this->stateVarID, $this->daObjID, $this->daFieldID, $this->pageID, $this->pageLabelID, $this->transitionID, $this->sideBarID, $this->sideBarLinkID, $this->sideBarLabelID);//[RAD_CALLBACK_PARAMS]
        $this->pageDisplay = new FormProcessor_AddFieldLabels( $this->moduleRootPath, $this->viewer, $formAction, $this->daObjID );     
        
    } // end loadAddFieldLabels()



    //************************************************************************
	/**
	 * function loadViewPages
	 * <pre>Initializes the ViewPages Page.</pre>
	 * @return [void]
	 */
    // RAD Tools: DataListTable Style
    function loadViewPages() 
    {
        $this->pageDisplay = new page_ViewPages( $this->moduleRootPath, $this->viewer, $this->sortBy, $this->moduleID );    
        
        $links = array();
        
        $addLink = $this->getCallBack( moduleRAD::PAGE_ADDPAGE, $this->sortBy , $this->moduleID, $this->stateVarID, $this->daObjID, $this->daFieldID, $this->pageID, $this->pageLabelID, $this->transitionID, $this->sideBarID, $this->sideBarLinkID, $this->sideBarLabelID);//[RAD_CALLBACK_PARAMS]
        $links["add"] = $addLink;

        $editLink = $this->getCallBack( moduleRAD::PAGE_EDITPAGE, $this->sortBy , $this->moduleID, $this->stateVarID, $this->daObjID, $this->daFieldID, "", $this->pageLabelID, $this->transitionID, $this->sideBarID, $this->sideBarLinkID, $this->sideBarLabelID);//[RAD_CALLBACK_PARAMS_EDIT]
        $editLink .= "&". moduleRAD::PAGEID . "=";
        $links["edit"] = $editLink;

        $delLink = $this->getCallBack( moduleRAD::PAGE_DELETEPAGE, $this->sortBy , $this->moduleID, $this->stateVarID, $this->daObjID, $this->daFieldID, "", $this->pageLabelID, $this->transitionID, $this->sideBarID, $this->sideBarLinkID, $this->sideBarLabelID);//[RAD_CALLBACK_PARAMS_EDIT]
        $delLink .= "&". moduleRAD::PAGEID . "=";
        $links["del"] = $delLink;

        // if we are to return to the Module View
        if ($this->isReturnModuleView ) {
            
            // continue on to the View Module Page
            $continueLink = $this->getCallBack( moduleRAD::PAGE_VIEWMODULE, "" , $this->moduleID);//[RAD_CALLBACK_PARAMS]
        
        } else {
        
            $continueLink = $this->getCallBack( moduleRAD::PAGE_TRANSITIONS, "" , $this->moduleID );//[RAD_CALLBACK_PARAMS]
        
        }
        $links["cont"] = $continueLink;

/*[RAD_LINK_INSERT]*/

        $sortByLink = $this->getCallBack( moduleRAD::PAGE_VIEWPAGES, '' , $this->moduleID, $this->stateVarID, $this->daObjID, $this->daFieldID, $this->pageID, $this->pageLabelID, $this->transitionID, $this->sideBarID, $this->sideBarLinkID, $this->sideBarLabelID);//[RAD_CALLBACK_PARAMS]
        $sortByLink .= "&".moduleRAD::SORTBY."=";
        $links["sortBy"] = $sortByLink;

        $this->pageDisplay->setLinks( $links ); 
        
    } // end loadViewPages()



    //************************************************************************
	/**
	 * function loadAddPage
	 * <pre>Initializes the AddPage Page.</pre>
	 * @return [void]
	 */
    function loadAddPage() 
    {
        
        $formAction = $this->getCallBack(moduleRAD::PAGE_ADDPAGE, $this->sortBy , $this->moduleID, $this->stateVarID, $this->daObjID, $this->daFieldID, $this->pageID, $this->pageLabelID, $this->transitionID, $this->sideBarID, $this->sideBarLinkID, $this->sideBarLabelID);//[RAD_CALLBACK_PARAMS]
        $this->pageDisplay = new FormProcessor_AddPage( $this->moduleRootPath, $this->viewer, $formAction, $this->pageID , $this->moduleID);//[RAD_FORMINIT_FOREIGNKEY_INIT]        
        
    } // end loadAddPage()



    //************************************************************************
	/**
	 * function loadEditPage
	 * <pre>Initializes the EditPage Page.</pre>
	 * @return [void]
	 */
    function loadEditPage() 
    {
        
        $formAction = $this->getCallBack(moduleRAD::PAGE_EDITPAGE, $this->sortBy , $this->moduleID, $this->stateVarID, $this->daObjID, $this->daFieldID, $this->pageID, $this->pageLabelID, $this->transitionID, $this->sideBarID, $this->sideBarLinkID, $this->sideBarLabelID);//[RAD_CALLBACK_PARAMS]
        $this->pageDisplay = new FormProcessor_EditPage( $this->moduleRootPath, $this->viewer, $formAction, $this->pageID , $this->moduleID);//[RAD_FORMINIT_FOREIGNKEY_INIT]        
        
    } // end loadEditPage()



    //************************************************************************
	/**
	 * function loadAddPageFields
	 * <pre>Initializes the AddPageFields Page.</pre>
	 * @return [void]
	 */
    // RAD Tools: DataListTable Style
    function loadAddPageFields() 
    {

        $formAction = $this->getCallBack(moduleRAD::PAGE_ADDPAGEFIELDS, $this->sortBy, $this->moduleID, $this->stateVarID, $this->daObjID, $this->daFieldID, $this->pageID );
        $this->pageDisplay = new FormProcessor_ViewPageFields( $this->moduleRootPath, $this->viewer, $formAction, $this->pageID );
        
    } // end loadAddPageFields()



    //************************************************************************
	/**
	 * function loadAddPageLabels
	 * <pre>Initializes the AddPageLabels Page.</pre>
	 * @return [void]
	 */
    // RAD Tools: AdminBox Style
    function loadAddPageLabels() 
    {
        
        $formAction = $this->getCallBack(moduleRAD::PAGE_ADDPAGELABELS, $this->sortBy , $this->moduleID, $this->stateVarID, $this->daObjID, $this->daFieldID, $this->pageID, $this->pageLabelID, $this->transitionID, $this->sideBarID, $this->sideBarLinkID, $this->sideBarLabelID);//[RAD_CALLBACK_PARAMS]
        $this->pageDisplay = new FormProcessor_AddPageLabels( $this->moduleRootPath, $this->viewer, $formAction, $this->sortBy,  $this->pageLabelID, $this->pageID );//[RAD_FORMINIT_FOREIGNKEY_INIT]    
        
        $links = array();
        
        $continueLink = $this->getCallBack( moduleRAD::PAGE_VIEWPAGES, "" , $this->moduleID);//[RAD_CALLBACK_PARAMS]
        $links["cont"] = $continueLink;

        $editLink = $this->getCallBack( moduleRAD::PAGE_ADDPAGELABELS, $this->sortBy, $this->moduleID, $this->stateVarID, $this->daObjID, $this->daFieldID, $this->pageID, '', $this->transitionID, $this->sideBarID, $this->sideBarLinkID, $this->sideBarLabelID );//[RAD_CALLBACK_PARAMS_EDIT]
        $editLink .= "&". moduleRAD::PAGELABELID . "=";
        $links[ "edit" ] = $editLink;
        
        // NOTE: delete link is same as edit link for an AdminBox
        $links[ "del" ] = $editLink;

/*[RAD_LINK_INSERT]*/

        $sortByLink = $this->getCallBack( moduleRAD::PAGE_ADDPAGELABELS, '' , $this->moduleID, $this->stateVarID, $this->daObjID, $this->daFieldID, $this->pageID, $this->pageLabelID, $this->transitionID, $this->sideBarID, $this->sideBarLinkID, $this->sideBarLabelID);//[RAD_CALLBACK_PARAMS]
        $sortByLink .= "&".moduleRAD::SORTBY."=";
        $links["sortBy"] = $sortByLink;

        $this->pageDisplay->setLinks( $links );    
        
    } // end loadAddPageLabels()



    //************************************************************************
	/**
	 * function loadTransitions
	 * <pre>Initializes the Transitions Page.</pre>
	 * @return [void]
	 */
    // RAD Tools: AdminBox Style
    function loadTransitions() 
    {
        
        $formAction = $this->getCallBack(moduleRAD::PAGE_TRANSITIONS, $this->sortBy , $this->moduleID, $this->stateVarID, $this->daObjID, $this->daFieldID, $this->pageID, $this->pageLabelID, $this->transitionID, $this->sideBarID, $this->sideBarLinkID, $this->sideBarLabelID);//[RAD_CALLBACK_PARAMS]
        $this->pageDisplay = new FormProcessor_Transitions( $this->moduleRootPath, $this->viewer, $formAction, $this->sortBy,  $this->transitionID, $this->moduleID );//[RAD_FORMINIT_FOREIGNKEY_INIT]    
        
        $links = array();
        
        $continueLink = $this->getCallBack( moduleRAD::PAGE_VIEWMODULE, "" , $this->moduleID, $this->stateVarID, $this->daObjID, $this->daFieldID, $this->pageID, $this->pageLabelID, $this->transitionID, $this->sideBarID, $this->sideBarLinkID, $this->sideBarLabelID);//[RAD_CALLBACK_PARAMS]
        $links["cont"] = $continueLink;

        $editLink = $this->getCallBack( moduleRAD::PAGE_TRANSITIONS, $this->sortBy, $this->moduleID);//[RAD_CALLBACK_PARAMS_EDIT]
        $editLink .= "&". moduleRAD::TRANSITIONID . "=";
        $links[ "edit" ] = $editLink;
        
        // NOTE: delete link is same as edit link for an AdminBox
        $links[ "del" ] = $editLink;

/*[RAD_LINK_INSERT]*/

        $sortByLink = $this->getCallBack( moduleRAD::PAGE_TRANSITIONS, '' , $this->moduleID, $this->stateVarID, $this->daObjID, $this->daFieldID, $this->pageID, $this->pageLabelID, $this->transitionID, $this->sideBarID, $this->sideBarLinkID, $this->sideBarLabelID);//[RAD_CALLBACK_PARAMS]
        $sortByLink .= "&".moduleRAD::SORTBY."=";
        $links["sortBy"] = $sortByLink;

        $this->pageDisplay->setLinks( $links );    
        
    } // end loadTransitions()



    //************************************************************************
	/**
	 * function loadEditModule
	 * <pre>Initializes the EditModule Page.</pre>
	 * @return [void]
	 */
    function loadEditModule() 
    {
        
        $formAction = $this->getCallBack(moduleRAD::PAGE_EDITMODULE, $this->sortBy , $this->moduleID, $this->stateVarID, $this->daObjID, $this->daFieldID, $this->pageID, $this->pageLabelID, $this->transitionID, $this->sideBarID, $this->sideBarLinkID, $this->sideBarLabelID);//[RAD_CALLBACK_PARAMS]
        $this->pageDisplay = new FormProcessor_EditModule( $this->moduleRootPath, $this->viewer, $formAction, $this->moduleID );//[RAD_FORMINIT_FOREIGNKEY_INIT]        
        
    } // end loadEditModule()



    //************************************************************************
	/**
	 * function loadDeleteModule
	 * <pre>Initializes the DeleteModule Page.</pre>
	 * @return [void]
	 */
    function loadDeleteModule() 
    {
        
        $formAction = $this->getCallBack(moduleRAD::PAGE_DELETEMODULE, $this->sortBy , $this->moduleID, $this->stateVarID, $this->daObjID, $this->daFieldID, $this->pageID, $this->pageLabelID, $this->transitionID, $this->sideBarID, $this->sideBarLinkID, $this->sideBarLabelID);//[RAD_CALLBACK_PARAMS]
        $this->pageDisplay = new page_DeleteModule( $this->moduleRootPath, $this->viewer, $formAction, $this->moduleID );
                
    } // end loadDeleteModule()



    //************************************************************************
	/**
	 * function loadDeleteDAObj
	 * <pre>Initializes the DeleteDAObj Page.</pre>
	 * @return [void]
	 */
    function loadDeleteDAObj() 
    {
        
        $formAction = $this->getCallBack(moduleRAD::PAGE_DELETEDAOBJ, $this->sortBy , $this->moduleID, $this->stateVarID, $this->daObjID, $this->daFieldID, $this->pageID, $this->pageLabelID, $this->transitionID, $this->sideBarID, $this->sideBarLinkID, $this->sideBarLabelID);//[RAD_CALLBACK_PARAMS]
        $this->pageDisplay = new page_DeleteDAObj( $this->moduleRootPath, $this->viewer, $formAction, $this->daObjID );
                
    } // end loadDeleteDAObj()



    //************************************************************************
	/**
	 * function loadDeletePage
	 * <pre>Initializes the DeletePage Page.</pre>
	 * @return [void]
	 */
    function loadDeletePage() 
    {
        
        $formAction = $this->getCallBack(moduleRAD::PAGE_DELETEPAGE, $this->sortBy , $this->moduleID, $this->stateVarID, $this->daObjID, $this->daFieldID, $this->pageID, $this->pageLabelID, $this->transitionID, $this->sideBarID, $this->sideBarLinkID, $this->sideBarLabelID);//[RAD_CALLBACK_PARAMS]
        $this->pageDisplay = new page_DeletePage( $this->moduleRootPath, $this->viewer, $formAction, $this->pageID );
                
    } // end loadDeletePage()



/*[RAD_PAGE_LOAD_FN]*/		

}

?>