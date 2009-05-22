<?php
/**
 * @package AIobjects
 */ 
/**
 * class XMLObject_AdminBox
 * <pre> 
 * The XML object for managing the info for an Admin Box
 * </pre>
 * @author Johnny Hausman
 */
class  XMLObject_AdminBox extends XMLObject {

	//CONSTANTS:
	/** The XML root node value for this object */
    const XML_NODE_ROOT = 'adminBox';
    
    /** The XML data row element value for this object */
    const XML_ELEMENT_EDITID = 'editID';
    
    /** The XML heading node value for this object */
    const XML_NODE_HEADING = 'headings';
    
    /** The XML heading element value for this object */
    const XML_ELEMENT_HEADING = 'heading';
    
    /** The XML data node value for this object */
    const XML_NODE_DATA = 'data';
    
    /** The XML data row element value for this object */
    const XML_NODE_DATAROW = 'row';
    
    /** The XML data value element value for this object */
    const XML_ELEMENT_DATAUID = 'uid';
    
    /** The XML data value element value for this object */
    const XML_ELEMENT_DATAVALUE = 'value';
    
    /** The XML Form node value for this object */
    const XML_NODE_FORM = 'form';
    
    /** The XML Form item NODE value for this object */
    const XML_NODE_FORMITEM = 'item';
    
    /** The XML Form item's name element value for this object */
    const XML_ELEMENT_FORMITEM_NAME = 'name';
    
    /** The XML Form item's default value for this object */
    const XML_ELEMENT_FORMITEM_VALUE = 'defaultValue';
    
    /** The XML Form item's error for this object */
    const XML_ELEMENT_FORMITEM_ERROR = 'errorMSG';
    
    /** The XML Form item's type for this object */
    const XML_ELEMENT_FORMITEM_TYPE = 'type';
    
    /** The XML Form Date Item's start value for this object */
    const XML_ELEMENT_FORMITEM_DATE_STARTYEAR = 'startYear';
    
    /** The XML Form Date Item's start value for this object */
    const XML_ELEMENT_FORMITEM_DATE_ENDYEAR = 'endYear';
    
    
    /** The XML Form List Item's node for it's options */
    const XML_NODE_FORMITEM_LIST_ITEM = 'item';
    
    /** The XML Form List Item's Label element name */
    const XML_ELEMENT_FORMITEM_LIST_ITEM_LABEL = 'label';
    
    /** The XML Form List Item's Value element name */
    const XML_ELEMENT_FORMITEM_LIST_ITEM_VALUE = 'value';
    
    
    /** The XML Form links NODE value */
    const XML_NODE_FORMLINKS = 'formLinks';
    
    /** The XML Form links NODE value */
    const XML_NODE_DATALINKS = 'dataLinks';
    
     /** The XML links NODE value */
    const XML_NODE_LINK = 'link';
    
    /** The XML links NODE value */
    const XML_ELEMENT_LINKS_LABEL = 'label';
    
    /** The XML links NODE value */
    const XML_ELEMENT_LINKS_ACTION = 'action';
    
    
        /** The XML Form links NODE value */
    const XML_NODE_HIDDENDATA = 'hiddenData';
    
     /** The XML links NODE value */
    const XML_NODE_HIDDEN = 'hidden';
    
    /** The XML links NODE value */
    const XML_ELEMENT_HIDDEN_NAME = 'name';
    
    /** The XML links NODE value */
    const XML_ELEMENT_HIDDEN_VALUE = 'value';


	//VARIABLES:
	/** @var [INTEGER] the ID of the Data Element to "edit" */
	protected $editID;

	/** @var [OBJECT] XML list of Headings */
	protected $heading;
	
	/** @var [OBJECT] XML list of entry data */
	protected $data;
	
	/** @var [OBJECT] XML list of Form data */
	protected $form;
	
	/** @var [OBJECT] XML list of Form Links */
	protected $linksForm;
	
	/** @var [OBJECT] XML list of Data Links */
	protected $linksData;
	
	/** @var [OBJECT] XML list of Hidden Data items */
	protected $hiddenData;
	

	//CLASS CONSTRUCTOR
	//************************************************************************
	/**
	 * function __construct
	 * <pre>
	 * Initialized the Admin Box 
	 * </pre>
	 * @return [void]
	 */
    function __construct() 
    {
        parent::__construct( XMLObject_AdminBox::XML_NODE_ROOT );
        
        $this->editID = -1;
        
        $this->heading = new XMLObject( XMLObject_AdminBox::XML_NODE_HEADING );
        $this->data = new XMLObject( XMLObject_AdminBox::XML_NODE_DATA );
        $this->form = new XMLObject( XMLObject_AdminBox::XML_NODE_FORM );
        $this->linksForm = new XMLObject( XMLObject_AdminBox::XML_NODE_FORMLINKS );
        $this->linksData = new XMLObject( XMLObject_AdminBox::XML_NODE_DATALINKS );
         $this->hiddenData = new XMLObject( XMLObject_AdminBox::XML_NODE_HIDDENDATA );
        
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
	 * function getXML
	 *
	 * Generates an XML document from the object's Values array.
	 *
	 * @param $isHeaderIncluded [BOOL] Determines if we include the '<?xml version="1.0"?>' header.
	 * @param $rootNodeName [STRING] The XML root node name.
	 *
	 * @return [STRING] Returns an XML formatted string.
	 */
	function getXML( $isHeaderIncluded=true, $rootNodeName='' ) 
	{
        $this->addElement( XMLObject_AdminBox::XML_ELEMENT_EDITID, $this->editID );
        $this->addXmlObject( $this->heading );
        
        $this->addXmlObject( $this->data );
        
        $this->addXmlObject( $this->form );
        
        $this->addXmlObject( $this->linksForm );
        
        $this->addXmlObject( $this->linksData );
        
        $this->addXmlObject( $this->hiddenData );
	
        return parent::getXML( $isHeaderIncluded, $rootNodeName);
	}

    
    
    
    //************************************************************************
	/**
	 * function addHeading
	 * <pre>
	 * Stores a heading for the admin box
	 * </pre>
	 * @param $heading [STRING] The text for the heading
	 * @return [void]
	 */
    function addHeading($heading) 
    {
        
        $this->heading->addElement( XMLObject_AdminBox::XML_ELEMENT_HEADING, $heading );
        
    }  // end classMethod()
    
    
    
    //************************************************************************
	/**
	 * function addDataRow
	 * <pre>
	 * Stores a heading for the admin box
	 * </pre>
	 * @param $uid [INTEGER] the unique id of this data row
	 * @param $values [ARRAY] array of values for this row
	 * @return [void]
	 */
    function addDataRow($uid, $values) 
    {
        $xmlRow = new XMLObject( XMLObject_AdminBox::XML_NODE_DATAROW );
        $xmlRow->addElement( XMLObject_AdminBox::XML_ELEMENT_DATAUID, $uid);
        
        for ($indx=0; $indx<count( $values); $indx++ ) {
            $xmlRow->addElement( XMLObject_AdminBox::XML_ELEMENT_DATAVALUE, $values[$indx] );
        }
        
        $this->data->addXmlObject( $xmlRow );
        
    }  // end addDataRow()
    
    
    
    //************************************************************************
	/**
	 * function addFormItem
	 * <pre>
	 * Stores a Form Item entry
	 * </pre>
	 * @param $name [STRING] the name of the form item
	 * @param $value [STRING] default value of this form item
	 * @param $error [STRING] error message related to this form item
	 * @param $type [STRING] type of form item
	 * @param $options [ARRAY] list of alternate parameters for specific form types
	 * @return [void]
	 */
    function addFormItem($name, $value, $error, $type, $options) 
    {
        $xmlItem = new XMLObject( XMLObject_AdminBox::XML_NODE_FORMITEM );
        
        $xmlItem->addElement( XMLObject_AdminBox::XML_ELEMENT_FORMITEM_NAME, $name);
        $xmlItem->addElement( XMLObject_AdminBox::XML_ELEMENT_FORMITEM_VALUE, $value);
        $xmlItem->addElement( XMLObject_AdminBox::XML_ELEMENT_FORMITEM_ERROR, $error);
        $xmlItem->addElement( XMLObject_AdminBox::XML_ELEMENT_FORMITEM_TYPE, $type);
        
        switch ( $type ) {
        
            case 'D':
                // on a date type, add the start and end years
                $key = XMLObject_AdminBox::XML_ELEMENT_FORMITEM_DATE_STARTYEAR;
                $xmlItem->addElement( $key, $options[ $key ]);
                
                $key = XMLObject_AdminBox::XML_ELEMENT_FORMITEM_DATE_ENDYEAR;
                $xmlItem->addElement( $key, $options[ $key ]);
                break;
                
            case 'L':
                // add each list item to the form item
                foreach( $options as $value=>$label ) {
                
                    $xmlOption = new XMLObject(XMLObject_AdminBox::XML_NODE_FORMITEM_LIST_ITEM );
                    $xmlOption->addElement( XMLObject_AdminBox::XML_ELEMENT_FORMITEM_LIST_ITEM_LABEL, $label);
                    $xmlOption->addElement( XMLObject_AdminBox::XML_ELEMENT_FORMITEM_LIST_ITEM_VALUE, $value);
                    
                    $xmlItem->addXmlObject( $xmlOption );
                }
                break;
        }
        
        $this->form->addXmlObject( $xmlItem );
        
    }  // end addFormItem()
    
    
    
    //************************************************************************
	/**
	 * function addDataLink
	 * <pre>
	 * Stores a link entry for the data rows
	 * </pre>
	 * @param $label [STRING] the value to show for the link
	 * @param $action [STRING] the href action for this link
	 * @return [void]
	 */
    function addDataLink($label, $action) 
    {
        $xmlLink = new XMLObject( XMLObject_AdminBox::XML_NODE_LINK );
        $xmlLink->addElement( XMLObject_AdminBox::XML_ELEMENT_LINKS_LABEL, $label);
        $xmlLink->addElement( XMLObject_AdminBox::XML_ELEMENT_LINKS_ACTION, $action);
        
        $this->linksData->addXmlObject( $xmlLink );
        
    }  // end addDataLink()
    
    
    //************************************************************************
	/**
	 * function addFormLink
	 * <pre>
	 * Stores a link entry for the form rows
	 * </pre>
	 * @param $label [STRING] the value to show for the link
	 * @param $action [STRING] the href action for this link
	 * @return [void]
	 */
    function addFormLink($label, $action) 
    {
        $xmlLink = new XMLObject( XMLObject_AdminBox::XML_NODE_LINK );
        $xmlLink->addElement( XMLObject_AdminBox::XML_ELEMENT_LINKS_LABEL, $label);
        $xmlLink->addElement( XMLObject_AdminBox::XML_ELEMENT_LINKS_ACTION, $action);
        
        $this->linksForm->addXmlObject( $xmlLink );
        
    }  // end addFormLink()
    
    
    
    //************************************************************************
	/**
	 * function addHiddenData
	 * <pre>
	 * Stores a hidden data item in the object
	 * </pre>
	 * @param $name [STRING] the name of the hidden data item
	 * @param $value [STRING] the value of the hidden data item
	 * @return [void]
	 */
    function addHiddenData($name, $value) 
    {
        $xmlItem = new XMLObject( XMLObject_AdminBox::XML_NODE_HIDDEN );
        $xmlItem->addElement( XMLObject_AdminBox::XML_ELEMENT_HIDDEN_NAME, $name);
        $xmlItem->addElement( XMLObject_AdminBox::XML_ELEMENT_HIDDEN_VALUE, $value);
        
        $this->hiddenData->addXmlObject( $xmlItem );
        
    }  // end addHiddenData()
    
    
    
    //************************************************************************
	/**
	 * function setEditID
	 * <pre>
	 * Stores the unique id of the data row we are editing..
	 * </pre>
	 * @param $editID [INTEGER] unique data row id
	 * @return [void]
	 */
    function setEditID( $editID ) 
    {
        
        $this->editID = $editID;
        
    }  // end setEditID()
	
	
}

?>