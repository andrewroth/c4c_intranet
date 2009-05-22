<?
/*
 * page_StatsReport.tpl.php
 *
 * This is a generic template for the page_StatsReport.php page.
 *
 * Required Template Variables:
 *  $pageLabels :   The values of the labels to display on the page.
 *
 */
 
// First load the common Template Tools object
// This object handles the common display of our form items and
// text formmatting tools.
$fileName = 'objects/TemplateTools.php';
$path = Page::findPathExtension( $fileName );
require_once( $path.$fileName);

$templateTools = new TemplateTools();

// load the page labels
$templateTools->loadPageLabels( $pageLabels );


?>
<p><span class="heading"><? echo $templateTools->getPageLabel('[Title]'); ?></span></p>
<p><span class="text"><? echo $templateTools->getPageLabel('[Instr]'); ?></span></p>

<?	// create a header with '<meas_type> <freq_name> Statistics'
	$prevSet = false;
	if (isset($measName))
	{
		echo '<p><span class="bold">'.$measName;
		$prevSet = true;
	}
	if (isset($freqName))
	{
		if ($prevSet == false)
		{
			echo '<p><span class="bold">';
		}
		else 
		{
			echo ' ';
		}
		echo $freqName.' ';
		$prevSet = true;
	}
	if ($prevSet == true)
	{
		echo 'Statistics Summary</p></span>';
	}		
?>

<?	// create a header with '<ministry> - <division> - <region> - <location>'

	$prevSet = false;
	if (isset($ministryName))
	{
		echo '<p><span class="bold">'.$ministryName;
		$prevSet = true;
	}
	if (isset($divisionName))
	{
		if ($prevSet == false)
		{
			echo '<p><span class="bold">';
		}
		else 
		{
			echo ' - ';
		}
		echo $divisionName;
		$prevSet = true;
	}	
	if (isset($regionName))
	{
		if ($prevSet == false)
		{
			echo '<p><span class="bold">';
		}
		else 
		{
			echo ' - ';
		}
		echo $regionName;
		$prevSet = true;
	}
	if (isset($locationName))
	{
		if ($prevSet == false)
		{
			echo '<p><span class="bold">';
		}
		else 
		{
			echo ' - ';
		}
		echo $locationName;
		$prevSet = true;
	}
	
	if ($prevSet == true)
	{
		echo '</p></span>';
	}
?>
	
<?
		/** NOTE: $fieldsArray is passed as a parameter based on user-selected statistics: $statsArray **/
		
//     $fieldsOfInterest = "weeklyReport_1on1SpConv,weeklyReport_1on1SpConvStd,weeklyReport_1on1GosPres,weeklyReport_1on1GosPresStd,weeklyReport_1on1HsPres,weeklyReport_1on1HsPresStd,weeklyReport_7upCompleted,weeklyReport_7upCompletedStd,weeklyReport_cjVideo,weeklyReport_mda,weeklyReport_otherEVMats,weeklyReport_rlk,weeklyReport_siq,SUBMIT";
//     $fieldsArray = explode(",", $fieldsOfInterest);
 
		/** NOTE: $monthArray is replaced with $parentFreqArray, which may contain years, months, weeks, or days **/

// $monthArray = array( 1=>"January", 2=>"February", 3=>"March", 4=>"April", 5=>"May", 6=>"June", 7=>"July", 8=>"August", 9=>"September", 10=>"October", 11=>"November", 12=>"December");   
?>

<?

// // 1. semester selection jump list
// $itemType = 'jumplist';
// $itemName = 'semester_id';
// $itemValue = $semesterJumpLinkSelectedValue;
// $itemError = 'errorerror';
// $listName = 'list_semester_id';

// echo $templateTools->showByFormType($itemType, $itemName, $itemValue, $itemError, $$listName );


// // 2. campus selection jump list
// $itemType = 'jumplist';
// $itemName = 'campus_id';
// $itemValue = $campusJumpLinkSelectedValue;
// $itemError = 'errorerror';
// $listName = 'list_campus_id';

// echo $templateTools->showByFormType($itemType, $itemName, $itemValue, $itemError, $$listName );

$rangeTotals = array();
foreach( $statsArray as $index=>$statName )
{
    $rangeTotals[ $statName ] = 0;
}

// if ( count($infoArray) > 1 )		// show 'totals' link if more than one staff being reported on
// {
//     echo '<br/><br/><a class="text" href="#totals">'.$templateTools->getPageLabel('[Totals]').'</a>';
// }

// foreach( $infoArray as $indx=>$statReportInfo )
// {
// // START INDIVIDUAL STATS

// echo '<br/><br/>';
// echo '<span class="bold">'.$templateTools->getPageLabel('[StaffName]') . ':</span> <span class="text">'.$statReportInfo->staffName.'</span>';


echo "<table border=\"0\">
    <tr>
        <td>&nbsp;</td>";

        // blank for desc column
        
         if (isset($parentFreqArray))
         {
        
	        // generate text for each parent freq value (i.e. year, month, week, day, etc)
	        foreach( $statReportInfo->calendar as $parentValue=>$arrayOfChildFreqVals )
	        {
// 		        echo 'calendar array <pre>'.print_r($statReportInfo->calendar,true).'</pre>';
// 		        echo 'array of child vals <pre>'.print_r($arrayOfChildFreqVals,true).'</pre>';
// 		        echo 'array of parent freqs <pre>'.print_r($parentFreqArray,true).'</pre>';
		        
	            echo '<td align="center" class="smalltext" colspan="'.count($arrayOfChildFreqVals).'">'.$parentFreqArray[$parentValue].'</td>';	//$parentFreqArray[$parentValue]
	        }
         }
        
        // blank for totals column
        
        echo "
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td>&nbsp;</td>";

        // blank for desc colunm
        // generate text for each freq. value (i.e. week begin/end dates associated with parent freq = months)
        $total_freq_vals = 0;
        foreach( $statReportInfo->calendar as $parentValue=>$arrayOfChildFreqVals )
        {
            foreach( $arrayOfChildFreqVals as $freqValue=>$freqValID )	// was $day=>weekID
            {
                echo '<td class="smalltext">'.$freqValue.'</td>';
                $total_freq_vals++;
            }
        }
        
        // blank for totals,average, etc columns
        if (isset($calcNames))
        {
	         reset($calcNames);
				foreach( array_keys($calcNames) as $key )
				{	        
        			echo '<td class="smalltext" align="right">'.current($calcNames).'</td>';
        			next($calcNames);
     			}
  		  }
    echo '</tr>';
    
    
        foreach( $statsArray as $index=>$statName )
        {
            $total = 0;
            echo '<tr>';
                // fieldName
                $label = $statName;	//$templateTools->getPageLabel('[formLabel_'.$statName.']');
                /*if ( $fieldName == 'SUBMIT' )
                {
                    $label = 'Submitted';
                }*/
                echo '<td class="smalltext" bgcolor="EEEEEE">'.$label.'</td>';
                foreach( $statReportInfo->calendar as $parentValue=>$arrayOfChildFreqVals )	// was $month=>$arrayOfDays
                {
                    foreach( $arrayOfChildFreqVals as $freqValue=>$freqValID )	// was $arrayOfDays as $day=>weekID
                    {
                        $value = 0;
                        if ( $statReportInfo->dataArray[$freqValID] != null )
                        {
                            if ( $statName != 'SUBMIT' )
                            {
	                            // deal with case where some stats have values and some do not
	                            if (isset($statReportInfo->dataArray[$freqValID][$statName]))
	                            {
                                	$value = $statReportInfo->dataArray[$freqValID][$statName];
                             	 }
                             	 else
                             	 {
	                             	 $value = 0;
                             	 } 
                            }
                            else
                            {
                                $value = 'x';
                            }
                        }
                        echo '<td class="smalltext" bgcolor="EEEEEE">'.$value.'</td>';
                        if ( $value === "x" )
                        {
                            $value = 1;
                        }
                        $total += $value;
                    }
                }
                $rangeTotals[$statName] += $total;

                // show those calculations selected by the user
			        if (isset($calcNames))
			        {
				         reset($calcNames);
							foreach( array_keys($calcNames) as $key )
							{	 
								switch(current($calcNames))
								{
									case 'Total':
										echo '<td class="smalltext" bgcolor="EEEEEE" align="right">'.$total.'</td>';
										break;
									case 'Average':
										$average = round($total / $total_freq_vals);
										echo '<td class="smalltext" bgcolor="EEEEEE" align="right">'.$average.'</td>';
										break;
									default:
										break;
								}
			        			next($calcNames);
			     			}
			  		  }                                

                
            
            echo '</tr>';
        }

    
    

echo '</table>';

echo '<br/><br/>';

// END INDIVIDUAL STATS

// } // foreach (infoArray)

//     if ( count($infoArray) > 1 )			// include totals for ALL staff members
//     {  
//         echo '<a name="totals" /><span class="bold">'.$templateTools->getPageLabel('[Totals]').'</span><br/>';
//         echo '<table border="0">';
//         // display summary totals
//         foreach( $fieldsArray as $index=>$fieldName )
//         {
//             echo '<tr><td class="smalltext">'.$templateTools->getPageLabel('[formLabel_'.$fieldName.']').'</td><td class="smalltext">'.$semesterTotals[$fieldName].'</td></tr>';            
//         }
//         echo "</table>";
//     }
?>


    
    