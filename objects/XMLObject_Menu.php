<?php
/**
 * @package AIObjects
 */ 
/**
 * class XMLObject_Menu
 * <pre> 
 * This class creates the proper XML data for describing the Menu of an 
 * application.
 * </pre>
 * @author Johnny Hausman
 */
class  XMLObject_Menu extends XMLObject {

	//CONSTANTS:
	/** const ROOT_NODE_MENU The Root Node name for the Menu data */
    const ROOT_NODE_MENU = 'menu';
    
    /** const NODE_ITEM The Element Node name for a menu item */
    const NODE_ITEM = 'item';
    
    /** const ITEM_TYPE_LINK The item type key for a Link item */
    const ITEM_TYPE = 'type';
    
    /** const ITEM_TYPE_LINK The item type key for a Link item */
    const ITEM_TYPE_LINK = 'link';
    
    /** const ITEM_TYPE_LINK_LABEL The label key for a Link item */
    const ITEM_TYPE_LINK_LABEL = 'label';
    
    /** const ITEM_TYPE_LINK_LINK The link key for a Link item */
    const ITEM_TYPE_LINK_LINK = 'link';
    
    /** const ITEM_TYPE_LIST The item type key for a List item */
    const ITEM_TYPE_JUMPLIST = 'jumplist';

	//VARIABLES:
	/** @var [classvariable1 type] [optional description of classvariable1 ] */
	var $classvariable1;

	/** @var [classvariable2 type] [optional description of  classvariable2] */
	var $classvariable2;

	//CLASS CONSTRUCTOR
	//************************************************************************
	/**
	 * function __construct
	 * <pre>
	 * Prepare the Object for use.
	 * </pre>
	 * @param $param1 [$param1 type] [optional description of $param1]
	 * @param $param2 [$param2 type] [optional description of $param2]
	 * @return [returnValue, can be void]
	 */
    function __construct() 
    {
        // CODE
        parent::__construct( XMLObject_Menu::ROOT_NODE_MENU );
        
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
	 * function addLink
	 * <pre>
	 * Adds a link item to the menu
	 * </pre>
	 * @param $label [STRING] The label to display for the link.
	 * @param $link [STRING] The actual HREF link 
	 * @return [void]
	 */
    function addLink($label, $link) 
    {
        $xmlObject = new XMLObject( XMLObject_Menu::NODE_ITEM );
        $xmlObject->addElement( XMLObject_Menu::ITEM_TYPE, XMLObject_Menu::ITEM_TYPE_LINK);
        $xmlObject->addElement(XMLObject_Menu::ITEM_TYPE_LINK_LABEL, $label);
        $xmlObject->addElement(XMLObject_Menu::ITEM_TYPE_LINK_LINK, $link);
        
        $this->addXmlObject( $xmlObject );
        
    }   // end addLink()
	
}

?>