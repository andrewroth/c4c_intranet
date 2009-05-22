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

require ( 'app_[ModuleName].php' );
require ( 'incl_[ModuleName].php');


/*
 *  Directory Setup
 *
 *  Setup any specific directories used by this module.
 */
/*
if( !file_exists( module[ModuleName]::DEF_DIR_DATA ) ) { 
    mkdir( module[ModuleName]::DEF_DIR_DATA);
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


    $module->loadByKey( module[ModuleName]::MODULE_KEY );
    $module->setKey( module[ModuleName]::MODULE_KEY );
    $module->setPath( '[RAD_PATH_MODULE_ROOT][RAD_CORE_PRE_NAME][ModuleName]/' );
    $module->setApplicationFile( 'app_[ModuleName].php' );
    $module->setIncludeFile( 'incl_[ModuleName].php' );
    $module->setName( 'module[ModuleName]' );
    $module->setParameters( '' );
    $module->setSystemAccessFile( 'objects_bl/obj_SystemAccess.php' );
    $module->setSystemAccessObj( module[ModuleName]::MODULE_KEY.'Access' );
    
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
    $labelManager->addSeries( module[ModuleName]::MULTILINGUAL_SERIES_KEY );
    
    
    
    // Create General Field labels for module[ModuleName] 
    $labelManager->addPage( module[ModuleName]::MULTILINGUAL_PAGE_FIELDS );

    
/*[RAD_FIELDS_LABEL]*/
    
    
    
    
/*[RAD_PAGE_LABEL]*/
    
    
} else {

    echo 'Skipping Labels ... <br>';
    
} // end if !skipLabels


?>