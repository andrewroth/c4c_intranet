<?php
/**
 * @package aia_reg
 */ 
/**
 * class RowManager_TicketsManager
 * <pre> 
 * Used to handle AIA Grey Cup Breakfast tickets; associated # of tickets with registration record in cim_reg_registration table
 * </pre>
 * @author Hobbe Smit
 */
class  RowManager_TicketsManager extends RowManager {

	//CONSTANTS:
	/** The name of the DB Table this class manages. */
    const DB_TABLE = 'aia_greycup';
    
    /** The SQL description of the DB Table this class manages. */
    /*
     * pricerules_id [INTEGER]  Unique identifier of the associated price rule.
     * is_active [INTEGER]  Indicates whether the (volume) price rule has already been made active or not.
     * is_recalculated [INTEGER]  This is a flag indicating whether a balance-owing recalculation has been run yet with the 'is_active' flag being in its current state.
     */
    const DB_TABLE_DESCRIPTION = " (
  registration_id int(10) NOT NULL ,
  num_tickets int(5) NOT NULL  default 0,
  to_survey int(1) NOT NULL default 0,
  PRIMARY KEY (registration_id)
) TYPE=MyISAM";
    
    /** The fields in the DB Table this class manages. */
    const FIELD_LIST = 'registration_id,num_tickets,to_survey';
    
    /** The XML node name for this entry. */
    const XML_NODE_NAME = 'aia_greycup_tickets';
    

	//VARIABLES:


	//CLASS CONSTRUCTOR
	//************************************************************************
	/**
	 * function __construct
	 * <pre>
	 * Initialize this object.
	 * </pre>
	 * @param $REGISTRATION_ID [INTEGER] The unique id of the tickets record we are managing.
	 * @return [void]
	 */
    function __construct( $REGISTRATION_ID=-1 ) 
    {
    
        $dbTableName = RowManager_TicketsManager::DB_TABLE;
        $fieldList = RowManager_TicketsManager::FIELD_LIST;
        $primaryKeyField = 'registration_id';
        $primaryKeyValue = $REGISTRATION_ID;
        
        if (( $REGISTRATION_ID != -1 ) && ( $REGISTRATION_ID != '' )) {
        
            $condition = $primaryKeyField . '=' . $primaryKeyValue;
            
        } else {
            $condition = '';
        }
        $xmlNodeName = RowManager_TicketsManager::XML_NODE_NAME;
        parent::__construct( $dbTableName, $fieldList, $primaryKeyField, $primaryKeyValue, $condition, $xmlNodeName);
        
        $this->dbDescription = RowManager_TicketsManager::DB_TABLE_DESCRIPTION;

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
	 * function getNumTickets
	 * <pre>
	 * Returns the value of the 'num_tickets' field
	 * </pre>
	 * @return [INTEGER]
	 */
    function getNumTickets() 
    {   
    	return $this->getValueByFieldName('num_tickets');
 	 }

    
    /**
	 * function setRegID
	 * <pre>
	 * Set the registration ID 
	 * </pre>
     *
	 * @param $regID		the ID of the registration
	 */
    function setRegID($regID) 
    {
        $this->setValueByFieldName('registration_id',$regID);
    }   
    
   /**
	 * function getJoinOnRegID
	 * <pre>
	 * returns the field used as a join condition for registration ID
	 * </pre>
	 * @return [STRING]
	 */
    function getJoinOnRegID()
    {   
        return $this->getJoinOnFieldX('registration_id');
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