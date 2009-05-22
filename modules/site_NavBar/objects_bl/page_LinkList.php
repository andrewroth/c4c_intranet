<?php
/**
 * @package NavBar
 */ 
/**
 * class FormProcessor_LinkList 
 * <pre> 
 * Displays a list of links for the given Group.
 * </pre>
 * @author Johnny Hausman
 * Date:   23 Aug 2005
 */
 // RAD Tools: AdminBox Page
class  FormProcessor_LinkList extends PageDisplay_FormProcessor_AdminBox {

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
    //                               N = Numeric 
    //                               B = Boolean
    //                               D = Date ( 3 lists boxes day/mon/year)
    //
    //             invalid_value = A value that is considered incorrect for this
    //                             form field.  Leaving it blank is equivalent 
    //                             to form_value != '' 
    const FORM_FIELDS = 'navbarlink_id|N|<skip>,label_label|T|,navbarlink_url|T|<skip>,module_id|N|<skip>,navbarlink_isActive|B|,navbargroup_id|T|<skip>';
    
    /** The list of field types to be displayed in the form */
    // NOTE: if a field isn't displayed, put a '-' for it's entry.
    const FORM_FIELD_TYPES = '-,textbox,textarea|20|4,droplist,checkbox,-';
    
    /** The list of fields to be displayed in the data list */
    const DISPLAY_FIELDS = 'label_label,navbarlink_url,module_id,navbarlink_isActive';
    
    /** The Querystring Field for which entry is currently being edited ... */
    const MULTILINGUAL_PAGE_KEY = 'FormProcessor_LinkList';

	//VARIABLES:
	
    /** @var [OBJECT] The multilingual manager used for initializing RowLabelBridge Objects for this page. */
	protected $bridgeMultiLingualManager;
	
    /** @var [STRING] The initialization variable for the dataList */
    protected $navbargroup_id;
	
	/** @var [STRING] The initilization variable for the dataManager. */
	protected $navbarlink_id;
	
	/** @var [STRING] The path to the module's root directory. */
	protected $pathModuleRoot;
	




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
	 * @param $navbarlink_id [STRING] The init data for the dataManager obj
	 * @param $navbargroup_id [STRING] The init data for the dataList obj
	 * @return [void]
	 */
    function __construct($pathModuleRoot, $viewer, $formAction, $sortBy, $navbarlink_id, $navbargroup_id="" )
    {
        // NOTE: be sure to call the parent constructor before trying to 
        //       use the ->formXXX arrays...
        $fieldList = FormProcessor_LinkList::FORM_FIELDS;
        $fieldTypes = FormProcessor_LinkList::FORM_FIELD_TYPES;
        $displayFields = FormProcessor_LinkList::DISPLAY_FIELDS;
        parent::__construct($viewer, $formAction, $sortBy, $fieldList, $fieldTypes, $displayFields );


        $this->pathModuleRoot = $pathModuleRoot;
        
        $this->navbarlink_id = $navbarlink_id;
        $this->navbargroup_id = $navbargroup_id;

        
        // figure out the important fields for the dataManager
        $fieldsOfInterest = implode(',', $this->formFields);
        
        $linkManager = new RowManager_NavBarLinksManager( $navbarlink_id );
        
        $seriesKey = moduleNavBar::MULTILINGUAL_SERIES_KEY;
        $pageKey = $linkManager->getXMLNodeName();
        $this->bridgeMultiLingualManager = new MultilingualManager( $viewer->getLanguageID(), $seriesKey, $pageKey );
        

        $this->dataManager = new RowLabelBridge($linkManager, $this->bridgeMultiLingualManager );      
        $this->dataManager->setFieldsOfInterest( $fieldsOfInterest );
        $this->formValues = $this->dataManager->getArrayOfValues();
    

        // now initialize the labels for this page
        // start by loading the default field labels for this Module
        $languageID = $viewer->getLanguageID();
        $seriesKey = moduleNavBar::MULTILINGUAL_SERIES_KEY;
        $pageKey = moduleNavBar::MULTILINGUAL_PAGE_FIELDS;
        $this->labels = new MultilingualManager( $languageID, $seriesKey, $pageKey );
        
        // then load the page specific labels for this page
        $pageKey = FormProcessor_LinkList::MULTILINGUAL_PAGE_KEY;
        $this->labels->loadPageLabels( $pageKey );
        
        // load the site default form link labels
        $this->labels->setSeriesKey( SITE_LABEL_SERIES_SITE );
        $this->labels->loadPageLabels( SITE_LABEL_PAGE_FORM_LINKS );
        
        $this->labels->loadPageLabels( SITE_LABEL_PAGE_FORMERRORS );
         
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
            }
            
        } else {
        // else 
        
            // save the value of the Foriegn Key(s)
            $this->formValues[ 'navbargroup_id' ] = $this->navbargroup_id;
            $this->formValues[ 'navbarlink_id' ] = $this->navbarlink_id;
        /*[RAD_ADMINBOX_FOREIGNKEY]*/
            
            // Store values in dataManager object
            $this->dataManager->loadFromArray( $this->formValues );

            // Save the values into the Table.
            if (!$this->dataManager->isLoaded()) {
                $this->dataManager->createNewEntry();
            } else {
                $this->dataManager->updateDBTable();
            }
            
            
            
        } // end if
        
        // now tell Cache Manager to reset the cache entries...
        $cacheManager = new RowManager_NavBarCacheManager();
        $cacheManager->flushCacheEntries();
        
        // now Clear out dataManager & FormValues
        $this->dataManager->clearValues();
        $this->formValues = $this->dataManager->getArrayOfValues();

        
        // on a successful update return navbarlink_id to ''
        $this->navbarlink_id='';
        
        
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
        //$path = $this->pathModuleRoot.'templates/';
        // Otherwise use the standard Templates for the site:
        $path = SITE_PATH_TEMPLATES;
        
        
        
        /*
         * store the link values
         */
        // example:
            // $this->linkValues[ 'view' ] = 'add/new/href/data/here';


        // store the link labels
        $this->linkLabels[ 'edit' ] = $this->labels->getLabel( '[Edit]' );
        $this->linkLabels[ 'del'  ] = $this->labels->getLabel( '[Delete]' );
        $this->linkLabels[ 'cont' ] = $this->labels->getLabel( '[Continue]');
        // $this->linkLabels[ 'view' ] = 'new link label here';

        
        
        /*
         * store any additional link Columns
         */
        // example:
            $title = $this->labels->getLabel( '[title_access_groups]');
            $columnLabel = $this->labels->getLabel( '[accessGroups]');
            $link = $this->linkValues[ 'accessGroups' ];
            $fieldName = 'navbarlink_id';
            $this->addLinkColumn( $title, $columnLabel, $link, $fieldName);
            
            $title = $this->labels->getLabel( '[title_viewer]');
            $columnLabel = $this->labels->getLabel( '[viewers]');
            $link = $this->linkValues[ 'viewers' ];
            $fieldName = 'navbarlink_id';
            $this->addLinkColumn( $title, $columnLabel, $link, $fieldName);
            
            
        /*
         * Update any label tags ...
         */
        // example:
        $groupManager = new RowManager_NavBarGroupManager( $this->navbargroup_id );
        $seriesKey = moduleNavBar::MULTILINGUAL_SERIES_KEY;
        $pageKey = $groupManager->getXMLNodeName();
        $groupMultiLingual = new MultilingualManager( $this->viewer->getLanguageID(), $seriesKey, $pageKey );
        $bridgeManager = new RowLabelBridge($groupManager, $groupMultiLingual ); 
        $name = $bridgeManager->getLabel();
        $this->labels->setLabelTag( '[Title]', '[groupName]', $name);


        // NOTE:  this parent method prepares the $this->template with the 
        // common AdminBox data.  
        $this->prepareTemplate( $path );
        
        
        // store the statevar id to edit
        $this->template->set( 'editEntryID', $this->navbarlink_id );
        
        


        
        // store all the fields to the template
        $this->setFormFieldsToTemplate();
        
        /*
         * Form related Template variables:
         */
        
        
        /*
         * Insert the date start/end values for the following date fields:
         */
        // example:
            //$this->template->set( 'startYear_[fieldName]', 2000);
            //$this->template->set( 'endYear_[fieldName]', 2010);



        /*
         * List related Template variables :
         */
        // Store the XML Node name for the Data Access Field List
        $xmlNodeName = $this->dataManager->getXMLNodeName();
        $this->template->set( 'rowManagerXMLNodeName', $xmlNodeName);
        
        // store the primary key field name for the data being displayed
        $this->template->set( 'primaryKeyFieldName', 'navbarlink_id');
        
        // store data list to the template
        // NOTE: we initialize it here to make sure we capture any new data 
        // from a recent processData() call.
//        $this->dataList = new NavBarLinksList( $this->navbargroup_id, $this->sortBy );
        
        $linkManager = new RowManager_NavBarLinksManager( );
        $linkManager->setGroupID( $this->navbargroup_id );
        $bridgeManager = new RowLabelBridge($linkManager, $this->bridgeMultiLingualManager ); 
        $bridgeManager->setSortOrder( $this->sortBy );
        $this->dataList = $bridgeManager->getListIterator();
        $this->template->setXML( 'dataList', $this->dataList->getXML() );
        
        
        /*
         * Add any additional data required by the template here
         */
         
        $moduleManager = new RowManager_siteModuleManager();
        $moduleManager->setSortOrder( $moduleManager->getLabelField() );
        $moduleList = $moduleManager->getListIterator();
        $this->template->set( 'list_module_id', $moduleList->getDropListArray() );
        
        $dateList = array('0000-00-00 00:00:00'=>'');
        $this->template->set( 'list_navbarlink_startDateTime', $dateList );
        $this->template->set( 'list_navbarlink_endDateTime', $dateList );
         
        
        $templateName = TEMPLATE_ADMIN_BOX;
        // if you are creating a custom template for this page then 
		// replace $templateName with the following:
		//$templateName = 'page_LinkList.php';
		
		return $this->template->fetch( $templateName );
        
    }
    
    	
}

?>