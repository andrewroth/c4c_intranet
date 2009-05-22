<?php
/**
 * @package RAD
 */ 
/**
 * class FormProcessor_ViewPageFields 
 * <pre> 
 * This page displays the list of available fields to work with on this page.
 * </pre>
 * @author Johnny Hausman
 * Date:   21 Feb 2005
 */
class  FormProcessor_ViewPageFields extends PageDisplay_FormProcessor {

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
    const FORM_FIELDS = 'page_rowMgrID|T|<skip>,page_listMgrID|H|<skip>';
    
    /** The Multilingual Page Key for this page */
    const MULTILINGUAL_PAGE_KEY = 'FormProcessor_ViewPageFields';

	//VARIABLES:
	
	/** @var [STRING] The path to the module's root directory. */
	protected $pathModuleRoot;
	
	/** @var [STRING] The form Action for submitting this form. */
	protected $formAction;
	
	/** @var [OBJECT] The Viewer Object. */
	protected $viewer;
		
    /** @var [STRING] The initialization data for the dataManager. */
	protected $initVar;
	
	/** @var [OBJECT] The data manager object. (PageManager) */
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
	 * @param $initVar [INTEGER] Value used to initialize the dataManager
	 * @return [void]
	 */
    function __construct($pathModuleRoot, $viewer, $formAction, $initVar ) 
    {
        // NOTE: be sure to call the parent constructor before trying to 
        //       use the ->formXXX arrays...
        parent::__construct( $formAction, FormProcessor_ViewPageFields::FORM_FIELDS, '' );

        $this->pathModuleRoot = $pathModuleRoot;
        $this->viewer = $viewer;
        $this->formAction = $formAction;
        $this->initVar = $initVar;
        
        // figure out the important fields for the dataManager
        $fieldsOfInterest = implode(',', $this->formFields);
        
        $this->dataManager = new RowManager_PageManager( $initVar );
//        $this->dataManager->setFieldsOfInterest( $fieldsOfInterest );
//        $this->formValues = $this->dataManager->getArrayOfValues();

        // now initialize the labels for this page
        // start by loading the default field labels for this Module
        $languageID = $viewer->getLanguageID();
        $seriesKey = moduleRAD::MULTILINGUAL_SERIES_KEY;
        $pageKey = moduleRAD::MULTILINGUAL_PAGE_FIELDS;
        $this->labels = new XMLObject_MultilingualManager( $languageID, $seriesKey, $pageKey );
        
        // load the site default form link labels
        $this->labels->loadPageLabels( SITE_LABEL_SERIES_SITE, SITE_LABEL_PAGE_FORM_LINKS );
        
        // then load the page specific labels for this page
        $pageKey = FormProcessor_ViewPageFields::MULTILINGUAL_PAGE_KEY;
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

        // this form contains special variables from the form.
        $formFields = array();
        if (isset($_REQUEST[ 'formField' ]) ) {
            $formFields = $_REQUEST[ 'formField' ];
        }
        
        $listFields = array();
        if (isset($_REQUEST[ 'listField' ]) ) {
            $listFields = $_REQUEST[ 'listField' ];
        }
        
        $this->formValues[ 'formFields' ] = $formFields;
        $this->formValues[ 'listFields' ] = $listFields;
        
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
        
        // if a form object was selected for this page
        $formDaObj = $this->dataManager->getFormDAObj();
        if ($formDaObj->isLoaded() ) {
        
            // if no form fields selected
            if ( count( $this->formValues[ 'formFields' ] ) == 0) {
                
                // mark an error
                $isValid = false;
                $this->formErrors[ 'formFields' ] = $this->labels->getLabel( '[error_formFields]');
            }
        }
        
        // if a list object was selected for this page
        $listDaObj = $this->dataManager->getListDAObj();
        if ($listDaObj->isLoaded() ) {
        
            // if no list fields selected 
            if ( count( $this->formValues[ 'listFields' ] ) == 0) {
            
                // mark an error
                $isValid = false;
                $this->formErrors[ 'listFields' ] = $this->labels->getLabel( '[error_listFields]');
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
        
        // process form Fields
        $formDAObj = $this->dataManager->getFormDAObj();
        $pageID = $this->dataManager->getID();
        $formDAObjID = $formDAObj->getID();
        $fieldEntries = new PageFieldList( $pageID, $formDAObjID, 1 );
        
        $formList = $this->formValues[ 'formFields' ] ;
        
 // update field set ( $pageID, $daObjID, $isForm, $fieldEntries, $formList )
        $this->updateFieldSet($pageID, $formDAObjID, '1', $fieldEntries, $formList );
        
        // process list Fields
        $listDAObj = $this->dataManager->getListDAObj();
        $pageID = $this->dataManager->getID();
        $listDAObjID = $listDAObj->getID();
        $fieldEntries = new PageFieldList( $pageID, $listDAObjID, 0 );
        
        $listList = $this->formValues[ 'listFields' ];
        
        $this->updateFieldSet($pageID, $listDAObjID, 0, $fieldEntries, $listList );
        
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
        
        $this->template = new Template( $this->pathModuleRoot.'templates/' );
        
        // store any additional values to template
        $this->template->set( 'formAction', $this->formAction );
        
         // store the page labels
        // NOTE: use this location to update any label tags ...
        // example:
        $name = $this->dataManager->getName();
        $this->labels->setLabelTag( '[Title]', '[pageName]', $name);
        $this->template->setXML( 'pageLabels', $this->labels->getLabelXML() );
        
        // store all the fields to the template
//        $this->setFormFieldsToTemplate();
        
        /*
         * Add any additional data required by the template here
         */
         
        // Store the XML Node name for the Data Access Field List
        $xmlNodeName = RowManager_DAFieldManager::XML_NODE_NAME;
        $this->template->set( 'rowManagerXMLNodeName', $xmlNodeName);
        
        /*
         * get list of Form DAObj Fields
         */
        // get Form DAObj from PageManager 
        $formDAObj = $this->dataManager->getFormDAObj();

        // get List of Fields from Form DAObj Manager
        $fieldList = $formDAObj->getFieldList();

        // set List of Form Fields
        $this->template->setXML( 'formFields', $fieldList->getXML() );
        
        
        // get list of current page Fields for Form DAObj Mgr from PageManager
        $pageID = $this->dataManager->getID();
        $formDAObjID = $formDAObj->getID();
        $currentFormFieldList = new PageFieldList( $pageID, $formDAObjID, 1 );
        
        // set list of current Form Fields
        $this->template->setXML( 'currentFormFields', $currentFormFieldList->getXML() );
        
        // set ID of Form DAObj
        $this->template->set( 'formDAObjID', $formDAObjID );
        
        
        /*
         * get list of List DAObj Fields
         */
        // get List DAObj form PageManager
        $listDAObj = $this->dataManager->getListDAObj();
         
        // get List of Fields from List DAObj Manager
        $fieldList = $listDAObj->getFieldList();

        // set List of List Fields
        $this->template->setXML( 'listFields', $fieldList->getXML() );
        
        // get list of current page fields for List DAObj Mgn from PageManager
        $pageID = $this->dataManager->getID();
        $listDAObjID = $listDAObj->getID();
        $currentListFieldList = new PageFieldList( $pageID, $listDAObjID, 0 );
        
        // set list of current List Fields
        $this->template->setXML( 'currentListFields', $currentListFieldList->getXML() );
        
        // set ID of List DAObj
        $this->template->set( 'listDAObjID', $listDAObjID );

		return $this->template->fetch( 'page_ViewPageFields.php' );
        
    }
    
    
    
    //************************************************************************
	/**
	 * function updateFieldSet
	 * <pre>
	 * Processes a given list of fields to be linked to this page
	 * </pre>
	 * @param $pageID [INTEGER] the ID of the current page
	 * @param $daObjID [INTEGER] the ID of the associated Data Access Object
	 * @param $isForm [INTEGER] flag indicating if associated with form DAObj
	 * @param $fieldEntries [OBJECT] PageFieldList object with current data
	 * @param $formList [ARRAY] the values returned from the form
	 * @return [void]
	 */
    function updateFieldSet($pageID, $daObjID, $isForm, $fieldEntries, $formList) 
    {
        $currentFieldArray = array();
        $fieldEntries->setFirst();
        
        /*
         * First remove unselected fields ...
         */
         
        // for each entry
        while( $field = $fieldEntries->getNext() ) {

            // if current field is in list returned from form
            if ( in_array( (string) $field->getFieldID(), $formList) ) {
            
                // add current entry to currentArray
                $currentFieldArray[] = $field->getFieldID();
                
            } else { 
            // else
            
                // delete current entry
                $field->deleteEntry();
                
            }// end if
            
        } // next entry
         
         
         
        /*
         * Now Add selected fields not already in table
         */
        
        // for each item in list returned from form
        for ( $indx=0; $indx<count($formList); $indx++) {
        
            // if current item not in currentArray
            if (!in_array($formList[$indx], $currentFieldArray) ) {
            
                // create new PageField Entry in table
                $pageField = new RowManager_PageFieldManager();
                $pageField->createNewEntry();
                
                // fill in current data set
                $pageField->setPageID( $pageID );
                $pageField->setDAObjID( $daObjID );
                $pageField->setDAFieldID( $formList[$indx] );
                $pageField->setIsForm( $isForm );
                
                // update entry
                $pageField->updateDBTable();
                
            } // end if
            
        } // next item
        
    } // end updateFieldSet()
    
	
}

?>