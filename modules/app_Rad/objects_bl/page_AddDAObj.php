<?php
/**
 * @package RAD
 */ 
/**
 * class FormProcessor_AddDAObj 
 * <pre> 
 * Adds a Data Access Object to a module
 * </pre>
 * @author Johnny Hausman
 * Date:   23 Mar 2005
 */
class  FormProcessor_AddDAObj extends PageDisplay_FormProcessor {

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
	//             form_field_type = the type of form field
    //                               T = Text / String
    //                               B = Boolean
    //                               D = Date ( 3 lists boxes day/mon/year)
    //
    //             invalid_value = A value that is considered incorrect for this
    //                             form field.  Leaving it blank is equivalent 
    //                             to form_value != ''.  If a variable is able
    //                             to be left empty ('') then put the keyword
    //                             '<skip>' for this value. 
    const FORM_FIELDS = 'module_id|T|<skip>,daobj_name|T|,daobj_desc|T|,daobj_managerInitVarID|T|,daobj_listInitVarID|T|,daobj_dbTableName|T|<skip>';
    
    /** The list of field types to be displayed in the form */
    // NOTE: if a field isn't displayed, put a '-' for it's entry.
    const FORM_FIELD_TYPES = '-,textbox,textarea,droplist,droplist,-';
    
    /** The Multilingual Page Key for this page */
    const MULTILINGUAL_PAGE_KEY = 'FormProcessor_AddDAObj';

	//VARIABLES:
	
	/** @var [STRING] The path to the module's root directory. */
	protected $pathModuleRoot;
	
	/** @var [STRING] The form Action for submitting this form. */
	protected $formAction;
	
	/** @var [OBJECT] The Viewer Object. */
	protected $viewer;
		
    /** @var [STRING] The initialization data for the dataManager. */
	protected $daobj_id;
	
	/** @var [INTEGER] Foreign Key needed by Data Manager */
	protected $module_id;
	
	/** @var [OBJECT] The data manager object. */
	protected $dataManager;


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
	 * @param $daobj_id [INTEGER] Value used to initialize the dataManager
	 * @param $module_id [INTEGER] The foreign key data for the data Manager
	 * @return [void]
	 */
    function __construct($pathModuleRoot, $viewer, $formAction, $daobj_id , $module_id='') 
    {
        // NOTE: be sure to call the parent constructor before trying to 
        //       use the ->formXXX arrays...
        parent::__construct( $formAction, FormProcessor_AddDAObj::FORM_FIELDS, FormProcessor_AddDAObj::FORM_FIELD_TYPES );

        $this->pathModuleRoot = $pathModuleRoot;
        $this->viewer = $viewer;
        $this->formAction = $formAction;
        $this->daobj_id = $daobj_id;
        $this->module_id = $module_id;

        
        // figure out the important fields for the dataManager
        $fieldsOfInterest = implode(',', $this->formFields);
        
        $this->dataManager = new RowManager_DAObjManager( $daobj_id );
        $this->dataManager->setFieldsOfInterest( $fieldsOfInterest );
        $this->formValues = $this->dataManager->getArrayOfValues();

        // now initialize the labels for this page
        // start by loading the default field labels for this Module
        $languageID = $viewer->getLanguageID();
        $seriesKey = moduleRAD::MULTILINGUAL_SERIES_KEY;
        $pageKey = moduleRAD::MULTILINGUAL_PAGE_FIELDS;
        $this->labels = new XMLObject_MultilingualManager( $languageID, $seriesKey, $pageKey );
        
        // load the site default form link labels
        $this->labels->loadPageLabels( SITE_LABEL_SERIES_SITE, SITE_LABEL_PAGE_FORM_LINKS );
        
        // then load the page specific labels for this page
        $pageKey = FormProcessor_AddDAObj::MULTILINGUAL_PAGE_KEY;
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
        
        /*
         * Put any additional data manipulations here.
         * if you don't need to do anything else, you should 
         * just remove this method and let the parent method get
         * called directly.
         */
        
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
        
        if ($isValid) {
        
            $isValid = $this->dataManager->isUniqueName( $this->formValues[ 'daobj_name'], $this->module_id );
            if ( !$isValid) {
                $this->formErrors[ 'daobj_name' ] = $this->labels->getLabel( '[error_UniqueName]');
            }
        }
        
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
    
        // now set the value of the dbTableName
        $moduleManager = new RowManager_ModuleManager( $this->module_id );
        $moduleName = strtolower( $moduleManager->getModuleName() );
        $tableName = strtolower( $this->formValues[ 'daobj_name' ] );
//        $dbTableName = $moduleName.'_'.$tableName.'manager_'.$tableName;
        $dbTableName = $moduleName.'_'.$tableName;
        $this->formValues[ 'daobj_dbTableName' ] = $dbTableName;
        
        // save the value of the Foriegn Key(s)
            $this->formValues[ 'module_id' ] = $this->module_id;
        /*[RAD_ADMINBOX_FOREIGNKEY]*/
        
        // store values in table manager object.
        if (!$this->dataManager->isLoaded()) {
            $this->dataManager->createNewEntry();
        }
        $this->dataManager->loadFromArray( $this->formValues );
        $this->dataManager->updateDBTable();
        
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
        
        // store any additional values to template
        $this->template->set( 'formAction', $this->formAction );
        
        // store the page labels in XML format...
        // NOTE: use this location to update any label tags ...
        $moduleManager = new RowManager_ModuleManager( $this->module_id );
        $name = $moduleManager->getModuleName();
        $this->labels->setLabelTag( '[Title]', '[moduleName]', $name);
        $this->template->setXML( 'pageLabels', $this->labels->getLabelXML() );
        
        // store all the fields to the template
        $this->setFormFieldsToTemplate();

        /*
         * Form related Template variables:
         */
        // save the list of form fields
        $this->template->set( 'formFieldList', $this->formFields);
        
        // store the field types being displayed
        $fieldTypes = explode(',', FormProcessor_AddDAObj::FORM_FIELD_TYPES);
        $this->template->set( 'formFieldType', $fieldTypes);
        
        // store the button label
        $this->template->set( 'buttonText', $this->labels->getLabel('[Add]') );
        


        // Insert the date start/end values for the following date fields:
        // example:
            //$this->template->set( 'startYear_[fieldName]', 2000);
            //$this->template->set( 'endYear_[fieldName]', 2010);

                


        /*
         * Add any additional data required by the template here
         */
         
        // add the drop list info for the state var choices
        $stateVarList = new StateVarList( $this->module_id );
        $stateVarArray = $stateVarList->getDropListArray();
        $this->template->set( 'list_daobj_managerInitVarID', $stateVarArray);
        $this->template->set( 'list_daobj_listInitVarID', $stateVarArray);

		// uncomment this line if you are creating a template for this page
		//$templateName = 'page_AddDAObj.php';
		// otherwise use the generic admin box template
		$templateName = 'siteFormSingle.php';
		
		return $this->template->fetch( $templateName );
        
    }
    
    
    
    //************************************************************************
	/**
	 * function getDaObjID
	 * <pre>
	 * This method returns the daobj_id from the dataManager.
	 * </pre>
	 * @return [STRING] HTML Display data.
	 */
    function getDaObjID() 
    {
		return $this->dataManager->getPrimaryKeyValue();   
    } 
    
	
}

?>