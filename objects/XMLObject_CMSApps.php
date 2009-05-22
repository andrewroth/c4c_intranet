<?php
/**
 * @package CMSPage
 */ 
/**
 * class XMLObject_CMSApps
 * <pre> 
 * A class to manage individual Application entries in the CMS_CMSApps_Apps DB table.
 * </pre>
 * @author Johnny Hausman
 */
class  XMLObject_CMSApps extends XMLObject {

	//CONSTANTS:
	/** The name of the DB Table this class manages. */
    const DB_TABLE_APPS = 'cms_cmsapps_app';
    
    /** The XML node label for the Key property. */
    const XML_NODE_APP = 'app';
    
    /** The XML node label for the Key property. */
    const XML_NODE_KEY = 'key';
    
    /** The XML node label for the Type property. */
    const XML_NODE_TYPE = 'type';
    
    /** The XML node label for the Content property. */
    const XML_NODE_CONTENT = 'content';
    
    /** The Sql command to create thhe required table*/
    const SQL_CREATE_TABLE = " (
          app_id int(11) NOT NULL auto_increment,
          app_type varchar(50) NOT NULL default '',
          app_key varchar(50) NOT NULL default '',
          app_parameters text NOT NULL,
          PRIMARY KEY  (app_id)
        ) TYPE=MyISAM";

    
    /** The XML node label for the Content property. */
    const APP_TYPE_HTMLBLOCK = 'htmlBlock';
    

	//VARIABLES:
	
	/** @var [INTEGER] The unique app ID */
	var $appID;
	
	/** @var [STRING] The application Type keyword */
	var $appType;

	/** @var [STRING] The Application's "Key" */
	var $appKey;
	
	/** @var [ARRAY] An array of parameters to use to initialize the applciation. */
	var $appParameters;
	
	/** @var [STRING] The HTML contents of this application. */
	var $appHTML;
	
	/** @var [OBJECT] The DB connection object. */
	var $db;
	
	/** @var [OBJECT] The viewer object. */
	var $viewer;
	
	

	//CLASS CONSTRUCTOR
	//************************************************************************
	/**
	 * function __construct
	 * <pre>
	 * loads a specific application by it's key.
	 * </pre>
	 * @param $db [OBJECT] The db connection for the site
	 * @param $viewer [OBJECT] The viewer object
	 * @param $appKey [STRING] The identifying Key for the application
	 * @return [void]
	 */
    function __construct( $viewer, $appID=null ) 
    {
    
        // pass the root node name to the parent constructor
        parent::__construct( XMLObject_CMSApps::XML_NODE_APP );
        
        // store the db & viewer objects
        $this->db = new Database_Site();
        $this->db->connectToDB( SITE_DB_NAME, SITE_DB_PATH, SITE_DB_USER, SITE_DB_PWORD);
        
        $this->viewer =& $viewer;
        
        // if an appID is provided then
        if (!is_null($appID) ) {
        
            // Load this app
            $this->appID = $appID;
            $this->loadApp( $this->appID );
        }
        
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
	 * function createTable
	 * <pre>
	 * loads a page's content data.
	 * </pre>
	 * @param $key [STRING] Unique Handle for the desired Page
	 */
    function createTable($dbUse) {
    /* A fuction called to create the session table this object works with*/
            $sql = "CREATE TABLE ".XMLObject_CMSApps::DB_TABLE_APPS . XMLObject_CMSApps::SQL_CREATE_TABLE;
        
            if (!$dbUse->runSQL( $sql ) ) {
                echo '<tr><td><font color="#FF0000">'.$sql."</font></td></tr>\n";
            }
    }




    //************************************************************************
	/**
	 * function dropTable
	 * <pre>
	 * loads a page's content data.
	 * </pre>
	 * @param $key [STRING] Unique Handle for the desired Page
	 */
    function dropTable($dbUse) {
        /* A fuction called to drop the session table this object works with*/
        $sql = "DROP TABLE IF EXISTS ".XMLObject_CMSApps::DB_TABLE_APPS;
            
        if (!$dbUse->runSQL( $sql ) ) {
            echo '<tr><td><font color="#FF0000">'.$sql."</font></td></tr>\n";
        }
}
    
    
    
    //************************************************************************
	/**
	 * function loadApp
	 * <pre>
	 * Loads the individual Application Data from the appropriate CMS system 
	 * object.
	 * </pre>
	 * <pre><code>
	 * [Put PseudoCode Here]
	 * </code></pre>
	 * @param $appID [STRING] The unique ID of the application info we are 
	 * loading.
	 * @return [void]
	 */
    function loadApp( $appID ) 
    {
        // reset my XML values to empty
        $this->clearXMLValues();
        
        // get the requested App entry from the DB
        $sql = "SELECT * FROM ".SITE_DB_NAME.'.'.XMLObject_CMSApps::DB_TABLE_APPS." WHERE app_id=".$appID;
        
        $this->db->runSQL( $sql );
        
        // if entry found then 
        if ( $row = $this->db->retrieveRow() ) {
        
            // set member values
            $this->appID = $row[ 'app_id' ];
            $this->appType = $row[ 'app_type' ];
            $this->appKey = $row[ 'app_key' ];
            $this->appParameters = $row[ 'app_parameters' ];
            
            // find App Type and create new applcation
            switch ( $this->appType ) {
            
                case XMLObject_CMSApps::APP_TYPE_HTMLBLOCK:
                
                    $htmlBlock = new HTMLBlock( $this->appKey, $this->viewer->getLanguageID() );
                    $this->appHTML = $htmlBlock->getData();
                    
                    //$this->appHTML = 'HTML Block // key=['.$this->appKey.'] languageID=['.$this->viewer->getLanguageID().']';
                    break;
            }
            
            // now set the data in the XML Object
            // include App Key as an element
           $this->addElement(XMLObject_CMSApps::XML_NODE_KEY, $this->appKey );
           
           // include App Type as an element
           $this->addElement(XMLObject_CMSApps::XML_NODE_TYPE, $this->appType );
           
           // include App HTML Content as an element
           $this->addElement(XMLObject_CMSApps::XML_NODE_CONTENT, $this->appHTML );            
           
        } else {
        
            // clear object to empty state
            $this->appID = '';
            $this->appType = '';
            $this->appKey =  '';
            $this->appParameters = '';
            $this->appHTML = '';
        }
        
    }  // end loadApp()
    	
}

?>