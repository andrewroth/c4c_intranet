<?php
/**
 * @package cim_hrdb
 */ 
/**
 * class RowManager_PrivManager
 * <pre> 
 * Manager for the Privileges table..
 * </pre>
 * @author CIM Team
 */
class  RowManager_PrivManager extends RowManager {

	//CONSTANTS:
	/** The name of the DB Table this class manages. */
    const DB_TABLE = 'cim_hrdb_priv';
    
    /** The SQL description of the DB Table this class manages. */
    /*
     * priv_id [INTEGER]  The id for the privilege
     * priv_accesslevel [STRING]  The access level associated with the ID.
     */
    const DB_TABLE_DESCRIPTION = " (
  priv_id int(20) NOT NULL  auto_increment,
  priv_accesslevel varchar(100) NOT NULL  default '',
  PRIMARY KEY (priv_id)
) TYPE=MyISAM";
    
    /** The fields in the DB Table this class manages. */
    const FIELD_LIST = 'priv_id,priv_accesslevel';
    
    /** The XML node name for this entry. */
    const XML_NODE_NAME = 'priv';
    

	//VARIABLES:


	//CLASS CONSTRUCTOR
	//************************************************************************
	/**
	 * function __construct
	 * <pre>
	 * Initialize this object.
	 * </pre>
	 * @param $PRIV_ID [INTEGER] The unique id of the priv we are managing.
	 * @return [void]
	 */
    function __construct( $PRIV_ID=-1 ) 
    {
    
        $dbTableName = RowManager_PrivManager::DB_TABLE;
        $fieldList = RowManager_PrivManager::FIELD_LIST;
        $primaryKeyField = 'priv_id';
        $primaryKeyValue = $PRIV_ID;
        
        if (( $PRIV_ID != -1 ) && ( $PRIV_ID != '' )) {
        
            $condition = $primaryKeyField . '=' . $primaryKeyValue;
            
        } else {
            $condition = '';
        }
        $xmlNodeName = RowManager_PrivManager::XML_NODE_NAME;
        parent::__construct( $dbTableName, $fieldList, $primaryKeyField, $primaryKeyValue, $condition, $xmlNodeName);
        
        $this->dbDescription = RowManager_PrivManager::DB_TABLE_DESCRIPTION;

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
        return 'priv_accesslevel';
    }

    
    	
}

?>