<?php
/**
 * @package Multilingual
 */ 
/**
 * class XMLObject_Multilingual_Page
 * <pre> 
 * This class gathers the page data and prepares it for XML output.
 * </pre>
 * @author Johnny Hausman
 */
class  XMLObject_Multilingual_Page extends XMLObject {

	//CONSTANTS:
	/** The Page XML Root Node Name */
    const NODE_PAGE_ROOT = 'page';

	//VARIABLES:
	/** @var [ARRAY] Array of Field Names to manage for the page entry */
	var $fieldList;

	/** @var [ARRAY] The Labels managed by this entry */
	var $labelsList;
	
	/** @var [STRING] The series ID of the page we are to manage */
	var $seriesID;
	
	/** @var [STRING] The page key of the page we are to manage */
	var $pageKey;
	
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
	 * @param $seriesID [STRING] The Page ID this Label is linked to
	 * @param $pageKey [STRING] The unique Label Key of this Label Data
	 * @return [void]
	 */
    function __construct($seriesID='', $pageKey='') 
    {
    
        parent::__construct( XMLObject_Multilingual_Page::NODE_PAGE_ROOT );
        
        // set the list of field names to manage
        $fieldNames = 'page_key';
        $this->fieldList = explode( ',', $fieldNames);
        
        $this->labelsList = array();
        
        $this->seriesID = $seriesID;
        $this->pageKey = $pageKey;
        
        // setup DB object
        $this->db = new Database_Site();
        $this->db->connectToDB( SITE_DB_NAME, SITE_DB_PATH, SITE_DB_USER, SITE_DB_PWORD);
        
        // if a seriesID & pageKey were provided then load the data...
        if (($this->seriesID != '') && ($this->pageKey != '')) {
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
        $sql .= SITE_DB_NAME.'.'.XMLObject_MultilingualManager::DB_TABLE_PAGE;
        $sql .= ' WHERE series_id="'.$this->seriesID.'" AND page_key="'.$this->pageKey.'"';
        
        $this->db->runSQL( $sql );
        
        if ($row = $this->db->retrieveRow() ) {
        
            // get pageID
            $pageID = $row['page_id'];
            
             // load Values into this Page Object
            for( $indx=0; $indx<count($this->fieldList); $indx++ ) {
            
                $fieldName = $this->fieldList[$indx];
                $this->addElement( $fieldName, $row[$fieldName]);
            }
            
            
             // Now get each label key associated with this Page
            $sql = 'SELECT DISTINCT label_key FROM ';
            $sql .= SITE_DB_NAME.'.'.XMLObject_MultilingualManager::DB_TABLE_LABEL;
            $sql .= ' WHERE page_id="'.$pageID.'"';
            
            $this->db->runSQL( $sql );
            
            // for each label key
            while( $row = $this->db->retrieveRow() ) {
    
                // store XML Object into array
                $this->labelsList[] = new XMLObject_Multilingual_Label( $pageID, $row[ 'label_key' ] );
           
            } // next label
            
            
            // Add Each Label entry to this element
            for( $indx=0; $indx<count( $this->labelsList ); $indx++) {

                $this->addXmlObject( $this->labelsList[ $indx ] );
            } // next Label
            
            
        } else {
        // else Page entry not found so
        
            // reset pageID
            $pageID = -1;
        
        }
        
        
    } // end loadData()
    
    
    
   //************************************************************************
	/**
	 * function synchronizeXMLData
	 * <pre>
	 * This function will take an XML data set of Page info and 
	 * synchronize it with the current data in the db.  This is useful for 
	 * exporting from one system using getXML and importing into another.
	 * </pre>
	 * <pre><code>
	 * if Page !Exist then
	 *     create page
	 *     get pageID
	 * else
	 *     get pageID
	 * end if
	 * for each LabelSet
	 *     for each label
	 *         if pageID + label_key + language_id !Exist then
	 *             Insert labe info
	 *         else
	 *             if values are different
	 *                 if new label mod date later than current then
	 *                     remove any xlation entries linked to current label
	 *                     Update label info with new set
	 *                     Insert any translation request linked to new label
	 *                 end if
	 *             end if
	 *         end if
	 *     next label
	 * next LabelSet
	 * </code></pre>
	 * @param $seriesID [INTEGER] The corresponding series ID for this page
	 * @param $xmlData [OBJECT] SimpleXML object of the series info
	 * @return [void]
	 */
    function synchronizeXMLData( $seriesID, $xmlData ) 
    {
        
        $dbPageTableName = SITE_DB_NAME.'.'.XMLObject_MultilingualManager::DB_TABLE_PAGE;
        
        $labelObject = new XMLObject_Multilingual_Label();
        
        $sql = 'SELECT * FROM '.$dbPageTableName;
        $sql .= ' WHERE series_id='.$seriesID.' AND page_key="'.$xmlData->page_key.'"';
        
        $this->db->runSQL( $sql );

        //  if Page !Exist then
        if ($row = $this->db->retrieveRow() ) {
        
            //  get pageID
            $pageID = $row['page_id'];
        
        } else {
        //  else
        
            //  create page
            $sql = 'INSERT INTO '.$dbPageTableName.' (series_id, page_key) ';
            $sql .= ' VALUES ('.$seriesID.', "'.$xmlData->page_key.'")';
            $this->db->runSQL( $sql );

            //  get pageID
            $pageID = $this->db->retrievePrimaryKey();
        
        } //  end if
        
        //  for each LabelSet
        $labelNodeName = XMLObject_Multilingual_Label::NODE_LABEL_ROOT;
        foreach( $xmlData->$labelNodeName as $labelSet) {
        
            $labelObject->synchronizeXMLData( $pageID, $labelSet );
        
        } //  next LabelSet

    } // end synchronizeXMLData()

	
}

?>