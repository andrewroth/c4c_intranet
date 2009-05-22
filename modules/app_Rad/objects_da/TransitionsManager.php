<?php
/**
 * @package RAD
 */ 
/**
 * class RowManager_TransitionsManager
 * <pre> 
 * Tracks the standard transitions between pages.
 * </pre>
 * @author Johnny Hausman
 */
class  RowManager_TransitionsManager extends RowManager {

	//CONSTANTS:
	/** The name of the DB Table this class manages. */
    const DB_TABLE = 'rad_transitions';
    
    /** The fields in the DB Table this class manages. */
    const FIELD_LIST = 'transition_id,module_id,transition_fromObjID,transition_toObjID,transition_type,transition_isCreated';
    
    /** The XML node name for this entry. */
    const XML_NODE_NAME = 'transitions';
    
    /** The transition type keyword for FORM transitions. */
    const TRANSITION_TYPE_FORM = 'form';
    
    /** The transition type keyword for ADD transitions. */
    const TRANSITION_TYPE_ADD = 'add';
    
    /** The transition type keyword for EDIT transitions. */
    const TRANSITION_TYPE_EDIT = 'edit';
    
    /** The transition type keyword for CONTINUE transitions. */
    const TRANSITION_TYPE_CONTINUE = 'cont';
    
    /** The transition type keyword for DELETE transitions. */
    const TRANSITION_TYPE_DELETE = 'del';
    

	//VARIABLES:


	//CLASS CONSTRUCTOR
	//************************************************************************
	/**
	 * function __construct
	 * <pre>
	 * Initialize this object.
	 * </pre>
	 * @param $transitionID [INTEGER] The unique id of the transitions we are managing.
	 * @return [void]
	 */
    function __construct( $transitionID=-1 ) 
    {
    
        $dbTableName = RowManager_TransitionsManager::DB_TABLE;
        $fieldList = RowManager_TransitionsManager::FIELD_LIST;
        $primaryKeyField = 'transition_id';
        $primaryKeyValue = $transitionID;
        
        if (( $transitionID != -1 ) && ( $transitionID != '' )) {
        
            $condition = $primaryKeyField . '=' . $primaryKeyValue;
            
        } else {
            $condition = '';
        }
        $xmlNodeName = RowManager_TransitionsManager::XML_NODE_NAME;
        parent::__construct( $dbTableName, $fieldList, $primaryKeyField, $primaryKeyValue, $condition, $xmlNodeName, RADTOOL_DB_NAME, RADTOOL_DB_PATH, RADTOOL_DB_USER, RADTOOL_DB_PWORD);
        
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
	 * function getFromPageObj
	 * <pre>
	 * returns the source Page as an object.
	 * </pre>
	 * @return [OBJECT]
	 */
    function getFromPageObj() 
    {
        $pageID = $this->getValueByFieldName( 'transition_fromObjID' );
        return new RowManager_PageManager( $pageID );
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
    
    
    
    //************************************************************************
	/**
	 * function getPageConstTag
	 * <pre>
	 * returns the TAG for the Page constant in the applications Template. 
	 * used by the ModuelCreator.php file.
	 * </pre>
	 * @return [STRING]
	 */
    function getPageConstTag() 
    {
        $tag = '';
        
        $type = $this->getValueByFieldName( 'transition_type' );
        
        switch ($type) {
        
            case RowManager_TransitionsManager::TRANSITION_TYPE_FORM:
                break;
                
            case RowManager_TransitionsManager::TRANSITION_TYPE_ADD:
                $tag = '[PAGE_ADD]';
                break;
                
            case RowManager_TransitionsManager::TRANSITION_TYPE_EDIT:
                $tag = '[PAGE_VIEW]';
                break;
                
            case RowManager_TransitionsManager::TRANSITION_TYPE_CONTINUE:
                $tag = '[PAGE_NEXT]';
                break;
            
            case RowManager_TransitionsManager::TRANSITION_TYPE_DELETE:
                $tag = '[PAGE_DEL]';
                break;
        }
        
        
        return $tag;
    }
    
    
    
    //************************************************************************
	/**
	 * function getToPageObj
	 * <pre>
	 * returns the destination Page as an object.
	 * </pre>
	 * @return [OBJECT]
	 */
    function getToPageObj() 
    {
        $pageID = $this->getValueByFieldName( 'transition_toObjID' );
        return new RowManager_PageManager( $pageID );
    }
    
    
    
    //************************************************************************
	/**
	 * function getTransitionTypeArray
	 * <pre>
	 * Returns an array of possible transition types. Used for displaying
	 * droplist values on templates. 
	 * </pre>
	 * @return [ARRAY]
	 */
    function getTransitionTypeArray( $labels=null ) 
    {
        $typeList = array();
        
        $form = RowManager_TransitionsManager::TRANSITION_TYPE_FORM;
        $add = RowManager_TransitionsManager::TRANSITION_TYPE_ADD;
        $edit = RowManager_TransitionsManager::TRANSITION_TYPE_EDIT;
        $continue = RowManager_TransitionsManager::TRANSITION_TYPE_CONTINUE;
        $delete = RowManager_TransitionsManager::TRANSITION_TYPE_DELETE; 
        
        // if labels were provided then
        if ($labels) {
        
            // return translated version of elements
            $typeList[ $form ] = $labels->getLabel( '['.$form.']' );
            $typeList[ $add ] = $labels->getLabel( '['.$add.']' );
            $typeList[ $edit ] = $labels->getLabel( '['.$edit.']' );
            $typeList[ $continue ] = $labels->getLabel( '['.$continue.']' );
            $typeList[ $delete ] = $labels->getLabel( '['.$delete.']' );
            
        } else {
            
            // else return values as labels
            $typeList[ $form ] = $form;
            $typeList[ $add ] = $add;
            $typeList[ $edit ] = $edit;
            $typeList[ $continue ] = $continue;
            $typeList[ $delete ] = $delete;
        
        }
        
        return $typeList;
    }
    
    
    
    //************************************************************************
	/**
	 * function getType
	 * <pre>
	 * returns the transition type value.
	 * </pre>
	 * @return [STRING]
	 */
    function getType() 
    {
        
        $type = $this->getValueByFieldName( 'transition_type' );
        return $type;
    }
    
    
    
    //************************************************************************
	/**
	 * function isCreated
	 * <pre>
	 * returns the creation status of this object.
	 * </pre>
	 * @return [BOOL] True if created, False otherwise.
	 */
    function isCreated() 
    {
        return ( (int) $this->getValueByFieldName( 'transition_isCreated' ) == 1);
    }
    
    
    
    //************************************************************************
	/**
	 * function isDeleteType
	 * <pre>
	 * returns wether or not this transition is a delete transition.
	 * </pre>
	 * @return [BOOL]
	 */
    function isDeleteType() 
    {
        $type = $this->getValueByFieldName( 'transition_type' );
        return ($type == RowManager_TransitionsManager::TRANSITION_TYPE_DELETE);
    } 
    
    
    
    //************************************************************************
	/**
	 * function isEditType
	 * <pre>
	 * returns wether or not this transition is an edit transition.
	 * </pre>
	 * @return [BOOL]
	 */
    function isEditType() 
    {
        $type = $this->getValueByFieldName( 'transition_type' );
        return ($type == RowManager_TransitionsManager::TRANSITION_TYPE_EDIT);
    } 
    
    
    
    //************************************************************************
	/**
	 * function isFormType
	 * <pre>
	 * returns wether or not this transition is a form transition.
	 * </pre>
	 * @return [BOOL]
	 */
    function isFormType() 
    {
        $type = $this->getValueByFieldName( 'transition_type' );
        return ($type == RowManager_TransitionsManager::TRANSITION_TYPE_FORM);
    }
    
    
    
    //************************************************************************
	/**
	 * function setCreated
	 * <pre>
	 * sets the value of the transition_isCreated flag.
	 * </pre>
	 * @return [INTEGER]
	 */
    function setCreated() 
    {
        $this->setValueByFieldName( 'transition_isCreated', 1 );
        $this->updateDBTable();
    }
    
    
    
    //************************************************************************
	/**
	 * function setNotCreated
	 * <pre>
	 * Sets the status of this object to NOT Created.
	 * </pre>
	 * @return [INTEGER]
	 */
    function setNotCreated() 
    {
        $this->setValueByFieldName( 'transition_isCreated', 0 );
        $this->updateDBTable();
    }

    
    	
}

?>