<?PHP
$pathFile = 'General/gen_Includes.php';
$extension = '';
    
// Attempt to find proper directory from current page to Root ...
$numAttempts = 0;
while ( (!file_exists($extension.$pathFile)) && ( $numAttempts < 5) ) {
    
    $extension = '../'.$extension;
    $numAttempts++; 
}
require ( $extension.$pathFile );

require ( 'app_cim_stats.php' );
require ( 'incl_cim_stats.php');


/*
 *  Directory Setup
 *
 *  Setup any specific directories used by this module.
 */
/*
if( !file_exists( modulecim_stats::DEF_DIR_DATA ) ) { 
    mkdir( modulecim_stats::DEF_DIR_DATA);
}
*/




// check to see if the parameter 'skipModule' was provided
$skipModule = isset($_REQUEST['skipModule']);

// if it was NOT provided then update the Modules Table
if (!$skipModule ) {

    
    /*
     * Modules Table
     *
     * Setup the Page Modules Table to include a proper entry for this app.
     */
    $module = new RowManager_siteModuleManager();


    $module->loadByKey( modulecim_stats::MODULE_KEY );
    $module->setKey( modulecim_stats::MODULE_KEY );
    $module->setPath( 'modules/app_cim_stats/' );
    $module->setApplicationFile( 'app_cim_stats.php' );
    $module->setIncludeFile( 'incl_cim_stats.php' );
    $module->setName( 'modulecim_stats' );
    $module->setParameters( '' );
    $module->setSystemAccessFile( 'objects_bl/obj_SystemAccess.php' );
    $module->setSystemAccessObj( modulecim_stats::MODULE_KEY.'Access' );
    
    // if module entry already exists then
    if ( $module->isLoaded() ) {
    
        // update current entry
        $module->updateDBTable();
        
    } else {
    
        // create new entry
        $module->createNewEntry();
    }
    

} else {

    echo 'Skipping Module Table ... <br>';
    
}




// check to see if the parameter 'skipTables' was provided
$skipTables = isset($_REQUEST['skipTables']);
$skipTables = true;

// if NOT then reset the tables...
if ( !$skipTables ) {


    /*
     * WeeklyReport Table
     *
     * Handles information related to information staff submit each week.
     *
     * weeklyReport_id [INTEGER]  unique id
     * weeklyReport_1on1SpConv [INTEGER]  number of 1-1 spiritual conversations this week
     * weeklyReport_1on1GosPres [INTEGER]  number of 1 on 1 gospel presentations this week
     * weeklyReport_1on1HsPres [INTEGER]  number of 1 on 1 Holy Spirit presentations
     */
    $WeeklyReport = new RowManager_WeeklyReportManager();

    $WeeklyReport->dropTable();
    $WeeklyReport->createTable();



    /*
     * Week Table
     *
     * Manages information related to a week
     *
     * week_id [INTEGER]  unique id of the week
     * week_endDate [DATE]  Ending date of the week
     */
    $Week = new RowManager_WeekManager();

    $Week->dropTable();
    $Week->createTable();



    /*
     * Semester Table
     *
     * Manages information related to semesters
     *
     * semester_id [INTEGER]  unique id of a semester
     * semester_desc [STRING]  Textual description of the semester
     */
    $Semester = new RowManager_SemesterManager();

    $Semester->dropTable();
    $Semester->createTable();



    /*
     * SemesterReport Table
     *
     * Manages stats information for a campus from a given semester
     *
     * semesterreport_id [INTEGER]  Unique id
     * semesterreport_avgPrayer [INTEGER]  Average attendence at prayer meetings over the semester
     * semesterreport_avgWklyMtg [INTEGER]  The average attendence at the weekly meetings over the semester.
     * semesterreport_numStaffChall [INTEGER]  Number of people challenged to staff
     * semesterreport_numInternChall [INTEGER]  number challenged to an internship
     * semesterreport_numFrosh [INTEGER]  number of frosh involved
     * semesterreport_numStaffDG [INTEGER]  number of staff led DGs
     * semesterreport_numInStaffDG [INTEGER]  number of students in staff led DGs
     * semesterreport_numStudentDG [INTEGER]  number of student led DGs
     * semesterreport_numInStudentDG [INTEGER]  number of students in student-led DGs
     * semesterreport_numSpMultStaffDG [INTEGER]  Number of SP mults in staff led DGs
     * semesterreport_numSpMultStdDG [INTEGER]  Number of sp mults in student led DGs
     * semester_id [INTEGER]  id of the semester
     * campus_id [INTEGER]  id of the campus
     */
    $SemesterReport = new RowManager_SemesterReportManager();

    $SemesterReport->dropTable();
    $SemesterReport->createTable();



    /*
     * PrcMethod Table
     *
     * Manages methods by which people PRC
     *
     * prcMethod_id [INTEGER]  unique id
     * prcMethod_desc [STRING]  Textual description of the prc method
     */
    $PrcMethod = new RowManager_PrcMethodManager();

    $PrcMethod->dropTable();
    $PrcMethod->createTable();



    /*
     * PRC Table
     *
     * Manages information related to someone who has PRC'd
     *
     * prc_id [INTEGER]  unique id
     * prc_firstName [STRING]  The first name of someone who has PRC'd
     * prcMethod_id [INTEGER]  The method by which someone came to Christ
     * prc_witnessName [STRING]  The name(s) of someone who witnessed this person make a decision
     * semester_id [INTEGER]  id of the semester
     * campus_id [INTEGER]  The campus where this person PRC'd
     */
    $PRC = new RowManager_PRCManager();

    $PRC->dropTable();
    $PRC->createTable();



    /*
     * ExposureType Table
     *
     * The different types of evangelistic exposure
     *
     * exposuretype_id [INTEGER]  unique id
     * exposuretype_desc [STRING]  Text description of the exposure type.
     */
    $ExposureType = new RowManager_ExposureTypeManager();

    $ExposureType->dropTable();
    $ExposureType->createTable();



    /*
     * MoreStats Table
     *
     * Manages information regarding additonal weekly stats
     *
     * morestats_id [INTEGER]  unique id
     * morestats_exp [INTEGER]  How many exposures happened here.
     * morestats_notes [STRING]  Notes of the event that happened
     * week_id [INTEGER]  week_id
     * campus_id [INTEGER]  campus_id
     * exposuretype_id [INTEGER]  exposuretype_id
     */
    $MoreStats = new RowManager_MoreStatsManager();

    $MoreStats->dropTable();
    $MoreStats->createTable();



    /*
     * Priv Table
     *
     * Manages access priviledges for the stats module
     *
     * priv_id [INTEGER]  unique id
     * priv_desc [STRING]  Description of the priviledge
     */
    $Priv = new RowManager_PrivManager();

    $Priv->dropTable();
    $Priv->createTable();



    /*
     * Access Table
     *
     * Where staff members are assigned priviledges
     *
     * access_id [INTEGER]  unique id
     * staff_id [INTEGER]  staff id
     * priv_id [INTEGER]  priviledge id
     */
    $Access = new RowManager_AccessManager();

    $Access->dropTable();
    $Access->createTable();



    /*
     * Coordinator Table
     *
     * manages which staff have what access to which campuses
     *
     * coordinator_id [INTEGER]  unique id
     * access_id [INTEGER]  the access_id of a staff member
     * campus_id [INTEGER]  a campus to which this coordinator is assigned
     */
    $Coordinator = new RowManager_CoordinatorManager();

    $Coordinator->dropTable();
    $Coordinator->createTable();



    /*
     * Year Table
     *
     * Manages info related to a year
     *
     * year_id [INTEGER]  unique id
     * year_desc [STRING]  textual description of the year
     */
    $Year = new RowManager_YearManager();

    $Year->dropTable();
    $Year->createTable();



/*[RAD_DAOBJ_TABLE]*/

    

} else {

    echo 'Skipping Tables ... <br>';
    
} // end if !skipTables




// check to see if parameter 'skipLabel' was provided
$skipLabel = isset( $_REQUEST['skipLabel'] );

// if not, then add labels to DB ...
if (!$skipLabel) {
        
        
    /*
     *  Insert Labels in DB
     */
    // Create Application Upload Series
    $labelManager = new  MultilingualManager();
    $labelManager->addSeries( modulecim_stats::MULTILINGUAL_SERIES_KEY );
    
    
    
    // Create General Field labels for modulecim_stats 
    $labelManager->addPage( modulecim_stats::MULTILINGUAL_PAGE_FIELDS );

    
    //
    // WeeklyReport table
    //
    $labelManager->addLabel( "[title_weeklyReport_1on1SpConv]", "# 1-1 Spiritual Conversations", "en" );
    $labelManager->addLabel( "[formLabel_weeklyReport_1on1SpConv]", "# 1-1 Spiritual Conversations", "en" );
    $labelManager->addLabel( "[title_weeklyReport_1on1SpConvStd]", "# 1-1 Spiritual Conversations (By Disciples)", "en" );
    $labelManager->addLabel( "[formLabel_weeklyReport_1on1SpConvStd]", "# 1-1 Spiritual Conversations (By Disciples)", "en" );
    $labelManager->addLabel( "[title_weeklyReport_1on1GosPres]", "# 1-1 Gospel Presentations", "en" );
    $labelManager->addLabel( "[formLabel_weeklyReport_1on1GosPres]", "# 1-1 Gospel Presentations", "en" );
    $labelManager->addLabel( "[title_weeklyReport_1on1GosPresStd]", "# 1-1 Gospel Presentations (By Disciples)", "en" );
    $labelManager->addLabel( "[formLabel_weeklyReport_1on1GosPresStd]", "# 1-1 Gospel Presentations (By Disciples)", "en" );
    $labelManager->addLabel( "[title_weeklyReport_1on1HsPres]", "# 1-1 Holy Spirit Presentations", "en" );
    $labelManager->addLabel( "[formLabel_weeklyReport_1on1HsPres]", "# 1-1 Holy Spirit Presentations", "en" );
    $labelManager->addLabel( "[title_weeklyReport_1on1HsPresStd]", "# 1-1 Holy Spirit Presentations (By Disciples)", "en" );
    $labelManager->addLabel( "[formLabel_weeklyReport_1on1HsPresStd]", "# 1-1 Holy Spirit Presentations (By Disciples)", "en" );
    $labelManager->addLabel( "[title_weeklyReport_7upCompleted]", "# Follow up (completed 4 basic followup)", "en" );
    $labelManager->addLabel( "[formLabel_weeklyReport_7upCompleted]", "# Follow up (completed 4 basic followup)", "en" );
    $labelManager->addLabel( "[title_weeklyReport_7upCompletedStd]", "# Follow up (completed 4 basic followup) (By Disciples)", "en" );
    $labelManager->addLabel( "[formLabel_weeklyReport_7upCompletedStd]", "# Follow up (completed 4 basic followup) (By Disciples) ", "en" );
    $labelManager->addLabel( "[formLabel_weeklyReport_cjVideo]", "Jesus Videos", "en" );
    $labelManager->addLabel( "[title_weeklyReport_cjVideo]", "Jesus Videos", "en" );
    $labelManager->addLabel( "[formLabel_weeklyReport_mda]", "MDA Exposures", "en" );
    $labelManager->addLabel( "[title_weeklyReport_mda]", "MDA Exposures", "en" );
    $labelManager->addLabel( "[formLabel_weeklyReport_otherEVMats]", "Other Evangelistic Materials", "en" );
    $labelManager->addLabel( "[title_weeklyReport_otherEVMats]", "Other Evangelistic Materials", "en" );
    $labelManager->addLabel( "[formLabel_weeklyReport_rlk]", "RLKs", "en" );
    $labelManager->addLabel( "[title_weeklyReport_rlk]", "RLKs", "en" );
    $labelManager->addLabel( "[formLabel_weeklyReport_siq]", "SIQs", "en" );
    $labelManager->addLabel( "[title_weeklyReport_siq]", "SIQs", "en" );
    $labelManager->addLabel( "[formLabel_weeklyReport_notes]", "Notes", "en" );
    $labelManager->addLabel( "[title_weeklyReport_notes]", "Notes", "en" );
    
    
    
    
    //
    // Week table
    //
    $labelManager->addLabel( "[title_week_id]", "Week Ending", "en" );
    $labelManager->addLabel( "[formLabel_week_id]", "Week Ending", "en" );
    $labelManager->addLabel( "[title_week_endDate]", "End Date", "en" );
    $labelManager->addLabel( "[formLabel_week_endDate]", "End Date", "en" );


    //
    // Semester table
    //
    $labelManager->addLabel( "[title_semester_id]", "Semester ID", "en" );
    $labelManager->addLabel( "[formLabel_semester_id]", "Semester ID", "en" );
    $labelManager->addLabel( "[title_semester_desc]", "Description", "en" );
    $labelManager->addLabel( "[formLabel_semester_desc]", "Description", "en" );


    //
    // SemesterReport table
    //
    $labelManager->addLabel( "[title_semesterreport_id]", "Semester Report ID", "en" );
    $labelManager->addLabel( "[formLabel_semesterreport_id]", "Semester Report ID", "en" );
    $labelManager->addLabel( "[title_semesterreport_avgPrayer]", "Average Prayer Meeting Attendence", "en" );
    $labelManager->addLabel( "[formLabel_semesterreport_avgPrayer]", "Average Prayer Meeting Attendence", "en" );
    $labelManager->addLabel( "[title_semesterreport_avgWklyMtg]", "Average Weekly Meeting Attendence", "en" );
    $labelManager->addLabel( "[formLabel_semesterreport_avgWklyMtg]", "Average Weekly Meeting Attendence", "en" );
    $labelManager->addLabel( "[title_semesterreport_numStaffChall]", "# challenged to staff", "en" );
    $labelManager->addLabel( "[formLabel_semesterreport_numStaffChall]", "# challenged to staff", "en" );
    $labelManager->addLabel( "[title_semesterreport_numInternChall]", "# challenged to internship", "en" );
    $labelManager->addLabel( "[formLabel_semesterreport_numInternChall]", "# challenged to internship", "en" );
    $labelManager->addLabel( "[title_semesterreport_numFrosh]", "# frosh involved", "en" );
    $labelManager->addLabel( "[formLabel_semesterreport_numFrosh]", "# frosh involved", "en" );
    $labelManager->addLabel( "[title_semesterreport_numStaffDG]", "# staff-led DGs", "en" );
    $labelManager->addLabel( "[formLabel_semesterreport_numStaffDG]", "# staff-led DGs", "en" );
    $labelManager->addLabel( "[title_semesterreport_numInStaffDG]", "# in staff-led DGs", "en" );
    $labelManager->addLabel( "[formLabel_semesterreport_numInStaffDG]", "# in staff-led DGs", "en" );
    $labelManager->addLabel( "[title_semesterreport_numStudentDG]", "# student-led DGs", "en" );
    $labelManager->addLabel( "[formLabel_semesterreport_numStudentDG]", "# student-led DGs", "en" );
    $labelManager->addLabel( "[title_semesterreport_numInStudentDG]", "# in student-led DGs", "en" );
    $labelManager->addLabel( "[formLabel_semesterreport_numInStudentDG]", "# in student-led DGs", "en" );
    $labelManager->addLabel( "[title_semesterreport_numSpMultStaffDG]", "# sp. mult in staff DGs", "en" );
    $labelManager->addLabel( "[formLabel_semesterreport_numSpMultStaffDG]", "# sp. mult in staff DGs", "en" );
    $labelManager->addLabel( "[title_semesterreport_numSpMultStdDG]", "# sp. mult in student DGs", "en" );
    $labelManager->addLabel( "[formLabel_semesterreport_numSpMultStdDG]", "# sp. mult in student DGs", "en" );
    $labelManager->addLabel( "[title_semester_id]", "Semester", "en" );
    $labelManager->addLabel( "[formLabel_semester_id]", "Semester", "en" );
    $labelManager->addLabel( "[title_campus_id]", "Campus", "en" );
    $labelManager->addLabel( "[formLabel_campus_id]", "Campus", "en" );


    //
    // PrcMethod table
    //
    $labelManager->addLabel( "[title_prcMethod_id]", "Method ID", "en" );
    $labelManager->addLabel( "[formLabel_prcMethod_id]", "Method ID", "en" );
    $labelManager->addLabel( "[title_prcMethod_desc]", "Description", "en" );
    $labelManager->addLabel( "[formLabel_prcMethod_desc]", "Description", "en" );


    //
    // PRC table
    //
    $labelManager->addLabel( "[title_prc_id]", "PRC ID", "en" );
    $labelManager->addLabel( "[formLabel_prc_id]", "PRC ID", "en" );
    $labelManager->addLabel( "[title_prc_firstName]", "Person who indicated decision", "en" );
    $labelManager->addLabel( "[formLabel_prc_firstName]", "Person who indicated decision", "en" );
    $labelManager->addLabel( "[example_prc_firstName]", "Bill", "en" );
    $labelManager->addLabel( "[title_prcMethod_id]", "Method", "en" );
    $labelManager->addLabel( "[formLabel_prcMethod_id]", "Method", "en" );
    $labelManager->addLabel( "[title_prc_witnessName]", "Person who shared gospel", "en" );
    $labelManager->addLabel( "[formLabel_prc_witnessName]", "Person who shared gospel", "en" );
    $labelManager->addLabel( "[example_prc_witnessName]", "Russ and Sean", "en" );
    $labelManager->addLabel( "[title_semester_id]", "Semester", "en" );
    $labelManager->addLabel( "[formLabel_semester_id]", "Semester", "en" );
    $labelManager->addLabel( "[example_semester_id]", "Fall 2006", "en" );
    $labelManager->addLabel( "[title_campus_id]", "Campus", "en" );
    $labelManager->addLabel( "[formLabel_campus_id]", "Campus", "en" );
    $labelManager->addLabel( "[example_campus_id]", "University of Waterloo", "en" );
    $labelManager->addLabel( "[title_prc_notes]", "Notes", "en" );
    $labelManager->addLabel( "[formLabel_prc_notes]", "Notes", "en" );
    $labelManager->addLabel( "[formLabel_prc_7upCompleted]", "Completed Follow Up?", "en" );
    $labelManager->addLabel( "[title_prc_7upCompleted]", "Completed Follow Up?", "en" );
    $labelManager->addLabel( "[title_prc_date]", "Date", "en" );
    $labelManager->addLabel( "[formLabel_prc_date]", "Date", "en" );
    $labelManager->addLabel( "[title_prc_7upStarted]", "Started Follow Up?", "en" );
    $labelManager->addLabel( "[formLabel_prc_7upStarted]", "Started Follow Up?", "en" );


    //
    // ExposureType table
    //
    $labelManager->addLabel( "[title_exposuretype_id]", "Type", "en" );
    $labelManager->addLabel( "[formLabel_exposuretype_id]", "Type", "en" );
    $labelManager->addLabel( "[title_exposuretype_desc]", "Description", "en" );
    $labelManager->addLabel( "[formLabel_exposuretype_desc]", "Description", "en" );


    //
    // MoreStats table
    //
    $labelManager->addLabel( "[title_morestats_id]", "MoreStats ID", "en" );
    $labelManager->addLabel( "[formLabel_morestats_id]", "MoreStats ID", "en" );
    $labelManager->addLabel( "[title_morestats_exp]", "Exposures", "en" );
    $labelManager->addLabel( "[formLabel_morestats_exp]", "Exposures", "en" );
    $labelManager->addLabel( "[title_morestats_notes]", "Notes", "en" );
    $labelManager->addLabel( "[formLabel_morestats_notes]", "Notes", "en" );
    $labelManager->addLabel( "[title_week_id]", "Week", "en" );
    $labelManager->addLabel( "[formLabel_week_id]", "Week", "en" );
    $labelManager->addLabel( "[title_campus_id]", "Campus", "en" );
    $labelManager->addLabel( "[formLabel_campus_id]", "Campus", "en" );
    $labelManager->addLabel( "[title_exposuretype_id]", "Type", "en" );
    $labelManager->addLabel( "[formLabel_exposuretype_id]", "Type", "en" );


    //
    // Priv table
    //
    $labelManager->addLabel( "[title_priv_id]", "Priv ID", "en" );
    $labelManager->addLabel( "[formLabel_priv_id]", "Priv ID", "en" );
    $labelManager->addLabel( "[title_priv_desc]", "Description", "en" );
    $labelManager->addLabel( "[formLabel_priv_desc]", "Description", "en" );


    //
    // Access table
    //
    $labelManager->addLabel( "[title_access_id]", "Access ID", "en" );
    $labelManager->addLabel( "[formLabel_access_id]", "Access ID", "en" );
    $labelManager->addLabel( "[title_staff_id]", "Staff", "en" );
    $labelManager->addLabel( "[formLabel_staff_id]", "Staff", "en" );
    $labelManager->addLabel( "[title_priv_id]", "Privilege", "en" );
    $labelManager->addLabel( "[formLabel_priv_id]", "Privilege", "en" );


    //
    // coordinator table
    //
    $labelManager->addLabel( "[title_coordinator_id]", "Coordinator ID", "en" );
    $labelManager->addLabel( "[formLabel_coordinator_id]", "Coordinator ID", "en" );
    $labelManager->addLabel( "[title_access_id]", "Access ID", "en" );
    $labelManager->addLabel( "[formLabel_access_id]", "Access ID", "en" );
    $labelManager->addLabel( "[title_campus_id]", "Campus", "en" );
    $labelManager->addLabel( "[formLabel_campus_id]", "Campus", "en" );


    //
    // Year table
    //
    $labelManager->addLabel( "[title_year_id]", "Year ID", "en" );
    $labelManager->addLabel( "[formLabel_year_id]", "Year ID", "en" );
    $labelManager->addLabel( "[example_year_id]", "１", "en" );
    $labelManager->addLabel( "[error_year_id]", "Invalid year id", "en" );
    $labelManager->addLabel( "[title_year_desc]", "Description", "en" );
    $labelManager->addLabel( "[formLabel_year_desc]", "Description", "en" );
    $labelManager->addLabel( "[example_year_desc]", "2006 - 2007", "en" );
    $labelManager->addLabel( "[error_year_desc]", "Invalid description", "en" );


/*[RAD_FIELDS_LABEL]*/
    
    
    
    
// Create CommonDisplay labels 
    $labelManager->addPage( CommonDisplay::MULTILINGUAL_PAGE_KEY );
/*
    //
    // Use this section to create your common page label information:
    //
    $labelManager->addLabel( "[Title]", "Title", "en" );
    $labelManager->addLabel( "[Instr]", "Instructions", "en" );
*/


    // Create StaffWeeklyReport labels 
    $labelManager->addPage( FormProcessor_StaffWeeklyReport::MULTILINGUAL_PAGE_KEY );

    $labelManager->addLabel( "[Title]", "Staff Weekly Report", "en" );
    $labelManager->addLabel( "[Instr]", "Please enter your stats from this week.  First, select the week.  Second, select the campus.", "en" );
/*[RAD_PAGE(StaffWeeklyReport)_LABELS]*/



    // Create StatsHome labels 
    $labelManager->addPage( page_StatsHome::MULTILINGUAL_PAGE_KEY );

    $labelManager->addLabel( "[Title]", "Stats", "en" );
    $labelManager->addLabel( "[Instr]", "Figure out what to put here.", "en" );
    $labelManager->addLabel( "[AllStaff]", "All Staff", "en" );
    $labelManager->addLabel( "[submitWeeklyStats]", "Submit Weekly Stats", "en" );
    $labelManager->addLabel( "[submitMoreWeeklyStats]", "Additional Weekly Stats", "en" );    
    $labelManager->addLabel( "[indicatedDecisions]", "Indicated Decisions", "en" );
    $labelManager->addLabel( "[CampusDirector]", "Campus Directors", "en" );
    $labelManager->addLabel( "[submitSemesterStats]", "Submit Semester Stats", "en" );
    $labelManager->addLabel( "[RegionalTeam]", "Regional Team", "en" );
    $labelManager->addLabel( "[NationalTeam]", "National Team", "en" );
    $labelManager->addLabel( "[CampusStatsCoordinator]", "Campus Stats Coordinator", "en" );
    $labelManager->addLabel( "[prcMethod]", "Edit PRC Methods", "en" );
    $labelManager->addLabel( "[exposureTypes]", "Edit Exposure Types for Weekly Campus Stats", "en");
    $labelManager->addLabel( "[campusWeeklyStats]", "Campus Weekly Stats", "en");
    $labelManager->addLabel( "[prcReportByCampus]", "Indicated Decisions", "en" );
    $labelManager->addLabel( "[semesterGlance]", "Semester At A Glance", "en" );

/*[RAD_PAGE(StatsHome)_LABELS]*/



    // Create SemesterReport labels 
    $labelManager->addPage( FormProcessor_SemesterReport::MULTILINGUAL_PAGE_KEY );

    $labelManager->addLabel( "[Title]", "Semester Report", "en" );
    $labelManager->addLabel( "[Instr]", "Campus directors can use this page to input semester statistics for each campus they are assigned to.", "en" );
/*[RAD_PAGE(SemesterReport)_LABELS]*/



    // Create PrcMethod labels 
    $labelManager->addPage( FormProcessor_PrcMethod::MULTILINGUAL_PAGE_KEY );

    $labelManager->addLabel( "[Title]", "PRC Methods", "en" );
    $labelManager->addLabel( "[Instr]", "Use this page to manage the different ways we track of someone coming to Christ.", "en" );
/*[RAD_PAGE(PrcMethod)_LABELS]*/



    // Create SelectPrcSemesterCampus labels 
    $labelManager->addPage( FormProcessor_SelectPrcSemesterCampus::MULTILINGUAL_PAGE_KEY );

    $labelManager->addLabel( "[Title]", "Indicated Decisions", "en" );
    $labelManager->addLabel( "[Instr]", "Select the semester and campus you want to see indicated decisions for.", "en" );
/*[RAD_PAGE(SelectPrcSemesterCampus)_LABELS]*/



    // Create PRC labels 
    $labelManager->addPage( FormProcessor_PRC::MULTILINGUAL_PAGE_KEY );

    $labelManager->addLabel( "[Title]", "Indicated Decisions", "en" );
    $labelManager->addLabel( "[Instr]", "Use this page to enter info related to people indicating decisions for Christ.<br/>Semester: <b>[semester]</b><br/>Campus: <b>[campus]</b>", "en" );
/*[RAD_PAGE(PRC)_LABELS]*/



    // Create ExposureTypes labels 
    $labelManager->addPage( FormProcessor_ExposureTypes::MULTILINGUAL_PAGE_KEY );

    $labelManager->addLabel( "[Title]", "Exposure Types", "en" );
    $labelManager->addLabel( "[Instr]", "Add, edit or delete the different exposure types.", "en" );
/*[RAD_PAGE(ExposureTypes)_LABELS]*/



    // Create MoreStats labels 
    $labelManager->addPage( FormProcessor_MoreStats::MULTILINGUAL_PAGE_KEY );

    $labelManager->addLabel( "[Title]", "Campus Weekly Stats", "en" );
    $labelManager->addLabel( "[Instr]", "Enter stats from your campus team's activities during a given week.  First, select the week.  Second, select the campus.", "en" );
/*[RAD_PAGE(MoreStats)_LABELS]*/



    // Create StaffAdditionalWeeklyStats labels 
    $labelManager->addPage( FormProcessor_StaffAdditionalWeeklyStats::MULTILINGUAL_PAGE_KEY );

    $labelManager->addLabel( "[Title]", "Additional Weekly Stats", "en" );
    $labelManager->addLabel( "[Instr]", "Enter any additional stats you have for this week.  First, select the week.  Second, select the campus.", "en" );
/*[RAD_PAGE(StaffAdditionalWeeklyStats)_LABELS]*/



    // Create PRC_ReportByCampus labels 
    $labelManager->addPage( page_PRC_ReportByCampus::MULTILINGUAL_PAGE_KEY );

    $labelManager->addLabel( "[Title]", "Indicated Decisions", "en" );
    $labelManager->addLabel( "[Instr]", "Report of indicated decisions.", "en" );
    $labelManager->addLabel( "[Campus]", "Campus", "en" );
    $labelManager->addLabel( "[Total]", "Total", "en" );
    $labelManager->addLabel( "[View]", "View", "en" );
/*[RAD_PAGE(PRC_ReportByCampus)_LABELS]*/



    // Create Reports labels 
    $labelManager->addPage( page_Reports::MULTILINGUAL_PAGE_KEY );

/*[RAD_PAGE(Reports)_LABELS]*/



    // Create StaffSemesterReport labels 
    $labelManager->addPage( page_StaffSemesterReport::MULTILINGUAL_PAGE_KEY );

    $labelManager->addLabel( "[Title]", "Semester At A Glance", "en" );
    $labelManager->addLabel( "[Instr]", "Here is a view of the stats from this semester.", "en" );
/*[RAD_PAGE(StaffSemesterReport)_LABELS]*/



    // Create RegionalSemesterReport labels 
    $labelManager->addPage( page_RegionalSemesterReport::MULTILINGUAL_PAGE_KEY );

    $labelManager->addLabel( "[Title]", "Regional Personal Ministry Summary", "en" );
    $labelManager->addLabel( "[Instr]", "Reports for your region...", "en" );
/*[RAD_PAGE(RegionalSemesterReport)_LABELS]*/



    // Create CampusWeeklyStatsReport labels 
    $labelManager->addPage( page_CampusWeeklyStatsReport::MULTILINGUAL_PAGE_KEY );

    $labelManager->addLabel( "[Title]", "Campus Weekly Stats Report", "en" );
    $labelManager->addLabel( "[Instr]", "Here is a report of all the stats for team activities this semester.", "en" );
/*[RAD_PAGE(CampusWeeklyStatsReport)_LABELS]*/



    // Create CampusYearSummary labels 
    $labelManager->addPage( page_CampusYearSummary::MULTILINGUAL_PAGE_KEY );

    $labelManager->addLabel( "[Title]", "Campus Ministry Summary", "en" );
    $labelManager->addLabel( "[Instr]", "Here is a summary of ministry on the given campus for this year.", "en" );
/*[RAD_PAGE(CampusYearSummary)_LABELS]*/



/*[RAD_PAGE_LABEL]*/
    
    
} else {

    echo 'Skipping Labels ... <br>';
    
} // end if !skipLabels


?>