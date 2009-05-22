<?php
/**
 * @package NavBar
 */ 
/**
 * class RowManager_NavBarLinksManager
 * <pre> 
 * Manages the actual links on the NavBar.
 * </pre>
 * @author Johnny Hausman
 */
class  RowManager_NavBarLinksManager extends RowManager {

	//CONSTANTS:
	/** The name of the DB Table this class manages. */
    const DB_TABLE = 'navbar_navbarlinks';
    
    /** The SQL description of the DB Table this class manages. */
    /*
     * navbarlink_id [INTEGER]  Primary Key for this table
     * navbargroup_id [INTEGER]  Foreign Key relating this Link to a group
     * navbarlink_textKey [STRING]  the key for the multilingual content to display the name of this link. "[link_[textKey]]"
     * navbarlink_url [STRING]  the url of a link not tied to a site module.
     * module_id [INTEGER]  Foreign Key relating this link to a build in module for the site.
     * navbarlink_isActive [BOOL]  Bool flag turning link on or off.
     * navbarlink_isModule [BOOL]  Bool flag indicating if this link uses a module key or url.
     * navbarlink_order [INTEGER]  used for specifying which order this link should be displayed in the nav bar menu.
     */
    const DB_TABLE_DESCRIPTION = " (
  navbarlink_id int(11) NOT NULL  auto_increment,
  navbargroup_id int(11) NOT NULL  default '0',
  navbarlink_textKey varchar(50) NOT NULL  default '',
  navbarlink_url text NOT NULL  default '',
  module_id int(11) NOT NULL  default '0',
  navbarlink_isActive int(1) NOT NULL  default '0',
  navbarlink_isModule int(1) NOT NULL  default '0',
  navbarlink_order int(11) NOT NULL  default '0',
  navbarlink_startDateTime datetime NOT NULL default '0000-00-00 00:00:00',
  navbarlink_endDateTime datetime NOT NULL default '9999-12-29 23:59:00',
  PRIMARY KEY (navbarlink_id)
) TYPE=MyISAM";
    
    /** The fields in the DB Table this class manages. */
    const FIELD_LIST = 'navbarlink_id,navbargroup_id,navbarlink_textKey,navbarlink_url,module_id,navbarlink_isActive,navbarlink_isModule,navbarlink_order,navbarlink_startDateTime,navbarlink_endDateTime';
    
    /** The XML node name for this entry. */
    const XML_NODE_NAME = 'navbarlinks';
    

	//VARIABLES:


	//CLASS CONSTRUCTOR
	//************************************************************************
	/**
	 * function __construct
	 * <pre>
	 * Initialize this object.
	 * </pre>
	 * @param $linkID [INTEGER] The unique id of the navbarlinks we are managing.
	 * @return [void]
	 */
    function __construct( $linkID=-1 ) 
    {
    
        $dbTableName = RowManager_NavBarLinksManager::DB_TABLE;
        $fieldList = RowManager_NavBarLinksManager::FIELD_LIST;
        $primaryKeyField = 'navbarlink_id';
        $primaryKeyValue = $linkID;
        
        if (( $linkID != -1 ) && ( $linkID != '' )) {
        
            $condition = $primaryKeyField . '=' . $primaryKeyValue;
            
        } else {
            $condition = '';
        }
        $xmlNodeName = RowManager_NavBarLinksManager::XML_NODE_NAME;
        parent::__construct( $dbTableName, $fieldList, $primaryKeyField, $primaryKeyValue, $condition, $xmlNodeName);
        
        $this->dbDescription = RowManager_NavBarLinksManager::DB_TABLE_DESCRIPTION;
        
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
    
        // before removing entry, make sure associated linkGroups & linkViewers
        // are removed as well
        $linkID = $this->getID();
        
        $linkMgr = new RowManager_NavLinkAccessGroupManager();
        $linkMgr->setLinkID( $linkID );
        $list = $linkMgr->getListIterator();
        
        $list->setFirst();
        while( $entry =  $list->getNext() ) {
            $entry->deleteEntry();
        }
        
        $linkViewerMgr = new RowManager_NavLinkViewerManager();
        $linkViewerMgr->setLinkID( $linkID );
        $list = $linkViewerMgr->getListIterator();
        
        $list->setFirst();
        while( $entry =  $list->getNext() ) {
            $entry->deleteEntry();
        }
        
        parent::deleteEntry();
        
    } // end deleteEntry()
    
    
    
    //************************************************************************
	/**
	 * function getJoinOnLinkID
	 * <pre>
	 * Returns the join field for navbarlink_id.
	 * </pre>
	 * @return [STRING]
	 */
    function getJoinOnLinkID() 
    {
        return $this->getJoinOnFieldX( 'navbarlink_id' );
    }
    
    
    
    //************************************************************************
	/**
	 * function getKeyField
	 * <pre>
	 * Returns the field to use in the key routines.
	 * </pre>
	 * @return [STRING]
	 */
    function getKeyField() 
    {
        return "navbarlink_textKey";
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
        return "navbarlink_textKey";
    }
    
    
    
    //************************************************************************
	/**
	 * function getURL
	 * <pre>
	 * Returns the URL of this linnk.
	 * </pre>
	 * @return [STRING]
	 */
    function getURL() 
    {
        return $this->getValueByFieldName( 'navbarlink_url' );
    }
    
    
    
    //************************************************************************
	/**
	 * function setGroupID
	 * <pre>
	 * Set's the navbargroup_id value.
	 * </pre>
	 * @param $groupID [INTEGER] new navbargroup_id
	 * @return [void]
	 */
    function setGroupID( $groupID ) 
    {
        $this->setValueByFieldName( 'navbargroup_id', $groupID);
    }
    
    
    
    //************************************************************************
	/**
	 * function setURL
	 * <pre>
	 * Sets the URL of this linnk.
	 * </pre>
	 * @param $url [STRING] the new url
	 * @return [void]
	 */
    function setURL( $url ) 
    {
        $this->setValueByFieldName( 'navbarlink_url', $url );
    }

    
    	
}

?>