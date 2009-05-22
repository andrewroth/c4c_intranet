<?php
/**
 * @package cim_sch
 */
/**
 * class page_MySchedule
 * <pre>
 * Interface to edit your schedule.
 * </pre>
 * @author Calvin Jien & Russ Martin
 * Date:   31 Mar 2008
 */
// RAD Tools: Custom Page
class  page_MySchedule extends PageDisplay_FormProcessor {

	//CONSTANTS:

	/** The Multilingual Page Key for labels on this page */
	const MULTILINGUAL_PAGE_KEY = 'page_MySchedule';


	//VARIABLES:

	/** @var [OBJECT] The viewer object. */
	protected $viewer;

	/** @var [STRING] The path to this module's root directory. */
	protected $pathModuleRoot;

	// the person ID
	protected $personID;

	// the schedule ID
	protected $scheduleID;




	//CLASS CONSTRUCTOR
	//************************************************************************
	/**
	 * function __construct
	 * <pre>
	 * Initialize the object.
	 * </pre>
	 * @param $pathModuleRoot [STRING] The path to the module's root dir.
	 * @param $viewer [OBJECT] The viewer object.
	 * @return [void]
	 */
	function __construct($pathModuleRoot, $viewer, $formAction, $sortBy )
	{
		// NOTE: be sure to call the parent constructor before trying to
		//       use the ->formXXX arrays...
		$fieldList = '';//FormProcessor_ManageSuperAdmin::FORM_FIELDS;
		$fieldTypes = '';//FormProcessor_ManageSuperAdmin::FORM_FIELD_TYPES;
		$displayFields = '';//FormProcessor_ManageSuperAdmin::DISPLAY_FIELDS;
		parent::__construct( $formAction, '', '' );

		// initialzie the object values
		$this->pathModuleRoot = $pathModuleRoot;
		$this->viewer = $viewer;

		// now initialize the labels for this page
		// start by loading the default field labels for this Module
		$languageID = $viewer->getLanguageID();
		$seriesKey = modulecim_sch::MULTILINGUAL_SERIES_KEY;
		$pageKey = page_MySchedule::MULTILINGUAL_PAGE_KEY;
		$this->labels = new MultilingualManager( $languageID, $seriesKey, $pageKey );

		// init the person id
		// figure out the viewer's person ID
		$accessManager = new RowManager_AccessManager( );
		$accessManager->loadByViewerID( $this->viewer->getViewerID( ) );
		$this->personID = $accessManager->getPersonID();
		echo ("Your person ID is:".$this->personID."<br/>");

		// set the schedule id
		$scheduleManager = new RowManager_ScheduleManager();
		$scheduleManager->setPersonID($this->personID);
		$scheduleList = new ListIterator( $scheduleManager );
		$scheduleList->setFirst();
		$this->scheduleID =-1;
		if ( $scheduleList->moveNext() )
		{
			$schManager = $scheduleList->getCurrent( new RowManager_ScheduleManager() );
			$this->scheduleID = $schManager-> getScheduleID();
			echo "Schedule ID:".$this->scheduleID."<br/>";
		}else{
			echo "ERROR finding schedule id.<br/>";
		}

		 
	}

	function loadFromForm()
	{
		// echo "Hello World from loadFromForm!<br/>";
		return true;
	}

	function isDataValid()
	{
		// echo "Hello World from isDataValid!<br/>";
		return true;
	}

	function processData()
	{
		echo "Hello World from processData!<br/>";
		echo "<pre>".print_r( $_REQUEST, true)."</pre>";

		// delete all timeblocks for this person
		// since we want to overwrite their previous data
		$scheduleBlocksManager = new RowManager_ScheduleBlocksManager();
		$scheduleBlocksManager->setScheduleIDAsCondition($this->scheduleID);
		$scheduleBlocksManager->deleteEntry();

		// delete all group association of this person
		// since we want to overwrite their previous data
		$groupAssociationManager = new RowManager_GroupAssociationManager();
		$groupAssociationManager->setPersonIDAsCondition($this->personID);
		$groupAssociationManager->deleteEntry();

		// find out the scheduleID for this person
		echo "the scheduleID is [".$this->scheduleID."]<br/>";


		// find all of the busy schedule blocks that were submitted
		foreach ( $_REQUEST as $key=>$value )
		{
			if ( substr( $key, 0, 3) == "TB_" )
			{
				// we know this is a timeblock
				echo "Found a timeblock [".$value."]<br/>";

				// write a binary value of 1 for all the blocks this person is busy
				$scheduleBlocksManager = new RowManager_ScheduleBlocksManager();
				$scheduleBlocksManager->setScheduleID($this->scheduleID);
				$scheduleBlocksManager->setTimeBlock($value);
				$scheduleBlocksManager->createNewEntry();
			}
			if ( substr( $key, 0, 2) == "G_" )
			{
				// we know this is a timeblock
				echo "Found a group [".$value."]<br/>";

				// write a binary value of 1 for all the blocks this person is busy
				$groupAssociationManager = new RowManager_GroupAssociationManager();
				$groupAssociationManager->setPersonID($this->personID);
				$groupAssociationManager->setGroupID($value);
				$groupAssociationManager->createNewEntry();

			}

		}






		return;
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
	}



	//************************************************************************
	/**
	 * function getHTML
	 * <pre>
	 * This method returns the HTML data generated by this object.
	 * </pre>
	 * @return [STRING] HTML Display data.
	 */
	function getHTML()
	{

		// Uncomment the following line if you want to create a template
		// tailored for this page:
		$path = $this->pathModuleRoot.'templates/';
		// Otherwise use the standard Templates for the site:
		//$path = SITE_PATH_TEMPLATES;


		/*
		 * Update any label tags ...
		 */
		// example:
		// $name = $user->getName();
		// $this->labels->setLabelTag( '[Title]', '[userName]', $name);


		// NOTE:  this parent method prepares the $this->template with the
		// common Display data.
		$this->prepareTemplate($path);

		// uncomment this line if you are creating a template for this page
		$templateName = 'page_MySchedule.php';
		// otherwise use the generic site template
		//$templateName = '';
		$this->displayGroups();
		$this->getGroupData();
		$this->displayTimetable();
		$this->getScheduleData();
		//$this->getScheduleData();
		return $this->template->fetch( $templateName );

	}
	function displayGroups(){
		// This array get passed back to the template multiple time
		$groupCollectionArray = array();


		$multiTableManager = new MultiTableManager();
		$groupManager = new RowManager_GroupManager();
		$superAdminManager = new RowManager_PermissionsSuperAdminManager();

		//SUPER ADMIN

		//Check if user's Viewer_id is in the PermissionSuperAdmin table
		//If the user is a super admin then show all gorups per campus including public groups
		if ( $superAdminManager->loadByViewerID( $this->viewer->getViewerID( ) ) )
		{
			// the viewer is a super admin
			echo "ViewerID[".$this->viewer->getViewerID( )."] is a super admin<br/>";
			$campusManager = new RowManager_CampusManager();
			
			
			$campusArray = array();
			$this->listIterator = $campusManager->getListIterator();
			$this->listIterator->setFirst();
			while( $this->listIterator->moveNext() )
			{
				$group = $this->listIterator->getCurrent(new RowManager_CampusManager());
				$campusArray[] = $group->getCampusID();
			}
			//echo "<pre>".print_r($campusArray)."</pre>";
			
		foreach( $campusArray as $key=>$campusID )
			{

				$campusManager = new RowManager_CampusManager( $campusID );
				$campusGroupManager = new RowManager_CampusGroupManager();
				$campusGroupManager->setCampusID($campusID);
				$groupManager = new RowManager_GroupManager();
				
				$multiTableManager = new MultiTableManager();
				$multiTableManager->addRowManager($groupManager);
				$multiTableManager->addRowManager( $campusGroupManager, new JoinPair( $campusGroupManager->getJoinOnGroupID(), $groupManager->getJoinOnGroupID() , JOIN_TYPE_RIGHT) );
				$multiTableManager->addRowManager( $campusManager, new JoinPair( $campusManager->getJoinOnCampusID(), $campusGroupManager->getJoinOnCampusID() , JOIN_TYPE_RIGHT) );
				
				//Go through the result and save all the groups of that campus to an array
				$campusGroupArray = array();
				$this->listIterator = $multiTableManager->getListIterator();
				$this->listIterator->setFirst();
				while( $this->listIterator->moveNext() )
				{
					$group = $this->listIterator->getCurrent(new RowManager_CampusGroupManager());
					$campusGroupArray[] = $group;
				}
					
				//set the campusID and CampusDesc for the $campusGroupArray
				$groupCollectionArray[] = new GroupCollection( $campusManager->getShortDesc(), $campusID, $campusGroupArray );
			}
			
			//TODO - not a correct join
			//TODO - get all campus ID and groups
			//TODO - get all public groups
		}
			
		else
		{
			//STAFF OR STUDENT
			//If the user is a student or staff then they should have campus assignmnets in cim_hrdb_assignment
			//Find all the campuses and save them in the $campusAssigment array
			$campusAssignments = array();
			$statusArray = array();
			$statusArray[] = CA_STAFF;
			$statusArray[] = CA_STUDENT;
			foreach( $statusArray as $key=>$statusID )
			{
				// filter from the cim_hrdb_assignment table
				$assignmentManager = new RowManager_AssignmentsManager();
				$assignmentManager->setPersonID( $this->personID );
				$assignmentManager->setAssignmentStatus( $statusID );
				$assignmentList = new ListIterator( $assignmentManager );
				$assignmentList->setFirst();
				while ( $assignmentList->moveNext() )
				{
					$assManager = $assignmentList->getCurrent( new RowManager_AssignmentsManager() );
					$campusAssignments[] = $assManager->getCampusID();
				}

			}

			//CAMPUS ADMIN
			//some users can be admin to a campus that they are neither a student or staff for
			//Check cim_sch_permissionsCampusAdmin for the viewer id of the user
			//for each found save the campusID in the $campusAssignments table

			$permissionsCampusAdmin = new RowManager_PermissionsCampusAdminManager();
			$permissionsCampusAdmin->setViewerID($this->viewer->getViewerID( ));
			$campusAdminList = new ListIterator( $permissionsCampusAdmin );
			$campusAdminList->setFirst();
			while( $campusAdminList->moveNext() )
			{
				$permCampus = $campusAdminList->getCurrent( new RowManager_PermissionsCampusAdminManager() );

				//for each campuses found, store in array
				$campusAssignments[] = $permCampus->getCampusID();

			}

			//remove any duplicate campus ID in the array
			$campusAssignments = array_unique($campusAssignments);

			 
			//After collection all the campusIDs lets go through each campusID and get the groups
			//for each campusID find all the groups in $campusGroupManager table
			//Save the groups in an array taged with the campusID, Shortdesc

			foreach( $campusAssignments as $key=>$campusID )
			{
				//Set the campusID so we can get the shortDesc at the end
				$campusManager = new RowManager_CampusManager( $campusID );

				//Join cim_sch_Group and cim_sch_campusgroup
				$campusGroupManager = new RowManager_CampusGroupManager();
				$campusGroupManager->setCampusID( $campusID );
				$multiTableManager = new MultiTableManager();
				$multiTableManager->addRowManager($campusGroupManager);
				$groupManager = new RowManager_GroupManager();
				$multiTableManager->addRowManager( $groupManager, new JoinPair( $campusGroupManager->getJoinOnGroupID(), $groupManager->getJoinOnGroupID() ) );

				//Go through the result and save all the groups of that campus to an array
				$campusGroupArray = array();
				$this->listIterator = $multiTableManager->getListIterator();
				$this->listIterator->setFirst();
				while( $this->listIterator->moveNext() )
				{
					$group = $this->listIterator->getCurrent(new RowManager_GroupManager());
					$campusGroupArray[] = $group;
				}
					
				//set the campusID and CampusDesc for the $campusGroupArray
				$groupCollectionArray[] = new GroupCollection( $campusManager->getShortDesc(), $campusID, $campusGroupArray );
			}
			 
			 
			//GROUP ADMIN
			//The user might be a group admin so we should display that group as well
			//We have to find the which groups the user is admin for in cim_sch_permissionsGroupAdmin
			//For each of these gorups, look in cim_sch_campusGroup table and find and store the campusID in an array
			//Use the campusID array and for each campusID and only save the gorups with the same campusID
			//Save all the gorups in the $gorupCollectionArray

			//Set a fillter for only show results if its the user's ViewerID
			$permissionsGroupAdminManager = new RowManager_PermissionsGroupAdminManager();
			$permissionsGroupAdminManager->setViewerID($this->viewer->getViewerID());

			//Set Fillter to only show results that are a campus group
			$groupManager = new RowManager_GroupManager();
			$groupManager->setGroupTypeID(1);

			//Make the join of tables cim_sch_group, cim_sch_campusGroup, cim_sch_permissionsGroupAdmin
			$campusGroupManager = new RowManager_CampusGroupManager();
			$multiTableManager = new MultiTableManager();
			$multiTableManager->addRowManager( $groupManager );
			$multiTableManager->addRowManager( $campusGroupManager, new JoinPair( $campusGroupManager->getJoinOnGroupID(), $groupManager->getJoinOnGroupID(), JOIN_TYPE_RIGHT ) );
			$multiTableManager->addRowManager($permissionsGroupAdminManager, new JoinPair ($permissionsGroupAdminManager->getJoinOnGroupID(),$groupManager->getJoinOnGroupID(),JOIN_TYPE_RIGHT ));

			//Go through the results and save the campusID of that group
			$campusGroupArray = array();
			$this->listIterator = $multiTableManager->getListIterator();
			$this->listIterator->setFirst();
			while( $this->listIterator->moveNext() )
			{
				$group = $this->listIterator->getCurrent(new RowManager_CampusGroupManager());
				$campusGroupArray[] = $group->getCampusID();
			}


			//For each campus found, go through the result again and fillter by campusID
			//Only the groups of the same campusID are saved together
			foreach( $campusGroupArray as $key=>$campusID )
			{
				 
				//This allows us to get the campus shortDesc at the end
				$campusManager = new RowManager_CampusManager($campusID);

				//same code as before to join the tables
				$permissionsGroupAdminManager = new RowManager_PermissionsGroupAdminManager();
				$permissionsGroupAdminManager->setViewerID($this->viewer->getViewerID());
				$campusGroupManager = new RowManager_CampusGroupManager();
				$campusGroupManager->setCampusID($campusID);
				$groupManager = new RowManager_GroupManager();
				$groupManager->setGroupTypeID(1);
				$multiTableManager = new MultiTableManager();
				$multiTableManager->addRowManager( $groupManager );
				$multiTableManager->addRowManager( $campusGroupManager, new JoinPair( $campusGroupManager->getJoinOnGroupID(), $groupManager->getJoinOnGroupID(), JOIN_TYPE_RIGHT ) );
				$multiTableManager->addRowManager($permissionsGroupAdminManager, new JoinPair ($permissionsGroupAdminManager->getJoinOnGroupID(),$groupManager->getJoinOnGroupID(),JOIN_TYPE_RIGHT ));

				//go through the results and save the gorups
				$campusGroupArray = array();
				$this->listIterator = $multiTableManager->getListIterator();
				$this->listIterator->setFirst();
				while( $this->listIterator->moveNext() )
				{
					$group = $this->listIterator->getCurrent(new RowManager_GroupManager());
					$campusGroupArray[] = $group;
				}

				//set the campusID and CampusDesc for the $campusGroupArray
				$groupCollectionArray[] = new GroupCollection( $campusManager->getShortDesc(), $campusID, $campusGroupArray );
			}
			 
			 
			 

			//PUBLIC Groups
			//Show all groups in cim_sch_group with the groupTypeID of 2 (public)

			//The public gorup does not have a campus assign
			$campusID = 0;

			//The public gorup desc is public, this is shown in the template
			$publicGroupDesc = "Public";

			//Set the public gorup fillter
			$thisIsAPublicGroup = 2;

			$groupManager = new RowManager_GroupManager();
			$groupManager->setGroupTypeID($thisIsAPublicGroup);

			//go through the results and save the groups
			$groupArray = array();
			$this->listIterator = $groupManager->getListIterator();
			$this->listIterator->setFirst();
			while( $this->listIterator->moveNext() )
			{
				$group = $this->listIterator->getCurrent(new RowManager_GroupManager());
				$groupArray[] = $group;
			}

			//save the public groups to the array
			$groupCollectionArray[] = new GroupCollection( $publicGroupDesc, $campusID, $groupArray );
				
		}//END OF IF



		//KSL

		//NORMAL

		/*
		 $campusAssignments = array();

		 $statusArray = array();
		 $statusArray[] = CA_STAFF;
		 $statusArray[] = CA_STUDENT;
		 foreach( $statusArray as $key=>$statusID )
		 {
		 // filter from the cim_hrdb_assignment table
		 $assignmentManager = new RowManager_AssignmentsManager();
		 $assignmentManager->setPersonID( $this->personID );
		 $assignmentManager->setAssignmentStatus( $statusID );

		  

		 $assignmentList = new ListIterator( $assignmentManager );
		 $assignmentList->setFirst();
		 while ( $assignmentList->moveNext() )
		 {
		 $assManager = $assignmentList->getCurrent( new RowManager_AssignmentsManager() );
		 $campusAssignments[] = $assManager->getCampusID();
		 }

		 }
		 // echo "<pre>".print_r($campusAssignments, true)."</pre>";

		 // STEP 2:  get the appropriate groups
		 foreach( $campusAssignments as $key=>$campusID )
		 {
		 $campusManager = new RowManager_CampusManager( $campusID );

		 $campusGroupManager = new RowManager_CampusGroupManager();
		 $campusGroupManager->setCampusID( $campusID );

		 $multiTableManager = new MultiTableManager();
		 $multiTableManager->addRowManager($campusGroupManager);
		  
		 $groupManager = new RowManager_GroupManager();
		 $multiTableManager->addRowManager( $groupManager, new JoinPair( $campusGroupManager->getJoinOnGroupID(), $groupManager->getJoinOnGroupID() ) );

		 $campusGroupArray = array();
		 $this->listIterator = $multiTableManager->getListIterator();
		 $this->listIterator->setFirst();
		 while( $this->listIterator->moveNext() )
		 {
		 $group = $this->listIterator->getCurrent(new RowManager_GroupManager());
		 $campusGroupArray[] = $group;
		 }

		 $groupCollectionArray[] = new GroupCollection( $campusManager->getShortDesc(), $campusID, $campusGroupArray );
		 }*/

		return $this->template->set('groupCollectionArray', $groupCollectionArray);
	}

	function getGroupData(){

		$groupAssociationManager = new RowManager_GroupAssociationManager();
		$groupAssociationManager->setPersonID($this->personID);
		$groupAssociationArray = array();

		//Go through the row returned
		$groupList = new ListIterator( $groupAssociationManager );
		$groupList->setFirst();
		$timeBlock = -1;
		while ( $groupList->moveNext() )
		{
			//get the time block in that row
			$groupsManager = $groupList->getCurrent( new RowManager_GroupAssociationManager() );
			 
			//save the timeblock to the array and keep looping to get all of them
			$groupAssociationArray[] = $groupsManager->getGroups();

		}

		return $this->template->set('groupAssociationArray', $groupAssociationArray);

	}


	function displayTimetable(){
		//compute all the values required for the timetable
		//This is for an empty timetable


		//The time/date shown on the side/top of the timetable are stored here.
		$weekDaysNameArray = array("M", "T", "W", "T", "F");
		$timesArray = array();
		$dbTimesBlocks = array();
			
		//This is the array that get pass to the template.
		//All calculation are stored in this array. More information are saved to this array later on.
		$timeTableBlocks = array ("weekDaysName"=>$weekDaysNameArray);

		//SCHEDULE SETTINGS----------------
		$scheduleStartTime = 7; 	//What time do you want the scheduler to start at?
		$scheduleEndTime = 21; 		//What time do you want the scheduler to end at?
		$afterNoonCheck = 13; 		//This should not be changed. This is for formatting
		//times from 24hour to 12hours time
		$halfDayMark = 12; 			//This should not be changed. This is reqired in-order to
		//show the apropreate 'am' or 'pm' tags next to the time.
		$showHalfHourBlocks = true; //Not configured yet
		//---------------------------------

		for ($hour24 = $scheduleStartTime; $hour24 <= $scheduleEndTime; $hour24++) {
				
			//For every hour create two half hour blocks
			//EX: 1:00pm  creates 1:00-1:30 and 1:30-2:00
				
			for ($half_hour = 1; $half_hour <= 2; $half_hour++) {
				if ($hour24 < $afterNoonCheck)
				$hour12 = $hour24;
				else
				$hour12 = $hour24 - $halfDayMark;

				if ($half_hour == 1) {
					$minutes = 0;
					$min_str = "00";
				} else {
					$minutes = 30;
					$min_str = "30";
				}

				if ($hour24 < $halfDayMark)
				$ampm = "am";
				else
				$ampm = "pm";

				//Each time blocks are stored in this array (Human format)
				$timesArray[] = "$hour12:".$min_str.$ampm;

				//Each time blocks are stored in this array (Database format)
				for($day =2; $day<=6; $day++){
					$dbTimesBlocks[] = ($hour24 * 1000) + ($minutes * 10) + $day;
				}
			}
				
		}
		//The populated timesArray is saved to the timeTableBlocks array.
		$timeTableBlocks['times'] = $timesArray;
		$timeTableBlocks['dbtimes'] = $dbTimesBlocks;
			
		//The timeTableBlocks array is passed to the template.
		$this->template->set('timeTableBlocks', $timeTableBlocks);
	}

	//Given the scheduleID, look in the database and find all timeblocks associated to the schedule ID
	//save results in $timeBlocksArray and pass it to the template
	function getScheduleData(){

		//The array to be send
		$timeBlocksArray = array();

		if ( $this->scheduleID < 1 )
		{
			print ("No Schedule found for your ID");
			$timeBlocksArray = null;
		}
		else
		{
			//Returns a row of the database with the scheduleID
			$scheduleBlocksManager = new RowManager_ScheduleBlocksManager();
			$scheduleBlocksManager->setScheduleID($this->scheduleID);

			//Go through the row returned
			$scheduleBlocksList = new ListIterator( $scheduleBlocksManager );
			$scheduleBlocksList->setFirst();
			$timeBlock = -1;
			while ( $scheduleBlocksList->moveNext() )
			{
				//get the time block in that row
				$blocksManager = $scheduleBlocksList->getCurrent( new RowManager_ScheduleBlocksManager() );
				$timeBlock = $blocksManager->getTimeBlock();
				 
				//save the timeblock to the array and keep looping to get all of them
				$timeBlocksArray[] = $timeBlock;

			}
		}
		//Pass the data to the template for display
		return $this->template->set('timeBlocksArray', $timeBlocksArray);

	}
}


?>