<?php
/**
 * @package RAD
 */ 
/**
 * class PageFieldList
 * <pre> 
 * This object manages the listing of the pagefield table elements.
 * </pre>
 * @author Johnny Hausman
 */
class  PageFieldList {

	//CONSTANTS:
	/** The XML Root Node Name for this list of info. */
    const XML_NODE_NAME = 'PageFieldList';

	//VARIABLES:
	/** @var [OBJECT] The ReadOnlyResultSet obj returned from the RowManager. */
	protected $resultSet;
	

	//CLASS CONSTRUCTOR
	//************************************************************************
	/**
	 * function __construct
	 * <pre>
	 * Initialize the Class ...
	 * </pre>
     * @param $page_id [INTEGER] value used to initialize the list.
     * @param $daobj_id [INTEGER] value used to initialize the list.
     * @param $isForm [INTEGER] value used to initialize the list.
	 * @param $sortBy [STRING] the field name to sort list by
     * @return [void]
	 */
    function __construct( $page_id=-1, $daobj_id=-1, $isForm=-1,  $sortBy='' ) 
    {
        $searchManager = new RowManager_PageFieldManager();
        
        // NOTE: if you need to narrow the field of the search then uncommnet
        // the following and set the proper search criteria.
        $searchManager->setValueByFieldName("page_id", $page_id );
        if ($daobj_id != -1 ) {
            $searchManager->setValueByFieldName("daobj_id", $daobj_id );
        }
        if ($isForm != -1) {
            $searchManager->setValueByFieldName("pagefield_isForm", $isForm );
        }
        
        if ($sortBy == '') {
            $sortBy = 'dafield_id';
        }
        
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
        return $this->resultSet->getNext( new RowManager_PageFieldManager() );
    }  // end classMethod()
    
    
    
    //************************************************************************
	/**
	 * function getNextDataField
	 * <pre>
	 * Returns next Data Field object referenced by the next PageFieldManager 
	 * entry in the list.
	 * </pre>
	 * @return [OBJECT] if exists, FALSE otherwise
	 */
    function getNextDataField() 
    {
        $nextPageField = $this->getNext();
        
        if ($nextPageField) {
            $returnValue = $nextPageField->getDAField();
        } else {
            $returnValue = false;
        }
        return $returnValue;
    }  // end getNextDataField()

    
        
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
	function getXML( $isHeaderIncluded=true, $rootNodeName=PageFieldList::XML_NODE_NAME ) 
	{
        $xmlObject = new XMLObject( $rootNodeName);
        
        $this->resultSet->setFirst();
        while( $item = $this->resultSet->getNext( new RowManager_PageFieldManager() ) ) {
        
            $xmlObject->addXMLObject( $item->getXMLObject() );
        }// end while
        
        return $xmlObject->getXML( $isHeaderIncluded );
	
	} // end getXML()
	
}

?>