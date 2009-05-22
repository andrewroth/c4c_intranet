<?php
/**
 * @package cim_reg
 */ 
/**
 * class RowManager_ActiveRuleManager
 * <pre> 
 * Used to determine whether the associated (volume) price rule has been triggered. Also keeps track of whether balance-owing recalculation has been executed yet..
 * </pre>
 * @author Russ Martin
 */
class  RowManager_ActiveRuleManager extends RowManager {

	//CONSTANTS:
	/** The name of the DB Table this class manages. */
    const DB_TABLE = 'cim_reg_activerules';
    
    const IS_TRUE = 1;
    const IS_FALSE = 0;
    
    /** The SQL description of the DB Table this class manages. */
    /*
     * pricerules_id [INTEGER]  Unique identifier of the associated price rule.
     * is_active [INTEGER]  Indicates whether the (volume) price rule has already been made active or not.
     * is_recalculated [INTEGER]  This is a flag indicating whether a balance-owing recalculation has been run yet with the 'is_active' flag being in its current state.
     */
    const DB_TABLE_DESCRIPTION = " (
  pricerules_id int(16) NOT NULL  auto_increment,
  is_active int(1) NOT NULL  default '0',
  is_recalculated int(1) NOT NULL  default '0',
  PRIMARY KEY (pricerules_id)
) TYPE=MyISAM";
    
    /** The fields in the DB Table this class manages. */
    const FIELD_LIST = 'pricerules_id,is_active,is_recalculated';
    
    /** The XML node name for this entry. */
    const XML_NODE_NAME = 'activerule';
    

	//VARIABLES:


	//CLASS CONSTRUCTOR
	//************************************************************************
	/**
	 * function __construct
	 * <pre>
	 * Initialize this object.
	 * </pre>
	 * @param $PRICERULE_ID [INTEGER] The unique id of the activerule we are managing.
	 * @return [void]
	 */
    function __construct( $PRICERULE_ID=-1 ) 
    {
    
        $dbTableName = RowManager_ActiveRuleManager::DB_TABLE;
        $fieldList = RowManager_ActiveRuleManager::FIELD_LIST;
        $primaryKeyField = 'pricerules_id';
        $primaryKeyValue = $PRICERULE_ID;
        
        if (( $PRICERULE_ID != -1 ) && ( $PRICERULE_ID != '' )) {
        
            $condition = $primaryKeyField . '=' . $primaryKeyValue;
            
        } else {
            $condition = '';
        }
        $xmlNodeName = RowManager_ActiveRuleManager::XML_NODE_NAME;
        parent::__construct( $dbTableName, $fieldList, $primaryKeyField, $primaryKeyValue, $condition, $xmlNodeName);
        
        $this->dbDescription = RowManager_ActiveRuleManager::DB_TABLE_DESCRIPTION;

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
	 * function getIsActive
	 * <pre>
	 * Returns the value of the 'is_active' field
	 * </pre>
	 * @return [INTEGER]
	 */
    function getIsActive() 
    {   
    	return $this->getValueByFieldName('is_active');
 	 }

 	  	 
     //************************************************************************
	/**
	 * function getIsRecalculated
	 * <pre>
	 * Returns the value of the 'is_recalculated' field
	 * </pre>
	 * @return [INTEGER]
	 */
    function getIsRecalculated() 
    {   
    	return $this->getValueByFieldName('is_recalculated');
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