<?php
$toolName = 'modules/app_cim_reg/objects_da/SuperAdminAssignmentManager.php';
$toolPath = Page::findPathExtension( $toolName );
require_once( $toolPath.$toolName);

$toolName = 'modules/app_cim_reg/objects_da/EventAdminAssignmentManager.php';
$toolPath = Page::findPathExtension( $toolName );
require_once( $toolPath.$toolName);

$toolName = 'modules/app_cim_reg/objects_da/PrivilegeManager.php';
$toolPath = Page::findPathExtension( $toolName );
require_once( $toolPath.$toolName);



/**
 * @package cim_hrdb
 */ 
/**
 * class page_HrdbHome 
 * <pre> 
 * Home of the hrdb section.
 * </pre>
 * @author CIM Team
 * Date:   17 Mar 2006
 */
 // RAD Tools: Custom Page
class  page_HrdbHome extends PageDisplay_FormProcessor_AdminBox {

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
    //                            Time = Time ( 3 list boxes  HH/MM/Am )
    //                        DateTime = Date + Time pickers ...
    //
    //             invalid_value = A value that is considered incorrect for this
    //                             form field.  Leaving it blank is equivalent 
    //                             to form_value != '' 
    const FORM_FIELDS = 'person_id|N|';
    
    /** The list of field types to be displayed in the form */
    // NOTE: if a field isn't displayed, put a '-' for it's entry.
    const FORM_FIELD_TYPES = 'droplist';
    
    /** The list of fields to be displayed in the data list */
    const DISPLAY_FIELDS = 'event_id,registration_id,registration_status,registration_balance';
    
    /** The Querystring Field for which entry is currently being edited ... */
    const MULTILINGUAL_PAGE_KEY = 'page_HrdbHome';

	//VARIABLES:
	
	/** @var [STRING] The path to the module's root directory. */
	protected $pathModuleRoot;
	
	/** @var [INTEGER] The initilization variable for the dataManager. */
	protected $person_id;

	/** @var [INTEGER] the key used for editing list entries **/
	protected $registration_id;

	/** @var [OBJECT] The viewer object. */
	protected $viewer;



	//CLASS CONSTRUCTOR
	//************************************************************************
	/**
	 * function __construct
	 * <pre>
	 * Initialize the object.
	 * </pre>
	 * @param $pathModuleRoot [STRING] The path to the module's root dir.
	 * @param $viewer [OBJECT] The viewer object.
	 * @param $formAction [STRING] The action on a form submit
	 * @param $sortBy [STRING] Field data to sort listManager by.
	 * @return [void]
	 */				
    function __construct($pathModuleRoot, $viewer, $formAction, $sortBy, $person_id = '') 
    {
    
        // NOTE: be sure to call the parent constructor before trying to 
        //       use the ->formXXX arrays...
        $fieldList = page_HrdbHome::FORM_FIELDS;
        $fieldTypes = page_HrdbHome::FORM_FIELD_TYPES;
        $displayFields = page_HrdbHome::DISPLAY_FIELDS;
        parent::__construct($viewer, $formAction, $sortBy, $fieldList, $fieldTypes, $displayFields );
        
        // initialzie the object values
        $this->pathModuleRoot = $pathModuleRoot;
        $this->viewer = $viewer;
        
        $this->person_id = $person_id;
        // ?????? $this->registration_id = $registration_id;
        
        // figure out the important fields for the dataManager
//         $fieldsOfInterest = implode(',', $this->formFields);
        
//         if ($person_id != '')
//         {
	        $this->dataManager = new RowManager_PersonManager( $person_id );
// 	        $this->dataManager->setFieldsOfInterest( $fieldsOfInterest );
	        $this->dataManager->setSortOrder( 'person_lname,person_fname' );
	        $this->formValues = $this->dataManager->getArrayOfValues();
//         }
    

        // now initialize the labels for this page
        // start by loading the default field labels for this Module
        $languageID = $viewer->getLanguageID();
        $seriesKey = modulecim_hrdb::MULTILINGUAL_SERIES_KEY;
        $pageKey = page_HrdbHome::MULTILINGUAL_PAGE_KEY;
        $this->labels = new MultilingualManager( $languageID, $seriesKey, $pageKey );
        
        // then load the page specific labels for this page
        $pageKey = page_HrdbHome::MULTILINGUAL_PAGE_KEY;
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
    
//         // if this is a delete operation then
//         if ( $this->opType == 'D' ) {
//         
//             if ( $this->shouldDelete ) {
//             
//                 $this->dataManager->deleteEntry();
//             }
//             
//         } else {
// 	        // Store values in dataManager object
//             $this->dataManager->loadFromArray( $this->formValues );
//             
//             // Save the values into the Table.
//             if (!$this->dataManager->isLoaded()) {
//                 $this->dataManager->createNewEntry();
//             } else {
//                 $this->dataManager->updateDBTable();
//             }
//     
//             
//         } // end if

		  $this->person_id = $this->formValues['person_id'];

        $this->dataManager = new RowManager_PersonManager( $this->person_id );
// 	        $this->dataManager->setFieldsOfInterest( $fieldsOfInterest );
        $this->dataManager->setSortOrder( 'person_lname,person_fname' );
        $this->formValues = $this->dataManager->getArrayOfValues();

        
        // on a successful update return pricerules_id to ''
        $this->registration_id='';
        
        
    } // end processData()
        
    
    //************************************************************************
	/**
	 * function getHTML
	 * <pre>
	 * This method returns the HTML data generated by this object.
	 * </pre>
	 * @return [STRING] HTML Display data.
	 *
	 * ON JAN 2, 2008 Russ made two changes to this page to restore the original functionality... they are documented below.
	 * ON JAN 8, 2008 Hobbe added conditional statements to allow registration record searches IF viewer has Reg. Sys. Super Admin privs.
	 */
    function getHTML() 
    {
	    
        
        // Uncomment the following line if you want to create a template 
        // tailored for this page:
        
        
         $privManager = new PrivilegeManager( $this->viewer->getID() );  
         if ($privManager->isSuperAdmin()==true)	
         {	
	         $path = SITE_PATH_TEMPLATES;
	      }
	      else
	      {
        		// Changed by RM from using the assignment below on Jan 2, 2008.
        		$path = $this->pathModuleRoot.'templates/';
     		}
        // Otherwise use the standard Templates for the site:
        // $path = SITE_PATH_TEMPLATES;
        
        
        
        /*
         * store the link values
         */
        // example:
            // $this->linkValues[ 'view' ] = 'add/new/href/data/here';


        // store the link labels
        $this->linkLabels[ 'edit' ] = $this->labels->getLabel( '[Edit]' );
        $this->linkLabels[ 'del'  ] = $this->labels->getLabel( '[Delete]' );
//         $this->linkLabels[ 'cont' ] = $this->labels->getLabel( '[Continue]');
        // $this->linkLabels[ 'view' ] = 'new link label here';

        
        
        /*
         * store any additional link Columns
         */
        // example:
            //$title = $this->labels->getLabel( '[title_groups]');
            //$columnLabel = $this->labels->getLabel( '[groups]');
            //$link = $this->linkValues[ 'groups' ];
            //$fieldName = 'accessgroup_id';
            //$this->addLinkColumn( $title, $columnLabel, $link, $fieldName);
            
            
        /*
         * Update any label tags ...
         */
        // example:
            // $name = $user->getName();
            // $this->labels->setLabelTag( '[Title]', '[userName]', $name);


        // NOTE:  this parent method prepares the $this->template with the 
        // common AdminBox data.  
        $this->prepareTemplate( $path );
              
        // store the statevar id to edit
        $this->template->set( 'editEntryID', $this->registration_id );

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
        $xmlNodeName = RowManager_RegistrationManager::XML_NODE_NAME;
        $this->template->set( 'rowManagerXMLNodeName', $xmlNodeName);
        
        // store the primary key field name for the data being displayed
        $this->template->set( 'primaryKeyFieldName', 'registration_id');
        
        // store data list to the template
        // NOTE: we initialize it here to make sure we capture any new data 
        // from a recent processData() call.
        
        if ($this->person_id != '')
        {
	        $dataAccessManager = new RowManager_RegistrationManager();
	        $dataAccessManager->setPersonID( $this->person_id);
	        $dataAccessManager->setSortOrder( $this->sortBy );
	//        $this->dataList = new PriceRuleList( $this->sortBy );
	        $this->dataList = $dataAccessManager->getListIterator();
	        $this->template->setXML( 'dataList', $this->dataList->getXML() );
        }
//         else
//         {
// 	        $this->dataList = array();
// // 	        $this->template->setXML( 'dataList', $this->dataList->getXML() );	
//         }        
        
        
        
        
        /*
         * Add any additional data required by the template here
         */
        $person = new RowManager_PersonManager();
        $person->setLabelTemplateLastNameFirstName();
//         $field->setPersonID( $this->person_id);
        $person->setSortOrder( 'person_lname, person_fname' );
        $personList = new ListIterator($person);	
        $personArray = $personList->getDropListArray();
        
        $this->template->set( 'list_person_id', $personArray );  
        
        $notice = "<br><b>NOTE:</b> Duplicate names may appear if a person has multiple records.";
        $this->template->set( 'note_person_id', $notice);    
        
        $event = new RowManager_EventManager();
//         $field->setPersonID( $this->person_id);
        $eventList = new ListIterator($event);	
        $eventArray = $eventList->getDropListArray();

        $this->template->set( 'list_event_id', $eventArray );       
        

        $status = new RowManager_StatusManager();
        $statusList = new ListIterator($status);	
        $statusArray = $statusList->getDropListArray();

        $this->template->set( 'list_registration_status', $statusArray );                  
        
        
//         
//         $nameFields = 'person_lname,person_fname';
//         $template = '[person_lname], [person_fname]';
//         $this->dataManager->setLabelTemplate( $nameFields, $template );
 
         if ($privManager->isSuperAdmin()==true)	
         {	
	         $templateName = 'siteSearchFormDataList.php';		//'page_HrdbHome.php';
	      }
	      else
	      {
				// Changed by RM on Jan 2, 2008 - We can't have just anybody being able to access this data.
        		$templateName = 'page_HrdbHome.php';
     		}       

        
        // if you are creating a custom template for this page then 
		// replace $templateName with the following:
		//$templateName = 'page_EditPriceRules.php';
		
		return $this->template->fetch( $templateName );	    
        
    }
	
}

?>
