<?php
/**
 * @package cim_reg
 */ 
/**
 * class page_PersonRecordCleanUp
 * <pre> 
 * Used to remove redundant person records from the ciministry database, as well as records pointing to those.
 * </pre>
 * @author Hobbe Smit
 * Date:   11 Oct 2007
 */
class  page_PersonRecordCleanUp extends PageDisplay_FormProcessor		//DisplayList 
{

	//CONSTANTS:
	
	/** dummy fields... **/
	 const FORM_FIELDS = '';	//'ccreceipt_sequencenum|T|,ccreceipt_authcode|T|,ccreceipt_responsecode|T|,ccreceipt_message|T|,ccreceipt_moddate|T|';

	/** dummy field types... **/
	 const FORM_FIELD_TYPES = '';	//'-,-,-,-,-,-,-,-,-';//'textbox,droplist|20,textbox|20,textbox|6,textbox|7,hidden,textbox|10,-,hidden'; 
	 	
	/** The list of fields to be displayed */
    const DISPLAY_FIELDS = '';	//'ccreceipt_sequencenum,ccreceipt_authcode,ccreceipt_responsecode,ccreceipt_message,ccreceipt_moddate';
    
    /** The Multilingual Page Key for labels on this page */
    const MULTILINGUAL_PAGE_KEY = 'page_PersonRecordCleanUp';
    
    /** a CSV string containing the fields of cim_hrdb_person (except the local contact info since we shouldn't use old local data)**/
    const PERSON_RECORD_FIELDS = 'person_id,person_fname,person_lname,person_phone,person_email,person_addr,person_city,province_id,person_pc,gender_id';//,person_local_phone,person_local_addr,person_local_city,person_local_pc,person_local_province_id';
 
    /** a CSV string containing the fields of cim_hrdb_emerg **/
    const EMERG_RECORD_FIELDS = 'emerg_id,person_id,emerg_passportNum,emerg_passportOrigin,emerg_passportExpiry,emerg_contactName,emerg_contactRship,emerg_contactHome,emerg_contactWork,emerg_contactMobile,emerg_contactEmail,emerg_birthdate,emerg_medicalNotes';
       
    /** a CSV string containing the fields of cim_hrdb_assignment **/
    const ASSIGNMENT_RECORD_FIELDS = 'assignment_id,person_id,campus_id,assignmentstatus_id';

	//VARIABLES:
	
	/** @var [OBJECT] The viewer object. */
	protected $viewer;
	
    /** @var [STRING] The path to this module's root directory. */
	protected $pathModuleRoot;
	
	
	/** @var [OBJECT] Stores a reference to the app. controller object */
//	protected $_controller;								

	/** @var [STRING] Data sorting parameter passed around */
	protected $sortBy;	
	
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
	 * @param $sortBy [STRING] Field data to sort listManager by.
     * @param $managerInit [INTEGER] Initialization value for the listManager.
	 * @return [void]
	 */
    function __construct($pathModuleRoot, $viewer, $sortBy, $filter_fname = 'A%', $filter_lname = 'A%', $filter_email = '', $max_exec_time)
    {
//        parent::__construct( page_DisplayCCtransactionReceipt::DISPLAY_FIELDS );

		  $formAction = '';
        $fieldList = page_PersonRecordCleanUp::FORM_FIELDS;
        $fieldTypes = page_PersonRecordCleanUp::FORM_FIELD_TYPES;
        $displayFields = page_PersonRecordCleanUp::DISPLAY_FIELDS;
        parent::__construct($viewer, $formAction, $sortBy, $fieldList, $fieldTypes, $displayFields );
        
        $this->pathModuleRoot = $pathModuleRoot;
        $this->viewer = $viewer;
        $this->sortBy = $sortBy;
        
        // initialize data filters
        $this->filter_fname = $filter_fname;
        $this->filter_lname = $filter_lname;
        $this->filter_email = $filter_email;
        
        if (isset($max_exec_time))
        {
	        set_time_limit($max_exec_time);
// 	        echo "Time limit set to ".$max_exec_time." seconds!";
        }
	
			$this->person_manager = new RowManager_PersonManager();
// 			$this->access_manager = new RowManager_AccessManager();
// 			$this->person_dg_manager = new RowManager_PersonDGManager();	// TODO: implement this class under app_cim_sch
// 			$this->schedule_manager = new RowManager_ScheduleManager();	// TODO: implement this class under app_cim_sch
// 			$this->person_year_manager = new RowManager_PersonYearManager();	// TODO: implement this class under app_cim_sch
// 			$this->emerg_contact_manager = new RowManager_EmergencyInfoManager();
// 			$this->hrdb_admin_manager = new RowManager_AdminManager();
// 			$this->campus_assign_manager = new RowManager_AssignmentsManager();
// 			$this->registration_manager = new RowManager_RegistrationManager();
// 			$this->staff_manager = new RowManager_StaffManager();
 
                
         // now initialize the labels for this page
         // start by loading the default field labels for this Module
         $languageID = $viewer->getLanguageID();
         $seriesKey = modulecim_reg::MULTILINGUAL_SERIES_KEY;
         $pageKey = modulecim_reg::MULTILINGUAL_PAGE_FIELDS;
         $this->labels = new MultilingualManager( $languageID, $seriesKey, $pageKey );
         
         // then load the page specific labels for this page
         $pageKey = page_PersonRecordCleanUp::MULTILINGUAL_PAGE_KEY;
         $this->labels->loadPageLabels( $pageKey );
         
         $this->labels->setSeriesKey( SITE_LABEL_SERIES_SITE );
         $this->labels->loadPageLabels( SITE_LABEL_PAGE_FORM_LINKS );
         
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
	 * function loadFromForm
	 * <pre>
	 * Loads the data from the submitted form. Because this page is made up of 
	 * sub-pages we just need to figure out the appropriate loadFromForm() call
	 * </pre>
	 * Precondition: sub-page objects must be initialized
	 * @return [void]
	 */
    function loadFromForm() 
    {	    	    
	    parent::loadFromForm();      
       
    } // end loadFromForm() 
    

   //************************************************************************
	/**
	 * function isDataValid
	 * <pre>
	 * Verifies the returned data is valid. Because this page is made up of 
	 * sub-pages we just need to figure out the appropriate isDataValid() call
	 * </pre>
	 * @return [BOOL]
	 */
    function isDataValid() 
    {      
      $isValid = parent::isDataValid();   
       
      // now return result
      return $isValid;        
    }
    
    
    
    //************************************************************************
	/**
	 * function processData
	 * <pre>
	 * Processes the data for this form. Because this page is made up of 
	 * sub-pages we just need to figure out the appropriate processData() call
	 * on a sub-page.
	 * </pre>
	 * Precondition: sub-page objects must be initialized
	 * @return [void]
	 */
    function processData() 
    {
		// hopefully don't need to do anything here
        
    } // end processData()
    
        
    
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
	    // initialize the variable storing process report data
	    $reportDataDump = '';
	    $BR = '<BR>';
	    $HR = '<HR>';
    
        // Make a new Template object
        $path = $this->pathModuleRoot.'templates/';
        //        $path = SITE_PATH_TEMPLATES;
        // Replace $path with the following line if you want to create a
        // template tailored for this page:
        //$path = $this->pathModuleRoot.'templates/';
        
        
        // store the link values
        // $this->linkValues[ 'view' ] = 'add/new/href/data/here';
        
        // store the link labels
        $this->linkLabels[ 'cont' ] = $this->labels->getLabel( '[GoBack]');        

        
        // store any additional link Columns
        // example:
            //$title = $this->labels->getLabel( '[title_groups]');
            //$columnLabel = $this->labels->getLabel( '[groups]');
            //$link = $this->linkValues[ 'groups' ];
            //$fieldName = 'accessgroup_id';
            //$this->addLinkColumn( $title, $columnLabel, $link, $fieldName);

        
        // store the page labels
        // NOTE: use this location to update any label tags ...
        // example:
            // $name = $user->getName();
            // $this->labels->setLabelTag( '[Title]', '[userName]', $name);
            
        
        $this->prepareTemplate( $path );          
			
	
			/** Get list of unique triples of first name, last name, and e-mail address **/
// 		  $allPeople = array();		// NOT USED BECAUSE WE HAVE NESTED LOOP INSTEAD OF MULTIPLE LOOPS
		  
        $personRecords = new MultiTableManager();
        $personRecords->addRowManager($this->person_manager);
              		  
        $personRecords->setSortOrder( 'person_lname' ); 
        
//         echo 'filters = '.$this->filter_fname.', '.$this->filter_lname.', '.$this->filter_email;
        
        /**** DATA FILTERS: USED TO ENSURE 60 SEC TIME-OUT IS NOT VIOLATED ****/
        $personRecords->addSearchCondition( "person_fname like '".$this->filter_fname."%'" );
        $personRecords->addSearchCondition( "person_lname like '".$this->filter_lname."%'" );
        $personRecords->addSearchCondition( "person_email like '".$this->filter_email."%'" );	
        
                // use GROUP BY to easily enforce distinct triplets of (person_fname, person_lname, person_email)
		  $groupBy = "person_fname,person_lname,person_email";
        $personRecords->setGroupBy($groupBy);	
         
		  $personData = $personRecords->getListIterator(); 
        $personDataArray = $personData->getDataList();	
	
			/** Go through the list of names 1 by 1, running another query to find if duplicates exist **/
        	reset($personDataArray);
        	foreach(array_keys($personDataArray) as $k)
        	{
	        	$savedPersonID = -1;	// the only person ID left in the database for this individual
	        	
	        	$person = current($personDataArray);
	        	
	        	$person_fname = $person['person_fname'];
	        	$person_lname = $person['person_lname']; 
				$person_email = $person['person_email']; 

				$reportDataDump .= 'Unique person record tuple:'.$BR.'  First Name = '.$person_fname.', Last Name = '.$person_lname.', E-mail = '.$person_email.$BR.$BR;
//  				echo "PERSON NAME: ".$person_fname." ".$person_lname;												
//  			echo "PERSON: <pre>".print_r($person,true)."</pre>"; 

				// search for a particular person to see if duplicate records exist
				$indiv_person_manager = new RowManager_PersonManager();
				$indiv_person_manager->setFirstName(addslashes($person_fname));	// use addslashes to escape special chars in string
				$indiv_person_manager->setLastName(addslashes($person_lname));
				$indiv_person_manager->setEmail(addslashes($person_email));
				$indiv_person_manager->setSortOrder( 'person_id' );
				$indiv_person_manager->setAscDesc( 'DESC' ); 	// sort by descending person IDs
				
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
//  							echo "<br>found viewer IDs: <pre>".print_r($foundViewerIDs, true)."</pre>";

							/** Get the associated viewer_id with the most recent login date **/
// 							$viewers = new RowManager_ViewerManager();
// 							$viewer_ids = '';
// 							reset($foundViewerIDs);
// 							foreach (array_keys($foundViewerIDs) as $key)
// 							{
// // 								$record = current($foundViewerIDs);
// 								$viewer_ids .= $key.',';	//$record	//
// 								next($foundViewerIDs);
// 							}
// 							$viewer_ids = substr($viewer_ids, 0, -1);	// remove final comma
// //  							echo 'viewer_ids list = '.$viewer_ids.'<br>';
// 							$viewers->addSearchCondition("viewer_id in (".$viewer_ids.")");

// 		 
// 						   $viewersData = $viewers->getListIterator();
// 						   $viewersArray = $viewersData->getDataList();
// 						   
// // 						   echo 'viewers array data = <pre>'.print_r($viewersArray,true).'</pre>';
// 						   
// 						   $mostRecentDate = '0000-00-00';
// 						   $mostRecentViewer = -1;
// 						   reset($viewersArray);
// 							foreach(array_keys($viewersArray) as $l)
//         					{		
// 	        					$record = current($viewersArray);
// 	        					$foundDate = $record['viewer_lastLogin'];	
// 	        					$viewerID = $record['viewer_id'];		
// 	        					
// 	        					// update most recent date if a more recent login date was found
// 	        					if ($foundDate > $mostRecentDate)
// 	        					{
// 		        					$mostRecentDate = $foundDate;  
// 		        					$mostRecentViewer = $viewerID;	// set viewer_id to use
// 	        					}
//         					}
        					
        					// TODO: add loop here to check if all $foundViewerIDs (from access table) are in viewers table
        					// <loop>
        					//		if (in_array($foundViewerIDs[index], array_keys($viewersArray)))
        					//			delete $foundViewerIDs[index] from access table
        					// <end-loop>
        					
//          					echo 'most recent viewer id = '.$mostRecentViewer;
//          					echo 'viewer ids from list = <pre>'.print_r(array_keys($foundViewerIDs),true).'</pre>';
		
							/** store the active (access table) person_id in special variable	**/
							reset($foundViewerIDs);
							
// 							// (NEW) == person_id associated with the viewer_id having the most recent login date
// 							//				ONLY IN THE CASE WHERE PERSON HAS MORE THAN 1 VIEWER_ID
// 							if (($mostRecentViewer != -1)&&(count($viewersArray) > 1))
// 							{
// 								$temp_viewerIDs = array_keys($foundViewerIDs);		// gets the viewer ids
// 								$temp_personIDs = array_values($foundViewerIDs);		// gets the person ids
// 								$index = array_search($mostRecentViewer, $temp_viewerIDs); // get index having most recent viewer_id
// 								
// 								$savedPersonID = $temp_personIDs[$index];
// 								$reportDataDump .= 'Person ID of the record to keep: '.$savedPersonID.' (associated with most recent login)'.$BR.$BR;
// 							}
// 							else 	// FORMERLY: (OLD) == latest viewer-associated person ID, since array is ordered by person_id (DESC)
// 							{
								$personIDs = explode(',' , $person_ids_list);
								$savedPersonID = 	current($personIDs);		//current($foundViewerIDs);
								$reportDataDump .= 'Person ID of the record to keep: '.$savedPersonID.' (associated with the most recent person record)'.$BR.$BR;
									
// 							}	
							
// 							echo 'latest viewer ids = <pre>'.print_r($foundViewerIDs,true).'</pre>';
// 							echo 'saved person ID = '.$savedPersonID;

							$reportDataDump .= 'Changes made to <b>cim_hrdb_access table</b>: '.$BR;							
							
							/*** update the access table records to only use latest person ID **/						
							foreach(array_values($foundViewerIDs) as $person_id)
        					{	
	        					$viewer_id = key($foundViewerIDs);
// 	        					echo 'viewer_id = '.$viewer_id;
	        					
	        					// only update the access table record if it needs a different person_id	
								if ($person_id != $savedPersonID)
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
									
			     					   // set the values to set in the record (using 'access_id' as search key)
										$updateValues = array();
										$updateValues['access_id'] = $accessID;
										$updateValues['viewer_id'] = $viewer_id;
										$updateValues['person_id'] = $savedPersonID;	// only data that is changed
										
										
				        				$reportDataDump .= 'Updating person_id '.$person_id.' to be '.$savedPersonID.$BR.$BR;
										
		 			        			$accessManager->loadFromArray( $updateValues );
		 			        			$accessManager->updateDBTable();
		 			        			next($accessDataArray);
	 			        			}
 			        			}
 			        			
 			        			$id = next($foundViewerIDs);	// person_id
	        					if ($id === FALSE)
	        					{
		        					break;	// no valid data found so break out of the loop
	        					}
							}
 						}	/** <end> access table update **/
						
						        		
		        		$baseRecord = $indivDataArray[$savedPersonID];
// 		        		echo "<br>base record: <pre>".print_r($baseRecord,true)."</pre><br>";
		        		$flagArray = $this->checkPersonRecordFields($baseRecord);
// 		        		echo "<br>flag array: <pre>".print_r($flagArray,true)."</pre><br>";
		        		

		        		// Add data from other records to the stored latest person record, if required	
		        		// (i.e. if latest data misses phone #, etc)
		        		reset($indivDataArray);		        		
		        		foreach(array_keys($indivDataArray) as $id)
        				{
		        			$record = current($indivDataArray);	
		        			$personID = $record['person_id'];
		        			
		        			if ($personID != $savedPersonID)
		        			{    
			        			$personUpdater = new RowManager_PersonManager();
			        			$personUpdater->setPersonID($savedPersonID);
			        			$updateValues = array();
			        			$updateValues['person_id'] = $savedPersonID;	// just to make sure...
			        			
			        			$nextFlagArray = $this->checkPersonRecordFields($indivDataArray[$personID]);
// 			        			echo "<br>next flag array: <pre>".print_r($nextFlagArray,true)."</pre><br>";
			        			
			        			reset($flagArray);
			        			foreach(array_keys($flagArray) as $m)  
			        			{
				        			// if field is empty in active record then
				        			// replace with most recent value - if one exists
				        			// (since we are going through a list of person ids
				        			//  in descending order)
				        			$flag = current($flagArray);
				        			if ($flag == '0')
				        			{
					        			$fieldName = key($flagArray);
					        			
					        			// check if the replacement person record has a non-empty field
					        			if ($nextFlagArray[$fieldName] == '1')
					        			{
						        			$updateValues[$fieldName] = $record[$fieldName];
						        			$flagArray[$fieldName] = '1';	// prevents less-recent person data to overwrite what was just written
					        			}
				        			}
				        			next($flagArray);
			        			}
// 			        			echo "<br>update values: <pre>".print_r($updateValues,true)."</pre><br>";
			        			
			        			// update the active person record (in database)
			        			if (count($updateValues) > 1)	// need something other than key
			        			{
				        			$reportDataDump .= 'Adding the following data to our preferred <b>cim_hrdb_person</b> record (using given person_id): ';
				        			$reportDataDump .= '<pre>'.print_r($updateValues,true).'</pre>'.$BR.$BR;

			        				$personUpdater->loadFromArray( $updateValues );
			        				$personUpdater->updateDBTable();
		        				}
		        			}		        		   
		        			
		        			next($indivDataArray);
	        			}	
        			}		// end "if >1 person id found for the person data"				

					 

	
					
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

					// remove all but the most recent person-year record (associated with active person id)
					if (count($personYearArray) > 1)
					{
						reset($personYearArray);
						$person_year_id = key($personYearArray);
						$reportDataDump .= 'Saving the first person year record associated with person ID '.$savedPersonID.$BR.$BR;
						next($personYearArray);	// keep the first record (most recent personyear_id
						
		        		foreach(array_keys($personYearArray) as $m)
	     				{
		        			$record = current($personYearArray);
		        			
		        			$personYearID = key($personYearArray);
		        			
// 		        			echo "REMOVE person-year entry for person_id = ".$savedPersonID." using key = ".key($personYearArray);
		        			if ((isset($personYearID))&&($personYearID != '')&&($personYearID > 0))
		        			{
				        		$reportDataDump .= 'Deleting redundant person year record having year ID '.$record.$BR.$BR;
			        			$personYearUpdater = new RowManager_PersonYearManager($personYearID);	
	 		        			$personYearUpdater->deleteEntry();		
 		        			}						
		        			
		        			next($personYearArray);
	        			}							
						
					}
						
	    				
        			// Step 2)  Update the records having the non-active person ids for this person
        			$person_year_manager2 = new RowManager_PersonYearManager();								
					$person_year_manager2->addSearchCondition('person_id in ('.$person_ids_list.')');
		 			$person_year_manager2->setSortOrder( 'person_id' );
		 			$person_year_manager2->setAscDesc( 'DESC' ); 	// sort by descending person IDs
		 
	    			$personYearData2 = $person_year_manager2->getListIterator();
	    			$person_year_array2 = $personYearData2->getDataList();	
// 					echo "<br>Years for ALL person_ids: <pre>".print_r($person_year_array2,true)."</pre><br>"; 
	
					// If no record was found for the active person record - then set flag for updating
					$updated = true;
					if (count($personYearArray) < 1)
					{
						$updated = false;
					}
	        		reset($person_year_array2);	
	        		$j = 0;	        		
	        		foreach(array_keys($person_year_array2) as $l)
     				{
	        			$record = current($person_year_array2);	
	        			$personID = $record['person_id'];
	        			
	        			// We ignore records with the active person id - since we dealt with those redundancies already
	        			if ($personID != $savedPersonID)
	        			{    
// 		        			echo "FOUND person ".$personID;
		        			$person_year_id = $record['personyear_id'];
		        			
		        			$personYearUpdater = new RowManager_PersonYearManager($person_year_id);
// 		        			$personYearUpdater->setPersonYearID($person_year_id);
		        			
		        			$person_id = $record['person_id'];
		        			$year_id = $record['year_id'];
		        			
		        			// check to see if identical information was already stored under active person_id
// 		        			if (in_array($year_id, $personYearArray))
// 		        			{
							if ($updated == false)	// if active person ID doesn't have record yet, then update older record with active person ID
							{
			        			$updateValues = array();
			        			$updateValues['person_id'] = $savedPersonID;	// just to make sure...
			        			$updateValues['year_id'] = $year_id;
			        			
//         						echo "<br>update values to ".$savedPersonID." from ".$person_id.": <pre>".print_r($person_year_array2,true)."</pre><br>"; 						        			
			        			
			        			// update the person ID for a person-DG record (in database)
			        			$personYearUpdater->loadFromArray( $updateValues );
 			        			$personYearUpdater->updateDBTable();
 			        			$updated = true;	// prevents the new data from being overwritten with older data (and allows better efficiency)
 			        			
 			        			$reportDataDump .= 'No record found for person ID '.$savedPersonID.', updating person ID for person ID '.$person_id.$BR.$BR;
							}
							else
							{
// 			        			echo "<br>TO BE DELETED FROM cim_hrdb_person_year: person_id = ".$personID.", year = ".$year_id."<br>";
 			        			$reportDataDump .= 'Deleting record for alternative person ID '.$person_id.$BR.$BR;
 			        			$personYearUpdater->deleteEntry();								
		        			}
// 							else	// add person-year data from other person-id-linked records
// 		        			{
// 			        			$updateValues = array();
// 			        			$updateValues['person_id'] = $savedPersonID;	// just to make sure...
// 			        			$updateValues['year_id'] = $year_id;
// 			        			
//         						echo "<br>update values to ".$savedPersonID." from ".$person_id.": <pre>".print_r($person_year_array2,true)."</pre><br>"; 						        			
// 			        			
// 			        			// update the person ID for a person-DG record (in database)
// 			        			$personYearUpdater->loadFromArray( $updateValues );
//  			        			$personYearUpdater->updateDBTable();
// 		        			}
		      
	        			}		        		   
	        			
	        			next($person_year_array2);
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
	        			
	        			
			      	$fields = page_PersonRecordCleanUp::EMERG_RECORD_FIELDS;
			     		$fieldsArray = explode(",",$fields);	
			        		
			     		// store the emergency info values in an array
			     		reset($fieldsArray);
			     		foreach(array_keys($fieldsArray) as $k)
						{
			     			$fieldName = current($fieldsArray);	
			     			
			        		$emerg_info[$fieldName] = $record[$fieldName];		        				       		
			     			
			     			next($fieldsArray);
			  			}	        			
// 	        			$emerg_info['person_id'] = $record['person_id'];
// 	        			$emerg_info['emerg_passportNum'] = $record['emerg_passportNum'];
// 	        			$emerg_info['emerg_passportOrigin'] = $record['emerg_passportOrigin'];
// 	        			$emerg_info['emerg_passportExpiry'] = $record['emerg_passportExpiry'];
// 	        			$emerg_info['emerg_contactName'] = $record['emerg_contactName'];
// 	        			$emerg_info['emerg_contactRship'] = $record['emerg_contactRship'];
// 	        			$emerg_info['emerg_contactHome'] = $record['emerg_contactHome'];
// 	        			$emerg_info['emerg_contactWork'] = $record['emerg_contactWork'];
// 	        			$emerg_info['emerg_contactMobile'] = $record['emerg_contactMobile'];
// 	        			$emerg_info['emerg_contactEmail'] = $record['emerg_contactEmail'];
// 	        			$emerg_info['emerg_birthdate'] = $record['emerg_birthdate'];
// 	        			$emerg_info['emerg_medicalNotes'] = $record['emerg_medicalNotes'];
	        			
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
     				
     				// remove all but the most recent emergency info record (associated with active person id)
					if (count($emergInfoArray) > 1)
					{
						reset($emergInfoArray);
						$reportDataDump .= 'Saving the emergency contact record associated with person ID '.$savedPersonID.$BR.$BR;
						next($emergInfoArray);	// keep the first record (most recent emerg_id)
						
		        		foreach(array_keys($emergInfoArray) as $m)
	     				{
		        			$record = current($emergInfoArray);
		        			
		        			$emergID = key($emergInfoArray);
		        			
// 		        			echo "REMOVE person-emerg entry for person_id = ".$savedPersonID." using key = ".key($emergInfoArray);
		        			if ((isset($emergID))&&($emergID != ''))
		        			{
			        			$emergUpdater = new RowManager_EmergencyInfoManager($emergID);	
 	 		        			$emergUpdater->deleteEntry();	
 	 		        			$reportDataDump .= 'Deleting redundant emergency contact record having emergency ID '.$emergID.$BR.$BR;	
 		        			}						
		        			
		        			next($emergInfoArray);
	        			}							
						
					}	
	    				
        			// Step 2)  Update the emergency contact records having the non-active person ids for this person
        			$emerg_info_manager2 = new RowManager_EmergencyInfoManager();								
					$emerg_info_manager2->addSearchCondition('person_id in ('.$person_ids_list.')');
		 			$emerg_info_manager2->setSortOrder( 'person_id' );
		 			$emerg_info_manager2->setAscDesc( 'DESC' ); 	// sort by descending person IDs
		 			
// 		 			echo "candidate person ids = ".$person_ids_list."<br>";
		 
	    			$emergInfoData2 = $emerg_info_manager2->getListIterator();
	    			$emerg_info_array2 = $emergInfoData2->getDataList();	
//  					echo "<br>Contact data for ALL person_ids: <pre>".print_r($emerg_info_array2,true)."</pre><br>"; 
	
					$updateValues = array();	
// 					$updateValues = $this->initRecord(page_PersonRecordCleanUp::EMERG_RECORD_FIELDS);	
// 					$updateID = -1;	
						
// 					// If no record was found for the active person record - then set flag for updating
// 					$updated = true;
// 					if (count($personYearArray) < 1)
// 					{
// 						$updated = false;
// 					}	
	        		reset($emerg_info_array2);		        		
	        		foreach(array_keys($emerg_info_array2) as $l)
     				{
	        			$record = current($emerg_info_array2);	
	        			$personID = $record['person_id'];
	        			$contactName = $record['emerg_contactName'];
	        			
	        			if ($personID != $savedPersonID)
	        			{    
		        			$emerg_id = $record['emerg_id'];
		        			
		        			$personEmergUpdater = new RowManager_EmergencyInfoManager($emerg_id);
// 		        			$personEmergUpdater->setPersonEmergID($emerg_id);
		        			
		        			$person_id = $record['person_id'];
		        			
							if (count($emergInfoArray) < 1)	// if active person ID doesn't have record yet, then update older record with active person ID
							{
								// update the last-updated record with further information (if there was a last update)
// 								if ($updateID != -1)
// 								{
// 									$personEmergUpdater = new RowManager_EmergencyInfoManager($updateID);
// 								}
								// TODO: reactivate the above and then delete all entries but the first totally updated record
									
								$record['person_id'] = $savedPersonID;	// require this to actually change person ID
								
// 								// determine if some fields have been replaced previously
// 								$flagArray = $this->checkRecordFields($updateValues, page_PersonRecordCleanUp::EMERG_RECORD_FIELDS);
// 			        			
// 			        			reset($flagArray);
// 			        			foreach(array_keys($flagArray) as $m)  
// 			        			{
// 				        			// if field is empty in update record then
// 				        			// replace with most recent value - if one exists
// 				        			// (since we are going through a list of person ids
// 				        			//  in descending order)
// 				        			$flag = current($flagArray);
// 				        			if ($flag == '0')
// 				        			{
// 					        			$fieldName = key($flagArray);  					        			
// 						        		$updateValues[$fieldName] = $record[$fieldName];	// update the array (or replace empty with empty)
// 				        			}
// 				        			next($flagArray);
// 			        			}				
								// (BELOW) REMOVE WHEN USING ABOVE:
								$updateValues['person_id'] = $savedPersonID;						 
			        			
			        			// update the person ID for an emergency contact record (in database)
			        			$personEmergUpdater->loadFromArray( $updateValues );
 			        			$personEmergUpdater->updateDBTable();
// 								$updateID = $emerg_id;				// TODO: ensure that we end up with only ONE record that is updated with latest data
								$reportDataDump .= 'No record found for person ID '.$savedPersonID.', updating person ID for person ID '.$person_id.$BR.$BR;
							}
							else
							{
								$contact_name = $record['emerg_contactHome'];
//  			        			echo "<br>TO BE DELETED FROM cim_hrdb_emerg: person_id = ".$person_id.", contactName = ".$contact_name."<br>";
								$reportDataDump .= 'Deleting record for alternative person ID '.$person_id.' having contact name = '.$contactName.$BR.$BR;
 			        			$personEmergUpdater->deleteEntry();								
		        			}
		      
	        			}		        		   
	        			
	        			next($emerg_info_array2);
        			}	
        			
        			
        			/**** TODO: have code to deal with redundant person ids in 'cim_hrdb_admin' (LOW-PRIORITY DUE TO SMALL SIZE OF TABLE) **/
        			
         			
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
	        			
	        			
			      	$fields = page_PersonRecordCleanUp::ASSIGNMENT_RECORD_FIELDS;
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
					if (count($campusAssignArray) > 1)	// remove ONLY records with redundant person-campus pairs
					{
						$campus_ids_list = array(); 
						$idx = 0;    				
						reset($campusAssignArray);
						$row = current($campusAssignArray);
						$campus_ids_list[$idx++] = $row['campus_id'];
						next($campusAssignArray);	// keep the first record (most recent assign_id)
						
		        		foreach(array_keys($campusAssignArray) as $m)
	     				{
		        			$record = current($campusAssignArray);
		        			
		        			$assignID = key($campusAssignArray);
		        			
// 		        			echo "REMOVE person-campus entry for person_id = ".$savedPersonID." using key = ".key($campusAssignArray);
		        			if ((isset($assignID))&&($assignID != ''))
		        			{
			        			// remove entries having a campus_id already stored for the active person record
			        			if (in_array($record['campus_id'], $campus_ids_list))
			        			{
				        			$assignUpdater = new RowManager_AssignmentsManager($assignID);	
	 	 		        			$assignUpdater->deleteEntry();	
	 	 		        			$reportDataDump .= 'Deleting redundant campus assignment record having campus ID '.$record['campus_id'].$BR.$BR;	 	 		        			
 	 		        			}
 	 		        			else	// store campus_id so as to remove any other records with this campus_id
 	 		        			{
	 	 		        			$campus_ids_list[$idx++] = $record['campus_id'];
 	 		        			}
 		        			}						
		        			
		        			next($campusAssignArray);
	        			}							
						
					}	
	    				
        			// Step 2)  Update the campus assignment records having the non-active person ids for this person
        			$campus_assign_manager2 = new RowManager_AssignmentsManager();							
					$campus_assign_manager2->addSearchCondition('person_id in ('.$person_ids_list.')');
		 			$campus_assign_manager2->setSortOrder( 'person_id' );
		 			$campus_assign_manager2->setAscDesc( 'DESC' ); 	// sort by descending person IDs
		 			
// 		 			echo "candidate person ids = ".$person_ids_list."<br>";
		 
	    			$campusAssignData2 = $campus_assign_manager2->getListIterator();
	    			$campus_assign_array2 = $campusAssignData2->getDataList();	
//  					echo "<br>Contact data for ALL person_ids: <pre>".print_r($emerg_info_array2,true)."</pre><br>"; 
	
					$campusIDs = array();
					$idx = 0;	

	        		reset($campus_assign_array2);		        		
	        		foreach(array_keys($campus_assign_array2) as $l)
     				{
	        			$record = current($campus_assign_array2);	
	        			$personID = $record['person_id'];
	        			
	        			if ($personID != $savedPersonID)
	        			{    
// 		        			echo "FOUND person ".$personID;
		        			$assignment_id = $record['assignment_id'];
		        			$campus_id = $record['campus_id'];
		        			
		        			$personAssignmentUpdater = new RowManager_AssignmentsManager($assignment_id);
// 		        			$personEmergUpdater->setPersonEmergID($emerg_id);
		        			
		        			$person_id = $record['person_id'];
		        			
							if (count($campusAssignArray) < 1)	// if active person ID doesn't have record yet, then update older record with active person ID
							{									
								$record['person_id'] = $savedPersonID;	// require this to actually change person ID
								
								// only create a new record with active person id if the campus ID not associated with the person yet
								if (!in_array($campus_id, $campusIDs))
								{											 			        			
				        			// update the person ID for an campus assignment record (in database)
				        			$updateValues = array();
				        			$updateValues['person_id'] = $savedPersonID;	
				        			$personAssignmentUpdater->loadFromArray( $updateValues );
	 			        			$personAssignmentUpdater->updateDBTable();
	 			        			$reportDataDump .= 'No record found for person ID '.$savedPersonID.' (with campus ID '.$campus_id.'),<br>';
	 			        			$reportDataDump .= 'updating person ID for person ID '.$person_id.$BR.$BR;
	 			        			
	 			        			$campusIDs[$idx++] = $campus_id;
 			        			}
 			        			else 
 			        			{
// 	 			        			echo "<br>Delete op #1.";
	 			        			$personAssignmentUpdater->deleteEntry();	
	 			        			$reportDataDump .= 'Deleting record for alternative person ID '.$person_id.$BR.$BR;	
 			        			}
	 			        			
							}
							else
							{
//  			        			echo "<br>TO BE DELETED FROM cim_hrdb_emerg: person_id = ".$person_id.", campus_id = ".$campus_id."<br>";
 			        			$personAssignmentUpdater->deleteEntry();	
 			        			$reportDataDump .= 'Deleting record for alternative person ID '.$person_id.$BR.$BR;							
		        			}
		      
	        			}		        		   
	        			
	        			next($campus_assign_array2);
        			}	        			       			
         
 					/*** Update the Registrations table	(cim_reg_registration)  **/
 					/** NOTE: Currenlty only use step 2, which simply replace associated person IDs with active person ID **/
					// Step 1)  Find the information stored for the active person_id
// 					$regRecordsArray = array();
// 					$idx = 0;
// 					
// 					$registration_manager = new RowManager_RegistrationManager();
// 					$registration_manager->setPersonID($savedPersonID);
// 					$registration_manager->setSortOrder( 'registration_id' );
// 		 			$registration_manager->setAscDesc( 'DESC' ); 	// sort by descending registration IDs
// 					
// //  					echo "<BR>".$savedPersonID.",";

// 					$registrationData = $registration_manager->getListIterator();
// 	    			$regs_array = $registrationData->getDataList();	
// 	        		reset($regs_array);		       		
// 	        		foreach(array_keys($regs_array) as $id)
//      				{
// 	        			$record = current($regs_array);	
// 	        			
// 	        			$reg_id = $record['registration_id'];
// // 	        			$registration_info = array();
// 	        				        			
// // 			      	$fields = page_PersonRecordCleanUp::REGISTRATION_RECORD_FIELDS;
// // 			     		$fieldsArray = explode(",",$fields);	
// // 			        		
// // 			     		// store the campus assignment values in an array
// // 			     		reset($fieldsArray);
// // 			     		foreach(array_keys($fieldsArray) as $k)
// // 						{
// // 			     			$fieldName = current($fieldsArray);	
// // 			     			
// // 			        		$registration_info[$fieldName] = $record[$fieldName];		        				       		
// // 			     			
// // 			     			next($fieldsArray);
// // 			  			}	        			
// 	        			
// 	        			// store array of record values in array with assign_id as key
// // 	        			$regRecordsArray[$reg_id] = $registration_info;
// 						$regRecordsArray[$idx++] = $reg_id;
// 	        			
// 	        			next($regs_array);
//         			}	   
//         			
//          		// TEST CONDITION       			
//         			if (count($regs_array) > 0)
//         			{
// 	        			echo "<br>Registration ids for active person_id ".$savedPersonID.": <pre>".print_r($regRecordsArray,true)."</pre><br>"; 
//      				}	
     				
     				// TODO??: convert the code below to delete registration records that appear under same person_id (obviously with same event_id)
// 					if (count($regRecordsArray) > 1)	// remove ONLY records with redundant person-campus pairs
// 					{
// 						$campus_ids_list = array(); 
// 						$idx = 0;    				
// 						reset($campusAssignArray);
// 						$row = current($campusAssignArray);
// 						$campus_ids_list[$idx++] = $row['campus_id'];
// 						next($campusAssignArray);	// keep the first record (most recent emerg_id)
// 						
// 		        		foreach(array_keys($campusAssignArray) as $m)
// 	     				{
// 		        			$record = current($campusAssignArray);
// 		        			
// 		        			$assignID = key($campusAssignArray);
// 		        			
// // 		        			echo "REMOVE person-campus entry for person_id = ".$savedPersonID." using key = ".key($campusAssignArray);
// 		        			if ((isset($assignID))&&($assignID != ''))
// 		        			{
// 			        			// remove entries having a campus_id already stored for the active person record
// 			        			if (in_array($record['campus_id'], $campus_ids_list))
// 			        			{
// 				        			$assignUpdater = new RowManager_AssignmentsManager($assignID);	
// 	 	 		        			$assignUpdater->deleteEntry();		 	 		        			
//  	 		        			}
//  	 		        			else	// store campus_id so as to remove any other records with this campus_id
//  	 		        			{
// 	 	 		        			$campus_ids_list[$idx++] = $record['campus_id'];
//  	 		        			}
//  		        			}						
// 		        			
// 		        			next($campusAssignArray);
// 	        			}							
// 						
// 					}	

					$reportDataDump .= 'Changes made to <b>cim_reg_registration table</b>: '.$BR;
	    				
        			// Step 2)  Update the registration records having the non-active person ids for this person  (TODO: work from here)
        			$registration_manager2 = new RowManager_RegistrationManager();							
					$registration_manager2->addSearchCondition('person_id in ('.$person_ids_list.')');
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
	        			
	        			if ($personID != $savedPersonID)		// replace associated person_ids with active person_id (NO DELETION)
	        			{    
// 		        			echo "FOUND person ".$personID;
		        			$registration_id = $record['registration_id'];
// 		        			$event_id = $record['event_id'];
		        			
		        			$regRecordUpdater = new RowManager_RegistrationManager($registration_id);
// 		        			$personEmergUpdater->setPersonEmergID($emerg_id);
		        			
// 							if (count($regRecordsArray) < 1)	// if active person ID doesn't have record yet, then update older record with active person ID
// 							{									
// 								$record['person_id'] = $savedPersonID;	// require this to actually change person ID
								
// 								// only create a new record with active person id if the event_id not associated with the person yet
// 								if (!in_array($event_id, $eventIDs))
// 								{											 			        			
				        			// update the person ID for an campus assignment record (in database)
				        			$updateValues = array();
				        			$updateValues['person_id'] = $savedPersonID;	
				        			$regRecordUpdater->loadFromArray( $updateValues );
	 			        			$regRecordUpdater->updateDBTable();
	 			        			$reportDataDump .= 'Found registration record for alternative ID of person ID '.$savedPersonID.','.$BR;
	 			        			$reportDataDump .= 'updating person ID for person ID '.$personID.$BR.$BR;
	 			        			
// 	 			        			$eventIDs[$idx++] = $event_id;
//  			        			}
//  			        			else 
//  			        			{
// 	 			        			echo "<br>Delete op #1.";
// 	 			        			$regRecordUpdater->deleteEntry();		
//  			        			}
	 			        			
// 							}
// 							else
// 							{
//  			        			echo "<br>TO BE DELETED FROM cim_reg_registration: person_id = ".$personID.", event_id = ".$event_id."<br>";
//  			        			$regRecordUpdater->deleteEntry();								
// 		        			}
		      
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
// 	        		reset($staff_array);		       		
// 	        		foreach(array_keys($staff_array) as $id)
//      				{
// 	        			$record = current($staff_array);	
// 	        			
// 	        			$staff_id = $record['staff_id'];
// 						$staffRecordsArray[$idx++] = $staff_id;
// 	        			
// 	        			next($staff_array);
//         			}	   
        			
         		// TEST CONDITION       			
//         			if (count($staff_array) > 0)
//         			{
// 	        			echo "<br>Staff info for active person_id ".$savedPersonID.": <pre>".print_r($staff_array,true)."</pre><br>"; 
//      				}
     					
     				$reportDataDump .= 'Changes made to <b>cim_hrdb_staff table</b>: '.$BR;
     				
     				// Step 2) Remove all but one of the staff records
					if (count($staff_array) > 1)	// remove ONLY records with redundant person-campus pairs
					{				
						reset($staff_array);
						next($staff_array);	// keep the first record (most recent staff_id for active person)
						$reportDataDump .= 'Saving the first staff record associated with person ID '.$savedPersonID.$BR.$BR;
						
// 						echo 'staff array = <pre>'.print_r($staff_array,true).'</pre>';
		        		foreach(array_keys($staff_array) as $m)
	     				{
		        			$record = current($staff_array);
		        			$staffID = key($staff_array);
		        			
			        		// remove redundant entry
		        			$staffUpdater = new RowManager_StaffManager($staffID);	
	 		        		$staffUpdater->deleteEntry();	
	 		        		$reportDataDump .= 'Deleting redundant staff record having staff ID '.$staffID.$BR.$BR;	 	 		        							

		        			$id = next($staff_array);	// staff ID
        					if ($id === FALSE)
        					{
	        					break;	// no valid data found so break out of the loop
        					}
	        			}							
						
					}	
	    				
        			// Step 3)  Delete the staff records having the non-active person ids for this person
        			$staff_manager2 = new RowManager_StaffManager();							
					$staff_manager2->addSearchCondition('person_id in ('.$person_ids_list.')');
		 			$staff_manager2->setSortOrder( 'person_id' );
		 			$staff_manager2->setAscDesc( 'DESC' ); 	// sort by descending person IDs
		 					 
	    			$staffData2 = $staff_manager2->getListIterator();
	    			$staff_array2 = $staffData2->getDataList();	
	
					$toUpdate = false;
					if ( count($staff_array) < 1 )
					{
						$toUpdate = true;
					}

	        		reset($staff_array2);		        		
	        		foreach(array_keys($staff_array2) as $l)
     				{
	        			$record = current($staff_array2);	
	        			$personID = $record['person_id'];
	        			
	        			if ($personID != $savedPersonID)
	        			{    
		        			$staff_id = $record['staff_id'];	
		        			$staffUpdater = new RowManager_StaffManager($staff_id);
		        			
							if ($toUpdate == true)	// if active person ID doesn't have record yet, then update older record with active person ID
							{									
// 								$record['person_id'] = $savedPersonID;	// require this to actually change person ID
									 			        			
			        			// update the person ID for a staff record (in database)
			        			$updateValues = array();
			        			$updateValues['person_id'] = $savedPersonID;	
			        			$staffUpdater->loadFromArray( $updateValues );
 			        			$staffUpdater->updateDBTable();		
 			        			$toUpdate = false;    
 			        			
 			        			$reportDataDump .= 'No record found for person ID '.$savedPersonID.', updating person ID for person ID '.$personID.$BR.$BR;    			
							}
							else
							{
//  			        			echo "<br>TO BE DELETED FROM cim_hrdb_staff: person_id = ".$person_id.", staff_id = ".$staff_id."<br>";
 			        			$staffUpdater->deleteEntry();
 			        			$reportDataDump .= 'Deleting record for alternative person ID '.$personID.$BR.$BR;								
		        			}
		      
	        			}		        		   
	        			
	        			next($staff_array2);
        			}
        						  							
										
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
	        			
	        			if ($personID != $savedPersonID)
	        			{    
		        			$personSubGroupID = $record['person_sub_group_id'];
		        			
		        			$personDGUpdater = new RowManager_PersonDGManager($personSubGroupID);
		        			
		        			$dg_id = $record['sub_group_id'];
		        			$campus_id = $record['organization_id'];
		        			
// 		        			echo 'dg-id, campus-id = '.$dg_id.', '.$campus_id.'<br>';
       			
		        			// check to see if identical information was already stored under active person_id
		        			if (isset($dg_campus_array[$dg_id])&&( $dg_campus_array[$dg_id] == $campus_id))
		        			{
			        			$personDGUpdater->deleteEntry();
			        			$reportDataDump .= 'Deleting record for alternative person ID '.$personID.$BR;
			        			$reportDataDump .= 'since it has information already stored for primary person ID '.$savedPersonID.$BR.$BR;
			        			
// 								echo "<br>TO BE DELETED FROM sch_person_sub_group: person_id = ".$personID.", dg = ".$dg_id.", campus = ".$campus_id."<br>";
		        			}
							else //if ($dg_campus_array[$dg_id] != $campus_id)
		        			{
			        			$updateValues = array();
			        			$updateValues['person_id'] = $savedPersonID;	// just to make sure...
			        			$updateValues['sub_group_id'] = $record['sub_group_id'];
			        			$updateValues['organization_id'] = $record['organization_id'];
			        			
//          						echo "<br>update values from ".$personID.": <pre>".print_r($dg_campus_array,true)."</pre><br>"; 	
		
			        			// TODO: deal with case where two non-active person-ids contain identical info (currently both are saved with active person id)
			        			
			        			// update the person ID for a person-DG record (in database)
			        			$personDGUpdater->loadFromArray( $updateValues );
 			        			$personDGUpdater->updateDBTable();
 			        			$reportDataDump .= 'Updating record for alternative person ID '.$personID.$BR;
			        			$reportDataDump .= 'since it has new information: setting person ID to be '.$savedPersonID.$BR.$BR;			        			
		        			}
		      
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
	    			
// 	    			echo 'other person-ids schedule array = <pre>'.print_r($personScheduleArray2,true).'</pre>';		
					
					$toUpdate = false;
					if ( count($schedule_array) < 1 )
					{
						$toUpdate = true;
// 						echo 'Staff update needed';
					}
					
// 					echo 'schedule array = <pre>'.print_r($personScheduleArray2,true).'</pre>';

					$updatePersonID = -1;
	        		reset($personScheduleArray2);		        		
	        		foreach(array_keys($personScheduleArray2) as $l)
     				{
	        			$record = current($personScheduleArray2);	
	        			$personID = $record['person_id'];
	        			
	        			if ($personID != $savedPersonID)
	        			{    
		        			$found_sch_block = $record['schedule_block'];
		        			$schedule_id = $record['schedule_id'];
		        			
		        			$personScheduleUpdater = new RowManager_ScheduleManager($schedule_id);
// 		        			$personScheduleUpdater->setPersonID($personID);	
// 		        			$personScheduleUpdater->setScheduleBlock($found_sch_block);		        			        			
		        			
		        			// if the active person_id DOES NOT HAVE this schedule block, then update record with active person id
// 		        			if (!in_array($found_sch_block, $schedule_array))	// COMMENTED OUT BECAUSE WE DON'T WANT TO MERGE SCHEDULES
// 		        			{
	
							// if the active person_id DOES NOT HAVE **ANY** schedule block, then update record with active person id
							if (($toUpdate == true)||($updatePersonID == $personID))
							{			        			
					        	$updateValues = array();
			        			$updateValues['person_id'] = $savedPersonID;		// NEW VALUE
			        			$updateValues['schedule_block'] = $found_sch_block;	// just to make sure...
			        			
			        			// update the person ID for a person-DG record (in database)
			        			$personScheduleUpdater->loadFromArray( $updateValues );
			        			$personScheduleUpdater->updateDBTable();	
			        			
			        			if ($toUpdate == true)
			        			{
				        			$toUpdate = false;
				        			$updatePersonID = $personID;	// set person ID whose schedule blocks to use for updating
	
			        				$reportDataDump .= 'No schedule block found for person ID '.$savedPersonID.','.$BR;
			        				$reportDataDump .= 'updating using schedule blocks from person ID '.$updatePersonID.$BR.$BR;				        			
			        			}        			
		        			}
		        			else	// delete the redundant record
		        			{
// TODO: enable this code at mid-April 2008
// 			        			$personScheduleUpdater->deleteEntry();
// 			        			$reportDataDump .= 'Deleting record for alternative person ID '.$personID.$BR.$BR;
			        			
			        			// TODO: deal with case where two non-active person-ids contain identical info 
			        			// (currently both are saved with active person id)			        			
 		        			}			        					        					      
	        			}		        		   
	        			
	        			next($personScheduleArray2);
        			}	  
        			
			  
					/*** Remove all person records other than the active person ID (most often the one used in most-recent login) ***/  
					$personIDs = explode(',', $person_ids_list);
					foreach( array_values($personIDs) as $personID) 
					{		 
						if ($personID != $savedPersonID)
						{
							$personUpdater = new RowManager_PersonManager($personID);	
							$personUpdater->deleteEntry();
							$reportDataDump .= 'Deleting redundant <b>cim_hrdb_person</b> record having person ID '.$personID.$BR;	
						}
						next($personIDs);
					}        			
   			

				}  // end if (isset($indivDataArray)) 
				
				$reportDataDump = substr($reportDataDump, 0, -4);	// remove the last <BR>			 											          
	         $reportDataDump .= $HR;				 
				
				next($personDataArray);
			}			

	
							
						   
 				$this->template->set('reportDataDump', $reportDataDump );
			

			 
			         
        // store the Row Manager's XML Node Name
//         $this->template->set( 'rowManagerXMLNodeName', RowManager_ReceiptManager::XML_NODE_NAME );
        
        // store the primary key field name for the data being displayed
//         $this->template->set( 'primaryKeyFieldName', 'ccreceipt_sequencenum');


        /*
         *  Set up any additional data transfer to the Template here...
         */
        
   
        $templateName = 'page_PersonRecordCleanUp.tpl.php';
		// if you are creating a custom template for this page then 
		// replace $templateName with the following:
		//$templateName = 'page_DisplayCCtransactionReceipt.php';
								        
	        // send CC transaction confirmation e-mail (but first remove links)
// 		$link_regex = '{<a.*?</a>}';	
// 		$message_body = $this->template->fetch( $templateName );
// 		$message_body = preg_replace( $link_regex, '', $message_body);
// 		
// 		if (!defined('IGNORE_EMAILS'))
// 		{	  
// 			$this->sendCCTransactionEmail($message_body);		
// 		}
		
		return $this->template->fetch( $templateName );
        
    }
    
    /** Take a CSV list of person IDs 
        and return an array of person IDs keyed to viewer_id 
        (if association exists) **/
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
		
     	// checks for empty fields in a generic record specified by a CSV fields listing 
  		// and returns array indicating which fields are empty
  		private function checkRecordFields($record, $fields)
  		{
     		$flagArray = array();
     		
//      		$fields = page_PersonRecordCleanUp::EMERG_RECORD_FIELDS;
     		$fieldsArray = explode(",",$fields);	
        		
     		reset($fieldsArray);
     		foreach(array_keys($fieldsArray) as $k)
			{
     			$fieldName = current($fieldsArray);	
     			
     			// default == field is empty; check to see if it really is empty
     			$flagArray[$fieldName] = '0';
//      			echo "person field = ".$person_record[$fieldName];
     			if (($record[$fieldName] != '') && ($record[$fieldName] != '0'))
     			{
        			$flagArray[$fieldName] = '1';	// indicate field has a non-empty/non-default value
  				}			        				       		
     			
     			next($fieldsArray);
  			}
  			
  			return $flagArray;
		}  
		
     	// initializes fields in a generic record specified by a CSV fields listing 
  		// and returns the record (as an array with field names as keys)
  		private function initRecord($fields)
  		{
     		$record = array();
     		
//      		$fields = page_PersonRecordCleanUp::EMERG_RECORD_FIELDS;
     		$fieldsArray = explode(",",$fields);	
        		
     		reset($fieldsArray);
     		foreach(array_keys($fieldsArray) as $k)
			{
     			$fieldName = current($fieldsArray);	
     			
     			// default == field is empty
     			$record[$fieldName] = '';	        				       		
     			
     			next($fieldsArray);
  			}
  			
  			return $record;
		}  				
    
  
    // sends CC transaction confirmation e-mail off to certain HQ folks
    private function sendCCTransactionEmail($msgTxt = '')		
    {
	    // retrieve basic confirmation e-mail info.
	    $RECIPIENTS = 'jocelyn.veer@crusade.org, rita.klassen@crusade.org';
	    $SUBJECT = 'Campus for Christ Credit Card Transaction Received';
	    $FROM = 'registration@campusforchrist.org';
	    
	    $success = false;
	    
	    if ($msgTxt != '')
	    {
		     $message = '<html>';	//<head>Credit Card Transaction Receipt</head>';
		     $message .= '<body>';	   
       	  $message .= $msgTxt;  
       	  $message .= "</body></html>";                    

	        $headers = 'MIME-Version: 1.0' . "\r\n";
	        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	        $htmlBreak = '<br/>';     	           
	       
	       $message = wordwrap($message, 70);       
// 	
// 	       $headers .= 'From: '.$FROM . "\n" .
// 				'Reply-To: '.$FROM . "\n" .
// 				'X-Mailer: PHP/' . phpversion();

			 $headers = "From: C4C Registration System <".$FROM.">\n" .
					      "MIME-Version: 1.0\n" .
					      "Content-type: text/html; charset=iso-8859-1\n" .
					      'X-Mailer: PHP/' . phpversion();
	
	// 				echo "<BR>HEADERS: ".$headers;								
	// 				echo "TO: ".$to;
	// 				echo "<br>SUBJECT: ".$subject;
	// 				echo "<BR>MESSAGE: ".$message;
	
			 ini_set('SMTP', EMAIL_SMTP_SERVER);
			 ini_set('smtp_port', EMAIL_SMTP_PORT);
	
	       $success = mail( $RECIPIENTS, $SUBJECT, $message, $headers  );
       }
       
       if ( !$success )
       {
           return 'Error Sending Confirmation E-mail!';		// TODO: replace with a label
       }    	
       else
       {
	        return 'Confirmation E-mail Successfully Sent';	// TODO: replace with a label
        }   

    }
        
      
}

?>