<?php
/**
 * @package cim_reg
 */ 
/**
 * class RowManager_EventManager
 * <pre> 
 * Manages the information pertaining to events.
 * </pre>
 * @author Russ Martin
 */
class  RowManager_EventManager extends RowManager {

	//CONSTANTS:
	/** The name of the DB Table this class manages. */
    const DB_TABLE = 'cim_reg_event';
    
    /** The SQL description of the DB Table this class manages. */
    /*
     * event_id [INTEGER]  unique id
     * event_name [STRING]  name of event
     * event_descBrief [STRING]  brief description
     * event_descDetail [STRING]  Detailed description of the event
     * event_startDate [DATE]  start date
     * event_endDate [DATE]  event's end date
     * event_regStart [DATE]  registration starts
     * event_regEnd [DATE]  event registration ends
     * event_website [STRING]  event website
     * event_emailConfirmText [STRING]  email confirmation text
     * event_basePrice [STRING]  base price for the event
     * event_deposit [INTEGER]  deposit req'd
     * event_contactEmail [STRING]  contact email
     * event_pricingText [STRING]  pricing text
     */
    const DB_TABLE_DESCRIPTION = " (
  event_id int(8) NOT NULL  auto_increment,
  country_id int(50) NOT NULL  default '0',
  ministry_id int(20) unsigned NOT NULL  default '0',
  event_name varchar(128) NOT NULL  default '',
  event_descBrief varchar(128) NOT NULL  default '',
  event_descDetail text NOT NULL  default '',
  event_startDate datetime NOT NULL  default '0000-00-00 00:00:00',
  event_endDate datetime NOT NULL  default '0000-00-00 00:00:00',
  event_regStart datetime NOT NULL  default '0000-00-00 00:00:00',
  event_regEnd datetime NOT NULL  default '0000-00-00 00:00:00',
  event_website varchar(128) NOT NULL  default '',
  event_emailConfirmText text NOT NULL  default '',
  event_basePrice int(16) NOT NULL  default '0',
  event_deposit int(16) NOT NULL  default '0',
  event_allowCash int(1) NOT NULL default '1',  
  event_contactEmail text NOT NULL  default '',
  event_pricingText text NOT NULL  default '',
  event_onHomePage int(1) NOT NULL default '1',
  PRIMARY KEY (event_id)
) TYPE=MyISAM";
    
    /** The fields in the DB Table this class manages. */
    const FIELD_LIST = 'event_id,country_id,ministry_id,event_name,event_descBrief,event_descDetail,event_startDate,event_endDate,event_regStart,event_regEnd,event_website,event_emailConfirmText,event_basePrice,event_deposit,event_allowCash,event_contactEmail,event_pricingText,event_onHomePage';
    
    /** The XML node name for this entry. */
    const XML_NODE_NAME = 'event';
    

	//VARIABLES:


	//CLASS CONSTRUCTOR
	//************************************************************************
	/**
	 * function __construct
	 * <pre>
	 * Initialize this object.
	 * </pre>
	 * @param $EVENT_ID [INTEGER] The unique id of the event we are managing.
	 * @return [void]
	 */
    function __construct( $EVENT_ID=-1 ) 
    {
    
        $dbTableName = RowManager_EventManager::DB_TABLE;
        $fieldList = RowManager_EventManager::FIELD_LIST;
        $primaryKeyField = 'event_id';
        $primaryKeyValue = $EVENT_ID;
        
        if (( $EVENT_ID != -1 ) && ( $EVENT_ID != '' )) {
        
            $condition = $primaryKeyField . '=' . $primaryKeyValue;
            
        } else {
            $condition = '';
        }
        $xmlNodeName = RowManager_EventManager::XML_NODE_NAME;
        parent::__construct( $dbTableName, $fieldList, $primaryKeyField, $primaryKeyValue, $condition, $xmlNodeName);
        
        $this->dbDescription = RowManager_EventManager::DB_TABLE_DESCRIPTION;

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
	 * Set the event ID 
	 * </pre>
	 *return [void]
	 * @param $eventID		the ID of the event
	 */
    function setEventID($eventID) 
    {
        $this->setValueByFieldName('event_id',$eventID);
    }     
    
    /**
	 * function setMinistryID
	 * <pre>
	 * Set the ministry ID 
	 * </pre>
	 *return [void]
	 * @param $ministryID		the ID of the ministry
	 */
    function setMinistryID($ministryID) 
    {
        $this->setValueByFieldName('ministry_id',$ministryID);
    }       
    
    
    /**
	 * function setOnHomePage
	 * <pre>
	 * Set whether the event is shown to students 
	 * </pre>
	 *return [void]
	 * @param $val		0 for FALSE, 1 for TRUE
	 */    
    function setOnHomePage( $val )
    {
         $this->setValueByFieldName( "event_onHomePage", $val );
    }
    
    
     /**
	 * function getOnHomePage
	 * <pre>
	 * Get whether the event is shown to students 
	 * </pre>
	 *return [void]
	 * @return  $val		0 for FALSE, 1 for TRUE
	 */    
    function getOnHomePage( )
    {
         $this->getValueByFieldName( "event_onHomePage" );
    }   
    
    
    
        //************************************************************************
	/**
	 * function getEventName
	 * <pre>
	 * Returns the event name
	 * </pre>
	 * @return [STRING]
	 */
    function getEventName() 
    {
        return $this->getValueByFieldName( 'event_name' );
    }
    
	/**
	 * function getEventBasePrice
	 * <pre>
	 * Returns the event base price
	 * </pre>
	 * @return [STRING]
	 */
    function getEventBasePrice() 
    {
        return $this->getValueByFieldName( 'event_basePrice' );
    }    
    
 	/**
	 * function getEventEmail
	 * <pre>
	 * Returns the event e-mail address
	 * </pre>
	 * @return [STRING]
	 */
    function getEventEmail() 
    {
        return $this->getValueByFieldName( 'event_contactEmail' );
    }       
    
 	/**
	 * function isEventCashAllowed
	 * <pre>
	 * Returns whether or not cash IOUs are allowed
	 * </pre>
	 * @return [STRING]
	 */
    function isEventCashAllowed() 
    {	    
	    if ($this->getValueByFieldName( 'event_allowCash' ) == '1')
	    {
		    return true;
	    }
	    else
	    {
       	return false;
    	}
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
	 * function getJoinOnCountryID
	 * <pre>
	 * returns the field used as a join condition for country ID
	 * </pre>
	 * @return [STRING]
	 */
    function getJoinOnCountryID()
    {   
        return $this->getJoinOnFieldX('country_id');
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
        return "event_name";
    }
    


    
    	
}

?>