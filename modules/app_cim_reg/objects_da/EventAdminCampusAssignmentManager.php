<?php
/**
 * @package cim_reg
 */ 
/**
 * class RowManager_EventAdminCampusAssignmentManager
 * <pre> 
 * Assigns the event admin privileges of some user to a particular campus..
 * </pre>
 * @author Russ Martin
 */
class  RowManager_EventAdminCampusAssignmentManager extends RowManager {

	//CONSTANTS:
	/** The name of the DB Table this class manages. */
    const DB_TABLE = 'cim_reg_campusaccess';
    
    /** The SQL description of the DB Table this class manages. */
    /*
     * campusaccess_id [INTEGER]  Identifier for a particular campus assignment to some event admin
     * eventadmin_id [INTEGER]  Identifier of the event admin who will be assigned a campus
     * campus_id [INTEGER]  The unique identifier that describes a particular university campus
     */
    const DB_TABLE_DESCRIPTION = " (
  campusaccess_id int(10) NOT NULL  auto_increment,
  eventadmin_id int(10) NOT NULL  default '0',
  campus_id int(10) NOT NULL  default '0',
  PRIMARY KEY (campusaccess_id)
) TYPE=MyISAM";
    
    /** The fields in the DB Table this class manages. */
    const FIELD_LIST = 'campusaccess_id,eventadmin_id,campus_id';
    
    /** The XML node name for this entry. */
    const XML_NODE_NAME = 'eventadmincampusassignment';
    

	//VARIABLES:


	//CLASS CONSTRUCTOR
	//************************************************************************
	/**
	 * function __construct
	 * <pre>
	 * Initialize this object.
	 * </pre>
	 * @param $CAMPUSACCESS_ID [INTEGER] The unique id of the eventadmincampusassignment we are managing.
	 * @return [void]
	 */
    function __construct( $CAMPUSACCESS_ID=-1 ) 
    {
    
        $dbTableName = RowManager_EventAdminCampusAssignmentManager::DB_TABLE;
        $fieldList = RowManager_EventAdminCampusAssignmentManager::FIELD_LIST;
        $primaryKeyField = 'campusaccess_id';
        $primaryKeyValue = $CAMPUSACCESS_ID;
        
        if (( $CAMPUSACCESS_ID != -1 ) && ( $CAMPUSACCESS_ID != '' )) {
        
            $condition = $primaryKeyField . '=' . $primaryKeyValue;
            
        } else {
            $condition = '';
        }
        $xmlNodeName = RowManager_EventAdminCampusAssignmentManager::XML_NODE_NAME;
        parent::__construct( $dbTableName, $fieldList, $primaryKeyField, $primaryKeyValue, $condition, $xmlNodeName);
        
        $this->dbDescription = RowManager_EventAdminCampusAssignmentManager::DB_TABLE_DESCRIPTION;

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
	 * function setEventAdminID
	 * <pre>
	 * Set the event admin ID for event admin campus assignment
	 * </pre>
	 *return [void]
	 * @param $eventAdminID		the event admin ID
	 */
    function setEventAdminID($eventAdminID) 
    {
        $this->setValueByFieldName('eventadmin_id',$eventAdminID);
    }    
       
    
	/**
	 * function getJoinOnEventAdminID
	 * <pre>
	 * Returns the tableName+fieldName combo for an SQL to properly reference
	 * this table on an SQL JOIN operation.
	 * </pre>
	 * @return [STRING]
	 */
    function getJoinOnEventAdminID()
    {
        return $this->getTableName().'.eventadmin_id';
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