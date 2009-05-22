<?php
/**
 * @package cim_reg
 */ 
/**
 * class FormProcessor_EditFieldValues   (THIS IS THE ONE THAT IS BEING USED IN REGISTRATION PROCESS)
 * <pre> 
 * This page is a rough template (to be modified) intended to support changing event-specific form field values for individual registrants.
 * </pre>
 * @author Russ Martin
 * Date:   24 Jul 2007
 */
 // RAD Tools: FormSingleEntry Page
class  FormProcessor_EditFieldValues extends PageDisplay_FormProcessor {

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
//    const FORM_FIELDS = 'fields_id|N|,fieldvalues_value|T|,registration_id|T|<skip>';
	 const FORM_FIELDS = 'fields_id,fieldvalues_value';
    
    /** The list of field types to be displayed in the form */
    // NOTE: if a field isn't displayed, put a '-' for it's entry.
//    const FORM_FIELD_TYPES = 'textbox,textarea,-';
    
    /** The Multilingual Page Key for this page */
    const MULTILINGUAL_PAGE_KEY = 'FormProcessor_EditFieldValues';

	//VARIABLES:
	
	/** @var [STRING] The path to the module's root directory. */
	protected $pathModuleRoot;
	
	/** @var [OBJECT] The Viewer Object. */
	protected $viewer;
		
    /** @var [STRING] The initialization data for the dataManager. */
	protected $fieldvalues_id;
	
	/** @var [INTEGER] Foreign Key needed by Data Manager */
	protected $fields_id;

	/** @var [INTEGER] Foreign Key needed by Data Manager */
	protected $registration_id;
	
	/** @var [INTEGER] Foreign Key needed by Data Manager */
	protected $person_id;
	
	/** @var [INTEGER] Foreign Key needed by Data Manager */
	protected $event_id;	
	
	
	/** @var [ARRAY] array mapping form labels to fieldvalues_ids*/
	protected $formFieldToValueIDmapper;
	
	/** @var [ARRAY] array mapping form labels to field_ids*/
	protected $formFieldToFieldIDmapper;		
	
	/** @var [ARRAY] array storing the form labels */
	protected $formLabels;
	
	/** @var [BOOLEAN] whether or not to disable heading (i.e. for use as a sub-page) */
	protected $disable_heading;
	
	/** @var [BOOLEAN] whether or not the page must create new fieldvalues record(s) */
	protected $isNewRecordCreator;	
	
	/** @var [BOOLEAN] whether or not to show hidden fields */
	protected $show_hidden;		

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
	 * @param $registration_id [INTEGER] The foreign key data for the data Manager
	 * @return [void]
	 */
    function __construct($pathModuleRoot, $viewer, $formAction, $person_id = '', $event_id = '', $fieldvalues_id ='', $fields_id='', $registration_id='',$disableHeading = false, $showHidden = true) 
    {
	     $this->disable_heading = $disableHeading;
	     $this->show_hidden = $showHidden;		// set to FALSE when in sign-up process
        // NOTE: be sure to call the parent constructor before trying to 
        //       use the ->formXXX arrays...

		  // store field values in field list; NOTE: probably don't need this now that we are generating custom labels...
		  $fieldList = $this->getFieldList($registration_id, $person_id, $event_id); //FormProcessor_EditFieldValues::FORM_FIELDS;        
        
		  // store field display types
        $fieldDisplayTypes = $this->getFormFieldTypes($registration_id, $person_id, $event_id);	//FormProcessor_EditFieldValues::FORM_FIELD_TYPES;
        parent::__construct( $formAction, $fieldList, $fieldDisplayTypes  );

        $this->pathModuleRoot = $pathModuleRoot;
        $this->viewer = $viewer;
        $this->formFieldToValueIDmapper = array();	// mapping is setup later in getFieldValuesArray()
        $this->formFieldToFieldIDmapper = array();	// mapping is setup later in getFieldsArray()
        $this->formLabels = array();
        $this->formLabels = $this->getFieldLabels($registration_id, $person_id, $event_id);

        $this->fieldvalues_id = $fieldvalues_id;
        $this->fields_id = $fields_id;
        $this->registration_id = $registration_id;
        
        $this->person_id = $person_id;
        $this->event_id = $event_id;
        
//        echo "PersonID = ".$person_id;
// 		 echo "EventID = ".$event_id;
// 			echo "Registration ID = ".$registration_id;
        
        // figure out the important fields for the dataManager
 //      $fieldsOfInterest = implode(',', $this->formFields);
 
 			$this->dataManager = new RowManager_FieldValueManager( $fieldvalues_id );
//        $this->dataManager->setFieldsOfInterest( $fieldsOfInterest );

	     $this->formValues = $this->getFieldValuesArray( $registration_id, $person_id, $event_id); //$this->dataManager->getArrayOfValues();

        // if the database contains no values then flag for new record creation (assumes not all values can be empty strings)
        if (count($this->formValues) == 0)
        {
	        $this->isNewRecordCreator = true;
        }  
        else 
        {
	        $this->isNewRecordCreator = false;
        } 	        
                
//		 echo "form values:<br><pre>".print_r($this->formValues,true)."</pre>";      

        // now initialize the labels for this page
        // start by loading the default field labels for this Module
        $languageID = $viewer->getLanguageID();
        $seriesKey = modulecim_reg::MULTILINGUAL_SERIES_KEY;
        $pageKey = modulecim_reg::MULTILINGUAL_PAGE_FIELDS;
        $this->labels = new MultilingualManager( $languageID, $seriesKey, $pageKey );
        
        // then load the page specific labels for this page
        $pageKey = FormProcessor_EditFieldValues::MULTILINGUAL_PAGE_KEY;
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
//			echo "field values:<br><pre>".print_r($fieldValues,true)."</pre>";

			$fields = new RowManager_FieldManager();
			$fields->setEventID($this->event_id);
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
					$formValues[ 'registration_id' ] = $this->registration_id;
// 					echo "FORM values:<br><pre>".print_r($formValues,true)."</pre>";
				
		        $this->dataManager = new RowManager_FieldValueManager( $fieldValueID );	//$fieldValueIDs[$idx]
		        $fieldsOfInterest = FormProcessor_EditFieldValues::FORM_FIELDS;
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
						$formValues[ 'registration_id' ] = $this->registration_id;			
//						echo "ADD FORM values:<br><pre>".print_r($formValues,true)."</pre>";
						
			        $this->dataManager = new RowManager_FieldValueManager();	//$fieldValueIDs[$idx]
//			        $fieldsOfInterest = FormProcessor_EditFieldValues::FORM_FIELDS;
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
		  if ($this->isNewRecordCreator == true)
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
				  $newValues[ 'registration_id' ] = $this->registration_id;					  
				  
		        $this->dataManager = new RowManager_FieldValueManager();	//$fieldValueIDs[$idx]
				  
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
        
        
		  $this->formValues['form_name'] = 'fieldValuesForm';
        
        // store all the fields to the template
        $this->setFormFieldsToTemplate(); 
               
                
        $this->template->set( 'formLabels', $this->formLabels );                        

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
     if ($this->disable_heading == true)
     {
	     $this->template->set( 'disableHeading', true ); 
     }   
     
     $this->template->set( 'formAnchor', 'FieldValuesForm');

		// uncomment this line if you are creating a template for this page
		//$templateName = 'page_EditFieldValues.php';
		// otherwise use the generic admin box template
		$templateName = 'siteFormSingle_dynamic.php';
		
		return $this->template->fetch( $templateName );
        
    }

    
    
    
 /*** HELPER METHODS ***/   
     
    
	// get custom labels for form based on stored event-specific form field descriptions    
   protected function getFieldLabels($regID='',$personID='',$eventID='')
	{    
		$labelsArray = array();
         
      $valuesArray = $this->getFieldArray($regID,$personID,$eventID);	//$valuesIterator->getDataList();	
       
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
        
        
        
    
    	// returns an array of registration-specific form field values (for event-specific form fields)
    	// e.g. 'fields_id|N|,fieldvalues_value|T|,registration_id|T|<skip>'  -- although <skip> is not implemented
	protected function getFieldList($regID='',$personID='',$eventID='')
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
       $valuesArray = $this->getFieldArray($regID,$personID,$eventID);	//$valuesIterator->getDataList();	
       
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
    protected function getFieldArray($regID='',$personID='',$eventID='') 
 	 {
	 	 $FALSE = 0;
	 	 
		 $fields = new RowManager_FieldManager();
//		 $fvalues = new RowManager_FieldValueManager();
		 $ftypes = new RowManager_FieldTypeManager();
		 
// 		 echo "personID = ".$personID;
// 		 echo "eventID = ".$eventID;
		 
		 if ($eventID != '') 
		 {
			 	$fields->setEventID($eventID);
		 		//$fvalues->setRegID($regID);
	    }
//	    else if (($eventID != '') && ($personID != ''))
		 else if ($regID != '')
	    {
		    $registrations = new RowManager_RegistrationManager();
		    $registrations->setRegID($regID);
//		    $person = new RowManager_PersonManager();
//		    $person->setPersonID($personID);
		    $event = new RowManager_EventManager();
//		    $event->setEventID($eventID);
		    $personReg = new MultiTableManager();
		    $personReg->addRowManager($registrations);
//		    $personReg->addRowManager($person, new JoinPair($registrations->getJoinOnPersonID(), $person->getJoinOnPersonID()));
		    $personReg->addRowManager($event, new JoinPair($registrations->getJoinOnEventID(), $event->getJoinOnEventID()));
		    
       	 $valIterator = $personReg->getListIterator(); 
       	 $valArray = $valIterator->getDataList();		
       	 
	       // go through results and store field types
	       reset($valArray);
			foreach(array_keys($valArray) as $k)
			{
			   $regValue = current($valArray);
			   
			   $eventID = $regValue['event_id'];		//NOTE: assumes only 1 event per registration       //OLD: registration per person per event
			
				next($valArray);
			}	     
			$fields->setEventID($eventID);
//			$fvalues->setRegID($regID);  	 	    
	    }
		    
//	    $fvalues->setSortByFieldID();

		 $fieldInfo = new MultiTableManager();
		 $fieldInfo->addRowManager($fields);
//		 $fieldInfo->addRowManager($fvalues, new JoinPair($fvalues->getJoinOnFieldID(), $fields->getJoinOnFieldID()));
		 $fieldInfo->addRowManager($ftypes, new JoinPair($fields->getJoinOnFieldTypeID(), $ftypes->getJoinOnFieldTypeID()));
		 if ($this->show_hidden == false) {
        		$fieldInfo->constructSearchCondition( 'fields_hidden', '=', $FALSE, true );
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
				$this->formFieldToFieldIDmapper['form_field'.$idx] = $record['fields_id'];
				
				next($valuesArray);
				$idx++;
			} 

//  		 echo "field id values:<br><pre>".print_r($this->formFieldToFieldIDmapper,true)."</pre>";

					
       return $valuesArray;       
	}	
	

    // return array of database records from field tables: cim_reg_fields, cim_reg_fieldtypes, cim_reg_fieldvalues
    // @param  [BOOLEAN] $isIndexedByValueID		whether or not the output array is indexed by template labels or by fieldvalue_id
    protected function getFieldValuesArray($regID='',$personID='',$eventID='')	//,$isIndexedByValueID = false) 
 	 {
	 	 $FALSE = 0;
	 	 
		 $fields = new RowManager_FieldManager();	 
		 $fvalues = new RowManager_FieldValueManager();
		 $ftypes = new RowManager_FieldTypeManager();
		 
// 		 echo "personID = ".$personID;
// 		 echo "eventID = ".$eventID;
		 
		 if ($regID != '') 
		 {
			 	//$fields->setEventID($eventID);
		 		$fvalues->setRegID($regID);
	    }
	    else if (($eventID != '') && ($personID != ''))
// 		 else if ($regID != '')
	    {
		    $registrations = new RowManager_RegistrationManager();
// 		    $registrations->setRegID($regID);
		    $person = new RowManager_PersonManager();
		    $person->setPersonID($personID);
		    $event = new RowManager_EventManager();
		    $event->setEventID($eventID);
		    $personReg = new MultiTableManager();
		    $personReg->addRowManager($registrations);
		    $personReg->addRowManager($person, new JoinPair($registrations->getJoinOnPersonID(), $person->getJoinOnPersonID()));
		    $personReg->addRowManager($event, new JoinPair($registrations->getJoinOnEventID(), $event->getJoinOnEventID()));
		    
       	 $valIterator = $personReg->getListIterator(); 
       	 $valArray = $valIterator->getDataList();		
       	 
	       // go through results and store field types
	       reset($valArray);
			foreach(array_keys($valArray) as $k)
			{
			   $regValue = current($valArray);
			   
			   $regID = $regValue['registration_id'];		//NOTE: assumes only 1 registration per person per event
			
				next($valArray);
			}	     
// 			$fields->setEventID($eventID);
			$fvalues->setRegID($regID);  	 	    
	    }
		    
//	    $fvalues->setSortByFieldID();


		 $fieldInfo = new MultiTableManager();
		 $fieldInfo->addRowManager($fields);
		 $fieldInfo->addRowManager($fvalues, new JoinPair($fvalues->getJoinOnFieldID(), $fields->getJoinOnFieldID()));
		 $fieldInfo->addRowManager($ftypes, new JoinPair($fields->getJoinOnFieldTypeID(), $ftypes->getJoinOnFieldTypeID()));
		 if ($this->show_hidden == false) {
        		$fieldInfo->constructSearchCondition( 'fields_hidden', '=', $FALSE, true );
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
					$updateValues['registration_id'] = $regID;
					
					$fieldvalues_manager = new RowManager_FieldValueManager();
					
		        // store values in table manager object.
		        $fieldvalues_manager->loadFromArray( $updateValues );
		        
		        // now update the DB with the values
		        if (!$fieldvalues_manager->isLoaded()) {
		            $fieldvalues_manager->createNewEntry(true);
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
		 	 
    
  	 /** Retrieve the list of field types to be displayed in the form */
	// NOTE: if a field isn't displayed, put a '-' for it's entry. -- NOT IMPLEMENTED YET
	//  e.g. 'textbox,textarea,checkbox,droplist,-';   -- droplist also not implemented (in DB) 
    protected function getFormFieldTypes($regID='',$personID='',$eventID='')
    {
	    $fieldTypes = '';
	    
	    $typesArray = $this->getFieldArray($regID,$personID,$eventID);
	    
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

}

?>
