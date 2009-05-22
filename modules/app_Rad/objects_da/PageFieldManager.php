<?php
/**
 * @package RAD
 */ 
/**
 * class RowManager_PageFieldManager
 * <pre> 
 * links a page to the DA Obj fields it uses..
 * </pre>
 * @author Johnny Hausman
 */
class  RowManager_PageFieldManager extends RowManager {

	//CONSTANTS:
	/** The name of the DB Table this class manages. */
    const DB_TABLE = 'rad_pagefield';
    
    /** The fields in the DB Table this class manages. */
    const FIELD_LIST = 'pagefield_id,page_id,daobj_id,dafield_id,pagefield_isForm';
    
    /** The XML node name for this entry. */
    const XML_NODE_NAME = 'pagefield';
    

	//VARIABLES:


	//CLASS CONSTRUCTOR
	//************************************************************************
	/**
	 * function __construct
	 * <pre>
	 * Initialize this object.
	 * </pre>
	 * @param $initValue [INTEGER] The unique id of the pagefield we are managing.
	 * @return [void]
	 */
    function __construct( $initValue=-1 ) 
    {
    
        $dbTableName = RowManager_PageFieldManager::DB_TABLE;
        $fieldList = RowManager_PageFieldManager::FIELD_LIST;
        $primaryKeyField = 'pagefield_id';
        $primaryKeyValue = $initValue;
        
        if (( $initValue != -1 ) && ( $initValue != '' )) {
        
            $condition = $primaryKeyField . '=' . $primaryKeyValue;
            
        } else {
            $condition = '';
        }
        $xmlNodeName = RowManager_PageFieldManager::XML_NODE_NAME;
        parent::__construct( $dbTableName, $fieldList, $primaryKeyField, $primaryKeyValue, $condition, $xmlNodeName, RADTOOL_DB_NAME, RADTOOL_DB_PATH, RADTOOL_DB_USER, RADTOOL_DB_PWORD);
        
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
	 * function getDAField
	 * <pre>
	 * Gets the DA Field Object referenced by the current dafield_id field
	 * </pre>
	 * @return [OBJECT]
	 */
    function getDAField() 
    {
        $fieldID = $this->getFieldID();
        return new RowManager_DAFieldManager( $fieldID );
    }
    
    
    
    //************************************************************************
	/**
	 * function getFieldID
	 * <pre>
	 * Gets the value of the dafield_id field
	 * </pre>
	 * @return [INTEGER]
	 */
    function getFieldID() 
    {
        return $this->getValueByFieldName( 'dafield_id' );
    }
    
    
    
    //************************************************************************
	/**
	 * function getID
	 * <pre>
	 * Gets the value of the pagefield_id field
	 * </pre>
	 * @return [INTEGER]
	 */
    function getID() 
    {
        $this->getValueByFieldName( 'pagefield_id' );
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
	 * function setDAFieldID
	 * <pre>
	 * Sets the value of the Data Access Field ID
	 * </pre>
	 * @param $value [INTEGER] the value for the DA Field ID
	 * @return [void]
	 */
    function setDAFieldID( $value ) 
    {
        $this->setValueByFieldName( 'dafield_id', $value );
    }
    
    
    
    //************************************************************************
	/**
	 * function setDAObjID
	 * <pre>
	 * Sets the value of the Data Access Object ID
	 * </pre>
	 * @param $value [INTEGER] the value for the DAObj ID
	 * @return [void]
	 */
    function setDAObjID( $value ) 
    {
        $this->setValueByFieldName( 'daobj_id', $value );
    }
    
    
    
    //************************************************************************
	/**
	 * function setPageID
	 * <pre>
	 * Sets the value of the Page ID
	 * </pre>
	 * @param $value [INTEGER] the value for the Page ID
	 * @return [void]
	 */
    function setPageID( $value ) 
    {
        $this->setValueByFieldName( 'page_id', $value );
    }
    
    
    
    //************************************************************************
	/**
	 * function setIsForm
	 * <pre>
	 * Sets the value of the isForm field
	 * </pre>
	 * @param $value [INTEGER] the value for the isForm field
	 * @return [void]
	 */
    function setIsForm( $value ) 
    {
        $this->setValueByFieldName( 'pagefield_isForm', $value );
    }

    
    	
}

?>