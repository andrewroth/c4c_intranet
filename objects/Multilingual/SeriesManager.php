<?php
/**
 * @package Multilingual
 */ 
/**
 * class RowManager_MultilingualSeriesManager
 * <pre> 
 * This object manages the multilingual series table.
 * </pre>
 * @author Johnny Hausman
 */
class  RowManager_MultilingualSeriesManager extends RowManager {

	//CONSTANTS:
	/** The name of the DB Table this class manages. */
    const DB_TABLE = 'site_multilingual_series';
    
    /** The fields in the DB Table this class manages. */
    const FIELD_LIST = 'series_id,series_key';
    
    /** The XML node name for this entry. */
    const XML_NODE_NAME = 'multilingualSeries';
    
    const DB_TABLE_DESCRIPTION = " (  
  series_id int(11) NOT NULL auto_increment,
  series_key varchar(50) NOT NULL default '',
  PRIMARY KEY  (series_id)
    ) TYPE=MyISAM";

    

	//VARIABLES:


	//CLASS CONSTRUCTOR
	//************************************************************************
	/**
	 * function __construct
	 * <pre>
	 * Initialize this object.
	 * </pre>
	 * @param $series_id [INTEGER] The unique id of the Series we are managing.
	 * @return [void]
	 */
    function __construct( $series_id=-1 ) 
    {
    
        $dbTableName = RowManager_MultilingualSeriesManager::DB_TABLE;
        $fieldList = RowManager_MultilingualSeriesManager::FIELD_LIST;
        $primaryKeyField = 'series_id';
        $primaryKeyValue = $series_id;
        
        if (( $series_id != -1 ) && ( $series_id != '' )) {
        
            $condition = $primaryKeyField . '=' . $primaryKeyValue;
            
        } else {
            $condition = '';
        }
        $xmlNodeName = RowManager_MultilingualSeriesManager::XML_NODE_NAME;
        $this->dbDescription = RowManager_MultilingualSeriesManager::DB_TABLE_DESCRIPTION;
        parent::__construct( $dbTableName, $fieldList, $primaryKeyField, $primaryKeyValue, $condition, $xmlNodeName);
        
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
	 * function isUniqueKey
	 * <pre>
	 * Returns whether or not this Key is unique (not already present).
	 * </pre>
	 * @param $key [STRING] the series_key to check
	 * @return [BOOL]
	 */
    function isUniqueKey( $key ) 
    {
        return $this->isUniqueFieldValue( $key, 'series_key' );
    }
    
    
    
    //************************************************************************
	/**
	 * function getKey
	 * <pre>
	 * Returns the key of this series.
	 * </pre>
	 * @return [STRING]
	 */
    function getKey() 
    {
        return $this->getValueByFieldName( 'series_key' );
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
        return "series_key";
    }
    
    
    
    //************************************************************************
	/**
	 * function getPageList
	 * <pre>
	 * Returns a list of Pages associated with this Series.
	 * </pre>
	 * @return [OBJECT]
	 */
    function getPageList() 
    {
        return new MultilingualPageList( $this->getID() );
    }
    
    
    
    //************************************************************************
	/**
	 * function loadBySeriesKey
	 * <pre>
	 * Initialized this object using a provided Series Key.
	 * </pre>
	 * @param $key [STRING] the series Key to use to load.
	 * @return [void]
	 */
    function loadBySeriesKey( $key ) 
    {
        // if a key was provided
        if ( $key != '' ) {
        
            // load the object with series_key as condition
            $condition = 'series_key="'.$key.'"';
            $this->loadByCondition( $condition );
        }
    
    }
    
    
    
    //************************************************************************
	/**
	 * function setKey
	 * <pre>
	 * Sets the Key of this series.
	 * </pre>
	 * @param $key [STRING] new series_key
	 * @return [void]
	 */
    function setKey( $key ) 
    {
        $this->setValueByFieldName( 'series_key', $key );
    }

    
    	
}

?>