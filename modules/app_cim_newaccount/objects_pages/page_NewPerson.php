<?php
/**
 * @package cim_newaccount
 */ 
/**
 * class FormProcessor_NewPerson 
 * <pre> 
 * This page is used to add a new person to the system.
 * </pre>
 * @author CIM
 * Date:   15 Apr 2006
 */
 // RAD Tools: FormSingleEntry Page
class  FormProcessor_NewPerson extends PageDisplay_FormProcessor {

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
    const FORM_FIELDS = 'person_email|E|,viewer_passWord|T|,pword2|T|,person_fname|T|,person_lname|T|';

    /** The list of field types to be displayed in the form */
    // NOTE: if a field isn't displayed, put a '-' for it's entry.
    const FORM_FIELD_TYPES = 'textbox,password,password,textbox,textbox';
    
    /** The Multilingual Page Key for this page */
    const MULTILINGUAL_PAGE_KEY = 'FormProcessor_NewPerson';

	//VARIABLES:
	
	/** @var [STRING] The path to the module's root directory. */
	protected $pathModuleRoot;
	
	/** @var [OBJECT] The Viewer Object. */
	protected $viewer;
		
    /** @var [STRING] The initialization data for the dataManager. */
	protected $person_id;
	



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
        $fieldList = FormProcessor_NewPerson::FORM_FIELDS;
        $fieldDisplayTypes = FormProcessor_NewPerson::FORM_FIELD_TYPES;
        parent::__construct( $formAction, $fieldList, $fieldDisplayTypes  );

        $this->pathModuleRoot = $pathModuleRoot;
        $this->viewer = $viewer;

        $this->person_id = $person_id;

        
        // figure out the important fields for the dataManager
        $fieldsOfInterest = implode(',', $this->formFields);

        $this->dataManager = new RowManager_PersonManager();
        $this->dataManager->setFieldsOfInterest( $fieldsOfInterest );
        $this->formValues = $this->dataManager->getArrayOfValues();

        // now initialize the labels for this page
        // start by loading the default field labels for this Module
        $languageID = $viewer->getLanguageID();
        $seriesKey = modulecim_newaccount::MULTILINGUAL_SERIES_KEY;
        $pageKey = modulecim_newaccount::MULTILINGUAL_PAGE_FIELDS;
        $this->labels = new MultilingualManager( $languageID, $seriesKey, $pageKey );
        
        // then load the page specific labels for this page
        $pageKey = FormProcessor_NewPerson::MULTILINGUAL_PAGE_KEY;
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
	        
            // check to make sure the user id doesn't already exist
            $userID = $this->formValues[ 'person_email' ];
            $viewerManager = new RowManager_ViewerManager();
            $viewerManager->loadByUserID( $userID );
            if ( $viewerManager->isLoaded() ) {
                // this user already exists
                $isValid = false;
                $this->formErrors[ 'person_email' ] = $this->labels->getLabel( '[error_uniqueUserID]');
            }	        
	        
	        // check to ensure that person does not already have an account
	        $fname = $this->formValues[ 'person_fname' ];
	        $lname = $this->formValues[ 'person_lname' ];
	        $email = $this->formValues[ 'person_email' ];
	
	        $viewerData = new RowManager_ViewerManager();        
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
      
        }

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
        
        // echo "Inside Process Data<br/>";
        // echo "<pre>".print_r( $this->formValues, true )."</pre>";

        // ASSSUMES that we want to make a totally new person
        // and a totally new viewer
        // we can add code later to check for the uniqueness
        // of the person based on an email or something

        // 1. create new viewer
        $viewerManager = new RowManager_ViewerManager();
        $viewerManager->setPassWord( $this->formValues['viewer_passWord'] );
        $viewerManager->setUserID( $this->formValues['person_email']  );
        $viewerManager->setLanguageID( 1 ); // english
        // TODO this value should not be hard-coded for the account group
        $viewerManager->setAccountGroupID( 15 ); // the 'unknown' group
        $viewerManager->setIsActive( true );
        $viewerManager->createNewEntry();
        $viewerID = $viewerManager->getID(); // get the ID of the newly created viewer
        
        // 2. put into the 'all' access group
        // PART A
        $viewerAccessGroupManager = new RowManager_ViewerAccessGroupManager();
        $viewerAccessGroupManager->setViewerID( $viewerID );
        $viewerAccessGroupManager->setAccessGroupID( ALL_ACCESS_GROUP ); // add to the 'all' access group
        $viewerAccessGroupManager->createNewEntry();
        // PART B
        $viewerAccessGroupManager = new RowManager_ViewerAccessGroupManager();
        $viewerAccessGroupManager->setViewerID( $viewerID );
        $viewerAccessGroupManager->setAccessGroupID( SPT_APPLICANT_ACCESS_GROUP ); // add to the 'SPT-Student' access group
        $viewerAccessGroupManager->createNewEntry();
        
        // 3. create new person (or grab person_id from existing record)
        $personManager = new RowManager_PersonManager();
        $personManager->setFirstName( $this->formValues['person_fname'] );
        $personManager->setLastName( $this->formValues['person_lname'] );
        $personManager->setEmail( $this->formValues['person_email'] );
        $personManager->setSortOrder( 'person_id' );
        $personManager->setAscDesc( 'DESC' ); 	// sort by descending person IDs
        
        $personList = $personManager->getListIterator();
        $personArray = $personList->getDataList();
        
        $personID = -1;
        if (count($personArray) < 1)	// create new person record if none exists yet
        {
	        $personManager->createNewEntry();
	        $personID = $personManager->getID(); // get the ID of the newly created person
        }
        else 
        {
	        // knowing that person has no record in viewer table, use latest person_id
	        reset($personArray);
	        $record = current($personArray);	
	        $personID = $record['person_id']; 	// latest id, by virtue of DESC person_id sort
        }
	        
        
        // 4. create an access table entry for this (viewer,person) combo
        $accessManager = new RowManager_AccessManager();
        $accessManager->setViewerID( $viewerID );
        $accessManager->setPersonID( $personID );
        $accessManager->createNewEntry();

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
        $this->template->set( 'buttonText', $this->labels->getLabel('[Update]') );
        


        // Insert the date start/end values for the following date fields:
        // example:
            //$this->template->set( 'startYear_[fieldName]', 2000);
            //$this->template->set( 'endYear_[fieldName]', 2010);

                


        /*
         * Add any additional data required by the template here
         */


        // uncomment this line if you are creating a template for this page
        // $templateName = 'page_NewPerson.php';
        // otherwise use the generic site form single template
        $templateName = 'siteFormSingle.php';
		
	return $this->template->fetch( $templateName );
        
    }
    
	
}

?>