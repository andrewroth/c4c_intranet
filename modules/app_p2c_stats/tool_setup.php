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

require ( 'app_p2c_stats.php' );
require ( 'incl_p2c_stats.php');


/*
 *  Directory Setup
 *
 *  Setup any specific directories used by this module.
 */
/*
if( !file_exists( modulep2c_stats::DEF_DIR_DATA ) ) { 
    mkdir( modulep2c_stats::DEF_DIR_DATA);
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


    $module->loadByKey( modulep2c_stats::MODULE_KEY );
    $module->setKey( modulep2c_stats::MODULE_KEY );
    $module->setPath( 'modules/app_p2c_stats/' );
    $module->setApplicationFile( 'app_p2c_stats.php' );
    $module->setIncludeFile( 'incl_p2c_stats.php' );
    $module->setName( 'modulep2c_stats' );
    $module->setParameters( '' );
    $module->setSystemAccessFile( 'objects_bl/obj_SystemAccess.php' );
    $module->setSystemAccessObj( modulep2c_stats::MODULE_KEY.'Access' );
    
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
// $skipTables = isset($_REQUEST['skipTables']);
$skipTables = true;

// if NOT then reset the tables...
if ( !$skipTables ) {


    /*
     * Division Table
     *
     * A division of some ministry.
     *
     * division_id [INTEGER]  unique identifier of division
     * division_name [STRING]  Name of the Division
     * division_desc [STRING]  Description of Division
     * ministry_id [INTEGER]  The ID of the Ministry this Division belongs to.
     */
    $Division = new RowManager_DivisionManager();

    $Division->dropTable();
    $Division->createTable();



    /*
     * Ministry Table
     *
     * stores details on a Ministry
     *
     * ministry_id [INTEGER]  unique id of this Ministry
     * ministry_name [STRING]  the Ministry's name
     * ministry_desc [STRING]  Description of the Ministry
     * ministry_website [STRING]  the URL of the Ministry's website
     */
    $Ministry = new RowManager_MinistryManager();

    $Ministry->dropTable();
    $Ministry->createTable();



    /*
     * StatsRegion Table
     *
     * a region affiliated with a particular ministry-division combination
     *
     * region_id [INTEGER]  unique identifier for this Region
     * region_name [STRING]  the name of this Region
     * region_desc [STRING]  The Region's description
     * division_id [INTEGER]  unique id of the division associated with this region
     * ministry_id [INTEGER]  the identifier of the associated Ministry
     */
    $StatsRegion = new RowManager_StatsRegionManager();

    $StatsRegion->dropTable();
    $StatsRegion->createTable();



    /*
     * Location Table
     *
     * A location associated with a ministry-division-region
     *
     * location_id [INTEGER]  unique identifier of this Location
     * location_name [STRING]  the Location's name
     * location_desc [STRING]  the description of the Location
     * region_id [INTEGER]  the id of the Region associated with this Location
     * division_id [INTEGER]  the id of the associated Division
     * ministry_id [INTEGER]  the id of the Ministry associated with this Location
     */
    $Location = new RowManager_LocationManager();

    $Location->dropTable();
    $Location->createTable();



    /*
     * FrequencyType Table
     *
     * Defines a frequency type (i.e. 'weekly')
     *
     * freq_id [INTEGER]  unique id of freq. type
     * freq_name [STRING]  The name of the frequency type
     * freq_desc [STRING]  The description of the freq. type
     * freq_parent_date_field_index [INTEGER]  The field index of the date field corresponding to this frequency type's parent value (i.e. parent of 'weekly' is 'monthly' ==> index 2 of YYYY-MM-DD HH:min:SS)
     * freq_parent_date_field_name [STRING]  the name of the date field corresponding to the parent frequency (i.e. 'year' for index 1 of YYYY-MM-DD HH:min:SS)
     * freq_parent_freq_id [INTEGER]  The frequency type id associated with the parent frequency (may be case that no freq specified - i.e. 'yearly' is at top and has no parent freq)
     */
    $FrequencyType = new RowManager_FreqTypeManager();

    $FrequencyType->dropTable();
    $FrequencyType->createTable();



    /*
     * FrequencyValue Table
     *
     * Stores a specific frequency value (i.e. 'January 2008'.
     *
     * freqvalue_id [INTEGER]  the unique identifier
     * freq_id [INTEGER]  the id of the parent frequency type
     * freqvalue_value [DATE]  the actual frequency value (in date-time form)
     * freqvalue_desc [STRING]  The user-friendly description of the frequency value (i.e. 'January 2008' for '2008-01-01 00:00:00')
     */
    $FrequencyValue = new RowManager_FreqValueManager();

    $FrequencyValue->dropTable();
    $FrequencyValue->createTable();



    /*
     * Statistic Table
     *
     * A statistic description
     *
     * statistic_id [INTEGER]  unique identifier for this Statistic
     * statistic_name [STRING]  the Statistic's name
     * statistic_desc [STRING]  The Statistic description
     * statistic_type [STRING]  the data-type of this Statistic (i.e. numeric, boolean, etc)
     * scope_id [INTEGER]  the id indicating the scope of the statistic (i.e. ministry-level, division-level, etc)
     * scope_ref_id [INTEGER]  The particular scope instance associated with the statistic (i.e. project-level stat assigned to OEX Project)
     * freq_id [INTEGER]  the id indicating the frequency type associated with this statistic
     * meas_id [INTEGER]  the id of the measurement type associated with this statistic (i.e. 'Personal Ministry')
     */
    $Statistic = new RowManager_StatisticManager();

    $Statistic->dropTable();
    $Statistic->createTable();



    /*
     * StatisticValue Table
     *
     * a specific statistic value (i.e. '45' for '# of Gospel Presentations')
     *
     * statvalues_id [INTEGER]  the unique id for the Statistic Value
     * statistic_id [INTEGER]  the id of the statistic associated with this value
     * scope_id [INTEGER]  the scope of the stored stat value
     * scope_ref_id [INTEGER]  the specific scope instance associated with the stat value
     * freqvalue_id [INTEGER]  the id of the specific frequency value associated with the stat value (i.e. a particular day,week,month, or others etc)
     * meastype_id [INTEGER]  The particular measurement type associated with the stat value (OBSOLETE??)
     * statvalues_value [STRING]  The actual statistics value
     * statvalues_modtime [DATE]  the time of the value's insertion/modification
     * person_id [INTEGER]  the id of the person who entered the stat value
     */
    $StatisticValue = new RowManager_StatValueManager();

    $StatisticValue->dropTable();
    $StatisticValue->createTable();



    /*
     * MeasurementType Table
     *
     * Stores a stats measurement type (i.e. 'Personal Ministry')
     *
     * meas_id [INTEGER]  the unique identifier
     * meas_name [STRING]  the name of the Measurement Type
     * meas_desc [STRING]  The Measurement Type description
     */
    $MeasurementType = new RowManager_MeasureTypeManager();

    $MeasurementType->dropTable();
    $MeasurementType->createTable();



    /*
     * Scope Table
     *
     * stores a statistic scope (i.e. Ministry, Region, etc)
     *
     * scope_id [INTEGER]  the object's unique identifier
     * scope_name [STRING]  the name of the Scope
     * scope_reftable [STRING]  the particular scope's reference table (i.e. p2c_stats_ministry)
     */
    $Scope = new RowManager_ScopeManager();

    $Scope->dropTable();
    $Scope->createTable();



    /*
     * ReportCalculation Table
     *
     * A calculation that can be included in a stats report (i.e. SUM, AVG, etc)
     *
     * filter_id [INTEGER]  the unique id of this filter/calculation
     * filter_name [STRING]  the Filter/Calculation name
     * filter_desc [STRING]  Description for this Calculation/Filter
     */
    $ReportCalculation = new RowManager_ReportFilterManager();

    $ReportCalculation->dropTable();
    $ReportCalculation->createTable();



    /*
     * StatDataType Table
     *
     * Stores a data type for a statistic (i.e. 'numeric')
     *
     * statistic_type_id [INTEGER]  unique id for the data type
     * statistic_type [STRING]  the statistic data type (i.e. 'numeric')
     */
    $StatDataType = new RowManager_StatDataTypeManager();

    $StatDataType->dropTable();
    $StatDataType->createTable();



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
    $labelManager->addSeries( modulep2c_stats::MULTILINGUAL_SERIES_KEY );
    
    
    
    // Create General Field labels for modulep2c_stats 
    $labelManager->addPage( modulep2c_stats::MULTILINGUAL_PAGE_FIELDS );

    
//     //
//     // Statistic table - alternate naming scheme
//     //
// 	$labelManager->addLabel( "[title_statistic_name]", "Statistic", "en" );
// 	$labelManager->addLabel( "[title_statistic_desc]", "Stat Description", "en" );
// 	$labelManager->addLabel( "[title_scope_id]", "Scope", "en" );
// 	$labelManager->addLabel( "[title_scope_ref_id]", "Associated Area", "en" );
// 	$labelManager->addLabel( "[title_freq_id]", "Report Frequency", "en" );
// 	$labelManager->addLabel( "[title_meas_id]", "Measurement Type", "en" );			

// 	$labelManager->addLabel( "[formLabel_statistic_name]", "Statistic", "en" );
// 	$labelManager->addLabel( "[formLabel_statistic_desc]", "Stat Description", "en" );
// 	$labelManager->addLabel( "[formLabel_scope_id]", "Scope", "en" );
// 	$labelManager->addLabel( "[formLabel_scope_ref_id]", "Associated Area", "en" );
// 	$labelManager->addLabel( "[formLabel_freq_id]", "Report Frequency", "en" );
// 	$labelManager->addLabel( "[formLabel_meas_id]", "Measurement Type", "en" );	
// 		
  
    
    //
    // Division table
    //
    $labelManager->addLabel( "[title_division_id]", "Division", "en" );
    $labelManager->addLabel( "[formLabel_division_id]", "Division", "en" );
    $labelManager->addLabel( "[title_division_name]", "Division", "en" );
    $labelManager->addLabel( "[formLabel_division_name]", "Division", "en" );
    $labelManager->addLabel( "[title_division_desc]", "Description", "en" );
    $labelManager->addLabel( "[formLabel_division_desc]", "Description", "en" );
    $labelManager->addLabel( "[title_ministry_id]", "Ministry", "en" );
    $labelManager->addLabel( "[formLabel_ministry_id]", "Ministry", "en" );


    //
    // Ministry table
    //
    $labelManager->addLabel( "[title_ministry_id]", "Ministry", "en" );
    $labelManager->addLabel( "[formLabel_ministry_id]", "Ministry", "en" );
    $labelManager->addLabel( "[title_ministry_name]", "Ministry", "en" );
    $labelManager->addLabel( "[formLabel_ministry_name]", "Ministry", "en" );
    $labelManager->addLabel( "[title_ministry_desc]", "Description", "en" );
    $labelManager->addLabel( "[formLabel_ministry_desc]", "Description", "en" );
    $labelManager->addLabel( "[title_ministry_website]", "Website", "en" );
    $labelManager->addLabel( "[formLabel_ministry_website]", "Website", "en" );


    //
    // StatsRegion table
    //
    $labelManager->addLabel( "[title_region_id]", "Region", "en" );
    $labelManager->addLabel( "[formLabel_region_id]", "Region", "en" );
    $labelManager->addLabel( "[title_region_name]", "Region", "en" );
    $labelManager->addLabel( "[formLabel_region_name]", "Region", "en" );
    $labelManager->addLabel( "[title_region_desc]", "Description", "en" );
    $labelManager->addLabel( "[formLabel_region_desc]", "Description", "en" );
    $labelManager->addLabel( "[title_division_id]", "Parent Division", "en" );
    $labelManager->addLabel( "[formLabel_division_id]", "Parent Division", "en" );
    $labelManager->addLabel( "[title_ministry_id]", "Parent Ministry", "en" );
    $labelManager->addLabel( "[formLabel_ministry_id]", "Parent Ministry", "en" );


    //
    // Location table
    //
    $labelManager->addLabel( "[title_location_id]", "Location", "en" );
    $labelManager->addLabel( "[formLabel_location_id]", "Location", "en" );
    $labelManager->addLabel( "[title_location_name]", "Location", "en" );
    $labelManager->addLabel( "[formLabel_location_name]", "Location", "en" );
    $labelManager->addLabel( "[title_location_desc]", "Description", "en" );
    $labelManager->addLabel( "[formLabel_location_desc]", "Description", "en" );
    $labelManager->addLabel( "[title_region_id]", "Parent Region", "en" );
    $labelManager->addLabel( "[formLabel_region_id]", "Parent Region", "en" );
    $labelManager->addLabel( "[title_division_id]", "Parent Division", "en" );
    $labelManager->addLabel( "[formLabel_division_id]", "Parent Division", "en" );
    $labelManager->addLabel( "[title_ministry_id]", "Parent Ministry", "en" );
    $labelManager->addLabel( "[formLabel_ministry_id]", "Parent Ministry", "en" );


    //
    // FrequencyType table
    //
    $labelManager->addLabel( "[title_freq_id]", "Frequency", "en" );
    $labelManager->addLabel( "[formLabel_freq_id]", "Frequency", "en" );
    $labelManager->addLabel( "[title_freq_name]", "Frequency", "en" );
    $labelManager->addLabel( "[formLabel_freq_name]", "Frequency", "en" );
    $labelManager->addLabel( "[title_freq_desc]", "Description", "en" );
    $labelManager->addLabel( "[formLabel_freq_desc]", "Description", "en" );
    $labelManager->addLabel( "[title_freq_parent_date_field_index]", "Parent Date Index", "en" );
    $labelManager->addLabel( "[formLabel_freq_parent_date_field_index]", "Parent Date Index", "en" );
    $labelManager->addLabel( "[title_freq_parent_date_field_name]", "Parent Date Field", "en" );
    $labelManager->addLabel( "[formLabel_freq_parent_date_field_name]", "Parent Date Field", "en" );
    $labelManager->addLabel( "[title_freq_parent_freq_id]", "Parent Frequency", "en" );
    $labelManager->addLabel( "[formLabel_freq_parent_freq_id]", "Parent Frequency", "en" );


    //
    // FrequencyValue table
    //
    $labelManager->addLabel( "[title_freqvalue_id]", "Frequency Value", "en" );
    $labelManager->addLabel( "[formLabel_freqvalue_id]", "Frequency Value", "en" );
    $labelManager->addLabel( "[title_freq_id]", "Frequency Type", "en" );
    $labelManager->addLabel( "[formLabel_freq_id]", "Frequency Type", "en" );
    $labelManager->addLabel( "[title_freqvalue_value]", "Frequency DateTime", "en" );
    $labelManager->addLabel( "[formLabel_freqvalue_value]", "Frequency DateTime", "en" );
    $labelManager->addLabel( "[title_freqvalue_desc]", "Frequency Value", "en" );
    $labelManager->addLabel( "[formLabel_freqvalue_desc]", "Frequency Value", "en" );


    //
    // Statistic table
    //
    $labelManager->addLabel( "[title_statistic_id]", "Statistic", "en" );
    $labelManager->addLabel( "[formLabel_statistic_id]", "Statistic", "en" );
    $labelManager->addLabel( "[title_statistic_name]", "Statistic", "en" );
    $labelManager->addLabel( "[formLabel_statistic_name]", "Statistic", "en" );
    $labelManager->addLabel( "[title_statistic_desc]", "Description", "en" );
    $labelManager->addLabel( "[formLabel_statistic_desc]", "Description", "en" );
    $labelManager->addLabel( "[title_statistic_type]", "Data Type", "en" );
    $labelManager->addLabel( "[formLabel_statistic_type]", "Data Type", "en" );
    $labelManager->addLabel( "[title_scope_id]", "Scope", "en" );
    $labelManager->addLabel( "[formLabel_scope_id]", "Scope", "en" );
    $labelManager->addLabel( "[title_scope_ref_id]", "Scope Instance", "en" );
    $labelManager->addLabel( "[formLabel_scope_ref_id]", "Scope Instance", "en" );
    $labelManager->addLabel( "[title_freq_id]", "Frequency", "en" );
    $labelManager->addLabel( "[formLabel_freq_id]", "Frequency", "en" );
    $labelManager->addLabel( "[title_meas_id]", "Measurement Type", "en" );
    $labelManager->addLabel( "[formLabel_meas_id]", "Measurement Type", "en" );


    //
    // StatisticValue table
    //
    $labelManager->addLabel( "[title_statvalues_id]", "Statistic Value", "en" );
    $labelManager->addLabel( "[formLabel_statvalues_id]", "Statistic Value", "en" );
    $labelManager->addLabel( "[title_statistic_id]", "Statistic Name", "en" );
    $labelManager->addLabel( "[formLabel_statistic_id]", "Statistic Name", "en" );
    $labelManager->addLabel( "[title_scope_id]", "Scope", "en" );
    $labelManager->addLabel( "[formLabel_scope_id]", "Scope", "en" );
    $labelManager->addLabel( "[title_scope_ref_id]", "Scope Instance", "en" );
    $labelManager->addLabel( "[formLabel_scope_ref_id]", "Scope Instance", "en" );
    $labelManager->addLabel( "[title_freqvalue_id]", "Frequency Value", "en" );
    $labelManager->addLabel( "[formLabel_freqvalue_id]", "Frequency Value", "en" );
    $labelManager->addLabel( "[title_meastype_id]", "Measurement Type", "en" );
    $labelManager->addLabel( "[formLabel_meastype_id]", "Measurement Type", "en" );
    $labelManager->addLabel( "[title_statvalues_value]", "Statistic Value", "en" );
    $labelManager->addLabel( "[formLabel_statvalues_value]", "Statistic Value", "en" );
    $labelManager->addLabel( "[title_statvalues_modtime]", "Update Time", "en" );
    $labelManager->addLabel( "[formLabel_statvalues_modtime]", "Update Time", "en" );
    $labelManager->addLabel( "[title_person_id]", "Value Author", "en" );
    $labelManager->addLabel( "[formLabel_person_id]", "Value Author", "en" );


    //
    // MeasurementType table
    //
    $labelManager->addLabel( "[title_meas_id]", "Measurement Type", "en" );
    $labelManager->addLabel( "[formLabel_meas_id]", "Measurement Type", "en" );
    $labelManager->addLabel( "[title_meas_name]", "Measurement Type", "en" );
    $labelManager->addLabel( "[formLabel_meas_name]", "Measurement Type", "en" );
    $labelManager->addLabel( "[title_meas_desc]", "Description", "en" );
    $labelManager->addLabel( "[formLabel_meas_desc]", "Description", "en" );


    //
    // Scope table
    //
    $labelManager->addLabel( "[title_scope_id]", "Scope", "en" );
    $labelManager->addLabel( "[formLabel_scope_id]", "Scope", "en" );
    $labelManager->addLabel( "[title_scope_name]", "Scope", "en" );
    $labelManager->addLabel( "[formLabel_scope_name]", "Scope", "en" );
    $labelManager->addLabel( "[title_scope_reftable]", "Scope's Table", "en" );
    $labelManager->addLabel( "[formLabel_scope_reftable]", "Scope's Table", "en" );


    //
    // ReportCalculation table
    //
    $labelManager->addLabel( "[title_filter_id]", "Calculation", "en" );
    $labelManager->addLabel( "[formLabel_filter_id]", "Calculation", "en" );
    $labelManager->addLabel( "[title_filter_name]", "Calculation", "en" );
    $labelManager->addLabel( "[formLabel_filter_name]", "Calculation", "en" );
    $labelManager->addLabel( "[title_filter_desc]", "Description", "en" );
    $labelManager->addLabel( "[formLabel_filter_desc]", "Description", "en" );


    //
    // StatDataType table
    //
    $labelManager->addLabel( "[title_statistic_type_id]", "Statistic Data Type", "en" );
    $labelManager->addLabel( "[formLabel_statistic_type_id]", "Statistic Data Type", "en" );
    $labelManager->addLabel( "[title_statistic_type]", "Statistic Data Type", "en" );
    $labelManager->addLabel( "[formLabel_statistic_type]", "Statistic Data Type", "en" );


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


    // Create StatsHome labels 
    $labelManager->addPage( page_GenericStatsHome::MULTILINGUAL_PAGE_KEY );

    $labelManager->addLabel( "[Instr]", "Welcome to the Power to Change Statistics System v1.0!", "en" );
    $labelManager->addLabel( "[Title]", "Statistics System Home", "en" );
    $labelManager->addLabel( "[submitStats]", "Submit Statistics", "en" );
    $labelManager->addLabel( "[generateReports]", "Generate Stats Reports", "en" );

    $labelManager->addLabel( "[editMinistry]", "Edit Ministries", "en" );
    $labelManager->addLabel( "[editDivision]", "Edit Divisions", "en" );
    $labelManager->addLabel( "[editRegion]", "Edit Regions", "en" );
    $labelManager->addLabel( "[editLocation]", "Edit Locations", "en" );
    $labelManager->addLabel( "[editStatistic]", "Edit Statistics", "en" );    
    
/*[RAD_PAGE(StatsHome)_LABELS]*/

    // Create StatsInputFilterForm labels 
    $labelManager->addPage( FormProcessor_StatsInputFilter::MULTILINGUAL_PAGE_KEY );
    
    $labelManager->addLabel( "[Title]", "Statistics Input Form", "en" );
    $labelManager->addLabel( "[Instr]", "Please choose values to determine which statistics you want to enter:", "en" );

/*[RAD_PAGE(StatsInputFilterForm)_LABELS]*/

    // Create StatsInputForm labels 
    $labelManager->addPage( FormProcessor_StatsInput::MULTILINGUAL_PAGE_KEY );
    
    $labelManager->addLabel( "[Title]", "Statistics Input Form", "en" );
    $labelManager->addLabel( "[Instr]", "Please enter your statistic values:", "en" );
    $labelManager->addLabel( "[NoStatsFound]", "NO statistics found... please choose different filter values.", "en" );

/*[RAD_PAGE(StatsInputFilterForm)_LABELS]*/


    // Create StatsReportFilterForm labels 
    $labelManager->addPage( FormProcessor_StatsReportFilter::MULTILINGUAL_PAGE_KEY );
    
    $labelManager->addLabel( "[Title]", "Report Statistics Filter Form", "en" );
    $labelManager->addLabel( "[Instr]", "Please choose values to determine which statistics you want to see a report for:", "en" );

/*[RAD_PAGE(StatsReportFilterForm)_LABELS]*/


    // Create StatsReportSelectionForm labels 
    $labelManager->addPage( FormProcessor_StatsReportSelection::MULTILINGUAL_PAGE_KEY );
    
    $labelManager->addLabel( "[Title]", "Report Statistics Selection Form", "en" );
    $labelManager->addLabel( "[Instr]", "Please choose one or more statistics and a date/time-range to report on:", "en" );
    
//     $labelManager->addLabel( "[formLabel_statistic_id]", "Statistics Available", "en" );
//     $labelManager->addLabel( "[formLabel_filter_id]", "Special Calculations Available", "en" );
    
/*[RAD_PAGE(StatsReportSelectionForm)_LABELS]*/

    // Create StatsReport labels 
    $labelManager->addPage( page_StatsReport::MULTILINGUAL_PAGE_KEY );
    
    $labelManager->addLabel( "[Title]", "Statistics Report", "en" );
    $labelManager->addLabel( "[Instr]", "Shown below are the statistics you requested:", "en" );
    
//     $labelManager->addLabel( "[formLabel_statistic_id]", "Statistics Available", "en" );
//     $labelManager->addLabel( "[formLabel_filter_id]", "Special Calculations Available", "en" );
    
/*[RAD_PAGE(StatsReportSelectionForm)_LABELS]*/

    
        // Create DownloadReport labels 
    $labelManager->addPage( page_DownloadReport::MULTILINGUAL_PAGE_KEY );

    $labelManager->addLabel( "[Title]", "Download Report", "en" );
    $labelManager->addLabel( "[Instr]", "Right-click on link below and click on 'Save Link As...' to download the report.<br>Left-click to view the data in your browser.", "en" );
//     $labelManager->addLabel( "[DownloadEventDataDump]", "Download Event Registration Summary Report", "en" );
//     $labelManager->addLabel( "[DownloadScholarshipDataDump]", "Download Event Scholarships Summary Report", "en" );
    $labelManager->addLabel( "[Continue]", "Continue", "en" );

/*[RAD_PAGE(DownloadReport)_LABELS]*/




    // Create EditMinistry labels 
    $labelManager->addPage( FormProcessor_EditMinistry::MULTILINGUAL_PAGE_KEY );

    $labelManager->addLabel( "[Instr]", "Update information using the form below:", "en" );
    $labelManager->addLabel( "[Title]", "Edit Ministry Information", "en" );
/*[RAD_PAGE(EditMinistry)_LABELS]*/



    // Create EditDivision labels 
    $labelManager->addPage( FormProcessor_EditDivision::MULTILINGUAL_PAGE_KEY );

    $labelManager->addLabel( "[Instr]", "Use the form below to update division information:", "en" );
    $labelManager->addLabel( "[Title]", "Edit Division Information", "en" );
/*[RAD_PAGE(EditDivision)_LABELS]*/



    // Create EditRegion labels 
    $labelManager->addPage( FormProcessor_EditRegion::MULTILINGUAL_PAGE_KEY );

    $labelManager->addLabel( "[Title]", "Edit Regions", "en" );
    $labelManager->addLabel( "[Instr]", "Use the form below to manage and create regions:", "en" );
/*[RAD_PAGE(EditRegion)_LABELS]*/



    // Create EditLocation labels 
    $labelManager->addPage( FormProcessor_EditLocation::MULTILINGUAL_PAGE_KEY );

    $labelManager->addLabel( "[Title]", "Edit Locations", "en" );
    $labelManager->addLabel( "[Instr]", "Use the form below to manage locations:", "en" );
/*[RAD_PAGE(EditLocation)_LABELS]*/




    // Create EditStatistic labels 
    $labelManager->addPage( FormProcessor_EditStatistic::MULTILINGUAL_PAGE_KEY );

    $labelManager->addLabel( "[Instr]", "Use the topmost form for adding a new statistic. To edit or delete statistics, use the list at the bottom of the page.", "en" );
    $labelManager->addLabel( "[Title]", "Manage Statistics", "en" );
/*[RAD_PAGE(EditStatistic)_LABELS]*/



/*[RAD_PAGE_LABEL]*/

     // load the labels for the side bar

//     $labelManager->addPage( obj_SideBar::MULTILINGUAL_PAGE_KEY );
//     $labelManager->addLabel( "[Heading]", "Event Registration", "en" );
//     $labelManager->addLabel( "[Notice]", "Note: You MUST click <u>".$labelManager->getLabel('[backToRegList]')."</u> when done registering.", "en" );
//     $labelManager->addLabel( "[RegCancel]", "Cancel Registration", "en" );	  
//     $labelManager->addLabel( "[editMyInfo]", "Step 1: Personal Info", "en" );
//     $labelManager->addLabel( "[editCampusInfo]", "Step 2: Campus-related Info", "en" );
//     $labelManager->addLabel( "[editFieldValues]", "Step 3: Event-specific Form Values", "en" );
//     $labelManager->addLabel( "[processFinances]", "Step 4: Process Finances", "en" );
//     $labelManager->addLabel( "[backToRegList]", "<br><b>Registration Completed</b>", "en");	//Back to Campus Registrations", "en" );
//     $labelManager->addLabel( "[backToEventList]", "<br><b>Registration Completed</b>", "en" );
    
//<br><b>Registration Completed</b>

    $labelManager->addPage( page_NotAuthorized::MULTILINGUAL_PAGE_KEY );
    $labelManager->addLabel( "[Title]", "Unauthorized Access Detected", "en" );
    $labelManager->addLabel( "[Instr]", "You do not have the required privileges for accessing this page.<br><br>You can use your browser's 'Back' button or use the menus to navigate back.", "en" );
    
    
} else {

    echo 'Skipping Labels ... <br>';
    
} // end if !skipLabels


?>