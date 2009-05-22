<?
/*
 * page_AccountAccess.php
 *
 * This template displays the Account Access entry display.
 *
 * Required Template Variables:
 *  $pageLabels :   The values of the labels to display on the page.
 *  $formAction :   The action for the submitted form.
 *  $accessCategories :    Array of access categories for the site.
 *  $currentGroups :    Array of access group ID's currently assigned to the 
 *                     account being worked edited.
 *  $buttonText : The label of the button to display
 */

// First load the common Template Tools object
// This object handles the common display of our form items and
// text formmatting tools.
$fileName = 'objects/TemplateTools.php';
$path = Page::findPathExtension( $fileName );
require_once( $path.$fileName);

$templateTools = new TemplateTools();


//Load the Keys for the XML based Form Item Objects
$formItemName = XMLObject_FormItem::XML_ELEMENT_NAME;
$formItemValue = XMLObject_FormItem::XML_ELEMENT_VALUE;
$formItemError = XMLObject_FormItem::XML_ELEMENT_ERROR;


// Initialize the row color
$rowColor = "";
$templateTools->swapBGColor( $rowColor);

$headingColor = '';
$templateTools->setHeadingBGColor( $headingColor );

 
// load the page labels
$templateTools->loadPageLabels( $pageLabels );


?>
<p><span class="heading"><? echo $templateTools->getPageLabel('[Title]'); ?></span></p>
<p><span class="text"><? echo $templateTools->getPageLabel('[Instr]'); ?></span></p>
<hr>
<form name="Form" id="Form" method="post" action="<?=$formAction;?>">
<input name="Process" type="hidden" id="Process" value="T" />
<table width="100%" border="0" cellspacing="2" cellpadding="2" >
<!-- [RAD_FORM_FIELDENTRIES] -->

<?

echo "<tr>\n";
$maxNumColsPerRow = 4;
$colNum = 1;
// foreach Access Category
foreach( $accessCategories as $name=>$groupList ) {

    // if current column > max Columns then reset row
    if ( $colNum > $maxNumColsPerRow ) {
        echo "</tr>\n<tr>";
        $colNum = 1;
    }
    
    echo '<td valign="top" width="';
    $width = 100 / $maxNumColsPerRow;
    echo $width;
    echo '%" >';

    echo '<table width="100%" border="0" cellspacing="0" cellpadding="0">'."\n";
    
    // display the category Name
    echo '<tr '.$headingColor.' ><td colspan="2"  class="bold">'.$name."</td></tr>\n";
    
    $rowColor = '';
    $templateTools->swapBGColor( $rowColor);
    
    // display each Access Group in this Category
    foreach( $groupList as $id=>$group) {
    
        $checked = '';
        if ( array_key_exists( $id, $currentGroups) ) {
        
            $checked = ' checked="checked" ';
        } 
        
        echo '<tr '.$rowColor.' ><td width="10" >';
        echo '<input name="groups[]" type="checkbox"  value="'.$id.'" '.$checked.' />';
        echo '</td><td class="text" align="left" >'.$group."</td></tr>\n";
        
        $templateTools->swapBGColor( $rowColor);
        
    }
    
    
    echo "</table>\n";
    
    echo "</td>\n";
    $colNum ++;
}

?>
</table>
<hr>
<div align="middle"><input name="formSubmit" type="submit" value="<?=$buttonText; ?>" /></div>
</form>
