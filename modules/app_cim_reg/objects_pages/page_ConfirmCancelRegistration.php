<?php
/**
 * @package cim_reg
 */ 
/**
 * class page_ConfirmCancelRegistration 
 * <pre> 
 * Prompt the user to decide whether they really want to cancel an event registration.
 * </pre>
 * @author Russ Martin
 * Date:   17 Aug 2007
 */
 // RAD Tools: Custom Page
class  page_ConfirmCancelRegistration extends PageDisplay {

	//CONSTANTS:
	    /** The list of fields to be displayed */
    const DISPLAY_FIELDS = 'event_id,person_id';
    
    /** The Multilingual Page Key for labels on this page */
    const MULTILINGUAL_PAGE_KEY = 'page_ConfirmCancelRegistration';



	//VARIABLES:
    /** @var [STRING] The form Action for submitting this form. */
	protected $formAction;
	
	/** @var [STRING] list of fields to display. */
	protected $displayFields;	
	
	/** @var [OBJECT] The data item object to display. */
	protected $itemManager;	
	
	
	/** @var [OBJECT] The viewer object. */
	protected $viewer;
	
    /** @var [STRING] The path to this module's root directory. */
	protected $pathModuleRoot;
	
    /** @var [BOOL] should this Object be cancelled?. */
	protected $shouldCancel;
	
	/** @var [BOOL] was this called from a submitted form?. */
	protected $wasSubmitted;
	
	/** @var [INTEGER] The Initialization values for the itemManager. */
	protected $person_id;
	protected $event_id;
	protected $reg_id;

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
    function __construct($pathModuleRoot, $viewer, $formAction, $event_id, $person_id ) 
    {
    
        parent::__construct();
        
        // initialzie the object values
        $this->pathModuleRoot = $pathModuleRoot;
        $this->viewer = $viewer;

        $this->person_id = $person_id;
        $this->event_id = $event_id;
        
        $this->formAction = $formAction;
        $this->displayFields = page_ConfirmCancelRegistration::DISPLAY_FIELDS;
        
        $this->shouldCancel = false;
        $this->wasSubmitted = false;      
        
         // create the item Manager to display
        $regs = new RowManager_RegistrationManager();
        $regs->setPersonID($this->person_id);
        $regs->setEventID($this->event_id);      
          
        $regList =  $regs->getListIterator();
        $regArray = $regList->getDataList();
        
        reset($regArray);
        $record = current($regArray);	// should be single record per person per event
        $this->reg_id = $record['registration_id'];
        
        // init. data manager object
        $this->itemManager = new RowManager_RegistrationManager($this->reg_id);
        
        // now initialize the labels for this page
        // start by loading the default field labels for this Module
        $languageID = $viewer->getLanguageID();
        $seriesKey = modulecim_reg::MULTILINGUAL_SERIES_KEY;
        $pageKey = page_ConfirmCancelRegistration::MULTILINGUAL_PAGE_KEY;
        $this->labels = new MultilingualManager( $languageID, $seriesKey, $pageKey );

        
        // then load the page specific labels for this page
        $this->labels->loadPageLabels( $pageKey );
        
        // add Site YES/NO labels
        $this->labels->setSeriesKey( SITE_LABEL_SERIES_SITE );
        $this->labels->loadPageLabels( SITE_LABEL_PAGE_LIST_YESNO );        
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
	 * @param $param1 [$param1 type][optional description of $param1]
	 * @param $param2 [$param2 type][optional description of $param2]
	 * @return [returnValue, can be void]
	 */
    function loadFromForm() 
    {

        if ( $_POST[ 'submit' ] == $this->labels->getLabel('[yes]')) {
            $this->shouldCancel = true;
        }
        
        $this->wasSubmitted = true;
                
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
         $isValid = true;
        
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
	    
	 
        if ($this->shouldCancel == true) {
	        
	        $status = new RowManager_StatusManager();
	        $status->setStatusDesc(RowManager_StatusManager::CANCELLED);
	        $statusList = $status->getListIterator();
	        $statusArray = $statusList->getDataList();
	        
	        reset($statusArray);	// Assumption: status descriptions are unique
	        $record = current($statusArray);
	        $status_id = $record['status_id'];
	        
	        $reg_record['registration_status'] = $record['status_id'];
	        
	        
// 	        echo "<pre>".print_r($reg_record,true)."</pre>";
// 	        $list = $this->itemManager->getListIterator();
//            echo "manager = <pre>".print_r($list->getDataList(),true)."</pre>";
        
	         // change status of registration record
            $this->itemManager->setStatus($status_id);
            $this->itemManager->loadFromArray( $reg_record );

            $this->itemManager->updateDBTable();   
            
        }
        
    } // end processData()    
    
    
    
    //************************************************************************
	/**
	 * function prepareTemplate
	 * <pre>
	 * Prepares the template object for returning page display data.
	 * </pre>
	 * @return [void]
	 */
    function prepareTemplate($path) 
    {
        parent::prepareTemplate( $path );
    
        // store the form action data
        $this->template->set( 'formAction', $this->formAction );
        
        // store the field names being displayed
        $fieldNames = explode(',', $this->displayFields);
        $this->template->set( 'dataFieldList', $fieldNames);
        
        // store XML List of Applicants ...
        $this->template->setXML( 'dataItem', $this->itemManager->getXML() );
        
    }
    
    
    
    //************************************************************************
	/**
	 * function wasCancelled()
	 * <pre>
	 * Returns the value of <code>shouldCancel</code>.
	 * </pre>
	 * @return [BOOL]
	 */
    function wasCancelled() 
    {
        return $this->shouldCancel;
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
        //$path = $this->pathModuleRoot.'templates/';
        // Otherwise use the standard Templates for the site:
        $path = SITE_PATH_TEMPLATES;
        
                // NOTE:  this parent method prepares the $this->template with the 
        // common Display data.  
        $this->prepareTemplate($path);
        
        
        
         $reg = $this->itemManager;	// retrieve RegistrationManager set to a particular reg_id earlier
//        $reg->setEventID($this->event_id);
        
        $person = new RowManager_PersonManager();
        $person->setLabelTemplateLastNameFirstName();
        $event = new RowManager_EventManager();
//        $event->setEventID($this->event_id);
        
			// create join on person and registration tables
        $multiTableManager = new MultiTableManager();
        $multiTableManager->addRowManager($person);            
        $multiTableManager->addRowManager( $reg, new JoinPair( $reg->getJoinOnPersonID(), $person->getJoinOnPersonID() ) );

        $listIterator = $multiTableManager->getListIterator();         		      	
        $personArray = $listIterator->getDropListArray();	//$listIterator
        $this->template->set( 'list_person_id', $personArray );
//        echo print_r($personArray,true);
        
        // create join on event and registration tables
        $multiTableManager2 = new MultiTableManager();
        $multiTableManager2->addRowManager($event);         
        $multiTableManager2->addRowManager( $reg, new JoinPair( $reg->getJoinOnEventID(), $event->getJoinOnEventID() ) );

        $listIterator2 = $multiTableManager2->getListIterator();         		      	
        $eventArray = $listIterator2->getDropListArray();	//$listIterator
        $this->template->set( 'list_event_id', $eventArray );
//        echo print_r($eventArray,true);       
        
        

        /*
         * Update any label tags ...
         */
        // example:
            // $name = $user->getName();
            // $this->labels->setLabelTag( '[Title]', '[userName]', $name);




        // uncomment this line if you are creating a template for this page
		$templateName = 'siteDeleteConf.php';		//'page_ConfirmCancelRegistration.tpl.php';
		// otherwise use the generic site template
		//$templateName = '';
		
		return $this->template->fetch( $templateName );
		
		
        
    }
	
}

?>