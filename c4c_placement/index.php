<?php

require_once("../objects/SiteObject.php");
require_once("../objects/Database.php");

define( SPT_DB_NAME, "summerprojecttool" );
define( SPT_DB_HOST, "dbserver.crusade.org" );
define( SPT_DB_USER, "" );
define( SPT_DB_PWD, "" );

echo "<h2>Staff Placement Reports Page</h2>";
/*
$sptDB = new Database_MySQL();
$sptDB->connectToDB(SPT_DB_NAME, SPT_DB_HOST, SPT_DB_USER, SPT_DB_PWD);

// find all the people who have filled out the 'Staff Placement Questionnaire'
$sql = "select a.id from applns as a inner join profiles on a.id=profiles.appln_id where a.form_id=21";
$sptDB->runSQL($sql);
$appArray = array();
while( $row = $sptDB->retrieveRow() )
{
   $appArray[] = $row['id'];
}

// IBS Report #1
$questionSet = array(6102=>"First Name",6103=>"Last Name",6104=>"# years on staff",6125=>"# years attended IBS",6100=>"Would like to attend 2008",7454=>"would like to attend 2009",6088=>"Summers attended",6124=>"summers prior to 1990 attended");
generateReport( $appArray, $questionSet, "IBS", "IBS" );

// Spring / Summer 2008 Placement Report #2
$questionSet = array(6102=>"First name", 6103 => "Last name", 6119=>"Summer 2006 placement", 6121=>"Summer 2007 placement", 6139=>"Spring Break 2008 yes/no", 6142=>"Processing Applications rated with #", 6146=>"Coaching Interns rated with #", 6147=>"# of interns to coach", 6126=>"1st choice summer 2008", 8226=>"2nd choice summer 2008", 8227=>"3rd choice summer 2008", 8225=>"IBS in addition to Project", 8486=>"Explanation of Summer 2008 Other", 6151=>"Interest in special projects");
generateReport( $appArray, $questionSet, "Spring / Summer 2008 Placement", "SpringSummer2008Placement" );
 
// 2009 Interest Report #3
$questionSet = array(6102=>"First name", 6103=>"last name", 6162=>"Spring Break 2009 interest", 7454=>"IBS 2009",  6161=>"summer 2009 interest project", 8254=>"Summer 2009 development area interest", 8489=>"Additional Comments re Summer 2009");
generateReport( $appArray, $questionSet, "2009 Interest", "2009Interest" );
 
// Partnership Interest Report #4
$questionSet = array(6102=>"First name", 6103=>"Last name", 6157=>"Partnership feel part of", 8487=>"another partnership IÕd love to be a part of", 8488=>"long term capacity");
generateReport( $appArray, $questionSet, "Partnership Interest", "PartnershipInterest" );
 
// Unique interests Report #5
$questionSet = array(6102=>"First name", 6103=>"Last name", 6142=>"Processing Applications rated with #", 6146=>"Coaching Interns rated with #", 6147=>"# of interns to coach", 6151=>"Interest in special projects" );
generateReport( $appArray, $questionSet, "Unique Interests", "UniqueInterests" );
 
// Placement History Report #6
$questionSet = array(6102=>"First name", 6103=>"last name", 6125=>"# years at IBS", 6119=>"Summer 2006 Placement", 6121=>"Summer 2007 Placement");
generateReport( $appArray, $questionSet, "Placement History", "PlacementHistory" );



// $appArray = array of app_ids
// $questionSet = array of questions_id
// $reportName = textual description of the report
// $filename = filename to output .csv to (don't use space or funny characters)
function generateReport($appArray, $questionSet, $reportName, $filename)
{
   $csvHelper = new CsvHelper();
   
   echo "<h3>".$reportName."</h3>";
   echo '<table border="1">';
   echo '<tr>';
   // display the column headers (question descriptions)
   foreach($questionSet as $qNum=>$qDesc)
   {
      echo "<td>".$qDesc."</td>";
      $csvHelper->addField( $qDesc );
   }
   echo "</tr>";
   $csvHelper->endRow();
   
   $sptDB2 = new Database_MySQL();
   $sptDB2->connectToDB(SPT_DB_NAME, SPT_DB_HOST, SPT_DB_USER, SPT_DB_PWD);
   
   $sptDB3 = new Database_MySQL();
   $sptDB3->connectToDB(SPT_DB_NAME, SPT_DB_HOST, SPT_DB_USER, SPT_DB_PWD);
   
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
		// changed these lines since getting a "Cannot modify header information - headers already sent by" error - RM Jan 31, 2008
		// header("Content-type:application/vnd.ms-excel");
		// header("Content-disposition:attachment;filename=".$this->filename);
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

*/

?>
