<?php

require_once('../../../php5/objects/SiteObject.php');
require_once('../../../php5/objects/Database.php');

$db = new Database_MySQL();
$db->connectToDB( 'site', 'localhost', 'root', 'jimbo111');

$commaList = '';
$firstDate = '2006-06-10';
$date = $firstDate;

for ( $i=0; $i < 200; $i++ )
{

    $sql = 'insert into cim_stats_week set week_endDate="'.$date.'";';
    $time = strtotime($date);
    $date = date( "Y-m-d", mktime( 0, 0, 0, date('m', $time), date('d',$time)+7, date('Y',$time) ) );
    echo $sql.'<br/>';
    $db->runSQL($sql);

}

?>