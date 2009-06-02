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
	<body onLoad="MM_preloadImages('<?=$pathToRoot;?>Images/chinese-on.jpg','<?=$pathToRoot;?>Images/korean-on.jpg','<?=$pathToRoot;?>Images/english-on.jpg');" bgcolor="#FFFFFF" text="#000000" link="#003366" vlink="#003366" alink="#CCCCCC" leftmargin="3" topmargin="8" bottommargin="8" marginwidth="0" marginheight="0" ID="Bdy" >
<table width="751" align="center" cellpadding="0" cellspacing="0">
    <tr>
        <td><? echo $GCX_ConnexionBar;?></td>
    </tr>
</table>

		<table width="750" height="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
			<tr valign="top">
				<td width="100%" height="118" colspan="5" valign="bottom">
					<div align="left">
						<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="223450" > 
							<tr>
								<td width="1" >
									<img src="<?=$pathToRoot;?>Images/space.gif" width="1" height="118">
								</td>
								<td>
								    <table width="100%" height="118" cellpadding="0" cellspacing="0" border="0" >
								        <tr>
								            <td width="336" background="<?=$pathToRoot;?>Images/CimHeader_left.jpg">
								                <table width="336" height="118" border="0">
								                    <tr valign="bottom">
								                        <td>
                                                            <?
                                                                $nodeKey = XMLObject_PageContent::NODE_NAVBAR;
                                                                echo $page->$nodeKey;
                                                            ?>
                                                        </td>
								                    </tr>
								                </table>
								            </td>
            								<td width="*" background="<?=$pathToRoot;?>Images/CimHeader_center.jpg">&nbsp;</td>
                                            <td width="229" background="<?=$pathToRoot;?>Images/CimHeader_right.jpg">&nbsp;</td>
                                </tr>
                            </table>
								</td>
								<td width="1" >
									<img src="<?=$pathToRoot;?>Images/space.gif" width="1" height="118">
								</td>
							</tr>
					  </table>
					</div>
				</td>
				
			</tr>
            <?
            /*
             * Application Menu Bar Data
             */
             
                // pull together any menu data into menuHTML...
                $menuHTML = '';
                $menuKey = XMLObject_Menu::ROOT_NODE_MENU;
                $menuItemKey = XMLObject_Menu::NODE_ITEM;
                $itemTypeKey = XMLObject_Menu::ITEM_TYPE;

                if ( isset($page->$menuKey->$menuItemKey) ) {
                
                    foreach( $page->$menuKey->$menuItemKey as $item) {
                    
                        switch ($item->$itemTypeKey) {
                        
                            case XMLObject_Menu::ITEM_TYPE_LINK:
                                if ($menuHTML != '') {
                                    $menuHTML .= ' | ';
                                }
                                $labelKey = XMLObject_Menu::ITEM_TYPE_LINK_LABEL;
                                $linkKey = XMLObject_Menu::ITEM_TYPE_LINK_LINK;
                                $menuHTML .= '<a href="'.$item->$linkKey.'">'.$item->$labelKey.'</a>';
                                break;
                        }
                    }
                    
                } // end if page->menu->item exists ...
                
                
                // if menuHTML has data then we display the menu bar...
                if ($menuHTML != '') {
                    
                    echo '<tr valign="top"> 
    <td width="1" bgcolor="223450"><img src="'.$pathToRoot.'images/space.gif" width="1" height="1"></td>
    <td width="748" colspan="3" bgcolor="#CCCCCC" height="10" > 
     <table cellpadding="0" cellspacing="0" width="100%">
        <tr>
          <td valign="top">
            <table height="21" cellpadding="0" cellspacing="0" width="100%" border=0>
              <tr>
                <td bgcolor="#CCCCCC" height="20">
                  <table cellSpacing="2" cellPadding="3" width="100%" border=0>
                    <tr>
                      <td class=navbar vAlign=top>
					  <!-- Nav Bar -->';
					  
				    echo $menuHTML;      
      
                    echo '<!-- End Nav Bar -->
						</td>
					</tr>
				  </table>
				</td>
              </tr>
			</table>
		  </td>
		</tr>
      </table>
    </td>
    <td width="1" bgcolor="223450"><img src="'.$pathToRoot.'images/space.gif" width="1" height="1"></td>
  </tr>
  <tr>
	 <td width="1" bgcolor="223450"><img src="'.$pathToRoot.'images/space.gif" width="1" height="1"></td> 
     <td height="1" bgcolor="223450" colspan="3"><img src="'.$pathToRoot.'images/space.gif" width="1" height="1"></td>
	 <td width="1" bgcolor="223450"><img src="'.$pathToRoot.'images/space.gif" width="1" height="1"></td>
  </tr>';	
                } // end if menuHTML has data ...
                
            ?><tr valign="top">
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
				    echo '<tr>
				     <td class="bold">This is the DEV site, not the live CIM intranet.</td>
				    </tr>';
				    }
echo'       <tr>
                <td>';
				    
				    $contentKey = XMLObject_PageContent::NODE_CONTENT;
				    echo $page->$contentKey;
				    
				    // close padding table
				    echo '</td>
            </tr>
        </table>';
       
				    // close Content Table Cell 
				    echo '</td>';
				    
				    // if sidebar exists then
				    if ( $sideBarContent != '' ) {
				    
				        // display sidebar data
				        echo '<td width="1" bgcolor="223450"><img src="'.$pathToRoot.'images/space.gif" width="1" height="1"></td>
	<td width="223" height="100%" bgcolor="#EEEEEE" ><table width="100%" border="0" cellspacing="6" cellpadding="6">
            <tr>
                <td><!-- Menu Area -->';
                        echo $sideBarContent;
                        
                        echo '<!-- End Menu Area --> </td>
            </tr>
        </table></td>';
				    
				    } // end if
				    
				?><td width="1" bgcolor="223450">
					<img src="<?=$pathToRoot;?>Images/space.gif" width="1" height="1">
				</td>
			</tr>
			<tr valign="bottom" bgcolor="223450">
				<td height="25" colspan="5">
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td width="10%" valign="bottom">
								<img src="<?=$pathToRoot;?>Images/bl.jpg" width="6" height="6">
							</td>
							<td height="25" valign="middle">
								<table width="100%" border="0" align="center" cellpadding="5" cellspacing="2">
									<tr>
										<td valign="middle" class="footer">Logged in as:
											<?=$userID;?>
											| <a class="footer" href="http://www.campusforchrist.org">Campus for Christ</a> | <a class="footer" href="http://www.athletesinaction.com">Athletes in Action</a> | <a class="footer" href="http://www.leaderimpactgroup.com">LeaderImpact Group</a> | <a class="footer" href="http://www.powertochange.org">P2C</a>
											
										</td>
									</tr>
								</table>
							</td>
							<td width="10%" height="100%" valign="bottom">
								<div align="right">
									<img src="<?=$pathToRoot;?>Images/br.jpg" width="6" height="6">
								</div>
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</body>
</html>
