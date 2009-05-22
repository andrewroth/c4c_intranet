<?
$pathToRootKey =  XMLObject_PageContent::ELEMENT_PATH_ROOT;
$pathToRoot = (string) $page->$pathToRootKey;

?><HTML>
<HEAD>
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
