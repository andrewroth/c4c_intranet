<?php
/**
 * @package cim_reg
 */ 
/**
 * class RowManager_StatusManager
 * <pre> 
 * Used to describe what state a particular registration is in (unassigned, registered, cancelled, etc.).
 * </pre>
 * @author Russ Martin
 */
class  RowManager_StatusManager extends RowManager {

	//CONSTANTS:
	/** The name of the DB Table this class manages. */
    const DB_TABLE = 'cim_reg_status';
    
    /** The SQL description of the DB Table this class manages. */
    /*
     * status_id [INTEGER]  Unique identifier of a particular registration status description
     * status_desc [STRING]  Description of some registration status
     */
    const DB_TABLE_DESCRIPTION = " (
  status_id int(10) NOT NULL,			// HSMIT:  Jan 18, 2008  Removed auto_increment due to DB replication problems
  status_desc varchar(32) NOT NULL  default '',
  PRIMARY KEY (status_id)
) TYPE=MyISAM";
    
    /** The fields in the DB Table this class manages. */
    const FIELD_LIST = 'status_id,status_desc';
    
    /** The XML node name for this entry. */
    const XML_NODE_NAME = 'status';
    
    const REGISTERED = 'Registered';
    const INCOMPLETE = 'Incomplete';
    const CANCELLED = 'Cancelled';
    const UNASSIGNED = 'Unassigned';

	//VARIABLES:


	//CLASS CONSTRUCTOR
	//************************************************************************
	/**
	 * function __construct
	 * <pre>
	 * Initialize this object.
	 * </pre>
	 * @param $STATUS_ID [INTEGER] The unique id of the status we are managing.
	 * @return [void]
	 */
    function __construct( $STATUS_ID=-1 ) 
    {
    
        $dbTableName = RowManager_StatusManager::DB_TABLE;
        $fieldList = RowManager_StatusManager::FIELD_LIST;
        $primaryKeyField = 'status_id';
        $primaryKeyValue = $STATUS_ID;
        
        if (( $STATUS_ID != -1 ) && ( $STATUS_ID != '' )) {
        
            $condition = $primaryKeyField . '=' . $primaryKeyValue;
            
        } else {
            $condition = '';
        }
        $xmlNodeName = RowManager_StatusManager::XML_NODE_NAME;
        parent::__construct( $dbTableName, $fieldList, $primaryKeyField, $primaryKeyValue, $condition, $xmlNodeName);
        
        $this->dbDescription = RowManager_StatusManager::DB_TABLE_DESCRIPTION;

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
	 * function setStatusDesc
	 * <pre>
	 * Set the status description
	 * </pre>
	 *return [void]
	 * @param $statusDesc		the description of the reg. status
	 */
    function setStatusDesc($statusDesc) 
    {
        $this->setValueByFieldName('status_desc',$statusDesc);
    }     
    
    /**
	 * function setStatusID
	 * <pre>
	 * Set the status ID 
	 * </pre>
	 *return [void]
	 * @param $statusID		the ID of the status
	 */
    function setRegID($statusID) 
    {
        $this->setValueByFieldName('status_id',$statusID);
    }     
    
   /**
	 * function getJoinOnStatusID
	 * <pre>
	 * returns the field used as a join condition for status ID
	 * </pre>
	 * @return [STRING]
	 */
    function getJoinOnStatusID()
    {   
        return $this->getJoinOnFieldX('status_id');
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
        return "status_desc";
    }

    
    	
}

?>