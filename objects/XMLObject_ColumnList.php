<?php
/**
 * @package AIObjects
 */ 
/**
 * class XMLObject_ColumnList
 * <pre> 
 * This object prepares data to represent a form item in a template.
 * </pre>
 * @author Johnny Hausman
 */
class  XMLObject_ColumnList extends XMLObject {

	//CONSTANTS:
	/** The main rowlist XML node tag */
    const XML_NODE_COLUMNLIST = 'colList';
    
    /** The main row item XML node tag */
    const XML_NODE_COL = 'col';
    
    /** The heading xml element tag */
    const XML_ELEMENT_HEADING = 'heading';
    
    /** The value xml element tag */
    const XML_ELEMENT_FIELDNAME = 'fieldName';

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
        parent::__construct(XMLObject_ColumnList::XML_NODE_COLUMNLIST);
        
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
	 * function addColumnData
	 * <pre>
	 * adds a row entry in this XML object.
	 * </pre>
	 * @param $heading [STRING] the row label 
	 * @param $fieldName [STRING] the row id value
	 * @return [void]
	 */
    function addColumnData($heading, $fieldName) 
    {
        $xmlRow = new XMLObject( XMLObject_ColumnList::XML_NODE_COL );
        $xmlRow->addElement(XMLObject_ColumnList::XML_ELEMENT_HEADING, $heading );
        $xmlRow->addElement(XMLObject_ColumnList::XML_ELEMENT_FIELDNAME, $fieldName );
        
        $this->addXMLObject( $xmlRow ); 
    }	

	
}

?>