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

require ( 'app_cim_sch.php' );
require ( 'incl_cim_sch.php');


/*
 *  Directory Setup
 *
 *  Setup any specific directories used by this module.
 */
/*
if( !file_exists( modulecim_sch::DEF_DIR_DATA ) ) { 
    mkdir( modulecim_sch::DEF_DIR_DATA);
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


    $module->loadByKey( modulecim_sch::MODULE_KEY );
    $module->setKey( modulecim_sch::MODULE_KEY );
    $module->setPath( 'modules/app_cim_sch/' );
    $module->setApplicationFile( 'app_cim_sch.php' );
    $module->setIncludeFile( 'incl_cim_sch.php' );
    $module->setName( 'modulecim_sch' );
    $module->setParameters( '' );
    $module->setSystemAccessFile( 'objects_bl/obj_SystemAccess.php' );
    $module->setSystemAccessObj( modulecim_sch::MODULE_KEY.'Access' );
    
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
//$skipTables = isset($_REQUEST['skipTables']);
$skipTables = true;

// if NOT then reset the tables...
if ( !$skipTables ) {


    /*
     * CampusGroup Table
     *
     * Stores the relationships between the group and campus
     *
     * campusgroup_id [INTEGER]  ID of campus group
     * group_id [INTEGER]  ID of a group
     * campus_id [INTEGER]  ID of a campus
     */
    $CampusGroup = new RowManager_CampusGroupManager();

    $CampusGroup->dropTable();
    $CampusGroup->createTable();



    /*
     * Group Table
     *
     * Contains the meta data for each of the groups
     *
     * group_id [INTEGER]  ID of the group
     * groupType_id [INTEGER]  ID of the group type
     * group_name [STRING]  The name of the group
     * group_desc [STRING]  The description of the group
     */
    $Group = new RowManager_GroupManager();

    $Group->dropTable();
    $Group->createTable();



    /*
     * GroupAssociation Table
     *
     * Contains the relationship between the group and the person. 
     *
     * groupAssocation_id [INTEGER]  ID of the association between group and person
     * group_id [INTEGER]  ID of the group
     * person_id [INTEGER]  ID of the person
     */
    $GroupAssociation = new RowManager_GroupAssociationManager();

    $GroupAssociation->dropTable();
    $GroupAssociation->createTable();



    /*
     * ScheduleBlocks Table
     *
     * Object that stores information related to a person's schedule
     *
     * scheduleBlocks_id [INTEGER]  primary key
     * schedule_id [INTEGER]  foreign key to the meta-data associated with the schedule
     * scheduleBlocks_timeblock [INTEGER]  time blocks of a person's schedule
     */
    $ScheduleBlocks = new RowManager_ScheduleBlocksManager();

    $ScheduleBlocks->dropTable();
    $ScheduleBlocks->createTable();



    /*
     * GroupType Table
     *
     * Contains the types of groups
     *
     * groupType_id [INTEGER]  ID of the group type
     * groupType_desc [STRING]  The description of the group type
     */
    $GroupType = new RowManager_GroupTypeManager();

    $GroupType->dropTable();
    $GroupType->createTable();



    /*
     * Schedule Table
     *
     * Contains the meta data about each of the schedules
     *
     * schedule_id [INTEGER]  ID of the schedule
     * person_id [INTEGER]  ID of the person
     * timezones_id [INTEGER]  ID of the timezone
     * schedule_dateTimeStamp [DATE]  Date and time stamp whenever changes are made
     */
    $Schedule = new RowManager_ScheduleManager();

    $Schedule->dropTable();
    $Schedule->createTable();



    /*
     * TimeZones Table
     *
     * Contains all the time zones off sets
     *
     * timezones_id [INTEGER]  ID of the timezones
     * timezones_desc [STRING]  Time zones description
     * timezones_offset [INTEGER]  The value for the timezones offset
     */
    $TimeZones = new RowManager_TimeZonesManager();

    $TimeZones->dropTable();
    $TimeZones->createTable();



    /*
     * PermissionsCampusAdmin Table
     *
     * Contains the relationship between the viewer and campus. Campus Admin can access all group on an individual campus.
     *
     * permissionsCampusAdmin_id [INTEGER]  ID of the campus admin permissions
     * viewer_id [INTEGER]  ID of the viewer
     * campus_id [INTEGER]  ID of the campus
     */
    $PermissionsCampusAdmin = new RowManager_PermissionsCampusAdminManager();

    $PermissionsCampusAdmin->dropTable();
    $PermissionsCampusAdmin->createTable();



    /*
     * PermissionsGroupAdmin Table
     *
     * Contains the relationship between viewer and group. Group admin can only access the group that they are assign to.
     *
     * permissionsGroupAdmin_id [INTEGER]  ID of the group admin permissions
     * viewer_id [INTEGER]  ID of the viewer
     * group_id [INTEGER]  ID of the group
     * permissionsGroupAdmin_emailNotification [INTEGER]  To send the email notification to the user?
     * permissionsGroupAdmin_admin [INTEGER]  Indicate if the user is the admin for the group.
     */
    $PermissionsGroupAdmin = new RowManager_PermissionsGroupAdminManager();

    $PermissionsGroupAdmin->dropTable();
    $PermissionsGroupAdmin->createTable();



    /*
     * PermissionsSuperAdmin Table
     *
     * Contains all the super admins. Super Admin can access everything in the scheduler.
     *
     * permissionsSuperAdmin_id [INTEGER]  ID of the Super Admin Permissions
     * viewer_id [INTEGER]  ID of the viewer
     */
    $PermissionsSuperAdmin = new RowManager_PermissionsSuperAdminManager();

    $PermissionsSuperAdmin->dropTable();
    $PermissionsSuperAdmin->createTable();



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
    $labelManager->addSeries( modulecim_sch::MULTILINGUAL_SERIES_KEY );
    
    
    
    // Create General Field labels for modulecim_sch 
    $labelManager->addPage( modulecim_sch::MULTILINGUAL_PAGE_FIELDS );

    
    //
    // CampusGroup table
    //
    $labelManager->addLabel( "[title_campusgroup_id]", "Campus Group ID", "en" );
    $labelManager->addLabel( "[formLabel_campusgroup_id]", "Campus Group ID", "en" );
    $labelManager->addLabel( "[title_group_id]", "Group", "en" );
    $labelManager->addLabel( "[formLabel_group_id]", "Group", "en" );
    $labelManager->addLabel( "[title_campus_id]", "Campus", "en" );
    $labelManager->addLabel( "[formLabel_campus_id]", "Campus", "en" );


    //
    // Group table
    //
    $labelManager->addLabel( "[title_group_id]", "Group ID", "en" );
    $labelManager->addLabel( "[formLabel_group_id]", "Group ID", "en" );
    $labelManager->addLabel( "[title_groupType_id]", "Group Type ID", "en" );
    $labelManager->addLabel( "[formLabel_groupType_id]", "Group Type ID", "en" );
    $labelManager->addLabel( "[title_group_name]", "Group Name", "en" );
    $labelManager->addLabel( "[formLabel_group_name]", "Group Name", "en" );
    $labelManager->addLabel( "[title_group_desc]", "Group Description ", "en" );
    $labelManager->addLabel( "[formLabel_group_desc]", "Group Description ", "en" );


    //
    // GroupAssociation table
    //
    $labelManager->addLabel( "[title_groupAssocation_id]", "Group Assocation ID", "en" );
    $labelManager->addLabel( "[formLabel_groupAssocation_id]", "Group Assocation ID", "en" );
    $labelManager->addLabel( "[title_group_id]", "Group ID", "en" );
    $labelManager->addLabel( "[formLabel_group_id]", "Group ID", "en" );
    $labelManager->addLabel( "[title_person_id]", "Person ID", "en" );
    $labelManager->addLabel( "[formLabel_person_id]", "Person ID", "en" );


    //
    // ScheduleBlocks table
    //
    $labelManager->addLabel( "[title_scheduleBlocks_id]", "ScheduleBlocks ID", "en" );
    $labelManager->addLabel( "[formLabel_scheduleBlocks_id]", "ScheduleBlocks ID", "en" );
    $labelManager->addLabel( "[title_schedule_id]", "Schedule", "en" );
    $labelManager->addLabel( "[formLabel_schedule_id]", "Schedule", "en" );
    $labelManager->addLabel( "[title_scheduleBlocks_timeblock]", "Schedule Timeblocks", "en" );
    $labelManager->addLabel( "[formLabel_scheduleBlocks_timeblock]", "Schedule Timeblocks", "en" );


    //
    // GroupType table
    //
    $labelManager->addLabel( "[title_groupType_id]", "Group Type ID", "en" );
    $labelManager->addLabel( "[formLabel_groupType_id]", "Group Type ID", "en" );
    $labelManager->addLabel( "[title_groupType_desc]", "Group Type Description", "en" );
    $labelManager->addLabel( "[formLabel_groupType_desc]", "Group Type Description", "en" );


    //
    // Schedule table
    //
    $labelManager->addLabel( "[title_schedule_id]", "Schedule ID", "en" );
    $labelManager->addLabel( "[formLabel_schedule_id]", "Schedule ID", "en" );
    $labelManager->addLabel( "[title_person_id]", "Person ID", "en" );
    $labelManager->addLabel( "[formLabel_person_id]", "Person ID", "en" );
    $labelManager->addLabel( "[title_timezones_id]", "Time Zones ID", "en" );
    $labelManager->addLabel( "[formLabel_timezones_id]", "Time Zones ID", "en" );
    $labelManager->addLabel( "[title_schedule_dateTimeStamp]", "Schedule Date and Time Stamp", "en" );
    $labelManager->addLabel( "[formLabel_schedule_dateTimeStamp]", "Schedule Date and Time Stamp", "en" );


    //
    // TimeZones table
    //
    $labelManager->addLabel( "[title_timezones_id]", "Time Zones ID", "en" );
    $labelManager->addLabel( "[formLabel_timezones_id]", "Time Zones ID", "en" );
    $labelManager->addLabel( "[title_timezones_desc]", "Time Zones Description", "en" );
    $labelManager->addLabel( "[formLabel_timezones_desc]", "Time Zones Description", "en" );
    $labelManager->addLabel( "[title_timezones_offset]", "Time Zones Off Set", "en" );
    $labelManager->addLabel( "[formLabel_timezones_offset]", "Time Zones Off Set", "en" );


    //
    // PermissionsCampusAdmin table
    //
    $labelManager->addLabel( "[title_permissionsCampusAdmin_id]", "Campus Admin Permissions ID", "en" );
    $labelManager->addLabel( "[formLabel_permissionsCampusAdmin_id]", "Campus Admin Permissions ID", "en" );
    $labelManager->addLabel( "[title_viewer_id]", "Viewer ID", "en" );
    $labelManager->addLabel( "[formLabel_viewer_id]", "Viewer ID", "en" );
    $labelManager->addLabel( "[title_campus_id]", "Campus ID", "en" );
    $labelManager->addLabel( "[formLabel_campus_id]", "Campus ID", "en" );


    //
    // PermissionsGroupAdmin table
    //
    $labelManager->addLabel( "[title_permissionsGroupAdmin_id]", "Group Admin Permissions ID", "en" );
    $labelManager->addLabel( "[formLabel_permissionsGroupAdmin_id]", "Group Admin Permissions ID", "en" );
    $labelManager->addLabel( "[title_viewer_id]", "Viewer ID", "en" );
    $labelManager->addLabel( "[formLabel_viewer_id]", "Viewer ID", "en" );
    $labelManager->addLabel( "[title_group_id]", "Group ID", "en" );
    $labelManager->addLabel( "[formLabel_group_id]", "Group ID", "en" );
    $labelManager->addLabel( "[title_permissionsGroupAdmin_emailNotification]", "Group Admin Email Notification", "en" );
    $labelManager->addLabel( "[formLabel_permissionsGroupAdmin_emailNotification]", "Group Admin Email Notification", "en" );
    $labelManager->addLabel( "[title_permissionsGroupAdmin_admin]", "Group Admin", "en" );
    $labelManager->addLabel( "[formLabel_permissionsGroupAdmin_admin]", "Group Admin", "en" );


    //
    // PermissionsSuperAdmin table
    //
    $labelManager->addLabel( "[title_permissionsSuperAdmin_id]", "Supe Admin Permission ID", "en" );
    $labelManager->addLabel( "[formLabel_permissionsSuperAdmin_id]", "Supe Admin Permission ID", "en" );
    $labelManager->addLabel( "[title_viewer_id]", "Viewer ID", "en" );
    $labelManager->addLabel( "[formLabel_viewer_id]", "Viewer ID", "en" );


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


    // Create SchedulerHome labels 
    $labelManager->addPage( page_SchedulerHome::MULTILINGUAL_PAGE_KEY );

    $labelManager->addLabel( "[Instr]", "This is your scheduler homepage.", "en" );
    $labelManager->addLabel( "[Title]", "Online Scheduler Home", "en" );
/*[RAD_PAGE(SchedulerHome)_LABELS]*/



    // Create ManageTimeZones labels 
    $labelManager->addPage( FormProcessor_ManageTimeZones::MULTILINGUAL_PAGE_KEY );

    $labelManager->addLabel( "[Title]", "Manage Time Zones", "en" );
    $labelManager->addLabel( "[Instr]", "Use this page to manage time zones.", "en" );
/*[RAD_PAGE(ManageTimeZones)_LABELS]*/



    // Create AdminGroupType labels 
    $labelManager->addPage( FormProcessor_AdminGroupType::MULTILINGUAL_PAGE_KEY );

    $labelManager->addLabel( "[Title]", "Manage Group Types", "en" );
    $labelManager->addLabel( "[Instr]", "Use this interface to manage group types.", "en" );
/*[RAD_PAGE(AdminGroupType)_LABELS]*/



    // Create ManageSuperAdmin labels 
    $labelManager->addPage( FormProcessor_ManageSuperAdmin::MULTILINGUAL_PAGE_KEY );

    $labelManager->addLabel( "[Title]", "Manage Super Admin", "en" );
    $labelManager->addLabel( "[Instr]", "Use this interface to add or delete super admin. Super admins has access to all groups and all campuses. ", "en" );
/*[RAD_PAGE(ManageSuperAdmin)_LABELS]*/



    // Create MySchedule labels 
    $labelManager->addPage( page_MySchedule::MULTILINGUAL_PAGE_KEY );

    $labelManager->addLabel( "[Title]", "My Schedule", "en" );
    $labelManager->addLabel( "[Instr]", "Use this interface to edit your schedule.", "en" );
/*[RAD_PAGE(MySchedule)_LABELS]*/



    // Create ManageGroup labels 
    $labelManager->addPage( FormProcessor_ManageGroup::MULTILINGUAL_PAGE_KEY );

    $labelManager->addLabel( "[Title]", "Manage Group", "en" );
    $labelManager->addLabel( "[Instr]", "Use this page to manage information about a group.  Choose the campuses the group is accessible to.", "en" );
/*[RAD_PAGE(ManageGroup)_LABELS]*/



    // Create ManageCampusGroup labels 
    $labelManager->addPage( FormProcessor_ManageCampusGroup::MULTILINGUAL_PAGE_KEY );

    $labelManager->addLabel( "[Title]", "Manage Campus Group", "en" );
    $labelManager->addLabel( "[Instr]", "Select the campuses associated with this group.  If it is public, there is no need to set the campuses.", "en" );
/*[RAD_PAGE(ManageCampusGroup)_LABELS]*/



    // Create ViewGroups labels 
    $labelManager->addPage( page_ViewGroups::MULTILINGUAL_PAGE_KEY );

    $labelManager->addLabel( "[Title]", "View Groups", "en" );
    $labelManager->addLabel( "[Instr]", "Manage information about your groups.", "en" );
/*[RAD_PAGE(ViewGroups)_LABELS]*/



/*[RAD_PAGE_LABEL]*/

     // load the labels for the side bar

    $labelManager->addPage( obj_AdminSideBar::MULTILINGUAL_PAGE_KEY );
    $labelManager->addLabel( "[General]", "General", "en" );
    $labelManager->addLabel( "[SchedulerHome]", "Scheduler Home", "en" );
    $labelManager->addLabel( "[AdminLinks]", "Admin", "en" );
    $labelManager->addLabel( "[ManageTimezones]", "Manage Timezones", "en" );
    $labelManager->addLabel( "[ManageGroupTypes]", "Manage Group Types", "en" );
    $labelManager->addLabel( "[ManageSuperAdmin]", "Manage Super Admin", "en" );
	$labelManager->addLabel( "[MySchedule]", "My Schedule", "en" );
    
} else {

    echo 'Skipping Labels ... <br>';
    
} // end if !skipLabels


?>