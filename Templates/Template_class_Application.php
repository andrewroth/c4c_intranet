<?php


class  <Application>_DB extends Database_MySQL {
// 
//  DESCRIPTION:
//		This is the <Application>'s Database Object.  It handles the DB connection 
//		the DB it works with.
//
//		Since most of the Applications we work with use the MYSQL DB, this example
//		is based upon that. 
//
//		In this example, all you need to do is rename the Name of the DB you use
//		in the connectToDB() function.
//
//	CONSTANTS:

//
//	VARIABLES:

//
//	CLASS CONSTRUCTOR
//

	//************************************************************************
	function <Application>_DB() {
	
		Database_MySQL::Database_MySQL();

	}

//
//	CLASS FUNCTIONS:
//
	
	//************************************************************************
	function connectToDB() {
	
		Database_MySQL::ConnectToDB( '<ApplicationDatabaseName>', DB_PATH, DB_USER, DB_PWORD);
	
	}

}




class  <Application>_Display extends DisplayObject {
// 
//  DESCRIPTION:
//		This is a Generic <Application> object. It handles connecting to the DB, as well as 
//		providing some common Page display routines.
//
//	CONSTANTS:

//
//	VARIABLES:
	var $viewerID;				// The Viewer's Unique ID for the Web Site.
	var $viewerLanguageID;		// The Viewer's Prefered Language 
	var $viewerAccessLv;		// The Viewer's Access Priviledge Level.
	var $callBack;				
	
	var $pageTitle;				// The page Title.  Usually displayed at the top of the page.
	var $formAction;			// The URL for the form included on this page.
	var $isFormIncluded;		// BOOLEAN: Do we include the Form Tag on this page (default = True)
	
	var $DB;					// A common DB object for use in all the pages of this application.
	var $isDBInitialized;		// BOOLEAN: Has the DB been initialized?
	
//
//	CLASS CONSTRUCTOR
//

	//************************************************************************
	function <Application>_Display($CallBack, $ViewerID, $ViewerLanguageID, $ViewerAccessLv) {
		$this->callBack 		= $CallBack;
		$this->viewerID 		= $ViewerID;
		$this->viewerLanguageID = $ViewerLanguageID;
		$this->viewerAccessLv 	= $ViewerAccessLv;
		
		DisplayObject::DisplayObject();
		
		$this->pageTitle = 'Forgot to set the Title';
		$this->formAction = $CallBack;
		
		$this->isFormIncluded = true;
		
		$this->DB = new <Application>_DB();
		$this->isDBInitialized = false;
		
	}

//
//	CLASS FUNCTIONS:
//

	//************************************************************************
	function exampleFn() {
	
	
	}



	//************************************************************************
	function prepareContent() {
	// 
	//  DESCRIPTION:
	//	Drawing the common display outline for this series of pages.  This routine
	//	generally set's the common layout (Title, Picture, format, etc...) for
	//	your application's look and feel.
	//
	//	This routine is called by the $this->drawContent() function.
	//
		
		if ($this->isFormIncluded == true ) {
			$this->AddToDisplayList( '<form name="Form" method="post" action="'.$this->formAction.'">' );
		}
		
		// Add The Pre Title HTML
		$this->AddToDisplayList(
		'<table width="100%" border="0" cellpadding="6" cellspacing="6">
        <tr> 
          <td height="30" valign="top">
		    <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr> 
                <td valign="baseline"><span class="heading">');
		
		// Add The Title
		$this->AddToDisplayList( $this->pageTitle );
		
		// Add the Post Title-Pre Content HTML
		$this->AddToDisplayList('</span></td>
                
              </tr>
            </table>
            <hr width="100%" size="1" noshade color="#223450"> </td>
        </tr>
        <tr> 
          <td valign="top">' );
		 
		 // Now Call the Individual Page Content Drawing Routine 
		 $this->drawPageContent();
		 
		 // Now Add The Post Page Content HTML
		 $this->AddToDisplayList('</td>
          </tr></table>');
		  
		if ($this->isFormIncluded == true ) {
			$this->AddToDisplayList( '</form>' );
		}
	
	}	


	
	
	//************************************************************************
	function drawPageContent() {
	// 
	//	This function is called by the PrepareContent() function.
	//
		 $this->AddToDisplayList('class_<Application>::DrawPageContent Has not been Implemented');
		 
	}
	
	//************************************************************************
	function drawContent() {
	
		$this->prepareContent();
			 
	}
	
	
	//************************************************************************
	function DrawDirect() {
	
		$this->drawContent();
		
		DisplayObject::DrawDirect();
	
	}
	
	
	//************************************************************************
	function Draw() {
	
		$this->drawContent();
		
		return DisplayObject::Draw();
	
	}

}





?>