<?php
/**
 * @package cim_hrdb
 */ 
/**
 * class RowManager_StaffActivityManager
 * <pre> 
 * Records details about some staff member's scheduled activity..
 * </pre>
 * @author CIM Team
 */
class  RowManager_StaffActivityManager extends RowManager {

	//CONSTANTS:
	/** The name of the DB Table this class manages. */
    const DB_TABLE = 'cim_hrdb_staffactivity';
    
    /** The SQL description of the DB Table this class manages. */
    /*
     * staffactivity_id [INTEGER]  unique id of the staff activity record
     * person_id [INTEGER]  the id of the staff person associated with the activity
     * staffactivity_startdate [DATE]  The start date of the activity
     * staffactivity_enddate [DATE]  The end date of the activity.
     * staffactivity_contactPhone [STRING]  The phone # where the staff member can be reached during the activity.
     * activitytype_id [INTEGER]  The activity's type (i.e. "vacation")
     */
    const DB_TABLE_DESCRIPTION = " (
  staffactivity_id int(15) NOT NULL  auto_increment,
  person_id int(50) NOT NULL  default '0',
  staffactivity_startdate date NOT NULL  default '0000-00-00',
  staffactivity_enddate date NOT NULL  default '0000-00-00',
  staffactivity_contactPhone varchar(20) NOT NULL  default '',
  activitytype_id int(10) NOT NULL  default '0',
  PRIMARY KEY (staffactivity_id)
) TYPE=MyISAM";
    
    /** The fields in the DB Table this class manages. */
    const FIELD_LIST = 'staffactivity_id,person_id,staffactivity_startdate,staffactivity_enddate,staffactivity_contactPhone,activitytype_id';
    
    /** The XML node name for this entry. */
    const XML_NODE_NAME = 'staffactivity';
    

	//VARIABLES:


	//CLASS CONSTRUCTOR
	//************************************************************************
	/**
	 * function __construct
	 * <pre>
	 * Initialize this object.
	 * </pre>
	 * @param $STAFFACTIVITY_ID [INTEGER] The unique id of the staffactivity we are managing.
	 * @return [void]
	 */
    function __construct( $STAFFACTIVITY_ID=-1 ) 
    {
    
        $dbTableName = RowManager_StaffActivityManager::DB_TABLE;
        $fieldList = RowManager_StaffActivityManager::FIELD_LIST;
        $primaryKeyField = 'staffactivity_id';
        $primaryKeyValue = $STAFFACTIVITY_ID;
        
        if (( $STAFFACTIVITY_ID != -1 ) && ( $STAFFACTIVITY_ID != '' )) {
        
            $condition = $primaryKeyField . '=' . $primaryKeyValue;
            
        } else {
            $condition = '';
        }
        $xmlNodeName = RowManager_StaffActivityManager::XML_NODE_NAME;
        parent::__construct( $dbTableName, $fieldList, $primaryKeyField, $primaryKeyValue, $condition, $xmlNodeName);
        
        $this->dbDescription = RowManager_StaffActivityManager::DB_TABLE_DESCRIPTION;

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
	 * function getJoinOnPersonID
	 * <pre>
	 * returns the field used as a join condition for person id
	 * </pre>
	 * @return [STRING]
	 */
    function getJoinOnPersonID()
    {   
        return $this->getJoinOnFieldX('person_id');
    }     
    
 	/**
	 * function getJoinOnActivityTypeID
	 * <pre>
	 * returns the field used as a join condition for activitytype id
	 * </pre>
	 * @return [STRING]
	 */
    function getJoinOnActivityTypeID()
    {   
        return $this->getJoinOnFieldX('activitytype_id');
    }        
    
       
    /**
	 * function setStartDate
	 * <pre>
	 * sets the start date
	 * </pre>
	 * @return [void]
	 */
    function setStartDate( $start_date )
    {
        $this->setValueByFieldName( 'staffactivity_startdate', $start_date );
    }
	/**
	 * function setStaffActivityID
	 * <pre>
	 * sets the staff activity ID
	 * </pre>
	 * @return [void]
	 */
    function setStaffActivityID( $activity_id )
    {
        $this->setValueByFieldName( 'staffactivity_id', $activity_id );
    }   
    /**
	 * function setActivityTypeID
	 * <pre>
	 * sets the activity type ID 
	 * </pre>
	 * @return [void]
	 */
    function setActivityTypeID( $activitytype_id )
    {
        $this->setValueByFieldName( 'activitytype_id', $activitytype_id );
    }   
    /**
	 * function setPersonID
	 * <pre>
	 * sets the person's ID
	 * </pre>
	 * @return [void]
	 */
    function setPersonID( $person_id )
    {
        $this->setValueByFieldName( 'person_id', $person_id );
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