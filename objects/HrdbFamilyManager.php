<?php
/**
 * @package NSSPayRoll
 */ 
/**
 * class RowManager_FamilyManagerManager
 * <pre> 
 * Manages the family table in the hrdb..
 * </pre>
 * @author Johnny Hausman/Russ Martin
 */
class  RowManager_FamilyManager extends RowManager {

	//CONSTANTS:
	/** The name of the DB Table this class manages. */
    const DB_TABLE = 'family';
    
    /** The SQL description of the DB Table this class manages. */
    /*
     * family_id [INTEGER]  Unique id
     * family_creationdata [STRING]  Creation Data
     * family_anniversary [DATE]  Date of the family's anniversary.
     * family_alumni [BOOL]  Is the family alumni?
     */
    const DB_TABLE_DESCRIPTION = " (
  family_id int(int) NOT NULL  auto_increment,
  family_creationdata varchar(varchar) NOT NULL  default '',
  family_anniversary date NOT NULL  default '0000-00-00',
  family_alumni int(int) NOT NULL  default '0',
  PRIMARY KEY (family_id)
) TYPE=MyISAM";
    
    /** The fields in the DB Table this class manages. */
    const FIELD_LIST = 'family_id,family_creationdata,family_anniversary,family_alumni';
    
    /** The XML node name for this entry. */
    const XML_NODE_NAME = 'family';
    

	//VARIABLES:


	//CLASS CONSTRUCTOR
	//************************************************************************
	/**
	 * function __construct
	 * <pre>
	 * Initialize this object.
	 * </pre>
	 * @param $initValue [INTEGER] The unique id of the familymanager we are managing.
	 * @return [void]
	 */
    function __construct( $initValue=-1 ) 
    {
    
        $dbTableName = RowManager_FamilyManager::DB_TABLE;
        $fieldList = RowManager_FamilyManager::FIELD_LIST;
        $primaryKeyField = 'family_id';
        $primaryKeyValue = $initValue;
        
        if (( $initValue != -1 ) && ( $initValue != '' )) {
        
            $condition = $primaryKeyField . '=' . $primaryKeyValue;
            
        } else {
            $condition = '';
        }
        $xmlNodeName = RowManager_FamilyManager::XML_NODE_NAME;
        parent::__construct( $dbTableName, $fieldList, $primaryKeyField, $primaryKeyValue, $condition, $xmlNodeName, HR_DB_NAME);
        
        $this->dbDescription = RowManager_FamilyManager::DB_TABLE_DESCRIPTION;
        
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
    
    function getJoinOnFamilyID()
    {
        return $this->getJoinOnFieldX('family_id');
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
        return "/////";
    }
    
    function setAlumni( $val )
    {
        $flag = 0; // default to false
        if ( $val )
        {
            $flag = 1;
        }
        $this->setValueByFieldName( 'family_alumni', $flag );
    }

    
    	
}

?>