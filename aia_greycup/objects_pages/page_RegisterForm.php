<?php

// $toolName = 'modules/app_cim_hrdb/objects_da/AdminManager.php';
// $toolPath = Page::findPathExtension( $toolName );
// require_once( $toolPath.$toolName);

// $toolName = 'modules/app_cim_hrdb/objects_da/AccessManager.php';
// $toolPath = Page::findPathExtension( $toolName );
// require_once( $toolPath.$toolName);

// TODO: centralize these library loading calls
  require_once('../modules/app_cim_reg/objects_da/StatusManager.php');
 require_once('../modules/app_cim_reg/objects_da/EventManager.php');
 require_once('../modules/app_cim_reg/objects_da/ActiveRuleManager.php');
 require_once('../modules/app_cim_reg/objects_da/CreditCardTransactionManager.php');
 require_once('../modules/app_cim_reg/objects_da/CreditCardTypeManager.php');
 require_once('../modules/app_cim_reg/objects_da/ReceiptManager.php');
 require_once('../modules/app_cim_hrdb/objects_da/ProvinceManager.php');
 require_once('../Tools/TicketsManager.php');
 
 require_once('../objects/Moneris/CreditCardProcessor.php');
 
 // need for balance owing update in CreditCardTransactionManager (because it uses FinanceTools)
 require_once('../modules/app_cim_reg/objects_da/PriceRuleManager.php');
 require_once('../modules/app_cim_reg/objects_da/PriceRuleTypeManager.php');
 require_once('../modules/app_cim_reg/objects_da/FieldValueManager.php');
 require_once('../modules/app_cim_reg/objects_da/ScholarshipAssignmentManager.php');
 require_once('../modules/app_cim_reg/objects_da/CashTransactionManager.php');

 
/**
 * @package cim_hrdb
 */ 
/**
 * class FormProcessor_Register 
 * <pre> 
 * Allows a person to edit their hrdb info.
 * </pre>
 * @author CIM Team
 * Date:   06 Apr 2006
 */
 // RAD Tools: FormSingleEntry Page
class  FormProcessor_Register extends PageDisplay_FormProcessor {

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
    const FORM_FIELDS = 'person_fname|T|,person_lname|T|,person_email|T|,person_addr|T|,person_city|T|,person_pc|T|,province_id|N|,num_tickets|N|,cctransaction_cardName|T|,cctype_id|N|,cctransaction_cardNum|N|,cctransaction_expiry|T|,to_survey|B|';	//cctransaction_amount|N|,cctransaction_billingPC|T|
    
    /** The list of field types to be displayed in the form */
    // NOTE: if a field isn't displayed, put a '-' for it's entry.
    const FORM_FIELD_TYPES = 'textbox||50,textbox||50,textbox||25,textbox||128,textbox||50,textbox||7,droplist,droplist,textbox||64,droplist|20,textbox|20|25,textbox|6|5,checkbox';	//textbox|10|15,textbox|7|7
    
    /** The Multilingual Page Key for this page */
    const MULTILINGUAL_PAGE_KEY = 'FormProcessor_Register';
    
    // HERE THE INITIAL REG. STATUS IS SET
    const INITIAL_REG_STATUS = 'Incomplete';
    
    // HACK: used because we don't have a viewer object to get language from
    const ENGLISH = '1';
    
    // INDICATES STANDARD TICKET PRICE AND LATE FEE APPLIED AFTER LATE DATE
    const TICKET_PRICE = 50;
    const LATE_FEE = 10;
    const LATE_DATE = '2007-11-11 00:00:01'; 
    

	//VARIABLES:
	
	/** @var [STRING] The path to the module's root directory. */
	protected $pathModuleRoot;
	
	/** @var [OBJECT] The Object used to manage registration data. */
	protected $regManager;
	
	/** @var [OBJECT] The Object used to manage event data. */
	protected $eventManager;
	
	/** @var [OBJECT] The Object used to manage ticket data. */
	protected $ticketManager;
		
	/** @var [OBJECT] The Object used to manage credit card transaction data. */
	protected $ccTransManager;	

    /** @var [STRING] The initialization data for the dataManager. */
	protected $event_id;	
	
    /** @var [STRING] The initialization data for the dataManager. */
	protected $campus_id;	
	
    /** @var [STRING] The initialization data for the dataManager. */
	protected $person_id;			
	
    /** @var [STRING] The initialization data for the dataManager. */
	protected $registration_id;
	
    /** @var [STRING] The confirm # of the regManager. */
	protected $confirmNum;			
	
	    /** @var [INTEGER] The cost of a single ticket */
	protected $ticket_price;			
		
	
	/** @var [BOOLEAN] Whether or not page is located within registration process */
	protected $isInRegProcess;

		/** @var [BOOLEAN] Whether or not form has been processed*/	
// 	protected $formIsProcessed;
	
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
	 * @param $formAction [STRING] The action on a form submit
	 * @return [void]
	 */
    function __construct($pathModuleRoot, $formAction, $event_id) 
    {
        // NOTE: be sure to call the parent constructor before trying to 
        //       use the ->formXXX arrays...

        $this->event_id = $event_id;
        $this->campus_id = 69;	// 'Unknown' campus
        $this->person_id = -1;	// person ID is set later
        $this->confirmNum = 0;
        $this->formIsProcessed = false;

//         $this->setRegistrationID();	// get registration ID for the rest of the process	         
//      		$formAction .= '&'.moduleaia_reg::REG_ID.'='.$this->registration_id;

     		// pass on new person_id to GET parameters
//      		$formAction = str_replace( moduleaia_reg::PERSON_ID.'=-1', moduleaia_reg::PERSON_ID.'='.$this->person_id, $formAction);

        $fieldList = FormProcessor_Register::FORM_FIELDS;
        $fieldDisplayTypes = FormProcessor_Register::FORM_FIELD_TYPES;
        parent::__construct( $formAction, $fieldList, $fieldDisplayTypes  );

        $this->pathModuleRoot = $pathModuleRoot;
        
        $this->creditProcessor = new CreditCardProcessor();
        

//         // figure out the important fields for the dataManager
//  //       $fieldsOfInterest = implode(',', $this->formFields);
//         
         $this->dataManager = new RowManager_PersonManager( );
//  //       $this->dataManager->setFieldsOfInterest( $fieldsOfInterest );
//         $this->formValues = $this->dataManager->getArrayOfValues();
// //echo "form values:<br><pre>".print_r($this->formValues,true)."</pre>";    

			$this->regManager = new RowManager_RegistrationManager();
//			$this->regManager ->setRegID($this->registration_id);
// 			$this->eventManager = new RowManager_EventManager();
// 			$this->eventManager->setEventID($this->event_id);
			$this->ticketManager = new RowManager_TicketsManager();	
//			$this->ticketManager->setRegID($this->registration_id);
			
// 			$this->regManager = new MultiTableManager(); 
// 			$this->regManager->addRowManager($regs);
// 			$this->regManager->addRowManager($events, new JoinPair($regs->getJoinOnEventID(), $events->getJoinOnEventID()));
// 			$this->regManager->addRowManager($tickets, new JoinPair($regs->getJoinOnRegID(), $tickets->getJoinOnRegID()));
			
			$this->ccTransManager = new RowManager_CreditCardTransactionManager();
//			$this->ccTransManager->setRegID($this->registration_id);

        // now initialize the labels for this page
        // start by loading the default field labels for this Module
        $languageID = FormProcessor_Register::ENGLISH;
        $seriesKey = moduleaia_reg::MULTILINGUAL_SERIES_KEY;
        $pageKey = moduleaia_reg::MULTILINGUAL_PAGE_FIELDS;
        $this->labels = new MultilingualManager( $languageID, $seriesKey, $pageKey );
        
        // then load the page specific labels for this page
        $pageKey = FormProcessor_Register::MULTILINGUAL_PAGE_KEY;
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
	            
//         $this->formIsProcessed = true;
        
        // try to get person_id given the entered e-mail address
        $person_email = $this->formValues['person_email'];
        $this->person_id = $this->getPersonID($person_email);  	
//         $this->registration_id = $this->getRegistrationID($this->person_id);	
        
        // if no previous person record found then create a new record
        if ($this->person_id == -1)	// || !$this->dataManager->isLoaded()
        {
	        $values = $this->formValues;	// grab all the form values (RowManager smart enough to only load pertinent data)	       
	        $this->person_id = $this->createPersonRecord($values,$this->dataManager);
        }
//         else 
//         {
// 	         $this->dataManager ->setPersonID($this->person_id);
// 	         $this->dataManager->loadFromArray( $this->formValues );
//             $this->dataManager->updateDBTable();
//         }	        
	     
        // if no previous registration record found
//         if ($this->registration_id == -1)
//         {   	        
	         $this->registration_id = $this->createRegistrationRecord($this->event_id, $this->person_id, $this->regManager);

	                // create new form values
		       $this->formValues[ 'reg_id' ] = $this->registration_id;   
		       $_POST['registration_id'] = $this->registration_id;     
		       $this->formValues[ 'cctransaction_refnum' ] = null;
//          }
	        		  
        
        // store values in table manager object.
//         $this->dataManager ->setPersonID($this->person_id);
//         $this->dataManager->loadFromArray( $this->formValues );
//         $this->regManager ->setRegID($this->registration_id);
//         $this->regManager->loadFromArray( $this->formValues );
//         $this->ccTransManager ->setRegID($this->registration_id);
		  $this->ticketManager->loadFromArray( $this->formValues);
        $this->ccTransManager->loadFromArray( $this->formValues );

        
         // now update the DB with the ticket values
        if (!$this->ticketManager->isLoaded()) 
        {
	         $this->ticketManager->setRegID($this->registration_id);
            $this->ticketManager->createNewEntry(true);
        } 
//         else 
//         {
//             $this->ticketManager->updateDBTable();
//         }             

                     
  		  // determine the ticket price
  		 $this->ticket_price = FormProcessor_Register::TICKET_PRICE;
		 if (strtotime("now") >= strtotime( FormProcessor_Register::LATE_DATE ))
		 {
			 $this->ticket_price += FormProcessor_Register::LATE_FEE;
		 }
  		  
  		  // calculate amount that needs to be paid
  		  $numTickets = $this->formValues['num_tickets'];
  		  $this->formValues['cctransaction_amount'] = $this->ticket_price*$numTickets;
  		  
  		  // add cents to amount if required
		    $amount = 	 $this->formValues['cctransaction_amount'];
		    $dollar_pattern = '([0-9]+.[0-9][0-9])';	// NOTE: does NOT match '.05'; user MUST put digit before the '.'
		    if (!preg_match($dollar_pattern, $amount))
		    {
  		    	$amount .= '.00';		//assume that cents are missing from string (required for CC processing)
		    }       
		    $this->formValues['cctransaction_amount'] = $amount; 
  
      // Store values in dataManager object
//       $this->ccTransManager->loadFromArray( $this->formValues );
//              echo "<pre>".print_r($this->formValues ,true)."</pre>";  
      
      // Save the values into the Table.
      if (!$this->ccTransManager->isLoaded()) {
  	            
          $this->ccTransManager->createNewEntry();		// fortunately, default is to mark transaction as NOT processed
          $ccTransID = $this->ccTransManager->getID();		//	echo "CCTRANS_ID == ".$ccTransID;
          
          // TO ADD TO DB: sequence # (ref num), approval (auth) code, response code (response code: [0,49] approved,   [50,999] declined, Null   incomplete)
          // message (APPROVED, DECLINED, CALL FOR, HOLD CARD (PICK UP CARD)
          
          // NOTE: person_id and confirmNum were already set via helper method with reg_id parameter, called in constructor
			 $timestamp = strtotime("now");
			 $date = date('Y-m-d_H:i:s', $timestamp);
  		    $order_id = 'AIA_'.$this->confirmNum.$date;        		   
  		    	        		    
  		    $ccNum =  $this->formValues['cctransaction_cardNum'];
  		    
  		    // NOTE: need to swap MM/YY to become YYMM, for Moneris credit processing purposes
  		    $expiryDate = substr($this->formValues['cctransaction_expiry'],-2,2).substr($this->formValues['cctransaction_expiry'],0,2);
  		    
//         		    echo "<br>person_id, order_id, amount, ccNum, expiryDate =<br>".$this->person_id.", ".$order_id.", ".$amount.", ".$ccNum.", ".$expiryDate;
          $msg = $this->creditProcessor->purchase($this->person_id, $order_id, $amount, $ccNum, $expiryDate);
//                 echo "message = <pre>".print_r($msg,true)."</pre>";
          $transRefNum = $msg->getTxnNumber();	// retrieve trans. ref. # for possible VOID operations in the future               						               
          $this->storeReceiptInDB($ccTransID, $msg, $date);                

         $_POST['cctransaction_id'] = $ccTransID;	// needed even if transaction is declined
			$resultMessage = $msg->getMessage();
			if ( preg_match('/'.CreditCardProcessor::APPROVED.'/i', $resultMessage))
			{
				$this->formValues['cctransaction_processed'] = 1;	// mark transaction as processed IF it worked
				$this->formValues['cctransaction_id'] = $ccTransID;
				$this->formValues['cctransaction_refnum'] = $transRefNum;
				$this->ccTransManager->loadFromArray( $this->formValues );
				$this->ccTransManager->updateDBTable();
				
				// send next page updated information, including a "hidden" value
				$_POST['cctransaction_processed'] = 1;
				
				// set registration status to REGISTERED
				$this->regManager->setStatus(RowManager_RegistrationManager::STATUS_REGISTERED);
				$this->regManager->updateDBTable();
			}
// 					else 
// 					{
// 						$this->error_message = $resultMessage;
// 					}               

      } 
//       else 
//       {
//          // retrieve old values
//          
//          // if card name, card-type, card number, card expiry, or card postal code is to be updated
//          // then VOID transaction (if possible: batches close between 10-11 PM EST daily; otherwise refund the customer)
//          
//          // VOID requires 'order_id' and 'txn_number'
//          
//          // refund requires 'order_id', 'txn_number', and some $$$ amount
//          
//          // if only amount is changing, check first to see if 
//          
//          // update "processed" flag and timestamp of transaction
//          
//          // update information
//           $this->ccTransManager->updateDBTable();
//       }    
      
              // now update the DB with the person values
//         if (!$this->dataManager->isLoaded()) 
//         {
// //	        echo "PERSONID = ".$this->person_id;
// 	         $this->dataManager->setPersonID($this->person_id);
//             $this->dataManager->createNewEntry(true);
//             
// //             $this->assignCampus($this->person_id);
//         } else 
//         {
//             $this->dataManager->updateDBTable();
//         }
//         
//          // now update the DB with the registration values
//         if (!$this->regManager->isLoaded()) 
//         {
// 	         $this->regManager->setRegID($this->registration_id);
//             $this->regManager->createNewEntry(true);
//         } else 
//         {
//             $this->regManager->updateDBTable();
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
//         $path = SITE_PATH_TEMPLATES;
        
        
        
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
        
        $cctransWarning = "<div class='notice'>Do <b>NOT</b> refresh the page or re-click the 'Update' button after initially clicking 'Update'.<br> Wait for the confirmation page to be loaded.</div>";
        $this->template->set( 'specialInfo', $cctransWarning);
        


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

			        // get a list of all credit card type IDs
        $ccType = new RowManager_CreditCardTypeManager();
        $ccType->setSortOrder( 'cctype_id' );
        $ccTypeList = new ListIterator($ccType);	
        $ccTypeArray = $ccTypeList->getDropListArray();

        $this->template->set( 'list_cctype_id', $ccTypeArray );  
        
        
       $this->ticket_price = FormProcessor_Register::TICKET_PRICE;
		 if (strtotime("now") >= strtotime( FormProcessor_Register::LATE_DATE ))
		 {
			 $this->ticket_price += FormProcessor_Register::LATE_FEE;
		 }
		 
        $totalChoices = 10;
        $numTicketChoices = array();
        for ($i = 1; $i <= $totalChoices; $i++)
        { 
        		$numTicketChoices[$i] = ''.($i).'  ($'.$this->ticket_price*$i.')';
  	     }
  	     $numTicketChoices[$totalChoices] = $numTicketChoices[$totalChoices].' (table)';
        $this->template->set( 'list_num_tickets', $numTicketChoices );         

        $donationLink = 'To make a donation towards this event, click <a href = "https://secure.crusade.org/giving/give_ministry.php">here</a> '
        					.'and under "Giving Description" enter the following: "Grey Cup Breakfast - 50050".';
        $this->template->set( 'footerContent', $donationLink);
        
        $contactInfo = 'Questions? Send an e-mail to: <a href=mailto:tickets@greycupbreakfast.ca>tickets@greycupbreakfast.ca</a>';
        $this->template->set( 'contactInfo', $contactInfo);
        

		// uncomment this line if you are creating a template for this page
		//$templateName = 'page_EditMyInfo.php';
		// otherwise use the generic admin box template
		$templateName = 'page_RegisterForm.tpl.php';
		
		return $this->template->fetch( $templateName );
        
    }
    
    // returns the person ID associated with a given e-mail address, if a person exists
    protected function getPersonID($person_email)
    {
	   $personID = -1;
	    
		$persons = new RowManager_PersonManager();
		$persons->setEmail($person_email);
		
      $personsList = $persons->getListIterator( );
      $personsArray = $personsList->getDataList();

      // grab the first person_id found
      reset($personsArray);
      
      if (count($personsArray) > 0)
      {
	      $personRecord = current($personsArray);	
	      $personID = $personRecord['person_id'];
      }
      
      return $personID;
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
		
    // set registration ID by retrieving the next valid ID from the database
    // creates a new person record
    protected function createPersonRecord($values,&$people)
    {
			if (isset($values)&&(count($values)>0))
			{	  			
				$personID = $this->getNextPersonID();
// 				$people = new RowManager_RegistrationManager();
				
				 // store values in table manager object.
		        $people->loadFromArray( $values );
		        
		        // set primary key to use for update (if maxID found)
			      if ($personID > -1)
			      {
			      	$values['person_id'] = $personID;
			      	$people->setPersonID($personID);
		      	}
		        
		        // now update the DB with the values
		        if (!$people->isLoaded()) 
		        {
		            $people->createNewEntry(true);	// allow primary key to be set (in case auto_increment is off)
		            return $personID;
		        }
		        else
		        {
			        return -1;
		        }				
			}
	 }
				
   
   // returns the registration ID associated with the currently set person_id
    protected function getRegistrationID($personID)
     {
	     $regID = -1;
	     
	     if ($personID != -1)
	     {
        		// get registration ID for the rest of the reg. process
        		$regs = new RowManager_RegistrationManager();		
			  $regs->setPersonID($this->person_id);		
	        $regsList = $regs->getListIterator( );
	        $regsArray = $regsList->getDataList();			          
		      
	        $statusID = 0;
	         reset($regsArray);
	        	foreach(array_keys($regsArray) as $k)
				{
					$reg = current($regsArray);	
					$regID = $reg['registration_id'];	// NOTE: should only be one reg. per person per event (ENFORCE??)	
// 					$this->registration_id = $regID;	
					
					next($regsArray);	
				}
			}
			return $regID;	// returns latest registration_id
		}	
		
		// returns registration ID if form processed
// 		public function externalGetRegistrationID()
// 		{
// 			if ($this->formIsProcessed == true)
// 			{
// 				return $this->registration_id;
// 			}
// 			else
// 			{
// 				return -1;
// 			}
// 		}

	    

    // set registration ID by retrieving the next valid ID from the database
    // creates a new registration record
    protected function createRegistrationRecord($eventID, $personID, &$regs)
     {
			if (($personID != -1)&&($eventID != -1))
			{	        			        		     
// 	        $regs = new RowManager_RegistrationManager();
		
				// get status id for INITIAL_REG_STATUS
			  $regStatus = new RowManager_StatusManager();
			  $regStatus->setStatusDesc(FormProcessor_Register::INITIAL_REG_STATUS);		
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
				$allRegs->addRowManager($regs);
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
				$regValues['event_id'] = $eventID;
				
				// check if a new person record needs to be created
// 				if ($this->person_id == -1)
// 				{
// 					$this->person_id = $this->getNextPersonID();	// assumes processData() will properly use this value for insertion
// 				}
				$regValues['person_id'] = $personID;
								
				
				$timestamp = strtotime("now");
	     		$date = date('Y-m-d H:i:s', $timestamp);  // == NOW() : to bad I could pass that as non-string...    
				$regValues['registration_date'] = $date;	// set date-time to current date-time
				
				
				$regValues['registration_confirmNum'] = 'E'.$eventID.'R'.$nextRegID.'AIA';
				$regValues['registration_status'] = $statusID;
				
				$this->confirmNum = $regValues['registration_confirmNum'];	// TODO: change means of assigning to global
				
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
		            return $nextRegID;
		        }
		        else
		        {
			        return -1;
		        }
		        // TODO: figure out how to show error if no registration made, or updated (IF it is even possible now...)
	        }
        	
        }
			  
			
			
			
			
			
     // store CC transaction result info in the cim_reg_ccreceipt table
     // $msg is a result object having useful response data
     protected function storeReceiptInDB($ccTransID, $msg, $timeStamp)
     {
	      $originalResponse = $msg->getMpgResponseData();
// 	      echo "RESPONSE DATA <PRE>".print_r($originalResponse,true)."</PRE>";
	     
			$receiptManager = new RowManager_ReceiptManager();
			$receiptManager->setCCtransID($ccTransID);
			
			// get data fields and populate with response data
			$responseData = array();
			$tableFields = $receiptManager->getFields();
// 			echo "<pre>".print_r($tableFields ,true)."</pre>"; 
			
			$idx = 0;
			reset($tableFields);
			foreach(array_keys($tableFields) as $k)
			{
				$field = current($tableFields);	// get receipt table column name
				
//				echo "field = ".$field;
				$responseKey = $this->creditProcessor->getReceiptKey($field);	// get Moneris response array key mapped to receipt table column
				if (isset($responseKey))
				{
//					echo "response key = ".$responseKey;				
					// use table column name as key to data in original response (as mapped to column via constant array)	
					if ($field == 'ccreceipt_moddate')
					{
// 						$timestamp = explode('|',CreditCardProcessor::TRANSACTION_TIMESTAMP);

// 						if (isset($originalResponse[$timestamp[0]])&&($originalResponse[$timestamp[0]]!=null)&&
// 						   (isset($originalResponse[$timestamp[1]]))&&($originalResponse[$timestamp[1]]!=null))
// 						{
// 							$t_date = $originalResponse[$timestamp[0]];
// 							$t_time = $originalResponse[$timestamp[1]];
							
							$responseData[$field] = $timeStamp;		//$t_date.' '.$t_time;
// 						}
						
					}
					else if (isset($originalResponse[$responseKey])&&($originalResponse[$responseKey]!=null))	// needed because AuthCode not returned on DECLINED transaction
					{
						$responseData[$field] = $originalResponse[$responseKey];	
					}
					else
					{
						$responseData[$field] = '-1';	// if a response code is not available, set to -1
					}
				}
				
				next($tableFields);	
				$idx++;
			}			
		   $responseData['cctransaction_id'] = $ccTransID;
			
		     // LOAD DATA INTO cim_reg_ccreceipt TABLE
          $receiptManager->loadFromArray( $responseData );
//          echo "responseData: <pre>".print_r($responseData ,true)."</pre>";  
            
         // Save the values into the Table.
//          if (!$receiptManager->isLoaded()) {		// DISABLED BECAUSE MUST SET PRIMARY KEY MANUALLY ==> isLoaded() is set to TRUE by code
             $receiptManager->createNewEntry(true);	
//          }
          // do NOT update any receipt rows			

		}	   			
			
			
			
			
			
			
			// create a campus assignment record for the new person entry
// 			protected function assignCampus($personID)
// 			{
// 				if ((isset($this->campus_id)&&($this->campus_id != '')))
// 				{
// 					$campusAssign = new RowManager_AssignmentsManager();
// 					$campusAssign->setPersonID($personID);
// 					$campusAssign->setCampusID($this->campus_id);
// 					
// 				   $updateValues = array();
// 				   $updateValues['person_id'] = $personID;    
// 				   $updateValues['campus_id'] = $this->campus_id;	
// 	        
// 	            // Store values in AssignmentsManager object
// 	            $campusAssign->loadFromArray( $updateValues );
// 	//              echo "<pre>".print_r($updateValues ,true)."</pre>";          
// 	            
// 	            // store new information
// 	             $campusAssign->createNewEntry();
//              }
//           }      	    
	
          
          // self-explanatory: system user == person to be registered (or at least get personal info changed)
//           protected function getPersonIDfromViewerID()
//           {
// 	          $accessPriv = new RowManager_AccessManager();
// 	          $accessPriv->setViewerID($this->viewer->getID());
// 	          
// 	          $accessPrivList = $accessPriv->getListIterator();
// 	          $accessPrivArray = $accessPrivList->getDataList();
// 	          
// 	          $personID = '';
// 	          reset($accessPrivArray);
// 	          foreach (array_keys($accessPrivArray) as $k)
// 	          {
// 	          	$record = current($accessPrivArray);
// 	          	$personID = $record['person_id'];	// can only be 1 person_id per viewer_id
// 	          	next($accessPrivArray);
//           	 }
// 	          
// 	          return $personID;
//           }
	          
}

?>
