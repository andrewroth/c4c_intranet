<?php
/**
 * @package AccountAdmin
 */ 
/**
 * class FormProcessor_AdminPriv 
 * <pre> 
 * This page manages an accounts access priviledge into the Account Admin system.
 * </pre>
 * @author Johnny Hausman
 * Date:   19 April 2005
 */
 // RAD Tools: AdminBox Page
class  FormProcessor_AdminPriv extends PageDisplay_FormProcessor {

	//CONSTANTS:
	/** The list of form fields for this page */
	// NOTE: the format for this list is:
	//
	//         form_field_name|form_field_type|invalid_value
	//
	//             form_field_name = the name for the form field.  generally 
	//                               it is named the same as the table column 
	//                               of the data it represents
	//
	//             form_field_type = the data type of the field
    //                               T = Text / String
    //                               B = Boolean
    //                               D = Date ( 3 lists boxes day/mon/year)
    //
    //             invalid_value = A value that is considered incorrect for this
    //                             form field.  Leaving it blank is equivalent 
    //                             to form_value != '' 
    const FORM_FIELDS = 'account|T|-,viewer_id|T|<skip>,accountadminaccess_privilege|T|-';
    
    /** The list of field types to be displayed in the form */
    // NOTE: if a field isn't displayed, put a '-' for it's entry.
    const FORM_FIELD_TYPES = 'droplist,-,droplist';
    
    /** The list of fields to be displayed in the data list */
    const DISPLAY_FIELDS = 'viewer_id,accountadminaccess_privilege';
    
    /** The Querystring Field for which entry is currently being edited ... */
    const MULTILINGUAL_PAGE_KEY = 'FormProcessor_AdminPriv';

	//VARIABLES:
	
	/** @var [OBJECT] The AccessPriviledge Object. */
	protected $accessPrivilegeManager;
	
	/** @var [STRING] The path to the module's root directory. */
	protected $pathModuleRoot;
	
	/** @var [STRING] The form Action for submitting this form. */
	protected $formAction;
	
	/** @var [OBJECT] The Viewer Object. */
	protected $viewer;
	
	/** @var [ARRAY] The HREF values the links on this page. */
	protected $linkValues;
	
	/** @var [ARRAY] The labels for the links on this page. */
	protected $linkLabels;
	
	/** @var [ARRAY] Additional columns in the data list that are links. */
	protected $linkColumns;
	
	/** @var [STRING] The initilization variable for the dataManager. */
	protected $accountadminaccess_id;
	
/*[RAD_LIST_INIT]*/
	
/*[RAD_FOREIGN_KEY_VAR]*/

    /** @var [STRING] The type of Editing operation (U=Update, D=Delete). */
	protected $opType;
	
	/** @var [BOOL] Flag marking if we should delete the current entry. */
	protected $shouldDelete;
	
	/** @var [OBJECT] The data manager object (holds the form info) */
	protected $dataManager;
	
	/** @var [OBJECT] The data List object. */
	protected $dataList;
	
	/** @var [STRING] The field information to sort dataList by */
	protected $sortBy;


	//CLASS CONSTRUCTOR
	//************************************************************************
	/**
	 * function __construct
	 * <pre>
	 * Initialize the object.
	 * </pre>
	 * @param $pathModuleRoot [STRING] The path to this module's root directory
	 * @param $viewer [OBJECT] The viewer object.
	 * @param $formAction [STRING] The action on a form submit
	 * @param $sortBy [STRING] Field data to sort listManager by.
	 * @param $accountadminaccess_id [STRING] The init data for the dataManager obj
	 * @return [void]
	 */
    function __construct($pathModuleRoot, $viewer, $accessPrivMgr, $formAction, $sortBy, $accountadminaccess_id )//[RAD_FOREIGN_KEY_PARAM]
    {
        // NOTE: be sure to call the parent constructor before trying to 
        //       use the ->formXXX arrays...
        parent::__construct( $formAction, FormProcessor_AdminPriv::FORM_FIELDS,  FormProcessor_AdminPriv::FORM_FIELD_TYPES);

        $this->pathModuleRoot = $pathModuleRoot;
        $this->viewer = $viewer;
        $this->accessPrivilegeManager = $accessPrivMgr;
        $this->formAction = $formAction;
        $this->sortBy = $sortBy;
        $this->linkValues = array();
        $this->linkLabels = array();
        $this->linkColumns = array();
        
        $this->accountadminaccess_id = $accountadminaccess_id;

        $this->opType = '';
        // see what operation type (if any) is requested...
        if ( isset( $_REQUEST[ 'admOpType' ] ) ) {
        
            $this->opType = $_REQUEST[ 'admOpType' ];
        }
        $this->shouldDelete = false;
        
        // figure out the important fields for the dataManager
        $fieldsOfInterest = implode(',', $this->formFields);
        
        $this->dataManager = new RowManager_AccountAdminAccessManager( $accountadminaccess_id );
        $this->dataManager->setFieldsOfInterest( $fieldsOfInterest );
        $this->formValues = $this->dataManager->getArrayOfValues();
        if ( isset( $this->formValues['viewer_id'] ) ) {
            $this->formValues['account'] = $this->formValues['viewer_id'];
        }
        
        // now initialize the labels for this page
        // start by loading the default field labels for this Module
        $languageID = $viewer->getLanguageID();
        $seriesKey = moduleAccountAdmin::MULTILINGUAL_SERIES_KEY;
        $pageKey = moduleAccountAdmin::MULTILINGUAL_PAGE_FIELDS;
        $this->labels = new MultilingualManager( $languageID, $seriesKey, $pageKey );
        
        // then load the page specific labels for this page
        $pageKey = FormProcessor_AdminPriv::MULTILINGUAL_PAGE_KEY;
        $this->labels->loadPageLabels( $pageKey );
        
        // load the site default form link labels
        $this->labels->setSeriesKey( SITE_LABEL_SERIES_SITE );
        $this->labels->loadPageLabels( SITE_LABEL_PAGE_FORM_LINKS );
        
         
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
    }	
    
    
    
    //************************************************************************
	/**
	 * function loadFromForm
	 * <pre>
	 * Loads the data from the submitted form.
	 * </pre>
	 * @return [void]
	 */
    function loadFromForm() 
    {
        parent::loadFromForm();
        
        
        // if the button pressed was a 'Delete?' confirmation then
        if (isset( $_REQUEST[ 'submit' ] ) ) {
        
            if ( $_REQUEST[ 'submit' ] == $this->labels->getLabel('[Delete?]')) {
                
                // set shouldDelete 
                $this->shouldDelete = true;
            }
            
        }
        
        
        
    } // end loadFromForm()
    
    
    
    //************************************************************************
	/**
	 * function isDataValid
	 * <pre>
	 * Verifies the returned data is valid.
	 * </pre>
	 * @return [BOOL]
	 */
    function isDataValid() 
    {
         $isValid = parent::isDataValid();
        
        /*
         * check here for specific cases not covered by simple Field
         * Definitions.
         */
        
        // Example : error checking
        // NOTE:  a custom error label [error_UniqueModuleName] is used
        // for the error.  This error label is created in the Page Labels
        // form.
        // Make sure that module name doesn't already exist...
//        if ($isValid) {
        
//            $isValid = $this->dataManager->isUniqueModuleName();
//            $this->formErrors[ 'module_name' ] = $this->labels->getLabel( '[error_UniqueModuleName]');
///        }
        
        // now return result
        return $isValid;
        
    }
    
    
    
    //************************************************************************
	/**
	 * function processData
	 * <pre>
	 * Processes the data for this form.
	 * </pre>
	 * @return [void]
	 */
    function processData() 
    {
        // if this is a delete operation then
        if ( $this->opType == 'D' ) {
        
            if ( $this->shouldDelete ) {
            
                $this->dataManager->deleteEntry();
                
                // now make sure all the systemAccessObjects have been updated
                $moduleManager = new RowManager_siteModuleManager();
                $moduleManager->processSystemAccessRemoveAdmin( $this->formValues['account'] );
            }
            
        } else {
        // else 
        
            /*[RAD_ADMINBOX_FOREIGNKEY]*/
            
            // store values in table manager object.
            $this->formValues['viewer_id'] = $this->formValues['account'];
            
            $this->dataManager->loadFromArray( $this->formValues );
            
            if (!$this->dataManager->isLoaded()) {
                $this->dataManager->createNewEntry();
            } else {  
                $this->dataManager->updateDBTable();
            }

            // now make sure all the systemAccessObjects have been updated
            $moduleManager = new RowManager_siteModuleManager();
            $moduleManager->processSystemAccessNewAdmin( $this->formValues['viewer_id'] );
                    
        } // end if
        
        // now Clear out dataManager & FormValues
        $this->dataManager->clearValues();
        $this->formValues = $this->dataManager->getArrayOfValues();

        
        // on a successful update return accountadminaccess_id to ''
        $this->accountadminaccess_id='';
        
        
    } // end processData()
    
    
    
    //************************************************************************
	/**
	 * function getHTML
	 * <pre>
	 * This method returns the HTML data generated by this object.
	 * </pre>
	 * @return [STRING] HTML Display data.
	 */
    function getHTML() 
    {
        
        // Uncomment the following line if you want to create a template 
        // tailored for this page:
        //$path = $this->pathModuleRoot.'[RAD_PATH_TEMPLATES]';
        // Otherwise use the standard Templates for the site:
        $path = SITE_PATH_TEMPLATES;
        
        $this->template = new Template( $path );
        
        // store the form action information
        $this->template->set( 'formAction', $this->formAction );
        
        // store the link values
        // example:
            // $this->linkValues[ 'view' ] = 'add/new/href/data/here';
        $this->template->set( 'linkValues', $this->linkValues );
        
        // store the link labels
        $this->linkLabels[ 'edit' ] = $this->labels->getLabel( '[Edit]' );
        $this->linkLabels[ 'del'  ] = $this->labels->getLabel( '[Delete]' );
        $this->linkLabels[ 'cont' ] = $this->labels->getLabel( '[Continue]');
        // $this->linkLabels[ 'view' ] = 'new link label here';
        $this->template->set( 'linkLabels', $this->linkLabels );
        
        // store any additional link Columns
        // example:
            //$title = $this->labels->getLabel( '[title_groups]');
            //$columnLabel = $this->labels->getLabel( '[groups]');
            //$link = $this->linkValues[ 'groups' ];
            //$fieldName = 'accessgroup_id';
            //$this->addLinkColumn( $title, $columnLabel, $link, $fieldName);
        $this->template->set( 'linkColumns', $this->linkColumns);
        
        // store the statevar id to edit
        $this->template->set( 'editEntryID', $this->accountadminaccess_id );
        
        // store the current op type
        $this->template->set( 'opType', $this->opType );
        
        // store the page labels in XML format...
        // NOTE: use this location to update any label tags ...
        // example:
            // $name = $user->getName();
            // $this->labels->setLabelTag( '[Title]', '[userName]', $name);
        $this->template->setXML( 'pageLabels', $this->labels->getLabelXML() );
        
        // store all the fields to the template
        $this->setFormFieldsToTemplate();
        
        /*
         * Form related Template variables:
         */
        // save the list of form fields
        $this->template->set( 'formFieldList', $this->formFields);
        
        // store the field types being displayed
        $fieldTypes = explode(',', FormProcessor_AdminPriv::FORM_FIELD_TYPES);
        $this->template->set( 'formFieldType', $fieldTypes);
        
        
        // Insert the date start/end values for the following date fields:
        // example:
            //$this->template->set( 'startYear_[fieldName]', 2000);
            //$this->template->set( 'endYear_[fieldName]', 2010);
/*[RAD_DAOBJ_FIELD_DATE_PARAM]*/


        /*
         * List related Template variables :
         */
        // Store the XML Node name for the Data Access Field List
        $this->dataList = $this->accessPrivilegeManager->getListAccountPriviledgeAccess( $this->sortBy );
        $xmlNodeName = $this->dataList->getRowManagerXMLNodeName();
        $this->template->set( 'rowManagerXMLNodeName', $xmlNodeName);
        
        // store the primary key field name for the data being displayed
        $this->template->set( 'primaryKeyFieldName', 'accountadminaccess_id');
        
        // store data list to the template
        // NOTE: we initialize it here to make sure we capture any new data 
        // from a recent processData() call.

        $this->template->setXML( 'dataList', $this->dataList->getXML() );
        
        // store the field names being displayed
        $fieldNames = explode(',', FormProcessor_AdminPriv::DISPLAY_FIELDS);
        $this->template->set( 'dataFieldList', $fieldNames);
        
        
        
        
        /*
         * Add any additional data required by the template here
         */
        
        // get a list of viewer_id's that are currently in the table
        $this->dataList = new AccountAdminAccessList( $this->sortBy );
        $entryArray = $this->dataList->getDropListArray();

        // get a list of all viewer_id's
        $viewer = new RowManager_ViewerManager();
        $viewer->setSortOrder( 'viewer_userID' );
        $viewerList = $this->accessPrivilegeManager->getListViewerAccounts( 'viewer_userID' );
        $viewerArray = $viewerList->getDropListArray();
        
        // since list from dataList has viewer_id as value we need to 
        // flip the array from the viewerList so that viewer_id is also 
        // in values (we'll return the resulting array's back to the 
        // proper positions later)
        $flippedArray = array_flip( $viewerArray );
        
        // The difference between the two arrays defines the droplist box
        // e.g. we remove the entries already in the table from the 
        // whole list of viewers
        $dropListArray = array_diff( $flippedArray, $entryArray);
        
        // The intersection of the 2 arrays defines the list for displaying
        // the account names for the entries in the list.
        $rowListArray = array_intersect( $flippedArray, $entryArray);
        
        // set the two arrays (making sure they are properly fliped back to 
        // normal)
        $this->template->set( 'list_viewer_id', array_flip($rowListArray) );
        
        // if there is an entry to edit/delete then 
        if ( $this->accountadminaccess_id != '' ) {
            // pass the row list for the dropList
            $this->template->set( 'list_account', array_flip($rowListArray) );
        } else {
            // else pass the dropList array
            $this->template->set( 'list_account', array_flip($dropListArray) );
        }    
        
        // get Access Privilege List
        $privList = $this->dataManager->getAccessPrivilegeArray( $this->labels, $this->accessPrivilegeManager->getAccessPrivilege() );
        $this->template->set( 'list_accountadminaccess_privilege', $privList);
        
        $templateName = 'siteAdminBox.php';
		return $this->template->fetch( $templateName );
        
    }
    
    
    
    //************************************************************************
	/**
	 * function addLinkColumn
	 * <pre>
	 * Adds a value to the linkColumn array.
	 * </pre>
	 * @param $title [STRING] The label to display for the column title
	 * @param $label [STRING] The label to display for the link
	 * @param $link  [STRING] the href value for the link
	 * @param $fieldName [STRING] the name of the field used to complete 
	 * the link
	 * @return [void]
	 */
    function addLinkColumn($title, $label, $link, $fieldName ) 
    {
        $entry = array();
        $entry[ 'title' ] = $title;
        $entry[ 'label' ] = $label;
        $entry[ 'link' ] = $link;
        $entry[ 'field' ] = $fieldName;
        
        $this->linkColumns[] = $entry;
    }
    
    
    
    //************************************************************************
	/**
	 * function setLinks
	 * <pre>
	 * Sets the value of the linkValues array.
	 * </pre>
	 * @param $links [ARRAY] Array of Link Values
	 * @return [void]
	 */
    function setLinks($links) 
    {
        $this->linkValues = $links;
    }
    
    
    
    //************************************************************************
	/**
	 * function setFormAction
	 * <pre>
	 * Sets the value of the Form Action Link.
	 * </pre>
	 * @param $link [STRING] The HREF link for the continue link
	 * @return [void]
	 */
    function setFormAction($link) 
    {
        $this->formAction = $link;
    }
    
	
}

?>