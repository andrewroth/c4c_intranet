<?php
/**
 * @package cim_hrdb
 */ 
/**
 * class page_NotAuthorized
 * <pre> 
 * Page to display upon un-authorized access of some part of the HRDB system
 * </pre>
 * @author Hobbe Smit
 * Date:   17 Jan 2008  (cim_reg: 29 Aug 2007)
 */
 // RAD Tools: Custom Page
class  page_NotAuthorized extends PageDisplay {

	//CONSTANTS:
    
    /** The Multilingual Page Key for labels on this page */
    const MULTILINGUAL_PAGE_KEY = 'page_NotAuthorized';
    

	//VARIABLES:
	
	/** @var [OBJECT] The viewer object. */
	protected $viewer;
	
    /** @var [STRING] The path to this module's root directory. */
	protected $pathModuleRoot;
	
		

	//CLASS CONSTRUCTOR
	//************************************************************************
	/**
	 * function __construct
	 * <pre>
	 * Initialize the object.
	 * </pre>
	 * @param $pathModuleRoot [STRING] The path to the module's root dir.
	 * @param $viewer [OBJECT] The viewer object.
	 * @return [void]
	 */
    function __construct($pathModuleRoot, $viewer)
    {
    
        parent::__construct();
        
        // initialzie the object values
        $this->pathModuleRoot = $pathModuleRoot;
        $this->viewer = $viewer;
        
        // now initialize the labels for this page
        // start by loading the default field labels for this Module
        $languageID = $viewer->getLanguageID();
        $seriesKey = modulecim_hrdb::MULTILINGUAL_SERIES_KEY;
        $pageKey = page_NotAuthorized::MULTILINGUAL_PAGE_KEY;
        $this->labels = new MultilingualManager( $languageID, $seriesKey, $pageKey );

         
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

        // Uncomment the following line if you want to create a template 
        // tailored for this page:
        $path = $this->pathModuleRoot.'templates/';
        // Otherwise use the standard Templates for the site:
        //$path = SITE_PATH_TEMPLATES;
        

        /*
         * Update any label tags ...
         */
        // example:
            // $name = $user->getName();
            // $this->labels->setLabelTag( '[Title]', '[userName]', $name);


        // NOTE:  this parent method prepares the $this->template with the 
        // common Display data.  
        $this->prepareTemplate($path);


        // uncomment this line if you are creating a template for this page
		$templateName = 'page_NotAuthorized.tpl.php';
		// otherwise use the generic site template
		//$templateName = '';
		
		return $this->template->fetch( $templateName );
        
    }
    
    
	
}

?>