<?php
/**
 * @package p2c_stats
 */ 
/**
 * class RowManager_ScopeManager
 * <pre> 
 * Manages records storing scope names and tables (i.e. Ministry, p2c_stats_ministry) 
 * </pre>
 * @author Hobbe Smit (Nov 7, 2007)
 */
class  RowManager_ScopeManager extends RowManager {

	//CONSTANTS:
	
	/** The name of the DB Table this class manages. */
    const DB_TABLE = 'p2c_stats_scope';
    
    /**** NOTE: ensure these constants stay updated ***/
    const SCOPE_MINISTRY = '1';
    const SCOPE_DIVISION = '2';
    const SCOPE_REGION = '3';
    const SCOPE_LOCATION = '4';
    
    const SCOPE_LIST = '1,2,3,4';
    
    /** The SQL description of the DB Table this class manages. */
    /*
     * scope_id [INTEGER]  Unique identifier for this particular record
     * scope_name [STRING]  The name of the scope
     * scope_reftable [STRING]  The name of the table specific to this scope
     */
    const DB_TABLE_DESCRIPTION = " (                                    
                   `scope_id` int(10) NOT NULL auto_increment,                       
                   `scope_name` varchar(64) collate latin1_general_ci NOT NULL,      
                   `scope_reftable` varchar(32) collate latin1_general_ci NOT NULL,  
                   PRIMARY KEY  (`scope_id`)                                         
                 ) ENGINE=InnoDB";
    
    /** The fields in the DB Table this class manages. */
    const FIELD_LIST = 'scope_id,scope_name,scope_reftable';
    
    /** The XML node name for this entry. */
    const XML_NODE_NAME = 'p2c_stats_scope';
    

	//VARIABLES:


	//CLASS CONSTRUCTOR
	//************************************************************************
	/**
	 * function __construct
	 * <pre>
	 * Initialize this object.
	 * </pre>
	 * @param $SCOPE_ID [INTEGER] The unique id of the scope record we are managing.
	 * @return [void]
	 */
    function __construct( $SCOPE_ID=-1 ) 
    {
    
        $dbTableName = RowManager_ScopeManager::DB_TABLE;
        $fieldList = RowManager_ScopeManager::FIELD_LIST;
        $primaryKeyField = 'scope_id';
        $primaryKeyValue = $SCOPE_ID;
        
        if (( $SCOPE_ID != -1 ) && ( $SCOPE_ID != '' )) {
        
            $condition = $primaryKeyField . '=' . $primaryKeyValue;
            
        } else {
            $condition = '';
        }
        $xmlNodeName = RowManager_ScopeManager::XML_NODE_NAME;
        parent::__construct( $dbTableName, $fieldList, $primaryKeyField, $primaryKeyValue, $condition, $xmlNodeName);
        
        $this->dbDescription = RowManager_ScopeManager::DB_TABLE_DESCRIPTION;

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
	 * function getScopeName
	 * <pre>
	 * returns the scope's name
	 * </pre>
	 * @return [STRING]
	 */
    function getScopeName()
    {   
        return $this->getValueByFieldName('scope_name');
    }  
    
     //************************************************************************
	/**
	 * function getScopeID
	 * <pre>
	 * returns the scope ID
	 * </pre>
	 * @return [INTEGER]
	 */
    function getScopeID()
    {   
        return $this->getValueByFieldName('scope_id');
    }       
    
    
    //************************************************************************
	/**
	 * function getJoinOnScopeID
	 * <pre>
	 * returns the field used as a join condition for scope ID
	 * </pre>
	 * @return [STRING]
	 */
    function getJoinOnScopeID()
    {   
        return $this->getJoinOnFieldX('scope_id');
    }
    
   /**
	 * function setScopeID
	 * <pre>
	 * Set the scope ID for the scope
	 * </pre>
     *
	 * @param $scopeID		the ID of the scope
	 */
    function setScopeID($scopeID) 
    {
        $this->setValueByFieldName('scope_id',$scopeID);
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
        return "scope_name";
    }

    
    	
}

?>