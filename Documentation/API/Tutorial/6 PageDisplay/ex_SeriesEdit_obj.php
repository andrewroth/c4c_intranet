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
require( 'page_SeriesEdit.php' );



/*
 * Load the Data
 */

// Load in the ID of the row we want to edit. 
// Init to -1 if not given.
$seriesID = -1;
if ( isset( $_REQUEST[ 'seriesID' ] ) ) {
    $seriesID = $_REQUEST[ 'seriesID' ];
}

// mark the value of the call back 
$formAction = 'ex_SeriesEdit_obj.php?seriesID='.$seriesID;

// Create our nifty new PageDisplay object
// The constructor acts like our old loadData() 
$pageDisplay = new page_SeriesEdit( '', null, $formAction, $seriesID );

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
