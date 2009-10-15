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

//CURRENT MONTH ID
$curMonth = '"'.date("F Y").'"';
$sql = 'SELECT month_id FROM cim_stats_month WHERE month_desc='.$curMonth;
$db->runSQL($sql);
while( $row=$db->retrieveRow() )
{
	$monthID = $row['month_id'];
}	

?>
<font face="sans-serif">
<h3>Regional Monthly Summary by Week</h3>
<form method="post">
Month: <select name="month"><br />
<option value="#">Select Month</option>
<?php
		$sql = 'SELECT month_id, month_desc FROM cim_stats_month';
			$db->runSQL($sql);
			while( $row=$db->retrieveRow() )
			{
				if ( intval($row['month_id']) > intval($monthID) ) {
					//Don't show it
				} else {
					echo '<option value="'.$row["month_id"].'">'.$row["month_desc"].'</option>';
				}
			}

?>
</select>

<br /><br />
<input type="submit" name="submit" value="Submit" /> 
</form>
<center>
<?php

if( isset( $_POST["submit"] ) ) {
	$monthID = $_POST["month"];
}

$sql = 'SELECT month_desc FROM cim_stats_month WHERE month_id='.$monthID;
$db->runSQL($sql);
while( $row=$db->retrieveRow() )
{
	$month = $row['month_desc'];
}	
//Get Weeks
$sql = "SELECT week_id FROM cim_stats_week WHERE month_id=".$monthID." ORDER BY week_id";
$db->runSQL($sql);
$m = array('','','','');
$n = array('','','','');
$i=0;
while( $row=$db->retrieveRow() )
{
	$n[$i] = $row['week_id'];
	$i+=1;
	$m[$i-1] = "Week ".$i;
}	

//Ontario and Atlantic Stats
$sql = "SELECT SUM(r.weeklyReport_1on1GosPres), SUM(r.weeklyReport_1on1SpConv),SUM(r.weeklyReport_1on1HsPres), SUM(r.weeklyReport_1on1SpConvStd),SUM(r.weeklyReport_1on1GosPresStd) FROM cim_stats_weeklyreport AS r INNER JOIN cim_stats_week AS w ON r.week_id=w.week_id INNER JOIN cim_hrdb_campus AS n ON r.campus_id=n.campus_id WHERE region_id=1 AND month_id=".$monthID;
$db->runSQL($sql);
while( $row=$db->retrieveRow() )
{
	$oGosPres = $row['SUM(r.weeklyReport_1on1GosPres)'];
	$oSpConv = $row['SUM(r.weeklyReport_1on1SpConv)'];
	$oHSConv = $row['SUM(r.weeklyReport_1on1HsPres)'];
	$oSpConvStd = $row['SUM(r.weeklyReport_1on1SpConvStd)'];
	$oGosPresStd = $row['SUM(r.weeklyReport_1on1GosPresStd)'];
}	
$sql = 'SELECT m.month_number, m.month_calendaryear, m.month_desc FROM cim_stats_month AS m WHERE m.month_id='.$monthID;
$db->runSQL($sql);
while( $row=$db->retrieveRow() )
{
	$monthNum = $row['month_number'];
	$curYear = $row['month_calendaryear'];
	$month = $row['month_desc'];
}
	
$monthGreater = '"'.$curYear.'-'.$monthNum.'-31"';
$monthLower = '"'.$curYear.'-'.$monthNum.'-00"';

$sql = "SELECT COUNT(p.prc_id) FROM cim_stats_prc AS p INNER JOIN cim_hrdb_campus AS n ON p.campus_id=n.campus_id WHERE region_id=1 AND p.prc_date <= ".$monthGreater." AND p.prc_date > ".$monthLower;
$db->runSQL($sql);
while( $row=$db->retrieveRow() )
{
	$qPRC = $row['COUNT(p.prc_id)'];
}

//West Stats
$sql = "SELECT SUM(r.weeklyReport_1on1GosPres), SUM(r.weeklyReport_1on1SpConv),SUM(r.weeklyReport_1on1HsPres), SUM(r.weeklyReport_1on1SpConvStd),SUM(r.weeklyReport_1on1GosPresStd) FROM cim_stats_weeklyreport AS r INNER JOIN cim_stats_week AS w ON r.week_id=w.week_id INNER JOIN cim_hrdb_campus AS n ON r.campus_id=n.campus_id WHERE region_id=3 AND month_id=".$monthID;
$db->runSQL($sql);
while( $row=$db->retrieveRow() )
{
	$wGosPres = $row['SUM(r.weeklyReport_1on1GosPres)'];
	$wSpConv = $row['SUM(r.weeklyReport_1on1SpConv)'];
	$wHSConv = $row['SUM(r.weeklyReport_1on1HsPres)'];
	$wSpConvStd = $row['SUM(r.weeklyReport_1on1SpConvStd)'];
	$wGosPresStd = $row['SUM(r.weeklyReport_1on1GosPresStd)'];
}		
$sql = 'SELECT m.month_number, m.month_calendaryear, m.month_desc FROM cim_stats_month AS m WHERE m.month_id='.$monthID;
$db->runSQL($sql);
while( $row=$db->retrieveRow() )
{
	$monthNum = $row['month_number'];
	$curYear = $row['month_calendaryear'];
	$month = $row['month_desc'];
}
	
$monthGreater = '"'.$curYear.'-'.$monthNum.'-31"';
$monthLower = '"'.$curYear.'-'.$monthNum.'-00"';

$sql = "SELECT COUNT(p.prc_id) FROM cim_stats_prc AS p INNER JOIN cim_hrdb_campus AS n ON p.campus_id=n.campus_id WHERE region_id=3 AND p.prc_date <= ".$monthGreater." AND p.prc_date > ".$monthLower;
$db->runSQL($sql);
while( $row=$db->retrieveRow() )
{
	$wPRC = $row['COUNT(p.prc_id)'];
}

//Quebec Stats
$sql = "SELECT SUM(r.weeklyReport_1on1GosPres), SUM(r.weeklyReport_1on1SpConv),SUM(r.weeklyReport_1on1HsPres), SUM(r.weeklyReport_1on1SpConvStd),SUM(r.weeklyReport_1on1GosPresStd) FROM cim_stats_weeklyreport AS r INNER JOIN cim_stats_week AS w ON r.week_id=w.week_id INNER JOIN cim_hrdb_campus AS n ON r.campus_id=n.campus_id WHERE region_id=2 AND month_id=".$monthID;
$db->runSQL($sql);
while( $row=$db->retrieveRow() )
{
	$qGosPres = $row['SUM(r.weeklyReport_1on1GosPres)'];
	$qSpConv = $row['SUM(r.weeklyReport_1on1SpConv)'];
	$qHSConv = $row['SUM(r.weeklyReport_1on1HsPres)'];
	$qSpConvStd = $row['SUM(r.weeklyReport_1on1SpConvStd)'];
	$qGosPresStd = $row['SUM(r.weeklyReport_1on1GosPresStd)'];
}		
$sql = 'SELECT m.month_number, m.month_calendaryear, m.month_desc FROM cim_stats_month AS m WHERE m.month_id='.$monthID;
$db->runSQL($sql);
while( $row=$db->retrieveRow() )
{
	$monthNum = $row['month_number'];
	$curYear = $row['month_calendaryear'];
	$month = $row['month_desc'];
}
	
$monthGreater = '"'.$curYear.'-'.$monthNum.'-31"';
$monthLower = '"'.$curYear.'-'.$monthNum.'-00"';

$sql = "SELECT COUNT(p.prc_id) FROM cim_stats_prc AS p INNER JOIN cim_hrdb_campus AS n ON p.campus_id=n.campus_id WHERE region_id=2 AND p.prc_date <= ".$monthGreater." AND p.prc_date > ".$monthLower;
$db->runSQL($sql);
while( $row=$db->retrieveRow() )
{
	$oPRC = $row['COUNT(p.prc_id)'];
}

//Total
$nGosPres = $qGosPres + $wGosPres + $oGosPres; 
$nSpConv = $qSpConv + $wSpConv + $oSpConv; 
$nHSConv = $qHSConv + $wHSConv + $oHSConv; 
$nSpConvStd = $qSpConvStd + $wSpConvStd + $oSpConvStd; 
$nGosPresStd = $qGosPresStd + $wGosPresStd + $oGosPresStd;
$nPRC = $qPRC + $wPRC + $oPRC;

echo "<h4>Total Stats for ".$month."</h4>";
?>
<table cellpadding='5' cellspacing='0' style="border: 2px #000000 solid;">
<tr>
<td style='border: 1px solid #FFFFFF;'></td><td><strong><center>Ontario and Atlantic</center></strong></td><td><strong><center>West</center></strong></td><td><strong><center>Quebec</center></strong></td><td><strong><center>National Total</center></strong></td>
</tr>
<?php
echo "<tr><td>Spiritual Conversations by Staff</td><td><center>".$oSpConv."</center></td><td><center>".$wSpConv."</center></td><td><center>".$qSpConv."</center></td><td><center>".$nSpConv."</center></td></tr>";
echo "<tr><td>Spiritual Conversations by Students</td><td><center>".$oSpConvStd."</center></td><td><center>".$wSpConvStd."</center></td><td><center>".$qSpConvStd."</center></td><td><center>".$nSpConvStd."</center></td></tr>";
echo "<tr><td>Gospel Presentations by Staff</td><td><center>".$oGosPres."</center></td><td><center>".$wGosPres."</center></td><td><center>".$qGosPres."</center></td><td><center>".$nGosPres."</center></td></tr>";
echo "<tr><td>Gospel Presentations by Students</td><td><center>".$oGosPresStd."</center></td><td><center>".$wGosPresStd."</center></td><td><center>".$qGosPresStd."</center></td><td><center>".$nGosPresStd."</center></td></tr>";
echo "<tr><td>Holy Spirit Presentations by Staff</td><td><center>".$oHSConv."</center></td><td><center>".$wHSConv."</center></td><td><center>".$qHSConv."</center></td><td><center>".$nHSConv."</center></td></tr>";
echo "<tr><td></td><td><center></center></td><td><center></center></td><td><center></center></td><td><center></center></td></tr>";
echo "<tr><td>Indicated Decisions</td><td><center>".$oPRC."</center></td><td><center>".$wPRC."</center></td><td><center>".$qPRC."</center></td><td><center>".$nPRC."</center></td></tr>";
echo "</table><br />";

//Weekly Totals	
echo "<h4>Total Stats by Week</h4>";
?>
<table cellpadding='5' cellspacing='0' style="border: 2px #000000 solid;">
<tr>
<?php

//Week 1
$sql = "SELECT SUM(r.weeklyReport_1on1GosPres), SUM(r.weeklyReport_1on1SpConv),SUM(r.weeklyReport_1on1HsPres), SUM(r.weeklyReport_1on1SpConvStd),SUM(r.weeklyReport_1on1GosPresStd) FROM cim_stats_weeklyreport AS r INNER JOIN cim_stats_week AS w ON r.week_id=w.week_id INNER JOIN cim_hrdb_campus AS n ON r.campus_id=n.campus_id WHERE region_id<>4 AND r.week_id=".$n[0];
$db->runSQL($sql);
while( $row=$db->retrieveRow() )
{
	$xGosPres = $row['SUM(r.weeklyReport_1on1GosPres)'];
	$xSpConv = $row['SUM(r.weeklyReport_1on1SpConv)'];
	$xHSConv = $row['SUM(r.weeklyReport_1on1HsPres)'];
	$xSpConvStd = $row['SUM(r.weeklyReport_1on1SpConvStd)'];
	$xGosPresStd = $row['SUM(r.weeklyReport_1on1GosPresStd)'];
}	
$sql = 'SELECT week_endDate FROM cim_stats_week WHERE week_id='.$n[0];
$db->runSQL($sql);
while( $row=$db->retrieveRow() )
{
	$weekGreater = "'".$row['week_endDate']."'";
}
$sql = 'SELECT week_endDate FROM cim_stats_week WHERE week_id='.($n[0]-1);
$db->runSQL($sql);
while( $row=$db->retrieveRow() )
{
	$weekLower = "'".$row['week_endDate']."'";
}
$sql = "SELECT COUNT(p.prc_id) FROM cim_stats_prc AS p INNER JOIN cim_hrdb_campus AS n ON p.campus_id=n.campus_id WHERE region_id<>4 AND prc_date<=".$weekGreater." AND prc_date>".$weekLower;
$db->runSQL($sql);
while( $row=$db->retrieveRow() )
{
	$xPRC = $row['COUNT(p.prc_id)'];
}	


//Week 2
$sql = "SELECT SUM(r.weeklyReport_1on1GosPres), SUM(r.weeklyReport_1on1SpConv),SUM(r.weeklyReport_1on1HsPres), SUM(r.weeklyReport_1on1SpConvStd),SUM(r.weeklyReport_1on1GosPresStd) FROM cim_stats_weeklyreport AS r INNER JOIN cim_stats_week AS w ON r.week_id=w.week_id INNER JOIN cim_hrdb_campus AS n ON r.campus_id=n.campus_id WHERE region_id<>4 AND r.week_id=".$n[1];
$db->runSQL($sql);
while( $row=$db->retrieveRow() )
{
	$yGosPres = $row['SUM(r.weeklyReport_1on1GosPres)'];
	$ySpConv = $row['SUM(r.weeklyReport_1on1SpConv)'];
	$yHSConv = $row['SUM(r.weeklyReport_1on1HsPres)'];
	$ySpConvStd = $row['SUM(r.weeklyReport_1on1SpConvStd)'];
	$yGosPresStd = $row['SUM(r.weeklyReport_1on1GosPresStd)'];
}	
$sql = 'SELECT week_endDate FROM cim_stats_week WHERE week_id='.$n[1];
$db->runSQL($sql);
while( $row=$db->retrieveRow() )
{
	$weekGreater = "'".$row['week_endDate']."'";
}
$sql = 'SELECT week_endDate FROM cim_stats_week WHERE week_id='.($n[1]-1);
$db->runSQL($sql);
while( $row=$db->retrieveRow() )
{
	$weekLower = "'".$row['week_endDate']."'";
}
$sql = "SELECT COUNT(p.prc_id) FROM cim_stats_prc AS p INNER JOIN cim_hrdb_campus AS n ON p.campus_id=n.campus_id WHERE region_id<>4 AND prc_date<=".$weekGreater." AND prc_date>".$weekLower;
$db->runSQL($sql);
while( $row=$db->retrieveRow() )
{
	$yPRC = $row['COUNT(p.prc_id)'];
}	

//Week 3
$sql = "SELECT SUM(r.weeklyReport_1on1GosPres), SUM(r.weeklyReport_1on1SpConv),SUM(r.weeklyReport_1on1HsPres), SUM(r.weeklyReport_1on1SpConvStd),SUM(r.weeklyReport_1on1GosPresStd) FROM cim_stats_weeklyreport AS r INNER JOIN cim_stats_week AS w ON r.week_id=w.week_id INNER JOIN cim_hrdb_campus AS n ON r.campus_id=n.campus_id WHERE region_id<>4 AND r.week_id=".$n[2];
$db->runSQL($sql);
while( $row=$db->retrieveRow() )
{
	$zGosPres = $row['SUM(r.weeklyReport_1on1GosPres)'];
	$zSpConv = $row['SUM(r.weeklyReport_1on1SpConv)'];
	$zHSConv = $row['SUM(r.weeklyReport_1on1HsPres)'];
	$zSpConvStd = $row['SUM(r.weeklyReport_1on1SpConvStd)'];
	$zGosPresStd = $row['SUM(r.weeklyReport_1on1GosPresStd)'];
}	
$sql = 'SELECT week_endDate FROM cim_stats_week WHERE week_id='.$n[2];
$db->runSQL($sql);
while( $row=$db->retrieveRow() )
{
	$weekGreater = "'".$row['week_endDate']."'";
}
$sql = 'SELECT week_endDate FROM cim_stats_week WHERE week_id='.($n[2]-1);
$db->runSQL($sql);
while( $row=$db->retrieveRow() )
{
	$weekLower = "'".$row['week_endDate']."'";
}
$sql = "SELECT COUNT(p.prc_id) FROM cim_stats_prc AS p INNER JOIN cim_hrdb_campus AS n ON p.campus_id=n.campus_id WHERE region_id<>4 AND prc_date<=".$weekGreater." AND prc_date>".$weekLower;
$db->runSQL($sql);
while( $row=$db->retrieveRow() )
{
	$zPRC = $row['COUNT(p.prc_id)'];
}	

//Week 4
$sql = "SELECT SUM(r.weeklyReport_1on1GosPres), SUM(r.weeklyReport_1on1SpConv),SUM(r.weeklyReport_1on1HsPres), SUM(r.weeklyReport_1on1SpConvStd),SUM(r.weeklyReport_1on1GosPresStd) FROM cim_stats_weeklyreport AS r INNER JOIN cim_stats_week AS w ON r.week_id=w.week_id INNER JOIN cim_hrdb_campus AS n ON r.campus_id=n.campus_id WHERE region_id<>4 AND r.week_id=".$n[3];
$db->runSQL($sql);
while( $row=$db->retrieveRow() )
{
	$zzGosPres = $row['SUM(r.weeklyReport_1on1GosPres)'];
	$zzSpConv = $row['SUM(r.weeklyReport_1on1SpConv)'];
	$zzHSConv = $row['SUM(r.weeklyReport_1on1HsPres)'];
	$zzSpConvStd = $row['SUM(r.weeklyReport_1on1SpConvStd)'];
	$zzGosPresStd = $row['SUM(r.weeklyReport_1on1GosPresStd)'];
}	
$sql = 'SELECT week_endDate FROM cim_stats_week WHERE week_id='.$n[3];
$db->runSQL($sql);
while( $row=$db->retrieveRow() )
{
	$weekGreater = "'".$row['week_endDate']."'";
}
$sql = 'SELECT week_endDate FROM cim_stats_week WHERE week_id='.($n[3]-1);
$db->runSQL($sql);
while( $row=$db->retrieveRow() )
{
	$weekLower = "'".$row['week_endDate']."'";
}
$sql = "SELECT COUNT(p.prc_id) FROM cim_stats_prc AS p INNER JOIN cim_hrdb_campus AS n ON p.campus_id=n.campus_id WHERE region_id<>4 AND prc_date<=".$weekGreater." AND prc_date>".$weekLower;
$db->runSQL($sql);
while( $row=$db->retrieveRow() )
{
	$zzPRC = $row['COUNT(p.prc_id)'];
}	

if ( count($n)==5 ){
	//Week 5
	$sql = "SELECT SUM(r.weeklyReport_1on1GosPres), SUM(r.weeklyReport_1on1SpConv),SUM(r.weeklyReport_1on1HsPres), SUM(r.weeklyReport_1on1SpConvStd),SUM(r.weeklyReport_1on1GosPresStd) FROM cim_stats_weeklyreport AS r INNER JOIN cim_stats_week AS w ON r.week_id=w.week_id INNER JOIN cim_hrdb_campus AS n ON r.campus_id=n.campus_id WHERE region_id<>4 AND r.week_id=".$n[4];
	$db->runSQL($sql);
	while( $row=$db->retrieveRow() )
	{
		$zzzGosPres = $row['SUM(r.weeklyReport_1on1GosPres)'];
		$zzzSpConv = $row['SUM(r.weeklyReport_1on1SpConv)'];
		$zzzHSConv = $row['SUM(r.weeklyReport_1on1HsPres)'];
		$zzzSpConvStd = $row['SUM(r.weeklyReport_1on1SpConvStd)'];
		$zzzGosPresStd = $row['SUM(r.weeklyReport_1on1GosPresStd)'];
	}	
	$sql = 'SELECT week_endDate FROM cim_stats_week WHERE week_id='.$n[4];
	$db->runSQL($sql);
	while( $row=$db->retrieveRow() )
	{
		$weekGreater = "'".$row['week_endDate']."'";
	}
	$sql = 'SELECT week_endDate FROM cim_stats_week WHERE week_id='.($n[4]-1);
	$db->runSQL($sql);
	while( $row=$db->retrieveRow() )
	{
		$weekLower = "'".$row['week_endDate']."'";
	}
	$sql = "SELECT COUNT(p.prc_id) FROM cim_stats_prc AS p INNER JOIN cim_hrdb_campus AS n ON p.campus_id=n.campus_id WHERE region_id<>4 AND prc_date<=".$weekGreater." AND prc_date>".$weekLower;
	$db->runSQL($sql);
	while( $row=$db->retrieveRow() )
	{
		$zzzPRC = $row['COUNT(p.prc_id)'];
	}	

	//Total
	$tGosPres = $xGosPres + $yGosPres + $zGosPres + $zzGosPres + $zzzGosPres; 
	$tSpConv = $xSpConv + $ySpConv + $zSpConv + $zzSpConv + $zzzSpConv; 
	$tHSConv = $xHSConv + $yHSConv + $zHSConv + $zzHSConv + $zzzHSConv; 
	$tSpConvStd = $xSpConvStd + $ySpConvStd + $zSpConvStd + $zzSpConvStd + $zzzSpConvStd; 
	$tGosPresStd = $xGosPresStd + $yGosPresStd + $zGosPresStd + $zzGosPresStd + $zzzGosPresStd;
	$tPRC = $xPRC + $yPRC + $zPRC + $zzPRC + $zzzPRC;
	
	echo "<td style='border: 1px solid #FFFFFF;'></td><td><strong><center>".$m[0]."</center></strong></td><td><strong><center>".$m[1]."</center></strong></td><td><strong><center>".$m[2]."</center></strong></td><td><strong><center>".$m[3]."</center></strong></td><td><strong><center>".$m[4]."</center></strong></td><td><strong><center>Total</center></strong></td></tr>";
	echo "<tr><td>Spiritual Conversations by Staff</td><td><center>".$xSpConv."</center></td><td><center>".$ySpConv."</center></td><td><center>".$zSpConv."</center></td><td><center>".$zzSpConv."</center></td><td><center>".$zzzSpConv."</center></td><td><center>".$tSpConv."</center></td></tr>";
	echo "<tr><td>Spiritual Conversations by Students</td><td><center>".$xSpConvStd."</center></td><td><center>".$ySpConvStd."</center></td><td><center>".$zSpConvStd."</center></td><td><center>".$zzSpConvStd."</center></td><td><center>".$zzzSpConvStd."</center></td><td><center>".$tSpConvStd."</center></td></tr>";
	echo "<tr><td>Gospel Presentations by Staff</td><td><center>".$xGosPres."</center></td><td><center>".$yGosPres."</center></td><td><center>".$zGosPres."</center></td><td><center>".$zzGosPres."</center></td><td><center>".$zzzGosPres."</center></td><td><center>".$tGosPres."</center></td></tr>";
	echo "<tr><td>Gospel Presentations by Students</td><td><center>".$xGosPresStd."</center></td><td><center>".$yGosPresStd."</center></td><td><center>".$zGosPresStd."</center></td><td><center>".$zzGosPresStd."</center></td><td><center>".$zzzGosPresStd."</center></td><td><center>".$tGosPresStd."</center></td></tr>";
	echo "<tr><td>Holy Spirit Presentations by Staff</td><td><center>".$xHSConv."</center></td><td><center>".$yHSConv."</center></td><td><center>".$zHSConv."</center></td><td><center>".$zzHSConv."</center></td><td><center>".$zzzHSConv."</center></td><td><center>".$tHSConv."</center></td></tr>";
	echo "<tr><td></td><td><center></center></td><td><center></center></td><td><center></center></td><td><center></center></td><td><center></center></td></tr>";
	echo "<tr><td>Indicated Decisions</td><td><center>".$xPRC."</center></td><td><center>".$yPRC."</center></td><td><center>".$zPRC."</center></td><td><center>".$zzPRC."</center></td><td><center>".$zzzPRC."</center></td><td><center>".$tPRC."</center></td></tr>";
	echo "</table><br />";
	
}
else{
	//Total
	$tGosPres = $xGosPres + $yGosPres + $zGosPres + $zzGosPres; 
	$tSpConv = $xSpConv + $ySpConv + $zSpConv + $zzSpConv; 
	$tHSConv = $xHSConv + $yHSConv + $zHSConv + $zzHSConv; 
	$tSpConvStd = $xSpConvStd + $ySpConvStd + $zSpConvStd + $zzSpConvStd; 
	$tGosPresStd = $xGosPresStd + $yGosPresStd + $zGosPresStd + $zzGosPresStd;
	$tPRC = $xPRC + $yPRC + $zPRC + $zzPRC;
	
	echo "<td style='border: 1px solid #FFFFFF;'></td><td><strong><center>".$m[0]."</center></strong></td><td><strong><center>".$m[1]."</center></strong></td><td><strong><center>".$m[2]."</center></strong></td><td><strong><center>".$m[3]."</center></strong></td><td><strong><center>Total</center></strong></td></tr>";
	echo "<tr><td>Spiritual Conversations by Staff</td><td><center>".$xSpConv."</center></td><td><center>".$ySpConv."</center></td><td><center>".$zSpConv."</center></td><td><center>".$zzSpConv."</center></td><td><center>".$tSpConv."</center></td></tr>";
	echo "<tr><td>Spiritual Conversations by Students</td><td><center>".$xSpConvStd."</center></td><td><center>".$ySpConvStd."</center></td><td><center>".$zSpConvStd."</center></td><td><center>".$zzSpConvStd."</center></td><td><center>".$tSpConvStd."</center></td></tr>";
	echo "<tr><td>Gospel Presentations by Staff</td><td><center>".$xGosPres."</center></td><td><center>".$yGosPres."</center></td><td><center>".$zGosPres."</center></td><td><center>".$zzGosPres."</center></td><td><center>".$tGosPres."</center></td></tr>";
	echo "<tr><td>Gospel Presentations by Students</td><td><center>".$xGosPresStd."</center></td><td><center>".$yGosPresStd."</center></td><td><center>".$zGosPresStd."</center></td><td><center>".$zzGosPresStd."</center></td><td><center>".$tGosPresStd."</center></td></tr>";
	echo "<tr><td>Holy Spirit Presentations by Staff</td><td><center>".$xHSConv."</center></td><td><center>".$yHSConv."</center></td><td><center>".$zHSConv."</center></td><td><center>".$zzHSConv."</center></td><td><center>".$tHSConv."</center></td></tr>";
	echo "<tr><td></td><td><center></center></td><td><center></center></td><td><center></center></td><td><center></center></td></tr>";
	echo "<tr><td>Indicated Decisions</td><td><center>".$xPRC."</center></td><td><center>".$yPRC."</center></td><td><center>".$zPRC."</center></td><td><center>".$zzPRC."</center></td><td><center>".$tPRC."</center></td></tr>";
	echo "</table><br />";
}

//Ontario and Atlantic Totals	
echo "<h4>Ontario and Atlantic Stats by Week</h4>";
?>
<table cellpadding='5' cellspacing='0' style="border: 2px #000000 solid;">
<tr>
<?php

//Week 1
$sql = "SELECT SUM(r.weeklyReport_1on1GosPres), SUM(r.weeklyReport_1on1SpConv),SUM(r.weeklyReport_1on1HsPres), SUM(r.weeklyReport_1on1SpConvStd),SUM(r.weeklyReport_1on1GosPresStd) FROM cim_stats_weeklyreport AS r INNER JOIN cim_stats_week AS w ON r.week_id=w.week_id INNER JOIN cim_hrdb_campus AS n ON r.campus_id=n.campus_id WHERE region_id=1 AND r.week_id=".$n[0];
$db->runSQL($sql);
while( $row=$db->retrieveRow() )
{
	$xGosPres = $row['SUM(r.weeklyReport_1on1GosPres)'];
	$xSpConv = $row['SUM(r.weeklyReport_1on1SpConv)'];
	$xHSConv = $row['SUM(r.weeklyReport_1on1HsPres)'];
	$xSpConvStd = $row['SUM(r.weeklyReport_1on1SpConvStd)'];
	$xGosPresStd = $row['SUM(r.weeklyReport_1on1GosPresStd)'];
}	
$sql = 'SELECT week_endDate FROM cim_stats_week WHERE week_id='.$n[0];
$db->runSQL($sql);
while( $row=$db->retrieveRow() )
{
	$weekGreater = "'".$row['week_endDate']."'";
}
$sql = 'SELECT week_endDate FROM cim_stats_week WHERE week_id='.($n[0]-1);
$db->runSQL($sql);
while( $row=$db->retrieveRow() )
{
	$weekLower = "'".$row['week_endDate']."'";
}
$sql = "SELECT COUNT(p.prc_id) FROM cim_stats_prc AS p INNER JOIN cim_hrdb_campus AS n ON p.campus_id=n.campus_id WHERE region_id=1 AND prc_date<=".$weekGreater." AND prc_date>".$weekLower;
$db->runSQL($sql);
while( $row=$db->retrieveRow() )
{
	$xPRC = $row['COUNT(p.prc_id)'];
}	


//Week 2
$sql = "SELECT SUM(r.weeklyReport_1on1GosPres), SUM(r.weeklyReport_1on1SpConv),SUM(r.weeklyReport_1on1HsPres), SUM(r.weeklyReport_1on1SpConvStd),SUM(r.weeklyReport_1on1GosPresStd) FROM cim_stats_weeklyreport AS r INNER JOIN cim_stats_week AS w ON r.week_id=w.week_id INNER JOIN cim_hrdb_campus AS n ON r.campus_id=n.campus_id WHERE region_id=1 AND r.week_id=".$n[1];
$db->runSQL($sql);
while( $row=$db->retrieveRow() )
{
	$yGosPres = $row['SUM(r.weeklyReport_1on1GosPres)'];
	$ySpConv = $row['SUM(r.weeklyReport_1on1SpConv)'];
	$yHSConv = $row['SUM(r.weeklyReport_1on1HsPres)'];
	$ySpConvStd = $row['SUM(r.weeklyReport_1on1SpConvStd)'];
	$yGosPresStd = $row['SUM(r.weeklyReport_1on1GosPresStd)'];
}	
$sql = 'SELECT week_endDate FROM cim_stats_week WHERE week_id='.$n[1];
$db->runSQL($sql);
while( $row=$db->retrieveRow() )
{
	$weekGreater = "'".$row['week_endDate']."'";
}
$sql = 'SELECT week_endDate FROM cim_stats_week WHERE week_id='.($n[1]-1);
$db->runSQL($sql);
while( $row=$db->retrieveRow() )
{
	$weekLower = "'".$row['week_endDate']."'";
}
$sql = "SELECT COUNT(p.prc_id) FROM cim_stats_prc AS p INNER JOIN cim_hrdb_campus AS n ON p.campus_id=n.campus_id WHERE region_id=1 AND prc_date<=".$weekGreater." AND prc_date>".$weekLower;
$db->runSQL($sql);
while( $row=$db->retrieveRow() )
{
	$yPRC = $row['COUNT(p.prc_id)'];
}	

//Week 3
$sql = "SELECT SUM(r.weeklyReport_1on1GosPres), SUM(r.weeklyReport_1on1SpConv),SUM(r.weeklyReport_1on1HsPres), SUM(r.weeklyReport_1on1SpConvStd),SUM(r.weeklyReport_1on1GosPresStd) FROM cim_stats_weeklyreport AS r INNER JOIN cim_stats_week AS w ON r.week_id=w.week_id INNER JOIN cim_hrdb_campus AS n ON r.campus_id=n.campus_id WHERE region_id=1 AND r.week_id=".$n[2];
$db->runSQL($sql);
while( $row=$db->retrieveRow() )
{
	$zGosPres = $row['SUM(r.weeklyReport_1on1GosPres)'];
	$zSpConv = $row['SUM(r.weeklyReport_1on1SpConv)'];
	$zHSConv = $row['SUM(r.weeklyReport_1on1HsPres)'];
	$zSpConvStd = $row['SUM(r.weeklyReport_1on1SpConvStd)'];
	$zGosPresStd = $row['SUM(r.weeklyReport_1on1GosPresStd)'];
}	
$sql = 'SELECT week_endDate FROM cim_stats_week WHERE week_id='.$n[2];
$db->runSQL($sql);
while( $row=$db->retrieveRow() )
{
	$weekGreater = "'".$row['week_endDate']."'";
}
$sql = 'SELECT week_endDate FROM cim_stats_week WHERE week_id='.($n[2]-1);
$db->runSQL($sql);
while( $row=$db->retrieveRow() )
{
	$weekLower = "'".$row['week_endDate']."'";
}
$sql = "SELECT COUNT(p.prc_id) FROM cim_stats_prc AS p INNER JOIN cim_hrdb_campus AS n ON p.campus_id=n.campus_id WHERE region_id=1 AND prc_date<=".$weekGreater." AND prc_date>".$weekLower;
$db->runSQL($sql);
while( $row=$db->retrieveRow() )
{
	$zPRC = $row['COUNT(p.prc_id)'];
}	

//Week 4
$sql = "SELECT SUM(r.weeklyReport_1on1GosPres), SUM(r.weeklyReport_1on1SpConv),SUM(r.weeklyReport_1on1HsPres), SUM(r.weeklyReport_1on1SpConvStd),SUM(r.weeklyReport_1on1GosPresStd) FROM cim_stats_weeklyreport AS r INNER JOIN cim_stats_week AS w ON r.week_id=w.week_id INNER JOIN cim_hrdb_campus AS n ON r.campus_id=n.campus_id WHERE region_id=1 AND r.week_id=".$n[3];
$db->runSQL($sql);
while( $row=$db->retrieveRow() )
{
	$zzGosPres = $row['SUM(r.weeklyReport_1on1GosPres)'];
	$zzSpConv = $row['SUM(r.weeklyReport_1on1SpConv)'];
	$zzHSConv = $row['SUM(r.weeklyReport_1on1HsPres)'];
	$zzSpConvStd = $row['SUM(r.weeklyReport_1on1SpConvStd)'];
	$zzGosPresStd = $row['SUM(r.weeklyReport_1on1GosPresStd)'];
}	
$sql = 'SELECT week_endDate FROM cim_stats_week WHERE week_id='.$n[3];
$db->runSQL($sql);
while( $row=$db->retrieveRow() )
{
	$weekGreater = "'".$row['week_endDate']."'";
}
$sql = 'SELECT week_endDate FROM cim_stats_week WHERE week_id='.($n[3]-1);
$db->runSQL($sql);
while( $row=$db->retrieveRow() )
{
	$weekLower = "'".$row['week_endDate']."'";
}
$sql = "SELECT COUNT(p.prc_id) FROM cim_stats_prc AS p INNER JOIN cim_hrdb_campus AS n ON p.campus_id=n.campus_id WHERE region_id=1 AND prc_date<=".$weekGreater." AND prc_date>".$weekLower;
$db->runSQL($sql);
while( $row=$db->retrieveRow() )
{
	$zzPRC = $row['COUNT(p.prc_id)'];
}	

if ( count($n)==5 ){
	//Week 5
	$sql = "SELECT SUM(r.weeklyReport_1on1GosPres), SUM(r.weeklyReport_1on1SpConv),SUM(r.weeklyReport_1on1HsPres), SUM(r.weeklyReport_1on1SpConvStd),SUM(r.weeklyReport_1on1GosPresStd) FROM cim_stats_weeklyreport AS r INNER JOIN cim_stats_week AS w ON r.week_id=w.week_id INNER JOIN cim_hrdb_campus AS n ON r.campus_id=n.campus_id WHERE region_id=1 AND r.week_id=".$n[4];
	$db->runSQL($sql);
	while( $row=$db->retrieveRow() )
	{
		$zzzGosPres = $row['SUM(r.weeklyReport_1on1GosPres)'];
		$zzzSpConv = $row['SUM(r.weeklyReport_1on1SpConv)'];
		$zzzHSConv = $row['SUM(r.weeklyReport_1on1HsPres)'];
		$zzzSpConvStd = $row['SUM(r.weeklyReport_1on1SpConvStd)'];
		$zzzGosPresStd = $row['SUM(r.weeklyReport_1on1GosPresStd)'];
	}	
	$sql = 'SELECT week_endDate FROM cim_stats_week WHERE week_id='.$n[4];
	$db->runSQL($sql);
	while( $row=$db->retrieveRow() )
	{
		$weekGreater = "'".$row['week_endDate']."'";
	}
	$sql = 'SELECT week_endDate FROM cim_stats_week WHERE week_id='.($n[4]-1);
	$db->runSQL($sql);
	while( $row=$db->retrieveRow() )
	{
		$weekLower = "'".$row['week_endDate']."'";
	}
	$sql = "SELECT COUNT(p.prc_id) FROM cim_stats_prc AS p INNER JOIN cim_hrdb_campus AS n ON p.campus_id=n.campus_id WHERE region_id=1 AND prc_date<=".$weekGreater." AND prc_date>".$weekLower;
	$db->runSQL($sql);
	while( $row=$db->retrieveRow() )
	{
		$zzzPRC = $row['COUNT(p.prc_id)'];
	}	

	//Total
	$tGosPres = $xGosPres + $yGosPres + $zGosPres + $zzGosPres + $zzzGosPres; 
	$tSpConv = $xSpConv + $ySpConv + $zSpConv + $zzSpConv + $zzzSpConv; 
	$tHSConv = $xHSConv + $yHSConv + $zHSConv + $zzHSConv + $zzzHSConv; 
	$tSpConvStd = $xSpConvStd + $ySpConvStd + $zSpConvStd + $zzSpConvStd + $zzzSpConvStd; 
	$tGosPresStd = $xGosPresStd + $yGosPresStd + $zGosPresStd + $zzGosPresStd + $zzzGosPresStd;
	$tPRC = $xPRC + $yPRC + $zPRC + $zzPRC + $zzzPRC;
	
	echo "<td style='border: 1px solid #FFFFFF;'></td><td><strong><center>".$m[0]."</center></strong></td><td><strong><center>".$m[1]."</center></strong></td><td><strong><center>".$m[2]."</center></strong></td><td><strong><center>".$m[3]."</center></strong></td><td><strong><center>".$m[4]."</center></strong></td><td><strong><center>Total</center></strong></td></tr>";
	echo "<tr><td>Spiritual Conversations by Staff</td><td><center>".$xSpConv."</center></td><td><center>".$ySpConv."</center></td><td><center>".$zSpConv."</center></td><td><center>".$zzSpConv."</center></td><td><center>".$zzzSpConv."</center></td><td><center>".$tSpConv."</center></td></tr>";
	echo "<tr><td>Spiritual Conversations by Students</td><td><center>".$xSpConvStd."</center></td><td><center>".$ySpConvStd."</center></td><td><center>".$zSpConvStd."</center></td><td><center>".$zzSpConvStd."</center></td><td><center>".$zzzSpConvStd."</center></td><td><center>".$tSpConvStd."</center></td></tr>";
	echo "<tr><td>Gospel Presentations by Staff</td><td><center>".$xGosPres."</center></td><td><center>".$yGosPres."</center></td><td><center>".$zGosPres."</center></td><td><center>".$zzGosPres."</center></td><td><center>".$zzzGosPres."</center></td><td><center>".$tGosPres."</center></td></tr>";
	echo "<tr><td>Gospel Presentations by Students</td><td><center>".$xGosPresStd."</center></td><td><center>".$yGosPresStd."</center></td><td><center>".$zGosPresStd."</center></td><td><center>".$zzGosPresStd."</center></td><td><center>".$zzzGosPresStd."</center></td><td><center>".$tGosPresStd."</center></td></tr>";
	echo "<tr><td>Holy Spirit Presentations by Staff</td><td><center>".$xHSConv."</center></td><td><center>".$yHSConv."</center></td><td><center>".$zHSConv."</center></td><td><center>".$zzHSConv."</center></td><td><center>".$zzzHSConv."</center></td><td><center>".$tHSConv."</center></td></tr>";
	echo "<tr><td></td><td><center></center></td><td><center></center></td><td><center></center></td><td><center></center></td><td><center></center></td></tr>";
	echo "<tr><td>Indicated Decisions</td><td><center>".$xPRC."</center></td><td><center>".$yPRC."</center></td><td><center>".$zPRC."</center></td><td><center>".$zzPRC."</center></td><td><center>".$zzzPRC."</center></td><td><center>".$tPRC."</center></td></tr>";
	echo "</table><br />";
	
}
else{
	//Total
	$tGosPres = $xGosPres + $yGosPres + $zGosPres + $zzGosPres; 
	$tSpConv = $xSpConv + $ySpConv + $zSpConv + $zzSpConv; 
	$tHSConv = $xHSConv + $yHSConv + $zHSConv + $zzHSConv; 
	$tSpConvStd = $xSpConvStd + $ySpConvStd + $zSpConvStd + $zzSpConvStd; 
	$tGosPresStd = $xGosPresStd + $yGosPresStd + $zGosPresStd + $zzGosPresStd;
	$tPRC = $xPRC + $yPRC + $zPRC + $zzPRC;
	
	echo "<td style='border: 1px solid #FFFFFF;'></td><td><strong><center>".$m[0]."</center></strong></td><td><strong><center>".$m[1]."</center></strong></td><td><strong><center>".$m[2]."</center></strong></td><td><strong><center>".$m[3]."</center></strong></td><td><strong><center>Total</center></strong></td></tr>";
	echo "<tr><td>Spiritual Conversations by Staff</td><td><center>".$xSpConv."</center></td><td><center>".$ySpConv."</center></td><td><center>".$zSpConv."</center></td><td><center>".$zzSpConv."</center></td><td><center>".$tSpConv."</center></td></tr>";
	echo "<tr><td>Spiritual Conversations by Students</td><td><center>".$xSpConvStd."</center></td><td><center>".$ySpConvStd."</center></td><td><center>".$zSpConvStd."</center></td><td><center>".$zzSpConvStd."</center></td><td><center>".$tSpConvStd."</center></td></tr>";
	echo "<tr><td>Gospel Presentations by Staff</td><td><center>".$xGosPres."</center></td><td><center>".$yGosPres."</center></td><td><center>".$zGosPres."</center></td><td><center>".$zzGosPres."</center></td><td><center>".$tGosPres."</center></td></tr>";
	echo "<tr><td>Gospel Presentations by Students</td><td><center>".$xGosPresStd."</center></td><td><center>".$yGosPresStd."</center></td><td><center>".$zGosPresStd."</center></td><td><center>".$zzGosPresStd."</center></td><td><center>".$tGosPresStd."</center></td></tr>";
	echo "<tr><td>Holy Spirit Presentations by Staff</td><td><center>".$xHSConv."</center></td><td><center>".$yHSConv."</center></td><td><center>".$zHSConv."</center></td><td><center>".$zzHSConv."</center></td><td><center>".$tHSConv."</center></td></tr>";
	echo "<tr><td></td><td><center></center></td><td><center></center></td><td><center></center></td><td><center></center></td></tr>";
	echo "<tr><td>Indicated Decisions</td><td><center>".$xPRC."</center></td><td><center>".$yPRC."</center></td><td><center>".$zPRC."</center></td><td><center>".$zzPRC."</center></td><td><center>".$tPRC."</center></td></tr>";
	echo "</table><br />";
}

	//West Totals	
echo "<h4>West Stats by Week</h4>";
?>
<table cellpadding='5' cellspacing='0' style="border: 2px #000000 solid;">
<tr>
<?php

//Week 1
$sql = "SELECT SUM(r.weeklyReport_1on1GosPres), SUM(r.weeklyReport_1on1SpConv),SUM(r.weeklyReport_1on1HsPres), SUM(r.weeklyReport_1on1SpConvStd),SUM(r.weeklyReport_1on1GosPresStd) FROM cim_stats_weeklyreport AS r INNER JOIN cim_stats_week AS w ON r.week_id=w.week_id INNER JOIN cim_hrdb_campus AS n ON r.campus_id=n.campus_id WHERE region_id=3 AND r.week_id=".$n[0];
$db->runSQL($sql);
while( $row=$db->retrieveRow() )
{
	$xGosPres = $row['SUM(r.weeklyReport_1on1GosPres)'];
	$xSpConv = $row['SUM(r.weeklyReport_1on1SpConv)'];
	$xHSConv = $row['SUM(r.weeklyReport_1on1HsPres)'];
	$xSpConvStd = $row['SUM(r.weeklyReport_1on1SpConvStd)'];
	$xGosPresStd = $row['SUM(r.weeklyReport_1on1GosPresStd)'];
}	
$sql = 'SELECT week_endDate FROM cim_stats_week WHERE week_id='.$n[0];
$db->runSQL($sql);
while( $row=$db->retrieveRow() )
{
	$weekGreater = "'".$row['week_endDate']."'";
}
$sql = 'SELECT week_endDate FROM cim_stats_week WHERE week_id='.($n[0]-1);
$db->runSQL($sql);
while( $row=$db->retrieveRow() )
{
	$weekLower = "'".$row['week_endDate']."'";
}
$sql = "SELECT COUNT(p.prc_id) FROM cim_stats_prc AS p INNER JOIN cim_hrdb_campus AS n ON p.campus_id=n.campus_id WHERE region_id=3 AND prc_date<=".$weekGreater." AND prc_date>".$weekLower;
$db->runSQL($sql);
while( $row=$db->retrieveRow() )
{
	$xPRC = $row['COUNT(p.prc_id)'];
}	


//Week 2
$sql = "SELECT SUM(r.weeklyReport_1on1GosPres), SUM(r.weeklyReport_1on1SpConv),SUM(r.weeklyReport_1on1HsPres), SUM(r.weeklyReport_1on1SpConvStd),SUM(r.weeklyReport_1on1GosPresStd) FROM cim_stats_weeklyreport AS r INNER JOIN cim_stats_week AS w ON r.week_id=w.week_id INNER JOIN cim_hrdb_campus AS n ON r.campus_id=n.campus_id WHERE region_id=3 AND r.week_id=".$n[1];
$db->runSQL($sql);
while( $row=$db->retrieveRow() )
{
	$yGosPres = $row['SUM(r.weeklyReport_1on1GosPres)'];
	$ySpConv = $row['SUM(r.weeklyReport_1on1SpConv)'];
	$yHSConv = $row['SUM(r.weeklyReport_1on1HsPres)'];
	$ySpConvStd = $row['SUM(r.weeklyReport_1on1SpConvStd)'];
	$yGosPresStd = $row['SUM(r.weeklyReport_1on1GosPresStd)'];
}	
$sql = 'SELECT week_endDate FROM cim_stats_week WHERE week_id='.$n[1];
$db->runSQL($sql);
while( $row=$db->retrieveRow() )
{
	$weekGreater = "'".$row['week_endDate']."'";
}
$sql = 'SELECT week_endDate FROM cim_stats_week WHERE week_id='.($n[1]-1);
$db->runSQL($sql);
while( $row=$db->retrieveRow() )
{
	$weekLower = "'".$row['week_endDate']."'";
}
$sql = "SELECT COUNT(p.prc_id) FROM cim_stats_prc AS p INNER JOIN cim_hrdb_campus AS n ON p.campus_id=n.campus_id WHERE region_id=3 AND prc_date<=".$weekGreater." AND prc_date>".$weekLower;
$db->runSQL($sql);
while( $row=$db->retrieveRow() )
{
	$yPRC = $row['COUNT(p.prc_id)'];
}	

//Week 3
$sql = "SELECT SUM(r.weeklyReport_1on1GosPres), SUM(r.weeklyReport_1on1SpConv),SUM(r.weeklyReport_1on1HsPres), SUM(r.weeklyReport_1on1SpConvStd),SUM(r.weeklyReport_1on1GosPresStd) FROM cim_stats_weeklyreport AS r INNER JOIN cim_stats_week AS w ON r.week_id=w.week_id INNER JOIN cim_hrdb_campus AS n ON r.campus_id=n.campus_id WHERE region_id=3 AND r.week_id=".$n[2];
$db->runSQL($sql);
while( $row=$db->retrieveRow() )
{
	$zGosPres = $row['SUM(r.weeklyReport_1on1GosPres)'];
	$zSpConv = $row['SUM(r.weeklyReport_1on1SpConv)'];
	$zHSConv = $row['SUM(r.weeklyReport_1on1HsPres)'];
	$zSpConvStd = $row['SUM(r.weeklyReport_1on1SpConvStd)'];
	$zGosPresStd = $row['SUM(r.weeklyReport_1on1GosPresStd)'];
}	
$sql = 'SELECT week_endDate FROM cim_stats_week WHERE week_id='.$n[2];
$db->runSQL($sql);
while( $row=$db->retrieveRow() )
{
	$weekGreater = "'".$row['week_endDate']."'";
}
$sql = 'SELECT week_endDate FROM cim_stats_week WHERE week_id='.($n[2]-1);
$db->runSQL($sql);
while( $row=$db->retrieveRow() )
{
	$weekLower = "'".$row['week_endDate']."'";
}
$sql = "SELECT COUNT(p.prc_id) FROM cim_stats_prc AS p INNER JOIN cim_hrdb_campus AS n ON p.campus_id=n.campus_id WHERE region_id=3 AND prc_date<=".$weekGreater." AND prc_date>".$weekLower;
$db->runSQL($sql);
while( $row=$db->retrieveRow() )
{
	$zPRC = $row['COUNT(p.prc_id)'];
}	

//Week 4
$sql = "SELECT SUM(r.weeklyReport_1on1GosPres), SUM(r.weeklyReport_1on1SpConv),SUM(r.weeklyReport_1on1HsPres), SUM(r.weeklyReport_1on1SpConvStd),SUM(r.weeklyReport_1on1GosPresStd) FROM cim_stats_weeklyreport AS r INNER JOIN cim_stats_week AS w ON r.week_id=w.week_id INNER JOIN cim_hrdb_campus AS n ON r.campus_id=n.campus_id WHERE region_id=3 AND r.week_id=".$n[3];
$db->runSQL($sql);
while( $row=$db->retrieveRow() )
{
	$zzGosPres = $row['SUM(r.weeklyReport_1on1GosPres)'];
	$zzSpConv = $row['SUM(r.weeklyReport_1on1SpConv)'];
	$zzHSConv = $row['SUM(r.weeklyReport_1on1HsPres)'];
	$zzSpConvStd = $row['SUM(r.weeklyReport_1on1SpConvStd)'];
	$zzGosPresStd = $row['SUM(r.weeklyReport_1on1GosPresStd)'];
}	
$sql = 'SELECT week_endDate FROM cim_stats_week WHERE week_id='.$n[3];
$db->runSQL($sql);
while( $row=$db->retrieveRow() )
{
	$weekGreater = "'".$row['week_endDate']."'";
}
$sql = 'SELECT week_endDate FROM cim_stats_week WHERE week_id='.($n[3]-1);
$db->runSQL($sql);
while( $row=$db->retrieveRow() )
{
	$weekLower = "'".$row['week_endDate']."'";
}
$sql = "SELECT COUNT(p.prc_id) FROM cim_stats_prc AS p INNER JOIN cim_hrdb_campus AS n ON p.campus_id=n.campus_id WHERE region_id=3 AND prc_date<=".$weekGreater." AND prc_date>".$weekLower;
$db->runSQL($sql);
while( $row=$db->retrieveRow() )
{
	$zzPRC = $row['COUNT(p.prc_id)'];
}	

if ( count($n)==5 ){
	//Week 5
	$sql = "SELECT SUM(r.weeklyReport_1on1GosPres), SUM(r.weeklyReport_1on1SpConv),SUM(r.weeklyReport_1on1HsPres), SUM(r.weeklyReport_1on1SpConvStd),SUM(r.weeklyReport_1on1GosPresStd) FROM cim_stats_weeklyreport AS r INNER JOIN cim_stats_week AS w ON r.week_id=w.week_id INNER JOIN cim_hrdb_campus AS n ON r.campus_id=n.campus_id WHERE region_id=3 AND r.week_id=".$n[4];
	$db->runSQL($sql);
	while( $row=$db->retrieveRow() )
	{
		$zzzGosPres = $row['SUM(r.weeklyReport_1on1GosPres)'];
		$zzzSpConv = $row['SUM(r.weeklyReport_1on1SpConv)'];
		$zzzHSConv = $row['SUM(r.weeklyReport_1on1HsPres)'];
		$zzzSpConvStd = $row['SUM(r.weeklyReport_1on1SpConvStd)'];
		$zzzGosPresStd = $row['SUM(r.weeklyReport_1on1GosPresStd)'];
	}	
	$sql = 'SELECT week_endDate FROM cim_stats_week WHERE week_id='.$n[4];
	$db->runSQL($sql);
	while( $row=$db->retrieveRow() )
	{
		$weekGreater = "'".$row['week_endDate']."'";
	}
	$sql = 'SELECT week_endDate FROM cim_stats_week WHERE week_id='.($n[4]-1);
	$db->runSQL($sql);
	while( $row=$db->retrieveRow() )
	{
		$weekLower = "'".$row['week_endDate']."'";
	}
	$sql = "SELECT COUNT(p.prc_id) FROM cim_stats_prc AS p INNER JOIN cim_hrdb_campus AS n ON p.campus_id=n.campus_id WHERE region_id=3 AND prc_date<=".$weekGreater." AND prc_date>".$weekLower;
	$db->runSQL($sql);
	while( $row=$db->retrieveRow() )
	{
		$zzzPRC = $row['COUNT(p.prc_id)'];
	}	

	//Total
	$tGosPres = $xGosPres + $yGosPres + $zGosPres + $zzGosPres + $zzzGosPres; 
	$tSpConv = $xSpConv + $ySpConv + $zSpConv + $zzSpConv + $zzzSpConv; 
	$tHSConv = $xHSConv + $yHSConv + $zHSConv + $zzHSConv + $zzzHSConv; 
	$tSpConvStd = $xSpConvStd + $ySpConvStd + $zSpConvStd + $zzSpConvStd + $zzzSpConvStd; 
	$tGosPresStd = $xGosPresStd + $yGosPresStd + $zGosPresStd + $zzGosPresStd + $zzzGosPresStd;
	$tPRC = $xPRC + $yPRC + $zPRC + $zzPRC + $zzzPRC;
	
	echo "<td style='border: 1px solid #FFFFFF;'></td><td><strong><center>".$m[0]."</center></strong></td><td><strong><center>".$m[1]."</center></strong></td><td><strong><center>".$m[2]."</center></strong></td><td><strong><center>".$m[3]."</center></strong></td><td><strong><center>".$m[4]."</center></strong></td><td><strong><center>Total</center></strong></td></tr>";
	echo "<tr><td>Spiritual Conversations by Staff</td><td><center>".$xSpConv."</center></td><td><center>".$ySpConv."</center></td><td><center>".$zSpConv."</center></td><td><center>".$zzSpConv."</center></td><td><center>".$zzzSpConv."</center></td><td><center>".$tSpConv."</center></td></tr>";
	echo "<tr><td>Spiritual Conversations by Students</td><td><center>".$xSpConvStd."</center></td><td><center>".$ySpConvStd."</center></td><td><center>".$zSpConvStd."</center></td><td><center>".$zzSpConvStd."</center></td><td><center>".$zzzSpConvStd."</center></td><td><center>".$tSpConvStd."</center></td></tr>";
	echo "<tr><td>Gospel Presentations by Staff</td><td><center>".$xGosPres."</center></td><td><center>".$yGosPres."</center></td><td><center>".$zGosPres."</center></td><td><center>".$zzGosPres."</center></td><td><center>".$zzzGosPres."</center></td><td><center>".$tGosPres."</center></td></tr>";
	echo "<tr><td>Gospel Presentations by Students</td><td><center>".$xGosPresStd."</center></td><td><center>".$yGosPresStd."</center></td><td><center>".$zGosPresStd."</center></td><td><center>".$zzGosPresStd."</center></td><td><center>".$zzzGosPresStd."</center></td><td><center>".$tGosPresStd."</center></td></tr>";
	echo "<tr><td>Holy Spirit Presentations by Staff</td><td><center>".$xHSConv."</center></td><td><center>".$yHSConv."</center></td><td><center>".$zHSConv."</center></td><td><center>".$zzHSConv."</center></td><td><center>".$zzzHSConv."</center></td><td><center>".$tHSConv."</center></td></tr>";
	echo "<tr><td></td><td><center></center></td><td><center></center></td><td><center></center></td><td><center></center></td><td><center></center></td></tr>";
	echo "<tr><td>Indicated Decisions</td><td><center>".$xPRC."</center></td><td><center>".$yPRC."</center></td><td><center>".$zPRC."</center></td><td><center>".$zzPRC."</center></td><td><center>".$zzzPRC."</center></td><td><center>".$tPRC."</center></td></tr>";
	echo "</table><br />";
	
}
else{
	//Total
	$tGosPres = $xGosPres + $yGosPres + $zGosPres + $zzGosPres; 
	$tSpConv = $xSpConv + $ySpConv + $zSpConv + $zzSpConv; 
	$tHSConv = $xHSConv + $yHSConv + $zHSConv + $zzHSConv; 
	$tSpConvStd = $xSpConvStd + $ySpConvStd + $zSpConvStd + $zzSpConvStd; 
	$tGosPresStd = $xGosPresStd + $yGosPresStd + $zGosPresStd + $zzGosPresStd;
	$tPRC = $xPRC + $yPRC + $zPRC + $zzPRC;
	
	echo "<td style='border: 1px solid #FFFFFF;'></td><td><strong><center>".$m[0]."</center></strong></td><td><strong><center>".$m[1]."</center></strong></td><td><strong><center>".$m[2]."</center></strong></td><td><strong><center>".$m[3]."</center></strong></td><td><strong><center>Total</center></strong></td></tr>";
	echo "<tr><td>Spiritual Conversations by Staff</td><td><center>".$xSpConv."</center></td><td><center>".$ySpConv."</center></td><td><center>".$zSpConv."</center></td><td><center>".$zzSpConv."</center></td><td><center>".$tSpConv."</center></td></tr>";
	echo "<tr><td>Spiritual Conversations by Students</td><td><center>".$xSpConvStd."</center></td><td><center>".$ySpConvStd."</center></td><td><center>".$zSpConvStd."</center></td><td><center>".$zzSpConvStd."</center></td><td><center>".$tSpConvStd."</center></td></tr>";
	echo "<tr><td>Gospel Presentations by Staff</td><td><center>".$xGosPres."</center></td><td><center>".$yGosPres."</center></td><td><center>".$zGosPres."</center></td><td><center>".$zzGosPres."</center></td><td><center>".$tGosPres."</center></td></tr>";
	echo "<tr><td>Gospel Presentations by Students</td><td><center>".$xGosPresStd."</center></td><td><center>".$yGosPresStd."</center></td><td><center>".$zGosPresStd."</center></td><td><center>".$zzGosPresStd."</center></td><td><center>".$tGosPresStd."</center></td></tr>";
	echo "<tr><td>Holy Spirit Presentations by Staff</td><td><center>".$xHSConv."</center></td><td><center>".$yHSConv."</center></td><td><center>".$zHSConv."</center></td><td><center>".$zzHSConv."</center></td><td><center>".$tHSConv."</center></td></tr>";
	echo "<tr><td></td><td><center></center></td><td><center></center></td><td><center></center></td><td><center></center></td></tr>";
	echo "<tr><td>Indicated Decisions</td><td><center>".$xPRC."</center></td><td><center>".$yPRC."</center></td><td><center>".$zPRC."</center></td><td><center>".$zzPRC."</center></td><td><center>".$tPRC."</center></td></tr>";
	echo "</table><br />";
}

	//Quebex Totals	
echo "<h4>Quebec Stats by Week</h4>";
?>
<table cellpadding='5' cellspacing='0' style="border: 2px #000000 solid;">
<tr>
<?php

//Week 1
$sql = "SELECT SUM(r.weeklyReport_1on1GosPres), SUM(r.weeklyReport_1on1SpConv),SUM(r.weeklyReport_1on1HsPres), SUM(r.weeklyReport_1on1SpConvStd),SUM(r.weeklyReport_1on1GosPresStd) FROM cim_stats_weeklyreport AS r INNER JOIN cim_stats_week AS w ON r.week_id=w.week_id INNER JOIN cim_hrdb_campus AS n ON r.campus_id=n.campus_id WHERE region_id=2 AND r.week_id=".$n[0];
$db->runSQL($sql);
while( $row=$db->retrieveRow() )
{
	$xGosPres = $row['SUM(r.weeklyReport_1on1GosPres)'];
	$xSpConv = $row['SUM(r.weeklyReport_1on1SpConv)'];
	$xHSConv = $row['SUM(r.weeklyReport_1on1HsPres)'];
	$xSpConvStd = $row['SUM(r.weeklyReport_1on1SpConvStd)'];
	$xGosPresStd = $row['SUM(r.weeklyReport_1on1GosPresStd)'];
}	
$sql = 'SELECT week_endDate FROM cim_stats_week WHERE week_id='.$n[0];
$db->runSQL($sql);
while( $row=$db->retrieveRow() )
{
	$weekGreater = "'".$row['week_endDate']."'";
}
$sql = 'SELECT week_endDate FROM cim_stats_week WHERE week_id='.($n[0]-1);
$db->runSQL($sql);
while( $row=$db->retrieveRow() )
{
	$weekLower = "'".$row['week_endDate']."'";
}
$sql = "SELECT COUNT(p.prc_id) FROM cim_stats_prc AS p INNER JOIN cim_hrdb_campus AS n ON p.campus_id=n.campus_id WHERE region_id=2 AND prc_date<=".$weekGreater." AND prc_date>".$weekLower;
$db->runSQL($sql);
while( $row=$db->retrieveRow() )
{
	$xPRC = $row['COUNT(p.prc_id)'];
}	


//Week 2
$sql = "SELECT SUM(r.weeklyReport_1on1GosPres), SUM(r.weeklyReport_1on1SpConv),SUM(r.weeklyReport_1on1HsPres), SUM(r.weeklyReport_1on1SpConvStd),SUM(r.weeklyReport_1on1GosPresStd) FROM cim_stats_weeklyreport AS r INNER JOIN cim_stats_week AS w ON r.week_id=w.week_id INNER JOIN cim_hrdb_campus AS n ON r.campus_id=n.campus_id WHERE region_id=2 AND r.week_id=".$n[1];
$db->runSQL($sql);
while( $row=$db->retrieveRow() )
{
	$yGosPres = $row['SUM(r.weeklyReport_1on1GosPres)'];
	$ySpConv = $row['SUM(r.weeklyReport_1on1SpConv)'];
	$yHSConv = $row['SUM(r.weeklyReport_1on1HsPres)'];
	$ySpConvStd = $row['SUM(r.weeklyReport_1on1SpConvStd)'];
	$yGosPresStd = $row['SUM(r.weeklyReport_1on1GosPresStd)'];
}	
$sql = 'SELECT week_endDate FROM cim_stats_week WHERE week_id='.$n[1];
$db->runSQL($sql);
while( $row=$db->retrieveRow() )
{
	$weekGreater = "'".$row['week_endDate']."'";
}
$sql = 'SELECT week_endDate FROM cim_stats_week WHERE week_id='.($n[1]-1);
$db->runSQL($sql);
while( $row=$db->retrieveRow() )
{
	$weekLower = "'".$row['week_endDate']."'";
}
$sql = "SELECT COUNT(p.prc_id) FROM cim_stats_prc AS p INNER JOIN cim_hrdb_campus AS n ON p.campus_id=n.campus_id WHERE region_id=2 AND prc_date<=".$weekGreater." AND prc_date>".$weekLower;
$db->runSQL($sql);
while( $row=$db->retrieveRow() )
{
	$yPRC = $row['COUNT(p.prc_id)'];
}	

//Week 3
$sql = "SELECT SUM(r.weeklyReport_1on1GosPres), SUM(r.weeklyReport_1on1SpConv),SUM(r.weeklyReport_1on1HsPres), SUM(r.weeklyReport_1on1SpConvStd),SUM(r.weeklyReport_1on1GosPresStd) FROM cim_stats_weeklyreport AS r INNER JOIN cim_stats_week AS w ON r.week_id=w.week_id INNER JOIN cim_hrdb_campus AS n ON r.campus_id=n.campus_id WHERE region_id=2 AND r.week_id=".$n[2];
$db->runSQL($sql);
while( $row=$db->retrieveRow() )
{
	$zGosPres = $row['SUM(r.weeklyReport_1on1GosPres)'];
	$zSpConv = $row['SUM(r.weeklyReport_1on1SpConv)'];
	$zHSConv = $row['SUM(r.weeklyReport_1on1HsPres)'];
	$zSpConvStd = $row['SUM(r.weeklyReport_1on1SpConvStd)'];
	$zGosPresStd = $row['SUM(r.weeklyReport_1on1GosPresStd)'];
}	
$sql = 'SELECT week_endDate FROM cim_stats_week WHERE week_id='.$n[2];
$db->runSQL($sql);
while( $row=$db->retrieveRow() )
{
	$weekGreater = "'".$row['week_endDate']."'";
}
$sql = 'SELECT week_endDate FROM cim_stats_week WHERE week_id='.($n[2]-1);
$db->runSQL($sql);
while( $row=$db->retrieveRow() )
{
	$weekLower = "'".$row['week_endDate']."'";
}
$sql = "SELECT COUNT(p.prc_id) FROM cim_stats_prc AS p INNER JOIN cim_hrdb_campus AS n ON p.campus_id=n.campus_id WHERE region_id=2 AND prc_date<=".$weekGreater." AND prc_date>".$weekLower;
$db->runSQL($sql);
while( $row=$db->retrieveRow() )
{
	$zPRC = $row['COUNT(p.prc_id)'];
}	

//Week 4
$sql = "SELECT SUM(r.weeklyReport_1on1GosPres), SUM(r.weeklyReport_1on1SpConv),SUM(r.weeklyReport_1on1HsPres), SUM(r.weeklyReport_1on1SpConvStd),SUM(r.weeklyReport_1on1GosPresStd) FROM cim_stats_weeklyreport AS r INNER JOIN cim_stats_week AS w ON r.week_id=w.week_id INNER JOIN cim_hrdb_campus AS n ON r.campus_id=n.campus_id WHERE region_id=2 AND r.week_id=".$n[3];
$db->runSQL($sql);
while( $row=$db->retrieveRow() )
{
	$zzGosPres = $row['SUM(r.weeklyReport_1on1GosPres)'];
	$zzSpConv = $row['SUM(r.weeklyReport_1on1SpConv)'];
	$zzHSConv = $row['SUM(r.weeklyReport_1on1HsPres)'];
	$zzSpConvStd = $row['SUM(r.weeklyReport_1on1SpConvStd)'];
	$zzGosPresStd = $row['SUM(r.weeklyReport_1on1GosPresStd)'];
}	
$sql = 'SELECT week_endDate FROM cim_stats_week WHERE week_id='.$n[3];
$db->runSQL($sql);
while( $row=$db->retrieveRow() )
{
	$weekGreater = "'".$row['week_endDate']."'";
}
$sql = 'SELECT week_endDate FROM cim_stats_week WHERE week_id='.($n[3]-1);
$db->runSQL($sql);
while( $row=$db->retrieveRow() )
{
	$weekLower = "'".$row['week_endDate']."'";
}
$sql = "SELECT COUNT(p.prc_id) FROM cim_stats_prc AS p INNER JOIN cim_hrdb_campus AS n ON p.campus_id=n.campus_id WHERE region_id=2 AND prc_date<=".$weekGreater." AND prc_date>".$weekLower;
$db->runSQL($sql);
while( $row=$db->retrieveRow() )
{
	$zzPRC = $row['COUNT(p.prc_id)'];
}	

if ( count($n)==5 ){
	//Week 5
	$sql = "SELECT SUM(r.weeklyReport_1on1GosPres), SUM(r.weeklyReport_1on1SpConv),SUM(r.weeklyReport_1on1HsPres), SUM(r.weeklyReport_1on1SpConvStd),SUM(r.weeklyReport_1on1GosPresStd) FROM cim_stats_weeklyreport AS r INNER JOIN cim_stats_week AS w ON r.week_id=w.week_id INNER JOIN cim_hrdb_campus AS n ON r.campus_id=n.campus_id WHERE region_id=2 AND r.week_id=".$n[4];
	$db->runSQL($sql);
	while( $row=$db->retrieveRow() )
	{
		$zzzGosPres = $row['SUM(r.weeklyReport_1on1GosPres)'];
		$zzzSpConv = $row['SUM(r.weeklyReport_1on1SpConv)'];
		$zzzHSConv = $row['SUM(r.weeklyReport_1on1HsPres)'];
		$zzzSpConvStd = $row['SUM(r.weeklyReport_1on1SpConvStd)'];
		$zzzGosPresStd = $row['SUM(r.weeklyReport_1on1GosPresStd)'];
	}	
	$sql = 'SELECT week_endDate FROM cim_stats_week WHERE week_id='.$n[4];
	$db->runSQL($sql);
	while( $row=$db->retrieveRow() )
	{
		$weekGreater = "'".$row['week_endDate']."'";
	}
	$sql = 'SELECT week_endDate FROM cim_stats_week WHERE week_id='.($n[4]-1);
	$db->runSQL($sql);
	while( $row=$db->retrieveRow() )
	{
		$weekLower = "'".$row['week_endDate']."'";
	}
	$sql = "SELECT COUNT(p.prc_id) FROM cim_stats_prc AS p INNER JOIN cim_hrdb_campus AS n ON p.campus_id=n.campus_id WHERE region_id=2 AND prc_date<=".$weekGreater." AND prc_date>".$weekLower;
	$db->runSQL($sql);
	while( $row=$db->retrieveRow() )
	{
		$zzzPRC = $row['COUNT(p.prc_id)'];
	}	

	//Total
	$tGosPres = $xGosPres + $yGosPres + $zGosPres + $zzGosPres + $zzzGosPres; 
	$tSpConv = $xSpConv + $ySpConv + $zSpConv + $zzSpConv + $zzzSpConv; 
	$tHSConv = $xHSConv + $yHSConv + $zHSConv + $zzHSConv + $zzzHSConv; 
	$tSpConvStd = $xSpConvStd + $ySpConvStd + $zSpConvStd + $zzSpConvStd + $zzzSpConvStd; 
	$tGosPresStd = $xGosPresStd + $yGosPresStd + $zGosPresStd + $zzGosPresStd + $zzzGosPresStd;
	$tPRC = $xPRC + $yPRC + $zPRC + $zzPRC + $zzzPRC;
	
	echo "<td style='border: 1px solid #FFFFFF;'></td><td><strong><center>".$m[0]."</center></strong></td><td><strong><center>".$m[1]."</center></strong></td><td><strong><center>".$m[2]."</center></strong></td><td><strong><center>".$m[3]."</center></strong></td><td><strong><center>".$m[4]."</center></strong></td><td><strong><center>Total</center></strong></td></tr>";
	echo "<tr><td>Spiritual Conversations by Staff</td><td><center>".$xSpConv."</center></td><td><center>".$ySpConv."</center></td><td><center>".$zSpConv."</center></td><td><center>".$zzSpConv."</center></td><td><center>".$zzzSpConv."</center></td><td><center>".$tSpConv."</center></td></tr>";
	echo "<tr><td>Spiritual Conversations by Students</td><td><center>".$xSpConvStd."</center></td><td><center>".$ySpConvStd."</center></td><td><center>".$zSpConvStd."</center></td><td><center>".$zzSpConvStd."</center></td><td><center>".$zzzSpConvStd."</center></td><td><center>".$tSpConvStd."</center></td></tr>";
	echo "<tr><td>Gospel Presentations by Staff</td><td><center>".$xGosPres."</center></td><td><center>".$yGosPres."</center></td><td><center>".$zGosPres."</center></td><td><center>".$zzGosPres."</center></td><td><center>".$zzzGosPres."</center></td><td><center>".$tGosPres."</center></td></tr>";
	echo "<tr><td>Gospel Presentations by Students</td><td><center>".$xGosPresStd."</center></td><td><center>".$yGosPresStd."</center></td><td><center>".$zGosPresStd."</center></td><td><center>".$zzGosPresStd."</center></td><td><center>".$zzzGosPresStd."</center></td><td><center>".$tGosPresStd."</center></td></tr>";
	echo "<tr><td>Holy Spirit Presentations by Staff</td><td><center>".$xHSConv."</center></td><td><center>".$yHSConv."</center></td><td><center>".$zHSConv."</center></td><td><center>".$zzHSConv."</center></td><td><center>".$zzzHSConv."</center></td><td><center>".$tHSConv."</center></td></tr>";
	echo "<tr><td></td><td><center></center></td><td><center></center></td><td><center></center></td><td><center></center></td><td><center></center></td></tr>";
	echo "<tr><td>Indicated Decisions</td><td><center>".$xPRC."</center></td><td><center>".$yPRC."</center></td><td><center>".$zPRC."</center></td><td><center>".$zzPRC."</center></td><td><center>".$zzzPRC."</center></td><td><center>".$tPRC."</center></td></tr>";
	echo "</table><br />";
	
}
else{
	//Total
	$tGosPres = $xGosPres + $yGosPres + $zGosPres + $zzGosPres; 
	$tSpConv = $xSpConv + $ySpConv + $zSpConv + $zzSpConv; 
	$tHSConv = $xHSConv + $yHSConv + $zHSConv + $zzHSConv; 
	$tSpConvStd = $xSpConvStd + $ySpConvStd + $zSpConvStd + $zzSpConvStd; 
	$tGosPresStd = $xGosPresStd + $yGosPresStd + $zGosPresStd + $zzGosPresStd;
	$tPRC = $xPRC + $yPRC + $zPRC + $zzPRC;
	
	echo "<td style='border: 1px solid #FFFFFF;'></td><td><strong><center>".$m[0]."</center></strong></td><td><strong><center>".$m[1]."</center></strong></td><td><strong><center>".$m[2]."</center></strong></td><td><strong><center>".$m[3]."</center></strong></td><td><strong><center>Total</center></strong></td></tr>";
	echo "<tr><td>Spiritual Conversations by Staff</td><td><center>".$xSpConv."</center></td><td><center>".$ySpConv."</center></td><td><center>".$zSpConv."</center></td><td><center>".$zzSpConv."</center></td><td><center>".$tSpConv."</center></td></tr>";
	echo "<tr><td>Spiritual Conversations by Students</td><td><center>".$xSpConvStd."</center></td><td><center>".$ySpConvStd."</center></td><td><center>".$zSpConvStd."</center></td><td><center>".$zzSpConvStd."</center></td><td><center>".$tSpConvStd."</center></td></tr>";
	echo "<tr><td>Gospel Presentations by Staff</td><td><center>".$xGosPres."</center></td><td><center>".$yGosPres."</center></td><td><center>".$zGosPres."</center></td><td><center>".$zzGosPres."</center></td><td><center>".$tGosPres."</center></td></tr>";
	echo "<tr><td>Gospel Presentations by Students</td><td><center>".$xGosPresStd."</center></td><td><center>".$yGosPresStd."</center></td><td><center>".$zGosPresStd."</center></td><td><center>".$zzGosPresStd."</center></td><td><center>".$tGosPresStd."</center></td></tr>";
	echo "<tr><td>Holy Spirit Presentations by Staff</td><td><center>".$xHSConv."</center></td><td><center>".$yHSConv."</center></td><td><center>".$zHSConv."</center></td><td><center>".$zzHSConv."</center></td><td><center>".$tHSConv."</center></td></tr>";
	echo "<tr><td></td><td><center></center></td><td><center></center></td><td><center></center></td><td><center></center></td></tr>";
	echo "<tr><td>Indicated Decisions</td><td><center>".$xPRC."</center></td><td><center>".$yPRC."</center></td><td><center>".$zPRC."</center></td><td><center>".$zzPRC."</center></td><td><center>".$tPRC."</center></td></tr>";
	echo "</table><br />";
}

	
?>
</font>
</center>