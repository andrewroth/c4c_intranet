<?php
/**
 * @package cim_hrdb
 */ 
/**
 * class RowManager_AdminManager
 * <pre> 
 * Manages the Admin access table..
 * </pre>
 * @author CIM Team
 */
class  RowManager_AdminManager extends RowManager {

	//CONSTANTS:
	/** The name of the DB Table this class manages. */
    const DB_TABLE = 'cim_hrdb_admin';
    
    /** The SQL description of the DB Table this class manages. */
    /*
     * admin_id [INTEGER]  The id.
     * viewer_id [INTEGER]  The user(viewer) id.
     * priv_id [INTEGER]  The privilege ID assigned to the user(viewer).
     */
    const DB_TABLE_DESCRIPTION = " (
  admin_id int(1) NOT NULL  auto_increment,
  person_id int(50) NOT NULL  default '0',
  priv_id int(20) NOT NULL  default '0',
  PRIMARY KEY (admin_id)
) TYPE=MyISAM";
    
    /** The fields in the DB Table this class manages. */
    const FIELD_LIST = 'admin_id,person_id,priv_id';

    /** The Campus Level Priviledge. Allows users to administer Accounts for
     *  their campuses.
     */
    const PRIVILEDGE_CAMPUS = 2;

    /** The Site Level Priviledge. Super Admin rights for the HRDB module.
     */
    const PRIVILEDGE_SITE = 1;
    
    /** The XML node name for this entry. */
    const XML_NODE_NAME = 'admin';
    

	//VARIABLES:


	//CLASS CONSTRUCTOR
	//************************************************************************
	/**
	 * function __construct
	 * <pre>
	 * Initialize this object.
	 * </pre>
	 * @param $ADMIN_ID [INTEGER] The unique id of the admin we are managing.
	 * @return [void]
	 */
    function __construct( $ADMIN_ID=-1 ) 
    {
    
        $dbTableName = RowManager_AdminManager::DB_TABLE;
        $fieldList = RowManager_AdminManager::FIELD_LIST;
        $primaryKeyField = 'admin_id';
        $primaryKeyValue = $ADMIN_ID;
        
        if (( $ADMIN_ID != -1 ) && ( $ADMIN_ID != '' )) {
        
            $condition = $primaryKeyField . '=' . $primaryKeyValue;
            
        } else {
            $condition = '';
        }
        $xmlNodeName = RowManager_AdminManager::XML_NODE_NAME;
        parent::__construct( $dbTableName, $fieldList, $primaryKeyField, $primaryKeyValue, $condition, $xmlNodeName);
        
        $this->dbDescription = RowManager_AdminManager::DB_TABLE_DESCRIPTION;

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
	 * function getJoinOnPersonID
	 * <pre>
	 * returns the field used as a join condition for campus_id
	 * </pre>
	 * @return [STRING]
	 */
    function getJoinOnPersonID()
    {   
        return $this->getJoinOnFieldX('person_id');
    }    
    
    //************************************************************************
	/**
	 * function hasCampusPriv
	 * <pre>
	 * returns wether or not this account has Campus Level Priviledges
	 * </pre>
	 * @return [BOOL]
	 */
    function hasCampusPriv($viewer_id = '')
    {
        $priv = (int) $this->getValueByFieldName('priv_id');
        $sitePriv = RowManager_AdminManager::PRIVILEDGE_CAMPUS;
                        	      
        // if campus privileges not found then determine if person is staff
        if ( ($priv != $sitePriv) && ($viewer_id != '') )
        {
// 	        echo 'is staff = '.$this->isStaff($person_id);
				return $this->isStaff($viewer_id);
	        
        }
        else // if ($priv == $sitePriv)  i.e. person has campus admin privs
        {

	        return ($priv == $sitePriv);
        }


    }

    /**
	 * function hasCampusPriv
	 * <pre>
	 * returns person ID based on the viewer ID
	 * </pre>
	 * @return [INT]
	 */
         // self-explanatory: system user == person to be registered (or at least get personal info changed)
    protected function getPersonIDfromViewerID($viewer_id)
    {
       $accessPriv = new RowManager_AccessManager();
       $accessPriv->setViewerID($viewer_id);
       
       $accessPrivList = $accessPriv->getListIterator();
       $accessPrivArray = $accessPrivList->getDataList();
       
       $personID = '';
       reset($accessPrivArray);
       foreach (array_keys($accessPrivArray) as $k)
       {
       	$record = current($accessPrivArray);
       	$personID = $record['person_id'];	// can only be 1 person_id per viewer_id
       	next($accessPrivArray);
    	 }
       
       return $personID;
    }   
    
    
    //************************************************************************
	/**
	 * function isStaff
	 * <pre>
	 * returns wether or not this account has Campus Level Priviledges (as staff)
	 * </pre>
	 * @return [BOOL]
	 */
    function isStaff($viewer_id = '')
    {
	    $person_id = '';
	    if ($viewer_id != '')
	    {
	    	$person_id = $this->getPersonIDfromViewerID($viewer_id);
    	 }
    	 
	    if ($person_id != '')
	    {
		     $staffManager = new RowManager_StaffManager();
		     $staffManager->setPersonID($person_id);
		     $staffManager->setIsActive(true);	// NOTE: true == 1
		     
		     $staffList = $staffManager->getListIterator();	 
		     $staffArray = $staffList->getDataList();
		     
// 		     echo 'staff records = <pre>'.print_r($staffArray,true).'</pre>';
		     
		     // Person was determined to be a staff member
		     if (count($staffArray) > 0)
		     {
// 					/** Create new privilege entry **/
// 					$values = array();
// 					$values['person_id'] = $person_id;		// redundant?
// 					$values['priv_id'] = RowManager_AdminManager::PRIVILEDGE_CAMPUS;

// 					$this->loadFromArray( $values );
// 		      	$this->createNewEntry();		      	
// 		      	
// 		      	/** Get the new admin id and use it to insert a campusadminid **/
// 		      	$newAdminID = $this->getLastInsertID();
// 		      	
// 		      	/** Create a campus admin entry for each campus the staff is a member of **/
// 		      	$campus_assignments = new RowManager_AssignmentsManager();
// 		      	$campus_assignments->setPersonID($person_id);
// 		      	
// 		      	$assignList = $campus_assignments->getListIterator();
// 		      	$assignArray = $assignList->getDataList();
// 		      	
// // 		      	echo 'campus assignments = <pre>'.print_r($assignArray,true).'</pre>';
// 		      	
// 		      	reset($assignArray);
// 		      	foreach (array_keys($assignArray) as $key)
// 		      	{
// 			      	$record = current($assignArray);
// 			      	$campus_id = $record['campus_id'];
// 		      	
// 			      	/** Create campus-admin entry **/
// 			      	$campusAdminManager = new RowManager_CampusAdminManager();
// 			      	$values2 = array();
// 			      	$values2['admin_id'] = $newAdminID;
// 			      	$values2['campus_id'] = $campus_id;
// 			      	$campusAdminManager->loadFromArray( $values2 );
// 		      		$campusAdminManager->createNewEntry();
// 		      		
// 		      		next($assignArray);
// 		      	}
					return true;
				}
				else	// person not found in staff table
				{
					return false;
				}
			}
			else	// no person_id was given
			{
				return false;
			}
	 }

    //************************************************************************
	/**
	 * function hasSitePriv
	 * <pre>
	 * returns wether or not this account has Site Level Priviledges
	 * </pre>
	 * @return [BOOL]
	 */
    function hasSitePriv()
    {
        $priv = (int) $this->getValueByFieldName('priv_id');
        $sitePriv = RowManager_AdminManager::PRIVILEDGE_SITE;
        return ( $priv == $sitePriv);
    }
    
    /** function setSitePriv
     *
     * Set the priv_id filter to site-wide administration
     */
	 /**
	 * function hasSitePriv
	 * <pre>
	 * returns wether or not this account has Site Level Priviledges
	 * </pre>
	 * @return [void]
	 */
    function setSitePriv()
    {
	     $sitePriv = RowManager_AdminManager::PRIVILEDGE_SITE;
        $this->setValueByFieldName( 'priv_id', $sitePriv );
     }
	    

    //************************************************************************
	/**
	 * function loadByPersonID
	 * <pre>
	 * Attempts to load this object given a person_id
	 * </pre>
	 * @param $viewerID [INTEGER] new person_id
	 * @return [BOOL]
	 */
    function loadByPersonID( $personID )
    {
        $condition = 'person_id='.$personID;
        return $this->loadByCondition( $condition );
    }
    
   //************************************************************************
	/**
	 * function setAdminID
	 * <pre>
	 * Sets the id for the Admin
	 * </pre>
	 * @param $title [INT] The person id.
	 * @return [void]
	 */
    function setAdminID( $admin_ID )
    {
        $this->setValueByFieldName( 'admin_id', $admin_ID );
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