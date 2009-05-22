<?php
/**
 * @package cim_reg
 */ 
/**
 * class RowManager_PriceRuleTypeManager
 * <pre> 
 * A price rule type..
 * </pre>
 * @author Russ Martin
 */
class  RowManager_PriceRuleTypeManager extends RowManager {

	//CONSTANTS:
	/** The name of the DB Table this class manages. */
    const DB_TABLE = 'cim_reg_priceruletypes';
    
    /** The SQL description of the DB Table this class manages. */
    /*
     * priceruletypes_id [INTEGER]  price rule type identifier
     * priceruletypes_desc [STRING]  Describes the price rule type (i.e. frosh discount)
     */
    const DB_TABLE_DESCRIPTION = " (
  priceruletypes_id int(10) NOT NULL  auto_increment,
  priceruletypes_desc varchar(128) NOT NULL  default '',
  PRIMARY KEY (priceruletypes_id)
) TYPE=MyISAM";
    
    /** The fields in the DB Table this class manages. */
    const FIELD_LIST = 'priceruletypes_id,priceruletypes_desc';
    
    /** The XML node name for this entry. */
    const XML_NODE_NAME = 'priceruletype';
    
	 const FORM_ATTRIBUTE_RULE = 1;		// discount based on value in form field
	 const DATE_RULE = 2;					// discount based on registration date before some set date
	 const VOLUME_RULE = 3;					// discount based on registration total >= certain amount (applied per campus)
	 const CAMPUS_RULE = 4;					// discount based on registrant's campus
    
	//VARIABLES:


	//CLASS CONSTRUCTOR
	//************************************************************************
	/**
	 * function __construct
	 * <pre>
	 * Initialize this object.
	 * </pre>
	 * @param $PRICERULETYPE_ID [INTEGER] The unique id of the priceruletype we are managing.
	 * @return [void]
	 */
    function __construct( $PRICERULETYPE_ID=-1 ) 
    {
    
        $dbTableName = RowManager_PriceRuleTypeManager::DB_TABLE;
        $fieldList = RowManager_PriceRuleTypeManager::FIELD_LIST;
        $primaryKeyField = 'priceruletypes_id';
        $primaryKeyValue = $PRICERULETYPE_ID;
        
        if (( $PRICERULETYPE_ID != -1 ) && ( $PRICERULETYPE_ID != '' )) {
        
            $condition = $primaryKeyField . '=' . $primaryKeyValue;
            
        } else {
            $condition = '';
        }
        $xmlNodeName = RowManager_PriceRuleTypeManager::XML_NODE_NAME;
        parent::__construct( $dbTableName, $fieldList, $primaryKeyField, $primaryKeyValue, $condition, $xmlNodeName);
        
        $this->dbDescription = RowManager_PriceRuleTypeManager::DB_TABLE_DESCRIPTION;

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
        return "priceruletypes_desc";
    }

    
    	
}

?>