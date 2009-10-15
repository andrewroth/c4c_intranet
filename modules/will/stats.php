<?php
//IMPORTANT CODE
$pathFile = 'General/gen_Includes.php';
$extension = '';
// Attempt to find proper directory from current page to Root ...
$numAttempts = 0;
while ( (!file_exists($extension.$pathFile)) && ( $numAttempts < 5) ) {
    
    $extension = '../'.$extension;
    $numAttempts++; 
}
require ( $extension.$pathFile );
define('DB_NAME', 'ciministry');
define('DB_PATH', 'dbserver.powertochange.local');
define('DB_USER', 'ciministry');
define('DB_PWD', 'sPlat91over');
$db = new Database_MySQL();
$db->connectToDB( DB_NAME, DB_PATH, DB_USER, DB_PWD);
//END IMPORTANT CODE

//CURRENT YEAR ID
$curMonth = '"'.date("F Y").'"';
$sql = 'SELECT year_id, month_id FROM cim_stats_month WHERE month_desc='.$curMonth;
$db->runSQL($sql);
while( $row=$db->retrieveRow() )
{
	$yearID = $row['year_id'];
	$curMonth = $row['month_id'];
}	
//$yearID = 4; //CURRENT MINISTRY YEAR

?>
<font face="sans-serif">
<h3>Monthly Campus Stats </h3>
<form method="post">
Month: <select name="month"><br />
<option value="#">Select Month</option>
<?php
		$sql = 'SELECT month_id, month_desc FROM cim_stats_month WHERE year_id='.$yearID;
			$db->runSQL($sql);
			while( $row=$db->retrieveRow() )
			{
				if ( intval($row["month_id"]) > intval($curMonth) ){
					//Don't show it
				} else {
					echo '<option value="'.$row["month_id"].'">'.$row["month_desc"].'</option>';
				}
			}

?>
</select>

<br /><br />

Campus: <select name="campus"><br />
<option value="#">Select Campus</option>
<?php
		$sql = 'SELECT campus_id, campus_desc FROM cim_hrdb_campus AS c INNER JOIN cim_hrdb_region AS r ON c.region_id=r.region_id WHERE country_id=1 ORDER BY campus_desc';
			$db->runSQL($sql);
			while( $row=$db->retrieveRow() )
			{
				echo '<option value="'.$row["campus_id"].'">'.$row["campus_desc"].'</option>';
			}

?>
</select>

<br /><br />
<input type="submit" name="submit" value="Submit" /> 
</form>
<center>
<?php

if( isset( $_POST["submit"] ) ) {
	$campusID = $_POST["campus"];
	$sql = 'SELECT c.campus_desc FROM cim_hrdb_campus AS c WHERE c.campus_id='.$campusID;
	$db->runSQL($sql);
	while( $row=$db->retrieveRow() )
	{
		$campus = $row['campus_desc'];
	}	
	$monthID = $_POST["month"];
	$curYear = 0;
	$monthNum = 0;
	$month = 0;
	$sql = 'SELECT m.month_number, m.month_calendaryear, m.month_desc FROM cim_stats_month AS m WHERE m.month_id='.$monthID;
	$db->runSQL($sql);
	while( $row=$db->retrieveRow() )
	{
		$monthNum = $row['month_number'];
		$curYear = $row['month_calendaryear'];
		$month = $row['month_desc'];
	}
		
	$monthGreater = '"'.$curYear.'-'.$monthNum.'-32"';
	$monthLower = '"'.$curYear.'-'.$monthNum.'-00"';
	
	$GosPres = 0; $SpConv = 0; $HSConv = 0; $SpConvStd = 0; $GosPresStd = 0; $PRC = 0;
	
	$sql = 'SELECT SUM(r.weeklyReport_1on1GosPres), SUM(r.weeklyReport_1on1SpConv),SUM(r.weeklyReport_1on1HsPres), SUM(r.weeklyReport_1on1SpConvStd),SUM(r.weeklyReport_1on1GosPresStd) FROM cim_stats_weeklyreport AS r INNER JOIN cim_stats_week AS w ON r.week_id=w.week_id WHERE w.month_id='.$monthID.' AND r.campus_id='.$campusID;
	$db->runSQL($sql);

	while( $row=$db->retrieveRow() )
	{
		$GosPres += $row['SUM(r.weeklyReport_1on1GosPres)'];
		$SpConv += $row['SUM(r.weeklyReport_1on1SpConv)'];
		$HSConv += $row['SUM(r.weeklyReport_1on1HsPres)'];
		$SpConvStd += $row['SUM(r.weeklyReport_1on1SpConvStd)'];
		$GosPresStd += $row['SUM(r.weeklyReport_1on1GosPresStd)'];
	}

	echo "<h4>Stats for ".$campus." during ".$month."</h4>";
	?>
	<table cellpadding='5' cellspacing='0' style="border: 2px #000000 solid;">
	<tr>
	<td style='border: 1px solid #FFFFFF;'></td><td><strong><center>Total</center></strong></td></td>
	</tr>
	<?php
	echo "<tr><td>Spiritual Conversations by Staff</td><td><center>".$SpConv."</center></td></tr>";
	echo "<tr><td>Spiritual Conversations by Students</td><td><center>".$SpConvStd."</center></td></tr>";
	$spTotal = $SpConv + $SpConvStd;
	echo "<tr><td><i><strong>Total Spiritual Conversations</strong></i></td><td><center><strong>".$spTotal."</strong></center></td></tr>";
	echo "<tr><td></td><td></td></tr>";	
	echo "<tr><td>Gospel Presentations by Staff</td><td><center>".$GosPres."</center></td></tr>";
	echo "<tr><td>Gospel Presentations by Students</td><td><center>".$GosPresStd."</center></td></tr>";
	$gpTotal = $GosPres + $GosPresStd;
	echo "<tr><td><i><strong>Total Gospel Presentations</strong></i></td><td><center><strong>".$gpTotal."</strong></center></td></tr>";
	echo "<tr><td></td><td></td></tr>";
	//echo "Spiritual Conversations by students: ".$SpConvStd."<br />";
	//echo "Gospel Presentations by students: ".$GosPresStd."<br />";
	echo "<tr><td><strong>HS Presentations</strong></td><td><center><strong>".$HSConv."</strong></center></td></tr>";
	
	$sql = 'SELECT COUNT(p.prc_id) FROM cim_stats_prc AS p WHERE campus_id ='.$campusID.' AND p.prc_date < '.$monthGreater.' AND p.prc_date > '.$monthLower;
	$db->runSQL($sql);
	while( $row=$db->retrieveRow() )
	{
		$PRC += $row['COUNT(p.prc_id)'];

	}
	echo "<tr><td></td><td></td></tr>";
	echo "<tr><td><strong>Indicated Decisions</strong></td><td><center><strong>".$PRC."</strong></center></td></tr></table><br />";
	echo "<br />";
	}
	
?>
</font>
</center>