<?php
/**
 * @package cim_hrdb
 */ 
/**
 * class RowManager_StaffScheduleInstrManager
 * <pre> 
 * The form instructions directly associated with a particular HRDB form.
 * </pre>
 * @author CIM Team
 */
class  RowManager_StaffScheduleInstrManager extends RowManager {

	//CONSTANTS:
	/** The name of the DB Table this class manages. */
    const DB_TABLE = 'cim_hrdb_staffscheduleinstr';
    
    /** The SQL description of the DB Table this class manages. */
    /*
     * staffscheduleinstr_toptext [STRING]  The instructions for the main (top) form.
     * staffscheduleinstr_bottomtext [STRING]  The instructions for the scheduled activities form (if it is used for this HR form).
     * staffscheduletype_id [INTEGER]  The primary id of the object - same primary ID as the schedule form type object.
     */
    const DB_TABLE_DESCRIPTION = " ( 
  staffscheduleinstr_id int(15) NOT NULL auto_increment,
  staffscheduleinstr_toptext text NOT NULL  default '',
  staffscheduleinstr_bottomtext text NOT NULL  default '',
  staffscheduletype_id int(15) NOT NULL,
  PRIMARY KEY (staffscheduleinstr_id)
) TYPE=MyISAM";
    
    /** The fields in the DB Table this class manages. */
    const FIELD_LIST = 'staffscheduleinstr_toptext,staffscheduleinstr_bottomtext,staffscheduletype_id';
    
    /** The XML node name for this entry. */
    const XML_NODE_NAME = 'staffscheduleinstr';
    

	//VARIABLES:


	//CLASS CONSTRUCTOR
	//************************************************************************
	/**
	 * function __construct
	 * <pre>
	 * Initialize this object.
	 * </pre>
	 * @param $STAFFSCHEDULEINSTR_ID [INTEGER] The unique id of the staffscheduleinstr we are managing.
	 * @return [void]
	 */
    function __construct( $STAFFSCHEDULEINSTR_ID=-1 ) 
    {
    
        $dbTableName = RowManager_StaffScheduleInstrManager::DB_TABLE;
        $fieldList = RowManager_StaffScheduleInstrManager::FIELD_LIST;
        $primaryKeyField = 'staffscheduletype_id';
        $primaryKeyValue = $STAFFSCHEDULEINSTR_ID;
        
        if (( $STAFFSCHEDULEINSTR_ID != -1 ) && ( $STAFFSCHEDULEINSTR_ID != '' )) {
        
            $condition = $primaryKeyField . '=' . $primaryKeyValue;
            
        } else {
            $condition = '';
        }
        $xmlNodeName = RowManager_StaffScheduleInstrManager::XML_NODE_NAME;
        parent::__construct( $dbTableName, $fieldList, $primaryKeyField, $primaryKeyValue, $condition, $xmlNodeName);
        
        $this->dbDescription = RowManager_StaffScheduleInstrManager::DB_TABLE_DESCRIPTION;

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
	 * function setFormTypeID
	 * <pre>
	 * Set the staffscheduletype_id value
	 * </pre>
	 * @return [VOID]
	 */   
	function setFormTypeID($staffscheduletype_id)
	{
     $this->setValueByFieldName('staffscheduletype_id',$staffscheduletype_id);
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