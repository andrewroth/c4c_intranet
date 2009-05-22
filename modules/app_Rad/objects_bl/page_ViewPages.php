<?php
/**
 * @package RAD
 */ 
/**
 * class page_ViewPages 
 * <pre> 
 * Displays the list of pages entered into this module
 * </pre>
 * @author Johnny Hausman
 * Date:   23 Mar 2005
 */
class  page_ViewPages {

	//CONSTANTS:
	
	/** The list of fields to be displayed */
    const DISPLAY_FIELDS = 'page_name,page_desc,page_type,page_isAdd,page_rowMgrID,page_listMgrID,page_isCreated';
    
    /** The Multilingual Page Key for labels on this page */
    const MULTILINGUAL_PAGE_KEY = 'page_ViewPages';
    

	//VARIABLES:
	
	/** @var [OBJECT] The viewer object. */
	protected $viewer;
	
    /** @var [STRING] The path to this module's root directory. */
	protected $pathModuleRoot;
	
    /** @var [OBJECT] The labels object for this page of info. */
	protected $labels;
	
	/** @var [ARRAY] The HREF values the links on this page. */
	protected $linkValues;
	
	/** @var [ARRAY] The labels for the links on this page. */
	protected $linkLabels;
	
	/** @var [ARRAY] Additional columns in the data list that are links. */
	protected $linkColumns;
	
	/** @var [INTEGER] The initilization value for the listManager. */
//	protected $managerInit;
    /** @var [STRING] The initialization variable for the dataList */
    protected $module_id;
	
	/** @var [OBJECT] The object for generating the data list. */
	protected $listManager;
	
	
	//CLASS CONSTRUCTOR
	//************************************************************************
	/**
	 * function __construct
	 * <pre>
	 * Initialize the object.
	 * </pre>
	 * @param $pathModuleRoot [STRING] The path to the module's root dir.
	 * @param $viewer [OBJECT] The viewer object.
	 * @param $sortBy [STRING] Field data to sort listManager by.
     * @param $managerInit [INTEGER] Initialization value for the listManager.
	 * @param $module_id [STRING] The init data for the dataList obj
	 * @return [void]
	 */
    function __construct($pathModuleRoot, $viewer, $sortBy, $module_id="" ) 
    {

        $this->pathModuleRoot = $pathModuleRoot;
        $this->viewer = $viewer;
        $this->linkValues = array();
        $this->linkLabels = array();
        $this->linkColumns = array();
                
//        $this->managerInit = $managerInit;
        $this->module_id = $module_id;
        

        $this->listManager = new PageList( $this->module_id, $sortBy );
         
         // now initialize the labels for this page
         // start by loading the default field labels for this Module
         $languageID = $viewer->getLanguageID();
         $seriesKey = moduleRAD::MULTILINGUAL_SERIES_KEY;
         $pageKey = moduleRAD::MULTILINGUAL_PAGE_FIELDS;
         $this->labels = new XMLObject_MultilingualManager( $languageID, $seriesKey, $pageKey );
         
         // then load the page specific labels for this page
         $pageKey = page_ViewPages::MULTILINGUAL_PAGE_KEY;
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
        
        $this->template = new Template( $path );
        
        // store the Row Manager's XML Node Name
        $this->template->set( 'rowManagerXMLNodeName', RowManager_PageManager::XML_NODE_NAME );
        
        // store the field names being displayed
        $fieldNames = explode(',', page_ViewPages::DISPLAY_FIELDS);
        $this->template->set( 'dataFieldList', $fieldNames);
        
        // store the primary key field name for the data being displayed
        $this->template->set( 'primaryKeyFieldName', 'page_id');
        
        // store the link values
        // $this->linkValues[ 'view' ] = 'add/new/href/data/here';
        $this->template->set( 'linkValues', $this->linkValues );
        
        // store the link labels
        $this->linkLabels[ 'add' ] = $this->labels->getLabel( '[Add]' );
        $this->linkLabels[ 'edit' ] = $this->labels->getLabel( '[Edit]' );
        $this->linkLabels[ 'del'  ] = $this->labels->getLabel( '[Delete]' );
        $this->linkLabels[ 'cont' ] = $this->labels->getLabel( '[Continue]');
        // $this->linkLabels[ 'view' ] = 'new link label here';
        $this->template->set( 'linkLabels', $this->linkLabels );
        
        // store any additional link Columns
        // example:
            //$title = $this->labels->getLabel( '[title_groups]');
            //$columnLabel = $this->labels->getLabel( '[groups]');
            //$link = $this->linkValues[ 'groups' ];
            //$fieldName = 'accessgroup_id';
            //$this->addLinkColumn( $title, $columnLabel, $link, $fieldName);

        $this->template->set( 'linkColumns', $this->linkColumns);
        
        // store the page labels
        // NOTE: use this location to update any label tags ...
        // example:
        $moduleManager = new RowManager_ModuleManager( $this->module_id );
        $name = $moduleManager->getModuleName();
        $this->labels->setLabelTag( '[Title]', '[moduleName]', $name);
        $this->template->setXML( 'pageLabels', $this->labels->getLabelXML() );
        
        // store XML List of Applicants ...
        $this->template->setXML( 'dataList', $this->listManager->getXML() );
        

        /*
         *  Set up any additional data transfer to the Template here...
         */
         
        $pageTypeArray = RowManager_PageManager::getPageTypeArray();
        $this->template->set( 'list_page_type', $pageTypeArray);
        
        $daObjList = new DAObjList( $this->module_id );
        $listArray = $daObjList->getDroplistArray();
        $this->template->set( 'list_page_rowMgrID', $listArray);
        $this->template->set( 'list_page_listMgrID', $listArray);
        
   
        $templateName = 'siteDataList.php';
		// if you are creating a custom template for this page then 
		// replace $templateName with the following:
		//$templateName = 'page_ViewPages.php';
		
		return $this->template->fetch( $templateName );
        
    }
    
    
    
    //************************************************************************
	/**
	 * function addLinkColumn
	 * <pre>
	 * Adds a value to the linkColumn array.
	 * </pre>
	 * @param $title [STRING] The label to display for the column title
	 * @param $label [STRING] The label to display for the link
	 * @param $link  [STRING] the href value for the link
	 * @param $fieldName [STRING] the name of the field used to complete 
	 * the link
	 * @return [void]
	 */
    function addLinkColumn($title, $label, $link, $fieldName ) 
    {
        $entry = array();
        $entry[ 'title' ] = $title;
        $entry[ 'label' ] = $label;
        $entry[ 'link' ] = $link;
        $entry[ 'field' ] = $fieldName;
        
        $this->linkColumns[] = $entry;
    }
    
    
    
    //************************************************************************
	/**
	 * function setLinks
	 * <pre>
	 * Sets the value of the linkValues array.
	 * </pre>
	 * @param $links [ARRAY] Array of Link Values
	 * @return [void]
	 */
    function setLinks($links) 
    {
        $this->linkValues = $links;
    }
	
}

?>