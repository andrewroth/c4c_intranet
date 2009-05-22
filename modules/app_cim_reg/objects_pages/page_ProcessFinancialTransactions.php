<?php
/**
 * Aug 7, 2007: RAD Tool wiped this file and I had to reconstitute based on app_cim_reg... please excuse lack of comments (HSMIT)
 * @package cim_reg
 */ 
/**
 * class page_ProcessFinancialTransactions 
 * <pre> 
 * This page allows a user to pay for registration via an online credit card transaction or the promise of a cash transaction to the indicated person.
 * </pre>
 * @author Russ Martin
 * Date:   07 Aug 2007
 */
 // RAD Tools: Custom Page
class  page_ProcessFinancialTransactions extends PageDisplay_FormProcessor {

	//CONSTANTS:
	const CAMPUS_UNKNOWN = '69';
	const STATUS_UNKNOWN = '0';
	
	/** The list of fields to be displayed */
	 const DISPLAY_FIELDS = ''; 
	 const FORM_FIELD_TYPES = '';
	 const FORM_FIELDS = '';	 
	     
    /** The Multilingual Page Key for labels on this page */
    const MULTILINGUAL_PAGE_KEY = 'page_ProcessFinancialTransactions';
    

	//VARIABLES:
	
	/** @var [OBJECT] The viewer object. */
	protected $viewer;
	
    /** @var [STRING] The path to this module's root directory. */
	protected $pathModuleRoot;
	
	
	/** @var [INTEGER] Foreign Key needed by Data Manager */
	protected $event_id;
	
	/** @var [INTEGER] Foreign Key needed by Data Manager */
	protected $campus_id;	
	
	/** @var [INTEGER] Foreign Key needed by Data Manager */
	protected $reg_id;	
		
	
	
	/** @var [INTEGER] Stores the currently to-be-updated cash transaction id*/
	protected $cashtrans_id;	
	
	/** @var [INTEGER] Stores the currently to-be-updated cc transaction id*/
	protected $cctrans_id;		
	
	
	/** @var [INTEGER] Stores the currently to-be-updated person id*/
	protected $person_id;			

	/** @var [INTEGER] Stores the event deposit */
	protected $deposit;			
	
		
		/** @var [OBJECT] Stores a reference to active sub-page object */
	protected $active_subPage;		
	
		/** @var [OBJECT] Stores a reference to valid sub-page object */
	protected $scholarship_list;	

		/** @var [OBJECT] Stores a reference to valid sub-page object */
	protected $cashTrans_form;
	
		/** @var [OBJECT] Stores a reference to valid sub-page object */	
	protected $ccTrans_form;		//subPage
				
	
	/** @var [STRING] Data sorting parameter passed around */
	protected $sortBy;	
	
	/** @var [STRING] URLs for form submissions*/
	protected $formAction;
	protected $cashTrans_formAction;	
	protected $ccTrans_formAction;				

	/** @var [INTEGER] the base event price for this registrant*/
	protected $basePriceForThisGuy;		
		
	/** @var [STRING] name of the sub-page form being submitted*/
	protected $formName;	
	
	/** @var [BOOLEAN] Whether page is in sign-up process or offline reg. process */
	protected $is_signup;	
		

	//CLASS CONSTRUCTOR
	//************************************************************************
	/**
	 * function __construct
	 * <pre>
	 * Initialize the object.
	 * </pre>
	 * @param $pathModuleRoot [STRING] The path to the module's root dir.
	 * @param $viewer [OBJECT] The viewer object.
	 * @return [void]
	 */
    function __construct($pathModuleRoot, $viewer, $sortBy, $regID, $eventID, $campusID = '', $cashTransID = '', $ccTransID = '', $formAction, $cashTransFormAction, $ccTransFormAction, $personID, $isSignUp = false) 
    {
	     $fieldList = page_EditRegistrationDetails::FORM_FIELDS;
        $fieldTypes = page_EditRegistrationDetails::FORM_FIELD_TYPES;
        $displayFields = page_EditRegistrationDetails::DISPLAY_FIELDS;
        parent::__construct($formAction,  $fieldList, $displayFields ); 
        
         // initialize the object values
        $this->pathModuleRoot = $pathModuleRoot;
        $this->viewer = $viewer;
        $this->sortBy = $sortBy;
        $this->formAction = $formAction;
        $this->cashTrans_formAction = $cashTransFormAction;
        $this->ccTrans_formAction = $ccTransFormAction;   
        
        $this->is_signup = $isSignUp;  
               
        $this->event_id = $eventID;
        $this->campus_id = $campusID; 
        $this->reg_id = $regID; 
        $this->deposit = $this->getEventDeposit();
        
        if ($cashTransID != '') 
        {
	        $this->cashtrans_id = $cashtransID;
        }
        
        if ($ccTransID != '') 
        {
	        $this->cctrans_id = $ccTransID;
        }       
        
        // just let these be empty if they are passed as empty
        $this->person_id = $personID;

        
        // ensure that the person is assigned to the "Unknown" campus if s/he forgot to choose a campus
        if ($this->person_id != '')
        {
	          $campusAssigner = new RowManager_EditCampusAssignmentManager();
        		 $campusAssigner->setPersonID($this->person_id);
        		 
        		 $campusAssignList = $campusAssigner->getListIterator();
        		 $campusAssignArray = $campusAssignList->getDataList();

				 if ( count($campusAssignArray) == 0 )
				 {        		 
	             // Store default values in dataManager object
	             $defaultValues = array();
	             $defaultValues['person_id'] = $this->person_id;
	             $defaultValues['campus_id'] = page_ProcessFinancialTransactions::CAMPUS_UNKNOWN;
	             $defaultValues['assignmentstatus_id'] = page_ProcessFinancialTransactions::STATUS_UNKNOWN;
	             $campusAssigner->loadFromArray( $defaultValues );
	            
	             // Save the values into the Table.
	             if (!$campusAssigner->isLoaded()) {
	            
	             	$campusAssigner->createNewEntry();    
	          	 } 
          	 } 
       	} 		 

			// create references to sub-page objects
			$this->scholarship_list = new page_ScholarshipDisplayList( $this->pathModuleRoot, $this->viewer, $this->sortBy, $this->reg_id);	//,  $this->scholarship_id , $this->reg_id);
			$this->cashTrans_form = new FormProcessor_EditRegistrationCashTransactionsList( $this->pathModuleRoot, $this->viewer, $this->cashTrans_formAction, $this->sortBy,  $this->cashtrans_id , $this->reg_id, $this->is_signup);
			$this->ccTrans_form = new FormProcessor_EditRegistrationCCTransactionsList( $this->pathModuleRoot, $this->viewer, $this->ccTrans_formAction, $this->sortBy,  $this->cctrans_id , $this->reg_id);
        
        // now initialize the labels for this page
        // start by loading the default field labels for this Module
        $languageID = $viewer->getLanguageID();
        $seriesKey = modulecim_reg::MULTILINGUAL_SERIES_KEY;
        $pageKey = page_ProcessFinancialTransactions::MULTILINGUAL_PAGE_KEY;
        $this->labels = new MultilingualManager( $languageID, $seriesKey, $pageKey );

         
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
			
			case 'cashTransForm':
				$this->active_subPage = $this->cashTrans_form;	 
				break;
			case 'ccTransForm':
				$this->active_subPage = $this->ccTrans_form;	
				break;			
			default:
				die('VALID FORM NAME **NOT** FOUND; name = '.$this->formName);
		}     
		$this->active_subPage->loadFromForm();         
       
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
      $isValid = $this->active_subPage->isDataValid();   
       
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
 		$this->active_subPage->processData();
        
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
        // Make a new Template object
        //$this->pathModuleRoot.'templates/';
        // Replace $path with the following line if you want to create a
        // template tailored for this page:
        $path = $this->pathModuleRoot.'templates/';
        
        
        // store the link values
        // $this->linkValues[ 'view' ] = 'add/new/href/data/here';
        
        // store the link labels
        $this->linkLabels[ 'add' ] = $this->labels->getLabel( '[Add]' );
//        $this->linkLabels[ 'edit' ] = $this->labels->getLabel( '[Edit]' );
//        $this->linkLabels[ 'del'  ] = $this->labels->getLabel( '[Delete]' );
		  if (!isset($this->linkLabels[ 'cont' ]))
		  {
        		$this->linkLabels[ 'cont' ] = $this->labels->getLabel( '[Continue]');
	 		}
        // $this->linkLabels[ 'view' ] = 'new link label here';

		               
		  // get pricing info
		  
		  // get base price for event participation
	     $event = new RowManager_EventManager($this->event_id);
        $eventBasePrice = $event->getEventBasePrice();
        $eventCashAllowed = $event->isEventCashAllowed();
                
        // get price rules for specific event
        $priceRules = new RowManager_PriceRuleManager();
        $priceRules->setEventID($this->event_id);
        $ruleManager = $priceRules->getListIterator(); 
        $priceRulesArray = $ruleManager->getDataList();	
//  			echo "<pre>".print_r($priceRulesArray,true)."</pre>";

        // array storing the rules applied to a particular registrant
        $rulesApplied = array();	    
        
        	    
        $priceGetter = new FinancialTools();
        $this->basePriceForThisGuy = $priceGetter->getBasePriceForRegistrant( $this->reg_id, $this->event_id, $this->campus_id, $eventBasePrice, $priceRulesArray, $rulesApplied );
// 			echo "base price = ".$basePriceForThisGuy."<BR>";

		  $totalsList = $this->getFinancialTotals();
		  $totalsArray = explode(',',$totalsList);
		  $scholarship_total = $totalsArray[0];
		  $cash_total = $totalsArray[1];
		  $cash_owing = $totalsArray[2];
		  $cc_total = $totalsArray[3];
			 
			$this->prepareTemplate( $path );
			
			// retrieve deposit amount for event
			$deposit = $this->getEventDeposit();
			
			/*** HACK: for AIA Winter Retreat '08  ***/
			if ($this->event_id == 31)
			{
	         $this->template->set('minPayNotice', "AIA Winter Retreat Registrants:<br> Please pay the $".$deposit." or full price with credit card and remainder at registration and not to an AIA staff member.<br> Thank-you.");
			}
			else
			{				
	         $this->template->set('minPayNotice', "NOTE: you must have recorded a transaction covering the $".$deposit." deposit in order to register for this event.");
         }
         $this->template->set('maxPayNotice', "'Total Paid' is only updated by credit transactions and confirmed cash transactions. " );
 //        $this->template->set( 'maxPayNotice', 'The maximum amount that must be paid is'.$maxPayment);
						
			
			// set some variables calculated previously; placed here because I need to get PERSON_ID for link
			// which had to be set before prepareTemplate(), which has to be executed BEFORE setting variables...
//        $this->template->set('eventBasePrice', $eventBasePrice );
//        $this->template->set('priceRules', $rulesApplied );
        $this->template->set('basePriceForThisGuy', $this->basePriceForThisGuy );
		  //$priceGetter->calcBalanceOwing($this->reg_id);		// NOT NEEDED BECAUSE TOTALS CALCULATED AS SUM IN TEMPLATE		
							   
//			 $this->template->set('person', $this->person_info );    
			
        // send in scholarships list, cash transactions table, and credit card transactions table
        $this->template->set('scholarshipsList', $this->generateScholarshipsList() );       
        if ($eventCashAllowed == true)
        {
		 	 	$this->template->set('cashTransAdminBox', $this->generateCashTransactionsTable() );
	 	  }
	 	  
	 	         
       // Load over-payment message, if necessary
       if ($this->ccTrans_form->hasOverPaid())
       {
       	$this->template->set( 'attemptedOverpayment', true );
    	 } 
	 	  
	 	  
		  $this->template->set('ccTransAdminBox', $this->generateCCTransactionsTable() );
		  	
// 		  $this->setFinancialTotals();		// moved up since it also sets a link label
	 		$this->template->set('scholarshipTotal', $scholarship_total );
			$this->template->set('cashTotal', $cash_total );
			$this->template->set('cashOwed', $cash_owing );		
			$this->template->set('ccTotal', $cc_total );
						        
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
          
		  
		  // TODO: somehow merge the primary join with the balance owing join.... for efficiency

        /*
         *  Set up any additional data transfer to the Template here...
         */
 //       $this->template->set( 'dataList', $this->dataList);
   
        $templateName = 'page_ProcessFinancialTransactions.tpl.php';
		// if you are creating a custom template for this page then 
		// replace $templateName with the following:
		//$templateName = 'page_EditCampusRegistrations.php';
		
		return $this->template->fetch( $templateName );
        
    }
    
    /** Returns CSV containing:  scholarshipTotal, cashTotal, cashOwed, ccTotal **/
    protected function getFinancialTotals()
    {
	  // get scholarship total
		$scholarship_total = $this->getScholarshipsTotal();
		
		if (!isset($scholarship_total))
		{
			$scholarship_total = 0;
		}				
// 		$this->template->set('scholarshipTotal', $scholarship_total );
		
		
		// get cash total
		$cash_total = $this->getCashPaidTotal();
		if (!isset($cash_total))
		{
			$cash_total = 0;
		}
// 		$this->template->set('cashTotal', $cash_total );
		
		// get cash owed
		$cash_owing = $this->getCashOwedTotal();
		if (!isset($cash_owing))
		{
			$cash_owing = 0;
		}
// 		$this->template->set('cashOwed', $cash_owing );			

		
	  // get credit card total
	  $cc_total = $this->getCCtransTotal();

		if (!isset($cc_total))
		{
			$cc_total = 0;
		}			
// 		$this->template->set('ccTotal', $cc_total );	
			
		$totalPaid = $scholarship_total + $cash_total + $cc_total; 
		if (($totalPaid + $cash_owing) >= $this->deposit)
		{
			$this->linkLabels[ 'cont' ] = $this->labels->getLabel( '[Continue]'); 		
		}	
		
		
		// set the balance-owing column in the cim_reg_registration table
		$owed = $this->basePriceForThisGuy - $scholarship_total - $cash_total - $cc_total;  
		$registration = new RowManager_RegistrationManager($this->reg_id);
		$registration->setBalanceOwing($owed);
		
		$balance = array();
		$balance['registration_balance'] = $owed;
		$registration->loadFromArray( $balance );
		$registration->updateDBTable();
		
		return $scholarship_total.','.$cash_total.','.$cash_owing.','.$cc_total;
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
    function setLinks($links, $cashTransLinks, $ccTransLinks, $disabledLink) 
    {
       $this->cashTrans_form->setLinks($cashTransLinks);
       $this->ccTrans_form->setLinks($ccTransLinks);
    
        $dataAccessManager = new RowManager_EditCampusAssignmentManager();
        $dataAccessManager->setPersonID($this->person_id);
        $dataAccessManager->setCampusID($this->campus_id);
        $dataAccessManager->setSortOrder( $this->sortBy );
        $dataList = $dataAccessManager->getListIterator();  
        $displayedValues = $dataList->getDataList();
        
        // calculate total paid already
        $scholarshipTotal = $this->getScholarshipsTotal();
        $cashTotal = $this->getCashPaidTotal();
        $ccTotal = $this->getCCtransTotal();
        $cashOwed = $this->getCashOwedTotal();
        $totalPaid = $scholarshipTotal+$cashTotal+$ccTotal; 
        
//          echo "<br>scholarships = ".$scholarshipTotal;
//          echo "<br>cash total = ".$cashTotal;
//          echo "<br>cc total = ".$ccTotal; 
        
         // disallow the 'continue' link if total paid (+ recorded as owed) is less than event deposit for this person
        $deposit = $this->getEventDeposit();
        if (($deposit == "NOT YET DETERMINED")||($totalPaid+$cashOwed < $deposit))
        {

			   $baseLink = $disabledLink;	//cashTransLinks['sortBy'];
// 			   $baseLink = str_replace( modulecim_reg::CASHTRANS_ID.'=', '', $baseLink);
			   
			   $links['cont'] = $baseLink;       
			   $this->linkLabels[ 'cont' ] = $this->labels->getLabel( '[Disabled]'); 
  		  }       
  		  
//   		          echo print_r($this->linkValues,true);
	    
	    parent::setLinks($links);
      
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
    function setFormAction($cashTransLinks, $ccTransLinks) 
    {
	    //parent::setFormAction($link);
       $this->cashTrans_form->setFormAction($cashTransLinks);
       $this->ccTrans_form->setFormAction($ccTransLinks); 
    }    
  
    
    // returns html of a table with a listing of all the scholarships for
    // the currently-selected participant
    //
    function generateScholarshipsList()
    {
			// $subPage = $this->_controller->loadEditRegistrationScholarshipList(); 
			$content = $this->scholarship_list->getHTML(); 
         
         return $content;
    }    
    
        // returns html of a table with a listing of all the cash transactions for
    // the currently-selected participant
    //
    function generateCashTransactionsTable()
    {
	      //$content = $this->_controller->loadEditRegistrationCashTransactionsList();
			$content = $this->cashTrans_form->getHTML(); 
         
         return $content;
    } 
    
        // returns html of a table with a listing of all the credit card transactions for
    // the currently-selected participant
    //
    function generateCCTransactionsTable()
    {
//			$content = $this->_controller->loadEditRegistrationCCTransactionsList(); 
			$content = $this->ccTrans_form->getHTML(); 
         
         return $content;
    } 
    
    
    // get total scholarships amount
    function getScholarshipsTotal()
    {
		  $scholarships = new RowManager_ScholarshipAssignmentManager();
		  $scholarships->setRegID($this->reg_id);
		  $scholarshipTotal = new MultiTableManager();
		  $scholarshipTotal->addRowManager($scholarships);
		  $scholarshipTotal->setFunctionCall('SUM','scholarship_amount');
		  $scholarshipTotal->setGroupBy('registration_id');
		  
	     $scholarshipsList = $scholarshipTotal->getListIterator(); 
        $scholarshipsArray = $scholarshipsList->getDataList();		  
	
        $scholarship_total = 0;
         reset($scholarshipsArray);
        	foreach(array_keys($scholarshipsArray) as $k)
			{
				$scholarshp = current($scholarshipsArray);	
				$scholarship_total = $scholarshp['SUM(scholarship_amount)'];		
				
				next($scholarshipsArray);

			}
			
			return $scholarship_total;
	  }	    
    
    
    // get total cash paid
    function getCashPaidTotal()
    {
		  $cashTrans = new RowManager_CashTransactionManager();
		  $cashTrans->setRegID($this->reg_id);
		  $cashTrans->setReceived(true);
		  $cashTransTotal = new MultiTableManager();
		  $cashTransTotal->addRowManager($cashTrans);		  
		  $cashTransTotal->setFunctionCall('SUM','cashtransaction_amtPaid');
		  $cashTransTotal->setGroupBy('reg_id');
		  
	     $cashTransList = $cashTransTotal->getListIterator(); 
        $cashTransArray = $cashTransList->getDataList();		  
	
        $cash_total = 0;
         reset($cashTransArray);
        	foreach(array_keys($cashTransArray) as $k)
			{
				$cash_trans = current($cashTransArray);	
				$cash_total = $cash_trans['SUM(cashtransaction_amtPaid)'];		
				
				next($cashTransArray);

			}
			
			return $cash_total;
		}	    
    
    // get total cash owed
    function getCashOwedTotal()
    {
		  $cashOwed = new RowManager_CashTransactionManager();
		  $cashOwed->setRegID($this->reg_id);
		  $cashOwed->setReceived(false);
		  $cashOwedTotal = new MultiTableManager();
		  $cashOwedTotal->addRowManager($cashOwed);
		  $cashOwedTotal->setFunctionCall('SUM','cashtransaction_amtPaid');
		  $cashOwedTotal->setGroupBy('reg_id');
		  
	     $cashOwedList = $cashOwedTotal->getListIterator(); 
        $cashOwedArray = $cashOwedList->getDataList();		  
	
         $cash_owing = 0;
         reset($cashOwedArray);
        	foreach(array_keys($cashOwedArray) as $k)
			{
				$cash_owed = current($cashOwedArray);	
				$cash_owing = $cash_owed['SUM(cashtransaction_amtPaid)'];		
				
				next($cashOwedArray);

			}
			
			return $cash_owing;
	 }	    
    
    // get total amount paid via Credit Card (CC)
    function getCCtransTotal() 
    {
    		  $ccTrans = new RowManager_CreditCardTransactionManager();
		  $ccTrans->setRegID($this->reg_id);
		  $ccTrans->setProcessed(true);
		  $ccTransTotal = new MultiTableManager();
		  $ccTransTotal->addRowManager($ccTrans);
		  $ccTransTotal->setFunctionCall('SUM','cctransaction_amount');
		  $ccTransTotal->setGroupBy('reg_id');
		  
	     $ccTransList = $ccTransTotal->getListIterator(); 
        $ccTransArray = $ccTransList->getDataList();		  
	
         $cc_total = 0;
         reset($ccTransArray);
        	foreach(array_keys($ccTransArray) as $k)
			{
				$cc_trans = current($ccTransArray);	
				$cc_total = $cc_trans['SUM(cctransaction_amount)'];		
				
				next($ccTransArray);

			}
			return $cc_total;
		}
			
    
    // get event deposit price
    function getEventDeposit()
    {
	    if (isset($this->event_id))
	    {
		    
		    $event = new RowManager_EventManager();
		    $event->setEventID($this->event_id);
		    $eventList = $event->getListIterator();
		    $eventArray = $eventList->getDataList();
		    
		    $deposit = '';
		    reset($eventArray);
	     	 foreach(array_keys($eventArray) as $k)
			 {
				$record = current($eventArray);	
				$deposit = $record['event_deposit'];		
				
				next($eventArray);
			 }
			 
			 return $deposit;
		 }
		 else
		 {
			 return "TO BE DETERMINED";
		 }
	 }

}

?>