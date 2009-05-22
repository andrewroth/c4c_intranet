<?php
/**
 * @package RAD
 */ 
/**
 * class FormProcessor_AddFieldLabels
 * <pre> 
 * Allows you to attach specific labels to each field for use in displaying Titles, Form labels, examples, etc..
 * </pre>
 * @author Johnny Hausman
 * Date:   23 Mar 2005
 */
 // RAD Tools: FormGrid page
class  FormProcessor_AddFieldLabels extends PageDisplay_FormProcessor {

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
    const FORM_FIELDS = 'dafield_title|T|<skip>,dafield_formLabel|T|<skip>,dafield_example|T|<skip>,dafield_error|T|<skip>,daobj_id|T|<skip>';
    
    /** The list of field types to be displayed in the form */
    // NOTE: if a field isn't displayed, put a '-' for it's entry.
    const FORM_FIELD_TYPES = 'textbox,textbox,textbox,textbox,-';
    
    /** The Multilingual Page Key for this page */
    const MULTILINGUAL_PAGE_KEY = 'FormProcessor_AddFieldLabels';

	//VARIABLES:

	/** @var [STRING] The path to the module's root directory. */
	protected $pathModuleRoot;
	
	/** @var [STRING] The form Action for submitting this form. */
	protected $formAction;
	
	/** @var [OBJECT] The Viewer Object. */
	protected $viewer;
		
    /** @var [STRING] The initialization data for the rowManager. */
	protected $daobj_id;
	
	/** @var [OBJECT] The object that holds the Row Info. */
	protected $rowManager;


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
	 * @param $daobj_id [INTEGER] Value used to initialize the rowManager
	 * @return [void]
	 */
    function __construct($pathModuleRoot, $viewer, $formAction, $daobj_id ) 
    {
        // NOTE: be sure to call the parent constructor before trying to 
        //       use the ->formXXX arrays...
        parent::__construct( $formAction, FormProcessor_AddFieldLabels::FORM_FIELDS, FormProcessor_AddFieldLabels::FORM_FIELD_TYPES );
        
        $this->pathModuleRoot = $pathModuleRoot;
        $this->viewer = $viewer;
        $this->formAction = $formAction;
        $this->daobj_id = $daobj_id;

        
        // figure out the important fields for the rowItems
        $fieldsOfInterest = implode(',', $this->formFields);
        
        // create new rowManager (a List Iterator obj.)
        $this->rowManager = new DAFieldList( $daobj_id );
        
        // for each row item ...
        $this->rowManager->setFirst( );
        while( $rowItem = $this->rowManager->getNext() ) {
        
            // make sure rowItems have valid entries in the DB
            if (!$rowItem->isLoaded()) {
                $rowItem->createNewEntry();
            }
        
            // set the fields of interest ...
            $rowItem->setFieldsOfInterest( $fieldsOfInterest );
            
            // get the primaryID of this rowItem
            $primaryID = $rowItem->getPrimaryKeyValue();
            
            // now initialize beginning form values from rowItem object
            for( $indx=0; $indx<count($this->formFields); $indx++) {
                
                $key = $this->formFields[$indx];
                $this->formValues[ $key.$primaryID ] = $rowItem->getValueByFieldName( $key );
            } // next field
                
        } // next rowItem in rowManager 
         
        
        // now initialize the labels for this page
        // start by loading the default field labels for this Module
        $languageID = $viewer->getLanguageID();
        $seriesKey = moduleRAD::MULTILINGUAL_SERIES_KEY;
        $pageKey = moduleRAD::MULTILINGUAL_PAGE_FIELDS;
        $this->labels = new XMLObject_MultilingualManager( $languageID, $seriesKey, $pageKey );
        
        // load the site default form link labels
        $this->labels->loadPageLabels( SITE_LABEL_SERIES_SITE, SITE_LABEL_PAGE_FORM_LINKS );
        
        // then load the page specific labels for this page
        $pageKey = FormProcessor_AddFieldLabels::MULTILINGUAL_PAGE_KEY;
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
        // for each rowItem in family ...
        $this->rowManager->setFirst( );
        while( $rowItem = $this->rowManager->getNext() ) {
            
            parent::loadFromForm( $rowItem->getPrimaryKeyValue() );
   
        } // next rowItem
        
    } // end loadFromForm()
    
    
    
    //************************************************************************
	/**
	 * function isDataValid
	 * <pre>
	 * Verifies that the returned data is valid.
	 * </pre>
	 * @return [BOOL]
	 */
    function isDataValid() 
    {
        
        $isValid = true;
        
        // for each rowItem in rowManager ...
        $this->rowManager->setFirst( );
        while( $rowItem = $this->rowManager->getNext() ) {
            
            $isValid = (( parent::isDataValid( $rowItem->getPrimaryKeyValue() ) && ( $isValid == true )));  
            
        } // next rowItem
        
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
        // for each rowItem in rowManager ...
        $this->rowManager->setFirst( );
        while( $rowItem = $this->rowManager->getNext() ) {
            
            $formValues = array();
            $primaryID = $rowItem->getPrimaryKeyValue();
            
            // for each formField
             for( $indx=0; $indx<count($this->formFields); $indx++) {
    
                $keyDest = $this->formFields[$indx];
                $keySource = $keyDest.$primaryID;
                
                // compile formValues for current rowItem into array
                $formValues[ $keyDest ] = $this->formValues[ $keySource ];
            
            }  // next formField
            
            // now remember the value of the daObjID
            $formValues [ 'daobj_id' ] = $this->daobj_id;
            
            // update rowItem with new formValues
            $rowItem->loadFromArray( $formValues );
            $rowItem->updateDBTable();
                
        } // next rowItem
        
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
        
        // store the formAction value to the template
        $this->template->set( 'formAction', $this->formAction );
        
        // store the page labels in XML format...
        // NOTE: use this location to update any label tags ...
        $daObj = new RowManager_DAObjManager( $this->daobj_id );
        $name = $daObj->getName();
        $this->labels->setLabelTag( '[Title]', '[daobjName]', $name);
        $this->template->setXML( 'pageLabels', $this->labels->getLabelXML() );
        
        // store the rowManager to the template
        $this->template->setXML( 'rowList', $this->rowManager->getXML() );
        
        // store the label Field Name
        $this->template->set( 'labelFieldName', 'dafield_name' );
        
        // store all the fields to the template
        $this->setFormFieldsToTemplate();
        
        
        /*
         * Add any additional data required by the template here
         */
        // save the list of form fields
        $this->template->set( 'formFieldList', $this->formFields);
        
        // store the field types being displayed
        $fieldTypes = explode(',', FormProcessor_AddFieldLabels::FORM_FIELD_TYPES);
        $this->template->set( 'formFieldType', $fieldTypes);
        
        
        // Insert the date start/end values for the following date fields:
        // example:
            //$this->template->set( 'startYear_[fieldName]', 2000);
            //$this->template->set( 'endYear_[fieldName]', 2010);

        
        
        /*
         * List related Template variables :
         */
        // Store the XML Node name for the Data Access Field List
        $xmlNodeName = RowManager_DAFieldManager::XML_NODE_NAME;
        $this->template->set( 'rowManagerXMLNodeName', $xmlNodeName);
        
        // store the primary key field name for the data being displayed
        $this->template->set( 'primaryKeyFieldName', 'dafield_id');
        
        
		// uncomment this line if you are creating a template for this page
		//$templateName = 'page_AddFieldLabels.php';
		$templateName = 'siteFormGrid.php';  // generic form grid template
		
		return $this->template->fetch( $templateName );
        
    }
    
    
    
    //************************************************************************
	/**
	 * function setFormFieldsToTemplate
	 * <pre>
	 * Stores the fields into the Template object. This one is updated to 
	 * add fields by each rowItem's primary ID...
	 * </pre>
	 * @return [void]
	 */
    function setFormFieldsToTemplate() 
    {
        
        // for each rowItem in family ...
        $this->rowManager->setFirst( );
        while( $rowItem = $this->rowManager->getNext() ) {
        
            parent::setFormFieldsToTemplate( $rowItem->getPrimaryKeyValue() );
            
        } // next rowItem

    } // end setFormFieldsToTemplate() 
	
}

?>