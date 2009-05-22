<?php

// $fileName = 'Tools/tools_RetrieveCrossReferences.php';
// $path = Page::findPathExtension( $fileName );
// require_once( $path.$fileName);


/**
 * @package cim_reg
 */ 
/**
 * class FormProcessor_EmailComposer 
 * <pre> 
 * Allows a person to compoose an e-mail
 * </pre>
 * @author CIM Team
 * Date:   30 Jan 2008
 */
 // RAD Tools: FormSingleEntry Page
class  FormProcessor_EmailComposer extends PageDisplay_FormProcessor {

	//CONSTANTS:	
	const COMBO_BOX_SIZE = 15;
	
	const ALL_CAMPUS_REGISTRANTS = 0;
	const COMPLETE_CAMPUS_REGISTRANTS = 1;
	const INCOMPLETE_CAMPUS_REGISTRANTS = 2;
	const CANCELLED_CAMPUS_REGISTRANTS = 3;
	const MALE_CAMPUS_REGISTRANTS = 4;
	const FEMALE_CAMPUS_REGISTRANTS = 5;
// 	const ALL_CAMPUS_MEMBERS = 6;
	const CUSTOM_CAMPUS_REGISTRANTS = 6;		// MEMBERS
	
	const DEFAULT_RECIPIENTS = 0;	//FormProcessor_EmailComposer::ALL_CAMPUS_REGISTRANTS;

	
	/** The list of form fields for this page */
	// NOTE: the format for this list is:
	//
	//         form_field_name|form_field_type|invalid_value
	//
	//             form_field_name = the name for the form field.  generally 
	//                               it is named the same as the table column 
	//                               of the data it represents
	//
	//             form_field_type = the type of form field
    //                               T = Text / String
    //                               N = Numeric 
    //                               B = Boolean
    //                               D = Date ( 3 lists boxes day/mon/year)
    //                            Time = Time ( 3 list boxes  HH/MM/Am )
    //                        DateTime = Date + Time pickers ...
    //
    //             invalid_value = A value that is considered incorrect for this
    //                             form field.  Leaving it blank is equivalent 
    //                             to form_value != ''.  If a variable is able
    //                             to be left empty ('') then put the keyword
    //                             '<skip>' for this value. 
    const FORM_FIELDS = 'from_email|T|,to_email|T|,email_subject|T|,email_body|T|';
    
    /** The list of field types to be displayed in the form */
    // NOTE: if a field isn't displayed, put a '-' for it's entry.
    const FORM_FIELD_TYPES = 'textbox|40|50,jumplist,textbox|70|70,textarea|70|10';
    
    /** The Multilingual Page Key for this page */
    const MULTILINGUAL_PAGE_KEY = 'FormProcessor_EmailComposer';
    
    // HERE THE INITIAL REG. STATUS IS SET
    const INITIAL_REG_STATUS = 'Incomplete';

	//VARIABLES:
	
	/** @var [ARRAY] The "To:" e-mail address options. */
	protected $TO_ADDRESS_OPTIONS;
	
	/** @var [STRING] The path to the module's root directory. */
	protected $pathModuleRoot;
	
	/** @var [OBJECT] The Viewer Object. */
	protected $viewer;
		
    /** @var [ARRAY] The form parameters sent previously. */
//  	protected $email_params;
	
    /** @var [INTEGER] The initialization data for the dataManager. */
	protected $event_id;	
	
    /** @var [INTEGER] The initialization data for the dataManager. */
	protected $campus_id;		

    /** @var [INTEGER] The previous "TO" e-mail choice */
	protected $to_email_choice;	
	
    /** @var [STRING] The base of each "TO" value (i.e. jump-link) */
	protected $base_opt_value;			
	
    /** @var [STRING] The type of e-mail composition page required */
// 	protected $page_type;		
	
	/** @var [REFERENCE] A reference to the controller object (app_cim_reg) */
//	protected $controller;	


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
	 * @param $event_id [INTEGER] Value used to initialize the dataManager
	 * @return [void]
	 */
    function __construct($pathModuleRoot, $viewer, $formAction, $event_id, $campus_id = '', $to_email_opt = '', $base_opt_value = '') 	// $email_params = '', 
    {
        // NOTE: be sure to call the parent constructor before trying to 
        //       use the ->formXXX arrays...
        
//         $this->person_id = $person_id;
        $this->event_id = $event_id;		
        $this->campus_id = $campus_id;
        
        if ($to_email_opt == '')
        {
	        $this->to_email_choice = FormProcessor_EmailComposer::DEFAULT_RECIPIENTS;
        }
        else
        {
        	  $this->to_email_choice = $to_email_opt;
     	  }
     	  $this->base_opt_value = $base_opt_value;
                
        $this->viewer = $viewer;

//         if ((!isset($person_id))||($person_id == ''))
//         {
// 	        $this->person_id = $this->getPersonIDfromViewerID();
// 	        $formAction .= '&'.modulecim_reg::PERSON_ID.'='.$this->person_id;
//         }
        
//         if (($isInRegProcess == true)&&($registration_id == ''))
//         {
// 	         $this->setRegistrationID();	// get registration ID for the rest of the process	         
//         		$formAction .= '&'.modulecim_reg::REG_ID.'='.$this->registration_id;

//         		// also note that person_id is set above if it is also not set yet
//         		if ($person_id == -1) 
//         		{
// 	        		// pass on new person_id to GET parameters
// 	        		$formAction = str_replace( modulecim_reg::PERSON_ID.'=-1', modulecim_reg::PERSON_ID.'='.$this->person_id, $formAction);
//         		}
// 	        		        		
//      	  }
     	  
     	  
        $fieldList = FormProcessor_EmailComposer::FORM_FIELDS;
        $fieldDisplayTypes = FormProcessor_EmailComposer::FORM_FIELD_TYPES;
        parent::__construct( $formAction, $fieldList, $fieldDisplayTypes  );

        $this->pathModuleRoot = $pathModuleRoot;
        
        // if ($this->pageType == FormProcessor_EmailComposer::CAMPUS_EMAIL)
        if ($this->campus_id != '')		// if the campus id has been set, then restrict e-mail recipients to the campus
        {
	  	     $this->TO_ADDRESS_OPTIONS = array('0'=>'All Campus Registrants', '1'=>'Campus Registrants - Completed', 
	 											'2'=>'Campus Registrants - Incomplete', '3'=>'Campus Registrants - Cancelled', 
	 											'4'=>'Campus Registrants - Males','5'=>'Campus Registrants - Females', 
	 											'6'=>'Custom List of Campus Registrants...');		//, '6'=>'All Campus Club Students'
		  }
 		  else	// allow all event registrants to be e-mailed
 		  {									
	  	     $this->TO_ADDRESS_OPTIONS = array('0'=>'All Event Registrants', '1'=>'Event Registrants - Completed', 
	 											'2'=>'Event Registrants - Incomplete', '3'=>'Event Registrants - Cancelled', 
	 											'4'=>'Event Registrants - Males','5'=>'Event Registrants - Females', 
	 											'6'=>'Custom List of Event Registrants...'); 
 		  }											


// To make sure this is not exploited to edit any other person's id.
// If the user has no privileges, this sets the viewer id to be his/her own,
// even if the variable given to it is not the viewer's person id.
// NOTE: anyone with higher previliges can edit any person's info, by simply
// changing the posted variable value.			// NOTE: this code was causing problems in app_cim_reg module

        // Now load the access Priviledge manager of this viewer
//         $this->accessPrivManager = new RowManager_AdminManager( );

//         // Get the person ID
//         $accessManager = new RowManager_AccessManager( );
//         $accessManager->loadByViewerID( $this->viewer->getViewerID( ) );
//         $personID = $accessManager->getPersonID();

//         // Get the permissions the person has.
//         $this->accessPrivManager->loadByPersonID( $personID );

//         if ( !$this->accessPrivManager->isLoaded() ) {
//           $this->person_id=$personID;
// /        }
//End of check.
        
        // figure out the important fields for the dataManager
 //       $fieldsOfInterest = implode(',', $this->formFields);
        
        $this->dataManager = new MultiTableManager();
        $persons = new RowManager_PersonManager( );		//$this->person_id
        $registrations = new RowManager_RegistrationManager(); 
        $registrations->setEventID($this->event_id);
        $this->dataManager->addRowManager($persons);
        $this->dataManager->addRowManager( $registrations, new JoinPair( $persons->getJoinOnPersonID(), $registrations->getJoinOnPersonID())); 
        
        if ($this->campus_id != '')
        {
	        $assignments = new RowManager_AssignmentsManager();
	        $assignments->setCampusID($this->campus_id);
        	  $this->dataManager->addRowManager($assignments, new JoinPair( $assignments->getJoinOnPersonID(), $persons->getJoinOnPersonID()));
     	  }
	     $this->dataManager->setSortOrder('person_lname,person_fname');   

        
 //       $this->dataManager->setFieldsOfInterest( $fieldsOfInterest );
        $this->formValues = $this->dataManager->getArrayOfValues();
			// echo "form values:<br><pre>".print_r($this->formValues,true)."</pre>";   
			
// 			$eventInfo = new RowManager_EventManager($this->event_id);
// 			$event_email = $eventInfo->getEventEmail();
// 			echo $event_email;			
			$this->formValues['from_email'] = $this->getPersonEmailfromViewerID();
  			$this->formValues['to_email'] = $this->base_opt_value.$this->to_email_choice;		// set jumplist SELECTED value
// 			$this->formValues['email_subject'] = $campus_name.' - '.$event_name.' Notice';


        // now initialize the labels for this page
        // start by loading the default field labels for this Module
        $languageID = $viewer->getLanguageID();
        $seriesKey = modulecim_reg::MULTILINGUAL_SERIES_KEY;
        $pageKey = modulecim_reg::MULTILINGUAL_PAGE_FIELDS;
        $this->labels = new MultilingualManager( $languageID, $seriesKey, $pageKey );
        
        // then load the page specific labels for this page
        $pageKey = FormProcessor_EmailComposer::MULTILINGUAL_PAGE_KEY;
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
        // save the value of the Foriegn Key(s)
        /*[RAD_ADMINBOX_FOREIGNKEY]*/	 
        


// 		$sender_name = 'NAME';
		$sender_email = $_POST['from_email'];


		$contacts_array = $_POST['email_contacts'];
		$recipients = '';	// CSV list to be populated
// 		echo '<pre>'.print_r($contacts_array,true).'</pre>';
		foreach (array_keys($contacts_array, true) as $key)
		{
			$record = current($contacts_array);
			$recipients .= $record.',';
			next($contacts_array);
		}
		$recipients = substr($recipients,0,-1);	// remove last comma	

// 		$recipients = 'hobbesmit@hotmail.com,hobbesmit@gmail.com';
		$subject = $_POST['email_subject'];
		$email_body = $_POST['email_body'];
		
// 		echo 'selected = <pre>'.print_r($_POST['email_contacts'],true).'</pre>';
		 
		$this->sendEmail('', $sender_email, $recipients, $subject, $email_body);	
        
        
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
        $path = $this->pathModuleRoot.'templates/';
        // Otherwise use the standard Templates for the site:
//         $path = SITE_PATH_TEMPLATES;
        
        
        
        // store the page labels in XML format...
        // NOTE: use this location to update any label tags ...
        // $name = $user->getName();
        // $this->labels->setLabelTag( '[Title]', '[userName]', $name);
        $this->linkLabels[ 'back' ] = $this->labels->getLabel( '[Back]' );

        
        
        // NOTE:  this parent method prepares the $this->template with the 
        // common Form data.  
        $this->prepareTemplate( $path );
        
        
        /** Default "From:" e-mail address is that of the viewer/admin **/
        $this->formValues['from_email'] = $this->getPersonEmailfromViewerID();
                
        // Retrieve names and e-mail addresses of registrants (all/per-campus)
		  $data_iterator = $this->dataManager->getListIterator();
		  $data_array = $data_iterator->getDataList();
		  
		  $email_contacts = array();
		  reset($data_array);
		  foreach (array_keys($data_array) as $k)
		  {
			  $record = current($data_array);
// 			  $person_id = $record['person_id'];	
			  $person_name = $record['person_lname'].', '.$record['person_fname'];
			  $person_email = $record['person_email'];
			  
			  $reg_status = $record['registration_status'];
			  $gender = $record['gender_id'];
			  
			  $index = $person_email;	// default index is id of person 
			  if ($this->isSelectedContact($reg_status, $gender))	// determine if e-mail contact is SELECTED
			  {
				  $index = '*'.$index;		// add modifier to indicated SELECTED status
			  }
				  
			  $email_contacts[$index] = $person_name;	//.'<BR>('.$person_email.')';  <BR> doesnt work in listbox
			  next($data_array);
		  }
		  
// 		  echo ' contacts = <pre>'.print_r($email_contacts,true).'</pre>';
		  
		  $this->template->set( 'inclComboInstructions', true );
		  $this->template->set( 'comboBoxName','email_contacts[]'); 
		  $this->template->set( 'comboBoxSize',FormProcessor_EmailComposer::COMBO_BOX_SIZE); 
		  $this->template->set( 'comboDataArray',$email_contacts); 
        
        
        /*
         * Form related Template variables:
         */
        
        // store the button label
        $this->template->set( 'buttonText', $this->labels->getLabel('[SendMessage]') );
        


        // Insert the date start/end values for the following date fields:
        // example:
            //$this->template->set( 'startYear_[fieldName]', 2000);
            //$this->template->set( 'endYear_[fieldName]', 2010);

                


        /*
         * Add any additional data required by the template here
         */
         
        // now add the data for the Campus Group JumpList
        $jumpLink = $this->linkValues['jumpLink'];
        $jumpList = array();
//         if ( $this->adminManager->hasSitePriv() )
//         {
//             $jumpList[ $jumpLink.page_PeoplebyCampuses::DISPLAY_ALL_ID ] = 'Show All';
//         }
        foreach( $this->TO_ADDRESS_OPTIONS as $key=>$value) {
            $jumpList[ $jumpLink.$key ] = $value;
        }
        $this->template->set( 'list_to_email', $jumpList  );		//jumpList
        // echo '<pre>'.print_r($jumpList,true).'</pre>';
        // echo 'jumpLink['.$jumpLink.']<br/>';
//         $this->template->set( 'defaultOption', $jumpLink.$this->to_email_choice);	//FormProcessor_EmailComposer::DEFAULT_RECIPIENTS );
  
//         $this->template->set( 'list_to_email', $this->TO_ADDRESS_OPTIONS ); 


		// uncomment this line if you are creating a template for this page
		$templateName = 'page_EmailComposer.tpl.php';
		// otherwise use the generic admin box template
// 		$templateName = 'siteFormSingle.php';
		
		return $this->template->fetch( $templateName );
        
    }

	
          
    // self-explanatory: system user == person whose e-mail address we use as "From:" address
    protected function getPersonEmailfromViewerID()
    {
       $personEmailInfo = new MultiTableManager();
       $personInfo = new RowManager_PersonManager();
       $accessPriv = new RowManager_AccessManager();
       $accessPriv->setViewerID($this->viewer->getID());
       
       $personEmailInfo->addRowManager($personInfo);
       $personEmailInfo->addRowManager($accessPriv, new JoinPair( $personInfo->getJoinOnPersonID(), $accessPriv->getJoinOnPersonID()));
       
       $personEmailList = $personEmailInfo->getListIterator();
       $personEmailArray = $personEmailList->getDataList();
       
       $personID = '';
       reset($personEmailArray);
       foreach (array_keys($personEmailArray) as $k)
       {
       	$record = current($personEmailArray);
       	$personID = $record['person_id'];	// can only be 1 person_id per viewer_id
       	$personEmail = $record['person_email'];
       	next($personEmailArray);
    	 }
       
       return $personEmail;
    }

    // Returns the correct list of e-mail recipients given the drop-list option
//     protected getRecipients($receivers_option)
//     {
// 	    // switch on the drop-list option
// 	    switch ($receivers_option)
// 	    {
// 			case $this->TO_ADDRESS_OPTIONS[
// 0'=>'All Campus Registrants', '1'=>'Campus Registrants - Completed', 
//  											'2'=>'Campus Registrants - Incomplete', '3'=>'Campus Registrants - Cancelled', 
//  											'4'=>'Campus Registrants - Males','5'=>'Campus Registrants - Females', '6'=>'All Campus Club Students', 
//  											'7'=>'Custom List of Campus Students...';
// 	}		    
		    		    
          
    // sends CC transaction confirmation e-mail off to certain HQ folks
    protected function sendEmail($sender_name = '', $sender_email = '', $recipients = '', $subject = '', $msgTxt = '')		
    {
	    if (($sender_email != '')&&($recipients != '')&&($subject != '')&&($msgTxt != ''))
	    {
		    
		    // retrieve basic confirmation e-mail info.
		    $RECIPIENTS = $recipients;
		    $SUBJECT = stripslashes($subject);
		    
		    if ($sender_name == '')
		    {
			    $sender_name = 'C4C Registration System';
		    }
			 $FROM_NAME = $sender_name;
		    $FROM_ADDRESS = $sender_email;
		    
		    $success = false;
		    
		    if ($msgTxt != '')
		    {
	// 		     $message = '<html>';
	// 		     $message .= '<body>';	   
	//        	  $message .= $msgTxt;  
	//        	  $message .= "</body></html>";                    
	
	// 	        $headers = 'MIME-Version: 1.0' . "\r\n";
	// 	        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	// 	        $htmlBreak = '<br/>';  
				 $message = $msgTxt;   	           
		       
		       $message = wordwrap($message, 70);
		       $message = stripslashes($message);       
	// 	
	// 	       $headers .= 'From: '.$FROM . "\n" .
	// 				'Reply-To: '.$FROM . "\n" .
	// 				'X-Mailer: PHP/' . phpversion();
	
				 $headers = "From: ".$FROM_NAME." <".$FROM_ADDRESS.">\n" .
				 				"Bcc: ".$RECIPIENTS."\n" .
						      "MIME-Version: 1.0\n" .
						      "Content-type: text/html; charset=iso-8859-1\n" .
						      'X-Mailer: PHP/' . phpversion();
		
		// 				echo "<BR>HEADERS: ".$headers;								
		// 				echo "TO: ".$to;
		// 				echo "<br>SUBJECT: ".$subject;
		// 				echo "<BR>MESSAGE: ".$message;
		
				 ini_set('SMTP', EMAIL_SMTP_SERVER);
				 ini_set('smtp_port', EMAIL_SMTP_PORT);
		
				 // to (same as from because using BCC), subject, message, headers
		       $success = mail( $FROM_ADDRESS, $SUBJECT, $message, $headers  );		
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
        else		// some parameters missing
        {
           return 'Error Sending Confirmation E-mail!';		// TODO: replace with a label
        }

    }
    
    /**
     * Retrieve e-mail recipients based on "To" option chosen
     */           
//     protected function getRecipients($option_parts[1]);
    
    		// if ($this->pageType == FormProcessor_EmailComposer::CAMPUS_EMAIL)      
    		

	
	
	/**
	 * Determine if e-mail contact in combo-box should be SELECTED
	 *
	 * @return   [BOOLEAN]  Whether or not the contact should be set to SELECTED
	 */
	protected function isSelectedContact($reg_status, $gender)
	{
		switch($this->to_email_choice)
		{
			case FormProcessor_EmailComposer::ALL_CAMPUS_REGISTRANTS:
				return true;		// since we should have already filtered by campus
				break;
				
			case FormProcessor_EmailComposer::COMPLETE_CAMPUS_REGISTRANTS:
			
				if ($reg_status == RowManager_RegistrationManager::STATUS_REGISTERED)
				{
					return true;
				}
				return false;
				break;
				
			case FormProcessor_EmailComposer::INCOMPLETE_CAMPUS_REGISTRANTS:
			
				if (($reg_status == RowManager_RegistrationManager::STATUS_INCOMPLETE)||
				($reg_status == RowManager_RegistrationManager::STATUS_UNASSIGNED))
				{
					return true;
				}
				return false;
				break;				
	
			case FormProcessor_EmailComposer::CANCELLED_CAMPUS_REGISTRANTS:
			
				if ($reg_status == RowManager_RegistrationManager::STATUS_CANCELLED)
				{
					return true;
				}
				return false;
				break;	
				
			case FormProcessor_EmailComposer::MALE_CAMPUS_REGISTRANTS:
			
				if ($gender == RowManager_GenderManager::MALE)	//||($gender == RowManager_GenderManager::UKNOWN))
				{
					return true;
				}
				return false;
				break;	
				
			case FormProcessor_EmailComposer::FEMALE_CAMPUS_REGISTRANTS:
			
				if ($gender == RowManager_GenderManager::FEMALE)	//||($gender == RowManager_GenderManager::UKNOWN))
				{
					return true;
				}
				return false;
				break;	
				
// 			case FormProcessor_EmailComposer::ALL_CAMPUS_MEMBERS:
// 			
// 				return true;
// 				break;			
				
			case FormProcessor_EmailComposer::CUSTOM_CAMPUS_REGISTRANTS	:
			default:
			
				return false;		// we want the user to select his/her own contacts to send e-mail to
		}
	}
			
													   	          
}

?>