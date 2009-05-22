<?php
/**
 * @package cim_hrdb
 */ 
/**
 * class RowManager_FormFieldManager
 * <pre> 
 * this is a HRDB form field object.
 * </pre>
 * @author CIM Team
 */
class  RowManager_FormFieldManager extends RowManager {

	//CONSTANTS:
	/** The name of the DB Table this class manages. */
    const DB_TABLE = 'cim_hrdb_fields';
    
    /** The SQL description of the DB Table this class manages. */
    /*
     * fields_id [INTEGER]  the unique id of the field
     * fieldtype_id [INTEGER]  The field type associated with the field (i.e. "checkbox")
     * fields_desc [STRING]  the description of the form field
     * staffscheduletype_id [INTEGER]  id of the form that this field belongs to
     * fields_priority [INTEGER]  the display priority of this form field
     * fields_reqd [BOOL]  whether or not this field is a required field (for the user to fill in)
     * fields_invalid [STRING]  an value that is invalid for this field
     * fields_hidden [BOOL]  whether this field is hidden to the general user
     * datatypes_id [INTEGER]  The id of the type of data this field expects, i.e. "numeric".
     */
    const DB_TABLE_DESCRIPTION = " (
  fields_id int(16) NOT NULL  auto_increment,
  fieldtype_id int(16) NOT NULL  default '0',
  fields_desc text NOT NULL  default '',
  staffscheduletype_id int(15) NOT NULL  default '0',
  fields_priority int(16) NOT NULL  default '0',
  fields_reqd int(8) NOT NULL  default '0',
  fields_invalid varchar(128) NOT NULL  default '',
  fields_hidden int(8) NOT NULL  default '0',
  datatypes_id int(4) NOT NULL  default '3',
  fieldgroup_id int(10) NOT NULL  default '0',
  fields_note varchar(75) NOT NULL default '',
  PRIMARY KEY (fields_id)
) TYPE=MyISAM";
    
    /** The fields in the DB Table this class manages. */
    const FIELD_LIST = 'fields_id,fieldtype_id,fields_desc,staffscheduletype_id,fields_priority,fields_reqd,fields_invalid,fields_hidden,datatypes_id,fieldgroup_id,fields_note';
    
    /** The XML node name for this entry. */
    const XML_NODE_NAME = 'formfield';
    

	//VARIABLES:


	//CLASS CONSTRUCTOR
	//************************************************************************
	/**
	 * function __construct
	 * <pre>
	 * Initialize this object.
	 * </pre>
	 * @param $FIELD_ID [INTEGER] The unique id of the formfield we are managing.
	 * @return [void]
	 */
    function __construct( $FIELD_ID=-1 ) 
    {
    
        $dbTableName = RowManager_FormFieldManager::DB_TABLE;
        $fieldList = RowManager_FormFieldManager::FIELD_LIST;
        $primaryKeyField = 'fields_id';
        $primaryKeyValue = $FIELD_ID;
        
        if (( $FIELD_ID != -1 ) && ( $FIELD_ID != '' )) {
        
            $condition = $primaryKeyField . '=' . $primaryKeyValue;
            
        } else {
            $condition = '';
        }
        $xmlNodeName = RowManager_FormFieldManager::XML_NODE_NAME;
        parent::__construct( $dbTableName, $fieldList, $primaryKeyField, $primaryKeyValue, $condition, $xmlNodeName);
        
        $this->dbDescription = RowManager_FormFieldManager::DB_TABLE_DESCRIPTION;

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
	 * function setFormID
	 * <pre>
	 * Set the form ID associated with this form field
	 * </pre>
     *
	 * @param $formID		the ID of the form
	 */
    function setFormID($formID) 
    {
        $this->setValueByFieldName('staffscheduletype_id',$formID);
        //return $this->getValueByFieldName( 'applicant_codename' );
    }   
    
   /**
	 * function setFieldGroupID
	 * <pre>
	 * Set the fieldgroup ID associated with this form field
	 * </pre>
     *
	 * @param $fieldgroupID		the ID of the fieldgroup
	 */
    function setFieldGroupID($fieldgroupID) 
    {
        $this->setValueByFieldName('fieldgroup_id',$fieldgroupID);
        //return $this->getValueByFieldName( 'applicant_codename' );
    }      
    
    
    /**
	 * function getJoinOnFieldTypeID
	 * <pre>
	 * returns the field used as a join condition (fieldtype_id)
	 * </pre>
	 * @return [STRING]
	 */
    function getJoinOnFieldTypeID()
    {   
        return $this->getJoinOnFieldX('fieldtype_id');
    }     
    
    /**
	 * function getJoinOnFieldID
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
        return "fields_desc";
    }

    
    	
}

?>