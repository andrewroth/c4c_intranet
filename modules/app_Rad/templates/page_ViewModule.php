<?
$fileName = 'objects/TemplateTools.php';
$path = Page::findPathExtension( $fileName );
require_once( $path.$fileName);

$templateTools = new TemplateTools();


$rowColor = "";
$templateTools->swapBGColor( $rowColor );

$templateTools->loadPageLabels( $pageLabels )
?>
<p><span class="heading"><? echo $templateTools->getPageLabel('[Title]');  ?></span></p>
<p><span class="text"><? echo $templateTools->getPageLabel('[Instr]');  ?></span></p>
<p><span class="bold"><? echo $templateTools->getPageLabel('[Description]'); ?>: </span><span class="text"><? echo $dataList->module_desc; ?></span></p>
<div align="right" class="text" ><? 

    if (!isset($editLink)) {
        $editLink = '#';
    }
    echo '<a href="'.$links[ 'edit'].'">'.$templateTools->getPageLabel('[Edit]').'</a>'; 
    
?></div>
<hr>
<table width="100%" border="0">
<tr valign="top" <?= $rowColor;?> >

<!--[RAD_FIELDNAME_LABEL] -->
<td class="text"><? echo $templateTools->getPageLabel('[title_module_creatorName]'); ?></td>
<td class="text"><? echo $dataList->module_creatorName; ?></td>
</tr>
<? $templateTools->swapBGColor( $rowColor ); ?>
<tr valign="top" <?= $rowColor;?> >
<td class="text"><? echo $templateTools->getPageLabel('[title_module_isCore]'); ?></td>
<td class="text"><? echo $dataList->module_isCore; ?></td>
</tr>
<? 
    
    $templateTools->swapBGColor( $rowColor ); 

?>
<tr valign="top" <?= $rowColor;?> >
<td class="text"><? echo $templateTools->getPageLabel('[title_module_isCommonLook]'); ?></td>
<td class="text"><? echo $dataList->module_isCommonLook; ?></td>
</tr>
<? 
    
    $templateTools->swapBGColor( $rowColor ); 

?>
<tr valign="top" <?= $rowColor;?> >
<td class="text"><? echo $templateTools->getPageLabel('[title_module_isCreated]'); ?></td>
<td class="text"><em><? echo $dataList->module_isCreated; ?></em></td>
</tr>
<? 
    
    $templateTools->swapBGColor( $rowColor ); 

?>
<tr valign="top" <?= $rowColor;?> >
<td class="text"><? echo $templateTools->getPageLabel('[title_module_isUpdated]'); ?></td>
<td class="text"><em><? echo $dataList->module_isUpdated; ?></em></td>
</tr>
<? 
    
    $templateTools->swapBGColor( $rowColor ); 

?>
</table>
<hr>
<table width="100%" border="0">
<tr>
<td width="33%" valign="top" >
<p><span class="bold"><a href="<? echo $links[ 'stateVarSection']; ?>"><? echo $templateTools->getPageLabel('[titleStateVar]'); ?></a> : </span></a></p>
<?
    $stateVarKey = RowManager_StateVarManager::XML_NODE_NAME;
    foreach( $stateVarList->$stateVarKey as $stateVar) {
    
        $link = $links[ 'stateVarEdit'].$stateVar->statevar_id;
        echo '<p><span class="text"><a href="'.$link.'">'.$stateVar->statevar_name.'</a></span><br><span class="smalltext">'.$stateVar->statevar_desc.'</span></p>';
    }
?>
</td>
<td width="33%" valign="top" class="text">
<p><span class="bold"><a href="<? echo $links[ 'daObjSection']; ?>"><? echo $templateTools->getPageLabel('[titleDAObj]'); ?></a> : </span></p>
<?
    $daObjVarKey = RowManager_DAObjManager::XML_NODE_NAME;
    foreach( $daObjectList->$daObjVarKey as $daObj) {
    
        $link = $links[ 'daObjEdit'].$daObj->daobj_id;
        echo '<p><span class="text"><a href="'.$link.'">'.$daObj->daobj_name.'</a></span><br><span class="smalltext">'.$daObj->daobj_desc.'</span></p>';
    }
?>

</td>
<td width="33%" valign="top" class="text">
<p><span class="bold"><a href="<? echo $links[ 'pageSection']; ?>"><? echo $templateTools->getPageLabel('[titlePage]'); ?></a> : </span></p>
<?
    $pageEditLink = $links[ 'pageEdit'];
    $pageVarKey = RowManager_PageManager::XML_NODE_NAME;
    foreach( $pageList->$pageVarKey as $page) {
    
        $link = $pageEditLink.$page->page_id;
        echo '<p><span class="text"><a href="'.$link.'">'.$page->page_name.'</a></span><br><span class="smalltext">'.$page->page_desc.'</span></p>';
    }
?>

</td>
<td width="33%" valign="top" class="text">
<p><span class="bold"><a href="<? echo $links[ 'transitionSection']; ?>"><? echo $templateTools->getPageLabel('[titleTransitions]'); ?></a> : </span></p>
<?
    $transitionVarKey = RowManager_TransitionsManager::XML_NODE_NAME;
    foreach( $transitionList->$transitionVarKey as $transition) {
    
        $link = $links[ 'transitionEdit'].$transition->transition_id;
        
        $fromName = $pageNames[ (int) $transition->transition_fromObjID ];
        $toName = $pageNames[ (int) $transition->transition_toObjID ];
        echo '<p><span class="text"><a href="'.$link.'">'.$fromName.'->'.$toName.'</a></span></p>';
    }
?>

</td>
</tr>
</table>
<hr>
<table width="100%" >
<tr>
<td align="left" class="text">
<?
echo '<a href="'.$links['returnModuleList'].'">'.$templateTools->getPageLabel('[returnList]').'</a>'; 
?>
</td>
<td align="right" class="text">
<?
echo '<a href="'.$links[ 'create'].'">'.$templateTools->getPageLabel('[createModule]').'</a>'; 
?>
</td>
</tr>
</table>
