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

//START
echo "<h3>identify if there are instances of the same guid multiple times in the accountadmin_viewer table</h3>";
$sql = "SELECT guid, COUNT( guid ) FROM accountadmin_viewer GROUP BY guid HAVING COUNT( guid ) > 1";
$db->runSQL($sql);
$row=$db->retrieveRow();
$total=$row['COUNT( guid )']; //First row is just the total of all guids...don't display in table
?>
<table cellpadding='5' cellspacing='0' style="border: 2px #000000 solid;">
<tr>
<td><strong>guid</strong></td><td># of Instances</td>
</tr>
<?php
while( $row=$db->retrieveRow() )
{
	echo "<tr><td>".$row['guid']."</td><td><center>".$row['COUNT( guid )']."</center></td></tr>";
}	
echo "</table>";
echo "<br /><br />";
//END

//START
echo "<h3>identify if there are instances of the same person_id multiple times in the cim_hrdb_access table</h3>";
$sql = "SELECT person_id, COUNT( person_id ) FROM cim_hrdb_access GROUP BY person_id HAVING COUNT( person_id ) > 1";
$db->runSQL($sql);
$row=$db->retrieveRow();
$total=$row['COUNT( person_id )']; //First row is just the total of all person_ids...don't display in table
?>
<table cellpadding='5' cellspacing='0' style="border: 2px #000000 solid;">
<tr>
<td><strong>person_id</strong></td><td># of Instances</td>
</tr>
<?php
while( $row=$db->retrieveRow() )
{
	echo "<tr><td>".$row['person_id']."</td><td><center>".$row['COUNT( person_id )']."</center></td></tr>";
}	
echo "</table>";
echo "<br /><br />";
//END

//START
echo "<h3>identify if there are instances of the same viewer_id multiple times in the cim_hrdb_access table</h3>";
$sql = "SELECT viewer_id, COUNT( viewer_id ) FROM cim_hrdb_access GROUP BY viewer_id HAVING COUNT( viewer_id ) > 1";
$db->runSQL($sql);
$row=$db->retrieveRow();
$total=$row['COUNT( viewer_id )']; //First row is just the total of all viwer_ids...don't display in table
?>
<table cellpadding='5' cellspacing='0' style="border: 2px #000000 solid;">
<tr>
<td><strong>viewer_id</strong></td><td># of Instances</td>
</tr>
<?php
while( $row=$db->retrieveRow() )
{
	echo "<tr><td>".$row['viewer_id']."</td><td><center>".$row['COUNT( viewer_id )']."</center></td></tr>";
}	
echo "</table>";
echo "<br /><br />";
//END

//START
echo "<h3>identify if there are instances of the same person_id multiple times in the cim_hrdb_emerg table</h3>";
$sql = "SELECT person_id, COUNT( person_id ) FROM cim_hrdb_emerg GROUP BY person_id HAVING COUNT( person_id ) > 1";
$db->runSQL($sql);
$row=$db->retrieveRow();
$total=$row['COUNT( viewer_id )']; //First row is just the total of all person_ids...don't display in table
?>
<table cellpadding='5' cellspacing='0' style="border: 2px #000000 solid;">
<tr>
<td><strong>person_id</strong></td><td># of Instances</td>
</tr>
<?php
while( $row=$db->retrieveRow() )
{
	echo "<tr><td>".$row['person_id']."</td><td><center>".$row['COUNT( person_id )']."</center></td></tr>";
}	
echo "</table>";
echo "<br /><br />";
//END

//START
echo "<h3>identify if there are instances of the same person_id multiple times in the cim_hrdb_staff table</h3>";
$sql = "SELECT person_id, COUNT( person_id ) FROM cim_hrdb_staff GROUP BY person_id HAVING COUNT( person_id ) > 1";
$db->runSQL($sql);
$row=$db->retrieveRow();
$total=$row['COUNT( viewer_id )']; //First row is just the total of all person_ids...don't display in table
?>
<table cellpadding='5' cellspacing='0' style="border: 2px #000000 solid;">
<tr>
<td><strong>person_id</strong></td><td># of Instances</td>
</tr>
<?php
while( $row=$db->retrieveRow() )
{
	echo "<tr><td>".$row['person_id']."</td><td><center>".$row['COUNT( person_id )']."</center></td></tr>";
}	
echo "</table>";
echo "<br /><br />";
//END

//START
echo "<h3>identify records in the cim_hrdb_emerg table that have birthdays that seem off either pre-1920 or after 1997</h3>";
$sql = "SELECT person_id, emerg_birthdate FROM cim_hrdb_emerg WHERE emerg_birthdate > '1997-01-01' OR emerg_birthdate < '1920-01-01'";
$db->runSQL($sql);
$row=$db->retrieveRow();
$total=$row['COUNT( viewer_id )']; //First row is just the total of all person_ids...don't display in table
?>
<table cellpadding='5' cellspacing='0' style="border: 2px #000000 solid;">
<tr>
<td><strong>person_id</strong></td><td>Birthday</td>
</tr>
<?php
while( $row=$db->retrieveRow() )
{
	echo "<tr><td>".$row['person_id']."</td><td><center>".$row['emerg_birthdate']."</center></td></tr>";
}	
echo "</table>";
echo "<br /><br />";
//END

