<?php
$pathFile = 'General/gen_Includes.php';
$extension = '';
    
// Attempt to find proper directory from current page to Root ...
$numAttempts = 0;
while ( (!file_exists($extension.$pathFile)) && ( $numAttempts < 5) ) {
    
    $extension = '../'.$extension;
    $numAttempts++; 
}

require ( $extension.$pathFile );

require( 'SeriesManager.php' );
require( 'page_SeriesList.php' );
require( 'page_SeriesEdit.php' );
require( 'app_tvAddicts.php' );


//
// Because an AppController object is not able to function on it's own
// this script will properly load it and drive it through the 
// load, process, display phases.
//
// This script acts like the Page Object, which you will learn about later.
//

// Common data sent to the PageContent object
$db = new Database_Site(SITE_DB_NAME, SITE_DB_PATH, SITE_DB_USER, SITE_DB_PWORD); 
$viewer = new Viewer();


// if a language option was set, then update viewer to that language 
$pLang = '';
if (isset( $_REQUEST[ Page::QS_LANGUAGE ] ) ) {
    $viewer->setLanguageID( $_REQUEST[ Page::QS_LANGUAGE ] );
    $pLang = '&'.Page::QS_LANGUAGE.'='.$_REQUEST[ Page::QS_LANGUAGE ];
}
$callBack = 'ex_tvAddicts_obj.php?'.Page::QS_MODULE.'=Something'.$pLang;
$labels = new XMLObject_MultilingualManager($viewer->getLanguageID() );


// Create new AppController Object
$application = new moduleTVAddicts( $db, $viewer, $labels );


$application->setModuleRootPath( '' );
$application->setPageCallBack( $callBack );
$application->setBaseCallBack( $callBack );


// "Drive" the PageContent Object through it's loadData(), processData(), and 
// prepareDisplayData() functions.
$application->loadData();
$application->processData();
$application->prepareDisplayData();

// Get the content data back in Array format
$pageData = $application->getPageContent();	

// Now get the Template requested by the PageContent object
$template = new Template( $extension );// SITE_PATH_TEMPLATES );

// Set PageContent information using the setXML() method.
$template->set( 'page', $pageData);

// Get Template HTML
// display HTML
echo $template->fetch( $application->getPageTemplate() );

?>
