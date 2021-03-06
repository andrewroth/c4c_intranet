<?php
/**
 * @package [ModuleName]
 */ 
/**
 * class [PageNamePrefix][PageName] 
 * <pre> 
 * [PageDescription]
 * </pre>
 * @author [CreatorName]
 * Date:   [CreationDate]
 */
 // RAD Tools: DataSingle Page
class  [PageNamePrefix][PageName] extends PageDisplay_DisplaySingle {

	//CONSTANTS:
    
    /** The list of fields to be displayed */
    const DISPLAY_FIELDS = '[RAD_FIELDNAME_LIST]';
    
    /** The Multilingual Page Key for labels on this page */
    const MULTILINGUAL_PAGE_KEY = '[PageNamePrefix][PageName]';
    

	//VARIABLES:
	
	/** @var [OBJECT] The viewer object. */
	protected $viewer;
	
    /** @var [STRING] The path to this module's root directory. */
	protected $pathModuleRoot;
	
	/** @var [INTEGER] The initialization value for the itemManager. */
	protected $[RAD_FORM_INIT];



	//CLASS CONSTRUCTOR
	//************************************************************************
	/**
	 * function __construct
	 * <pre>
	 * Initialize the object.
	 * </pre>
	 * @param $pathModuleRoot [STRING] The path to the module's root dir.
	 * @param $viewer [OBJECT] The viewer object.
     * @param $[RAD_FORM_INIT] [INTEGER] Initialization value for the itemManager.
	 * @return [void]
	 */
    function __construct($pathModuleRoot, $viewer, $[RAD_FORM_INIT] ) 
    {
    
        parent::__construct( [PageNamePrefix][PageName]::DISPLAY_FIELDS );
        
        // initialzie the object values
        $this->pathModuleRoot = $pathModuleRoot;
        $this->viewer = $viewer;

        $this->[RAD_FORM_INIT] = $[RAD_FORM_INIT];

        
        // create the item Manager to display
        $this->itemManager = new RowManager_[RAD_DAOBJ_MANAGER_NAME]( $[RAD_FORM_INIT] );
        
        // now initialize the labels for this page
        // start by loading the default field labels for this Module
        $languageID = $viewer->getLanguageID();
        $seriesKey = module[ModuleName]::MULTILINGUAL_SERIES_KEY;
        $pageKey = module[ModuleName]::MULTILINGUAL_PAGE_FIELDS;
        $this->labels = new MultilingualManager( $languageID, $seriesKey, $pageKey );
        
        // then load the page specific labels for this page
        $pageKey = [PageNamePrefix][PageName]::MULTILINGUAL_PAGE_KEY;
        $this->labels->loadPageLabels( $pageKey );
         
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
        //$path = $this->pathModuleRoot.'[RAD_PATH_TEMPLATES]';
        // Otherwise use the standard Templates for the site:
        $path = SITE_PATH_TEMPLATES;
        

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
		//$templateName = '[PageNamePrefix][PageName].php';
		// otherwise use the generic site template
		$templateName = '[RAD_TEMPLATE_DEFAULT]';
		
		return $this->template->fetch( $templateName );
        
    }
	
}

?>