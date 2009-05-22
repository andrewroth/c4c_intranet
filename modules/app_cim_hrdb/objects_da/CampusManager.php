<?php
/**
 * @package cim_hrdb
 */ 
/**
 * class RowManager_CampusManager
 * <pre> 
 * Manages the Campus Table.
 * </pre>
 * @author CIM Team
 */
class  RowManager_CampusManager extends RowManager {

	//CONSTANTS:
	/** The name of the DB Table this class manages. */
    const DB_TABLE = 'cim_hrdb_campus';
    
    /** The SQL description of the DB Table this class manages. */
    /*
     * campus_id [INTEGER]  The id of the campus.
     * campus_desc [STRING]  The name of the Campus.
     * campus_shortDesc [STRING]  The short name for the campus.
     */
    const DB_TABLE_DESCRIPTION = " (
  campus_id int(50) NOT NULL  auto_increment,
  campus_desc varchar() NOT NULL  default '',
  campus_shortDesc varchar() NOT NULL  default '',
  accountgroup_id int(50) NOT NULL  default'0',
  region_id int(50) NOT NULL  default'0',
  campus_website varchar (128) NOT NULL default '',
  campus_facebookgroup varchar (128) NOT NULL default '',
  campus_gcxnamespace varchar (128) NOT NULL default '',
  PRIMARY KEY (campus_id)
) TYPE=MyISAM";
    
    /** The fields in the DB Table this class manages. */
    const FIELD_LIST = 'campus_id,campus_desc,campus_shortDesc,accountgroup_id,region_id,campus_website,campus_facebookgroup,campus_gcxnamespace';
    
    /** The XML node name for this entry. */
    const XML_NODE_NAME = 'campus';
    

	//VARIABLES:


	//CLASS CONSTRUCTOR
	//************************************************************************
	/**
	 * function __construct
	 * <pre>
	 * Initialize this object.
	 * </pre>
	 * @param $CAMPUS_ID [INTEGER] The unique id of the campus we are managing.
	 * @return [void]
	 */
    function __construct( $CAMPUS_ID=-1 ) 
    {
    
        $dbTableName = RowManager_CampusManager::DB_TABLE;
        $fieldList = RowManager_CampusManager::FIELD_LIST;
        $primaryKeyField = 'campus_id';
        $primaryKeyValue = $CAMPUS_ID;
        
        if (( $CAMPUS_ID != -1 ) && ( $CAMPUS_ID != '' )) {
        
            $condition = $primaryKeyField . '=' . $primaryKeyValue;
            
        } else {
            $condition = '';
        }
        $xmlNodeName = RowManager_CampusManager::XML_NODE_NAME;
        parent::__construct( $dbTableName, $fieldList, $primaryKeyField, $primaryKeyValue, $condition, $xmlNodeName);
        
        $this->dbDescription = RowManager_CampusManager::DB_TABLE_DESCRIPTION;

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
        return "campus_desc";
    }

    //************************************************************************
	/**
	 * function getJoinOnCampusID
	 * <pre>
	 * returns the field used as a join condition for campus_id
	 * </pre>
	 * @return [STRING]
	 */
    function getJoinOnCampusID()
    {   
        return $this->getJoinOnFieldX('campus_id');
    }
    
    
	/**
	 * function getJoinOnRegionID
	 * <pre>
	 * returns the field used as a join condition for region id
	 * </pre>
	 * @return [INT]
	 */
    function getJoinOnRegionID()
    {   
        return $this->getJoinOnFieldX('region_id');
    }     
    
        
    /**
	 * function getDesc
	 * <pre>
	 * returns a string
	 * </pre>
	 * @return [STRING]
	 */
    function getDesc()
    {
        return $this->getValueByFieldName('campus_desc');
    }
    /**
	 * function getShortDesc
	 * <pre>
	 * returns a string
	 * </pre>
	 * @return [STRING]
	 */
    function getShortDesc()
    {
        return $this->getValueByFieldName('campus_shortDesc');
    }
    /**
	 * function getDesc
	 * <pre>
	 * sets the campus ID
	 * </pre>
	 * @return [void]
	 */
    function setCampusID( $campusID )
    {
        $this->setValueByFieldName('campus_id', $campusID );
        return;
    }
	/**
	 * function setRegionID
	 * <pre>
	 * sets the region ID
	 * </pre>
	 * @return [void]
	 */
    function setRegionID( $regionID )
    {
        $this->setValueByFieldName('region_id', $regionID );
        return;
    }
    /**
	 * function getCampusID
	 * <pre>
	 * gets the campus ID
	 * </pre>
	 * @return [INT]
	 */
    function getCampusID(){
    	return $this->getValueByFieldName('campus_id');	
    }
    /**
	 * function getFacebookGroupURL
	 * <pre>
	 * returns a string
	 * </pre>
	 * @return [STRING]
	 */
    function getFacebookGroupURL()
    {
        return $this->getValueByFieldName('campus_facebookgroup');
    }
    /**
	 * function getGCXNamespace
	 * <pre>
	 * returns a string
	 * </pre>
	 * @return [STRING]
	 */
    function getGCXNamespace()
    {
        return $this->getValueByFieldName('campus_gcxnamespace');
    }
    
}

?>