<?php

// First load the common Template Tools object
// This object handles the common display of our form items and
// text formmatting tools.
// $fileName = 'objects/TemplateTools.php';
// $path = Page::findPathExtension( $fileName );
// require_once( $path.$fileName);

/**
 * @package p2c_stats
 */ 
/**
 * class FormProcessor_StatsInput
 * <pre> 
 * Allows a person to input statistics
 * </pre>
 * @author CIM Team (hsmit)
 * Date:   25 Oct 2007
 */
 // RAD Tools: FormSingleEntry Page
class  FormProcessor_StatsInput extends PageDisplay_FormProcessor {

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
//     const FORM_FIELDS = 'statistic_id|N|,statvalues_value|T|,freqvalue_id|N|';	//,meastype_id|N|,person_id|N|<hidden>
    
    /** The list of field types to be displayed in the form */
    // NOTE: if a field isn't displayed, put a '-' for it's entry.
//     const FORM_FIELD_TYPES = '-,textbox||8,droplist,-,-';
    
    /** The Multilingual Page Key for this page */
    const MULTILINGUAL_PAGE_KEY = 'FormProcessor_StatsInput';
    

	//VARIABLES:
	
	/** @var [STRING] The path to the module's root directory. */
	protected $pathModuleRoot;
	
	/** @var [OBJECT] The Viewer Object. */
	protected $viewer;
		
    /** @var [STRING] The initialization data for the dataManager. */
	protected $statvalues_id;
	
	/** @var [INTEGER] Foreign Key needed by Data Manager */
	protected $person_id;
		
	/** @var [INTEGER] Foreign Key needed by Data Manager */
	protected $stat_id;

	/** @var [INTEGER] Foreign Key needed by Data Manager */
	protected $freq_id;

	/** @var [INTEGER] Foreign Key needed by Data Manager */
	protected $meastype_id;
	
	/** @var [ARRAY] Foreign Keys needed by Data Manager */
	protected $scope_ref_list;

      
	/** @var [ARRAY] array mapping form labels to statsvalues_ids*/
	protected $formFieldToValueIDmapper;
	
	/** @var [ARRAY] array mapping form labels to stat_ids*/
	protected $formFieldToStatIDmapper;		
	
	/** @var [ARRAY] array storing the form labels */
	protected $formLabels;
	
	/** @var [BOOLEAN] whether or not to disable heading (i.e. for use as a sub-page) */
	protected $disable_heading;
	
	/** @var [BOOLEAN] whether or not the page must create new fieldvalues record(s) */
	protected $isNewRecordCreator;		
	  
        
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

	 * @return [void]
	 */
    function __construct($pathModuleRoot, $viewer, $formAction, $person_id = '', $statvalues_id = '', $stat_id ='', $freq_id='', $meastype_id='', $scope_ref_list='', $disableHeading = false, $showHidden = true) 
    {
	     $this->disable_heading = $disableHeading;
	     $this->show_hidden = $showHidden;		// set to FALSE when in sign-up process
	     $this->pathModuleRoot = $pathModuleRoot;
        $this->viewer = $viewer;
	     
        $this->statvalues_id = $statvalues_id;
        $this->stat_id = $stat_id;
        $this->freq_id = $freq_id;
        $this->meastype_id = $meastype_id;                
        $this->scope_ref_list = $scope_ref_list;	
        
 			if ($person_id != '')
			{
        		$this->person_id = $person_id;   
     		}
     		else 
     		{
	     		$this->person_id = $this->getPersonIDfromViewerID();
     		}            
	     
        // NOTE: be sure to call the parent constructor before trying to 
        //       use the ->formXXX arrays...

		  // store field values in field list; NOTE: probably don't need this now that we are generating custom labels...
		  $fieldList = $this->getFieldList($scope_ref_list,$freq_id,$meastype_id); //FormProcessor_EditFieldValues::FORM_FIELDS;      
        
		  // store field display types
        $fieldDisplayTypes = $this->getFormFieldTypes($scope_ref_list,$freq_id,$meastype_id);	//FormProcessor_EditFieldValues::FORM_FIELD_TYPES;
        
        parent::__construct( $formAction, $fieldList, $fieldDisplayTypes  );
        
        
        $this->formFieldToValueIDmapper = array();	// mapping is setup later in getFieldValuesArray()
        $this->formFieldToStatIDmapper = array();	// mapping is setup later in getFieldsArray()
        $this->formLabels = array();
        $this->formLabels = $this->getFieldLabels($scope_ref_list,$freq_id,$meastype_id);
 
        $_POST['meas_id'] = $this->meastype_id;
        $_POST['freq_id'] = $this->freq_id;

        if (isset($scope_ref_list)&&(count($scope_ref_list) > 0))
        {        
// 	        		$_POST['scope_ref_list'] = $scope_ref_list;
        		$_POST['ministry_id'] = $scope_ref_list[modulep2c_stats::SCOPE_REF_MINISTRY];
        		$_POST['division_id'] = $scope_ref_list[modulep2c_stats::SCOPE_REF_DIVISION];
        		$_POST['region_id'] = $scope_ref_list[modulep2c_stats::SCOPE_REF_REGION];
        		$_POST['location_id'] = $scope_ref_list[modulep2c_stats::SCOPE_REF_LOCATION];  

     		} 
//      		$this->formValues['meas_id'] = $meastype_id;
//      		$this->formValues['freq_id'] = $freq_id;
     		
//       		echo "POST array: <pre>".print_r($_POST,true)."</pre>";
     		
        
        // figure out the important fields for the dataManager
 //      $fieldsOfInterest = implode(',', $this->formFields);
 
 			$this->dataManager = new RowManager_StatValueManager( $statvalues_id );
//        $this->dataManager->setFieldsOfInterest( $fieldsOfInterest );

			/** NOTE **    this page is for input and not editing, plus no particular freq-value is yet specified so any values would be inaccurate **/
			/** values would be inaccurate because only the first ever <freq> stat value would be shown, not for all the other <freq>s (i.e. week) **/
//	     $this->formValues = $this->getFieldValuesArray( $scope_ref_list,$freq_id,$meastype_id); //$this->dataManager->getArrayOfValues();

        // if the database contains no values then flag for new record creation (assumes not all values can be empty strings)
//         if (count($this->formValues) == 0)
//         {
// 	        $this->isNewRecordCreator = true;
//         }  
//         else 
//         {
// 	        $this->isNewRecordCreator = false;
//         } 	  
                       
// 		 echo "form values:<br><pre>".print_r($this->formValues,true)."</pre>";   
//         echo "field to value id array: <pre>".print_r($this->formFieldToValueIDmapper,true)."</pre>";
//         echo "field to stat id array: <pre>".print_r($this->formFieldToStatIDmapper,true)."</pre>";

        // now initialize the labels for this page
        // start by loading the default field labels for this Module
        $languageID = $viewer->getLanguageID();
        $seriesKey = modulep2c_stats::MULTILINGUAL_SERIES_KEY;
        $pageKey = modulep2c_stats::MULTILINGUAL_PAGE_FIELDS;
        $this->labels = new MultilingualManager( $languageID, $seriesKey, $pageKey );
        
        // then load the page specific labels for this page
        $pageKey = FormProcessor_StatsInput::MULTILINGUAL_PAGE_KEY;
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
        
//         echo "2 POST array: <pre>".print_r($_POST,true)."</pre>";
             
        
		   $formValues = array();
			$fieldValues = array();
			// get field value records
//			$fieldValues = $this->getFieldValuesArray( $this->registration_id, $this->person_id, $this->event_id, true );
			$fieldValues = $_POST;	//$this->formValues;			
// 			echo "field values:<br><pre>".print_r($_POST,true)."</pre>";
			
			$processDataTuple = false;
			reset($fieldValues);
			$keys = array_keys($fieldValues);	// get field value ids, since array indexed using them
			foreach ($keys as $formLabel)
			//for ($idx = 0; $idx < count($fieldValueIDs); $idx++)
			{
				
// 				$fieldValueID = -1;
// 				if ( isset($this->formFieldToValueIDmapper[$formLabel])) 
// 				{
// 					// get fieldvalues_id mapped to formlabel
// 					$statValueID = $this->formFieldToValueIDmapper[$formLabel];
// 					$formValues['statvalues_id' ] = $fieldValueID;
// 					$formValues['statvalues_value' ] = $fieldValues[$formLabel];
// // 					$formValues[ 'registration_id' ] = $this->registration_id;
// //					echo "FORM values:<br><pre>".print_r($formValues,true)."</pre>";
// 				
// 		        $this->dataManager = new RowManager_StatValueManager( $statValueID );	//$fieldValueIDs[$idx]
// 		        $fieldsOfInterest = FormProcessor_EditFieldValues::FORM_FIELDS;
// 	           $this->dataManager->setFieldsOfInterest( $fieldsOfInterest );
// 				  
// 				  $this->dataManager->loadFromArray( $formValues );		// load field value into appropriate row in DB
// //				  echo 'field value id = '.$fieldValueID.' for '.$fieldValues[$formLabel].'<BR>';
// 				  
// 					// standard code for adding/updating but nested to accomodate updating multiple fieldvalues rows
// 		        if (!$this->dataManager->isLoaded()) {
// 		            $this->dataManager->createNewEntry();	
// 		            //echo "ADDED";
// 		        } else {
// 		            $this->dataManager->updateDBTable();	
// 		            //echo "UPDATED";
// 		        }			  
// 			  }
// 			  else if ($this->isNewRecordCreator == true)	// if no fieldvalues records could be found, create new one
// 			  {
	
				  
				   if (isset($this->formFieldToStatIDmapper[$formLabel]))
				   {
// 						echo "<br>formLabel = ".$formLabel;											   

// 						$formValues[ 'registration_id' ] = $this->registration_id;			
//						echo "ADD FORM values:<br><pre>".print_r($formValues,true)."</pre>";

						if ($processDataTuple == true)
						{	
// 							$freqValueRecord = array();
// // 							echo "FREQ_ID = ".$fieldValues['freq_id'];	//$this->freq_id;
// 							$freqValueRecord['freq_id'] = $fieldValues['freq_id'];	//$this->freq_id;
// 							
// 							//echo "value = ".str_replace("-", "0", $fieldValues[$formLabel]); // PROBLEM: '-' between YYYY-MM-DD							
// 							
// 							$freqValueRecord['freqvalue_value'] = $fieldValues[$formLabel];
// 							$freqValueRecord['freqvalue_desc'] = '';
// 							
// 							  $freqValueManager = new RowManager_FreqValueManager();
// 							  $freqValueManager->loadFromArray( $freqValueRecord );
// 							  
// 								// standard code for adding/updating but nested to accomodate updating multiple fieldvalues rows
// 					        if (!$freqValueManager->isLoaded()) {
// 					            $freqValueManager->createNewEntry();	
// 	 				            echo "ADDED FVAL";
// 					        } else {
// 					            $freqValueManager->updateDBTable();	
// 	 				            echo "UPDATED FVAL";
// 					        }	
// 					        $freqValueID = $freqValueManager->getID();	
// 	 				        echo "FREQVAL_ID = ".$freqValueID;				  
																		
// 							  $formValues['freqvalue_id'] = $freqValueID;
 							  $formValues['freqvalue_id' ] = $fieldValues[$formLabel];
							  $formValues['meastype_id'] = $this->meastype_id;
										
					        $this->dataManager = new RowManager_StatValueManager();	//$fieldValueIDs[$idx]
		//			        $fieldsOfInterest = FormProcessor_EditFieldValues::FORM_FIELDS;
		//		           $this->dataManager->setFieldsOfInterest( $fieldsOfInterest );
							  
							  $this->dataManager->loadFromArray( $formValues );		// load field value into appropriate row in DB
			//				  echo 'field value id = '.$fieldValueID.' for '.$fieldValues[$formLabel].'<BR>';
							  
							// standard code for adding/updating but nested to accomodate updating multiple fieldvalues rows
					        if (!$this->dataManager->isLoaded()) {
					            $this->dataManager->createNewEntry();	
// 					            echo "ADDED";
					        } else {
					            $this->dataManager->updateDBTable();	
// 					            echo "UPDATED";
					        }
							 $processDataTuple = false;
						 }
						 else		// get ready to process statvalue-freqvalue pair at next iteration
						 {
							 $processDataTuple = true;
							 
							 // get statID mapped to formlabel
							 $statID = $this->formFieldToStatIDmapper[$formLabel];
							 $formValues['statistic_id' ] = $statID;								 
							 $formValues['statvalues_value' ] = $fieldValues[$formLabel];
							 
							 // TODO: change below 2 lines to be dependent on most accurate scope chosen on filter page
							 $formValues['scope_id'] = modulep2c_stats::SCOPE_REF_LOCATION;
							 $formValues['scope_ref_id'] = $this->scope_ref_list[modulep2c_stats::SCOPE_REF_LOCATION];
							 
							 $formValues['person_id'] = $this->person_id;	// TEMP VAL
						 }
		          }
// 	        }						
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
        
//         $this->formValues['freq_id'] = $this->freq_id;
//         $this->formValues['meas_id'] = $this->meastype_id;
// 		  $this->formValues['form_name'] = 'statValuesForm';
// 			$_POST['freq_id'] = $this->freq_id;
// 			$_POST['meas_id'] = $this->meastype_id;
        
        // store all the fields to the template
        $this->setFormFieldsToTemplate(); 
               
                
        $this->template->set( 'formLabels', $this->formLabels );                        

        /*
         * Form related Template variables:
         */
        
        // store the button label
        $this->template->set( 'buttonText', $this->labels->getLabel('[Update]') );
        
        
        /*** Fill the frequency value droplists with appropriate values (i.e. years, weeks, days, etc) **/
        // NOTE: moving code below into the loop would allow for different freq types per statistic input
			$freqValueManager = new RowManager_FreqValueManager();
			$freqValueManager->setFreqID($this->freq_id);		// set whether we filtered by annual, weekly, etc. type stats
			$freqValueList = $freqValueManager->getListIterator();
			$freqValueArray = $freqValueList->getDropListArray();		
	//         echo "<pre>".print_r($freqValueArray,true)."</pre>";
			
        reset($this->formFieldToStatIDmapper);
        foreach (array_keys($this->formFieldToStatIDmapper) as $k)
        {   
	        next($this->formFieldToStatIDmapper);  
	        
	        // every other field will be a freq type dropbox
 	        $this->template->set( 'list_'.$k, $freqValueArray );  
	        next($this->formFieldToStatIDmapper);           
		  }
		  
// 		  echo 'fields = <pre>'.print_r($this->formFieldToStatIDmapper,true).'</pre>';
		  

        /*
         * Add any additional data required by the template here
         */
      if ($this->disable_heading == true)
      {
	     $this->template->set( 'disableHeading', true ); 
      }   
      
//           $labelManager->addLabel( "[NoStatsFound]", "NO statistics found... please choose different filter values.", "en" );
		if ( count($this->formFieldToStatIDmapper) < 1 ) 
		{
			// see also: $templateTools->getPageLabel('[NoStatsFound]') );
			$this->template->set( 'specialInfo', '<div class="notice">NO statistics found... please choose different filter values.</div>'); 
		}
     
      $this->template->set( 'formAnchor', 'StatValuesForm');

		// uncomment this line if you are creating a template for this page
		//$templateName = 'page_EditFieldValues.php';
		// otherwise use the generic admin box template
		$templateName = 'siteFormSingle_dynamic.php';
		
		return $this->template->fetch( $templateName );
        
    }

    
    
    
 /*** HELPER METHODS ***/   
     
    
	// get custom labels for form based on stored event-specific form field descriptions    
   protected function getFieldLabels($scopeRefList,$freqID='',$measID='')
	{    
		$labelsArray = array();
         
      $valuesArray = $this->getFieldArray($scopeRefList, $freqID, $measID);	//$valuesIterator->getDataList();	
       
       // go through results and store field descriptions as the form field labels
      $idx = 0;
      reset($valuesArray);
		foreach(array_keys($valuesArray) as $k)
		{
		   $fieldValue = current($valuesArray);
		   
//		   $fieldList .= 'form_field'.$idx.'|'.$this->getFieldType($fieldValue['fieldtypes_desc']).'|,';		//$fieldValue['fields_desc']
		   $labelsArray['formLabel_'.$idx] = $fieldValue['statistic_name'].' ('.$fieldValue['freq_desc'].')';
		   $labelsArray['formLabel_'.++$idx] = $fieldValue['statistic_name'].' (Select '.$fieldValue['freq_name'].')';	// for associated freq value field
		
		   $idx++;
			next($valuesArray);
		}	
		
		return $labelsArray;	// return array of form field labels generated from event-specific fields
	}       
        
        
        
    
    	// returns an array of statistic form field labels (filtered by ministry, division, region, location, freq. type, and meas. type)
    	// e.g. 'statistic_id|N|,statvalues_value|T|,freqvalue_id|N|'  -- although <skip> is not implemented
	protected function getFieldList($scopeRefList,$freqID='',$measID='')
	{
		 $TRUE = 1;
		 $FALSE = 0;
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
       
       // get types to match stat type ids
       $stat_types = new RowManager_StatDataTypeManager();
       $typesList = $stat_types->getListIterator();
       $typesArray = $typesList->getDataList();
       
       $valuesArray = $this->getFieldArray($scopeRefList, $freqID, $measID);	//$valuesIterator->getDataList();	
       
       // go through results and store field descriptions as the form field labels
       $idx = 0;
       reset($valuesArray);
		foreach(array_keys($valuesArray) as $k)
		{
		   $fieldValue = current($valuesArray);
		   
		   $fieldList .= 'form_field'.$idx.'|'.$this->getFieldType($typesArray[$fieldValue['statistic_type_id']]['statistic_type']).'|,';		//$fieldValue['fields_desc']
		   $fieldList .= 'form_field'.++$idx.'|'.$this->getFieldType('datetime').'|,'; /** associated freq. value field **/
		
		   $idx++;
			next($valuesArray);
		}	
		// 'freq_id|N|<skip>,meas_id|N|<skip>,form_name|T|<skip>';	//
		$fieldList = substr($fieldList,0,-1);	// remove final comma		
//   		echo "<BR><BR>Field List = ".$fieldList;
				
		return $fieldList;	// return list of form fields generated from event-specific fields
    }
    
        
    // return array of database records from field tables: cim_reg_fields, cim_reg_fieldtypes
    protected function getFieldArray($scopeRefList,$freqID='',$measID='') 
 	 {	 	 	 
	 	 
		 $stats = new MultiTableManager();
		 $stat = new RowManager_StatisticManager();
		 $freq = new RowManager_FreqTypeManager();
		 $stats->addRowManager($stat);
		 $stats->addRowManager($freq, new JoinPair($stat->getJoinOnFreqID(), $freq->getJoinOnFreqID()));
		 
		 // filter the statistic fields shown using the parameters
		 $searchConditions = '';
		 if (isset($scopeRefList))
		 {
			reset($scopeRefList);
			foreach(array_keys($scopeRefList) as $k)
			{
				$scopeID = key($scopeRefList);
			   $scopeRefID = current($scopeRefList);			   
			   
			   $searchConditions .= '(p2c_stats_statistic.scope_id = '.$scopeID;
			   $searchConditions .= ' AND p2c_stats_statistic.scope_ref_id = '.$scopeRefID.')';
			   $searchConditions .= ' OR ';
			
				next($scopeRefList);
			}
			$searchConditions = substr($searchConditions,0,-4);	// remove last OR
			$stats->addSearchCondition($searchConditions);
		}	
		
		if ($freqID != '')
		{
// 			$stats->setFreqID($freqID);
			$stats->addSearchCondition('p2c_stats_statistic.freq_id = '.$freqID);
		}
		
		if ($measID != '')
		{
// 			$stats->setMeasureTypeID($measID);
			$stats->addSearchCondition('p2c_stats_statistic.meas_id = '.$measID);
		}				
// 		$stats->setSortByStatID();
		$stats->setSortOrder('statistic_id');
		 
// 		 echo $stats->createSQL();
		 
       $statsIterator = $stats->getListIterator(); 
       $statsArray = $statsIterator->getDataList();	
       
// 		 echo "found statistics:<br><pre>".print_r($statsArray,true)."</pre>";

       // map the fields_id of each field values row to the label of that particular form field
        $idx = 0;
        reset($statsArray);
        	foreach(array_keys($statsArray) as $k)
			{
				$record = current($statsArray);				
				
				// store mapping associating form field label with fields_id
				$this->formFieldToStatIDmapper['form_field'.$idx] = $record['statistic_id'];
				$this->formFieldToStatIDmapper['form_field'.++$idx] = $record['statistic_id'];	// for freq value field
				
				next($statsArray);
				$idx++;
			} 

//  		 echo "stat id values:<br><pre>".print_r($this->formFieldToStatIDmapper,true)."</pre>";

					
       return $statsArray;       
	}	
	

    // return array of database records from field tables: cim_reg_fields, cim_reg_fieldtypes, cim_reg_fieldvalues
    // @param  [BOOLEAN] $isIndexedByValueID		whether or not the output array is indexed by template labels or by fieldvalue_id
    protected function getFieldValuesArray($scopeRefList,$freqID='',$measID='')	//,$isIndexedByValueID = false) 
 	 {
		 $statvalues = new RowManager_StatValueManager();
		 $statvalues->setSortByStatID();
		 
		 $stats = new RowManager_StatisticManager();	 

		/** TODO
		 * 	scopeID == ''  means we either don't proceed or assume all possible scopes
		 *	   scopeRefID == '' can be ignored if the prev is true, otherwise could assume all values for given scope (i.e ministry, division, etc)
		 *		freqID == '' means we don't proceed since we need to interpret frequency value properly
	    *		measID == '' means we don't proceed since, for instance, Personal Ministry <> Team Ministry (or can we have stats count for both?)
	    **/
				 

		 $fieldInfo = new MultiTableManager();
		 $fieldInfo->addRowManager($statvalues);
		 $fieldInfo->addRowManager($stats, new JoinPair($statvalues->getJoinOnStatID(), $stats->getJoinOnStatID()));

		 		 
		 // filter the statistic fields shown using the parameters
		 $searchConditions = '';
		 if (isset($scopeRefList))
		 {	 
			 
			reset($scopeRefList);
			foreach(array_keys($scopeRefList) as $k)
			{
				$scopeID = key($scopeRefList);
			   $scopeRefID = current($scopeRefList);			   
			   
			   $searchConditions .= '(p2c_stats_statistic.scope_id = '.$scopeID;
			   $searchConditions .= ' AND p2c_stats_statistic.scope_ref_id = '.$scopeRefID.')';
			   $searchConditions .= ' OR ';
			
				next($scopeRefList);
			}
			$searchConditions = substr($searchConditions,0,-4);	// remove last OR
			$fieldInfo->addSearchCondition($searchConditions);
		}	
		
		if ($freqID != '')
		{
			$fieldInfo->addSearchCondition('p2c_stats_statistic.freq_id = '.$freqID);
		}
		
		if ($measID != '')
		{
			$fieldInfo->addSearchCondition('p2c_stats_statistic.meas_id = '.$measID);
		}
				 
		 

       $valuesIterator = $fieldInfo->getListIterator(); 
       $valuesArray = $valuesIterator->getDataList();	      
//        echo "field values:<br><pre>".print_r($valuesArray,true)."</pre>";
       
       // since each field value is located in a DB row the result array has several arrays - one per field value
       // need to extract each field value and store it as a non-array record in a result array
        $fieldValues = array();
        $record = array();
        $idx = 0;
        reset($valuesArray);
        	foreach(array_keys($valuesArray) as $k)
			{
				$record = current($valuesArray);				
				
/*				if ($isIndexedByValueID == true)
				{
					$fieldValues[$record['fieldvalues_id']] = $record['fieldvalues_value'];
				}
				else
				{		*/
					$fieldValues['form_field'.$idx] = $record['statvalues_value'];
					//$fieldValues['form_field'.$idx+1] = $record['freqvalue_id'];
//				}
				
				// store mapping associating form field label with fieldvalues_id
				$this->formFieldToValueIDmapper['form_field'.$idx] = $record['statvalues_id'];
				//$this->formFieldToValueIDmapper['form_field'.++$idx] = $record['statvalues_id'];
				
				next($valuesArray);
				$idx++;
			}       
       
		
       return $fieldValues;       
	}	
		 	 
    
  	 /** Retrieve the list of field types to be displayed in the form */
	// NOTE: if a field isn't displayed, put a '-' for it's entry. -- NOT IMPLEMENTED YET
	//  e.g. 'textbox,textarea,checkbox,droplist,-';   -- droplist also not implemented (in DB) 
    protected function getFormFieldTypes($scopeRefList,$freqID='',$measID='')
    {
	    $fieldTypes = '';
	    
	    $typesArray = $this->getFieldArray($scopeRefList, $freqID, $measID);
// 	    echo "<br>types field array = <pre>".print_r($typesArray,true)."</pre>"; 


       // get types to match stat type ids
       $stat_types = new RowManager_StatDataTypeManager();
       $typesList = $stat_types->getListIterator();
       $statDataTypesArray = $typesList->getDataList();
       
       
	    
       // go through results and store field types
       reset($typesArray);
		foreach(array_keys($typesArray) as $k)
		{
		   $fieldValue = current($typesArray);
		   $fieldTypes .= $this->getFormObject($statDataTypesArray[$fieldValue['statistic_type_id']]['statistic_type']).',';			// $fieldValue['statistic_type']
		   $fieldTypes .= 'droplist,';	// used for stat-related freq value field
		
			next($typesArray);
		}	
		// 'hidden,hidden,hidden';	//
		$fieldTypes = substr($fieldTypes,0,-1);	// remove final comma		
// 		echo "<br>Field Types = ".$fieldTypes;
		
		return $fieldTypes;	// return list of form field types associated with event-specific fields
	}	    

    
    //             form_field_type = the type of form field
    //                               T = Text / String
    //                               N = Numeric 
    //                               B = Boolean
    //                               D = Date ( 3 lists boxes day/mon/year)
    //                            Time = Time ( 3 list boxes  HH/MM/Am )
    //                        DateTime = Date + Time pickers ...    
    // return template form field type given statistic type 
    // (as recorded in 'p2c_stats_stattype' table and used in 'p2c_stats_statistic' table)
    protected function getFieldType($statistic_type)
    {
	    $fieldType = '';
	    
	    switch ($statistic_type)
	    {
		    case 'numeric':
		    	$fieldType = 'N';
		    	break;
		    case 'text':
		    	$fieldType = 'T';
		    	break;
		    case 'boolean':
		    	$fieldType = 'B';
		    	break;
		    case 'date':
		    	$fieldType = 'D';
		    	break;
		    case 'time':
		    	$fieldType = 'Time';
		    	break;	
		    case 'datetime':
		    	$fieldType = 'DateTime';
		    	break;			    
		    default:
		    	$fieldType = 'T';
		    	break;
		}
		
		return $fieldType;
	}    
	
  
    // return template form field object given statistic type 
    // (as recorded in 'p2c_stats_stattype' table and used in 'p2c_stats_statistic' table)
    protected function getFormObject($statistic_type)
    {
	    $fieldType = '';
	    
	    switch ($statistic_type)
	    {
		    case 'numeric':
		    	$fieldType = 'textbox';
		    	break;
		    case 'text':
		    	$fieldType = 'textbox';
		    	break;
		    case 'boolean':
		    	$fieldType = 'checkbox';
		    	break;
		    case 'date':
		    	$fieldType = 'datetimepicker';
		    	break;
		    case 'time':
		    	$fieldType = 'datetimepicker';
		    	break;	
		    case 'datetime':
		    	$fieldType = 'datetimepicker';
		    	break;			    default:
		    	$fieldType = 'textbox';
		    	break;
		}
		
		return $fieldType;
	}   	 		
	
    // self-explanatory: system user == person to be registered (or at least get personal info changed)
 protected function getPersonIDfromViewerID()
 {
    $accessPriv = new RowManager_AccessManager();
    $accessPriv->setViewerID($this->viewer->getID());
    
    $accessPrivList = $accessPriv->getListIterator();
    $accessPrivArray = $accessPrivList->getDataList();
    
    $personID = '';
    reset($accessPrivArray);
    foreach (array_keys($accessPrivArray) as $k)
    {
    	$record = current($accessPrivArray);
    	$personID = $record['person_id'];	// can only be 1 person_id per viewer_id
    	next($accessPrivArray);
 	 }
    
    return $personID;
 } 	

}

?>