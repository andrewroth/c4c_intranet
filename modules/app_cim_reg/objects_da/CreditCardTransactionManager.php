<?php
/**
 * @package cim_reg
 */ 
/**
 * class RowManager_CreditCardTransactionManager
 * <pre> 
 * Manages the details pertaining to a credit card transaction from some registrant to the appropriate event host..
 * </pre>
 * @author Russ Martin
 */
class  RowManager_CreditCardTransactionManager extends RowManager {

	//CONSTANTS:
	/** The name of the DB Table this class manages. */
    const DB_TABLE = 'cim_reg_cctransaction';
    
    /** The SQL description of the DB Table this class manages. */
    /*
     * cctransaction_id [INTEGER]  Unique identifier for a particular credit card transaction record
     * reg_id [INTEGER]  Identifier of the registrant involved in the credit card transaction (generally the payee).
     * cctransaction_cardName [STRING]  Name displayed on the credit card used for this transaction.
     * cctype_id [INTEGER]  Identifier for the particular credit card type used
     * cctransaction_cardNum [STRING]  The credit card number
     * cctransaction_expiry [STRING]  The expiry date of the credit card being used.
     * cctransaction_billingPC [STRING]  Postal code of the credit card's billing address.
     * cctransaction_processed [INTEGER]  Whether or not transaction has been processed (1 = true, 0 = false).
     * cctransaction_amount [INTEGER]  The amount of money being transacted.
     * cctransaction_moddate [DATE]  The timestamp of the last modification to the transaction record.
     */
    const DB_TABLE_DESCRIPTION = " (
  cctransaction_id int(10) NOT NULL  auto_increment,
  reg_id int(10) NOT NULL  default '0',
  cctransaction_cardName varchar(64) NOT NULL  default '',
  cctype_id int(10) NOT NULL  default '0',
  cctransaction_cardNum text NOT NULL  default '',
  cctransaction_expiry varchar(64) NOT NULL  default '',
  cctransaction_billingPC varchar(7) NOT NULL  default '',
  cctransaction_processed int(1) NOT NULL  default '0',
  cctransaction_amount int(12) NOT NULL  default '0',
  cctransaction_moddate timestamp NOT NULL  ,
  cctransaction_refnum varchar(255),
  PRIMARY KEY (cctransaction_id)
) TYPE=MyISAM";
    
    /** The fields in the DB Table this class manages. */
    const FIELD_LIST = 'cctransaction_id,reg_id,cctransaction_cardName,cctype_id,cctransaction_cardNum,cctransaction_expiry,cctransaction_billingPC,cctransaction_processed,cctransaction_amount,cctransaction_moddate,cctransaction_refnum';
    
    /** The XML node name for this entry. */
    const XML_NODE_NAME = 'creditcardtransaction';
    

	//VARIABLES:


	//CLASS CONSTRUCTOR
	//************************************************************************
	/**
	 * function __construct
	 * <pre>
	 * Initialize this object.
	 * </pre>
	 * @param $CCTRANS_ID [INTEGER] The unique id of the creditcardtransaction we are managing.
	 * @return [void]
	 */
    function __construct( $CCTRANS_ID=-1 ) 
    {
    
        $dbTableName = RowManager_CreditCardTransactionManager::DB_TABLE;
        $fieldList = RowManager_CreditCardTransactionManager::FIELD_LIST;
        $primaryKeyField = 'cctransaction_id';
        $primaryKeyValue = $CCTRANS_ID;
        
        if (( $CCTRANS_ID != -1 ) && ( $CCTRANS_ID != '' )) {
        
            $condition = $primaryKeyField . '=' . $primaryKeyValue;
            
        } else {
            $condition = '';
        }
        $xmlNodeName = RowManager_CreditCardTransactionManager::XML_NODE_NAME;
        parent::__construct( $dbTableName, $fieldList, $primaryKeyField, $primaryKeyValue, $condition, $xmlNodeName);
        
        $this->dbDescription = RowManager_CreditCardTransactionManager::DB_TABLE_DESCRIPTION;

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
        //return $this->getValueByFieldName( 'applicant_codename' );
    }
    
     //************************************************************************
	/**
	 * function createNewEntry
	 * <pre>
	 * Creates a new table entry in the DB for this object to manage.
	 * </pre>
	 * @param $doAllowPrimaryKeyUpdate [BOOL] allow insertion of primary key 
	 * value if present.
	 * @return [void]
	 */
    function createNewEntry( $doAllowPrimaryKeyUpdate=false ) 
    {  
	    parent::createNewEntry( $doAllowPrimaryKeyUpdate );
	    
	    //$ccTransID = $this->getID(); 
	    $values = $this->getArrayOfValues();
// 	    echo "<pre>".print_r($values,true)."</pre>";
	    
	    if (isset($values['reg_id']))
	    {
	    
		    // update balance owing column in cim_reg_registration table
		    $singleReg = new RowManager_RegistrationManager($values['reg_id']);
// 		    $singleReg_list = $singleReg->getListIterator();
// 		    $singleReg_array = $singleReg_list->getDataList();
// 		    
// 		    reset($singleReg_array);
// 		    $record = current($singleReg_array);
// 		    $oldBalance = $record['registration_balance'];
		    
			 $balanceGetter = new FinancialTools();
			 $balance = array();
// 			 $balance['registration_balance'] = $oldBalance - $record['cctransaction_amount'];
			 $balance['registration_balance'] = $balanceGetter->simpleCalcBalanceOwing($values['reg_id']);	
			 $singleReg->loadFromArray( $balance );
			 $singleReg->updateDBTable();			
		 }	    
    } 
    
 
    //************************************************************************
	/**
	 * function updateDBTable
	 * <pre>
	 * Updates the DB table info.
	 * </pre>
	 * @return [void]
	 */
    function updateDBTable( $isDebug=false ) 
    {   
	    $status = parent::updateDBTable( $isDebug );
	    
	    if ($status == true)
	    {
	    		$values = $this->getArrayOfValues();
				// 	    echo "<pre>".print_r($values,true)."</pre>";
				
			    if (isset($values['reg_id']))
			    {
			    
				    // update balance owing column in cim_reg_registration table
				    $singleReg = new RowManager_RegistrationManager($values['reg_id']);
		// 		    $singleReg_list = $singleReg->getListIterator();
		// 		    $singleReg_array = $singleReg_list->getDataList();
		// 		    
		// 		    reset($singleReg_array);
		// 		    $record = current($singleReg_array);
		// 		    $oldBalance = $record['registration_balance'];
				    
					 $balanceGetter = new FinancialTools();
					 $balance = array();
		// 			 $balance['registration_balance'] = $oldBalance - $record['cctransaction_amount'];
					 $balance['registration_balance'] = $balanceGetter->simpleCalcBalanceOwing($values['reg_id']);	
					 $singleReg->loadFromArray( $balance );
					 $singleReg->updateDBTable();			
				 }	 	
		 }	    

        
    } // end updateDBTable() 
    
    
    // TODO: update balance owing IF single-record deletion is implemented for CC transactions  (currently only deleted if main reg. record is)
    // HSMIT, Aug. 15, 2007
	    
    
    
    //************************************************************************
	/**
	 * function loadFromArray (overrides parent function)
	 * <pre>
	 * Loads this object from a given array of data.
	 * </pre>
	 * @param $values [ARRAY] array of data: array( $field=>$value,...,$field=>$value);
	 * @return [void]
	 */
    function loadFromArray($values) 
    {
	    $cardNum = $values['cctransaction_cardNum'];
	    $values['cctransaction_cardNum'] = substr($cardNum, 0, 3).'****'.substr($cardNum, -3);
	    parent::loadFromArray($values);
	    
	    
// 	    if (isset($values['reg_id']))
// 	    {
// 	    
// 		    // update balance owing column in cim_reg_registration table
// 		    $singleReg = new RowManager_RegistrationManager($values['reg_id']);
// // 		    $singleReg_list = $singleReg->getListIterator();
// // 		    $singleReg_array = $singleReg_list->getDataList();
// // 		    
// // 		    reset($singleReg_array);
// // 		    $record = current($singleReg_array);
// // 		    $oldBalance = $record['registration_balance'];
// 		    
// 			 $balanceGetter = new FinancialTools();
// 			 $balance = array();
// // 			 $balance['registration_balance'] = $oldBalance - $record['cctransaction_amount'];
// 			 $balance['registration_balance'] = $balanceGetter->simpleCalcBalanceOwing($values['reg_id']);	
// 			 $singleReg->loadFromArray( $balance );
// 			 $singleReg->updateDBTable();			
// 		 }
    }    
    
   /**
	 * function getJoinOnRegID
	 * <pre>
	 * returns the field used as a join condition for registration_id
	 * </pre>
	 * @return [STRING]
	 */
    function getJoinOnRegID()
    {   
        return $this->getJoinOnFieldX('reg_id');
    }    
    
   /**
	 * function getJoinOnTypeID
	 * <pre>
	 * returns the field used as a join condition for cctype_id
	 * </pre>
	 * @return [STRING]
	 */
    function getJoinOnTypeID()
    {   
        return $this->getJoinOnFieldX('cctype_id');
    }      
    
    
    //************************************************************************
	/**
	 * function getLabelField
	 * <pre>
	 * Returns the field to use in the label routines.
	 * </pre>
	 * @return [STRING]
	 */
    function getLabelField() 
    {
        return "No Field Label Marked";
    }
    

    /**
	 * function setRegID
	 * <pre>
	 * Set the registration ID for filtering cash transactions
	 * </pre>
	*return [void]
	 * @param $regID		the ID of the registration linked to the cash transaction(s)
	 */
    function setRegID($regID) 
    {
        $this->setValueByFieldName('reg_id',$regID);
    }     
    
     /**
	 * function setProcessed
	 * <pre>
	 * Filter based on 'processed' status
	 * </pre>
	 *return [void]
	 * @param $processed		the BOOLEAN indicating whether transaction has been processed
	 */
    function setProcessed($processed) 
    {
       if ($processed == true) 
	    {  
        	$this->setValueByFieldName('cctransaction_processed','1');
     	 }
     	 else 
     	 {
	     	$this->setValueByFieldName('cctransaction_processed','0');
     	 }  
     			
    }     
    
    
    /**
	 * function setCCtransID
	 * <pre>
	 * Set the CC transaction ID for filtering cc transactions
	 * </pre>
	 *return [void]
	 * @param $ccTransId		the ID of the CC transaction
	 */
    function setCCtransID($ccTransId) 
    {
        $this->setValueByFieldName('cctransaction_id',$ccTransId);
    }       
    
    /**
	 * function setProcessedFlag
	 * <pre>
	 * Set the CC transaction flag indicated whether it was processed
	 * </pre>
	 *return [void]
	 * @param $isProcessed		whether or not the transaction was processed (0 = false, 1 = true)
	 */
    function setProcessedFlag($isProcessed = 1) 
    {
        $this->setValueByFieldName('cctransaction_processed',$isProcessed);
    }  
    
        	
  //************************************************************************
	/**
	 * function loadByRegID
	 * <pre>
	 * Attempts to load this Credit Card Transaction given a Registration ID.
	 * </pre>
	 * @param $userID [STRING] the registration id of the transaction to load
	 * @return [BOOL]
	 */
    function loadByRegID( $regID ) 
    {
        $condition = ' reg_id="'.$regID.'" ';
        
        return $this->loadByCondition( $condition );
    }
    
           //************************************************************************
	/**
	 * function loadByCashTransactionID
	 * <pre>
	 * Attempts to load this object given a cc trans. id
	 * </pre>
	 * @param $ccTransID [INTEGER] new cc tran. id
	 * @return [BOOL]
	 */
    function loadByCCTransactionID( $ccTransID )
    {
        $condition = 'cctransaction_id='.$ccTransID;
        return $this->loadByCondition( $condition );
    } 
}

?>