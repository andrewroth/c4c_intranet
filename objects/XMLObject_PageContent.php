<?php
/**
 * @package AIobjects
 */
/**
 * class XMLObject_PageContent
 * <pre>
 * Written By:	Johnny Hausman
 * Date:    18 Aug '04
 *
 * This is a generic Page Content Object.  It handles the proper compilation
 * and packaging of the page's display output to be sent back to the calling
 * Page Object.
 *
 *</pre>
 */
abstract
class XMLObject_PageContent extends XMLObject {
// 		
//
//	CONSTANTS:

    /** const ROOT_NODE_PAGECONTENT Root NodeName for the Page Content XML  data. */
        const ROOT_NODE_PAGECONTENT = 'PageContent';
        
    /** const NODE_CSS    NodeName for the XML CSS data. */
        const NODE_CSS = 'styleList';
    
    /** const NODE_SCRIPT    NodeName for the XML SCRIPT data. */
        const NODE_SCRIPT = 'scripts';
        
    /** const NODE_BODYLIST    NodeName for the XML Body Tag data. */
        const NODE_BODYLIST = 'body';
        
    /** const NODE_NAVBAR    NodeName for the XML Navbar Tag data. */
        const NODE_NAVBAR = 'navBar';
        
    /** const ELEMENT_NAVBAR_MAIN    Element for the XML Navbar Main Menu data. */
//        const ELEMENT_NAVBAR_MAIN = 'menuMain';
        
    /** const ELEMENT_NAVBAR_SUB    Element for the XML Navbar Sub Menu data. */
//        const ELEMENT_NAVBAR_SUB = 'menuSub';
        
    /** const NODE_CONTENT    NodeName for the XML Content Tag data. */
        const NODE_CONTENT = 'content';
        
    /** const NODE_SIDEBAR    NodeName for the XML SideBar Content Tag data. */
        const NODE_SIDEBAR = 'sidebar';
        
    /** const ELEMENT_CSS    NodeName for the XML CSS data. */
        const ELEMENT_CSS = 'style';
        
    /** const ELEMENT_SCRIPT    NodeName for the XML Script data. */
        const ELEMENT_SCRIPT = 'script';
        
    /** const ELEMENT_PATH_ROOT  NodeName for the Path to the Root Directory. */
        const ELEMENT_PATH_ROOT = 'pathToRoot';
        
    /** const NODE_PAGE_TITLE    NodeName for the page's title. */
        const NODE_PAGE_TITLE = 'pageTitle';
        
    /** const NODE_WINDOW_TITLE    NodeName for the window's title. */
        const NODE_WINDOW_TITLE = 'windowTitle';
        
    /** const NODE_PAGE_CALLBACK    NodeName for the Page Callback string. */
        const NODE_PAGE_CALLBACK = 'pageCallBack';
        
    /** const NODE_HEADER_IMAGE    NodeName for the Header Image. */   
        const NODE_HEADER_IMAGE = 'headerImage';

//
//	VARIABLES:

    /** @var [STRING] The callback routine for this page (without module parameters). */
		protected $baseCallBack;
		
    /** @var [OBJECT] XML Object to store list of Body Tag attributes. */
		protected $bodyList;
		
    /** @var [OBJECT] XML Object to store list of CSS files. */
		protected $cssList;
		
    /** @var [OBJECT] DB access object. */
		protected $db;
		
    /** @var [OBJECT] Multilingual Labels Object. */
		protected $labels;
		
    /** @var [STRING] Path to the Root directory of this Module. */
		protected $moduleRootPath;
		
    /** @var [OBJECT] XML Object to store NavBar Data. */
		protected $navBar;
		
    /** @var [STRING] The whole callback routine for this page. */
		protected $pageCallBack;
		
    /** @var [OBJECT] An XML Object describing the Application's menu. */
		protected $pageMenu;
		
    /** @var [STRING] The outer most Template for use in displaying this page. */
		protected $pageTemplateFile;
		
    /** @var [STRING] Title of this page/application. */
		protected $pageTitle;
		
    /** @var [STRING] Path to the Root directory of the Site. */
		protected $pathToRoot;
		
    /** @var [OBJECT] XML Object to store list of Script files. */
		protected $scriptList;
		
    /** @var [OBJECT] Viewer object. */
		protected $viewer;
		
    /** @var [STRING] Title of this browser window. */
		protected $windowTitle;

    /** @var [STRING] The Page Header image */
        protected $pageHeaderImage;
		
		
    
//
//	CLASS CONSTRUCTOR
//

	//************************************************************************
	/**
	 * This is the class constructor for XMLObject_PageContent class
     *
	 * @param &$siteDB     [OBJECT]    The common DB link to the site DB.
	 * @param &$siteViewer [OBJECT]    The common viewer object.
	 * @param &$siteLabels [OBJECT]    A common label object for the page.
	 */
    function __construct( &$siteDB, &$siteViewer, &$siteLabels ) 
    {
	
        parent::__construct();
        
        $this->cssList = new XMLObject( XMLObject_PageContent::NODE_CSS );
        $this->scriptList = new XMLObject( XMLObject_PageContent::NODE_SCRIPT );
        $this->bodyList = new XMLObject( XMLObject_PageContent::NODE_BODYLIST );
        
        $this->db = $siteDB;
        $this->viewer = $siteViewer;
        $this->labels = $siteLabels;
        
        $this->setNodeName( XMLObject_PageContent::ROOT_NODE_PAGECONTENT );

        $this->pageTitle = '';
        $this->windowTitle = '';

        $this->baseCallBack = '';
        
        $this->pageMenu = new XMLObject_Menu();
        
        // Default the template info to the DEFAULT site template.
        $this->pageTemplateFile = PAGE_TEMPLATE_DEFAULT;
        
        $this->pageHeaderImage = PAGE_TEMPLATE_HEADER_IMAGE;
        
        $this->navBar = new RowManager_NavBarCacheManager();
        $this->loadCache();
        
        
	}
	
	

	//
	//	CLASS FUNCTIONS:
	
	
	
	//************************************************************************
	/** 
	 * function processData
	 * <pre>
	 * Provided function to allow an object to process it's data.
     * </pre>
     * @return [void]
	 */
    abstract
    function processData( );
    	
	
	
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
    function prepareDisplayData( );
	
	
	
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
        $this->addElement(XMLObject_PageContent::NODE_CONTENT, $content );	
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
        $this->scriptList->addElement(XMLObject_PageContent::ELEMENT_SCRIPT, $fullPathName );	
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
        $this->addElement(XMLObject_PageContent::NODE_SIDEBAR, $content );	
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
        $this->cssList->addElement(XMLObject_PageContent::ELEMENT_CSS, $fullPathName );	
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
        $this->addElement(  XMLObject_PageContent::NODE_NAVBAR,  $cacheData );
	   
	   // include body list as an element
	   $this->addXmlObject( $this->bodyList );
	   
	   // include Menu as an element
	   $this->addXmlObject( $this->pageMenu );
	   
	   // set the page's path to Root
	   $this->addElement(  XMLObject_PageContent::ELEMENT_PATH_ROOT,  $this->pathToRoot );
	   
	   // set the page's title
	   $this->addElement(  XMLObject_PageContent::NODE_PAGE_TITLE,  $this->pageTitle );
	   
	   // set the page's title
	   $this->addElement(  XMLObject_PageContent::NODE_WINDOW_TITLE,  $this->windowTitle );
	   
	   // set the page's Header Image
	   $this->addElement(  XMLObject_PageContent::NODE_HEADER_IMAGE,  $this->pageHeaderImage );

	   
	   // set the page's pageCallBack value
	   $this->addElement(  XMLObject_PageContent::NODE_PAGE_CALLBACK,  $this->pageCallBack );

	   // Now call the parent getXML to return the XML
	   $returnValue = parent::getXML($isHeaderIncluded, $rootNodeName);
	   
	   // Now restore the values array to their original values.
	   $this->xmlValues = $valuesCopy;
	   
	   return $returnValue;
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
	 * function loadData
	 * <pre>
	 * Provided function to allow object to load it's data.
     * </pre>
     * @return [void]
	 */
    abstract
    function loadData( );
	
	
	
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
	   $this->pageCallBack =   $callBack;
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
	   $this->pageHeaderImage =   $image;
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
	
	   $this->pageTitle =  $title ;

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
	
	   $this->windowTitle =  $title ;

	}
	

}

?>