<?php
/**
 * @package [ModuleName]
 */ 
/**
 * class [DAObj]
 * <pre> 
 * [DAObjDescription]
 * </pre>
 * @author [CreatorName]
 */
class  [DAObj] extends ListIterator {

	//CLASS CONSTRUCTOR
	//************************************************************************
	/**
	 * function __construct
	 * <pre>
	 * Initialize the Class ...
	 * </pre>
[RAD_INITVAR_DOC]	 * @param $sortBy [STRING] the field name to sort list by
     * @return [void]
	 */
    function __construct( /*[RAD_INITVAR_PARAM]*/ $sortBy='' ) 
    {
        $searchManager = new RowManager_[DAObj_ROW_MGR]();
        
        // NOTE: if you need to narrow the field of the search then uncommnet
        // the following and set the proper search criteria.
/*[RAD_INITVAR_CODE]*/        //$searchManager->setValueByFieldName('module_isCommonLook', '1' );
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