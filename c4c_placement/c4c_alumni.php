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

echo '<table border="1" cellpadding="5">';

$sql = "select p.person_id,person_fname,person_lname,person_email,year_id from cim_hrdb_person as p left join cim_hrdb_person_year on p.person_id=cim_hrdb_person_year.person_id order by person_lname";
$sptDB->runSQL($sql);
while( $row = $sptDB->retrieveRow() )
{
   $personID = $row['person_id'];
   $yearInSchool = $yearArray[$row['year_id']];
   if ( $yearInSchool == '' )
   {
      $yearInSchool = "not specified";
   }
   echo "<tr>";
   echo "<td>";
   
   echo "<b>Family Name:</b> ". $row['person_lname']."&nbsp;&nbsp;&nbsp;&nbsp; <b>First Name:</b> " .$row['person_fname']." &nbsp;&nbsp;&nbsp;&nbsp;<b>Person ID:</b> ".$personID." <br/>";
   echo "<b>Year in School:</b>".$yearArray[$row['year_id']]."&nbsp;&nbsp;&nbsp;&nbsp; <b>Email:</b> ".$row['person_email']."<br/><br/>";

   // get campus assignment information
   echo "<b>Campus Assignments:</b><br/>";
   $sql2 = "select * from cim_hrdb_assignment where person_id=".$personID;
   $sptDB2->runSQL( $sql2 );
   while ( $row2 = $sptDB2->retrieveRow() )
   {
      echo $assignmentStatusArray[$row2['assignmentstatus_id']];
      echo " at ";
      echo $campusArray[$row2['campus_id']];
      echo "<br/>";
   }
   echo "<br/>";
    
   // get event registrations
   echo "<b>Event Registrations:</b><br/>";
   $sql2 = "select * from cim_reg_registration where person_id=".$personID;
   $sptDB2->runSQL( $sql2 );
   while ( $row2 = $sptDB2->retrieveRow() )
   {
      echo $regStatusArray[$row2['registration_status']];
      echo " at ";
      echo $eventArray[$row2['event_id']];
      echo "<br/>";
   }
   echo "<br/>"; 
   
   // TODO - get project registrations
        
   echo "</td>";   
   echo "</tr>";
}
echo "</table>";

// find all the people who have filled out the 'Staff Placement Questionnaire'
/*$sql = "select a.id from applns as a inner join profiles on a.id=profiles.appln_id where a.form_id=86";
$sptDB->runSQL($sql);
$appArray = array();
while( $row = $sptDB->retrieveRow() )
{
   $appArray[] = $row['id'];
}

// EXAMPLE 
// $questionSet = array(6102=>"First Name",6103=>"Last Name",6104=>"# years on staff",6125=>"# years attended IBS",6100=>"Would like to attend 2008",7454=>"would like to attend 2009",6088=>"Summers attended",6124=>"summers prior to 1990 attended");


// Contact / Emergency Information
$questionSet = array( 10601=>"10601", 11042=>"11042", 10603=>"10603", 10617=>"10617", 10618=>"10618", 10619=>"10619", 10690=>"10690", 10691=>"10691", 10692=>"10692", 10693=>"10693", 10694=>"10694", 10712=>"10712", 10713=>"10713", 10715=>"10715");
generateReport( $appArray, $questionSet, "Contact / Emergency Information", "ContactEmergencyInformation" );

// Travel Information
$questionSet = array( 10601=>"10601", 11042=>"11042", 10603=>"10603", 10994=>"10994", 10930=>"10930", 10992=>"10992", 10931=>"10931", 10934=>"10934", 10935=>"10935", 10995=>"10995", 11040=>"11040", 11041=>"11041", 10945=>"10945", 10946=>"10946", 10947=>"10947", 11043=>"11043", 11044=>"11044", 10936=>"10936", 10969=>"10969", 10970=>"10970", 10971=>"10971", 10972=>"10972", 10973=>"10973", 10974=>"10974");
generateReport( $appArray, $questionSet, "Travel Information", "TravelInformation" );
 
// Summit Details
$questionSet = array( 10601=>"10601", 11042=>"11042", 10603=>"10603", 11036=>"11036", 11037=>"11037", 10993=>"10993", 11032=>"11032", 11034=>"11034", 10952=>"10952", 10957=>"10957", 11046=>"11046", 11045=>"11045", 10961=>"10961", 10966=>"10966", 10967=>"10967", 10976=>"10976" );
generateReport( $appArray, $questionSet, "Summit Details", "SummitDetails" );
 
// Golden Boot Award
$questionSet = array( 10601=>"10601", 11042=>"11042", 10603=>"10603", 10975=>"10975", 11066=>"11066", 11067=>"11067", 11070=>"11070", 11069=>"11069", 11068=>"11068" );
generateReport( $appArray, $questionSet, "Golden Boot Award", "GoldenBootAward" );
*/

// $appArray = array of app_ids
// $questionSet = array of questions_id
// $reportName = textual description of the report
// $filename = filename to output .csv to (don't use space or funny characters)
function generateReport($appArray, $questionSet, $reportName, $filename)
{
   $sptDB2 = new Database_MySQL();
   $sptDB2->connectToDB(SPT_DB_NAME, SPT_DB_HOST, SPT_DB_USER, SPT_DB_PWD);
   
   $sptDB3 = new Database_MySQL();
   $sptDB3->connectToDB(SPT_DB_NAME, SPT_DB_HOST, SPT_DB_USER, SPT_DB_PWD);
   
   $csvHelper = new CsvHelper();
   
   echo "<h3>".$reportName."</h3>";
   echo '<table border="1">';
   echo '<tr>';
   // display the column headers (question descriptions)
   foreach($questionSet as $qNum=>$qDesc)
   {
      // get the question text from the database
      $desc = "";
      $sql2 = "select * from form_elements where id=".$qNum;
      $sptDB2->runSQL( $sql2 );
      if ( $aRow = $sptDB2->retrieveRow() )
      {
         $desc = $aRow["text"];
      }
      if ( $desc == "" )
      {
         $desc = $qDesc;
      }
      
      // echo "<td>".$qDesc."</td>";
      echo "<td>".$desc."</td>";
      // $csvHelper->addField( $qDesc );
      $csvHelper->addField( $desc );
   }
   echo "</tr>";
   $csvHelper->endRow();
   
   // go through all the people who have submitted this form
   foreach ($appArray as $key=>$app_id )
   {
      // find all the answers to the questions for this applicant
      echo "<tr>";
      foreach($questionSet as $qNum=>$qDesc)
      {
      
         // first need to check if qNum has children elements (ex. checkboxfield)
         $sql3 = "select * from form_elements where parent_id=".$qNum;
         $sptDB3->runSQL( $sql3 );
         $childrenArray = array();
         while ( $row3 = $sptDB3->retrieveRow() )
         {
            $childrenArray[ $row3["id"] ] = $row3["text"];
         }
      
         $answer = "";
         if ( count( $childrenArray ) > 0 )
         {
            // loop through all the elements to see if they were set
            foreach( $childrenArray as $elementID=>$text )
            {
               $sql2 = "select * from form_answers where question_id=".$elementID." and instance_id=".$app_id;
               $sptDB2->runSQL( $sql2 );
               if ( $row2 = $sptDB2->retrieveRow() )
               {
                  // if the element is set print the text associated with the answer
                  if ( $row2["answer"] != 0 )
                  {
                     $answer .= $text . " | ";
                  }
               }
            }
         }
         else
         {
            // just a regular element
            
            $sql2 = "select * from form_answers where question_id=".$qNum . " and instance_id=".$app_id;
            $sptDB2->runSQL($sql2);
            
            if ( $row2 = $sptDB2->retrieveRow() )
            {
               $answer = $row2["answer"];
            } // if
         } // if
         
         if ( $answer == "" )
         {
             $answer = "&nbsp;";
         } // if
         echo "<td>".$answer."</td>";
         
         $csvAnswer = $answer;
         if ( $csvAnswer == "&nbsp;" )
         {
            $csvAnswer = " ";
         }
         $csvHelper->addField( $csvAnswer );
         
      } // foreach
      echo "</tr>";
      $csvHelper->endRow();
   }
   
   echo '</table>';
   
   // make a unique file name with the system time
   
   $filename .= time() . ".csv";
   $csvOutput = $csvHelper->render($filename); 
   
   // In our example we're opening $filename in append mode.
   // The file pointer is at the bottom of the file hence 
   // that's where $somecontent will go when we fwrite() it.
   if ( !$handle = fopen( $filename, 'x+') ) 
   {
      echo "Cannot open file ($filename)";
      exit;
   }
   
   // Write $somecontent to our opened file.
   if (fwrite($handle, $csvOutput) === FALSE) {
      echo "Cannot write to file ($filename)";
      exit;
   }

// echo "Success, wrote ($somecontent) to file ($filename)";
echo "<br/><a href=\"".$filename."\">".$filename."</a><br/>";

fclose($handle);
   
}


// http://bakery.cakephp.org/articles/view/csv-helper-php5 
// class CsvHelper extends AppHelper {
	
class CsvHelper {

	var $delimiter = ',';
	var $enclosure = '"';
	var $filename = 'Export.csv';
	var $line = array();
	var $buffer;
	
	function CsvHelper() {
		$this->clear();
	}
	
	function clear() {
		$this->line = array();
		$this->buffer = fopen('php://temp/maxmemory:'. (5*1024*1024), 'r+');
	}
	
	function addField($value) {
		$this->line[] = $value;
	}
	
	function endRow() {
		$this->addRow($this->line);
		$this->line = array();
	}
	
	function addRow($row) {
		fputcsv($this->buffer, $row, $this->delimiter, $this->enclosure);
	}
	
	function renderHeaders() {
		header("Content-type:application/vnd.ms-excel");
		header("Content-disposition:attachment;filename=".$this->filename);
	}
	
	function setFilename($filename) {
		$this->filename = $filename;
		if (strtolower(substr($this->filename, -4)) != '.csv') {
			$this->filename .= '.csv';
		}
	}
	
	function render($outputHeaders = true, $to_encoding = null, $from_encoding = "auto") {
		if ($outputHeaders) {
			if (is_string($outputHeaders)) {
				$this->setFilename($outputHeaders);
			}
			$this->renderHeaders();
		}
		rewind($this->buffer);
		$output = stream_get_contents($this->buffer);
		if ($to_encoding) {
			$output = mb_convert_encoding($output, $to_encoding, $from_encoding);
		}
		return $output;
		// changed this line, since we don't have access to the (supposed) inherited AppHelper class
		// return $this->output($output);
	}
}

?>
