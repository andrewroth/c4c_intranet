<?
/*
 * page_RegionalSemesterReport.php
 *
 * This is a generic template for the page_RegionalSemesterReport.php page.
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

    $fieldsArray = explode(",", $fieldsOfInterest);


?>
<p><span class="heading"><? echo $templateTools->getPageLabel('[Title]'); ?></span></p>
<p><span class="text"><? echo $templateTools->getPageLabel('[Instr]'); ?></span></p>

<?

// 1. semester selection jump list
$itemType = 'jumplist';
$itemName = 'semester_id';
$itemValue = $semesterJumpLinkSelectedValue;
$itemError = 'errorerror';
$listName = 'list_semester_id';

echo $templateTools->showByFormType($itemType, $itemName, $itemValue, $itemError, $$listName );

// 1. region selection jump list
$itemType = 'jumplist';
$itemName = 'region_id';
$itemValue = $regionJumpLinkSelectedValue;
$itemError = 'errorerror';
$listName = 'list_region_id';

echo $templateTools->showByFormType($itemType, $itemName, $itemValue, $itemError, $$listName );

echo '<br/><br/>';

echo "<table border=\"1\">";

        // display the header row
        echo generateHeaderRow( $campusInfoArray, $templateTools );
    
        $count = 0;
        foreach( $fieldsArray as $index=>$fieldName )
        {
            $count++;
            $total = 0;
            echo '<tr>';
                // fieldName
                $label = $templateTools->getPageLabel('[formLabel_'.$fieldName.']');

                echo '<td class="smalltext" bgcolor="EEEEEE">'.$label.'</td>';
                
                foreach( $campusInfoArray as $key=>$campusInfoObj )
                {
                    $value = $campusInfoObj->dataArray[$fieldName];
                    
                    echo '<td class="smalltext" bgcolor="EEEEEE">'.$value.'</td>';
                    $total += $value;
                }
                
                // total
                echo '<td class="smalltext" bgcolor="EEEEEE" align="right">'.$total.'</td>';
            
            echo '</tr>';
            
            if ( ($count % 10) == 0 )
            {
                // display another header row for easier reading
                echo generateHeaderRow( $campusInfoArray, $templateTools );
            }
            
            
        } // foreach
        
        foreach( $linksArray as $linkDescKey=>$linkValue )
        {
            echo '<tr>';
            
            echo '<td class="smalltext">'.$templateTools->getPageLabel($linkDescKey).'</td>';
                foreach( $campusInfoArray as $key=>$campusInfoObj )
                {
                    echo '<td class="smalltext"><a href="'.$linkValue.$campusInfoObj->campusID.'">'.$templateTools->getPageLabel("[View]").'</a></td>';
                } // foreach
                
                echo '<td>&nbsp;</td>';
            
            
            
            echo '</tr>';
        }
        
        
        // display another header row for easier reading
        echo generateHeaderRow( $campusInfoArray, $templateTools );

    
    

echo '</table>';

function generateHeaderRow( $campusInfoArray, $templateTools )
{
    
    $headerRow = "
    <tr>
        <td>&nbsp;</td>";

        // blank for desc colunm
        // generate text for each month
        foreach( $campusInfoArray as $key=>$campusInfoObj )
        {
            $headerRow .= '<td class="smalltext">'.$campusInfoObj->shortName.'</td>';   
        }
        
        // blank for totals column
        $headerRow .= '<td class="smalltext" align="right">'.$templateTools->getPageLabel('[Total]').'</td>';
    echo '</tr>';

    return $headerRow;
    
} // generateHeaderRow()
?>

