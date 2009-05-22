<?php
/**
 * @package AccountAdmin
 */ 
/**
 * class form_AccountAccess 
 * <pre> 
 * Manages a viewers access groups to the site.
 * </pre>
 * @author Johnny Hausman
 * Date:   21 Mar 2005
 */
 // RAD Tools: AdminBox Page
class  form_AccountAccess {

	//CONSTANTS:
    
    /** The Querystring Field for which entry is currently being edited ... */
    const MULTILINGUAL_PAGE_KEY = 'form_AccountAccess';

	//VARIABLES:
	
	/** @var [STRING] The path to the module's root directory. */
	protected $pathModuleRoot;
	
	/** @var [STRING] The form Action for submitting this form. */
	protected $formAction;
	
	/** @var [OBJECT] The Viewer Object. */
	protected $viewer;
	
	/** @var [STRING] The initilization variable for the dataManager. */
	protected $vieweraccessgroup_id;
	
    /** @var [STRING] The initialization variable for the dataList */
    protected $viewer_id;
    
    /** @var [ARRAY] The submitted list of Access Groups to be linked to this account */
	protected $submittedGroups;
	
	/** @var [OBJECT] The data manager object (holds the form info) */
	protected $dataManager;
	
	/** @var [OBJECT] The data List object. */
	protected $dataList;
	
	/** @var [STRING] The field information to sort dataList by */
	protected $sortBy;


	//CLASS CONSTRUCTOR
	//************************************************************************
	/**
	 * function __construct
	 * <pre>
	 * Initialize the object.
	 * </pre>
	 * @param $pathModuleRoot [STRING] The path to this module's root directory
	 * @param $viewer [OBJECT] The viewer object.
	 * @param $formAction [STRING] The action on a form submit
	 * @param $sortBy [STRING] Field data to sort listManager by.
	 * @param $viewer_id [STRING] The init data for the dataList obj
	 * @return [void]
	 */
    function __construct($pathModuleRoot, $viewer, $formAction, $sortBy, $viewer_id="" )
    {
        // NOTE: be sure to call the parent constructor before trying to 
        //       use the ->formXXX arrays...
 //       parent::__construct( form_AccountAccess::FORM_FIELDS );

        $this->pathModuleRoot = $pathModuleRoot;
        $this->viewer = $viewer;
        $this->formAction = $formAction;
        $this->sortBy = $sortBy;

//        $this->vieweraccessgroup_id = $vieweraccessgroup_id;
        $this->viewer_id = $viewer_id;
        
        $this->submittedGroups = array();
        $groupList = new ViewerAccessGroupList( $this->viewer_id, $this->sortBy );
        $this->currentGroupList = $groupList->getAccessGroupArray();
        
        // now initialize the labels for this page
        // start by loading the default field labels for this Module
        $languageID = $viewer->getLanguageID();
        $seriesKey = moduleAccountAdmin::MULTILINGUAL_SERIES_KEY;
        $pageKey = moduleAccountAdmin::MULTILINGUAL_PAGE_FIELDS;
        $this->labels = new XMLObject_MultilingualManager( $languageID, $seriesKey, $pageKey );
        
        // load the site default form link labels
        $this->labels->loadPageLabels( SITE_LABEL_SERIES_SITE, SITE_LABEL_PAGE_FORM_LINKS );
        
        // then load the page specific labels for this page
        $pageKey = form_AccountAccess::MULTILINGUAL_PAGE_KEY;
        $this->labels->loadPageLabels( $seriesKey, $pageKey );
         
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
	 * @return [void]
	 */
    function loadFromForm() 
    {
        $this->submittedGroups = array();
        
        if (isset( $_REQUEST[ 'groups' ] ) ) {
            $this->submittedGroups = $_REQUEST[ 'groups' ];
        }
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
	 * Processes the data for this form.
	 * </pre>
	 * @return [void]
	 */
    function processData() 
    {
        
        // now get list of NEW Groups added to this Account
        $addedList = array();
        for( $indx=0; $indx< count( $this->submittedGroups ); $indx++) {
        
            $id = $this->submittedGroups[ $indx ];
            
            // if id not in currentGroupList then add to addList
            if ( !isset( $this->currentGroupList[ $id ]) ) {
                $addedList[] = $id;
            }
        }

        
        // foreach added group
        $viewerAccessGroup = new RowManager_ViewerAccessGroupManager();
        $accessGroupManager = new RowManager_AccessGroupManager();
        $adminAccessGroupID = $accessGroupManager->getAdminAccessGroupID();
        //print($adminAccessGroupID . "<br>");
        for( $indx=0; $indx<count( $addedList ); $indx++ ) {
            // create new entry
            $viewerAccessGroup->createNewEntry();
            
            // load values
            $values = array();
            $values[ 'viewer_id' ] = $this->viewer_id;
            $values[ 'accessgroup_id' ] = $addedList[ $indx ];
            $viewerAccessGroup->loadFromArray( $values );

            // update DB Table
            $viewerAccessGroup->updateDBTable();
            
            //add to table accountadmin_accountadminaccess if acces group is adminAccesGroup
            if ($values[ 'accessgroup_id' ] == $adminAccessGroupID)
            {
  
                $aam = new RowManager_AccountAdminAccessManager();
                $aam->setViewerID($this->viewer_id);
                $aam->setGroupPrivilege();
                $aam->createNewEntry();
            }
            
        } // next group 
        
        $languageManager = new RowManager_LanguageManager();
        $languageList = $languageManager->getListIterator();
        $languageList->setFirst();
        while($language = $languageList->getNext())
        {
            $navbar = new RowManager_NavBarCacheManager();
            $navbar->loadByViewerID($this->viewer_id, $language->getID());
           if ($navbar->getID() != -1) {
                $navbar->setCacheInvalid();
                $navbar->updateDBTable();
            }
        }
        
        
        // get list of DELETED Groups from this account
        $deletedList = array();
        foreach($this->currentGroupList  as $key=>$value) {
        
            if ( !in_array( $key, $this->submittedGroups ) ) {
                $deletedList[] = $key;
            }
        }
        
        // foreach deleted group
        for( $indx=0; $indx<count( $deletedList ); $indx++ ) {

            // if we can load a manager for this account with this group then
            if ( $viewerAccessGroup->loadByViewerAccessGroup( $this->viewer_id, $deletedList[$indx] ) ) {
            
                // delete
                $viewerAccessGroup->deleteEntry();
            if ($deletedList[ $indx ] == $adminAccessGroupID)
            {

                $aam = new RowManager_AccountAdminAccessManager();
                $aam->setViewerID($this->viewer_id);
                //$aam->setGroupPrivilege();
                //print("before delete");
                $aam->deleteEntry();
            }
        }
        
        } // next group
        
        // update currentGroupList with submittedGroupList
        $groupList = new ViewerAccessGroupList( $this->viewer_id, $this->sortBy );
        $this->currentGroupList = $groupList->getAccessGroupArray();
    
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
        
        // Uncomment the following line if you want to create a template 
        // tailored for this page:
        $path = $this->pathModuleRoot.'templates/';
        $this->template = new Template( $path );
        
        // store the form action information
        $this->template->set( 'formAction', $this->formAction );
        
                
        // store the page labels in XML format...
        // NOTE: use this location to update any label tags ...
        // example:
        $account = new RowManager_ViewerManager( $this->viewer_id );
        $name = $account->getUserID();
        $this->labels->setLabelTag( '[Title]', '[viewerUserID]', $name);
        $this->labels->setLabelTag( '[Instr]', '[viewerUserID]', $name);
        $this->template->setXML( 'pageLabels', $this->labels->getLabelXML() );

        
        /*
         * Form related Template variables:
         */
        // compile list of Access Categories and Related Access Groups
        $categoryArray = array();
        
        $categoryManager = new RowManager_AccessCategoryManager( );
        $seriesKey = moduleAccountAdmin::MULTILINGUAL_SERIES_KEY;
        $pageKey = $categoryManager->getXMLNodeName();
        $multilingualContext = new MultilingualManager( $this->viewer->getLanguageID(), $seriesKey, $pageKey );
        $bridgeManager = new RowLabelBridge($categoryManager, $multilingualContext ); 
        
        $groupMultiLingualContext = new MultilingualManager( $this->viewer->getLanguageID(), $seriesKey, RowManager_AccessGroupManager::XML_NODE_NAME );
        
        
        $accessCategoryList = $bridgeManager->getListIterator();
//        $accessCategoryList = new AccessCategoryList();
        $accessCategoryList->setFirst();
        while ( $accessCategory = $accessCategoryList->getNext() ) {
        
//            $accessGroupList = new AccessGroupList( $accessCategory->getID() );
            $name = $accessCategory->getLabel();
            
            $groupManager = new RowManager_AccessGroupManager( );
            $groupManager->setAccessCategoryID( $accessCategory->getID() );

            $bridgeManager = $groupManager->getRowLabelBridge( $groupMultiLingualContext );
            $accessGroupList = $bridgeManager->getListIterator();
            
            $categoryArray[ $name ] = $accessGroupList->getDropListArray();
        }
            
        $this->template->set( 'accessCategories', $categoryArray);


        // load the current Groups associated with this account
        $this->template->set( 'currentGroups', $this->currentGroupList );
        
        
        $this->template->set( 'buttonText', $this->labels->getLabel('[Update]'));
        
        // return the HTML content for this page
		$templateName = 'page_AccountAccess.php';
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
    
    
    
    //************************************************************************
	/**
	 * function setFormAction
	 * <pre>
	 * Sets the value of the Form Action Link.
	 * </pre>
	 * @param $link [STRING] The HREF link for the continue link
	 * @return [void]
	 */
    function setFormAction($link) 
    {
        $this->formAction = $link;
    }
    
	
}

?>