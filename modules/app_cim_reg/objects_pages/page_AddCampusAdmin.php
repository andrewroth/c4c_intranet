<?php
/**
 * @package cim_reg
 */ 
/**
 * class FormProcessor_AddCampusAdmin 
 * <pre> 
 * Page used to assign campuses to event administrators.
 * </pre>
 * @author Russ Martin
 * Date:   03 Jul 2007
 */
 // RAD Tools: AdminBox Page
class  FormProcessor_AddCampusAdmin extends PageDisplay_FormProcessor_AdminBox {

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
    const FORM_FIELDS = 'eventadmin_id|N|,campus_id|N|';
    
    /** The list of field types to be displayed in the form */
    // NOTE: if a field isn't displayed, put a '-' for it's entry.
    const FORM_FIELD_TYPES = 'droplist,droplist';
    
    /** The list of fields to be displayed in the data list */
    const DISPLAY_FIELDS = 'eventadmin_id,campus_id';
    
    /** The Querystring Field for which entry is currently being edited ... */
    const MULTILINGUAL_PAGE_KEY = 'FormProcessor_AddCampusAdmin';

	//VARIABLES:
	
	/** @var [STRING] The path to the module's root directory. */
	protected $pathModuleRoot;
	
	/** @var [STRING] The initilization variable for the dataManager. */
	protected $campusaccess_id;
	
/* no List Init Variable defined for this DAObj */
	
	/** @var [INTEGER] Foreign Key needed by Data Manager */
	protected $eventadmin_id;

	/** @var [INTEGER] Foreign Key needed by Data Manager */
	protected $campus_id;

	protected $event_id;	// used to filter admins by event


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
	 * @param $campusaccess_id [STRING] The init data for the dataManager obj
	 * @param $eventadmin_id [INTEGER] The foreign key data for the data Manager
	 * @param $campus_id [INTEGER] The foreign key data for the data Manager
	 * @return [void]
	 */
    function __construct($pathModuleRoot, $viewer, $formAction, $sortBy, $campusaccess_id , $eventadmin_id='', $event_id='')	//$campus_id='', 
    {
        // NOTE: be sure to call the parent constructor before trying to 
        //       use the ->formXXX arrays...
        $fieldList = FormProcessor_AddCampusAdmin::FORM_FIELDS;
        $fieldTypes = FormProcessor_AddCampusAdmin::FORM_FIELD_TYPES;
        $displayFields = FormProcessor_AddCampusAdmin::DISPLAY_FIELDS;
        parent::__construct($viewer, $formAction, $sortBy, $fieldList, $fieldTypes, $displayFields );


        $this->pathModuleRoot = $pathModuleRoot;
        
        $this->campusaccess_id = $campusaccess_id;

        $this->eventadmin_id = $eventadmin_id;
        //$this->campus_id = $campus_id;
		$this->event_id = $event_id;

        
        // figure out the important fields for the dataManager
        $fieldsOfInterest = implode(',', $this->formFields);
        
        
        //*** ADDED JOIN IN ORDER TO FILTER BY EVENT ***/
 /**       $dataAccessManager = new RowManager_EventAdminCampusAssignmentManager($campusaccess_id);
 //       $dataAccessManager->setSortOrder( $this->sortBy );
//        $dataAccessManager->setEventID( $this->event_id);
        
       
        $eventAdminManager = new RowManager_EventAdminAssignmentManager();
        $eventAdminManager->setEventID($this->event_id);
        
        $multiTableManager = new MultiTableManager();
        $multiTableManager->addRowManager($eventAdminManager);
            
        $multiTableManager->addRowManager( $dataAccessManager, new JoinPair( $eventAdminManager->getJoinOnEventAdminID(), $dataAccessManager->getJoinOnEventAdminID() ) );
 //       $multiTableManager->constructSearchCondition( 'event_id', '=', $this->event_id, true );
        /*** END JOIN ***/
        
        $this->dataManager = new RowManager_EventAdminCampusAssignmentManager( $campusaccess_id );	//$multiTableManager;//
        $this->dataManager->setFieldsOfInterest( $fieldsOfInterest );
        $this->formValues = $this->dataManager->getArrayOfValues();
    

        // now initialize the labels for this page
        // start by loading the default field labels for this Module
        $languageID = $viewer->getLanguageID();
        $seriesKey = modulecim_reg::MULTILINGUAL_SERIES_KEY;
        $pageKey = modulecim_reg::MULTILINGUAL_PAGE_FIELDS;
        $this->labels = new MultilingualManager( $languageID, $seriesKey, $pageKey );
        
        // then load the page specific labels for this page
        $pageKey = FormProcessor_AddCampusAdmin::MULTILINGUAL_PAGE_KEY;
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
            // $this->formValues[ 'eventadmin_id' ] = $this->eventadmin_id;
 //           $this->formValues[ 'campus_id' ] = $this->campus_id;
            $this->formValues[ 'event_id' ] = $this->event_id;
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

        
        // on a successful update return campusaccess_id to ''
        $this->campusaccess_id='';
        
        
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
        $this->template->set( 'editEntryID', $this->campusaccess_id );
        
        


        
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
        //
        // NOTE: Hobbe, here are the original two lines that I moved to below
        //
        // $xmlNodeName = RowManager_EventAdminCampusAssignmentManager::XML_NODE_NAME;
        // $this->template->set( 'rowManagerXMLNodeName', $xmlNodeName);
        
        // store the primary key field name for the data being displayed
        $this->template->set( 'primaryKeyFieldName', 'campusaccess_id');
        
        // Russ' Debugging Methodoloy
        // 1. Try and create a multi-table manager that returns the 
        // result set I want and put it into and array.  Then figure
        // out why that is not making it through to the template.
        //
        // Result: Hobbe, indeed you were creating the multi-table 
        // manager correctly (I just renamed the one row manager),
        // otherwise your code was fine.
        // 
        // 2. Ok, try and figure out why the template doesn't like
        // XML it is getting.
        //
        // a. first I check another example (FormProcessor_AddSuperAdmin)
        // of where an adminbox type template is generated.  Yes, it 
        // appears we are sending the xml properly
        // 
        // b. i notice the call to ->set('primaryKeyFieldName', ... )
        // in the example I'm checking, that too seems to be okay
        // 
        // c. I notice the xmlNodeName parameter being set in the
        // templates, i realize that we are not setting this properly
        // and refactor the code a little to get the xmlNodeName from
        // the multitablemanager instead.
        
        // store data list to the template
        // NOTE: we initialize it here to make sure we capture any new data 
        // from a recent processData() call.
        $campusAdminManager = new RowManager_EventAdminCampusAssignmentManager();
        
        //*** ADDED JOIN TO FILTER BY EVENT ***/
         $eventAdminManager = new RowManager_EventAdminAssignmentManager();
         // echo "The eventID is [".$this->event_id."]<br/>";
         $eventAdminManager->setEventID( $this->event_id );
        
         $multiTableManager = new MultiTableManager();
         $multiTableManager->addRowManager( $campusAdminManager );
         $multiTableManager->addRowManager( $eventAdminManager, new JoinPair( $eventAdminManager->getJoinOnEventAdminID(), $campusAdminManager->getJoinOnEventAdminID() ) );
        
        // code to check the result set in the multi-table manager
        // $i = 0;
        // $listIt = $multiTableManager->getListIterator();
        // $listIt->setFirst();
        // while( $listIt->moveNext() )
        // {
        //    echo "ith [".$i."] element";
        //    $i++;
        // }
        // end multi-table manager check
        
        // $this->dataList = $multiTableManager->getListIterator();                      
        // echo "<pre>List: ".print_r($this->dataList,true)."</pre>";
        
        //*** END ADD ***/
        
        $this->dataList = $multiTableManager->getListIterator();

        // Hobbe, I added/moved these two lines and now it works!
        // It has to do with how the template understands the 
        // XML that it is passed
        $xmlNodeName = $this->dataList->getRowManagerXMLNodeName();
        $this->template->set( 'rowManagerXMLNodeName', $xmlNodeName);
        
        $this->template->setXML( 'dataList', $this->dataList->getXML() );  
        
        /*
         * Add any additional data required by the template here
         */
         
        $eventAdmin = new RowManager_EventAdminAssignmentManager();
        $eventAdmin->setEventID($this->event_id);
        $viewer = new RowManager_ViewerManager();
        
        $multiTableManager2 = new MultiTableManager();
        $multiTableManager2->addRowManager($eventAdmin);
            
        $multiTableManager2->addRowManager( $viewer, new JoinPair( $eventAdmin->getJoinOnViewerID(), $viewer->getJoinOnViewerID() ) );
  //      $multiTableManager2->constructSearchCondition( 'event_id', '=', $this->event_id, true );
        $multiTableManager2->setSortOrder( 'viewer_userID' );
        $multiTableManager2->setLabelTemplate('viewer_userID', '[viewer_userID]');
        $listIterator = $multiTableManager2->getListIterator(); 
        
         // code to check the result set in the multi-table manager
/*        echo "<pre>List: ".print_r($listIterator,true)."</pre>";
               
         $i = 0;
         $listIt = $multiTableManager2->getListIterator();
         $listIt->setFirst();
         while( $listIt->moveNext() )
         {
            echo "ith [".$i."] element";
            $i++;
         }
 */       // end multi-table manager check
        
//        echo print_r($listIterator,true);
/*
        $viewer = new RowManager_ViewerManager();
        $viewer->setSortOrder( 'viewer_userID' );
        $viewerList = new ListIterator($viewer);	
        $viewerArray = $viewerList->getDropListArray();
*/  
		      	
        $viewerArray = $listIterator->getDropListArray();	//$listIterator
        $this->template->set( 'list_eventadmin_id', $viewerArray );
//        echo print_r($viewerArray,true);
        
        
        $campus = new RowManager_CampusManager();
 //       $campus->setEventID( $this->event_id);
        $campus->setSortOrder( 'campus_id' );
        $campusList = new ListIterator($campus);	
        $campusArray = $campusList->getDropListArray();

        $this->template->set( 'list_campus_id', $campusArray ); 
              
               
        
        $templateName = 'siteAdminBox.php';
        // if you are creating a custom template for this page then 
		// replace $templateName with the following:
		//$templateName = 'page_AddCampusAdmin.php';
		
		return $this->template->fetch( $templateName );
        
    }
    
    	
}

?>