<?php

$toolName = 'modules/app_cim_hrdb/objects_da/CampusManager.php';
$toolPath = Page::findPathExtension( $toolName );
require_once( $toolPath.$toolName);

class PrivilegeManager {

	//CONSTANTS:
	const SUPER_ADMIN = 1;
	const FINANCE_ADMIN = 2;
	const EVENT_ADMIN = 3;
	const CAMPUS_ADMIN = 4;
	
	const ALL_EVENTS = 'ALL';
	const ALL_CAMPUSES = 'ALL';
		
// 	const STUDENT = 5;

	//VARIABLES:
	
	// [INTEGER]  The ID of the viewer whose privileges are being managed
	protected $viewer_id;
	
	// [BOOLEAN]
	protected $isSuperAdmin;
	protected $isStudent;
	
	// [ARRAY]  key = event_id, data = 1/0  (true/false)
	protected $isFinanceAdmin;
	protected $isEventAdmin;
	
	// [ARRAY] key = event_id, data = |-separated list of campus_ids
	protected $isCampusAdmin;

	
// 	// [ARRAY]  the events associated with user
// 	protected $event_id;
// 	
// 	// [ARRAY]  the campuses associated with user
// 	protected $campus_id;
	
// 	protected $privilegeLevel;
	
	//CLASS CONSTRUCTOR
    function __construct( $viewerID ) 
    {
	     $this->viewer_id = $viewerID;
	     
	     // set defaults
	     $this->isSuperAdmin = false;
	     $this->isFinanceAdmin = array();
	     $this->isEventAdmin = array();
	     $this->isCampusAdmin = array();
	    
        $superAdminManager = new RowManager_SuperAdminAssignmentManager();

        // the permissions are scaled if you have n permission you all have any permission < n
        $this->isSuperAdmin = $superAdminManager->loadByViewer( $viewerID );
        if ($this->isSuperAdmin == true)
        {
	        $this->isFinanceAdmin[PrivilegeManager::ALL_EVENTS] = 1;
	        $this->isEventAdmin[PrivilegeManager::ALL_EVENTS] = 1;
	        $this->isCampusAdmin[PrivilegeManager::ALL_EVENTS] = PrivilegeManager::ALL_CAMPUSES;
        }

        // determine for which events the viewer is an finance, event, or campus admin
       $eventPrivManager = new RowManager_EventAdminAssignmentManager();
       $eventPrivManager->setViewerID($this->viewer_id);
       
       $privList = $eventPrivManager->getListIterator();
       $privArray = $privList->getDataList();
       
       $isEventAdmin = array();
       reset($privArray);
       foreach (array_keys($privArray) as $k)
       {
	       $record = current($privArray);     
	       $eventID = $record['event_id'];
	       $priv = $record['priv_id'];
	       $adminID = $record['eventadmin_id'];
	    
	       // set admin flags based on records found in eventadmin table (SUPER_ADMIN has its own table)
	       switch ($priv)
	       {	
		       case  PrivilegeManager::FINANCE_ADMIN:
		       	$this->isFinanceAdmin[$eventID] = 1;	// set value to true (1)
		       	$this->isEventAdmin[$eventID] = 1;	// set value to true (1)
		       	$this->isCampusAdmin[$eventID] = PrivilegeManager::ALL_CAMPUSES;	// set value to represent all campuses
		       	break;
		       case PrivilegeManager::EVENT_ADMIN:
		       	$this->isEventAdmin[$eventID] = 1;	// set value to true (1)
		       	$this->isCampusAdmin[$eventID] = PrivilegeManager::ALL_CAMPUSES;	// set value to represent all campuses		       	
		       	break;	
		       case PrivilegeManager::CAMPUS_ADMIN:	 
		       
		       	$adminCampuses = new RowManager_EventAdminCampusAssignmentManager();
		       	$adminCampuses->setEventAdminID($adminID);
		       	
		       	$campusList = $adminCampuses->getListIterator();
		       	$campusArray = $campusList->getDataList();
		       	
// 		       	echo "campuslist = <pre>".print_r($campusArray,true)."</pre>";
		       	
		       	$adminCampusList = '';
		       	reset($campusArray);
		       	foreach (array_keys($campusArray) as $k)
		       	{
			       	$row = current($campusArray);
			       	
			       	$campus_id = $row['campus_id'];
			       	$adminCampusList .= $campus_id.'|';
			       	
			       	next($campusArray);
		       	}
		       	$adminCampusList = substr($adminCampusList,0,-1);	// remove last '|'
		       	
		       	$this->isCampusAdmin[$eventID] = $adminCampusList;	// set value to list of campus IDs
		       	break;
		       default:
		       	break;
	       }	

	       
	       next($privArray);
       }
       
       // if no privileges found, then check if viewer is C4C staff with associated campus(es)
       if (count($this->isCampusAdmin) < 1)
       {
		    $access = new RowManager_AccessManager();
		    $access->setViewerID($this->viewer_id);	
		    $person = new RowManager_PersonManager();
		    $staff = new RowManager_StaffManager();
	   	 $staff->setIsActive('1');	    
		    $assign = new RowManager_AssignmentsManager();
		    $assign->setAssignmentStatus(CA_STAFF);
		    $campus = new RowManager_CampusManager();
		    
		    $multiTables = new MultiTableManager();
		    $multiTables->addRowManager($access);
		    $multiTables->addRowManager($person, new JoinPair( $access->getJoinOnPersonID(), $person->getJoinOnPersonID()));
		    $multiTables->addRowManager($staff, new JoinPair ($person->getJoinOnPersonID(), $staff->getJoinOnPersonID()));
		    $multiTables->addRowManager($assign, new JoinPair ($assign->getJoinOnPersonID(), $person->getJoinOnPersonID()));
		    $multiTables->addRowManager($campus, new JoinPair ($assign->getJoinOnCampusID(), $campus->getJoinOnCampusID()));
		    
// 		    $multiTables->addSearchCondition("cim_hrdb_assignment.assignmentstatus_id = ".PrivilegeManager::STATUS_STAFF);
		    
		    $campusList = $multiTables->getListIterator();
		    $campusArray = $campusList->getDataList();
		    reset($campusArray);
		    
//  		    echo 'campus array for user: <pre>'.print_r($campusArray, true).'</pre><br>';
		    
		    // some campus was found, so viewer is admin for this campus (for all events)
		    if (isset($campusArray)&&(count($campusArray) > 0)) 
		    {
			    $listOfCampuses = '';
			    foreach (array_keys($campusArray) as $k)
			    {
				    $record = current($campusArray);
				    $campus_id = $record['campus_id'];
				    $listOfCampuses = $campus_id.'|';
				    
				    next($campusArray);
			  	 }  
			  	 $listOfCampuses = substr($listOfCampuses,0,-1);	// remove last '|'
				    
				 $this->isCampusAdmin[PrivilegeManager::ALL_EVENTS] = $listOfCampuses;
// 				 echo 'pre campus list = <pre>'.print_r($this->isCampusAdmin,true).'</pre>';
		    }
	    }
	    
//        echo '<br>super admin = '.$this->isSuperAdmin;
//        echo '<br>event admin = <pre>'.print_r($this->isEventAdmin,true).'</pre>';
//        echo '<br>campus admin = <pre>'.print_r($this->isCampusAdmin, true).'</pre>';
//        echo '<br>finance admin = <pre>'.print_r($this->isFinanceAdmin, true).'</pre>';
       
       $this->isStudent = true;	// all users have at least student-level access
       	        
	}
	/**
	 * function getAdminEvents
	 * <pre>
	 * returns simple-indexed array containing eventIDs belonging to non-super-admin
	 * </pre>
	 * @return [events[]]   return true for super-admin
	 */
	
	function getAdminEvents()
	{
		$events = array();
		
		if ($this->isSuperAdmin == true)
		{
			return PrivilegeManager::ALL_EVENTS;
		}
		
		if (count($this->isFinanceAdmin) > 0)
		{
		    if (isset($this->isFinanceAdmin[PrivilegeManager::ALL_EVENTS])&&($this->isFinanceAdmin[PrivilegeManager::ALL_EVENTS] == 1)) 
		    {
			    return PrivilegeManager::ALL_EVENTS;
		    }		
		    $financeEvents = array_keys($this->isFinanceAdmin);
// 		    echo "finance events = <pre>".print_r($financeEvents,true)."</pre>";
		    $events = array_merge( $events, $financeEvents );
// 		    return $events;
	    }
	    
		if (count($this->isEventAdmin) > 0)
		{
		    if (isset($this->isEventAdmin[PrivilegeManager::ALL_EVENTS])&&($this->isEventAdmin[PrivilegeManager::ALL_EVENTS] == 1)) 
		    {
			    return PrivilegeManager::ALL_EVENTS;
		    }		
		    $evAdminEvents = array_keys($this->isEventAdmin);
// 		    echo "evadmin events = <pre>".print_r($evAdminEvents,true)."</pre>";
			 $events = array_merge( $events, $evAdminEvents );
// 		    return $events;
	    }	    

		if (count($this->isCampusAdmin) > 0)
		{
		    if (isset($this->isCampusAdmin[PrivilegeManager::ALL_EVENTS]))	//&&($this->isCampusAdmin[PrivilegeManager::ALL_EVENTS] == PrivilegeManager::ALL_CAMPUSES)) 
		    {
			    return PrivilegeManager::ALL_EVENTS;
		    }		
		    $campusAdminEvents = array_keys($this->isCampusAdmin);
// 		    echo "campus events = <pre>".print_r($campusAdminEvents,true)."</pre>";
			 $events = array_merge( $events, $campusAdminEvents );		    
// 		    return $events;
	    }	
	    
	    return $events;  	    
    }
	    
    /**
	 * function isSuperAdmin
	 * <pre>
	 * returns if the thing is a super admin
	 * </pre>
	 * @return [BOOL]   return true for super-admin
	 */
    function isSuperAdmin()
    {
        return $this->isSuperAdmin;
    }
    
    /**
	 * function sFinanceAdmin
	 * <pre>
	 * determine if viewer is a finance admin for the given event 
	 * </pre>
	 * @return [boolean] 
	 */
    function isFinanceAdmin($eventID)
    {
	    if (isset($this->isFinanceAdmin[PrivilegeManager::ALL_EVENTS])&&($this->isFinanceAdmin[PrivilegeManager::ALL_EVENTS] == 1)) 
	    {
		    return true;
	    }
	    
	    if (isset($eventID)&&($eventID != ''))
	    {		    
	       	if (isset( $this->isFinanceAdmin[$eventID] ))
	       	{
		       	$isFinanceAdmin = $this->isFinanceAdmin[$eventID];
		       	switch ($isFinanceAdmin)
		       	{
			       	case 0:
			       		return false;
			       		break;
			       	case 1:
			       		return true;
			       		break;
			       	default:
			       		break;
	    		}
 			}
       }
       
       return false;	 
    }
    /**
	 * function isEventAdmin
	 * <pre>
	 * determine if viewer is an event admin for the given event 
	 * </pre>
	 * @return [boolean] 
	 */
    function isEventAdmin($eventID)
    {
	    if (isset($this->isEventAdmin[PrivilegeManager::ALL_EVENTS])&&($this->isEventAdmin[PrivilegeManager::ALL_EVENTS] == 1))
	    {
		    return true;
	    }	    	    
	    
	    if (isset($eventID)&&($eventID != ''))
	    {		    
       	if (isset( $this->isEventAdmin[$eventID] ))
       	{
	       	$isEventAdmin = $this->isEventAdmin[$eventID];
	       	switch ($isEventAdmin)
	       	{
		       	case 0:
		       		return false;
		       		break;
		       	case 1:
		       		return true;
		       		break;
		       	default:
		       		break;
    			}
 			}
       }
       
       return false;	       
    }
    /**
	 * function isCampusAdmin
	 * <pre>
	 * return whether viewer is a campus admin for given event and campus
	 * </pre>
	 * @return [boolean] 
	 */
    function isCampusAdmin($eventID, $campusID)
    {	  
 		if (isset($this->isCampusAdmin[PrivilegeManager::ALL_EVENTS])&&($this->isCampusAdmin[PrivilegeManager::ALL_EVENTS] == PrivilegeManager::ALL_CAMPUSES)) 
	    {
		    return true;
	    }	  
	    
	    if (isset($eventID)&&($eventID != ''))
	    {
	  		if (isset($this->isCampusAdmin[$eventID])&&($this->isCampusAdmin[$eventID] == PrivilegeManager::ALL_CAMPUSES)) 
		    {
			    return true;
		    }			    
		    
		    if ((isset($campusID))&&($campusID != ''))
	    	 {			    	 		    	 
		    	 	   		    
			    if ( isset($this->isCampusAdmin[$eventID]) )
			    {
			     	$campuses = $this->isCampusAdmin[$eventID];
			     	if ($campuses != '')
			     	{
					    $campusArray = explode('|',$campuses);
					    
					    if (in_array($campusID, $campusArray))
					    {
						    return true;
					    }
				    }
			    }
		    }
		    
		    // if no value was found, determine if the viewer is staff on some campus
// 		    $viewers = new RowManager_ViewerManager();
// 		    $viewers->set($this->viewer_id);
		    $access = new RowManager_AccessManager();
		    $access->setViewerID($this->viewer_id);	
		    $person = new RowManager_PersonManager();
		    $staff = new RowManager_StaffManager();
	   	 $staff->setIsActive('1');	    
		    $assign = new RowManager_AssignmentsManager();
		    $assign->setAssignmentStatus(CA_STAFF);
		    $campus = new RowManager_CampusManager();
		    $campus->setCampusID($campusID);
		    
		    $multiTables = new MultiTableManager();
		    $multiTables->addRowManager($access);
		    $multiTables->addRowManager($person, new JoinPair( $access->getJoinOnPersonID(), $person->getJoinOnPersonID()));
		    $multiTables->addRowManager($staff, new JoinPair ($person->getJoinOnPersonID(), $staff->getJoinOnPersonID()));
		    $multiTables->addRowManager($assign, new JoinPair ($assign->getJoinOnPersonID(), $person->getJoinOnPersonID()));
		    $multiTables->addRowManager($campus, new JoinPair ($assign->getJoinOnCampusID(), $campus->getJoinOnCampusID()));
		    
		    $campusList = $multiTables->getListIterator();
		    $campusArray = $campusList->getDataList();
		    
// 		    echo 'campus array for user: <pre>'.print_r($campusArray, true).'</pre><br>';
		    
		    // some campus was found, so viewer is admin for this campus (for all events)
		    if (isset($campusArray)&&(count($campusArray) > 0)) 
		    {
			    // store the viewer in the database as a campus id assigned to the current campus
			    /*** TODO: low priority because it is an optimization ***/
    	       	
			    return true;	
		    }	    
       }
       
       return false;	
    }
    /**
	 * function isBasicAdmin
	 * <pre>
	 * a simple check to determine if viewer is admin for *some* campus and *some* event
	 * </pre>
	 * @return [BOOL] 
	 */
    function isBasicAdmin($eventID='DEFAULT')
    {
	    // check if viewer is a super-admin
 		if (isset($this->isCampusAdmin[PrivilegeManager::ALL_EVENTS])&&($this->isCampusAdmin[PrivilegeManager::ALL_EVENTS] == PrivilegeManager::ALL_CAMPUSES)) 
	    {
		    return true;
	    }		    
	    
	    if ( isset($this->isCampusAdmin))
	    {
		    // if no event ID passed in (i.e. very basic check) or eventID is valid for this admin
		    if (($eventID=='DEFAULT')||(isset($this->isCampusAdmin[$eventID])) )
		    {
			    // *some* campus should have been stored in campus admin array
	// 		    echo "<pre>".print_r($this->isCampusAdmin[$evebt=true)."</pre>";
		     	if (count($this->isCampusAdmin) > 0) 
		     	{
			     	return true;
		     	}	     	
		    }
	    }
	    
    	     	// otherwise check if viewer is staff at some campus

// 		    $viewers = new RowManager_ViewerManager();
// 		    $viewers->set($this->viewer_id);
	    $access = new RowManager_AccessManager();
	    $access->setViewerID($this->viewer_id);	
	    $person = new RowManager_PersonManager();
	    $staff = new RowManager_StaffManager();
	    $staff->setIsActive('1');
	    $assign = new RowManager_AssignmentsManager();
		 $assign->setAssignmentStatus(CA_STAFF);
	    $campus = new RowManager_CampusManager();
	    
	    $multiTables = new MultiTableManager();
	    $multiTables->addRowManager($access);
	    $multiTables->addRowManager($person, new JoinPair( $access->getJoinOnPersonID(), $person->getJoinOnPersonID()));
	    $multiTables->addRowManager($staff, new JoinPair ($person->getJoinOnPersonID(), $staff->getJoinOnPersonID()));
	    $multiTables->addRowManager($assign, new JoinPair ($assign->getJoinOnPersonID(), $person->getJoinOnPersonID()));
	    $multiTables->addRowManager($campus, new JoinPair ($assign->getJoinOnCampusID(), $campus->getJoinOnCampusID()));
	    
	    $campusList = $multiTables->getListIterator();
	    $campusArray = $campusList->getDataList();
	    
// 		    echo 'campus array for user: <pre>'.print_r($campusArray, true).'</pre><br>';
	    
	    // some campus was found, so viewer is admin for this campus (for all events)
	    if (isset($campusArray)&&(count($campusArray) > 0)) 
	    {
		    // store the viewer in the database as a campus id assigned to the current campus
		    /*** TODO: low priority because it is an optimization ***/
 	       	
		    return true;	
	    }	
		    
		 return false;  
    } 	     	    
    /**
	 * function isBasicAdmin
	 * <pre>
	 * a simple check to determine if the object is a student
	 * </pre>
	 * @return [BOOL] 
	 */
    function isStudent()
    {
        return $this->isStudent;
    }
//     
//     function getPrivilegeLevel()
//     {
// 	    if ($this->isSuperAdmin == true)
// 	    {
// 	   	return PrivilegeManager::SUPER_ADMIN;
// 		 }
// 		 
// 		 if ($this->isFinanceAdmin == true)
// 		 {
// 	   	return PrivilegeManager::FINANCE_ADMIN;
// 		 }	
// 		 
// 		 if ($this->isEventAdmin == true)
// 		 {
// 	   	return PrivilegeManager::EVENT_ADMIN;
// 		 }	
// 		 
// 		 if ($this->isCampusAdmin == true)
// 		 {
// 	   	return PrivilegeManager::CAMPUS_ADMIN;
// 		 }	
// 		 
// 		 if ($this->isStudent == true)
// 		 {
// 	   	return PrivilegeManager::STUDENT;
// 		 }	
// 	 }		 		 		 		 



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
        	
}

?>