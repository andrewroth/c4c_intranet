<?php
/**
 * @package cim_stats
 */ 
/**
 * class FormProcessor_SemesterReport 
 * <pre> 
 * Where campus directors enter stats for their campus for a given semester
 * </pre>
 * @author Russ Martin
 * Date:   21 Jun 2006
 */
 // RAD Tools: FormSingleEntry Page
class  FormProcessor_SemesterReport extends PageDisplay_FormProcessor {

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
    const FORM_FIELDS = 'semester_id|N|<skip>,campus_id|N|<skip>,semesterreport_avgPrayer|N|,semesterreport_avgWklyMtg|N|,semesterreport_numStaffChall|N|,semesterreport_numInternChall|N|,semesterreport_numFrosh|N|,semesterreport_numStaffDG|N|,semesterreport_numInStaffDG|N|,semesterreport_numStudentDG|N|,semesterreport_numInStudentDG|N|,semesterreport_numSpMultStaffDG|N|,semesterreport_numSpMultStdDG|N|';
    
    /** The list of field types to be displayed in the form */
    // NOTE: if a field isn't displayed, put a '-' for it's entry.
    const FORM_FIELD_TYPES = 'jumplist,jumplist,textbox,textbox,textbox,textbox,textbox,textbox,textbox,textbox,textbox,textbox,textbox';
    
    /** The Multilingual Page Key for this page */
    const MULTILINGUAL_PAGE_KEY = 'FormProcessor_SemesterReport';

	//VARIABLES:
	
	/** @var [STRING] The path to the module's root directory. */
	protected $pathModuleRoot;
	
	/** @var [OBJECT] The Viewer Object. */
	protected $viewer;
		
    /** @var [STRING] The initialization data for the dataManager. */
	protected $semesterreport_id;
	
	/** @var [INTEGER] Foreign Key needed by Data Manager */
	protected $semester_id;

	/** @var [INTEGER] Foreign Key needed by Data Manager */
	protected $campus_id;
	
	/** @var [INTEGER] Foreign Key needed */
	protected $staff_id;
	
    /** @var [OBJECT] An interator of a MultiTableManager. */	
	protected $campusListIterator;


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
	 * @param $semesterreport_id [INTEGER] Value used to initialize the dataManager
	 * @param $semester_id [INTEGER] The foreign key data for the data Manager
	 * @param $campus_id [INTEGER] The foreign key data for the data Manager
	 * @return [void]
	 */
    function __construct($pathModuleRoot, $viewer, $formAction, $semesterreport_id , $semester_id='', $campus_id='', $staff_id='') 
    {
        // NOTE: be sure to call the parent constructor before trying to 
        //       use the ->formXXX arrays...
        $fieldList = FormProcessor_SemesterReport::FORM_FIELDS;
        $fieldDisplayTypes = FormProcessor_SemesterReport::FORM_FIELD_TYPES;
        parent::__construct( $formAction, $fieldList, $fieldDisplayTypes  );

        $this->pathModuleRoot = $pathModuleRoot;
        $this->viewer = $viewer;

        $this->semesterreport_id = $semesterreport_id;
        $this->staff_id = $staff_id;
        
        // check the semester id
        $this->semester_id = $semester_id;
        if ( $this->semester_id == '' )
        {
            // echo 'semester NOT set, giving default value... ';
            $semesterManager = new RowManager_SemesterManager();
            $today = date('Y-m-d',time());
            if ( $semesterManager->loadByDate( $today ) )
            {
                $this->semester_id = $semesterManager->getID();
            }
            else if ( $semesterManager->checkIfFirstSemester( $today ) )
            {
                // echo "in base case<br/>";
                $this->semester_id = $semesterManager->getID();
            }
            else
            {
                die( 'ERROR - could not set semester - page_SemesterReport.php' );
            }
        }
        // echo '$this->semester_id['.$this->semester_id.']<br/>';
        
        // for looking up the person_id of this staff member
        $staffManager = new RowManager_StaffManager( $this->staff_id );
        
        // setup the 
        $assignmentManager = new RowManager_AssignmentsManager();
        $assignmentManager->setPersonID( $staffManager->getPersonID() );
        $assignmentManager->setAssignmentStatusID( CA_STAFF );
            
        $multiTableManager = new MultiTableManager();
        $multiTableManager->addRowManager($assignmentManager);
            
        $campusManager = new RowManager_CampusManager();
        $campusManager->setSortOrder('campus_desc');
        $multiTableManager->addRowManager( $campusManager, new JoinPair( $campusManager->getJoinOnCampusID(), $assignmentManager->getJoinOnCampusID() ) );
           
        $this->campusListIterator = $multiTableManager->getListIterator();
        
        if ( $campus_id != '' )
        {
            // echo 'campus_id is SET ['.$campus_id.']<br/>';
            $this->campus_id = $campus_id;
        }
        else
        {
            // set a default campus id
            // echo 'Choosing a default campus<br/>';
            $this->campusListIterator->setFirst();
            if ( $this->campusListIterator->moveNext() )
            {
                $campusObject = $this->campusListIterator->getCurrent(new RowManager_CampusManager());
                $this->campus_id = $campusObject->getID();
            }
            else
            {
                die('ERROR - unable to set campus_id - page_StaffWeeklyReport');
            }
        }
        
        // figure out the important fields for the dataManager
        $fieldsOfInterest = implode(',', $this->formFields);
        
        $this->dataManager = new RowManager_SemesterReportManager( $this->semester_id, $this->campus_id );
        $this->dataManager->setFieldsOfInterest( $fieldsOfInterest );
        $this->formValues = $this->dataManager->getArrayOfValues();

        // now initialize the labels for this page
        // start by loading the default field labels for this Module
        $languageID = $viewer->getLanguageID();
        $seriesKey = modulecim_stats::MULTILINGUAL_SERIES_KEY;
        $pageKey = modulecim_stats::MULTILINGUAL_PAGE_FIELDS;
        $this->labels = new MultilingualManager( $languageID, $seriesKey, $pageKey );
        
        // then load the page specific labels for this page
        $pageKey = FormProcessor_SemesterReport::MULTILINGUAL_PAGE_KEY;
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
        // save the value of the Foriegn Key(s)
        $this->formValues[ 'semester_id' ] = $this->semester_id;
        $this->formValues[ 'campus_id' ] = $this->campus_id;
        /*[RAD_ADMINBOX_FOREIGNKEY]*/
        
        // store values in table manager object.
        $this->dataManager->loadFromArray( $this->formValues );
        
        // now update the DB with the values
        if (!$this->dataManager->isLoaded()) {
            $this->dataManager->createNewEntry();
        } else {
            $this->dataManager->updateDBTable();
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
        
        // Uncomment the following line if you want to create a template 
        // tailored for this page:
        //$path = $this->pathModuleRoot.'templates/';
        // Otherwise use the standard Templates for the site:
        $path = SITE_PATH_TEMPLATES;
        
        
        
        // store the page labels in XML format...
        // NOTE: use this location to update any label tags ...
        // $name = $user->getName();
        // $this->labels->setLabelTag( '[Title]', '[userName]', $name);

        // temporarily reset the form values so the defaults show up properly in the jumplists
        $this->formValues[ 'semester_id' ] = $this->linkValues['semesterJumpLink'].$this->semester_id;
        $this->formValues[ 'campus_id' ] = $this->linkValues['campusJumpLink'].$this->campus_id;
        
        // NOTE:  this parent method prepares the $this->template with the 
        // common Form data.  
        $this->prepareTemplate( $path );
                
                

        /*
         * Form related Template variables:
         */
        
        // store the button label
        $this->template->set( 'buttonText', $this->labels->getLabel('[Update]') );
        


        // Insert the date start/end values for the following date fields:
        // example:
            //$this->template->set( 'startYear_[fieldName]', 2000);
            //$this->template->set( 'endYear_[fieldName]', 2010);

                


        /*
         * Add any additional data required by the template here
         */
        
        // Semester list.
        $jumpLink = $this->linkValues['semesterJumpLink'];
        $semesterManager = new RowManager_SemesterManager( );
        $semesterList = $semesterManager->getListIterator( );
        $semesterArray = $semesterList->getDropListArray( null, $jumpLink );
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
           
        $jumpLink = $this->linkValues['campusJumpLink']; 
        $campusList = $multiTableManager->getListIterator();
        $campusArray = array();
        $campusList->setFirst();
        while( $campusList->moveNext() )
        {
            $campusObject = $campusList->getCurrent(new RowManager_CampusManager());
            $campusArray[$jumpLink.$campusObject->getID()] = $campusObject->getLabel();
        }
        $this->template->set( 'list_campus_id', $campusArray );

		// uncomment this line if you are creating a template for this page
		//$templateName = 'page_SemesterReport.php';
		// otherwise use the generic admin box template
		$templateName = 'siteFormSingle.php';
		
		return $this->template->fetch( $templateName );
        
    }
    
	
}

?>