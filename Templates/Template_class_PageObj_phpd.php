<?php
// Replace [ ]  with your own words. Pls remember to remove the braces '[ ]'
// For more information on how to use phpDocumentor. See http://www.phpdoc.org/docs/HTMLSmartyConverter/PHP
// Caution: Any line within a Documentation Block(aka: DocBlock) that doesn't begin with a * will be ignored.
/**
 * @package [packagename]
 */
/**
 * class PageObject
 *
 * This is a Display Object for displaying this page.
 *
 * @author [authorname]
 */
class  PageObject extends <Application>_Display {

	//CONSTANTS:
	/** [CLASS_CONSTANT description] */
    const CLASS_CONSTANT = '5566';

	//VARIABLES:
	/** @var [classvariable1 type] [optional description of classvariable1 ] */
	var $classvariable1;

	/** @var [classvariable2 type] [optional description of  classvariable2] */
	var $classvariable2;
	
	/** @var [STRING] The URL to use when submitting this form */
	var $callBack;				// The URL to use when submitting this form
	
	/** @var [STRING] The Viewer ID of this Page's viewer */	
	var $viewerID;				

	/** @var [STRING] The Language ID of this Page's Viewer*/	
	var $viewerLanguageID;		// 

	/**
	* The Access Level of this Page's Viewer.  This value is used
	* to determine what info this viewer is allowed to see on this page.
	* @var [STRING] 
	*/
	var $viewerAccessLevel;
								
	//**************************************************************
	// Add Additional Variables here for the operation of your Page.
	//**************************************************************
	
	/** @var [STRING] */
	var $ErrorMessages;
	
	/** @var [STRING] */
	var $ErrorWarning; 
	
	/** @var [STRING] General Messages that need to be displayed to the Viewer */
	var $Message;

	
	//
	//	CLASS CONSTRUCTOR
	//************************************************************************
	/**
	 * function PageObject
	 *
	 * @param $CallBack [$param1 type] [optional description of $param1]
	 * @param $ViewerID [$param2 type] [optional description of $param2]
	 * @param $ViewerLanguageID [$param2 type] [optional description of $param2]
	 * @param $ViewerAccessLv [$param2 type] [optional description of $param2]
	 */
	function PageObject( $CallBack, $ViewerID, $ViewerLanguageID, $ViewerAccessLv) {

		<Application>_Display::<Application>_Display($CallBack, $ViewerID, $ViewerLanguageID, $ViewerAccessLv);
			
		$this->pageName = 'NewApp';
		
		$this->DB->connectToDB();			// Created in the <Application>_Display class.
		
	}

//
//	CLASS FUNCTIONS:
//

	//************************************************************************
	/**
	 * function classFunctionTemplate
	 * <pre>
	 * [classFunctionTemplate Description]
	 * </pre>
	 * <pre><code>
	 * [Put PseudoCode Here]
	 * </code></pre>
	 * @param $param1 [$param1 type][optional description of $param1]
	 * @param $param2 [$param2 type][optional description of $param2]
	 * @return [returnValue, can be void]
	 */
		function classFunctionTemplate($param1, $param2) {
		// CODE
		}	
	

	
	
	//************************************************************************
	/**
	 * function loadFromDB
	 * <pre>
	 *	This function will pull the required info from the DB for this object's
	 *	variables.
	 * </pre>
	 */
	function loadFromDB() {

	}

	
	//************************************************************************
	/**
	 * function loadFromForm
	 * <pre>
	 *	This function will pull the required info from a submitted Form for
	 *	this object's variables.
	 * </pre>
	 */
	function loadFromForm() {		
		
	//	$this->RegionID		= $_REQUEST['RegionID'];

	}
	
	
	
	//************************************************************************
	/**
	 * function processData
	 * <pre><code>
	 * If there was a submitted form ...
	 *		if Data is valid
	 *          $this->DB->SetTableName( 'postapp' );
				
	 *          $Fields = array();
	 *          $Values = array();
				
	 *          $Fields[] = 'postapp_appdata';
	 *          $Values[] = "LOAD_FILE(\"$tempLocation\")";
				
	 *          $this->DB->SetFields( $Fields );
	 *          $this->DB->SetValues( $Values );
				
	 *          $this->DB->DBInsert();
	 *          Data was successfully loaded and Processed.
	 *     	else
	 *			Data is not Valid, so return FALSE
	 *		end if
	 * else
	 *		There was nothing to Process, so return FALSE
	 * end if	
	 * </code></pre>
	 */
	function processData() {
			
		// If there was a submitted form ...
		if ( isset( $_REQUEST['Process'] ) == true) {

			if ( $this->isDataValid() == true ) {
			
	//			$this->DB->SetTableName( 'postapp' );
				
	//			$Fields = array();
	//			$Values = array();
				
	//			$Fields[] = 'postapp_appdata';
	//			$Values[] = "LOAD_FILE(\"$tempLocation\")";
				
	//			$this->DB->SetFields( $Fields );
	//			$this->DB->SetValues( $Values );
				
	//			$this->DB->DBInsert();
	
				return true;		// Data was successfully loaded and Processed.
				
			} else {
				
				return false;		// Data is not Valid, so return FALSE
			}
			
		} else {
		
			return false;			// There was nothing to Process, so return FALSE
		}

	}

	
	
	//************************************************************************
	/**
	 * function isDataValid
	 * @return $Result [default = true]
	 */
	function isDataValid() {
	
		$Result = true;

		// If this was not from an Inactive Form ...
//		if ( isset( $_REQUEST['Inactive'] ) == false ) {

//		} // End if Not Inactive Form ...
		
		return $Result;
	}
	
	


	//************************************************************************
	/**
	 * function drawContent
	 * <pre>
	 *	Here we overwrite the Application_Display Class's DrawContent() so we can 
	 *	load the labels for this specific page, before we start drawing the page.
	 * </pre>
	 * <pre><code>
	 * - Get Proper Page Labels
	 * - Set Page Title Label
	 * </code></pre>
	 */
	function drawContent() {
	
		// Get Proper Page Labels
		$this->Labels = new MultiLingual_Labels( 'AI', '<Application>', 'PageName', $this->viewerLanguageID );
		
		// Set Page Title Label
		$this->pageTitle = $this->Labels->Label('[Title]');
		
		<Application>_Display::drawContent();		// Now call the Parent DrawContent();
	}
	
	

	//************************************************************************
	/**
	 * function drawPageContent
	 * <pre>
	 * This function actually puts the specific content of this page together.
	 * </pre>
	 */
	function drawPageContent() {		

//		if ( count( $this->ErrorMessages) > 0 ) {
//		
//			$this->AddToDisplayList('<p align="Left" class="error">'.$this->ErrorWarning.'</p>');
//		
//		}

		$MultiLingualLists = new MultiLingual_Lists( 'AI', 'Interviews', $this->ViewerLanguageID);
		
		$this->AddToDisplayList('<p class="text">'.$this->Labels->Label('[Desc]').'</p>');
		
		$this->AddToDisplayList('<input name="Process" type="hidden" id="Process" value="true">');

		$BGColor = ' bgcolor="#EEEEEE" ';

		$NumCols = 2;					// There are 2 standard columns for this view
		
		$OutputTable = new Table ( $NumCols, ' border="0" cellpadding="3" cellspacing="3" width="100%" ');
		
		// Date Entry
		$OutputTable->AddTableCell( $this->Labels->Label('[Date]'), $BGColor.' class="text" ' );
		
		$this->AddToDisplayList( $OutputTable, DISPLAYOBJECT_TYPE_OBJECT);

		$RestOfHTML = '<hr width="100%" size="1" noshade color="#223450"><span align="left"><a href="'.$this->CallbackDisplay.'"><span class="modify">'.$this->Labels->Label('[ReturnInterviews]').'</span></a></span><span align="center"><p class="text"> <input type="submit" value="'.$this->Labels->Label('[Add]').'" /></p></span>';
		$this->AddToDisplayList( $RestOfHTML );
		
				 
	}



}

?>