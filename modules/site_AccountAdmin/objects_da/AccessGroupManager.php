<?php
/**
 * @package AccountAdmin
 */ 
/**
 * class RowManager_AccessGroupManager
 * <pre> 
 * Defines an access group for the site.  Different site links (and resources) are assoicated with different account Groups. .
 * </pre>
 * @author Johnny Hausman
 */
class  RowManager_AccessGroupManager extends RowManager {

	//CONSTANTS:
	/** The name of the DB Table this class manages. */
    const DB_TABLE = 'accountadmin_accessgroup';
	
	//** Value for Undefined Access Category. */
	const UNDEFINED_ACCESS_CATEGORY = -1;
    
    /** The SQL description of the DB Table this class manages. */
    /*
     * accessgroup_id [INTEGER]  Primary Key for this table
     * accesscategory_id [INTEGER]  Links this access group to a category.
     * accessgroup_key [STRING]  The label lookup value for this access group
     */
    const DB_TABLE_DESCRIPTION = " (
  accessgroup_id int(11) NOT NULL  auto_increment,
  accesscategory_id int(11) NOT NULL  default '0',
  accessgroup_key varchar(50) NOT NULL  default '',
  PRIMARY KEY (accessgroup_id)
) TYPE=MyISAM";
    
    /** The fields in the DB Table this class manages. */
    const FIELD_LIST = 'accessgroup_id,accesscategory_id,accessgroup_key';
    
    /** The XML node name for this entry. */
    const XML_NODE_NAME = 'accessgroup';
    
    const ADMIN_ACCESS_LABEL = 'Site Administration';
    const HRDB_ACCESS_LABEL = 'HRDB';
    const ALL_ACCESS_LABEL = 'All';
	//VARIABLES:


	//CLASS CONSTRUCTOR
	//************************************************************************
	/**
	 * function __construct
	 * <pre>
	 * Initialize this object.
	 * </pre>
	 * @param $accessGroupID [INTEGER] The unique id of the accessgroup we are managing.
	 * @return [void]
	 */
    function __construct( $accessGroupID=-1 ) 
    {
    
        $dbTableName = RowManager_AccessGroupManager::DB_TABLE;
        $fieldList = RowManager_AccessGroupManager::FIELD_LIST;
        $primaryKeyField = 'accessgroup_id';
        $primaryKeyValue = $accessGroupID;
        
        if (( $accessGroupID != -1 ) && ( $accessGroupID != '' )) {
        
            $condition = $primaryKeyField . '=' . $primaryKeyValue;
            
        } else {
            $condition = '';
        }
        $xmlNodeName = RowManager_AccessGroupManager::XML_NODE_NAME;
        parent::__construct( $dbTableName, $fieldList, $primaryKeyField, $primaryKeyValue, $condition, $xmlNodeName);
        
        $this->dbDescription = RowManager_AccessGroupManager::DB_TABLE_DESCRIPTION;
        
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
	 * function getAccessCategoryID
	 * <pre>
	 * Returns the accesscategory_id value for this entry.
	 * </pre>
	 * @return [STRING]
	 */
    function getAccessCategoryID() 
    {
        return $this->getValueByFieldName( "accesscategory_id" );
    }
	
		
	
    //*******************************************************************
	/**
	 * function getAdminAccessGroupID
	 * <pre>
	 * Returns a access group id for the admin group
	 * </pre>
	 * @return [INTEGER]
	 */
    function getAdminAccessGroupID()
    {
        /*
        $accessGroup = new RowManager_AccessGroupManager();
        $seriesKey = moduleAccountAdmin::MULTILINGUAL_SERIES_KEY;
        $pageKey = RowManager_AccessGroupManager::XML_NODE_NAME;
        $multiLingualContext = new MultilingualManager( 1, $seriesKey, $pageKey );
        $labelBridge = $accessGroup->getRowLabelBridge( $multiLingualContext );

        $labelBridge->constructSearchCondition("label_label", "=", RowManager_AccessGroupManager::ADMIN_ACCESS_LABEL, true);
        $labelBridgeList = $labelBridge->getListIterator();
//var_export($labelBridgeList);
        $labelBridgeList->setFirst();
        $group = $labelBridgeList->getNext();
  //      var_export($group);
        return $group->getID();
        */
        return $this->getAccessGroupID(RowManager_AccessGroupManager::ADMIN_ACCESS_LABEL);
    }
    
    
    //*******************************************************************
	/**
	 * function getAllAccessGroupID
	 * <pre>
	 * Returns a access group id for the 'all' group
	 * </pre>
	 * @return [INTEGER]
	 */
    function getAllAccessGroupID()
    {
        /*
        $accessGroup = new RowManager_AccessGroupManager();
        $seriesKey = moduleAccountAdmin::MULTILINGUAL_SERIES_KEY;
        $pageKey = RowManager_AccessGroupManager::XML_NODE_NAME;
        $multiLingualContext = new MultilingualManager( 1, $seriesKey, $pageKey );
        $labelBridge = $accessGroup->getRowLabelBridge( $multiLingualContext );

        $labelBridge->constructSearchCondition("label_label", "=", RowManager_AccessGroupManager::ALL_ACCESS_LABEL, true);
        $labelBridgeList = $labelBridge->getListIterator();
//var_export($labelBridgeList);
        $labelBridgeList->setFirst();
        $group = $labelBridgeList->getNext();
  //      var_export($group);
        return $group->getID();
    */
        return $this->getAccessGroupID(RowManager_AccessGroupManager::ALL_ACCESS_LABEL);
    }
    
    
    
    //************************************************************************
	/**
	 * function getAccesGroupID
	 * <pre>
	 * Returns a access group id for given label
	 * </pre>
	 * @param $label [STRING] The label of the Group we are searching for. 
	 * @return [INTEGER]
	 */
	 function getAccessGroupID($label)
	 {
        $accessGroup = new RowManager_AccessGroupManager();
        $seriesKey = moduleAccountAdmin::MULTILINGUAL_SERIES_KEY;
        $pageKey = RowManager_AccessGroupManager::XML_NODE_NAME;
        $multiLingualContext = new MultilingualManager( 1, $seriesKey, $pageKey );
        $labelBridge = $accessGroup->getRowLabelBridge( $multiLingualContext );
        
        $labelBridge->constructSearchCondition("label_label", "=", $label, true);
        $labelBridgeList = $labelBridge->getListIterator();
        //var_export($labelBridgeList);
        $labelBridgeList->setFirst();
        $group = $labelBridgeList->getNext();
//var_export($group);
        if ($group != false) {
            return $group->getID();
        } else {
            return false;
        }
	 }
    
    //************************************************************************
	/**
	 * function getCategoryManager
	 * <pre>
	 * Returns a Access Category manager object linked to by this object.
	 * </pre>
	 * @return [OBJECT RowManager_AccessCategoryManager]
	 */
    function getCategoryManager() 
    {
        $categoryManagerID = (int) $this->getValueByFieldName( 'accesscategory_id' );
        return new RowManager_AccessCategoryManager( $categoryManagerID );
    }
    
    //************************************************************************
	/**
	 * function getHRDBAccessID
	 * <pre>
	 * Returns the Access ID for HRDB access
	 * </pre>
	 * @return [INTEGER RowManager_AccessCategoryManager]
	 */
    function getHRDBAccessGroupID()
    {
        return $this->getAccessGroupID(RowManager_AccessGroupManager::HRDB_ACCESS_LABEL);
    }
    
    
    
    //************************************************************************
	/**
	 * function getKey
	 * <pre>
	 * Returns the key to use in the RowLabelBridge routines.
	 * </pre>
	 * @return [STRING]
	 */
    function getKey() 
    {
        return $this->getValueByFieldName( "accessgroup_key" );
    }
    
    
    
    //************************************************************************
	/**
	 * function getKeyField
	 * <pre>
	 * Returns the field to use in the RowLabelBridge routines.
	 * </pre>
	 * @return [STRING]
	 */
    function getKeyField() 
    {
        return "accessgroup_key";
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
        return "accessgroup_key";
    }
    
    
    
    //************************************************************************
	/**
	 * function setAccessCategoryID
	 * <pre>
	 * Sets the accesscategory_id value for this entry.
	 * </pre>
	 * @param $accessCategoryID [INTEGER] The new accesscategory_id value
	 * @return [void]
	 */
    function setAccessCategoryID( $accessCategoryID ) 
    {
        $this->setValueByFieldName( 'accesscategory_id', $accessCategoryID );
    }
    
    
    
    //************************************************************************
	/**
	 * function setAccessGroupID
	 * <pre>
	 * Sets the accessgroup_id value for this entry.
	 * </pre>
	 * @param $accessGroupID [INTEGER] The new accessgroup_id value
	 * @return [void]
	 */
    function setAccessGroupID( $accessGroupID ) 
    {
        $this->setValueByFieldName( 'accessgroup_id', $accessGroupID );
    }
    
    
    
    //************************************************************************
	/**
	 * function setAccessGroupKey
	 * <pre>
	 * Sets the accessgroup_key value for this entry.
	 * </pre>
	 * @param $key [INTEGER] The new accessgroup_key value
	 * @return [void]
	 */
    function setAccessGroupKey( $key ) 
    {
        $this->setValueByFieldName( 'accessgroup_key', $key );
    }
    
    
    
    //************************************************************************
	/**
	 * function setKey
	 * <pre>
	 * Returns the key to use in the RowLabelBridge routines.
	 * </pre>
	 * @param $key [STRING] the new key value
	 * @return [void]
	 */
    function setKey( $key ) 
    {
        $this->setValueByFieldName( "accessgroup_key", $key );
    }

    
    	
}

?>