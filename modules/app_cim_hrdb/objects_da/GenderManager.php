<?php
/**
 * @package cim_hrdb
 */ 
/**
 * class RowManager_GenderManager
 * <pre> 
 * Manages the gender table..
 * </pre>
 * @author CIM Team
 */
class  RowManager_GenderManager extends RowManager {

	//CONSTANTS:
	/** The name of the DB Table this class manages. */
    const DB_TABLE = 'cim_hrdb_gender';
    
    const MALE = 1;
    const FEMALE = 2;
    const UNKNOWN = 3;
    
    /** The SQL description of the DB Table this class manages. */
    /*
     * gender_id [INTEGER]  The id of the gender.
     * gender_desc [STRING]  The is the gender type.
     */
    const DB_TABLE_DESCRIPTION = " (
  gender_id int(1) NOT NULL  auto_increment,
  gender_desc varchar(50) NOT NULL  default '',
  PRIMARY KEY (gender_id)
) TYPE=MyISAM";
    
    /** The fields in the DB Table this class manages. */
    const FIELD_LIST = 'gender_id,gender_desc';
    
    /** The XML node name for this entry. */
    const XML_NODE_NAME = 'gender';
    

	//VARIABLES:


	//CLASS CONSTRUCTOR
	//************************************************************************
	/**
	 * function __construct
	 * <pre>
	 * Initialize this object.
	 * </pre>
	 * @param $GENDER_ID [INTEGER] The unique id of the gender we are managing.
	 * @return [void]
	 */
    function __construct( $GENDER_ID=-1 ) 
    {
    
        $dbTableName = RowManager_GenderManager::DB_TABLE;
        $fieldList = RowManager_GenderManager::FIELD_LIST;
        $primaryKeyField = 'gender_id';
        $primaryKeyValue = $GENDER_ID;
        
        if (( $GENDER_ID != -1 ) && ( $GENDER_ID != '' )) {
        
            $condition = $primaryKeyField . '=' . $primaryKeyValue;
            
        } else {
            $condition = '';
        }
        $xmlNodeName = RowManager_GenderManager::XML_NODE_NAME;
        parent::__construct( $dbTableName, $fieldList, $primaryKeyField, $primaryKeyValue, $condition, $xmlNodeName);
        
        $this->dbDescription = RowManager_GenderManager::DB_TABLE_DESCRIPTION;

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
	 * function getJoinOnGenderID
	 * <pre>
	 * returns the field used as a join condition for gender_id
	 * </pre>
	 * @return [STRING]
	 */
    function getJoinOnGenderID()
    {   
        return $this->getJoinOnFieldX('gender_id');
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
        return 'gender_desc';
    }

    
    	
}

?>