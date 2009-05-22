<?php
/**
 * @package p2c_stats
 */ 
/**
 * class RowManager_ReportFilterManager
 * <pre> 
 * Manages records storing filters associated with stats reports (i.e. SUM, AVG, etc)
 * </pre>
 * @author Hobbe Smit (Nov 1, 2007)
 */
class  RowManager_ReportFilterManager extends RowManager {

	//CONSTANTS:
	
	/** The name of the DB Table this class manages. */
    const DB_TABLE = 'p2c_stats_reportfilter';
    
    /** The SQL description of the DB Table this class manages. */
    /*
     * filter_id [INTEGER]  Unique identifier for this particular record
     * filter_name [STRING]  The name of the filter
     * filter_desc [STRING]  The description of the filter
     */
    const DB_TABLE_DESCRIPTION = " (                           
                          `filter_id` int(20) NOT NULL auto_increment,                    
                          `filter_name` varchar(64) collate latin1_general_ci NOT NULL,   
                          `filter_desc` varchar(128) collate latin1_general_ci NOT NULL,  
                          PRIMARY KEY  (`filter_id`)                                      
                        ) ENGINE=InnoDB";
    
    /** The fields in the DB Table this class manages. */
    const FIELD_LIST = 'filter_id,filter_name,filter_desc';
    
    /** The XML node name for this entry. */
    const XML_NODE_NAME = 'p2c_stats_reportfilter';
    

	//VARIABLES:


	//CLASS CONSTRUCTOR
	//************************************************************************
	/**
	 * function __construct
	 * <pre>
	 * Initialize this object.
	 * </pre>
	 * @param $MIN_ID [INTEGER] The unique id of the ministry record we are managing.
	 * @return [void]
	 */
    function __construct( $FILTER_ID=-1 ) 
    {
    
        $dbTableName = RowManager_ReportFilterManager::DB_TABLE;
        $fieldList = RowManager_ReportFilterManager::FIELD_LIST;
        $primaryKeyField = 'filter_id';
        $primaryKeyValue = $FILTER_ID;
        
        if (( $FILTER_ID != -1 ) && ( $FILTER_ID != '' )) {
        
            $condition = $primaryKeyField . '=' . $primaryKeyValue;
            
        } else {
            $condition = '';
        }
        $xmlNodeName = RowManager_ReportFilterManager::XML_NODE_NAME;
        parent::__construct( $dbTableName, $fieldList, $primaryKeyField, $primaryKeyValue, $condition, $xmlNodeName);
        
        $this->dbDescription = RowManager_ReportFilterManager::DB_TABLE_DESCRIPTION;

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
	 * function getFilterName
	 * <pre>
	 * returns the filter's name
	 * </pre>
	 * @return [STRING]
	 */
    function getFilterName()
    {   
        return $this->getValueByFieldName('filter_name');
    }  
    
     //************************************************************************
	/**
	 * function getFilterID
	 * <pre>
	 * returns the filter ID
	 * </pre>
	 * @return [STRING]
	 */
    function getFilterID()
    {   
        return $this->getValueByFieldName('filter_id');
    }       
    
    
    //************************************************************************
	/**
	 * function getJoinOnFilterID
	 * <pre>
	 * returns the field used as a join condition for filter ID
	 * </pre>
	 * @return [STRING]
	 */
    function getJoinOnFilterID()
    {   
        return $this->getJoinOnFieldX('filter_id');
    }
    
   /**
	 * function setFilterID
	 * <pre>
	 * Set the filter ID for the filter
	 * </pre>
     *
	 * @param $filterID		the ID of the filter
	 */
    function setFilterID($filterID) 
    {
        $this->setValueByFieldName('filter_id',$filterID);
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
        return "filter_name";
    }

    
    	
}

?>