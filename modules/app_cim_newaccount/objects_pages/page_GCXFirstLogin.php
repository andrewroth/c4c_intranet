<?php
/**
 * @package cim_newaccount
 */ 
/**
 * class FormProcessor_GCXFirstLogin
* <pre> 
 * This page is used to add a new person to the system.
 * </pre>
 * @author CIM
 * Date:   15 Apr 2006
 */
 // RAD Tools: FormSingleEntry Page
class  FormProcessor_GCXFirstLogin extends PageDisplay_FormProcessor {

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
    const FORM_FIELDS = 'viewer_userID|T|,viewer_passWord|T|';

    /** The list of field types to be displayed in the form */
    // NOTE: if a field isn't displayed, put a '-' for it's entry.
    const FORM_FIELD_TYPES = 'textbox,password';
    
    /** The Multilingual Page Key for this page */
    const MULTILINGUAL_PAGE_KEY = 'FormProcessor_GCXFirstLogin';

	//VARIABLES:
	
	/** @var [STRING] The path to the module's root directory. */
	protected $pathModuleRoot;
	
	/** @var [OBJECT] The Viewer Object. */
	protected $viewer;
			



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
	 * @param $guid [STRING] GUID passed from login page
	 * @return [void]
	 */
    function __construct($pathModuleRoot, $viewer, $formAction, $guid ) 
    {
        // NOTE: be sure to call the parent constructor before trying to 
        //       use the ->formXXX arrays...
        $fieldList = FormProcessor_GCXFirstLogin::FORM_FIELDS;
        $fieldDisplayTypes = FormProcessor_GCXFirstLogin::FORM_FIELD_TYPES;
        parent::__construct( $formAction, $fieldList, $fieldDisplayTypes  );

        $this->pathModuleRoot = $pathModuleRoot;
        $this->viewer = $viewer;
        $this->guid = $guid;



        
        // figure out the important fields for the dataManager
        $fieldsOfInterest = implode(',', $this->formFields);

        $this->dataManager = new RowManager_ViewerManager();
        $this->dataManager->setFieldsOfInterest( $fieldsOfInterest );
        $this->formValues = $this->dataManager->getArrayOfValues();

        // now initialize the labels for this page
        // start by loading the default field labels for this Module
        $languageID = $viewer->getLanguageID();
        $seriesKey = modulecim_newaccount::MULTILINGUAL_SERIES_KEY;
        $pageKey = modulecim_newaccount::MULTILINGUAL_PAGE_FIELDS;
        $this->labels = new MultilingualManager( $languageID, $seriesKey, $pageKey );
        
        // then load the page specific labels for this page
        $pageKey = FormProcessor_GCXFirstLogin::MULTILINGUAL_PAGE_KEY;
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

      if ( $isValid ) {
/*	        
            // check to make sure the user id doesn't already exist
            $userID = $this->formValues[ 'person_email' ];
            $viewerManager = new RowManager_ViewerManager();
            $viewerManager->loadByUserID( $userID );
            if ( $viewerManager->isLoaded() ) {
                // this user already exists
                $isValid = false;
                $this->formErrors[ 'person_email' ] = $this->labels->getLabel( '[error_uniqueUserID]');
            }	        
*/	        
	        // check to ensure that person does already have an account
	              
	               $userID = $this->formValues[ 'viewer_userID' ];
	               $PWord = $this->formValues[ 'viewer_passWord' ];
	   
/*	        $viewerData = new RowManager_ViewerManager();        
	        $accessData = new RowManager_AccessManager();	        
	        $personData = new RowManager_PersonManager();
	        $personData->setFirstName($fname);
	        $personData->setLastName($lname);
	        $personData->setEmail($email);
	        
	        $authenticateData = new MultiTableManager();
	        $authenticateData->addRowManager($personData);
	        $authenticateData->addRowManager($accessData, new JoinPair($accessData->getJoinOnPersonID(),$personData->getJoinOnPersonID()));
	        $authenticateData->addRowManager($viewerData, new JoinPair($viewerData->getJoinOnViewerID(),$accessData->getJoinOnViewerID()));	        
	        
	        $login_list = $authenticateData->getListIterator();
	        $login_array = $login_list->getDataList();
// 	        echo 'authentication data = <pre>'.print_r($login_array, true).'</pre>';
	        if (count($login_array) > 0)
	        {
		        $isValid = false;
		        $this->formErrors[ 'person_email'] = $this->labels->getLabel( '[error_prevAccountFound]');		      
	        }
            
            // check to make sure the passwords match
            $pword = $this->formValues[ 'viewer_passWord' ];
            $pword2 = $this->formValues[ 'pword2' ];
            if( $pword != $pword2 ) {
            
                $isValid = false;
                $this->formErrors[ 'viewer_passWord' ] = $this->labels->getLabel( '[error_passwordMatch]');
                
            }
 */     
        }

    



        // now return result
        
        
     //   echo ($userID.$PWord);


        $isValid = false; //assume false
        
            $viewerManager = new RowManager_ViewerManager();
            $viewerManager->loadByUserIDPWord($userID, $PWord);        
        
   
            // if viewerManager is successfully loaded then data was a 
            // valid login
            
			if ( $viewerManager->isLoaded() )        //checking ID and PWord
			 {
			 
			     if (!($viewerManager->getGUID()))         //check if it has a GUID already
			     {
			     
			     $isValid = true;
			     
			     } else {echo ("SONIC BOOOOM!");
			             die;}
			     
			 } else { echo ('Invalid UserID & Password.'); }
			             	             

           
			 
        return $isValid;
    }
    
    
    
    //************************************************************************
	/**
	 * function processData
	 * <pre>
	 * Processes the data for this form.
	 * 
	 * 
	 * </pre>
	 * @return [void]
	 */
    function processData()
    {
        $viewerManager = new RowManager_ViewerManager();
        $userID = $this->formValues[ 'viewer_userID' ];         //get userID from form
        $PWord = $this->formValues[ 'viewer_passWord' ];        //get PWord from form
        
        $viewerManager->loadByUserIDPWord($userID, $PWord);     //load a viewer
		
		//echo ($this->guid);	
		//echo ($viewerManager->getID());
		
        viewer_guid_connect($this->guid, $viewerManager->getID(), false); //inject GUID into the loaded viewer
        
        
        $viewerManager->isAuthenticated = true; 

	    // update the viewer's last login info
	    $viewerManager->setLastLogin();
	    //$viewerManager->updateDBTable();

	    // Update current Session ID with current ViewerID
	    $_SESSION[ SESSION_ID_ID ] = $viewerManager->getID();

        header ('Location: https://intranet.campusforchrist.org/index.php?p_Mod=Welcome'); //HARDCODED stuff
        

        return;
        
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
        // $path = $this->pathModuleRoot.'templates/';
        // Otherwise use the standard Templates for the site:
        // Note: prepended two diretories since this file is not quite being run in the same way
        $path = "../../".SITE_PATH_TEMPLATES;

        
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
        $this->template->set( 'button1Text' , $this->labels->getLabel('Submit') );
        $this->template->set( 'button2Text' , $this->labels->getLabel('Skip') );

        


        // Insert the date start/end values for the following date fields:
        // example:
            //$this->template->set( 'startYear_[fieldName]', 2000);
            //$this->template->set( 'endYear_[fieldName]', 2010);

                


        /*
         * Add any additional data required by the template here
         */


        // uncomment this line if you are creating a template for this page
        // $templateName = 'page_GCXFirstLogin.php';
        // otherwise use the generic site form single template
        $templateName = 'siteFormDouble.php';
		
	return $this->template->fetch( $templateName );
        
    }
    
	
}

?>
