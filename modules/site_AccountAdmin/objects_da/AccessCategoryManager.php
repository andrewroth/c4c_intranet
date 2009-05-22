<?php
/**
 * @package AccountAdmin
 */ 
/**
 * class RowManager_AccessCategoryManager
 * <pre> 
 * Organizes the access groups into categories for easier management..
 * </pre>
 * @author Johnny Hausman
 */
class  RowManager_AccessCategoryManager extends RowManager {

	//CONSTANTS:
	/** The name of the DB Table this class manages. */
    const DB_TABLE = 'accountadmin_accesscategory';
    
    /** The SQL description of the DB Table this class manages. */
    /*
     * accesscategory_id [INTEGER]  Primary Key for this field.
     * accesscategory_key [STRING]  The Label lookup key for this category
     */
    const DB_TABLE_DESCRIPTION = " (
  accesscategory_id int(11) NOT NULL  auto_increment,
  accesscategory_key varchar(50) NOT NULL  default '',
  PRIMARY KEY (accesscategory_id)
) TYPE=MyISAM";
    
    /** The fields in the DB Table this class manages. */
    const FIELD_LIST = 'accesscategory_id,accesscategory_key';
    
    /** The XML node name for this entry. */
    const XML_NODE_NAME = 'accesscategory';
    

	//VARIABLES:


	//CLASS CONSTRUCTOR
	//************************************************************************
	/**
	 * function __construct
	 * <pre>
	 * Initialize this object.
	 * </pre>
	 * @param $accessCategoryID [INTEGER] The unique id of the accesscategory we are managing.
	 * @return [void]
	 */
    function __construct( $accessCategoryID=-1 ) 
    {
    
        $dbTableName = RowManager_AccessCategoryManager::DB_TABLE;
        $fieldList = RowManager_AccessCategoryManager::FIELD_LIST;
        $primaryKeyField = 'accesscategory_id';
        $primaryKeyValue = $accessCategoryID;
        
        if (( $accessCategoryID != -1 ) && ( $accessCategoryID != '' )) {
        
            $condition = $primaryKeyField . '=' . $primaryKeyValue;
            
        } else {
            $condition = '';
        }
        $xmlNodeName = RowManager_AccessCategoryManager::XML_NODE_NAME;
        parent::__construct( $dbTableName, $fieldList, $primaryKeyField, $primaryKeyValue, $condition, $xmlNodeName);
        
        $this->dbDescription = RowManager_AccessCategoryManager::DB_TABLE_DESCRIPTION;
        
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
	 * function getKey
	 * <pre>
	 * Returns the key of this object.
	 * </pre>
	 * @return [STRING]
	 */
    function getKey() 
    {
        return $this->getValueByFieldName( 'accesscategory_key' );
    }    
    
    
    
    //************************************************************************
	/**
	 * function getKeyField
	 * <pre>
	 * Returns the key field of this object.
	 * </pre>
	 * @return [STRING]
	 */
    function getKeyField() 
    {
        return 'accesscategory_key';
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
        return "accesscategory_key";
    }
    
    
    
    //************************************************************************
	/**
	 * function getName
	 * <pre>
	 * Returns the name (key) of this object.
	 * </pre>
	 * @return [STRING]
	 */
    function getName() 
    {
        return $this->getKey();

    }
    
    
    
    //************************************************************************
	/**
	 * function setID
	 * <pre>
	 * Sets the accesscategory_id of this object.
	 * </pre>
	 * @param $id [INTEGER] the new accesscategory_id 
	 * @return [void]
	 */
    function setID( $id ) 
    {
        $this->setValueByFieldName( 'accesscategory_id', $id );
    }
    
    
    
    //************************************************************************
	/**
	 * function setKey
	 * <pre>
	 * Sets the accesscategory_key of this object.
	 * </pre>
	 * @param $key [STRING] the new accesscategory_key 
	 * @return [void]
	 */
    function setKey( $key ) 
    {
        $this->setValueByFieldName( 'accesscategory_key', $key );
    }

    
    	
}

?>