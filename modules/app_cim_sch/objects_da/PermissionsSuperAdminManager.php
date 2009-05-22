<?php
/**
 * @package cim_sch
 */ 
/**
 * class RowManager_PermissionsSuperAdminManager
 * <pre> 
 * Contains all the super admins. Super Admin can access everything in the scheduler..
 * </pre>
 * @author Calvin Jien & Russ Martin
 */
class  RowManager_PermissionsSuperAdminManager extends RowManager {

	//CONSTANTS:
	/** The name of the DB Table this class manages. */
    const DB_TABLE = 'cim_sch_permissionssuperadmin';
    
    /** The SQL description of the DB Table this class manages. */
    /*
     * permissionsSuperAdmin_id [INTEGER]  ID of the Super Admin Permissions
     * viewer_id [INTEGER]  ID of the viewer
     */
    const DB_TABLE_DESCRIPTION = " (
  permissionsSuperAdmin_id int(11) NOT NULL  auto_increment,
  viewer_id int(11) NOT NULL  default '0',
  PRIMARY KEY (permissionsSuperAdmin_id)
) TYPE=MyISAM";
    
    /** The fields in the DB Table this class manages. */
    const FIELD_LIST = 'permissionsSuperAdmin_id,viewer_id';
    
    /** The XML node name for this entry. */
    const XML_NODE_NAME = 'permissionssuperadmin';
    

	//VARIABLES:


	//CLASS CONSTRUCTOR
	//************************************************************************
	/**
	 * function __construct
	 * <pre>
	 * Initialize this object.
	 * </pre>
	 * @param $PERMISSIONSSUPERADMIN_ID [INTEGER] The unique id of the permissionssuperadmin we are managing.
	 * @return [void]
	 */
    function __construct( $PERMISSIONSSUPERADMIN_ID=-1 ) 
    {
    
        $dbTableName = RowManager_PermissionsSuperAdminManager::DB_TABLE;
        $fieldList = RowManager_PermissionsSuperAdminManager::FIELD_LIST;
        $primaryKeyField = 'permissionsSuperAdmin_id';
        $primaryKeyValue = $PERMISSIONSSUPERADMIN_ID;
        
        if (( $PERMISSIONSSUPERADMIN_ID != -1 ) && ( $PERMISSIONSSUPERADMIN_ID != '' )) {
        
            $condition = $primaryKeyField . '=' . $primaryKeyValue;
            
        } else {
            $condition = '';
        }
        $xmlNodeName = RowManager_PermissionsSuperAdminManager::XML_NODE_NAME;
        parent::__construct( $dbTableName, $fieldList, $primaryKeyField, $primaryKeyValue, $condition, $xmlNodeName);
        
        $this->dbDescription = RowManager_PermissionsSuperAdminManager::DB_TABLE_DESCRIPTION;

    }
    
    //************************************************************************
	/**
	 * function loadByViewerID
	 * <pre>
	 * Attempts to load this object given a viewer_id
	 * </pre>
	 * @param $viewerID [INTEGER] new viewer_id
	 * @return [BOOL]
	 */
    function loadByViewerID( $viewerID )
    {
        $condition = 'viewer_id='.$viewerID;
        return $this->loadByCondition( $condition );
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