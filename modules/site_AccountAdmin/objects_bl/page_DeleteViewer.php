<?php
/**
 * @package AccountAdmin
 */ 
/**
 * class page_DeleteViewer 
 * <pre> 
 * Removes an account from the site.
 * </pre>
 * @author Johnny Hausman
 * Date:   21 Mar 2005
 */
class  page_DeleteViewer {

	//CONSTANTS:
    
    /** The list of fields to be displayed */
    const DISPLAY_FIELDS = 'viewer_userID,language_id,viewer_isActive,viewer_lastLogin';
    
    /** The Multilingual Page Key for labels on this page */
    const MULTILINGUAL_PAGE_KEY = 'page_DeleteViewer';
    

	//VARIABLES:
	
	/** @var [OBJECT] The viewer object. */
	protected $viewer;
	
    /** @var [STRING] The path to this module's root directory. */
	protected $pathModuleRoot;
	
	/** @var [STRING] The form Action for submitting this form. */
	protected $formAction;
	
    /** @var [OBJECT] The labels object for this page of info. */
	protected $labels;
	
	/** @var [INTEGER] The initilization value for the listManager. */
	protected $managerInit;
	
	/** @var [OBJECT] The object for generating the data list. */
	protected $itemManager;
	
	/** @var [BOOL] should this Object be deleted?. */
	protected $shouldDelete;
	
	/** @var [BOOL] was this called from a submitted form?. */
	protected $wasSubmitted;


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
        // initialzie the object values
        $this->pathModuleRoot = $pathModuleRoot;
        $this->viewer = $viewer;
        $this->formCallBack = $formAction;
        $this->managerInit = $managerInit;
        
        $this->shouldDelete = false;
        $this->wasSubmitted = false;
        
        // create the item Manager to display
        $this->itemManager = new RowManager_ViewerManager( $managerInit );
        
        // now initialize the labels for this page
        // start by loading the default field labels for this Module
        $languageID = $viewer->getLanguageID();
        $seriesKey = moduleAccountAdmin::MULTILINGUAL_SERIES_KEY;
        $pageKey = moduleAccountAdmin::MULTILINGUAL_PAGE_FIELDS;
        $this->labels = new MultilingualManager( $languageID, $seriesKey, $pageKey );
        
        // then load the page specific labels for this page
        $pageKey = page_DeleteViewer::MULTILINGUAL_PAGE_KEY;
        $this->labels->loadPageLabels( $pageKey );
        
        // add Site YES/NO labels
        $seriesKey = SITE_LABEL_SERIES_SITE;
        $this->labels->setSeriesKey( $seriesKey );
        
        $pageKey = SITE_LABEL_PAGE_LIST_YESNO;
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
	 * function loadFromForm
	 * <pre>
	 * Loads the data from the submitted form.
	 * </pre>
	 * @param $param1 [$param1 type][optional description of $param1]
	 * @param $param2 [$param2 type][optional description of $param2]
	 * @return [returnValue, can be void]
	 */
    function loadFromForm() 
    {

        if ( $_REQUEST[ 'submit' ] == $this->labels->getLabel('[yes]')) {
            $this->shouldDelete = true;
        }
        
        $this->wasSubmitted = true;
                
    } // end loadFromForm()
    
    
    
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
         $isValid = true;
        
        // now return result
        return $isValid;
        
    }
    
    
    
    //************************************************************************
	/**
	 * function processData
	 * <pre>
	 * Processes the data for this form.
	 * </pre>
	 * @return [void]
	 */
    function processData() 
    {
        if ($this->shouldDelete) {
        
/*
 * Previous version of web site had following code to keep stats access
 * tables current:
 * 
            $this->DB->db_name = 'statistics';

            $this->DB->SetTableName( 'campusbasedaccess' );
            $this->DB->SetCondition( 'viewer_id='.$this->ViewerID );
            $this->DB->DBDelete();
    
            $this->DB->SetTableName( 'userbasedaccess' );
            $this->DB->SetCondition( 'viewer_id='.$this->ViewerID );
            $this->DB->DBDelete();
*
* This needs to be reworked to have an automated central system for 
* an application to register an AccessRemoval object to use for removing
* account entries:

forEach ( sysAccessObject ) 
    sysAccessObject->removeViewerAccount( viewer_id );
next sysAccessObject

*/		

    $moduleManager = new RowManager_siteModuleManager();
    $moduleManager->processSystemAccessRemoveViewer( $this->itemManager->getID() );

// until that is in place ... Here is a quick hack!
//require ("modules/app_Stats/objects_da/StatsAccessManager.php");
//$statsAccessManager = new RowManager_StatsAccessManager(  );
//$statsAccessManager->removeViewerAccount( $this->itemManager->getID() );
        
            $this->itemManager->deleteEntry();
        }
        
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
        $path = SITE_PATH_TEMPLATES;
        // Replace $path with the following line if you want to create a
        // template tailored for this page:
        //$path = $this->pathModuleRoot.'templates/';
        
        $this->template = new Template( $path );
        
        // store the form action data
        $this->template->set( 'formAction', $this->formCallBack );

        // store the page labels used by this template...
        // NOTE: use this location to update any label tags ...
        $userID = $this->itemManager->getUserID();
        $this->labels->setLabelTag( '[Title]', '[viewerUserID]', $userID);
        $this->template->setXML( 'pageLabels', $this->labels->getLabelXML() );          


        // store the field names being displayed
        $fieldNames = explode(',', page_DeleteViewer::DISPLAY_FIELDS);
        $this->template->set( 'dataFieldList', $fieldNames);
        
        // store XML Data of item
        $this->template->setXML( 'dataItem', $this->itemManager->getXML() );

        // store language list for display
        $languageManager = new RowManager_LanguageManager();
        $context = new MultilingualManager( $this->viewer->getLanguageID());
        $bridge = $languageManager->getRowLabelBridge( $context );
        $languageList = $bridge->getListIterator();
        $languageArray = $languageList->getDropListArray( );
        $this->template->set( 'list_language_id', $languageArray );
        
        $isActiveList = array();
        $isActiveList[ '1' ] = $this->labels->getLabel( '[yes]' );
        $isActiveList[ '0' ] = $this->labels->getLabel( '[no]' );
        $this->template->set( 'list_viewer_isActive', $isActiveList );

        // uncomment this line if you are creating a template for this page
		//$templateName = 'page_DeleteViewer.php';
		// otherwise use the generic admin box template
		$templateName = 'siteDeleteConf.php';
		
		return $this->template->fetch( $templateName );
        
    }
    
    
    
    //************************************************************************
	/**
	 * function wasDeleted()
	 * <pre>
	 * Returns the value of <code>shouldDelete</code>.
	 * </pre>
	 * @return [BOOL]
	 */
    function wasDeleted() 
    {
        return $this->shouldDelete;
    }
	
}

?>