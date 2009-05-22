<?
/*
 * page_CampusYearSummary.php
 *
 * This is a generic template for the page_CampusYearSummary.php page.
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
// 2. campus selection jump list
$itemType = 'jumplist';
$itemName = 'year_id';
$itemValue = $yearJumpLinkSelectedValue;
$itemError = 'errorerror';
$listName = 'list_year_id';

echo $templateTools->showByFormType($itemType, $itemName, $itemValue, $itemError, $$listName );

// 2. campus selection jump list
$itemType = 'jumplist';
$itemName = 'campus_id';
$itemValue = $campusJumpLinkSelectedValue;
$itemError = 'errorerror';
$listName = 'list_campus_id';

echo $templateTools->showByFormType($itemType, $itemName, $itemValue, $itemError, $$listName );
?>

<br/>
<br/>

<table border="0" cellpadding="5">
    <tr>
        <td valign="top">
            <span class="text"><? echo $templateTools->getPageLabel('[PersonalMin]'); ?></span><br/>
            
            <?                 
                echo createTable( $semesterArray, $templateTools, $personalMinStatsArray, true, $personalMinLink ); 
            
            ?>
            <br/>
        
        </td>
        <td valign="top">
            <span class="text"><? echo $templateTools->getPageLabel('[IndicatedDecisions]'); ?></span><br/>
            
            <? 
                
                echo createTable( $semesterArray, $templateTools, $prcArray, false, $indDecLink ); ?>
            
            <br/>
            <span class="text"><? echo $templateTools->getPageLabel('[CampusMin]'); ?></span><br/>
            
            <? 
                
                echo createTable( $semesterArray, $templateTools, $campusTeamMinArray, false, $campusTeamLink, true, true ); ?>
            <br/>
        </td>
    </tr>
    <tr> 
        <td valign="top">
            <span class="text"><? echo $templateTools->getPageLabel('[SemesterStats]'); ?></span></br>
            
            <? 
                
                echo createTable( $semesterArray, $templateTools, $semesterStatsArray, true, $semStatsLink, false); ?>
            <br/>
        </td>
    </tr>
</table>


<?

function createTable( $semesterArray, $templateTools, $statsArray, $lookupCategoryLabel=true, $drillDownLink="#", $includeTotal=true, $includeColunmTotal=false)
{
    
    $columnTotal = array();
            
    $tableString = "<table>";
    $tableString .= "<tr>";
        $tableString .= "<td class=\"smalltext\">&nbsp;</td>";
        foreach( $semesterArray as $semesterID=>$semDesc )
        {
            $tableString .= "<td align=\"right\" class=\"smalltext\"><a href=".$drillDownLink.$semesterID.">".$semDesc."</a></td>";
            $columnTotal[$semesterID] = 0;
        }
        
        if ( $includeTotal )
        {
            $tableString .= "<td class=\"smalltext\">".$templateTools->getPageLabel("[Total]")."</td>";
        }
    $tableString .= "</tr>";
        
        foreach( $statsArray as $category=>$dataArray )
        {
            $total = 0;
            $tableString .= "<tr>";
                
                // display the category
                $label = $category;
                if ( $lookupCategoryLabel)
                {
                    $label = "[formLabel_".$label."]";
                }
                $tableString .= "<td class=\"smalltext\">".$templateTools->getPageLabel($label)."</td>";
                
                // foreach semester
                foreach( $dataArray as $semesterID=>$value )
                {
                    $tableString .= "<td align=\"right\" class=\"smalltext\">".$value."</td>";
                    $total += $value;
                    $columnTotal[$semesterID] += $value;
                }
                
                // show the row total, if applicable
                if ( $includeTotal )
                {
                    $tableString .= "<td align=\"right\" class=\"smalltext\">".$total."</td>";
                }
                
            $tableString .= "</tr>";      
        }
        
        if ( $includeColunmTotal )
        {
            $tableString .= "<td>&nbsp;</td>"; 
            $grandTotal = 0;
            foreach( $semesterArray as $semesterID=>$semDesc )
            {
                $tableString .= "<td align=\"right\" class=\"smalltext\">".$columnTotal[$semesterID]."</td>"; 
                $grandTotal += $columnTotal[$semesterID];
            } // foreach
                
            $tableString .= "<td align=\"right\" class=\"smalltext\">".$grandTotal."</td>"; 
        }
    
    
    $tableString .= "</table>";
    
    return $tableString;
}

?>