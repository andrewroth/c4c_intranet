<?php
/**
 * @package p2c_stats
 */ 
/**
 * class RowManager_FreqTypeManager
 * <pre> 
 * Manages frequency type records
 * </pre>
 * @author Hobbe Smit (Oct 24, 2007)
 */
class  RowManager_FreqTypeManager extends RowManager {

	//CONSTANTS:
	
	/** The name of the DB Table this class manages. */
    const DB_TABLE = 'p2c_stats_frequency';
    
    /*** The constants representing the data stored in the table **/
    const YEAR = 1;
    const MONTH = 2;
    const WEEK = 3;
    const DAY = 4;
    const AM_PM = 5;
    const HOUR = 6;
    
    
    /** The SQL description of the DB Table this class manages. */
    /*
     * freq_id [INTEGER]  Unique identifier for this particular freq type record
     * freq_desc [STRING]  The description of the freq. type
     */
    const DB_TABLE_DESCRIPTION = " (                                             
                       `freq_id` int(20) NOT NULL auto_increment,                                     
                       `freq_name` varchar(32) collate latin1_general_ci NOT NULL,                    
                       `freq_desc` varchar(64) collate latin1_general_ci NOT NULL,                    
                       `freq_parent_date_field_index` int(4) NOT NULL default '0',                    
                       `freq_parent_date_field_name` varchar(24) collate latin1_general_ci NOT NULL,  
                       `freq_parent_freq_id` int(20) NOT NULL default '0',                            
                       PRIMARY KEY  (`freq_id`)                                                       
                     ) ENGINE=InnoDB";
    
    /** The fields in the DB Table this class manages. */
    const FIELD_LIST = 'freq_id,freq_name,freq_desc,freq_parent_date_field_index,freq_parent_date_field_name,freq_parent_freq_id';
    
    /** The XML node name for this entry. */
    const XML_NODE_NAME = 'p2c_stats_frequency';
    

	//VARIABLES:


	//CLASS CONSTRUCTOR
	//************************************************************************
	/**
	 * function __construct
	 * <pre>
	 * Initialize this object.
	 * </pre>
	 * @param $FREQ_ID [INTEGER] The unique id of the frequency type we are managing.
	 * @return [void]
	 */
    function __construct( $FREQ_ID=-1 ) 
    {
    
        $dbTableName = RowManager_FreqTypeManager::DB_TABLE;
        $fieldList = RowManager_FreqTypeManager::FIELD_LIST;
        $primaryKeyField = 'freq_id';
        $primaryKeyValue = $FREQ_ID;
        
        if (( $FREQ_ID != -1 ) && ( $FREQ_ID != '' )) {
        
            $condition = $primaryKeyField . '=' . $primaryKeyValue;
            
        } else {
            $condition = '';
        }
        $xmlNodeName = RowManager_FreqTypeManager::XML_NODE_NAME;
        parent::__construct( $dbTableName, $fieldList, $primaryKeyField, $primaryKeyValue, $condition, $xmlNodeName);
        
        $this->dbDescription = RowManager_FreqTypeManager::DB_TABLE_DESCRIPTION;

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
	 * function getFreqTypeDesc
	 * <pre>
	 * returns the freq. type's description
	 * </pre>
	 * @return [STRING]
	 */
    function getFreqTypeDesc()
    {   
        return $this->getValueByFieldName('freq_desc');
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
        return "freq_desc";
    }

    
    	
}

?>