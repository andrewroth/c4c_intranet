<?php
/**
 * @package cim_hrdb
 */ 
/**
 * class FormProcessor_ApproveStaffSchedule
 * <pre> 
 * This page is a rough template (to be modified) intended to provide a page displaying a user form to approve.
 * Fields are custom-built using page_EditFormFields.php
 * </pre>
 * @author Hobbe Smit
 * Date:   25 Feb 2008
 */
 // RAD Tools: FormSingleEntry Page
class  FormProcessor_ApproveStaffSchedule extends PageDisplay_FormProcessor {

	//CONSTANTS:
	
	/** The list of fields to be displayed */
	 const DISPLAY_FIELDS = 'staffschedule_approved,staffschedule_approvalnotes,staffschedule_approvedby'; 	//,staffschedule_lastmodifiedbydirector
	 const FORM_FIELD_TYPES = 'checkbox,textarea,textbox_ro';	//,textbox_ro
	 const FORM_FIELDS = 'staffschedule_approved|C|,staffschedule_approvalnotes|T|,viewer_userID|T|<skip>';	 //,staffschedule_lastmodifiedbydirector|D|<skip>
	     
    /** The Multilingual Page Key for labels on this page */
    const MULTILINGUAL_PAGE_KEY = 'FormProcessor_ApproveStaffSchedule';
    

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

		/** @var [OBJECT] Stores a reference to valid sub-page object */
// 	protected $approval_form;

				
	
	/** @var [STRING] Data sorting parameter passed around */
	protected $sortBy;	
	
	/** @var [STRING] URLs for form submissions*/
	protected $formAction;
	protected $basic_formAction;	// == approval form action
	protected $activity_formAction;			

		
	/** @var [STRING] name of the sub-page form being submitted*/
	protected $formName;	
	
	/** @var [BOOLEAN] Whether to show activity schedule form */
	protected $has_activity_form;	

	/** @var [BOOLEAN] Whether to show contact phone #s for activities */
	protected $has_activity_contact_nums;
	
	/** @var [ARRAY] Filter activity types, no filter types == no filter required, all types allowed */
	protected $activity_types_filter;		
	
	
	/** @var [BOOLEAN] Whether to show hidden fields */
	protected $show_hidden_fields;
	
	/** @var [BOOLEAN] Whether form has just been successfully submitted */
	protected $form_submitted;		

	/** @var [BOOLEAN] Whether form has been approved */
	protected $is_form_approved;				

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
	     $fieldList = FormProcessor_ApproveStaffSchedule::FORM_FIELDS;
        $fieldTypes = FormProcessor_ApproveStaffSchedule::FORM_FIELD_TYPES;
        $displayFields = FormProcessor_ApproveStaffSchedule::DISPLAY_FIELDS;
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
  
        // Get form type context information
        $formType = new RowManager_StaffScheduleTypeManager($this->form_id);
        
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
        
        
        
        // Get person and form type IDs from form instance ID, if applicable
        if (($this->personal_form_id != ''))		//(($this->person_id == '')||($this->staffscheduletype_id == '')) && 
        {
	        $formInstance = new RowManager_StaffScheduleManager($this->personal_form_id);
	        $this->person_id = $formInstance->getPersonID();
	        $this->staffscheduletype_id = $formInstance->getFormID();
	        
// 	        echo 'person_id = '.$this->person_id.'  and   form type id = '.$this->staffscheduletype_id;
        }        
        
        // Setup data-manager tied to staff schedule table (i.e. for approval)
        $form_instance = new RowManager_StaffScheduleManager($staffschedule_id);  
//        $registration->setSortOrder( $sortBy );
        $form_instance->setFormID($this->form_id);
        $form_instance->setPersonID($this->person_id);
        
   //     $multiTableManager2->setLabelTemplate('viewer_userID', '[viewer_userID]');
        $this->listManager = $form_instance->getListIterator(); 
//         $formInstanceArray = $this->listManager->getDataList();	
//         echo "<pre>".print_r($this->listManager,true)."</pre>";
//        echo "<pre>".print_r($formInstanceArray,true)."</pre>";    
        

			// create references to sub-page objects
			$disableHeading = true;
			$disableForm = true;
			$this->basic_form = new FormProcessor_EditBasicStaffForm( $this->pathModuleRoot, $this->viewer, $this->basic_formAction, $this->person_id, $this->form_id, $this->fieldvalues_id, $this->field_id, $disableHeading, $this->show_hidden_fields, $this->personal_form_id, $disableForm);		//  $this->sortBy, 
			if ($this->has_activity_form == true)
			{
				 $incContactNums = $this->has_activity_contact_nums;       
			
 				$this->optional_sheduled_activity_form = new FormProcessor_EditStaffActivity( $this->pathModuleRoot, $this->viewer, $this->activity_formAction, $this->sortBy,  $this->staffactivity_id , $this->person_id, $this->form_id, $this->personal_form_id, '', true, $incContactNums, $this->activity_types_filter, $disableForm);		//, $activitytype_id=''
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
        }	
			
        // now initialize the labels for this page
        // start by loading the default field labels for this Module
        $languageID = $viewer->getLanguageID();
        $seriesKey = modulecim_hrdb::MULTILINGUAL_SERIES_KEY;
        $pageKey = FormProcessor_ApproveStaffSchedule::MULTILINGUAL_PAGE_KEY;
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
			case 'approvalForm':
				$this->active_subpage = null;
				break;							
			default:
				die('VALID FORM NAME **NOT** FOUND; name = '.$this->formName);
		}     
		if ($this->active_subPage == null)
	   {    
			parent::loadFromForm();   
		}
		else
		{
			$this->active_subPage->loadFromForm(); 
		}  
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
	    if ($this->active_subPage == null)
	    {		    
		    $isValid = parent::isDataValid();
	    }
	    else
	    {
      	 $isValid = $this->active_subPage->isDataValid();  
   	 } 
       
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
	    if ($this->active_subPage == null)
	    {
		         // save the value of the Primary Key(s)
				$this->formValues[ 'staffschedule_id' ] = $this->personal_form_id;
				$this->formValues[ 'staffschedule_approvedby' ] = $this->getPersonIDfromViewerID();
				$this->formValues[ 'staffschedule_approvalnotes' ] = trim($this->formValues[ 'staffschedule_approvalnotes' ]);
		     /*[RAD_ADMINBOX_FOREIGNKEY]*/	
		     
		     // Only set the "last modified" time if approval is changed
		     if ($this->formValues['staffschedule_approved'] == 'on')
		     {
			     $this->formValues['staffschedule_approved'] = 1;
			     if ($this->is_form_approved == false)
			     {
				     $this->formValues[ 'staffschedule_lastmodifiedbydirector' ] = strftime("%Y-%m-%d %H:%M:%S",time());		// == CURRENT_TIME
				     $this->is_form_approved = true;
			     }
		     }
		     else
		     {
			     $this->formValues['staffschedule_approved'] = 0;
			     if ($this->is_form_approved == true)
			     {
				     $this->formValues[ 'staffschedule_lastmodifiedbydirector' ] = strftime("%Y-%m-%d %H:%M:%S",time());		// == CURRENT_TIME
				     $this->is_form_approved = false;
			     }			
		     }     
		     
// 		     echo 'form values = <pre>'.print_r($this->formValues,true).'</pre>';
	            
	        $form_instance = new RowManager_StaffScheduleManager($this->personal_form_id);  
	//        $registration->setSortOrder( $sortBy );
// 	        $form_instance->setFormID($this->form_id);
// 	        $form_instance->setPersonID($this->person_id);
	        $form_instance->loadFromArray( $this->formValues );
	        $form_instance->updateDBTable();			            	        	               
	    }
	    else
	    {	  		  
 			 $this->active_subPage->processData();  			  
		 }         
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
        		$this->linkLabels[ 'cont' ] = $this->labels->getLabel( '[Back]');	// [Continue]
	 		}
        // $this->linkLabels[ 'view' ] = 'new link label here';

		               			 
			$this->prepareTemplate( $path );
			
		// Set form approval status message
// 		$form_approved = "Approval Pending";
// 		if ($this->is_form_approved == true)
// 		{
// 			$form_approved = "Form Approved";
// 		}
// 		$this->template->set('form_approval_msg', $form_approved );
// 		
			
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

  		 
			// Set approval form information		
			$is_approved = '';	  	
			$approved_by = '';
			$last_change = '';	 
  		   $approval_array = $this->listManager->getDataList();
			reset($approval_array);
			foreach (array_keys($approval_array) as $k)
			{
				$record = current($approval_array);
				$approved = $record['staffschedule_approved'];
				if ($approved == '1')
				{
					$is_approved = 'CHECKED';
				}
				$approved_by = $record['staffschedule_approvedby'];
				$last_change = $record['staffschedule_lastmodifiedbydirector'];
				$approval_notes = $record['staffschedule_approvalnotes'];
				
				next($approval_array);
			}  		
			
        $personManager = new RowManager_PersonManager( $approved_by );
        $personManager->setSortOrder('person_lname');
        $personManager->setLabelTemplateLastNameFirstName();
        $approved_by = $personManager->getPersonFirstName().' '.$personManager->getPersonLastName();
//         $personList = $personManager->getListIterator( );
//         $personArray = $personList->getDropListArray( );
//         $this->template->set( 'list_approved_by', $personArray ); 			
			   
			$this->template->set('approvalFormAction', $this->formAction);
 			$this->template->set('is_approved', $is_approved);
			$this->template->set('approvalButtonText', 'Approve/Disapprove'); 
			$this->template->set('approval_notes', $approval_notes);  
			$this->template->set('director_field','Last Change By');
 			$this->template->set('approved_by', $approved_by);
			$this->template->set('time_field','Last Change At');
			
			if ($last_change != '')
			{
             $date_regex = '/[2-9]([0-9]{3})\-[0-9]{1,2}\-[0-9]{1,2}/';	
				 if (preg_match($date_regex, $last_change) >= 1)
				 {
					 $time = strtotime($last_change);
					 $last_change = strftime("%d %b %Y  %H:%M:%S",$time);;
				 }
			 }
 			$this->template->set('last_change', $last_change);
 			
 			// 			$this->template->set('last_change', $last_change);		 
						        
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
         // Get the real form name
        $form_name = '';
        if ($this->form_id != '')
        {
	        $formContext = new RowManager_StaffScheduleTypeManager($this->form_id);
        	  $form_name = $formContext->getFormName();
     	  }
     	  
     	  // Get the person's name
     	  $person_name = '';
     	  if ($this->person_id != '')
     	  {
	     	  $personInfo = new RowManager_PersonManager($this->person_id);
	     	  $person_name = $personInfo->getPersonFirstName().' '.$personInfo->getPersonLastName();
     	  }
       
//      	  $form_notice = 'Please note that the "Update" button only updates the top form.<br>The bottom form is updated via its own buttons/links.';
        $this->template->set( 'heading', $form_name);
        $this->template->set( 'subheading', $person_name);		
//         $this->template->set( 'formsNotice', $form_notice);
   
        $templateName = 'page_ApproveStaffSchedule.tpl.php';
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
		 
// 		 $this->approval_form->setFormAction($bottomFormLinks);
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
    
    // returns html of a form displayed at the bottom of the page (i.e. the approval form, if enabled)
    //
//     function generateBottomForm()
//     {
// 			$content = $this->approval_form->getHTML(); 
//          
//          return $content;
//     } 

        // self-explanatory: system user == person to be registered (or at least get personal info changed)
    protected function getPersonIDfromViewerID()
    {
       $accessPriv = new RowManager_AccessManager();
       $accessPriv->setViewerID($this->viewer->getID());
       
       $accessPrivList = $accessPriv->getListIterator();
       $accessPrivArray = $accessPrivList->getDataList();
       
       $personID = '';
       reset($accessPrivArray);
       foreach (array_keys($accessPrivArray) as $k)
       {
       	$record = current($accessPrivArray);
       	$personID = $record['person_id'];	// can only be 1 person_id per viewer_id
       	next($accessPrivArray);
    	 }
       
       return $personID;
    }

}

?>