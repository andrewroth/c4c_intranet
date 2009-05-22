<?
/*
 * page_CampusWeeklyStatsReport.php
 *
 * This is a generic template for the page_CampusWeeklyStatsReport.php page.
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
/// ___________________

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

/// ___________________


$grandTotal = 0;

echo '<table border="0">';
foreach( $exposureArray as $key=>$expObj )
{
    echo '<tr><td class="bold" colspan="3">'.$expObj->expDesc.'</td></tr>';
    echo '<td class="text">'.$templateTools->getPageLabel('[Week]').'</td>'.'<td class="text">'.$templateTools->getPageLabel('[Notes]').'</td>'.'<td class="text">'.$templateTools->getPageLabel('[Exposures]').'</td>';
    $thisExpTotal = 0;
    foreach( $expObj->valuesArray as $id=>$dataArray )
    {
        // echo '<pre>'.print_r($dataArray, true).'</pre>';
        $numExp = $dataArray['morestats_exp'];
        echo '<tr><td class="text">'.$dataArray['week_endDate'].'</td>'.'<td class="text">'.$dataArray['morestats_notes'].'</td>'.'<td class="text">'.$numExp.'</td></tr>';
        $thisExpTotal += $numExp;
    } // foreach
    echo '<tr><td class="bold" colspan="2">'.$templateTools->getPageLabel('[Total]').'</td><td class="text">'.$thisExpTotal.'</td></tr>';
    echo '<tr><td colspan="3">&nbsp;</td></tr>';
    $grandTotal += $thisExpTotal;
    
} // exposure types

echo '<tr><td class="text" colspan="2">'.$templateTools->getPageLabel('[Total]').'</td><td class="text">'.$grandTotal.'</td></tr>';

echo "</table>";
?>