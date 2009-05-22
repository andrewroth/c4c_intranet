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



/*
 * Define the State Variables
 */
// PAGE is the querystring variable used for indicating which page to display
define( 'PAGE', 'page' );
define( 'PAGE_SERIESLIST', 'SL' ); // the page value for the SeriesList page
define( 'PAGE_SERIESEDIT', 'SE' ); // the page value for the SeriesEdit page




/*
 * Load the Data
 */
 
// Load in the PageController's state variables
$page = PAGE_SERIESLIST;
if ( isset( $_REQUEST[ PAGE ] ) ) {
    $page = $_REQUEST[ PAGE ];
}


// Load in the ID of the row we want to edit. 
// Init to -1 if not given.
$seriesID = -1;
if ( isset( $_REQUEST[ 'seriesID' ] ) ) {
    $seriesID = $_REQUEST[ 'seriesID' ];
}


// now descide which PageDisplay object to load
switch( $page ) {
        
    case PAGE_SERIESEDIT:
        // mark the value of the call back 
        $formAction = 'ex_tvAddicts.php?'.PAGE.'='.PAGE_SERIESEDIT.'&seriesID='.$seriesID;
        
        // Create our nifty new PageDisplay object
        // The constructor acts like our old loadData() 
        $pageDisplay = new page_SeriesEdit( '', null, $formAction, $seriesID );
        break;
        
    case PAGE_SERIESLIST:
    default:
        // Create our nifty new PageDisplay object
        // The constructor acts like our old loadData() 
        $pageDisplay = new page_SeriesList( '', null, '');
        
        // our script is now responsible to know about the links of the 
        // application. So it creates an array of links for the template
        // to use.
        $links[ 'edit' ] = 'ex_tvAddicts.php?'.PAGE.'='.PAGE_SERIESEDIT.'&seriesID=';
        $pageDisplay->setLinks( $links );
        break;
}


// be sure to load the form values if a form was submitted
if ( isset( $_REQUEST['submit']) ) {
    $pageDisplay->loadFromForm();
}




/*
 * Process the Data
 */

// only need to processData() if this was a form Submission
if ( isset( $_REQUEST['submit']) ) {

    // if the form data was valid
    if ( $pageDisplay->isDataValid() ) {
    
        // then process the data
        $pageDisplay->processData();
    }
}




/*
 * now display the HTML
 */
echo $pageDisplay->getHTML();


?>
