<?php
/**
 * @package AccountAdmin
 */ 
/**
 * class RowManager_ViewerAccessGroupManager
 * <pre> 
 * Links a Viewer to an Access Group..
 * </pre>
 * @author Johnny Hausman
 */
class  RowManager_ViewerAccessGroupManager extends RowManager {

	//CONSTANTS:
	/** The name of the DB Table this class manages. */
    const DB_TABLE = 'accountadmin_vieweraccessgroup';
    
    /** The SQL description of the DB Table this class manages. */
    /*
     * vieweraccessgroup_id [INTEGER]  Primary Key for this table
     * viewer_id [INTEGER]  The Viewer ID to define an access group for.
     * accessgroup_id [INTEGER]  The Access Group we are linking to a viewer.
     */
    const DB_TABLE_DESCRIPTION = " (
  vieweraccessgroup_id int(11) NOT NULL  auto_increment,
  viewer_id int(11) NOT NULL  default '0',
  accessgroup_id int(11) NOT NULL  default '0',
  PRIMARY KEY (vieweraccessgroup_id)
) TYPE=MyISAM";
    
    /** The fields in the DB Table this class manages. */
    const FIELD_LIST = 'vieweraccessgroup_id,viewer_id,accessgroup_id';
    
    /** The XML node name for this entry. */
    const XML_NODE_NAME = 'vieweraccessgroup';
    

	//VARIABLES:


	//CLASS CONSTRUCTOR
	//************************************************************************
	/**
	 * function __construct
	 * <pre>
	 * Initialize this object.
	 * </pre>
	 * @param $initValue [INTEGER] The unique id of the vieweraccessgroup we are managing.
	 * @return [void]
	 */
    function __construct( $initValue=-1 ) 
    {
    
        $dbTableName = RowManager_ViewerAccessGroupManager::DB_TABLE;
        $fieldList = RowManager_ViewerAccessGroupManager::FIELD_LIST;
        $primaryKeyField = 'vieweraccessgroup_id';
        $primaryKeyValue = $initValue;
        
        if (( $initValue != -1 ) && ( $initValue != '' )) {
        
            $condition = $primaryKeyField . '=' . $primaryKeyValue;
            
        } else {
            $condition = '';
        }
        $xmlNodeName = RowManager_ViewerAccessGroupManager::XML_NODE_NAME;
        parent::__construct( $dbTableName, $fieldList, $primaryKeyField, $primaryKeyValue, $condition, $xmlNodeName);
        
        $this->dbDescription = RowManager_ViewerAccessGroupManager::DB_TABLE_DESCRIPTION;
        
        if ($this->isLoaded() == false) {
        
            // uncomment this line if you want the Manager to automatically 
            // create a new entry if the given info doesn't exist.
            // $this->createNewEntry();
        }
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
	 * function getAccessGroupManager
	 * <pre>
	 * Returns an AccessGroupManager based on the current object.
	 * </pre>
	 * @return [OBJECT] RowManager_AccessGroupManager
	 */
    function getAccessGroupManager() 
    {
        $accessGroupID = $this->getValueByFieldName( 'accessgroup_id' );
        return  new RowManager_AccessGroupManager( $accessGroupID );
    }
    
    
    
    //************************************************************************
	/**
	 * function getJoinOnGroupID
	 * <pre>
	 * Returns the join field for accessgroup_id.
	 * </pre>
	 * @return [STRING]
	 */
    function getJoinOnGroupID() 
    {
        return $this->getJoinOnFieldX( 'accessgroup_id' );
    }
    
    
    //************************************************************************
	/**
	 * function getJoinOnViewerID
	 * <pre>
	 * Returns the join field for viewer_id.
	 * </pre>
	 * @return [STRING]
	 */
    function getJoinOnViewerID() 
    {
        return $this->getJoinOnFieldX( 'viewer_id' );
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
        return "accessgroup_id";
    }
    
    
    
    //************************************************************************
	/**
	 * function loadByViewerAccessGroup
	 * <pre>
	 * loads an entry given a viewer id and access group id.
	 * </pre>
	 * @param $viewerID [INTEGER] the ID of the viewer account
	 * @param $accessGroupID [INTEGER] the ID of the access group
	 * @return [BOOL]
	 */
    function loadByViewerAccessGroup( $viewerID, $accessGroupID ) 
    {
        $condition = ' viewer_id='.$viewerID.' AND accessgroup_id='.$accessGroupID;
        
        return  $this->loadByCondition( $condition );
    }
    
    
    
    //************************************************************************
	/**
	 * function setAccessGroupID
	 * <pre>
	 * Sets the accessgroup_id for this entry.
	 * </pre>
	 * @param $accessGroupID [INTEGER] the new accessgroup_id 
	 * @return [void]
	 */
    function setAccessGroupID( $accessGroupID ) 
    {
        $this->setValueByFieldName( 'accessgroup_id', $accessGroupID );
    }
    
    
    
    //************************************************************************
	/**
	 * function setViewerID
	 * <pre>
	 * Sets the viewer_id for this entry.
	 * </pre>
	 * @param $viewerID [INTEGER] the new viewer_id 
	 * @return [void]
	 */
    function setViewerID( $viewerID ) 
    {
        $this->setValueByFieldName( 'viewer_id', $viewerID );
    }

    
    	
}

?>