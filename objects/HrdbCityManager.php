<?php
/**
 * @package NSSPayRoll
 */ 
/**
 * class RowManager_HrdbCityManager 
 * <pre> 
 * Manages entries in the HRDB->Cities table.
 * </pre>
 * @author Johnny Hausman/David Cheong
 */
class  RowManager_HrdbCityManager extends RowManager {

	//CONSTANTS:
	/** The name of the DB Table this class manages. */
    const DB_TABLE = 'cities';
    
    /** The fields in the DB Table this class manages. */
    const FIELD_LIST = 'city_id,city_label,province_id';
    
    /** The XML node name for this entry. */
    const XML_NODE_NAME = 'hrdbCity';
    

	//VARIABLES:


	//CLASS CONSTRUCTOR
	//************************************************************************
	/**
	 * function __construct
	 * <pre>
	 * Initialize this object.
	 * </pre>
	 * @param $cityID [INTEGER] The unique id of the city we are managing.
	 * @return [void]
	 */
    function __construct( $cityID=-1 ) 
    {
        $dbTableName = RowManager_HrdbCityManager::DB_TABLE;
        $fieldList = RowManager_HrdbCityManager::FIELD_LIST;
        $primaryKeyField = 'city_id';
        $primaryKeyValue = $cityID;
        
        if (( $cityID != -1 ) && ( $cityID != '' )) {
        
            $condition = $primaryKeyField . '=' . $primaryKeyValue;
            
        } else {
            $condition = '';
        }
        $xmlNodeName = RowManager_HrdbCityManager::XML_NODE_NAME;
        parent::__construct( $dbTableName, $fieldList, $primaryKeyField, $primaryKeyValue, $condition, $xmlNodeName, HR_DB_NAME );
        
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
        return "city_label";
    }
    
    function getJoinOnCityID()
    {
        return $this->getJoinOnFieldX('city_id');
    }
    
    function getJoinOnProvinceID()
    {
        return $this->getJoinOnFieldX('province_id');
    }
    
    //************************************************************************
	/**
	 * function getCity
	 * <pre>
	 * Returns city label 
     * </pre>
	 * @return [STRING]
	 */
    function getCity() 
    {
        return $this->getValueByFieldName( 'city_label' );
    }
           	
}

?>