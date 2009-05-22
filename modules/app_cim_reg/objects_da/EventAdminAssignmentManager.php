<?php
/**
 * @package cim_reg
 */ 
/**
 * class RowManager_EventAdminAssignmentManager
 * <pre> 
 * Assigns a particular privilege to a particular user for some event..
 * </pre>
 * @author Russ Martin
 */
class  RowManager_EventAdminAssignmentManager extends RowManager {

	//CONSTANTS:
	/** The name of the DB Table this class manages. */
    const DB_TABLE = 'cim_reg_eventadmin';
    
    /** The SQL description of the DB Table this class manages. */
    /*
     * eventadmin_id [INTEGER]  unique id for event administrator privilege assignment
     * event_id [INTEGER]  id for the event for which privileges are being assigned
     * priv_id [INTEGER]  ID for a particular event privilege
     * viewer_id [INTEGER]  ID associated with a particular system user
     */
    const DB_TABLE_DESCRIPTION = " (
  eventadmin_id int(10) NOT NULL  auto_increment,
  event_id int(10) NOT NULL  default '0',
  priv_id int(10) NOT NULL  default '0',
  viewer_id int(10) NOT NULL  default '0',
  PRIMARY KEY (eventadmin_id)
) TYPE=MyISAM";
    
    /** The fields in the DB Table this class manages. */
    const FIELD_LIST = 'eventadmin_id,event_id,priv_id,viewer_id';
    
    /** The XML node name for this entry. */
    const XML_NODE_NAME = 'eventadminassignment';
    

	//VARIABLES:


	//CLASS CONSTRUCTOR
	//************************************************************************
	/**
	 * function __construct
	 * <pre>
	 * Initialize this object.
	 * </pre>
	 * @param $EVENTADMIN_ID [INTEGER] The unique id of the eventadminassignment we are managing.
	 * @return [void]
	 */
    function __construct( $EVENTADMIN_ID=-1 ) 
    {
    
        $dbTableName = RowManager_EventAdminAssignmentManager::DB_TABLE;
        $fieldList = RowManager_EventAdminAssignmentManager::FIELD_LIST;
        $primaryKeyField = 'eventadmin_id';
        $primaryKeyValue = $EVENTADMIN_ID;
        
        if (( $EVENTADMIN_ID != -1 ) && ( $EVENTADMIN_ID != '' )) {
        
            $condition = $primaryKeyField . '=' . $primaryKeyValue;
            
        } else {
            $condition = '';
        }
        $xmlNodeName = RowManager_EventAdminAssignmentManager::XML_NODE_NAME;
        parent::__construct( $dbTableName, $fieldList, $primaryKeyField, $primaryKeyValue, $condition, $xmlNodeName);
        
        $this->dbDescription = RowManager_EventAdminAssignmentManager::DB_TABLE_DESCRIPTION;

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
	 * function setEventAdminID
	 * <pre>
	 * Set the event admin ID for event admin privilege assignment
	 * </pre>
	 *return [void]
	 * @param $eventAdminID		the event admin ID
	 */
    function setEventAdminID($eventAdminID) 
    {
        $this->setValueByFieldName('eventadmin_id',$eventAdminID);
    }    	
    	
    	
    	
    	
	/**
	 * function setEventID
	 * <pre>
	 * Set the event ID for viewer privilege assignment
	 * </pre>
	 *return [void]
	 * @param $eventID		the ID of the event
	 */
    function setEventID($eventID) 
    {
        $this->setValueByFieldName('event_id',$eventID);
        //return $this->getValueByFieldName( 'applicant_codename' );
    }
    
    
    /**
	 * function setViewerID
	 * <pre>
	 * Set the viewer ID for event admin privilege assignment
	 * </pre>
	 *return [void]
	 * @param $viewerID		the ID of the viewer
	 */
    function setViewerID($viewerID) 
    {
        $this->setValueByFieldName('viewer_id',$viewerID);
        //return $this->getValueByFieldName( 'applicant_codename' );
    }
    
    /**
	 * function setPrivilege
	 * <pre>
	 * Set the privilege as a filter
	 * </pre>
	 *return [void]
	 * @param $priv		the privilege level of the viewer
	 */
    function setPrivilege($priv) 
    {
        $this->setValueByFieldName('priv_id',$priv);
        //return $this->getValueByFieldName( 'applicant_codename' );
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
    
	/**
	 * function getJoinOnEventAdminID
	 * <pre>
	 * Returns the tableName+fieldName combo for an SQL to properly reference
	 * this table on an SQL JOIN operation.
	 * </pre>
	 * @return [STRING]
	 */
    function getJoinOnViewerID()
    {
        return $this->getTableName().'.viewer_id';
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
        return "viewer_id";
    }

    
    	/**
	 * function getPrivilege
	 * <pre>
	 * Returns the field to use in the label routines.
	 * </pre>
	 * @return [STRING]
	 */
    function getPrivilege() 
    {
        return $this->getValueByFieldName('priv_id');
    }
    

   //************************************************************************
	/**
	 * function loadByEventID
	 * <pre>
	 * loads an entry given a viewer id and event id.
	 * </pre>
	 * @param $viewerID [INTEGER] the ID of the viewer account
	 * @param $eventID [INTEGER] the ID of the event associated with admin privilege
	 * @param $priv [INTEGER] the constant indicating what privilege level access has been given
	 * @return [BOOL]
	 */
    function loadByEventIDandPriv( $viewerID, $eventID, $priv ) 
    {
        $condition = ' viewer_id='.$viewerID.' AND event_id='.$eventID.' AND priv_id='.$priv;
        
        return  $this->loadByCondition( $condition );
    }    	
}

?>