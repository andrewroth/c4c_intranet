<?php
/**
 * @package NavBar
 */ 
/**
 * class RowManager_NavLinkViewerManager
 * <pre> 
 * Manages relationships between links and individual Viewers on the site..
 * </pre>
 * @author Johnny Hausman
 */
class  RowManager_NavLinkViewerManager extends RowManager {

	//CONSTANTS:
	/** The name of the DB Table this class manages. */
    const DB_TABLE = 'navbar_navlinkviewer';
    
    /** The SQL description of the DB Table this class manages. */
    /*
     * navlinkviewer_id [INTEGER]  Primary Key for this table
     * navbarlink_id [INTEGER]  Foreign Key pointing back to which link is being referenced.
     * viewer_id [INTEGER]  Foreign Key relating back to the viewer being assigned this link
     */
    const DB_TABLE_DESCRIPTION = " (
  navlinkviewer_id int(11) NOT NULL  auto_increment,
  navbarlink_id int(11) NOT NULL  default '0',
  viewer_id int(11) NOT NULL  default '0',
  PRIMARY KEY (navlinkviewer_id)
) TYPE=MyISAM";
    
    /** The fields in the DB Table this class manages. */
    const FIELD_LIST = 'navlinkviewer_id,navbarlink_id,viewer_id';
    
    /** The XML node name for this entry. */
    const XML_NODE_NAME = 'navlinkviewer';
    

	//VARIABLES:


	//CLASS CONSTRUCTOR
	//************************************************************************
	/**
	 * function __construct
	 * <pre>
	 * Initialize this object.
	 * </pre>
	 * @param $linkViewerID [INTEGER] The unique id of the navlinkviewer we are managing.
	 * @return [void]
	 */
    function __construct( $linkViewerID=-1 ) 
    {
    
        $dbTableName = RowManager_NavLinkViewerManager::DB_TABLE;
        $fieldList = RowManager_NavLinkViewerManager::FIELD_LIST;
        $primaryKeyField = 'navlinkviewer_id';
        $primaryKeyValue = $linkViewerID;
        
        if (( $linkViewerID != -1 ) && ( $linkViewerID != '' )) {
        
            $condition = $primaryKeyField . '=' . $primaryKeyValue;
            
        } else {
            $condition = '';
        }
        $xmlNodeName = RowManager_NavLinkViewerManager::XML_NODE_NAME;
        parent::__construct( $dbTableName, $fieldList, $primaryKeyField, $primaryKeyValue, $condition, $xmlNodeName);
        
        $this->dbDescription = RowManager_NavLinkViewerManager::DB_TABLE_DESCRIPTION;
        
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
	 * function setLinkID
	 * <pre>
	 * Sets the navbarlink_id.
	 * </pre>
	 * @param $linkID [INTEGER] the navbarlink_id of the link 
	 * @return [void]
	 */
    function setLinkID( $linkID ) 
    {
        $this->setValueByFieldName('navbarlink_id', $linkID );
    }
    
    
    
    //************************************************************************
	/**
	 * function setViewerID
	 * <pre>
	 * Sets the viewer_id.
	 * </pre>
	 * @param $viewerID [INTEGER] the viewer_id of the viewer 
	 * @return [void]
	 */
    function setViewerID( $viewerID ) 
    {
        $this->setValueByFieldName('viewer_id', $viewerID );
    }

    
    	
}

?>