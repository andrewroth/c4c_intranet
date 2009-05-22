<?php
/**
 * @package cim_reg
 */ 
/**
 * class RowManager_PrivilegeTypeManager
 * <pre> 
 * Manages the information pertaining to registration interface admin privilege types..
 * </pre>
 * @author Russ Martin
 */
class  RowManager_PrivilegeTypeManager extends RowManager {

	//CONSTANTS:
	/** The name of the DB Table this class manages. */
    const DB_TABLE = 'cim_reg_priv';
    
    /** The SQL description of the DB Table this class manages. */
    /*
     * priv_id [INTEGER]  Identifier for privilege
     * priv_desc [STRING]  Description of the privilege
     */
    const DB_TABLE_DESCRIPTION = " (
  priv_id int(10) NOT NULL  auto_increment,
  priv_desc varchar(64) NOT NULL  default '',
  PRIMARY KEY (priv_id)
) TYPE=MyISAM";
    
    /** The fields in the DB Table this class manages. */
    const FIELD_LIST = 'priv_id,priv_desc';
    
    /** The XML node name for this entry. */
    const XML_NODE_NAME = 'privilegetype';
    

	//VARIABLES:


	//CLASS CONSTRUCTOR
	//************************************************************************
	/**
	 * function __construct
	 * <pre>
	 * Initialize this object.
	 * </pre>
	 * @param $PRIV_ID [INTEGER] The unique id of the privilegetype we are managing.
	 * @return [void]
	 */
    function __construct( $PRIV_ID=-1 ) 
    {
    
        $dbTableName = RowManager_PrivilegeTypeManager::DB_TABLE;
        $fieldList = RowManager_PrivilegeTypeManager::FIELD_LIST;
        $primaryKeyField = 'priv_id';
        $primaryKeyValue = $PRIV_ID;
        
        if (( $PRIV_ID != -1 ) && ( $PRIV_ID != '' )) {
        
            $condition = $primaryKeyField . '=' . $primaryKeyValue;
            
        } else {
            $condition = '';
        }
        $xmlNodeName = RowManager_PrivilegeTypeManager::XML_NODE_NAME;
        parent::__construct( $dbTableName, $fieldList, $primaryKeyField, $primaryKeyValue, $condition, $xmlNodeName);
        
        $this->dbDescription = RowManager_PrivilegeTypeManager::DB_TABLE_DESCRIPTION;

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
	 * function getLabelField
	 * <pre>
	 * Returns the field to use in the label routines.
	 * </pre>
	 * @return [STRING]
	 */
    function getLabelField() 
    {
        return "priv_desc";
    }

    
    	
}

?>