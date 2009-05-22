<script language="JavaScript" type="text/JavaScript">
<!--
function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}

function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
//-->
</script>

<table width="750" height="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr valign="top">
    <td colspan="3">
      <table cellpadding="0" cellspacing="0" width="100%">
        <tr>
          <td valign="top">
            <table height="21" cellpadding="0" cellspacing="0" width="100%" border=0>
              <tr>
                <td bgcolor="#CCCCCC" height="20">
                  <table cellSpacing="2" cellPadding="3" width="100%" border=0>
                    <tr>
                      <td class=navbar vAlign=top><? for ($navIndx=0; $navIndx<count($navBar); $navIndx++) { 
                            if ( $navIndx != 0 ) {
                            ?> | <?
                            }
                            if ($navBar[$navIndx]['selected'] == true) {  ?><?=$navBar[$navIndx]['label'];?> <?
                            } else {
                            ?> <a href="<?=$navBar[$navIndx]['link'];?>"><?=$navBar[$navIndx]['label'];?></a><?
                            } 
                            
                        }?></td>
					</tr>
				  </table>
				</td>
              </tr>
			</table>
		  </td>
		</tr>
        <tr> 
          <td height="1" bgcolor="223450"><img src="images/space.gif" width="1" height="1"></td>
        </tr>
      </table>
	</td>
  </tr>
  <tr valign="top"> 
    <td width="524"><table width="100%" height="100%" border="0" cellpadding="6" cellspacing="6">
        <tr> 
          <td height="30" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr> 
                <td valign="baseline"><span class="heading"><?=$labels->Label('[StatsEntry]');?></span><font color="#FFFFFF" size="5" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
                <td><div align="right"></div>
                  <div align="right"></div>
                  <div align="right"></div></td>
              </tr>
            </table>
            <hr width="100%" size="1" noshade color="#223450"> </td>
        </tr>
        <tr> 
          <td valign="top"><p class="text"><?=$labels->Label('[Instructions]');?></p>
            <form name="Form1" method="post" action="<?=$formAction['Form1'] ?>"><table width="100%" border="0" align="center" cellpadding="1" cellspacing="1">
              <tr valign="middle" bgcolor="#FFFFFF"> 
                <td width="15%" class="heading3"><?=$labels->Label('[Region]');?></td>
<?php

if( count($regionlist) == 1 ) {
	// Do not display regional drop down list, only Display current region.
	echo '<td width="37%" class="smalltext">'.$regionlist[0]['label'].'</td>';
	
} else {
	echo '<td width="37%" class="text"><select name="regionlist" style="width=180px" onChange="MM_jumpMenu(\'this\',this,0)" >';
	
	for($count=0;$count<count($regionlist);$count++)
		echo '<option value="'.$regionlist[$count]['jumplink'].'"'.($regionlist[$count]['selected']?' selected>':'>').$regionlist[$count]['label'].'</option>';
	
	echo '</select></td>';
	
}

?>
                <td width="12%" class="text">&nbsp;</td>
                <td width="36%">&nbsp; </td>
              </tr>
              <tr valign="middle" bgcolor="#FFFFFF"> 
                <td class="heading3"><?=$labels->Label('[Campus]');?></td>
<?

if( count($campuslist) == 1 ) {
	// Do not display campus drop down list, only display current campus or "No available campuses".
	echo '<td class="smalltext">'.$campuslist[0]['label'].'</td>';
	
} else {
	echo '<td><select name="campuslist" style="width=180px" onChange="MM_jumpMenu(\'this\',this,0)">';
	
	for($count=0;$count<count($campuslist);$count++) {
		echo '<option value="'.$campuslist[$count]['jumplink'].'"'.($campuslist[$count]['selected']?' selected>':'>').$campuslist[$count]['label'].'</option>';
	}
	
	echo '</select></td>';
}

?>

                  </select></td>
                <td>&nbsp;</td>
                <td width="36%">&nbsp;</td>
              </tr>
              <tr valign="middle" bgcolor="#FFFFFF"> 
                <td class="heading3"><?=$labels->Label('[Month]');?></td>
                <td> <select name="monthlist" style="width=180px" onChange="MM_jumpMenu('this',this,0)">
<?

for($count=0;$count<count($monthlist);$count++) {
    echo '<option value="'.$monthlist[$count]['jumplink'].'"'.($monthlist[$count]['selected']?' selected>':'>').$monthlist[$count]['label'].'</option>';
}


?>
                  </select> </td>
                <td class="bold"><div align="center"><?=$labels->Label('[OR]');?></div></td>
                <td width="36%"><select name="newmonthlist">
<?

for($count=0;$count<count($newmonthlist);$count++) {
    echo '<option value="'.$newmonthlist[$count]['value'].'">'.$newmonthlist[$count]['label'].'</option>';
}


?>
                  </select>
                  <a href="javascript:document.Form1.submit()"><span class="smallText"><?=$labels->Label('[Add]');?> </span></a></td>
              </tr>
            </table></form>
            <p class="text"><?=$labels->Label('[EnterStatsInstr]');?></p>
            <form name="Form2" method="post" action="<?=$formAction['Form2'] ?>"><table width="100%" border="0" cellspacing="0" cellpadding="2">
              <tr valign="top" bgcolor="223450"> 
                <td width="76%" rowspan="2" valign="middle" bordercolor="#000000"> 
                  <div align="center" class="bold"><font color="ffffff"><?=$labels->Label('[Item]');?></font></div>
                  </td>
                <td colspan="2" valign="middle" bordercolor="#000000"> 
                  <div align="center"><span class="bold"><font color="ffffff"><?=$labels->Label('[ReportedNumbers]');?></font></span><font color="ffffff"><strong> </strong></font></div></td>
              </tr>
              <tr> 
                <td width="13%" height="20" valign="middle" bordercolor="#000000" bgcolor="223450"> 
                  <div align="center" class="smallText"><strong><font color="#FFFFFF"><?=$labels->Label('[Staff]');?></font></strong></div></td>
                <td width="11%" valign="middle" bordercolor="#000000" bgcolor="223450"> 
                  <div align="center"> 
                    <p class="smallText"><strong><font color="#FFFFFF"><?=$labels->Label('[Disc]');?></font></strong></p>
                  </div></td>
              </tr><?
              
              $bgColor = '';
              for ($multiIndx=0; $multiIndx<count($multiQuestion); $multiIndx++) {
              
                    if ($bgColor == 'FFFFFF') {
                        $bgColor = "EEEEEE";
                    } 
                    else {
                        $bgColor="FFFFFF";
                    }
              ?><tr valign="top"> 
                <td bordercolor="#000000" bgcolor="<?=$bgColor;?>" class="smallText"><?=$multiQuestion[$multiIndx]['label'];?></td>
                <td align="center" bordercolor="#000000" bgcolor="<?=$bgColor;?>"> <strong> 
                <input name="<?=$multiQuestion[$multiIndx]['nameStaff'];?>" type="text" size="5" value="<?=$multiQuestion[$multiIndx]['valueStaff'];?>">
                  </strong></td>
                <td align="center" bordercolor="#000000" bgcolor="<?=$bgColor;?>"> <strong> 
                  <input name="<?=$multiQuestion[$multiIndx]['nameDisc'];?>" type="text" size="5" value="<?=$multiQuestion[$multiIndx]['valueDisc'];?>">
                  </strong></td>
              </tr><?
              }
              
              
               for ($singleIndx=0; $singleIndx<count($singleQuestion); $singleIndx++) {
              
                    if ($bgColor == 'FFFFFF') {
                        $bgColor = "EEEEEE";
                    } 
                    else {
                        $bgColor="FFFFFF";
                    }
              ?>
             <tr valign="top"> 
                <td bordercolor="#000000" bgcolor="<?=$bgColor;?>" class="smallText"><?=$singleQuestion[$singleIndx]['label'];?></td>
                <td colspan="2" align="center" bordercolor="#000000" bgcolor="<?=$bgColor;?>"> 
                  <strong> 
                  <input name="<?=$singleQuestion[$singleIndx]['name'];?>" type="text" size="5" value="<?=$singleQuestion[$singleIndx]['value'];?>">
                  </strong></td>
              </tr>
              <?
              } ?>
              <tr> 
                <td colspan="3">&nbsp;</td>
              </tr>
              <tr> 
                <td colspan="3" align="center"><div align="right"><a href="javascript:document.Form2.submit()" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Save','','images/saveon.jpg',1)"><img src="images/saveoff.jpg" name="Save" width="104" height="25" border="0"></a></div></td>
              </tr>
            </table></form>
            <p class="heading2">&nbsp;</p>
	</td>
        </tr>
        <tr> 
          <td valign="bottom"> <hr size="1" noshade color="223450"> 
            <div align="center" class="smallText"> </div></td>
        </tr>
      </table></td>
    <td width="1" bgcolor="#223450"><?php echo '<img src="images/space.gif" width="1" height="1">'; ?></td>
    <td width="223" bgcolor="#EEEEEE">
      <table width="100%" border="0" cellspacing="10" cellpadding="10">
        <tr> 
          <td valign="top">
<table width="100%" border="0" cellspacing="4" cellpadding="0">
              <tr> 
                <td colspan="2" class="bold"><?=$labels->Label('[MissingMonths]');?></td>
              </tr>
<? for($indx=0;$indx<count($missingMonths);$indx++) {
    echo '<tr class="smallText"> 
                <td valign="top">'.$missingMonths[$indx]['label'].'</td>';
    echo '<td><a href="'.$missingMonths[$indx]['link'].'">'.$labels->Label('[Add]').'</a></td></tr>';
}
?>
            </table>
            
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table>
