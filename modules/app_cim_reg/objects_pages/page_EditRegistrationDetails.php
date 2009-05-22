<?php
/**
 * @package cim_reg
 */ 
 
$toolName = 'modules/app_cim_hrdb/objects_da/ProvinceManager.php';
$toolPath = Page::findPathExtension( $toolName );
require_once( $toolPath.$toolName);

$toolName = 'modules/app_cim_hrdb/objects_da/GenderManager.php';
$toolPath = Page::findPathExtension( $toolName );
require_once( $toolPath.$toolName);

/**
 * class page_EditCampusRegistrations 
 * <pre> 
 * Used to manage registrations for a particular event-campus combination.
 * </pre>
 * @author Russ Martin
 * Date:   06 Jul 2007
 */
class  page_EditRegistrationDetails extends PageDisplay_FormProcessor {	//_DisplayList

	//CONSTANTS:
	
	/** The list of fields to be displayed */
	 const DISPLAY_FIELDS = 'registration_status'; //'scholarship_desc,scholarship_desc,scholarship_sourceAcct,scholarship_amount,form_name';	//'event_basePrice, pricerules_desc,pricerules_discount,'
// 	 .'scholarship_amount,scholarship_sourceDesc,'
// 	 .'cashtransaction_amtPaid,cashtransaction_recd,cashtransaction_staffName,'
// 	 .'cctransaction_amount,cctransaction_processed,'
// 	 .'status_desc,<balance_owing>,'
// 	 .'person_fname,person_lname,campus_desc,person_email,person_gender,'
// 	 .'person_local_addr,person_local_city,person_local_province_id,person_local_pc,person_local_phone,'
// 	 .'person_addr,person_city,province_id,person_pc,person_phone,'
// 	 .'event_desc,'
// 	 .'<DO WE NEED deposit type ???? sort of ambiguous if both CC and Cash used>'
// 	 .'cim_reg_fields,cim_reg_fieldvalues,'
// 	 .'scholarship_sourceDesc,scholarship_sourceAcct,scholarship_amount,<delete>';

	 const FORM_FIELD_TYPES = 'droplist';//'textbox,textbox,textbox,textbox,hidden';
	 const FORM_FIELDS = 'registration_status|N|';//'scholarship_desc|T|,scholarship_desc|T|,scholarship_sourceAcct|T|,scholarship_amount|T|,form_name|T|<skip>';//,scholarship_id|T|<skip>';
	 
	 //cashtransaction_recd,cashtransaction_staffName,status_desc';
	 // also payment_type = CASH/CC; also paid? = cctransaction_processed or cashtransaction_recd
    
    /** The Multilingual Page Key for labels on this page */
    const MULTILINGUAL_PAGE_KEY = 'page_EditRegistrationDetails';
    

	//VARIABLES:
	
	/** @var [OBJECT] The viewer object. */
	protected $viewer;
	
    /** @var [STRING] The path to this module's root directory. */
	protected $pathModuleRoot;
	
	/** @var [INTEGER] Foreign Key needed by Data Manager */
//	protected $event_id;
	
	/** @var [INTEGER] Foreign Key needed by Data Manager */
//	protected $campus_id;	
	
	/** @var [INTEGER] Foreign Key needed by Data Manager */
	protected $reg_id;	
	
	/** @var [OBJECT] Stores a reference to the app. controller object */
//	protected $_controller;		
	
	/** @var [ARARY] Stores the registrant's personal data*/
	protected $person_info;			
	
	/** @var [INTEGER] Stores the currently to-be-updated scholarship_id*/
	protected $scholarship_id;	
	
	/** @var [INTEGER] Stores the currently to-be-updated cash transaction id*/
	protected $cashtrans_id;	
	
	/** @var [INTEGER] Stores the currently to-be-updated cc transaction id*/
	protected $cctrans_id;		
	
	
	/** @var [INTEGER] Stores the currently to-be-updated person id*/
	protected $person_id;			
	
	/** @var [INTEGER] Stores the currently to-be-updated field values id*/
	protected $fieldvalues_id;			
	
	/** @var [INTEGER] Stores the currently to-be-updated fields id*/
	protected $fields_id;	
	
		
		/** @var [OBJECT] Stores a reference to active sub-page object */
	protected $active_subPage;		
	
		/** @var [OBJECT] Stores a reference to valid sub-page object */
	protected $scholarship_subPage;	

		/** @var [OBJECT] Stores a reference to valid sub-page object */
	protected $cashTrans_subPage;
	
		/** @var [OBJECT] Stores a reference to valid sub-page object */	
	protected $ccTrans_subPage;
	
			/** @var [OBJECT] Stores a reference to valid sub-page object */	
	protected $fieldValues_subPage;				
	
	/** @var [STRING] Data sorting parameter passed around */
	protected $sortBy;	
	
	/** @var [STRING] URLs for form submissions*/
	protected $formAction;
	protected $scholarship_formAction;	
	protected $cashTrans_formAction;	
	protected $ccTrans_formAction;	
	protected $fieldValues_formAction;					
	
	/** @var [STRING] name of the sub-page form being submitted*/
	protected $formName;		
	
	/** @var [INTEGER] The initilization value for the listManager. */
//	protected $managerInit;
/* no List Init Variable defined for this DAObj */
		
	
	//CLASS CONSTRUCTOR
	//************************************************************************
	/**
	 * function __construct
	 * <pre>
	 * Initialize the object.
	 * </pre>
	 * @param $pathModuleRoot [STRING] The path to the module's root dir.
	 * @param $viewer [OBJECT] The viewer object.
	 * @param $sortBy [STRING] Field data to sort listManager by.
	 * @param $reg_id [INTEGER] The ID of the registration whose details to show
	 * @param $formAction [STRING]  the form action to take
     * @param &$controller [OBJECT] *Reference* to controller object used to init. page construction (REMOVED)
	 * @return [void]
	 */
    function __construct($pathModuleRoot, $viewer, $sortBy, $reg_id, $event_id, $campus_id, $scholarship_id='', $cashtrans_id='', $cctrans_id='', $formAction, $scholarship_formAction, $cashTrans_formAction, $ccTrans_formAction, $fieldValues_formAction, $personID='', $fieldvaluesID='', $fieldsID='' ) 
    {	    
	     $fieldList = page_EditRegistrationDetails::FORM_FIELDS;
        $fieldTypes = page_EditRegistrationDetails::FORM_FIELD_TYPES;
        $displayFields = page_EditRegistrationDetails::DISPLAY_FIELDS;
        parent::__construct($formAction,  $fieldList, $displayFields ); 
//        parent::__construct($viewer, $formAction, $sortBy, $fieldList, $fieldTypes, $displayFields );
        
//        parent::__construct( page_EditRegistrationDetails::DISPLAY_FIELDS );
        
//        $this->_controller = $controller;		// store reference to app. controller for later use
        
        $this->pathModuleRoot = $pathModuleRoot;
        $this->viewer = $viewer;
        $this->sortBy = $sortBy;
        $this->formAction = $formAction;
        $this->scholarship_formAction = $scholarship_formAction;
        $this->cashTrans_formAction = $cashTrans_formAction;
        $this->ccTrans_formAction = $ccTrans_formAction;
        $this->fieldValues_formAction = $fieldValues_formAction;        
 
               
        $this->event_id = $event_id;
        $this->campus_id = $campus_id; 
        $this->reg_id = $reg_id; 
        
        if ($scholarship_id != '') 
        {
	        $this->scholarship_id = $scholarship_id;
        }
        
        if ($cashtrans_id != '') 
        {
	        $this->cashtrans_id = $cashtrans_id;
        }
        
        if ($cctrans_id != '') 
        {
	        $this->cctrans_id = $cctrans_id;
        }       
        
        // just let these be empty if they are passed as empty
        $this->person_id = $personID;
        $this->fieldvalues_id = $fieldvaluesID;
        $this->fields_id = $fieldsID; 
                        
//        $dataAccessObject = new RowManager_RegistrationManager();
//        $dataAccessObject->setSortOrder( $sortBy );
//        $this->listManager = new RegistrationList( $sortBy );
//        $this->listManager = $dataAccessObject->getListIterator();
        
        
        $registration = new RowManager_RegistrationManager();  
//        $registration->setSortOrder( $sortBy );
        $registration->setRegID($this->reg_id);
        $person = new RowManager_PersonManager();

       
     	  // join 2 tables together: cim_reg_registration & cim_hrdb_person
        $regPerson = new MultiTableManager();
        $regPerson->addRowManager($person);			
        $regPerson->addRowManager( $registration, new JoinPair( $person->getJoinOnPersonID(), $registration->getJoinOnPersonID()));                  
//        $campusRegs->setPrimaryKeyField( 'registration_id' );
        
   //     $multiTableManager2->setLabelTemplate('viewer_userID', '[viewer_userID]');
        $this->listManager = $regPerson->getListIterator(); 
        $regsArray = $this->listManager->getDataList();	
//         echo "<pre>".print_r($this->listManager,true)."</pre>";
//        echo "<pre>".print_r($regsArray,true)."</pre>";    

			// create references to sub-page objects
			$this->scholarship_subPage = new FormProcessor_EditRegistrationScholarshipList( $this->pathModuleRoot, $this->viewer, $this->scholarship_formAction, $this->sortBy,  $this->scholarship_id , $this->reg_id);
			$this->cashTrans_subPage = new FormProcessor_EditRegistrationCashTransactionsList( $this->pathModuleRoot, $this->viewer, $this->cashTrans_formAction, $this->sortBy,  $this->cashtrans_id , $this->reg_id);
			$this->ccTrans_subPage = new FormProcessor_EditRegistrationCCTransactionsList( $this->pathModuleRoot, $this->viewer, $this->ccTrans_formAction, $this->sortBy,  $this->cctrans_id , $this->reg_id);
			$this->fieldValues_subPage = new FormProcessor_EditFieldValues( $this->pathModuleRoot, $this->viewer, $this->ccTrans_formAction,  $this->person_id , $this->event_id, $this->fieldvalues_id, $this->fields_id, $this->reg_id, true);

      
         // now initialize the labels for this page
         // start by loading the default field labels for this Module
         $languageID = $viewer->getLanguageID();
         $seriesKey = modulecim_reg::MULTILINGUAL_SERIES_KEY;
         $pageKey = modulecim_reg::MULTILINGUAL_PAGE_FIELDS;
         $this->labels = new MultilingualManager( $languageID, $seriesKey, $pageKey );
         
         // then load the page specific labels for this page
         $pageKey = page_EditRegistrationDetails::MULTILINGUAL_PAGE_KEY;
         $this->labels->loadPageLabels( $pageKey );
         
         $this->labels->setSeriesKey( SITE_LABEL_SERIES_SITE );
         $this->labels->loadPageLabels( SITE_LABEL_PAGE_FORM_LINKS );
         
    }

    //************************************************************************
	/**
	 * function loadFromForm
	 * <pre>
	 * Loads the data from the submitted form. Because this page is made up of 
	 * sub-pages we just need to figure out the appropriate loadFromForm() call
	 * </pre>
	 * Precondition: sub-page objects must be initialized
	 * @return [void]
	 */
    function loadFromForm() 
    {	    	    
	    $this->formName = $_REQUEST['form_name']; 	    
	   
//	   echo 'Inside load_from_form of main page: <pre>'.print_r($this->formValues,true).'</pre><br>';	   
	   
		switch($this->formName) {
			
			case 'scholarshipForm':
				$this->active_subPage = $this->scholarship_subPage;
				break;
			case 'cashTransForm':
				$this->active_subPage = $this->cashTrans_subPage;	 
				break;
			case 'ccTransForm':
				$this->active_subPage = $this->ccTrans_subPage;	
				break;
			case 'fieldValuesForm':
				$this->active_subPage = $this->fieldValues_subPage;	
				break;	
			case 'regStatusForm':
				$this->active_subpage = null;
				break;			
			default:
				die('VALID FORM NAME **NOT** FOUND; name = '.$this->formName);
		} 
		
		if ($this->active_subPage == null)
	   {    
			parent::loadFromForm();   
		}
		else
		{
			$this->active_subPage->loadFromForm(); 
		}      
       
    } // end loadFromForm()
    
    
    //************************************************************************
	/**
	 * function isDataValid
	 * <pre>
	 * Verifies the returned data is valid. Because this page is made up of 
	 * sub-pages we just need to figure out the appropriate isDataValid() call
	 * </pre>
	 * @return [BOOL]
	 */
    function isDataValid() 
    {      
	    if ($this->active_subPage == null)
	    {
		    $isValid = parent::isDataValid();
	    }
	    else
	    {
      	 $isValid = $this->active_subPage->isDataValid();  
   	 } 
       
      // now return result
      return $isValid;        
    }
    
    
    
    //************************************************************************
	/**
	 * function processData
	 * <pre>
	 * Processes the data for this form. Because this page is made up of 
	 * sub-pages we just need to figure out the appropriate processData() call
	 * on a sub-page.
	 * </pre>
	 * Precondition: sub-page objects must be initialized
	 * @return [void]
	 */
    function processData()
    { 

	    if ($this->active_subPage == null)
	    {
		         // save the value of the Primary Key(s)
				$this->formValues[ 'registration_id' ] = $this->reg_id;
				$this->formValues[ 'registration_status' ] = $_POST['registration_status'];
		     /*[RAD_ADMINBOX_FOREIGNKEY]*/
		   
		         
	         // Store values in dataManager object
	         $regsManager = new RowManager_RegistrationManager($this->reg_id);
	         $regsManager->loadFromArray( $this->formValues );
	         $regsManager->updateDBTable();		         

	    }
	    else
	    {	    
 			 $this->active_subPage->processData(); 
		 } 
        
    } // end processData()
    

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
	 * function getHTML
	 * <pre>
	 * This method returns the HTML data generated by this object.
	 * </pre>
	 * @return [STRING] HTML Display data.
	 */
    function getHTML() 
    {   
        // Make a new Template object
        //$this->pathModuleRoot.'templates/';
        // Replace $path with the following line if you want to create a
        // template tailored for this page:
        $path = $this->pathModuleRoot.'templates/';
        
        // store the link values
        // $this->linkValues[ 'view' ] = 'add/new/href/data/here';
        
        // store the link labels
        $this->linkLabels[ 'add' ] = $this->labels->getLabel( '[Add]' );
        $this->linkLabels[ 'edit' ] = $this->labels->getLabel( '[Edit]' );
        $this->linkLabels[ 'del'  ] = $this->labels->getLabel( '[Delete]' );
        $this->linkLabels[ 'cont' ] = $this->labels->getLabel( '[Continue]');
        // $this->linkLabels[ 'view' ] = 'new link label here';
        

        
//         $adminLink = $this->linkValues[ 'adminHome' ];
//         $this->template->set('adminLink', $adminLink );




		  // get pricing info
		  
		  // get base price for event participation
	     $event = new RowManager_EventManager($this->event_id);
        $eventBasePrice = $event->getEventBasePrice();
                
        // get price rules for specific event
        $priceRules = new RowManager_PriceRuleManager();
        $priceRules->setEventID($this->event_id);
        $ruleManager = $priceRules->getListIterator(); 
        $priceRulesArray = $ruleManager->getDataList();	
 	//	echo "<pre>".print_r($priceRulesArray,true)."</pre>";

        // array storing the rules applied to a particular registrant
        $rulesApplied = array();	    
        	    
        $priceGetter = new FinancialTools();
        $basePriceForThisGuy = $priceGetter->getBasePriceForRegistrant( $this->reg_id, $this->event_id, $this->campus_id, $eventBasePrice, $priceRulesArray, $rulesApplied );



		  // get Personal Info
		  $registration = new RowManager_RegistrationManager();  
        $registration->setRegID($this->reg_id);
        $person = new RowManager_PersonManager();
        $assignment = new RowManager_AssignmentsManager();	// assigns campus to person
        $campus = new RowManager_CampusManager();
     //   $campus->setCampusID($this->campus_id);	  		  		  
		  
		  $personalInfo = new MultiTableManager();
        $personalInfo->addRowManager($person);	
        $personalInfo->addRowManager( $assignment, new JoinPair( $person->getJoinOnPersonID(), $assignment->getJoinOnPersonID()) );
        $personalInfo->addRowManager( $campus, new JoinPair( $campus->getJoinOnCampusID(), $assignment->getJoinOnCampusID()) );
        $personalInfo->addRowManager( $registration, new JoinPair( $registration->getJoinOnPersonID(), $person->getJoinOnPersonID()) );
        
        $this->listManager = $personalInfo->getListIterator(); 
        $personInfoArray = $this->listManager->getDataList();	
//         echo "<pre>".print_r($this->listManager,true)."</pre>";
//        echo "<pre>".print_r($personInfoArray,true)."</pre>";    

        // cycle through registrations and store balance owing for each
        $this->owingArray = array();
        $priceGetter = new FinancialTools();
        
        reset($personInfoArray);
        	foreach(array_keys($personInfoArray) as $k)
			{
				$personData = current($personInfoArray);
				
				$this->person_id = $personData['person_id'];
					
				$this->person_info['person_fname'] = '';
				$this->person_info['person_fname'] = $personData['person_fname'];
				$this->person_info['person_lname'] = '';
				$this->person_info['person_lname'] = $personData['person_lname'];
				$this->person_info['campus_desc'] = '';
				$this->person_info['campus_desc'] = $personData['campus_desc'];
				$this->person_info['person_email'] = '';	
				$this->person_info['person_email'] = $personData['person_email'];	
				$this->person_info['gender_id'] = '';	
				$this->person_info['gender_id'] = $personData['gender_id'];	
				
				$this->person_info['person_local_addr'] = '';
				$this->person_info['person_local_addr'] = $personData['person_local_addr'];
				$this->person_info['person_local_city'] = '';
				$this->person_info['person_local_city'] = $personData['person_local_city'];
				$this->person_info['person_local_province_id'] = '';
				$this->person_info['person_local_province_id'] = $personData['person_local_province_id'];	
				$this->person_info['person_local_pc'] = '';
				$this->person_info['person_local_pc'] = $personData['person_local_pc'];
				$this->person_info['person_local_phone'] = '';
				$this->person_info['person_local_phone'] = $personData['person_local_phone'];
				
				$this->person_info['person_addr'] = '';
				$this->person_info['person_addr'] = $personData['person_addr'];
				$this->person_info['person_city'] = '';
				$this->person_info['person_city'] = $personData['person_city'];
				$this->person_info['province_id'] = '';
				$this->person_info['province_id'] = $personData['province_id'];	
				$this->person_info['person_pc'] = '';
				$this->person_info['person_pc'] = $personData['person_pc'];	
				$this->person_info['person_phone'] = '';
				$this->person_info['person_phone'] = $personData['person_phone'];	
				
				$this->person_info['registration_status'] = $personData['registration_status'];		
				
				next($personInfoArray);

			}
			
			 $this->linkValues["EditPersonInfo"] .= $this->person_id;
			 
			$this->prepareTemplate( $path );
			
			// set current registration status ID
			$this->template->set('currentRegStatus', $this->person_info['registration_status']);
			
			// get list of registration statuses
			$regStatuses = new RowManager_StatusManager();
			$regStatusesList = $regStatuses->getListIterator();
			$regStatusesArray = $regStatusesList->getDataList();
			
			$statusList = array();
			reset($regStatusesArray);
			foreach (array_keys($regStatusesArray) as $k)
			{
				$record = current($regStatusesArray);
				$statusList[key($regStatusesArray)] = $record['status_desc'];
				
				next($regStatusesArray);
			}
// 						echo 'status list = <pre>'.print_r($statusList, true).'</pre>';
			
			// set registration status information
			$this->template->set('statusFormAction', $this->formAction);
			$this->template->set('statusList', $statusList);
			$this->template->set('statusButtonText', 'Update');
						
			
			// set some variables calculated previously; placed here because I need to get PERSON_ID for link
			// which had to be set before prepareTemplate(), which has to be executed BEFORE setting variables...
        $this->template->set('eventBasePrice', $eventBasePrice );
        $this->template->set('priceRules', $rulesApplied );
        $this->template->set('basePriceForThisGuy', $basePriceForThisGuy );
		  //$priceGetter->calcBalanceOwing($this->reg_id);		// NOT NEEDED BECAUSE TOTALS CALCULATED			
							   
			 $this->template->set('person', $this->person_info );

			
			 
		  // get provinces and genders
		  $provinces = new RowManager_ProvinceManager();
        $provinceList = $provinces->getListIterator(); 
        $provincesArray = $provinceList->getDataList();	
//        echo "<pre>".print_r($provincesArray,true)."</pre>";    
         
         $province_info = array();
         reset($provincesArray);
        	foreach(array_keys($provincesArray) as $k)
			{
				$province = current($provincesArray);	
				$province_info[$province['province_id']] = $province['province_desc'];		
				
				next($provincesArray);

			}
			$this->template->set('list_province_id', $province_info );    
			
		  $genders = new RowManager_GenderManager();
        $genderList = $genders->getListIterator(); 
        $genderArray = $genderList->getDataList();	
//        echo "<pre>".print_r($genderArray,true)."</pre>";    
         
         $gender_info = array();
         reset($genderArray);
        	foreach(array_keys($genderArray) as $k)
			{
				$gender = current($genderArray);	
				$gender_info[$gender['gender_id']] = $gender['gender_desc'];		
				
				next($genderArray);

			}
			$this->template->set('list_gender_id', $gender_info );     		          
			
        // send in scholarships table, cash transactions table, and credit card transactions table
        $this->template->set('scholarshipsAdminBox', $this->generateScholarshipsTable() );
		  $this->template->set('cashTransAdminBox', $this->generateCashTransactionsTable() );
		  $this->template->set('ccTransAdminBox', $this->generateCCTransactionsTable() );
		  	
		  
		  // get scholarship total
		  $scholarships = new RowManager_ScholarshipAssignmentManager();
		  $scholarships->setRegID($this->reg_id);
		  $scholarshipTotal = new MultiTableManager();
		  $scholarshipTotal->addRowManager($scholarships);
		  $scholarshipTotal->setFunctionCall('SUM','scholarship_amount');
		  $scholarshipTotal->setGroupBy('registration_id');
		  
	     $scholarshipsList = $scholarshipTotal->getListIterator(); 
        $scholarshipsArray = $scholarshipsList->getDataList();		  
	
         reset($scholarshipsArray);
        	foreach(array_keys($scholarshipsArray) as $k)
			{
				$scholarshp = current($scholarshipsArray);	
				$scholarship_total = $scholarshp['SUM(scholarship_amount)'];		
				
				next($scholarshipsArray);

			}
			if (!isset($scholarship_total))
			{
				$scholarship_total = 0;
			}				
			$this->template->set('scholarshipTotal', $scholarship_total );
			
			
			// get cash total
		  $cashTrans = new RowManager_CashTransactionManager();
		  $cashTrans->setRegID($this->reg_id);
		  $cashTrans->setReceived(true);
		  $cashTransTotal = new MultiTableManager();
		  $cashTransTotal->addRowManager($cashTrans);		  
		  $cashTransTotal->setFunctionCall('SUM','cashtransaction_amtPaid');
		  $cashTransTotal->setGroupBy('reg_id');
		  
	     $cashTransList = $cashTransTotal->getListIterator(); 
        $cashTransArray = $cashTransList->getDataList();		  
	
         reset($cashTransArray);
        	foreach(array_keys($cashTransArray) as $k)
			{
				$cash_trans = current($cashTransArray);	
				$cash_total = $cash_trans['SUM(cashtransaction_amtPaid)'];		
				
				next($cashTransArray);

			}
			if (!isset($cash_total))
			{
				$cash_total = 0;
			}
			$this->template->set('cashTotal', $cash_total );
			
			// get cash owed
		  $cashOwed = new RowManager_CashTransactionManager();
		  $cashOwed->setRegID($this->reg_id);
		  $cashOwed->setReceived(false);
		  $cashOwedTotal = new MultiTableManager();
		  $cashOwedTotal->addRowManager($cashOwed);
		  $cashOwedTotal->setFunctionCall('SUM','cashtransaction_amtPaid');
		  $cashOwedTotal->setGroupBy('reg_id');
		  
	     $cashOwedList = $cashOwedTotal->getListIterator(); 
        $cashOwedArray = $cashOwedList->getDataList();		  
	
         reset($cashOwedArray);
        	foreach(array_keys($cashOwedArray) as $k)
			{
				$cash_owed = current($cashOwedArray);	
				$cash_owing = $cash_owed['SUM(cashtransaction_amtPaid)'];		
				
				next($cashOwedArray);

			}
			if (!isset($cash_owing))
			{
				$cash_owing = 0;
			}
			$this->template->set('cashOwed', $cash_owing );			
	
			
		  // get credit card total
		  $ccTrans = new RowManager_CreditCardTransactionManager();
		  $ccTrans->setProcessed(true);
		  $ccTrans->setRegID($this->reg_id);
		  $ccTransTotal = new MultiTableManager();
		  $ccTransTotal->addRowManager($ccTrans);
		  $ccTransTotal->setFunctionCall('SUM','cctransaction_amount');
		  $ccTransTotal->setGroupBy('reg_id');
		  
	     $ccTransList = $ccTransTotal->getListIterator(); 
        $ccTransArray = $ccTransList->getDataList();		  
	
         reset($ccTransArray);
        	foreach(array_keys($ccTransArray) as $k)
			{
				$cc_trans = current($ccTransArray);	
				$cc_total = $cc_trans['SUM(cctransaction_amount)'];		
				
				next($ccTransArray);

			}
			if (!isset($cc_total))
			{
				$cc_total = 0;
			}			
			$this->template->set('ccTotal', $cc_total );	
			

			// TODO??: get credit card transactions NOT processed
					
			
			// set form for editing registration-specific form fields' values
			$this->template->set('eventFieldsFormSingle', $this->generateFieldValuesForm() );
			

						        
        // store any additional link Columns
        // example:
            //$title = $this->labels->getLabel( '[title_groups]');
            //$columnLabel = $this->labels->getLabel( '[groups]');
            //$link = $this->linkValues[ 'groups' ];
            //$fieldName = 'accessgroup_id';
            //$this->addLinkColumn( $title, $columnLabel, $link, $fieldName);

        
        // store the page labels
        // NOTE: use this location to update any label tags ...
        // example:
            // $name = $user->getName();
            // $this->labels->setLabelTag( '[Title]', '[userName]', $name);
                    
        
        // store the Row Manager's XML Node Name
//        $this->template->set( 'rowManagerXMLNodeName', RowManager_RegistrationManager::XML_NODE_NAME );
		  $this->template->set( 'rowManagerXMLNodeName', MultiTableManager::XML_NODE_NAME );
        
        // store the primary key field name for the data being displayed
        $this->template->set( 'primaryKeyFieldName', 'registration_id');
        
               // Load over-payment message, if necessary
       if ($this->ccTrans_subPage->hasOverPaid())
       {
       	$this->template->set( 'attemptedOverpayment', true );
    	 } 
          
		  
		  // TODO: somehow merge the primary join with the balance owing join.... for efficiency

        /*
         *  Set up any additional data transfer to the Template here...
         */
 //       $this->template->set( 'dataList', $this->dataList);
   
        $templateName = 'page_EditRegistrationDetails.tpl.php';
		// if you are creating a custom template for this page then 
		// replace $templateName with the following:
		//$templateName = 'page_EditCampusRegistrations.php';
		
		return $this->template->fetch( $templateName );
        
    }
    
   //************************************************************************
	/**
	 * function setLinks
	 * <pre>
	 * Sets the value of the linkValues array.
	 * </pre>
	 * @param $links [ARRAY] Array of Link Values
	 * @return [void]
	 */
    function setLinks($links, $scholarshipLinks, $cashTransLinks, $ccTransLinks) 
    {
	    parent::setLinks($links);
       $this->scholarship_subPage->setLinks($scholarshipLinks);
       $this->cashTrans_subPage->setLinks($cashTransLinks);
       $this->ccTrans_subPage->setLinks($ccTransLinks);
    }
    
    //************************************************************************
	/**
	 * function setFormAction
	 * <pre>
	 * Sets the value of the Form Action Link.
	 * </pre>
	 * @param $link [STRING] The HREF link for the continue link
	 * @return [void]
	 */
    function setFormAction($scholarshipLinks, $cashTransLinks, $ccTransLinks, $fieldValLinks) 
    {
	    //parent::setFormAction($link);
       $this->scholarship_subPage->setFormAction($scholarshipLinks);
       $this->cashTrans_subPage->setFormAction($cashTransLinks);
       $this->ccTrans_subPage->setFormAction($ccTransLinks);
       $this->fieldValues_subPage->setFormAction($fieldValLinks);	    
    }    
  
    
    // returns html of a table with a listing of all the scholarships for
    // the currently-selected participant
    //
    private function generateScholarshipsTable()
    {
			// $subPage = $this->_controller->loadEditRegistrationScholarshipList(); 
			$content = $this->scholarship_subPage->getHTML(); 
         
         return $content;
    }    
    
        // returns html of a table with a listing of all the cash transactions for
    // the currently-selected participant
    //
    private function generateCashTransactionsTable()
    {
	      //$content = $this->_controller->loadEditRegistrationCashTransactionsList();
			$content = $this->cashTrans_subPage->getHTML(); 
         
         return $content;
    } 
    
        // returns html of a table with a listing of all the credit card transactions for
    // the currently-selected participant
    //
    private function generateCCTransactionsTable()
    {
//			$content = $this->_controller->loadEditRegistrationCCTransactionsList(); 
			$content = $this->ccTrans_subPage->getHTML(); 
         
         return $content;
    } 
    
    
	// this function generates the field values form 
	//   used for the 'edit registration details' page
	// that shows everything you want to know about somebody
	//
	private function generateFieldValuesForm()	//(&$form)
	{  
//		echo "in Generate Form: regdetails<BR>";
//		$content = $this->_controller->loadEditRegistrationFieldValuesForm();
		$content = $this->fieldValues_subPage->getHTML();	
		
//		echo $content;
		return $content;
	}

    
    
}

?>
