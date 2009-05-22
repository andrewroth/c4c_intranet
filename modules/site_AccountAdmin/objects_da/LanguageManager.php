<?php
/**
 * @package AIobjects
 */ 
/**
 * class RowManager_LanguageManager
 * <pre> 
 * Defines the valid languages for display in the site.
 * </pre>
 * @author Johnny Hausman
 */
class  RowManager_LanguageManager extends RowManager {

	//CONSTANTS:
	/** The name of the DB Table this class manages. */
    const DB_TABLE = 'accountadmin_language';
    
    /** The SQL description of the DB Table this class manages. */
    /*
     * language_id [INTEGER]  Primary Key for this table.
     * language_key [STRING]  The Lable lookup key for this language.
     */
    const DB_TABLE_DESCRIPTION = " (
  language_id int(11) NOT NULL  auto_increment,
  language_key varchar(25) NOT NULL  default '',
  language_code varchar(2) NOT NULL  default '',
  PRIMARY KEY (language_id)
) TYPE=MyISAM";
    
    /** The fields in the DB Table this class manages. */
    const FIELD_LIST = 'language_id,language_key,language_code';
    
    /** The Multilingual Page Key for this object's translations. */
    const MULTILINGUAL_PAGE_KEY = 'language';
    
    /** The XML node name for this entry. */
    const XML_NODE_NAME = 'language';
    

	//VARIABLES:


	//CLASS CONSTRUCTOR
	//************************************************************************
	/**
	 * function __construct
	 * <pre>
	 * Initialize this object.
	 * </pre>
	 * @param $languageID [INTEGER] The unique id of the language we are managing.
	 * @return [void]
	 */
    function __construct( $languageID=-1 ) 
    {
    
        $dbTableName = RowManager_LanguageManager::DB_TABLE;
        $fieldList = RowManager_LanguageManager::FIELD_LIST;
        $primaryKeyField = 'language_id';
        $primaryKeyValue = $languageID;
        
        if (( $languageID != -1 ) && ( $languageID != '' )) {
        
            $condition = $primaryKeyField . '=' . $primaryKeyValue;
            
        } else {
            $condition = '';
        }
        $xmlNodeName = RowManager_LanguageManager::XML_NODE_NAME;
        parent::__construct( $dbTableName, $fieldList, $primaryKeyField, $primaryKeyValue, $condition, $xmlNodeName);
        
        $this->dbDescription = RowManager_LanguageManager::DB_TABLE_DESCRIPTION;
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
	 * function getCode
	 * <pre>
	 * Returns the language Code.
	 * </pre>
	 * @return [STRING]
	 */
    function getCode() 
    {
        return $this->getValueByFieldName( 'language_code' );
    }
    
    
    
    //************************************************************************
	/**
	 * function getKey
	 * <pre>
	 * Returns the language key.
	 * </pre>
	 * @return [STRING]
	 */
    function getKey() 
    {
        return $this->getValueByFieldName( 'language_key' );
    }
    
    
    
    //************************************************************************
	/**
	 * function getKeyField
	 * <pre>
	 * Returns the field for the language key.
	 * </pre>
	 * @return [STRING]
	 */
    function getKeyField() 
    {
        return 'language_key' ;
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
        return "language_key";
    }
    
    
    
    //************************************************************************
	/**
	 * function getRowLabelBridge
	 * <pre>
	 * The language manager needs a special RowLabelBridge so it doesn't get
	 * the language_id's confused between tables.  There is a special 
	 * LanguageLabelBridge designed to take care of this.
	 * </pre>
	 * @param $multilingualContext [OBJECT] a MultiLingualManager defined for
	 * this rowLabelBridge.  Must at least have the viewer's languageID set.
	 * @return [OBJECT]
	 */
	 function getRowLabelBridge( $multilingualContext ) 
	 {
	   if ( ! $multilingualContext->isContextSet()) {
	       $multilingualContext->loadContextByPageKey( $this->getXMLNodeName() );
	   }
	   return new LanguageLabelBridge($this, $multilingualContext );
	 }
    
    
    
    //************************************************************************
	/**
	 * function setCode
	 * <pre>
	 * Sets the language Code.
	 * </pre>
	 * @param $code [STRING] the new language_code value
	 * @return [void]
	 */
    function setCode( $code ) 
    {
        $this->setValueByFieldName( 'language_code', $code );
    }
    
    
    
    //************************************************************************
	/**
	 * function setID
	 * <pre>
	 * Sets the language ID.
	 * </pre>
	 * @param $id [STRING] the new language_id value
	 * @return [void]
	 */
    function setID( $id ) 
    {
        $this->setValueByFieldName( 'language_id', $id );
    }
    
    
    
    //************************************************************************
	/**
	 * function setKey
	 * <pre>
	 * Sets the language key.
	 * </pre>
	 * @param $key [STRING] the new language_key value
	 * @return [void]
	 */
    function setKey( $key ) 
    {
        $this->setValueByFieldName( 'language_key', $key );
    }

    
    	
}

?>