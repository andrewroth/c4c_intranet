<?php
/**
 * @package p2c_stats
 */ 
/**
 * class RowManager_DivisionManager
 * <pre> 
 * Manages records storing Power to Change division names and descriptions
 * </pre>
 * @author Hobbe Smit (Oct 24, 2007)
 */
class  RowManager_DivisionManager extends RowManager {

	//CONSTANTS:
	
	/** The name of the DB Table this class manages. */
    const DB_TABLE = 'p2c_stats_division';
    
    /** The SQL description of the DB Table this class manages. */
    /*
     * division_id [INTEGER]  Unique identifier for this particular record
     * division_name [STRING]  The name of the division
     * division_desc [STRING]  The description of the division
     * ministry_id [INTEGER]  The ministry that the division is associated with
     */
    const DB_TABLE_DESCRIPTION = " (                                                                                      
                      `division_id` int(50) NOT NULL auto_increment,                                                                         
                      `division_name` varchar(64) collate latin1_general_ci NOT NULL,                                                        
                      `division_desc` varchar(128) collate latin1_general_ci NOT NULL,                                                       
                      `ministry_id` int(20) NOT NULL default '0',                                                                            
                      PRIMARY KEY  (`division_id`),                                                                                          
                      KEY `FK_div_min` (`ministry_id`),                                                                                      
                      CONSTRAINT `FK_div_min` FOREIGN KEY (`ministry_id`) REFERENCES `p2c_stats_ministry` (`ministry_id`) ON UPDATE CASCADE  
                    ) ENGINE=InnoDB";
    
    /** The fields in the DB Table this class manages. */
    const FIELD_LIST = 'division_id,division_name,division_desc,ministry_id';
    
    /** The XML node name for this entry. */
    const XML_NODE_NAME = 'p2c_stats_division';
    

	//VARIABLES:


	//CLASS CONSTRUCTOR
	//************************************************************************
	/**
	 * function __construct
	 * <pre>
	 * Initialize this object.
	 * </pre>
	 * @param $DIV_ID [INTEGER] The unique id of the division record we are managing.
	 * @return [void]
	 */
    function __construct( $DIV_ID=-1 ) 
    {
    
        $dbTableName = RowManager_DivisionManager::DB_TABLE;
        $fieldList = RowManager_DivisionManager::FIELD_LIST;
        $primaryKeyField = 'division_id';
        $primaryKeyValue = $DIV_ID;
        
        if (( $DIV_ID != -1 ) && ( $DIV_ID != '' )) {
        
            $condition = $primaryKeyField . '=' . $primaryKeyValue;
            
        } else {
            $condition = '';
        }
        $xmlNodeName = RowManager_DivisionManager::XML_NODE_NAME;
        parent::__construct( $dbTableName, $fieldList, $primaryKeyField, $primaryKeyValue, $condition, $xmlNodeName);
        
        $this->dbDescription = RowManager_DivisionManager::DB_TABLE_DESCRIPTION;

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
	 * function getDivisionName
	 * <pre>
	 * returns the divisions's name
	 * </pre>
	 * @return [STRING]
	 */
    function getDivisionName()
    {   
        return $this->getValueByFieldName('division_name');
    }  
    
     //************************************************************************
	/**
	 * function getDivisionID
	 * <pre>
	 * returns the division_id
	 * </pre>
	 * @return [STRING]
	 */
    function getDivisionID()
    {   
        return $this->getValueByFieldName('division_id');
    }       
    
    
    //************************************************************************
	/**
	 * function getJoinOnDivisionID
	 * <pre>
	 * returns the field used as a join condition for division ID
	 * </pre>
	 * @return [STRING]
	 */
    function getJoinOnDivisionID()
    {   
        return $this->getJoinOnFieldX('division_id');
    }
    
    //************************************************************************
	/**
	 * function getJoinOnMinistryID
	 * <pre>
	 * returns the field used as a join condition for ministry ID
	 * </pre>
	 * @return [STRING]
	 */
    function getJoinOnMinistryID()
    {   
        return $this->getJoinOnFieldX('ministry_id');
    }
       
    
   /**
	 * function setDivisionID
	 * <pre>
	 * Set the division ID for the division
	 * </pre>
     *
	 * @param $divisionID		the ID of the division
	 */
    function setDivisionID($divisionID) 
    {
        $this->setValueByFieldName('division_id',$divisionID);
    }
    
     
   /**
	 * function setMinistryID
	 * <pre>
	 * Set the ministry ID associated with the division
	 * </pre>
     *
	 * @param $ministryID		the ID of the ministry
	 */
    function setMinistryID($ministryID) 
    {
        $this->setValueByFieldName('ministry_id',$ministryID);
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
        return "division_name";
    }

    
    	
}

?>