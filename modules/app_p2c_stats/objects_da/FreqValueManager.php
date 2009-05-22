<?php
/**
 * @package p2c_stats
 */ 
/**
 * class RowManager_FreqValueManager
 * <pre> 
 * Manages frequency value records
 * </pre>
 * @author Hobbe Smit (Oct 26, 2007)
 */
class  RowManager_FreqValueManager extends RowManager {

	//CONSTANTS:
	
	/** The name of the DB Table this class manages. */
    const DB_TABLE = 'p2c_stats_freqvalue';
    
    /** The SQL description of the DB Table this class manages. */
    /*
     * freq_id [INTEGER]  Unique identifier for this particular freq type record
     * freqvalue_desc [STRING]  The description of the freq. value (i.e. 'Week 2')
     */
    const DB_TABLE_DESCRIPTION = " (                                                                                         
                       `freqvalue_id` int(50) NOT NULL auto_increment,                                                                            
                       `freq_id` int(20) NOT NULL,                                                                                                
                       `freqvalue_value` datetime default '0000-00-00 00:00:00',                                                                  
                       `freqvalue_desc` varchar(48) collate latin1_general_ci NOT NULL,                                                           
                       PRIMARY KEY  (`freqvalue_id`),                                                                                             
                       KEY `FK_freqvalue_freqtype` (`freq_id`),                                                                                   
                       CONSTRAINT `FK_freqvalue_freqtype` FOREIGN KEY (`freq_id`) REFERENCES `p2c_stats_frequency` (`freq_id`) ON UPDATE CASCADE  
                     ) ENGINE=InnoDB";
    
    /** The fields in the DB Table this class manages. */
    const FIELD_LIST = 'freqvalue_id,freq_id,freqvalue_value,freqvalue_desc';
    
    /** The XML node name for this entry. */
    const XML_NODE_NAME = 'p2c_stats_freqvalue';
    

	//VARIABLES:


	//CLASS CONSTRUCTOR
	//************************************************************************
	/**
	 * function __construct
	 * <pre>
	 * Initialize this object.
	 * </pre>
	 * @param $FREQVAL_ID [INTEGER] The unique id of the frequency value we are managing.
	 * @return [void]
	 */
    function __construct( $FREQVAL_ID=-1 ) 
    {
    
        $dbTableName = RowManager_FreqValueManager::DB_TABLE;
        $fieldList = RowManager_FreqValueManager::FIELD_LIST;
        $primaryKeyField = 'freqvalue_id';
        $primaryKeyValue = $FREQVAL_ID;
        
        if (( $FREQVAL_ID != -1 ) && ( $FREQVAL_ID != '' )) {
        
            $condition = $primaryKeyField . '=' . $primaryKeyValue;
            
        } else {
            $condition = '';
        }
        $xmlNodeName = RowManager_FreqValueManager::XML_NODE_NAME;
        parent::__construct( $dbTableName, $fieldList, $primaryKeyField, $primaryKeyValue, $condition, $xmlNodeName);
        
        $this->dbDescription = RowManager_FreqValueManager::DB_TABLE_DESCRIPTION;

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
	 * function getFreqValue
	 * <pre>
	 * returns the freq. value
	 * </pre>
	 * @return [STRING]
	 */
    function getFreqValue()
    {   
        return $this->getValueByFieldName('freqvalue_value');
    }      
    
     //************************************************************************
	/**
	 * function getFreqValueDesc
	 * <pre>
	 * returns the freq. value's description
	 * </pre>
	 * @return [STRING]
	 */
    function getFreqValueDesc()
    {   
        return $this->getValueByFieldName('freqvalue_desc');
    }  
    
     //************************************************************************
	/**
	 * function getFreqID
	 * <pre>
	 * returns the freq ID
	 * </pre>
	 * @return [STRING]
	 */
    function getFreqID()
    {   
        return $this->getValueByFieldName('freq_id');
    }       
    
    
    //************************************************************************
	/**
	 * function getJoinOnFreqID
	 * <pre>
	 * returns the field used as a join condition for freq_id
	 * </pre>
	 * @return [STRING]
	 */
    function getJoinOnFreqID()
    {   
        return $this->getJoinOnFieldX('freq_id');
    }
    
    //************************************************************************
	/**
	 * function getJoinOnFreqValueID
	 * <pre>
	 * returns the field used as a join condition for freqvalue_id
	 * </pre>
	 * @return [STRING]
	 */
    function getJoinOnFreqValueID()
    {   
        return $this->getJoinOnFieldX('freqvalue_id');
    }
     
    
   /**
	 * function setFreqID
	 * <pre>
	 * Set the freq type ID for the freq. type
	 * </pre>
     *
	 * @param $freqID		the ID of the freq. type
	 */
    function setFreqID($freqID) 
    {
        $this->setValueByFieldName('freq_id',$freqID);
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
        return "freqvalue_desc";
    }

    
    
    
    function setSortByDateTime()
    {
        $this->setSortOrder('freqvalue_value');
        return;
    }    
    	
}

?>