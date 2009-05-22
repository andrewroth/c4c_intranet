<?php
/**
 * @package [ModuleName]
 */ 
/**
 * class RowManager_[DAObj]
 * <pre> 
 * [DAObjDescription].
 * </pre>
 * @author [CreatorName]
 */
class  RowManager_[DAObj] extends RowManager {

	//CONSTANTS:
	/** The name of the DB Table this class manages. */
    const DB_TABLE = '[RAD_TABLENAME]';
    
    /** The SQL description of the DB Table this class manages. */
    /*
[RAD_DB_TABLE_DESCRIPTION_DOC]     */
    const DB_TABLE_DESCRIPTION = " (
[RAD_DB_TABLE_DESCRIPTION_SQL]) TYPE=MyISAM";
    
    /** The fields in the DB Table this class manages. */
    const FIELD_LIST = '[RAD_FIELDLIST_DEF]';
    
    /** The XML node name for this entry. */
    const XML_NODE_NAME = '[RAD_XML_NODENAME]';
    

	//VARIABLES:


	//CLASS CONSTRUCTOR
	//************************************************************************
	/**
	 * function __construct
	 * <pre>
	 * Initialize this object.
	 * </pre>
	 * @param $[RAD_STATEVAR] [INTEGER] The unique id of the [RAD_XML_NODENAME] we are managing.
	 * @return [void]
	 */
    function __construct( $[RAD_STATEVAR]=-1 ) 
    {
    
        $dbTableName = RowManager_[DAObj]::DB_TABLE;
        $fieldList = RowManager_[DAObj]::FIELD_LIST;
        $primaryKeyField = '[RAD_DAObj_PRIMARY_KEY_FIELD]';
        $primaryKeyValue = $[RAD_STATEVAR];
        
        if (( $[RAD_STATEVAR] != -1 ) && ( $[RAD_STATEVAR] != '' )) {
        
            $condition = $primaryKeyField . '=' . $primaryKeyValue;
            
        } else {
            $condition = '';
        }
        $xmlNodeName = RowManager_[DAObj]::XML_NODE_NAME;
        parent::__construct( $dbTableName, $fieldList, $primaryKeyField, $primaryKeyValue, $condition, $xmlNodeName);
        
        $this->dbDescription = RowManager_[DAObj]::DB_TABLE_DESCRIPTION;

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
	 * function getLabelField
	 * <pre>
	 * Returns the field to use in the label routines.
	 * </pre>
	 * @return [STRING]
	 */
    function getLabelField() 
    {
        return "[RAD_DAOBJ_LABEL_FIELD]";
    }

    
    	
}

?>