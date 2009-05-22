<?php
/**
 * @package cim_hrdb
 */ 
/**
 * class RowManager_StaffDirectorManager
 * <pre> 
 * Stores staff-to-director associations. That is, it indicates which staff have which other staff as their director(s)..
 * </pre>
 * @author CIM Team
 */
class  RowManager_StaffDirectorManager extends RowManager {

	//CONSTANTS:
	/** The name of the DB Table this class manages. */
    const DB_TABLE = 'cim_hrdb_staffdirector';
    
    /** The SQL description of the DB Table this class manages. */
    /*
     * staffdirector_id [INTEGER]  The unique ID of the staff-to-director association
     * staff_id [INTEGER]  The ID of the staff to be associated with a director.
     * director_id [INTEGER]  The staff ID of the staff director supervising the staff member indicated in the "staff_id" field.
     */
    const DB_TABLE_DESCRIPTION = " (
  staffdirector_id int(60) NOT NULL  auto_increment,
  staff_id int(50) NOT NULL  default '0',
  director_id int(50) NOT NULL  default '0',
  PRIMARY KEY (staffdirector_id)
) TYPE=MyISAM";
    
    /** The fields in the DB Table this class manages. */
    const FIELD_LIST = 'staffdirector_id,staff_id,director_id';
    
    /** The XML node name for this entry. */
    const XML_NODE_NAME = 'staffdirector';
    

	//VARIABLES:


	//CLASS CONSTRUCTOR
	//************************************************************************
	/**
	 * function __construct
	 * <pre>
	 * Initialize this object.
	 * </pre>
	 * @param $STAFFDIRECTOR_ID [INTEGER] The unique id of the staffdirector we are managing.
	 * @return [void]
	 */
    function __construct( $STAFFDIRECTOR_ID=-1 ) 
    {
    
        $dbTableName = RowManager_StaffDirectorManager::DB_TABLE;
        $fieldList = RowManager_StaffDirectorManager::FIELD_LIST;
        $primaryKeyField = 'staffdirector_id';
        $primaryKeyValue = $STAFFDIRECTOR_ID;
        
        if (( $STAFFDIRECTOR_ID != -1 ) && ( $STAFFDIRECTOR_ID != '' )) {
        
            $condition = $primaryKeyField . '=' . $primaryKeyValue;
            
        } else {
            $condition = '';
        }
        $xmlNodeName = RowManager_StaffDirectorManager::XML_NODE_NAME;
        parent::__construct( $dbTableName, $fieldList, $primaryKeyField, $primaryKeyValue, $condition, $xmlNodeName);
        
        $this->dbDescription = RowManager_StaffDirectorManager::DB_TABLE_DESCRIPTION;

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
	 * function getDirectorHierarchy
	 * <pre>
	 * returns the ResultSet object containing the director hierarchy
	 * </pre>
	 * @param $director_id [INT] The root director id of the hierarchy	 
	 * @return [OBJECT] ReadOnlyResultSet.
	 */    
    function getDirectorHierarchy($director_id = TOP_DIRECTOR_ID)	// March 17, 2008:  151  (Mike Woodard)	
    {
	    $sql = 'select distinct ';
	    
	    // Initialize column filters
	    for ($lvl = 1; $lvl <= MAX_DIRECTOR_LEVELS; $lvl++)
	    {
		    $sql .= 'table'.$lvl.'.director_id as dir_lvl'.$lvl.',';
		    $sql .= 'table'.$lvl.'.staff_id as staff_lvl'.$lvl.',';
	    }
	    $sql = substr($sql,0,-1);	// remove comma
	    $init_val = 1;
	    $sql .= ' from '.RowManager_StaffDirectorManager::DB_TABLE.' as table'.$init_val;
	    
		 // Setup join portion of the SQL query    
	    for ($level = 2; $level <= MAX_DIRECTOR_LEVELS; $level++)
	    {	   
		    $sql .= ' LEFT JOIN '.RowManager_StaffDirectorManager::DB_TABLE.' as table'.$level;
		    $sql .= ' on table'.$level.'.director_id = table'.(--$level).'.staff_id';
		    $level++;
	    }
	    
	    $sql .= ' where table'.$init_val.'.director_id = '.$director_id;	    
			
// 	    echo 'hier. = <br>'.$sql.'<BR><BR>';
	    
        // create a new DB object
        $db = new Database_Site();
        $databaseName = $this->dbName;
        if ( $databaseName == '' )
        {
            $databaseName = SITE_DB_NAME;
        }
        $db->connectToDB( $databaseName, $this->dbPath, $this->dbUser, $this->dbPword );
        
//         echo "<BR>sql = ".$sql;
        
        // run the sql
        $db->runSQL( $sql );
        
        // create a new ReadOnlyResultSet using current db object
        $recordSet = new ReadOnlyResultSet( $db );
        
        // return this record set
        return $recordSet;			
     }

    
    //************************************************************************
	/**
	 * function getJoinOnStaffID
	 * <pre>
	 * returns the field used as a join condition for staff_id
	 * </pre>
	 * @return [STRING]
	 */
    function getJoinOnStaffID()
    {   
        return $this->getJoinOnFieldX('staff_id');
    }   
 
       
    //************************************************************************
	/**
	 * function getJoinOnDirectorID
	 * <pre>
	 * returns the field used as a join condition for director_id
	 * </pre>
	 * @return [STRING]
	 */
    function getJoinOnDirectorID()
    {   
        return $this->getJoinOnFieldX('director_id');
    }         


   //************************************************************************
	/**
	 * function getStaffID
	 * <pre>
	 * Gets the id for the staff being directed
	 * </pre>
	 * @param $title [INT] The staff id.
	 * @return [void]
	 */
    function getStaffID()
    {
        return $this->getValueByFieldName('staff_id');
    }    
    
    
        
    /**
	 * function setDirectorID
	 * <pre>
	 * sets the Director's ID
	 * </pre>
	 * @return [void]
	 */
    function setDirectorID( $director_id )
    {
        $this->setValueByFieldName( 'director_id', $director_id );
    }
    /**
	 * function setStaffID
	 * <pre>
	 * returns the field used as a join condition for activitytype id
	 * </pre>
	 * @return [STRING]
	 */
    function setStaffID( $staff_id )
    {
        $this->setValueByFieldName( 'staff_id', $staff_id );
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