<?php
/**
 * @package AIobjects
 */ 
/**
 * class PageDisplay
 * <pre> 
 * This object manages the generic page data handling for a page object. 
 * </pre>
 * @author Johnny Hausman
 */
class  PageDisplay {

	//CONSTANTS:

	//VARIABLES:
	
    /** @var [ARRAY] The HREF values the links on this page. */
	protected $linkValues;
	
	/** @var [ARRAY] The labels for the links on this page. */
	protected $linkLabels;
	
	/** @var [OBJECT] the template object */
	protected $template;
	
	/** @var [OBJECT] the labels object */
	protected $labels;
	
	/** @var [STRING] the page error message */
	protected $error_message;
	
	/** @var [BOOLEAN] whether the page is being refreshed */
	protected $isErrorRefresh;

	//CLASS CONSTRUCTOR
	//************************************************************************
	/**
	 * function __construct
	 * <pre>
	 * Initialize the PageDisplay Object.
	 * </pre>
	 * @return [void]
	 */
    function __construct( ) 
    {

        $this->linkValues = array();
        $this->linkLabels = array();
                
        $this->isErrorRefresh = false;
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
        
        // Create the New Template Object
        $this->template = new Template( $path );
        
        // store the link values
        $this->template->set( 'linkValues', $this->linkValues );
        
        // store the link labels
        $this->template->set( 'linkLabels', $this->linkLabels );
        
        // store the page labels in XML format...
        if ( isset( $this->labels ) ) {
            $this->template->set( 'pageLabels', $this->labels->getLabelArray() );
        }            
        
    } 
    
    
    
    //************************************************************************
	/**
	 * function setLinks
	 * <pre>
	 * Sets the value of the linkValues array.
	 * </pre>
	 * @param $links [ARRAY] Array of Link Values
	 * @return [void]
	 */
    function setLinks($links) 
    {
        $this->linkValues = $links;
    }
    
    /** Sets error message for this page **/
    function setErrorMessage($msg)
    {
	    $this->error_message = $msg;
    }
    
     /** Gets error message for this page **/
    function getErrorMessage()
    {
	    return $this->error_message;
    }
    
    /** Sets whether or not the page is being refreshed **/
    function setIsErrorRefresh($refresh=false)
    {
	    $this->isErrorRefresh = $refresh;
    }       
    
    /** Returns whether or not the page is being refreshed **/
    function getIsErrorRefresh()
    {
	    return $this->isErrorRefresh;
    }
	
}

?>