<?
/*
 * [PageName]
 *
 */
 
// First load the common Template Tools object
// This object handles the common display of our form items and
// text formmatting tools.
$fileName = 'objects/TemplateTools.php';
$path = Page::findPathExtension( $fileName );
require_once( $path.$fileName);

$templateTools = new TemplateTools();


// Initialize the row color
$rowColor = "";
$templateTools->setHeadingBGColor( $rowColor );


// load the page labels
$templateTools->loadPageLabels( $pageLabels )

?>
<p><span class="heading"><? echo $templateTools->getPageLabel('[Title]'); ?></span></p>
<p><span class="text"><? echo $templateTools->getPageLabel('[Instr]'); ?></span></p>
<div align="right" class="text" ><? 

    if (!isset($addLink)) {
        $addLink = '#';
    }
    echo '<a href="'.$addLink.'">'.$templateTools->getPageLabel('[Add]').'</a>'; 
    
?></div>
<hr>
<table width="100%" border="0">
<tr valign="top" <?= $rowColor;?> >

<!--[RAD_FIELDNAME_LABEL] -->
<td class="bold"><? echo $templateTools->getPageLabel('[title_[FieldName]]'); ?></td>

<td class="text">&nbsp;</td>
</tr>
<?
    $entryKey = RowManager_[DAObj]::XML_NODE_NAME;
    /*
     *  For each entry ...
     */
    $numEntries = 0;
    foreach ($dataList->$entryKey as $entry) {
    
        $templateTools->swapBGColor( $rowColor );
        
        // Put any text formatting logic here :
        // 
        // if ( $entry->[FieldName] != 'FULL' ) {
        //     $textStyle = 'error';
        // } else {
        //     $textStyle = 'text';
        // }
        
        $textStyle = 'text';
        
        echo '<tr valign="top" '.$rowColor.' >';
 
/*[RAD_FIELDNAME_DATA]*/       
        echo '<td class="'.$textStyle.'">'.$entry->[FieldName].'</td>';

        if ( !isset($editLink) ) {
            $editLink = '#';
        }
        $currentEditLink = $editLink.$entry->[PrimaryKeyField];
        echo '<td align="right" class="text"><a href="'.$currentEditLink.'">'.$templateTools->getPageLabel('[View]').'</a></td>';

        echo '</tr>';
    
        $numEntries ++;
    }
?> 
</table>
<hr>
<div class="text" align="right"><? 
                    
    
    echo '<a href="'.$continueLink.'">'.$templateTools->getPageLabel('[Continue]').'</a>';
  
?></div>
