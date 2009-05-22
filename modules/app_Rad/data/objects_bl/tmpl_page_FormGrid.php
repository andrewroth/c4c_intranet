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
 // RAD Tools: FormGrid page
class  [PageNamePrefix][PageName] extends FormProcessor {

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
    //                               N = Numeric 
    //                               B = Boolean
    //                               D = Date ( 3 lists boxes day/mon/year)
    //                            Time = Time ( 3 list boxes  HH/MM/Am )
    //                        DateTime = Date + Time pickers ...
    //
    //             invalid_value = A value that is considered incorrect for this
    //                             form field.  Leaving it blank is equivalent 
    //                             to form_value != ''.  If a variable is able
    //                             to be left empty ('') then put the keyword
    //                             '<skip>' for this value. 
    const FORM_FIELDS = '[RAD_FIELDTYPE_LIST]';
    
    /** The list of field types to be displayed in the form */
    // NOTE: if a field isn't displayed, put a '-' for it's entry.
    const FORM_FIELD_TYPES = '[RAD_FORMENTRYTYPE_LIST]';
    
    /** The Multilingual Page Key for this page */
    const MULTILINGUAL_PAGE_KEY = '[PageNamePrefix][PageName]';

	//VARIABLES:

	/** @var [STRING] The path to the module's root directory. */
	protected $pathModuleRoot;
	
	/** @var [STRING] The form Action for submitting this form. */
	protected $formAction;
	
	/** @var [OBJECT] The Viewer Object. */
	protected $viewer;
		
    /** @var [STRING] The initialization data for the rowManager. */
	protected $[RAD_FORMGRID_LIST_INIT];
	
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
	 * @param $[RAD_FORMGRID_LIST_INIT] [INTEGER] Value used to initialize the rowManager
	 * @return [void]
	 */
    function __construct($pathModuleRoot, $viewer, $formAction, $[RAD_FORMGRID_LIST_INIT] ) 
    {
        // NOTE: be sure to call the parent constructor before trying to 
        //       use the ->formXXX arrays...
        parent::__construct( [PageNamePrefix][PageName]::FORM_FIELDS );
        
        $this->pathModuleRoot = $pathModuleRoot;
        $this->viewer = $viewer;
        $this->formAction = $formAction;
        $this->[RAD_FORMGRID_LIST_INIT] = $[RAD_FORMGRID_LIST_INIT];

        
        // figure out the important fields for the rowItems
        $fieldsOfInterest = implode(',', $this->formFields);
        
        // create new rowManager (a List Iterator obj.)
        $this->rowManager = new [RAD_FORMGRID_LIST_OBJ_NAME]( $[RAD_FORMGRID_LIST_INIT] );
        
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
        $seriesKey = module[ModuleName]::MULTILINGUAL_SERIES_KEY;
        $pageKey = module[ModuleName]::MULTILINGUAL_PAGE_FIELDS;
        $this->labels = new MultilingualManager( $languageID, $seriesKey, $pageKey );
        
        // then load the page specific labels for this page
        $pageKey = [PageNamePrefix][PageName]::MULTILINGUAL_PAGE_KEY;
        $this->labels->loadPageLabels( $pageKey );
        
        // load the site default form link labels
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
        //$path = $this->pathModuleRoot.'[RAD_PATH_TEMPLATES]';
        // Otherwise use the standard Templates for the site:
        $path = SITE_PATH_TEMPLATES;
        $this->template = new Template( $path );
        
        // store the formAction value to the template
        $this->template->set( 'formAction', $this->formAction );
        
        // store the page labels in XML format...
        // NOTE: use this location to update any label tags ...
        // $name = $user->getName();
        // $this->labels->setLabelTag( '[Title]', '[userName]', $name);
        $this->template->setXML( 'pageLabels', $this->labels->getLabelXML() );
        
        // store the rowManager to the template
        $this->template->setXML( 'rowList', $this->rowManager->getXML() );
        
        // store the label Field Name
        $this->template->set( 'labelFieldName', '[RAD_FORMGRID_LABEL_NAME]' );
        
        // store all the fields to the template
        $this->setFormFieldsToTemplate();
        
        
        /*
         * Add any additional data required by the template here
         */
        // save the list of form fields
        $this->template->set( 'formFieldList', $this->formFields);
        
        // store the field types being displayed
        $fieldTypes = explode(',', [PageNamePrefix][PageName]::FORM_FIELD_TYPES);
        $this->template->set( 'formFieldType', $fieldTypes);
        
        
        // Insert the date start/end values for the following date fields:
        // example:
            //$this->template->set( 'startYear_[fieldName]', 2000);
            //$this->template->set( 'endYear_[fieldName]', 2010);
/*[RAD_DAOBJ_FIELD_DATE_PARAM]*/
        
        
        /*
         * List related Template variables :
         */
        // Store the XML Node name for the Data Access Field List
        $xmlNodeName = RowManager_[RAD_DAOBJ_MANAGER_NAME]::XML_NODE_NAME;
        $this->template->set( 'rowManagerXMLNodeName', $xmlNodeName);
        
        // store the primary key field name for the data being displayed
        $this->template->set( 'primaryKeyFieldName', '[RAD_FORM_INIT]');
        
        
		// uncomment this line if you are creating a template for this page
		//$templateName = 'page_[PageName].php';
		$templateName = '[RAD_TEMPLATE_DEFAULT]';  // generic form grid template
		
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