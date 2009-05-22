<?php
/**
 * class RowManager_[TableName]Manager
 * <pre> 
 * [description]
 * </pre>
 * @author [author]
 */
class  RowManager_[TableName]Manager extends RowManager {

	//CONSTANTS:
	/** The name of the DB Table this class manages. */
    const DB_TABLE = '[application]_[tableName]';
    
    /** The SQL description of the DB Table this class manages. */
    /*
     * episode_id [INTEGER]  Unique identifier (Primary Key)
     * episode_title [STRING]  The title of the episode we love so much
     */
    const DB_TABLE_DESCRIPTION = " (
  episode_id int(11) NOT NULL  auto_increment,
  episode_title varchar(50) NOT NULL  default '',
  PRIMARY KEY (episode_id)
) TYPE=MyISAM";
    
    /** The fields in the DB Table this class manages. */
    const FIELD_LIST = 'episode_id,episode_title';
    
    /** The primary key field in the DB Table */
    const PRIMARYKEY_FIELD = 'episode_id';
    
    /** The XML node name for this entry. */
    const XML_NODE_NAME = '[tableName]';
    

	//VARIABLES:


	//CLASS CONSTRUCTOR
	//************************************************************************
	/**
	 * function __construct
	 * <pre>
	 * Initialize this object.
	 * </pre>
	 * @param $initID [INTEGER] The unique id of the episode we are managing.
	 * @return [void]
	 */
    function __construct( $initID=-1 ) 
    {
    
        $dbTableName = RowManager_[TableName]Manager::DB_TABLE;
        $fieldList = RowManager_[TableName]Manager::FIELD_LIST;
        $primaryKeyField = RowManager_[TableName]Manager::PRIMARYKEY_FIELD;
        $primaryKeyValue = $initID;
        
        if (( $initID != -1 ) && ( $initID != '' )) {
        
            $condition = $primaryKeyField . '=' . $primaryKeyValue;
            
        } else {
            $condition = '';
        }
        $xmlNodeName = RowManager_[TableName]Manager::XML_NODE_NAME;
        parent::__construct( $dbTableName, $fieldList, $primaryKeyField, $primaryKeyValue, $condition, $xmlNodeName);
        
        $this->dbDescription = RowManager_[TableName]Manager::DB_TABLE_DESCRIPTION;
        
        if ($this->isLoaded() == false) {
        
            // uncomment this line if you want the Manager to automatically 
            // create a new entry if the given info doesn't exist.
            // $this->createNewEntry();
        }
    }



	//CLASS METHODS:
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
        //$this->setValueByFieldName( 'episode_title', $title );
    }
    
    
    
    //CLASS METHODS:
    
    
    
    
    //************************************************************************
	/**
	 * function getLabelField
	 * <pre>
	 * Returns the value commonly used for displaying as a Label (Form Grid
	 * rows, Drop List Labels, etc...).
	 * </pre>
	 * @return [STRING]
	 */
    function getLabelField() 
    {
        return 'noFieldProvided';
    }

}

?>