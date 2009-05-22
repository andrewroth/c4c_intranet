<?php
/**
 * @package CMSPage
 */ 
/**
 * class XMLObject_CMSPageApp
 * <pre> 
 * This class manages the CMS_CMSPAGEAPPS_PageApp DB table and compiles all the zones and apps on a given page.
 * </pre>
 * @author Johnny Hausman
 */
class  XMLObject_CMSPageApp extends XMLObject {

	//CONSTANTS:
	/** The name of the DB Table this class manages. */
    const DB_TABLE_PAGEAPP = 'cms_cmspageapps_pageapp';
    
    /** The XML node label for the Page Node property. */
    const XML_NODE_PAGE = 'cmspage';
    
    /** The XML node label for the Zone property. */
    const XML_NODE_ZONE = 'zone';
    const SQL_CREATE_TABLE = " (
          pageapp_id int(11) NOT NULL auto_increment,
          page_id int(11) NOT NULL default '0',
          app_id int(11) NOT NULL default '0',
          pageapp_zone varchar(50) NOT NULL default '',
          pageapp_order int(2) NOT NULL default '0',
          PRIMARY KEY  (pageapp_id)
        ) TYPE=MyISAM";

	//VARIABLES:
	/** @var [ARRAY] List of Zones for the given PageID */
	var $zones;

	/** @var [classvariable2 type] [optional description of  classvariable2] */
	var $pageID;
	
	/** @var [OBJECT] The DB connection object. */
	var $db;
	
	/** @var [OBJECT] The viewer object. */
	var $viewer;

	//CLASS CONSTRUCTOR
	//************************************************************************
	/**
	 * function __construct
	 * <pre>
	 * initialize the zones for the given page
	 * </pre>
	 * @param $db [OBJECT] The Site DB object
	 * @param $viewer [OBJECT] The Viewer object
	 * @return [void]
	 */
    function __construct( $viewer, $pageID=null) 
    {
    
         parent::__construct( XMLObject_CMSPageApp::XML_NODE_PAGE );
        
        // store the db & viewer objects
        $this->db =& new Database_Site();
        $this->db->connectToDB( SITE_DB_NAME, SITE_DB_PATH, SITE_DB_USER, SITE_DB_PWORD);
        
        $this->viewer =& $viewer;
        
        // if a pageID was given then
        if (!(is_null( $pageID ) ) ) {
        
            // store value
            $this->pageID = $pageID;
            
            // load this page's data...
            $this->loadPage( $pageID );
        }
        
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
    }	
    
    
    
    //************************************************************************
	/**
	 * function loadPage
	 * <pre>
	 * load the page zones and applications given a pageID.
	 * </pre>
	 * @param $pageID [INTEGER] Unique PageID of the page to load.
	 */
    function loadPage( $pageID ) 
    {
        // now get a list of zones for this page
        $sql = 'SELECT DISTINCT pageapp_zone FROM '.SITE_DB_NAME.'.'.XMLObject_CMSPageApp::DB_TABLE_PAGEAPP.' WHERE page_id='.$pageID;
        
        // for each zone
        $this->db->runSQL( $sql );
        while ($row = $this->db->retrieveRow() ) {
        
            // store in this->zones
            $this->zones[] = $row['pageapp_zone'];
        }
        
        // Create a generic App Object.
        $currentApp = new XMLObject_CMSApps( $this->viewer);
            
        // for each zone
        for ( $zoneIndx=0; $zoneIndx<count($this->zones); $zoneIndx++) {
        
            // Create a new zone XML Object
            $currentZone = new XMLObject( XMLObject_CMSPageApp::XML_NODE_ZONE );
            $currentZone->addAttribute( 'name', $this->zones[ $zoneIndx ] );
            
            // get all the applications in the current zone
            $sql = 'SELECT * FROM '.SITE_DB_NAME.'.'.XMLObject_CMSPageApp::DB_TABLE_PAGEAPP.' WHERE page_id='.$pageID.' AND pageapp_zone="'.$this->zones[ $zoneIndx ].'" ORDER BY pageapp_order';
            
            // for each application
            $this->db->runSQL( $sql );
            while ( $row = $this->db->retrieveRow() ) {
            
                // Load Application
                $currentApp->loadApp( $row['app_id'] );
                
                // Store Application in current Zone
                $currentZone->addElement( $currentApp->getNodeName(), $currentApp->getValues() );
                
            }// end while
            
            // Now store current Zone in this object
            $this->addElement( $currentZone->getNodeName(), $currentZone->getValues() );
            
        } // end For Each Zone
    }
    
    function dropTable($db)
    {
        $sql = "DROP TABLE IF EXISTS ".XMLObject_CMSPageApp::DB_TABLE_PAGEAPP;
        if (!$db->runSQL( $sql ) ) {
            echo '<tr><td><font color="#FF0000">'.$sql."</font></td></tr>\n";
        }
    }
    
    function createTable($db)
    {
         /* $sql = "CREATE TABLE ".XMLObject_CMSPageApp::DB_TABLE_PAGEAPP." (
          pageapp_id int(11) NOT NULL auto_increment,
          page_id int(11) NOT NULL default '0',
          app_id int(11) NOT NULL default '0',
          pageapp_zone varchar(50) NOT NULL default '',
          pageapp_order int(2) NOT NULL default '0',
          PRIMARY KEY  (pageapp_id)
        ) TYPE=MyISAM";*/
        $sql = "CREATE TABLE " . XMLObject_CMSPageApp::DB_TABLE_PAGEAPP . XMLObject_CMSPageApp::SQL_CREATE_TABLE;
        if (!$db->runSQL($sql) ) {
            echo '<tr><td><font color="#FF0000">'.$sql."</font></td></tr>\n";
        }
    }
	
}

?>