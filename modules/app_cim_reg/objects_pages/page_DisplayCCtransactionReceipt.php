<?php
/**
 * @package cim_reg
 */ 
/**
 * class page_DisplayCCtransactionReceipt 
 * <pre> 
 * Used to display the receipt for an event registration credit card transaction.
 * </pre>
 * @author Russ Martin
 * Date:   08 Aug 2007
 */
class  page_DisplayCCtransactionReceipt extends PageDisplay_FormProcessor		//DisplayList 
{

	//CONSTANTS:
	
	/** dummy fields... **/
	 const FORM_FIELDS = '';	//'ccreceipt_sequencenum|T|,ccreceipt_authcode|T|,ccreceipt_responsecode|T|,ccreceipt_message|T|,ccreceipt_moddate|T|';

	/** dummy field types... **/
	 const FORM_FIELD_TYPES = '';	//'-,-,-,-,-,-,-,-,-';//'textbox,droplist|20,textbox|20,textbox|6,textbox|7,hidden,textbox|10,-,hidden'; 
	 	
	/** The list of fields to be displayed */
    const DISPLAY_FIELDS = '';	//'ccreceipt_sequencenum,ccreceipt_authcode,ccreceipt_responsecode,ccreceipt_message,ccreceipt_moddate';
    
    /** The Multilingual Page Key for labels on this page */
    const MULTILINGUAL_PAGE_KEY = 'page_DisplayCCtransactionReceipt';
    

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
    function __construct($pathModuleRoot, $viewer, $sortBy, $reg_id, $cctrans_id='', $personID='') 	// $event_id, $campus_id,
    {
//        parent::__construct( page_DisplayCCtransactionReceipt::DISPLAY_FIELDS );

		  $formAction = '';
        $fieldList = page_DisplayCCtransactionReceipt::FORM_FIELDS;
        $fieldTypes = page_DisplayCCtransactionReceipt::FORM_FIELD_TYPES;
        $displayFields = page_DisplayCCtransactionReceipt::DISPLAY_FIELDS;
        parent::__construct($viewer, $formAction, $sortBy, $fieldList, $fieldTypes, $displayFields );
        
        $this->pathModuleRoot = $pathModuleRoot;
        $this->viewer = $viewer;
        $this->sortBy = $sortBy;

        $this->reg_id = $reg_id; 	
//         echo "REG_ID =".$reg_id;
        
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
        $campus = new RowManager_CampusManager();
        $assign = new RowManager_AssignmentsManager();
        $campusStatus = new RowManager_CampusAssignmentStatusManager();
		  $status = new RowManager_StatusManager();
       
     	  // join 2 tables together: cim_reg_registration & cim_hrdb_person
        $this->statusManager = new MultiTableManager();
        $this->statusManager->addRowManager($registration);			
        $this->statusManager->addRowManager( $person, new JoinPair( $person->getJoinOnPersonID(), $registration->getJoinOnPersonID()));
        $this->statusManager->addRowManager( $assign, new JoinPair ( $person->getJoinOnPersonID(), $assign->getJoinOnPersonID()));
        $this->statusManager->addRowManager( $campus, new JoinPair ( $campus->getJoinOnCampusID(), $assign->getJoinOnCampusID()));
        $this->statusManager->addRowManager( $campusStatus, new JoinPair ( $assign->getJoinOnStatusID(), $campusStatus->getJoinOnStatusID()));
        $this->statusManager->addRowManager( $status, new JoinPair( $registration->getJoinOnStatus(), $status->getJoinOnStatusID()));               
        
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
         $languageID = $viewer->getLanguageID();
         $seriesKey = modulecim_reg::MULTILINGUAL_SERIES_KEY;
         $pageKey = modulecim_reg::MULTILINGUAL_PAGE_FIELDS;
         $this->labels = new MultilingualManager( $languageID, $seriesKey, $pageKey );
         
         // then load the page specific labels for this page
         $pageKey = page_DisplayCCtransactionReceipt::MULTILINGUAL_PAGE_KEY;
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
	//        echo "<pre>".print_r($statusDataArray,true)."</pre>";  
	
				$registrant = '';
				$campusStatus = '';
				$campusName = '';
				$regStatus = '';  
				$confirmNum = '';
	        
	        reset($statusDataArray);
	        	foreach(array_keys($statusDataArray) as $k)
				{
					$personData = current($statusDataArray);
					
					if ((!isset($this->person_id))||($this->person_id == ''))
					{
						$this->person_id = $personData['person_id'];
					}
					
					$registrant = $personData['person_fname'].' '.$personData['person_lname'];
					$campusStatus =  $personData['assignmentstatus_desc'];
					$campusName = $personData['campus_desc'];
					$regStatus = $personData['status_desc'];
					
					$confirmNum = $personData['registration_confirmNum'];
					
					next($statusDataArray);
	
				}
							
						   
				$this->template->set('registrantName', $registrant );
				$this->template->set('campusStatus', $campusStatus );
				$this->template->set('campusName', $campusName );
				$this->template->set('regStatus', $regStatus );			
	
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
			}
			else	// show error message
			{
				$this->template->set('error', true);
				$this->template->set('message', $message );
			}	
			 
			         
        // store the Row Manager's XML Node Name
        $this->template->set( 'rowManagerXMLNodeName', RowManager_ReceiptManager::XML_NODE_NAME );
        
        // store the primary key field name for the data being displayed
        $this->template->set( 'primaryKeyFieldName', 'ccreceipt_sequencenum');


        /*
         *  Set up any additional data transfer to the Template here...
         */
        
   
        $templateName = 'page_DisplayCCtransactionReceipt.tpl.php';
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
    
  
    // sends CC transaction confirmation e-mail off to certain HQ folks
    private function sendCCTransactionEmail($msgTxt = '')		
    {
	    // retrieve basic confirmation e-mail info.
	    $RECIPIENTS = 'register@powertochange.org';
	    $SUBJECT = 'Campus for Christ Credit Card Transaction Received';
	    $FROM = 'registration@campusforchrist.org';
	    
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

			 $headers = "From: C4C Registration System <".$FROM.">\n" .
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

?>