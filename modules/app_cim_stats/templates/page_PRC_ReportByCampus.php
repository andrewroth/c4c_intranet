<?
/*
 * page_PRC_ReportByCampus.php
 *
 * This is a generic template for the page_PRC_ReportByCampus.php page.
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

// 1. semester selection jump list
$itemType = 'jumplist';
$itemName = 'semester_id';
$itemValue = $semesterJumpLinkSelectedValue;
$itemError = 'errorerror';
$listName = 'list_semester_id';

echo $templateTools->showByFormType($itemType, $itemName, $itemValue, $itemError, $$listName );

echo '<br/><br/>';

?>

<table border="0" cellpadding="0" cellspacing="0">
    <tr>
        <td class="text"><? echo $templateTools->getPageLabel('[Campus]'); ?></td>
        <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
        <td class="text"><? echo $templateTools->getPageLabel('[Total]'); ?></td>
        <td class="text">&nbsp;&nbsp;&nbsp;<? echo $templateTools->getPageLabel('[View]'); ?></td>
    </tr>
    <?
    foreach($campusPRCArray as $key=>$aCampus )
    {
        $link = '';
        if ( $aCampus['link'] != '#' )
        {
            $link = '<a href="#">View</a>';
        }
        echo '<tr><td class="text">'.$aCampus['desc'].'</td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td><td class="text" align="right">'.$aCampus['totalPRC'].'</td><td class="text">'.$link.'</td></tr>';
    }
    
    ?>
    <tr>
        <td class="text"><b><? echo $templateTools->getPageLabel('[Total]'); ?></b></td>
        <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
        <td class="text" align="right"><b><? echo $pageTotal; ?></b></td>
        <td class="text">&nbsp;</td>
    </tr>
    
</table>

