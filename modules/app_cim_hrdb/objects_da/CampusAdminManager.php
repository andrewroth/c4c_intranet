<?php
/**
 * @package cim_hrdb
 */ 
/**
 * class RowManager_CampusAdminManager
 * <pre> 
 * Manage for the CampusAdmin table..
 * </pre>
 * @author CIM Team
 */
class  RowManager_CampusAdminManager extends RowManager {

	//CONSTANTS:
	/** The name of the DB Table this class manages. */
    const DB_TABLE = 'cim_hrdb_campusadmin';

    /** The SQL description of the DB Table this class manages. */
    /*
     * campusadmin_id [INTEGER]  ID for the assignment
     * admin_id [INTEGER]  The id from the admin table.
     * campus_id [INTEGER]  The id for the campus being assigned to the viewer.
     */
    const DB_TABLE_DESCRIPTION = " (
  campusadmin_id int(20) NOT NULL  auto_increment,
  admin_id int(20) NOT NULL  default '0',
  campus_id int(20) NOT NULL  default '0',
  PRIMARY KEY (campusadmin_id)
) TYPE=MyISAM";

    /** The fields in the DB Table this class manages. */
    const FIELD_LIST = 'campusadmin_id,admin_id,campus_id';

    /** The XML node name for this entry. */
    const XML_NODE_NAME = 'campusadmin';


	//VARIABLES:


	//CLASS CONSTRUCTOR
	//************************************************************************
	/**
	 * function __construct
	 * <pre>
	 * Initialize this object.
	 * </pre>
	 * @param $CAMPUSADMIN_ID [INTEGER] The unique id of the campusadmin we are managing.
	 * @return [void]
	 */
    function __construct( $CAMPUSADMIN_ID=-1 )
    {

        $dbTableName = RowManager_CampusAdminManager::DB_TABLE;
        $fieldList = RowManager_CampusAdminManager::FIELD_LIST;
        $primaryKeyField = 'campusadmin_id';
        $primaryKeyValue = $CAMPUSADMIN_ID;

        if (( $CAMPUSADMIN_ID != -1 ) && ( $CAMPUSADMIN_ID != '' )) {

            $condition = $primaryKeyField . '=' . $primaryKeyValue;

        } else {
            $condition = '';
        }
        $xmlNodeName = RowManager_CampusAdminManager::XML_NODE_NAME;
        parent::__construct( $dbTableName, $fieldList, $primaryKeyField, $primaryKeyValue, $condition, $xmlNodeName);

        $this->dbDescription = RowManager_CampusAdminManager::DB_TABLE_DESCRIPTION;

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
        return "campus_id";
    }

   //************************************************************************
	/**
	 * function getCampusID
	 * <pre>
	 * Gets the id for the campus
	 * </pre>
	 * @param $title [INT] The campus id.
	 * @return [void]
	 */
    function getCampusID()
    {
        return $this->getValueByFieldName('campus_id');
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

    //************************************************************************
	/**
	 * function loadByAdminID
	 * <pre>
	 * Attempts to load this manager using the given AdminID.
	 * </pre>
	 * @param $userID [STRING] the user id of the accout to load
	 * @return [BOOL]
	 */
    function loadByAdminID( $adminID )
    {
        $this->loadByCondition('admin_id='.$adminID);
    }
    
   //************************************************************************
	/**
	 * function setadminID
	 * <pre>
	 * Sets the id for the admin
	 * </pre>
	 * @param $title [INT] The admin id.
	 * @return [void]
	 */
    function setAdminID( $admindID )
    {
        $this->setValueByFieldName( 'admin_id', $admindID );
    }
    
   //************************************************************************
	/**
	 * function setCampusID
	 * <pre>
	 * Sets the id for the campus
	 * </pre>
	 * @param $campusID [INT] The campus id.
	 * @return [void]
	 */
    function setCampusID( $campusID )
    {
        $this->setValueByFieldName( 'campus_id', $campusID );
    } 

    
    	
}

?>