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

require ( 'app_cim_spt.php' );
require ( 'incl_cim_spt.php');


/*
 *  Directory Setup
 *
 *  Setup any specific directories used by this module.
 */
/*
if( !file_exists( modulecim_spt::DEF_DIR_DATA ) ) { 
    mkdir( modulecim_spt::DEF_DIR_DATA);
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


    $module->loadByKey( modulecim_spt::MODULE_KEY );
    $module->setKey( modulecim_spt::MODULE_KEY );
    $module->setPath( 'modules/app_cim_spt/' );
    $module->setApplicationFile( 'app_cim_spt.php' );
    $module->setIncludeFile( 'incl_cim_spt.php' );
    $module->setName( 'modulecim_spt' );
    $module->setParameters( '' );
    $module->setSystemAccessFile( 'objects_bl/obj_SystemAccess.php' );
    $module->setSystemAccessObj( modulecim_spt::MODULE_KEY.'Access' );
    
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

// if NOT then reset the tables...
if ( !$skipTables ) {


    /*
     * Ticket Table
     *
     * Manages tickets for authentication with the SPT.
     *
     * ticket_id [INTEGER]  Unique id
     * viewer_id [INTEGER]  viewer's id
     * ticket_ticket [STRING]  Ticket
     * ticket_expiry [INTEGER]  when the ticket expires
     */
    $Ticket = new RowManager_TicketManager();

    $Ticket->dropTable();
    $Ticket->createTable();



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
    $labelManager->addSeries( modulecim_spt::MULTILINGUAL_SERIES_KEY );
    
    
    
    // Create General Field labels for modulecim_spt 
    $labelManager->addPage( modulecim_spt::MULTILINGUAL_PAGE_FIELDS );

    
    //
    // Ticket table
    //
    $labelManager->addLabel( "[formLabel_ticket_id]", "Ticket ID", "en" );
    $labelManager->addLabel( "[formLabel_viewer_id]", "Viewer ID", "en" );
    $labelManager->addLabel( "[formLabel_ticket_ticket]", "Ticket", "en" );
    $labelManager->addLabel( "[formLabel_ticket_expiry]", "Expiry Time", "en" );


/*[RAD_FIELDS_LABEL]*/
    
    
    
    
// Create CommonDisplay labels 
    $labelManager->addPage( CommonDisplay::MULTILINGUAL_PAGE_KEY );

    //
    // Use this section to create your common page label information:
    $labelManager->addLabel( "[Title]", "Title", "en" );
    $labelManager->addLabel( "[Instr]", "Instructions", "en" );

    // Create spt_home labels 
    $labelManager->addPage( page_spt_home::MULTILINGUAL_PAGE_KEY );

    $labelManager->addLabel( "[Title]", "Summer Project Tool", "en" );
    $labelManager->addLabel( "[Instr]", "Here are some instructions.", "en" );
/*[RAD_PAGE(spt_home)_LABELS]*/



/*[RAD_PAGE_LABEL]*/
    
    
} else {

    echo 'Skipping Labels ... <br>';
    
} // end if !skipLabels


?>