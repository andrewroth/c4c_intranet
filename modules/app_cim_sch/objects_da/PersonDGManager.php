<?php
/**
 * @package cim_hrdb
 */ 
/**
 * class RowManager_PersonDGManager
 * <pre> 
 * This manages the sch_person_sub_group table..
 * </pre>
 * @author CIM Team
 */
class  RowManager_PersonDGManager extends RowManager {

	//CONSTANTS:
	/** The name of the DB Table this class manages. */
    const DB_TABLE = 'sch_person_sub_group';
    
    /** The SQL description of the DB Table this class manages. */
    /*
     * person_id [INTEGER]  This is the first key for the table, storing a link to the person record
     * sub_group_id [INTEGER]  This is second key: the id of the small group assigned to the person id.
     * organization_id [INTEGER]  This is the third key: the campus/venue id associated with the small group
     */
    const DB_TABLE_DESCRIPTION = " (                     
                        `person_id` double NOT NULL default '0',                
                        `sub_group_id` double NOT NULL default '0',             
                        `organization_id` double NOT NULL default '0',          
                        `person_sub_group_id` int(11) NOT NULL auto_increment,  
                        PRIMARY KEY  (`person_sub_group_id`)                    
                      ) ENGINE=InnoDB";
    
    /** The fields in the DB Table this class manages. */
    const FIELD_LIST = 'person_id,sub_group_id,organization_id,person_sub_group_id';
    
    /** The XML node name for this entry. */
    const XML_NODE_NAME = 'person_sub_group';
    

	//VARIABLES:


	//CLASS CONSTRUCTOR
	//************************************************************************
	/**
	 * function __construct
	 * <pre>
	 * Initialize this object.
	 * </pre>
	 * @param $PERSON_SUBGRP_ID [INTEGER] The unique id of the access we are managing.
	 * @return [void]
	 */
    function __construct( $PERSON_SUBGRP_ID=-1 ) 
    {
    
        $dbTableName = RowManager_PersonDGManager::DB_TABLE;
        $fieldList = RowManager_PersonDGManager::FIELD_LIST;
        $primaryKeyField = 'person_sub_group_id';
        $primaryKeyValue = $PERSON_SUBGRP_ID;
        
        if (( $PERSON_SUBGRP_ID != -1 ) && ( $PERSON_SUBGRP_ID != '' )) {
        
            $condition = $primaryKeyField . '=' . $primaryKeyValue;
            
        } else {
            $condition = '';
        }
        $xmlNodeName = RowManager_PersonDGManager::XML_NODE_NAME;
        parent::__construct( $dbTableName, $fieldList, $primaryKeyField, $primaryKeyValue, $condition, $xmlNodeName);
        
        $this->dbDescription = RowManager_PersonDGManager::DB_TABLE_DESCRIPTION;

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
        return "person_id";
    }

    //************************************************************************
	/**
	 * function getPersonID
	 * <pre>
	 * Returns the Person ID related to a viewer.
	 * </pre>
	 * @return [STRING]
	 */
    function getPersonID()
    {
        return $this->getValueByFieldName('person_id');
    }

    //************************************************************************
	/**
	 * function getSubGroupID
	 * <pre>
	 * Returns the SubGroup ID related to a person.
	 * </pre>
	 * @return [STRING]
	 */
    function getSubGroupID()
    {
        return $this->getValueByFieldName('sub_group_id');
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
	 * function getJoinOnSubGroupID
	 * <pre>
	 * returns the field used as a join condition for sub_group_id
	 * </pre>
	 * @return [STRING]
	 */
    function getJoinOnSubGroupID()
    {
        return $this->getJoinOnFieldX('sub_group_id');
    }

    
    function setSubGroupID( $sub_group_id )
    {
        $this->setValueByFieldName( 'sub_group_id', $sub_group_id  );
        return;
    }
    
    function setPersonID( $personID )
    {
        $this->setValueByFieldName( 'person_id', $personID );
        return;
    }

    
    	
}

?>