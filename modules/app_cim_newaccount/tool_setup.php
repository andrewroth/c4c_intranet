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

require ( 'app_cim_newaccount.php' );
require ( 'incl_cim_newaccount.php');


/*
 *  Directory Setup
 *
 *  Setup any specific directories used by this module.
 */
/*
if( !file_exists( modulecim_newaccount::DEF_DIR_DATA ) ) { 
    mkdir( modulecim_newaccount::DEF_DIR_DATA);
}
*/




// check to see if the parameter 'skipModule' was provided
$skipModule = true;//isset($_REQUEST['skipModule']);

// if it was NOT provided then update the Modules Table
if (!$skipModule ) {

    
    /*
     * Modules Table
     *
     * Setup the Page Modules Table to include a proper entry for this app.
     */
    $module = new RowManager_siteModuleManager();


    $module->loadByKey( modulecim_newaccount::MODULE_KEY );
    $module->setKey( modulecim_newaccount::MODULE_KEY );
    $module->setPath( 'modules/app_cim_newaccount/' );
    $module->setApplicationFile( 'app_cim_newaccount.php' );
    $module->setIncludeFile( 'incl_cim_newaccount.php' );
    $module->setName( 'modulecim_newaccount' );
    $module->setParameters( '' );
    $module->setSystemAccessFile( 'objects_bl/obj_SystemAccess.php' );
    $module->setSystemAccessObj( modulecim_newaccount::MODULE_KEY.'Access' );
    
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
$skipTables = true;//isset($_REQUEST['skipTables']);

// if NOT then reset the tables...
if ( !$skipTables ) {


    /*
     * Person Table
     *
     * This is to access the person table.
     *
     * person_id [INTEGER]  The id for the person.
     * person_fname [STRING]  The field for the first name of the person.
     * person_lname [STRING]  The last name of the person.
     * person_phone [STRING]  The phone number of the person
     * person_email [STRING]  The email address of the person.
     * person_addr [STRING]  The address of the person.
     * person_city [STRING]  The city the person is living in.
     * province_id [INTEGER]  The province id for the province the person is living in.
     * person_pc [STRING]  The postal code for the person.
     * gender_id [INTEGER]  The gender id for the person.
     */
    $Person = new RowManager_PersonManager();

    $Person->dropTable();
    $Person->createTable();



    /*
     * Province Table
     *
     * This manages the Provinces table.
     *
     * province_id [INTEGER]  This is the key for the table
     * province_desc [STRING]  This is the full name for the Province
     * province_shortDesc [STRING]  This is the abbreviation for the province.
     */
    $Province = new RowManager_ProvinceManager();

    $Province->dropTable();
    $Province->createTable();



    /*
     * Gender Table
     *
     * This manages the gender table.
     *
     * gender_id [INTEGER]  This is the key for the table.
     * gender_desc [STRING]  This is the type of gender.
     */
    $Gender = new RowManager_GenderManager();

    $Gender->dropTable();
    $Gender->createTable();



    /*
     * Campus Table
     *
     * This manages the Campus Table
     *
     * campus_id [INTEGER]  This is the key for the table.
     * campus_desc [STRING]  This is the full name for the Campus.
     * campus_shortDesc [STRING]  This is the abbreviation for the Campus.
     */
    $Campus = new RowManager_CampusManager();

    $Campus->dropTable();
    $Campus->createTable();



    /*
     * Assignment Table
     *
     * This manages the assignment table.
     *
     * assignment_id [INTEGER]  This is the key for the table.
     * person_id [INTEGER]  This is the id of the person being assigned to a campus.
     * campus_id [INTEGER]  This is the id of the campus the person is being assigned to.
     */
    $Assignment = new RowManager_AssignmentManager();

    $Assignment->dropTable();
    $Assignment->createTable();



    /*
     * Access Table
     *
     * This is to manage the access table.
     *
     * access_id [INTEGER]  This is the key for the access table.
     * viewer_id [INTEGER]  This is the viewer who is assigned to a person.
     * person_id [INTEGER]  The id for the person being assigned to the viewer id.
     */
    $Access = new RowManager_AccessManager();

    $Access->dropTable();
    $Access->createTable();



    /*
     * Viewer Table
     *
     * This manages the viewer table.
     *
     * viewer_id [INTEGER]  This is the key to the table.
     * accountgroup_id [INTEGER]  This is the accountgroup the account is in.
     * viewer_userID [STRING]  This is the username for the viewer.
     * viewer_passWord [STRING]  This is the user's password.
     * language_id [INTEGER]  This is the language id for the viewer.
     * viewer_isActive [INTEGER]  This is true if the viewer is active.
     * viewer_lastLogin [DATE]  This is the last time the viewer logged into the system.
     */
    $Viewer = new RowManager_ViewerManager();

    $Viewer->dropTable();
    $Viewer->createTable();



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
    $labelManager->addSeries( modulecim_newaccount::MULTILINGUAL_SERIES_KEY );
    
    
    
    // Create General Field labels for modulecim_newaccount 
    $labelManager->addPage( modulecim_newaccount::MULTILINGUAL_PAGE_FIELDS );

    
    //
    // Person table
    //
    $labelManager->addLabel( "[title_person_fname]", "First Name", "en" );
    $labelManager->addLabel( "[formLabel_person_fname]", "First Name", "en" );
    $labelManager->addLabel( "[example_person_fname]", "Jane", "en" );
    $labelManager->addLabel( "[error_person_fname]", "Please enter the first name.", "en" );
    $labelManager->addLabel( "[title_person_lname]", "Last Name", "en" );
    $labelManager->addLabel( "[formLabel_person_lname]", "Last Name", "en" );
    $labelManager->addLabel( "[example_person_lname]", "Doe", "en" );
    $labelManager->addLabel( "[error_person_lname]", "Please enter the last name.", "en" );
    $labelManager->addLabel( "[title_person_phone]", "Phone", "en" );
    $labelManager->addLabel( "[formLabel_person_phone]", "Phone", "en" );
    $labelManager->addLabel( "[example_person_phone]", "416-123-4552", "en" );
    $labelManager->addLabel( "[error_person_phone]", "Please enter the phone number.", "en" );
    $labelManager->addLabel( "[title_person_email]", "Email", "en" );
    $labelManager->addLabel( "[formLabel_person_email]", "Email", "en" );
    $labelManager->addLabel( "[example_person_email]", "jesuslives@something.com", "en" );
    $labelManager->addLabel( "[error_person_email]", "Please enter the email address.", "en" );
    $labelManager->addLabel( "[title_person_addr]", "Address", "en" );
    $labelManager->addLabel( "[formLabel_person_addr]", "Address", "en" );
    $labelManager->addLabel( "[example_person_addr]", "12 Bridge St.", "en" );
    $labelManager->addLabel( "[error_person_addr]", "Please enter the address.", "en" );
    $labelManager->addLabel( "[title_person_city]", "City", "en" );
    $labelManager->addLabel( "[formLabel_person_city]", "City", "en" );
    $labelManager->addLabel( "[example_person_city]", "Scarborough", "en" );
    $labelManager->addLabel( "[error_person_city]", "Please enter the city.", "en" );
    $labelManager->addLabel( "[title_province_id]", "Province", "en" );
    $labelManager->addLabel( "[formLabel_province_id]", "Province", "en" );
    $labelManager->addLabel( "[example_province_id]", "ON", "en" );
    $labelManager->addLabel( "[error_province_id]", "Please pick a province.", "en" );
    $labelManager->addLabel( "[title_person_pc]", "Postal Code", "en" );
    $labelManager->addLabel( "[formLabel_person_pc]", "Postal Code", "en" );
    $labelManager->addLabel( "[example_person_pc]", "M3J 8L1", "en" );
    $labelManager->addLabel( "[error_person_pc]", "Please enter the postal code.", "en" );
    $labelManager->addLabel( "[title_gender_id]", "Gender", "en" );
    $labelManager->addLabel( "[formLabel_gender_id]", "Gender", "en" );
    $labelManager->addLabel( "[example_gender_id]", "Female", "en" );
    $labelManager->addLabel( "[error_gender_id]", "Please pick a gender.", "en" );


    //
    // Province table
    //
    $labelManager->addLabel( "[title_province_desc]", "Province", "en" );
    $labelManager->addLabel( "[formLabel_province_desc]", "Province", "en" );
    $labelManager->addLabel( "[example_province_desc]", "Ontario", "en" );
    $labelManager->addLabel( "[error_province_desc]", "Please enter a Province", "en" );
    $labelManager->addLabel( "[title_province_shortDesc]", "Province Short Name", "en" );
    $labelManager->addLabel( "[formLabel_province_shortDesc]", "Province Short Name", "en" );
    $labelManager->addLabel( "[example_province_shortDesc]", "ON", "en" );
    $labelManager->addLabel( "[error_province_shortDesc]", "Please enter the Province's Short Name.", "en" );


    //
    // Gender table
    //
    $labelManager->addLabel( "[title_gender_desc]", "Gender", "en" );
    $labelManager->addLabel( "[formLabel_gender_desc]", "Gender", "en" );
    $labelManager->addLabel( "[example_gender_desc]", "Female", "en" );
    $labelManager->addLabel( "[error_gender_desc]", "Please pick a gender.", "en" );


    //
    // Campus table
    //
    $labelManager->addLabel( "[title_campus_desc]", "Campus", "en" );
    $labelManager->addLabel( "[formLabel_campus_desc]", "Campus", "en" );
    $labelManager->addLabel( "[example_campus_desc]", "University of Waterloo", "en" );
    $labelManager->addLabel( "[error_campus_desc]", "Please enter a Campus Name.", "en" );
    $labelManager->addLabel( "[title_campus_shortDesc]", "Campus Short Name", "en" );
    $labelManager->addLabel( "[formLabel_campus_shortDesc]", "Campus Short Name", "en" );
    $labelManager->addLabel( "[example_campus_shortDesc]", "UW", "en" );
    $labelManager->addLabel( "[error_campus_shortDesc]", "Please enter the Campus's Short Name.", "en" );


    //
    // Assignment table
    //
    $labelManager->addLabel( "[title_person_id]", "Person", "en" );
    $labelManager->addLabel( "[formLabel_person_id]", "Person", "en" );
    $labelManager->addLabel( "[example_person_id]", "Doe, Jane", "en" );
    $labelManager->addLabel( "[error_person_id]", "Please pick a person.", "en" );
    $labelManager->addLabel( "[title_campus_id]", "Campus", "en" );
    $labelManager->addLabel( "[formLabel_campus_id]", "Campus", "en" );
    $labelManager->addLabel( "[example_campus_id]", "University of Waterloo", "en" );
    $labelManager->addLabel( "[error_campus_id]", "Please pick a campus.", "en" );


    //
    // Access table
    //
    $labelManager->addLabel( "[title_viewer_id]", "User", "en" );
    $labelManager->addLabel( "[formLabel_viewer_id]", "User", "en" );
    $labelManager->addLabel( "[example_viewer_id]", "jane.doe", "en" );
    $labelManager->addLabel( "[error_viewer_id]", "Please pick a user.", "en" );
    $labelManager->addLabel( "[title_person_id]", "Person", "en" );
    $labelManager->addLabel( "[formLabel_person_id]", "Person", "en" );
    $labelManager->addLabel( "[example_person_id]", "Doe, Jane", "en" );
    $labelManager->addLabel( "[error_person_id]", "Please pick a person.", "en" );


    //
    // Viewer table
    //
    $labelManager->addLabel( "[title_viewer_userID]", "Username", "en" );
    $labelManager->addLabel( "[formLabel_viewer_userID]", "Username", "en" );
    $labelManager->addLabel( "[error_uniqueUserID]", "The username has been used. Please enter another username.", "en" );
    $labelManager->addLabel( "[example_viewer_userID]", "jane.doe", "en" );
    $labelManager->addLabel( "[error_viewer_userID]", "Please enter a user name.", "en" );
    $labelManager->addLabel( "[title_viewer_passWord]", "Password", "en" );
    $labelManager->addLabel( "[formLabel_viewer_passWord]", "Password", "en" );
    $labelManager->addLabel( "[example_viewer_passWord]", "t3stb0t", "en" );
    $labelManager->addLabel( "[error_viewer_passWord]", "Please enter a password.", "en" );
    $labelManager->addLabel( "[formLabel_pword2]", "Verify Password", "en" );


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


    // Create NewPerson labels 
    $labelManager->addPage( FormProcessor_NewPerson::MULTILINGUAL_PAGE_KEY );

    $labelManager->addLabel( "[Instr]", "Please fill in all the fields.", "en" );
    $labelManager->addLabel( "[Title]", "Create Account", "en" );
    $labelManager->addLabel( "[error_prevAccountFound]", 'You already have an account!<br>Please go to login page and click on "Forgot Password?".', "en");
/*[RAD_PAGE(NewPerson)_LABELS]*/



    // Create Created Successfully. labels 
    $labelManager->addPage( page_CreatedSuccessfully::MULTILINGUAL_PAGE_KEY );

    $labelManager->addLabel( "[Title]", "Account Creation Successful", "en" );
    $labelManager->addLabel( "[Instr]", "Your account has been created successfully. You may now login.", "en" );
/*[RAD_PAGE(Created Successfully.)_LABELS]*/



    // Create RecoverLoginDetails labels 
    $labelManager->addPage( FormProcessor_RecoverLoginDetails::MULTILINGUAL_PAGE_KEY );

    $labelManager->addLabel( "[Title]", "Recover Login Info", "en" );
    $labelManager->addLabel( "[Instr]", "Please enter your email address. Your password will be reset and your login info will be emailed to you.", "en" );
/*[RAD_PAGE(RecoverLoginDetails)_LABELS]*/



    // Create EmailSentSuccessfully labels 
    $labelManager->addPage( page_EmailSentSuccessfully::MULTILINGUAL_PAGE_KEY );

    $labelManager->addLabel( "[Title]", "Email Sent", "en" );
    $labelManager->addLabel( "[Instr]", "Your login details have been successfully sent to the email you provided.", "en" );
/*[RAD_PAGE(EmailSentSuccessfully)_LABELS]*/


    // Create GCXFirstLogin labels 
    $labelManager->addPage( FormProcessor_GCXFirstLogin::MULTILINGUAL_PAGE_KEY );

    $labelManager->addLabel( "[Title]", "This is your first time logging into with your GCX account.", "en" );
    $labelManager->addLabel( "[Instr]", "If you have an existing Intranet UserID and Password, please login. If not, press skip.", "en" );
    $labelManager->addLabel( "[yes]", "Submit", "en" );
    $labelManager->addLabel( "[no]", "Skip", "en" );
/*[RAD_PAGE(GCXFirstLogin)_LABELS]*/





/*[RAD_PAGE_LABEL]*/
    
    
} else {

    echo 'Skipping Labels ... <br>';
    
} // end if !skipLabels


?>