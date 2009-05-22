<?php
/**
 * @package cim_reg
 */ 
/**
 * class RowManager_DataTypeManager
 * <pre> 
 * Stores some data type used for form fields, etc. Example: Number.
 * </pre>
 * @author Russ Martin
 */
class  RowManager_DataTypeManager extends RowManager {

	//CONSTANTS:
	/** The name of the DB Table this class manages. */
    const DB_TABLE = 'cim_reg_datatypes';
    
    /** The SQL description of the DB Table this class manages. */
    /*
     * datatypes_id [INTEGER]  A unique identifier for the data type
     * datatypes_key [STRING]  A unique abbreviation for the data type (i.e. 'N' for 'Number')
     * datatypes_desc [STRING]  A description of the data type.
     */
    const DB_TABLE_DESCRIPTION = " (
  datatypes_id int(4) NOT NULL  auto_increment,
  datatypes_key varchar(8) NOT NULL  default '',
  datatypes_desc varchar(64) NOT NULL  default '',
  PRIMARY KEY (datatypes_id)
) TYPE=MyISAM";
    
    /** The fields in the DB Table this class manages. */
    const FIELD_LIST = 'datatypes_id,datatypes_key,datatypes_desc';
    
    /** The XML node name for this entry. */
    const XML_NODE_NAME = 'datatype';
    

	//VARIABLES:


	//CLASS CONSTRUCTOR
	//************************************************************************
	/**
	 * function __construct
	 * <pre>
	 * Initialize this object.
	 * </pre>
	 * @param $DATATYPE_ID [INTEGER] The unique id of the datatype we are managing.
	 * @return [void]
	 */
    function __construct( $DATATYPE_ID=-1 ) 
    {
    
        $dbTableName = RowManager_DataTypeManager::DB_TABLE;
        $fieldList = RowManager_DataTypeManager::FIELD_LIST;
        $primaryKeyField = 'datatypes_id';
        $primaryKeyValue = $DATATYPE_ID;
        
        if (( $DATATYPE_ID != -1 ) && ( $DATATYPE_ID != '' )) {
        
            $condition = $primaryKeyField . '=' . $primaryKeyValue;
            
        } else {
            $condition = '';
        }
        $xmlNodeName = RowManager_DataTypeManager::XML_NODE_NAME;
        parent::__construct( $dbTableName, $fieldList, $primaryKeyField, $primaryKeyValue, $condition, $xmlNodeName);
        
        $this->dbDescription = RowManager_DataTypeManager::DB_TABLE_DESCRIPTION;

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
        return "datatypes_desc";
    }

    
    	
}

?>