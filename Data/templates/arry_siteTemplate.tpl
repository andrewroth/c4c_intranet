<?
$pathToRoot = (string) $page[AppController::KEY_PATH_ROOT];
?>
<!--
This file was changed for the cim login module. The original file was backed up
in the same folder.
-->
<html>
	<head>
		<title><?
			/*
			 *  Insert Page/Site Title
			 */
			echo $page[AppController::KEY_WINDOW_TITLE];

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
        $cssList = $page[ AppController::KEY_CSS ];
        for( $indx=0; $indx<count($cssList); $indx++ ) {
            echo '<link href="'.$pathToRoot.$cssList[$indx].'" rel="stylesheet" type="text/css">'."\n";
        }
        
        $scriptList = $page[ AppController::KEY_SCRIPT ];
//        foreach ($scriptList as $script) {
        for($indx=0; $indx<count($scriptList); $indx++) {
            echo '<script language="JavaScript" src="'.$pathToRoot.$scriptList[$indx].'" type="text/javascript"></script>'."\n";
        }
	?>
	</head>
	<body onLoad="MM_preloadImages('<?=$pathToRoot;?>Images/chinese-on.jpg','<?=$pathToRoot;?>Images/korean-on.jpg','<?=$pathToRoot;?>Images/english-on.jpg');" bgcolor="#FFFFFF" text="#000000" link="#003366" vlink="#003366" alink="#CCCCCC" leftmargin="3" topmargin="8" bottommargin="8" marginwidth="0" marginheight="0" ID="Bdy" >
                <table width="750" height="118" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="223450" >
                        <tr valign="top">
                          <td width="336" ><img src="<?=$pathToRoot;?>Images/CimHeader_left.jpg" width="336"</td>
                          <td width="100%" ><img src="<?=$pathToRoot;?>Images/CimHeader_center.jpg" width="100%" height="118"></td>
                          <td width="229" ><img src="<?=$pathToRoot;?>Images/CimHeader_right.jpg" width="229"></td>
			</tr>
	        </table>
		<table width="750" height="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
                        <tr valign="top">
				<td width="1" bgcolor="223450">
					<img src="<?=$pathToRoot;?>Images/space.gif" width="1" height="1">
				</td>
				<?
					/*
					 * Page Content Here
					 */

				    // Pull out zonedContent data from page array
				    $zonedContent = $page[ AppController::KEY_CONTENT ];


				    // first check to see if we have any sidebar content ...
				    // if so, then
				    $sideBarContent = '';
				    if ( isset( $zonedContent[ AppController::KEY_ZONE_SIDEBAR ] ) ) {
				        $sideBarContent = (string) $zonedContent[ AppController::KEY_ZONE_SIDEBAR ];
				    }
				    if ($sideBarContent != '' ) {

				        // create normal content column
				        echo '<td width="524" height="100%"  >';

				    } else {
				    // else

				        // create WIDE content column with wide
				        echo '<td width="748" colspan="3">';

				    } // end if

				    // draw padded spacing around content area ...
				    echo '<table width="100%" border="0" cellspacing="6" cellpadding="6">
            <tr>
                <td>';

				    echo $zonedContent[ AppController::KEY_ZONE_MAIN ];

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
				    
				?>
                                <td width="1" bgcolor="223450">
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
								<table width="50%" border="0" align="center" cellpadding="5" cellspacing="2">
									<tr>
										<td valign="middle" class="footer">&nbsp;
											
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