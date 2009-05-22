<?php
/**
 * @package cim_hrdb
 */ 
/**
 * class FormProcessor_EditStaffFormContext 
 * <pre> 
 * Allows an admin to setup the basic information describing an HRDB form, i.e. the valid dates, whether it has associated schedule information, etc).
 * </pre>
 * @author CIM Team
 * Date:   29 Feb 2008
 */
 // RAD Tools: FormSingleEntry Page
class  FormProcessor_EditStaffFormContext extends PageDisplay_FormProcessor {

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
    const FORM_FIELDS = 'staffscheduletype_desc|T|,staffscheduletype_startdate|D|,staffscheduletype_enddate|D|,staffscheduletype_has_activities|B|<skip>,staffscheduletype_has_activity_phone|B|<skip>,staffscheduletype_activity_types|T|<skip>,staffscheduletype_is_shown|B|<skip>';
    
    /** The list of field types to be displayed in the form */
    // NOTE: if a field isn't displayed, put a '-' for it's entry.
    const FORM_FIELD_TYPES = 'textbox,datepicker,datepicker,checkbox,checkbox,combolist,checkbox';
    
    /** The Multilingual Page Key for this page */
    const MULTILINGUAL_PAGE_KEY = 'FormProcessor_EditStaffFormContext';

	//VARIABLES:
	
	/** @var [STRING] The path to the module's root directory. */
	protected $pathModuleRoot;
	
	/** @var [OBJECT] The Viewer Object. */
	protected $viewer;
		
    /** @var [STRING] The initialization data for the dataManager. */
	protected $staffscheduletype_id;
	



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
	 * @param $staffscheduletype_id [INTEGER] Value used to initialize the dataManager
	 * @return [void]
	 */
    function __construct($pathModuleRoot, $viewer, $formAction, $staffscheduletype_id ) 
    {
        // NOTE: be sure to call the parent constructor before trying to 
        //       use the ->formXXX arrays...
        $fieldList = FormProcessor_EditStaffFormContext::FORM_FIELDS;
        $fieldDisplayTypes = FormProcessor_EditStaffFormContext::FORM_FIELD_TYPES;
        parent::__construct( $formAction, $fieldList, $fieldDisplayTypes  );

        $this->pathModuleRoot = $pathModuleRoot;
        $this->viewer = $viewer;

        $this->staffscheduletype_id = $staffscheduletype_id;

        
        // figure out the important fields for the dataManager
        $fieldsOfInterest = implode(',', $this->formFields);
        
        $this->dataManager = new RowManager_StaffScheduleTypeManager( $staffscheduletype_id );
        $this->dataManager->setFieldsOfInterest( $fieldsOfInterest );
        $this->formValues = $this->dataManager->getArrayOfValues();
        
//         echo 'PRE form values = <pre>'.print_r($this->formValues,true).'</pre>'; 

        // now initialize the labels for this page
        // start by loading the default field labels for this Module
        $languageID = $viewer->getLanguageID();
        $seriesKey = modulecim_hrdb::MULTILINGUAL_SERIES_KEY;
        $pageKey = modulecim_hrdb::MULTILINGUAL_PAGE_FIELDS;
        $this->labels = new MultilingualManager( $languageID, $seriesKey, $pageKey );
        
        // then load the page specific labels for this page
        $pageKey = FormProcessor_EditStaffFormContext::MULTILINGUAL_PAGE_KEY;
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
// 	    echo 'form values = <pre>'.print_r($this->formValues,true).'</pre>';
        // save the value of the Foriegn Key(s)
        /*[RAD_ADMINBOX_FOREIGNKEY]*/
        
        // Store activity types CSV list, if any values found
        if (isset($this->formValues['staffscheduletype_activity_types']))
        {
	        $activity_types = $this->formValues['staffscheduletype_activity_types'];
	        if (is_array($activity_types))
	        {
		        $filter_list = '';
		        $activity_type_filters = $this->formValues['staffscheduletype_activity_types'];
		        reset($activity_type_filters);
		        foreach (array_keys($activity_type_filters) as $key)
		        {
			        $record = current($activity_type_filters);
			        $filter_list .= $record.',';
			        next($activity_type_filters);
		        }
		        $filter_list = substr($filter_list,0,-1);
		        $this->formValues['staffscheduletype_activity_types'] = $filter_list;
	        }
	        else {
		        $this->formValues['staffscheduletype_activity_types'] = '';	// ensures that '<skip>' is not stored
	        }
        }
	        
		        
        
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
        $this->template->set( 'startYear_staffscheduletype_startdate', 2008);
        $this->template->set( 'endYear_staffscheduletype_startdate', 2018);

        $this->template->set( 'startYear_staffscheduletype_enddate', 2008);
        $this->template->set( 'endYear_staffscheduletype_enddate', 2018);

        
/****        
        // Retrieve names and e-mail addresses of registrants (all/per-campus)
		  $data_iterator = $this->dataManager->getListIterator();
		  $data_array = $data_iterator->getDataList();
		  
		  $email_contacts = array();
		  reset($data_array);
		  foreach (array_keys($data_array) as $k)
		  {
			  $record = current($data_array);
// 			  $person_id = $record['person_id'];	
			  $person_name = $record['person_lname'].', '.$record['person_fname'];
			  $person_email = $record['person_email'];
			  
			  $reg_status = $record['registration_status'];
			  $gender = $record['gender_id'];
			  
			  $index = $person_email;	// default index is id of person 
			  if ($this->isSelectedContact($reg_status, $gender))	// determine if e-mail contact is SELECTED
			  {
				  $index = '*'.$index;		// add modifier to indicated SELECTED status
			  }
				  
			  $email_contacts[$index] = $person_name;	//.'<BR>('.$person_email.')';  <BR> doesnt work in listbox
			  next($data_array);
		  }
		  
// 		  echo ' contacts = <pre>'.print_r($email_contacts,true).'</pre>';
		  
		  $this->template->set( 'inclComboInstructions', true );
		  $this->template->set( 'comboBoxName','email_contacts[]'); 
		  $this->template->set( 'comboBoxSize',FormProcessor_EmailComposer::COMBO_BOX_SIZE); 
		  $this->template->set( 'comboDataArray',$email_contacts); 
******/                


        /*
         * Add any additional data required by the template here
         */
        $activityTypesManager = new RowManager_ActivityTypeManager( );
        $activityTypesList = $activityTypesManager->getListIterator( );
        $activityTypesArray = $activityTypesList->getDropListArray( );
        $this->template->set( 'list_staffscheduletype_activity_types', $activityTypesArray );      
        

		// uncomment this line if you are creating a template for this page
		//$templateName = 'page_EditStaffFormContext.php';
		// otherwise use the generic admin box template
		$templateName = 'siteFormSingle.php';
		
		return $this->template->fetch( $templateName );
        
    }
    
	
}

?>