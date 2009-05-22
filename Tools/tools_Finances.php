<?php

// First load the common Registration Summaries Tools object
// This object allows for efficient access to registration summary data (multi-table).
$fileName = 'Tools/tools_RegSummaries.php';
$path = Page::findPathExtension( $fileName );
require_once( $path.$fileName);

//
//  FINANCE TOOLS
// 
//  DESCRIPTION:
//		This set of routines helps us to perform calculations based on financial data.
//

/**
 * class RegSummaryTools
 * <pre> 
 * This is a generic class that gives access to useful multi-table 
 * registration summary functions
 * @author Hobbe Smit
 */

class  FinancialTools  {

	//CONSTANTS:
	const RECALC_NOTNEEDED = 0;
   const RECALC_COMPLETE = 1;
   const RECALC_NEEDED = 2;

	//VARIABLES:
    /** @var [ARRAY] Values managed by this object. */
//	protected $values;
	
	
	//CLASS CONSTRUCTOR
	//************************************************************************
	/**
	 * function __construct
	 * <pre>
	 * Initialize this object.
	 * </pre>
	 * @return [void]
	 */
    function __construct( ) 
    {}


	/********** NOTE: make sure 60 second PHP timeout is not activated: use event_id as filter ************/
	 /**
	 * function recalculateBalances
	 * <pre>
	 * re-calculates the balance owed by all the registrants for a particular event
	 * <br>Particularly useful when a volume rule has been triggered.
	 * </pre>
	 * @param $event_id [INTEGER] The unique id of the event we are dealing with.
	 * @return [VOID]
	 */	
	function recalculateBalances( $event_id, $campus_id = '' )
	{
		if (isset($event_id)&&($event_id != ''))
		{

			// retrieve registration records
			$regs = new RowManager_RegistrationManager();
			$regs->setEventID($event_id);
			$regsList = $regs->getListIterator();
			$regsArray = $regsList->getDataList();
			
		   reset($regsArray);
		  	foreach(array_keys($regsArray) as $k)
			{
				$record = current($regsArray);
				$reg_id = $record['registration_id'];
				
				$owed = $this->simpleCalcBalanceOwing($reg_id, $event_id, $campus_id);	
				
				// store calculated balance owing in registration record
				$singleReg = new RowManager_RegistrationManager($reg_id);
				$balance = array();
				$balance['registration_balance'] = $owed;
				$singleReg->loadFromArray( $balance );
				$singleReg->updateDBTable();			
				
				next($regsArray);
		
			}
		}
	}    
    

	//************************************************************************
	 /**
	 * function calcBalanceOwing
	 * <pre>
	 * calculates the balance owed by the person linked to a particular registration
	 * </pre>
	 * @param $registrant_id [INTEGER] The unique id of the registration we are dealing with.
	 * @return [INTEGER] the balance owing by the registrant
	 */
	function calcBalanceOwing( $registrant_id, &$rulesApplied = null, &$basePrice = null, &$priceRulesArray = array(), &$scholarships = array(), &$cash_rec = null, &$cash_owed = null, &$cc_rec = null, &$cc_owed = null, $eventID = '', $campusID = '') {	  		
		
	  // variables to fill with data
	  $eventBasePrice = '';
	  $priceRulesArray = array();
	  $rulesApplied = array();
	  
	  if ($eventID == '')
	  {

		  /** retrieve event ID from registration(s) array   **/
		  $registration = new RowManager_RegistrationManager();
		  $registration->setRegID($registrant_id);
	  	  $regsManager = $registration->getListIterator(); 
	     $regsArray = $regsManager->getDataList();	
	//     	echo "<pre>".print_r($regEventsArray,true)."</pre>";
	     	
		  //NOTE: should be only one record in array
	     reset($regsArray);
	     $result = current($regsArray);
	     $eventID = $result['event_id'];
	//     echo 'eventID = '.$eventID;
		}
     
		if ($campusID == '')
		{
		
	     /** Retrieve campus registration data for single registration **/
	     $summaryTool = new RegSummaryTools();
	     $regInfo = array();
	     $regInfo = $summaryTool->getCampusRegistrations($eventID, '', false, '', $registrant_id);
	     
	     //NOTE: should be only one key-value pair
	     reset($regInfo);
	     $campusID = key($regInfo);	// since key = campusID and value = total of registrations for that campus
	//     echo 'campusID = '.$campusID;
	  }

     /** Retrieve event base price **/
     $event = new RowManager_EventManager($eventID);
     $eventBasePrice = $event->getEventBasePrice();
     
     /** Retrieve price rules array **/
     $priceRules = new RowManager_PriceRuleManager();
     $priceRules->setEventID($eventID);
     $ruleManager = $priceRules->getListIterator(); 
     $priceRulesArray = $ruleManager->getDataList();	
 
  		/** Use found data to retrieve base price for the $registrant_id parameter **/
	  $balanceOwing = $this->getBasePriceForRegistrant($registrant_id,  $eventID, $campusID, $eventBasePrice, $priceRulesArray, $rulesApplied);
	  $basePrice = $balanceOwing;
//	  echo '0) original cost = '.$balanceOwing.'<br>';
//	  echo "<pre>".print_r($rulesApplied,true)."</pre>";
	  
	  /** Search for scholarships **/
//	  $scholarships = array();
	  $scholarships = $this->getScholarships($registrant_id);
//	  echo "<pre>".print_r($scholarships,true)."</pre>";
	  
	  /** Retrieve cash transactions **/
	  $cash_transactions = array();
	  $cash_transactions = $this->getCashTransactions($registrant_id);

	  /** Retrieve credit card transactions **/
	  $cc_transactions = array();
	  $cc_transactions = $this->getCCTransactions($registrant_id);	  
	  
	  
	  /** Calculate amount still owing **/
	      
     // subtract scholarship money from total owing
     $refund = array();
      reset($scholarships);
     	foreach(array_keys($scholarships) as $k)
		{
			$refund = current($scholarships);	
			
 			$balanceOwing -= $refund['scholarship_amount'];
// 			echo '1) new amount = '.$balanceOwing.'<br>';
 			
 			next($scholarships);			
		}
		
				
		// subtract cash transactions received
		$cash_paid = array();
		$cashReceived = 0;
		$cashOwed = 0;
      reset($cash_transactions);
     	foreach(array_keys($cash_transactions) as $k)
		{
			$cash_paid = current($cash_transactions);	
			
			if ($cash_paid['cashtransaction_recd'] == 1)
			{
				$cashReceived += $cash_paid['cashtransaction_amtPaid'];
 				$balanceOwing -= $cash_paid['cashtransaction_amtPaid'];
			}
			else
			{
				$cashOwed += $cash_paid['cashtransaction_amtPaid'];
			}
// 			echo '2) new amount = '.$balanceOwing.'<br>';
 			
 			next($cash_transactions);			
		}		
		
		// return cash received total if parameter initialized 
		if (isset($cash_rec))
		{
			$cash_rec = $cashReceived;
		}
		
		// return cash owed total if parameter initialized 
		if (isset($cash_owed))
		{
			$cash_owed = $cashOwed;
		}		
			  
		// subtract credit card transactions processed
		$cc_paid = array();
		$ccReceived = 0;
		$ccOwed = 0;
      reset($cc_transactions);
     	foreach(array_keys($cc_transactions) as $k)
		{
			$cc_paid = current($cc_transactions);	
			
			if ($cc_paid['cctransaction_processed'] == 1)
			{
 				$ccReceived += $cc_paid['cctransaction_amount'];
 				$balanceOwing -= $cc_paid['cctransaction_amount'];
			}
			else 
			{
 				$ccOwed += $cc_paid['cctransaction_amount'];
			}				

			
// 			echo '3) new amount = '.$balanceOwing.'<br><br>';
 			
 			next($cc_transactions);			
		}
		
		// return CC received total if parameter initialized 
		if (isset($cc_rec))
		{
			$cc_rec = $ccReceived;
		}
		
		// return CC owed total if parameter initialized 
		if (isset($cc_owed))
		{
			$cc_owed = $ccOwed;
		}			
		
		return $balanceOwing;
	
	}
	
	//************************************************************************
	 /**
	 * function calcBalanceOwing
	 * <pre>
	 * calculates the balance owed by the person linked to a particular registration
	 * </pre>
	 * @param $registrant_id [INTEGER] The unique id of the registration we are dealing with.
	 * @return [INTEGER] the balance owing by the registrant
	 */
	function simpleCalcBalanceOwing( $registrant_id,  $eventID = '', $campusID = '') {	  		
		
	  // variables to fill with data
	  $eventBasePrice = '';
	  $priceRulesArray = array();
// 	  $rulesApplied = array();
	  
	  if ($eventID == '')
	  {

		  /** retrieve event ID from registration(s) array   **/
		  $registration = new RowManager_RegistrationManager();
		  $registration->setRegID($registrant_id);
	  	  $regsManager = $registration->getListIterator(); 
	     $regsArray = $regsManager->getDataList();	
	//     	echo "<pre>".print_r($regEventsArray,true)."</pre>";
	     	
		  //NOTE: should be only one record in array
	     reset($regsArray);
	     $result = current($regsArray);
	     $eventID = $result['event_id'];
	//     echo 'eventID = '.$eventID;
		}
     
		if ($campusID == '')
		{
		
	     /** Retrieve campus registration data for single registration **/
	     $summaryTool = new RegSummaryTools();
	     $regInfo = array();
	     $regInfo = $summaryTool->getCampusRegistrations($eventID, '', false, '', $registrant_id);
	     
	     //NOTE: should be only one key-value pair
	     reset($regInfo);
	     $campusID = key($regInfo);	// since key = campusID and value = total of registrations for that campus
	//     echo 'campusID = '.$campusID;
	  }

     /** Retrieve event base price **/
     $event = new RowManager_EventManager($eventID);
     $eventBasePrice = $event->getEventBasePrice();
     
     /** Retrieve price rules array **/
     $priceRules = new RowManager_PriceRuleManager();
     $priceRules->setEventID($eventID);
     $ruleManager = $priceRules->getListIterator(); 
     $priceRulesArray = $ruleManager->getDataList();	
     
     $balanceOwing = 0;
 
  		/** Use found data to retrieve base price for the $registrant_id parameter **/
	  $balanceOwing = $this->getBasePriceForRegistrant($registrant_id,  $eventID, $campusID, $eventBasePrice, $priceRulesArray);
	  $basePrice = $balanceOwing;
//	  echo '0) original cost = '.$balanceOwing.'<br>';
//	  echo "<pre>".print_r($rulesApplied,true)."</pre>";
	  
	  /** Search for scholarships **/
	  $scholarships = array();
	  $scholarships = $this->getScholarships($registrant_id);
//	  echo "<pre>".print_r($scholarships,true)."</pre>";
	  
	  /** Retrieve cash transactions **/
	  $cash_transactions = array();
	  $cash_transactions = $this->getCashTransactions($registrant_id);

	  /** Retrieve credit card transactions **/
	  $cc_transactions = array();
	  $cc_transactions = $this->getCCTransactions($registrant_id);	  
	  
	  
	  /** Calculate amount still owing **/
	      
     // subtract scholarship money from total owing
     $refund = array();
      reset($scholarships);
     	foreach(array_keys($scholarships) as $k)
		{
			$refund = current($scholarships);	
			
 			$balanceOwing -= $refund['scholarship_amount'];
// 			echo '1) new amount = '.$balanceOwing.'<br>';
 			
 			next($scholarships);			
		}
		
				
		// subtract cash transactions received
		$cash_paid = array();
		$cashReceived = 0;
		$cashOwed = 0;
      reset($cash_transactions);
     	foreach(array_keys($cash_transactions) as $k)
		{
			$cash_paid = current($cash_transactions);	
			
			if ($cash_paid['cashtransaction_recd'] == 1)
			{
 				$balanceOwing -= $cash_paid['cashtransaction_amtPaid'];
			}

// 			echo '2) new amount = '.$balanceOwing.'<br>';
 			
 			next($cash_transactions);			
		}		
		
	
			  
		// subtract credit card transactions processed
		$cc_paid = array();
		$ccReceived = 0;
		$ccOwed = 0;
      reset($cc_transactions);
     	foreach(array_keys($cc_transactions) as $k)
		{
			$cc_paid = current($cc_transactions);	

			if ($cc_paid['cctransaction_processed'] == 1)
			{
 				$balanceOwing -= $cc_paid['cctransaction_amount'];
			}								
			
			
// 			echo '3) new amount = '.$balanceOwing.'<br><br>';
 			
 			next($cc_transactions);			
		}		
		
		return $balanceOwing;
	
	}
	
	


	

	/**
	 * function getBasePriceForRegistrant
	 * <pre>
	 * Returns registration cost for a particular registration, not including scholarship discounts
	 * </pre>
	 * Pre-condition: all variables must be initialized with proper values
	 *
	 * @param $regID [INTEGER]		registration ID
	 * @param $eventID [INTEGER]	event ID
	 * @param $campusID [INTEGER]	campus ID (precondition: must be associated directly with registration ID)
	 * @param $eventBasePrice [INTEGER]	the cost of the event per registration, before any discounts
	 * @param $priceRulesArray [ARRAY]	an array of the price rules applying to event denoted by $eventID
	 * @param &$rulesApplied [ARRAY REFERENCE]	reference to an array to be filled with applied rules	
	 * @return [INTEGER] $basePriceForThisGuy		the new base price for registration $regID (before scholarships)
	 */	
	function getBasePriceForRegistrant( $regID, $eventID, $campusID, $eventBasePrice, $priceRulesArray, &$rulesApplied = array())
	{
		// Need to manually calculate discounts for these exceptions:
		$BC_SUMMIT_2007 = 19;
		$MB_SUMMIT_2007 = 22;
		$LAKESHORE_SUMMIT_2007 = 25;
		$EASTERN_WC_2007 = 28;
		$AIA_NATIONAL_TRAINING = 33;
		$MARITIMES_SUMMIT_2008 = 34;
	
	    $basePriceForThisGuy = $eventBasePrice;
	    
	    
// 	     echo "<pre>".print_r($priceRulesArray,true)."</pre>";
	    
	    
	    // PUT SPECIAL EVENT EXCEPTIONS HERE AS CONDITIONAL STATEMENTS:
/*	    if ($eventID == $MARITIMES_SUMMIT_2008)
	    {
		    $FROSH_DISCOUNT_FIELD = 119;
		    
		    // first check for Frosh Discount
            $fieldValue = new RowManager_FieldValueManager();
// 	            $fieldValue->loadByFieldIDandRegID($rule['fields_id'],$regID);
			$fieldValue->setFieldID($FROSH_DISCOUNT_FIELD);
			$fieldValue->setRegID($regID);
         
         $valueListManager = $fieldValue->getListIterator(); 
         $fieldValueList = $valueListManager->getDataList();	
// 		         echo "<pre>".print_r($fieldValueList,true)."</pre>";
			
         reset($fieldValueList);
         $record = current($fieldValueList);		         	

			// CHECK TO SEE IF SOME FIELD VALUE HAS BEEN SET FOR GIVEN PARAMETERS
// 					$userValue = '';
			$userValue = $record['fieldvalues_value'];   // $fieldValue->getFieldValue();
			if ((isset($userValue))&&($userValue != '')) 
			{
			
				// DETERMINE WHETHER PRICE RULE VALUE IS EQUIVALENT TO CURRENT FIELD VALUE
            if ( $userValue == '1')
            {
                // form criteria is met, apply the discount/penalty
//                 $basePriceForThisGuy -= 15;		// subtract $15 from $65 event base cost
					$basePriceForThisGuy = 50;		// frosh cost
					
					$rulesApplied[] = $priceRulesArray['45'];
					
					return $basePriceForThisGuy;
            }			
       	}  
       	
       	// if no frosh discount, THEN apply early bird discount (if conditions met)
// 		        echo "DATE RULE<BR>";
         // get the user's registration date    
         $registration = new RowManager_RegistrationManager();
         $registration->setRegID($regID);
         
         $regListManager = $registration->getListIterator(); 
         $regArray = $regListManager->getDataList();	
//        echo "<pre>".print_r($registration,true)."</pre>";	

			// set default date-time
			$regTime = '';	
			
			// retrieve registration date
			reset($regArray);
			$record = current($regArray);	// should be only 1 record for regID
			$regTime = $record['registration_date'];
		
// 					$regTime = $registration->getRegistrationDate();
			if ($regTime != '') 
			{										
				
            // if the registrant signed up before a deadline, apply the rule
            if ( strtotime($regTime) < strtotime( '2008-04-01' )  )		//$rule['pricerules_value']
            {
                // date criteria is met, apply the discount/penalty
//                 $basePriceForThisGuy -= 15;		// apply early bird discount to $65 event base cost to get $50
                
					 $basePriceForThisGuy = 50;
                $rulesApplied[] = $priceRulesArray['47'];
                
                return $basePriceForThisGuy;
            }	
      	}	      		    
		    
	    	return $basePriceForThisGuy;			// otherwise return unaltered base event cost ($125)
    	}		*/    
	    
	    
	    if ($eventID == $AIA_NATIONAL_TRAINING)
	    {
		    $FOOD_PASS_REQ_FIELD = 102;
		    $HOUSING_REQ_FIELD = 103;
		    
		    // first check for Food Pass Fee
            $fieldValue = new RowManager_FieldValueManager();
// 	            $fieldValue->loadByFieldIDandRegID($rule['fields_id'],$regID);
			$fieldValue->setFieldID($FOOD_PASS_REQ_FIELD);
			$fieldValue->setRegID($regID);
         
         $valueListManager = $fieldValue->getListIterator(); 
         $fieldValueList = $valueListManager->getDataList();	
// 		         echo "<pre>".print_r($fieldValueList,true)."</pre>";
			
         reset($fieldValueList);
         $record = current($fieldValueList);		         	

			// CHECK TO SEE IF SOME FIELD VALUE HAS BEEN SET FOR $FOOD_PASS_REQ_FIELD
// 					$userValue = '';
			$userValue = $record['fieldvalues_value'];   // $fieldValue->getFieldValue();
			if ((isset($userValue))&&($userValue != '')) 
			{
	         /** Get the user's registration date **/
	         $registration = new RowManager_RegistrationManager();
	         $registration->setRegID($regID);
	         
	         $regListManager = $registration->getListIterator(); 
	         $regArray = $regListManager->getDataList();	
	//        echo "<pre>".print_r($registration,true)."</pre>";					
				// set default date-time
				$regTime = '';	
				
				// retrieve registration date-time
				reset($regArray);
				$record = current($regArray);	// should be only 1 record for regID
				$regTime = $record['registration_date'];
				
	
				// DETERMINE WHETHER PRICE RULE VALUE IS EQUIVALENT TO CURRENT FIELD VALUE
            if ( $userValue == '1')
            {
                // form criteria is met, apply the discount/penalty
//                 $basePriceForThisGuy += 100;		// add 150 to base 260 event price
					$basePriceForThisGuy += 150;	
					
					$rulesApplied[] = $priceRulesArray['39'];
					
					// Apply early-bird discount on this if applicable
					if ($regTime != '') 
					{										
						
		            // if the registrant signed up before a deadline, apply the rule
		            if ( strtotime($regTime) < strtotime( '2008-04-16' )  )		//$rule['pricerules_value']
		            {
							 $basePriceForThisGuy -= 50;		// subtract 50 
		                $rulesApplied[] = $priceRulesArray['42'];	              	                
		            }	
		      	}		
					
            }			
       	}  
 

		    
		    // second check for Housing Fee
            $fieldValue = new RowManager_FieldValueManager();
// 	            $fieldValue->loadByFieldIDandRegID($rule['fields_id'],$regID);
			$fieldValue->setFieldID($HOUSING_REQ_FIELD);
			$fieldValue->setRegID($regID);
         
         $valueListManager = $fieldValue->getListIterator(); 
         $fieldValueList = $valueListManager->getDataList();	
// 		         echo "<pre>".print_r($fieldValueList,true)."</pre>";
			
         reset($fieldValueList);
         $record = current($fieldValueList);		       	
       	      	
			// CHECK TO SEE IF SOME FIELD VALUE HAS BEEN SET FOR $HOUSING_REQ_FIELD
// 					$userValue = '';
			$userValue = $record['fieldvalues_value'];   // $fieldValue->getFieldValue();
			if ((isset($userValue))&&($userValue != '')) 
			{
	         /** Get the user's registration date **/
	         $registration = new RowManager_RegistrationManager();
	         $registration->setRegID($regID);
	         
	         $regListManager = $registration->getListIterator(); 
	         $regArray = $regListManager->getDataList();	
	//        echo "<pre>".print_r($registration,true)."</pre>";					
				// set default date-time
				$regTime = '';	
				
				// retrieve registration date-time
				reset($regArray);
				$record = current($regArray);	// should be only 1 record for regID
				$regTime = $record['registration_date'];
				
	
				// DETERMINE WHETHER PRICE RULE VALUE IS EQUIVALENT TO CURRENT FIELD VALUE
            if ( $userValue == '1')
            {
                // form criteria is met, apply the discount/penalty

//                 $basePriceForThisGuy += 180;		// add 230 to base 260 event price
					$basePriceForThisGuy += 230;
					
					$rulesApplied[] = $priceRulesArray['41'];
					
					// Apply early-bird discount on this if applicable
					if ($regTime != '') 
					{										
						
		            // if the registrant signed up before a deadline, apply the rule
		            if ( strtotime($regTime) < strtotime( '2008-04-16' )  )		//$rule['pricerules_value']
		            {
							 $basePriceForThisGuy -= 50;		// subtract 50
		                $rulesApplied[] = $priceRulesArray['42'];	               	                
		            }	
		      	}		
					
					return $basePriceForThisGuy;
            }			
       	}  
      		    
		    
	    	return $basePriceForThisGuy;			// otherwise return unaltered base event cost ($125)
    	 }	    
	    
	    
	    
	    
	    if ($eventID == $EASTERN_WC_2007)
	    {
		    $COMMUTER_DISCOUNT_FIELD = 86;
		    
		    // first check for Frosh Discount
            $fieldValue = new RowManager_FieldValueManager();
// 	            $fieldValue->loadByFieldIDandRegID($rule['fields_id'],$regID);
			$fieldValue->setFieldID($COMMUTER_DISCOUNT_FIELD);
			$fieldValue->setRegID($regID);
         
         $valueListManager = $fieldValue->getListIterator(); 
         $fieldValueList = $valueListManager->getDataList();	
// 		         echo "<pre>".print_r($fieldValueList,true)."</pre>";
			
         reset($fieldValueList);
         $record = current($fieldValueList);		         	

			// CHECK TO SEE IF SOME FIELD VALUE HAS BEEN SET FOR GIVEN PARAMETERS
// 					$userValue = '';
			$userValue = $record['fieldvalues_value'];   // $fieldValue->getFieldValue();
			if ((isset($userValue))&&($userValue != '')) 
			{
			
				// DETERMINE WHETHER PRICE RULE VALUE IS EQUIVALENT TO CURRENT FIELD VALUE
            if ( $userValue == '1')
            {
                // form criteria is met, apply the discount/penalty
//                 $basePriceForThisGuy -= 80;		// subtract $80 from $279 event base cost
					$basePriceForThisGuy = 199;		// commuter cost
					
					$rulesApplied[] = $priceRulesArray['38'];
					
					return $basePriceForThisGuy;
            }			
       	}  
       	
       	// if no commuter discount, THEN apply early bird discount (if conditions met)
// 		        echo "DATE RULE<BR>";
         // get the user's registration date    
         $registration = new RowManager_RegistrationManager();
         $registration->setRegID($regID);
         
         $regListManager = $registration->getListIterator(); 
         $regArray = $regListManager->getDataList();	
//        echo "<pre>".print_r($registration,true)."</pre>";	

			// set default date-time
			$regTime = '';	
			
			// retrieve registration date
			reset($regArray);
			$record = current($regArray);	// should be only 1 record for regID
			$regTime = $record['registration_date'];
		
// 					$regTime = $registration->getRegistrationDate();
			if ($regTime != '') 
			{										
				
            // if the registrant signed up before a deadline, apply the rule
            if ( strtotime($regTime) < strtotime( '2007-12-01' )  )		//$rule['pricerules_value']
            {
	            if  ( strtotime($regTime) < strtotime( '2007-10-09' )  )
	            {
                // date criteria is met, apply the discount/penalty
//                 $basePriceForThisGuy -= 50;		// apply early bird discounts to $279 event base cost to get $229
                
						 $basePriceForThisGuy = 229;
	                $rulesApplied[] = $priceRulesArray['37'];
	                $rulesApplied[] = $priceRulesArray['36'];
	                
	                return $basePriceForThisGuy;
                }
                else
                {
                // date criteria is met, apply the discount/penalty
//                 $basePriceForThisGuy -= 50;		// apply regular discount to $279 event base cost to get $259
                
						 $basePriceForThisGuy = 259;
	                $rulesApplied[] = $priceRulesArray['36'];
	                
	                return $basePriceForThisGuy;
                }	                
            }	
      	}	      		    
		    
	    	return $basePriceForThisGuy;			// otherwise return unaltered base event cost ($125)
    	 }
    	 
    	 	    
	    
	    // PUT SPECIAL EVENT EXCEPTIONS HERE AS CONDITIONAL STATEMENTS:
	    if ($eventID == $BC_SUMMIT_2007)
	    {
		    $FROSH_DISCOUNT_FIELD = 54;
		    
		    // first check for Frosh Discount
            $fieldValue = new RowManager_FieldValueManager();
// 	            $fieldValue->loadByFieldIDandRegID($rule['fields_id'],$regID);
			$fieldValue->setFieldID($FROSH_DISCOUNT_FIELD);
			$fieldValue->setRegID($regID);
         
         $valueListManager = $fieldValue->getListIterator(); 
         $fieldValueList = $valueListManager->getDataList();	
// 		         echo "<pre>".print_r($fieldValueList,true)."</pre>";
			
         reset($fieldValueList);
         $record = current($fieldValueList);		         	

			// CHECK TO SEE IF SOME FIELD VALUE HAS BEEN SET FOR GIVEN PARAMETERS
// 					$userValue = '';
			$userValue = $record['fieldvalues_value'];   // $fieldValue->getFieldValue();
			if ((isset($userValue))&&($userValue != '')) 
			{
			
				// DETERMINE WHETHER PRICE RULE VALUE IS EQUIVALENT TO CURRENT FIELD VALUE
            if ( $userValue == '1')
            {
                // form criteria is met, apply the discount/penalty
//                 $basePriceForThisGuy -= 46;		// subtract $46 from $125 event base cost
					$basePriceForThisGuy = 79;		// frosh cost
					
					$rulesApplied[] = $priceRulesArray['14'];
					
					return $basePriceForThisGuy;
            }			
       	}  
       	
       	// if no frosh discount, THEN apply early bird discount (if conditions met)
// 		        echo "DATE RULE<BR>";
         // get the user's registration date    
         $registration = new RowManager_RegistrationManager();
         $registration->setRegID($regID);
         
         $regListManager = $registration->getListIterator(); 
         $regArray = $regListManager->getDataList();	
//        echo "<pre>".print_r($registration,true)."</pre>";	

			// set default date-time
			$regTime = '';	
			
			// retrieve registration date
			reset($regArray);
			$record = current($regArray);	// should be only 1 record for regID
			$regTime = $record['registration_date'];
		
// 					$regTime = $registration->getRegistrationDate();
			if ($regTime != '') 
			{										
				
            // if the registrant signed up before a deadline, apply the rule
            if ( strtotime($regTime) < strtotime( '2007-09-21' )  )		//$rule['pricerules_value']
            {
                // date criteria is met, apply the discount/penalty
//                 $basePriceForThisGuy -= 26;		// apply early bird discount to $125 event base cost to get $99
                
					 $basePriceForThisGuy = 99;
                $rulesApplied[] = $priceRulesArray['15'];
                
                return $basePriceForThisGuy;
            }	
      	}	      		    
		    
	    	return $basePriceForThisGuy;			// otherwise return unaltered base event cost ($125)
    	 }
    	 
    	 
	    if ($eventID == $MB_SUMMIT_2007)
	    {
		    $FROSH_DISCOUNT_FIELD = 60;
		    $FROSH_VOLUME_THRESHOLD = 20;
		    $MB_EARLY_FROSH_TABLE = 'temp_mb_early_frosh';
		    
		    // first check for Frosh Discount
            $fieldValue = new RowManager_FieldValueManager();
// 	            $fieldValue->loadByFieldIDandRegID($rule['fields_id'],$regID);
			$fieldValue->setFieldID($FROSH_DISCOUNT_FIELD);
			$fieldValue->setRegID($regID);
         
         $valueListManager = $fieldValue->getListIterator(); 
         $fieldValueList = $valueListManager->getDataList();	
// 		         echo "<pre>".print_r($fieldValueList,true)."</pre>";
			
         reset($fieldValueList);
         $record = current($fieldValueList);		         	

			// CHECK TO SEE IF SOME FIELD VALUE HAS BEEN SET FOR GIVEN PARAMETERS
// 					$userValue = '';
			$userValue = $record['fieldvalues_value'];   // $fieldValue->getFieldValue();
			if ((isset($userValue))&&($userValue != '')) 
			{

				// DETERMINE WHETHER PRICE RULE VALUE IS EQUIVALENT TO CURRENT FIELD VALUE
            if ( $userValue == '1')
            {

	            // check if there are 20 or more frosh already stored
	            $froshValues = new RowManager_FieldValueManager();
	            $froshValues->setFieldID($FROSH_DISCOUNT_FIELD);
	            $froshValues->setFieldValue('1');	// 1 = checked checkbox
	            
	            $fieldsManager = new MultiTableManager();
	            $fieldsManager->addRowManager($froshValues);
	            
	            // TODO: sub-query like 'SELECT <ALL FIELD VALUES FOR SPECIFIC FROSH DISCOUNT> WHERE REG_ID IN (SELECT ALL REGISTRATIONS FOR EVENT)'
		         $regs = new RowManager_RegistrationManager();
		         $regs->setEventID($eventID);
	            
	            $regData = new MultiTableManager();
		         $regData->addRowManager($regs);
		         $regData->setFieldList('registration_id');
		         $registered_SQL = $regData->createSQL();      
	            		      
					// actually creates the sub-query in order to get an accurate count of discount field values stored
					$negateSubQuery = false;
					$addSubQuery = true;
		         $fieldsManager->constructSubQuery( 'registration_id', $registered_SQL, $negateSubQuery, $addSubQuery );	
		         
// 		         $froshValues->setSortOrder('registration_id');
					$froshList = $fieldsManager->getListIterator(); 
					$froshArray = array();
		         $froshArray = $froshList->getDataList();
		         
// 		         echo "COUNT = ".count($froshArray);
		         if (count($froshArray) <= $FROSH_VOLUME_THRESHOLD)
		         {       	
          
	                // form criteria is met, apply the discount/penalty
	//                 $basePriceForThisGuy -= 25;		// subtract $46 from $125 event base cost
						$basePriceForThisGuy = 40;		// frosh cost
						
						$rulesApplied[] = $priceRulesArray['25'];
						
					   $db = new Database_MySQL();
				      $db->connectToDB( SITE_DB_NAME, SITE_DB_PATH, SITE_DB_USER, SITE_DB_PWORD);		
				      
				      // precaution that avoids duplicates
				      $sql = "DELETE FROM ".$MB_EARLY_FROSH_TABLE." WHERE registration_id = ".$regID;
				       $db->runSQL( $sql );      
				      
				       $sql = "INSERT INTO ".$MB_EARLY_FROSH_TABLE." (registration_id) VALUES (".$regID.")";
				       $db->runSQL( $sql );

			        }
			        else	// determine if the registration was given early frosh discount already
			        {				        
						   $db = new Database_MySQL();
					      $db->connectToDB( SITE_DB_NAME, SITE_DB_PATH, SITE_DB_USER, SITE_DB_PWORD);		      
					      
					      $sql = "SELECT * FROM ".$MB_EARLY_FROSH_TABLE." WHERE registration_id = ".$regID;
					      $db->runSQL( $sql );
					      $temp_regID = '';
					      if ( $row = $db->retrieveRow() )
					      {
					          $temp_regID = $row['registration_id'];
					      }				
					      
					      // apply rule despite there being >20 frosh because this registration existed before cut-off
					      if ($regID == $temp_regID)  
					      {
			//                 $basePriceForThisGuy -= 25;		// subtract $25 from $85 event base cost
								$basePriceForThisGuy = 40;		// frosh cost
								
								$rulesApplied[] = $priceRulesArray['25'];
							}
							else
							{
								$basePriceForThisGuy = 60;	// basic frosh cost
								
								$rulesApplied[] = $priceRulesArray['28'];
							}
						}						            				
						
						return $basePriceForThisGuy;
					}
            }			  
		    
	    	return $basePriceForThisGuy;			// otherwise return unaltered base event cost ($85)
    	 }    	
    	 
    	 
    	 
	    if ($eventID == $LAKESHORE_SUMMIT_2007)
	    {
		    $FROSH_DISCOUNT_FIELD = 64;
		    
		    // first check for Frosh Discount
            $fieldValue = new RowManager_FieldValueManager();
// 	            $fieldValue->loadByFieldIDandRegID($rule['fields_id'],$regID);
			$fieldValue->setFieldID($FROSH_DISCOUNT_FIELD);
			$fieldValue->setRegID($regID);
         
         $valueListManager = $fieldValue->getListIterator(); 
         $fieldValueList = $valueListManager->getDataList();	
// 		         echo "<pre>".print_r($fieldValueList,true)."</pre>";
			
         reset($fieldValueList);
         $record = current($fieldValueList);		         	

			// CHECK TO SEE IF SOME FIELD VALUE HAS BEEN SET FOR GIVEN PARAMETERS
// 					$userValue = '';
			$userValue = $record['fieldvalues_value'];   // $fieldValue->getFieldValue();
			if ((isset($userValue))&&($userValue != '')) 
			{
			
				// DETERMINE WHETHER PRICE RULE VALUE IS EQUIVALENT TO CURRENT FIELD VALUE
            if ( $userValue == '1')
            {
                // form criteria is met, apply the discount/penalty
//                 $basePriceForThisGuy -= <varies>;		// subtract <varying amount> from $120/$115/$110/$105 to get $75
					$basePriceForThisGuy = 75;		// frosh cost
					
					$rulesApplied[] = $priceRulesArray['19'];
					
					return $basePriceForThisGuy;
            }			
       	}  
       	
       	// if no frosh discount, THEN apply early bird discount (if conditions met)
// 		        echo "DATE RULE<BR>";
         // get the user's registration date    
         $registration = new RowManager_RegistrationManager();
         $registration->setRegID($regID);
         
         $regListManager = $registration->getListIterator(); 
         $regArray = $regListManager->getDataList();	
//        echo "<pre>".print_r($registration,true)."</pre>";	

			// set default date-time
			$regTime = '';	
			
			// retrieve registration date
			reset($regArray);
			$record = current($regArray);	// should be only 1 record for regID
			$regTime = $record['registration_date'];
		
// 					$regTime = $registration->getRegistrationDate();
			if ($regTime != '') 
			{										
				
            // if the registrant signed up before a deadline, apply the rule
            if ( strtotime($regTime) < strtotime( '2007-09-26' )  )		//$rule['pricerules_value']
            {
                // date criteria is met, apply the discount/penalty
//                 $basePriceForThisGuy -= 15;		// apply early bird discount to $115 event base cost to get $105
                
					 $basePriceForThisGuy = 105;
                $rulesApplied[] = $priceRulesArray['20'];
                
                return $basePriceForThisGuy;
            }	
      	}	      		    
		    
	    	return $basePriceForThisGuy;			// otherwise return unaltered base event cost ($120)
    	 }    	  
    	 
    	 
    	 /**** END OF RULE EXCEPTIONS ****/
    	 
    	 
    	 	        
	    // apply any price rules
	    foreach( $priceRulesArray as $key=>$rule )
	    {
	        $ruleType = $rule['priceruletypes_id'];
	        
	         // form attribute rule: apply price rule based on whether some form field value exists (i.e. frosh discount)
	        if ( $ruleType == RowManager_PriceRuleTypeManager::FORM_ATTRIBUTE_RULE )
	        {
// 	            echo "FORM RULE<BR>";
	            // get the user's input for this form attribute        
	            $fieldValue = new RowManager_FieldValueManager();
// 	            $fieldValue->loadByFieldIDandRegID($rule['fields_id'],$regID);
					$fieldValue->setFieldID($rule['fields_id']);
					$fieldValue->setRegID($regID);
	            
		         $valueListManager = $fieldValue->getListIterator(); 
		         $fieldValueList = $valueListManager->getDataList();	
// 		         echo "<pre>".print_r($fieldValueList,true)."</pre>";
					
		         reset($fieldValueList);
		         $record = current($fieldValueList);		         	
		
					// CHECK TO SEE IF SOME FIELD VALUE HAS BEEN SET FOR GIVEN PARAMETERS
// 					$userValue = '';
					$userValue = $record['fieldvalues_value'];   // $fieldValue->getFieldValue();
					if ((isset($userValue))&&($userValue != '')) 
					{
					
						// DETERMINE WHETHER PRICE RULE VALUE IS EQUIVALENT TO CURRENT FIELD VALUE
		            if ( $rule['pricerules_value'] == $userValue )
		            {
		                // form criteria is met, apply the discount/penalty
		                $basePriceForThisGuy += $rule['pricerules_discount'];
		                
		                $rulesApplied[] = $rule;
		            }			
	          	}            

	        }
	        else if ( $ruleType == RowManager_PriceRuleTypeManager::DATE_RULE )		// date rule: pricing applied based on date (i.e. early-bird discount)
	        {
// 		        echo "DATE RULE<BR>";
	            // get the user's registration date    
	            $registration = new RowManager_RegistrationManager();
	            $registration->setRegID($regID);
	            
		         $regListManager = $registration->getListIterator(); 
		         $regArray = $regListManager->getDataList();	
		//        echo "<pre>".print_r($registration,true)."</pre>";	
		
					// set default date-time
					$regTime = '';	
					
					// retrieve registration date
					reset($regArray);
					$record = current($regArray);	// should be only 1 record for regID
					$regTime = $record['registration_date'];
				
// 					$regTime = $registration->getRegistrationDate();
					if ($regTime != '') 
					{										
						
		            // if the registrant signed up before a deadline, apply the rule
		            if ( strtotime($regTime) < strtotime($rule['pricerules_value'] )  )
		            {
		                // date criteria is met, apply the discount/penalty
		                $basePriceForThisGuy += $rule['pricerules_discount'];
		                
		                $rulesApplied[] = $rule;
		            }	
	         	}			

	        }
	        else if ( $ruleType == RowManager_PriceRuleTypeManager::VOLUME_RULE )		// volume rule: apply pricing rule based on total event registrations for campus
	        {
		        $volumeNeeded = $rule['pricerules_value'];
		        
// 		        $correctCampus = false;
// 		        $pattern = RowManager_PriceRuleTypeManager::CAMPUS_VOLUME_REGEX;
// 		        $numMatches = preg_match($pattern, $rule['pricerules_value']);

// 		        if ($numMatches > 0)
// 		        {
// 			        
// 						$pricingValues = explode('|',$rule['pricerules_value']);
// 	//					echo '<pre>'.print_r($pricingValues,true).'</pre>';
// 	//					echo 'campus = '.$pricingValues[0].'  cut-off = '.$pricingValues[1];
// 						if ((int)$pricingValues[0] == $campusID) 
// 						{
// 							$correctCampus = true;
// 							$volumeNeeded = $pricingValues[1];
// 	
// 	/*						if ($numRegistrantsMyCampus != '') 
// 							{				
// 				            // if the # of registrants >= the bulk discount value...
// 				            if ( $numRegistrantsMyCampus >= $pricingValues[1] )
// 				            {
// 				                // bulk discount criteria is met, apply the discount/penalty
// 				                $basePriceForThisGuy += $rule['pricerules_discount'];
// 				                
// 				                $rulesApplied[] = $rule;
// 				            }	
// 			         	}
// 			         	else 	// try to calculate the # of registrants on our own
// 			         	{
// 	*/		
// 					 	
// 	/**						}
// 	**/						
// 						}	 
// 					}
// 					
// 					// check volume rule if no specific campus associated or current campus is associated with rule
// 					if (($numMatches == 0)||($correctCampus == true))
// 					{
						
				if (isset($campusID)&&($campusID != ''))
				{
						// get total registrations for specific campus and particular event
			         $total = array();
			         $summary = new RegSummaryTools();					
						$total = $summary->getCampusRegistrations( $eventID, '' , false, $campusID, '', RowManager_RegistrationManager::STATUS_REGISTERED); 
						
						if (isset($total[$campusID]))
						{
							$numRegistrantsMyCampus = $total[$campusID];
						}
						else
						{
							$numRegistrantsMyCampus = 0;
						}
						
						if (count($total) > 0) 
						{
			            // if the # of registrants >= the bulk discount value...
			            if ( $numRegistrantsMyCampus >= $volumeNeeded)		//$rule['pricerules_value']   )
			            {

			                // bulk discount criteria is met, apply the discount/penalty
			                $basePriceForThisGuy += $rule['pricerules_discount'];
			                
			                $rulesApplied[] = $rule;
			            }	
		           	}	
	           	}   
	           	else 
	           	{
		           // should not occur, this function meant to be used with campusID set
	           }

	        }
	        else if ( $ruleType == RowManager_PriceRuleTypeManager::CAMPUS_RULE )	// campus rule: apply this discount to any registration linked to particular campus
	        {
// 		        echo "CAMPUS RULE<BR>";
	            // check the campus ID against the one stored in the price rules table	            
	            if ($campusID == $rule['pricerules_value'])
	            {
	                $basePriceForThisGuy += $rule['pricerules_discount'];
	                
	                $rulesApplied[] = $rule;	  
               }                

          	}
           else		        
	        {
	            die('unknown ruletype['.$ruleType.']');
	        }
	        
	    } // foreach rule
	    
	    // special hack for Eastern Ontario/Montreal summit 2006
/*	    if ( $eventID == 4 )
	    {
	        $basePriceForThisGuy = getBasePriceEasternSummit2006( $regID, $numRegistrantsMyCampus, $rulesApplied );
	    }
	    else if ( $eventID == 11 )
	    {
	        $basePriceForThisGuy = getBasePricePrairieSummit2006( $regID, $campusID, $numRegistrantsMyCampus, $rulesApplied );
	    }
*/	    
	    return $basePriceForThisGuy;
	
	}

	
	/**
	 * function getCashTransactions
	 * <pre>
	 * Returns array of arrays, indexed by cash transaction ID
	 * </pre>
	 * @param $regID [INTEGER]		registration ID
	 * @return [ARRAY] the array of cash transaction records for registration $regID
	 */	
	function getCashTransactions($regID)
	{
		$cashTransactions = new RowManager_CashTransactionManager();
		$cashTransactions->setRegID($regID);
		
	   $cashTransIterator = $cashTransactions->getListIterator(); 
      $cashTransArray = $cashTransIterator->getDataList();	

        //echo "<pre>".print_r($cashTransArray,true)."</pre>";
        
        return $cashTransArray;
  	}

  	/**
	 * function getCCTransactions
	 * <pre>
	 * Returns array of arrays, indexed by credit card transaction ID
	 * </pre>
	 * @param $regID [INTEGER]		registration ID
	 * @return [ARRAY] the array of credit card  transaction records for registration $regID
	 */  	
  	function getCCTransactions($regID)
	{
		$ccTransactions = new RowManager_CreditCardTransactionManager();
		$ccTransactions->setRegID($regID);
		
	   $ccTransIterator = $ccTransactions->getListIterator(); 
      $ccTransArray = $ccTransIterator->getDataList();	

        //echo "<pre>".print_r($ccTransArray,true)."</pre>";
        
      return $ccTransArray;
  	}
  	
  	/**
	 * function getScholarships
	 * <pre>
	 * Returns array of arrays, indexed by scholarship ID
	 * </pre>
	 * @param $regID [INTEGER]		registration ID
	 * @return [ARRAY] the array of scholarship records for registration $regID
	 */   	
  	function getScholarships($regID)
  	{
	  	$scholarships = new RowManager_ScholarshipAssignmentManager();
	  	$scholarships->setRegID($regID);
     
	   $scholarshipsIterator = $scholarships->getListIterator(); 
      $scholarshipsArray = $scholarshipsIterator->getDataList();	

     //   echo "<pre>".print_r($scholarshipsArray,true)."</pre>";
        
      return $scholarshipsArray;
   }   
	
/**	
	function processData( )
	{
	    global $pageID;
	    global $eventID;
	    global $regID;
	    global $form;
	    global $formTwo;
	    global $tempForm;
	
	    $db = new Database_MySQL();
	    $db->connectToDB( DB_NAME, DB_PATH, DB_USER, DB_PWD);
	
	    if ( formSubmitted() )
	    {
	        if ( $form->isDataValid() )
	        {            
	            switch ( $pageID )
	            {
	                case PAGE_ADD_CASHTRANS:
	
	                    $paymentRecd = 0;                
	                    if ( isset($_REQUEST['cashtransaction_recd']) )
	                    {
	                        $paymentRecd = $_REQUEST['cashtransaction_recd'] ;
	                    }
	                    
	                    // paying staff cash
	                    // die('pay cash selected');
	                    $sql = 'INSERT INTO cim_reg_cashtransaction set 
	                        reg_id='.$regID.', 
	                        cashtransaction_staffName="'.mysql_real_escape_string($_REQUEST['cashtransaction_staffName']).'",
	                        cashtransaction_recd="'.mysql_real_escape_string($paymentRecd).'",
	                        cashtransaction_amtPaid="'.mysql_real_escape_string($_REQUEST['cashtransaction_amtPaid']).'"';
	                    
	                    // echo $sql.'<br/>';
	                    $db->runSQL( $sql );
	                    
	                    $pageID = PAGE_REG_PERSON_DETAILS;
	                    
	                    break;
	                    
	                case PAGE_ADD_CCTRANS:
	                
	                    $string = mysql_real_escape_string($_REQUEST['cctransaction_cardNum']);
	                
	                    // Encryption/decryption key
	                    $key = "bafmamhwwstlj24.15";
	                    
	                    // Encryption Algorithm
	                    $cipher_alg = MCRYPT_RIJNDAEL_128;
	                    
	                    // Create the initialization vector for added security.
	                    $size = mcrypt_get_iv_size($cipher_alg, MCRYPT_MODE_ECB);
	                    srand();	// initialize random number generator
	                    $iv = mcrypt_create_iv($size, MCRYPT_RAND);
	                    
	                    // Output original string
	                    // print "Original string: $string <p>";
	                    
	                    // Encrypt $string
	                    $encrypted_string = mcrypt_encrypt($cipher_alg, $key, 
	                    $string, MCRYPT_MODE_ECB, $iv);
	                    
	                    // Convert to hexadecimal and output to browser
	                    $encrypted_string = bin2hex($encrypted_string);
	                    // print "Encrypted string: ".$hex."<p>";
	                    // echo "[".$encrypted_string."]<br/>";
	                
	                    // credit card transaction
	                    $sql = 'INSERT INTO cim_reg_cctransaction set 
	                        reg_id='.$regID.', 
	                        cctransaction_cardName="'.mysql_real_escape_string($_REQUEST['cctransaction_cardName']).'", 
	                        cctype_id='.$_REQUEST['cctype_id'].', 
	                        cctransaction_cardNum="'.$encrypted_string.'", 
	                        cctransaction_expiry="'.mysql_real_escape_string($_REQUEST['cctransaction_expiry']).'", 
	                        cctransaction_amount="'.mysql_real_escape_string($_REQUEST['cctransaction_amount']).'",
	                        cctransaction_billingPC="'.mysql_real_escape_string($_REQUEST['cctransaction_billingPC']).'"';
	                    $db->runSQL( $sql );
	                    // echo $sql.'<br/>';
	                
	                    $pageID = PAGE_REG_PERSON_DETAILS;
	                
	                    break;
	
	                case PAGE_SIGNUP_PRICING_EVENT_INFO:
	                 
	                    // get the event name
	                    $sql = "SELECT * FROM ".DB_TABLE_EVENT." where ".DB_TABLE_EVENT_FIELD_ID."=". $eventID;
	                    $db->runSQL( $sql );
	                    $depositReq = -1;
	                    if ( $row = $db->retrieveRow() )
	                    {
	                        $depositReq = $row['event_deposit'];
	                    }
	                    else
	                    {
	                        die('ERROR - Invalid event_id['.$eventID.']');
	                    }
	                               
	                    if ( $_REQUEST['paymentOption'] == 1 )
	                    {
	                        $string = mysql_real_escape_string($_REQUEST['cctransaction_cardNum']);
	                
	                        // Encryption/decryption key
	                        $key = "bafmamhwwstlj24.15";
	                        
	                        // Encryption Algorithm
	                        $cipher_alg = MCRYPT_RIJNDAEL_128;
	                        
	                        // Create the initialization vector for added security.
	                        $iv = mcrypt_create_iv(mcrypt_get_iv_size($cipher_alg, 
	                        MCRYPT_MODE_ECB), MCRYPT_RAND);
	                        
	                        // Output original string
	                        // print "Original string: $string <p>";
	                        
	                        // Encrypt $string
	                        $encrypted_string = mcrypt_encrypt($cipher_alg, $key, 
	                        $string, MCRYPT_MODE_ECB, $iv);
	                        
	                        // Convert to hexadecimal and output to browser
	                        $encrypted_string = bin2hex($encrypted_string);
	                        // print "Encrypted string: ".$hex."<p>";
	                        // echo "[".$encrypted_string."]<br/>";
	                    	                    
	                        // die('credit card selected');
	                        // credit card transaction
	                        $sql = 'INSERT INTO cim_reg_cctransaction set 
	                            reg_id='.$regID.', 
	                            cctransaction_cardName="'.mysql_real_escape_string($_REQUEST['cctransaction_cardName']).'", 
	                            cctype_id='.$_REQUEST['cctype_id'].', 
	                            //cctransaction_cardNum="'.mysql_real_escape_string($_REQUEST['cctransaction_cardNum']).'", 
	                            cctransaction_cardNum="'.$encrypted_string.'", 
	                            cctransaction_expiry="'.mysql_real_escape_string($_REQUEST['cctransaction_expiry']).'", 
	                            cctransaction_amount="'.$depositReq.'",
	                            cctransaction_billingPC="'.mysql_real_escape_string($_REQUEST['cctransaction_billingPC']).'"';
	                        $db->runSQL( $sql );
	                    }
	                    else if ( $_REQUEST['paymentOption'] == 2 )
	                    {
	                        // paying staff cash
	                        // switch back note: $formTwo is fine
	                        $form = $tempForm;
	                        // die('pay cash selected');
	                        $sql = 'INSERT INTO cim_reg_cashtransaction set 
	                            reg_id='.$regID.', 
	                            cashtransaction_staffName="'.mysql_real_escape_string($_REQUEST['cashtransaction_staffName']).'"';
	                        $db->runSQL( $sql );
	                    }
	                    else
	                    {
	                        die('ERROR - unknown payment option');
	                    }
	                    
	                    // set the pageID different for the page we want to transition to;
	                    $pageID = PAGE_SIGNUP_CONFIRMATION;
	                    
	                    break;
	                default:
	                    break;
	            
	            } // switch
	        } // isDataValid
	        else
	        {
	            // may need to switch form items back, when data isn't valid
	            if ( $pageID == PAGE_SIGNUP_PRICING_EVENT_INFO )
	            {
	                if ( $_REQUEST['paymentOption'] == 2 )
	                {
	                    // paying staff cash
	                    // switch back note: $formTwo is fine
	                    $form = $tempForm;
	                }
	            }
	            // echo 'Data was not valid<br/>';
	        }
	    } // formSubmitted
	        
	    return;
	}
	
	
	function displayData( )
	{
	    global $pageID;
	    global $eventID;
	    global $regID;
	    global $langID;
	    global $form;
	    global $formTwo;
	    global $pageFunc;
	    global $pageContent;
	    global $templateName;
	    global $realTemplateName;
	    
	    $db = new Database_MySQL();
	    $db->connectToDB( DB_NAME, DB_PATH, DB_USER, DB_PWD);
	    
	    switch( $pageID )
	    {
		    
	        case PAGE_ADD_CASHTRANS:
	            
	            // get the event name
	            $sql = "SELECT * FROM ".DB_TABLE_EVENT." where ".DB_TABLE_EVENT_FIELD_ID."=". $eventID;
	            $db->runSQL( $sql );
	            $eventName = 'error';
	            if ( $row = $db->retrieveRow() )
	            {
	                $eventName = $row[DB_TABLE_EVENT_FIELD_NAME];
	            }
	            else
	            {
	                die('ERROR - Invalid event_id['.$eventID.']');
	            }
	            $pageContent->set('eventName', $eventName );
	            
	            // get the campus list
	            $campusArray = array();
	            $sql = "SELECT * FROM cim_hrdb_campus ORDER BY campus_desc";
	            $db->runSQL( $sql );
	            while ( $row = $db->retrieveRow() )
	            {
	                $campusArray[ $row['campus_id'] ] = $row[ 'campus_desc' ];
	            }
	            
	            // get the registrant's info for display
	            $sql = "select * from cim_hrdb_person inner join cim_reg_registration on cim_hrdb_person.person_id=cim_reg_registration.person_id inner join cim_hrdb_campus on cim_hrdb_person.campus_id=cim_hrdb_campus.campus_id where registration_id=".$regID;
	            $db->runSQL( $sql );
	            $person = '';
	            $campusID = -1;
	            if ( $row = $db->retrieveRow()  )
	            {
	                $person = $row;
	                $campusID = $row['campus_id'];
	            }
	            else
	            {
	                die('ERROR - looking up regID['.$regID.']');
	            }
	            $pageContent->set('specialInfo', 'Registrant: '.$person['person_fname'].' '.$person['person_lname'].'<br/>Campus: '.$campusArray[$campusID].'<br/>');
	            
	            $pageContent->set('form', $form);
	        
	            $realTemplateName = TEMPLATE_ADD_CASHTRANS;
	            $templateName = TEMPLATE_GENERIC_FORM;
	            break;
	            
	        case PAGE_ADD_CCTRANS:
	        
	            // get the event name
	            $sql = "SELECT * FROM ".DB_TABLE_EVENT." where ".DB_TABLE_EVENT_FIELD_ID."=". $eventID;
	            $db->runSQL( $sql );
	            $eventName = 'error';
	            if ( $row = $db->retrieveRow() )
	            {
	                $eventName = $row[DB_TABLE_EVENT_FIELD_NAME];
	            }
	            else
	            {
	                die('ERROR - Invalid event_id['.$eventID.']');
	            }
	            $pageContent->set('eventName', $eventName );
	            
	            // get the campus list
	            $campusArray = array();
	            $sql = "SELECT * FROM cim_hrdb_campus ORDER BY campus_desc";
	            $db->runSQL( $sql );
	            while ( $row = $db->retrieveRow() )
	            {
	                $campusArray[ $row['campus_id'] ] = $row[ 'campus_desc' ];
	            }
	            
	            // get the registrant's info for display
	            $sql = "select * from cim_hrdb_person inner join cim_reg_registration on cim_hrdb_person.person_id=cim_reg_registration.person_id inner join cim_hrdb_campus on cim_hrdb_person.campus_id=cim_hrdb_campus.campus_id where registration_id=".$regID;
	            $db->runSQL( $sql );
	            $person = '';
	            $campusID = -1;
	            if ( $row = $db->retrieveRow()  )
	            {
	                $person = $row;
	                $campusID = $row['campus_id'];
	            }
	            else
	            {
	                die('ERROR - looking up regID['.$regID.']');
	            }
	            $pageContent->set('specialInfo', 'Registrant: '.$person['person_fname'].' '.$person['person_lname'].'<br/>Campus: '.$campusArray[$campusID].'<br/>');
	            
	            $pageContent->set('list_cctype_id', array( 1=>'Visa', 2=>'Mastercard' ) );
	            $pageContent->set('form', $form);
	        
	            $realTemplateName = TEMPLATE_ADD_CCTRANS;
	            $templateName = TEMPLATE_GENERIC_FORM;
	            
	            break;
	                        
	        case PAGE_SIGNUP_PRICING_EVENT_INFO:
	            
	            // TODO - get rid of all hard-coded values in this section
	        
	            $db = new Database_MySQL();
	            $db->connectToDB( DB_NAME, DB_PATH, DB_USER, DB_PWD);
	            
	            // get the event name
	            $sql = "SELECT * FROM ".DB_TABLE_EVENT." where ".DB_TABLE_EVENT_FIELD_ID."=". $eventID;
	            $db->runSQL( $sql );
	            $eventName = 'error';
	            $depositReq = -1;
	            if ( $row = $db->retrieveRow() )
	            {
	                $eventName = $row[DB_TABLE_EVENT_FIELD_NAME];
	                $depositReq = $row['event_deposit'];
	            }
	            else
	            {
	                die('ERROR - Invalid event_id['.$eventID.']');
	            }
	            $pageContent->set('eventName', $eventName );
	            $pageContent->set('eventID', $eventID );
	            
	            $pageContent->set('depositReq', $depositReq );
	            
	            // make the first form (for option 1)
	            $formOne = new Template( TEMPLATES_DIR );
	            $formOne->set('disableHeading', true);
	            $formOne->set('disableFormTag', true);
	            $formOne->set('list_cctype_id', array( 1=>'Visa', 2=>'Mastercard' ) );
	            $formOne->set('form', $form);
	            $labels = new MultiLingual_Labels( GPC_SITE_LABEL, GPC_SERIES_LABEL, TEMPLATE_SIGNUP_PRICING_EVENT_INFO, $langID );
	            $formOne->set('labels', $labels );    
	            $formOneContent = $formOne->fetch( TEMPLATE_GENERIC_FORM );
	            $pageContent->set('formOneContent', $formOneContent );
	            
	            // make the second form (for option 2)
	            $formDeux = new Template( TEMPLATES_DIR );
	            $formDeux->set('disableHeading', true);
	            $formDeux->set('disableFormTag', true);
	            $formDeux->set('form', $formTwo);
	            $formDeux->set('labels', $labels );    
	            $formTwoContent = $formDeux->fetch( TEMPLATE_GENERIC_FORM );
	            $pageContent->set('formTwoContent', $formTwoContent );
	            
	            // set the form action
	            $pageContent->set('formAction', $form->formAction );
	            
	            $specialInfoLabels = new MultiLingual_Labels( GPC_SITE_LABEL, GPC_SERIES_LABEL, TEMPLATE_SIGNUP_PRICING_EVENT_INFO, $langID );
	            $pageContent->set('specialInfo', $specialInfoLabels->Label('[SpecialInfo]') );
	            
	            $templateName = TEMPLATE_SIGNUP_PRICING_EVENT_INFO;
	            
	            break;
	        default:
	            break;
	    }
	    return;
	}
	            
	            
	            	                        	            
	function getBasePriceEasternSummit2006( $regID, $numRegistrantsMyCampus=0, &$rulesApplied )
	{
	    // if frosh/new christian $75
	        // if 20+ -5
	        // if 50+ -5
	    // else
	        // if ontime $105
	            // if 20+ -10
	            // if 50+ -10
	        // else $120 (late)
	            // if 20+ -5
	            // if 50+ -5
	    
	    $basePrice = 105;
	    
	    $db = new Database_MySQL();
	    $db->connectToDB( DB_NAME, DB_PATH, DB_USER, DB_PWD);
	    
	    // is this guy a frosh?
	    $sql = "SELECT * FROM cim_reg_fieldvalues WHERE fields_id=11 AND registration_id=".$regID;
	    $db->runSQL( $sql );
	    $isFrosh = 0;
	    if ( $row = $db->retrieveRow() )
	    {
	        $isFrosh = $row['fieldvalues_value'];
	    }
	    
	    // is this guy a new christian?
	    $sql = "SELECT * FROM cim_reg_fieldvalues WHERE fields_id=20 AND registration_id=".$regID;
	    $db->runSQL( $sql );
	    $isNewCool = 0;
	    if ( $row = $db->retrieveRow() )
	    {
	        $isNewCool = $row['fieldvalues_value'];
	    }    
	    
	    
	    // if frosh/new christian $75
	    if ( $isFrosh || $isNewCool )    
	    {
	        $basePrice = 75;
	        $rulesApplied[] = array( 'pricerules_desc'=>'Frosh/New Christian BASE $75', 'pricerules_discount'=>75 ) ;     
	        
	        // if 20+ -5
	        if ( $numRegistrantsMyCampus > 20 )
	        {
	            $rulesApplied[] = array( 'pricerules_desc'=>'Volume 20+', 'pricerules_discount'=>-5 ) ;
	            // $rulesApplied .= 'Volume 20+ -5 | ';
	            $basePrice -= 5;
	        }
	        
	        // if 50+ -5
	        if ( $numRegistrantsMyCampus > 50 )
	        {
	            $rulesApplied[] = array( 'pricerules_desc'=>'Volume 50+', 'pricerules_discount'=>-5 ) ;
	            // $rulesApplied .= 'Volume 50+ -5 | ';
	            $basePrice -= 5;
	        }    
	    }
	    // else
	    else
	    {
	        $sql = "SELECT * FROM cim_reg_registration WHERE registration_id=".$regID;
	        $db->runSQL( $sql );
	        $regDate = 1;
	        if ( $row = $db->retrieveRow() )
	        {
	            $regDate = $row['registration_date'];
	        }
	        
	        // if ontime $105 (default) => on or before sept 25th (thus, make it first thing on the 26th)
	        if ( strtotime( $regDate ) <= mktime( 0,0,0,9,26,2006 )  )
	        {
	            // if 20+ -10
	            if ( $numRegistrantsMyCampus > 20 )
	            {
	                $rulesApplied[] = array( 'pricerules_desc'=>'Volume 20+', 'pricerules_discount'=>-10 ) ;
	                // $rulesApplied .= 'Volume 20+ -10 | ';
	                $basePrice -= 10;
	            }
	            
	            // if 50+ -10
	            if ( $numRegistrantsMyCampus > 50 )
	            {
	                $rulesApplied[] = array( 'pricerules_desc'=>'Volume 50+', 'pricerules_discount'=>-10 ) ;
	                // $rulesApplied .= 'Volume 50+ -10 | ';
	                $basePrice -= 10;
	            } 
	            
	        }
	        // else $120 (late)
	        else
	        {
	            $rulesApplied[] = array( 'pricerules_desc'=>'Late BASE 120', 'pricerules_discount'=>120 ) ;
	            // $rulesApplied .= 'Late $120 | ';
	            $basePrice = 120;
	            // if 20+ -5
	            if ( $numRegistrantsMyCampus > 20 )
	            {
	                $rulesApplied[] = array( 'pricerules_desc'=>'Volume 20+', 'pricerules_discount'=>-5 ) ;
	                // $rulesApplied .= 'Volume 20+ -5 | ';
	                $basePrice -= 5;
	            }
	            
	            // if 50+ -5
	            if ( $numRegistrantsMyCampus > 50 )
	            {
	                $rulesApplied[] = array( 'pricerules_desc'=>'Volume 50+', 'pricerules_discount'=>-5 ) ;
	                // $rulesApplied .= 'Volume 50+ -5 | ';
	                $basePrice -= 5;
	            }
	        }     
	    }
	            
	    return $basePrice;
	}
	
	function getBasePricePrairieSummit2006( $regID, $campusID, $numRegistrantsMyCampus=0, &$rulesApplied )
	{
	    $db = new Database_MySQL();
	    $db->connectToDB( DB_NAME, DB_PATH, DB_USER, DB_PWD);
	    
	    $basePrice = 75;
	    
	    // if U of S
	        // if frosh $30
	        // else $50
	    
	    // else if U of M
	        // if frosh $50
	        // if 20+ -10
	        // if 30+ -5
	        // if 40+ -5
	    
	    // is this guy a frosh?
	    $sql = "SELECT * FROM cim_reg_fieldvalues WHERE fields_id=14 AND registration_id=".$regID;
	    $db->runSQL( $sql );
	    $isFrosh = 0;
	    if ( $row = $db->retrieveRow() )
	    {
	        $isFrosh = $row['fieldvalues_value'];
	    }
	    
	    // if U of S
	    if ( $campusID == 68 )
	    {
	        // if frosh $30
	        if ( $isFrosh )
	        {
	            $rulesApplied[] = array( 'pricerules_desc'=>'U of S Frosh $30', 'pricerules_discount'=>30 ) ;
	            // $rulesApplied .= "U of S Frosh $30 | ";
	            $basePrice = 30;
	        }
	        // else $50
	        else
	        {
	            $rulesApplied[] = array( 'pricerules_desc'=>'U of S Regular', 'pricerules_discount'=>50 ) ;
	            // $rulesApplied .= "U of S Regular $50 | ";
	            $basePrice = 50;
	        }
	    }
	    // else if U of M
	    else if ( $campusID == 24 )
	    {
	        // if frosh $50
	        if ( $isFrosh )
	        {
	            $rulesApplied[] = array( 'pricerules_desc'=>'U of M Frosh $50', 'pricerules_discount'=>50 ) ;
	            // $rulesApplied .= "U of M Frosh $50 | ";
	            $basePrice = 50;
	        }
	        
	        // if 20+ -10
	        if ( $numRegistrantsMyCampus > 20 )
	        {
	            $rulesApplied[] = array( 'pricerules_desc'=>'U of M Volume 20+', 'pricerules_discount'=>-10 ) ;
	            // $rulesApplied .= "U of M Volume 20+ -10 | ";
	            $basePrice -= 10;
	        }
	        // if 30+ -5
	        if ( $numRegistrantsMyCampus > 30 )
	        {
	            $rulesApplied[] = array( 'pricerules_desc'=>'U of M Volume 30+', 'pricerules_discount'=>-5 ) ;
	            // $rulesApplied .= "U of M Volume 30+ -5 | ";
	            $basePrice -= 5;
	        }
	        // if 40+ -5   
	        if ( $numRegistrantsMyCampus > 40 )
	        {
	            $rulesApplied[] = array( 'pricerules_desc'=>'U of M Volume 40+', 'pricerules_discount'=>-5 ) ;
	            // $rulesApplied .= "U of M Volume 40+ -5 | ";
	            $basePrice -= 5;
	        }
	    }
	    
	    
	    return $basePrice;
	}
	
	function getAllCC()
	{
	    $db = new Database_MySQL();
	    $db->connectToDB( DB_NAME, DB_PATH, DB_USER, DB_PWD);
	    
	    // get the cctype list
	    $ccTypeArray = array();
	    $sql = "SELECT * FROM cim_reg_cctype";
	    $db->runSQL( $sql );
	    while ( $row = $db->retrieveRow() )
	    {
	        $ccTypeArray[ $row['cctype_id'] ] = $row[ 'cctype_desc' ];
	    }
	    
	    // get the event list
	    $eventArray = array();
	    $depositArray = array();
	    $sql = "SELECT * FROM cim_reg_event";
	    $db->runSQL( $sql );
	    while ( $row = $db->retrieveRow() )
	    {
	        $eventArray[ $row['event_id'] ] = $row[ 'event_name' ];
	        $depositArray[ $row['event_id'] ] = $row[ 'event_deposit' ];
	    }
	    
	    // get the campus list
	    $campusArray = array();
	    $sql = "SELECT * FROM cim_hrdb_campus ORDER BY campus_desc";
	    $db->runSQL( $sql );
	    while ( $row = $db->retrieveRow() )
	    {
	        $campusArray[ $row['campus_id'] ] = $row[ 'campus_desc' ];
	    }
	
	    // define the fields
	    $csvText = "reg_id,person_id,person_fname,person_lname,campus_id,event_id,cctransaction_id,cctransaction_cardName,cctype_id,cctransaction_cardNum,cctransaction_expiry,cctransaction_billingPC,cctransaction_amount,event_deposit";
	    $csvText .= "\n";
	    
	        // Encryption/decryption key
	    $key = "bafmamhwwstlj24.15";
	
	    // Encryption Algorithm
	    $cipher_alg = MCRYPT_RIJNDAEL_128;
	    
	    // Create the initialization vector for added security.
	    $iv = mcrypt_create_iv(mcrypt_get_iv_size($cipher_alg, MCRYPT_MODE_ECB), MCRYPT_RAND);
	    
	    
	    $sql = "SELECT * FROM cim_hrdb_person INNER JOIN cim_reg_registration ON cim_hrdb_person.person_id=cim_reg_registration.person_id INNER JOIN cim_reg_cctransaction ON cim_reg_registration.registration_id=cim_reg_cctransaction.reg_id WHERE cctransaction_processed=0";	
	    $db->runSQL($sql);
	    while ( $row = $db->retrieveRow() )
	    {
	        $csvText .= '"'.$row['registration_id'].'",';
	        $csvText .= '"'.$row['person_id'].'",';
	        $csvText .= '"'.$row['person_fname'].'",';
	        $csvText .= '"'.$row['person_lname'].'",';
	        $csvText .= '"'.$campusArray[ $row['campus_id'] ].'",';
	        $csvText .= '"'.$eventArray[ $row['event_id'] ].'",';
	        $csvText .= '"'.$row['cctransaction_id'] .'",';
	        $csvText .= '"'.$row['cctransaction_cardName'] .'",';
	        $csvText .= '"'.$ccTypeArray[ $row['cctype_id'] ].'",';
	        //$csvText .= '"NUM '.$row['cctransaction_cardNum'] .'",';
	                
	        $ccNum = $row['cctransaction_cardNum'];
	        // print "encrypted string from db: $ccNum <p>";
	        $encrypted_db_string = pack( 'H'.strlen($ccNum) , $ccNum );
	        // print "encrypted string in binary: $encrypted_db_string <p>";
	
	        $decrypted_db_string = mcrypt_decrypt($cipher_alg, $key, 
	        $encrypted_db_string, MCRYPT_MODE_ECB, $iv);
	        // print "Decrypted db string: $decrypted_db_string <p>";
	        
	        $csvText .= '"NUM '.trim($decrypted_db_string) .'",';
	        $csvText .= '"MM/YY '.$row['cctransaction_expiry'] .'",';
	        $csvText .= '"'.$row['cctransaction_billingPC'] .'",';
	        $csvText .= '"'.$row['cctransaction_amount'].'"';
	        $csvText .= '"'.$depositArray[ $row['event_id'] ].'"';
	                
	        $csvText .= "\n";
	    }
	    
	    return $csvText;
	}	            
**/	

/**	function loadAddCashTransaction()
	{
	    global $form;
	    global $eventID;
	    global $langID;
	    global $regID;
	    global $pageFunc;
	    global $adminID;
	    global $campusID;
	    
	    $form->setFormAction ( $pageFunc->getCallBack(PAGE_ADD_CASHTRANS, $langID, array( PARAM_EVENTID=>$eventID, PARAM_ADMINID=>$adminID, PARAM_CAMPUSID=>$campusID, PARAM_REGID=>$regID ) ) );
	    
	    $fieldInfo = 'cashtransaction_staffName|textbox|T|1|,cashtransaction_recd|checkbox|N|0|,cashtransaction_amtPaid|textbox|N|1|';
	    $form->setFields( $fieldInfo );
	    
	    $formData = array();
	    $formData['cashtransaction_staffName'] = '';
	    $formData['cashtransaction_recd'] = 1;
	    $formData['cashtransaction_amtPaid'] = 0;
	    $form->setFormData( $formData );
	    
	    return;
	}
	
	function loadAddCCTransaction()
	{
	    global $form;
	    global $eventID;
	    global $langID;
	    global $regID;
	    global $pageFunc;
	    global $adminID;
	    global $campusID;
	    
	    $fieldInfo = 'cctransaction_cardName|textbox|T|1|,cctype_id|droplist|N|1|,cctransaction_cardNum|textbox|T|1|,cctransaction_expiry|textbox|T|1|,cctransaction_billingPC|textbox|T|1|,cctransaction_amount|textbox|N|1|';
	    $form->setFields( $fieldInfo );
	    $form->setFormAction ( $pageFunc->getCallBack(PAGE_ADD_CCTRANS, $langID, array( PARAM_EVENTID=>$eventID, PARAM_ADMINID=>$adminID, PARAM_CAMPUSID=>$campusID, PARAM_REGID=>$regID ) ) );
	    
	    return;
	}
	
	
	function loadSignupPricingEventInfo()
	{
	    global $form;
	    global $formTwo;
	    global $eventID;
	    global $langID;
	    global $regID;
	    global $pageFunc;
	    
	    $fieldInfo = 'cctransaction_cardName|textbox|T|1|,cctype_id|droplist|N|1|,cctransaction_cardNum|textbox|T|1|,cctransaction_expiry|textbox|T|1|,cctransaction_billingPC|textbox|T|1|';
	    $form->setFields( $fieldInfo );
	    $form->setFormAction ( $pageFunc->getCallBack(PAGE_SIGNUP_PRICING_EVENT_INFO, $langID, array( PARAM_EVENTID=>$eventID, PARAM_REGID=>$regID ) ) );
	    
	    $fieldInfo = 'cashtransaction_staffName|textbox|T|1|';
	    $formTwo->setFields( $fieldInfo );
	    
	    return;
	}
**/

}	// end class FinancialTools	            
?>
