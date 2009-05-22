<?php
/**
 * @package cim_sch
 */ 
/**
 * class RowManager_TimeZonesManager
 * <pre> 
 * Contains all the time zones off sets.
 * </pre>
 * @author Calvin Jien & Russ Martin
 */
class  RowManager_TimeZonesManager extends RowManager {

	//CONSTANTS:
	/** The name of the DB Table this class manages. */
    const DB_TABLE = 'cim_sch_timezones';
    
    /** The SQL description of the DB Table this class manages. */
    /*
     * timezones_id [INTEGER]  ID of the timezones
     * timezones_desc [STRING]  Time zones description
     * timezones_offset [INTEGER]  The value for the timezones offset
     */
    const DB_TABLE_DESCRIPTION = " (
  timezones_id int(11) NOT NULL  auto_increment,
  timezones_desc varchar(32) NOT NULL  default '',
  timezones_offset int(11) NOT NULL  default '0',
  PRIMARY KEY (timezones_id)
) TYPE=MyISAM";
    
    /** The fields in the DB Table this class manages. */
    const FIELD_LIST = 'timezones_id,timezones_desc,timezones_offset';
    
    /** The XML node name for this entry. */
    const XML_NODE_NAME = 'timezones';
    

	//VARIABLES:


	//CLASS CONSTRUCTOR
	//************************************************************************
	/**
	 * function __construct
	 * <pre>
	 * Initialize this object.
	 * </pre>
	 * @param $TIMEZONES_ID [INTEGER] The unique id of the timezones we are managing.
	 * @return [void]
	 */
    function __construct( $TIMEZONES_ID=-1 ) 
    {
    
        $dbTableName = RowManager_TimeZonesManager::DB_TABLE;
        $fieldList = RowManager_TimeZonesManager::FIELD_LIST;
        $primaryKeyField = 'timezones_id';
        $primaryKeyValue = $TIMEZONES_ID;
        
        if (( $TIMEZONES_ID != -1 ) && ( $TIMEZONES_ID != '' )) {
        
            $condition = $primaryKeyField . '=' . $primaryKeyValue;
            
        } else {
            $condition = '';
        }
        $xmlNodeName = RowManager_TimeZonesManager::XML_NODE_NAME;
        parent::__construct( $dbTableName, $fieldList, $primaryKeyField, $primaryKeyValue, $condition, $xmlNodeName);
        
        $this->dbDescription = RowManager_TimeZonesManager::DB_TABLE_DESCRIPTION;

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
        return "No Field Label Marked";
    }

    
    	
}

?>