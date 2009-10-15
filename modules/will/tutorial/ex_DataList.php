<?php

/*
 * This script will attempt to load the 3 RowManagers: SeriesManager, 
 * SeasonManager, and EpisodeManager and use them to create a set of entries.
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
require( 'EpisodeManager.php' );


?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Addiction List</title>
<style type="text/css">
<!--
.text_white {color: #FFFFFF}
-->
</style>
</head>
<body>
 <p>Current TV Addictions:</p>
 <table width="100" border="0" cellspacing="2" cellpadding="2">
     <tr>
         <td bgcolor="#666666"><span class="text_white">Episodes</span></td>
     </tr>
<?php

    // Now create a new episode manager
    $episodeManager = new RowManager_EpisodeManager();
    
    // get all the rows in this table
    $list = $episodeManager->getListIterator();
    
    // for each row
    $list->setFirst();
    while( $episode = $list->getNext() ) {
    
        // echo out a new table row with title as contents
        echo '<tr>
         <td>' . $episode->getTitle() . '</td>
     </tr>';
     
    } // next row
    
?>
 </table>
</body>
</html>