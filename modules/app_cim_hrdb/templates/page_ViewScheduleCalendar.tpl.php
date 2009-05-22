<?
/*
 * genDataList.php
 *
 * This template displays a set of data in a grid.
 *
 * Required Template Variables:
 *  $pageLabels :   The values of the labels to display on the page.
 *  $linkValues :   Array of link href values. linkValue[ 'key' ] = 'href';
 *  $linkLabels :   Array of link lables. linkLabels[ 'key' ] = 'Label';
 *  $linkColumns:   Array of columns with links to other pages.
 *                  $columnEntry = $linkColumns[0];
 *                  $columnEntry['title'] = Label to display for the Title
 *                  $columnEntry['label'] = Label to display on the page
 *                  $columnEntry['link' ] = The link to use 
 *                  $columnEntry['field' ] = Name of the field to use for the 
 *                      rest of the link data.
 *  $dataFieldList :    Array of fields processed by this form.
 *  $rowManagerXMLNodeName : The XML Node Name of the data List Entries
 *  $dataList   :   The XML data to display in the list
 *  $primaryKeyFieldName : The primary key field name for the dataList entries
 */
 
// First load the common Template Tools object
// This object handles the common display of our form items and
// text formmatting tools.
$fileName = 'objects/TemplateTools.php';
$path = Page::findPathExtension( $fileName );
require_once( $path.$fileName);
require_once ('objects/Calendar/Month/Weekdays.php');

$templateTools = new TemplateTools();


// Initialize the row color
$rowColor = "";
$templateTools->setHeadingBGColor( $rowColor );


// load the page labels
$templateTools->loadPageLabels( $pageLabels );



// This template displays a Title & Instr field by default.  If you don't 
// want them displayed, then you send ($disableHeading = true) to the 
// template.
// Now check to see if the disableHeading param has been sent
if (!isset( $disableHeading ) ) {

    // if not default it to false
    $disableHeading = false;
}

// if we are to display the heading ...
if (!$disableHeading) {

?>
<p><span class="heading"><? echo $templateTools->getPageLabel('[Title]'); ?></span></p>
<p><span class="text"><? echo $templateTools->getPageLabel('[Instr]'); ?></span></p>
<? 

}// end display heading

//Jump List stuff.
$showjumpList = true;

if ($showjumpList){
   $templateTools->showJumpListByArray( 'month_text', $defaultMonth, $jumpList, false);
   echo '<br><br>';
}//End of jump list code.


    // If an Add Link Exists ... add it here.
    if ( isset($linkValues['add']) ) {
        echo '<div align="right" class="text" ><a href="'.$linkValues['add'].'">'.$linkLabels['add'].'</a></div>';
    }


?>

<?
$Month = new Calendar_Month_Weekdays($year_id, $month_id, $first_weekday);

$Month->build();

echo "<table border='1' cellspacing='0' cellpadding='5' bgcolor='#7799FF'>\n";  #00BFFF    #1E90FF
echo "<tr><td align='left' class='bold' width='14%'>Sun</td>";	// width 
echo "<td align='left' class='bold' width='14%'>Mon</td>";
echo "<td align='left' class='bold' width='14%'>Tues</td>";
echo "<td align='left' class='bold' width='14%'>Wed</td>";
echo "<td align='left' class='bold' width='14%'>Thurs</td>";
echo "<td align='left' class='bold' width='14%'>Fri</td>";
echo "<td align='left' class='bold' width='14%'>Sat</td></tr>";


while ($Day = $Month->fetch()) {
    if ($Day->isFirst()) {
	     echo "<tr><td align='left' colspan='7' border='1'>Week Events:<br><br></td></tr>";
        echo "<tr>\n";
    }

    if ($Day->isEmpty()) {
        echo "<td width='180'>".getCellData()."</td>\n";
    } else {
	    $display_data = '';
	    
// 	    echo '<pre>'.print_r($monthEventDataList,true).'</pre>';
// 	    $data_array = $monthEventDataList[$Day->thisDay()];
// 	    
 	    if (isset($monthEventDataList[$Day->thisDay()])&&(count($monthEventDataList[$Day->thisDay()]) > 0))
 	    {
		    
// 	    $event_color = $colorCodeList[$eventType];

// 		    $tooltip_color = '#7799FF';
// 		    $tooltip = "vacation:<br>Hobbe Smit (905-528-5907)<br>Russ Martin (222-543-5355)<br>Calvin Jien (433-543-5333)";
// 		    $display_data = '<a style="text-decoration: none" class="info smalltext" href="#">VAC<span>'.$tooltip.'</span></a>';
// 		    $display_data .= '&nbsp;<a style="text-decoration: none" class="info smalltext" href="#">OFF<span style="color:'.$tooltip_color.';border-color:'.$tooltip_color.'">'.$tooltip.'</span></a><br>';
// 		    $display_data .= '&nbsp;<a style="text-decoration: none" class="info smalltext" href="#">OFF<span>'.$tooltip.'</span></a>';
//  		    $display_data .= '&nbsp;<a style="text-decoration: none" class="info smalltext" href="#">OFF<span>'.$tooltip.'</span></a>';
//  		    $display_data .= '&nbsp;<a style="text-decoration: none" class="info smalltext" href="#">OFF<span>'.$tooltip.'</span></a><br>';
// 		    $display_data .= '&nbsp;<a style="text-decoration: none" class="info smalltext" href="#">OFF<span>'.$tooltip.'</span></a>';
//  		    $display_data .= '&nbsp;<a style="text-decoration: none" class="info smalltext" href="#">OFF<span>'.$tooltip.'</span></a>';
//  		    $display_data .= '&nbsp;<a style="text-decoration: none" class="info smalltext" href="#">OFF<span>'.$tooltip.'</span></a><br>';
// 		    $display_data .= '&nbsp;<a style="text-decoration: none" class="info smalltext" href="#">MORE EVENTS<span>'.$tooltip.'</span></a>';	
		        		    		    
       	 echo '<td valign="top" width="14%">'.$Day->thisDay().getCellData($monthEventDataList[$Day->thisDay()], $colorCodeList, $Day->thisDay())."</td>\n";
     	 }
     	 else
     	 {
       	 echo '<td valign="top" width="14%">'.$Day->thisDay().getCellData(array(), $colorCodeList)."</td>\n";
     	 }	     	 
    }

    if ($Day->isLast()) {
        echo "</tr>\n";
    }
}

echo "</table>\n";

function getCellData($data_array = array(), $color_codes = array(), $day = 0)
{
	$EVENT_DESC = 0;
	$PERSON_NAME = 1;
	$CONTACT_NUM = 2;
	
	$MIN_ROWS = 4;
// 	$MAX_ROWS = 4;
	$MAX_COLS = 2;
	
	$row_count = 0;	// keep track of displayed cell rows

	$firstline = '<br>';	//'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br>';
	$line = '<br>';
	$cell = '&nbsp;';
	
	if (count($data_array) > 0)
	{
		$event_tag_index = 2;
		
		// Go through all data stored with each event type, i.e. all vacation events
		foreach (array_keys($data_array) as $event_type_abbrev)
		{
			$event_instances = current($data_array);
			
// 			echo 'data_array = <pre>'.print_r($data_array,true).'</pre>';
// 			echo 'event instances = <pre>'.print_r($event_instances,true).'</pre>';
			
			$tooltip_color = $color_codes[$event_type_abbrev];
			$tooltip = '';
			
			// Go through all particular instances of the event type, i.e. Hobbe's vacation and Russ's vacation
			$firstRecord = true;
			reset($event_instances);
			foreach( array_keys($event_instances) as $activity_id)
			{
				$record = current($event_instances);
// 				echo 'record = <pre>'.print_r($record,true).'</pre>';
				if ($firstRecord == true)
				{
					$tooltip .= $record[$EVENT_DESC].':<br>';
					$firstRecord = false;
				}
				$tooltip .=	$record[$PERSON_NAME].' '.$record[$CONTACT_NUM].'<br>';
				
				next($event_instances);
			}
 			$tooltip = substr($tooltip,0,-4);	// remove last '<br>'
			
			$cell .= '&nbsp;<a style="text-decoration: none" class="info smalltext" color="'.$tooltip_color.'" href="#">';
			$cell .= $event_type_abbrev;
 			$cell .= '<span style="color:'.$tooltip_color.';border-color:'.$tooltip_color.'">'.$tooltip.'</span></a>';
						
			if (($event_tag_index % $MAX_COLS == 0))		//($day >= 10) && 
			{
				$cell .= '<br>';		// need to add line after first two entries and then every third entry
				$row_count++;
			}
// 			else if ($event_tag_index == 2)		// only allow 1 entry on first line if double-digit date
// 			{
// 				$cell .= '<br>';
// 			}
				
			next($data_array);
			$event_tag_index++;
			
// 			echo 'tag = '.$event_tag_index;
		}
	}
// 	else {
// 		$cell = $firstline;
// 		for ($i=1; $i < $MIN_ROWS; $i++)
// 		{
// 			$cell .= $line;
// 		}			
// 	}
	
	// Pad the table cell with the required # of lines needed yet
	for ($rows=$row_count; $rows < $MIN_ROWS; $rows++)
	{
		$cell .= $line;
	}		
	
	return $cell;
}	

?>

<div class="text" align="right"><? 
    
    // display Continue Link if provided
    $continueLabel = '';
    if ( isset($linkValues['cont']) ) {
        $continueLabel = '<a href="'.$linkValues['cont'].'">'.$linkLabels['cont'].'</a>';
    }

    echo $continueLabel;
  
?></div>
