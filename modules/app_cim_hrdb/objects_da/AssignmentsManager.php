<?php
/**
 * @package cim_hrdb
 */ 
/**
 * class RowManager_AssignmentsManager
 * <pre> 
 * This manages the campus assignments table..
 * </pre>
 * @author CIM Team
 */
class  RowManager_AssignmentsManager extends RowManager {

	//CONSTANTS:
	/** The name of the DB Table this class manages. */
    const DB_TABLE = 'cim_hrdb_assignment';

    /** The SQL description of the DB Table this class manages. */
    /*
     * assignment_id [INTEGER]  This is the key for this table.
     * person_id [INTEGER]  The is the person id for the person assigned to the campus.
     * campus_id [INTEGER]  The is the campus the person is assigned to.
     */
    const DB_TABLE_DESCRIPTION = " (
  assignment_id int(50) NOT NULL  auto_increment,
  person_id int(50) NOT NULL  default '0',
  campus_id int(50) NOT NULL  default '0',
  assignmentstatus_id int(1) NOT NULL,
  PRIMARY KEY (assignment_id)
) TYPE=MyISAM";
    
    /** The fields in the DB Table this class manages. */
    const FIELD_LIST = 'assignment_id,person_id,campus_id,assignmentstatus_id';
    
    /** The XML node name for this entry. */
    const XML_NODE_NAME = 'assignments';
    
    const UNKNOWN_STATUS = 'Unknown Status';
    

	//VARIABLES:


	//CLASS CONSTRUCTOR
	//************************************************************************
	/**
	 * function __construct
	 * <pre>
	 * Initialize this object.
	 * </pre>
	 * @param $ASSIGNMENT_ID [INTEGER] The unique id of the assignments we are managing.
	 * @return [void]
	 */
    function __construct( $ASSIGNMENT_ID=-1 ) 
    {
    
        $dbTableName = RowManager_AssignmentsManager::DB_TABLE;
        $fieldList = RowManager_AssignmentsManager::FIELD_LIST;
        $primaryKeyField = 'assignment_id';
        $primaryKeyValue = $ASSIGNMENT_ID;

        if (( $ASSIGNMENT_ID != -1 ) && ( $ASSIGNMENT_ID != '' )) {

            $condition = $primaryKeyField . '=' . $primaryKeyValue;

        } else {
            $condition = '';
        }
        $xmlNodeName = RowManager_AssignmentsManager::XML_NODE_NAME;
        parent::__construct( $dbTableName, $fieldList, $primaryKeyField, $primaryKeyValue, $condition, $xmlNodeName);

        $this->dbDescription = RowManager_AssignmentsManager::DB_TABLE_DESCRIPTION;

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
	 * function setCampusID
	 * <pre>
	 * Sets the id for the campus
	 * </pre>
	 * @param $title [INT] The campus id.
	 * @return [void]
	 */
    function setCampusID( $campus_ID )
    {
        $this->setValueByFieldName( 'campus_id', $campus_ID );
    }
    
   //************************************************************************
	/**
	 * function setAssignmentStatus
	 * <pre>
	 * Sets the id for the campus assignment
	 * </pre>
	 * @param $title [INT] The campus assignment id.
	 * @return [void]
	 */
    function setAssignmentStatus( $assignstatus_id )
    {
        $this->setValueByFieldName( 'assignmentstatus_id', $assignstatus_id );
    }    

   //************************************************************************
	/**
	 * function setAssignmentStatusID
	 * <pre>
	 * Sets the id for the assignment stats
	 * </pre>
	 * @param $title [INT] The assignment status id.
	 * @return [void]
	 */
    function setAssignmentStatusID( $assignmentstatus_ID )
    {
        $this->setValueByFieldName( 'assignmentstatus_id', $assignmentstatus_ID );
    }

   //************************************************************************
	/**
	 * function getCampusID
	 * <pre>
	 * Gets the id for the campus
	 * </pre>
	 * @param $title [INT] The campus id.
	 * @return [void]
	 */
    function getCampusID()
    {
        return $this->getValueByFieldName('campus_id');
    }
    
    /**
	 * function loadByPersonID
	 * <pre>
	 * Makes the manager load a row using the person id.
	 * </pre>
	 * @return [STRING]
	 */
    function loadByPersonID( $personID )
    {
        $this->loadByCondition( 'person_id='.$personID );
    }
    
    function loadCurrentStudentsStaff( $personID )
    {
        return $this->loadByCondition('person_id='.$personID. ' AND ( assignmentstatus_id='.CA_STAFF.' '. OP_OR . ' assignmentstatus_id='. CA_STUDENT. ')' );
    }

}

?>