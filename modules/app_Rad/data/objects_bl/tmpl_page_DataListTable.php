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
class  [PageNamePrefix][PageName] extends PageDisplay_DisplayList {

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
	
	/** @var [INTEGER] The initilization value for the listManager. */
//	protected $managerInit;
/*[RAD_LIST_INIT]*/
		
	
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
[RAD_LIST_INIT_DOC]	 * @return [void]
	 */
    function __construct($pathModuleRoot, $viewer, $sortBy[RAD_LIST_INIT_PARAM] ) 
    {
        parent::__construct( [PageNamePrefix][PageName]::DISPLAY_FIELDS );
        
        $this->pathModuleRoot = $pathModuleRoot;
        $this->viewer = $viewer;
                
//        $this->managerInit = $managerInit;
/*[RAD_LIST_INIT_VAR_INIT]*/        

        $dataAccessObject = new RowManager_[RAD_DAOBJ_MANAGER_NAME]();
        $dataAccessObject->setSortOrder( $sortBy );
//        $this->listManager = new [RAD_DAOBJ_LIST_NAME]( [RAD_LIST_INIT_DAOBJ_PARAM]$sortBy );
        $this->listManager = $dataAccessObject->getListIterator();
         
         // now initialize the labels for this page
         // start by loading the default field labels for this Module
         $languageID = $viewer->getLanguageID();
         $seriesKey = module[ModuleName]::MULTILINGUAL_SERIES_KEY;
         $pageKey = module[ModuleName]::MULTILINGUAL_PAGE_FIELDS;
         $this->labels = new MultilingualManager( $languageID, $seriesKey, $pageKey );
         
         // then load the page specific labels for this page
         $pageKey = [PageNamePrefix][PageName]::MULTILINGUAL_PAGE_KEY;
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
        //$path = $this->pathModuleRoot.'[RAD_PATH_TEMPLATES]';
        
        
        // store the link values
        // $this->linkValues[ 'view' ] = 'add/new/href/data/here';

        
        // store the link labels
        $this->linkLabels[ 'add' ] = $this->labels->getLabel( '[Add]' );
        $this->linkLabels[ 'edit' ] = $this->labels->getLabel( '[Edit]' );
        $this->linkLabels[ 'del'  ] = $this->labels->getLabel( '[Delete]' );
        $this->linkLabels[ 'cont' ] = $this->labels->getLabel( '[Continue]');
        // $this->linkLabels[ 'view' ] = 'new link label here';

        
        // store any additional link Columns
        // example:
            //$title = $this->labels->getLabel( '[title_groups]');
            //$columnLabel = $this->labels->getLabel( '[groups]');
            //$link = $this->linkValues[ 'groups' ];
            //$fieldName = 'accessgroup_id';
            //$this->addLinkColumn( $title, $columnLabel, $link, $fieldName);

        
        // store the page labels
        // NOTE: use this location to update any label tags ...
        // example:
            // $name = $user->getName();
            // $this->labels->setLabelTag( '[Title]', '[userName]', $name);
            
        
        $this->prepareTemplate( $path );
        
        // store the Row Manager's XML Node Name
        $this->template->set( 'rowManagerXMLNodeName', RowManager_[RAD_LIST_MANAGER_NAME]::XML_NODE_NAME );
        
        // store the primary key field name for the data being displayed
        $this->template->set( 'primaryKeyFieldName', '[RAD_LIST_PRIMARYKEY]');


        /*
         *  Set up any additional data transfer to the Template here...
         */
        
   
        $templateName = '[RAD_TEMPLATE_DEFAULT]';
		// if you are creating a custom template for this page then 
		// replace $templateName with the following:
		//$templateName = 'page_[PageName].php';
		
		return $this->template->fetch( $templateName );
        
    }
    
    
}

?>