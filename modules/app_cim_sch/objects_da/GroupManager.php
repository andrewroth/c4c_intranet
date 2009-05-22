<?php
/**
 * @package cim_sch
 */ 
/**
 * class RowManager_GroupManager
 * <pre> 
 * Contains the meta data for each of the groups.
 * </pre>
 * @author Calvin Jien & Russ Martin
 */
class  RowManager_GroupManager extends RowManager {

	//CONSTANTS:
	/** The name of the DB Table this class manages. */
    const DB_TABLE = 'cim_sch_group';
    
    /** The SQL description of the DB Table this class manages. */
    /*
     * group_id [INTEGER]  ID of the group
     * groupType_id [INTEGER]  ID of the group type
     * group_name [STRING]  The name of the group
     * group_desc [STRING]  The description of the group
     */
    const DB_TABLE_DESCRIPTION = " (
  group_id int(11) NOT NULL  auto_increment,
  groupType_id int(11) NOT NULL  default '0',
  group_name varchar(20) NOT NULL  default '',
  group_desc varchar(255) NOT NULL  default '',
  PRIMARY KEY (group_id)
) TYPE=MyISAM";
    
    /** The fields in the DB Table this class manages. */
    const FIELD_LIST = 'group_id,groupType_id,group_name,group_desc';
    
    /** The XML node name for this entry. */
    const XML_NODE_NAME = 'group';
    

	//VARIABLES:


	//CLASS CONSTRUCTOR
	//************************************************************************
	/**
	 * function __construct
	 * <pre>
	 * Initialize this object.
	 * </pre>
	 * @param $GROUP_ID [INTEGER] The unique id of the group we are managing.
	 * @return [void]
	 */
    function __construct( $GROUP_ID=-1 ) 
    {
    
        $dbTableName = RowManager_GroupManager::DB_TABLE;
        $fieldList = RowManager_GroupManager::FIELD_LIST;
        $primaryKeyField = 'group_id';
        $primaryKeyValue = $GROUP_ID;
        
        if (( $GROUP_ID != -1 ) && ( $GROUP_ID != '' )) {
        
            $condition = $primaryKeyField . '=' . $primaryKeyValue;
            
        } else {
            $condition = '';
        }
        $xmlNodeName = RowManager_GroupManager::XML_NODE_NAME;
        parent::__construct( $dbTableName, $fieldList, $primaryKeyField, $primaryKeyValue, $condition, $xmlNodeName);
        
        $this->dbDescription = RowManager_GroupManager::DB_TABLE_DESCRIPTION;

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
	 * function getJoinOnGroupID
	 * <pre>
	 * ?
	 * </pre>
	 * @return [STRING]
	 */
    function getJoinOnGroupID()
    {   
        return $this->getJoinOnFieldX('group_id');
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
        return "group_name";
    }
    

    /**
	 * function getName
	 * <pre>
	 * returns the name
	 * </pre>
	 * @return [STRING]
	 */
    function getName()
    {
        return $this->getValueByFieldName( 'group_name' );
    }
    /**
	 * function getGroupTypeID
	 * <pre>
	 * returns the group type ID
	 * </pre>
	 * @return [STRING]
	 */
    function getGroupTypeID()
    {
        return $this->getValueByFieldName( 'groupType_id' );
    }
	/**
	 * function getGroupID
	 * <pre>
	 * returns the group ID
	 * </pre>
	 * @return [STRING]
	 */
    function getGroupID()    {
        return $this->getValueByFieldName( 'group_id' );
    }
    /**
	 * function setGroupTypeID
	 * <pre>
	 * sets the group type ID
	 * </pre>
	 * @return [void]
	 */
    function setGroupTypeID($groupTypeID){
    	 $this->setValueByFieldName( 'groupType_id', $groupTypeID );
    }
}

?>