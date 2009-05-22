<table width="100%" border="0" cellspacing="6" cellpadding="6">
<tr><td>
<? if ($form->title != '' ) { ?>
<span class="heading"><?=$form->title;?></span>
<hr size="1" color="#223450" >
<? } ?>
<form action="<?=$form->callback;?>" method="post" name="<?=$form->name;?>" <?=($form->isUpload ? ' enctype="multipart/form-data" ' : '' );?> >
<input type="hidden" name="Process" value="<?=$form->name;?>">
<? for ($indx=0; $indx<count($form->hiddenData); $indx++) { ?>
<input type="hidden" name="<?=$form->hiddenData[$indx]['Name'];?>" value="<?=$form->hiddenData[$indx]['Value'];?>">
<? } ?>
<table width="100%"  border="0" cellspacing="3" cellpadding="3">
<? for($indx=0; $indx<count($form->items); $indx++) {

		switch ( $form->items[ $indx ]['Type'] ) {
			
			case 'T': 
			?>
			<tr> 
			  <td class="text" valign="top" bgcolor="#EEEEEE"><?=$form->items[$indx]['Label'];?></td>
			  <td><input name="<?=$form->items[$indx]['Name'];?>" type="text" value="<?=$form->items[$indx]['Value'];?>" <?=($form->isEnabled ? '' : 'DISABLED');?> >
			  <div class="error"><?=$form->items[$indx]['ErrorMsg'];?></div>
			  <div class="example"><?=$form->items[$indx]['Example'];?></div></td>
			</tr>
			<? 
				break;
			
			case 'M': 
			?>
			<tr> 
			  <td class="text" valign="top" bgcolor="#EEEEEE"><?=$form->items[$indx]['Label'];?></td>
			  <td><textarea name="<?=$form->items[$indx]['Name'];?>" rows="5" id="<?=$form->items[$indx]['Name'];?>" <?=($form->isEnabled ? '' : 'DISABLED');?> ><?=$form->items[$indx]['Value'];?></textarea>
			  <div class="error"><?=$form->items[$indx]['ErrorMsg'];?></div>
			  <div class="example"><?=$form->items[$indx]['Example'];?></div></td>
			</tr>
			
			<? 
				break;
			
			case 'CB': 
			?>
			<tr> 
			  <td class="text" valign="top" bgcolor="#EEEEEE"><?=$form->items[$indx]['Label'];?></td>
			  <td><input name="<?=$form->items[$indx]['Name'];?>" type="checkbox" value="1" <?=($form->items[$indx]['Value']!='' ? ' checked ' : '');?> <?=($form->isEnabled ? '' : 'DISABLED');?> ></td>
			</tr>
			
			<? 
				break;
				
				
            case 'FU':      //File UploadBox 
			?>
			<tr> 
			  <td class="text" valign="top" bgcolor="#EEEEEE"><?=$form->items[$indx]['Label'];?></td>
			  <td><? if( $form->items[$indx]['Value'] != '') {
			      ?>
			      <span class="modify"><?=$form->items[$indx]['Value']['fileName'];?> (<?=$form->items[$indx]['Value']['fileSize'];?>)</span>
			      <? } 
			     ?><input name="<?=$form->items[$indx]['Name'];?>" type="file" size="20" <?=($form->isEnabled ? '' : 'DISABLED');?> ></td>
			</tr>
			
			<? 
				break;
				
			case 'L': 
			?>
			<tr> 
			  <td class="text" valign="top" colspan="2" bgcolor="#EEEEEE"><?=$form->items[$indx]['Label'];?></td>
			</tr>
			
			<? 
				break;
				
			case 'List': 
			?>
			<tr> 
			  <td class="text" valign="top" bgcolor="#EEEEEE"><?=$form->items[$indx]['Label'];?></td>
			  <td><select name="<?=$form->items[$indx]['Name'];?>" size="1" id="<?=$form->items[$indx]['Name'];?>" <?=($form->isEnabled ? '' : 'DISABLED');?> >
			      <?  for ($listIndx=0; $listIndx<count( $form->items[$indx]['List'] ); $listIndx++ ) {
				  		$tagSelected = '';		
						if ( isset($form->items[$indx]['List'][$listIndx]['listSelected']) == true) {
							if ($form->items[$indx]['List'][$listIndx]['listSelected'] == true) {
								$tagSelected = 'selected';
							}
						}
				  ?><option value="<?=$form->items[$indx]['List'][$listIndx]['listValue'];?>"  <?=$tagSelected;?> ><?=$form->items[$indx]['List'][$listIndx]['listLabel'];?></option>
				  <?  }  ?>
				  </select><div class="error"><?=$form->items[$indx]['ErrorMsg'];?></div></td>
			</tr>
			<? 
				break;
		
		}
	}
?>

</table>
<hr width="100%" size="1" noshade color="#223450">
<div align="center">
<?
for ($indx=0; $indx<count( $form->buttonList ); $indx++ ) {
					
?><input type="submit" value="<?=$form->buttonList[$indx]['Value'];?>" />
<?
}
?>

</div>
</form>

<? 
for ($indx=0; $indx<count($form->messages); $indx++) { 
?>
<p class="text"><?=$form->messages[$indx];?></p>
<? } ?>
</td></tr></table>
