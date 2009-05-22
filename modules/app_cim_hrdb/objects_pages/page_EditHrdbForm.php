<?php
/**
 * @package cim_hrdb
 */ 
/**
 * class FormProcessor_EditHrdbForm 
 * <pre> 
 * The interface page for creating new HRDB forms by adding/deleting fields
 * </pre>
 * @author CIM Team
 * Date:   11 Feb 2008
 */
 // RAD Tools: FormSingleEntry Page
class  FormProcessor_EditHrdbForm extends PageDisplay_FormProcessor {

	//CONSTANTS:
	
	/** The list of fields to be displayed */
	 const DISPLAY_FIELDS = ''; 
	 const FORM_FIELD_TYPES = '';
	 const FORM_FIELDS = '';	 
	     
    /** The Multilingual Page Key for labels on this page */
    const MULTILINGUAL_PAGE_KEY = 'FormProcessor_EditHrdbForm';
    

	//VARIABLES:
	
	/** @var [OBJECT] The viewer object. */
	protected $viewer;
	
	/** @var [STRING] The path to the module's root directory. */
	protected $pathModuleRoot;
	
	/** @var [STRING] The initilization variable for the dataManager. */
	protected $fields_id;
	
/* no List Init Variable defined for this DAObj */
	
	/** @var [INTEGER] Foreign Key needed by Data Manager */
// 	protected $fieldtype_id;

	/** @var [INTEGER] Foreign Key needed by Data Manager */
// 	protected $staffscheduletype_id;

	/** @var [INTEGER] Foreign Key needed by Data Manager */
// 	protected $datatypes_id;	
	
	

	/** @var [INTEGER] Foreign Key needed by Data Manager */
// 	protected $fieldvalues_id;
	
	/** @var [INTEGER] Foreign Key needed by Data Manager */
// 	protected $field_id;			
	
	
	/** @var [INTEGER] Stores the currently to-be-updated staff activity id*/
// 	protected $staffactivity_id;	
	
	/** @var [INTEGER] Stores the id of the current type of form*/
	protected $form_id;	
	
	/** @var [INTEGER] Stores the id of the specific instance of the form type*/
// 	protected $personal_form_id;	
	
	
	/** @var [INTEGER] Stores the currently to-be-updated person id*/
	protected $person_id;			

		
		/** @var [OBJECT] Stores a reference to active sub-page object */
	protected $active_subPage;		
	
		/** @var [OBJECT] Stores a reference to valid sub-page object */
	protected $editfields_form;	

		/** @var [OBJECT] Stores a reference to valid sub-page object */
	protected $instructions_form;

				
	
	/** @var [STRING] Data sorting parameter passed around */
	protected $sortBy;	
	
	/** @var [STRING] URLs for form submissions*/
	protected $formAction;
	protected $editfields_formAction;	
	protected $instructions_formAction;				

		
	/** @var [STRING] name of the sub-page form being submitted*/
	protected $formName;	
	
	/** @var [BOOLEAN] Whether form has just been successfully submitted */
	protected $form_submitted;		

	
	
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
    function __construct($pathModuleRoot, $viewer, $formAction, $instrFormAction, $editFieldsFormAction, $sortBy, $staffscheduletype_id, $fields_id = '') 
    {

	     $fieldList = FormProcessor_EditHrdbForm::FORM_FIELDS;
        $fieldTypes = FormProcessor_EditHrdbForm::FORM_FIELD_TYPES;
        $displayFields = FormProcessor_EditHrdbForm::DISPLAY_FIELDS;
        parent::__construct($formAction,  $fieldList, $displayFields ); 
        
         // initialize the object values
        $this->pathModuleRoot = $pathModuleRoot;
        $this->viewer = $viewer;
        $this->sortBy = $sortBy;
        $this->formAction = $formAction;
        $this->editfields_formAction = $editFieldsFormAction;
        $this->instructions_formAction = $instrFormAction;   
        
//         $this->has_activity_form = $hasActivityForm;  
               
        $this->form_id = $staffscheduletype_id;
        $this->field_id = $fields_id;       
        
        // just let these be empty if they are passed as empty
//         $this->person_id = $person_id;

        
        $this->form_submitted = false;
        

        
                
        // figure out the important fields for the dataManager
        $fieldsOfInterest = implode(',', $this->formFields);
        
        $this->dataManager = new RowManager_FormFieldManager( $fields_id );
        $this->dataManager->setFieldsOfInterest( $fieldsOfInterest );
        $this->formValues = $this->dataManager->getArrayOfValues();
  	  	  
        
        // Get form type context information
        $formType = new RowManager_StaffScheduleTypeManager($this->form_id);
        
        $formTypeList = $formType->getListIterator();
        $formTypeArray = $formTypeList->getDataList();
         	  	       
        
		  // Ensure that a form instance is created for the staff person
        $scheduleFormManager = new RowManager_StaffScheduleManager();
        $scheduleFormManager->setPersonID($this->person_id);
        $scheduleFormManager->setFormID($this->form_id);
        
        $formList = $scheduleFormManager->getListIterator();
        $formArray = $formList->getDataList();
        

        
        
			// create references to sub-page objects
			$disableHeading = true;	                                                      
			$this->instructions_form = new FormProcessor_EditStaffFormInstructions( $this->pathModuleRoot, $this->viewer, $this->instructions_formAction, $this->form_id, $disableHeading);								
			$this->editfields_form = new FormProcessor_EditFormFields( $this->pathModuleRoot, $this->viewer, $this->editfields_formAction, $this->sortBy, $this->field_id,  $this->form_id, $disableHeading);
				
			
        // now initialize the labels for this page
        // start by loading the default field labels for this Module
        $languageID = $viewer->getLanguageID();
        $seriesKey = modulecim_hrdb::MULTILINGUAL_SERIES_KEY;
        $pageKey = modulecim_hrdb::MULTILINGUAL_PAGE_FIELDS;
        $this->labels = new MultilingualManager( $languageID, $seriesKey, $pageKey );
        
        // then load the page specific labels for this page
        $pageKey = FormProcessor_EditHrdbForm::MULTILINGUAL_PAGE_KEY;
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
	 * Loads the data from the submitted form. Because this page is made up of 
	 * sub-pages we just need to figure out the appropriate loadFromForm() call
	 * </pre>
	 * Precondition: sub-page objects must be initialized
	 * @return [void]
	 */
    function loadFromForm() 
    {	    	 
	    $this->formName = $_REQUEST['form_name']; 
	    
	    if (isset($_REQUEST['submit']))
	    {
	    	$submitText = $_REQUEST['submit'];   
    	 }
    	 else if (isset($_REQUEST['formSubmit']))
    	 {
	    	$submitText = $_REQUEST['formSubmit'];   
    	 }	    	 
	   
// 	   echo 'Inside load_from_form of main page: <pre>'.print_r($_REQUEST,true).'</pre><br>';	 
	   	   
		switch ($submitText) {	//$this->formName) {
			
			case $this->labels->getLabel('[UpdateForm2]'):	//'instructionsForm':
				$this->active_subPage = $this->instructions_form;	
				break;
			case $this->labels->getLabel('[Update]'):		//'editFieldsForm':
			case $this->labels->getLabel('[Add]'):	
			case $this->labels->getLabel('[Delete?]'):
			case $this->labels->getLabel('[Cancel]'):		
				$this->active_subPage = $this->editfields_form;	 
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
 		$this->active_subPage->processData();
        
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
//         $this->linkLabels[ 'add' ] = $this->labels->getLabel( '[Add]' );
//        $this->linkLabels[ 'edit' ] = $this->labels->getLabel( '[Edit]' );
//        $this->linkLabels[ 'del'  ] = $this->labels->getLabel( '[Delete]' );
		  if (!isset($this->linkLabels[ 'cont' ]))
		  {
        		$this->linkLabels[ 'cont' ] = $this->labels->getLabel( '[Back]');
	 		}
        // $this->linkLabels[ 'view' ] = 'new link label here';

     // NOTE:  this parent method prepares the $this->template with the 
     // common Form data.  
     $this->prepareTemplate( $path );
        		
			
		// Display message if form has just been submitted
		if ($this->form_submitted == true)
		{
			$statusMessage = 'Form information successfully submitted.';
	  		$this->template->set('form_status_msg', $statusMessage );
	  		$this->form_submitted = false;
  		}
			
		 // Set the sub-page objects
		 $this->template->set('instrForm', $this->generateTopForm() );
		 $this->template->set('editFieldsForm', $this->generateBottomForm() );
  
						        
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
       
     	  $form_notice = 'Please note that the "Update" button only updates the top form.<br>The bottom form is updated via its own buttons/links.';
        $this->template->set( 'subheading', $form_name);
        
        $this->template->set( 'formsNotice', $form_notice);
   
        $templateName = 'page_EditHrdbForm.tpl.php';
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
    function setLinks($links, $editFieldsFormLinks) 
    {
       $this->editfields_form->setLinks($editFieldsFormLinks);	    
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
       $this->instructions_form->setFormAction($topFormLinks);
		 $this->editfields_form->setFormAction($bottomFormLinks);
    }    

    
    // returns html of a form displayed at the top of the page (i.e. the edit instructions form)
    //
    function generateTopForm()
    {
			$content = $this->instructions_form->getHTML(); 
         
         return $content;
    } 
    
    // returns html of a form displayed at the bottom of the page (i.e. the edit fields form)
    //
    function generateBottomForm()
    {
			$content = $this->editfields_form->getHTML(); 
         
         return $content;
    } 

}

?>