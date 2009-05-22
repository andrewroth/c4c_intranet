<?php
/**
 * @package cim_stats
 */ 
/**
 * class page_StaffSemesterReport 
 * <pre> 
 * Shows the stats for a staff from a semester at a glance.
 * </pre>
 * @author Russ Martin
 * Date:   23 Nov 2006
 */
 // RAD Tools: Custom Page
class  page_StaffSemesterReport extends PageDisplay {

	//CONSTANTS:
    
    /** The Multilingual Page Key for labels on this page */
    const MULTILINGUAL_PAGE_KEY = 'page_StaffSemesterReport';
    

	//VARIABLES:
	
	/** @var [OBJECT] The viewer object. */
	protected $viewer;
	
    /** @var [STRING] The path to this module's root directory. */
	protected $pathModuleRoot;
	
	protected $staff_id;
	protected $campus_id;
	
	protected $semester_id;
	
	protected $campusListIterator;
	protected $semesterListIterator;
	
	protected $person_id;
	
	protected $permManager;
	

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
    function __construct($pathModuleRoot, $viewer, $staff_id, $campus_id, $semester_id ) 
    {
    
        parent::__construct();
        
        // initialzie the object values
        $this->pathModuleRoot = $pathModuleRoot;
        $this->viewer = $viewer;
        
        // for looking up the person_id of this staff member
        $this->staff_id = $staff_id;
        $staffManager = new RowManager_StaffManager( $this->staff_id );
        // echo 'the staff_id['.$this->staff_id.']<br/>';
        
        $this->permManager = new PermissionManager( $this->viewer->getViewerID() );
        
        // figure out what campuses to display
        $campusManager = new RowManager_CampusManager();
        $multiTableManager = new MultiTableManager();
        $isRT = $this->permManager->isRegional();
        if ( $isRT )
        {
            // get all the campuses across the country
            $multiTableManager->addRowManager( $campusManager );            
        } 
        else
        {
            // get only the campuses the staff is assigned to
            $assignmentManager = new RowManager_AssignmentsManager();
            $this->person_id = $staffManager->getPersonID();
            $assignmentManager->setPersonID( $this->person_id );
            $assignmentManager->setAssignmentStatusID( CA_STAFF );
            
            $multiTableManager->addRowManager($assignmentManager);
            $multiTableManager->addRowManager( $campusManager, new JoinPair( $campusManager->getJoinOnCampusID(), $assignmentManager->getJoinOnCampusID() ) );
        }
        $multiTableManager->setSortOrder('campus_desc');
           
        $this->campusListIterator = $multiTableManager->getListIterator();
        
        if ( $campus_id != '' )
        {
            // echo 'campus_id is SET ['.$campus_id.']<br/>';
            $this->campus_id = $campus_id;
        }
        else
        {
            // set a default campus id
            // echo 'Choosing a default campus<br/>';
            $this->campusListIterator->setFirst();
            if ( $this->campusListIterator->moveNext() )
            {
                $campusObject = $this->campusListIterator->getCurrent(new RowManager_CampusManager());
                $this->campus_id = $campusObject->getID();
            }
            else
            {
                die('ERROR - unable to set campus_id - page_StaffWeeklyReport');
            }
        }
        // echo 'the campus_id['.$this->campus_id.']<br/>';
        
        if ( $semester_id != '' )
        {
            $this->semester_id = $semester_id;
        }
        else
        {
            // set a default semester id
            $this->semester_id = 4;
            // TODO set this properly
            
        }
        // echo 'the semester_id['.$this->semester_id.']<br/>';
        
        
        
        // now initialize the labels for this page
        // start by loading the default field labels for this Module
        $languageID = $viewer->getLanguageID();
        $seriesKey = modulecim_stats::MULTILINGUAL_SERIES_KEY;
        $pageKey = modulecim_stats::MULTILINGUAL_PAGE_FIELDS;
        $this->labels = new MultilingualManager( $languageID, $seriesKey, $pageKey );
        
        $pageKey = page_StaffSemesterReport::MULTILINGUAL_PAGE_KEY;
        $this->labels->loadPageLabels( $pageKey );
         
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
         
        // The weeks
        $weekManager = new RowManager_WeekManager();
        
        $weekManager->setSemesterID( $this->semester_id );
        $weekManager->setSortByDate();
        
        $staffArray = array();
        
        // figure out all the people we want to report on
        $isCD = $this->permManager->isCD();
        if ( $isCD )
        {
            // get all the people from this campus who have reported stats
            
            $wklyReportManager = new RowManager_WeeklyReportManager();
            $wklyReportManager->setCampusID($this->campus_id);
            
            $anotherWeekManager = new RowManager_WeekManager();
            $anotherWeekManager->setSemesterID( $this->semester_id );
            
            $multiTableManager = new MultiTableManager();
            $multiTableManager->addRowManager($wklyReportManager);
                
            $multiTableManager->addRowManager( $anotherWeekManager, new JoinPair( $wklyReportManager->getJoinOnWeekID(), $anotherWeekManager->getJoinOnWeekID() ) );
            
            $this->listIterator = $multiTableManager->getListIterator();
            $this->listIterator->setFirst();
            while( $this->listIterator->moveNext() )
            {
                $reportRow = $this->listIterator->getCurrent(new RowManager_WeeklyReportManager());
                $staffArray[] = $reportRow->getStaffID();
            }
            
            $staffArray = array_unique($staffArray);
            
            // echo '<pre>'.print_r($staffArray, true).'</pre>';
        }
        else
        {
            // just get the stats for the staff viewing the page
            $staffArray[] = $this->staff_id;
        }
        
        $infoArray = array();
        
        foreach ( $staffArray as $indx=>$staffID )
        {
            //IndSemesterInfo
            $indInfo = new IndSemesterInfo();
            
            $staffManager = new RowManager_StaffManager( $staffID );
            $personID = $staffManager->getPersonID();
            $personManager = new RowManager_PersonManager( $personID );
            $personManager->setLabelTemplateLastNameFirstName();
            $indInfo->staffName = $personManager->getLabel();
            $indInfo->staffID = $staffID;
            
            // calendar
            $indInfo->calendar = array();
            $currentMonth = 0;
            
            // actual data
            // dataArray[weekID] = arrayOfData
            $indInfo->dataArray = array();
            
            $weekList = new ListIterator( $weekManager );
            
            $weekList->setFirst();
            while( $weekList->moveNext() )
            {
                $week = $weekList->getCurrent( new RowManager_WeekManager() );
                $weekID = $week->getID();
                
                // setup stuff for the calendar in the report
                $endDate = $week->getEndDate();
                list( $year, $month, $day ) = explode('-', $endDate );
                $month = ltrim($month, "0");
                // $day = ltrim($day, "0");
                if ( $currentMonth != $month )
                {
                    // echo 'start new array<br/>';
                    $currentMonth = $month;
                }
                $indInfo->calendar[ $currentMonth ][ $day ] = $weekID;
                // end calendar stuff
                
                // check if an entry exists in the table for 
                $weeklyReport = new RowManager_WeeklyReportManager( $weekID, $staffID,  $this->campus_id );
                    
                if ( $weeklyReport->isLoaded() )
                {
                    // echo $week->getEndDate() . ' loaded <br/>';
                    
                    $indInfo->dataArray[ $weekID ] = $weeklyReport->getArrayOfValues();
                     
                    // echo '<pre>'.print_r( $weeklyReport->getArrayOfValues() ).'</pre>';
                }
                else
                {
                    $indInfo->dataArray[ $weekID ] = null;
                    // echo $week->getEndDate() . ' NOT loaded <br/>';
                }          
            }
            
            // echo '<pre>'.print_r($calendar,true).'</pre>';
            
            $infoArray[] = $indInfo;
        }

        /*
         * Update any label tags ...
         */
        // example:
            // $name = $user->getName();
            // $this->labels->setLabelTag( '[Title]', '[userName]', $name);

        $campusJumpLinkSelectedValue = $this->linkValues['campusJumpLink'].$this->campus_id;
        $semesterJumpLinkSelectedValue = $this->linkValues['semesterJumpLink'].$this->semester_id;

        // NOTE:  this parent method prepares the $this->template with the 
        // common Display data.  
        $this->prepareTemplate($path);
        
        // $this->template->set( 'calendar', $calendar );
        // $this->template->set( 'dataArray', $dataArray );
        $this->template->set( 'infoArray', $infoArray );
        $this->template->set( 'campusJumpLinkSelectedValue', $campusJumpLinkSelectedValue ); 
        $this->template->set( 'semesterJumpLinkSelectedValue', $semesterJumpLinkSelectedValue );
        
        
        
        // campus list
        $jumpLink = $this->linkValues['campusJumpLink'];
        $campusArray = array();
        $this->campusListIterator->setFirst();
        while( $this->campusListIterator->moveNext() )
        {
            $campusObject = $this->campusListIterator->getCurrent(new RowManager_CampusManager());
            $campusArray[$jumpLink.$campusObject->getID()] = $campusObject->getLabel();
        }
        // echo '<pre>'.print_r($campusArray, true ).'</pre>';
        $this->template->set( 'list_campus_id', $campusArray );
        
        // semester list
        $jumpLink = $this->linkValues['semesterJumpLink'];
        $semesterArray = array();
        $semesterManager = new RowManager_SemesterManager();
        $this->semesterListIterator = $semesterManager->getListIterator();
        $this->semesterListIterator->setFirst();
        while( $this->semesterListIterator->moveNext() )
        {
            $semesterObject = $this->semesterListIterator->getCurrent(new RowManager_SemesterManager());
            $semesterArray[$jumpLink.$semesterObject->getID()] = $semesterObject->getLabel();
        }
        // echo '<pre>'.print_r($campusArray, true ).'</pre>';
        $this->template->set( 'list_semester_id', $semesterArray );    

        // uncomment this line if you are creating a template for this page
		$templateName = 'page_StaffSemesterReport.php';
		// otherwise use the generic site template
		//$templateName = '';
		
		return $this->template->fetch( $templateName );
        
    }
	
}

?>