<?php
/**
 * @package RAD
 */ 
/**
 * class RowManager_DAFieldManager
 * <pre> 
 * Tracks each field that is part of a Data Access Object.
 * </pre>
 * @author Johnny Hausman
 */
class  RowManager_DAFieldManager extends RowManager {

	//CONSTANTS:
	/** The name of the DB Table this class manages. */
    const DB_TABLE = 'rad_dafield';
    
    /** The fields in the DB Table this class manages. */
    const FIELD_LIST = 'dafield_id,daobj_id,statevar_id,dafield_name,dafield_desc,dafield_type,dafield_dbType,dafield_formFieldType,dafield_isPrimaryKey,dafield_isForeignKey,dafield_isNullable,dafield_default,dafield_invalidValue,dafield_isLabelName,dafield_isListInit,dafield_isCreated,dafield_title,dafield_formLabel,dafield_example,dafield_error';
    
    /** The XML node name for this entry. */
    const XML_NODE_NAME = 'dafield';
    

	//VARIABLES:


	//CLASS CONSTRUCTOR
	//************************************************************************
	/**
	 * function __construct
	 * <pre>
	 * Initialize this object.
	 * </pre>
	 * @param $daFieldID [INTEGER] The unique id of the dafield we are managing.
	 * @return [void]
	 */
    function __construct( $daFieldID=-1 ) 
    {
    
        $dbTableName = RowManager_DAFieldManager::DB_TABLE;
        $fieldList = RowManager_DAFieldManager::FIELD_LIST;
        $primaryKeyField = 'dafield_id';
        $primaryKeyValue = $daFieldID;
        
        if (( $daFieldID != -1 ) && ( $daFieldID != '' )) {
        
            $condition = $primaryKeyField . '=' . $primaryKeyValue;
            
        } else {
            $condition = '';
        }
        $xmlNodeName = RowManager_DAFieldManager::XML_NODE_NAME;
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
	 * function getDBFieldTypeArray
	 * <pre>
	 * Returns an array of database field types. (used for template droplist)
	 * </pre>
	 * @return [ARRAY]
	 */
    function getDBFieldTypeArray() 
    {
    
        $fieldTypes = array();
        
        $fieldTypes[ 'int' ] = 'int';
        $fieldTypes[ 'varchar' ] = 'varchar';
        $fieldTypes[ 'text' ] = 'text';
        $fieldTypes[ 'date' ] = 'date';
        $fieldTypes[ 'time' ] = 'time';
        $fieldTypes[ 'datetime' ] = 'datetime';
        $fieldTypes[ 'timestamp' ] = 'timestamp';
        $fieldTypes[ 'enum' ] = 'enum';
        
        return $fieldTypes;
    }
    
    
    
    //************************************************************************
	/**
	 * function getDBType
	 * <pre>
	 * Returns the database field type of this field.
	 * </pre>
	 * @return [STRING]
	 */
    function getDBType() 
    {
        return $this->getValueByFieldName( 'dafield_dbType' );
    }
    
    
    
    //************************************************************************
	/**
	 * function getDefaultValue
	 * <pre>
	 * Returns the default value of this field.
	 * </pre>
	 * @return [STRING]
	 */
    function getDefaultValue() 
    {
        return $this->getValueByFieldName( 'dafield_default' );
    }
    
    
    
    //************************************************************************
	/**
	 * function getDescription
	 * <pre>
	 * Returns the description of this field.
	 * </pre>
	 * @return [STRING]
	 */
    function getDescription() 
    {
        return $this->getValueByFieldName( 'dafield_desc' );
    }
    
    
    
    //************************************************************************
	/**
	 * function getError
	 * <pre>
	 * Returns the error label of this field.
	 * </pre>
	 * @return [STRING]
	 */
    function getError() 
    {
        return $this->getValueByFieldName( 'dafield_error' );
    }
    
    
    
    //************************************************************************
	/**
	 * function getExample
	 * <pre>
	 * Returns the example label of this field.
	 * </pre>
	 * @return [STRING]
	 */
    function getExample() 
    {
        return $this->getValueByFieldName( 'dafield_example' );
    }
    
    
    
    //************************************************************************
	/**
	 * function getFieldTypeEntry
	 * <pre>
	 * Returns an entry used by FormProcessor Objects to manage this field.
	 * </pre>
	 * @return [STRING]
	 */
    function getFieldTypeEntry() 
    {
        $name = $this->getName();
        
        $type = '';
        switch( $this->getType() ) {
        
            case 'BOOL':
                $type = 'B';
                break;
                
            case 'DATE':
                $type = 'D';
                break;
                
            case 'FLOAT':
            case 'INTEGER':
                $type = 'N';
                break;
                
            default:
                $type = 'T';
                break;
        }
        
        $invalidValue = $this->getInvalidValue();
        
        return $name.'|'.$type.'|'.$invalidValue;
    }
    
    
    
    //************************************************************************
	/**
	 * function getFormEntryType
	 * <pre>
	 * Returns the desired form field type.
	 * </pre>
	 * @return [STRING]
	 */
    function getFormEntryType() 
    {
        return $this->getValueByFieldName( 'dafield_formFieldType' );
    }
    
    
    
    //************************************************************************
	/**
	 * function getFormLabel
	 * <pre>
	 * Returns the form label of this field.
	 * </pre>
	 * @return [STRING]
	 */
    function getFormLabel() 
    {
        return $this->getValueByFieldName( 'dafield_formLabel' );
    }
    
    
    
    //************************************************************************
	/**
	 * function getInvalidValue
	 * <pre>
	 * Returns the invalid value of this field.
	 * </pre>
	 * @return [STRING]
	 */
    function getInvalidValue() 
    {
        return $this->getValueByFieldName( 'dafield_invalidValue' );
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
        return 'dafield_name';
    }
    
    
    
    //************************************************************************
	/**
	 * function getName
	 * <pre>
	 * Returns the name of this field.
	 * </pre>
	 * @return [STRING]
	 */
    function getName() 
    {
        return $this->getValueByFieldName( 'dafield_name' );
    }
    
    
    
    //************************************************************************
	/**
	 * function getStateVar
	 * <pre>
	 * Returns the state var associated with this field.
	 * </pre>
	 * @return [STRING]
	 */
    function getStateVar() 
    {
        $stateVarID = $this->getValueByFieldName( 'statevar_id' );
        
        // 
//        if ((int) $stateVarID != -1) {
        
            $returnValue = new RowManager_StateVarManager( $stateVarID );
            
//        } else {
            
//            $returnValue = false;
//        }
        
        return $returnValue;
    }
    
    
    
    //************************************************************************
	/**
	 * function getTitle
	 * <pre>
	 * Returns the title label of this field.
	 * </pre>
	 * @return [STRING]
	 */
    function getTitle() 
    {
        return $this->getValueByFieldName( 'dafield_title' );
    }
    
    
    
    //************************************************************************
	/**
	 * function getType
	 * <pre>
	 * Returns the type of this field.
	 * </pre>
	 * @return [STRING]
	 */
    function getType() 
    {
        return $this->getValueByFieldName( 'dafield_type' );
    }
    
    
    
    //************************************************************************
	/**
	 * function isDateType
	 * <pre>
	 * Returns the status of this fields ability to be a NULL value.
	 * </pre>
	 * @return [BOOL]
	 */
    function isDateType() 
    {
        $type = $this->getType();
        
        return ( $type == 'DATE' );
    }
    
    
    
    //************************************************************************
	/**
	 * function isForeignKey
	 * <pre>
	 * Returns whether this field is a foreign key or not.
	 * </pre>
	 * @return [BOOL]
	 */
    function isForeignKey() 
    {
        $isForeignKey = $this->getValueByFieldName( 'dafield_isForeignKey' );
        
        return ( (int) $isForeignKey == 1);
    }
    
    
    
    //************************************************************************
	/**
	 * function isLabelName
	 * <pre>
	 * Returns whether this field is used to display the row label in a 
	 * Form Grid form.
	 * </pre>
	 * @return [BOOL]
	 */
    function isLabelName() 
    {
        $isLabelName = $this->getValueByFieldName( 'dafield_isLabelName' );
        
        return ( (int) $isLabelName == 1);
    }
    
    
    
    //************************************************************************
	/**
	 * function isListInit
	 * <pre>
	 * Returns whether this field is used to initialize the list iterator or not.
	 * </pre>
	 * @return [BOOL]
	 */
    function isListInit() 
    {
        $isListInit = $this->getValueByFieldName( 'dafield_isListInit' );
        
        return ( (int) $isListInit == 1);
    }
    
    
    
    //************************************************************************
	/**
	 * function isNullable
	 * <pre>
	 * Returns the status of this fields ability to be a NULL value.
	 * </pre>
	 * @return [BOOL]
	 */
    function isNullable() 
    {
        $isNullable = $this->getValueByFieldName( 'dafield_isNullable' );
        
        return ( (int) $isNullable == 1);
    }
    
    
    
    //************************************************************************
	/**
	 * function isPrimaryKey
	 * <pre>
	 * Returns whether this field is the primary key or not.
	 * </pre>
	 * @return [BOOL]
	 */
    function isPrimaryKey() 
    {
        $isPrimaryKey = $this->getValueByFieldName( 'dafield_isPrimaryKey' );
        
        return ( (int) $isPrimaryKey == 1);
    }
    
    
    
    //************************************************************************
	/**
	 * function isUniqueName
	 * <pre>
	 * Verifies if the given name is already taken (False) or not (True)
	 * </pre>
	 * @param $name [STRING] The name we are checking
	 * @param $daobjID [INTEGER] the id of the daObj we are searching
	 * @return [BOOL]
	 */
    function isUniqueName( $name='', $daobjID='') 
    {
    
        // if moduleID not provided, then use current value in object
        if ( $daobjID == '') {
            $daobjID = $this->getValueByFieldName( 'daobj_id' );
        }
        
        // if module id isn't empty
        $condition = '';
        if ( $daobjID != '') {
            $condition = 'daobj_id='.$daobjID;
        }

        // return unique field result
        return $this->isUniqueFieldValue( $name, 'dafield_name', $condition );
    }

    
    	
}

?>