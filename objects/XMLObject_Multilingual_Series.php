<?php
/**
 * @package Multilingual
 */ 
/**
 * class XMLObject_Multilingual_Series
 * <pre> 
 * This class gathers the series data and prepares it for XML output.
 * </pre>
 * @author Johnny Hausman
 */
class  XMLObject_Multilingual_Series extends XMLObject {

	//CONSTANTS:
	/** The Site XML Root Node Name */
    const NODE_SITE_ROOT = 'series';

	//VARIABLES:
	/** @var [ARRAY] Array of Field Names to manage for the series entry */
	var $fieldList;

	/** @var [ARRAY] The page(s) managed by this entry */
	var $pageList;

	/** @var [STRING] The series key of the series we are to manage */
	var $seriesKey;
	
	/** @var [OBJECT] The DB object to access the information */
	var $db;
	
	

	//CLASS CONSTRUCTOR
	//************************************************************************
	/**
	 * function __construct
	 * <pre>
	 * [classConstructor Description]
	 * </pre>
	 * <pre><code>
	 * [Put PseudoCode Here]
	 * </code></pre>
	 * @param $seriesKey [STRING] The unique Label Key of this Label Data
	 * @return [void]
	 */
    function __construct($seriesKey='') 
    {
    
        parent::__construct( XMLObject_Multilingual_Series::NODE_SITE_ROOT );
        
        // set the list of field names to manage
        $fieldNames = 'series_key';
        $this->fieldList = explode( ',', $fieldNames);
        
        $this->pageList = array();

        $this->seriesKey = $seriesKey;
        
        // setup DB object
        $this->db = new Database_Site();
        $this->db->connectToDB( SITE_DB_NAME, SITE_DB_PATH, SITE_DB_USER, SITE_DB_PWORD);
        
        // if a series Key is provided then load the data
        if ($this->seriesKey != '') {
            $this->loadData();
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
	 * function loadData
	 * <pre>
	 * gathers the label data from the DB
	 * </pre>
	 * @return [void]
	 */
    function loadData() 
    {
        // build sql for gathering data
        $sql = 'SELECT * FROM ';
        $sql .= SITE_DB_NAME.'.'.XMLObject_MultilingualManager::DB_TABLE_SERIES;
        $sql .= ' WHERE series_key="'.$this->seriesKey.'"';
        
        $this->db->runSQL( $sql );
        
        // if an entry is found then
        if ($row = $this->db->retrieveRow() ) {
        
            // get seriesID
            $seriesID = $row['series_id'];
            
             // load Values into this Series Object
            for( $indx=0; $indx<count($this->fieldList); $indx++ ) {
            
                $fieldName = $this->fieldList[$indx];
                $this->addElement( $fieldName, $row[$fieldName]);
            }
            
            
             // Now get each Page key associated with this Series
            $sql = 'SELECT DISTINCT page_key FROM ';
            $sql .= SITE_DB_NAME.'.'.XMLObject_MultilingualManager::DB_TABLE_PAGE;
            $sql .= ' WHERE series_id="'.$seriesID.'"';
            
            $this->db->runSQL( $sql );
            
            // for each page key
            while( $row = $this->db->retrieveRow() ) {
    
                // store XML Object into array
                $this->pageList[] = new XMLObject_Multilingual_Page( $seriesID, $row[ 'page_key' ] );
           
            } // next label
            
            
            // Add Each Page entry to this element
            for( $indx=0; $indx<count( $this->pageList ); $indx++) {
                
                $this->addXmlObject( $this->pageList[ $indx ] );
            } // next Label
            
            
        } else {
        // else Page entry not found so
        
            // reset pageID
            $seriesID = -1;
        
        }
        
        
    } // end loadData()
    
    
    
    //************************************************************************
	/**
	 * function synchronizeXMLData
	 * <pre>
	 * This function will take an XML data set of Series info and 
	 * synchronize it with the current data in the db.  This is useful for 
	 * exporting from one system using getXML and importing into another.
	 * </pre>
	 * <pre><code>
	 * if series Exist then
	 *     get seriesID
	 * else
     *     create series
	 *     get seriesID
	 * end if
	 * for each Page
     *     tell pageObject to synchronize it's data
	 * next Page
	 * </code></pre>
	 * @param $xmlData [OBJECT] SimpleXML object of the series info
	 * @return [void]
	 */
    function synchronizeXMLData( $xmlData ) 
    {
        
        $dbSeriesTableName = SITE_DB_NAME.'.'.XMLObject_MultilingualManager::DB_TABLE_SERIES;
        
        $pageObject = new XMLObject_Multilingual_Page();
        
        $sql = 'SELECT * FROM '.$dbSeriesTableName;
        $sql .= ' WHERE series_key="'.$xmlData->series_key.'"';
        
        $this->db->runSQL( $sql );
        
        // if series Exist then
        if ( $row = $this->db->retrieveRow() ) {
        
            // get seriesID
            $seriesID = $row[ 'series_id' ];
    
        } else {
        // else
        
            // create series
            $sql = 'INSERT INTO '.$dbSeriesTableName.' (series_key) ';
            $sql .= ' VALUES ("'.$xmlData->series_key.'")';
            $this->db->runSQL( $sql );
            
            // get seriesID
            $seriesID = $this->db->retrievePrimaryKey();
            
        } // end if

        // for each Page
        $pageNodeName = XMLObject_Multilingual_Page::NODE_PAGE_ROOT;
        foreach( $xmlData->$pageNodeName as $page ) {
        
            $pageObject->synchronizeXMLData( $seriesID, $page);
            
        } // next Page
    }

    	
	
}

?>