<?php
// Replace [ ]  with your own words. Pls remember to remove the braces '[ ]'
// For more information on how to use phpDocumentor. See http://www.phpdoc.org/docs/HTMLSmartyConverter/PHP
// Caution: Any line within a Documentation Block(aka: DocBlock) that doesn't begin with a * will be ignored.

/**
 * @package [packagename]
 */
/**
 * class <Application>_DB
 * <pre> 
 *		This is the <Application>'s Database Object.  It handles the DB connection 
 *		the DB it works with.
 *
 *		Since most of the Applications we work with use the MYSQL DB, this example
 *		is based upon that. 
 *
 *		In this example, all you need to do is rename the Name of the DB you use
 *		in the connectToDB() function.
 * </pre>
 * @author [authorname]
 */
class  <Application>_DB extends Database_MySQL {

	//CONSTANTS:
	/** [CLASS_CONSTANT description] */
    const CLASS_CONSTANT = '5566';

	//VARIABLES:
	/** @var [classvariable1 type] [optional description of classvariable1 ] */
	var $classvariable1;

	/** @var [classvariable2 type] [optional description of  classvariable2] */
	var $classvariable2;


	//
	//	CLASS CONSTRUCTOR
	//************************************************************************
	/**
	 * function <Application>_DB
	 * <pre>
	 * [<Application>_DB Description]
	 * </pre>
	 * <pre><code>
	 * [Put PseudoCode Here]
	 * </code></pre>
	 * @param $param1 [$param1 type][optional description of $param1]
	 * @param $param2 [$param2 type][optional description of $param2]
	 * @return [returnValue, can be void]
	 */
	function <Application>_DB() {
	
		Database_MySQL::Database_MySQL();

	}

	//
	//	CLASS FUNCTIONS:
	//************************************************************************
	/**
	 * function connectToDB
	 */
	function connectToDB() {
	
		Database_MySQL::ConnectToDB( '<ApplicationDatabaseName>', DB_PATH, DB_USER, DB_PWORD);
	
	}

}



/**
 * @package [packagename]
 * class <Application>_Display
 * <pre> 
 * This is a Generic <Application> object. It handles connecting to the DB, as well as 
 * providing some common Page display routines.
 * </pre>
 * @author [authorname]
 */
class  <Application>_Display extends DisplayObject {

	//CONSTANTS:
	/** [CLASS_CONSTANT description] */
    const CLASS_CONSTANT = '5566';

	//VARIABLES:
	/** @var [STRING] The Viewer's Unique ID for the Web Site. */
	var $viewerID; 
	
	/** @var [STRING] The Viewer's Prefered Language  */
	var $viewerLanguageID; 
	
	/** @var [STRING] The Viewer's Access Priviledge Level. */
	var $viewerAccessLv;
	
	/** @var [STRING] The Viewer's Unique ID for the Web Site. */
	var $callBack;				
	
	/** @var [STRING] The page Title.  Usually displayed at the top of the page. */
	var $pageTitle; 
	
	/** @var [STRING] The URL for the form included on this page. */
	var $formAction;
	
	/** @var [BOOLEAN] Do we include the Form Tag on this page (default = True) */
	var $isFormIncluded;
	
	/** @var [STRING] A common DB object for use in all the pages of this application. */
	var $DB;
	
	/** @var [BOOLEAN] Has the DB been initialized? */
	var $isDBInitialized;
	
//
//	CLASS CONSTRUCTOR
//

	//************************************************************************
	/**
	 * function <Application>_Display
	 *
	 * @param $CallBack [STRING]
	 * @param $ViewerID [STRING]
	 * @param $ViewerLanguageID [INT]
	 * @param $ViewerAccessLv [INT]
	 * @return void
	 */
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
	//************************************************************************
	/**
	 * function exampleFn
	 */
	function exampleFn() {
	
	
	}



	//************************************************************************
	/**
	 * function classFunction
	 * <pre>
	 * [classFunction Description]
	 * </pre>
	 * <pre><code>
	 * [Put PseudoCode Here]
	 * </code></pre>
	 * @param $param1 [$param1 type][optional description of $param1]
	 * @param $param2 [$param2 type][optional description of $param2]
	 * @return [returnValue, can be void]
	 */
		function classFunction($param1, $param2) {
		// CODE
		}
			
	//************************************************************************
	/**
	 * function prepareContent
	 * <pre>
	 *	Drawing the common display outline for this series of pages.  This routine
	 *	generally set's the common layout (Title, Picture, format, etc...) for
	 *	your application's look and feel.
	 *
	 * This routine is called by the $this->drawContent() function.
	 * </pre>
	 */
	function prepareContent() {
	
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
	/**
	 * function drawPageContent
	 * <pre>
	 * This function is called by the PrepareContent() function.
	 * </pre>
	 */
	function drawPageContent() {

		 $this->AddToDisplayList('class_<Application>::DrawPageContent Has not been Implemented');
		 
	}
	
	//************************************************************************
	/**
	 * function drawContent
	 */
	function drawContent() {
	
		$this->prepareContent();
			 
	}
	
	
	//************************************************************************
	/**
	 * function DrawDirect
	 */
	function DrawDirect() {
	
		$this->drawContent();
		
		DisplayObject::DrawDirect();
	
	}
	
	
	//************************************************************************
	/**
	 * function Draw
	 */
	function Draw() {
	
		$this->drawContent();
		
		return DisplayObject::Draw();
	
	}

}





?>