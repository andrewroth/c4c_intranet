<?php
/**
 * @package NSSPayRoll
 */ 
/**
 * class RowManager_HrdbAssignmentManager 
 * <pre> 
 * Manages entries in the HRDB->Assignment table.
 * </pre>
 * @author Johnny Hausman/David Cheong
 */
class  RowManager_HrdbAssignmentManager extends RowManager {

	//CONSTANTS:
	/** The name of the DB Table this class manages. */
    const DB_TABLE = 'assignment';
    
    /** The fields in the DB Table this class manages. */
    const FIELD_LIST = 'assignment_id,assignment_label,city_id';
    
    /** The XML node name for this entry. */
    const XML_NODE_NAME = 'hrdbAssignment';
    

	//VARIABLES:


	//CLASS CONSTRUCTOR
	//************************************************************************
	/**
	 * function __construct
	 * <pre>
	 * Initialize this object.
	 * </pre>
	 * @param $assignmentID [INTEGER] The unique id of the assignment to manage.
	 * @return [void]
	 */
    function __construct( $assignmentID=-1 ) 
    {
        $dbTableName = RowManager_HrdbAssignmentManager::DB_TABLE;
        $fieldList = RowManager_HrdbAssignmentManager::FIELD_LIST;
        $primaryKeyField = 'assignment_id';
        $primaryKeyValue = $assignmentID;
        
        if (( $assignmentID != -1 ) && ( $assignmentID != '' )) {
        
            $condition = $primaryKeyField . '=' . $primaryKeyValue;
            
        } else {
            $condition = '';
        }
        $xmlNodeName = RowManager_HrdbAssignmentManager::XML_NODE_NAME;
        parent::__construct( $dbTableName, $fieldList, $primaryKeyField, $primaryKeyValue, $condition, $xmlNodeName, HR_DB_NAME);
        

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
    
    function getJoinOnAssignmentID()
    {
        return $this->getJoinOnFieldX('assignment_id');
    }
    
    function getJoinOnCityID()
    {
        return $this->getJoinOnFieldX('city_id');
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
        return "assignment_label";
    }
    
    
    
    //************************************************************************
	/**
	 * function getAssignment
	 * <pre>
	 * Returns assignment label 
     * </pre>
	 * @return [STRING]
	 */
    function getAssignment() 
    {
        return $this->getValueByFieldName( 'assignment_label' );
    }
    
    
    
    //************************************************************************
	/**
	 * function getCity
	 * <pre>
	 * Returns city object associated with this assignment. 
     * </pre>
	 * @return [OBJECT]
	 */
    function getCity() 
    {
        $cityID = $this->getCityID();
        return new RowManager_HrdbCityManager( $cityID );
    }
    
    
    
    //************************************************************************
	/**
	 * function getCityID
	 * <pre>
	 * Returns city_id associated with this assignment. 
     * </pre>
	 * @return [INTEGER]
	 */
    function getCityID() 
    {
        return $this->getValueByFieldName( 'city_id' );
    }
       	
}

?>