<?php
/**
 * @package cim_reg
 */ 
/**
 * class RowManager_RegistrationManager
 * <pre> 
 * Manages basic registration data for some person-event combination..
 * </pre>
 * @author Russ Martin
 */
class  RowManager_RegistrationManager extends RowManager {

	//CONSTANTS:
	
	/** constants taken from cim_reg_status table **/
	const STATUS_REGISTERED = 1;
	const STATUS_CANCELLED = 2;
	const STATUS_INCOMPLETE = 3;
	const STATUS_UNASSIGNED = 0;
	
	/** The name of the DB Table this class manages. */
    const DB_TABLE = 'cim_reg_registration';
    
    /** The SQL description of the DB Table this class manages. */
    /*
     * registration_id [INTEGER]  Unique identifier for this particular registration record
     * event_id [INTEGER]  The event the person is registering for.
     * person_id [INTEGER]  The value identifying the person registering.
     * registration_date [DATE]  The date the registration was made.
     * registration_confirmNum [STRING]  The confirmation number for the registration.
     */
    const DB_TABLE_DESCRIPTION = " (
  registration_id int(10) NOT NULL  auto_increment,
  event_id int(10) NOT NULL  default '0',
  person_id int(10) NOT NULL  default '0',
  registration_date datetime NOT NULL  default '0000-00-00 00:00:00',
  registration_confirmNum varchar(64) NOT NULL  default '',
  registration_status int(4) NOT NULL default 0,
  registration_balance float NOT NULL default 0,
  PRIMARY KEY (registration_id)
) TYPE=MyISAM";
    
    /** The fields in the DB Table this class manages. */
    const FIELD_LIST = 'registration_id,event_id,person_id,registration_date,registration_confirmNum,registration_status,registration_balance';
    
    /** The XML node name for this entry. */
    const XML_NODE_NAME = 'registration';
    

	//VARIABLES:


	//CLASS CONSTRUCTOR
	//************************************************************************
	/**
	 * function __construct
	 * <pre>
	 * Initialize this object.
	 * </pre>
	 * @param $REG_ID [INTEGER] The unique id of the registration we are managing.
	 * @return [void]
	 */
    function __construct( $REG_ID=-1 ) 
    {
    
        $dbTableName = RowManager_RegistrationManager::DB_TABLE;
        $fieldList = RowManager_RegistrationManager::FIELD_LIST;
        $primaryKeyField = 'registration_id';
        $primaryKeyValue = $REG_ID;
        
        if (( $REG_ID != -1 ) && ( $REG_ID != '' )) {
        
            $condition = $primaryKeyField . '=' . $primaryKeyValue;
            
        } else {
            $condition = '';
        }
        $xmlNodeName = RowManager_RegistrationManager::XML_NODE_NAME;
        parent::__construct( $dbTableName, $fieldList, $primaryKeyField, $primaryKeyValue, $condition, $xmlNodeName);
        
        $this->dbDescription = RowManager_RegistrationManager::DB_TABLE_DESCRIPTION;

    }
    
    /**
     * function  getStatusDesc
     * 
     * Library function to get reg. status given the status id
     * 
     * @param  $status_id [INTEGER]
     * @return		the status description
     **/
    public static function getStatusDesc($status_id)
    {
	    switch ($status_id)
	    {
		    case RowManager_RegistrationManager::STATUS_REGISTERED:
		    	return 'Registered';
		    	break;
		    case RowManager_RegistrationManager::STATUS_CANCELLED:
		    	return 'Cancelled';
		    	break;
		    case RowManager_RegistrationManager::STATUS_INCOMPLETE:
		    	return 'Incomplete';
		    	break;
		    case RowManager_RegistrationManager::STATUS_UNASSIGNED:
		    	return 'Unassigned';
		    	break;
		    default:
		    	break;
    	}
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
	 * function getRegistrationDate
	 * <pre>
	 * returns the registration date
	 * </pre>
	 * @return [STRING]
	 */
    function getRegistrationDate()
    {   
        return $this->getValueByFieldName('registration_date');
    }  
    
     //************************************************************************
	/**
	 * function getRegistrationID
	 * <pre>
	 * returns the registration ID
	 * </pre>
	 * @return [STRING]
	 */
    function getRegistrationID()
    {   
        return $this->getValueByFieldName('registration_id');
    }       
    
    /**
	 * function getEventID
	 * <pre>
	 * Get the event ID of the registration record
	 * </pre>
	 *return [STRING]
	 * @return [INTEGER]		the ID of the associated event
	 */
    function getEventID() 
    {
        return $this->getValueByFieldName('event_id');
    }   
    
    /**
	 * function getBalanceOwing
	 * <pre>
	 * Get the balancing owing of the registration record
	 * </pre>
	 *return [INT]
	 * @return [INTEGER]		the balance owing of the associated registration record
	 */
    function getBalanceOwing() 
    {
        return $this->getBalanceOwing('balance_owing');
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
    
   /**
	 * function getJoinOnRegID
	 * <pre>
	 * returns the field used as a join condition for registration_id
	 * </pre>
	 * @return [STRING]
	 */
    function getJoinOnRegID()
    {   
        return $this->getJoinOnFieldX('registration_id');
    }
    
    /**
	 * function getJoinOnEventID
	 * <pre>
	 * returns the field used as a join condition for event ID
	 * </pre>
	 * @return [STRING]
	 */
    function getJoinOnEventID()
    {   
        return $this->getJoinOnFieldX('event_id');
    }
    
    
   /**
	 * function getJoinOnStatusID
	 * <pre>
	 * returns the field used as a join condition for status ID
	 * </pre>
	 * @return [STRING]
	 */
    function getJoinOnStatus()
    {   
        return $this->getJoinOnFieldX('registration_status');
    }    
    
    
   /**
	 * function setEventID
	 * <pre>
	 * Set the event ID for registration recording
	 * </pre>
	 *return [void]
	 * @param $eventID		the ID of the event
	 */
    function setEventID($eventID) 
    {
        $this->setValueByFieldName('event_id',$eventID);
        //return $this->getValueByFieldName( 'applicant_codename' );
    }
    

    /**
	 * function setPersonID
	 * <pre>
	 * Set the person ID for registration recording
	 * </pre>
	 *return [void]
	 * @param $personID		the ID of the person registering
	 */
    function setPersonID($personID) 
    {
        $this->setValueByFieldName('person_id',$personID);
        //return $this->getValueByFieldName( 'applicant_codename' );
    }    
    
    
   /**
	 * function setStatus
	 * <pre>
	 * Set the registration status
	 * </pre>
	 *return [void]
	 * @param $status		the status of the registration record
	 */
    function setStatus( $status )
    {
	    if (is_int($status)) {
		    
		    switch ( $status ) {
			    
			    case RowManager_RegistrationManager::STATUS_REGISTERED:
			    	$this->setValueByFieldName( 'registration_status', $status );
			    	break;			    	
			    case RowManager_RegistrationManager::STATUS_INCOMPLETE:
			    	$this->setValueByFieldName( 'registration_status', $status );
			    	break;			    	
			    case RowManager_RegistrationManager::STATUS_CANCELLED:
			    	$this->setValueByFieldName( 'registration_status', $status );
			    	break;
			    case RowManager_RegistrationManager::STATUS_UNASSIGNED:
			    	$this->setValueByFieldName( 'registration_status', $status );
			    	break;
		    }

		}
	}
	
    /**
	 * function setRegID
	 * <pre>
	 * Set the registration ID 
	 * </pre>
	 *return [void]
	 * @param $regID		the ID of the registration
	 */
    function setRegID($regID) 
    {
        $this->setValueByFieldName('registration_id',$regID);
    } 
    
     /**
	 * function setBalanceOwing
	 * <pre>
	 * Set the balance owing for this registration
	 * </pre>
	 *return [void]
	 * @param $owed		the $$$ owed for this registration
	 */
    function setBalanceOwing($owed) 
    {
        $this->setValueByFieldName('balance_owing',$owed);
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