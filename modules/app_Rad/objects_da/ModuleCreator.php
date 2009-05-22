<?php
/**
 * @package RAD
 */ 
/**
 * class ModuleCreator
 * <pre> 
 * This Object steps through the process of creating the a Module.
 * </pre>
 * @author Johnny Hausman
 */
class  ModuleCreator {

	//CONSTANTS:
	/** the default permission settings (in octal = leading 0) for the directories. */
    const DIR_MODE = 0777;
    
    /** the name of the app_Module template file. */
    const FILE_APP_MODULE = 'tmpl_app_ModuleName.php';
    
    /** the name of the incl_Module template file. */
    const FILE_INCL_MODULE = 'tmpl_incl_ModuleName.php';
    
    /** the name of the obj_CommonDisplay template file. */
    const FILE_COMMON_OBJ = 'tmpl_obj_CommonDisplay.php';
    
    /** the name of the db_backup.sh template file. */
    const FILE_DB_BACKUP = 'tmpl_db_backup.sh';
    
    /** the name of the tool_setup template file. */
    const FILE_TOOL_SETUP = 'tmpl_tool_setup.php';
    
    /** the name of the RowManager Object template file. */
    const FILE_DA_ROWMANAGER = 'tmpl_RowManagerObj.php';
    
    /** the name of the List Iterator Object template file. */
    const FILE_DA_LISTITERATOR = 'tmpl_ListIterator.php';
    
    /** the default path from the site root. */
    const PATH_MODULE_ROOT = 'modules/';
    
    /** the default path for the Business Logic objects. */
    const PATH_OBJECT_BL = 'objects_bl/';
    
    /** the default path for the Data Access objects. */
    const PATH_OBJECT_DA = 'objects_da/';
    
    /** the default path for the Page Display objects. */
    const PATH_OBJECT_PAGES = 'objects_pages/';
    
    /** the default path for the Templates objects. */
    const PATH_TEMPLATES = 'templates/';
	
	/** the index key for the Module ID. */
    const KEY_MODULE_ID = 'module_id';
    
	/** the index key for the Module Name. */
    const KEY_MODULE_NAME = 'module_name';
    
    /** the index key for the Module Creator. */
    const KEY_MODULE_CREATOR = 'module_creator';
    
    /** the index key for the Module Name + Path. */
    const KEY_PATH_APP_NAME = 'path_app_name';
    
    /** the index key for the Include File + Path. */
    const KEY_PATH_INCLUDE_NAME = 'path_include_name';
    
    /** the index key for the Setup File + Path. */
    const KEY_PATH_SETUP_NAME = 'path_setup_name';
    
    /** the default path from the site root to the RAD root. */
    const KEY_PATH_RAD_ROOT = 'path_rad_root';
    
    /** the default path from the site root to the New Module's object_bl. */
    const KEY_PATH_MODULE_BL = 'path_module_bl';
    
    /** the default path from the site root to the New Module's object_pages. */
    const KEY_PATH_MODULE_PAGES = 'path_module_pages';
    
    /** the default path from the site root to the New Module's template dir. */
    const KEY_PATH_MODULE_TEMPLATE = 'path_module_template';
    
    /** the default path from the site root to the New Module's root. */
    const KEY_PATH_MODULE_ROOT = 'path_module_root';
    
    /** the tag defining the Module Name. */
    const TAG_MODULE_NAME = '[ModuleName]';
    
    /** the tag defining the Creator Name. */
    const TAG_CREATOR_NAME = '[CreatorName]';
    
    /** the tag defining the Creation Date. */
    const TAG_CREATION_DATE = '[CreationDate]';
    
    /** the tag defining the Module Description. */
    const TAG_MODULE_DESCRIPTION = '[ModuleDescription]';
    
    /** the tag defining the Module's Object declaration point. */
    const TAG_MODULE_OBJECT_VAR = '/*[RAD_PAGE_OBJECT_VAR]*/';
    
    /** the tag defining the Module's Object loading point. */
    const TAG_MODULE_OBJECT_LOAD = '/*[RAD_COMMON_LOAD]*/';
    
    /** the tag defining the Module's Object Common HTML Wrapping point. */
    const TAG_MODULE_COMMON_HTML = '/*[RAD_COMMON_LOAD_HTML]*/';
    
    /** the tag defining the include file's Common Display include statemnt. */
    const TAG_INCLUDE_COMMON = '/*[RAD_COMMON_DISPLAY]*/';
    
    /** the tag defining the include file's Data Access Object insertion point. */
    const TAG_INCLUDE_DA = '/*[RAD_INCLUDE_DA]*/';
    
    /** the tag defining the include file's Business Logic insertion point. */
    const TAG_INCLUDE_BL = '/*[RAD_INCLUDE_BL]*/';
    
    /** the tag defining the include file's Business Logic insertion point. */
    const TAG_INCLUDE_PAGES = '/*[RAD_INCLUDE_PAGES]*/';
    
    /** the tag defining the path for the templates directory. */
    const TAG_PATH_TEMPLATES = '[RAD_PATH_TEMPLATES]';
    
    /** the tag defining the path to the Modules directory. */
    const TAG_PATH_MODULE_ROOT = '[RAD_PATH_MODULE_ROOT]';
    
    /** the tag defining the Module's Pre name insertion point. */
    const TAG_TOOL_CORE_PRE = '[RAD_CORE_PRE_NAME]';
    
    /** the tag defining the Page Label Insertion point in the setup file. */
    const TAG_TOOL_PAGE_LABEL = '/*[RAD_PAGE_LABEL]*/';
    
    /** the tag defining the SQL Table definition Insertion point in the setup file. */
    const TAG_TOOL_DAOBJ_TABLE = '/*[RAD_DAOBJ_TABLE]*/';
    
    /** the tag defining the Field Label Insertion point in the setup file. */
    const TAG_TOOL_FIELDS_LABEL = '/*[RAD_FIELDS_LABEL]*/';
    
    /** the tag defining a page's CONST def insertion point */
    const TAG_PAGE_CONST = '/*[RAD_PAGE_CONST]*/';
    
    /** the tag defining a page's CONST def insertion point */
    const TAG_PAGE_STATEVAR_CONST = '/*[RAD_PAGE_STATEVAR_CONST]*/';
    
    /** the tag defining a page's VAR def insertion point */
    const TAG_PAGE_STATEVAR = '/*[RAD_PAGE_STATEVAR_VAR]*/';
    
    /** the tag defining a page's VAR Init insertion point */
    const TAG_PAGE_STATEVAR_INIT = '/*[RAD_PAGE_LOAD_STATEVAR]*/';

    /** the tag defining a page's VAR CallBack Doc insertion point */
    const TAG_PAGE_CALLBACK_DOC = '[RAD_CALLBACK_DOC]';  
    
    /** the tag defining a page's VAR CallBack Parameter insertion point */
    const TAG_PAGE_CALLBACK_PARAM = ')//RAD_CALLBACK_PARAM'; 
    
    /** the tag defining a page's VAR CallBack Code insertion point */
    const TAG_PAGE_CALLBACK_CODE = '/*[RAD_CALLBACK_CODE]*/'; 
    
    /** the tag defining the DAObj Name insertion point */
    const TAG_DAOBJ_NAME = '[DAObj]'; 
    
    /** the tag defining the DAObj Description insertion point */
    const TAG_DAOBJ_DESC = '[DAObjDescription]'; 
    
    /** the tag defining the DAObj DB Table Name insertion point */
    const TAG_DAOBJ_DBTABLE = '[RAD_TABLENAME]'; 
    
    /** the tag defining the DAObj DB Table Field Description insertion point */
    const TAG_DAOBJ_DBTABLE_DOC = '[RAD_DB_TABLE_DESCRIPTION_DOC]'; 
    
    /** the tag defining the DAObj DB Table SQL insertion point */
    const TAG_DAOBJ_DBTABLE_SQL = '[RAD_DB_TABLE_DESCRIPTION_SQL]'; 
    
    /** the tag defining the DAObj DB Field List insertion point */
    const TAG_DAOBJ_DBFIELDLIST = '[RAD_FIELDLIST_DEF]';
    
    /** the tag defining the DAObj XML NODE NAME insertion point */
    const TAG_DAOBJ_XMLNODENAME = '[RAD_XML_NODENAME]';
    
    /** the tag defining the DAObj State Variable Init insertion point */
    const TAG_DAOBJ_STATEVAR = '[RAD_STATEVAR]';
    
    /** the tag defining the DAObj Primary Key insertion point */
    const TAG_DAOBJ_PRIMARYKEY = '[RAD_DAObj_PRIMARY_KEY_FIELD]';
    
    /** the tag defining the DAObj getLabel return value */
    const TAG_DAOBJ_GETLABEL = '[RAD_DAOBJ_LABEL_FIELD]';
    
    /** the tag defining the DAObj List Iterator's Row Manager Name insertion point */
    const TAG_DAOBJ_ROWMANAGER = '[DAObj_ROW_MGR]';
    
    /** the tag defining the DAObj List Iterator's Init documentation insertion point */
    const TAG_DAOBJ_INITVAR_DOC = '[RAD_INITVAR_DOC]';
    
    /** the tag defining the DAObj List Iterator's Init parameter insertion point */
    const TAG_DAOBJ_INITVAR_PARAM = '/*[RAD_INITVAR_PARAM]*/';
    
    /** the tag defining the DAObj List Iterator's Init Code insertion point */
    const TAG_DAOBJ_INITVAR_CODE = '/*[RAD_INITVAR_CODE]*/';
    
    /** the tag defining the Page Prefix Name insertion point */
    const TAG_PAGE_PREFIXNAME = '[PageNamePrefix]';
    
    /** the tag defining the Page Name insertion point */
    const TAG_PAGE_NAME = '[PageName]';
    
    /** the tag defining the Page Description insertion point */
    const TAG_PAGE_DESCRIPTION = '[PageDescription]';
    
    /** the tag defining the Form's Field Type List insertion point */
    const TAG_PAGE_FORMFIELDTYPE = '[RAD_FIELDTYPE_LIST]';
    
    /** the tag defining the Form's Form Entry Type List insertion point */
    const TAG_PAGE_FORMENTRYTYPE = '[RAD_FORMENTRYTYPE_LIST]';
    
    /** the tag defining the Form's Data Manager Object insertion point */
    const TAG_PAGE_DATAMANAGER = '[RAD_DAOBJ_MANAGER_NAME]';
    
    /** the tag defining the Form Initilization Variable Name */
    const TAG_FORM_INIT_NAME = '[RAD_FORM_INIT]';
    
    /** the tag defining the Form' Data List Initilization Variable Name */
    const TAG_LIST_INIT_NAME = '/*[RAD_LIST_INIT]*/';
    
    /** the tag defining the Form' Data List Initilization Documentation */
    const TAG_LIST_INIT_DOC = '[RAD_LIST_INIT_DOC]';
    
    /** the tag defining the Form' Data List Initilization Parameter */
    const TAG_LIST_INIT_PARAM = '[RAD_LIST_INIT_PARAM]';
    
    /** the tag defining the Form' Data List Initilization Statement */
    const TAG_LIST_INIT_VAR_INIT = '/*[RAD_LIST_INIT_VAR_INIT]*/';
    
    /** the tag defining the Form' Data List Initilization Statement */
    const TAG_LIST_INIT_DAOBJ_PARAM = '[RAD_LIST_INIT_DAOBJ_PARAM]';
    
    /** the tag defining the Form' Foreign Key Variables */
    const TAG_PAGE_FOREIGNKEY_VARIABLE = '/*[RAD_FOREIGN_KEY_VAR]*/';
    
    /** the tag defining the Form' Foreign Key Documentation */
    const TAG_PAGE_FOREIGNKEY_DOCUMENTATION = '[RAD_FOREIGN_KEY_DOC]';
    
    /** the tag defining the Form' Foreign Key Parameter */
    const TAG_PAGE_FOREIGNKEY_PARAM = ')//[RAD_FOREIGN_KEY_PARAM]';
    
    /** the tag defining the Form' Foreign Key Parameter Save */
    const TAG_PAGE_FOREIGNKEY_SAVE = '/*[RAD_FOREIGN_KEY_SAVE]*/';
    
    /** the tag defining the Form' Data manager Object's Foreign Key data */
    const TAG_PAGE_FOREIGNKEY = '/*[RAD_ADMINBOX_FOREIGNKEY]*/';
    
    /** the tag defining the Form' Date start/end data insert */
    const TAG_PAGE_DATE_PARAM = '/*[RAD_DAOBJ_FIELD_DATE_PARAM]*/';
    
    /** the tag defining the Form's List Fields */
    const TAG_PAGE_LIST_FIELDS = '[RAD_FIELDNAME_LIST]';
    
    /** the tag defining the Form's List Manager Object insertion point */
    const TAG_PAGE_LISTMANAGER = '[RAD_DAOBJ_LIST_NAME]';
    
    /** the tag defining the Form's List Row manager insertion point */
    const TAG_PAGE_LIST_ROWMANAGER = '[RAD_LIST_MANAGER_NAME]';
    
    /** the tag defining the Form's List PrimaryKey insertion point */
    const TAG_PAGE_LIST_PRIMARYKEY = '[RAD_LIST_PRIMARYKEY]';
    
    /** the tag defining the Page's Default Template Name insertion point */
    const TAG_PAGE_TEMPLATE_DEFAULT = '[RAD_TEMPLATE_DEFAULT]';

    /** the tag defining the Page Labels insertion point */
    const TAG_PAGE_LABELS = '/*[RAD_PAGE_LABEL]*/';
    
    /** the tag defining the Page Default Constant Name insertion point */
    const TAG_PAGE_DEFAULT_CONST = '[RAD_PAGE_DEFAULT_CONSTNAME]';
    
    /** the tag defining the Page Default Page Name insertion point */
    const TAG_PAGE_DEFAULT_NAME = '[RAD_PAGE_DEFAULT_PAGENAME]';
        
    /** the tag defining the Form's List Initilization Variable Name */
    const TAG_FORMGRID_LIST_INIT_NAME = '[RAD_FORMGRID_LIST_INIT]';
    
    /** the tag defining the Form's List Initilization Variable Name */
    const TAG_FORMGRID_LIST_OBJ_NAME = '[RAD_FORMGRID_LIST_OBJ_NAME]';
    
    /** the tag defining the Form's List Initilization Variable Name */
    const TAG_FORMGRID_LABEL_NAME = '[RAD_FORMGRID_LABEL_NAME]';

    /** the tag defining the LoadPage insertion point */
    const TAG_APP_LOAD_PAGE = '/*[RAD_PAGE_LOAD_CALL]*/';
    
    /** the tag defining the LoadPage Function insertion point */
    const TAG_APP_LOAD_PAGE_FN = '/*[RAD_PAGE_LOAD_FN]*/';
    
    /** the tag defining the PageInit's Page Name insertion point */
    const TAG_PAGEINIT_NAME = '[RAD_PAGEINIT_NAME]';
    
    /** the tag defining the PageInit's Page Prefix Name insertion point */
    const TAG_PAGEINIT_PREFIXNAME = '[PageNamePrefix]';
    
    /** the tag defining the PageInit's Page Object Name insertion point */
    const TAG_PAGEINIT_PAGENAME = '[PageName]';
    
    /** the tag defining the PageInit's Page CONST Name insertion point */
    const TAG_PAGEINIT_CONSTNAME = '[RAD_PAGE_CONSTNAME]';
    
    /** the tag defining the PageInit's Callback Parameter List */
    const TAG_PAGEINIT_CALLBACK = ');//[RAD_CALLBACK_PARAMS]';
    
    /** the tag defining the PageInit's Edit/Del link Callback Parameter List */
    const TAG_PAGEINIT_CALLBACK_EDIT = ');//[RAD_CALLBACK_PARAMS_EDIT]';
    
    /** the tag defining the PageInit's Form Init Var name */
    const TAG_PAGEINIT_FORMINIT = '[RAD_PAGEINIT_FORMINIT_VAR]';
    
    /** the tag defining the PageInit's Form List Init Var name */
    const TAG_PAGEINIT_FORMINIT_LIST = '[RAD_PAGEINIT_FORMINIT_LIST_VAR]';
    
    /** the tag defining the PageInit's List Init Var name */
    const TAG_PAGEINIT_LISTINIT = '[RAD_PAGEINIT_LISTINIT_VAR]';
    
    /** the tag defining the PageInit's DAObj Init Var from the List DAObj name */
    const TAG_PAGEINIT_LIST_DAOBJ = '[RAD_PAGEINIT_LISTINIT_DAOBJ_VAR]';
    
    /** the tag defining the PageInit's ForeignKey Param Insert name */
    const TAG_PAGEINIT_FOREIGNKEY_INIT = ');//[RAD_FORMINIT_FOREIGNKEY_INIT]';
    
    /** the tag defining the Transitions Source Page CONST Name  */
    const TAG_TRANSITION_SOURCE_CONSTNAME = '[RAD_PAGE_SOURCE_CONSTNAME]';
    
    /** the tag defining the Transitions Dest Page CONST Name  */
    const TAG_TRANSITION_DEST_CONSTNAME = '[RAD_PAGE_DEST_CONSTNAME]';
    
    /** the tag defining the Transitions Dest Page Name  */
    const TAG_TRANSITION_DEST_NAME = '[RAD_PAGE_DEST_NAME]';
    
    /** the tag defining the Transition Code Insertion point  */
    const TAG_TRANSITION_CODE = '/*[RAD_PAGE_TRANSITION]*/';
    
    /** the tag defining the Page's AdminBox ManagerInit Insertion point  */
    const TAG_PAGE_ADMINBOX_MANAGERINIT = '[RAD_TRANSITION_MANAGERINIT_NAME]';
    
    
	//VARIABLES:
	/** @var [ARRAY] Array of data items used in creating a module */
	protected $values;


	//CLASS CONSTRUCTOR
	//************************************************************************
	/**
	 * function __construct
	 * <pre>
	 * Initialize the object.
	 * </pre>
	 * @param $moduleID [INTEGER] the unique module id of the module to create
	 * @param $pathModuleRoot [STRING] path to the root of the RAD directory.
	 * @return [void]
	 */
    function __construct( $moduleID, $pathModuleRoot ) 
    {
        $this->values[ ModuleCreator::KEY_MODULE_ID ] = $moduleID;
        $this->values[ ModuleCreator::KEY_PATH_RAD_ROOT ] = $pathModuleRoot;
    }



	//CLASS FUNCTIONS:
	//************************************************************************
	/**
	 * function classMethod
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
    function classMethod($param1, $param2) 
    {
        // CODE
    }  // end classMethod()
    
    
    
    //************************************************************************
	/**
	 * function createModule
	 * <pre>
	 * This routine steps throught the module data and makes sure it has been
	 * properly created.
	 * </pre>
	 * <pre><code>
	 * load Module manager
	 * if Module manager is not created then
	 *     create Module Directory
	 *     Create Base Files
	 *     update created status
	 * end if
	 * </code></pre>
	 * @return [returnValue, can be void]
	 */
    function createModule() 
    {
        // load Module manager
        $moduleID =  $this->values[ ModuleCreator::KEY_MODULE_ID ];
        $moduleManager = new RowManager_ModuleManager( $moduleID );
        
        $this->storeCommonVariables( $moduleManager );
        
        
        // if Module manager is not created then
        if (!$moduleManager->isCreated()) {
        
            // create Module Directory
            $directoryName = '';
            if ( !$moduleManager->isCore() ) {
                $directoryName = 'app_';
            }
            $directoryName .= $moduleManager->getModuleName();
            $this->createDirectory( $directoryName );
            
            // Create Base Files
            $this->createBaseFiles( $moduleManager );
            
            // update created status
            $moduleManager->setCreated();
            
        } else {
        
            // make sure variable info is updated
        
        }// end if
        
        
        // process StateVar info
        $this->processStateVarInfo( $moduleID );
        
        // process Data Access Object info
        $this->processDataAccessObjectInfo( $moduleID );
        
        // process Page Object info
        $this->processPageInfo( $moduleID );
        
        // process Page Transitions (form) info
        $this->processTransition( $moduleID );
        
        
    }  // end createModule()
    
    
    
    //************************************************************************
	/**
	 * function storeCommonVariables
	 * <pre>
	 * Creates the common values we use to track .
	 * </pre>
	 * @param $moduleManager [OBJECT] The Module Manager
	 * @return [void]
	 */
    function storeCommonVariables( $moduleManager ) 
    {
        $this->values[ ModuleCreator::KEY_MODULE_NAME ] = $moduleManager->getModuleName();
        
        $this->values[ ModuleCreator::KEY_MODULE_CREATOR ] = $moduleManager->getCreatorName();
        
        // store the path info as well ...
        // Module Root Directory
        $name = '';
        if ( !$moduleManager->isCore() ) {
            $name = 'app_';
        }
        $name .= $moduleManager->getModuleName();
        $directoryName = ModuleCreator::PATH_MODULE_ROOT.$name;
        $this->values[ ModuleCreator::KEY_PATH_MODULE_ROOT ] = $directoryName.'/'; 
        // Business Logic Object Directory
        $blDirectory = $directoryName.'/'.ModuleCreator::PATH_OBJECT_BL;
        $this->values[ ModuleCreator::KEY_PATH_MODULE_BL ] = $blDirectory;
        
        // Page Display Object Directory
        $pageDirectory = $directoryName.'/'.ModuleCreator::PATH_OBJECT_PAGES;
        $this->values[ ModuleCreator::KEY_PATH_MODULE_PAGES ] = $pageDirectory;
        
        // Template Directory
        $templateDirectory = $directoryName.'/'.ModuleCreator::PATH_TEMPLATES;
        $this->values[ ModuleCreator::KEY_PATH_MODULE_TEMPLATE ] = $templateDirectory;
        
        // store the App Name & path in the values array
        $modulePath = $this->values[ ModuleCreator::KEY_PATH_MODULE_ROOT ];
        $moduleName = $moduleManager->getModuleName();
        $name = $modulePath.'app_'.$moduleName.'.php';
        $this->values[ ModuleCreator::KEY_PATH_APP_NAME ] = $name;
        
        // store the include Name and Path
        $name = $modulePath.'incl_'.$moduleName.'.php';
        $this->values[ ModuleCreator::KEY_PATH_INCLUDE_NAME ] = $name;
        
        // store the setup Name and path
        $name = $modulePath.'tool_setup.php';
        $this->values[ ModuleCreator::KEY_PATH_SETUP_NAME ] = $name;
        
        
    }
    
    
    
    //************************************************************************
	/**
	 * function createDirectory
	 * <pre>
	 * Creates the necessary directory structure for a module.
	 * </pre>
	 * @param $name [STRING] The Name of the Module Directory
	 * @param $path [STRING] The Path to the Module Directory
	 * @return [void]
	 */
    function createDirectory($name, $path=ModuleCreator::PATH_MODULE_ROOT) 
    {
        // create base directory
/*        $directoryName = $path.$name;
        if ( !file_exists( $directoryName ) ) {
            mkdir( $directoryName, ModuleCreator::DIR_MODE );
        }
        $this->values[ ModuleCreator::KEY_PATH_MODULE_ROOT ] = $directoryName.'/';
*/
        $directoryName = $this->values[ ModuleCreator::KEY_PATH_MODULE_ROOT ];
        if ( !file_exists( $directoryName ) ) {
            mkdir( $directoryName, ModuleCreator::DIR_MODE );
        }
        
        // create sub directories
        // objects_bl
//        $blDirectory = $directoryName.ModuleCreator::PATH_OBJECT_BL;
//        $this->values[ ModuleCreator::KEY_PATH_MODULE_BL ] = $blDirectory;
        $blDirectory = $this->values[ ModuleCreator::KEY_PATH_MODULE_BL ];

        if ( !file_exists( $blDirectory ) ) {
            mkdir( $blDirectory, ModuleCreator::DIR_MODE );
        }
        
        // objects_da
        $daDirectory = $directoryName.ModuleCreator::PATH_OBJECT_DA;
        if ( !file_exists( $daDirectory ) ) {
            mkdir( $daDirectory, ModuleCreator::DIR_MODE );
        }
        
        // objects_pages
        $pageDirectory = $directoryName.ModuleCreator::PATH_OBJECT_PAGES;
        if ( !file_exists( $pageDirectory ) ) {
            mkdir( $pageDirectory, ModuleCreator::DIR_MODE );
        }
        
        // templates
        $templateDirectory = $directoryName.ModuleCreator::PATH_TEMPLATES;
        if ( !file_exists( $templateDirectory ) ) {
            mkdir( $templateDirectory, ModuleCreator::DIR_MODE );
        }
        
    }  // end createDirectory()
    
    
    
    //************************************************************************
	/**
	 * function createBaseFiles
	 * <pre>
	 * Creates the base files for the module (app_Module, incl_Module, 
	 * tool_setup).
	 * </pre>
	 * @param $name [STRING] The Name of the Module
	 * @param $path [STRING] The Path to the Module Directory
	 * @return [void]
	 */
    function createBaseFiles( $moduleManager ) 
    {
    
        $templatePath = $this->values[ ModuleCreator::KEY_PATH_RAD_ROOT ] . 'data/';
        $modulePath = $this->values[ ModuleCreator::KEY_PATH_MODULE_ROOT ];
        
        $moduleName = $moduleManager->getModuleName();
        
        // get app_Module template and save in new Module
        $appFileName = $templatePath.ModuleCreator::FILE_APP_MODULE;
        $appFileContents = file_get_contents( $appFileName );
        if ($appFileContents) {
        
            $appFileContents = $this->replaceCommonTags( $appFileContents );
            
            // Replace Module Description
            $tagModuleDesc = ModuleCreator::TAG_MODULE_DESCRIPTION;
            $moduleDesc = $moduleManager->getModuleDescription();
            $appFileContents = str_replace($tagModuleDesc, $moduleDesc, $appFileContents );
            
            
            // Check for is common look and fill in options
            if ($moduleManager->isCommonLook()) {
              
                $clObjectCreation = '    /** protected $pageCommonDisplay [OBJECT] The display object for the common page layout. */
        protected $pageCommonDisplay;' . "\n\n".ModuleCreator::TAG_MODULE_OBJECT_VAR;
                $clObjectLoading = '        // load the common page layout object
        $this->pageCommonDisplay = new CommonDisplay( $this->modulePathRoot, $this->pathToRoot, $this->viewer);' ; //."\n\n".ModuleCreator::TAG_MODULE_OBJECT_LOAD;
                $clObjectDisplay = '        // wrap current page\'s html in the common html of the module
        $content = $this->pageCommonDisplay->getHTML( $content );';
                
            } else {
            
                $clObjectCreation = ModuleCreator::TAG_MODULE_OBJECT_VAR;
                $clObjectLoading = ModuleCreator::TAG_MODULE_OBJECT_LOAD;
                $clObjectDisplay = '';
            
            }
            
            // Replace Common Look Object Declaration
            $tagCreationObject = ModuleCreator::TAG_MODULE_OBJECT_VAR;
            $appFileContents = str_replace($tagCreationObject, $clObjectCreation, $appFileContents );
            
            // Replace Common Look Object creation
            $tagObjectLoad = ModuleCreator::TAG_MODULE_OBJECT_LOAD;
            $appFileContents = str_replace($tagObjectLoad, $clObjectLoading, $appFileContents );
            
            // Replace Common Look HTML wrapping
            $tagCommonHTML = ModuleCreator::TAG_MODULE_COMMON_HTML;
            $appFileContents = str_replace($tagCommonHTML, $clObjectDisplay, $appFileContents );
            
            
            $name = $this->values[ ModuleCreator::KEY_PATH_APP_NAME ];
            file_put_contents( $name, $appFileContents);
            
        } else {
        
            echo "Couldn't Open [".$appFileName."]<br>";
            exit;
        }
        
        
        /*
         *  Create Include File
         */
        $inclFileName = $templatePath.ModuleCreator::FILE_INCL_MODULE;
        $inclFileContents = file_get_contents( $inclFileName );
        if ($inclFileContents) {
        
            $inclFileContents = $this->replaceCommonTags( $inclFileContents );
            
            // if module shares a CommonLook then
            if ($moduleManager->isCommonLook()) {
              
                $clInclude = '// Common Display Object:
// ----------------------
// This object provides a common layout for the pages in this module.  The 
// related templated file is stored in /'.ModuleCreator::PATH_TEMPLATES.'obj_CommonDisplay.php
require_once( \''.ModuleCreator::PATH_OBJECT_BL.'obj_CommonDisplay.php\');';
                
            } else {
            
                $clInclude = '';
            
            }
            
            // Replace CommonDisplay Tag
            $tagCommonDisplay = ModuleCreator::TAG_INCLUDE_COMMON;
            $inclFileContents = str_replace($tagCommonDisplay, $clInclude, $inclFileContents );
            
            $name = $this->values[ ModuleCreator::KEY_PATH_INCLUDE_NAME ];
            file_put_contents( $name, $inclFileContents);
        
        } else {
        
            echo "Couldn't Open [".$inclFileName."]<br>";
            exit;
        } 
        
        
        
        /*
         *  Now if Module uses a Common Look, then add CommonDisplay 
         *  objects.
         */
        // if module shares a CommonLook then
        if ($moduleManager->isCommonLook()) {
          
           
            /*
             *   Create CommonDisplay Object
             */
            $cdFileName = $templatePath.ModuleCreator::PATH_OBJECT_BL.ModuleCreator::FILE_COMMON_OBJ;
            $cdFileContents = file_get_contents( $cdFileName );
            if ($cdFileContents) {
                          
                $cdFileContents = $this->replaceCommonTags( $cdFileContents );
                
                $name = $modulePath.ModuleCreator::PATH_OBJECT_BL.'obj_CommonDisplay.php';
                file_put_contents( $name, $cdFileContents);
            

            } else {
                echo "Couldn't Open [".$cdFileName."]<br>";
                exit;
            } 
            
            
            /*
             *   Create CommonDisplay Template
             */
            $cdtFileName = $templatePath.ModuleCreator::PATH_TEMPLATES.ModuleCreator::FILE_COMMON_OBJ;
            $cdtFileContents = file_get_contents( $cdtFileName );
            if ($cdtFileContents) {
                          
                $cdtFileContents = $this->replaceCommonTags( $cdtFileContents );
                
                $name = $modulePath.ModuleCreator::PATH_TEMPLATES.'obj_CommonDisplay.php';
                file_put_contents( $name, $cdtFileContents);
            

            } else {
                echo "Couldn't Open [".$cdtFileName."]<br>";
                exit;
            }
             
        
        } // end if common look
        
        
        /*
         *  Create Tool_Setup File
         */
        $toolFileName = $templatePath.ModuleCreator::FILE_TOOL_SETUP;
        $toolFileContents = file_get_contents( $toolFileName );
        if ($toolFileContents) {
        
            $toolFileContents = $this->replaceCommonTags( $toolFileContents);
            
            // Replace Module Root Path
            $tagModuleRootPath = ModuleCreator::TAG_PATH_MODULE_ROOT;
            $path = ModuleCreator::PATH_MODULE_ROOT;
            $toolFileContents = str_replace($tagModuleRootPath, $path, $toolFileContents );
            
            $preName = 'app_';
            if ($moduleManager->isCore() ) {
                $preName = '';
            }
            
            $tag = ModuleCreator::TAG_TOOL_CORE_PRE;
            $toolFileContents = str_replace($tag, $preName, $toolFileContents );
            
            
            // if module shares a CommonLook then
            if ($moduleManager->isCommonLook()) {

                $clInclude = '// Create CommonDisplay labels 
    $labelManager->addPage( CommonDisplay::MULTILINGUAL_PAGE_KEY );
/*
    //
    // Use this section to create your common page label information:
    //
    $labelManager->addLabel( "[Title]", "Title", "en" );
    $labelManager->addLabel( "[Instr]", "Instructions", "en" );
*/';
                $clInclude .= "\n\n\n".ModuleCreator::TAG_TOOL_PAGE_LABEL; 
                           
            } else {
            
                $clInclude = ModuleCreator::TAG_TOOL_PAGE_LABEL;
            
            }
            
            // Replace CommonDisplay Tag
            $tagPageLabel = ModuleCreator::TAG_TOOL_PAGE_LABEL;
            $toolFileContents = str_replace($tagPageLabel, $clInclude, $toolFileContents );
            
            $name = $this->values[ ModuleCreator::KEY_PATH_SETUP_NAME ];
            file_put_contents( $name, $toolFileContents);
            
        
        } else {
        
            echo "Couldn't Open [".$toolFileName."]<br>";
            exit;
        } 
        
        
        
        
        
        
        
        //////////////////
        //////////////////
        
        
        
        
        /*
         *  Create db_backup.sh File
         */
        $dbFileName = $templatePath.ModuleCreator::FILE_DB_BACKUP;
        $dbFileContents = file_get_contents( $dbFileName );
        if ($dbFileContents) {
        
            $dbFileContents = $this->replaceCommonTags( $dbFileContents);
            
            // Replace [USERID] tag
            $tagUserID = '[USERID]';
            $user = SITE_DB_USER;
            $dbFileContents = str_replace($tagUserID, $user, $dbFileContents );
            
            
            // Replace [DATABASE] tag
            $tagDatabase = '[DATABASE]';
            $dbName = SITE_DB_NAME;
            $dbFileContents = str_replace($tagDatabase, $dbName, $dbFileContents );
            
            
            $moduleID = $moduleManager->getModuleID();
            $daObjList = new DAObjList( $moduleID );
            
            $nameList = '';
            
            $daObjList->setFirst();
            while( $daObj = $daObjList->getNext() ) {
            
                $nameList .= $daObj->getDBTableName().' ';
            }
            
            // Replace [TABLELIST] tag
            $tagTableList = '[TABLELIST]';
            $dbFileContents = str_replace($tagTableList, $nameList, $dbFileContents );
            
            $name = $this->values[ ModuleCreator::KEY_PATH_MODULE_ROOT ].'db_backup.sh';
            file_put_contents( $name, $dbFileContents);
            
        
        } else {
        
            echo "Couldn't Open [".$dbFileName."]<br>";
            exit;
        } 
        
         
    }  // end createBaseFiles()
    
    
    
    //************************************************************************
	/**
	 * function processStateVarInfo
	 * <pre>
	 * Updates the app_ModuleName file with the stateVar info.
	 * </pre>
	 * @param $moduleID [INTEGER] The module id of the statevars to work with
	 * @return [void]
	 */
    function processStateVarInfo( $moduleID ) 
    {
        // open app file
        $appFileName = $this->values[ ModuleCreator::KEY_PATH_APP_NAME ];
        $appFileContents = file_get_contents( $appFileName );
        
        // get stateList object
        $stateVarList = new StateVarList( $moduleID );
        
        // for each statevar object
        $stateVarList->setFirst();
        while( $stateVar = $stateVarList->getNext() ) {
        
            // if object not created then
            if (!$stateVar->isCreated()) {
            
                // insert state var CONST definition
                $tag = ModuleCreator::TAG_PAGE_STATEVAR_CONST;
                $name = $stateVar->getConstName();
                $id = $stateVar->getID();
                $data = '    /*! const '.$name.'   The QueryString '.$name.' parameter. */
        const '.$name.' = "SV'.$id.'";';
                $data .= "\n\n".$tag;
                $appFileContents = str_replace($tag, $data, $appFileContents );
            
                // insert state var definition
                $tag = ModuleCreator::TAG_PAGE_STATEVAR;
                $name = $stateVar->getName();
                $desc = $stateVar->getDescription();
                $type = $stateVar->getType();
                $data = '    /*! protected $'.$name.'   ['.$type.'] '.$desc.' */
		protected $'.$name.';';
                $data .= "\n\n".$tag;
                $appFileContents = str_replace($tag, $data, $appFileContents );
                
                // insert state var initialization
                $tag = ModuleCreator::TAG_PAGE_STATEVAR_INIT;
                $moduleName = $this->values[ ModuleCreator::KEY_MODULE_NAME ];
                $name = $stateVar->getName();
                $constName= strtoupper( $name);
                
                switch( $type) {
                    case 'STRING':
                        $defaultValue = '"'.$stateVar->getDefaultValue().'"';
                        break;
                    
                    case 'BOOL':
                    case 'INTEGER':
                        $defaultValue = $stateVar->getDefaultValue();
                        if ($defaultValue == '') {
                            $defaultValue = '""';
                        }
                        break;

                }
                $data = '        // load the module\'s '.$constName.' variable
        $this->'.$name.' = $this->getQSValue( module'.$moduleName.'::'.$constName.', '.$defaultValue.' );';
                $data .= "\n\n".$tag;
                $appFileContents = str_replace($tag, $data, $appFileContents );
                
                // insert state var create link entries
                // phpDoc comments:
                $tag = ModuleCreator::TAG_PAGE_CALLBACK_DOC;
                $name = $stateVar->getName();
                $const = strtoupper($name); 
                $type = $stateVar->getType();
                $data = '	 * \''.$name.'\' ['.$type.'] The Desired '.$const.' of this Link.';
                $data .= "\n".$tag;
                $appFileContents = str_replace($tag, $data, $appFileContents );
                
                // function parameter
//                $tag = ModuleCreator::TAG_PAGE_CALLBACK_PARAM;
//                $name = $stateVar->getName();
//                $data = ', $'.$name."=''";
//                $data .= $tag;
//                $appFileContents = str_replace($tag, $data, $appFileContents );
                
                // function Code
                $tag = ModuleCreator::TAG_PAGE_CALLBACK_CODE;
                $name = $stateVar->getName();
                $data = '        if ( isset( $parameters[\''.$name.'\']) ) {
            if ( $parameters[\''.$name.'\'] != \'\' ) {
                if ($callBack != \'\') {
                    $callBack .= \'&\';
                }
                $callBack .= module'.$moduleName.'::'.$const.'.\'=\'.$parameters[\''.$name.'\'];
            }
        }';
                $data .= "\n\n".$tag;
                $appFileContents = str_replace($tag, $data, $appFileContents );
                
                // Now mark this state var as having been created.
                $stateVar->setCreated();
                
            } // end if
            
        } // next object
        
        
        // save file contents
        file_put_contents( $appFileName, $appFileContents);
        
    }  // end processStateVarInfo()
    
    
    
    //************************************************************************
	/**
	 * function processDataAccessObjectInfo
	 * <pre>
	 * Takes the Data Access info and creates the proper tool_setup.php entries
	 * as well as the individual DataAccessManager & DataAccessList objects.
	 * </pre>
	 * @param $moduleID [INTEGER] The module id of the DAObjects to work with
	 * @return [void]
	 */
    function processDataAccessObjectInfo( $moduleID ) 
    {
    
        $pathToCodeTemplates = $this->values[ ModuleCreator::KEY_PATH_RAD_ROOT ];
        $pathToCodeTemplates .= 'data/code/';
        
        $codeTemplate = new Template( $pathToCodeTemplates );
        
        // open include file to include any created objects
        $includeFileName = $this->values[ ModuleCreator::KEY_PATH_INCLUDE_NAME ];
        $includeFileContents = file_get_contents( $includeFileName );
        
        /* 
         * Begin by modifying the tool_setup file
         */
        
        // open tool_setup file
        $setupFileName = $this->values[ ModuleCreator::KEY_PATH_SETUP_NAME ];
        $setupFileContents = file_get_contents( $setupFileName );
        
        // get daObjList object
        $daObjList = new DAObjList( $moduleID );
        
        // for each daObj object
        $daObjList->setFirst();
        while( $daObj = $daObjList->getNext() ) {
        
            // if object not created then
            if (!$daObj->isCreated()) {
            
                $docTableName = ucwords($daObj->getName());
                $docTableDescription = $daObj->getDescription() . "\n";
                $docFieldList = '';
                
                $sqlManagerName = $docTableName;
                $sqlFieldList = '';
                $sqlPrimaryKey = '';
                $fieldLabels = '';
                $tableManagerFieldList = '';
                $primaryKeyFieldName = '';
                $listInitFields = array();
                $labelFieldName = '';
                
                $fieldList = $daObj->getFieldList();
                
                $fieldList->setFirst();
                while ( $field = $fieldList->getNext() ) {
                
                    // compile documentation entries
                    $docFieldList .= '     * '.$field->getName().' ['.$field->getType().']  '.$field->getDescription()."\n";
                    
                    // compile sql field(s) 
                    $sqlFieldList .= $this->getSQLFieldEntry( $field );
                     
                    if ($field->isPrimaryKey()) {
                        $sqlPrimaryKey = '  PRIMARY KEY ('.$field->getName() .")\n";
                        $primaryKeyFieldName = $field->getName();
                    }
                    
                    
                    // Collect Field Label info
                    $fieldLabels .= $this->getFieldLabels( $field );
                    
                    // collect TableManager field list
                    if ($tableManagerFieldList != '') {
                        $tableManagerFieldList .= ',';
                    }
                    $tableManagerFieldList .= $field->getName();
                    
                    // collect names of any fields used to init the list
                    if ( $field->isListInit() ) {
                        $listInitFields[] = $field;
                    }
                    
                    // store the field name used for labels display(s)
                    // (like Form Grid Rows, or Drop List Labels, etc...)
                    if ( $field->isLabelName() ) {
                        $labelFieldName = $field->getName();
                    }
                    
                } // next Field Entry
                
                // combine sqlFieldList with sqlPrimaryKey
                $sqlFieldList .= $sqlPrimaryKey;

                $codeTemplate->set( 'tableName' , $docTableName);
                $codeTemplate->set( 'tableDescription', $docTableDescription);
                $codeTemplate->set( 'fieldList', $docFieldList );
                
                $codeTemplate->set( 'tableNameCap', $sqlManagerName );
                $codeTemplate->set(  'dbFieldList', $sqlFieldList );
                
                $setupCode = $codeTemplate->fetch( 'setup_dbTable.php' );
//echo $setupCode;
//exit;

            
                // insert sql setup code 
                $tag = ModuleCreator::TAG_TOOL_DAOBJ_TABLE;
                $data = $setupCode."\n\n\n\n".$tag;
                $setupFileContents = str_replace($tag, $data, $setupFileContents );
                
                // insert field labels 
                $tag = ModuleCreator::TAG_TOOL_FIELDS_LABEL;
                $data = "    //\n    // ".$daObj->getName()." table\n    //\n".$fieldLabels."\n\n".$tag;
                $setupFileContents = str_replace($tag, $data, $setupFileContents );
            
                // Now create new Table manager Object
                $tableManagerName = $this->createTableManagerObject( $daObj, $tableManagerFieldList, $primaryKeyFieldName, $labelFieldName, $docFieldList, $sqlFieldList);
                
                // Now create new List Manager Object
//                $listIteratorName = $this->createListIteratorObject( $daObj, $listInitFields );
                
                // Now insert new objects into include file
                $tag = ModuleCreator::TAG_INCLUDE_DA;
                $data = "require_once( '".ModuleCreator::PATH_OBJECT_DA.$tableManagerName."' );\n";
//                $data .= "require_once( '".ModuleCreator::PATH_OBJECT_DA.$listIteratorName."' );\n";
                $data .= $tag;
                $includeFileContents = str_replace($tag, $data, $includeFileContents );
                
                // Now mark this Data Access Object as having been created.
                $daObj->setCreated();
                
            } // end if !created
            
        } // next object
        
        
        // save Setup file contents
        file_put_contents( $setupFileName, $setupFileContents);
        
        
        // save Include File Contents
        file_put_contents( $includeFileName, $includeFileContents);
        
    }  // end processDataAccessObjectInfo()
    
    
    
    //************************************************************************
	/**
	 * function createTableManagerObject
	 * <pre>
	 * Creates a new Table Manager Object for the given daObj Object. This 
	 * function returns the name of the file it creates.
	 * </pre>
	 * @param $daObj [OBJECT] Current Data Access Object.
	 * @param $fieldList [STRING] list of fields in this da object
	 * @param $primaryKeyFieldName [STRING] name of the field that is the primary key.
	 * @param $labelFieldName [STRING] name of the field used for labels
	 * @param $dbTableDescriptionDoc [STRING] the documentation for the db fields
	 * @param $dbTableDescriptionSQL [STRING] SQL code to create the db table
	 * @return [STRING]
	 */
    function createTableManagerObject( $daObj, $fieldList, $primaryKeyFieldName, $labelFieldName, $dbTableDescriptionDoc, $dbTableDescriptionSQL ) 
    {
    
        // get path/Name of template
        $pathToDATemplate = $this->values[ ModuleCreator::KEY_PATH_RAD_ROOT ];
        $pathToDATemplate .= 'data/'.ModuleCreator::PATH_OBJECT_DA;
        
        $fileName = $pathToDATemplate.ModuleCreator::FILE_DA_ROWMANAGER;
        $fileContents = file_get_contents( $fileName );
        
        // update sections:
        // Module Name
        // Creator Name
        $fileContents = $this->replaceCommonTags( $fileContents );

        
        // DAObj Name
        $tag = ModuleCreator::TAG_DAOBJ_NAME;
        $data = $daObj->getManagerName();
        $fileContents = str_replace($tag, $data, $fileContents );
        
        // DAObj Desc
        $tag = ModuleCreator::TAG_DAOBJ_DESC;
        $data = $daObj->getDescription();
        $fileContents = str_replace($tag, $data, $fileContents );
                
        // DB Table Name
        $tag = ModuleCreator::TAG_DAOBJ_DBTABLE;
        $data = $daObj->getDBTableName();
        $fileContents = str_replace($tag, $data, $fileContents );
        
        // DB Table Field Documentation
        $tag = ModuleCreator::TAG_DAOBJ_DBTABLE_DOC;
        $data = $dbTableDescriptionDoc;
        $fileContents = str_replace($tag, $data, $fileContents );
        
        // DB Table SQL code
        $tag = ModuleCreator::TAG_DAOBJ_DBTABLE_SQL;
        $data = $dbTableDescriptionSQL;
        $fileContents = str_replace($tag, $data, $fileContents );
        
        // Field List
        $tag = ModuleCreator::TAG_DAOBJ_DBFIELDLIST;
        $data = $fieldList;
        $fileContents = str_replace($tag, $data, $fileContents );
        
        // XML_NODE_NAME
        $tag = ModuleCreator::TAG_DAOBJ_XMLNODENAME;
        $data = strtolower($daObj->getName());
        $fileContents = str_replace($tag, $data, $fileContents);
        
        // State Variable Information
        $stateVarID = $daObj->getManagerInitVarID();
        $stateVar = new RowManager_StateVarManager( $stateVarID );
        if ( $stateVar->isLoaded() ) {
            $data = $stateVar->getName();
        } else {
            $data = 'initValue';
        }
        $tag = ModuleCreator::TAG_DAOBJ_STATEVAR;
        $fileContents = str_replace($tag, $data, $fileContents);
        
        // DAOBJ Primary Key Field Name
        $tag = ModuleCreator::TAG_DAOBJ_PRIMARYKEY;
        $data = $primaryKeyFieldName;
        $fileContents = str_replace($tag, $data, $fileContents);
        
        // Insert return value for getLabel() function
        // if a labelFieldName was given
        if ($labelFieldName != '' ) {
        
            // return function result
            $data = $labelFieldName;
        
        } else {
        // else
        
            // return error message
            $data = 'No Field Label Marked';
            
        } // endif
        $tag = ModuleCreator::TAG_DAOBJ_GETLABEL;
        $fileContents = str_replace($tag, $data, $fileContents);
        
        // save new file
        $modulePath = $this->values[ ModuleCreator::KEY_PATH_MODULE_ROOT ];
        $modulePath .= ModuleCreator::PATH_OBJECT_DA;
        $name = $daObj->getManagerName().'.php';
        $fileName = $modulePath . $name;
        file_put_contents( $fileName, $fileContents);
                
        return $name;
        
    }  // end createTableManagerObject()
    
    
    
    //************************************************************************
	/**
	 * function createListIteratorObject
	 * <pre>
	 * Creates a new List Iterator Object for the given daObj Object. This 
	 * function returns the name of the file it creates.
	 * </pre>
	 * @param $daObj [OBJECT] Current Data Access Object.
	 * @param $listInitFields [ARRAY] fields required to initialize the list
	 * @return [STRING]
	 */
    function createListIteratorObject( $daObj, $listInitFields ) 
    {
    
        // get path/Name of template
        $pathToDATemplate = $this->values[ ModuleCreator::KEY_PATH_RAD_ROOT ];
        $pathToDATemplate .= 'data/'.ModuleCreator::PATH_OBJECT_DA;
        
        $fileName = $pathToDATemplate.ModuleCreator::FILE_DA_LISTITERATOR;
        $fileContents = file_get_contents( $fileName );
        
        // update sections:
        // Module Name
        // Creator Name
        $fileContents = $this->replaceCommonTags( $fileContents );

        
        // DAObj Name
        $tag = ModuleCreator::TAG_DAOBJ_NAME;
        $data = $daObj->getListIteratorName();
        $fileContents = str_replace($tag, $data, $fileContents );
        
        // DAObj Desc
        $tag = ModuleCreator::TAG_DAOBJ_DESC;
        $data = 'This object manages the listing of the '.strtolower($daObj->getName()).' table elements.';
        $fileContents = str_replace($tag, $data, $fileContents );
                
        // DA Object Row Manager Name
        $tag = ModuleCreator::TAG_DAOBJ_ROWMANAGER;
        $data = $daObj->getManagerName();
        $fileContents = str_replace($tag, $data, $fileContents );
        
        // compile list init fields
        $docComments = '';
        $parameters = '';
        $initCode = '';
        for( $indx=0; $indx<count($listInitFields); $indx++) {
        
            // documentation 
            $docComments .= "     * @param $".$listInitFields[ $indx ]->getName()." [".$listInitFields[ $indx ]->getType()."] value used to initialize the list.\n";
            
            // parameters
            switch( $listInitFields[ $indx ]->getType() ) {
                case 'STRING':
                    $parameters .= "$".$listInitFields[ $indx ]->getName()."=''";
                    break;
                    
                case 'INTEGER':
                    $parameters .= "$".$listInitFields[ $indx ]->getName()."=-1";
                    break;
                    
                default:
                    $parameters .= "$".$listInitFields[ $indx ]->getName()."=''";
                    break;
            } // end switch()
            
            // tack on a ',' here so that the parameter list ends with a ','
            // (note: there is another param afterwards)
            if ($parameters != '') {
                $parameters .= ', ';
            }
            
            // Initialization Code
            $initCode .= '        $searchManager->setValueByFieldName("'.$listInitFields[ $indx ]->getName().'", $'.$listInitFields[ $indx ]->getName()." );\n";
        }
        
        // Init Variable Documentation
        $tag = ModuleCreator::TAG_DAOBJ_INITVAR_DOC;
        $data = $docComments;
        $fileContents = str_replace($tag, $data, $fileContents );
        
        // Init Variable Parameters
        $tag = ModuleCreator::TAG_DAOBJ_INITVAR_PARAM;
        $data = $parameters;
        $fileContents = str_replace($tag, $data, $fileContents );
        
        // Init Code Data
        $tag = ModuleCreator::TAG_DAOBJ_INITVAR_CODE;
        $data = $initCode;
        $fileContents = str_replace($tag, $data, $fileContents );
        
                
        // save new file
        $modulePath = $this->values[ ModuleCreator::KEY_PATH_MODULE_ROOT ];
        $modulePath .= ModuleCreator::PATH_OBJECT_DA;
        $name = $daObj->getListIteratorName().'.php';
        $fileName = $modulePath . $name;
        file_put_contents( $fileName, $fileContents);
                
        return $name;
        
    }  // end createListIteratorObject()
    
    
    
    //************************************************************************
	/**
	 * function processPageInfo
	 * <pre>
	 * Takes the Page info and creates the proper objects_bl/ pages, updates
	 * app_Module with the proper initialization info.
	 * </pre>
	 * @param $moduleID [INTEGER] The module id of the Pages to work with
	 * @return [void]
	 */
    function processPageInfo( $moduleID ) 
    {
        
        // open include file
        $key = ModuleCreator::KEY_PATH_INCLUDE_NAME;
        $includeFileName = $this->values[ $key ];
        $includeFileContents = file_get_contents( $includeFileName );
        
        // open app file
        $appFileName = $this->values[ ModuleCreator::KEY_PATH_APP_NAME ];
        $appFileContents = file_get_contents( $appFileName );
        
        $pageList = new PageList( $moduleID );
        
        // for each page
        $pageList->setFirst();
        while ( $page = $pageList->getNext() ) {
        
            // if page not already created
            if (!$page->isCreated() ) {
            
                // open page template based on page type
                $templateContents = $this->getTemplate( $page );
                                
                // replace TAGS
                $this->replaceTemplateTags( $page, $templateContents);
                
                // store data as new object bl file
                $blPath = $this->values[ ModuleCreator::KEY_PATH_MODULE_PAGES ];
                $name = 'page_'.$page->getPageName().'.php';
                file_put_contents( $blPath.$name, $templateContents);
             
                // include new file in include file
                $tag = ModuleCreator::TAG_INCLUDE_PAGES;
                $data = "require_once( '".ModuleCreator::PATH_OBJECT_PAGES.$name."' );\n";
                $data .= $tag;
                $includeFileContents = str_replace($tag, $data, $includeFileContents );
  
         
                // update page info in app file
                $this->updatePageAppInfo( $page, $appFileContents );
                
                // prepare the tool setup file to receive labels for this page.
                $this->preparePageLabels( $page );
                
                // if page is a custom template then
                if ($page->isCustom() ) {
                
                    $this->transferCustomTemplate( $page );
                                        
                } // end if
                
                // Mark this page as having been created
                $page->setCreated();
                
            } // end if
            
            
            // NOTE: we update a page labels even if a page has already been
            // created.  If there are new labels, they will be added to the
            // list.
            // update page labels
            $this->updatePageLabels( $page );
            
        } // next page
        
        // save include file
        file_put_contents( $includeFileName, $includeFileContents);
        
        // save app file
        file_put_contents( $appFileName, $appFileContents);
            
    }  // end processPageInfo()
    
    
    
    //************************************************************************
	/**
	 * function getTemplate
	 * <pre>
	 * Returns the contents of the proper Page Template based upon the given
	 * page type.
	 * </pre>
	 * @param $page [OBJECT] The current page object
	 * @return [STRING]
	 */
    function getTemplate( $page ) 
    {
        $contents = '';
        
        $fileName = $page->getBLTemplateName();
        
        $pathToTemplates = $this->values[ ModuleCreator::KEY_PATH_RAD_ROOT ];
        $pathToTemplates .= 'data/'.ModuleCreator::PATH_OBJECT_BL;
        
        $contents = file_get_contents( $pathToTemplates.$fileName );
        
        return $contents;
    }  // end getCurrentDate()
    
    
    
    //************************************************************************
	/**
	 * function replaceTemplateTags
	 * <pre>
	 * Updates the given template contents with the proper data
	 * </pre>
	 * @param $page [OBJECT] The current Page Object
	 * @param $templateData [STRING] The contents of the Template File
	 * @return [STRING]
	 */
    function replaceTemplateTags( $page, &$templateData ) 
    {
        /*
         * insert common tags here 
         */
        $templateData = $this->replaceCommonTags( $templateData );
        
        // insert Page Prefix Name 
        $tag = ModuleCreator::TAG_PAGE_PREFIXNAME;
        $data = $page->getPagePrefixName();
        $templateData = str_replace($tag, $data, $templateData );
        
        // insert Page Name 
        $tag = ModuleCreator::TAG_PAGE_NAME;
        $data = $page->getPageName();
        $templateData = str_replace($tag, $data, $templateData );
        
        // insert Page Description 
        $tag = ModuleCreator::TAG_PAGE_DESCRIPTION;
        $data = $page->getDescription();
        $templateData = str_replace($tag, $data, $templateData );
        
        /*
         * Process Form Portions of the Templates
         */
        // Gather Form Field entry data...
        $fieldList = '';
        $formEntryList = '';
        
        // $formDateFieldList is used to create the startYear and endYear data 
        // to pass to the form templates (formEntrySingle, Adminbox, ...)
        $formDateFieldList = array(); 
         
        // fieldListEntries is used to make sure we don't duplicate entries in 
        // the field list when we add foreign key information to it.
        $fieldListEntries = array();   
        $formFieldList = $page->getFormFieldList();
        $formFieldList->setFirst();
        while ( $field = $formFieldList->getNextDataField() ) {
            
            if ($fieldList != '') {
                $fieldList .= ',';
            }
            $fieldList .= $field->getFieldTypeEntry();
            
            if ($formEntryList != '') {
                $formEntryList .= ',';
            }
            $formEntryList .= $field->getFormEntryType();
            
            // if this field is a date type
            if ($field->isDateType()) {
            
                $formDateFieldList[] = $field->getname();
            
            }
            
            // save the name of this entry in the fieldListEntries
            $name = $field->getName();
            $fieldListEntries[ $name ] = $name;
        }
        
        
        // step through each field of the formDAObj to see if it contains
        // any foreign keys
        $foreignKeyInfo = array();
        $foreignKeyInit = '// save the value of the Foriegn Key(s)';
        $formDAObj = $page->getFormDAObj();
        $formFields = $formDAObj->getFieldList();
        $formFields->setFirst();
        while( $field = $formFields->getNext() ) {

            // if current field is a foreign key
            if ( $field->isForeignKey() ) {
                
                // compile foreign Key init statements
                if ($foreignKeyInit != '') {
                    $foreignKeyInit .= "\n";
                }
                $name = $field->getName();
                $foreignKeyInit .= '            $this->formValues[ \''.$name.'\' ] = $this->'.$name.';';
                

                // Store additional foreign key param info
                $info['name'] = $name;
                $info['type'] = $field->getType();
                $foreignKeyInfo[] = $info;

                // if current field is NOT already in field list then add it
                if ( !array_key_exists( $name, $fieldListEntries) ) {
                
                    // mark entry to be skipped for is data valid operations
                    if ($fieldList != '') {
                        $fieldList .= ',';
                    }
                    $fieldList .= $name.'|T|<skip>';
                    
                    // mark entry as not being displayed on a form
                    if ($formEntryList != '') {
                        $formEntryList .= ',';
                    }
                    $formEntryList .= '-';
                    
                } // end if field NOT in field list
                
            } // end if foreign key

        } // next field
        
        
        // To find the Form's Data Manager's Init Variable we find the 
        // primary key field for the form:
        $formInitVar = 'You Did not select a primary key for this DAObj';
        $formDAObj = $page->getFormDAObj();
        $formFields = $formDAObj->getFieldList();
        $formFields->setFirst();
        while( $field = $formFields->getNext() ) {
            
            if( $field->isPrimaryKey() ) {
                $formInitVar = $field->getName();
            }
            
        }
        
        // insert Field Type List
        $tag = ModuleCreator::TAG_PAGE_FORMFIELDTYPE;
        $data = $fieldList;
        $templateData = str_replace($tag, $data, $templateData );
        
        // insert Form Entry Type List
        $tag = ModuleCreator::TAG_PAGE_FORMENTRYTYPE;
        $data = $formEntryList;
        $templateData = str_replace($tag, $data, $templateData );
        
        // data Manager's Init Variable Name
        $tag = ModuleCreator::TAG_FORM_INIT_NAME;
        $data = $formInitVar;
        $templateData = str_replace($tag, $data, $templateData );
        
        // data Manager Object
        $dataManager = $page->getFormDAObj();
        $tag = ModuleCreator::TAG_PAGE_DATAMANAGER;
        $data = $dataManager->getManagerName();
        $templateData = str_replace($tag, $data, $templateData );
        
        // Foreign Key Initialization (for Admin Boxes)
        $tag = ModuleCreator::TAG_PAGE_FOREIGNKEY;
        $data = $foreignKeyInit."\n        ".$tag;
        $templateData = str_replace($tag, $data, $templateData );
        
        // Form button Text update
        $tag = '[RAD_BUTTONLABEL]';
        if ( $page->isAddType() ) {
            $data = '[Add]';
        } else {
            $data = '[Update]';
        }
        $templateData = str_replace($tag, $data, $templateData );
        
        
        // Insert the Date Field's startYear and endYear Values
        $data = '';
        for( $indx=0; $indx<count($formDateFieldList); $indx++) {
            $name = $formDateFieldList[ $indx ];
            $data .= '        $this->template->set( \'startYear_'.$name.'\', 2000);
        $this->template->set( \'endYear_'.$name.'\', 2010);'."\n\n";
        }
        $tag = ModuleCreator::TAG_PAGE_DATE_PARAM;
        $templateData = str_replace($tag, $data, $templateData );
        
        
        /*
         * Form Grid Updates
         */
        
        $formGridListInitName = '';
        $formGridLabelFieldName = ''; 
        $formDAObj = $page->getFormDAObj();
        $formFields = $formDAObj->getFieldList();
        $formFields->setFirst();
        while( $field = $formFields->getNext() ) {
            
            if( $field->isListInit() ) {
                $formGridListInitName = $field->getName();
            }
            
            if( $field->isLabelName() ) {
                $formGridLabelFieldName = $field->getName();
            }
            
        }
        
        // Insert the name of the ListIterator Object name
        $tag = ModuleCreator::TAG_FORMGRID_LIST_OBJ_NAME;
        $data = $formDAObj->getListIteratorName();
        $templateData = str_replace($tag, $data, $templateData );
        
        // Insert the name of the ListIterator's InitVar name
        $tag = ModuleCreator::TAG_FORMGRID_LIST_INIT_NAME;
        $data = $formGridListInitName;
        $templateData = str_replace($tag, $data, $templateData );
        
        // Insert the name of the ListIterator's InitVar name
        $tag = ModuleCreator::TAG_FORMGRID_LABEL_NAME;
        $data = $formGridLabelFieldName;
        $templateData = str_replace($tag, $data, $templateData );
        
        
        
        /*
         * Process Data List Information
         */
        $fieldList = '';
        $listFieldList = $page->getListFieldList();
        $listFieldList->setFirst();
        while ( $field = $listFieldList->getNextDataField() ) {
            
            if ($fieldList != '') {
                $fieldList .= ',';
            }
            $fieldList .= $field->getName();

        }
        
        // to find the listInitVarName we step through all the fields of the 
        // list DAObj to find the listInit's
        $listInitVarName = array();
        $listDAObj = $page->getListDAObj();
        $listDAObjFields = $listDAObj->getFieldList();
        $listDAObjFields->setFirst();
        while( $field = $listDAObjFields->getNext() ) {
        
            if ( $field->isListInit() ) {
                $listInitVarName[] = $field->getName();
            }
        }
        
        
        // get primary Key info
        $primaryKeyName = 'You Did not select a primary key for this DAObj';
        $listDAObj = $page->getListDAObj();
        $listFields = $listDAObj->getFieldList();
        $listFields->setFirst();
        while( $field = $listFields->getNext() ) {
            
            if( $field->isPrimaryKey() ) {
                $primaryKeyName = $field->getName();
            }
            
        }
        
        // insert Display Field List
        $tag = ModuleCreator::TAG_PAGE_LIST_FIELDS;
        $data = $fieldList;
        $templateData = str_replace($tag, $data, $templateData );
        
        // data List Object's RowManager Name
        $tag = ModuleCreator::TAG_PAGE_LIST_ROWMANAGER;
        $data = $listDAObj->getManagerName();
        $templateData = str_replace($tag, $data, $templateData );
        
        // data List object Name
        $listManager = $page->getListDAObj();
        $tag = ModuleCreator::TAG_PAGE_LISTMANAGER;
        $data = $listManager->getListIteratorName();
        $templateData = str_replace($tag, $data, $templateData );
        
        /*
         * Update the Data List Initialization Data ...
         */
            // Data List Init Variable Name (define the variable)
            $tag = ModuleCreator::TAG_LIST_INIT_NAME;
            $data = '/* no List Init Variable defined for this DAObj */';
            if (count($listInitVarName) > 0) {
                $data = '';
                for( $indx=0; $indx<count($listInitVarName); $indx++) {
                    if ($data != '') {
                        $data .= "\n\n";
                    }
                    $data .= "    /** @var [STRING] The initialization variable for the dataList */
    protected $".$listInitVarName[$indx].";";
                }
            }
            $templateData = str_replace($tag, $data, $templateData );
        
            // Documentation Header
            $tag = ModuleCreator::TAG_LIST_INIT_DOC;
            $data = '';
            for( $indx=0; $indx<count($listInitVarName); $indx++) {
                $data .= '	 * @param $'.$listInitVarName[$indx].' [STRING] The init data for the dataList obj'."\n";
            }
            $templateData = str_replace($tag, $data, $templateData );
            
            // Parameter Entry
            $tag = ModuleCreator::TAG_LIST_INIT_PARAM;
            $data = '';
            for( $indx=0; $indx<count($listInitVarName); $indx++) {
                $data .= ', $'.$listInitVarName[$indx].'=""';
            }
            $templateData = str_replace($tag, $data, $templateData );
            
            // Module Variable Initilization 
            $tag = ModuleCreator::TAG_LIST_INIT_VAR_INIT;
            $data = '';
            for( $indx=0; $indx<count($listInitVarName); $indx++) {
                $data .= '        $this->'.$listInitVarName[$indx].' = $'.$listInitVarName[$indx].';'."\n";
            }
            $templateData = str_replace($tag, $data, $templateData );
            
            // DAObj Parameter Initilization 
            $tag = ModuleCreator::TAG_LIST_INIT_DAOBJ_PARAM;
            $data = '';
            for( $indx=0; $indx<count($listInitVarName); $indx++) {
                $data .= '$this->'.$listInitVarName[$indx].', ';
            }
            $templateData = str_replace($tag, $data, $templateData );
        
        // data List Object's primary key
        $tag = ModuleCreator::TAG_PAGE_LIST_PRIMARYKEY;
        $data = $primaryKeyName;
        $templateData = str_replace($tag, $data, $templateData );
        
        
        // now create the parameters for the foreign keys
        // make sure to not include the data list init value
        $paramVariables = '';
        $paramDocumentation = '';
        $paramList = '';
        $paramSave = '';
        for( $indx=0; $indx<count($foreignKeyInfo); $indx ++ ) {
        
            $name = $foreignKeyInfo[$indx]['name'];
            $type = $foreignKeyInfo[$indx]['type'];
            
            // current foriegn key != data list Init Variable
            if (!in_array($name, $listInitVarName) ) {
            
                // compile variable definition
                if ($paramVariables != '') {
                    $paramVariables .= "\n\n";
                }
                $paramVariables .= '	/** @var ['.$type.'] Foreign Key needed by Data Manager */
	protected $'.$name.';';
	           
	           // compile parameter documentation
	           $paramDocumentation .= '	 * @param $'.$name.' ['.$type.'] The foreign key data for the data Manager'."\n";
	           
	           // compile parameter list
	           $paramList .= ', $'.$name."=''";
	           
	           $paramSave .= '        $this->'.$name.' = $'.$name.";\n";
	           
            } // end if not data list init var
            
        } // next foreign key data item
        
        // now replace them in the document
        // insert parameter Variable definitions
        $tag = ModuleCreator::TAG_PAGE_FOREIGNKEY_VARIABLE;
        $data = $paramVariables;
        $templateData = str_replace($tag, $data, $templateData );
        
        // insert Foreign Key parameter Variable documentation
        $tag = ModuleCreator::TAG_PAGE_FOREIGNKEY_DOCUMENTATION;
        $data = $paramDocumentation;
        $templateData = str_replace($tag, $data, $templateData );
        
        // insert Foreign Key parameter parameter entry
        $tag = ModuleCreator::TAG_PAGE_FOREIGNKEY_PARAM;
        $data = $paramList . ')';
        $templateData = str_replace($tag, $data, $templateData );
        
        // insert Foreign Key parameter saving entry
        $tag = ModuleCreator::TAG_PAGE_FOREIGNKEY_SAVE;
        $data = $paramSave;
        $templateData = str_replace($tag, $data, $templateData );
        
        
        // Now finally replace the name of the Site Template to reference
        // by default
        $tag = ModuleCreator::TAG_PAGE_TEMPLATE_DEFAULT;
        $data = $page->getSiteTemplateName();
        $templateData = str_replace($tag, $data, $templateData );
                
    }  // end replaceTemplateTags()
    
    
    
    //************************************************************************
	/**
	 * function updatePageAppInfo
	 * <pre>
	 * Updates the given application data with the current page's init data
	 * </pre>
	 * @param $page [OBJECT] The current Page Object
	 * @param $appData [STRING] The contents of the app File
	 * @return [void]
	 */
    function updatePageAppInfo( $page, &$appData ) 
    {
    
        $id = $page->getID();
        $name = $page->getPageName();
        $constName = $page->getPageConstantName();
    
        // include page definition in appfile
        $tag = ModuleCreator::TAG_PAGE_CONST;
        $data = '    /** const '.$constName.'   Display the '.$name.' Page. */
        const '.$constName.' = "P'.$id.'";'."\n\n".$tag;
        $appData = str_replace($tag, $data, $appData );
        
        
        // include loadData() entry
        $tag = ModuleCreator::TAG_APP_LOAD_PAGE;
        $data = '            /*
             *  '.$name.'
             */
            case module[ModuleName]::'.$constName.':
                $this->load'.$name.'();
                break;'."\n\n".$tag;
                
        $data = $this->replaceCommonTags( $data );
        $appData = str_replace($tag, $data, $appData );
        
        // if page is the Site Default then
        if ($page->isDefault() ) {
        
            // replace Default Constant Name Entry
            $tag = ModuleCreator::TAG_PAGE_DEFAULT_CONST;
            $data = $constName;
            $appData = str_replace($tag, $data, $appData );
            
            // replace Default Page Name Entry
            $tag = ModuleCreator::TAG_PAGE_DEFAULT_NAME;
            $data = $name;
            $appData = str_replace($tag, $data, $appData );
            
        }
        
        // include load page function
        $initCode = $this->getPageInitCode( $page );
        $tag = ModuleCreator::TAG_APP_LOAD_PAGE_FN;
        $data = $initCode."\n\n\n\n".$tag;
        $appData = str_replace($tag, $data, $appData );
        
        
        // if page is an AdminBox Style 
        if ($page->isAdminBoxStyle() ) {
        
            // get AdminBox Process Code template
            $pathToTemplates = $this->values[ ModuleCreator::KEY_PATH_RAD_ROOT ];
            $pathToTemplates .= 'data/code/';
            $contents = file_get_contents( $pathToTemplates.'formTrans_AdminBox.php' );
            $contents = $this->replaceCommonTags( $contents );
            
            
            // insert post processing info
            // Page Constant Name
            $tag = ModuleCreator::TAG_TRANSITION_SOURCE_CONSTNAME;
            $data = $page->getPageConstantName();
            $contents = str_replace($tag, $data, $contents );
            
            // StateVar manager Init Info
            $formDaObj = $page->getFormDAObj();
            $stateVar = $formDaObj->getFormInitStateVar();
            
            $tag = ModuleCreator::TAG_PAGE_ADMINBOX_MANAGERINIT;
            $data = $stateVar->getName();
            $contents = str_replace($tag, $data, $contents );
            
            // The loadPage call()  
            $tag = ModuleCreator::TAG_PAGEINIT_NAME;
            $data = $page->getPageName();
            $contents = str_replace($tag, $data, $contents );
            
            
            // save data into App file 
            $tag = ModuleCreator::TAG_TRANSITION_CODE;
            $data = $contents."\n\n".$tag;
            $appData = str_replace($tag, $data, $appData);
            
        } // end if
 
                
    }  // end updatePageAppInfo()
    
    
    
    //************************************************************************
	/**
	 * function transferCustomTemplate
	 * <pre>
	 * Transfers the Custom Template to the proper place.
	 * </pre>
	 * @param $page [OBJECT] The current Page Object
	 * @return [void]
	 */
    function transferCustomTemplate( $page ) 
    {

        /*
         * copy Custom Template to templates directory
         */
        // get original template contents...
        $pathToTemplates = $this->values[ ModuleCreator::KEY_PATH_RAD_ROOT ];
        $pathToTemplates .= 'data/templates/';
        $fileName = 'tmpl_page_Custom.php';
        $contents = file_get_contents( $pathToTemplates.$fileName );
        
        // replace page tags 
        $pagePrefixName = $page->getPagePrefixName();
        $pageName = $page->getPageName();
        
        // Replace the Page Prefix Name
        $tag = ModuleCreator::TAG_PAGEINIT_PREFIXNAME;
        $data = $pagePrefixName;
        $contents = str_replace($tag, $data, $contents );
        
        // Replace the Page Prefix Name
        $tag = ModuleCreator::TAG_PAGEINIT_PAGENAME;
        $data = $pageName;
        $contents = str_replace($tag, $data, $contents );
        
        // save template file
        $templateFileName = $this->values[ ModuleCreator::KEY_PATH_MODULE_TEMPLATE ];
        $templateFileName .= $pagePrefixName.$pageName.'.php';
        file_put_contents( $templateFileName, $contents);

    }
    
    
    
    //************************************************************************
	/**
	 * function getPageInitCode
	 * <pre>
	 * Compiles the function initialization code for a given page.
	 * </pre>
	 * @param $page [OBJECT] The current Page Object
	 * @return [STRING]
	 */
    function getPageInitCode( $page ) 
    {
    
        $id = $page->getID();
        $pagePrefixName = $page->getPagePrefixName();
        $pageName = $page->getPageName();
        $pageConstName = $page->getPageConstantName();
    
        $fileName = $page->getBLInitCodeName();
        
        $pathToTemplates = $this->values[ ModuleCreator::KEY_PATH_RAD_ROOT ];
        $pathToTemplates .= 'data/code/';
        
        $contents = file_get_contents( $pathToTemplates.$fileName );

        
        // Now attempt to fill out the Add, Edit, Delete, Continue Link info
        // for each transition
        $pageTransitionsList = new TransitionsList('', '', $page->getID() );
        $pageTransitionsList->setFirst();
        while( $transition = $pageTransitionsList->getNext() ) {

            // if type is not form then
            if ( !$transition->isFormType() ) {
            
                // get Link init code by transition type:
                $linkContent = $page->getLinkInitCode( $transition->getType() );
            
                // get Destination Page object
                $destPage = $transition->getToPageObj();
                
                // Get Constant Name of Destination Page
                $constName = $destPage->getPageConstantName();
                
                // get tag name by type 
                $tag = $transition->getPageConstTag();
                
                // replace tag
                $linkContent = str_replace($tag, $constName, $linkContent );
                
                // if type = Edit then
                if (( $transition->isEditType() ) 
                      || ( $transition->isDeleteType() ) ) {
                
                    // Get Page's Form INIT STATE VAR INFO
                    $formDaObj = $destPage->getFormDAObj();
                    if (!$formDaObj->isLoaded() ) {
                        $formDaObj = $destPage->getListDAObj();
                    }
                    $stateVar = $formDaObj->getFormInitStateVar();
                    
                    // replace [EDIT_STATEVAR_CONT] with constant name of statevar
                    $tag = '[EDIT_STATEVAR_CONST]';
                    $data = $stateVar->getConstName();
                    $linkContent = str_replace($tag, $data, $linkContent );
                    
                    
                    // now Create CallBack parameter list for Edit/Del links
                    // NOTE: the param list should skip the stateVar INIT variable
                    $formInitVar = $stateVar->getName();
                    $moduleID = $page->getModuleID();
                    $callbackParamList = $this->getCallBackParamList( $moduleID, $formInitVar );   
                       
                    $tag = ModuleCreator::TAG_PAGEINIT_CALLBACK_EDIT;
                    $data = $callbackParamList.$tag;
                    $linkContent = str_replace($tag, $data, $linkContent );
                    
                    
                    
                } // end if Edit or Delete type
                
                
                // now take link update content and add to pageInit content
                // replace tag
                $tag = '/*[RAD_LINK_INSERT]*/';
                $linkInsertContent = $linkContent."\n\n".$tag;

                $contents = str_replace($tag, $linkInsertContent, $contents );
                
            } // end if !formType  
            
        } // next transition
        
             
        // if page is AdminBox then
        if ( $page->isAdminBoxStyle() ) {
        
            $linkData = $page->getLinkInitAdminBox();
        
            // Get Page's Form INIT STATE VAR INFO
            $formDaObj = $page->getFormDAObj();
            $stateVar = $formDaObj->getFormInitStateVar();
            
            // replace [EDIT_STATEVAR_CONT] with constant name of statevar
            $tag = '[EDIT_STATEVAR_CONST]';
            $data = $stateVar->getConstName();
            $linkData = str_replace($tag, $data, $linkData );

            // Now take new LinkData & insert into page content
            $tag = '/*[RAD_LINK_INSERT]*/';
            $linkInsertContent = $linkData."\n\n".$tag;
            $contents = str_replace($tag, $linkInsertContent, $contents );
            
            
        } // end if
        
        
        // Replace Common Tags in init code
        $contents = $this->replaceCommonTags( $contents );
        
        // Replace the Function Name
        $tag = ModuleCreator::TAG_PAGEINIT_NAME;
        $data = $pageName;
        $contents = str_replace($tag, $data, $contents );
        
        // Replace the Page Prefix Name
        $tag = ModuleCreator::TAG_PAGEINIT_PREFIXNAME;
        $data = $pagePrefixName;
        $contents = str_replace($tag, $data, $contents );
        
        // Replace the Page Prefix Name
        $tag = ModuleCreator::TAG_PAGEINIT_PAGENAME;
        $data = $pageName;
        $contents = str_replace($tag, $data, $contents );
        
        // Replace the Page CONST Name
        $tag = ModuleCreator::TAG_PAGEINIT_CONSTNAME;
        $data = $pageConstName;
        $contents = str_replace($tag, $data, $contents );

        // now Create CallBack parameter list
        $moduleID = $page->getModuleID();
        $callbackParamList = $this->getCallBackParamList( $moduleID );   
           
        $tag = ModuleCreator::TAG_PAGEINIT_CALLBACK;
        $data = $callbackParamList.$tag;
        $contents = str_replace($tag, $data, $contents );
        
        
        // For Form Elements
        
        // find the form initilization (statevar) variable 
        $formDAObj = $page->getFormDAObj();
        $stateVar = $formDAObj->getFormInitStateVar();
        $formInitVar = '$this->'.$stateVar->getName();
           
        $tag = ModuleCreator::TAG_PAGEINIT_FORMINIT;
        $data = $formInitVar;
        $contents = str_replace($tag, $data, $contents );
        
        // for FormGrids, find the form's List Init (statevar) variable
        $stateVar = $formDAObj->getListInitStateVar();
        $formListInitVar = '$this->'.$stateVar->getName();
           
        $tag = ModuleCreator::TAG_PAGEINIT_FORMINIT_LIST;
        $data = $formListInitVar;
        $contents = str_replace($tag, $data, $contents );
        
        // Insert the List manager Init variable info here
        $listDAObj = $page->getListDAObj();
        $stateVar = $listDAObj->getListInitStateVar();
        if ($stateVar->isLoaded() ) {
            $listInitStateVarName = $stateVar->getName();
            $listInitVar = ', $this->'.$stateVar->getName();
        } else {
            $listInitStateVarName = '';
            $listInitVar = '';
        }
           
        $tag = ModuleCreator::TAG_PAGEINIT_LISTINIT;
        $data = $listInitVar;
        $contents = str_replace($tag, $data, $contents );
        
        // Insert the DAObj Init Variable info (for Delete Confirmation Pages)
        $stateVar = $listDAObj->getFormInitStateVar();
        if ($stateVar->isLoaded() ) {
            $listInitVar = ', $this->'.$stateVar->getName();
        } else {
            $listInitVar = '';
        }
        
        $tag = ModuleCreator::TAG_PAGEINIT_LIST_DAOBJ;
        $data = $listInitVar;
        $contents = str_replace($tag, $data, $contents );
        
        // now find the statevar(s) for all the foreign Keys
        $formInitVarList = '';
        $formFields = $formDAObj->getFieldList();
        $formFields->setFirst();
        while( $field = $formFields->getNext() ) {
            
            // find StateVar Name marked as Foreign Key
            if( $field->isForeignKey() ) {

                $stateVar = $field->getStateVar();
                
                // if stateVar exists
                if ( $stateVar->isLoaded() ) {
                
                    // if not the listInitStateVarName (already added above)
                    if ( $stateVar->getName() != $listInitStateVarName ) {
                    
                        // add to list
                        $formInitVarList = ', $this->'.$stateVar->getName();
                        
                    } // end if not listInitStateVarName
                    
                } // end if stateVar exists
                
            } // end if Foreign Key
            
        }// next field
        
        $tag = ModuleCreator::TAG_PAGEINIT_FOREIGNKEY_INIT;
        $data = $formInitVarList.$tag;
        $contents = str_replace($tag, $data, $contents );
        
    
        return $contents;
               
    }  // end getPageInitCode()
    
    
    
    //************************************************************************
	/**
	 * function getCallBackParamList
	 * <pre>
	 * Creates a set of call back parameters given the current module id.
	 * </pre>
	 * @param $moduleID [INTEGER] module id of the state vars to use.
	 * @param $skipField [STRING] name of the field to skip in the param list
	 * @return [STRING]
	 */
    function getCallBackParamList( $moduleID, $skipField='' ) 
    {
        // get list of this module's state vars
        $stateVarList = new StateVarList( $moduleID );
        
        // for each statevar object
        $callbackParamList = '';
        $stateVarList->setFirst();
        while( $stateVar = $stateVarList->getNext() ) {
        
            $stateVarName = $stateVar->getName();
            
            if ($stateVarName != $skipField) {
                if ( $callbackParamList != '') {
                    $callbackParamList .= ', ';
                }
                $callbackParamList .= '\''.$stateVarName.'\'=>$this->'.$stateVarName;
            } else {
//                $callbackParamList .= ', ""';
            }
        }
        
        return $callbackParamList;
        
    }  // end getCallBackParamList()
    
    
    
    //************************************************************************
	/**
	 * function processTransition
	 * <pre>
	 * Takes the Transition info and updates the app_MODULENAME file to 
	 * insert the form auto transitions.
	 * </pre>
	 * @param $moduleID [INTEGER] The module id of the Pages to work with
	 * @return [void]
	 */
    function processTransition( $moduleID ) 
    {
    
        // get form transition template
        $pathToTemplates = $this->values[ ModuleCreator::KEY_PATH_RAD_ROOT ];
        $pathToTemplates .= 'data/code/';
        $contentsTemplate = file_get_contents( $pathToTemplates.'formTrans_FormStyle.php' );
        $contentsTemplate = $this->replaceCommonTags( $contentsTemplate );
        
        // open app file
        $appFileName = $this->values[ ModuleCreator::KEY_PATH_APP_NAME ];
        $appFileContents = file_get_contents( $appFileName );
        
        $transitionsList = new TransitionsList( $moduleID );
        
        // for each transition
        $transitionsList->setFirst();
        while ( $transition = $transitionsList->getNext() ) {
        
            // if transition is a form type
            if ($transition->isFormType() ) {
            
                // if transition not already created
                if (!$transition->isCreated() ) {
                
                    
                    // get source page info
                    $sourcePage = $transition->getFromPageObj();
                    
                    // NOTE: this one uses the Template above as the initial
                    // code source.
                    $tag = ModuleCreator::TAG_TRANSITION_SOURCE_CONSTNAME;
                    $data = $sourcePage->getPageConstantName();
                    $contents = str_replace($tag, $data, $contentsTemplate );
                    
                    // replace the Source Page's init var back to ''
                    $tag = '[RAD_SOURCE_FORMINIT]';
                    $daObj = $sourcePage->getFormDAObj();
                    $stateVar = $daObj->getFormInitStateVar();
                    if ( $stateVar->isLoaded() ) {
                        $data = '$this->'.$stateVar->getName()." = '';";
                    } else {
                        $data = '/* No StateVar given for FormInit. */';
                    }
                    $contents = str_replace($tag, $data, $contents);
                    
                    // get destiniation page info
                    $destPage = $transition->getToPageObj();
                    
                    $tag = ModuleCreator::TAG_TRANSITION_DEST_CONSTNAME;
                    $data = $destPage->getPageConstantName();
                    $contents = str_replace($tag, $data, $contents);
                    
                    $tag = ModuleCreator::TAG_TRANSITION_DEST_NAME;
                    $data = $destPage->getPageName();
                    $contents = str_replace($tag, $data, $contents);
                    
                    
                    // save data into App file 
                    $tag = ModuleCreator::TAG_TRANSITION_CODE;
                    $data = $contents."\n\n".$tag;
                    $appFileContents = str_replace($tag, $data, $appFileContents);                 
                           
                    // Mark this transition as having been created
                    $transition->setCreated();
                    
                } // end if
                
            } // end if form type
            
        } // next page
        
        // save app file
        file_put_contents( $appFileName, $appFileContents);
            
    }  // end processTransition()
    
    
    
    //************************************************************************
	/**
	 * function preparePageLabels
	 * <pre>
	 * Inserts the given page's label definition and label insert tag.
	 * </pre>
	 * @param $page [OBJECT] The page to work with 
	 * @return [void]
	 */
    function preparePageLabels( $page ) 
    {
        
        // open tool_setup.php file
        $setupFileName = $this->values[ ModuleCreator::KEY_PATH_SETUP_NAME ];
        $setupContents = file_get_contents( $setupFileName );
        
        $pageLabelInsertTag = '/*[RAD_PAGE('.$page->getName().')_LABELS]*/';
        
        if (!$page->isCreated() ) {
        
            $baseCode = '    // Create [PageName] labels 
    $labelManager->addPage( [PrePageName][PageName]::MULTILINGUAL_PAGE_KEY );';

            $tag = '[PageName]';
            $data = $page->getName();
            $baseCode =  str_replace($tag, $data, $baseCode);
            
            $tag = '[PrePageName]';
            $data = $page->getPagePrefixName();
            $baseCode =  str_replace($tag, $data, $baseCode);
            
            // store labels in setup file 
            $tag = ModuleCreator::TAG_PAGE_LABELS;
            $data = $baseCode."\n\n".$pageLabelInsertTag."\n\n\n\n".$tag;
            $setupContents = str_replace($tag, $data, $setupContents);
        
        }
        
        // save app file
        file_put_contents( $setupFileName, $setupContents);
        
    }
    
    
    
    //************************************************************************
	/**
	 * function updatePageLabels
	 * <pre>
	 * Inserts the given page's labels into the tool setup routine.
	 * </pre>
	 * @param $page [OBJECT] The page to work with 
	 * @return [void]
	 */
    function updatePageLabels( $page ) 
    {
        
        // open tool_setup.php file
        $setupFileName = $this->values[ ModuleCreator::KEY_PATH_SETUP_NAME ];
        $setupContents = file_get_contents( $setupFileName );
        
        $pageLabelInsertTag = '/*[RAD_PAGE('.$page->getName().')_LABELS]*/';
                
        $labelList = $page->getPageLabels();
        
        $siteLanguageList = new LanguageList();
        
        // for each label
        $labelList->setFirst();
        while ( $label = $labelList->getNext() ) {
            
                // if label not already created
                if (!$label->isCreated() ) {
                
                    
                    $key = $label->getKey();
                    $text = $label->getLabel();
                    $text = str_replace( "'", "''", $text);
                    $text = str_replace( '"', '\"', $text);
                    
                    $lang = $label->getLanguageID();
                    $langKey = $siteLanguageList->getLanguageKeyByID( $lang );
                    
                    $labelMgr = '    $labelManager->addLabel( "'.$key.'", "'.$text.'", "'.$langKey.'" );';
                    
                    $tag = $pageLabelInsertTag;
                    $data = $labelMgr."\n".$tag;
                    $setupContents = str_replace($tag, $data, $setupContents);
                           
                    // Mark this label as having been created
                    $label->setCreated();
                    
                } // end if
                
            
        } // next label
        
        // save app file
        file_put_contents( $setupFileName, $setupContents);
            
    }  // end updatePageLabels()

    
    
    //************************************************************************
	/**
	 * function getCurrentDate
	 * <pre>
	 * Returns a commonly formatted Date of today..
	 * </pre>
	 * @return [STRING]
	 */
    function getCurrentDate() 
    {
        return date( 'd M Y');
    }  // end getCurrentDate()
    
    
    
    //************************************************************************
	/**
	 * function getFieldLabels
	 * <pre>
	 * Returns the label insertion sql for the given field.
	 * </pre>
	 * @return [STRING]
	 */
    function getFieldLabels( $field ) 
    {
        $returnValue = '';
        
        $fieldName = $field->getName();
        
        $label = $field->getTitle();
        if ($label != '') {
//            $label = str_replace( "'", "''", $label);
            $label = str_replace( '"', '\"', $label);
            $returnValue = '    $labelManager->addLabel( "[title_'.$fieldName.']", "'.$label.'", "en" );';
            
        }
        
        $label = $field->getFormLabel();
        if ($label != '') {
            
            if ( $returnValue != '') {
                $returnValue .= "\n";
            }
///            $label = str_replace( "'", "''", $label);
            $label = str_replace( '"', '\"', $label);
            $returnValue .= '    $labelManager->addLabel( "[formLabel_'.$fieldName.']", "'.$label.'", "en" );';
            
        }
        
        $label = $field->getExample();
        if ($label != '') {
            
            if ( $returnValue != '') {
                $returnValue .= "\n";
            }
//            $label = str_replace( "'", "''", $label);
            $label = str_replace( '"', '\"', $label);
            $returnValue .= '    $labelManager->addLabel( "[example_'.$fieldName.']", "'.$label.'", "en" );';

        }
        
        $label = $field->getError();
        if ($label != '') {
            
            if ( $returnValue != '') {
                $returnValue .= "\n";
            }
///            $label = str_replace( "'", "''", $label);
            $label = str_replace( '"', '\"', $label);
            $returnValue .= '    $labelManager->addLabel( "[error_'.$fieldName.']", "'.$label.'", "en" );';
            
        }
        
        if ( $returnValue != '') {
            $returnValue .= "\n";
        }
               
        return $returnValue;
        
    }  // end getFieldLabels()

    
    
    
    //************************************************************************
	/**
	 * function getSQLFieldEntry
	 * <pre>
	 * Returns a commonly formatted Date of today..
	 * </pre>
	 * @return [STRING]
	 */
    function getSQLFieldEntry( $field ) 
    {
        $dbType = $field->getDBType();
                    
        if ( !$field->isPrimaryKey() ) {
            if ($field->isNullable() ) {
                $nullable = '';
            } else {
                $nullable = ' NOT NULL ';
            }
            
            if ($field->getDefaultValue() == '') {
                $parts = explode( '(', $dbType);
                switch ($parts[0]) {
                
                    case 'int':
                        $defaultValue = "default '0'";
                        break;
                        
                    case 'text':
                    case 'varchar':
                        $defaultValue = "default ''";
                        break;
                        
                    case 'date':
                        $defaultValue = "default '0000-00-00'";
                        break;
                        
                    case 'time':
                        $defaultValue = "default '00:00:00'";
                        break;
                        
                    case 'datetime':
                        $defaultValue = "default '0000-00-00 00:00:00'";
                        break;
                        
                    case 'enum':
                        $pieces = explode(',', $parts[1]);
                        $firstOption = $pieces[0];
                        $defaultValue = "default ".$firstOption;
                        break;
                    
                    default:
                        echo 'getSQLFieldEntry()::can\'t find $dbType['.$dbType.'] in switch.<br><br>';
                        break;
                }
            } else {
                $defaultValue = "default '".$field->getDefaultValue()."'";
            }
        } else {
            $nullable = ' NOT NULL ';
            $defaultValue = 'auto_increment';
        } // end if ! primary key
        
        return '  '.$field->getName().' '.$dbType.$nullable.' '.$defaultValue.",\n";
    }  // end getSQLFieldEntry()
    
    
    
    //************************************************************************
	/**
	 * function replaceCommonTags
	 * <pre>
	 * Parses the given input string removing the most commonly used Tags.
	 * </pre>
	 * @param $currentData [STRING] containing the current file data.
	 * @return [STRING]
	 */
    function replaceCommonTags( $currentData ) 
    {
        // Replace Module Name
        $tagModuleName = ModuleCreator::TAG_MODULE_NAME;
        $moduleName = $this->values[ ModuleCreator::KEY_MODULE_NAME ];
        $currentData = str_replace($tagModuleName, $moduleName, $currentData );
        
        // Replace Creator Name
        $tagCreatorName = ModuleCreator::TAG_CREATOR_NAME;
        $creatorName = $this->values[ ModuleCreator::KEY_MODULE_CREATOR ];
        $currentData = str_replace($tagCreatorName, $creatorName, $currentData );
        
        // Replace Creation Date
        $tagCreationDate = ModuleCreator::TAG_CREATION_DATE;
        $creationDate = $this->getCurrentDate();
        $currentData = str_replace($tagCreationDate, $creationDate, $currentData );
            
        // Replace Template Path
        $tagTemplatePath = ModuleCreator::TAG_PATH_TEMPLATES;
        $path = ModuleCreator::PATH_TEMPLATES;
        $currentData = str_replace($tagTemplatePath, $path, $currentData );
        
        return $currentData;
        
    }  // end replaceCommonTags()
	
}

?>