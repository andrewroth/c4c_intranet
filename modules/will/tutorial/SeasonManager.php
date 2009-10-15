<?php
/**
 * class RowManager_SeasonManager
 * <pre> 
 * [description]
 * </pre>
 * @author Will Schuurman
 */
class  RowManager_SeasonManager extends RowManager {

	//CONSTANTS:
	/** The name of the DB Table this class manages. */
    const DB_TABLE = 'tvaddicts_season';
    
    /** The SQL description of the DB Table this class manages. */
    /*
     * season_id [INTEGER]  Unique identifier (Primary Key)
     * season_title [STRING]  The title of the season we love so much
     */
    const DB_TABLE_DESCRIPTION = " (
  season_id int(11) NOT NULL  auto_increment,
  series_id int(11) NOT NULL,
  season_num int(1) NOT NULL,
  PRIMARY KEY (season_id)
) TYPE=MyISAM";
    
    /** The fields in the DB Table this class manages. */
    const FIELD_LIST = 'season_id,season_title';
    
    /** The primary key field in the DB Table */
    const PRIMARYKEY_FIELD = 'season_id';
    
    /** The XML node name for this entry. */
    const XML_NODE_NAME = 'season';
    

	//VARIABLES:


	//CLASS CONSTRUCTOR
	//************************************************************************
	/**
	 * function __construct
	 * <pre>
	 * Initialize this object.
	 * </pre>
	 * @param $initID [INTEGER] The unique id of the season we are managing.
	 * @return [void]
	 */
    function __construct( $initID=-1 ) 
    {
    
        $dbTableName = RowManager_SeasonManager::DB_TABLE;
        $fieldList = RowManager_SeasonManager::FIELD_LIST;
        $primaryKeyField = RowManager_SeasonManager::PRIMARYKEY_FIELD;
        $primaryKeyValue = $initID;
        
        if (( $initID != -1 ) && ( $initID != '' )) {
        
            $condition = $primaryKeyField . '=' . $primaryKeyValue;
            
        } else {
            $condition = '';
        }
        $xmlNodeName = RowManager_SeasonManager::XML_NODE_NAME;
        parent::__construct( $dbTableName, $fieldList, $primaryKeyField, $primaryKeyValue, $condition, $xmlNodeName);
        
        $this->dbDescription = RowManager_SeasonManager::DB_TABLE_DESCRIPTION;
        
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
        //$this->setValueByFieldName( 'season_title', $title );
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
        return $this->getValueByFieldName( 'season_title' );
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
    function setNum( $num ) 
    {
        return $this->setValueByFieldName( 'season_num', $num );
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
    function setSeriesID( $id ) 
    {
        return $this->setValueByFieldName( 'series_id', $id );
    }

}

?>