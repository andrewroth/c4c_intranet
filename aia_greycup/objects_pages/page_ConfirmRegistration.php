<?php

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
 
/**
 * @package aia reg
 */ 
/**
 * class page_ConfirmRegistration 
 * <pre> 
 * Used to display the confirmation page for AIA Grey Cup Breakfast 2007 registration
 * </pre>
 * @author Hobbe Smit
 * Date:   03 Oct 2007
 */
class  page_ConfirmRegistration extends PageDisplay_FormProcessor		//DisplayList 
{

	//CONSTANTS:
	
	/** dummy fields... **/
	 const FORM_FIELDS = '';	//'ccreceipt_sequencenum|T|,ccreceipt_authcode|T|,ccreceipt_responsecode|T|,ccreceipt_message|T|,ccreceipt_moddate|T|';

	/** dummy field types... **/
	 const FORM_FIELD_TYPES = '';	//'-,-,-,-,-,-,-,-,-';//'textbox,droplist|20,textbox|20,textbox|6,textbox|7,hidden,textbox|10,-,hidden'; 
	 	
	/** The list of fields to be displayed */
    const DISPLAY_FIELDS = '';	//'ccreceipt_sequencenum,ccreceipt_authcode,ccreceipt_responsecode,ccreceipt_message,ccreceipt_moddate';
    
    /** The Multilingual Page Key for labels on this page */
    const MULTILINGUAL_PAGE_KEY = 'page_ConfirmRegistration';
    
    /** No viewer object so use this constant for language **/
    const ENGLISH = '1';
    
    /** default FROM e-mail address for confirmation e-mails **/
    const DEFAULT_EMAIL = 'info@athletesinaction.com';
    
     /** HACK: default confirmation e-mail message (as seen in the database)**/
    const CONFIRM_MSG = 'We look forward to seeing you this year at the 29th Annual Grey Cup Breakfast hosted by Athletes in Action.';
    

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
//	protected $person_info;			
	
	/** @var [INTEGER] Stores the currently to-be-updated scholarship_id*/
//	protected $scholarship_id;	
	
	/** @var [INTEGER] Stores the currently to-be-updated cash transaction id*/
//	protected $cashtrans_id;	
	
	/** @var [INTEGER] Stores the currently to-be-updated cc transaction id*/
	protected $cctrans_id;		
	
	
	/** @var [INTEGER] Stores the currently to-be-updated person id*/
	protected $person_id;					
		
		/** @var [OBJECT] Stores a reference to active sub-page object */
//	protected $active_subPage;		
	
		/** @var [OBJECT] Stores a reference to valid sub-page object */	
//	protected $ccTrans_subPage;

	/** @var [STRING] Data sorting parameter passed around */
	protected $sortBy;	

	
		/** @var [OBJECT] Stores a reference to database manager for CC transactions */	
 	protected $ccTransManager;	
 	
 		/** @var [OBJECT] Stores a reference to database manager for CC transaction receipts */	
 	protected $receiptManager;	
 	
 		/** @var [OBJECT] Stores a reference to database manager for general registration status info*/	
 	protected $statusManager;	 	
	
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
     * @param $managerInit [INTEGER] Initialization value for the listManager.
	 * @return [void]
	 */
    function __construct($pathModuleRoot, $reg_id='', $cctrans_id='', $personID='') 	// $event_id, $campus_id,
    {
//        parent::__construct( page_DisplayCCtransactionReceipt::DISPLAY_FIELDS );

		  $viewer = null;
		  $sortBy = null;
		  $formAction = '';
        $fieldList = page_ConfirmRegistration::FORM_FIELDS;
        $fieldTypes = page_ConfirmRegistration::FORM_FIELD_TYPES;
        $displayFields = page_ConfirmRegistration::DISPLAY_FIELDS;
        parent::__construct($viewer, $formAction, $sortBy, $fieldList, $fieldTypes, $displayFields );
        
        $this->pathModuleRoot = $pathModuleRoot;
//         $this->viewer = $viewer;
//         $this->sortBy = $sortBy;

		  if (isset($_POST['registration_id']))
		  {
			  $this->reg_id = $_POST['registration_id'];
		  }
		  else
		  {
       	 $this->reg_id = $reg_id; 	
    	  }
        
        if (isset($_POST['cctransaction_id']))
        {
	     		$this->cctrans_id = $_POST['cctransaction_id'];
     	  }
     	  else // try getting cc trans. ID from parameter (not currently used in offline reg process)
     	  {
     	  		$this->cctrans_id = $cctrans_id;
  	  	  }
  	  	  
//   	  	  echo "CCTRANSID = <pre>".$this->cctrans_id."</pre>";
        
        // just let these be empty if they are passed as empty
        $this->person_id = $personID;
        
        $registration = new RowManager_RegistrationManager();  
//        $registration->setSortOrder( $sortBy );
        $registration->setRegID($this->reg_id);
        $person = new RowManager_PersonManager();
//         $campus = new RowManager_CampusManager();
//         $assign = new RowManager_AssignmentsManager();
//         $campusStatus = new RowManager_CampusAssignmentStatusManager();
		  $status = new RowManager_StatusManager();
		  $tickets = new RowManager_TicketsManager();
       
     	  // join 2 tables together: cim_reg_registration & cim_hrdb_person
        $this->statusManager = new MultiTableManager();
        $this->statusManager->addRowManager($registration);			
        $this->statusManager->addRowManager( $person, new JoinPair( $person->getJoinOnPersonID(), $registration->getJoinOnPersonID()));
//         $this->statusManager->addRowManager( $assign, new JoinPair ( $person->getJoinOnPersonID(), $assign->getJoinOnPersonID()));
//         $this->statusManager->addRowManager( $campus, new JoinPair ( $campus->getJoinOnCampusID(), $assign->getJoinOnCampusID()));
//         $this->statusManager->addRowManager( $campusStatus, new JoinPair ( $assign->getJoinOnStatusID(), $campusStatus->getJoinOnStatusID()));
        $this->statusManager->addRowManager( $status, new JoinPair( $registration->getJoinOnStatus(), $status->getJoinOnStatusID()));  
        $this->statusManager->addRowManager( $tickets, new JoinPair( $registration->getJoinOnRegID(), $tickets->getJoinOnRegID()));             
        
   //     $multiTableManager2->setLabelTemplate('viewer_userID', '[viewer_userID]');
//        $this->listManager = $regPerson->getListIterator(); 
 //       $regsArray = $this->listManager->getDataList();	
//         echo "<pre>".print_r($this->listManager,true)."</pre>";
//        echo "<pre>".print_r($regsArray,true)."</pre>";  

        $this->ccTransManager = new MultiTableManager;
        $ccTrans = new RowManager_CreditCardTransactionManager();
        $ccTrans->setCCtransID($this->cctrans_id);
//         $ccTrans->setSortOrder( $sortBy );
		  $ccType = new RowManager_CreditCardTypeManager();

		  
		  $this->ccTransManager->addRowManager( $ccTrans );
		  $this->ccTransManager->addRowManager( $ccType, new JoinPair( $ccType->getJoinOnTypeID(), $ccTrans->getJoinOnTypeID()));

        $this->receiptManager = new RowManager_ReceiptManager();
        $this->receiptManager->setCCtransID($this->cctrans_id);
 
                
         // now initialize the labels for this page
         // start by loading the default field labels for this Module
         $languageID = page_ConfirmRegistration::ENGLISH;
         $seriesKey = moduleaia_reg::MULTILINGUAL_SERIES_KEY;
         $pageKey = moduleaia_reg::MULTILINGUAL_PAGE_FIELDS;
         $this->labels = new MultilingualManager( $languageID, $seriesKey, $pageKey );
         
         // then load the page specific labels for this page
         $pageKey = page_ConfirmRegistration::MULTILINGUAL_PAGE_KEY;
         $this->labels->loadPageLabels( $pageKey );
         
         $this->labels->setSeriesKey( SITE_LABEL_SERIES_SITE );
         $this->labels->loadPageLabels( SITE_LABEL_PAGE_FORM_LINKS );
         
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
	    parent::loadFromForm();      
       
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
      $isValid = parent::isDataValid();   
       
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
		// hopefully don't need to do anything here
        
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
        $path = $this->pathModuleRoot.'templates/';
        //        $path = SITE_PATH_TEMPLATES;
        // Replace $path with the following line if you want to create a
        // template tailored for this page:
        //$path = $this->pathModuleRoot.'templates/';
        
           
        $templateName = 'page_DisplayConfirmRegistration.tpl.php';
        
        
        // store the link values
        // $this->linkValues[ 'view' ] = 'add/new/href/data/here';

        
        // store the link labels
//         $this->linkLabels[ 'add' ] = $this->labels->getLabel( '[Add]' );
//         $this->linkLabels[ 'edit' ] = $this->labels->getLabel( '[Edit]' );
//         $this->linkLabels[ 'del'  ] = $this->labels->getLabel( '[Delete]' );
        $this->linkLabels[ 'cont' ] = $this->labels->getLabel( '[Continue]');
        // $this->linkLabels[ 'view' ] = 'new link label here';

        
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
            
        
        $this->prepareTemplate( $path );
			
						
			// get receipt summary information
        $receiptData = $this->receiptManager->getListIterator();  
        $receiptDataArray = $receiptData->getDataList();	
//        echo "<pre>".print_r($receiptDataArray,true)."</pre>";  

			$seqNum = '';
			$approvalCode = '';
			$response = '';
			$message = '';

			reset($receiptDataArray);
        	foreach(array_keys($receiptDataArray) as $k)
        	{
	        	$receipt = current($receiptDataArray);
	        	
	        	$seqNum = $receipt['ccreceipt_sequencenum'];
	        	$approvalCode = $receipt['ccreceipt_authcode']; 
				$response = $receipt['ccreceipt_responsecode']; 
				$message = $receipt['ccreceipt_message']; 
				
// 							echo "RECEIPT: <pre>".print_r($receipt,true)."</pre>";   
				
				next($receiptDataArray);
			}

			
			// proceed to show receipt if transaction was approved, otherwise show error message
			if ( preg_match('/'.CreditCardProcessor::APPROVED.'/i', $message))
			{
				
			  // get Personal Info
			  $statusData = $this->statusManager->getListIterator(); 
	        $statusDataArray = $statusData->getDataList();	
// 	        echo "<pre>".print_r($statusDataArray,true)."</pre>";  
	
				$registrant = '';
				$email = '';
				$campusStatus = '';
				$campusName = '';
				$regStatus = '';  
				$confirmNum = '';
				$numTickets = '';
	        
	        reset($statusDataArray);
	        	foreach(array_keys($statusDataArray) as $k)
				{
					$personData = current($statusDataArray);
					
					if ((!isset($this->person_id))||($this->person_id == ''))
					{
						$this->person_id = $personData['person_id'];
					}
					
					
					$registrant = $personData['person_fname'].' '.$personData['person_lname'];
					$email = $personData['person_email'];
// 					$campusStatus =  $personData['assignmentstatus_desc'];
// 					$campusName = $personData['campus_desc'];
					$regStatus = $personData['status_desc'];
					$numTickets = $personData['num_tickets'];
					
					$confirmNum = $personData['registration_confirmNum'];
					
					next($statusDataArray);
	
				}
							
						   
				$this->template->set('registrantName', $registrant );
// 				$this->template->set('campusStatus', $campusStatus );
// 				$this->template->set('campusName', $campusName );
				$this->template->set('regStatus', $regStatus );		
				$this->template->set('numTickets', $numTickets);	
	
				$this->template->set('confirmNum', $confirmNum );	
				$this->template->set('personID', $this->person_id  );				
							
				// get Credit Card info
				$ccTransData = $this->ccTransManager->getListIterator();  
	        $ccTransDataArray = $ccTransData->getDataList();	
	//        echo "<pre>".print_r($ccTransDataArray,true)."</pre>";  
	
				$amount = '';
				$timestamp = '';
				$cardName = '';
				$cardType = '';
				$cardNum = '';
				$cardDate = '';
				reset($ccTransDataArray);		// should only return 1 record
	        	foreach(array_keys($ccTransDataArray) as $k)
	        	{
		        	$transRecord = current($ccTransDataArray);
		        	
		        	$amount = $transRecord['cctransaction_amount'];
		        	$timestamp = $transRecord['cctransaction_moddate']; 
					$cardName = $transRecord['cctransaction_cardName']; 
					$cardType = $transRecord['cctype_desc']; 
					$cardNum = $transRecord['cctransaction_cardNum']; 
					$cardDate = $transRecord['cctransaction_expiry']; 
					
					next($statusDataArray);
	
				}				
				
				$this->template->set('amount', $amount );
				$this->template->set('timestamp', $timestamp );
				$this->template->set('cardName', $cardName );
				$this->template->set('cardType', $cardType );								
				$this->template->set('cardNum', $cardNum );
				$this->template->set('cardDate', $cardDate );				
				
	 			// set Moneris transaction response data
				$this->template->set('seqNum', $seqNum );
				$this->template->set('approvalCode', $approvalCode );
				$this->template->set('response', $response );
				$this->template->set('message', $message );
				
				$link_regex = '{<a.*?</a>}';	
				$message = $this->template->fetch( $templateName );
				$message = preg_replace( $link_regex, '', $message);	
								
			  if (!defined('IGNORE_EMAILS'))
			  {	  
		  		$reg_message = $this->sendConfirmationEmail($email,$message,page_ConfirmRegistration::CONFIRM_MSG);
	  		  }			
					
			}
			else	// show error message
			{
				$this->template->set('error', true);
				$this->template->set('message', $message );
			}	
			 
        
        $contactInfo = 'Questions? Send an e-mail to: <a href=mailto:tickets@greycupbreakfast.ca>tickets@greycupbreakfast.ca</a>';
        $this->template->set( 'contactInfo', $contactInfo);			
			         
        // store the Row Manager's XML Node Name
        $this->template->set( 'rowManagerXMLNodeName', RowManager_ReceiptManager::XML_NODE_NAME );
        
        // store the primary key field name for the data being displayed
        $this->template->set( 'primaryKeyFieldName', 'ccreceipt_sequencenum');


        /*
         *  Set up any additional data transfer to the Template here...
         */
        

		// if you are creating a custom template for this page then 
		// replace $templateName with the following:
		//$templateName = 'page_DisplayCCtransactionReceipt.php';
								        
	        // send CC transaction confirmation e-mail (but first remove links)
		$link_regex = '{<a.*?</a>}';	
		$message_body = $this->template->fetch( $templateName );
		$message_body = preg_replace( $link_regex, '', $message_body);
		
		if (!defined('IGNORE_EMAILS'))
		{	  
			$this->sendCCTransactionEmail($message_body);		
		}
		
		return $this->template->fetch( $templateName );
        
    }
    
    // sends  registration confirmation e-mail to registrant
    private function sendConfirmationEmail($email, $msgTxt = '', $special_msg = '')		
    {
	    
	    if (isset($email)&&($email!=''))
	    {
		    // retrieve basic confirmation e-mail info.
		    $RECIPIENTS = $email;
		    $SUBJECT = 'Athletes in Action Grey Cup Breakfast: Registration Confirmed';
		    $FROM = page_ConfirmRegistration::DEFAULT_EMAIL;
		    
		    $success = false;
		    
		    if ($msgTxt != '')
		    {
			     $message = '<html>';	//<head>Credit Card Transaction Receipt</head>';
			     $message .= '<body>';	
			     $message .= '<H4>';
			     $message .= $special_msg;
			     $message .= '</H4>';   
	       	  $message .= $msgTxt;  
	       	  $message .= "</body></html>";                    
	
		        $headers = 'MIME-Version: 1.0' . "\r\n";
		        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		        $htmlBreak = '<br/>';     	           
		       
		       $message = wordwrap($message, 70);       
	// 	
	// 	       $headers .= 'From: '.$FROM . "\n" .
	// 				'Reply-To: '.$FROM . "\n" .
	// 				'X-Mailer: PHP/' . phpversion();
	
				 $headers = "From: AIA Registration System <".$FROM.">\n" .
						      "MIME-Version: 1.0\n" .
						      "Content-type: text/html; charset=iso-8859-1\n" .
						      'X-Mailer: PHP/' . phpversion();
		
		// 				echo "<BR>HEADERS: ".$headers;								
		// 				echo "TO: ".$to;
		// 				echo "<br>SUBJECT: ".$subject;
		// 				echo "<BR>MESSAGE: ".$message;
		
				 ini_set('SMTP', EMAIL_SMTP_SERVER);
				 ini_set('smtp_port', EMAIL_SMTP_PORT);
		
		       $success = mail( $RECIPIENTS, $SUBJECT, $message, $headers  );
	       }
	       
	       if ( !$success )
	       {
	           return 'Error Sending Confirmation E-mail!';		// TODO: replace with a label
	       }    	
	       else
	       {
		        return 'Confirmation E-mail Successfully Sent';	// TODO: replace with a label
	        } 
        } 

    }
    
    
  
    // sends CC transaction confirmation e-mail off to certain HQ folks
    private function sendCCTransactionEmail($msgTxt = '')		
    {
	    // retrieve basic confirmation e-mail info.
	    $RECIPIENTS = 'jocelyn.veer@crusade.org, rita.klassen@crusade.org';
	    $SUBJECT = 'Athletes in Action Credit Card Transaction Received';
	    $FROM = 'reg@campusforchrist.org';
	    
	    $success = false;
	    
	    if ($msgTxt != '')
	    {
		     $message = '<html>';	//<head>Credit Card Transaction Receipt</head>';
		     $message .= '<body>';	   
       	  $message .= $msgTxt;  
       	  $message .= "</body></html>";                    

	        $headers = 'MIME-Version: 1.0' . "\r\n";
	        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	        $htmlBreak = '<br/>';     	           
	       
	       $message = wordwrap($message, 70);       
// 	
// 	       $headers .= 'From: '.$FROM . "\n" .
// 				'Reply-To: '.$FROM . "\n" .
// 				'X-Mailer: PHP/' . phpversion();

			 $headers = "From: AIA Registration System <".$FROM.">\n" .
					      "MIME-Version: 1.0\n" .
					      "Content-type: text/html; charset=iso-8859-1\n" .
					      'X-Mailer: PHP/' . phpversion();
	
	// 				echo "<BR>HEADERS: ".$headers;								
	// 				echo "TO: ".$to;
	// 				echo "<br>SUBJECT: ".$subject;
	// 				echo "<BR>MESSAGE: ".$message;
	
			 ini_set('SMTP', EMAIL_SMTP_SERVER);
			 ini_set('smtp_port', EMAIL_SMTP_PORT);
	
	       $success = mail( $RECIPIENTS, $SUBJECT, $message, $headers  );
       }
       
       if ( !$success )
       {
           return 'Error Sending Confirmation E-mail!';		// TODO: replace with a label
       }    	
       else
       {
	        return 'Confirmation E-mail Successfully Sent';	// TODO: replace with a label
        }   

    }
    
//     // sends offline registration confirmation e-mail to admin and registrant
//     private function sendConfirmationEmail($appendHTML = false)		// NOTE: set to 'true' in the case of event_id = 14 (Winter Conference)
//     {
// 	    // retrieve basic confirmation e-mail info.
// 	    $INFO_FIELDS_TOTAL = 8;
// 	    $emailInfo = $this->getConfirmEmailInfo($this->reg_id);
// 	    
// 	    $financeGetter = new FinancialTools();
// 	    
// 	    // retrieve financial data for inclusion in e-mail
// 	    $rulesApplied = array();
// 	    $basePriceForThisGuy = 0;
// 	    $priceRules = array();
// 	    $scholarships = array();
// 	    $cash_paid = 0;
// 	    $cash_owed = 0;
// 	    $cc_paid = 0;
// 	    $cc_owed = 0;
// 	    
// 	    $balance_owing = $financeGetter->calcBalanceOwing( $this->reg_id, $rulesApplied, $basePriceForThisGuy, $priceRules, $scholarships, $cash_paid, $cash_owed, $cc_paid, $cc_owed);	  		
// 	    $eventBasePrice = $this->getEventBasePrice($this->event_id);
// 	    
// 	    if (isset($emailInfo)&&(count($emailInfo) == $INFO_FIELDS_TOTAL))
// 	    {
// 	    
// 	// 	    $confirmationLabels = new MultiLingual_Labels( SITE_LABEL_PAGE_GENERAL, SITE_LABEL_SERIES_SITE, TEMPLATE_SIGNUP_CONFIRMATION, $langID );
// 	       $to = $emailInfo['email'];
// 	       $subject = $this->labels->getLabel('[Subject]');
// 	       
// 	       // HACK for french and eastern WC
// 	       $headers = '';
// 	       $htmlBreak = '';
// 	       $message = '';
// 	                       
// 	       // To send HTML mail, the Content-type header must be set
// 	       if ( $appendHTML == true )
// 	       {
// 	           ;
// 	           $headers .= 'MIME-Version: 1.0' . "\r\n";
// 	           $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
// 	           $htmlBreak = '<br/>';
// 	           
// 	           $message .= '<html><body>';	           	           
// 	       }
// 	       
// 	       // Create the message
// 	
// 	       $message .= $this->labels->getLabel('[ThankYou]')." ". $emailInfo['event_name'] ."\n" . $htmlBreak;
// 	       $message .= $this->labels->getLabel('[ConfirmationNumber]').': ' . $emailInfo['confirmNum'] . "\n" . $htmlBreak;
// 	       $message .= $this->labels->getLabel('[fName]').': ' . $emailInfo['person_fname']. "\n" . $htmlBreak;
// 	       $message .= $this->labels->getLabel('[lName]').': ' . $emailInfo['person_lname']. "\n" . $htmlBreak;
// 	       
// 	       $message .= "\n" . $htmlBreak;
// 	       $message .= "---- ".$this->labels->getLabel('[FinanceInfo]')." ----\n" . $htmlBreak;
// 	       $message .= "\n" . $htmlBreak;	 
// 	       
//           // event base price
// 	       $message .= $this->labels->getLabel('[eventBasePrice]')."  ";	             
// 	       $message .= '$'.$emailInfo['event_basePrice']."\n" . $htmlBreak;          
//           
//           // Total of above base price + discounts
// 	       $message .= $this->labels->getLabel('[BasePriceForYou]')."  ";	             
// 	       $message .= '$'.$basePriceForThisGuy."\n" . $htmlBreak;   
// 	       $message .= "\n" . $htmlBreak;    	                
// 	       
// 	       //credit card transaction information
// 	       	       
// 	       $message .= $this->labels->getLabel('[ccProcessed]')."  ";	             
// 	       $message .= '$'.$cc_paid."  \t\t";			// "\n" . $htmlBreak;
// 	       $message .= "\n" . $htmlBreak;
// 	       
// 	       $message .= $this->labels->getLabel('[BalanceOwing]')."  ";	 
// 	       
// 	       if (substr($balance_owing,0,1)=='-')
// 	       {
// 	       	$message .= "-$".substr($balance_owing,1). "\n" . $htmlBreak;	
//        	 }
//        	 else 
//        	 {           	       
// 	       	$message .= "$".$balance_owing. "\n" . $htmlBreak;	
//        	 }	       	   
// 	       
// 	       // event admin specific:  event confirmation text
// 	       $message .= $emailInfo['confirm_text'];
// 	
// 	       $message .= "\n" . $htmlBreak;
// 	       $message .= "-------------------------------\n" . $htmlBreak;
// 	       $message .= "\n" . $htmlBreak;
// 	       $message .= "\n" . $htmlBreak;
// 	       
// 	       
// 	       // check if proper event e-mail address was found, if NOT then use default address
// 	       $event_email = $emailInfo['event_email'];
//          if(!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $event_email) )
//          {
//             // echo "The e-mail was not valid";
//             $isValid = false;
// 				$event_email = page_ConfirmRegistration::DEFAULT_EMAIL;
//          } 	       
// 	       
// // 	       $message .= $this->labels->getLabel('[footer]'). $event_email . "\n" . $htmlBreak;
// 	        
// 	       // add the end tags
// 	       if ( $appendHTML )
// 	       {
// 	           $message .= "</body></html>";
// 	       }
// 	       
// 	       $message = wordwrap($message, 70);



// 	       
// 	
// 	       $headers .= 'From: '.$event_email . "\n" .
// 				'Reply-To: '.$event_email . "\n" .
// 				'X-Mailer: PHP/' . phpversion();

// // 				echo "<BR>HEADERS: ".$headers;								
// // 				echo "TO: ".$to;
// // 				echo "<br>SUBJECT: ".$subject;
// // 				echo "<BR>MESSAGE: ".$message;

// 			 ini_set('SMTP', EMAIL_SMTP_SERVER);
// 			 ini_set('smtp_port', EMAIL_SMTP_PORT);
// 	
// 	       $success = mail( $to, $subject, $message, $headers  );
// 	       if ( !$success )
// 	       {
// 	           return 'Error Sending Confirmation E-mail!';		// TODO: replace with a label
// 	       }    	
// 	       else
// 	       {
// 		        return 'Confirmation E-mail Successfully Sent';	// TODO: replace with a label
// 	        }   
//         }
//         else	// could not get confirmation info
//         {
// 	        return 'Error Retrieving Confirmation Information: E-mail *Not* Sent!';	// TODO: replace with a label
//         }
//     }
//     
//     
//      // set confirmation e-mail address and info by retrieving from the database (using registration ID)
//      // @return [ARRAY] an array of email, event_name, confirm_text, event_basePrice, confirmNum, person_fname, person_lname, campus_name, and adminEmail
//     protected function getConfirmEmailInfo($regID)
//      {
// 	     $infoArray = array();
// 	     
// 	     $email = '';
// 	     $confirmNum = '';
// 	     $person_fname = '';
// 	     $person_lname = '';
// 	     $event_name = '';
// 	     $confirm_text = '';
// 	     
// 			// determine if parameter has been set
// 			if (isset($regID))
// 			{	     
// 	
// 				// get registration info for in confirmation e-mail (and get registrant's e-mail address)	        	
// 	        $regs = new RowManager_RegistrationManager();
// 	        $regs->setRegID($regID);
// 	        $people = new RowManager_PersonManager();
// 	        $event = new RowManager_EventManager;
// 	        
// 	        $personRegs = new MultiTableManager();
// 	        $personRegs->addRowManager($people);
// 	        $personRegs->addRowManager($regs, new JoinPair( $regs->getJoinOnPersonID(), $people->getJoinOnPersonID()));
// 	        $personRegs->addRowManager($event, new JoinPair ($regs->getJoinOnEventID(), $event->getJoinOnEventID()));
// 	        
// 	        $personList = $personRegs->getListIterator();
// 	        $personArray = $personList->getDataList();		
// // 	        echo "<pre>".print_r($personArray,true)."</pre>"; 
// 	          
// 	         reset($personArray);
// 	        	foreach(array_keys($personArray) as $k)
// 				{
// 					$person = current($personArray);	
// 					$email = $person['person_email'];
// 					$person_fname = $person['person_fname'];	// NOTE: should only be one person per registration (ENFORCE??)
// 					$person_lname = $person['person_lname'];
// 					$confirmNum = $person['registration_confirmNum'];
// 					$event_name = $person['event_name'];
// 					$confirm_text = $person['event_emailConfirmText'];	
// 					$event_basePrice = $person['event_basePrice'];	
// 					$event_contactEmail = $person['event_contactEmail'];
// 					
// 					next($personArray);	
// 				}

// 				$infoArray['event_email'] = $event_contactEmail;
// 				$infoArray['email'] = $email;
// 				$infoArray['person_fname'] = $person_fname;
// 				$infoArray['person_lname'] = $person_lname;
// 				$infoArray['confirmNum'] = $confirmNum;
// 				$infoArray['event_name'] = $event_name;
// 				$infoArray['confirm_text'] = $confirm_text;
// 				$infoArray['event_basePrice'] = $event_basePrice;
//         } 
//         
//         return $infoArray;	//$email.','.$event_name.','.$confirmNum.','.$event_basePrice.','.$person_fname.','.$person_lname.';
//      } 
    

        
      
}

?>