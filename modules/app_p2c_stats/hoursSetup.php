<?php

require_once('../../../php5/objects/SiteObject.php');
require_once('../../../php5/objects/Database.php');

$db = new Database_MySQL();
$db->connectToDB( 'ciministry_development', 'localhost', 'spt', 'cIm777');

$HOUR = 6;	// = freq_id

$commaList = '';
// $firstDate = '0000-00-00 24:00:00';
// $date = $firstDate;
$hour = '0000-00-00 00:00:01';
$hourDesc = '00:00';
$zerofill = '';

for ( $i=1; $i < 25; $i++ )
{
    $sql = 'insert into p2c_stats_freqvalue values ("", '.$HOUR.',"'.$hour.'","'.$hourDesc.'");';

    if (strlen($i) == 1)
    {
	    $zerofill = '0';
    }
    else
    {
	    $zerofill = '';
    }
    
    $hour = "0000-00-00 ".$zerofill.$i.":00:01";
    $hourDesc = $zerofill.$i.':00';

    echo $sql.'<br/>';
     $db->runSQL($sql);


}

?>