<?php


class  Page_v1 extends Page {
// 
//  DESCRIPTION:
//		This is a Page Object to draw your page as they are drawn on Version 1
//		of the AI Web Site.
//
//	CONSTANTS:

//
//	VARIABLES:
	var $TitleImage;
	
//
//	CLASS CONSTRUCTOR
//

	//************************************************************************
	function Page_v1( $LocalPageName='<null>', $PathFromRoot='', $PathToRoot='../', $PageTitle='Untitled Document') {
	
		$this->Viewer = &new Viewer( );
		
		if ( $this->Viewer->IsAuthenticated == False) {
			
			$this->Redirect("{$PathToRoot}Authenticate.php?CP={$PathFromRoot}{$LocalPageName}");
		
		} else {
		
			$this->PageName 		= $LocalPageName;
			$this->PathFromRootDir 	= $PathFromRoot;
			$this->PathToRootDir	= $PathToRoot;
			
			$this->PageTitle 		= $PageTitle;
			$this->PageBackgroundImage = "{$PathToRoot}../Pages/Images/Gen_bkg.gif";
			$this->BodyParameters	= 'vlink="#660000" alink="#660000" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" ';
			$this->TitleImage		= 'Images/ttl_Current.gif';
			$this->Styles			= array();
			$this->JScripts			= array();
			$this->OnLoadEvents		= array();
			
			DisplayObject::DisplayObject();  //  Call the parent Object's Constructor
		
			$this->AddStyle( 'Reports' );
			$this->AddStyle( 'Section' );
			$this->AddStyle( 'Subscriptions' );
		}
	}

//
//	CLASS FUNCTIONS:
//

	//************************************************************************
	function TemplateName() {
	
	
	}
	
	//************************************************************************
	function BuildPreContent() {
		
		$PreContent = "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
  <tr> 
    <td width=\"30\">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr> 
    <td colspan=\"2\"><img src=\"{$this->TitleImage}\" width=\"200\" height=\"42\"></td>
  </tr>
  <tr> 
    <td width=\"30\">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr> 
    <td width=\"30\">&nbsp;</td>
    <td>";
		$this->AddToDisplayList( $PreContent );

	}
	
	
	//************************************************************************
	function BuildPostContent() {
		
		$PostContent = '</td>
  </tr>
</table>';
		$this->AddToDisplayList( $PostContent );

	}
	

}






?>