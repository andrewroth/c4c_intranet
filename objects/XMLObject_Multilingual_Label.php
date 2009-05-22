<?php
/**
 * @package Multilingual
 */ 
/**
 * class XMLObject_Multilingual_Label
 * <pre> 
 * This class gathers the label data and prepares it for XML output.
 * </pre>
 * @author Johnny Hausman
 */
class  XMLObject_Multilingual_Label extends XMLObject {

	//CONSTANTS:
	/** [CLASS_CONSTANT description] */
    const NODE_LABEL = 'label';
    
    const NODE_LABEL_ROOT = 'labelSet';

	//VARIABLES:
	/** @var [STRING] String of Field Names to manage for the label entry */
	var $fieldNames;
	
	/** @var [ARRAY] Array of Field Names to manage for the label entry */
	var $fieldList;

	/** @var [ARRAY] The Labels/Languages managed by this entry */
	var $labelsList;
	
	/** @var [STRING] The page ID of the labels we are to manage */
	var $pageID;
	
	/** @var [STRING] The label key of the labels we are to manage */
	var $labelKey;
	
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
	 * @param $pageID [STRING] The Page ID this Label is linked to
	 * @param $labelKey [STRING] The unique Label Key of this Label Data
	 * @return [void]
	 */
    function __construct($pageID='', $labelKey='') 
    {
    
        parent::__construct( XMLObject_Multilingual_Label::NODE_LABEL_ROOT );
        
        // set the list of field names to manage
        $this->fieldNames = 'label_key,label_label,language_id,label_moddate';
        $this->fieldList = explode( ',', $this->fieldNames);
        
        $this->labelsList = array();
        
        $this->pageID = $pageID;
        $this->labelKey = $labelKey;
        
        // setup DB object
        $this->db = new Database_Site();
        $this->db->connectToDB( SITE_DB_NAME, SITE_DB_PATH, SITE_DB_USER, SITE_DB_PWORD);
        
        if (($this->pageID != '') && ($this->labelKey != '')) {
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
        $sql .= SITE_DB_NAME.'.'.XMLObject_MultilingualManager::DB_TABLE_LABEL;
        $sql .= ' WHERE page_id="'.$this->pageID.'" AND label_key="'.$this->labelKey.'"';
        
        $this->db->runSQL( $sql );
        
        // for each label
        while( $row = $this->db->retrieveRow() ) {
        
            // create new XML Object
            $currentLabel = new XMLObject(XMLObject_Multilingual_Label::NODE_LABEL );
            
            // load Values into XML Object
            for( $indx=0; $indx<count($this->fieldList); $indx++ ) {
                $fieldName = $this->fieldList[$indx];
                $currentLabel->addElement( $fieldName, $row[$fieldName]);
            }
            
            // Load any translation requests for this label
            $translationRequests = new XMLObject_Multilingual_Translation( $row[ 'label_id' ] );
            
            $currentLabel->addXmlObject( $translationRequests );
            
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
    function synchronizeXMLData( $pageID, $xmlData ) 
    {
        
        $dbLabelTableName = SITE_DB_NAME.'.'.XMLObject_MultilingualManager::DB_TABLE_LABEL;
        $translationNodeName = XMLObject_Multilingual_Translation::NODE_TRANSLATION_ROOT;
        $translationRequests = new XMLObject_Multilingual_Translation();
        
        //  for each label
        $labelNodeName = XMLObject_Multilingual_Label::NODE_LABEL;
        foreach( $xmlData->$labelNodeName as $label) {
        
            $whereCondition = 'page_id='.$pageID.' AND label_key="'.$label->label_key.'" AND language_id='.$label->language_id;
            
            $sql = 'SELECT * FROM '.$dbLabelTableName;
            $sql .= ' WHERE '.$whereCondition;
            
            $this->db->runSQL( $sql );
            
            // if pageID + label_key + language_id Exist then
            if ($row = $this->db->retrieveRow() ) {
            
                // if values are different
                if ($row['label_label'] != $label->label_label ) {
                
                    // if new label mod date later than current then
                    $newDate = (float) $label->label_moddate;
                    $oldDate = (float) $row[ 'label_moddate'];

                    if ( $newDate > $oldDate ) {

//                        //  remove any xlation entries linked to current label
                        $translationRequests->removeEntry( $row['label_id'] );
                        
                        //  Update label info with new set
                        $this->db->setTableName( XMLObject_MultilingualManager::DB_TABLE_LABEL );
                        $fields = array( 'label_label', 'label_moddate');
                        $values[] = $label->label_label;
                        $values[] = $label->label_moddate;
                        
                        $this->db->setFields( $fields );
                        $this->db->setValues( $values );
                        
                        $this->db->setCondition( $whereCondition );
                        $this->db->update();
                        
//                        //  Insert any translation request linked to new label
                        $translationRequests->synchronizeXMLData( $row['label_id'], $label->$translationNodeName);
                        
                    } // end if
        
                } // end if
        
            } else {
            // else
      
                //  Insert label info
                $this->db->setTableName( XMLObject_MultilingualManager::DB_TABLE_LABEL );
                
                $fields = array();
                $values = array();
                
                // for each fieldlist item
                for( $indx=0; $indx<count($this->fieldList); $indx++) {
                    $fieldName = $this->fieldList[ $indx ];
                    $fields[] = $fieldName;
                    $values[] = (string) $label->$fieldName;
                    // NOTE:  I was having problems when assigning $values[] = 
                    //        the simpleXML member.  It doesn't seem to play 
                    //        nicely with the DB routines for the prepping the 
                    //        array, but casting the values as strings (which 
                    //        is what we want) works well.
                }
                
                $fields[] = 'page_id';
                $values[] = $pageID;
                
                $this->db->setFields( $fields );
                $this->db->setValues( $values );
                
                $this->db->insert();

        
                //  Insert any translation request linked to new label
                $newLabelID = $this->db->retrievePrimaryKey();
                $translationRequests->synchronizeXMLData( $newLabelID, $label->$translationNodeName);
        
            } // end if Exists 
        
        } //  next label
        

    } // end synchronizeXMLData()
    
    
}

?>