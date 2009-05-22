<?php
/**
 * @package p2c_stats
 */ 
/**
 * class RowManager_StatValueManager
 * <pre> 
 * Manages statistic (value) records
 * </pre>
 * @author Hobbe Smit (Oct 25, 2007)
 */
class  RowManager_StatValueManager extends RowManager {

	//CONSTANTS:
	
	/** The name of the DB Table this class manages. */
    const DB_TABLE = 'p2c_stats_statvalues';
    
    /** The SQL description of the DB Table this class manages. */
    /*
     * statvalues_id [INTEGER]   Unique identifier for this particular statistic value
     * statistic_id [INTEGER]   identifier for this particular statistic description
     * scope_id [INTEGER]  The scope that the statistic applies to (i.e. ministry, division, region, location, etc)
     * scope_ref_id [INTEGER]  The id of the specific ministry, division, region, or location (or some new scope)
     *
     * freqvalue_id [INTEGER]  The frequency VALUE associated with this statistic (i.e. a particular week, month, year, etc)
     * meastype_id [INTEGER]  The measurement type associated with the statistic (i.e. Personal Ministry, Team Ministry, etc)
     *
     * person_id [INTEGER]  The person associated with this statistic value (most often the person entering the data)   
     */
    const DB_TABLE_DESCRIPTION = " (                                                                                              
                        `statvalues_id` int(50) NOT NULL auto_increment,                                                                                 
                        `statistic_id` int(50) NOT NULL default '0',                                                                                     
                        `scope_id` int(10) NOT NULL default '0',                                                                                         
                        `scope_ref_id` int(50) NOT NULL default '0' COMMENT 'min, div, reg, or loc id',                                                  
                        `statvalues_value` varchar(64) collate latin1_general_ci NOT NULL,                                                               
                        `freqvalue_id` int(50) NOT NULL default '0',                                                                                     
                        `meastype_id` int(20) NOT NULL default '0',                                                                                      
                        `statvalues_modtime` timestamp NULL default CURRENT_TIMESTAMP,                                                                   
                        `person_id` int(50) NOT NULL default '0',                                                                                        
                        PRIMARY KEY  (`statvalues_id`),                                                                                                  
                        KEY `FK_value_stat` (`statistic_id`),                                                                                            
                        KEY `FK_value_scope` (`scope_id`),                                                                                               
                        KEY `FK_value_freqval` (`freqvalue_id`),                                                                                         
                        KEY `FK_value_measure` (`meastype_id`),                                                                                          
                        KEY `FK_value_person` (`person_id`),                                                                                             
                        CONSTRAINT `FK_value_person` FOREIGN KEY (`person_id`) REFERENCES `cim_hrdb_person` (`person_id`) ON UPDATE CASCADE,             
                        CONSTRAINT `FK_value_freqval` FOREIGN KEY (`freqvalue_id`) REFERENCES `p2c_stats_freqvalue` (`freqvalue_id`) ON UPDATE CASCADE,  
                        CONSTRAINT `FK_value_measure` FOREIGN KEY (`meastype_id`) REFERENCES `p2c_stats_measure` (`meas_id`) ON UPDATE CASCADE,          
                        CONSTRAINT `FK_value_scope` FOREIGN KEY (`scope_id`) REFERENCES `p2c_stats_scope` (`scope_id`) ON UPDATE CASCADE,                
                        CONSTRAINT `FK_value_stat` FOREIGN KEY (`statistic_id`) REFERENCES `p2c_stats_statistic` (`statistic_id`) ON UPDATE CASCADE      
                      ) ENGINE=InnoDB";
    
    /** The fields in the DB Table this class manages. */
    const FIELD_LIST = 'statvalues_id,statistic_id,scope_id,scope_ref_id,statvalues_value,freqvalue_id,meastype_id,statvalues_modtime,person_id';
    
    /** The XML node name for this entry. */
    const XML_NODE_NAME = 'p2c_stats_statvalues';
    

	//VARIABLES:


	//CLASS CONSTRUCTOR
	//************************************************************************
	/**
	 * function __construct
	 * <pre>
	 * Initialize this object.
	 * </pre>
	 * @param $STATVALUE_ID [INTEGER] The unique id of the statistic value we are managing.
	 * @return [void]
	 */
    function __construct( $STATVALUE_ID=-1 ) 
    {
    
        $dbTableName = RowManager_StatValueManager::DB_TABLE;
        $fieldList = RowManager_StatValueManager::FIELD_LIST;
        $primaryKeyField = 'statvalues_id';
        $primaryKeyValue = $STATVALUE_ID;
        
        if (( $STATVALUE_ID != -1 ) && ( $STATVALUE_ID != '' )) {
        
            $condition = $primaryKeyField . '=' . $primaryKeyValue;
            
        } else {
            $condition = '';
        }
        $xmlNodeName = RowManager_StatValueManager::XML_NODE_NAME;
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
	 * function getStatValue
	 * <pre>
	 * returns the statistic value
	 * </pre>
	 * @return [STRING]
	 */
    function getStatValue()
    {   
        return $this->getValueByFieldName('statvalues_value');
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
	 * function getJoinOnFreqValueID
	 * <pre>
	 * returns the field used as a join condition for freq value ID
	 * </pre>
	 * @return [STRING]
	 */
    function getJoinOnFreqValueID()
    {   
        return $this->getJoinOnFieldX('freqvalue_id');
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
	 * function setFreqValueID
	 * <pre>
	 * Set the freq value ID for the statistic value
	 * </pre>
     *
	 * @param $freqValID		the freq value ID of the statistic value
	 */
    function setFreqValueID($freqValID) 
    {
        $this->setValueByFieldName('freqvalue_id',$freqValID);
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
        $this->setValueByFieldName('meastype_id',$measID);
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
        $this->setSortOrder('stat_id');
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

    
    	
}

?>