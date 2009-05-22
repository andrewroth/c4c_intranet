<?php
/**
 * @package cim_sch
 */ 
/**
 * class RowManager_PermissionsGroupAdminManager
 * <pre> 
 * Contains the relationship between viewer and group. Group admin can only access the group that they are assign to..
 * </pre>
 * @author Calvin Jien & Russ Martin
 */
class  RowManager_PermissionsGroupAdminManager extends RowManager {

	//CONSTANTS:
	/** The name of the DB Table this class manages. */
    const DB_TABLE = 'cim_sch_permissionsgroupadmin';
    
    /** The SQL description of the DB Table this class manages. */
    /*
     * permissionsGroupAdmin_id [INTEGER]  ID of the group admin permissions
     * viewer_id [INTEGER]  ID of the viewer
     * group_id [INTEGER]  ID of the group
     * permissionsGroupAdmin_emailNotification [INTEGER]  To send the email notification to the user?
     * permissionsGroupAdmin_admin [INTEGER]  Indicate if the user is the admin for the group.
     */
    const DB_TABLE_DESCRIPTION = " (
  permissionsGroupAdmin_id int(11) NOT NULL  auto_increment,
  viewer_id int(11) NOT NULL  default '0',
  group_id int(11) NOT NULL  default '0',
  permissionsGroupAdmin_emailNotification int(11) NOT NULL  default '0',
  PRIMARY KEY (permissionsGroupAdmin_id)
) TYPE=MyISAM";
    
    /** The fields in the DB Table this class manages. */
    const FIELD_LIST = 'permissionsGroupAdmin_id,viewer_id,group_id,permissionsGroupAdmin_emailNotification';
    
    /** The XML node name for this entry. */
    const XML_NODE_NAME = 'permissionsgroupadmin';
    

	//VARIABLES:


	//CLASS CONSTRUCTOR
	//************************************************************************
	/**
	 * function __construct
	 * <pre>
	 * Initialize this object.
	 * </pre>
	 * @param $PERMISSIONSGROUPADMIN_ID [INTEGER] The unique id of the permissionsgroupadmin we are managing.
	 * @return [void]
	 */
    function __construct( $PERMISSIONSGROUPADMIN_ID=-1 ) 
    {
    
        $dbTableName = RowManager_PermissionsGroupAdminManager::DB_TABLE;
        $fieldList = RowManager_PermissionsGroupAdminManager::FIELD_LIST;
        $primaryKeyField = 'permissionsGroupAdmin_id';
        $primaryKeyValue = $PERMISSIONSGROUPADMIN_ID;
        
        if (( $PERMISSIONSGROUPADMIN_ID != -1 ) && ( $PERMISSIONSGROUPADMIN_ID != '' )) {
        
            $condition = $primaryKeyField . '=' . $primaryKeyValue;
            
        } else {
            $condition = '';
        }
        $xmlNodeName = RowManager_PermissionsGroupAdminManager::XML_NODE_NAME;
        parent::__construct( $dbTableName, $fieldList, $primaryKeyField, $primaryKeyValue, $condition, $xmlNodeName);
        
        $this->dbDescription = RowManager_PermissionsGroupAdminManager::DB_TABLE_DESCRIPTION;

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
	 * function loadByViewerID
	 * <pre>
	 * processes viewerID
	 * </pre>
	 * @return [STRING]
	 */
    function loadByViewerID( $viewerID )
    {
        $condition = 'viewer_id='.$viewerID;
        echo "Loadbyviewer: ".$viewerID."<br>";
        return $this->loadByCondition( $condition );
    }
    /**
	 * function getGroupID
	 * <pre>
	 * returns the value by field name
	 * </pre>
	 * @return [BOOLEAN]
	 */
    function getGroupID (){
    	return $this->getValueByFieldName('group_id');
    }
	/**
	 * function getViewerID
	 * <pre>
	 * returns the value by field name of viewer ID
	 * </pre>
	 * @return [BOOLEAN]
	 */
	function getViewerID(){
		return $this->getValueByFieldName('viewer_id');
	}
	function setViewerID($viewerID){
		$this->setValueByFieldName('viewer_id',$viewerID);
	}
	function setGroupID($groupID){
		$this->setValueByFieldName('group_id',$groupID);
	}
    function setCampusID( $campusID )
    {
        $this->setValueByFieldName( 'campus_id', $campusID );
    }
	
    function getJoinOnGroupID()
    {   
        return $this->getJoinOnFieldX('group_id');
    }

    function returnSearchConditionViewerID( $viewerID )
    {

        $conditionArray[] = "viewer_id=".$viewerID;
        $monsterCondition = $this->constructSearchConditionFromArray( $conditionArray, OP_OR, true );
        return $monsterCondition;
    }

    function returnSearchConditionCampusIDViewerID($campusID, $viewerID){
    	$conditionArray[] = "campus_id=".$campusID;
    	$conditionArray[] = "viewer_id=".$viewerID;
        $monsterCondition = $this->constructSearchConditionFromArray( $conditionArray, OP_OR, true );
        return $monsterCondition;
    }
}

?>