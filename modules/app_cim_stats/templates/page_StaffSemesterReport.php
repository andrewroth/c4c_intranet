<?
/*
 * page_StaffSemesterReport.php
 *
 * This is a generic template for the page_StaffSemesterReport.php page.
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

<?
    // changed by RM on June 4, 2009
    // no longer interested in "HS Presentations", "Completed Follow-up", "Jesus Videos", "MDA Event Exposures", "Other Evangelistic Materials", "RLKs", "SIQs"
    // $fieldsOfInterest = "weeklyReport_1on1SpConv,weeklyReport_1on1SpConvStd,weeklyReport_1on1GosPres,weeklyReport_1on1GosPresStd,weeklyReport_1on1HsPres,weeklyReport_1on1HsPresStd,weeklyReport_7upCompleted,weeklyReport_7upCompletedStd,weeklyReport_cjVideo,weeklyReport_mda,weeklyReport_otherEVMats,weeklyReport_rlk,weeklyReport_siq,SUBMIT";
    $fieldsOfInterest = "weeklyReport_1on1SpConv,weeklyReport_1on1SpConvStd,weeklyReport_1on1GosPres,weeklyReport_1on1GosPresStd,SUBMIT";
    $fieldsArray = explode(",", $fieldsOfInterest);
 
 $monthArray = array( 1=>"January", 2=>"February", 3=>"March", 4=>"April", 5=>"May", 6=>"June", 7=>"July", 8=>"August", 9=>"September", 10=>"October", 11=>"November", 12=>"December");   
?>

<?

// 1. semester selection jump list
$itemType = 'jumplist';
$itemName = 'semester_id';
$itemValue = $semesterJumpLinkSelectedValue;
$itemError = 'errorerror';
$listName = 'list_semester_id';

echo $templateTools->showByFormType($itemType, $itemName, $itemValue, $itemError, $$listName );


// 2. campus selection jump list
$itemType = 'jumplist';
$itemName = 'campus_id';
$itemValue = $campusJumpLinkSelectedValue;
$itemError = 'errorerror';
$listName = 'list_campus_id';

echo $templateTools->showByFormType($itemType, $itemName, $itemValue, $itemError, $$listName );

$semesterTotals = array();
foreach( $fieldsArray as $index=>$fieldName )
{
    $semesterTotals[ $fieldName ] = 0;
}

if ( count($infoArray) > 1 )
{
    echo '<br/><br/><a class="text" href="#totals">'.$templateTools->getPageLabel('[Totals]').'</a>';
}

foreach( $infoArray as $indx=>$indInfo )
{
// START INDIVIDUAL STATS

echo '<br/><br/>';
echo '<span class="bold">'.$templateTools->getPageLabel('[StaffName]') . ':</span> <span class="text">'.$indInfo->staffName.'</span>';


echo "<table border=\"0\">
    <tr>
        <td>&nbsp;</td>";

        // blank for desc column
        
        // generate text for each month
        foreach( $indInfo->calendar as $month=>$arrayOfDays )
        {
            echo '<td align="center" class="smalltext" colspan="'.count($arrayOfDays).'">'.$monthArray[$month].'</td>';
        }
        
        // blank for totals column
        
        echo "
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td>&nbsp;</td>";

        // blank for desc colunm
        // generate text for each month
        foreach( $indInfo->calendar as $month=>$arrayOfDays )
        {
            foreach( $arrayOfDays as $day=>$weekID )
            {
                echo '<td class="smalltext">'.$day.'</td>';
            }
        }
        
        // blank for totals column
        echo '<td class="smalltext" align="right">Total</td>';
    echo '</tr>';
    
    
        foreach( $fieldsArray as $index=>$fieldName )
        {
            $total = 0;
            echo '<tr>';
                // fieldName
                $label = $templateTools->getPageLabel('[formLabel_'.$fieldName.']');
                /*if ( $fieldName == 'SUBMIT' )
                {
                    $label = 'Submitted';
                }*/
                echo '<td class="smalltext" bgcolor="EEEEEE">'.$label.'</td>';
                foreach( $indInfo->calendar as $month=>$arrayOfDays )
                {
                    foreach( $arrayOfDays as $day=>$weekID )
                    {
                        $value = 0;
                        if ( $indInfo->dataArray[$weekID] != null )
                        {
                            if ( $fieldName != 'SUBMIT' )
                            {
                                $value = $indInfo->dataArray[$weekID][$fieldName];
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
                $semesterTotals[$fieldName] += $total;
                
                // total
                echo '<td class="smalltext" bgcolor="EEEEEE" align="right">'.$total.'</td>';
            
            echo '</tr>';
        }

    
    

echo '</table>';

echo '<br/><br/>';

// END INDIVIDUAL STATS

} // foreach (infoArray)

    if ( count($infoArray) > 1 )
    {  
        echo '<a name="totals" /><span class="bold">'.$templateTools->getPageLabel('[Totals]').'</span><br/>';
        echo '<table border="0">';
        // display summary totals
        foreach( $fieldsArray as $index=>$fieldName )
        {
            echo '<tr><td class="smalltext">'.$templateTools->getPageLabel('[formLabel_'.$fieldName.']').'</td><td class="smalltext">'.$semesterTotals[$fieldName].'</td></tr>';            
        }
        echo "</table>";
    }
?>


    
    
