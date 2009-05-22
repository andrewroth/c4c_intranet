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
    //                               B = Boolean
    //                               D = Date ( 3 lists boxes day/mon/year)
    //
    //             invalid_value = A value that is considered incorrect for this
    //                             form field.  Leaving it blank is equivalent 
    //                             to form_value != ''.  If a variable is able
    //                             to be left empty ('') then put the keyword
    //                             '<skip>' for this value. 
    const FORM_FIELDS = '[RAD_FIELDTYPE_LIST]';
    
    /** The Querystring Field for which entry is currently being edited ... */
    const MULTILINGUAL_PAGE_KEY = '[PageNamePrefix][PageName]';

	//VARIABLES:
	
	/** @var [STRING] The path to the module's root directory. */
	protected $pathModuleRoot;
	
	/** @var [STRING] The form Action for submitting this form. */
	protected $formAction;
	
	/** @var [OBJECT] The Viewer Object. */
	protected $viewer;
		
    /** @var [STRING] The initialization data for the dataManager. */
	protected $initVar;
	
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
	 * @param $initVar [INTEGER] Value used to initialize the dataManager
	 * @return [void]
	 */
    function __construct($pathModuleRoot, $viewer, $formAction, $initVar ) 
    {
        // NOTE: be sure to call the parent constructor before trying to 
        //       use the ->formXXX arrays...
        parent::__construct( [PageNamePrefix][PageName]::FORM_FIELDS );

        $this->pathModuleRoot = $pathModuleRoot;
        $this->viewer = $viewer;
        $this->formAction = $formAction;
        $this->initVar = $initVar;
        
        // figure out the important fields for the dataManager
        $fieldsOfInterest = implode(',', $this->formFields);
        
        $this->dataManager = new [RAD_DAOBJ_NAME]( $initVar );
        $this->dataManager->setFieldsOfInterest( $fieldsOfInterest );
        $this->formValues = $this->dataManager->getArrayOfValues();

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
        
        // Example : error checking
        // NOTE:  a custom error label [error_UniqueModuleName] is used
        // for the error.  This error label is created in the Page Labels
        // form.
        // Make sure that module name doesn't already exist...
//        if ($isValid) {
//            $isValid = $this->dataManager->isUniqueModuleName();
//            if (!$isValid) {
//              $this->formErrors[ 'module_name' ] = $this->labels->getLabel( '[error_UniqueModuleName]');
//            }
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
        
        $this->template = new Template( $this->pathModuleRoot.'[RAD_PATH_TEMPLATES]' );
        
        // store any additional values to template
        $this->template->set( 'formAction', $this->formAction );
        
        // store the page labels in XML format...
        $this->template->setXML( 'pageLabels', $this->labels->getLabelXML() );
        
        // store all the fields to the template
        $this->setFormFieldsToTemplate();
        
        /*
         * Add any additional data required by the template here
         */
         
        

		return $this->template->fetch( 'page_[PageName].php' );
        
    }
    
	
}

?>