<?php

$toolName = 'modules/app_cim_hrdb/objects_da/AdminManager.php';
$toolPath = Page::findPathExtension( $toolName );
require_once( $toolPath.$toolName);

$toolName = 'modules/app_cim_hrdb/objects_da/AccessManager.php';
$toolPath = Page::findPathExtension( $toolName );
require_once( $toolPath.$toolName);

/**
 * @package cim_hrdb
 */ 
/**
 * class FormProcessor_EditMyInfo 
 * <pre> 
 * Allows a person to edit their hrdb info.
 * </pre>
 * @author CIM Team
 * Date:   06 Apr 2006
 */
 // RAD Tools: FormSingleEntry Page
class  FormProcessor_EditMyInfo extends PageDisplay_FormProcessor {

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
    const FORM_FIELDS = 'person_fname|T|,person_lname|T|,person_email|E|,gender_id|N|,person_phone|T|,person_local_phone|T|<skip>,person_addr|T|,person_city|T|,person_pc|T|,province_id|N|,person_local_addr|T|<skip>,person_local_city|T|<skip>,person_local_pc|T|<skip>,person_local_province_id|N|<skip>';
    
    /** The list of field types to be displayed in the form */
    // NOTE: if a field isn't displayed, put a '-' for it's entry.
    const FORM_FIELD_TYPES = 'textbox||50,textbox||50,textbox||50,droplist,textbox||25,textbox||25,textbox||128,textbox||50,textbox||7,droplist,textbox||128,textbox||50,textbox||7,droplist';
    
    /** The Multilingual Page Key for this page */
    const MULTILINGUAL_PAGE_KEY = 'FormProcessor_EditMyInfo';
    
    // HERE THE INITIAL REG. STATUS IS SET
    const INITIAL_REG_STATUS = 'Incomplete';

	//VARIABLES:
	
	/** @var [STRING] The path to the module's root directory. */
	protected $pathModuleRoot;
	
	/** @var [OBJECT] The Viewer Object. */
	protected $viewer;
		
    /** @var [STRING] The initialization data for the dataManager. */
	protected $person_id;
	
    /** @var [STRING] The initialization data for the dataManager. */
	protected $event_id;	
	
    /** @var [STRING] The initialization data for the dataManager. */
	protected $registration_id;	
	
    /** @var [STRING] The initialization data for the dataManager. */
	protected $campus_id;		
	
	/** @var [BOOLEAN] Whether or not page is located within registration process */
	protected $isInRegProcess;
	
	/** @var [REFERENCE] A reference to the controller object (app_cim_reg) */
//	protected $controller;	


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
    function __construct($pathModuleRoot, $viewer, $formAction, $person_id, $event_id, $campus_id = '', $registration_id = '', $isInRegProcess = false, $selfReg = false) 
    {
        // NOTE: be sure to call the parent constructor before trying to 
        //       use the ->formXXX arrays...
        
        $this->person_id = $person_id;
        $this->event_id = $event_id;
        $this->campus_id = $campus_id;
                
        $this->viewer = $viewer;

//         if ((!isset($person_id))||($person_id == ''))
//         {
// 	        $this->person_id = $this->getPersonIDfromViewerID();
// 	        $formAction .= '&'.modulecim_reg::PERSON_ID.'='.$this->person_id;
//         }
        
        if (($isInRegProcess == true)&&($registration_id == ''))
        {
	         $this->setRegistrationID();	// get registration ID for the rest of the process	         
        		$formAction .= '&'.modulecim_reg::REG_ID.'='.$this->registration_id;

        		// also note that person_id is set above if it is also not set yet
        		if ($person_id == -1) 
        		{
	        		// pass on new person_id to GET parameters
	        		$formAction = str_replace( modulecim_reg::PERSON_ID.'=-1', modulecim_reg::PERSON_ID.'='.$this->person_id, $formAction);
        		}
	        		        		
     	  }
        $fieldList = FormProcessor_EditMyInfo::FORM_FIELDS;
        $fieldDisplayTypes = FormProcessor_EditMyInfo::FORM_FIELD_TYPES;
        parent::__construct( $formAction, $fieldList, $fieldDisplayTypes  );

        $this->pathModuleRoot = $pathModuleRoot;
        
        $this->isInRegProcess = $isInRegProcess;

// To make sure this is not exploited to edit any other person's id.
// If the user has no privileges, this sets the viewer id to be his/her own,
// even if the variable given to it is not the viewer's person id.
// NOTE: anyone with higher previliges can edit any person's info, by simply
// changing the posted variable value.			// NOTE: this code was causing problems in app_cim_reg module

        // Now load the access Priviledge manager of this viewer
//         $this->accessPrivManager = new RowManager_AdminManager( );

//         // Get the person ID
//         $accessManager = new RowManager_AccessManager( );
//         $accessManager->loadByViewerID( $this->viewer->getViewerID( ) );
//         $personID = $accessManager->getPersonID();

//         // Get the permissions the person has.
//         $this->accessPrivManager->loadByPersonID( $personID );

//         if ( !$this->accessPrivManager->isLoaded() ) {
//           $this->person_id=$personID;
// /        }
//End of check.
        
        // figure out the important fields for the dataManager
 //       $fieldsOfInterest = implode(',', $this->formFields);
        
        $this->dataManager = new RowManager_PersonManager( $this->person_id );
 //       $this->dataManager->setFieldsOfInterest( $fieldsOfInterest );
        $this->formValues = $this->dataManager->getArrayOfValues();
//echo "form values:<br><pre>".print_r($this->formValues,true)."</pre>";      


        // now initialize the labels for this page
        // start by loading the default field labels for this Module
        $languageID = $viewer->getLanguageID();
        $seriesKey = modulecim_reg::MULTILINGUAL_SERIES_KEY;
        $pageKey = modulecim_reg::MULTILINGUAL_PAGE_FIELDS;
        $this->labels = new MultilingualManager( $languageID, $seriesKey, $pageKey );
        
        // then load the page specific labels for this page
        $pageKey = FormProcessor_EditMyInfo::MULTILINGUAL_PAGE_KEY;
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
        
        // store values in table manager object.
        $this->dataManager->loadFromArray( $this->formValues );
        
        // now update the DB with the values
        if (!$this->dataManager->isLoaded()) {
//	        echo "PERSONID = ".$this->person_id;
	         $this->dataManager->setPersonID($this->person_id);
            $this->dataManager->createNewEntry(true);
            
            $this->assignCampus($this->person_id);
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

                


        /*
         * Add any additional data required by the template here
         */
        $provinceManager = new RowManager_ProvinceManager( );
        $provinceList = $provinceManager->getListIterator( );
        $provinceArray = $provinceList->getDropListArray( );
        $this->template->set( 'list_province_id', $provinceArray );
        $this->template->set( 'list_person_local_province_id', $provinceArray );
        // echo '<pre>'.print_r($provinceArray,true).'</pre>';
        //Gender list.
        $genderManager = new RowManager_GenderManager( );
        $genderList = $genderManager->getListIterator( );
        $genderArray = $genderList->getDropListArray( );
        $this->template->set( 'list_gender_id', $genderArray );


		// uncomment this line if you are creating a template for this page
		//$templateName = 'page_EditMyInfo.php';
		// otherwise use the generic admin box template
		$templateName = 'siteFormSingle.php';
		
		return $this->template->fetch( $templateName );
        
    }

    // set registration ID by retrieving from the database (if required for rest of registration process)
    // also creates new registration record if required
    protected function setRegistrationID()
     {
        // get registration ID for the rest of the reg. process
        $regs = new RowManager_RegistrationManager();
        $people = new RowManager_PersonManager();
        $people->setPersonID($this->person_id);
        $events = new RowManager_EventManager();
        $events->setEventID($this->event_id);
        
        $personRegs = new MultiTableManager();
        $personRegs->addRowManager($regs);
        $personRegs->addRowManager($people, new JoinPair( $regs->getJoinOnPersonID(), $people->getJoinOnPersonID()));
        $personRegs->addRowManager($events, new JoinPair( $regs->getJoinOnEventID(), $events->getJoinOnEventID()));
        
        $regsList = $personRegs->getListIterator( );
        $regsArray = $regsList->getDataList();		
//        echo "<pre>".print_r($regsArray,true)."</pre>"; 
          
	
         reset($regsArray);
        	foreach(array_keys($regsArray) as $k)
			{
				$registration = current($regsArray);	
				$this->registration_id = $registration['registration_id'];	// NOTE: should only be one reg. per person per event (ENFORCE??)		
				
				next($regsArray);	
			}
			
			// create new registration record for this person (since none exists for current person-event combo)
			if (!isset($this->registration_id))
			{
				// get status id for INITIAL_REG_STATUS
			  $regStatus = new RowManager_StatusManager();
			  $regStatus->setStatusDesc(FormProcessor_EditMyInfo::INITIAL_REG_STATUS);		
	        $regStatusList = $regStatus->getListIterator( );
	        $regStatusArray = $regStatusList->getDataList();			          
		      
	        $statusID = 0;
	         reset($regStatusArray);
	        	foreach(array_keys($regStatusArray) as $k)
				{
					$status = current($regStatusArray);	
					$statusID = $status['status_id'];	// NOTE: should only be one reg. per person per event (ENFORCE??)		
					
					next($regStatusArray);	
				}			
				
				// get the MAX(registration_id)... need to determine what insertion registration ID will be (used in confirmNum)
				$allRegs = new MultiTableManager();
				$regs2 = new RowManager_RegistrationManager();
				$allRegs->addRowManager($regs2);
				$allRegs->setFunctionCall('MAX','registration_id');
				$allRegs->ignoreFields();	// only leave MAX(registration_id) in values to be returned
				
	         $allRegsList = $allRegs->getListIterator( );
	         $allRegsArray = $allRegsList->getDataList();

	         
	         $maxID = -1;
		      reset($allRegsArray);
		     	foreach(array_keys($allRegsArray) as $k)
				{
					$regRecord = current($allRegsArray);	
					$maxID = $regRecord['MAX(registration_id)'];
					if ($maxID > -1)
					{
						break;	// get out of the loop once MAX is found
					}	
					
					next($allRegsArray);	
				}	        
					
				// compile values needed for new registration record
				$regValues = array();
				$nextRegID = $maxID+1;
				$regValues['event_id'] = $this->event_id;
				
				// check if a new person record needs to be created
				if ($this->person_id == -1)
				{
					$this->person_id = $this->getNextPersonID();	// assumes processData() will properly use this value for insertion
					
					// create empty person record to start off... since otherwise FK constraint on cim_reg_registration is NOT satisfied
				  $personManager = new RowManager_PersonManager( $this->person_id );
		        $personManager->loadFromArray( $this->formValues );
			     $personManager->setPersonID($this->person_id);
		        $personManager->createNewEntry(true);
		            
		        //$this->assignCampus($this->person_id);	-- save this step for when info properly entered into form				
				}
				$regValues['person_id'] = $this->person_id;
								
				
				$timestamp = strtotime("now");
        		$date = date('Y-m-d H:i:s', $timestamp);  // == NOW() : to bad I could pass that as non-string...    
				$regValues['registration_date'] = $date;	// set date-time to current date-time
				
				
				$regValues['registration_confirmNum'] = 'E'.$this->event_id.'R'.$nextRegID.'C'.$this->campus_id;
				$regValues['registration_status'] = $statusID;
				
				 // store values in table manager object.
		        $regs->loadFromArray( $regValues );
		        
		        // set primary key to use for update (if maxID found)
			      if ($maxID > -1)
			      {
			      	$regValues['registration_id'] = $nextRegID;
			      	$regs->setRegID($regValues['registration_id']);
		      	}
		        
		        // now update the DB with the values
		        if (!$regs->isLoaded()) 
		        {
		            $regs->createNewEntry(true);	// allow primary key to be set (in case auto_increment is off)
		            $this->registration_id = $nextRegID;
		        }
		        // TODO: figure out how to show error if no registration made, or updated (IF it is even possible now...)
	        }
        }
				
			
        // retrieve next person ID for insertion
        protected function getNextPersonID()
        {
				// get the MAX(person_id)... need to determine what insertion person ID will be (used to create new registration record)
				$person = new RowManager_PersonManager();
				$persons = new MultiTableManager();
				$persons->addRowManager($person);
				$persons->setFunctionCall('MAX','person_id');
				$persons->ignoreFields();	// only leave MAX(person_id) in values to be returned
				
	         $personsList = $persons->getListIterator( );
	         $personsArray = $personsList->getDataList();

	         
	         $maxID = -1;
		      reset($personsArray);
		     	foreach(array_keys($personsArray) as $k)
				{
					$personRecord = current($personsArray);	
					$maxID = $personRecord['MAX(person_id)'];
					if ($maxID > -1)
					{
						break;	// get out of the loop once MAX is found
					}	
					
					next($personsArray);	
				}	
				return $maxID+1;
			}	  
			
			// create a campus assignment record for the new person entry
			protected function assignCampus($personID)
			{
				if ((isset($this->campus_id)&&($this->campus_id != '')))
				{
					$campusAssign = new RowManager_AssignmentsManager();
					$campusAssign->setPersonID($personID);
					$campusAssign->setCampusID($this->campus_id);
					
				   $updateValues = array();
				   $updateValues['person_id'] = $personID;    
				   $updateValues['campus_id'] = $this->campus_id;	
	        
	            // Store values in AssignmentsManager object
	            $campusAssign->loadFromArray( $updateValues );
	//              echo "<pre>".print_r($updateValues ,true)."</pre>";          
	            
	            // store new information
	             $campusAssign->createNewEntry();
             }
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
