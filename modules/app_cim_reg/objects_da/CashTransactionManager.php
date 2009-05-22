<?php
/**
 * @package cim_reg
 */ 
/**
 * class RowManager_CashTransactionManager
 * <pre> 
 * Manages financial data pertaining to cash transactions between some registrant and the event host..
 * </pre>
 * @author Russ Martin
 */
class  RowManager_CashTransactionManager extends RowManager {

	//CONSTANTS:
	/** The name of the DB Table this class manages. */
    const DB_TABLE = 'cim_reg_cashtransaction';
    
    /** The SQL description of the DB Table this class manages. */
    /*
     * cashtransaction_id [INTEGER]  Unique identifier of a particular cash transaction from some registrant to event host
     * reg_id [INTEGER]  Value identifying the registrant from which the cash originates (if value is positive)
     * cashtransaction_staffName [STRING]  The name of the staff member receiving the cash (or dispersing if cash value is negative).
     * cashtransaction_recd [INTEGER]  Whether or not payment was received (1 or 0 for true/false).
     * cashtransaction_amtPaid [INTEGER]  Dollar amount of cash transaction.
     * cashtransaction_moddate [DATE]  Modification timestamp for cash transaction record.
     */
    const DB_TABLE_DESCRIPTION = " (
  cashtransaction_id int(10) NOT NULL  auto_increment,
  reg_id int(10) NOT NULL  default '0',
  cashtransaction_staffName varchar(64) NOT NULL  default '',
  cashtransaction_recd int(10) NOT NULL  default '0',
  cashtransaction_amtPaid int(12) NOT NULL  default '0',
  cashtransaction_moddate timestamp NOT NULL  ,
  PRIMARY KEY (cashtransaction_id)
) TYPE=MyISAM";
    
    /** The fields in the DB Table this class manages. */
    const FIELD_LIST = 'cashtransaction_id,reg_id,cashtransaction_staffName,cashtransaction_recd,cashtransaction_amtPaid,cashtransaction_moddate';
    
    /** The XML node name for this entry. */
    const XML_NODE_NAME = 'cashtransaction';
    

	//VARIABLES:


	//CLASS CONSTRUCTOR
	//************************************************************************
	/**
	 * function __construct
	 * <pre>
	 * Initialize this object.
	 * </pre>
	 * @param $CASHTRANS_ID [INTEGER] The unique id of the cashtransaction we are managing.
	 * @return [void]
	 */
    function __construct( $CASHTRANS_ID=-1 ) 
    {
    
        $dbTableName = RowManager_CashTransactionManager::DB_TABLE;
        $fieldList = RowManager_CashTransactionManager::FIELD_LIST;
        $primaryKeyField = 'cashtransaction_id';
        $primaryKeyValue = $CASHTRANS_ID;
        
        if (( $CASHTRANS_ID != -1 ) && ( $CASHTRANS_ID != '' )) {
        
            $condition = $primaryKeyField . '=' . $primaryKeyValue;
            
        } else {
            $condition = '';
        }
        $xmlNodeName = RowManager_CashTransactionManager::XML_NODE_NAME;
        parent::__construct( $dbTableName, $fieldList, $primaryKeyField, $primaryKeyValue, $condition, $xmlNodeName);
        
        $this->dbDescription = RowManager_CashTransactionManager::DB_TABLE_DESCRIPTION;

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
        
    
    //************************************************************************
	/**
	 * function deleteEntry
	 * <pre>
	 * Removes the DB table info.
	 * </pre>
	 * @return [void]
	 */
    function deleteEntry() 
    {   
	    parent::deleteEntry();

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
        
    } // end deleteEntry(    
    
    
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
	 * function setReceived
	 * <pre>
	 * Filter based on 'received' status
	 * </pre>
           *return [void]
	 * @param $received		the BOOLEAN indicating whether cash has been received
	 */
    function setReceived($received) 
    {
       if ($received == true) 
	    {  
        	$this->setValueByFieldName('cashtransaction_recd','1');
     	 }
     	 else 
     	 {
	     	$this->setValueByFieldName('cashtransaction_recd','0');
     	 }  
     			
    }    
       
    
    /**
	 * function setRegID
	 * <pre>
	 * Set the registration ID for filtering cash transactions
	 * </pre>
            *return void
	 * @param $regID		the ID of the registration linked to the cash transaction(s)
	 */
    function setRegID($regID) 
    {
        $this->setValueByFieldName('reg_id',$regID);
    } 

       //************************************************************************
	/**
	 * function loadByCashTransactionID
	 * <pre>
	 * Attempts to load this object given a cash trans. id
	 * </pre>
	 * @param $cashTransID [INTEGER] new cash tran. id
	 * @return [BOOL]
	 */
    function loadByCashTransactionID( $cashTransID )
    {
        $condition = 'cashtransaction_id='.$cashTransID;
        return $this->loadByCondition( $condition );
    }     
    	
}

?>