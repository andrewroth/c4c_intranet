<?php
/**
 * @package cim_stats
 */ 
/**
 * class RowManager_AccessManager
 * <pre> 
 * Where staff members are assigned priviledges.
 * </pre>
 * @author Russ Martin
 */
class  RowManager_AccessManager extends RowManager {

	//CONSTANTS:
	/** The name of the DB Table this class manages. */
    const DB_TABLE = 'cim_stats_access';
    
    /** The SQL description of the DB Table this class manages. */
    /*
     * access_id [INTEGER]  unique id
     * staff_id [INTEGER]  staff id
     * priv_id [INTEGER]  priviledge id
     */
    const DB_TABLE_DESCRIPTION = " (
  access_id int(16) NOT NULL  auto_increment,
  staff_id int(16) NOT NULL  default '0',
  priv_id int(16) NOT NULL  default '0',
  PRIMARY KEY (access_id)
) TYPE=MyISAM";
    
    /** The fields in the DB Table this class manages. */
    const FIELD_LIST = 'access_id,staff_id,priv_id';
    
    /** The XML node name for this entry. */
    const XML_NODE_NAME = 'access';
    

	//VARIABLES:


	//CLASS CONSTRUCTOR
	//************************************************************************
	/**
	 * function __construct
	 * <pre>
	 * Initialize this object.
	 * </pre>
	 * @param $ACCESS_ID [INTEGER] The unique id of the access we are managing.
	 * @return [void]
	 */
    function __construct( $ACCESS_ID=-1 ) 
    {
    
        $dbTableName = RowManager_AccessManager::DB_TABLE;
        $fieldList = RowManager_AccessManager::FIELD_LIST;
        $primaryKeyField = 'access_id';
        $primaryKeyValue = $ACCESS_ID;
        
        if (( $ACCESS_ID != -1 ) && ( $ACCESS_ID != '' )) {
        
            $condition = $primaryKeyField . '=' . $primaryKeyValue;
            
        } else {
            $condition = '';
        }
        $xmlNodeName = RowManager_AccessManager::XML_NODE_NAME;
        parent::__construct( $dbTableName, $fieldList, $primaryKeyField, $primaryKeyValue, $condition, $xmlNodeName);
        
        $this->dbDescription = RowManager_AccessManager::DB_TABLE_DESCRIPTION;

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
        return "No Field Label Marked";
    }

    
    	
}

?>