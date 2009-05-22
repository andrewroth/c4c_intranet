<?php
/**
 * @package [ModuleName]
 */ 
/**
 * class [DAObj]
 * <pre> 
 * [DAObjDescription]
 * </pre>
 * @author [CreatorName]
 */
class  [DAObj] {

	//CONSTANTS:
	/** The XML Root Node Name for this list of info. */
    const XML_NODE_NAME = '[DAObj]';

	//VARIABLES:
	/** @var [OBJECT] The ReadOnlyResultSet obj returned from the RowManager. */
	protected $resultSet;
	
	/** @var [OBJECT] A multilingual manager to be shared among the entries. */
	protected $multiLingualManager;
	
	/** @var [INTEGER] The language id of the labels to work with. */
	protected $languageID;
	

	//CLASS CONSTRUCTOR
	//************************************************************************
	/**
	 * function __construct
	 * <pre>
	 * Initialize the Class ...
	 * </pre>
[RAD_INITVAR_DOC]	 * @param $sortBy [STRING] the field name to sort list by
     * @return [void]
	 */
    function __construct( /*[RAD_INITVAR_PARAM]*/ $languageID, $sortBy='' ) 
    {
        $this->languageID = $languageID;
        
        $seriesKey = SITE_LABEL_SERIES_SITE;
        $pageKey = RowManager_LanguageManager::MULTILINGUAL_PAGE_KEY;
        $this->multiLingualManager = new MultilingualManager( $languageID, $seriesKey, $pageKey );
        
        $searchManager = new RowLabelBridge_[DAObj_ROW_MGR](-1, $this->languageID, $this->multiLingualManager);
        
        // NOTE: if you need to narrow the field of the search then uncommnet
        // the following and set the proper search criteria.
/*[RAD_INITVAR_CODE]*/        //$searchManager->setValueByFieldName('module_isCommonLook', '1' );
        $searchManager->setSortOrder( $sortBy );
        
        $this->resultSet = $searchManager->find();
        
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
    }  // end classMethod()
    
    
    
    //************************************************************************
	/**
	 * function setFirst
	 * <pre>
	 * Sets the list pointer to the first object.
	 * </pre>
	 * @return [void]
	 */
    function setFirst() 
    {
        $this->resultSet->setFirst();
    }  // end classMethod()
    
    
    
    //************************************************************************
	/**
	 * function getDropListArray
	 * <pre>
	 * Returns the list Objects in an array (used by form templates for drop
	 * lists).
	 * </pre>
	 * @param $labels [OBJECT] a multilingual label object for converting 
	 * label into the current language.
	 * @return [ARRAY] if exists, FALSE otherwise
	 */
    function getDropListArray( $labels=null ) 
    {
        // create an empty array to fill out
        $resultArray = array();
        
        // for each item in the list
        $this->setFirst();
        while( $item = $this->getNext() ) {
        
            // if a label object provided then 
            if ( $labels ) {
            
                // translate item label
                $currentLabel = $labels->getLabel( '['.$item->getLabel().']');
                $resultArray[ $item->getID() ] = $currentLabel;
                
            } else {
            // else 
            
                // store item label as is
                $resultArray[ $item->getID() ] = $item->getLabel();
            }
        }
        
        // return result array 
        return $resultArray;
        
    }  // end getDropListArray()
    
    
    
    //************************************************************************
	/**
	 * function getNext
	 * <pre>
	 * Returns next object in the list.
	 * </pre>
	 * @return [OBJECT] if exists, FALSE otherwise
	 */
    function getNext() 
    {
        return $this->resultSet->getNext( new RowLabelBridge_[DAObj_ROW_MGR](-1, $this->languageID, $this->multiLingualManager) );
    }  // end classMethod()

    
        
    //************************************************************************
	/** 
	 * function getXML
	 *
	 * Generates an XML document from the list of applicants.
	 *
	 * @param $isHeaderIncluded [BOOL] Determines if we include the '<?xml version="1.0"?>' header.
	 * @param $rootNodeName [STRING] The XML root node name.
	 *
	 * @return [STRING] Returns an XML formatted string.
	 */
	function getXML( $isHeaderIncluded=true, $rootNodeName=[DAObj]::XML_NODE_NAME ) 
	{
        $xmlObject = new XMLObject( $rootNodeName);
        
        $this->resultSet->setFirst();
        while( $item = $this->resultSet->getNext( new RowLabelBridge_[DAObj_ROW_MGR]( -1, $this->languageID, $this->multiLingualManager) ) ) {
        
            $xmlObject->addXMLObject( $item->getXMLObject() );
        }// end while
        
        return $xmlObject->getXML( $isHeaderIncluded );
	
	} // end getXML()
	
}

?>