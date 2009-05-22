<?php
/**
 * @package cim_reg
 */ 
/**
 * class RowManager_FieldManager
 * <pre> 
 * A form field for a given event..
 * </pre>
 * @author Russ Martin
 */
class  RowManager_FieldManager extends RowManager {

	//CONSTANTS:
	/** The name of the DB Table this class manages. */
    const DB_TABLE = 'cim_reg_fields';
    
    /** The SQL description of the DB Table this class manages. */
    /*
     * fields_id [INTEGER]  A form field's identifier
     * fieldtype_id [INTEGER]  Identifier for a particular field type
     * fields_desc [STRING]  Description/label associated with a particular field
     * event_id [INTEGER]  The event identifier associated with the form field
     * fields_priority [INTEGER]  The priority of the form field.
     * fields_datacheck [STRING]  The type of data expected to be associated with this form field.
     * fields_reqd [INTEGER]  Whether or not this field is required.
     * fields_invalid [STRING]  Specifies invalid data not allowed in the form field.
     * fields_hidden [INTEGER]  Whether or not the form field is hidden to registrants (but not to admins).
     */
    const DB_TABLE_DESCRIPTION = " (
  fields_id int(10) NOT NULL  auto_increment,
  fieldtype_id int(10) NOT NULL  default '0',
  fields_desc text NOT NULL  default '',
  event_id int(10) NOT NULL  default '0',
  fields_priority int(10) NOT NULL  default '0',
  fields_reqd int(1) NOT NULL  default '0',
  fields_invalid varchar(128) NOT NULL  default '',
  fields_hidden int(1) NOT NULL  default '0',
  datatypes_id int(4) NOT NULL default '0',
  PRIMARY KEY (fields_id)
) TYPE=MyISAM";
//   fields_datacheck varchar(8) NOT NULL  default '',
    
    /** The fields in the DB Table this class manages. */	//fields_datacheck,
    const FIELD_LIST = 'fields_id,fieldtype_id,fields_desc,event_id,fields_priority,fields_reqd,fields_invalid,fields_hidden,datatypes_id';
    
    /** The XML node name for this entry. */
    const XML_NODE_NAME = 'field';
    

	//VARIABLES:


	//CLASS CONSTRUCTOR
	//************************************************************************
	/**
	 * function __construct
	 * <pre>
	 * Initialize this object.
	 * </pre>
	 * @param $FIELD_ID [INTEGER] The unique id of the field we are managing.
	 * @return [void]
	 */
    function __construct( $FIELD_ID=-1 ) 
    {
    
        $dbTableName = RowManager_FieldManager::DB_TABLE;
        $fieldList = RowManager_FieldManager::FIELD_LIST;
        $primaryKeyField = 'fields_id';
        $primaryKeyValue = $FIELD_ID;
        
        if (( $FIELD_ID != -1 ) && ( $FIELD_ID != '' )) {
        
            $condition = $primaryKeyField . '=' . $primaryKeyValue;
            
        } else {
            $condition = '';
        }
        $xmlNodeName = RowManager_FieldManager::XML_NODE_NAME;
        parent::__construct( $dbTableName, $fieldList, $primaryKeyField, $primaryKeyValue, $condition, $xmlNodeName);
        
        $this->dbDescription = RowManager_FieldManager::DB_TABLE_DESCRIPTION;

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
	 * function setEventID
	 * <pre>
	 * Set the event ID for form field creation/modification
	 * </pre>
	 *return [void]
	 * @param $eventID		the ID of the event
	 */
    function setEventID($eventID) 
    {
        $this->setValueByFieldName('event_id',$eventID);
    }
  
     /**
	 * function setIsHidden
	 * <pre>
	 * Set whether or not to show hidden fields
	 * </pre>
	 *return [void]
	 * @param $isHidden [BOOLEAN]  	whether or not to show hidden fields
	 */
    function setIsHidden($isHidden) 
    {
        $this->setValueByFieldName('fields_hidden',$isHidden);
    }   
      
     /**
	 * function setIsRequired
	 * <pre>
	 * Set whether the fields retrieved should be required fields or non-required fields
	 * </pre>
	 *return [void]
	 * @param $isRequired [BOOLEAN]  	'required?' flag to filter by 
	 */
    function setIsRequired($isRequired) 
    {
        $this->setValueByFieldName('fields_reqd',$isRequired);
    }      
    
    /**
	 * function setSortByFielsID
	 * <pre>
	 * sets the sort order
	 * </pre>
	 * @return [STRING]
	 */
    function setSortByFieldID() 
    {
        $this->setSortOrder('fields_id');
    }    
            
    
    /**
	 * function getJoinOnFieldID
	 * <pre>
	 * returns the field used as a join condition (fields_id)
	 * </pre>
	 * @return [STRING]
	 */
    function getJoinOnFieldID()
    {   
        return $this->getJoinOnFieldX('fields_id');
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