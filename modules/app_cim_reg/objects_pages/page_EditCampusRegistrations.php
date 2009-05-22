<?php
/**
 * @package cim_reg
 */ 
 
$toolName = 'Tools/tools_Finances.php';
$toolPath = Page::findPathExtension( $toolName );
require_once( $toolPath.$toolName);

/**
 * class page_EditCampusRegistrations 
 * <pre> 
 * Used to manage registrations for a particular event-campus combination.
 * </pre>
 * @author Russ Martin
 * Date:   06 Jul 2007
 */
class  page_EditCampusRegistrations extends PageDisplay_DisplayList {	//extends PageDisplay_FormProcessor {	//_

	//CONSTANTS:
	
	/** The list of fields to be displayed */
//    const DISPLAY_FIELDS = 'registration_id,person_id,registration_date';		cctransaction_processed, (REMOVED ON SEPT 26, 2007)
	 const DISPLAY_FIELDS = 'person_lname,person_fname,registration_date,person_email,cashtransaction_recd,cashtransaction_staffName,status_desc,registration_balance';
	 // also payment_type = CASH/CC; also paid? = cctransaction_processed or cashtransaction_recd
  
//	 const FORM_FIELD_TYPES = '';//'textbox,textbox,textbox,textbox,hidden';
//	 const FORM_FIELDS = '';//'scholarship_desc|T|,scholarship_desc|T|,scholarship_sourceAcct|T|,scholarship_amount|T|,form_name|T|<skip>';//,scholarship_id|T|<skip>';	 
	   
    /** The Multilingual Page Key for labels on this page */
    const MULTILINGUAL_PAGE_KEY = 'page_EditCampusRegistrations';
    
    
    /** default sending e-mail address **/
    const DEFAULT_EMAIL = 'registration@campusforchrist.org';
    
    

	//VARIABLES:
	
	/** @var [OBJECT] The viewer object. */
	protected $viewer;
	
    /** @var [STRING] The path to this module's root directory. */
	protected $pathModuleRoot;
	
	/** @var [INTEGER] Foreign Key needed by Data Manager */
	protected $event_id;
	
	/** @var [INTEGER] Foreign Key needed by Data Manager */
	protected $campus_id;	
	
	/** @var [STRING] the campus description **/
	protected $campus_name;
	
		/** @var [ARRAY] list of balances owed per registration */
	protected $owingArray;
	
	/** @var [OBJECT] Stores a reference to valid sub-page object: registrants drop-list */	
	protected $registrants_dropList;	
	
	/** @var [STRING] Stores URL for form submitting registrant name to offline registration process */
	protected $registrant_formAction;
	
	/** @var [BOOLEAN] Indicates whether the offline reg. process has just been completed */
	protected $is_in_reg_process;	
	
	/** @var [INTEGER] Foreign Key needed for offline reg confirmation e-mail */
	protected $reg_id;
	
	
	/** @var [STRING] Data sorting parameter passed around */
	protected $sortBy;		
	
	/** @var [INTEGER] The initilization value for the listManager. */
//	protected $managerInit;
/* no List Init Variable defined for this DAObj */
		
	
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
    function __construct($pathModuleRoot, $viewer, $registrant_formAction, $sortBy, $event_id, $campus_id="", $isInRegProcess = 'FALSE', $reg_id = '') //$formAction, 
    {
// 	     $fieldList = page_EditCampusRegistrations::FORM_FIELDS;
//        $fieldTypes = page_EditCampusRegistrations::FORM_FIELD_TYPES;
        $displayFields = page_EditCampusRegistrations::DISPLAY_FIELDS;
        parent::__construct($displayFields ); //$formAction,  $fieldList, 
               
        $this->pathModuleRoot = $pathModuleRoot;
        $this->viewer = $viewer;
        
        $this->registrant_formAction = $registrant_formAction;
        $this->sortBy = $sortBy;
        
        $this->event_id = $event_id;
        $this->campus_id = $campus_id; 
        
        $this->is_in_reg_process = $isInRegProcess;
        $this->reg_id = $reg_id;
                
//        $this->managerInit = $managerInit;
        

//        $dataAccessObject = new RowManager_RegistrationManager();
//        $dataAccessObject->setSortOrder( $sortBy );
//        $this->listManager = new RegistrationList( $sortBy );
//        $this->listManager = $dataAccessObject->getListIterator();
        
        
        $registration = new RowManager_RegistrationManager();  
        $registration->setSortOrder( $sortBy );
        
        $registration->setEventID($this->event_id);
        $person = new RowManager_PersonManager();
        $assignment = new RowManager_AssignmentsManager();	// assigns campus to person
        $campus = new RowManager_CampusManager();
     //   $campus->setCampusID($this->campus_id);
        $cash_trans = new RowManager_CashTransactionManager();
        $cc_trans = new RowManager_CreditCardTransactionManager();
        $status = new RowManager_StatusManager();
       
     	  // join 6 tables together: 
     	  //cim_reg_registration, cim_hrdb_person, cim_hrdb_assignment, cim_hrdb_campus, 
     	  //cim_reg_cashtransaction, and cim_reg_cctransaction  (and cim_reg_status)
        $campusRegs = new MultiTableManager();
/*        $campusRegs->addRowManager( $registration, new JoinPair( $person->getJoinOnPersonID(), $registration->getJoinOnPersonID()));        
        $campusRegs->addRowManager( $person, new JoinPair( $assignment->getJoinOnPersonID(), $person->getJoinOnPersonID() ) );
        $campusRegs->addRowManager( $assignment, new JoinPair( $campus->getJoinOnCampusID(), $assignment->getJoinOnCampusID() ) );
        $campusRegs->addRowManager( $cash_trans, new JoinPair( $registration->getJoinOnRegID(), $cash_trans->getJoinOnRegID() ) );
/*        $campusRegs->addRowManager( $cc_trans, new JoinPair( $registration->getJoinOnRegID(), $cc_trans->getJoinOnRegID() ) );
*/
/**/        
		  $campusRegs->addRowManager($campus);			
        $campusRegs->addRowManager( $assignment, new JoinPair( $campus->getJoinOnCampusID(), $assignment->getJoinOnCampusID(), JOIN_TYPE_LEFT) );
        $campusRegs->addRowManager( $person, new JoinPair( $assignment->getJoinOnPersonID(), $person->getJoinOnPersonID(), JOIN_TYPE_LEFT ) );
        $campusRegs->addRowManager( $registration, new JoinPair( $person->getJoinOnPersonID(), $registration->getJoinOnPersonID(), JOIN_TYPE_LEFT));        
        $campusRegs->addRowManager( $cash_trans, new JoinPair( $registration->getJoinOnRegID(), $cash_trans->getJoinOnRegID(), JOIN_TYPE_LEFT ) );
        $campusRegs->addRowManager( $cc_trans, new JoinPair( $registration->getJoinOnRegID(), $cc_trans->getJoinOnRegID(), JOIN_TYPE_LEFT ) );
        $campusRegs->addRowManager( $status, new JoinPair( $registration->getJoinOnStatus(), $status->getJoinOnStatusID(), JOIN_TYPE_LEFT ) ); 
                
        if ($this->campus_id!='') {
        		$campusRegs->constructSearchCondition( 'campus_id', '=', $this->campus_id, true );
     	  }
     	  // (below) ensures no duplicate entries appear in case of multiple payments
     	  // TODO: figure out which record is displayed....
     	  $campusRegs->setGroupBy( 'registration_id' );	
//         $campusRegs->setSortOrder( $sortBy );
        $campusRegs->setPrimaryKeyField( 'registration_id' );
        
        if ($sortBy == 'registration_balance')
        {
	        $campusRegs->addSortField($sortBy, 'DESC');	// sort balances from greatest to least
        }
        else
        {
	        $campusRegs->addSortField($sortBy);	// sort field from least to greatest value
        }
        
        
   //     $multiTableManager2->setLabelTemplate('viewer_userID', '[viewer_userID]');
        $this->listManager = $campusRegs->getListIterator(); 
        $regsArray = $this->listManager->getDataList();	

//          echo "<pre>".print_r($this->listManager,true)."</pre>";
//         echo "<pre>".print_r($regsArray,true)."</pre>";    

        // cycle through registrations and store balance owing for each
        $this->owingArray = array();
        $priceGetter = new FinancialTools();
        
        $results = array();
        $temp = array();
        reset($regsArray);
	     	foreach(array_keys($regsArray) as $k)
			{
				$reg = current($regsArray);	
	//				echo 'regID = '.$reg['registration_id'];
				$reg_id = $reg['registration_id'];
				$param = null;
				$array = array();
				$owed = $reg['registration_balance']; // $priceGetter->simpleCalcBalanceOwing($reg_id, $this->event_id, $this->campus_id);
				$this->owingArray[$reg_id] = $owed;	
				
				next($regsArray);
	
			}
//			echo "<pre>".print_r($this->owingArray,true)."</pre>";   

			// create references to sub-page object: registrant drop-down list
//			$this->registrants_dropList = new FormProcessor_EditCampusRegistrations_OffflineRegBox( $this->pathModuleRoot, $this->viewer, $formAction);

      
         // now initialize the labels for this page
         // start by loading the default field labels for this Module
         $languageID = $viewer->getLanguageID();
         $seriesKey = modulecim_reg::MULTILINGUAL_SERIES_KEY;
         $pageKey = modulecim_reg::MULTILINGUAL_PAGE_FIELDS;
         $this->labels = new MultilingualManager( $languageID, $seriesKey, $pageKey );
         
         // then load the page specific labels for this page
         $pageKey = page_EditCampusRegistrations::MULTILINGUAL_PAGE_KEY;
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
	 * Loads the data from the submitted form.
	 * </pre>
	 * @return [void]
	 */
    function loadFromForm() 
    {
        parent::loadFromForm();
        
        /*
         * Put any additional data manipulations here.
         * if you don't need to do anything else, you should 
         * just remove this method and let the parent method get
         * called directly.
         */
        
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
		// nothing to do here

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
        $path = $this->pathModuleRoot.'templates/';
        // Replace $path with the following line if you want to create a
        // template tailored for this page:
        //$path = $this->pathModuleRoot.'templates/';
        
        
        // store the link values
        // $this->linkValues[ 'view' ] = 'add/new/href/data/here';

        
        // store the link labels
        $this->linkLabels[ 'add' ] = $this->labels->getLabel( '[Add]' );
        $this->linkLabels[ 'edit' ] = $this->labels->getLabel( '[Edit]' );
        $this->linkLabels[ 'del'  ] = $this->labels->getLabel( '[Delete]' );
        $this->linkLabels[ 'cont' ] = $this->labels->getLabel( '[GoBack]');
        
        $this->linkLabels[ 'CampusEventDataDump' ] = 'Download Campus-specific Event Registration Summary';
        $this->linkLabels[ 'CampusEventScholarshipList' ] = 'Download Campus-specific Scholarship List';
        $this->linkLabels[ 'EmailCampusRegistrants' ] = $this->labels->getLabel( '[EmailCampusRegistrants]');
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
            
        
        $this->prepareTemplate( $path );
        
        // has viewer just returned from offline registration process?
		  if ($this->is_in_reg_process == 'TRUE')
		  {
			  $this->template->set( 'regCompleted', $this->is_in_reg_process );
			  
			  $reg_result = $this->setRegistrationStatus();	// uses reg_id from offline reg process to get status
			  $result_array = explode('|',$reg_result);
			  $reg_status = $result_array[0];
			  $reg_message = $result_array[1];
			  
			  $this->template->set( 'regStatus', $reg_status );
			  
			  // only send e-mail if all pertinent registration info has been stored (including cash/CC event deposit, if applicable)
			  if ($reg_status == RowManager_StatusManager::REGISTERED)
			  {	
				  if (!defined('IGNORE_EMAILS'))
				  {	  
			  		$reg_message = $this->sendConfirmationEmail();	// since reg_message = '' if REGISTERED, use for e-mail status message
		  		  }
		  	  }
		  	  $this->template->set('regMessage', $reg_message);
		  }         
        
		  $campuses = new RowManager_CampusManager();
		  $campuses->setCampusID($this->campus_id);
		  
		  $campusList = $campuses->getListIterator();
		  $campusArray = $campusList->getDataList();
		  
		  // only 1 campus per campus_id 
		  $the_campus = current($campusArray);
		  $this->campus_name = $the_campus['campus_desc'];
		  $this->template->set('campusName', $this->campus_name);
        
        // store the Row Manager's XML Node Name
//        $this->template->set( 'rowManagerXMLNodeName', RowManager_RegistrationManager::XML_NODE_NAME );
		  $this->template->set( 'rowManagerXMLNodeName', MultiTableManager::XML_NODE_NAME );
        
        // store the primary key field name for the data being displayed
        $this->template->set( 'primaryKeyFieldName', 'registration_id');
        
        $boolArray = array();
        $boolArray['0'] = 'no';
        $boolArray['1'] = 'yes';

        $this->template->set( 'list_cctransaction_processed', $boolArray ); 
		  $this->template->set( 'list_cashtransaction_recd', $boolArray ); 
		  $this->template->set( 'owingArray', $this->owingArray ); 
		  
		  
		          // load offline registrations registrant drop-down list
       $this->template->set('offlineRegistrationBox', $this->generateRegistrantsDroplist() );
		  
		  
		  // TODO: somehow merge the primary join with the balance owing join.... for efficiency

        /*
         *  Set up any additional data transfer to the Template here...
         */
//         $this->template->set( 'dataList', $this->dataList);
   
        $templateName = 'page_EditCampusRegistrations.tpl.php';
		// if you are creating a custom template for this page then 
		// replace $templateName with the following:
		//$templateName = 'page_EditCampusRegistrations.php';
		
		return $this->template->fetch( $templateName );
        
    }
    
    // returns html of a drop-down list of all possible registrants
    //
    private function generateRegistrantsDroplist()
    {
//			$content = $this->_controller->loadEditCampusRegistrations_OffflineRegBox(); 
			//$content = $this->registrants_dropList->getHTML(); 

			$people = new RowManager_PersonManager();
			$access = new RowManager_AccessManager();				// ADDED Nov 21, 2007
			$viewers = new RowManager_ViewerManager();			// ADDED Nov 21, 2007
			$assignment = new RowManager_AssignmentsManager();
			$assignment->setCampusID($this->campus_id);
			
		   $registrants = new MultiTableManager();
         $registrants->addRowManager($people);	
         $registrants->addRowManager( $assignment, new JoinPair( $people->getJoinOnPersonID(), $assignment->getJoinOnPersonID()) );	
         $registrants->addRowManager( $access, new JoinPair( $people->getJoinOnPersonID(), $access->getJoinOnPersonID()));	// ADDED Nov 21, 2007
         $registrants->addRowManager( $viewers, new JoinPair ( $access->getJoinOnViewerID(), $viewers->getJoinOnViewerID()));	// ADDED Nov 21, 2007
         
         // get sub-query data for filtering out registrants that have already been registered for event
         $regs = new RowManager_RegistrationManager();
         $regs->setEventID($this->event_id);
//          $regs->setPersonID($this->person_id);
         $status = new RowManager_StatusManager();
         $status->setStatusDesc(RowManager_StatusManager::REGISTERED);
        
         $regData = new MultiTableManager();
         $regData->addRowManager($regs);
         $regData->addRowManager($status, new JoinPair($regs->getJoinOnStatus(), $status->getJoinOnStatusID()));
         $regData->setFieldList('person_id');
         $registered_SQL = $regData->createSQL();
//          echo "<br>CREATED SQL 1 = ".$registered_SQL;
      
			// actually creates the sub-query ensuring that registrants in drop-down list are NOT registered
			$negateSubQuery = true;
			$addSubQuery = true;
         $registrants->constructSubQuery( 'person_id', $registered_SQL, $negateSubQuery, $addSubQuery );					
			
			$registrants->setSortOrder('person_lname');
			$peopleManager = $registrants->getListIterator(); 
         $registrantsArray = $peopleManager->getDataList();
//          echo "<br>CREATED SQL 2 = ".$registrants->createSQL();	
         
         $registrant = array();
         
         // NOTE: the drop-down list stealthily passes PERSON_ID to controller (see name="SV43")
			$dropList =
			'<form name="Form" id="Form" method="post" action="'.$this->registrant_formAction.'">'.
				'Select a registrant for offline registration, or choose "New Registrant" :<br><br>'. 
				'<select name="'.modulecim_reg::PERSON_ID.'">'.
				'<option selected="selected" value="-1">New Registrant</option>';         
         
         // retrieve person first and last name from database array
	      reset($registrantsArray);
        	foreach(array_keys($registrantsArray) as $k)
			{
				$personData = current($registrantsArray);	
//				$registrant['person_fname'] = $personData['person_fname'];
//				$registrant['person_lname'] = $personData['person_lname'];	

				// add registrant names to drop-down list
//				for ($i = 0; $i < $totalPeople; $i++) 
//				{												
					$dropList .= '<option value='.$personData['person_id'].'>'.$personData['person_lname'].', '.$personData['person_fname'].' ('.$personData['viewer_userID'].')</option>';
//				}	
				
				next($registrantsArray);

			}	
			
//			$totalPeople = count($	
								
			$dropList .= '</select>'.
							'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input name="REGISTER" type="submit" value="REGISTER" /></form>';
         
         return $dropList;
    }
    
    // sends offline registration confirmation e-mail to admin and registrant
    private function sendConfirmationEmail($appendHTML = false)		// NOTE: set to 'true' in the case of event_id = 14 (Winter Conference)
    {
	    // retrieve basic confirmation e-mail info.
	    $INFO_FIELDS_TOTAL = 10;
	    $emailInfo = $this->getConfirmEmailInfo($this->reg_id);
	    
	    $financeGetter = new FinancialTools();
	    
	    // retrieve financial data for inclusion in e-mail
	    $rulesApplied = array();
	    $basePriceForThisGuy = 0;
	    $priceRules = array();
	    $scholarships = array();
	    $cash_paid = 0;
	    $cash_owed = 0;
	    $cc_paid = 0;
	    $cc_owed = 0;
	    
	    $balance_owing = $financeGetter->calcBalanceOwing( $this->reg_id, $rulesApplied, $basePriceForThisGuy, $priceRules, $scholarships, $cash_paid, $cash_owed, $cc_paid, $cc_owed);	  		
	    $eventBasePrice = $this->getEventBasePrice($this->event_id);
	    
	    if (isset($emailInfo)&&(count($emailInfo) == $INFO_FIELDS_TOTAL))
	    {
	    
	// 	    $confirmationLabels = new MultiLingual_Labels( SITE_LABEL_PAGE_GENERAL, SITE_LABEL_SERIES_SITE, TEMPLATE_SIGNUP_CONFIRMATION, $langID );
	       $to = $emailInfo['email'];
	       $subject = $this->labels->getLabel('[Subject]');
	       
	       // HACK for french and eastern WC
	       $headers = '';
	       $htmlBreak = '';
	       $message = '';
	                       
	       // To send HTML mail, the Content-type header must be set
	       if ( $appendHTML == true )
	       {
	           ;
	           $headers .= 'MIME-Version: 1.0' . "\r\n";
	           $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	           $htmlBreak = '<br/>';
	           
	           $message .= '<html><body>';	           	           
	       }
	       
	       // Create the message
	
	       $message .= $this->labels->getLabel('[ThankYou]')." ". $emailInfo['event_name'] ."\n" . $htmlBreak;
	       $message .= $this->labels->getLabel('[ConfirmationNumber]').': ' . $emailInfo['confirmNum'] . "\n" . $htmlBreak;
	       $message .= $this->labels->getLabel('[fName]').': ' . $emailInfo['person_fname']. "\n" . $htmlBreak;
	       $message .= $this->labels->getLabel('[lName]').': ' . $emailInfo['person_lname']. "\n" . $htmlBreak;
	       $message .= $this->labels->getLabel('[campus]').': ' . $emailInfo['campus_name']. "\n" . $htmlBreak;
	       
	       $message .= "\n" . $htmlBreak;
	       $message .= "---- ".$this->labels->getLabel('[FinanceInfo]')." ----\n" . $htmlBreak;
	       $message .= "\n" . $htmlBreak;	 
	       
          // event base price
	       $message .= $this->labels->getLabel('[eventBasePrice]')."  ";	             
	       $message .= '$'.$emailInfo['event_basePrice']."\n" . $htmlBreak;          
          
          // first print out the rules the computer has applied
          foreach( $rulesApplied as $key=>$ruleApplied )
          {
              $message .= $ruleApplied['pricerules_desc'] .':  '.$ruleApplied['pricerules_discount']. "\n" . $htmlBreak;   
          }      
          $message .= "\n" . $htmlBreak;    
          
          // Total of above base price + discounts
	       $message .= $this->labels->getLabel('[BasePriceForYou]')."  ";	             
	       $message .= '$'.$basePriceForThisGuy."\n" . $htmlBreak;   
	       $message .= "\n" . $htmlBreak;   
	       
          //  print out the scholarships for the registrant
          if ((isset($scholarships)&&(count($scholarships) > 0)))
          {
          	$message .= $this->labels->getLabel('[ScholarshipsInfo]'). ": \n" . $htmlBreak;
       	 }
          foreach( $scholarships as $key=>$scholarship )
          {
              $message .= '$'.$scholarship['scholarship_amount'] .' from: '.$scholarship['scholarship_sourceDesc']. "\n" . $htmlBreak;   
          }      
          $message .= "\n" . $htmlBreak;   	                
	       
	       // cash and credit card transaction information
	       $message .= $this->labels->getLabel('[cashReceived]')."  ";	             
	       $message .= '$'.$cash_paid."  \t\t";			// "\n" . $htmlBreak;
	       $message .= $this->labels->getLabel('[cashNotReceived]')."  ";	             
	       $message .= '$'.$cash_owed. "\n" . $htmlBreak;
	       $message .= "\n" . $htmlBreak;
	       	       
	       $message .= $this->labels->getLabel('[ccProcessed]')."  ";	             
	       $message .= '$'.$cc_paid."  \t\t";			// "\n" . $htmlBreak;
	       $message .= $this->labels->getLabel('[ccNotProcessed]')."  ";	             
	       $message .= '$'.$cc_owed. "\n" . $htmlBreak;
	       $message .= "\n" . $htmlBreak;
	       
	       $message .= $this->labels->getLabel('[BalanceOwing]')."  ";	 
	       
	       if (substr($balance_owing,0,1)=='-')
	       {
	       	$message .= "-$".substr($balance_owing,1). "\n" . $htmlBreak;	
       	 }
       	 else 
       	 {           	       
	       	$message .= "$".$balance_owing. "\n" . $htmlBreak;	
       	 }	       	   
       	     
	       $message .= "\n" . $htmlBreak;
	       $message .= "---- ".$this->labels->getLabel('[ImpInfo]')." ----\n" . $htmlBreak;
	       $message .= "\n" . $htmlBreak;
	       
	       // event admin specific:  event confirmation text
	       $message .= $emailInfo['confirm_text'];
	
	       $message .= "\n" . $htmlBreak;
	       $message .= "-------------------------------\n" . $htmlBreak;
	       $message .= "\n" . $htmlBreak;
	       $message .= "\n" . $htmlBreak;
	       
	       
	       // check if proper event e-mail address was found, if NOT then use default address
	       $event_email = $emailInfo['event_email'];
         if(!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $event_email) )
         {
            // echo "The e-mail was not valid";
            $isValid = false;
				$event_email = page_EditCampusRegistrations::DEFAULT_EMAIL;
         } 	       
	       
	       $message .= $this->labels->getLabel('[footer]'). $event_email . "\n" . $htmlBreak;
	        
	       // add the end tags
	       if ( $appendHTML )
	       {
	           $message .= "</body></html>";
	       }
	       
	       $message = wordwrap($message, 70);



	       
	
	       $headers .= 'From: '.$event_email . "\n" .
	       	'Bcc: '.$emailInfo['adminEmail'] . "\n" .
				'Reply-To: '.$event_email . "\n" .
				'X-Mailer: PHP/' . phpversion();

// 				echo "<BR>HEADERS: ".$headers;								
// 				echo "TO: ".$to;
// 				echo "<br>SUBJECT: ".$subject;
// 				echo "<BR>MESSAGE: ".$message;

			 ini_set('SMTP', EMAIL_SMTP_SERVER);
			 ini_set('smtp_port', EMAIL_SMTP_PORT);
	
	       $success = mail( $to, $subject, $message, $headers  );
	       if ( !$success )
	       {
	           return 'Error Sending Confirmation E-mail!';		// TODO: replace with a label
	       }    	
	       else
	       {
		        return 'Confirmation E-mail Successfully Sent';	// TODO: replace with a label
	        }   
        }
        else	// could not get confirmation info
        {
	        return 'Error Retrieving Confirmation Information: E-mail *Not* Sent!';	// TODO: replace with a label
        }
    }
    
    
     // set confirmation e-mail address and info by retrieving from the database (using registration ID)
     // @return [ARRAY] an array of email, event_name, confirm_text, event_basePrice, confirmNum, person_fname, person_lname, campus_name, and adminEmail
    protected function getConfirmEmailInfo($regID)
     {
	     $infoArray = array();
	     
	     $email = '';
	     $admEmail = '';
	     $confirmNum = '';
	     $person_fname = '';
	     $person_lname = '';
	     $campus_name = '';
	     $event_name = '';
	     $confirm_text = '';
	     
			// determine if parameter has been set
			if (isset($regID))
			{	     
				
				// get admin's e-mail
			  $viewers = new RowManager_ViewerManager();
			  $viewers->setID($this->viewer->getViewerID());
			  $view_person = new RowManager_AccessManager();
			  $person = new RowManager_PersonManager();
			  
			  $viewerInfo = new MultiTableManager();
			  $viewerInfo->addRowManager($viewers); 
	        $viewerInfo->addRowManager($view_person, new JoinPair( $viewers->getJoinOnViewerID(), $view_person->getJoinOnViewerID()));
	        $viewerInfo->addRowManager($person, new JoinPair( $person->getJoinOnPersonID(), $view_person->getJoinOnPersonID()));
	        
	        $personInfoList = $viewerInfo->getListIterator( );
	        $personInfoArray = $personInfoList->getDataList();		
	//        echo "<pre>".print_r($personInfoArray,true)."</pre>"; 
	          
				$person_id = '';
	         reset($personInfoArray);
	        	foreach(array_keys($personInfoArray) as $k)
				{
					$record = current($personInfoArray);	
					$admEmail = $record['person_email'];	// NOTE: should only be one person per viewer ID (ENFORCE??)
					
					next($personInfoArray);	
				}
				
				$infoArray['adminEmail'] = $admEmail;
				
				
				// get registration info for in confirmation e-mail (and get registrant's e-mail address)	        	
	        $regs = new RowManager_RegistrationManager();
	        $regs->setRegID($regID);
	        $people = new RowManager_PersonManager();
	        $assign = new RowManager_AssignmentsManager();
	        $campus = new RowManager_CampusManager;
	        $event = new RowManager_EventManager;
	        
	        $personRegs = new MultiTableManager();
	        $personRegs->addRowManager($people);
	        $personRegs->addRowManager($regs, new JoinPair( $regs->getJoinOnPersonID(), $people->getJoinOnPersonID()));
	        $personRegs->addRowManager($assign, new JoinPair ($people->getJoinOnPersonID(), $assign->getJoinOnPersonID()));
	        $personRegs->addRowManager($campus, new JoinPair ($assign->getJoinOnCampusID(), $campus->getJoinOnCampusID()));
	        $personRegs->addRowManager($event, new JoinPair ($regs->getJoinOnEventID(), $event->getJoinOnEventID()));
	        
	        $personList = $personRegs->getListIterator();
	        $personArray = $personList->getDataList();		
// 	        echo "<pre>".print_r($personArray,true)."</pre>"; 
	          
	         reset($personArray);
	        	foreach(array_keys($personArray) as $k)
				{
					$person = current($personArray);	
					$email = $person['person_email'];
					$person_fname = $person['person_fname'];	// NOTE: should only be one person per registration (ENFORCE??)
					$person_lname = $person['person_lname'];
					$campus_name = $person['campus_desc'];
					$confirmNum = $person['registration_confirmNum'];
					$event_name = $person['event_name'];
					$confirm_text = $person['event_emailConfirmText'];	
					$event_basePrice = $person['event_basePrice'];	
					$event_contactEmail = $person['event_contactEmail'];
					
					next($personArray);	
				}

				$infoArray['event_email'] = $event_contactEmail;
				$infoArray['email'] = $email;
				$infoArray['person_fname'] = $person_fname;
				$infoArray['person_lname'] = $person_lname;
				$infoArray['campus_name'] = $campus_name;
				$infoArray['confirmNum'] = $confirmNum;
				$infoArray['event_name'] = $event_name;
				$infoArray['confirm_text'] = $confirm_text;
				$infoArray['event_basePrice'] = $event_basePrice;
        } 
        
        return $infoArray;	//$email.','.$event_name.','.$confirmNum.','.$event_basePrice.','.$person_fname.','.$person_lname.','.$campus_desc.','.$admEmail;
     } 
    
     // set the registration status of the last offline reg. process based on info currently in database
     // @return [STRING] a CSV string of 'status|status_message'
     protected function setRegistrationStatus()
     {
	     $status_message = 'No registration created!';
	     
	     if ((isset($this->reg_id))&&($this->reg_id != ''))
	     {
		     // check cim_hrdb_person to determine if a person has been affiliated with registration
		     $regs = new RowManager_RegistrationManager();
		     $regs->setRegID($this->reg_id);
		     $person = new RowManager_PersonManager();
		     
		     $regCheck = new MultiTableManager();
		     $regCheck->addRowManager($regs);
		     $regCheck->addRowManager($person, new JoinPair($regs->getJoinOnPersonID(), $person->getJoinOnPersonID()));		
		     
		     $regsList = $regCheck->getListIterator();
		     $regsArray = $regsList->getDataList();
		     
		     
		     // variables to be used for later checks
		     $person_id = '';
		     $confirm_num = '';
		     $person_address = '';
		     $person_email = '';
		     $person_city = '';
		     $person_province = '0';
		     $person_pcode = '';
		     $person_phone = '';
		     
		     reset($regsArray);	// should be only one registration status (for 1 reg_id)
		     foreach (array_keys($regsArray) as $k)
		     {
			     $record = current($regsArray);
			     
			     $backup_event_id = $record['event_id'];
			     $person_id = $record['person_id'];
			     $confirm_num = $record['registration_confirmNum'];
			     
			     $person_email = $record['person_email'];
			     $person_address = $record['person_addr'];
			     $person_city = $record['person_city'];
			     $person_province = $record['province_id'];
			     $person_pcode = $record['person_pc'];
			     $person_phone = $record['person_phone'];

			     next($regsArray);
		     }		     	          
		     
		     // determine whether any person records were found for registration
		     if ((!isset($regsArray))||(count($regsArray)<1))
		     {
			     $this->storeRegStatus($this->reg_id, RowManager_StatusManager::INCOMPLETE);			     
			     $status_message = 'No person record associated with registration.';	// ASSUMPTION: set reg_id ==> created registration record
			     return RowManager_StatusManager::INCOMPLETE.'|'.$status_message;
		     }
		     else if (isset($regsArray) && (($person_email == '')||($person_address == '')||
		     ($person_city == '')||($person_province == '')||($person_province == '0')||($person_pcode == '')||($person_phone == '')))
		     {
			     $this->storeRegStatus($this->reg_id, RowManager_StatusManager::INCOMPLETE);
			     $status_message = '<br><br><table><tr><td><span class="notice">Please ensure that you have entered the following data: '
			     .'<br>name, e-mail address, permanent address, city, province, postal code, and phone number.</span></tr></td></table>';	
			     return RowManager_StatusManager::INCOMPLETE.'|'.$status_message;
		     }
		     
		     // check cim_hrdb_assignment to determine that the person has been assigned to a campus
		     $assign = new RowManager_AssignmentsManager();
		     $assign->setPersonID($person_id);
		     $status = new RowManager_CampusAssignmentStatusManager();
		     
		     $campusAssign = new MultiTableManager();
		     $campusAssign->addRowManager($assign);
		     $campusAssign->addRowManager($status, new JoinPair($assign->getJoinOnStatusID(), $status->getJoinOnStatusID()));
		     
		     $regsList = $campusAssign->getListIterator();
		     $regsArray = $regsList->getDataList();
		     
		     // variables to be used for later checks
		     $assignArray = array();
		     
		     reset($regsArray);	// should be only one campus assignment status (for now, later maybe not)
		     foreach (array_keys($regsArray) as $k)
		     {
			     $record = current($regsArray);
			     
			     if ($record['assignmentstatus_desc'] != RowManager_AssignmentsManager::UNKNOWN_STATUS)
			     {
			     		$assignArray[$record['campus_id']] = $record['assignmentstatus_desc'];
		     	  }
			     next($regsArray);
		     }		
		     
		     // determine whether a campus assignment exists for the found person linked to the registration
		     if ((!isset($assignArray))||(count($assignArray)<1))
		     {
			     $this->storeRegStatus($this->reg_id, RowManager_StatusManager::INCOMPLETE);
			     $status_message = "Registrant's campus status has not been recorded.";
			     return RowManager_StatusManager::INCOMPLETE.'|'.$status_message;
		     }
		     		     
		     // check cim_reg_fieldvalues to determine whether field values have been set for the registration
		     $fields = new RowManager_FieldManager();
		     $fields->setEventID($this->event_id);
		     $TRUE = 1;
		     $fields->setIsRequired($TRUE);
		     
		     $fieldsList = $fields->getListIterator();
		     $fieldsArray = $fieldsList->getDataList();

// 		     reset($fieldsArray);	// should be only one campus assignment status (for now, later maybe not)
// 		     foreach (array_keys($fieldsArray) as $k)
// 		     {
// 			     $record = current($fieldsArray);
// 			     
// 			     next($fieldsArray);
// 		     }		     
		     
		     
		     $fieldValues = new RowManager_FieldValueManager();
		     $fieldValues->setRegID($this->reg_id);
		     
		     $valuesList = $fieldValues->getListIterator();
		     $valuesArray = $valuesList->getDataList();

		     
// 		     reset($regsArray);	// should be only one campus assignment status (for now, later maybe not)
// 		     foreach (array_keys($regsArray) as $k)
// 		     {
// 			     $record = current($regsArray);
// 			     
// 			     $assignArray[$record['campus_id'] = $record['assignmentstatus_desc']
// 			     next($regsArray);
// 		     }	

				// ensure that the REQUIRED fields for an event all have a record for the particular registration
				if (count($valuesArray) < count($fieldsArray))
				{     
			      $this->storeRegStatus($this->reg_id, RowManager_StatusManager::INCOMPLETE);					
					$status_message = 'No event-specific field values were set for the registration.';
					return  RowManager_StatusManager::INCOMPLETE.'|'.$status_message;
				}
				
				
				// retrieve event deposit for later use
				$event = new RowManager_EventManager();
				$event->setEventID($this->event_id);
				
		     $eventsList = $event->getListIterator();
		     $eventsArray = $eventsList->getDataList();

		     $event_deposit = -1;
		     $event_basePrice = -1;
		     reset($eventsArray);	// should be only one event per event_id
		     foreach (array_keys($eventsArray) as $k)
		     {
			     $record = current($eventsArray);
			     $event_deposit = $record['event_deposit'];
			     
			     next($eventsArray);
		     }
		     
		     if ($event_deposit == -1)
		     {
			     $this->storeRegStatus($this->reg_id, RowManager_StatusManager::INCOMPLETE);			     
			     $status_message = 'Invalid event associated with registration.';
					return  RowManager_StatusManager::INCOMPLETE.'|'.$status_message;
			  }			     					
		     
		     
		     // check cim_reg_cashtransaction and cim_reg_cctransaction tables to determine if event deposit has been paid
		     $ccTransaction = new RowManager_CreditCardTransactionManager();
		     $ccTransaction->setRegID($this->reg_id);
		     
		     $ccTransList = $ccTransaction->getListIterator();
		     $ccTransArray = $ccTransList->getDataList();

		     $ccAmount = 0;
		     reset($ccTransArray);	
		     foreach (array_keys($ccTransArray) as $k)
		     {
			     $record = current($ccTransArray);
			     $ccAmount += $record['cctransaction_amount'];
			     
			     next($ccTransArray);
		     }		
		     
		     // check cash
		     $cashTransaction = new RowManager_CashTransactionManager();
		     $cashTransaction->setRegID($this->reg_id);
		     
		     $cashTransList = $cashTransaction->getListIterator();
		     $cashTransArray = $cashTransList->getDataList();

		     $cashAmount = 0;
		     reset($cashTransArray);
		     foreach (array_keys($cashTransArray) as $k)
		     {
			     $record = current($cashTransArray);
			     $cashAmount += $record['cashtransaction_amtPaid'];
			     
			     next($cashTransArray);
		     }		
		     
		     if ($ccAmount+$cashAmount < $event_deposit)
		     {
			     $this->storeRegStatus($this->reg_id, RowManager_StatusManager::INCOMPLETE);			     
			     $status_message = 'The event deposit of $'.$event_deposit.' has not been paid.';
					return  RowManager_StatusManager::INCOMPLETE.'|'.$status_message;
			  }				         	     
		     
		     
		     // check that confirmation # exists and is in proper format (check that format is 'E<event_id>R<reg_id>C<campus_id>')
		     $pattern = '(E'.$this->event_id.'R'.$this->reg_id.'C'.$this->campus_id.')';
		     if ((!isset($confirm_num))||(preg_match($pattern, $confirm_num) < 1))
		     {
			     $this->storeRegStatus($this->reg_id, RowManager_StatusManager::INCOMPLETE);			     
			     $status_message = 'The confirmation number has not been properly set.';
					return  RowManager_StatusManager::INCOMPLETE.'|'.$status_message;
			  }			     
			  
// 			  $status = new RowManager_StatusManager();
// 			  $status->setStatusDesc(RowManager_StatusManager::REGISTERED);
// 			  
// 		     $statusList = $status->getListIterator();
// 		     $statusArray = $statusList->getDataList();

// 		     $status_id = -1;
// 		     reset($statusArray);		// should be only 1 record for a particular status description
// 		     foreach (array_keys($statusArray) as $k)
// 		     {
// 			     $record = current($statusArray);
// 			     $status_id = $record['status_id'];
// 			     
// 			     next($statusArray);
// 		     }	
// 		     		
// 		     if ($status_id == -1)
// 		     {
// 			     $status_message = 'The registration status could not be properly set to REGISTERED.';
// 					return  RowManager_StatusManager::INCOMPLETE.'|'.$status_message;
// 			  }
// 			  			  
// 			  $updateValues = array();
// 			  $updateValues['registration_id'] = $this->reg_id;    
// 			  $updateValues['registration_status'] = $status_id;	// mark registration as being REGISTERED
//         
//             // Store values in RegistrationManager object
//             $regs->loadFromArray( $updateValues );
// //              echo "<pre>".print_r($this->formValues ,true)."</pre>";          
//             
//             // update information
//              $regs->updateDBTable();     

				 $success = $this->storeRegStatus($this->reg_id, RowManager_StatusManager::REGISTERED);
				 if ($success == false)
				 {
 		     		$status_message = 'The registration status could not be properly set to REGISTERED.';
 					return  RowManager_StatusManager::INCOMPLETE.'|'.$status_message;	
				 }
				 else
				 {				 		     
             	$status_message = '';
		       	return  RowManager_StatusManager::REGISTERED.'|'.$status_message;
	       	 }

	     }
	     else	// use default message if no registration ID was found
	     {
		     return RowManager_StatusManager::UNASSIGNED.'|'.$status_message;
	     }
     }
     
     // Update registration status in database
     // Pre-condition: $this->reg_id must initialized to a valid ID
     //
     // @param [STRING] a constant indicating the current status of the registration
     //							i.e. RowManager_StatusManager::REGISTERED
     // @return [BOOLEAN] whether or not the operation was a success
     protected function storeRegStatus($regID='', $reg_status)
     {
	     $success = true;
	     
	     if ($regID != '')
	     {
		     $regs = new RowManager_RegistrationManager();
			  $regs->setRegID($this->reg_id);
	     
			  $status = new RowManager_StatusManager();
			  $status->setStatusDesc($reg_status);
			  
		     $statusList = $status->getListIterator();
		     $statusArray = $statusList->getDataList();
	
		     $status_id = -1;
		     reset($statusArray);		// should be only 1 record for a particular status description
		     foreach (array_keys($statusArray) as $k)
		     {
			     $record = current($statusArray);
			     $status_id = $record['status_id'];
			     
			     next($statusArray);
		     }	
		     		
		     if ($status_id == -1)
		     {
					$success = false;
					return $sucess;
			  }
			  			  
			  $updateValues = array();
			  $updateValues['registration_id'] = $this->reg_id;    
			  $updateValues['registration_status'] = $status_id;	// mark registration as being REGISTERED
	     
	         // Store values in RegistrationManager object
	         $regs->loadFromArray( $updateValues );
	//              echo "<pre>".print_r($this->formValues ,true)."</pre>";          
	         
	         // update information
	          $regs->updateDBTable();  
	          
	          return $success;
          }
          else
          {
	          $success = false;
          }
     }     
     
     // retrieve base price for event
     // PRECONDITION: $eventID has been initialized as some non-negative valid event ID
     protected function getEventBasePrice($eventID)
     {
	     $event = new RowManager_EventManager();
	     $event->setEventID($eventID);
	     
	     $eventList = $event->getListIterator();
	     $eventArray = $eventList->getDataList();
	     
	     $eventBasePrice = 0;
	     reset($eventArray);
	     foreach (array_keys($eventArray) as $k) 
	     {
		     $record = current($eventArray);
		     $eventBasePrice = $record['event_basePrice'];	// should be only 1 base price for 1 event_id
		     next($eventArray);
	     }
	     
	     return $eventBasePrice;
     }
		     
}

?>