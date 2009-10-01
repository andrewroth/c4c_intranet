<?php
/**
 * @package cim_hrdb
 */ 
/**
 * class RowManager_AccessManager
 * <pre> 
 * This manages the access table..
 * </pre>
 * @author CIM Team
 */
class  RowManager_AccessManager extends RowManager {

	//CONSTANTS:
	/** The name of the DB Table this class manages. */
    const DB_TABLE = 'cim_hrdb_access';
    
    /** The SQL description of the DB Table this class manages. */
    /*
     * access_id [INTEGER]  This is the key for the table
     * viewer_id [INTEGER]  This is the viewer(user) id of the user who is assigned to a person id.
     * person_id [INTEGER]  This is the person id connected to the viewer id.
     */
    const DB_TABLE_DESCRIPTION = " (
  access_id int(50) NOT NULL  auto_increment,
  viewer_id int(50) NOT NULL  default '0',
  person_id int(50) NOT NULL  default '0',
  PRIMARY KEY (access_id)
) TYPE=MyISAM";
    
    /** The fields in the DB Table this class manages. */
    const FIELD_LIST = 'access_id,viewer_id,person_id';
    
    /** The XML node name for this entry. */
    const XML_NODE_NAME = 'access';
    

	//VARIABLES:


	//CLASS CONSTRUCTOR
	//************************************************************************
	/**
	 * function __construct
	 * <pre>
	 * Initialize this object.
	 * </pre>
	 * @param $PERSON_ID [INTEGER] The unique id of the access we are managing.
	 * @return [void]
	 */
    function __construct( $PERSON_ID=-1 ) 
    {
    
        $dbTableName = RowManager_AccessManager::DB_TABLE;
        $fieldList = RowManager_AccessManager::FIELD_LIST;
        $primaryKeyField = 'access_id';
        $primaryKeyValue = $PERSON_ID;
        
        if (( $PERSON_ID != -1 ) && ( $PERSON_ID != '' )) {
        
            $condition = $primaryKeyField . '=' . $primaryKeyValue;
            
        } else {
            $condition = '';
        }
        $xmlNodeName = RowManager_AccessManager::XML_NODE_NAME;
        parent::__construct( $dbTableName, $fieldList, $primaryKeyField, $primaryKeyValue, $condition, $xmlNodeName);
        
        $this->dbDescription = RowManager_AccessManager::DB_TABLE_DESCRIPTION;

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
        return "person_id";
    }

    //************************************************************************
	/**
	 * function getPersonID
	 * <pre>
	 * Returns the Person ID related to a viewer.
	 * </pre>
	 * @return [STRING]
	 */
    function getPersonID()
    {
        return $this->getValueByFieldName('person_id');
    }

    //************************************************************************
	/**
	 * function getViewerID
	 * <pre>
	 * Returns the Viewer ID related to a person.
	 * </pre>
	 * @return [STRING]
	 */
    function getViewerID()
    {
        return $this->getValueByFieldName('viewer_id');
    }
    
    //************************************************************************
	/**
	 * function getJoinOnPersonID
	 * <pre>
	 * returns the field used as a join condition for person_id
	 * </pre>
	 * @return [STRING]
	 */
    function getJoinOnPersonID()
    {
        return $this->getJoinOnFieldX('person_id');
    }

    //************************************************************************
	/**
	 * function getJoinOnViewerID
	 * <pre>
	 * returns the field used as a join condition for viewer_id
	 * </pre>
	 * @return [STRING]
	 */
    function getJoinOnViewerID()
    {
        return $this->getJoinOnFieldX('viewer_id');
    }

    //************************************************************************
	/**
	 * function loadByViewerID
	 * <pre>
	 * Makes the manager load a row using the viewer id.
	 * </pre>
	 * @return [STRING]
	 */
    function loadByViewerID( $viewerID )
    {
        return $this->loadByCondition( 'viewer_id='.$viewerID );
    }
    
    /**
	 * function loadByPersonID
	 * <pre>
	 * Makes the manager load a row using the person id.
	 * </pre>
	 * @return [STRING]
	 */
    function loadByPersonID( $personID )
    {
        return $this->loadByCondition( 'person_id='.$personID );
    }
    /**
	 * functionsetViewer
	 * <pre>
	 * Makes the manager load a row using the viewer id.
	 * </pre>
	 * @return [void]
	 */
    function setViewerID( $viewerID )
    {
        $this->setValueByFieldName( 'viewer_id', $viewerID  );
        return;
    }
    /**
	 * function loadByPersonID
	 * <pre>
	 * Makes the manager set a row using the person id.
	 * </pre>
	 * @return [void]
	 */
    function setPersonID( $personID )
    {
        $this->setValueByFieldName( 'person_id', $personID );
        return;
    }

    
    	
}

?>
