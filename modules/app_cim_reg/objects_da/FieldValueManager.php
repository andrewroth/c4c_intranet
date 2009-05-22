<?php
/**
 * @package cim_reg
 */ 
/**
 * class RowManager_FieldValueManager
 * <pre> 
 * Assigns a value to a registration form field for some registrant..
 * </pre>
 * @author Russ Martin
 */
class  RowManager_FieldValueManager extends RowManager {

	//CONSTANTS:
	/** The name of the DB Table this class manages. */
    const DB_TABLE = 'cim_reg_fieldvalues';
    
    /** The SQL description of the DB Table this class manages. */
    /*
     * fieldvalues_id [INTEGER]  Unique identifier for the field value stored for a particular field-registrant combination.
     * fields_id [INTEGER]  Value identifying the form field being assigned the value.
     * fieldvalues_value [STRING]  The value being assigned to a particular form field for some registration.
     * registration_id [INTEGER]  The value identifying the registration associated with the field value assignment.
     */
    const DB_TABLE_DESCRIPTION = " (
  fieldvalues_id int(10) NOT NULL  auto_increment,
  fields_id int(10) NOT NULL  default '0',
  fieldvalues_value text NOT NULL  default '',
  registration_id int(10) NOT NULL  default '0',
  PRIMARY KEY (fieldvalues_id)
) TYPE=MyISAM";
    
    /** The fields in the DB Table this class manages. */
    const FIELD_LIST = 'fieldvalues_id,fields_id,fieldvalues_value,registration_id';
    
    /** The XML node name for this entry. */
    const XML_NODE_NAME = 'fieldvalue';
    

	//VARIABLES:


	//CLASS CONSTRUCTOR
	//************************************************************************
	/**
	 * function __construct
	 * <pre>
	 * Initialize this object.
	 * </pre>
	 * @param $FIELDVALUE_ID [INTEGER] The unique id of the fieldvalue we are managing.
	 * @return [void]
	 */
    function __construct( $FIELDVALUE_ID=-1 ) 
    {
    
        $dbTableName = RowManager_FieldValueManager::DB_TABLE;
        $fieldList = RowManager_FieldValueManager::FIELD_LIST;
        $primaryKeyField = 'fieldvalues_id';
        $primaryKeyValue = $FIELDVALUE_ID;
        
        if (( $FIELDVALUE_ID != -1 ) && ( $FIELDVALUE_ID != '' )) {
        
            $condition = $primaryKeyField . '=' . $primaryKeyValue;
            
        } else {
            $condition = '';
        }
        $xmlNodeName = RowManager_FieldValueManager::XML_NODE_NAME;
        parent::__construct( $dbTableName, $fieldList, $primaryKeyField, $primaryKeyValue, $condition, $xmlNodeName);
        
        $this->dbDescription = RowManager_FieldValueManager::DB_TABLE_DESCRIPTION;

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
	 * function getFieldValue
	 * <pre>
	 * returns the form field value
	 * </pre>
	 * @return [STRING]
	 */
    function getFieldValue()
    {   
        return $this->getValueByFieldName('fieldvalues_value');
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
	 * function getJoinOnRegID
	 * <pre>
	 * returns the field used as a join condition (registration_id)
	 * </pre>
	 * @return [STRING]
	 */
    function getJoinOnRegID()
    {   
        return $this->getJoinOnFieldX('registration_id');
    }     
    
    
   /**
	 * function setFieldID
	 * <pre>
	 * Set the field ID for managing field values
	 * </pre>
	 *return [void]
	 * @param $fieldID		the ID of the form field
	 */
    function setFieldID($fieldID) 
    {
        $this->setValueByFieldName('fields_id',$fieldID);
    }

    /**
	 * function setRegID
	 * <pre>
	 * Set the registration ID for managing field values
	 * </pre>
	 *return [void]
	 * @param $regID		the ID of the registration having the form field
	 */
    function setRegID($regID) 
    {
        $this->setValueByFieldName('registration_id',$regID);
    }    
    
     /**
	 * function setFieldValue
	 * <pre>
	 * Set the field value as a filter
	 * </pre>
	 *return [void]
	 * @param $fieldValue		the value of the event-specific form field
	 */
    function setFieldValue($fieldValue) 
    {
        $this->setValueByFieldName('fieldvalues_value',$fieldValue);
    }    
    
     /**
	 * function setSortByField
	 * <pre>
	 * Set the sort by field ID
	 * </pre>
           *return [void]
	 * 
	 */  
    function setSortByFieldID() 
    {
        $this->setSortOrder('fields_id');
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
	 * function loadByFieldIDandRegID
	 * <pre>
	 * Attempts to load this object given a field ID and a registration ID
     * </pre>
     * @param $fieldID [INTEGER] the form field ID to look up
     * @param $regID [INTEGER] the registration ID to look up
	 * @return [BOOL]
	 */
    function loadByFieldIDandRegID( $fieldID, $regID ) 
    {
        // echo 'The loadByViewerID::viewerID is ['.$viewerID.']<br/>';
        $condition = 'fields_id='.$fieldID.' and registration_id='.$regID;
        $retVal = $this->loadByCondition( $condition );
        if (!$retVal)
        {
            // echo 'Error loading accessManager - loadByViewerID<br/>';
        }
        return $retVal;
    }   
    	
}

?>