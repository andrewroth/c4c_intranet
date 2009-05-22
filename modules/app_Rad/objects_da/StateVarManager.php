<?php
/**
 * @package RAD
 */ 
/**
 * class RowManager_StateVarManager
 * <pre> 
 * Manages the state variables used to track the state of this module.
 * </pre>
 * @author Johnny Hausman
 */
class  RowManager_StateVarManager extends RowManager {

	//CONSTANTS:
	/** The name of the DB Table this class manages. */
    const DB_TABLE = 'rad_statevar';
    
    /** The fields in the DB Table this class manages. */
    const FIELD_LIST = 'statevar_id,module_id,statevar_name,statevar_desc,statevar_type,statevar_default,statevar_isCreated,statevar_isUpdated';
    
    /** The XML node name for this entry. */
    const XML_NODE_NAME = 'statevar';
    

	//VARIABLES:


	//CLASS CONSTRUCTOR
	//************************************************************************
	/**
	 * function __construct
	 * <pre>
	 * Initialize this object.
	 * </pre>
	 * @param $stateVarID [INTEGER] The unique id of the statevar we are managing.
	 * @return [void]
	 */
    function __construct( $stateVarID=-1 ) 
    {
    
        $dbTableName = RowManager_StateVarManager::DB_TABLE;
        $fieldList = RowManager_StateVarManager::FIELD_LIST;
        $primaryKeyField = 'statevar_id';
        $primaryKeyValue = $stateVarID;
        
        if (( $stateVarID != -1 ) && ( $stateVarID != '' )) {
        
            $condition = $primaryKeyField . '=' . $primaryKeyValue;
            
        } else {
            $condition = '';
        }
        $xmlNodeName = RowManager_StateVarManager::XML_NODE_NAME;
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
	 * function getConstName
	 * <pre>
	 * Returns the name of this state var's Constant Definition.
	 * </pre>
	 * @return [STRING]
	 */
    function getConstName() 
    {
        $name = $this->getName();
        
        return strtoupper( $name );
    }
    
    
    
    //************************************************************************
	/**
	 * function getDefaultValue
	 * <pre>
	 * Returns the default value of this state var
	 * </pre>
	 * @return [STRING]
	 */
    function getDefaultValue() 
    {
        return $this->getValueByFieldName( 'statevar_default' );
    }
    
    
    
    //************************************************************************
	/**
	 * function getDescription
	 * <pre>
	 * Returns the description of this state var
	 * </pre>
	 * @return [STRING]
	 */
    function getDescription() 
    {
        return $this->getValueByFieldName( 'statevar_desc' );
    }
    
    
    
    //************************************************************************
	/**
	 * function getID
	 * <pre>
	 * Returns the id of this state var
	 * </pre>
	 * @return [INTEGER]
	 */
    function getID() 
    {
        return $this->getValueByFieldName( 'statevar_id' );
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
        return 'statevar_name';
    }
    
    
    
    //************************************************************************
	/**
	 * function getName
	 * <pre>
	 * Returns the name of this state var
	 * </pre>
	 * @return [STRING]
	 */
    function getName() 
    {
        return $this->getValueByFieldName( 'statevar_name' );
    }
    
    
    
    //************************************************************************
	/**
	 * function getType
	 * <pre>
	 * Returns the type of this state var
	 * </pre>
	 * @return [STRING]
	 */
    function getType() 
    {
        return $this->getValueByFieldName( 'statevar_type' );
    }
    
    
    
    //************************************************************************
	/**
	 * function isCreated
	 * <pre>
	 * Returns the status of wether this item has already been updated
	 * </pre>
	 * @return [BOOL]
	 */
    function isCreated() 
    {
        // CODE
        $isCreated =  $this->getValueByFieldName( 'statevar_isCreated' );
        return ( (int) $isCreated == 1 );
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
        return $this->isUniqueFieldValue( $name, 'statevar_name', $condition );
    }
    
    
    
    //************************************************************************
	/**
	 * function setCreated
	 * <pre>
	 * Sets the status of this item to "created"
	 * </pre>
	 * @return [BOOL]
	 */
    function setCreated() 
    {
        $this->setValueByFieldName( 'statevar_isCreated', 1 );
        $this->updateDBTable();
    }
    
    
    
    //************************************************************************
	/**
	 * function setNotCreated
	 * <pre>
	 * Sets the status of this item to Not created
	 * </pre>
	 * @return [BOOL]
	 */
    function setNotCreated() 
    {
        $this->setValueByFieldName( 'statevar_isCreated', 0 );
        $this->updateDBTable();
    }

    
    	
}

?>