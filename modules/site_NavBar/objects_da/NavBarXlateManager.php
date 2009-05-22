<?php
/**
 * @package NavBar
 */ 
/**
 * class RowManager_NavBarXlateManager
 * <pre> 
 * Holds the "needs to be Translated" information for the content data..
 * </pre>
 * @author Johnny Hausman
 */
class  RowManager_NavBarXlateManager extends RowManager {

	//CONSTANTS:
	/** The name of the DB Table this class manages. */
    const DB_TABLE = 'navbar_navbarxlate';
    
    /** The SQL description of the DB Table this class manages. */
    /*
     * navbarxlate_id [INTEGER]  Primary Key for this table
     * language_id [INTEGER]  Marks the language that the translation needs to be in.
     * navbarcontent_id [INTEGER]  Foreign Key linking to the content entry that needs the translation
     */
    const DB_TABLE_DESCRIPTION = " (
  navbarxlate_id int(11) NOT NULL  auto_increment,
  language_id int(11) NOT NULL  default '0',
  navbarcontent_id int(11) NOT NULL  default '0',
  PRIMARY KEY (navbarxlate_id)
) TYPE=MyISAM";
    
    /** The fields in the DB Table this class manages. */
    const FIELD_LIST = 'navbarxlate_id,language_id,navbarcontent_id';
    
    /** The XML node name for this entry. */
    const XML_NODE_NAME = 'navbarxlate';
    

	//VARIABLES:


	//CLASS CONSTRUCTOR
	//************************************************************************
	/**
	 * function __construct
	 * <pre>
	 * Initialize this object.
	 * </pre>
	 * @param $initValue [INTEGER] The unique id of the navbarxlate we are managing.
	 * @return [void]
	 */
    function __construct( $initValue=-1 ) 
    {
    
        $dbTableName = RowManager_NavBarXlateManager::DB_TABLE;
        $fieldList = RowManager_NavBarXlateManager::FIELD_LIST;
        $primaryKeyField = 'navbarxlate_id';
        $primaryKeyValue = $initValue;
        
        if (( $initValue != -1 ) && ( $initValue != '' )) {
        
            $condition = $primaryKeyField . '=' . $primaryKeyValue;
            
        } else {
            $condition = '';
        }
        $xmlNodeName = RowManager_NavBarXlateManager::XML_NODE_NAME;
        parent::__construct( $dbTableName, $fieldList, $primaryKeyField, $primaryKeyValue, $condition, $xmlNodeName);
        
        $this->dbDescription = RowManager_NavBarXlateManager::DB_TABLE_DESCRIPTION;
        
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