<?php
require("../General/gen_Includes.php");
require("class_<Application>.php");



//
// CONSTANTS
//
define('THIS_MODE', 'M');
define('THIS_MODE_DISPLAY', 'D');
define('THIS_MODE_ALUMNI', 'AL');


//
// VARIABLES
//
$ThisMode = '<null>';				// STRING	The passed Mode of the page. Display/New/Review
$ThisPageObject = '<null>';			// OBJECT	The page object that will be Loaded, Processed, and Displayed.			
$ThisViewerAccessLevel = '<null>';	// OBJECT	The Viewer's access Level

//
// PAGE PROCESSING
//
$ThisPage = new AIWebPage( 'HRDB_Admin.php', 'HRDB/' );

//A specific property of AIWebPage is the PageHeaderImage. The default is the 
//image without the AsiaImpact. (= RootDir/Images/AIHead2.jpg)  Setting it to 
//AIHead.jpg will display the Home Logo.
//$ThisPage->PageHeaderImage = 'Images/AIhead.jpg';


$ThisPage->Start();			// Control has now passed to the $ThisPage object.  It will call the 
							// This_LoadData(), This_ProcessData(), and This_DisplayData() functions.


//
// DEFINE REQUIRED FUNCTIONS
//
//	"This_LoadData()", "This_ProcessData()", and "This_DisplayData()" 
//	are required functions when using the above Page->Start() processing
//	routines


function This_LoadData() {
//
//	DESCRIPTION:
//		Use this function to load all the data you will need to use in processing
//		your page.  This is a good place to read in your Form Data, Data from 
//		your Databases, initialize your class variables, etc...
//
	global $ThisPage;		//	make sure the Page Variable is available in this function.
	global $ThisMode;
	global $ThisPageObject;
	global $ThisViewerAccessLevel;

	
	//
	//	Read In QueryString Variables
	//
	$ThisMode = QueryString_LoadValue( THIS_MODE, THIS_MODE_DISPLAY);

	//
	//	Get Viewer's Access Level
	//
//	$ThisViewerAccessLevel = new AccessLevel( $ThisPage->Viewer->ViewerID );
	
	
	switch( $ThisMode ) {
			
		case THIS_MODE_DISPLAY:
			$ThisPageObject = new AdminWelcome();
			break;
			
		case THIS_MODE_ALUMNI:
			$ThisPageObject = new <Application>( This_CallBack( $ThisMode ), $ThisPage->Viewer->ViewerID, $ThisPage->Viewer->LanguageID, $ThisViewerAccessLevel->accessLevel);
			$ThisPageObject->LoadFromDB();
			break;
		
	}
	
	
	// Now if there has been a form submittal, load data from the Form ...
	if ( isset( $_REQUEST['Process'] ) == true ) {
				
		$ThisPageObject->loadFromForm();				
	}


}


function This_ProcessData() {
//
//	DESCRIPTION:
//		Use this function to process the main operation of your page.  It does all
//		the necessary business logic to prepare you for the drawing stage.
//
	global $ThisPage;
	global $ThisMode;
	global $ThisPageObject;
	global $ThisViewerAccessLevel;
	

	// If this call was from a Form Submit
	if ( isset( $_REQUEST['Process'] ) == true ) {
		
		//If this is processed successfully ...
		if ( $ThisPageObject->ProcessData() == true) {
		
			//	For pages that are not the Display List, set them to the Display List..
/*			if ( $ThisMode != THIS_MODE_DISPLAY ) {
			
				//	Set Mode back to DISPLAY
				$ThisMode = THIS_MODE_DISPLAY;
				
				// Now Set ThisPageObject to the Applications Object
				$ThisPageObject = new <Application>( This_CallBack( THIS_MODE_DISPLAY ), $ThisPage->Viewer->ViewerID, $ThisPage->Viewer->LanguageID, $ThisViewerAccessLevel->accessLevel);
				$ThisPageObject->loadFromDB();

			}
*/
			
		} //END IF				
	}
	
}


function This_DisplayData() {
//
//	DESCRIPTION:
//		Use this function to create the resulting page for the user to view.
//
	global $ThisPage;
	global $ThisMode;
	global $ThisPageObject;

	$ThisLabels = new MultiLingual_Labels( 'AI', 'HRDBAdmin', 'Main', $ThisPage->Viewer->LanguageID );
	$ThisPage->PageMainTitle = $ThisLabels->Label('[Title]');
	
//	$ThisPage->PageAdminColContent = This_DrawAdminColumn( $ThisLabels );
//	$ThisPage->PageAdminColWidth='100';
			
	$ThisPage->AddStyle('Site');
	$ThisPage->AddStyle('hrdb');

	// On all these pages, if we don't want the default Form Wrapper uncomment this line
	//$ThisPageObject->InterviewsAddForm = false;
	
	return $ThisPageObject;
}


//
//  SUPPORT FUNCTIONS HERE
//
//	Fill in all the support functions you need to make this
//	page properly operate here.
//



function This_CallBack( $Mode='<null>') {

	$Temp = '';
	
	if ( ($Mode != '<null>') && ($Mode != '') ) {
		$Temp = THIS_MODE.'='.$Mode;
	}
	
	
	$Temp = '<Application>.php?'.$Temp;
	
	
	return $Temp;
}


function This_FnTemplate() {

	$CurrTable = new Table(1);
	
	return $CurrTable;
}

?>
