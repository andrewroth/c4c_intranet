<?php
/**
 * class RowManager_SeriesManager
 * <pre> 
 * [description]
 * </pre>
 * @author Will Schuurman
 */
class  RowManager_SeriesManager extends RowManager {

	//CONSTANTS:
	/** The name of the DB Table this class manages. */
    const DB_TABLE = 'tvaddicts_series';
    
    /** The SQL description of the DB Table this class manages. */
    /*
     * series_id [INTEGER]  Unique identifier (Primary Key)
     * series_title [STRING]  The title of the series we love so much
     */
    const DB_TABLE_DESCRIPTION = " (
  series_id int(11) NOT NULL  auto_increment,
  series_title varchar(50) NOT NULL  default '',
  PRIMARY KEY (series_id)
) TYPE=MyISAM";
    
    /** The fields in the DB Table this class manages. */
    const FIELD_LIST = 'series_id,series_title';
    
    /** The primary key field in the DB Table */
    const PRIMARYKEY_FIELD = 'series_id';
    
    /** The XML node name for this entry. */
    const XML_NODE_NAME = 'series';
    

	//VARIABLES:


	//CLASS CONSTRUCTOR
	//************************************************************************
	/**
	 * function __construct
	 * <pre>
	 * Initialize this object.
	 * </pre>
	 * @param $initID [INTEGER] The unique id of the series we are managing.
	 * @return [void]
	 */
    function __construct( $initID=-1 ) 
    {
    
        $dbTableName = RowManager_SeriesManager::DB_TABLE;
        $fieldList = RowManager_SeriesManager::FIELD_LIST;
        $primaryKeyField = RowManager_SeriesManager::PRIMARYKEY_FIELD;
        $primaryKeyValue = $initID;
        
        if (( $initID != -1 ) && ( $initID != '' )) {
        
            $condition = $primaryKeyField . '=' . $primaryKeyValue;
            
        } else {
            $condition = '';
        }
        $xmlNodeName = RowManager_SeriesManager::XML_NODE_NAME;
        parent::__construct( $dbTableName, $fieldList, $primaryKeyField, $primaryKeyValue, $condition, $xmlNodeName);
        
        $this->dbDescription = RowManager_SeriesManager::DB_TABLE_DESCRIPTION;
        
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
        //$this->setValueByFieldName( 'series_title', $title );
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

	//************************************************************************
	/**
	 * function getLabelField
	 * <pre>
	 * Returns the value commonly used for displaying as a Label (Form Grid
	 * rows, Drop List Labels, etc...).
	 * </pre>
	 * @return [STRING]
	 */
    function getTitle() 
    {
        return $this->getValueByFieldName( 'series_title' );
    }

		//************************************************************************
	/**
	 * function getLabelField
	 * <pre>
	 * Returns the value commonly used for displaying as a Label (Form Grid
	 * rows, Drop List Labels, etc...).
	 * </pre>
	 * @return [STRING]
	 */
    function setTitle( $title ) 
    {
        return $this->setValueByFieldName( 'series_title', $title );
    }

}

?>