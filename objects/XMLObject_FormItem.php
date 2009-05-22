<?php
/**
 * @package AIObjects
 */ 
/**
 * class XMLObject_FormItem
 * <pre> 
 * This object prepares data to represent a form item in a template.
 * </pre>
 * @author Johnny Hausman
 */
class  XMLObject_FormItem extends XMLObject {

	//CONSTANTS:
	/** The main form item XML node tag */
    const XML_NODE_FORMITEM = 'formItem';
    
    /** The name xml element tag */
    const XML_ELEMENT_NAME = 'name';
    
    /** The value xml element tag */
    const XML_ELEMENT_VALUE = 'value';
    
    /** The error xml element tag */
    const XML_ELEMENT_ERROR = 'error';

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
    function __construct($name, $value, $error) 
    {
        parent::__construct(XMLObject_FormItem::XML_NODE_FORMITEM);
        
        $this->addElement( XMLObject_FormItem::XML_ELEMENT_NAME, $name);
        $this->addElement( XMLObject_FormItem::XML_ELEMENT_VALUE, $value);
        $this->addElement( XMLObject_FormItem::XML_ELEMENT_ERROR, $error);
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
	
}

?>