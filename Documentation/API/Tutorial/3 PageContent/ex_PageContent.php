<?php

$pathFile = "General/gen_Includes.php";
$pathToRoot = '';
    
// Attempt to find proper directory from current page to Root ...
$numAttempts = 0;
while ( (!file_exists($pathToRoot.$pathFile)) && ( $numAttempts < 7) ) {
    
    $pathToRoot = '../'.$pathToRoot;
    $numAttempts++; 
}
        
require( $pathToRoot.$pathFile );
require("app_ModuleExample.php");

// Common data sent to the PageContent object
$db = new Database_Site(SITE_DB_NAME, SITE_DB_PATH, SITE_DB_USER, SITE_DB_PWORD); 
$viewer = new Viewer();
$labels = new XMLObject_MultilingualManager($viewer->getLanguageID() );

// if a language option was set, then update viewer to that language 
$pLang = '';
if (isset( $_REQUEST['p_Lang'] ) {
    $viewer->setLanguageID( $_REQUEST[ 'p_Lang' ] );
    $pLang = '&p_Lang='.$_REQUEST[ 'p_Lang' ];
}
$callBack = 'ex_PageContent.php?p_mod=Something'.$pLang;

// Create new PageContent Object
$pageContent = new moduleExample( $db, $viewer, $labels );


$pageContent->setModuleRootPath( '' );
$pageContent->setPageCallBack( $callBack );
$pageContent->setBaseCallBack( $callBack );


// "Drive" the PageContent Object through it's loadData(), processData(), and 
// prepareDisplayData() functions.
$pageContent->loadData();
$pageContent->processData();
$pageContent->prepareDisplayData();

// Get the content data back in XML format
$pageContentXML = $pageContent->getXML();	

// Now get the Template requested by the PageContent object
$template = new Template( $pathToRoot."Data/templates/" );

// Set PageContent information using the setXML() method.
$template->setXML( 'page', $pageContentXML);

// Get Template HTML
// display HTML
echo $template->fetch( PAGE_TEMPLATE_DEFAULT );

?>
