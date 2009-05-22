<?php
/**
 * @package AccountAdmin
 */ 
/**
 * class FormProcessor_AddViewer 
 * <pre> 
 * Adds a new account to the web site.
 * </pre>
 * @author Johnny Hausman
 * Date:   21 Mar 2005
 */
class  FormProcessor_AddViewer extends PageDisplay_FormProcessor {

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
	//             form_field_type = the type of form field
    //                               T = Text / String
    //                               B = Boolean
    //                               D = Date ( 3 lists boxes day/mon/year)
    //
    //             invalid_value = A value that is considered incorrect for this
    //                             form field.  Leaving it blank is equivalent 
    //                             to form_value != ''.  If a variable is able
    //                             to be left empty ('') then put the keyword
    //                             '<skip>' for this value. 
    const FORM_FIELDS = 'accountgroup_id|T|<skip>,viewer_userID|T|,viewer_passWord|T|,pword2|T|,language_id|T|-,viewer_isActive|B|';
    
    /** The list of field types to be displayed in the form */
    // NOTE: if a field isn't displayed, put a '-' for it's entry.
    const FORM_FIELD_TYPES = '-,textbox,password,password,droplist,checkbox';
    
    /** The Multilingual Page Key for this page */
    const MULTILINGUAL_PAGE_KEY = 'FormProcessor_AddViewer';

	//VARIABLES:
	
	/** @var [STRING] The path to the module's root directory. */
	protected $pathModuleRoot;
	
	/** @var [STRING] The form Action for submitting this form. */
	protected $formAction;
	
	/** @var [OBJECT] The Viewer Object. */
	protected $viewer;
		
    /** @var [STRING] The initialization data for the dataManager. */
	protected $viewer_id;
	
	/** @var [INTEGER] Foreign Key needed by Data Manager */
	protected $accountgroup_id;
	
	/** @var [OBJECT] The data manager object. */
	protected $dataManager;


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
	 * @param $viewer_id [INTEGER] Value used to initialize the dataManager
	 * @param $accountgroup_id [INTEGER] The foreign key data for the data Manager
	 * @return [void]
	 */
    function __construct($pathModuleRoot, $viewer, $formAction, $viewer_id , $accountgroup_id='') 
    {
        // NOTE: be sure to call the parent constructor before trying to 
        //       use the ->formXXX arrays...
        parent::__construct( $formAction, FormProcessor_AddViewer::FORM_FIELDS, FormProcessor_AddViewer::FORM_FIELD_TYPES );

        $this->pathModuleRoot = $pathModuleRoot;
        $this->viewer = $viewer;
        $this->formAction = $formAction;
        $this->viewer_id = $viewer_id;
        $this->accountgroup_id = $accountgroup_id;

        
        // figure out the important fields for the dataManager
        $fieldsOfInterest = implode(',', $this->formFields);
        
        $this->dataManager = new RowManager_ViewerManager( $viewer_id );
        $this->dataManager->setFieldsOfInterest( $fieldsOfInterest );
        $this->formValues = $this->dataManager->getArrayOfValues();

        // now initialize the labels for this page
        // start by loading the default field labels for this Module
        $languageID = $viewer->getLanguageID();
        $seriesKey = moduleAccountAdmin::MULTILINGUAL_SERIES_KEY;
        $pageKey = moduleAccountAdmin::MULTILINGUAL_PAGE_FIELDS;
        $this->labels = new MultilingualManager( $languageID, $seriesKey, $pageKey );
        
        // then load the page specific labels for this page
        $pageKey = FormProcessor_AddViewer::MULTILINGUAL_PAGE_KEY;
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
        
        /*
         * Put any additional data manipulations here.
         * if you don't need to do anything else, you should 
         * just remove this method and let the parent method get
         * called directly.
         */
        
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
        if ($isValid) {
            
            $pword = $this->formValues[ 'viewer_passWord' ];
            $pword2 = $this->formValues[ 'pword2' ];
            if( $pword != $pword2 ) {
            
                $isValid = false;
                $this->formErrors[ 'viewer_passWord' ] = $this->labels->getLabel( '[error_passwordMatch]');
                
            }
        
            $userID = $this->formValues[ 'viewer_userID' ];
            if ( !$this->dataManager->isUniqueUserID( $userID ) ) {
                
                $isValid = false;
                $this->formErrors[ 'viewer_userID' ] = $this->labels->getLabel( '[error_uniqueUserID]');
            }
        }
        

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
        // save the value of the Foriegn Key(s)
        $this->formValues[ 'accountgroup_id' ] = $this->accountgroup_id;
        /*[RAD_ADMINBOX_FOREIGNKEY]*/
        
        // store values in table manager object.
        if (!$this->dataManager->isLoaded()) {
            $this->dataManager->createNewEntry();
        }
        $this->dataManager->loadFromArray( $this->formValues );
        
        $accessGroupManager = new RowManager_AccessGroupManager();
        $allAccessGroupID = $accessGroupManager->getAllAccessGroupID();

        // don't need this for CIM stuff - RM
        // $hrdbGroupID = $accessGroupManager->getHRDBAccessGroupID();
        // echo 'hrdbGroupID['.$hrdbGroupID.']<br/>';
        //$this->dataManager->setAccountGroup($allAccessGroupID);
        $viewerAccessGroup = new RowManager_ViewerAccessGroupManager();

        //$hrdbGroupID = 34;
        // $defaultGroups = array($allAccessGroupID, $hrdbGroupID);
        $defaultGroups = array($allAccessGroupID );
        
        for ($i=0; $i<count($defaultGroups);$i++)
        {
            //load values
            $values = array();
            //print($this->dataManager->getID() . "<br>");
            //print($allAccessGroupID);
            $values[ 'viewer_id' ] = $this->dataManager->getID();
            //$values[ 'accessgroup_id' ] = $allAccessGroupID;
            $values[ 'accessgroup_id' ] = $defaultGroups[$i];
            $viewerAccessGroup->loadFromArray( $values );
        //var_export($viewerAccessGroup);
        // update DB Table

            $viewerAccessGroup->createNewEntry();
        }
                
        // Make sure password is set using the dataManager's routines 
        // (for encryption)
        $pword = $this->formValues[ 'viewer_passWord' ];
        $this->dataManager->setPassWord( $pword );
        
        $this->dataManager->updateDBTable();
        
        
        // now make sure all the systemAccessObjects have been updated
        $moduleManager = new RowManager_siteModuleManager();
        $moduleManager->processSystemAccessNewViewer( $this->dataManager->getID() );
        
        
        
        
        
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
        
        $this->template = new Template( $path );
        
        // store any additional values to template
        $this->template->set( 'formAction', $this->formAction );
        
        // store the page labels in XML format...
        // NOTE: use this location to update any label tags ...
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
        $fieldTypes = explode(',', FormProcessor_AddViewer::FORM_FIELD_TYPES);
        $this->template->set( 'formFieldType', $fieldTypes);
        
        // store the button label
        $this->template->set( 'buttonText', $this->labels->getLabel('[Add]') );
                
        /*
         * Add any additional data required by the template here
         */
        $languageManager = new RowManager_LanguageManager( );
        $seriesKey = moduleAccountAdmin::MULTILINGUAL_SERIES_KEY;
        $pageKey = RowManager_LanguageManager::XML_NODE_NAME;
        $bridgeMultiLingualManager = new MultilingualManager( $this->viewer->getLanguageID(), $seriesKey, $pageKey );
        $bridgeManager = new LanguageLabelBridge($languageManager, $bridgeMultiLingualManager );
        $languageList = $bridgeManager->getListIterator();
        $languageArray = $languageList->getDropListArray( );
        $this->template->set( 'list_language_id', $languageArray );

		// uncomment this line if you are creating a template for this page
		//$templateName = 'page_AddViewer.php';
		// otherwise use the generic admin box template
		$templateName = 'siteFormSingle.php';
		
		return $this->template->fetch( $templateName );
        
    }
    
	
}

?>