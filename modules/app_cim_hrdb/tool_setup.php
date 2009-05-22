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

require ( 'app_cim_hrdb.php' );
require ( 'incl_cim_hrdb.php');


/*
 *  Directory Setup
 *
 *  Setup any specific directories used by this module.
 */
/*
if( !file_exists( modulecim_hrdb::DEF_DIR_DATA ) ) { 
    mkdir( modulecim_hrdb::DEF_DIR_DATA);
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


    $module->loadByKey( modulecim_hrdb::MODULE_KEY );
    $module->setKey( modulecim_hrdb::MODULE_KEY );
    $module->setPath( 'modules/app_cim_hrdb/' );
    $module->setApplicationFile( 'app_cim_hrdb.php' );
    $module->setIncludeFile( 'incl_cim_hrdb.php' );
    $module->setName( 'modulecim_hrdb' );
    $module->setParameters( '' );
    $module->setSystemAccessFile( 'objects_bl/obj_SystemAccess.php' );
    $module->setSystemAccessObj( modulecim_hrdb::MODULE_KEY.'Access' );
    
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
     * Person Table
     *
     * Manages data associated with a person.
     *
     * person_id [INTEGER]  a person'd unique id
     * person_fname [STRING]  A person's first name
     */
    $Person = new RowManager_PersonManager();

    $Person->dropTable();
    $Person->createTable();



    /*
     * Province Table
     *
     * Manages provinces
     *
     * province_id [INTEGER]  id of a province
     * province_desc [STRING]  Textual name of a province
     * province_shortDesc [STRING]  Short form of a province's name
     */
    $Province = new RowManager_ProvinceManager();

    $Province->dropTable();
    $Province->createTable();
    
    /*
     * Country Table
     *
     * Manages countries
     *
     * country_id [INTEGER]  id of a country
     * country_desc [STRING]  Textual name of a country
     * country_shortDesc [STRING]  Short form of a country's name
     */
    $Country = new RowManager_CountryManager();

    $Country->dropTable();
    $Country->createTable();




    /*
     * Campus Table
     *
     * Manages the Campus Table
     *
     * campus_id [INTEGER]  The id of the campus.
     * campus_desc [STRING]  The name of the Campus.
     * campus_shortDesc [STRING]  The short name for the campus.
     */
    $Campus = new RowManager_CampusManager();

    $Campus->dropTable();
    $Campus->createTable();



    /*
     * Person Table
     *
     * Manages data associated with a person.
     *
     * person_id [INTEGER]  a person'd unique id
     * person_fname [STRING]  A person's first name
     * person_lname [STRING]  A person's last name
     * person_phone [STRING]  A person's phone number
     * person_email [STRING]  A person's email
     * person_addr [STRING]  A person's address
     * person_city [STRING]  A person's city.
     * province_id [INTEGER]  The person's province.
     * person_pc [STRING]  Person Postal Code
     * gender_id [INTEGER]  The person's gender.
     */
    $Person = new RowManager_PersonManager();

    $Person->dropTable();
    $Person->createTable();



    /*
     * Gender Table
     *
     * Manages the gender table.
     *
     * gender_id [INTEGER]  The id of the gender.
     * gedner_desc [STRING]  The is the gender type.
     */
    $Gender = new RowManager_GenderManager();

    $Gender->dropTable();
    $Gender->createTable();



    /*
     * Admin Table
     *
     * Manages the Admin access table.
     *
     * admin_id [INTEGER]  The id.
     * viewer_id [INTEGER]  The user(viewer) id.
     * priv_id [INTEGER]  The privilege ID assigned to the user(viewer).
     */
    $Admin = new RowManager_AdminManager();

    $Admin->dropTable();
    $Admin->createTable();



    /*
     * Priv Table
     *
     * Manager for the Privileges table.
     *
     * priv_id [INTEGER]  The id for the privilege
     * priv_accesslevel [STRING]  The access level associated with the ID.
     */
    $Priv = new RowManager_PrivManager();

    $Priv->dropTable();
    $Priv->createTable();



    /*
     * CampusAdmin Table
     *
     * Manage for the CampusAdmin table.
     *
     * campusadmin_id [INTEGER]  ID for the assignment
     * admin_id [INTEGER]  The id from the admin table.
     * campus_id [INTEGER]  The id for the campus being assigned to the viewer.
     */
    $CampusAdmin = new RowManager_CampusAdminManager();

    $CampusAdmin->dropTable();
    $CampusAdmin->createTable();



    /*
     * Staff Table
     *
     * DAObj to manage the staff table.
     *
     * staff_id [INTEGER]  The id for the staff member.
     * person_id [INTEGER]  The id of the person who is staff.
     */
    $Staff = new RowManager_StaffManager();

    $Staff->dropTable();
    $Staff->createTable();



    /*
     * Admin Table
     *
     * Manages the Admin access table.
     *
     * admin_id [INTEGER]  The id.
     * viewer_id [INTEGER]  The user(viewer) id.
     * priv_id [INTEGER]  The privilege ID assigned to the user(viewer).
     */
    $Admin = new RowManager_AdminManager();

    $Admin->dropTable();
    $Admin->createTable();



    /*
     * CampusAdmin Table
     *
     * Manage for the CampusAdmin table.
     *
     * campusadmin_id [INTEGER]  ID for the assignment
     * admin_id [INTEGER]  The id from the admin table.
     * campus_id [INTEGER]  The id for the campus being assigned to the viewer.
     */
    $CampusAdmin = new RowManager_CampusAdminManager();

    $CampusAdmin->dropTable();
    $CampusAdmin->createTable();



    /*
     * Staff Table
     *
     * DAObj to manage the staff table.
     *
     * staff_id [INTEGER]  The id for the staff member.
     * person_id [INTEGER]  The id of the person who is staff.
     */
    $Staff = new RowManager_StaffManager();

    $Staff->dropTable();
    $Staff->createTable();



    /*
     * Viewer Table
     *
     * This is to use the accountadmin_viewer table to add an admin to the hrdb module.
     *
     * viewer_userID [STRING]  This stored the user id of the viewer.
     * viewer_id [INTEGER]  This is the id number for the viewer.
     */
    $Viewer = new RowManager_ViewerManager();

    $Viewer->dropTable();
    $Viewer->createTable();



    /*
     * Staff Table
     *
     * DAObj to manage the staff table.
     *
     * staff_id [INTEGER]  The id for the staff member.
     * person_id [INTEGER]  The id of the person who is staff.
     */
    $Staff = new RowManager_StaffManager();

    $Staff->dropTable();
    $Staff->createTable();



    /*
     * Assignments Table
     *
     * This manages the campus assignments table.
     *
     * assignment_id [INTEGER]  This is the key for this table.
     * person_id [INTEGER]  The is the person id for the person assigned to the campus.
     * campus_id [INTEGER]  The is the campus the person is assigned to.
     */
    $Assignments = new RowManager_AssignmentsManager();

    $Assignments->dropTable();
    $Assignments->createTable();



    /*
     * Access Table
     *
     * This manages the access table.
     *
     * access_id [INTEGER]  This is the key for the table
     * viewer_id [INTEGER]  This is the viewer(user) id of the user who is assigned to a person id.
     * person_id [INTEGER]  This is the person id connected to the viewer id.
     */
    $Access = new RowManager_AccessManager();

    $Access->dropTable();
    $Access->createTable();



    /*
     * Region Table
     *
     * manages regions
     *
     * region_id [INTEGER]  id of a region
     * reg_desc [STRING]  description of a region
     */
    $Region = new RowManager_RegionManager();

    $Region->dropTable();
    $Region->createTable();



    /*
     * EmergencyInfo Table
     *
     * a record of emergency info for a person
     *
     * emerg_id [INTEGER]  unique indentifier
     * person_id [INTEGER]  Person id
     * emerg_passportNum [STRING]  Passport number
     * emerg_passportOrigin [STRING]  passport's country of origin
     * emerg_passportExpiry [DATE]  passport date of expiry
     * emerg_contactName [STRING]  emergency contact name
     * emerg_contactRship [STRING]  emergency contact's relationship to the person
     * emerg_contactHome [STRING]  emergency contact's home phone number
     * emerg_contactWork [STRING]  emergency contact's work phone number
     * emerg_contactMobile [STRING]  emergency contact's mobile phone number
     * emerg_contactEmail [STRING]  emergency contact's email address
     * emerg_birthdate [DATE]  person's birthdate
     * emerg_medicalNotes [STRING]  medical notes about this person
     */
    $EmergencyInfo = new RowManager_EmergencyInfoManager();

    $EmergencyInfo->dropTable();
    $EmergencyInfo->createTable();



    /*
     * CampusAssignmentStatus Table
     *
     * The status of a person assigned to some campus.
     *
     * assignmentstatus_id [INTEGER]  unique identifier for a particular campus assignment status
     * assignmentstatus_desc [STRING]  Description of a particular campus assignment status
     */
    $CampusAssignmentStatus = new RowManager_CampusAssignmentStatusManager();

    $CampusAssignmentStatus->dropTable();
    $CampusAssignmentStatus->createTable();



    /*
     * EditCampusAssignment Table
     *
     * Page used to edit campus assignments for people. Assigns campus and some sort of campus status (i.e. student, staff, alumni, etc) to a person.
     *
     * assignment_id [INTEGER]  Unique id of some campus assignment for some student
     * person_id [INTEGER]  Unique id of the person being assigned a campus
     * campus_id [INTEGER]  Unique ID of the campus being assigned to a person
     * assignmentstatus_id [INTEGER]  ID referring to a particular status w.r.t. a campus (i.e. student, staff, etc)
     */
    $EditCampusAssignment = new RowManager_EditCampusAssignmentManager();

    $EditCampusAssignment->dropTable();
    $EditCampusAssignment->createTable();



    /*
     * ViewerToPersonAssignment Table
     *
     * Assigns user/viewer privileges to a user.
Privilege level depends on that given to viewer record.
     *
     * access_id [INTEGER]  Unique id of person-to-viewer assignment
     * viewer_id [INTEGER]  Unique id of some viewer/user record used to store login information
     * person_id [INTEGER]  Unique identifier for some person record
     */
    $ViewerToPersonAssignment = new RowManager_ViewerToPersonAssignmentManager();

    $ViewerToPersonAssignment->dropTable();
    $ViewerToPersonAssignment->createTable();



    /*
     * YearInSchool Table
     *
     * Manages the cim_hrdb_year_in_school table
     *
     * year_id [INTEGER]  unique id
     * year_desc [STRING]  text description of the year in school
     */
    $YearInSchool = new RowManager_YearInSchoolManager();

    $YearInSchool->dropTable();
    $YearInSchool->createTable();
    
    /*
     * PersonYear Table
     *
     * Manages the cim_hrdb_personyear table
     *
     * year_id [INTEGER]   id referencing year status
     * grad_date [DATE]  expected graduation date
     */
    $PersonYear = new RowManager_PersonYearManager();

    $PersonYear->dropTable();
    $PersonYear->createTable();



    /*
     * ActivityType Table
     *
     * a type of schedule activity (i.e. vacation, etc)
     *
     * activitytype_id [INTEGER]  unique id of the staff activity type
     * activitytype_desc [STRING]  Description of the activity type
     */
    $ActivityType = new RowManager_ActivityTypeManager();

    $ActivityType->dropTable();
    $ActivityType->createTable();



    /*
     * StaffActivity Table
     *
     * Records details about some staff member's scheduled activity.
     *
     * staffactivity_id [INTEGER]  unique id of the staff activity record
     * person_id [INTEGER]  the id of the staff person associated with the activity
     * staffactivity_startdate [DATE]  The start date of the activity
     * staffactivity_enddate [DATE]  The end date of the activity.
     * staffactivity_contactPhone [STRING]  The phone # where the staff member can be reached during the activity.
     * activitytype_id [INTEGER]  The activity's type (i.e. "vacation")
     */
    $StaffActivity = new RowManager_StaffActivityManager();

    $StaffActivity->dropTable();
    $StaffActivity->createTable();



    /*
     * StaffScheduleType Table
     *
     * The HRDB schedule/form type.
     *
     * staffscheduletype_id [INTEGER]  Unique ID for this form/schedule type
     * staffscheduletype_desc [STRING]  Description of the staff form/schedule type.
     * staffscheduletype_startdate [DATE]  The min. start date for the schedule/form context
     * staffscheduletype_enddate [DATE]  The max ending date for the schedule/form.
     */
    $StaffScheduleType = new RowManager_StaffScheduleTypeManager();

    $StaffScheduleType->dropTable();
    $StaffScheduleType->createTable();



    /*
     * StaffSchedule Table
     *
     * A particular staff person's schedule
     *
     * staffschedule_id [INTEGER]  Unique id of the person's schedule
     * person_id [INTEGER]  The id of the person associated with this schedule
     * staffscheduletype_id [INTEGER]  the id of the form associated with this personal schedule
     * staffschedule_approved [BOOL]  boolean indicating director's approval
     * staffschedule_approvedby [INTEGER]  the person_id of the director approving the schedule
     * staffschedule_lastmodifiedbydirector [DATE]  the timestamp of the last change *made by a director*
     * staffschedule_approvalnotes [STRING]  notes made by the director regarding approval
     */
    $StaffSchedule = new RowManager_StaffScheduleManager();

    $StaffSchedule->dropTable();
    $StaffSchedule->createTable();



    /*
     * ActivitySchedule Table
     *
     * object linking an activity to some schedule; allows an activity to be associated with more than one schedule/form
     *
     * activityschedule_id [INTEGER]  unique id of the object
     * staffactivity_id [INTEGER]  the id of the staff activity
     * staffschedule_id [INTEGER]  id of the schedule/form to associated with the activity
     */
    $ActivitySchedule = new RowManager_ActivityScheduleManager();

    $ActivitySchedule->dropTable();
    $ActivitySchedule->createTable();



    /*
     * FormField Table
     *
     * this is a HRDB form field object
     *
     * fields_id [INTEGER]  the unique id of the field
     * fieldtype_id [INTEGER]  The field type associated with the field (i.e. "checkbox")
     * fields_desc [STRING]  the description of the form field
     * staffscheduletype_id [INTEGER]  id of the form that this field belongs to
     * fields_priority [INTEGER]  the display priority of this form field
     * fields_reqd [BOOL]  whether or not this field is a required field (for the user to fill in)
     * fields_invalid [STRING]  an value that is invalid for this field
     * fields_hidden [BOOL]  whether this field is hidden to the general user
     * datatypes_id [INTEGER]  The id of the type of data this field expects, i.e. "numeric".
     */
    $FormField = new RowManager_FormFieldManager();

    $FormField->dropTable();
    $FormField->createTable();



    /*
     * FormFieldValue Table
     *
     * A record storing a field value entered via a HRDB form.
     *
     * fieldvalues_id [INTEGER]  The unique field value id.
     * fields_id [INTEGER]  The id of the form field where this value was entered.
     * fieldvalues_value [STRING]  The value stored.
     * person_id [INTEGER]  The person who entered the value stored.
     * fieldvalues_modTime [DATE]  The time when the value record was last changed.
     */
    $FormFieldValue = new RowManager_FormFieldValueManager();

    $FormFieldValue->dropTable();
    $FormFieldValue->createTable();



    /*
     * FieldGroup Table
     *
     * Object describing a group of fields
     *
     * fieldgroup_id [INTEGER]  Unique id of a field group
     * fieldgroup_desc [STRING]  The field group description/label.
     */
    $FieldGroup = new RowManager_FieldGroupManager();

    $FieldGroup->dropTable();
    $FieldGroup->createTable();



    /*
     * FieldGroup_Matches Table
     *
     * An object that matches a field group with some (repeatable form) field
     *
     * fieldgroup_matches_id [INTEGER]  The unique id of the matching
     * fieldgroup_id [INTEGER]  the id of the field group being matched
     * fields_id [INTEGER]  the id of the field being matched to a fieldgroup
     */
    $FieldGroup_Matches = new RowManager_FieldGroup_MatchesManager();

    $FieldGroup_Matches->dropTable();
    $FieldGroup_Matches->createTable();



    /*
     * StaffScheduleInstr Table
     *
     * The form instructions directly associated with a particular HRDB form
     *
     * staffscheduleinstr_toptext [STRING]  The instructions for the main (top) form.
     * staffscheduleinstr_bottomtext [STRING]  The instructions for the scheduled activities form (if it is used for this HR form).
     * staffscheduletype_id [INTEGER]  The primary id of the object - same primary ID as the schedule form type object.
     */
    $StaffScheduleInstr = new RowManager_StaffScheduleInstrManager();

    $StaffScheduleInstr->dropTable();
    $StaffScheduleInstr->createTable();



    /*
     * StaffDirector Table
     *
     * Stores staff-to-director associations. That is, it indicates which staff have which other staff as their director(s).
     *
     * staffdirector_id [INTEGER]  The unique ID of the staff-to-director association
     * staff_id [INTEGER]  The ID of the staff to be associated with a director.
     * director_id [INTEGER]  The staff ID of the staff director supervising the staff member indicated in the "staff_id" field.
     */
    $StaffDirector = new RowManager_StaffDirectorManager();

    $StaffDirector->dropTable();
    $StaffDirector->createTable();



    /*
     * CustomReports Table
     *
     * The object that allows access and editing of custom report names.
     *
     * report_id [INTEGER]  The unique ID of the custom report.
     * report_name [STRING]  The name of the custom HRDB report.
     */
    $CustomReports = new RowManager_CustomReportsManager();

    $CustomReports->dropTable();
    $CustomReports->createTable();



    /*
     * CustomFields Table
     *
     * The object used to associate HRDB form fields with a custom-built report.
     *
     * customfields_id [INTEGER]  The unique id of this custom report to HRDB form field match-up.
     * report_id [INTEGER]  The ID of the associated custom report.
     * fields_id [INTEGER]  The HRDB form field that should be associated with a custom report.
     */
    $CustomFields = new RowManager_CustomFieldsManager();

    $CustomFields->dropTable();
    $CustomFields->createTable();



    /*
     * Ministry Table
     *
     * Contains name and abbreviation of some ministry. Other data may be added in the future, i.e. description and website.
     *
     * ministry_id [INTEGER]  the unique primary id of the ministry
     * ministry_name [STRING]  The full name of the ministry.
     * ministry_abbrev [STRING]  The abbreviation of the ministry name.
     */
    $Ministry = new RowManager_MinistryManager();

    $Ministry->dropTable();
    $Ministry->createTable();



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
    $labelManager->addSeries( modulecim_hrdb::MULTILINGUAL_SERIES_KEY );



    // Create General Field labels for modulecim_hrdb
    $labelManager->addPage( modulecim_hrdb::MULTILINGUAL_PAGE_FIELDS );

    //
    // Country table
    //
    $labelManager->addLabel( "[title_country_desc]", "Country", "en" );
    $labelManager->addLabel( "[formLabel_country_desc]", "Country", "en" );
    $labelManager->addLabel( "[example_country_desc]", "Canada", "en" );
    $labelManager->addLabel( "[error_country_desc]", "Invalid country", "en" );
    $labelManager->addLabel( "[title_country_shortDesc]", "Short form", "en" );
    $labelManager->addLabel( "[formLabel_country_shortDesc]", "Short form", "en" );
    $labelManager->addLabel( "[example_country_shortDesc]", "CAN", "en" );
    $labelManager->addLabel( "[error_country_shortDesc]", "Invalid short form", "en" );    
    
    //
    // Province table
    //
    $labelManager->addLabel( "[title_province_desc]", "Province", "en" );
    $labelManager->addLabel( "[formLabel_province_desc]", "Province", "en" );
    $labelManager->addLabel( "[example_province_desc]", "Ontario", "en" );
    $labelManager->addLabel( "[error_province_desc]", "Invalid province", "en" );
    $labelManager->addLabel( "[title_province_shortDesc]", "Short form", "en" );
    $labelManager->addLabel( "[formLabel_province_shortDesc]", "Short form", "en" );
    $labelManager->addLabel( "[example_province_shortDesc]", "ON", "en" );
    $labelManager->addLabel( "[error_province_shortDesc]", "Invalid short form", "en" );


    //
    // Campus table
    //
    $labelManager->addLabel( "[title_campus_desc]", "Campus Name", "en" );
    $labelManager->addLabel( "[formLabel_campus_desc]", "Campus Name", "en" );
    $labelManager->addLabel( "[example_campus_desc]", "University of Waterloo", "en" );
    $labelManager->addLabel( "[error_campus_desc]", "Please enter the name of the Campus", "en" );
    $labelManager->addLabel( "[title_campus_shortDesc]", "Campus Short Name", "en" );
    $labelManager->addLabel( "[formLabel_campus_shortDesc]", "Campus Short Name", "en" );
    $labelManager->addLabel( "[example_campus_shortDesc]", "waterloo", "en" );
    $labelManager->addLabel( "[error_campus_shortDesc]", "Please enter the short name for the Campus", "en" );


    //
    // Person table
    //
    $labelManager->addLabel( "[title_person_fname]", "First Name", "en" );
    $labelManager->addLabel( "[formLabel_person_fname]", "First Name", "en" );
    $labelManager->addLabel( "[example_person_fname]", "Russ", "en" );
    $labelManager->addLabel( "[error_person_fname]", "Invalid first name.", "en" );
    
    $labelManager->addLabel( "[title_person_lname]", "Last Name", "en" );
    $labelManager->addLabel( "[formLabel_person_lname]", "Last Name", "en" );
    $labelManager->addLabel( "[example_person_lname]", "Martin", "en" );
    $labelManager->addLabel( "[error_person_lname]", "Invalid last name.", "en" );
    
    $labelManager->addLabel( "[title_person_legal_fname]", "Legal First Name", "en" );
    $labelManager->addLabel( "[formLabel_person_legal_fname]", "Legal First Name", "en" );
    $labelManager->addLabel( "[error_legal_person_fname]", "Invalid legal first name.", "en" );
    
    $labelManager->addLabel( "[title_person_legal_lname]", "Legal Last Name", "en" );
    $labelManager->addLabel( "[formLabel_person_legal_lname]", "Legal Last Name", "en" );
    $labelManager->addLabel( "[error_legal_person_lname]", "Invalid legal last name.", "en" );
    
    $labelManager->addLabel( "[title_person_phone]", "Permanent Phone Number", "en" );
    $labelManager->addLabel( "[formLabel_person_phone]", "Permanent Phone Number", "en" );
    $labelManager->addLabel( "[example_person_phone]", "(519) 123-4567", "en" );
    $labelManager->addLabel( "[error_person_phone]", "Invalid permanent phone number.", "en" );
    
    $labelManager->addLabel( "[title_person_local_phone]", "Local Phone Number", "en" );
    $labelManager->addLabel( "[formLabel_person_local_phone]", "Local Phone Number", "en" );
    $labelManager->addLabel( "[example_person_local_phone]", "(519) 123-4567", "en" );
    $labelManager->addLabel( "[error_person_local_phone]", "Invalid local phone number.", "en" );
    
    $labelManager->addLabel( "[title_person_email]", "Email", "en" );
    $labelManager->addLabel( "[formLabel_person_email]", "Email", "en" );
    $labelManager->addLabel( "[example_person_email]", "bart@simpsons.com", "en" );
    $labelManager->addLabel( "[error_person_email]", "Invalid email.", "en" );
    
    $labelManager->addLabel( "[title_person_addr]", "Permanent Address", "en" );
    $labelManager->addLabel( "[formLabel_person_addr]", "Permanent Address", "en" );
    $labelManager->addLabel( "[example_person_addr]", "1234 Pine Street", "en" );
    $labelManager->addLabel( "[error_person_addr]", "Invalid permanent address.", "en" );
    
    $labelManager->addLabel( "[title_person_local_addr]", "Local Address", "en" );
    $labelManager->addLabel( "[formLabel_person_local_addr]", "Local Address", "en" );
    $labelManager->addLabel( "[example_person_local_addr]", "1234 Pine Street", "en" );
    $labelManager->addLabel( "[error_person_local_addr]", "Invalid local address.", "en" );
    
    $labelManager->addLabel( "[title_person_city]", "Permanent City", "en" );
    $labelManager->addLabel( "[formLabel_person_city]", "Permanent City", "en" );
    $labelManager->addLabel( "[example_person_city]", "Waterloo", "en" );
    $labelManager->addLabel( "[error_person_city]", "Invalid permanent city.", "en" );
    
    $labelManager->addLabel( "[title_person_local_city]", "Local City", "en" );
    $labelManager->addLabel( "[formLabel_person_local_city]", "Local City", "en" );
    $labelManager->addLabel( "[example_person_local_city]", "Waterloo", "en" );
    $labelManager->addLabel( "[error_person_local_city]", "Invalid local city.", "en" );
    
    $labelManager->addLabel( "[title_province_id]", "Permanent Province", "en" );
    $labelManager->addLabel( "[formLabel_province_id]", "Permanent Province", "en" );
    $labelManager->addLabel( "[example_province_id]", "ON", "en" );
    $labelManager->addLabel( "[error_province_id]", "Please pick a province.", "en" );
    
    $labelManager->addLabel( "[title_person_local_province_id]", "Local Province", "en" );
    $labelManager->addLabel( "[formLabel_person_local_province_id]", "Local Province", "en" );
    $labelManager->addLabel( "[example_person_local_province_id]", "ON", "en" );
    $labelManager->addLabel( "[error_person_local_province_id]", "Please pick a province.", "en" );
    
    $labelManager->addLabel( "[title_person_pc]", "Permanent Postal Code", "en" );
    $labelManager->addLabel( "[formLabel_person_pc]", "Permanent Postal Code", "en" );
    $labelManager->addLabel( "[example_person_pc]", "N23 G76", "en" );
    $labelManager->addLabel( "[error_person_pc]", "Invalid permanent Postal Code.", "en" );
    
    $labelManager->addLabel( "[title_person_local_pc]", "Local Postal Code", "en" );
    $labelManager->addLabel( "[formLabel_person_local_pc]", "Local Postal Code", "en" );
    $labelManager->addLabel( "[example_person_local_pc]", "N23 G76", "en" );
    $labelManager->addLabel( "[error_person_local_pc]", "Invalid local Postal Code.", "en" );
    
    $labelManager->addLabel( "[title_gender_id]", "Gender", "en" );
    $labelManager->addLabel( "[formLabel_gender_id]", "Gender", "en" );
    $labelManager->addLabel( "[example_gender_id]", "Male", "en" );
    $labelManager->addLabel( "[error_gender_id]", "Please pick a gender.", "en" );


    //
    // Gender table
    //
    $labelManager->addLabel( "[title_gender_id]", "Gender ID", "en" );
    $labelManager->addLabel( "[formLabel_gender_id]", "Gender ID", "en" );
    $labelManager->addLabel( "[example_gender_id]", "1", "en" );
    $labelManager->addLabel( "[error_gender_id]", "Invalid gender.", "en" );
    $labelManager->addLabel( "[title_gedner_desc]", "Gender", "en" );
    $labelManager->addLabel( "[formLabel_gedner_desc]", "Gender", "en" );
    $labelManager->addLabel( "[example_gedner_desc]", "Male", "en" );
    $labelManager->addLabel( "[error_gedner_desc]", "Please pick the gender.", "en" );


    //
    // Admin table
    //
    $labelManager->addLabel( "[title_viewer_id]", "Viewer", "en" );
    $labelManager->addLabel( "[formLabel_viewer_id]", "Viewer", "en" );
    $labelManager->addLabel( "[example_viewer_id]", "suraj.reddy", "en" );
    $labelManager->addLabel( "[error_viewer_id]", "Pleace select a viewer to assign the privilege to.", "en" );
    $labelManager->addLabel( "[title_priv_id]", "Privilege", "en" );
    $labelManager->addLabel( "[formLabel_priv_id]", "Privilege", "en" );
    $labelManager->addLabel( "[example_priv_id]", "campus", "en" );
    $labelManager->addLabel( "[error_priv_id]", "Pleace select a privilege", "en" );


    //
    // Priv table
    //
    $labelManager->addLabel( "[title_priv_accesslevel]", "Access", "en" );
    $labelManager->addLabel( "[formLabel_priv_accesslevel]", "Access", "en" );
    $labelManager->addLabel( "[example_priv_accesslevel]", "Campus", "en" );
    $labelManager->addLabel( "[error_priv_accesslevel]", "Please enter a name for the Access Level.", "en" );


    //
    // CampusAdmin table
    //
    $labelManager->addLabel( "[title_campus_id]", "Campus", "en" );
    $labelManager->addLabel( "[formLabel_campus_id]", "Campus", "en" );
    $labelManager->addLabel( "[example_campus_id]", "University of Waterloo", "en" );
    $labelManager->addLabel( "[error_campus_id]", "Please select a campus.", "en" );


    //
    // Staff table
    //
    $labelManager->addLabel( "[title_is_active]", "Active?", "en" );    


    //
    // Admin table
    //
    $labelManager->addLabel( "[title_viewer_id]", "Viewer", "en" );
    $labelManager->addLabel( "[formLabel_viewer_id]", "Viewer", "en" );
    $labelManager->addLabel( "[example_viewer_id]", "suraj.reddy", "en" );
    $labelManager->addLabel( "[error_viewer_id]", "Pleace select a viewer to assign the privilege to.", "en" );
    $labelManager->addLabel( "[title_priv_id]", "Privilege", "en" );
    $labelManager->addLabel( "[formLabel_priv_id]", "Privilege", "en" );
    $labelManager->addLabel( "[example_priv_id]", "campus", "en" );
    $labelManager->addLabel( "[error_priv_id]", "Pleace select a privilege", "en" );


    //
    // CampusAdmin table
    //
    $labelManager->addLabel( "[title_campus_id]", "Campus", "en" );
    $labelManager->addLabel( "[formLabel_campus_id]", "Campus", "en" );
    $labelManager->addLabel( "[example_campus_id]", "University of Waterloo", "en" );
    $labelManager->addLabel( "[error_campus_id]", "Please select a campus.", "en" );


    //
    // Staff table
    //


    //
    // Viewer table
    //
    $labelManager->addLabel( "[title_viewer_id]", "User ID", "en" );
    $labelManager->addLabel( "[title_viewer_userID]", "User ID", "en" );
    $labelManager->addLabel( "[formLabel_viewer_id]", "User ID", "en" );
    $labelManager->addLabel( "[example_viewer_id]", "jimbot12", "en" );
    $labelManager->addLabel( "[error_viewer_id]", "Please pick a viewer id.", "en" );


    //
    // Staff table
    //
    $labelManager->addLabel( "[title_person_id]", "Person", "en" );
    $labelManager->addLabel( "[formLabel_person_id]", "Person", "en" );
    $labelManager->addLabel( "[example_person_id]", "Sean Cullen", "en" );
    $labelManager->addLabel( "[error_person_id]", "Please pick a person to make staff.", "en" );


    //
    // Assignments table
    //
    $labelManager->addLabel( "[title_campus_id]", "Campus", "en" );
    $labelManager->addLabel( "[formLabel_campus_id]", "Campus", "en" );
    $labelManager->addLabel( "[example_campus_id]", "University of Waterloo", "en" );
    $labelManager->addLabel( "[error_campus_id]", "Please pick a campus.", "en" );
    $labelManager->addLabel( "[title_assignmentstatus_id]", "Status", "en" );


    //
    // Access table
    //
    $labelManager->addLabel( "[title_viewer_id]", "Viewer", "en" );
    $labelManager->addLabel( "[formLabel_viewer_id]", "Viewer", "en" );
    $labelManager->addLabel( "[example_viewer_id]", "string", "en" );
    $labelManager->addLabel( "[error_viewer_id]", "Please pick a viewer id.", "en" );
    $labelManager->addLabel( "[title_person_id]", "Person", "en" );
    $labelManager->addLabel( "[formLabel_person_id]", "Person", "en" );
    $labelManager->addLabel( "[example_person_id]", "Suraj Reddy", "en" );
    $labelManager->addLabel( "[error_person_id]", "Please pick a person id.", "en" );


    //
    // Region table
    //
    $labelManager->addLabel( "[title_region_id]", "Region ID", "en" );
    $labelManager->addLabel( "[formLabel_region_id]", "Region ID", "en" );
    $labelManager->addLabel( "[title_reg_desc]", "Region Desc", "en" );
    $labelManager->addLabel( "[formLabel_reg_desc]", "Region Description", "en" );
    $labelManager->addLabel( "[title_country_id]", "Country", "en" );
    $labelManager->addLabel( "[formLabel_country_id]", "Country", "en" );


    //
    // EmergencyInfo table
    //
    $labelManager->addLabel( "[title_emerg_id]", "Emergency ID", "en" );
    $labelManager->addLabel( "[formLabel_emerg_id]", "Emergency ID", "en" );
    $labelManager->addLabel( "[example_emerg_id]", "342", "en" );
    $labelManager->addLabel( "[error_emerg_id]", "invalid emerg_id", "en" );
    $labelManager->addLabel( "[title_person_id]", "Person", "en" );
    $labelManager->addLabel( "[formLabel_person_id]", "Person", "en" );
    $labelManager->addLabel( "[example_person_id]", "Bart Simpson", "en" );
    $labelManager->addLabel( "[error_person_id]", "invalid person_id", "en" );
    $labelManager->addLabel( "[title_emerg_passportNum]", "Passport Number", "en" );
    $labelManager->addLabel( "[formLabel_emerg_passportNum]", "Passport Number", "en" );
    $labelManager->addLabel( "[example_emerg_passportNum]", "JS205369", "en" );
    $labelManager->addLabel( "[error_emerg_passportNum]", "invalid passport number", "en" );
    $labelManager->addLabel( "[title_emerg_passportOrigin]", "Passport Issuing Country", "en" );
    $labelManager->addLabel( "[formLabel_emerg_passportOrigin]", "Passport Issuing Country", "en" );
    $labelManager->addLabel( "[example_emerg_passportOrigin]", "Canada", "en" );
    $labelManager->addLabel( "[error_emerg_passportOrigin]", "invalid passport origin", "en" );
    $labelManager->addLabel( "[title_emerg_passportExpiry]", "Passport Expiry", "en" );
    $labelManager->addLabel( "[formLabel_emerg_passportExpiry]", "Passport Expiry", "en" );
    $labelManager->addLabel( "[example_emerg_passportExpiry]", "2007-02-24", "en" );
    $labelManager->addLabel( "[error_emerg_passportExpiry]", "invalid passport expiry", "en" );
    $labelManager->addLabel( "[title_emerg_contactName]", "Emergency Contact", "en" );
    $labelManager->addLabel( "[formLabel_emerg_contactName]", "Emergency Contact", "en" );
    $labelManager->addLabel( "[example_emerg_contactName]", "Marg Simpson", "en" );
    $labelManager->addLabel( "[error_emerg_contactName]", "invalid contact name", "en" );
    $labelManager->addLabel( "[title_emerg_contactRship]", "Contact's Relationship", "en" );
    $labelManager->addLabel( "[formLabel_emerg_contactRship]", "Contact's Relationship", "en" );
    $labelManager->addLabel( "[example_emerg_contactRship]", "Wife", "en" );
    $labelManager->addLabel( "[error_emerg_contactRship]", "invalid contact relationship", "en" );
    $labelManager->addLabel( "[title_emerg_contactHome]", "Contact Home Phone", "en" );
    $labelManager->addLabel( "[formLabel_emerg_contactHome]", "Contact Home Phone", "en" );
    $labelManager->addLabel( "[example_emerg_contactHome]", "519 234 1111", "en" );
    $labelManager->addLabel( "[error_emerg_contactHome]", "invalid home phone", "en" );
    $labelManager->addLabel( "[title_emerg_contactWork]", "Contact Work Phone", "en" );
    $labelManager->addLabel( "[formLabel_emerg_contactWork]", "Contact Work Phone", "en" );
    $labelManager->addLabel( "[example_emerg_contactWork]", "905 813 6240", "en" );
    $labelManager->addLabel( "[error_emerg_contactWork]", "invalid work phone", "en" );
    $labelManager->addLabel( "[title_emerg_contactMobile]", "Contact Mobile Phone", "en" );
    $labelManager->addLabel( "[formLabel_emerg_contactMobile]", "Contact Mobile Phone", "en" );
    $labelManager->addLabel( "[example_emerg_contactMobile]", "416 625 3632", "en" );
    $labelManager->addLabel( "[error_emerg_contactMobile]", "invalid mobile phone", "en" );
    $labelManager->addLabel( "[title_emerg_contactEmail]", "Contact Email", "en" );
    $labelManager->addLabel( "[formLabel_emerg_contactEmail]", "Contact Email", "en" );
    $labelManager->addLabel( "[example_emerg_contactEmail]", "marg.simpson@c4c.ca", "en" );
    $labelManager->addLabel( "[error_emerg_contactEmail]", "invalid email", "en" );
    $labelManager->addLabel( "[title_emerg_birthdate]", "Birthdate", "en" );
    $labelManager->addLabel( "[formLabel_emerg_birthdate]", "Birthdate", "en" );
    $labelManager->addLabel( "[example_emerg_birthdate]", "1982-04-01", "en" );
    $labelManager->addLabel( "[error_emerg_birthdate]", "invalid birthdate", "en" );
    $labelManager->addLabel( "[title_emerg_medicalNotes]", "Medical Notes", "en" );
    $labelManager->addLabel( "[formLabel_emerg_medicalNotes]", "Medical Notes", "en" );
    $labelManager->addLabel( "[example_emerg_medicalNotes]", "severe allergy to peanuts", "en" );
    $labelManager->addLabel( "[error_emerg_medicalNotes]", "invalid medical notes", "en" );


    //
    // CampusAssignmentStatus table
    //
    $labelManager->addLabel( "[title_assignmentstatus_id]", "Assignment Status", "en" );
    $labelManager->addLabel( "[formLabel_assignmentstatus_id]", "Assignment Status", "en" );
    $labelManager->addLabel( "[title_assignmentstatus_desc]", "Assignment Status", "en" );
    $labelManager->addLabel( "[formLabel_assignmentstatus_desc]", "Assignment Status", "en" );


    //
    // EditCampusAssignment table
    //
    $labelManager->addLabel( "[title_assignment_id]", "Assignment ID", "en" );
    $labelManager->addLabel( "[formLabel_assignment_id]", "Assignment ID", "en" );
    $labelManager->addLabel( "[title_person_id]", "Person", "en" );
    $labelManager->addLabel( "[formLabel_person_id]", "Person", "en" );
    $labelManager->addLabel( "[title_campus_id]", "Campus", "en" );
    $labelManager->addLabel( "[formLabel_campus_id]", "Campus", "en" );
    $labelManager->addLabel( "[title_assignmentstatus_id]", "Campus Status", "en" );
    $labelManager->addLabel( "[formLabel_assignmentstatus_id]", "Campus Status", "en" );


    //
    // ViewerToPersonAssignment table
    //
    $labelManager->addLabel( "[title_access_id]", "Access ID", "en" );
    $labelManager->addLabel( "[formLabel_access_id]", "Access ID", "en" );
    $labelManager->addLabel( "[title_viewer_id]", "User", "en" );
    $labelManager->addLabel( "[formLabel_viewer_id]", "User", "en" );
    $labelManager->addLabel( "[title_person_id]", "Person", "en" );
    $labelManager->addLabel( "[formLabel_person_id]", "Person", "en" );


    //
    // YearInSchool table
    //
    $labelManager->addLabel( "[title_year_id]", "Year ID", "en" );
    $labelManager->addLabel( "[formLabel_year_id]", "Year ID", "en" );
    $labelManager->addLabel( "[title_year_desc]", "Year Desc", "en" );
    $labelManager->addLabel( "[formLabel_year_desc]", "Year Desc", "en" );
    
    //
    // PersonYear table
    //    
    $labelManager->addLabel( "[title_grad_date]", "Expected Graduation Date (YYYY-MM-DD)", "en" );
    $labelManager->addLabel( "[formLabel_grad_date]", "Expected Graduation Date<BR>(YYYY-MM-DD)", "en" );

    //
    // ActivityType table
    //
    $labelManager->addLabel( "[title_activitytype_id]", "Activity Type", "en" );
    $labelManager->addLabel( "[formLabel_activitytype_id]", "Activity Type", "en" );
    $labelManager->addLabel( "[title_activitytype_desc]", "Activity Type", "en" );
    $labelManager->addLabel( "[formLabel_activitytype_desc]", "Activity Type", "en" );
    $labelManager->addLabel( "[example_activitytype_desc]", "Staff Vacation", "en" );
	 $labelManager->addLabel( "[title_activitytype_abbr]", "Activity Abbrev.", "en" ); 
	 $labelManager->addLabel( "[formLabel_activitytype_abbr]", "Activity Abbrev.", "en" ); 
	 $labelManager->addLabel( "[title_activitytype_color]", "Activity Tag Colour", "en" ); 
	 $labelManager->addLabel( "[formLabel_activitytype_color]", "Activity Tag Colour", "en" ); 
		
	
			 

    //
    // StaffActivity table
    //
    $labelManager->addLabel( "[title_staffactivity_id]", "Staff Activity", "en" );
    $labelManager->addLabel( "[formLabel_staffactivity_id]", "Staff Activity", "en" );
    $labelManager->addLabel( "[title_person_id]", "Staff", "en" );
    $labelManager->addLabel( "[formLabel_person_id]", "Staff", "en" );
    $labelManager->addLabel( "[title_staffactivity_startdate]", "Start Date", "en" );
    $labelManager->addLabel( "[formLabel_staffactivity_startdate]", "Start Date", "en" );
    $labelManager->addLabel( "[title_staffactivity_enddate]", "End Date", "en" );
    $labelManager->addLabel( "[formLabel_staffactivity_enddate]", "End Date", "en" );
    $labelManager->addLabel( "[title_staffactivity_contactPhone]", "Contact Phone #", "en" );
    $labelManager->addLabel( "[formLabel_staffactivity_contactPhone]", "Contact Phone #", "en" );
    $labelManager->addLabel( "[title_activitytype_id]", "Activity Type", "en" );
    $labelManager->addLabel( "[formLabel_activitytype_id]", "Activity Type", "en" );


    //
    // StaffScheduleType table
    //
    $labelManager->addLabel( "[title_staffscheduletype_id]", "Form Name", "en" );
    $labelManager->addLabel( "[formLabel_staffscheduletype_id]", "Form Name", "en" );
    $labelManager->addLabel( "[title_staffscheduletype_desc]", "Form Name", "en" );
    $labelManager->addLabel( "[formLabel_staffscheduletype_desc]", "Form Name", "en" );
    $labelManager->addLabel( "[title_staffscheduletype_startdate]", "First Valid Date", "en" );
    $labelManager->addLabel( "[formLabel_staffscheduletype_startdate]", "First Valid Date", "en" );
    $labelManager->addLabel( "[title_staffscheduletype_enddate]", "Last Valid Date", "en" );
    $labelManager->addLabel( "[formLabel_staffscheduletype_enddate]", "Last Valid Date", "en" );
    $labelManager->addLabel( "[title_staffscheduletype_has_activities]", "Include Scheduled Events?", "en" );
    $labelManager->addLabel( "[formLabel_staffscheduletype_has_activities]", "Include Scheduled Events?", "en" );
    $labelManager->addLabel( "[formLabel_staffscheduletype_has_activity_phone]", "Include Event Contact Phone #?", "en" );
    $labelManager->addLabel( "[title_staffscheduletype_has_activity_phone]", "Include Event Contact Phone #?", "en" );	
    $labelManager->addLabel( "[formLabel_staffscheduletype_activity_types]", "Filter by these Activity Types:<br>(Ignore to allow all activity types. Filter by multiple types by using Ctrl+click on the choices.)", "en" );
    $labelManager->addLabel( "[title_staffscheduletype_activity_types]", "Filter by these Activity Types:", "en" );	
    $labelManager->addLabel( "[title_staffscheduletype_is_shown]", "Is form accessible?", "en" );
    $labelManager->addLabel( "[formLabel_staffscheduletype_is_shown]", "Allow all staff access to this form?", "en" );


    //
    // StaffSchedule table
    //
    $labelManager->addLabel( "[title_staffschedule_id]", "Staff Schedule ID", "en" );
    $labelManager->addLabel( "[formLabel_staffschedule_id]", "Staff Schedule ID", "en" );
    $labelManager->addLabel( "[title_person_id]", "Staff", "en" );
    $labelManager->addLabel( "[formLabel_person_id]", "Staff", "en" );
    $labelManager->addLabel( "[title_staffscheduletype_id]", "Associated Form", "en" );
    $labelManager->addLabel( "[formLabel_staffscheduletype_id]", "Associated Form", "en" );
    $labelManager->addLabel( "[title_staffschedule_approved]", "Approved?", "en" );
    $labelManager->addLabel( "[formLabel_staffschedule_approved]", "Approved?", "en" );
    $labelManager->addLabel( "[title_staffschedule_approvedby]", "Approved By", "en" );
    $labelManager->addLabel( "[formLabel_staffschedule_approvedby]", "Approved By", "en" );
    $labelManager->addLabel( "[title_staffschedule_lastmodifiedbydirector]", "Last Admin Change", "en" );
    $labelManager->addLabel( "[formLabel_staffschedule_lastmodifiedbydirector]", "Last Admin Change", "en" );
    $labelManager->addLabel( "[title_staffschedule_approvalnotes]", "Approval Notes", "en" );
    $labelManager->addLabel( "[formLabel_staffschedule_approvalnotes]", "Approval Notes", "en" );


    //
    // ActivitySchedule table
    //
    $labelManager->addLabel( "[title_activityschedule_id]", "Activity-Schedule ID", "en" );
    $labelManager->addLabel( "[formLabel_activityschedule_id]", "Activity-Schedule ID", "en" );
    $labelManager->addLabel( "[title_staffactivity_id]", "Staff Activity", "en" );
    $labelManager->addLabel( "[formLabel_staffactivity_id]", "Staff Activity", "en" );
    $labelManager->addLabel( "[title_staffschedule_id]", "Staff Schedule", "en" );
    $labelManager->addLabel( "[formLabel_staffschedule_id]", "Staff Schedule", "en" );


    //
    // FormField table
    //
    $labelManager->addLabel( "[title_fields_id]", "Form Field", "en" );
    $labelManager->addLabel( "[formLabel_fields_id]", "Form Field", "en" );
    $labelManager->addLabel( "[title_fieldtype_id]", "Field Type", "en" );
    $labelManager->addLabel( "[formLabel_fieldtype_id]", "Field Type", "en" );
    $labelManager->addLabel( "[title_fields_desc]", "Field Description", "en" );
    $labelManager->addLabel( "[formLabel_fields_desc]", "Field Description", "en" );
    $labelManager->addLabel( "[title_staffscheduletype_id]", "Associated Form", "en" );
    $labelManager->addLabel( "[formLabel_staffscheduletype_id]", "Associated Form", "en" );
    $labelManager->addLabel( "[title_fields_priority]", "Display Priority", "en" );
    $labelManager->addLabel( "[formLabel_fields_priority]", "Display Priority", "en" );
    $labelManager->addLabel( "[title_fields_reqd]", "Required?", "en" );
    $labelManager->addLabel( "[formLabel_fields_reqd]", "Required?", "en" );
    $labelManager->addLabel( "[title_fields_invalid]", "Invalid Data", "en" );
    $labelManager->addLabel( "[formLabel_fields_invalid]", "Invalid Data", "en" );
    $labelManager->addLabel( "[title_fields_hidden]", "Hidden?", "en" );
    $labelManager->addLabel( "[formLabel_fields_hidden]", "Hidden?", "en" );
    $labelManager->addLabel( "[title_datatypes_id]", "Data Type", "en" );
    $labelManager->addLabel( "[formLabel_datatypes_id]", "Data Type", "en" );
    $labelManager->addLabel( "[title_fields_note]", "Field Note", "en" );
    $labelManager->addLabel( "[formLabel_fields_note]", "Field Note", "en" );
    


    //
    // FormFieldValue table
    //
    $labelManager->addLabel( "[title_fieldvalues_id]", "Field Value", "en" );
    $labelManager->addLabel( "[formLabel_fieldvalues_id]", "Field Value", "en" );
    $labelManager->addLabel( "[title_fields_id]", "Associated Field", "en" );
    $labelManager->addLabel( "[formLabel_fields_id]", "Associated Field", "en" );
    $labelManager->addLabel( "[title_fieldvalues_value]", "Field Value", "en" );
    $labelManager->addLabel( "[formLabel_fieldvalues_value]", "Field Value", "en" );
    $labelManager->addLabel( "[title_person_id]", "Data Entry Person", "en" );
    $labelManager->addLabel( "[formLabel_person_id]", "Data Entry Person", "en" );
    $labelManager->addLabel( "[title_fieldvalues_modTime]", "Last Modified At", "en" );
    $labelManager->addLabel( "[formLabel_fieldvalues_modTime]", "Last Modified At", "en" );


    //
    // FieldGroup table
    //
    $labelManager->addLabel( "[title_fieldgroup_id]", "Field Group", "en" );
    $labelManager->addLabel( "[formLabel_fieldgroup_id]", "Field Group", "en" );
    $labelManager->addLabel( "[title_fieldgroup_desc]", "Field Group", "en" );
    $labelManager->addLabel( "[formLabel_fieldgroup_desc]", "Field Group", "en" );


    //
    // FieldGroup_Matches table
    //
    $labelManager->addLabel( "[title_fieldgroup_matches_id]", "Field Group Match", "en" );
    $labelManager->addLabel( "[formLabel_fieldgroup_matches_id]", "Field Group Match", "en" );
    $labelManager->addLabel( "[title_fieldgroup_id]", "Field Group", "en" );
    $labelManager->addLabel( "[formLabel_fieldgroup_id]", "Field Group", "en" );
    $labelManager->addLabel( "[title_fields_id]", "Field", "en" );
    $labelManager->addLabel( "[formLabel_fields_id]", "Field", "en" );


    //
    // StaffScheduleInstr table
    //
    $labelManager->addLabel( "[title_staffscheduleinstr_toptext]", "Main Form Instructions", "en" );
    $labelManager->addLabel( "[formLabel_staffscheduleinstr_toptext]", "Main Form Instructions", "en" );
    $labelManager->addLabel( "[title_staffscheduleinstr_bottomtext]", "Activity Form Instructions", "en" );
    $labelManager->addLabel( "[formLabel_staffscheduleinstr_bottomtext]", "Activity Form Instructions", "en" );
    $labelManager->addLabel( "[title_staffscheduletype_id]", "HRDB Form Instructions", "en" );
    $labelManager->addLabel( "[formLabel_staffscheduletype_id]", "HRDB Form Instructions", "en" );
    $labelManager->addLabel( "[formLabel_form_name]", " ", "en" );



    //
    // StaffDirector table
    //
    $labelManager->addLabel( "[title_staffdirector_id]", "Staff-Director Relation", "en" );
    $labelManager->addLabel( "[formLabel_staffdirector_id]", "Staff-Director Relation", "en" );
    $labelManager->addLabel( "[title_staff_id]", "Staff", "en" );
    $labelManager->addLabel( "[formLabel_staff_id]", "Staff", "en" );
    $labelManager->addLabel( "[title_director_id]", "Director/Supervisor", "en" );
    $labelManager->addLabel( "[formLabel_director_id]", "Director/Supervisor", "en" );


    //
    // CustomReports table
    //
    $labelManager->addLabel( "[title_report_id]", "Report", "en" );
    $labelManager->addLabel( "[formLabel_report_id]", "Report", "en" );
    $labelManager->addLabel( "[title_report_name]", "Report Name", "en" );
    $labelManager->addLabel( "[formLabel_report_name]", "Report Name", "en" );
    $labelManager->addLabel( "[title_report_is_shown]", "Active?", "en" );
    $labelManager->addLabel( "[formLabel_report_is_shown]", "Active?", "en" );


    //
    // CustomFields table
    //
    $labelManager->addLabel( "[title_customfields_id]", "Custom Field", "en" );
    $labelManager->addLabel( "[formLabel_customfields_id]", "Custom Field", "en" );
    $labelManager->addLabel( "[title_report_id]", "Report Name", "en" );
    $labelManager->addLabel( "[formLabel_report_id]", "Report Name", "en" );
    $labelManager->addLabel( "[title_fields_id]", "Form Field", "en" );
    $labelManager->addLabel( "[formLabel_fields_id]", "Form Field", "en" );


    //
    // Ministry table
    //
    $labelManager->addLabel( "[title_ministry_id]", "Ministry", "en" );
    $labelManager->addLabel( "[formLabel_ministry_id]", "Ministry", "en" );
    $labelManager->addLabel( "[title_ministry_name]", "Ministry Name", "en" );
    $labelManager->addLabel( "[formLabel_ministry_name]", "Ministry Name", "en" );
    $labelManager->addLabel( "[title_ministry_abbrev]", "Ministry Abbrev.", "en" );
    $labelManager->addLabel( "[formLabel_ministry_abbrev]", "Ministry Abbrev.", "en" );


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


    // Create EditMyInfo labels 
    $labelManager->addPage( FormProcessor_EditMyInfo::MULTILINGUAL_PAGE_KEY );

    $labelManager->addLabel( "[Title]", "My HRDB info", "en" );
    $labelManager->addLabel( "[Instr]", "Please keep your contact information up to date.", "en" );
    $labelManager->addLabel( "[Title]", "Your contact information", "en" );
/*[RAD_PAGE(EditMyInfo)_LABELS]*/



    // Create hrdbHome labels
    $labelManager->addPage( page_hrdbHome::MULTILINGUAL_PAGE_KEY );

    $labelManager->addLabel( "[Title]", "This is the home page.", "en" );
    $labelManager->addLabel( "[Instr]", "Use the form below to find event registration data for a particular person:", "en" );
    
    $labelManager->addLabel( "[Search]", "Search", "en" );
    $labelManager->addLabel( "[formLabel_person_id]", "Person Name", "en" );
    $labelManager->addLabel( "[title_event_id]", "Event Name", "en" );
    $labelManager->addLabel( "[title_registration_id]", "Registration ID", "en" );
    $labelManager->addLabel( "[title_registration_status]", "Registration Status", "en" );
    $labelManager->addLabel( "[title_registration_balance]", "Registration Balance", "en" );
    
/*[RAD_PAGE(hrdbHome)_LABELS]*/

    // Create ImportData labels
    $labelManager->addPage( page_ImportData::MULTILINGUAL_PAGE_KEY );

/*[RAD_PAGE(ImportData)_LABELS]*/

    // Create Countries labels
    $labelManager->addPage( FormProcessor_Countries::MULTILINGUAL_PAGE_KEY );
    $labelManager->addLabel( "[Title]", "Countries", "en" );
    $labelManager->addLabel( "[Instr]", "You can modify the Countries list by using this page.<br>It is recommended that all short forms conform to <a href=http://en.wikipedia.org/wiki/ISO_3166-1_alpha-3>ISO 3166-1</a>.", "en" );
    

/*[RAD_PAGE(Countries)_LABELS]*/


    // Create Provinces labels
    $labelManager->addPage( FormProcessor_Provinces::MULTILINGUAL_PAGE_KEY );
    $labelManager->addLabel( "[Title]", "Provinces", "en" );
    $labelManager->addLabel( "[Instr]", "You can modify the Provinces list by using this page.", "en" );

/*[RAD_PAGE(Provinces)_LABELS]*/



    // Create Campuses labels
    $labelManager->addPage( FormProcessor_Campuses::MULTILINGUAL_PAGE_KEY );

    $labelManager->addLabel( "[Title]", "Campuses", "en" );
    $labelManager->addLabel( "[Instr]", "You can modify the Campuses list by using this page.", "en" );
/*[RAD_PAGE(Campuses)_LABELS]*/



    // Create People labels
    $labelManager->addPage( page_People::MULTILINGUAL_PAGE_KEY );

    $labelManager->addLabel( "[Title]", "People", "en" );
    $labelManager->addLabel( "[Instr]", "You can modify the People list and edit Peoples' info by using this page.", "en" );
/*[RAD_PAGE(People)_LABELS]*/

    // Create New Person labels
    $labelManager->addPage( FormProcessor_NewPerson::MULTILINGUAL_PAGE_KEY );

    $labelManager->addLabel( "[Title]", "New Person", "en" );
    $labelManager->addLabel( "[Instr]", "You can add a person to the module by using the form below.", "en" );
/*[RAD_PAGE(New Person)_LABELS]*/



    // Create Privileges labels
    $labelManager->addPage( FormProcessor_Privileges::MULTILINGUAL_PAGE_KEY );

    $labelManager->addLabel( "[Title]", "HRDB Privileges", "en" );
    $labelManager->addLabel( "[Instr]", "You can modify the list of Previleges by using this page.", "en" );

/*[RAD_PAGE(Privileges)_LABELS]*/



    // Create People List labels
    $labelManager->addPage( FormProcessor_PeopleList::MULTILINGUAL_PAGE_KEY );

    $labelManager->addLabel( "[Title]", "People", "en" );
    $labelManager->addLabel( "[Instr]", "You can modify the People list and edit Peoples' info by using this page.", "en" );

/*[RAD_PAGE(People List)_LABELS]*/



    // Create Delete Person labels
    $labelManager->addPage( page_DeletePerson::MULTILINGUAL_PAGE_KEY );
    $labelManager->addLabel( "[Title]", "Delete Person", "en" );
    $labelManager->addLabel( "[Instr]", "Are you sure you want to delete this person?", "en" );
/*[RAD_PAGE(Delete Person)_LABELS]*/


/*[RAD_PAGE(Staff)_LABELS]*/



    // Create View Staff labels
    // $labelManager->addPage( FormProcessor_ViewStaff::MULTILINGUAL_PAGE_KEY );

/*[RAD_PAGE(View Staff)_LABELS]*/



    // Create Add Admin labels
    $labelManager->addPage( FormProcessor_AddAdmin::MULTILINGUAL_PAGE_KEY );

    $labelManager->addLabel( "[Title]", "Add Admin", "en" );
    $labelManager->addLabel( "[Instr]", "You can add an admin by using the form below.", "en" );
/*[RAD_PAGE(Add Admin)_LABELS]*/



    // Create Add Admin labels
    $labelManager->addPage( FormProcessor_AddAdmin::MULTILINGUAL_PAGE_KEY );

/*[RAD_PAGE(Add Admin)_LABELS]*/



    // Create EditMyInfo labels
    $labelManager->addPage( FormProcessor_EditMyInfo::MULTILINGUAL_PAGE_KEY );

    $labelManager->addLabel( "[Instr]", "Please keep your contact information updated. For your legal names, please enter it as it appears on your passport.  This is necessary for project participants.", "en" );
    $labelManager->addLabel( "[Title]", "Your contact information", "en" );
/*[RAD_PAGE(EditMyInfo)_LABELS]*/



    // Create EditPerson labels
    $labelManager->addPage( FormProcessor_EditPerson::MULTILINGUAL_PAGE_KEY );

    $labelManager->addLabel( "[Title]", "Edit Person", "en" );
    $labelManager->addLabel( "[Instr]", "Please keep the contact info up to date.", "en" );
/*[RAD_PAGE(EditPerson)_LABELS]*/



    // Create AddStaff labels
    $labelManager->addPage( FormProcessor_AddStaff::MULTILINGUAL_PAGE_KEY );

    $labelManager->addLabel( "[Title]", "Add Staff", "en" );
    $labelManager->addLabel( "[Instr]", "You can add a staff member using the form below.", "en" );
/*[RAD_PAGE(AddStaff)_LABELS]*/



    // Create Staff labels
    $labelManager->addPage( page_Staff::MULTILINGUAL_PAGE_KEY );

    $labelManager->addLabel( "[Title]", "Staff", "en" );
    $labelManager->addLabel( "[Instr]", "You can add or remove staff members using this page.", "en" );
/*[RAD_PAGE(Staff)_LABELS]*/



    // Create Delete Staff labels
    $labelManager->addPage( page_DeleteStaff::MULTILINGUAL_PAGE_KEY );

    $labelManager->addLabel( "[Title]", "Delete Staff Member", "en" );
    $labelManager->addLabel( "[Instr]", "Are you sure you want to delete this staff member?", "en" );
/*[RAD_PAGE(Delete Staff)_LABELS]*/



    // Create Admins labels
    $labelManager->addPage( page_Admins::MULTILINGUAL_PAGE_KEY );

    $labelManager->addLabel( "[Title]", "HRDB Admin", "en" );
    $labelManager->addLabel( "[Instr]", "You can view and edit all the Admins for this module using this page.", "en" );
    $labelManager->addLabel( "[view_campuses]", "Assigned Campuses", "en" );
    $labelManager->addLabel( "[view]", "View", "en" );

/*[RAD_PAGE(Admins)_LABELS]*/



    // Create DeleteAdmin labels 
    $labelManager->addPage( page_DeleteAdmin::MULTILINGUAL_PAGE_KEY );

    $labelManager->addLabel( "[Title]", "Delete Admin", "en" );
    $labelManager->addLabel( "[Instr]", "Are you sure you want to delete this admin?", "en" );
/*[RAD_PAGE(DeleteAdmin)_LABELS]*/



    // Create ViewCampuses labels
    $labelManager->addPage( FormProcessor_ViewCampuses::MULTILINGUAL_PAGE_KEY );

    $labelManager->addLabel( "[Title]", "Campus Assignments", "en" );
    $labelManager->addLabel( "[Instr]", "You can add and edit the selected admin's campus assignments here.", "en" );
/*[RAD_PAGE(ViewCampuses)_LABELS]*/



    // Create ViewCampuses labels
    $labelManager->addPage( FormProcessor_ViewCampuses::MULTILINGUAL_PAGE_KEY );
    $labelManager->addLabel( "[Continue]", "Continue", "en" );

/*[RAD_PAGE(ViewCampuses)_LABELS]*/



    // Create People labels
    $labelManager->addPage( page_People::MULTILINGUAL_PAGE_KEY );
    $labelManager->addLabel( "[more_info]", "More Info", "en" );
    $labelManager->addLabel( "[view_more_info]", "View", "en" );
    $labelManager->addLabel( "[campus_assignments]", "Campus Assignments", "en" );
    $labelManager->addLabel( "[view_campus_assignments]", "View", "en" );


/*[RAD_PAGE(People)_LABELS]*/



    // Create CampusAssignments labels
    $labelManager->addPage( FormProcessor_CampusAssignments::MULTILINGUAL_PAGE_KEY );

    $labelManager->addLabel( "[Title]", "Campus Assignments", "en" );
    $labelManager->addLabel( "[Instr]", "You can add and edit a person's campus assignments here.", "en" );
    $labelManager->addLabel( "[Continue]", "Continue", "en" );
/*[RAD_PAGE(CampusAssignments)_LABELS]*/



    // Create PersonInfo labels
    $labelManager->addPage( page_PersonInfo::MULTILINGUAL_PAGE_KEY );

    $labelManager->addLabel( "[Title]", "Person Information", "en" );
    $labelManager->addLabel( "[Instr]", "Please keep the contact information up to date.", "en" );
    $labelManager->addLabel( "[Continue]", "Continue", "en" );

/*[RAD_PAGE(PersonInfo)_LABELS]*/



    // Create PeopleCampus labels
    $labelManager->addPage( FormProcessor_PeopleCampus::MULTILINGUAL_PAGE_KEY );

    $labelManager->addLabel( "[Title]", "People", "en" );
/*[RAD_PAGE(PeopleCampus)_LABELS]*/



    // Create PeoplebyCampuses labels
    $labelManager->addPage( page_PeoplebyCampuses::MULTILINGUAL_PAGE_KEY );

    $labelManager->addLabel( "[Title]", "Campus Member List", "en" );
    $labelManager->addLabel( "[Instr]", "Pick a Campus from the drop down list to display the members of that Campus.", "en" );
    $labelManager->addLabel( "[more_info]", "More Info", "en" );
    $labelManager->addLabel( "[view_more_info]", "View", "en" );
    $labelManager->addLabel( "[campus_assignments]", "Campus Assignments", "en" );
    $labelManager->addLabel( "[view_campus_assignments]", "View", "en" );

/*[RAD_PAGE(PeoplebyCampuses)_LABELS]*/



    // Create AdminPrivs labels
    $labelManager->addPage( FormProcessor_AdminPrivs::MULTILINGUAL_PAGE_KEY );

    $labelManager->addLabel( "[Title]", "Admin Previliges", "en" );
/*[RAD_PAGE(AdminPrivs)_LABELS]*/



    // Create AdminPrivs labels
    $labelManager->addPage( FormProcessor_AdminPrivs::MULTILINGUAL_PAGE_KEY );

/*[RAD_PAGE(AdminPrivs)_LABELS]*/



    // Create New Account labels 
    $labelManager->addPage( FormProcessor_NewAccount::MULTILINGUAL_PAGE_KEY );

    $labelManager->addLabel( "[Title]", "Create New Account", "en" );
    $labelManager->addLabel( "[Instr]", "Please fill in all the fields", "en" );
/*[RAD_PAGE(New Account)_LABELS]*/



    // Create EditMyEmergInfo labels 
    $labelManager->addPage( FormProcessor_EditMyEmergInfo::MULTILINGUAL_PAGE_KEY );

    $labelManager->addLabel( "[Title]", "Edit Emergency Contact Info", "en" );
    $labelManager->addLabel( "[Instr]", "Please enter your relevant emergency contact and crisis management information.", "en" );
/*[RAD_PAGE(EditMyEmergInfo)_LABELS]*/



    // Create EditCampusAssignmentStatusTypes labels 
    $labelManager->addPage( FormProcessor_EditCampusAssignmentStatusTypes::MULTILINGUAL_PAGE_KEY );

    $labelManager->addLabel( "[Title]", "Edit Campus Assignment Status Types", "en" );
    $labelManager->addLabel( "[Instr]", "Use the form below to add/delete/modify campus assignment status types:", "en" );
/*[RAD_PAGE(EditCampusAssignmentStatusTypes)_LABELS]*/



    // Create EditCampusAssignment labels 
    $labelManager->addPage( FormProcessor_EditCampusAssignment::MULTILINGUAL_PAGE_KEY );

    $labelManager->addLabel( "[Title]", "Edit Campus Assignments", "en" );
    $labelManager->addLabel( "[Instr]", "Use the form below to edit the campus assignment and status for a person:", "en" );
/*[RAD_PAGE(EditCampusAssignment)_LABELS]*/



    // Create EditRegion labels 
    $labelManager->addPage( FormProcessor_EditRegion::MULTILINGUAL_PAGE_KEY );

    $labelManager->addLabel( "[Title]", "Edit Regions", "en" );
    $labelManager->addLabel( "[Instr]", "Use the form below to edit regions used by the intranet system:", "en" );
/*[RAD_PAGE(EditRegion)_LABELS]*/



    // Create EditPeople labels 
    $labelManager->addPage( FormProcessor_EditPeople::MULTILINGUAL_PAGE_KEY );

    $labelManager->addLabel( "[Title]", "Edit People Listing", "en" );
    $labelManager->addLabel( "[Instr]", "Use the form below to edit basic personal information for people in the database:", "en" );
/*[RAD_PAGE(EditPeople)_LABELS]*/



/*    // Create EditAccessAssignment labels 
    $labelManager->addPage( FormProcessor_EditAccessAssignment::MULTILINGUAL_PAGE_KEY );

    $labelManager->addLabel( "[Title]", "Edit User Record Assignments", "en" );
    $labelManager->addLabel( "[Instr]", "Use the form below to assign some user record to some person.", "en" );*/
/*[RAD_PAGE(EditAccessAssignment)_LABELS]*/



    // Create EditMyCampusAssignment labels 
    $labelManager->addPage( FormProcessor_EditMyCampusAssignment::MULTILINGUAL_PAGE_KEY );

    $labelManager->addLabel( "[Title]", "Edit My Campus Assignment", "en" );
    $labelManager->addLabel( "[Instr]", "Use this page to edit your status as it pertains to each campus you studied or served at.", "en" );
/*[RAD_PAGE(EditMyCampusAssignment)_LABELS]*/



    // Create EditMyYearInSchool labels 
    $labelManager->addPage( FormProcessor_EditMyYearInSchool::MULTILINGUAL_PAGE_KEY );

    $labelManager->addLabel( "[Title]", "Edit My Year in School", "en" );
    $labelManager->addLabel( "[Instr]", "Please confirm what year in school you are in.", "en" );
    $labelManager->addLabel( "[title_grad_date]", "Expected Graduation Date (YYYY-MM-DD)", "en" );
    $labelManager->addLabel( "[formLabel_grad_date]", "Expected Graduation Date<BR>(YYYY-MM-DD)", "en" );
/*[RAD_PAGE(EditMyYearInSchool)_LABELS]*/



    // Create EditStudentYearInSchool labels 
    $labelManager->addPage( FormProcessor_EditStudentYearInSchool::MULTILINGUAL_PAGE_KEY );

    $labelManager->addLabel( "[Title]", "Campus Student Seniority List", "en" );
    $labelManager->addLabel( "[Instr]", "Pick a Campus from the drop down list to display the members of that Campus, along with their year-in-school.", "en" );
    $labelManager->addLabel( "[CampusStudentsByYear]", "Campus Student Seniority List", "en" );
    $labelManager->addLabel( "[DownloadSeniorityCSV]", "Download as Spreadsheet", "en" );
/*[RAD_PAGE(EditStudentYearInSchool)_LABELS]*/

    // Create ViewStudentYearInSchool labels 
    $labelManager->addPage( page_ViewStudentYearInSchool::MULTILINGUAL_PAGE_KEY );

    $labelManager->addLabel( "[Title]", "List Students by Seniority", "en" );
    $labelManager->addLabel( "[Instr]", "Pick a seniority level from the drop down list to display people with that seniority, associated by campus.", "en" );
/*[RAD_PAGE(EditStudentYearInSchool)_LABELS]*/


        // Create DownloadCSV labels 
    $labelManager->addPage( page_DownloadCSV::MULTILINGUAL_PAGE_KEY );

    $labelManager->addLabel( "[Title]", "Download CSV Report", "en" );
    $labelManager->addLabel( "[Instr]", "Right-click on link below and click on 'Save Link As...' to download the report.<br>Left-click to view the data in your browser.", "en" );
    $labelManager->addLabel( "[DownloadSeniorityDataDump]", "Download Student Seniority List", "en" );
    $labelManager->addLabel( "[DownloadActivitiesDataDump]", "Download Staff Activities List", "en" );
    $labelManager->addLabel( "[DownloadCustomReportDataDump]", "Download Custom Report", "en" );
    
/*[RAD_PAGE(DownloadCSV)_LABELS]*/
    
    
    // Create hrdbForms labels 
    $labelManager->addPage( page_hrdbForms::MULTILINGUAL_PAGE_KEY );

    $labelManager->addLabel( "[Title]", "HRDB Forms", "en" );
    $labelManager->addLabel( "[Instr]", "Select a form using the list below:", "en" );
    $labelManager->addLabel( "[title_access]", "Access Link", "en" );
    $labelManager->addLabel( "[access]", "Access", "en" );
    $labelManager->addLabel( "[title_admin]", "Admin Link", "en" );
    $labelManager->addLabel( "[admin]", "Edit Form", "en" );
    $labelManager->addLabel( "[title_approval]", "Approval Link", "en" );
    $labelManager->addLabel( "[approve]", "Approve Forms", "en" );
    $labelManager->addLabel( "[title_submitted]", "View Staff Submissions", "en" );
    $labelManager->addLabel( "[submitted]", "View Staff", "en" );    
    /*[RAD_PAGE(hrdbForms)_LABELS]*/


    // Create EditFormFields labels 
    $labelManager->addPage( FormProcessor_EditFormFields::MULTILINGUAL_PAGE_KEY );

    $labelManager->addLabel( "[Title]", "Edit HRDB Form Fields", "en" );
    $labelManager->addLabel( "[Instr]", "Use the form below to create, update, or delete online form fields:", "en" );
/*[RAD_PAGE(EditFormFields)_LABELS]*/


    // Create EditStaffScheduleForm labels 
    $labelManager->addPage( FormProcessor_EditStaffScheduleForm::MULTILINGUAL_PAGE_KEY );

    $labelManager->addLabel( "[Title]", "Edit My HRDB Form", "en" );
    $labelManager->addLabel( "[Instr]", "Please fill in the following fields. When you're finished, press the Update button to save any changes.", "en" );
/*[RAD_PAGE(EditFormFields)_LABELS]*/


    // Create EditStaffActivity labels 
    $labelManager->addPage( FormProcessor_EditStaffActivity::MULTILINGUAL_PAGE_KEY );

    $labelManager->addLabel( "[Title]", "Edit Staff Activities", "en" );
    $labelManager->addLabel( "[Instr]", "Use the form below to add/edit/remove staff activities that may be associated with various schedules:", "en" );
/*[RAD_PAGE(EditStaffActivity)_LABELS]*/



    // Create ApproveStaffSchedule labels 
    $labelManager->addPage( FormProcessor_ApproveStaffSchedule::MULTILINGUAL_PAGE_KEY );

    $labelManager->addLabel( "[Title]", "HRDB Forms Approval", "en" );
    $labelManager->addLabel( "[Instr]", "Use this interface to approve users' HRDB forms:", "en" );
    $labelManager->addLabel( "[formLabel_viewer_userID]", "Approved by", "en" ); 
    $labelManager->addLabel( "[formLabel_title_userID]", "Approved by", "en" );   
    $labelManager->addLabel( "[ApprovalStatus]", "Approved?", "en" );  
    $labelManager->addLabel( "[ApprovalNotes]", "Approval Notes:", "en" );
    $labelManager->addLabel( "[Director]", "Last Change By", "en" );  
    $labelManager->addLabel( "[ChangeTime]", "Approval Changed At", "en" );    
    $labelManager->addLabel( "[Back]", "Back", "en" );     // [Continue]
/*[RAD_PAGE(ApproveStaffSchedule)_LABELS]*/



    // Create FormApprovalListing labels 
    $labelManager->addPage( page_FormApprovalListing::MULTILINGUAL_PAGE_KEY );

    $labelManager->addLabel( "[Title]", "Approval Listing", "en" );
    $labelManager->addLabel( "[Instr]", "Shows who has had their form approved.", "en" );
    $labelManager->addLabel( "[Access]", "Access", "en" );
    $labelManager->addLabel( "[View]", "view", "en" );
/*[RAD_PAGE(FormApprovalListing)_LABELS]*/



    // Create EditStaffFormContext labels 
    $labelManager->addPage( FormProcessor_EditStaffFormContext::MULTILINGUAL_PAGE_KEY );

    $labelManager->addLabel( "[Title]", "Create HRDB Form<br>(Setup General Information)", "en" );
    $labelManager->addLabel( "[Instr]", "Use the form below to setup general HRDB form information:", "en" );
/*[RAD_PAGE(EditStaffFormContext)_LABELS]*/



    // Create EditStaffFormInstructions labels 
    $labelManager->addPage( FormProcessor_EditStaffFormInstructions::MULTILINGUAL_PAGE_KEY );

    $labelManager->addLabel( "[Title]", "Edit HRDB Form Instructions", "en" );
    $labelManager->addLabel( "[Instr]", "Use form below to add instructions for the main HRDB form and the (optional) associated scheduled activities form.", "en" );
/*[RAD_PAGE(EditStaffFormInstructions)_LABELS]*/


    // Create EditHrdbForm labels 
    $labelManager->addPage( FormProcessor_EditHrdbForm::MULTILINGUAL_PAGE_KEY );

    $labelManager->addLabel( "[Title]", "Edit HRDB Form Instructions and Fields", "en" );
    $labelManager->addLabel( "[Instr]", "Use form below to add instructions for the HRDB form, as well as to add form fields:", "en" );
    $labelManager->addLabel( "[Back]", "Back", "en" );     // [Continue]
    
/*[RAD_PAGE(EditHrdbForm)_LABELS]*/

    // Create EditHrdbForm labels 
    $labelManager->addPage( page_ViewScheduleCalendar::MULTILINGUAL_PAGE_KEY );

    $labelManager->addLabel( "[Title]", "View Calendar of Approved Events", "en" );
    $labelManager->addLabel( "[Instr]", "The calendar shows approved events for staff under your leadership.", "en" );
    
/*[RAD_PAGE(EditHrdbForm)_LABELS]*/


    // Create ViewStaffActivities labels 
    $labelManager->addPage( page_ViewStaffActivities::MULTILINGUAL_PAGE_KEY );

    $labelManager->addLabel( "[Title]", "View Staff Activities", "en" );
    $labelManager->addLabel( "[Instr]", "A list of scheduled staff activities:", "en" );
/*[RAD_PAGE(ViewStaffActivities)_LABELS]*/



    // Create hrdbActivities labels 
    $labelManager->addPage( page_hrdbActivities::MULTILINGUAL_PAGE_KEY );

    $labelManager->addLabel( "[Title]", "Activity Types Listing", "en" );
    $labelManager->addLabel( "[Instr]", "Use the link column to access specific scheduled staff activities.", "en" );
    $labelManager->addLabel( "[title_access]", "Access Events of this Type", "en" );
    $labelManager->addLabel( "[access]", "Access Events", "en" );    
/*[RAD_PAGE(hrdbActivities)_LABELS]*/


    // Create ViewActivitiesByDate labels 
    $labelManager->addPage( FormProcessor_ViewActivitiesByDate::MULTILINGUAL_PAGE_KEY );

    $labelManager->addLabel( "[Title]", "Staff Activities By Date", "en" );
    $labelManager->addLabel( "[Instr]", "Use the form to restrict activities by a date-range.", "en" );
    $labelManager->addLabel( "[DownloadActivitiesDateCSV]", "Download all Activity Data as Spreadsheet", "en" );
    
/*[RAD_PAGE(hrdbActivities)_LABELS]*/


    // Create ViewActivitiesByDate labels 
    $labelManager->addPage( page_FormSubmittedListing::MULTILINGUAL_PAGE_KEY );

    $labelManager->addLabel( "[Title]", "Listing of Staff Form Submissions", "en" );
    $labelManager->addLabel( "[Instr]", "Use this form to identify staff that still need to submit a form.", "en" );
    $labelManager->addLabel( "[Access]", "Person Contact Info", "en" );    
/*[RAD_PAGE(hrdbActivities)_LABELS]*/


    // Create EditActivityTypes labels 
    $labelManager->addPage( FormProcessor_EditActivityTypes::MULTILINGUAL_PAGE_KEY );

    $labelManager->addLabel( "[Title]", "Edit Staff Activity Types", "en" );
    $labelManager->addLabel( "[Instr]", "Use the form below to edit activity types:", "en" );
/*[RAD_PAGE(EditActivityTypes)_LABELS]*/



    // Create EditCustomReports labels 
    $labelManager->addPage( FormProcessor_EditCustomReports::MULTILINGUAL_PAGE_KEY );

    $labelManager->addLabel( "[Title]", "Edit Custom Report Fields", "en" );
    $labelManager->addLabel( "[Instr]", "Use the form below to associate the data of a specific form field with a custom report:", "en" );
/*[RAD_PAGE(EditCustomReports)_LABELS]*/



    // Create ViewCustomReport labels 
    $labelManager->addPage( page_ViewCustomReport::MULTILINGUAL_PAGE_KEY );

    $labelManager->addLabel( "[Title]", "View Custom Report", "en" );
    $labelManager->addLabel( "[Instr]", "Details shown below for the pre-selected custom report:", "en" );
    $labelManager->addLabel( "[DownloadCustomReportCSV]", "Download Report Data as Spreadsheet", "en" );
/*[RAD_PAGE(EditCustomReports)_LABELS]*/



    // Create CustomReportsListing labels 
    $labelManager->addPage( page_CustomReportsListing::MULTILINGUAL_PAGE_KEY );

    $labelManager->addLabel( "[Title]", "Custom Reports Listing", "en" );
    $labelManager->addLabel( "[Instr]", "Use the access links to access the custom reports:", "en" );
    $labelManager->addLabel( "[title_access]", "Access Link", "en" );
    $labelManager->addLabel( "[access]", "Access", "en" );
    $labelManager->addLabel( "[title_admin]", "Admin Link", "en" );
    $labelManager->addLabel( "[admin]", "Edit Report", "en" );        
/*[RAD_PAGE(CustomReportsListing)_LABELS]*/



    // Create Edit Staff labels 
    $labelManager->addPage( FormProcessor_EditStaff::MULTILINGUAL_PAGE_KEY );

    $labelManager->addLabel( "[Title]", "Staff", "en" );
    $labelManager->addLabel( "[Instr]", "You can add, edit, or remove staff member listing data using this page.", "en" );
/*[RAD_PAGE(Edit Staff)_LABELS]*/



    // Create EditCustomReportMetaData labels 
    $labelManager->addPage( FormProcessor_EditCustomReportMetaData::MULTILINGUAL_PAGE_KEY );

    $labelManager->addLabel( "[Title]", "Edit Custom Report Meta-data", "en" );
    $labelManager->addLabel( "[Instr]", "Use the form below to change the report name, active status, etc:", "en" );
/*[RAD_PAGE(EditCustomReportMetaData)_LABELS]*/



/*[RAD_PAGE_LABEL]*/

	  // Load labels for the Unauthorized Access page
    $labelManager->addPage( page_NotAuthorized::MULTILINGUAL_PAGE_KEY );
    $labelManager->addLabel( "[Title]", "Unauthorized Access Detected", "en" );
    $labelManager->addLabel( "[Instr]", "You do not have the required privileges for accessing this page.<br><br>You can use your browser's 'Back' button or use the menus to navigate back.", "en" );
 


     // load the labels for the side bar

    $labelManager->addPage( obj_AdminSideBar::MULTILINGUAL_PAGE_KEY );
    $labelManager->addLabel( "[General]", "General", "en" );
    $labelManager->addLabel( "[editMyInfo]", "Edit Your Info", "en" );
    $labelManager->addLabel( "[editMyCampusInfo]", "Edit My Campus Info", "en" );
    $labelManager->addLabel( "[editMyYearInSchool]", "Edit My School Info", "en" );
    $labelManager->addLabel( "[editMyForms]", "Edit My Forms", "en" );
    
    $labelManager->addLabel( "[CampusLevelLinks]", "Campus Admin", "en" );
//    $labelManager->addLabel( "[PeopleList]", "People List", "en" );
    $labelManager->addLabel( "[PeopleByCampuses]", "Campus Member List", "en" );
    $labelManager->addLabel( "[CampusStudentsByYear]", "Campus Student<br>Seniority List", "en" );
    $labelManager->addLabel( "[NationalStudentsByYear]", "View All Students by Seniority", "en" );
    $labelManager->addLabel( "[approveForms]", "Approve Forms", "en" );  
    $labelManager->addLabel( "[viewScheduleCalendar]", "View Schedule Calendar", "en" ); 
    $labelManager->addLabel( "[viewActivitiesByType]", "View Activities by Type", "en" ); 
    $labelManager->addLabel( "[viewActivitiesByDate]", "View Activities by Date", "en" ); 
    $labelManager->addLabel( "[viewStaffMissingForms]", "View Staff Form Submissions", "en" ); 
    $labelManager->addLabel( "[viewCustomReportsList]", "View Custom Reports", "en" ); 
    
    $labelManager->addLabel( "[AdminLinks]", "HRDB Admin", "en" );
    $labelManager->addLabel( "[editForms]", "Edit Forms", "en" );
    $labelManager->addLabel( "[editReports]", "Edit Custom Reports", "en" );
    $labelManager->addLabel( "[editRegions]", "Regions", "en" );
    $labelManager->addLabel( "[editCountries]", "Countries", "en" );
    $labelManager->addLabel( "[editProvinces]", "Provinces", "en" );
    $labelManager->addLabel( "[editCampuses]", "Campuses", "en" );
//    $labelManager->addLabel( "[editPeople]", "People List", "en" );
    $labelManager->addLabel( "[editPrivileges]", "Privileges", "en" );
    $labelManager->addLabel( "[Staff]","Staff","en");
    $labelManager->addLabel( "[Admins]","Admins","en");
    $labelManager->addLabel( "[AssignStatusTypes]","Assignment Status Types","en");
    $labelManager->addLabel( "[CampusAssignments]","Campus Assignments","en");
    $labelManager->addLabel( "[ActivityTypes]","Activity Types","en");


} else {

    echo 'Skipping Labels ... <br>';

} // end if !skipLabels


?>