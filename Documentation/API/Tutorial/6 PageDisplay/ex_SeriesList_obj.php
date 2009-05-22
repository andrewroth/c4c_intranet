<?php
/*
 * Include required files
 */
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


// Create our nifty new PageDisplay object
// The constructor acts like our old loadData() 
$pageDisplay = new page_SeriesList( '', null, '');

// our script is now responsible to know about the links of the 
// application. So it creates an array of links for the template
// to use.
$links[ 'edit' ] = 'ex_SeriesEdit_obj.php?seriesID=';
$pageDisplay->setLinks( $links );



// only need to check for form operations if this was a form Submission
if ( isset( $_REQUEST['submit']) ) {

    // if the form data was valid
    if ( $pageDisplay->isDataValid() ) {
    
        // then process the data
        $pageDisplay->processData();
    }
}

// now display the HTML
echo $pageDisplay->getHTML();

?>
