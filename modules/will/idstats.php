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
	$method8 = 0; $method9 = 0; $method10 = 0; $method11 = 0; $method12 = 0; $method13 = 0; 
	$sql = 'SELECT p.prcMethod_id, p.prc_7upCompleted FROM cim_stats_prc AS p INNER JOIN cim_stats_prcmethod AS m ON p.prcMethod_id=m.prcMethod_id INNER JOIN cim_stats_semester AS h ON p.semester_id=h.semester_id WHERE h.year_id='.$yearID;
	$db->runSQL($sql);
	while( $row=$db->retrieveRow() )
	{
		if ( intval($row['p.prcMethod_id']) == 1 ) {
			$method1 += 1;
		} else {
			$method1 += 1;
		}
	}	
	echo "Hello ".$method1;
}
?>