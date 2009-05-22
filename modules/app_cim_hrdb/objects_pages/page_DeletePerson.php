<?php
/**
 * @package cim_hrdb
 */ 
/**
 * class page_DeletePerson 
 * <pre> 
 * Delete a Person from the database.
 * </pre>
 * @author CIM Team
 * Date:   03 Apr 2006
 */
// RAD Tools : Delete Confirmation Style
class  page_DeletePerson extends PageDisplay_DeleteConf {

	//CONSTANTS:
	
	/** dummy fields... **/
	 const FORM_FIELDS = '';	//'ccreceipt_sequencenum|T|,ccreceipt_authcode|T|,ccreceipt_responsecode|T|,ccreceipt_message|T|,ccreceipt_moddate|T|';

	/** dummy field types... **/
	 const FORM_FIELD_TYPES = '';	//'-,-,-,-,-,-,-,-,-';//'textbox,droplist|20,textbox|20,textbox|6,textbox|7,hidden,textbox|10,-,hidden'; 
    
    /** The Multilingual Page Key for labels on this page */
    const MULTILINGUAL_PAGE_KEY = 'page_DeletePerson';
    
    /** a CSV string containing the fields of cim_hrdb_person (except the local contact info since we shouldn't use old local data)**/
    const PERSON_RECORD_FIELDS = 'person_id,person_fname,person_lname,person_phone,person_email,person_addr,person_city,province_id,person_pc,gender_id';//,person_local_phone,person_local_addr,person_local_city,person_local_pc,person_local_province_id';
 
    /** a CSV string containing the fields of cim_hrdb_emerg **/
    const EMERG_RECORD_FIELDS = 'emerg_id,person_id,emerg_passportNum,emerg_passportOrigin,emerg_passportExpiry,emerg_contactName,emerg_contactRship,emerg_contactHome,emerg_contactWork,emerg_contactMobile,emerg_contactEmail,emerg_birthdate,emerg_medicalNotes';
       
    /** a CSV string containing the fields of cim_hrdb_assignment **/
    const ASSIGNMENT_RECORD_FIELDS = 'assignment_id,person_id,campus_id,assignmentstatus_id';
    
    
    /** The list of fields to be displayed */
    const DISPLAY_FIELDS = 'person_id,person_fname,person_lname,person_phone,person_email,person_addr,person_city,province_id,person_pc,gender_id';
       

	//VARIABLES:
	
	/** @var [OBJECT] The viewer object. */
	protected $viewer;
	
    /** @var [STRING] The path to this module's root directory. */
	protected $pathModuleRoot;
	
	/** @var [INTEGER] The Initialization value for the itemManager. */
	protected $person_id;
	

	/** @var [OBJECT] the following are the RowManagers for all the tables accessed: **/
	protected $person_manager;
// 	protected $access_manager;
// 	protected $person_dg_manager;
// 	protected $schedule_manager;
// 	protected $person_year_manager;
// 	protected $emerg_contact_manager;
// 	protected $hrdb_admin_manager;
// 	protected $campus_assign_manager;
// 	protected $registration_manager;
// 	protected $staff_manager;

	/** @var [STRING] Data record person first name filter */
	protected $filter_fname;	
	
	/** @var [STRING] Data record person last name filter */
	protected $filter_lname;		

	/** @var [STRING] Data record person e-mail filter */
	protected $filter_email;	

	//CLASS CONSTRUCTOR
	//************************************************************************
	/**
	 * function __construct
	 * <pre>
	 * Initialize the object.
	 * </pre>
	 * @param $pathModuleRoot [STRING] The path to the module's root dir.
	 * @param $viewer [OBJECT] The viewer object.
	 * @param $formAction [STRING] The action on a form submit
     * @param $managerInit [INTEGER] Initialization value for the itemManager.
	 * @return [void]
	 */
    function __construct($pathModuleRoot, $viewer, $formAction, $person_id='' ) 
    {
        $fieldList = page_DeletePerson::DISPLAY_FIELDS;
        parent::__construct( $formAction, $fieldList );
        
        // initialzie the object values
        $this->pathModuleRoot = $pathModuleRoot;
        $this->viewer = $viewer;

        $this->person_id = $person_id;
        
                
//         // initialize data filters
//         $this->filter_fname = $filter_fname;
//         $this->filter_lname = $filter_lname;
//         $this->filter_email = $filter_email;
        
        if (isset($max_exec_time))
        {
	        set_time_limit($max_exec_time);
// 	        echo "Time limit set to ".$max_exec_time." seconds!";
        }
        
        // create the item Manager to display
        $this->itemManager = new RowManager_PersonManager( $person_id );
        $this->person_manager = new RowManager_PersonManager();
        
        // now initialize the labels for this page
        // start by loading the default field labels for this Module
        $languageID = $viewer->getLanguageID();
        $seriesKey = modulecim_hrdb::MULTILINGUAL_SERIES_KEY;
        $pageKey = modulecim_hrdb::MULTILINGUAL_PAGE_FIELDS;
        $this->labels = new MultilingualManager( $languageID, $seriesKey, $pageKey );
        
        // then load the page specific labels for this page
        $pageKey = page_DeletePerson::MULTILINGUAL_PAGE_KEY;
        $this->labels->loadPageLabels( $pageKey );
        
        // add Site YES/NO labels
        $this->labels->setSeriesKey( SITE_LABEL_SERIES_SITE );
        $this->labels->loadPageLabels( SITE_LABEL_PAGE_LIST_YESNO );
         
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
	 * function processData
	 * <pre>
	 * Processes the data for this form.
	 * </pre>
	 * @return [void]
	 */
    function processData() 
    {
	    // initialize the variable storing process report data
	    $reportDataDump = '';
	    $BR = '<BR>';
	    $HR = '<HR>';
		
		if ($this->shouldDelete) {
			// TODO: delete all the dependent data records (otherwise FK constraints will *NOT* allow deletion)
			// see app_cim_reg/objects_pages/page_ConfirmDeleteRegistration.php
			
	       	$savedPersonID = $this->person_id;	// the ID of the person whose records are to be deleted


// 				$reportDataDump .= 'Unique person record tuple:'.$BR.'  First Name = '.$person_fname.', Last Name = '.$person_lname.', E-mail = '.$person_email.$BR.$BR;
//  				echo "PERSON NAME: ".$person_fname." ".$person_lname;												
//  			echo "PERSON: <pre>".print_r($person,true)."</pre>"; 

				// search for a particular person to see if duplicate records exist
//				$indiv_person_manager = new RowManager_PersonManager();
			   $indiv_person_manager = new MultiTableManager();
        		$indiv_person_manager->addRowManager($this->person_manager);
// 				$indiv_person_manager->setFirstName(addslashes($person_fname));	// use addslashes to escape special chars in string
// 				$indiv_person_manager->setLastName(addslashes($person_lname));
// 				$indiv_person_manager->setEmail(addslashes($person_email));
// 				$indiv_person_manager->setSortOrder( 'person_id' );
// 				$indiv_person_manager->setAscDesc( 'DESC' ); 	// sort by descending person IDs

			  $indiv_person_manager->addSearchCondition( "person_id = '".$this->person_id."'" );
	        
	                // use GROUP BY to easily enforce distinct triplets of (person_fname, person_lname, person_email)
			  $groupBy = "person_fname,person_lname,person_email";
	        $indiv_person_manager->setGroupBy($groupBy);	
				
			  $indivData = $indiv_person_manager->getListIterator(); 
	        $indivDataArray = $indivData->getDataList();

// 				  echo "    INDIV COUNT: ".count($indivDataArray)."<br><br>";	        
//   	        echo "INDIV RECORDS: <pre>".print_r($indivDataArray,true)."</pre>"; 

        		
        		$person_ids_list = '';
	        
	        //return all the person's data into array (key = person_id) of arrays (and store total data stored?)
	        
	        if (isset($indivDataArray))
	        {
		     		if (count($indivDataArray) == 0)
	        		{
		        		echo "ERROR: person was found earlier and now NO records are found!";
	        		}
	        		else if (count($indivDataArray) == 1)
	        		{
// 		        		 echo "GREAT! This person only has one record.";
		        		reset($indivDataArray);
		        		$record = current($indivDataArray);
		        		$savedPersonID = $record['person_id'];
		        		$person_ids_list = $savedPersonID;
		        		
		        		$reportDataDump .= 'Unique person id found for tuple: '.$savedPersonID.$BR.$BR;
	        		}
	        		else if (count($indivDataArray) > 1)	//if more than 1 record for the current person then:
	        		{
		        		// get the person IDs for this individual
		        		reset($indivDataArray);
		        		foreach(array_keys($indivDataArray) as $l)
        				{
		        			$record = current($indivDataArray);		        		
		        		   
		        			$person_ids_list .= $record['person_id'];
		        			$person_ids_list .= ',';
		        			
		        			next($indivDataArray);
	        			}
	        			$person_ids_list = substr($person_ids_list, 0, -1);	// remove final comma
	        			$reportDataDump .= 'Multiple person ids found for tuple: '.$person_ids_list.$BR.$BR;
        			}
        			
        			// Search for duplicate person-related entries - for 1 or more person_ids found for current person
        			if ($person_ids_list != '')
        			{
	        			
// 	        			echo "<br> person ids list: ".$person_ids_list."<br>";
// 	        			$person_ids_array = explode($person_ids_list,',');
		        			
	        			// check access table using all the found person IDs - retrieve viewer ids with person id as key
	        			$foundViewerIDs = $this->getAccessRecords($person_ids_list);	// can safely assume array ISSET
	        			
//  	        			echo 'found viewer ids= <pre>'.print_r($foundViewerIDs,true).'</pre>';

	        			
	        			/** IF 0 access table records were found: **/
	        			if (count($foundViewerIDs) == 0)
	        			{	   
		        			// TODO?: notify admin that this/these person record(s) require a viewer account
		        			     			
							// Store the active (latest) person_id in special variable
							reset($indivDataArray);
							$savedPersonID = key($indivDataArray);	// recall that person_ids are sorted in descending order
						}
						else if (count($foundViewerIDs) >= 1)	/** IF 1 (or more) access table records were found: **/
						{		
							/** store the active (access table) person_id in special variable	**/
							reset($foundViewerIDs);

							$personIDs = explode(',' , $person_ids_list);
							$savedPersonID = 	current($personIDs);		//current($foundViewerIDs);
							$reportDataDump .= 'Person ID of the record(s) to delete: '.$savedPersonID.' (associated with the most recent person record)'.$BR.$BR;

// 							echo 'latest viewer ids = <pre>'.print_r($foundViewerIDs,true).'</pre>';
// 							echo 'saved person ID = '.$savedPersonID;

							$reportDataDump .= 'Changes made to <b>cim_hrdb_access table</b>: '.$BR;							
							
							/*** update the access table records to only use latest person ID **/						
							foreach(array_values($foundViewerIDs) as $person_id)
        					{	
	        					$viewer_id = key($foundViewerIDs);
// 	        					echo 'viewer_id = '.$viewer_id;
	        					
	        					// only delete from the access table record if it needs a different person_id	
								if ($person_id == $savedPersonID)
								{	        					
		        					// get access ID(s) for the record to change				
									$accessManager = new RowManager_AccessManager();
									$accessManager->setViewerID($viewer_id);
									$accessManager->setPersonID(current($foundViewerIDs));	// or just use $person_id
									
							 		$accessData = $accessManager->getListIterator(); 
		     					   $accessDataArray = $accessData->getDataList();	
		     					   
// 		     					   echo 'access data array = <pre>'.print_r($accessDataArray,true).'</pre>';
		     					   
		     					   reset($accessDataArray);	// deal with the unlikely case that we have redundant viewerID-personID records
		     					   foreach (array_keys($accessDataArray) as $key)
		     					   {
		     					   	$record = current($accessDataArray);	
		     					   	$accessID = $record['access_id'];		
										
										$reportDataDump .= 'Deleting access table entries linked to person_id = '.$person_id;
										$accessDeleter = new RowManager_AccessManager($accessID);
										$accessDeleter->deleteEntry();	
	
		 			        			next($accessDataArray);
	 			        			}
 			        			}
 			        			
 			        			$id = next($foundViewerIDs);	// person_id
	        					if ($id === FALSE)
	        					{
		        					break;	// no valid data found so break out of the loop
	        					}
							}
 						}	/** <end> access table entry deletion **/
						
						        		
		        		$baseRecord = $indivDataArray[$savedPersonID];
// 		        		echo "<br>base record: <pre>".print_r($baseRecord,true)."</pre><br>";
// 		        		$flagArray = $this->checkPersonRecordFields($baseRecord);
// 		        		echo "<br>flag array: <pre>".print_r($flagArray,true)."</pre><br>";

					/** NOTE: SKIP PERSON RECORD UPDATE SINCE WE ARE JUST DELETING A RECORD, *NOT* UPDATING **/
	
					
					/** Go through various tables and clean out or update records related to the current person **/
					
					// Update and clean-up the Person-Year table (cim_hrdb_person_year)
					// Step 1)  Find the information stored for the active person_id
					$personYearArray = array();
					
					$person_year_manager = new RowManager_PersonYearManager();
					$person_year_manager->setPersonID($savedPersonID);
					$person_year_manager->setSortOrder('personyear_id');
					$person_year_manager->setAscDesc( 'DESC' ); 	// sort by descending personyear IDs
					
					
// 					echo "<BR>".$savedPersonID.",";

					$personYearData = $person_year_manager->getListIterator();
	    			$person_year_array = $personYearData->getDataList();	
	        		reset($person_year_array);		       		
	        		foreach(array_keys($person_year_array) as $key)
     				{
	        			$record = current($person_year_array);	
	        			
	        			$person_year_id = $record['personyear_id'];
	        			$year_id = $record['year_id'];
	        			
	        			$personYearArray[$person_year_id] = $year_id;	// store person_id associated with the person_year_id
	        			
	        			next($person_year_array);
        			}	   
        			
           			
//         			if (count($person_year_array) > 0)
//         			{
// 	        			echo "<br>Years for active person_id ".$savedPersonID.": <pre>".print_r($personYearArray,true)."</pre><br>"; 
//      				}		
     				
//      				echo "Person IDs list: ".$person_ids_list."<br>";

					$reportDataDump .= 'Changes made to <b>cim_hrdb_person_year table</b>: '.$BR;

					// remove all person-year records (associated with active person id)
					if (count($personYearArray) >= 1)
					{
						reset($personYearArray);
						$person_year_id = key($personYearArray);
// 						$reportDataDump .= 'Saving the first person year record associated with person ID '.$savedPersonID.$BR.$BR;
// 						next($personYearArray);	// keep the first record (most recent personyear_id
						
		        		foreach(array_keys($personYearArray) as $m)
	     				{
		        			$record = current($personYearArray);
		        			
		        			$personYearID = key($personYearArray);
		        			
 		        			$reportDataDump .= "REMOVE person-year entry for person_id = ".$savedPersonID." using key = ".key($personYearArray).$BR.$BR;
		        			if ((isset($personYearID))&&($personYearID != '')&&($personYearID > 0))
		        			{
				        		$reportDataDump .= 'Deleting person year record having year ID '.$record.$BR.$BR;
			        			$personYearUpdater = new RowManager_PersonYearManager($personYearID);	
	 		        			$personYearUpdater->deleteEntry();		
 		        			}						
		        			
		        			next($personYearArray);
	        			}							
						
					}
					
	
					// Update the Emergency Contact table (cim_hrdb_emerg)
					// Step 1)  Find the information stored for the active person_id
					$emergInfoArray = array();
					
					$emerg_info_manager = new RowManager_EmergencyInfoManager();
					$emerg_info_manager->setPersonID($savedPersonID);
					$emerg_info_manager->setSortOrder( 'emerg_id' );
		 			$emerg_info_manager->setAscDesc( 'DESC' ); 	// sort by descending emerg IDs
					
//  					echo "<BR>".$savedPersonID.",";

					$emergInfoData = $emerg_info_manager->getListIterator();
	    			$emerg_info_array = $emergInfoData->getDataList();	
	        		reset($emerg_info_array);		       		
	        		foreach(array_keys($emerg_info_array) as $l)
     				{
	        			$record = current($emerg_info_array);	
	        			
	        			$emerg_id = $record['emerg_id'];
	        			$emerg_info = array();
	        			
	        			
			      	$fields = page_DeletePerson::EMERG_RECORD_FIELDS;
			     		$fieldsArray = explode(",",$fields);	
			        		
			     		// store the emergency info values in an array
			     		reset($fieldsArray);
			     		foreach(array_keys($fieldsArray) as $k)
						{
			     			$fieldName = current($fieldsArray);	
			     			
			        		$emerg_info[$fieldName] = $record[$fieldName];		        				       		
			     			
			     			next($fieldsArray);
			  			}	        			
	        			
	        			// store array of record values in array with emerg_id as key
	        			$emergInfoArray[$emerg_id] = $emerg_info;
	        			
	        			next($emerg_info_array);
        			}	   
        			
         		// TEST CONDITION       			
//         			if (count($emerg_info_array) > 0)
//         			{
// 	        			echo "<br>Emergency info for active person_id ".$savedPersonID.": <pre>".print_r($emergInfoArray,true)."</pre><br>"; 
//      				}	
     				
     				$reportDataDump .= 'Changes made to <b>cim_hrdb_emerg table</b>: '.$BR;
     				
     				// remove all emergency info records associated with active person id
					if (count($emergInfoArray) >= 1)
					{
						reset($emergInfoArray);
// 						$reportDataDump .= 'Saving the emergency contact record associated with person ID '.$savedPersonID.$BR.$BR;
// 						next($emergInfoArray);	// keep the first record (most recent emerg_id)
						
		        		foreach(array_keys($emergInfoArray) as $m)
	     				{
		        			$record = current($emergInfoArray);
		        			
		        			$emergID = key($emergInfoArray);
		        			
// 		        			echo "REMOVE person-emerg entry for person_id = ".$savedPersonID." using key = ".key($emergInfoArray);
		        			if ((isset($emergID))&&($emergID != ''))
		        			{
			        			$emergUpdater = new RowManager_EmergencyInfoManager($emergID);	
 	 		        			$emergUpdater->deleteEntry();	
 	 		        			$reportDataDump .= 'Deleting emergency contact record having emergency ID '.$emergID.$BR.$BR;	
 		        			}						
		        			
		        			next($emergInfoArray);
	        			}							
						
					}		
        			
        			/**** TODO: have code to deal with deleting person ids in 'cim_hrdb_admin' (LOW-PRIORITY DUE TO SMALL SIZE OF TABLE) **/
        			
         			
					/*** Update the Campus Assignment table	(cim_hrdb_assignment)  **/
					// Step 1)  Find the information stored for the active person_id
					$campusAssignArray = array();
					
					$campus_assign_manager = new RowManager_AssignmentsManager();
					$campus_assign_manager->setPersonID($savedPersonID);
					$campus_assign_manager->setSortOrder( 'assignment_id' );
		 			$campus_assign_manager->setAscDesc( 'DESC' ); 	// sort by descending assignment IDs
					
					$campusAssignData = $campus_assign_manager->getListIterator();
	    			$campus_assign_array = $campusAssignData->getDataList();	
	        		reset($campus_assign_array);		       		
	        		foreach(array_keys($campus_assign_array) as $id)
     				{
	        			$record = current($campus_assign_array);	
	        			
	        			$assign_id = $record['assignment_id'];
	        			$assignment_info = array();
	        			
	        			
			      	$fields = page_DeletePerson::ASSIGNMENT_RECORD_FIELDS;
			     		$fieldsArray = explode(",",$fields);	
			        		
			     		// store the campus assignment values in an array
			     		reset($fieldsArray);
			     		foreach(array_keys($fieldsArray) as $k)
						{
			     			$fieldName = current($fieldsArray);	
			     			
			        		$assignment_info[$fieldName] = $record[$fieldName];		        				       		
			     			
			     			next($fieldsArray);
			  			}	        			
	        			
	        			// store array of record values in array with assign_id as key
	        			$campusAssignArray[$assign_id] = $assignment_info;
	        			
	        			next($campus_assign_array);
        			}	   
        			
         		// TEST CONDITION       			
//         			if (count($campus_assign_array) > 0)
//         			{
// 	        			echo "<br>Campus assignment info for active person_id ".$savedPersonID.": <pre>".print_r($campusAssignArray,true)."</pre><br>"; 
//      				}	
     				
     				$reportDataDump .= 'Changes made to <b>cim_hrdb_assignment table</b>: '.$BR;
     				
     				// TODO??: remove all but the most recent campus assignment record (associated with active person id)
     				// REMEMBER: a student may be an alumni of one school or attend two schools at once...
					if (count($campusAssignArray) >= 1)	// remove ONLY records with redundant person-campus pairs
					{
						$campus_ids_list = array(); 
						$idx = 0;    				
						reset($campusAssignArray);
						$row = current($campusAssignArray);
						$campus_ids_list[$idx++] = $row['campus_id'];
// 						next($campusAssignArray);	// keep the first record (most recent assign_id)
						
		        		foreach(array_keys($campusAssignArray) as $m)
	     				{
		        			$record = current($campusAssignArray);
		        			
		        			$assignID = key($campusAssignArray);
		        			
		        			$reportDataDump .= "REMOVE person-campus entry for person_id = ".$savedPersonID." using key = ".key($campusAssignArray).$BR.$BR;
		        			if ((isset($assignID))&&($assignID != ''))
		        			{
			        			// remove entries having a campus_id for the active person record

				        			$assignUpdater = new RowManager_AssignmentsManager($assignID);	
	 	 		        			$assignUpdater->deleteEntry();	
	 	 		        			$reportDataDump .= 'Deleting campus assignment record having campus ID '.$record['campus_id'].$BR.$BR;	 	 		        			

 		        			}						
		        			
		        			next($campusAssignArray);
	        			}							
						
					}	

					$reportDataDump .= 'Changes made to <b>cim_reg_registration table</b>: '.$BR;	    			
        			
        			// Delete the registration records associated with the person ID
        			$registration_manager2 = new RowManager_RegistrationManager();							
					$registration_manager2->addSearchCondition('person_id in ('.$savedPersonID.')' ); //$person_ids_list.')');
		 			$registration_manager2->setSortOrder( 'person_id' );
		 			$registration_manager2->setAscDesc( 'DESC' ); 	// sort by descending person IDs
		 			
// 		 			echo "candidate person ids = ".$person_ids_list."<br>";
		 
	    			$registrationData2 = $registration_manager2->getListIterator();
	    			$registration_array2 = $registrationData2->getDataList();	
//  					echo "<br>Contact data for ALL person_ids: <pre>".print_r($emerg_info_array2,true)."</pre><br>"; 
	
// 					$eventIDs = array();
// 					$idx = 0;	

	        		reset($registration_array2);		        		
	        		foreach(array_keys($registration_array2) as $key)
     				{
	        			$record = current($registration_array2);	
	        			$personID = $record['person_id'];
	        			
	        			if ($personID == $savedPersonID)		// delete any associated registration records
	        			{    
// 		        			echo "FOUND person ".$personID;
		        			$registration_id = $record['registration_id'];
// 		        			$event_id = $record['event_id'];

        					//  Delete associated records in registration-related tables
        					$this->deleteAssociatedRegRecords($registration_id);
		        			
		        			$regRecordUpdater = new RowManager_RegistrationManager($registration_id);
									 			        			
// 		        			// update the person ID for an campus assignment record (in database)
// 		        			$updateValues = array();
// 		        			$updateValues['person_id'] = $savedPersonID;	
// 				        			$regRecordUpdater->loadFromArray( $updateValues );
// 	 			        			$regRecordUpdater->updateDBTable();

							$regRecordUpdater->deleteEntry();
							
			        			$reportDataDump .= 'Delete associated registration record for person ID '.$savedPersonID.','.$BR; 
	        			}		        		   
	        			
	        			next($registration_array2);
        			}	       			
        			
        			
					/*** Update the Staff table	(cim_hrdb_staff)  **/
					// Step 1)  Find the information stored for the active person_id
					
					$staff_manager = new RowManager_StaffManager();
					$staff_manager->setPersonID($savedPersonID);
					$staff_manager->setSortOrder( 'staff_id' );
		 			$staff_manager->setAscDesc( 'DESC' ); 	// sort by descending assignment IDs
					
//  					echo "<BR>".$savedPersonID.",";

					$staffData = $staff_manager->getListIterator();
	    			$staff_array = $staffData->getDataList();	

         		// TEST CONDITION       			
//         			if (count($staff_array) > 0)
//         			{
// 	        			echo "<br>Staff info for active person_id ".$savedPersonID.": <pre>".print_r($staff_array,true)."</pre><br>"; 
//      				}
     					
     				$reportDataDump .= 'Changes made to <b>cim_hrdb_staff table</b>: '.$BR;
     				
     				// Step 2) Remove all but one of the staff records
// 					if (count($staff_array) > 1)	// remove ONLY records with redundant person-campus pairs
// 					{				
						reset($staff_array);
// 						next($staff_array);	// keep the first record (most recent staff_id for active person)
// 						$reportDataDump .= 'Saving the first staff record associated with person ID '.$savedPersonID.$BR.$BR;
						
// 						echo 'staff array = <pre>'.print_r($staff_array,true).'</pre>';
		        		foreach(array_keys($staff_array) as $m)
	     				{
		        			$record = current($staff_array);
		        			$staffID = key($staff_array);
		        			
			        		// remove redundant entry
		        			$staffUpdater = new RowManager_StaffManager($staffID);	
	 		        		$staffUpdater->deleteEntry();	
	 		        		$reportDataDump .= 'Deleting staff record having staff ID '.$staffID.$BR.$BR;	 	 		        							

		        			$id = next($staff_array);	// staff ID
        					if ($id === FALSE)
        					{
	        					break;	// no valid data found so break out of the loop
        					}
	        			}							
						
// 					}	
								
					/***** Remove redundant sub-group associations, otherwise rename person-id to active person-id ******************/
					// Update the Person-DG table (sch_person_sub_group): still requires clean up
					// Step 1)  Find the information stored for the active person_id
					$dg_campus_array = array();
					
					$person_dg_manager = new RowManager_PersonDGManager();
					$person_dg_manager->setPersonID($savedPersonID);
					$person_dg_manager->setSortOrder('person_sub_group_id');
					$person_dg_manager->setAscDesc( 'DESC' ); 	// sort by descending person_sub_group_IDs

					$personDGData = $person_dg_manager->getListIterator();
	    			$personDGArray = $personDGData->getDataList();	
	        		reset($personDGArray);		        		
	        		foreach(array_keys($personDGArray) as $l)
     				{
	        			$record = current($personDGArray);	
	        			
	        			$dg_id = $record['sub_group_id'];
	        			$campus_id = $record['organization_id'];
	        			
	        			$dg_campus_array[$dg_id] = $campus_id;
	        			
	        			next($personDGArray);
        			}	           			         				
//         			
//         			if (count($dg_campus_array) > 0)
//         			{
// 	        			echo "<br>DG for active person_id ".$savedPersonID.": <pre>".print_r($personDGArray,true)."</pre><br>"; 
// //          				echo "<br>DG-Campus for active person_id ".$savedPersonID.": <pre>".print_r($dg_campus_array,true)."</pre><br>"; 	
//      				}		
     				
     				$reportDataDump .= 'Changes made to <b>sch_person_sub_group table</b>: '.$BR;	
	    				
        			// Step 2)  Update the records having the non-active person ids for this person
        			$person_dg_manager2 = new RowManager_PersonDGManager();								
					$person_dg_manager2->addSearchCondition('person_id in ('.$person_ids_list.')');
		 			$person_dg_manager2->setSortOrder( 'person_id' );
		 			$person_dg_manager2->setAscDesc( 'DESC' ); 	// sort by descending person IDs
		 
	    			$personDGData2 = $person_dg_manager2->getListIterator();
	    			$personDGArray2 = $personDGData2->getDataList();		
	    			
					// If no record was found for the active person record - then set flag for updating
// 					$updated = true;
// 					if (count($personDGArray2) < 1)
// 					{
// 						$updated = false;
// 					}
// 	        		$j = 0;

// 					echo 'DG array results = <pre>'.print_r($personDGArray2,true).'</pre>';
// 					echo 'dg - campus array: <pre>'.print_r($dg_campus_array,true).'</pre>';	  	    			    			
					
	        		reset($personDGArray2);		        		
	        		foreach(array_keys($personDGArray2) as $l)
     				{
	        			$record = current($personDGArray2);	
	        			$personID = $record['person_id'];
	        			
	        			if ($personID == $savedPersonID)
	        			{    
		        			$personSubGroupID = $record['person_sub_group_id'];
		        			
		        			$personDGUpdater = new RowManager_PersonDGManager($personSubGroupID);
		        			
		        			$dg_id = $record['sub_group_id'];
		        			$campus_id = $record['organization_id'];

		        			$personDGUpdater->deleteEntry();
		        			$reportDataDump .= 'Deleting record for person ID '.$savedPersonID.$BR;
		      
	        			}		        		   
	        			
	        			next($personDGArray2);
        			}	
        			
        			
        			
        			/*** Update the personal schedule table (sch_schedule)  **/
					// Step 1)  Find the information stored for the active person_id
					$schedule_array = array();
					
					$schedule_manager = new RowManager_ScheduleManager();
					$schedule_manager->setPersonID($savedPersonID);
					$schedule_manager->setSortOrder('schedule_id');
					$schedule_manager->setAscDesc( 'DESC' ); 	// sort by descending schedule_IDs

					$personScheduleData = $schedule_manager->getListIterator();
	    			$personScheduleArray = $personScheduleData->getDataList();	
	        		reset($personScheduleArray);
	        		$idx = 0;		        		
	        		foreach(array_keys($personScheduleArray) as $l)
     				{
	        			$record = current($personScheduleArray);	
	        			
	        			$schedule_block = $record['schedule_block'];	        			
	        			$schedule_array[$idx] = $schedule_block;
	        			
	        			next($personScheduleArray);
	        			$idx++;
        			}	  
        			
//         			echo 'active person schedule = <pre>'.print_r($personScheduleArray,true).'</pre>';
//         			echo 'person blocks array = <pre>'.print_r($schedule_array,true).'</pre>';  

     				$reportDataDump .= 'Changes made to <b>sch_schedule table</b>: '.$BR;									
	    				
        			// Step 2)  Create new records for active person ID from data linked to the non-active person ids for this person
        			$schedules = new RowManager_ScheduleManager();	
        			$schedule_manager2 = new MultiTableManager();	
        			$schedule_manager2->addRowManager($schedules);						
					$schedule_manager2->addSearchCondition('person_id in ('.$person_ids_list.')');
		 			$schedule_manager2->addSortField( 'person_id', 'DESC' );
// 		 			$schedule_manager2->setAscDesc( 'DESC' ); 	// sort by descending person ID
		 			
	    			$personScheduleData2 = $schedule_manager2->getListIterator();
	    			$personScheduleArray2 = $personScheduleData2->getDataList();

					$updatePersonID = -1;
	        		reset($personScheduleArray2);		        		
	        		foreach(array_keys($personScheduleArray2) as $l)
     				{
	        			$record = current($personScheduleArray2);	
	        			$personID = $record['person_id'];
	        			
	        			if ($personID == $savedPersonID)
	        			{    
		        			$found_sch_block = $record['schedule_block'];
		        			$schedule_id = $record['schedule_id'];
		        			
		        			$personScheduleUpdater = new RowManager_ScheduleManager($schedule_id);

		        			$personScheduleUpdater->deleteEntry();	
		        			$reportDataDump .= 'Deleting record for person ID '.$savedPersonID.$BR.$BR;     					        					      
	        			}		        		   
	        			
	        			next($personScheduleArray2);
        			}	  
        			
			  
					/*** Remove all person records for person_id***/  
					$personIDs = explode(',', $person_ids_list);
					foreach( array_values($personIDs) as $personID) 
					{		 
						if ($personID == $savedPersonID)
						{
							$personUpdater = new RowManager_PersonManager($personID);	
							$personUpdater->deleteEntry();
							$reportDataDump .= 'Deleting <b>cim_hrdb_person</b> record having person ID '.$personID.$BR;	
						}
						next($personIDs);
					}        			
   			

				}  // end if (isset($indivDataArray)) 
				
				$reportDataDump = substr($reportDataDump, 0, -4);	// remove the last <BR>			 											          
	         $reportDataDump .= $HR;				 
				
// 				next($personDataArray);
// 			}	

			}	// end 	if (isset($indivDataArray))
			
// 			echo $reportDataDump;

	
			
		}	// end 'should delete?'
		
		parent::processData();	// remove data from cim_hrdb_person table

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
        //$path = $this->pathModuleRoot.'templates/';
        // Otherwise use the standard Templates for the site:
        $path = SITE_PATH_TEMPLATES;
        

        /*
         * Update any label tags ...
         */
        // example:
            // $name = $user->getName();
            // $this->labels->setLabelTag( '[Title]', '[userName]', $name);
         
        
        
        // NOTE:  this parent method prepares the $this->template with the 
        // common AdminBox data.  
        $this->prepareTemplate( $path );


        // uncomment this line if you are creating a template for this page
		//$templateName = 'page_DeletePerson.php';
		// otherwise use the generic site template
		$templateName = 'siteDeleteConf.php';
		
		return $this->template->fetch( $templateName );
        
    }

    
    private function getAccessRecords($person_ids)
    {
	    $matchedViewerIDs = array();
	    	    
	    $access_manager = new RowManager_AccessManager();
	    $access_manager->addSearchCondition("person_id in (".$person_ids.")");
		 $access_manager->setSortOrder( 'person_id' );
		 $access_manager->setAscDesc( 'DESC' ); 	// sort by descending person IDs
		 
	    $accessData = $access_manager->getListIterator();
	    $accessArray = $accessData->getDataList();
	    
// 	    echo 'access-viewer records = <pre>'.print_r($accessArray,true).'</pre>';
	    
	    if (isset($accessArray))
	    {
		    if (count($accessArray) > 0)
		    {
			    reset($accessArray);
	        	 foreach(array_keys($accessArray) as $k)
	        	 {
		        	$accessRecord = current($accessArray);
		        	
		        	$personID = $accessRecord['person_id'];
		        	$viewerID = $accessRecord['viewer_id'];
		        	$matchedViewerIDs[$viewerID] = $personID;	// NOV 27,2007: swapped $viewerID and $personID (key-index swap)
		        						
					next($accessArray);
				 }
			 }
		 }
		// 		 echo 'viewer records = <pre>'.print_r($matchedViewerIDs,true).'</pre>'; 
		return $matchedViewerIDs;		 
	 }
	 
  	// checks for empty fields in a cim_hrdb_person record 
		// and returns array indicating which fields are empty
		private function checkPersonRecordFields($person_record)
		{
  		$flagArray = array();
  		
  		$fields = page_PersonRecordCleanUp::PERSON_RECORD_FIELDS;
  		$fieldsArray = explode(",",$fields);	
     		
  		reset($fieldsArray);
  		foreach(array_keys($fieldsArray) as $k)
		{
  			$fieldName = current($fieldsArray);	
  			
  			// default == field is empty; check to see if it really is empty
  			$flagArray[$fieldName] = '0';
//      			echo "person field = ".$person_record[$fieldName];
  			if (($person_record[$fieldName] != '') && ($person_record[$fieldName] != '0'))
  			{
     			$flagArray[$fieldName] = '1';	// indicate field has a non-empty/non-default value
				}			        				       		
  			
  			next($fieldsArray);
			}
			
			return $flagArray;
	}   
	
	private function deleteAssociatedRegRecords($reg_id)
	{
				// delete any CC transactions linked to the registration record
		$ccTrans = new RowManager_CreditCardTransactionManager();
		$ccTrans->setRegID($reg_id);
		
		$ccTransList = $ccTrans->getListIterator();
		$ccTransArray = $ccTransList->getDataList();
		
		reset($ccTransArray);
		foreach(array_keys($ccTransArray) as $k)
		{
			$record = current($ccTransArray);
			$ccTransID = $record['cctransaction_id'];
			
			// delete any CC transaction receipts linked to the registration record
			$ccReceipt = new RowManager_ReceiptManager($ccTransID);		
			$ccReceipt->deleteEntry();		
			
			// delete CC trans record now that we know CC trans. ID
			$deleteCCtrans = new RowManager_CreditCardTransactionManager($ccTransID);
			$deleteCCtrans->deleteEntry();										
			
			next($ccTransArray);
		}				
		
		// delete any cash transactions linked to the registration record
		$cashTrans = new RowManager_CashTransactionManager();
		$cashTrans->setRegID($reg_id);
		
		$cashTransList = $cashTrans->getListIterator();
		$cashTransArray = $cashTransList->getDataList();
					
		reset($cashTransArray);
		foreach(array_keys($cashTransArray) as $k)
		{
			$record = current($cashTransArray);
			$cashTransID = $record['cashtransaction_id'];
			
			// delete cash trans record now that we know cash trans. ID
			$deleteCashTrans = new RowManager_CashTransactionManager($cashTransID);
			$deleteCashTrans->deleteEntry();							
			
			next($cashTransArray);
		}				
		
		// delete any scholarships linked to the registration record
		$scholarship = new RowManager_ScholarshipAssignmentManager();
		$scholarship->setRegID($reg_id);
		
		$scholarshipList = $scholarship->getListIterator();
		$scholarshipArray = $scholarshipList->getDataList();
					
		reset($scholarshipArray);
		foreach(array_keys($scholarshipArray) as $k)
		{
			$record = current($scholarshipArray);
			$scholarshipID = $record['scholarship_id'];
			
			// delete cash trans record now that we know scholarship ID
			$deleteScholarship = new RowManager_ScholarshipAssignmentManager($scholarshipID);
			$deleteScholarship->deleteEntry();							
			
			next($scholarshipArray);
		}					
		
		// delete any field values linked to the registration record
		$fieldValues = new RowManager_FieldValueManager();
		$fieldValues->setRegID($reg_id);
		
		$fieldValuesList = $fieldValues->getListIterator();
		$fieldValuesArray = $fieldValuesList->getDataList();
					
		reset($fieldValuesArray);
		foreach(array_keys($fieldValuesArray) as $k)
		{
			$record = current($fieldValuesArray);
			$fieldValueID = $record['fieldvalues_id'];
			
			// delete cash trans record now that we know field value ID
			$deleteFieldValue = new RowManager_FieldValueManager($fieldValueID);
			$deleteFieldValue->deleteEntry();							
			
			next($fieldValuesArray);
		}	
	}
		 	
}

?>