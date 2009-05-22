<?php
/**
 * @package cim_hrdb
 */ 
/**
 * class RowManager_ViewerToPersonAssignmentManager
 * <pre> 
 * Assigns user/viewer privileges to a user.
Privilege level depends on that given to viewer record..
 * </pre>
 * @author CIM Team
 */
class  RowManager_ViewerToPersonAssignmentManager extends RowManager {

	//CONSTANTS:
	/** The name of the DB Table this class manages. */
    const DB_TABLE = 'cim_hrdb_viewertopersonassignment';
    
    /** The SQL description of the DB Table this class manages. */
    /*
     * access_id [INTEGER]  Unique id of person-to-viewer assignment
     * viewer_id [INTEGER]  Unique id of some viewer/user record used to store login information
     * person_id [INTEGER]  Unique identifier for some person record
     */
    const DB_TABLE_DESCRIPTION = " (
  access_id int(50) NOT NULL  auto_increment,
  viewer_id int(50) NOT NULL  default '0',
  person_id int(50) NOT NULL  default '0',
  PRIMARY KEY (access_id)
) TYPE=MyISAM";
    
    /** The fields in the DB Table this class manages. */
    const FIELD_LIST = 'access_id,viewer_id,person_id';
    
    /** The XML node name for this entry. */
    const XML_NODE_NAME = 'viewertopersonassignment';
    

	//VARIABLES:


	//CLASS CONSTRUCTOR
	//************************************************************************
	/**
	 * function __construct
	 * <pre>
	 * Initialize this object.
	 * </pre>
	 * @param $ACCESS_ID [INTEGER] The unique id of the viewertopersonassignment we are managing.
	 * @return [void]
	 */
    function __construct( $ACCESS_ID=-1 ) 
    {
    
        $dbTableName = RowManager_ViewerToPersonAssignmentManager::DB_TABLE;
        $fieldList = RowManager_ViewerToPersonAssignmentManager::FIELD_LIST;
        $primaryKeyField = 'access_id';
        $primaryKeyValue = $ACCESS_ID;
        
        if (( $ACCESS_ID != -1 ) && ( $ACCESS_ID != '' )) {
        
            $condition = $primaryKeyField . '=' . $primaryKeyValue;
            
        } else {
            $condition = '';
        }
        $xmlNodeName = RowManager_ViewerToPersonAssignmentManager::XML_NODE_NAME;
        parent::__construct( $dbTableName, $fieldList, $primaryKeyField, $primaryKeyValue, $condition, $xmlNodeName);
        
        $this->dbDescription = RowManager_ViewerToPersonAssignmentManager::DB_TABLE_DESCRIPTION;

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