<?
$pathToRootKey =  XMLObject_PageContent::ELEMENT_PATH_ROOT;
$pathToRoot = (string) $page->$pathToRootKey;

?>
<html>
	<head>
		<title><?
			/*
			 *  Insert Page/Site Title
			 */
            $windowTitleKey = XMLObject_PageContent::NODE_WINDOW_TITLE;
			echo $page->$windowTitleKey;

		?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
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
	</head>
	<body onLoad="" bgcolor="#FFFFFF" text="#000000" link="#003366" vlink="#003366" alink="#CCCCCC" leftmargin="3" topmargin="8" bottommargin="8" marginwidth="0" marginheight="0" ID="Bdy" >
    <table width="100%" border="0" cellspacing="6" cellpadding="6">
    <tr>
        <td><? 
					/*
					 * Page Content Here
					 */
				    
				    $contentKey = XMLObject_PageContent::NODE_CONTENT;
				    echo $page->$contentKey;
								    
				?></td>
            </tr>
        </table>
	</body>
</html>