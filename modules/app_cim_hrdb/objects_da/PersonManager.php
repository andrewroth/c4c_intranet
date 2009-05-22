<?php
/**
 * @package cim_hrdb
 */ 
/**
 * class RowManager_PersonManager
 * <pre> 
 * Manages data associated with a person..
 * </pre>
 * @author CIM Team
 */
class  RowManager_PersonManager extends RowManager {

	//CONSTANTS:
	
	const GENDER_MALE = 1;
	const GENDER_FEMALE = 2;
	const GENDER_UNKNOWN = 3;
	
	/** The name of the DB Table this class manages. */
    const DB_TABLE = 'cim_hrdb_person';
    
    /** The SQL description of the DB Table this class manages. */
    /*
     * person_id [INTEGER]  a person'd unique id
     * person_fname [STRING]  A person's first name
     * person_lname [STRING]  a person's last name
     * person_phone [STRING]  A person's phone number
     * person_email [STRING]  A person's email
     * person_addr [STRING]  A person's address
     * person_city [STRING]  A person's city.
     * province_id [INTEGER]  The person's province.
     * person_pc [STRING]  Person Postal Code
     * gender_id [INTEGER]  The person's gender.
     */
    const DB_TABLE_DESCRIPTION = " (
  person_id int(50) NOT NULL  auto_increment,
  person_fname varchar(50) NOT NULL  default '',
  person_lname varchar(50) NOT NULL  default '',
  person_legal_fname varchar(50) NOT NULL  default '',
  person_legal_lname varchar(50) NOT NULL  default '',  
  person_phone varchar(50) NOT NULL  default '',
  person_email varchar(128) NOT NULL  default '',
  person_addr varchar(128) NOT NULL  default '',
  person_city varchar(50) NOT NULL  default '',
  province_id int(10) NOT NULL  default '0',
  person_pc varchar(20) NOT NULL  default '',
  gender_id int(1) NOT NULL  default '0',
  person_local_phone varchar(50) NOT NULL  default '',
  person_local_addr varchar(50) NOT NULL  default '',
  person_local_city varchar(50) NOT NULL  default '',
  person_local_pc varchar(50) NOT NULL  default '',
  person_local_province_id int(10) NOT NULL  default '0',
  PRIMARY KEY (person_id)
) TYPE=MyISAM";

// TODO - add the new fields to the above list - RM Nov 27, 2008
    
    /** The fields in the DB Table this class manages. */
    const FIELD_LIST = 'person_id,person_fname,person_lname,person_legal_fname,person_legal_lname,person_phone,person_email,person_addr,person_city,province_id,person_pc,gender_id,person_local_phone,person_local_addr,person_local_city,person_local_pc,person_local_province_id,cell_phone,local_valid_until,title_id,country_id,person_local_country_id';
    
    /** The XML node name for this entry. */
    const XML_NODE_NAME = 'person';
    

	//VARIABLES:


	//CLASS CONSTRUCTOR
	//************************************************************************
	/**
	 * function __construct
	 * <pre>
	 * Initialize this object.
	 * </pre>
	 * @param $PERSON_ID [INTEGER] The unique id of the person we are managing.
	 * @return [void]
	 */
    function __construct( $PERSON_ID=-1 ) 
    {
    
        $dbTableName = RowManager_PersonManager::DB_TABLE;
        $fieldList = RowManager_PersonManager::FIELD_LIST;
        $primaryKeyField = 'person_id';
        $primaryKeyValue = $PERSON_ID;
        
        if (( $PERSON_ID != -1 ) && ( $PERSON_ID != '' )) {
        
            $condition = $primaryKeyField . '=' . $primaryKeyValue;
            
        } else {
            $condition = '';
        }
        $xmlNodeName = RowManager_PersonManager::XML_NODE_NAME;
        parent::__construct( $dbTableName, $fieldList, $primaryKeyField, $primaryKeyValue, $condition, $xmlNodeName);
        
        $this->dbDescription = RowManager_PersonManager::DB_TABLE_DESCRIPTION;

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
	 * function getJoinOnPersonID
	 * <pre>
	 * returns the field used as a join condition for person_id
	 * </pre>
	 * @return [STRING]
	 */
    function getJoinOnPersonID()
    {   
        return $this->getJoinOnFieldX('person_id');
    }
    
    
        //************************************************************************
	/**
	 * function getJoinOnGenderID
	 * <pre>
	 * returns the field used as a join condition for gender_id
	 * </pre>
	 * @return [STRING]
	 */
    function getJoinOnGenderID()
    {   
        return $this->getJoinOnFieldX('gender_id');
    }
    
        //************************************************************************
	/**
	 * function getJoinOnProvinceID
	 * <pre>
	 * returns the field used as a join condition for province_id
	 * </pre>
	 * @return [STRING]
	 */
    function getJoinOnProvinceID()
    {   
        return $this->getJoinOnFieldX('province_id');
    }
    
    
        //************************************************************************
	/**
	 * function getJoinOnLocalProvinceID
	 * <pre>
	 * returns the field used as a join condition for person_local_province_id
	 * </pre>
	 * @return [STRING]
	 */
    function getJoinOnLocalProvinceID()
    {   
        return $this->getJoinOnFieldX('person_local_province_id');
    }
    
    /**
	 * function getJoinOnCampusID
	 * <pre>
	 * returns the field used as a join condition for campus_id
	 * </pre>
	 * @return [STRING]
	 */
/**    function getJoinOnCampusID()
    {   
        return $this->getJoinOnFieldX('campus_id');
    }
*  OBSOLETE: campus_id field removed from cim_hrdb_person table*/


   //************************************************************************
	/**
	 * function getPersonID
	 * <pre>
	 * Gets the id for the person
	 * </pre>
	 * @param $title [INT] The person id.
	 * @return [void]
	 */
    function getPersonID()
    {
        return $this->getValueByFieldName('person_id');
    }
    
   //************************************************************************
	/**
	 * function getPersonFirstName
	 * <pre>
	 * Gets the first name for the person
	 * </pre>
	 * @return [STRING]  the person's first name
	 */
    function getPersonFirstName()
    {
        return $this->getValueByFieldName('person_fname');
    }    
    
   //************************************************************************
	/**
	 * function getPersonLastName
	 * <pre>
	 * Gets the last name for the person
	 * </pre>
	 * @return [STRING]  the person's last name
	 */
    function getPersonLastName()
    {
        return $this->getValueByFieldName('person_lname');
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
        return 'person_fname';
    }
    /**
	 * function setLabelTemplateLastNameFirstName	
	 * <pre>
	 * sets the label template with first and last names
	 * </pre>
	 * <pre><code>
	 * [Put PseudoCode Here]
	 * </code></pre>
[]	 * @param none [void][void]
	 * @return [void]
	 */
    function setLabelTemplateLastNameFirstName()
    {   
        $this->setLabelTemplate( 'person_lname,person_fname','[person_lname], [person_fname]');
    }

    /**
	 * function setLabelTemplateLastNameFirstNameID
	 * <pre>
	 * sets the label template with first and last names and person id
	 * </pre>
	 * <pre><code>
	 * [Put PseudoCode Here]
	 * </code></pre>
[]	 * @param none [void][void]
	 * @return [void]
	 */
    function setLabelTemplateLastNameFirstNameID()
    {   
        $this->setLabelTemplate( 'person_lname,person_fname,person_id','[person_lname], [person_fname] - [person_id]');
    }
    
	/**
	 * function setPersonID	
	 * <pre>
	 * sets the person ID
	 * </pre>
	 * <pre><code>
	 * [Put PseudoCode Here]
	 * </code></pre>
[]	 * @param $personID [INT][the person id]
	 * @return [void]
	 */
    function setPersonID( $personID )
    {
        $this->setValueByFieldName( 'person_id', $personID );
    }
    /**
	 * function setFirstName	
	 * <pre>
	 * sets the person's first name
	 * </pre>
	 * <pre><code>
	 * [Put PseudoCode Here]
	 * </code></pre>
[]	 * @param $fname [INT][the person's first name]
	 * @return [void]
	 */
    function setFirstName( $fname )
    {
        $this->setValueByFieldName( 'person_fname', $fname );
    }
    /**
	 * function setPersonID	
	 * <pre>
	 * sets the person's last name
	 * </pre>
	 * <pre><code>
	 * [Put PseudoCode Here]
	 * </code></pre>
[]	 * @param $lname [INT][ the person's last name]
	 * @return [void]
	 */
    function setLastName( $lname )
    {
        $this->setValueByFieldName( 'person_lname', $lname );
    }
    /**
	 * function setPersonID	
	 * <pre>
	 * sets the person's email address
	 * </pre>
	 * <pre><code>
	 * [Put PseudoCode Here]
	 * </code></pre>
[]	 * @param $email [String?][the person's email]
	 * @return [void]
	 */
    function setEmail( $email )
    {
        $this->setValueByFieldName( 'person_email', $email );
        return;
    }
	/**
	 * function setPersonID	
	 * <pre>
	 * sets the gender
	 * </pre>
	 * <pre><code>
	 * [Put PseudoCode Here]
	 * </code></pre>
[]	 * @param $gender [INT or String][the person's gender]
	 * @return [void]
	 */
    // accepts: 'm', 'male', all mixed cases, and 1; similarly for female
    function setGender( $gender )
    {
	    if (is_int($gender)) {
		    
		    switch ( $gender ) {
			    
			    case RowManager_PersonManager::GENDER_MALE:
			    	$this->setValueByFieldName( 'gender_id', RowManager_PersonManager::GENDER_MALE );
			    	break;
			    	
			    case RowManager_PersonManager::GENDER_FEMALE:
			    	$this->setValueByFieldName( 'gender_id', RowManager_PersonManager::GENDER_FEMALE );
			    	break;
			    default:
			    	$this->setValueByFieldName( 'gender_id', RowManager_PersonManager::GENDER_UNKNOWN );
		    }
		}
		else 
		{
			$gender = mb_convert_case($gender, MB_CASE_UPPER);
	    	switch( $gender ) {
		    
		    	case 'M':
		    	case 'MALE':
        			$this->setValueByFieldName( 'gender_id', RowManager_PersonManager::GENDER_MALE );
        			break;
        		case 'F':
        		case 'FEMALE':
        			$this->setValueByFieldName( 'gender_id', RowManager_PersonManager::GENDER_FEMALE );
        			break;  
		    	default:
			    	$this->setValueByFieldName( 'gender_id', RowManager_PersonManager::GENDER_UNKNOWN );        			      		
     		}
  		}
  		
      return;
    }   
    
    	
}

?>
