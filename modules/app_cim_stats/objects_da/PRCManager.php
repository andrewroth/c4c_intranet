<?php
/**
 * @package cim_stats
 */ 
/**
 * class RowManager_PRCManager
 * <pre> 
 * Manages information related to someone who has PRC'd.
 * </pre>
 * @author Russ Martin
 */
class  RowManager_PRCManager extends RowManager {

	//CONSTANTS:
	/** The name of the DB Table this class manages. */
    const DB_TABLE = 'cim_stats_prc';
    
    /** The SQL description of the DB Table this class manages. */
    /*
     * prc_id [INTEGER]  unique id
     * prc_firstName [STRING]  The first name of someone who has PRC'd
     * prcMethod_id [INTEGER]  The method by which someone came to Christ
     * prc_witnessName [STRING]  The name(s) of someone who witnessed this person make a decision
     * semester_id [INTEGER]  id of the semester
     * campus_id [INTEGER]  The campus where this person PRC'd
     */
    const DB_TABLE_DESCRIPTION = " (
  prc_id int(10) NOT NULL  auto_increment,
  prc_firstName varchar(128) NOT NULL  default '',
  prcMethod_id int(10) NOT NULL  default '0',
  prc_witnessName varchar(128) NOT NULL  default '',
  prc_notes text NOT NULL,
  prc_7upStarted int(10), NOT NULL default '0',
  prc_7upCompleted int(10), NOT NULL default '0',
  semester_id int(10) NOT NULL  default '0',
  campus_id int(10) NOT NULL  default '0',
  prc_date date NOT NULL default '0000-00-00',
  PRIMARY KEY (prc_id)
) TYPE=MyISAM";
    
    /** The fields in the DB Table this class manages. */
    const FIELD_LIST = 'prc_id,prc_firstName,prcMethod_id,prc_witnessName,prc_notes,prc_7upCompleted,semester_id,campus_id,prc_7upStarted,prc_date';
    
    /** The XML node name for this entry. */
    const XML_NODE_NAME = 'prc';
    

	//VARIABLES:


	//CLASS CONSTRUCTOR
	//************************************************************************
	/**
	 * function __construct
	 * <pre>
	 * Initialize this object.
	 * </pre>
	 * @param $PRC_ID [INTEGER] The unique id of the prc we are managing.
	 * @return [void]
	 */
    function __construct( $PRC_ID=-1, $semester_id=-1, $campus_id=-1 ) 
    {
    
        $dbTableName = RowManager_PRCManager::DB_TABLE;
        $fieldList = RowManager_PRCManager::FIELD_LIST;
        $primaryKeyField = 'prc_id';
        $primaryKeyValue = $PRC_ID;
        
        if (( $PRC_ID != -1 ) && ( $PRC_ID != '' )) {
        
            $condition = $primaryKeyField . '=' . $primaryKeyValue;
            
        } else {
            $condition = '';
        }
        
        $xmlNodeName = RowManager_PRCManager::XML_NODE_NAME;
        parent::__construct( $dbTableName, $fieldList, $primaryKeyField, $primaryKeyValue, $condition, $xmlNodeName);
        
        $this->dbDescription = RowManager_PRCManager::DB_TABLE_DESCRIPTION;

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
	 * function setSemester
	 * <pre>
	 *sets semester
	 * </pre>
	 * @return [void]
	 */
    function setSemester( $semesterID )
    {
        $this->setValueByFieldName('semester_id', $semesterID);
    }
    /**
	 * function setCampus
	 * <pre>
	 * sets the campus
	 * </pre>
	 * @return [void]
	 */
    function setCampus( $campusID )
    {
        $this->setValueByFieldName('campus_id', $campusID);
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
    
    //************************************************************************
	/**
	 * function getJoinOnPrcMethodID
	 * <pre>
	 * returns the field used as a join condition for semester_id
	 * </pre>
	 * @return [STRING]
	 */
    function getJoinOnPrcMethodID()
    {   
        return $this->getJoinOnFieldX('prcMethod_id');
    }

    
    	
}

?>