<?php
/**
 * @package RAD
 */ 
/**
 * class RowManager_PageManager
 * <pre> 
 * Manages all the pages related to a module.
 * </pre>
 * @author Johnny Hausman
 */
class  RowManager_PageManager extends RowManager {

	//CONSTANTS:
	/** The name of the DB Table this class manages. */
    const DB_TABLE = 'rad_page';
    
    /** The fields in the DB Table this class manages. */
    const FIELD_LIST = 'page_id,module_id,page_name,page_desc,page_type,page_isAdd,page_rowMgrID,page_listMgrID,page_isCreated,page_isDefault';
    
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
	 * @param $pageID [INTEGER] The unique id of the page we are managing.
	 * @return [void]
	 */
    function __construct( $pageID=-1 ) 
    {
    
        $dbTableName = RowManager_PageManager::DB_TABLE;
        $fieldList = RowManager_PageManager::FIELD_LIST;
        $primaryKeyField = 'page_id';
        $primaryKeyValue = $pageID;
        
        if (( $pageID != -1 ) && ( $pageID != '' )) {
        
            $condition = $primaryKeyField . '=' . $primaryKeyValue;
            
        } else {
            $condition = '';
        }
        $xmlNodeName = RowManager_PageManager::XML_NODE_NAME;
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
	 * function deleteEntry
	 * <pre>
	 * Removes the child entries of page objects before removing self.
	 * </pre>
	 * @return [void]
	 */
    function deleteEntry() 
    {
        // first remove any associated fields with this Page
        $pageFieldList = new PageFieldList( $this->getID() );
        $pageFieldList->setFirst();
        while( $field = $pageFieldList->getNext() ) {
            $field->deleteEntry();
        }
        
        // now remove any labels associated with this Page
        $pageLabelList = new PageLabelsList( $this->getID() );
        $pageLabelList->setFirst();
        while( $label = $pageLabelList->getNext() ) {
            $label->deleteEntry();
        }
        
        // now call parent method
        parent::deleteEntry();
        
    }
    
    
    
    //************************************************************************
	/**
	 * function getBLInitCodeName
	 * <pre>
	 * Returns name of the code Template to use for the loading of a page.
	 * </pre>
	 * @return [STRING]
	 */
    function getBLInitCodeName() 
    {
        $type =  $this->getValueByFieldName( 'page_type' );
        
        switch( $type ) {
        
            case 'FSDLT':
            case 'AB':
                $fileName = 'pageInit_AdminBox.php';
                break;
                
            
            case 'DLT':
                $fileName = 'pageInit_DataListTable.php';
                break;
                
            
            case 'FS':
                $fileName = 'pageInit_FormSingleEntry.php';
                break;
                
            case 'FG':            
                $fileName = 'pageInit_FormGrid.php';
                break;
                
            case 'DLS':
                $fileName = 'pageInit_DataSingle.php';
                break;
                
            case 'DelC':
                $fileName = 'pageInit_DeleteConf.php';
                break;
                
            case 'Other':
                $fileName = 'pageInit_Custom.php';
                break;
                
        }
        
        return $fileName;
        
    } // end getBLInitCodeName()
    
    
    
    //************************************************************************
	/**
	 * function getBLTemplateName
	 * <pre>
	 * Returns name of the Business Logic Template to use when createing a new
	 * page object.
	 * </pre>
	 * @return [STRING]
	 */
    function getBLTemplateName() 
    {
        $type =  $this->getValueByFieldName( 'page_type' );
        
        switch( $type ) {
        
            case 'FSDLT':
            case 'AB':
                $fileName = 'tmpl_page_AdminBox.php';
                break;
                
            case 'DLT':
                $fileName = 'tmpl_page_DataListTable.php';
                break;
                
            case 'FS':
                $fileName = 'tmpl_page_FormSingleEntry.php';
                break;
                
            case 'FG':
                $fileName = 'tmpl_page_FormGrid.php';
                break;
                
            case 'DLS':
                $fileName = 'tmpl_page_DataSingle.php';
                break;
                
            case 'DelC':
                $fileName = 'tmpl_page_DeleteConfirmation.php';
                break;
                
            case 'Other':
                $fileName = 'tmpl_page_Custom.php';
                break;
            
        }
        
        return $fileName;
        
    } // end getBLTemplateName()
    
    
    
    //************************************************************************
	/**
	 * function getDescription
	 * <pre>
	 * Returns the page description of this page.
	 * </pre>
	 * @return [STRING]
	 */
    function getDescription() 
    {
        return $this->getValueByFieldName( 'page_desc' );
        
    } // end getDescription()
    
    
    
    //************************************************************************
	/**
	 * function getFormDAObj
	 * <pre>
	 * Returns the Data Access Object for this page's Form portion.
	 * </pre>
	 * @return [OBJECT]
	 */
    function getFormDAObj() 
    {
        $formDAObjID = $this->getValueByFieldName( 'page_rowMgrID' );

        return new RowManager_DAObjManager( $formDAObjID );
        
    } // end getFormDAObj()
    
    
    
    //************************************************************************
	/**
	 * function getFormFieldList
	 * <pre>
	 * Returns the Data Access Object for this page's List portion.
	 * </pre>
	 * @return [OBJECT]
	 */
    function getFormFieldList() 
    {
        $pageID = $this->getID();
        $formDAObjID = $this->getValueByFieldName( 'page_rowMgrID' );
        $isForm = '1';

        return new PageFieldList( $pageID, $formDAObjID, $isForm );
        
    } // end getFormFieldList()
    
    
    
    //************************************************************************
	/**
	 * function getFormTransitionTemplateName
	 * <pre>
	 * Returns name of the Form Transition Template to use.
	 * </pre>
	 * @return [STRING]
	 */
    function getFormTransitionTemplateName() 
    {
        $type =  $this->getValueByFieldName( 'page_type' );
        
        switch( $type ) {
        
            case 'FSDLT':
            case 'AB':
                $fileName = 'formTrans_AdminBox.php';
                break;
                
            case 'DelC':
            case 'FS':
            case 'FG':
            case 'Other':
                $fileName = 'formTrans_FormStyle.php';
                break;
                
        }
        
        return $fileName;
        
    } // end getFormTransitionTemplateName()
    
    
    
    //************************************************************************
	/**
	 * function getID
	 * <pre>
	 * Returns the unique ID of this page object.
	 * </pre>
	 * @return [INTEGER]
	 */
    function getID() 
    {
        return $this->getValueByFieldName( 'page_id' );
        
    } // end getID()
    
    
    
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
        return 'page_name';
    }
    
    
    
    //************************************************************************
	/**
	 * function getLinkInitAdminBox
	 * <pre>
	 * Returns the link initialization Code for an Admin Box page type.
	 * </pre>
	 * @return [STRING]
	 */
    function getLinkInitAdminBox( ) 
    {
        $editTag = RowManager_TransitionsManager::TRANSITION_TYPE_EDIT;
        $delTag = RowManager_TransitionsManager::TRANSITION_TYPE_DELETE;
        
        $code ='        $parameters = array( );//[RAD_CALLBACK_PARAMS_EDIT]
        $editLink = $this->getCallBack( module[ModuleName]::[RAD_PAGE_CONSTNAME], $this->sortBy, $parameters );
        $editLink .= "&". module[ModuleName]::[EDIT_STATEVAR_CONST] . "=";
        $links[ "'.$editTag.'" ] = $editLink;
        
        // NOTE: delete link is same as edit link for an AdminBox
        $links[ "'.$delTag.'" ] = $editLink;';

        return $code;
        
    } // end getLinkInitAdminBox()
    
    
    
    //************************************************************************
	/**
	 * function getLinkInitCode
	 * <pre>
	 * Returns the link initialization Code for a given transition type.
	 * </pre>
	 * @param $type [STRING] The current Transition Type we are requesting 
	 * link initizalitions code for.
	 * @return [STRING]
	 */
    function getLinkInitCode( $type ) 
    {
        $code = '';
        
        switch ( $type ) {
        
            case RowManager_TransitionsManager::TRANSITION_TYPE_ADD:
                $code ='        $parameters = array( );//[RAD_CALLBACK_PARAMS]
        $addLink = $this->getCallBack( module[ModuleName]::[PAGE_ADD], $this->sortBy, $parameters );
        $links["'.$type.'"] = $addLink;';
                break;
        
            case RowManager_TransitionsManager::TRANSITION_TYPE_EDIT:
                $code ='        $parameters = array( );//[RAD_CALLBACK_PARAMS_EDIT]
        $editLink = $this->getCallBack( module[ModuleName]::[PAGE_VIEW], $this->sortBy, $parameters );
        $editLink .= "&". module[ModuleName]::[EDIT_STATEVAR_CONST] . "=";
        $links["'.$type.'"] = $editLink;';
                break;
                
            case RowManager_TransitionsManager::TRANSITION_TYPE_DELETE:
                $code ='        $parameters = array( );//[RAD_CALLBACK_PARAMS_EDIT]
        $delLink = $this->getCallBack( module[ModuleName]::[PAGE_DEL], $this->sortBy, $parameters );
        $delLink .= "&". module[ModuleName]::[EDIT_STATEVAR_CONST] . "=";
        $links["'.$type.'"] = $delLink;';
                break;
                
            case RowManager_TransitionsManager::TRANSITION_TYPE_CONTINUE:
                $code ='        $parameters = array( );//[RAD_CALLBACK_PARAMS]
        $continueLink = $this->getCallBack( module[ModuleName]::[PAGE_NEXT], "", $parameters );
        $links["'.$type.'"] = $continueLink;';
                break;
                
        }

        return $code;
        
    } // end getLinkInitCode()
    
    
    
    //************************************************************************
	/**
	 * function getListDAObj
	 * <pre>
	 * Returns the Data Access Object for this page's List portion.
	 * </pre>
	 * @return [OBJECT]
	 */
    function getListDAObj() 
    {
        $listDAObjID = $this->getValueByFieldName( 'page_listMgrID' );

        return new RowManager_DAObjManager( $listDAObjID );
        
    } // end getListDAObj()
    
    
    
    //************************************************************************
	/**
	 * function getListFieldList
	 * <pre>
	 * Returns the Data Access Object for this page's List portion.
	 * </pre>
	 * @return [OBJECT]
	 */
    function getListFieldList() 
    {
        $pageID = $this->getID();
        $formDAObjID = $this->getValueByFieldName( 'page_listMgrID' );
        $isForm = '0';

        return new PageFieldList( $pageID, $formDAObjID, $isForm );
        
    } // end getListFieldList()
    
    
    
    //************************************************************************
	/**
	 * function getModuleID
	 * <pre>
	 * Returns the ID of this page's module object.
	 * </pre>
	 * @return [INTEGER]
	 */
    function getModuleID() 
    {
        return $this->getValueByFieldName( 'module_id' );
        
    } // end getModuleID()
    
    
    
    //************************************************************************
	/**
	 * function getName
	 * <pre>
	 * Returns the name of this page object.
	 * </pre>
	 * @return [STRING]
	 */
    function getName() 
    {
        return $this->getValueByFieldName( 'page_name' );
        
    } // end getName()
    
    
    
    //************************************************************************
	/**
	 * function getPageConstantName
	 * <pre>
	 * Returns the name of this page's page constant.
	 * </pre>
	 * @return [STRING]
	 */
    function getPageConstantName() 
    {
        $name = $this->getPageName();
        
        // make sure no spaces
        $name = strtoupper( $name );
        
        return 'PAGE_'.$name;
        
    } // end getPageConstantName()
    
    
    
    //************************************************************************
	/**
	 * function getPageLabels
	 * <pre>
	 * Returns a list of labels linked to this page.
	 * </pre>
	 * @return [STRING]
	 */
    function getPageLabels() 
    {
        // get page ID
        $pageID = $this->getID();
        
        // create new PageLabelList()
        $labelList = new PageLabelsList( $pageID );
        
        return $labelList;
        
    } // end getPageLabels()
    
    
    
    //************************************************************************
	/**
	 * function getPageName
	 * <pre>
	 * Returns the page name of this page.
	 * </pre>
	 * @return [STRING]
	 */
    function getPageName() 
    {
        $name = $this->getValueByFieldName( 'page_name' );
        
        // make sure no spaces
        $name = str_replace( ' ', '', $name);
        
        // Capatilize 1st letter
        $name = ucwords( $name );
        
        return $name;
        
    } // end getPageName()
    
    
    
    //************************************************************************
	/**
	 * function getPagePrefixName
	 * <pre>
	 * Returns the page prefix name of this page.
	 * </pre>
	 * @return [STRING]
	 */
    function getPagePrefixName() 
    {
        $prefixName = '';
        switch ($this->getValueByFieldName( 'page_type' ) ) {
        
            case 'FG':
            case 'FS':
            case 'FSDLT':
            case 'AB':
                $prefixName = 'FormProcessor_';
                break;
                
            case 'DelC':
            case 'DLS':
            case 'DLT':
            case 'Other':
                $prefixName = 'page_';
                break;
                
            default:
                $prefixName = '';
                break;

        }
        
        return $prefixName;
        
    } // end getPagePrefixName()
    
    
    
    //************************************************************************
	/**
	 * function getPageType
	 * <pre>
	 * Returns the page type of this page.
	 * </pre>
	 * @return [INTEGER]
	 */
    function getPageType() 
    {
        return $this->getValueByFieldName( 'page_type' );
        
    } // end getPageType()
    
    
    
    //************************************************************************
	/**
	 * function getPageTypeArray
	 * <pre>
	 * Returns an array of the available page types for a page.
	 * </pre>
	 * @return [ARRAY]
	 */
    function getPageTypeArray() 
    {
        $typeData = array();
        
        $typeData[ 'AB' ] = 'AdminBox';
        $typeData[ 'DLT' ] = 'Display List (Table)';
        $typeData[ 'DLS' ] = 'Display List (Single)';
        $typeData[ 'FS' ]  = 'Form (Single Entry)';
        $typeData[ 'FG' ]  = 'Form (Grid)';
        $typeData[ 'FSDLT' ] = 'Form + Data List';
        $typeData[ 'DelC' ] = 'Delete Confirmation';
        $typeData[ 'Other' ] = 'Other (Template)';
        
        return $typeData;
        
    } // end getPageTypeArray()
    
    
    
    //************************************************************************
	/**
	 * function getSiteTemplateName
	 * <pre>
	 * Returns name of the Site Template to use by default when creating a 
	 * new object_bl/Page object.
	 * </pre>
	 * @return [STRING]
	 */
    function getSiteTemplateName() 
    {
        $type =  $this->getValueByFieldName( 'page_type' );
        
        switch( $type ) {
        
            case 'FSDLT':
                $fileName = 'siteFormDataList.php';
                break;
                
            case 'AB':
                $fileName = 'siteAdminBox.php';
                break;
                
            case 'DLS':
                $fileName = 'siteDataSingle.php';
                break;
                
            case 'DLT':
                $fileName = 'siteDataList.php';
                break;
                
            case 'FS':
                $fileName = 'siteFormSingle.php';
                break;
                
            case 'FG':
                $fileName = 'siteFormGrid.php';
                break;
                
            case 'DelC':
                $fileName = 'siteDeleteConf.php';
                break;
                
            case 'Other':
                $fileName = '';
                break;
                
        }
        
        return $fileName;
        
    } // end getSiteTemplateName()
    
    
    
    //************************************************************************
	/**
	 * function isAddType
	 * <pre>
	 * returns TRUE if this page is an Add type form.
	 * </pre>
	 * @return [BOOL] 
	 */
    function isAddType() 
    {
        return ( (int) $this->getValueByFieldName( 'page_isAdd' ) == 1);
    }
    
    
    
    //************************************************************************
	/**
	 * function isAdminBoxStyle
	 * <pre>
	 * returns TRUE if page is an admin box STYLE (includes FormSingle+List 
	 * type). FALSE otherwise.
	 * </pre>
	 * @return [BOOL]
	 */
    function isAdminBoxStyle() 
    {
        $isAdminBoxStyle = false;
        
        $type = $this->getPageType();
        
        switch ( $type ) {
            case 'FSDLT':
            case 'AB':
                $isAdminBoxStyle = true;
                break;
        }
        return $isAdminBoxStyle;
    }
    
    
    
    //************************************************************************
	/**
	 * function isCreated
	 * <pre>
	 * returns the creation status of this page object.
	 * </pre>
	 * @return [BOOL] True if created, False otherwise.
	 */
    function isCreated() 
    {
        return ( (int) $this->getValueByFieldName( 'page_isCreated' ) == 1);
    }
    
    
    
    //************************************************************************
	/**
	 * function isCustom
	 * <pre>
	 * returns TRUE if page is a cusotm STYLE. FALSE otherwise.
	 * </pre>
	 * @return [BOOL]
	 */
    function isCustom() 
    {
        $type = $this->getPageType();
        
        return ($type == 'Other');
    }
    
    
    
    //************************************************************************
	/**
	 * function isDefault
	 * <pre>
	 * returns TRUE if page is the Deafult page of a Module. FALSE otherwise.
	 * </pre>
	 * @return [BOOL]
	 */
    function isDefault() 
    {
        return ( (int) $this->getValueByFieldName( 'page_isDefault' ) == 1);
    }
    
    
    
    //************************************************************************
	/**
	 * function isUniqueName
	 * <pre>
	 * Verifies if the given name is unique.
	 * </pre>
	 * @param $name [STRING] The name to check for
	 * @param $moduleID [INTEGER] the id of the module we are searching 
	 * @return [BOOL]  True if Unique.  False otherwise.
	 */
    function isUniqueName( $name='', $moduleID='') 
    {
        
        // if moduleID not provided, then use current value in object
        if ( $moduleID == '') {
            $moduleID = $this->getValueByFieldName( 'module_id' );
        }
        
        // if module id isn't empty
        $condition = '';
        if ( $moduleID != '') {
            $condition = 'module_id='.$moduleID;
        }

        // return unique field result
        return $this->isUniqueFieldValue( $name, 'page_name', $condition );
        
    }  // end isUniqueName()
    
    
    
    //************************************************************************
	/**
	 * function setCreated
	 * <pre>
	 * sets the value of the page_isCreated flag.
	 * </pre>
	 * @return [INTEGER]
	 */
    function setCreated() 
    {
        $this->setValueByFieldName( 'page_isCreated', 1 );
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
        // set all related page labels as not being Created as well.
        $pageID = $this->getID();
        $list = new PageLabelsList( $pageID );
        $list->setFirst();
        while ($item = $list->getNext() ) {
            $item->setNotCreated();
        }
        
        $this->setValueByFieldName( 'page_isCreated', 0 );
        $this->updateDBTable();
    }

    
    	
}

?>