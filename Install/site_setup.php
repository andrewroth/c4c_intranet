<?PHP
/*
 *  Using this script:
 *
 *  This script will setup the php5 version of the site.  it will create an 
 *  initial instance of all the DB's, entries, labels, and scripts that are
 *  used by the site.
 *
 *  Most configuration happens by setting the needed values in the objects
 *  that work with these tables.  Values that are not defined in the system's
 *  objects are then defined in the 'General/gen_Defines.php' file.
 *
 *  To run this script you can:
 *      A) open up a web browser and then pull it up :  
 *          http://path/to/script/site_setup.php
 *          note: you should call this using the method people will be using
 *               to access your site. (ie don't use 'localhost/path/to/script/.'
 *               if people will normally use 'http://path/to/...' since part of 
 *               this url will end up as a file reference for some files.
 *
 *      B) call it on the command line:
 *          php site_setup.php
 *
 *  However you run it, you will need to make sure that the process has
 *  permission to write to the directories the files are in, otherwise this
 *  script will be unable to create some of the needed scripts.
 *
 */

/*
 * Site Database
 *
 * Create the Site Database.
 */

$pathFile = 'General/gen_Includes.php';
$extension = '';
    
// Attempt to find proper directory from current page to Root ...
$numAttempts = 0;
while ( (!file_exists($extension.$pathFile)) && ( $numAttempts < 5) ) {
    
    $extension = '../'.$extension;
    $numAttempts++; 
}
require_once ( $extension.$pathFile );






$db = new Database_Site();
$db->doSuppressErrors();
$db->connectToDB( SITE_DB_NAME, SITE_DB_PATH, SITE_DB_USER, SITE_DB_PWORD);

$sql = "CREATE DATABASE /*!32312 IF NOT EXISTS*/ ".SITE_DB_NAME;
$db->runSQL($sql);

$sql = "USE ".SITE_DB_NAME;
$db->runSQL($sql);


/*
 * Modules Table
 *
 * Setup the Page Modules Table.
 */
$module = new RowManager_siteModuleManager();

$module->dropTable();
$module->createTable();

// Initialize Login Page Module
$module->setKey( PAGE_MODULE_LOGIN );
$module->setPath( SITE_PATH_MODULES . 'site_Login/' );
$module->setApplicationFile( 'login_app.php' );
$module->setIncludeFile( 'login_includes.php' );
$module->setName( 'moduleLogin' );
$module->setParameters( '' );
$module->createNewEntry();

require( $extension . SITE_PATH_MODULES . 'site_Login/login_app.php' );

// Initialize Logout Page Module
$module->setKey( PAGE_MODULE_LOGOUT );
$module->setPath( SITE_PATH_MODULES . 'site_Login/' );
$module->setApplicationFile( 'login_app.php' );
$module->setIncludeFile( 'login_includes.php' );
$module->setName( 'moduleLogin' );
$module->setParameters( moduleLogin::MODE."=".moduleLogin::MODE_LOGOUT );
$module->createNewEntry();

// Initialize the Welcome Page
$module->setKey( 'Welcome' );
$module->setPath( SITE_PATH_MODULES . 'site_CMSPage/' );
$module->setApplicationFile( 'cmsPage_app.php' );
$module->setIncludeFile( '' );
$module->setName( 'moduleCMSPage' );
$module->setParameters( 'P=Welcome' );
$module->createNewEntry();



/*
 * Login Table
 *
 * Setup the User Login Table.
 *



***
*** This Table is now being managed by the AccountAdmin Module
***

*/



/*
 * Session Table
 *
 * Setup the session tracking table.  
 * (Used by Tools/tool_Sessions.php)
 */
    sessionsDropTable($db);
    sessionsCreateTable($db);
 
/*
 *XMLObject_CMSPage
 *
 * The table definitions for the CMSPage Application infrastructure.
 */
    $tableDefCMSPage = new XMLObject_CMSApps("");
    
    $tableDefCMSPage->dropTable($db);
    $tableDefCMSPage->createTable($db);
        
/*
*XMLObject_CMSPageApp
*
*
*/
    $tableDefCMSPageApp = new XMLObject_CMSPageApp('');
    
    $tableDefCMSPageApp->dropTable($db);
    $tableDefCMSPageApp->createTable($db);



/*
*CMSPages
*
*
*/
    $tableDefCMSPages = new CMSPage('');
    
    $tableDefCMSPages->dropTable($db);
    $tableDefCMSPages->createTable($db);



/*
 * HTMLBlock
 *
 * The SQL definition of the CMS application HTMLBlock.
 */
    $tableDefHTMLBlock = new HTMLBlock(null,'');
    
    $tableDefHTMLBlock->dropTable($db);
    $tableDefHTMLBlock->createTable($db);



/*
 * XMLObject_MultilingualManager
 *
 * The SQL definition of the Multilingual Tables.
 */
    //Create Tables
    $tableSM = new RowManager_MultilingualSeriesManager();
    $tableSM->dropTable ();
    $tableSM->createTable ();
    
    $tablePM = new RowManager_MultilingualPageManager();
    $tablePM->dropTable ();
    $tablePM->createTable ();

    $tableLM = new RowManager_MultilingualLabelManager();
    $tableLM->dropTable ();
    $tableLM->createTable ();
    
    $tableXL = new RowManager_XLationManager();
    $tableXL->dropTable ();
    $tableXL->createTable ();
    
    
    $dir = $extension . SITE_PATH_MODULES;
    
    $files1 = scandir($dir);
    //echo "----------<br><pre>";
    //print_r ($files1);
    //echo"</pre><br>--------<br><br>";
    //echo "Directory of <b>$dir</b><br>";
    //echo "---------------------------<br>";
    
    for ($i = 0; $i < count($files1); $i++){
        if (($files1[$i] !== ".") && ($files1[$i] !== "..") && (is_dir($dir . $files1[$i]))) {
                if (substr($files1[$i],0,5) == "site_") {
                    //echo "checking {$files1[$i]} for setup script...";
                    if (is_file($dir . $files1[$i] . "/tool_setup.php")){
                        //echo "<b>tool_setup.php found...</b>";
                        require_once ( $dir . $files1[$i] . "/tool_setup.php" );
                        //echo "<i> tool setup sucessfully!!!</i>";
                    } else {
                        //echo "No setup file found";
                    }
                    //echo "<br>";
                }
            }
    
    }
    
    //Enter Series, Page, Labels
    $tableMM = new MultilingualManager();
        
    $tableMM->addSeries (SITE_LABEL_SERIES_SITE);           // 1
        $tableMM->addPage (SITE_LABEL_PAGE_GENERAL);        // 1.1
            $tableMM->addLabel('site_WindowTitle','AI Home', "en" );
        $tableMM->addPage (SITE_LABEL_PAGE_LIST_YESNO);     // 1.3
            $tableMM->addLabel('[yes]','yes', "en" );
            $tableMM->addLabel('[no]','no', "en" );
        $tableMM->addPage (SITE_LABEL_PAGE_FORMERRORS);     // 1.4
            $tableMM->addLabel('[error_T]','Enter a value', "en" );
            $tableMM->addLabel('[error_N]','Enter a Numeric value', "en" );
            $tableMM->addLabel('[error_M]','Enter a value', "en" );
            $tableMM->addLabel('[error_L]','Select a value', "en" );
            $tableMM->addLabel('[error_D]','Select a value for each field', "en" );
            $tableMM->addLabel('[error_R]','Choose an option', "en" );
            $tableMM->addLabel('[error_D_invalid]','This is an invalid date', "en" );
        $tableMM->addPage (SITE_LABEL_PAGE_LIST_COUNTRY);   // 1.5
            $tableMM->addLabel('[Australia]','Australia', "en" );
            $tableMM->addLabel('[Canada]','Canada', "en" );
            $tableMM->addLabel('[China]','China', "en" );
            $tableMM->addLabel('[Hong Kong]','Hong Kong', "en" );
            $tableMM->addLabel('[Japan]','Japan', "en" );
            $tableMM->addLabel('[Korea]','Korea', "en" );
            $tableMM->addLabel('[Philippines]','Philippines', "en" );
            $tableMM->addLabel('[Russia]','Russia', "en" );
            $tableMM->addLabel('[Singapore]','Singapore', "en" );
            $tableMM->addLabel('[Thailand]','Thailand', "en" );
            $tableMM->addLabel('[United States]','United States', "en" );
            $tableMM->addLabel('[Other]','Other', "en" );
            $tableMM->addLabel('[Malaysia]','Malaysia', "en" );
        $tableMM->addPage (SITE_LABEL_PAGE_LIST_GENDER);    // 1.6
            $tableMM->addLabel('[Male]','Male', "en" );
            $tableMM->addLabel('[Female]','Female', "en" );
        $tableMM->addPage (SITE_LABEL_PAGE_LIST_MONTHS);    // 1.7
            $tableMM->addLabel('[January]','January', "en" );
            $tableMM->addLabel('[February]','February', "en" );
            $tableMM->addLabel('[March]','March', "en" );
            $tableMM->addLabel('[April]','April', "en" );
            $tableMM->addLabel('[May]','May', "en" );
            $tableMM->addLabel('[June]','June', "en" );
            $tableMM->addLabel('[July]','July', "en" );
            $tableMM->addLabel('[August]','August', "en" );
            $tableMM->addLabel('[September]','September', "en" );
            $tableMM->addLabel('[October]','October', "en" );
            $tableMM->addLabel('[November]','November', "en" );
            $tableMM->addLabel('[December]','December', "en" );
        $tableMM->addPage (SITE_LABEL_PAGE_FORM_LINKS);     // 1.8
            $tableMM->addLabel('[Edit]','Edit', "en" );
            $tableMM->addLabel('[Update]','Update', "en" );
            $tableMM->addLabel('[Delete]','Delete', "en" );
            $tableMM->addLabel('[Delete?]','Delete ? ', "en" );
            $tableMM->addLabel('[Add]','ADD', "en" );
            $tableMM->addLabel('[Cancel]','Cancel', "en" );
            $tableMM->addLabel('[Continue]','Continue', "en" );
            $tableMM->addLabel('[View]','View', "en" );     
    $tableMM->addSeries (CMSPage::DB_TABLE_PAGE);           // 2
        $tableMM->addPage (SITE_LABEL_PAGE_MODULE_TITLES);  // 2.2
            $tableMM->addLabel('Welcome','Welcome', "en" );


/*
 *  Now install the perl upload scripts ...
 */
 
 

/*
 * 1) Header file (Tools/tool_perlUploadHeader.cgi)
 *
 */

// if file exists, then delete it.
// Note: following statements assumes setup script is 1 directory below
//       the root directory.
$locationHeader = $extension . PerlFileUpload::DEF_LOCATION_UPLOADHEADER;
if ( file_exists( $locationHeader ) ) {
unlink( $locationHeader );
}

// compile contents into variable
    $template = new Template( );
    $contentHeader = $template->fetch('ContentHeaderTemplate.php');

// open file and write contents.
// close.
file_put_contents( $locationHeader, $contentHeader );
chmod( $locationHeader, 0755 );
/*
 * end 1)
 */


/*
 * 2) Upload Script (Tools/tool_perlUpload.cgi)
 *
 */

// if file exists, then delete it.
// Note: following statements assumes setup script is 1 directory below
//       the root directory.
$locationUploader = $extension . PerlFileUpload::DEF_LOCATION_UPLOAD;
if ( file_exists( $locationUploader ) ) {
unlink( $locationUploader );
}


// compile contents into variable
    $template = new Template( );
    $template->set( 'locationHeader', $locationHeader );
    $contentUploader = $template->fetch('ContentUploaderTemplate.php');
// End Contents contentUploader

// open file and write contents.
// close.
file_put_contents( $locationUploader, $contentUploader );
chmod( $locationUploader, 0766 );
/*
 * end 2)
 */
 
/*
 * 3) Progress Bar (Tools/tool_perlProgressBar.cgi)
 *
 */

// if file exists, then delete it.
// Note: following statements assumes setup script is 1 directory below
//       the root directory.
$locationProgressBar = $extension . PerlFileUpload::DEF_LOCATION_PROGRESSBAR;
if ( file_exists( $locationProgressBar ) ) {
unlink( $locationProgressBar );
}

// compile contents into variable
$template = new Template( );
$template->set( 'locationHeader', $locationHeader );
$contentProgressBar = $template->fetch('ContentProgressBarTemplate.php');


// open file and write contents.
// close.
file_put_contents( $locationProgressBar, $contentProgressBar );
chmod( $locationProgressBar, 0766 );
/*
 * end 3)
 */
 
/*
 * 4) Perl Upload Javascript file (Data/scripts/JScript/perlUpload.jsp)
 *
 */

// if file exists, then delete it.
// Note: following statements assumes setup script is 1 directory below
//       the root directory.
$locationJava = $extension . PerlFileUpload::DEF_LOCATION_JAVASCRIPT;
if ( file_exists( $locationJava ) ) {
unlink( $locationJava );
}

// compile contents into variable
$pathParts = pathinfo( $_SERVER[ SITE_KEY_SERVER_URL ] );

$pathWebRoot = Page::getBaseURL();

//$pathProgressBar =  SITE_SERVER_HTTP.$_SERVER['HTTP_HOST']. $pathParts[ 'dirname' ].'/'.$locationProgressBar ;
$pathWebRoot = str_replace('Install/site_setup.php', '', $pathWebRoot);
$pathWebRoot = str_replace('install/site_setup.php', '', $pathWebRoot);

$pathProgressBar = $pathWebRoot.PerlFileUpload::DEF_LOCATION_PROGRESSBAR;

$template = new Template( );

$template->set( 'pathProgressBar', $pathProgressBar );

$contentJava = $template->fetch('ContentJavaScriptTemplate.php');


// open file and write contents.
// close.
file_put_contents( $locationJava, $contentJava );
/*
 * end 4)
 */



/*
 * 5) DB Backup ()
 *
 */

// if file exists, then delete it.
// Note: following statements assumes setup script is 1 directory below
//       the root directory.
$locationDBBackup = $extension . SITE_PATH_TOOLS . "db_backup.sh";
if ( file_exists( $locationDBBackup ) ) {
unlink( $locationDBBackup );
}

// compile contents into variable
$template = new Template( );
$template->set( 'thesite', SITE_DB_NAME);
$contentDBBackup = $template->fetch('db_backup.sh');


// open file and write contents.
// close.
file_put_contents( $locationDBBackup, $contentDBBackup );
chmod( $locationDBBackup, 0766 );
/*
 * end 5)
 */


?>