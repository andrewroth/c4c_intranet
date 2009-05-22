<?php
/**
 * @package cim_hrdb
 */ 
/**
 * class RowManager_FieldGroup_MatchesManager
 * <pre> 
 * An object that matches a field group with some (repeatable form) field.
 * </pre>
 * @author CIM Team
 */
class  RowManager_FieldGroup_MatchesManager extends RowManager {

	//CONSTANTS:
	/** The name of the DB Table this class manages. */
    const DB_TABLE = 'cim_hrdb_fieldgroup_matches';
    
    /** The SQL description of the DB Table this class manages. */
    /*
     * fieldgroup_matches_id [INTEGER]  The unique id of the matching
     * fieldgroup_id [INTEGER]  the id of the field group being matched
     * fields_id [INTEGER]  the id of the field being matched to a fieldgroup
     */
    const DB_TABLE_DESCRIPTION = " (
  fieldgroup_matches_id int(20) NOT NULL  auto_increment,
  fieldgroup_id int(10) NOT NULL  default '0',
  fields_id int(16) NOT NULL  default '0',
  PRIMARY KEY (fieldgroup_matches_id)
) TYPE=MyISAM";
    
    /** The fields in the DB Table this class manages. */
    const FIELD_LIST = 'fieldgroup_matches_id,fieldgroup_id,fields_id';
    
    /** The XML node name for this entry. */
    const XML_NODE_NAME = 'fieldgroup_matches';
    

	//VARIABLES:


	//CLASS CONSTRUCTOR
	//************************************************************************
	/**
	 * function __construct
	 * <pre>
	 * Initialize this object.
	 * </pre>
	 * @param $FIELDGROUP_MATCHES_ID [INTEGER] The unique id of the fieldgroup_matches we are managing.
	 * @return [void]
	 */
    function __construct( $FIELDGROUP_MATCHES_ID=-1 ) 
    {
    
        $dbTableName = RowManager_FieldGroup_MatchesManager::DB_TABLE;
        $fieldList = RowManager_FieldGroup_MatchesManager::FIELD_LIST;
        $primaryKeyField = 'fieldgroup_matches_id';
        $primaryKeyValue = $FIELDGROUP_MATCHES_ID;
        
        if (( $FIELDGROUP_MATCHES_ID != -1 ) && ( $FIELDGROUP_MATCHES_ID != '' )) {
        
            $condition = $primaryKeyField . '=' . $primaryKeyValue;
            
        } else {
            $condition = '';
        }
        $xmlNodeName = RowManager_FieldGroup_MatchesManager::XML_NODE_NAME;
        parent::__construct( $dbTableName, $fieldList, $primaryKeyField, $primaryKeyValue, $condition, $xmlNodeName);
        
        $this->dbDescription = RowManager_FieldGroup_MatchesManager::DB_TABLE_DESCRIPTION;

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