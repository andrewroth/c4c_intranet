<?php

/**
 * @package CMSPage
 */ 
/**
 * class CMSPage
 * <pre> 
 * This class is responsible for piecing together the various data items found
 * on a CMS page.
 * </pre>
 * @author Johnny Hausman
 */
class  CMSPage {

	//CONSTANTS:
	/** The name of the DB Table this class manages. */
    const DB_TABLE_PAGE = 'cms_cmspages_page';
    const SQL_CREATE_TABLE = " (
  page_id int(11) NOT NULL auto_increment,
  area_id int(11) NOT NULL default '0',
  page_key varchar(50) NOT NULL default '',
  page_template varchar(50) NOT NULL default '',
  PRIMARY KEY  (page_id)
) TYPE=MyISAM;";


	//VARIABLES:
	/** @var [OBJECT] The pageApp Manager for this page. */
	var $pageApps;
	
	/** @var [STRING] The unique handle of the requested Page. */
	var $pageKey;
	
	/** @var [STRING] Name of the Template File to use for this Page. */
	var $pageTemplate;
	
	/** @var [OBJECT] The DB connection object. */
	var $db;
	
	/** @var [OBJECT] The viewer object. */
	var $viewer;
	



	//CLASS CONSTRUCTOR
	//************************************************************************
	/**
	 * function __construct
	 * <pre>
	 * Class constructor for the XMLObject_CMSPage.
	 * </pre>
	 * @return [void]
	 */
    function __construct( $viewer, $key=null ) 
    {
        
        
        $this->pageApps = new XMLObject_CMSPageApp( $viewer );
        
        // store the db & viewer objects
        $this->db =& new Database_Site();
        $this->db->connectToDB( SITE_DB_NAME, SITE_DB_PATH, SITE_DB_USER, SITE_DB_PWORD);
        
        $this->viewer =& $viewer;
        
        // if a key was given then
        if (!(is_null( $key ) ) ) {
            
            $this->pageKey = $key;
            
            // load this page's data...
            $this->loadPage( $key );
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
	 * function dropTable
	 * <pre>
	 * drops this objects table
	 * </pre>
	 * 
	 */
       function dropTable($db)
    {
        $sql = "DROP TABLE IF EXISTS ".CMSPage::DB_TABLE_PAGE;
        if (!$db->runSQL( $sql ) ) {
            echo '<tr><td><font color="#FF0000">'.$sql."</font></td></tr>\n";
        }
    }
    
     //************************************************************************
	/**
	 * function createTable
	 * <pre>
	 * creates this objects table
	 * </pre>
	 * 
	 */
    function createTable($db)
    {
        $sql = "CREATE TABLE " . CMSPage::DB_TABLE_PAGE . CMSPage::SQL_CREATE_TABLE;
        if (!$db->runSQL($sql) ) {
            echo '<tr><td><font color="#FF0000">'.$sql."</font></td></tr>\n";
        }
    }
   
   
    //************************************************************************
	/**
	 * function loadPage
	 * <pre>
	 * loads a page's content data.
	 * </pre>
	 * @param $key [STRING] Unique Handle for the desired Page
	 */
    function loadPage( $key ) 
    {
        $this->pageKey = $key;
        
        $sql = 'SELECT * FROM '.SITE_DB_NAME.'.'.CMSPage::DB_TABLE_PAGE.' WHERE page_key="'.$key.'"';
        
        $this->db->runSQL( $sql );
        
        if ($row = $this->db->retrieveRow() ) {

            $this->pageTemplate = $row[ 'page_template' ];        
            $this->pageApps->loadPage( $row[ 'page_id' ] );
        
        } else {
        
            $this->pageTemplate = '';  
            $this->pageApps->loadPage( -1 );
        }

    }  // end loadPage()
    
    
    
    //************************************************************************
	/**
	 * function getPageTemplateName
	 * <pre>
	 * Returns the page Template name.
	 * </pre>
	 */
    function getPageTemplateName() 
    {
        
        return $this->pageTemplate;        

    }  // end getPageTemplateName()
    
    
    
    //************************************************************************
	/**
	 * function getPageTitle
	 * <pre>
	 * loads the cmspages label series
	 * Returns the page Title.
	 * </pre>
	 * @param $labels [OBJECT] The label's object to use for retrieving the Title.
     * @return [STRING] the page title.
	 */
    function getPageTitle( $labels ) 
    {
    
        $labels->loadSeriesLabels( CMSPage::DB_TABLE_PAGE );
        return $labels->getLabel( $this->pageKey );        

    }  // end getPageTitle()

    
    
    //************************************************************************
	/**
	 * function getXML
	 * <pre>
	 * returns the page contents data in XML format.
	 * </pre>
     * @param $isHeaderIncluded [BOOL] Determines if we include the '<?xml version="1.0"?>' header.
	 * @param $rootNodeName [STRING] The XML root node name.
	 *
	 * @return [STRING] Returns an XML formatted string.
	 */
    function getXML( $isHeaderIncluded=true, $rootNodeName='' ) 
	{
       return $this->pageApps->getXML( $isHeaderIncluded, $rootNodeName);
    }

	
}

?>