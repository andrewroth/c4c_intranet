<?php
/**
 * @package AIobjects
 */ 
/**
 * class PageDisplay_FormProcessor_AdminBox 
 * <pre> 
 * A generic Page Display object that handles AdminBox style pages.
 * </pre>
 * @author Johnny Hausman
 * Date:   28 Apr 2005
 */
class  PageDisplay_FormProcessor_AdminBox extends PageDisplay_FormProcessor {

	//CONSTANTS:


	//VARIABLES:
	
	/** @var [STRING] The field list for the display portion. */
	protected $displayFields;
	
	/** @var [OBJECT] The Viewer Object. */
	protected $viewer;
	
	
	/** @var [ARRAY] Additional columns in the data list that are links. */
	protected $linkColumns;
	

    /** @var [STRING] The type of Editing operation (U=Update, D=Delete). */
	protected $opType;
	
	/** @var [BOOL] Flag marking if we should delete the current entry. */
	protected $shouldDelete;
	
	
	/** @var [OBJECT] The data List object. */
	protected $dataList;
	
	/** @var [STRING] The field information to sort dataList by */
	protected $sortBy;


	//CLASS CONSTRUCTOR
	//************************************************************************
	/**
	 * function __construct
	 * <pre>
	 * Initialize the object.
	 * </pre>
	 * @param $pathModuleRoot [STRING] The path to this module's root directory
	 * @param $viewer [OBJECT] The viewer object.
	 * @param $formAction [STRING] The action on a form submit
	 * @param $sortBy [STRING] Field data to sort listManager by.
	 * @param $fieldList [STRING] The list of form fields to work with
	 * @param $fieldDisplayTypes [STRING] The list of form field Types
	 * @param $displayFields [STRING] List of field names for the display list
	 * @return [void]
	 */
    function __construct($viewer, $formAction, $sortBy, $fieldList, $fieldDisplayTypes, $displayFields)
    {
        // NOTE: be sure to call the parent constructor before trying to 
        //       use the ->formXXX arrays...
        parent::__construct( $formAction, $fieldList, $fieldDisplayTypes );
        
        $this->displayFields = $displayFields;

        $this->viewer = $viewer;
        $this->sortBy = $sortBy;

        $this->linkColumns = array();

        $this->opType = $this->getQueryStringOPType();
        
        $this->shouldDelete = false;
        
         
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
    function addLinkColumn($title, $label, $link, $fieldName ) 
    {
        $entry = array();
        $entry[ 'title' ] = $title;
        $entry[ 'label' ] = $label;
        $entry[ 'link' ] = $link;
        $entry[ 'field' ] = $fieldName;
        
        $this->linkColumns[] = $entry;
    }
    
    
    
    //************************************************************************
	/**
	 * function getOPTypeDelete
	 * <pre>
	 * Returns the op type value that represents a Delete operation.
	 * </pre>
	 * @return [STRING]
	 */
    function getOPTypeDelete( ) 
    {
        return 'D';
    }
    
    
    
    //************************************************************************
	/**
	 * function getOPTypeUpdate
	 * <pre>
	 * Returns the op type value that represents an Update operation.
	 * </pre>
	 * @return [STRING]
	 */
    function getOPTypeUpdate( ) 
    {
        return 'U';
    }
    
    
    
    //************************************************************************
	/**
	 * function getQueryStringOPType
	 * <pre>
	 * Returns the value of state of the page. This value is returned from the
	 * query string not the internal member variable.
	 * </pre>
	 * @return [STRING]
	 */
    function getQueryStringOPType( ) 
    {
        $opType = '';
        
        // see what operation type (if any) is requested...
        if ( isset( $_REQUEST[ 'admOpType' ] ) ) {
        
            $opType = $_REQUEST[ 'admOpType' ];
        }
    
        return $opType;
    }
    
    
    
    //************************************************************************
	/**
	 * function loadFromForm
	 * <pre>
	 * Loads the data from the submitted form.
	 * </pre>
	 * @return [void]
	 */
    function loadFromForm() 
    {
        parent::loadFromForm();
        
        // if the button pressed was a 'Delete?' confirmation then
        if (isset( $_REQUEST[ 'submit' ] ) ) {
        
            if ( $_REQUEST[ 'submit' ] == $this->labels->getLabel('[Delete?]')) {
                
                // set shouldDelete 
                $this->shouldDelete = true;
            }
            
        }
        
    }
    
    
    
    //************************************************************************
	/**
	 * function prepareTemplate
	 * <pre>
	 * This method prepares the template object for returning AdminBox data.
	 * </pre>
	 * @return [void]
	 */
    function prepareTemplate($path) 
    {
        
        // call the FormProcessor's prepare Template function.
        parent::prepareTemplate( $path );
        
        // store any additional link Columns
        $this->template->set( 'linkColumns', $this->linkColumns);
        
        // store the current op type
        $this->template->set( 'opType', $this->opType );
        

        /*
         * List related Template variables :
         */
        // store the field names being displayed
        $fieldNames = explode(',', $this->displayFields);
        $this->template->set( 'dataFieldList', $fieldNames);
        
    }
    
	
}

?>