<?php

// First load the common Registration Summaries Tools object
// This object allows for efficient access to registration summary data (multi-table).
$fileName = 'Tools/tools_RegSummaries.php';
$path = Page::findPathExtension( $fileName );
require_once( $path.$fileName);

/**
 * @package cim_reg
 */ 
/**
 * class page_DownloadRegistrationSummary
 * <pre> 
 * A generic report download page (for a single report type - in this case an AIA reg summary report)
 * </pre>
 * @author Hobbe Smit
 * Date:   10 Oct 2007
 */
class  page_DownloadAIARegReport extends PageDisplay {

	//CONSTANTS:
	
	/** The list of fields to be displayed */
//    const DISPLAY_FIELDS = '';
    
    /** The Multilingual Page Key for labels on this page */
    const MULTILINGUAL_PAGE_KEY = 'page_DownloadAIARegReport';
    

	//VARIABLES:
	
	/** @var [OBJECT] The viewer object. */
 	protected $viewer;
	
    /** @var [STRING] The path to this module's root directory. */
	protected $pathModuleRoot;
	
    /** @var [STRING] The type of download this page manages. */
	protected $download_type;	
	
    /** @var [STRING] The event ID filter for the data to download. */
	protected $event_id;	
	
    /** @var [STRING] The campus ID filter for the data to download. */
// 	protected $campus_id;			
	
	/** @var [INTEGER] The initilization value for the listManager. */
//	protected $managerInit;
/* no List Init Variable defined for this DAObj */
		
	
	//CLASS CONSTRUCTOR
	//************************************************************************
	/**
	 * function __construct
	 * <pre>
	 * Initialize the object.
	 * </pre>
	 * @param $pathModuleRoot [STRING] The path to the module's root dir.
	 * @param $viewer [OBJECT] The viewer object.
	 * @param $downloadType [STRING] Used to decide which file to overwrite with recent report
	 * @param $eventID [STRING] Identifies the event to filter data by
     * @param $managerInit [INTEGER] Initialization value for the listManager.
	 * @return [void]
	 */
    function __construct($pathModuleRoot, $viewer,  $eventID = '') 
    {
        parent::__construct( );
        
        $this->pathModuleRoot = $pathModuleRoot;
        $this->viewer = $viewer;       
        
        			// if viewer is NOT authenticated then
			if ( !($this->viewer->isAuthenticated() ) ) {
	        
// 	            // if the requested page wasn't PAGE_MODULE_LOGIN then
// 	            if ( $this->moduleKey != PAGE_MODULE_LOGIN) {
// 	            
// 	                // Store requested PageContent Module & QueryString info in Session CallBack
// 	                // NOTE: I use SERVER_ADDR + SCRIPT_URL instead of SCRIPT_URI 
// 	                // since mac web servers tend to use rendezvous names which 
// 	                // means nothing on Windows systems ...
// 	                $baseCallBack = $this->getBaseURL(). '?' .$_SERVER['QUERY_STRING'];
// 	                $_SESSION[ SESSION_ID_CALLBACK ] = $baseCallBack;
// 	            
// 	                $this->debug( 'Viewer NOT Authenticated.<br>Storing baseCallBack=['.$baseCallBack.']<br>' );
// 	            
// 	                // set current PageContent Module to Login
// 	                $this->moduleKey = PAGE_MODULE_LOGIN;
// 	                
// 	            } // end if moduleKey != PAGE_MODULE_LOGIN
	            
	        } // end if
        
        // overwrites data in a file determined by $reportType and located at SITE_PATH_REPORTS
        $this->storeReportData($eventID);
        
        $this->event_id = $eventID;
                
//        $this->managerInit = $managerInit;
        
/*
        $dataAccessObject = new RowManager_EventManager();
        // only display those rows that are supposed to be displayed on the home page
        $dataAccessObject->setOnHomePage( true );
        $dataAccessObject->setSortOrder( $sortBy );
//        $this->listManager = new EventList( $sortBy );
        $this->listManager = $dataAccessObject->getListIterator();
 */        
         // now initialize the labels for this page
         // start by loading the default field labels for this Module
         $languageID = $viewer->getLanguageID();
         $seriesKey = modulecim_reg::MULTILINGUAL_SERIES_KEY;
         $pageKey = modulecim_reg::MULTILINGUAL_PAGE_FIELDS;
         $this->labels = new MultilingualManager( $languageID, $seriesKey, $pageKey );
         
         // then load the page specific labels for this page
         $pageKey = page_DownloadAIARegReport::MULTILINGUAL_PAGE_KEY;
         $this->labels->loadPageLabels( $pageKey );
         
         $this->labels->setSeriesKey( SITE_LABEL_SERIES_SITE );
         $this->labels->loadPageLabels( SITE_LABEL_PAGE_FORM_LINKS );
         
    }



	//CLASS FUNCTIONS:
	//************************************************************************
	/**
	 * function classMethod
	 * <pre>
	 * [classFunction Description]
	 * </pre>
	 * <pre><code>
	 * [Put PseudoCode Here]
	 * </code></pre>
	 * @param $param1 [$param1 type][optional description of $param1]
	 * @param $param2 [$param2 type][optional description of $param2]
	 * @return [returnValue, can be void]
	 */
    function classMethod($param1, $param2) 
    {
        // CODE
    }	    
    
    
    
    //************************************************************************
	/**
	 * function getHTML
	 * <pre>
	 * This method returns the HTML data generated by this object.
	 * </pre>
	 * @return [STRING] HTML Display data.
	 */
    function getHTML() 
    {
    
        // Make a new Template object
        $path = SITE_PATH_TEMPLATES;
        // Replace $path with the following line if you want to create a
        // template tailored for this page:
        //$path = $this->pathModuleRoot.'templates/';
        
        $this->prepareTemplate( $path );
        
        // store the link values
        // $this->linkValues[ 'view' ] = 'add/new/href/data/here';

        
        // store the link labels
        $this->linkLabels[ 'add' ] = $this->labels->getLabel( '[Add]' );
        $this->linkLabels[ 'edit' ] = $this->labels->getLabel( '[Edit]' );
        $this->linkLabels[ 'del'  ] = $this->labels->getLabel( '[Delete]' );
        $this->linkLabels[ 'cont' ] = $this->labels->getLabel( '[Continue]');
        // $this->linkLabels[ 'view' ] = 'new link label here';

	     $downloadLinks[ 'DownloadEventDataDump' ]  = $this->linkValues[ 'DownloadEventDataDump' ];

        
        $this->template->set('linksList', $downloadLinks );
                 
        
        // store any additional link Columns
        // example:
            //$title = $this->labels->getLabel( '[title_groups]');
            //$columnLabel = $this->labels->getLabel( '[groups]');
            //$link = $this->linkValues[ 'groups' ];
            //$fieldName = 'accessgroup_id';
            //$this->addLinkColumn( $title, $columnLabel, $link, $fieldName);
            
            // echo "<pre>".print_r($this->linkValues, true)."</pre>";
/*   
            $title = $this->labels->getLabel( '[Details]');
            $columnLabel = $this->labels->getLabel( '[View]');
            $link = $this->linkValues[ 'view' ];
            $fieldName = 'event_id';
            $this->addLinkColumn( $title, $columnLabel, $link, $fieldName);
*/
        
        // store the page labels
        // NOTE: use this location to update any label tags ...
        // example:
            // $name = $user->getName();
            // $this->labels->setLabelTag( '[Title]', '[userName]', $name);
            
        

        
        // store the Row Manager's XML Node Name
//        $this->template->set( 'rowManagerXMLNodeName', RowManager_EventManager::XML_NODE_NAME );
        
        // store the primary key field name for the data being displayed
//        $this->template->set( 'primaryKeyFieldName', 'event_id');


        /*
         *  Set up any additional data transfer to the Template here...
         */
//        $this->template->set( 'disableHeading', true );
   
        $templateName = 'siteLinkList.php';
		// if you are creating a custom template for this page then 
		// replace $templateName with the following:
		//$templateName = 'page_HomePageEventList.php';
		
		return $this->template->fetch( $templateName );
        
    }
    

    // stores summary data in the appropriate report file (i.e. overwrites data with current data)
    protected function storeReportData($eventID = '')
    {
	   $fileDir = SITE_PATH_REPORTS;
	   $fileName = '';
	    
    	$dataGetter = new RegSummaryTools();

 		$fileName =  modulecim_reg::AIA_CSV_FILE_NAME;
 		$fileData = $dataGetter->getCSVforAIAEvent( $eventID);  				

			// BEGIN: CODE MODIFIED FROM 'fwrite()' IN PHP.NET DOCUMENTATION    >>> TODO?: write each record as it is read
			
			// Let's make sure the file exists and is writable first.
			//if (is_writable($filename)) {
			
			   // In our example we're opening $filename in append mode.
			   // The file pointer is at the bottom of the file hence
			   // that's where $somecontent will go when we fwrite() it.
			   if (!$handle = fopen($fileDir.$fileName, 'w')) {
			         echo "Cannot open file ($fileDir.$fileName)";
			         exit;
			   }
			
			   // Write $somecontent to our opened file.
			   if (fwrite($handle, $fileData) === FALSE) {
			       echo "Cannot write to file ($fileDir.$fileName)";
			       exit;
			   }
			  
			   //echo "Success, wrote ($fileData) to file ($fileName)";
			  
			   fclose($handle);
			
			//} else {
			//   echo "The file $filename is not writable";
			//}
			
		return $fileName;
	}	    
    
        
}

?>