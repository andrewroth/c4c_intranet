<?php
/**
 * @package cim_stats
 */ 
/**
 * class page_CampusYearSummary 
 * <pre> 
 * Summarizes a year of ministry on a campus
 * </pre>
 * @author Russ Martin
 * Date:   19 Feb 2007
 */
 // RAD Tools: Custom Page
class  page_CampusYearSummary extends PageDisplay {

	//CONSTANTS:
    
    /** The Multilingual Page Key for labels on this page */
    const MULTILINGUAL_PAGE_KEY = 'page_CampusYearSummary';
    

	//VARIABLES:
	
	/** @var [OBJECT] The viewer object. */
	protected $viewer;
	
    /** @var [STRING] The path to this module's root directory. */
	protected $pathModuleRoot;
	
    protected $staff_id;
	protected $campus_id;
	
	protected $year_id;
	
	protected $campusListIterator;
	protected $yearListIterator;
	
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
    function __construct($pathModuleRoot, $viewer, $staff_id, $campus_id, $year_id ) 
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
        
        if ( $year_id != '' )
        {
            $this->year_id = $year_id;
        }
        else
        {
            // set a default semester id
            $this->year_id = 2;
            // TODO set this properly
            
        }
        // echo 'the semester_id['.$this->semester_id.']<br/>';
        
        // now initialize the labels for this page
        // start by loading the default field labels for this Module
        $languageID = $viewer->getLanguageID();
        $seriesKey = modulecim_stats::MULTILINGUAL_SERIES_KEY;
        $pageKey = page_CampusYearSummary::MULTILINGUAL_PAGE_KEY;
        $this->labels = new MultilingualManager( $languageID, $seriesKey, $pageKey );
        
        $pageKey = modulecim_stats::MULTILINGUAL_PAGE_FIELDS;
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
        
        // get a list of all the semesters associated with this year
        $semesterManager = new RowManager_SemesterManager();
        $semesterManager->setYearID( $this->year_id );
        $semesterList = $semesterManager->getListIterator();
        $semesterArray = $semesterList->getDropListArray();
        // echo "<pre>".print_r( $semesterArray, true)."</pre>";
        
        $semStatsFieldsOfInterest = "semesterreport_avgPrayer,semesterreport_avgWklyMtg,semesterreport_numStaffChall,semesterreport_numInternChall,semesterreport_numFrosh,semesterreport_numStaffDG,semesterreport_numInStaffDG,semesterreport_numStudentDG,semesterreport_numInStudentDG,semesterreport_numSpMultStaffDG,semesterreport_numSpMultStdDG";
        $semStatsFieldArray = explode(",", $semStatsFieldsOfInterest );
        
        $perStatsFieldsOfInterest = "weeklyReport_1on1SpConv,weeklyReport_1on1SpConvStd,weeklyReport_1on1GosPres,weeklyReport_1on1GosPresStd,weeklyReport_1on1HsPres,weeklyReport_1on1HsPresStd,weeklyReport_7upCompleted,weeklyReport_7upCompletedStd,weeklyReport_cjVideo,weeklyReport_mda,weeklyReport_otherEVMats,weeklyReport_rlk,weeklyReport_siq";
        $perStatsFieldArray = explode(",", $perStatsFieldsOfInterest );
        
        $prcTotals = array();
        $semesterStatsArray = array();
        foreach( $semesterArray as $semesterID=>$desc )
        {
            // init the personal stats array
            foreach( $perStatsFieldArray as $key=>$fieldName )
            {
                $personalMinStatsArray[$fieldName][$semesterID] = 0;
            }
        
            // GET INDICATED DECISIONS
            $prcManager = new RowManager_PRCManager();
            $prcManager->setSemester( $semesterID );
            $prcManager->setCampus( $this->campus_id );
            $prcList = $prcManager->getListIterator();
            $totalPRC = $prcList->getNumRows();
            $prcTotals[$semesterID] = $totalPRC;
            
            // GET SEMESTER STATS
            $semReportManager = new RowManager_SemesterReportManager( $semesterID, $this->campus_id  );
            
            $semReportManager->setFieldsOfInterest( $semStatsFieldsOfInterest );
            $valuesArray = $semReportManager->getArrayOfValues();
            // echo "<pre>".print_r( $valuesArray, true)."</pre>";
            
            foreach( $semStatsFieldArray as $key=>$fieldName )
            {
                $num = 0;
                if ( isset( $valuesArray[$fieldName] ) )
                {
                    $num = $valuesArray[$fieldName];
                }
            
                $semesterStatsArray[$fieldName][$semesterID] = $num;
            } // foreach semStatsFieldArray
            
            // GET CAMPUS TEAM EXPOSURE STATS
            $exposureTypeManager = new RowManager_ExposureTypeManager();
            $exIt = $exposureTypeManager->getListIterator();
            $exIt->setFirst();
            while( $exIt->moveNext() )
            {
                $anEx = $exIt->getCurrent( new RowManager_ExposureTypeManager() );
                $typeID = $anEx->getID();
                
                $weekManager = new RowManager_WeekManager();
                $weekManager->setSemesterID( $semesterID );
                
                $moreStatsManager = new RowManager_MoreStatsManager();
                $moreStatsManager->setExposureTypeID( $typeID );
                $moreStatsManager->setCampusID( $this->campus_id );
                
                $multiTableManager = new MultiTableManager();
                $multiTableManager->addRowManager($weekManager);
                    
                $multiTableManager->addRowManager( $moreStatsManager, new JoinPair( $weekManager->getJoinOnWeekID(), $moreStatsManager->getJoinOnWeekID() ) );
                
                $listIterator = $multiTableManager->getListIterator();
                $listIterator->setFirst();
                $dataArray = array();
                $expTotal = 0;
                while( $listIterator->moveNext() )
                {
                    $anItem = $listIterator->getCurrent( new RowManager_MoreStatsManager() );
                    $expTotal += $anItem->getNumExposures();
                }
                
                $campusTeamMinArray[$anEx->getLabel()][$semesterID] = $expTotal;
                
            } // all exposureTypes
            
            // GET PERSONAL MINISTRY STATS
            
            $weekManager = new RowManager_WeekManager();
            $weekManager->setSemesterID( $semesterID );
            
            $weeklyReport = new RowManager_WeeklyReportManager();
            $weeklyReport->setCampusID($this->campus_id);
            
            $multiTableManager = new MultiTableManager();
            $multiTableManager->addRowManager($weekManager);
            
            $multiTableManager->addRowManager( $weeklyReport, new JoinPair( $weekManager->getJoinOnWeekID(), $weeklyReport->getJoinOnWeekID() ) );
            $listIterator = $multiTableManager->getListIterator();
            $listIterator->setFirst();
            $expTotal = 0;
            while( $listIterator->moveNext() )
            {
                $aReport = $listIterator->getCurrent( new RowManager_WeeklyReportManager() );
                $dataArray = $aReport->getArrayOfValues();
                foreach( $perStatsFieldArray as $key=>$fieldName )
                {
                    $personalMinStatsArray[$fieldName][$semesterID] += $dataArray[$fieldName];
                }
                
            }
            
        } // foreach semesterArray
        
        $prcArray = array( "Indicated Decisions"=>$prcTotals );

        /*
         * Update any label tags ...
         */
        // example:
            // $name = $user->getName();
            // $this->labels->setLabelTag( '[Title]', '[userName]', $name);

        $campusJumpLinkSelectedValue = $this->linkValues['campusJumpLink'].$this->campus_id;
        $yearJumpLinkSelectedValue = $this->linkValues['yearJumpLink'].$this->year_id;

        // NOTE:  this parent method prepares the $this->template with the 
        // common Display data.  
        $this->prepareTemplate($path);
        
        $this->template->set('semesterArray', $semesterArray );
        
        // the actual stats
        $this->template->set('personalMinStatsArray',$personalMinStatsArray);
        $this->template->set('prcArray',$prcArray);
        $this->template->set('campusTeamMinArray',$campusTeamMinArray); 
        $this->template->set('semesterStatsArray', $semesterStatsArray);
        
        
        $this->template->set('semStatsLink', $this->linkValues['semStatsLink'] );
        $this->template->set('campusTeamLink', $this->linkValues['campusTeamLink'] );
        $this->template->set('indDecLink', $this->linkValues['indDecLink'] );
        $this->template->set('personalMinLink', $this->linkValues['personalMinLink'] );
        
        $this->template->set( 'campusJumpLinkSelectedValue', $campusJumpLinkSelectedValue );
        $this->template->set( 'yearJumpLinkSelectedValue', $yearJumpLinkSelectedValue );
        
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
        
        // year list
        $jumpLink = $this->linkValues['yearJumpLink'];
        $yearArray = array();
        $yearManager = new RowManager_YearManager();
        $this->yearListIterator = $yearManager->getListIterator();
        $this->yearListIterator->setFirst();
        while( $this->yearListIterator->moveNext() )
        {
            $yearObject = $this->yearListIterator->getCurrent(new RowManager_YearManager());
            $yearArray[$jumpLink.$yearObject->getID()] = $yearObject->getLabel();
        }
        // echo '<pre>'.print_r($campusArray, true ).'</pre>';
        $this->template->set( 'list_year_id', $yearArray ); 

        // uncomment this line if you are creating a template for this page
		$templateName = 'page_CampusYearSummary.php';
		// otherwise use the generic site template
		//$templateName = '';
		
		return $this->template->fetch( $templateName );
        
    }
	
}

?>