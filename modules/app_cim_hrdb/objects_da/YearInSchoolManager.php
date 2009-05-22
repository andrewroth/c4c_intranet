<?php
/**
 * @package cim_hrdb
 */ 
/**
 * class RowManager_YearInSchoolManager
 * <pre> 
 * Manages the cim_hrdb_year_in_school table.
 * </pre>
 * @author CIM Team
 */
class  RowManager_YearInSchoolManager extends RowManager {

	//CONSTANTS:
	/** The name of the DB Table this class manages. */
    const DB_TABLE = 'cim_hrdb_year_in_school';
    
    /** The SQL description of the DB Table this class manages. */
    /*
     * year_id [INTEGER]  unique id
     * year_desc [STRING]  text description of the year in school
     */
    const DB_TABLE_DESCRIPTION = " (
  year_id int(10) NOT NULL  auto_increment,
  year_desc varchar(64) NOT NULL  default '',
  PRIMARY KEY (year_id)
) TYPE=MyISAM";
    
    /** The fields in the DB Table this class manages. */
    const FIELD_LIST = 'year_id,year_desc';
    
    /** The XML node name for this entry. */
    const XML_NODE_NAME = 'yearinschool';
    

	//VARIABLES:


	//CLASS CONSTRUCTOR
	//************************************************************************
	/**
	 * function __construct
	 * <pre>
	 * Initialize this object.
	 * </pre>
	 * @param $YEAR_ID [INTEGER] The unique id of the yearinschool we are managing.
	 * @return [void]
	 */
    function __construct( $YEAR_ID=-1 ) 
    {
    
        $dbTableName = RowManager_YearInSchoolManager::DB_TABLE;
        $fieldList = RowManager_YearInSchoolManager::FIELD_LIST;
        $primaryKeyField = 'year_id';
        $primaryKeyValue = $YEAR_ID;
        
        if (( $YEAR_ID != -1 ) && ( $YEAR_ID != '' )) {
        
            $condition = $primaryKeyField . '=' . $primaryKeyValue;
            
        } else {
            $condition = '';
        }
        $xmlNodeName = RowManager_YearInSchoolManager::XML_NODE_NAME;
        parent::__construct( $dbTableName, $fieldList, $primaryKeyField, $primaryKeyValue, $condition, $xmlNodeName);
        
        $this->dbDescription = RowManager_YearInSchoolManager::DB_TABLE_DESCRIPTION;

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
	 * function getJoinOnYearID
	 * <pre>
	 * returns the field used as a join condition for year_id
	 * </pre>
	 * @return [STRING]
	 */
    function getJoinOnYearID()
    {   
        return $this->getJoinOnFieldX('year_id');
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
        return "year_desc";
    }

    
    	
}

?>