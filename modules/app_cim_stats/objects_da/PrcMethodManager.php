<?php
/**
 * @package cim_stats
 */ 
/**
 * class RowManager_PrcMethodManager
 * <pre> 
 * Manages methods by which people PRC.
 * </pre>
 * @author Russ Martin
 */
class  RowManager_PrcMethodManager extends RowManager {

	//CONSTANTS:
	/** The name of the DB Table this class manages. */
    const DB_TABLE = 'cim_stats_prcmethod';
    
    /** The SQL description of the DB Table this class manages. */
    /*
     * prcMethod_id [INTEGER]  unique id
     * prcMethod_desc [STRING]  Textual description of the prc method
     */
    const DB_TABLE_DESCRIPTION = " (
  prcMethod_id int(10) NOT NULL  auto_increment,
  prcMethod_desc varchar(64) NOT NULL  default '',
  PRIMARY KEY (prcMethod_id)
) TYPE=MyISAM";
    
    /** The fields in the DB Table this class manages. */
    const FIELD_LIST = 'prcMethod_id,prcMethod_desc';
    
    /** The XML node name for this entry. */
    const XML_NODE_NAME = 'prcmethod';
    

	//VARIABLES:


	//CLASS CONSTRUCTOR
	//************************************************************************
	/**
	 * function __construct
	 * <pre>
	 * Initialize this object.
	 * </pre>
	 * @param $METHOD_ID [INTEGER] The unique id of the prcmethod we are managing.
	 * @return [void]
	 */
    function __construct( $METHOD_ID=-1 ) 
    {
    
        $dbTableName = RowManager_PrcMethodManager::DB_TABLE;
        $fieldList = RowManager_PrcMethodManager::FIELD_LIST;
        $primaryKeyField = 'prcMethod_id';
        $primaryKeyValue = $METHOD_ID;
        
        if (( $METHOD_ID != -1 ) && ( $METHOD_ID != '' )) {
        
            $condition = $primaryKeyField . '=' . $primaryKeyValue;
            
        } else {
            $condition = '';
        }
        $xmlNodeName = RowManager_PrcMethodManager::XML_NODE_NAME;
        parent::__construct( $dbTableName, $fieldList, $primaryKeyField, $primaryKeyValue, $condition, $xmlNodeName);
        
        $this->dbDescription = RowManager_PrcMethodManager::DB_TABLE_DESCRIPTION;

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
        return "prcMethod_desc";
    }
    
    //************************************************************************
	/**
	 * function getJoinOnPrcMethodID
	 * <pre>
	 * returns the field used as a join condition for semester_id
	 * </pre>
	 * @return [STRING]
	 */
    function getJoinOnPrcMethodID()
    {   
        return $this->getJoinOnFieldX('prcMethod_id');
    }

    
    	
}

?>