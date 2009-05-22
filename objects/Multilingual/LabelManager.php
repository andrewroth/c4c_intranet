<?php
/**
 * @package Multilingual
 */ 
/**
 * class RowManager_MultilingualLabelManager
 * <pre> 
 * This object manages the individual entries in the Multilingual Labels table.
 * </pre>
 * @author Johnny Hausman
 */
class  RowManager_MultilingualLabelManager extends RowManager {

	//CONSTANTS:
	/** The name of the DB Table this class manages. */
    const DB_TABLE = 'site_multilingual_label';
    
    /** The fields in the DB Table this class manages. */
    const FIELD_LIST = 'label_id,page_id,label_key,label_label,label_moddate,language_id';
    
    /** The XML node name for this entry. */
    const XML_NODE_NAME = 'multilingualLabel';
    
    /** The XML element name for a label entry. */
    const XML_ELEMENT_NAME = 'label';
    
    /** The SQL command to create the table for the object*/
    const DB_TABLE_DESCRIPTION = " (  
          label_id int(11) NOT NULL auto_increment,
          page_id int(11) NOT NULL default '0',
          label_key varchar(50) NOT NULL default '',
          label_label text NOT NULL,
          label_moddate timestamp(14) NOT NULL,
          language_id int(11) NOT NULL default '0',
          PRIMARY KEY  (label_id)
            ) TYPE=MyISAM;";

	//VARIABLES:


	//CLASS CONSTRUCTOR
	//************************************************************************
	/**
	 * function __construct
	 * <pre>
	 * Initialize this object.
	 * </pre>
	 * @param $label_id [INTEGER] The unique id of the multilingualLabel we are managing.
	 * @return [void]
	 */
    function __construct( $label_id=-1 ) 
    {
    
        $dbTableName = RowManager_MultilingualLabelManager::DB_TABLE;
        $fieldList = RowManager_MultilingualLabelManager::FIELD_LIST;
        $primaryKeyField = 'label_id';
        $primaryKeyValue = $label_id;
        
        if (( $label_id != -1 ) && ( $label_id != '' )) {
        
            $condition = $primaryKeyField . '=' . $primaryKeyValue;
            
        } else {
            $condition = '';
        }
        $xmlNodeName = RowManager_MultilingualLabelManager::XML_NODE_NAME;
        $this->dbDescription = RowManager_MultilingualLabelManager::DB_TABLE_DESCRIPTION;
        parent::__construct( $dbTableName, $fieldList, $primaryKeyField, $primaryKeyValue, $condition, $xmlNodeName);

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
        //return $this->getValueByFieldName( 'applicant_codename' );
    }
    
    
    
    //************************************************************************
	/**
	 * function createNewEntry
	 * <pre>
	 * Creates a new row entry in the DB table for this object to manage. It 
	 * also updates the Xlation tabel to mark the new entry as needing 
	 * translation.
	 * </pre>
	 * @param $doAllowPrimaryKeyUpdate [BOOL] allow insertion of primary key 
	 * @param $shouldIgnoreXlation [BOOL] allow insertion of primary key 
	 * value if present.
	 * @return [void]
	 */
    function createNewEntry( $doAllowPrimaryKeyUpdate=false, $shouldIgnoreXlation=false ) 
    {   
    
        // make sure label is translated into UnicodeEntities
        $data = $this->getLabel();
        $newData = Unicode_utf8ToUnicodeEntities ($data);
        $this->setLabel( $newData );
        
        parent::createNewEntry( $doAllowPrimaryKeyUpdate );
        
        if (!$shouldIgnoreXlation ) {
        
            $currentPageID = $this->getPageID();
            $currentKey = $this->getKey();
            $currentLanguageID = $this->getLanguageID();
            
            $xlationManager = new RowManager_XLationManager();
            
            // If there are no other pageID + labelKey entries like this one
            // then we need to add xlation entries for all other languages.
            $condition = 'page_id='.$currentPageID;
            if ( $this->isUniqueFieldValue( $currentKey, 'label_key', $condition) ) {
                
                $xlationManager->setLabelID( $this->getID() );
                
                // for each other language in site
                $languageManager = new RowManager_LanguageManager();
                $languageList = $languageManager->getListIterator();
                $languageList->setFirst();
                while( $language = $languageList->getNext() ) {
                    
                    $newLanguageID = $language->getID();
                    if ( $newLanguageID != $currentLanguageID ) {
                
                        // Add Xlation Entry
                        $xlationManager->setLanguageID( $newLanguageID );
                        $xlationManager->createNewEntry();
                    
                    }
                    
                } // next language
                
            } else {
            
                // Since there are other label id's, then look to see
                // if the current entry can substitute for an xlation request
                
                // for each label with matching PageID & Key
                $labelManager = new RowManager_MultilingualLabelManager();
                $labelManager->setPageID( $currentPageID );
                $labelManager->setKey( $currentKey );
                $labelList = $labelManager->getListIterator();
                $labelList->setFirst();
                while( $label = $labelList->getNext() ) {
                
                    // delete any xlation entry with current language_id & 
                    // matching label_id
                    if ($xlationManager->loadByLabelAndLanguage( $label->getID(), $currentLanguageID ) ) {
                        $xlationManager->deleteEntry();
                    }
                    
                } // next label
            
            } // end if isUnique
            
        } // end if !shouldIgnoreXlation
    }
    
    
    
    //************************************************************************
	/**
	 * function isUnique
	 * <pre>
	 * Returns whether or not this label is unique (not already present).
	 * </pre>
	 * @param $pageID [INTEGER] The page_id of the label to check for
	 * @param $key [STRING] the label_key to check
	 * $param $languageID [INTEGER] the language_id to check for
	 * @return [BOOL]
	 */
    function isUnique( $pageID, $key, $languageID ) 
    {
        $condition = 'page_id='.$pageID.' AND language_id='.$languageID;
        return $this->isUniqueFieldValue( $key, 'label_key', $condition );
    }
    
    
    
    //************************************************************************
	/**
	 * function getKey
	 * <pre>
	 * Returns the key of this label.
	 * </pre>
	 * @return [STRING]
	 */
    function getKey() 
    {
        return $this->getValueByFieldName( 'label_key' );
    }
    
    
    
    //************************************************************************
	/**
	 * function getKeyField
	 * <pre>
	 * Returns the key field
	 * </pre>
	 * @return [STRING]
	 */
    function getKeyField() 
    {
        return 'label_key';
    }
    
    
    
    //************************************************************************
	/**
	 * function getLabel
	 * <pre>
	 * Returns the value commonly used for displaying as a Label (Form Grid
	 * rows, Drop List Labels, etc...).
	 * </pre>
	 * @return [STRING]
	 */
    function getLabel() 
    {
        return $this->getValueByFieldName( 'label_label' );
    }
    
    
    
    //************************************************************************
	/**
	 * function getLabelField
	 * <pre>
	 * Returns the field to use in the label routines.
	 * </pre>
	 * @return [STRING]
	 */
    function getLabelField() 
    {
        return "label_label";
    }
    
    
    
    //************************************************************************
	/**
	 * function getLanguageID
	 * <pre>
	 * Returns the ID of the language of this label.
	 * </pre>
	 * @return [INTEGER]
	 */
    function getLanguageID() 
    {
        return (int) $this->getValueByFieldName( 'language_id' );
    }
    
    
    
    //************************************************************************
	/**
	 * function getModDate
	 * <pre>
	 * Returns the Modification Date of this label.
	 * </pre>
	 * @return [STRING]
	 */
    function getModDate() 
    {
        return $this->getValueByFieldName( 'label_moddate' );
    }
    
    
    
    //************************************************************************
	/**
	 * function getPageID
	 * <pre>
	 * Returns the ID of the parent page of this label.
	 * </pre>
	 * @return [INTEGER]
	 */
    function getPageID() 
    {
        return (int) $this->getValueByFieldName( 'page_id' );
    }
    
    
    
    //************************************************************************
	/**
	 * function loadByKeyInfo
	 * <pre>
	 * loads a label by Page, Key and Language ID.
	 * </pre>
	 * @return [BOOL]
	 */
    function loadByKeyInfo( $pageID='', $key='', $languageID='' ) 
    {
        $condition = "";
        if ($pageID != '') {
            $condition = 'page_id='.$pageID;
        }
        
        if ($key != '') {
            if ($condition != '' ) {
                $condition .= ' AND ';
            }
            $condition .= 'label_key="'.$key.'"';
        }
        
        if ($languageID != '') {
            if ($condition != '' ) {
                $condition .= ' AND ';
            }
            $condition .= 'language_id='.$languageID;
        }

        return $this->loadByCondition( $condition );
    }
    
    
    
    //************************************************************************
	/**
	 * function setKey
	 * <pre>
	 * Set the key of this label.
	 * </pre>
	 * @return [STRING]
	 */
    function setKey( $key ) 
    {
        $this->setValueByFieldName( 'label_key', $key );
    }
    
    
    
    //************************************************************************
	/**
	 * function setLabel
	 * <pre>
	 * Set the label data 
	 * </pre>
	 * @param $label [STRING] The label data
	 * @return [void]
	 */
    function setLabel( $label ) 
    {
        return $this->setValueByFieldName( 'label_label', $label );
    }
    
    
    
    //************************************************************************
	/**
	 * function setLanguageID
	 * <pre>
	 * Set the ID of the language of this label.
	 * </pre>
	 * @param $languageID [INTEGER] the id of the language field
	 * @return [void]
	 */
    function setLanguageID( $languageID ) 
    {
        $this->setValueByFieldName( 'language_id', $languageID );
    }
    
    
    
    //************************************************************************
	/**
	 * function setPageID
	 * <pre>
	 * Set the ID of the parent page of this label.
	 * </pre>
	 * @param $pageID [INTEGER] The ID of the page this label belongs to
	 * @return [void]
	 */
    function setPageID( $pageID ) 
    {
        $this->setValueByFieldName( 'page_id', $pageID );
    }
    
    
    
    //************************************************************************
	/**
	 * function updateDBTable
	 * <pre>
	 * Updates the DB table info.
	 * </pre>
	 * @return [void]
	 */
    function updateDBTable() 
    {   
        // make sure label is translated into UnicodeEntities
        $data = $this->getLabel();
        $newData = Unicode_utf8ToUnicodeEntities ($data);
        $this->setLabel( $newData );
    
        parent::updateDBTable();
        
        // Go Through and remove any existing xlation requests for this
        // label entry.
        $currentPageID = $this->getPageID();
        $currentKey = $this->getKey();
        $currentLanguageID = $this->getLanguageID();
        
        $xlationManager = new RowManager_XLationManager();
        
        // for each label with matching PageID & Key
        $labelManager = new RowManager_MultilingualLabelManager();
        $labelManager->setPageID( $currentPageID );
        $labelManager->setKey( $currentKey );
        $labelList = $labelManager->getListIterator();
        $labelList->setFirst();
        while( $label = $labelList->getNext() ) {
        
            // delete any xlation entry with current language_id & 
            // matching label_id
            if ($xlationManager->loadByLabelAndLanguage( $label->getID(), $currentLanguageID ) ) {
                $xlationManager->deleteEntry();
            }
            
        } // next label     
    } 


    	
}

?>