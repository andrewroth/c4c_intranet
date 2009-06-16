<?php
/**
 * @package cim_stats
 */ 
/**
 * class RowManager_SemesterManager
 * <pre> 
 * Manages information related to semesters.
 * </pre>
 * @author Russ Martin
 */
class  RowManager_SemesterManager extends RowManager {

	//CONSTANTS:
	/** The name of the DB Table this class manages. */
    const DB_TABLE = 'cim_stats_semester';
    
    /** The SQL description of the DB Table this class manages. */
    /*
     * semester_id [INTEGER]  unique id of a semester
     * semester_desc [STRING]  Textual description of the semester
     */
    const DB_TABLE_DESCRIPTION = " (
  semester_id int(10) NOT NULL  auto_increment,
  semester_desc varchar(64) NOT NULL  default '',
  year_id int(8) NOT NULL,
  PRIMARY KEY (semester_id)
) TYPE=MyISAM";
    
    /** The fields in the DB Table this class manages. */
    const FIELD_LIST = 'semester_id,semester_desc,year_id';
    
    /** The XML node name for this entry. */
    const XML_NODE_NAME = 'semester';
    

	//VARIABLES:


	//CLASS CONSTRUCTOR
	//************************************************************************
	/**
	 * function __construct
	 * <pre>
	 * Initialize this object.
	 * </pre>
	 * @param $SEMESTER_ID [INTEGER] The unique id of the semester we are managing.
	 * @return [void]
	 */
    function __construct( $SEMESTER_ID=-1 ) 
    {
    
        $dbTableName = RowManager_SemesterManager::DB_TABLE;
        $fieldList = RowManager_SemesterManager::FIELD_LIST;
        $primaryKeyField = 'semester_id';
        $primaryKeyValue = $SEMESTER_ID;
        
        if (( $SEMESTER_ID != -1 ) && ( $SEMESTER_ID != '' )) {
        
            $condition = $primaryKeyField . '=' . $primaryKeyValue;
            
        } else {
            $condition = '';
        }
        $xmlNodeName = RowManager_SemesterManager::XML_NODE_NAME;
        parent::__construct( $dbTableName, $fieldList, $primaryKeyField, $primaryKeyValue, $condition, $xmlNodeName);
        
        $this->dbDescription = RowManager_SemesterManager::DB_TABLE_DESCRIPTION;

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
        return 'semester_desc';
    }
    
	/**
	 * function loadByDate
	 * <pre>
	 * Finds the semester associated with the given date - $date: YYYY-MM-DD - returns false if no semester is found
	 * </pre>
	 * @return [BOOLEAN]
	 */
    function loadByDate( $date )
    {
        return $this->loadByCondition("semester_startDate <= '".$date."' order by semester_startDate desc limit 1");
    }
    
	/**
	 * function checkIfFirstSemester
	 * <pre>
	 * Checks if the desired date is before the start of the first semester in the table - $date: YYYY-MM-DD  - returns false if no semester is found
	 * </pre>
	 * @return [BOOLEAN]
	 */
    function checkIfFirstSemester( $date )
    {
        return $this->loadByCondition("semester_startDate >= '".$date."' order by semester_startDate limit 1");
    }
    /**
	 * function setSemesterID
	 * <pre>
	 * sets the semester ID
	 * </pre>
	 * @return [void]
	 */
    function setSemesterID( $id )
    {
        $this->setValueByFieldName('semester_id', $id );
        return;
    }
    /**
	 * function setYearID
	 * <pre>
	 * sets the year ID
	 * </pre>
	 * @return [void]
	 */
    function setYearID( $id )
    {
        $this->setValueByFieldName( 'year_id', $id );
        return;
    }

    function getYearID()
    {
    	return $this->getValueByFieldName('year_id');
    }
    
    //************************************************************************
	/**
	 * function getJoinOnSemesterID
	 * <pre>
	 * returns the field used as a join condition for semester_id
	 * </pre>
	 * @return [STRING]
	 */
    function getJoinOnSemesterID()
    {   
        return $this->getJoinOnFieldX('semester_id');
    }

    
    	
}

?>
