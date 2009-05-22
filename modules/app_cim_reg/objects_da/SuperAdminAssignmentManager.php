<?php
/**
 * @package cim_reg
 */ 
/**
 * class RowManager_SuperAdminAssignmentManager
 * <pre> 
 * Assigns super admin privilege to particular viewers..
 * </pre>
 * @author Russ Martin
 */
class  RowManager_SuperAdminAssignmentManager extends RowManager {

	//CONSTANTS:
	/** The name of the DB Table this class manages. */
    const DB_TABLE = 'cim_reg_superadmin';
    
    /** The SQL description of the DB Table this class manages. */
    /*
     * superadmin_id [INTEGER]  Unique identifier for super admin
     * viewer_id [INTEGER]  Identifier of the viewer/user assigned the super-admin role.
     */
    const DB_TABLE_DESCRIPTION = " (
  superadmin_id int(16) NOT NULL  auto_increment,
  viewer_id int(16) NOT NULL  default '0',
  PRIMARY KEY (superadmin_id)
) TYPE=MyISAM";
    
    /** The fields in the DB Table this class manages. */
    const FIELD_LIST = 'superadmin_id,viewer_id';
    
    /** The XML node name for this entry. */
    const XML_NODE_NAME = 'superadminassignment';
    

	//VARIABLES:


	//CLASS CONSTRUCTOR
	//************************************************************************
	/**
	 * function __construct
	 * <pre>
	 * Initialize this object.
	 * </pre>
	 * @param $SUPERADMIN_ID [INTEGER] The unique id of the superadminassignment we are managing.
	 * @return [void]
	 */
    function __construct( $SUPERADMIN_ID=-1 ) 
    {
    
        $dbTableName = RowManager_SuperAdminAssignmentManager::DB_TABLE;
        $fieldList = RowManager_SuperAdminAssignmentManager::FIELD_LIST;
        $primaryKeyField = 'superadmin_id';
        $primaryKeyValue = $SUPERADMIN_ID;
        
        if (( $SUPERADMIN_ID != -1 ) && ( $SUPERADMIN_ID != '' )) {
        
            $condition = $primaryKeyField . '=' . $primaryKeyValue;
            
        } else {
            $condition = '';
        }
        $xmlNodeName = RowManager_SuperAdminAssignmentManager::XML_NODE_NAME;
        parent::__construct( $dbTableName, $fieldList, $primaryKeyField, $primaryKeyValue, $condition, $xmlNodeName);
        
        $this->dbDescription = RowManager_SuperAdminAssignmentManager::DB_TABLE_DESCRIPTION;

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

   //************************************************************************
	/**
	 * function loadByViewer
	 * <pre>
	 * loads an entry given a viewer id
	 * </pre>
	 * @param $viewerID [INTEGER] the ID of the viewer account
	 * @return [BOOL]
	 */
    function loadByViewer( $viewerID) 
    {
        $condition = ' viewer_id='.$viewerID;
        
        return  $this->loadByCondition( $condition );
    }        
    	
}

?>