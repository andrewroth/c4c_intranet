<?php
/**
 * @package cim_newaccount
 */ 
/**
 * class RowManager_ViewerManager
 * <pre> 
 * This manages the viewer table..
 * </pre>
 * @author CIM
 */
//Names user manager as there is a global class called viewer manager.
class  RowManager_UserManager extends RowManager {

	//CONSTANTS:
	/** The name of the DB Table this class manages. */
    const DB_TABLE = 'accountadmin_viewer';
    
    /** The SQL description of the DB Table this class manages. */
    /*
     * viewer_id [INTEGER]  This is the key to the table.
     * accountgroup_id [INTEGER]  This is the accountgroup the account is in.
     * viewer_userID [STRING]  This is the username for the viewer.
     * viewer_passWord [STRING]  This is the user's password.
     * language_id [INTEGER]  This is the language id for the viewer.
     * viewer_isActive [INTEGER]  This is true if the viewer is active.
     * viewer_lastLogin [DATE]  This is the last time the viewer logged into the system.
     */
    const DB_TABLE_DESCRIPTION = " (
  viewer_id int(11) NOT NULL  auto_increment,
  guid varchar(64) NOT NULL  default '',
  accountgroup_id int(11) NOT NULL  default '0',
  viewer_userID varchar(50) NOT NULL  default '',
  viewer_passWord varchar(50) NOT NULL  default '',
  language_id int(11) NOT NULL  default '0',
  viewer_isActive int(1) NOT NULL  default '0',
  viewer_lastLogin date NOT NULL  default '0000-00-00',
  PRIMARY KEY (viewer_id)
) TYPE=MyISAM";
    
    /** The fields in the DB Table this class manages. */
    const FIELD_LIST = 'viewer_id,guid,accountgroup_id,viewer_userID,viewer_passWord,language_id,viewer_isActive,viewer_lastLogin';
    
    /** The XML node name for this entry. */
    const XML_NODE_NAME = 'viewer';
    

	//VARIABLES:


	//CLASS CONSTRUCTOR
	//************************************************************************
	/**
	 * function __construct
	 * <pre>
	 * Initialize this object.
	 * </pre>
	 * @param $ViewerID [INTEGER] The unique id of the viewer we are managing.
	 * @return [void]
	 */
    function __construct( $ViewerID=-1 ) 
    {
    
        $dbTableName = RowManager_ViewerManager::DB_TABLE;
        $fieldList = RowManager_ViewerManager::FIELD_LIST;
        $primaryKeyField = 'viewer_id';
        $primaryKeyValue = $ViewerID;
        
        if (( $ViewerID != -1 ) && ( $ViewerID != '' )) {
        
            $condition = $primaryKeyField . '=' . $primaryKeyValue;
            
        } else {
            $condition = '';
        }
        $xmlNodeName = RowManager_ViewerManager::XML_NODE_NAME;
        parent::__construct( $dbTableName, $fieldList, $primaryKeyField, $primaryKeyValue, $condition, $xmlNodeName);
        
        $this->dbDescription = RowManager_ViewerManager::DB_TABLE_DESCRIPTION;

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
	 * Removes the DB table entry.  Also, since this table also has linked
	 * items in the viewer access group table, it makes sure those are removed
	 * as well.
	 * </pre>
	 * @return [void]
	 */
    function deleteEntry() 
    {  
    
        // get a viewerAccessGroup manager
        $viewerAccess = new RowManager_ViewerAccessGroupManager();
        
        // now update it so that it's condition is based on this viewer id
        $condition = $this->getPrimaryKeyField().'='.$this->getID();
        
        $viewerAccess->setDBCondition( $condition );
        $viewerAccess->deleteEntry();
        
        // now continue with remove of this entry...
        parent::deleteEntry();
    
    }
    
    
    
    //************************************************************************
	/**
	 * function encryptPassword
	 * <pre>
	 * Encrypts a given password for safe storage in the DB.
	 * </pre>
	 * @param $passWord [STRING] the UNENCRYPTED form of the password
	 * @return [STRING]
	 */
    function encryptPassword( $passWord ) 
    {
        return md5( $passWord );
    }
    
    
    
    //************************************************************************
	/**
	 * function isUniqueUserID
	 * <pre>
	 * Verifies that the given UserID is not already taken by the system.
	 * </pre>
	 * @param $userID [STRING] The user id to examine
	 * @return [BOOL]
	 */
    function isUniqueUserID( $userID='' ) 
    {  
        return $this->isUniqueFieldValue( $userID, 'viewer_userID');
    }
    
    
    
    //************************************************************************
	/**
	 * function isActive
	 * <pre>
	 * Returns wether or not this account is active.
	 * </pre>
	 * @return [BOOL]
	 */
    function isActive() 
    {
        return ((int) $this->getValueByFieldName( 'viewer_isActive' ) == 1);
    }
    
    
    
    //************************************************************************
	/**
	 * function getAccountAdminAccessPriviledgeObject
	 * <pre>
	 * Returns the object managing this viewers access priviledge into the 
	 * account admin module. 
	 * </pre>
	 * @return [OBJECT]
	 */
    function getAccountAdminAccessPriviledgeObject() 
    {
        // if accountAdminAccessPriv object has not been initialzied then
        if ( is_null( $this->accountAdminAccessPriv ) ) {
            
            // create a new instance and load it for this viewer
            $this->accountAdminAccessPriv = new RowManager_AccountAdminAccessManager( );
            $this->accountAdminAccessPriv->loadByViewerID( $this->getID() );
        }
        
        return $this->accountAdminAccessPriv;
    }
    
    
    
    //************************************************************************
	/**
	 * function getAccountGroupID
	 * <pre>
	 * Returns the value of the current object's Account Group ID 
	 * </pre>
	 * @return [INTEGER]
	 */
    function getAccountGroupID() 
    {
        return (int) $this->getValueByFieldName( 'accountgroup_id' );
    }
    
    
    
    //************************************************************************
	/**
	 * function getJoinOnAccountGroupID
	 * <pre>
	 * Returns the accountgroup_id field for use in multitable joins.
	 * </pre>
	 * @return [STRING]
	 */
    function getJoinOnAccountGroupID() 
    {
        return $this->getJoinOnFieldX(  "accountgroup_id" );
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
        return "viewer_userID";
    }
    
    
    
    //************************************************************************
	/**
	 * function getLanguageID
	 * <pre>
	 * Returns the value of the current object's Language ID.
	 * </pre>
	 * @return [INTEGER]
	 */
    function getLanguageID() 
    {
        return (int) $this->getValueByFieldName( 'language_id' );
    }
    
    
    
    //************************************************************************
	/**
	 * function getPassword
	 * <pre>
	 * Returns the value of the current object's viewer password.
	 * </pre>
	 * @return [STRING]
	 */
    function getPassword()
    {
        return $this->getValueByFieldName('viewer_passWord');
    }
    
    
    
    //************************************************************************
	/**
	 * function getRegionID
	 * <pre>
	 * Returns the value of the current object's Region ID 
	 * NOTE: same as accountgroup_id.
	 * </pre>
	 * @return [INTEGER]
	 */
    function getRegionID() 
    {
        return $this->getAccountGroupID();
    }
    
    
    
    //************************************************************************
	/**
	 * function getUserID
	 * <pre>
	 * Returns the value of the current object's User ID.
	 * </pre>
	 * @return [STRING]
	 */
    function getUserID() 
    {
        return $this->getValueByFieldName( 'viewer_userID' );
    }
    
    
    
    //************************************************************************
	/**
	 * function loadByUserID
	 * <pre>
	 * Attempts to load this Viewer Account given a UserID.
	 * </pre>
	 * @param $userID [STRING] the user id of the accout to load
	 * @return [BOOL]
	 */
    function loadByUserID( $userID ) 
    {
        $condition = ' viewer_userID="'.$userID.'" ';
        
        return $this->loadByCondition( $condition );
    }
    
    
    
    //************************************************************************
	/**
	 * function loadByUserIDPWord
	 * <pre>
	 * Attempts to load this Viewer Account given a UserID & PWord.
	 * </pre>
	 * @param $userID [STRING] the user id of the accout to load
	 * @param $passWord [STRING] the password of the account to load
	 * @return [BOOL]
	 */
    function loadByUserIDPWord( $userID, $passWord ) 
    {
    
        // encrypt password
        $encryptedPassWord = $this->encryptPassWord( $passWord );
        
        $condition = 'viewer_userID="'.$userID.'" AND viewer_passWord="'.$encryptedPassWord.'" ';

        return $this->loadByCondition( $condition );
    }
    
    
    
    //************************************************************************
	/**
	 * function setAccountGroupID
	 * <pre>
	 * Sets the accountgroup_id of this object.
	 * </pre>
	 * @param $id [INTEGER] the new accountgroup_id 
	 * @return [void]
	 */
    function setAccountGroupID( $id ) 
    {
        $this->setValueByFieldName( 'accountgroup_id', $id );
    }
    
    
    
    //************************************************************************
	/**
	 * function setID
	 * <pre>
	 * Sets the viewer_id of this object.
	 * </pre>
	 * @param $id [INTEGER] the new viewer_id 
	 * @return [void]
	 */
    function setID( $id ) 
    {
        $this->setValueByFieldName( 'viewer_id', $id );
    }
    
    
    
    //************************************************************************
	/**
	 * function setIsActive
	 * <pre>
	 * Sets the value of the current object's viewer_isActive.
	 * </pre>
	 * @param $isActive [BOOL] The new viewer_isActive to use.
	 * @return [void]
	 */
    function setIsActive( $isActive ) 
    {
        $this->setValueByFieldName( 'viewer_isActive', $isActive );
    }
    
    
    
    //************************************************************************
	/**
	 * function setLanguageID
	 * <pre>
	 * Sets the value of the current object's Language ID.
	 * </pre>
	 * @param $languageID [INTEGER] The new language ID to use.
	 * @return [void]
	 */
    function setLanguageID( $languageID ) 
    {
        $this->setValueByFieldName( 'language_id', $languageID );
    }
    
    
    
    //************************************************************************
	/**
	 * function setLastLogin
	 * <pre>
	 * Set's the value of the last login field for this entry.
	 * </pre>
	 * @param $date [DATE] the date of the last login
	 * @return [void]
	 */
    function setLastLogin( $date=null ) 
    {
        if ( is_null( $date ) ) {
            $date = date("Y-m-d");
        }
        
        $this->setValueByFieldName( 'viewer_lastLogin', $date );
    }
    
    
    
    //************************************************************************
	/**
	 * function setPassWord
	 * <pre>
	 * Set's the value of the password for this entry.
	 * </pre>
	 * @param $passWord [STRING] the UNENCRYPTED form of the password
	 * @return [void]
	 */
    function setPassWord( $passWord ) 
    {
        $encryptedPassWord = $this->encryptPassword( $passWord );
        
        $this->setValueByFieldName( 'viewer_passWord', $encryptedPassWord );
    }
    
    
    
    //************************************************************************
	/**
	 * function setPassWordEncrypted
	 * <pre>
	 * Set's the value of the password for this entry.
	 * </pre>
	 * @param $passWord [STRING] the encrypted password
	 * @return [void]
	 */
    function setPassWordEncrypted( $passWord ) 
    {
        $this->setValueByFieldName( 'viewer_passWord', $passWord );
    }
    
    
    
    //************************************************************************
	/**
	 * function setUserID
	 * <pre>
	 * Set's the value of the viewer_userID for this entry.
	 * </pre>
	 * @param $userID [STRING] the new viewer_userID
	 * @return [void]
	 */
    function setUserID( $userID ) 
    {
        $this->setValueByFieldName( 'viewer_userID', $userID );
    }
    
    	
}

?>