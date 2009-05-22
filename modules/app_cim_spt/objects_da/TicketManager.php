<?php
/**
 * @package cim_spt
 */ 
/**
 * class RowManager_TicketManager
 * <pre> 
 * Manages tickets for authentication with the SPT..
 * </pre>
 * @author Russ Martin
 */
class  RowManager_TicketManager extends RowManager {

	//CONSTANTS:
	/** The name of the DB Table this class manages. */
    const DB_TABLE = 'spt_ticket';
    
    /** The SQL description of the DB Table this class manages. */
    /*
     * ticket_id [INTEGER]  Unique id
     * viewer_id [INTEGER]  viewer's id
     * ticket_ticket [STRING]  Ticket
     * ticket_expiry [INTEGER]  when the ticket expires
     */
    const DB_TABLE_DESCRIPTION = " (
  ticket_id int(8) NOT NULL  auto_increment,
  viewer_id int(8) NOT NULL  default '0',
  ticket_ticket varchar(64) NOT NULL  default '',
  ticket_expiry int(16) NOT NULL  default '0',
  PRIMARY KEY (ticket_id)
) TYPE=MyISAM";
    
    /** The fields in the DB Table this class manages. */
    const FIELD_LIST = 'ticket_id,viewer_id,ticket_ticket,ticket_expiry';
    
    /** The XML node name for this entry. */
    const XML_NODE_NAME = 'ticket';
    

	//VARIABLES:


	//CLASS CONSTRUCTOR
	//************************************************************************
	/**
	 * function __construct
	 * <pre>
	 * Initialize this object.
	 * </pre>
	 * @param $initValue [INTEGER] The unique id of the ticket we are managing.
	 * @return [void]
	 */
    function __construct( $initValue=-1 ) 
    {
    
        $dbTableName = RowManager_TicketManager::DB_TABLE;
        $fieldList = RowManager_TicketManager::FIELD_LIST;
        $primaryKeyField = 'ticket_id';
        $primaryKeyValue = $initValue;
        
        if (( $initValue != -1 ) && ( $initValue != '' )) {
        
            $condition = $primaryKeyField . '=' . $primaryKeyValue;
            
        } else {
            $condition = '';
        }
        $xmlNodeName = RowManager_TicketManager::XML_NODE_NAME;
        parent::__construct( $dbTableName, $fieldList, $primaryKeyField, $primaryKeyValue, $condition, $xmlNodeName);
        
        $this->dbDescription = RowManager_TicketManager::DB_TABLE_DESCRIPTION;

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
    
    function setViewerID( $viewerID )
    {
        $this->setValueByFieldName( 'viewer_id', $viewerID );
        return;
    }
    
    function setTicket( $ticket )
    {
        $this->setValueByFieldName( 'ticket_ticket', $ticket );
        return;
    }
    
    function setExpiry( $expiry )
    {
        $this->setValueByFieldName( 'ticket_expiry', $expiry );
        return;
    }
    

    
    	
}

?>