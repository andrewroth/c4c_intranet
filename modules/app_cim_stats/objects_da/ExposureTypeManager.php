<?php
/**
 * @package cim_stats
 */ 
/**
 * class RowManager_ExposureTypeManager
 * <pre> 
 * The different types of evangelistic exposure.
 * </pre>
 * @author Russ Martin
 */
class  RowManager_ExposureTypeManager extends RowManager {

	//CONSTANTS:
	/** The name of the DB Table this class manages. */
    const DB_TABLE = 'cim_stats_exposuretype';
    
    /** The SQL description of the DB Table this class manages. */
    /*
     * exposuretype_id [INTEGER]  unique id
     * exposuretype_desc [STRING]  Text description of the exposure type.
     */
    const DB_TABLE_DESCRIPTION = " (
  exposuretype_id int(10) NOT NULL  auto_increment,
  exposuretype_desc varchar(64) NOT NULL  default '',
  PRIMARY KEY (exposuretype_id)
) TYPE=MyISAM";
    
    /** The fields in the DB Table this class manages. */
    const FIELD_LIST = 'exposuretype_id,exposuretype_desc';
    
    /** The XML node name for this entry. */
    const XML_NODE_NAME = 'exposuretype';
    

	//VARIABLES:


	//CLASS CONSTRUCTOR
	//************************************************************************
	/**
	 * function __construct
	 * <pre>
	 * Initialize this object.
	 * </pre>
	 * @param $EXPOSURE_ID [INTEGER] The unique id of the exposuretype we are managing.
	 * @return [void]
	 */
    function __construct( $EXPOSURE_ID=-1 ) 
    {
    
        $dbTableName = RowManager_ExposureTypeManager::DB_TABLE;
        $fieldList = RowManager_ExposureTypeManager::FIELD_LIST;
        $primaryKeyField = 'exposuretype_id';
        $primaryKeyValue = $EXPOSURE_ID;
        
        if (( $EXPOSURE_ID != -1 ) && ( $EXPOSURE_ID != '' )) {
        
            $condition = $primaryKeyField . '=' . $primaryKeyValue;
            
        } else {
            $condition = '';
        }
        $xmlNodeName = RowManager_ExposureTypeManager::XML_NODE_NAME;
        parent::__construct( $dbTableName, $fieldList, $primaryKeyField, $primaryKeyValue, $condition, $xmlNodeName);
        
        $this->dbDescription = RowManager_ExposureTypeManager::DB_TABLE_DESCRIPTION;

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
        return "exposuretype_desc";
    }
    
    
    //************************************************************************
	/**
	 * function getJoinOnExpTypeID
	 * <pre>
	 * returns the field used as a join condition for exposuretype_id
	 * </pre>
	 * @return [STRING]
	 */
    function getJoinOnExpTypeID()
    {   
        return $this->getJoinOnFieldX('exposuretype_id');
    }

    
    	
}

?>