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





/***
 *** Load All Data needed to carry out Edit Operation
 ***/

// read in the expected seriesID from the querystring ...
// if not set, default to -1
$seriesID = -1;
if ( isset( $_REQUEST[ 'seriesID' ] ) ) {
    $seriesID = $_REQUEST[ 'seriesID' ];
}


// Load in the requested SeriesManager from the DB
$seriesManager = new RowManager_SeriesManager( $seriesID );


// if the form was submitted, then load Form Data:
if ( isset( $_REQUEST['submit']) ) {
    $newTitle = $_REQUEST[ 'title' ];
}

// set default error Message
$titleError = '';





/***
 *** Process the Data
 ***/
if ( isset( $_REQUEST['submit']) ) {

    if ( $newTitle != '') {
        $seriesManager->setTitle( $newTitle );
        $seriesManager->updateDBTable();
    } else {
        $titleError = 'Title can\'t be empty';
    }
}






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
$template->set( 'formAction', 'ex_SeriesEdit.php?seriesID='.$seriesID );
$template->set( 'title', $seriesManager->getTitle() );
$template->set( 'titleError', $titleError);

// now we get the HTML of the Template and display that for our page.
echo $template->fetch( 'ex_SeriesEdit.tpl' );

?>
