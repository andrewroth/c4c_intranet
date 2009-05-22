<?php

/*
 * This script will attempt to load the 3 RowManagers: SeriesManager, 
 * SeasonManager, and EpisodeManager and create their tables in the DB.
 * 

 */

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
require( 'SeriesManager.php' );
require( 'SeasonManager.php' );
require( 'EpisodeManager.php' );



// Now create each RowManager and use them to create the DB tables:
$series = new RowManager_SeriesManager();
$series->dropTable();
$series->createTable();

$season = new RowManager_SeasonManager();
$season->dropTable();
$season->createTable();

$episode = new RowManager_EpisodeManager();
$episode->dropTable();
$episode->createTable();

echo 'Done!  You should now find these tables in the '.SITE_DB_NAME.' database.<br>';

?>