<?PHP


$pathFile = 'General/gen_Includes.php';
$extension = '';
    
// Attempt to find proper directory from current page to Root ...
$numAttempts = 0;
while ( (!file_exists($extension.$pathFile)) && ( $numAttempts < 5) ) {
    
    $extension = '../'.$extension;
    $numAttempts++; 
}

if (!defined( GEN_INCLUDES ) ) {
    require_once ( $extension.$pathFile );
}

require ( 'app_AccountAdmin.php' );
require ( 'incl_AccountAdmin.php');


/*
 *  Directory Setup
 *
 *  Setup any specific directories used by this module.
 */
/*
if( !file_exists( moduleAccountAdmin::DEF_DIR_DATA ) ) { 
    mkdir( moduleAccountAdmin::DEF_DIR_DATA);
}
*/



/*
 * Modules Table
 *
 * Setup the Page Modules Table to include a proper entry for this app.
 */
$module = new RowManager_siteModuleManager();


$module->loadByKey( moduleAccountAdmin::MODULE_KEY );
$module->setKey( moduleAccountAdmin::MODULE_KEY );
$module->setPath( 'modules/site_AccountAdmin/' );
$module->setApplicationFile( 'app_AccountAdmin.php' );
$module->setIncludeFile( 'incl_AccountAdmin.php' );
$module->setName( 'moduleAccountAdmin' );
$module->setParameters( '' );

// if module entry already exists then
if ( $module->isLoaded() ) {

    // update current entry
    $module->updateDBTable();
    
} else {

    // create new entry
    $module->createNewEntry();
}




/*
 * Language Table
 *
 * Defines the valid languages for display in the site.
 *
 * language_id [INTEGER]  Primary Key for this table.
 * language_key [STRING]  The Lable lookup key for this language.
 */
/*$languageManager = new RowManager_LanguageManager();

$languageManager->dropTable();
$languageManager->createTable();


// since this is a RowLabelBridge, we need to use that to create the initial
// entry.
$seriesKey = moduleAccountAdmin::MULTILINGUAL_SERIES_KEY;
$pageKey = RowManager_LanguageManager::XML_NODE_NAME;
$bridgeMultiLingualManager = new MultilingualManager( 1, $seriesKey, $pageKey );
$dataManager = new LanguageLabelBridge($languageManager, $bridgeMultiLingualManager );

// load default english entry
$values[ 'label_label' ] = 'English';
$values[ 'language_code' ] = 'en';

$dataManager->loadFromArray( $values );
$dataManager->createNewEntry();

$skipTables = true;

if ( !$skipTables )
{

/*
 * Viewer Table
 *
 * This table tracks the viewer's account (user id, pword, etc...)
 *
 * viewer_id [INTEGER]  Primary Key for this table
 * accountgroup_id [INTEGER]  Foreign Key linking this account to an account group
 * viewer_userID [STRING]  The user id for the site login.
 * viewer_passWord [STRING]  The account password
 * language_id [INTEGER]  The default Language ID for this viewer
 * viewer_isActive [BOOL]  Is this account currently active?
 * viewer_lastLogin [DATE]  Date viewer last entered web site.
 */
$viewer = new RowManager_ViewerManager();

$viewer->dropTable();
$viewer->createTable();

// Create default Admin Entry
//$viewer->setAccountGroupID( 9 );
$viewer->setUserID( 'admin' );
$viewer->setPassWordEncrypted( '35af4bf130805f0b86b1b13e49c8101e' );
$viewer->setLanguageID( 1 );
$viewer->setIsActive( 1 );
$viewer->setLastLogin( '' );

$viewer->createNewEntry();



/*
 * AccountGroup Table
 *
 * Organizes the viewer (login accounts) into different groups for easier management.
 *
 * accountgroup_id [INTEGER]  Primary Key for this table
 * accountgroup_key [STRING]  The label key for this group. (used to lookup in multilingual labels for display value)
 */
$accountGroup = new RowManager_AccountGroupManager();

$accountGroup->dropTable();
$accountGroup->createTable();



// AccountGroup is a RowLabelBridge, so we must use that to create the initial
// entries:
$seriesKey = moduleAccountAdmin::MULTILINGUAL_SERIES_KEY;
$pageKey = RowManager_AccountGroupManager::XML_NODE_NAME;
$multiLingualContext = new MultilingualManager( 1, $seriesKey, $pageKey );
$labelBridge = $accountGroup->getRowLabelBridge( $multiLingualContext );

$values = array();
$values[ 'label_label' ] = 'Site Admin';

$labelBridge->loadFromArray( $values );
$labelBridge->createNewEntry();


$viewer->setAccountGroupID( $labelBridge->getID() );
$viewer->updateDBTable();

/*
 * AccessCategory Table
 *
 * Organizes the access groups into categories for easier management.
 *
 * accesscategory_id [INTEGER]  Primary Key for this field.
 * accesscategory_key [STRING]  The Label lookup key for this category
 */
$accessCategory = new RowManager_AccessCategoryManager();

$accessCategory->dropTable();
$accessCategory->createTable();


// AccessCategory is a RowLabelBridge, so we must use that to create the initial
// entries:
$seriesKey = moduleAccountAdmin::MULTILINGUAL_SERIES_KEY;
$pageKey = RowManager_AccessCategoryManager::XML_NODE_NAME;
$multiLingualContext = new MultilingualManager( 1, $seriesKey, $pageKey );
$category = $accessCategory->getRowLabelBridge( $multiLingualContext );

$values = array();
$values[ 'label_label' ] = 'Admin';

$category->loadFromArray( $values );
$category->createNewEntry();


/*
 * AccessGroup Table
 *
 * Defines an access group for the site.  Different site links (and resources) are assoicated with different account Groups.
 *
 * accessgroup_id [INTEGER]  Primary Key for this table
 * accesscategory_id [INTEGER]  Links this access group to a category.
 * accessgroup_key [STRING]  The label lookup value for this access group
 */
$accessGroup = new RowManager_AccessGroupManager();

$accessGroup->dropTable();
$accessGroup->createTable();

// AccessGroup is a RowLabelBridge, so we must use that to create the initial
// entries:
$seriesKey = moduleAccountAdmin::MULTILINGUAL_SERIES_KEY;
$pageKey = RowManager_AccessGroupManager::XML_NODE_NAME;
$multiLingualContext = new MultilingualManager( 1, $seriesKey, $pageKey );
$group = $accessGroup->getRowLabelBridge( $multiLingualContext );

$values = array();
$values[ 'label_label' ] = 'Site Administration';
$values[ 'accesscategory_id' ] = $category->getID();

$group->loadFromArray( $values );
$group->createNewEntry();




/*
 * ViewerAccessGroup Table
 *
 * Links a Viewer to an Access Group.
 *
 * vieweraccessgroup_id [INTEGER]  Primary Key for this table
 * viewer_id [INTEGER]  The Viewer ID that we are defining an access group for.
 * accessgroup_id [INTEGER]  The Access Group we are linking to a viewer.
 */
$viewerAccessGroup = new RowManager_ViewerAccessGroupManager();

$viewerAccessGroup->dropTable();
$viewerAccessGroup->createTable();

// Now add the Admin Account to the Site Admin access group
$viewerAccessGroup->setAccessGroupID( $group->getID() );
$viewerAccessGroup->setViewerID( $viewer->getID() );
$viewerAccessGroup->createNewEntry();


/*
 * AccountAdminAccess Table
 *
 * Manages Access Priviledges for the Account Admin system.
 *
 * accountadminaccess_id [INTEGER]  Primary Key for this table
 * viewer_id [INTEGER]  The account we are defining an access priv for
 * accountadminaccess_privilege [INTEGER]  The access privilege level of this viewer
 */
$accountAdminAccess = new RowManager_AccountAdminAccessManager();

$accountAdminAccess->dropTable();
$accountAdminAccess->createTable();

// Now Mark Admin Account as having SiteLevel access for the web site.
$accountAdminAccess->setSiteLevelAccess();
$accountAdminAccess->setViewerID( $viewer->getID() );
$accountAdminAccess->createNewEntry();



/*[RAD_DAOBJ_TABLE]*/

}
else
{
    echo 'Skipping tables<br/>';
}



/*
 *  Insert Labels in DB
 */
$labelManager = new  MultilingualManager();
$labelManager->addSeries( moduleAccountAdmin::MULTILINGUAL_SERIES_KEY );


// Create General Field labels for moduleAccountAdmin
$labelManager->addPage( moduleAccountAdmin::MULTILINGUAL_PAGE_FIELDS );

//
// Viewer table
//
$labelManager->addLabel( '[title_accountgroup_id]', 'Group', 'en' );
$labelManager->addLabel( '[formLabel_accountgroup_id]', 'Select the group', 'en' );
$labelManager->addLabel( '[title_viewer_userID]', 'UserID', 'en' );
$labelManager->addLabel( '[formLabel_viewer_userID]', 'Enter the User ID', 'en' );
$labelManager->addLabel( "[title_viewer_passWord]", "Password", "en" );
$labelManager->addLabel( "[formLabel_viewer_passWord]", "Enter the Password", "en" );
$labelManager->addLabel( "[title_language_id]", "Language", "en" );
$labelManager->addLabel( "[formLabel_language_id]", "Select the default language", "en" );
$labelManager->addLabel( "[title_viewer_isActive]", "is Active?", "en" );
$labelManager->addLabel( "[formLabel_viewer_isActive]", "Is this account active?", "en" );
$labelManager->addLabel( "[title_viewer_lastLogin]", "Last Login", "en" );
$labelManager->addLabel( "[formLabel_viewer_lastLogin]", "Date User last logged in.", "en" );



//
// AccountGroup table
//
$labelManager->addLabel( "[title_accountgroup_key]", "Group Name", "en" );
$labelManager->addLabel( "[formLabel_accountgroup_key]", "Enter the group", "en" );



//
// AccessCategory table
//
$labelManager->addLabel( "[title_accesscategory_key]", "Category", "en" );
$labelManager->addLabel( "[formLabel_accesscategory_key]", "Enter the category", "en" );



//
// AccessGroup table
//
$labelManager->addLabel( "[title_accesscategory_id]", "Category", "en" );
$labelManager->addLabel( "[formLabel_accesscategory_id]", "Select the access category", "en" );
$labelManager->addLabel( "[title_accessgroup_key]", "Group", "en" );
$labelManager->addLabel( "[formLabel_accessgroup_key]", "Enter the access group name", "en" );



//
// Language table
//
$labelManager->addLabel( "[title_language_key]", "Language", "en" );
$labelManager->addLabel( "[formLabel_language_key]", "Enter the language name", "en" );



//
// ViewerAccessGroup table
//


//
// AccountAdminAccess table
//
$labelManager->addLabel( "[title_viewer_id]", "Account", "en" );
$labelManager->addLabel( "[formLabel_viewer_id]", "Select the Account", "en" );
$labelManager->addLabel( "[title_accountadminaccess_privilege]", "Priviledge", "en" );
$labelManager->addLabel( "[formLabel_accountadminaccess_privilege]", "Select the priviledge level", "en" );



/*[RAD_FIELDS_LABEL]*/




// Create AccountList labels 
$labelManager->addPage( page_AccountList::MULTILINGUAL_PAGE_KEY );

$labelManager->addLabel( "[Title]", "Accounts", "en" );
$labelManager->addLabel( "[Instr]", "These are the accounts on the system. ", "en" );
$labelManager->addLabel( "[ChooseGroup]", "Select an Account Group to work with :", "en" );
$labelManager->addLabel( "[title_passWord]", "Passwords", "en" );
$labelManager->addLabel( "[change]", "change", "en" );
$labelManager->addLabel( "[title_access]", "Access Groups", "en" );

/*[RAD_PAGE(AccountList)_LABELS]*/



// Create AddViewer labels 
$labelManager->addPage( FormProcessor_AddViewer::MULTILINGUAL_PAGE_KEY );


$labelManager->addLabel( "[Title]", "Add an Account", "en" );
$labelManager->addLabel( "[Instr]", "Use the following form to add a new account to the system.", "en" );
$labelManager->addLabel( "[formLabel_pword2]", "Password again", "en" );
$labelManager->addLabel( "[error_passwordMatch]", "Passwords did not match", "en" );
$labelManager->addLabel( "[error_uniqueUserID]", "This UserID is already taken", "en" );

/*[RAD_PAGE(AddViewer)_LABELS]*/



// Create EditViewer labels
$labelManager->addPage( FormProcessor_EditViewer::MULTILINGUAL_PAGE_KEY ); 

$labelManager->addLabel( "[Title]", "Edit Account ( [viewerUserID] )", "en" );
$labelManager->addLabel( "[Instr]", "Use the following form to edit this account.", "en" );
$labelManager->addLabel( "[error_uniqueUserID]", "This UserID is already taken", "en" );

/*[RAD_PAGE(EditViewer)_LABELS]*/



// Create EditPassword labels 
$labelManager->addPage( FormProcessor_EditPassword::MULTILINGUAL_PAGE_KEY ); 

$labelManager->addLabel( "[Title]", "Modify Password for [viewerUserID]", "en" );
$labelManager->addLabel( "[Instr]", "Enter the new password in the following form.", "en" );
$labelManager->addLabel( "[formLabel_pword2]", "Enter the password again", "en" );
$labelManager->addLabel( "[error_passwordMatch]", "Passwords did not match", "en" );

// Create AccountAccess labels
$labelManager->addPage( page_PasswordChanged::MULTILINGUAL_PAGE_KEY );

$labelManager->addLabel( "[Title]", "Password Changed", "en" );
$labelManager->addLabel( "[Instr]", "The password was successfully changed for [viewerUserID].", "en" );
$labelManager->addLabel( "[Continue]", "Continue", "en" );


/*[RAD_PAGE(EditPassword)_LABELS]*/



// Create DeleteViewer labels
$labelManager->addPage( page_DeleteViewer::MULTILINGUAL_PAGE_KEY );

$labelManager->addLabel( "[Title]", "Delete Account ( [viewerUserID] )", "en" );
$labelManager->addLabel( "[Instr]", "Are you sure you want to remove the following account from the system?", "en" );

/*[RAD_PAGE(DeleteViewer)_LABELS]*/



// Create AccessCategories labels
$labelManager->addPage( FormProcessor_AccessCategories::MULTILINGUAL_PAGE_KEY );

$labelManager->addLabel( "[Title]", "Access Categories", "en" );
$labelManager->addLabel( "[Instr]", "In order to control access to the different areas of the website, we create \"Access Groups\".  A link to an area of a web site is usually associated with an Access Group.  If a viewer account has been assigned to that group, then they will be able to see the link.<br><br>Access Catagories allow us the ability to organize our Access Groups.  Each category will have one or more Access Groups associated with it.<br><br>Use the following form to add new categories for the access groups.", "en" );
$labelManager->addLabel( "[title_label_label]", "Category", "en" );
$labelManager->addLabel( "[title_groups]", "Access Groups", "en" );
$labelManager->addLabel( "[view]", "view", "en" );

/*[RAD_PAGE(AccessCategories)_LABELS]*/



// Create AccessGroup labels
$labelManager->addPage( FormProcessor_AccessGroup::MULTILINGUAL_PAGE_KEY ); 

$labelManager->addLabel( "[Title]", "Access Groups ([accessCategoryName])", "en" );
$labelManager->addLabel( "[Instr]", "Use the following form to enter the access groups for the access category: <b>[accessCategoryName]</b>", "en" );
$labelManager->addLabel( "[title_label_label]", "Group", "en" );

/*[RAD_PAGE(AccessGroup)_LABELS]*/



// Create LanguageList labels 
$labelManager->addPage( FormProcessor_LanguageList::MULTILINGUAL_PAGE_KEY ); 

$labelManager->addLabel( "[Title]", "Site Languages", "en" );
$labelManager->addLabel( "[Instr]", "Use the following form to enter new languages for this site to manage.<br><br>The \"Code\" is a 2 digit code for the language (e.g. English=en, Chinese=cn, Korean=ko). This code is used for importing and exporting language labels among different sites.", "en" );
$labelManager->addLabel( "[title_label_label]", "Language.", "en" );
$labelManager->addLabel( "[title_language_code]", "Code.", "en" );

/*[RAD_PAGE(LanguageList)_LABELS]*/



// Create AccountAccess labels 
$labelManager->addPage( form_AccountAccess::MULTILINGUAL_PAGE_KEY ); 

$labelManager->addLabel( "[Title]", "[viewerUserID] Access Groups", "en" );
$labelManager->addLabel( "[Instr]", "Use the following form to update [viewerUserID]''s access group settings.<br><br>NOTE: by assigning a viewer to a group, you are granting them access to areas of the website assigned to that group.  \"...with great power, comes great responsibility ...\"  Think before you click.", "en" );

/*[RAD_PAGE(AccountAccess)_LABELS]*/



// Create AccountGroup labels
$labelManager->addPage( form_AccountGroup::MULTILINGUAL_PAGE_KEY );  

$labelManager->addLabel( "[Title]", "Account Groups", "en" );
$labelManager->addLabel( "[Instr]", "This form allows you to create different \"Groups\" to use in ordering your web site user accounts.  The purpose of these groups is to simply help you organize your accounts and help distribute administrative tasks among different account groups.", "en" );
$labelManager->addLabel( "[title_label_label]", "Group", "en");

/*[RAD_PAGE(AccountAccess)_LABELS]*/



// Create AccountGroup labels 
$labelManager->addPage( FormProcessor_AdminPriv::MULTILINGUAL_PAGE_KEY );

$labelManager->addLabel( "[Title]", "Account Administration Priviledge", "en" );
$labelManager->addLabel( "[Instr]", "This form allows you to set the scope of access rights to a user account. Setting up an account here allows users to create and remove new web site accounts.<br><br>If the account has \"Group\" priviledges then they will be able to manage accounts within their own Account Group.  They will not be able to access accounts from other Groups.<br><br>If the account has \"Site\" priviledges, then they will be able to access accounts from all Account Groups.", "en" );
$labelManager->addLabel( "[site]", "Site", "en" );
$labelManager->addLabel( "[group]", "Group", "en" );

/*[RAD_PAGE(AccountAccess)_LABELS]*/



// Create AdminSideBar labels
$labelManager->addPage(obj_AdminSideBar::MULTILINGUAL_PAGE_KEY);

$labelManager->addLabel( "[Title]", "Admin Options", "en" );
$labelManager->addLabel( "[changeYourPassword]", "Change Your Password", "en" );
$labelManager->addLabel( "[accountList]", "Edit User Accounts", "en" );
$labelManager->addLabel( "[accountAdminAccessPriv]", "Account Admin Priviledges", "en" );
$labelManager->addLabel( "[accountGroup]", "Edit Account Groups", "en" );
$labelManager->addLabel( "[accessCatagories]", "Access Categories", "en" );
$labelManager->addLabel( "[languageList]", "Site Languages", "en" );


/*[RAD_PAGE(AccountAccess)_LABELS]*/



/*[RAD_PAGE_LABEL]*/


?>