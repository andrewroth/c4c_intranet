<?php
/**
 * @package cim_hrdb
 */ 
/**
 * class RowManager_CampusAssignmentStatusManager
 * <pre> 
 * The status of a person assigned to some campus..
 * </pre>
 * @author CIM Team
 */
class  RowManager_CampusAssignmentStatusManager extends RowManager {

	//CONSTANTS:
	/** The name of the DB Table this class manages. */
    const DB_TABLE = 'cim_hrdb_assignmentstatus';
    
    /** The SQL description of the DB Table this class manages. */
    /*
     * assignmentstatus_id [INTEGER]  unique identifier for a particular campus assignment status
     * assignmentstatus_desc [STRING]  Description of a particular campus assignment status
     */
    const DB_TABLE_DESCRIPTION = " (
  assignmentstatus_id int(10) NOT NULL  auto_increment,
  assignmentstatus_desc varchar(64) NOT NULL  default '',
  PRIMARY KEY (assignmentstatus_id)
) TYPE=MyISAM";
    
    /** The fields in the DB Table this class manages. */
    const FIELD_LIST = 'assignmentstatus_id,assignmentstatus_desc';
    
    /** The XML node name for this entry. */
    const XML_NODE_NAME = 'assignmentstatus';
    

	//VARIABLES:


	//CLASS CONSTRUCTOR
	//************************************************************************
	/**
	 * function __construct
	 * <pre>
	 * Initialize this object.
	 * </pre>
	 * @param $ASSIGNSTATUS_ID [INTEGER] The unique id of the campusassignmentstatus we are managing.
	 * @return [void]
	 */
    function __construct( $ASSIGNSTATUS_ID=-1 ) 
    {
    
        $dbTableName = RowManager_CampusAssignmentStatusManager::DB_TABLE;
        $fieldList = RowManager_CampusAssignmentStatusManager::FIELD_LIST;
        $primaryKeyField = 'assignmentstatus_id';
        $primaryKeyValue = $ASSIGNSTATUS_ID;
        
        if (( $ASSIGNSTATUS_ID != -1 ) && ( $ASSIGNSTATUS_ID != '' )) {
        
            $condition = $primaryKeyField . '=' . $primaryKeyValue;
            
        } else {
            $condition = '';
        }
        $xmlNodeName = RowManager_CampusAssignmentStatusManager::XML_NODE_NAME;
        parent::__construct( $dbTableName, $fieldList, $primaryKeyField, $primaryKeyValue, $condition, $xmlNodeName);
        
        $this->dbDescription = RowManager_CampusAssignmentStatusManager::DB_TABLE_DESCRIPTION;

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
	 * function getJoinOnStatusID
	 * <pre>
	 * returns the field used as a join condition for status_id
	 * </pre>
	 * @return [STRING]
	 */
    function getJoinOnStatusID()
    {   
        return $this->getJoinOnFieldX('assignmentstatus_id');
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
        return "assignmentstatus_desc";
    }

    
    	
}

?>