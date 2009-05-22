<?php
/**
 * @package cim_hrdb
 */ 
/**
 * class FormProcessor_EditStudentYearInSchool
 * <pre> 
 * An interface that allows bulk update of each student's year-in-school on a per-campus basis.
 * </pre>
 * @author CIM Team
 * Date:   11 Jan 2008
 */
 // RAD Tools: FormGrid page
class  FormProcessor_EditStudentYearInSchool extends PageDisplay_FormProcessor {

	//CONSTANTS:
	
	const DISPLAY_ALL_ID = -1;
	
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
    const FORM_FIELDS = 'person_id|N|,person_fname|T|,person_lname|T|,year_id|N|,grad_date|T|';
    
    /** The list of field types to be displayed in the form */
    // NOTE: if a field isn't displayed, put a '-' for it's entry.
    const FORM_FIELD_TYPES = 'hidden,textbox_ro,textbox_ro,droplist,textbox';
    
    /** The Multilingual Page Key for this page */
    const MULTILINGUAL_PAGE_KEY = 'FormProcessor_EditStudentYearInSchool';

	//VARIABLES:

	/** @var [STRING] The path to the module's root directory. */
	protected $pathModuleRoot;
	
	/** @var [STRING] The form Action for submitting this form. */
	protected $formAction;
	
	/** @var [OBJECT] The Viewer Object. */
	protected $viewer;
		
    /** @var [STRING] The initialization data for the rowManager. */
   protected $person_id;
 	protected $person_year_id;
 	protected $campus_id;
	
	/** @var [OBJECT] The object that holds the Row Info. */
	protected $rowManager;

	protected $primaryIDs;

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
	 * @param $ [INTEGER] Value used to initialize the rowManager
	 * @return [void]
	 */
    function __construct($pathModuleRoot, $viewer, $formAction, $person_id, $campus_id, $person_year_id = '') 
    {
        // NOTE: be sure to call the parent constructor before trying to 
        //       use the ->formXXX arrays...
        parent::__construct( $formAction, FormProcessor_EditStudentYearInSchool::FORM_FIELDS, FormProcessor_EditStudentYearInSchool::FORM_FIELD_TYPES );
        
        $this->pathModuleRoot = $pathModuleRoot;
        $this->viewer = $viewer;
        $this->formAction = $formAction;
        $this->campus_id = $campus_id;
        $this->person_id = $person_id;
        $this->person_year_id = $person_year_id;
        
//        if ($person_year_id == '')
//        {
// 	       if (isset($person_id))
// 	       {
// 		       if (isset($campus_id))
// 		       {
// 		       }
// 	       }
//        }
        
			/**** Check privileges and initialize campus drop-down list ***/
        // Now load the access Priviledge manager of this viewer
        $this->adminManager = new RowManager_AdminManager( );

        // Get the person ID
        $accessManager = new RowManager_AccessManager( );
        $accessManager->loadByViewerID( $this->viewer->getViewerID( ) );
        $personID = $accessManager->getPersonID();

        // Get the permissions the person has.
        $this->adminManager->loadByPersonID( $personID );
        
        if ( $this->adminManager->hasSitePriv()  )
        {
            $campusManager = new RowManager_CampusManager( );
            $campusManager->setSortOrder('campus_desc');
            $this->campusList = $campusManager->getListIterator( );
            $this->accessibleCampuses = $this->campusList->getDropListArray();
        }        
        else if ( $this->adminManager->hasCampusPriv()  )
        {
            $campusAdminManager = new RowManager_CampusAdminManager();
            $adminID = $this->adminManager->getID();
            // echo 'adminID['.$adminID.']<br/>';
            $campusAdminManager->setAdminID( $adminID );
            
            $multiTableManager = new MultiTableManager();
            $multiTableManager->addRowManager($campusAdminManager);
            $multiTableManager->setSortOrder('campus_desc');
            
            $campusManager = new RowManager_CampusManager();
            $multiTableManager->addRowManager( $campusManager, new JoinPair( $campusManager->getJoinOnCampusID(), $campusAdminManager->getJoinOnCampusID() ) );
            
            $this->campusList = $multiTableManager->getListIterator();
            
            $this->accessibleCampuses = array();
            $this->campusList->setFirst();
            while( $this->campusList->moveNext() )
            {
                $campusAdminObject = $this->campusList->getCurrent(new RowManager_CampusAdminManager());
                $campusObject = $this->campusList->getCurrent(new RowManager_CampusManager());
                $this->accessibleCampuses[$campusAdminObject->getCampusID()] = $campusObject->getLabel();
            }
        }
        else if ( $this->adminManager->isStaff($viewer->getID()) )
        {  
            $staffManager = new RowManager_StaffManager();
            $staffManager->setPersonID( $personID );
            
            $multiTableManager = new MultiTableManager();
            $multiTableManager->addRowManager($staffManager);
            $multiTableManager->setSortOrder('campus_desc');
            
            $assignmentManager = new RowManager_AssignmentsManager();
            $multiTableManager->addRowManager( $assignmentManager, new JoinPair( $assignmentManager->getJoinOnPersonID(), $staffManager->getJoinOnPersonID() ) );
            
            $campusManager = new RowManager_CampusManager();
            $multiTableManager->addRowManager( $campusManager, new JoinPair( $campusManager->getJoinOnCampusID(), $assignmentManager->getJoinOnCampusID() ) );
            
            $this->campusList = $multiTableManager->getListIterator();
            
            $this->accessibleCampuses = array();
            $this->campusList->setFirst();
            while( $this->campusList->moveNext() )
            {
                $campusAssignObject = $this->campusList->getCurrent(new RowManager_AssignmentsManager());
                $campusObject = $this->campusList->getCurrent(new RowManager_CampusManager());
                $this->accessibleCampuses[$campusAssignObject->getCampusID()] = $campusObject->getLabel();
            }
  		  }        
        else
        {	
            $campusManager = new RowManager_CampusManager( );
            $campusManager->setSortOrder('campus_desc');
            $this->campusList = $campusManager->getListIterator( );
            $this->accessibleCampuses = $this->campusList->getDropListArray();
        }
        
        // modify the campus_id if necessary
        if ( $this->campus_id == FormProcessor_EditStudentYearInSchool::DISPLAY_ALL_ID  )
        {
            // setting the campus id to blank will get entries from all the campuses
            $this->campus_id = '';
        }
        else if ( $this->campus_id == '' )
        {
            // no campus has been specified
            // choose a default campus if none specified
            // echo 'No campus specified<br/>';
            
            // get the first element from the accessible list
            foreach( $this->accessibleCampuses as $key=>$value )
            {
                $this->campus_id = $key;
                break;
            }
            
            // assert campus_id should now be something
            if ( $this->campus_id == '' )
            {
                die( "ERROR - campusID not set to anything<br/>" );
            }
            
        }
        /*** end privilege checking and campus droplist setup ***/	
        
	        		        
//         echo 'campus = '.$this->campus_id;  
      
	      // create new rowManager (a List Iterator obj.)
	      $statuses = '0,1,6';	// filter by assignment status in ('undefined', 'current student', 'unknown')
	      $this->rowManager = new PersonYearList( $this->campus_id, $statuses, 'year_id,person_lname');		      
        
        // figure out the important fields for the rowItems
        $fieldsOfInterest = implode(',', $this->formFields);
        
        $this->primaryIDs = array();
        
        // for each row item ...
        $this->rowManager->setFirst( );
        $i = 0;
        $valid_values = explode(',',RowManager_PersonYearManager::FIELD_LIST);
        while( $rowItem = $this->rowManager->getNext() ) {
        
            // make sure rowItems have valid entries in the DB
            if (!$rowItem->isLoaded()) {
                $rowItem->createNewEntry();
            }
        
            // set the fields of interest ...
            $rowItem->setFieldsOfInterest( $fieldsOfInterest );
            
            // get the primaryID of this rowItem
            $primaryID = $rowItem->getPrimaryKeyValue();
            $this->primaryIDs[$i] = $primaryID;
            $person_id = -1;
            
            // now initialize beginning form values from rowItem object
            for( $indx=0; $indx<count($this->formFields); $indx++) {
                
                $key = $this->formFields[$indx];
                
                if (in_array($key, $valid_values))
                {
                	$this->formValues[ $key.$primaryID ] = $rowItem->getValueByFieldName( $key );
                	if ($key == 'person_id')
                	{
	                	$person_id = $this->formValues[ $key.$primaryID ];
                	}
             	 }
             	 else 
             	 {	             	 
	             	 if ($person_id != '-1')
	             	 {
	             	 	$person_manager = new RowManager_PersonManager($person_id);
	             	 	$this->formValues[ $key.$primaryID ] = $person_manager->getValueByFieldName( $key );
             	 	 }
             	 	 else
             	 	 {
	             	 	 $this->formValues[ $key.$primaryID ] = "";
             	 	 }               	
             	 }
            } // next field
            $i++;
                
        } // next rowItem in rowManager 
        

//         echo 'array = <pre>'.print_r($this->formValues,true).'</pre>'; 
        
        // now initialize the labels for this page
        // start by loading the default field labels for this Module
        $languageID = $viewer->getLanguageID();
        $seriesKey = modulecim_hrdb::MULTILINGUAL_SERIES_KEY;
        $pageKey = modulecim_hrdb::MULTILINGUAL_PAGE_FIELDS;
        $this->labels = new MultilingualManager( $languageID, $seriesKey, $pageKey );
        
        // then load the page specific labels for this page
        $pageKey = FormProcessor_EditStudentYearInSchool::MULTILINGUAL_PAGE_KEY;
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
        // for each rowItem in family ...
        $this->rowManager->setFirst( );
        while( $rowItem = $this->rowManager->getNext() ) {
            
            parent::loadFromForm( $rowItem->getPrimaryKeyValue() );
   
        } // next rowItem
        
    } // end loadFromForm()
    
    
    
    //************************************************************************
	/**
	 * function isDataValid
	 * <pre>
	 * Verifies that the returned data is valid.
	 * </pre>
	 * @return [BOOL]
	 */
    function isDataValid() 
    {
        
        $isValid = true;
        
        // for each rowItem in rowManager ...
        $this->rowManager->setFirst( );
        while( $rowItem = $this->rowManager->getNext() ) {
            
            $isValid = (( parent::isDataValid( $rowItem->getPrimaryKeyValue() ) && ( $isValid == true )));  
            
        } // next rowItem
        
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
        // for each rowItem in rowManager ...
        $this->rowManager->setFirst( );
        while( $rowItem = $this->rowManager->getNext() ) {
            
            $formValues = array();
            $primaryID = $rowItem->getPrimaryKeyValue();
            
            // for each formField
             for( $indx=0; $indx<count($this->formFields); $indx++) {
    
                $keyDest = $this->formFields[$indx];
                $keySource = $keyDest.$primaryID;
                
                // compile formValues for current rowItem into array
                $formValues[ $keyDest ] = $this->formValues[ $keySource ];
            
            }  // next formField
            
            // update rowItem with new formValues
            $rowItem->loadFromArray( $formValues );
            $rowItem->updateDBTable();
                
        } // next rowItem
        
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
        $path = $this->pathModuleRoot.'templates/';
        // Otherwise use the standard Templates for the site:
//         $path = SITE_PATH_TEMPLATES;
        $this->template = new Template( $path );
        
                // store the link labels
        $this->linkLabels[ 'DownloadSeniorityCSV' ] = $this->labels->getLabel( '[DownloadSeniorityCSV]' );
        
        // store the formAction value to the template
        $this->template->set( 'formAction', $this->formAction );
        
        // store the page labels in XML format...
        // NOTE: use this location to update any label tags ...
        // $name = $user->getName();
        // $this->labels->setLabelTag( '[Title]', '[userName]', $name);
        $this->template->setXML( 'pageLabels', $this->labels->getLabelXML() );
        
        // store the rowManager to the template
        $this->template->setXML( 'rowList', $this->rowManager->getXML() );
        
        // store the label Field Name
        $this->template->set( 'labelFieldName', '' );
        
        // store all the fields to the template
        $this->setFormFieldsToTemplate();
        
        
        /*
         * Add any additional data required by the template here
         */
        // save the list of form fields
        $this->template->set( 'formFieldList', $this->formFields);
        
        // store the field types being displayed
        $fieldTypes = explode(',', FormProcessor_EditStudentYearInSchool::FORM_FIELD_TYPES);
        $this->template->set( 'formFieldType', $fieldTypes);
        
        
        // Insert the date start/end values for the following date fields:
        // example:
            //$this->template->set( 'startYear_[fieldName]', 2000);
            //$this->template->set( 'endYear_[fieldName]', 2010);
            
        /** Create and store download CSV link **/           
        $downloadLink = array();
		  $downloadLink[ 'DownloadSeniorityCSV' ]  = $this->linkValues[ 'DownloadSeniorityCSV' ];
		          
		  $this->template->set('linkLabels', $this->linkLabels);
        $this->template->set('downloadLink', $downloadLink );
                           
            
        // now add the data for the Campus Group JumpList
        $jumpLink = $this->linkValues['jumpLink'];
        $jumpList = array();
        if ( $this->adminManager->hasSitePriv() )
        {
            $jumpList[ $jumpLink.page_PeoplebyCampuses::DISPLAY_ALL_ID ] = 'Show All';
        }
        foreach( $this->accessibleCampuses as $key=>$value) {
            $jumpList[ $jumpLink.$key ] = $value;
        }
        $this->template->set( 'jumpList', $jumpList  );
        // echo '<pre>'.print_r($jumpList,true).'</pre>';
        // echo 'jumpLink['.$jumpLink.']<br/>';
        $this->template->set( 'defaultCampus', $jumpLink.$this->campus_id );
          
        //Person list.
//         $personManager = new RowManager_PersonManager( );
//         $personManager->setSortOrder('person_lname');
//         $personManager->setLabelTemplateLastNameFirstName();
//         $personList = $personManager->getListIterator( );
//         $personArray = $personList->getDataList();	//DropListArray( );
//         $this->template->set( 'list_person_id', $personArray );   


//         // for each row item ...
//         $this->rowManager->setFirst( );
//         while( $rowItem = $this->rowManager->getNext() ) {
//         
//             // make sure rowItems have valid entries in the DB
//             if (!$rowItem->isLoaded()) {
//                 $rowItem->createNewEntry();
//             }
//         
//             // set the fields of interest ...
//             $rowItem->setFieldsOfInterest( $fieldsOfInterest );
//             
//             // get the primaryID of this rowItem
//             $primaryID = $rowItem->getPrimaryKeyValue();
//             
//             // now initialize beginning form values from rowItem object
//             for( $indx=0; $indx<count($this->formFields); $indx++) {
//                 
//                 $key = $this->formFields[$indx];
//                 
//                 $this->formValues[ $key.$primaryID ] = $rowItem->getValueByFieldName( $key );
//             } // next field
//                 
//         } // next rowItem in rowManager 
        
        
        //Year list.
        $yearManager = new RowManager_YearInSchoolManager( );
        $yearManager->setSortOrder('year_id');
        $yearList = $yearManager->getListIterator( );
        $yearArray = $yearList->getDropListArray( );
        $this->template->set( 'list_year_id', $yearArray );    
        
        reset($this->primaryIDs);
        foreach( array_keys($this->primaryIDs) as $k)
        {
	        $record = current($this->primaryIDs);
	        $this->template->set( 'list_year_id'.$record, $yearArray );     
	        next($this->primaryIDs);
        }      
        
        //Person list.        
//         $this->template->set( 'list_person_id', $personArray );
//         
//         reset($this->primaryIDs);
//         foreach( array_keys($this->primaryIDs) as $k)
//         {
// 	        $personManager = new RowManager_PersonManager( $person_id );
// 	        $personManager->setLabelTemplateLastNameFirstName();
// 	        $personList = $personManager->getListIterator( );
// 	        $personArray = $personList->getDropListArray( );	        
// 	        
// 	        $record = current($this->primaryIDs);
// 	        echo 'array = <pre>'.print_r($record,true).'</pre>';
// 	        $this->template->set( 'person_id'.$record, $person_name );     
// 	        next($this->primaryIDs);
//         }           
        
        /*
         * List related Template variables :
         */
        // Store the XML Node name for the Data Access Field List
        $xmlNodeName = RowManager_PersonYearManager::XML_NODE_NAME;
        $this->template->set( 'rowManagerXMLNodeName', $xmlNodeName);
        
        // store the primary key field name for the data being displayed
        $this->template->set( 'primaryKeyFieldName', 'personyear_id');
        
        
		// uncomment this line if you are creating a template for this page
		$templateName = 'page_EditStudentYearInSchool.tpl.php';
// 		$templateName = 'siteFormGrid.php';  // generic form grid template
		
		return $this->template->fetch( $templateName );
        
    }
    
    
    
    //************************************************************************
	/**
	 * function setFormFieldsToTemplate
	 * <pre>
	 * Stores the fields into the Template object. This one is updated to 
	 * add fields by each rowItem's primary ID...
	 * </pre>
	 * @return [void]
	 */
    function setFormFieldsToTemplate() 
    {
        
        // for each rowItem in family ...
        $this->rowManager->setFirst( );
        while( $rowItem = $this->rowManager->getNext() ) {
        
            parent::setFormFieldsToTemplate( $rowItem->getPrimaryKeyValue() );
            
        } // next rowItem

    } // end setFormFieldsToTemplate() 
    
    
    /** Simple function for retrieving the set campus_id **/
    public function getCampusID() {
	    
	    return $this->campus_id;
    }
	
}

?>