<?php
/**
 * @package RAD
 */ 
/**
 * class RowManager_PageLabelsManager
 * <pre> 
 * Tracks any additional labels needed by a page..
 * </pre>
 * @author Johnny Hausman
 */
class  RowManager_PageLabelsManager extends RowManager {

	//CONSTANTS:
	/** The name of the DB Table this class manages. */
    const DB_TABLE = 'rad_pagelabels';
    
    /** The fields in the DB Table this class manages. */
    const FIELD_LIST = 'pagelabel_id,page_id,pagelabel_key,pagelabel_label,language_id,pagelabel_isCreated';
    
    /** The XML node name for this entry. */
    const XML_NODE_NAME = 'pagelabels';
    

	//VARIABLES:


	//CLASS CONSTRUCTOR
	//************************************************************************
	/**
	 * function __construct
	 * <pre>
	 * Initialize this object.
	 * </pre>
	 * @param $pageLabelID [INTEGER] The unique id of the pagelabels we are managing.
	 * @return [void]
	 */
    function __construct( $pageLabelID=-1 ) 
    {
    
        $dbTableName = RowManager_PageLabelsManager::DB_TABLE;
        $fieldList = RowManager_PageLabelsManager::FIELD_LIST;
        $primaryKeyField = 'pagelabel_id';
        $primaryKeyValue = $pageLabelID;
        
        if (( $pageLabelID != -1 ) && ( $pageLabelID != '' )) {
        
            $condition = $primaryKeyField . '=' . $primaryKeyValue;
            
        } else {
            $condition = '';
        }
        $xmlNodeName = RowManager_PageLabelsManager::XML_NODE_NAME;
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
	 * function getKey
	 * <pre>
	 * returns the label key.
	 * </pre>
	 * @return [STRING]
	 */
    function getKey() 
    {
        return $this->getValueByFieldName( 'pagelabel_key' );
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
        return 'pagelabel_label';
    }
    
    
    
    //************************************************************************
	/**
	 * function getLanguageID
	 * <pre>
	 * returns the label's language ID.
	 * </pre>
	 * @return [INTEGER]
	 */
    function getLanguageID() 
    {
        return $this->getValueByFieldName( 'language_id' );
    }
    
    
    
    //************************************************************************
	/**
	 * function isCreated
	 * <pre>
	 * returns the creation status of this object.
	 * </pre>
	 * @return [BOOL] True if created, False otherwise.
	 */
    function isCreated() 
    {
        return ( (int) $this->getValueByFieldName( 'pagelabel_isCreated' ) == 1);
    }
    
    
    
    //************************************************************************
	/**
	 * function setCreated
	 * <pre>
	 * marks this object as being created.
	 * </pre>
	 * @return [INTEGER]
	 */
    function setCreated() 
    {
        $this->setValueByFieldName( 'pagelabel_isCreated', 1 );
        $this->updateDBTable();
    }
    
    
    
    //************************************************************************
	/**
	 * function setNotCreated
	 * <pre>
	 * marks this object as NOT being created.
	 * </pre>
	 * @return [INTEGER]
	 */
    function setNotCreated() 
    {
        $this->setValueByFieldName( 'pagelabel_isCreated', 0 );
        $this->updateDBTable();
    }


    
    	
}

?>