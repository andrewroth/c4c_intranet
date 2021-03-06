<?php
/**
 * @package RAD
 */ 
/**
 * class page_ViewModule 
 * <pre> 
 * This page displays the details of the selected Module.
 * </pre>
 * @author Johnny Hausman
 * Date:   17 Jan 2005
 */
class  page_ViewModule {

	//CONSTANTS:
    
    /** The Querystring Field for which entry is currently being edited ... */
    const MULTILINGUAL_PAGE_KEY = 'page_ViewModule';

	//VARIABLES:
	
	/** @var [OBJECT] The viewer object. */
	protected $viewer;
	
    /** @var [STRING] The path to this module's root directory. */
	protected $pathModuleRoot;
	
    /** @var [OBJECT] The labels object for this page of info. */
	protected $labels;
	
	/** @var [ARRAY] The links used on this page. */
	protected $links;
	
	
/*[RAD_SYSVAR_VAR]*/	
	/** @var [INTEGER] Desired Region ID to view Applications for. */
//	protected $regionID;
	
	
/*[RAD_DAOBJ_VAR]*/
	/** @var [OBJECT] The Module Manager Object. */
	protected $dataManager;
	
	/** @var [OBJECT] The list of state variables for this module. */
	protected $listStateVar;
	
	/** @var [OBJECT] The list of Data Access Objects for this module. */
	protected $listDAObjects;
	
	/** @var [OBJECT] The list of Page Objects for this module. */
	protected $listPageObjects;
	
	/** @var [OBJECT] The list of Transitions for this module. */
	protected $listTransitions;
	
	
	//CLASS CONSTRUCTOR
	//************************************************************************
	/**
	 * function __construct
	 * <pre>
	 * Initialize the object.
	 * </pre>
	 * @param $pathModuleRoot [STRING] The path to the module's root dir.
	 * @param $viewer [OBJECT] The viewer object.
	 * @param $moduleID [INTEGER] The module ID of the module we are viewing.
//[RAD_DAOBJ_INIT_VAR_DOC]
	 * @return [void]
	 */
    function __construct($pathModuleRoot, $viewer, $moduleID ) 
    {

        $this->pathModuleRoot = $pathModuleRoot;
        $this->viewer = $viewer;
        $this->links = array();

        
/*[RAD_DAOBJ_INIT_VAR_SAVE]*/
//        $this->regionID = $regionID;
        
        $this->dataManager = new RowManager_ModuleManager( $moduleID );
         
         // now initialize the labels for this page
         // start by loading the default field labels for this Module
         $languageID = $viewer->getLanguageID();
         $seriesKey = moduleRAD::MULTILINGUAL_SERIES_KEY;
         $pageKey = moduleRAD::MULTILINGUAL_PAGE_FIELDS;
         $this->labels = new XMLObject_MultilingualManager( $languageID, $seriesKey, $pageKey );
         
         $this->listStateVar = new StateVarList( $moduleID );
         $this->listDAObjects = new DAObjList( $moduleID );
         $this->listPageObjects = new PageList( $moduleID );
         $this->listTransitions = new TransitionsList( $moduleID );
         
         
         // then load the page specific labels for this page
         $pageKey = page_ViewModule::MULTILINGUAL_PAGE_KEY;
         $this->labels->loadPageLabels( $seriesKey, $pageKey );
         
         $this->labels->loadPageLabels( SITE_LABEL_SERIES_SITE, SITE_LABEL_PAGE_FORM_LINKS );
         
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
	 * function loadFromForm
	 * <pre>
	 * mimiks the loading from a form.
	 * </pre>
	 * @return [void]
	 */
    function loadFromForm() 
    {

    }
    
    
    
    //************************************************************************
	/**
	 * function isDataValid
	 * <pre>
	 * Verifies the returned data is valid.
	 * </pre>
	 * @return [BOOL]
	 */
    function isDataValid() 
    {
        return true;
    }

    
    
    
    //************************************************************************
	/**
	 * function processData
	 * <pre>
	 * Processes the steps needed to create the current module.
	 * </pre>
	 * @return [void]
	 */
    function processData() 
    {
        
        // store values in table manager object.
        $moduleID = $this->dataManager->getModuleID();
        $moduleCreator = new ModuleCreator( $moduleID, $this->pathModuleRoot);
        $moduleCreator->createModule();
        
    } // end processData()
    
    
    
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
        $this->template = new Template( $this->pathModuleRoot.'templates/' );
        
        // store the link info
        $this->template->set( 'links', $this->links );

        
        // store the page labels
        $name = $this->dataManager->getModuleName();
        $this->labels->setLabelTag( '[Title]', '[moduleName]', $name);
        $this->template->setXML( 'pageLabels', $this->labels->getLabelXML() );
        
        // store XML List of Applicants ...
        $this->template->setXML( 'dataList', $this->dataManager->getXML() );
        

        /*
         *  Set up any additional data transfer to the Template here...
         */
        // store XML list of State Vars
        $this->template->setXML( 'stateVarList', $this->listStateVar->getXML() );
        
        // store XML list of Data Access Objects
        $this->template->setXML( 'daObjectList', $this->listDAObjects->getXML() );
        
        // store XML list of Page Objects
        $this->template->setXML( 'pageList', $this->listPageObjects->getXML() );
        
        // store XML list of Page Transitions
        $this->template->setXML( 'transitionList', $this->listTransitions->getXML() );
        
        // now store an array of Page Names so the transitions can list 
        // the names of the Pages Objects ...
        $pageNames = array();
        $this->listPageObjects->setFirst();
        while ( $page = $this->listPageObjects->getNext() ) {
            $pageNames[ $page->getID() ] = $page->getName();
        }
        $this->template->set( 'pageNames', $pageNames );
        
		return $this->template->fetch( 'page_ViewModule.php' );
        
    }
    
    
    
    //************************************************************************
	/**
	 * function setLinks
	 * <pre>
	 * stores the value of the links array
	 * </pre>
	 * @param $link [ARRAY] list of href links 
	 * @return [void]
	 */
    function setLinks($link) 
    {
        $this->links = $link;
    }  // end setLinks()
    
    
    
 	
}

?>