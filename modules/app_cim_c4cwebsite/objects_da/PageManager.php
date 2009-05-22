<?php
/**
 * @package cim_c4cwebsite
 */ 
/**
 * class RowManager_PageManager
 * <pre> 
 * Manages interactions with the page table.
 * </pre>
 * @author Russ Martin, Jon Baelde, Valera Strugov
 */
class  RowManager_PageManager extends RowManager {

	//CONSTANTS:
	/** The name of the DB Table this class manages. */
    const DB_TABLE = 'cim_c4cwebsite_page';
    
    /** The SQL description of the DB Table this class manages. */
    /*
     * page_id [INTEGER]  unique identifier
     * page_parentID [INTEGER]  the id of the parent page
     * page_breadcrumbTitle [STRING]  the title to display in the breadcrumb feature
     * page_templateName [STRING]  the name of the template used to display this page
     * page_link [STRING]  the link for the page, it's the path from the root
     * page_order [INTEGER]  what order the pages should be put in
     */
    const DB_TABLE_DESCRIPTION = " (
  page_id int(8) NOT NULL  auto_increment,
  page_parentID int(8) NOT NULL  default '0',
  page_breadcrumbTitle varchar(64) NOT NULL  default '',
  page_templateName varchar(64) NOT NULL  default '',
  page_link varchar(128) NOT NULL  default '',
  page_order int(8) NOT NULL  default '0',
  page_keywords text NOT NULL,
  PRIMARY KEY (page_id)
) TYPE=MyISAM";
    
    /** The fields in the DB Table this class manages. */
    const FIELD_LIST = 'page_id,page_parentID,page_breadcrumbTitle,page_templateName,page_link,page_order,page_keywords';
    
    /** The XML node name for this entry. */
    const XML_NODE_NAME = 'page';
    

	//VARIABLES:


	//CLASS CONSTRUCTOR
	//************************************************************************
	/**
	 * function __construct
	 * <pre>
	 * Initialize this object.
	 * </pre>
	 * @param $PAGE_ID [INTEGER] The unique id of the page we are managing.
	 * @return [void]
	 */
    function __construct( $PAGE_ID=-1 ) 
    {
    
        $dbTableName = RowManager_PageManager::DB_TABLE;
        $fieldList = RowManager_PageManager::FIELD_LIST;
        $primaryKeyField = 'page_id';
        $primaryKeyValue = $PAGE_ID;
        
        if (( $PAGE_ID != -1 ) && ( $PAGE_ID != '' )) {
        
            $condition = $primaryKeyField . '=' . $primaryKeyValue;
            
        } else {
            $condition = '';
        }
        $xmlNodeName = RowManager_PageManager::XML_NODE_NAME;
        parent::__construct( $dbTableName, $fieldList, $primaryKeyField, $primaryKeyValue, $condition, $xmlNodeName);
        
        $this->dbDescription = RowManager_PageManager::DB_TABLE_DESCRIPTION;

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
        //return $this->getValueByFieldName( 'applicant_codename' );
    }
    
    
    
    //************************************************************************
	/**
	 * function getLabelField
	 * <pre>
	 * Returns the field to use in the label routines.
	 * </pre>
	 * @return [STRING]
	 */
    function getLabelField() 
    {
        return "page_link";
    }

    
    	
}

?>