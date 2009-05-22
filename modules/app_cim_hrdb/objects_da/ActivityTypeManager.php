<?php
/**
 * @package cim_hrdb
 */ 
/**
 * class RowManager_ActivityTypeManager
 * <pre> 
 * a type of schedule activity (i.e. vacation, etc).
 * </pre>
 * @author CIM Team
 */
class  RowManager_ActivityTypeManager extends RowManager {

	//CONSTANTS:
	/** The name of the DB Table this class manages. */
    const DB_TABLE = 'cim_hrdb_activitytype';
    
    /** The SQL description of the DB Table this class manages. */
    /*
     * activitytype_id [INTEGER]  unique id of the staff activity type
     * activitytype_desc [STRING]  Description of the activity type
     */
    const DB_TABLE_DESCRIPTION = " (
  activitytype_id int(10) NOT NULL  auto_increment,
  activitytype_desc varchar(75) NOT NULL  default '',
  activitytype_abbr varchar(6) collate latin1_general_ci NOT NULL,   
  activitytype_color varchar(7) collate latin1_general_ci NOT NULL,
  PRIMARY KEY (activitytype_id)
) TYPE=MyISAM";
    
    /** The fields in the DB Table this class manages. */
    const FIELD_LIST = 'activitytype_id,activitytype_desc,activitytype_abbr,activitytype_color';
    
    /** The XML node name for this entry. */
    const XML_NODE_NAME = 'activitytype';
    

	//VARIABLES:


	//CLASS CONSTRUCTOR
	//************************************************************************
	/**
	 * function __construct
	 * <pre>
	 * Initialize this object.
	 * </pre>
	 * @param $ACTIVITYTYPE_ID [INTEGER] The unique id of the activitytype we are managing.
	 * @return [void]
	 */
    function __construct( $ACTIVITYTYPE_ID=-1 ) 
    {
    
        $dbTableName = RowManager_ActivityTypeManager::DB_TABLE;
        $fieldList = RowManager_ActivityTypeManager::FIELD_LIST;
        $primaryKeyField = 'activitytype_id';
        $primaryKeyValue = $ACTIVITYTYPE_ID;
        
        if (( $ACTIVITYTYPE_ID != -1 ) && ( $ACTIVITYTYPE_ID != '' )) {
        
            $condition = $primaryKeyField . '=' . $primaryKeyValue;
            
        } else {
            $condition = '';
        }
        $xmlNodeName = RowManager_ActivityTypeManager::XML_NODE_NAME;
        parent::__construct( $dbTableName, $fieldList, $primaryKeyField, $primaryKeyValue, $condition, $xmlNodeName);
        
        $this->dbDescription = RowManager_ActivityTypeManager::DB_TABLE_DESCRIPTION;

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
    
   //************************************************************************
	/**
	 * function getActivityTypeDesc
	 * <pre>
	 * Gets the description of the activity type
	 * </pre>
	 * @return [STRING]
	 */
    function getActivityTypeDesc()
    {
        return $this->getValueByFieldName('activitytype_desc');
    }    
        
        
	/**
	 * function setActivityTypeDesc
	 * <pre>
	 * Sets the description of the activity type
	 * </pre>
	 * @return [STRING]
	 */
    function setActivityTypeID( $activitytype_id )
    {
        $this->setValueByFieldName( 'activitytype_id', $activitytype_id );
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
        return "activitytype_desc";
    }

    
    	
}

?>