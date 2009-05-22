<?php
/**
 * @package cim_hrdb
 */ 
/**
 * class RowManager_ProvinceManager
 * <pre> 
 * Manages provinces.
 * </pre>
 * @author CIM Team
 */
class  RowManager_ProvinceManager extends RowManager {

	//CONSTANTS:
	/** The name of the DB Table this class manages. */
    const DB_TABLE = 'cim_hrdb_province';
    
    /** The SQL description of the DB Table this class manages. */
    /*
     * province_id [INTEGER]  id of a province
     * province_desc [STRING]  Textual name of a province
     * province_shortDesc [STRING]  Short form of a province's name
     */
    const DB_TABLE_DESCRIPTION = " (
  province_id int() NOT NULL  auto_increment,
  province_desc varchar() NOT NULL  default '',
  province_shortDesc varchar() NOT NULL  default '',
  PRIMARY KEY (province_id)
) TYPE=MyISAM";
    
    /** The fields in the DB Table this class manages. */
    const FIELD_LIST = 'province_id,province_desc,province_shortDesc';
    
    /** The XML node name for this entry. */
    const XML_NODE_NAME = 'province';
    

	//VARIABLES:


	//CLASS CONSTRUCTOR
	//************************************************************************
	/**
	 * function __construct
	 * <pre>
	 * Initialize this object.
	 * </pre>
	 * @param $PROVINCE_ID [INTEGER] The unique id of the province we are managing.
	 * @return [void]
	 */
    function __construct( $PROVINCE_ID=-1) 
    {
    
        $dbTableName = RowManager_ProvinceManager::DB_TABLE;
        $fieldList = RowManager_ProvinceManager::FIELD_LIST;
        $primaryKeyField = 'province_id';
        $primaryKeyValue = $PROVINCE_ID;
        
        if (( $PROVINCE_ID != -1 ) && ( $PROVINCE_ID != '' )) {
        
            $condition = $primaryKeyField . '=' . $primaryKeyValue;
            
        } else {
            $condition = '';
        }
        $xmlNodeName = RowManager_ProvinceManager::XML_NODE_NAME;
        parent::__construct( $dbTableName, $fieldList, $primaryKeyField, $primaryKeyValue, $condition, $xmlNodeName);
        
        $this->dbDescription = RowManager_ProvinceManager::DB_TABLE_DESCRIPTION;

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
	 * function getJoinOnProvinceID
	 * <pre>
	 * returns the field used as a join condition for province_id
	 * </pre>
	 * @return [STRING]
	 */
    function getJoinOnProvinceID()
    {   
        return $this->getJoinOnFieldX('province_id');
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
        return 'province_shortDesc';
    }

    
    	
}

?>