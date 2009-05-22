<?php
/**
 * @package cim_sch
 */ 
/**
 * class RowManager_PermissionsCampusAdminManager
 * <pre> 
 * Contains the relationship between the viewer and campus. Campus Admin can access all group on an individual campus..
 * </pre>
 * @author Calvin Jien & Russ Martin
 */
class  RowManager_PermissionsCampusAdminManager extends RowManager {

	//CONSTANTS:
	/** The name of the DB Table this class manages. */
    const DB_TABLE = 'cim_sch_permissionscampusadmin';
    
    /** The SQL description of the DB Table this class manages. */
    /*
     * permissionsCampusAdmin_id [INTEGER]  ID of the campus admin permissions
     * viewer_id [INTEGER]  ID of the viewer
     * campus_id [INTEGER]  ID of the campus
     */
    const DB_TABLE_DESCRIPTION = " (
  permissionsCampusAdmin_id int(11) NOT NULL  auto_increment,
  viewer_id int(11) NOT NULL  default '0',
  campus_id int(11) NOT NULL  default '0',
  PRIMARY KEY (permissionsCampusAdmin_id)
) TYPE=MyISAM";
    
    /** The fields in the DB Table this class manages. */
    const FIELD_LIST = 'permissionsCampusAdmin_id,viewer_id,campus_id';
    
    /** The XML node name for this entry. */
    const XML_NODE_NAME = 'permissionscampusadmin';
    

	//VARIABLES:


	//CLASS CONSTRUCTOR
	//************************************************************************
	/**
	 * function __construct
	 * <pre>
	 * Initialize this object.
	 * </pre>
	 * @param $PERMISSIONSCAMPUSADMIN_ID [INTEGER] The unique id of the permissionscampusadmin we are managing.
	 * @return [void]
	 */
    function __construct( $PERMISSIONSCAMPUSADMIN_ID=-1 ) 
    {
    
        $dbTableName = RowManager_PermissionsCampusAdminManager::DB_TABLE;
        $fieldList = RowManager_PermissionsCampusAdminManager::FIELD_LIST;
        $primaryKeyField = 'permissionsCampusAdmin_id';
        $primaryKeyValue = $PERMISSIONSCAMPUSADMIN_ID;
        
        if (( $PERMISSIONSCAMPUSADMIN_ID != -1 ) && ( $PERMISSIONSCAMPUSADMIN_ID != '' )) {
        
            $condition = $primaryKeyField . '=' . $primaryKeyValue;
            
        } else {
            $condition = '';
        }
        $xmlNodeName = RowManager_PermissionsCampusAdminManager::XML_NODE_NAME;
        parent::__construct( $dbTableName, $fieldList, $primaryKeyField, $primaryKeyValue, $condition, $xmlNodeName);
        
        $this->dbDescription = RowManager_PermissionsCampusAdminManager::DB_TABLE_DESCRIPTION;

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
    	
    	
        return "campus_id";
    }
	/**
	 * function getCampusID
	 * <pre>
	 * returns the campus ID
	 * </pre>
	 * @return [STRING]
	 */
    function getCampusID()
    {
        return $this->getValueByFieldName('campus_id');
    }

    /**
	 * function setViewerID
	 * <pre>
	 * returns the campus name
	 * </pre>
	 * @return [STRING]
	 */
    function setViewerID( $viewerID )
    {
        $this->setValueByFieldName( 'viewer_id', $viewerID );
    }

    /**
	 * function getJoinOnCampusID
	 * <pre>
	 * returns the campus ID
	 * </pre>
	 * @return [STRING]
	 */
    function getJoinOnCampusID()
    {   
        return $this->getJoinOnFieldX('campus_id');
    }
    /**
	 * function getCampusName
	 * <pre>
	 * returns the campus name
	 * </pre>
	 * @return [STRING]
	 */
    function getJoinOnViewerID()
    {   
        return $this->getJoinOnFieldX('viewer_id');
    }

    	
}

?>