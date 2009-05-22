<?php


class  OldPage extends DisplayObject {
// 
//  DESCRIPTION:
//		This class handles Page creation, control, and display back to the 
//		client.  It is intended to assume control of the Page's operation
//		and will in turn call the Calling Page's LoadData(), ProcessData()
//		and DisplayData() routines.
//		
//
//	CONSTANTS:

//
//	VARIABLES:
	var $Viewer;			//  The data related to the Viewer of the page.
	
	var $PathToRootDir;		//	The path from this page to the Root Directory.
	var $PathFromRootDir;	//	The path from the Root Dir to this page.
	var $PageName;			//	The File Name of this php page.
	
	var $PageTitle;			//	The Title of this HTML Page.
	var $PageBackgroundImage;	//	The Desired Background Image for this page.
	var $BodyParameters;	//  Additional Body Tag Parameters.
	var $CharacterSet;
	var $PageCallback;		//  The Callback string for the Language Changing Options.
	
	var $Styles;
	var $JScripts;
	var $OnLoadEvents;
	
//
//	CLASS CONSTRUCTOR
//

	//************************************************************************
	function OldPage( $LocalPageName='<null>', $PathFromRoot='', $PathToRoot='../', $PageTitle='Untitled Document') {
		
		$this->Viewer = &new Viewer( );
		
		if ( $this->Viewer->isAuthenticated() == False) {
			
			$this->Redirect("{$PathToRoot}Login/Login.php?M=D&CP={$PathFromRoot}{$LocalPageName}");
		
		} else {
		
			$this->PageName 		= $LocalPageName;
			$this->PathFromRootDir 	= $PathFromRoot;
			$this->PathToRootDir	= $PathToRoot;
			
			$this->PageTitle 		= $PageTitle;
			$this->PageBackgroundImage = "<null>";
			$this->BodyParameters	= "<null>";
			$this->CharacterSet 	= "iso-8859-1";
			
			
			$this->Styles			= array();
			$this->JScripts			= array();
			$this->OnLoadEvents		= array();
			
			DisplayObject::DisplayObject();  //  Call the parent Object's Constructor
		
			// Check to see if there was a Language Change requested on current page:
			if ( isset( $_REQUEST[ SESSION_ID_LANG ] ) == true ) {
				$_SESSION[ SESSION_ID_LANG ] = $_REQUEST[ SESSION_ID_LANG ];
			}
			
			
			// Now check to see if there is a current Language setting in the stored session info
			if (isset( $_SESSION[ SESSION_ID_LANG ] ) ) {
				$this->Viewer->LanguageID = $_SESSION[ SESSION_ID_LANG ];
			}
		}
	
	}

//
//	CLASS FUNCTIONS:
//

	//************************************************************************
	function TemplateName() {
	
	
	}
	
	
	//************************************************************************
	function Redirect( $Destination) {
	
		header( "Location:".$Destination );
		exit;
	}
	
	
	//************************************************************************
	function Start() {
	
		// Initialize any General Modules here (ie ErrorReporting, etc...)
	
		// Now call the 3 User defined Routines to process their page ...
		This_LoadData();
		This_ProcessData();
		
		$Result = This_DisplayData();
		
		
		// Now Begin the process of putting together the Page itself ...
		$this->BuildPageHeader();
		$this->BuildBodyTag();
		$this->BuildPreContent();
		
		$this->AddToDisplayList( $Result, DISPLAYOBJECT_TYPE_OBJECT);
		
		$this->BuildPostContent();
		$this->ClosePage();
		
		// Return contents of Page to Browser
		$this->DrawDirect();
		
		// Flush output
		ob_end_flush();
	}
	
	
	//************************************************************************
	function BuildPageHeader() {
		
		$this->AddToDisplayList( "<html>\n" );
		$this->AddToDisplayList( "<head>\n" );
		$this->AddToDisplayList( "<title>$this->PageTitle</title>\n" );
		$this->AddToDisplayList( '<meta http-equiv="Content-Type" content="text/html; charset='.$this->CharacterSet.'">' ); 
		$this->AddToDisplayList( "\n" ); 
		$this->AddToDisplayList( "<script>
	// The following variable is used in the milonic menu scripts to properly
	// find the path to the other menu scripts to include.
	aiPathToRoot='".$this->PathToRootDir."';
    </script>" ); 
		$this->InsertStyles();
		$this->InsertJScripts();
		$this->AddToDisplayList( "</head>\n\n" );
	}
	
	
	
	//************************************************************************
	function BuildBodyTag() {
		
		$this->AddToDisplayList( "<body " );
		
		//  Add Requested Background Image
		if ( $this->PageBackgroundImage != '<null>' ) {
			$this->AddToDisplayList( "background=\"$this->PageBackgroundImage\"");	
		}
		
		//  Add any OnLoad Events ....
		if (count( $this->OnLoadEvents ) > 0 ) {
		
			$this->AddToDisplayList( ' onLoad="' );
			
			for ( $Indx=0; $Indx< count($this->OnLoadEvents); $Indx++) {
				
				$this->AddToDisplayList( $this->OnLoadEvents[ $Indx ].";" );
			}
			$this->AddToDisplayList( '" ' );
		}
		
		if ( $this->BodyParameters != "<null>" ) {
			$this->AddToDisplayList( $this->BodyParameters );
		}
		
		//  Close the Body Tag
		$this->AddToDisplayList( " >\n" );
	}
	
	
	
	//************************************************************************
	function BuildPreContent() {
		
		//$this->AddToDisplayList( "PreContent:<br>\n" );

	}
		
	
	
	//************************************************************************
	function BuildPostContent() {
		
		//$this->AddToDisplayList( "Post Content<br>\n" );

	}
	
	
	//************************************************************************
	function ClosePage() {
	
		$this->AddToDisplayList( "\n</body>\n</html>" );
	}
	
	
	
	//************************************************************************
	function InsertStyles() {
	
		for ( $Indx = 0; $Indx < count( $this->Styles ); $Indx++ ) {
			
			$this->AddToDisplayList( "<link href=\"{$this->PathToRootDir}Data/CSS/{$this->Styles[$Indx]}.css\" rel=\"stylesheet\" type=\"text/css\">\n" );
		
		}
	}
	
	
	
	//************************************************************************
	function InsertJScripts() {
	
		for ( $Indx = 0; $Indx < count( $this->JScripts ); $Indx++ ) {
			
			$this->AddToDisplayList( "<script language=\"JavaScript\" src=\"{$this->PathToRootDir}Data/SCRIPTS/JScript/{$this->JScripts[$Indx]}.jsp\" type=\"text/javascript\"></script>\n" );
		
		}
	}
	
	
	
	//************************************************************************
	function AddStyle( $StyleFileName='<null>') {
	//
	//	StyleFileName :  should only be the name of the File.  No path and no
	//					 .css should be added to it's name (that gets added
	//					 later).
	//
	
		if ($StyleFileName != '<null>' ) {
		
			if ( in_array( $StyleFileName, $this->Styles) == FALSE ) {

// In Future, Add some error checking here to make sure File Exists...
			
				$this->Styles[] = $StyleFileName;
			
			}
		}
	}
	
	
	//************************************************************************
	function AddJScript( $ScriptFileName='<null>') {
	
		if ($ScriptFileName != '<null>' ) {
		
			if ( in_array( $ScriptFileName, $this->JScripts) == FALSE ) {

// In Future, Add some error checking here to make sure File Exists...
			
				$this->JScripts[] = $ScriptFileName;
			
				// Here we Handle Scripts with special requirements
				switch( $ScriptFileName ) {		
					
					//  The following SCRIPTS require the "MM_findObj" script
					case "Haus_ConvertListBoxToList":
					case "Haus_ReorderListBox":
							$this->AddJScript("MM_findObj");
							break;
					
					//  The following Scripts require special OnLoadEvents to operate
					case "Haus_AnniversaryCheck":
							$this->AddOnLoadEvent("Haus_AnniversaryCheck()");
							break;
							
					case "Camp_EndDateCheck":
							$this->AddOnLoadEvent("Camp_EndDateCheck()");
							break;
					
					case "Camp_ProcessMPTADetail":
							$this->AddOnLoadEvent("initDistrictandCountyLists()");
							break;
				}			
			}
		}
	}
	
	
	
	//************************************************************************
	function AddOnLoadEvent( $Event='<null>') {
	
		if ($Event != '<null>' ) {
		
			if ( in_array( $Event, $this->OnLoadEvents) == FALSE ) {
			
				$this->OnLoadEvents[] = $Event;
			
			}
		}
	}
}






class  NullPage extends OldPage {
// 
//  DESCRIPTION:
//		This page object creates a blank page object.  It doesn't create any output to send
//		back to the browser, except for the data returned by the This_DisplayData() function.
//
//		This is useful for Excell Files returned to the browser.
//		
//
//	CONSTANTS:

//
//	VARIABLES:

	
//
//	CLASS CONSTRUCTOR
//

	//************************************************************************
	function NullPage( $LocalPageName='<null>', $PathFromRoot='', $PathToRoot='../', $PageTitle='Untitled Document') {
		
		
		OldPage::OldPage( $LocalPageName, $PathFromRoot, $PathToRoot, $PageTitle);
			
	}

//
//	CLASS FUNCTIONS:
//	
	
	//************************************************************************
	function BuildPageHeader() {
		
	}
	
	
	
	//************************************************************************
	function BuildBodyTag() {
		

	}
	
	
	
	//************************************************************************
	function BuildPreContent() {
		
		//$this->AddToDisplayList( "PreContent:<br>\n" );

	}
		
	
	
	//************************************************************************
	function BuildPostContent() {
		
		//$this->AddToDisplayList( "Post Content<br>\n" );

	}
	
	
	//************************************************************************
	function ClosePage() {

	}
	
	
	
}





?>