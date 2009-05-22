<?php
/**
 * @package Multilingual
 */ 
/**
 * class RowManager_MultilingualPageManager
 * <pre> 
 * This object manages the Multilingual Page table.
 * </pre>
 * @author Johnny Hausman
 */
class  RowManager_MultilingualPageManager extends RowManager {

	//CONSTANTS:
	/** The name of the DB Table this class manages. */
    const DB_TABLE = 'site_multilingual_page';
    
    /** The fields in the DB Table this class manages. */
    const FIELD_LIST = 'page_id,series_id,page_key';
    
    /** The XML node name for this entry. */
    const XML_NODE_NAME = 'multilingualPageManager';
    
     /** The XML node name for this entry. */
    const DB_TABLE_DESCRIPTION = " (  
      page_id int(11) NOT NULL auto_increment,
      series_id int(11) NOT NULL default '0',
      page_key varchar(50) NOT NULL default '',
      PRIMARY KEY  (page_id)
        ) TYPE=MyISAM;";
    
	//VARIABLES:


	//CLASS CONSTRUCTOR
	//************************************************************************
	/**
	 * function __construct
	 * <pre>
	 * Initialize this object.
	 * </pre>
	 * @param $page_id [INTEGER] The unique id of the multilingualPageManager we are managing.
	 * @return [void]
	 */
    function __construct( $page_id=-1 ) 
    {
    
        $dbTableName = RowManager_MultilingualPageManager::DB_TABLE;
        $fieldList = RowManager_MultilingualPageManager::FIELD_LIST;
        $primaryKeyField = 'page_id';
        $primaryKeyValue = $page_id;
        
        if (( $page_id != -1 ) && ( $page_id != '' )) {
        
            $condition = $primaryKeyField . '=' . $primaryKeyValue;
            
        } else {
            $condition = '';
        }
        $xmlNodeName = RowManager_MultilingualPageManager::XML_NODE_NAME;
        $this->dbDescription = RowManager_MultilingualPageManager::DB_TABLE_DESCRIPTION;
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
	 * Returns whether or not this Key is unique (not already present) for the
	 * given series id.
	 * </pre>
	 * @param $seriesID [INTEGER] the series_id to check the key for
	 * @param $key [STRING] the page_key to check
	 * @return [BOOL]
	 */
    function isUniqueKey( $seriesID, $key ) 
    {
        $condition = 'series_id='.$seriesID;
        return $this->isUniqueFieldValue( $key, 'page_key', $condition );
    }
    
    
    
    //************************************************************************
	/**
	 * function getKey
	 * <pre>
	 * Returns the of this page's key.
	 * </pre>
	 * @return [STRING]
	 */
    function getKey() 
    {
        return $this->getValueByFieldName( 'page_key' );
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
        return "page_key";
    }
    
    
    
    //************************************************************************
	/**
	 * function getLabelList
	 * <pre>
	 * Returns a list of multilingual labels for this page.
	 * </pre>
	 * @return [OBJECT]
	 */
    function getLabelList() 
    {
        $pageID = $this->getID();
        return new MultilingualLabelList( $pageID );
    }
    
    
    
    //************************************************************************
	/**
	 * function getSeriesID
	 * <pre>
	 * Returns the ID of the parent Series of this page.
	 * </pre>
	 * @return [INTEGER]
	 */
    function getSeriesID() 
    {
        return (int) $this->getValueByFieldName( 'series_id' );
    }
    
    
    
    //************************************************************************
	/**
	 * function loadByPageKey
	 * <pre>
	 * Initialize this object using the provided series id and page Key.
	 * </pre>
	 * @param $seriesID [INTEGER] the id of the page's series
	 * @param $key [STRING] the page Key to use to load.
	 * @return [void]
	 */
    function loadByPageKey( $seriesID, $key ) 
    {
        // if a key was provided
        if ( $key != '' ) {
        
            // load the object with page_key as condition
            $condition = '';
            if ($seriesID != '') {
                $condition = 'series_id='.$seriesID.' AND ';
            }
            $condition .= 'page_key="'.$key.'"';
            $this->loadByCondition( $condition );

        }
    
    }
    
    
    
    //************************************************************************
	/**
	 * function setKey
	 * <pre>
	 * Sets the Key of this page.
	 * </pre>
	 * @param $key [STRING] new page_key
	 * @return [void]
	 */
    function setKey( $key ) 
    {
        $this->setValueByFieldName( 'page_key', $key );
    }
    
    
    
    //************************************************************************
	/**
	 * function setSeriesID
	 * <pre>
	 * Sets the ID of the parent Series of this page.
	 * </pre>
	 * @param $seriesID [INTEGER] new series_id
	 * @return [void]
	 */
    function setSeriesID( $seriesID ) 
    {
        $this->setValueByFieldName( 'series_id', $seriesID );
    }

    
    
}

?>