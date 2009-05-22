<?php
/**
 * @package cim_hrdb
 */ 
/**
 * class FormProcessor_EditStaffScheduleForm
 * <pre> 
 * This page is a rough template (to be modified) intended to provide an online HRDB form for general users.
 * Fields are custom-built using page_EditFormFields.php
 * </pre>
 * @author Hobbe Smit
 * Date:   12 Feb 2008
 */
 // RAD Tools: FormSingleEntry Page
class  FormProcessor_EditBasicStaffForm extends PageDisplay_FormProcessor {		//_AdminBox

	//CONSTANTS:
	const NO_FIELDGROUP_ID = 0;	// the id indicating the field is *not* repeatable
	
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
//    const FORM_FIELDS = 'fields_id|N|,fieldvalues_value|T|,registration_id|T|<skip>';
	 const FORM_FIELDS = 'fields_id,fieldvalues_value';
    
    /** The list of field types to be displayed in the form */
    // NOTE: if a field isn't displayed, put a '-' for it's entry.
//    const FORM_FIELD_TYPES = 'textbox,textarea,-';
    
    /** The Multilingual Page Key for this page */
    const MULTILINGUAL_PAGE_KEY = 'FormProcessor_EditStaffScheduleForm';

	//VARIABLES:
	
	/** @var [STRING] The path to the module's root directory. */
	protected $pathModuleRoot;
	
	/** @var [OBJECT] The Viewer Object. */
	protected $viewer;
	
	/** @var [STRING] The sorting key. */
	protected $sortBy;	
		
    /** @var [STRING] The initialization data for the dataManager. */
	protected $fieldvalues_id;
	
	/** @var [INTEGER] Foreign Key needed by Data Manager */
	protected $fields_id;

	/** @var [INTEGER] Foreign Key needed by Data Manager */
	protected $person_id;
	
	/** @var [INTEGER] Foreign Key needed by Data Manager */
	protected $staffscheduletype_id;	
	
	/** @var [INTEGER] Foreign Key needed by Data Manager */
	protected $staffschedule_id;		
	
	
	/** @var [ARRAY] array mapping form labels to fieldvalues_ids*/
	protected $formFieldToValueIDmapper;
	protected $footerFieldToValueIDmapper;
	
	/** @var [ARRAY] array mapping form labels to field_ids*/
	protected $formFieldToFieldIDmapper;
	protected $footerFieldToFieldIDmapper;		
	
	/** @var [ARRAY] array storing the form labels */
	protected $formLabels;
	
	/** @var [ARRAY] array storing the form field notes */
	protected $formNotes;	
	
	/** @var [ARRAY] array storing the list labels */
	protected $listLabels;	
	
    /** @var [STRING] The actual name for the HRDB form. */
	protected $form_name;
	
	/** @var [BOOLEAN] whether or not to disable heading (i.e. for use as a sub-page) */
	protected $disable_heading;
	
	/** @var [BOOLEAN] whether or not to disable form (i.e. for use as a sub-page) */
	protected $disable_form;
		
	/** @var [BOOLEAN] whether or not the page must create new fieldvalues record(s) */
	protected $isNewRecordCreator;	
	
	/** @var [BOOLEAN] whether or not to show hidden fields */
	protected $show_hidden;		
	
	/** @var [INTEGER] The total # of standard fields in top form */
	protected $total_nonrepeatable_fields;
	
	
// 	 public $TEST_MSG;

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
	 * @param $fieldvalues_id [INTEGER] Value used to initialize the dataManager
	 * @param $fields_id [INTEGER] The foreign key data for the data Manager
	 * @return [void]
	 */
    function __construct($pathModuleRoot, $viewer, $formAction, $person_id = '', $staffscheduletype_id = '', $fieldvalues_id ='', $fields_id='', $disableHeading = false, $showHidden = true, $staffschedule_id = '', $disableForm = false) 	//$sortBy, 
    {
	   
	     $this->disable_heading = $disableHeading;
	     $this->disable_form = $disableForm;
	     $this->show_hidden = $showHidden;		// set to FALSE when in sign-up process
        // NOTE: be sure to call the parent constructor before trying to 
        //       use the ->formXXX arrays...

		  // store field values in field list; NOTE: probably don't need this now that we are generating custom labels...
		  $fieldList = $this->getFieldList($person_id, $staffscheduletype_id); //FormProcessor_EditStaffScheduleForm::FORM_FIELDS; ;
// 		  $this->total_nonrepeatable_fields = count(explode(',', $fieldList)) - 1;   // subtract 1 because of special hidden field
// 		  $footerFieldList = $this->getFooterFieldList($person_id, $staffscheduletype_id);
        
		  // store field display types
        $fieldTypes = $this->getFormFieldTypes($person_id, $staffscheduletype_id);	//FormProcessor_EditStaffScheduleForm::FORM_FIELD_TYPES;
        $footerFieldTypes = $this->getFooterFormFieldTypes($person_id, $staffscheduletype_id);
        $displayFields = $this->getDisplayFields($person_id, $staffscheduletype_id);	//FormProcessor_EditStaffScheduleForm::DISPLAY_FIELDS;
        //parent::__construct( $formAction, $fieldList, $fieldDisplayTypes  );  
        parent::__construct($formAction, $fieldList, $fieldTypes);    //$viewer,  $sortBy, $displayFields, $footerFieldList, $footerFieldTypes 
        
        
        
        $this->pathModuleRoot = $pathModuleRoot;
//         $this->sortBy = $sortBy;
        $this->viewer = $viewer;
        $this->formFieldToValueIDmapper = array();	// mapping is setup later in getFieldValuesArray()
        $this->formFieldToFieldIDmapper = array();	// mapping is setup later in getFieldsArray()
        $this->formLabels = array();
        $this->formLabels = $this->getFieldLabels($person_id, $staffscheduletype_id);
        $this->listLabels = $this->getListLabels($person_id, $staffscheduletype_id);
        

        $this->fieldvalues_id = $fieldvalues_id;
        $this->fields_id = $fields_id;
        
        $this->person_id = $person_id;
        $this->staffscheduletype_id = $staffscheduletype_id;
        $this->staffschedule_id = $staffschedule_id;
        
        // Get person and form type IDs from form instance ID, if applicable
        if (($this->staffschedule_id != ''))		//(($this->person_id == '')||($this->staffscheduletype_id == '')) && 
        {
	        $formInstance = new RowManager_StaffScheduleManager($this->staffschedule_id);
	        $this->person_id = $formInstance->getPersonID();
	        $this->staffscheduletype_id = $formInstance->getFormID();
	        
// 	        echo 'person_id = '.$this->person_id.'  and   form type id = '.$this->staffscheduletype_id;
        }
        
        // Get the real form name
        if ($this->staffscheduletype_id != '')
        {
	        $formContext = new RowManager_StaffScheduleTypeManager($this->staffscheduletype_id);
        	  $this->form_name = $formContext->getFormName();
     	  }
     	  else {
	     	  $this->form_name = '';
     	  }
        
//        echo "PersonID = ".$person_id;
// 		 echo "EventID = ".$event_id;
// 			echo "Registration ID = ".$registration_id;
        
        // figure out the important fields for the dataManager
 //      $fieldsOfInterest = implode(',', $this->formFields);
 
 			$this->dataManager = new RowManager_FormFieldValueManager( $fieldvalues_id );
//        $this->dataManager->setFieldsOfInterest( $fieldsOfInterest );

		  $mainFormValues = $this->getFieldValuesArray( $this->person_id, $this->staffscheduletype_id); //$this->dataManager->getArrayOfValues();
// 		  $footerFormValues = $this->getFooterFieldValuesArray( $person_id, $staffscheduletype_id); //$this->dataManager->getArrayOfValues();		  
	     $this->formValues = $mainFormValues;	//array_merge($mainFormValues, $footerFormValues);
//  		  echo 'initial db form values = <pre>'.print_r($this->formValues,true).'</pre>';
	     
        // if the database contains no values then flag for new record creation (assumes not all values can be empty strings)
        if (count($this->formValues) == 0)
        {
	        $this->isNewRecordCreator = true;			// NEVER SET!!
        }  
        else 
        {
	        $this->isNewRecordCreator = false;
        } 	        
                
        // now initialize the labels for this page
        // start by loading the default field labels for this Module
        $languageID = $viewer->getLanguageID();
        $seriesKey = modulecim_hrdb::MULTILINGUAL_SERIES_KEY;
        $pageKey = modulecim_hrdb::MULTILINGUAL_PAGE_FIELDS;
        $this->labels = new MultilingualManager( $languageID, $seriesKey, $pageKey );
        
        // then load the page specific labels for this page
        $pageKey = FormProcessor_EditStaffScheduleForm::MULTILINGUAL_PAGE_KEY;
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
//            $this->formValues[ 'fieldvalues_id' ] = $this->fieldvalues_id;
//            $this->formValues[ 'registration_id' ] = $this->registration_id;
        /*[RAD_ADMINBOX_FOREIGNKEY]*/
             
        
		   $formValues = array();
			$fieldValues = array();
			// get field value records
//			$fieldValues = $this->getFieldValuesArray( $this->registration_id, $this->person_id, $this->event_id, true );
			$fieldValues = $this->formValues;			
//  			echo "field values:<br><pre>".print_r($fieldValues,true)."</pre>";
//  			echo 'field to value id mapper:<br><pre>'.print_r($this->formFieldToValueIDmapper,true).'</pre>';

			$fields = new RowManager_FormFieldManager();
			$fields->setFormID($this->staffscheduletype_id);
			$fieldsList = $fields->getListIterator();
			$fieldsArray = $fieldsList->getDataList();
			$all_field_ids = array_keys($fieldsArray);
			$field_ids_list = array();		// use to store field ids that already have values
			$idx = 0;
			
			reset($fieldValues);
			$keys = array_keys($fieldValues);	// get field value ids, since array indexed using them
			foreach ($keys as $formLabel)
			//for ($idx = 0; $idx < count($fieldValueIDs); $idx++)
			{
								
				$fieldValueID = -1;
				if ( isset($this->formFieldToValueIDmapper[$formLabel])) 
				{
					// get fieldvalues_id mapped to formlabel
					$fieldValueID = $this->formFieldToValueIDmapper[$formLabel];
					$formValues['fieldvalues_id' ] = $fieldValueID;
					$formValues['fieldvalues_value' ] = $fieldValues[$formLabel];
					$formValues[ 'person_id' ] = $this->person_id;
					$formValues[ 'fieldvalues_modTime' ] = strftime("%Y-%m-%d %H:%M:%S",time());		// == CURRENT_TIME
// 					echo "FORM values:<br><pre>".print_r($formValues,true)."</pre>";
				
		        $this->dataManager = new RowManager_FormFieldValueManager( $fieldValueID );	//$fieldValueIDs[$idx]
		        $fieldsOfInterest = FormProcessor_EditStaffScheduleForm::FORM_FIELDS;
	           $this->dataManager->setFieldsOfInterest( $fieldsOfInterest );
				  
				  $this->dataManager->loadFromArray( $formValues );		// load field value into appropriate row in DB
// 				  echo 'field value id = '.$fieldValueID.' for '.$fieldValues[$formLabel].'<BR>';
				  
					// standard code for adding/updating but nested to accomodate updating multiple fieldvalues rows
		        if (!$this->dataManager->isLoaded()) {
		            $this->dataManager->createNewEntry();	
		            //echo "ADDED";
		        } else {
		            $this->dataManager->updateDBTable();	
		            //echo "UPDATED";
		        }			  
			  }
			  else if ($this->isNewRecordCreator == true)	// if no fieldvalues records could be found, create new one
			  {
// 				   echo "field mapper = <pre>".print_r($this->formFieldToValueIDmapper,true)."</pre>";
				  
				   // must ensure that a fieldID exists
				   if (isset($this->formFieldToFieldIDmapper[$formLabel]))
				   {

						// get fields_id mapped to formlabel
						$fieldID = $this->formFieldToFieldIDmapper[$formLabel];
						$field_ids_list[$idx++] = $fieldID;
						
						$formValues['fields_id' ] = $fieldID;					   
						$formValues['fieldvalues_value' ] = $fieldValues[$formLabel];
						$formValues[ 'person_id' ] = $this->person_id;	
						$formValues[ 'fieldvalues_modTime' ] = strftime("%Y-%m-%d %H:%M:%S",time());		// == CURRENT_TIME
//						echo "ADD FORM values:<br><pre>".print_r($formValues,true)."</pre>";
						
			        $this->dataManager = new RowManager_FormFieldValueManager();	//$fieldValueIDs[$idx]
//			        $fieldsOfInterest = FormProcessor_EditStaffScheduleForm::FORM_FIELDS;
//		           $this->dataManager->setFieldsOfInterest( $fieldsOfInterest );
					  
					  $this->dataManager->loadFromArray( $formValues );		// load field value into appropriate row in DB
	//				  echo 'field value id = '.$fieldValueID.' for '.$fieldValues[$formLabel].'<BR>';
					  
						// standard code for adding/updating but nested to accomodate updating multiple fieldvalues rows
			        if (!$this->dataManager->isLoaded()) {
			            $this->dataManager->createNewEntry();	
// 			            echo "ADDED";
			        } else {
			            $this->dataManager->updateDBTable();	
// 			            echo "UPDATED";
			        }
		        }
        
	        }				
		  }
		  
		  /*** Add empty field values for event fields not shown to the user (i.e. hidden fields) **/
		  /** NOTE: only required for first time registration field values are stored **/
		  if ($this->isNewRecordCreator == true)	// NOTE: creation of new empty records now done in getFieldValuesArray()
		  {
  
			  // Find which ids in the set of all fields do NOT appear the set of fields with values
			  $missing_values = array_diff($all_field_ids, $field_ids_list);
	// 		  echo 'missing fields = <pre>'.print_r($missing_values,true).'</pre>';
			  
			  reset($missing_values);
			  $newValues = array();
			  foreach (array_keys($missing_values) as $key)
			  {
				  $fieldID = current($missing_values);
				  
				  $newValues['fields_id' ] = $fieldID;					   
				  $newValues['fieldvalues_value' ] = '';
				  $newValues[ 'person_id' ] = $this->person_id;	
					$formValues[ 'fieldvalues_modTime' ] = strftime("%Y-%m-%d %H:%M:%S",time());		// == CURRENT_TIME
				  
		        $this->dataManager = new RowManager_FormFieldValueManager();	//$fieldValueIDs[$idx]
				  
				  $this->dataManager->loadFromArray( $newValues );		// load field value into appropriate row in DB
	//				  echo 'field value id = '.$fieldValueID.' for '.$fieldValues[$formLabel].'<BR>';
				  
					// standard code for adding/updating but nested to accomodate updating multiple fieldvalues rows
		        if (!$this->dataManager->isLoaded()) {
		            $this->dataManager->createNewEntry();	
	// 			            echo "ADDED";
		        } else {
		            $this->dataManager->updateDBTable();	
	// 			            echo "UPDATED";
		        }
		        next($missing_values);			
	        }
        }
		     
     		// Ensure that a form instance is created for the staff person
        $scheduleFormManager = new RowManager_StaffScheduleManager();
        $scheduleFormManager->setPersonID($this->person_id);
        $scheduleFormManager->setFormID($this->staffscheduletype_id);
        
        $formList = $scheduleFormManager->getListIterator();
        $formArray = $formList->getDataList();
        
        $personal_form_id = '';
        if (count($formArray) > 0)
        {
	        $row = current($formArray);	// pick first record for grabbing form ID 
	        $personal_form_id = $row['staffschedule_id'];
        }	
        
         // Create new form instance record if none exists
         if ($personal_form_id == '')
         {
         	$scheduleFormManager->createNewEntry();
         	$personal_form_id = $scheduleFormManager->getID();
      	}	 
      	
      	return $personal_form_id;   
	 			       
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
        $path = $this->pathModuleRoot.'templates/';
        // Otherwise use the standard Templates for the site:
//         $path = SITE_PATH_TEMPLATES;
        
        // store the link labels
        $this->linkLabels[ 'edit' ] = $this->labels->getLabel( '[Edit]' );
        $this->linkLabels[ 'del'  ] = $this->labels->getLabel( '[Delete]' );
        $this->linkLabels[ 'cont' ] = $this->labels->getLabel( '[Continue]');
        // $this->linkLabels[ 'view' ] = 'new link label here';
                
        
        // store the page labels in XML format...
        // NOTE: use this location to update any label tags ...
        // $name = $user->getName();
        //$this->labels->setLabelTag( '[Title]', '[userName]', $name);
        
		/*    $labelManager = new  MultilingualManager();
		    $labelManager->addSeries( modulecim_reg::MULTILINGUAL_SERIES_KEY );
		    
		    
		    
		    // Create General Field labels for modulecim_reg 
		    $labelManager->addPage( modulecim_reg::MULTILINGUAL_PAGE_FIELDS );
			 $labelManager->addPage( modulecim_reg::PAGE_EDITFIELDVALUES );
		    
		    //
		    // Event table
		    //
			$labelManager->addLabel( "[title_event_deposit]", "Deposit", "en" );        
		
		*/        
		
        
        // NOTE:  this parent method prepares the $this->template with the 
        // common Form data.  
        $this->prepareTemplate( $path );
        
        
		  $this->formValues['form_name'] = 'basicStaffForm';
        
        // store all the fields to the template
        $this->setFormFieldsToTemplate(); 
               
                
        $this->template->set( 'formLabels', $this->formLabels );  
        $this->template->set( 'listLabels', $this->listLabels );                      

        /*
         * Form related Template variables:
         */
         
        // Disable form?
        if ($this->disable_form == true)
        {
	        $this->template->set( 'disableForm', $this->disable_form);
        }
        
        // store the button label
        $this->template->set( 'buttonText', $this->labels->getLabel('[Update]') );
        
        /** UGLY HACK: TO FIX WITH A BETTER SOLUTION **/
//         if ($this->formLabels['formLabel_0'] == '# of Years on Staff')
//         {
// 	        $notice = "(As of August this year.)";
// 	        $this->template->set( 'note_form_field0', $notice);   
//         }

        /** Add notes beside form fields that have them **/
        $f_idx = 0;
        reset($this->formNotes);
        foreach (array_keys($this->formNotes) as $field_key)
        {
	        $notice = current($this->formNotes);
	        
	        $this->template->set( $field_key, $notice);  
	        next($this->formNotes);
	        $f_idx++;
        }
        


        // Insert the date start/end values for the following date fields:
        // example:
            //$this->template->set( 'startYear_[fieldName]', 2000);
            //$this->template->set( 'endYear_[fieldName]', 2010);

     
     if ($this->form_name != '')
     {           
		  $this->template->set('formName', $this->form_name);
	  }
	  
	  
        /*
         * List related Template variables :
         */
                 // store the statevar id to edit
        $this->template->set( 'editEntryID', $this->fieldvalues_id );
        
        // store the primary key field name for the data being displayed
        $this->template->set( 'primaryKeyFieldName', 'fieldvalues_id');
        
        // store data list to the template
        // NOTE: we initialize it here to make sure we capture any new data 
        // from a recent processData() call.
        $fieldValueManager = new RowManager_FormFieldValueManager();
        $fieldValueManager->setPersonID( $this->person_id);
        $fieldManager = new RowManager_FormFieldManager();
//         $fieldManager->constructSearchCondition( 'fieldgroup_id', '!=', '0', true );
        
        $fieldListRow = new MultiTableManager();
        $fieldListRow->addRowManager($fieldValueManager);
		  $fieldListRow->addRowManager($fieldManager, new JoinPair($fieldValueManager->getJoinOnFieldID(), $fieldManager->getJoinOnFieldID()));  
		  $fieldListRow->addSearchCondition('cim_hrdb_fields.fieldgroup_id != 0');
        $fieldListRow->setSortOrder( 'fieldgroup_id,fieldvalues_id' );
        $this->dataList = $fieldListRow->getListIterator();
        
        $test_array = $this->dataList->getDataList();
//         echo 'repeat fields = <pre>'.print_r($test_array,true).'</pre>';
        
        // Store the XML Node name for the Data Access Field List
        $xmlNodeName = $this->dataList->getRowManagerXMLNodeName();
        $this->template->set( 'rowManagerXMLNodeName', $xmlNodeName);       
//         $xmlNodeName = RowManager_FormFieldValueManager::XML_NODE_NAME;
//         $this->template->set( 'rowManagerXMLNodeName', $xmlNodeName);
        $this->template->setXML( 'dataList', $this->dataList->getXML() );	   


        /*
         * Add any additional data required by the template here
         */
     if ($this->disable_heading == true)
     {
	     $this->template->set( 'disableHeading', true ); 
	     
     }   
     
     $this->template->set( 'formAnchor', 'FormFieldValuesForm');
     $this->template->set( 'disableHeading', $this->disable_heading );   

		// uncomment this line if you are creating a template for this page
		$templateName = 'page_EditBasicStaffForm.tpl.php';
		// otherwise use the generic admin box template
// 		$templateName = 'siteFormSingle_dynamic.php';
		
		return $this->template->fetch( $templateName );
        
    }

    
    
    
 /*** HELPER METHODS ***/   
     
    
	// get custom labels for form based on stored event-specific form field descriptions    
   protected function getFieldLabels($personID='',$formID='',$isRepeatable=false) 	// switch between showing repeatable fields or not
	{    
		$labelsArray = array();
         
      $valuesArray = $this->getFieldArray($personID,$formID,$isRepeatable);	//$valuesIterator->getDataList();	
       
       // go through results and store field descriptions as the form field labels
      $idx = 0;
      reset($valuesArray);
		foreach(array_keys($valuesArray) as $k)
		{
		   $fieldValue = current($valuesArray);
		   
//		   $fieldList .= 'form_field'.$idx.'|'.$this->getFieldType($fieldValue['fieldtypes_desc']).'|,';		//$fieldValue['fields_desc']
		   $labelsArray['formLabel_'.$idx] = $fieldValue['fields_desc'];
		
		   $idx++;
			next($valuesArray);
		}	
		
		return $labelsArray;	// return array of form field labels generated from event-specific fields
	}     
	
	
	// get custom labels for footer list-form based on stored  form field descriptions    
   protected function getListLabels($personID='',$formID='') 	//,$isRepeatable=false   switch between showing repeatable fields or not
	{    
		$labelsArray = array();
         
		$isRepeatable = true;
      $valuesArray = $this->getFieldArray($personID,$formID,$isRepeatable);	//$valuesIterator->getDataList();	
       
       // go through results and store field descriptions as the form field labels
      $idx = 0;				//$this->total_nonrepeatable_fields   NOTE: this counter reset is very particular to this split-form page
      reset($valuesArray);
		foreach(array_keys($valuesArray) as $k)
		{
		   $fieldValue = current($valuesArray);
		   
//		   $fieldList .= 'form_field'.$idx.'|'.$this->getFieldType($fieldValue['fieldtypes_desc']).'|,';		//$fieldValue['fields_desc']
		   $labelsArray['title_list_field'.$idx] = $fieldValue['fields_desc'];
		
		   $idx++;
			next($valuesArray);
		}	
		
		return $labelsArray;	// return array of form field labels generated from event-specific fields
	} 	  
        
        
        
    
    	// returns an array of registration-specific form field values (for event-specific form fields)
    	// e.g. 'fields_id|N|,fieldvalues_value|T|,person_id|T|<skip>'  -- although <skip> is not implemented
	protected function getFieldList($personID='',$formID='',$isRepeatable=false) 	// switch between showing repeatable fields or not
	{
		 $TRUE = 0;
		 $FALSE = 1;
		 $skip = '';
		 
		 $fieldList = '';
/*		 $fields = new RowManager_FieldsManager();
		 $fvalues = new RowManager_FieldValueManager();
		 $ftypes = new RowManager_FieldTypeManager();
		 
		 if ($regID == '') 
		 {
		 		$fvalues->setRegID($regID);
	    }
//	    $fvalues->setSortByFieldID();

		 $fieldInfo = new MultiTableManager();
		 $fieldInfo->addRowManager($fields);
		 $fieldInfo->addRowManager($fvalues, new JoinType($fvalues->getJoinOnFieldID(), $fields->getJoinOnFieldID()));
		 $fieldInfo->addRowManager($ftypes, new JoinType($fields->getJoinOnFieldTypeID(), $ftypes->getJoinOnFieldTypeID()));
		 

       $valuesIterator = $fieldInfo->getListIterator();  */
       $valuesArray = $this->getFieldArray($personID,$formID,$isRepeatable);	//$valuesIterator->getDataList();	
       
       // go through results and store field descriptions as the form field labels
       $idx = 0;
       reset($valuesArray);
		foreach(array_keys($valuesArray) as $k)
		{
		   $fieldValue = current($valuesArray);
		   
		   // determine whether or not the field is required
		   if ($fieldValue['fields_reqd'] == $TRUE)
		   {
			   $skip = '<skip>';
		   }
		   else 
		   {
			   $skip = '';
		   }
		   
		   $fieldList .= 'form_field'.$idx.'|'.$this->getFieldType($fieldValue['fieldtypes_desc']).'|'.$skip.',';		//$fieldValue['fields_desc']
		
		   $idx++;
			next($valuesArray);
		}	
		
		$fieldList .= 'form_name|T|<skip>';	//substr($fieldList,0,-1);	// remove final comma
				
		return $fieldList;	// return list of form fields generated from event-specific fields
    }
    
        
    // return array of database records from field tables: cim_reg_fields, cim_reg_fieldtypes
    protected function getFieldArray($personID='',$formID='',$isRepeatable=false) 	// switch between showing repeatable fields or not
 	 {
	 	 $FALSE = 0;
	 	 
		 $fields = new RowManager_FormFieldManager();
//		 $fvalues = new RowManager_FieldValueManager();
		 $ftypes = new RowManager_FieldTypeManager();
		 
// 		 echo "personID = ".$personID;
// 		 echo "eventID = ".$eventID;
		 
		 if ($formID != '') 
		 {
			 	$fields->setFormID($formID);
		 		//$fvalues->setRegID($regID);
	    }
// 		 else if ($personID != '')
// 	    {
// 		    $persons = new RowManager_PersonManager();
// 		    $persons->setPersonID($personID);
// //		    $person = new RowManager_PersonManager();
// //		    $person->setPersonID($personID);
// 		    $form = new RowManager_StaffScheduleTypeManager();
// //		    $event->setEventID($eventID);
// 		    $personForm = new MultiTableManager();
// 		    $personForm->addRowManager($persons);
// //		    $personReg->addRowManager($person, new JoinPair($registrations->getJoinOnPersonID(), $person->getJoinOnPersonID()));
// 		    $personForm->addRowManager($form, new JoinPair($registrations->getJoinOnEventID(), $event->getJoinOnEventID()));
// 		    
//        	 $valIterator = $personReg->getListIterator(); 
//        	 $valArray = $valIterator->getDataList();		
//        	 
// 	       // go through results and store field types
// 	       reset($valArray);
// 			foreach(array_keys($valArray) as $k)
// 			{
// 			   $regValue = current($valArray);
// 			   
// 			   $eventID = $regValue['event_id'];		//NOTE: assumes only 1 event per registration       //OLD: registration per person per event
// 			
// 				next($valArray);
// 			}	     
// 			$fields->setEventID($eventID);
// //			$fvalues->setRegID($regID);  	 	    
// 	    }
		    
//	    $fvalues->setSortByFieldID();

		 $fieldInfo = new MultiTableManager();
		 $fieldInfo->addRowManager($fields);
//		 $fieldInfo->addRowManager($fvalues, new JoinPair($fvalues->getJoinOnFieldID(), $fields->getJoinOnFieldID()));
		 $fieldInfo->addRowManager($ftypes, new JoinPair($fields->getJoinOnFieldTypeID(), $ftypes->getJoinOnFieldTypeID()));
		 if ($this->show_hidden == false) {
        		$fieldInfo->constructSearchCondition( 'fields_hidden', '=', $FALSE, true );
     	  }
     	  
     	  // filter out repeatable fields if flag set to FALSE
     	  if ($isRepeatable == false)
     	  {
        		$fieldInfo->constructSearchCondition( 'fieldgroup_id', '=', '0', true );
     	  }	     	  
     	  else 
     	  {
        		$fieldInfo->constructSearchCondition( 'fieldgroup_id', '!=', '0', true );
     	  }	     	  

		 $fieldInfo->setSortOrder('fields_priority');
// 		 echo $fieldInfo->createSQL();
		 
       $valuesIterator = $fieldInfo->getListIterator(); 
       $valuesArray = $valuesIterator->getDataList();	
       
//		 echo "label values:<br><pre>".print_r($valuesArray,true)."</pre>";

       // map the fields_id of each field values row to the label of that particular form field
        $idx = 0;
        reset($valuesArray);
        	foreach(array_keys($valuesArray) as $k)
			{
				$record = current($valuesArray);				
				
				// store mapping associating form field label with fields_id
				if ($isRepeatable == false)
				{
					$this->formFieldToFieldIDmapper['form_field'.$idx] = $record['fields_id'];
				}
				else {
					$this->footerFieldToFieldIDmapper['form_field'.$idx] = $record['fields_id'];
				}				
				
				$this->formNotes['note_form_field'.$idx] = $record['fields_note']; // grab note for beside form field
				
				next($valuesArray);
				$idx++;
			} 

//  		 echo "field id values:<br><pre>".print_r($this->formFieldToFieldIDmapper,true)."</pre>";

					
       return $valuesArray;       
	}	
	

    // return array of database records from field tables: cim_hrdb_fields, cim_reg_fieldtypes, cim_hrdb_fieldvalues
    // @param  [BOOLEAN] $isIndexedByValueID		whether or not the output array is indexed by template labels or by fieldvalue_id
    protected function getFieldValuesArray($personID='',$formID='',$isRepeatable=false) 	// switch between showing repeatable fields or not
 	 {
	 	 $FALSE = 0;
	 	 
		 $fields = new RowManager_FormFieldManager();
// 		 $fields->setFieldGroupID(FormProcessor_EditStaffScheduleForm::NO_FIELDGROUP_ID);	// HSMIT added 
		 $fvalues = new RowManager_FormFieldValueManager();
		 $ftypes = new RowManager_FieldTypeManager();
		 
// 		 echo "personID = ".$personID;
// 		 echo "eventID = ".$eventID;
		 
		 if ($personID != '') 
		 {
			 	//$fields->setEventID($eventID);
		 		$fvalues->setPersonID($personID);
	    }

	    if ($formID != '')
	    {
		    $fields->setFormID($formID);
	    }
		    
//	    $fvalues->setSortByFieldID();


		 $fieldInfo = new MultiTableManager();
		 $fieldInfo->addRowManager($fields);
		 $fieldInfo->addRowManager($fvalues, new JoinPair($fvalues->getJoinOnFieldID(), $fields->getJoinOnFieldID()));
		 $fieldInfo->addRowManager($ftypes, new JoinPair($fields->getJoinOnFieldTypeID(), $ftypes->getJoinOnFieldTypeID()));
		 
		 if ($this->show_hidden == false) {
        		$fieldInfo->constructSearchCondition( 'fields_hidden', '=', $FALSE, true );
     	  }
     	  
     	  // filter out repeatable fields if flag set to FALSE
     	  if ($isRepeatable == false)
     	  {
//         		$fieldInfo->constructSearchCondition( 'fieldgroup_id', '=', '0', true );
        		$fieldInfo->addSearchCondition( 'fieldgroup_id = 0' );
     	  }	     	  
     	  else 
     	  {
//         		$fieldInfo->constructSearchCondition( 'fieldgroup_id', '!=', '0', true );
        		$fieldInfo->addSearchCondition( 'fieldgroup_id != 0' );
     	  }	
		 
		 $fieldInfo->setSortOrder('fields_priority');

       $valuesIterator = $fieldInfo->getListIterator(); 
       $valuesArray = $valuesIterator->getDataList();	
       
//         echo "pre field values:<br><pre>".print_r($valuesArray,true)."</pre>";
             
       // store field ids associated with values already in database
       $initializedFieldIds = array_keys($valuesArray);
     
       // since each field value is located in a DB row the result array has several arrays - one per field value
       // need to extract each field value and store it as a non-array record in a result array
        $fieldValues = array();
        $idx = 0;
        
        /** Go through all event fields and map each to existing field value, otherwise create new field value record **/		
        $fieldsArray = array_values($this->formFieldToFieldIDmapper);	// store field IDs (ASSUMES formFieldToFieldIDmapper is initialized) 
//         echo 'fieldsArray = <pre>'.print_r($fieldsArray,true).'</pre>';             
        reset($fieldsArray);
        reset($valuesArray);
        	foreach(array_keys($fieldsArray) as $k)
			{
				$fieldID = current($fieldsArray);
				$form_value = '';		// default blank field value if none found
				$form_value_id = -1;		// to be replaced with existing or newly-created field values ID
						 
				if (in_array($fieldID, $initializedFieldIds)==true)	// check if field has value already
				{
					$record = $valuesArray[$fieldID];
					$form_value = $record['fieldvalues_value']; 
					$form_value_id = 	$record['fieldvalues_id']; 
				}	
				else		// create a new field values record
				{
					$updateValues = array();
					$updateValues['fields_id'] = $fieldID;
					$updateValues['fieldvalues_value'] = $form_value;
					$updateValues['person_id'] = $personID;
					
					$fieldvalues_manager = new RowManager_FormFieldValueManager();
					
		        // store values in table manager object.
		        $fieldvalues_manager->loadFromArray( $updateValues );
		        
		        $fieldvalues_list = $fieldvalues_manager->getListIterator();
		        $fieldvalues_array = $fieldvalues_list->getDataList();
		        
		        // now update the DB with the values
		        if (count($fieldvalues_array) < 1) {		//(!$fieldvalues_manager->isLoaded()) {
// 			        echo "new entry ".$fieldID.", ".$personID;
		            $fieldvalues_manager->createNewEntry();
		            $form_value_id = $fieldvalues_manager->getID();
	            }	
            }			
				$fieldValues['form_field'.$idx] = $form_value;					
				
				// store mapping associating form field label with fieldvalues_id
				$this->formFieldToValueIDmapper['form_field'.$idx] = $form_value_id;
				
				next($fieldsArray);
				$idx++;
			}     
			
// 			echo 'labels-values = <pre>'.print_r($this->formFieldToValueIDmapper,true).'</pre>';
// 			echo 'labels-fields = <pre>'.print_r($this->formFieldToFieldIDmapper,true).'</pre>'; 
       
		
       return $fieldValues;       
	}	
	
	
    // return array of database records from field tables: cim_hrdb_fields, cim_reg_fieldtypes, cim_hrdb_fieldvalues
    protected function getFooterFieldValuesArray($personID='',$formID='',$isRepeatable=true) 	// switch between showing repeatable fields or not
 	 {
	 	 $FALSE = 0;
	 	 
		 $fields = new RowManager_FormFieldManager();
		 $fields->setFieldGroupID(FormProcessor_EditStaffScheduleForm::NO_FIELDGROUP_ID);	// HSMIT added 
		 $fvalues = new RowManager_FormFieldValueManager();
		 $ftypes = new RowManager_FieldTypeManager();

		 
		 if ($personID != '') 
		 {
			 	//$fields->setFormID($formID);
		 		$fvalues->setPersonID($personID);
	    }



		 $fieldInfo = new MultiTableManager();
		 $fieldInfo->addRowManager($fields);
		 $fieldInfo->addRowManager($fvalues, new JoinPair($fvalues->getJoinOnFieldID(), $fields->getJoinOnFieldID()));
		 $fieldInfo->addRowManager($ftypes, new JoinPair($fields->getJoinOnFieldTypeID(), $ftypes->getJoinOnFieldTypeID()));
		 
		 if ($this->show_hidden == false) {
        		$fieldInfo->constructSearchCondition( 'fields_hidden', '=', $FALSE, true );
     	  }
     	  
     	  // filter out repeatable fields if flag set to FALSE
     	  if ($isRepeatable == false)
     	  {
        		$fieldInfo->constructSearchCondition( 'fieldgroup_id', '=', '0', true );
     	  }	     	  
     	  else 
     	  {
        		$fieldInfo->constructSearchCondition( 'fieldgroup_id', '!=', '0', true );
     	  }	
		 
		 $fieldInfo->setSortOrder('fields_priority');

       $valuesIterator = $fieldInfo->getListIterator(); 
       $valuesArray = $valuesIterator->getDataList();	
       
//        echo "field values:<br><pre>".print_r($valuesArray,true)."</pre>";
             
       // store field ids associated with values already in database
       $initializedFieldIds = array_keys($valuesArray);
     
       // since each field value is located in a DB row the result array has several arrays - one per field value
       // need to extract each field value and store it as a non-array record in a result array
        $fieldValues = array();
        $idx = $this->total_nonrepeatable_fields;			// initialize counter to first available form ID (some used already)
        
        /** Go through all event fields and map each to existing field value, otherwise create new field value record **/		
        $fieldsArray = array_values($this->footerFieldToFieldIDmapper);	// store field IDs (ASSUMES formFieldToFieldIDmapper is initialized) 
//         echo 'fieldsArray = <pre>'.print_r($fieldsArray,true).'</pre>';             
        reset($fieldsArray);
        reset($valuesArray);
        	foreach(array_keys($fieldsArray) as $k)
			{
				$fieldID = current($fieldsArray);
				$form_value = '';		// default blank field value if none found
				$form_value_id = -1;		// to be replaced with existing or newly-created field values ID
						 
				if (in_array($fieldID, $initializedFieldIds)==true)	// check if field has value already
				{     
					$record = $valuesArray[$fieldID];
					$form_value = $record['fieldvalues_value']; 
					$form_value_id = 	$record['fieldvalues_id']; 
				}	
				else		// create a new field values record
				{
					$updateValues = array();
					$updateValues['fields_id'] = $fieldID;
					$updateValues['fieldvalues_value'] = $form_value;
					$updateValues['person_id'] = $personID;
					
					$fieldvalues_manager = new RowManager_FormFieldValueManager();
					
		        // store values in table manager object.
		        $fieldvalues_manager->loadFromArray( $updateValues );
		        
		        // now update the DB with the values
		        if (!$fieldvalues_manager->isLoaded()) {
// 			        echo "new entry ".$fieldID.", ".$personID;
		            $fieldvalues_manager->createNewEntry();
		            $form_value_id = $fieldvalues_manager->getID();
	            }	
            }			
				$fieldValues['form_field'.$idx] = $form_value;					
				
				// store mapping associating form field label with fieldvalues_id
				$this->footerFieldToValueIDmapper['form_field'.$idx] = $form_value_id;
				
				next($fieldsArray);
				$idx++;
			}     
			
// 			echo 'labels-values = <pre>'.print_r($this->formFieldToValueIDmapper,true).'</pre>';
// 			echo 'labels-fields = <pre>'.print_r($this->formFieldToFieldIDmapper,true).'</pre>'; 
       
		
       return $fieldValues;       
	}	
	
			 	 
    
  	 /** Retrieve the list of field types to be displayed in the form */
	// NOTE: if a field isn't displayed, put a '-' for it's entry. -- NOT IMPLEMENTED YET
	//  e.g. 'textbox,textarea,checkbox,droplist,-';   -- droplist also not implemented (in DB) 
    protected function getFormFieldTypes($personID='',$formID='',$isRepeatable=false) 	// switch between showing repeatable fields or not
    {
	    $fieldTypes = '';
	    
	    $typesArray = $this->getFieldArray($personID,$formID,$isRepeatable);
	    
       // go through results and store field types
       reset($typesArray);
		foreach(array_keys($typesArray) as $k)
		{
		   $fieldValue = current($typesArray);
		   
		   $fieldType = $fieldValue['fieldtypes_desc'];
		   if ($fieldType == 'textarea')
		   {
			   $fieldType = 'textarea|30|3';
		   }
		   $fieldTypes .= $fieldType.',';
		
			next($typesArray);
		}	
		
		$fieldTypes .= 'hidden';	//substr($fieldTypes,0,-1);	// remove final comma
		
		return $fieldTypes;	// return list of form field types associated with event-specific fields
	}	    

    
    //             form_field_type = the type of form field
    //                               T = Text / String
    //                               N = Numeric 
    //                               B = Boolean
    //                               D = Date ( 3 lists boxes day/mon/year)
    //                            Time = Time ( 3 list boxes  HH/MM/Am )
    //                        DateTime = Date + Time pickers ...    
    // return template form field type given fieldtypes_desc from the database
    protected function getFieldType($fieldtypes_desc)
    {
	    $fieldType = '';
	    
	    switch ($fieldtypes_desc)
	    {
		    case 'checkbox':
		    	$fieldType = 'B';
		    	break;
		    case 'textbox':
		    	$fieldType = 'T';	// NOTE: 'N' for numeric is also possible but will be avoided
		    	break;
		    case 'textarea':
		    	$fieldType = 'T';
		    	break;
		    case 'password':
		    	$fieldType = 'T';
		    	break;
		    default:
		    	$fieldType = 'T';
		    	break;
		}
		
		return $fieldType;
	} 
	
			 		 	

	/**
	 * Function getDisplayFields
	 * The function used to get display fields, i.e. the repeatable fields shown in editable data list
	 * at the bottom of the page.
	 *
	 * @param [INTEGER]   $personID    the id of the person associated with the form
	 * @param [INTEGER]   $formID      the id specifying the form to be used
/////	 * @param [BOOLEAN]   $isRepeatable      whether to show repeatable fields or non-repeatable fields
	 *
	 * @return [ARRAY] an array containing the fields displayed in table below form (i.e. the repeatable form fields)
	 **/
	protected function getDisplayFields($personID='',$formID='') 	//,$isRepeatable=true  switch between showing repeatable fields or not
	{
		 $TRUE = 0;
		 $FALSE = 1;
		 $skip = '';
		 
		 $displayList = '';

       $isRepeatable = true;
       $valuesArray = $this->getFieldArray($personID,$formID,$isRepeatable);	//$valuesIterator->getDataList();	
       
//        echo 'values = <pre>'.print_r($valuesArray,true).'</pre>';
       
       // go through results and store field descriptions as the form field labels
       // start from the first available un-used index
       $idx = 0;	//$this->total_nonrepeatable_fields;
       reset($valuesArray);
		foreach(array_keys($valuesArray) as $k)
		{
		   $fieldValue = current($valuesArray);
		   
		   // determine whether or not the field is required
// 		   if ($fieldValue['fields_reqd'] == $TRUE)
// 		   {
// 			   $skip = '<skip>';
// 		   }
// 		   else 
// 		   {
// 			   $skip = '';
// 		   }
		   
		   $displayList .= 'list_field'.$idx.',';		//$fieldValue['fields_desc']
		
		   $idx++;
			next($valuesArray);
		}	
		if (count($valuesArray) > 0) {
			$displayList = substr($displayList,0,-1);
		}
// 		$displayList .= 'list_name';	//substr($fieldList,0,-1);	// remove final comma

				
		return $displayList;	// return list of form fields generated from event-specific fields
    }
    
    
    
    	// returns an array of footer form fields with values
    	// e.g. 'fields_id|N|,fieldvalues_value|T|,person_id|T|<skip>'  -- although <skip> is not implemented
	protected function getFooterFieldList($personID='',$formID='') 	//,$isRepeatable=false   switch between showing repeatable fields or not
	{
		 $TRUE = 0;
		 $FALSE = 1;
		 $skip = '';
		 
		 $fieldList = '';
		 $isRepeatable = true;
       
       $valuesArray = $this->getFieldArray($personID,$formID,$isRepeatable);	//$valuesIterator->getDataList();	
       
       // go through results and store field descriptions as the form field labels
       // start from the first available un-used index
       $idx = $this->total_nonrepeatable_fields;
       reset($valuesArray);
		foreach(array_keys($valuesArray) as $k)
		{
		   $fieldValue = current($valuesArray);
		   
		   // determine whether or not the field is required
		   if ($fieldValue['fields_reqd'] == $TRUE)
		   {
			   $skip = '<skip>';
		   }
		   else 
		   {
			   $skip = '';
		   }
		   
		   $fieldList .= 'form_field'.$idx.'|'.$this->getFieldType($fieldValue['fieldtypes_desc']).'|'.$skip.',';		//$fieldValue['fields_desc']
		
		   $idx++;
			next($valuesArray);
		}	
		
		$fieldList .= 'form_name|T|<skip>';	//substr($fieldList,0,-1);	// remove final comma
				
		return $fieldList;	// return list of form fields generated from event-specific fields
    }    
    
    
    /** Retrieve the list of field types to be displayed in the form */
	// NOTE: if a field isn't displayed, put a '-' for it's entry. -- NOT IMPLEMENTED YET
	//  e.g. 'textbox,textarea,checkbox,droplist,-';   -- droplist also not implemented (in DB) 
    protected function getFooterFormFieldTypes($personID='',$formID='') 	//,$isRepeatable=false   switch between showing repeatable fields or not
    {
	    $fieldTypes = '';
	    $isRepeatable = true;
	    
	    $typesArray = $this->getFieldArray($personID,$formID,$isRepeatable);
	    
       // go through results and store field types
       reset($typesArray);
		foreach(array_keys($typesArray) as $k)
		{
		   $fieldValue = current($typesArray);
		   
		   $fieldTypes .= $fieldValue['fieldtypes_desc'].',';
		
			next($typesArray);
		}	
		
		$fieldTypes .= 'hidden';	//substr($fieldTypes,0,-1);	// remove final comma
		
		return $fieldTypes;	// return list of form field types associated with event-specific fields
	}	  
}

?>
