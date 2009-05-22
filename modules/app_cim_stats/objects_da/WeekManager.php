<?php
/**
 * @package cim_stats
 */ 
/**
 * class RowManager_WeekManager
 * <pre> 
 * Manages information related to a week.
 * </pre>
 * @author Russ Martin
 */
class  RowManager_WeekManager extends RowManager {

	//CONSTANTS:
	/** The name of the DB Table this class manages. */
    const DB_TABLE = 'cim_stats_week';
    
    /** The SQL description of the DB Table this class manages. */
    /*
     * week_id [INTEGER]  unique id of the week
     * week_endDate [DATE]  Ending date of the week
     */
    const DB_TABLE_DESCRIPTION = " (
  week_id int(10) NOT NULL  auto_increment,
  week_endDate date NOT NULL  default '0000-00-00',
  semester_id int(10) NOT NULL default 0,
  PRIMARY KEY (week_id)
) TYPE=MyISAM";
    
    /** The fields in the DB Table this class manages. */
    const FIELD_LIST = 'week_id,week_endDate,semester_id';
    
    /** The XML node name for this entry. */
    const XML_NODE_NAME = 'week';
    

	//VARIABLES:


	//CLASS CONSTRUCTOR
	//************************************************************************
	/**
	 * function __construct
	 * <pre>
	 * Initialize this object.
	 * </pre>
	 * @param $WEEK_ID [INTEGER] The unique id of the week we are managing.
	 * @return [void]
	 */
    function __construct( $WEEK_ID=-1 ) 
    {
    
        $dbTableName = RowManager_WeekManager::DB_TABLE;
        $fieldList = RowManager_WeekManager::FIELD_LIST;
        $primaryKeyField = 'week_id';
        $primaryKeyValue = $WEEK_ID;
        
        if (( $WEEK_ID != -1 ) && ( $WEEK_ID != '' )) {
        
            $condition = $primaryKeyField . '=' . $primaryKeyValue;
            
        } else {
            $condition = '';
        }
        $xmlNodeName = RowManager_WeekManager::XML_NODE_NAME;
        parent::__construct( $dbTableName, $fieldList, $primaryKeyField, $primaryKeyValue, $condition, $xmlNodeName);
        
        $this->dbDescription = RowManager_WeekManager::DB_TABLE_DESCRIPTION;

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
        return 'week_endDate';
    }
    
    //************************************************************************
	/**
	 * function getValueByFieldName
	 * <pre>
	 * Returns the value of this field.
	 * </pre>
	 * @param $fieldName [STRING] the key for the desired value.
	 * @return [STRING]
	 */
	 // doing a bit of a trick here for the label formating of the date
	 // this overrides the parent function (but still calls it)
    function getValueByFieldName( $fieldName ) 
    {
        $retVal = parent::getValueByFieldName( $fieldName );
        if ( $fieldName == 'week_endDate' )
        {
            $retVal = date( 'd-M-y', strtotime($retVal) );
        }
        
        return $retVal;
    }
    /**
	 * function getEndDate
	 * <pre>
	 * Returns the date - return date is form 'd-M-y'
	 * </pre>
	 * @return [STRING]
	 */
    function getEndDate()
    {
        $retVal = date ( 'Y-m-d', strtotime( $this->getValueByFieldName('week_endDate') ) );
        return $retVal;
    }
    /**
	 * function loadByDate
	 * <pre>
	 * given a date, finds the week that ends on or after that date - $date: in format YYYY-MM-DD - returns true if the item was successfully loaded
	 * </pre>
	 * @return [STRING]
	 */
    function loadByDate( $date )
    {
        return $this->loadByCondition( "week_endDate >= '".$date."' ORDER BY week_endDate limit 1" );   
    }
    
    //************************************************************************
	/**
	 * function getJoinOnWeekID
	 * <pre>
	 * returns the field used as a join condition for week_id
	 * </pre>
	 * @return [STRING]
	 */
    function getJoinOnWeekID()
    {   
        return $this->getJoinOnFieldX('week_id');
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
	 * function setSortByDate
	 * <pre>
	 * sets the sort by date
	 * </pre>
	 * @return [void]
	 */
    function setSortByDate()
    {
        $this->setSortOrder('week_endDate');
        return;
    }
    
    	
}

?>