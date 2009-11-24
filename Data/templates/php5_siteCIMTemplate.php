<?
$pathToRootKey =  XMLObject_PageContent::ELEMENT_PATH_ROOT;
$pathToRoot = (string) $page->$pathToRootKey;
//$userID = "string";
?>
 <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <head>
        <title>
            <?
			/*
			 *  Insert Page/Site Title
			 */
            $windowTitleKey = XMLObject_PageContent::NODE_WINDOW_TITLE;
			echo $page->$windowTitleKey;

		?>
        </title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <script>
            // The following variable is used in the milonic menu scripts to properly
            // find the path to the other menu scripts to include.
            aiPathToRoot = '<?=$pathToRoot;?>';
        </script>
        <script type="text/javascript">
		/* 
		This script sets the height of the menu bar (if exists) and the content to be the same
		*/
            function SetHeight(){
                s = document.getElementById('sidebar');
                c = document.getElementById('content');
                
                if (s.offsetHeight < c.offsetHeight) {
                    s.style.height = (c.offsetHeight + 10) + "px";
                }
                else {
                    c.style.height = s.offsetHeight + "px";
                }
            }
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
    <body onLoad="SetHeight(); MM_preloadImages('<?=$pathToRoot;?>Images/chinese-on.jpg','<?=$pathToRoot;?>Images/korean-on.jpg','<?=$pathToRoot;?>Images/english-on.jpg');" link="#003366" vlink="#003366" alink="#CCCCCC">
        <!-- begin top -->
        <div id="top">
			<!-- begin gcx bar -->
            <div id="gcx_bar">
                <? echo $GCX_ConnexionBar;?>
            </div>
			<!-- end gcx bar-->
            <!-- begin header -->
            <div id="header">
                <div id="left-header">
                    <img src="../../Images/BannerLeftShadow.png" alt="left border" />
                </div>
                <div id="c4c-logo">
                    <img src="../../Images/C4Clogo.png" alt="Campus for Christ" class="logo" /><img src="../../Images/IntranetTitle.png" alt="Campus for Christ" class="intranet" />
                </div>
                <div id="logged-in">
                    <br/>
                    <span class="text">logged in as:</span>
                    <span class="bold">
                        <?=$userID;?>
                    </span>
                </div>
                <div id="right-header">
                    <img src="../../Images/BannerRightShadow.png" alt="left border" />
                </div>
            </div><!-- end header -->
			<!-- begin main_navbar-->
            <div id="yellow_strip">
            </div>
			<!-- end main_navbar -->
        </div>
        <!-- End Top -->
		<!-- begin menu code -->
        <br /><br /><br /><br /><br /><br />
        <div align="center">
            <table class="navbar">
                <tr valign="top">
                    <td>
                        <?
                            $nodeKey = XMLObject_PageContent::NODE_NAVBAR;
                            echo $page->$nodeKey;
                        ?>
                    </td>
                </tr>
            </table>
        </div>
        <!-- end menu code-->
		<!-- begin wrapper -->
        <div class="wrapper">
            <!-- begin container - holds content, sidebar, and footer -->
            <div id="container">
                <?php
					/*
					 * Page Content Here
					 */
				    // first check to see if we have any sidebar content ...
				    // if so, then 
				    $sideBarKey = XMLObject_PageContent::NODE_SIDEBAR;
				    $sideBarContent = (string) $page->$sideBarKey;
				    				    // if sidebar exists then
				    if ( $sideBarContent != '' ) {
						?>
					<!-- begin sidebar -->
					<div id="sidebar">
						<?
							echo $sideBarContent;
							?>
					</div>
					<!-- end sidebar -->
					<?
						}
						?>
                <!-- begin content -->
                <div id="content">
                    <?

				    if ( SHOW_DEV_FEATURES )
				    {
				    echo '<p class="bold">This is the DEV site, not the live CIM intranet.</p>';
				    }

				    $contentKey = XMLObject_PageContent::NODE_CONTENT;
				    echo $page->$contentKey;	
                    ?>
                </div>
                <!-- end content-->
				<!-- begin footer -->
					<div id="footer">
				    <div id="left-footer">
					</div>
					<!-- begin footer-content -->
                    <div id="footer-content">
                        <table class="t1">
                            <tr>
                                <td class="t1">
                                    <span class="footer1">C4C site</span>
                                    <br/>
                                    <a href="http://www.campusforchrist.org">campusforchrist.org</a>
                                </td>
                                <td class="t1">
                                    <span class="footer1">the Pulse</span>
                                    <br/>
                                    <a href="http://pulse.campusforchrist.org">pulse.campusforchrist.org</a>
                                </td>
                                <td class="t1">
                                    <span class="footer1">C4C Resource Wiki</span>
                                    <br/>
                                    <a href="http://resources.campusforchrist.org">resources.campusforchrist.org</a>
                                </td>
                                <td class="t1">
                                    <span class="footer1">Project Application Tool</span>
                                    <br/>
                                    <a href="http://pat.campusforchrist.org">pat.campusforchrist.org</a>
                                </td>
                            </tr>
                        </table>
                    </div>
					<!-- end footer-content -->
					<div id="right-footer">
					</div>
                </div>
                <!-- end footer -->
            </div>
            <!-- end container -->
        </div>
        <!-- end wrapper -->
    </body>
</html>