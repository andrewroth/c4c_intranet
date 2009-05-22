<?php
/**
 * @package RAD
 */ 
/**
 * class RowManager_DAObjManager
 * <pre> 
 * Manages the Data Access Objects for this module..
 * </pre>
 * @author Johnny Hausman
 */
class  RowManager_DAObjManager extends RowManager {

	//CONSTANTS:
	/** The name of the DB Table this class manages. */
    const DB_TABLE = 'rad_daobj';
    
    /** The fields in the DB Table this class manages. */
    const FIELD_LIST = 'daobj_id,module_id,daobj_name,daobj_desc,daobj_dbTableName,daobj_managerInitVarID,daobj_listInitVarID,daobj_isCreated,daobj_isUpdated';
    
    /** The XML node name for this entry. */
    const XML_NODE_NAME = 'daobj';
    

	//VARIABLES:


	//CLASS CONSTRUCTOR
	//************************************************************************
	/**
	 * function __construct
	 * <pre>
	 * Initialize this object.
	 * </pre>
	 * @param $daObjID [INTEGER] The unique id of the daobj we are managing.
	 * @return [void]
	 */
    function __construct( $daObjID=-1 ) 
    {
    
        $dbTableName = RowManager_DAObjManager::DB_TABLE;
        $fieldList = RowManager_DAObjManager::FIELD_LIST;
        $primaryKeyField = 'daobj_id';
        $primaryKeyValue = $daObjID;
        
        if (( (int) $daObjID != -1 ) && ( $daObjID != '' )) {
        
            $condition = $primaryKeyField . '=' . $primaryKeyValue;
            
        } else {
            $condition = '';
        }
        $xmlNodeName = RowManager_DAObjManager::XML_NODE_NAME;
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
	 * function deleteEntry
	 * <pre>
	 * Removes the child entries of daField objects before removing self.
	 * </pre>
	 * @return [void]
	 */
    function deleteEntry() 
    {
        // first remove any associated fields with this DAObj
        $daFieldList = new DAFieldList( $this->getID() );
        $daFieldList->setFirst();
        while( $field = $daFieldList->getNext() ) {
            $field->deleteEntry();
        }
        
        // now call parent method
        parent::deleteEntry();
        
    }
    
    
    
    //************************************************************************
	/**
	 * function getDBTableName
	 * <pre>
	 * returns the name of the db table this DAObj manages.
	 * </pre>
	 * @return [STRING]
	 */
    function getDBTableName() 
    {
        return $this->getValueByFieldName( 'daobj_dbTableName' );
    }
    
    
    
    //************************************************************************
	/**
	 * function getDescription
	 * <pre>
	 * returns the description of this DAObj.
	 * </pre>
	 * @return [STRING]
	 */
    function getDescription() 
    {
        return $this->getValueByFieldName( 'daobj_desc' );
    }
    
    
    
    //************************************************************************
	/**
	 * function getFieldList
	 * <pre>
	 * returns a DAFieldList object of the fields linked to this DAObj.
	 * </pre>
	 * @return [OBJECT]
	 */
    function getFieldList() 
    {
        $daObjID = $this->getValueByFieldName( 'daobj_id' );
     
        return new DAFieldList( $daObjID );
    }
    
    
    
    //************************************************************************
	/**
	 * function getFormInitStateVar
	 * <pre>
	 * Returns the state var associated with the initialization of the Manager.
	 * </pre>
	 * @return [STRING]
	 */
    function getFormInitStateVar() 
    {
        $stateVarID = $this->getValueByFieldName( 'daobj_managerInitVarID' );
        
        return new RowManager_StateVarManager( $stateVarID );
    }
    
    
    
    //************************************************************************
	/**
	 * function getID
	 * <pre>
	 * returns the value of the daobj_id tracked by the Object.
	 * </pre>
	 * @return [INTEGER]
	 */
    function getID() 
    {
        return $this->getValueByFieldName( 'daobj_id' );
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
        return 'daobj_name';
    }

    
    
    
    //************************************************************************
	/**
	 * function getListInitStateVar
	 * <pre>
	 * Returns the state var associated with the initialization of the List.
	 * </pre>
	 * @return [STRING]
	 */
    function getListInitStateVar() 
    {
        $stateVarID = $this->getValueByFieldName( 'daobj_listInitVarID' );
        
        return new RowManager_StateVarManager( $stateVarID );
    }
    
    
    
    //************************************************************************
	/**
	 * function getListIteratorName
	 * <pre>
	 * returns the name of this DAObj's List Iterator.
	 * </pre>
	 * @return [OBJECT]
	 */
    function getListIteratorName() 
    {
        $name = ucwords( $this->getValueByFieldName( 'daobj_name' ) ).'List';
        return $name;
    }
    
    
    
    //************************************************************************
	/**
	 * function getManagerInitVarID
	 * <pre>
	 * returns the value of the daobj_managerInitVarID tracked by the Object.
	 * </pre>
	 * @return [INTEGER]
	 */
    function getManagerInitVarID() 
    {
        return $this->getValueByFieldName( 'daobj_managerInitVarID' );
    }
    
    
    
    //************************************************************************
	/**
	 * function getManagerName
	 * <pre>
	 * returns the name of this DAObj's Row Manager.
	 * </pre>
	 * @return [OBJECT]
	 */
    function getManagerName() 
    {
        $name = ucwords( $this->getValueByFieldName( 'daobj_name' ) ).'Manager';
        return $name;
    }    
    
    
    
    //************************************************************************
	/**
	 * function getModuleID
	 * <pre>
	 * returns the value of the module_id tracked by the Object.
	 * </pre>
	 * @return [INTEGER]
	 */
    function getModuleID() 
    {
        return $this->getValueByFieldName( 'module_id' );
    }
    
    
    
    //************************************************************************
	/**
	 * function getName
	 * <pre>
	 * returns the name of this DAObj.
	 * </pre>
	 * @return [OBJECT]
	 */
    function getName() 
    {
        return $this->getValueByFieldName( 'daobj_name' );
    }
    
    
    
    //************************************************************************
	/**
	 * function isCreated
	 * <pre>
	 * returns the creation status of this data access object.
	 * </pre>
	 * @return [BOOL] True if created, False otherwise.
	 */
    function isCreated() 
    {
        return ( (int) $this->getValueByFieldName( 'daobj_isCreated' ) == 1);
    }
    
    
    
    //************************************************************************
	/**
	 * function isUniqueName
	 * <pre>
	 * Verifies if the given name is already taken (False) or not (True)
	 * </pre>
	 * @param $name [STRING] The name we are checking
	 * @param $moduleID [INTEGER] the id of the module we are searching
	 * @return [BOOL]
	 */
    function isUniqueName( $name='', $moduleID='') 
    {
    
        // if moduleID not provided, then use current value in object
        if ( $moduleID == '') {
            $moduleID = $this->getValueByFieldName( 'module_id' );
        }
        
        // if module id isn't empty
        $condition = '';
        if ( $moduleID != '') {
            $condition = 'module_id='.$moduleID;
        }

        // return unique field result
        return $this->isUniqueFieldValue( $name, 'daobj_name', $condition );
    }
    
    
    
    //************************************************************************
	/**
	 * function setCreated
	 * <pre>
	 * Sets the status of this object to NOT Created.
	 * </pre>
	 * @return [INTEGER]
	 */
    function setCreated() 
    {
        $this->setValueByFieldName( 'daobj_isCreated', 1 );
        $this->updateDBTable();
    }
    
    
    
    //************************************************************************
	/**
	 * function setNotCreated
	 * <pre>
	 * Sets the status of this object to NOT Created.
	 * </pre>
	 * @return [INTEGER]
	 */
    function setNotCreated() 
    {
        $this->setValueByFieldName( 'daobj_isCreated', 0 );
        $this->updateDBTable();
    }

    
    	
}

?>