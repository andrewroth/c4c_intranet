<?php
/**
 * @package cim_sch
 */ 
/**
 * class RowManager_GroupAssociationManager
 * <pre> 
 * Contains the relationship between the group and the person. .
 * </pre>
 * @author Calvin Jien & Russ Martin
 */
class  RowManager_GroupAssociationManager extends RowManager {

	//CONSTANTS:
	/** The name of the DB Table this class manages. */
    const DB_TABLE = 'cim_sch_groupassociation';
    
    /** The SQL description of the DB Table this class manages. */
    /*
     * groupAssocation_id [INTEGER]  ID of the association between group and person
     * group_id [INTEGER]  ID of the group
     * person_id [INTEGER]  ID of the person
     */
    const DB_TABLE_DESCRIPTION = " (
  groupAssocation_id int(11) NOT NULL  auto_increment,
  group_id int(11) NOT NULL  default '0',
  person_id int(11) NOT NULL  default '0',
  PRIMARY KEY (groupAssocation_id)
) TYPE=MyISAM";
    
    /** The fields in the DB Table this class manages. */
    const FIELD_LIST = 'groupAssocation_id,group_id,person_id';
    
    /** The XML node name for this entry. */
    const XML_NODE_NAME = 'groupassociation';
    

	//VARIABLES:


	//CLASS CONSTRUCTOR
	//************************************************************************
	/**
	 * function __construct
	 * <pre>
	 * Initialize this object.
	 * </pre>
	 * @param $GROUPASSOCATION_ID [INTEGER] The unique id of the groupassociation we are managing.
	 * @return [void]
	 */
    function __construct( $GROUPASSOCATION_ID=-1 ) 
    {
    
        $dbTableName = RowManager_GroupAssociationManager::DB_TABLE;
        $fieldList = RowManager_GroupAssociationManager::FIELD_LIST;
        $primaryKeyField = 'groupAssocation_id';
        $primaryKeyValue = $GROUPASSOCATION_ID;
        
        if (( $GROUPASSOCATION_ID != -1 ) && ( $GROUPASSOCATION_ID != '' )) {
        
            $condition = $primaryKeyField . '=' . $primaryKeyValue;
            
        } else {
            $condition = '';
        }
        $xmlNodeName = RowManager_GroupAssociationManager::XML_NODE_NAME;
        parent::__construct( $dbTableName, $fieldList, $primaryKeyField, $primaryKeyValue, $condition, $xmlNodeName);
        
        $this->dbDescription = RowManager_GroupAssociationManager::DB_TABLE_DESCRIPTION;

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
	/**
	 * function getGroups
	 * <pre>
	 * return group ID
	 * </pre>
	 * @return [STRING]
	 */
    function getGroups(){
    	return $this->getValueByFieldName('group_id');
    }
    /**
	 * function setPersonID
	 * <pre>
	 * sets person ID
	 * </pre>
	 * @return [void]
	 */
    function setPersonID( $person_ID )
    {
        $this->setValueByFieldName( 'person_id', $person_ID );
    }
    /**
	 * function setPersonIDAsCondition
	 * <pre>
	 * sets the condition on the person ID
	 * </pre>
	 * @return [void]
	 */
    function setPersonIDAsCondition( $personID )
    {
        $this->setDBCondition('person_id='.$personID);
        return;
    }
    /**
	 * function setGroupID
	 * <pre>
	 * sets group ID
	 * </pre>
	 * @return [void]
	 */
    function setGroupID($groupID){
    
    	$this->setValueByFieldName('group_id', $groupID);
    	return;
    }

}


?>