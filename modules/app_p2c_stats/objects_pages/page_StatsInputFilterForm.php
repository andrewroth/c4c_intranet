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
 * class FormProcessor_StatsInputFilter 
 * <pre> 
 * Allows a person to generate a statistics input form
 * </pre>
 * @author CIM Team (hsmit)
 * Date:   24 Oct 2007
 */
 // RAD Tools: FormSingleEntry Page
class  FormProcessor_StatsInputFilter extends PageDisplay_FormProcessor {

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
    const FORM_FIELDS = 'ministry_id|T|,division_id|T|,region_id|T|,location_id|N|,meas_id|N|,freq_id|N|';
    
    /** The list of field types to be displayed in the form */
    // NOTE: if a field isn't displayed, put a '-' for it's entry.
    const FORM_FIELD_TYPES = 'jumplist|Y,jumplist|Y,jumplist|Y,droplist,droplist,droplist';
    
    /** The Multilingual Page Key for this page */
    const MULTILINGUAL_PAGE_KEY = 'FormProcessor_StatsInputFilter';

	//VARIABLES:
	
	/** @var [STRING] The path to the module's root directory. */
	protected $pathModuleRoot;
	
	/** @var [OBJECT] The Viewer Object. */
	protected $viewer;
		
    /** @var [STRING] The initialization data for the dataManager. */
	protected $person_id;
	
	/** @var [STRING] The initialization data for the various Data Access Managers. */
	protected $ministry_id;
	protected $division_id;
	protected $region_id;
	protected $location_id;
	
	/** @var [OBJECT] Data Access managers for various scopes */
	protected $division_manager;
	protected $region_manager;
	protected $location_manager;


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
	 * @param $person_id [INTEGER] Value used to initialize the dataManager
	 * @return [void]
	 */
    function __construct($pathModuleRoot, $viewer, $formAction, $person_id, $ministry_id = '', $division_id = '', $region_id = '') 
    {
        // NOTE: be sure to call the parent constructor before trying to 
        //       use the ->formXXX arrays...
        
        $this->person_id = $person_id;
        $this->ministry_id = $ministry_id;
        $this->division_id = $division_id;
        $this->region_id = $region_id;
                
        $this->viewer = $viewer;

//         if ((!isset($person_id))||($person_id == ''))
//         {
// 	        $this->person_id = $this->getPersonIDfromViewerID();
// 	        $formAction .= '&'.modulep2c_stats::PERSON_ID.'='.$this->person_id;
//         }

// echo ' min/div = '.$ministry_id.', '.$division_id;

			/** Setup droplist values using identifiers received via jumplists **/        
			$this->division_manager = new RowManager_DivisionManager();
			$this->region_manager = new RowManager_StatsRegionManager();
			$this->location_manager = new RowManager_LocationManager();
			if ($ministry_id != '')
			{
// 				echo "MINISTRY";
				$this->division_manager->setMinistryID($ministry_id);
								
				if ($division_id != '')
				{
// 					echo "DIVISION";
					$this->region_manager->setMinistryID($ministry_id);	
					$this->region_manager->setDivisionID($division_id);			
					
					if ($region_id != '')
					{
						$this->location_manager->setMinistryID($ministry_id);	
						$this->location_manager->setDivisionID($division_id);	
						$this->location_manager->setRegionID($region_id);					
					}		
				}
			}
// 			else
// 			{
// 				$this->ministry_id = '1';
// 				$this->division_manager->setMinistryID($this->ministry_id);
// 			}	


        $fieldList = FormProcessor_StatsInputFilter::FORM_FIELDS;
        $fieldDisplayTypes = FormProcessor_StatsInputFilter::FORM_FIELD_TYPES;
        parent::__construct( $formAction, $fieldList, $fieldDisplayTypes  );

        $this->pathModuleRoot = $pathModuleRoot;
        
         $this->dataManager = new RowManager_StatisticManager();
//         $person_manager = new RowManager_PersonManager( $this->person_id );
//         $ministry_manager = new RowManager_MinistryManager( $this->person_id );
        
 //       $this->dataManager->setFieldsOfInterest( $fieldsOfInterest );
         $this->formValues = $this->dataManager->getArrayOfValues();
//echo "form values:<br><pre>".print_r($this->formValues,true)."</pre>";      


        // now initialize the labels for this page
        // start by loading the default field labels for this Module
        $languageID = $viewer->getLanguageID();
        $seriesKey = modulep2c_stats::MULTILINGUAL_SERIES_KEY;
        $pageKey = modulep2c_stats::MULTILINGUAL_PAGE_FIELDS;
        $this->labels = new MultilingualManager( $languageID, $seriesKey, $pageKey );
        
        // then load the page specific labels for this page
        $pageKey = FormProcessor_StatsInputFilter::MULTILINGUAL_PAGE_KEY;
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
        /*[RAD_ADMINBOX_FOREIGNKEY]*/	    
        
//         echo '<pre>'.print_r($this->formValues,true).'</pre>'; 	
        
        // TODO: store settings in the saved form table??			    	        
        
        // store values in table manager object.
/***          $this->dataManager->loadFromArray( $this->formValues ); ***/
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
        //$path = $this->pathModuleRoot.'templates/';
        // Otherwise use the standard Templates for the site:
        $path = SITE_PATH_TEMPLATES;
        
                 // temporarily reset the form values so the defaults show up properly in the jumplists
        $this->formValues[ 'ministry_id' ] = $this->linkValues['ministryJumpLink'].$this->ministry_id;
        $this->formValues[ 'division_id' ] = $this->linkValues['divisionJumpLink'].$this->division_id; 
        $this->formValues[ 'region_id' ] = $this->linkValues['regionJumpLink'].$this->region_id; 
        
        
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
        


        // Insert the date start/end values for the following date fields:
        // example:
            //$this->template->set( 'startYear_[fieldName]', 2000);
            //$this->template->set( 'endYear_[fieldName]', 2010);

                


        /*
         * Add any additional data required by the template here
         */
//         $person_manager = new RowManager_PersonManager( $this->person_id );

         
        /**** Populate drop-lists for filtering which statistic input fields to show on next page ****/
         $jumpLink = $this->linkValues['ministryJumpLink'];
        
        $ministryManager = new RowManager_MinistryManager( );
        $ministryList = new ListIterator( $ministryManager );	//$ministryManager->getListIterator( );
        $ministryArray = $ministryList->getDropListArray( null, $jumpLink );	//added jumplink
        $this->template->set( 'list_ministry_id', $ministryArray );
        
        $jumpLink2 = $this->linkValues['divisionJumpLink'];        
        $divisionManager = $this->division_manager;	// new RowManager_DivisionManager( );
        $divisionList = new ListIterator( $divisionManager );		//$divisionManager->getListIterator( );
        $divisionArray = $divisionList->getDropListArray( null, $jumpLink2 );	//added jumplink
        $this->template->set( 'list_division_id', $divisionArray );
        // echo '<pre>'.print_r($divisionArray,true).'</pre>';
        
        $jumpLink3 = $this->linkValues['regionJumpLink'];        
        $regionManager = $this->region_manager;	//new RowManager_StatsRegionManager( );
        $regionList = new ListIterator( $regionManager );		//$regionManager->getListIterator( );
        $regionArray = $regionList->getDropListArray( null, $jumpLink3 );	//added jumplink
        $this->template->set( 'list_region_id', $regionArray );
        
        $locationManager = $this->location_manager;	//new RowManager_LocationManager( );
        $locationList = $locationManager->getListIterator( );
        $locationArray = $locationList->getDropListArray( );
        $this->template->set( 'list_location_id', $locationArray );  
         
        $measureManager = new RowManager_MeasureTypeManager( );
        $measureList = $measureManager->getListIterator( );
        $measureArray = $measureList->getDropListArray( );
        $this->template->set( 'list_meas_id', $measureArray );
        
        $freqTypeManager = new RowManager_FreqTypeManager( );
        $freqTypeList = $freqTypeManager->getListIterator( );
        $freqTypeArray = $freqTypeList->getDropListArray( );
        $this->template->set( 'list_freq_id', $freqTypeArray );         
              


		// uncomment this line if you are creating a template for this page
		//$templateName = 'page_EditMyInfo.php';
		// otherwise use the generic admin box template
		$templateName = 'siteFormSingle.php';
		
		return $this->template->fetch( $templateName );
        
    }

	          
}

?>