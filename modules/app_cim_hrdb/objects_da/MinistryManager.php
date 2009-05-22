<?php
/**
 * @package cim_hrdb
 */ 
/**
 * class RowManager_MinistryManager
 * <pre> 
 * Contains name and abbreviation of some ministry. Other data may be added in the future, i.e. description and website..
 * </pre>
 * @author CIM Team
 */
class  RowManager_MinistryManager extends RowManager {

	//CONSTANTS:
	/** The name of the DB Table this class manages. */
    const DB_TABLE = 'cim_hrdb_ministry';
    
    /** The SQL description of the DB Table this class manages. */
    /*
     * ministry_id [INTEGER]  the unique primary id of the ministry
     * ministry_name [STRING]  The full name of the ministry.
     * ministry_abbrev [STRING]  The abbreviation of the ministry name.
     */
    const DB_TABLE_DESCRIPTION = " (
  ministry_id int(20) NOT NULL  auto_increment,
  ministry_name varchar(64) NOT NULL  default '',
  ministry_abbrev varchar(16) NOT NULL  default '',
  PRIMARY KEY (ministry_id)
) TYPE=MyISAM";
    
    /** The fields in the DB Table this class manages. */
    const FIELD_LIST = 'ministry_id,ministry_name,ministry_abbrev';
    
    /** The XML node name for this entry. */
    const XML_NODE_NAME = 'ministry';
    

	//VARIABLES:


	//CLASS CONSTRUCTOR
	//************************************************************************
	/**
	 * function __construct
	 * <pre>
	 * Initialize this object.
	 * </pre>
	 * @param $MINISTRY_ID [INTEGER] The unique id of the ministry we are managing.
	 * @return [void]
	 */
    function __construct( $MINISTRY_ID=-1 ) 
    {
    
        $dbTableName = RowManager_MinistryManager::DB_TABLE;
        $fieldList = RowManager_MinistryManager::FIELD_LIST;
        $primaryKeyField = 'ministry_id';
        $primaryKeyValue = $MINISTRY_ID;
        
        if (( $MINISTRY_ID != -1 ) && ( $MINISTRY_ID != '' )) {
        
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
	 * function getLabelField
	 * <pre>
	 * Returns the field to use in the label routines.
	 * </pre>
	 * @return [STRING]
	 */
    function getLabelField() 
    {
        return "ministry_abbrev";
    }

    
    	
}

?>