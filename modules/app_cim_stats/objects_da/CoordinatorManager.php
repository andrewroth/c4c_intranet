<?php
/**
 * @package cim_stats
 */ 
/**
 * class RowManager_CoordinatorManager
 * <pre> 
 * manages which staff have what access to which campuses.
 * </pre>
 * @author Russ Martin
 */
class  RowManager_CoordinatorManager extends RowManager {

	//CONSTANTS:
	/** The name of the DB Table this class manages. */
    const DB_TABLE = 'cim_stats_coordinator';
    
    /** The SQL description of the DB Table this class manages. */
    /*
     * coordinator_id [INTEGER]  unique id
     * access_id [INTEGER]  the access_id of a staff member
     * campus_id [INTEGER]  a campus to which this coordinator is assigned
     */
    const DB_TABLE_DESCRIPTION = " (
  coordinator_id int(16) NOT NULL  auto_increment,
  access_id int(16) NOT NULL  default '0',
  campus_id int(16) NOT NULL  default '0',
  PRIMARY KEY (coordinator_id)
) TYPE=MyISAM";
    
    /** The fields in the DB Table this class manages. */
    const FIELD_LIST = 'coordinator_id,access_id,campus_id';
    
    /** The XML node name for this entry. */
    const XML_NODE_NAME = 'coordinator';
    

	//VARIABLES:


	//CLASS CONSTRUCTOR
	//************************************************************************
	/**
	 * function __construct
	 * <pre>
	 * Initialize this object.
	 * </pre>
	 * @param $COORDINATOR_ID [INTEGER] The unique id of the coordinator we are managing.
	 * @return [void]
	 */
    function __construct( $COORDINATOR_ID=-1 ) 
    {
    
        $dbTableName = RowManager_CoordinatorManager::DB_TABLE;
        $fieldList = RowManager_CoordinatorManager::FIELD_LIST;
        $primaryKeyField = 'coordinator_id';
        $primaryKeyValue = $COORDINATOR_ID;
        
        if (( $COORDINATOR_ID != -1 ) && ( $COORDINATOR_ID != '' )) {
        
            $condition = $primaryKeyField . '=' . $primaryKeyValue;
            
        } else {
            $condition = '';
        }
        $xmlNodeName = RowManager_CoordinatorManager::XML_NODE_NAME;
        parent::__construct( $dbTableName, $fieldList, $primaryKeyField, $primaryKeyValue, $condition, $xmlNodeName);
        
        $this->dbDescription = RowManager_CoordinatorManager::DB_TABLE_DESCRIPTION;

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