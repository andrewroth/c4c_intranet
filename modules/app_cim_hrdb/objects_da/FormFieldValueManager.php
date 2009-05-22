<?php
/**
 * @package cim_hrdb
 */ 
/**
 * class RowManager_FormFieldValueManager
 * <pre> 
 * A record storing a field value entered via a HRDB form..
 * </pre>
 * @author CIM Team
 */
class  RowManager_FormFieldValueManager extends RowManager {

	//CONSTANTS:
	/** The name of the DB Table this class manages. */
    const DB_TABLE = 'cim_hrdb_fieldvalues';
    
    /** The SQL description of the DB Table this class manages. */
    /*
     * fieldvalues_id [INTEGER]  The unique field value id.
     * fields_id [INTEGER]  The id of the form field where this value was entered.
     * fieldvalues_value [STRING]  The value stored.
     * person_id [INTEGER]  The person who entered the value stored.
     * fieldvalues_modTime [DATE]  The time when the value record was last changed.
     */
    const DB_TABLE_DESCRIPTION = " (
  fieldvalues_id int(16) NOT NULL  auto_increment,
  fields_id int(16) NOT NULL  default '0',
  fieldvalues_value text NOT NULL  default '',
  person_id int(16) NOT NULL  default '0',
  fieldvalues_modTime timestamp(14) NOT NULL  default 'CURRENT_TIMESTAMP',
  PRIMARY KEY (fieldvalues_id)
) TYPE=MyISAM";
    
    /** The fields in the DB Table this class manages. */
    const FIELD_LIST = 'fieldvalues_id,fields_id,fieldvalues_value,person_id,fieldvalues_modTime';
    
    /** The XML node name for this entry. */
    const XML_NODE_NAME = 'formfieldvalue';
    

	//VARIABLES:


	//CLASS CONSTRUCTOR
	//************************************************************************
	/**
	 * function __construct
	 * <pre>
	 * Initialize this object.
	 * </pre>
	 * @param $FIELDVALUE_ID [INTEGER] The unique id of the formfieldvalue we are managing.
	 * @return [void]
	 */
    function __construct( $FIELDVALUE_ID=-1 ) 
    {
    
        $dbTableName = RowManager_FormFieldValueManager::DB_TABLE;
        $fieldList = RowManager_FormFieldValueManager::FIELD_LIST;
        $primaryKeyField = 'fieldvalues_id';
        $primaryKeyValue = $FIELDVALUE_ID;
        
        if (( $FIELDVALUE_ID != -1 ) && ( $FIELDVALUE_ID != '' )) {
        
            $condition = $primaryKeyField . '=' . $primaryKeyValue;
            
        } else {
            $condition = '';
        }
        $xmlNodeName = RowManager_FormFieldValueManager::XML_NODE_NAME;
        parent::__construct( $dbTableName, $fieldList, $primaryKeyField, $primaryKeyValue, $condition, $xmlNodeName);
        
        $this->dbDescription = RowManager_FormFieldValueManager::DB_TABLE_DESCRIPTION;

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
	 * function setPersonID
	 * <pre>
	 * Set the person ID associated with this form field
	 * </pre>
     *
	 * @param $personID		the person ID associated with the form
	 */
    function setPersonID($personID) 
    {
        $this->setValueByFieldName('person_id',$personID);
        //return $this->getValueByFieldName( 'applicant_codename' );
    }   
    
    
   /**
	 * function setFieldID
	 * <pre>
	 * Set the field ID associated with this form field value
	 * </pre>
     *
	 * @param $fieldID		the field ID associated with the form
	 */
    function setFieldID($fieldID) 
    {
        $this->setValueByFieldName('fields_id',$fieldID);
    }           
    
    
	 /* function getJoinOnFieldID
	 * <pre>
	 * returns the field used as a join condition (field_id)
	 * </pre>
	 * @return [STRING]
	 */
    function getJoinOnFieldID()
    {   
        return $this->getJoinOnFieldX('fields_id');
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
        return "fieldvalues_value";
    }

    
    	
}

?>