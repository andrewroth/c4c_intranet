<?php
/**
 * @package cim_reg
 */ 
/**
 * class RowManager_ReceiptManager
 * <pre> 
 * A record of an official Moneris operation associated with a particular transaction record..
 * </pre>
 * @author Russ Martin
 */
class  RowManager_ReceiptManager extends RowManager {

	//CONSTANTS:
	/** The name of the DB Table this class manages. */
    const DB_TABLE = 'cim_reg_ccreceipt';
    
    /** The SQL description of the DB Table this class manages. */
    /*
     * ccreceipt_sequencenum [STRING]  The unique identifier of a receipt returned by Moneris.
     * ccreceipt_authcode [STRING]  According to Moneris:
Authorization code returned from the issuing institution.
     * ccreceipt_responsecode [STRING]  According to Moneris:
Transaction Response Code
< 50: Transaction approved
>= 50: Transaction declined
NULL: Transaction was not sent for authorization
* If you would like further details on the response codes that are returned please see
the Response Codes document available at
https://www3.moneris.com/connect/en/documents/index.html
     * ccreceipt_message [STRING]  According to Moneris:
Response description returned from issuing institution.

Major types: APPROVED, DECLINED, CALL FOR, and HOLD CARD
     * ccreceipt_moddate [DATE]  The timestamp of when the receipt was created (or modified... but preferably no modifications are made).
     * cctransaction_id [INTEGER]  The unique identifier of a CC transaction to associate with this Moneris receipt.
     */
    const DB_TABLE_DESCRIPTION = " (
  ccreceipt_sequencenum varchar(18) NOT NULL  auto_increment,
  ccreceipt_authcode varchar(8) NOT NULL  default '',
  ccreceipt_responsecode varchar(3) NOT NULL  default '',
  ccreceipt_message varchar(100) NOT NULL  default '',
  ccreceipt_moddate timestamp(14) NOT NULL  default 'CURRENT_TIMESTAMP',
  cctransaction_id int(10) NOT NULL  default '0',
  PRIMARY KEY (cctransaction_id)
) TYPE=MyISAM";
    
    /** The fields in the DB Table this class manages. */
    const FIELD_LIST = 'ccreceipt_sequencenum,ccreceipt_authcode,ccreceipt_responsecode,ccreceipt_message,ccreceipt_moddate,cctransaction_id';
    
    /** The XML node name for this entry. */
    const XML_NODE_NAME = 'ccreceipt';
    

	//VARIABLES:


	//CLASS CONSTRUCTOR
	//************************************************************************
	/**
	 * function __construct
	 * <pre>
	 * Initialize this object.
	 * </pre>
	 * @param $RECEIPT_ID [INTEGER] The unique id of the receipt we are managing.
	 * @return [void]
	 */
    function __construct( $RECEIPT_ID=-1 ) 
    {
    
        $dbTableName = RowManager_ReceiptManager::DB_TABLE;
        $fieldList = RowManager_ReceiptManager::FIELD_LIST;
        $primaryKeyField = 'cctransaction_id';
        $primaryKeyValue = $RECEIPT_ID;
        
        if (( $RECEIPT_ID != -1 ) && ( $RECEIPT_ID != '' )) {
        
            $condition = $primaryKeyField . '=' . $primaryKeyValue;
            
        } else {
            $condition = '';
        }
        $xmlNodeName = RowManager_ReceiptManager::XML_NODE_NAME;
        parent::__construct( $dbTableName, $fieldList, $primaryKeyField, $primaryKeyValue, $condition, $xmlNodeName);
        
        $this->dbDescription = RowManager_ReceiptManager::DB_TABLE_DESCRIPTION;

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

    
    	
}

?>