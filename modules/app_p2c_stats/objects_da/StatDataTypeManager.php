<?php
/**
 * @package p2c_stats
 */ 
/**
 * class RowManager_StatDataTypeManager
 * <pre> 
 * Stores a data type for a statistic (i.e. 'numeric').
 * </pre>
 * @author Hobbe Smit (on behalf of CIM team)
 */
class  RowManager_StatDataTypeManager extends RowManager {

	//CONSTANTS:
	/** The name of the DB Table this class manages. */
    const DB_TABLE = 'p2c_stats_stattype';
    
    /** The SQL description of the DB Table this class manages. */
    /*
     * statistic_type_id [INTEGER]  unique id for the data type
     * statistic_type [STRING]  the statistic data type (i.e. 'numeric')
     */
    const DB_TABLE_DESCRIPTION = " (
  statistic_type_id int(4) NOT NULL  auto_increment,
  statistic_type varchar(32) NOT NULL  default '',
  PRIMARY KEY (statistic_type_id)
) TYPE=InnoDB";
    
    /** The fields in the DB Table this class manages. */
    const FIELD_LIST = 'statistic_type_id,statistic_type';
    
    /** The XML node name for this entry. */
    const XML_NODE_NAME = 'statdatatype';
    

	//VARIABLES:


	//CLASS CONSTRUCTOR
	//************************************************************************
	/**
	 * function __construct
	 * <pre>
	 * Initialize this object.
	 * </pre>
	 * @param $STATTYPE_ID [INTEGER] The unique id of the statdatatype we are managing.
	 * @return [void]
	 */
    function __construct( $STATTYPE_ID=-1 ) 
    {
    
        $dbTableName = RowManager_StatDataTypeManager::DB_TABLE;
        $fieldList = RowManager_StatDataTypeManager::FIELD_LIST;
        $primaryKeyField = 'statistic_type_id';
        $primaryKeyValue = $STATTYPE_ID;
        
        if (( $STATTYPE_ID != -1 ) && ( $STATTYPE_ID != '' )) {
        
            $condition = $primaryKeyField . '=' . $primaryKeyValue;
            
        } else {
            $condition = '';
        }
        $xmlNodeName = RowManager_StatDataTypeManager::XML_NODE_NAME;
        parent::__construct( $dbTableName, $fieldList, $primaryKeyField, $primaryKeyValue, $condition, $xmlNodeName);
        
        $this->dbDescription = RowManager_StatDataTypeManager::DB_TABLE_DESCRIPTION;

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
        return "statistic_type";
    }

    
    	
}

?>