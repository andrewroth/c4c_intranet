<?php

require_once("../objects/SiteObject.php");
require_once("../objects/Database.php");

define( SPT_DB_NAME, "ciministry" );
define( SPT_DB_HOST, "dbserver.crusade.org" );
define( SPT_DB_USER, "" );
define( SPT_DB_PWD, "" );

echo "<h2>C4C Alumni Reports Page</h2>";

$sptDB = new Database_MySQL();
$sptDB->connectToDB(SPT_DB_NAME, SPT_DB_HOST, SPT_DB_USER, SPT_DB_PWD);

$sptDB2 = new Database_MySQL();
$sptDB2->connectToDB(SPT_DB_NAME, SPT_DB_HOST, SPT_DB_USER, SPT_DB_PWD);

// get event list
$sql = "select * from cim_reg_event";
$sptDB->runSQL( $sql );
$eventArray = array();
while( $row = $sptDB->retrieveRow() )
{
   $eventArray[ $row['event_id'] ] = $row['event_name'];
}

// get campus list
$sql = "select * from cim_hrdb_campus";
$sptDB->runSQL( $sql );
$campusArray = array();
while( $row = $sptDB->retrieveRow() )
{
   $campusArray[$row['campus_id']] = $row['campus_desc'];
}

// get registration status list
$sql = "select * from cim_reg_status";
$sptDB->runSQL( $sql );
$regStatusArray = array();
while( $row = $sptDB->retrieveRow() )
{
   $regStatusArray[$row['status_id']] = $row['status_desc'];
}

// get assignment description list
$sql = "select * from cim_hrdb_campusassignmentstatus";
$sptDB->runSQL( $sql );
$assignmentStatusArray = array();
while( $row = $sptDB->retrieveRow() )
{
   $assignmentStatusArray[$row['assignmentstatus_id']] = $row['assignmentstatus_desc'];
}

// get year description
$sql = "select * from cim_hrdb_year_in_school";
$sptDB->runSQL( $sql );
$yearArray = array();
while( $row = $sptDB->retrieveRow() )
{
   $yearArray[$row['year_id']] = $row['year_desc'];
}

/*echo '<table border="1">';
   echo "<tr>";
      echo "<td>".'person_id'."</td>";
      echo "<td>".'person_fname'."</td>";
      echo "<td>".'person_lname'."</td>";
      echo "<td>".'person_email'."</td>";
      echo "<td>".'viewer_userID'."</td>";
   echo "</tr>";
*/

$sql = "select * from cim_hrdb_person as p inner join cim_hrdb_access as a on p.person_id=a.person_id inner join accountadmin_viewer as v on v.viewer_id=a.viewer_id order by person_lname";
$sptDB->runSQL($sql);
while( $row = $sptDB->retrieveRow() )
{
   $personID = $row['person_id'];
   $firstName = $row['person_fname'];
   $userName = $row['viewer_userID'];
   $email = $row['person_email'];
   /*echo "<tr>";
   echo "<td>".$personID."</td>";
   echo "<td>".$firstName."&nbsp;</td>";
   echo "<td>".$row['person_lname']."&nbsp;</td>";
   echo "<td>".$row['person_email']."&nbsp;</td>";
   echo "<td>".$userName."&nbsp;</td>";
   echo "</tr>";*/
   
   $text = "Dear ".$firstName.",\n\n";
   $text .= "This is an email from the Campus Internet Ministry team at Power to Change Ministries.  As the new year begins we would like to make sure we have up to date information about you.  By helping keep us up to date, you won't miss important emails about campus events, conferences and projects.  Please take three (3) minutes to help us out, by doing the following.\n\n";
   $text .= "1. Login at https://intranet.campusforchrist.org with your username [".$userName."].  (If you have forgotten your password you can reset it by clicking on the 'Forgot Password?' link and entering this email, [".$email."])\n\n";
   $text .= "2. Once logged in, choose 'Modules -> HRDB' from the top menu.\n\n";
   $text .= "3. Use the links on the right-hand side to update your information.  Remember to hit update after each section.  Please make sure you have correct information under 'Edit My Info', 'Edit My Campus Info' and 'Edit My Year Info'.  (Non-campus people only need to enter information under 'Edit My Info').\n\n";
   $text .= "4. Thanks! You're done.\n\n";
   $text .= "You have received this email because you signed up for a discipleship group, conference or project with Power to Change, Canada.  Power to Change Ministries include Campus for Christ, Leader Impact Group and Athletes in Action.  Our privacy policy can be found at http://powertochange.com/corporate/canada/privacy.\n\n";
   $text .= "If you have further questions, please contact russ.martin@c4c.ca.\n\n";
   $text .= "Thanks for your help,\n\n";
   $text .= "Russ Martin\n";
   $text .= "Campus Internet Ministry\n\n";
   $text .= "P.S. We have included your username in this email to indicate it orginates from intranet.campusforchrist.org.\n";
   // echo $text;
   
   
   $message = wordwrap($text, 70);
   $to = $email;
   $subject = "Power to Change Ministries Information Update";
    
    $headers = 'From: Russ Martin <russ.martin@c4c.ca>' . "\r\n" .
'Reply-To: russ.martin@c4c.ca' . "\r\n" .
'X-Mailer: PHP/' . phpversion();

   if(!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $email) )
   {
      echo "The e-mail [".$email."] was not valid for person_id=[".$personID."].<br/>";
   }
   else
   {
      // try and send an email
      $success = true;
      // $success = mail( $to, $subject, $message, $headers  );
      if ( !$success )
      {
         echo 'Error Sending Mail to ['.$email.']!<br/>';
      }
      else
      {
         echo 'Successfully sent an email to ['.$email.'].<br/>';
      }
   }
}

// echo "</table>";

?>
