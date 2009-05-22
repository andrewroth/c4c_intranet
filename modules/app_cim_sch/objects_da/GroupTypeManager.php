<?php
/**
 * @package cim_sch
 */ 
/**
 * class RowManager_GroupTypeManager
 * <pre> 
 * Contains the types of groups.
 * </pre>
 * @author Calvin Jien & Russ Martin
 */
class  RowManager_GroupTypeManager extends RowManager {

	//CONSTANTS:
	/** The name of the DB Table this class manages. */
    const DB_TABLE = 'cim_sch_grouptype';
    
    /** The SQL description of the DB Table this class manages. */
    /*
     * groupType_id [INTEGER]  ID of the group type
     * groupType_desc [STRING]  The description of the group type
     */
    const DB_TABLE_DESCRIPTION = " (
  groupType_id int(11) NOT NULL  auto_increment,
  groupType_desc varchar(20) NOT NULL  default '',
  PRIMARY KEY (groupType_id)
) TYPE=MyISAM";
    
    /** The fields in the DB Table this class manages. */
    const FIELD_LIST = 'groupType_id,groupType_desc';
    
    /** The XML node name for this entry. */
    const XML_NODE_NAME = 'grouptype';
    

	//VARIABLES:


	//CLASS CONSTRUCTOR
	//************************************************************************
	/**
	 * function __construct
	 * <pre>
	 * Initialize this object.
	 * </pre>
	 * @param $GROUPTYPE_ID [INTEGER] The unique id of the grouptype we are managing.
	 * @return [void]
	 */
    function __construct( $GROUPTYPE_ID=-1 ) 
    {
    
        $dbTableName = RowManager_GroupTypeManager::DB_TABLE;
        $fieldList = RowManager_GroupTypeManager::FIELD_LIST;
        $primaryKeyField = 'groupType_id';
        $primaryKeyValue = $GROUPTYPE_ID;
        
        if (( $GROUPTYPE_ID != -1 ) && ( $GROUPTYPE_ID != '' )) {
        
            $condition = $primaryKeyField . '=' . $primaryKeyValue;
            
        } else {
            $condition = '';
        }
        $xmlNodeName = RowManager_GroupTypeManager::XML_NODE_NAME;
        parent::__construct( $dbTableName, $fieldList, $primaryKeyField, $primaryKeyValue, $condition, $xmlNodeName);
        
        $this->dbDescription = RowManager_GroupTypeManager::DB_TABLE_DESCRIPTION;

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
        return "groupType_desc";
    }

    
    	
}

?>