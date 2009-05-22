<?php
/**
 * @package cim_hrdb
 */ 
/**
 * class RowManager_StaffManager
 * <pre> 
 * DAObj to manage the staff table..
 * </pre>
 * @author CIM Team
 */
class  RowManager_StaffManager extends RowManager {

	//CONSTANTS:
	/** The name of the DB Table this class manages. */
    const DB_TABLE = 'cim_hrdb_staff';
    
    /** The SQL description of the DB Table this class manages. */
    /*
     * staff_id [INTEGER]  The id for the staff member.
     * person_id [INTEGER]  The id of the person who is staff.
     */
    const DB_TABLE_DESCRIPTION = " (
  staff_id int(50) NOT NULL  auto_increment,
  person_id int(50) NOT NULL  default '0',
  is_active int(1) NOT NULL  default '1',  
  PRIMARY KEY (staff_id)
) TYPE=MyISAM";
    
    /** The fields in the DB Table this class manages. */
    const FIELD_LIST = 'staff_id,person_id,is_active';
    
    /** The XML node name for this entry. */
    const XML_NODE_NAME = 'staff';
    

	//VARIABLES:


	//CLASS CONSTRUCTOR
	//************************************************************************
	/**
	 * function __construct
	 * <pre>
	 * Initialize this object.
	 * </pre>
	 * @param $STAFF_ID [INTEGER] The unique id of the staff we are managing.
	 * @return [void]
	 */
    function __construct( $STAFF_ID=-1 ) 
    {
    
        $dbTableName = RowManager_StaffManager::DB_TABLE;
        $fieldList = RowManager_StaffManager::FIELD_LIST;
        $primaryKeyField = 'staff_id';
        $primaryKeyValue = $STAFF_ID;
        
        if (( $STAFF_ID != -1 ) && ( $STAFF_ID != '' )) {
        
            $condition = $primaryKeyField . '=' . $primaryKeyValue;
            
        } else {
            $condition = '';
        }
        $xmlNodeName = RowManager_StaffManager::XML_NODE_NAME;
        parent::__construct( $dbTableName, $fieldList, $primaryKeyField, $primaryKeyValue, $condition, $xmlNodeName);
        
        $this->dbDescription = RowManager_StaffManager::DB_TABLE_DESCRIPTION;

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
    
    
   //************************************************************************
	/**
	 * function setStaffID
	 * <pre>
	 * Sets the id for the staff
	 * </pre>
	 * @param $title [INT] The staff id.
	 * @return [void]
	 */
    function setStaffID( $staff_ID )
    {
        $this->setValueByFieldName( 'staff_id', $staff_ID );
    }    
    
   //************************************************************************
	/**
	 * function setIsActive
	 * <pre>
	 * Sets the active status
	 * </pre>
	 * @param $is_active [INT] The staff active status
	 * @return [void]
	 */
    function setIsActive( $is_active )
    {
        $this->setValueByFieldName( 'is_active', $is_active );
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
        return "staff_id";
    }
    /**
	 * function getPersonID
	 * <pre>
	 * gets the person's Id
	 * </pre>
	 * @return [void]
	 */
    function getPersonID()
    {
        return $this->getValueByFieldName('person_id');
    }
    /**
	 * function getIsActive
	 * <pre>
	 * get's the is active variable - checks if something is actvie
	 * </pre>
	 * @return [INT?]
	 */
    function getIsActive()
    {
        return $this->getValueByFieldName('is_active');
    } 
       
    
    //************************************************************************
	/**
	 * function getJoinOnStaffID
	 * <pre>
	 * returns the field used as a join condition for campus_id
	 * </pre>
	 * @return [STRING]
	 */
    function getJoinOnStaffID()
    {   
        return $this->getJoinOnFieldX('staff_id');
    }
    
    //************************************************************************
	/**
	 * function getJoinOnPersonID
	 * <pre>
	 * returns the field used as a join condition for campus_id
	 * </pre>
	 * @return [STRING]
	 */
    function getJoinOnPersonID()
    {   
        return $this->getJoinOnFieldX('person_id');
    }
    	
}

?>