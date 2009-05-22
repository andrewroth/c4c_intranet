<?php
/**
 * @package cim_hrdb
 */ 
/**
 * class FormProcessor_EditStaffScheduleForm
 * <pre> 
 * This page is a rough template (to be modified) intended to provide an online HRDB form for general users.
 * Fields are custom-built using page_EditFormFields.php
 * </pre>
 * @author Hobbe Smit
 * Date:   15 Feb 2008
 */
 // RAD Tools: FormSingleEntry Page
class  FormProcessor_EditStaffScheduleForm extends PageDisplay_FormProcessor {

	//CONSTANTS:
	
	/** The list of fields to be displayed */
	 const DISPLAY_FIELDS = 'staffschedule_approved'; 
	 const FORM_FIELD_TYPES = '';
	 const FORM_FIELDS = '';	 
	     
    /** The Multilingual Page Key for labels on this page */
    const MULTILINGUAL_PAGE_KEY = 'FormProcessor_EditStaffScheduleForm';
    

	//VARIABLES:
	
	/** @var [OBJECT] The viewer object. */
	protected $viewer;
	
    /** @var [STRING] The path to this module's root directory. */
	protected $pathModuleRoot;
	
	
	/** @var [INTEGER] Foreign Key needed by Data Manager */
	protected $fieldvalues_id;
	
	/** @var [INTEGER] Foreign Key needed by Data Manager */
	protected $field_id;			
	
	
	/** @var [INTEGER] Stores the currently to-be-updated staff activity id*/
	protected $staffactivity_id;	
	
	/** @var [INTEGER] Stores the id of the current type of form*/
	protected $form_id;	
	
	/** @var [INTEGER] Stores the id of the specific instance of the form type*/
	protected $personal_form_id;	
	
	
	/** @var [INTEGER] Stores the currently to-be-updated person id*/
	protected $person_id;			

		
		/** @var [OBJECT] Stores a reference to active sub-page object */
	protected $active_subPage;		
	
		/** @var [OBJECT] Stores a reference to valid sub-page object */
	protected $basic_form;	

		/** @var [OBJECT] Stores a reference to valid sub-page object */
	protected $optional_sheduled_activity_form;

				
	
	/** @var [STRING] Data sorting parameter passed around */
	protected $sortBy;	
	
	/** @var [STRING] URLs for form submissions*/
	protected $formAction;
	protected $basic_formAction;	
	protected $activity_formAction;				

		
	/** @var [STRING] name of the sub-page form being submitted*/
	protected $formName;	
	
	/** @var [STRING] name of the HRDB form being submitted*/
	protected $hrdbFormTitle;			
	
	
	/** @var [BOOLEAN] Whether to show activity schedule form */
	protected $has_activity_form;	
	
	/** @var [BOOLEAN] Whether form requires contact phone # for every activity */
	protected $has_activity_contact_nums;	
	
	/** @var [ARRAY] Filter activity types, no filter types == no filter required, all types allowed */
	protected $activity_types_filter;	
		
		
	/** @var [BOOLEAN] Whether to show hidden fields */
	protected $show_hidden_fields;
	
	/** @var [BOOLEAN] Whether form has just been successfully submitted */
	protected $form_submitted;		

	/** @var [BOOLEAN] Whether form has been approved */
	protected $is_form_approved;	
	
	/** @var [STRING] Approval notes */
	protected $approval_notes;	
	
	
	//CLASS CONSTRUCTOR
	//************************************************************************
	/**
	 * function __construct
	 * <pre>
	 * Initialize the object.
	 * </pre>
	 * @param $pathModuleRoot [STRING] The path to the module's root dir.
	 * @param $viewer [OBJECT] The viewer object.
	 * @return [void]
	 */																																	
    function __construct($pathModuleRoot, $viewer, $formAction, $basicFormAction, $activityFormAction, $sortBy, $person_id, $staffscheduletype_id, $staffschedule_id = '', $fieldvalues_id = '', $fields_id = '', $activity_id = '', $showHidden = true) 
    {

	     $fieldList = FormProcessor_EditStaffScheduleForm::FORM_FIELDS;
        $fieldTypes = FormProcessor_EditStaffScheduleForm::FORM_FIELD_TYPES;
        $displayFields = FormProcessor_EditStaffScheduleForm::DISPLAY_FIELDS;
        parent::__construct($formAction,  $fieldList, $displayFields ); 
        
         // initialize the object values
        $this->pathModuleRoot = $pathModuleRoot;
        $this->viewer = $viewer;
        $this->sortBy = $sortBy;
        $this->formAction = $formAction;
        $this->basic_formAction = $basicFormAction;
        $this->activity_formAction = $activityFormAction;   
        
//         $this->has_activity_form = $hasActivityForm;  
               
        $this->form_id = $staffscheduletype_id;
        $this->personal_form_id = $staffschedule_id;
        $this->field_id = $fields_id; 
        
        if ($fieldvalues_id != '') 
        {
	        $this->fieldvalues_id = $fieldvalues_id;
        }
        
        if ($activity_id != '') 
        {
	        $this->staffactivity_id = $activity_id;
        }       
        
        // just let these be empty if they are passed as empty
        $this->person_id = $person_id;
        
        $this->has_activity_form = true;		// set default, could be changed if form info exists
        $this->has_activity_contact_nums = false;	// set default, could be changed if form info exists
        $this->activity_types_filter = array();
        $this->show_hidden_fields = $showHidden;
        
        $this->form_submitted = false;
        
//          // Get the real form name
//         $this->hrdbFormTitle = '';
//         if ($this->form_id != '')
//         {
// 	        $formContext = new RowManager_StaffScheduleTypeManager($this->form_id);
//         	  
//      	  }        
  
        // Get form type context information
        $formType = new RowManager_StaffScheduleTypeManager($this->form_id);
        $this->hrdbFormTitle = $formType->getFormName();
        
        $formTypeList = $formType->getListIterator();
        $formTypeArray = $formTypeList->getDataList();
        
        if (count($formTypeArray) > 0)
        {        
	        $row = current($formTypeArray);	// pick first record for grabbing form context data
                	  
        	  // Determine if form should have associated activities
        	  $has_activities = $row['staffscheduletype_has_activities'];
	        if ($has_activities == '0')
	        {
	        		$this->has_activity_form = false;
        	  }        	  
 			
        	  // Determine if form activities require contact phone #s
        	  $has_activity_phone_nums = $row['staffscheduletype_has_activity_phone'];
	        if ($has_activity_phone_nums == '1')
	        {
	        		$this->has_activity_contact_nums = true;
        	  }   
        	  
        	  // Determine if activities form must be filtered by 1 or more activity types
        	  $filters_result = $row['staffscheduletype_activity_types'];
        	  if ($filters_result != '')
        	  {
        	  		$this->activity_types_filter = explode(',', $filters_result);
     	  	  }   
  	  	  }
  	  	  
  	  	       
        
		  // Ensure that a form instance is created for the staff person
        $scheduleFormManager = new RowManager_StaffScheduleManager();
        $scheduleFormManager->setPersonID($this->person_id);
        $scheduleFormManager->setFormID($this->form_id);
        
        $formList = $scheduleFormManager->getListIterator();
        $formArray = $formList->getDataList();
        
        $this->is_form_approved = false;
        if (count($formArray) > 0)
        {
	        $row = current($formArray);	// pick first record for grabbing approval data 
	        $approved = $row['staffschedule_approved'];
	        if ($approved == '1')
	        {
	        		$this->is_form_approved = true;
        	  }      	  
        	          	  
        	  $this->approval_notes = $row['staffschedule_approvalnotes'];
        }	
        
        
			// create references to sub-page objects
			$disableHeading = true;
			$this->basic_form = new FormProcessor_EditBasicStaffForm( $this->pathModuleRoot, $this->viewer, $this->basic_formAction, $this->person_id, $this->form_id, $this->fieldvalues_id, $this->field_id, $disableHeading, $this->show_hidden_fields);		//  $this->sortBy, 
			if ($this->has_activity_form == true)
			{
				 $incContactNums = $this->has_activity_contact_nums;       
// 	        $incContactNums = false;
// 	        $onlyShowVacationType = false;
// 	        	        
// 	        /** HACK: to be replaced with a more generic approach tied in with Edit Form Fields **/
// 			  if ($this->form_id ==  '1')  // summer schedule form requires contact # for each activity
// 			  {
// 				  $incContactNums = true;				  
// 			  } 		
// 			  else if ($this->form_id == '2')
// 			  {
// 				  $onlyShowVacationType = true;
// 			  }
			  							
 				$this->optional_sheduled_activity_form = new FormProcessor_EditStaffActivity( $this->pathModuleRoot, $this->viewer, $this->activity_formAction, $this->sortBy,  $this->staffactivity_id , $this->person_id, $this->form_id, $this->personal_form_id, '', true, $incContactNums, $this->activity_types_filter);		//, $activitytype_id=''
 				$this->optional_sheduled_activity_form->setFormName('scheduledActivityForm');
			}
			
			

			
        // now initialize the labels for this page
        // start by loading the default field labels for this Module
        $languageID = $viewer->getLanguageID();
        $seriesKey = modulecim_hrdb::MULTILINGUAL_SERIES_KEY;
        $pageKey = FormProcessor_EditStaffScheduleForm::MULTILINGUAL_PAGE_KEY;
        $this->labels = new MultilingualManager( $languageID, $seriesKey, $pageKey );


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
	 * Loads the data from the submitted form. Because this page is made up of 
	 * sub-pages we just need to figure out the appropriate loadFromForm() call
	 * </pre>
	 * Precondition: sub-page objects must be initialized
	 * @return [void]
	 */
    function loadFromForm() 
    {	    	 
	    $this->formName = $_REQUEST['form_name']; 	    
	   
// 	   echo 'Inside load_from_form of main page: <pre>'.print_r($this->formValues,true).'</pre><br>';	   
	   
		switch($this->formName) {
			
			case 'basicStaffForm':
				  
				$this->active_subPage = $this->basic_form;	
				break;
			case 'scheduledActivityForm':

				$this->active_subPage = $this->optional_sheduled_activity_form;	 
				break;			
			default:
				die('VALID FORM NAME **NOT** FOUND; name = '.$this->formName);
		}     
		$this->active_subPage->loadFromForm();   
		$this->form_submitted = true;      
       
    } // end loadFromForm() 
    

   //************************************************************************
	/**
	 * function isDataValid
	 * <pre>
	 * Verifies the returned data is valid. Because this page is made up of 
	 * sub-pages we just need to figure out the appropriate isDataValid() call
	 * </pre>
	 * @return [BOOL]
	 */
    function isDataValid() 
    {      
      $isValid = $this->active_subPage->isDataValid();   
       
      // now return result
      return $isValid;        
    }
    
    
    
    //************************************************************************
	/**
	 * function processData
	 * <pre>
	 * Processes the data for this form. Because this page is made up of 
	 * sub-pages we just need to figure out the appropriate processData() call
	 * on a sub-page.
	 * </pre>
	 * Precondition: sub-page objects must be initialized
	 * @return [void]
	 */
    function processData() 
    {

 		$personal_form_id = $this->active_subPage->processData();
 		
 		if ($personal_form_id != '')
 		{
	 		$this->personal_form_id = $personal_form_id;	//NOTE: may replace a non-empty value..
 		}
 		 				
	   	// Flag the requirement for the director to be notified of this change
	   $scheduleFormManager = new RowManager_StaffScheduleManager($this->personal_form_id);
	   $scheduleFormManager->setToNotify(true);
 		$scheduleFormManager->updateDBTable();
 		
 		// Compose Notification E-mail
//  		$message = $this->composeNotificationMessage();
 		
//   		$this->sendEmailToDirector();
 
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
        // Make a new Template object
        //$this->pathModuleRoot.'templates/';
        // Replace $path with the following line if you want to create a
        // template tailored for this page:
        $path = $this->pathModuleRoot.'templates/';
        
        
        // store the link values
        // $this->linkValues[ 'view' ] = 'add/new/href/data/here';
        
        // store the link labels
        $this->linkLabels[ 'add' ] = $this->labels->getLabel( '[Add]' );
//        $this->linkLabels[ 'edit' ] = $this->labels->getLabel( '[Edit]' );
//        $this->linkLabels[ 'del'  ] = $this->labels->getLabel( '[Delete]' );
		  if (!isset($this->linkLabels[ 'cont' ]))
		  {
        		$this->linkLabels[ 'cont' ] = $this->labels->getLabel( '[Continue]');
	 		}
        // $this->linkLabels[ 'view' ] = 'new link label here';

		               			 
			$this->prepareTemplate( $path );
			
		$top_instructions = '';
		$bottom_instructions = '';


		$form_instructions = new RowManager_StaffScheduleInstrManager();
		$form_instructions->setFormTypeID($this->form_id);
		
		$instr_list = $form_instructions->getListIterator();
		$instr_array = $instr_list->getDataList();
		
		foreach( array_keys($instr_array) as $key)
		{
			$record = current($instr_array);
			$top_instructions = $record['staffscheduleinstr_toptext'];
			$bottom_instructions = $record['staffscheduleinstr_bottomtext'];
		}
		
		if ($top_instructions != '')
		{
			$this->template->set('top_instructions', $top_instructions);
		}
		if ($bottom_instructions != '')
		{
			$this->template->set('bottom_instructions', $bottom_instructions);
		}
			
		// Set form approval status message
		$form_approved = "Approval Pending";
		if ($this->is_form_approved == true)
		{
			$form_approved = "Form Approved";
		}
		$this->template->set('form_approval_status', $form_approved );
		$this->template->set('form_approval_notes', $this->approval_notes );
		
			
		// Display message if form has just been submitted
		if ($this->form_submitted == true)
		{
			$statusMessage = 'Form information successfully submitted.';
	  		$this->template->set('form_status_msg', $statusMessage );
	  		$this->form_submitted = false;
  		}
			
		 // Set the sub-page objects
		 $this->template->set('basicStaffForm', $this->generateTopForm() );

		 if ($this->has_activity_form == true)
		 {
		  		$this->template->set('scheduledActivityForm', $this->generateBottomForm() );
  		 }
						        
        // store any additional link Columns
        // example:
            //$title = $this->labels->getLabel( '[title_groups]');
            //$columnLabel = $this->labels->getLabel( '[groups]');
            //$link = $this->linkValues[ 'groups' ];
            //$fieldName = 'accessgroup_id';
            //$this->addLinkColumn( $title, $columnLabel, $link, $fieldName);

        
        // store the page labels
        // NOTE: use this location to update any label tags ...
        // example:
            // $name = $user->getName();
            // $this->labels->setLabelTag( '[Title]', '[userName]', $name);
                    
        
        // store the Row Manager's XML Node Name
//        $this->template->set( 'rowManagerXMLNodeName', RowManager_RegistrationManager::XML_NODE_NAME );
		  $this->template->set( 'rowManagerXMLNodeName', MultiTableManager::XML_NODE_NAME );
        
        // store the primary key field name for the data being displayed
        $this->template->set( 'primaryKeyFieldName', 'person_id');
          
		  
		  // TODO: somehow merge the primary join with the balance owing join.... for efficiency

        /*
         *  Set up any additional data transfer to the Template here...
         */
 //       $this->template->set( 'dataList', $this->dataList);
       
     	  $form_notice = 'Please note that the "Update" button only updates the top form.<br>The bottom form is updated via its own buttons/links.';
        $this->template->set( 'subheading', $this->hrdbFormTitle);
        
        $this->template->set( 'formsNotice', $form_notice);
   
        $templateName = 'page_EditStaffScheduleForm.tpl.php';
		// if you are creating a custom template for this page then 
		// replace $templateName with the following:
		//$templateName = 'page_EditCampusRegistrations.php';
		
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
    function setLinks($links, $activityFormLinks) 
    {
	    if ($this->has_activity_form == true)
		 {
       	$this->optional_sheduled_activity_form->setLinks($activityFormLinks);
    	 }    
  		  
//   		          echo print_r($this->linkValues,true);
	    
	    parent::setLinks($links);
      
    }
    
    //************************************************************************
	/**
	 * function setFormAction
	 * <pre>
	 * Sets the value of the Form Action Link.
	 * </pre>
	 * @param $link [STRING] The HREF link for the continue link
	 * @return [void]
	 */
    function setFormAction($link, $topFormLinks, $bottomFormLinks) 
    {
	    parent::setFormAction($link);
       $this->basic_form->setFormAction($topFormLinks);
 
	    if ($this->has_activity_form == true)
		 {
			$this->optional_sheduled_activity_form->setFormAction($bottomFormLinks);
		 } 
    }    

    
    // returns html of a form displayed at the top of the page (i.e. the basic HRDB form)
    //
    function generateTopForm()
    {
			$content = $this->basic_form->getHTML(); 
         
         return $content;
    } 
    
    // returns html of a form displayed at the bottom of the page (i.e. the scheduled activities form, if enabled)
    //
    function generateBottomForm()
    {
			$content = $this->optional_sheduled_activity_form->getHTML(); 
         
         return $content;
    } 
    
    
     // Sends a "form submitted" notice to the director of the staff-person submitting the form
    private function sendEmailToDirector($msgTxt = '')		
    {
	    $director_emails = '';
	    $director_names = '';
	    $director_info = $this->getDirectorInfo(); 
	    
	    if (isset($director_info)&&(count($director_info) > 0))
	    {
	    	foreach (array_keys( $director_info ) as $key)
	    	{
		    	$record = current($director_info);
		    	$director_emails .= $record['person_email'].',';
		    	$director_names .= $record['person_fname'].' '.$record['person_lname'].',';
		    	next($director_info);
	    	}
	    	$director_emails = substr($director_emails,0,-1);
	    	$director_names = substr($director_names,0,-1);
    	}
	    
	    $person_name = $this->getPersonFullName();
	    
	    // Append to form title to clarify why directors may be receiving two e-mails
	    $form_title = $this->hrdbFormTitle;
	    switch($this->formName) {
			
			case 'basicStaffForm':				  
				$form_title	.= ' (Basic Info)';
				break;
			case 'scheduledActivityForm':
				$form_title	.= ' (Scheduled Activity)';
				break;			
			default:
		}    
	    
	    $message = '';
	    
	    // Create message text if not provided
	    if ($msgTxt == '')
	    {
			$htmlBreak = '';
	       
	       // Create the message
	
	       $message .= 'Dear ';
	       $directors = explode(',',$director_names);
	       foreach( array_keys($directors) as $key )
	       {
		       $message .= current($directors).' and ';
		       next($directors);
	       }
	       $message = substr($message,0,-5);
	       $message .= ',' ."\r\n\r\n" . $htmlBreak;	
	       $message .= 'This message has been sent to notify you of a new form submission that is ready for your approval.';	       
	       $message .= ' Please be prompt in your consideration of the submitted form for approval.' ."\r\n\r\n" . $htmlBreak;
	       $message .= 'Form submitted: '.$form_title . "\r\n\r\n" . $htmlBreak;
	       $message .= 'Submitted by: '.$person_name ."\r\n\r\n" . $htmlBreak;
	       
	       $message .= 'Sincerely,' ."\r\n" . $htmlBreak;
	       $message .= "\t\t" . 'The CIM Team' ."\r\n" . $htmlBreak;	
       }	    
  
	    
	    // retrieve basic confirmation e-mail info.
	    $RECIPIENTS = $director_emails;
	    $SUBJECT = $form_title.' submitted by '.$person_name;
	    $FROM = 'registration@campusforchrist.org';
	    
	    $success = false;
	    
	    if ($message != '')
	    {
// 		     $message = '<html>';	//<head>Some Title</head>';
// 		     $message .= '<body>';	   
       	  $message .= $msgTxt;  
//        	  $message .= "</body></html>";                    

	        $headers = 'MIME-Version: 1.0' . "\r\n";
	        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	        $htmlBreak = '<br/>';     	           
	       
	       $message = wordwrap($message, 70);       
// 	
// 	       $headers .= 'From: '.$FROM . "\n" .
// 				'Reply-To: '.$FROM . "\n" .
// 				'X-Mailer: PHP/' . phpversion();

			 $headers = "From: C4C HRDB Intranet <".$FROM.">\n" .
					      "MIME-Version: 1.0\n" .
					      "Content-type: text; charset=iso-8859-1\n" .
					      'X-Mailer: PHP/' . phpversion();
	
// 				echo "<BR>HEADERS: ".$headers;								
// 				echo "TO: ".$RECIPIENTS;
// 				echo "<br>SUBJECT: ".$SUBJECT;
// 				echo "<BR>MESSAGE: ".$message;
	
			 ini_set('SMTP', EMAIL_SMTP_SERVER);
			 ini_set('smtp_port', EMAIL_SMTP_PORT);
	
	       $success = mail( $RECIPIENTS, $SUBJECT, $message, $headers  );
       }
       
       if ( !$success )
       {
           return 'Error Sending Confirmation E-mail!';		// TODO: replace with a label
       }    	
       else
       {
	        return 'Confirmation E-mail Successfully Sent';	// TODO: replace with a label
        }   

    }    
    
    protected function composeNotificationMessage()
    {
		$message = '';
		$htmlBreak = '';
       
       // Create the message

       $message .= 'Dear directors,' ."\r\n\r\n" . $htmlBreak;	// TODO: add actual names
       $message .= 'This message has been sent to notify you of a new form submission that is ready for your approval.';
       $message .= ' Please be prompt in your consideration of the submitted form for approval.' ."\r\n\r\n" . $htmlBreak;
       $message .= 'Sincerely,' ."\r\n" . $htmlBreak;
       $message .= "\t\t" . 'The CIM Team' ."\r\n" . $htmlBreak;
       
       return $message;
    }
    
    
	 // Retrieve the info for each director above the current user
	 protected function getDirectorInfo()
	 {
		 $director_array = array();
		 
        $staff_id = $this->getStaffIDfromViewerID();
        
        $emailGetter = new MultiTableManager();     
        $staffDirectorManager = new RowManager_StaffDirectorManager();
		  $staffDirectorManager->setStaffID($staff_id);
		  $staffManager = new RowManager_StaffManager();
		  $personManager = new RowManager_PersonManager();
		  
		  $emailGetter->addRowManager($personManager);
		  $emailGetter->addRowManager($staffManager, new JoinPair($personManager->getJoinOnPersonID(), $staffManager->getJoinOnPersonID()));
		  $emailGetter->addRowManager($staffDirectorManager, new JoinPair($staffManager->getJoinOnStaffID(), $staffDirectorManager->getJoinOnDirectorID()));
		  
		  
		  $directorEmailList = $emailGetter->getListIterator();
		  $director_array = $directorEmailList->getDataList();
// 		  foreach (array_keys($directorEmailArray) as $key)
// 		  {
// 			  $record = current($directorEmailArray);
// 			  $director_email_list .= $record['person_email'].',';
// 			  next($directorEmailArray);
// 		  }
// 		  $director_email_list = substr($director_email_list,0,-1);
		  
		  return $director_array;	//$director_email_list;

     }	  
     
     
     // Retrieve the full name of the current user
     private function getPersonFullName()
     {
	     $personManager = new RowManager_PersonManager($this->person_id);
	     
	     return $personManager->getPersonFirstName().' '.$personManager->getPersonLastName();
     }
	    
        // self-explanatory: system user == potential approval-qualified staff director
    protected function getStaffIDfromViewerID()
    {
	    $staffViewer = new MultiTableManager();
	    
       $accessPriv = new RowManager_AccessManager();
       $accessPriv->setViewerID($this->viewer->getID());      
       $staff = new RowManager_StaffManager();
       
       $staffViewer->addRowManager($staff);
       $staffViewer->addRowManager($accessPriv, new JoinPair($staff->getJoinOnPersonID(), $accessPriv->getJoinOnPersonID()));
       
       $staffViewerList = $staffViewer->getListIterator();
       $staffViewerArray = $staffViewerList->getDataList();
       
       $staffID = '';
       reset($staffViewerArray);
       foreach (array_keys($staffViewerArray) as $k)
       {
       	$record = current($staffViewerArray);
       	$staffID = $record['staff_id'];	// can only be 1 staff_id per viewer_id
       	next($staffViewerArray);
    	 }
       
       return $staffID;
    }    	        

}

?>