<?php
/**
 * @package cim_hrdb
 */ 
/**
 * class RowManager_RegionManager
 * <pre> 
 * manages regions.
 * </pre>
 * @author CIM Team
 */
class  RowManager_RegionManager extends RowManager {

	//CONSTANTS:
	/** The name of the DB Table this class manages. */
    const DB_TABLE = 'cim_hrdb_region';
    
    /** The SQL description of the DB Table this class manages. */
    /*
     * region_id [INTEGER]  id of a region
     * reg_desc [STRING]  description of a region
     */
    const DB_TABLE_DESCRIPTION = " (
  region_id int(8) NOT NULL  auto_increment,
  reg_desc varchar(64) NOT NULL  default '',
  country_id int(50) NOT NULL default '0',
  PRIMARY KEY (region_id)
) TYPE=MyISAM";
    
    /** The fields in the DB Table this class manages. */
    const FIELD_LIST = 'region_id,reg_desc,country_id';
    
    /** The XML node name for this entry. */
    const XML_NODE_NAME = 'region';
    

	//VARIABLES:


	//CLASS CONSTRUCTOR
	//************************************************************************
	/**
	 * function __construct
	 * <pre>
	 * Initialize this object.
	 * </pre>
	 * @param $REGION_ID [INTEGER] The unique id of the region we are managing.
	 * @return [void]
	 */
    function __construct( $REGION_ID=-1 ) 
    {
    
        $dbTableName = RowManager_RegionManager::DB_TABLE;
        $fieldList = RowManager_RegionManager::FIELD_LIST;
        $primaryKeyField = 'region_id';
        $primaryKeyValue = $REGION_ID;
        
        if (( $REGION_ID != -1 ) && ( $REGION_ID != '' )) {
        
            $condition = $primaryKeyField . '=' . $primaryKeyValue;
            
        } else {
            $condition = '';
        }
        $xmlNodeName = RowManager_RegionManager::XML_NODE_NAME;
        parent::__construct( $dbTableName, $fieldList, $primaryKeyField, $primaryKeyValue, $condition, $xmlNodeName);
        
        $this->dbDescription = RowManager_RegionManager::DB_TABLE_DESCRIPTION;

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
    
	/**
	 * function getJoinOnRegionID
	 * <pre>
	 * returns the field used as a join condition for region id
	 * </pre>
	 * @return [STRING]
	 */
    function getJoinOnRegionID()
    {   
        return $this->getJoinOnFieldX('region_id');
    }     
    
    
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
        return "reg_desc";
    }

    
    	
}

?>