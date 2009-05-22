<?php
/**
 * @package cim_sch
 */ 
/**
 * class RowManager_ScheduleManager
 * <pre> 
 * Contains the meta data about each of the schedules.
 * </pre>
 * @author Calvin Jien & Russ Martin
 */
class  RowManager_ScheduleManager extends RowManager {

	//CONSTANTS:
	/** The name of the DB Table this class manages. */
    const DB_TABLE = 'cim_sch_schedule';
    
    /** The SQL description of the DB Table this class manages. */
    /*
     * schedule_id [INTEGER]  ID of the schedule
     * person_id [INTEGER]  ID of the person
     * timezones_id [INTEGER]  ID of the timezone
     * schedule_dateTimeStamp [DATE]  Date and time stamp whenever changes are made
     */
    const DB_TABLE_DESCRIPTION = " (
  schedule_id int(11) NOT NULL  auto_increment,
  person_id int(11) NOT NULL  default '0',
  timezones_id int(11) NOT NULL  default '0',
  schedule_dateTimeStamp datetime NOT NULL  default '0000-00-00 00:00:00',
  PRIMARY KEY (schedule_id)
) TYPE=MyISAM";
    
    /** The fields in the DB Table this class manages. */
    const FIELD_LIST = 'schedule_id,person_id,timezones_id,schedule_dateTimeStamp';
    
    /** The XML node name for this entry. */
    const XML_NODE_NAME = 'schedule';
    

	//VARIABLES:


	//CLASS CONSTRUCTOR
	//************************************************************************
	/**
	 * function __construct
	 * <pre>
	 * Initialize this object.
	 * </pre>
	 * @param $SCHEDULE_ID [INTEGER] The unique id of the schedule we are managing.
	 * @return [void]
	 */
    function __construct( $SCHEDULE_ID=-1 ) 
    {
    
        $dbTableName = RowManager_ScheduleManager::DB_TABLE;
        $fieldList = RowManager_ScheduleManager::FIELD_LIST;
        $primaryKeyField = 'schedule_id';
        $primaryKeyValue = $SCHEDULE_ID;
        
        if (( $SCHEDULE_ID != -1 ) && ( $SCHEDULE_ID != '' )) {
        
            $condition = $primaryKeyField . '=' . $primaryKeyValue;
            
        } else {
            $condition = '';
        }
        $xmlNodeName = RowManager_ScheduleManager::XML_NODE_NAME;
        parent::__construct( $dbTableName, $fieldList, $primaryKeyField, $primaryKeyValue, $condition, $xmlNodeName);
        
        $this->dbDescription = RowManager_ScheduleManager::DB_TABLE_DESCRIPTION;

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
    
   //************************************************************************
	/**
	 * function setpersonID
	 * <pre>
	 * Sets the id for the person
	 * </pre>
	 * @param $title [INT] The person id.
	 * @return [void]
	 */
    function setPersonID( $person_ID )
    {
        $this->setValueByFieldName( 'person_id', $person_ID );
    }
    /**
	 * function getScheduleID
	 * <pre>
	 * gets the schedule ID
	 * </pre>
	 * @return [?]
	 */
    function getScheduleID( ){
    	return $this->getValueByFieldName('schedule_id');
    }
    
    	
}

?>