<?php
/**
 * @package NSSPayRoll
 */ 
/**
 * class RowManager_HrdbRegionManager 
 * <pre> 
 * Manages entries in the HRDB->Regions table.
 * </pre>
 * @author Johnny Hausman/David Cheong
 */
class  RowManager_HrdbRegionManager extends RowManager {

	//CONSTANTS:
	/** The name of the DB Table this class manages. */
    const DB_TABLE = 'regions';
    
    /** The fields in the DB Table this class manages. */
    const FIELD_LIST = 'region_id,region_label';
    
    /** The XML node name for this entry. */
    const XML_NODE_NAME = 'hrdbRegion';
    

	//VARIABLES:


	//CLASS CONSTRUCTOR
	//************************************************************************
	/**
	 * function __construct
	 * <pre>
	 * Initialize this object.
	 * </pre>
	 * @param $regionID [INTEGER] The unique id of the region we are managing.
	 * @return [void]
	 */
    function __construct( $regionID=-1 ) 
    {
        $dbTableName = RowManager_HrdbRegionManager::DB_TABLE;
        $fieldList = RowManager_HrdbRegionManager::FIELD_LIST;
        $primaryKeyField = 'region_id';
        $primaryKeyValue = $regionID;
        
        if (( $regionID != -1 ) && ( $regionID != '' )) {
        
            $condition = $primaryKeyField . '=' . $primaryKeyValue;
            
        } else {
            $condition = '';
        }
        $xmlNodeName = RowManager_HrdbRegionManager ::XML_NODE_NAME;
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
        return "region_label";
    }
    
    
    
    //************************************************************************
	/**
	 * function getRegion
	 * <pre>
	 * Returns region of ren
     * </pre>
	 * @return [STRING]
	 */
    function getRegion() 
    {
        return $this->getValueByFieldName( 'region_label' );
    }
    
    
    
    //************************************************************************
	/**
	 * function getID
	 * <pre>
	 * Returns ID of region
     * </pre>
	 * @return [STRING]
	 */
    function getID() 
    {
        return $this->getValueByFieldName( 'region_id' );
    }
    
    
       	
}

?>