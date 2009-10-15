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
	
	
	
	
	<body onLoad="MM_preloadImages('<?=$pathToRoot;?>Images/chinese-on.jpg','<?=$pathToRoot;?>Images/korean-on.jpg','<?=$pathToRoot;?>Images/english-on.jpg');" link="#003366" vlink="#003366" alink="#CCCCCC" leftmargin="3" topmargin="8" bottommargin="8" marginwidth="0" marginheight="0" ID="Bdy" >
	
	
	
<!-- page begins (controls the div around header, content, and footer)_______-->
<div id="page">



<!-- header begins -->
<div id="header">

<div id="gcx_bar">
	<? echo $GCX_ConnexionBar;?>
</div>


<img src="../../Images/header_left.jpg" alt="left border" width="12" align="left"/>


<div id="logo">
<img src="../../Images/c4c_logo_full_colour_400x200.jpg" alt="Campus for Christ" width="150" height="75"/>
</div>


<img src="../../Images/header_right.jpg" alt="right border" width="12" align="right"/>



</div><!-- header ends -->

<!-- main navbar begins _____________________________________________________-->    
<div id="main_navbar">

<?
$nodeKey = XMLObject_PageContent::NODE_NAVBAR;
echo $page->$nodeKey;
?>
                                                            
</div><!-- main navbar ends ________________________________________________-->




<!-- container begins (holds content and sidebar) ____________-->
<div id="container">



<!-- content begins __________________________________________-->
<div id="content">
			


					<?
					/*
					 * Page Content Here
					 */
				    // first check to see if we have any sidebar content ...
				    // if so, then 
				    $sideBarKey = XMLObject_PageContent::NODE_SIDEBAR;
				    $sideBarContent = (string) $page->$sideBarKey;

				    if ( SHOW_DEV_FEATURES )
				    {
				    echo '<p class="bold">This is the DEV site, not the live CIM intranet.</p>';
				    }

				    $contentKey = XMLObject_PageContent::NODE_CONTENT;
				    echo $page->$contentKey;		    
				    ?>
				    
</div><!-- content ends _______________________________________-->	


<!-- sidebar begins ___________________________________________-->
<div id="sidebar">
					
					<?
					
				    // if sidebar exists then
				    if ( $sideBarContent != '' ) {
						    
				        // display sidebar data
				        
				        

                        echo $sideBarContent;
                      } // end if
				    
					?>  
				
</div><!-- sidebar ends _______________________________________-->
				    
				    
	
			

		

			

<!-- footer begins ____________________________________________-->	
<div id="footer">

<img src="../../Images/page_bottom_b.jpg" alt="page bottom" width="800" height="40" align="center"/>


			Logged in as:
			<?=$userID;?>
			<a class="footer" href="http://www.campusforchrist.org">Campus for Christ</a> | <a class="footer" href="http://www.athletesinaction.com">Athletes in Action</a> | <a class="footer" href="http://www.leaderimpactgroup.com">LeaderImpact Group</a> | <a class="footer" href="http://www.powertochange.org">P2C</a>
			

</div><!-- footer ends ________________________________________-->		



</div><!-- container ends _____________________________________-->	


		
</div><!-- page ends -->


	
</body>
</html>
