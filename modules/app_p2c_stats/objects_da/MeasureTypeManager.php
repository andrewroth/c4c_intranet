<?php
/**
 * @package p2c_stats
 */ 
/**
 * class RowManager_MeasureTypeManager
 * <pre> 
 * Manages measurement type records
 * </pre>
 * @author Hobbe Smit (Oct 25, 2007)
 */
class  RowManager_MeasureTypeManager extends RowManager {

	//CONSTANTS:
	
	/** The name of the DB Table this class manages. */
    const DB_TABLE = 'p2c_stats_measure';
    
    /** The SQL description of the DB Table this class manages. */
    /*
     * meas_id [INTEGER]  Unique identifier for this particular measurement type record
     * meas_name [STRING]  The description of the measurement name
     * meas_desc [STRING]  The description of the measurement type
     */
    const DB_TABLE_DESCRIPTION = " (                                
                     `meas_id` int(20) NOT NULL auto_increment,                      
                     `meas_name` varchar(64) collate latin1_general_ci NOT NULL,     
                     `meas_desc` varchar(128) collate latin1_general_ci NOT NULL,    
                     PRIMARY KEY  (`meas_id`)                                        
                   ) ENGINE=InnoDB";
    
    /** The fields in the DB Table this class manages. */
    const FIELD_LIST = 'meas_id,meas_name,meas_desc';
    
    /** The XML node name for this entry. */
    const XML_NODE_NAME = 'p2c_stats_measure';
    

	//VARIABLES:


	//CLASS CONSTRUCTOR
	//************************************************************************
	/**
	 * function __construct
	 * <pre>
	 * Initialize this object.
	 * </pre>
	 * @param $MEAS_ID [INTEGER] The unique id of the frequency type we are managing.
	 * @return [void]
	 */
    function __construct( $MEAS_ID=-1 ) 
    {
    
        $dbTableName = RowManager_MeasureTypeManager::DB_TABLE;
        $fieldList = RowManager_MeasureTypeManager::FIELD_LIST;
        $primaryKeyField = 'meas_id';
        $primaryKeyValue = $MEAS_ID;
        
        if (( $MEAS_ID != -1 ) && ( $MEAS_ID != '' )) {
        
            $condition = $primaryKeyField . '=' . $primaryKeyValue;
            
        } else {
            $condition = '';
        }
        $xmlNodeName = RowManager_MeasureTypeManager::XML_NODE_NAME;
        parent::__construct( $dbTableName, $fieldList, $primaryKeyField, $primaryKeyValue, $condition, $xmlNodeName);
        
        $this->dbDescription = RowManager_MeasureTypeManager::DB_TABLE_DESCRIPTION;

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
	 * function getMeasureTypeDesc
	 * <pre>
	 * returns the meas. type's description
	 * </pre>
	 * @return [STRING]
	 */
    function getMeasureTypeDesc()
    {   
        return $this->getValueByFieldName('meas_desc');
    }  
    
     //************************************************************************
	/**
	 * function getMeasureTypeName
	 * <pre>
	 * returns the meas. type's name
	 * </pre>
	 * @return [STRING]
	 */
    function getMeasureTypeName()
    {   
        return $this->getValueByFieldName('meas_name');
    }      
    
     //************************************************************************
	/**
	 * function getMeasureID
	 * <pre>
	 * returns the measure ID
	 * </pre>
	 * @return [STRING]
	 */
    function getMeasureID()
    {   
        return $this->getValueByFieldName('meas_id');
    }       
    
    
    //************************************************************************
	/**
	 * function getJoinOnMeasureID
	 * <pre>
	 * returns the field used as a join condition for meas_id
	 * </pre>
	 * @return [STRING]
	 */
    function getJoinOnMeasureID()
    {   
        return $this->getJoinOnFieldX('meas_id');
    }
    
 
    
   /**
	 * function setMeasureID
	 * <pre>
	 * Set the measure type ID for the measure type
	 * </pre>
     *
	 * @param $measID		the ID of the measure type
	 */
    function setMeasureID($measID) 
    {
        $this->setValueByFieldName('meas_id',$measID);
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
        return "meas_name";
    }

    
    	
}

?>