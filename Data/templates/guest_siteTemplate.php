<?
$pathToRootKey =  XMLObject_PageContent::ELEMENT_PATH_ROOT;
$pathToRoot = (string) $page->$pathToRootKey;

?><HTML>
<HEAD>
<meta http-equiv="Cache-Control" content="no-cache"> 
<meta http-equiv="Pragma" content="no-cache">
<meta http-equiv="expires" content="0">
<TITLE><?
			/*
			 *  Insert Page/Site Title
			 */
            $windowTitleKey = XMLObject_PageContent::NODE_WINDOW_TITLE;
			echo $page->$windowTitleKey;

		?></TITLE>
		<script>
	// The following variable is used in the milonic menu scripts to properly
	// find the path to the other menu scripts to include.
	aiPathToRoot='<?=$pathToRoot;?>';
    </script>
<?
		/*
		 *  Insert CSS Styles and JavaScript links ...
		 */
        $styleListKey = XMLObject_PageContent::NODE_CSS;
        $styleKey =  XMLObject_PageContent::ELEMENT_CSS;
        foreach ($page->$styleListKey->$styleKey as $style) {
            echo '<link href="'.$pathToRoot.$style.'" rel="stylesheet" type="text/css">'."\n";
        }
        
        $scriptListKey = XMLObject_PageContent::NODE_SCRIPT;
        $scriptKey =  XMLObject_PageContent::ELEMENT_SCRIPT;
        foreach ($page->$scriptListKey->$scriptKey as $script) {
            echo '<script language="JavaScript" src="'.$pathToRoot.$script.'" type="text/javascript"></script>'."\n";
        }
	?>	
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}
//-->
</script>
</HEAD>
<BODY bgcolor="#FFFFFF" link="#40637A" vlink="#003366" leftmargin="0" topmargin="0" bottommargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('<?=$pathToRoot;?>/images/previous_on.jpg')">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="160" valign="top"> <table width="160" border="0" cellspacing="0" cellpadding="0" height="100%">
        <tr> 
          <td valign="top" bgcolor="#40637A" width="25"> <img src="<?=$pathToRoot;?>/images/space.gif" width="25" height="1"> 
          </td>
          <td valign="top" width="5"><img src="<?=$pathToRoot;?>/images/space.gif" width="5" height="1"></td>
          <td valign="top" width="170" align="right"> <table width="130" height="100%" border="0" align="left" cellpadding="5" cellspacing="0">
              <tr align="right" valign="top"> 
                <td width="129"> <div align="right" class="strong"> 
                    <?
                        /*
                         * Display sidebar content...
                         */
                        $sideBarKey = XMLObject_PageContent::NODE_SIDEBAR;
                        $sideBarContent = (string) $page->$sideBarKey;
                        echo $sideBarContent;
                       
                        if (strpos($sideBarContent, "Admin Options") == true)
                            echo "<a href='". Page::getBaseURL() ."'><span class=\"text\">Home</span></a><br>";
                    ?>
                    
                  </div></td>
                <td width="1" height="100%" rowspan="2" class="level1"><img src="<?=$pathToRoot;?>/images/gray.gif" width="1" height="100%"></td>
              </tr>
              <tr align="right" valign="top"> 
                <td width="129" class="text">&nbsp;</td>
              </tr>
            </table></td>
        </tr>
      </table></td>
    <td valign="top"><?
        /*
         * Display Page Content Data
         */
        $contentKey = XMLObject_PageContent::NODE_CONTENT;
        echo $page->$contentKey;
    ?></td>
  </tr>
</table>
</BODY>
</HTML>
