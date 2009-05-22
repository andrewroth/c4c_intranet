<?php

##
## Example php -q TestPurchase.php store1
##

require "../mpgClasses.php";

/**************************** Request Variables *******************************/

$store_id='store3';
$api_token='yesguy';

/************************* Transactional Variables ****************************/

$type='purchase';
$cust_id='CUST13343';
$order_id='ord-'.date("dmy-G:i:s");
$amount='10.00';
$pan='4242424242424242';
$expiry_date='0812';	//YYMM
$crypt='7';

/*********************** Transactional Associative Array **********************/

$txnArray=array('type'=>$type,
     		    'order_id'=>$order_id,
     		    'cust_id'=>$cust_id,
    		    'amount'=>$amount,
   			    'pan'=>$pan,
   			    'expdate'=>$expiry_date,
   			    'crypt_type'=>$crypt
   		       );

/**************************** Transaction Object *****************************/

$mpgTxn = new mpgTransaction($txnArray);

/****************************** Request Object *******************************/

$mpgRequest = new mpgRequest($mpgTxn);

/***************************** HTTPS Post Object *****************************/

$mpgHttpPost  =new mpgHttpsPost($store_id,$api_token,$mpgRequest);

/******************************* Response ************************************/

$mpgResponse=$mpgHttpPost->getMpgResponse();

print("\nCardType = " . $mpgResponse->getCardType());
print("\nTransAmount = " . $mpgResponse->getTransAmount());
print("\nTxnNumber = " . $mpgResponse->getTxnNumber());
print("\nReceiptId = " . $mpgResponse->getReceiptId());
print("\nTransType = " . $mpgResponse->getTransType());
print("\nReferenceNum = " . $mpgResponse->getReferenceNum());
print("\nResponseCode = " . $mpgResponse->getResponseCode());
print("\nISO = " . $mpgResponse->getISO());
print("\nMessage = " . $mpgResponse->getMessage());
print("\nAuthCode = " . $mpgResponse->getAuthCode());
print("\nComplete = " . $mpgResponse->getComplete());
print("\nTransDate = " . $mpgResponse->getTransDate());
print("\nTransTime = " . $mpgResponse->getTransTime());
print("\nTicket = " . $mpgResponse->getTicket());
print("\nTimedOut = " . $mpgResponse->getTimedOut());

?>

