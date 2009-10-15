<?PHP 
// check to see if this form was just submitted:
// if so, there should be the value of the Submit button in the $_REQUEST array
if (isset( $_REQUEST[ 'Submit' ] ) ) {
	
	// load the site objects
    $pathFile = 'General/gen_Includes.php';
    $extension = '';
        
    // Attempt to find proper directory from current page to Root ...
    $numAttempts = 0;
    while ( (!file_exists($extension.$pathFile)) && ( $numAttempts < 5) ) {
        
        $extension = '../'.$extension;
        $numAttempts++; 
    }
    
    require ( $extension.$pathFile );

    /*
     * This script expects that these files are in the same directory 
     */
    require( 'EpisodeManager.php' );


	$series = new RowManager_EpisodeManager();
    $series->setTitle( $_REQUEST[ 'title' ] );
    $series->setAirDate( $_REQUEST[ 'airdate' ] );
    $series->setNumberTimesWatched( $_REQUEST[ 'watched' ] );
    $series->setSeasonID( 1 );	
    $series->createNewEntry();
    
}
?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>FormExample</title>
</head>
<body>
<h1>Enter A new Episode:</h1>
<form action="" method="post">
Episode Title: <input name="title" type="text"><br>
Episode AirDate: <input name="airdate" type="text"><br>
Number of Times Watched: <input name="watched" type="text"><br>
<input type="submit" name="Submit" value="Submit">
</form>
</body>
</html>
