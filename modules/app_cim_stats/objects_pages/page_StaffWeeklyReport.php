<?php
/**
 * @package cim_stats
 */ 
/**
 * class FormProcessor_StaffWeeklyReport 
 * <pre> 
 * Page where staff enter their weekly stats.
 * </pre>
 * @author Russ Martin
 * Date:   10 Jun 2006
 */
 // RAD Tools: FormSingleEntry Page
class  FormProcessor_StaffWeeklyReport extends PageDisplay_FormProcessor {

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
    // modified by Russ Martin on June 4, 2009
    // removed the fields of "HS Presentations" (student/staff) and "Completed Follow-up" (student/staff) as we are no longer measuring these
    // const FORM_FIELDS = 'staff_id|N|<skip>,week_id|N|<skip>,campus_id|N|<skip>,weeklyReport_1on1SpConv|N|,weeklyReport_1on1SpConvStd|N|,weeklyReport_1on1GosPres|N|,weeklyReport_1on1GosPresStd|N|,weeklyReport_1on1HsPres|N|,weeklyReport_1on1HsPresStd|N|,weeklyReport_7upCompleted|N|,weeklyReport_7upCompletedStd|N|';
    const FORM_FIELDS = 'staff_id|N|<skip>,week_id|N|<skip>,campus_id|N|<skip>,weeklyReport_1on1SpConv|N|,weeklyReport_1on1SpConvStd|N|,weeklyReport_1on1GosPres|N|,weeklyReport_1on1GosPresStd|N|,weeklyReport_1on1HsPres|N|';
    
    /** The list of field types to be displayed in the form */
    // NOTE: if a field isn't displayed, put a '-' for it's entry.
    const FORM_FIELD_TYPES = '-,jumplist,jumplist,textbox,textbox,textbox,textbox,textbox';
    
    /** The Multilingual Page Key for this page */
    const MULTILINGUAL_PAGE_KEY = 'FormProcessor_StaffWeeklyReport';

	//VARIABLES:
	
	/** @var [STRING] The path to the module's root directory. */
	protected $pathModuleRoot;
	
	/** @var [OBJECT] The Viewer Object. */
	protected $viewer;
		
    /** @var [INTEGER] The initialization data for the dataManager. */
	protected $staff_id;
	
	/** @var [INTEGER] The initialization data for the dataManager. */
	protected $week_id;

    /** @var [INTEGER] The initialization data for the dataManager. */
	protected $campus_id;

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
	 * @param $staff_id [INTEGER] Value used to initialize the dataManager
	 * @return [void]
	 */
    function __construct($pathModuleRoot, $viewer, $formAction, $staff_id, $week_id='', $campus_id='' ) 
    {
        // NOTE: be sure to call the parent constructor before trying to 
        //       use the ->formXXX arrays...
        $fieldList = FormProcessor_StaffWeeklyReport::FORM_FIELDS;
        $fieldDisplayTypes = FormProcessor_StaffWeeklyReport::FORM_FIELD_TYPES;
        parent::__construct( $formAction, $fieldList, $fieldDisplayTypes  );

        $this->pathModuleRoot = $pathModuleRoot;
        $this->viewer = $viewer;
        $this->campus_id = $campus_id;
        $this->staff_id = $staff_id;
        
        if ( $week_id != '' )
        {
            // echo 'week_id is SET ['.$week_id.']<br/>';
            $this->week_id = $week_id;
        }
        else
        {
            // give a default value to the week id            
            $weekManager = new RowManager_WeekManager();
            if ( $weekManager->loadByDate( date( 'Y-m-d', time() ) ) )
            {
                $this->week_id = $weekManager->getID();
            }
            else
            {
                die("ERROR - couldn't see week_id - page_StaffWeeklyReport.php");
            }
        }
        
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
        
        $this->dataManager = new RowManager_WeeklyReportManager( $this->week_id, $this->staff_id, $this->campus_id );
        $this->dataManager->setFieldsOfInterest( $fieldsOfInterest );
        $this->formValues = $this->dataManager->getArrayOfValues();

        // now initialize the labels for this page
        // start by loading the default field labels for this Module
        $languageID = $viewer->getLanguageID();
        $seriesKey = modulecim_stats::MULTILINGUAL_SERIES_KEY;
        $pageKey = modulecim_stats::MULTILINGUAL_PAGE_FIELDS;
        $this->labels = new MultilingualManager( $languageID, $seriesKey, $pageKey );
        
        
        // then load the page specific labels for this page
        $pageKey = FormProcessor_StaffWeeklyReport::MULTILINGUAL_PAGE_KEY;
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
        $this->formValues['staff_id'] = $this->staff_id;
        $this->formValues['week_id'] = $this->week_id;
        $this->formValues['campus_id'] = $this->campus_id;
        /*[RAD_ADMINBOX_FOREIGNKEY]*/
        
        // store values in table manager object.
        $this->dataManager->loadFromArray( $this->formValues );
        
        // now update the DB with the values
        if (!$this->dataManager->isLoaded()) {
            // echo 'Creating new entry!<br/>';
            $this->dataManager->createNewEntry();
        } else {
            // echo 'Updating Entry!<br/>';
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
        $this->formValues[ 'week_id' ] = $this->linkValues['weekJumpLink'].$this->week_id;
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
         

        // week list
        $jumpLink = $this->linkValues['weekJumpLink'];
        
        $weekManager = new RowManager_WeekManager();
        $weekManager->setSortOrder('week_endDate');
        $weekList = new ListIterator( $weekManager );
        $jumpList = $weekList->getDropListArray(null, $jumpLink);
        $this->template->set( 'list_week_id', $jumpList );
        
        // campus list
        $jumpLink = $this->linkValues['campusJumpLink'];
        $campusArray = array();
        $this->campusListIterator->setFirst();
        while( $this->campusListIterator->moveNext() )
        {
            $campusObject = $this->campusListIterator->getCurrent(new RowManager_CampusManager());
            $campusArray[$jumpLink.$campusObject->getID()] = $campusObject->getLabel();
        }
        // echo '<pre>'.print_r($campusArray, true ).'</pre>';
        $this->template->set( 'list_campus_id', $campusArray );
        
        // add the definitions at the bottom of the page
        $defsContent = new Template($this->pathModuleRoot.'templates/');
        $a = $defsContent->fetch( 'defs.tpl.php'  );
        $this->template->set( 'footerContent', $a );

		// uncomment this line if you are creating a template for this page
		//$templateName = 'page_StaffWeeklyReport.php';
		// otherwise use the generic admin box template
		$templateName = 'siteFormSingle.php';
		
		return $this->template->fetch( $templateName );
        
    }
    
	
}

?>
