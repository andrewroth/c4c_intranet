<?php
/**
 * @package cim_hrdb
 */ 
/**
 * class RowManager_StaffScheduleManager
 * <pre> 
 * A particular staff person's schedule.
 * </pre>
 * @author CIM Team
 */
class  RowManager_StaffScheduleManager extends RowManager {

	//CONSTANTS:
	/** The name of the DB Table this class manages. */
    const DB_TABLE = 'cim_hrdb_staffschedule';
    
    /** The SQL description of the DB Table this class manages. */
    /*
     * staffschedule_id [INTEGER]  Unique id of the person's schedule
     * person_id [INTEGER]  The id of the person associated with this schedule
     * staffscheduletype_id [INTEGER]  the id of the form associated with this personal schedule
     * staffschedule_approved [BOOL]  boolean indicating director's approval
     * staffschedule_approvedby [INTEGER]  the person_id of the director approving the schedule
     * staffschedule_lastmodifiedbydirector [DATE]  the timestamp of the last change *made by a director*
     * staffschedule_approvalnotes [STRING]  notes made by the director regarding approval
     */
    const DB_TABLE_DESCRIPTION = " (
  staffschedule_id int(15) NOT NULL  auto_increment,
  person_id int(50) NOT NULL  default '0',
  staffscheduletype_id int(15) NOT NULL  default '0',
  staffschedule_approved int(2) NOT NULL  default '0',
  staffschedule_approvedby int(50) NOT NULL  default '0',
  staffschedule_lastmodifiedbydirector timestamp(14) NOT NULL  default '0000-00-00 00:00:00',
  staffschedule_approvalnotes text NOT NULL  default '',
  staffschedule_tonotify int(2) NOT NULL  default '0',
  PRIMARY KEY (staffschedule_id)
) TYPE=MyISAM";
    
    /** The fields in the DB Table this class manages. */
    const FIELD_LIST = 'staffschedule_id,person_id,staffscheduletype_id,staffschedule_approved,staffschedule_approvedby,staffschedule_lastmodifiedbydirector,staffschedule_approvalnotes,staffschedule_tonotify';
    
    /** The XML node name for this entry. */
    const XML_NODE_NAME = 'staffschedule';
    

	//VARIABLES:


	//CLASS CONSTRUCTOR
	//************************************************************************
	/**
	 * function __construct
	 * <pre>
	 * Initialize this object.
	 * </pre>
	 * @param $STAFFSCHEDULE_ID [INTEGER] The unique id of the staffschedule we are managing.
	 * @return [void]
	 */
    function __construct( $STAFFSCHEDULE_ID=-1 ) 
    {
    
        $dbTableName = RowManager_StaffScheduleManager::DB_TABLE;
        $fieldList = RowManager_StaffScheduleManager::FIELD_LIST;
        $primaryKeyField = 'staffschedule_id';
        $primaryKeyValue = $STAFFSCHEDULE_ID;
        
        if (( $STAFFSCHEDULE_ID != -1 ) && ( $STAFFSCHEDULE_ID != '' )) {
        
            $condition = $primaryKeyField . '=' . $primaryKeyValue;
            
        } else {
            $condition = '';
        }
        $xmlNodeName = RowManager_StaffScheduleManager::XML_NODE_NAME;
        parent::__construct( $dbTableName, $fieldList, $primaryKeyField, $primaryKeyValue, $condition, $xmlNodeName);
        
        $this->dbDescription = RowManager_StaffScheduleManager::DB_TABLE_DESCRIPTION;

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
	 * function setFormID
	 * <pre>
	 * Set the staffscheduletype_id value
	 * </pre>
	 * @return [VOID]
	 */   
	function setFormID($staffscheduletype_id)
	{
     $this->setValueByFieldName('staffscheduletype_id',$staffscheduletype_id);
  }
  
  
  
      //************************************************************************
	/**
	 * function setPersonID
	 * <pre>
	 * Set the person_id value
	 * </pre>
	 * @return [VOID]
	 */   
	function setPersonID($person_id)
	{
     $this->setValueByFieldName('person_id',$person_id);
  }
  
  
     //************************************************************************
	/**
	 * function setToNotify
	 * <pre>
	 * Set whether to notify director of form change
	 * </pre>
	 * @return [VOID]
	 */   
	function setToNotify($to_notify)
	{
		switch ($to_notify)
		{
			case true:			
     			$this->setValueByFieldName('staffschedule_tonotify',1);
     			break;
			case false:
			default:			
     			$this->setValueByFieldName('staffschedule_tonotify',0);
     			break;     			
		}
  }  
  
  
   /**
	 * function getFormID
	 * <pre>
	 * Get the form type ID of the form instance record
	 * </pre>
     *
	 * @return [INTEGER]		the ID of the associated form type
	 */
    function getFormID() 
    {
        return $this->getValueByFieldName('staffscheduletype_id');
    } 
    
    /**
	 * function getPersonID
	 * <pre>
	 * Get the person ID of the form instance record
	 * </pre>
     *
	 * @return [INTEGER]		the ID of the associated person 
	 */
    function getPersonID() 
    {
        return $this->getValueByFieldName('person_id');
    }    
         
      
	/**
	 * function getJoinOnApprovedBy
	 * <pre>
	 * returns the field used as a join condition for approval person
	 * </pre>
	 * @return [STRING]
	 */
    function getJoinOnApprovedBy()
    {   
        return $this->getJoinOnFieldX('staffschedule_approvedby');
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
        return "person_id";
    }

    
    	
}

?>