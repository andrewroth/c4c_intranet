<?php
/**
 * @package cim_reg
 */ 
/**
 * class RowManager_ScholarshipAssignmentManager
 * <pre> 
 * Assigns a scholarship to a registrant and manages affiliated data..
 * </pre>
 * @author Russ Martin
 */
class  RowManager_ScholarshipAssignmentManager extends RowManager {

	//CONSTANTS:
	/** The name of the DB Table this class manages. */
    const DB_TABLE = 'cim_reg_scholarship';
    
    /** The SQL description of the DB Table this class manages. */
    /*
     * scholarship_id [INTEGER]  Unique identifier of the scholarship being assigned.
     * registration_id [INTEGER]  Value identifying the registrant receiving the scholarship.
     * scholarship_amount [INTEGER]  The amount of money the scholarship is worth.
     * scholarship_sourceAcct [STRING]  The account number from where the scholarship originates.
     * scholarship_sourceDesc [STRING]  The description of the source account.
     */
    const DB_TABLE_DESCRIPTION = " (
  scholarship_id int(10) NOT NULL  auto_increment,
  registration_id int(10) NOT NULL  default '0',
  scholarship_amount int(12) NOT NULL  default '0',
  scholarship_sourceAcct varchar(64) NOT NULL  default '',
  scholarship_sourceDesc varchar(128) NOT NULL  default '',
  PRIMARY KEY (scholarship_id)
) TYPE=MyISAM";
    
    /** The fields in the DB Table this class manages. */
    const FIELD_LIST = 'scholarship_id,registration_id,scholarship_amount,scholarship_sourceAcct,scholarship_sourceDesc';
    
    /** The XML node name for this entry. */
    const XML_NODE_NAME = 'scholarshipassignment';
    

	//VARIABLES:


	//CLASS CONSTRUCTOR
	//************************************************************************
	/**
	 * function __construct
	 * <pre>
	 * Initialize this object.
	 * </pre>
	 * @param $SCHOLARSHIP_ID [INTEGER] The unique id of the scholarshipassignment we are managing.
	 * @return [void]
	 */
    function __construct( $SCHOLARSHIP_ID=-1 ) 
    {
    
        $dbTableName = RowManager_ScholarshipAssignmentManager::DB_TABLE;
        $fieldList = RowManager_ScholarshipAssignmentManager::FIELD_LIST;
        $primaryKeyField = 'scholarship_id';
        $primaryKeyValue = $SCHOLARSHIP_ID;
        
        if (( $SCHOLARSHIP_ID != -1 ) && ( $SCHOLARSHIP_ID != '' )) {
        
            $condition = $primaryKeyField . '=' . $primaryKeyValue;
            
        } else {
            $condition = '';
        }
        $xmlNodeName = RowManager_ScholarshipAssignmentManager::XML_NODE_NAME;
        parent::__construct( $dbTableName, $fieldList, $primaryKeyField, $primaryKeyValue, $condition, $xmlNodeName);
        
        $this->dbDescription = RowManager_ScholarshipAssignmentManager::DB_TABLE_DESCRIPTION;

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
	    
	    if (isset($values['registration_id']))
	    {
	    
		    // update balance owing column in cim_reg_registration table
		    $singleReg = new RowManager_RegistrationManager($values['registration_id']);
// 		    $singleReg_list = $singleReg->getListIterator();
// 		    $singleReg_array = $singleReg_list->getDataList();
// 		    
// 		    reset($singleReg_array);
// 		    $record = current($singleReg_array);
// 		    $oldBalance = $record['registration_balance'];
		    
			 $balanceGetter = new FinancialTools();
			 $balance = array();
// 			 $balance['registration_balance'] = $oldBalance - $record['cctransaction_amount'];
			 $balance['registration_balance'] = $balanceGetter->simpleCalcBalanceOwing($values['registration_id']);	
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
				
			    if (isset($values['registration_id']))
			    {
			    
				    // update balance owing column in cim_reg_registration table
				    $singleReg = new RowManager_RegistrationManager($values['registration_id']);
		// 		    $singleReg_list = $singleReg->getListIterator();
		// 		    $singleReg_array = $singleReg_list->getDataList();
		// 		    
		// 		    reset($singleReg_array);
		// 		    $record = current($singleReg_array);
		// 		    $oldBalance = $record['registration_balance'];
				    
					 $balanceGetter = new FinancialTools();
					 $balance = array();
		// 			 $balance['registration_balance'] = $oldBalance - $record['cctransaction_amount'];
					 $balance['registration_balance'] = $balanceGetter->simpleCalcBalanceOwing($values['registration_id']);	
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
	    
	    if (isset($values['registration_id']))
	    {
	    
		    // update balance owing column in cim_reg_registration table
		    $singleReg = new RowManager_RegistrationManager($values['registration_id']);
// 		    $singleReg_list = $singleReg->getListIterator();
// 		    $singleReg_array = $singleReg_list->getDataList();
// 		    
// 		    reset($singleReg_array);
// 		    $record = current($singleReg_array);
// 		    $oldBalance = $record['registration_balance'];
		    
			 $balanceGetter = new FinancialTools();
			 $balance = array();
// 			 $balance['registration_balance'] = $oldBalance - $record['cctransaction_amount'];
			 $balance['registration_balance'] = $balanceGetter->simpleCalcBalanceOwing($values['registration_id']);	
			 $singleReg->loadFromArray( $balance );
			 $singleReg->updateDBTable();			
		 }	  	    
        
    } // end deleteEntry(      
    
    
        /**
	 * function getJoinOnRegID
	 * <pre>
	 * returns the field used as a join condition (registration_id)
	 * </pre>
	 * @return [STRING]
	 */
    function getJoinOnRegID()
    {   
        return $this->getJoinOnFieldX('registration_id');
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
	 * Set the registration ID for filtering scholarships
	 * </pre>
	 *return [void]
	 * @param $regID		the ID of the registration linked to the scholarship(s)
	 */
    function setRegID($regID) 
    {
        $this->setValueByFieldName('registration_id',$regID);
    }    
    
   //************************************************************************
	/**
	 * function loadByRegID
	 * <pre>
	 * Attempts to load this object given a registration id
	 * </pre>
	 * @param $regID [INTEGER] new egistration id
	 * @return [BOOL]
	 */
    function loadByRegID( $regID )
    {
        $condition = 'registration_id='.$regID;
        return $this->loadByCondition( $condition );
    } 
    
       //************************************************************************
	/**
	 * function loadByScholarshipID
	 * <pre>
	 * Attempts to load this object given a scholarship id
	 * </pre>
	 * @param $scholarshipID [INTEGER] new scholarship id
	 * @return [BOOL]
	 */
    function loadByScholarshipID( $scholarshipID )
    {
        $condition = 'scholarship_id='.$scholarshipID;
        return $this->loadByCondition( $condition );
    } 
    	
}

?>