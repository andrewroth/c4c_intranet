<?php
/**
 * @package AIObjects
 */ 
/**
 * class XMLObject_RowList
 * <pre> 
 * This object prepares data to represent a form item in a template.
 * </pre>
 * @author Johnny Hausman
 */
class  XMLObject_RowList extends XMLObject {

	//CONSTANTS:
	/** The main rowlist XML node tag */
    const XML_NODE_ROWLIST = 'rowList';
    
    /** The main row item XML node tag */
    const XML_NODE_ROW = 'row';
    
    /** The name xml element tag */
    const XML_ELEMENT_NAME = 'name';
    
    /** The value xml element tag */
    const XML_ELEMENT_VALUE = 'value';

	//VARIABLES:


	//CLASS CONSTRUCTOR
	//************************************************************************
	/**
	 * function __construct
	 * <pre>
	 * iniitalizes this object
	 * </pre>
	 * @param $name [STRING] the form item's name
	 * @param $value [STRING] the form item's value
	 * @param $error [STRING] the form item's error 
	 * @return [void]
	 */
    function __construct( ) 
    {
        parent::__construct(XMLObject_RowList::XML_NODE_ROWLIST);
        
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
	 * function addRowData
	 * <pre>
	 * adds a row entry in this XML object.
	 * </pre>
	 * @param $label [STRING] the row label 
	 * @param $id [STRING] the row id value
	 * @return [void]
	 */
    function addRowData($label, $id) 
    {
        $xmlRow = new XMLObject( XMLObject_RowList::XML_NODE_ROW );
        $xmlRow->addElement(XMLObject_RowList::XML_ELEMENT_NAME, $label );
        $xmlRow->addElement(XMLObject_RowList::XML_ELEMENT_VALUE, $id );
        
        $this->addXMLObject( $xmlRow ); 
    }	

	
}

?>