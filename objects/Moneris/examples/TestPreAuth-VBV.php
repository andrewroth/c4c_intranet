<?php

## Example php -q TestPurchase-VBV.php "moneris" store

require "../mpgClasses.php";

/******************************* Request Variables ********************************/

$store_id='moneris';
$api_token='hurgle';

/****************************** Transactional Variables ***************************/

$type='cavv_preauth';
$order_id='ord-'.date("dmy-G:i:s");
$cust_id='CUST887763';
$amount='10.00';
$pan="4242424242424242";
$expiry_date="0812";
$cavv='AAABBJg0VhI0VniQEjRWAAAAAAA=';

/*************************** Transaction Associative Array ************************/

$txnArray=array(
				'type'=>$type,
	            'order_id'=>$order_id,
			    'cust_id'=>$cust_id,
	            'amount'=>$amount,
	            'pan'=>$pan,
	            'expdate'=>$expiry_date,
		        'cavv'=>$cavv
	           );

/****************************** Transaction Object *******************************/

$mpgTxn = new mpgTransaction($txnArray);

/******************************* Request Object **********************************/

$mpgRequest = new mpgRequest($mpgTxn);

/****************************** HTTPS Post Object *******************************/

$mpgHttpPost  =new mpgHttpsPost($store_id,$api_token,$mpgRequest);

/************************************ Response **********************************/

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

