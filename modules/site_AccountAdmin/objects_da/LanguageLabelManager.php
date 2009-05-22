<?php
/**
 * @package AccountAdmin
 */ 
/**
 * class RowLabelBridge_LanguageLabelManager
 * <pre> 
 * This object manages the relationship between an entry in the language table
 * and it's multilingual label description.
 * </pre>
 * @author Johnny Hausman
 * date: 14 April 2005
 */
class  RowLabelBridge_LanguageLabelManager extends RowLabelBridge {

	//CONSTANTS:
    
    /** The XML node name for this entry. */
    const XML_NODE_NAME = 'LanguageLabelManager';
    

	//VARIABLES:


	//CLASS CONSTRUCTOR
	//************************************************************************
	/**
	 * function __construct
	 * <pre>
	 * Initialize this object.
	 * </pre>
	 * @param $language_id [INTEGER] The unique id of the dataManager.
	 * @param $languageID [INTEGER] The desired language id of the viewer
	 * @param $manager [OBJECT] A Multilingual Manager object for retrieving the label manager object.  (Highly suggest passing one in for creating multiple objects ... like the list object)
	 * @return [void]
	 */
    function __construct( $language_id=-1, $languageID='', $manager=null ) 
    {
    
        $dataManager = new RowManager_LanguageManager( $language_id );
/*        
echo 'language_id=['.$language_id.']<br>';
if ($dataManager->isLoaded()){
echo 'dataManager is Loaded<br>';
} else {
echo 'dataManager is NOT loaded <br>';
}
*/
        // if a manager object was not provided then create it
        if (is_null( $manager )) {
            $seriesKey = SITE_LABEL_SERIES_SITE;
            $pageKey = RowManager_LanguageManager::MULTILINGUAL_PAGE_KEY;
            $manager = new MultilingualManager( $languageID, $seriesKey, $pageKey );
        }
        
        $xmlNodeName = RowLabelBridge_LanguageLabelManager::XML_NODE_NAME;
        
        parent::__construct( $dataManager, $manager, $xmlNodeName );
    
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
	 * function getLabel
	 * <pre>
	 * Returns the value commonly used for displaying as a Label (Form Grid
	 * rows, Drop List Labels, etc...).
	 * </pre>
	 * @return [STRING]
	 */
    function getLabel() 
    {
        return $this->labelManager->getLabel();
    } 
    
    
    
    //************************************************************************
	/**
	 * function getLabelKey
	 * <pre>
	 * Returns the properly formatted label key.
	 * </pre>
	 * @return [STRING]
	 */
    function getLabelKey() 
    {
        return '['.$this->dataManager->getKey().']';
    }
    
    
    
    //************************************************************************
	/** 
	 * function getXMLObject
	 * <pre>
	 * Generates an XML Object from the object's Values array.
	 * NOTE: I'm overridding the parent method due to special case where
	 * the dataManager & labelManager share the same field name (dataManager's
	 * primary key). 
	 * </pre>
	 * @param $isHeaderIncluded [BOOL] Determines if we include the '<?xml version="1.0"?>' header.
	 * @param $rootNodeName [STRING] The XML root node name.
	 *
	 * @return [OBJECT] XMLObject
	 */
	function getXMLObject( $isHeaderIncluded=true, $rootNodeName='' ) 
	{
	
        // use member root node name if one is not provided.
        if ($rootNodeName == '') {
            $rootNodeName = $this->xmlNodeName;
        }
        
        // NOTE: Big picture here, is to make the two seperate XML 
        // descriptions to be 1 blended description.
        
        // get the XML objects of the dataManager & labelManager
        $dataManagerXMLObj = $this->dataManager->getXMLObject();
        $labelManagerXMLObj = $this->labelManager->getXMLObject();
        
        // Get their values as Arrays
        $dataManagerValues = $dataManagerXMLObj->getValues();
        $labelManagerValues = $labelManagerXMLObj->getValues();

        // NOTE:
        // in this case, labelManager contains the dataManager's primary key
        // as the foreign key.  In our application we need both values. So
        // here we rename the labelManager's foreign key instance to 
        // 'viewerLanguage_id'
        $combinedValues = $dataManagerValues;
        foreach ($labelManagerValues as $xmlElement ) {
        
            $key = $xmlElement->getName();
            
            if ( $key == 'language_id' ) {

                $xmlElement->setName( 'viewerLanguage_id' );
            }
            
            $combinedValues[] =  $xmlElement;
            
        }    

        // create new XML Object for output
        $xmlObject = new XMLObject( $rootNodeName );
        
        // set those combined values as this Blended XML object
        $xmlObject->setValues( $combinedValues );
        
        return $xmlObject;
        
    } 
    
    
    
    //************************************************************************
	/**
	 * function loadFromArray
	 * <pre>
	 * Loads the objects from a given array of data.
	 * NOTE: because we are dealing with a confilct of keys between the 
	 * dataManager & the labelManager (both have a language_id field) we
	 * have to override the parent function and correct this here.
	 * </pre>
	 * @param $values [ARRAY] array of data: array( $field=>$value,...,$field=>$value);
	 * @return [void]
	 */
    function loadFromArray($values) 
    {
        // insert a language_id for the dataManager to use if not already 
        // provided
        $fieldName = $this->dataManager->getPrimaryKeyField();
        if( !isset( $values[ $fieldName ] ) ) {
            $values[ $fieldName ] = $this->dataManager->getPrimaryKeyValue();
        }
        $this->dataManager->loadFromArray( $values );
        
        // remap the language_id key to it's proper value.
        if (isset( $values[ 'viewerLanguage_id' ] ) ) {
            $values[ 'language_id' ] = $values[ 'viewerLanguage_id' ];
        }
        $values[ 'label_key' ] = $this->getLabelKey();
        $this->labelManager->loadFromArray( $values );

        // if the array didn't load the label object then load it from the 
        // dataManager info.
        if (!$this->labelManager->isLoaded() ) {
            $this->loadLabelManager();
        }
    }

}

?>