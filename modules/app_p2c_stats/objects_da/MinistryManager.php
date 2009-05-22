<?php
/**
 * @package p2c_stats
 */ 
/**
 * class RowManager_MinistryManager
 * <pre> 
 * Manages records storing Power to Change ministry names and descriptions
 * </pre>
 * @author Hobbe Smit (Oct 24, 2007)
 */
class  RowManager_MinistryManager extends RowManager {

	//CONSTANTS:
	
	/** The name of the DB Table this class manages. */
    const DB_TABLE = 'p2c_stats_ministry';
    
    /** The SQL description of the DB Table this class manages. */
    /*
     * ministry_id [INTEGER]  Unique identifier for this particular record
     * ministry_name [STRING]  The name of the ministry
     * ministry_desc [STRING]  The description of the ministry
     * ministry_website [STRING]  The website associate with the ministry
     */
    const DB_TABLE_DESCRIPTION = " (                                   
                      `ministry_id` int(20) NOT NULL auto_increment,                      
                      `ministry_name` varchar(64) collate latin1_general_ci NOT NULL,     
                      `ministry_desc` varchar(128) collate latin1_general_ci NOT NULL,    
                      `ministry_website` varchar(48) collate latin1_general_ci NOT NULL,  
                      PRIMARY KEY  (`ministry_id`)                                        
                    ) ENGINE=InnoDB";
    
    /** The fields in the DB Table this class manages. */
    const FIELD_LIST = 'ministry_id,ministry_name,ministry_desc,ministry_website';
    
    /** The XML node name for this entry. */
    const XML_NODE_NAME = 'p2c_stats_ministry';
    

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
    function __construct( $MIN_ID=-1 ) 
    {
    
        $dbTableName = RowManager_MinistryManager::DB_TABLE;
        $fieldList = RowManager_MinistryManager::FIELD_LIST;
        $primaryKeyField = 'ministry_id';
        $primaryKeyValue = $MIN_ID;
        
        if (( $MIN_ID != -1 ) && ( $MIN_ID != '' )) {
        
            $condition = $primaryKeyField . '=' . $primaryKeyValue;
            
        } else {
            $condition = '';
        }
        $xmlNodeName = RowManager_MinistryManager::XML_NODE_NAME;
        parent::__construct( $dbTableName, $fieldList, $primaryKeyField, $primaryKeyValue, $condition, $xmlNodeName);
        
        $this->dbDescription = RowManager_MinistryManager::DB_TABLE_DESCRIPTION;

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
	 * function getMinistryName
	 * <pre>
	 * returns the ministry's name
	 * </pre>
	 * @return [STRING]
	 */
    function getMinistryName()
    {   
        return $this->getValueByFieldName('ministry_name');
    }  
    
     //************************************************************************
	/**
	 * function getMinistryID
	 * <pre>
	 * returns the ministry ID
	 * </pre>
	 * @return [STRING]
	 */
    function getMinistryID()
    {   
        return $this->getValueByFieldName('ministry_id');
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
	 * function setMinistryID
	 * <pre>
	 * Set the ministry ID for the ministry
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
        return "ministry_name";
    }

    
    	
}

?>