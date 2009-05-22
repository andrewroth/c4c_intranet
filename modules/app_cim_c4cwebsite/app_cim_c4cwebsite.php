<?php
/**
 * @package cim_c4cwebsite
 class modulecim_c4cwebsite
 discussion <pre>
 Written By	:	Russ Martin, Jon Baelde, Valera Strugov
 Date		:   10 Jul 2007
 
 Manages CMS related things for the C4C website
 
 </pre>	
*/
class modulecim_c4cwebsite extends XMLObject_PageContent {
// 		
//
//	CONSTANTS:

        
    /** const MULTILINGUAL_SERIES_KEY The Multilingual Series key for this application.. */
        const MULTILINGUAL_SERIES_KEY = 'modulecim_c4cwebsite';
        
    /** const MULTILINGUAL_PAGE_FIELDS The Multilingual Page key for the fields of this application. */
        const MULTILINGUAL_PAGE_FIELDS = 'fields_cim_c4cwebsite';
        
    /** const MODULE_KEY The Module Key for this Module.  Used for access */
        const MODULE_KEY = 'cim_c4cwebsite';
        
    /** const PAGE    The QueryString Page parameter. */
        const PAGE = "P";
        
    /** const PAGE_EDITPAGES   Display the EditPages Page. */
        const PAGE_EDITPAGES = "P49";

/*[RAD_PAGE_CONST]*/

    /** const SORTBY    The QueryString SortBy parameter. */
        const SORTBY = "modSort";
                

    /*! const PAGE_ID   The QueryString PAGE_ID parameter. */
        const PAGE_ID = "SV41";

/*[RAD_PAGE_STATEVAR_CONST]*/
        
        
//
//	VARIABLES:
        
    /** protected $page   [STRING] The current Mode of this Module. */
		protected $page;
		
    /** protected $sortBy [STRING] Parameter to sort displayed Lists. */
        protected $sortBy;
		
    /*! protected $PAGE_ID   [INTEGER] unique identifier for pages */
		protected $PAGE_ID;

/*[RAD_PAGE_STATEVAR_VAR]*/
		
   
    /** protected $pageDisplay [OBJECT] The display object for the page. */
        protected $pageDisplay;
        
    /** protected $pageCommonDisplay [OBJECT] The display object for the common page layout. */
        protected $pageCommonDisplay;

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
//        $this->appID = $this->getQSValue( modulecim_c4cwebsite::APPID, '' );
        
        // load the common page layout object
        $this->pageCommonDisplay = new CommonDisplay( $this->moduleRootPath, $this->pathToRoot, $this->viewer);
         
        // load the module's page (DEFAULT = WELCOME)
        // TODO, change this once there becomes a home page
        $this->page = $this->getQSValue( modulecim_c4cwebsite::PAGE, modulecim_c4cwebsite::PAGE_EDITPAGES );
        
        // load the module's sortBy parameter (DEFAULT = '')
        $this->sortBy = $this->getQSValue( modulecim_c4cwebsite::SORTBY, '' );
        
        // load the module's PAGE_ID variable
        $this->PAGE_ID = $this->getQSValue( modulecim_c4cwebsite::PAGE_ID, "" );

/*[RAD_PAGE_LOAD_STATEVAR]*/
        
        switch( $this->page ) {
                
            /*
             *  EditPages
             */
            case modulecim_c4cwebsite::PAGE_EDITPAGES:
                $this->loadEditPages();
                break;

/*[RAD_PAGE_LOAD_CALL]*/
   
                 
            /*
             *  Just to make sure, default the pageDisplay to 
             *  the [RAD_PAGE_DEFAULT_PAGENAME] page.
             */
            default:
                  // TODO, change this once there is a default page
                $this->page = modulecim_c4cwebsite::PAGE_EDITPAGES;
                $this->load[RAD_PAGE_DEFAULT_PAGENAME]();
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
    
                    case modulecim_c4cwebsite::PAGE_EDITPAGES:
                        // NOTE: after a successful submit on an AdminBox style
                        // form, set the managerInit variable back to ''
                        $this->PAGE_ID = '';
                        $this->loadEditPages( true );                     
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
        
         
        // Add any necessary javascripts for this page:
        switch( $this->page ) {
        
/*[RAD_PAGE_JAVASCRIPTS]*/
//             case modulecim_c4cwebsite::PAGE_DEFAULT:
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
	 * 'PAGE_ID' [INTEGER] The Desired PAGE_ID of this Link.
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
            $callBack = modulecim_c4cwebsite::PAGE.'='.$page;
        }
        
        if ($sortBy != '') {
            if ($callBack != '') {
                $callBack .= '&';
            }
            $callBack .= modulecim_c4cwebsite::SORTBY.'='.$sortBy;
        }
        
        
        if ( isset( $parameters['PAGE_ID']) ) {
            if ( $parameters['PAGE_ID'] != '' ) {
                if ($callBack != '') {
                    $callBack .= '&';
                }
                $callBack .= modulecim_c4cwebsite::PAGE_ID.'='.$parameters['PAGE_ID'];
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
        return modulecim_c4cwebsite::MULTILINGUAL_SERIES_KEY;
    }

    
    
    //************************************************************************
	/**
	 * function loadEditPages
	 * <pre>
	 * Initializes the EditPages Page.
	 * </pre>
	 * @param $isCreated [BOOL] "Is THIS pageDisplay object already created?"
	 * @return [void]
	 */
    // RAD Tools: AdminBox Style
    function loadEditPages( $isCreated=false ) 
    {
        
        // compile a formAction for the adminBox
        $parameters = array('PAGE_ID'=>$this->PAGE_ID);//[RAD_CALLBACK_PARAMS]
        $formAction = $this->getCallBack(modulecim_c4cwebsite::PAGE_EDITPAGES, $this->sortBy, $parameters );
        
        // set the pageCallBack value.  This is used by the Language switching
        // code
        $this->setPageCallBack( $formAction );
        
        // if this pageDisplay object isn't already created then 
        if ( !$isCreated ) {
        
            // create a new pageDisplay object
            $this->pageDisplay = new FormProcessor_EditPages( $this->moduleRootPath, $this->viewer, $formAction, $this->sortBy,  $this->PAGE_ID, $this->PAGE_ID );//[RAD_FORMINIT_FOREIGNKEY_INIT]    
        
        } else {
        
            // otherwise just update the formAction value
            $this->pageDisplay->setFormAction( $formAction );
        }
        
        $links = array();
        
        $parameters = array( );//[RAD_CALLBACK_PARAMS_EDIT]
        $editLink = $this->getCallBack( modulecim_c4cwebsite::PAGE_EDITPAGES, $this->sortBy, $parameters );
        $editLink .= "&". modulecim_c4cwebsite::PAGE_ID . "=";
        $links[ "edit" ] = $editLink;
        
        // NOTE: delete link is same as edit link for an AdminBox
        $links[ "del" ] = $editLink;

/*[RAD_LINK_INSERT]*/

        $parameters = array('PAGE_ID'=>$this->PAGE_ID);//[RAD_CALLBACK_PARAMS]
        $sortByLink = $this->getCallBack( modulecim_c4cwebsite::PAGE_EDITPAGES, '', $parameters );
        $sortByLink .= "&".modulecim_c4cwebsite::SORTBY."=";
        $links["sortBy"] = $sortByLink;

        $this->pageDisplay->setLinks( $links );    
        
    } // end loadEditPages()



/*[RAD_PAGE_LOAD_FN]*/		

}

?>