<?php
/**
 * @package cim_hrdb
 */ 
/**
 * class RowManager_FieldGroupManager
 * <pre> 
 * Object describing a group of fields.
 * </pre>
 * @author CIM Team
 */
class  RowManager_FieldGroupManager extends RowManager {

	//CONSTANTS:
	/** The name of the DB Table this class manages. */
    const DB_TABLE = 'cim_hrdb_fieldgroup';
    
    /** The SQL description of the DB Table this class manages. */
    /*
     * fieldgroup_id [INTEGER]  Unique id of a field group
     * fieldgroup_desc [STRING]  The field group description/label.
     */
    const DB_TABLE_DESCRIPTION = " (
  fieldgroup_id int(10) NOT NULL  auto_increment,
  fieldgroup_desc varchar(75) NOT NULL  default '',
  PRIMARY KEY (fieldgroup_id)
) TYPE=MyISAM";
    
    /** The fields in the DB Table this class manages. */
    const FIELD_LIST = 'fieldgroup_id,fieldgroup_desc';
    
    /** The XML node name for this entry. */
    const XML_NODE_NAME = 'fieldgroup';
    

	//VARIABLES:


	//CLASS CONSTRUCTOR
	//************************************************************************
	/**
	 * function __construct
	 * <pre>
	 * Initialize this object.
	 * </pre>
	 * @param $FIELDGROUP_ID [INTEGER] The unique id of the fieldgroup we are managing.
	 * @return [void]
	 */
    function __construct( $FIELDGROUP_ID=-1 ) 
    {
    
        $dbTableName = RowManager_FieldGroupManager::DB_TABLE;
        $fieldList = RowManager_FieldGroupManager::FIELD_LIST;
        $primaryKeyField = 'fieldgroup_id';
        $primaryKeyValue = $FIELDGROUP_ID;
        
        if (( $FIELDGROUP_ID != -1 ) && ( $FIELDGROUP_ID != '' )) {
        
            $condition = $primaryKeyField . '=' . $primaryKeyValue;
            
        } else {
            $condition = '';
        }
        $xmlNodeName = RowManager_FieldGroupManager::XML_NODE_NAME;
        parent::__construct( $dbTableName, $fieldList, $primaryKeyField, $primaryKeyValue, $condition, $xmlNodeName);
        
        $this->dbDescription = RowManager_FieldGroupManager::DB_TABLE_DESCRIPTION;

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
        return "fieldgroup_desc";
    }

    
    	
}

?>