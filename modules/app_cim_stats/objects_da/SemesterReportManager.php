<?php
/**
 * @package cim_stats
 */ 
/**
 * class RowManager_SemesterReportManager
 * <pre> 
 * Manages stats information for a campus from a given semester.
 * </pre>
 * @author Russ Martin
 */
class  RowManager_SemesterReportManager extends RowManager {

	//CONSTANTS:
	/** The name of the DB Table this class manages. */
    const DB_TABLE = 'cim_stats_semesterreport';
    
    /** The SQL description of the DB Table this class manages. */
    /*
     * semesterreport_id [INTEGER]  Unique id
     * semesterreport_avgPrayer [INTEGER]  Average attendence at prayer meetings over the semester
     * semesterreport_avgWklyMtg [INTEGER]  The average attendence at the weekly meetings over the semester.
     * semesterreport_numStaffChall [INTEGER]  Number of people challenged to staff
     * semesterreport_numInternChall [INTEGER]  number challenged to an internship
     * semesterreport_numFrosh [INTEGER]  number of frosh involved
     * semesterreport_numStaffDG [INTEGER]  number of staff led DGs
     * semesterreport_numInStaffDG [INTEGER]  number of students in staff led DGs
     * semesterreport_numStudentDG [INTEGER]  number of student led DGs
     * semesterreport_numInStudentDG [INTEGER]  number of students in student-led DGs
     * semesterreport_numSpMultStaffDG [INTEGER]  Number of SP mults in staff led DGs
     * semesterreport_numSpMultStdDG [INTEGER]  Number of sp mults in student led DGs
     * semester_id [INTEGER]  id of the semester
     * campus_id [INTEGER]  id of the campus
     */
    const DB_TABLE_DESCRIPTION = " (
  semesterreport_id int(10) NOT NULL  auto_increment,
  semesterreport_avgPrayer int(10) NOT NULL  default '0',
  semesterreport_avgWklyMtg int(10) NOT NULL  default '0',
  semesterreport_numStaffChall int(10) NOT NULL  default '0',
  semesterreport_numInternChall int(10) NOT NULL  default '0',
  semesterreport_numFrosh int(10) NOT NULL  default '0',
  semesterreport_numStaffDG int(10) NOT NULL  default '0',
  semesterreport_numInStaffDG int(10) NOT NULL  default '0',
  semesterreport_numStudentDG int(10) NOT NULL  default '0',
  semesterreport_numInStudentDG int(10) NOT NULL  default '0',
  semesterreport_numSpMultStaffDG int(10) NOT NULL  default '0',
  semesterreport_numSpMultStdDG int(10) NOT NULL  default '0',
  semester_id int(10) NOT NULL  default '0',
  campus_id int(10) NOT NULL  default '0',
  PRIMARY KEY (semesterreport_id)
) TYPE=MyISAM";
    
    /** The fields in the DB Table this class manages. */
    const FIELD_LIST = 'semesterreport_id,semesterreport_avgPrayer,semesterreport_avgWklyMtg,semesterreport_numStaffChall,semesterreport_numInternChall,semesterreport_numFrosh,semesterreport_numStaffDG,semesterreport_numInStaffDG,semesterreport_numStudentDG,semesterreport_numInStudentDG,semesterreport_numSpMultStaffDG,semesterreport_numSpMultStdDG,semester_id,campus_id';
    
    /** The XML node name for this entry. */
    const XML_NODE_NAME = 'semesterreport';
    

	//VARIABLES:


	//CLASS CONSTRUCTOR
	//************************************************************************
	/**
	 * function __construct
	 * <pre>
	 * Initialize this object.
	 * </pre>
	 * @param $SEMESTER_ID [INTEGER] The unique id of the semesterreport we are managing.
	 * @return [void]
	 */
    function __construct( $SEMESTER_ID=-1, $campusID=-1 ) 
    {
    
        $dbTableName = RowManager_SemesterReportManager::DB_TABLE;
        $fieldList = RowManager_SemesterReportManager::FIELD_LIST;
        $primaryKeyField = 'semesterreport_id';
        $primaryKeyValue = -1;
        
        if (( $SEMESTER_ID != -1 ) && ( $SEMESTER_ID != '' )) {
        
            $condition = 'semester_id=' . $SEMESTER_ID;
            
            if (( $campusID != -1 ) && ( $campusID != '' )) {
                $condition .= ' AND campus_id='.$campusID;
            }
        } else {
            $condition = '';
        }
        // echo 'The condition is ['.$condition.']<br/>';
        $xmlNodeName = RowManager_SemesterReportManager::XML_NODE_NAME;
        parent::__construct( $dbTableName, $fieldList, $primaryKeyField, $primaryKeyValue, $condition, $xmlNodeName);
        
        $this->dbDescription = RowManager_SemesterReportManager::DB_TABLE_DESCRIPTION;

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
	 * function setCampusID
	 * <pre>
	 * sets the campus ID
	 * </pre>
	 * @return [void]
	 */
    function setCampusID( $campusID )
    {
        $this->setValueByFieldName('campus_id', $campusID );
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

    
    	
}

?>