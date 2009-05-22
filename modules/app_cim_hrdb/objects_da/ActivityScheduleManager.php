<?php
/**
 * @package cim_hrdb
 */ 
/**
 * class RowManager_ActivityScheduleManager
 * <pre> 
 * object linking an activity to some schedule; allows an activity to be associated with more than one schedule/form.
 * </pre>
 * @author CIM Team
 */
class  RowManager_ActivityScheduleManager extends RowManager {

	//CONSTANTS:
	/** The name of the DB Table this class manages. */
    const DB_TABLE = 'cim_hrdb_activityschedule';
    
    /** The SQL description of the DB Table this class manages. */
    /*
     * activityschedule_id [INTEGER]  unique id of the object
     * staffactivity_id [INTEGER]  the id of the staff activity
     * staffschedule_id [INTEGER]  id of the schedule/form to associated with the activity
     */
    const DB_TABLE_DESCRIPTION = " (
  activityschedule_id int(15) NOT NULL  auto_increment,
  staffactivity_id int(15) NOT NULL  default '0',
  staffschedule_id int(15) NOT NULL  default '0',
  PRIMARY KEY (activityschedule_id)
) TYPE=MyISAM";
    
    /** The fields in the DB Table this class manages. */
    const FIELD_LIST = 'activityschedule_id,staffactivity_id,staffschedule_id';
    
    /** The XML node name for this entry. */
    const XML_NODE_NAME = 'activityschedule';
    

	//VARIABLES:


	//CLASS CONSTRUCTOR
	//************************************************************************
	/**
	 * function __construct
	 * <pre>
	 * Initialize this object.
	 * </pre>
	 * @param $ACTIVITYSCHEDULE_ID [INTEGER] The unique id of the activityschedule we are managing.
	 * @return [void]
	 */
    function __construct( $ACTIVITYSCHEDULE_ID=-1 ) 
    {
    
        $dbTableName = RowManager_ActivityScheduleManager::DB_TABLE;
        $fieldList = RowManager_ActivityScheduleManager::FIELD_LIST;
        $primaryKeyField = 'activityschedule_id';
        $primaryKeyValue = $ACTIVITYSCHEDULE_ID;
        
        if (( $ACTIVITYSCHEDULE_ID != -1 ) && ( $ACTIVITYSCHEDULE_ID != '' )) {
        
            $condition = $primaryKeyField . '=' . $primaryKeyValue;
            
        } else {
            $condition = '';
        }
        $xmlNodeName = RowManager_ActivityScheduleManager::XML_NODE_NAME;
        parent::__construct( $dbTableName, $fieldList, $primaryKeyField, $primaryKeyValue, $condition, $xmlNodeName);
        
        $this->dbDescription = RowManager_ActivityScheduleManager::DB_TABLE_DESCRIPTION;

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
    
 	/**
	 * function getJoinOnActivityID
	 * <pre>
	 * returns the field used as a join condition for staffactivity id
	 * </pre>
	 * @return [STRING]
	 */
    function getJoinOnActivityID()
    {   
        return $this->getJoinOnFieldX('staffactivity_id');
    }   
    
    
 	/**
	 * function getJoinOnScheduleID
	 * <pre>
	 * returns the field used as a join condition for staffschedule id
	 * </pre>
	 * @return [STRING]
	 */
    function getJoinOnScheduleID()
    {   
        return $this->getJoinOnFieldX('staffschedule_id');
    }           
    
 
    //************************************************************************
	/**
	 * function setStaffActivityID
	 * <pre>
	 * Set the staffactivity_id value
	 * </pre>
	 * @return [VOID]
	 */   
	function setStaffActivityID($activity_id)
	{
     $this->setValueByFieldName('staffactivity_id',$activity_id);
  }
		
  
    //************************************************************************
	/**
	 * function setStaffScheduleID
	 * <pre>
	 * Set the staffschedule_id value
	 * </pre>
	 * @return [VOID]
	 */   
	function setStaffScheduleID($schedule_id)
	{
     $this->setValueByFieldName('staffschedule_id',$schedule_id);
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