<?php
/**
 * @package AccountAdmin
 */ 
/**
 * class RowManager_AccountGroupManager
 * <pre> 
 * Organizes the viewer (login accounts) into different groups for easier management..
 * </pre>
 * @author Johnny Hausman
 */
class  RowManager_AccountGroupManager extends RowManager {

	//CONSTANTS:
	/** The name of the DB Table this class manages. */
    const DB_TABLE = 'accountadmin_accountgroup';
    
    /** The SQL description of the DB Table this class manages. */
    /*
     * accountgroup_id [INTEGER]  Primary Key for this table
     * accountgroup_key [STRING]  The label key for this group. (used to 
     *                  lookup in multilingual labels for display value)
     */
    const DB_TABLE_DESCRIPTION = " (
  accountgroup_id int(11) NOT NULL  auto_increment,
  accountgroup_key varchar(50) NOT NULL  default '',
  PRIMARY KEY (accountgroup_id)
) TYPE=MyISAM";
    
    /** The fields in the DB Table this class manages. */
    const FIELD_LIST = 'accountgroup_id,accountgroup_key';
    
    /** The XML node name for this entry. */
    const XML_NODE_NAME = 'accountgroup';
    

	//VARIABLES:


	//CLASS CONSTRUCTOR
	//************************************************************************
	/**
	 * function __construct
	 * <pre>
	 * Initialize this object.
	 * </pre>
	 * @param $accountGroupID [INTEGER] The unique id of the accountgroup we are managing.
	 * @return [void]
	 */
    function __construct( $accountGroupID=-1 ) 
    {
    
        $dbTableName = RowManager_AccountGroupManager::DB_TABLE;
        $fieldList = RowManager_AccountGroupManager::FIELD_LIST;
        $primaryKeyField = 'accountgroup_id';
        $primaryKeyValue = $accountGroupID;
        
        if (( $accountGroupID != -1 ) && ( $accountGroupID != '' )) {
        
            $condition = $primaryKeyField . '=' . $primaryKeyValue;
            
        } else {
            $condition = '';
        }
        $xmlNodeName = RowManager_AccountGroupManager::XML_NODE_NAME;
        parent::__construct( $dbTableName, $fieldList, $primaryKeyField, $primaryKeyValue, $condition, $xmlNodeName);
        
        $this->dbDescription = RowManager_AccountGroupManager::DB_TABLE_DESCRIPTION;
        
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
	 * function getKey
	 * <pre>
	 * Returns the Key to use in the RowLabelBridge routines.
	 * </pre>
	 * @return [STRING]
	 */
    function getKey() 
    {
        return $this->getValueByFieldName(  "accountgroup_key" );
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
        return "accountgroup_key";
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
        return "accountgroup_key";
    }
    
    
    
    //************************************************************************
	/**
	 * function setID
	 * <pre>
	 * Sets the accountgroup_id of this object.
	 * </pre>
	 * @param $id [INTEGER] the new accountgroup_id 
	 * @return [void]
	 */
    function setID( $id ) 
    {
        $this->setValueByFieldName( 'accountgroup_id', $id );
    }
    
    
    
    //************************************************************************
	/**
	 * function setKey
	 * <pre>
	 * Sets the accountgroup_key of this object.
	 * </pre>
	 * @param $key [STRING] the new accountgroup_key 
	 * @return [void]
	 */
    function setKey( $key ) 
    {
        $this->setValueByFieldName( 'accountgroup_key', $key );
    }

    
    	
}

?>