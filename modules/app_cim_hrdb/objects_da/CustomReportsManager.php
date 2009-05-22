<?php
/**
 * @package cim_hrdb
 */ 
/**
 * class RowManager_CustomReportsManager
 * <pre> 
 * The object that allows access and editing of custom report names..
 * </pre>
 * @author CIM Team
 */
class  RowManager_CustomReportsManager extends RowManager {

	//CONSTANTS:
	/** The name of the DB Table this class manages. */
    const DB_TABLE = 'cim_hrdb_customreports';
    
    /** The SQL description of the DB Table this class manages. */
    /*
     * report_id [INTEGER]  The unique ID of the custom report.
     * report_name [STRING]  The name of the custom HRDB report.
     */
    const DB_TABLE_DESCRIPTION = " (
  report_id int(10) NOT NULL  auto_increment,
  report_name varchar(64) NOT NULL  default '',
  report_is_shown int(1) NOT NULL  default '0',
  PRIMARY KEY (report_id)
) TYPE=MyISAM";
    
    /** The fields in the DB Table this class manages. */
    const FIELD_LIST = 'report_id,report_name,report_is_shown';
    
    /** The XML node name for this entry. */
    const XML_NODE_NAME = 'customreports';
    

	//VARIABLES:


	//CLASS CONSTRUCTOR
	//************************************************************************
	/**
	 * function __construct
	 * <pre>
	 * Initialize this object.
	 * </pre>
	 * @param $REPORT_ID [INTEGER] The unique id of the customreports we are managing.
	 * @return [void]
	 */
    function __construct( $REPORT_ID=-1 ) 
    {
    
        $dbTableName = RowManager_CustomReportsManager::DB_TABLE;
        $fieldList = RowManager_CustomReportsManager::FIELD_LIST;
        $primaryKeyField = 'report_id';
        $primaryKeyValue = $REPORT_ID;
        
        if (( $REPORT_ID != -1 ) && ( $REPORT_ID != '' )) {
        
            $condition = $primaryKeyField . '=' . $primaryKeyValue;
            
        } else {
            $condition = '';
        }
        $xmlNodeName = RowManager_CustomReportsManager::XML_NODE_NAME;
        parent::__construct( $dbTableName, $fieldList, $primaryKeyField, $primaryKeyValue, $condition, $xmlNodeName);
        
        $this->dbDescription = RowManager_CustomReportsManager::DB_TABLE_DESCRIPTION;

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
	 * function getReportName
	 * <pre>
	 * Gets the name of the custom report
	 * </pre>
	 * @param $title [INT] The custom report name
	 * @return [void]
	 */
    function getReportName()
    {
        return $this->getValueByFieldName('report_name');
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
        return "report_name";
    }
	/**
	 * function setIsShown
	 * <pre>
	 * checks if the set is shown
	 * </pre>
	 * @return [STRING]
	 */
    // Whether or not report name is listed on non-superadmin report list pages
    function setIsShown( $isShown )
    {
        $this->setValueByFieldName( 'report_is_shown', $isShown );
    }    
    	
}

?>