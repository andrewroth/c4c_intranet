<?
$pathToRootKey =  XMLObject_PageContent::ELEMENT_PATH_ROOT;
$pathToRoot = (string) $page->$pathToRootKey;

//$userID = "string";

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
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
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
	<body>
                
            <tr valign="top">
				<td width="1" bgcolor="223450">
					<img src="<?=$pathToRoot;?>Images/space.gif" width="1" height="1">
				</td>
				<? 
					/*
					 * Page Content Here
					 */
				    // first check to see if we have any sidebar content ...
				    // if so, then 
				    $sideBarKey = XMLObject_PageContent::NODE_SIDEBAR;
				    $sideBarContent = (string) $page->$sideBarKey;
				    if ($sideBarContent != '' ) {
				    
				        // create normal content column 
				        echo '<td width="524" height="100%"  >';
				        
				    } else {
				    // else
				    
				        // create WIDE content column with wide
				        echo '<td width="748" >';
				        
				    } // end if
				    
				    // draw padded spacing around content area ...
				    echo '<table width="100%" border="0" cellspacing="6" cellpadding="6">';
				    
				    if ( SHOW_DEV_FEATURES )
				    {
				    echo '<tr><td class="bold">This is the DEV site, not the live CIM intranet.</td></tr>';
				    }
echo'       <tr><td>';
				    
				    $contentKey = XMLObject_PageContent::NODE_CONTENT;
				    echo $page->$contentKey;
				    
				    // close padding table
				    echo '</td></tr></table>';
       
				    // close Content Table Cell 
				    echo '</td>'; ?>			    

	</body>
</html>