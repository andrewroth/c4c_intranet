<?php
/**
 * @package NSSPayRoll
 */ 
/**
 * class RowManager_ProvinceManager
 * <pre> 
 * manages the hrdb province table.
 * </pre>
 * @author Johnny Hausman/Russ Martin
 */
class  RowManager_ProvinceManager extends RowManager {

	//CONSTANTS:
	/** The name of the DB Table this class manages. */
    const DB_TABLE = 'province';
    
    /** The SQL description of the DB Table this class manages. */
    /*
     * province_id [INTEGER]  unique id
     * region_id [INTEGER]  Region id.
     * province_label [STRING]  Textual description of this province
     */
    const DB_TABLE_DESCRIPTION = " (
  province_id int(8) NOT NULL  auto_increment,
  region_id int(8) NOT NULL  default '0',
  province_label varchar(64) NOT NULL  default '',
  PRIMARY KEY (province_id)
) TYPE=MyISAM";
    
    /** The fields in the DB Table this class manages. */
    const FIELD_LIST = 'province_id,region_id,province_label';
    
    /** The XML node name for this entry. */
    const XML_NODE_NAME = 'province';
    

	//VARIABLES:


	//CLASS CONSTRUCTOR
	//************************************************************************
	/**
	 * function __construct
	 * <pre>
	 * Initialize this object.
	 * </pre>
	 * @param $initValue [INTEGER] The unique id of the province we are managing.
	 * @return [void]
	 */
    function __construct( $initValue=-1 ) 
    {
    
        $dbTableName = RowManager_ProvinceManager::DB_TABLE;
        $fieldList = RowManager_ProvinceManager::FIELD_LIST;
        $primaryKeyField = 'province_id';
        $primaryKeyValue = $initValue;
        
        if (( $initValue != -1 ) && ( $initValue != '' )) {
        
            $condition = $primaryKeyField . '=' . $primaryKeyValue;
            
        } else {
            $condition = '';
        }
        $xmlNodeName = RowManager_ProvinceManager::XML_NODE_NAME;
        parent::__construct( $dbTableName, $fieldList, $primaryKeyField, $primaryKeyValue, $condition, $xmlNodeName, HR_DB_NAME);
        
        $this->dbDescription = RowManager_ProvinceManager::DB_TABLE_DESCRIPTION;
        
        if ($this->isLoaded() == false) {
        
            // uncomment this line if you want the Manager to automatically 
            // create a new entry if the given info doesn't exist.
            // $this->createNewEntry();
        }
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
    
    function getJoinOnProvinceID()
    {
        return $this->getJoinOnFieldX('province_id');
    }
    
    function getJoinOnRegionID()
    {
        return $this->getJoinOnFieldX('region_id');
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
        return "///////";
    }

    
    	
}

?>