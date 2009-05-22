<?php
/**
 * @package AIobjects	
 */
/**
 * class XMLObject
 * <pre>
 * Written By	:	Johnny Hausman
 * Date		:    18 Aug '04
 *
 * This is a generic XML Object for all the objects in the Web Site.  It
 * provides a basic set of XML output functionality.
 * </pre>
 */
class XMLObject extends SiteObject {

	//	CONSTANTS:
	/** const indentSpacing */
    const SPACING_INDENT = '    ';
	
	//
	//	VARIABLES:
    /** @var [ARRAY] An array of values for this object. The object values are stored in an Array to make it easier for processing into XML. */
		protected $xmlValues;
		
    /** @var [STRING] The XML root node name for this object. */
		protected $xmlNodeName;
		
    /** @var [ARRAY] List of Attributes for this object. */
		protected $xmlAttributes;

    
//
//	CLASS CONSTRUCTOR
//

	//************************************************************************
	/**
	 * This is the class constructor for XMLObject class
	 * @param $nodeName [STRING]
	 * @param $attributeList [ARRAY] An array of key=>value pairs for this 
	 * object's attributes.
	 * @param $isDebugEnabled [BOOLEAN]
	 * @return [void]
	 */
    function __construct( $nodeName='', $attributeList=null, $isDebugEnabled=false ) 
    {
        parent::__construct();
	   
        $this->xmlValues = array();
        $this->xmlNodeName = $nodeName;
        
        $this->xmlAttributes = array();
        if ( is_null($attributeList) == false) {
            $this->xmlAttributes = $attributeList;
        }
        
        if ($isDebugEnabled == true) {
            $this->debugEnable();
        }
	}
	
	

//
//	CLASS FUNCTIONS:
//
		
	
	
	//************************************************************************
	/** 
	 * function addAttribute
	 * <pre>
	 * Creates an Attribute entry for this object.
	 * </pre>
	 * @param $name [STRING] The attribute name we are adding.
	 * @param $value [STRING] The attribute value we are adding.
	 * @return [void]
	 */
    function addAttribute( $name, $value ) 
	{
	   $this->xmlAttributes[ $name ] = $value;
	}
	
	
	
	//************************************************************************
	/** 
	 * function addElement
	 * <pre>
	 * Creates an Element entry for this object.
	 * </pre>
	 * @param $name [STRING] The element name we are adding.
	 * @param $value [STRING] The element value we are adding.
	 * @param $attributes [ARRAY] Array of key=>value pairs for the attributes.
	 * @return [void]
	 */
    function addElement( $name, $value, $attributes=null ) 
	{
	   $this->xmlValues[] = new XMLElement( $name, $value, $attributes);	
	}
	
	
	
	//************************************************************************
	/** 
	 * function addXmlObject
	 * <pre>
	 * Saves an XML Object (XMLObject or XMLElement) as an entry in this object.
	 * </pre>
	 * @param $xmlObject [OBJECT] The XMLObject we want to add. 
	 * @return [void]
	 */
    function addXmlObject( $xmlObject ) 
	{
	   $this->xmlValues[] = $xmlObject;
	}
	
	
	
	//************************************************************************
	/** 
	 * function clearXMLValues
	 * <pre>
	 * initialize the xmlValues array to an empty array.
	 * </pre>
	 * @return [void]
	 */
    function clearXMLValues( ) 
	{
         $this->xmlValues = array();
	}
	
	
	
	//************************************************************************
	/** 
	 * function getNodeName
	 * <pre>
	 * Returns the object's xmlNodeName.
	 * </pre>
	 * @return [STRING]
	 */
	function getNodeName() 
	{
	   return $this->xmlNodeName;	
	}
	
	
	
	//************************************************************************
	/** 
	 * function getValues
	 * <pre>
	 * Returns the object's Values array.
	 * </pre>
	 * @return [ARRAY]
	 */
    function getValues( ) 
	{
        return $this->xmlValues;
	}
	

	
	//************************************************************************
	/** 
	 * function getXML
	 * <pre>
	 * Generates an XML document from the object's Values array.
	 * </pre>
	 * @param $isHeaderIncluded [BOOL] Determines if we include the '<?xml version="1.0"?>' header.
	 * @param $rootNodeName [STRING] The XML root node name.
	 * @return [STRING]
	 */
	function getXML( $isHeaderIncluded=true, $rootNodeName='', $spaces='' ) 
	{
        
        // Initialize Output to empty.
        $output = '';
        
        // if header requested then add header
        if ($isHeaderIncluded) {
            $output .= $spaces.'<?xml version="1.0"?>'."\n";
        }
        
        // if rootNodeName provided then use that
        if ( $rootNodeName != '' ) {
            $nodeName = $rootNodeName;
        }
        else {
        // else use Object's xmlNodeName
            $nodeName = $this->xmlNodeName;
        }
        
        //$this->debugEnable();
        $this->debugDumpArray( $this->xmlValues, 'this->xmlValues');
        
        
        // Build Attribute List
        $attributeList = '';
        foreach( $this->xmlAttributes as $key=>$value) {
        
            $attributeList .= ' '.$key.'="'.$value.'" ';
        }
        
        // Now print Node Name
        $output .= $spaces."<".$nodeName.$attributeList.">\n";

        // for each Object in this one
        for( $indx=0; $indx<count($this->xmlValues); $indx++) {
            $output .= $this->xmlValues[ $indx ]->getXML( false, '', $spaces.XMLObject::SPACING_INDENT);
        }
        $output .= $spaces."</".$nodeName.">\n";
        
        return $output;
	}
	
	
	
	//************************************************************************
	/** 
	 * function setNodeName
	 * <pre>
	 * Stores this objects root node name.
	 * </pre>
	 * @param $name [STRING] The new Node Name.
	 * @return [void]
	 */
    function setNodeName( $name ) 
	{
	   $this->xmlNodeName =  $name;	
	}
	
	
	
	//************************************************************************
	/** 
	 * function setValues
	 *<pre>
	 * Stores the given array of XML Objects.
	 *</pre>
	 * @param $values [ARRAY] Array of XMLObjects.
	 * @return [void]
	 */
    function setValues( $values ) 
	{
	   $this->xmlValues =  $values;	
	}
	
	

}




/**
 * class XMLElement
 * <pre> 
 * This class represents the most basic element of an XML  description.
 * </pre>
 * @author Johnny Hausman
 */
class  XMLElement {

	//CONSTANTS:

	//VARIABLES:
	/** @var [STRING] The element's node name. eg <elementName>Content</elementName> */
	protected $elementName;

	/** @var [STRING] The data for this element. */
	protected $elementData;
	
	/** @var [ARRAY] An ARRAY of attributes in Key=>Value pairs.  */
	protected $elementAttributes;

	//CLASS CONSTRUCTOR
	//************************************************************************
	/**
	 * function __construct
	 * <pre>
	 * Initialize the object
	 * </pre>
	 * @param $name [STRING] The Element's Name
	 * @param $data [STRING] The Element's Data
	 * @param $attributes [ARRAY] OPTIONAL Element Attributes
	 * @return [void]
	 */
    function __construct($name, $data, $attributes=null ) 
    {
        $this->elementName = $name;
        $this->elementData = $data;
        if (is_null($attributes) == false) {
            $this->elementAttributes = $attributes;
        } else {
            $this->elementAttributes = array();
        }
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
	 * function getData
	 * <pre>
	 * Returns the element's data
	 * </pre>
	 * @return [STRING]
	 */
    function getData() 
    {
        return $this->elementData;
    } 
    
    
    
    //************************************************************************
	/**
	 * function getName
	 * <pre>
	 * Returns the element's name
	 * </pre>
	 * @return [STRING]
	 */
    function getName() 
    {
        return $this->elementName;
    }  
    
    
    
    //************************************************************************
	/** 
	 * function getXML
	 * <pre>
	 * Generates an XML document from the object's Values array.
	 * </pre>
	 * @param $isHeaderIncluded [BOOL] Determines if we include the '<?xml version="1.0"?>' header.
	 * @param $rootNodeName [STRING] The XML root node name.
	 * @return [STRING]
	 */
	function getXML( $isHeaderIncluded=true, $rootNodeName='', $spaces='' ) 
	{
        // Initialize Output to empty.
        $output = '';
        
        
        // if rootNodeName provided then use that
        if ( $rootNodeName != '' ) {
            $nodeName = $rootNodeName;
        }
        else {
        // else use this element's name
            $nodeName = $this->getName();
        }
        
        
        // Build Attribute List
        $attributeList = '';
        foreach( $this->elementAttributes as $key=>$value) {
        
            $attributeList .= ' '.$key.'="'.$value.'" ';
        }
        
        // compile element data
        // add opening tag
        $output = $spaces."<".$nodeName.$attributeList.">";
        
        // add data
        // enclose in CDATA tag if data contains XML troublesome data
///        $data = $this->getData();
//        if ( !( strpos( $data, '<' ) === false ) || !(strpos( $data, '[' ) === false ) ) {
//echo 'must have been true ['.$data.']  strpos( < )=['.strpos( $data, '<' ).'...<br>';
//            $data = "<![CDATA[".$this->getData()."]]>";
//        }
//        $output .= $data;
        
        $output .= "<![CDATA[".$this->getData()."]]>";
        // TODO resolve this
        // $output .= $this->getData();
        
        // add closing tag
        $output .= "</".$nodeName.">\n";
        
        return $output;
	}
    
    
    
    //************************************************************************
	/**
	 * function setName
	 * <pre>
	 * Sets the element's name
	 * </pre>
	 * @param $name [STRING] the new name for this element
	 * @return [void]
	 */
    function setName( $name ) 
    {
        $this->elementName = $name;
    }
	
}


?>