<?php 
ob_start( "ob_gzhandler");  //  Start Output Buffering.
		// We turn on Output buffering to allow us the ability to
		// Redirect the user to another page if needed.
		//
		// Also, we set the "ob_gzhandler" as the buffer handler to enable
		// the ability to compress the output and then send it to the users.
		
//		
// Gen Includes
//
//	This file includes the standard classes and tools used to make our pages.
//
error_reporting( E_ALL);

define( 'GEN_INCLUDES', true );

function LoadLibrary( $LibName, $LibType="Classes" ) {

	$LibFileName = $LibType."/".$LibName.".php";
	
	// Attempt to find proper directory from current page to Root ...
	$numAttempts = 0;
	while ( (!file_exists($LibFileName)) && ( $numAttempts < 6) ) {
		
		$LibFileName = '../'.$LibFileName;
		$numAttempts++;
	}
		
	//check if file exists...
	if (file_exists($LibFileName)) {
	
		// load library
		require_once($LibFileName);
		return TRUE;
	}
	else {
		
		// print error!
		die ("Could not load $LibType $LibName [$LibFileName].\n");
	}
}
/*
// CAS.php defines some global variables.
// Requires the PEAR DB library
if (!class_exists( 'phpCAS' )) {
    LoadLibrary( 'CAS', 'Tools/CAS' );
}*/

/*
// CAS.php defines some global variables.
// Requires the PEAR DB library
if (!class_exists( 'phpCAS' )) {
    LoadLibrary( 'CAS', 'Tools/CAS' );
}
*/

//GCX Authentication
LoadLibrary("CAS", "Tools/CAS");

//  Load General Definitions
LoadLibrary("gen_Defines", "General");
LoadLibrary("gen_CodeProfiler", "General");

//  Load Site Objects
LoadLibrary("CASUser", "objects");
LoadLibrary("SiteObject","objects");
LoadLibrary("Viewer","objects");
LoadLibrary("OldSiteViewer", "objects");

LoadLibrary("Database", "objects");
LoadLibrary("XMLObject", "objects");
LoadLibrary("AppController", "objects");
LoadLibrary("XMLObject_PageContent", "objects");
LoadLibrary("XMLObject_Menu", "objects" );
LoadLibrary("Page", "objects" );
LoadLibrary("Template", "objects" );
LoadLibrary("XMLObject_CMSApps", "objects" );
LoadLibrary("XMLObject_CMSPageApp", "objects" );
LoadLibrary("CMSPages", "objects" );
LoadLibrary("HTMLBlock", "objects" );
LoadLibrary("SystemAccess", 'objects' );

LoadLibrary("FormHelper", "objects");

// NOTE: in process of refactoring and removeing these
LoadLibrary("XMLObject_MultilingualManager", "objects" );
LoadLibrary("XMLObject_Multilingual_Translation", "objects" );
LoadLibrary("XMLObject_Multilingual_Label", "objects" );
LoadLibrary("XMLObject_Multilingual_Page", "objects" );
LoadLibrary("XMLObject_Multilingual_Series", "objects" );

LoadLibrary("XMLObject_FormItem", "objects" );
LoadLibrary("XMLObject_AdminBox", "objects" );
LoadLibrary("XMLObject_RowList", "objects" );
LoadLibrary("XMLObject_ColumnList", "objects" );
LoadLibrary("TableManagerSingle", "objects" );
LoadLibrary("PerlFileUpload", "objects" );
LoadLibrary("FileObject", "objects" );
LoadLibrary("PopUpManager", "objects" );

// DataAccessManager objects
LoadLibrary("DataAccessManager", "objects");
LoadLibrary("RowManager", "objects/DataAccessManager" );
LoadLibrary("ListIterator", "objects/DataAccessManager" );
LoadLibrary("MultiTableManager", "objects/DataAccessManager");
LoadLibrary("RowLabelBridge", "objects/DataAccessManager" );
LoadLibrary("JoinPair", "objects/DataAccessManager");
LoadLibrary("TempTableManager", "objects/DataAccessManager");

// Objects Dependent On RowManager Class:
LoadLibrary("ModuleManager","objects");
LoadLibrary("LabelList", "objects/Multilingual" );
LoadLibrary("LabelManager", "objects/Multilingual" );
LoadLibrary("PageList", "objects/Multilingual" );
LoadLibrary("PageManager", "objects/Multilingual" );
LoadLibrary("SeriesList", "objects/Multilingual" );
LoadLibrary("SeriesManager", "objects/Multilingual" );
LoadLibrary("MultilingualManager", "objects/Multilingual" );
LoadLibrary( "xLationManager", "objects/Multilingual" );

// PDF Creation Objects
LoadLibrary("PDF", "objects/PDF_Templates" );
LoadLibrary("PDF_Template_Table", "objects/PDF_Templates" );
LoadLibrary("PDF_Template_Charts", "objects/PDF_Templates" );

// site_AccountAdmin objects available to all modules
LoadLibrary( "AccountGroupManager", "modules/site_AccountAdmin/objects_da" );
LoadLibrary("ViewerManager","modules/site_AccountAdmin/objects_da");
LoadLibrary( "LanguageManager", "modules/site_AccountAdmin/objects_da" );
LoadLibrary( "LanguageList", "modules/site_AccountAdmin/objects_da" );
LoadLibrary( "AccessGroupManager", "modules/site_AccountAdmin/objects_da" );
LoadLibrary( "ViewerAccessGroupManager", "modules/site_AccountAdmin/objects_da" );

// site_NavBar objects available to all modules
LoadLibrary( "NavBarCacheManager", "modules/site_NavBar/objects_da" );
//LoadLibrary( "NavBarLinksManager", "modules/site_NavBar/objects_da" );
//LoadLibrary( "NavLinkViewerManager", "modules/site_NavBar/objects_da" );

// CIM stuff available to all modules
LoadLibrary( "CampusManager", "modules/app_cim_hrdb/objects_da" );
LoadLibrary( "AssignmentsManager", "modules/app_cim_hrdb/objects_da" );
LoadLibrary( "EditCampusAssignmentManager", "modules/app_cim_hrdb/objects_da" );
LoadLibrary( "StaffManager", "modules/app_cim_hrdb/objects_da" );
LoadLibrary( "PersonManager", "modules/app_cim_hrdb/objects_da" );
LoadLibrary( "CountryManager", "modules/app_cim_hrdb/objects_da" );
LoadLibrary( "RegionManager", "modules/app_cim_hrdb/objects_da" );
LoadLibrary( "MinistryManager", "modules/app_cim_hrdb/objects_da" );
LoadLibrary( "EventManager", "modules/app_cim_reg/objects_da" );
LoadLibrary( "RegistrationManager", "modules/app_cim_reg/objects_da" );
LoadLibrary( "StatusManager", "modules/app_cim_reg/objects_da" );
LoadLibrary( "AccessManager", "modules/app_cim_hrdb/objects_da" );
LoadLibrary( "EventAdminCampusAssignmentManager", "modules/app_cim_reg/objects_da" ); // added by Russ to make hrdb work
LoadLibrary( "app_cim_reg", "modules/app_cim_reg" );	// used by HRDB to access Reg Sys. pages

// used for database cleanup
LoadLibrary( "EmergencyInfoManager", "modules/app_cim_hrdb/objects_da" );
LoadLibrary( "PersonYearManager", "modules/app_cim_hrdb/objects_da" );
LoadLibrary( "app_cim_sch", "modules/app_cim_sch" );	// used by HRDB to access Scheduler table interface objects
LoadLibrary( "PersonDGManager", "modules/app_cim_sch/objects_da" );
LoadLibrary( "ScheduleManager", "modules/app_cim_sch/objects_da" );

// used for Delete Person (in HRDB);
LoadLibrary( "CashTransactionManager", "modules/app_cim_reg/objects_da" );
LoadLibrary( "CreditCardTransactionManager", "modules/app_cim_reg/objects_da" );
LoadLibrary( "ReceiptManager", "modules/app_cim_reg/objects_da" );
LoadLibrary( "ScholarshipAssignmentManager", "modules/app_cim_reg/objects_da" );
LoadLibrary( "FieldValueManager", "modules/app_cim_reg/objects_da" );


// common data and field types
LoadLibrary( "DataTypeManager", "modules/app_cim_reg/objects_da" );
LoadLibrary( "FieldTypeManager", "modules/app_cim_reg/objects_da" );


LoadLibrary("ReadOnlyResultSet", "objects" );

// NOTE: FormProcessor has been replaced by PageDisplay, 
// PageDisplay_FormProcessor. Objects based upon FormProcessor need to be
// upgraded to use PageDisplay_FormProcessor.
//LoadLibrary("FormProcessor", "objects" );


LoadLibrary("PageDisplay", "objects" );
LoadLibrary("FormProcessor", "objects/pageDisplay" );
LoadLibrary("DisplayList", "objects/pageDisplay" );
LoadLibrary("DisplaySingle", "objects/pageDisplay" );
LoadLibrary("DeleteConf", "objects/pageDisplay" );
LoadLibrary("AdminBox", "objects/pageDisplay/formProcessor" );

LoadLibrary("tools_Finances", "Tools");


LoadLibrary("class_DisplayObject");
LoadLibrary("class_Table");

LoadLibrary("class_OldPage");
LoadLibrary("class_Forms");
//LoadLibrary("class_MultiLingual");
LoadLibrary("class_CMS");
LoadLibrary("class_Subscription");
LoadLibrary("class_LinkTool");
LoadLibrary("class_AIWebPage");
//LoadLibrary("class_NavBar");
LoadLibrary("class_MenuBar");
LoadLibrary("class_EazyForm");

// Load general stuff not specific to payroll but was created in payroll and then moved
/*LoadLibrary( 'HrdbRenList', 'objects' );
LoadLibrary( 'HrdbRenManager', 'objects' );
LoadLibrary( 'HrdbFamilyMemberList', 'objects');
LoadLibrary( 'HrdbRegionManager', 'objects');
LoadLibrary( 'HrdbRegionList', 'objects');
LoadLibrary( 'HrdbAssignmentManager', 'objects');
LoadLibrary( 'HrdbCityManager', 'objects');
LoadLibrary( 'HrdbFamilyManager', 'objects');
LoadLibrary( 'HrdbFamilyList', 'objects');
LoadLibrary( 'HrdbProvinceManager', 'objects');
LoadLibrary( 'HrdbProvinceList', 'objects');
LoadLibrary( 'HrdbAccessManager', 'objects');
*/

//  Load Software Tools
LoadLibrary("tools_Sessions", "Tools");
LoadLibrary("tools_Querystring", "Tools");
LoadLibrary("tools_Unicode", "Tools");
LoadLibrary("tools_Debug", "Tools");

LoadLibrary("EmailTemplate", "modules/app_EmailTemplates/tools");
LoadLibrary("incl_EmailTemplates", "modules/app_EmailTemplates");
//require_once( 'tools/EmailTemplate.php' );
//require_once("modules/app_EmailTemplates/incl_EmailTemplates.php");

/*
        //////////
        //
        // phpCAS simple client
        //
        
        // import phpCAS lib
        //include_once('CAS.php');
        
        phpCAS::setDebug();
        
        // initialize phpCAS
        phpCAS::client(CAS_VERSION_2_0,SITE_CAS_HOSTNAME,SITE_CAS_PORT,SITE_CAS_PATH);
        
        // no SSL validation for the CAS server
        phpCAS::setNoCasServerValidation();
        
        // force CAS authentication
        //phpCAS::forceAuthentication();
        
        // at this step, the user has been authenticated by the CAS server
        // and the user's login name can be read with phpCAS::getUser().
        
        // logout if desired
        if (isset($_REQUEST['logout'])) {
        phpCAS::logout();
        }
        
        //////////
        */

?>
