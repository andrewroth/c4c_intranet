<?php
/**
 * @package AccountAdmin
 */ 
/**
 * class RowManager_AccountAdminAccessManager
 * <pre> 
 * Manages Access Priviledges for the Account Admin system..
 * </pre>
 * @author Johnny Hausman
 */
class  RowManager_AccountAdminAccessManager extends RowManager {

	//CONSTANTS:
	/** The name of the DB Table this class manages. */
    const DB_TABLE = 'accountadmin_accountadminaccess';
    
    /** The SQL description of the DB Table this class manages. */
    /*
     * accountadminaccess_id [INTEGER]  Primary Key for this table
     * viewer_id [INTEGER]  The account we are defining an access priv for
     * accountadminaccess_privilege [INTEGER]  The access privilege level of
     *                              this viewer
     */
    const DB_TABLE_DESCRIPTION = " (
  accountadminaccess_id int(11) NOT NULL  auto_increment,
  viewer_id int(11) NOT NULL  default '0',
  accountadminaccess_privilege int(1) NOT NULL  default '0',
  PRIMARY KEY (accountadminaccess_id)
) TYPE=MyISAM";
    
    /** The fields in the DB Table this class manages. */
    const FIELD_LIST = 'accountadminaccess_id,viewer_id,accountadminaccess_privilege';
    
    /** The Group Level Priviledge. Allows user to administer Accounts for
     *  their account group.
     */
    const PRIVILEDGE_GROUP = 1;
    
    /** The Site Level Priviledge. Allows user to administer Accounts for
     *  any account group, and also administer the site level details like
     *  language types, access groups, etc...
     */
    const PRIVILEDGE_SITE = 2;
    
    /** The XML node name for this entry. */
    const XML_NODE_NAME = 'accountadminaccess';
    

	//VARIABLES:

    /** @var [OBJECT] Viewer Manager object.  Used to access current viewers DB fields. */
	protected $viewerMgr;
	
	

	//CLASS CONSTRUCTOR
	//************************************************************************
	/**
	 * function __construct
	 * <pre>
	 * Initialize this object.
	 * </pre>
	 * @param $initValue [INTEGER] The unique id of the accountadminaccess we are managing.
	 * @return [void]
	 */
    function __construct( $initValue=-1 ) 
    {
    
        $dbTableName = RowManager_AccountAdminAccessManager::DB_TABLE;
        $fieldList = RowManager_AccountAdminAccessManager::FIELD_LIST;
        $primaryKeyField = 'accountadminaccess_id';
        $primaryKeyValue = $initValue;
        
        if (( $initValue != -1 ) && ( $initValue != '' )) {
        
            $condition = $primaryKeyField . '=' . $primaryKeyValue;
            
        } else {
            $condition = '';
        }
        $xmlNodeName = RowManager_AccountAdminAccessManager::XML_NODE_NAME;
        parent::__construct( $dbTableName, $fieldList, $primaryKeyField, $primaryKeyValue, $condition, $xmlNodeName);
        
        $this->dbDescription = RowManager_AccountAdminAccessManager::DB_TABLE_DESCRIPTION;
        
        $this->viewerMgr = null;
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
	 * function getAccessPriviledge
	 * <pre>
	 * Returns the current user's access Priviledge
	 * </pre> 
	 * @return [INTEGER]
	 */
    function getAccessPrivilege( ) 
    {
        return $this->getValueByFieldName( 'accountadminaccess_privilege' );
    }
    
    
    
    //************************************************************************
	/**
	 * function getAccessPriviledgeArray
	 * <pre>
	 * Returns an array of AccessPriviledge types
	 * </pre> 
	 * @param $labels [ARRAY] labels to use for translation of this list.
	 * @param $defaultPriv [ARRAY] The limit of the priviledge to include in the 
	 * list.  This is for limiting the array based on a viewer's scope.
	 * @return [ARRAY]
	 */
    function getAccessPrivilegeArray( $labels, $privLimit=0 ) 
    {
        $priviledges = array();
        $groupPriv = RowManager_AccountAdminAccessManager::PRIVILEDGE_GROUP;
        if ( $privLimit >= $groupPriv ) {
            $priviledges[ $groupPriv ] = $labels->getLabel( '[group]' );
        }
            
        $sitePriv = RowManager_AccountAdminAccessManager::PRIVILEDGE_SITE;
        if ( $privLimit >= $sitePriv ) {
            $priviledges[ $sitePriv ] = $labels->getLabel( '[site]' );
        }
        
        return $priviledges;
    }
    
    
    
    //************************************************************************
	/**
	 * function getJoinOnViewerID
	 * <pre>
	 * returns the field used as a join condition for viewer_id
	 * </pre> 
	 * @return [STRING]
	 */
    function getJoinOnViewerID( ) 
    {   
        return $this->getJoinOnFieldX('viewer_id');
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
        return "viewer_id";
    }
    
    
    
    //************************************************************************
	/**
	 * function getListAccountPriviledgeAccess
	 * <pre>
	 * Returns a ListIterator for the list of accounts this viewer has access
	 * to modify.
	 * </pre>
     * @param $sortBy [STRING] the name of the field to sort by (can be a
	 * comma seperated list).
	 * @return [OBJECT]
	 */
    function getListAccountPriviledgeAccess( $sortBy ) 
    {
        $multiTable = new MultiTableManager();
        
        $genViewer = new RowManager_ViewerManager();
        $joinFieldA = $genViewer->getJoinOnViewerID();
        
        // if the current viewer is limited to the Group Access scope then
        // filter list based on current group.
        if ($this->hasGroupPriv() ) {
            $viewerMgr = $this->getViewerManager();
            $genViewer->setAccountGroupID( $viewerMgr->getAccountGroupID() );
        }
        
        $multiTable->addRowManager( $genViewer );
        
        $accessManager = new RowManager_AccountAdminAccessManager();
        $joinFieldB = $accessManager->getJoinOnViewerID();
        $joinPair = new JoinPair($joinFieldA, $joinFieldB);
        
        $multiTable->addRowManager( $accessManager, $joinPair);
        $multiTable->constructSearchCondition( 'accountadminaccess_privilege', '<=', $this->getAccessPrivilege(), true);
        
        return $multiTable->getListIterator( $sortBy );
    }
    
    
    
    //************************************************************************
	/**
	 * function getListViewerAccounts
	 * <pre>
	 * Returns a ListIterator for the list of web site accounts this viewer 
	 * has access to modify.
	 * </pre>
     * @param $sortBy [STRING] the name of the field to sort by (can be a
	 * comma seperated list).
	 * @return [OBJECT]
	 */
    function getListViewerAccounts( $sortBy='' ) 
    {
        
        $genViewer = new RowManager_ViewerManager();
        
        // if the current viewer is limited to the Group Access scope then
        // filter list based on current group.
        if (!$this->hasSitePriv() ) {
            $viewerMgr = $this->getViewerManager();
            $genViewer->setAccountGroupID( $viewerMgr->getAccountGroupID() );
        }
        
        return $genViewer->getListIterator( $sortBy );
    }
    
    
    
    //************************************************************************
	/**
	 * function getViewerID
	 * <pre>
	 * returns the viewer_id
	 * </pre> 
	 * @return [INTEGER]
	 */
    function getViewerID( ) 
    {   
        return $this->getValueByFieldName('viewer_id');
    }
    
    
    
    //************************************************************************
	/**
	 * function getViewerManager
	 * <pre>
	 * Returns a RowManager_ViewerManager based on the current viewer.
	 * </pre>
	 * @return [OBJECT]
	 */
    function getViewerManager() 
    {
        if (is_null( $this->viewerMgr ) ) {
            $this->viewerMgr = new RowManager_ViewerManager( $this->getViewerID() );
        }
        return $this->viewerMgr;
    }
    
    
    
    //************************************************************************
	/**
	 * function hasGroupPriv
	 * <pre>
	 * returns wether or not this account has Group Level Priviledges 
	 * </pre> 
	 * @return [BOOL]
	 */
    function hasGroupPriv() 
    {
        $priv = (int) $this->getValueByFieldName('accountadminaccess_privilege');
        $sitePriv = RowManager_AccountAdminAccessManager::PRIVILEDGE_GROUP;
        return ( $priv == $sitePriv);
    }
    
    
    
    //************************************************************************
	/**
	 * function hasSitePriv
	 * <pre>
	 * returns wether or not this account has Site Level Priviledges 
	 * </pre> 
	 * @return [BOOL]
	 */
    function hasSitePriv() 
    {
        $priv = (int) $this->getValueByFieldName('accountadminaccess_privilege');
        $sitePriv = RowManager_AccountAdminAccessManager::PRIVILEDGE_SITE;
        return ( $priv == $sitePriv);
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
    
    
    
   //************************************************************************
	/**
	 * function setGroupPrivilege
	 * <pre>
	 * Sets the access privilege of the current viewer_id to GROUP
	 * </pre> 
	 * @return [void]
	 */
    function setGroupPrivilege()
    {
        $groupPriv = RowManager_AccountAdminAccessManager::PRIVILEDGE_GROUP;
        $this->setValueByFieldName( 'accountadminaccess_privilege', $groupPriv);
    }
    
    
    
    //************************************************************************
	/**
	 * function setSiteLevelAccess
	 * <pre>
	 * Sets the access priviledge of the current viewer_id to SITE
	 * </pre> 
	 * @return [void]
	 */
    function setSiteLevelAccess( ) 
    {
        $sitePriv = RowManager_AccountAdminAccessManager::PRIVILEDGE_SITE;
        $this->setValueByFieldName( 'accountadminaccess_privilege', $sitePriv );
    }
    
    
    
    //************************************************************************
	/**
	 * function setViewerID
	 * <pre>
	 * Sets the value of the current viewer_id 
	 * </pre> 
	 * @param $viewerID [INTEGER] new viewer_id
	 * @return [void]
	 */
    function setViewerID( $viewerID ) 
    {
        $this->setValueByFieldName( 'viewer_id', $viewerID );
    }

    
    	
}

?>