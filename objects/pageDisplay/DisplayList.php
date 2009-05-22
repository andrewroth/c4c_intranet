<?php
/**
 * @package AIobjects
 */ 
/**
 * class PageDisplay_DisplayList 
 * <pre> 
 * This object manages pages that display lists of data.
 * </pre>
 * @author Johnny Hausman
 * Date:   28 Apr 2005
 */
class  PageDisplay_DisplayList extends PageDisplay {

	//CONSTANTS:
    

	//VARIABLES:
	
	/** @var [STRING] list of fields to display. */
	protected $displayFields;
	
	/** @var [ARRAY] Additional columns in the data list that are links. */
	protected $linkColumns;
	
	/** @var [OBJECT] The object for generating the data list. */
	protected $listManager;
	
	
	//CLASS CONSTRUCTOR
	//************************************************************************
	/**
	 * function __construct
	 * <pre>
	 * Initialize the object.
	 * </pre>
	 * @return [void]
	 */
    function __construct( $displayFieldList ) 
    {
        parent::__construct();
        
        $this->displayFields = $displayFieldList;
        $this->linkColumns = array();
                
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
	 * function prepareTemplate
	 * <pre>
	 * Prepares the template object for returning page display data.
	 * </pre>
	 * @return [void]
	 */
    function prepareTemplate($path) 
    {
        parent::prepareTemplate( $path );
    
        
        // store the field names being displayed
        $fieldNames = explode(',', $this->displayFields);
        $this->template->set( 'dataFieldList', $fieldNames);
        
        // store any additional link Columns
        $this->template->set( 'linkColumns', $this->linkColumns);
        
        // store XML List of Applicants ...
        $this->template->setXML( 'dataList', $this->listManager->getXML() );
        
    }
    
    
    
    //************************************************************************
	/**
	 * function addLinkColumn
	 * <pre>
	 * Adds a value to the linkColumn array.
	 * </pre>
	 * @param $title [STRING] The label to display for the column title
	 * @param $label [STRING] The label to display for the link
	 * @param $link  [STRING] the href value for the link
	 * @param $fieldName [STRING] the name of the field used to complete 
	 * the link
	 * @return [void]
	 */
    function addLinkColumn($title, $label, $link, $fieldName, $useAlt = 'false', $label_alt = '', $link_alt = '', $field_alt = '' ) 
    {
        $entry = array();
        $entry[ 'title' ] = $title;
        $entry[ 'label' ] = $label;
        $entry[ 'link' ] = $link;
        $entry[ 'field' ] = $fieldName;
        $entry[ 'count' ] = 1;
        
        if ($useAlt == 'true')
        {
	        $entry[ 'useAlt' ] = $useAlt;
	        $entry[ 'label_alt' ] = $label_alt;
	        $entry[ 'link_alt' ] = $link_alt;
	        $entry[ 'field_alt' ] = $field_alt;  
	        $entry[ 'count' ] = 2; 
        }     
        
        $this->linkColumns[] = $entry;
    }
	
    //************************************************************************
	/**
	 * function addDynamicLinkColumn
	 * <pre>
	 * Adds a value to the linkColumn array.
	 * </pre>
	 * @param $title [STRING] The label to display for the column title
	 * @param $labels [ARRAY] The label(s) to display for the link(s)
	 * @param $links  [ARRAY] the href value(s) for the link(s)
	 * @param $fieldNames [ARRAY] the name(s) of the field(s) used to complete 
	 * the link(s)
	 * @return [void]
	 */
    function addDynamicLinkColumn($title, $labels, $links, $fieldNames ) 
    {
        $entry = array();
        $entry[ 'title' ] = $title;
        $entry[ 'count' ] = count($labels);	// store total link types
        
        for ($i=0; $i < count($labels); $i++)
        {
	        $entry[ 'label'.$i ] = $labels[$i];
	        $entry[ 'link'.$i ] = $links[$i];
	        $entry[ 'field'.$i ] = $fieldNames[$i];
        }   
        
//         echo "entry: <pre>".print_r($entry,true)."</pre>";  
        
        $this->linkColumns[] = $entry;
    }    
}

?>