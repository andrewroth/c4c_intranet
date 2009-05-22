<?
$fileName = 'objects/TemplateTools.php';
$path = Page::findPathExtension( $fileName );
require_once( $path.$fileName);

$templateTools = new TemplateTools();


$rowColor = "";
$templateTools->setHeadingBGColor( $rowColor );
 
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
<td class="bold"><? echo $dataList->[FieldName]; ?></td>
<td class="text">&nbsp;</td>
</tr>

</table>
<hr>

