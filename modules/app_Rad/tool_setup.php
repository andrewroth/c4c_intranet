<?PHP
$pathFile = 'General/gen_Includes.php';
$extension = '';
    
// Attempt to find proper directory from current page to Root ...
$numAttempts = 0;
while ( (!file_exists($extension.$pathFile)) && ( $numAttempts < 5) ) {
    
    $extension = '../'.$extension;
    $numAttempts++; 
}
require ( $extension.$pathFile );

require ( 'app_RAD.php' );
require ( 'incl_RAD.php');


/*
 *  Directory Setup
 *
 *  Setup any specific directories used by this module.
 */
/*
if( !file_exists( moduleRAD::DEF_DIR_DATA ) ) { 
    mkdir( moduleRAD::DEF_DIR_DATA);
}
*/

echo '<table>';

$db = new Database_Site();
$db->connectToDB( SITE_DB_NAME, SITE_DB_PATH, SITE_DB_USER, SITE_DB_PWORD);

$sql = "USE ".SITE_DB_NAME;
runSQL( $sql );




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
    
    
    $module->loadByKey( moduleRAD::MODULE_KEY );
    $module->setKey( moduleRAD::MODULE_KEY );
    $module->setPath( 'modules/app_Rad/' );
    $module->setApplicationFile( 'app_RAD.php' );
    $module->setIncludeFile( 'incl_RAD.php' );
    $module->setName( 'moduleRAD' );
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
     * Module Table
     *
     * Tracks the modules being managed by the RAD Tools
     *
     * module_id [INTEGER]  The Primary Key for this table
     * module_name [STRING]  The Name of the module
     * module_desc [STRING]  The description of this module
     * module_creatorName [STRING]  The name of the person(s) designing this module
     * module_isCommonLook [BOOL]  BOOL: do the pages in this module share a commong look and feel?
     * module_isCore [BOOL]  BOOL: Is this module part of the core site system?
     * module_isCreated [BOOL]  BOOL: has this module already been created (basic directory & core files)?
     */
    $tableName = RowManager_ModuleManager::DB_TABLE;
    $sql = "DROP TABLE IF EXISTS ".$tableName;
    runSQL( $sql );
    
    $sql = "CREATE TABLE ".$tableName." (
      module_id int(11) NOT NULL  auto_increment,
      module_name varchar(50) NOT NULL  default '',
      module_desc text NOT NULL  default '',
      module_creatorName text NOT NULL  default '',
      module_isCommonLook int(1) NOT NULL  default '0',
      module_isCore int(1) NOT NULL  default '0',
      module_isCreated int(1) NOT NULL  default '0',
      PRIMARY KEY (module_id)
    ) TYPE=MyISAM";
    runSQL( $sql );
    
    
    
    /*
     * StateVar Table
     *
     * Manages the state variables used to track the state of this module
     *
     * statevar_id [INTEGER]  Primary Key for this table
     * module_id [INTEGER]  Foreign Key linking this state variable to a module
     * statevar_name [STRING]  Name of this state variable
     * statevar_desc [STRING]  Description of this state variable
     * statevar_type [STRING]  Defines the variable type for this state variable (STRING, INTEGER, BOOL, DATE)
     * statevar_default [STRING]  Default value for this state variable.  Leaving blank = ""
     * statevar_isCreated [BOOL]  BOOL: has this state variable been created in the module?
     * statevar_isUpdated [BOOL]  BOOL: has the state variable definition changed?
     */
    $tableName = RowManager_StateVarManager::DB_TABLE;
    $sql = "DROP TABLE IF EXISTS ".$tableName;
    runSQL( $sql );
    
    $sql = "CREATE TABLE ".$tableName." (
      statevar_id int(11) NOT NULL  auto_increment,
      module_id int(11) NOT NULL  default '0',
      statevar_name varchar(50) NOT NULL  default '',
      statevar_desc text NOT NULL  default '',
      statevar_type enum('STRING','BOOL','INTEGER','DATE') NOT NULL  default 'STRING',
      statevar_default varchar(50) NOT NULL  default '',
      statevar_isCreated int(1) NOT NULL  default '0',
      statevar_isUpdated int(1) NOT NULL  default '0',
      PRIMARY KEY (statevar_id)
    ) TYPE=MyISAM";
    runSQL( $sql );
    
    
    
    /*
     * DAObj Table
     *
     * Manages the Data Access Objects for this module.
     *
     * daobj_id [INTEGER]  Primary Key for this table
     * module_id [INTEGER]  Foreign Key linking this DAObj to a module
     * daobj_name [STRING]  Name of this Data Access Object
     * daobj_desc [STRING]  Decription of this Data Access Object
     * daobj_dbTableName [STRING]  Name of the database table this data access object manages
     * daobj_managerInitVarID [INTEGER]  The ID of the state variable that initializes the Row Manager object.
     * daobj_listInitVarID [INTEGER]  The ID of the state variable that initializes the list manager object
     * daobj_isCreated [BOOL]  BOOL: has this entry already been created?
     * daobj_isUpdated [BOOL]  BOOL: has this entry been updated?
     */
    $tableName = RowManager_DAObjManager::DB_TABLE;
    $sql = "DROP TABLE IF EXISTS ".$tableName;
    runSQL( $sql );
    
    $sql = "CREATE TABLE ".$tableName." (
      daobj_id int(11) NOT NULL  auto_increment,
      module_id int(11) NOT NULL  default '0',
      daobj_name varchar(50) NOT NULL  default '',
      daobj_desc text NOT NULL  default '',
      daobj_dbTableName varchar(100) NOT NULL  default '',
      daobj_managerInitVarID int(11) NOT NULL  default '0',
      daobj_listInitVarID int(11) NOT NULL  default '0',
      daobj_isCreated int(1) NOT NULL  default '0',
      daobj_isUpdated int(1) NOT NULL  default '0',
      PRIMARY KEY (daobj_id)
    ) TYPE=MyISAM";
    runSQL( $sql );
    
    
    
    /*
     * DAField Table
     *
     * Tracks each field that is part of a Data Access Object
     *
     * dafield_id [INTEGER]  Primary key for this table
     * daobj_id [INTEGER]  Foreign Key linking this field to a data access object
     * statevar_id [INTEGER]  Foreign Key linking this field to a state variable (useful for foreign keys to know how to pass in the proper data)
     * dafield_name [STRING]  Name of this field (DB Table Column format)
     * dafield_desc [STRING]  Description of this field
     * dafield_type [STRING]  The type of value this field represents (STRING, INTEGER, DATE, BOOLEAN)
     * dafield_dbType [STRING]  The type of table column in the DB
     * dafield_formFieldType [STRING]  The type of Form Field used to enter this data on a form (textbox, textarea, etc...)
     * dafield_isPrimaryKey [BOOL]  BOOL: is this field a primary key for the table?
     * dafield_isForeignKey [BOOL]  BOOL: is this field a foreign key to another table?
     * dafield_isNullable [BOOL]  BOOL: can this field be NULL?
     * dafield_default [STRING]  The default value for this field
     * dafield_invalidValue [STRING]  The value returned from a form that would be invalid for this field. (leaving blank = "", putting "<skip>" means accept any value)
     * dafield_isLabelName [BOOL]  BOOL: is this field used for displaying the Row's label (form Grid row labels, drop list labels, etc...)
     * dafield_isListInit [BOOL]  BOOL: is this the field used to initialize the List Manager object?
     * dafield_isCreated [BOOL]  BOOL: has this entry already been created?
     * dafield_title [STRING]  The label used for Titles for this field.
     * dafield_formLabel [STRING]  The text to use for Form Labels when entering data for this field in a form.
     * dafield_example [STRING]  The text to use when displaying an example for this field's form item.
     * dafield_error [STRING]  The text to use when displaying this field's error message
     */
    $tableName = RowManager_DAFieldManager::DB_TABLE;
    $sql = "DROP TABLE IF EXISTS ".$tableName;
    runSQL( $sql );
    
    $sql = "CREATE TABLE ".$tableName." (
      dafield_id int(11) NOT NULL  auto_increment,
      daobj_id int(11) NOT NULL  default '0',
      statevar_id int(11) NOT NULL  default '-1',
      dafield_name varchar(50) NOT NULL  default '',
      dafield_desc text NOT NULL  default '',
      dafield_type varchar(50) NOT NULL  default '',
      dafield_dbType varchar(50) NOT NULL  default '',
      dafield_formFieldType varchar(50) NOT NULL  default '',
      dafield_isPrimaryKey int(1) NOT NULL  default '0',
      dafield_isForeignKey int(1) NOT NULL  default '0',
      dafield_isNullable int(1) NOT NULL  default '0',
      dafield_default varchar(50) NOT NULL  default '',
      dafield_invalidValue varchar(50) NOT NULL  default '',
      dafield_isLabelName int(1) NOT NULL  default '0',
      dafield_isListInit int(1) NOT NULL  default '0',
      dafield_isCreated int(1) NOT NULL  default '0',
      dafield_title text NOT NULL  default '',
      dafield_formLabel text NOT NULL  default '',
      dafield_example text NOT NULL  default '',
      dafield_error text NOT NULL  default '',
      PRIMARY KEY (dafield_id)
    ) TYPE=MyISAM";
    runSQL( $sql );
    
    
    
    /*
     * Page Table
     *
     * Manages all the pages related to a module
     *
     * page_id [INTEGER]  Primary Key for this table
     * module_id [INTEGER]  Foreign Key linking this page to a module
     * page_name [STRING]  Name of this page
     * page_desc [STRING]  Description of this page
     * page_type [STRING]  The type of page this is (AdminBox, DataList, Single Entry Form, etc...)
     * page_isAdd [BOOL]  BOOL: is this page an ADD type of form
     * page_rowMgrID [INTEGER]  The ID of the Data Access Object used to manage the form data.
     * page_listMgrID [INTEGER]  ID of the Data Access Object used to manage the list information on this page.
     * page_isCreated [BOOL]  BOOL: has this page already been created?
     * page_isDefault [BOOL]  BOOL: is this page the default page in the module?
     */
    $tableName = RowManager_PageManager::DB_TABLE;
    $sql = "DROP TABLE IF EXISTS ".$tableName;
    runSQL( $sql );
    
    $sql = "CREATE TABLE ".$tableName." (
      page_id int(11) NOT NULL  auto_increment,
      module_id int(11) NOT NULL  default '0',
      page_name varchar(50) NOT NULL  default '',
      page_desc text NOT NULL  default '',
      page_type varchar(5) NOT NULL  default '',
      page_isAdd int(1) NOT NULL  default '0',
      page_rowMgrID int(11) NOT NULL  default '0',
      page_listMgrID int(11) NOT NULL  default '0',
      page_isCreated int(1) NOT NULL  default '0',
      page_isDefault int(1) NOT NULL  default '0',
      PRIMARY KEY (page_id)
    ) TYPE=MyISAM";
    runSQL( $sql );
    
    
    
    /*
     * PageField Table
     *
     * links a page to the DA Obj fields it uses.
     *
     * pagefield_id [INTEGER]  Primary Key for this table
     * page_id [INTEGER]  Foreign Key linking this field to a page
     * daobj_id [INTEGER]  Links this field back to it's Data Access object
     * dafield_id [INTEGER]  links this field back to the Data Access Field 
     * pagefield_isForm [BOOL]  BOOL: is this field related to the form manager (1) or list manager (0)
     */
    $tableName = RowManager_PageFieldManager::DB_TABLE;
    $sql = "DROP TABLE IF EXISTS ".$tableName;
    runSQL( $sql );
    
    $sql = "CREATE TABLE ".$tableName." (
      pagefield_id int(11) NOT NULL  auto_increment,
      page_id int(11) NOT NULL  default '0',
      daobj_id int(11) NOT NULL  default '0',
      dafield_id int(11) NOT NULL  default '0',
      pagefield_isForm int(1) NOT NULL  default '0',
      PRIMARY KEY (pagefield_id)
    ) TYPE=MyISAM";
    runSQL( $sql );
    
    
    
    /*
     * PageLabels Table
     *
     * Tracks any additional labels needed by a page.
     *
     * pagelabel_id [INTEGER]  Primary Key for this field
     * page_id [INTEGER]  Foreign key linking this label to a page
     * pagelabel_key [STRING]  The multilingual key lookup value for this label.
     * pagelabel_label [STRING]  The multilingual label value for this label
     * language_id [INTEGER]  The foreign key linking this label to a site language.
     * pagelabel_isCreated [BOOL]  BOOL: has this label already been created?
     */
    $tableName = RowManager_PageLabelsManager::DB_TABLE;
    $sql = "DROP TABLE IF EXISTS ".$tableName;
    runSQL( $sql );
    
    $sql = "CREATE TABLE ".$tableName." (
      pagelabel_id int(11) NOT NULL  auto_increment,
      page_id int(11) NOT NULL  default '0',
      pagelabel_key varchar(50) NOT NULL  default '',
      pagelabel_label text NOT NULL  default '',
      language_id int(11) NOT NULL  default '0',
      pagelabel_isCreated int(1) NOT NULL  default '0',
      PRIMARY KEY (pagelabel_id)
    ) TYPE=MyISAM";
    runSQL( $sql );
    
    
    
    /*
     * Transitions Table
     *
     * Tracks the standard transitions between pages
     *
     * transition_id [INTEGER]  Primary Key for this table
     * module_id [INTEGER]  Foreign Key linking this transition to a module
     * transition_fromObjID [INTEGER]  ID of the page that the transition is coming FROM
     * transition_toObjID [INTEGER]  ID of the page this transition is moving TO
     * transition_type [STRING]  Type of transition (form, edit, delete, add, etc...)
     * transition_isCreated [BOOL]  BOOL: has this transition already been processed?
     */
    $tableName = RowManager_TransitionsManager::DB_TABLE;
    $sql = "DROP TABLE IF EXISTS ".$tableName;
    runSQL( $sql );
    
    $sql = "CREATE TABLE ".$tableName." (
      transition_id int(11) NOT NULL  auto_increment,
      module_id int(11) NOT NULL  default '0',
      transition_fromObjID int(11) NOT NULL  default '0',
      transition_toObjID int(11) NOT NULL  default '0',
      transition_type varchar(10) NOT NULL  default '',
      transition_isCreated int(1) NOT NULL  default '0',
      PRIMARY KEY (transition_id)
    ) TYPE=MyISAM";
    runSQL( $sql );
    
    
    
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
    $sql = "INSERT INTO ".XMLObject_MultilingualManager::DB_TABLE_SERIES." (series_key) VALUES ('".moduleRAD::MULTILINGUAL_SERIES_KEY."' )";
    runSQL( $sql );
    
    $seriesID = $db->getPrimaryKey();
    
    
    // Create General Field labels for moduleRAD 
    $sql = "INSERT INTO ".XMLObject_MultilingualManager::DB_TABLE_PAGE." (series_id, page_key) VALUES ( ".$seriesID.", '".moduleRAD::MULTILINGUAL_PAGE_FIELDS."' )";
    runSQL( $sql );
    
    $pageID = $db->getPrimaryKey();
    
    
    $tableName = XMLObject_MultilingualManager::DB_TABLE_LABEL;
    
    //
    // Module table
    //
    $sql = "INSERT INTO ".$tableName." (page_id, label_key, label_label, language_id) VALUES ( ".$pageID.", '[title_module_name]', 'Name', 1 )";
    runSQL( $sql );
    
    $sql = "INSERT INTO ".$tableName." (page_id, label_key, label_label, language_id) VALUES ( ".$pageID.", '[formLabel_module_name]', 'Enter the Module Name', 1 )";
    runSQL( $sql );
    
    $sql = "INSERT INTO ".$tableName." (page_id, label_key, label_label, language_id) VALUES ( ".$pageID.", '[title_module_desc]', 'Description', 1 )";
    runSQL( $sql );
    
    $sql = "INSERT INTO ".$tableName." (page_id, label_key, label_label, language_id) VALUES ( ".$pageID.", '[formLabel_module_desc]', 'Enter the description', 1 )";
    runSQL( $sql );
    
    $sql = "INSERT INTO ".$tableName." (page_id, label_key, label_label, language_id) VALUES ( ".$pageID.", '[title_module_creatorName]', 'Creator', 1 )";
    runSQL( $sql );
    
    $sql = "INSERT INTO ".$tableName." (page_id, label_key, label_label, language_id) VALUES ( ".$pageID.", '[formLabel_module_creatorName]', 'Enter the Name of the designer', 1 )";
    runSQL( $sql );
    
    $sql = "INSERT INTO ".$tableName." (page_id, label_key, label_label, language_id) VALUES ( ".$pageID.", '[title_module_isCommonLook]', 'Common Look?', 1 )";
    runSQL( $sql );
    
    $sql = "INSERT INTO ".$tableName." (page_id, label_key, label_label, language_id) VALUES ( ".$pageID.", '[formLabel_module_isCommonLook]', 'Do the pages in this module share a common look?', 1 )";
    runSQL( $sql );
    
    $sql = "INSERT INTO ".$tableName." (page_id, label_key, label_label, language_id) VALUES ( ".$pageID.", '[title_module_isCore]', 'Is Core?', 1 )";
    runSQL( $sql );
    
    $sql = "INSERT INTO ".$tableName." (page_id, label_key, label_label, language_id) VALUES ( ".$pageID.", '[formLabel_module_isCore]', 'Is this module part of the core site system?', 1 )";
    runSQL( $sql );
    
    $sql = "INSERT INTO ".$tableName." (page_id, label_key, label_label, language_id) VALUES ( ".$pageID.", '[title_module_isCreated]', 'Is Created?', 1 )";
    runSQL( $sql );
    
    $sql = "INSERT INTO ".$tableName." (page_id, label_key, label_label, language_id) VALUES ( ".$pageID.", '[formLabel_module_isCreated]', 'Has this module been created?', 1 )";
    runSQL( $sql );
    
    
    
    //
    // StateVar table
    //
    $sql = "INSERT INTO ".$tableName." (page_id, label_key, label_label, language_id) VALUES ( ".$pageID.", '[title_statevar_name]', 'Name', 1 )";
    runSQL( $sql );
    
    $sql = "INSERT INTO ".$tableName." (page_id, label_key, label_label, language_id) VALUES ( ".$pageID.", '[formLabel_statevar_name]', 'Enter the name', 1 )";
    runSQL( $sql );
    
    $sql = "INSERT INTO ".$tableName." (page_id, label_key, label_label, language_id) VALUES ( ".$pageID.", '[title_statevar_desc]', 'Desc', 1 )";
    runSQL( $sql );
    
    $sql = "INSERT INTO ".$tableName." (page_id, label_key, label_label, language_id) VALUES ( ".$pageID.", '[formLabel_statevar_desc]', 'Enter a description', 1 )";
    runSQL( $sql );
    
    $sql = "INSERT INTO ".$tableName." (page_id, label_key, label_label, language_id) VALUES ( ".$pageID.", '[title_statevar_type]', 'Type', 1 )";
    runSQL( $sql );
    
    $sql = "INSERT INTO ".$tableName." (page_id, label_key, label_label, language_id) VALUES ( ".$pageID.", '[formLabel_statevar_type]', 'Select the Type', 1 )";
    runSQL( $sql );
    
    $sql = "INSERT INTO ".$tableName." (page_id, label_key, label_label, language_id) VALUES ( ".$pageID.", '[title_statevar_default]', 'Default', 1 )";
    runSQL( $sql );
    
    $sql = "INSERT INTO ".$tableName." (page_id, label_key, label_label, language_id) VALUES ( ".$pageID.", '[formLabel_statevar_default]', 'Enter a default value', 1 )";
    runSQL( $sql );
    
    $sql = "INSERT INTO ".$tableName." (page_id, label_key, label_label, language_id) VALUES ( ".$pageID.", '[title_statevar_isCreated]', 'is Created', 1 )";
    runSQL( $sql );
    
    $sql = "INSERT INTO ".$tableName." (page_id, label_key, label_label, language_id) VALUES ( ".$pageID.", '[formLabel_statevar_isCreated]', 'Has this entry been created?', 1 )";
    runSQL( $sql );
    
    $sql = "INSERT INTO ".$tableName." (page_id, label_key, label_label, language_id) VALUES ( ".$pageID.", '[title_statevar_isUpdated]', 'is Updated', 1 )";
    runSQL( $sql );
    
    $sql = "INSERT INTO ".$tableName." (page_id, label_key, label_label, language_id) VALUES ( ".$pageID.", '[formLabel_statevar_isUpdated]', 'Has this entry been updated', 1 )";
    runSQL( $sql );
    
    
    
    //
    // DAObj table
    //
    $sql = "INSERT INTO ".$tableName." (page_id, label_key, label_label, language_id) VALUES ( ".$pageID.", '[title_daobj_name]', 'Name', 1 )";
    runSQL( $sql );
    
    $sql = "INSERT INTO ".$tableName." (page_id, label_key, label_label, language_id) VALUES ( ".$pageID.", '[formLabel_daobj_name]', 'Enter the name', 1 )";
    runSQL( $sql );
    
    $sql = "INSERT INTO ".$tableName." (page_id, label_key, label_label, language_id) VALUES ( ".$pageID.", '[title_daobj_desc]', 'Description', 1 )";
    runSQL( $sql );
    
    $sql = "INSERT INTO ".$tableName." (page_id, label_key, label_label, language_id) VALUES ( ".$pageID.", '[formLabel_daobj_desc]', 'Enter a description', 1 )";
    runSQL( $sql );
    
    $sql = "INSERT INTO ".$tableName." (page_id, label_key, label_label, language_id) VALUES ( ".$pageID.", '[title_daobj_dbTableName]', 'DB Table', 1 )";
    runSQL( $sql );
    
    $sql = "INSERT INTO ".$tableName." (page_id, label_key, label_label, language_id) VALUES ( ".$pageID.", '[formLabel_daobj_dbTableName]', 'Enter the DB table', 1 )";
    runSQL( $sql );
    
    $sql = "INSERT INTO ".$tableName." (page_id, label_key, label_label, language_id) VALUES ( ".$pageID.", '[title_daobj_managerInitVarID]', 'Row Manager Init', 1 )";
    runSQL( $sql );
    
    $sql = "INSERT INTO ".$tableName." (page_id, label_key, label_label, language_id) VALUES ( ".$pageID.", '[formLabel_daobj_managerInitVarID]', 'Select the state variable used to create a Row manager', 1 )";
    runSQL( $sql );
    
    $sql = "INSERT INTO ".$tableName." (page_id, label_key, label_label, language_id) VALUES ( ".$pageID.", '[title_daobj_listInitVarID]', 'List manager Init', 1 )";
    runSQL( $sql );
    
    $sql = "INSERT INTO ".$tableName." (page_id, label_key, label_label, language_id) VALUES ( ".$pageID.", '[formLabel_daobj_listInitVarID]', 'Select the state variable used to create a List Iterator', 1 )";
    runSQL( $sql );
    
    $sql = "INSERT INTO ".$tableName." (page_id, label_key, label_label, language_id) VALUES ( ".$pageID.", '[title_daobj_isCreated]', 'is Created?', 1 )";
    runSQL( $sql );
    
    $sql = "INSERT INTO ".$tableName." (page_id, label_key, label_label, language_id) VALUES ( ".$pageID.", '[formLabel_daobj_isCreated]', 'Has this entry been created?', 1 )";
    runSQL( $sql );
    
    $sql = "INSERT INTO ".$tableName." (page_id, label_key, label_label, language_id) VALUES ( ".$pageID.", '[title_daobj_isUpdated]', 'is Updated?', 1 )";
    runSQL( $sql );
    
    $sql = "INSERT INTO ".$tableName." (page_id, label_key, label_label, language_id) VALUES ( ".$pageID.", '[formLabel_daobj_isUpdated]', 'Has this entry been updated?', 1 )";
    runSQL( $sql );
    
    
    
    //
    // DAField table
    //
    $sql = "INSERT INTO ".$tableName." (page_id, label_key, label_label, language_id) VALUES ( ".$pageID.", '[title_statevar_id]', 'StateVar', 1 )";
    runSQL( $sql );
    
    $sql = "INSERT INTO ".$tableName." (page_id, label_key, label_label, language_id) VALUES ( ".$pageID.", '[formLabel_statevar_id]', 'If this is a foreign Key, select a statevar that is connected to it (if any)', 1 )";
    runSQL( $sql );
    
    $sql = "INSERT INTO ".$tableName." (page_id, label_key, label_label, language_id) VALUES ( ".$pageID.", '[title_dafield_name]', 'Name', 1 )";
    runSQL( $sql );
    
    $sql = "INSERT INTO ".$tableName." (page_id, label_key, label_label, language_id) VALUES ( ".$pageID.", '[formLabel_dafield_name]', 'Enter the name', 1 )";
    runSQL( $sql );
    
    $sql = "INSERT INTO ".$tableName." (page_id, label_key, label_label, language_id) VALUES ( ".$pageID.", '[title_dafield_desc]', 'Description', 1 )";
    runSQL( $sql );
    
    $sql = "INSERT INTO ".$tableName." (page_id, label_key, label_label, language_id) VALUES ( ".$pageID.", '[formLabel_dafield_desc]', 'Describe this field', 1 )";
    runSQL( $sql );
    
    $sql = "INSERT INTO ".$tableName." (page_id, label_key, label_label, language_id) VALUES ( ".$pageID.", '[title_dafield_type]', 'Var Type', 1 )";
    runSQL( $sql );
    
    $sql = "INSERT INTO ".$tableName." (page_id, label_key, label_label, language_id) VALUES ( ".$pageID.", '[formLabel_dafield_type]', 'Select the variable type', 1 )";
    runSQL( $sql );
    
    $sql = "INSERT INTO ".$tableName." (page_id, label_key, label_label, language_id) VALUES ( ".$pageID.", '[title_dafield_dbType]', 'DB Field Type', 1 )";
    runSQL( $sql );
    
    $sql = "INSERT INTO ".$tableName." (page_id, label_key, label_label, language_id) VALUES ( ".$pageID.", '[formLabel_dafield_dbType]', 'Select the DB field type', 1 )";
    runSQL( $sql );
    
    $sql = "INSERT INTO ".$tableName." (page_id, label_key, label_label, language_id) VALUES ( ".$pageID.", '[title_dafield_formFieldType]', 'Form Type', 1 )";
    runSQL( $sql );
    
    $sql = "INSERT INTO ".$tableName." (page_id, label_key, label_label, language_id) VALUES ( ".$pageID.", '[formLabel_dafield_formFieldType]', 'Select the Form Field type', 1 )";
    runSQL( $sql );
    
    $sql = "INSERT INTO ".$tableName." (page_id, label_key, label_label, language_id) VALUES ( ".$pageID.", '[title_dafield_isPrimaryKey]', 'Primary Key?', 1 )";
    runSQL( $sql );
    
    $sql = "INSERT INTO ".$tableName." (page_id, label_key, label_label, language_id) VALUES ( ".$pageID.", '[formLabel_dafield_isPrimaryKey]', 'Is this field the primary key?', 1 )";
    runSQL( $sql );
    
    $sql = "INSERT INTO ".$tableName." (page_id, label_key, label_label, language_id) VALUES ( ".$pageID.", '[title_dafield_isForeignKey]', 'Foreign Key?', 1 )";
    runSQL( $sql );
    
    $sql = "INSERT INTO ".$tableName." (page_id, label_key, label_label, language_id) VALUES ( ".$pageID.", '[formLabel_dafield_isForeignKey]', 'is this field a foreign key? <br><span class=\"smalltext\">(true only if value is REQUIRED)</span>', 1 )";
    runSQL( $sql );
    
    $sql = "INSERT INTO ".$tableName." (page_id, label_key, label_label, language_id) VALUES ( ".$pageID.", '[title_dafield_isNullable]', 'Nullable?', 1 )";
    runSQL( $sql );
    
    $sql = "INSERT INTO ".$tableName." (page_id, label_key, label_label, language_id) VALUES ( ".$pageID.", '[formLabel_dafield_isNullable]', 'Can this field be NULL?', 1 )";
    runSQL( $sql );
    
    $sql = "INSERT INTO ".$tableName." (page_id, label_key, label_label, language_id) VALUES ( ".$pageID.", '[title_dafield_default]', 'Default', 1 )";
    runSQL( $sql );
    
    $sql = "INSERT INTO ".$tableName." (page_id, label_key, label_label, language_id) VALUES ( ".$pageID.", '[formLabel_dafield_default]', 'Enter a default value', 1 )";
    runSQL( $sql );
    
    $sql = "INSERT INTO ".$tableName." (page_id, label_key, label_label, language_id) VALUES ( ".$pageID.", '[title_dafield_invalidValue]', 'Invalid', 1 )";
    runSQL( $sql );
    
    $sql = "INSERT INTO ".$tableName." (page_id, label_key, label_label, language_id) VALUES ( ".$pageID.", '[formLabel_dafield_invalidValue]', 'Enter an Invalid Value<br><span class=\"smalltext\">(this refers to values returned from the form item)</span>', 1 )";
    runSQL( $sql );
    
    $sql = "INSERT INTO ".$tableName." (page_id, label_key, label_label, language_id) VALUES ( ".$pageID.", '[title_dafield_isLabelName]', 'Label?', 1 )";
    runSQL( $sql );
    
    $sql = "INSERT INTO ".$tableName." (page_id, label_key, label_label, language_id) VALUES ( ".$pageID.", '[formLabel_dafield_isLabelName]', 'Should this field be used for this table''s label?<br><span class=\"smalltext\">(Form Grid Row Labels, Drop List labels, etc...)</span>', 1 )";
    runSQL( $sql );
    
    $sql = "INSERT INTO ".$tableName." (page_id, label_key, label_label, language_id) VALUES ( ".$pageID.", '[title_dafield_isListInit]', 'ListInit?', 1 )";
    runSQL( $sql );
    
    $sql = "INSERT INTO ".$tableName." (page_id, label_key, label_label, language_id) VALUES ( ".$pageID.", '[formLabel_dafield_isListInit]', 'Is this field used to initialize it''s List Iterator object', 1 )";
    runSQL( $sql );
    
    $sql = "INSERT INTO ".$tableName." (page_id, label_key, label_label, language_id) VALUES ( ".$pageID.", '[title_dafield_isCreated]', 'Created?', 1 )";
    runSQL( $sql );
    
    $sql = "INSERT INTO ".$tableName." (page_id, label_key, label_label, language_id) VALUES ( ".$pageID.", '[formLabel_dafield_isCreated]', 'Has this field already been created?', 1 )";
    runSQL( $sql );
    
    $sql = "INSERT INTO ".$tableName." (page_id, label_key, label_label, language_id) VALUES ( ".$pageID.", '[title_dafield_title]', 'Title', 1 )";
    runSQL( $sql );
    
    $sql = "INSERT INTO ".$tableName." (page_id, label_key, label_label, language_id) VALUES ( ".$pageID.", '[formLabel_dafield_title]', 'Enter the text for a title', 1 )";
    runSQL( $sql );
    
    $sql = "INSERT INTO ".$tableName." (page_id, label_key, label_label, language_id) VALUES ( ".$pageID.", '[title_dafield_formLabel]', 'Form Label', 1 )";
    runSQL( $sql );
    
    $sql = "INSERT INTO ".$tableName." (page_id, label_key, label_label, language_id) VALUES ( ".$pageID.", '[formLabel_dafield_formLabel]', 'Enter the text for a form label', 1 )";
    runSQL( $sql );
    
    $sql = "INSERT INTO ".$tableName." (page_id, label_key, label_label, language_id) VALUES ( ".$pageID.", '[title_dafield_example]', 'Example', 1 )";
    runSQL( $sql );
    
    $sql = "INSERT INTO ".$tableName." (page_id, label_key, label_label, language_id) VALUES ( ".$pageID.", '[formLabel_dafield_example]', 'Enter the text for an example', 1 )";
    runSQL( $sql );
    
    $sql = "INSERT INTO ".$tableName." (page_id, label_key, label_label, language_id) VALUES ( ".$pageID.", '[title_dafield_error]', 'Error', 1 )";
    runSQL( $sql );
    
    $sql = "INSERT INTO ".$tableName." (page_id, label_key, label_label, language_id) VALUES ( ".$pageID.", '[formLabel_dafield_error]', 'Enter the text for an error', 1 )";
    runSQL( $sql );
    
    
    
    //
    // Page table
    //
    $sql = "INSERT INTO ".$tableName." (page_id, label_key, label_label, language_id) VALUES ( ".$pageID.", '[title_page_name]', 'Name', 1 )";
    runSQL( $sql );
    
    $sql = "INSERT INTO ".$tableName." (page_id, label_key, label_label, language_id) VALUES ( ".$pageID.", '[formLabel_page_name]', 'Enter the page Name', 1 )";
    runSQL( $sql );
    
    $sql = "INSERT INTO ".$tableName." (page_id, label_key, label_label, language_id) VALUES ( ".$pageID.", '[title_page_desc]', 'Desc', 1 )";
    runSQL( $sql );
    
    $sql = "INSERT INTO ".$tableName." (page_id, label_key, label_label, language_id) VALUES ( ".$pageID.", '[formLabel_page_desc]', 'Describe this page', 1 )";
    runSQL( $sql );
    
    $sql = "INSERT INTO ".$tableName." (page_id, label_key, label_label, language_id) VALUES ( ".$pageID.", '[title_page_type]', 'Type', 1 )";
    runSQL( $sql );
    
    $sql = "INSERT INTO ".$tableName." (page_id, label_key, label_label, language_id) VALUES ( ".$pageID.", '[formLabel_page_type]', 'Select the page type', 1 )";
    runSQL( $sql );
    
    $sql = "INSERT INTO ".$tableName." (page_id, label_key, label_label, language_id) VALUES ( ".$pageID.", '[title_page_isAdd]', 'is Add?', 1 )";
    runSQL( $sql );
    
    $sql = "INSERT INTO ".$tableName." (page_id, label_key, label_label, language_id) VALUES ( ".$pageID.", '[formLabel_page_isAdd]', 'Is this page an Add type of form?', 1 )";
    runSQL( $sql );
    
    $sql = "INSERT INTO ".$tableName." (page_id, label_key, label_label, language_id) VALUES ( ".$pageID.", '[title_page_rowMgrID]', 'Form Manager', 1 )";
    runSQL( $sql );
    
    $sql = "INSERT INTO ".$tableName." (page_id, label_key, label_label, language_id) VALUES ( ".$pageID.", '[formLabel_page_rowMgrID]', 'Select the DAObj used for Form data<br><span class=\"smalltext\">(AdminBox, Form, Form Grid)</span>', 1 )";
    runSQL( $sql );
    
    $sql = "INSERT INTO ".$tableName." (page_id, label_key, label_label, language_id) VALUES ( ".$pageID.", '[title_page_listMgrID]', 'List Manager', 1 )";
    runSQL( $sql );
    
    $sql = "INSERT INTO ".$tableName." (page_id, label_key, label_label, language_id) VALUES ( ".$pageID.", '[formLabel_page_listMgrID]', 'Select the DAObj used for the list data<br><span class=\"smalltext\">(AdminBox, Display List, Delete conf)</span>', 1 )";
    runSQL( $sql );
    
    $sql = "INSERT INTO ".$tableName." (page_id, label_key, label_label, language_id) VALUES ( ".$pageID.", '[title_page_isCreated]', 'Created?', 1 )";
    runSQL( $sql );
    
    $sql = "INSERT INTO ".$tableName." (page_id, label_key, label_label, language_id) VALUES ( ".$pageID.", '[formLabel_page_isCreated]', 'Has this page been created?', 1 )";
    runSQL( $sql );
    
    $sql = "INSERT INTO ".$tableName." (page_id, label_key, label_label, language_id) VALUES ( ".$pageID.", '[title_page_isDefault]', 'Default?', 1 )";
    runSQL( $sql );
    
    $sql = "INSERT INTO ".$tableName." (page_id, label_key, label_label, language_id) VALUES ( ".$pageID.", '[formLabel_page_isDefault]', 'Is this page the default page in the module?', 1 )";
    runSQL( $sql );
    
    
    
    //
    // PageField table
    //
    
    
    //
    // PageLabels table
    //
    $sql = "INSERT INTO ".$tableName." (page_id, label_key, label_label, language_id) VALUES ( ".$pageID.", '[title_pagelabel_key]', 'Key', 1 )";
    runSQL( $sql );
    
    $sql = "INSERT INTO ".$tableName." (page_id, label_key, label_label, language_id) VALUES ( ".$pageID.", '[formLabel_pagelabel_key]', 'Enter the lookup key', 1 )";
    runSQL( $sql );
    
    $sql = "INSERT INTO ".$tableName." (page_id, label_key, label_label, language_id) VALUES ( ".$pageID.", '[title_pagelabel_label]', 'Label', 1 )";
    runSQL( $sql );
    
    $sql = "INSERT INTO ".$tableName." (page_id, label_key, label_label, language_id) VALUES ( ".$pageID.", '[formLabel_pagelabel_label]', 'Enter the label text', 1 )";
    runSQL( $sql );
    
    $sql = "INSERT INTO ".$tableName." (page_id, label_key, label_label, language_id) VALUES ( ".$pageID.", '[title_language_id]', 'Language', 1 )";
    runSQL( $sql );
    
    $sql = "INSERT INTO ".$tableName." (page_id, label_key, label_label, language_id) VALUES ( ".$pageID.", '[formLabel_language_id]', 'Select the language', 1 )";
    runSQL( $sql );
    
    $sql = "INSERT INTO ".$tableName." (page_id, label_key, label_label, language_id) VALUES ( ".$pageID.", '[title_pagelabel_isCreated]', 'Created?', 1 )";
    runSQL( $sql );
    
    $sql = "INSERT INTO ".$tableName." (page_id, label_key, label_label, language_id) VALUES ( ".$pageID.", '[formLabel_pagelabel_isCreated]', 'Has this label been created?', 1 )";
    runSQL( $sql );
    
    
    
    //
    // Transitions table
    //
    $sql = "INSERT INTO ".$tableName." (page_id, label_key, label_label, language_id) VALUES ( ".$pageID.", '[title_transition_fromObjID]', 'Page From', 1 )";
    runSQL( $sql );
    
    $sql = "INSERT INTO ".$tableName." (page_id, label_key, label_label, language_id) VALUES ( ".$pageID.", '[formLabel_transition_fromObjID]', 'Selecte the page the transition is moving away from', 1 )";
    runSQL( $sql );
    
    $sql = "INSERT INTO ".$tableName." (page_id, label_key, label_label, language_id) VALUES ( ".$pageID.", '[title_transition_toObjID]', 'Page To', 1 )";
    runSQL( $sql );
    
    $sql = "INSERT INTO ".$tableName." (page_id, label_key, label_label, language_id) VALUES ( ".$pageID.", '[formLabel_transition_toObjID]', 'Select the page the transition is moving to', 1 )";
    runSQL( $sql );
    
    $sql = "INSERT INTO ".$tableName." (page_id, label_key, label_label, language_id) VALUES ( ".$pageID.", '[title_transition_type]', 'Type', 1 )";
    runSQL( $sql );
    
    $sql = "INSERT INTO ".$tableName." (page_id, label_key, label_label, language_id) VALUES ( ".$pageID.", '[formLabel_transition_type]', 'Select the type of transition', 1 )";
    runSQL( $sql );
    
    $sql = "INSERT INTO ".$tableName." (page_id, label_key, label_label, language_id) VALUES ( ".$pageID.", '[title_transition_isCreated]', 'Created?', 1 )";
    runSQL( $sql );
    
    $sql = "INSERT INTO ".$tableName." (page_id, label_key, label_label, language_id) VALUES ( ".$pageID.", '[formLabel_transition_isCreated]', 'Is Created?', 1 )";
    runSQL( $sql );
    
    
    
    /*[RAD_FIELDS_LABEL]*/
    
    
    
    
    // Create ModuleList labels 
        $sql = "INSERT INTO ".XMLObject_MultilingualManager::DB_TABLE_PAGE." (series_id, page_key) VALUES ( ".$seriesID.", '".page_ModuleList::MULTILINGUAL_PAGE_KEY."' )";
    runSQL( $sql );
        
    $pageID = $db->getPrimaryKey();
        
    $tableName = XMLObject_MultilingualManager::DB_TABLE_LABEL;
    
    
    
    $sql = "INSERT INTO ".$tableName." (page_id, label_key, label_label, language_id) VALUES ( ".$pageID.", '[Title]', 'Modules', 1 )";
    runSQL( $sql );
    
    $sql = "INSERT INTO ".$tableName." (page_id, label_key, label_label, language_id) VALUES ( ".$pageID.", '[Instr]', 'Click on the \"ADD\" link to add a module.<br>Click on \"View\" to see a summary of the module.', 1 )";
    runSQL( $sql );
    
    $sql = "INSERT INTO ".$tableName." (page_id, label_key, label_label, language_id) VALUES ( ".$pageID.", '[title_View]', 'Summary', 1 )";
    runSQL( $sql );
    
    $sql = "INSERT INTO ".$tableName." (page_id, label_key, label_label, language_id) VALUES ( ".$pageID.", '[view]', 'view', 1 )";
    runSQL( $sql );
    
    /*[RAD_PAGE(ModuleList)_LABELS]*/
    
    
    
    // Create AddModule labels 
        $sql = "INSERT INTO ".XMLObject_MultilingualManager::DB_TABLE_PAGE." (series_id, page_key) VALUES ( ".$seriesID.", '".FormProcessor_AddModule::MULTILINGUAL_PAGE_KEY."' )";
    runSQL( $sql );
        
    $pageID = $db->getPrimaryKey();
        
    $tableName = XMLObject_MultilingualManager::DB_TABLE_LABEL;
    
    
    
    $sql = "INSERT INTO ".$tableName." (page_id, label_key, label_label, language_id) VALUES ( ".$pageID.", '[Title]', 'Add Module', 1 )";
    runSQL( $sql );
    
    $sql = "INSERT INTO ".$tableName." (page_id, label_key, label_label, language_id) VALUES ( ".$pageID.", '[Instr]', 'Use this form to create a new module.', 1 )";
    runSQL( $sql );
    
    $sql = "INSERT INTO ".$tableName." (page_id, label_key, label_label, language_id) VALUES ( ".$pageID.", '[error_UniqueModuleName]', 'This name has already been taken', 1 )";
    runSQL( $sql );
    
    /*[RAD_PAGE(AddModule)_LABELS]*/
    
    
    
    // Create ViewModule labels 
        $sql = "INSERT INTO ".XMLObject_MultilingualManager::DB_TABLE_PAGE." (series_id, page_key) VALUES ( ".$seriesID.", '".page_ViewModule::MULTILINGUAL_PAGE_KEY."' )";
    runSQL( $sql );
        
    $pageID = $db->getPrimaryKey();
        
    $tableName = XMLObject_MultilingualManager::DB_TABLE_LABEL;
    
    
    
    $sql = "INSERT INTO ".$tableName." (page_id, label_key, label_label, language_id) VALUES ( ".$pageID.", '[Title]', '[moduleName] Summary', 1 )";
    runSQL( $sql );
    
    $sql = "INSERT INTO ".$tableName." (page_id, label_key, label_label, language_id) VALUES ( ".$pageID.", '[Instr]', 'Click on the \"Create Module\" link to make sure all parts of the module have been created.', 1 )";
    runSQL( $sql );
    
    $sql = "INSERT INTO ".$tableName." (page_id, label_key, label_label, language_id) VALUES ( ".$pageID.", '[Description]', 'Description:', 1 )";
    runSQL( $sql );
    
    $sql = "INSERT INTO ".$tableName." (page_id, label_key, label_label, language_id) VALUES ( ".$pageID.", '[titleStateVar]', 'State Var', 1 )";
    runSQL( $sql );
    
    $sql = "INSERT INTO ".$tableName." (page_id, label_key, label_label, language_id) VALUES ( ".$pageID.", '[titleDAObj]', 'DA Objects', 1 )";
    runSQL( $sql );
    
    $sql = "INSERT INTO ".$tableName." (page_id, label_key, label_label, language_id) VALUES ( ".$pageID.", '[titlePage]', 'Pages', 1 )";
    runSQL( $sql );
    
    $sql = "INSERT INTO ".$tableName." (page_id, label_key, label_label, language_id) VALUES ( ".$pageID.", '[titleTransitions]', 'Transitions', 1 )";
    runSQL( $sql );
    
    $sql = "INSERT INTO ".$tableName." (page_id, label_key, label_label, language_id) VALUES ( ".$pageID.", '[titleSideBar]', 'Side Bar', 1 )";
    runSQL( $sql );
    
    $sql = "INSERT INTO ".$tableName." (page_id, label_key, label_label, language_id) VALUES ( ".$pageID.", '[createModule]', 'Create Module', 1 )";
    runSQL( $sql );
    
    $sql = "INSERT INTO ".$tableName." (page_id, label_key, label_label, language_id) VALUES ( ".$pageID.", '[returnList]', 'Return to Module List', 1 )";
    runSQL( $sql );
    
    /*[RAD_PAGE(ViewModule)_LABELS]*/
    
    
    
    // Create AddStateVar labels 
        $sql = "INSERT INTO ".XMLObject_MultilingualManager::DB_TABLE_PAGE." (series_id, page_key) VALUES ( ".$seriesID.", '".FormProcessor_AddStateVar::MULTILINGUAL_PAGE_KEY."' )";
    runSQL( $sql );
        
    $pageID = $db->getPrimaryKey();
        
    $tableName = XMLObject_MultilingualManager::DB_TABLE_LABEL;
    
    
    
    $sql = "INSERT INTO ".$tableName." (page_id, label_key, label_label, language_id) VALUES ( ".$pageID.", '[Title]', '[moduleName]''s State Variables', 1 )";
    runSQL( $sql );
    
    $sql = "INSERT INTO ".$tableName." (page_id, label_key, label_label, language_id) VALUES ( ".$pageID.", '[Instr]', 'Use the following form to add state variables to this module.', 1 )";
    runSQL( $sql );
    
    $sql = "INSERT INTO ".$tableName." (page_id, label_key, label_label, language_id) VALUES ( ".$pageID.", '[error_UniqueName]', 'This name has already been taken', 1 )";
    runSQL( $sql );
    
    $sql = "INSERT INTO ".$tableName." (page_id, label_key, label_label, language_id) VALUES ( ".$pageID.", '[STRING]', 'String', 1 )";
    runSQL( $sql );
    
    $sql = "INSERT INTO ".$tableName." (page_id, label_key, label_label, language_id) VALUES ( ".$pageID.", '[INTEGER]', 'Integer', 1 )";
    runSQL( $sql );
    
    $sql = "INSERT INTO ".$tableName." (page_id, label_key, label_label, language_id) VALUES ( ".$pageID.", '[BOOL]', 'Bool', 1 )";
    runSQL( $sql );
    
    $sql = "INSERT INTO ".$tableName." (page_id, label_key, label_label, language_id) VALUES ( ".$pageID.", '[DATE]', 'Date', 1 )";
    runSQL( $sql );
    
    /*[RAD_PAGE(AddStateVar)_LABELS]*/
    
    
    
    // Create DAObjList labels 
        $sql = "INSERT INTO ".XMLObject_MultilingualManager::DB_TABLE_PAGE." (series_id, page_key) VALUES ( ".$seriesID.", '".page_DAObjList::MULTILINGUAL_PAGE_KEY."' )";
    runSQL( $sql );
        
    $pageID = $db->getPrimaryKey();
        
    $tableName = XMLObject_MultilingualManager::DB_TABLE_LABEL;
    
    
    
    $sql = "INSERT INTO ".$tableName." (page_id, label_key, label_label, language_id) VALUES ( ".$pageID.", '[Title]', '[moduleName]''s Data Access Objects', 1 )";
    runSQL( $sql );
    
    $sql = "INSERT INTO ".$tableName." (page_id, label_key, label_label, language_id) VALUES ( ".$pageID.", '[Instr]', 'Below is the list of Data Access Objects currently associated with this module.', 1 )";
    runSQL( $sql );
    
    
    /*[RAD_PAGE(DAObjList)_LABELS]*/
    
    
    
    // Create AddDAObj labels 
        $sql = "INSERT INTO ".XMLObject_MultilingualManager::DB_TABLE_PAGE." (series_id, page_key) VALUES ( ".$seriesID.", '".FormProcessor_AddDAObj::MULTILINGUAL_PAGE_KEY."' )";
    runSQL( $sql );
        
    $pageID = $db->getPrimaryKey();
        
    $tableName = XMLObject_MultilingualManager::DB_TABLE_LABEL;
    
    
    
    $sql = "INSERT INTO ".$tableName." (page_id, label_key, label_label, language_id) VALUES ( ".$pageID.", '[Title]', '[moduleName]: Add Data Access Object', 1 )";
    runSQL( $sql );
    
    $sql = "INSERT INTO ".$tableName." (page_id, label_key, label_label, language_id) VALUES ( ".$pageID.", '[Instr]', 'Use this form to add a new data access object.', 1 )";
    runSQL( $sql );
    
    $sql = "INSERT INTO ".$tableName." (page_id, label_key, label_label, language_id) VALUES ( ".$pageID.", '[error_UniqueName]', 'This name has already been taken', 1 )";
    runSQL( $sql );
    
    /*[RAD_PAGE(AddDAObj)_LABELS]*/
    
    
    
    // Create EditDAObj labels 
        $sql = "INSERT INTO ".XMLObject_MultilingualManager::DB_TABLE_PAGE." (series_id, page_key) VALUES ( ".$seriesID.", '".FormProcessor_EditDAObj::MULTILINGUAL_PAGE_KEY."' )";
    runSQL( $sql );
        
    $pageID = $db->getPrimaryKey();
        
    $tableName = XMLObject_MultilingualManager::DB_TABLE_LABEL;
    
    
    
    $sql = "INSERT INTO ".$tableName." (page_id, label_key, label_label, language_id) VALUES ( ".$pageID.", '[Title]', 'Edit [daobjName]', 1 )";
    runSQL( $sql );
    
    $sql = "INSERT INTO ".$tableName." (page_id, label_key, label_label, language_id) VALUES ( ".$pageID.", '[Instr]', 'Use this form to edit this Data Access Object.', 1 )";
    runSQL( $sql );
    
    $sql = "INSERT INTO ".$tableName." (page_id, label_key, label_label, language_id) VALUES ( ".$pageID.", '[error_UniqueName]', 'This name has already been taken', 1 )";
    runSQL( $sql );
    
    /*[RAD_PAGE(EditDAObj)_LABELS]*/
    
    
    
    // Create AddDAFields labels 
        $sql = "INSERT INTO ".XMLObject_MultilingualManager::DB_TABLE_PAGE." (series_id, page_key) VALUES ( ".$seriesID.", '".FormProcessor_AddDAFields::MULTILINGUAL_PAGE_KEY."' )";
    runSQL( $sql );
        
    $pageID = $db->getPrimaryKey();
        
    $tableName = XMLObject_MultilingualManager::DB_TABLE_LABEL;
    
    
    
    $sql = "INSERT INTO ".$tableName." (page_id, label_key, label_label, language_id) VALUES ( ".$pageID.", '[Title]', 'Add Fields to [daobjName]', 1 )";
    runSQL( $sql );
    
    $sql = "INSERT INTO ".$tableName." (page_id, label_key, label_label, language_id) VALUES ( ".$pageID.", '[Instr]', 'Use the following form to add fields to this Data Access Object.', 1 )";
    runSQL( $sql );
    
    $sql = "INSERT INTO ".$tableName." (page_id, label_key, label_label, language_id) VALUES ( ".$pageID.", '[formLabel_dbTypeModifier]', 'Certain DB Field Types require modifiers:<br><span class=\"smalltext\">(int, varchar, enum, etc...)</span>', 1 )";
    runSQL( $sql );
    
    $sql = "INSERT INTO ".$tableName." (page_id, label_key, label_label, language_id) VALUES ( ".$pageID.", '[error_UniqueName]', 'This name has already been taken', 1 )";
    runSQL( $sql );
    
    /*[RAD_PAGE(AddDAFields)_LABELS]*/
    
    
    
    // Create AddFieldLabels labels 
        $sql = "INSERT INTO ".XMLObject_MultilingualManager::DB_TABLE_PAGE." (series_id, page_key) VALUES ( ".$seriesID.", '".FormProcessor_AddFieldLabels::MULTILINGUAL_PAGE_KEY."' )";
    runSQL( $sql );
        
    $pageID = $db->getPrimaryKey();
        
    $tableName = XMLObject_MultilingualManager::DB_TABLE_LABEL;
    
    
    
    $sql = "INSERT INTO ".$tableName." (page_id, label_key, label_label, language_id) VALUES ( ".$pageID.", '[Title]', 'Enter Field Labels for [daobjName]', 1 )";
    runSQL( $sql );
    
    $sql = "INSERT INTO ".$tableName." (page_id, label_key, label_label, language_id) VALUES ( ".$pageID.", '[Instr]', 'Use the following form to enter the labels you want displayed for these field labels when they are in use in your module.', 1 )";
    runSQL( $sql );
    
    /*[RAD_PAGE(AddFieldLabels)_LABELS]*/
    
    
    
    // Create ViewPages labels 
        $sql = "INSERT INTO ".XMLObject_MultilingualManager::DB_TABLE_PAGE." (series_id, page_key) VALUES ( ".$seriesID.", '".page_ViewPages::MULTILINGUAL_PAGE_KEY."' )";
    runSQL( $sql );
        
    $pageID = $db->getPrimaryKey();
        
    $tableName = XMLObject_MultilingualManager::DB_TABLE_LABEL;
    
    
    
    $sql = "INSERT INTO ".$tableName." (page_id, label_key, label_label, language_id) VALUES ( ".$pageID.", '[Title]', '[moduleName]''s Pages', 1 )";
    runSQL( $sql );
    
    $sql = "INSERT INTO ".$tableName." (page_id, label_key, label_label, language_id) VALUES ( ".$pageID.", '[Instr]', 'Use the list below to work with the pages in the system.', 1 )";
    runSQL( $sql );
    
    /*[RAD_PAGE(ViewPages)_LABELS]*/
    
    
    
    // Create AddPage labels 
        $sql = "INSERT INTO ".XMLObject_MultilingualManager::DB_TABLE_PAGE." (series_id, page_key) VALUES ( ".$seriesID.", '".FormProcessor_AddPage::MULTILINGUAL_PAGE_KEY."' )";
    runSQL( $sql );
        
    $pageID = $db->getPrimaryKey();
        
    $tableName = XMLObject_MultilingualManager::DB_TABLE_LABEL;
    
    
    
    $sql = "INSERT INTO ".$tableName." (page_id, label_key, label_label, language_id) VALUES ( ".$pageID.", '[Title]', '[moduleName]: Add New Page', 1 )";
    runSQL( $sql );
    
    $sql = "INSERT INTO ".$tableName." (page_id, label_key, label_label, language_id) VALUES ( ".$pageID.", '[Instr]', 'Use this form to add a new page to this module.', 1 )";
    runSQL( $sql );
    
    $sql = "INSERT INTO ".$tableName." (page_id, label_key, label_label, language_id) VALUES ( ".$pageID.", '[error_UniqueName]', 'This name has already been taken', 1 )";
    runSQL( $sql );
    
    /*[RAD_PAGE(AddPage)_LABELS]*/
    
    
    
    // Create EditPage labels 
        $sql = "INSERT INTO ".XMLObject_MultilingualManager::DB_TABLE_PAGE." (series_id, page_key) VALUES ( ".$seriesID.", '".FormProcessor_EditPage::MULTILINGUAL_PAGE_KEY."' )";
    runSQL( $sql );
        
    $pageID = $db->getPrimaryKey();
        
    $tableName = XMLObject_MultilingualManager::DB_TABLE_LABEL;
    
    
    
    $sql = "INSERT INTO ".$tableName." (page_id, label_key, label_label, language_id) VALUES ( ".$pageID.", '[Title]', 'Edit [pageName]', 1 )";
    runSQL( $sql );
    
    $sql = "INSERT INTO ".$tableName." (page_id, label_key, label_label, language_id) VALUES ( ".$pageID.", '[Instr]', 'Use this form to edit this page info.', 1 )";
    runSQL( $sql );
    
    /*[RAD_PAGE(EditPage)_LABELS]*/
    
    
    
    // Create AddPageFields labels 
        $sql = "INSERT INTO ".XMLObject_MultilingualManager::DB_TABLE_PAGE." (series_id, page_key) VALUES ( ".$seriesID.", '".FormProcessor_ViewPageFields::MULTILINGUAL_PAGE_KEY."' )";
    runSQL( $sql );
        
    $pageID = $db->getPrimaryKey();
        
    $tableName = XMLObject_MultilingualManager::DB_TABLE_LABEL;
    
    
    
    $sql = "INSERT INTO ".$tableName." (page_id, label_key, label_label, language_id) VALUES ( ".$pageID.", '[Title]', '[pageName] Fields', 1 )";
    runSQL( $sql );
    
    $sql = "INSERT INTO ".$tableName." (page_id, label_key, label_label, language_id) VALUES ( ".$pageID.", '[Instr]', 'Select the fields for use on this page.  The Data Access Objects might manage more fields than this page is interested in, so select the ones being used.<br><br> NOTE: you need to select the fields for both the Form section as well as the List section.', 1 )";
    runSQL( $sql );
    
    $sql = "INSERT INTO ".$tableName." (page_id, label_key, label_label, language_id) VALUES ( ".$pageID.", '[formFields]', 'Form Fields', 1 )";
    runSQL( $sql );
    
    $sql = "INSERT INTO ".$tableName." (page_id, label_key, label_label, language_id) VALUES ( ".$pageID.", '[listFields]', 'List Fields', 1 )";
    runSQL( $sql );
    
    /*[RAD_PAGE(AddPageFields)_LABELS]*/
    
    
    
    // Create AddPageLabels labels 
        $sql = "INSERT INTO ".XMLObject_MultilingualManager::DB_TABLE_PAGE." (series_id, page_key) VALUES ( ".$seriesID.", '".FormProcessor_AddPageLabels::MULTILINGUAL_PAGE_KEY."' )";
    runSQL( $sql );
        
    $pageID = $db->getPrimaryKey();
        
    $tableName = XMLObject_MultilingualManager::DB_TABLE_LABEL;
    
    
    
    $sql = "INSERT INTO ".$tableName." (page_id, label_key, label_label, language_id) VALUES ( ".$pageID.", '[Title]', '[pageName] Labels', 1 )";
    runSQL( $sql );
    
    $sql = "INSERT INTO ".$tableName." (page_id, label_key, label_label, language_id) VALUES ( ".$pageID.", '[Instr]', 'Enter any additional labels for this page.', 1 )";
    runSQL( $sql );
    
    /*[RAD_PAGE(AddPageLabels)_LABELS]*/
    
    
    
    // Create Transitions labels 
        $sql = "INSERT INTO ".XMLObject_MultilingualManager::DB_TABLE_PAGE." (series_id, page_key) VALUES ( ".$seriesID.", '".FormProcessor_Transitions::MULTILINGUAL_PAGE_KEY."' )";
    runSQL( $sql );
        
    $pageID = $db->getPrimaryKey();
        
    $tableName = XMLObject_MultilingualManager::DB_TABLE_LABEL;
    
    
    
    $sql = "INSERT INTO ".$tableName." (page_id, label_key, label_label, language_id) VALUES ( ".$pageID.", '[Title]', '[moduleName] Transitions', 1 )";
    runSQL( $sql );
    
    $sql = "INSERT INTO ".$tableName." (page_id, label_key, label_label, language_id) VALUES ( ".$pageID.", '[Instr]', 'Enter the transitions between pages in this module.', 1 )";
    runSQL( $sql );
    
    /*[RAD_PAGE(Transitions)_LABELS]*/
    
    
    
    // Create EditModule labels 
        $sql = "INSERT INTO ".XMLObject_MultilingualManager::DB_TABLE_PAGE." (series_id, page_key) VALUES ( ".$seriesID.", '".FormProcessor_EditModule::MULTILINGUAL_PAGE_KEY."' )";
    runSQL( $sql );
        
    $pageID = $db->getPrimaryKey();
        
    $tableName = XMLObject_MultilingualManager::DB_TABLE_LABEL;
    
    
    
    $sql = "INSERT INTO ".$tableName." (page_id, label_key, label_label, language_id) VALUES ( ".$pageID.", '[Title]', 'Edit [moduleName]', 1 )";
    runSQL( $sql );
    
    $sql = "INSERT INTO ".$tableName." (page_id, label_key, label_label, language_id) VALUES ( ".$pageID.", '[Instr]', 'Use this form to edit the module information.', 1 )";
    runSQL( $sql );
    
    $sql = "INSERT INTO ".$tableName." (page_id, label_key, label_label, language_id) VALUES ( ".$pageID.", '[error_UniqueModuleName]', 'This name has already been taken', 1 )";
    runSQL( $sql );
    
    /*[RAD_PAGE(EditModule)_LABELS]*/
    
    
    
    // Create DeleteModule labels 
        $sql = "INSERT INTO ".XMLObject_MultilingualManager::DB_TABLE_PAGE." (series_id, page_key) VALUES ( ".$seriesID.", '".page_DeleteModule::MULTILINGUAL_PAGE_KEY."' )";
    runSQL( $sql );
        
    $pageID = $db->getPrimaryKey();
        
    $tableName = XMLObject_MultilingualManager::DB_TABLE_LABEL;
    
    
    
    $sql = "INSERT INTO ".$tableName." (page_id, label_key, label_label, language_id) VALUES ( ".$pageID.", '[Title]', 'Delete [moduleName]?', 1 )";
    runSQL( $sql );
    
    $sql = "INSERT INTO ".$tableName." (page_id, label_key, label_label, language_id) VALUES ( ".$pageID.", '[Instr]', 'Are you sure you want to remove this module?', 1 )";
    runSQL( $sql );
    
    /*[RAD_PAGE(DeleteModule)_LABELS]*/
    
    
    
    // Create DeleteDAObj labels 
        $sql = "INSERT INTO ".XMLObject_MultilingualManager::DB_TABLE_PAGE." (series_id, page_key) VALUES ( ".$seriesID.", '".page_DeleteDAObj::MULTILINGUAL_PAGE_KEY."' )";
    runSQL( $sql );
        
    $pageID = $db->getPrimaryKey();
        
    $tableName = XMLObject_MultilingualManager::DB_TABLE_LABEL;
    
    
    
    $sql = "INSERT INTO ".$tableName." (page_id, label_key, label_label, language_id) VALUES ( ".$pageID.", '[Title]', 'Delete [daobjName]?', 1 )";
    runSQL( $sql );
    
    $sql = "INSERT INTO ".$tableName." (page_id, label_key, label_label, language_id) VALUES ( ".$pageID.", '[Instr]', 'Are you sure you want to remove this Data Access Object?', 1 )";
    runSQL( $sql );
    
    /*[RAD_PAGE(DeleteDAObj)_LABELS]*/
    
    
    
    // Create DeletePage labels 
        $sql = "INSERT INTO ".XMLObject_MultilingualManager::DB_TABLE_PAGE." (series_id, page_key) VALUES ( ".$seriesID.", '".page_DeletePage::MULTILINGUAL_PAGE_KEY."' )";
    runSQL( $sql );
        
    $pageID = $db->getPrimaryKey();
        
    $tableName = XMLObject_MultilingualManager::DB_TABLE_LABEL;
    
    
    
    $sql = "INSERT INTO ".$tableName." (page_id, label_key, label_label, language_id) VALUES ( ".$pageID.", '[Title]', 'Delete [pageName]?', 1 )";
    runSQL( $sql );
    
    $sql = "INSERT INTO ".$tableName." (page_id, label_key, label_label, language_id) VALUES ( ".$pageID.", '[Instr]', 'Are you sure you want to remove this Page from the module?', 1 )";
    runSQL( $sql );
    
/*[RAD_PAGE(DeletePage)_LABELS]*/
    
    
    
/*[RAD_PAGE_LABEL]*/
    
    
} else {

    echo 'Skipping Labels ... <br>';
    
} // end if !skipLabels

echo '</table>';



function runSQL( $sql ) {
    global $db;
    
    if ($db->runSQL( $sql ) ) {
        echo '<tr><td><font color="#999999">'.$sql."</font></td></tr>\n";
    } else {
        echo '<tr><td><font color="#FF0000">'.$sql."</font></td></tr>\n";
    }
}

?>