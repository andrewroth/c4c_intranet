<?php
/**
 * @package cim_sch
 */ 
/**
 * class FormProcessor_ManageGroup 
 * <pre> 
 * An interface into editing and creating groups
 * </pre>
 * @author Calvin Jien & Russ Martin
 * Date:   03 Apr 2008
 */
 // RAD Tools: FormSingleEntry Page
class  FormProcessor_ManageGroup extends PageDisplay_FormProcessor {

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
    //                               N = Numeric 
    //                               B = Boolean
    //                               D = Date ( 3 lists boxes day/mon/year)
    //                            Time = Time ( 3 list boxes  HH/MM/Am )
    //                        DateTime = Date + Time pickers ...
    //
    //             invalid_value = A value that is considered incorrect for this
    //                             form field.  Leaving it blank is equivalent 
    //                             to form_value != ''.  If a variable is able
    //                             to be left empty ('') then put the keyword
    //                             '<skip>' for this value. 
    const FORM_FIELDS = 'groupType_id|N|,group_name|T|,group_desc|T|';
    
    /** The list of field types to be displayed in the form */
    // NOTE: if a field isn't displayed, put a '-' for it's entry.
    const FORM_FIELD_TYPES = 'droplist,textbox,textarea';
    
    /** The Multilingual Page Key for this page */
    const MULTILINGUAL_PAGE_KEY = 'FormProcessor_ManageGroup';

	//VARIABLES:
	
	/** @var [STRING] The path to the module's root directory. */
	protected $pathModuleRoot;
	
	/** @var [OBJECT] The Viewer Object. */
	protected $viewer;
		
    /** @var [STRING] The initialization data for the dataManager. */
	protected $group_id;
	
	/** @var [INTEGER] Foreign Key needed by Data Manager */
	protected $groupType_id;
	
	// info related to the newly created group in processData
	protected $newGroupID;
	protected $newGroupTypeID;

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
	 * @param $group_id [INTEGER] Value used to initialize the dataManager
	 * @param $groupType_id [INTEGER] The foreign key data for the data Manager
	 * @return [void]
	 */
    function __construct($pathModuleRoot, $viewer, $formAction, $group_id , $groupType_id='') 
    {
        // NOTE: be sure to call the parent constructor before trying to 
        //       use the ->formXXX arrays...
        $fieldList = FormProcessor_ManageGroup::FORM_FIELDS;
        $fieldDisplayTypes = FormProcessor_ManageGroup::FORM_FIELD_TYPES;
        parent::__construct( $formAction, $fieldList, $fieldDisplayTypes  );

        $this->pathModuleRoot = $pathModuleRoot;
        $this->viewer = $viewer;

        $this->group_id = $group_id;
        $this->groupType_id = $groupType_id;

        
        // figure out the important fields for the dataManager
        $fieldsOfInterest = implode(',', $this->formFields);
        
        $this->dataManager = new RowManager_GroupManager( $group_id );
        $this->dataManager->setFieldsOfInterest( $fieldsOfInterest );
        $this->formValues = $this->dataManager->getArrayOfValues();

        // now initialize the labels for this page
        // start by loading the default field labels for this Module
        $languageID = $viewer->getLanguageID();
        $seriesKey = modulecim_sch::MULTILINGUAL_SERIES_KEY;
        $pageKey = modulecim_sch::MULTILINGUAL_PAGE_FIELDS;
        $this->labels = new MultilingualManager( $languageID, $seriesKey, $pageKey );
        
        // then load the page specific labels for this page
        $pageKey = FormProcessor_ManageGroup::MULTILINGUAL_PAGE_KEY;
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
        // save the value of the Foriegn Key(s)
        // $this->formValues[ 'groupType_id' ] = $this->groupType_id;
        /*[RAD_ADMINBOX_FOREIGNKEY]*/
        
        // store values in table manager object.
        $this->dataManager->loadFromArray( $this->formValues );
        
        // now update the DB with the values
        if (!$this->dataManager->isLoaded()) {
            $this->dataManager->createNewEntry();
            //also need to add the user to be a group admin
            $permissionsGroupAdminManager = new RowManager_PermissionsGroupAdminManager();
            $permissionsGroupAdminManager->setViewerID($this->viewer->getViewerID());
            $permissionsGroupAdminManager->setGroupID( $this->dataManager->getGroupID() );
            $permissionsGroupAdminManager->createNewEntry();
   
        } else {
            $this->dataManager->updateDBTable();

        }
        
        // retrieve the ID of the newly created/updated group
        $this->newGroupID = $this->dataManager->getID();
        // echo "The ID of the newly created group is [".$this->newGroupID."]<br/>";
        
        $this->newGroupTypeID = $this->dataManager->getGroupTypeID();
        // echo "The groupType ID of the newly created group is [".$this->newGroupTypeID."]<br/>";
        
        
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
        
        
        
        // store the page labels in XML format...
        // NOTE: use this location to update any label tags ...
        // $name = $user->getName();
        // $this->labels->setLabelTag( '[Title]', '[userName]', $name);

        
        
        // NOTE:  this parent method prepares the $this->template with the 
        // common Form data.  
        $this->prepareTemplate( $path );
                
                

        /*
         * Form related Template variables:
         */
        
        // store the button label
        $this->template->set( 'buttonText', $this->labels->getLabel('[Update]') );
        


        // Insert the date start/end values for the following date fields:
        // example:
            //$this->template->set( 'startYear_[fieldName]', 2000);
            //$this->template->set( 'endYear_[fieldName]', 2010);

                


        /*
         * Add any additional data required by the template here
         */
        /*         
        //get a list of campuses that you have access to
        $campusManager = new RowManager_CampusManager();
        $campusManagerList = new ListIterator($campusManager);
        $campusArray = $campusManagerList->getDropListArray();
        $this->template->set('list_campus_id',$campusArray );
        

        $permissionsCampusAdminManager = new RowManager_PermissionsCampusAdminManager();
        $permissionsCampusAdminManager->setViewerID($this->viewer->getViewerID());
        $permissionsCampusAdminManagerList = new ListIterator($permissionsCampusAdminManager);
        $permissionsCampusArray = $permissionsCampusAdminManagerList->getDropListArray();
        echo"<br>".print_r ($permissionsCampusArray)."<br>";
        $this->template->set('list_campus_id',$permissionsCampusArray );*/
        
         // get a list of all group types
        $groupType = new RowManager_GroupTypeManager();
        $groupTypeList = new ListIterator($groupType);	
        $groupArray = $groupTypeList->getDropListArray();
        $this->template->set( 'list_groupType_id', $groupArray );
        

		// uncomment this line if you are creating a template for this page
		//$templateName = 'page_ManageGroup.php';
		// otherwise use the generic admin box template
		$templateName = 'siteFormSingle.php';
		
		return $this->template->fetch( $templateName );
        
    }
    
    function getNewGroupID()
    {
        return $this->newGroupID;
    }
    
    function getNewGroupTypeID()
    {
        return $this->newGroupTypeID;
    }
    
	
}

?>