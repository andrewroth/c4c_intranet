<?php

require_once('../../../php5/objects/SiteObject.php');
require_once('../../../php5/objects/Database.php');

$db = new Database_MySQL();
$db->connectToDB( 'ciministry_development', 'localhost', 'spt', 'cIm777');

$WEEK = 3;	// = freq_id

$commaList = '';
$firstDate = '2007-12-30';
$date = $firstDate;
$weekDesc = 'Week 1 of 2008';
$j = 2;

for ( $i=0; $i < 200; $i++ )
{

//     $sql = 'insert into p2c_stats_freqvalue set freqvalue_value ="'.$date.'" and freq_id ='.$WEEK.' and freqvalue_desc="'.$weekDesc.'";';
    $sql = 'insert into p2c_stats_freqvalue values ("", '.$WEEK.',"'.$date.'","'.$weekDesc.'");';
    $time = strtotime($date);
    $new_time = mktime( 0, 0, 0, date('m', $time), date('d',$time)+7, date('Y',$time) );
    $date = date( "Y-m-d", $new_time );
    
 	 if ($j == 53)	// reset week number for every year
	 {
		$j = 1;	
		$new_year = mktime( 0, 0, 0, date('m', $time), date('d',$time), date('Y',$time)+1 );
		$weekDesc = 'Week '.$j.' of '.date('Y',$new_year); 	
	 }
	 else
	 {
    	$weekDesc = 'Week '.$j.' of '.date('Y',$new_time);
 	 }
    echo $sql.'<br/>';
     $db->runSQL($sql);

	$j++;

}

?>