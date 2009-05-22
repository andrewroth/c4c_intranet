<?php
/**
 * @package cim_hrdb
 */ 
/**
 * class FormProcessor_EditStaffActivity 
 * <pre> 
 * Allows staff to edit their various activities (which are then linked to the appropriate forms).
 * </pre>
 * @author CIM Team
 * Date:   15 Feb 2008
 */
 // RAD Tools: AdminBox Page
class  FormProcessor_EditStaffActivity extends PageDisplay_FormProcessor_AdminBox {

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
//     const FORM_FIELDS = 'staffactivity_startdate|D|,staffactivity_enddate|D|,staffactivity_contactPhone|T|,activitytype_id|N|,person_id|T|<skip>,form_name|T|<skip>';
    
    /** The list of field types to be displayed in the form */
    // NOTE: if a field isn't displayed, put a '-' for it's entry.
	 //		 after the 'textbox' type name add a '|' followed by a number to change the textbox length
//     const FORM_FIELD_TYPES = 'datepicker,datepicker,textbox,droplist,-,hidden';
    
    /** The list of fields to be displayed in the data list */
//     const DISPLAY_FIELDS = 'staffactivity_startdate,staffactivity_enddate,staffactivity_contactPhone,activitytype_id';
    
    /** The Querystring Field for which entry is currently being edited ... */
    const MULTILINGUAL_PAGE_KEY = 'FormProcessor_EditStaffActivity';

	//VARIABLES:
	
	// Variables replacing Constants to allow for some dynamic form creation
	protected $FORM_FIELDS;
	protected $FORM_FIELD_TYPES;
	protected $DISPLAY_FIELDS;
	
	/** @var [STRING] The path to the module's root directory. */
	protected $pathModuleRoot;
	
	/** @var [STRING] The form type to associate with this activity */
	protected $sortBy;
		
	/** @var [STRING] The initilization variable for the dataManager. */
	protected $staffactivity_id;
	
/* no List Init Variable defined for this DAObj */
	
	/** @var [INTEGER] Foreign Key needed by Data Manager */
	protected $person_id;
	
	/** @var [INTEGER] The form type to associate with this activity */
	protected $form_id;
	
	
	/** @var [INTEGER] The form instance to associate with this activity */
	protected $personal_form_id;
	
	
	/** @var [INTEGER] Foreign Key needed by Data Manager */
	protected $activitytype_id;

		/** @var [OBJECT] Data Manager storing context for form instance */
	protected $scheduleFormManager;
	
		/** @var [DATE] The form context start and end dates */
	protected $form_start_date;
	protected $form_end_date;
	protected $form_date_range;		// user-friendly date range
	
	/** @var [STRING] Various date error messages */
	protected $dateSwitchMessage;	
	protected $dateContextMessage;	
	
	/** @var [BOOLEAN] Whether only to show vacation activity type */
// 	protected $showOnlyVacation;
	/** @var [ARRAY] activity types to be used as filters */
 	protected $activityTypesFilter;
	
	/** @var [BOOLEAN] Whether to disable the form */
	protected $disableForm;
	
	
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
	 * @param $staffactivity_id [STRING] The init data for the dataManager obj
	 * @param $person_id [INTEGER] The foreign key data for the data Manager
	 * @param $activitytype_id [INTEGER] The foreign key data for the data Manager
	 * @return [void]
	 */																																							
    function __construct($pathModuleRoot, $viewer, $formAction, $sortBy, $staffactivity_id , $person_id='', $form_id='', $personal_form_id='', $activitytype_id='', $disableHeading = true, $showContactField = false, $activityTypesFilter = array(), $disableForm = false)
    {
        // NOTE: be sure to call the parent constructor before trying to 
        //       use the ->formXXX arrays...
        
        if ($showContactField == true)
        {
        		$FORM_FIELDS = 'staffactivity_startdate|T|,staffactivity_enddate|T|,staffactivity_contactPhone|T|,activitytype_id|N|,person_id|T|<skip>,form_name|T|<skip>';
            $FORM_FIELD_TYPES = 'datebox,datebox,textbox,droplist,-,hidden';
        		$DISPLAY_FIELDS = 'staffactivity_startdate,staffactivity_enddate,staffactivity_contactPhone,activitytype_id';
  		  }
		  else {
        		$FORM_FIELDS = 'staffactivity_startdate|T|,staffactivity_enddate|T|,activitytype_id|N|,person_id|T|<skip>,form_name|T|<skip>';
            $FORM_FIELD_TYPES = 'datebox,datebox,droplist,-,hidden';
        		$DISPLAY_FIELDS = 'staffactivity_startdate,staffactivity_enddate,activitytype_id';
		  }
		  
        $fieldList = $FORM_FIELDS;	//FormProcessor_EditStaffActivity::FORM_FIELDS;
        $fieldTypes = $FORM_FIELD_TYPES;	//FormProcessor_EditStaffActivity::FORM_FIELD_TYPES;
        $displayFields = $DISPLAY_FIELDS;	//FormProcessor_EditStaffActivity::DISPLAY_FIELDS;
        parent::__construct($viewer, $formAction, $sortBy, $fieldList, $fieldTypes, $displayFields );


        $this->pathModuleRoot = $pathModuleRoot;
        $this->sortBy = $sortBy;
        if ($sortBy == '')
        {
	        $this->sortBy = 'staffactivity_startdate';
        }

        $this->disableForm = $disableForm;
//         $this->showOnlyVacation = $showOnlyVacation;		// TODO??: replace with activitytype_id = 1
		  $this->activityTypesFilter = $activityTypesFilter;
        $this->staffactivity_id = $staffactivity_id;

        $this->person_id = $person_id;
        $this->form_id = $form_id;
        $this->personal_form_id = $personal_form_id;
    
        // Get person and form type IDs from form instance ID, if applicable
        if (($this->personal_form_id != ''))		//(($this->person_id == '')||($this->staffscheduletype_id == '')) && 
        {
	        $formInstance = new RowManager_StaffScheduleManager($this->personal_form_id);
	        $this->person_id = $formInstance->getPersonID();
	        $this->form_id = $formInstance->getFormID();
	        
// 	        echo 'person_id = '.$this->person_id.'  and   form type id = '.$this->form_id;
        }        
                
        // Set the form instance ID based on other IDs
        if (($this->person_id != '')&&($this->form_id != '')&&($this->personal_form_id == ''))
        {        
	        $this->personal_form_id = $personal_form_id;
	        
	        $this->scheduleFormManager = new RowManager_StaffScheduleManager();
	        $this->scheduleFormManager->setPersonID($this->person_id);
	        $this->scheduleFormManager->setFormID($this->form_id);
	        
	        $formList = $this->scheduleFormManager->getListIterator();
	        $formArray = $formList->getDataList();
	        
	        if (count($formArray) > 0)
	        {
		        $row = current($formArray);	// pick first record for grabbing form ID 
		        $this->personal_form_id = $row['staffschedule_id'];
	        }
        }
        

        $this->activitytype_id = $activitytype_id;

		  $this->disableHeading = $disableHeading;
        
        // figure out the important fields for the dataManager
        $fieldsOfInterest = implode(',', $this->formFields);
        
        $this->dataManager = new RowManager_StaffActivityManager($this->staffactivity_id);
//         $this->dataManager->setStaffActivityID($staffactivity_id);
		  $this->dataManager->setPersonID($this->person_id);
		  
		  if (count($this->activityTypesFilter) > 0)
		  {				
				$activityTypesList = implode(',',$this->activityTypesFilter);
				if ($activityTypesList != '')
				{
					$this->dataManager->addSearchCondition('activitytype_id in ('.$activityTypesList.')');
				}
		  }

        if (!isset($this->form_start_date))
        {
  	     		$this->form_start_date = '';
  	     }
        if (!isset($this->form_start_date))
        {
  	     		$this->form_end_date = ''; 
  	     }  		
  	              
        if ($form_id != '')
        {
        		$scheduleType = new RowManager_StaffScheduleTypeManager($this->form_id);
        		$this->form_start_date = $scheduleType->getStartDate();
//         		$this->dataManager->addSearchCondition( 'staffactivity_startdate >= '.$form_start_date );
        		$this->dataManager->constructSearchCondition('staffactivity_startdate','>=',$this->form_start_date, true);
        		$this->form_end_date = $scheduleType->getEndDate();
//         		$this->dataManager->addSearchCondition( 'staffactivity_enddate <= '.$form_end_date );   
        		$this->dataManager->constructSearchCondition('staffactivity_enddate','<=',$this->form_end_date, true);
        		
  			  $transformedStartDate = $this->getEasyDate($this->form_start_date);
	        $transformedEndDate = $this->getEasyDate($this->form_end_date);
	        $this->form_date_range = $transformedStartDate.' - '.$transformedEndDate;
     	  }
     	  $this->dataManager->setSortOrder($this->sortBy);	// does nothing, see manager called in getHTML()...
     	  
     	  
//      	  $this->dataManager->setFieldsOfInterest( $fieldsOfInterest );
     	  
        $this->formValues = $this->dataManager->getArrayOfValues();


        // now initialize the labels for this page
        // start by loading the default field labels for this Module
        $languageID = $viewer->getLanguageID();
        $seriesKey = modulecim_hrdb::MULTILINGUAL_SERIES_KEY;
        $pageKey = modulecim_hrdb::MULTILINGUAL_PAGE_FIELDS;
        $this->labels = new MultilingualManager( $languageID, $seriesKey, $pageKey );
        
        // then load the page specific labels for this page
        $pageKey = FormProcessor_EditStaffActivity::MULTILINGUAL_PAGE_KEY;
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
    	  $activityFormInstance = new RowManager_ActivityScheduleManager();
    	  if ($this->personal_form_id != '')
    	  {
    	  		$activityFormInstance->setStaffScheduleID($this->personal_form_id);
 	  	  }
    	  
        // if this is a delete operation then
        if ( $this->opType == 'D' ) {
        
            if ( $this->shouldDelete ) {
              
                // Delete from the activity-schedule table as well
                // NOTE: COULD REPLACE WITH A CASCADING FK DELETE 
                $matchList = $activityFormInstance->getListIterator();
                $matchArray = $matchList->getDataList();
                
                reset($matchArray);
                foreach (array_keys($matchArray) as $key)
                {
	                $row = current($matchArray);
	                $primaryID = $row['activityschedule_id'];
	                if ($primaryID != '')
	                {
		                $deleter = new RowManager_ActivityScheduleManager($primaryID);
		                $deleter->deleteEntry();
	                }
	                next($matchArray);
                }
            
                /** Must delete entry from matching table BEFORE deleting activity entry
                  * so that FK constraint is not violated **/
                $db_error_msg = $this->dataManager->deleteEntry();
                $this->setErrorMessage($db_error_msg);
                  
            }
            
        } else {
        // else 
        
            // save the value of the Foriegn Key(s)
            $this->formValues[ 'person_id' ] = $this->person_id;
//             $this->formValues[ 'staffactivity_id' ] = $this->staffactivity_id;
//             $this->formValues[ 'activitytype_id' ] = $this->activitytype_id;
        /*[RAD_ADMINBOX_FOREIGNKEY]*/
        
                		// check to see if dates are invalid, i.e. start date < form's first valid date  OR end date > form's end date
	        if (($this->form_start_date != '')&&($this->form_end_date != ''))
	        {   
        
	        		// check to see if dates are invalid, i.e. start date > end date
	        		if ( strtotime($this->formValues['staffactivity_startdate']) > strtotime($this->formValues['staffactivity_enddate'])  )
	        		{
		        		$this->dateSwitchMessage = 'Start date cannot be after end date!';
	        		}
	        			// check to ensure that form dates are within the range specified for the specific HRDB form
	        		else if ((strtotime($this->formValues['staffactivity_startdate']) < strtotime($this->form_start_date)) ||
			        (strtotime($this->formValues['staffactivity_enddate']) > strtotime($this->form_end_date)))
		         {
		        		$this->dateContextMessage = 'Start and end dates must fall within the following date-range (inclusive):<br>';
		        		$this->dateContextMessage .= $this->form_date_range;
	        	   }	
	        	   else {
		            // Store values in dataManager object
		            $this->dataManager->loadFromArray( $this->formValues );
		            
		            
		            // Interlude: create new form instance record if none exists
		            if ($this->personal_form_id == '')
		            {
		            	$this->scheduleFormManager->createNewEntry();
		            	$this->personal_form_id = $this->scheduleFormManager->getID();
		         	}
		     	
		            
		            // Save the values into the Table.
		            if (!$this->dataManager->isLoaded()) {
		                $this->dataManager->createNewEntry();
		                
		                // Update the schedule-activity match table
		                $newID = $this->dataManager->getID();
		                $activityFormInstance->setStaffActivityID($newID);
		                $activityFormInstance->setStaffScheduleID($this->personal_form_id);
		                $activityFormInstance->createNewEntry();
		                
		            } else {
		                $this->dataManager->updateDBTable();
		            }	
	            }
            }	        	   		        
            
            
        } // end if
        
        // now Clear out dataManager & FormValues
        $this->dataManager->clearValues();
        $this->formValues = $this->dataManager->getArrayOfValues();

        
        // on a successful update return staffactivity_id to ''
        $this->staffactivity_id='';
        
        return $this->personal_form_id;
        
    } // end processData()
    
    /* Function that takes a date in YYYY-MM-DD format and turns it into
       something like  07 September 2008
     */
    protected function getEasyDate($db_date) 
    {
	    $new_date = '';
        $date_regex = '/[2-9]([0-9]{3})\-[0-9]{1,2}\-[0-9]{1,2}/';	
		  if (preg_match($date_regex, $db_date) >= 1)
		  {
			 	$time = strtotime($db_date);
			 	$new_date = strftime("%d %b %Y",$time);;
		  }	 
		  
		  return $new_date;
	  }   
	    
    
    
    
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
        //$path = SITE_PATH_TEMPLATES;
        
        
        
        /*
         * store the link values
         */
        // example:
            // $this->linkValues[ 'view' ] = 'add/new/href/data/here';


        // store the link labels
        // Disable form?
//         if ($this->disableForm != true)
//         {
        		$this->linkLabels[ 'edit' ] = $this->labels->getLabel( '[Edit]' );
        		$this->linkLabels[ 'del'  ] = $this->labels->getLabel( '[Delete]' );
//      	  }
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
        $this->template->set( 'editEntryID', $this->staffactivity_id );
  		  $this->formValues['form_name'] = 'scheduledActivityForm';
       

        
        // store all the fields to the template
        $this->setFormFieldsToTemplate();
        
        /*
         * Form related Template variables:
         */
        // Disable form?
        if ($this->disableForm == true)
        {
	        $this->template->set( 'disableForm', $this->disableForm);
        }
        
        
        /*
         * Insert the date start/end values for the following date fields:
         */
        // example:
            //$this->template->set( 'startYear_[fieldName]', 2000);
            //$this->template->set( 'endYear_[fieldName]', 2010);
        $this->template->set( 'startYear_staffactivity_startdate', 2000);
        $this->template->set( 'endYear_staffactivity_startdate', 2010);

        $this->template->set( 'startYear_staffactivity_enddate', 2000);
        $this->template->set( 'endYear_staffactivity_enddate', 2010);




        /*
         * List related Template variables :
         */
        // Store the XML Node name for the Data Access Field List
        $xmlNodeName = RowManager_StaffActivityManager::XML_NODE_NAME;
        $this->template->set( 'rowManagerXMLNodeName', $xmlNodeName);
        
        // store the primary key field name for the data being displayed
        $this->template->set( 'primaryKeyFieldName', 'staffactivity_id');
        
        // store data list to the template
        // NOTE: we initialize it here to make sure we capture any new data 
        // from a recent processData() call.
        $dataAccessManager = new RowManager_StaffActivityManager();
        if (($this->form_start_date != '')&&($this->form_end_date != ''))
        {
	        $dataAccessManager->constructSearchCondition('staffactivity_startdate','>=',$this->form_start_date, true);  
	        $dataAccessManager->constructSearchCondition('staffactivity_enddate','<=',$this->form_end_date, true);
        }
//         if ($this->showOnlyVacation == true)
// 		  {
// 			  $dataAccessManager->setActivityTypeID('1'); // **HACK** activitytype set to vacation
// 		  }
		  if (count($this->activityTypesFilter) > 0)
		  {
				$activityTypesList = implode(',',$this->activityTypesFilter);
				$dataAccessManager->addSearchCondition('activitytype_id in ('.$activityTypesList.')');
// 				$dataAccessManager->constructSearchCondition('activitytype_id','=',$activityTypesList, true);
		  }
        $dataAccessManager->setPersonID($this->person_id);
        $dataAccessManager->setSortOrder($this->sortBy);

     	  
//        $this->dataList = new StaffActivityList( $this->sortBy );
        $this->dataList = $dataAccessManager->getListIterator();		// $dataAccessManager
        $this->template->setXML( 'dataList', $this->dataList->getXML() );
        
        
        
        
        /*
         * Add any additional data required by the template here
         */
        $this->template->set( 'disableHeading', $this->disableHeading ); 
        
        $activitytype = new RowManager_ActivityTypeManager();
//         if ($this->showOnlyVacation == true)
// 		  {
// 			  $activitytype->setActivityTypeID('1'); // **HACK** activitytype set to vacation
// 		  }   
		  if (count($this->activityTypesFilter) > 0)
		  {
				$activityTypesList = implode(',',$this->activityTypesFilter);
				if ($activityTypesList != '')
				{
					$activitytype->addSearchCondition('activitytype_id in ('.$activityTypesList.')');
				}
		  }       
		  $activitytype->setSortOrder( 'activitytype_desc' );
//         $activitytypeList = new ListIterator($activitytype);	
//         $activitytypeArray = $activitytypeList->getDropListArray();
		  $activitytypeList = $activitytype->getListIterator();
		  $activitytypeArray = $activitytypeList->getDataList();
        
        foreach (array_keys($activitytypeArray) as $key)
        {
	        $record = current($activitytypeArray);
	        $colorCode = $record['activitytype_color'];
	        $eventDesc = $record['activitytype_desc'];
	        $activitytypeArray[$key] = '<span style="color:'.$colorCode.';">'.$eventDesc.'</span>';
	        next($activitytypeArray);
        }

        $this->template->set( 'list_activitytype_id', $activitytypeArray );

        /* First check to see whether start date > end date
         * then check if date matches form date context 
         */
        if (isset($this->dateSwitchMessage))
        {
	        $this->template->set( 'date_error_msg', $this->dateSwitchMessage );
        }
        else
        if (isset($this->dateContextMessage))
        {
	        $this->template->set( 'date_error_msg', $this->dateContextMessage );
        }	        	


        
//         $templateName = 'siteAdminBox.php';
        // if you are creating a custom template for this page then 
		// replace $templateName with the following:
		$this->template->set( 'formName', $this->formValues['form_name'] ); 
		$templateName = 'page_EditStaffActivity.tpl.php';
		
		return $this->template->fetch( $templateName );
        
    }
    
    
    // Simple function to return user-friendly form date-range
    function getFormDateRange()
    {
	    return $this->form_date_range;
    }
    	
    
    // Use this function to ensure that as a sub-page the form name still is set
    public function setFormName($name='')
    {
	    $this->formValues['form_name'] = $name;
    }
}

?>