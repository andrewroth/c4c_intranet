<?php
/**
 * @package AccountAdmin
 */ 
/**
 * class LanguageLabelBridge
 * <pre> 
 * This object implements a special RowLabelBridge for use in handling the
 * entry of the language table.  Implementing a RowLabelBridge for the language
 * table creates a conflict not handled by the standard RowLabelBridge: 
 * namely that both tables have a language_id field that must be managed 
 * seperatly.
 * </pre>
 * @author Johnny Hausman
 */
class  LanguageLabelBridge extends RowLabelBridge {

	//CONSTANTS:
    const KEY_VIEWER_LANGUAGE_ID = 'viewerLangaugeID';

	//VARIABLES:
	
	/** @var [INTEGER] Viewer Language ID [set when dataManager objects have a field that conflicts with the language_id field of the labelManager] */
	protected $viewerLangaugeID;
	


	//CLASS CONSTRUCTOR
	//************************************************************************
	/**
	 * function __construct
	 * <pre>
	 * Initialize this object.  The different manager objects are expected to
	 * be provided from the child of this object.
	 * </pre>
	 * @param $rowManager [OBJECT] The Row Manager object.
	 * @param $multiLingualManager [OBJECT] Multilingual Manager Object
	 * @param $xmlNodeName [STRING] The xml node name for this object
	 * @return [void]
	 */
    function __construct( $rowManager, $multiLingualManager, $xmlNodeName='' ) 
    {

        parent::__construct( $rowManager, $multiLingualManager, $xmlNodeName );
    
        // viewer's langaugeID is tracked manually
        $this->viewerLangaugeID = -1;
        
        // now we need to correct the Field Mappings since the label.language_id
        // has overwritten the language.language_id
        $fieldName = $rowManager->getPrimaryKeyField();
        $this->fieldMapping[ $fieldName ] = $rowManager->getTableName().'.'.$fieldName;
        $this->fieldList = implode( ',', $this->fieldMapping);

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
	 * Creates a new table entry in the DB for these objects to manage.
	 * </pre>
     * @param $doAllowPrimaryKeyUpdate [BOOL] allow insertion of primary key 
	 * @return [void]
	 */
    function createNewEntry( $doAllowPrimaryKeyUpdate=false ) 
    {   
        parent::createNewEntry( $doAllowPrimaryKeyUpdate, $this->viewerLangaugeID);

    }
    
    
    
    //************************************************************************
	/**
	 * function getArrayOfValues
	 * <pre>
	 * Returns an array of combined values from the dataManager & labelManager.
	 * </pre>
	 * @return [ARRAY]
	 */
    function getArrayOfValues() 
    {   
    
        $resultArray = array();
        
        $valuesArray = $this->dataManager->getArrayOfValues();
        $resultArray = array_merge($resultArray, $valuesArray);

        // now gather the labelManager array of values but don't allow
        // the language_id to overwrite the dataManager's language_id
        $valuesArray = $this->labelManager->getArrayOfValues();
        unset( $valuesArray[ 'language_id' ] );
        $resultArray = array_merge($resultArray, $valuesArray);
        
        // now add in any remaining rowManagers in group
        for( $indx=2; $indx<count($this->rowManagerList); $indx++) {
            
            $resultArray = array_merge( $resultArray, $this->rowManagerList[ $indx ]->getArrayOfValues() );
        }
        
        return $resultArray;
    } 
       
    
    
    //************************************************************************
	/**
	 * function getViewerLanguageIDKey
	 * <pre>
	 * Returns the key to use for hiding the viewer's langauge_id in the 
	 * values arrays.
	 * </pre> 
	 * @return [STRING]
	 */
    function getViewerLanguageIDKey( ) 
    {   
        return LanguageLabelBridge::KEY_VIEWER_LANGUAGE_ID;
    }
    
    
    
    //************************************************************************
	/**
	 * function loadFromArray
	 * <pre>
	 * Loads the objects from a given array of data.
	 * </pre>
	 * @param $values [ARRAY] array of data: array( $field=>$value,...,$field=>$value);
	 * @return [void]
	 */
    function loadFromArray($values) 
    {
        // initialize all managed rowMangers with these values
        parent::loadFromArray( $values );
        
        // now if there is a hidden viewerLangaugeIDKey in the values
        $key = $this->getViewerLanguageIDKey();
        if ( isset( $values[ $key ] ) ) {
        
            // update labelManager with this value 
            $this->labelManager->setLanguageID( $values[ $key ] );
            $this->viewerLangaugeID = $values[ $key ];
            
        }
        
    }
    
    
    
   //************************************************************************
	/**
	 * function setViewerLanguageID
	 * <pre>
	 * sets the viewerLanguageID.
	 * </pre>
	 * @param $languageID [INTEGER] ID of the viewers Language ID
	 * @return [void]
	 */
    function setViewerLanguageID($languageID) 
    {
        $this->viewerLanguageID = (int) $languageID;
    }
    

}

?>