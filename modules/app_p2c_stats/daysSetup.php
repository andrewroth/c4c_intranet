<?php

require_once('../../../php5/objects/SiteObject.php');
require_once('../../../php5/objects/Database.php');

$db = new Database_MySQL();
$db->connectToDB( 'ciministry_development', 'localhost', 'spt', 'cIm777');

$DAY = 4;	// = freq_id

$commaList = '';
$firstDate = '0000-01-01';
$date = $firstDate;
$dayDesc = 'January 1';

for ( $i=0; $i < 366; $i++ )
{

    $sql = 'insert into p2c_stats_freqvalue values ("", '.$DAY.',"'.$date.'","'.$dayDesc.'");';
    $date = '2000'.substr($date,4);	// temporarily use the year 2000; replaced with 0000 later
    $time = strtotime($date);
    $new_time = mktime( 0, 0, 0, date('m', $time), date('d',$time)+1, date('Y',$time) );
    
    $date = "0000-".date( "m-d", $new_time );
    $month = date( "F", $new_time );
    $day = date( "j", $new_time );

    $dayDesc = $month.' '.$day;

    echo $sql.'<br/>';
     $db->runSQL($sql);


}

?>