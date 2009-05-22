<?php
/**
 * @package cim_hrdb
 */ 
/**
 * class RowManager_StaffScheduleTypeManager
 * <pre> 
 * The HRDB schedule/form type..
 * </pre>
 * @author CIM Team
 */
class  RowManager_StaffScheduleTypeManager extends RowManager {

	//CONSTANTS:
	/** The name of the DB Table this class manages. */
    const DB_TABLE = 'cim_hrdb_staffscheduletype';
    
    /** The SQL description of the DB Table this class manages. */
    /*
     * staffscheduletype_id [INTEGER]  Unique ID for this form/schedule type
     * staffscheduletype_desc [STRING]  Description of the staff form/schedule type.
     * staffscheduletype_startdate [DATE]  The min. start date for the schedule/form context
     * staffscheduletype_enddate [DATE]  The max ending date for the schedule/form.
     */
    const DB_TABLE_DESCRIPTION = " (                                 
                              `staffscheduletype_id` int(15) NOT NULL auto_increment,                   
                              `staffscheduletype_desc` varchar(75) collate latin1_general_ci NOT NULL,  
                              `staffscheduletype_startdate` date NOT NULL default '0000-00-00',         
                              `staffscheduletype_enddate` date NOT NULL default '0000-00-00',           
                              `staffscheduletype_has_activities` int(2) NOT NULL default '1',           
                              `staffscheduletype_has_activity_phone` int(2) NOT NULL default '0',       
                              `staffscheduletype_activity_types` varchar(25) NOT NULL default '', 
                              `staffscheduletype_is_shown` int(2) NOT NULL default '0',         
                              PRIMARY KEY  (`staffscheduletype_id`)                                     
                            ) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci ";
    
    /** The fields in the DB Table this class manages. */
    const FIELD_LIST = 'staffscheduletype_id,staffscheduletype_desc,staffscheduletype_startdate,staffscheduletype_enddate,staffscheduletype_has_activities,staffscheduletype_has_activity_phone,staffscheduletype_activity_types,staffscheduletype_is_shown';
    
    /** The XML node name for this entry. */
    const XML_NODE_NAME = 'staffscheduletype';
    

	//VARIABLES:


	//CLASS CONSTRUCTOR
	//************************************************************************
	/**
	 * function __construct
	 * <pre>
	 * Initialize this object.
	 * </pre>
	 * @param $STAFFSCHEDULETYPE_ID [INTEGER] The unique id of the staffscheduletype we are managing.
	 * @return [void]
	 */
    function __construct( $STAFFSCHEDULETYPE_ID=-1 ) 
    {
    
        $dbTableName = RowManager_StaffScheduleTypeManager::DB_TABLE;
        $fieldList = RowManager_StaffScheduleTypeManager::FIELD_LIST;
        $primaryKeyField = 'staffscheduletype_id';
        $primaryKeyValue = $STAFFSCHEDULETYPE_ID;
        
        if (( $STAFFSCHEDULETYPE_ID != -1 ) && ( $STAFFSCHEDULETYPE_ID != '' )) {
        
            $condition = $primaryKeyField . '=' . $primaryKeyValue;
            
        } else {
            $condition = '';
        }
        $xmlNodeName = RowManager_StaffScheduleTypeManager::XML_NODE_NAME;
        parent::__construct( $dbTableName, $fieldList, $primaryKeyField, $primaryKeyValue, $condition, $xmlNodeName);
        
        $this->dbDescription = RowManager_StaffScheduleTypeManager::DB_TABLE_DESCRIPTION;

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
	 * function getFormName
	 * <pre>
	 * Gets the name of the HRDB staff form
	 * </pre>
	 * @return [STRING]
	 */
    function getFormName()
    {
        return $this->getValueByFieldName('staffscheduletype_desc');
    }   
    
	/**
	 * function getStartDate
	 * <pre>
	 * Gets the first date for the HRDB form
	 * </pre>
	 * @return [STRING]
	 */    
    function getStartDate()
    {
        return $this->getValueByFieldName('staffscheduletype_startdate');
    }  	    
    
	/**
	 * function getEndDate
	 * <pre>
	 * Gets the last date for the HRDB form
	 * </pre>
	 * @return [STRING]
	 */    
    function getEndDate()
    {
        return $this->getValueByFieldName('staffscheduletype_enddate');
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
        return "staffscheduletype_desc";
    }

    /**
	 * function seIsSHown
	 * <pre>
	 * checks if the set is shown
	 * </pre>
	 * @return [void]
	 */
    function setIsShown( $isShown )
    {
        $this->setValueByFieldName( 'staffscheduletype_is_shown', $isShown );
    }
    	
}

?>