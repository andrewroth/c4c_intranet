<?php
/**
 * @package Multilingual
 */ 
/**
 * class MultilingualManager
 * <pre> 
 * This class manages the multilingual label information.
 * </pre>
 * @author Johnny Hausman
 */
class  MultilingualManager {

	//CONSTANTS:
    /** The Multilingual XML Root Node Name */
    const XML_NODE_NAME = 'multilingual';


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
	
	/** @var [OBJECT] Series manager Object  */
	protected $seriesManager;
	
	/** @var [OBJECT] Page manager Object  */
	protected $pageManager;
	
	/** @var [OBJECT] Language manager Object  */
	protected $languageList;
	
	

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
        
        $this->languageList = null;
        
        $this->seriesManager = new RowManager_MultilingualSeriesManager();
        $this->pageManager = new RowManager_MultilingualPageManager();
        
        // if a series key was provided ...
        if ( $seriesKey != '' ) {
        
            $this->seriesManager->loadBySeriesKey( $seriesKey );

            // if a page key was also provided then
            if ($pageKey != '' ) {

                // load that page's label data
                $this->loadPageLabels( $pageKey);
                
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
	 * function addLabel
	 * <pre>
	 * Creates a new label in the Labels DB table.
	 * </pre>
	 * @param $key [STRING] name of the label key 
	 * @param $text [STRING] name of the label text
	 * @param $languageKey [STRING] the language KEY of the language the text is in
	 * @return [void]
	 */
    function addLabel( $key, $text, $languageKey, $update = false ) 
    {
        // if we haven't loaded the language list then load it now.
        if ( is_null( $this->languageList) ) {
            $this->languageList = new LanguageList();
        }
        
        // if a page context is properly set then 
        if ( $this->pageManager->isLoaded() ) {
        
            // get the language ID from the given language Key
            $languageID = $this->languageList->getLanguageIDByKey( $languageKey );
            $pageID = $this->pageManager->getID();
            
            // create the new label 
            $label = new RowManager_MultilingualLabelManager();
                        
            // if label is unique then
            if ( $label->isUnique( $pageID, $key, $languageID ) ) {
            
                $label->setPageID( $pageID );
                $label->setKey( $key );
                $label->setLabel( $text );
                $label->setLanguageID( $languageID );  
                $label->createNewEntry();
                
            } // end if
            else //if ($update = true)		// HSMIT: added IF statement for dynamic labelling
            {
                // the label is not unique - an entry already exists in the DB
                // NEW CODE BY Russ Martin
                // TODO - Add code here to make the tools setup the final authority
                // echo 'The key ' . $key . ' is not unique <br/>';
/*                
                $label->setPageID( $pageID );
                $label->setKey( $key );
                $label->setLabel( $text );
                $label->setLanguageID( $languageID );  
                $label->updateDBTable();  // <-- primary code: used to update table if some aspect of data is not unique              
 */           }
        
        } else {
            die ('MultilingualManager::addLabel() : attempting to add label without a pageManager loaded!');
        }
        
    } // end addLabel()
    
    
    
    //************************************************************************
	/**
	 * function addPage
	 * <pre>
	 * Creates a new Page in the Multilingual Page DB table.
	 * </pre>
	 * @param $key [STRING] name of the label key 
	 * @return [void]
	 */
    function addPage( $key ) 
    {

        // if a page context is properly set then 
        if ( $this->seriesManager->isLoaded() ) {
      
            $seriesID = $this->seriesManager->getID();
            
            // if page key and series is unique then
            if ( $this->pageManager->isUniqueKey( $seriesID, $key) ) {
          
                // load key and Series ID
                $this->pageManager->setKey( $key );
                $this->pageManager->setSeriesID( $seriesID );
                
                // create new entry
                $this->pageManager->createNewEntry();
                
            } else {
            // else
           
                // load by page key
//                $this->pageManager->loadByPageKey( $seriesID, $key );
                $this->loadPageLabels( $key );
                
            } // end if
        
        } else {
            die ('MultilingualManager::addPage() : attempting to add Page without a seriesManager loaded!');
        }
        
    } // end addPage()
    
    
    
    //************************************************************************
	/**
	 * function addSeries
	 * <pre>
	 * Creates a new Series in the Multilingual series DB table.
	 * </pre>
	 * @param $key [STRING] name of the series 
	 * @return [void]
	 */
    function addSeries( $key ) 
    {
        // if key is unique then
        if ( $this->seriesManager->isUniqueKey( $key ) ) {
        
            // load key 
            $this->seriesManager->setKey( $key );
            
            // create new entry
            $this->seriesManager->createNewEntry(); 
            
        } else {
        // else
        
            // load Series from key
            $this->seriesManager->loadBySeriesKey( $key );
            
        }// end if
               
    } // end addSeries()
    
    

	//************************************************************************
	/**
	 * function createContext
	 * <pre>
	 * This function makes sure the given context (Site Key & Page Key) exist.
	 * </pre>
	 * @return [void]
	 */
    function createContext() 
    {
        // if a series key was given
        if ( $this->seriesKey != '') {
        
            // if series not loaded then
            if (!$this->seriesManager->isLoaded()) {
            
                // create series
                $this->addSeries( $this->seriesKey );
                              
            } // end if
            
        } // end if
        
        // if a page key was given
        if ($this->pageKey != '' ) {
        
            // if page is not loaded then
            if (!$this->pageManager->isLoaded() ) {
            
                // create page
                $this->addPage( $this->pageKey );

            } // end 
            
        } // end
    
    }

    
    
    
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
        
            // echo 'The key is ['.$key.']<br/>';
            // echo 'The $this->labels[ $key ] is ['.$this->labels[ $key ].']<br/>';

            // if desired [LANGUAGEID] exists
            if (array_key_exists($languageID, $this->labels[ $key ] ) ) {
            // if (array_key_exists($languageID, $this->labels ) ) {
            
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
	 * function getLabelManager
	 * <pre>
	 * returns a label manager object
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
	 * @return [OBJECT] RowManager_MultilingualLabelManager
	 */
    function getLabelManager($key, $languageID='') 
    {
        $labelManager = new RowManager_MultilingualLabelManager();
        
        
        // if language ID is not provided, then use class default.
        if ($languageID == '' ) {
            $languageID = $this->languageID;
        }

        // if desired [KEY] exists then
        if ( array_key_exists($key, $this->labels) ) {

            // if desired [LANGUAGEID] exists 
            if (array_key_exists($languageID, $this->labels[ $key ] ) ) {
            
                // return label in requested Language ID
                $pageID = $this->pageManager->getID();
                $successful = $labelManager->loadByKeyInfo( $pageID, $key, $languageID );
                // echo 'successful['.$successful.']<br/>';
                // echo 'lableManager<pre>'.print_r($labelManager,true).'</pre>';
            
            } else {
            // else 

                // return label in 1st avaialble language
                $labelData = $this->labels[ $key ];
                $languagesIDAvailable = array_keys( $labelData );
                $languageID = $languagesIDAvailable[0];
                
                $pageID = $this->pageManager->getID();
                $labelManager->loadByKeyInfo( $pageID, $key, $languageID );
                
            } // end if
        
        } else {
      
            // Make sure the pageID is set
            $labelManager->setPageID( $this->pageManager->getID() );
            
        } // end if

        $labelManager->setLanguageID( $languageID );
        
        return $labelManager;
        
    } // end getLabelManager()
    
    
    
    //************************************************************************
	/**
	 * function getLabelArray
	 * <pre>
	 * Returns the current set of labels as an array.
	 * </pre>
	 * @return [ARRAY]
	 */
    function getLabelArray() 
    {
        $labelArray = array();
        foreach( $this->labels as $key=>$value) {
        
            $label = $this->getLabel($key, $this->languageID);
            $labelArray[ $key ] = $label;
        }
        return $labelArray;
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
        $xmlList =  new XMLObject(RowManager_MultilingualLabelManager::XML_NODE_NAME );
        
        $labelKey = RowManager_MultilingualLabelManager::XML_ELEMENT_NAME;
        
        foreach( $this->labels as $key=>$value) {
        
            $label = $this->getLabel($key, $this->languageID);
            $xmlList->addElement($labelKey, $label, array('key'=>$key) );
        }

//echo $xmlList->getXML();
        return $xmlList->getXML();
    }
    
    
    
    //************************************************************************
	/**
	 * function getPageID
	 * <pre>
	 * Returns the current PageID being used for these labels.
	 * </pre>
	 * @return [INTEGER]
	 */
    function getPageID() 
    {
        return $this->pageManager->getID();
    }
    
    

	//************************************************************************
	/**
	 * function isContextSet
	 * <pre>
	 * Verifies that the Series and Page have been properly loaded.
	 * </pre>
	 * @return [BOOL]
	 */
    function isContextSet() 
    {
        return (($this->seriesManager->isLoaded()) 
                && ($this->pageManager->isLoaded()) );    
    }
    
    
    
    //************************************************************************
	/**
	 * function loadLabelsFromDB
	 * <pre>
	 * Loads a set of labels from the db.
	 * </pre>
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
	 * function loadPageLabels
	 * <pre>
	 * loads a set of labels linked to a given Series + Page  
	 * </pre>
	 * @param $seriesKey [STRING] unique key for the series of labels to load.
	 * @param $pagesKey [STRING] unique key for the page of labels to load.
	 * @return [void]
	 */
    function loadPageLabels( $pageKey='' ) 
    {

        if ($pageKey != '' ) {
        
            if ($this->seriesManager->isLoaded() ) {

                // get current series ID (from internal seriesManager)
                $seriesID = $this->seriesManager->getID();

                // attempt to load the page
                $this->pageManager->loadByPageKey( $seriesID, $pageKey );
                
                // if successfully loaded
                if ($this->pageManager->isLoaded() ) {

                    // get the list of labels
                    $labelList = $this->pageManager->getLabelList();
                    
                    // store each label
                    $labelList->setFirst();
                    while ( $label = $labelList->getNext() ) {
                        $this->storeLabel( $label );
                    } // next label
                    
                } // end if loaded
                
            } // end if series manager loaded 
            
        }
        
    } // end loadPageLabels()
    
    
    
    //************************************************************************
	/**
	 * function loadContextByPageKey
	 * <pre>
	 * Initialize this object using the provided page Key only.
	 * </pre>
	 * @param $key [STRING] the page Key to use to load.
	 * @return [void]
	 */
    function loadContextByPageKey( $key ) 
    {
        // if a key was provided
        if ( $key != '' ) {
        
            // this routine is called if the series key is unknown.
            // so attempt to load the page by key only...
            $this->pageManager->loadByPageKey( '', $key );
            
            if ( $this->pageManager->isLoaded() ) {
                
                // now try to load the series
                $seriesID = $this->pageManager->getSeriesID();
                $this->seriesManager = new RowManager_MultilingualSeriesManager( $seriesID ); 
                
                // now that we have a seriesManager loaded, 
                // load the PageLabels
                $this->loadPageLabels( $key );
                
            }

        }
    
    }
    
    
    
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
        $sql .= SITE_DB_NAME.'.'.MultilingualManager::DB_TABLE_SERIES;
        
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
        
                
    } // end loadSeriesData()
    
    
    
    //************************************************************************
	/**
	 * function loadSeriesLabels
	 * <pre>
	 * loads a set of labels linked to a given Series Key 
	 * </pre>
	 * @param $seriesKey [STRING] unique key for the series of labels to load.
	 * @return [void]
	 */
    function loadSeriesLabels( $seriesKey='' ) 
    {

echo 'Multilingual Manager::loadSeriesLabels() not implemented.';
exit;
        
    } // end loadSeriesLabels()
    
    
    
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
        // echo 'The $key is ['.$key.']<br/>';
        // echo 'The $tag is ['.$tag.']<br/>';
        // echo 'The $value is ['.$value.']<br/>';

        // if desired [KEY] exists then
        if ( array_key_exists($key, $this->labels) ) {
            // echo 'Key exists<br/>';
            
            // if desired [LANGUAGEID] exists 
            if (array_key_exists($this->languageID, $this->labels[ $key ] ) ) {
                // echo 'Desired Language is available<br/>';
                
                // update label                
                $labelData = $this->labels[ $key ][ $this->languageID ];
                $this->labels[ $key ][ $this->languageID ] = str_replace($tag, $value, $labelData);
                
                // echo 'new string should be'.$this->labels[ $key ][ $this->languageID ].'<br>';
            
            } else {
            // else 
                // echo 'Desired lang not available<br/>';
                
                // update label in 1st available language
                $labelData = current( $this->labels[ $key ] );
                $langID = key( $this->labels[$key] ); // Oh, Johnny, you forgot this line, 90 minutes of debugging == free lunch for me!
                // need to look through the other langs
 // echo 'Debugging Multilingual Manaer (line 613).<br><br>Case is key matches but requested language not available ... on a tag update<br><br>';
 // echo 'labelData = [';
 // var_export($labelData);
 // echo ']<br><br>';
 // echo 'this->labels[] = [';
 // var_export($this->labels[ $key ]);
 // echo ']<br><br>';
 // exit;
                $this->labels[$key][$langID]  = str_replace($tag, $value, $labelData);
                // echo 'The $this->labels[$key] is ['.$this->labels[$key].']<br/>';
                // echo 'Using lang['.$langID.']<br/>';
 // exit;             
            } // end if
            
        } 

    } // end setLabelTag()
    
    
    
    //************************************************************************
	/**
	 * function setPageKey
	 * <pre>
	 * Stores the page key for this object.
	 * </pre>
	 * @param $key [STRING] name of the page key 
	 * @return [void]
	 */
    function setPageKey( $key ) 
    {
    
        $this->pageKey = $key;
        
    } // end setPageKey()
    
    
    
    //************************************************************************
	/**
	 * function setSeriesKey
	 * <pre>
	 * Stores the series key for this object.
	 * </pre>
	 * @param $key [STRING] name of the series key 
	 * @return [void]
	 */
    function setSeriesKey( $key ) 
    {
    
        $this->seriesKey = $key;
        $this->seriesManager->loadBySeriesKey( $key );
        
    } // end setSeriesKey()
    
    
    
    //************************************************************************
	/**
	 * function storeLabel
	 * <pre>
	 * Stores the label information into our label array.
	 * </pre>
	 * @param $label [OBJECT] multilingual label object
	 * @return [void]
	 */
    function storeLabel( $label ) 
    {

        $key = $label->getKey();
        $languageID = $label->getLanguageID();
        $labelText = $label->getLabel();
        
        // store in labels array
        $this->labels[ $key ][ $languageID ] = $labelText;

    } // end storeLabel()
    
    
    
    
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
	
}

?>