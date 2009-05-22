<?php
/**
 * @package cim_stats
 */ 
/**
 * class RowManager_MoreStatsManager
 * <pre> 
 * Manages information regarding additonal weekly stats.
 * </pre>
 * @author Russ Martin
 */
class  RowManager_MoreStatsManager extends RowManager {

	//CONSTANTS:
	/** The name of the DB Table this class manages. */
    const DB_TABLE = 'cim_stats_morestats';
    
    /** The SQL description of the DB Table this class manages. */
    /*
     * morestats_id [INTEGER]  unique id
     * morestats_exp [INTEGER]  How many exposures happened here.
     * morestats_notes [STRING]  Notes of the event that happened
     * week_id [INTEGER]  week_id
     * campus_id [INTEGER]  campus_id
     * exposuretype_id [INTEGER]  exposuretype_id
     */
    const DB_TABLE_DESCRIPTION = " (
  morestats_id int(10) NOT NULL  auto_increment,
  morestats_exp int(10) NOT NULL  default '0',
  morestats_notes text NOT NULL  default '',
  week_id int(10) NOT NULL  default '0',
  campus_id int(10) NOT NULL  default '0',
  exposuretype_id int(10) NOT NULL  default '0',
  PRIMARY KEY (morestats_id)
) TYPE=MyISAM";
    
    /** The fields in the DB Table this class manages. */
    const FIELD_LIST = 'morestats_id,morestats_exp,morestats_notes,week_id,campus_id,exposuretype_id';
    
    /** The XML node name for this entry. */
    const XML_NODE_NAME = 'morestats';
    

	//VARIABLES:


	//CLASS CONSTRUCTOR
	//************************************************************************
	/**
	 * function __construct
	 * <pre>
	 * Initialize this object.
	 * </pre>
	 * @param $MORESTATS_ID [INTEGER] The unique id of the morestats we are managing.
	 * @return [void]
	 */
    function __construct( $MORESTATS_ID=-1 ) 
    {
    
        $dbTableName = RowManager_MoreStatsManager::DB_TABLE;
        $fieldList = RowManager_MoreStatsManager::FIELD_LIST;
        $primaryKeyField = 'morestats_id';
        $primaryKeyValue = $MORESTATS_ID;
        
        if (( $MORESTATS_ID != -1 ) && ( $MORESTATS_ID != '' )) {
        
            $condition = $primaryKeyField . '=' . $primaryKeyValue;
            
        } else {
            $condition = '';
        }
        $xmlNodeName = RowManager_MoreStatsManager::XML_NODE_NAME;
        parent::__construct( $dbTableName, $fieldList, $primaryKeyField, $primaryKeyValue, $condition, $xmlNodeName);
        
        $this->dbDescription = RowManager_MoreStatsManager::DB_TABLE_DESCRIPTION;

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
	 * function getNumExposures
	 * <pre>
	 * Returns the num exposures
	 * </pre>
	 * @return [STRING]
	 */
    function getNumExposures()
    {
        return $this->getValueByFieldName( 'morestats_exp' );
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
        $this->setValueByFieldName('campus_id', $campusID);
        return;
    }
    /**
	 * function setWeekID
	 * <pre>
	 * sets the week ID
	 * </pre>
	 * @return [void]
	 */
    function setWeekID( $weekID)
    {
        $this->setValueByFieldName('week_id', $weekID);
        return;
    }
    /**
	 * function setExposureTypeID
	 * <pre>
	 * sets the exposure Type ID
	 * </pre>
	 * @return [void]
	 */
    function setExposureTypeID( $expID )
    {
        $this->setValueByFieldName('exposuretype_id', $expID );
        return;
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
	 * function getJoinOnExpTypeID
	 * <pre>
	 * returns the field used as a join condition for exposuretype_id
	 * </pre>
	 * @return [STRING]
	 */
    function getJoinOnExpTypeID()
    {   
        return $this->getJoinOnFieldX('exposuretype_id');
    }
    
    	
}

?>