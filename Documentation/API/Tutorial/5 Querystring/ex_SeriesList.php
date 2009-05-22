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





/***
 *** Load All Data needed to make the list
 ***/

// Get a list of all the series entries in the table
$seriesArray = array();
$seriesManager = new RowManager_SeriesManager();
    
// get all the rows in this table
$list = $seriesManager->getListIterator();

// for each row
$list->setFirst();
while( $series = $list->getNext() ) {

    $seriesArray[ $series->getID() ] = $series->getTitle();
 
} // next row


// Define the Edit link:
// NOTE: how it ends with "seriesID="
// it is intened for this link to be concatened with the series_id value in the 
// above array
$editLink = 'ex_SeriesEdit.php?seriesID=';





/***
 *** get HTML for display
 ***/
 
// Now we create a Template object 
// NOTE: (optional parameter is to set the path to your template file )
// ex   $template = new Template( "path/to/template/files/here.php" );
// if you don't set it, it assumes the template is in the same directory
// as your script.
//
$template = new Template( );

// Now we pass/set the values of variables in the Template
// 1st parameter is the name of the variable as it will be called in the template
// 2nd parameter is the current variable that you want to pass in
$template->set( 'seriesList', $seriesArray);
$template->set( 'editLink', $editLink);

// now we get the HTML of the Template and display that for our page.
echo $template->fetch( 'ex_SeriesList.tpl' );

?>
