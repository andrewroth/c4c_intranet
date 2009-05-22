<?php
/**
 * @package cim_reg
 */ 
/**
 * class RowManager_FieldTypeManager
 * <pre> 
 * Manages field type information.
 * </pre>
 * @author Russ Martin
 */
class  RowManager_FieldTypeManager extends RowManager {

	//CONSTANTS:
	/** The name of the DB Table this class manages. */
    const DB_TABLE = 'cim_reg_fieldtypes';
    
    /** The SQL description of the DB Table this class manages. */
    /*
     * fieldtypes_id [INTEGER]  ID for field type
     * fieldtypes_desc [STRING]  Description of field type
     */
    const DB_TABLE_DESCRIPTION = " (
  fieldtypes_id int(10) NOT NULL  auto_increment,
  fieldtypes_desc varchar(128) NOT NULL  default '',
  PRIMARY KEY (fieldtypes_id)
) TYPE=MyISAM";
    
    /** The fields in the DB Table this class manages. */
    const FIELD_LIST = 'fieldtypes_id,fieldtypes_desc';
    
    /** The XML node name for this entry. */
    const XML_NODE_NAME = 'fieldtype';
    

	//VARIABLES:


	//CLASS CONSTRUCTOR
	//************************************************************************
	/**
	 * function __construct
	 * <pre>
	 * Initialize this object.
	 * </pre>
	 * @param $FIELDTYPE_ID [INTEGER] The unique id of the fieldtype we are managing.
	 * @return [void]
	 */
    function __construct( $FIELDTYPE_ID=-1 ) 
    {
    
        $dbTableName = RowManager_FieldTypeManager::DB_TABLE;
        $fieldList = RowManager_FieldTypeManager::FIELD_LIST;
        $primaryKeyField = 'fieldtypes_id';
        $primaryKeyValue = $FIELDTYPE_ID;
        
        if (( $FIELDTYPE_ID != -1 ) && ( $FIELDTYPE_ID != '' )) {
        
            $condition = $primaryKeyField . '=' . $primaryKeyValue;
            
        } else {
            $condition = '';
        }
        $xmlNodeName = RowManager_FieldTypeManager::XML_NODE_NAME;
        parent::__construct( $dbTableName, $fieldList, $primaryKeyField, $primaryKeyValue, $condition, $xmlNodeName);
        
        $this->dbDescription = RowManager_FieldTypeManager::DB_TABLE_DESCRIPTION;

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
	 * function getJoinOnFieldTypeID
	 * <pre>
	 * returns the field used as a join condition (fieldtype_id)
	 * </pre>
	 * @return [STRING]
	 */
    function getJoinOnFieldTypeID()
    {   
        return $this->getJoinOnFieldX('fieldtypes_id');
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
        return "fieldtypes_desc";
    }

    
    	
}

?>