<?php

require_once("../objects/SiteObject.php");
require_once("../objects/Database.php");

define( SPT_DB_NAME, "ciministry" );
define( SPT_DB_HOST, "dbserver.crusade.org" );
define( SPT_DB_USER, "" );
define( SPT_DB_PWD, "" );

echo "<h2>WC Email</h2>";

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

$sql = "select * from national_signup group by signup_email";
$sptDB->runSQL($sql);
while( $row = $sptDB->retrieveRow() )
{
   $personID = $row['signup_email'];
   $firstName = $row['signup_name'];
   // $userName = $row['viewer_userID'];
   $email = $row['signup_email'];
   // $email = "russ.martin@c4c.ca";
   // $eventID = $row['event_id'];
   /*echo "<tr>";
   echo "<td>".$personID."</td>";
   echo "<td>".$firstName."&nbsp;</td>";
   echo "<td>".$row['person_lname']."&nbsp;</td>";
   echo "<td>".$row['person_email']."&nbsp;</td>";
   echo "<td>".$userName."&nbsp;</td>";
   echo "</tr>";*/
   
   $text = "Dear ".$firstName.",\n\n"; 
   $text .= "Thank you for joining us in prayer last semester!  As we have prayed, we have seen God respond.  We have seen 169 indicated decisions across Canada, plus an additional 130 students come to faith through our Korean campus ministry, Agape Impact (we had not originally included the Agape impact numbers in our goal, but, as they are part of our ministry, we will be including them in our total for this year).\n\n";
   $text .= "We have heard reports from Quebec that there seems to be a greater openness as our staff and students share their faith there, and several Quebecois have come to faith.  Additionally, we have heard of 4 Muslims coming to faith across Canada during this past 4 months.  Praise God!\n\n";
   $text .= "We want to invite you to again join us in our prayer chain during the week of January 7.  Here is the link:  http://prayerchain.campusforchrist.org/. We are praying that we can mobilize 2000 people to join us in prayer, so please invite as many of your friends as possible.\n\n";
   $text .= "Thanks for your partnership!\n\n";
   $text .= "In Christ,\n";
   $text .= "Gregg Hinzelman\n";
   $text .= "Campus for Christ\n\n";
   // echo $text;
     
   $message = wordwrap($text, 70);
   $to = $email;
   $subject = "C4C Prayer Chain";
    
    $headers = 'From: Gregg Hinzelman <gregg.hinzelman@c4c.ca>' . "\r\n" .
'Reply-To: gregg.hinzelman@c4c.ca' . "\r\n" .
'X-Mailer: PHP/' . phpversion();

   if(!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $email) )
   {
      echo "The e-mail [".$email."] was not valid for person_id=[".$personID."]<br/>";
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
         echo 'Successfully sent an email to ['.$email.']<br/>';
      }
   }
}

// echo "</table>";

?>
