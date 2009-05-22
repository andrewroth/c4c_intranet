<?php
/**
 * @package cim_sch
 */ 
/**
 * class RowManager_CampusGroupManager
 * <pre> 
 * Stores the relationships between the group and campus.
 * </pre>
 * @author Calvin Jien & Russ Martin
 */
class  RowManager_CampusGroupManager extends RowManager {

	//CONSTANTS:
	/** The name of the DB Table this class manages. */
    const DB_TABLE = 'cim_sch_campusgroup';
    
    /** The SQL description of the DB Table this class manages. */
    /*
     * campusgroup_id [INTEGER]  ID of campus group
     * group_id [INTEGER]  ID of a group
     * campus_id [INTEGER]  ID of a campus
     */
    const DB_TABLE_DESCRIPTION = " (
  campusgroup_id int(11) NOT NULL  auto_increment,
  group_id int(11) NOT NULL  default '0',
  campus_id int(11) NOT NULL  default '0',
  PRIMARY KEY (campusgroup_id)
) TYPE=MyISAM";
    
    /** The fields in the DB Table this class manages. */
    const FIELD_LIST = 'campusgroup_id,group_id,campus_id';
    
    /** The XML node name for this entry. */
    const XML_NODE_NAME = 'campusgroup';
    
	/** @var [OBJECT] The viewer object. */
	protected $viewer;
	
    

	//VARIABLES:


	//CLASS CONSTRUCTOR
	//************************************************************************
	/**
	 * function __construct
	 * <pre>
	 * Initialize this object.
	 * </pre>
	 * @param $CAMPUSGROUP_ID [INTEGER] The unique id of the campusgroup we are managing.
	 * @return [void]
	 */
    function __construct( $CAMPUSGROUP_ID=-1) 
    {

        $dbTableName = RowManager_CampusGroupManager::DB_TABLE;
        $fieldList = RowManager_CampusGroupManager::FIELD_LIST;
        $primaryKeyField = 'campusgroup_id';
        $primaryKeyValue = $CAMPUSGROUP_ID;
        
        if (( $CAMPUSGROUP_ID != -1 ) && ( $CAMPUSGROUP_ID != '' )) {
        
            $condition = $primaryKeyField . '=' . $primaryKeyValue;
            
        } else {
            $condition = '';
        }
        $xmlNodeName = RowManager_CampusGroupManager::XML_NODE_NAME;
        parent::__construct( $dbTableName, $fieldList, $primaryKeyField, $primaryKeyValue, $condition, $xmlNodeName);
        
        $this->dbDescription = RowManager_CampusGroupManager::DB_TABLE_DESCRIPTION;

    }
    
    // $campusAssignments
    //      key - arbitrary
    //      value - campus_id
	/**
	 * function setCampuses
	 * <pre>
	 * given an array of campuses, find all the groups for those campuses
	 * </pre>
	 * @return [void]
	 */
    function setCampuses( $campusAssignments )
    {
        $conditionArray = array();
        foreach( $campusAssignments as $key=>$campusID )
        {
            $conditionArray[] = "campus_id=".$campusID;
        }

        $monsterCondition = $this->constructSearchConditionFromArray( $conditionArray, OP_OR, true );
        $this->setDBCondition($monsterCondition);
        return;
    }
 	
    //Had problem creating the search conditions from page_ViewGroups, 
    //this was created to set the appropriate search conditions.
	/**
	 * function setCampuses
	 * <pre>
	 * ?
	 * </pre>
	 * @return [BOOLEAN]
	 */
    function returnSearchCondition( $campusAssignments, $viewerID )
    {
        $conditionArray = array();
        foreach( $campusAssignments as $key=>$campusID )
        {
            $conditionArray[] = "campus_id=".$campusID;
        }
        
        //This ViewerID is to check for groups admin from page_viewGroups in cim_sch
        $conditionArray[] = "viewer_id=".$viewerID;
        $monsterCondition = $this->constructSearchConditionFromArray( $conditionArray, OP_OR, true );
        return $monsterCondition;
    }

    /**
	 * function setGroups
	 * <pre>
	 * sets groups
	 * </pre>
	 * @return [void]
	 */
    function setGroups( $groupsAssignments )
    {
        $conditionArray2 = array();
        foreach( $groupsAssignments as $key=>$groupID )
        {
            $conditionArray2[] = "group_id=".$groupID;
        }
        
        $this->constructSearchConditionFromArray( $conditionArray2, OP_OR, true );
        return;
    }
    /**
	 * function loadByCampusID
	 * <pre>
	 * returns load by condition function result
	 * </pre>
	 * @return [STRING]
	 */
    function loadByCampusID( $campusID )
    {
        $condition = 'campus_id='.$campusID;
        return $this->loadByCondition( $condition );
    }
    /**
	 * function set Campus ID
	 * <pre>
	 * sets the campus ID
	 * </pre>
	 * @return [void]
	 */
    function setCampusID( $campusID )
    {
        $this->setValueByFieldName( 'campus_id', $campusID );
    }
    /**
	 * function setGroupID
	 * <pre>
	 * sets the group ID
	 * </pre>
	 * @return [void]
	 */
    function setGroupID( $groupID )
    {
        $this->setValueByFieldName( 'group_id', $groupID );
    }
    /**
	 * function getJoinOnGroupID
	 * <pre>
	 * ?
	 * </pre>
	 * @return [STRING]
	 */
    function getJoinOnGroupID()
    {   
        return $this->getJoinOnFieldX('group_id');
    }
    
    function getJoinOnCampusID()
    {   
        return $this->getJoinOnFieldX('campus_id');
    }

	/**
	 * function getJoinOnCampusID
	 * <pre>
	 * ?
	 * </pre>
	 * @return [STRING]
	 */
    function getJoinOnCampusID()
    {   
        return $this->getJoinOnFieldX('campus_id');
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
	/**
	 * function getGroupID
	 * <pre>
	 * gets the group ID
	 * </pre>
	 * @return [STRING]
	 */
    function getGroupID(){
    	return $this->getValueByFieldName('group_id');
    }
    /**
	 * function getCampusID
	 * <pre>
	 * given an array of campuses, find all the groups for those campuses
	 * </pre>
	 * @return [STING]
	 */
    function getCampusID(){
    	return $this->getValueByFieldName('campus_id');
    }
}

?>