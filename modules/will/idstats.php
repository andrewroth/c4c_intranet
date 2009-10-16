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
$sql = 'SELECT year_id FROM cim_stats_month WHERE month_desc='.$curMonth;
$db->runSQL($sql);
while( $row=$db->retrieveRow() )
{
	$yearID = $row['year_id'];
}	

?>
<font face="sans-serif">
<h3>Indicated Decisions Stats</h3>
<form method="post">
Ministry Year: <select name="year"><br />
<option value="#">Select Year</option>
<?php
		$sql = 'SELECT year_id, year_desc FROM cim_stats_year';
			$db->runSQL($sql);
			while( $row=$db->retrieveRow() )
			{
				if ( intval($row['year_id']) > intval($yearID) ) {
					//Don't show it
				} else {
					echo '<option value="'.$row["year_id"].'">'.$row["year_desc"].'</option>';
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
	$yearID = $_POST['year'];
	
	$sql = 'SELECT c.year_desc FROM cim_stats_year AS c WHERE c.year_id='.$yearID;
	$db->runSQL($sql);
	while( $row=$db->retrieveRow() ){
		$year = $row['year_desc'];
	}	
	
	$method1 = 0; $method2 = 0; $method3 = 0; $method4 = 0; $method5 = 0; $method6 = 0; $method7 = 0; 
	$method8 = 0; $method9 = 0; $method10 = 0; $method11 = 0; $method12 = 0; $method13 = 0; $total = 0;
	$complete1 = 0; $complete2 = 0; $complete3 = 0; $complete4 = 0; $complete5 = 0; $complete6 = 0; $complete7 = 0; 
	$complete8 = 0; $complete9 = 0; $complete10 = 0; $complete11 = 0; $complete12 = 0; $complete13 = 0;
 	$sql = 'SELECT p.prcMethod_id, p.prc_7upCompleted FROM cim_stats_prc AS p INNER JOIN cim_stats_prcmethod AS m ON p.prcMethod_id=m.prcMethod_id INNER JOIN cim_stats_semester AS h ON p.semester_id=h.semester_id WHERE h.year_id='.$yearID;
	$db->runSQL($sql);
 	while( $row=$db->retrieveRow() )
	{
 		switch( intval($row['prcMethod_id']) ) 
		{
			case 1:
				$method1 += 1;
				if ( intval($row['prc_7upCompleted']) == 1 ) {
					$complete1 += 1;
					}
				break;
			case 2:
				$method2 += 1;
				if ( intval($row['prc_7upCompleted']) == 1 ) {
					$complete2 += 1;
					}
				break;
			case 3:
				$method3 += 1;
				if ( intval($row['prc_7upCompleted']) == 1 ) {
					$complete3 += 1;
					}
				break;
			case 4:
				$method4 += 1;
				if ( intval($row['prc_7upCompleted']) == 1 ) {
					$complete4 += 1;
					}
				break;
			case 5:
				$method5 += 1;
				if ( intval($row['prc_7upCompleted']) == 1 ) {
					$complete5 += 1;
					}
				break;
			case 6:
				$method6 += 1;
				if ( intval($row['prc_7upCompleted']) == 1 ) {
					$complete6 += 1;
					}
				break;
			case 7: 	
				$method7 += 1; 
				if ( intval($row['prc_7upCompleted']) == 1 ) {
					$complete7 += 1;
					}
				break;
			case 8:
				$method8 += 1;
				if ( intval($row['prc_7upCompleted']) == 1 ) {
					$complete8 += 1;
					}
				break;
			case 9:
				$method9 += 1;
				if ( intval($row['prc_7upCompleted']) == 1 ) {
					$complete9 += 1;
					}
				break;
			case 10: 
				$method10 += 1;
				if ( intval($row['prc_7upCompleted']) == 1 ) {
					$complete10 += 1;
					}
				break;
			case 11:
				$method11 += 1;
				if ( intval($row['prc_7upCompleted']) == 1 ) {
					$complete11 += 1;
					}
				break;
			case 12:
				$method12 += 1;
				if ( intval($row['prc_7upCompleted']) == 1 ) {
					$complete12 += 1;
					}
				break;
			case 13:
				$method13 += 1;
				if ( intval($row['prc_7upCompleted']) == 1 ) {
					$complete13 += 1;
					}
				break;
		}
		$total += 1;
			
	}	  
	
echo "<h4>How People Came to Christ in ".$year."</h4>";
?>
<table cellpadding='5' cellspacing='0' style="border: 2px #000000 solid;">
<tr>
<td style='border: 1px solid #FFFFFF;'><strong><center>Method</center></strong></td><td><strong><center>Number</center></strong></td><td><strong><center>Percent</center></strong></td><td><strong><center>Completed Follow-up</center></strong></td><td><strong><center>% Completed Follow-up</center></strong></td>
</tr>
<?php
echo "<tr><td>Random Evangelism</td><td><center>".$method1."</center></td><td><center>".intval(($method1/$total)*100)."%</center></td><td><center>".$complete1."</center></td><td><center>".intval(($complete1/$method1)*100)."%</center></td></tr>";
echo "<tr><td>Friendship Evangelism</td><td><center>".$method4."</center></td><td><center>".intval(($method4/$total)*100)."%</center></td><td><center>".$complete4."</center></td><td><center>".intval(($complete4/$method4)*100)."%</center></td></tr>";
echo "<tr><td>SIQ Follow-up</td><td><center>".$method10."</center></td><td><center>".intval(($method10/$total)*100)."%</center></td><td><center>".$complete10."</center></td><td><center>".intval(($complete10/$method10)*100)."%</center></td></tr>";
echo "<tr><td>Campus Wide Event</td><td><center>".$method2."</center></td><td><center>".intval(($method2/$total)*100)."%</center></td><td><center>".$complete2."</center></td><td><center>".intval(($complete2/$method2)*100)."%</center></td></tr>";
echo "<tr><td>Other</td><td><center>".$method12."</center></td><td><center>".intval(($method12/$total)*100)."%</center></td><td><center>".$complete12."</center></td><td><center>".intval(($complete12/$method12)*100)."%</center></td></tr>";
echo "<tr><td>Real Life Kit</td><td><center>".$method13."</center></td><td><center>".intval(($method13/$total)*100)."%</center></td><td><center>".$complete1."</center></td><td><center>".intval(($complete1/$method1)*100)."%</center></td></tr>";
echo "<tr><td>Investigative Bible Study</td><td><center>".$method5."</center></td><td><center>".intval(($method5/$total)*100)."%</center></td><td><center>".$complete5."</center></td><td><center>".intval(($complete5/$method5)*100)."%</center></td></tr>";
echo "<tr><td>Weekly Meeting Follow-up</td><td><center>".$method8."</center></td><td><center>".intval(($method8/$total)*100)."%</center></td><td><center>".$complete8."</center></td><td><center>".intval(($complete8/$method8)*100)."%</center></td></tr>";
echo "<tr><td>MDA Outreach</td><td><center>".$method3."</center></td><td><center>".intval(($method3/$total)*100)."%</center></td><td><center>".$complete3."</center></td><td><center>".intval(($complete3/$method3)*100)."%</center></td></tr>";
echo "<tr><td>Internet Contact</td><td><center>".$method11."</center></td><td><center>".intval(($method11/$total)*100)."%</center></td><td><center>".$complete11."</center></td><td><center>".intval(($complete11/$method11)*100)."%</center></td></tr>";
if ( $method7 > 0) {
	echo "<tr><td>Jesus Video</td><td><center>".$method7."</center></td><td><center>".intval(($method7/$total)*100)."%</center></td><td><center>".$complete7."</center></td><td><center>".intval(($complete7/$method7)*100)."%</center></td></tr>";
}
if ( $method9 > 0 ){
	echo "<tr><td>Leadership Luncheon</td><td><center>".$method9."</center></td><td><center>".intval(($method9/$total)*100)."%</center></td><td><center>".$complete9."</center></td><td><center>".intval(($complete9/$method9)*100)."%</center></td></tr>";
}  
echo "</table><br />";

}

?>