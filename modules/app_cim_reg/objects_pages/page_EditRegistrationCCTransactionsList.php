<?php		/** THIS IS THE PRIMARY CC TRANSACTION PROCESSING UI CLASS **/

$toolName = 'objects/Moneris/CreditCardProcessor.php';
$toolPath = Page::findPathExtension( $toolName );
require_once( $toolPath.$toolName);

/**
 * @package cim_reg
 */ 
/**
 * class FormProcessor_EditRegistrationCCTransactionsList 
 * <pre> 
 * This page is used to edit credit card transactions for some registration.
 * </pre>
 * @author Russ Martin
 * Date:   10 Jul 2007
 */
 // RAD Tools: AdminBox Page
class  FormProcessor_EditRegistrationCCTransactionsList extends PageDisplay_FormProcessor_AdminBox {

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
	//             form_field_type = the data type of the field
    //                               T = Text / String
    //                               N = Numeric 
    //                               B = Boolean
    //                               D = Date ( 3 lists boxes day/mon/year)
    //                            Time = Time ( 3 list boxes  HH/MM/Am )
    //                        DateTime = Date + Time pickers ...
    //
    //             invalid_value = A value that is considered incorrect for this
    //                             form field.  Leaving it blank is equivalent 
    //                             to form_value != '' 
    const FORM_FIELDS = 'cctransaction_cardName|T|,cctype_id|N|,cctransaction_cardNum|N|,cctransaction_expiry|T|,cctransaction_billingPC|T|,cctransaction_processed|B|<skip>,cctransaction_amount|N|,reg_id|T|<skip>,cctransaction_refnum|T|<skip>,form_name|T|<skip>';	//,cctransaction_id|T|<skip>';
    
    /** The list of field types to be displayed in the form */
    // NOTE: if a field isn't displayed, put a '-' for it's entry.
    const FORM_FIELD_TYPES = 'textbox||64,droplist|20,textbox|20|25,textbox|6|5,textbox|7|7,hidden,textbox|10|15|style="border: 4px solid #FF6633",-,-,hidden';	//,hidden';		
    
    /** The list of fields to be displayed in the data list */
    const DISPLAY_FIELDS = 'cctransaction_cardName,cctype_id,cctransaction_cardNum,cctransaction_expiry,cctransaction_billingPC,cctransaction_processed,cctransaction_amount';
    
    /** The Querystring Field for which entry is currently being edited ... */
    const MULTILINGUAL_PAGE_KEY = 'FormProcessor_EditRegistrationCCTransactionsList';

	//VARIABLES:
	
	/** @var [STRING] The path to the module's root directory. */
	protected $pathModuleRoot;
	
	/** @var [STRING] The initilization variable for the dataManager. */
	protected $cctransaction_id;
	
/* no List Init Variable defined for this DAObj */
	
	/** @var [INTEGER] Foreign Key needed by Data Manager */
	protected $reg_id;

	/** @var [INTEGER] person ID used for CC transactions */
	protected $person_id;

	/** @var [INTEGER] confirmation # used for CC transaction's unique order ID */
	protected $confirmNum;
	
	/** @var [BOOLEAN] used to indicate over-payment before it is processed */		
	protected $has_overpaid;	
		
	/** @var [OBJECT] object used to process CC transactions (via Moneris) */		
	protected $creditProcessor;


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
	 * @param $sortBy [STRING] Field data to sort listManager by.
	 * @param $cctransaction_id [STRING] The init data for the dataManager obj
	 * @param $reg_id [INTEGER] The foreign key data for the data Manager
	 * @param $cctype_id [INTEGER] The foreign key data for the data Manager
	 * @return [void]
	 */
    function __construct($pathModuleRoot, $viewer,  $formAction, $sortBy, $cctransaction_id='', $reg_id)
    {
        // NOTE: be sure to call the parent constructor before trying to 
        //       use the ->formXXX arrays...
        $fieldList = FormProcessor_EditRegistrationCCTransactionsList::FORM_FIELDS;
        $fieldTypes = FormProcessor_EditRegistrationCCTransactionsList::FORM_FIELD_TYPES;
        $displayFields = FormProcessor_EditRegistrationCCTransactionsList::DISPLAY_FIELDS;
        parent::__construct($viewer, $formAction, $sortBy, $fieldList, $fieldTypes, $displayFields );

        $this->pathModuleRoot = $pathModuleRoot;
        
        if ($cctransaction_id != '') 
        {
        		$this->cctransaction_id = $cctransaction_id;
//         			        echo "CC TRANS";
//         		$formAction .= '&'.modulecim_reg::CCTRANS_ID.'='.$this->cctransaction_id;
        		$this->dataManager = new RowManager_CreditCardTransactionManager($cctransaction_id);
     		}
     		else
     		{
	     		$this->dataManager = new RowManager_CreditCardTransactionManager();
     		}

        $this->reg_id = $reg_id;
		  $this->setPersonID($reg_id);		// ALSO SETS CONFIRMATION #
		  $this->has_overpaid = false;
       
        $this->creditProcessor = new CreditCardProcessor();
        
        // figure out the important fields for the dataManager
        $fieldsOfInterest = implode(',', $this->formFields);
        
//        $this->dataManager = new RowManager_CreditCardTransactionManager();	// $cctransaction_id );
//         $this->dataManager->setFieldsOfInterest( $fieldsOfInterest );
        $this->dataManager->setRegID($this->reg_id);
        
        if ($this->cctransaction_id != '') {
        		$this->dataManager->loadByCCTransactionID($this->cctransaction_id);
     	  }
        $this->formValues = $this->dataManager->getArrayOfValues();
    

        // now initialize the labels for this page
        // start by loading the default field labels for this Module
        $languageID = $viewer->getLanguageID();
        $seriesKey = modulecim_reg::MULTILINGUAL_SERIES_KEY;
        $pageKey = modulecim_reg::MULTILINGUAL_PAGE_FIELDS;
        $this->labels = new MultilingualManager( $languageID, $seriesKey, $pageKey );
        
        // then load the page specific labels for this page
        $pageKey = FormProcessor_EditRegistrationCCTransactionsList::MULTILINGUAL_PAGE_KEY;
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
	    
        // if this is a delete operation then
        if ( $this->opType == 'D' ) {
        
            if ( $this->shouldDelete ) {
            
                $this->dataManager->deleteEntry();
            }
            
        } else {
        // else 
        
        		$eventPrice = new MultiTableManager();
        		$event = new RowManager_EventManager();
        		$registration = new RowManager_RegistrationManager();
        		$registration->setRegID($this->reg_id);
        		$eventPrice->addRowManager($event);
        		$eventPrice->addRowManager($registration, new JoinPair($registration->getJoinOnEventID(), $event->getJoinOnEventID()));
        		
        		$eventList = $eventPrice->getListIterator();
        		$eventArray = $eventList->getDataList();
        		
        		$event_price = 0;
        		foreach( array_keys($eventArray) as $k )
        		{
	        		$record = current($eventArray);
	        		$event_price = $record['event_basePrice'];		// should be only one event price for the event registration
	        		next($eventArray);
        		}
        
        		$amount_being_paid = $this->formValues['cctransaction_amount'];
        		$prev_paid = $this->getPreviousPaid();
        		
        		// TODO: once balance_owing has trigger, use the following:
        		// if ($amount_being_paid > $this->getBalanceOwing)
        		if (($amount_being_paid + $prev_paid) > $event_price)	// Do NOT allow over-payment
        		{
	        		$this->has_overpaid = true;
	        		
	        		// Ensure that no erroneous CC receipt page is shown, by unsetting cardNum POST variable since
	        		// if (isset($_POST['cctransaction_cardNum'])) is the condition causing branch to receipt page
	        		unset($_POST[ 'cctransaction_cardNum' ]);
        		}
        		else
        		{        
	            // save the value of the Foriegn Key(s)
	            $this->formValues[ 'reg_id' ] = $this->reg_id;
	            
	            $this->formValues[ 'cctransaction_refnum' ] = null;
	        /*[RAD_ADMINBOX_FOREIGNKEY]*/
	            
	        		  // add cents to amount if required
	     		    $amount = $this->formValues['cctransaction_amount'];
	     		    $dollar_pattern = '([0-9]+\.[0-9][0-9])';	// NOTE: does NOT match '.05'; user MUST put digit before the '.'
	     		    if (!preg_match($dollar_pattern, $amount))
	     		    {
	        		    $amount .= '.00';		//assume that cents are missing from string (required for CC processing)
	     		    }        
// 	     		    echo '<br>amount = '.$amount;
	     		    
	        		 $this->formValues['cctransaction_amount'] = $amount;
	        
	            // Store values in dataManager object
	            $this->dataManager->loadFromArray( $this->formValues );
	//              echo "<pre>".print_r($this->formValues ,true)."</pre>";  
	            
	            // Save the values into the Table.
	            if (!$this->dataManager->isLoaded()) {
	        	            
	                $this->dataManager->createNewEntry();		// fortunately, default is to mark transaction as NOT processed
	                $ccTransID = $this->dataManager->getID();		//	echo "CCTRANS_ID == ".$ccTransID;
	                
	                // TO ADD TO DB: sequence # (ref num), approval (auth) code, response code (response code: [0,49] approved,   [50,999] declined, Null   incomplete)
	                // message (APPROVED, DECLINED, CALL FOR, HOLD CARD (PICK UP CARD)
	                
	                // NOTE: person_id and confirmNum were already set via helper method with reg_id parameter, called in constructor
						 $timestamp = strtotime("now");
						 $date = date('Y-m-d_H:i:s', $timestamp);
	        		    $order_id = 'C4C'.$this->confirmNum.$date;        		   
	        		    	        		    
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
							$this->dataManager->loadFromArray( $this->formValues );
							$this->dataManager->updateDBTable();
							
							// send next page updated information, including a "hidden" value
							$_POST['cctransaction_processed'] = 1;
						}
	// 					else 
	// 					{
	// 						$this->error_message = $resultMessage;
	// 					}               
	
	            } else {
		            // retrieve old values
		            
		            // if card name, card-type, card number, card expiry, or card postal code is to be updated
		            // then VOID transaction (if possible: batches close between 10-11 PM EST daily; otherwise refund the customer)
		            
		            // VOID requires 'order_id' and 'txn_number'
		            
		            // refund requires 'order_id', 'txn_number', and some $$$ amount
		            
		            // if only amount is changing, check first to see if 
		            
		            // update "processed" flag and timestamp of transaction
		            
		            // update information
	                $this->dataManager->updateDBTable();
	            }
        		} 
            
            
        } // end if
        
        // now Clear out dataManager & FormValues
        $this->dataManager->clearValues();
        $this->formValues = $this->dataManager->getArrayOfValues();

        
        // on a successful update return cctransaction_id to ''
        $this->cctransaction_id='';
        
        
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
        
        
        
        /*
         * store the link values
         */
        // example:
            // $this->linkValues[ 'view' ] = 'add/new/href/data/here';


        // store the link labels
        $this->linkLabels[ 'edit' ] = $this->labels->getLabel( '[Edit]' );
        $this->linkLabels[ 'del'  ] = $this->labels->getLabel( '[Delete]' );
        $this->linkLabels[ 'cont' ] = $this->labels->getLabel( '[Continue]');
        // $this->linkLabels[ 'view' ] = 'new link label here';

        
        
        /*
         * store any additional link Columns
         */
        // example:
            //$title = $this->labels->getLabel( '[title_groups]');
            //$columnLabel = $this->labels->getLabel( '[groups]');
            //$link = $this->linkValues[ 'groups' ];
            //$fieldName = 'accessgroup_id';
            //$this->addLinkColumn( $title, $columnLabel, $link, $fieldName);
            
            
        /*
         * Update any label tags ...
         */
        // example:
            // $name = $user->getName();
            // $this->labels->setLabelTag( '[Title]', '[userName]', $name);


        // NOTE:  this parent method prepares the $this->template with the 
        // common AdminBox data.  
        $this->prepareTemplate( $path );
        
        
        // store the statevar id to edit
        $this->template->set( 'editEntryID', $this->cctransaction_id );
        
		  $this->formValues['form_name'] = 'ccTransForm';        
        
       
        // store all the fields to the template
        $this->setFormFieldsToTemplate();
        
        /*
         * Form related Template variables:
         */
        
        
        /*
         * Insert the date start/end values for the following date fields:
         */
        // example:
            //$this->template->set( 'startYear_[fieldName]', 2000);
            //$this->template->set( 'endYear_[fieldName]', 2010);



        /*
         * List related Template variables :
         */
        // Store the XML Node name for the Data Access Field List
        $xmlNodeName = RowManager_CreditCardTransactionManager::XML_NODE_NAME;
        $this->template->set( 'rowManagerXMLNodeName', $xmlNodeName);
        
        // store the primary key field name for the data being displayed
        $this->template->set( 'primaryKeyFieldName', 'cctransaction_id');
        
        // store data list to the template
        // NOTE: we initialize it here to make sure we capture any new data 
        // from a recent processData() call.
        $dataAccessManager = new RowManager_CreditCardTransactionManager();
        $dataAccessManager->setSortOrder( $this->sortBy );
        $dataAccessManager->setRegID($this->reg_id);
//        $this->dataList = new CreditCardTransactionList( $this->sortBy );
        $this->dataList = $dataAccessManager->getListIterator();
        $this->template->setXML( 'dataList', $this->dataList->getXML() );
        
 
        // replace card type IDs with card type descriptions
/* 		  $cardTypes = new RowManager_CreditCardTypeManager();
        $cardTypesList = $cardTypes->getListIterator(); 
        $cardTypesArray = $cardTypesList->getDataList();	
//        echo "<pre>".print_r($cardTypesArray,true)."</pre>";    
         
         $cardType_info = array();
         reset($cardTypesArray);
        	foreach(array_keys($cardTypesArray) as $k)
			{
				$cardType = current($cardTypesArray);	
				$cardType_info[$cardType['cctype_id']] = $cardType['cctype_desc'];		
				
				next($cardTypesArray);

			}
			$this->template->set('list_cctype_id', $cardType_info ); */
			
			        // get a list of all credit card type IDs
        $ccType = new RowManager_CreditCardTypeManager();
        $ccType->setSortOrder( 'cctype_id' );
        $ccTypeList = new ListIterator($ccType);	
        $ccTypeArray = $ccTypeList->getDropListArray();

        $this->template->set( 'list_cctype_id', $ccTypeArray );          
        
        
               
        // replaces 0s and 1s with no's and yes's
        $boolArray = array();
        $boolArray['0'] = 'no';
        $boolArray['1'] = 'yes';

        $this->template->set( 'list_cctransaction_processed', $boolArray );     
        
        /*
         * Add any additional data required by the template here
         */
       $this->template->set( 'disableHeading', true ); 
       $this->template->set( 'formAnchor', 'RegCCTransactionForm'); 

        
        $templateName = 'siteAdminBox.php';
        // if you are creating a custom template for this page then 
		// replace $templateName with the following:
		//$templateName = 'page_EditRegistrationCCTransactionsList.php';
		
		return $this->template->fetch( $templateName );
        
    }
    

        // set person ID by retrieving from the database (using registration ID)
    protected function setPersonID($regID)
     {
			// determine if parameter has been set
			if (isset($regID))
			{	     
		     
	        // get registration ID for the rest of the reg. process
	        $regs = new RowManager_RegistrationManager();
	        $regs->setRegID($regID);
	        $people = new RowManager_PersonManager();
	        
	        $personRegs = new MultiTableManager();
	        $personRegs->addRowManager($people);
	        $personRegs->addRowManager($regs, new JoinPair( $regs->getJoinOnPersonID(), $people->getJoinOnPersonID()));
	        
	        $personList = $personRegs->getListIterator( );
	        $personArray = $personList->getDataList();		
	//        echo "<pre>".print_r($personArray,true)."</pre>"; 
	          
		
	         reset($personArray);
	        	foreach(array_keys($personArray) as $k)
				{
					$person = current($personArray);	
					$this->person_id = $person['person_id'];	// NOTE: should only be one person per registration (ENFORCE??)
					$this->confirmNum = $person['registration_confirmNum'];		
					
					next($personArray);	
				}
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
		
		// Function used to retrieve previous confirmed payments for the current registration record
		protected function getPreviousPaid()  
		{
			// Get previously processed CC transactions
		   $ccTransManager = new RowManager_CreditCardTransactionManager();
		   $ccTransManager->setRegID($this->reg_id);
		   $ccTransManager->setProcessed(true);
		   
		   $ccTransList = $ccTransManager->getListIterator();
		   $ccTransArray = $ccTransList->getDataList();
		   
		   $paid = 0;
		   reset($ccTransArray);
		   foreach (array_keys($ccTransArray) as $key)
		   {
			   $record = current($ccTransArray);
			   $paid += $record['cctransaction_amount'];
			   next($ccTransArray);
		   }
		   			   
			// Get previously processed cash transactions
		   $cashTransManager = new RowManager_CashTransactionManager();
		   $cashTransManager->setRegID($this->reg_id);
		   $cashTransManager->setReceived(true);
		   
		   $cashTransList = $cashTransManager->getListIterator();
		   $cashTransArray = $cashTransList->getDataList();
		   
		   reset($cashTransArray);
		   foreach (array_keys($cashTransArray) as $key)
		   {
			   $record = current($cashTransArray);
			   $paid += $record['cashtransaction_amtPaid'];
			   next($cashTransArray);
		   }		
		   
		   return $paid;
	   }	   

			   
		// Function used to retrieve balance owing for the current registration record
		protected function getBalanceOwing()  
		{
		   $regManager = new RowManager_RegistrationManager($this->reg_id);	
		   return $regManager->getBalanceOwing();
	   }		   
		
		// Retrieve over-payment status
		public function hasOverPaid()
		{
			return $this->has_overpaid;
		}
}

?>