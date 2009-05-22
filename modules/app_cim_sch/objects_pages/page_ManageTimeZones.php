<?php
/**
 * @package cim_sch
 */ 
/**
 * class FormProcessor_ManageTimeZones 
 * <pre> 
 * An interface for creating a timezone.
 * </pre>
 * @author Calvin Jien & Russ Martin
 * Date:   26 Mar 2008
 */
 // RAD Tools: AdminBox Page
class  FormProcessor_ManageTimeZones extends PageDisplay_FormProcessor_AdminBox {

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
    const FORM_FIELDS = 'timezones_desc|T|,timezones_offset|N|';
    
    /** The list of field types to be displayed in the form */
    // NOTE: if a field isn't displayed, put a '-' for it's entry.
	 //		 after the 'textbox' type name add a '|' followed by a number to change the textbox length
    const FORM_FIELD_TYPES = 'textbox,textbox';
    
    /** The list of fields to be displayed in the data list */
    const DISPLAY_FIELDS = 'timezones_desc,timezones_offset';
    
    /** The Querystring Field for which entry is currently being edited ... */
    const MULTILINGUAL_PAGE_KEY = 'FormProcessor_ManageTimeZones';

	//VARIABLES:
	
	/** @var [STRING] The path to the module's root directory. */
	protected $pathModuleRoot;
	
	/** @var [STRING] The initilization variable for the dataManager. */
	protected $timezones_id;
	
/* no List Init Variable defined for this DAObj */
	




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
	 * @param $timezones_id [STRING] The init data for the dataManager obj
	 * @return [void]
	 */
    function __construct($pathModuleRoot, $viewer, $formAction, $sortBy, $timezones_id )
    {
        // NOTE: be sure to call the parent constructor before trying to 
        //       use the ->formXXX arrays...
        $fieldList = FormProcessor_ManageTimeZones::FORM_FIELDS;
        $fieldTypes = FormProcessor_ManageTimeZones::FORM_FIELD_TYPES;
        $displayFields = FormProcessor_ManageTimeZones::DISPLAY_FIELDS;
        parent::__construct($viewer, $formAction, $sortBy, $fieldList, $fieldTypes, $displayFields );


        $this->pathModuleRoot = $pathModuleRoot;
        
        $this->timezones_id = $timezones_id;



        
        // figure out the important fields for the dataManager
        $fieldsOfInterest = implode(',', $this->formFields);
        
        $this->dataManager = new RowManager_TimeZonesManager( $timezones_id );
        $this->dataManager->setFieldsOfInterest( $fieldsOfInterest );
        $this->formValues = $this->dataManager->getArrayOfValues();
    

        // now initialize the labels for this page
        // start by loading the default field labels for this Module
        $languageID = $viewer->getLanguageID();
        $seriesKey = modulecim_sch::MULTILINGUAL_SERIES_KEY;
        $pageKey = modulecim_sch::MULTILINGUAL_PAGE_FIELDS;
        $this->labels = new MultilingualManager( $languageID, $seriesKey, $pageKey );
        
        // then load the page specific labels for this page
        $pageKey = FormProcessor_ManageTimeZones::MULTILINGUAL_PAGE_KEY;
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
        
        // now Clear out dataManager & FormValues
        $this->dataManager->clearValues();
        $this->formValues = $this->dataManager->getArrayOfValues();

        
        // on a successful update return timezones_id to ''
        $this->timezones_id='';
        
        
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
        $this->template->set( 'editEntryID', $this->timezones_id );
        
        


        
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
        $xmlNodeName = RowManager_TimeZonesManager::XML_NODE_NAME;
        $this->template->set( 'rowManagerXMLNodeName', $xmlNodeName);
        
        // store the primary key field name for the data being displayed
        $this->template->set( 'primaryKeyFieldName', 'timezones_id');
        
        // store data list to the template
        // NOTE: we initialize it here to make sure we capture any new data 
        // from a recent processData() call.
        $dataAccessManager = new RowManager_TimeZonesManager();
        $dataAccessManager->setSortOrder( $this->sortBy );
//        $this->dataList = new TimeZonesList( $this->sortBy );
        $this->dataList = $dataAccessManager->getListIterator();
        $this->template->setXML( 'dataList', $this->dataList->getXML() );
        
        
        
        
        /*
         * Add any additional data required by the template here
         */
         
        
        $templateName = 'siteAdminBox.php';
        // if you are creating a custom template for this page then 
		// replace $templateName with the following:
		//$templateName = 'page_ManageTimeZones.php';
		
		return $this->template->fetch( $templateName );
        
    }
    
    	
}

?>