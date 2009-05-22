<?php
/**
 * @package [ModuleName]
 */ 
/**
 * class [PageNamePrefix][PageName] 
 * <pre> 
 * [PageDescription]
 * </pre>
 * @author [CreatorName]
 * Date:   [CreationDate]
 */
 // RAD Tools: AdminBox Page
class  [PageNamePrefix][PageName] extends PageDisplay_FormProcessor_AdminBox {

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
    const FORM_FIELDS = '[RAD_FIELDTYPE_LIST]';
    
    /** The list of field types to be displayed in the form */
    // NOTE: if a field isn't displayed, put a '-' for it's entry.
	 //		 after the 'textbox' type name add a '|' followed by a number to change the textbox length
    const FORM_FIELD_TYPES = '[RAD_FORMENTRYTYPE_LIST]';
    
    /** The list of fields to be displayed in the data list */
    const DISPLAY_FIELDS = '[RAD_FIELDNAME_LIST]';
    
    /** The Querystring Field for which entry is currently being edited ... */
    const MULTILINGUAL_PAGE_KEY = '[PageNamePrefix][PageName]';

	//VARIABLES:
	
	/** @var [STRING] The path to the module's root directory. */
	protected $pathModuleRoot;
	
	/** @var [STRING] The initilization variable for the dataManager. */
	protected $[RAD_FORM_INIT];
	
/*[RAD_LIST_INIT]*/
	
/*[RAD_FOREIGN_KEY_VAR]*/



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
	 * @param $[RAD_FORM_INIT] [STRING] The init data for the dataManager obj
[RAD_LIST_INIT_DOC][RAD_FOREIGN_KEY_DOC]	 * @return [void]
	 */
    function __construct($pathModuleRoot, $viewer, $formAction, $sortBy, $[RAD_FORM_INIT][RAD_LIST_INIT_PARAM] )//[RAD_FOREIGN_KEY_PARAM]
    {
        // NOTE: be sure to call the parent constructor before trying to 
        //       use the ->formXXX arrays...
        $fieldList = [PageNamePrefix][PageName]::FORM_FIELDS;
        $fieldTypes = [PageNamePrefix][PageName]::FORM_FIELD_TYPES;
        $displayFields = [PageNamePrefix][PageName]::DISPLAY_FIELDS;
        parent::__construct($viewer, $formAction, $sortBy, $fieldList, $fieldTypes, $displayFields );


        $this->pathModuleRoot = $pathModuleRoot;
        
        $this->[RAD_FORM_INIT] = $[RAD_FORM_INIT];
/*[RAD_LIST_INIT_VAR_INIT]*/
/*[RAD_FOREIGN_KEY_SAVE]*/

        
        // figure out the important fields for the dataManager
        $fieldsOfInterest = implode(',', $this->formFields);
        
        $this->dataManager = new RowManager_[RAD_DAOBJ_MANAGER_NAME]( $[RAD_FORM_INIT] );
        $this->dataManager->setFieldsOfInterest( $fieldsOfInterest );
        $this->formValues = $this->dataManager->getArrayOfValues();
    

        // now initialize the labels for this page
        // start by loading the default field labels for this Module
        $languageID = $viewer->getLanguageID();
        $seriesKey = module[ModuleName]::MULTILINGUAL_SERIES_KEY;
        $pageKey = module[ModuleName]::MULTILINGUAL_PAGE_FIELDS;
        $this->labels = new MultilingualManager( $languageID, $seriesKey, $pageKey );
        
        // then load the page specific labels for this page
        $pageKey = [PageNamePrefix][PageName]::MULTILINGUAL_PAGE_KEY;
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

        
        // on a successful update return [RAD_FORM_INIT] to ''
        $this->[RAD_FORM_INIT]='';
        
        
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
        $this->template->set( 'editEntryID', $this->[RAD_FORM_INIT] );
        
        


        
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
/*[RAD_DAOBJ_FIELD_DATE_PARAM]*/


        /*
         * List related Template variables :
         */
        // Store the XML Node name for the Data Access Field List
        $xmlNodeName = RowManager_[RAD_LIST_MANAGER_NAME]::XML_NODE_NAME;
        $this->template->set( 'rowManagerXMLNodeName', $xmlNodeName);
        
        // store the primary key field name for the data being displayed
        $this->template->set( 'primaryKeyFieldName', '[RAD_LIST_PRIMARYKEY]');
        
        // store data list to the template
        // NOTE: we initialize it here to make sure we capture any new data 
        // from a recent processData() call.
        $dataAccessManager = new RowManager_[RAD_DAOBJ_MANAGER_NAME]();
        $dataAccessManager->setSortOrder( $this->sortBy );
//        $this->dataList = new [RAD_DAOBJ_LIST_NAME]( [RAD_LIST_INIT_DAOBJ_PARAM]$this->sortBy );
        $this->dataList = $dataAccessManager->getListIterator();
        $this->template->setXML( 'dataList', $this->dataList->getXML() );
        
        
        
        
        /*
         * Add any additional data required by the template here
         */
         
        
        $templateName = '[RAD_TEMPLATE_DEFAULT]';
        // if you are creating a custom template for this page then 
		// replace $templateName with the following:
		//$templateName = 'page_[PageName].php';
		
		return $this->template->fetch( $templateName );
        
    }
    
    	
}

?>