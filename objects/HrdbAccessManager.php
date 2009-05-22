<?php
/**
 * @package NSSPayRoll
 */ 
/**
 * class RowManager_HrdbAccessManager
 * <pre> 
 * Manages entries in the HRDB->Access table.
 * </pre>
 * @author Johnny Hausman/David Cheong
 */
class  RowManager_HrdbAccessManager extends RowManager {

	//CONSTANTS:
	/** The name of the DB Table this class manages. */
    const DB_TABLE = 'access';
    
    /** The fields in the DB Table this class manages. */
    const FIELD_LIST = 'access_id,viewer_id,ren_id,access_reports,access_admin';
    
    /** The XML node name for this entry. */
    const XML_NODE_NAME = 'hrdbAccess';
    

	//VARIABLES:


	//CLASS CONSTRUCTOR
	//************************************************************************
	/**
	 * function __construct
	 * <pre>
	 * Initialize this object.
	 * </pre>
	 * @param $accessID [INTEGER] The unique id of the access object we are managing.
	 * @return [void]
	 */
    function __construct( $accessID=-1 ) 
    {
    
        $dbTableName = RowManager_HrdbAccessManager::DB_TABLE;
        $fieldList = RowManager_HrdbAccessManager::FIELD_LIST;
        $primaryKeyField = 'access_id';
        $primaryKeyValue = $accessID;
        
        if (( $accessID != -1 ) && ( $accessID != '' )) {
        
            $condition = $primaryKeyField . '=' . $primaryKeyValue;
            
        } else {
            $condition = '';
        }
        $xmlNodeName = RowManager_HrdbAccessManager::XML_NODE_NAME;
        parent::__construct( $dbTableName, $fieldList, $primaryKeyField, $primaryKeyValue, $condition, $xmlNodeName, HR_DB_NAME);
        
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
	 * function getRenID
	 * <pre>
	 * Returns renID of ren
     * </pre>
	 * @return [STRING]
	 */
    function getRenID() 
    {
        return $this->getValueByFieldName( 'ren_id' );
    }
    
    
    
    //************************************************************************
	/**
	 * function getID
	 * <pre>
	 * Returns ID of ren
     * </pre>
	 * @return [STRING]
	 */
    function getID() 
    {
        return $this->getValueByFieldName( 'access_id' );
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
        return "viewer_id";
    }
    
    
    
    //************************************************************************
	/**
	 * function getViewerID
	 * <pre>
	 * Returns viewerID of ren
     * </pre>
	 * @return [STRING]
	 */
    function getViewerID() 
    {
        return $this->getValueByFieldName( 'viewer_id' );
    }
    
    
    
    //************************************************************************
	/**
	 * function loadByRenID
	 * <pre>
	 * Attempts to load this object given a ren_id
     * </pre>
     * @param $renID [INTEGER] the ren_id to look up
	 * @return [BOOL]
	 */
    function loadByRenID( $renID ) 
    {
        $condition = 'ren_id='.$renID;
        $retVal = $this->loadByCondition( $condition );
        if (!$retVal)
        {
            // echo 'Error loading accessManager - loadByRenID<br/>';
        }
        return $retVal;
    }
    
    
    
    //************************************************************************
	/**
	 * function loadByViewerID
	 * <pre>
	 * Attempts to load this object given a viewer_id
     * </pre>
     * @param $viewerID [INTEGER] the viewer_id to look up
	 * @return [BOOL]
	 */
    function loadByViewerID( $viewerID ) 
    {
        // echo 'The loadByViewerID::viewerID is ['.$viewerID.']<br/>';
        $condition = 'viewer_id='.$viewerID;
        $retVal = $this->loadByCondition( $condition );
        if (!$retVal)
        {
            // echo 'Error loading accessManager - loadByViewerID<br/>';
        }
        return $retVal;
    }

    	
}

?>