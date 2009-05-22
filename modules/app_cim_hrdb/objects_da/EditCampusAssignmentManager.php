<?php
/**
 * @package cim_hrdb
 */ 
/**
 * class RowManager_EditCampusAssignmentManager
 * <pre> 
 * Page used to edit campus assignments for people. Assigns campus and some sort of campus status (i.e. student, staff, alumni, etc) to a person..
 * </pre>
 * @author CIM Team
 */
class  RowManager_EditCampusAssignmentManager extends RowManager {

	//CONSTANTS:
	/** The name of the DB Table this class manages. */
    const DB_TABLE = 'cim_hrdb_assignment';
    
    /** The SQL description of the DB Table this class manages. */
    /*
     * assignment_id [INTEGER]  Unique id of some campus assignment for some student
     * person_id [INTEGER]  Unique id of the person being assigned a campus
     * campus_id [INTEGER]  Unique ID of the campus being assigned to a person
     * assignmentstatus_id [INTEGER]  ID referring to a particular status w.r.t. a campus (i.e. student, staff, etc)
     */
    const DB_TABLE_DESCRIPTION = " (
  assignment_id int(50) NOT NULL  auto_increment,
  person_id int(50) NOT NULL  default '0',
  campus_id int(50) NOT NULL  default '0',
  assignmentstatus_id int(10) NOT NULL  default '0',
  PRIMARY KEY (assignment_id)
) TYPE=MyISAM";
    
    /** The fields in the DB Table this class manages. */
    const FIELD_LIST = 'assignment_id,person_id,campus_id,assignmentstatus_id';
    
    /** The XML node name for this entry. */
    const XML_NODE_NAME = 'editcampusassignment';
    

	//VARIABLES:


	//CLASS CONSTRUCTOR
	//************************************************************************
	/**
	 * function __construct
	 * <pre>
	 * Initialize this object.
	 * </pre>
	 * @param $ASSIGNMENT_ID [INTEGER] The unique id of the editcampusassignment we are managing.
	 * @return [void]
	 */
    function __construct( $ASSIGNMENT_ID=-1 ) 
    {
    
        $dbTableName = RowManager_EditCampusAssignmentManager::DB_TABLE;
        $fieldList = RowManager_EditCampusAssignmentManager::FIELD_LIST;
        $primaryKeyField = 'assignment_id';
        $primaryKeyValue = $ASSIGNMENT_ID;
        
        if (( $ASSIGNMENT_ID != -1 ) && ( $ASSIGNMENT_ID != '' )) {
        
            $condition = $primaryKeyField . '=' . $primaryKeyValue;
            
        } else {
            $condition = '';
        }
        $xmlNodeName = RowManager_EditCampusAssignmentManager::XML_NODE_NAME;
        parent::__construct( $dbTableName, $fieldList, $primaryKeyField, $primaryKeyValue, $condition, $xmlNodeName);
        
        $this->dbDescription = RowManager_EditCampusAssignmentManager::DB_TABLE_DESCRIPTION;

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
	 * function getCampusID
	 * <pre>
	 * Returns the field containing the campus ID
	 * @return [STRING]
	 */
    function getCampusID() 
    {
        return $this->getValueByFieldName('campus_id');
    }    
    
    //************************************************************************
	/**
	 * function getJoinOnStatusID
	 * <pre>
	 * returns the field used as a join condition for status_id
	 * </pre>
	 * @return [STRING]
	 */
    function getJoinOnStatusID()
    {   
        return $this->getJoinOnFieldX('assignmentstatus_id');
    }
    
    
    //************************************************************************
	/**
	 * function getJoinOnPersonID
	 * <pre>
	 * returns the field used as a join condition for person_id
	 * </pre>
	 * @return [STRING]
	 */
    function getJoinOnPersonID()
    {   
        return $this->getJoinOnFieldX('person_id');
    }
    
     //************************************************************************
	/**
	 * function getJoinOnCampusID
	 * <pre>
	 * returns the field used as a join condition for campus ID
	 * </pre>
	 * @return [STRING]
	 */
    function getJoinOnCampusID(  )
    {   
        return $this->getJoinOnFieldX('campus_id');
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
	//************************************************************************
	/**
	 * function setAssignmentID
	 * <pre>
	 * sets the assignment ID
	 * </pre>
	 * @return [void]
	 */
    function setAssignmentID( $primaryID )
    {
        $this->setValueByFieldName( 'assignment_id', $primaryID );
        return;
    }
    //************************************************************************
	/**
	 * function setPersonID
	 * <pre>
	 * sets the person's ID
	 * </pre>
	 * @return [void]
	 */
    function setPersonID( $personID )
    {
        $this->setValueByFieldName( 'person_id', $personID );
        return;
    } 
    //************************************************************************
	/**
	 * function setCampusID
	 * <pre>
	 * sets the campus's ID
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
	 * function setStatusID
	 * <pre>
	 * sets the status's ID
	 * </pre>
	 * @return [void]
	 */
    function setStatusID( $statusID )
    {
        $this->setValueByFieldName( 'assignmentstatus_id', $statusID );
        return;
    }        	
}

?>