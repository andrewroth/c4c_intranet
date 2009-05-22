<?php
/**
 * @package Multilingual
 */ 
/**
 * class XMLObject_MultilingualManager
 * <pre> 
 * This class is responsible for oversees the Multilingual Data (labels & lists).
 * </pre>
 * @author Johnny Hausman
 */
class  XMLObject_MultilingualManager extends XMLObject {

	//CONSTANTS:
	/** The DB Table Name of the Series Table */
    const DB_TABLE_SERIES = 'site_multilingual_series';
    
    /** The DB Table Name of the Page Table */
    const DB_TABLE_PAGE = 'site_multilingual_page';
    
    /** The DB Table Name of the Label Table */
    const DB_TABLE_LABEL = 'site_multilingual_label';
    
    /** The DB Table Name of the Label Translation Table */
    const DB_TABLE_TRANSLATION = 'site_multilingual_translation';
    
    /** The Multilingual XML Root Node Name */
    const NODE_MULTILINGUAL_ROOT = 'multilingual';
    
    /** The Multilingual Label List XML Root Node Name */
    const XML_NODE_LABELLIST = 'labelList';
    
    /** The Multilingual Label  XML Element Name */
    const XML_ELEMENT_LABEL = 'label';

	//VARIABLES:
	/** @var [ARRAY] array of labels keyed by [KEY][LANGUAGE_ID] */
	protected $labels;

	/** @var [INTEGER] Desired language id of the viewer */
	protected $languageID;
	
	/** @var [STRING] The Series Key of the labels we want */
	protected $seriesKey;
	
	/** @var [STRING] The Page Key of the labels we want */
	protected $pageKey;
	
	/** @var [STRING] The Label Key of the label we want */
	protected $labelKey;
	
	/** @var [OBJECT] DB object for access label info */
	protected $db;
	
	/** @var [ARRAY] Array of Series Objects  */
	protected $seriesList;
	
	

	//CLASS CONSTRUCTOR
	//************************************************************************
	/**
	 * function __construct
	 * <pre>
	 * Initialize the Manager to it's starting values.
	 * </pre>
	 * @param $languageID [INTEGER] The Desired Language ID of the labels 
	 * @param $seriesKey [STRING] The Unique series key
	 * @param $pageKey [STRING] The Unique page key
	 * @param $labelKey [STRING] The Unique label key
	 * @return [void]
	 */
    function __construct($languageID='', $seriesKey='', $pageKey='', $labelKey='') 
    {
        parent::__construct( XMLObject_MultilingualManager::NODE_MULTILINGUAL_ROOT );
    
        // save provided initialization data ...
        $this->languageID   = $languageID;
        $this->seriesKey    = $seriesKey;
        $this->pageKey      = $pageKey;
        $this->labelKey     = $labelKey;
        
        // initialize labels to empty array
        $this->labels = array();
        
        // setup DB object
        $this->db = new Database_Site();
        $this->db->connectToDB( SITE_DB_NAME, SITE_DB_PATH, SITE_DB_USER, SITE_DB_PWORD);

        // initialize seriesList to empty array
        $this->seriesList = array();
        
        // if a series key was provided ...
        if ( $seriesKey != '' ) {
        
            // if a page key was also provided then
            if ($pageKey != '' ) {
            
                // load that page's label data
                $this->loadPageLabels( $seriesKey, $pageKey);
                
            } else {
                
                // load the serie's label data
                $this->loadSeriesLabels( $seriesKey );
            
            }
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
	 * function loadLabelsFromDB
	 * <pre>
	 * Loads a set of labels from the db.
	 * </pre>
	 * <pre><code>
	 * [Put PseudoCode Here]
	 * </code></pre>
	 * @param $sql [STRING] SQL statement to use to load labels
	 * @return [void]
	 */
    function loadLabelsFromDB( $sql ) 
    {
        // execute given SQL statment
        $this->db->runSQL( $sql );
        
        // for each returned label
        while ($row = $this->db->retrieveRow() ) {
        
            // store in labels array
            $this->labels[ $row['label_key'] ][ $row['language_id'] ] = $row['label_label'];
            
        } // next label
        
    } // end loadLabelsFromDB()
    
    
    
    //************************************************************************
	/**
	 * function loadSeriesLabels
	 * <pre>
	 * loads a set of labels linked to a given Series Key 
	 * </pre>
	 * <pre><code>
	 * [Put PseudoCode Here]
	 * </code></pre>
	 * @param $seriesKey [STRING] unique key for the series of labels to load.
	 * @return [void]
	 */
    function loadSeriesLabels( $seriesKey='' ) 
    {
        // if no series key is given, then all data will be loaded.
        // might not be what you want ...
        $whereClause = '';
        if ($seriesKey != '' ) {
            
            $whereClause = ' series_key="'.$seriesKey.'" ';
        }
        
        // compile proper SQL statement for loading this series...
        $sql = 'SELECT label_label, language_id, label_key FROM ';
        $sql .= '( ' . SITE_DB_NAME.'.'.XMLObject_MultilingualManager::DB_TABLE_SERIES . ' AS a INNER JOIN ' . SITE_DB_NAME.'.'.XMLObject_MultilingualManager::DB_TABLE_PAGE . ' AS b ON a.series_id=b.series_id )';
        $sql .= ' INNER JOIN '. SITE_DB_NAME.'.'.XMLObject_MultilingualManager::DB_TABLE_LABEL . ' as c ON b.page_id=c.page_id ';
        
        if ( $whereClause != '') {
            $sql .= ' WHERE '.$whereClause;
        }

        $this->loadLabelsFromDB( $sql );
        
    } // end loadSeriesLabels()
    
    
    
    //************************************************************************
	/**
	 * function loadPageLabels
	 * <pre>
	 * loads a set of labels linked to a given Series + Page  
	 * </pre>
	 * @param $seriesKey [STRING] unique key for the series of labels to load.
	 * @param $pagesKey [STRING] unique key for the page of labels to load.
	 * @return [void]
	 */
    function loadPageLabels( $seriesKey='', $pageKey='' ) 
    {
        // if no series key or page key is given, then all data will be loaded.
        // might not be what you want ...
        $whereClause = '';
        if ($seriesKey != '' ) {
            
            $whereClause = ' series_key="'.$seriesKey.'" ';
        }
        
        if ($pageKey != '' ) {
            
            if ($whereClause != '') {
                $whereClause .= ' AND ';
            }
            $whereClause .= ' page_key="'.$pageKey.'" ';
        }
        
        // compile proper SQL statement for loading this series...
        $sql = 'SELECT label_label, language_id, label_key FROM ';
        $sql .= '( ' . SITE_DB_NAME.'.'.XMLObject_MultilingualManager::DB_TABLE_SERIES . ' AS a INNER JOIN ' . SITE_DB_NAME.'.'.XMLObject_MultilingualManager::DB_TABLE_PAGE . ' AS b ON a.series_id=b.series_id )';
        $sql .= ' INNER JOIN '. SITE_DB_NAME.'.'.XMLObject_MultilingualManager::DB_TABLE_LABEL . ' as c ON b.page_id=c.page_id ';
        
        if ( $whereClause != '') {
            $sql .= ' WHERE '.$whereClause;
        }

        $this->loadLabelsFromDB( $sql );
        
    } // end loadPageLabels()

    
    
    
    //************************************************************************
	/**
	 * function loadSeriesData
	 * <pre>
	 * load the series+page+label Data linked to a given Series Key 
	 * </pre>
	 * <pre><code>
	 * if no series key is given, then all data will be loaded.
	 * </code></pre>
	 * @param $seriesKey [STRING] unique key for the series data to load.
	 * @return [void]
	 */
    function loadSeriesData( $seriesKey='' ) 
    {
        // if no series key is given, then all data will be loaded.
        // might not be what you want ...
        $whereClause = '';
        if ($seriesKey != '' ) {
            
            $whereClause = ' series_key="'.$seriesKey.'" ';
        }
        
        // compile proper SQL statement for loading this series...
        $sql = 'SELECT DISTINCT series_key FROM ';
        $sql .= SITE_DB_NAME.'.'.XMLObject_MultilingualManager::DB_TABLE_SERIES;
        
        if ( $whereClause != '') {
            $sql .= ' WHERE '.$whereClause;
        }

        // run the query 
        $this->db->runSQL( $sql );

        // for each series returned
        while( $row = $this->db->retrieveRow() ) {

            // create new instance of series
            $seriesList = new XMLObject_Multilingual_Series($row['series_key']);
            
            // add to this object's XML data
            $this->addXmlObject( $seriesList );
        }
        
                
    } // end loadSeriesLabels()

    
    
    
    //************************************************************************
	/**
	 * function getLabel
	 * <pre>
	 * returns a label
	 * </pre>
	 * <pre><code>
	 * if language ID is not provided, then use class default.
	 * if desired [KEY] exists then
	 *     if desired [LANGUAGEID] exists 
	 *         return label
	 *     else
	 *         return label in 1st avaialble language
	 *     end if
	 * else
	 *     return key
	 * end if
	 * </code></pre>
	 * @param $key [STRING] The Key of the label we should return
	 * @param $languageID [INTEGER] The Language ID of the label to return
	 * @return [STRING]
	 */
    function getLabel($key, $languageID='') 
    {
        $labelData = '';
        
        // if language ID is not provided, then use class default.
        if ($languageID == '' ) {
            $languageID = $this->languageID;
        }


        // if desired [KEY] exists then
        if ( array_key_exists($key, $this->labels) ) {

            // if desired [LANGUAGEID] exists 
            if (array_key_exists($languageID, $this->labels[ $key ] ) ) {
            
                // return label
                $labelData = $this->labels[ $key ][ $languageID ];
            
            } else {
            // else 
            
                // return label in 1st avaialble language
                $labelData = current( $this->labels[ $key ] );
                
            } // end if
            
        } else {
        // else
        
            //return key
            $labelData = $key;
            
        } // end if

        return $labelData;
        
    } // end getLabel()
    
    
    
    //************************************************************************
	/**
	 * function setLabelTag
	 * <pre>
	 * replaces an embedded tag in a label with the given value.
	 * </pre>
	 * <pre><code>
	 * if language ID is not provided, then use class default.
	 * if desired [KEY] exists then
	 *     if desired [LANGUAGEID] exists 
	 *         update label
	 *     else
	 *         update label in 1st avaialble language
	 *     end if
	 * end if
	 * </code></pre>
	 * @param $key [STRING] The Key of the label we should update
	 * @param $tag [STRING] The embedded tag in the label to replace
	 * @param $value [STRING] The text to replace the tag with.
	 * @return [void]
	 */
    function setLabelTag($key, $tag, $value) 
    {

        // if desired [KEY] exists then
        if ( array_key_exists($key, $this->labels) ) {

            // if desired [LANGUAGEID] exists 
            if (array_key_exists($this->languageID, $this->labels[ $key ] ) ) {
            
                // update label
                $labelData = $this->labels[ $key ][ $this->languageID ];
                $this->labels[ $key ][ $this->languageID ] = str_replace($tag, $value, $labelData);
            
            } else {
            // else 
            
                // update label in 1st avaialble language
                $labelData = current( $this->labels[ $key ] );
                $langID = key( $this->labels[$key] ); // Oh, Johnny, you forgot this line, 90 minutes of debugging == free lunch for me!
/*echo 'Debugging Multilingual Manaer (line 396).<br><br>Case is key matches but requested language not available ... on a tag update<br><br>';
echo 'labelData = [';
var_export($labelData);
echo ']<br><br>';
echo 'this->labels[] = [';
var_export($this->labels[ $key ]);
echo ']<br><br>';
exit;*/
                $this->labels[$key][$langID]  = str_replace($tag, $value, $labelData);
                
            } // end if
            
        } 

    } // end setLabelTag()
    
    
    
    
    //************************************************************************
	/**
	 * function synchronizeXMLData
	 * <pre>
	 * This function will take an XML data set of multilingual info and 
	 * synchronize it with the current data in the db.  This is useful for 
	 * exporting from one system using getXML and importing into another.
	 * </pre>
	 * <pre><code>
	 * convert XML data into a simpleXML object
	 * create a Multilingual_Series object to handle synchronizing of Data
	 * for each series
     *   tell series object to synchronize XML Data 
	 * next series
	 * </code></pre>
	 * @param $xmlData [STRING] XML description of the multilingual data to synchronize
	 * @return [void]
	 */
    function synchronizeXMLData( $xmlData ) 
    {
        
        // convert XML data into a simpleXML object
        $multilingualData = simplexml_load_string( $xmlData );
        
        $seriesObject = new XMLObject_Multilingual_Series();
        
        // for each series
        foreach( $multilingualData as $series ) {
        
            // tell series object to synchronize XML Data 
            $seriesObject->synchronizeXMLData( $series );
            
        }  // next series
        
    }
    
    
    
    //************************************************************************
	/**
	 * function getLabelXML
	 * <pre>
	 * Prepares all the currently held labels into an XML output.
	 * </pre>
	 * @return [STRING]
	 */
    function getLabelXML() 
    {
        $xmlList =  new XMLObject(XMLObject_MultilingualManager::XML_NODE_LABELLIST );
        
        foreach( $this->labels as $key=>$value) {
        
            $label = $this->getLabel($key, $this->languageID);
            $xmlList->addElement('label', $label, array('key'=>$key) );
        }
        
        return $xmlList->getXML();
        
    }
	
}

?>