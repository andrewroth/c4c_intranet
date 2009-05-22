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

require ( 'app_cim_c4cwebsite.php' );
require ( 'incl_cim_c4cwebsite.php');


/*
 *  Directory Setup
 *
 *  Setup any specific directories used by this module.
 */
/*
if( !file_exists( modulecim_c4cwebsite::DEF_DIR_DATA ) ) { 
    mkdir( modulecim_c4cwebsite::DEF_DIR_DATA);
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


    $module->loadByKey( modulecim_c4cwebsite::MODULE_KEY );
    $module->setKey( modulecim_c4cwebsite::MODULE_KEY );
    $module->setPath( 'modules/app_cim_c4cwebsite/' );
    $module->setApplicationFile( 'app_cim_c4cwebsite.php' );
    $module->setIncludeFile( 'incl_cim_c4cwebsite.php' );
    $module->setName( 'modulecim_c4cwebsite' );
    $module->setParameters( '' );
    $module->setSystemAccessFile( 'objects_bl/obj_SystemAccess.php' );
    $module->setSystemAccessObj( modulecim_c4cwebsite::MODULE_KEY.'Access' );
    
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
     * Page Table
     *
     * Manages interactions with the page table
     *
     * page_id [INTEGER]  unique identifier
     * page_parentID [INTEGER]  the id of the parent page
     * page_breadcrumbTitle [STRING]  the title to display in the breadcrumb feature
     * page_templateName [STRING]  the name of the template used to display this page
     * page_link [STRING]  the link for the page, it's the path from the root
     * page_order [INTEGER]  what order the pages should be put in
     */
    $Page = new RowManager_PageManager();

    $Page->dropTable();
    $Page->createTable();



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
    $labelManager->addSeries( modulecim_c4cwebsite::MULTILINGUAL_SERIES_KEY );
    
    
    
    // Create General Field labels for modulecim_c4cwebsite 
    $labelManager->addPage( modulecim_c4cwebsite::MULTILINGUAL_PAGE_FIELDS );

    
    //
    // Page table
    //
    $labelManager->addLabel( "[title_page_id]", "Page ID", "en" );
    $labelManager->addLabel( "[formLabel_page_id]", "Page ID", "en" );
    $labelManager->addLabel( "[title_page_parentID]", "Parent Page", "en" );
    $labelManager->addLabel( "[formLabel_page_parentID]", "Parent Page", "en" );
    $labelManager->addLabel( "[title_page_breadcrumbTitle]", "Title", "en" );
    $labelManager->addLabel( "[formLabel_page_breadcrumbTitle]", "Title", "en" );
    $labelManager->addLabel( "[title_page_templateName]", "Template", "en" );
    $labelManager->addLabel( "[formLabel_page_templateName]", "Template", "en" );
    $labelManager->addLabel( "[title_page_link]", "Link", "en" );
    $labelManager->addLabel( "[formLabel_page_link]", "Link", "en" );
    $labelManager->addLabel( "[title_page_order]", "Order", "en" );
    $labelManager->addLabel( "[formLabel_page_order]", "Order", "en" );
    $labelManager->addLabel( "[title_page_keywords]", "Keywords", "en" );
    $labelManager->addLabel( "[formLabel_page_keywords]", "Keywords", "en" );

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


    // Create EditPages labels 
    $labelManager->addPage( FormProcessor_EditPages::MULTILINGUAL_PAGE_KEY );

    $labelManager->addLabel( "[Title]", "Edit Pages", "en" );
    $labelManager->addLabel( "[Instr]", "Use the page to edit page meta data for pages in the C4C website.", "en" );
/*[RAD_PAGE(EditPages)_LABELS]*/



/*[RAD_PAGE_LABEL]*/
    
    
} else {

    echo 'Skipping Labels ... <br>';
    
} // end if !skipLabels


?>