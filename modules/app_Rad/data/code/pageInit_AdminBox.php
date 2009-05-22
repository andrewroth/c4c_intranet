    //************************************************************************
	/**
	 * function load[RAD_PAGEINIT_NAME]
	 * <pre>
	 * Initializes the [RAD_PAGEINIT_NAME] Page.
	 * </pre>
	 * @param $isCreated [BOOL] "Is THIS pageDisplay object already created?"
	 * @return [void]
	 */
    // RAD Tools: AdminBox Style
    function load[RAD_PAGEINIT_NAME]( $isCreated=false ) 
    {
        
        // compile a formAction for the adminBox
        $parameters = array();//[RAD_CALLBACK_PARAMS]
        $formAction = $this->getCallBack(module[ModuleName]::[RAD_PAGE_CONSTNAME], $this->sortBy, $parameters );
        
        // set the pageCallBack value.  This is used by the Language switching
        // code
        $this->setPageCallBack( $formAction );
        
        // if this pageDisplay object isn't already created then 
        if ( !$isCreated ) {
        
            // create a new pageDisplay object
            $this->pageDisplay = new [PageNamePrefix][PageName]( $this->moduleRootPath, $this->viewer, $formAction, $this->sortBy,  [RAD_PAGEINIT_FORMINIT_VAR][RAD_PAGEINIT_LISTINIT_VAR] );//[RAD_FORMINIT_FOREIGNKEY_INIT]    
        
        } else {
        
            // otherwise just update the formAction value
            $this->pageDisplay->setFormAction( $formAction );
        }
        
        $links = array();
        
/*[RAD_LINK_INSERT]*/

        $parameters = array();//[RAD_CALLBACK_PARAMS]
        $sortByLink = $this->getCallBack( module[ModuleName]::[RAD_PAGE_CONSTNAME], '', $parameters );
        $sortByLink .= "&".module[ModuleName]::SORTBY."=";
        $links["sortBy"] = $sortByLink;

        $this->pageDisplay->setLinks( $links );    
        
    } // end load[RAD_PAGEINIT_NAME]()