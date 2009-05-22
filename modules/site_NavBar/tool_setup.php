<?PHP
$pathFile = 'General/gen_Includes.php';
$extension = '';
    
// Attempt to find proper directory from current page to Root ...
$numAttempts = 0;
while ( (!file_exists($extension.$pathFile)) && ( $numAttempts < 5) ) {
    
    $extension = '../'.$extension;
    $numAttempts++; 
}

if (!defined( "GEN_INCLUDES" ) ) {
    require_once ( $extension.$pathFile );
}

require ( 'app_NavBar.php' );
require ( 'incl_NavBar.php');


/*
 *  Directory Setup
 *
 *  Setup any specific directories used by this module.
 */
/*
if( !file_exists( moduleNavBar::DEF_DIR_DATA ) ) { 
    mkdir( moduleNavBar::DEF_DIR_DATA);
}
*/




// check to see if the parameter 'skipModule' was provided
$skipModule = isset($_REQUEST['skipModule']);

// if it was NOT provided then update the Modules Table
if (!$skipModule ) {

    
    /*
     * Modules Table
     *
     * Setup the Page Modules Table to include a proper entry for this app.
     */
    $module = new RowManager_siteModuleManager();


    $module->loadByKey( moduleNavBar::MODULE_KEY );
    $module->setKey( moduleNavBar::MODULE_KEY );
    $module->setPath( 'modules/site_NavBar/' );
    $module->setApplicationFile( 'app_NavBar.php' );
    $module->setIncludeFile( 'incl_NavBar.php' );
    $module->setName( 'moduleNavBar' );
    $module->setParameters( '' );
    
    // if module entry already exists then
    if ( $module->isLoaded() ) {
    
        // update current entry
        $module->updateDBTable();
        
    } else {
    
        // create new entry
        $module->createNewEntry();
    }
    

} else {

    echo 'Skipping Module Table ... <br>';
    
}




// check to see if the parameter 'skipTables' was provided
$skipTables = isset($_REQUEST['skipTables']);

// if NOT then reset the tables...
if ( !$skipTables ) {

    /*
     * NavBarGroup Table
     *
     * Divides the NavBar into seperate Groups.  Links on the NavBar are under these groups.
     *
     * navbargroup_id [INTEGER]  Primary Key for this table
     * navbargroup_nameKey [STRING]  The multilingual lookup key to retrieve the group name.  '[group_[nameKey]]'
     * navbargroup_order [INTEGER]  defines the order in which the groups are to be displayed on the Nav Bar.
     */
    $NavBarGroup = new RowManager_NavBarGroupManager();

    $NavBarGroup->dropTable();
    $NavBarGroup->createTable();

    // NavBarGroup is a RowLabelBridge, so we must use that to create the initial
    // entries:
    $seriesKey = moduleNavBar::MULTILINGUAL_SERIES_KEY;
    $pageKey = RowManager_NavBarGroupManager::XML_NODE_NAME;
    $multiLingualContext = new MultilingualManager( 1, $seriesKey, $pageKey );
    $group = $NavBarGroup->getRowLabelBridge( $multiLingualContext );
    
    $values = array();
    $values[ 'label_label' ] = 'Admin';
    $group->loadFromArray( $values );
    $group->createNewEntry();
    
    
    /*
     * NavBarLinks Table
     *
     * Manages the actual links on the NavBar
     *
     * navbarlink_id [INTEGER]  Primary Key for this table
     * navbargroup_id [INTEGER]  Foreign Key relating this Link to a group
     * navbarlink_textKey [STRING]  the key for the multilingual content to display the name of this link. "[link_[textKey]]"
     * navbarlink_url [STRING]  the url of a link not tied to a site module.
     * module_id [INTEGER]  Foreign Key relating this link to a built in module for the site.
     * navbarlink_isActive [BOOL]  Bool flag turning link on or off.
     * navbarlink_isModule [BOOL]  Bool flag indicating if this link uses a module key or url.
     * navbarlink_order [INTEGER]  used for specifying which order this link should be displayed in the nav bar menu.
     */
    $NavBarLinks = new RowManager_NavBarLinksManager();

    $NavBarLinks->dropTable();
    $NavBarLinks->createTable();


    $seriesKey = moduleNavBar::MULTILINGUAL_SERIES_KEY;
    $pageKey = RowManager_NavBarLinksManager::XML_NODE_NAME;
    $multiLingualContext = new MultilingualManager( 1, $seriesKey, $pageKey );
    $link = $NavBarLinks->getRowLabelBridge( $multiLingualContext );
    
    $values = array();
    $values[ 'label_label' ] = 'Site Administration';
    $values[ 'navbargroup_id' ] = $group->getID();

    if (!defined( 'moduleAccountAdmin::MODULE_KEY' ) ) {
        require_once ( $extension.'modules/site_AccountAdmin/app_AccountAdmin.php' );
        require_once ( $extension.'modules/site_AccountAdmin/incl_AccountAdmin.php' );
    }
    $module = new RowManager_siteModuleManager();
    $module->loadByKey( moduleAccountAdmin::MODULE_KEY );
    
    $values[ 'module_id' ] = $module->getID();
    $values[ 'navbarlink_isActive' ] = 1;
    $values[ 'navbarlink_isModule' ] = 1;
    $values[ 'navbarlink_order' ] = 0;
    $link->loadFromArray( $values );
    $link->createNewEntry();


    /*
     * NavLinkAccessGroup Table
     *
     * This table joins which nav bar links are displayed for which site access group.
     *
     * navlinkaccessgroup_id [INTEGER]  Primary Key for this table
     * navbarlink_id [INTEGER]  Foreign Key relating this entry to a link
     * accessgroup_id [INTEGER]  Foreign key relating this link to a site Access Group
     */
    $navLinkAccessGroup = new RowManager_NavLinkAccessGroupManager();

    $navLinkAccessGroup->dropTable();
    $navLinkAccessGroup->createTable();

    // now link the "Site Administration" Access Group to the "Site Administration" link
    // first we have to flip over backwards to get the account group with the label "Site Administration"
    $accessGroup = new RowManager_AccessGroupManager();
    $seriesKey = moduleAccountAdmin::MULTILINGUAL_SERIES_KEY;
    $pageKey = RowManager_AccessGroupManager::XML_NODE_NAME;
    $multiLingualContext = new MultilingualManager( 1, $seriesKey, $pageKey );
    $group = $accessGroup->getRowLabelBridge( $multiLingualContext );
    $group->constructSearchCondition( 'label_label', OP_EQUAL, 'Site Administration', true);
    $list = $group->getListIterator();
    
    $list->setFirst();
    if ( $item = $list->getNext() ) {
        
        $navLinkAccessGroup->setGroupID( $item->getID() );
        $navLinkAccessGroup->setLinkID( $link->getID() );
        $navLinkAccessGroup->createNewEntry();
    }
    
    /*
     * NavLinkViewer Table
     *
     * Manages relationships between links and individual Viewers on the site.
     *
     * navlinkviewer_id [INTEGER]  Primary Key for this table
     * navbarlink_id [INTEGER]  Foreign Key pointing back to which link is being referenced.
     * viewer_id [INTEGER]  Foreign Key relating back to the viewer being assigned this link
     */
    $NavLinkViewer = new RowManager_NavLinkViewerManager();

    $NavLinkViewer->dropTable();
    $NavLinkViewer->createTable();


    /*
     * NavBarCache Table
     *
     * Stores the generated nav bar information for a user.
     *
     * navbarcache_id [INTEGER]  Primary Key for this table.
     * viewer_id [INTEGER]  Foreign Key linking this cache entry to a viewer.
     * language_id [INTEGER]  Foreign Key linking this cache entry to a particular language version. (each viewer can have a cache entry for each language)
     * navbarcache_cacheMain [STRING]  Holds the main nav bar data.
     * navbarcache_cacheSub [STRING]  Holds the sub menu data cache
     * navbarcache_isValid [BOOL]  BOOL flag indicating if this cache info is valid.
     */
    $NavBarCache = new RowManager_NavBarCacheManager();

    $NavBarCache->dropTable();
    $NavBarCache->createTable();



    /*
     * NavBarContentData Table
     *
     * Holds the multilingual content (labels) for the nav bar information.
     *
     * navbarcontent_id [INTEGER]  Primary Key for this table
     * language_id [INTEGER]  Foriegn Key linking this content to a language
     * navbarcontent_key [STRING]  The content key for this content data.  Values are usually either "[group[ID#]]" or "[label[ID#]]"
     * navbarcontent_data [STRING]  The actual content to be displayed on the page.
     */
//    $NavBarContentData = new RowManager_NavBarContentDataManager();

//    $NavBarContentData->dropTable();
//    $NavBarContentData->createTable();



    /*
     * NavBarXlate Table
     *
     * Holds the "needs to be Translated" information for the content data.
     *
     * navbarxlate_id [INTEGER]  Primary Key for this table
     * language_id [INTEGER]  Marks the language that the translation needs to be in.
     * navbarcontent_id [INTEGER]  Foreign Key linking to the content entry that needs the translation
     */
//    $NavBarXlate = new RowManager_NavBarXlateManager();

//    $NavBarXlate->dropTable();
//    $NavBarXlate->createTable();



/*[RAD_DAOBJ_TABLE]*/

    

} else {

    echo 'Skipping Tables ... <br>';
    
} // end if !skipTables




// check to see if parameter 'skipLabel' was provided
$skipLabel = isset( $_REQUEST['skipLabel'] );

// if not, then add labels to DB ...
if (!$skipLabel) {
        
        
    /*
     *  Insert Labels in DB
     */
    // Create Application Upload Series
    $labelManager = new  MultilingualManager();
    $labelManager->addSeries( moduleNavBar::MULTILINGUAL_SERIES_KEY );
    
    
    
    // Create General Field labels for moduleNavBar 
    $labelManager->addPage( moduleNavBar::MULTILINGUAL_PAGE_FIELDS );

    
    //
    // NavBarGroup table
    //
    $labelManager->addLabel( "[title_navbargroup_nameKey]", "Name", "en" );
    $labelManager->addLabel( "[formLabel_navbargroup_nameKey]", "Enter the nave of this group", "en" );
    $labelManager->addLabel( "[title_navbargroup_order]", "Order", "en" );
    $labelManager->addLabel( "[formLabel_navbargroup_order]", "Enter the order of display for this group", "en" );


    //
    // NavBarLinks table
    //
    $labelManager->addLabel( "[title_navbarlink_url]", "URL", "en" );
    $labelManager->addLabel( "[formLabel_navbarlink_url]", "Enter the Url for this link", "en" );
    $labelManager->addLabel( "[title_module_id]", "Module", "en" );
    $labelManager->addLabel( "[formLabel_module_id]", "Select the module for this link", "en" );
    $labelManager->addLabel( "[title_navbarlink_isActive]", "is Active?", "en" );
    $labelManager->addLabel( "[formLabel_navbarlink_isActive]", "Is this link active?", "en" );
    $labelManager->addLabel( "[title_navbarlink_isModule]", "is Module?", "en" );
    $labelManager->addLabel( "[formLabel_navbarlink_isModule]", "Is this link a site module?", "en" );
    $labelManager->addLabel( "[title_navbarlink_order]", "Order", "en" );
    $labelManager->addLabel( "[formLabel_navbarlink_order]", "Enter the order this link should appear in the group.", "en" );


    //
    // NavLinkAccessGroup table
    //
    $labelManager->addLabel( "[title_accessgroup_id]", "Access Group", "en" );
    $labelManager->addLabel( "[formLabel_accessgroup_id]", "Select the group that should see this link.", "en" );


    //
    // NavLinkViewer table
    //
    $labelManager->addLabel( "[title_viewer_id]", "Viewer", "en" );
    $labelManager->addLabel( "[formLabel_viewer_id]", "Select the Viewer for this link", "en" );


    //
    // NavBarCache table
    //


    //
    // NavBarContentData table
    //


    //
    // NavBarXlate table
    //


/*[RAD_FIELDS_LABEL]*/
    
    
    
    
    // Create GroupList labels 
    $labelManager->addPage( FormProcessor_GroupList::MULTILINGUAL_PAGE_KEY );

    $labelManager->addLabel( "[Title]", "Nav Bar Groups", "en" );
    $labelManager->addLabel( "[Instr]", "Use the following form to enter any NavBar groups.", "en" );
    $labelManager->addLabel( "[title_label_label]", "Group Name", "en" );
    $labelManager->addLabel( "[title_links]", "View Links?", "en" );
    $labelManager->addLabel( "[view]", "Links", "en" );
/*[RAD_PAGE(GroupList)_LABELS]*/



    // Create LinkList labels 
    $labelManager->addPage( FormProcessor_LinkList::MULTILINGUAL_PAGE_KEY );

    $labelManager->addLabel( "[Title]", "Nav Bar Links for Group [groupName]", "en" );
    $labelManager->addLabel( "[Instr]", "Use the following form to add links to this Nav Bar group.<br><br>Here you can enter either a manual link, or select from one of the predefined modules.  If you select a module, it will ignore anything you enter manually.<br><br>You can also enter an (optional) Start Date and an End Date.  The Link will become active during those times if you have them entered.", "en" );
    $labelManager->addLabel( "[viewAccessGroups]", "Access Groups", "en" );
    $labelManager->addLabel( "[viewViewers]", "Viewers", "en" );
    $labelManager->addLabel( "[groups]", "Groups", "en" );
    $labelManager->addLabel( "[viewers]", "Viewers", "en" );
    $labelManager->addLabel( "[title_label_label]", "Link", "en" );
    $labelManager->addLabel( "[formLabel_label_label]", "Enter the display name of the link", "en" );
    $labelManager->addLabel( "[formLabel_navbarlink_startDateTime]", "Enter a starting date & time for this link", "en" );
    $labelManager->addLabel( "[formLabel_navbarlink_endDateTime]", "Enter an ending date & time for this link", "en" );
    $labelManager->addLabel( "[title_navbarlink_startDateTime]", "Start Date", "en" );
    $labelManager->addLabel( "[title_navbarlink_endDateTime]", "End Date", "en" );
/*[RAD_PAGE(LinkList)_LABELS]*/



    // Create LinkGroups labels 
    $labelManager->addPage( FormProcessor_LinkGroups::MULTILINGUAL_PAGE_KEY );

    $labelManager->addLabel( "[Title]", "[linkName] Group Associations", "en" );
    $labelManager->addLabel( "[Instr]", "Use the following form to associate this link to a particular Access Group.<br><br>When a link is associated with a group, any user account that is associated with that group will see this link on their NavBar.", "en" );
/*[RAD_PAGE(LinkGroups)_LABELS]*/



    // Create LinkViewer labels 
    $labelManager->addPage( FormProcessor_LinkViewer::MULTILINGUAL_PAGE_KEY );

    $labelManager->addLabel( "[Title]", "[linkName] Viewers", "en" );
    $labelManager->addLabel( "[Instr]", "Use the following form to associate this link with a given viewer on the web site.<br><br>When a link is associated with a User Account, that account will see this link in their NavBar.", "en" );
/*[RAD_PAGE(LinkViewer)_LABELS]*/



/*[RAD_PAGE_LABEL]*/
    
    
} else {

    echo 'Skipping Labels ... <br>';
    
} // end if !skipLabels


?>