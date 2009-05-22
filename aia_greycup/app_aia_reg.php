<?php

// First load the common Registration Summaries Tools object
// This object allows for efficient access to registration summary data (multi-table).
// $fileName = 'Tools/tools_RegSummaries.php';
// $path = Page::findPathExtension( $fileName );
// require_once( $path.$fileName);
require_once('objects_bl/obj_CommonDisplay.php');
require_once('objects_pages/page_RegisterForm.php');
require_once('objects_pages/page_ConfirmRegistration.php');
//require_once('objects_pages/page_DownloadRegistrationSummary.php');
//require_once('objects_pages/page_NotAuthorized.php');

// require_once('../modules/app_cim_reg/objects_da/PrivilegeManager.php');
// require_once('../modules/app_cim_reg/objects_da/SuperAdminAssignmentManager.php');
// require_once('../modules/app_cim_reg/objects_da/EventAdminAssignmentManager.php');

/**
 * @package aia_reg
 class moduleaia_reg
 discussion <pre>
 Written By	:	Russ Martin, modified by Hobbe Smit
 Date		:   12 Feb 2007  (intense modification on October 3, 2007)
 
 registration system module... version 2.0
 
 </pre>	
*/
class moduleaia_reg extends XMLObject_PageContent {
// 		
//
//	CONSTANTS:            

    /** const EVENT_DATA_FILE_NAME The name/suffix of the file where event registration data is stored */
        const EVENT_DATA_FILE_NAME = 'AIAeventDataDump.csv';
      
                
    /** const MULTILINGUAL_SERIES_KEY The Multilingual Series key for this application.. */
        const MULTILINGUAL_SERIES_KEY = 'moduleaia_reg';
        
    /** const MULTILINGUAL_PAGE_FIELDS The Multilingual Page key for the fields of this application. */
        const MULTILINGUAL_PAGE_FIELDS = 'fields_aia_reg';
        
    /** const MODULE_KEY The Module Key for this Module.  Used for access */
        const MODULE_KEY = 'aia_reg';
        
    /** const PAGE    The QueryString Page parameter. */
        const PAGE = "P";              
        
    /** const PAGE_REGISTERFORM   Display the RegisterForm Page. */
        const PAGE_REGISTERFORM = "P68";            

    /** const PAGE_CONFIRMREGISTRATION   Display the ConfirmRegistration Page. */
        const PAGE_CONFIRMREGISTRATION = "P69";
        
    /** const PAGE_DOWNLOADREGISTRATIONSUMMARY   Display the DownloadRegistrationSummary Page. */
//         const PAGE_DOWNLOADREGISTRATIONSUMMARY = "P70";        
        
    

/*[RAD_PAGE_CONST]*/

    /** const SORTBY    The QueryString SortBy parameter. */
        const SORTBY = "modSort";
                

    /*! const EVENT_ID   The QueryString EVENT_ID parameter. */
        const EVENT_ID = "SV21";

    /*! const CCTYPE_ID   The QueryString CCTYPE_ID parameter. */
        const CCTYPE_ID = "SV25";

    /*! const PRIV_ID   The QueryString PRIV_ID parameter. */
        const PRIV_ID = "SV26";

    /*! const VIEWER_ID   The QueryString VIEWER_ID parameter. */
        const VIEWER_ID = "SV27";

    /*! const CASHTRANS_ID   The QueryString CASHTRANS_ID parameter. */
        const CASHTRANS_ID = "SV34";

    /*! const CCTRANS_ID   The QueryString CCTRANS_ID parameter. */
        const CCTRANS_ID = "SV35";

    /*! const REG_ID   The QueryString REG_ID parameter. */
        const REG_ID = "SV36";

    /*! const CAMPUS_ID   The QueryString CAMPUS_ID parameter. */
        const CAMPUS_ID = "SV40";   

    /*! const PERSON_ID   The QueryString PERSON_ID parameter. */
        const PERSON_ID = "SV43";       

    /*! const RECEIPT_ID   The QueryString RECEIPT_ID parameter. */
        const RECEIPT_ID = "SV46";

/*[RAD_PAGE_STATEVAR_CONST]*/

     	      	          
//
//	VARIABLES:
        
    /** protected $page   [STRING] The current Mode of this Module. */
		protected $page;
		
    /** protected $sortBy [STRING] Parameter to sort displayed Lists. */
        protected $sortBy;
		
    /*! protected $EVENT_ID   [INTEGER] unique identifier of events */
		protected $EVENT_ID;

    /*! protected $CCTYPE_ID   [INTEGER] unique identifier of credit card type */
		protected $CCTYPE_ID;

    /*! protected $PRIV_ID   [INTEGER] unique identifier of privileges */
		protected $PRIV_ID;

    /*! protected $VIEWER_ID   [INTEGER] unique identifier of system user */
		protected $VIEWER_ID;

    /*! protected $CASHTRANS_ID   [INTEGER] unique identifier for a particular cash transaction */
		protected $CASHTRANS_ID;

    /*! protected $CCTRANS_ID   [INTEGER] unique identifier for a particular credit card transaction */
		protected $CCTRANS_ID;

    /*! protected $REG_ID   [INTEGER] unique identifier for a particular event registration */
		protected $REG_ID;

    /*! protected $CAMPUS_ID   [INTEGER] unique identifier for a campus (HRDB var) */
		protected $CAMPUS_ID;

    /*! protected $PERSON_ID   [INTEGER] unique identifier for a person (HRDB var) */
		protected $PERSON_ID;
		
    /*! protected $RECEIPT_ID   [INTEGER] unique identifier for a CC transaction receipt */
		protected $RECEIPT_ID;

/*[RAD_PAGE_STATEVAR_VAR]*/
		
   
    /** protected $pageDisplay [OBJECT] The display object for the page. */
        protected $pageDisplay;
        
    /** protected $pageCommonDisplay [OBJECT] The display object for the common page layout. */
        protected $pageCommonDisplay;
        
   /** [STRING] constant indicating which page to return to after form action	 **/
   	  protected $previous_page;
   	  
    /*! protected $sideBar [OBJECT] The display object for the sideBar. */
        protected $sideBar;   	  

/*[RAD_PAGE_OBJECT_VAR]*/ 		


//
//	CLASS FUNCTIONS:
//


//************************************************************************
/**
 * @param &$siteDB     [OBJECT]    The common DB link to the site DB.
 * @param &$siteViewer [OBJECT]    The common viewer object.
 * @param &$siteLabels [OBJECT]    A common label object for the page.
 */
 function __construct( &$siteDB, &$siteViewer, &$siteLabels ) 
{
	parent::__construct($siteDB, $siteViewer, $siteLabels);
	$this->pageTemplateFile = 'Data/templates/php5_siteAIAGreyCupTemplate.php';        
   $this->pageHeaderImage = PAGE_TEMPLATE_HEADER_IMAGE;
}

	
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
//        $this->appID = $this->getQSValue( moduleaia_reg::APPID, '' );
        
        // load the common page layout object
        $this->pageCommonDisplay = new CommonDisplay( $this->moduleRootPath, $this->pathToRoot, $this->viewer);
         
        // load the module's page (DEFAULT = WELCOME)
        $this->page = $this->getQSValue( moduleaia_reg::PAGE, moduleaia_reg::PAGE_REGISTERFORM );
        
        // load the module's sortBy parameter (DEFAULT = '')
        $this->sortBy = $this->getQSValue( moduleaia_reg::SORTBY, '' );
        
        // load the module's EVENT_ID variable
        $this->EVENT_ID = $this->getQSValue( moduleaia_reg::EVENT_ID, "" );

        // load the module's CCTYPE_ID variable
        $this->CCTYPE_ID = $this->getQSValue( moduleaia_reg::CCTYPE_ID, "" );

        // load the module's PRIV_ID variable
        $this->PRIV_ID = $this->getQSValue( moduleaia_reg::PRIV_ID, "" );

        // load the module's VIEWER_ID variable
        $this->VIEWER_ID = $this->getQSValue( moduleaia_reg::VIEWER_ID, "" );

        // load the module's CASHTRANS_ID variable
        $this->CASHTRANS_ID = $this->getQSValue( moduleaia_reg::CASHTRANS_ID, "" );

        // load the module's CCTRANS_ID variable
        $this->CCTRANS_ID = $this->getQSValue( moduleaia_reg::CCTRANS_ID, "" );

        // load the module's REG_ID variable
        $this->REG_ID = $this->getQSValue( moduleaia_reg::REG_ID, "" );

        // load the module's CAMPUS_ID variable
        $this->CAMPUS_ID = $this->getQSValue( moduleaia_reg::CAMPUS_ID, "" );

        // load the module's PERSON_ID variable
        $this->PERSON_ID = $this->getQSValue( moduleaia_reg::PERSON_ID, "" );                   
        
        // load the module's RECEIPT_ID variable
        $this->RECEIPT_ID = $this->getQSValue( moduleaia_reg::RECEIPT_ID, "" );
                   
                

/*[RAD_PAGE_LOAD_STATEVAR]*/
        
        switch( $this->page ) {        

            /*
             *  RegisterForm
             */
            case moduleaia_reg::PAGE_REGISTERFORM:
                $this->loadRegisterForm();
                break;

            /*
             *  ConfirmRegistration
             */
            case moduleaia_reg::PAGE_CONFIRMREGISTRATION:
                $this->loadConfirmRegistration();
                break;


            /*
             *  DownloadRegistrationSummary
             */
//             case moduleaia_reg::PAGE_DOWNLOADREGISTRATIONSUMMARY:
//                 $this->loadDownloadRegistrationSummary();
//                 break;
                
/*[RAD_PAGE_LOAD_CALL]*/
   
                 
            /*
             *  Just to make sure, default the pageDisplay to 
             *  the Reg_home page.
             */
            default:
                $this->page = moduleaia_reg::PAGE_REGISTERFORM;
                $this->loadRegisterForm();
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
    
                    case moduleaia_reg::PAGE_REGISTERFORM:
			
		                        // go to credit card trans. receipt page if CC transactions entered                
			                if (isset($_POST['cctransaction_cardNum']))
			                {
				                $this->CCTRANS_ID = '';
									 $this->page = moduleaia_reg::PAGE_CONFIRMREGISTRATION;
			                   $this->loadConfirmRegistration();	               
		                   }
		                   else
		                   {
	                        $this->page = moduleaia_reg::PAGE_REGISTERFORM;
	                        $this->loadRegisterForm(true);     
			                }           
			                break;                        


                    case moduleaia_reg::PAGE_CONFIRMREGISTRATION:
                        $this->loadConfirmRegistration( true );                     
                        break;


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
        
        
        $this->pageCommonDisplay->setEventID($this->EVENT_ID);

        // wrap current page's html in the common html of the module
        $content = $this->pageCommonDisplay->getHTML( $content );      

        // store HTML content as this page's content Item
        $this->addContent( $content );
        
        // add the sidebar content
//         if (isset($this->sideBar))
//         {
//         		$sideBarContent = $this->sideBar->getHTML();
//         		$this->addSideBarContent( $sideBarContent );
//      		}          
         
        // Add any necessary javascripts for this page:
        switch( $this->page ) {
        
/*[RAD_PAGE_JAVASCRIPTS]*/
//             case moduleaia_reg::PAGE_DEFAULT:
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
	 * 'EVENT_ID' [INTEGER] The Desired EVENT_ID of this Link.
	 * 'FIELDTYPE_ID' [INTEGER] The Desired FIELDTYPE_ID of this Link.
	 * 'PRICERULETYPE_ID' [INTEGER] The Desired PRICERULETYPE_ID of this Link.
	 * 'CCTYPE_ID' [INTEGER] The Desired CCTYPE_ID of this Link.
	 * 'PRIV_ID' [INTEGER] The Desired PRIV_ID of this Link.
	 * 'VIEWER_ID' [INTEGER] The Desired VIEWER_ID of this Link.
	 * 'SUPERADMIN_ID' [INTEGER] The Desired SUPERADMIN_ID of this Link.
	 * 'EVENTADMIN_ID' [INTEGER] The Desired EVENTADMIN_ID of this Link.
	 * 'FIELD_ID' [INTEGER] The Desired FIELD_ID of this Link.
	 * 'DATATYPE_ID' [INTEGER] The Desired DATATYPE_ID of this Link.
	 * 'PRICERULE_ID' [INTEGER] The Desired PRICERULE_ID of this Link.
	 * 'CAMPUSACCESS_ID' [INTEGER] The Desired CAMPUSACCESS_ID of this Link.
	 * 'CASHTRANS_ID' [INTEGER] The Desired CASHTRANS_ID of this Link.
	 * 'CCTRANS_ID' [INTEGER] The Desired CCTRANS_ID of this Link.
	 * 'REG_ID' [INTEGER] The Desired REG_ID of this Link.
	 * 'FIELDVALUE_ID' [INTEGER] The Desired FIELDVALUE_ID of this Link.
	 * 'SCHOLARSHIP_ID' [INTEGER] The Desired SCHOLARSHIP_ID of this Link.
	 * 'STATUS_ID' [INTEGER] The Desired STATUS_ID of this Link.
	 * 'CAMPUS_ID' [INTEGER] The Desired CAMPUS_ID of this Link.
	 * 'PERSON_ID' [INTEGER] The Desired PERSON_ID of this Link.
	 * 	 * 'RECEIPT_ID' [INTEGER] The Desired RECEIPT_ID of this Link.
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
            $callBack = moduleaia_reg::PAGE.'='.$page;
        }
        
        if ($sortBy != '') {
            if ($callBack != '') {
                $callBack .= '&';
            }
            $callBack .= moduleaia_reg::SORTBY.'='.$sortBy;
        }
        
        
        if ( isset( $parameters['EVENT_ID']) ) {
            if ( $parameters['EVENT_ID'] != '' ) {
                if ($callBack != '') {
                    $callBack .= '&';
                }
                $callBack .= moduleaia_reg::EVENT_ID.'='.$parameters['EVENT_ID'];
            }
        }


        if ( isset( $parameters['CCTYPE_ID']) ) {
            if ( $parameters['CCTYPE_ID'] != '' ) {
                if ($callBack != '') {
                    $callBack .= '&';
                }
                $callBack .= moduleaia_reg::CCTYPE_ID.'='.$parameters['CCTYPE_ID'];
            }
        }

        if ( isset( $parameters['PRIV_ID']) ) {
            if ( $parameters['PRIV_ID'] != '' ) {
                if ($callBack != '') {
                    $callBack .= '&';
                }
                $callBack .= moduleaia_reg::PRIV_ID.'='.$parameters['PRIV_ID'];
            }
        }

        if ( isset( $parameters['VIEWER_ID']) ) {
            if ( $parameters['VIEWER_ID'] != '' ) {
                if ($callBack != '') {
                    $callBack .= '&';
                }
                $callBack .= moduleaia_reg::VIEWER_ID.'='.$parameters['VIEWER_ID'];
            }
        }

        if ( isset( $parameters['CASHTRANS_ID']) ) {
            if ( $parameters['CASHTRANS_ID'] != '' ) {
                if ($callBack != '') {
                    $callBack .= '&';
                }
                $callBack .= moduleaia_reg::CASHTRANS_ID.'='.$parameters['CASHTRANS_ID'];
            }
        }

        if ( isset( $parameters['CCTRANS_ID']) ) {
            if ( $parameters['CCTRANS_ID'] != '' ) {
                if ($callBack != '') {
                    $callBack .= '&';
                }
                $callBack .= moduleaia_reg::CCTRANS_ID.'='.$parameters['CCTRANS_ID'];
            }
        }

        if ( isset( $parameters['REG_ID']) ) {
            if ( $parameters['REG_ID'] != '' ) {
                if ($callBack != '') {
                    $callBack .= '&';
                }
                $callBack .= moduleaia_reg::REG_ID.'='.$parameters['REG_ID'];
            }
        }

        if ( isset( $parameters['CAMPUS_ID']) ) {
            if ( $parameters['CAMPUS_ID'] != '' ) {
                if ($callBack != '') {
                    $callBack .= '&';
                }
                $callBack .= moduleaia_reg::CAMPUS_ID.'='.$parameters['CAMPUS_ID'];
            }
        }

        if ( isset( $parameters['PERSON_ID']) ) {
            if ( $parameters['PERSON_ID'] != '' ) {
                if ($callBack != '') {
                    $callBack .= '&';
                }
                $callBack .= moduleaia_reg::PERSON_ID.'='.$parameters['PERSON_ID'];
            }
        }
  

        if ( isset( $parameters['RECEIPT_ID']) ) {
            if ( $parameters['RECEIPT_ID'] != '' ) {
                if ($callBack != '') {
                    $callBack .= '&';
                }
                $callBack .= moduleaia_reg::RECEIPT_ID.'='.$parameters['RECEIPT_ID'];
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
        return moduleaia_reg::MULTILINGUAL_SERIES_KEY;
    }
    
    

	/**
	 * function getViewerPrivilegeLevel
	 * <pre>
	 * Returns the privilege level of the current user/viewer
	 * </pre>
	 * @return [INTEGER] A constant indicating the privilege level of the user
	 */    
//     protected function getViewerPrivilegeLevel()
//     {
//         // get privileges for the current viewer
//         $privManager = new PrivilegeManager( $this->viewer->getID() );
//   			
//         return $privManager->getPrivilegeLevel();     
//      }    
    


    //************************************************************************
	/**
	 * function loadRegisterForm
	 * <pre>
	 * Initializes the RegisterForm Page.
	 * </pre>
	 * @return [void]
	 */
    function loadRegisterForm() 
    {
	    // SET EVENT TO BE 'AIA GREYCUP BREAKFAST 2007'
	    $this->EVENT_ID = 30;
	    
        // set the pageCallBack to be without any additional parameters
        // (an AdminBox needs this so Language Switching on a page doesn't
        // pass a previous operations)
        $parameters = array('REG_ID'=>$this->REG_ID, 'EVENT_ID'=>$this->EVENT_ID, 'CCTRANS_ID'=>$this->CCTRANS_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID);//[RAD_CALLBACK_PARAMS]
        $pageCallBack = $this->getCallBack(moduleaia_reg::PAGE_REGISTERFORM, $this->sortBy, $parameters);
        $this->setPageCallBack( $pageCallBack );
        $formAction = $this->getCallBack(moduleaia_reg::PAGE_REGISTERFORM, $this->sortBy, $parameters );
        $this->pageDisplay = new FormProcessor_Register( $this->moduleRootPath, $formAction, $this->EVENT_ID);
//         $this->REG_ID = $this->pageDisplay->externalGetRegistrationID();
//         echo "REGID ".$this->REG_ID;
        
    } // end loadRegisterForm()
    
    
 //************************************************************************
	/**
	 * function loadConfirmRegistration
	 * <pre>
	 * Initializes the ConfirmRegistration Page.
	 * </pre>
	 * @return [void]
	 */
    // RAD Tools: DataListTable Style
    function loadConfirmRegistration() 
    {

	        // set the pageCallBack to be without any additional parameters
	        // (an AdminBox needs this so Language Switching on a page doesn't
	        // pass a previous operations)
	        $parameters = array('EVENT_ID'=>$this->EVENT_ID, 'CCTYPE_ID'=>$this->CCTYPE_ID,  'VIEWER_ID'=>$this->VIEWER_ID, 'CCTRANS_ID'=>$this->CCTRANS_ID, 'REG_ID'=>$this->REG_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'PERSON_ID'=>$this->PERSON_ID, 'RECEIPT_ID'=>$this->RECEIPT_ID);//[RAD_CALLBACK_PARAMS]
	        $pageCallBack = $this->getCallBack(moduleaia_reg::PAGE_CONFIRMREGISTRATION, $this->sortBy, $parameters);
	        $this->setPageCallBack( $pageCallBack );
	        
	        $this->pageDisplay = new page_ConfirmRegistration( $this->moduleRootPath, $this->REG_ID, $this->CCTRANS_ID, $this->PERSON_ID );    
	         
	        $links = array();
	        
	        $parameters = array('EVENT_ID'=>$this->EVENT_ID, 'CCTYPE_ID'=>$this->CCTYPE_ID,  'VIEWER_ID'=>$this->VIEWER_ID, 'CCTRANS_ID'=>$this->CCTRANS_ID, 'REG_ID'=>$this->REG_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'PERSON_ID'=>$this->PERSON_ID, 'RECEIPT_ID'=>$this->RECEIPT_ID);//[RAD_CALLBACK_PARAMS]
			  $continueLink = $this->getCallBack( moduleaia_reg::PAGE_REGISTERFORM, "", $parameters );
	       
	        $links["cont"] = $continueLink;
	
	/*[RAD_LINK_INSERT]*/
	
	        $parameters = array('EVENT_ID'=>$this->EVENT_ID, 'CCTYPE_ID'=>$this->CCTYPE_ID,  'VIEWER_ID'=>$this->VIEWER_ID, 'CCTRANS_ID'=>$this->CCTRANS_ID, 'REG_ID'=>$this->REG_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'PERSON_ID'=>$this->PERSON_ID, 'RECEIPT_ID'=>$this->RECEIPT_ID);//[RAD_CALLBACK_PARAMS]
	        $sortByLink = $this->getCallBack( moduleaia_reg::PAGE_CONFIRMREGISTRATION, '', $parameters );
	        $sortByLink .= "&".moduleaia_reg::SORTBY."=";
	        $links["sortBy"] = $sortByLink;
	
	        $this->pageDisplay->setLinks( $links ); 
     
    } // end loadDisplayCCtransactionReceipt()


    	/**
	 * function loadDownloadRegistrationSummary
	 * <pre>
	 * Initializes the DownloadRegistrationSummary Page.
	 * </pre>
	 * @return [void]
	 */    
    function loadDownloadRegistrationSummary()
    {	
// 	    // get privileges for the current viewer
//          $privManager = new PrivilegeManager( $this->viewer->getID() );  
//          if ($privManager->isCampusAdmin($this->EVENT_ID, $this->CAMPUS_ID)==true)	
//          {		    
// 		    
// 	        // set the pageCallBack to be without any additional parameters
// 	        // (an AdminBox needs this so Language Switching on a page doesn't
// 	        // pass a previous operations)
// 	        $parameters = array('EVENT_ID'=>$this->EVENT_ID, 'PRIV_ID'=>$this->PRIV_ID, 'VIEWER_ID'=>$this->VIEWER_ID, 'REG_ID'=>$this->REG_ID);//[RAD_CALLBACK_PARAMS]
// 	        $pageCallBack = $this->getCallBack(moduleaia_reg::PAGE_DOWNLOADREGISTRATIONSUMMARY, $this->sortBy, $parameters);
// 	        $this->setPageCallBack( $pageCallBack );        
// 	        
// 	        $this->pageDisplay = new page_DownloadRegistrationSummary( $this->moduleRootPath, $this->viewer, $this->EVENT_ID );    
// 	        
// 	        $links = array();
// 	        
// 	/*[RAD_LINK_INSERT]*/
// 	
// 	//$this->getCallBack( modulecim_reg::PAGE_EDITCAMPUSASSIGNMENT, '', $parameters );
// 	// 		  $link1 = SITE_PATH_MODULES.'app_'.moduleaia_reg::MODULE_KEY.'/objects_pages/'.moduleaia_reg::CSV_DOWNLOAD_TOOL.'?'.moduleaia_reg::EVENT_ID.'='.$this->EVENT_ID.'&'.modulecim_reg::DOWNLOAD_TYPE.'='.modulecim_reg::DOWNLOAD_EVENT_DATA;	//$this->getCallBack( modulecim_reg::PAGE_ADMINEVENTHOME, '', $fileDownloadParameters );
// 			  $link1 = SITE_PATH_REPORTS.moduleaia_reg::EVENT_DATA_FILE_NAME;
// 	
// 	        $links[ "DownloadEventDataDump" ] = $link1;
// 			  
// // 	        $parameters = array( 'EVENT_ID'=>$this->EVENT_ID, 'FIELDTYPE_ID'=>$this->FIELDTYPE_ID);//[RAD_CALLBACK_PARAMS]
// // 	        $continueLink = $this->getCallBack( moduleaia_reg::PAGE_ADMINEVENTHOME, "", $parameters );
// // 	        $links["cont"] = $continueLink;		  
// 	
// 	        $this->pageDisplay->setLinks( $links ); 
// 	        //$this->previous_page = moduleaia_reg::PAGE_HOMEPAGEEVENTLIST;   
//         }
//         else
//         {
// 	        $this->pageDisplay = new page_NotAuthorized($this->moduleRootPath, $this->viewer);  
//         } 
     } 

}




?>