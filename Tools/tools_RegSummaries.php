<?php

$fileName = 'Tools/tools_Finances.php';
$path = Page::findPathExtension( $fileName );
require_once( $path.$fileName);

//require_once ('../aia_greycup/objects_da/TicketsManager.php');
require_once('TicketsManager.php');

//
//  REGISTRATION SUMMARY TOOLS
// 
//  DESCRIPTION:
//		This set of routines helps us to retrieve registration summary data
//

/**
 * class RegSummaryTools
 * <pre> 
 * This is a generic class that gives access to useful multi-table 
 * registration summary functions
 * @author Hobbe Smit
 */

class  RegSummaryTools  {

	//CONSTANTS:
	const TYPE_REG_ID = 1;
	const TYPE_EVENT_ID = 2;
	const TYPE_CAMPUS_ID = 3;
	const TYPE_PERSON_ID = 4;
	const TYPE_PRIMARY_KEY = 5;
   

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
	  
//************************************************************************

	/** RETRIEVE *UNIQUE* REGISTRATION DATA: USED FOR EVENT SUMMARY PURPOSES **/	
	function getUniqueRegistrations($eventID, $gender='', $areCancelled = false, $status = '')
	{
	  
	  $groupBy = 'registration_id';	// IMPORTANT: this is what forces count of only unique registration IDs
     $dbFunction = '';
     $funcParam = '';
     
     $registration = new RowManager_RegistrationManager();      
     $person = new RowManager_PersonManager();
     $assignment = new RowManager_AssignmentsManager();	// assigns campus to person 
     
     
     // filter by event ID
     if (isset($eventID)) 
     {
     		$registration->setEventID($eventID);
  	  }
  	  
  	  // filter by cancelled status
  	  if ($areCancelled==true)
  	  {
     	  $registration->setStatus(RowManager_RegistrationManager::STATUS_CANCELLED);
  	  }
  	  else if (isset($status)&&($status!=''))	 // filter by some defined status
  	  {
	     	  $registration->setStatus($status);
  	  }
  	 
  	   
  	  // filter by gender    	  
  	  if ($gender != '')
  	  {
     		$person->setGender($gender);
  	  }   
  
     
  	  // join 3 tables together: cim_hrdb_person, cim_hrdb_campus, and cim_reg_registration
     $uniqueRegs = new MultiTableManager();
     $uniqueRegs->addRowManager($registration);
     $uniqueRegs->addRowManager( $assignment, new JoinPair( $registration->getJoinOnPersonID(), $assignment->getJoinOnPersonID() ) );    
     $uniqueRegs->addRowManager( $person, new JoinPair( $assignment->getJoinOnPersonID(), $person->getJoinOnPersonID() ) );
	  
     // use GROUP BY and $dbFunction = 'COUNT' to quickly get summary data per campus
     if ($groupBy != '') {
     		$uniqueRegs->setGroupBy($groupBy);	//'campus_desc');
  		}
  		
  		if ($dbFunction != '') {
	     	$uniqueRegs->setFunctionCall($dbFunction,$funcParam);
     	}
		    	  
//      $uniqueRegs->setSortOrder( 'registration_id' );		// NOTE: could make this a function parameter as well
     $uniqueRegsIterator = $uniqueRegs->getListIterator(); 
     $regsArray = $uniqueRegsIterator->getDataList();	

     return $regsArray;
   }
   
   

    /** RETRIEVE CAMPUS REGISTRATION DATA: REQUIRES TABLE JOINS **/	
    // $eventID = valid integer; $gender = valid gender string or integer;
    // NOTE: $campusID may be CSV list if so desired
    // $areCancelled = boolean indicating whether to return only cancelled registrations
    // @return		[ARRAY]	an array of records having campusID as index and registrations total as data
	function getCampusRegistrations($eventID, $gender='', $areCancelled = false, $campusID = '', $regID = '', $status = '')
	{

        $groupBy = 'campus_desc';
        $dbFunction = 'COUNT';
        $funcParam = '';
        $regsArray = $this->getCampusPersonRegistrationData($eventID, $gender, $areCancelled, $campusID, $regID, $groupBy, $dbFunction, $funcParam, $status);

//         echo "<pre>".print_r($regsArray,true)."</pre>";
        
			// store results in array having campusID as key and total count as value
        $results = array();
        $temp = array();
        reset($regsArray);
        	foreach(array_keys($regsArray) as $k)
			{
				$temp = current($regsArray);				
				
        		$campusID = $temp['campus_id'];
        		$total = $temp['COUNT(*)'];
//        		echo $campusID.': '.$total.'<br>';
				$results[$campusID] = $total;
				
				next($regsArray);

			}
        
// 			echo "<pre>".print_r($results,true)."</pre>";
			
	    return $results;
	} 
	
	
	// returns an array of all the data stored in the person, assignment, campus, and registration tables; filtered by parameters (if set)
	// NOTE: campusID may be CSV list if so desired
	function getCampusPersonRegistrationData($eventID, $gender='', $areCancelled = false, $campusID = '', $regID = '', $groupBy = '', $dbFunction = '', $funcParam = '', $status = '')
	{
		
	/** TESTING GROUP BY on single table manager...**	CONCLUSION: use MultiTableManager
			$testRegs = new MultiTableManager();
			$test_reg = new RowManager_RegistrationManager(); 
			$testRegs->addRowManager($test_reg); 
		  
        // use GROUP BY and COUNT to quickly get summary data per campus
        $testRegs->setGroupBy('event_id');
		  $testRegs->setFunctionCall('COUNT','');
        $testRegs->setSortOrder( 'event_id' );
        $testRegsIterator = $testRegs->getListIterator(); 
        $testRegsArray = $testRegsIterator->getDataList();	

       echo "<pre>".print_r($testRegsArray,true)."</pre> WOOHOO!!";
** END TESTING **/
      	
        $registration = new RowManager_RegistrationManager();      
        $person = new RowManager_PersonManager();
        $assignment = new RowManager_AssignmentsManager();	// assigns campus to person
        $campus = new RowManager_CampusManager();
        
        // filter by registration id
        if ($regID !='')
        {	        
	        $registration->setRegID($regID);
        }
        
        // filter by event ID
        if (isset($eventID)) 
        {
        		$registration->setEventID($eventID);
     	  }
     	  
     	  // filter by cancelled status
     	  if ($areCancelled==true)
     	  {
	     	  $registration->setStatus(RowManager_RegistrationManager::STATUS_CANCELLED);
     	  }
     	  else if (isset($status)&&($status!=''))	 // filter by some defined status
     	  {
  	     	  $registration->setStatus($status);
     	  }
     	 
     	   
     	  // filter by gender    	  
     	  if ($gender != '')
     	  {
        		$person->setGender($gender);
     	  }   
     	  
//      	  // filter by campus
//      	  if ($campusID != '')
//      	  {
// 	     	  $campus->setCampusID($campusID);
//      	  }    
        
     	  // join 3 tables together: cim_hrdb_person, cim_hrdb_campus, and cim_reg_registration
        $campusRegs = new MultiTableManager();
        $campusRegs->addRowManager($campus);
        $campusRegs->addRowManager( $assignment, new JoinPair( $campus->getJoinOnCampusID(), $assignment->getJoinOnCampusID() ) );    
        $campusRegs->addRowManager( $person, new JoinPair( $assignment->getJoinOnPersonID(), $person->getJoinOnPersonID() ) );
        $campusRegs->addRowManager( $registration, new JoinPair( $person->getJoinOnPersonID(), $registration->getJoinOnPersonID()));        
		  
        // use GROUP BY and $dbFunction = 'COUNT' to quickly get summary data per campus
        if ($groupBy != '') {
        		$campusRegs->setGroupBy($groupBy);	//'campus_desc');
     		}
     		
     		if ($dbFunction != '') {
		     	$campusRegs->setFunctionCall($dbFunction,$funcParam);
	     	}
	     	
     	  // filter by campus
     	  if ($campusID != '')
     	  {
	     	  $campusRegs->addSearchCondition('cim_hrdb_campus.campus_id in ('.$campusID.')');
     	  }  	     	
			    	  
          //      $multiTableManager2->constructSearchCondition( 'event_id', '=', $this->event_id, true );
        $campusRegs->setSortOrder( 'campus_desc' );		// NOTE: could make this a function parameter as well
   //     $multiTableManager2->setLabelTemplate('viewer_userID', '[viewer_userID]');
        $campusRegsIterator = $campusRegs->getListIterator(); 
        $regsArray = $campusRegsIterator->getDataList();	
        
        return $regsArray;
     }	
     
     
// eventID - the id of this event
// campusID - the id of the campus for which you want to create the csv file
// includeFields - whether or not to include the field definitions
//
function getCSVScholarshipByCampus( $eventID, $campusID='', $regID = '', $includeFields=true )
{
    
    $csvText = '';
    
    if ( $includeFields )
    {
        $csvText .= 'Registration ID,Recipient ID,Last Name,First Name,Campus,Campus Status,Scholarship ID,Amount,Source Account,Source Description';
        $csvText .= "\n";
        
    }
    
    $scholarshipsArray = array();
	 $scholarshipsArray = $this->getAllScholarshipData($eventID, $campusID, $regID, $groupBy = '', $dbFunction = '', $funcParam = '');

		// store results in a CSV-formatted text string
     $row = array();
     reset($scholarshipsArray);
     	foreach(array_keys($scholarshipsArray) as $k)
		{
			$row = current($scholarshipsArray);	
			
		  $person_fname = iconv("UTF-8", "ISO-8859-1",$row['person_fname']); // properly displays accents, etc in spreadsheet app.
	     $person_lname = iconv("UTF-8", "ISO-8859-1",$row['person_lname']); // properly displays accents, etc in spreadsheet app.
		  $campus_desc = iconv("UTF-8", "ISO-8859-1",$row['campus_desc']); 
		  $scholarship_sourceAcct = iconv("UTF-8", "ISO-8859-1",$row['scholarship_sourceAcct']); 
		  $scholarship_sourceDesc = iconv("UTF-8", "ISO-8859-1",$row['scholarship_sourceDesc']); 
			
        $csvText .= $row['registration_id'] .',';
    
        $csvText .= $row['person_id'] .',';
        $csvText .= '"'.$person_fname .'",';
        $csvText .= '"'.$person_lname .'",';
        $csvText .= '"'.$campus_desc .'",';	 
        $csvText .= '"'.$row['assignmentstatus_desc'] .'",';	 
        $csvText .= '"'.$row['scholarship_id'] .'",';	         
        $csvText .= '"'.$row['scholarship_amount'] .'",';	 
        $csvText .= '"'.$scholarship_sourceAcct .'",';	 
        $csvText .= '"'.$scholarship_sourceDesc .'",';	                        
	        	        
        // end line
        $csvText .= "\n";
        				
							
			next($scholarshipsArray);	   	    	    	    		  	        	        	        	        
    }
    
    return $csvText;
}     
	
     
	/**
	 * getCSVbyCampus
	 * 
	 * @param  eventID - the id of this event
	 * @param  campusID - the id of the campus for which you want to create the csv file
	 * @param  includeFields - whether or not to include the field definitions
	 * @return	a CSV text dump summarizing registration information per campus
	 */
	function getCSVByCampus( $eventID, $campusID='', $includeFields=true )
	{
 
	    $csvText = '';
	    if ( $includeFields )
	    {
	        // person fields
	        $csvText ="Person ID,First Name,Last Name,Phone,E-mail,Address,City,Province,Postal Code,Gender,Local Phone,Local Address,Local City,Local Postal Code,Local Province,Campus,Campus Status,";
	        
	        // registration fields
	        $csvText .= "Registration Status,Registration ID,Event ID,Registration Date,Confirmation Number,";
	    }
	    

	    if ( $includeFields )
	    {
		    $fields = array();
		    
		    // get event-specific form fields for using as column headers in CSV file
			$fieldsArray = $this->getRecordByManager(new RowManager_FieldManager(), RegSummaryTools::TYPE_EVENT_ID, $eventID);	//$this->getFields($eventID);
			reset($fieldsArray);
        foreach(array_keys($fieldsArray) as $k)
        {
		      $fieldRecord = current($fieldsArray);
		      $fields_desc = iconv("UTF-8", "ISO-8859-1",$fieldRecord['fields_desc']); // properly displays accents, etc in spreadsheet app.
		        
		      $csvText .= '"'.$fields_desc.'",';
		      $fields[$fieldRecord['fields_id']] = $fields_desc;
				
				next($fieldsArray);
			}
		}
	          
	    
	    if ( $includeFields )    
	    {
	        // payement type stuff
	        $csvText .= 'Payment Type,';
	        $csvText .= 'Deposit Paid?,';
	        $csvText .= 'Payment Notes,';
	        $csvText .= 'Amount Paid,';
	        
	        // scholarship total
	        $csvText .= "Scholarship Total,";
	        
	        // event pricing
	        $csvText .= "Event Price,Balance Owing,Rules Applied";
	        
	        // end of the field definitions
	        $csvText .= "\n";
	        
	    } // if includeFields
	    
	    $provinceArray = array();
	    $provinces = $this->getRecordByManager(new RowManager_ProvinceManager());	    
			reset($provinces);
        foreach(array_keys($provinces) as $k)
        {
		      $prov = current($provinces);
		        
		      $provinceArray[ $prov['province_id'] ] = $prov['province_desc'];
			
				next($provinces);
			}	
			$provinceArray['0'] = '';	    
// 			echo "<pre>".print_r($provinceArray,true)."</pre>";
		   
//		 $groupBy = 'registration_id'   
		     
		 //function getCampusPersonRegistrationData($eventID, $gender='', $areCancelled = false, $campusID = '', $regID = '', $groupBy = '', $dbFunction = '', $funcParam = '')
	    $dataArray = $this->getAllRegistrationData($eventID, '', false, $campusID);	//,'',$groupBy);
		    

 //       echo "<pre>".print_r($dataArray,true)."</pre>";
        
			// store results in a CSV-formatted text string
        $results = array();
        $row = array();
        reset($dataArray);
        	foreach(array_keys($dataArray) as $k)
			{
				$row = current($dataArray);	
				
			  $person_fname = iconv("UTF-8", "ISO-8859-1",$row['person_fname']); // properly displays accents, etc in spreadsheet app.
	        $person_lname = iconv("UTF-8", "ISO-8859-1",$row['person_lname']); // properly displays accents, etc in spreadsheet app.
	        $person_addr = iconv("UTF-8", "ISO-8859-1",$row['person_addr']); // properly displays accents, etc in spreadsheet app.
	        $person_city = iconv("UTF-8", "ISO-8859-1",$row['person_city']); // properly displays accents, etc in spreadsheet app.
	        $person_local_addr = iconv("UTF-8", "ISO-8859-1",$row['person_local_addr']); // properly displays accents, etc in spreadsheet app.
	        $person_local_city = iconv("UTF-8", "ISO-8859-1",$row['person_local_city']); // properly displays accents, etc in spreadsheet app.
		  	  $campus_desc = iconv("UTF-8", "ISO-8859-1",$row['campus_desc']); 

				
	        $regID = $row['registration_id'];
	    
	        $csvText .= $row['person_id'] .',';
	        $csvText .= '"'.$person_fname .'",';
	        $csvText .= '"'.$person_lname .'",';
	        $csvText .= '"'.$row['person_phone'] .'",';
	        $csvText .= '"'.$row['person_email'] .'",';
	        $csvText .= '"'.$person_addr .'",';
	        $csvText .= '"'.$person_city .'",';
	        $csvText .= $provinceArray[ $row['province_id'] ] .',';
	        $csvText .= '"'.$row['person_pc'] .'",';
	        $csvText .= $row['gender_desc'] .',';
	        $csvText .= '"'.$row['person_local_phone'] .'",';
	        $csvText .= '"'.$person_local_addr .'",';
	        $csvText .= '"'.$person_local_city .'",';
	        $csvText .= '"'.$row['person_local_pc'] .'",'; 
	        $csvText .= $provinceArray[ $row['person_local_province_id'] ] .',';		// province conflict... whether id or desc...
	        $csvText .= $campus_desc .',';
	        $csvText .= $row['assignmentstatus_desc'] .',';
	        
	        $csvText .= RowManager_RegistrationManager::getStatusDesc($row['registration_status']) .',';
	        $csvText .= $row['registration_id'] .','; 
	        $csvText .= $row['event_id'] .','; 
	        $csvText .= '"'.$row['registration_date'] .'",'; 
	        $csvText .= '"'.$row['registration_confirmNum'] .'",';
	        	        											
//         		$campusID = $temp['campus_id'];
//         		$total = $temp['COUNT(*)'];
//        		echo $campusName.': '.$total.'<br>';
// 				$results[$campusID] = $total;


			    // get event-specific form field data for CSV file
// 				$fieldArray = $this->getFieldValues(new RowManager_FieldValueManager(), $regID);
				$fieldArray = $this->getRecordByManager(new RowManager_FieldValueManager(), RegSummaryTools::TYPE_REG_ID, $regID);	//$this->getFields($eventID);
				
			  $fvalues = array();

			  //
				reset($fieldArray);
	        foreach(array_keys($fieldArray) as $k)
	        {
			      $fieldValue = current($fieldArray);
			      
			      $fieldvalues_value = iconv("UTF-8", "ISO-8859-1",$fieldValue['fieldvalues_value']); // properly displays accents, etc in spreadsheet app.
			      $fvalues[$fieldValue['fields_id']] = $fieldvalues_value;
			        
//			      $csvText .= '"'.$fieldValue['fieldvalues_value'].'",';
			
					next($fieldArray);
				}	
				
				/** Any fields whose values were not set must be given default '' value **/
// 				if (count($fvalues) < 1)
// 				{
					$availableFieldsArray = $this->getRecordByManager(new RowManager_FieldManager(), RegSummaryTools::TYPE_EVENT_ID, $eventID);	//$this->getFields($eventID);
					foreach(array_keys($availableFieldsArray) as $k)
		         {
				      $fieldValue = current($availableFieldsArray);
				      
				      if (!isset($fvalues[$fieldValue['fields_id']]))
				      {

				      	$fieldValue['fieldvalues_value'] = '';		// could use 'default' but might just confuse people
				      	$fvalues[$fieldValue['fields_id']] = $fieldValue['fieldvalues_value'];
			      	}
				      next($availableFieldsArray);
					}						
// 				}
	        
				// need to sort array of retrieved values so that they match column headers 
				// (for some reason RowManager's ORDER BY is really slow)
				ksort($fvalues);
				reset($fvalues);
	        foreach(array_keys($fvalues) as $k)
	        {
			      $fieldValue2 = current($fvalues);
			      
// 			      $fvalues[$fieldValue['fields_id']] = $fieldValue['fieldvalues_value'];
			        
			      $csvText .= '"'.$fieldValue2.'",';
			
					next($fvalues);
				}					
				
 
	        // payment type
	        $paymentType = '';          
	        $paymentNotes = '';
	        $depositPaid = '';
	        $amountPaid = 0;
	        
	        		    // get registration-specific cash transaction records
				$cashTransArray = $this->getRecordByManager(new RowManager_CashTransactionManager(), RegSummaryTools::TYPE_REG_ID, $regID);
				reset($cashTransArray);
	        foreach(array_keys($cashTransArray) as $k)
	        {
			      $cashRecord = current($cashTransArray);
		         $cashtransaction_staffName = iconv("UTF-8", "ISO-8859-1",$cashRecord['cashtransaction_staffName']); // properly displays accents, etc in spreadsheet app.			      
			      
			      $paymentType .= 'CASH | ';
	            $paymentNotes .= 'Pay to ' . $cashtransaction_staffName . ' $' . $cashRecord['cashtransaction_amtPaid'] . ' '; 
	            if ( $cashRecord['cashtransaction_recd'] == 1 )
	            {
	                $depositPaid .= 'YES | ';
	                $paymentNotes .= 'PAID';
	                $amountPaid += $cashRecord['cashtransaction_amtPaid'];
	            }
	            else
	            {
	                $depositPaid .= 'NO | ';
	                $paymentNotes .= 'NOT PAID';
	            }	
	            
	            $paymentNotes .= ' | ';  			        
					
					next($cashTransArray);
				}
				
				
	        		    // get registration-specific credit card transaction records
				$ccTransArray = $this->getRecordByManager(new RowManager_CreditCardTransactionManager(), RegSummaryTools::TYPE_REG_ID, $regID);
				reset($ccTransArray);
	        foreach(array_keys($ccTransArray) as $k)
	        {
			      $ccRecord = current($ccTransArray);
			      $cctransaction_cardName = iconv("UTF-8", "ISO-8859-1",$ccRecord['cctransaction_cardName']); // properly displays accents, etc in spreadsheet app.			      

			      
			      if ($ccRecord['cctransaction_processed'] == '1')
			      {
		            $paymentType .= 'CC | ';
		            $paymentNotes .= 'Charged to '.$cctransaction_cardName.' $'.$ccRecord['cctransaction_amount'].' | ';
		            $amountPaid += $ccRecord['cctransaction_amount'];
		            
		            $paymentNotes .= ' | ';  		
	            }	        
					
					next($ccTransArray);
				}				
				
			  if ( $paymentType == '' )
	        {
	            $paymentType = 'NON-PAYMENT/ERROR';
	        }
				
	       $csvText .= '"'. $paymentType .'",';
	       $csvText .= '"'.$depositPaid .'",';
	       $csvText .= '"'.$paymentNotes .'",';
	       $csvText .= '"'.$amountPaid .'",';				
	        
	       
	        // scholarship total
	        $scholarshipTotal = 0;
	        
	        	$scholarshipArray = $this->getRecordByManager(new RowManager_ScholarshipAssignmentManager(), RegSummaryTools::TYPE_REG_ID, $regID);
				reset($scholarshipArray);
	        foreach(array_keys($scholarshipArray) as $k)
	        {
			      $scholarshipRecord = current($scholarshipArray);
			      
					$scholarshipTotal += $scholarshipRecord['scholarship_amount'];			        
					
					next($scholarshipArray);
				}
	        
	        $csvText .= $scholarshipTotal.',';				
				       

	        $rulesApplied = array();
	                
	        // how much deposit have they paid plus any scholarships
//	        $totalCredits = $amountPaid + $scholarshipTotal;

	        
	        $financeTools = new FinancialTools();
	        $basePriceForThisGuy = 0;
	        $balanceOwing = $financeTools->calcBalanceOwing($regID, $rulesApplied, $basePriceForThisGuy);
	                
	        // print the cost for this registrant
	        $csvText .= $basePriceForThisGuy.",";
	        
	        // how much to they owe
//	        $balanceOwing = $basePriceForThisGuy - $totalCredits;
	        $csvText .= $balanceOwing.',';
	        
	        // print out the rulesApplied array
	        $rulesText = '';
	        foreach( $rulesApplied as $ruleKey=>$ruleValue )
	        {
		         $pricerules_desc = iconv("UTF-8", "ISO-8859-1",$ruleValue['pricerules_desc']); // properly displays accents, etc in spreadsheet app.
	            $rulesText .= $pricerules_desc. ' '.$ruleValue['pricerules_discount'] .' | ' ;
	        }
	        
	        $csvText .= '"'.$rulesText.'"';
	        	        
	        // end line
	        $csvText .= "\n";
	        				
								
				next($dataArray);	   	    	    	    		  	        	        	        	        
	    }
	    
	    return $csvText;
	}	
  
    	// returns an array of registration-specific form field values (for event-specific form fields)
	function getFieldValues($fvalues, $regID='')
	{
		 //$fvalues = new RowManager_FieldValueManager();
		 if ($regID == '') 
		 {
		 		$fvalues->setRegID($regID);
	    }
	    $fvalues->setSortByFieldID();

       $valuesIterator = $fvalues->getListIterator(); 
       $valuesArray = $valuesIterator->getDataList();	
       
       return $valuesArray;
    }

    
    // takes in some RowManager object and its primary key, if set
    function getRecordByManager($recordManager, $paramType=RegSummaryTools::TYPE_PRIMARY_KEY, $paramID='')
    {
	    $class = get_class($recordManager); 
	    $records = new $class();
	    
	    if ($paramID != '')
	    {
	    	 // filter records by the initialized parameter ID
		    switch ($paramType) 
		    {
			    case RegSummaryTools::TYPE_REG_ID:
			    	$records->setRegID($paramID);
			    	break;
			    case RegSummaryTools::TYPE_EVENT_ID:
			    	$records->setEventID($paramID);
			    	break;
			    case RegSummaryTools::TYPE_CAMPUS_ID:
			    	$records->setCampusID($paramID);
			    	break;
			    case RegSummaryTools::TYPE_PERSON_ID:
			    	$records->setPersonID($paramID);
			    	break;
			    case RegSummaryTools::TYPE_PRIMARY_KEY:
			    default:
			    	$records = new $class($paramID);
			    	break;
		    }
	    }	
	    
	    $recordsIterator = $records->getListIterator(); 
       $recordsArray = $recordsIterator->getDataList();	
       
       return $recordsArray;
    }	    
    
    
	// returns an array of all the scholarship data stored; filtered by parameters (if set)
	function getAllScholarshipData($eventID, $campusID = '', $regID = '', $groupBy = '', $dbFunction = '', $funcParam = '')
	{
		
        $scholarship = new RowManager_ScholarshipAssignmentManager();
        $registration = new RowManager_RegistrationManager();      
        $person = new RowManager_PersonManager();
        $assignment = new RowManager_EditCampusAssignmentManager();	// assigns campus to person
        $assignStatus = new RowManager_CampusAssignmentStatusManager();
        $campus = new RowManager_CampusManager();

                
        // filter by registration id
        if ($regID !='')
        {	        
	        $registration->setRegID($regID);
        }
        
        // filter by event ID
        if (isset($eventID)) 
        {
        		$registration->setEventID($eventID);
     	  }
     	  
     	  // filter by campus
     	  if ($campusID != '')
     	  {
	     	  $campus->setCampusID($campusID);
     	  }    
        
     	  // join these tables together: cim_hrdb_person, cim_hrdb_assignment, cim_hrdb_campus, cim_reg_registration,
     	  // cim_reg_scholarship
        $scholarshipRecords = new MultiTableManager();
        $scholarshipRecords->addRowManager($scholarship);
        $scholarshipRecords->addRowManager( $registration, new JoinPair( $registration->getJoinOnRegID(), $scholarship->getJoinOnRegID()));        
        $scholarshipRecords->addRowManager( $person, new JoinPair( $person->getJoinOnPersonID(), $registration->getJoinOnPersonID()));                 
        $scholarshipRecords->addRowManager( $assignment, new JoinPair( $person->getJoinOnPersonID(), $assignment->getJoinOnPersonID() ) );
        $scholarshipRecords->addRowManager( $assignStatus, new JoinPair( $assignStatus->getJoinOnStatusID(), $assignment->getJoinOnStatusID() ) );           
        $scholarshipRecords->addRowManager( $campus, new JoinPair( $assignment->getJoinOnCampusID(), $campus->getJoinOnCampusID() ) );
       		  
        // use GROUP BY and $dbFunction = 'COUNT' to quickly get summary data per campus
        if ($groupBy != '') {
        		$scholarshipRecords->setGroupBy($groupBy);	//'campus_desc');
     		}
     		
     		if ($dbFunction != '') {
		     	$scholarshipRecords->setFunctionCall($dbFunction,$funcParam);
	     	}
			    	  
          //      $multiTableManager2->constructSearchCondition( 'event_id', '=', $this->event_id, true );
        $scholarshipRecords->setSortOrder( 'person_lname' );		// NOTE: could make this a function parameter as well
   //     $multiTableManager2->setLabelTemplate('viewer_userID', '[viewer_userID]');
        $scholarshipIterator = $scholarshipRecords->getListIterator(); 
        $scholarshipsArray = $scholarshipIterator->getDataList();	
        
        return $scholarshipsArray;
     }	
 
	
	// returns an array of all the data stored in the person, assignment, campus, and registration tables; filtered by parameters (if set)
	function getAllRegistrationData($eventID, $gender='', $areCancelled = false, $campusID = '', $regID = '', $groupBy = '', $dbFunction = '', $funcParam = '')
	{
		
	/** TESTING GROUP BY on single table manager...**	CONCLUSION: use MultiTableManager
			$testRegs = new MultiTableManager();
			$test_reg = new RowManager_RegistrationManager(); 
			$testRegs->addRowManager($test_reg); 
		  
        // use GROUP BY and COUNT to quickly get summary data per campus
        $testRegs->setGroupBy('event_id');
		  $testRegs->setFunctionCall('COUNT','');
        $testRegs->setSortOrder( 'event_id' );
        $testRegsIterator = $testRegs->getListIterator(); 
        $testRegsArray = $testRegsIterator->getDataList();	

       echo "<pre>".print_r($testRegsArray,true)."</pre> WOOHOO!!";
** END TESTING **/
      	
        $registration = new RowManager_RegistrationManager();      
        $person = new RowManager_PersonManager();
        $assignment = new RowManager_EditCampusAssignmentManager();	// assigns campus to person
        $assignStatus = new RowManager_CampusAssignmentStatusManager();
        $campus = new RowManager_CampusManager();
        $field = new RowManager_FieldValueManager();
//         $cashTrans = new RowManager_CashTransactionManager();
//         $ccTrans = new RowManager_CreditCardTransactionManager();
//         $scholarship = new RowManager_ScholarshipAssignmentManager();
        $genderManager = new RowManager_GenderManager();
//        $provinceManager = new RowManager_ProvinceManager();
//        $provinceManager2 = new RowManager_ProvinceManager();
                
        // filter by registration id
        if ($regID !='')
        {	        
	        $registration->setRegID($regID);
        }
        
        // filter by event ID
        if (isset($eventID)) 
        {
        		$registration->setEventID($eventID);
     	  }
     	  
     	  // filter by cancelled status
     	  if ($areCancelled==true)
     	  {
	     	  $registration->setStatus(RowManager_RegistrationManager::STATUS_CANCELLED);
     	  }
     	   
     	  // filter by gender    	  
     	  if ($gender != '')
     	  {
        		$person->setGender($gender);
     	  }   
     	  
     	  
     	  // filter by campus
     	  if ($campusID != '')
     	  {	     	  
	     	  $campus->setCampusID($campusID);
     	  }    
        
     	  // join these tables together: cim_hrdb_person, cim_hrdb_assignment, cim_hrdb_campusassignmentstatus, cim_hrdb_campus, cim_reg_registration,
     	  //	cim_reg_fieldvalues, cim_reg_cashtransaction, cim_reg_cctransaction, cim_reg_scholarship, cim_hrdb_province, cim_hrdb_gender
        $registrationRecords = new MultiTableManager();
        $registrationRecords->addRowManager($person);
        $registrationRecords->addRowManager( $assignment, new JoinPair( $person->getJoinOnPersonID(), $assignment->getJoinOnPersonID() ) );
        $registrationRecords->addRowManager( $assignStatus, new JoinPair( $assignStatus->getJoinOnStatusID(), $assignment->getJoinOnStatusID() ) );           
        $registrationRecords->addRowManager( $campus, new JoinPair( $assignment->getJoinOnCampusID(), $campus->getJoinOnCampusID() ) );
        $registrationRecords->addRowManager( $registration, new JoinPair( $person->getJoinOnPersonID(), $registration->getJoinOnPersonID()));
//         $registrationRecords->addRowManager( $field, new JoinPair( $registration->getJoinOnRegID(), $field->getJoinOnRegID()));        
//         $registrationRecords->addRowManager( $cashTrans, new JoinPair( $registration->getJoinOnRegID(), $cashTrans->getJoinOnRegID()));        
//         $registrationRecords->addRowManager( $ccTrans, new JoinPair( $registration->getJoinOnRegID(), $ccTrans->getJoinOnRegID()));        
//         $registrationRecords->addRowManager( $scholarship, new JoinPair( $registration->getJoinOnRegID(), $scholarship->getJoinOnRegID()));        
        $registrationRecords->addRowManager( $genderManager, new JoinPair( $person->getJoinOnGenderID(), $genderManager->getJoinOnGenderID()));        
//        $registrationRecords->addRowManager( $provinceManager, new JoinPair( $person->getJoinOnProvinceID(), $provinceManager->getJoinOnProvinceID()));        
//        $registrationRecords->addRowManager( $provinceManager2, new JoinPair( $person->getJoinOnLocalProvinceID(), $provinceManager2->getJoinOnProvinceID()));        

        		  
        // use GROUP BY and $dbFunction = 'COUNT' to quickly get summary data per campus
        if ($groupBy != '') {
        		$registrationRecords->setGroupBy($groupBy);	//'campus_desc');
     		}
     		
     		if ($dbFunction != '') {
		     	$registrationRecords->setFunctionCall($dbFunction,$funcParam);
	     	}
//         echo $registrationRecords->createSQL();
        			    	  
          //      $multiTableManager2->constructSearchCondition( 'event_id', '=', $this->event_id, true );
        $registrationRecords->setSortOrder( 'person_lname' );		// NOTE: could make this a function parameter as well
   //     $multiTableManager2->setLabelTemplate('viewer_userID', '[viewer_userID]');
        $regsIterator = $registrationRecords->getListIterator(); 
        $regsArray = $regsIterator->getDataList();	
        

        
        return $regsArray;
     }		
     
     
     
     	/**
	 * getCSVforAIAEvent
	 * 
	 * @param  eventID - the id of this event
	 * @param  includeFields - whether or not to include the field definitions
	 * @return	a CSV text dump summarizing registration information
	 */
	function getCSVforAIAEvent( $eventID, $includeFields=true )
	{
    
	    $csvText = '';
	    if ( $includeFields )
	    {
	        // person fields
	        $csvText ="Person ID,First Name,Last Name,E-mail,Address,City,Province,Postal Code,";
	        
	        // registration fields
	        $csvText .= "Registration Status,Registration ID,Event ID,Registration Date,Confirmation Number,";
	    }
	    
	    if ( $includeFields )
	    {
		    // AIA-specific fields
		    $csvText .= "# of Tickets, Wants to be surveyed?,";
	    }
	          
	    
	    if ( $includeFields )    
	    {
	        // payement type stuff
	        $csvText .= 'Payment Type,';
// 	        $csvText .= 'Deposit Paid?,';
	        $csvText .= 'Payment Notes,';
	        $csvText .= 'Amount Paid,';
	        
	        // scholarship total
// 	        $csvText .= "Scholarship Total,";
	        
	        // event pricing
// 	        $csvText .= "Event Price,Balance Owing";
	        
	        // end of the field definitions
	        $csvText .= "\n";
	        
	    } // if includeFields
	    
	    $provinceArray = array();
	    $provinces = $this->getRecordByManager(new RowManager_ProvinceManager());	    
			reset($provinces);
        foreach(array_keys($provinces) as $k)
        {
		      $prov = current($provinces);
		        
		      $provinceArray[ $prov['province_id'] ] = $prov['province_desc'];
			
				next($provinces);
			}	
			$provinceArray['0'] = '';	    
// 			echo "<pre>".print_r($provinceArray,true)."</pre>";
		   
//		 $groupBy = 'registration_id'   
		     
		 //function getCampusPersonRegistrationData($eventID, $gender='', $areCancelled = false, $campusID = '', $regID = '', $groupBy = '', $dbFunction = '', $funcParam = '')
	    $dataArray = $this->getNonCampusRegistrationData($eventID, '', false);	//,'',$groupBy);
		    

 //       echo "<pre>".print_r($dataArray,true)."</pre>";
        
			// store results in a CSV-formatted text string
        $results = array();
        $row = array();
        reset($dataArray);
        	foreach(array_keys($dataArray) as $k)
			{
				$row = current($dataArray);	
				
			  $person_fname = iconv("UTF-8", "ISO-8859-1",$row['person_fname']); // properly displays accents, etc in spreadsheet app.
	        $person_lname = iconv("UTF-8", "ISO-8859-1",$row['person_lname']); // properly displays accents, etc in spreadsheet app.
	        $person_addr = iconv("UTF-8", "ISO-8859-1",$row['person_addr']); // properly displays accents, etc in spreadsheet app.
	        $person_city = iconv("UTF-8", "ISO-8859-1",$row['person_city']); // properly displays accents, etc in spreadsheet app.
	        				
	        $regID = $row['registration_id'];
	    
	        $csvText .= $row['person_id'] .',';

	        $csvText .= '"'.$person_fname .'",';
	        $csvText .= '"'.$person_lname .'",';
	        $csvText .= '"'.$row['person_email'] .'",';
	        $csvText .= '"'.$person_addr .'",';
	        $csvText .= '"'.$person_city .'",';
	        $csvText .= $provinceArray[ $row['province_id'] ] .',';
	        $csvText .= '"'.$row['person_pc'] .'",';
	        
	        $csvText .= RowManager_RegistrationManager::getStatusDesc($row['registration_status']) .',';
	        $csvText .= $row['registration_id'] .','; 
	        $csvText .= $row['event_id'] .','; 
	        $csvText .= '"'.$row['registration_date'] .'",'; 
	        $csvText .= '"'.$row['registration_confirmNum'] .'",';
	        
	        
	        
	        	// get # of tickets ordered and survey interest (should only be 1 record per registration ID)
				$ticketsArray = $this->getRecordByManager(new RowManager_TicketsManager(), RegSummaryTools::TYPE_REG_ID, $regID);
				if (isset($ticketsArray)&&(count($ticketsArray) > 0))
				{
					
					reset($ticketsArray);
		        foreach(array_keys($ticketsArray) as $k)
		        {
				      $ticketRecord = current($ticketsArray);
	
		            $csvText .= '"'.$ticketRecord['num_tickets'].'",';		
		            $toSurvey = $ticketRecord['to_survey'];
		            
		            switch($toSurvey)
		            {
			            case 1:
			            	$csvText .= "Yes,";
			            	break;
			            case 0:
			            default:
			            	$csvText .= "No,";
			            	break;
		            }
						
						next($ticketsArray);
					}	
				}
				else
				{
					 $csvText .= 'not set,';
					 $csvText .= 'not set,';
				}	

 
	        // payment type
	        $paymentType = '';          
	        $paymentNotes = '';
	        $depositPaid = '';
	        $amountPaid = 0;
	        
	        		    // get registration-specific cash transaction records
				$cashTransArray = $this->getRecordByManager(new RowManager_CashTransactionManager(), RegSummaryTools::TYPE_REG_ID, $regID);
				reset($cashTransArray);
	        foreach(array_keys($cashTransArray) as $k)
	        {
			      $cashRecord = current($cashTransArray);
			      
			      $paymentType .= 'CASH | ';
	            $paymentNotes .= 'Pay to ' . $cashRecord['cashtransaction_staffName'] . ' $' . $cashRecord['cashtransaction_amtPaid'] . ' '; 
	            if ( $cashRecord['cashtransaction_recd'] == 1 )
	            {
	                $depositPaid .= 'YES | ';
	                $paymentNotes .= 'PAID';
	                $amountPaid += $cashRecord['cashtransaction_amtPaid'];
	            }
	            else
	            {
	                $depositPaid .= 'NO | ';
	                $paymentNotes .= 'NOT PAID';
	            }	
	            
	            $paymentNotes .= ' | ';  			        
					
					next($cashTransArray);
				}
				
				
	        		    // get registration-specific credit card transaction records
				$ccTransArray = $this->getRecordByManager(new RowManager_CreditCardTransactionManager(), RegSummaryTools::TYPE_REG_ID, $regID);
				reset($ccTransArray);
	        foreach(array_keys($ccTransArray) as $k)
	        {
			      $ccRecord = current($ccTransArray);
			      
			      if ($ccRecord['cctransaction_processed'] == '1')
			      {
		            $paymentType .= 'CC | ';
		            $paymentNotes .= 'Charged to '.$ccRecord['cctransaction_cardName'].' $'.$ccRecord['cctransaction_amount'].' | ';
		            $amountPaid += $ccRecord['cctransaction_amount'];
		            
		            $paymentNotes .= ' | ';  		
	            }	        
					
					next($ccTransArray);
				}				
				
			  if ( $paymentType == '' )
	        {
	            $paymentType = 'NON-PAYMENT/ERROR';
	        }
				
	       $csvText .= '"'. $paymentType .'",';
// 	       $csvText .= '"'.$depositPaid .'",';
	       $csvText .= '"'.$paymentNotes .'",';
	       $csvText .= '"'.$amountPaid .'",';				

	        	        
	        // end line
	        $csvText .= "\n";
	        				
								
				next($dataArray);	   	    	    	    		  	        	        	        	        
	    }
	    
	    return $csvText;
	}	
	
	
		// returns an array of all the data stored in the person, assignment, campus, and registration tables; filtered by parameters (if set)
	function getNonCampusRegistrationData($eventID, $areCancelled = false, $regID = '', $groupBy = '', $dbFunction = '', $funcParam = '')
	{
      	
        $registration = new RowManager_RegistrationManager();      
        $person = new RowManager_PersonManager();

                
        // filter by registration id
        if ($regID !='')
        {	        
	        $registration->setRegID($regID);
        }
        
        // filter by event ID
        if (isset($eventID)) 
        {
        		$registration->setEventID($eventID);
     	  }
     	  
     	  // filter by cancelled status
     	  if ($areCancelled==true)
     	  {
	     	  $registration->setStatus(RowManager_RegistrationManager::STATUS_CANCELLED);
     	  }

        
     	  // join these tables together: cim_hrdb_person, cim_hrdb_assignment, cim_hrdb_campusassignmentstatus, cim_hrdb_campus, cim_reg_registration,
     	  //	cim_reg_fieldvalues, cim_reg_cashtransaction, cim_reg_cctransaction, cim_reg_scholarship, cim_hrdb_province, cim_hrdb_gender
        $registrationRecords = new MultiTableManager();
        $registrationRecords->addRowManager($registration);
        $registrationRecords->addRowManager( $person, new JoinPair( $person->getJoinOnPersonID(), $registration->getJoinOnPersonID()));

        		  
        // use GROUP BY and $dbFunction = 'COUNT' to quickly get summary data per campus
        if ($groupBy != '') {
        		$registrationRecords->setGroupBy($groupBy);	//'campus_desc');
     		}
     		
     		if ($dbFunction != '') {
		     	$registrationRecords->setFunctionCall($dbFunction,$funcParam);
	     	}
//         echo $registrationRecords->createSQL();
        			    	  
          //      $multiTableManager2->constructSearchCondition( 'event_id', '=', $this->event_id, true );
        $registrationRecords->setSortOrder( 'person_lname' );		// NOTE: could make this a function parameter as well
   //     $multiTableManager2->setLabelTemplate('viewer_userID', '[viewer_userID]');
        $regsIterator = $registrationRecords->getListIterator(); 
        $regsArray = $regsIterator->getDataList();	
        
//         echo "list: <pre>".print_r($regsArray,true)."</pre>";

        
        return $regsArray;
     }	
     
     
	// NON-REGISTRATION-BASED METHOD: returns an array of all the student seniority data stored; filtered by parameters (if set)
	function getStudentSeniorityData($campusID = '', $campus_status = '', $staff_id = '', $groupBy = '', $dbFunction = '', $funcParam = '')
	{
		$validCampus = true;
		
/**		
        $seniority = new RowManager_PersonYearManager();
        $person = new RowManager_PersonManager();
        $yearDesc = new RowManager_YearInSchoolManager();
        $assignment = new RowManager_EditCampusAssignmentManager();	// assigns campus to person
        $assignStatus = new RowManager_CampusAssignmentStatusManager();
        $campus = new RowManager_CampusManager();

     	  
     	  // filter by campus
     	  if ($campusID != '')
     	  {
	     	  $campus->setCampusID($campusID);
     	  }
     	  
     	  // filter by campus status
     	  if ($campus_status != '')
     	  {
	     	  $assignment->addSearchCondition('assignmentstatus_id in ($campus_status)');
     	  }         	      
        
     	  // join these tables together: cim_hrdb_person, cim_hrdb_assignment, cim_hrdb_campus, cim_hrdb_personyear,
        $seniorityRecords = new MultiTableManager();
        $seniorityRecords->addRowManager($seniority);        
        $seniorityRecords->addRowManager( $person, new JoinPair( $person->getJoinOnPersonID(), $seniority->getJoinOnPersonID()));   
        $seniorityRecords->addRowManager( $yearDesc, new JoinPair( $seniority->getJoinOnYearID(), $yearDesc->getJoinOnYearID()));
        $seniorityRecords->addRowManager( $assignment, new JoinPair( $person->getJoinOnPersonID(), $assignment->getJoinOnPersonID() ) );
        $seniorityRecords->addRowManager( $assignStatus, new JoinPair( $assignStatus->getJoinOnStatusID(), $assignment->getJoinOnStatusID() ) );           
        $seniorityRecords->addRowManager( $campus, new JoinPair( $assignment->getJoinOnCampusID(), $campus->getJoinOnCampusID() ) );
**/
// 			if ($staff_id != '')		// using staff_id, determine whether the campus_id parameter is valid for that staff
// 			{    
// 			  $adminChecker = new MultiTableManager();
// 			  $staff = new RowManager_StaffManager();  
// 			  $staff->setStaffID($staff_id);         
// 			  $people = new RowManager_PersonManager();   			  
// 			  $admins = new RowManager_AdminManager();
// 			  $admins->setSitePriv();
// 			  
// 			  $adminChecker->addRowManager($admins);
// 			  $adminChecker->addRowManager($people, new JoinPair($admins->getJoinOnPersonID(), $people->getJoinOnPersonID()));
// 	        $adminChecker->addRowManager($staff, new JoinPair($staff->getJoinOnPersonID(), $people->getJoinOnPersonID()));	
// 	        
// 	        $adminList = $adminChecker->getListIterator();	
// 	        $adminArray = $adminList->getDataList();
// 	        
// 	        if (count($adminArray) > 0)		// the current viewer is a super-admin: allow viewing of all campuses
// 	        {
// 		        	$validCampus = true;
// 	        }  
// 	        else 	// must determine if this staff-person is allowed to view the campus parameter passed in
// 	        {				
// 				  $campusChecker = new MultiTableManager();				 			             
// 				  $staff = new RowManager_StaffManager();  
// 				  $staff->setStaffID($staff_id);         
// 				  $people = new RowManager_PersonManager();   
// 				  $assignments = new RowManager_AssignmentsManager();
// 	           
// 				  $campusChecker->addRowManager($assignments);
// 				  $campusChecker->addRowManager($people, new JoinPair($assignments->getJoinOnPersonID(), $people->getJoinOnPersonID()));
// 		        $campusChecker->addRowManager($staff, new JoinPair($staff->getJoinOnPersonID(), $people->getJoinOnPersonID()));
// 		        
// 	        	  $campusCheckList = $campusChecker->getListIterator();
// 	        	  $campusCheckArray = $campusCheckList->getDataList();
// 	        	  
// 	        	  foreach (array_keys($campusCheckArray) as $key)
// 	        	  {
// 		        	  $record = current($campusCheckArray);
// 		        	  $campus_id = $record['campus_id'];
// 		        	  
// 		        	  if ($campus_id == $campusID)
// 		        	  {
// 			        	  $validCampus = true;
// 		        	  }	
// 	        	  }
//         	  }	        	  
//         }	

        $seniorityArray = array();
		  if ($validCampus == true)
		  {
		     $personYearManager = new RowManager_PersonYearManager();
		     $campusAssignments = new RowManager_AssignmentsManager();
		     $campusAssignments->setCampusID($campusID);	    
		     $person = new RowManager_PersonManager(); 
		     $yearDesc = new RowManager_YearInSchoolManager();
		     $assignStatus = new RowManager_CampusAssignmentStatusManager();
	   
	        $seniorityRecords = new MultiTableManager();	//new RowManager_PersonYearManager();
	        $seniorityRecords->addRowManager($campusAssignments);
	        $seniorityRecords->addRowManager( $assignStatus, new JoinPair( $assignStatus->getJoinOnStatusID(), $campusAssignments->getJoinOnStatusID(), JOIN_TYPE_LEFT ) );   
	        $seniorityRecords->addRowManager($personYearManager, new JoinPair($personYearManager->getJoinOnPersonID(), $campusAssignments->getJoinOnPersonID(), JOIN_TYPE_LEFT));   
	        $seniorityRecords->addRowManager( $person, new JoinPair( $person->getJoinOnPersonID(), $personYearManager->getJoinOnPersonID()));  
	        $seniorityRecords->addRowManager( $yearDesc, new JoinPair( $personYearManager->getJoinOnYearID(), $yearDesc->getJoinOnYearID()));    
	 
		     if ($campus_status != '')
		     {
		     		$seniorityRecords->addSearchCondition('cim_hrdb_assignment.assignmentstatus_id in ('.$campus_status.')');	// filter results by student-campus status
	     	  }   
	       		  
	        // use GROUP BY and $dbFunction = 'COUNT' to quickly get summary data per campus
	        if ($groupBy != '') {
	        		$seniorityRecords->setGroupBy($groupBy);
	     		}
	     		
	     		if ($dbFunction != '') {
			     	$seniorityRecords->setFunctionCall($dbFunction,$funcParam);
		     	}
				    	  
	        $seniorityRecords->setSortOrder( 'year_id,person_lname' );		// NOTE: could make this a function parameter as well
	        $seniorityIterator = $seniorityRecords->getListIterator(); 
	        $seniorityArray = $seniorityIterator->getDataList();	
        }
        
        return $seniorityArray;
     }
     
 	// NON-REGISTRATION-BASED METHOD: returns a CSV of all the student seniority data stored; filtered by parameters (if set)
 	function getStudentSeniorityCSV($campusID = '', $campus_status = '', $staffID = '', $groupBy = '', $dbFunction = '', $funcParam = '', $includeFields = true)
	{   	     	
		$dataArray = $this->getStudentSeniorityData($campusID, $campus_status, $staffID, $groupBy, $dbFunction, $funcParam);
		
   	 $csvText = '';
	    if ( $includeFields == true)
	    {
	        // person fields
	        $csvText ="Grad. Date, Year in School,Campus Status,First Name,Last Name,E-mail";
	        $csvText .= "\n";
	    }

 //       echo "<pre>".print_r($dataArray,true)."</pre>";
        
			// store results in a CSV-formatted text string
        $results = array();
        $row = array();
        reset($dataArray);
        	foreach(array_keys($dataArray) as $k)
			{
				$row = current($dataArray);	
				
// 	        $personyearID = $row['personyear_id'];
	    
			  if ($row['assignmentstatus_id'] == 0)
			  {
				  $assignStatus = 'Undefined Status';
			  }
			  else
			  {
				  $assignStatus = $row['assignmentstatus_desc'];
			  }
			  
			  $csvText .= $row['grad_date'] . ',';	
	        $csvText .= $row['year_desc'] .',';
	        $csvText .= $assignStatus .',';
	        $person_fname = iconv("UTF-8", "ISO-8859-1",$row['person_fname']);	// properly displays accents, etc in spreadsheet app.
	        $csvText .= '"'.$person_fname .'",';
	        $person_lname = iconv("UTF-8", "ISO-8859-1",$row['person_lname']); // properly displays accents, etc in spreadsheet app.
	        $csvText .= '"'.$person_lname.'",';
	        $csvText .= '"'.$row['person_email'] .'",';
	        	        
	        // end line
	        $csvText .= "\n";
	        				
								
				next($dataArray);	   	    	    	    		  	        	        	        	        
	    }
	    
	    return $csvText;		
    }
    
    
    
	// NON-REGISTRATION-BASED METHOD: returns an array of all the staff activity data stored; not filtered (yet)
	function getStaffActivityData($director_id = '')
	{
		
     $staff_activities = new RowManager_StaffActivityManager();   
     $activity_types = new RowManager_ActivityTypeManager();
     $person = new RowManager_PersonManager(); 
     
     $activityRecords = new MultiTableManager();	
     $activityRecords->addRowManager($staff_activities);
     $activityRecords->addRowManager($activity_types, new JoinPair( $staff_activities->getJoinOnActivityTypeID(), $activity_types->getJoinOnActivityTypeID())); 
     $activityRecords->addRowManager( $person, new JoinPair( $person->getJoinOnPersonID(), $staff_activities->getJoinOnPersonID()));    	
		
		if ($director_id != '')
		{
	        $staffManager = new RowManager_StaffDirectorManager();
	        $staffManager->setDirectorID($director_id);
	        
				/* Retrieve all directors under the current director */
	        $hierarchy_result = $staffManager->getDirectorHierarchy($director_id);	        
	        $hierarchy_result->setFirst();
	        $hierarchy_array = array();
	        $directed_staff = '';
           while( $hierarchy_result->moveNext() ) {
	           $staff_ids = $hierarchy_result->getCurrentRow();
// 	           echo 'array = <pre>'.print_r($hierarchy_array,true).'</pre>';

					for ($lvl = 1; $lvl <= MAX_DIRECTOR_LEVELS; $lvl++)
					{
						$staff_id = $staff_ids['staff_lvl'.$lvl];
						if ($staff_id != null)
						{
							$directed_staff .= $staff_id.',';
						}
					}					
           }   
           if ($directed_staff != '')	// if staff found under director, then simply remove comma
           {
	          $directed_staff .=	$director_id;	//= substr( $directed_staff, 0, -1 );
           }    
           else 	// Stop any sub-query errors or accidental loosing of control
           {
	          $directed_staff = $director_id;	//page_ViewScheduleCalendar::NON_DIRECTOR;
           } 
           
           $staff = new RowManager_StaffManager();
	        $activityRecords->addRowManager($staff, new JoinPair($staff->getJoinOnPersonID(), $person->getJoinOnPersonID()));
	        $activityRecords->addSearchCondition('staff_id in ('.$directed_staff.')');           
        }			

			    	  
        $activityRecords->setSortOrder( 'person_lname,person_fname,staffactivity_startdate,staffactivity_enddate' );		// NOTE: could make this a function parameter as well
        $activityIterator = $activityRecords->getListIterator(); 
        $activityArray = $activityIterator->getDataList();	
        
        return $activityArray;
     }    
    
    
 	// NON-REGISTRATION-BASED METHOD: returns a CSV of all the staff activity data stored; originally had no filter parameters
 	function getStaffActivitiesCSV($director_id = '', $includeFields = true)
 	{
		$dataArray = $this->getStaffActivityData($director_id);
		
   	 $csvText = '';
	    if ( $includeFields == true)
	    {
	        // person fields
	        $csvText ="Last Name,First Name,Activity Type,Start Date,End Date,Contact Phone #";
	        $csvText .= "\n";
	    }

 //       echo "<pre>".print_r($dataArray,true)."</pre>";
        
			// store results in a CSV-formatted text string
        $results = array();
        $row = array();
        reset($dataArray);
        	foreach(array_keys($dataArray) as $k)
			{
				$row = current($dataArray);	
				
// 	        $personyearID = $row['personyear_id'];
	    
// 			  if ($row['activitytype_id'] == 0)
// 			  {
// 				  $assignStatus = 'Undefined Activity Type';
// 			  }
// 			  else
// 			  {
// 				  $assignStatus = $row['activitytype_desc'];
// 			  }
			  
	        $person_lname = iconv("UTF-8", "ISO-8859-1",$row['person_lname']); // properly displays accents, etc in spreadsheet app.
	        $csvText .= '"'.$person_lname.'",';
	        $person_fname = iconv("UTF-8", "ISO-8859-1",$row['person_fname']);	// properly displays accents, etc in spreadsheet app.
	        $csvText .= '"'.$person_fname .'",';	        
	        $csvText .= '"'.$row['activitytype_desc'] .'",';
	        $csvText .= '"'.$row['staffactivity_startdate'] .'",';
	        $csvText .= '"'.$row['staffactivity_enddate'] .'",';
	        $csvText .= '"'.$row['staffactivity_contactPhone'] .'",';
	        
	        	        
	        // end line
	        $csvText .= "\n";
	        				
								
				next($dataArray);	   	    	    	    		  	        	        	        	        
	    }
	    
	    return $csvText;	
    }	 	
    
    // Simple function for returning the abbreviation of a title of a custom report given its ID
    function getCustomReportTitleAbbrev($reportID)
    {
	    $titleAbbrev = '';
	    
	    $customReports = new RowManager_CustomReportsManager($reportID);	    
	    $fullTitle = $customReports->getReportName();
	    
       $title_bits = explode(' ', $fullTitle);
       foreach (array_keys($title_bits) as $key)
       {
	       $titleAbbrev .= substr(current($title_bits),0,3).'_';
	       next($title_bits);
       }
       return $titleAbbrev;
    }
    
    // Function for returning the field labels to be associated with a particular custom report
    function getCustomReportFields($reportID)
    {
	    $fieldsList = '';

	     $custom_fields = new RowManager_CustomFieldsManager();  
	     $custom_fields->setReportID($reportID); 
	     $fields_desc = new RowManager_FormFieldManager();
	     
        $fieldLabels = new MultiTableManager();	
        $fieldLabels->addRowManager($fields_desc);
       $fieldLabels->addRowManager($custom_fields, new JoinPair( $fields_desc->getJoinOnFieldID(), $custom_fields->getJoinOnFieldID())); 
			    	  
        $fieldLabels->setSortOrder( 'fields_priority, fields_id' );		// NOTE: could make this a function parameter as well
        $labelsIterator = $fieldLabels->getListIterator(); 
        $labelsArray = $labelsIterator->getDataList();	
  
		  if (count($labelsArray) > 0)
		  {
			  $fieldsList .= 'Last Name,First Name,';
		  }              
        foreach( array_keys($labelsArray) as $key )
        {
	        $record = current($labelsArray);
	        $fieldsList .= $record['fields_desc'].',';
	        next($labelsArray);
        }
        $fieldsList = substr($fieldsList,0,-1);	// remove comma
        
        return $fieldsList;
     }
     	    
     
     // Function for returning the field data to be associated with a particular custom report
    function getCustomReportData($reportID, $director_id = '')
    {
			// Initialize primary data access object
		  $dataAccessObject = new MultiTableManager();
		  $person_manager = new RowManager_PersonManager();
		  $dataAccessObject->addRowManager($person_manager);    
		  
			  
			if ($director_id != '')
			{
	        $staffManager = new RowManager_StaffDirectorManager();
	        $staffManager->setDirectorID($director_id);
	        
				/* Retrieve all directors under the current director */
	        $hierarchy_result = $staffManager->getDirectorHierarchy($director_id);	        
	        $hierarchy_result->setFirst();
	        $hierarchy_array = array();
	        $directed_staff = '';
           while( $hierarchy_result->moveNext() ) {
	           $staff_ids = $hierarchy_result->getCurrentRow();
// 	           echo 'array = <pre>'.print_r($hierarchy_array,true).'</pre>';

					for ($lvl = 1; $lvl <= MAX_DIRECTOR_LEVELS; $lvl++)
					{
						$staff_id = $staff_ids['staff_lvl'.$lvl];
						if ($staff_id != null)
						{
							$directed_staff .= $staff_id.',';
						}
					}					
           }   
           if ($directed_staff != '')	// if staff found under director, then simply remove comma
           {
	          $directed_staff .=	$director_id;	//= substr( $directed_staff, 0, -1 );
           }    
           else 	// Stop any sub-query errors or accidental loosing of control
           {
	          $directed_staff = $director_id;	//page_ViewScheduleCalendar::NON_DIRECTOR;
           } 
           
           $staff = new RowManager_StaffManager();
	        $dataAccessObject->addRowManager($staff, new JoinPair($staff->getJoinOnPersonID(), $person_manager->getJoinOnPersonID()));
	        $dataAccessObject->addSearchCondition('staff_id in ('.$directed_staff.')');           
        }			  
	    
	     // First, get the fields used by the report
        $this->fields_id_array = array(); 
        
        $customfields = new RowManager_CustomFieldsManager();
        $customfields->setReportID($reportID);		
        $customFieldsList = $customfields->getListIterator();
        $customFieldsArray = $customFieldsList->getDataList();
                
        $i = 0;
        foreach (array_keys($customFieldsArray) as $key)
        {
	        $record = current($customFieldsArray);
        	  $this->fields_id_array[$i] = $record['fields_id'];
        	  $i++;	next($customFieldsArray);
     	  }	    
	    
     	  
     	  // Second, create an elaborate query using temp. tables to allow custom data columns
		  $fieldList = '';
		  $temp_tables = array();
		  if (count($this->fields_id_array) > 0)
		  {
			  $fieldList = 'person_lname,person_fname,';
		  }
		  for ($i=0; $i < count($this->fields_id_array); $i++)
		  {
			  $tempTableCreationSQLmaker = new MultiTableManager();
			  $fieldvalue_manager = new RowManager_FormFieldValueManager();
			  $fieldvalue_manager->setFieldID($this->fields_id_array[$i]);

		  	  
		  	  // Create a temporary table from a SQL join retrieving the data for a particular form field
			  $tempTableCreationSQLmaker->addRowManager($fieldvalue_manager);
			  $fields_manager = new RowManager_FormFieldManager();
			  $tempTableCreationSQLmaker->addRowManager($fields_manager, new JoinPair($fieldvalue_manager->getJoinOnFieldID(), $fields_manager->getJoinOnFieldID()));
			  $customfields_manager = new RowManager_CustomFieldsManager();
			  $customfields_manager->setReportID($reportID);
			  $tempTableCreationSQLmaker->addRowManager($customfields_manager, new JoinPair($fieldvalue_manager->getJoinOnFieldID(),$customfields_manager->getJoinOnFieldID()));
			  $tempFieldList = 'person_id,fieldvalues_value';
			  $tempTableCreationSQLmaker->setFieldList($tempFieldList);
			  
			  $tempTableCreationSQL = $tempTableCreationSQLmaker->createSQL();
			  
			  $temp_tables[$i] = new TempTableManager( 'temptable'.$i, $tempTableCreationSQL, $tempFieldList, 'temptable'.$i); //$PRIMARY_ID=-1
			  $temp_tables[$i]->createTable(true);
			  
			  
			  // Join the temporary tables together to get a table of n+1 columns where n = count($this->field_ids_array) and the extra column stores person_id
			  if ($i > 0)
			  {
				  $fieldList .= ',temptable'.$i.'.fieldvalues_value as value'.$i;
				  $i_minus = $i - 1;
		  	  		$dataAccessObject->addRowManager($temp_tables[$i], new JoinPair($temp_tables[$i_minus]->getJoinOnFieldX(page_ViewCustomReport::JOIN_FIELD), $temp_tables[$i]->getJoinOnFieldX(page_ViewCustomReport::JOIN_FIELD)));
  	  		  }
  	  		  else {
	  	  		  $fieldList .= 'temptable'.$i.'.person_id,temptable'.$i.'.fieldvalues_value as value'.$i;
	  	  		  $dataAccessObject->addRowManager($temp_tables[0], new JoinPair($person_manager->getJoinOnFieldX(page_ViewCustomReport::JOIN_FIELD), $temp_tables[0]->getJoinOnFieldX(page_ViewCustomReport::JOIN_FIELD)));
  	  		  }	  
	  	  }
	  	  	  	  
		  $dataAccessObject->setFieldList($fieldList);
		  $dataAccessObject->setSortOrder('person_lname,person_fname');
	     $listManager = $dataAccessObject->getListIterator();	
	     $fieldsDataArray =  $listManager->getDataList(); 	     
        
        return $fieldsDataArray;
     }    
     

 	// NON-REGISTRATION-BASED METHOD: returns a CSV of custom report data filtered and determined by the reportID parameter
    function getCustomReportCSV($reportID, $director_id = '', $includeFields = true)
    {
		$dataArray = $this->getCustomReportData($reportID, $director_id);
		$fieldsList = $this->getCustomReportFields($reportID);
		$fieldsArray = explode(",",$fieldsList);
		
   	 $csvText = '';
	    if ( $includeFields == true)
	    {
	        // report fields
	        $csvText = $fieldsList;
	        $csvText .= "\n";
	    }

 //       echo "<pre>".print_r($dataArray,true)."</pre>";
        
			// store results in a CSV-formatted text string
        $results = array();
        $row = array();
        reset($dataArray);
        	foreach(array_keys($dataArray) as $k)
			{
				$row = current($dataArray);	
				
// 				echo '<pre>'.print_r($row,true).'</pre>';

				reset($fieldsArray);				
      					  
				$i = -2;
				foreach( array_keys( $fieldsArray) as $field_key )
				{
					if ($i == -2)
					{
		        		$person_lname = iconv("UTF-8", "ISO-8859-1",$row['person_lname']); // properly displays accents, etc in spreadsheet app.
		        		$csvText .= '"'.$person_lname.'",';						
	        		}
	        		else if ($i == -1)
	        		{
		        		$person_fname = iconv("UTF-8", "ISO-8859-1",$row['person_fname']); // properly displays accents, etc in spreadsheet app.
		        		$csvText .= '"'.$person_fname.'",';  		
	        		} 
	        		else
	        		{       		
						$field = current($fieldsArray);
		        		$field_data = iconv("UTF-8", "ISO-8859-1",$row['value'.$i]); // properly displays accents, etc in spreadsheet app.
		        		$csvText .= '"'.$field_data.'",';
	        		}
	        		next($fieldsArray);   $i++;
        		}
	        	        
	        // end line
	        $csvText .= "\n";
	        				
								
				next($dataArray);	   	    	    	    		  	        	        	        	        
	    }
	    
	    return $csvText;	
    }	    
	
} 
?>
