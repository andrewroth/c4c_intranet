<?php
/**
 * @package cim_hrdb
 */ 
/**
 * class RowManager_CountryManager
 * <pre> 
 * Manages countries.
 * </pre>
 * @author CIM Team
 */
class  RowManager_CountryManager extends RowManager {

	//CONSTANTS:
	/** The name of the DB Table this class manages. */
    const DB_TABLE = 'cim_hrdb_country';
    
    /** The SQL description of the DB Table this class manages. */
    /*
     * country_id [INTEGER]  id of a country
     * country_desc [STRING]  Textual name of a country
     * country_shortDesc [STRING]  Short form of a country's name
     */
    const DB_TABLE_DESCRIPTION = " (
  country_id int(50) NOT NULL  auto_increment,
  country_desc varchar(50) NOT NULL  default '',
  country_shortDesc varchar(50) NOT NULL  default '',
  PRIMARY KEY (country_id)
) TYPE=MyISAM";
    
    /** The fields in the DB Table this class manages. */
    const FIELD_LIST = 'country_id,country_desc,country_shortDesc';
    
    /** The XML node name for this entry. */
    const XML_NODE_NAME = 'country';
    

	//VARIABLES:


	//CLASS CONSTRUCTOR
	//************************************************************************
	/**
	 * function __construct
	 * <pre>
	 * Initialize this object.
	 * </pre>
	 * @param $COUNTRY_ID [INTEGER] The unique id of the province we are managing.
	 * @return [void]
	 */
    function __construct( $COUNTRY_ID=-1) 
    {
    
        $dbTableName = RowManager_CountryManager::DB_TABLE;
        $fieldList = RowManager_CountryManager::FIELD_LIST;
        $primaryKeyField = 'country_id';
        $primaryKeyValue = $COUNTRY_ID;
        
        if (( $COUNTRY_ID != -1 ) && ( $COUNTRY_ID != '' )) {
        
            $condition = $primaryKeyField . '=' . $primaryKeyValue;
            
        } else {
            $condition = '';
        }
        $xmlNodeName = RowManager_CountryManager::XML_NODE_NAME;
        parent::__construct( $dbTableName, $fieldList, $primaryKeyField, $primaryKeyValue, $condition, $xmlNodeName);
        
        $this->dbDescription = RowManager_CountryManager::DB_TABLE_DESCRIPTION;

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
	 * function getJoinOnCountryID
	 * <pre>
	 * returns the field used as a join condition for country_id
	 * </pre>
	 * @return [STRING]
	 */
    function getJoinOnCountryID()
    {   
        return $this->getJoinOnFieldX('country_id');
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
        return 'country_shortDesc';
    }

    
    	
}

?>