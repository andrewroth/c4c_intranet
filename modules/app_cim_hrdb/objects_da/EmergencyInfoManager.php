<?php
/**
 * @package cim_hrdb
 */ 
/**
 * class RowManager_EmergencyInfoManager
 * <pre> 
 * a record of emergency info for a person.
 * </pre>
 * @author CIM Team
 */
class  RowManager_EmergencyInfoManager extends RowManager {

	//CONSTANTS:
	/** The name of the DB Table this class manages. */
    const DB_TABLE = 'cim_hrdb_emerg';
    
    /** The SQL description of the DB Table this class manages. */
    /*
     * emerg_id [INTEGER]  unique indentifier
     * person_id [INTEGER]  Person id
     * emerg_passportNum [STRING]  Passport number
     * emerg_passportOrigin [STRING]  passport's country of origin
     * emerg_passportExpiry [DATE]  passport date of expiry
     * emerg_contactName [STRING]  emergency contact name
     * emerg_contactRship [STRING]  emergency contact's relationship to the person
     * emerg_contactHome [STRING]  emergency contact's home phone number
     * emerg_contactWork [STRING]  emergency contact's work phone number
     * emerg_contactMobile [STRING]  emergency contact's mobile phone number
     * emerg_contactEmail [STRING]  emergency contact's email address
     * emerg_birthdate [DATE]  person's birthdate
     * emerg_medicalNotes [STRING]  medical notes about this person
     */
    const DB_TABLE_DESCRIPTION = " (
  emerg_id int(16) NOT NULL  auto_increment,
  person_id int(16) NOT NULL  default '0',
  emerg_passportNum varchar(32) NOT NULL  default '',
  emerg_passportOrigin varchar(32) NOT NULL  default '',
  emerg_passportExpiry date NOT NULL  default '0000-00-00',
  emerg_contactName varchar(64) NOT NULL  default '',
  emerg_contactRship varchar(64) NOT NULL  default '',
  emerg_contactHome varchar(32) NOT NULL  default '',
  emerg_contactWork varchar(32) NOT NULL  default '',
  emerg_contactMobile varchar(32) NOT NULL  default '',
  emerg_contactEmail varchar(32) NOT NULL  default '',
  emerg_birthdate date NOT NULL  default '0000-00-00',
  emerg_medicalNotes text NOT NULL  default '',
  PRIMARY KEY (emerg_id)
) TYPE=MyISAM";
    
    /** The fields in the DB Table this class manages. */
    const FIELD_LIST = 'emerg_id,person_id,emerg_passportNum,emerg_passportOrigin,emerg_passportExpiry,emerg_contactName,emerg_contactRship,emerg_contactHome,emerg_contactWork,emerg_contactMobile,emerg_contactEmail,emerg_birthdate,emerg_medicalNotes';
    
    /** The XML node name for this entry. */
    const XML_NODE_NAME = 'emergencyinfo';
    

	//VARIABLES:


	//CLASS CONSTRUCTOR
	//************************************************************************
	/**
	 * function __construct
	 * <pre>
	 * Initialize this object.
	 * </pre>
	 * @param $EMERG_ID [INTEGER] The unique id of the emergencyinfo we are managing.
	 * @return [void]
	 */
    function __construct( $EMERG_ID=-1, $person_id=-1 ) 
    {
    
        $dbTableName = RowManager_EmergencyInfoManager::DB_TABLE;
        $fieldList = RowManager_EmergencyInfoManager::FIELD_LIST;
        $primaryKeyField = 'emerg_id';
        $primaryKeyValue = $EMERG_ID;
        
        if (( $EMERG_ID != -1 ) && ( $EMERG_ID != '' )) {
        
            $condition = $primaryKeyField . '=' . $primaryKeyValue;
            
        } else {
            $condition = '';
        }
        
        if ( ( $person_id != -1 ) && ( $person_id != '' ) )
        {
            $concat = ' AND ';
            if ( $condition == '' )
            {
                $concat = '';
            }
            $condition .= $concat.'person_id='.$person_id;
        }
        
        $xmlNodeName = RowManager_EmergencyInfoManager::XML_NODE_NAME;
        parent::__construct( $dbTableName, $fieldList, $primaryKeyField, $primaryKeyValue, $condition, $xmlNodeName);
        
        $this->dbDescription = RowManager_EmergencyInfoManager::DB_TABLE_DESCRIPTION;

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
	 * @return [ void]
	 */
	 
    function classMethod($param1, $param2) 
    {
        // CODE
        //return $this->getValueByFieldName( 'applicant_codename' );
    }
    
    
    //************************************************************************
	/**
	 * function classMethod
	 * <pre>
	 * [classFunction Description]
	 * </pre>
	 * <pre><code>
	 * [Put PseudoCode Here]
	 * </code></pre>
	 * @param $personID [ unknown][optional description of $param1]
	 * @return [void]
	 */
    function setPersonID( $personID )
    {
        $this->setValueByFieldName( 'person_id', $personID );
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

    
    	
}

?>