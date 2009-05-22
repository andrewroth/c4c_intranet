<?php


define( SITE_DB_NAME, "loccim" );
define( SITE_DB_HOST, "localhost" );
define( SITE_DB_PATH, "localhost" );
define( SITE_DB_USER, "root" );
define( SITE_DB_PWD, "" );

require_once("../../objects/SiteObject.php");
require_once("../../objects/Database.php");
require_once("../../objects/DataAccessManager.php");
require_once("../../objects/DataAccessManager/RowManager.php");
require_once("objects_da/ScheduleManager.php");

echo "<h2>Input some data!</h2>";

$db1 = new Database_MySQL();
$db1->connectToDB(SITE_DB_NAME, SITE_DB_HOST, SITE_DB_USER, SITE_DB_PWD);

$db3 = new Database_MySQL();
$db3->connectToDB(SITE_DB_NAME, SITE_DB_HOST, SITE_DB_USER, SITE_DB_PWD);

$db2 = new Database_MySQL();
$db2->connectToDB(SITE_DB_NAME, SITE_DB_HOST, SITE_DB_USER, SITE_DB_PWD);

$sql = "select distinct(person_id) from sch_schedule";
$db3->runSQL( $sql );
while( $row = $db3->retrieveRow() )
{
    $personID = $row['person_id'];
    // echo "personID[".$personID."]<br/>";
    
    // create a entry in cim_sch_schedule for each person
    $sql2 = "INSERT INTO cim_sch_schedule (person_id, timezones_id) VALUES (".$personID.", 1)";
    // echo $sql2."<br/>";
    $db2->runSQL($sql2);
    
    $scheduleID = -1;
    $sql2 = "SELECT * FROM cim_sch_schedule WHERE person_id=".$personID;
    $db2->runSQL( $sql2 );
    if ( $row2 = $db2->retrieveRow() )
    {
        $scheduleID = $row2['schedule_id'];
    }
    else
    {
        echo "Could not find personID[".$personID."]<br/>";
    }
    echo "The scheduleID[".$scheduleID."] for personID[".$personID."]<br/>";
    
    // find all the timeblocks for the peson in sch_schedule
    $sqlTime = "SELECT * FROM sch_schedule where person_id=".$personID;
    $db2->runSQL( $sqlTime );    
    while ( $row2 = $db2->retrieveRow() )
    {
        $scheduleBlock = $row2['schedule_block'];
        // echo $scheduleBlock . " | ";
        
        // create an entry in cim_sch_timeblocks for all the timeblock
        $sqlBlock = "INSERT INTO cim_sch_scheduleblocks (schedule_id, scheduleBlocks_timeblock) VALUES ( ".$scheduleID.",".$scheduleBlock." )";
        $db1->runSQL( $sqlBlock );
    
    }
    echo "Inserted schedule block for personID[".$personID."]<br/>";
    
} // while

// echo "<pre>".print_r($_POST, true)."</pre>";

if ( isset( $_POST['Process'] )  )
{
    echo '<p>Your name will be entered in the draw.</p>';
    echo 'Name: <b>'.$_POST['name'].'</b><br/>';
    echo 'Email: <b>'.$_POST['email'].'</b><br/>';
    
    $db = new Database_MySQL();
    $db->connectToDB(SPT_DB_NAME, SPT_DB_HOST, SPT_DB_USER, SPT_DB_PWD);
    
    $sql = 'INSERT INTO 08_staff_survey (survey_name, survey_email) VALUES ("'.$_POST['name'].'", "'.$_POST['email'].'")';
    $db->runSQL( $sql );
}
else
{
    echo "<p>Thanks for filling out the C4C Staff Survey.  Please enter your name and email to enter the draw for 25,000 Aeroplan miles.  Your name and email are in no way connected to your survey response.</p>";
    echo '<form name="draw" method="post">';
    echo 'Name: <input name="name" type="text" /><br/>';
    echo 'Email: <input name="email" type="text" /><br/>';
    echo '<br/>';
    echo '<input type="submit"/ value="Submit">';
    echo '<input name="Process" type="hidden" id="Process" value="T" />';
    echo '</form>';
}

echo "<p>If you experience technical difficulties, please contact russ.martin@c4c.ca.</p>";

?>
