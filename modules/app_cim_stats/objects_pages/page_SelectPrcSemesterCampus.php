<?php
/**
 * @package cim_stats
 */ 
/**
 * class FormProcessor_SelectPrcSemesterCampus 
 * <pre> 
 * Transition page for selecting a semester and campus for which to display indicated decisions
 * </pre>
 * @author Russ Martin
 * Date:   22 Jun 2006
 */
 // RAD Tools: FormSingleEntry Page
class  FormProcessor_SelectPrcSemesterCampus extends PageDisplay_FormProcessor {

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
    const FORM_FIELDS = 'semester_id|N|,campus_id|N|,prcMethod_id|T|<skip>';
    
    /** The list of field types to be displayed in the form */
    // NOTE: if a field isn't displayed, put a '-' for it's entry.
    const FORM_FIELD_TYPES = 'droplist,droplist,-';
    
    /** The Multilingual Page Key for this page */
    const MULTILINGUAL_PAGE_KEY = 'FormProcessor_SelectPrcSemesterCampus';

	//VARIABLES:
	
	/** @var [STRING] The path to the module's root directory. */
	protected $pathModuleRoot;
	
	/** @var [OBJECT] The Viewer Object. */
	protected $viewer;
		
    /** @var [STRING] The initialization data for the dataManager. */
	protected $prc_id;
	
	/** @var [INTEGER] Foreign Key needed by Data Manager */
	protected $prcMethod_id;

	/** @var [INTEGER] Foreign Key needed by Data Manager */
	protected $semester_id;

	/** @var [INTEGER] Foreign Key needed by Data Manager */
	protected $campus_id;

    /** @var [INTEGER] id of staff accessing the page */
    protected $staff_id;

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
	 * @param $prc_id [INTEGER] Value used to initialize the dataManager
	 * @param $prcMethod_id [INTEGER] The foreign key data for the data Manager
	 * @param $semester_id [INTEGER] The foreign key data for the data Manager
	 * @param $campus_id [INTEGER] The foreign key data for the data Manager
	 * @return [void]
	 */
    function __construct($pathModuleRoot, $viewer, $formAction, $prc_id , $prcMethod_id='', $semester_id='', $campus_id='', $staff_id ) 
    {
        // NOTE: be sure to call the parent constructor before trying to 
        //       use the ->formXXX arrays...
        $fieldList = FormProcessor_SelectPrcSemesterCampus::FORM_FIELDS;
        $fieldDisplayTypes = FormProcessor_SelectPrcSemesterCampus::FORM_FIELD_TYPES;
        parent::__construct( $formAction, $fieldList, $fieldDisplayTypes  );

        $this->pathModuleRoot = $pathModuleRoot;
        $this->viewer = $viewer;

        $this->prc_id = $prc_id;
        $this->prcMethod_id = $prcMethod_id;
        $this->semester_id = $semester_id;
        $this->campus_id = $campus_id;
        $this->staff_id = $staff_id;

        
        // figure out the important fields for the dataManager
        $fieldsOfInterest = implode(',', $this->formFields);
        
        $this->dataManager = new RowManager_PRCManager( $prc_id );
        $this->dataManager->setFieldsOfInterest( $fieldsOfInterest );
        $this->formValues = $this->dataManager->getArrayOfValues();

        // now initialize the labels for this page
        // start by loading the default field labels for this Module
        $languageID = $viewer->getLanguageID();
        $seriesKey = modulecim_stats::MULTILINGUAL_SERIES_KEY;
        $pageKey = modulecim_stats::MULTILINGUAL_PAGE_FIELDS;
        $this->labels = new MultilingualManager( $languageID, $seriesKey, $pageKey );
        
        // then load the page specific labels for this page
        $pageKey = FormProcessor_SelectPrcSemesterCampus::MULTILINGUAL_PAGE_KEY;
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
        /*
        // save the value of the Foriegn Key(s)
            $this->formValues[ 'prcMethod_id' ] = $this->prcMethod_id;
            $this->formValues[ 'semester_id' ] = $this->semester_id;
            $this->formValues[ 'campus_id' ] = $this->campus_id;*/
        /*[RAD_ADMINBOX_FOREIGNKEY]*/
        
        // store values in table manager object.
/*        $this->dataManager->loadFromArray( $this->formValues );
        
        // now update the DB with the values
        if (!$this->dataManager->isLoaded()) {
            $this->dataManager->createNewEntry();
        } else {
            $this->dataManager->updateDBTable();
        }
  */      
        
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
        
        
        
        // store the page labels in XML format...
        // NOTE: use this location to update any label tags ...
        // $name = $user->getName();
        // $this->labels->setLabelTag( '[Title]', '[userName]', $name);

        
        
        // NOTE:  this parent method prepares the $this->template with the 
        // common Form data.  
        $this->prepareTemplate( $path );
                
                

        /*
         * Form related Template variables:
         */
        
        // store the button label
        $this->template->set( 'buttonText', $this->labels->getLabel('[Continue]') );
        


        // Insert the date start/end values for the following date fields:
        // example:
            //$this->template->set( 'startYear_[fieldName]', 2000);
            //$this->template->set( 'endYear_[fieldName]', 2010);

                


        /*
         * Add any additional data required by the template here
         */
         
        // semester list
        $semesterManager = new RowManager_SemesterManager( );
        $semesterList = $semesterManager->getListIterator( );
        $semesterArray = $semesterList->getDropListArray( );
        $this->template->set( 'list_semester_id', $semesterArray );

        // for looking up the person_id of this staff member
        $staffManager = new RowManager_StaffManager( $this->staff_id );

        // campus list
        $assignmentManager = new RowManager_AssignmentsManager();
        $assignmentManager->setPersonID( $staffManager->getPersonID() );
        $assignmentManager->setAssignmentStatusID( CA_STAFF );
            
        $multiTableManager = new MultiTableManager();
        $multiTableManager->addRowManager($assignmentManager);
            
        $campusManager = new RowManager_CampusManager();
        $campusManager->setSortOrder('campus_desc');
        $multiTableManager->addRowManager( $campusManager, new JoinPair( $campusManager->getJoinOnCampusID(), $assignmentManager->getJoinOnCampusID() ) );
           
        $campusList = $multiTableManager->getListIterator();
        $campusArray = array();
        $campusList->setFirst();
        while( $campusList->moveNext() )
        {
            $campusObject = $campusList->getCurrent(new RowManager_CampusManager());
            $campusArray[$campusObject->getID()] = $campusObject->getLabel();
        }
        $this->template->set( 'list_campus_id', $campusArray );
        
		// uncomment this line if you are creating a template for this page
		//$templateName = 'page_SelectPrcSemesterCampus.php';
		// otherwise use the generic admin box template
		$templateName = 'siteFormSingle.php';
		
		return $this->template->fetch( $templateName );
        
    }
    
	
}

?>