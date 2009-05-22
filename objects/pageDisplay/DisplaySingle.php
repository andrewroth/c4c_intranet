<?php
/**
 * @package AIobjects
 */ 
/**
 * class PageDisplay_DisplaySingle 
 * <pre> 
 * This object manages pages that display a single set of data.
 * </pre>
 * @author Johnny Hausman
 * Date:   28 Apr 2005
 */
class  PageDisplay_DisplaySingle extends PageDisplay {

	//CONSTANTS:
    

	//VARIABLES:
	
	/** @var [STRING] list of fields to display. */
	protected $displayFields;
	
	/** @var [OBJECT] The data item object to display. */
	protected $itemManager;
	
	
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
        
        // store XML List of Applicants ...
        $this->template->setXML( 'dataItem', $this->itemManager->getXML() );
        
    }
	
}

?>