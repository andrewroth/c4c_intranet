<?
$fileName = 'objects/TemplateTools.php';
$path = Page::findPathExtension( $fileName );
require_once( $path.$fileName);

$templateTools = new TemplateTools();

/*
 * Load XMLObject_FormItem keys
 */
$formItemName = XMLObject_FormItem::XML_ELEMENT_NAME;
$formItemValue = XMLObject_FormItem::XML_ELEMENT_VALUE;
$formItemError = XMLObject_FormItem::XML_ELEMENT_ERROR;

$rowColor = "";
$templateTools->swapBGColor( $rowColor );
 
$templateTools->loadPageLabels( $pageLabels );

$textStyle = 'text';

?>
<p><span class="heading"><? echo $templateTools->getPageLabel('[Title]'); ?></span></p>
<p><span class="text"><? echo $templateTools->getPageLabel('[Instr]'); ?></span></p>
<hr>
<form name="Form" id="Form" method="post" action="<?=$formAction;?>">
<input name="Process" type="hidden" id="Process" value="T" />
<table width="100%" border="0">
<!-- [RAD_FORM_FIELDENTRIES] -->
<tr valign="top" <?=$rowColor;?> >
    <td class="text"><? 
        $templateTools->swapBGColor( $rowColor);
        echo $templateTools->getPageLabel('[formLabel_[FieldName]]'); 
    ?></td>
    <td><? 
        $templateTools->showTextBox( $[FieldName]->$formItemName, $[FieldName]->$formItemValue, $[FieldName]->$formItemError);
    ?></td>
</tr>
<?
//[RAD_FORM_ENTRY]    
/*
    echo '<td valign="top" class="'.$textStyle.'">';
    $templateTools->showTextBox(  $statevar_name->$formItemName, $statevar_name->$formItemValue, $statevar_name->$formItemError);
    echo "</td>\n";
    
    echo '<td valign="top" class="'.$textStyle.'">';
    $templateTools->showTextBox(  $statevar_desc->$formItemName, $statevar_desc->$formItemValue, $statevar_desc->$formItemError);
    echo "</td>\n";
    
    echo '<td valign="top" class="'.$textStyle.'">';
    $listData[ 'STRING' ] = $templateTools->getPageLabel('[STRING]');
    $listData[ 'BOOL' ] = $templateTools->getPageLabel('[BOOL]');
    $listData[ 'INTEGER' ] = $templateTools->getPageLabel('[INTEGER]');
    $templateTools->showListByArray(  $statevar_type->$formItemName, $statevar_type->$formItemValue, $listData);
    $templateTools->showErrorMessage( $statevar_type->$formItemError );
    echo "</td>\n";
    
    echo '<td valign="top" class="'.$textStyle.'">';
    $templateTools->showTextBox(  $statevar_default->$formItemName, $statevar_default->$formItemValue, $statevar_default->$formItemError);
    echo "</td>\n";
*/
?>
</table>
<hr>
<input name="region_id" type="hidden" value="<?=$region_id->$formItemValue;?>" />
<div align="middle"><input name="Add" type="submit" value="<? 
if ( $editEntryID != '' ) {
    echo $templateTools->getPageLabel('[Update]'); 
} else {
    echo $templateTools->getPageLabel('[Add]'); 
}
?>" /></div>
</form>
<hr>
<table width="100%" border="0">
<?
$templateTools->setHeadingBGColor( $rowColor );
?><tr valign="top" <?= $rowColor;?> >

<!--[RAD_FIELDNAME_TITLE] -->
<td class="bold"><? echo $templateTools->getPageLabel('[title_[FieldName]]'); ?></td>

<td class="text">&nbsp;</td>
</tr>
<?
    $entryKey = RowManager_[DAObj]::XML_NODE_NAME;
    /*
     *  For each applicant ...
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
        
        // display entry data ...
        echo '<tr valign="top" '.$rowColor.' >';
 
/*[RAD_FIELDNAME_DATA]*/       
        echo '<td class="'.$textStyle.'">'.$entry->[FieldName].'</td>';

        if ( !isset($editLink) ) {
            $editLink = '#';
        }
        $currentEditLink = $editLink.$entry->[PrimaryKeyField];
        echo '<td align="right" class="text"><a href="'.$currentEditLink.'">'.$templateTools->getPageLabel('[Edit]').'</a></td>';

        echo '</tr>';
            
    
        $numEntries ++;
    }
    
?> 
</table>
<hr>
<div class="text" align="right"><? 
                    
    echo '<a href="'.$continueLink.'">'.$templateTools->getPageLabel('[Continue]').'</a>';
  
?></div>
