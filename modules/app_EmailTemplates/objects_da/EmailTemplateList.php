<?php
/**
 * @package EmailTemplates
 */ 
/**
 * class EmailTemplateList
 * <pre> 
 * This object manages the listing of the emailtemplate table elements.
 * </pre>
 * @author Reuben Uy
 */
class  EmailTemplateList extends ListIterator {

	//CLASS CONSTRUCTOR
	//************************************************************************
	/**
	 * function __construct
	 * <pre>
	 * Initialize the Class ...
	 * </pre>
     * @param $template_id [INTEGER] value used to initialize the list.
	 * @param $sortBy [STRING] the field name to sort list by
     * @return [void]
	 */
    function __construct( $template_id=-1,  $sortBy='' ) 
    {
        //print (moduleEmailTemplates::MULTILINGUAL_SERIES_KEY);
        $searchManager = new RowManager_EmailTemplateManager($template_id);
        $searchManager->setAppID(moduleEmailTemplates::MULTILINGUAL_SERIES_KEY);
        // NOTE: if you need to narrow the field of the search then uncommnet
        // the following and set the proper search criteria.
        $searchManager->setValueByFieldName("template_id", $template_id );
        //$searchManager->setValueByFieldName('module_isCommonLook', '1' );
        $searchManager->setSortOrder( $sortBy );
        
        parent::__construct( $searchManager );
        
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
}

?>