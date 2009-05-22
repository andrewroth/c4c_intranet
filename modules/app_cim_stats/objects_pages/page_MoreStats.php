<?php
/**
 * @package cim_stats
 */ 
/**
 * class FormProcessor_MoreStats 
 * <pre> 
 * Page for entering additional weekly stats.  Note, this page is for campus teams as a whole.
 * </pre>
 * @author Russ Martin
 * Date:   28 Jun 2006
 */
 // RAD Tools: AdminBox Page
class  FormProcessor_MoreStats extends PageDisplay_FormProcessor_AdminBox {

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
    const FORM_FIELDS = 'week_id|N|<skip>,campus_id|N|<skip>,morestats_exp|N|,morestats_notes|T|<skip>,exposuretype_id|N|';
    
    /** The list of field types to be displayed in the form */
    // NOTE: if a field isn't displayed, put a '-' for it's entry.
    const FORM_FIELD_TYPES = 'jumplist,jumplist,textbox,textarea,droplist';
    
    /** The list of fields to be displayed in the data list */
    const DISPLAY_FIELDS = 'morestats_exp,morestats_notes,exposuretype_id';
    
    /** The Querystring Field for which entry is currently being edited ... */
    const MULTILINGUAL_PAGE_KEY = 'FormProcessor_MoreStats';

	//VARIABLES:
	
	/** @var [STRING] The path to the module's root directory. */
	protected $pathModuleRoot;
	
	/** @var [STRING] The initilization variable for the dataManager. */
	protected $morestats_id;
	
/* no List Init Variable defined for this DAObj */
	
	/** @var [INTEGER] Foreign Key needed by Data Manager */
	protected $campus_id;

	/** @var [INTEGER] Foreign Key needed by Data Manager */
	protected $exposuretype_id;

    /** @var [INTEGER] Foreign Key needed by Data Manager */
    protected $week_id;
    
    /** @var [INTEGER] Foreign Key needed by Data Manager */
    protected $staff_id;
    
    /** @var [OBJECT] An interator of a MultiTableManager. */	
	protected $campusListIterator;


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
	 * @param $morestats_id [STRING] The init data for the dataManager obj
	 * @param $campus_id [INTEGER] The foreign key data for the data Manager
	 * @param $exposuretype_id [INTEGER] The foreign key data for the data Manager
	 * @return [void]
	 */
    function __construct($pathModuleRoot, $viewer, $formAction, $sortBy, $morestats_id , $campus_id='', $exposuretype_id='', $week_id, $staff_id )
    {
        // NOTE: be sure to call the parent constructor before trying to 
        //       use the ->formXXX arrays...
        $fieldList = FormProcessor_MoreStats::FORM_FIELDS;
        $fieldTypes = FormProcessor_MoreStats::FORM_FIELD_TYPES;
        $displayFields = FormProcessor_MoreStats::DISPLAY_FIELDS;
        parent::__construct($viewer, $formAction, $sortBy, $fieldList, $fieldTypes, $displayFields );


        $this->pathModuleRoot = $pathModuleRoot;
        
        $this->morestats_id = $morestats_id;

        $this->campus_id = $campus_id;
        $this->exposuretype_id = $exposuretype_id;
        // echo '$this->exposuretype_id['.$this->exposuretype_id.']<br/>';
        $this->week_id = $week_id;
        $this->staff_id = $staff_id;
        
        
        
        // for looking up the person_id of this staff member
        $staffManager = new RowManager_StaffManager( $this->staff_id );
        
        // setup the 
        $assignmentManager = new RowManager_AssignmentsManager();
        $assignmentManager->setPersonID( $staffManager->getPersonID() );
        $assignmentManager->setAssignmentStatusID( CA_STAFF );
            
        $multiTableManager = new MultiTableManager();
        $multiTableManager->addRowManager($assignmentManager);
            
        $campusManager = new RowManager_CampusManager();
        $campusManager->setSortOrder('campus_desc');
        $multiTableManager->addRowManager( $campusManager, new JoinPair( $campusManager->getJoinOnCampusID(), $assignmentManager->getJoinOnCampusID() ) );
           
        $this->campusListIterator = $multiTableManager->getListIterator();
        
        if ( $campus_id != '' )
        {
            // echo 'campus_id is SET ['.$campus_id.']<br/>';
            $this->campus_id = $campus_id;
        }
        else
        {
            // set a default campus id
            // echo 'Choosing a default campus<br/>';
            $this->campusListIterator->setFirst();
            if ( $this->campusListIterator->moveNext() )
            {
                $campusObject = $this->campusListIterator->getCurrent(new RowManager_CampusManager());
                $this->campus_id = $campusObject->getID();
            }
            else
            {
                die('ERROR - unable to set campus_id - page_StaffWeeklyReport');
            }
        }
        
        if ( $this->week_id == '' )
        {
            // give a default value to the week id            
            $weekManager = new RowManager_WeekManager();
            if ( $weekManager->loadByDate( date( 'Y-m-d', time() ) ) )
            {
                $this->week_id = $weekManager->getID();
            }
            else
            {
                die("ERROR - couldn't see week_id - page_MoreStats.php");
            }
        }
        // echo '$this->week_id['.$this->week_id.']<br/>';


        
        // figure out the important fields for the dataManager
        $fieldsOfInterest = implode(',', $this->formFields);
        
        $this->dataManager = new RowManager_MoreStatsManager( $morestats_id );
        $this->dataManager->setFieldsOfInterest( $fieldsOfInterest );
        $this->formValues = $this->dataManager->getArrayOfValues();
    

        // now initialize the labels for this page
        // start by loading the default field labels for this Module
        $languageID = $viewer->getLanguageID();
        $seriesKey = modulecim_stats::MULTILINGUAL_SERIES_KEY;
        $pageKey = modulecim_stats::MULTILINGUAL_PAGE_FIELDS;
        $this->labels = new MultilingualManager( $languageID, $seriesKey, $pageKey );
        
        // then load the page specific labels for this page
        $pageKey = FormProcessor_MoreStats::MULTILINGUAL_PAGE_KEY;
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
            $this->formValues[ 'week_id' ] = $this->week_id;
            $this->formValues[ 'campus_id' ] = $this->campus_id;
            // $this->formValues[ 'exposuretype_id' ] = $this->exposuretype_id;
            // echo '$this->exposuretype_id['.$this->exposuretype_id.']<br/>';
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

        
        // on a successful update return morestats_id to ''
        $this->morestats_id='';
        
        
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

        // temporarily reset the form values so the defaults show up properly in the jumplists
        $this->formValues[ 'week_id' ] = $this->linkValues['weekJumpLink'].$this->week_id;
        $this->formValues[ 'campus_id' ] = $this->linkValues['campusJumpLink'].$this->campus_id;

        // NOTE:  this parent method prepares the $this->template with the 
        // common AdminBox data.  
        $this->prepareTemplate( $path );
        
        
        // store the statevar id to edit
        $this->template->set( 'editEntryID', $this->morestats_id );
        
        


        
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
        $xmlNodeName = RowManager_MoreStatsManager::XML_NODE_NAME;
        $this->template->set( 'rowManagerXMLNodeName', $xmlNodeName);
        
        // store the primary key field name for the data being displayed
        $this->template->set( 'primaryKeyFieldName', 'morestats_id');
        
        // store data list to the template
        // NOTE: we initialize it here to make sure we capture any new data 
        // from a recent processData() call.
        $dataAccessManager = new RowManager_MoreStatsManager();
        // echo 'This campus ID['.$this->campus_id.']<br/>';
        $dataAccessManager->setCampusID( $this->campus_id );
        $dataAccessManager->setWeekID( $this->week_id );
        $dataAccessManager->setSortOrder( $this->sortBy );
//        $this->dataList = new MoreStatsList( $this->sortBy );
        $this->dataList = $dataAccessManager->getListIterator();
        $this->template->setXML( 'dataList', $this->dataList->getXML() );
        
        
        
        
        /*
         * Add any additional data required by the template here
         */
         
        // week list
        $jumpLink = $this->linkValues['weekJumpLink'];
        
        $weekManager = new RowManager_WeekManager();
        $weekManager->setSortOrder('week_endDate');
        $weekList = new ListIterator( $weekManager );
        $jumpList = $weekList->getDropListArray(null, $jumpLink);
        $this->template->set( 'list_week_id', $jumpList );
        
        // for looking up the person_id of this staff member
        $staffManager = new RowManager_StaffManager( $this->staff_id );
        
        // campus list
        $assignmentManager = new RowManager_AssignmentsManager();
        $assignmentManager->setPersonID( $staffManager->getPersonID() );
        $assignmentManager->setAssignmentStatusID( CA_STAFF );
            
        $multiTableManager = new MultiTableManager();
        $multiTableManager->addRowManager($assignmentManager);
            
        $campusManager = new RowManager_CampusManager();
        $campusManager->setSortOrder('campus_desc');
        $multiTableManager->addRowManager( $campusManager, new JoinPair( $campusManager->getJoinOnCampusID(), $assignmentManager->getJoinOnCampusID() ) );
           
        $jumpLink = $this->linkValues['campusJumpLink']; 
        $campusList = $multiTableManager->getListIterator();
        $campusArray = array();
        $campusList->setFirst();
        while( $campusList->moveNext() )
        {
            $campusObject = $campusList->getCurrent(new RowManager_CampusManager());
            $campusArray[$jumpLink.$campusObject->getID()] = $campusObject->getLabel();
        }
        // echo '<pre>'.print_r($campusArray, true ).'</pre>';
        $this->template->set( 'list_campus_id', $campusArray );
         
        // method list
        $typeManager = new RowManager_ExposureTypeManager( );
        $typeManager->setSortOrder('exposuretype_desc');
        $typeList = $typeManager->getListIterator( );
        $typeArray = $typeList->getDropListArray( );
        $this->template->set( 'list_exposuretype_id', $typeArray );
        
        $templateName = 'siteFormDataList.php';
        // if you are creating a custom template for this page then 
		// replace $templateName with the following:
		//$templateName = 'page_MoreStats.php';
		
		return $this->template->fetch( $templateName );
        
    }
    
    	
}

?>