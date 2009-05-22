<?php
/**
 * @package EmailTemplates
 class moduleEmailTemplates
 discussion <pre>
 Written By	:	Reuben Uy
 Date		:   24 Jan 2006
 
 A module for adding, editing, and removing templates
 
 </pre>	
*/
class moduleEmailTemplates extends XMLObject_PageContent {
// 		
//
//	CONSTANTS:

        
    /** const MULTILINGUAL_SERIES_KEY The Multilingual Series key for this application.. */
        const MULTILINGUAL_SERIES_KEY = 'moduleEmailTemplates';
        
    /** const MULTILINGUAL_PAGE_FIELDS The Multilingual Page key for the fields of this application. */
        const MULTILINGUAL_PAGE_FIELDS = 'fields_EmailTemplates';
        
    /** const MODULE_KEY The Module Key for this Module.  Used for access */
        const MODULE_KEY = 'EmailTemplates';
        
    /** const PAGE    The QueryString Page parameter. */
        const PAGE = "P";
        
    /*! const PAGE_TEMPLATEADMINPAGE   Display the TemplateAdminPage Page. */
        const PAGE_TEMPLATEADMINPAGE = "P1";

    /*! const PAGE_EDITTEMPLATE   Display the EditTemplate Page. */
        const PAGE_EDITTEMPLATE = "P6";

/*[RAD_PAGE_CONST]*/

    /** const SORTBY    The QueryString SortBy parameter. */
        const SORTBY = "modSort";
                

    /*! const TEMPLATE_ID   The QueryString TEMPLATE_ID parameter. */
        const TEMPLATE_ID = "SV1";

/*[RAD_PAGE_STATEVAR_CONST]*/
        
        
//
//	VARIABLES:
        
    /** protected $page   [STRING] The current Mode of this Module. */
		protected $page;
		
    /** protected $sortBy [STRING] Parameter to sort displayed Lists. */
        protected $sortBy;
		
    /*! protected $template_id   [INTEGER] The current template we're working with */
		protected $template_id;

/*[RAD_PAGE_STATEVAR_VAR]*/
		
   
    /** protected $pageDisplay [OBJECT] The display object for the page. */
        protected $pageDisplay;
        
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
//        $this->appID = $this->getQSValue( moduleEmailTemplates::APPID, '' );
        
/*[RAD_COMMON_LOAD]*/
         
        // load the module's page (DEFAULT = WELCOME)
        $this->page = $this->getQSValue( moduleEmailTemplates::PAGE, moduleEmailTemplates::PAGE_TEMPLATEADMINPAGE );
        
        // load the module's sortBy parameter (DEFAULT = '')
        $this->sortBy = $this->getQSValue( moduleEmailTemplates::SORTBY, '' );
        
        // load the module's TEMPLATE_ID variable
        $this->template_id = $this->getQSValue( moduleEmailTemplates::TEMPLATE_ID, "" );

/*[RAD_PAGE_LOAD_STATEVAR]*/
        
        switch( $this->page ) {
                
            /*
             *  TemplateAdminPage
             */
            case moduleEmailTemplates::PAGE_TEMPLATEADMINPAGE:
                $this->loadTemplateAdminPage();
                break;

            /*
             *  EditTemplate
             */
            case moduleEmailTemplates::PAGE_EDITTEMPLATE:
                $this->loadEditTemplate();
                break;

/*[RAD_PAGE_LOAD_CALL]*/
   
                 
            /*
             *  Just to make sure, default the pageDisplay to 
             *  the TemplateAdminPage page.
             */
            default:
                $this->page = moduleEmailTemplates::PAGE_TEMPLATEADMINPAGE;
                $this->loadTemplateAdminPage();
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
    
                    case moduleEmailTemplates::PAGE_EDITTEMPLATE:
                        $this->template_id = '';
                        $this->page = moduleEmailTemplates::PAGE_TEMPLATEADMINPAGE;
                        $this->loadTemplateAdminPage();                       
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
//             case moduleEmailTemplates::PAGE_DEFAULT:
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
	 * 'template_id' [INTEGER] The Desired TEMPLATE_ID of this Link.
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
            $callBack = moduleEmailTemplates::PAGE.'='.$page;
        }
        
        if ($sortBy != '') {
            if ($callBack != '') {
                $callBack .= '&';
            }
            $callBack .= moduleEmailTemplates::SORTBY.'='.$sortBy;
        }
        
        
        if ( isset( $parameters['template_id']) ) {
            if ( $parameters['template_id'] != '' ) {
                if ($callBack != '') {
                    $callBack .= '&';
                }
                $callBack .= moduleEmailTemplates::TEMPLATE_ID.'='.$parameters['template_id'];
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
        return moduleEmailTemplates::MULTILINGUAL_SERIES_KEY;
    }

    
    
    //************************************************************************
	/**
	 * function loadTemplateAdminPage
	 * <pre>
	 * Initializes the TemplateAdminPage Page.
	 * </pre>
	 * @return [void]
	 */
    // RAD Tools: DataListTable Style
    function loadTemplateAdminPage() 
    {
        // set the pageCallBack to be without any additional parameters
        // (an AdminBox needs this so Language Switching on a page doesn't
        // pass a previous operations)
        $parameters = array('template_id'=>$this->template_id);//[RAD_CALLBACK_PARAMS]
        $pageCallBack = $this->getCallBack(moduleEmailTemplates::PAGE_TEMPLATEADMINPAGE, $this->sortBy, $parameters);
        $this->setPageCallBack( $pageCallBack );
        
        
        $this->pageDisplay = new page_TemplateAdminPage( $this->moduleRootPath, $this->viewer, $this->sortBy, $this->template_id );    
        
        $links = array();
        
        $parameters = array( );//[RAD_CALLBACK_PARAMS_EDIT]
        $editLink = $this->getCallBack( moduleEmailTemplates::PAGE_EDITTEMPLATE, $this->sortBy, $parameters );
        $editLink .= "&". moduleEmailTemplates::TEMPLATE_ID . "=";
        $links["edit"] = $editLink;

/*[RAD_LINK_INSERT]*/

        $parameters = array('template_id'=>$this->template_id);//[RAD_CALLBACK_PARAMS]
        $sortByLink = $this->getCallBack( moduleEmailTemplates::PAGE_TEMPLATEADMINPAGE, '', $parameters );
        $sortByLink .= "&".moduleEmailTemplates::SORTBY."=";
        $links["sortBy"] = $sortByLink;

        $this->pageDisplay->setLinks( $links ); 
        
    } // end loadTemplateAdminPage()



    //************************************************************************
	/**
	 * function loadEditTemplate
	 * <pre>
	 * Initializes the EditTemplate Page.
	 * </pre>
	 * @return [void]
	 */
    // RAD Tools: FormSingleEntry style
    function loadEditTemplate() 
    {
        // set the pageCallBack to be without any additional parameters
        // (an AdminBox needs this so Language Switching on a page doesn't
        // pass a previous operations)
        $parameters = array('template_id'=>$this->template_id);//[RAD_CALLBACK_PARAMS]
        $pageCallBack = $this->getCallBack(moduleEmailTemplates::PAGE_EDITTEMPLATE, $this->sortBy, $parameters);
        $this->setPageCallBack( $pageCallBack );
        
        
        $parameters = array('template_id'=>$this->template_id);//[RAD_CALLBACK_PARAMS]
        $formAction = $this->getCallBack(moduleEmailTemplates::PAGE_EDITTEMPLATE, $this->sortBy, $parameters );
        $this->pageDisplay = new FormProcessor_EditTemplate( $this->moduleRootPath, $this->viewer, $formAction, $this->template_id );//[RAD_FORMINIT_FOREIGNKEY_INIT]        
        
    } // end loadEditTemplate()



/*[RAD_PAGE_LOAD_FN]*/		

}

?>