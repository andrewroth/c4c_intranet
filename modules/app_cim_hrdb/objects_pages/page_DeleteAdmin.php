<?php
/**
 * @package cim_hrdb
 */ 
/**
 * class page_DeleteAdmin 
 * <pre> 
 * A Confirmation page for deleting admins.
 * </pre>
 * @author CIM Team
 * Date:   06 Apr 2006
 */
// RAD Tools : Delete Confirmation Style
class  page_DeleteAdmin extends PageDisplay_DeleteConf {

	//CONSTANTS:
    
    /** The list of fields to be displayed */
    const DISPLAY_FIELDS = 'person_id';
    
    /** The Multilingual Page Key for labels on this page */
    const MULTILINGUAL_PAGE_KEY = 'page_DeleteAdmin';
    

	//VARIABLES:
	
	/** @var [OBJECT] The viewer object. */
	protected $viewer;
	
    /** @var [STRING] The path to this module's root directory. */
	protected $pathModuleRoot;
	
	/** @var [INTEGER] The Initialization value for the itemManager. */
	protected $managerInit;
	


	//CLASS CONSTRUCTOR
	//************************************************************************
	/**
	 * function __construct
	 * <pre>
	 * Initialize the object.
	 * </pre>
	 * @param $pathModuleRoot [STRING] The path to the module's root dir.
	 * @param $viewer [OBJECT] The viewer object.
	 * @param $formAction [STRING] The action on a form submit
     * @param $managerInit [INTEGER] Initialization value for the itemManager.
	 * @return [void]
	 */
    function __construct($pathModuleRoot, $viewer, $formAction, $managerInit='' ) 
    {
        $fieldList = page_DeleteAdmin::DISPLAY_FIELDS;
        parent::__construct( $formAction, $fieldList );
        
        // initialzie the object values
        $this->pathModuleRoot = $pathModuleRoot;
        $this->viewer = $viewer;

        $this->managerInit = $managerInit;
        
        // create the item Manager to display
        $this->itemManager = new RowManager_AdminManager( $managerInit );
        
        // now initialize the labels for this page
        // start by loading the default field labels for this Module
        $languageID = $viewer->getLanguageID();
        $seriesKey = modulecim_hrdb::MULTILINGUAL_SERIES_KEY;
        $pageKey = modulecim_hrdb::MULTILINGUAL_PAGE_FIELDS;
        $this->labels = new MultilingualManager( $languageID, $seriesKey, $pageKey );
        
        // then load the page specific labels for this page
        $pageKey = page_DeleteAdmin::MULTILINGUAL_PAGE_KEY;
        $this->labels->loadPageLabels( $pageKey );
        
        // add Site YES/NO labels
        $this->labels->setSeriesKey( SITE_LABEL_SERIES_SITE );
        $this->labels->loadPageLabels( SITE_LABEL_PAGE_LIST_YESNO );
         
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
        //$path = $this->pathModuleRoot.'templates/';
        // Otherwise use the standard Templates for the site:
        $path = SITE_PATH_TEMPLATES;
        

        /*
         * Update any label tags ...
         */
        // example:
            // $name = $user->getName();
            // $this->labels->setLabelTag( '[Title]', '[userName]', $name);
         
        
        
        // NOTE:  this parent method prepares the $this->template with the 
        // common AdminBox data.  
        $this->prepareTemplate( $path );
        
        /*
         *  Set up any additional data transfer to the Template here...
         */
        //Display person names instead of person ids.
        $personManager = new RowManager_PersonManager( );
        $personManager->setSortOrder('person_lname');
        $personManager->setLabelTemplateLastNameFirstName();
        $personList = $personManager->getListIterator( );
        $personArray = $personList->getDropListArray( );
        $this->template->set( 'list_person_id', $personArray );



      // uncomment this line if you are creating a template for this page
		//$templateName = 'page_DeleteAdmin.php';
		// otherwise use the generic site template
		$templateName = 'siteDeleteConf.php';
		
		return $this->template->fetch( $templateName );

    }
	
}

?>