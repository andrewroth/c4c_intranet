<?php
/**
 * @package cim_newaccount
 class modulecim_newaccount
 discussion <pre>
 Written By	:	CIM
 Date		:   15 Apr 2006
 
 This is the module for people to register and use the system.
 
 </pre>	
*/

/* These are now moved to gen_Defines.php
//define('ALL_ACCESS_GROUP', 1);
//define('SPT_APPLICANT_ACCESS_GROUP', 46);
*/

class modulecim_newaccount extends AppController{ //XMLObject_PageContent {
// 		
//
//	CONSTANTS:

        
    /** const MULTILINGUAL_SERIES_KEY The Multilingual Series key for this application.. */
        const MULTILINGUAL_SERIES_KEY = 'modulecim_newaccount';
        
    /** const MULTILINGUAL_PAGE_FIELDS The Multilingual Page key for the fields of this application. */
        const MULTILINGUAL_PAGE_FIELDS = 'fields_cim_newaccount';
        
    /** const MODULE_KEY The Module Key for this Module.  Used for access */
        const MODULE_KEY = 'cim_newaccount';
        
    /** const PAGE    The QueryString Page parameter. */
        const PAGE = "P";
        
    /** const PAGE_NEWPERSON   Display the NewPerson Page. */
        const PAGE_NEWPERSON = "P32";

    /** const PAGE_EMAILSENTSUCCESSFULLY   Display the CreatedSuccessfully. Page. */
        const PAGE_CREATEDSUCCESSFULLY = "P34";

    /** const PAGE_RECOVERLOGINDETAILS   Display the RecoverLoginDetails Page. */
        const PAGE_RECOVERLOGINDETAILS = "P35";

    /** const PAGE_EMAILSENTSUCCESSFULLY   Display the EmailSentSuccessfully Page. */
        const PAGE_EMAILSENTSUCCESSFULLY = "P36";
        
    /** const PAGE_GCXFIRSTLOGIN   Display the GCXFirstLogin Page. */
        const PAGE_GCXFIRSTLOGIN = "P37";
        

/*[RAD_PAGE_CONST]*/

    /** const SORTBY    The QueryString SortBy parameter. */
        const SORTBY = "modSort";
                

    /*! const PERSONID   The QueryString PERSONID parameter. */
        const PERSONID = "SV13";

    /*! const PROVINCEID   The QueryString PROVINCEID parameter. */
        const PROVINCEID = "SV14";

    /*! const GENDERID   The QueryString GENDERID parameter. */
        const GENDERID = "SV15";

    /*! const CAMPUSID   The QueryString CAMPUSID parameter. */
        const CAMPUSID = "SV16";

    /*! const VIEWERID   The QueryString VIEWERID parameter. */
        const VIEWERID = "SV17";

    /*! const ASSIGNMENTID   The QueryString ASSIGNMENTID parameter. */
        const ASSIGNMENTID = "SV18";

    /*! const ACCESSID   The QueryString ACCESSID parameter. */
        const ACCESSID = "SV19";
        
    /*! const REDIRECT_URL The redirect-url parameter. */
        const REDIRECT_URL = "RU";
        
    /*! const GUID  The QueryString GUID parameter. */
        const GUID = "GUID";
        
        

/*[RAD_PAGE_STATEVAR_CONST]*/
        
        
//
//	VARIABLES:
        
    /** protected $page   [STRING] The current Mode of this Module. */
		protected $page;
		
    /** protected $sortBy [STRING] Parameter to sort displayed Lists. */
        protected $sortBy;
		
    /*! protected $PersonID   [INTEGER] The id of the person. */
		protected $PersonID;

    /*! protected $ProvinceID   [INTEGER] The id of the province. */
		protected $ProvinceID;

    /*! protected $GenderID   [INTEGER] The id of the gender. */
		protected $GenderID;

    /*! protected $CampusID   [INTEGER] The id of the campus. */
		protected $CampusID;

    /*! protected $ViewerID   [INTEGER] The id of the user being created. */
		protected $ViewerID;

    /*! protected $AssignmentID   [INTEGER] The id for the Campus Assignment for the viewer. */
		protected $AssignmentID;

    /*! protected $AccessID   [INTEGER] The id for the Access table which links the viewerId and the personID */
		protected $AccessID;
		
	/*! protected $redirectURL [STRING] the url that the page should redirect to one an account has been successfully created. */ 	
		protected $redirectURL;

	/*! protected $guid [STRING] GUID of the user who logged in through GCX. */ 	
		protected $guid;

/*[RAD_PAGE_STATEVAR_VAR]*/
		
   
    /** protected $pageDisplay [OBJECT] The display object for the page. */
        protected $pageDisplay;
        
    /** protected $pageCommonDisplay [OBJECT] The display object for the common page layout. */
        protected $pageCommonDisplay;

/*[RAD_PAGE_OBJECT_VAR]*/ 		


//
//	CLASS FUNCTIONS:
//

	
	//************************************************************************
	/** 
	 * @function loadData
	 *
	 * @abstract Provided function to allow object to load it's data.
     *
	 */
	function loadData( ) 
	{


/*[RAD_PAGE_STATEVAR_INIT]*/
        
        // Now check to see if a Application ID was given
//        $this->appID = $this->getQSValue( modulecim_newaccount::APPID, '' );
        
        // load the common page layout object
        //$this->pageCommonDisplay = new CommonDisplay( $this->moduleRootPath, $this->pathToRoot, $this->viewer);

        // load the module's page (DEFAULT = WELCOME)
        $this->page = $this->getQSValue( modulecim_newaccount::PAGE, modulecim_newaccount::PAGE_NEWPERSON );
        
        // load the module's sortBy parameter (DEFAULT = '')
        $this->sortBy = $this->getQSValue( modulecim_newaccount::SORTBY, '' );
        
        // load the module's PERSONID variable
        $this->PersonID = $this->getQSValue( modulecim_newaccount::PERSONID, "" );

        // load the module's PROVINCEID variable
        $this->ProvinceID = $this->getQSValue( modulecim_newaccount::PROVINCEID, "" );

        // load the module's GENDERID variable
        $this->GenderID = $this->getQSValue( modulecim_newaccount::GENDERID, "" );

        // load the module's CAMPUSID variable
        $this->CampusID = $this->getQSValue( modulecim_newaccount::CAMPUSID, "" );

        // load the module's VIEWERID variable
        $this->ViewerID = $this->getQSValue( modulecim_newaccount::VIEWERID, "" );

        // load the module's ASSIGNMENTID variable
        $this->AssignmentID = $this->getQSValue( modulecim_newaccount::ASSIGNMENTID, "" );

        // load the module's ACCESSID variable
        $this->AccessID = $this->getQSValue( modulecim_newaccount::ACCESSID, "" );
        
        // load the module's REDIRECT_URL variable
        $this->redirectURL = $this->getQSValue( modulecim_newaccount::REDIRECT_URL, "" );
        
        // load the module's GUID variable
        $this->guid = $this->getQSValue( modulecim_newaccount::GUID, "" );


/*[RAD_PAGE_LOAD_STATEVAR]*/
        
        switch( $this->page ) {
                
            /*
             *  NewPerson
             */
            case modulecim_newaccount::PAGE_NEWPERSON:
                $this->loadNewPerson();
                break;

            /*
             *  CreatedSuccessfully.
             */
            case modulecim_newaccount::PAGE_CREATEDSUCCESSFULLY:
                $this->loadCreatedSuccessfully();
                break;

            /*
             *  RecoverLoginDetails
             */
            case modulecim_newaccount::PAGE_RECOVERLOGINDETAILS:
                $this->loadRecoverLoginDetails();
                break;

            /*
             *  EmailSentSuccessfully
             */
            case modulecim_newaccount::PAGE_EMAILSENTSUCCESSFULLY:
                $this->loadEmailSentSuccessfully();
                break;
                
            /*
             *  GCXFIRSTLOGIN
             */
             
            case modulecim_newaccount::PAGE_GCXFIRSTLOGIN:
                $this->loadGCXFirstLogin();
                break;

/*[RAD_PAGE_LOAD_CALL]*/
   
                 
            /*
             *  Just to make sure, default the pageDisplay to 
             *  the NewPerson page.
             */
            default:
                $this->page = modulecim_newaccount::PAGE_NEWPERSON;
                $this->loadNewPerson();
                break;
        
        }
        
        
        /*
         * Load Form Values if a ProcessData field exists
         */
        if (isset( $_REQUEST[ PerlFileUpload::DEF_QSPARAM_SID ]) ) {
            // perlFileUploads don't retain the Process parameter
            // so we add it here
            $_REQUEST[ 'Process' ]  = 'Y';
        }
        
        if (isset( $_REQUEST[ 'Process' ] ) ) {
        
            $this->pageDisplay->loadFromForm();
        }

	}
	
	
	
	//************************************************************************
	/** 
	 * @function processData
	 *
	 * @abstract Provided function to allow an object to process it's data.
	 *
	 */
	function processData( ) 
	{

        // if this was a form submit ... 
        // NOTE: our forms should have a hidden variable named Process on them.
        if (isset( $_REQUEST[ 'Process' ] ) ) {
        
        
            // if form data is valid ...
            if ( $this->pageDisplay->isDataValid() ) {
            
                // process the data
                $this->pageDisplay->processData();
            
                // now switch to the proper next page ...
                switch( $this->page ) {
    
                    case modulecim_newaccount::PAGE_NEWPERSON:
                        $this->PersonID = '';
                        $this->page = modulecim_newaccount::PAGE_CREATEDSUCCESSFULLY;
                        $this->loadCreatedSuccessfully();                       
                        break;
                        
                    case modulecim_newaccount::PAGE_GCXFIRSTLOGIN:
                        
 
                        
                        break;

                     /*
                     June 4, 2007 - Modified so that recoverLogin page can handle
                     how to proceed in it's own getHTML method
                    case modulecim_newaccount::PAGE_RECOVERLOGINDETAILS:
                        $this->PersonID = '';
                        $this->page = modulecim_newaccount::PAGE_EMAILSENTSUCCESSFULLY;
                        $this->loadEmailSentSuccessfully();                       
                        break;
                        */

/*[RAD_PAGE_TRANSITION]*/
                        
                 }
            
            } // end if data valid
        
        }  // end if Process

	}
	
	
	
	//************************************************************************
	/** 
	 * @function prepareDisplayData
	 *
	 * @abstract Provided function to allow an object to prepare it's data 
	 * for displaying (actually done in the <code>Page</code> Object).
     *
	 */
	function prepareDisplayData( ) 
	{
        $content = $this->pageDisplay->getHTML();

        // wrap current page's html in the common html of the module - Skip!
        //$content = $this->pageCommonDisplay->getHTML( $content );

        // store HTML content as this page's content Item
        $this->addContent( $content );
        
         
        // Add any necessary javascripts for this page:
        switch( $this->page ) {
        
/*[RAD_PAGE_JAVASCRIPTS]*/
//             case modulecim_newaccount::PAGE_DEFAULT:
//                $this->addScript('MM_jumpMenu.jsp');
//                break;

        }
        
	}
	
	
	
    //************************************************************************
	/**
	 * function getCallBack
	 *
	 * <pre> Builds the proper HREF link for a desired action. </pre>
	 *
	 *
	 * @param $page [STRING] The Desired PAGE of this Link.
	 * @param $sortBy [STRING] The Desired Sort Field for this link.
	 * @param $parameters [ARRAY] An array of parameterName=>Value pairs 
	 * possible parameter values :
	 * 'PersonID' [INTEGER] The Desired PERSONID of this Link.
	 * 'ProvinceID' [INTEGER] The Desired PROVINCEID of this Link.
	 * 'GenderID' [INTEGER] The Desired GENDERID of this Link.
	 * 'CampusID' [INTEGER] The Desired CAMPUSID of this Link.
	 * 'ViewerID' [INTEGER] The Desired VIEWERID of this Link.
	 * 'AssignmentID' [INTEGER] The Desired ASSIGNMENTID of this Link.
	 * 'AccessID' [INTEGER] The Desired ACCESSID of this Link.
[RAD_CALLBACK_DOC]
	 * @return [STRING] The Link.
	 */
    function getCallBack($page='', $sortBy='', $parameters='')
    {
        if ( $parameters == '') {
            $parameters = array();
        }
        
        $returnValue = $this->baseCallBack;
        
        $callBack = '';
        
        if ($page != '') {
            $callBack = modulecim_newaccount::PAGE.'='.$page;
        }
        
        if ($sortBy != '') {
            if ($callBack != '') {
                $callBack .= '&';
            }
            $callBack .= modulecim_newaccount::SORTBY.'='.$sortBy;
        }
        
        
        if ( isset( $parameters['PersonID']) ) {
            if ( $parameters['PersonID'] != '' ) {
                if ($callBack != '') {
                    $callBack .= '&';
                }
                $callBack .= modulecim_newaccount::PERSONID.'='.$parameters['PersonID'];
            }
        }

        if ( isset( $parameters['ProvinceID']) ) {
            if ( $parameters['ProvinceID'] != '' ) {
                if ($callBack != '') {
                    $callBack .= '&';
                }
                $callBack .= modulecim_newaccount::PROVINCEID.'='.$parameters['ProvinceID'];
            }
        }

        if ( isset( $parameters['GenderID']) ) {
            if ( $parameters['GenderID'] != '' ) {
                if ($callBack != '') {
                    $callBack .= '&';
                }
                $callBack .= modulecim_newaccount::GENDERID.'='.$parameters['GenderID'];
            }
        }

        if ( isset( $parameters['CampusID']) ) {
            if ( $parameters['CampusID'] != '' ) {
                if ($callBack != '') {
                    $callBack .= '&';
                }
                $callBack .= modulecim_newaccount::CAMPUSID.'='.$parameters['CampusID'];
            }
        }

        if ( isset( $parameters['ViewerID']) ) {
            if ( $parameters['ViewerID'] != '' ) {
                if ($callBack != '') {
                    $callBack .= '&';
                }
                $callBack .= modulecim_newaccount::VIEWERID.'='.$parameters['ViewerID'];
            }
        }

        if ( isset( $parameters['AssignmentID']) ) {
            if ( $parameters['AssignmentID'] != '' ) {
                if ($callBack != '') {
                    $callBack .= '&';
                }
                $callBack .= modulecim_newaccount::ASSIGNMENTID.'='.$parameters['AssignmentID'];
            }
        }

        if ( isset( $parameters['AccessID']) ) {
            if ( $parameters['AccessID'] != '' ) {
                if ($callBack != '') {
                    $callBack .= '&';
                }
                $callBack .= modulecim_newaccount::ACCESSID.'='.$parameters['AccessID'];
            }
        }
        
        if ( isset( $parameters['REDIRECT_URL']) ) {
            if ( $parameters['REDIRECT_URL'] != '' ) {
                if ($callBack != '') {
                    $callBack .= '&';
                }
                $callBack .= modulecim_newaccount::REDIRECT_URL.'='.$parameters['REDIRECT_URL'];
            }
        }


       if ( isset( $parameters['GUID']) ) {
            if ( $parameters['GUID'] != '' ) {
                if ($callBack != '') {
                    $callBack .= '&';
                }
                $callBack .= modulecim_newaccount::GUID.'='.$parameters['GUID'];
            }
        }
        
/*[RAD_CALLBACK_CODE]*/
        
        if ( $callBack != '') {
            $returnValue .= '&'.$callBack;
        }
        
        return $returnValue;
    }    
    
    
    
    //************************************************************************
	/**
	 * function getMultilingualSeriesKey()
	 *
	 * <pre> Returns the value of the Multilingual Series Key </pre>
	 *
	 * @return [STRING]
	 */
    function getMultilingualSeriesKey() 
    {
        return modulecim_newaccount::MULTILINGUAL_SERIES_KEY;
    }

    
    
    //************************************************************************
	/**
	 * function loadNewPerson
	 * <pre>
	 * Initializes the NewPerson Page.
	 * </pre>
	 * @return [void]
	 */
    // RAD Tools: FormSingleEntry style
    function loadNewPerson() 
    {
        // set the pageCallBack to be without any additional parameters
        // (an AdminBox needs this so Language Switching on a page doesn't
        // pass a previous operations)
        $parameters = array('PersonID'=>$this->PersonID, 'ProvinceID'=>$this->ProvinceID, 'GenderID'=>$this->GenderID, 'CampusID'=>$this->CampusID, 'ViewerID'=>$this->ViewerID, 'AssignmentID'=>$this->AssignmentID);//[RAD_CALLBACK_PARAMS]
        $pageCallBack = $this->getCallBack(modulecim_newaccount::PAGE_NEWPERSON, $this->sortBy, $parameters);
        $this->setPageCallBack( $pageCallBack );
        
        
        $parameters = array('PersonID'=>$this->PersonID, 'ProvinceID'=>$this->ProvinceID, 'GenderID'=>$this->GenderID, 'CampusID'=>$this->CampusID, 'ViewerID'=>$this->ViewerID, 'AssignmentID'=>$this->AssignmentID,'REDIRECT_URL'=>$this->redirectURL);//[RAD_CALLBACK_PARAMS]
        $formAction = $this->getCallBack(modulecim_newaccount::PAGE_NEWPERSON, $this->sortBy, $parameters );
        $this->pageDisplay = new FormProcessor_NewPerson( $this->moduleRootPath, $this->viewer, $formAction, $this->PersonID );//[RAD_FORMINIT_FOREIGNKEY_INIT]        
        
    } // end loadNewPerson()



    //************************************************************************
	/**
	 * function loadCreatedSuccessfully.
	 * <pre>
	 * Initializes the CreatedSuccessfully. Page.
	 * </pre>
	 * @return [void]
	 */
    // RAD Tools: Custom style
    function loadCreatedSuccessfully()
    {
        // set the pageCallBack to be without any additional parameters
        // (an AdminBox needs this so Language Switching on a page doesn't
        // pass a previous operations)
        $parameters = array('PersonID'=>$this->PersonID, 'ProvinceID'=>$this->ProvinceID, 'GenderID'=>$this->GenderID, 'CampusID'=>$this->CampusID, 'ViewerID'=>$this->ViewerID, 'AssignmentID'=>$this->AssignmentID, 'AccessID'=>$this->AccessID, 'REDIRECT_URL'=>$this->redirectURL);//[RAD_CALLBACK_PARAMS]
        $pageCallBack = $this->getCallBack(modulecim_newaccount::PAGE_CREATEDSUCCESSFULLY, $this->sortBy, $parameters);
        $this->setPageCallBack( $pageCallBack );
        
        $this->pageDisplay = new page_CreatedSuccessfully( $this->moduleRootPath, $this->viewer, $this->redirectURL );
        
        $links = array();
        
/*[RAD_LINK_INSERT]*/

        $this->pageDisplay->setLinks( $links );     
        
    } // end loadCreatedSuccessfully.()



    //************************************************************************
	/**
	 * function loadRecoverLoginDetails
	 * <pre>
	 * Initializes the RecoverLoginDetails Page.
	 * </pre>
	 * @return [void]
	 */
    // RAD Tools: FormSingleEntry style
    function loadRecoverLoginDetails() 
    {
        // set the pageCallBack to be without any additional parameters
        // (an AdminBox needs this so Language Switching on a page doesn't
        // pass a previous operations)
        $parameters = array('PersonID'=>$this->PersonID, 'ProvinceID'=>$this->ProvinceID, 'GenderID'=>$this->GenderID, 'CampusID'=>$this->CampusID, 'ViewerID'=>$this->ViewerID, 'AssignmentID'=>$this->AssignmentID, 'AccessID'=>$this->AccessID);//[RAD_CALLBACK_PARAMS]
        $pageCallBack = $this->getCallBack(modulecim_newaccount::PAGE_RECOVERLOGINDETAILS, $this->sortBy, $parameters);
        $this->setPageCallBack( $pageCallBack );
        
        
        $parameters = array('PersonID'=>$this->PersonID, 'ProvinceID'=>$this->ProvinceID, 'GenderID'=>$this->GenderID, 'CampusID'=>$this->CampusID, 'ViewerID'=>$this->ViewerID, 'AssignmentID'=>$this->AssignmentID, 'AccessID'=>$this->AccessID);//[RAD_CALLBACK_PARAMS]
        $formAction = $this->getCallBack(modulecim_newaccount::PAGE_RECOVERLOGINDETAILS, $this->sortBy, $parameters );
        $this->pageDisplay = new FormProcessor_RecoverLoginDetails( $this->moduleRootPath, $this->viewer, $formAction, $this->PersonID );//[RAD_FORMINIT_FOREIGNKEY_INIT]        
        
    } // end loadRecoverLoginDetails()



    //************************************************************************
	/**
	 * function loadEmailSentSuccessfully
	 * <pre>
	 * Initializes the EmailSentSuccessfully Page.
	 * </pre>
	 * @return [void]
	 */
    // RAD Tools: Custom style
    function loadEmailSentSuccessfully() 
    {
        // set the pageCallBack to be without any additional parameters
        // (an AdminBox needs this so Language Switching on a page doesn't
        // pass a previous operations)
        $parameters = array('PersonID'=>$this->PersonID, 'ProvinceID'=>$this->ProvinceID, 'GenderID'=>$this->GenderID, 'CampusID'=>$this->CampusID, 'ViewerID'=>$this->ViewerID, 'AssignmentID'=>$this->AssignmentID, 'AccessID'=>$this->AccessID);//[RAD_CALLBACK_PARAMS]
        $pageCallBack = $this->getCallBack(modulecim_newaccount::PAGE_EMAILSENTSUCCESSFULLY, $this->sortBy, $parameters);
        $this->setPageCallBack( $pageCallBack );
        
        
        $this->pageDisplay = new page_EmailSentSuccessfully( $this->moduleRootPath, $this->viewer );   
        
        $links = array();
        
/*[RAD_LINK_INSERT]*/

        $this->pageDisplay->setLinks( $links );     
        
    } // end loadEmailSentSuccessfully()


    //************************************************************************
	/**
	 * function loadGCXFirstLogin
	 * <pre>
	 * Initializes the GCXFirstLogin Page.
	 * </pre>
	 * @return [void]
	 */
    // RAD Tools: Custom style
    function loadGCXFirstLogin() 
    {
// set the pageCallBack to be without any additional parameters
        // (an AdminBox needs this so Language Switching on a page doesn't
        // pass a previous operations)
        $parameters = array('PersonID'=>$this->PersonID, 'ProvinceID'=>$this->ProvinceID, 'GenderID'=>$this->GenderID, 'CampusID'=>$this->CampusID, 'ViewerID'=>$this->ViewerID, 'AssignmentID'=>$this->AssignmentID, 'GUID'=>$this->guid);//[RAD_CALLBACK_PARAMS]
        $pageCallBack = $this->getCallBack(modulecim_newaccount::PAGE_GCXFIRSTLOGIN, $this->sortBy, $parameters);
        $this->setPageCallBack( $pageCallBack );
        
        
        $parameters = array('PersonID'=>$this->PersonID, 'ProvinceID'=>$this->ProvinceID, 'GenderID'=>$this->GenderID, 'CampusID'=>$this->CampusID, 'ViewerID'=>$this->ViewerID, 'AssignmentID'=>$this->AssignmentID,'REDIRECT_URL'=>$this->redirectURL, 'GUID'=>$this->guid);//[RAD_CALLBACK_PARAMS]
        $formAction = $this->getCallBack(modulecim_newaccount::PAGE_GCXFIRSTLOGIN, $this->sortBy, $parameters );
        $this->pageDisplay = new FormProcessor_GCXFirstLogin( $this->moduleRootPath, $this->viewer, $formAction, $this->guid);
        
        //[RAD_FORMINIT_FOREIGNKEY_INIT]           
        
    } // end loadGCXFirstLogin()



/*[RAD_PAGE_LOAD_FN]*/		

}

?>