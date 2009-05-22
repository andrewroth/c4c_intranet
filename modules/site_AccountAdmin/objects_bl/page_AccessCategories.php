<?php
/**
 * @package AccountAdmin
 */ 
/**
 * class FormProcessor_AccessCategories 
 * <pre> 
 * Organizes the access groups into different categories.
 * </pre>
 * @author Johnny Hausman
 * Date:   21 Mar 2005
 */
 // RAD Tools: AdminBox Page
class  FormProcessor_AccessCategories extends PageDisplay_FormProcessor {

	//CONSTANTS:
	/** The list of form fields for this page */
	// NOTE: the format for this list is:
	//
	//         form_field_name|form_field_type|invalid_value
	//
	//             form_field_name = the name for the form field.  generally 
	//                               it is named the same as the table column 
	//                               of the data it represents
	//
	//             form_field_type = the data type of the field
    //                               T = Text / String
    //                               B = Boolean
    //                               D = Date ( 3 lists boxes day/mon/year)
    //
    //             invalid_value = A value that is considered incorrect for this
    //                             form field.  Leaving it blank is equivalent 
    //                             to form_value != '' 
    const FORM_FIELDS = 'accesscategory_id|N|<skip>,label_label|T|';
    
    /** The list of field types to be displayed in the form */
    // NOTE: if a field isn't displayed, put a '-' for it's entry.
    const FORM_FIELD_TYPES = '-,textbox';
    
    /** The list of fields to be displayed in the data list */
    const DISPLAY_FIELDS = 'label_label';
    
    /** The Querystring Field for which entry is currently being edited ... */
    const MULTILINGUAL_PAGE_KEY = 'FormProcessor_AccessCategories';

	//VARIABLES:
	
	/** @var [STRING] The initilization variable for the dataManager. */
	protected $accesscategory_id;
	
	/** @var [OBJECT] The multilingual manager used for initializing RowLabelBridge Objects for this page. */
	protected $bridgeMultiLingualManager;
	
	/** @var [STRING] The form Action for submitting this form. */
	protected $formAction;
	
	/** @var [ARRAY] Additional columns in the data list that are links. */
	protected $linkColumns;
	
	/** @var [ARRAY] The labels for the links on this page. */
	protected $linkLabels;
		
	/** @var [ARRAY] The HREF values the links on this page. */
	protected $linkValues;
	
	/** @var [STRING] The path to the module's root directory. */
	protected $pathModuleRoot;
		
	/** @var [OBJECT] The Viewer Object. */
	protected $viewer;

	
/* no List Init Variable defined for this DAObj */
	


    /** @var [STRING] The type of Editing operation (U=Update, D=Delete). */
	protected $opType;
	
	/** @var [BOOL] Flag marking if we should delete the current entry. */
	protected $shouldDelete;
	
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
	 * @param $accesscategory_id [STRING] The init data for the dataManager obj
	 * @return [void]
	 */
    function __construct($pathModuleRoot, $viewer, $formAction, $sortBy, $accesscategory_id )
    {
        // NOTE: be sure to call the parent constructor before trying to 
        //       use the ->formXXX arrays...
        parent::__construct( $formAction, FormProcessor_AccessCategories::FORM_FIELDS, FormProcessor_AccessCategories::FORM_FIELD_TYPES );

        $this->pathModuleRoot = $pathModuleRoot;
        $this->viewer = $viewer;
        $this->formAction = $formAction;
        $this->sortBy = $sortBy;
        $this->linkValues = array();
        $this->linkLabels = array();
        $this->linkColumns = array();
        
        $this->accesscategory_id = $accesscategory_id;



        $this->opType = '';
        // see what operation type (if any) is requested...
        if ( isset( $_REQUEST[ 'admOpType' ] ) ) {
        
            $this->opType = $_REQUEST[ 'admOpType' ];
        }
        $this->shouldDelete = false;
        
        // figure out the important fields for the dataManager
        $fieldsOfInterest = implode(',', $this->formFields);
        
        $accessCategoryManager = new RowManager_AccessCategoryManager( $accesscategory_id );
        
        $seriesKey = moduleAccountAdmin::MULTILINGUAL_SERIES_KEY;
        $pageKey = RowManager_AccessCategoryManager::XML_NODE_NAME;
        $this->bridgeMultiLingualManager = new MultilingualManager( $viewer->getLanguageID(), $seriesKey, $pageKey );
        
        $this->dataManager = new RowLabelBridge($accessCategoryManager, $this->bridgeMultiLingualManager );
        $this->dataManager->setFieldsOfInterest( $fieldsOfInterest );
        $this->formValues = $this->dataManager->getArrayOfValues();
    

        // now initialize the labels for this page
        // start by loading the default field labels for this Module
        $languageID = $viewer->getLanguageID();
        $seriesKey = moduleAccountAdmin::MULTILINGUAL_SERIES_KEY;
        $pageKey = moduleAccountAdmin::MULTILINGUAL_PAGE_FIELDS;
        $this->labels = new XMLObject_MultilingualManager( $languageID, $seriesKey, $pageKey );
        
        // load the site default form link labels
        $this->labels->loadPageLabels( SITE_LABEL_SERIES_SITE, SITE_LABEL_PAGE_FORM_LINKS );
        
        // then load the page specific labels for this page
        $pageKey = FormProcessor_AccessCategories::MULTILINGUAL_PAGE_KEY;
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
        parent::loadFromForm();
        
        
        // if the button pressed was a 'Delete?' confirmation then
        if (isset( $_REQUEST[ 'submit' ] ) ) {
        
            if ( $_REQUEST[ 'submit' ] == $this->labels->getLabel('[Delete?]')) {
                
                // set shouldDelete 
                $this->shouldDelete = true;
            }
            
        }
        
        
        
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
         $isValid = parent::isDataValid();
        
        /*
         * check here for specific cases not covered by simple Field
         * Definitions.
         */
        
        // Example : error checking
        // NOTE:  a custom error label [error_UniqueModuleName] is used
        // for the error.  This error label is created in the Page Labels
        // form.
        // Make sure that module name doesn't already exist...
//        if ($isValid) {
        
//            $isValid = $this->dataManager->isUniqueModuleName();
//            $this->formErrors[ 'module_name' ] = $this->labels->getLabel( '[error_UniqueModuleName]');
///        }
        
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
    
        // if this is a delete operation then
        if ( $this->opType == 'D' ) {
        
            if ( $this->shouldDelete ) {
            
                $this->dataManager->deleteEntry();
            }
            
        } else {
        // else 
        
            // save the value of the Foriegn Key(s)
        /*[RAD_ADMINBOX_FOREIGNKEY]*/
            
            // store values in table manager object.
            $this->dataManager->loadFromArray( $this->formValues );
            if (!$this->dataManager->isLoaded()) {
                $this->dataManager->createNewEntry();
            } else {
                $this->dataManager->updateDBTable();
            }
            
        } // end if
        
        // now Clear out dataManager & FormValues
        $this->dataManager->clearValues();
        $this->formValues = $this->dataManager->getArrayOfValues();

        
        // on a successful update return accesscategory_id to ''
        $this->accesscategory_id='';
        
        
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
        //$path = $this->pathModuleRoot.'templates/';
        // Otherwise use the standard Templates for the site:
        $path = SITE_PATH_TEMPLATES;
        
        $this->template = new Template( $path );
        
        // store the form action information
        $this->template->set( 'formAction', $this->formAction );
        
        // store the link values
        // example:
            // $this->linkValues[ 'view' ] = 'add/new/href/data/here';
        $this->template->set( 'linkValues', $this->linkValues );
        
        // store the link labels
        $this->linkLabels[ 'edit' ] = $this->labels->getLabel( '[Edit]' );
        $this->linkLabels[ 'del'  ] = $this->labels->getLabel( '[Delete]' );
        $this->linkLabels[ 'cont' ] = $this->labels->getLabel( '[Continue]');
        // $this->linkLabels[ 'view' ] = 'new link label here';
        $this->template->set( 'linkLabels', $this->linkLabels );
        
        // store any additional link Columns
        // example:
        $title = $this->labels->getLabel( '[title_groups]');
        $columnLabel = $this->labels->getLabel( '[view]');
        $link = $this->linkValues[ 'groups' ];
        $fieldName = 'accesscategory_id';
        $this->addLinkColumn( $title, $columnLabel, $link, $fieldName);
        $this->template->set( 'linkColumns', $this->linkColumns);
        
        // store the statevar id to edit
        $this->template->set( 'editEntryID', $this->accesscategory_id );
        
        // store the current op type
        $this->template->set( 'opType', $this->opType );
        
        // store the page labels in XML format...
        // NOTE: use this location to update any label tags ...
        // example:
            // $name = $user->getName();
            // $this->labels->setLabelTag( '[Title]', '[userName]', $name);
        $this->template->setXML( 'pageLabels', $this->labels->getLabelXML() );
        
        // store all the fields to the template
        $this->setFormFieldsToTemplate();
        
        /*
         * Form related Template variables:
         */
        // save the list of form fields
        $this->template->set( 'formFieldList', $this->formFields);
        
        // store the field types being displayed
        $fieldTypes = explode(',', FormProcessor_AccessCategories::FORM_FIELD_TYPES);
        $this->template->set( 'formFieldType', $fieldTypes);
        
        /*
         * List related Template variables :
         */
        // Store the XML Node name for the Data Access Field List
        $xmlNodeName = $this->dataManager->getXMLNodeName();
        $this->template->set( 'rowManagerXMLNodeName', $xmlNodeName);
        
        // store the primary key field name for the data being displayed
        $this->template->set( 'primaryKeyFieldName', 'accesscategory_id');
        
        // store data list to the template
        // NOTE: we initialize it here to make sure we capture any new data 
        // from a recent processData() call.
//        $this->dataList = new AccessCategoryList( $this->sortBy );
        
        $categoryManager = new RowManager_AccessCategoryManager( );
        $bridgeManager = new RowLabelBridge($categoryManager, $this->bridgeMultiLingualManager ); 
        $this->dataList = $bridgeManager->getListIterator();
        $this->template->setXML( 'dataList', $this->dataList->getXML() );
        
        // store the field names being displayed
        $fieldNames = explode(',', FormProcessor_AccessCategories::DISPLAY_FIELDS);
        $this->template->set( 'dataFieldList', $fieldNames);
        
        
        
        
        /*
         * Add any additional data required by the template here
         */
         
        
        $templateName = 'siteAdminBox.php';
        // if you are creating a custom template for this page then 
		// replace $templateName with the following:
		//$templateName = 'page_AccessCategories.php';
		
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