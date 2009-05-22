    //************************************************************************
	/**
	 * function load[RAD_PAGEINIT_NAME]
	 * <pre>
	 * Initializes the [RAD_PAGEINIT_NAME] Page.
	 * </pre>
	 * @return [void]
	 */
    // RAD Tools: Custom style
    function load[RAD_PAGEINIT_NAME]() 
    {
        // set the pageCallBack to be without any additional parameters
        // (an AdminBox needs this so Language Switching on a page doesn't
        // pass a previous operations)
        $parameters = array();//[RAD_CALLBACK_PARAMS]
        $pageCallBack = $this->getCallBack(module[ModuleName]::[RAD_PAGE_CONSTNAME], $this->sortBy, $parameters);
        $this->setPageCallBack( $pageCallBack );
        
        
        $this->pageDisplay = new [PageNamePrefix][PageName]( $this->moduleRootPath, $this->viewer );   
        
        $links = array();
        
/*[RAD_LINK_INSERT]*/

        $this->pageDisplay->setLinks( $links );     
        
    } // end load[RAD_PAGEINIT_NAME]()