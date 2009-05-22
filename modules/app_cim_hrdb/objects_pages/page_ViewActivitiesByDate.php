<?php
/**
 * @package cim_hrdb
 */ 
/**
 * class FormProcessor_ViewActivitiesByDate
 * <pre> 
 * This page adds a date-range form to a ViewStaffActivities sub-page for the purpose
 * of searching staff activities by date-range.
 * </pre>
 * @author Hobbe Smit
 * Date:   21 Mar 2008
 */
 // RAD Tools: FormSingleEntry Page
class  FormProcessor_ViewActivitiesByDate extends PageDisplay_FormProcessor {

	//CONSTANTS:
	
	/** The list of fields to be displayed */
	 const FORM_FIELD_TYPES = '';
	 const FORM_FIELDS = 'start_date|T|,end_date|T|';
	 const DISPLAY_FIELDS = 'start_date,end_date'; 	 
	 const FORM_FIELD1 = 'start_date';
	 const FORM_FIELD2 = 'end_date';
	     
    /** The Multilingual Page Key for labels on this page */
    const MULTILINGUAL_PAGE_KEY = 'FormProcessor_ViewActivitiesByDate';
    

	//VARIABLES:
	
	/** @var [OBJECT] The viewer object. */
	protected $viewer;
	
    /** @var [STRING] The path to this module's root directory. */
	protected $pathModuleRoot;

	
	/** @var [INTEGER] Stores the currently to-be-updated staff activity id*/
	protected $staffactivity_id;	
	
	/** @var [INTEGER] Stores the activity type id*/
 	protected $activitytype_id;		
	
	
	/** @var [INTEGER] Stores the currently to-be-updated person id*/
	protected $person_id;			

		
		/** @var [OBJECT] Stores a reference to active sub-page object */
	protected $active_subPage;		
	
		/** @var [OBJECT] Stores a reference to valid sub-page object */
// 	protected $basic_form;	

		/** @var [OBJECT] Stores a reference to valid sub-page object */
	protected $activity_list;
	
	
	/** @var [STRING] Stores the start_date chosen (YYYY-MM-DD_*/
 	protected $start_date;		

	/** @var [STRING] Stores the end_date chosen (YYYY-MM-DD_*/
 	protected $end_date;			
 	
 					
	
	/** @var [STRING] Data sorting parameter passed around */
	protected $sortBy;	
	
	/** @var [STRING] URLs for form submissions*/
	protected $formAction;			

		
	/** @var [STRING] name of the sub-page form being submitted*/
	protected $formName;	
	

	/** @var [BOOLEAN] Whether form requires contact phone # for every activity */
	protected $has_activity_contact_nums;	
	
	/** @var [ARRAY] Filter activity types, no filter types == no filter required, all types allowed */
	protected $activity_types_filter;	

	
	
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
    function __construct($pathModuleRoot, $viewer, $formAction, $sortBy, $person_id, $activity_id = '', $start_date = '', $end_date = '')	//, $activitytype_id = '') 
    {

	     $fieldList = FormProcessor_ViewActivitiesByDate::FORM_FIELDS;
        $fieldTypes = FormProcessor_ViewActivitiesByDate::FORM_FIELD_TYPES;
        $displayFields = FormProcessor_ViewActivitiesByDate::DISPLAY_FIELDS;
        parent::__construct($formAction,  $fieldList, $displayFields ); 
        
         // initialize the object values
        $this->pathModuleRoot = $pathModuleRoot;
        $this->viewer = $viewer;
        $this->sortBy = $sortBy;
        $this->formAction = $formAction;

        if ($activity_id != '') 
        {
	        $this->staffactivity_id = $activity_id;
        }       
        
        // just let these be empty if they are passed as empty
        $this->person_id = $person_id;
        $this->start_date = $start_date;
        $this->end_date = $end_date;
        
        $this->has_activity_contact_nums = false;	// set default, could be changed if form info exists
        $this->activity_types_filter = array();
  
        // Get form type context information
//         $formType = new RowManager_StaffScheduleTypeManager($this->form_id);
//         
//         $formTypeList = $formType->getListIterator();
//         $formTypeArray = $formTypeList->getDataList();
//         
//         if (count($formTypeArray) > 0)
//         {        
// 	        $row = current($formTypeArray);	// pick first record for grabbing form context data
//                 	    	  
//  			
//         	  // Determine if form activities require contact phone #s
//         	  $has_activity_phone_nums = $row['staffscheduletype_has_activity_phone'];
// 	        if ($has_activity_phone_nums == '1')
// 	        {
// 	        		$this->has_activity_contact_nums = true;
//         	  }   
//         	  
//         	  // Determine if activities form must be filtered by 1 or more activity types
//         	  $filters_result = $row['staffscheduletype_activity_types'];
//         	  if ($filters_result != '')
//         	  {
//         	  		$this->activity_types_filter = explode(',', $filters_result);
//      	  	  }   
//   	  	  }
        
        
			// create references to sub-page objects
			$disableHeading = true;										  
			$this->activitytype_id = '';
			$this->activity_list = new page_ViewStaffActivities($this->pathModuleRoot, $this->viewer, $this->sortBy, $this->staffactivity_id, $this->activitytype_id, $disableHeading, $this->start_date, $this->end_date);
			
			
        // now initialize the labels for this page
        // start by loading the default field labels for this Module
        $languageID = $viewer->getLanguageID();
        $seriesKey = modulecim_hrdb::MULTILINGUAL_SERIES_KEY;
        $pageKey = FormProcessor_ViewActivitiesByDate::MULTILINGUAL_PAGE_KEY;
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
	     parent::loadFromForm();
	     
// 	    $this->formName = $_REQUEST['form_name']; 	    
// 	   
// // 	   echo 'Inside load_from_form of main page: <pre>'.print_r($this->formValues,true).'</pre><br>';	   
// 	   
// 		switch($this->formName) {
// 			
// 			case 'basicStaffForm':
// 				  
// 				$this->active_subPage = $this->basic_form;	
// 				break;
// 			case 'scheduledActivityForm':

// 				$this->active_subPage = $this->optional_sheduled_activity_form;	 
// 				break;			
// 			default:
// 				die('VALID FORM NAME **NOT** FOUND; name = '.$this->formName);
// 		}     
// 		$this->active_subPage->loadFromForm();   
// 		$this->form_submitted = true;      
       
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
         $isValid = parent::isDataValid();
         
//       $isValid = $this->active_subPage->isDataValid();   
       
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
//  		$this->active_subPage->processData();

		 $start_date = $_REQUEST[FormProcessor_ViewActivitiesByDate::FORM_FIELD1];
		 $end_date = $_REQUEST[FormProcessor_ViewActivitiesByDate::FORM_FIELD2];
		 $error_message = '';
		
		 // ensure dates are in the proper YYYY-MM-DD format
//        $date_regex = '/[2-9]([0-9]{3})\-[0-1][0-9]\-[0-3][0-9]/';	
       $date_regex = '/[2-9]([0-9]{3})\-(0[1-9]|1[012])\-(0[1-9]|[12][0-9]|3[01])/';	
		 if ((preg_match($date_regex, $start_date) >= 1)&&(preg_match($date_regex, $end_date) >= 1))
		 {
// 			 $time = strtotime($data);
// 			 $data = strftime("%d %b %Y",$time);

			 // ensure that start date <= end date as entered by user
			 if (strtotime($start_date) <= strtotime($end_date) )
			 {
				 	$this->start_date = $start_date;
				 	$this->end_date = $end_date;		
				 			 
					$disableHeading = true;
					$this->activity_list = new page_ViewStaffActivities($this->pathModuleRoot, $this->viewer, $this->sortBy, $this->staffactivity_id, $this->activitytype_id, $disableHeading, $this->start_date, $this->end_date);
			 }
			 else {
				$error_message = 'The beginning search date must be BEFORE (or equal to) the end search date.';
			 }
		 }
		 else
		 {
			 $error_message = 'Please ensure search dates are in the YYYY-MM-DD format.';
		 }	
			 
		 $this->setErrorMessage($error_message);
		 
// 		echo 'start = '.$this->start_date;
// 		echo '<br>end = '.$this->end_date;
		
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
	    $buttonText = 'Search Dates';
	    
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
        $this->linkLabels[ 'DownloadActivitiesDateCSV' ] = $this->labels->getLabel( '[DownloadActivitiesDateCSV]' );

		               			 
			$this->prepareTemplate( $path );
			

						        
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
        $this->template->set( 'primaryKeyFieldName', 'staffactivity_id');
          	  
//         $start_date = '';
// 	     $end_date = '';
//         if (isset($_REQUEST[FormProcessor_ViewActivitiesByDate::FORM_FIELD1]))
//         {
// 	        $start_date = $_REQUEST[FormProcessor_ViewActivitiesByDate::FORM_FIELD1];
// 	        $end_date = $_REQUEST[FormProcessor_ViewActivitiesByDate::FORM_FIELD2];
//         }
		  $this->template->set('scheduledActivityForm', $this->generateSubPage() );
// 		  echo '<br>final date = '.$this->activity_list->testdate;
		  
		  $this->template->set('daterangeFormAction', $this->formAction);
	  	  $this->template->set('start_date', FormProcessor_ViewActivitiesByDate::FORM_FIELD1);
	  	  $this->template->set('end_date', FormProcessor_ViewActivitiesByDate::FORM_FIELD2);		  
		  $this->template->set('submitButtonText', $buttonText);


        /*
         *  Set up any additional data transfer to the Template here...
         */
 //       $this->template->set( 'dataList', $this->dataList);
 
         /** Create and store download CSV link **/           
        $downloadLink = array();
		  $downloadLink[ 'DownloadActivitiesDateCSV' ]  = $this->linkValues[ 'DownloadActivitiesDateCSV' ];
		          
		  $this->template->set('linkLabels', $this->linkLabels);
        $this->template->set('downloadLink', $downloadLink );

   
        $templateName = 'page_ViewActivitiesByDate.tpl.php';
		// if you are creating a custom template for this page then 
		// replace $templateName with the following:
		//$templateName = 'page_EditCampusRegistrations.php';
		
		return $this->template->fetch( $templateName );
        
    }
    
    // returns html of a list displayed at the bottom of the page (i.e. the scheduled activities list)
    //
    function generateSubPage()		//($start_date='', $end_date='')
    {
	    /** HACK?**/
// 	    	$disableHeading = true;										  
// 			$this->activitytype_id = '';
// 			$this->activity_list = new page_ViewStaffActivities($this->pathModuleRoot, $this->viewer, $this->sortBy, $this->staffactivity_id, $this->activitytype_id, $disableHeading, $this->start_date, $this->end_date);
	    
			$content = $this->activity_list->getHTML(); 
         
         return $content;
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

       $this->activity_list->setLinks($links); 
  		  
//   		          echo print_r($this->linkValues,true);	    
 	    parent::setLinks($links);
      
    }
//     
//     //************************************************************************
// 	/**
// 	 * function setFormAction
// 	 * <pre>
// 	 * Sets the value of the Form Action Link.
// 	 * </pre>
// 	 * @param $link [STRING] The HREF link for the continue link
// 	 * @return [void]
// 	 */
//     function setFormAction($link, $topFormLinks, $bottomFormLinks) 
//     {
// 	    parent::setFormAction($link);
//        $this->basic_form->setFormAction($topFormLinks);
//  
// 	    if ($this->has_activity_form == true)
// 		 {
// 			$this->optional_sheduled_activity_form->setFormAction($bottomFormLinks);
// 		 } 
//     }   

		// Get start date of the last search
		public function getStartDate()
		{
			return $this->start_date;
		} 
		
		// Get end date of the last search
		public function getEndDate()
		{
			return $this->end_date;
		} 		
		
		// Set start date of the last search
		public function setStartDate($startDate='')
		{
			if ($startDate != '')
			{
				$this->start_date = $startDate;
			}
		} 
		
		// Set end date of the last search
		public function setEndDate($endDate='')
		{
			if ($endDate != '')
			{
				$this->end_date = $endDate;
			}
		} 			

}

?>