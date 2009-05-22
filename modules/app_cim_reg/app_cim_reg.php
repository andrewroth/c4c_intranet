<?php

// First load the common Registration Summaries Tools object
// This object allows for efficient access to registration summary data (multi-table).
$fileName = 'Tools/tools_RegSummaries.php';
$path = Page::findPathExtension( $fileName );
require_once( $path.$fileName);

/**
 * @package cim_reg
 class modulecim_reg
 discussion <pre>
 Written By	:	Russ Martin
 Date		:   12 Feb 2007
 
 registration system module... version 2.0
 
 </pre>	
*/
class modulecim_reg extends XMLObject_PageContent {
// 		
//
//	CONSTANTS:               

		  const CSV_DOWNLOAD_TOOL = 'page_Downloads.php';

    /** const EVENT_DATA_FILE_NAME The name/suffix of the file where event registration data is stored */
        const EVENT_DATA_FILE_NAME = 'eventDataDump.csv';

    /** const EVENT_SCHOLARSHIP_FILE_NAME The name/suffix of the file where event scholarship data is stored */
        const EVENT_SCHOLARSHIP_FILE_NAME = 'eventScholarshipDump.csv';    
        
        
       /** const AIA_CSV_FILE_NAME The name/suffix of the file where AIA event data is stored */
        const AIA_CSV_FILE_NAME =  'AIA_eventDataDump.csv';
            
                
    /** const MULTILINGUAL_SERIES_KEY The Multilingual Series key for this application.. */
        const MULTILINGUAL_SERIES_KEY = 'modulecim_reg';
        
    /** const MULTILINGUAL_PAGE_FIELDS The Multilingual Page key for the fields of this application. */
        const MULTILINGUAL_PAGE_FIELDS = 'fields_cim_reg';
        
    /** const MODULE_KEY The Module Key for this Module.  Used for access */
        const MODULE_KEY = 'cim_reg';
        
    /** const PAGE    The QueryString Page parameter. */
        const PAGE = "P";
        
        
    /** const PAGE_REG_HOME   Display the Reg_home Page. */
        const PAGE_REG_HOME = "P25";

    /** const PAGE_ADMINHOME   Display the AdminHome Page. */
        const PAGE_ADMINHOME = "P28";

    /** const PAGE_ADMINEVENTHOME   Display the AdminEventHome Page. */
        const PAGE_ADMINEVENTHOME = "P29";

    /** const PAGE_EVENTDETAILS   Display the EventDetails Page. */
        const PAGE_EVENTDETAILS = "P30";

    /** const PAGE_EDITFIELDTYPES   Display the EditFieldTypes Page. */
        const PAGE_EDITFIELDTYPES = "P31";

    /** const PAGE_EDITPRICERULETYPES   Display the EditPriceRuleTypes Page. */
        const PAGE_EDITPRICERULETYPES = "P32";

    /** const PAGE_EDITCREDITCARDTYPES   Display the EditCreditCardTypes Page. */
        const PAGE_EDITCREDITCARDTYPES = "P33";

    /** const PAGE_EDITPRIVILEGETYPES   Display the EditPrivilegeTypes Page. */
        const PAGE_EDITPRIVILEGETYPES = "P34";

    /** const PAGE_VIEWEVENTDETAILS   Display the ViewEventDetails Page. */
        const PAGE_VIEWEVENTDETAILS = "P35";

    /** const PAGE_ADDSUPERADMIN   Display the AddSuperAdmin Page. */
        const PAGE_ADDSUPERADMIN = "P36";

    /** const PAGE_ADDEVENTADMIN   Display the AddEventAdmin Page. */
        const PAGE_ADDEVENTADMIN = "P37";

    /** const PAGE_EDITFORMFIELDS   Display the EditFormFields Page. */
        const PAGE_EDITFORMFIELDS = "P38";

    /** const PAGE_EDITPRICERULES   Display the EditPriceRules Page. */
        const PAGE_EDITPRICERULES = "P39";

    /** const PAGE_ADDCAMPUSADMIN   Display the AddCampusAdmin Page. */
        const PAGE_ADDCAMPUSADMIN = "P40";

    /** const PAGE_EDITSTATUSES   Display the EditStatuses Page. */
        const PAGE_EDITSTATUSES = "P41";

    /** const PAGE_HOMEPAGEEVENTLIST   Display the HomePageEventList Page. */
        const PAGE_HOMEPAGEEVENTLIST = "P42";

    /** const PAGE_HOMEPAGEEVENTLIST   Display the EditRegistrationDetails Page. */        
        const PAGE_EDITREGISTRATIONDETAILS = "P43";

    /** const PAGE_EDITCAMPUSREGISTRATIONS   Display the EditCampusRegistrations Page. */
        const PAGE_EDITCAMPUSREGISTRATIONS = "P44";

    /** const PAGE_CONFIRMDELETEREGISTRATION   Display the ConfirmDeleteRegistration Page. */
        const PAGE_CONFIRMDELETEREGISTRATION = "P45";        

    /** const PAGE_EDITREGISTRATIONSCHOLARSHIPLIST   Display the EditRegistrationScholarshipList Page. */
        const PAGE_EDITREGISTRATIONSCHOLARSHIPLIST = "P46";

    /** const PAGE_EDITREGISTRATIONCASHTRANSACTIONSLIST   Display the EditRegistrationCashTransactionsList Page. */
        const PAGE_EDITREGISTRATIONCASHTRANSACTIONSLIST = "P47";

    /** const PAGE_EDITREGISTRATIONCCTRANSACTIONSLIST   Display the EditRegistrationCCTransactionsList Page. */
        const PAGE_EDITREGISTRATIONCCTRANSACTIONSLIST = "P48";

    /** const PAGE_EDITREGISTRATIONFIELDVALUESFORM   Display the EditRegistrationFieldValuesForm Page. */
        const PAGE_EDITREGISTRATIONFIELDVALUESFORM = "P50";               
        
     /** const PAGE_EDITPERSONALINFO   Display the EditPersonalInfo Page. */
        const PAGE_EDITPERSONALINFO = "P52";       

    /** const PAGE_EDITCAMPUSREGISTRATIONS_OFFFLINEREGBOX   Display the EditCampusRegistrations_OffflineRegBox Page. */
        const PAGE_EDITCAMPUSREGISTRATIONS_OFFFLINEREGBOX = "P53";
        
      /** const PAGE_EDITCAMPUSASSIGNMENT   Display the EditCampusAssignment Page. */
        const PAGE_EDITCAMPUSASSIGNMENT = "P55";  
        
      /** const PAGE_DOWNLOADREPORT   Display the DownloadReport Page. */
        const PAGE_DOWNLOADREPORT = "P56";   
                        

    /** const PAGE_EDITFIELDVALUES   Display the EditFieldValues Page. */
        const PAGE_EDITFIELDVALUES = "P57";
        
     /** const PAGE_PROCESSCASHTRANSACTIONPAGE   Display the ProcessCashTransaction Page. */
        const PAGE_PROCESSCASHTRANSACTION = "P58";
        
    /** const PAGE_PROCESSCCTRANSACTIONPAGE   Display the ProcessCCTransaction Page. */
        const PAGE_PROCESSCCTRANSACTION = "P59";
        
    /** const PAGE_PROCESSFINANCIALTRANSACTIONSPAGE   Display the ProcessFinancialTransactions Page. */
        const PAGE_PROCESSFINANCIALTRANSACTIONS = "P60";                       

    /** const PAGE_SCHOLARSHIPDISPLAYLIST   Display the ScholarshipDisplayList Page. */
        const PAGE_SCHOLARSHIPDISPLAYLIST = "P61";

    /** const PAGE_DISPLAYCCTRANSACTIONRECEIPT   Display the DisplayCCtransactionReceipt Page. */
        const PAGE_DISPLAYCCTRANSACTIONRECEIPT = "P62";

    /** const PAGE_CONFIRMCANCELREGISTRATION   Display the ConfirmCancelRegistration Page. */
        const PAGE_CONFIRMCANCELREGISTRATION = "P63";
        
    /** const PAGE_NOTAUTHORIZED   Display the NotAuthorized Page. */
        const PAGE_NOTAUTHORIZED = "P67";        
        
     /** const PAGE_AIAREGREPORT   Display the AIARegReport Page. */
        const PAGE_DOWNLOADAIAREGREPORT = "P70";       
        
      /** const PAGE_PERSONRECORDCLEANUP   Display the PersonRecordCleanUp Page. */   
        const PAGE_PERSONRECORDCLEANUP = "P71";      
        
      /** const PAGE_PERSONRECORDCLEANUP   Display the PersonRecordCleanUpForm Page. */   
        const PAGE_PERSONRECORDCLEANUP_FORM = "P88";    
        
       /** const PAGE_EMAILCOMPOSER   Display the EmailComposer Page. */   
        const PAGE_EMAILCOMPOSER = "P94";            
         
        
/*[RAD_PAGE_CONST]*/

    /** const SORTBY    The QueryString SortBy parameter. */
        const SORTBY = "modSort";
                

    /*! const EVENT_ID   The QueryString EVENT_ID parameter. */
        const EVENT_ID = "SV21";

    /*! const FIELDTYPE_ID   The QueryString FIELDTYPE_ID parameter. */
        const FIELDTYPE_ID = "SV23";

    /*! const PRICERULETYPE_ID   The QueryString PRICERULETYPE_ID parameter. */
        const PRICERULETYPE_ID = "SV24";

    /*! const CCTYPE_ID   The QueryString CCTYPE_ID parameter. */
        const CCTYPE_ID = "SV25";

    /*! const PRIV_ID   The QueryString PRIV_ID parameter. */
        const PRIV_ID = "SV26";

    /*! const VIEWER_ID   The QueryString VIEWER_ID parameter. */
        const VIEWER_ID = "SV27";

    /*! const SUPERADMIN_ID   The QueryString SUPERADMIN_ID parameter. */
        const SUPERADMIN_ID = "SV28";

    /*! const EVENTADMIN_ID   The QueryString EVENTADMIN_ID parameter. */
        const EVENTADMIN_ID = "SV29";

    /*! const FIELD_ID   The QueryString FIELD_ID parameter. */
        const FIELD_ID = "SV30";

    /*! const DATATYPE_ID   The QueryString DATATYPE_ID parameter. */
        const DATATYPE_ID = "SV31";

    /*! const PRICERULE_ID   The QueryString PRICERULE_ID parameter. */
        const PRICERULE_ID = "SV32";

    /*! const CAMPUSACCESS_ID   The QueryString CAMPUSACCESS_ID parameter. */
        const CAMPUSACCESS_ID = "SV33";

    /*! const CASHTRANS_ID   The QueryString CASHTRANS_ID parameter. */
        const CASHTRANS_ID = "SV34";

    /*! const CCTRANS_ID   The QueryString CCTRANS_ID parameter. */
        const CCTRANS_ID = "SV35";

    /*! const REG_ID   The QueryString REG_ID parameter. */
        const REG_ID = "SV36";

    /*! const FIELDVALUE_ID   The QueryString FIELDVALUE_ID parameter. */
        const FIELDVALUE_ID = "SV37";

    /*! const SCHOLARSHIP_ID   The QueryString SCHOLARSHIP_ID parameter. */
        const SCHOLARSHIP_ID = "SV38";

    /*! const STATUS_ID   The QueryString STATUS_ID parameter. */
        const STATUS_ID = "SV39";

    /*! const CAMPUS_ID   The QueryString CAMPUS_ID parameter. */
        const CAMPUS_ID = "SV40";
        
     /*! const ASSIGNSTATUS_ID   The QueryString ASSIGNSTATUS_ID parameter. */
        const ASSIGNSTATUS_ID = "SV42";       

    /*! const PERSON_ID   The QueryString PERSON_ID parameter. */
        const PERSON_ID = "SV43";
        
    /*! const ASSIGNMENT_ID   The QueryString ASSIGNMENT_ID parameter. */
        const ASSIGNMENT_ID = "SV45";  
        
              

    /*! const RECEIPT_ID   The QueryString RECEIPT_ID parameter. */
        const RECEIPT_ID = "SV46";

    /*! const MINISTRY_ID   The QueryString MINISTRY_ID parameter. */
        const MINISTRY_ID = "SV96";        
        

/*[RAD_PAGE_STATEVAR_CONST]*/

    /*! const DOWNLOAD_TYPE   The QueryString DOWNLOAD_TYPE parameter: used to indicate whether to download some report */
        const DOWNLOAD_TYPE = "DT";  
 
    /** const DOWNLOAD_EVENT_DATA The constant indicating an event data report download*/
        const DOWNLOAD_EVENT_DATA = '1';	

    /** const DOWNLOAD_SCHOLARSHIP_DATA The constant indicating an event scholarship report download*/
        const DOWNLOAD_SCHOLARSHIP_DATA = '2';	
        
        
     /** const IS_IN_REG_PROCESS The constant indicating whether a page is part of offline reg process*/       
        const IS_IN_REG_PROCESS = "RG";
        
     /** const IS_FALSE The constant indicating page is NOT in registration/sign-up process*/
     	  const IS_FALSE = 0;                 
            
     /** const IS_OFFLINE_REG The constant indicating page is in offline registration process*/
     	  const IS_OFFLINE_REG = 1;       
     	  
      /** const IS_SIGNUP The constant indicating page is in student sign-up process*/
     	  const IS_SIGNUP = 2;     
     	  
     /** const IS_RECALC   The constant indicating whether recalculation of balances has been completed*/
     	  const IS_RECALC = "RC";  
     	  
      /** const TO_EMAIL_CHOICE   The constant indicating which e-mail "TO" option was chosen*/	  
     	  const TO_EMAIL_CHOICE = "EC";
     	      	          
//
//	VARIABLES:
        
    /** protected $page   [STRING] The current Mode of this Module. */
		protected $page;
		
    /** protected $sortBy [STRING] Parameter to sort displayed Lists. */
        protected $sortBy;
		
    /*! protected $EVENT_ID   [INTEGER] unique identifier of events */
		protected $EVENT_ID;

    /*! protected $FIELDTYPE_ID   [INTEGER] unique identifier of field type */
		protected $FIELDTYPE_ID;

    /*! protected $PRICERULETYPE_ID   [INTEGER] unique identifier of price rule type */
		protected $PRICERULETYPE_ID;

    /*! protected $CCTYPE_ID   [INTEGER] unique identifier of credit card type */
		protected $CCTYPE_ID;

    /*! protected $PRIV_ID   [INTEGER] unique identifier of privileges */
		protected $PRIV_ID;

    /*! protected $VIEWER_ID   [INTEGER] unique identifier of system user */
		protected $VIEWER_ID;

    /*! protected $SUPERADMIN_ID   [INTEGER] unique identifier of super admin */
		protected $SUPERADMIN_ID;

    /*! protected $EVENTADMIN_ID   [INTEGER] unique identifier of event administrator */
		protected $EVENTADMIN_ID;

    /*! protected $FIELD_ID   [INTEGER] unique identifier for a particular form field */
		protected $FIELD_ID;

    /*! protected $DATATYPE_ID   [INTEGER] unique identifier for a data type (i.e. Number) */
		protected $DATATYPE_ID;

    /*! protected $PRICERULE_ID   [INTEGER] unique identifier for a particular price rule (an instance of a price rule type) */
		protected $PRICERULE_ID;

    /*! protected $CAMPUSACCESS_ID   [INTEGER] unique identifier for a particular campus-eventadminID assignment */
		protected $CAMPUSACCESS_ID;

    /*! protected $CASHTRANS_ID   [INTEGER] unique identifier for a particular cash transaction */
		protected $CASHTRANS_ID;

    /*! protected $CCTRANS_ID   [INTEGER] unique identifier for a particular credit card transaction */
		protected $CCTRANS_ID;

    /*! protected $REG_ID   [INTEGER] unique identifier for a particular event registration */
		protected $REG_ID;

    /*! protected $FIELDVALUE_ID   [INTEGER] unique identifier for a field value assignment (per registration) */
		protected $FIELDVALUE_ID;

    /*! protected $SCHOLARSHIP_ID   [INTEGER] unique identifier for a particular scholarship (per event registrant) */
		protected $SCHOLARSHIP_ID;

    /*! protected $STATUS_ID   [INTEGER] unique identifier for a registration status description */
		protected $STATUS_ID;

    /*! protected $CAMPUS_ID   [INTEGER] unique identifier for a campus (HRDB var) */
		protected $CAMPUS_ID;

    /*! protected $PERSON_ID   [INTEGER] unique identifier for a person (HRDB var) */
		protected $PERSON_ID;
		
    /*! protected $ASSIGNMENT_ID   [INTEGER] unique identifier for a campus-to-person assignment (HRDB var) */
		protected $ASSIGNMENT_ID;		

	/*! protected $ASSIGNSTATUS_ID   [INTEGER] unique identifier for a campus-to-person assignment status (HRDB var) */
		protected $ASSIGNSTATUS_ID;			
		
	/*! protected $DOWNLOAD_TYPE   [INTEGER] identifier indicating the type of report to download */
		protected $DOWNLOAD_TYPE;	

	/*! protected $IS_IN_REG_PROCESS   [STRING] identifier indicating whether page is in registration/sign-up process*/		
		protected $IS_IN_REG_PROCESS;
				
	/*! protected $IS_RECALC   [STRING] identifier indicating whether recalculation has just finished*/		
		protected $IS_RECALC;
		
    /*! protected $RECEIPT_ID   [INTEGER] unique identifier for a CC transaction receipt */
		protected $RECEIPT_ID;
	
	/*! protected $TO_EMAIL_CHOICE   [INTEGER] unique identifier for an e-mail "TO" option */	
		protected $TO_EMAIL_CHOICE;
		
    /*! protected $MINISTRY_ID   [INTEGER] id of a ministry using the Intranet */
		protected $MINISTRY_ID;
		
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
// function __construct($param) 
// {
// 	echo 'do something';
// }

	
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
//        $this->appID = $this->getQSValue( modulecim_reg::APPID, '' );
        
        // load the common page layout object
        $this->pageCommonDisplay = new CommonDisplay( $this->moduleRootPath, $this->pathToRoot, $this->viewer);
         
        // load the module's page (DEFAULT = WELCOME)
        $this->page = $this->getQSValue( modulecim_reg::PAGE, modulecim_reg::PAGE_REG_HOME );
        
        // load the module's sortBy parameter (DEFAULT = '')
        $this->sortBy = $this->getQSValue( modulecim_reg::SORTBY, '' );
        
        // load the module's EVENT_ID variable
        $this->EVENT_ID = $this->getQSValue( modulecim_reg::EVENT_ID, "" );

        // load the module's FIELDTYPE_ID variable
        $this->FIELDTYPE_ID = $this->getQSValue( modulecim_reg::FIELDTYPE_ID, "" );

        // load the module's PRICERULETYPE_ID variable
        $this->PRICERULETYPE_ID = $this->getQSValue( modulecim_reg::PRICERULETYPE_ID, "" );

        // load the module's CCTYPE_ID variable
        $this->CCTYPE_ID = $this->getQSValue( modulecim_reg::CCTYPE_ID, "" );

        // load the module's PRIV_ID variable
        $this->PRIV_ID = $this->getQSValue( modulecim_reg::PRIV_ID, "" );

        // load the module's VIEWER_ID variable
        $this->VIEWER_ID = $this->getQSValue( modulecim_reg::VIEWER_ID, "" );

        // load the module's SUPERADMIN_ID variable
        $this->SUPERADMIN_ID = $this->getQSValue( modulecim_reg::SUPERADMIN_ID, "" );

        // load the module's EVENTADMIN_ID variable
        $this->EVENTADMIN_ID = $this->getQSValue( modulecim_reg::EVENTADMIN_ID, "" );

        // load the module's FIELD_ID variable
        $this->FIELD_ID = $this->getQSValue( modulecim_reg::FIELD_ID, "" );

        // load the module's DATATYPE_ID variable
        $this->DATATYPE_ID = $this->getQSValue( modulecim_reg::DATATYPE_ID, "" );

        // load the module's PRICERULE_ID variable
        $this->PRICERULE_ID = $this->getQSValue( modulecim_reg::PRICERULE_ID, "" );

        // load the module's CAMPUSACCESS_ID variable
        $this->CAMPUSACCESS_ID = $this->getQSValue( modulecim_reg::CAMPUSACCESS_ID, "" );

        // load the module's CASHTRANS_ID variable
        $this->CASHTRANS_ID = $this->getQSValue( modulecim_reg::CASHTRANS_ID, "" );

        // load the module's CCTRANS_ID variable
        $this->CCTRANS_ID = $this->getQSValue( modulecim_reg::CCTRANS_ID, "" );

        // load the module's REG_ID variable
        $this->REG_ID = $this->getQSValue( modulecim_reg::REG_ID, "" );

        // load the module's FIELDVALUE_ID variable
        $this->FIELDVALUE_ID = $this->getQSValue( modulecim_reg::FIELDVALUE_ID, "" );

        // load the module's SCHOLARSHIP_ID variable
        $this->SCHOLARSHIP_ID = $this->getQSValue( modulecim_reg::SCHOLARSHIP_ID, "" );

        // load the module's STATUS_ID variable
        $this->STATUS_ID = $this->getQSValue( modulecim_reg::STATUS_ID, "" );

        // load the module's CAMPUS_ID variable
        $this->CAMPUS_ID = $this->getQSValue( modulecim_reg::CAMPUS_ID, "" );

        // load the module's PERSON_ID variable
        $this->PERSON_ID = $this->getQSValue( modulecim_reg::PERSON_ID, "" );
        
                // load the module's ASSIGNMENT_ID variable
        $this->ASSIGNMENT_ID = $this->getQSValue( modulecim_reg::ASSIGNMENT_ID, "" );
        
                // load the module's ASSIGNSTATUS_ID variable
        $this->ASSIGNSTATUS_ID = $this->getQSValue( modulecim_reg::ASSIGNSTATUS_ID, "" ); 
        
                // load the module's DOWNLOAD_TYPE variable
        $this->DOWNLOAD_TYPE = $this->getQSValue( modulecim_reg::DOWNLOAD_TYPE, "" );    
        
                 // load the module's IS_IN_REG_PROCESS variable
        $this->IS_IN_REG_PROCESS = $this->getQSValue( modulecim_reg::IS_IN_REG_PROCESS, "" );                     
        

        // load the module's RECEIPT_ID variable
        $this->RECEIPT_ID = $this->getQSValue( modulecim_reg::RECEIPT_ID, "" );
        
                 // load the module's IS_RECALC variable
        $this->IS_RECALC = $this->getQSValue( modulecim_reg::IS_RECALC, "" );                     
 
                 // load the module's TO_EMAIL_CHOICE variable
        $this->TO_EMAIL_CHOICE = $this->getQSValue( modulecim_reg::TO_EMAIL_CHOICE, "" );          
        
        // load the module's MINISTRY_ID variable
        $this->MINISTRY_ID = $this->getQSValue( modulecim_reg::MINISTRY_ID, "" );         
                       

/*[RAD_PAGE_LOAD_STATEVAR]*/
        
        switch( $this->page ) {
	        
            /*
             *  Not Authorized page
             */
            case modulecim_reg::PAGE_NOTAUTHORIZED:
                $this->loadNotAuthorized();
                break;	        
                
            /*
             *  Reg_home
             */
            case modulecim_reg::PAGE_REG_HOME:
                $this->loadReg_home();
                break;

            /*
             *  AdminHome
             */
            case modulecim_reg::PAGE_ADMINHOME:
                $this->loadAdminHome();
                break;

            /*
             *  AdminEventHome
             */
            case modulecim_reg::PAGE_ADMINEVENTHOME:
//             	 $this->CAMPUS_ID = '';   // implemented at source (Edit Campus Registrations) instead, by not passing parameter
                $this->loadAdminEventHome();
                break;

            /*
             *  EventDetails
             */
            case modulecim_reg::PAGE_EVENTDETAILS:
                $this->loadEventDetails();
                break;

            /*
             *  EditFieldTypes
             */
            case modulecim_reg::PAGE_EDITFIELDTYPES:
                $this->loadEditFieldTypes();
                break;

            /*
             *  EditPriceRuleTypes
             */
            case modulecim_reg::PAGE_EDITPRICERULETYPES:
                $this->loadEditPriceRuleTypes();
                break;

            /*
             *  EditCreditCardTypes
             */
            case modulecim_reg::PAGE_EDITCREDITCARDTYPES:
                $this->loadEditCreditCardTypes();
                break;

            /*
             *  EditPrivilegeTypes
             */
            case modulecim_reg::PAGE_EDITPRIVILEGETYPES:
                $this->loadEditPrivilegeTypes();
                break;

            /*
             *  ViewEventDetails
             */
            case modulecim_reg::PAGE_VIEWEVENTDETAILS:
                $this->loadViewEventDetails();
                break;

            /*
             *  AddSuperAdmin
             */
            case modulecim_reg::PAGE_ADDSUPERADMIN:
                $this->loadAddSuperAdmin();
                break;

            /*
             *  AddEventAdmin
             */
            case modulecim_reg::PAGE_ADDEVENTADMIN:
                $this->loadAddEventAdmin();
                break;

            /*
             *  EditFormFields
             */
            case modulecim_reg::PAGE_EDITFORMFIELDS:
                $this->loadEditFormFields();
                break;

            /*
             *  EditPriceRules
             */
            case modulecim_reg::PAGE_EDITPRICERULES:
                $this->loadEditPriceRules();
                break;

            /*
             *  AddCampusAdmin
             */
            case modulecim_reg::PAGE_ADDCAMPUSADMIN:
                $this->loadAddCampusAdmin();
                break;

            /*
             *  EditStatuses
             */
            case modulecim_reg::PAGE_EDITSTATUSES:
                $this->loadEditStatuses();
                break;

            /*
             *  HomePageEventList
             */
            case modulecim_reg::PAGE_HOMEPAGEEVENTLIST:
                $this->loadHomePageEventList();
                break;


            /*
             *  EditCampusRegistrations
             */
            case modulecim_reg::PAGE_EDITCAMPUSREGISTRATIONS:
                $this->loadEditCampusRegistrations();
                break;

            /*
             *  ConfirmDeleteRegistration
             */
            case modulecim_reg::PAGE_CONFIRMDELETEREGISTRATION:
                $this->loadConfirmDeleteRegistration();
                break;
 
            /*
             *  EditRegistrationDetails
             */
            case modulecim_reg::PAGE_EDITREGISTRATIONDETAILS:
                $this->loadEditRegistrationDetails();
                break;               

            /*
             *  EditRegistrationScholarshipList
             */
            case modulecim_reg::PAGE_EDITREGISTRATIONSCHOLARSHIPLIST:
                $this->loadEditRegistrationScholarshipList();
                break;

            /*
             *  EditRegistrationCashTransactionsList
             */
            case modulecim_reg::PAGE_EDITREGISTRATIONCASHTRANSACTIONSLIST:
                $this->loadEditRegistrationCashTransactionsList();
                break;

            /*
             *  EditRegistrationCCTransactionsList
             */
            case modulecim_reg::PAGE_EDITREGISTRATIONCCTRANSACTIONSLIST:
                $this->loadEditRegistrationCCTransactionsList();
                break;

            /*
             *  EditRegistrationFieldValuesForm
             */
            case modulecim_reg::PAGE_EDITREGISTRATIONFIELDVALUESFORM:
                $this->loadEditRegistrationFieldValuesForm();
                break;
                
                
            /*
             *  EmailComposer
             */
            case modulecim_reg::PAGE_EMAILCOMPOSER:
                $this->loadEmailComposer();
                break;
                
                                
             /*
             *  EditPersonalInfo
             */
            case modulecim_reg::PAGE_EDITPERSONALINFO:
                $this->loadEditPersonalInfo();
                
	              if ((isset($this->IS_IN_REG_PROCESS))&&($this->IS_IN_REG_PROCESS > modulecim_reg::IS_FALSE))
	              {	              		
        					$this->loadSideBar();
	           	  }              
                
                break;               

            /*
             *  EditCampusRegistrations_OffflineRegBox
             */
            case modulecim_reg::PAGE_EDITCAMPUSREGISTRATIONS_OFFFLINEREGBOX:
                $this->loadEditCampusRegistrations_OffflineRegBox();
                break;
 
             /*
             *  EditCampusAssignment
             */
            case modulecim_reg::PAGE_EDITCAMPUSASSIGNMENT:
                $this->loadEditCampusAssignment();
                
	              if ((isset($this->IS_IN_REG_PROCESS))&&($this->IS_IN_REG_PROCESS > modulecim_reg::IS_FALSE))
	              {	              		
        					$this->loadSideBar();
	           	  }                 
                
                break;            
                                  
             /*
             *  DownloadReport
             */
            case modulecim_reg::PAGE_DOWNLOADREPORT:
                $this->loadDownloadReport();
                break;                                 

            /*
             *  EditFieldValues
             */
            case modulecim_reg::PAGE_EDITFIELDVALUES:
                $this->loadEditFieldValues();
                
	              if ((isset($this->IS_IN_REG_PROCESS))&&($this->IS_IN_REG_PROCESS > modulecim_reg::IS_FALSE))
	              {	              		
        					$this->loadSideBar();
	           	  }                 
                break;
                
             /*
             *  ProcessCashTransaction
             */
            case modulecim_reg::PAGE_PROCESSCASHTRANSACTION:
                $this->loadProcessCashTransaction();
                break;
                
                
            /*
             *  ProcessCCTransaction
             */
            case modulecim_reg::PAGE_PROCESSCCTRANSACTION:
                $this->loadProcessCCTransaction();
                break;
                
            /*
             *  ProcessFinancialTransactions
             */
            case modulecim_reg::PAGE_PROCESSFINANCIALTRANSACTIONS:
                $this->loadProcessFinancialTransactions();
                
 	              if ((isset($this->IS_IN_REG_PROCESS))&&($this->IS_IN_REG_PROCESS > modulecim_reg::IS_FALSE))
	              {	              		
        					$this->loadSideBar();
	           	  }                
                break;                                               

            /*
             *  ScholarshipDisplayList
             */
            case modulecim_reg::PAGE_SCHOLARSHIPDISPLAYLIST:
                $this->loadScholarshipDisplayList();
                break;

            /*
             *  DisplayCCtransactionReceipt
             */
            case modulecim_reg::PAGE_DISPLAYCCTRANSACTIONRECEIPT:
                $this->loadDisplayCCtransactionReceipt();
                
	              if ((isset($this->IS_IN_REG_PROCESS))&&($this->IS_IN_REG_PROCESS > modulecim_reg::IS_FALSE))
	              {	              		
        					$this->loadSideBar();
	           	  }                 
                break;

            /*
             *  ConfirmCancelRegistration
             */
            case modulecim_reg::PAGE_CONFIRMCANCELREGISTRATION:
                $this->loadConfirmCancelRegistration();
                break;
                
            /*
             *  AIARegReport
             */
            case modulecim_reg::PAGE_DOWNLOADAIAREGREPORT:
                $this->loadDownloadAIARegReport();
                break;       
                
             /*
             *  PersonRecordCleanUp
             */               
            case modulecim_reg::PAGE_PERSONRECORDCLEANUP:
            	$this->loadPersonRecordCleanUp();
            	break;       

             /*
             *  PersonRecordCleanUpForm
             */               
            case modulecim_reg::PAGE_PERSONRECORDCLEANUP_FORM:
            	$this->loadPersonRecordCleanUpForm();
            	break;              	  
                

/*[RAD_PAGE_LOAD_CALL]*/
   
                 
            /*
             *  Just to make sure, default the pageDisplay to 
             *  the Reg_home page.
             */
            default:
                $this->page = modulecim_reg::PAGE_REG_HOME;
                $this->loadReg_home();
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
                
                // NOTE: do *NOT* restore this code, 
                // it causes a bug where FK constraint failed delete causes 
                // next insert to overwrite failed delete record                
//        			  if ($this->pageDisplay->getErrorMessage() != '')
// 					  {
// 						  $this->prepareDisplayData(true);
// 					  }
					              
                // now switch to the proper next page ...
                switch( $this->page ) {
    
                    case modulecim_reg::PAGE_EVENTDETAILS:
                        $this->page = modulecim_reg::PAGE_ADMINEVENTHOME;
                        $this->loadAdminEventHome();                       
                        break;

                    case modulecim_reg::PAGE_EDITFIELDTYPES:
                        // NOTE: after a successful submit on an AdminBox style
                        // form, set the managerInit variable back to ''
                        $this->FIELDTYPE_ID = '';
                        $this->loadEditFieldTypes( true );                     
                        break;

                    case modulecim_reg::PAGE_EDITPRICERULETYPES:
                        // NOTE: after a successful submit on an AdminBox style
                        // form, set the managerInit variable back to ''
                        $this->PRICERULETYPE_ID = '';
                        $this->loadEditPriceRuleTypes( true );                     
                        break;

                    case modulecim_reg::PAGE_EDITCREDITCARDTYPES:
                        // NOTE: after a successful submit on an AdminBox style
                        // form, set the managerInit variable back to ''
                        $this->CCTYPE_ID = '';
                        $this->loadEditCreditCardTypes( true );                     
                        break;

                    case modulecim_reg::PAGE_EDITPRIVILEGETYPES:
                        // NOTE: after a successful submit on an AdminBox style
                        // form, set the managerInit variable back to ''
                        $this->PRIV_ID = '';
                        $this->loadEditPrivilegeTypes( true );                     
                        break;

                    case modulecim_reg::PAGE_ADDSUPERADMIN:
                        // NOTE: after a successful submit on an AdminBox style
                        // form, set the managerInit variable back to ''
                        $this->SUPERADMIN_ID = '';
                        $this->loadAddSuperAdmin( true );                     
                        break;

                    case modulecim_reg::PAGE_ADDEVENTADMIN:
                        // NOTE: after a successful submit on an AdminBox style
                        // form, set the managerInit variable back to ''
                        $this->EVENTADMIN_ID = '';
                        $this->loadAddEventAdmin( true );                     
                        break;

                    case modulecim_reg::PAGE_EDITFORMFIELDS:
                        // NOTE: after a successful submit on an AdminBox style
                        // form, set the managerInit variable back to ''
                        $this->FIELD_ID = '';
                        $this->loadEditFormFields( true );                     
                        break;

                    case modulecim_reg::PAGE_EDITPRICERULES:
                        // NOTE: after a successful submit on an AdminBox style
                        // form, set the managerInit variable back to ''
                        $this->PRICERULE_ID = '';
                        $this->loadEditPriceRules( true );                     
                        break;

                    case modulecim_reg::PAGE_ADDCAMPUSADMIN:
                    
                        // NOTE: after a successful submit on an AdminBox style
                        // form, set the managerInit variable back to ''
                        $this->CAMPUSACCESS_ID = '';
                        $this->loadAddCampusAdmin( true );                     
                        break;

                    case modulecim_reg::PAGE_EDITSTATUSES:
                        // NOTE: after a successful submit on an AdminBox style
                        // form, set the managerInit variable back to ''
                        $this->STATUS_ID = '';
                        $this->loadEditStatuses( true );                     
                        break;

                    case modulecim_reg::PAGE_CONFIRMDELETEREGISTRATION:
                        $this->REG_ID = '';
                        $this->page = modulecim_reg::PAGE_EDITCAMPUSREGISTRATIONS;
                        $this->loadEditCampusRegistrations();                       
                        break;

                    case modulecim_reg::PAGE_EDITREGISTRATIONDETAILS:
                        $this->SCHOLARSHIP_ID = '';
                        $this->CASHTRANS_ID = '';
                       
                        // go to credit card trans. receipt page if CC transactions entered
		 	                if (isset($_POST['cctransaction_cardNum']))
			                {
				                $this->CCTRANS_ID = '';
									 $this->page = modulecim_reg::PAGE_DISPLAYCCTRANSACTIONRECEIPT;
			                   $this->loadDisplayCCtransactionReceipt();	               
		                   }
		                   else
		                   {
			                   $this->page = modulecim_reg::PAGE_EDITREGISTRATIONDETAILS;	            
				                $this->loadEditRegistrationDetails( true );	      
			                }           
			                break;                         
                        

                    case modulecim_reg::PAGE_EDITREGISTRATIONSCHOLARSHIPLIST:
                        // NOTE: after a successful submit on an AdminBox style
                        // form, set the managerInit variable back to ''
                        $this->SCHOLARSHIP_ID = '';
                        $this->loadEditRegistrationScholarshipList( true );                     
                        break;

                    case modulecim_reg::PAGE_EDITREGISTRATIONCASHTRANSACTIONSLIST:
                        // NOTE: after a successful submit on an AdminBox style
                        // form, set the managerInit variable back to ''
                        $this->CASHTRANS_ID = '';
                        $this->loadEditRegistrationCashTransactionsList( true );                     
                        break;

                    case modulecim_reg::PAGE_EDITREGISTRATIONCCTRANSACTIONSLIST:
                        // NOTE: after a successful submit on an AdminBox style
                        // form, set the managerInit variable back to ''
                        $this->CCTRANS_ID = '';
                       $this->loadEditRegistrationCCTransactionsList( true );    
// 								 $this->page = modulecim_reg::PAGE_DISPLAYCCTRANSACTIONRECEIPT;
// 		                   $this->loadDisplayCCtransactionReceipt();	                  
                        break;
                        
                  /*
		             *  EditPersonalInfo
		             */
		            case modulecim_reg::PAGE_EDITPERSONALINFO:
		                //$this->loadEditPersonalInfo( true );
		                 if ((isset($this->IS_IN_REG_PROCESS))&&($this->IS_IN_REG_PROCESS > modulecim_reg::IS_FALSE))
		                 {
		                 		$this->page = modulecim_reg::PAGE_EDITCAMPUSASSIGNMENT;
                       		$this->loadEditCampusAssignment(); 
                    	  }
                    	  else 
                    	  {
		                 		$this->page = modulecim_reg::PAGE_EDITREGISTRATIONDETAILS;
                       		$this->loadEditRegistrationDetails(); 
                    	  }	                    	       
		                break;  
		                
 
		             /*
		             *  EditCampusAssignment
		             */
		            case modulecim_reg::PAGE_EDITCAMPUSASSIGNMENT:
		                //$this->CAMPUS_ID = '';
		            	 //$this->PERSON_ID = '';
		            	 $this->ASSIGNMENT_ID = '';
		            	 
		                $this->loadEditCampusAssignment( true );
		                break;     		                 
                     
                 case modulecim_reg::PAGE_DOWNLOADREPORT:
                     $this->page = modulecim_reg::PAGE_ADMINEVENTHOME;
                     $this->loadAdminEventHome();                       
                     break;
                                             
                 case modulecim_reg::PAGE_EDITFIELDVALUES:
		                 if ((isset($this->IS_IN_REG_PROCESS))&&($this->IS_IN_REG_PROCESS > modulecim_reg::IS_FALSE))
		                 {
		                 		$this->page = modulecim_reg::PAGE_PROCESSFINANCIALTRANSACTIONS;
                       		$this->loadProcessFinancialTransactions(); 
                    	  }
                    	  else 
                    	  {
		                 //    $this->page = modulecim_reg::PAGE_EDITFIELDVALUES;
		                 //    $this->loadEditFieldValues(  true ); 
			                   $this->page = modulecim_reg::PAGE_EDITREGISTRATIONDETAILS;	            
				                $this->loadEditRegistrationDetails( );		                
                    	  }                 

// 	                   $this->page = modulecim_reg::PAGE_PROCESSFINANCIALTRANSACTIONS;	            
// 		                $this->loadProcessFinancialTransactions( );                        
                     break;
                     
                     
	             /*
	             *  ProcessCashTransaction
	             */
	            case modulecim_reg::PAGE_PROCESSCASHTRANSACTION:
	                $this->loadProcessCashTransaction(  true );
	                break;
	                
	                
	            /*
	             *  ProcessCCTransaction
	             */
	            case modulecim_reg::PAGE_PROCESSCCTRANSACTION:
	                $this->loadProcessCCTransaction( true );
	                break;
	                
	            /*
	             *  ProcessFinancialTransactions
	             */
	            case modulecim_reg::PAGE_PROCESSFINANCIALTRANSACTIONS:
         
                   $this->CASHTRANS_ID = '';
//                   $this->CCTRANS_ID = '';
//                   $this->REG_ID = '';
                   
//                    echo "<pre>".print_r($_POST, true)."</pre>";
	
                        // go to credit card trans. receipt page if CC transactions entered                
	                if (isset($_POST['cctransaction_cardNum']))
	                {
		                $this->CCTRANS_ID = '';
							 $this->page = modulecim_reg::PAGE_DISPLAYCCTRANSACTIONRECEIPT;
	                   $this->loadDisplayCCtransactionReceipt();	               
                   }
                   else
                   {
	                   $this->page = modulecim_reg::PAGE_PROCESSFINANCIALTRANSACTIONS;	            
		                $this->loadProcessFinancialTransactions( true );	         
	                }           
	                break;                      
                     
                     
//               case modulecim_reg::PAGE_EDITFIELDVALUES:
//                   $this->FIELDVALUE_ID = '';
//                   $this->page = modulecim_reg::PAGE_PROCESSFINANCIALTRANSACTIONS;
//                   $this->loadProcessFinancialTransactions();                       
//                   break;
                  
            case modulecim_reg::PAGE_CONFIRMCANCELREGISTRATION:
            	$this->REG_ID = '';

               $this->page = modulecim_reg::PAGE_REG_HOME;
               $this->loadReg_Home();	                                      
               break;      
                  
            case modulecim_reg::PAGE_PERSONRECORDCLEANUP_FORM:
            	$this->PERSON_ID = '';
            	
//             	echo "POST array = <pre>".print_r($_POST,true)."</pre>";
            	$firstName_filter = $_POST['person_fname'];
            	$lastName_filter = $_POST['person_lname'];
            	$email_filter = $_POST['person_email'];
            	$script_runtime = $_POST['script_timeout'];

               $this->page = modulecim_reg::PAGE_PERSONRECORDCLEANUP;
               $this->loadPersonRecordCleanUp($firstName_filter, $lastName_filter, $email_filter, $script_runtime);	                                      
               break;   
               
                              
          case modulecim_reg::PAGE_EMAILCOMPOSER:
//           		$emailParamArray = array();
//             	$emailParamArray['to_email'] = $_POST['to_email'];	// most likely an array of addresses
//             	$emailParamArray['from_email'] = $_POST['from_email'];
//             	$emailParamArray['email_subject'] = $_POST['email_subject'];  
//             	$emailParamArray['email_body'] = $_POST['email_body'];  
            	          
               $this->page = modulecim_reg::PAGE_EMAILCOMPOSER;
               $this->loadEmailComposer(true);	//, $emailParamArray);	                                      
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
	function prepareDisplayData( $error_refresh = false )  
	{
		  $this->pageDisplay->setIsErrorRefresh($error_refresh);
        $content = $this->pageDisplay->getHTML();
		  $this->pageDisplay->setIsErrorRefresh(false);	// reset flag
        $error_msg = $this->pageDisplay->getErrorMessage();
        
        $this->pageCommonDisplay->setEventID($this->EVENT_ID);

        // wrap current page's html in the common html of the module
        $content = $this->pageCommonDisplay->getHTML( $content, $error_msg );    
 

        // store HTML content as this page's content Item
        $this->addContent( $content );
        
        // add the sidebar content
        if (isset($this->sideBar))
        {
        		$sideBarContent = $this->sideBar->getHTML();
        		$this->addSideBarContent( $sideBarContent );
     		}          
         
        // Add any necessary javascripts for this page:
        switch( $this->page ) {
        
/*[RAD_PAGE_JAVASCRIPTS]*/
             case modulecim_reg::PAGE_EMAILCOMPOSER:
                $this->addScript('MM_jumpMenu.jsp');
                break;                              
//             case modulecim_hrdb::PAGE_DEFAULT:
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
            $callBack = modulecim_reg::PAGE.'='.$page;
        }
        
        if ($sortBy != '') {
            if ($callBack != '') {
                $callBack .= '&';
            }
            $callBack .= modulecim_reg::SORTBY.'='.$sortBy;
        }
        
        
        if ( isset( $parameters['EVENT_ID']) ) {
            if ( $parameters['EVENT_ID'] != '' ) {
                if ($callBack != '') {
                    $callBack .= '&';
                }
                $callBack .= modulecim_reg::EVENT_ID.'='.$parameters['EVENT_ID'];
            }
        }

        if ( isset( $parameters['FIELDTYPE_ID']) ) {
            if ( $parameters['FIELDTYPE_ID'] != '' ) {
                if ($callBack != '') {
                    $callBack .= '&';
                }
                $callBack .= modulecim_reg::FIELDTYPE_ID.'='.$parameters['FIELDTYPE_ID'];
            }
        }

        if ( isset( $parameters['PRICERULETYPE_ID']) ) {
            if ( $parameters['PRICERULETYPE_ID'] != '' ) {
                if ($callBack != '') {
                    $callBack .= '&';
                }
                $callBack .= modulecim_reg::PRICERULETYPE_ID.'='.$parameters['PRICERULETYPE_ID'];
            }
        }

        if ( isset( $parameters['CCTYPE_ID']) ) {
            if ( $parameters['CCTYPE_ID'] != '' ) {
                if ($callBack != '') {
                    $callBack .= '&';
                }
                $callBack .= modulecim_reg::CCTYPE_ID.'='.$parameters['CCTYPE_ID'];
            }
        }

        if ( isset( $parameters['PRIV_ID']) ) {
            if ( $parameters['PRIV_ID'] != '' ) {
                if ($callBack != '') {
                    $callBack .= '&';
                }
                $callBack .= modulecim_reg::PRIV_ID.'='.$parameters['PRIV_ID'];
            }
        }

        if ( isset( $parameters['VIEWER_ID']) ) {
            if ( $parameters['VIEWER_ID'] != '' ) {
                if ($callBack != '') {
                    $callBack .= '&';
                }
                $callBack .= modulecim_reg::VIEWER_ID.'='.$parameters['VIEWER_ID'];
            }
        }

        if ( isset( $parameters['SUPERADMIN_ID']) ) {
            if ( $parameters['SUPERADMIN_ID'] != '' ) {
                if ($callBack != '') {
                    $callBack .= '&';
                }
                $callBack .= modulecim_reg::SUPERADMIN_ID.'='.$parameters['SUPERADMIN_ID'];
            }
        }

        if ( isset( $parameters['EVENTADMIN_ID']) ) {
            if ( $parameters['EVENTADMIN_ID'] != '' ) {
                if ($callBack != '') {
                    $callBack .= '&';
                }
                $callBack .= modulecim_reg::EVENTADMIN_ID.'='.$parameters['EVENTADMIN_ID'];
            }
        }

        if ( isset( $parameters['FIELD_ID']) ) {
            if ( $parameters['FIELD_ID'] != '' ) {
                if ($callBack != '') {
                    $callBack .= '&';
                }
                $callBack .= modulecim_reg::FIELD_ID.'='.$parameters['FIELD_ID'];
            }
        }

        if ( isset( $parameters['DATATYPE_ID']) ) {
            if ( $parameters['DATATYPE_ID'] != '' ) {
                if ($callBack != '') {
                    $callBack .= '&';
                }
                $callBack .= modulecim_reg::DATATYPE_ID.'='.$parameters['DATATYPE_ID'];
            }
        }

        if ( isset( $parameters['PRICERULE_ID']) ) {
            if ( $parameters['PRICERULE_ID'] != '' ) {
                if ($callBack != '') {
                    $callBack .= '&';
                }
                $callBack .= modulecim_reg::PRICERULE_ID.'='.$parameters['PRICERULE_ID'];
            }
        }

        if ( isset( $parameters['CAMPUSACCESS_ID']) ) {
            if ( $parameters['CAMPUSACCESS_ID'] != '' ) {
                if ($callBack != '') {
                    $callBack .= '&';
                }
                $callBack .= modulecim_reg::CAMPUSACCESS_ID.'='.$parameters['CAMPUSACCESS_ID'];
            }
        }

        if ( isset( $parameters['CASHTRANS_ID']) ) {
            if ( $parameters['CASHTRANS_ID'] != '' ) {
                if ($callBack != '') {
                    $callBack .= '&';
                }
                $callBack .= modulecim_reg::CASHTRANS_ID.'='.$parameters['CASHTRANS_ID'];
            }
        }

        if ( isset( $parameters['CCTRANS_ID']) ) {
            if ( $parameters['CCTRANS_ID'] != '' ) {
                if ($callBack != '') {
                    $callBack .= '&';
                }
                $callBack .= modulecim_reg::CCTRANS_ID.'='.$parameters['CCTRANS_ID'];
            }
        }

        if ( isset( $parameters['REG_ID']) ) {
            if ( $parameters['REG_ID'] != '' ) {
                if ($callBack != '') {
                    $callBack .= '&';
                }
                $callBack .= modulecim_reg::REG_ID.'='.$parameters['REG_ID'];
            }
        }

        if ( isset( $parameters['FIELDVALUE_ID']) ) {
            if ( $parameters['FIELDVALUE_ID'] != '' ) {
                if ($callBack != '') {
                    $callBack .= '&';
                }
                $callBack .= modulecim_reg::FIELDVALUE_ID.'='.$parameters['FIELDVALUE_ID'];
            }
        }

        if ( isset( $parameters['SCHOLARSHIP_ID']) ) {
            if ( $parameters['SCHOLARSHIP_ID'] != '' ) {
                if ($callBack != '') {
                    $callBack .= '&';
                }
                $callBack .= modulecim_reg::SCHOLARSHIP_ID.'='.$parameters['SCHOLARSHIP_ID'];
            }
        }

        if ( isset( $parameters['STATUS_ID']) ) {
            if ( $parameters['STATUS_ID'] != '' ) {
                if ($callBack != '') {
                    $callBack .= '&';
                }
                $callBack .= modulecim_reg::STATUS_ID.'='.$parameters['STATUS_ID'];
            }
        }

        if ( isset( $parameters['CAMPUS_ID']) ) {
            if ( $parameters['CAMPUS_ID'] != '' ) {
                if ($callBack != '') {
                    $callBack .= '&';
                }
                $callBack .= modulecim_reg::CAMPUS_ID.'='.$parameters['CAMPUS_ID'];
            }
        }

        if ( isset( $parameters['PERSON_ID']) ) {
            if ( $parameters['PERSON_ID'] != '' ) {
                if ($callBack != '') {
                    $callBack .= '&';
                }
                $callBack .= modulecim_reg::PERSON_ID.'='.$parameters['PERSON_ID'];
            }
        }
        
         if ( isset( $parameters['ASSIGNMENT_ID']) ) {
            if ( $parameters['ASSIGNMENT_ID'] != '' ) {
                if ($callBack != '') {
                    $callBack .= '&';
                }
                $callBack .= modulecim_reg::ASSIGNMENT_ID.'='.$parameters['ASSIGNMENT_ID'];
            }
        }
        
         if ( isset( $parameters['ASSIGNSTATUS_ID']) ) {
            if ( $parameters['ASSIGNSTATUS_ID'] != '' ) {
                if ($callBack != '') {
                    $callBack .= '&';
                }
                $callBack .= modulecim_reg::ASSIGNSTATUS_ID.'='.$parameters['ASSIGNSTATUS_ID'];
            }
        }     
        
         if ( isset( $parameters['DOWNLOAD_TYPE']) ) {
            if ( $parameters['DOWNLOAD_TYPE'] != '' ) {
                if ($callBack != '') {
                    $callBack .= '&';
                }
                $callBack .= modulecim_reg::DOWNLOAD_TYPE.'='.$parameters['DOWNLOAD_TYPE'];
            }
        }      
        
          if ( isset( $parameters['IS_IN_REG_PROCESS']) ) {
            if ( $parameters['IS_IN_REG_PROCESS'] != '' ) {
                if ($callBack != '') {
                    $callBack .= '&';
                }
                $callBack .= modulecim_reg::IS_IN_REG_PROCESS.'='.$parameters['IS_IN_REG_PROCESS'];
            }
        }                   
                    

        if ( isset( $parameters['RECEIPT_ID']) ) {
            if ( $parameters['RECEIPT_ID'] != '' ) {
                if ($callBack != '') {
                    $callBack .= '&';
                }
                $callBack .= modulecim_reg::RECEIPT_ID.'='.$parameters['RECEIPT_ID'];
            }
        }
        
        
       if ( isset( $parameters['IS_RECALC']) ) {
            if ( $parameters['IS_RECALC'] != '' ) {
                if ($callBack != '') {
                    $callBack .= '&';
                }
                $callBack .= modulecim_reg::IS_RECALC.'='.$parameters['IS_RECALC'];
            }
        }     
        
                      
       if ( isset( $parameters['TO_EMAIL_CHOICE']) ) {
            if ( $parameters['TO_EMAIL_CHOICE'] != '' ) {
                if ($callBack != '') {
                    $callBack .= '&';
                }
                $callBack .= modulecim_reg::TO_EMAIL_CHOICE.'='.$parameters['TO_EMAIL_CHOICE'];
            }
        }  
        
        if ( isset( $parameters['MINISTRY_ID']) ) {
            if ( $parameters['MINISTRY_ID'] != '' ) {
                if ($callBack != '') {
                    $callBack .= '&';
                }
                $callBack .= modulecim_reg::MINISTRY_ID.'='.$parameters['MINISTRY_ID'];
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
        return modulecim_reg::MULTILINGUAL_SERIES_KEY;
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
	 * function loadNotAuthorized
	 * <pre>
	 * Initializes the NotAuthorized Page.
	 * </pre>
	 * @return [void]
	 */
    function loadNotAuthorized() 
    {
        // set the pageCallBack to be without any additional parameters
        // (an AdminBox needs this so Language Switching on a page doesn't
        // pass a previous operations)
//         $parameters = array('EVENT_ID'=>$this->EVENT_ID);//[RAD_CALLBACK_PARAMS]
//         $pageCallBack = $this->getCallBack(modulecim_reg::PAGE_ADMINHOME, $this->sortBy, $parameters);
//         $this->setPageCallBack( $pageCallBack );
        
      
        		$this->pageDisplay = new page_NotAuthorized( $this->moduleRootPath, $this->viewer);    	        
	
// 	        $this->pageDisplay->setLinks( $links ); 
        
    } // end loadNotAuthorized()
    


    //************************************************************************
	/**
	 * function loadReg_home
	 * <pre>
	 * Initializes the Reg_home Page.
	 * </pre>
	 * @return [void]
	 */
    // RAD Tools: Custom style
    function loadReg_home() 
    {
        // set the pageCallBack to be without any additional parameters
        // (an AdminBox needs this so Language Switching on a page doesn't
        // pass a previous operations)
        $parameters = array('VIEWER_ID'=>$this->VIEWER_ID);//[RAD_CALLBACK_PARAMS]
        $pageCallBack = $this->getCallBack(modulecim_reg::PAGE_REG_HOME, $this->sortBy, $parameters);
        $this->setPageCallBack( $pageCallBack );
        
         // set flag for if the page is located inside the student registration process
        if ($this->IS_IN_REG_PROCESS == modulecim_reg::IS_SIGNUP) 
        {
	        $isInRegProcess = 'TRUE';
// 	        $this->IS_IN_REG_PROCESS == modulecim_reg::IS_FALSE;	//reset flag
        }
        else 
        {
	        $isInRegProcess = 'FALSE';
        }          
        
    

			// get person_id via viewer object (i.e. the logged-in user will be signed up for event)
        if ((!isset($this->PERSON_ID))||($this->PERSON_ID == ''))
        {
	        $this->PERSON_ID = $this->getPersonIDfromViewerID();
        }
        
        // get privileges for the current viewer
        $privManager = new PrivilegeManager( $this->viewer->getID() );        
        
        
        $this->pageDisplay = new page_Reg_home( $this->moduleRootPath, $this->viewer, $this->REG_ID, $this->EVENT_ID, $this->PERSON_ID, $isInRegProcess, $this->MINISTRY_ID );   
        $this->pageDisplay->isAdmin($privManager->isBasicAdmin());
        
        $links = array();
        
        if ($privManager->isBasicAdmin()==true)	// check if privilege level is high enough
        {
// 	        $this->MINISTRY_ID = 2;   /* TEST: AIA */
	        $parameters = array( 'VIEWER_ID'=>$this->VIEWER_ID);//[RAD_CALLBACK_PARAMS]
	        $link = $this->getCallBack( modulecim_reg::PAGE_ADMINHOME, '', $parameters );		//
	        $links["adminHome"] = $link;
        }
        
        $parameters = array( 'MINISTRY_ID'=>$this->MINISTRY_ID, 'EVENT_ID'=>$this->EVENT_ID);//[RAD_CALLBACK_PARAMS_EDIT]
        $viewLink = $this->getCallBack( modulecim_reg::PAGE_VIEWEVENTDETAILS, $this->sortBy, $parameters );
        $viewLink .= "&". modulecim_reg::EVENT_ID . "=";
        $links["view"] = $viewLink;

          
        $this->IS_IN_REG_PROCESS = modulecim_reg::IS_SIGNUP; 
        $this->CAMPUS_ID = $this->getCampusIDfromViewerID();
                 
        $parameters = array('MINISTRY_ID'=>$this->MINISTRY_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'IS_IN_REG_PROCESS'=>$this->IS_IN_REG_PROCESS, 'EVENT_ID'=>$this->EVENT_ID, 'PERSON_ID'=>$this->PERSON_ID); //[RAD_CALLBACK_PARAMS]
        $registerLink = $this->getCallBack(modulecim_reg::PAGE_EDITPERSONALINFO, $this->sortBy, $parameters );    
        $registerLink .= "&". modulecim_reg::EVENT_ID . "=";
        $links["register"] = $registerLink;   
        
        $links["complete"] = $registerLink;	// use registration link for 'complete registration' as well 
        
        $links["edit_reg"] = $registerLink;	// use registration link for 'edit registration' as well     
        
        // cancel registration link information
//         $parameters = array('EVENT_ID'=>$this->EVENT_ID, 'PERSON_ID'=>$this->PERSON_ID); //[RAD_CALLBACK_PARAMS]
//         $cancelLink = $this->getCallBack(modulecim_reg::PAGE_CONFIRMCANCELREGISTRATION, $this->sortBy, $parameters );  
//         $cancelLink .= "&". modulecim_reg::EVENT_ID . "=";
//         $links["cancel"] = $cancelLink;         
        
        
/*[RAD_LINK_INSERT]*/

        $this->pageDisplay->setLinks( $links );   
        //$this->previous_page = modulecim_reg::PAGE_REG_HOME; 
        
    } // end loadReg_home()
    

        // self-explanatory: system user == person to be registered (or at least get personal info changed)
    protected function getPersonIDfromViewerID()
    {
       $accessPriv = new RowManager_AccessManager();
       $accessPriv->setViewerID($this->viewer->getID());
       
       $accessPrivList = $accessPriv->getListIterator();
       $accessPrivArray = $accessPrivList->getDataList();
       
       $personID = '';
       reset($accessPrivArray);
       foreach (array_keys($accessPrivArray) as $k)
       {
       	$record = current($accessPrivArray);
       	$personID = $record['person_id'];	// can only be 1 person_id per viewer_id
       	next($accessPrivArray);
    	 }
       
       return $personID;
    }
    
        // self-explanatory: get campus ID for system user (== person to be registered, or at least get personal info changed)
    protected function getCampusIDfromViewerID()
    {
	    $campusAssign = new RowManager_AssignmentsManager();
       $accessPriv = new RowManager_AccessManager();
       $accessPriv->setViewerID($this->viewer->getID());
       
       $getCampusID = new MultiTableManager();
       $getCampusID->addRowManager($campusAssign);
       $getCampusID->addRowManager($accessPriv, new JoinPair( $campusAssign->getJoinOnPersonID(), $accessPriv->getJoinOnPersonID()));
       
       $accessPrivList = $getCampusID->getListIterator();
       $accessPrivArray = $accessPrivList->getDataList();
       
       $personID = '';
       $campusID = '';
       reset($accessPrivArray);
       foreach (array_keys($accessPrivArray) as $k)
       {
       	$record = current($accessPrivArray);
       	$campusID = $record['campus_id'];	// NOTE: there may be more than 1 but system will just use last one...
       	next($accessPrivArray);
    	 }
       
       return $campusID;
    }    


    //************************************************************************
	/**
	 * function loadAdminHome
	 * <pre>
	 * Initializes the AdminHome Page.
	 * </pre>
	 * @return [void]
	 */
    // RAD Tools: DataListTable Style
    function loadAdminHome() 
    {
        // set the pageCallBack to be without any additional parameters
        // (an AdminBox needs this so Language Switching on a page doesn't
        // pass a previous operations)
        $parameters = array('EVENT_ID'=>$this->EVENT_ID);//[RAD_CALLBACK_PARAMS]
        $pageCallBack = $this->getCallBack(modulecim_reg::PAGE_ADMINHOME, $this->sortBy, $parameters);
        $this->setPageCallBack( $pageCallBack );
        
        $privManager = new PrivilegeManager( $this->viewer->getID() );        
        if ($privManager->isBasicAdmin()==true)	// check if privilege level is high enough
        {        
        		$this->pageDisplay = new page_AdminHome( $this->moduleRootPath, $this->viewer, $this->sortBy );    
  			
	        $links = array();
	        
	/*[RAD_LINK_INSERT]*/
	
	        $parameters = array( );//[RAD_CALLBACK_PARAMS]
	        $link = $this->getCallBack( modulecim_reg::PAGE_ADMINEVENTHOME, '', $parameters );
	        $link .= "&".modulecim_reg::EVENT_ID."=";
	        $links["access"] = $link;
	
	        $parameters = array('EVENT_ID'=>$this->EVENT_ID);//[RAD_CALLBACK_PARAMS]
	        $sortByLink = $this->getCallBack( modulecim_reg::PAGE_ADMINHOME, '', $parameters );
	        $sortByLink .= "&".modulecim_reg::SORTBY."=";
	        $links["sortBy"] = $sortByLink;
	        
	        
	
	        $this->pageDisplay->setLinks( $links ); 
	        //$this->previous_page = modulecim_reg::PAGE_ADMINHOME; 
        }
        else
        {
	        $this->pageDisplay = new page_NotAuthorized($this->moduleRootPath, $this->viewer);  
        }  
        
    } // end loadAdminHome()
    
    
    
    
 
    // checks if volume rules exist and applies any that are triggered
    protected function triggerBalanceRecalculation($eventID)
    {
	    $shouldRecalculate = false;
	    $volumeRuleTriggered = false;
	    $activeRule = null;
	    $is_active = RowManager_ActiveRuleManager::IS_FALSE;
	    $is_calculated = RowManager_ActiveRuleManager::IS_TRUE;
	    
	    $eventPriceRules = new RowManager_PriceRuleManager();
	    $eventPriceRules->setEventID($eventID);
	    $eventPriceRules->setPriceRuleType(RowManager_PriceRuleTypeManager::VOLUME_RULE);
	    
	    $ruleList = $eventPriceRules->getListIterator();
	    $ruleArray = $ruleList->getDataList();
	    
// 	    echo "rules <pre>".print_r($ruleArray,true)."</pre><BR>";
	    
	    $ruleIDs = array();
	    reset($ruleArray);		// cycle through volume rules
	    foreach (array_keys($ruleArray) as $k)
	    {
		    $record = current($ruleArray);
		    	     	
	    	$volumeNeeded = $record['pricerules_value'];	 
// 	    	echo "volume needed = ".$volumeNeeded."<BR>";
	    	
	    	$activeRule = new RowManager_ActiveRuleManager($record['pricerules_id']);
	    	$is_active = $activeRule->getIsActive();
	    	$is_calculated = $activeRule->getIsRecalculated();
	    	
// 	    	echo "active, calculated = ".$is_active.", ".$is_calculated."<BR>";
	    	
	    	// if recalculation was not executed previously
			if (isset($is_calculated)&&($is_calculated != '')&&($is_calculated == RowManager_ActiveRuleManager::IS_FALSE))
			{
				$shouldRecalculate = true;
				break;
			}
			else 
			{
				$is_calculated = RowManager_ActiveRuleManager::IS_TRUE;
			}
			
			if (isset($is_active)&&($is_active == ''))
			{
				$is_active = RowManager_ActiveRuleManager::IS_FALSE;
			}

	    	
	    	// get total registrations for the current event
			$totalRegs = 0;
         $total = array();
         $summary = new RegSummaryTools();					
			$total = $summary->getCampusRegistrations( $eventID, '' , false, '', '', RowManager_RegistrationManager::STATUS_REGISTERED);
			
// 		    echo "totals <pre>".print_r($total,true)."</pre><BR>";
     					
			reset($total);
			foreach (array_keys($total) as $k)	// cycle through campus registration totals
			{
				$element = current($total);

				// check if this volume rule is triggered for current campus
				if ($element >= $volumeNeeded)
				{
					$volumeRuleTriggered = true;
					break;
				}

				next($total);
			}
// 			echo "volume triggered = ".$volumeRuleTriggered;
			

			// if a volume rule was triggered for the first time
			if (($volumeRuleTriggered == true)&&($is_active == RowManager_ActiveRuleManager::IS_FALSE))
			{
				$setRecord = array();
				$setRecord['is_active'] = RowManager_ActiveRuleManager::IS_TRUE;
				$setRecord['is_recalculated'] = RowManager_ActiveRuleManager::IS_FALSE;
				$activeRule->loadFromArray($setRecord); 
            $activeRule->updateDBTable();
            
            $volumeRuleTriggered = false;		// reset value to default
            
            $shouldRecalculate = true;
            break;
            
         }		// if a volume rule was NOT triggered while set to ACTIVE
			else if (($volumeRuleTriggered == false)&&($is_active == RowManager_ActiveRuleManager::IS_TRUE))
			{
				$setRecord = array();
				$setRecord['is_active'] = RowManager_ActiveRuleManager::IS_FALSE;
				$setRecord['is_recalculated'] = RowManager_ActiveRuleManager::IS_FALSE;
				$activeRule->loadFromArray($setRecord); 
            $activeRule->updateDBTable();
            
            $shouldRecalculate = true;
            break;
            
         }
         else if ($volumeRuleTriggered) 
         {
	         $volumeRuleTriggered = false;		// reset value to default
         }
         else		// either volume rule triggered but was already set ACTIVE or volume rule not triggered and was NOT ACTIVE
         {			// either way, don't need to recalculate	
// 				$shouldRecalculate = false;			// do NOT set flag to FALSE because it may override setting to TRUE by prev. rule
			}
			
			next($ruleArray);
		}  
		
		return $shouldRecalculate;
	}	    


    


    //************************************************************************
	/**
	 * function loadAdminEventHome
	 * <pre>
	 * Initializes the AdminEventHome Page.
	 * </pre>
	 * @return [void]
	 */
    // RAD Tools: Custom style
    function loadAdminEventHome() 
    {	
	    
	           // get privileges for the current viewer
        $privManager = new PrivilegeManager( $this->viewer->getID() );               
        if ($privManager->isBasicAdmin($this->EVENT_ID)==true)	// check if privilege level is high enough
        { 
	        $links = array();
	        
	        $parameters = array();//[RAD_CALLBACK_PARAMS]	        	        
	        
	        $link = $this->getCallBack( modulecim_reg::PAGE_ADMINHOME, '', $parameters );
		     $links["BackLink"] = $link;  
	        
	        if ($privManager->isEventAdmin($this->EVENT_ID)==true)	// check if privilege level is high enough
	        {
		    
					/** Check if recalculation link was clicked **/
					if ($this->IS_RECALC == FinancialTools::RECALC_COMPLETE)
					{
						
						// run recalculation of balance owing
						$balanceSetter = new FinancialTools();
		   			$balanceSetter->recalculateBalances($this->EVENT_ID);
		   			$this->IS_RECALC = FinancialTools::RECALC_NOTNEEDED;
		   			
		   			$eventPriceRules = new RowManager_PriceRuleManager();
					   $eventPriceRules->setEventID($this->EVENT_ID);
					   $eventPriceRules->setPriceRuleType(RowManager_PriceRuleTypeManager::VOLUME_RULE);
					   
					    $ruleList = $eventPriceRules->getListIterator();
					    $ruleArray = $ruleList->getDataList();
					    
					    $ruleIDs = array();
					    reset($ruleArray);		// cycle through volume rules
					    foreach (array_keys($ruleArray) as $k)
					    {
						    $record = current($ruleArray);	  
			    	
			    			$activeRule = new RowManager_ActiveRuleManager($record['pricerules_id']);  
							$setRecord = array();
							$setRecord['is_recalculated'] = RowManager_ActiveRuleManager::IS_TRUE;
							$activeRule->loadFromArray($setRecord); 
			            $activeRule->updateDBTable();   		
			            
			            next($ruleArray);
		            }	
					}
					
							    /**  Check if a volume rule exists; if so, check if volume rule triggered ***/
					 if ($this->triggerBalanceRecalculation($this->EVENT_ID) == true)
					 {	    
						  $this->IS_RECALC = FinancialTools::RECALC_NEEDED;
					 }
					 
				}	// end eventAdmin privilege check 1
				

				// Need to set campus-link so that summary table data can be created for download PDF link
			  $parameters = array('EVENT_ID'=>$this->EVENT_ID , 'CAMPUS_ID'=>$this->CAMPUS_ID);//[RAD_CALLBACK_PARAMS]	  
			  $campus_link = $this->getCallBack( modulecim_reg::PAGE_EDITCAMPUSREGISTRATIONS, '', $parameters );
		     $campus_link .= "&". modulecim_reg::CAMPUS_ID . "=";
		     
			  $this->pageDisplay = new page_AdminEventHome( $this->moduleRootPath, $this->viewer, $this->EVENT_ID, $this->IS_RECALC, $campus_link );    
	        
	    
	        // set the pageCallBack to be without any additional parameters
	        // (an AdminBox needs this so Language Switching on a page doesn't
	        // pass a previous operations)
	        $parameters = array('EVENT_ID'=>$this->EVENT_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID);//[RAD_CALLBACK_PARAMS]
	        $pageCallBack = $this->getCallBack(modulecim_reg::PAGE_ADMINEVENTHOME, $this->sortBy, $parameters);
	        $this->setPageCallBack( $pageCallBack );
	        
	       
	        
	        if ($privManager->isSuperAdmin()==true)	// check if privilege level is high enough
	        {
		        $parameters = array('EVENT_ID'=>$this->EVENT_ID , 'CAMPUS_ID'=>$this->CAMPUS_ID);//[RAD_CALLBACK_PARAMS]	        	        
	        
		        $link = $this->getCallBack( modulecim_reg::PAGE_EDITFIELDTYPES, '', $parameters );
		        $links["EditFieldTypes"] = $link;  
		        $link = $this->getCallBack( modulecim_reg::PAGE_EDITPRICERULETYPES, '', $parameters );
		        $links["EditPriceRuleTypes"] = $link;        
		        $link = $this->getCallBack( modulecim_reg::PAGE_EDITCREDITCARDTYPES, '', $parameters );
		        $links["EditCreditCardTypes"] = $link;   
		        $link = $this->getCallBack( modulecim_reg::PAGE_EDITPRIVILEGETYPES, '', $parameters );
		        $links["EditPrivilegeTypes"] = $link; 
		        $link = $this->getCallBack( modulecim_reg::PAGE_ADDSUPERADMIN, '', $parameters );
		        $links["AddSuperAdmins"] = $link;   
		        $link = $this->getCallBack( modulecim_reg::PAGE_EDITSTATUSES, '', $parameters );
		        $links["EditStatusTypes"] = $link;   
	        }
	        
//         	  if ($privManager->isCampusAdmin($this->EVENT_ID,null)==true)	// check if privilege level is high enough
// 	        { 	   

		        $links["CampusLink"] = $campus_link; 
// 	        }             
	
			  if ($privManager->isEventAdmin($this->EVENT_ID)==true)	// check if privilege level is high enough	 
			  {   
				  /**** NOTE: PDF generation TEMPORARILY disabled until PDF plugin added to production PHP environment ****/
				   

					/** GENERATE PDF OF SUMMARY DATA **/
					$fileName = 'summary'.rand(1,MAX_TEMP_SEED).'.pdf';
					$filePath = getcwd()."/Reports/".$fileName;	// change to '\\' for local use ?
					$linkPath = SITE_PATH_REPORTS.$fileName;
					$page_margin = 20;
					$column_widths = array();
					$column_widths[0]=0;
					$column_widths[1]=195;		//campus
					$column_widths[2]=70;		// link
					$column_widths[3]=35;		// males total
					$column_widths[4]=50; 		// females total
					$column_widths[5]=30;		// both genders total
					$column_widths[6]=70;		// cancellations
					$column_widths[7]=55;		// completed regs
					$column_widths[8]=55;		// incomplete regs
					
					$table_pdf = new PDF_Template_Table($filePath, $page_margin, $column_widths, "Registrations");
					$table_pdf->generateTable();	//(true,true);

// 				  $metaRegSummaryHeadings = $this->pageDisplay->getMetaSummaryHeadings();
				  $metaRegSummaryData = $this->pageDisplay->getMetaSummaryData();
				  $campusRegSummaryHeadings = $this->pageDisplay->getSummaryHeadings();
				  $campusRegSummaryData = $this->pageDisplay->getSummaryData();
// 				  echo 'summary data = <pre>'.print_r($campusRegSummaryData,true).'</pre>';
	
					$table_pdf->fillTable($campusRegSummaryHeadings,$metaRegSummaryData, $campusRegSummaryData,true,true);
					
					/*** Add a pie chart of campus registrations  **/
					$chart_pdf = new PDF_Template_Charts($table_pdf->getPDF());
					$event = new RowManager_EventManager($this->EVENT_ID);
					$title = 'Total Campus Registrations for '.$event->getEventName();
					$chart_width = 5;	//PDF::PAGEWIDTH_LETTER*0.5;
					$chart_height = 5;	//PDF::PAGEHEIGHT_LETTER*0.5; 	
					
// 					echo 'chart height/width = '.$chart_height.', '.$chart_height;
					
					$found_nonzero = false;
					$campus_totals = array();
					reset($campusRegSummaryData);
					foreach (array_keys($campusRegSummaryData) as $key)
					{
						$record = current($campusRegSummaryData);
						$campus_totals[$key] = $record['campusTotal'];
						if ($record['campusTotal'] > 0)
						{
							$found_nonzero = true;
						}
						next($campusRegSummaryData);
					}
// 				  echo 'campus totals data = <pre>'.print_r($campus_totals,true).'</pre>';
							
					// required to avoid divide-by-zero error when generating pie chart with no data
				  if ($found_nonzero == true) {
						$chart_pdf->createPieChart($title, $chart_width, $chart_height, $campus_totals);
					}
					$table_pdf->Output();
	
				  $link = $linkPath;
				  $links["DownloadSummary"] = $link;
				  /** <END> PDF GENERATION **/	
				  
				  $emailPageParameters = array('EVENT_ID'=>$this->EVENT_ID);//[RAD_CALLBACK_PARAMS]              
		        $email_link = $this->getCallBack( modulecim_reg::PAGE_EMAILCOMPOSER, '', $emailPageParameters );  	        
		        $links["EmailRegistrants"] = $email_link;   	  
  
				              
		        $link = $this->getCallBack( modulecim_reg::PAGE_EVENTDETAILS, '', $parameters );
		        $links["EditEventDetails"] = $link;
		        $link = $this->getCallBack( modulecim_reg::PAGE_ADDEVENTADMIN, '', $parameters );
		        $links["AddEventAdmins"] = $link;        
		        $link = $this->getCallBack( modulecim_reg::PAGE_ADDCAMPUSADMIN, '', $parameters );
		        $links["AddCampusAdmins"] = $link;  
		
		        $this->IS_RECALC = FinancialTools::RECALC_COMPLETE;
		        $recalcParams = array('IS_RECALC'=>$this->IS_RECALC, 'EVENT_ID'=>$this->EVENT_ID , 'CAMPUS_ID'=>$this->CAMPUS_ID);
		        $link = $this->getCallBack( modulecim_reg::PAGE_ADMINEVENTHOME, '', $recalcParams );
		        $links["RecalculateBalances"] = $link;           
		                         
		        $link = $this->getCallBack( modulecim_reg::PAGE_EDITFORMFIELDS, '', $parameters );
		        $links["EditEventFormFields"] = $link;     
		        $link = $this->getCallBack( modulecim_reg::PAGE_EDITPRICERULES, '', $parameters );
		        $links["EditEventPriceRules"] = $link;     
		        
		        
		        /* Output the file to be downloaded */
		/*        if (isset($this->DOWNLOAD_TYPE))	//($_REQUEST["file"]))	//		//if (isset($_REQUEST["file"])) {
		        {	
			        $fileDir = SITE_PATH_REPORTS;
			        
			        echo "Data type = ".$this->DOWNLOAD_TYPE;    
			        switch($this->DOWNLOAD_TYPE)
			        {
				        case modulecim_reg::DOWNLOAD_EVENT_DATA:    
				        		$fileName = $this->getSummaryData($this->EVENT_ID, 1);	//$_REQUEST["file"];	
				        		echo "FILE NAME = ".$fileName;					
					    		$file=$fileDir.$fileName;
					    		
		//			    		echo "headers: <pre>".print_r(headers_list(),true)."</pre><br>";
					    		
					    		// TODO: move below code out of SWITCH
					    		 header("Content-Location: ".$file);
							    header("Content-type: text/comma-separated-values");
							    header("Content-Transfer-Encoding: Binary");
							    header("Content-length: ".filesize($file));
							    header("Content-disposition: attachment; filename=\"".basename($file)."\"");
							    readfile("$file");
							    
		
					    		break;
					     case modulecim_reg::DOWNLOAD_SCHOLARSHIP_DATA:
		/*		        		$fileName = $this->getSummaryData($this->EVENT_ID, 1);	//$_REQUEST["file"];	
				        		echo "FILE NAME = ".$fileName;					
					    		$file=$fileDir.$fileName;
					    		
					    		// TODO: move below code out of SWITCH
							    header("Content-type: text/comma-separated-values");
							    header("Content-Transfer-Encoding: Binary");
							    header("Content-length: ".filesize($file));
							    header("Content-disposition: attachment; filename=\"".basename($file)."\"");
							    readfile("$file"); */
		/*			     		echo "NOT YET IMPLEMENTED";
					     		break;
					     default:
					     		break;
				     }
				     unset($this->DOWNLOAD_TYPE);
		
					} else {
					    echo "No file selected";
					} 
					/** above code gratefully modified from code found at: 
						http://www.higherpass.com/php/tutorials/File-Download-Security/1/ **/
						        
		       
		        //$this->DOWNLOAD_TYPE = modulecim_reg::DOWNLOAD_EVENT_DATA;
		        //$fileDownloadParameters = array('EVENT_ID'=>$this->EVENT_ID , 'CAMPUS_ID'=>$this->CAMPUS_ID, 'DOWNLOAD_TYPE'=>$this->DOWNLOAD_TYPE);//[RAD_CALLBACK_PARAMS]              
		//        $link2 = SITE_PATH_MODULES.'app_'.modulecim_reg::MODULE_KEY.'/objects_pages/'.modulecim_reg::CSV_DOWNLOAD_TOOL.'?'.modulecim_reg::EVENT_ID.'='.$this->EVENT_ID.'&'.modulecim_reg::DOWNLOAD_TYPE.'='.modulecim_reg::DOWNLOAD_EVENT_DATA;	//$this->getCallBack( modulecim_reg::PAGE_ADMINEVENTHOME, '', $fileDownloadParameters );
		//        $links["EventDataDump"] = $link2;             //Event Data Dump - for importing into Excel
		
		        $this->DOWNLOAD_TYPE = modulecim_reg::DOWNLOAD_EVENT_DATA;
		        $fileDownloadParameters = array('EVENT_ID'=>$this->EVENT_ID , 'CAMPUS_ID'=>$this->CAMPUS_ID, 'DOWNLOAD_TYPE'=>$this->DOWNLOAD_TYPE);//[RAD_CALLBACK_PARAMS]              
		        $link2 = $this->getCallBack( modulecim_reg::PAGE_DOWNLOADREPORT, '', $fileDownloadParameters );
		        $links["EventDataDump"] = $link2;             //Event Data Dump - for importing into Excel        
		        
		        $this->DOWNLOAD_TYPE = modulecim_reg::DOWNLOAD_SCHOLARSHIP_DATA;
		        $fileDownloadParameters = array('EVENT_ID'=>$this->EVENT_ID , 'CAMPUS_ID'=>$this->CAMPUS_ID, 'DOWNLOAD_TYPE'=>$this->DOWNLOAD_TYPE);//[RAD_CALLBACK_PARAMS]              
		        $link3 = $this->getCallBack( modulecim_reg::PAGE_DOWNLOADREPORT, '', $fileDownloadParameters );
		        $links["EventScholarshipList"] = $link3;             //Event Scholarship List - for importing into Excel
        	}	// end event-admin privilege check 2
	        
	/*[RAD_LINK_INSERT]*/
	        $this->pageDisplay->setLinks( $links );
	        //$this->previous_page = modulecim_reg::PAGE_ADMINEVENTHOME; 
	         		

        }
        else
        {
	        $this->pageDisplay = new page_NotAuthorized($this->moduleRootPath, $this->viewer);  
        }         

	             
        
    } // end loadAdminEventHome()
    
//     protected function getSummaryData($eventID, $campusID = '')
//     {
//     	$dataGetter = new RegSummaryTools();
//     	$fileData = $dataGetter->getCSVByCampus( $eventID, $campusID );   
//     	echo "FileData = ".$fileData; 
//     
//  		//   spreadsheet.php?file=contactdata.xls
//     

// 			// BEGIN: CODE MODIFIED FROM 'fwrite()' IN PHP.NET DOCUMENTATION    >>> TODO?: write each record as it is read
// 			
// 			$fileDir = SITE_PATH_REPORTS;	//"./download/";
// 			$fileName =  modulecim_reg::EVENT_DATA_FILE_NAME;	//"eventData.csv";		// modulecim_reg::EVENT_SCHOLARSHIP_FILE_NAME
// 			
// 			// Let's make sure the file exists and is writable first.
// 			//if (is_writable($filename)) {
// 			
// 			   // In our example we're opening $filename in append mode.
// 			   // The file pointer is at the bottom of the file hence
// 			   // that's where $somecontent will go when we fwrite() it.
// 			   if (!$handle = fopen($fileDir.$fileName, 'w')) {
// 			         echo "Cannot open file ($fileDir.$fileName)";
// 			         exit;
// 			   }
// 			
// 			   // Write $somecontent to our opened file.
// 			   if (fwrite($handle, $fileData) === FALSE) {
// 			       echo "Cannot write to file ($fileDir.$fileName)";
// 			       exit;
// 			   }
// 			  
// 			   //echo "Success, wrote ($fileData) to file ($fileName)";
// 			  
// 			   fclose($handle);
// 			
// 			//} else {
// 			//   echo "The file $filename is not writable";
// 			//}
// 			
// 		return $fileName;
// 	}		
			
			


    //************************************************************************
	/**
	 * function loadEventDetails
	 * <pre>
	 * Initializes the EventDetails Page.
	 * </pre>
	 * @return [void]
	 */
    // RAD Tools: FormSingleEntry style
    function loadEventDetails() 
    {
        // get privileges for the current viewer
        $privManager = new PrivilegeManager( $this->viewer->getID() );  
        if ($privManager->isEventAdmin($this->EVENT_ID)==true)	// check if privilege level is high enough
        {	    
		    
	        // set the pageCallBack to be without any additional parameters
	        // (an AdminBox needs this so Language Switching on a page doesn't
	        // pass a previous operations)
	        $parameters = array('EVENT_ID'=>$this->EVENT_ID);//[RAD_CALLBACK_PARAMS]
	        $pageCallBack = $this->getCallBack(modulecim_reg::PAGE_EVENTDETAILS, $this->sortBy, $parameters);
	        $this->setPageCallBack( $pageCallBack );
	        
	        
	        $parameters = array('EVENT_ID'=>$this->EVENT_ID);//[RAD_CALLBACK_PARAMS]
	        $formAction = $this->getCallBack(modulecim_reg::PAGE_EVENTDETAILS, $this->sortBy, $parameters );
	        $this->pageDisplay = new FormProcessor_EventDetails( $this->moduleRootPath, $this->viewer, $formAction, $this->EVENT_ID );//[RAD_FORMINIT_FOREIGNKEY_INIT]        
	        
 			}
 			else
        {
	        $this->pageDisplay = new page_NotAuthorized($this->moduleRootPath, $this->viewer);  
        } 
 			
        //$this->previous_page = modulecim_reg::PAGE_EVENTDETAILS;  
    } // end loadEventDetails()



    //************************************************************************
	/**
	 * function loadEditFieldTypes
	 * <pre>
	 * Initializes the EditFieldTypes Page.
	 * </pre>
	 * @param $isCreated [BOOL] "Is THIS pageDisplay object already created?"
	 * @return [void]
	 */
    // RAD Tools: AdminBox Style
    function loadEditFieldTypes( $isCreated=false ) 
    {
	    
        // get privileges for the current viewer
        $privManager = new PrivilegeManager( $this->viewer->getID() );  
        if ($privManager->isSuperAdmin()==true)	// check if privilege level is high enough
        {		    
	        
	        // compile a formAction for the adminBox
	        $parameters = array('EVENT_ID'=>$this->EVENT_ID, 'FIELDTYPE_ID'=>$this->FIELDTYPE_ID);//[RAD_CALLBACK_PARAMS]
	        $formAction = $this->getCallBack(modulecim_reg::PAGE_EDITFIELDTYPES, $this->sortBy, $parameters );
	        
	        // set the pageCallBack value.  This is used by the Language switching
	        // code
	        $this->setPageCallBack( $formAction );
	        
	        // if this pageDisplay object isn't already created then 
	        if ( !$isCreated ) {
	        
	            // create a new pageDisplay object
	            $this->pageDisplay = new FormProcessor_EditFieldTypes( $this->moduleRootPath, $this->viewer, $formAction, $this->sortBy,  $this->FIELDTYPE_ID );//[RAD_FORMINIT_FOREIGNKEY_INIT]    
	        
	        } else {
	        
	            // otherwise just update the formAction value
	            $this->pageDisplay->setFormAction( $formAction );
	        }
	        
	        $links = array();
	        
	        $parameters = array( 'EVENT_ID'=>$this->EVENT_ID, 'FIELDTYPE_ID'=>$this->FIELDTYPE_ID);//[RAD_CALLBACK_PARAMS]
	        $continueLink = $this->getCallBack( modulecim_reg::PAGE_ADMINEVENTHOME, "", $parameters );
	        $links["cont"] = $continueLink;
	
	        $parameters = array('EVENT_ID'=>$this->EVENT_ID );//[RAD_CALLBACK_PARAMS_EDIT]
	        $editLink = $this->getCallBack( modulecim_reg::PAGE_EDITFIELDTYPES, $this->sortBy, $parameters );
	        $editLink .= "&". modulecim_reg::FIELDTYPE_ID . "=";
	        $links[ "edit" ] = $editLink;
	        
	        // NOTE: delete link is same as edit link for an AdminBox
	        $links[ "del" ] = $editLink;
	
	/*[RAD_LINK_INSERT]*/
	
	        $parameters = array('EVENT_ID'=>$this->EVENT_ID, 'FIELDTYPE_ID'=>$this->FIELDTYPE_ID);//[RAD_CALLBACK_PARAMS]
	        $sortByLink = $this->getCallBack( modulecim_reg::PAGE_EDITFIELDTYPES, '', $parameters );
	        $sortByLink .= "&".modulecim_reg::SORTBY."=";
	        $links["sortBy"] = $sortByLink;
	
	        $this->pageDisplay->setLinks( $links ); 
	        //$this->previous_page = modulecim_reg::PAGE_EDITFIELDTYPES;    
        }
 			else
        {
	        $this->pageDisplay = new page_NotAuthorized($this->moduleRootPath, $this->viewer);  
        }         
        
    } // end loadEditFieldTypes()



    //************************************************************************
	/**
	 * function loadEditPriceRuleTypes
	 * <pre>
	 * Initializes the EditPriceRuleTypes Page.
	 * </pre>
	 * @param $isCreated [BOOL] "Is THIS pageDisplay object already created?"
	 * @return [void]
	 */
    // RAD Tools: AdminBox Style
    function loadEditPriceRuleTypes( $isCreated=false ) 
    {

	            // get privileges for the current viewer
        $privManager = new PrivilegeManager( $this->viewer->getID() );  
        if ($privManager->isSuperAdmin()==true)	// check if privilege level is high enough
        {	
	                
	        // compile a formAction for the adminBox
	        $parameters = array('EVENT_ID'=>$this->EVENT_ID, 'FIELDTYPE_ID'=>$this->FIELDTYPE_ID, 'PRICERULETYPE_ID'=>$this->PRICERULETYPE_ID);//[RAD_CALLBACK_PARAMS]
	        $formAction = $this->getCallBack(modulecim_reg::PAGE_EDITPRICERULETYPES, $this->sortBy, $parameters );
	        
	        // set the pageCallBack value.  This is used by the Language switching
	        // code
	        $this->setPageCallBack( $formAction );
	        
	        // if this pageDisplay object isn't already created then 
	        if ( !$isCreated ) {
	        
	            // create a new pageDisplay object
	            $this->pageDisplay = new FormProcessor_EditPriceRuleTypes( $this->moduleRootPath, $this->viewer, $formAction, $this->sortBy,  $this->PRICERULETYPE_ID );//[RAD_FORMINIT_FOREIGNKEY_INIT]    
	        
	        } else {
	        
	            // otherwise just update the formAction value
	            $this->pageDisplay->setFormAction( $formAction );
	        }
	        
	        $links = array();
	        
	        $parameters = array( 'EVENT_ID'=>$this->EVENT_ID, 'FIELDTYPE_ID'=>$this->FIELDTYPE_ID, 'PRICERULETYPE_ID'=>$this->PRICERULETYPE_ID);//[RAD_CALLBACK_PARAMS]
	        $continueLink = $this->getCallBack( modulecim_reg::PAGE_ADMINEVENTHOME, "", $parameters );
	        $links["cont"] = $continueLink;
	
	        $parameters = array('EVENT_ID'=>$this->EVENT_ID );//[RAD_CALLBACK_PARAMS_EDIT]
	        $editLink = $this->getCallBack( modulecim_reg::PAGE_EDITPRICERULETYPES, $this->sortBy, $parameters );
	        $editLink .= "&". modulecim_reg::PRICERULETYPE_ID . "=";
	        $links[ "edit" ] = $editLink;
	        
	        // NOTE: delete link is same as edit link for an AdminBox
	        $links[ "del" ] = $editLink;
	
	/*[RAD_LINK_INSERT]*/
	
	        $parameters = array('EVENT_ID'=>$this->EVENT_ID, 'FIELDTYPE_ID'=>$this->FIELDTYPE_ID, 'PRICERULETYPE_ID'=>$this->PRICERULETYPE_ID);//[RAD_CALLBACK_PARAMS]
	        $sortByLink = $this->getCallBack( modulecim_reg::PAGE_EDITPRICERULETYPES, '', $parameters );
	        $sortByLink .= "&".modulecim_reg::SORTBY."=";
	        $links["sortBy"] = $sortByLink;
	
	        $this->pageDisplay->setLinks( $links );    
	        //$this->previous_page = modulecim_reg::PAGE_EDITPRICERULETYPES;  
        }
 			else
        {
	        $this->pageDisplay = new page_NotAuthorized($this->moduleRootPath, $this->viewer);  
        } 
                
    } // end loadEditPriceRuleTypes()



    //************************************************************************
	/**
	 * function loadEditCreditCardTypes
	 * <pre>
	 * Initializes the EditCreditCardTypes Page.
	 * </pre>
	 * @param $isCreated [BOOL] "Is THIS pageDisplay object already created?"
	 * @return [void]
	 */
    // RAD Tools: AdminBox Style
    function loadEditCreditCardTypes( $isCreated=false ) 
    {
 
	    // get privileges for the current viewer
        $privManager = new PrivilegeManager( $this->viewer->getID() );  
        if ($privManager->isSuperAdmin()==true)	// check if privilege level is high enough
        {	
	               
	        // compile a formAction for the adminBox
	        $parameters = array('EVENT_ID'=>$this->EVENT_ID, 'FIELDTYPE_ID'=>$this->FIELDTYPE_ID, 'PRICERULETYPE_ID'=>$this->PRICERULETYPE_ID, 'CCTYPE_ID'=>$this->CCTYPE_ID);//[RAD_CALLBACK_PARAMS]
	        $formAction = $this->getCallBack(modulecim_reg::PAGE_EDITCREDITCARDTYPES, $this->sortBy, $parameters );
	        
	        // set the pageCallBack value.  This is used by the Language switching
	        // code
	        $this->setPageCallBack( $formAction );
	        
	        // if this pageDisplay object isn't already created then 
	        if ( !$isCreated ) {
	        
	            // create a new pageDisplay object
	            $this->pageDisplay = new FormProcessor_EditCreditCardTypes( $this->moduleRootPath, $this->viewer, $formAction, $this->sortBy,  $this->CCTYPE_ID );//[RAD_FORMINIT_FOREIGNKEY_INIT]    
	        
	        } else {
	        
	            // otherwise just update the formAction value
	            $this->pageDisplay->setFormAction( $formAction );
	        }
	        
	        $links = array();
	        
	        $parameters = array( 'EVENT_ID'=>$this->EVENT_ID, 'FIELDTYPE_ID'=>$this->FIELDTYPE_ID, 'PRICERULETYPE_ID'=>$this->PRICERULETYPE_ID, 'CCTYPE_ID'=>$this->CCTYPE_ID);//[RAD_CALLBACK_PARAMS]
	        $continueLink = $this->getCallBack( modulecim_reg::PAGE_ADMINEVENTHOME, "", $parameters );
	        $links["cont"] = $continueLink;
	
	        $parameters = array('EVENT_ID'=>$this->EVENT_ID );//[RAD_CALLBACK_PARAMS_EDIT]
	        $editLink = $this->getCallBack( modulecim_reg::PAGE_EDITCREDITCARDTYPES, $this->sortBy, $parameters );
	        $editLink .= "&". modulecim_reg::CCTYPE_ID . "=";
	        $links[ "edit" ] = $editLink;
	        
	        // NOTE: delete link is same as edit link for an AdminBox
	        $links[ "del" ] = $editLink;
	
	/*[RAD_LINK_INSERT]*/
	
	        $parameters = array('EVENT_ID'=>$this->EVENT_ID, 'FIELDTYPE_ID'=>$this->FIELDTYPE_ID, 'PRICERULETYPE_ID'=>$this->PRICERULETYPE_ID, 'CCTYPE_ID'=>$this->CCTYPE_ID);//[RAD_CALLBACK_PARAMS]
	        $sortByLink = $this->getCallBack( modulecim_reg::PAGE_EDITCREDITCARDTYPES, '', $parameters );
	        $sortByLink .= "&".modulecim_reg::SORTBY."=";
	        $links["sortBy"] = $sortByLink;
	
	        $this->pageDisplay->setLinks( $links );    
	        //$this->previous_page = modulecim_reg::PAGE_EDITCREDITCARDTYPES;  
        }
  			else
        {
	        $this->pageDisplay = new page_NotAuthorized($this->moduleRootPath, $this->viewer);  
        }        
        
    } // end loadEditCreditCardTypes()



    //************************************************************************
	/**
	 * function loadEditPrivilegeTypes
	 * <pre>
	 * Initializes the EditPrivilegeTypes Page.
	 * </pre>
	 * @param $isCreated [BOOL] "Is THIS pageDisplay object already created?"
	 * @return [void]
	 */
    // RAD Tools: AdminBox Style
    function loadEditPrivilegeTypes( $isCreated=false ) 
    {
	    
	    // get privileges for the current viewer
        $privManager = new PrivilegeManager( $this->viewer->getID() );  
        if ($privManager->isSuperAdmin()==true)	// check if privilege level is high enough
        {		    
        
	        // compile a formAction for the adminBox
	        $parameters = array('EVENT_ID'=>$this->EVENT_ID, 'FIELDTYPE_ID'=>$this->FIELDTYPE_ID, 'PRICERULETYPE_ID'=>$this->PRICERULETYPE_ID, 'CCTYPE_ID'=>$this->CCTYPE_ID, 'PRIV_ID'=>$this->PRIV_ID);//[RAD_CALLBACK_PARAMS]
	        $formAction = $this->getCallBack(modulecim_reg::PAGE_EDITPRIVILEGETYPES, $this->sortBy, $parameters );
	        
	        // set the pageCallBack value.  This is used by the Language switching
	        // code
	        $this->setPageCallBack( $formAction );
	        
	        // if this pageDisplay object isn't already created then 
	        if ( !$isCreated ) {
	        
	            // create a new pageDisplay object
	            $this->pageDisplay = new FormProcessor_EditPrivilegeTypes( $this->moduleRootPath, $this->viewer, $formAction, $this->sortBy,  $this->PRIV_ID );//[RAD_FORMINIT_FOREIGNKEY_INIT]    
	        
	        } else {
	        
	            // otherwise just update the formAction value
	            $this->pageDisplay->setFormAction( $formAction );
	        }
	        
	        $links = array();
	        
	        $parameters = array( 'EVENT_ID'=>$this->EVENT_ID, 'FIELDTYPE_ID'=>$this->FIELDTYPE_ID, 'PRICERULETYPE_ID'=>$this->PRICERULETYPE_ID, 'CCTYPE_ID'=>$this->CCTYPE_ID, 'PRIV_ID'=>$this->PRIV_ID);//[RAD_CALLBACK_PARAMS]
	        $continueLink = $this->getCallBack( modulecim_reg::PAGE_ADMINEVENTHOME, "", $parameters );
	        $links["cont"] = $continueLink;
	
	        $parameters = array('EVENT_ID'=>$this->EVENT_ID );//[RAD_CALLBACK_PARAMS_EDIT]
	        $editLink = $this->getCallBack( modulecim_reg::PAGE_EDITPRIVILEGETYPES, $this->sortBy, $parameters );
	        $editLink .= "&". modulecim_reg::PRIV_ID . "=";
	        $links[ "edit" ] = $editLink;
	        
	        // NOTE: delete link is same as edit link for an AdminBox
	        $links[ "del" ] = $editLink;
	
	/*[RAD_LINK_INSERT]*/
	
	        $parameters = array('EVENT_ID'=>$this->EVENT_ID, 'FIELDTYPE_ID'=>$this->FIELDTYPE_ID, 'PRICERULETYPE_ID'=>$this->PRICERULETYPE_ID, 'CCTYPE_ID'=>$this->CCTYPE_ID, 'PRIV_ID'=>$this->PRIV_ID);//[RAD_CALLBACK_PARAMS]
	        $sortByLink = $this->getCallBack( modulecim_reg::PAGE_EDITPRIVILEGETYPES, '', $parameters );
	        $sortByLink .= "&".modulecim_reg::SORTBY."=";
	        $links["sortBy"] = $sortByLink;
	
	        $this->pageDisplay->setLinks( $links );  
	        //$this->previous_page = modulecim_reg::PAGE_EDITPRIVILEGETYPES;  
        }  
  			else
        {
	        $this->pageDisplay = new page_NotAuthorized($this->moduleRootPath, $this->viewer);  
        }   	        
        
    } // end loadEditPrivilegeTypes()



    //************************************************************************
	/**
	 * function loadViewEventDetails
	 * <pre>
	 * Initializes the ViewEventDetails Page.
	 * </pre>
	 * @return [void]
	 */
    // RAD Tools: DataSingle Style
    function loadViewEventDetails() 
    {
    
        // set the pageCallBack to be without any additional parameters
        // (an AdminBox needs this so Language Switching on a page doesn't
        // pass a previous operations)
        $parameters = array('EVENT_ID'=>$this->EVENT_ID, 'FIELDTYPE_ID'=>$this->FIELDTYPE_ID, 'PRICERULETYPE_ID'=>$this->PRICERULETYPE_ID, 'CCTYPE_ID'=>$this->CCTYPE_ID, 'PRIV_ID'=>$this->PRIV_ID);//[RAD_CALLBACK_PARAMS]
        $pageCallBack = $this->getCallBack(modulecim_reg::PAGE_VIEWEVENTDETAILS, $this->sortBy, $parameters);
        $this->setPageCallBack( $pageCallBack );
        

        $this->pageDisplay = new page_ViewEventDetails( $this->moduleRootPath, $this->viewer, $this->EVENT_ID );
        
        $links = array();
        
        $parameters = array('FIELDTYPE_ID'=>$this->FIELDTYPE_ID, 'PRICERULETYPE_ID'=>$this->PRICERULETYPE_ID, 'CCTYPE_ID'=>$this->CCTYPE_ID, 'PRIV_ID'=>$this->PRIV_ID);//[RAD_CALLBACK_PARAMS]
        $continueLink = $this->getCallBack( modulecim_reg::PAGE_REG_HOME, "", $parameters );
        $links["cont"] = $continueLink;

/*[RAD_LINK_INSERT]*/

        $this->pageDisplay->setLinks( $links );
        //$this->previous_page = modulecim_reg::PAGE_VIEWEVENTDETAILS;   
                
    } // end loadViewEventDetails()



    //************************************************************************
	/**
	 * function loadAddSuperAdmin
	 * <pre>
	 * Initializes the AddSuperAdmin Page.
	 * </pre>
	 * @param $isCreated [BOOL] "Is THIS pageDisplay object already created?"
	 * @return [void]
	 */
    // RAD Tools: AdminBox Style
    function loadAddSuperAdmin( $isCreated=false ) 
    {
	    // get privileges for the current viewer
        $privManager = new PrivilegeManager( $this->viewer->getID() );  
        if ($privManager->isSuperAdmin()==true)	// check if privilege level is high enough
        {	    
        
	        // compile a formAction for the adminBox
	        $parameters = array('EVENT_ID'=>$this->EVENT_ID, 'FIELDTYPE_ID'=>$this->FIELDTYPE_ID, 'PRICERULETYPE_ID'=>$this->PRICERULETYPE_ID, 'CCTYPE_ID'=>$this->CCTYPE_ID, 'PRIV_ID'=>$this->PRIV_ID, 'VIEWER_ID'=>$this->VIEWER_ID, 'SUPERADMIN_ID'=>$this->SUPERADMIN_ID);//[RAD_CALLBACK_PARAMS]
	        $formAction = $this->getCallBack(modulecim_reg::PAGE_ADDSUPERADMIN, $this->sortBy, $parameters );
	
	        
	        // set the pageCallBack value.  This is used by the Language switching
	        // code
	        $this->setPageCallBack( $formAction );
	        
	        // if this pageDisplay object isn't already created then 
	        if ( !$isCreated ) {
	        
	            // create a new pageDisplay object
	            $this->pageDisplay = new FormProcessor_AddSuperAdmin( $this->moduleRootPath, $this->viewer, $formAction, $this->sortBy,  $this->SUPERADMIN_ID);// , $this->VIEWER_ID);//[RAD_FORMINIT_FOREIGNKEY_INIT]    
	        
	        } else {
	        
	            // otherwise just update the formAction value
	            $this->pageDisplay->setFormAction( $formAction );
	        }
	        
	        $links = array();
	        
	        $parameters = array( 'EVENT_ID'=>$this->EVENT_ID, 'FIELDTYPE_ID'=>$this->FIELDTYPE_ID, 'PRICERULETYPE_ID'=>$this->PRICERULETYPE_ID, 'CCTYPE_ID'=>$this->CCTYPE_ID, 'PRIV_ID'=>$this->PRIV_ID, 'VIEWER_ID'=>$this->VIEWER_ID, 'SUPERADMIN_ID'=>$this->SUPERADMIN_ID);//[RAD_CALLBACK_PARAMS]
	        $continueLink = $this->getCallBack( modulecim_reg::PAGE_ADMINEVENTHOME, "", $parameters );
	        $links["cont"] = $continueLink;
	
	        $parameters = array('EVENT_ID'=>$this->EVENT_ID );//[RAD_CALLBACK_PARAMS_EDIT]
	        $delLink = $this->getCallBack( modulecim_reg::PAGE_ADDSUPERADMIN, $this->sortBy, $parameters );
	        $delLink .= "&". modulecim_reg::SUPERADMIN_ID . "=";
	        //$links[ "edit" ] = $editLink;
	        
	        // NOTE: delete link is same as edit link for an AdminBox
	        $links[ "del" ] = $delLink;
	
	/*[RAD_LINK_INSERT]*/
	
	        $parameters = array('EVENT_ID'=>$this->EVENT_ID, 'FIELDTYPE_ID'=>$this->FIELDTYPE_ID, 'PRICERULETYPE_ID'=>$this->PRICERULETYPE_ID, 'CCTYPE_ID'=>$this->CCTYPE_ID, 'PRIV_ID'=>$this->PRIV_ID, 'VIEWER_ID'=>$this->VIEWER_ID, 'SUPERADMIN_ID'=>$this->SUPERADMIN_ID);//[RAD_CALLBACK_PARAMS]
	        $sortByLink = $this->getCallBack( modulecim_reg::PAGE_ADDSUPERADMIN, '', $parameters );
	        $sortByLink .= "&".modulecim_reg::SORTBY."=";
	        $links["sortBy"] = $sortByLink;		// TODO: sort by user name not by viewer ID
	
	        $this->pageDisplay->setLinks( $links ); 
	        //$this->previous_page = modulecim_reg::PAGE_ADDSUPERADMIN;     
        }  
  			else
        {
	        $this->pageDisplay = new page_NotAuthorized($this->moduleRootPath, $this->viewer);  
        }          
    } // end loadAddSuperAdmin()



    //************************************************************************
	/**
	 * function loadAddEventAdmin
	 * <pre>
	 * Initializes the AddEventAdmin Page.
	 * </pre>
	 * @param $isCreated [BOOL] "Is THIS pageDisplay object already created?"
	 * @return [void]
	 */
    // RAD Tools: AdminBox Style
    function loadAddEventAdmin( $isCreated=false ) 
    {
	    
	    // get privileges for the current viewer
        $privManager = new PrivilegeManager( $this->viewer->getID() );  
        if ($privManager->isEventAdmin($this->EVENT_ID)==true)	// check if privilege level is high enough
        {	 	    
        
	        // compile a formAction for the adminBox
	        $parameters = array('EVENT_ID'=>$this->EVENT_ID, 'FIELDTYPE_ID'=>$this->FIELDTYPE_ID, 'PRICERULETYPE_ID'=>$this->PRICERULETYPE_ID, 'CCTYPE_ID'=>$this->CCTYPE_ID, 'PRIV_ID'=>$this->PRIV_ID, 'VIEWER_ID'=>$this->VIEWER_ID, 'SUPERADMIN_ID'=>$this->SUPERADMIN_ID, 'EVENTADMIN_ID'=>$this->EVENTADMIN_ID);//[RAD_CALLBACK_PARAMS]
	        $formAction = $this->getCallBack(modulecim_reg::PAGE_ADDEVENTADMIN, $this->sortBy, $parameters );
	        
	        // set the pageCallBack value.  This is used by the Language switching
	        // code
	        $this->setPageCallBack( $formAction );
	        
	        // if this pageDisplay object isn't already created then 
	        if ( !$isCreated ) {
	        
	            // create a new pageDisplay object
	            $this->pageDisplay = new FormProcessor_AddEventAdmin( $this->moduleRootPath, $this->viewer, $formAction, $this->sortBy,  $this->EVENTADMIN_ID,  $this->EVENT_ID);	//, $this->VIEWER_ID);//[RAD_FORMINIT_FOREIGNKEY_INIT]    
	        
	        } else {
	        
	            // otherwise just update the formAction value
	            $this->pageDisplay->setFormAction( $formAction );
	        }
	        
	        $links = array();
	        
	        $parameters = array( 'EVENT_ID'=>$this->EVENT_ID, 'FIELDTYPE_ID'=>$this->FIELDTYPE_ID, 'PRICERULETYPE_ID'=>$this->PRICERULETYPE_ID, 'CCTYPE_ID'=>$this->CCTYPE_ID, 'PRIV_ID'=>$this->PRIV_ID, 'VIEWER_ID'=>$this->VIEWER_ID, 'SUPERADMIN_ID'=>$this->SUPERADMIN_ID, 'EVENTADMIN_ID'=>$this->EVENTADMIN_ID);//[RAD_CALLBACK_PARAMS]
	        $continueLink = $this->getCallBack( modulecim_reg::PAGE_ADMINEVENTHOME, "", $parameters );
	        $links["cont"] = $continueLink;
	
	        $parameters = array( 'EVENT_ID'=>$this->EVENT_ID );//[RAD_CALLBACK_PARAMS_EDIT]
	        $editLink = $this->getCallBack( modulecim_reg::PAGE_ADDEVENTADMIN, $this->sortBy, $parameters );
	        $editLink .= "&". modulecim_reg::EVENTADMIN_ID . "=";
	        $links[ "edit" ] = $editLink;
	        
	        // NOTE: delete link is same as edit link for an AdminBox
	        $links[ "del" ] = $editLink;
	
	/*[RAD_LINK_INSERT]*/
	
	        $parameters = array('EVENT_ID'=>$this->EVENT_ID, 'FIELDTYPE_ID'=>$this->FIELDTYPE_ID, 'PRICERULETYPE_ID'=>$this->PRICERULETYPE_ID, 'CCTYPE_ID'=>$this->CCTYPE_ID, 'PRIV_ID'=>$this->PRIV_ID, 'VIEWER_ID'=>$this->VIEWER_ID, 'SUPERADMIN_ID'=>$this->SUPERADMIN_ID, 'EVENTADMIN_ID'=>$this->EVENTADMIN_ID);//[RAD_CALLBACK_PARAMS]
	        $sortByLink = $this->getCallBack( modulecim_reg::PAGE_ADDEVENTADMIN, '', $parameters );
	        $sortByLink .= "&".modulecim_reg::SORTBY."=";
	        $links["sortBy"] = $sortByLink;
	
	        $this->pageDisplay->setLinks( $links );    
	        //$this->previous_page = modulecim_reg::PAGE_ADDEVENTADMIN;  
        }  
  			else
        {
	        $this->pageDisplay = new page_NotAuthorized($this->moduleRootPath, $this->viewer);  
        }         
    } // end loadAddEventAdmin()



    //************************************************************************
	/**
	 * function loadEditFormFields
	 * <pre>
	 * Initializes the EditFormFields Page.
	 * </pre>
	 * @param $isCreated [BOOL] "Is THIS pageDisplay object already created?"
	 * @return [void]
	 */
    // RAD Tools: AdminBox Style
    function loadEditFormFields( $isCreated=false ) 
    {
	    
	    // get privileges for the current viewer
        $privManager = new PrivilegeManager( $this->viewer->getID() );  
        if ($privManager->isEventAdmin($this->EVENT_ID)==true)	// check if privilege level is high enough
        {		    
        
	        // compile a formAction for the adminBox
	        $parameters = array('EVENT_ID'=>$this->EVENT_ID, 'FIELDTYPE_ID'=>$this->FIELDTYPE_ID, 'PRICERULETYPE_ID'=>$this->PRICERULETYPE_ID, 'CCTYPE_ID'=>$this->CCTYPE_ID, 'PRIV_ID'=>$this->PRIV_ID, 'VIEWER_ID'=>$this->VIEWER_ID, 'SUPERADMIN_ID'=>$this->SUPERADMIN_ID, 'EVENTADMIN_ID'=>$this->EVENTADMIN_ID, 'FIELD_ID'=>$this->FIELD_ID);//[RAD_CALLBACK_PARAMS]
	        $formAction = $this->getCallBack(modulecim_reg::PAGE_EDITFORMFIELDS, $this->sortBy, $parameters );
	        
	        // set the pageCallBack value.  This is used by the Language switching
	        // code
	        $this->setPageCallBack( $formAction );
	        
	        // if this pageDisplay object isn't already created then 
	        if ( !$isCreated ) {
	        
	            // create a new pageDisplay object
	            $this->pageDisplay = new FormProcessor_EditFormFields( $this->moduleRootPath, $this->viewer, $formAction, $this->sortBy,  $this->FIELD_ID , $this->EVENT_ID);//[RAD_FORMINIT_FOREIGNKEY_INIT]    
	        
	        } else {
	        
	            // otherwise just update the formAction value
	            $this->pageDisplay->setFormAction( $formAction );
	        }
	        
	        $links = array();
	        
	        $parameters = array( 'EVENT_ID'=>$this->EVENT_ID, 'FIELDTYPE_ID'=>$this->FIELDTYPE_ID, 'PRICERULETYPE_ID'=>$this->PRICERULETYPE_ID, 'CCTYPE_ID'=>$this->CCTYPE_ID, 'PRIV_ID'=>$this->PRIV_ID, 'VIEWER_ID'=>$this->VIEWER_ID, 'SUPERADMIN_ID'=>$this->SUPERADMIN_ID, 'EVENTADMIN_ID'=>$this->EVENTADMIN_ID, 'FIELD_ID'=>$this->FIELD_ID);//[RAD_CALLBACK_PARAMS]
	        $continueLink = $this->getCallBack( modulecim_reg::PAGE_ADMINEVENTHOME, "", $parameters );
	        $links["cont"] = $continueLink;
	
	        $parameters = array( 'EVENT_ID'=>$this->EVENT_ID  );//[RAD_CALLBACK_PARAMS_EDIT]
	        $editLink = $this->getCallBack( modulecim_reg::PAGE_EDITFORMFIELDS, $this->sortBy, $parameters );
	        $editLink .= "&". modulecim_reg::FIELD_ID . "=";
	        $links[ "edit" ] = $editLink;
	        
	        // NOTE: delete link is same as edit link for an AdminBox
	        $links[ "del" ] = $editLink;
	
	/*[RAD_LINK_INSERT]*/
	
	        $parameters = array('EVENT_ID'=>$this->EVENT_ID, 'FIELDTYPE_ID'=>$this->FIELDTYPE_ID, 'PRICERULETYPE_ID'=>$this->PRICERULETYPE_ID, 'CCTYPE_ID'=>$this->CCTYPE_ID, 'PRIV_ID'=>$this->PRIV_ID, 'VIEWER_ID'=>$this->VIEWER_ID, 'SUPERADMIN_ID'=>$this->SUPERADMIN_ID, 'EVENTADMIN_ID'=>$this->EVENTADMIN_ID, 'FIELD_ID'=>$this->FIELD_ID);//[RAD_CALLBACK_PARAMS]
	        $sortByLink = $this->getCallBack( modulecim_reg::PAGE_EDITFORMFIELDS, '', $parameters );
	        $sortByLink .= "&".modulecim_reg::SORTBY."=";
	        $links["sortBy"] = $sortByLink;
	
	        $this->pageDisplay->setLinks( $links );   
	        //$this->previous_page = modulecim_reg::PAGE_EDITFORMFIELDS;   
        }  
  			else
        {
	        $this->pageDisplay = new page_NotAuthorized($this->moduleRootPath, $this->viewer);  
        }         
    } // end loadEditFormFields()



    //************************************************************************
	/**
	 * function loadEditPriceRules
	 * <pre>
	 * Initializes the EditPriceRules Page.
	 * </pre>
	 * @param $isCreated [BOOL] "Is THIS pageDisplay object already created?"
	 * @return [void]
	 */
    // RAD Tools: AdminBox Style
    function loadEditPriceRules( $isCreated=false ) 
    {
	    
	    // get privileges for the current viewer
        $privManager = new PrivilegeManager( $this->viewer->getID() );  
        if ($privManager->isEventAdmin($this->EVENT_ID)==true)	// check if privilege level is high enough
        {	        
	        // compile a formAction for the adminBox
	        $parameters = array('EVENT_ID'=>$this->EVENT_ID, 'FIELDTYPE_ID'=>$this->FIELDTYPE_ID, 'PRICERULETYPE_ID'=>$this->PRICERULETYPE_ID, 'CCTYPE_ID'=>$this->CCTYPE_ID, 'PRIV_ID'=>$this->PRIV_ID, 'VIEWER_ID'=>$this->VIEWER_ID, 'SUPERADMIN_ID'=>$this->SUPERADMIN_ID, 'EVENTADMIN_ID'=>$this->EVENTADMIN_ID, 'FIELD_ID'=>$this->FIELD_ID, 'DATATYPE_ID'=>$this->DATATYPE_ID, 'PRICERULE_ID'=>$this->PRICERULE_ID);//[RAD_CALLBACK_PARAMS]
	        $formAction = $this->getCallBack(modulecim_reg::PAGE_EDITPRICERULES, $this->sortBy, $parameters );
	        
	        // set the pageCallBack value.  This is used by the Language switching
	        // code
	        $this->setPageCallBack( $formAction );
	        
	        // if this pageDisplay object isn't already created then 
	        if ( !$isCreated ) {
	        
	            // create a new pageDisplay object
	            $this->pageDisplay = new FormProcessor_EditPriceRules( $this->moduleRootPath, $this->viewer, $formAction, $this->sortBy,  $this->PRICERULE_ID , $this->EVENT_ID);//[RAD_FORMINIT_FOREIGNKEY_INIT]    
	        
	        } else {
	        
	            // otherwise just update the formAction value
	            $this->pageDisplay->setFormAction( $formAction );
	        }
	        
	        $links = array();
	        
	        $parameters = array( 'EVENT_ID'=>$this->EVENT_ID, 'FIELDTYPE_ID'=>$this->FIELDTYPE_ID, 'PRICERULETYPE_ID'=>$this->PRICERULETYPE_ID, 'CCTYPE_ID'=>$this->CCTYPE_ID, 'PRIV_ID'=>$this->PRIV_ID, 'VIEWER_ID'=>$this->VIEWER_ID, 'SUPERADMIN_ID'=>$this->SUPERADMIN_ID, 'EVENTADMIN_ID'=>$this->EVENTADMIN_ID, 'FIELD_ID'=>$this->FIELD_ID, 'DATATYPE_ID'=>$this->DATATYPE_ID, 'PRICERULE_ID'=>$this->PRICERULE_ID);//[RAD_CALLBACK_PARAMS]
	        $continueLink = $this->getCallBack( modulecim_reg::PAGE_ADMINEVENTHOME, "", $parameters );
	        $links["cont"] = $continueLink;
	
	        $parameters = array( 'EVENT_ID'=>$this->EVENT_ID );//[RAD_CALLBACK_PARAMS_EDIT]
	        $editLink = $this->getCallBack( modulecim_reg::PAGE_EDITPRICERULES, $this->sortBy, $parameters );
	        $editLink .= "&". modulecim_reg::PRICERULE_ID . "=";
	        $links[ "edit" ] = $editLink;
	        
	        // NOTE: delete link is same as edit link for an AdminBox
	        $links[ "del" ] = $editLink;
	
	/*[RAD_LINK_INSERT]*/
	
	        $parameters = array('EVENT_ID'=>$this->EVENT_ID, 'FIELDTYPE_ID'=>$this->FIELDTYPE_ID, 'PRICERULETYPE_ID'=>$this->PRICERULETYPE_ID, 'CCTYPE_ID'=>$this->CCTYPE_ID, 'PRIV_ID'=>$this->PRIV_ID, 'VIEWER_ID'=>$this->VIEWER_ID, 'SUPERADMIN_ID'=>$this->SUPERADMIN_ID, 'EVENTADMIN_ID'=>$this->EVENTADMIN_ID, 'FIELD_ID'=>$this->FIELD_ID, 'DATATYPE_ID'=>$this->DATATYPE_ID, 'PRICERULE_ID'=>$this->PRICERULE_ID);//[RAD_CALLBACK_PARAMS]
	        $sortByLink = $this->getCallBack( modulecim_reg::PAGE_EDITPRICERULES, '', $parameters );
	        $sortByLink .= "&".modulecim_reg::SORTBY."=";
	        $links["sortBy"] = $sortByLink;
	
	        $this->pageDisplay->setLinks( $links ); 
	        //$this->previous_page = modulecim_reg::PAGE_EDITPRICERULES;   
        }  
  			else
        {
	        $this->pageDisplay = new page_NotAuthorized($this->moduleRootPath, $this->viewer);  
        }  	         
        
    } // end loadEditPriceRules()



    //************************************************************************
	/**
	 * function loadAddCampusAdmin
	 * <pre>
	 * Initializes the AddCampusAdmin Page.
	 * </pre>
	 * @param $isCreated [BOOL] "Is THIS pageDisplay object already created?"
	 * @return [void]
	 */
    // RAD Tools: AdminBox Style
    function loadAddCampusAdmin( $isCreated=false ) 
    {

	    // get privileges for the current viewer
        $privManager = new PrivilegeManager( $this->viewer->getID() );  
        if ($privManager->isEventAdmin($this->EVENT_ID)==true)	// check if privilege level is high enough
        {		            
	        // compile a formAction for the adminBox
	        $parameters = array('EVENT_ID'=>$this->EVENT_ID, 'FIELDTYPE_ID'=>$this->FIELDTYPE_ID, 'PRICERULETYPE_ID'=>$this->PRICERULETYPE_ID, 'CCTYPE_ID'=>$this->CCTYPE_ID, 'PRIV_ID'=>$this->PRIV_ID, 'VIEWER_ID'=>$this->VIEWER_ID, 'SUPERADMIN_ID'=>$this->SUPERADMIN_ID, 'EVENTADMIN_ID'=>$this->EVENTADMIN_ID, 'FIELD_ID'=>$this->FIELD_ID, 'DATATYPE_ID'=>$this->DATATYPE_ID, 'PRICERULE_ID'=>$this->PRICERULE_ID, 'CAMPUSACCESS_ID'=>$this->CAMPUSACCESS_ID, 'CASHTRANS_ID'=>$this->CASHTRANS_ID, 'CCTRANS_ID'=>$this->CCTRANS_ID, 'REG_ID'=>$this->REG_ID, 'FIELDVALUE_ID'=>$this->FIELDVALUE_ID, 'SCHOLARSHIP_ID'=>$this->SCHOLARSHIP_ID);//[RAD_CALLBACK_PARAMS]
	        $formAction = $this->getCallBack(modulecim_reg::PAGE_ADDCAMPUSADMIN, $this->sortBy, $parameters );
	        
	        // set the pageCallBack value.  This is used by the Language switching
	        // code
	        $this->setPageCallBack( $formAction );
	        
	        // if this pageDisplay object isn't already created then 
	        if ( !$isCreated ) {
	        
	            // create a new pageDisplay object
	            $this->pageDisplay = new FormProcessor_AddCampusAdmin( $this->moduleRootPath, $this->viewer, $formAction, $this->sortBy,  $this->CAMPUSACCESS_ID , $this->EVENTADMIN_ID, $this->EVENT_ID);//[RAD_FORMINIT_FOREIGNKEY_INIT]    
	
	        } else {
	        
	            // otherwise just update the formAction value
	            $this->pageDisplay->setFormAction( $formAction );
	        }
	        
	        $links = array();
	        
	        $parameters = array( 'EVENT_ID'=>$this->EVENT_ID, 'FIELDTYPE_ID'=>$this->FIELDTYPE_ID, 'PRICERULETYPE_ID'=>$this->PRICERULETYPE_ID, 'CCTYPE_ID'=>$this->CCTYPE_ID, 'PRIV_ID'=>$this->PRIV_ID, 'VIEWER_ID'=>$this->VIEWER_ID, 'SUPERADMIN_ID'=>$this->SUPERADMIN_ID, 'EVENTADMIN_ID'=>$this->EVENTADMIN_ID, 'FIELD_ID'=>$this->FIELD_ID, 'DATATYPE_ID'=>$this->DATATYPE_ID, 'PRICERULE_ID'=>$this->PRICERULE_ID, 'CAMPUSACCESS_ID'=>$this->CAMPUSACCESS_ID, 'CASHTRANS_ID'=>$this->CASHTRANS_ID, 'CCTRANS_ID'=>$this->CCTRANS_ID, 'REG_ID'=>$this->REG_ID, 'FIELDVALUE_ID'=>$this->FIELDVALUE_ID, 'SCHOLARSHIP_ID'=>$this->SCHOLARSHIP_ID);//[RAD_CALLBACK_PARAMS]
	        $continueLink = $this->getCallBack( modulecim_reg::PAGE_ADMINEVENTHOME, "", $parameters );
	        $links["cont"] = $continueLink;
	
	        $parameters = array( 'EVENT_ID'=>$this->EVENT_ID );//[RAD_CALLBACK_PARAMS_EDIT]
	        $editLink = $this->getCallBack( modulecim_reg::PAGE_ADDCAMPUSADMIN, $this->sortBy, $parameters );
	        $editLink .= "&". modulecim_reg::CAMPUSACCESS_ID . "=";
	        $links[ "edit" ] = $editLink;
	        
	        // NOTE: delete link is same as edit link for an AdminBox
	        $links[ "del" ] = $editLink;
	
	/*[RAD_LINK_INSERT]*/
	
	        $parameters = array('EVENT_ID'=>$this->EVENT_ID, 'FIELDTYPE_ID'=>$this->FIELDTYPE_ID, 'PRICERULETYPE_ID'=>$this->PRICERULETYPE_ID, 'CCTYPE_ID'=>$this->CCTYPE_ID, 'PRIV_ID'=>$this->PRIV_ID, 'VIEWER_ID'=>$this->VIEWER_ID, 'SUPERADMIN_ID'=>$this->SUPERADMIN_ID, 'EVENTADMIN_ID'=>$this->EVENTADMIN_ID, 'FIELD_ID'=>$this->FIELD_ID, 'DATATYPE_ID'=>$this->DATATYPE_ID, 'PRICERULE_ID'=>$this->PRICERULE_ID, 'CAMPUSACCESS_ID'=>$this->CAMPUSACCESS_ID, 'CASHTRANS_ID'=>$this->CASHTRANS_ID, 'CCTRANS_ID'=>$this->CCTRANS_ID, 'REG_ID'=>$this->REG_ID, 'FIELDVALUE_ID'=>$this->FIELDVALUE_ID, 'SCHOLARSHIP_ID'=>$this->SCHOLARSHIP_ID);//[RAD_CALLBACK_PARAMS]
	        $sortByLink = $this->getCallBack( modulecim_reg::PAGE_ADDCAMPUSADMIN, '', $parameters );
	        $sortByLink .= "&".modulecim_reg::SORTBY."=";
	        $links["sortBy"] = $sortByLink;
	
	        $this->pageDisplay->setLinks( $links );
	        //$this->previous_page = modulecim_reg::PAGE_ADDCAMPUSADMIN;      
        }  
  			else
        {
	        $this->pageDisplay = new page_NotAuthorized($this->moduleRootPath, $this->viewer);  
        }         
    } // end loadAddCampusAdmin()



    //************************************************************************
	/**
	 * function loadEditStatuses
	 * <pre>
	 * Initializes the EditStatuses Page.
	 * </pre>
	 * @param $isCreated [BOOL] "Is THIS pageDisplay object already created?"
	 * @return [void]
	 */
    // RAD Tools: AdminBox Style
    function loadEditStatuses( $isCreated=false ) 
    {
	    // get privileges for the current viewer
        $privManager = new PrivilegeManager( $this->viewer->getID() );  
        if ($privManager->isSuperAdmin()==true)	// check if privilege level is high enough
        {	
	                
	        // compile a formAction for the adminBox
	        $parameters = array('EVENT_ID'=>$this->EVENT_ID, 'FIELDTYPE_ID'=>$this->FIELDTYPE_ID, 'PRICERULETYPE_ID'=>$this->PRICERULETYPE_ID, 'CCTYPE_ID'=>$this->CCTYPE_ID, 'PRIV_ID'=>$this->PRIV_ID, 'VIEWER_ID'=>$this->VIEWER_ID, 'SUPERADMIN_ID'=>$this->SUPERADMIN_ID, 'EVENTADMIN_ID'=>$this->EVENTADMIN_ID, 'FIELD_ID'=>$this->FIELD_ID, 'DATATYPE_ID'=>$this->DATATYPE_ID, 'PRICERULE_ID'=>$this->PRICERULE_ID, 'CAMPUSACCESS_ID'=>$this->CAMPUSACCESS_ID, 'CASHTRANS_ID'=>$this->CASHTRANS_ID, 'CCTRANS_ID'=>$this->CCTRANS_ID, 'REG_ID'=>$this->REG_ID, 'FIELDVALUE_ID'=>$this->FIELDVALUE_ID, 'SCHOLARSHIP_ID'=>$this->SCHOLARSHIP_ID, 'STATUS_ID'=>$this->STATUS_ID);//[RAD_CALLBACK_PARAMS]
	        $formAction = $this->getCallBack(modulecim_reg::PAGE_EDITSTATUSES, $this->sortBy, $parameters );
	        
	        // set the pageCallBack value.  This is used by the Language switching
	        // code
	        $this->setPageCallBack( $formAction );
	        
	        // if this pageDisplay object isn't already created then 
	        if ( !$isCreated ) {
	        
	            // create a new pageDisplay object
	            $this->pageDisplay = new FormProcessor_EditStatuses( $this->moduleRootPath, $this->viewer, $formAction, $this->sortBy,  $this->STATUS_ID );//[RAD_FORMINIT_FOREIGNKEY_INIT]    
	        
	        } else {
	        
	            // otherwise just update the formAction value
	            $this->pageDisplay->setFormAction( $formAction );
	        }
	        
	        $links = array();
	        
	        $parameters = array( 'EVENT_ID'=>$this->EVENT_ID, 'FIELDTYPE_ID'=>$this->FIELDTYPE_ID, 'PRICERULETYPE_ID'=>$this->PRICERULETYPE_ID, 'CCTYPE_ID'=>$this->CCTYPE_ID, 'PRIV_ID'=>$this->PRIV_ID, 'VIEWER_ID'=>$this->VIEWER_ID, 'SUPERADMIN_ID'=>$this->SUPERADMIN_ID, 'EVENTADMIN_ID'=>$this->EVENTADMIN_ID, 'FIELD_ID'=>$this->FIELD_ID, 'DATATYPE_ID'=>$this->DATATYPE_ID, 'PRICERULE_ID'=>$this->PRICERULE_ID, 'CAMPUSACCESS_ID'=>$this->CAMPUSACCESS_ID, 'CASHTRANS_ID'=>$this->CASHTRANS_ID, 'CCTRANS_ID'=>$this->CCTRANS_ID, 'REG_ID'=>$this->REG_ID, 'FIELDVALUE_ID'=>$this->FIELDVALUE_ID, 'SCHOLARSHIP_ID'=>$this->SCHOLARSHIP_ID, 'STATUS_ID'=>$this->STATUS_ID);//[RAD_CALLBACK_PARAMS]
	        $continueLink = $this->getCallBack( modulecim_reg::PAGE_ADMINEVENTHOME, "", $parameters );
	        $links["cont"] = $continueLink;
	
	        $parameters = array( 'EVENT_ID'=>$this->EVENT_ID);//[RAD_CALLBACK_PARAMS_EDIT]
	        $editLink = $this->getCallBack( modulecim_reg::PAGE_EDITSTATUSES, $this->sortBy, $parameters );
	        $editLink .= "&". modulecim_reg::STATUS_ID . "=";
	        $links[ "edit" ] = $editLink;
	        
	        // NOTE: delete link is same as edit link for an AdminBox
	        $links[ "del" ] = $editLink;
	
	/*[RAD_LINK_INSERT]*/
	
	        $parameters = array('EVENT_ID'=>$this->EVENT_ID, 'FIELDTYPE_ID'=>$this->FIELDTYPE_ID, 'PRICERULETYPE_ID'=>$this->PRICERULETYPE_ID, 'CCTYPE_ID'=>$this->CCTYPE_ID, 'PRIV_ID'=>$this->PRIV_ID, 'VIEWER_ID'=>$this->VIEWER_ID, 'SUPERADMIN_ID'=>$this->SUPERADMIN_ID, 'EVENTADMIN_ID'=>$this->EVENTADMIN_ID, 'FIELD_ID'=>$this->FIELD_ID, 'DATATYPE_ID'=>$this->DATATYPE_ID, 'PRICERULE_ID'=>$this->PRICERULE_ID, 'CAMPUSACCESS_ID'=>$this->CAMPUSACCESS_ID, 'CASHTRANS_ID'=>$this->CASHTRANS_ID, 'CCTRANS_ID'=>$this->CCTRANS_ID, 'REG_ID'=>$this->REG_ID, 'FIELDVALUE_ID'=>$this->FIELDVALUE_ID, 'SCHOLARSHIP_ID'=>$this->SCHOLARSHIP_ID, 'STATUS_ID'=>$this->STATUS_ID);//[RAD_CALLBACK_PARAMS]
	        $sortByLink = $this->getCallBack( modulecim_reg::PAGE_EDITSTATUSES, '', $parameters );
	        $sortByLink .= "&".modulecim_reg::SORTBY."=";
	        $links["sortBy"] = $sortByLink;
	
	        $this->pageDisplay->setLinks( $links ); 
	        //$this->previous_page = modulecim_reg::PAGE_EDITSTATUSES;     
        }  
  			else
        {
	        $this->pageDisplay = new page_NotAuthorized($this->moduleRootPath, $this->viewer);  
        }         
    } // end loadEditStatuses()



    //************************************************************************
	/**
	 * function loadHomePageEventList
	 * <pre>
	 * Initializes the HomePageEventList Page.
	 * </pre>
	 * @return [void]
	 */
    // RAD Tools: DataListTable Style
    function loadHomePageEventList() 
    {
        // set the pageCallBack to be without any additional parameters
        // (an AdminBox needs this so Language Switching on a page doesn't
        // pass a previous operations)
        $parameters = array('EVENT_ID'=>$this->EVENT_ID, 'FIELDTYPE_ID'=>$this->FIELDTYPE_ID, 'PRICERULETYPE_ID'=>$this->PRICERULETYPE_ID, 'CCTYPE_ID'=>$this->CCTYPE_ID, 'PRIV_ID'=>$this->PRIV_ID, 'VIEWER_ID'=>$this->VIEWER_ID, 'SUPERADMIN_ID'=>$this->SUPERADMIN_ID, 'EVENTADMIN_ID'=>$this->EVENTADMIN_ID, 'FIELD_ID'=>$this->FIELD_ID, 'DATATYPE_ID'=>$this->DATATYPE_ID, 'PRICERULE_ID'=>$this->PRICERULE_ID, 'CAMPUSACCESS_ID'=>$this->CAMPUSACCESS_ID, 'CASHTRANS_ID'=>$this->CASHTRANS_ID, 'CCTRANS_ID'=>$this->CCTRANS_ID, 'REG_ID'=>$this->REG_ID, 'FIELDVALUE_ID'=>$this->FIELDVALUE_ID, 'SCHOLARSHIP_ID'=>$this->SCHOLARSHIP_ID, 'STATUS_ID'=>$this->STATUS_ID);//[RAD_CALLBACK_PARAMS]
        $pageCallBack = $this->getCallBack(modulecim_reg::PAGE_HOMEPAGEEVENTLIST, $this->sortBy, $parameters);
        $this->setPageCallBack( $pageCallBack );
        
        
        $this->pageDisplay = new page_HomePageEventList( $this->moduleRootPath, $this->viewer, $this->sortBy );    
        
        $links = array();
        
/*[RAD_LINK_INSERT]*/

        $parameters = array('EVENT_ID'=>$this->EVENT_ID, 'FIELDTYPE_ID'=>$this->FIELDTYPE_ID, 'PRICERULETYPE_ID'=>$this->PRICERULETYPE_ID, 'CCTYPE_ID'=>$this->CCTYPE_ID, 'PRIV_ID'=>$this->PRIV_ID, 'VIEWER_ID'=>$this->VIEWER_ID, 'SUPERADMIN_ID'=>$this->SUPERADMIN_ID, 'EVENTADMIN_ID'=>$this->EVENTADMIN_ID, 'FIELD_ID'=>$this->FIELD_ID, 'DATATYPE_ID'=>$this->DATATYPE_ID, 'PRICERULE_ID'=>$this->PRICERULE_ID, 'CAMPUSACCESS_ID'=>$this->CAMPUSACCESS_ID, 'CASHTRANS_ID'=>$this->CASHTRANS_ID, 'CCTRANS_ID'=>$this->CCTRANS_ID, 'REG_ID'=>$this->REG_ID, 'FIELDVALUE_ID'=>$this->FIELDVALUE_ID, 'SCHOLARSHIP_ID'=>$this->SCHOLARSHIP_ID, 'STATUS_ID'=>$this->STATUS_ID);//[RAD_CALLBACK_PARAMS]
        $sortByLink = $this->getCallBack( modulecim_reg::PAGE_HOMEPAGEEVENTLIST, '', $parameters );
        $sortByLink .= "&".modulecim_reg::SORTBY."=";
        $links["sortBy"] = $sortByLink;
        
        $parameters = array( 'EVENT_ID'=>$this->EVENT_ID);//[RAD_CALLBACK_PARAMS_EDIT]
        $viewLink = $this->getCallBack( modulecim_reg::PAGE_HOMEPAGEEVENTLIST, $this->sortBy, $parameters );
        $viewLink .= "&". modulecim_reg::EVENT_ID . "=";
        $links["view"] = $viewLink;
        
        $parameters = array( 'EVENT_ID'=>$this->EVENT_ID);//[RAD_CALLBACK_PARAMS_EDIT]
        $registerLink = $this->getCallBack( modulecim_reg::PAGE_HOMEPAGEEVENTLIST, $this->sortBy, $parameters );
        $registerLink .= "&". modulecim_reg::EVENT_ID . "=";
        $links["register"] = $registerLink;        

        $this->pageDisplay->setLinks( $links ); 
        //$this->previous_page = modulecim_reg::PAGE_HOMEPAGEEVENTLIST;   
        
    } // end loadHomePageEventList()
    
 	    

    //************************************************************************
	/**
	 * function loadEditCampusRegistrations
	 * <pre>
	 * Initializes the EditCampusRegistrations Page.
	 * </pre>
	 * @return [void]
	 */
    // RAD Tools: DataListTable Style
    function loadEditCampusRegistrations() 
    {

	    // get privileges for the current viewer
        $privManager = new PrivilegeManager( $this->viewer->getID() );  
        if ($privManager->isCampusAdmin($this->EVENT_ID, $this->CAMPUS_ID)==true)	// check if privilege level is high enough
        {	
		                	 
	        // set the pageCallBack to be without any additional parameters
	        // (an AdminBox needs this so Language Switching on a page doesn't
	        // pass a previous operations)
	        // (BELOW NOTE) REMOVED REG_ID FROM LIST OF PARAMETERS, SINCE I WANT REG_ID FOR CONFIRM. E-MAIL BUT NOT TO CONFUSE OFFLINE REG PROCESS
	        $parameters = array('EVENT_ID'=>$this->EVENT_ID, 'FIELDTYPE_ID'=>$this->FIELDTYPE_ID, 'PRICERULETYPE_ID'=>$this->PRICERULETYPE_ID, 'CCTYPE_ID'=>$this->CCTYPE_ID, 'PRIV_ID'=>$this->PRIV_ID, 'VIEWER_ID'=>$this->VIEWER_ID, 'SUPERADMIN_ID'=>$this->SUPERADMIN_ID, 'EVENTADMIN_ID'=>$this->EVENTADMIN_ID, 'FIELD_ID'=>$this->FIELD_ID, 'DATATYPE_ID'=>$this->DATATYPE_ID, 'PRICERULE_ID'=>$this->PRICERULE_ID, 'CAMPUSACCESS_ID'=>$this->CAMPUSACCESS_ID, 'CASHTRANS_ID'=>$this->CASHTRANS_ID, 'CCTRANS_ID'=>$this->CCTRANS_ID, 'FIELDVALUE_ID'=>$this->FIELDVALUE_ID, 'SCHOLARSHIP_ID'=>$this->SCHOLARSHIP_ID, 'STATUS_ID'=>$this->STATUS_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID);//[RAD_CALLBACK_PARAMS]
	        $pageCallBack = $this->getCallBack(modulecim_reg::PAGE_EDITCAMPUSREGISTRATIONS, $this->sortBy, $parameters);
	        $this->setPageCallBack( $pageCallBack );
	        
	        // set flag for if the page is located inside the offline registration process
	        if ($this->IS_IN_REG_PROCESS == modulecim_reg::IS_OFFLINE_REG) 
	        {
		        $isInRegProcess = 'TRUE';
	// 	        $this->IS_IN_REG_PROCESS == modulecim_reg::IS_FALSE;	//reset flag
	        }
	        else 
	        {
		        $isInRegProcess = 'FALSE';
	        }      
	          
	        $this->IS_IN_REG_PROCESS = modulecim_reg::IS_OFFLINE_REG;    
	        // (BELOW NOTE) REMOVED REG_ID FROM LIST OF PARAMETERS, SINCE I WANT REG_ID FOR CONFIRM. E-MAIL BUT NOT TO CONFUSE OFFLINE REG PROCESS
	        $formParameters = array('IS_IN_REG_PROCESS'=>$this->IS_IN_REG_PROCESS, 'EVENT_ID'=>$this->EVENT_ID, 'FIELDTYPE_ID'=>$this->FIELDTYPE_ID, 'PRICERULETYPE_ID'=>$this->PRICERULETYPE_ID, 'CCTYPE_ID'=>$this->CCTYPE_ID, 'PRIV_ID'=>$this->PRIV_ID, 'VIEWER_ID'=>$this->VIEWER_ID, 'SUPERADMIN_ID'=>$this->SUPERADMIN_ID, 'EVENTADMIN_ID'=>$this->EVENTADMIN_ID, 'FIELD_ID'=>$this->FIELD_ID, 'DATATYPE_ID'=>$this->DATATYPE_ID, 'PRICERULE_ID'=>$this->PRICERULE_ID, 'CAMPUSACCESS_ID'=>$this->CAMPUSACCESS_ID, 'CASHTRANS_ID'=>$this->CASHTRANS_ID, 'CCTRANS_ID'=>$this->CCTRANS_ID, 'FIELDVALUE_ID'=>$this->FIELDVALUE_ID, 'SCHOLARSHIP_ID'=>$this->SCHOLARSHIP_ID, 'STATUS_ID'=>$this->STATUS_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID);//[RAD_CALLBACK_PARAMS]
	        $formAction = $this->getCallBack(modulecim_reg::PAGE_EDITPERSONALINFO, $this->sortBy, $formParameters );               
	        //$formAction,
	        
	        $this->pageDisplay = new page_EditCampusRegistrations( $this->moduleRootPath, $this->viewer,  $formAction, $this->sortBy, $this->EVENT_ID, $this->CAMPUS_ID, $isInRegProcess, $this->REG_ID );    
	        
	        $links = array();
	        $this->REG_ID = '';		// reset registration ID so that offline reg. process is not confused
	        
	        // links for downloading CSV reports (campus-specific)
	        $this->DOWNLOAD_TYPE = modulecim_reg::DOWNLOAD_EVENT_DATA;
	        $fileDownloadParameters = array('EVENT_ID'=>$this->EVENT_ID , 'CAMPUS_ID'=>$this->CAMPUS_ID, 'DOWNLOAD_TYPE'=>$this->DOWNLOAD_TYPE);//[RAD_CALLBACK_PARAMS]              
	        $link2 = $this->getCallBack( modulecim_reg::PAGE_DOWNLOADREPORT, '', $fileDownloadParameters );
	        $links["CampusEventDataDump"] = $link2;             //Event Data Dump - for importing into Excel        
	        
	        $this->DOWNLOAD_TYPE = modulecim_reg::DOWNLOAD_SCHOLARSHIP_DATA;
	        $fileDownloadParameters = array('EVENT_ID'=>$this->EVENT_ID , 'CAMPUS_ID'=>$this->CAMPUS_ID, 'DOWNLOAD_TYPE'=>$this->DOWNLOAD_TYPE);//[RAD_CALLBACK_PARAMS]              
	        $link3 = $this->getCallBack( modulecim_reg::PAGE_DOWNLOADREPORT, '', $fileDownloadParameters );
	        $links["CampusEventScholarshipList"] = $link3;             //Event Scholarship List - for importing into Excel     
	        
	        
	        // regular links
	        $emailPageParameters = array('EVENT_ID'=>$this->EVENT_ID , 'CAMPUS_ID'=>$this->CAMPUS_ID);//[RAD_CALLBACK_PARAMS]              
	        $link4 = $this->getCallBack( modulecim_reg::PAGE_EMAILCOMPOSER, '', $emailPageParameters );  	        
	        $links["EmailCampusRegistrants"] = $link4;   	        
	        
	        $parameters = array( 'EVENT_ID'=>$this->EVENT_ID);	//, 'FIELDTYPE_ID'=>$this->FIELDTYPE_ID, 'PRICERULETYPE_ID'=>$this->PRICERULETYPE_ID, 'CCTYPE_ID'=>$this->CCTYPE_ID, 'PRIV_ID'=>$this->PRIV_ID, 'VIEWER_ID'=>$this->VIEWER_ID, 'SUPERADMIN_ID'=>$this->SUPERADMIN_ID, 'EVENTADMIN_ID'=>$this->EVENTADMIN_ID, 'FIELD_ID'=>$this->FIELD_ID, 'DATATYPE_ID'=>$this->DATATYPE_ID, 'PRICERULE_ID'=>$this->PRICERULE_ID, 'CAMPUSACCESS_ID'=>$this->CAMPUSACCESS_ID, 'CASHTRANS_ID'=>$this->CASHTRANS_ID, 'CCTRANS_ID'=>$this->CCTRANS_ID, 'REG_ID'=>$this->REG_ID, 'FIELDVALUE_ID'=>$this->FIELDVALUE_ID, 'SCHOLARSHIP_ID'=>$this->SCHOLARSHIP_ID, 'STATUS_ID'=>$this->STATUS_ID);	//, 'CAMPUS_ID'=>$this->CAMPUS_ID);//[RAD_CALLBACK_PARAMS]
	        $continueLink = $this->getCallBack( modulecim_reg::PAGE_ADMINEVENTHOME, "", $parameters );
	        $links["cont"] = $continueLink;
	        
	        $parameters = array( 'EVENT_ID'=>$this->EVENT_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID);//[RAD_CALLBACK_PARAMS_EDIT]		
	        
	        														
	        $editLink = $this->getCallBack( modulecim_reg::PAGE_EDITREGISTRATIONDETAILS, $this->sortBy, $parameters );
	        $editLink .= "&". modulecim_reg::REG_ID . "=";
	        $links[ "edit" ] = $editLink;
	        
	        // NOTE: delete link is same as edit link for an AdminBox: but not in this case, since we point to confirm page
	        $delLink = $this->getCallBack( modulecim_reg::PAGE_CONFIRMDELETEREGISTRATION, $this->sortBy, $parameters );
	        $delLink .= "&". modulecim_reg::REG_ID . "=";
	        $links[ "del" ] = $delLink;
	
	/*[RAD_LINK_INSERT]*/
	
	        $parameters = array('EVENT_ID'=>$this->EVENT_ID, 'FIELDTYPE_ID'=>$this->FIELDTYPE_ID, 'PRICERULETYPE_ID'=>$this->PRICERULETYPE_ID, 'CCTYPE_ID'=>$this->CCTYPE_ID, 'PRIV_ID'=>$this->PRIV_ID, 'VIEWER_ID'=>$this->VIEWER_ID, 'SUPERADMIN_ID'=>$this->SUPERADMIN_ID, 'EVENTADMIN_ID'=>$this->EVENTADMIN_ID, 'FIELD_ID'=>$this->FIELD_ID, 'DATATYPE_ID'=>$this->DATATYPE_ID, 'PRICERULE_ID'=>$this->PRICERULE_ID, 'CAMPUSACCESS_ID'=>$this->CAMPUSACCESS_ID, 'CASHTRANS_ID'=>$this->CASHTRANS_ID, 'CCTRANS_ID'=>$this->CCTRANS_ID, 'REG_ID'=>$this->REG_ID, 'FIELDVALUE_ID'=>$this->FIELDVALUE_ID, 'SCHOLARSHIP_ID'=>$this->SCHOLARSHIP_ID, 'STATUS_ID'=>$this->STATUS_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID);//[RAD_CALLBACK_PARAMS]
	        $sortByLink = $this->getCallBack( modulecim_reg::PAGE_EDITCAMPUSREGISTRATIONS, '', $parameters );
	        $sortByLink .= "&".modulecim_reg::SORTBY."=";
	        $links["sortBy"] = $sortByLink;
	
	        $this->pageDisplay->setLinks( $links ); 
	//        $this->previous_page = modulecim_reg::PAGE_EDITCAMPUSREGISTRATIONS; 
	//        echo "prev page = ".$this->previous_page;
        }  
  			else
        {
	        $this->pageDisplay = new page_NotAuthorized($this->moduleRootPath, $this->viewer);  
        }             
    } // end loadEditCampusRegistrations()



    //************************************************************************
	/**
	 * function loadConfirmDeleteRegistration
	 * <pre>
	 * Initializes the ConfirmDeleteRegistration Page.
	 * </pre>
	 * @return [void]
	 */
    // RAD Tools: DeleteConf Style
    function loadConfirmDeleteRegistration() 
    {
	    
	    // if event-id is missing, use reg-id to find it
	    if ((!isset($this->EVENT_ID)||($this->EVENT_ID == '')) && ($this->REG_ID != ''))
	    {
		    $eventFinder = new RowManager_RegistrationManager($this->REG_ID);
		    $this->EVENT_ID = $eventFinder->getEventID();		    
	    }
	    
	    // if campus-id is missing, use person-id to find it
	    if ((!isset($this->CAMPUS_ID)||($this->CAMPUS_ID == '')) && ($this->PERSON_ID != ''))
	    {
		    $campusFinder = new RowManager_EditCampusAssignmentManager();
		    $campusFinder->setPersonID($this->PERSON_ID);
		    $campusList = $campusFinder->getListIterator();
		    $campusArray = $campusList->getDataList();
// 		    echo 'campus array = <pre>'.print_r($campusArray,true).'</pre>';
		    
		    // pick the first campus found		 
		    $record = current($campusArray);   
		    $this->CAMPUS_ID = $record['campus_id'];    
	    }	    

	    // get privileges for the current viewer
        $privManager = new PrivilegeManager( $this->viewer->getID() );  
        if ($privManager->isCampusAdmin($this->EVENT_ID, $this->CAMPUS_ID)==true)	// check if privilege level is high enough
        {		    
		    
	        // set the pageCallBack to be without any additional parameters
	        // (an AdminBox needs this so Language Switching on a page doesn't
	        // pass a previous operations)
	        $parameters = array('EVENT_ID'=>$this->EVENT_ID, 'FIELDTYPE_ID'=>$this->FIELDTYPE_ID, 'PRICERULETYPE_ID'=>$this->PRICERULETYPE_ID, 'CCTYPE_ID'=>$this->CCTYPE_ID, 'PRIV_ID'=>$this->PRIV_ID, 'VIEWER_ID'=>$this->VIEWER_ID, 'SUPERADMIN_ID'=>$this->SUPERADMIN_ID, 'EVENTADMIN_ID'=>$this->EVENTADMIN_ID, 'FIELD_ID'=>$this->FIELD_ID, 'DATATYPE_ID'=>$this->DATATYPE_ID, 'PRICERULE_ID'=>$this->PRICERULE_ID, 'CAMPUSACCESS_ID'=>$this->CAMPUSACCESS_ID, 'CASHTRANS_ID'=>$this->CASHTRANS_ID, 'CCTRANS_ID'=>$this->CCTRANS_ID, 'REG_ID'=>$this->REG_ID, 'FIELDVALUE_ID'=>$this->FIELDVALUE_ID, 'SCHOLARSHIP_ID'=>$this->SCHOLARSHIP_ID, 'STATUS_ID'=>$this->STATUS_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID);//[RAD_CALLBACK_PARAMS]
	        $pageCallBack = $this->getCallBack(modulecim_reg::PAGE_CONFIRMDELETEREGISTRATION, $this->sortBy, $parameters);
	        $this->setPageCallBack( $pageCallBack );
	        
	        
	        $parameters = array('EVENT_ID'=>$this->EVENT_ID, 'FIELDTYPE_ID'=>$this->FIELDTYPE_ID, 'PRICERULETYPE_ID'=>$this->PRICERULETYPE_ID, 'CCTYPE_ID'=>$this->CCTYPE_ID, 'PRIV_ID'=>$this->PRIV_ID, 'VIEWER_ID'=>$this->VIEWER_ID, 'SUPERADMIN_ID'=>$this->SUPERADMIN_ID, 'EVENTADMIN_ID'=>$this->EVENTADMIN_ID, 'FIELD_ID'=>$this->FIELD_ID, 'DATATYPE_ID'=>$this->DATATYPE_ID, 'PRICERULE_ID'=>$this->PRICERULE_ID, 'CAMPUSACCESS_ID'=>$this->CAMPUSACCESS_ID, 'CASHTRANS_ID'=>$this->CASHTRANS_ID, 'CCTRANS_ID'=>$this->CCTRANS_ID, 'REG_ID'=>$this->REG_ID, 'FIELDVALUE_ID'=>$this->FIELDVALUE_ID, 'SCHOLARSHIP_ID'=>$this->SCHOLARSHIP_ID, 'STATUS_ID'=>$this->STATUS_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID);//[RAD_CALLBACK_PARAMS]
	        $formAction = $this->getCallBack(modulecim_reg::PAGE_CONFIRMDELETEREGISTRATION, $this->sortBy, $parameters );
	        $this->pageDisplay = new page_ConfirmDeleteRegistration( $this->moduleRootPath, $this->viewer, $formAction, $this->REG_ID );
	            
	        //$this->previous_page = modulecim_reg::PAGE_CONFIRMDELETEREGISTRATION; 
         }  
  			else
        {
	        $this->pageDisplay = new page_NotAuthorized($this->moduleRootPath, $this->viewer);  
        }              
    } // end loadConfirmDeleteRegistration()
    
    
    //************************************************************************
	/**
	 * function loadEditRegistrationDetails
	 * <pre>
	 * Initializes the EditRegistrationDetails Page.
	 * </pre>
	 * @return [void]
	 */
    // RAD Tools: <not used>
    function loadEditRegistrationDetails($isCreated=false ) 
    {
	    
	    // if event-id is missing, use reg-id to find it
	    if ((!isset($this->EVENT_ID)||($this->EVENT_ID == '')) && ($this->REG_ID != ''))
	    {
		    $eventFinder = new RowManager_RegistrationManager($this->REG_ID);
		    $this->EVENT_ID = $eventFinder->getEventID();		    
	    }
	    
	    // if campus-id is missing, use person-id to find it
	    if ((!isset($this->CAMPUS_ID)||($this->CAMPUS_ID == '')) && ($this->PERSON_ID != ''))
	    {
		    $campusFinder = new RowManager_EditCampusAssignmentManager();
		    $campusFinder->setPersonID($this->PERSON_ID);
		    $campusList = $campusFinder->getListIterator();
		    $campusArray = $campusList->getDataList();
// 		    echo 'campus array = <pre>'.print_r($campusArray,true).'</pre>';
		    
		    // pick the first campus found		 
		    $record = current($campusArray);   
		    $this->CAMPUS_ID = $record['campus_id'];    
	    }	 
		    

	    // get privileges for the current viewer
        $privManager = new PrivilegeManager( $this->viewer->getID() );  
        if ($privManager->isCampusAdmin($this->EVENT_ID, $this->CAMPUS_ID)==true)	// check if privilege level is high enough
        {		    
		    
		    //template-specific sections for jumping to
		    $SCHOLARSHIPS = '#Scholarships';
		    $CASHTRANS = '#CashTransactions';
		    $CCTRANS = '#ccTransactions';
		    $EVENTINFO = '#EventInfo';
		    
	        // set the pageCallBack to be without any additional parameters
	        // (an AdminBox needs this so Language Switching on a page doesn't
	        // pass a previous operations)
	 //       echo "SCHOLARSHIP_ID, CASHTRANS_ID, CCTRANS_ID = ".$this->SCHOLARSHIP_ID." ".$this->CASHTRANS_ID." ".$this->CCTRANS_ID."<BR>";
	        
	        $parameters = array('EVENT_ID'=>$this->EVENT_ID, 'FIELDTYPE_ID'=>$this->FIELDTYPE_ID, 'PRICERULETYPE_ID'=>$this->PRICERULETYPE_ID, 'CCTYPE_ID'=>$this->CCTYPE_ID, 'PRIV_ID'=>$this->PRIV_ID, 'VIEWER_ID'=>$this->VIEWER_ID, 'SUPERADMIN_ID'=>$this->SUPERADMIN_ID, 'EVENTADMIN_ID'=>$this->EVENTADMIN_ID, 'FIELD_ID'=>$this->FIELD_ID, 'DATATYPE_ID'=>$this->DATATYPE_ID, 'PRICERULE_ID'=>$this->PRICERULE_ID, 'CAMPUSACCESS_ID'=>$this->CAMPUSACCESS_ID, 'CASHTRANS_ID'=>$this->CASHTRANS_ID, 'CCTRANS_ID'=>$this->CCTRANS_ID, 'REG_ID'=>$this->REG_ID, 'FIELDVALUE_ID'=>$this->FIELDVALUE_ID, 'SCHOLARSHIP_ID'=>$this->SCHOLARSHIP_ID, 'STATUS_ID'=>$this->STATUS_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID);//[RAD_CALLBACK_PARAMS]
	        $scholarship_parameters = array('EVENT_ID'=>$this->EVENT_ID, 'PRIV_ID'=>$this->PRIV_ID, 'VIEWER_ID'=>$this->VIEWER_ID, 'SUPERADMIN_ID'=>$this->SUPERADMIN_ID, 'EVENTADMIN_ID'=>$this->EVENTADMIN_ID, 'REG_ID'=>$this->REG_ID, 'SCHOLARSHIP_ID'=>$this->SCHOLARSHIP_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID);//[RAD_CALLBACK_PARAMS]
	        $cashtrans_parameters = array('EVENT_ID'=>$this->EVENT_ID, 'PRIV_ID'=>$this->PRIV_ID, 'VIEWER_ID'=>$this->VIEWER_ID, 'SUPERADMIN_ID'=>$this->SUPERADMIN_ID, 'EVENTADMIN_ID'=>$this->EVENTADMIN_ID, 'CASHTRANS_ID'=>$this->CASHTRANS_ID, 'REG_ID'=>$this->REG_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID);//[RAD_CALLBACK_PARAMS]
	        $cctrans_parameters = array('EVENT_ID'=>$this->EVENT_ID, 'CCTYPE_ID'=>$this->CCTYPE_ID, 'PRIV_ID'=>$this->PRIV_ID, 'VIEWER_ID'=>$this->VIEWER_ID, 'SUPERADMIN_ID'=>$this->SUPERADMIN_ID, 'EVENTADMIN_ID'=>$this->EVENTADMIN_ID, 'CCTRANS_ID'=>$this->CCTRANS_ID, 'REG_ID'=>$this->REG_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID);//[RAD_CALLBACK_PARAMS]
	        $fieldvals_parameters = array('EVENT_ID'=>$this->EVENT_ID, 'CCTYPE_ID'=>$this->CCTYPE_ID, 'PRIV_ID'=>$this->PRIV_ID, 'VIEWER_ID'=>$this->VIEWER_ID, 'SUPERADMIN_ID'=>$this->SUPERADMIN_ID, 'EVENTADMIN_ID'=>$this->EVENTADMIN_ID, 'CCTRANS_ID'=>$this->CCTRANS_ID, 'REG_ID'=>$this->REG_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'PERSON_ID'=>$this->PERSON_ID, 'FIELD_ID'=>$this->FIELD_ID, 'FIELDVALUE_ID'=>$this->FIELDVALUE_ID);//[RAD_CALLBACK_PARAMS]
	
	        
	        $pageCallBack = $this->getCallBack(modulecim_reg::PAGE_EDITREGISTRATIONDETAILS, $this->sortBy, $parameters);
	        $this->setPageCallBack( $pageCallBack );
	        
	        $formAction = $this->getCallBack(modulecim_reg::PAGE_EDITREGISTRATIONDETAILS, $this->sortBy, $parameters );
	        $scholarship_formAction = $this->getCallBack(modulecim_reg::PAGE_EDITREGISTRATIONDETAILS, $this->sortBy, $scholarship_parameters );
	        $cashTrans_formAction = $this->getCallBack(modulecim_reg::PAGE_EDITREGISTRATIONDETAILS, $this->sortBy, $cashtrans_parameters );
	        $ccTrans_formAction = $this->getCallBack(modulecim_reg::PAGE_EDITREGISTRATIONDETAILS, $this->sortBy, $cctrans_parameters );
	        $fieldvals_formAction = $this->getCallBack(modulecim_reg::PAGE_EDITREGISTRATIONDETAILS, $this->sortBy, $fieldvals_parameters );
	
	        
	        // if this pageDisplay object isn't already created then 
	        if ( !$isCreated ) {
	        
	            // create a new pageDisplay object
	        		$this->pageDisplay = new page_EditRegistrationDetails( $this->moduleRootPath, $this->viewer, $this->sortBy, $this->REG_ID, $this->EVENT_ID, $this->CAMPUS_ID, $this->SCHOLARSHIP_ID, $this->CASHTRANS_ID, $this->CCTRANS_ID, $formAction, $scholarship_formAction, $cashTrans_formAction, $ccTrans_formAction, $fieldvals_formAction, $this->PERSON_ID, $this->FIELDVALUE_ID, $this->FIELD_ID );   
	        
	        } else {
	        
	            // otherwise just update the formAction value
	            $this->pageDisplay->setFormAction( $formAction, $scholarship_formAction, $cashTrans_formAction, $ccTrans_formAction, $fieldvals_formAction );
	        }   
	                          
	        
	        $links = array();
	        
	        $this->IS_IN_REG_PROCESS = modulecim_reg::IS_FALSE;
	        $parameters = array( 'IS_IN_REG_PROCESS'=>$this->IS_IN_REG_PROCESS, 'EVENT_ID'=>$this->EVENT_ID, 'FIELDTYPE_ID'=>$this->FIELDTYPE_ID, 'PRICERULETYPE_ID'=>$this->PRICERULETYPE_ID, 'CCTYPE_ID'=>$this->CCTYPE_ID, 'PRIV_ID'=>$this->PRIV_ID, 'VIEWER_ID'=>$this->VIEWER_ID, 'SUPERADMIN_ID'=>$this->SUPERADMIN_ID, 'EVENTADMIN_ID'=>$this->EVENTADMIN_ID, 'FIELD_ID'=>$this->FIELD_ID, 'DATATYPE_ID'=>$this->DATATYPE_ID, 'PRICERULE_ID'=>$this->PRICERULE_ID, 'CAMPUSACCESS_ID'=>$this->CAMPUSACCESS_ID, 'CASHTRANS_ID'=>$this->CASHTRANS_ID, 'CCTRANS_ID'=>$this->CCTRANS_ID, 'REG_ID'=>$this->REG_ID, 'FIELDVALUE_ID'=>$this->FIELDVALUE_ID, 'SCHOLARSHIP_ID'=>$this->SCHOLARSHIP_ID, 'STATUS_ID'=>$this->STATUS_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID);//[RAD_CALLBACK_PARAMS]
	        $continueLink = $this->getCallBack( modulecim_reg::PAGE_EDITCAMPUSREGISTRATIONS, "", $parameters );
	        $links["cont"] = $continueLink;
	
	        // set edit personal info link
	        $editLink = $this->getCallBack(modulecim_reg::PAGE_EDITPERSONALINFO, $this->sortBy, $parameters );  
	        $editLink .= "&". modulecim_reg::PERSON_ID . "=";                                
	        $links["EditPersonInfo"] = $editLink;
	        
	        /**** SCHOLARSHIP SUB-PAGE LINKS INIT ***/
	        $scholarshipLinks = array();
	        
	        $parameters = array('EVENT_ID'=>$this->EVENT_ID, 'FIELDTYPE_ID'=>$this->FIELDTYPE_ID, 'PRICERULETYPE_ID'=>$this->PRICERULETYPE_ID, 'CCTYPE_ID'=>$this->CCTYPE_ID, 'PRIV_ID'=>$this->PRIV_ID, 'VIEWER_ID'=>$this->VIEWER_ID, 'SUPERADMIN_ID'=>$this->SUPERADMIN_ID, 'EVENTADMIN_ID'=>$this->EVENTADMIN_ID, 'FIELD_ID'=>$this->FIELD_ID, 'DATATYPE_ID'=>$this->DATATYPE_ID, 'PRICERULE_ID'=>$this->PRICERULE_ID, 'CAMPUSACCESS_ID'=>$this->CAMPUSACCESS_ID, 'CASHTRANS_ID'=>$this->CASHTRANS_ID, 'CCTRANS_ID'=>$this->CCTRANS_ID, 'REG_ID'=>$this->REG_ID, 'FIELDVALUE_ID'=>$this->FIELDVALUE_ID, 'SCHOLARSHIP_ID'=>$this->SCHOLARSHIP_ID, 'STATUS_ID'=>$this->STATUS_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID);//[RAD_CALLBACK_PARAMS]
	//        $parameters = array( 'REG_ID'=>$this->REG_ID );//[RAD_CALLBACK_PARAMS_EDIT]
	        $editLink = $this->getCallBack( modulecim_reg::PAGE_EDITREGISTRATIONDETAILS, $this->sortBy, $parameters );
	        $editLink .= "&". modulecim_reg::SCHOLARSHIP_ID . "=";
	        $scholarshipLinks[ "edit" ] = $editLink;
	        
	        // NOTE: delete link is same as edit link for an AdminBox
	        $scholarshipLinks[ "del" ] = $editLink;
	
	        $parameters = array('EVENT_ID'=>$this->EVENT_ID, 'FIELDTYPE_ID'=>$this->FIELDTYPE_ID, 'PRICERULETYPE_ID'=>$this->PRICERULETYPE_ID, 'CCTYPE_ID'=>$this->CCTYPE_ID, 'PRIV_ID'=>$this->PRIV_ID, 'VIEWER_ID'=>$this->VIEWER_ID, 'SUPERADMIN_ID'=>$this->SUPERADMIN_ID, 'EVENTADMIN_ID'=>$this->EVENTADMIN_ID, 'FIELD_ID'=>$this->FIELD_ID, 'DATATYPE_ID'=>$this->DATATYPE_ID, 'PRICERULE_ID'=>$this->PRICERULE_ID, 'CAMPUSACCESS_ID'=>$this->CAMPUSACCESS_ID, 'CASHTRANS_ID'=>$this->CASHTRANS_ID, 'CCTRANS_ID'=>$this->CCTRANS_ID, 'REG_ID'=>$this->REG_ID, 'FIELDVALUE_ID'=>$this->FIELDVALUE_ID, 'STATUS_ID'=>$this->STATUS_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID);//[RAD_CALLBACK_PARAMS]
	        $sortByLink = $this->getCallBack( modulecim_reg::PAGE_EDITREGISTRATIONDETAILS, '', $parameters );
	        $sortByLink .= "&".modulecim_reg::SORTBY."=";
	        $scholarshipLinks["sortBy"] = $sortByLink;
	        
	         /**** CASH TRANSACTIONS SUB-PAGE LINKS INIT ***/
	        $cashTransLinks = array();
	        
	        $parameters = array('EVENT_ID'=>$this->EVENT_ID, 'FIELDTYPE_ID'=>$this->FIELDTYPE_ID, 'PRICERULETYPE_ID'=>$this->PRICERULETYPE_ID, 'CCTYPE_ID'=>$this->CCTYPE_ID, 'PRIV_ID'=>$this->PRIV_ID, 'VIEWER_ID'=>$this->VIEWER_ID, 'SUPERADMIN_ID'=>$this->SUPERADMIN_ID, 'EVENTADMIN_ID'=>$this->EVENTADMIN_ID, 'FIELD_ID'=>$this->FIELD_ID, 'DATATYPE_ID'=>$this->DATATYPE_ID, 'PRICERULE_ID'=>$this->PRICERULE_ID, 'CAMPUSACCESS_ID'=>$this->CAMPUSACCESS_ID, 'CASHTRANS_ID'=>$this->CASHTRANS_ID, 'CCTRANS_ID'=>$this->CCTRANS_ID, 'REG_ID'=>$this->REG_ID, 'FIELDVALUE_ID'=>$this->FIELDVALUE_ID, 'SCHOLARSHIP_ID'=>$this->SCHOLARSHIP_ID, 'STATUS_ID'=>$this->STATUS_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID);//[RAD_CALLBACK_PARAMS]
	        $editLink = $this->getCallBack( modulecim_reg::PAGE_EDITREGISTRATIONDETAILS, $this->sortBy, $parameters );
	        $editLink .= "&". modulecim_reg::CASHTRANS_ID . "=";
	        $cashTransLinks[ "edit" ] = $editLink;
	        
	        // NOTE: delete link is same as edit link for an AdminBox
	        $cashTransLinks[ "del" ] = $editLink;
	
	        $parameters = array('EVENT_ID'=>$this->EVENT_ID, 'FIELDTYPE_ID'=>$this->FIELDTYPE_ID, 'PRICERULETYPE_ID'=>$this->PRICERULETYPE_ID, 'CCTYPE_ID'=>$this->CCTYPE_ID, 'PRIV_ID'=>$this->PRIV_ID, 'VIEWER_ID'=>$this->VIEWER_ID, 'SUPERADMIN_ID'=>$this->SUPERADMIN_ID, 'EVENTADMIN_ID'=>$this->EVENTADMIN_ID, 'FIELD_ID'=>$this->FIELD_ID, 'DATATYPE_ID'=>$this->DATATYPE_ID, 'PRICERULE_ID'=>$this->PRICERULE_ID, 'CAMPUSACCESS_ID'=>$this->CAMPUSACCESS_ID, 'CCTRANS_ID'=>$this->CCTRANS_ID, 'REG_ID'=>$this->REG_ID, 'FIELDVALUE_ID'=>$this->FIELDVALUE_ID, 'SCHOLARSHIP_ID'=>$this->SCHOLARSHIP_ID, 'STATUS_ID'=>$this->STATUS_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID);//[RAD_CALLBACK_PARAMS]
	        $sortByLink = $this->getCallBack( modulecim_reg::PAGE_EDITREGISTRATIONDETAILS, '', $parameters );
	        $sortByLink .= "&".modulecim_reg::SORTBY."=";
	        $cashTransLinks["sortBy"] = $sortByLink;
	        
	        /**** CC TRANSACTIONS SUB-PAGE LINKS INIT ***/
	        $ccTransLinks = array();
	        
	        $parameters = array('EVENT_ID'=>$this->EVENT_ID, 'FIELDTYPE_ID'=>$this->FIELDTYPE_ID, 'PRICERULETYPE_ID'=>$this->PRICERULETYPE_ID, 'CCTYPE_ID'=>$this->CCTYPE_ID, 'PRIV_ID'=>$this->PRIV_ID, 'VIEWER_ID'=>$this->VIEWER_ID, 'SUPERADMIN_ID'=>$this->SUPERADMIN_ID, 'EVENTADMIN_ID'=>$this->EVENTADMIN_ID, 'FIELD_ID'=>$this->FIELD_ID, 'DATATYPE_ID'=>$this->DATATYPE_ID, 'PRICERULE_ID'=>$this->PRICERULE_ID, 'CAMPUSACCESS_ID'=>$this->CAMPUSACCESS_ID, 'CASHTRANS_ID'=>$this->CASHTRANS_ID, 'CCTRANS_ID'=>$this->CCTRANS_ID, 'REG_ID'=>$this->REG_ID, 'FIELDVALUE_ID'=>$this->FIELDVALUE_ID, 'SCHOLARSHIP_ID'=>$this->SCHOLARSHIP_ID, 'STATUS_ID'=>$this->STATUS_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID);//[RAD_CALLBACK_PARAMS]
	        $editLink = $this->getCallBack( modulecim_reg::PAGE_EDITREGISTRATIONDETAILS, $this->sortBy, $parameters );
	        $editLink .= "&". modulecim_reg::CCTRANS_ID . "=";
	//        $ccTransLinks[ "edit" ] = $editLink;
	        
	        // NOTE: delete link is same as edit link for an AdminBox
	//        $ccTransLinks[ "del" ] = $editLink;
	
	        $parameters = array('EVENT_ID'=>$this->EVENT_ID, 'FIELDTYPE_ID'=>$this->FIELDTYPE_ID, 'PRICERULETYPE_ID'=>$this->PRICERULETYPE_ID, 'CCTYPE_ID'=>$this->CCTYPE_ID, 'PRIV_ID'=>$this->PRIV_ID, 'VIEWER_ID'=>$this->VIEWER_ID, 'SUPERADMIN_ID'=>$this->SUPERADMIN_ID, 'EVENTADMIN_ID'=>$this->EVENTADMIN_ID, 'FIELD_ID'=>$this->FIELD_ID, 'DATATYPE_ID'=>$this->DATATYPE_ID, 'PRICERULE_ID'=>$this->PRICERULE_ID, 'CAMPUSACCESS_ID'=>$this->CAMPUSACCESS_ID, 'CASHTRANS_ID'=>$this->CASHTRANS_ID, 'REG_ID'=>$this->REG_ID, 'FIELDVALUE_ID'=>$this->FIELDVALUE_ID, 'SCHOLARSHIP_ID'=>$this->SCHOLARSHIP_ID, 'STATUS_ID'=>$this->STATUS_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID);//[RAD_CALLBACK_PARAMS]
	        $sortByLink = $this->getCallBack( modulecim_reg::PAGE_EDITREGISTRATIONDETAILS, '', $parameters );
	        $sortByLink .= "&".modulecim_reg::SORTBY."=";
	        $ccTransLinks["sortBy"] = $sortByLink;        
	        
	        
	        $this->pageDisplay->setLinks( $links, $scholarshipLinks, $cashTransLinks, $ccTransLinks);       
	        //$this->previous_page = modulecim_reg::PAGE_EDITREGISTRATIONDETAILS;   
         }  
  			else
        {
	        $this->pageDisplay = new page_NotAuthorized($this->moduleRootPath, $this->viewer);  
        }                           
    } // end loadEditRegistrationDetails()


    //************************************************************************
	/**
	 * function loadEditRegistrationScholarshipList	 (loads PAGE_EDITREGISTRATIONSCHOLARSHIPLIST)
	 * <pre>
	 * Initializes the EditRegistrationScholarshipList Page.
	 * </pre>
	 * @param $isCreated [BOOL] "Is THIS pageDisplay object already created?"
	 * @return [OBJECT] the (sub-)page object
	 */
    // RAD Tools: AdminBox Style
    function loadEditRegistrationScholarshipList( $isCreated=false ) 
    {
	    // TODO:  get some sort of CampusAdmin authentication in here (without using campus ID?)
        
        // compile a formAction for the adminBox
        $parameters = array('EVENT_ID'=>$this->EVENT_ID, 'FIELDTYPE_ID'=>$this->FIELDTYPE_ID, 'PRICERULETYPE_ID'=>$this->PRICERULETYPE_ID, 'CCTYPE_ID'=>$this->CCTYPE_ID, 'PRIV_ID'=>$this->PRIV_ID, 'VIEWER_ID'=>$this->VIEWER_ID, 'SUPERADMIN_ID'=>$this->SUPERADMIN_ID, 'EVENTADMIN_ID'=>$this->EVENTADMIN_ID, 'FIELD_ID'=>$this->FIELD_ID, 'DATATYPE_ID'=>$this->DATATYPE_ID, 'PRICERULE_ID'=>$this->PRICERULE_ID, 'CAMPUSACCESS_ID'=>$this->CAMPUSACCESS_ID, 'CASHTRANS_ID'=>$this->CASHTRANS_ID, 'CCTRANS_ID'=>$this->CCTRANS_ID, 'REG_ID'=>$this->REG_ID, 'FIELDVALUE_ID'=>$this->FIELDVALUE_ID, 'SCHOLARSHIP_ID'=>$this->SCHOLARSHIP_ID, 'STATUS_ID'=>$this->STATUS_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID);//[RAD_CALLBACK_PARAMS]
        $formAction = $this->getCallBack(modulecim_reg::PAGE_EDITREGISTRATIONDETAILS, $this->sortBy, $parameters );
        
        // set the pageCallBack value.  This is used by the Language switching
        // code
        $this->setPageCallBack( $formAction );
        
        // if this pageDisplay object isn't already created then 
        if ( !$isCreated ) {
        
            // create a new pageDisplay object
            $this->pageDisplay = new FormProcessor_EditRegistrationScholarshipList( $this->moduleRootPath, $this->viewer, $formAction, $this->sortBy,  $this->SCHOLARSHIP_ID , $this->REG_ID);//[RAD_FORMINIT_FOREIGNKEY_INIT]    
        
        } else {
        
            // otherwise just update the formAction value
            $this->pageDisplay->setFormAction( $formAction );
        }
        
        $links = array();
        
        $parameters = array('EVENT_ID'=>$this->EVENT_ID, 'FIELDTYPE_ID'=>$this->FIELDTYPE_ID, 'PRICERULETYPE_ID'=>$this->PRICERULETYPE_ID, 'CCTYPE_ID'=>$this->CCTYPE_ID, 'PRIV_ID'=>$this->PRIV_ID, 'VIEWER_ID'=>$this->VIEWER_ID, 'SUPERADMIN_ID'=>$this->SUPERADMIN_ID, 'EVENTADMIN_ID'=>$this->EVENTADMIN_ID, 'FIELD_ID'=>$this->FIELD_ID, 'DATATYPE_ID'=>$this->DATATYPE_ID, 'PRICERULE_ID'=>$this->PRICERULE_ID, 'CAMPUSACCESS_ID'=>$this->CAMPUSACCESS_ID, 'CASHTRANS_ID'=>$this->CASHTRANS_ID, 'CCTRANS_ID'=>$this->CCTRANS_ID, 'REG_ID'=>$this->REG_ID, 'FIELDVALUE_ID'=>$this->FIELDVALUE_ID, 'SCHOLARSHIP_ID'=>$this->SCHOLARSHIP_ID, 'STATUS_ID'=>$this->STATUS_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID);//[RAD_CALLBACK_PARAMS]
//        $parameters = array( 'REG_ID'=>$this->REG_ID );//[RAD_CALLBACK_PARAMS_EDIT]
        $editLink = $this->getCallBack( modulecim_reg::PAGE_EDITREGISTRATIONDETAILS, $this->sortBy, $parameters );
        $editLink .= "&". modulecim_reg::SCHOLARSHIP_ID . "=";
        $links[ "edit" ] = $editLink;
        
        // NOTE: delete link is same as edit link for an AdminBox
        $links[ "del" ] = $editLink;

/*[RAD_LINK_INSERT]*/

        $parameters = array('EVENT_ID'=>$this->EVENT_ID, 'FIELDTYPE_ID'=>$this->FIELDTYPE_ID, 'PRICERULETYPE_ID'=>$this->PRICERULETYPE_ID, 'CCTYPE_ID'=>$this->CCTYPE_ID, 'PRIV_ID'=>$this->PRIV_ID, 'VIEWER_ID'=>$this->VIEWER_ID, 'SUPERADMIN_ID'=>$this->SUPERADMIN_ID, 'EVENTADMIN_ID'=>$this->EVENTADMIN_ID, 'FIELD_ID'=>$this->FIELD_ID, 'DATATYPE_ID'=>$this->DATATYPE_ID, 'PRICERULE_ID'=>$this->PRICERULE_ID, 'CAMPUSACCESS_ID'=>$this->CAMPUSACCESS_ID, 'CASHTRANS_ID'=>$this->CASHTRANS_ID, 'CCTRANS_ID'=>$this->CCTRANS_ID, 'REG_ID'=>$this->REG_ID, 'FIELDVALUE_ID'=>$this->FIELDVALUE_ID, 'SCHOLARSHIP_ID'=>$this->SCHOLARSHIP_ID, 'STATUS_ID'=>$this->STATUS_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID);//[RAD_CALLBACK_PARAMS]
        $sortByLink = $this->getCallBack( modulecim_reg::PAGE_EDITREGISTRATIONDETAILS, '', $parameters );
        $sortByLink .= "&".modulecim_reg::SORTBY."=";
        $links["sortBy"] = $sortByLink;

        $this->pageDisplay->setLinks( $links );   
        
        //$content = $this->pageDisplay->getHTML(); 
               
         return $this->pageDisplay; 
        
    } // end loadEditRegistrationScholarshipList()



    //************************************************************************
	/**
	 * function loadEditRegistrationCashTransactionsList
	 * <pre>
	 * Initializes the EditRegistrationCashTransactionsList Page.
	 * </pre>
	 * @param $isCreated [BOOL] "Is THIS pageDisplay object already created?"
	 * @return [OBJECT] (sub-)page HTML content
	 */
    // RAD Tools: AdminBox Style
    function loadEditRegistrationCashTransactionsList( $isCreated=false ) 
    {
        
        // compile a formAction for the adminBox
        $parameters = array('EVENT_ID'=>$this->EVENT_ID, 'FIELDTYPE_ID'=>$this->FIELDTYPE_ID, 'PRICERULETYPE_ID'=>$this->PRICERULETYPE_ID, 'CCTYPE_ID'=>$this->CCTYPE_ID, 'PRIV_ID'=>$this->PRIV_ID, 'VIEWER_ID'=>$this->VIEWER_ID, 'SUPERADMIN_ID'=>$this->SUPERADMIN_ID, 'EVENTADMIN_ID'=>$this->EVENTADMIN_ID, 'FIELD_ID'=>$this->FIELD_ID, 'DATATYPE_ID'=>$this->DATATYPE_ID, 'PRICERULE_ID'=>$this->PRICERULE_ID, 'CAMPUSACCESS_ID'=>$this->CAMPUSACCESS_ID, 'CASHTRANS_ID'=>$this->CASHTRANS_ID, 'CCTRANS_ID'=>$this->CCTRANS_ID, 'REG_ID'=>$this->REG_ID, 'FIELDVALUE_ID'=>$this->FIELDVALUE_ID, 'SCHOLARSHIP_ID'=>$this->SCHOLARSHIP_ID, 'STATUS_ID'=>$this->STATUS_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID);//[RAD_CALLBACK_PARAMS]
        $formAction = $this->getCallBack(modulecim_reg::PAGE_EDITREGISTRATIONCASHTRANSACTIONSLIST, $this->sortBy, $parameters );
        
        // set the pageCallBack value.  This is used by the Language switching
        // code
        $this->setPageCallBack( $formAction );
        
        // if this pageDisplay object isn't already created then 
        if ( !$isCreated ) {
        
            // create a new pageDisplay object
            $this->pageDisplay = new FormProcessor_EditRegistrationCashTransactionsList( $this->moduleRootPath, $this->viewer, $formAction, $this->sortBy,  $this->CASHTRANS_ID , $this->REG_ID);//[RAD_FORMINIT_FOREIGNKEY_INIT]    
        
        } else {
        
            // otherwise just update the formAction value
            $this->pageDisplay->setFormAction( $formAction );
        }
        
        $links = array();
        
        $parameters = array('REG_ID'=>$this->REG_ID );//[RAD_CALLBACK_PARAMS_EDIT]
        $editLink = $this->getCallBack( modulecim_reg::PAGE_EDITREGISTRATIONCASHTRANSACTIONSLIST, $this->sortBy, $parameters );
        $editLink .= "&". modulecim_reg::CASHTRANS_ID . "=";
        $links[ "edit" ] = $editLink;
        
        // NOTE: delete link is same as edit link for an AdminBox
        $links[ "del" ] = $editLink;

/*[RAD_LINK_INSERT]*/

        $parameters = array('EVENT_ID'=>$this->EVENT_ID, 'FIELDTYPE_ID'=>$this->FIELDTYPE_ID, 'PRICERULETYPE_ID'=>$this->PRICERULETYPE_ID, 'CCTYPE_ID'=>$this->CCTYPE_ID, 'PRIV_ID'=>$this->PRIV_ID, 'VIEWER_ID'=>$this->VIEWER_ID, 'SUPERADMIN_ID'=>$this->SUPERADMIN_ID, 'EVENTADMIN_ID'=>$this->EVENTADMIN_ID, 'FIELD_ID'=>$this->FIELD_ID, 'DATATYPE_ID'=>$this->DATATYPE_ID, 'PRICERULE_ID'=>$this->PRICERULE_ID, 'CAMPUSACCESS_ID'=>$this->CAMPUSACCESS_ID, 'CASHTRANS_ID'=>$this->CASHTRANS_ID, 'CCTRANS_ID'=>$this->CCTRANS_ID, 'REG_ID'=>$this->REG_ID, 'FIELDVALUE_ID'=>$this->FIELDVALUE_ID, 'SCHOLARSHIP_ID'=>$this->SCHOLARSHIP_ID, 'STATUS_ID'=>$this->STATUS_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID);//[RAD_CALLBACK_PARAMS]
        $sortByLink = $this->getCallBack( modulecim_reg::PAGE_EDITREGISTRATIONCASHTRANSACTIONSLIST, '', $parameters );
        $sortByLink .= "&".modulecim_reg::SORTBY."=";
        $links["sortBy"] = $sortByLink;

        $this->pageDisplay->setLinks( $links );
        
         $content = $this->pageDisplay->getHTML();        
         return $content;     
        
    } // end loadEditRegistrationCashTransactionsList()



    //************************************************************************
	/**
	 * function loadEditRegistrationCCTransactionsList
	 * <pre>
	 * Initializes the EditRegistrationCCTransactionsList Page.
	 * </pre>
	 * @param $isCreated [BOOL] "Is THIS pageDisplay object already created?"
	 * @return [OBJECT] (sub-)page HTML content
	 */
    // RAD Tools: AdminBox Style
    function loadEditRegistrationCCTransactionsList( $isCreated=false ) 
    {
        
        // compile a formAction for the adminBox
        $parameters = array('EVENT_ID'=>$this->EVENT_ID, 'FIELDTYPE_ID'=>$this->FIELDTYPE_ID, 'PRICERULETYPE_ID'=>$this->PRICERULETYPE_ID, 'CCTYPE_ID'=>$this->CCTYPE_ID, 'PRIV_ID'=>$this->PRIV_ID, 'VIEWER_ID'=>$this->VIEWER_ID, 'SUPERADMIN_ID'=>$this->SUPERADMIN_ID, 'EVENTADMIN_ID'=>$this->EVENTADMIN_ID, 'FIELD_ID'=>$this->FIELD_ID, 'DATATYPE_ID'=>$this->DATATYPE_ID, 'PRICERULE_ID'=>$this->PRICERULE_ID, 'CAMPUSACCESS_ID'=>$this->CAMPUSACCESS_ID, 'CASHTRANS_ID'=>$this->CASHTRANS_ID, 'CCTRANS_ID'=>$this->CCTRANS_ID, 'REG_ID'=>$this->REG_ID, 'FIELDVALUE_ID'=>$this->FIELDVALUE_ID, 'SCHOLARSHIP_ID'=>$this->SCHOLARSHIP_ID, 'STATUS_ID'=>$this->STATUS_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID);//[RAD_CALLBACK_PARAMS]
        $formAction = $this->getCallBack(modulecim_reg::PAGE_EDITREGISTRATIONCCTRANSACTIONSLIST, $this->sortBy, $parameters );
        
        // set the pageCallBack value.  This is used by the Language switching
        // code
        $this->setPageCallBack( $formAction );
        
        // if this pageDisplay object isn't already created then 
        if ( !$isCreated ) {
        
            // create a new pageDisplay object
            $this->pageDisplay = new FormProcessor_EditRegistrationCCTransactionsList( $this->moduleRootPath, $this->viewer, $formAction, $this->sortBy,  $this->CCTRANS_ID , $this->REG_ID);//[RAD_FORMINIT_FOREIGNKEY_INIT]    
        
        } else {
        
            // otherwise just update the formAction value
            $this->pageDisplay->setFormAction( $formAction );
        }
        
        $links = array();
        
        $parameters = array( 'REG_ID'=>$this->REG_ID);//[RAD_CALLBACK_PARAMS_EDIT]
        $editLink = $this->getCallBack( modulecim_reg::PAGE_EDITREGISTRATIONCCTRANSACTIONSLIST, $this->sortBy, $parameters );
        $editLink .= "&". modulecim_reg::CCTRANS_ID . "=";
        $links[ "edit" ] = $editLink;
        
        // NOTE: delete link is same as edit link for an AdminBox
        $links[ "del" ] = $editLink;

/*[RAD_LINK_INSERT]*/

        $parameters = array('EVENT_ID'=>$this->EVENT_ID, 'FIELDTYPE_ID'=>$this->FIELDTYPE_ID, 'PRICERULETYPE_ID'=>$this->PRICERULETYPE_ID, 'CCTYPE_ID'=>$this->CCTYPE_ID, 'PRIV_ID'=>$this->PRIV_ID, 'VIEWER_ID'=>$this->VIEWER_ID, 'SUPERADMIN_ID'=>$this->SUPERADMIN_ID, 'EVENTADMIN_ID'=>$this->EVENTADMIN_ID, 'FIELD_ID'=>$this->FIELD_ID, 'DATATYPE_ID'=>$this->DATATYPE_ID, 'PRICERULE_ID'=>$this->PRICERULE_ID, 'CAMPUSACCESS_ID'=>$this->CAMPUSACCESS_ID, 'CASHTRANS_ID'=>$this->CASHTRANS_ID, 'CCTRANS_ID'=>$this->CCTRANS_ID, 'REG_ID'=>$this->REG_ID, 'FIELDVALUE_ID'=>$this->FIELDVALUE_ID, 'SCHOLARSHIP_ID'=>$this->SCHOLARSHIP_ID, 'STATUS_ID'=>$this->STATUS_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID);//[RAD_CALLBACK_PARAMS]
        $sortByLink = $this->getCallBack( modulecim_reg::PAGE_EDITREGISTRATIONCCTRANSACTIONSLIST, '', $parameters );
        $sortByLink .= "&".modulecim_reg::SORTBY."=";
        $links["sortBy"] = $sortByLink;

        $this->pageDisplay->setLinks( $links ); 
        
        $content = $this->pageDisplay->getHTML();        
        return $content;    
        
    } // end loadEditRegistrationCCTransactionsList()



    //************************************************************************
	/**
	 * function loadEditRegistrationFieldValuesForm
	 * <pre>
	 * Initializes the EditRegistrationFieldValuesForm Page.
	 * </pre>
	 * @return [OBJECT] (sub-)page HTML content
	 */
    // RAD Tools: FormSingleEntry style
    function loadEditRegistrationFieldValuesForm() 
    {
	    /**** OLD DATA IS COMMENTED OUT BECAUSE I REPLACED RAD-TOOL GENERATED CODE WITH MY OWN TEMPLATE  (HSMIT) ***/
	    
        // set the pageCallBack to be without any additional parameters
        // (an AdminBox needs this so Language Switching on a page doesn't
        // pass a previous operations)
/*        $parameters = array('EVENT_ID'=>$this->EVENT_ID, 'FIELDTYPE_ID'=>$this->FIELDTYPE_ID, 'PRICERULETYPE_ID'=>$this->PRICERULETYPE_ID, 'CCTYPE_ID'=>$this->CCTYPE_ID, 'PRIV_ID'=>$this->PRIV_ID, 'VIEWER_ID'=>$this->VIEWER_ID, 'SUPERADMIN_ID'=>$this->SUPERADMIN_ID, 'EVENTADMIN_ID'=>$this->EVENTADMIN_ID, 'FIELD_ID'=>$this->FIELD_ID, 'DATATYPE_ID'=>$this->DATATYPE_ID, 'PRICERULE_ID'=>$this->PRICERULE_ID, 'CAMPUSACCESS_ID'=>$this->CAMPUSACCESS_ID, 'CASHTRANS_ID'=>$this->CASHTRANS_ID, 'CCTRANS_ID'=>$this->CCTRANS_ID, 'REG_ID'=>$this->REG_ID, 'FIELDVALUE_ID'=>$this->FIELDVALUE_ID, 'SCHOLARSHIP_ID'=>$this->SCHOLARSHIP_ID, 'STATUS_ID'=>$this->STATUS_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID);//[RAD_CALLBACK_PARAMS]
        $pageCallBack = $this->getCallBack(modulecim_reg::PAGE_EDITREGISTRATIONFIELDVALUESFORM, $this->sortBy, $parameters);
        $this->setPageCallBack( $pageCallBack );
        
        
        $parameters = array('EVENT_ID'=>$this->EVENT_ID, 'FIELDTYPE_ID'=>$this->FIELDTYPE_ID, 'PRICERULETYPE_ID'=>$this->PRICERULETYPE_ID, 'CCTYPE_ID'=>$this->CCTYPE_ID, 'PRIV_ID'=>$this->PRIV_ID, 'VIEWER_ID'=>$this->VIEWER_ID, 'SUPERADMIN_ID'=>$this->SUPERADMIN_ID, 'EVENTADMIN_ID'=>$this->EVENTADMIN_ID, 'FIELD_ID'=>$this->FIELD_ID, 'DATATYPE_ID'=>$this->DATATYPE_ID, 'PRICERULE_ID'=>$this->PRICERULE_ID, 'CAMPUSACCESS_ID'=>$this->CAMPUSACCESS_ID, 'CASHTRANS_ID'=>$this->CASHTRANS_ID, 'CCTRANS_ID'=>$this->CCTRANS_ID, 'REG_ID'=>$this->REG_ID, 'FIELDVALUE_ID'=>$this->FIELDVALUE_ID, 'SCHOLARSHIP_ID'=>$this->SCHOLARSHIP_ID, 'STATUS_ID'=>$this->STATUS_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID);//[RAD_CALLBACK_PARAMS]
        $formAction = $this->getCallBack(modulecim_reg::PAGE_EDITREGISTRATIONFIELDVALUESFORM, $this->sortBy, $parameters );
        $this->pageDisplay = new FormProcessor_EditRegistrationFieldValuesForm( $this->moduleRootPath, $this->viewer, $formAction, $this->FIELDVALUE_ID , $this->REG_ID);//[RAD_FORMINIT_FOREIGNKEY_INIT]        
*/

			$form = new FormHelper();
			$this->loadFieldValuesForm($form);
			$formOne = new Template( SITE_PATH_TEMPLATES );
			$formOne->set('disableHeading', true);
			// $formOne->set('disableFormTag', true);
			$formOne->set('form', $form);
			
			
        // now initialize the labels for this page
        // start by loading the default field labels for this Module
        $languageID = $this->viewer->getLanguageID();
        $seriesKey = modulecim_reg::MULTILINGUAL_SERIES_KEY;
        $pageKey = modulecim_reg::MULTILINGUAL_PAGE_FIELDS;
        $this->labels = new MultilingualManager( $languageID, $seriesKey, $pageKey );
        
        // then load the page specific labels for this page
        $pageKey = FormProcessor_EditRegistrationScholarshipList::MULTILINGUAL_PAGE_KEY;
        $this->labels->loadPageLabels( $pageKey );
        
        // load the site default form link labels
        $this->labels->setSeriesKey( SITE_LABEL_SERIES_SITE );
        $this->labels->loadPageLabels( SITE_LABEL_PAGE_FORM_LINKS );
        
        $this->labels->loadPageLabels( SITE_LABEL_PAGE_FORMERRORS );
         			
						
//			$labels = new MultiLingual_Labels( GPC_SITE_LABEL, GPC_SERIES_LABEL, TEMPLATE_REG_PERSON_DETAILS, $langID );
			$formOne->set('labels', $this->labels );   
			$formOneContent = $formOne->fetch( TEMPLATE_GENERIC_FORM );
//			$pageContent->set('formOneContent', $formOneContent ); 


//        $content = $this->pageDisplay->getHTML();        
        return $formOneContent; 
                  
    } // end loadEditRegistrationFieldValuesForm()



    //************************************************************************
	/**
	 * function loadEditCampusRegistrations_OffflineRegBox
	 * <pre>
	 * Initializes the EditCampusRegistrations_OffflineRegBox Page.
	 * </pre>
	 * @return [void]
	 */
    // RAD Tools: FormSingleEntry style
    function loadEditCampusRegistrations_OffflineRegBox() 
    {
        // set the pageCallBack to be without any additional parameters
        // (an AdminBox needs this so Language Switching on a page doesn't
        // pass a previous operations)
        $parameters = array('EVENT_ID'=>$this->EVENT_ID, 'FIELDTYPE_ID'=>$this->FIELDTYPE_ID, 'PRICERULETYPE_ID'=>$this->PRICERULETYPE_ID, 'CCTYPE_ID'=>$this->CCTYPE_ID, 'PRIV_ID'=>$this->PRIV_ID, 'VIEWER_ID'=>$this->VIEWER_ID, 'SUPERADMIN_ID'=>$this->SUPERADMIN_ID, 'EVENTADMIN_ID'=>$this->EVENTADMIN_ID, 'FIELD_ID'=>$this->FIELD_ID, 'DATATYPE_ID'=>$this->DATATYPE_ID, 'PRICERULE_ID'=>$this->PRICERULE_ID, 'CAMPUSACCESS_ID'=>$this->CAMPUSACCESS_ID, 'CASHTRANS_ID'=>$this->CASHTRANS_ID, 'CCTRANS_ID'=>$this->CCTRANS_ID, 'REG_ID'=>$this->REG_ID, 'FIELDVALUE_ID'=>$this->FIELDVALUE_ID, 'SCHOLARSHIP_ID'=>$this->SCHOLARSHIP_ID, 'STATUS_ID'=>$this->STATUS_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID);//[RAD_CALLBACK_PARAMS]
        $pageCallBack = $this->getCallBack(modulecim_reg::PAGE_EDITCAMPUSREGISTRATIONS_OFFFLINEREGBOX, $this->sortBy, $parameters);
        $this->setPageCallBack( $pageCallBack );
        
        
        $parameters = array('EVENT_ID'=>$this->EVENT_ID, 'FIELDTYPE_ID'=>$this->FIELDTYPE_ID, 'PRICERULETYPE_ID'=>$this->PRICERULETYPE_ID, 'CCTYPE_ID'=>$this->CCTYPE_ID, 'PRIV_ID'=>$this->PRIV_ID, 'VIEWER_ID'=>$this->VIEWER_ID, 'SUPERADMIN_ID'=>$this->SUPERADMIN_ID, 'EVENTADMIN_ID'=>$this->EVENTADMIN_ID, 'FIELD_ID'=>$this->FIELD_ID, 'DATATYPE_ID'=>$this->DATATYPE_ID, 'PRICERULE_ID'=>$this->PRICERULE_ID, 'CAMPUSACCESS_ID'=>$this->CAMPUSACCESS_ID, 'CASHTRANS_ID'=>$this->CASHTRANS_ID, 'CCTRANS_ID'=>$this->CCTRANS_ID, 'REG_ID'=>$this->REG_ID, 'FIELDVALUE_ID'=>$this->FIELDVALUE_ID, 'SCHOLARSHIP_ID'=>$this->SCHOLARSHIP_ID, 'STATUS_ID'=>$this->STATUS_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID);//[RAD_CALLBACK_PARAMS]
        $formAction = $this->getCallBack(modulecim_reg::PAGE_EDITCAMPUSREGISTRATIONS_OFFFLINEREGBOX, $this->sortBy, $parameters );
        $this->pageDisplay = new FormProcessor_EditCampusRegistrations_OffflineRegBox( $this->moduleRootPath, $this->viewer, $formAction, $this->REG_ID , $this->EVENT_ID);//[RAD_FORMINIT_FOREIGNKEY_INIT]        
        
    } // end loadEditCampusRegistrations_OffflineRegBox()

    
 
   //************************************************************************
	/**
	 * function loadSideBar
	 * <pre>
	 * Choosses .
	 * </pre>
	 * @return [void]
	 */
    function loadSideBar() 
    {   
	    $regStatus = RowManager_RegistrationManager::STATUS_INCOMPLETE;
	    
	    // get privileges for the current viewer
        $privManager = new PrivilegeManager( $this->viewer->getID() ); 	// students allowed to see sidebar for sign-up process 
        if (($this->IS_IN_REG_PROCESS == modulecim_reg::IS_SIGNUP)||($privManager->isCampusAdmin($this->EVENT_ID, $this->CAMPUS_ID)==true))	// check if privilege level is high enough
        {		     

	//         $parameters['PERSON_ID'] = $personID;
	
				// find registration ID using person id and event_id
				//if ((!isset($this->REG_ID))||$this->REG_ID='')
				//{
					
					if ((isset($this->PERSON_ID))&&($this->PERSON_ID != '')&&((isset($this->EVENT_ID))&&($this->EVENT_ID != '')))
					{
						
			        // get registration ID for the rest of the reg. process
			        $regs = new RowManager_RegistrationManager();
			        $people = new RowManager_PersonManager();
			        $people->setPersonID($this->PERSON_ID);
			        $events = new RowManager_EventManager();
			        $events->setEventID($this->EVENT_ID);
			        
			        $personRegs = new MultiTableManager();
			        $personRegs->addRowManager($regs);
			        $personRegs->addRowManager($people, new JoinPair( $regs->getJoinOnPersonID(), $people->getJoinOnPersonID()));
			        $personRegs->addRowManager($events, new JoinPair( $regs->getJoinOnEventID(), $events->getJoinOnEventID()));
			        
			        $regsList = $personRegs->getListIterator( );
			        $regsArray = $regsList->getDataList();		
	// 		        echo "<pre>".print_r($regsArray,true)."</pre>"; 
			          			
			         reset($regsArray);
			        	foreach(array_keys($regsArray) as $k)
						{
							$registration = current($regsArray);	
							$this->REG_ID = $registration['registration_id'];	// NOTE: should only be one reg. per person per event (ENFORCE??)	
							$regStatus = $registration['registration_status'];
							
							next($regsArray);	
						}		
					}
				//}	
				
			 $regCompleted = false;
			 if ($regStatus == RowManager_RegistrationManager::STATUS_REGISTERED)
			 {
				$regCompleted = true;
			 }
	       $this->sideBar = new obj_RegProcessSideBar( $this->moduleRootPath, $this->viewer, $regCompleted);	//, $isNewRegistrant );   	
		
	        
	        $links = array();
	//         $adminLinks = array();
	//         $campusLevelLinks = array();
	
	        $parameters = array();					
	        $parameters = array('MINISTRY_ID'=>$this->MINISTRY_ID, 'IS_IN_REG_PROCESS'=>$this->IS_IN_REG_PROCESS, 'EVENT_ID'=>$this->EVENT_ID, 'REG_ID'=>$this->REG_ID, 'PERSON_ID'=>$this->PERSON_ID,  'CAMPUS_ID'=>$this->CAMPUS_ID, 'PRIV_ID'=>$this->PRIV_ID);//[RAD_CALLBACK_PARAMS]
				// 'PROVINCE_ID'=>$this->PROVINCE_ID, 'GENDER_ID'=>$this->GENDER_ID, 'STAFF_ID'=>$this->STAFF_ID, 'USER_ID'=>$this->USER_ID, 'ASSIGNMENT_ID'=>$this->ASSIGNMENT_ID, 'ADMIN_ID'=>$this->ADMIN_ID, 'CAMPUSADMIN_ID'=>$this->CAMPUSADMIN_ID
	
	        // echo print_r($parameters,true);
	
	        // GROUP 1: EVERYONE.
	        // ALL viewers can access these links
		     if (($regStatus == RowManager_RegistrationManager::STATUS_REGISTERED)&&($this->IS_IN_REG_PROCESS==modulecim_reg::IS_SIGNUP))
		     {
		        $requestLink = $this->getCallBack(modulecim_reg::PAGE_CONFIRMCANCELREGISTRATION, '', $parameters );
		        $links[ '[RegCancel]' ] = $requestLink;		
	        }	        	        
	        
	        $requestLink = $this->getCallBack( modulecim_reg::PAGE_EDITPERSONALINFO, '' , $parameters);
	        $links[ '[editMyInfo]' ] = $requestLink;
	        
	 	     // need to know if registration process requires new registrant personal info
		     // since this means side-bar cannot have future registration step links yet
		     if ((isset($this->PERSON_ID))&&($this->PERSON_ID == -1))
		     {
					// show only first link
		     }
		     else 	// show all registration process links
		     {		     			     
		        $requestLink = $this->getCallBack( modulecim_reg::PAGE_EDITCAMPUSASSIGNMENT, '' , $parameters);
		        $links[ '[editCampusInfo]' ] = $requestLink;
		        
		        $requestLink = $this->getCallBack( modulecim_reg::PAGE_EDITFIELDVALUES, '' , $parameters);
		        $links[ '[editFieldValues]' ] = $requestLink;   
		        
		        $requestLink = $this->getCallBack( modulecim_reg::PAGE_PROCESSFINANCIALTRANSACTIONS, '' , $parameters);
		        $links[ '[processFinances]' ] = $requestLink;  
	     		}	         
/***	       
	        if ($this->IS_IN_REG_PROCESS == modulecim_reg::IS_SIGNUP)
	        {
		        $requestLink = $this->getCallBack( modulecim_reg::PAGE_REG_HOME, '' , $parameters);
		        $links[ '[backToEventList]' ] = $requestLink; 
	        }
	        else if ($this->IS_IN_REG_PROCESS == modulecim_reg::IS_OFFLINE_REG)
	        {
		        $requestLink = $this->getCallBack( modulecim_reg::PAGE_EDITCAMPUSREGISTRATIONS, '' , $parameters);
		        $links[ '[backToRegList]' ] = $requestLink;                 
	        }
****/	                              
	
	//         // GROUP 2: CAMPUS ADMINS AND ABOVE ONLY.
	//         if ( ( $this->accessPrivManager->hasSitePriv() ) || ( $this->accessPrivManager->hasCampusPriv() ) ){
	//           //$requestLink = $this->getCallBack( modulecim_hrdb::PAGE_PEOPLE );
	//           //$campusLevelLinks[ '[PeopleList]' ] = $requestLink;
	//           // TODO if you have 'hrdb campus' group access rights you can see these
	//           $requestLink = $this->getCallBack( modulecim_hrdb::PAGE_PEOPLEBYCAMPUSES );
	//           $campusLevelLinks[ '[PeopleByCampuses]' ] = $requestLink;
	//         }
	
	//         // GROUP 3: SUPER ADMINS ONLY.
	//         if ( $this->accessPrivManager->hasSitePriv()){
	//           $requestLink = $this->getCallBack( modulecim_hrdb::PAGE_CAMPUSES );
	//           $adminLinks[ '[editCampuses]' ] = $requestLink;
	
	//           $requestLink = $this->getCallBack( modulecim_hrdb::PAGE_PROVINCES );
	//           $adminLinks[ '[editProvinces]' ] = $requestLink;
	
	//           $requestLink = $this->getCallBack( modulecim_hrdb::PAGE_PRIVILEGES );
	//           $adminLinks[ '[editPrivileges]' ] = $requestLink;
	
	//           $requestLink = $this->getCallBack( modulecim_hrdb::PAGE_STAFF );
	//           $adminLinks[ '[Staff]' ] = $requestLink;
	
	//           $requestLink = $this->getCallBack( modulecim_hrdb::PAGE_ADMINS );
	//           $adminLinks[ '[Admins]' ] = $requestLink;
	//           
	//           $requestLink = $this->getCallBack( modulecim_hrdb::PAGE_EDITCAMPUSASSIGNMENT );
	//           $adminLinks[ '[CampusAssignments]' ] = $requestLink;   
	
	//           $requestLink = $this->getCallBack( modulecim_hrdb::PAGE_EDITCAMPUSASSIGNMENTSTATUSTYPES );
	//           $adminLinks[ '[AssignStatusTypes]' ] = $requestLink;          
	//           
	//         }
	
	        // pass the links to the sidebar object
	        $this->sideBar->setLinks( $links );
	//         $this->sideBar->setAdminLinks( $adminLinks );
	//         $this->sideBar->setCampusLevelLinks( $campusLevelLinks );
		}

    } // end loadSideBar()
    
           
    
   //************************************************************************
	/**
	 * function loadEditPersonalInfo
	 * <pre>
	 * Initializes the EditPersonalInfo Page.
	 * </pre>
	 * @param $isCreated [BOOL] "Is THIS pageDisplay object already created?"
	 * @return [void]
	 */
    // RAD Tools: DataSingle Style
    function loadEditPersonalInfo($isCreated=false)
    {

	    // get privileges for the current viewer
        $privManager = new PrivilegeManager( $this->viewer->getID() );  
        if (($this->IS_IN_REG_PROCESS == modulecim_reg::IS_SIGNUP)||($privManager->isCampusAdmin($this->EVENT_ID, $this->CAMPUS_ID)==true))	// check if privilege level is high enough
        {	
	        
	        // set the pageCallBack to be without any additional parameters:  TODO: have it point to PAGE_EDITCAMPUSASSIGNMENT
	        // (an AdminBox needs this so Language Switching on a page doesn't
	        // pass a previous operations)
	        $parameters = array('MINISTRY_ID'=>$this->MINISTRY_ID, 'IS_IN_REG_PROCESS'=>$this->IS_IN_REG_PROCESS, 'EVENT_ID'=>$this->EVENT_ID, 'REG_ID'=>$this->REG_ID, 'PERSON_ID'=>$this->PERSON_ID,  'CAMPUS_ID'=>$this->CAMPUS_ID, 'PRIV_ID'=>$this->PRIV_ID);//[RAD_CALLBACK_PARAMS]
				// 'PROVINCE_ID'=>$this->PROVINCE_ID, 'GENDER_ID'=>$this->GENDER_ID, 'STAFF_ID'=>$this->STAFF_ID, 'USER_ID'=>$this->USER_ID, 'ASSIGNMENT_ID'=>$this->ASSIGNMENT_ID, 'ADMIN_ID'=>$this->ADMIN_ID, 'CAMPUSADMIN_ID'=>$this->CAMPUSADMIN_ID
	        $pageCallBack = $this->getCallBack(modulecim_reg::PAGE_EDITPERSONALINFO, $this->sortBy, $parameters);
	        $this->setPageCallBack( $pageCallBack );
	        
	        $formTo_page = '';
	//        echo "previous page = ".$this->previous_page;
	//        if (!isset($this->previous_page)) 
	//        {
		        $formTo_page = modulecim_reg::PAGE_EDITPERSONALINFO;
	/*        }
	        else 
	        {
		        $formTo_page = $this->previous_page;
	        } */
	
	        // NOTE: making use of previous_page variable to return to a dynamic page
	        $formAction = $this->getCallBack($formTo_page, $this->sortBy, $parameters );
	
	        // set flag for if the page is located inside the offline registration process
	        if ($this->IS_IN_REG_PROCESS > modulecim_reg::IS_FALSE) 
	        {
		        $isInRegProcess = true;
	        }
	        else 
	        {
		        $isInRegProcess = false;
	        }	        
	        
	        $this->pageDisplay = new FormProcessor_EditMyInfo( $this->moduleRootPath, $this->viewer, $formAction, $this->PERSON_ID, $this->EVENT_ID, $this->CAMPUS_ID, $this->REG_ID, $isInRegProcess );
	        
	/*
	        $links = array();
	
	        $parameters = array('PERSON_ID'=>$this->PERSON_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'PRIV_ID'=>$this->PRIV_ID);//[RAD_CALLBACK_PARAMS]
				// 'PROVINCE_ID'=>$this->PROVINCE_ID, 'GENDER_ID'=>$this->GENDER_ID, 'STAFF_ID'=>$this->STAFF_ID, 'USER_ID'=>$this->USER_ID, 'ASSIGNMENT_ID'=>$this->ASSIGNMENT_ID, 'ADMIN_ID'=>$this->ADMIN_ID, 'CAMPUSADMIN_ID'=>$this->CAMPUSADMIN_ID
	//		  $continueLink = $this->getCallBack( modulecim_reg::PAGE_EDITPERSONALINFO, "", $parameters );
	        $links["cont"] = $continueLink;
	
	        $this->pageDisplay->setLinks( $links );
	*/       
			//$this->previous_page = modulecim_reg::PAGE_EDITPERSONALINFO;    
        }
        else
        {
	        $this->pageDisplay = new page_NotAuthorized($this->moduleRootPath, $this->viewer);  
        }  
    } // end loadPersonInfo()
    
    
        //************************************************************************
	/**
	 * function loadEditCampusAssignment
	 * <pre>
	 * Initializes the EditCampusAssignment Page.
	 * </pre>
	 * @param $isCreated [BOOL] "Is THIS pageDisplay object already created?"
	 * @return [void]
	 */
    // RAD Tools: AdminBox Style
    function loadEditCampusAssignment( $isCreated=false ) 
    {

	    // get privileges for the current viewer
        $privManager = new PrivilegeManager( $this->viewer->getID() );  
        if (($this->IS_IN_REG_PROCESS == modulecim_reg::IS_SIGNUP)||($privManager->isCampusAdmin($this->EVENT_ID, $this->CAMPUS_ID)==true))	// check if privilege level is high enough
        {	        
	        // compile a formAction for the adminBox
	        $parameters = array('MINISTRY_ID'=>$this->MINISTRY_ID, 'IS_IN_REG_PROCESS'=>$this->IS_IN_REG_PROCESS, 'EVENT_ID'=>$this->EVENT_ID, 'REG_ID'=>$this->REG_ID, 'PERSON_ID'=>$this->PERSON_ID,  'CAMPUS_ID'=>$this->CAMPUS_ID, 'PRIV_ID'=>$this->PRIV_ID, 'ASSIGNMENT_ID'=>$this->ASSIGNMENT_ID, 'ASSIGNSTATUS_ID'=>$this->ASSIGNSTATUS_ID);	//, [RAD_CALLBACK_PARAMS]
				// 'PROVINCE_ID'=>$this->PROVINCE_ID, 'GENDER_ID'=>$this->GENDER_ID, 'STAFF_ID'=>$this->STAFF_ID, 'USER_ID'=>$this->USER_ID, 'ASSIGNMENT_ID'=>$this->ASSIGNMENT_ID, 'ADMIN_ID'=>$this->ADMIN_ID, 'CAMPUSADMIN_ID'=>$this->CAMPUSADMIN_ID
	        $formAction = $this->getCallBack(modulecim_reg::PAGE_EDITCAMPUSASSIGNMENT, $this->sortBy, $parameters );
	        
	        // set the pageCallBack value.  This is used by the Language switching
	        // code
	        $this->setPageCallBack( $formAction );
	        
	        // set whether or not in sign-up process
	        $isSignUp = false;
	        if ($this->IS_IN_REG_PROCESS == modulecim_reg::IS_SIGNUP)
	        {
		        $isSignUp = true;
	        }
	        
	        // if this pageDisplay object isn't already created then 
	        if ( !$isCreated ) {
        		               
	            // create a new pageDisplay object
	            $this->pageDisplay = new FormProcessor_EditCampusAssignment( $this->moduleRootPath, $this->viewer, $formAction, $this->sortBy,  $this->ASSIGNMENT_ID, $this->PERSON_ID, $this->CAMPUS_ID,  $isSignUp);	//, $this->ASSIGNSTATUS_ID);	// , $this->ASSIGNSTATUS_ID);//[RAD_FORMINIT_FOREIGNKEY_INIT]    
	        
	        } else {
	        
	            // otherwise just update the formAction value
	            $this->pageDisplay->setFormAction( $formAction );
	        }
	        
	        $links = array();
	        
	//         $parameters = array( 'EVENT_ID'=>$this->EVENT_ID, 'FIELDTYPE_ID'=>$this->FIELDTYPE_ID, 'PRICERULETYPE_ID'=>$this->PRICERULETYPE_ID, 'CCTYPE_ID'=>$this->CCTYPE_ID, 'PRIV_ID'=>$this->PRIV_ID, 'VIEWER_ID'=>$this->VIEWER_ID, 'SUPERADMIN_ID'=>$this->SUPERADMIN_ID, 'EVENTADMIN_ID'=>$this->EVENTADMIN_ID, 'FIELD_ID'=>$this->FIELD_ID, 'DATATYPE_ID'=>$this->DATATYPE_ID, 'PRICERULE_ID'=>$this->PRICERULE_ID, 'CAMPUSACCESS_ID'=>$this->CAMPUSACCESS_ID, 'CASHTRANS_ID'=>$this->CASHTRANS_ID, 'CCTRANS_ID'=>$this->CCTRANS_ID, 'REG_ID'=>$this->REG_ID, 'FIELDVALUE_ID'=>$this->FIELDVALUE_ID, 'SCHOLARSHIP_ID'=>$this->SCHOLARSHIP_ID, 'STATUS_ID'=>$this->STATUS_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID);//[RAD_CALLBACK_PARAMS]
	        $parameters = array('MINISTRY_ID'=>$this->MINISTRY_ID, 'IS_IN_REG_PROCESS'=>$this->IS_IN_REG_PROCESS, 'EVENT_ID'=>$this->EVENT_ID, 'REG_ID'=>$this->REG_ID, 'PERSON_ID'=>$this->PERSON_ID,  'CAMPUS_ID'=>$this->CAMPUS_ID, 'ASSIGNMENT_ID'=>$this->ASSIGNMENT_ID);	//'ASSIGNSTATUS_ID'=>$this->ASSIGNSTATUS_ID);	//,  [RAD_CALLBACK_PARAMS]
			  $continueLink = $this->getCallBack( modulecim_reg::PAGE_EDITFIELDVALUES, "", $parameters );
	        $links["cont"] = $continueLink;
	        
	        $parameters = array('MINISTRY_ID'=>$this->MINISTRY_ID, 'IS_IN_REG_PROCESS'=>$this->IS_IN_REG_PROCESS, 'EVENT_ID'=>$this->EVENT_ID, 'REG_ID'=>$this->REG_ID, 'PERSON_ID'=>$this->PERSON_ID,  'CAMPUS_ID'=>$this->CAMPUS_ID, 'ASSIGNMENT_ID'=>$this->ASSIGNMENT_ID);	//'ASSIGNSTATUS_ID'=>$this->ASSIGNSTATUS_ID);	//,  [RAD_CALLBACK_PARAMS]
	        $editLink = $this->getCallBack( modulecim_reg::PAGE_EDITCAMPUSASSIGNMENT, $this->sortBy, $parameters );
	        $editLink .= "&". modulecim_reg::ASSIGNMENT_ID . "=";
	        $links["edit"] = $editLink;
	        
	        // NOTE: delete link is same as edit link for an AdminBox
	        $links["del"] = $editLink;
	
	/*[RAD_LINK_INSERT]*/
	
	        $parameters = array('MINISTRY_ID'=>$this->MINISTRY_ID, 'IS_IN_REG_PROCESS'=>$this->IS_IN_REG_PROCESS, 'EVENT_ID'=>$this->EVENT_ID, 'REG_ID'=>$this->REG_ID, 'PERSON_ID'=>$this->PERSON_ID,  'CAMPUS_ID'=>$this->CAMPUS_ID, 'PRIV_ID'=>$this->PRIV_ID, 'ASSIGNMENT_ID'=>$this->ASSIGNMENT_ID, 'ASSIGNSTATUS_ID'=>$this->ASSIGNSTATUS_ID);	//,  [RAD_CALLBACK_PARAMS]
				// 'PROVINCE_ID'=>$this->PROVINCE_ID, 'GENDER_ID'=>$this->GENDER_ID, 'STAFF_ID'=>$this->STAFF_ID, 'USER_ID'=>$this->USER_ID, 'ASSIGNMENT_ID'=>$this->ASSIGNMENT_ID, 'ADMIN_ID'=>$this->ADMIN_ID, 'CAMPUSADMIN_ID'=>$this->CAMPUSADMIN_ID
	        $sortByLink = $this->getCallBack( modulecim_reg::PAGE_EDITCAMPUSASSIGNMENT, '', $parameters );
	        $sortByLink .= "&".modulecim_reg::SORTBY."=";
	        $links["sortBy"] = $sortByLink;
	
	        $this->pageDisplay->setLinks( $links );  
	        //$this->previous_page = modulecim_reg::PAGE_EDITCAMPUSASSIGNMENT;     
        }
        else
        {
	        $this->pageDisplay = new page_NotAuthorized($this->moduleRootPath, $this->viewer);  
        }          
    } // end loadEditCampusAssignment()


    //************************************************************************
	/**
	 * function loadEditFieldValues
	 * <pre>
	 * Initializes the EditFieldValues Page.
	 * </pre>
	 * @return [void]
	 */
    // RAD Tools: FormSingleEntry style
    function loadEditFieldValues($isCreated = false) 
    {

	    // get privileges for the current viewer
        $privManager = new PrivilegeManager( $this->viewer->getID() );  
        if (($this->IS_IN_REG_PROCESS == modulecim_reg::IS_SIGNUP)||($privManager->isCampusAdmin($this->EVENT_ID, $this->CAMPUS_ID)==true))	// check if privilege level is high enough
        {	    
	        // set the pageCallBack to be without any additional parameters
	        // (an AdminBox needs this so Language Switching on a page doesn't
	        // pass a previous operations)
	        $parameters = array('MINISTRY_ID'=>$this->MINISTRY_ID, 'IS_IN_REG_PROCESS'=>$this->IS_IN_REG_PROCESS, 'EVENT_ID'=>$this->EVENT_ID, 'FIELDTYPE_ID'=>$this->FIELDTYPE_ID, 'PRICERULETYPE_ID'=>$this->PRICERULETYPE_ID, 'CCTYPE_ID'=>$this->CCTYPE_ID, 'PRIV_ID'=>$this->PRIV_ID, 'VIEWER_ID'=>$this->VIEWER_ID, 'SUPERADMIN_ID'=>$this->SUPERADMIN_ID, 'EVENTADMIN_ID'=>$this->EVENTADMIN_ID, 'FIELD_ID'=>$this->FIELD_ID, 'DATATYPE_ID'=>$this->DATATYPE_ID, 'PRICERULE_ID'=>$this->PRICERULE_ID, 'CAMPUSACCESS_ID'=>$this->CAMPUSACCESS_ID, 'CASHTRANS_ID'=>$this->CASHTRANS_ID, 'CCTRANS_ID'=>$this->CCTRANS_ID, 'REG_ID'=>$this->REG_ID, 'FIELDVALUE_ID'=>$this->FIELDVALUE_ID, 'SCHOLARSHIP_ID'=>$this->SCHOLARSHIP_ID, 'STATUS_ID'=>$this->STATUS_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'PERSON_ID'=>$this->PERSON_ID);//[RAD_CALLBACK_PARAMS]
	        $pageCallBack = $this->getCallBack(modulecim_reg::PAGE_EDITFIELDVALUES, $this->sortBy, $parameters);
	        $this->setPageCallBack( $pageCallBack );       
	               
	        
	        $parameters = array('MINISTRY_ID'=>$this->MINISTRY_ID, 'IS_IN_REG_PROCESS'=>$this->IS_IN_REG_PROCESS, 'EVENT_ID'=>$this->EVENT_ID, 'FIELDTYPE_ID'=>$this->FIELDTYPE_ID, 'PRICERULETYPE_ID'=>$this->PRICERULETYPE_ID, 'CCTYPE_ID'=>$this->CCTYPE_ID, 'PRIV_ID'=>$this->PRIV_ID, 'VIEWER_ID'=>$this->VIEWER_ID, 'SUPERADMIN_ID'=>$this->SUPERADMIN_ID, 'EVENTADMIN_ID'=>$this->EVENTADMIN_ID, 'FIELD_ID'=>$this->FIELD_ID, 'DATATYPE_ID'=>$this->DATATYPE_ID, 'PRICERULE_ID'=>$this->PRICERULE_ID, 'CAMPUSACCESS_ID'=>$this->CAMPUSACCESS_ID, 'CASHTRANS_ID'=>$this->CASHTRANS_ID, 'CCTRANS_ID'=>$this->CCTRANS_ID, 'REG_ID'=>$this->REG_ID, 'FIELDVALUE_ID'=>$this->FIELDVALUE_ID, 'SCHOLARSHIP_ID'=>$this->SCHOLARSHIP_ID, 'STATUS_ID'=>$this->STATUS_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'PERSON_ID'=>$this->PERSON_ID);//[RAD_CALLBACK_PARAMS]
	        $formAction = $this->getCallBack(modulecim_reg::PAGE_EDITFIELDVALUES, $this->sortBy, $parameters );
	 //       $this->pageDisplay = new FormProcessor_EditFieldValues( $this->moduleRootPath, $this->viewer, $formAction, $this->PERSON_ID, $this->EVENT_ID, $this->FIELDVALUE_ID , $this->FIELD_ID, $this->REG_ID);//[RAD_FORMINIT_FOREIGNKEY_INIT]        
	
	        // if this pageDisplay object isn't already created then 
	        if ( !$isCreated ) {
		        
		        $showHidden = true;
		        if ($this->IS_IN_REG_PROCESS == modulecim_reg::IS_SIGNUP)
		        {
			        $showHidden = false;
		        }
	        
	            // create a new pageDisplay object
	        		$this->pageDisplay = new FormProcessor_EditFieldValues( $this->moduleRootPath, $this->viewer, $formAction, $this->PERSON_ID, $this->EVENT_ID, $this->FIELDVALUE_ID , $this->FIELD_ID, $this->REG_ID, false, $showHidden);//[RAD_FORMINIT_FOREIGNKEY_INIT]        
	        
	        } else {
	        
	            // otherwise just update the formAction value
	            $this->pageDisplay->setFormAction( $formAction );
	        }         
        }
        else
        {
	        $this->pageDisplay = new page_NotAuthorized($this->moduleRootPath, $this->viewer);  
        }             
    } // end loadEditFieldValues()
    
    
    
    //************************************************************************
	/**
	 * function loadProcessFinancialTransactions
	 * <pre>
	 * Initializes the ProcessFinancialTransactions Page.
	 * </pre>
	 * @return [void]
	 */
    // RAD Tools: <not used>
    function loadProcessFinancialTransactions($isCreated=false ) 	
    {
	    
	    // get privileges for the current viewer
        $privManager = new PrivilegeManager( $this->viewer->getID() );  
        if (($this->IS_IN_REG_PROCESS == modulecim_reg::IS_SIGNUP)||($privManager->isCampusAdmin($this->EVENT_ID, $this->CAMPUS_ID)==true))	// check if privilege level is high enough
        {		    
	/** TODO: replace PAGE_PROCESSFINANCIALTRANSACTIONSPAGE with PAGE_REGISTRATIONCONFIRMATIONPAGE	**/    
		    
	        // set the pageCallBack to be without any additional parameters
	        // (an AdminBox needs this so Language Switching on a page doesn't
	        // pass a previous operations)
	 //       echo "SCHOLARSHIP_ID, CASHTRANS_ID, CCTRANS_ID = ".$this->SCHOLARSHIP_ID." ".$this->CASHTRANS_ID." ".$this->CCTRANS_ID."<BR>";
	       
	        $parameters = array('MINISTRY_ID'=>$this->MINISTRY_ID, 'IS_IN_REG_PROCESS'=>$this->IS_IN_REG_PROCESS, 'PERSON_ID'=>$this->PERSON_ID, 'EVENT_ID'=>$this->EVENT_ID, 'FIELDTYPE_ID'=>$this->FIELDTYPE_ID, 'PRICERULETYPE_ID'=>$this->PRICERULETYPE_ID, 'CCTYPE_ID'=>$this->CCTYPE_ID, 'PRIV_ID'=>$this->PRIV_ID, 'VIEWER_ID'=>$this->VIEWER_ID, 'SUPERADMIN_ID'=>$this->SUPERADMIN_ID, 'EVENTADMIN_ID'=>$this->EVENTADMIN_ID, 'FIELD_ID'=>$this->FIELD_ID, 'DATATYPE_ID'=>$this->DATATYPE_ID, 'PRICERULE_ID'=>$this->PRICERULE_ID, 'CAMPUSACCESS_ID'=>$this->CAMPUSACCESS_ID, 'CASHTRANS_ID'=>$this->CASHTRANS_ID, 'CCTRANS_ID'=>$this->CCTRANS_ID, 'REG_ID'=>$this->REG_ID, 'FIELDVALUE_ID'=>$this->FIELDVALUE_ID, 'SCHOLARSHIP_ID'=>$this->SCHOLARSHIP_ID, 'STATUS_ID'=>$this->STATUS_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID);//[RAD_CALLBACK_PARAMS]
	        $cashtrans_parameters = array('MINISTRY_ID'=>$this->MINISTRY_ID, 'IS_IN_REG_PROCESS'=>$this->IS_IN_REG_PROCESS, 'PERSON_ID'=>$this->PERSON_ID, 'EVENT_ID'=>$this->EVENT_ID, 'PRIV_ID'=>$this->PRIV_ID, 'VIEWER_ID'=>$this->VIEWER_ID, 'SUPERADMIN_ID'=>$this->SUPERADMIN_ID, 'EVENTADMIN_ID'=>$this->EVENTADMIN_ID, 'CASHTRANS_ID'=>$this->CASHTRANS_ID, 'REG_ID'=>$this->REG_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID);//[RAD_CALLBACK_PARAMS]
	        $cctrans_parameters = array('MINISTRY_ID'=>$this->MINISTRY_ID, 'IS_IN_REG_PROCESS'=>$this->IS_IN_REG_PROCESS, 'PERSON_ID'=>$this->PERSON_ID, 'EVENT_ID'=>$this->EVENT_ID, 'CCTYPE_ID'=>$this->CCTYPE_ID, 'PRIV_ID'=>$this->PRIV_ID, 'VIEWER_ID'=>$this->VIEWER_ID, 'SUPERADMIN_ID'=>$this->SUPERADMIN_ID, 'EVENTADMIN_ID'=>$this->EVENTADMIN_ID, 'CCTRANS_ID'=>$this->CCTRANS_ID, 'REG_ID'=>$this->REG_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID);//[RAD_CALLBACK_PARAMS]
	        
	        $pageCallBack = $this->getCallBack(modulecim_reg::PAGE_PROCESSFINANCIALTRANSACTIONS, $this->sortBy, $parameters);
	        $this->setPageCallBack( $pageCallBack );
	        
	        $formAction = $this->getCallBack(modulecim_reg::PAGE_PROCESSFINANCIALTRANSACTIONS, $this->sortBy, $parameters );
	        $cashTrans_formAction = $this->getCallBack(modulecim_reg::PAGE_PROCESSFINANCIALTRANSACTIONS, $this->sortBy, $cashtrans_parameters );
	        $ccTrans_formAction = $this->getCallBack(modulecim_reg::PAGE_PROCESSFINANCIALTRANSACTIONS, $this->sortBy, $cctrans_parameters );
	        
	        
	
	//         $this->IS_IN_REG_PROCESS = modulecim_reg::IS_OFFLINE_REG; // could also use modulecim_reg::IS_SIGNUP... doesn't matter though
	        
	        $parameters = array('MINISTRY_ID'=>$this->MINISTRY_ID, 'IS_IN_REG_PROCESS'=>$this->IS_IN_REG_PROCESS, 'PERSON_ID'=>$this->PERSON_ID, 'EVENT_ID'=>$this->EVENT_ID, 'FIELDTYPE_ID'=>$this->FIELDTYPE_ID, 'PRICERULETYPE_ID'=>$this->PRICERULETYPE_ID, 'CCTYPE_ID'=>$this->CCTYPE_ID, 'PRIV_ID'=>$this->PRIV_ID, 'VIEWER_ID'=>$this->VIEWER_ID, 'SUPERADMIN_ID'=>$this->SUPERADMIN_ID, 'EVENTADMIN_ID'=>$this->EVENTADMIN_ID, 'FIELD_ID'=>$this->FIELD_ID, 'DATATYPE_ID'=>$this->DATATYPE_ID, 'PRICERULE_ID'=>$this->PRICERULE_ID, 'CAMPUSACCESS_ID'=>$this->CAMPUSACCESS_ID, 'CASHTRANS_ID'=>$this->CASHTRANS_ID, 'CCTRANS_ID'=>$this->CCTRANS_ID, 'REG_ID'=>$this->REG_ID, 'FIELDVALUE_ID'=>$this->FIELDVALUE_ID, 'SCHOLARSHIP_ID'=>$this->SCHOLARSHIP_ID, 'STATUS_ID'=>$this->STATUS_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID);//[RAD_CALLBACK_PARAMS]
	        
	        $continueLink = '';
	        $isSignUp = false;
	        if ($this->IS_IN_REG_PROCESS == modulecim_reg::IS_SIGNUP)
	        {
	        		$continueLink = $this->getCallBack( modulecim_reg::PAGE_REG_HOME, "", $parameters );
	        		$isSignUp = true;
		     }
		     else if ($this->IS_IN_REG_PROCESS == modulecim_reg::IS_OFFLINE_REG)
		     {
	        		$continueLink = $this->getCallBack( modulecim_reg::PAGE_EDITCAMPUSREGISTRATIONS, "", $parameters );
		     }	
	        
	        // if this pageDisplay object isn't already created then 
	        if ( !$isCreated ) {
	        
	            // create a new pageDisplay object
	        		$this->pageDisplay = new page_ProcessFinancialTransactions( $this->moduleRootPath, $this->viewer, $this->sortBy, $this->REG_ID, $this->EVENT_ID, $this->CAMPUS_ID, $this->CASHTRANS_ID, $this->CCTRANS_ID, $formAction, $cashTrans_formAction, $ccTrans_formAction, $this->PERSON_ID, $isSignUp );   						        
	        } else {
	        
	            // otherwise just update the formAction value
	            $this->pageDisplay->setFormAction( $formAction, $cashTrans_formAction, $ccTrans_formAction );
	        }   
	                          
	        
	        $links = array();	     
		     
	        $links["cont"] = $continueLink;	// TODO: point to confirmation page at end of offline reg process
	        $disabledLink = $this->getCallBack( modulecim_reg::PAGE_PROCESSFINANCIALTRANSACTIONS, "", $parameters );
	        
	
	        
	         /**** CASH TRANSACTIONS SUB-PAGE LINKS INIT ***/
	       $cashTransLinks = array();
	       
	        $parameters = array('MINISTRY_ID'=>$this->MINISTRY_ID, 'IS_IN_REG_PROCESS'=>$this->IS_IN_REG_PROCESS, 'PERSON_ID'=>$this->PERSON_ID, 'EVENT_ID'=>$this->EVENT_ID, 'FIELDTYPE_ID'=>$this->FIELDTYPE_ID, 'PRICERULETYPE_ID'=>$this->PRICERULETYPE_ID, 'CCTYPE_ID'=>$this->CCTYPE_ID, 'PRIV_ID'=>$this->PRIV_ID, 'VIEWER_ID'=>$this->VIEWER_ID, 'SUPERADMIN_ID'=>$this->SUPERADMIN_ID, 'EVENTADMIN_ID'=>$this->EVENTADMIN_ID, 'FIELD_ID'=>$this->FIELD_ID, 'DATATYPE_ID'=>$this->DATATYPE_ID, 'PRICERULE_ID'=>$this->PRICERULE_ID, 'CAMPUSACCESS_ID'=>$this->CAMPUSACCESS_ID, 'CASHTRANS_ID'=>$this->CASHTRANS_ID, 'CCTRANS_ID'=>$this->CCTRANS_ID, 'REG_ID'=>$this->REG_ID, 'FIELDVALUE_ID'=>$this->FIELDVALUE_ID, 'SCHOLARSHIP_ID'=>$this->SCHOLARSHIP_ID, 'STATUS_ID'=>$this->STATUS_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID);//[RAD_CALLBACK_PARAMS]
	        $editLink = $this->getCallBack( modulecim_reg::PAGE_PROCESSFINANCIALTRANSACTIONS, $this->sortBy, $parameters );
	        $editLink .= "&". modulecim_reg::CASHTRANS_ID . "=";
	//         $cashTransLinks[ "edit" ] = $editLink;
	        
	        // NOTE: delete link is same as edit link for an AdminBox
	//         $cashTransLinks[ "del" ] = $editLink;
	
	        $parameters = array('MINISTRY_ID'=>$this->MINISTRY_ID, 'IS_IN_REG_PROCESS'=>$this->IS_IN_REG_PROCESS, 'PERSON_ID'=>$this->PERSON_ID, 'EVENT_ID'=>$this->EVENT_ID, 'FIELDTYPE_ID'=>$this->FIELDTYPE_ID, 'PRICERULETYPE_ID'=>$this->PRICERULETYPE_ID, 'CCTYPE_ID'=>$this->CCTYPE_ID, 'PRIV_ID'=>$this->PRIV_ID, 'VIEWER_ID'=>$this->VIEWER_ID, 'SUPERADMIN_ID'=>$this->SUPERADMIN_ID, 'EVENTADMIN_ID'=>$this->EVENTADMIN_ID, 'FIELD_ID'=>$this->FIELD_ID, 'DATATYPE_ID'=>$this->DATATYPE_ID, 'PRICERULE_ID'=>$this->PRICERULE_ID, 'CAMPUSACCESS_ID'=>$this->CAMPUSACCESS_ID, 'CCTRANS_ID'=>$this->CCTRANS_ID, 'REG_ID'=>$this->REG_ID, 'FIELDVALUE_ID'=>$this->FIELDVALUE_ID, 'SCHOLARSHIP_ID'=>$this->SCHOLARSHIP_ID, 'STATUS_ID'=>$this->STATUS_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID);//[RAD_CALLBACK_PARAMS]
	        $sortByLink = $this->getCallBack( modulecim_reg::PAGE_PROCESSFINANCIALTRANSACTIONS, '', $parameters );
	        $sortByLink .= "&".modulecim_reg::SORTBY."=";
	        $cashTransLinks["sortBy"] = $sortByLink;
	        
	        /**** CC TRANSACTIONS SUB-PAGE LINKS INIT ***/
	        $ccTransLinks = array();
	        
	        $parameters = array('MINISTRY_ID'=>$this->MINISTRY_ID, 'IS_IN_REG_PROCESS'=>$this->IS_IN_REG_PROCESS, 'PERSON_ID'=>$this->PERSON_ID, 'EVENT_ID'=>$this->EVENT_ID, 'FIELDTYPE_ID'=>$this->FIELDTYPE_ID, 'PRICERULETYPE_ID'=>$this->PRICERULETYPE_ID, 'CCTYPE_ID'=>$this->CCTYPE_ID, 'PRIV_ID'=>$this->PRIV_ID, 'VIEWER_ID'=>$this->VIEWER_ID, 'SUPERADMIN_ID'=>$this->SUPERADMIN_ID, 'EVENTADMIN_ID'=>$this->EVENTADMIN_ID, 'FIELD_ID'=>$this->FIELD_ID, 'DATATYPE_ID'=>$this->DATATYPE_ID, 'PRICERULE_ID'=>$this->PRICERULE_ID, 'CAMPUSACCESS_ID'=>$this->CAMPUSACCESS_ID, 'CASHTRANS_ID'=>$this->CASHTRANS_ID, 'CCTRANS_ID'=>$this->CCTRANS_ID, 'REG_ID'=>$this->REG_ID, 'FIELDVALUE_ID'=>$this->FIELDVALUE_ID, 'SCHOLARSHIP_ID'=>$this->SCHOLARSHIP_ID, 'STATUS_ID'=>$this->STATUS_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID);//[RAD_CALLBACK_PARAMS]
	        $editLink = $this->getCallBack( modulecim_reg::PAGE_PROCESSFINANCIALTRANSACTIONS, $this->sortBy, $parameters );
	        $editLink .= "&". modulecim_reg::CCTRANS_ID . "=";
	//         $ccTransLinks[ "edit" ] = $editLink;
	        
	        // NOTE: delete link is same as edit link for an AdminBox
	//         $ccTransLinks[ "del" ] = $editLink;
	
	        $parameters = array('MINISTRY_ID'=>$this->MINISTRY_ID, 'IS_IN_REG_PROCESS'=>$this->IS_IN_REG_PROCESS, 'PERSON_ID'=>$this->PERSON_ID, 'EVENT_ID'=>$this->EVENT_ID, 'FIELDTYPE_ID'=>$this->FIELDTYPE_ID, 'PRICERULETYPE_ID'=>$this->PRICERULETYPE_ID, 'CCTYPE_ID'=>$this->CCTYPE_ID, 'PRIV_ID'=>$this->PRIV_ID, 'VIEWER_ID'=>$this->VIEWER_ID, 'SUPERADMIN_ID'=>$this->SUPERADMIN_ID, 'EVENTADMIN_ID'=>$this->EVENTADMIN_ID, 'FIELD_ID'=>$this->FIELD_ID, 'DATATYPE_ID'=>$this->DATATYPE_ID, 'PRICERULE_ID'=>$this->PRICERULE_ID, 'CAMPUSACCESS_ID'=>$this->CAMPUSACCESS_ID, 'CASHTRANS_ID'=>$this->CASHTRANS_ID, 'REG_ID'=>$this->REG_ID, 'FIELDVALUE_ID'=>$this->FIELDVALUE_ID, 'SCHOLARSHIP_ID'=>$this->SCHOLARSHIP_ID, 'STATUS_ID'=>$this->STATUS_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID);//[RAD_CALLBACK_PARAMS]
	        $sortByLink = $this->getCallBack( modulecim_reg::PAGE_PROCESSFINANCIALTRANSACTIONS, '', $parameters );
	        $sortByLink .= "&".modulecim_reg::SORTBY."=";
	        $ccTransLinks["sortBy"] = $sortByLink;        
	        
	        
	        $this->pageDisplay->setLinks( $links, $cashTransLinks, $ccTransLinks, $disabledLink);       
	        //$this->previous_page = modulecim_reg::PAGE_EDITREGISTRATIONDETAILS;   
        }
        else
        {
	        $this->pageDisplay = new page_NotAuthorized($this->moduleRootPath, $this->viewer);  
        }                         
    } // end loadProcessFinancialTransactions()
    

    //************************************************************************
	/**
	 * function loadProcessCashTransaction
	 * <pre>
	 * Initializes the ProcessCashTransaction Page.
	 * </pre>
	 * @return [void]
	 */
    // RAD Tools: FormSingleEntry style
    function loadProcessCashTransaction() 
    {
        // set the pageCallBack to be without any additional parameters
        // (an AdminBox needs this so Language Switching on a page doesn't
        // pass a previous operations)
        $parameters = array('MINISTRY_ID'=>$this->MINISTRY_ID, 'CASHTRANS_ID'=>$this->CASHTRANS_ID, 'REG_ID'=>$this->REG_ID);//[RAD_CALLBACK_PARAMS]
        $pageCallBack = $this->getCallBack(modulecim_reg::PAGE_PROCESSCASHTRANSACTIONPAGE, $this->sortBy, $parameters);
        $this->setPageCallBack( $pageCallBack );
        
        
        $parameters = array('MINISTRY_ID'=>$this->MINISTRY_ID, 'CASHTRANS_ID'=>$this->CASHTRANS_ID, 'REG_ID'=>$this->REG_ID);//[RAD_CALLBACK_PARAMS]
        $formAction = $this->getCallBack(modulecim_reg::PAGE_PROCESSCASHTRANSACTIONPAGE, $this->sortBy, $parameters );
        $this->pageDisplay = new FormProcessor_ProcessCashTransaction( $this->moduleRootPath, $this->viewer, $formAction, $this->CASHTRANS_ID , $this->REG_ID);//[RAD_FORMINIT_FOREIGNKEY_INIT]        

    } // end loadProcessCashTransaction()
    
    
    //************************************************************************
	/**
	 * function loadProcessCCTransaction
	 * <pre>
	 * Initializes the ProcessCCTransaction Page.
	 * </pre>
	 * @return [void]
	 */
    // RAD Tools: FormSingleEntry style
    function loadProcessCCTransaction() 
    {
        // set the pageCallBack to be without any additional parameters
        // (an AdminBox needs this so Language Switching on a page doesn't
        // pass a previous operations)
        $parameters = array('MINISTRY_ID'=>$this->MINISTRY_ID, 'CCTRANS_ID'=>$this->CASHTRANS_ID, 'REG_ID'=>$this->REG_ID);//[RAD_CALLBACK_PARAMS]
        $pageCallBack = $this->getCallBack(modulecim_reg::PAGE_PROCESSCCTRANSACTIONPAGE, $this->sortBy, $parameters);
        $this->setPageCallBack( $pageCallBack );
        
        
        $parameters = array('MINISTRY_ID'=>$this->MINISTRY_ID, 'CCTRANS_ID'=>$this->CCTRANS_ID, 'REG_ID'=>$this->REG_ID);//[RAD_CALLBACK_PARAMS]
        $formAction = $this->getCallBack(modulecim_reg::PAGE_PROCESSCCTRANSACTIONPAGE, $this->sortBy, $parameters );
        $this->pageDisplay = new FormProcessor_ProcessCCTransaction( $this->moduleRootPath, $this->viewer, $formAction, $this->CCTRANS_ID , $this->REG_ID);//[RAD_FORMINIT_FOREIGNKEY_INIT]        

    } // end loadProcessCCTransaction()    
    
    
   


    //************************************************************************
	/**
	 * function loadScholarshipDisplayList
	 * <pre>
	 * Initializes the ScholarshipDisplayList Page.
	 * </pre>
	 * @return [void]
	 */
    // RAD Tools: DataListTable Style
    function loadScholarshipDisplayList() 
    {
        // set the pageCallBack to be without any additional parameters
        // (an AdminBox needs this so Language Switching on a page doesn't
        // pass a previous operations)
        $parameters = array('MINISTRY_ID'=>$this->MINISTRY_ID, 'EVENT_ID'=>$this->EVENT_ID, 'FIELDTYPE_ID'=>$this->FIELDTYPE_ID, 'PRICERULETYPE_ID'=>$this->PRICERULETYPE_ID, 'CCTYPE_ID'=>$this->CCTYPE_ID, 'PRIV_ID'=>$this->PRIV_ID, 'VIEWER_ID'=>$this->VIEWER_ID, 'SUPERADMIN_ID'=>$this->SUPERADMIN_ID, 'EVENTADMIN_ID'=>$this->EVENTADMIN_ID, 'FIELD_ID'=>$this->FIELD_ID, 'DATATYPE_ID'=>$this->DATATYPE_ID, 'PRICERULE_ID'=>$this->PRICERULE_ID, 'CAMPUSACCESS_ID'=>$this->CAMPUSACCESS_ID, 'CASHTRANS_ID'=>$this->CASHTRANS_ID, 'CCTRANS_ID'=>$this->CCTRANS_ID, 'REG_ID'=>$this->REG_ID, 'FIELDVALUE_ID'=>$this->FIELDVALUE_ID, 'SCHOLARSHIP_ID'=>$this->SCHOLARSHIP_ID, 'STATUS_ID'=>$this->STATUS_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'PERSON_ID'=>$this->PERSON_ID);//[RAD_CALLBACK_PARAMS]
        $pageCallBack = $this->getCallBack(modulecim_reg::PAGE_SCHOLARSHIPDISPLAYLIST, $this->sortBy, $parameters);
        $this->setPageCallBack( $pageCallBack );
        
        
        $this->pageDisplay = new page_ScholarshipDisplayList( $this->moduleRootPath, $this->viewer, $this->sortBy, $this->REG_ID );    
        
        $links = array();
        
/*[RAD_LINK_INSERT]*/

        $parameters = array('MINISTRY_ID'=>$this->MINISTRY_ID, 'EVENT_ID'=>$this->EVENT_ID, 'FIELDTYPE_ID'=>$this->FIELDTYPE_ID, 'PRICERULETYPE_ID'=>$this->PRICERULETYPE_ID, 'CCTYPE_ID'=>$this->CCTYPE_ID, 'PRIV_ID'=>$this->PRIV_ID, 'VIEWER_ID'=>$this->VIEWER_ID, 'SUPERADMIN_ID'=>$this->SUPERADMIN_ID, 'EVENTADMIN_ID'=>$this->EVENTADMIN_ID, 'FIELD_ID'=>$this->FIELD_ID, 'DATATYPE_ID'=>$this->DATATYPE_ID, 'PRICERULE_ID'=>$this->PRICERULE_ID, 'CAMPUSACCESS_ID'=>$this->CAMPUSACCESS_ID, 'CASHTRANS_ID'=>$this->CASHTRANS_ID, 'CCTRANS_ID'=>$this->CCTRANS_ID, 'REG_ID'=>$this->REG_ID, 'FIELDVALUE_ID'=>$this->FIELDVALUE_ID, 'SCHOLARSHIP_ID'=>$this->SCHOLARSHIP_ID, 'STATUS_ID'=>$this->STATUS_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'PERSON_ID'=>$this->PERSON_ID);//[RAD_CALLBACK_PARAMS]
        $sortByLink = $this->getCallBack( modulecim_reg::PAGE_SCHOLARSHIPDISPLAYLIST, '', $parameters );
        $sortByLink .= "&".modulecim_reg::SORTBY."=";
        $links["sortBy"] = $sortByLink;

        $this->pageDisplay->setLinks( $links ); 
        
    } // end loadScholarshipDisplayList()



    //************************************************************************
	/**
	 * function loadDisplayCCtransactionReceipt
	 * <pre>
	 * Initializes the DisplayCCtransactionReceipt Page.
	 * </pre>
	 * @return [void]
	 */
    // RAD Tools: DataListTable Style
    function loadDisplayCCtransactionReceipt() 
    {
	    // get privileges for the current viewer
        $privManager = new PrivilegeManager( $this->viewer->getID() );  
        if (($this->IS_IN_REG_PROCESS == modulecim_reg::IS_SIGNUP)||($privManager->isCampusAdmin($this->EVENT_ID, $this->CAMPUS_ID)==true))	// check if privilege level is high enough
        {	
	        // set the pageCallBack to be without any additional parameters
	        // (an AdminBox needs this so Language Switching on a page doesn't
	        // pass a previous operations)
	        $parameters = array('MINISTRY_ID'=>$this->MINISTRY_ID, 'EVENT_ID'=>$this->EVENT_ID, 'FIELDTYPE_ID'=>$this->FIELDTYPE_ID, 'PRICERULETYPE_ID'=>$this->PRICERULETYPE_ID, 'CCTYPE_ID'=>$this->CCTYPE_ID, 'PRIV_ID'=>$this->PRIV_ID, 'VIEWER_ID'=>$this->VIEWER_ID, 'SUPERADMIN_ID'=>$this->SUPERADMIN_ID, 'EVENTADMIN_ID'=>$this->EVENTADMIN_ID, 'FIELD_ID'=>$this->FIELD_ID, 'DATATYPE_ID'=>$this->DATATYPE_ID, 'PRICERULE_ID'=>$this->PRICERULE_ID, 'CAMPUSACCESS_ID'=>$this->CAMPUSACCESS_ID, 'CASHTRANS_ID'=>$this->CASHTRANS_ID, 'CCTRANS_ID'=>$this->CCTRANS_ID, 'REG_ID'=>$this->REG_ID, 'FIELDVALUE_ID'=>$this->FIELDVALUE_ID, 'SCHOLARSHIP_ID'=>$this->SCHOLARSHIP_ID, 'STATUS_ID'=>$this->STATUS_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'PERSON_ID'=>$this->PERSON_ID, 'RECEIPT_ID'=>$this->RECEIPT_ID);//[RAD_CALLBACK_PARAMS]
	        $pageCallBack = $this->getCallBack(modulecim_reg::PAGE_DISPLAYCCTRANSACTIONRECEIPT, $this->sortBy, $parameters);
	        $this->setPageCallBack( $pageCallBack );
	        
	        $this->pageDisplay = new page_DisplayCCtransactionReceipt( $this->moduleRootPath, $this->viewer, $this->sortBy, $this->REG_ID, $this->CCTRANS_ID, $this->PERSON_ID );    
	        
	        $links = array();
	        
	        $parameters = array('MINISTRY_ID'=>$this->MINISTRY_ID, 'IS_IN_REG_PROCESS'=>$this->IS_IN_REG_PROCESS, 'EVENT_ID'=>$this->EVENT_ID, 'FIELDTYPE_ID'=>$this->FIELDTYPE_ID, 'PRICERULETYPE_ID'=>$this->PRICERULETYPE_ID, 'CCTYPE_ID'=>$this->CCTYPE_ID, 'PRIV_ID'=>$this->PRIV_ID, 'VIEWER_ID'=>$this->VIEWER_ID, 'SUPERADMIN_ID'=>$this->SUPERADMIN_ID, 'EVENTADMIN_ID'=>$this->EVENTADMIN_ID, 'FIELD_ID'=>$this->FIELD_ID, 'DATATYPE_ID'=>$this->DATATYPE_ID, 'PRICERULE_ID'=>$this->PRICERULE_ID, 'CAMPUSACCESS_ID'=>$this->CAMPUSACCESS_ID, 'CASHTRANS_ID'=>$this->CASHTRANS_ID, 'CCTRANS_ID'=>$this->CCTRANS_ID, 'REG_ID'=>$this->REG_ID, 'FIELDVALUE_ID'=>$this->FIELDVALUE_ID, 'SCHOLARSHIP_ID'=>$this->SCHOLARSHIP_ID, 'STATUS_ID'=>$this->STATUS_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'PERSON_ID'=>$this->PERSON_ID, 'RECEIPT_ID'=>$this->RECEIPT_ID);//[RAD_CALLBACK_PARAMS]
	        if ((isset($this->IS_IN_REG_PROCESS))&&($this->IS_IN_REG_PROCESS > modulecim_reg::IS_FALSE))
	        {
					$continueLink = $this->getCallBack( modulecim_reg::PAGE_PROCESSFINANCIALTRANSACTIONS, "", $parameters );
	     	  }
	     	  else 
	     	  {
					$continueLink = $this->getCallBack( modulecim_reg::PAGE_EDITREGISTRATIONDETAILS, "", $parameters );
	     	  }	       
	        $links["cont"] = $continueLink;
	
	/*[RAD_LINK_INSERT]*/
	
	        $parameters = array('MINISTRY_ID'=>$this->MINISTRY_ID, 'IS_IN_REG_PROCESS'=>$this->IS_IN_REG_PROCESS, 'EVENT_ID'=>$this->EVENT_ID, 'FIELDTYPE_ID'=>$this->FIELDTYPE_ID, 'PRICERULETYPE_ID'=>$this->PRICERULETYPE_ID, 'CCTYPE_ID'=>$this->CCTYPE_ID, 'PRIV_ID'=>$this->PRIV_ID, 'VIEWER_ID'=>$this->VIEWER_ID, 'SUPERADMIN_ID'=>$this->SUPERADMIN_ID, 'EVENTADMIN_ID'=>$this->EVENTADMIN_ID, 'FIELD_ID'=>$this->FIELD_ID, 'DATATYPE_ID'=>$this->DATATYPE_ID, 'PRICERULE_ID'=>$this->PRICERULE_ID, 'CAMPUSACCESS_ID'=>$this->CAMPUSACCESS_ID, 'CASHTRANS_ID'=>$this->CASHTRANS_ID, 'CCTRANS_ID'=>$this->CCTRANS_ID, 'REG_ID'=>$this->REG_ID, 'FIELDVALUE_ID'=>$this->FIELDVALUE_ID, 'SCHOLARSHIP_ID'=>$this->SCHOLARSHIP_ID, 'STATUS_ID'=>$this->STATUS_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'PERSON_ID'=>$this->PERSON_ID, 'RECEIPT_ID'=>$this->RECEIPT_ID);//[RAD_CALLBACK_PARAMS]
	        $sortByLink = $this->getCallBack( modulecim_reg::PAGE_DISPLAYCCTRANSACTIONRECEIPT, '', $parameters );
	        $sortByLink .= "&".modulecim_reg::SORTBY."=";
	        $links["sortBy"] = $sortByLink;
	
	        $this->pageDisplay->setLinks( $links ); 

        }
        else
        {
	        $this->pageDisplay = new page_NotAuthorized($this->moduleRootPath, $this->viewer);  
        }          
    } // end loadDisplayCCtransactionReceipt()
    
    
    

    //************************************************************************
	/**
	 * function loadConfirmCancelRegistration
	 * <pre>
	 * Initializes the ConfirmCancelRegistration Page.
	 * </pre>
	 * @return [void]
	 */
    // RAD Tools: Custom style
    function loadConfirmCancelRegistration() 
    {
        // set the pageCallBack to be without any additional parameters
        // (an AdminBox needs this so Language Switching on a page doesn't
        // pass a previous operations)
        $parameters = array('EVENT_ID'=>$this->EVENT_ID, 'FIELDTYPE_ID'=>$this->FIELDTYPE_ID, 'PRICERULETYPE_ID'=>$this->PRICERULETYPE_ID, 'CCTYPE_ID'=>$this->CCTYPE_ID, 'PRIV_ID'=>$this->PRIV_ID, 'VIEWER_ID'=>$this->VIEWER_ID, 'SUPERADMIN_ID'=>$this->SUPERADMIN_ID, 'EVENTADMIN_ID'=>$this->EVENTADMIN_ID, 'FIELD_ID'=>$this->FIELD_ID, 'DATATYPE_ID'=>$this->DATATYPE_ID, 'PRICERULE_ID'=>$this->PRICERULE_ID, 'CAMPUSACCESS_ID'=>$this->CAMPUSACCESS_ID, 'CASHTRANS_ID'=>$this->CASHTRANS_ID, 'CCTRANS_ID'=>$this->CCTRANS_ID, 'REG_ID'=>$this->REG_ID, 'FIELDVALUE_ID'=>$this->FIELDVALUE_ID, 'SCHOLARSHIP_ID'=>$this->SCHOLARSHIP_ID, 'STATUS_ID'=>$this->STATUS_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'PERSON_ID'=>$this->PERSON_ID, 'RECEIPT_ID'=>$this->RECEIPT_ID);//[RAD_CALLBACK_PARAMS]
        $pageCallBack = $this->getCallBack(modulecim_reg::PAGE_CONFIRMCANCELREGISTRATION, $this->sortBy, $parameters);
        $this->setPageCallBack( $pageCallBack );
        
        $parameters = array('EVENT_ID'=>$this->EVENT_ID, 'FIELDTYPE_ID'=>$this->FIELDTYPE_ID, 'PRICERULETYPE_ID'=>$this->PRICERULETYPE_ID, 'CCTYPE_ID'=>$this->CCTYPE_ID, 'PRIV_ID'=>$this->PRIV_ID, 'VIEWER_ID'=>$this->VIEWER_ID, 'SUPERADMIN_ID'=>$this->SUPERADMIN_ID, 'EVENTADMIN_ID'=>$this->EVENTADMIN_ID, 'FIELD_ID'=>$this->FIELD_ID, 'DATATYPE_ID'=>$this->DATATYPE_ID, 'PRICERULE_ID'=>$this->PRICERULE_ID, 'CAMPUSACCESS_ID'=>$this->CAMPUSACCESS_ID, 'CASHTRANS_ID'=>$this->CASHTRANS_ID, 'CCTRANS_ID'=>$this->CCTRANS_ID, 'REG_ID'=>$this->REG_ID, 'FIELDVALUE_ID'=>$this->FIELDVALUE_ID, 'SCHOLARSHIP_ID'=>$this->SCHOLARSHIP_ID, 'STATUS_ID'=>$this->STATUS_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'PERSON_ID'=>$this->PERSON_ID, 'RECEIPT_ID'=>$this->RECEIPT_ID);//[RAD_CALLBACK_PARAMS]
        $formAction = $this->getCallBack(modulecim_reg::PAGE_CONFIRMCANCELREGISTRATION, $this->sortBy, $parameters ); 
        
        $this->PERSON_ID = $_REQUEST[modulecim_reg::PERSON_ID];             
        
        $this->pageDisplay = new page_ConfirmCancelRegistration( $this->moduleRootPath, $this->viewer, $formAction, $this->EVENT_ID, $this->PERSON_ID );   
        
//         $links = array();
//         
// /*[RAD_LINK_INSERT]*/

//         $this->pageDisplay->setLinks( $links );     

        
        
    } // end loadConfirmCancelRegistration()



/*[RAD_PAGE_LOAD_FN]*/	



	// this function generates the field values form 
	//   used for the 'edit registration details' page
	// that shows everything you want to know about somebody
	//
	private function loadFieldValuesForm(&$form)
	{  
		
		$fields = new RowManager_FieldManager();
		$fieldTypes = new RowManager_FieldTypeManager();
		$fieldValues = new RowManager_FieldValueManager();
		$fieldValues->setRegID($this->REG_ID);
		
		$formFieldValues = new MultiTableManager();
		$formFieldValues->addRowManager($fields);
		$formFieldValues->addRowManager($fieldTypes, new JoinPair( $fields->getJoinOnFieldTypeID(), $fieldTypes->getJoinOnFieldTypeID() ) );
		$formFieldValues->addRowManager($fieldValues, new JoinPair( $fields->getJoinOnFieldID(), $fieldValues->getJoinOnFieldID() ) );
		$formFieldValues->setSortOrder('fields_priority');
		
		$formFieldValuesList = $formFieldValues->getListIterator(); 
		$formFieldValuesArray = $formFieldValuesList->getDataList();		  
	
		$formFieldLabels = array();
		$formData = array();
		$fieldInfo = '';
		//		$isFirst = true;
		$fieldValue = '';
		reset($formFieldValuesArray);		// (below) store registration-specific form values for event-specific fields
			foreach(array_keys($formFieldValuesArray) as $k)
		{
			$row = current($formFieldValuesArray);	
		//			$field_value = $row['fieldvalues_value'];		
			
		  $fieldName = 'fields_id'.$row['fields_id'];
		  $fieldInfo .=  $fieldName.'|'.$row['fieldtypes_desc'].'|'.$row['datatypes_id'].'|'.$row['fields_reqd'].'|'.$row['fields_invalid'].'';
		  $formFieldLabels[ $fieldName ] = $row['fields_desc']; 
		  $fieldValue = $row['fieldvalues_value']; 
		  $formData[$fieldName] = $fieldValue; 
			
		  $fieldInfo .= ',';
			next($formFieldValuesArray);
		}
		$fieldInfo = substr($fieldInfo,0,-1);	// remove final ','
					
	   // set data in the form to be displayed 
		$form->setFields( $fieldInfo );
		$form->setFormData( $formData );
		$form->setLabels( $formFieldLabels );
		$form->setButtonText( 'Update' );
		
		// setup form action based on AppController standards
		$parameters = array('EVENT_ID'=>$this->EVENT_ID, 'FIELDTYPE_ID'=>$this->FIELDTYPE_ID, 'PRICERULETYPE_ID'=>$this->PRICERULETYPE_ID, 'CCTYPE_ID'=>$this->CCTYPE_ID, 'PRIV_ID'=>$this->PRIV_ID, 'VIEWER_ID'=>$this->VIEWER_ID, 'SUPERADMIN_ID'=>$this->SUPERADMIN_ID, 'EVENTADMIN_ID'=>$this->EVENTADMIN_ID, 'FIELD_ID'=>$this->FIELD_ID, 'DATATYPE_ID'=>$this->DATATYPE_ID, 'PRICERULE_ID'=>$this->PRICERULE_ID, 'CAMPUSACCESS_ID'=>$this->CAMPUSACCESS_ID, 'CASHTRANS_ID'=>$this->CASHTRANS_ID, 'CCTRANS_ID'=>$this->CCTRANS_ID, 'REG_ID'=>$this->REG_ID, 'FIELDVALUE_ID'=>$this->FIELDVALUE_ID, 'SCHOLARSHIP_ID'=>$this->SCHOLARSHIP_ID, 'STATUS_ID'=>$this->STATUS_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID);//[RAD_CALLBACK_PARAMS]
      $formAction = $this->getCallBack(modulecim_reg::PAGE_EDITREGISTRATIONFIELDVALUESFORM, $this->sortBy, $parameters );
		$form->setFormAction( $formAction );	
				
		return;
	}	
	

	        //************************************************************************
	/**
	 * function loadDownloadReport
	 * <pre>
	 * Initializes the DownloadReport Page.
	 * </pre>
	 * @param $isCreated [BOOL] "Is THIS pageDisplay object already created?"
	 * @return [void]
	 */
    // RAD Tools: DisplayList Style (modified)
    function loadDownloadReport( $isCreated=false ) 
    {	
	    // get privileges for the current viewer
        $privManager = new PrivilegeManager( $this->viewer->getID() );  
        if ($privManager->isCampusAdmin($this->EVENT_ID, $this->CAMPUS_ID)==true)	
        {		    
		    
	        // set the pageCallBack to be without any additional parameters
	        // (an AdminBox needs this so Language Switching on a page doesn't
	        // pass a previous operations)
	        $parameters = array('EVENT_ID'=>$this->EVENT_ID, 'FIELDTYPE_ID'=>$this->FIELDTYPE_ID, 'PRICERULETYPE_ID'=>$this->PRICERULETYPE_ID, 'CCTYPE_ID'=>$this->CCTYPE_ID, 'PRIV_ID'=>$this->PRIV_ID, 'VIEWER_ID'=>$this->VIEWER_ID, 'SUPERADMIN_ID'=>$this->SUPERADMIN_ID, 'EVENTADMIN_ID'=>$this->EVENTADMIN_ID, 'FIELD_ID'=>$this->FIELD_ID, 'DATATYPE_ID'=>$this->DATATYPE_ID, 'PRICERULE_ID'=>$this->PRICERULE_ID, 'CAMPUSACCESS_ID'=>$this->CAMPUSACCESS_ID, 'CASHTRANS_ID'=>$this->CASHTRANS_ID, 'CCTRANS_ID'=>$this->CCTRANS_ID, 'REG_ID'=>$this->REG_ID, 'FIELDVALUE_ID'=>$this->FIELDVALUE_ID, 'SCHOLARSHIP_ID'=>$this->SCHOLARSHIP_ID, 'STATUS_ID'=>$this->STATUS_ID, 'DOWNLOAD_TYPE'=>$this->DOWNLOAD_TYPE);//[RAD_CALLBACK_PARAMS]
	        $pageCallBack = $this->getCallBack(modulecim_reg::PAGE_DOWNLOADREPORT, $this->sortBy, $parameters);
	        $this->setPageCallBack( $pageCallBack );        
	        	        
	        $links = array();
	        
	        	//$this->getCallBack( modulecim_reg::PAGE_EDITCAMPUSASSIGNMENT, '', $parameters );
	// 		  $link1 = SITE_PATH_MODULES.'app_'.modulecim_reg::MODULE_KEY.'/objects_pages/'.modulecim_reg::CSV_DOWNLOAD_TOOL.'?'.modulecim_reg::EVENT_ID.'='.$this->EVENT_ID.'&'.modulecim_reg::DOWNLOAD_TYPE.'='.modulecim_reg::DOWNLOAD_EVENT_DATA;	//$this->getCallBack( modulecim_reg::PAGE_ADMINEVENTHOME, '', $fileDownloadParameters );
			  $file_name1 = rand(1,MAX_TEMP_SEED).modulecim_reg::EVENT_DATA_FILE_NAME;
			  $link1 = SITE_PATH_REPORTS.$file_name1;
	//        $link1 .= "&".modulecim_reg::SORTBY."=";
			  $file_name2 = rand(1,MAX_TEMP_SEED).modulecim_reg::EVENT_SCHOLARSHIP_FILE_NAME;
			  $link2 = SITE_PATH_REPORTS.$file_name2;
			  
			  $file_names = $file_name1.','.$file_name2;
			  
			  // NOTE: file names *MUST* be set first, otherwise file cannot be downloaded by user
	        $this->pageDisplay = new page_DownloadReport( $this->moduleRootPath, $this->viewer, $this->DOWNLOAD_TYPE, $this->EVENT_ID, $this->CAMPUS_ID, $file_names );    		  
	        
	/*[RAD_LINK_INSERT]*/
		     $links[ "DownloadEventDataDump" ] = $link1;
			  $links[ "DownloadScholarshipDataDump" ] = $link2;
	  
	        $parameters = array( 'EVENT_ID'=>$this->EVENT_ID, 'FIELDTYPE_ID'=>$this->FIELDTYPE_ID);//[RAD_CALLBACK_PARAMS]
	        $continueLink = $this->getCallBack( modulecim_reg::PAGE_ADMINEVENTHOME, "", $parameters );
	        $links["cont"] = $continueLink;		  

	        $this->pageDisplay->setLinks( $links ); 
	        //$this->previous_page = modulecim_reg::PAGE_HOMEPAGEEVENTLIST;   
        }
        else
        {
	        $this->pageDisplay = new page_NotAuthorized($this->moduleRootPath, $this->viewer);  
        }         
    }	    
	

    /**
	 * function loadDownloadAIARegReport
	 * <pre>
	 * Initializes the DownloadAIARegReport Page.
	 * </pre>
	 * @return [void]
	 */    
    function loadDownloadAIARegReport()
    {	
	    // get privileges for the current viewer
         $privManager = new PrivilegeManager( $this->viewer->getID() );  
         if ($privManager->isCampusAdmin($this->EVENT_ID, $this->CAMPUS_ID)==true)	
         {		    
		    
	        // set the pageCallBack to be without any additional parameters
	        // (an AdminBox needs this so Language Switching on a page doesn't
	        // pass a previous operations)
	        $parameters = array('EVENT_ID'=>$this->EVENT_ID, 'PRIV_ID'=>$this->PRIV_ID, 'VIEWER_ID'=>$this->VIEWER_ID, 'REG_ID'=>$this->REG_ID);//[RAD_CALLBACK_PARAMS]
	        $pageCallBack = $this->getCallBack(modulecim_reg::PAGE_DOWNLOADAIAREGREPORT, $this->sortBy, $parameters);
	        $this->setPageCallBack( $pageCallBack );        
	        
	        $this->pageDisplay = new page_DownloadAIARegReport( $this->moduleRootPath, $this->viewer, $this->EVENT_ID );    
	        
	        $links = array();
	        
	/*[RAD_LINK_INSERT]*/
	
	//$this->getCallBack( modulecim_reg::PAGE_EDITCAMPUSASSIGNMENT, '', $parameters );
	// 		  $link1 = SITE_PATH_MODULES.'app_'.moduleaia_reg::MODULE_KEY.'/objects_pages/'.moduleaia_reg::CSV_DOWNLOAD_TOOL.'?'.moduleaia_reg::EVENT_ID.'='.$this->EVENT_ID.'&'.modulecim_reg::DOWNLOAD_TYPE.'='.modulecim_reg::DOWNLOAD_EVENT_DATA;	//$this->getCallBack( modulecim_reg::PAGE_ADMINEVENTHOME, '', $fileDownloadParameters );
			  $link1 = SITE_PATH_REPORTS.modulecim_reg::AIA_CSV_FILE_NAME;
	
	        $links[ "DownloadEventDataDump" ] = $link1;
			  
// 	        $parameters = array( 'EVENT_ID'=>$this->EVENT_ID, 'FIELDTYPE_ID'=>$this->FIELDTYPE_ID);//[RAD_CALLBACK_PARAMS]
// 	        $continueLink = $this->getCallBack( moduleaia_reg::PAGE_ADMINEVENTHOME, "", $parameters );
// 	        $links["cont"] = $continueLink;		  
	
	        $this->pageDisplay->setLinks( $links ); 
	        //$this->previous_page = moduleaia_reg::PAGE_HOMEPAGEEVENTLIST;   
        }
        else
        {
	        $this->pageDisplay = new page_NotAuthorized($this->moduleRootPath, $this->viewer);  
        } 
     } 
     
     
     
     
   //************************************************************************
	/**
	 * function loadEmailComposer
	 * <pre>
	 * Initializes the EmailComposer Page.
	 * </pre>
	 * @param $isCreated [BOOL] "Is THIS pageDisplay object already created?"
	 * @param $emailParams [ARRAY] contains to&from e-mail addresses, subject, and body
	 * @return [void]
	 */
    // RAD Tools: DataSingle Style
    function loadEmailComposer($isCreated=false)	//, $emailParams = '', $module = 'app_cim_reg')
    {

	    // get privileges for the current viewer
        $privManager = new PrivilegeManager( $this->viewer->getID() );  
        if ($privManager->isCampusAdmin($this->EVENT_ID, $this->CAMPUS_ID)==true)	// check if privilege level is high enough
        {	
	        
	        // set the pageCallBack to be without any additional parameters:  TODO: have it point to PAGE_EDITCAMPUSASSIGNMENT
	        // (an AdminBox needs this so Language Switching on a page doesn't
	        // pass a previous operations)
	        $parameters = array('EVENT_ID'=>$this->EVENT_ID, 'REG_ID'=>$this->REG_ID, 'PERSON_ID'=>$this->PERSON_ID,  'CAMPUS_ID'=>$this->CAMPUS_ID, 'PRIV_ID'=>$this->PRIV_ID);//[RAD_CALLBACK_PARAMS]
				// 'PROVINCE_ID'=>$this->PROVINCE_ID, 'GENDER_ID'=>$this->GENDER_ID, 'STAFF_ID'=>$this->STAFF_ID, 'USER_ID'=>$this->USER_ID, 'ASSIGNMENT_ID'=>$this->ASSIGNMENT_ID, 'ADMIN_ID'=>$this->ADMIN_ID, 'CAMPUSADMIN_ID'=>$this->CAMPUSADMIN_ID
	        $pageCallBack = $this->getCallBack(modulecim_reg::PAGE_EMAILCOMPOSER, $this->sortBy, $parameters);
	        $this->setPageCallBack( $pageCallBack );
	        
	        $formTo_page = '';
		     $formTo_page = modulecim_reg::PAGE_EMAILCOMPOSER;
	
	        // NOTE: making use of previous_page variable to return to a dynamic page
	        $formAction = $this->getCallBack($formTo_page, $this->sortBy, $parameters );
	        
	        $links = array();
	
	        $parameters = array('EVENT_ID'=>$this->EVENT_ID);	//'PERSON_ID'=>$this->PERSON_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'PRIV_ID'=>$this->PRIV_ID);//[RAD_CALLBACK_PARAMS]
			  $backLink = $this->getCallBack( modulecim_reg::PAGE_ADMINEVENTHOME, "", $parameters );
			  // also could go back to: PAGE_EDITCAMPUSREGISTRATIONS
    		  $links["back"] = $backLink;
    		  
    		  $parameters = array('EVENT_ID'=>$this->EVENT_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID);
    		  $jumpLink = $this->getCallBack( modulecim_reg::PAGE_EMAILCOMPOSER, $this->sortBy, $parameters ); //'', '', '', '', '', '' );//[RAD_CALLBACK_PARAMS_EDIT]
	        $jumpLink .= "&". modulecim_reg::TO_EMAIL_CHOICE . "=";			/** NEW param to implement **/
	        $links["jumpLink"] = $jumpLink;	        
	        
// 	       if ( !$isCreated ) {
        		
	        		// create new form display object			// $emailParams, 
	        		$this->pageDisplay = new FormProcessor_EmailComposer( $this->moduleRootPath, $this->viewer, $formAction,$this->EVENT_ID, $this->CAMPUS_ID, $this->TO_EMAIL_CHOICE, $jumpLink );	
	   	        
// 	        } else {
// 	        
// 	            // otherwise just update the formAction value
// 	            $this->pageDisplay->setFormAction( $formAction );
// 	        }  


	
	        $this->pageDisplay->setLinks( $links );
	        
	        $this->addScript('MM_jumpMenu.jsp');
    
  
        }
        else
        {
	        $this->pageDisplay = new page_NotAuthorized($this->moduleRootPath, $this->viewer);  
        }  
    } // end loadPersonInfo()
    
    
         
    /**
	 * function loadPersonRecordCleanUpForm
	 * <pre>
	 * Initializes the PersonRecordCleanUpForm Page.
	 * </pre>
	 * @return [void]
	 */    
    function loadPersonRecordCleanUpForm()
    {	
	    // get privileges for the current viewer
         $privManager = new PrivilegeManager( $this->viewer->getID() );  
         if ($privManager->isSuperAdmin()==true)	
         {		    
		    
	        // set the pageCallBack to be without any additional parameters
	        // (an AdminBox needs this so Language Switching on a page doesn't
	        // pass a previous operations)
	        $parameters = array('PRIV_ID'=>$this->PRIV_ID, 'VIEWER_ID'=>$this->VIEWER_ID);//[RAD_CALLBACK_PARAMS]
	        $pageCallBack = $this->getCallBack(modulecim_reg::PAGE_PERSONRECORDCLEANUP_FORM, $this->sortBy, $parameters);
	        $this->setPageCallBack( $pageCallBack );        
	        
	        $this->pageDisplay = new FormProcessor_PersonRecordCleanUpForm( $this->moduleRootPath, $this->viewer, $this->sortBy);    
	        
// 	        $links = array();
// 			  $processLink = $this->getCallBack( modulecim_reg::PAGE_PROCESSFINANCIALTRANSACTIONS, "", $parameters );      
// 	        $links["process"] = $processLink;
	
// 	        $this->pageDisplay->setLinks( $links );  
        }
        else
        {
	        $this->pageDisplay = new page_NotAuthorized($this->moduleRootPath, $this->viewer);  
        } 
     }      
     
     
    /**
	 * function loadPersonRecordCleanUp
	 * <pre>
	 * Initializes the PersonRecordCleanUp Page.
	 * </pre>
	 * @params	<person data filter parameters: first name, last name, e-mail, max exec time>
	 * @return [void]
	 */    
    function loadPersonRecordCleanUp($person_fname, $person_lname, $person_email, $max_exec_time)
    {	
	    // get privileges for the current viewer
         $privManager = new PrivilegeManager( $this->viewer->getID() );  
         if ($privManager->isSuperAdmin()==true)	
         {		    
		    
	        // set the pageCallBack to be without any additional parameters
	        // (an AdminBox needs this so Language Switching on a page doesn't
	        // pass a previous operations)
	        $parameters = array('PRIV_ID'=>$this->PRIV_ID, 'VIEWER_ID'=>$this->VIEWER_ID);//[RAD_CALLBACK_PARAMS]
	        $pageCallBack = $this->getCallBack(modulecim_reg::PAGE_PERSONRECORDCLEANUP, $this->sortBy, $parameters);
	        $this->setPageCallBack( $pageCallBack );        
	        
	        $this->pageDisplay = new page_PersonRecordCleanUp( $this->moduleRootPath, $this->viewer, $this->sortBy, $person_fname, $person_lname, $person_email, $max_exec_time);    
	        
 	        $links = array();
	        $parameters = array();	//, 'FIELDTYPE_ID'=>$this->FIELDTYPE_ID, 'PRICERULETYPE_ID'=>$this->PRICERULETYPE_ID, 'CCTYPE_ID'=>$this->CCTYPE_ID, 'PRIV_ID'=>$this->PRIV_ID, 'VIEWER_ID'=>$this->VIEWER_ID, 'SUPERADMIN_ID'=>$this->SUPERADMIN_ID, 'EVENTADMIN_ID'=>$this->EVENTADMIN_ID, 'FIELD_ID'=>$this->FIELD_ID, 'DATATYPE_ID'=>$this->DATATYPE_ID, 'PRICERULE_ID'=>$this->PRICERULE_ID, 'CAMPUSACCESS_ID'=>$this->CAMPUSACCESS_ID, 'CASHTRANS_ID'=>$this->CASHTRANS_ID, 'CCTRANS_ID'=>$this->CCTRANS_ID, 'REG_ID'=>$this->REG_ID, 'FIELDVALUE_ID'=>$this->FIELDVALUE_ID, 'SCHOLARSHIP_ID'=>$this->SCHOLARSHIP_ID, 'STATUS_ID'=>$this->STATUS_ID);	//, 'CAMPUS_ID'=>$this->CAMPUS_ID);//[RAD_CALLBACK_PARAMS]
	        $continueLink = $this->getCallBack( modulecim_reg::PAGE_PERSONRECORDCLEANUP_FORM, "", $parameters );
	        $links["cont"] = $continueLink;
	
 	        $this->pageDisplay->setLinks( $links );  
        }
        else
        {
	        $this->pageDisplay = new page_NotAuthorized($this->moduleRootPath, $this->viewer);  
        } 
     } 
}

?>
