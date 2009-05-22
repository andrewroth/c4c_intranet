<?php

// $toolName = 'modules/app_cim_hrdb/objects_da/AdminManager.php';
// $toolPath = Page::findPathExtension( $toolName );
// require_once( $toolPath.$toolName);

// $toolName = 'modules/app_cim_hrdb/objects_da/AccessManager.php';
// $toolPath = Page::findPathExtension( $toolName );
// require_once( $toolPath.$toolName);

/**
 * @package p2c_stats
 */ 
/**
 * class FormProcessor_StatsReportSelectionForm
 * <pre> 
 * Allows a person to select statistics, date/time-range, and additional calculations for report generation.
 * </pre>
 * @author CIM Team (hsmit)
 * Date:   31 Oct 2007
 */
 // RAD Tools: FormSingleEntry Page
class  FormProcessor_StatsReportSelection extends PageDisplay_FormProcessor {

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
    
    // NOTE: had to make 1st and last fields Text/String since a combolist returns an array
    const FORM_FIELDS = 'statistic_id|T|,freqvalue_id|N|,freqvalue_id_2|N|,filter_id|T|';	
    
    /** The list of field types to be displayed in the form */
    // NOTE: if a field isn't displayed, put a '-' for it's entry.
    const FORM_FIELD_TYPES = 'combolist|4,droplist,droplist,combolist|4';
    
    /** The Multilingual Page Key for this page */
    const MULTILINGUAL_PAGE_KEY = 'FormProcessor_StatsReportSelection';
    

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

      
 	/** @var [OBJECT] The dataManager used to create date/time droplists*/
 	protected $freqValueManager;
 	protected $freqValueManager2;
 	
 	/** @var [OBJECT] The dataManager used to create combo list with possible report filters (i.e. SUM, AVG, etc)*/
 	protected $filterManager; 	
	
	/** @var [BOOLEAN] whether or not to disable heading (i.e. for use as a sub-page) */
	protected $disable_heading;
	
	/** @var [BOOLEAN] whether or not the page must create new fieldvalues record(s) */
	protected $isNewRecordCreator;	
	
	
	/** @var [ARRAY] Used to store custom form field labels */
	protected $fieldLabels;	
	  
        
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
        
//  			if ($person_id != '')
// 			{
        		$this->person_id = $person_id;   
//      		}
//      		else 
//      		{
// 	     		$this->person_id = $this->getPersonIDfromViewerID();
//      		}            
	     
        // NOTE: be sure to call the parent constructor before trying to 
        //       use the ->formXXX arrays...

// 		  // store field values in field list; NOTE: probably don't need this now that we are generating custom labels...
// 		  $fieldList = $this->getFieldList($scope_ref_list,$freq_id,$meastype_id); //FormProcessor_EditFieldValues::FORM_FIELDS;      
//         
// 		  // store field display types
//         $fieldDisplayTypes = $this->getFormFieldTypes($scope_ref_list,$freq_id,$meastype_id);	//FormProcessor_EditFieldValues::FORM_FIELD_TYPES;
//         
        $fieldList = FormProcessor_StatsReportSelection::FORM_FIELDS;
        $fieldDisplayTypes = FormProcessor_StatsReportSelection::FORM_FIELD_TYPES;
        parent::__construct( $formAction, $fieldList, $fieldDisplayTypes  );

//  
//         $_POST['meas_id'] = $this->meastype_id;
//         $_POST['freq_id'] = $this->freq_id;

//         if (isset($scope_ref_list)&&(count($scope_ref_list) > 0))
//         {        
// // 	        		$_POST['scope_ref_list'] = $scope_ref_list;
//         		$_POST['ministry_id'] = $scope_ref_list[modulep2c_stats::SCOPE_REF_MINISTRY];
//         		$_POST['division_id'] = $scope_ref_list[modulep2c_stats::SCOPE_REF_DIVISION];
//         		$_POST['region_id'] = $scope_ref_list[modulep2c_stats::SCOPE_REF_REGION];
//         		$_POST['location_id'] = $scope_ref_list[modulep2c_stats::SCOPE_REF_LOCATION];  

//      		} 
     		
//       		echo "POST array: <pre>".print_r($_POST,true)."</pre>";
     		
        
 			// Fill the primary data-manager with the statistics to be displayed in combo list
         $this->dataManager = new RowManager_StatisticManager();
         $this->dataManager->setFreqID($this->freq_id);
         $this->dataManager->setMeasureTypeID($this->meastype_id);
 
         // find all statistics whose scope has been specified by previous filter step
         $scope_ref_list = $this->scope_ref_list;
         $scopeFilter = '';
         reset($scope_ref_list);
         foreach( array_keys($scope_ref_list) as $key)
         {
	         // TODO?: use is_numeric() on $scope_ref_list elements to determine that proper value exists
	         $scopeFilter .= '(scope_id = '.$key.' and scope_ref_id = '.current($scope_ref_list).') OR ';
	         
	         next($scope_ref_list);
         }
         $scopeFilter = substr($scopeFilter,0,-4);	// remove ' OR ' from the end of the string
         $this->dataManager->addSearchCondition($scopeFilter);
         
         // Fill 'freqValueManager' with freq. values needed to specify date/time-range for report
         $this->freqValueManager = new RowManager_FreqValueManager();
         $this->freqValueManager->setFreqID($this->freq_id);
         
         $this->freqValueManager2 = new RowManager_FreqValueManager();
         $this->freqValueManager2->setFreqID($this->freq_id);
          $this->freqValueManager2->addFieldNameAlias('freqvalue_id', 'freqvalue_id_2');

         $values = $this->freqValueManager2->getListIterator()->getDataList();
// 		   echo "form values:<br><pre>".print_r($values,true)."</pre>";  
         
         // Fill 'filterManager' with filters available for report (i.e. SUM, AVG, etc)
         $this->filterManager = new RowManager_ReportFilterManager();
        
 //       $this->dataManager->setFieldsOfInterest( $fieldsOfInterest );
//           $this->formValues = $this->dataManager->getArrayOfValues();
//echo "form values:<br><pre>".print_r($this->formValues,true)."</pre>";  


//         $this->formLabels = array();
//         $this->formLabels['formLabel_statistic_id'] = 
//         $this->formLabels = $this->getFieldLabels($scope_ref_list,$freq_id,$meastype_id);

		  $freqManager = new RowManager_FreqTypeManager($this->freq_id);
		  $freqList = $freqManager->getListIterator();
		  $freqArray = $freqList->getDataList();
		  $freqRecord = current($freqArray);
		  $freqStatDesc = $freqRecord['freq_desc'];
		  $freqName = $freqRecord['freq_name'];

		  $this->fieldLabels['statistic_id'] = 'Choose 1 or More '.$freqStatDesc.' Statistics:';
		  $this->fieldLabels['freqvalue_id'] = 'Starting '.$freqName.':';
		  $this->fieldLabels['freqvalue_id_2'] = 'Ending '.$freqName.':';
		  $this->fieldLabels['filter_id'] = 'Additional Calculations:';


        // now initialize the labels for this page
        // start by loading the default field labels for this Module
        $languageID = $viewer->getLanguageID();
        $seriesKey = modulep2c_stats::MULTILINGUAL_SERIES_KEY;
        $pageKey = modulep2c_stats::MULTILINGUAL_PAGE_FIELDS;
        $this->labels = new MultilingualManager( $languageID, $seriesKey, $pageKey );
        
        // then load the page specific labels for this page
        $pageKey = FormProcessor_StatsReportSelection::MULTILINGUAL_PAGE_KEY;
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
         
         // do NOT allow starting freq. range value to be less than ending value
//          if ($this->formValues['freq_value_id'] > $this->formValues['freq_value_id_2'])
//          {
// 	         $isValid = false;
// 	         $this->formErrors[ 'freq_value_id' ] = 'Starting range value must be greater than or equal to the ending range value.';
//          }
        
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
        /*[RAD_ADMINBOX_FOREIGNKEY]*/	    
        
        
//          echo '<pre>'.print_r($this->formValues,true).'</pre>'; 
//          echo '<br>_REQUEST values = <pre>'.print_r($_REQUEST, true).'</pre>';	
        
        // TODO: store settings in the saved form table??			    	        
        
        // store values in table manager object.
//         $this->dataManager->loadFromArray( $this->formValues );
//         
//         // now update the DB with the values
//         if (!$this->dataManager->isLoaded()) {
// //	        echo "PERSONID = ".$this->person_id;
// 	         $this->dataManager->setPersonID($this->person_id);
//             $this->dataManager->createNewEntry(true);
//             
//             $this->assignCampus($this->person_id);
//         } else {
//             $this->dataManager->updateDBTable();
//         }
        
        
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
        //$path = SITE_PATH_TEMPLATES;
        
       
        
        // store the page labels in XML format...
        // NOTE: use this location to update any label tags ...
        // $name = $user->getName();
        // $this->labels->setLabelTag( '[Title]', '[userName]', $name);

        
        
        // NOTE:  this parent method prepares the $this->template with the 
        // common Form data.  
        $this->prepareTemplate( $path );
                
//         echo "POST = <pre>".print_r($_POST,true)."</pre>";

        /*
         * Form related Template variables:
         */
        
        // store the button label
        $this->template->set( 'buttonText', $this->labels->getLabel('[Update]') );
        
        // store the dynamic labels
        $this->template->set('fieldLabels', $this->fieldLabels);
        
//  echo "labels = <PRE>".print_r($this->formLabels,true)."</pre>";

        // Insert the date start/end values for the following date fields:
        // example:
            //$this->template->set( 'startYear_[fieldName]', 2000);
            //$this->template->set( 'endYear_[fieldName]', 2010);

                


        /*
         * Add any additional data required by the template here
         */
//         $person_manager = new RowManager_PersonManager( $this->person_id );


         
        /**** Populate drop-lists and combo-lists for statistics, date/time-ranges, and filters used to generate reports ****/
        
        $statsList = $this->dataManager->getListIterator( );
        $statsArray = $statsList->getDropListArray( );
        $this->template->set( 'list_statistic_id', $statsArray );
//         echo '<pre>'.print_r($statsArray,true).'</pre>';
        
        $freqValList = $this->freqValueManager->getListIterator( );
        $freqValArray = $freqValList->getDropListArray( );
        $this->template->set( 'list_freqvalue_id', $freqValArray );
               

        $freqValList2 = $this->freqValueManager2->getListIterator( );
        $freqValArray2 = $freqValList2->getDropListArray( );
        $this->template->set( 'list_freqvalue_id_2', $freqValArray2 );
        
        // TODO: need duplicate of above..??  (for end time/date-range)
        
        $filterList = $this->filterManager->getListIterator( );
        $filterArray = $filterList->getDropListArray( );
        $this->template->set( 'list_filter_id', $filterArray );  
        
        
//         $validateScript = 'onchange="MM_checkPreviousMenu($TODO')"';	           //// CONTINUE HERE
//         $this->template->set( 'validateScript', $validateScript );
             

		// uncomment this line if you are creating a template for this page
		//$templateName = 'page_EditMyInfo.php';
		// otherwise use the generic admin box template
		$templateName = 'page_StatsReportSelectionForm.tpl.php';	//'siteFormSingle.php';
		
//         $this->setFormFieldsToTemplate();                             
//         $this->template->set( 'formLabels', $this->formLabels );       		
		
		
		return $this->template->fetch( $templateName );
        
    }

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
	          
}

?>