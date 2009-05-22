<?php
/**
 * @package NavBar
 */ 
/**
 * class RowManager_NavBarGroupManager
 * <pre> 
 * Divides the NavBar into seperate Groups.  Links on the NavBar are under these groups..
 * </pre>
 * @author Johnny Hausman
 */
class  RowManager_NavBarGroupManager extends RowManager {

	//CONSTANTS:
	/** The name of the DB Table this class manages. */
    const DB_TABLE = 'navbar_navbargroup';
    
    /** The SQL description of the DB Table this class manages. */
    /*
     * navbargroup_id [INTEGER]  Primary Key for this table
     * navbargroup_nameKey [STRING]  The multilingual lookup key to retrieve the group name.  '[group_[nameKey]]'
     * navbargroup_order [INTEGER]  defines the order in which the groups are to be displayed on the Nav Bar.
     */
    const DB_TABLE_DESCRIPTION = " (
  navbargroup_id int(11) NOT NULL  auto_increment,
  navbargroup_nameKey varchar(50) NOT NULL  default '',
  navbargroup_order int(11) NOT NULL  default '0',
  PRIMARY KEY (navbargroup_id)
) TYPE=MyISAM";
    
    /** The fields in the DB Table this class manages. */
    const FIELD_LIST = 'navbargroup_id,navbargroup_nameKey,navbargroup_order';
    
    /** The XML node name for this entry. */
    const XML_NODE_NAME = 'navbargroup';
    

	//VARIABLES:


	//CLASS CONSTRUCTOR
	//************************************************************************
	/**
	 * function __construct
	 * <pre>
	 * Initialize this object.
	 * </pre>
	 * @param $groupID [INTEGER] The unique id of the navbargroup we are managing.
	 * @return [void]
	 */
    function __construct( $groupID=-1 ) 
    {
    
        $dbTableName = RowManager_NavBarGroupManager::DB_TABLE;
        $fieldList = RowManager_NavBarGroupManager::FIELD_LIST;
        $primaryKeyField = 'navbargroup_id';
        $primaryKeyValue = $groupID;
        
        if (( $groupID != -1 ) && ( $groupID != '' )) {
        
            $condition = $primaryKeyField . '=' . $primaryKeyValue;
            
        } else {
            $condition = '';
        }
        $xmlNodeName = RowManager_NavBarGroupManager::XML_NODE_NAME;
        parent::__construct( $dbTableName, $fieldList, $primaryKeyField, $primaryKeyValue, $condition, $xmlNodeName);
        
        $this->dbDescription = RowManager_NavBarGroupManager::DB_TABLE_DESCRIPTION;
        
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
	 * function deleteEntry
	 * <pre>
	 * Removes the DB table info.
	 * </pre>
	 * @return [void]
	 */
    function deleteEntry() 
    {   
    
        // before removing entry, make sure associated links are removed 
        // as well
        $groupID = $this->getID();
        
        $linkMgr = new RowManager_NavBarLinksManager();
        $linkMgr->setGroupID( $groupID );
        $list = $linkMgr->getListIterator();
        
        $list->setFirst();
        while( $link =  $list->getNext() ) {
            $link->deleteEntry();
        }
        
        parent::deleteEntry();
        
    } // end deleteEntry()
    
    
    
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
        return "navbargroup_nameKey";
    }
    
    
    
    //************************************************************************
	/**
	 * function getKeyField
	 * <pre>
	 * Returns the field to use in the RowLabelBridge key routines.
	 * </pre>
	 * @return [STRING]
	 */
    function getKeyField() 
    {
        return "navbargroup_nameKey";
    }
    
    	
}

?>