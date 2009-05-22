<?php
/**
 * @package cim_reg
 */ 
/**
 * class page_ConfirmDeleteRegistration 
 * <pre> 
 * Prompts the user as to whether they *really* want to delete a particular registration record.
 * </pre>
 * @author Russ Martin
 * Date:   06 Jul 2007
 */
// RAD Tools : Delete Confirmation Style
class  page_ConfirmDeleteRegistration extends PageDisplay_DeleteConf {

	//CONSTANTS:
    
    /** The list of fields to be displayed */
    const DISPLAY_FIELDS = 'event_id,person_id';
    
    /** The Multilingual Page Key for labels on this page */
    const MULTILINGUAL_PAGE_KEY = 'page_ConfirmDeleteRegistration';
    

	//VARIABLES:
	
	/** @var [OBJECT] The viewer object. */
	protected $viewer;
	
    /** @var [STRING] The path to this module's root directory. */
	protected $pathModuleRoot;
	
	/** @var [INTEGER] The Initialization value for the itemManager. */
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
	 * @param $formAction [STRING] The action on a form submit
     * @param $managerInit [INTEGER] Initialization value for the itemManager.
	 * @return [void]
	 */
    function __construct($pathModuleRoot, $viewer, $formAction, $reg_id='' ) 
    {
        $fieldList = page_ConfirmDeleteRegistration::DISPLAY_FIELDS;
        parent::__construct( $formAction, $fieldList );
        
        // initialzie the object values
        $this->pathModuleRoot = $pathModuleRoot;
        $this->viewer = $viewer;

        $this->reg_id = $reg_id;
        
        // create the item Manager to display
        $this->itemManager = new RowManager_RegistrationManager( $reg_id );
        
        // now initialize the labels for this page
        // start by loading the default field labels for this Module
        $languageID = $viewer->getLanguageID();
        $seriesKey = modulecim_reg::MULTILINGUAL_SERIES_KEY;
        $pageKey = modulecim_reg::MULTILINGUAL_PAGE_FIELDS;
        $this->labels = new MultilingualManager( $languageID, $seriesKey, $pageKey );
        
        // then load the page specific labels for this page
        $pageKey = page_ConfirmDeleteRegistration::MULTILINGUAL_PAGE_KEY;
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
	 * function processData
	 * <pre>
	 * Processes the data for this form.
	 * </pre>
	 * @return [void]
	 */
    function processData() 
    {
		
		if ($this->shouldDelete) {
        	            
			// delete any CC transactions linked to the registration record
			$ccTrans = new RowManager_CreditCardTransactionManager();
			$ccTrans->setRegID($this->reg_id);
			
			$ccTransList = $ccTrans->getListIterator();
			$ccTransArray = $ccTransList->getDataList();
			
			reset($ccTransArray);
			foreach(array_keys($ccTransArray) as $k)
			{
				$record = current($ccTransArray);
				$ccTransID = $record['cctransaction_id'];
				
				// delete any CC transaction receipts linked to the registration record
				$ccReceipt = new RowManager_ReceiptManager($ccTransID);		
				$ccReceipt->deleteEntry();		
				
				// delete CC trans record now that we know CC trans. ID
				$deleteCCtrans = new RowManager_CreditCardTransactionManager($ccTransID);
				$deleteCCtrans->deleteEntry();										
				
				next($ccTransArray);
			}				
			
			// delete any cash transactions linked to the registration record
			$cashTrans = new RowManager_CashTransactionManager();
			$cashTrans->setRegID($this->reg_id);
			
			$cashTransList = $cashTrans->getListIterator();
			$cashTransArray = $cashTransList->getDataList();
						
			reset($cashTransArray);
			foreach(array_keys($cashTransArray) as $k)
			{
				$record = current($cashTransArray);
				$cashTransID = $record['cashtransaction_id'];
				
				// delete cash trans record now that we know cash trans. ID
				$deleteCashTrans = new RowManager_CashTransactionManager($cashTransID);
				$deleteCashTrans->deleteEntry();							
				
				next($cashTransArray);
			}				
			
			// delete any scholarships linked to the registration record
			$scholarship = new RowManager_ScholarshipAssignmentManager();
			$scholarship->setRegID($this->reg_id);
			
			$scholarshipList = $scholarship->getListIterator();
			$scholarshipArray = $scholarshipList->getDataList();
						
			reset($scholarshipArray);
			foreach(array_keys($scholarshipArray) as $k)
			{
				$record = current($scholarshipArray);
				$scholarshipID = $record['scholarship_id'];
				
				// delete cash trans record now that we know scholarship ID
				$deleteScholarship = new RowManager_ScholarshipAssignmentManager($scholarshipID);
				$deleteScholarship->deleteEntry();							
				
				next($scholarshipArray);
			}					
			
			// delete any field values linked to the registration record
			$fieldValues = new RowManager_FieldValueManager();
			$fieldValues->setRegID($this->reg_id);
			
			$fieldValuesList = $fieldValues->getListIterator();
			$fieldValuesArray = $fieldValuesList->getDataList();
						
			reset($fieldValuesArray);
			foreach(array_keys($fieldValuesArray) as $k)
			{
				$record = current($fieldValuesArray);
				$fieldValueID = $record['fieldvalues_id'];
				
				// delete cash trans record now that we know field value ID
				$deleteFieldValue = new RowManager_FieldValueManager($fieldValueID);
				$deleteFieldValue->deleteEntry();							
				
				next($fieldValuesArray);
			}					
		}
		
		parent::processData();	// remove data from cim_reg_registrations table

        
        
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
         * Update any label tags ...
         */
        // example:
            // $name = $user->getName();
            // $this->labels->setLabelTag( '[Title]', '[userName]', $name);
         
        
        
        // NOTE:  this parent method prepares the $this->template with the 
        // common AdminBox data.  
        $this->prepareTemplate( $path );
        
        
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

        // uncomment this line if you are creating a template for this page
		//$templateName = 'page_ConfirmDeleteRegistration.php';
		// otherwise use the generic site template
		$templateName = 'siteDeleteConf.php';
		
		return $this->template->fetch( $templateName );
        
    }
	
}

?>