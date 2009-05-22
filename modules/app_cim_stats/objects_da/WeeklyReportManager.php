<?php
/**
 * @package cim_stats
 */ 
/**
 * class RowManager_WeeklyReportManager
 * <pre> 
 * Handles information related to information staff submit each week..
 * </pre>
 * @author Russ Martin
 */
class  RowManager_WeeklyReportManager extends RowManager {

	//CONSTANTS:
	/** The name of the DB Table this class manages. */
    const DB_TABLE = 'cim_stats_weeklyreport';
    
    /** The SQL description of the DB Table this class manages. */
    /*
     * weeklyReport_id [INTEGER]  unique id
     * weeklyReport_1on1SpConv [INTEGER]  number of 1-1 spiritual conversations this week
     * weeklyReport_1on1GosPres [INTEGER]  number of 1 on 1 gospel presentations this week
     * weeklyReport_1on1HsPres [INTEGER]  number of 1 on 1 Holy Spirit presentations
     */
    const DB_TABLE_DESCRIPTION = " (
  weeklyReport_id int(10) NOT NULL  auto_increment,
  weeklyReport_1on1SpConv int(10) NOT NULL  default '0',
  weeklyReport_1on1SpConvStd int(10) NOT NULL  default '0',
  weeklyReport_1on1GosPres int(10) NOT NULL  default '0',
  weeklyReport_1on1GosPresStd int(10) NOT NULL  default '0',
  weeklyReport_1on1HsPres int(10) NOT NULL  default '0',
  weeklyReport_1on1GosPresStd int(10) NOT NULL  default '0',
  weeklyReport_7upCompleted int(10) NOT NULL  default '0',
  weeklyReport_7upCompletedStd int(10) NOT NULL  default '0',
  staff_id int(10) NOT NULL  default '0',
  week_id int(10) NOT NULL  default '0',
  campus_id int(10) NOT NULL  default '0',
  weeklyReport_cjVideo int(10) NOT NULL default '0',
  weeklyReport_mda int(10) NOT NULL default '0',
  weeklyReport_otherEVMats int(10) NOT NULL default '0',
  weeklyReport_rlk int(10) NOT NULL default '0',
  weeklyReport_siq int(10) NOT NULL default '0',
  weeklyReport_notes text NOT NULL default '',
  PRIMARY KEY (weeklyReport_id)
) TYPE=MyISAM";
    
    /** The fields in the DB Table this class manages. */
    const FIELD_LIST = 'weeklyReport_id,weeklyReport_1on1SpConv,weeklyReport_1on1SpConvStd,weeklyReport_1on1GosPres,weeklyReport_1on1GosPresStd,weeklyReport_1on1HsPres,weeklyReport_1on1HsPresStd,weeklyReport_7upCompleted,weeklyReport_7upCompletedStd,staff_id,week_id,campus_id,weeklyReport_cjVideo,weeklyReport_mda,weeklyReport_otherEVMats,weeklyReport_rlk,weeklyReport_siq,weeklyReport_notes';
    
    /** The XML node name for this entry. */
    const XML_NODE_NAME = 'weeklyreport';
    

	//VARIABLES:


	//CLASS CONSTRUCTOR
	//************************************************************************
	/**
	 * function __construct
	 * <pre>
	 * Initialize this object.
	 * </pre>
	 * @param $WEEK_ID [INTEGER] The unique id of the weeklyreport we are managing.
	 * @param $staff_id [INTEGER] The unique id of a staff member.
	 * @return [void]
	 */
    function __construct( $WEEK_ID=-1, $staff_id=-1, $campus_id=-1 ) 
    {
    
        $dbTableName = RowManager_WeeklyReportManager::DB_TABLE;
        $fieldList = RowManager_WeeklyReportManager::FIELD_LIST;
        $primaryKeyField = 'weeklyReport_id';
        $primaryKeyValue = 0;
        
        if (( $WEEK_ID != -1 ) && ( $WEEK_ID != '' )) {
        
            $condition = 'week_id' . '=' . $WEEK_ID;
            if ( ($staff_id != -1) && ($staff_id != '') )
            {
                $condition .= ' AND staff_id='. $staff_id;
            }
            
            if ( ($campus_id != -1) && ($campus_id != '') )
            {
                $condition .= ' AND campus_id='. $campus_id;
            }
            // echo 'The condition is ['.$condition.']<br/>';
        } else {
            $condition = '';
        }
        $xmlNodeName = RowManager_WeeklyReportManager::XML_NODE_NAME;
        parent::__construct( $dbTableName, $fieldList, $primaryKeyField, $primaryKeyValue, $condition, $xmlNodeName);
        
        $this->dbDescription = RowManager_WeeklyReportManager::DB_TABLE_DESCRIPTION;

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
	 * function getStaffID
	 * <pre>
	 * Returns the staff ID
	 * </pre>
	 * @return [STRING]
	 */
    function getStaffID()
    {
        return $this->getValueByFieldName('staff_id');
    }
    /**
	 * function setsStaffID
	 * <pre>
	 * sets the staff ID
	 * </pre>
	 * @return [void]
	 */
    function setStaffID( $staffID )
    {
        $this->setValueByFieldName( 'staff_id', $staffID );
        return;
    }
    /**
	 * function setCampusID
	 * <pre>
	 * sets the campus ID
	 * </pre>
	 * @return [void]
	 */
    function setCampusID( $campusID )
    {
        $this->setValueByFieldName( 'campus_id', $campusID );
        return;
    }
    
    //************************************************************************
	/**
	 * function getJoinOnCampusID
	 * <pre>
	 * returns the field used as a join condition for campus_id
	 * </pre>
	 * @return [STRING]
	 */
    function getJoinOnCampusID()
    {   
        return $this->getJoinOnFieldX('campus_id');
    }
    
    //************************************************************************
	/**
	 * function getJoinOnStaffID
	 * <pre>
	 * returns the field used as a join condition for staff_id
	 * </pre>
	 * @return [STRING]
	 */
    function getJoinOnStaffID()
    {   
        return $this->getJoinOnFieldX('staff_id');
    }
    
    //************************************************************************
	/**
	 * function getJoinOnWeekID
	 * <pre>
	 * returns the field used as a join condition for week_id
	 * </pre>
	 * @return [STRING]
	 */
    function getJoinOnWeekID()
    {   
        return $this->getJoinOnFieldX('week_id');
    }
    
    	
}

?>