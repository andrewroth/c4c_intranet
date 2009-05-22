<?php
/**
 * @package cim_hrdb
 */ 
/**
 * class TempTableManager
 * <pre> 
 * The object that allows access and editing of custom report names..
 * </pre>
 * @author CIM Team
 */
class  TempTableManager extends RowManager {

	//CONSTANTS:
	/** The name of the DB Table this class manages. */
//     const DB_TABLE = 'cim_hrdb_customreports';
//     
//     /** The SQL description of the DB Table this class manages. */
//     /*
//      * report_id [INTEGER]  The unique ID of the custom report.
//      * report_name [STRING]  The name of the custom HRDB report.
//      */
//     const DB_TABLE_DESCRIPTION = " (
//   report_id int(10) NOT NULL  auto_increment,
//   report_name varchar(64) NOT NULL  default '',
//   PRIMARY KEY (report_id)
// ) TYPE=MyISAM";
//     
//     /** The fields in the DB Table this class manages. */
//     const FIELD_LIST = 'report_id,report_name';
//     
//     /** The XML node name for this entry. */
//     const XML_NODE_NAME = 'customreports';
    

	//VARIABLES:
	protected $DB_TABLE;
// 	protected $DB_TABLE_CREATESQL;
	protected $FIELD_LIST;
// 	protected $XML_NODE_NAME;


	//CLASS CONSTRUCTOR
	//************************************************************************
	/**
	 * function __construct
	 * <pre>
	 * Initialize this object.
	 * </pre>
	 * @param $PRIMARY_ID [INTEGER] The unique id of the customreports we are managing.
	 * @return [void]
	 */
    function __construct($DB_TABLE, $DB_TABLE_CREATESQL, $FIELD_LIST, $XML_NODE_NAME,  $PRIMARY_ID=-1) 
    {
    
        $dbTableName = $this->DB_TABLE = $DB_TABLE;
        $fieldList = $this->FIELD_LIST = $FIELD_LIST;
        $fieldArray = explode(',',$FIELD_LIST);
        $primaryKeyField = $fieldArray[0];		// NOTE: assumes that field_list starts with primary ID
        $primaryKeyValue = $PRIMARY_ID;
        
        if (( $PRIMARY_ID != -1 ) && ( $PRIMARY_ID != '' )) {
        
            $condition = $primaryKeyField . '=' . $primaryKeyValue;
            
        } else {
            $condition = '';
        }
        $xmlNodeName = $XML_NODE_NAME;
        parent::__construct( $dbTableName, $fieldList, $primaryKeyField, $primaryKeyValue, $condition, $xmlNodeName);
        
        $this->dbDescription = ' '.$DB_TABLE_CREATESQL;

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
    
    
//    //************************************************************************
// 	/**
// 	 * function getReportName
// 	 * <pre>
// 	 * Gets the name of the custom report
// 	 * </pre>
// 	 * @param $title [INT] The custom report name
// 	 * @return [void]
// 	 */
//     function getReportName()
//     {
//         return $this->getValueByFieldName('report_name');
//     }    
//     
    
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
        return "NONE SELECTED";
    }

    
    	
}

?>