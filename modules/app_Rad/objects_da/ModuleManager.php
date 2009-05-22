<?php
/**
 * @package RAD
 */ 
/**
 * class RowManager_ModuleManager
 * <pre> 
 * Tracks the modules being managed by the RAD Tools.
 * </pre>
 * @author Johnny Hausman
 */
class  RowManager_ModuleManager extends RowManager {

	//CONSTANTS:
	/** The name of the DB Table this class manages. */
    const DB_TABLE = 'rad_module';
    
    /** The fields in the DB Table this class manages. */
    const FIELD_LIST = 'module_id,module_name,module_desc,module_creatorName,module_isCommonLook,module_isCore,module_isCreated';
    
    /** The XML node name for this entry. */
    const XML_NODE_NAME = 'module';
    

	//VARIABLES:


	//CLASS CONSTRUCTOR
	//************************************************************************
	/**
	 * function __construct
	 * <pre>
	 * Initialize this object.
	 * </pre>
	 * @param $moduleID [INTEGER] The unique id of the module we are managing.
	 * @return [void]
	 */
    function __construct( $moduleID=-1 ) 
    {
    
        $dbTableName = RowManager_ModuleManager::DB_TABLE;
        $fieldList = RowManager_ModuleManager::FIELD_LIST;
        $primaryKeyField = 'module_id';
        $primaryKeyValue = $moduleID;
        
        if (( $moduleID != -1 ) && ( $moduleID != '' )) {
        
            $condition = $primaryKeyField . '=' . $primaryKeyValue;
            
        } else {
            $condition = '';
        }
        $xmlNodeName = RowManager_ModuleManager::XML_NODE_NAME;
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
	 * function resetModule
	 * <pre>
	 * Reset the pieces of the Module to have their isCreated status reset
	 * </pre>
	 * @return [void]
	 */
    function resetModule() 
    {
        // first reset any associated State Variables
        $list = new StateVarList( $this->getModuleID() );
        $list->setFirst();
        while( $item = $list->getNext() ) {
            $item->setNotCreated();
        }
        
        // now reset any Data Access Objects
        $list = new DAObjList( $this->getModuleID() );
        $list->setFirst();
        while( $item = $list->getNext() ) {
            $item->setNotCreated();
        }
        
        // now reset any Page Objects
        $list = new PageList( $this->getModuleID() );
        $list->setFirst();
        while( $item = $list->getNext() ) {
            $item->setNotCreated();
        }
        
        // now remove any Transitions
        $list = new TransitionsList( $this->getModuleID() );
        $list->setFirst();
        while( $item = $list->getNext() ) {
            $item->setNotCreated();
        }
        
        // now call parent method
        $this->setNotCreated();
        
    }
    
    
    
    //************************************************************************
	/**
	 * function deleteEntry
	 * <pre>
	 * Removes the child entries of Module objects before removing self. 
	 * (Poor Man's Referential Integrity)
	 * </pre>
	 * @return [void]
	 */
    function deleteEntry() 
    {
        // first remove any associated State Variables
        $list = new StateVarList( $this->getModuleID() );
        $list->setFirst();
        while( $item = $list->getNext() ) {
            $item->deleteEntry();
        }
        
        // now remove any Data Access Objects
        $list = new DAObjList( $this->getModuleID() );
        $list->setFirst();
        while( $item = $list->getNext() ) {
            $item->deleteEntry();
        }
        
        // now remove any Page Objects
        $list = new PageList( $this->getModuleID() );
        $list->setFirst();
        while( $item = $list->getNext() ) {
            $item->deleteEntry();
        }
        
        // now remove any Transitions
        $list = new TransitionsList( $this->getModuleID() );
        $list->setFirst();
        while( $item = $list->getNext() ) {
            $item->deleteEntry();
        }
        
        // now call parent method
        parent::deleteEntry();
        
    }

    
    
    
    //************************************************************************
	/**
	 * function isCommonLook
	 * <pre>
	 * Returns wether or not the pages in this module share a common template.
	 * </pre>
	 * @return [void]
	 */
    function isCommonLook() 
    {
        $isCommonLook = $this->getValueByFieldName( 'module_isCommonLook' );
        return ( (int) $isCommonLook == 1 );
    }
    
    
    
    //************************************************************************
	/**
	 * function isCore
	 * <pre>
	 * Returns wether or not this is a Core module.  Core Modules don't have 
	 * the "app_" appended to their directory names.
	 * </pre>
	 * @return [void]
	 */
    function isCore() 
    {
        $isCore = $this->getValueByFieldName( 'module_isCore' );
        return ( (int) $isCore == 1 );
    }
    
    
    
    //************************************************************************
	/**
	 * function isCreated
	 * <pre>
	 * Returns the creation status of this module.
	 * </pre>
	 * @return [void]
	 */
    function isCreated() 
    {
        $isCreated = $this->getValueByFieldName( 'module_isCreated' );
        return ( (int) $isCreated == 1 );
    }
    
    
    
    //************************************************************************
	/**
	 * function isUniqueModuleName
	 * <pre>
	 * Verifies if the given name is unique.
	 * </pre>
	 * @param $name [STRING] the name we are checking 
	 * @return [BOOL]  True if Unique.  False otherwise.
	 */
    function isUniqueModuleName( $name = '') 
    {   
        return $this->isUniqueFieldValue( $name, 'module_name' );   
    }  
    
    
    
    //************************************************************************
	/**
	 * function getCreatorName
	 * <pre>
	 * Returns the current module's creator name
	 * </pre>
	 * @return [STRING]
	 */
    function getCreatorName() 
    {
        return $this->getValueByFieldName( 'module_creatorName' );
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
        return 'module_name';
    }
    
    
    
    //************************************************************************
	/**
	 * function getModuleDescription
	 * <pre>
	 * Returns the current module description
	 * </pre>
	 * @return [STRING]
	 */
    function getModuleDescription() 
    {
        return $this->getValueByFieldName( 'module_desc' );
    }
    
    
    
    //************************************************************************
	/**
	 * function getModuleID
	 * <pre>
	 * Returns the current module id
	 * </pre>
	 * @return [INTEGER]
	 */
    function getModuleID() 
    {
        // CODE
        return (int) $this->getValueByFieldName( 'module_id' );
    }
    
    
    
    //************************************************************************
	/**
	 * function getModuleName
	 * <pre>
	 * Returns the current module name
	 * </pre>
	 * @return [STRING]
	 */
    function getModuleName() 
    {
        return $this->getValueByFieldName( 'module_name' );
    }
    
    
    
    //************************************************************************
	/**
	 * function setCreated
	 * <pre>
	 * Updates this module as being created.
	 * </pre>
	 * @return [void]
	 */
    function setCreated() 
    {
        $this->setValueByFieldName( 'module_isCreated', 1 );
        $this->updateDBTable();
    }
    
    
    
    //************************************************************************
	/**
	 * function setNotCreated
	 * <pre>
	 * Updates this module as being NOT created.
	 * </pre>
	 * @return [void]
	 */
    function setNotCreated() 
    {
        $this->setValueByFieldName( 'module_isCreated', 0 );
        $this->updateDBTable();
    }


    
    	
}

?>