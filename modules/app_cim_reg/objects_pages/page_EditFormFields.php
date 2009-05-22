<?php
/**
 * @package cim_reg
 */ 
/**
 * class FormProcessor_EditFormFields 
 * <pre> 
 * A page used to add/edit/delete registration form fields.
 * </pre>
 * @author Russ Martin
 * Date:   29 Jun 2007
 */
 // RAD Tools: AdminBox Page
class  FormProcessor_EditFormFields extends PageDisplay_FormProcessor_AdminBox {

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
    //                               N = Numeric 
    //                               B = Boolean
    //                               D = Date ( 3 lists boxes day/mon/year)
    //                            Time = Time ( 3 list boxes  HH/MM/Am )
    //                        DateTime = Date + Time pickers ...
    //
    //             invalid_value = A value that is considered incorrect for this
    //                             form field.  Leaving it blank is equivalent 
    //                             to form_value != '' 			****NOTE**** wanted to give users option to leave 'fields_invalid' blank, so I made 5 spaces invalid  :)
    const FORM_FIELDS = 'fieldtype_id|N|,fields_desc|T|,fields_priority|N|,datatypes_id|N|,fields_reqd|B|,fields_invalid|T|<skip>,fields_hidden|B|,event_id|T|<skip>';
    
    /** The list of field types to be displayed in the form */
    // NOTE: if a field isn't displayed, put a '-' for it's entry.
    const FORM_FIELD_TYPES = 'droplist,textarea,textbox,droplist,checkbox,textbox,checkbox,-';
    
    /** The list of fields to be displayed in the data list */
    const DISPLAY_FIELDS = 'fieldtype_id,fields_desc,fields_priority,datatypes_id,fields_reqd,fields_invalid,fields_hidden';
    
    /** The Querystring Field for which entry is currently being edited ... */
    const MULTILINGUAL_PAGE_KEY = 'FormProcessor_EditFormFields';

	//VARIABLES:
	
	/** @var [STRING] The path to the module's root directory. */
	protected $pathModuleRoot;
	
	/** @var [STRING] The initilization variable for the dataManager. */
	protected $fields_id;
	
/* no List Init Variable defined for this DAObj */
	
	/** @var [INTEGER] Foreign Key needed by Data Manager */
	protected $fieldtype_id;

	/** @var [INTEGER] Foreign Key needed by Data Manager */
	protected $event_id;



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
	 * @param $fields_id [STRING] The init data for the dataManager obj
	 * @param $fieldtype_id [INTEGER] The foreign key data for the data Manager
	 * @param $event_id [INTEGER] The foreign key data for the data Manager
	 * @return [void]
	 */
    function __construct($pathModuleRoot, $viewer, $formAction, $sortBy, $fields_id , $event_id='')	//$fieldtype_id='', 
    {
        // NOTE: be sure to call the parent constructor before trying to 
        //       use the ->formXXX arrays...
        $fieldList = FormProcessor_EditFormFields::FORM_FIELDS;
        $fieldTypes = FormProcessor_EditFormFields::FORM_FIELD_TYPES;
        $displayFields = FormProcessor_EditFormFields::DISPLAY_FIELDS;
        parent::__construct($viewer, $formAction, $sortBy, $fieldList, $fieldTypes, $displayFields );


        $this->pathModuleRoot = $pathModuleRoot;
        
        $this->fields_id = $fields_id;

        //$this->fieldtype_id = $fieldtype_id;
        $this->event_id = $event_id;


        
        // figure out the important fields for the dataManager
        $fieldsOfInterest = implode(',', $this->formFields);
        
        $this->dataManager = new RowManager_FieldManager( $fields_id );
        $this->dataManager->setFieldsOfInterest( $fieldsOfInterest );
        $this->formValues = $this->dataManager->getArrayOfValues();
    

        // now initialize the labels for this page
        // start by loading the default field labels for this Module
        $languageID = $viewer->getLanguageID();
        $seriesKey = modulecim_reg::MULTILINGUAL_SERIES_KEY;
        $pageKey = modulecim_reg::MULTILINGUAL_PAGE_FIELDS;
        $this->labels = new MultilingualManager( $languageID, $seriesKey, $pageKey );
        
        // then load the page specific labels for this page
        $pageKey = FormProcessor_EditFormFields::MULTILINGUAL_PAGE_KEY;
        $this->labels->loadPageLabels( $pageKey );
        
        // load the site default form link labels
        $this->labels->setSeriesKey( SITE_LABEL_SERIES_SITE );
        $this->labels->loadPageLabels( SITE_LABEL_PAGE_FORM_LINKS );
        
        $this->labels->loadPageLabels( SITE_LABEL_PAGE_FORMERRORS );
         
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
            
                $db_error_msg = $this->dataManager->deleteEntry();
                $this->setErrorMessage($db_error_msg);
            }
            
        } else {
        // else 
        
            // save the value of the Foriegn Key(s)
//            $this->formValues[ 'fieldtype_id' ] = $this->fieldtype_id;
            $this->formValues[ 'event_id' ] = $this->event_id;
        /*[RAD_ADMINBOX_FOREIGNKEY]*/
            
            // Store values in dataManager object
            $this->dataManager->loadFromArray( $this->formValues );
            
            // Save the values into the Table.
            if (!$this->dataManager->isLoaded()) {
                $this->dataManager->createNewEntry();
            } else {
                $this->dataManager->updateDBTable();
            }
            
            
            
        } // end if
        
        // now Clear out dataManager & FormValues
        $this->dataManager->clearValues();
        $this->formValues = $this->dataManager->getArrayOfValues();

        
        // on a successful update return fields_id to ''
        $this->fields_id='';
        
        
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
        
        
        
        /*
         * store the link values
         */
        // example:
            // $this->linkValues[ 'view' ] = 'add/new/href/data/here';


        // store the link labels
        $this->linkLabels[ 'edit' ] = $this->labels->getLabel( '[Edit]' );
        $this->linkLabels[ 'del'  ] = $this->labels->getLabel( '[Delete]' );
        $this->linkLabels[ 'cont' ] = $this->labels->getLabel( '[Continue]');
        // $this->linkLabels[ 'view' ] = 'new link label here';

        
        
        /*
         * store any additional link Columns
         */
        // example:
            //$title = $this->labels->getLabel( '[title_groups]');
            //$columnLabel = $this->labels->getLabel( '[groups]');
            //$link = $this->linkValues[ 'groups' ];
            //$fieldName = 'accessgroup_id';
            //$this->addLinkColumn( $title, $columnLabel, $link, $fieldName);
            
            
        /*
         * Update any label tags ...
         */
        // example:
            // $name = $user->getName();
            // $this->labels->setLabelTag( '[Title]', '[userName]', $name);


        // NOTE:  this parent method prepares the $this->template with the 
        // common AdminBox data.  
        $this->prepareTemplate( $path );
        
        
        // store the statevar id to edit
        $this->template->set( 'editEntryID', $this->fields_id );
        
        


        
        // store all the fields to the template
        $this->setFormFieldsToTemplate();
        
        /*
         * Form related Template variables:
         */
        
        
        /*
         * Insert the date start/end values for the following date fields:
         */
        // example:
            //$this->template->set( 'startYear_[fieldName]', 2000);
            //$this->template->set( 'endYear_[fieldName]', 2010);



        /*
         * List related Template variables :
         */
        // Store the XML Node name for the Data Access Field List
        $xmlNodeName = RowManager_FieldManager::XML_NODE_NAME;
        $this->template->set( 'rowManagerXMLNodeName', $xmlNodeName);
        
        // store the primary key field name for the data being displayed
        $this->template->set( 'primaryKeyFieldName', 'fields_id');
        
        // store data list to the template
        // NOTE: we initialize it here to make sure we capture any new data 
        // from a recent processData() call.
        $dataAccessManager = new RowManager_FieldManager();
        $dataAccessManager->setEventID( $this->event_id);
        $dataAccessManager->setSortOrder( $this->sortBy );
//        $this->dataList = new FieldList( $this->sortBy );
        $this->dataList = $dataAccessManager->getListIterator();
        $this->template->setXML( 'dataList', $this->dataList->getXML() );
        
        
        
        
        /*
         * Add any additional data required by the template here
         */
        
        // get a list of all field type IDs
        $fieldtype = new RowManager_FieldTypeManager();
        $fieldtype->setSortOrder( 'fieldtype_id' );
        $fieldtypeList = new ListIterator($fieldtype);	
        $fieldtypeArray = $fieldtypeList->getDropListArray();

        $this->template->set( 'list_fieldtype_id', $fieldtypeArray );
        
         // get a list of all data types; DB table = reg_cim_datatypes
        $type = new RowManager_DataTypeManager();
        $type->setSortOrder( 'datatypes_id' );
        $typeList = new ListIterator($type);	
        $typeArray = $typeList->getDropListArray();

        $this->template->set( 'list_datatypes_id', $typeArray );   
        
        //TODO: replace this with a reference to a multi_lingual label constant array...
        $boolArray = array();
        $boolArray['0'] = 'false';
        $boolArray['1'] = 'true';
        
        $this->template->set( 'list_fields_hidden', $boolArray ); 
		$this->template->set( 'list_fields_reqd', $boolArray ); 
        
        // get a list of all field priorities  (for some possible future use; for ease, requires priority DB table)
/*        $priority = new RowManager_FieldManager();
        $priority->setSortOrder( 'fields_priority' );
        $priorityList = new ListIterator($priority);	
        $priorityArray = $priorityList->getDropListArray();

        $this->template->set( 'list_fields_priority', $priorityArray );   
 */       
        
        $templateName = 'siteFormDataList.php';
        // if you are creating a custom template for this page then 
		// replace $templateName with the following:
		//$templateName = 'page_EditFormFields.php';
		
		return $this->template->fetch( $templateName );
        
    }
    
    	
}

?>