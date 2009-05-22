<?php

// 
//  GENERAL DEFINES
//
//	This file will define the constants used through out the Site.
//
//
//

// whether the site is running local to the developer or not, 
// if this is running either on production or development on 
// the langley servers it should be set to false
$isLocal = false;  

// whether or not certain development features and settings
// should be used
$isDev = true;

// if the site is local, which developer is working on it?
$isHobbe = false;
$isRuss = true;
$isJon = false;
$isValera = false;


define( 'SITE_CAS_HOSTNAME',"signin.mygcx.org" );
define( 'SITE_CAS_PORT',443 );
define( 'SITE_CAS_PATH','/cas' );

//-----------------------------------------------------------------------
// START SITE SPECIFIC THINGS
// This is were you set things depending on which site you are on.

// this should be true on the training site
// this should be false on all other sites
// this should be equal to the amount of chocolate consumed by Johnny on alternating Tuesdays of each month
define( 'SHOW_TRAINING_FEATURES', false );

define( 'MAX_TEMP_SEED', 40 );	// == max temp files (of particular type)

// this should be 'site' on the live site
// this should be 'dev' on the dev site
if ( $isLocal )
{

   define( 'ASP_DB_PATH', 'localhost' );
   define( "SITE_DB_PATH", "localhost");
   
   if ( $isHobbe )
   {
	   define( "IGNORE_EMAILS", true );		// used to avoid triggering (unsuccessful) e-mailing attempts
	   
      // settings for Hobbe's dev machine
      define( "SITE_DB_NAME", "");
      define( "SITE_DB_USER", "");
      define( "SITE_DB_PWORD", "");
   }
   else if ( $isRuss )
   {
      // settings for Russ' dev machine
      define( "SITE_DB_NAME", "" );
      define( "SITE_DB_USER", "");
      define( "SITE_DB_PWORD", "");
   }
	else if ( $isJon )
	{
		// settings for Jon's mac machine
    	define( "SITE_DB_NAME", "" );
    	define( "SITE_DB_USER", "");
    	define( "SITE_DB_PWORD", "");
	
	}
	else if ( $isValera )
	{
		// settings for Valera's Win machine
    	define( "SITE_DB_NAME", "" );
    	define( "SITE_DB_USER", "");
    	define( "SITE_DB_PWORD", "");
	}

   else
   {
      define( "SITE_DB_NAME", "ciministry" );
      define( "SITE_DB_USER", "root");
      define( "SITE_DB_PWORD", "");
   }
}
else
{
   define( 'ASP_DB_PATH', '' );
   define( "SITE_DB_PATH", "");
   define( "SITE_DB_USER", "");
   define( "SITE_DB_PWORD", "");
   
   if ( $isDev )
   {
      // the name of the development database
      define( "SITE_DB_NAME", "" );
   }
   else
   {
      // the name of the production database
      define( "SITE_DB_NAME", "" );  
   }
}

if ( $isDev )
{
   define( 'SHOW_DEV_FEATURES', true );
}
else
{
   define( 'SHOW_DEV_FEATURES', false );
}

// define where to have the rad tool interactions
//
// we want to share the database amongst all the developers
//
// we point this to the production database, since the development one is
// frequently reloaded
define("RADTOOL_DB_PATH","");
define("RADTOOL_DB_NAME","");
define("RADTOOL_DB_USER","");
define("RADTOOL_DB_PWORD","");

// this should be 'www.dodomail.net/php/' on live site
// this should be 'www.dodomail.net/nss/' on dev site
define( "NAV_BAR_PATH", "www.dodomail.net/php/");

// this should be 'hrdb' on live site
// this shoulbe be 'test_hrdb' on the dev site
define( 'HR_DB_NAME', 'hrdb' );

// END SITE SPECIFIC THINGS


//-----------------------------------------------------------------------

// PHP 5
// 
// The set of Defines created and used by PHP 5 set of routines
//

// 
// Site Information
//

// SITE_PATH_SLASH 
//      the type of path slash to look for.
define( "SITE_PATH_SLASH", "/");  // for Unix OS'
//define( "SITE_PATH_SLASH", "\"); // for Windows OS

// SITE_PATH_STYLESHEETS
//      the path to the common site stylesheets
define( "SITE_PATH_STYLESHEETS", "Data/css/" );

// SITE_PATH_SCRIPTS
//      the path to the common site scripts
define( "SITE_PATH_SCRIPTS", "Data/scripts/JScript/" );

// SITE_PATH_TEMPLATES
//      the path to the common site scripts
define( "SITE_PATH_TEMPLATES", "Data/templates/" );

// SITE_PATH_IMAGES
//      the path to the common site images
define( "SITE_PATH_IMAGES", "Images/" );

// SITE_PATH_MODULES
//      the path to the modules folder
define( "SITE_PATH_MODULES", "modules/" );

// SITE_PATH_TOOLS
//      the path to the tools folder
define( "SITE_PATH_TOOLS", "Tools/" );

// SITE_PATH_REPORTS
//      the path to the folder storing the most recently generated reports (1 per type)
define( "SITE_PATH_REPORTS", "Reports/" );

// SITE_DB_

/*
 *  SITE_ADMIN_
 *
 *  The definitions for the initial administrator account id and pword.
 */ 
define( "SITE_ADMIN_USERID", "admin" );
define( "SITE_ADMIN_PWORD", "admin");       // plain text pword.  Will be encrypted and put into DB.

/*
 * SITE_KEY_SERVER_URL
 *
 * Defines the proper key to pull the proper path to the called page.  
 */
//define( "SITE_KEY_SERVER_URL", "SCRIPT_URL");
define( "SITE_KEY_SERVER_URL", "SCRIPT_NAME"); // for use on david's machine

/*
 * SITE_SERVER_HTTP
 *
 * Defines the proper http call to the server.  If you want the pages to be
 * SSL encrypted, use "https://" here.  
 */
if ( $isDev )
{
   // do not need ssl on the development site
   define( "SITE_SERVER_HTTP", "http://");
}
else
{
   // use ssl on the production site
   define( "SITE_SERVER_HTTP", "https://");
}


/*
 * SITE_LABEL_
 *
 * Define the common label parameters for some standard site wide defined 
 * label sets. 
 *
 * SITE_LABEL_SERIES_SITE
 *      The Multilingual Series Key for our Site wide label pages.  
 */
define( "SITE_LABEL_SERIES_SITE", "site");

/*
 * The following pages are defined under the above SITE_LABEL_SERIES_SITE 
 * series key.
 *
 * SITE_LABEL_PAGE_GENERAL
 *      Contains general site wide labels ... (like Page Title, etc ...)
 */
define( "SITE_LABEL_PAGE_GENERAL", "General");

/*
 *
 *
 *
 * SITE_LABEL_PAGE_MODULE_TITLES
 *      Contains module labels 
 */
define( "SITE_LABEL_PAGE_MODULE_TITLES", "ModuleTitles");

/*
 * SITE_LABEL_PAGE_FORMERRORS
 *      Contains generic form error labels if a form has not already defined
 *      an error message.
 */
define( "SITE_LABEL_PAGE_FORMERRORS", "form_errors");

/*
 * SITE_LABEL_PAGE_FORM_LINKS
 *      Contains generic form link labels for a form. Should containt links
 *      for "Add", "Edit", "Delete", "Delete?", and "Cancel" links.
 */
define( "SITE_LABEL_PAGE_FORM_LINKS", "form_links");

/*
 * SITE_LABEL_PAGE_LIST_
 *      Some Common lists that we use on the site ...
 *
 */
define( "SITE_LABEL_PAGE_LIST_YESNO", "list_yesno");
define( "SITE_LABEL_PAGE_LIST_MONTHS", "list_months");
define( "SITE_LABEL_PAGE_LIST_GENDER", "list_gender");
define( "SITE_LABEL_PAGE_LIST_COUNTRY", "list_countries");



/**
 * DB_TABLE_SESSION
 *
 * Since the Session tools are not Object Oriented, we define their constants
 * here. (for the sake of the site_setup.php routine we don't want to include
 * the session files before the session DB & table are created ...)
 *
 */
define( "DB_TABLE_SESSION", 'site_session');




/*
 * Page Information
 */ 
 
// What you see when you login
//define( 'PAGE_LOGIN_TEMPLATE', 'guest_loginTemplate.php');
// define( 'PAGE_LOGIN_TEMPLATE', 'php5_loginTemplate.php');
define( 'PAGE_LOGIN_TEMPLATE', 'cimLoginTemplate.php');

/*
 * PAGE_TEMPLATE 
 *      the QueryString Key for which page template to use.
 */
define( "PAGE_TEMPLATE", "pageTMPL" );


/*
 * PAGE_TEMPLATE_DEFAULT 
 *      is the default path+filename of the standard site template.
 */

//define( "PAGE_TEMPLATE_DEFAULT_ARRAY", SITE_PATH_TEMPLATES."arry_siteTemplate.tpl" );
// define( "PAGE_TEMPLATE_DEFAULT", SITE_PATH_TEMPLATES."php5_siteTemplate.php" );
define( "PAGE_TEMPLATE_DEFAULT", SITE_PATH_TEMPLATES."php5_siteCIMTemplate.php" );
define( "PAGE_TEMPLATE_DEFAULT_ARRAY", SITE_PATH_TEMPLATES."arry_siteTemplate.tpl" );
//define( "PAGE_TEMPLATE_DEFAULT",  SITE_PATH_TEMPLATES."guest_siteTemplate.php" );


//Left,Right and Center images. The center images fills in all extra gap in the middle.
//Note: The Header Images are currently hardcoded in the cim_siteTemplate.tpl
//define ("PAGE_TEMPLATE_HEADER_LEFT", SITE_PATH_IMAGES.'CimHeader_center.jpg');
//define ("PAGE_TEMPLATE_HEADER_CENTER", SITE_PATH_IMAGES.'CimHeader_center.jpg');
//define ("PAGE_TEMPLATE_HEADER_RIGHT", SITE_PATH_IMAGES.'CimHeader_center.jpg');
//Original Header Image
//define ("PAGE_TEMPLATE_HEADER_IMAGE", SITE_PATH_IMAGES.'site_HeaderImage.jpg');

define ("PAGE_TEMPLATE_HEADER_IMAGE", SITE_PATH_IMAGES.'CimHeader_center.jpg');


/*
 * PAGE_TEMPLATE_NULL 
 *      page template used when sending raw data back to the browser (like an
 *      Excel file).
 */
define( "PAGE_TEMPLATE_NULL", SITE_PATH_TEMPLATES."guest_siteContentOnly.php" );

/*
 * PAGE_TEMPLATE_PRINTABLE 
 *      page template used when generating data to be printed.
 */
define( "PAGE_TEMPLATE_PRINTABLE", SITE_PATH_TEMPLATES."guest_sitePrintable.php" );

/*
 * PAGE_TEMPLATE_LOGIN 
 *      is the default filename of the login template.
 */
define( "PAGE_TEMPLATE_LOGIN", SITE_PATH_TEMPLATES."php5_siteLogin.php" );

/*
 * PAGE_TEMPLATE_POPUP 
 *      is the default filename of the popups template.
 */
define( "PAGE_TEMPLATE_POPUP", SITE_PATH_TEMPLATES."php5_sitePopUp.php" );

/*
 * PAGE_MODULE_DEFAULT 
 *      is the default PageContent Module to load if none is provided.
 */
define( "PAGE_MODULE_DEFAULT" , "Welcome" );
//define( "PAGE_MODULE_DEFAULT" , "guestRegistration" );

/*
 * PAGE_MODULE_LOGIN 
 *     is the PageContent Module Key to load for the Login page.
 */
define( "PAGE_MODULE_LOGIN" , "Login" );

/*
 * PAGE_MODULE_LOGOUT 
 *     is the PageContent Module Key to load for the Logout page.
 */
define( "PAGE_MODULE_LOGOUT" , "Logout" );







// END PHP 5

// multilingual table stuff
define( 'NEW_SITE_NAME', 'AI' );
define( 'ASP_MULTILINGUAL_DB', 'multilingual' );
define( 'ASP_MULTILINGUAL_DB_SITE_TABLE', 'site' );
define( 'ASP_MULTILINGUAL_DB_SERIES_TABLE', 'series' );
define( 'ASP_MULTILINGUAL_DB_PAGE_TABLE', 'page' );
define( 'ASP_MULTILINGUAL_DB_LABEL_TABLE', 'labels' );


define( 'ASP_LOGIN_DB', 'login' );
define( 'ASP_SESSION_DB', 'login' );
define( 'ASP_SESSION_TABLE', 'sessions' );
define( 'ASP_DB_USERNAME', '' );
define( 'ASP_DB_PWD', '' );
define( 'ASP_SESSION_ID', 'aspSessionID' );
define( 'ASP_VIEWER_ID', 'aspViewerID' );
define( 'IS_FROM_OLD_SITE', 'isFromOldSite' );


//  SESSION ID's
//
//		These IDs are used to indicate the IDs of the session variables 
//		we use.
define( "SESSION_ID_ID", "V_ID" );
define( "SESSION_ID_LANG", "LANG");
define( "SESSION_ID_CALLBACK", "CallBack");

//	LOGIN
//
//		Here we define the Login page related Constants
define( "LOGIN_CALLBACK_PAGE", "CP");
define( "LOGIN_FORM_RETURN", "login/login.php?M=F");


//  DISPLAY OBJECT
//
//		These values are used through out the site.
define ( "DISPLAYOBJECT_TYPE_HTML", 'H');		// Defines HTML as the type of Data in an entry
define ( "DISPLAYOBJECT_TYPE_OBJECT", 'O');		// Defines an Object as Data in an entry


//	CLASS MODES
//
//		These values define the state of a table class:
define ( 'CLASS_MODE_ADD', 'ADD' );
define ( 'CLASS_MODE_MOD', 'MOD' );
define ( 'CLASS_MODE_DEL', 'DEL' );


//  BUTTON DEFINITIONS
//
//		These values define the values for the general MultiLingual Buttons
define( 'THIS_SUBMIT', 'submit');
define( 'THIS_SUBMIT_ADD', '[Add]' );
define( 'THIS_SUBMIT_MOD', '[Modify]' );
define( 'THIS_SUBMIT_DEL', '[Delete]' );
define( 'THIS_SUBMIT_DEL2', '[Delete?]' );
define( 'THIS_SUBMIT_CAN', '[Cancel]');
define( 'THIS_SUBMIT_UPDATE', '[Update]');

//	EMAIL INFORMATION
//
//		These values will define the SMTP & POP3 value defaults for the Email Class.
define( 'EMAIL_CONNECTION_TIMEOUT', 20);
define( 'EMAIL_SMTP_SERVER', 'smtp.truthmedia.com');	// Asia Impact value:	'192.168.216.12');
define( 'EMAIL_SMTP_PORT', 		25);
define( 'EMAIL_POP3_USER', 		'test' );	// TODO: find out Truthmedia value
define( 'EMAIL_POP3_PASS', 		'test' );	// TODO: find out Truthmedia value
define( 'EMAIL_POP3_SERVER', 	'pop.truthmedia.com');	// Asia Impact value:	'192.168.216.12');
define( 'EMAIL_POP3_PORT', 		110);

// TEMPLATE NAMES
define( 'TEMPLATE_DISPLAY_LIST', 'siteDataList.php' );
define( 'TEMPLATE_FORM_DATA_LIST', 'siteFormDataList.php' );
define( 'TEMPLATE_ADMIN_BOX', 'siteAdminBox.php' );
define( 'TEMPLATE_DISPLAY_LIST_SINGLE', 'siteDataSingle.php' );
define( 'TEMPLATE_DELETE_CONFIRMATION', 'siteDeleteConf.php' );
define( 'TEMPLATE_FORM_GRID', 'siteFormGrid.php');
define( 'TEMPLATE_FORM_SINGLE', 'siteFormSingle.php');
define( 'TEMPLATE_GENERIC_FORM', 'GenericForm.tpl.php' );

// SQL OPERATIONS
define( 'OP_NOT_EQUAL', '<>' );
define( 'OP_EQUAL', '=' );
define( 'OP_OR', 'OR');
define( 'OP_LESS_THAN_OR_EQUAL', '<=' );
define( 'OP_GREATER_THAN', '>' );
define( 'OP_LESS_THAN', '<' );

define( 'REPORT_FIELD_PREFIX', 'field_' );

//Campus Assignments
define( 'CA_STUDENT', '1');
define( 'CA_ALUMNI', '2');
define( 'CA_STAFF', '3');
define( 'CA_ATTENDED', '4');
define( 'CA_STAFF_ALUMNI', '5');
define( 'CA_UNKNOWN', '0');

// Director-staff Relations
define( 'MAX_DIRECTOR_LEVELS', 10 );
define( 'TOP_DIRECTOR_ID', 151 );

// Calendar code
define('CALENDAR_ROOT', 'objects'.DIRECTORY_SEPARATOR.'Calendar'.DIRECTORY_SEPARATOR);

//Access Groups (From app_cim_newaccount.php --- Moved here during Loop08 GCX CIM integration)
define('ALL_ACCESS_GROUP', 1);
define('SPT_APPLICANT_ACCESS_GROUP', 46);

?>
