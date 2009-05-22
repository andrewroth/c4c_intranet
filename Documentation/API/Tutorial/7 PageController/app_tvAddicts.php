<?php
/**
 * @package TVAddicts
 * class moduleTVAddicts
 * discussion <pre>
 * Written By	:	Johnny Hausman
 * Date		:   2006 Jan 21
 * 
 * This is the application controller for the TV Addicts application. It's
 * job is to decide which page is to be displayed and guide those pages 
 * through the load, process, display phases.
 * 
 * </pre>	
 */
class moduleTVAddicts extends AppController {
// 		
//
//	CONSTANTS:
        
    /** const PAGE    The QueryString Page parameter. */
        const PAGE = "P";
        const PAGE_SERIESLIST = 'SL';
        const PAGE_SERIESEDIT = 'SE';
        
    /** const SERIES_ID    The QueryString variable marking which series to edit. */
        const SERIES_ID = "seriesID";
        
        
//
//	VARIABLES:
	


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
         
        // Load in the PageController's state variables
        $pageKey = moduleTVAddicts::PAGE;
        $page = $this->getQSValue( $pageKey, moduleTVAddicts::PAGE_SERIESLIST );
        $this->stateVariables[$pageKey] = $page;
                
        
        $seriesIDKey = moduleTVAddicts::SERIES_ID;
        $seriesID = $this->getQSValue( $seriesIDKey, '' );
        $this->stateVariables[$seriesIDKey] = $seriesID;
                
                
                
        // now descide which PageDisplay object to load
        switch( $page ) {
                 
            case moduleTVAddicts::PAGE_SERIESEDIT:
                $this->loadSeriesEdit();
                break;
        
        
            case moduleTVAddicts::PAGE_SERIESLIST: 
            default:
                $this->stateVariables[ $pageKey ] = moduleTVAddicts::PAGE_SERIESLIST;
                $this->loadSeriesList();
                break;
        
        }
        
        
        // Now call the parent loadData() to make sure any needed form data 
        // is loaded.
        parent::loadData();

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
        if ( $this->isFormSubmission() ) {
        
            // if form data is valid ...
            if ( $this->pageDisplay->isDataValid() ) {
            
                // process the data
                $this->pageDisplay->processData();
            
                // now switch to the proper next page ...
                switch( $this->stateVariables[ moduleTVAddicts::PAGE ] ) {
    
                    case moduleTVAddicts::PAGE_SERIESEDIT:
                        $this->loadSeriesList();
                        break;
                        
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
	}

    
    
    //************************************************************************
    /**
     * function loadSeriesEdit
     * <pre>
     * This routine loads the SeriesEdit page in the pageDisplay Object.
     * </pre>
     * @return [void]
     */
    function loadSeriesEdit() {
        
        // mark the value of the call back 
        $formAction = $this->getCallBack();
        
        // Create our nifty new PageDisplay object
        // The constructor acts like our old loadData() 
        $this->pageDisplay = new page_SeriesEdit( '', null, $formAction, $this->stateVariables[ moduleTVAddicts::SERIES_ID ] );
    
    }
    
    
    
    //************************************************************************
    /**
     * function loadSeriesList
     * <pre>
     * This routine loads the SeriesList page in the pageDisplay Object.
     * </pre>
     * @return [void]
     */
    function loadSeriesList() {
        
        // Create our nifty new PageDisplay object
        // The constructor acts like our old loadData() 
        $this->pageDisplay = new page_SeriesList( '', null, '');
        
        // our script is now responsible to know about the links of the 
        // application. So it creates an array of links for the template
        // to use.
        $newValues = $this->stateVariables;
        $newValues[ moduleTVAddicts::PAGE ] = moduleTVAddicts::PAGE_SERIESEDIT;
        $links[ 'edit' ] = $this->getCallBack( $newValues, moduleTVAddicts::SERIES_ID );
        $this->pageDisplay->setLinks( $links );
    
    }		

}

?>