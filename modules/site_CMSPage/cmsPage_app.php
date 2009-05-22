<?php
/**
 * class moduleCMSPage
 * <pre>
 * Written By:	Johnny Hausman
 * Date:    12 Sep '04
 *
 * This is the CMS Page module.  It controls the displaying of our CMS Based
 * Pages.
 *
 *</pre>
 */
class moduleCMSPage extends XMLObject_PageContent {
// 		
//
//	CONSTANTS:
        
    /** const NODE_CSS    NodeName for the XML CSS data. */
        const ELEMENT_CSS = 'style';
        
    /** const Mode    The QueryString Mode parameter. */
        const MODE = 'M';

    /** const MODE_DISPLAY    Display the CMS Page. */
        const MODE_DISPLAY = "D";
        
    /** const MODE_SUBMIT    A Submition From the CMS Page. */
        const MODE_SUBMIT = "S";
        
    /** const PAGE    The QueryString Page (Key)  parameter. */
        const PAGE = "P";
        
    /** const PAGE_DEFAULT  A Default Page(Key) if none is provided. */
        const PAGE_DEFAULT = "Welcome";

 
//
//	VARIABLES:

    /** @var [STRING] The current Mode of this Module. */
		protected $mode;
		
    /** @var [STRING] The Unique Handle for the desired Page. */
		protected $pageKey;
		
     /** @var [STRING] The Error messages for this app. */
        protected $errorMessages;

//
//	CLASS FUNCTIONS:
//

	
	//************************************************************************
	/** 
	 * function loadData
	 *
	 * Provided function to allow object to load it's data.
	 *
	 * @param $name [STRING] The name of the StyleSheet.
	 * @param $path [STRING] The path to the StyleSheet.
	 */
	function loadData( ) 
	{
        
        // load the module's mode (DEFAULT = DISPLAY)
        $this->mode = $this->getQSValue( moduleCMSPage::MODE, moduleCMSPage::MODE_DISPLAY );
        $this->pageKey = $this->getQSValue( moduleCMSPage::PAGE, moduleCMSPage::PAGE_DEFAULT );

        
        switch( $this->mode ) {
        
 /*           case moduleCMSPage::MODE_FORM:
                
                if ( $this->viewer->isAuthenticated() == false ) {
                
                    $this->mode = moduleCMSPage::MODE_DISPLAY;
                }
                break;
*/
        
        } // end switch

	} // end loadData()
	
	
	
    //************************************************************************
	/** 
	 * function processData
	 *
	 * Provided function to allow an object to process it's data.
	 */
	function processData( ) 
	{

        switch( $this->mode ) {
        
            case moduleCMSPage::MODE_SUBMIT:
           
                 break;
        
        } // end switch

	} // end processData()
	
	
	
	//************************************************************************
	/** 
	 * function prepareDisplayData
	 *
	 * Provided function to allow an object to prepare it's data for 
	 * displaying (actually done in the Page Object).
	 */
	function prepareDisplayData( ) 
	{
	
        $cmsPage = new CMSPage( $this->viewer );

        $cmsPage->loadPage( $this->pageKey );
        
        $pageTitle = $cmsPage->getPageTitle( $this->labels );
        $this->setPageTitle( $pageTitle );
        
        $template = & new Template( $this->moduleRootPath.'templates/' );

        $template->setXML( 'CMSPage', $cmsPage->getXML() );
        
        $template->set( 'desiredZone', 'main' );
		
		$templateName = $cmsPage->getPageTemplateName();
		if ($templateName != '') {
    		$content = $template->fetch( $templateName );
        } else {
            $content = '';
        }
        
        // Finally store HTML content as this page's content Item
        $this->addContent( $content );
        
        
        $template->set( 'desiredZone', 'side' );
        if ($templateName != '') {
    		$content = $template->fetch( $templateName );
        } else {
            $content = '';
        }
        $this->addSideBarContent( $content );
        
        $this->pageMenu->addLink( 'LinkName', 'LinkHREF');

	} // end prepareDisplayData()
	
	
	
    //************************************************************************
	/**
	 * function getCallBack
	 * <pre>
	 * Builds the proper HREF link for a desired action.
	 * </pre>
	 *
	 * @param $mode [STRING] The Desired MODE of this Link.
	 * @return [STRING] The Link.
	 */
    function getCallBack($mode='') 
    {
        $returnValue = $this->baseCallBack;
        
        $callBack = '';
        
        if ($mode != '') {
            $callBack = moduleCMSPage::MODE.'='.$mode;
        }
        
        if ( $callBack != '') {
            $returnValue .= '&'.$callBack;
        }
        
        return $returnValue;
        
    } // end getCallBack()
    
}

?>