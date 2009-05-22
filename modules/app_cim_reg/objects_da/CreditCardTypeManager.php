<?php
/**
 * @package cim_reg
 */ 
/**
 * class RowManager_CreditCardTypeManager
 * <pre> 
 * Manages credit card type information.
 * </pre>
 * @author Russ Martin
 */
class  RowManager_CreditCardTypeManager extends RowManager {

	//CONSTANTS:
	/** The name of the DB Table this class manages. */
    const DB_TABLE = 'cim_reg_cctype';
    
    /** The SQL description of the DB Table this class manages. */
    /*
     * cctype_id [INTEGER]  Identifier for credit card type
     * cctype_desc [STRING]  Description of the credit card type
     */
    const DB_TABLE_DESCRIPTION = " (
  cctype_id int(10) NOT NULL  auto_increment,
  cctype_desc varchar(32) NOT NULL  default '',
  PRIMARY KEY (cctype_id)
) TYPE=MyISAM";
    
    /** The fields in the DB Table this class manages. */
    const FIELD_LIST = 'cctype_id,cctype_desc';
    
    /** The XML node name for this entry. */
    const XML_NODE_NAME = 'creditcardtype';
    

	//VARIABLES:


	//CLASS CONSTRUCTOR
	//************************************************************************
	/**
	 * function __construct
	 * <pre>
	 * Initialize this object.
	 * </pre>
	 * @param $CCTYPE_ID [INTEGER] The unique id of the creditcardtype we are managing.
	 * @return [void]
	 */
    function __construct( $CCTYPE_ID=-1 ) 
    {
    
        $dbTableName = RowManager_CreditCardTypeManager::DB_TABLE;
        $fieldList = RowManager_CreditCardTypeManager::FIELD_LIST;
        $primaryKeyField = 'cctype_id';
        $primaryKeyValue = $CCTYPE_ID;
        
        if (( $CCTYPE_ID != -1 ) && ( $CCTYPE_ID != '' )) {
        
            $condition = $primaryKeyField . '=' . $primaryKeyValue;
            
        } else {
            $condition = '';
        }
        $xmlNodeName = RowManager_CreditCardTypeManager::XML_NODE_NAME;
        parent::__construct( $dbTableName, $fieldList, $primaryKeyField, $primaryKeyValue, $condition, $xmlNodeName);
        
        $this->dbDescription = RowManager_CreditCardTypeManager::DB_TABLE_DESCRIPTION;

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
        return "cctype_desc";
    }

    
    	
}

?>