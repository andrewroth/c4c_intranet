<?php
/**
 * class RowManager_EpisodeManager
 * <pre> 
 * [description]
 * </pre>
 * @author Will Schuurman
 */
class  RowManager_EpisodeManager extends RowManager {

	//CONSTANTS:
	/** The name of the DB Table this class manages. */
    const DB_TABLE = 'tvaddicts_episode';
    
    /** The SQL description of the DB Table this class manages. */
    /*
     * episode_id [INTEGER]  Unique identifier (Primary Key)
     * episode_title [STRING]  The title of the episode we love so much
     */
    const DB_TABLE_DESCRIPTION = " (
  episode_id int(11) NOT NULL  auto_increment,
  season_id int(11) NOT NULL,
  episode_title varchar(20) NOT NULL,
  episode_airDate varchar(10) NOT NULL,
  episode_numberTimesWatched int(2),
  PRIMARY KEY (episode_id)
) TYPE=MyISAM";
    
    /** The fields in the DB Table this class manages. */
    const FIELD_LIST = 'episode_id,episode_title';
    
    /** The primary key field in the DB Table */
    const PRIMARYKEY_FIELD = 'episode_id';
    
    /** The XML node name for this entry. */
    const XML_NODE_NAME = 'episode';
    

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
    
        $dbTableName = RowManager_EpisodeManager::DB_TABLE;
        $fieldList = RowManager_EpisodeManager::FIELD_LIST;
        $primaryKeyField = RowManager_EpisodeManager::PRIMARYKEY_FIELD;
        $primaryKeyValue = $initID;
        
        if (( $initID != -1 ) && ( $initID != '' )) {
        
            $condition = $primaryKeyField . '=' . $primaryKeyValue;
            
        } else {
            $condition = '';
        }
        $xmlNodeName = RowManager_EpisodeManager::XML_NODE_NAME;
        parent::__construct( $dbTableName, $fieldList, $primaryKeyField, $primaryKeyValue, $condition, $xmlNodeName);
        
        $this->dbDescription = RowManager_EpisodeManager::DB_TABLE_DESCRIPTION;
        
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
        return $this->getValueByFieldName( 'episode_title' );
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
        return $this->setValueByFieldName( 'episode_title', $title );
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
    function setSeasonID( $id ) 
    {
        return $this->setValueByFieldName( 'season_id', $id );
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
    function setNumberTimesWatched( $num ) 
    {
        return $this->setValueByFieldName( 'episode_numberTimesWatched', $num );
    }
	
	/**
	 * function getLabelField
	 * <pre>
	 * Returns the value commonly used for displaying as a Label (Form Grid
	 * rows, Drop List Labels, etc...).
	 * </pre>
	 * @return [STRING]
	 */
    function setAirDate( $date ) 
    {
        return $this->setValueByFieldName( 'episode_airDate', $date );
    }

}

?>