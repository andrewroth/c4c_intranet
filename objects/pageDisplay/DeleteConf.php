<?php
/**
 * @package AIobjects
 */ 
/**
 * class PageDisplay_DeleteConf 
 * <pre> 
 * This object manages Delete Confirmation Pages.
 * </pre>
 * @author Johnny Hausman
 * Date:   28 Apr 2005
 */
class  PageDisplay_DeleteConf extends PageDisplay {

	//CONSTANTS:
    

	//VARIABLES:
	
    /** @var [STRING] The form Action for submitting this form. */
	protected $formAction;
	
	/** @var [STRING] list of fields to display. */
	protected $displayFields;
	
	/** @var [OBJECT] The data item object to display. */
	protected $itemManager;
	
    /** @var [BOOL] should this Object be deleted?. */
	protected $shouldDelete;
	
	/** @var [BOOL] was this called from a submitted form?. */
	protected $wasSubmitted;
	
	
	//CLASS CONSTRUCTOR
	//************************************************************************
	/**
	 * function __construct
	 * <pre>
	 * Initialize the object.
	 * </pre>
	 * @return [void]
	 */
    function __construct( $formAction, $displayFieldList ) 
    {
        parent::__construct();
        
        $this->formAction = $formAction;
        $this->displayFields = $displayFieldList;
        
        $this->shouldDelete = false;
        $this->wasSubmitted = false;
                
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
	 * function loadFromForm
	 * <pre>
	 * Loads the data from the submitted form.
	 * </pre>
	 * @param $param1 [$param1 type][optional description of $param1]
	 * @param $param2 [$param2 type][optional description of $param2]
	 * @return [returnValue, can be void]
	 */
    function loadFromForm() 
    {

        if ( $_REQUEST[ 'submit' ] == $this->labels->getLabel('[yes]')) {
            $this->shouldDelete = true;
        }
        
        $this->wasSubmitted = true;
                
    } // end loadFromForm()
    
    
    
    //************************************************************************
	/**
	 * function isDataValid
	 * <pre>
	 * Verifies the returned data is valid.
	 * </pre>
	 * @return [BOOL]
	 */
    function isDataValid() 
    {
         $isValid = true;
        
        // now return result
        return $isValid;
        
    }
    
    
    
    //************************************************************************
	/**
	 * function processData
	 * <pre>
	 * Processes the data for this form.
	 * </pre>
	 * @return [void]
	 */
    function processData() 
    {
        if ($this->shouldDelete) {
        
            $this->itemManager->deleteEntry();
        }
        
    } // end processData()
    
    
    
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
    
        // store the form action data
        $this->template->set( 'formAction', $this->formAction );
        
        // store the field names being displayed
        $fieldNames = explode(',', $this->displayFields);
        $this->template->set( 'dataFieldList', $fieldNames);
        
        // store XML List of Applicants ...
        $this->template->setXML( 'dataItem', $this->itemManager->getXML() );
        
    }
    
    
    
    //************************************************************************
	/**
	 * function wasDeleted()
	 * <pre>
	 * Returns the value of <code>shouldDelete</code>.
	 * </pre>
	 * @return [BOOL]
	 */
    function wasDeleted() 
    {
        return $this->shouldDelete;
    }
	
}

?>