<?php

require "mpgClasses.php";

//
//  CREDIT CARD PROCESSOR
// 
//  DESCRIPTION:
//		Class containing methods for processing CC transactions using the Moneris API
//

/**
 * class CreditCardProcessor
 * <pre> 
 * This is a class that processes CC transactions using the Moneris API
 * @author Hobbe Smit
 */

class  CreditCardProcessor  {

	//CONSTANTS:
	const APPROVED = 'APPROVED';
	const DECLINED = 'DECLINED';
	
   const TEST_STORE_ID = 'store3';
	const LIVE_STORE_ID = 'monmpg5324';
	const DEFAULT_STORE_ID = CreditCardProcessor::LIVE_STORE_ID;
	
	const TEST_API_TOKEN = 'yesguy';
	const LIVE_API_TOKEN = 'Onnmm8Jrdjp8nkFZrU0M';
	const DEFAULT_API_TOKEN = CreditCardProcessor::LIVE_API_TOKEN;
	
	const TRANSACTION_TYPE_PURCHASE = 'purchase';
	const TRANSACTION_TYPE_VOID = 'purchasecorrection';
	const TRANSACTION_TYPE_REFUND = 'refund';
	
	const CRYPT_SSL = '7';
		//7 - SSL enabled merchant
		//8 - Non Secure Transaction (Web or Email Based) 
		
	const TRANSACTION_TIMESTAMP = 'TransDate|TransTime';
		
	// variables that would ideally be constants
	private  $MONERIS_RECEIPT_KEYS;  

   /**************************** Request Variables *******************************/

    /** @var [STRING] Unique identifier for Moneris customer store. */
	protected $store_id;// = DEFAULT_STORE_ID;

    /** @var [ARRAY] Unique token used for a particular Moneris store's transactions. */
	protected $api_token;// = DEFAULT_API_TOKEN;	
	
	
	//CLASS CONSTRUCTOR
	//************************************************************************
	/**
	 * function __construct
	 * <pre>
	 * Initialize this object.
	 * </pre>
	 * @return [void]
	 */		 
    function __construct( $storeID = CreditCardProcessor::DEFAULT_STORE_ID, $apiToken = CreditCardProcessor::DEFAULT_API_TOKEN) 
    {
	    $this->store_id = $storeID;
	    $this->api_token = $apiToken;
	    
	    $this->MONERIS_RECEIPT_KEYS = array('ccreceipt_sequencenum'=>'ReferenceNum', 'ccreceipt_authcode'=>'AuthCode', 
	    											'ccreceipt_responsecode'=>'ResponseCode', 'ccreceipt_message'=>'Message', 
	    											'ccreceipt_moddate'=>CreditCardProcessor::TRANSACTION_TIMESTAMP);
	 }
	 
	 // return the Moneris receipt response key given cim_reg_ccreceipt column name
	 function getReceiptKey($columnName)
	 {
		 if (isset($this->MONERIS_RECEIPT_KEYS[$columnName]))
		 {
			 return $this->MONERIS_RECEIPT_KEYS[$columnName];
		 }
		 else
		 {
			 return;
		 }
	 }
	  
//************************************************************************

    /** PROCESS A SIMPLE CREDIT CARD TRANSACTION **/	
    // $orderID must be unique
    // $ccDate refers to expiry date on the credit card
	function purchase($customerID, $orderID, $amount, $ccNum, $ccDate)
	{		
		/************************* Transactional Variables ****************************/		
		$type = CreditCardProcessor::TRANSACTION_TYPE_PURCHASE;
// 		$cust_id='CUST13343';
// 		$order_id='ord-'.date("dmy-G:i:s");
// 		$amount='10.68';
// 		$pan='4242424242424242';
// 		$expiry_date='0812';		//YYMM -- yes, it is opposite to what is shown on card...
		$crypt = CreditCardProcessor::CRYPT_SSL;
		
		/*********************** Transactional Associative Array **********************/
		
		$txnArray=array('type'=>$type,
		     		    'order_id'=>$orderID,
		     		    'cust_id'=>$customerID,
		    		    'amount'=>$amount,
		   			    'pan'=>$ccNum,
		   			    'expdate'=>$ccDate,
		   			    'crypt_type'=>$crypt
		   		       );
		   		       
//  		echo "<br>Trans. Array: <pre>".print_r($txnArray,true)."</pre>";   
//  		echo "<br>store id = ".$this->store_id;
//  		echo "<br>api token = ".$this->api_token;		       
		
		/**************************** Transaction Object *****************************/
		
		$mpgTxn = new mpgTransaction($txnArray);
		
		/****************************** Request Object *******************************/
		
		$mpgRequest = new mpgRequest($mpgTxn);
		
		/***************************** HTTPS Post Object *****************************/
		
		$mpgHttpPost  = new mpgHttpsPost($this->store_id,$this->api_token,$mpgRequest);
		
		/******************************* Response ************************************/
		
		$mpgResponse=$mpgHttpPost->getMpgResponse();
		
// 		print("\nCardType = " . $mpgResponse->getCardType());
// 		print("\nTransAmount = " . $mpgResponse->getTransAmount());
// 		print("\nTxnNumber = " . $mpgResponse->getTxnNumber());
// 		print("\nReceiptId = " . $mpgResponse->getReceiptId());
// 		print("\nTransType = " . $mpgResponse->getTransType());
// 		print("\nReferenceNum = " . $mpgResponse->getReferenceNum());
// 		print("\nResponseCode = " . $mpgResponse->getResponseCode());
// 		print("\nISO = " . $mpgResponse->getISO());
// 		print("\nMessage = " . $mpgResponse->getMessage());
// 		print("\nAuthCode = " . $mpgResponse->getAuthCode());
// 		print("\nComplete = " . $mpgResponse->getComplete());
// 		print("\nTransDate = " . $mpgResponse->getTransDate());
// 		print("\nTransTime = " . $mpgResponse->getTransTime());
// 		print("\nTicket = " . $mpgResponse->getTicket());
// 		print("\nTimedOut = " . $mpgResponse->getTimedOut());

		return $mpgResponse;
	} 
	
	function refund($transNum, $orderID, $amount)
	{
	}
	
	// NOTE: I believe VOIDs (and possibly refunds??) can only be done while batch is still open (before 10-11 PM EST)
	function void_trans($transNum, $orderID)
	{
	}
} 
?>
