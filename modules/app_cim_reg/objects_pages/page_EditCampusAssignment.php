<?php
/**
 * @package cim_reg
 */ 
 
 $toolName = 'modules/app_cim_hrdb/objects_da/CampusAssignmentStatusManager.php';
$toolPath = Page::findPathExtension( $toolName );
require_once( $toolPath.$toolName);

/**
 * class FormProcessor_EditCampusAssignment 
 * <pre> 
 * Allows the user to edit the campus and campus status of a particular person.
 * </pre>
 * @author CIM Team
 * Date:   17 Jul 2007
 */
 // RAD Tools: AdminBox Page
class  FormProcessor_EditCampusAssignment extends PageDisplay_FormProcessor_AdminBox {

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
    const FORM_FIELDS = 'person_id|N|,campus_id|N|,assignmentstatus_id|N|0';
    
    /** The list of field types to be displayed in the form */
    // NOTE: if a field isn't displayed, put a '-' for it's entry.
	 //		 after the 'textbox' type name add a '|' followed by a number to change the textbox length
    const FORM_FIELD_TYPES = 'droplist,droplist,droplist';
    
    /** The list of fields to be displayed in the data list */
    const DISPLAY_FIELDS = 'person_id,campus_id,assignmentstatus_id';
    
    /** The Querystring Field for which entry is currently being edited ... */
    const MULTILINGUAL_PAGE_KEY = 'FormProcessor_EditCampusAssignment';

	//VARIABLES:
	
	/** @var [STRING] The path to the module's root directory. */
	protected $pathModuleRoot;
	
	/** @var [STRING] The initilization variable for the dataManager. */
	protected $assignment_id;
	
/* no List Init Variable defined for this DAObj */
	
	/** @var [INTEGER] Foreign Key needed by Data Manager */
	protected $person_id;

	/** @var [INTEGER] Foreign Key needed by Data Manager */
	protected $campus_id;

	/** @var [INTEGER] Foreign Key needed by Data Manager */
// 	protected $assignmentstatus_id;

		/** @var [STRING] The notice to display */
	protected $notice;
	
	/** @var [STRING] The error message to display (related to data validation) */
	protected $error_message;
	
	/** @var [ARRAY] Stores the values displayed in the page table **/
	protected $displayValues;
	
	/** @var [INTEGER] whether or not in sign-up process */
	protected $is_sign_up;
	

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
	 * @param $assignment_id [STRING] The init data for the dataManager obj
	 * @param $person_id [INTEGER] The foreign key data for the data Manager
	 * @param $campus_id [INTEGER] The foreign key data for the data Manager
	 * @param $assignmentstatus_id [INTEGER] The foreign key data for the data Manager
	 * @return [void]
	 */
    function __construct($pathModuleRoot, $viewer, $formAction, $sortBy, $assignment_id, $person_id='', $campus_id='', $isSignUp=false)//, $assignmentstatus_id='')	//, $isAddOnly = false)	// , $person_id='', $campus_id='', $assignmentstatus_id='')
    {
        // NOTE: be sure to call the parent constructor before trying to 
        //       use the ->formXXX arrays...
        $fieldList = FormProcessor_EditCampusAssignment::FORM_FIELDS;
        $fieldTypes = FormProcessor_EditCampusAssignment::FORM_FIELD_TYPES;
        $displayFields = FormProcessor_EditCampusAssignment::DISPLAY_FIELDS;
        parent::__construct($viewer, $formAction, $sortBy, $fieldList, $fieldTypes, $displayFields );

//		  $this->isAddOnly = $isAddOnly;		// whether or not to allow campus assignment updates
        $this->pathModuleRoot = $pathModuleRoot;
        
        $this->notice = "NOTE: only use edit for changing a person's status.<br>".
        "Add must be used for updating campus and person information.<br>".
        "This is done to store historical data and to avoid redundant records.";
        
        $this->assignment_id = $assignment_id;

        $this->person_id = $person_id;

//        $this->assignmentstatus_id = $assignmentstatus_id;

		  $this->is_sign_up = $isSignUp;
		  if ($this->is_sign_up == false)
		  {
        		$this->campus_id = $campus_id; 	// Sign-up process is NOT campus-specific
     	  }       
     	  
     	  
        // figure out the important fields for the dataManager
        $fieldsOfInterest = implode(',', $this->formFields);
        
        $this->dataManager = new RowManager_EditCampusAssignmentManager( $assignment_id );
//        $this->dataManager->setPersonID($this->person_id);
//        $this->dataManager->setCampusID($this->campus_id);
/*        if ($this->person_id!='') {
        		$this->dataManager->constructSearchCondition( 'person_id', '=', $this->person_id, true );
     	  }
        if ($this->campus_id!='') {
        		$this->dataManager->constructSearchCondition( 'campus_id', '=', $this->campus_id, true );
     	  }    
     	  */ 	  
        $this->dataManager->setFieldsOfInterest( $fieldsOfInterest );
        $this->formValues = $this->dataManager->getArrayOfValues();
//       echo "<pre>".print_r($this->formValues,true)."</pre>";


        // now initialize the labels for this page
        // start by loading the default field labels for this Module
        $languageID = $viewer->getLanguageID();
        $seriesKey = modulecim_reg::MULTILINGUAL_SERIES_KEY;
        $pageKey = modulecim_reg::MULTILINGUAL_PAGE_FIELDS;
        $this->labels = new MultilingualManager( $languageID, $seriesKey, $pageKey );
        
        // then load the page specific labels for this page
        $pageKey = FormProcessor_EditCampusAssignment::MULTILINGUAL_PAGE_KEY;
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
	    	$CAMPUS_FIELD = 'campus_id';
	    	$STATUS_FIELD = 'assignmentstatus_id';
	    
         $isValid = parent::isDataValid();
 
			// deal with insertion case
         if ($this->opType != 'U' && $this->opType != 'D')
         {        
	          // if the campus field has been provided 
	         if (isset( $this->formValues[ $CAMPUS_FIELD ] ) ) 
	         {
		         $campus = $this->formValues[ $CAMPUS_FIELD ];
	         
		         $campusManager = new RowManager_EditCampusAssignmentManager();
		         $campusManager->setPersonID($this->person_id);      
// 		        if ($this->campus_id != '')
// 		        {
// 		        		$campusManager->setCampusID($this->campus_id);
// 		     	  }
		        $campusList = $campusManager->getListIterator();
		        $campusArray = $campusList ->getDataList();
// 				  $campusArray = $this->dataList->getDataList();
// 				  echo '<pre>'.print_r($campusArray, true).'</pre>';
		        		        
		        reset($campusArray);
		        foreach (array_keys($campusArray) as $k)
		        {
			        $record = current($campusArray);  
			        
			        // ensure that each person has one assignment status per campus
			        if ($campus == $record[$CAMPUS_FIELD])
			        {
				        $errorLabel = 'Not a unique campus for this person.';
				        $this->formErrors[ $CAMPUS_FIELD ] = $errorLabel;
				        $isValid = false;
				        break;
			        }
			        next($campusArray);
		        }
	         } 
	         else {
	         
	             $isValid = false;
	         }
         }
         
         // deal with update case
         if ($this->opType == 'U')
         {
	         // if the campus field has been provided 
	         if (isset( $this->formValues[ $CAMPUS_FIELD ] ) ) 
	         {
		         $campus = $this->formValues[ $CAMPUS_FIELD ];
		         $status = $this->formValues[ $STATUS_FIELD ];
	         
		         $campusManager = new RowManager_EditCampusAssignmentManager();
		         $campusManager->setPersonID($this->person_id);       
// 		        if ($this->campus_id != '')
// 		        {
// 		        		$campusManager->setCampusID($this->campus_id);
// 		     	  }
		        $campusList = $campusManager->getListIterator();
		        $campusArray = $campusList ->getDataList();
		        		        
		        reset($campusArray);
		        foreach (array_keys($campusArray) as $k)
		        {
			        $record = current($campusArray);  
			        
			        // ensure that each person has one assignment status per campus
			        if (($campus == $record[$CAMPUS_FIELD]) && ($status == $record[$STATUS_FIELD]))
			        {
				        $errorLabel = 'Not a unique campus status for this person.';
				        $this->formErrors[ $STATUS_FIELD ] = $errorLabel;
				        $isValid = false;
				        break;
			        }
			        next($campusArray);
		        }
	         } 
	         else {
	         
	             $isValid = false;
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
	    
//	    echo "opType = ".$this->opType;
    
        // if this is a delete operation then
        if ( $this->opType == 'D' ) {
	        
//	        echo "D opType = ".$this->opType;
        
            if ( $this->shouldDelete ) {
            
                $this->dataManager->deleteEntry();
            }
            
        } else {
        // else 
        
            // save the value of the Foriegn Key(s)
//            $this->formValues[ 'person_id' ] = $this->person_id;
//            $this->formValues[ 'campus_id' ] = $this->campus_id;
//            $this->formValues[ 'assignmentstatus_id' ] = $this->assignmentstatus_id;

//			echo "person_id = ".$this->formValues[ 'person_id' ] ;
//			echo "campus_id = ".$this->formValues[ 'campus_id' ] ;
//			echo "assignmentstatus_id = ".$this->formValues[ 'assignmentstatus_id' ] ;
        /*[RAD_ADMINBOX_FOREIGNKEY]*/
            
            // Store values in dataManager object
            $this->dataManager->loadFromArray( $this->formValues );
            
            // Save the values into the Table.
            if (!$this->dataManager->isLoaded()) {
	            
//	            echo "A opType = ".$this->opType;
	            
/*	           $assignmentsChecker = new RowManager_EditCampusAssignmentManager( );

	            // check to ensure that duplicate/conflicting data is not stored
	            // i.e. ensure that each student-campus combo only has 1 status
	             $assignmentsChecker->setPersonID($this->formValues[ 'person_id' ]);
	             $assignmentsChecker->setCampusID($this->formValues[ 'campus_id' ]);

	             $resultSet = $assignmentsChecker->find();
	             
						$found = false;
	             	$resultSet->setFirst();
		            while( $resultSet->moveNext() ) {
		                
		                // load the searchManager from the current row of data
//		                echo "pre-insert results: <pre>".print_r($resultSet->getCurrentRow(),true)."</pre><br>";
		                $found = true;		               
		            }
		            
		          // only add new entry if the person-campus combination doesn't exist yet
		          if ($found == false) 
		          {  */
                	$this->dataManager->createNewEntry();
  /*           	 }
             	 else 
             	 {
	             	 $this->error_message = 'Only *1* status allowed per campus-person combination!<br>'.
	             	 								'Insert operation aborted.';
             	 }  */
		                            
            } else //if (!$this->isAddOnly) 
            {
//	            echo "U opType = ".$this->opType;
	            
/*	             $assignmentsChecker = new RowManager_EditCampusAssignmentManager( );	             
	             $assignmentsChecker->setAssignmentID($this->assignment_id);             
	             
	             $resultSet = $assignmentsChecker->find();
	             // NOTE: should only find one record, because assignment_id was set	             
	             	
						$abort = false;
//						$add = false;
	             	$resultSet->setFirst();
		            while( $resultSet->moveNext() ) {
		                
		                // load the searchManager from the current row of data
//		                echo "pre-insert results: <pre>".print_r($resultSet->getCurrentRow(),true)."</pre><br>";
							 $results = array();
							 $results = $resultSet->getCurrentRow();
							 
							 /** STEP 1: ensure that person name/ID is not updated since this can easily create redundancies **/
/*							 if ($this->formValues['person_id'] != $results['person_id']) 
							 {
		                	$abort = true;
		                	$this->error_message = 'Please do NOT update person in person-campus assignment,'.
		                									'use "ADD" instead.<br>Update operation aborted.';
                		 } 
               		 
  			             /** STEP 2: ensure that historical data about campus assignments is not over-written **/                		                		 
 /*               		 if ($this->formValues['campus_id'] != $results['campus_id'])
                		 {  
	                		 $abort = true;
	                		 if (isset($this->error_message)) {
		                		 $this->error_message .= '<br><br>';
	                		 }
	                		 else {
		                		 $this->error_message = '';
	                		 }
		                	 $this->error_message .= 'Please do NOT update campus in person-campus assignment,'.
		                									'use "ADD" instead.<br>Update operation aborted.';	
	                	 }                		              
		            }
		            		            		           
		            
		          // only add new entry if the person-campus combination doesn't exist yet
		          if ($abort == false) 
		          { 			          		          			          			          			          
//			          if ($add == false)
//			          { */
					    	$this->dataManager->updateDBTable();
/*				    	 }
				    	 else		// if ADD was triggered, add entry to DB instead of updating 
				    	 {
					    	 $this->dataManager->setAssignmentID('');	//ensure that primary key is not set
					    	 $this->dataManager->createNewEntry();
				    	 }
		    	 }
 */	               
            }
            
            
            
        } // end if
        
        // now Clear out dataManager & FormValues
        $this->dataManager->clearValues();
        $this->formValues = $this->dataManager->getArrayOfValues();

        
        // on a successful update return assignment_id to ''
        $this->assignment_id='';
        
        
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
        $this->template->set( 'editEntryID', $this->assignment_id );
        
        $this->template->set( 'notice', $this->notice);
	     $this->template->set( 'errorMessage', $this->error_message);

        
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

        
        // store the primary key field name for the data being displayed
        $this->template->set( 'primaryKeyFieldName', 'assignment_id');
        
        // store data list to the template
        // NOTE: we initialize it here to make sure we capture any new data 
        // from a recent processData() call.
        $dataAccessManager = new RowManager_EditCampusAssignmentManager();
        $dataAccessManager->setPersonID($this->person_id);
        
        if ($this->campus_id != '')
        {
        		$dataAccessManager->setCampusID($this->campus_id);
     	  }
        $dataAccessManager->setSortOrder( $this->sortBy );
        $this->dataList = $dataAccessManager->getListIterator();  
        
                // Store the XML Node name for the Data Access Field List
        $xmlNodeName = $this->dataList->getRowManagerXMLNodeName();//RowManager_EditCampusAssignmentManager::XML_NODE_NAME;
        $this->template->set( 'rowManagerXMLNodeName', $xmlNodeName);
          
        $this->template->setXML( 'dataList', $this->dataList->getXML() );   
                 
        
  			// enable drop-down list for adding new person assignments      
        $personManager = new RowManager_PersonManager();
        $campusManager = new RowManager_CampusManager();
/*        $combinedManager = new MultiTableManager();
        $combinedManager->addRowManager($personManager);
        $combinedManager->addRowManager($dataAccessManager, new JoinPair($personManager->getJoinOnPersonID(),$dataAccessManager->getJoinOnPersonID()));
     //   $combinedManager->addRowManager($campusManager, new JoinPair($campusManager->getJoinOnCampusID(),$dataAccessManager->getJoinOnCampusID()));
      if ($this->person_id!='') {
        		$combinedManager->constructSearchCondition( 'person_id', '=', $this->person_id, true );
     	  }
        if ($this->campus_id!='') {
        		$combinedManager->constructSearchCondition( 'campus_id', '=', $this->campus_id, true );
     	  }    
     	
     	  
     	  $dataList = $combinedManager->getListIterator();   
     	  $dataArray = $dataList->getDropListArray();     /**/ 
     	  	
  //   	    $personManager = new RowManager_PersonManager($this->person_id);
   //    $personList = $personManager->getListIterator();                
   //    $personArray = $personList ->getDropListArray();                
  //     $this->template->set( 'list_person_id', $personArray );
        
 //       $personList = $combinedManager->getListIterator();    
 		  $personManager->setPersonID($this->person_id);   
 		  $personManager->setLabelTemplateLastNameFirstName();
 		   $personList = $personManager->getListIterator();           
        $personArray = $personList ->getDropListArray();               
        $this->template->set( 'list_person_id', $personArray );
              
        // enable drop-down list for adding new campus assignments
        if ($this->campus_id != '')
        {
        		$campusManager->setCampusID($this->campus_id);
     	  }
        $campusList = $campusManager->getListIterator();
//  $campusList = $combinedManager->getListIterator();
        $campusArray = $campusList ->getDropListArray();  
        $this->template->set( 'list_campus_id', $campusArray);
        
               
         // enable drop-down list for adding new campus assignments
        $statusManager = new RowManager_CampusAssignmentStatusManager();
        $statusList = $statusManager->getListIterator();
//		  $statusList = $combinedManager->getListIterator();
        $statusArray = $statusList ->getDropListArray();  
        $this->template->set( 'list_assignmentstatus_id', $statusArray);
        
   //     $dataAccessManager->setPersonID($this->person_id);
   //     $dataAccessManager->setCampusID($this->campus_id);
//        $this->dataList = new EditCampusAssignmentList( $this->sortBy );
 //       $this->dataList = $combinedManager->getListIterator();
        
  
        
        /*
         * Add any additional data required by the template here
         */
//          $this->displayValues = 
        
        $templateName = 'siteAdminBox.php';
        // if you are creating a custom template for this page then 
		// replace $templateName with the following:
		//$templateName = 'page_EditCampusAssignment.php';
		
		return $this->template->fetch( $templateName );
        
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
        $dataAccessManager = new RowManager_EditCampusAssignmentManager();
        $dataAccessManager->setPersonID($this->person_id);
        $dataAccessManager->setCampusID($this->campus_id);
        $dataAccessManager->setSortOrder( $this->sortBy );
        $dataList = $dataAccessManager->getListIterator();  
        $displayedValues = $dataList->getDataList();
	    
    		  // disallow the 'continue' link if there is no campus assignment data recorded for this person
		  if (count($displayedValues) == 0) 
		  {
			   $baseLink = $links['edit'];
			   $baseLink = str_replace( modulecim_reg::ASSIGNMENT_ID.'=', '', $baseLink);
			   
			   $links['cont'] = $baseLink;        
  		  }	    
	    
	    parent::setLinks($links);
    }   
    

    
    	
}

?>