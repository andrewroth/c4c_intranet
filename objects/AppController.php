<?php
/**
 * @package AIobjects
 */
/**
 * class AppController
 * <pre>
 * Written By:	Johnny Hausman
 * Date:    31 Jan '06
 *
 * This is a generic Application Controller Object.  It handles the proper 
 * compilation and packaging of the page's display output to be sent back to 
 * the calling Page Object.
 *
 *</pre>
 */
abstract
class AppController {
// 		
//
//	CONSTANTS:

    /** const ROOT_KEY_PAGECONTENT Root NodeName for the Page Content XML  data. */
        const ROOT_KEY_PAGECONTENT = 'AppController';
        
        
    /** const KEY_BODYLIST    NodeName for the XML Body Tag data. */
        const KEY_BODYLIST = 'body';
        
    /** const KEY_CONTENT    NodeName for the XML Content Tag data. */
        const KEY_CONTENT = 'content';
        
    /** const KEY_CSS    NodeName for the XML CSS data. */
        const KEY_CSS = 'style';
        
    /** const KEY_HEADER_IMAGE    NodeName for the Header Image. */   
        const KEY_HEADER_IMAGE = 'headerImage';
        
    /** const KEY_NAVBAR    NodeName for the XML Navbar Tag data. */
        const KEY_NAVBAR = 'navBar';
        
    /** const KEY_PAGE_CALLBACK    NodeName for the Page Callback string. */
        const KEY_PAGE_CALLBACK = 'pageCallBack';
        
    /** const KEY_PAGE_TITLE    NodeName for the page's title. */
        const KEY_PAGE_TITLE = 'pageTitle';
        
    /** const KEY_PATH_ROOT  NodeName for the Path to the Root Directory. */
        const KEY_PATH_ROOT = 'pathToRoot';
        
    /** const KEY_SIDEBAR    NodeName for the XML SideBar Content Tag data. */
        const KEY_SIDEBAR = 'sidebar';
        
    /** const KEY_SCRIPT    NodeName for the XML Script data. */
        const KEY_SCRIPT = 'script';
        
    /** const KEY_WINDOW_TITLE    NodeName for the window's title. */
        const KEY_WINDOW_TITLE = 'windowTitle';
        
    /** const KEY_ZONE_MAIN    The HTML data for the Main Content area. */
        const KEY_ZONE_MAIN = 'zoneMain';
        
    /** const KEY_ZONE_SIDEBAR    The HTML data for the Sidebar area. */
        const KEY_ZONE_SIDEBAR = 'zoneSideBar';
        
    /** const FORM_KEY_PROCESS    The Name of the Process field for forms. */
        const FORM_KEY_PROCESS = 'Process';
        
    /** const QS_SORTBY    The QueryString SortBy parameter. */
        const QS_SORTBY = "modSort";

//
//	VARIABLES:
//
//  AppController specific variables:

    /** @var [STRING] The callback routine for this page (without module parameters). */
		protected $baseCallBack;

    /** @var [OBJECT] A DB object available to be used by your application. */
		protected $db;

    /** @var [BOOL] indicates if there was a form submission to process. */
		protected $isFormSubmission;

    /** @var [OBJECT] Labels for your Application. */
		protected $labels;
		
    /** @var [ARRAY] A list of all the css files to include in this page. */
		protected $listCSS;
		
    /** @var [ARRAY] A list of all the scripts to include in this page. */
		protected $listScripts;

    /** @var [ARRAY] The data to display for this page. */
		protected $pageContent;
		
    /** @var [STRING] The name of the page template file to use for 
        displaying content. */
		protected $pageTemplateFile;

    /** @var [OBJECT] An object to track info about the viewer of the page. */
		protected $viewer;

    /** @var [ARRAY] List of HTML content that is divided up into "zones". */
		protected $zonedContent;
	
//
//	
// Child specific variables:
		
    /** @var [ARRAY] holds all the application specific variables. */
    protected $stateVariables;
    
    /** protected $pageDisplay [OBJECT] The display object for the page. */
    protected $pageDisplay;
    
//
//	CLASS CONSTRUCTOR
//

	//************************************************************************
	/**
	 * This is the class constructor for XMLObject_AppController class
     *
	 * @param &$siteDB     [OBJECT]    The common DB link to the site DB.
	 * @param &$siteViewer [OBJECT]    The common viewer object.
	 * @param &$siteLabels [OBJECT]    A common label object for the page.
	 */
    function __construct( &$siteDB, &$siteViewer, &$siteLabels ) 
    {
                
        $this->db = $siteDB;
        $this->viewer = $siteViewer;
        $this->labels = $siteLabels;


        $this->pageContent[ AppController::KEY_PAGE_TITLE ] = '';
        $this->pageContent[ AppController::KEY_WINDOW_TITLE ] = '';
        
        
        $this->zonedContent = array();
        
        
        $this->baseCallBack = '';
        
        $this->pageMenu = array();
        
        // Default the template info to the DEFAULT site template.
        $this->pageTemplateFile = PAGE_TEMPLATE_DEFAULT_ARRAY;
        
        $this->pageContent[ AppController::KEY_HEADER_IMAGE ] = PAGE_TEMPLATE_HEADER_IMAGE;
        
//        $this->navBar = new RowManager_NavBarCacheManager();
//        $this->loadCache();
        
        $this->isFormSubmission = false;
        $this->stateVariables = array();
	}
	
	

	//
	//	CLASS FUNCTIONS:
	// 
	//  These Abstract functions are required by any child classes:
	
	
	
	//************************************************************************
	/** 
	 * function loadData
	 * <pre>
	 * Provided function to allow object to load it's data.
     * </pre>
     * @return [void]
	 */
    function loadData( )
    {
        // Load the SortBy parameter
        $sortbyKey = AppController::QS_SORTBY;
        $this->stateVariables[ $sortbyKey ] = 
                $this->getQSValue( $sortbyKey, '' );
                
                
        
        /*
         * Check to see if there was a form submission that needs processing
         */
        if (    (isset( $_REQUEST[ AppController::FORM_KEY_PROCESS ] )) 
             || (isset( $_REQUEST[ PerlFileUpload::DEF_QSPARAM_SID ] ))  ) {
            
            $this->isFormSubmission = true;
        }
        
        // if there was a form submission, then tell pageDisplay object to 
        // load form data.
        if ( $this->isFormSubmission ) {
        
            $this->pageDisplay->loadFromForm();
        }
    }
	
	
	
	//************************************************************************
	/** 
	 * function processData
	 * <pre>
	 * Provided function to allow an object to process it's data.
     * </pre>
     * @return [void]
	 */
    abstract
    function processData( );//{}
    	
	
	
	//************************************************************************
	/** 
	 * function prepareDisplayData
	 * <pre>
	 * Provided function to allow an object to prepare it's data for 
	 * displaying (actually done int he Page Object).
	 * </pre>
	 * @return [void]
	 */
    abstract
    function prepareDisplayData( );//{}
	
	

//
//   These are the class methods: 
//	
	
	
	
	//************************************************************************
	/** 
	 * function addContent
	 * <pre>
	 * Stores the content data entry 
	 * </pre>
	 * @param $content [STRING] HTML data for the content to display.
	 * @return [void]
	 */
    function addContent( $content ) 
    {
        $this->zonedContent[ AppController::KEY_ZONE_MAIN ] = $content;	
	}
	
	
	
	//************************************************************************
	/** 
	 * function addScript
	 * <pre>
	 * Creates a Script entry 
	 * </pre>
	 * @param $name [STRING] The name of the Script file.
	 * @param $path [STRING] The path to the Script file.
	 * @return [void]
	 */
    function addScript( $name, $path=SITE_PATH_SCRIPTS ) 
    {
	
        $fullPathName = $path.$name;
        $this->listScripts[]= $fullPathName;	
	}
	
	
	
	//************************************************************************
	/** 
	 * function addSideBarContent
	 * <pre>
	 * Stores the content data entry as the SideBar Content 
	 * </pre>
	 * @param $content [STRING] HTML data for the content to display.
	 * @return [void]
	 */
    function addSideBarContent( $content ) 
    {
        $this->zonedContent[ AppController::KEY_ZONE_SIDEBAR ] = $content;	
	}
	
	
	
	//************************************************************************
	/** 
	 * function addStyleSheet
	 * <pre>
	 * Creates a StyleSheet entry 
	 * </pre>
	 * @param $name [STRING] The name of the StyleSheet.
	 * @param $path [STRING] The path to the StyleSheet (from Root dir).
	 * @return [void]
	 */
    function addStyleSheet( $name, $path=SITE_PATH_STYLESHEETS ) 
    {
        $fullPathName = $path.$name;
        $this->listCSS[] = $fullPathName;	
	}
	
	
	
	//************************************************************************
	/** 
	 * function getPageContent
	 * <pre>
	 * Returns the pageContent array for use with the display templates. 
	 * </pre>
	 * @return [ARRAY]
	 */
    function getPageContent() 
    {
        $this->pageContent[ AppController::KEY_CSS ]     = $this->listCSS;
        $this->pageContent[ AppController::KEY_SCRIPT ]  = $this->listScripts;
        $this->pageContent[ AppController::KEY_CONTENT ] = $this->zonedContent;
        return $this->pageContent;
	}
	
	
	
	//************************************************************************
    /**
     * function getCallBack
     * <pre>
     * This routine parses through all the given stateVariables and produces
     * a link with these values on the querystring.
     * </pre>
     * @param $currentValues [ARRAY](optional) array of stateVariable info
     * @param $endingFieldAssignment [STRING](optional) Name of field to have
     * as ending field assignment.
     * @return [STRING]
     */
    function getCallBack( $currentValues=null, $endingFieldAssignment='' ) {
       
        if (is_null( $currentValues ) ) {
            $currentValues = $this->stateVariables;
        }

        // compile every stateVariable that has a value set 
        $queryString = '';
        foreach( $currentValues as $key=>$value) {
        
            // don't include paramters used for endingFieldAssignment
            if ( ($value != '' ) && ($endingFieldAssignment != $key)) {
            
                // add it to the QueryString
                $queryString.= '&'.$key.'='.$value;
            }
        }
        
        // Now piece together the callback string
        $callBack = $this->baseCallBack.$queryString;
        
        // if an ending Field assignment is requested then
        if ($endingFieldAssignment != '' ) {
                    
            // add requested ending field assignment
            $callBack.='&'.$endingFieldAssignment.'=';
        }
        
        // return the Call Back Link
        return $callBack;
    
    }
	
	
	
	//************************************************************************
	/** 
	 * function getPageTemplate
	 * <pre>
	 * Returns the template path/filename for this page. 
	 * </pre>
	 * @return [STRING]
	 */
    function getPageTemplate() 
    {
	   return $this->pageTemplateFile;
	}
	
	
	
	//************************************************************************
	/** 
	 * function getQSValue
	 * <pre>
	 * Gets a requested Querystring (QS) value.
	 * </pre>
	 * @param $qsItemName [STRING] The QS variable name.
	 * @param $defaultValue [STRING] If item not found, return this value.
	 * @return [STRING] 
     */
    function getQSValue( $qsItemName, $defaultValue ) 
    {
	
        if ( isset( $_REQUEST[ $qsItemName ] ) == true ) {
            $returnValue = $_REQUEST[ $qsItemName ];
        } else {
            $returnValue = $defaultValue;
        }
        
        return $returnValue;
	}
	
	
	
	//************************************************************************
	/** 
	 * function getXML
	 * <pre>
	 * Generates an XML document from the object's Values array.
	 * </pre>
	 * @param $isHeaderIncluded [BOOL] Determines if we include the 
	 * '<?xml version="1.0"?>' header.
	 * @param $rootNodeName [STRING] The XML root node name.
	 * @return [STRING] Returns an XML formatted string.
	 */
    function getXML( $isHeaderIncluded=true, $rootNodeName='' ) 
	{
	
	   // Prepare This object to generate it's XML output.
	   
	   // first store this objects values in a copy.
	   $valuesCopy = $this->xmlValues;
	   
	   // include css list as an element
	   $this->addXmlObject( $this->cssList );
	   
	   // include script list as an element
	   $this->addXmlObject( $this->scriptList );
	   
	   // include navbar data as an element
//	   $this->addXmlObject( $this->navBar );
        $cacheData = $this->navBar->getCache();
        $cacheData = str_replace( $this->navBar->getPathToRootTag(), $this->pathToRoot, $cacheData);
        $this->addElement(  XMLObject_AppController::KEY_NAVBAR,  $cacheData );
	   
	   // include body list as an element
	   $this->addXmlObject( $this->bodyList );
	   
	   // include Menu as an element
	   $this->addXmlObject( $this->pageMenu );
	   
	   // set the page's path to Root
	   $this->addElement(  XMLObject_AppController::KEY_PATH_ROOT,  $this->pathToRoot );
	   
	   // set the page's title
	   $this->addElement(  XMLObject_AppController::KEY_PAGE_TITLE,  $this->pageTitle );
	   
	   // set the page's title
	   $this->addElement(  XMLObject_AppController::KEY_WINDOW_TITLE,  $this->windowTitle );
	   
	   // set the page's Header Image
	   $this->addElement(  XMLObject_AppController::KEY_HEADER_IMAGE,  $this->pageHeaderImage );

	   
	   // set the page's pageCallBack value
	   $this->addElement(  XMLObject_AppController::KEY_PAGE_CALLBACK,  $this->pageCallBack );

	   // Now call the parent getXML to return the XML
	   $returnValue = parent::getXML($isHeaderIncluded, $rootNodeName);
	   
	   // Now restore the values array to their original values.
	   $this->xmlValues = $valuesCopy;
	   
	   return $returnValue;
	}
	
	
	
	//************************************************************************
	/** 
	 * function isFormSubmission
	 * <pre>
	 * Returns wether or not this was a form submission needing processing. 
	 * </pre>
	 * @return [BOOL]
	 */
    function isFormSubmission( ) 
    {
        return $this->isFormSubmission;	
	}
	
	
	
	//************************************************************************
	/** 
	 * function loadCache
	 * <pre>
	 * Prepares the cache data for the current viewer. 
	 * </pre>
	 * @return [void]
	 */
    function loadCache( ) 
    {
        $viewerID = $this->viewer->getID();
        $languageID = $this->viewer->getLanguageID();
        if (!$this->navBar->loadByViewerID( $viewerID, $languageID )) {
            $this->navBar->createCache( $this->viewer );
        }	
	}
	
	
	
	//************************************************************************
	/** 
	 * function setBaseCallBack
	 * <pre>
	 * Sets the callback string to return to the current page/module. 
	 * </pre>
	 * @param $path [STRING] The Call Back string.
	 * @return [void]
	 */
    function setBaseCallBack( $callBack ) 
    {
	   $this->baseCallBack =   $callBack;
	}
	
	
	
	//************************************************************************
	/** 
	 * function setModuleRootPath
	 * <pre>
	 * Sets the path from the Site's root directory to the module's root 
	 * directory. 
	 * </pre>
	 * @param $path [STRING] The path to the Script file.
	 * @return [void]
	 */
    function setModuleRootPath( $path ) 
    {
	
	   // in general, everything should be running from the root of the site.
	   // however, in cases where this isn't the case, we do a little checking
	   // here to make sure our path is properly centered from the root.
	   $pathExt = '';
	   for( $indx=0; $indx < 20 && !file_exists( $pathExt.$path); $indx++) {
	       $pathExt .= '../';
	   }
	   $this->moduleRootPath =  $pathExt.$path ;
	   $this->pathToRoot = $pathExt;
	   $this->pageContent[ AppController::KEY_PATH_ROOT ] = $pathExt;

	}
	
	
	
	//************************************************************************
	/** 
	 * function setPageCallBack
	 * <pre>
	 * Sets the callback string to return to the current page/module. 
	 * </pre>
	 * @param $path [STRING] The Call Back string.
	 * @return [void]
	 */
    function setPageCallBack( $callBack ) 
    {
	   $this->pageContent[ AppController::KEY_PAGE_CALLBACK ] =   $callBack;
	}
	
	
	
	//************************************************************************
	/** 
	 * function setPageHeaderImage
	 * <pre>
	 * Set the page's HeaderImage. 
	 * </pre>
	 * @param $image [STRING] The path/from/root/and/name of the image.
	 * @return [void]
	 */
    function setPageHeaderImage( $image ) 
    {
	   $this->pageContent[ AppController::KEY_HEADER_IMAGE ] =   $image;
	}
	
	
	
	//************************************************************************
	/** 
	 * function setPageTemplate
	 * <pre>
	 * Set the template path/filename for this page. 
	 * </pre>
	 * @param $template [STRING] The template file.
	 * @return [void]
	 */
    function setPageTemplate( $template ) 
    {
	   $this->pageTemplateFile =  $template;
	}
	
	
	
	//************************************************************************
	/** 
	 * function setPageTitle
	 * <pre>
	 * Set the page/application title. 
	 * </pre>
	 * @param $title [STRING] The page title.
	 * @return [void]
	 */
    function setPageTitle( $title ) 
    {
	
	   $this->pageContent[ AppController::KEY_PAGE_TITLE ] =  $title ;

	}
	
	
	
    //************************************************************************
	/** 
	 * function setWindowTitle
	 * <pre>
	 * Set the browser's window title. 
	 * </pre>
	 * @param $title [STRING] The Window title.
	 * @return [void]
	 */
    function setWindowTitle( $title ) 
    {
	
	   $this->pageContent[ 'windowTitle' ] =  $title ;

	}
	

}

?>