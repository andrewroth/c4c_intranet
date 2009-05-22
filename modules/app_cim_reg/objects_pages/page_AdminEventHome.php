<?php
/**
 * @package cim_reg
 */ 
 
 // First load the common Registration Summaries Tools object
// This object allows for efficient access to registration summary data (multi-table).
$fileName = 'Tools/tools_RegSummaries.php';
$path = Page::findPathExtension( $fileName );

$testName = 'Tools/tools_Finances.php';
$testPath = Page::findPathExtension( $testName );
require_once( $testPath.$testName);

require_once( $path.$fileName);

/**
 * class page_AdminEventHome 
 * <pre> 
 * Administrative home page for one of the events
 * </pre>
 * @author Russ Martin
 * Date:   20 Feb 2007
 */
 // RAD Tools: Custom Page
class  page_AdminEventHome extends PageDisplay {

	//CONSTANTS:
    
    /** The Multilingual Page Key for labels on this page */
    const MULTILINGUAL_PAGE_KEY = 'page_AdminEventHome';
    

	//VARIABLES:
	
	/** @var [OBJECT] The viewer object. */
	protected $viewer;
	
	protected $event_id;		// the event ID associated with the event admin home
	
    /** @var [STRING] The path to this module's root directory. */
	protected $pathModuleRoot;
	
    /** @var [INTEGER] The status of the recalculation of balances owing (see FinancialTools for constants) */
	protected $recalcStatus;

	/** @var [ARRAY] An array storing all the registration summary data column headings **/
	protected $summary_headings;	
		
	/** @var [ARRAY] An array storing all the registration summary data row-arrays, indexed by campus-name **/
	protected $summary_data;
	
	/** @var [ARRAY] An array storing all the meta summary data total headings **/	
// 	protected $meta_headings;

	/** @var [ARRAY] An array storing all the sum totals for all the campus-specific registration totals **/	
	protected $summaryTotals;
	

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
    function __construct($pathModuleRoot, $viewer, $eventID, $recalcStatus = FinancialTools::RECALC_NOTNEEDED, $campus_link = '' ) 
    {
    
        parent::__construct();
        
        // initialzie the object values
        $this->pathModuleRoot = $pathModuleRoot;
        $this->viewer = $viewer;
        $this->event_id = $eventID;
        $this->recalcStatus = $recalcStatus;
        
                	           // get privileges for the current viewer
        $privManager = new PrivilegeManager( $this->viewer->getID() ); 
        
        $regSummaries = new RegSummaryTools();    
        
//       	$is_campus_admin = false;
         if ($privManager->isBasicAdmin($this->event_id)==true)	// check if privilege level is high enough
         { 
	              
	         /** Set the summary data headings (used only for generating PDF) **/
	         $this->summary_headings = array();
				$this->summary_headings[0]='Campus';
				$this->summary_headings[1]='Admin';
				$this->summary_headings[2]='Males';
				$this->summary_headings[3]='Females';
				$this->summary_headings[4]='Total';
				$this->summary_headings[5]='Cancellations';
				$this->summary_headings[6]='Completed';
				$this->summary_headings[7]='Incomplete';
     	             
	      	/** RETRIEVE CAMPUS REGISTRATION SUMMARY DATA ***/
	      	//TODO?: put some/all of this into a helper method
	      	
	      	// initialized template arrays
	      	$campusLevelLinks = array();
	      	$this->summaryTotals = array();
	      	$this->summaryTotals['label'] = '';
				$this->summaryTotals['blank'] = '';		// 'Registrations' link has no need for a total...
	   	   $this->summaryTotals['numMales'] = 0;
	     		$this->summaryTotals['numFemales'] = 0;
	     		$this->summaryTotals['campusTotal'] = 0;
	     		$this->summaryTotals['cancellations'] = 0;  				
				$this->summaryTotals['completes'] = 0;	 
				$this->summaryTotals['incompletes'] = 0;	  
	     		
	     		/* Get all campuses (affiliated with the admin's country) */
// 	     		$campuses = new RowManager_CampusManager();
// 	     		$campuses->setSortOrder('campus_desc');
// 	     		$campusList = $campuses->getListIterator();
// 	     		$campusArray = $campusList->getDataList();

				$country_campuses = new MultiTableManager();
				
			   $events = new RowManager_EventManager();
			   $events->setEventID($this->event_id);
			   $campuses = new RowManager_CampusManager();
			   $regions = new RowManager_RegionManager();
			   $countries = new RowManager_CountryManager();
			  
			   $country_campuses->addRowManager($campuses);
			   $country_campuses->addRowManager($regions, new JoinPair($regions->getJoinOnRegionID(), $campuses->getJoinOnRegionID()));
			   $country_campuses->addRowManager($countries, new JoinPair($countries->getJoinOnCountryID(), $regions->getJoinOnCountryID()));
			   $country_campuses->addRowManager($events, new JoinPair($events->getJoinOnCountryID(), $countries->getJoinOnCountryID()));
			   $country_campuses->setSortOrder('campus_desc');
			   
			   $countryList = $country_campuses->getListIterator();
			   $campusArray = $countryList->getDataList();
			  
	     		reset($campusArray);
// 	     		echo 'campus array = <pre>'.print_r($campusArray,true).'</pre>';

				/** JANUARY 25, 2008    (HSMIT) added $campusList to all getCampusRegistrations() calls below
				                                to match registration campuses with event-affliated country's campus list 
				                                
				    ALSO: had to add somewhat redundant pre-processing to get campus list **/
				$campusList = '';
				foreach(array_keys($campusArray) as $key)
				{
					
					$record = current($campusArray);	
				   $campusList .= $record['campus_id'].',';		// populate CSV for registrations filter
				   next($campusArray);
			   }
			   $campusList = substr($campusList,0,-1);		
			   reset($campusArray);
	      	
	     		// retrieve cancellations (for current event)
	      	$results_cancelled = array();
	      	$results_cancelled  = $regSummaries->getCampusRegistrations( $this->event_id, '', true, $campusList ); 
	      	
	      	// retrieve total registrations and total females registered (for current event)
	      	 $results = array();
	      	 $results_female = array();
	      	 $results = $regSummaries->getCampusRegistrations( $this->event_id, '', false, $campusList );   
	      	 $results_female = $regSummaries->getCampusRegistrations( $this->event_id, 'female', false, $campusList );   
	      	 
	      	// retrieve total complete registrations and total incomplete registrations (for current event)
	      	 $results_complete = array();
	      	 $results_incomplete = array();
	      	 $results_complete = $regSummaries->getCampusRegistrations( $this->event_id, '', false, $campusList, '', RowManager_RegistrationManager::STATUS_REGISTERED );   
	      	 $results_incomplete = $regSummaries->getCampusRegistrations( $this->event_id, '', false, $campusList, '', RowManager_RegistrationManager::STATUS_INCOMPLETE );      	     	 	      	 
	      	 
	//      	 $results = array_merge( $results_male, $results_female );
	      	 reset($results); 
	//      	 reset($results_male);
	//      	 reset($results_female);  	       	 
	
				// go through total registrations in parallel with other results
	      	foreach(array_keys($campusArray) as $k)	//array_keys($results) as $k)
				{
					$total = current($results);
					$regCampusID = key($results);
					$campusID = key($campusArray);	//key($results);
					
					// retrieve campus name given the campus ID
					$campus = new RowManager_CampusManager($campusID);
					$campusName = $campus->getDesc();
					
					// process registration total if it matches the current campus ID
					if ($regCampusID == $campusID) 
					{
						
						// set total valid non-cancelled registrations for current campus (and event)
						if (isset($results_cancelled[$campusID]))	//&&$results_cancelled[$campusName]>0)
						{
							$cancelled = $results_cancelled[$campusID];
// 							$total = $total - $cancelled;
						}
						else 
						{
							$cancelled = 0;
						}
						
						// set total females registered for current campus (and event)
						if (isset($results_female[$campusID])) 
						{
							$females = $results_female[$campusID];					
						}
						else 
						{
							$females = 0;
						}
						
						// set total complete registrations for current campus (and event)
						if (isset($results_complete[$campusID])) 
						{
							$completes = $results_complete[$campusID];					
						}
						else 
						{
							$completes = 0;
						}
						
						// set total incomplete registrations for current campus (and event)
						if (isset($results_incomplete[$campusID])) 
						{
							$incompletes = $results_incomplete[$campusID];					
						}
						else 
						{
							$incompletes = 0;
						}												
							
		//				$females = current($results_female);
		//				$males = $results_male[$campusName];
		
						// set total registered males
						$males = $total - $females;	//current($results_male);//				
		
		        		       		
		//        		echo $campusName.': '.$total.' : '.$males.' : '.$females.'<br>';
		//        		echo 'cancelled : '.$cancelled.'<br>';
		        		
		        		// set registration summary values for current campus
		        		$aCampus = array();
		        		$aCampus['campus_desc'] = $campusName;
		        		$aCampus['regLink'] = '#';	//$this->linkValues[ 'CampusLink' ].$campusID;//$this->event_id."_".$campusID;
		        		$aCampus['numMales'] = $males;
		        		$aCampus['numFemales'] = $females;
		        		$aCampus['campusTotal'] = $total;
		        		$aCampus['cancellations'] = $cancelled;
		        		$aCampus['completes'] = $completes;
		        		$aCampus['incompletes'] = $incompletes;
		        		
// 		        		$summaryTotals['numMales'] += $males;
// 		        		$summaryTotals['numFemales'] += $females;
// 		        		$summaryTotals['campusTotal'] += $total;
// 		        		$summaryTotals['cancellations'] += $cancelled;	
		        		
		        		next($results);	   // increment array-pointer for registration totals array     		
	        		}
	        		else		// set default values for campus registration summary
	        		{

		        				        		// set registration summary values for current campus
		        		$aCampus = array();
		        		$aCampus['campus_desc'] = $campusName;
		        		$aCampus['regLink'] = '#';	//$this->linkValues[ 'CampusLink' ].$campusID;//$this->event_id."_".$campusID;
		        		$aCampus['numMales'] = 0;
		        		$aCampus['numFemales'] = 0;
		        		$aCampus['campusTotal'] = 0;
		        		$aCampus['cancellations'] = 0;
		        		$aCampus['completes'] = 0;
		        		$aCampus['incompletes'] = 0;		        		
					}	
							
	        		
	 //       		        $editLink = $this->getCallBack( modulecim_reg::PAGE_ADMINEVENTHOME, $this->sortBy, $parameters );
	 //       $editLink .= "&". modulecim_reg::REG_ID . "=";
	 //       CampusLink
	        
		         if ($privManager->isCampusAdmin($this->event_id,$campusID)==true)	// check if privilege level is high enough
		         { 	        		
		        		$aCampus['regLink'] = $campus_link.$campusID;	// $this->linkValues[ 'CampusLink' ].$campusID;		
	        		}
	        		
	        		// <START> USED TO BE INSIDE CAMPUS ADMIN PRIV. CHECK
	        		// BUT NOW ALL CAMPUS ADMINS CAN SEE SUMMARY DATA... ONLY REGISTRATION LINKS NOT SHOWN FOR INVALID CAMPUSES
	        		// store campus summary info in array indexed by campus name
 	        		$campusLevelLinks[$campusName] = $aCampus;
// 	        		if ($is_campus_admin == false) {
// 		        		$this->template->set('isCampusAdmin', true);
// 		        		$is_campus_admin = true;
// 	        		}
	        		// <END>
	        		

					
					next($campusArray);
	//				next($results_female);
	//				next($results_male);
				}
				
				$this->summary_data = $campusLevelLinks; 
				
				
				/*** END CAMPUS REGISTRATION SUMMARY DATA RETRIEVAL ***/  
				
				
				/**** SET TOTAL  *UNIQUE*  REGISTRATIONS *******/
				$totalRegs = array();
				$totalRegs = $regSummaries->getUniqueRegistrations($this->event_id);  
				
// 				echo "Total unique regs: ".count($totalRegs); 
				  
				$femaleRegs = array();
				$gender = 'female';
				$femaleRegs = $regSummaries->getUniqueRegistrations($this->event_id, $gender);  
				
// 				echo "<br>Total male regs: ".(count($totalRegs)-count($femaleRegs));   
// 				echo "<br>Total female regs: ".count($femaleRegs);
				  
				$cancelledRegs = array();
				$gender = '';
				$areCancelled = true;
				$cancelledRegs = $regSummaries->getUniqueRegistrations($this->event_id, $gender, $areCancelled);  
				
// 				echo "<br>Total cancelled regs: ".count($cancelledRegs); 

				$completeRegs = array();
				$gender = '';
				$areCancelled = false;
				$status = RowManager_RegistrationManager::STATUS_REGISTERED;
				$completeRegs = $regSummaries->getUniqueRegistrations($this->event_id, $gender, $areCancelled, $status); 
				
				$incompleteRegs = array();
				$gender = '';
				$areCancelled = false;
				$status = RowManager_RegistrationManager::STATUS_INCOMPLETE;
				$incompleteRegs = $regSummaries->getUniqueRegistrations($this->event_id, $gender, $areCancelled, $status); 				
				
				$this->summaryTotals['label'] = 'Total (Unique) Registrations:';
				$this->summaryTotals['blank'] = '';		// 'Registrations' link has no need for a total...
				$this->summaryTotals['numMales'] = count($totalRegs)-count($femaleRegs);
        		$this->summaryTotals['numFemales'] = count($femaleRegs);
        		$this->summaryTotals['campusTotal'] = count($totalRegs);
        		$this->summaryTotals['cancellations'] = count($cancelledRegs);	  				
				$this->summaryTotals['completes'] = count($completeRegs);	 
				$this->summaryTotals['incompletes'] = count($incompleteRegs);	  				
				  
			}       
        
        
        
        // now initialize the labels for this page
        // start by loading the default field labels for this Module
        $languageID = $viewer->getLanguageID();
        $seriesKey = modulecim_reg::MULTILINGUAL_SERIES_KEY;
        $pageKey = page_AdminEventHome::MULTILINGUAL_PAGE_KEY;
        $this->labels = new MultilingualManager( $languageID, $seriesKey, $pageKey );

         
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
	     $regSummaries = new RegSummaryTools();   

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
            
        $event = new RowManager_EventManager($this->event_id);
        $this->labels->setLabelTag( '[Instr]', '[eventName]', $event->getEventName());      


        // NOTE:  this parent method prepares the $this->template with the 
        // common Display data.  
        $this->prepareTemplate($path);
        
        // pass in the labels for the outer template
//		$labels = new MultiLingual_Labels( GPC_SITE_LABEL, GPC_SERIES_LABEL, TEMPLATE_PAGE, $langID );
//		$page->set('labels', $labels );


        	           // get privileges for the current viewer
        $privManager = new PrivilegeManager( $this->viewer->getID() );  						        
        if ($privManager->isEventAdmin($this->event_id)==true)	// check if privilege level is high enough
        { 
	        $this->template->set('isEventAdmin', true);
	
	        // display messages based on balance owing recalculation status
	        switch ($this->recalcStatus)
	        {
		        // display balance owing recalculation COMPLETED message
		        case FinancialTools::RECALC_COMPLETE:
			        $this->template->set('isRecalculated', true);
			        $completedMsg = $this->labels->getLabel('[RecalcCompleteMsg]');
			        $this->template->set('recalcMessage', $completedMsg);
			        break;
		        
			        // display balance owing recalculation NEEDED message
			     case FinancialTools::RECALC_NEEDED:
			        $this->template->set('needsRecalculation', true);
			        $completedMsg = $this->labels->getLabel('[RecalcNeededMsg]');
			        $this->template->set('recalcMessage', $completedMsg);
			        break;
			        
			     default:
			     	  break;
	        }  
        }
        
        $this->template->set('backLink', $this->linkValues[ 'BackLink' ]);


		//$superAdminPrefix = 'superAdmin_';
	    //$this->template->set('superAdminPrefix', $superAdminPrefix );
        
        $superAdminLevelLinks = array();
        $campusLevelLinks = array();
        $eventLevelLinks = array();
        $financeLevelLinks = array();
                     
        if ($privManager->isSuperAdmin()==true)	// check if privilege level is high enough
        { 
	        $this->template->set('isSuperAdmin', true);

	        //Super Admin Level links (order is important == viewing order)
	        $superAdminLevelLinks[ 'AddSuperAdmins' ]  = $this->linkValues[ 'AddSuperAdmins' ]; 
	        $superAdminLevelLinks[ 'EditPrivilegeTypes' ]  = $this->linkValues[ 'EditPrivilegeTypes' ]; 
	        $superAdminLevelLinks[ 'EditFieldTypes' ]  = $this->linkValues[ 'EditFieldTypes' ];
	        $superAdminLevelLinks[ 'EditPriceRuleTypes' ]  = $this->linkValues[ 'EditPriceRuleTypes' ];
	        $superAdminLevelLinks[ 'EditCreditCardTypes' ]  = $this->linkValues[ 'EditCreditCardTypes' ];
	        $superAdminLevelLinks[ 'EditStatusTypes' ]  = $this->linkValues[ 'EditStatusTypes' ];
	        
	        $this->template->set('superAdminLevelLinks', $superAdminLevelLinks );
        }
         
        
        //Campus Level links
      
        /** TODO: move the below code into an earlier page and pass on priv. info OR put in helper function ***/
        /** ALSO: make use of this or similar code for restricting access to campus-level registrations **/
        
      	/** CHECK PRIVILEGE LEVEL IN ORDER TO DETERMINE WHICH CAMPUS REGISTRATION LINKS TO SHOW **/
//         $viewer_id = $this->viewer->getViewerID();
//         $accessAll = false;
//         $accessCampuses = array();
//         
//         $superAdmin = new RowManager_SuperAdminAssignmentManager();
//         $superAdmin->setViewerID($viewer_id);
//         $superAdminList = new ListIterator($superAdmin);	
//   		  $superAdminArray = $superAdminList->getDropListArray();
// //     		echo "super: <pre>".print_r($superAdminArray, true)."</pre>";
//      		
// 			// all campuses can be accessed if user/viewer is super-admin
//         if (count($superAdminArray) > 0)
//         {
// 	        $accessAll = true;
//         }
//         else	// check if viewer is finance-level, event-level, or campus-level admin
//         {
// 	        // TODO: retrieve these constants from the database using PrivilegeTypeManager
// 	         $EVENT_LEVEL = 3;
// 	         $FINANCE_LEVEL = 2;
// 	         $CAMPUS_LEVEL = 4;
// 	         
// 	         $eventAdmin = new RowManager_EventAdminAssignmentManager();
//         		$eventAdmin->setEventID($this->event_id);
//         		$eventAdmin->setViewerID($viewer_id);
//         		$eventAdmin->setPrivilege($EVENT_LEVEL." or ".$FINANCE_LEVEL);
//         		$eventAdminList = new ListIterator($eventAdmin);	
//         		$eventAdminArray = $eventAdminList->getDropListArray();
// //        		echo "eventAdmin: <pre>".print_r($eventAdminArray, true)."</pre>";

// 				// grant access to all campuses if viewer is event-level or finance-level admin
//         		if (count($eventAdminArray) < 0)
//         		{
// 	        		$accessAll = true;
//   				}
//   				else 	// TODO: retrieve campus list if viewer has campus-level admin privileges
//   				{
// 	  				$eventAdmin2 = new RowManager_EventAdminAssignmentManager();
// 	        		$eventAdmin2->setEventID($this->event_id);
// 	        		$eventAdmin2->setViewerID($viewer_id);
// 	  				$eventAdmin2->setPrivilege($CAMPUS_LEVEL);
// 	        		$eventAdminList2 = new ListIterator($eventAdmin2);	
// 	        		$eventAdminArray2 = $eventAdminList2->getDropListArray();
// //	        		echo "eventAdmin2: <pre>".print_r($eventAdminArray2, true)."</pre>";	        		
//         		}

//         		
//       	}  
      	/** END PRIVILEGE CHECKING **/
      	
//       	$is_campus_admin = false;
         if ($privManager->isBasicAdmin($this->event_id)==true)	// check if privilege level is high enough
         {      	
      		$this->template->set('isCampusAdmin', true);
	         

      		/** HSMIT, Dec 6, 2007: MOVED REG SUMMARY DATA RETRIEVAL TO CONSTRUCTOR **/
      		$campusLevelLinks = $this->summary_data;
      		
				
				/*** END CAMPUS REGISTRATION SUMMARY DATA RETRIEVAL ***/   
				
				$this->template->set('linkText', 'Registrations');
				$this->template->set('campusLevelLinks', $campusLevelLinks );
			
				/** HSMIT: Dec 13, 2007: MOVED REG SUMMARY TOTALS TO CONSTRUCTOR **/  	
							
				$this->template->set('summaryTotals', $this->summaryTotals );
			}

						        
        if ($privManager->isEventAdmin($this->event_id)==true)	// check if privilege level is high enough
        { 
        
	        //Event Level links
	        $eventLevelLinks[ 'DownloadSummary' ] = $this->linkValues[ 'DownloadSummary' ];
	        $eventLevelLinks[ 'EmailRegistrants' ] = $this->linkValues[ 'EmailRegistrants' ];
	        $eventLevelLinks[ 'AddEventAdmins' ]  = $this->linkValues[ 'AddEventAdmins' ];
	        $eventLevelLinks[ 'AddCampusAdmins' ]  = $this->linkValues[ 'AddCampusAdmins' ];
	        $eventLevelLinks[ 'RecalculateBalances' ]  = $this->linkValues[ 'RecalculateBalances' ];
	        $eventLevelLinks[ 'EditEventDetails' ]  = $this->linkValues[ 'EditEventDetails' ];
	        $eventLevelLinks[ 'EditEventFormFields' ]  = $this->linkValues[ 'EditEventFormFields' ];
	        $eventLevelLinks[ 'EditEventPriceRules' ]  = $this->linkValues[ 'EditEventPriceRules' ];
	        $eventLevelLinks[ 'EventDataDump' ]  = $this->linkValues[ 'EventDataDump' ];
	        $eventLevelLinks[ 'EventScholarshipList' ]  = $this->linkValues[ 'EventScholarshipList' ];
	        $this->template->set('eventLevelLinks', $eventLevelLinks );
	        
	        //$editEventDetailsLink = $this->linkValues[ 'editEventDetailsLink' ];
	        //$this->template->set('editEventDetailsLink', $editEventDetailsLink );
        }
        
        if ($privManager->isFinanceAdmin($this->event_id)==true)	// check if privilege level is high enough
        { 
	        $this->template->set('isFinanceAdmin', true);
        
        //Finance Level links
        
  			}
    
        
        
        // uncomment this line if you are creating a template for this page
		$templateName = 'page_AdminEventHome.php';
		// otherwise use the generic site template
		//$templateName = '';
		
		return $this->template->fetch( $templateName );
        
    }
    
    
    /**
     *  function getMetaSummaryHeadings
     *  
     * @return [ARRAY]/[BOOLEAN]   array containing registration meta-summary data column headings
     *                             or FALSE if array is not set
     */    
//     function getMetaSummaryHeadings()
//     {
// 	    if (isset($this->meta_headings))
// 	    {
// 		    return $this->meta_headings;
// 	    }
// 	    else
// 	    {
// 		    return false;
// 	    }
//     }   	    

    /**
     *  function getMetaTotalsData
     *  
     * @return [ARRAY]/[BOOLEAN]   array containing totals of all campus-specific registration summary data totals
     *                             or FALSE if array is not set
     */
    function getMetaSummaryData()
    {
	    if (isset($this->summaryTotals))
	    {
		    return $this->summaryTotals;
	    }
	    else
	    {
		    return false;
	    }
    }    
    
    /**
     *  function getSummaryData
     *  
     * @return [ARRAY]/[BOOLEAN]   array containing registration summary data indexed by campus name
     *                             or FALSE if array is not set
     */
    function getSummaryData()
    {
	    if (isset($this->summary_data))
	    {
		    return $this->summary_data;
	    }
	    else
	    {
		    return false;
	    }
    }
    
    /**
     *  function getSummaryHeadings
     *  
     * @return [ARRAY]/[BOOLEAN]   array containing registration summary data column headings
     *                             or FALSE if array is not set
     */
    function getSummaryHeadings()
    {
	    if (isset($this->summary_headings))
	    {
		    return $this->summary_headings;
	    }
	    else
	    {
		    return false;
	    }
    }    
       	
	
}

?>