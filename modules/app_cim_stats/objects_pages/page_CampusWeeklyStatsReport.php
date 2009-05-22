<?php
/**
 * @package cim_stats
 */ 
/**
 * class page_CampusWeeklyStatsReport 
 * <pre> 
 * page where can see all weekly stats from a semester for a given campus
 * </pre>
 * @author Russ Martin
 * Date:   26 Jan 2007
 */
 // RAD Tools: Custom Page
class  page_CampusWeeklyStatsReport extends PageDisplay {

	//CONSTANTS:
    
    /** The Multilingual Page Key for labels on this page */
    const MULTILINGUAL_PAGE_KEY = 'page_CampusWeeklyStatsReport';
    

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
    function __construct($pathModuleRoot, $viewer, $staff_id, $campus_id="", $semester_id="" ) 
    {
    
        parent::__construct();
        
        // initialzie the object values
        $this->pathModuleRoot = $pathModuleRoot;
        $this->viewer = $viewer;
        
        $this->permManager = new PermissionManager( $this->viewer->getViewerID() );
        
        // for looking up the person_id of this staff member
        $this->staff_id = $staff_id;
        $staffManager = new RowManager_StaffManager( $this->staff_id );
        // echo 'the staff_id['.$this->staff_id.']<br/>';
         
        // figure out what campuses to display
        $multiTableManager = new MultiTableManager();
        $campusManager = new RowManager_CampusManager();
        $campusManager->setSortOrder('campus_desc');
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
        $pageKey = page_CampusWeeklyStatsReport::MULTILINGUAL_PAGE_KEY;
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

        // Uncomment the following line if you want to create a template 
        // tailored for this page:
        $path = $this->pathModuleRoot.'templates/';
        // Otherwise use the standard Templates for the site:
        //$path = SITE_PATH_TEMPLATES;

        $exposureArray = array();
        
        $exposureTypeManager = new RowManager_ExposureTypeManager();
        $exIt = $exposureTypeManager->getListIterator();
        $exIt->setFirst();
        while( $exIt->moveNext() )
        {
            $anEx = $exIt->getCurrent( new RowManager_ExposureTypeManager() );
            $typeID = $anEx->getID();
            
            $campusExposure = new CampusExposure();
            $campusExposure->expDesc = $anEx->getLabel();
            
            $arrayOfExposures = array();
            
            $weekManager = new RowManager_WeekManager();
            $weekManager->setSemesterID( $this->semester_id );
            
            $moreStatsManager = new RowManager_MoreStatsManager();
            $moreStatsManager->setExposureTypeID( $typeID );
            $moreStatsManager->setCampusID( $this->campus_id );
            
            $multiTableManager = new MultiTableManager();
            $multiTableManager->addRowManager($weekManager);
                
            $multiTableManager->addRowManager( $moreStatsManager, new JoinPair( $weekManager->getJoinOnWeekID(), $moreStatsManager->getJoinOnWeekID() ) );
            
            $listIterator = $multiTableManager->getListIterator();
            $listIterator->setFirst();
            $dataArray = array();
            while( $listIterator->moveNext() )
            {
                $moreStatsObj = $listIterator->getCurrent( new RowManager_MoreStatsManager() );
                $weekObj = $listIterator->getCurrent( new RowManager_WeekManager() );
                
                $arrayOfExposures[] = array_merge( $moreStatsObj->getArrayOfValues(), $weekObj->getArrayOfValues() );
                
                // array( 1=>array("week_endDate"=>"23-34", "morestats_notes"=>"some notes", "morestats_exp"=>35));
            }
            
            $campusExposure->valuesArray = $arrayOfExposures;
            $exposureArray[] = $campusExposure;
            
        } // while
        

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
        
        $this->template->set( 'exposureArray', $exposureArray );
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
		$templateName = 'page_CampusWeeklyStatsReport.php';
		// otherwise use the generic site template
		//$templateName = '';
		
		return $this->template->fetch( $templateName );
        
    }
	
}

?>