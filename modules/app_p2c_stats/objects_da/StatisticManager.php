<?php
/**
 * @package p2c_stats
 */ 
/**
 * class RowManager_StatisticManager
 * <pre> 
 * Manages statistic (name) records
 * </pre>
 * @author Hobbe Smit (Oct 24, 2007)
 */
class  RowManager_StatisticManager extends RowManager {

	//CONSTANTS:
	
	/** The name of the DB Table this class manages. */
    const DB_TABLE = 'p2c_stats_statistic';
    
    /** The SQL description of the DB Table this class manages. */
    /*
     * statistic_id [INTEGER]  Unique identifier for this particular statistic (name) record
     * scope_id [INTEGER]  The scope that the statistic applies to (i.e. ministry, division, region, location, etc)
     * scope_ref_id [INTEGER]  The id of the specific ministry, division, region, or location (or some new scope)
     * freq_id [INTEGER]  The frequency type associated with this statistic (i.e. daily, weekly, annually, etc)
     * meas_id [INTEGER]  The measurement type associated with the statistic (i.e. Personal Ministry, Team Ministry, etc)
     */
    const DB_TABLE_DESCRIPTION = " (                                                                                 
                       `statistic_id` int(11) NOT NULL auto_increment,                                                                    
                       `statistic_name` varchar(64) collate latin1_general_ci NOT NULL,                                                   
                       `statistic_desc` varchar(128) collate latin1_general_ci NOT NULL,                                                  
                       `statistic_type_id` int(4) NOT NULL default '0',                                                   
                       `scope_id` int(10) NOT NULL default '0',                                                                           
                       `scope_ref_id` int(50) NOT NULL default '0',                                                                       
                       `freq_id` int(20) NOT NULL default '0',                                                                            
                       `meas_id` int(20) NOT NULL default '0',                                                                            
                       PRIMARY KEY  (`statistic_id`),                                                                                     
                       KEY `FK_stat_scope` (`scope_id`),                                                                                  
                       KEY `FK_stat_freq` (`freq_id`),                                                                                    
                       KEY `FK_stat_meas` (`meas_id`),                                                                                    
                       CONSTRAINT `FK_stat_meas` FOREIGN KEY (`meas_id`) REFERENCES `p2c_stats_measure` (`meas_id`) ON UPDATE CASCADE,    
                       CONSTRAINT `FK_stat_freq` FOREIGN KEY (`freq_id`) REFERENCES `p2c_stats_frequency` (`freq_id`) ON UPDATE CASCADE,  
                       CONSTRAINT `FK_stat_scope` FOREIGN KEY (`scope_id`) REFERENCES `p2c_stats_scope` (`scope_id`) ON UPDATE CASCADE,
                       CONSTRAINT `FK_stat_scope` FOREIGN KEY (`statistic_type_id`) REFERENCES `p2c_stats_stattype` (`statistic_type_id`) ON UPDATE CASCADE, 
                     ) ENGINE=InnoDB";
    
    /** The fields in the DB Table this class manages. */
    const FIELD_LIST = 'statistic_id,statistic_name,statistic_desc,statistic_type_id,scope_id,scope_ref_id,freq_id,meas_id';
    
    /** The XML node name for this entry. */
    const XML_NODE_NAME = 'p2c_stats_statistics';
    

	//VARIABLES:


	//CLASS CONSTRUCTOR
	//************************************************************************
	/**
	 * function __construct
	 * <pre>
	 * Initialize this object.
	 * </pre>
	 * @param $STAT_ID [INTEGER] The unique id of the statistic we are managing.
	 * @return [void]
	 */
    function __construct( $STAT_ID=-1 ) 
    {
    
        $dbTableName = RowManager_StatisticManager::DB_TABLE;
        $fieldList = RowManager_StatisticManager::FIELD_LIST;
        $primaryKeyField = 'statistic_id';
        $primaryKeyValue = $STAT_ID;
        
        if (( $STAT_ID != -1 ) && ( $STAT_ID != '' )) {
        
            $condition = $primaryKeyField . '=' . $primaryKeyValue;
            
        } else {
            $condition = '';
        }
        $xmlNodeName = RowManager_StatisticManager::XML_NODE_NAME;
        parent::__construct( $dbTableName, $fieldList, $primaryKeyField, $primaryKeyValue, $condition, $xmlNodeName);
        
        $this->dbDescription = RowManager_StatisticManager::DB_TABLE_DESCRIPTION;

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
	 * function getStatisticDesc
	 * <pre>
	 * returns the statistic's description
	 * </pre>
	 * @return [STRING]
	 */
    function getStatisticDesc()
    {   
        return $this->getValueByFieldName('statistic_desc');
    }  
    
     //************************************************************************
	/**
	 * function getStatisticID
	 * <pre>
	 * returns the statistic ID
	 * </pre>
	 * @return [STRING]
	 */
    function getStatisticID()
    {   
        return $this->getValueByFieldName('statistic_id');
    }       
    
    
    //************************************************************************
	/**
	 * function getJoinOnStatisticID
	 * <pre>
	 * returns the field used as a join condition for statistic_id
	 * </pre>
	 * @return [STRING]
	 */
    function getJoinOnStatID()
    {   
        return $this->getJoinOnFieldX('statistic_id');
    }
    
   /**
	 * function getJoinOnScopeID
	 * <pre>
	 * returns the field used as a join condition for scope_id
	 * </pre>
	 * @return [STRING]
	 */
    function getJoinOnScopeID()
    {   
        return $this->getJoinOnFieldX('scope_id');
    }
    
    /**
	 * function getJoinOnScopeRefID
	 * <pre>
	 * returns the field used as a join condition for scope_ref ID
	 * </pre>
	 * @return [STRING]
	 */
    function getJoinOnScopeRefID()
    {   
        return $this->getJoinOnFieldX('scope_ref_id');
    }
    
    
   /**
	 * function getJoinOnFreqID
	 * <pre>
	 * returns the field used as a join condition for freq ID
	 * </pre>
	 * @return [STRING]
	 */
    function getJoinOnFreqID()
    {   
        return $this->getJoinOnFieldX('freq_id');
    }    
    
    
   /**
	 * function setScopeID
	 * <pre>
	 * Set the scope ID for the statistic
	 * </pre>
     *
	 * @param $scopeID		the ID of the scope
	 */
    function setScopeID($scopeID) 
    {
        $this->setValueByFieldName('scope_id',$scopeID);
        //return $this->getValueByFieldName( 'applicant_codename' );
    }
    

    /**
	 * function setScopeRefID
	 * <pre>
	 * Set the scope ref ID for the statistic
	 * </pre>
     *
	 * @param $scopeRefID		the reference (location, ministry, etc) ID of the scope
	 */
    function setScopeRefID($scopeRefID) 
    {
        $this->setValueByFieldName('scope_ref_id',$scopeRefID);
    }    
    
    /**
	 * function setFreqID
	 * <pre>
	 * Set the freq ID for the statistic
	 * </pre>
     *
	 * @param $freqID		the freq ID of the statistic
	 */
    function setFreqID($freqID) 
    {
        $this->setValueByFieldName('freq_id',$freqID);
    }        
    
    /**
	 * function setMeasureTypeID
	 * <pre>
	 * Set the measure type ID for the statistic
	 * </pre>
     *
	 * @param $measID		the measure type ID for the statistic
	 */
    function setMeasureTypeID($measID) 
    {
        $this->setValueByFieldName('meas_id',$measID);
    }    
    
    	
    /**
	 * function setStatisticID
	 * <pre>
	 * Set the statistic ID 
	 * </pre>
     *
	 * @param $stat_id		the ID of the statistic
	 */
    function setStatisticID($stat_id) 
    {
        $this->setValueByFieldName('statistic_id',$stat_id);
    } 
    
    

    function setSortByStatID() 
    {
        $this->setSortOrder('statistic_id');
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
        return "statistic_name";
    }

    
    	
}

?>