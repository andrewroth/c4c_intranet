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

/* require_once('objects/Template.php');
require_once('objects/Database.php');
require_once('gen_Defines.php');
require_once('PageFunctions.php'); */

define('DB_NAME', 'ciministry');
define('DB_PATH', 'dbserver.powertochange.local');
define('DB_USER', 'ciministry');
define('DB_PWD', 'sPlat91over');

$db = new Database_MySQL();
$db->connectToDB( DB_NAME, DB_PATH, DB_USER, DB_PWD);

?>
<b>How are we doing nationally this semester?</b><br />
======<br /><br />
<?php
	$GosPres = 0; $SpConv = 0; $HSConv = 0; $SpConvStd = 0; $GosPresStd = 0;
	$sql = 'select sum(r.weeklyReport_1on1GosPres), sum(r.weeklyReport_1on1SpConv),sum(r.weeklyReport_1on1HsPres), sum(r.weeklyReport_1on1SpConvStd),sum(r.weeklyReport_1on1GosPresStd) from cim_stats_weeklyreport as r inner join cim_stats_week as w on r.week_id=w.week_id where w.semester_id = 10 group by w.semester_id';
	$db->runSQL($sql);
	while( $row=$db->retrieveRow() )
	{
		$GosPres += $row['sum(r.weeklyReport_1on1GosPres)'];
		$SpConv += $row['sum(r.weeklyReport_1on1SpConv)'];
		$HSConv += $row['sum(r.weeklyReport_1on1HsPres)'];
		$SpConvStd += $row['sum(r.weeklyReport_1on1SpConvStd)'];
		$GosPresStd += $row['sum(r.weeklyReport_1on1GosPresStd)'];
	}
	echo "Spiritual Conversations by staff: ".$SpConv."<br />";
	echo "Gospel Presentations by staff: ".$GosPres."<br />";
	echo "<br />";
	echo "Spiritual Conversations by students: ".$SpConvStd."<br />";
	echo "Gospel Presentations by students: ".$GosPresStd."<br />";
	echo "<br />";
	echo "HS Presentations by staff: ".$HSConv."<br />";
	echo "<br />";
	
?>
<b>How many staff submitted reports:</b><br />
======<br /><br />
<?php
	$sql = 'select count(distinct(staff_id)) from cim_stats_weeklyreport as r inner join cim_stats_week as w on r.week_id=w.week_id where w.semester_id = 10';
	$db->runSQL($sql);
	$row=$db->retrieveRow();
	echo "Answer: ".$row['count(distinct(staff_id))']."<br />";
	echo "<br />";
?>
<b>How many students are signed up for Summit?</b><br />
======<br /><br />
<?php
	$total = 0;
	$sql = 'select count(r.person_id), e.event_id, e.event_name from cim_reg_registration as r inner join cim_reg_event as e on r.event_id=e.event_id where e.event_id>=50 and e.event_id<=58 group by e.event_id order by count(r.person_id) asc';
	$db->runSQL($sql);
	while( $row=$db->retrieveRow() )
	{
		echo $row['count(r.person_id)']." - ".$row['event_name']."<br />";
		$total += $row['count(r.person_id)'];
	}
	echo "<br />Total: ".$total."<br /><br />";
?>