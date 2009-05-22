<?php
/**
 * @package AIobjects	
 */
/**
 * class Page
 * <pre>
 * Written By:	Johnny Hausman
 * Date:    19 Aug '04
 *
 * This class handles Page creation, control, and display back to the client.  
 * It is intended to assume control of the Page's operation and will in turn 
 * call the Calling Page's LoadData(), ProcessData() and DisplayData() routines.
 *
 * This class also handles the operation and control of some DB tables:
 * page_modules.
 * </pre>
 */
class  Page extends SiteObject {
// 
//	CONSTANTS:
    /** The Querystring ID of the Page Content Module. */
        const QS_MODULE = 'p_Mod';
        
    /** The Querystring ID of the requested Page Language. */
        const QS_LANGUAGE = 'p_Lang';
        
    
//
//	VARIABLES:

    /** @var [OBJECT] The data related to the Viewer of the page. */
        protected $viewer;
        
    /** @var [OBJECT] The Page DB object. */
        protected $db;
        
    /** @var [OBJECT] A common labels object. */
        protected $labels;
        
    /** @var [STRING] The filename of the template to use. */
        protected $pageTemplate;
        
    /** @var [STRING] The path to the file of the template to use. */
        protected $pageTemplatePath;
        
    /** @var [STRING] The path to the root directory of the site. */
        protected $pagePathToRoot;
        
    /** @var [OBJECT] A moduleManager to work with a given system module. */
        protected $moduleManager;
        
    /** @var [STRING] The currently requested Module. */
        protected $moduleKey;
        
	
//
//	CLASS CONSTRUCTOR
//

    //************************************************************************
    /**
     * This is the class constructor for class Page
     *
     * @param $templateFile [PAGE_TEMPLATE_DEFAULT]
     */
    function __construct( $templateFile=PAGE_TEMPLATE_DEFAULT ) 
    {
		
		parent::__construct();
		
		// Turn on Debugging while designing ...
		//$this->debugEnable();
		
		// NOTE: Setting the pageTemplateFile this way is being 
		//    depreciated for having it set via the pageContent Object.
		//    This will dissappear soon ...
		//
		// Split the Template file data into it's path & File parts.
		$this->parseTemplateData( $templateFile );
		        
        $this->debug( 'pageTemplatePath=['.$this->pageTemplatePath.']<br>' );
        $this->debug( 'pageTemplate=['.$this->pageTemplate.']<br>' );
	
	}
	
	

	//CLASS FUNCTIONS:
    //************************************************************************
    /**
     * function classFunction
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
    function classFunction($param1, $param2) 
    {
        // CODE
    }	
	
	
	
	//************************************************************************
	/**
	 * function Redirect
	 * @param $Destination [STRING]
	 */
    function Redirect( $Destination) 
    {
	
		header( "Location:".$Destination );
		exit;
	}
	
	
	//************************************************************************
	/** 
	 * function start
	 * Takes control of the application and displays the page.
     * <pre><code>
     *   Begin Output Buffering (? or keep in includes file)
     *   create a new viewer
     *   get requested PageContent Module Name
     *   if none provided then set default to PAGE_MODULE_DEFAULT
     *   if viewer is NOT authenticated then
     *      Store requested PageContent Module & QueryString info
     *      set current PageContent Module to Login    
     *   end if
     *   
     *   Load Module particulars from DB
     *   Create new instance of desired PageContent Module
     *   Setup any desired Module Parameters
     *   Load PageContent information
     *   Path to PageContent Module Root
     *       CSS Styles
     *       Javascripts
     *       Database Object
     *       Labels Object
     *       Viewer Object
     *   Call PageContent LoadData()
     *   Call PageContent ProcessData()
     *   Call PageContent PrepareDisplay()
     *   Get Page Content XML
     *   Open up Template
     *   Set PageContent information
     *   Get Template HTML
     *   display HTML
     *   flush Output Buffer
     * </code></pre>	
     * @return [void]
	 */
	function start($validate = true) 
	{
	
	    // Begin Output Buffering (? or keep in includes file)
	    ob_start();
	    
	    /*
         *  Setup Site DB.
         */
	    // Create a new DB connection
	    $this->db = new Database_Site(SITE_DB_NAME, SITE_DB_PATH, SITE_DB_USER, SITE_DB_PWORD); 
	    
	    
	    /*
         *  Setup viewer information.
         */
        // create a new viewer
        $this->viewer = new Viewer();    
        
        // if there was a Language Change requested on current page:
        if ( isset( $_REQUEST[ Page::QS_LANGUAGE ] ) == true ) {
            // store this in the user's session
            $_SESSION[ Page::QS_LANGUAGE ] = $_REQUEST[ Page::QS_LANGUAGE ];
        }
        
        // if there is a current Language setting in the stored session info
        if (isset( $_SESSION[ Page::QS_LANGUAGE ] ) ) {
        
            // update viewer's desired language ID to given value.
            $this->viewer->setLanguageID( $_SESSION[ Page::QS_LANGUAGE ] );
        }
        
        
        
        /*
         *  Setup Site Label data.
         */
        // Create a new Label object
        $this->labels = new XMLObject_MultilingualManager($this->viewer->getLanguageID() );
        
        
        /*
         *  Decide on which AppController Object to Load
         */
        // get requested AppController Module Name
        // if none provided then set default to PAGE_MODULE_DEFAULT
        if ( isset( $_REQUEST[ Page::QS_MODULE ] ) == true ) {
            $this->moduleKey = $_REQUEST[ Page::QS_MODULE ];
        } else {
            $this->moduleKey = PAGE_MODULE_DEFAULT;
        }
        
      if ($validate == true)		// added $validate and this condition on October 3, 2007  (HSMIT)
      {
        
			// if viewer is NOT authenticated then
			if ( !($this->viewer->isAuthenticated() ) ) {
	        
	            // if the requested page wasn't PAGE_MODULE_LOGIN then
	            if ( $this->moduleKey != PAGE_MODULE_LOGIN) {
	            
	                // Store requested PageContent Module & QueryString info in Session CallBack
	                // NOTE: I use SERVER_ADDR + SCRIPT_URL instead of SCRIPT_URI 
	                // since mac web servers tend to use rendezvous names which 
	                // means nothing on Windows systems ...
	                $baseCallBack = $this->getBaseURL(). '?' .$_SERVER['QUERY_STRING'];
	                $_SESSION[ SESSION_ID_CALLBACK ] = $baseCallBack;
	            
	                $this->debug( 'Viewer NOT Authenticated.<br>Storing baseCallBack=['.$baseCallBack.']<br>' );
	            
	                // set current PageContent Module to Login
	                $this->moduleKey = PAGE_MODULE_LOGIN;
	                
	            } // end if moduleKey != PAGE_MODULE_LOGIN
	            
	        } // end if
	        
        }
        
        $this->debug( 'moduleKey=['.$this->moduleKey.']<br>' );
        
        // Load Module particulars from DB
	    $this->moduleManager = new RowManager_siteModuleManager();
	    $this->moduleManager->loadByKey( $this->moduleKey );
	    if ( !$this->moduleManager->isLoaded() ) {
	    
	       // Couldn't find requested ModuleKey so load Default
	       $this->moduleManager->loadByKey( PAGE_MODULE_DEFAULT );
	    }
	    
	    
        /*
         * Create new instance of desired Module's AppController Object
         * 
         * Note: the AppController is generating the Content for the page.
         *       it will be referred to as the pageContent variable.
         */
        // 1) Get path and name of Module's include file
        $path = $this->moduleManager->getPath();
        $includeFile = $this->moduleManager->getIncludeFile();
        
        
        // 2) include the Module's Include file ( if it exists )
        $this->debug( 'moduleIncludeFile=['.$path.$includeFile.']<br>' );
        if ( file_exists( $path.$includeFile ) ) {
            $this->includeFile( $path.$includeFile );
        }
         
        // 3) include the Module's Application File
        $moduleFile = $this->moduleManager->getApplicationFile();
        $this->includeFile( $path.$moduleFile );
        
        // 4) create a new instance of the module application as $pageContent
        $moduleClassName = $this->moduleManager->getName();
        
        $pageContent = new $moduleClassName( $this->db, $this->viewer, $this->labels );
        
//         $this->debugDumpArray( $pageContent );
        
        
        /*
         * Setup any desired Module Parameters
         *   NOTE: the ModuleParameters should be in the form of:
         *         Key1=Val1;Key2=Val2;...;KeyN=ValN 
         */
        $parameterList = $this->moduleManager->getParameters();
        
        if (( !is_null( $parameterList )) && ($parameterList != '') ) {
        
            // Break into array of KEY=VAL statements
            $parameterArray = explode( ';', $parameterList );
            
            // for each set of KEY=VAL statements ...
            for ($paramIndx=0; $paramIndx < count( $parameterArray); $paramIndx++) {
            
                // Seperate the KEY and VALUE
                $paramKeyVal = explode( '=', $parameterArray[ $paramIndx ]);
                
                // Store Key & Val in $_REQUEST array
                // $_REQUEST[ KEY ] = VALUE;
                $_REQUEST[ $paramKeyVal[0] ] = $paramKeyVal[1];
            }
        }
     
     
     
        /*
         ***
         *** Loading PageContent information
         ***
         */
        
        //     Path to PageContent Module Root
        $pageContent->setModuleRootPath( $path );
        
        /*
         *     Save Page CallBack string.  This value is primarily used in
         *      the language Menu switching link.  Here we need to make sure
         *      the languageID link isn't included.
         */
        $queryString = '';
        $rawQueryString = $_SERVER['QUERY_STRING'];
        
        // for each set of query string values
        $queryStringList = explode( '&', $rawQueryString);
        for($indx = 0; $indx < count($queryStringList); $indx++) {
        
            // if querystring is not the Language Switch Key
            $keyValue = explode( '=', $queryStringList[ $indx ] );
            if ($keyValue[0] != Page::QS_LANGUAGE) {
            
                // add the query string entry
                if ($queryString != '') {
                    $queryString .= '&';
                }
                $queryString .= $queryStringList[ $indx ];
            }
        }
        
        // put together the desired page call back
        $pageCallBack = $this->getBaseURL().'?'.$queryString;
        $pageContent->setPageCallBack( $pageCallBack );
        
        
        /*
         *     Save Base CallBack string to return to this page/module.
         *     This value is used for the PageObject's getCallBack() function.
         *     
         *     NOTE: callBack=http://URL/here/base_page.php?p_Mod=[ModuleKey]
         *
         *     NOTE: in the case of the Logout Module, we want the baseCallBack
         *     to be the Login module, not Logout module...
         */
        $baseCallBack = $this->getBaseURL().'?'.Page::QS_MODULE.'='.$this->moduleKey;
        $pageContent->setBaseCallBack( $baseCallBack );
        
        //     CSS Styles
        //         Adding default site css file
        $pageContent->addStyleSheet( 'site.css' );
        
        //     Javascripts
        //        These are some of the standard scripts ...
        $pageContent->addScript( 'GoogleAnalytics1.js' );
        $pageContent->addScript( 'GoogleAnalytics2.js' );
        $pageContent->addScript( 'milonic_src.jsp' );
        $pageContent->addScript( 'menu_data.jsp' );
        $pageContent->addScript( 'MM_swapImage.jsp' );
        $pageContent->addScript( 'MM_preloadImages.jsp' );
        $pageContent->addScript( 'MM_findObj.jsp' );
        
        
        
        //$this->debug( $pageContent->getXML() );

        // Call PageContent LoadData()
        $pageContent->loadData();
        
        // Call PageContent ProcessData()
        $pageContent->processData();
        
        // Call PageContent PrepareDisplay()
        $pageContent->prepareDisplayData();
        
        // Now get the Template requested by the PageContent object
        $templateFile = $pageContent->getPageTemplate();
        $this->parseTemplateData( $templateFile );

        // Open up Template
        $template = new Template( $this->pageTemplatePath );
        
        // NOTE: early versions of the framework used XML as the data
        //       transfer medium to the templates. Newer versions pass 
        //       the information using arrays
        //
        // if this is a XMLObject then use XML method ...
        if ( is_a( $pageContent, 'XMLObject_PageContent') ) {
        
            // Get Page Content XML
            $pageContentXML = $pageContent->getXML();	
            
            // Set PageContent information
            $template->setXML( 'page', $pageContentXML);
            
        } else {
        
            // Get Page Content XML
            $pageContentData = $pageContent->getPageContent();	
            
            // Set PageContent information
            $template->set( 'page', $pageContentData);
        
        }
		
		$template->set('userID', $this->viewer->getUserID());
		
		//// NEW CODE
		
		/*$gcxConnexionBar = "";
		
        phpCAS::setDebug();
        
        // initialize phpCAS
        phpCAS::client(CAS_VERSION_2_0,SITE_CAS_HOSTNAME,SITE_CAS_PORT,SITE_CAS_PATH);
        
        // no SSL validation for the CAS server
        phpCAS::setNoCasServerValidation();
        
        // check CAS authentication
        $auth = phpCAS::checkAuthentication();
		
		if ( $auth )
		{
		  $gcxConnexionBar = "GCX ConneXion Bar will go here... RM2 isAuth = true";
		  $service = 'https://www.mygcx.org/Public/module/omnibar/omnibar'; 
		  phpCAS::serviceWeb($service,$err_code,$output); 
		  preg_match('/<reportdata>(.*)<\\/reportdata>/', $output, $matches); 
		  $gcxConnexionBar = $matches[1]; 

		}
		else
		{
		  $gcxConnexionBar = "NOT authenticated";
		}
		
		$template->set('GCX_ConnexionBar', $gcxConnexionBar);
		
		//// END NEW CODE*/
        
        // Get Template HTML
        // display HTML
        echo $template->fetch( $this->pageTemplate );


        // flush Output Buffer
		ob_end_flush();
	}
	
	
	
	//************************************************************************
    /** 
     * function findPathExtension
     *
     * This function attempts to find the proper path to root to load the given file.
     *
     * <pre><code>
     * Initialize the new pathFile to the given value.
     * Attempt to find proper directory from current page to Root ... (quit after 5 attempts)
     * if file exists then 
     *    include file
     *    return success
     * else
     *    die with message about not finding file.
     * end if
     * </code></pre>
     * @param $file [STRING] The path to the file you want to find. 
     *
     * @return [STRING] The path to the root directory that allows you to find this file. 
     */
    function findPathExtension( $file ) 
    {
    
        $pathFile = $file;
        $extension = '';
            
        // Attempt to find proper directory from current page to Root ...
        $numAttempts = 0;
        while ( (!file_exists($extension.$pathFile)) && ( $numAttempts < 5) ) {
            
            $extension = '..'.SITE_PATH_SLASH.$extension;
            $numAttempts++; 
        }
        
        return $extension;
    }
	
	
	
	//************************************************************************
    /** 
     * function includeFile
     *
     * This function takes some of the file path guesswork out of including files.
     *
     * <pre><code>
     *   set pathFile as the proper path+FileName.
     *   if file exists & is not a Directory then 
     *       include file
     *       return success
     *   else
     *       return failure.
     *   end if
     * </code></pre>
     * @param $file [STRING] The path to the file you want to include.  The path
     * should be from the ROOT of the site.
     *
     * @return [BOOL] True if we were able to find & load the given file. False otherwise. 
     */
    function includeFile( $file ) 
    {

        $pathFile = Page::findPathExtension( $file ).$file;
            
        //check if file exists & is not a Directory then
        if ((file_exists($pathFile)) && (!is_dir($pathFile))) {
        
            // include File
            // return Success
            $returnValue = include_once($pathFile);
            
        } else {
        // else
            
            // return failure
            $returnValue = false;
        }
        
        return $returnValue;
    } // end includeFile()
    
    

    //************************************************************************
    /**
     * function parseTemplateData
     * <pre>
     * This function breakes up the given template data into it's path and
     * filename and stores them in the proper pageTemplatePath & pageTemplate
     * variables.
     * </pre>
     * <pre><code>
     *  Find any path extension to get us to find the templateFile
     *  break up $templateFile into Path & File name
     *  
     * </code></pre>
     * @param $templateFile [STRING] path + file name to desired Template File
     * @return [void]
     */
    function parseTemplateData($templateFile) 
    {    
        // Find any path extension to get us to find the templateFile
		$pathExtension = $this->findPathExtension( $templateFile );
		
        // break up $templateFile into Path & File name
		$path = '';
		$sections = explode( SITE_PATH_SLASH, $templateFile);
		for ($indx=0; $indx < (count($sections) -1); $indx++) {
            if ($path == '') {
              $path = $sections[ $indx ];
            }
            else {
              $path .= SITE_PATH_SLASH.$sections[$indx];
            }
		}
		
		$this->pageTemplatePath = $pathExtension.$path.'/';
		$this->pageTemplate = $sections[ $indx ];
		$this->pagePathToRoot = $pathExtension;

    }	
    
    
    
    //************************************************************************
    /**
     * function getBaseURL
     * <pre>
     * This function returns the basic URL for the site.  This will be compiled
     * from the server variables and returned as the proper link.
     * </pre>
     * @return [STRING]
     */
    function getBaseURL() 
    {
        // NOTE: this uses the SITE_KEY_SERVER_URL defined key to pull the path
        // to the called page.  This server key may be different on different
        // systems.
        $baseURL = SITE_SERVER_HTTP.$_SERVER['HTTP_HOST'].$_SERVER[ SITE_KEY_SERVER_URL ];

        return $baseURL;
        
    } // end getBaseURL()
    
    
    
    //************************************************************************
    /**
     * function getLoginURL
     * <pre>
     * This function returns the link to the Login Page.
     * </pre>
     * @return [STRING]
     */
    function getLoginURL() 
    {
        // NOTE: This routine is designed to be called directly without the 
        // need for this to be made an object.  So instead of using 
        // $this->getBaseURL() we references the getBaseURL() method using the
        // object reference.
        $baseURL = Page::getBaseURL().'?'.Page::QS_MODULE.'='.PAGE_MODULE_LOGIN;
        
        return $baseURL;
        
    } // end getLoginURL()
    
    
    
    //************************************************************************
    /**
     * function getLogoutURL
     * <pre>
     * This function returns the link to the Login Page.
     * </pre>
     * @return [STRING]
     */
    function getLogoutURL() 
    {
        // NOTE: This routine is designed to be called directly without the 
        // need for this to be made an object.  So instead of using 
        // $this->getBaseURL() we references the getBaseURL() method using the
        // object reference.
        $baseURL = Page::getBaseURL().'?'.Page::QS_MODULE.'='.PAGE_MODULE_LOGOUT;
        
        return $baseURL;
        
    } // end getLogoutURL()

}


?>