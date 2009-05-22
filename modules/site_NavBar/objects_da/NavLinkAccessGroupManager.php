<?php
/**
 * @package NavBar
 */ 
/**
 * class RowManager_NavLinkAccessGroupManager
 * <pre> 
 * This table joins which nav bar links are displayed for which site access group..
 * </pre>
 * @author Johnny Hausman
 */
class  RowManager_NavLinkAccessGroupManager extends RowManager {

	//CONSTANTS:
	/** The name of the DB Table this class manages. */
    const DB_TABLE = 'navbar_navlinkaccessgroup';
    
    /** The SQL description of the DB Table this class manages. */
    /*
     * navlinkaccessgroup_id [INTEGER]  Primary Key for this table
     * navbarlink_id [INTEGER]  Foreign Key relating this entry to a link
     * accessgroup_id [INTEGER]  Foreign key relating this link to a site Access Group
     */
    const DB_TABLE_DESCRIPTION = " (
  navlinkaccessgroup_id int(11) NOT NULL  auto_increment,
  navbarlink_id int(11) NOT NULL  default '0',
  accessgroup_id int(11) NOT NULL  default '0',
  PRIMARY KEY (navlinkaccessgroup_id)
) TYPE=MyISAM";
    
    /** The fields in the DB Table this class manages. */
    const FIELD_LIST = 'navlinkaccessgroup_id,navbarlink_id,accessgroup_id';
    
    /** The XML node name for this entry. */
    const XML_NODE_NAME = 'navlinkaccessgroup';
    

	//VARIABLES:


	//CLASS CONSTRUCTOR
	//************************************************************************
	/**
	 * function __construct
	 * <pre>
	 * Initialize this object.
	 * </pre>
	 * @param $linkGroupID [INTEGER] The unique id of the navlinkaccessgroup we are managing.
	 * @return [void]
	 */
    function __construct( $linkGroupID=-1 ) 
    {
    
        $dbTableName = RowManager_NavLinkAccessGroupManager::DB_TABLE;
        $fieldList = RowManager_NavLinkAccessGroupManager::FIELD_LIST;
        $primaryKeyField = 'navlinkaccessgroup_id';
        $primaryKeyValue = $linkGroupID;
        
        if (( $linkGroupID != -1 ) && ( $linkGroupID != '' )) {
        
            $condition = $primaryKeyField . '=' . $primaryKeyValue;
            
        } else {
            $condition = '';
        }
        $xmlNodeName = RowManager_NavLinkAccessGroupManager::XML_NODE_NAME;
        parent::__construct( $dbTableName, $fieldList, $primaryKeyField, $primaryKeyValue, $condition, $xmlNodeName);
        
        $this->dbDescription = RowManager_NavLinkAccessGroupManager::DB_TABLE_DESCRIPTION;
        
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
	 * function getJoinOnLinkID
	 * <pre>
	 * Returns the join field for viewer_id.
	 * </pre>
	 * @return [STRING]
	 */
    function getJoinOnLinkID() 
    {
        return $this->getJoinOnFieldX( 'navbarlink_id' );
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
	 * function setGroupID
	 * <pre>
	 * Sets the accessgroup_id of this entry.
	 * </pre>
	 * @param $groupID [INTEGER] the new accessgroup_id
	 * @return [void]
	 */
    function setGroupID( $groupID ) 
    {
        $this->setValueByFieldName( 'accessgroup_id', $groupID );
    }
    
    
    
    //************************************************************************
	/**
	 * function setLinkID
	 * <pre>
	 * Sets the navbarlink_id of this entry.
	 * </pre>
	 * @param $link [INTEGER] the new navbarlink_id
	 * @return [void]
	 */
    function setLinkID( $link ) 
    {
        $this->setValueByFieldName( 'navbarlink_id', $link );
    }

    
    	
}

?>