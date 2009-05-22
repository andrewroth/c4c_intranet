<?php
/**
 * @package Multilingual
 */ 
/**
 * class XMLObject_Multilingual_Translation
 * <pre> 
 * This class gathers the label translation data and prepares it for XML output.
 * </pre>
 * @author Johnny Hausman
 */
class  XMLObject_Multilingual_Translation extends XMLObject {

	//CONSTANTS:
	/** [CLASS_CONSTANT description] */
    const NODE_TRANSLATION = 'translation';
    
    const NODE_TRANSLATION_ROOT = 'translationSet';

	//VARIABLES:
	/** @var [STRING] String of Field Names to manage for the label translation entry */
	var $fieldNames;
	
	/** @var [ARRAY] Array of Field Names to manage for the label translation entry */
	var $fieldList;

	/** @var [ARRAY] The Entries managed by this object */
	var $entryList;
	
	/** @var [ARRAY] The Translation entries managed by this object */
	var $labelsList;
	
	/** @var [STRING] The label ID of the label translation we are to manage */
	var $labelID;
	
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
	 * @param $labelID [STRING] The unique Label ID of the Label with 
	 * translation requests.
	 * @return [void]
	 */
    function __construct( $labelID='') 
    {
    
        parent::__construct( XMLObject_Multilingual_Translation::NODE_TRANSLATION_ROOT );
        
        // set the list of field names to manage
        $this->fieldNames = 'language_id,translation_moddate';
        $this->fieldList = explode( ',', $this->fieldNames);
        
        $this->entryList = array();
        
        $this->labelID = $labelID;
        
        // setup DB object
        $this->db = new Database_Site();
        $this->db->connectToDB( SITE_DB_NAME, SITE_DB_PATH, SITE_DB_USER, SITE_DB_PWORD);
        
        if ($this->labelID != '') {
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
 //       $fieldNames = str_replace('label_moddate','FROM_UNIXTIME(label_moddate) as label_moddate', $this->fieldNames);
        $sql = 'SELECT * FROM ';
        $sql .= SITE_DB_NAME.'.'.XMLObject_MultilingualManager::DB_TABLE_TRANSLATION;
        $sql .= ' WHERE label_id="'.$this->labelID.'"';
        
        $this->db->runSQL( $sql );
        
        // for each label
        while( $row = $this->db->retrieveRow() ) {
        
            // create new XML Object
            $currentLabel = new XMLObject(XMLObject_Multilingual_Translation::NODE_TRANSLATION );
            
            // load Values into XML Object
            for( $indx=0; $indx<count($this->fieldList); $indx++ ) {
                $fieldName = $this->fieldList[$indx];
                $currentLabel->addElement( $fieldName, $row[$fieldName]);
            }
            
            // store XML Object into array
            $this->labelsList[] = $currentLabel;
            
        } // next label
        
        
        // Add Each Label entry to this element
        for( $indx=0; $indx<count( $this->labelsList ); $indx++) {

            $this->addXmlObject( $this->labelsList[ $indx ] );
        } // next Label
        
    } // end loadData()
    
    
    
    //************************************************************************
	/**
	 * function synchronizeXMLData
	 * <pre>
	 * This function will take an XML data set of Label info and 
	 * synchronize it with the current data in the db.  This is useful for 
	 * exporting from one system using getXML and importing into another.
	 * </pre>
	 * <pre><code>
	 * for each label
	 *     if pageID + label_key + language_id Exist then
	 *         if values are different
	 *             if new label mod date later than current then
	 *                 remove any xlation entries linked to current label
	 *                 Update label info with new set
	 *                 Insert any translation request linked to new label
	 *             end if
	 *         end if
	 *     else
	 *         Insert label info
	 *     end if
	 * next label
	 * </code></pre>
	 * @param $pageID [INTEGER] The corresponding page ID for this label
	 * @param $xmlData [OBJECT] SimpleXML object of the labelSet info
	 * @return [void]
	 */
    function synchronizeXMLData( $labelID, $xmlData ) 
    {
        
        $dbTranslationTableName = SITE_DB_NAME.'.'.XMLObject_MultilingualManager::DB_TABLE_LABEL;
        
        //  for each label
        $labelNodeName = XMLObject_Multilingual_Translation::NODE_TRANSLATION;
        if ( isset( $xmlData->$labelNodeName) ) {
        
            foreach( $xmlData->$labelNodeName as $label) {
            
                $this->db->setTableName( XMLObject_MultilingualManager::DB_TABLE_TRANSLATION );
                    
                $fields = array();
                $values = array();
                
                // for each fieldlist item
                for( $indx=0; $indx<count($this->fieldList); $indx++) {
                    $fieldName = $this->fieldList[ $indx ];
                    $fields[] = $fieldName;
                    $values[] = (string) $label->$fieldName;
                }
                
                $fields[] = 'label_id';
                $values[] = $labelID;
                
                $this->db->setFields( $fields );
                $this->db->setValues( $values );
                
                $this->db->insert();
            
            } //  next label
        
        } // end if (isset())         

    } // end synchronizeXMLData()
    
    
    
    //************************************************************************
	/**
	 * function removeEntry
	 * <pre>
	 * This method removes any Translation Entry(ies) based on the given data.
	 * </pre>
	 * <pre><code>
	 * [Put PseudoCode Here]
	 * </code></pre>
	 * @param $labelID [INTEGER] The Label ID of the entry to remove.
	 * @param $languageID [INTETER] Optional languageID of the Translation Entry to remove.  Default is to remove all if not provided.
	 * @return [void]
	 */
    function removeEntry($labelID, $languageID='') 
    {
        // create WHERE condition
        $whereCondition = ' label_id='.$labelID;
        if ( $languageID != '') {
            $whereCondition .= ' AND language_id='.$languageID;
        }
        
        
        $sql = 'DELETE FROM '.SITE_DB_NAME.'.'.XMLObject_MultilingualManager::DB_TABLE_TRANSLATION;
        $sql .= ' WHERE '.$whereCondition;
        
        $this->db->runSQL( $sql );
        
    }   // end removeEntry()
    
    
}

?>