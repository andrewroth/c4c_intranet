<?php
/**
 * @package cim_hrdb
 */ 
/**
 * class RowManager_CustomFieldsManager
 * <pre> 
 * The object used to associate HRDB form fields with a custom-built report..
 * </pre>
 * @author CIM Team
 */
class  RowManager_CustomFieldsManager extends RowManager {

	//CONSTANTS:
	/** The name of the DB Table this class manages. */
    const DB_TABLE = 'cim_hrdb_customfields';
    
    /** The SQL description of the DB Table this class manages. */
    /*
     * customfields_id [INTEGER]  The unique id of this custom report to HRDB form field match-up.
     * report_id [INTEGER]  The ID of the associated custom report.
     * fields_id [INTEGER]  The HRDB form field that should be associated with a custom report.
     */
    const DB_TABLE_DESCRIPTION = " (
  customfields_id int(16) NOT NULL  auto_increment,
  report_id int(10) NOT NULL  default '0',
  fields_id int(16) NOT NULL  default '0',
  PRIMARY KEY (customfields_id)
) TYPE=MyISAM";
    
    /** The fields in the DB Table this class manages. */
    const FIELD_LIST = 'customfields_id,report_id,fields_id';
    
    /** The XML node name for this entry. */
    const XML_NODE_NAME = 'customfields';
    

	//VARIABLES:


	//CLASS CONSTRUCTOR
	//************************************************************************
	/**
	 * function __construct
	 * <pre>
	 * Initialize this object.
	 * </pre>
	 * @param $CUSTOMFIELD_ID [INTEGER] The unique id of the customfields we are managing.
	 * @return [void]
	 */
    function __construct( $CUSTOMFIELD_ID=-1 ) 
    {
    
        $dbTableName = RowManager_CustomFieldsManager::DB_TABLE;
        $fieldList = RowManager_CustomFieldsManager::FIELD_LIST;
        $primaryKeyField = 'customfields_id';
        $primaryKeyValue = $CUSTOMFIELD_ID;
        
        if (( $CUSTOMFIELD_ID != -1 ) && ( $CUSTOMFIELD_ID != '' )) {
        
            $condition = $primaryKeyField . '=' . $primaryKeyValue;
            
        } else {
            $condition = '';
        }
        $xmlNodeName = RowManager_CustomFieldsManager::XML_NODE_NAME;
        parent::__construct( $dbTableName, $fieldList, $primaryKeyField, $primaryKeyValue, $condition, $xmlNodeName);
        
        $this->dbDescription = RowManager_CustomFieldsManager::DB_TABLE_DESCRIPTION;

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
	 * function getJoinOnFieldsID
	 * <pre>
	 * returns the field used as a join condition for fields_id
	 * </pre>
	 * @return [STRING]
	 */
    function getJoinOnFieldID()
    {   
        return $this->getJoinOnFieldX('fields_id');
    }    
    
    //************************************************************************
	/**
	 * function getJoinOnReportID
	 * <pre>
	 * returns the field used as a join condition for report_id
	 * </pre>
	 * @return [STRING]
	 */
    function getJoinOnReportID()
    {   
        return $this->getJoinOnFieldX('report_id');
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
        return "No Field Label Marked";
    }

    //************************************************************************
	/**
	 * function getLabelField
	 * <pre>
	 * sets the report ID
	 * </pre>
	 * @return [void]
	 */
    function setReportID( $reportID )
    {
        $this->setValueByFieldName( 'report_id', $reportID );
        return;
    }    	
}

?>