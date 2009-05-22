<?php
/**
 * @package [ModuleName]
 class module[ModuleName]
 discussion <pre>
 Written By	:	[CreatorName]
 Date		:   [CreationDate]
 
 [ModuleDescription]
 
 </pre>	
*/
class module[ModuleName] extends XMLObject_PageContent {
// 		
//
//	CONSTANTS:

        
    /** const MULTILINGUAL_SERIES_KEY The Multilingual Series key for this application.. */
        const MULTILINGUAL_SERIES_KEY = 'module[ModuleName]';
        
    /** const MULTILINGUAL_PAGE_FIELDS The Multilingual Page key for the fields of this application. */
        const MULTILINGUAL_PAGE_FIELDS = 'fields_[ModuleName]';
        
    /** const MODULE_KEY The Module Key for this Module.  Used for access */
        const MODULE_KEY = '[ModuleName]';
        
    /** const PAGE    The QueryString Page parameter. */
        const PAGE = "P";
        
/*[RAD_PAGE_CONST]*/

    /** const SORTBY    The QueryString SortBy parameter. */
        const SORTBY = "modSort";
                

/*[RAD_PAGE_STATEVAR_CONST]*/
        
        
//
//	VARIABLES:
        
    /** protected $page   [STRING] The current Mode of this Module. */
		protected $page;
		
    /** protected $sortBy [STRING] Parameter to sort displayed Lists. */
        protected $sortBy;
		
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
//        $this->appID = $this->getQSValue( module[ModuleName]::APPID, '' );
        
/*[RAD_COMMON_LOAD]*/
         
        // load the module's page (DEFAULT = WELCOME)
        $this->page = $this->getQSValue( module[ModuleName]::PAGE, module[ModuleName]::[RAD_PAGE_DEFAULT_CONSTNAME] );
        
        // load the module's sortBy parameter (DEFAULT = '')
        $this->sortBy = $this->getQSValue( module[ModuleName]::SORTBY, '' );
        
/*[RAD_PAGE_LOAD_STATEVAR]*/
        
        switch( $this->page ) {
                
/*[RAD_PAGE_LOAD_CALL]*/
   
                 
            /*
             *  Just to make sure, default the pageDisplay to 
             *  the [RAD_PAGE_DEFAULT_PAGENAME] page.
             */
            default:
                $this->page = module[ModuleName]::[RAD_PAGE_DEFAULT_CONSTNAME];
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

/*[RAD_COMMON_LOAD_HTML]*/

        // store HTML content as this page's content Item
        $this->addContent( $content );
        
         
        // Add any necessary javascripts for this page:
        switch( $this->page ) {
        
/*[RAD_PAGE_JAVASCRIPTS]*/
//             case module[ModuleName]::PAGE_DEFAULT:
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
            $callBack = module[ModuleName]::PAGE.'='.$page;
        }
        
        if ($sortBy != '') {
            if ($callBack != '') {
                $callBack .= '&';
            }
            $callBack .= module[ModuleName]::SORTBY.'='.$sortBy;
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
        return module[ModuleName]::MULTILINGUAL_SERIES_KEY;
    }

    
    
/*[RAD_PAGE_LOAD_FN]*/		

}

?>