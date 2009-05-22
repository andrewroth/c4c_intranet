<?php
/**
 * @package cim_hrdb
 */ 
/**
 * class page_HrdbForms 
 * <pre> 
 * A simple page listing the forms available for editing by admins/users (depending on GET parameter TBD)
 * </pre>
 * @author CIM Team
 * Date:   11 Feb 2008
 */
class  page_HrdbForms extends PageDisplay_FormProcessor {		//extends PageDisplay_DisplayList {

	//CONSTANTS:
	
	/** The list of fields to be displayed */
    const DISPLAY_FIELDS = 'staffscheduletype_desc';
	 const FORM_FIELD_TYPES = 'textbox';
	 const FORM_FIELDS = 'staffscheduletype_desc|T|';
    
    
    /** The Multilingual Page Key for labels on this page */
    const MULTILINGUAL_PAGE_KEY = 'page_HrdbForms';
    
    /** The constants for each level of access **/
    const ACCESS_SUPERADMIN = 1;
    const ACCESS_DIRECTOR_APPROVAL = 2;
    const ACCESS_DIRECTOR_SUBMITCHECK = 3;    
    const ACCESS_GENERAL = 4;
    

	//VARIABLES:
	/** @var [ARRAY] Additional columns in the data list that are links. (Borrowed from DisplayList.php)*/
	protected $linkColumns;
		
	/** @var [OBJECT] The viewer object. */
	protected $viewer;
	
    /** @var [STRING] The path to this module's root directory. */
	protected $pathModuleRoot;
	
// 	/** @var [BOOLEAN] whether the viewer is an admin **/
// 	protected $is_admin;
// 	
// 	/** @var [BOOLEAN] whether the page is an general-access page **/
// 	protected $is_access_page;	

	/** @var [INTEGER] The access level being used for the current instance of the page **/
	protected $access_type;
	
	
	/** @var [STRING] The form action value for the listManager. */
 	protected $formAction;
	
	//CLASS CONSTRUCTOR
	//************************************************************************
	/**
	 * function __construct
	 * <pre>
	 * Initialize the object.
	 * </pre>
	 * @param $pathModuleRoot [STRING] The path to the module's root dir.
	 * @param $viewer [OBJECT] The viewer object.
	 * @param $sortBy [STRING] Field data to sort listManager by.
     * @param $managerInit [INTEGER] Initialization value for the listManager.
	 * @return [void]
	 */
    function __construct($pathModuleRoot, $viewer, $sortBy, $formAction, $formlist_type ) 
    {
	     $fieldList = page_HrdbForms::FORM_FIELDS;
        $fieldTypes = page_HrdbForms::FORM_FIELD_TYPES;
        $displayFields = page_HrdbForms::DISPLAY_FIELDS;
        parent::__construct($formAction,  $fieldList, $displayFields ); 	    
//         parent::__construct( page_HrdbForms::DISPLAY_FIELDS );
        
        $this->pathModuleRoot = $pathModuleRoot;
        $this->viewer = $viewer;
//         $this->is_admin = false;
//         $this->is_access_page = true;
		  $this->access_type = page_HrdbForms::ACCESS_GENERAL;
        $this->formAction = $formAction;		// 11Apr2008: currently just used for Edit Forms page (to add form)

        $this->dataManager = new RowManager_StaffScheduleTypeManager();
        if ($formlist_type != modulecim_hrdb::FORMLIST_EDIT) {	 // only filter by 'is_shown' flag if not editing forms
        		$this->dataManager->setIsShown( true );
     		}
        $this->dataManager->setSortOrder( $sortBy );
//        $this->listManager = new StaffScheduleTypeList( $sortBy );
        $this->listManager = $this->dataManager->getListIterator();
         
         // now initialize the labels for this page
         // start by loading the default field labels for this Module
         $languageID = $viewer->getLanguageID();
         $seriesKey = modulecim_hrdb::MULTILINGUAL_SERIES_KEY;
         $pageKey = modulecim_hrdb::MULTILINGUAL_PAGE_FIELDS;
         $this->labels = new MultilingualManager( $languageID, $seriesKey, $pageKey );
         
         // then load the page specific labels for this page
         $pageKey = page_HrdbForms::MULTILINGUAL_PAGE_KEY;
         $this->labels->loadPageLabels( $pageKey );
         
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
	 * Loads the data from the submitted form. Because this page is made up of 
	 * sub-pages we just need to figure out the appropriate loadFromForm() call
	 * </pre>
	 * Precondition: sub-page objects must be initialized
	 * @return [void]
	 */
    function loadFromForm() 
    {	
	    parent::loadFromForm(); 
    }

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
        // save the value of the Foriegn Key(s)
        /*[RAD_ADMINBOX_FOREIGNKEY]*/
        
//         echo 'form values = <pre>'.print_r($this->formValues,true).'</pre>';
        
        // store values in table manager object.
        $this->dataManager->loadFromArray( $this->formValues );
        
        // now update the DB with the values
        if (!$this->dataManager->isLoaded()) {
            $this->dataManager->createNewEntry();
        } else {
            $this->dataManager->updateDBTable();
        }

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
    
        // Make a new Template object
        $path = SITE_PATH_TEMPLATES;
        // Replace $path with the following line if you want to create a
        // template tailored for this page:
        //$path = $this->pathModuleRoot.'templates/';
        
        
        // store the link values
        // $this->linkValues[ 'view' ] = 'add/new/href/data/here';

        
        // store the link labels
        $this->linkLabels[ 'add' ] = $this->labels->getLabel( '[Add]' );
        $this->linkLabels[ 'edit' ] = $this->labels->getLabel( '[Edit]' );
        $this->linkLabels[ 'del'  ] = $this->labels->getLabel( '[Delete]' );
        $this->linkLabels[ 'cont' ] = $this->labels->getLabel( '[Continue]');
        // $this->linkLabels[ 'view' ] = 'new link label here';

        
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
            
        if ($this->access_type == page_HrdbForms::ACCESS_GENERAL)		//$this->is_access_page == true)
        {
	        $title = $this->labels->getLabel( '[title_access]');
	        $columnLabel = $this->labels->getLabel( '[access]');
	        $link = $this->linkValues[ 'access' ];
	        $fieldName = 'staffscheduletype_id';
	        $this->addLinkColumn( $title, $columnLabel, $link, $fieldName); 
        }
               
        if ($this->access_type == page_HrdbForms::ACCESS_DIRECTOR_APPROVAL)
        {	        
	        $title = $this->labels->getLabel( '[title_approval]');
	        $columnLabel = $this->labels->getLabel( '[approve]');
	        $link = $this->linkValues[ 'approve' ];
	        $fieldName = 'staffscheduletype_id';
	        $this->addLinkColumn( $title, $columnLabel, $link, $fieldName); 	         	              
        }
        
        if ($this->access_type == page_HrdbForms::ACCESS_DIRECTOR_SUBMITCHECK)
        {	        
	        $title = $this->labels->getLabel( '[title_submitted]');
	        $columnLabel = $this->labels->getLabel( '[submitted]');
	        $link = $this->linkValues[ 'submitted' ];
	        $fieldName = 'staffscheduletype_id';
	        $this->addLinkColumn( $title, $columnLabel, $link, $fieldName); 	         	              
        }  
        
        $this->prepareTemplate( $path );          
        
 
        if ($this->access_type == page_HrdbForms::ACCESS_SUPERADMIN)		//($this->is_admin == true)
        {	                
        	  $title = $this->labels->getLabel( '[title_admin]');
	        $columnLabel = $this->labels->getLabel( '[admin]');
	        $link = $this->linkValues[ 'admin' ];
	        $fieldName = 'staffscheduletype_id';
	        $this->addLinkColumn( $title, $columnLabel, $link, $fieldName);  
	        
	        // Enable the 'Add' form for creating new forms
	        $formLabel = 'New Form Name:';		// TODO: replace with constant?
	        $formFieldArray = explode(',',page_HrdbForms::DISPLAY_FIELDS);
	        $formField = $formFieldArray[0];
	        $formButtonText = 'Add Form';
	        $this->template->set( 'addFormAction', $this->formAction );
	        $this->template->set( 'addFormLabel', $formLabel );
	        $this->template->set( 'addFormField', $formField );
	        $this->template->set( 'addButtonText', $formButtonText );
        }
        
        /** BELOW: borrowed from DisplayList.php **/
        // store the field names being displayed
        $fieldNames = explode(',', page_HrdbForms::DISPLAY_FIELDS);
        $this->template->set( 'dataFieldList', $fieldNames);
        
        // store any additional link Columns
        $this->template->set( 'linkColumns', $this->linkColumns);
        
        // store XML List of Applicants ...
        $this->template->setXML( 'dataList', $this->listManager->getXML() );
        /** END BORROWED CODE **/            
                    
        
        // store the Row Manager's XML Node Name
        $this->template->set( 'rowManagerXMLNodeName', RowManager_StaffScheduleTypeManager::XML_NODE_NAME );
        
        // store the primary key field name for the data being displayed
        $this->template->set( 'primaryKeyFieldName', 'staffscheduletype_id');


        /*
         *  Set up any additional data transfer to the Template here...
         */
        
   
        $templateName = 'siteDataList.php';
		// if you are creating a custom template for this page then 
		// replace $templateName with the following:
		//$templateName = 'page_HrdbForms.php';
		
		return $this->template->fetch( $templateName );
        
    }
    
//     // Simple function that enables admin access to HRDB forms
//     public function setAdminAccess ($is_admin = false)
//     {
// 	    $this->is_admin = $is_admin;
//     }
//     
//      // Simple function that sets the page to be a general-access page
//     public function setGeneralAccess ($is_access_page = true)
//     {
// 	    $this->is_access_page = $is_access_page;
//     }   

		// Simple function to set the access type for this page instance
		public function setAccessType($access_type)
		{
			switch($access_type)
			{
				case page_HrdbForms::ACCESS_SUPERADMIN:
					$this->access_type = page_HrdbForms::ACCESS_SUPERADMIN;
					break;				
				case page_HrdbForms::ACCESS_DIRECTOR_APPROVAL:
					$this->access_type = page_HrdbForms::ACCESS_DIRECTOR_APPROVAL;
					break;
				case page_HrdbForms::ACCESS_DIRECTOR_SUBMITCHECK:
					$this->access_type = page_HrdbForms::ACCESS_DIRECTOR_SUBMITCHECK;
					break;											
				case page_HrdbForms::ACCESS_GENERAL:
				default:
					$this->access_type = page_HrdbForms::ACCESS_GENERAL;
					break;			
			}
		}	
		
		
		/*** Borrowed from DisplayList.php **/
		
	/**
	 * function addLinkColumn
	 * <pre>
	 * Adds a value to the linkColumn array.
	 * </pre>
	 * @param $title [STRING] The label to display for the column title
	 * @param $label [STRING] The label to display for the link
	 * @param $link  [STRING] the href value for the link
	 * @param $fieldName [STRING] the name of the field used to complete 
	 * the link
	 * @return [void]
	 */
    function addLinkColumn($title, $label, $link, $fieldName, $useAlt = 'false', $label_alt = '', $link_alt = '', $field_alt = '' ) 
    {
        $entry = array();
        $entry[ 'title' ] = $title;
        $entry[ 'label' ] = $label;
        $entry[ 'link' ] = $link;
        $entry[ 'field' ] = $fieldName;
        $entry[ 'count' ] = 1;
        
        if ($useAlt == 'true')
        {
	        $entry[ 'useAlt' ] = $useAlt;
	        $entry[ 'label_alt' ] = $label_alt;
	        $entry[ 'link_alt' ] = $link_alt;
	        $entry[ 'field_alt' ] = $field_alt;  
	        $entry[ 'count' ] = 2; 
        }     
        
        $this->linkColumns[] = $entry;
    }	
}

?>