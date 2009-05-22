<?php
/**
 * @package cim_sch
 */ 
/**
 * class RowManager_ScheduleBlocksManager
 * <pre> 
 * Object that stores information related to a person's schedule.
 * </pre>
 * @author Calvin Jien & Russ Martin
 */
class  RowManager_ScheduleBlocksManager extends RowManager {

	//CONSTANTS:
	/** The name of the DB Table this class manages. */
    const DB_TABLE = 'cim_sch_scheduleblocks';
    
    /** The SQL description of the DB Table this class manages. */
    /*
     * scheduleBlocks_id [INTEGER]  primary key
     * schedule_id [INTEGER]  foreign key to the meta-data associated with the schedule
     * scheduleBlocks_timeblock [INTEGER]  time blocks of a person's schedule
     */
    const DB_TABLE_DESCRIPTION = " (
  scheduleBlocks_id int(11) NOT NULL  auto_increment,
  schedule_id int(11) NOT NULL  default '0',
  scheduleBlocks_timeblock int(11) NOT NULL  default '0',
  PRIMARY KEY (scheduleBlocks_id)
) TYPE=MyISAM";
    
    /** The fields in the DB Table this class manages. */
    const FIELD_LIST = 'scheduleBlocks_id,schedule_id,scheduleBlocks_timeblock';
    
    /** The XML node name for this entry. */
    const XML_NODE_NAME = 'scheduleblocks';
    

	//VARIABLES:


	//CLASS CONSTRUCTOR
	//************************************************************************
	/**
	 * function __construct
	 * <pre>
	 * Initialize this object.
	 * </pre>
	 * @param $SCHEDULEBLOCKS_ID [INTEGER] The unique id of the scheduleblocks we are managing.
	 * @return [void]
	 */
    function __construct( $SCHEDULEBLOCKS_ID=-1 ) 
    {
    
        $dbTableName = RowManager_ScheduleBlocksManager::DB_TABLE;
        $fieldList = RowManager_ScheduleBlocksManager::FIELD_LIST;
        $primaryKeyField = 'scheduleBlocks_id';
        $primaryKeyValue = $SCHEDULEBLOCKS_ID;
        
        if (( $SCHEDULEBLOCKS_ID != -1 ) && ( $SCHEDULEBLOCKS_ID != '' )) {
        
            $condition = $primaryKeyField . '=' . $primaryKeyValue;
            
        } else {
            $condition = '';
        }
        $xmlNodeName = RowManager_ScheduleBlocksManager::XML_NODE_NAME;
        parent::__construct( $dbTableName, $fieldList, $primaryKeyField, $primaryKeyValue, $condition, $xmlNodeName);
        
        $this->dbDescription = RowManager_ScheduleBlocksManager::DB_TABLE_DESCRIPTION;

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
	/**
	 * function setSheduleID
	 * <pre>
	 * sets the schedule Id
	 * </pre>
	 * @return [void]
	 */
    function setScheduleID($schedule_ID){
    	$this->setValueByFieldName('schedule_id', $schedule_ID);
    }
    /**
	 * function setScheduleIDAsCondition
	 * <pre>
	 * sets teh schedule ID as condition
	 * </pre>
	 * @return [void]
	 */
    function setScheduleIDAsCondition( $scheduleID )
    {
        $this->setDBCondition('schedule_id='.$scheduleID);
        return;
    }
	/**
	 * function setTimeBlock
	 * <pre>
	 * sets the time block
	 * </pre>
	 * @return [void]
	 */
    function setTimeBlock($timeblock){
    
    	$this->setValueByFieldName('scheduleBlocks_timeblock', $timeblock);
    	return;
    }
/**
	 * function getTimeBlock
	 * <pre>
	 * gets teh time block
	 * </pre>
	 * @return [?]
	 */
    function getTimeBlock(){
    	return $this->getValueByFieldName('scheduleBlocks_timeblock');
    }
    	
}

?>