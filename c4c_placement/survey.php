<?php

require_once("../objects/SiteObject.php");
require_once("../objects/Database.php");

define( SPT_DB_NAME, "ciministry" );
define( SPT_DB_HOST, "dbserver.powertochange.local" );
define( SPT_DB_USER, "" );
define( SPT_DB_PWD, "" );

/*define( SPT_DB_NAME, "site" );
define( SPT_DB_HOST, "localhost" );
define( SPT_DB_USER, "xxxxx" );
define( SPT_DB_PWD, "xxxxxx" );*/

echo "<h2>Campus for Christ Staff Survey</h2>";

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
