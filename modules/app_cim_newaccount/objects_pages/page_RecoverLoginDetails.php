<?php
/**
 * @package cim_newaccount
 */ 
/**
 * class FormProcessor_RecoverLoginDetails 
 * <pre> 
 * This is the page where the users can enter their email and their login info will be mailed to them.
 * </pre>
 * @author CIM
 * Date:   17 Apr 2006
 */
 // RAD Tools: FormSingleEntry Page
class  FormProcessor_RecoverLoginDetails extends PageDisplay_FormProcessor {

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
    const FORM_FIELDS = 'person_email|E|';
    
    /** The list of field types to be displayed in the form */
    // NOTE: if a field isn't displayed, put a '-' for it's entry.
    const FORM_FIELD_TYPES = 'textbox';
    
    /** The Multilingual Page Key for this page */
    const MULTILINGUAL_PAGE_KEY = 'FormProcessor_RecoverLoginDetails';

	//VARIABLES:
	
	/** @var [STRING] The path to the module's root directory. */
	protected $pathModuleRoot;
	
	/** @var [OBJECT] The Viewer Object. */
	protected $viewer;
		
    /** @var [STRING] The initialization data for the dataManager. */
	protected $person_id;
	
	 /** @var [BOOL] Keeps track of whether or not a password reset was preformed. */
	protected $passwordReset;
	
	 /** @var [BOOL] State variable that keeps track of whether or not a password reset was attempted. */
	protected $resetAttempted;
	
	/** @var [STRING] The email address of the person who wants their password reset. */
	protected $email;

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
	 * @param $person_id [INTEGER] Value used to initialize the dataManager
	 * @return [void]
	 */
    function __construct($pathModuleRoot, $viewer, $formAction, $person_id ) 
    {
        // NOTE: be sure to call the parent constructor before trying to 
        //       use the ->formXXX arrays...
        $fieldList = FormProcessor_RecoverLoginDetails::FORM_FIELDS;
        $fieldDisplayTypes = FormProcessor_RecoverLoginDetails::FORM_FIELD_TYPES;
        parent::__construct( $formAction, $fieldList, $fieldDisplayTypes  );

        $this->pathModuleRoot = $pathModuleRoot;
        $this->viewer = $viewer;

        $this->person_id = $person_id;
        
        $this->passwordReset = false;
        $this->resetAttempted = false;

        
        // figure out the important fields for the dataManager
        $fieldsOfInterest = implode(',', $this->formFields);
        
        $this->dataManager = new RowManager_PersonManager( $person_id );
        $this->dataManager->setFieldsOfInterest( $fieldsOfInterest );
        $this->formValues = $this->dataManager->getArrayOfValues();

        // now initialize the labels for this page
        // start by loading the default field labels for this Module
        $languageID = $viewer->getLanguageID();
        $seriesKey = modulecim_newaccount::MULTILINGUAL_SERIES_KEY;
        $pageKey = modulecim_newaccount::MULTILINGUAL_PAGE_FIELDS;
        $this->labels = new MultilingualManager( $languageID, $seriesKey, $pageKey );
        
        // then load the page specific labels for this page
        $pageKey = FormProcessor_RecoverLoginDetails::MULTILINGUAL_PAGE_KEY;
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
        // Get the email address from the form.
        $this->email = trim($this->formValues[ 'person_email' ]);
        // echo "Email [".$this->email."]<br/>";
        
        $this->resetAttempted = true;

         // look up to see if there are any viewers 
         // associated with each personID
         // 
         // note: just because there is an entry in the access table, does not
         // necessarily mean there is an entry in the viewer table, we perform
         // the join below to make sure there is an entry in all three of the
         // person, access and viewer tables and they are joined accordingly
         $personManager = new RowManager_PersonManager();
         $personManager->setEmail( $this->email );
         $accessManager = new RowManager_AccessManager();
         $viewerManager = new RowManager_ViewerManager();
         
         $multiTableManager = new MultiTableManager();
         $multiTableManager->addRowManager( $accessManager );
         $multiTableManager->addRowManager( $personManager, new JoinPair( $accessManager->getJoinOnPersonID(), $personManager->getJoinOnPersonID() ) );
         $multiTableManager->addRowManager( $viewerManager, new JoinPair( $accessManager->getJoinOnViewerID(), $viewerManager->getJoinOnViewerID() ) );
         
         $emailText = "";
         $accessList = new ListIterator( $multiTableManager );
         $accessList->setFirst();
         while ( $accessList->moveNext() )
         {
            $vManager = $accessList->getCurrent( new RowManager_ViewerManager() );
            $viewerID = $vManager->getID();
            
            $pManager = $accessList->getCurrent( new RowManager_PersonManager() );
            $personID = $pManager->getID();
            
            // reset, with a new (random) password
            $newPassword = $this->createRandomPassword();
            $vManager->setPassWord($newPassword);
            $vManager->updateDBTable();
            
            $userName = $vManager->getUserID();
            $emailText .= "Username: ". $vManager->getUserID(). "\n";
            $emailText .= "Password: ". $newPassword. "\n\n";
            
            $this->passwordReset = true;
            
            // echo "Found viewer-access-person table entry for viewerID[".$viewerID."] and viewer_userName[".$userName."] and personID[".$personID."] and email [".$this->email."] newPassword[".$newPassword."]<br/>";
         }
         
         // Send an email with the reset passwords
         if ( $this->passwordReset == true )        
         {
            $message =  "Hello ". $this->email .",\n\n";
            $message .= "Your Campus for Christ intranet passwords for the following usernames have been reset.  Please immediately login to the site and change your password to something you can remember.\n\n";
            // output the username/password combos that have been updated.
            $message .= $emailText;
            $message .= "If you continue to have difficulties with logging in, please contact our technical support at tech@campusforchrist.org.\n\n";
    
            $message = wordwrap($message, 70);
   
            $headers = 'From: C4C Tech Support <tech@campusforchrist.org>' . "\r\n" .
   'Reply-To: tech@campusforchrist.org' . "\r\n" .
   'X-Mailer: PHP/' . phpversion();
   
            // echo $message."<br/>";
            $success = mail( $this->email, "C4C Password Reset", $message, $headers  );
            if ( !$success )
            {
                echo 'Error Sending Mail!<br/>';
            }
            
            
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
         $path = "";
         if ( $this->passwordReset )
         {
            // use a custom template
            $path = $this->pathModuleRoot.'templates/';
         }
         else if ( $this->resetAttempted == true )
         {
            // use a custom template
            $path = $this->pathModuleRoot.'templates/';
         }
         else
         {
            // this is the first time through, display the form asking for 
            // the email
            // Otherwise use the standard Templates for the site:
            // Note: prepended two diretories since this file is not quite being run in the same way
            $path = "../../".SITE_PATH_TEMPLATES;
         }
        
        // store the page labels in XML format...
        // NOTE: use this location to update any label tags ...
        // $name = $user->getName();
        // $this->labels->setLabelTag( '[Title]', '[userName]', $name);
        
        // NOTE:  this parent method prepares the $this->template with the 
        // common Form data.  
        $this->prepareTemplate( $path );
                
        /*
         * Form related Template variables:
         */

        // store the button label
        $this->template->set( 'buttonText', $this->labels->getLabel('[Update]') );

        // Insert the date start/end values for the following date fields:
        // example:
            //$this->template->set( 'startYear_[fieldName]', 2000);
            //$this->template->set( 'endYear_[fieldName]', 2010);

        /*
         * Add any additional data required by the template here
         */
       
       // decide which template to display 
      if ( $this->passwordReset )
      {
         // a password reset has been done
         $templateName = "page_EmailSentSuccessfully.php";
         $this->template->set( 'emailSentSuccess', true );
         $this->template->set( 'emailAddress', $this->email );
      }
      else if ( $this->resetAttempted == true )
      {
         // a password reset was attempted, but the password could not
         // be reset for the given email
         $templateName = "page_EmailSentSuccessfully.php";
         $this->template->set( 'emailSentSuccess', false );
         $this->template->set( 'emailAddress', $this->email );
      }
      else
      {
         // this is the first time through, display the form asking for 
         // the email
         $templateName = 'siteFormSingle.php';
      }

		// uncomment this line if you are creating a template for this page
		// $templateName = 'page_NewPerson.php';
		// otherwise use the generic admin box template
		// $templateName = 'siteFormSingle.php';
		
		return $this->template->fetch( $templateName );
        
    }
    
    // http://www.totallyphp.co.uk/code/create_a_random_password.htm
    //
    /**
    * The letter l (lowercase L) and the number 1
    * have been removed, as they can be mistaken
    * for each other.
    */
   function createRandomPassword() {
   
       $chars = "abcdefghijkmnopqrstuvwxyz023456789";
       srand((double)microtime()*1000000);
       $i = 0;
       $pass = '' ;
   
       while ($i <= 7) {
           $num = rand() % 33;
           $tmp = substr($chars, $num, 1);
           $pass = $pass . $tmp;
           $i++;
       }
   
       return $pass;
   
   }
	
}

?>