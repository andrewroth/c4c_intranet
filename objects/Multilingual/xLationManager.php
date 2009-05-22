<?php
/**
 * @package Multilingual
 */ 
/**
 * class RowManager_XLationManager
 * <pre> 
 * This object manages the Translation (xLation) Table.  This table tracks
 * which labels require updating.
 * </pre>
 * @author Johnny Hausman
 */
class  RowManager_XLationManager extends RowManager {

	//CONSTANTS:
	/** The name of the DB Table this class manages. */
    const DB_TABLE = 'site_multilingual_xlation';
    
    /** The SQL description of the DB Table this class manages. */
    /*
[RAD_DB_TABLE_DESCRIPTION_DOC]     */
    const DB_TABLE_DESCRIPTION = " (
  `xlation_id` int(11) NOT NULL auto_increment,
  `label_id` int(11) NOT NULL default '0',
  `language_id` int(11) NOT NULL default '0',
  PRIMARY KEY  (`xlation_id`),
  KEY `label_id` (`label_id`),
  KEY `language_id` (`language_id`)
) TYPE=MyISAM";
    
    /** The fields in the DB Table this class manages. */
    const FIELD_LIST = 'xlation_id,label_id,language_id';
    
    /** The XML node name for this entry. */
    const XML_NODE_NAME = 'site_multilingual_xlation';
    

	//VARIABLES:


	//CLASS CONSTRUCTOR
	//************************************************************************
	/**
	 * function __construct
	 * <pre>
	 * Initialize this object.
	 * </pre>
	 * @param $xlation_id [INTEGER] The unique id of the site_multilingual_xlation we are managing.
	 * @return [void]
	 */
    function __construct( $xlation_id=-1 ) 
    {
    
        $dbTableName = RowManager_XLationManager::DB_TABLE;
        $fieldList = RowManager_XLationManager::FIELD_LIST;
        $primaryKeyField = 'xlation_id';
        $primaryKeyValue = $xlation_id;
        
        if (( $xlation_id != -1 ) && ( $xlation_id != '' )) {
        
            $condition = $primaryKeyField . '=' . $primaryKeyValue;
            
        } else {
            $condition = '';
        }
        $xmlNodeName = RowManager_XLationManager::XML_NODE_NAME;
        parent::__construct( $dbTableName, $fieldList, $primaryKeyField, $primaryKeyValue, $condition, $xmlNodeName);
        
        $this->dbDescription = RowManager_XLationManager::DB_TABLE_DESCRIPTION;

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
	 * function getLabelField
	 * <pre>
	 * Returns the field to use in the label routines.
	 * </pre>
	 * @return [STRING]
	 */
    function getLabelField() 
    {
        return "xlation_id";
    }
    
    
    
    //************************************************************************
	/**
	 * function loadByLabelAndLanguage
	 * <pre>
	 * loads a Xlation Entry given a label ID and language ID.
	 * </pre>
	 * @return [BOOL]
	 */
    function loadByLabelAndLanguage( $labelID='', $languageID='' ) 
    {
        $condition = '';
        
        if ($labelID != '') {
            $condition = 'label_id='.$labelID;
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
	 * function setLabelID
	 * <pre>
	 * Sets the value of the label_id
	 * </pre>
	 * @param $labelID [INTEGER] the id of the label needing translation
	 * @return [void]
	 */
    function setLabelID($labelID) 
    {
        $this->setValueByFieldName( 'label_id', $labelID );
    }
    
    
    
    //************************************************************************
	/**
	 * function setLanguageID
	 * <pre>
	 * Sets the value of the language_id field
	 * </pre>
	 * @param $languageID [INTEGER] the id the language we need translation
	 * into.
	 * @return [void]
	 */
    function setLanguageID($languageID) 
    {
        $this->setValueByFieldName( 'language_id', $languageID );
    }

    
    	
}

?>