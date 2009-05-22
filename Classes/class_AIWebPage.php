<?php


class  AIWebPage extends OldPage {
// 
//  DESCRIPTION:
//		This is a Page Object to draw your page as they are drawn on Version 1
//		of the AI Web Site.
//
//	CONSTANTS:

//
//	VARIABLES:
	var $TitleImage;
	var $PageMainTitle;
	var $PageHeaderImage;
	var $PageAdminColContent;
	var $PageAdminColWidth;
	var $DisplayNavBar;
	
	var $PageFooterContent;
//
//	CLASS CONSTRUCTOR
//

	//************************************************************************
	function AIWebPage( $LocalPageName='<null>', $PathFromRoot='', $PathToRoot='../', $PageTitle='Untitled Document') {
	
	
		OldPage::OldPage(  $LocalPageName, $PathFromRoot, $PathToRoot, $PageTitle );
		
		$this->PageMainTitle = '';
		$this->PageHeaderImage = 'Images/AIhead2.jpg';
		$this->PageAdminColContent = '<null>';
		$this->PageAdminColWidth = '298';
		$this->DisplayNavBar = true;
		$this->PageFooterContent = '<null>';
		
//		$this->AddStyle( 'CascadeMenu');
		$this->AddStyle( 'pageElements');
		
//		$this->AddJScript( 'CascadeMenu');
		$this->AddJScript( 'milonic_src');
		$this->AddJScript( 'menu_data');
		$this->AddJScript( 'MM_swapImage');
		$this->AddJScript( 'MM_preloadImages');
		$this->AddJScript( 'MM_findObj');
		
		$this->BodyParameters = 'bgcolor="#FFFFFF" text="#000000" link="#003366" vlink="#003366" alink="#CCCCCC" leftmargin="3" topmargin="8" bottommargin="8"  marginwidth="0" marginheight="0" ID="Bdy"';
//		$this->AddOnLoadEvent('InitMenu()');
		$this->AddOnLoadEvent("MM_preloadImages('{$PathToRoot}Images/chinese-on.jpg','{$PathToRoot}Images/korean-on.jpg','{$PathToRoot}Images/english-on.jpg')");

	
	}

//
//	CLASS FUNCTIONS:
//

	//************************************************************************
	function TemplateName() {
	
	
	}
	
	
	//************************************************************************
	function BuildBodyTag() {
	
//		// If we are to display the NavBar, be sure to add the OnClick Event handler to the Body Parameters.
//		if ($this->DisplayNavBar == true ) {	
//			$this->AddOnLoadEvent('InitMenu()');
//			$this->BodyParameters .= ' Onclick="HideMenu(menuBar)" ';
//		}
		
		// Now Call the Original BuildBodyTag() from the Page Class.
		OldPage::BuildBodyTag();
	}
	
	
	
	//************************************************************************
	function BuildLanguageMenu() {
	
		if ( $this->PageCallback != '' ) {
			$TempJumpKey = $this->PageCallback .'&'. SESSION_ID_LANG . '=';
		} else {
			$TempJumpKey = $this->PageName .'?'. SESSION_ID_LANG . '=';
		}
		$Temp = '<a href="'.$TempJumpKey.'2" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage(\'Chinese\',\'\',\''.$this->PathToRootDir.'Images/chinese-on.jpg\', 1)"><img src="'.$this->PathToRootDir.'Images/chinese-off.jpg" alt="Chinese" name="Chinese" width="28" height="16" border="0"></a>';
		$Temp .= '<a href="'.$TempJumpKey.'3" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage(\'Korean\',\'\',\''.$this->PathToRootDir.'Images/korean-on.jpg\',  1)"><img src="'.$this->PathToRootDir.'Images/korean-off.jpg"  alt="Korean"  name="Korean"  width="39" height="16" border="0"></a>';
		$Temp .= '<a href="'.$TempJumpKey.'1" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage(\'English\',\'\',\''.$this->PathToRootDir.'Images/english-on.jpg\',1)"><img src="'.$this->PathToRootDir.'Images/english-off.jpg" alt="English" name="English" width="52" height="16" border="0"></a>';

		
		return $Temp;
	
	}
	
	
	//************************************************************************
	function BuildPreContent() {
				
		$LanguageMenu = $this->BuildLanguageMenu();
		
		if ($this->DisplayNavBar == true ) {	
			$TempMenuBar = new NavBar( $this->Viewer->viewerID, $this->Viewer->languageID );
			$MainMenuBar = '<a href="http://www.milonic.com/"></a><script>'.$TempMenuBar->DrawMainMenu().'</script>';
			$SubMenuBar = '<script>'.$TempMenuBar->DrawSubMenus().'</script>';
		} else {
			$MainMenuBar = "&nbsp;";
			$SubMenuBar = "";
		}
		
		$Temp = $SubMenuBar.'<table width="750" height="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
  <tr valign="top"> 
    <td width="750" height="113" colspan="5" valign="bottom" background="'.$this->PathToRootDir.$this->PageHeaderImage.'"><div align="left"> 
        <table width="100%" cellpadding="0" cellspacing="0">
		<tr><td width="1" ><img src="'.$this->PathToRootDir.'Images/space.gif" width="1" height="113"></td>
		<td><table width="100%" height="100%" border="0">
          <tr> 
            <td height="43" colspan="2" valign="top">&nbsp;</td>
          </tr>
          <tr> 
            <td height="44" colspan="2" valign="bottom" class="pageTitle"><div align="right">'.$this->PageMainTitle.'</div></td>
          </tr>
          <tr> 
            <td>'.$MainMenuBar.'</td>
            <td valign="top" ><div align="right">'.$LanguageMenu.'</div></td>
          </tr>
        </table>
		</td>
		</tr>
		</table>
        </div></td>
  </tr>
  <tr valign="top"> 
    <td width="1" bgcolor="223450"><img src="'.$this->PathToRootDir.'Images/space.gif" width="1" height="1"></td>';
	
		// Now determine if there is any Admin Content to display
		if ( $this->PageAdminColContent != '<null>' ) {
		
			// If so, display content column as 1 column
			$Temp .= '    <td width="'.(748 - $this->PageAdminColWidth).'">';
		
		} else {
		
			// Else Content column = 3 columns
			$Temp .= '    <td width="748" >';
		}
		
		$this->AddToDisplayList( $Temp );
		
	}

	
	
	//************************************************************************
	function BuildPostContent() {
		
		//$this->AddToDisplayList( "Post Content<br>\n" );
		$AdminContent = '&nbsp;';

		if ( $this->PageAdminColContent != '<null>' ) {
		
			
			$Temp = '</td>
    <td width="1" bgcolor="#223450"><img src="'.$this->PathToRootDir.'Images/space.gif" width="1" height="1"></td>
    <td width="'.$this->PageAdminColWidth.'" bgcolor="#EEEEEE"><table width="100%" border="0" cellspacing="10" cellpadding="10">
        <tr> 
          <td valign="top">'.$this->PageAdminColContent.'</td>
        </tr>
      </table>
      <p>&nbsp;</p></td>
    <td width="1" bgcolor="223450"><img src="'.$this->PathToRootDir.'Images/space.gif" width="1" height="1"></td>
  </tr>';
		
		} else {
		
			$Temp = '</td>
    <td width="1" bgcolor="223450"><img src="'.$this->PathToRootDir.'Images/space.gif" width="1" height="1"></td>
  </tr>';
		}
		
		$this->AddToDisplayList( $Temp );
		
		// Now add the Optional PageFooterContent
		if ($this->PageFooterContent != '<null>' ) {
		
			if ($this->PageAdminColContent == '<null>') {
				$Temp = '<tr valign="top">
		<td width="1" bgcolor="223450"><img src="../images/AIimages/space.gif" width="1" height="1"></td>
		<td height="35" valign="top">'.$this->PageFooterContent.'</td>
		<td width="1" bgcolor="223450"><img src="../images/AIimages/space.gif" width="1" height="1"></td>
	  </tr>';
	 		} else {
				$Temp = '<tr valign="top">
		<td width="1" bgcolor="223450"><img src="../images/AIimages/space.gif" width="1" height="1"></td>
		<td height="35" valign="top">'.$this->PageFooterContent.'</td>
		<td width="1" bgcolor="223450"><img src="../images/AIimages/space.gif" width="1" height="1"></td>
		<td width="298" bgcolor="#EEEEEE"><p>&nbsp;</p></td>
    	<td width="1" bgcolor="223450"><img src="'.$this->PathToRootDir.'Images/space.gif" width="1" height="1"></td>
	  </tr>'; 
			}
			$this->AddToDisplayList( $Temp );
			
		}
		
		
  		$Temp = '<tr valign="bottom" bgcolor="223450"> 
    <td height="25" colspan="5"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td width="10%" valign="bottom"><img src="'.$this->PathToRootDir.'Images/bl.jpg" width="6" height="6"></td>
          <td height="25" valign="middle"><table width="50%" border="0" align="center" cellpadding="5" cellspacing="2">
              <tr> 
                <td valign="middle" class="footer">&nbsp;</td>
              </tr>
            </table> </td>
          <td width="10%" height="100%" valign="bottom"><div align="right"><img src="'.$this->PathToRootDir.'Images/br.jpg" width="6" height="6"></div></td>
        </tr>
      </table></td>
  </tr>
</table>';

		$this->AddToDisplayList( $Temp );
	}
	

}

?>