<?php
/**
 * @package cim_reg
 */ 
/**
 * class RowManager_PriceRuleManager
 * <pre> 
 * A pricing rule (i.e. frosh discount) for a particular event..
 * </pre>
 * @author Russ Martin
 */
class  RowManager_PriceRuleManager extends RowManager {

	//CONSTANTS:
	/** The name of the DB Table this class manages. */
    const DB_TABLE = 'cim_reg_pricerules';
    
    /** The SQL description of the DB Table this class manages. */
    /*
     * pricerules_id [INTEGER]  Unique identifier for this pricing rule
     * event_id [INTEGER]  Event identifier used to identify event associated with the pricing rule.
     * priceruletypes_id [INTEGER]  Identifies the price rule type of the particular rule
     * pricerules_desc [STRING]  Description of the pricing rule
     * fields_id [INTEGER]  If not zero, refers to a form field identifier that affects the price for the event.
     * pricerules_value [STRING]  A value that is used to determine when the price rule is applied (i.e. a date or a volume total, etc.)
     * pricerules_discount [INTEGER]  The actual discount to be applied to the price based on this price rule.
     */
    const DB_TABLE_DESCRIPTION = " (
  pricerules_id int(10) NOT NULL  auto_increment,
  event_id int(10) NOT NULL  default '0',
  priceruletypes_id int(10) NOT NULL  default '0',
  pricerules_desc text NOT NULL  default '',
  fields_id int(10) NOT NULL  default '0',
  pricerules_value varchar(128) NOT NULL  default '',
  pricerules_discount int(12) NOT NULL  default '0',
  PRIMARY KEY (pricerules_id)
) TYPE=MyISAM";
    
    /** The fields in the DB Table this class manages. */
    const FIELD_LIST = 'pricerules_id,event_id,priceruletypes_id,pricerules_desc,fields_id,pricerules_value,pricerules_discount';
    
    /** The XML node name for this entry. */
    const XML_NODE_NAME = 'pricerule';
    
    const IS_VOLUME_RULE = 3;		// taken from cim_reg_priceruletypes table
    

	//VARIABLES:


	//CLASS CONSTRUCTOR
	//************************************************************************
	/**
	 * function __construct
	 * <pre>
	 * Initialize this object.
	 * </pre>
	 * @param $PRICERULE_ID [INTEGER] The unique id of the pricerule we are managing.
	 * @return [void]
	 */
    function __construct( $PRICERULE_ID=-1 ) 
    {
    
        $dbTableName = RowManager_PriceRuleManager::DB_TABLE;
        $fieldList = RowManager_PriceRuleManager::FIELD_LIST;
        $primaryKeyField = 'pricerules_id';
        $primaryKeyValue = $PRICERULE_ID;
        
        if (( $PRICERULE_ID != -1 ) && ( $PRICERULE_ID != '' )) {
        
            $condition = $primaryKeyField . '=' . $primaryKeyValue;
            
        } else {
            $condition = '';
        }
        $xmlNodeName = RowManager_PriceRuleManager::XML_NODE_NAME;
        parent::__construct( $dbTableName, $fieldList, $primaryKeyField, $primaryKeyValue, $condition, $xmlNodeName);
        
        $this->dbDescription = RowManager_PriceRuleManager::DB_TABLE_DESCRIPTION;

    }
    
	/**
	 * function createNewEntry
	 * <pre>
	 * Creates a new table entry in the DB for this object to manage.
	 * </pre>
	 * @param $doAllowPrimaryKeyUpdate [BOOL] allow insertion of primary key 
	 * value if present.
	 * @return [void]
	 */
    function createNewEntry( $doAllowPrimaryKeyUpdate=false ) 
    {  
	    parent::createNewEntry( $doAllowPrimaryKeyUpdate );
	    
	    if ($this->isVolumePriceRule() == true)
	    {
	    
	      // create a record for tracking whether a volume rule is active
	      $activeRule = new RowManager_ActiveRuleManager($this->getID());
    		$setRecord = array();
    		$setRecord['pricerules_id'] = $this->getID();
			$setRecord['is_active'] = RowManager_ActiveRuleManager::IS_FALSE;		// default value
			$setRecord['is_recalculated'] = RowManager_ActiveRuleManager::IS_TRUE;	// default value
			$activeRule->loadFromArray($setRecord); 
         $activeRule->createNewEntry(true);
      }
    }

        
	/**
	 * function deleteEntry
	 * <pre>
	 * Removes the DB table info.
	 * </pre>
	 * @return [void]
	 */
    function deleteEntry() 
    { 
	    parent::deleteEntry();
	    
	    if ($this->isVolumePriceRule() == true)
	    {
	    
	      // create a record for tracking whether a volume rule is active
	      $activeRule = new RowManager_ActiveRuleManager($this->getID());
    		$activeRule->deleteEntry();
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
    
    
     /**
	 * function setEventID
	 * <pre>
	 * Set the event ID for form price rule creation
	 * </pre>
	 *return [void]
	 * @param $eventID		the ID of the event
	 */
    function setEventID($eventID) 
    {
        $this->setValueByFieldName('event_id',$eventID);
    }
    
     /**
	 * function setPriceRuleType
	 * <pre>
	 * Set the price rule type ID for form price rule creation
	 * </pre>
	 *return [void]
	 * @param $ruleTypeID		the price rule type ID
	 */
    function setPriceRuleType($ruleTypeID) 
    {
        $this->setValueByFieldName('priceruletypes_id',$ruleTypeID);
    }
        
     /**
	 * function isVolumePriceRule
	 * <pre>
	 * returns whether or not the current price rule is a volume discount/fee rule
	 * </pre>
	 */
    function isVolumePriceRule()
    {
	    $ruleType = $this->getValueByFieldName('priceruletypes_id');
	    if ($ruleType == RowManager_PriceRuleManager::IS_VOLUME_RULE)
	    {
		    return true;
	    }
	    else
	    {
		    return false;
	    }
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