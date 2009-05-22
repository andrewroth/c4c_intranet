<?php
/**
 * @package NavBar
 */ 
/**
 * class RowManager_NavBarContentDataManager
 * <pre> 
 * Holds the multilingual content (labels) for the nav bar information..
 * </pre>
 * @author Johnny Hausman
 */
class  RowManager_NavBarContentDataManager extends RowManager {

	//CONSTANTS:
	/** The name of the DB Table this class manages. */
    const DB_TABLE = 'navbar_navbarcontentdata';
    
    /** The SQL description of the DB Table this class manages. */
    /*
     * navbarcontent_id [INTEGER]  Primary Key for this table
     * language_id [INTEGER]  Foriegn Key linking this content to a language
     * navbarcontent_key [STRING]  The content key for this content data.  Values are usually either "[group[ID#]]" or "[label[ID#]]"
     * navbarcontent_data [STRING]  The actual content to be displayed on the page.
     */
    const DB_TABLE_DESCRIPTION = " (
  navbarcontent_id int(11) NOT NULL  auto_increment,
  language_id int(11) NOT NULL  default '0',
  navbarcontent_key varchar(50) NOT NULL  default '',
  navbarcontent_data text NOT NULL  default '',
  PRIMARY KEY (navbarcontent_id)
) TYPE=MyISAM";
    
    /** The fields in the DB Table this class manages. */
    const FIELD_LIST = 'navbarcontent_id,language_id,navbarcontent_key,navbarcontent_data';
    
    /** The XML node name for this entry. */
    const XML_NODE_NAME = 'navbarcontentdata';
    

	//VARIABLES:


	//CLASS CONSTRUCTOR
	//************************************************************************
	/**
	 * function __construct
	 * <pre>
	 * Initialize this object.
	 * </pre>
	 * @param $initValue [INTEGER] The unique id of the navbarcontentdata we are managing.
	 * @return [void]
	 */
    function __construct( $initValue=-1 ) 
    {
    
        $dbTableName = RowManager_NavBarContentDataManager::DB_TABLE;
        $fieldList = RowManager_NavBarContentDataManager::FIELD_LIST;
        $primaryKeyField = 'navbarcontent_id';
        $primaryKeyValue = $initValue;
        
        if (( $initValue != -1 ) && ( $initValue != '' )) {
        
            $condition = $primaryKeyField . '=' . $primaryKeyValue;
            
        } else {
            $condition = '';
        }
        $xmlNodeName = RowManager_NavBarContentDataManager::XML_NODE_NAME;
        parent::__construct( $dbTableName, $fieldList, $primaryKeyField, $primaryKeyValue, $condition, $xmlNodeName);
        
        $this->dbDescription = RowManager_NavBarContentDataManager::DB_TABLE_DESCRIPTION;
        
        if ($this->isLoaded() == false) {
        
            // uncomment this line if you want the Manager to automatically 
            // create a new entry if the given info doesn't exist.
            // $this->createNewEntry();
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
        return "No Field Label Marked";
    }

    
    	
}

?>