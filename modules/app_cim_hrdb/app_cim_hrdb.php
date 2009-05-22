<?php

/**
 * @package cim_hrdb
 class modulecim_hrdb
 discussion <pre>
 Written By	:	CIM Team
 Date		:   17 Mar 2006

 Manages human resource information for students and staff in the Canadian campus ministry.

 </pre>
*/
class modulecim_hrdb extends XMLObject_PageContent {
//
//
//	CONSTANTS:
    /** const SENIORITY_DATA_FILE_NAME The name/suffix of the file where campus student seniority data is stored */
        const SENIORITY_DATA_FILE_NAME = 'seniorityDataDump.csv';
        
    /** const ACTIVITIES_DATA_FILE_NAME The name/suffix of the file where staff activity data is stored */
        const ACTIVITIES_DATA_FILE_NAME = 'staffActivityDataDump.csv';

    /** const CUSTOMREPORT_DATA_FILE_NAME The name/suffix of the file where custom report data is stored */
        const CUSTOMREPORT_DATA_FILE_NAME = 'customReportDataDump.csv';
                
    /** const MULTILINGUAL_SERIES_KEY The Multilingual Series key for this application.. */
        const MULTILINGUAL_SERIES_KEY = 'modulecim_hrdb';

    /** const MULTILINGUAL_PAGE_FIELDS The Multilingual Page key for the fields of this application. */
        const MULTILINGUAL_PAGE_FIELDS = 'fields_cim_hrdb';

    /** const MODULE_KEY The Module Key for this Module.  Used for access */
        const MODULE_KEY = 'cim_hrdb';

    /** const PAGE    The QueryString Page parameter. */
        const PAGE = "P";

    /** const PAGE_EDITMYINFO   Display the EditMyInfo Page. */
        const PAGE_EDITMYINFO = "P1";

    /** const PAGE_HRDBHOME   Display the HrdbHome Page. */
        const PAGE_HRDBHOME = "P2";

    /** const PAGE_PROVINCES   Display the Provinces Page. */
        const PAGE_PROVINCES = "P5";

    /** const PAGE_IMPORTDATA   Display the ImportData Page. */
        const PAGE_IMPORTDATA = "PIM";

    /** const PAGE_CAMPUSES   Display the Campuses Page. */
        const PAGE_CAMPUSES = "P7";

    /** const PAGE_PEOPLE   Display the People Page. */
        const PAGE_PEOPLE = "P8";

    /** const PAGE_NEWPERSON   Display the NewPerson Page. */
        const PAGE_NEWPERSON = "P10";

    /** const PAGE_PRIVILEGES   Display the Privileges Page. */
        const PAGE_PRIVILEGES = "P11";

    /** const PAGE_PEOPLELIST   Display the PeopleList Page. */
        const PAGE_PEOPLELIST = "P12";

    /** const PAGE_DELETEPERSON   Display the DeletePerson Page. */
        const PAGE_DELETEPERSON = "P13";

    // TODO take out this variable
    /** const PAGE_VIEWSTAFF   Display the ViewStaff Page. */
        const PAGE_VIEWSTAFF = "P14";

    /** const PAGE_ADDADMIN   Display the AddAdmin Page. */
        const PAGE_ADDADMIN = "P15";

    /** const PAGE_EDITPERSON   Display the EditPerson Page. */
        const PAGE_EDITPERSON = "P17";

    /** const PAGE_ADDSTAFF   Display the AddStaff Page. */
        const PAGE_ADDSTAFF = "P18";

    /** const PAGE_STAFF   Display the Staff Page. */
        const PAGE_STAFF = "P19";

    /** const PAGE_DELETESTAFF   Display the DeleteStaff Page. */
        const PAGE_DELETESTAFF = "P20";

    /** const PAGE_ADMINS   Display the Admins Page. */
        const PAGE_ADMINS = "P23";

    /** const PAGE_DELETEADMIN   Display the DeleteAdmin Page. */
        const PAGE_DELETEADMIN = "P24";

    // used to see the assigned campuses to the priviledge level
    /** const PAGE_VIEWCAMPUSES   Display the ViewCampuses Page. */
        const PAGE_VIEWCAMPUSES = "P25";

    /** const PAGE_CAMPUSASSIGNMENTS   Display the CampusAssignments Page. */
        const PAGE_CAMPUSASSIGNMENTS = "P26";

    /** const PAGE_PERSONINFO   Display the PersonInfo Page. */
        const PAGE_PERSONINFO = "P28";

    /** const PAGE_PEOPLECAMPUS   Display the PeopleCampus Page. */
        const PAGE_PEOPLECAMPUS = "P29";

    /** const PAGE_PEOPLEBYCAMPUSES   Display the PeoplebyCampuses Page. */
        const PAGE_PEOPLEBYCAMPUSES = "P30";

    /** const PAGE_ADMINPRIVS   Display the AdminPrivs Page. */
        const PAGE_ADMINPRIVS = "P31";

    /** const PAGE_NEWACCOUNT   Display the NewAccount Page. */
        const PAGE_NEWACCOUNT = "P33";

    /** const PAGE_EDITMYEMERGINFO   Display the EditMyEmergInfo Page. */
        const PAGE_EDITMYEMERGINFO = "P21";

    /** const PAGE_EDITCAMPUSASSIGNMENTSTATUSTYPES   Display the EditCampusAssignmentStatusTypes Page. */
        const PAGE_EDITCAMPUSASSIGNMENTSTATUSTYPES = "P51";

    /** const PAGE_EDITCAMPUSASSIGNMENT   Display the EditCampusAssignment Page. */
        const PAGE_EDITCAMPUSASSIGNMENT = "P54";

    /** const PAGE_EDITREGION   Display the EditRegion Page. */
        const PAGE_EDITREGION = "P64";

    /** const PAGE_EDITPEOPLE   Display the EditPeople Page. */
        const PAGE_EDITPEOPLE = "P65";

    /** const PAGE_EDITACCESSASSIGNMENT   Display the EditAccessAssignment Page. */
        const PAGE_EDITACCESSASSIGNMENT = "P66";

    /** const PAGE_EDITMYCAMPUSASSIGNMENT   Display the EditMyCampusAssignment Page. */
        const PAGE_EDITMYCAMPUSASSIGNMENT = "P87";

    /** const PAGE_EDITMYYEARINSCHOOL   Display the EditMyYearInSchool Page. */
        const PAGE_EDITMYYEARINSCHOOL = "P89";
        
    /** const PAGE_EDITSTUDENTYEARINSCHOOL   Display the EditStudentYearInSchool Page. */
        const PAGE_EDITSTUDENTYEARINSCHOOL = "P90";      
        
    /** const PAGE_VIEWSTUDENTYEARINSCHOOL   Display the ViewStudentYearInSchool Page. */
        const PAGE_VIEWSTUDENTYEARINSCHOOL = "P91";     
        
    /** const PAGE_COUNTRIES   Display the Countries Page. */
        const PAGE_COUNTRIES = "P92";       
        
    /** const PAGE_DOWNLOADCSV   Display the DownloadCSV Page. */
        const PAGE_DOWNLOADCSV = "P93";                

    /** const PAGE_HRDBFORMS   Display the HrdbForms Page. */
        const PAGE_HRDBFORMS = "P94";


    /** const PAGE_EDITFORMFIELDS   Display the EditFormFields Page. */
        const PAGE_EDITFORMFIELDS = "P95";
        
    /** const PAGE_EDITFORMFIELDVALUES   Display the EditFormFieldValues Page. */
        const PAGE_EDITFORMFIELDVALUES = "P96";

    /** const PAGE_EDITSTAFFACTIVITY   Display the EditStaffActivity Page. */
        const PAGE_EDITSTAFFACTIVITY = "P97";
        
     /** const PAGE_EDITSTAFFSCHEDULEFORM   Display the EditStaffActivityForm Page. */
        const PAGE_EDITSTAFFSCHEDULE = "P98";       

    /** const PAGE_APPROVESTAFFSCHEDULE   Display the ApproveStaffSchedule Page. */
        const PAGE_APPROVESTAFFSCHEDULE = "P99";

    /** const PAGE_FORMAPPROVALLISTING   Display the FormApprovalListing Page. */
        const PAGE_FORMAPPROVALLISTING = "P100";

    /** const PAGE_EDITSTAFFFORMCONTEXT   Display the EditStaffFormContext Page. */
        const PAGE_EDITSTAFFFORMCONTEXT = "P101";

    /** const PAGE_EDITSTAFFFORMINSTRUCTIONS   Display the EditStaffFormInstructions Page. */
        const PAGE_EDITSTAFFFORMINSTRUCTIONS = "P102";

    /** const PAGE_EDITHRDBFORM   Display the EditHrdbForm Page. (combo page of form instructions and form fields)*/
        const PAGE_EDITHRDBFORM = "P103";        

    /** const PAGE_EDITHRDBFORM   Display the ViewScheduleCalendar Page. (page showing one month of activities)*/
        const PAGE_VIEWSCHEDULECALENDAR = "P104";                
        

    /** const PAGE_VIEWSTAFFACTIVITIES   Display the ViewStaffActivities Page. */
        const PAGE_VIEWSTAFFACTIVITIES = "P105";

    /** const PAGE_HRDBACTIVITIES   Display the HrdbActivities Page. */
        const PAGE_HRDBACTIVITIES = "P106";


    /** const PAGE_VIEWACTIVITIESBYDATE   Display the ViewActivitiesByDate Page. */
        const PAGE_VIEWACTIVITIESBYDATE = "P107";      
        
    /** const PAGE_FORMSUBMITTEDLISTING   Display the FormSubmittedListing Page. */
        const PAGE_FORMSUBMITTEDLISTING = "P109";              
         
        
    /** const PAGE_EDITACTIVITYTYPES   Display the EditActivityTypes Page. */
        const PAGE_EDITACTIVITYTYPES = "P113";

    /** const PAGE_EDITCUSTOMREPORTS   Display the EditCustomReports Page. */
        const PAGE_EDITCUSTOMREPORTS = "P115";
        
    /** const PAGE_VIEWCUSTOMREPORT   Display the ViewCustomReport Page. */
        const PAGE_VIEWCUSTOMREPORT = "P116";

    /** const PAGE_CUSTOMREPORTSLISTING   Display the CustomReportsListing Page. */
        const PAGE_CUSTOMREPORTSLISTING = "P117";

    /** const PAGE_EDITSTAFF   Display the EditStaff Page. */
        const PAGE_EDITSTAFF = "P121";

    /** const PAGE_EDITCUSTOMREPORTMETADATA   Display the EditCustomReportMetaData Page. */
        const PAGE_EDITCUSTOMREPORTMETADATA = "P122";

/*[RAD_PAGE_CONST]*/

    /** const SORTBY    The QueryString SortBy parameter. */
        const SORTBY = "modSort";


    /*! const PERSON_ID   The QueryString PERSON_ID parameter. */
        const PERSON_ID = "SV1";

    /*! const PROVINCE_ID   The QueryString PROVINCE_ID parameter. */
        const PROVINCE_ID = "SV2";

    /*! const GENDER_ID   The QueryString GENDER_ID parameter. */
        const GENDER_ID = "SV3";

    /*! const STAFF_ID   The QueryString STAFF_ID parameter. */
        const STAFF_ID = "SV4";

    /*! const CAMPUS_ID   The QueryString CAMPUS_ID parameter. */
        const CAMPUS_ID = "SV7";

    /*! const ADMIN_ID   The QueryString ADMIN_ID parameter. */
        const ADMIN_ID = "SV8";

    /*! const PRIV_ID   The QueryString PRIV_ID parameter. */
        const PRIV_ID = "SV9";

    /*! const CAMPUSADMIN_ID   The QueryString CAMPUSADMIN_ID parameter. */
        const CAMPUSADMIN_ID = "SV10";

    /*! const USER_ID   The QueryString USER_ID parameter. */
        const USER_ID = "SV11";

    /*! const ASSIGNMENT_ID   The QueryString ASSIGNMENT_ID parameter. */
        const ASSIGNMENT_ID = "SV12";

    /*! const REGION_ID   The QueryString REGION_ID parameter. */
        const REGION_ID = "SV19";

    /*! const EMERG_ID   The QueryString EMERG_ID parameter. */
        const EMERG_ID = "SV20";

    /*! const ASSIGNSTATUS_ID   The QueryString ASSIGNSTATUS_ID parameter. */
        const ASSIGNSTATUS_ID = "SV42";

    /*! const VIEWER_ID   The QueryString VIEWER_ID parameter. */
        const VIEWER_ID = "SV47";

    /*! const ACCESS_ID   The QueryString ACCESS_ID parameter. */
        const ACCESS_ID = "SV48";
        
    /*! const REG_ID   The QueryString REG_ID parameter. */
        const REG_ID = "SV36";        

    /*! const YEAR_ID   The QueryString YEAR_ID parameter. */
        const YEAR_ID = "SV66";

    /*! const PERSON_YEAR_ID   The QueryString PERSON_YEAR_ID parameter. */
        const PERSON_YEAR_ID = "SV67";
        
     /*! const COUNTRY_ID   The QueryString COUNTRY_ID parameter. */
        const COUNTRY_ID = "SV68";       

    /*! const STAFFSCHEDULE_ID   The QueryString STAFFSCHEDULE_ID parameter. */
        const STAFFSCHEDULE_ID = "SV77";

    /*! const STAFFACTIVITY_ID   The QueryString STAFFACTIVITY_ID parameter. */
        const STAFFACTIVITY_ID = "SV69";

    /*! const ACTIVITYTYPE_ID   The QueryString ACTIVITYTYPE_ID parameter. */
        const ACTIVITYTYPE_ID = "SV70";

    /*! const STAFFSCHEDULETYPE_ID   The QueryString STAFFSCHEDULETYPE_ID parameter. */
        const STAFFSCHEDULETYPE_ID = "SV71";

    /*! const ACTIVITYSCHEDULE_ID   The QueryString ACTIVITYSCHEDULE_ID parameter. */
        const ACTIVITYSCHEDULE_ID = "SV72";

    /*! const FIELD_ID   The QueryString FIELD_ID parameter. */
        const FIELD_ID = "SV73";

    /*! const FIELDVALUE_ID   The QueryString FIELDVALUE_ID parameter. */
        const FIELDVALUE_ID = "SV74";

    /*! const FIELDTYPE_ID   The QueryString FIELDTYPE_ID parameter. */
        const FIELDTYPE_ID = "SV75";

    /*! const DATATYPE_ID   The QueryString DATATYPE_ID parameter. */
        const DATATYPE_ID = "SV76";

    /*! const FIELDGROUP_ID   The QueryString FIELDGROUP_ID parameter. */
        const FIELDGROUP_ID = "SV78";

    /*! const FIELDGROUP_MATCHES_ID   The QueryString FIELDGROUP_MATCHES_ID parameter. */
        const FIELDGROUP_MATCHES_ID = "SV79";

    /*! const STAFFDIRECTOR_ID   The QueryString STAFFDIRECTOR_ID parameter. */
        const STAFFDIRECTOR_ID = "SV80";
        
    /*! const MONTH_ID   The QueryString MONTH_ID parameter. */
        const MONTH_ID = "SV81";        

    /*! const REPORT_ID   The QueryString REPORT_ID parameter. */
        const REPORT_ID = "SV94";

    /*! const CUSTOMFIELD_ID   The QueryString CUSTOMFIELD_ID parameter. */
        const CUSTOMFIELD_ID = "SV95";

    /*! const MINISTRY_ID   The QueryString MINISTRY_ID parameter. */
        const MINISTRY_ID = "SV96";

/*[RAD_PAGE_STATEVAR_CONST]*/

    /*! const DOWNLOAD_TYPE   The QueryString DOWNLOAD_TYPE parameter: used to indicate whether to download some report */
        const DOWNLOAD_TYPE = "DT";  
 
    /** const DOWNLOAD_EVENT_DATA The constant indicating seniority list report download*/
        const DOWNLOAD_SENIORITY_LIST = '3';	
        
    /** const DOWNLOAD_ACTIVITIESDATE_LIST The constant indicating activities-by-date report download*/
        const DOWNLOAD_ACTIVITIES_LIST = '4';
        
    /** const DOWNLOAD_CUSTOM_REPORT The constant indicating custom report download*/
        const DOWNLOAD_CUSTOM_REPORT = '5';
        
    /*! const FORMLIST_TYPE   The QueryString FORMLIST_TYPE parameter: used to indicate the purpose of the form list page */
        const FORMLIST_TYPE = "FT";          

    /** const FORMLIST_ACCESS The constant indicating form list provides access links*/
        const FORMLIST_ACCESS = '1';

    /** const FORMLIST_EDIT The constant indicating form list provides edit links*/
        const FORMLIST_EDIT = '2';      

    /** const FORMLIST_APPROVAL The constant indicating form list provides admin approval links*/
        const FORMLIST_APPROVAL = '3'; 
        
    /** const FORMLIST_SUBMITTED The constant indicating form list provides admin submitted-form check links*/
        const FORMLIST_SUBMITTED = '4';         
        
    /*! const SEARCH_STARTDATE   The QueryString SEARCH_STARTDATE parameter: used to temporarily store start date search term */
        const SEARCH_STARTDATE = "SD";          

    /*! const SEARCH_ENDDATE   The QueryString SEARCH_STARTDATE parameter: used to temporarily store end date search term */
        const SEARCH_ENDDATE = "ED";         
                       	
//
//	VARIABLES:

    /** protected $page   [STRING] The current Mode of this Module. */
		protected $page;

    /** protected $sortBy [STRING] Parameter to sort displayed Lists. */
                protected $sortBy;

    /*! protected $PERSON_ID   [INTEGER] id of a person */
		protected $PERSON_ID;

    /*! protected $PROVINCE_ID   [INTEGER] id of a province */
		protected $PROVINCE_ID;

    /*! protected $GENDER_ID   [INTEGER] id of a gender */
		protected $GENDER_ID;

    /*! protected $STAFF_ID   [INTEGER] id of a staff member */
		protected $STAFF_ID;

    /*! protected $CAMPUS_ID   [INTEGER] id of a campus */
		protected $CAMPUS_ID;

    /*! protected $ADMIN_ID   [INTEGER] access id for the admin table. */
		protected $ADMIN_ID;

    /*! protected $PRIV_ID   [INTEGER] id for the previlidge. */
		protected $PRIV_ID;

    /*! protected $CAMPUSADMIN_ID   [INTEGER] id for campus admin asignments. */
		protected $CAMPUSADMIN_ID;

    /*! protected $USER_ID   [INTEGER] The viewer_id, made user id to avoid any conflicts. */
		protected $USER_ID;

    /*! protected $ASSIGNMENT_ID   [INTEGER] This is for the assignments table. */
		protected $ASSIGNMENT_ID;

    /*! protected $REGION_ID   [INTEGER] id of a region */
		protected $REGION_ID;

    /*! protected $EMERG_ID   [INTEGER] id of a emergency info record */
		protected $EMERG_ID;

    /*! protected $ASSIGNSTATUS_ID   [INTEGER] id of a campus assignment status type */
		protected $ASSIGNSTATUS_ID;

    /*! protected $VIEWER_ID   [INTEGER] id of a non-HRDB admin */
		protected $VIEWER_ID;

    /*! protected $ACCESS_ID   [INTEGER] id of a viewer-to-person assignment */
		protected $ACCESS_ID;
		
    /*! protected $REG_ID   [INTEGER] id of a person's registration record */
		protected $REG_ID;

    /*! protected $YEAR_ID   [INTEGER] id of the school year a person is in */
		protected $YEAR_ID;

    /*! protected $PERSON_YEAR_ID   [INTEGER] id of the person-to-schoolyear assignment */
		protected $PERSON_YEAR_ID;
		
    /*! protected $COUNTRY_ID   [INTEGER] id of the country */		
		protected $COUNTRY_ID;

    /*! protected $STAFFSCHEDULE_ID   [INTEGER] id of a particular staff schedule/form */
		protected $STAFFSCHEDULE_ID;

    /*! protected $STAFFACTIVITY_ID   [INTEGER] id of a particular staff activity (associated with some schedule) */
		protected $STAFFACTIVITY_ID;

    /*! protected $ACTIVITYTYPE_ID   [INTEGER] id of an activity type (i.e. "vacation") */
		protected $ACTIVITYTYPE_ID;

    /*! protected $STAFFSCHEDULETYPE_ID   [INTEGER] id of a generic staff schedule/form type */
		protected $STAFFSCHEDULETYPE_ID;

    /*! protected $ACTIVITYSCHEDULE_ID   [INTEGER] id linking each activity to one or more forms/schedules(i.e. vacation may be shared between forms) */
		protected $ACTIVITYSCHEDULE_ID;

    /*! protected $FIELD_ID   [INTEGER] id of an HRDB form field */
		protected $FIELD_ID;

    /*! protected $FIELDVALUE_ID   [INTEGER] id of an HRDB form field value */
		protected $FIELDVALUE_ID;

    /*! protected $FIELDTYPE_ID   [INTEGER] id of field type (i.e. "checkbox")
(table associated with Reg module) */
		protected $FIELDTYPE_ID;

    /*! protected $DATATYPE_ID   [INTEGER] id of the data type (i.e. "Numeric")
(table associated with Reg module)  */
		protected $DATATYPE_ID;

    /*! protected $FIELDGROUP_ID   [INTEGER] id of a group of repeatable form fields */
		protected $FIELDGROUP_ID;

    /*! protected $FIELDGROUP_MATCHES_ID   [INTEGER] id of fieldgroup-field matching */
		protected $FIELDGROUP_MATCHES_ID;

    /*! protected $STAFFDIRECTOR_ID   [INTEGER] id of a staff-to-director association */
		protected $STAFFDIRECTOR_ID;
		
    /*! protected $MONTH_ID   [INTEGER] id of a month */
		protected $MONTH_ID;

    /*! protected $REPORT_ID   [INTEGER] id of a custom-built HRDB report */
		protected $REPORT_ID;

    /*! protected $CUSTOMFIELD_ID   [INTEGER] id of a custom report field */
		protected $CUSTOMFIELD_ID;

    /*! protected $MINISTRY_ID   [INTEGER] id of a ministry using the Intranet */
		protected $MINISTRY_ID;

/*[RAD_PAGE_STATEVAR_VAR]*/

	/*! protected $DOWNLOAD_TYPE   [INTEGER] identifier indicating the type of report to download */
		protected $DOWNLOAD_TYPE;	
		
	/*! protected $FORMLIST_TYPE   [INTEGER] identifier indicating the type of form-list page */
		protected $FORMLIST_TYPE;
		
	/*! protected $SEARCH_STARTDATE   [INTEGER] identifier indicating the start-date search term */
		protected $SEARCH_STARTDATE;		

	/*! protected $SEARCH_ENDDATE   [INTEGER] identifier indicating the end-date search term */
		protected $SEARCH_ENDDATE;		

    /** protected $pageDisplay [OBJECT] The display object for the page. */
        protected $pageDisplay;

    /** protected $pageCommonDisplay [OBJECT] The display object for the common page layout. */
        protected $pageCommonDisplay;

    /*! protected $sideBar [OBJECT] The display object for the sideBar. */
        protected $sideBar;

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
//        $this->appID = $this->getQSValue( modulecim_hrdb::APPID, '' );

        // load the common page layout object
        $this->pageCommonDisplay = new CommonDisplay( $this->moduleRootPath, $this->pathToRoot, $this->viewer);

        // load the module's page (DEFAULT = WELCOME)
        $this->page = $this->getQSValue( modulecim_hrdb::PAGE, modulecim_hrdb::PAGE_HRDBHOME );

        // load the module's sortBy parameter (DEFAULT = '')
        $this->sortBy = $this->getQSValue( modulecim_hrdb::SORTBY, '' );

        // load the module's PERSON_ID variable
        $this->PERSON_ID = $this->getQSValue( modulecim_hrdb::PERSON_ID, "" );

        // load the module's PROVINCE_ID variable
        $this->PROVINCE_ID = $this->getQSValue( modulecim_hrdb::PROVINCE_ID, "" );

        // load the module's GENDER_ID variable
        $this->GENDER_ID = $this->getQSValue( modulecim_hrdb::GENDER_ID, "" );

        // load the module's STAFF_ID variable
        $this->STAFF_ID = $this->getQSValue( modulecim_hrdb::STAFF_ID, "" );

        // load the module's CAMPUS_ID variable
        $this->CAMPUS_ID = $this->getQSValue( modulecim_hrdb::CAMPUS_ID, "" );

        // load the module's ADMIN_ID variable
        $this->ADMIN_ID = $this->getQSValue( modulecim_hrdb::ADMIN_ID, "" );

        // load the module's PRIV_ID variable
        $this->PRIV_ID = $this->getQSValue( modulecim_hrdb::PRIV_ID, "" );

        // load the module's CAMPUSADMIN_ID variable
        $this->CAMPUSADMIN_ID = $this->getQSValue( modulecim_hrdb::CAMPUSADMIN_ID, "" );

        // load the module's USER_ID variable
        $this->USER_ID = $this->getQSValue( modulecim_hrdb::USER_ID, "" );

        // load the module's ASSIGNMENT_ID variable
        $this->ASSIGNMENT_ID = $this->getQSValue( modulecim_hrdb::ASSIGNMENT_ID, "" );
        
        // load the module's REGION_ID variable
        $this->REGION_ID = $this->getQSValue( modulecim_hrdb::REGION_ID, "" );

        // load the module's EMERG_ID variable
        $this->EMERG_ID = $this->getQSValue( modulecim_hrdb::EMERG_ID, "" );

        // load the module's ASSIGNSTATUS_ID variable
        $this->ASSIGNSTATUS_ID = $this->getQSValue( modulecim_hrdb::ASSIGNSTATUS_ID, "" );


        // load the module's VIEWER_ID variable
        $this->VIEWER_ID = $this->getQSValue( modulecim_hrdb::VIEWER_ID, "" );

        // load the module's ACCESS_ID variable
        $this->ACCESS_ID = $this->getQSValue( modulecim_hrdb::ACCESS_ID, "" );
        
        // load the module's REG_ID variable
        $this->REG_ID = $this->getQSValue( modulecim_hrdb::REG_ID, "" );        

        // load the module's YEAR_ID variable
        $this->YEAR_ID = $this->getQSValue( modulecim_hrdb::YEAR_ID, "" );

        // load the module's PERSON_YEAR_ID variable
        $this->PERSON_YEAR_ID = $this->getQSValue( modulecim_hrdb::PERSON_YEAR_ID, "" );
        
         // load the module's COUNTRY_ID variable
        $this->COUNTRY_ID = $this->getQSValue( modulecim_hrdb::COUNTRY_ID, "" );       
        

        // load the module's STAFFSCHEDULE_ID variable
        $this->STAFFSCHEDULE_ID = $this->getQSValue( modulecim_hrdb::STAFFSCHEDULE_ID, "" );

        // load the module's STAFFACTIVITY_ID variable
        $this->STAFFACTIVITY_ID = $this->getQSValue( modulecim_hrdb::STAFFACTIVITY_ID, "" );

        // load the module's ACTIVITYTYPE_ID variable
        $this->ACTIVITYTYPE_ID = $this->getQSValue( modulecim_hrdb::ACTIVITYTYPE_ID, "" );

        // load the module's STAFFSCHEDULETYPE_ID variable
        $this->STAFFSCHEDULETYPE_ID = $this->getQSValue( modulecim_hrdb::STAFFSCHEDULETYPE_ID, "" );

        // load the module's ACTIVITYSCHEDULE_ID variable
        $this->ACTIVITYSCHEDULE_ID = $this->getQSValue( modulecim_hrdb::ACTIVITYSCHEDULE_ID, "" );

        // load the module's FIELD_ID variable
        $this->FIELD_ID = $this->getQSValue( modulecim_hrdb::FIELD_ID, "" );

        // load the module's FIELDVALUE_ID variable
        $this->FIELDVALUE_ID = $this->getQSValue( modulecim_hrdb::FIELDVALUE_ID, "" );

        // load the module's FIELDTYPE_ID variable
        $this->FIELDTYPE_ID = $this->getQSValue( modulecim_hrdb::FIELDTYPE_ID, "" );

        // load the module's DATATYPE_ID variable
        $this->DATATYPE_ID = $this->getQSValue( modulecim_hrdb::DATATYPE_ID, "" );

        // load the module's FIELDGROUP_ID variable
        $this->FIELDGROUP_ID = $this->getQSValue( modulecim_hrdb::FIELDGROUP_ID, "" );

        // load the module's FIELDGROUP_MATCHES_ID variable
        $this->FIELDGROUP_MATCHES_ID = $this->getQSValue( modulecim_hrdb::FIELDGROUP_MATCHES_ID, "" );

        // load the module's STAFFDIRECTOR_ID variable
        $this->STAFFDIRECTOR_ID = $this->getQSValue( modulecim_hrdb::STAFFDIRECTOR_ID, "" );

        // load the module's MONTH_ID variable
        $this->MONTH_ID = $this->getQSValue( modulecim_hrdb::MONTH_ID, "" );

        // load the module's REPORT_ID variable
        $this->REPORT_ID = $this->getQSValue( modulecim_hrdb::REPORT_ID, "" );

        // load the module's CUSTOMFIELD_ID variable
        $this->CUSTOMFIELD_ID = $this->getQSValue( modulecim_hrdb::CUSTOMFIELD_ID, "" );

        // load the module's MINISTRY_ID variable
        $this->MINISTRY_ID = $this->getQSValue( modulecim_hrdb::MINISTRY_ID, "" );

/*[RAD_PAGE_LOAD_STATEVAR]*/

                // load the module's DOWNLOAD_TYPE variable
        $this->DOWNLOAD_TYPE = $this->getQSValue( modulecim_hrdb::DOWNLOAD_TYPE, "" ); 
        
        // load the module's FORMLIST_TYPE variable
        $this->FORMLIST_TYPE = $this->getQSValue( modulecim_hrdb::FORMLIST_TYPE, "" );   
        
         // load the module's SEARCH_STARTDATE variable
        $this->SEARCH_STARTDATE = $this->getQSValue( modulecim_hrdb::SEARCH_STARTDATE, "" );
        
         // load the module's SEARCH_ENDDATE variable
        $this->SEARCH_ENDDATE = $this->getQSValue( modulecim_hrdb::SEARCH_ENDDATE, "" );
        
                     

//Get person's permissions

        // Get the person ID
        $accessManager = new RowManager_AccessManager( );
        $accessManager->loadByViewerID( $this->viewer->getViewerID( ) );
        $personID = $accessManager->getPersonID();

        // Now load the access Priviledge manager of this viewer
        $this->accessPrivManager = new RowManager_AdminManager( );
        // Get the permissions the person has.
        $this->accessPrivManager->loadByPersonID( $personID );

//Now do overall stuff based on permissions
//NOTE: Put the below 3 lines in the case statement for the page you want to block off from regular users.
//                if ( !$this->accessPrivManager->isLoaded() ) {
//                      //PAGE_HRDBHOME can be replaced by the page you want to redirect the person to.
//                    $this->page = modulecim_hrdb::PAGE_HRDBHOME;//PAGE_NOTALLOWED;
//                }

//End of general permission checking.

        switch( $this->page ) {
	        
	         /*
             *  Not Authorized page
             */
            case modulecim_reg::PAGE_NOTAUTHORIZED:
                $this->loadNotAuthorized();
                break;	 

            /*
             *  EditMyInfo
             */
            case modulecim_hrdb::PAGE_EDITMYINFO:
                $this->loadEditMyInfo();
                break;

            /*
             *  HrdbHome
             */
            case modulecim_hrdb::PAGE_HRDBHOME:
                $this->loadHrdbHome();
                break;

            /*
             *  Provinces
             */
            case modulecim_hrdb::PAGE_PROVINCES:
                if ( !$this->accessPrivManager->isLoaded() ) {
                    $this->page = modulecim_hrdb::PAGE_HRDBHOME;//PAGE_NOTALLOWED;
                }
                $this->loadProvinces();
                break;

            /*
             *  ImportData
             */
            case modulecim_hrdb::PAGE_IMPORTDATA:
                if ( !$this->accessPrivManager->isLoaded() ) {
                    $this->page = modulecim_hrdb::PAGE_HRDBHOME;//PAGE_NOTALLOWED;
                }
                $this->loadImportData();
                break;

            /*
             *  Campuses
             */
            case modulecim_hrdb::PAGE_CAMPUSES:
                if ( !$this->accessPrivManager->isLoaded() ) {
                    $this->page = modulecim_hrdb::PAGE_HRDBHOME;//PAGE_NOTALLOWED;
                }
                $this->loadCampuses();
                break;


            /*
             *  NewPerson
             */
            case modulecim_hrdb::PAGE_NEWPERSON:
                if ( !$this->accessPrivManager->isLoaded() ) {
                    $this->page = modulecim_hrdb::PAGE_HRDBHOME;//PAGE_NOTALLOWED;
                }
                $this->loadNewPerson();
                break;

            /*
             *  Privileges
             */
            case modulecim_hrdb::PAGE_PRIVILEGES:
                if ( !$this->accessPrivManager->isLoaded() ) {
                    $this->page = modulecim_hrdb::PAGE_HRDBHOME;//PAGE_NOTALLOWED;
                }
                $this->loadPrivileges();
                break;

            /*
             *  People
             */
            case modulecim_hrdb::PAGE_PEOPLE:
                if ( !$this->accessPrivManager->isLoaded() ) {
                    $this->page = modulecim_hrdb::PAGE_HRDBHOME;//PAGE_NOTALLOWED;
                }
                $this->loadPeople();
                break;

            /*
             *  PeopleList
             */
            case modulecim_hrdb::PAGE_PEOPLELIST:
                if ( !$this->accessPrivManager->isLoaded() ) {
                    $this->page = modulecim_hrdb::PAGE_HRDBHOME;//PAGE_NOTALLOWED;
                }
                $this->loadPeopleList();
                break;

            /*
             *  DeletePerson
             */
            case modulecim_hrdb::PAGE_DELETEPERSON:
                if ( !$this->accessPrivManager->isLoaded() ) {
                    $this->page = modulecim_hrdb::PAGE_HRDBHOME;//PAGE_NOTALLOWED;
                }
                $this->loadDeletePerson();
                break;

            /*
             *  ViewStaff
             */
            case modulecim_hrdb::PAGE_VIEWSTAFF:
                if ( !$this->accessPrivManager->isLoaded() ) {
                    $this->page = modulecim_hrdb::PAGE_HRDBHOME;//PAGE_NOTALLOWED;
                }
                $this->loadViewStaff();
                break;

            /*
             *  AddAdmin
             */
            case modulecim_hrdb::PAGE_ADDADMIN:
                if ( !$this->accessPrivManager->isLoaded() ) {
                    $this->page = modulecim_hrdb::PAGE_HRDBHOME;//PAGE_NOTALLOWED;
                }
                $this->loadAddAdmin();
                break;


            /*
             *  EditPerson
             */
            case modulecim_hrdb::PAGE_EDITPERSON:
                if ( !$this->accessPrivManager->isLoaded() ) {
                    $this->page = modulecim_hrdb::PAGE_HRDBHOME;//PAGE_NOTALLOWED;
                }
                $this->loadEditPerson();
                break;

            /*
             *  AddStaff
             */
            case modulecim_hrdb::PAGE_ADDSTAFF:
                if ( !$this->accessPrivManager->isLoaded() ) {
                    $this->page = modulecim_hrdb::PAGE_HRDBHOME;//PAGE_NOTALLOWED;
                }
                $this->loadAddStaff();
                break;

            /*
             *  Staff
             */
            case modulecim_hrdb::PAGE_STAFF:
                if ( !$this->accessPrivManager->isLoaded() ) {
                    $this->page = modulecim_hrdb::PAGE_HRDBHOME;//PAGE_NOTALLOWED;
                }
                $this->loadStaff();
                break;

            /*
             *  DeleteStaff
             */
            case modulecim_hrdb::PAGE_DELETESTAFF:
                if ( !$this->accessPrivManager->isLoaded() ) {
                    $this->page = modulecim_hrdb::PAGE_HRDBHOME;//PAGE_NOTALLOWED;
                }
                $this->loadDeleteStaff();
                break;

            /*
             *  Admins
             */
            case modulecim_hrdb::PAGE_ADMINS:
                if ( !$this->accessPrivManager->isLoaded() ) {
                    $this->page = modulecim_hrdb::PAGE_HRDBHOME;//PAGE_NOTALLOWED;
                }
                $this->loadAdmins();
                break;

            /*
             *  DeleteAdmin
             */
            case modulecim_hrdb::PAGE_DELETEADMIN:
                if ( !$this->accessPrivManager->isLoaded() ) {
                    $this->page = modulecim_hrdb::PAGE_HRDBHOME;//PAGE_NOTALLOWED;
                }
                $this->loadDeleteAdmin();
                break;

            /*
             *  ViewCampuses
             */
            case modulecim_hrdb::PAGE_VIEWCAMPUSES:
                if ( !$this->accessPrivManager->isLoaded() ) {
                    $this->page = modulecim_hrdb::PAGE_HRDBHOME;//PAGE_NOTALLOWED;
                }
                $this->loadViewCampuses();
                break;

            /*
             *  CampusAssignments
             */
            case modulecim_hrdb::PAGE_CAMPUSASSIGNMENTS:
                if ( !$this->accessPrivManager->isLoaded() ) {
                    $this->page = modulecim_hrdb::PAGE_HRDBHOME;//PAGE_NOTALLOWED;
                }
                $this->loadCampusAssignments();
                break;

            /*
             *  PersonInfo
             */
            case modulecim_hrdb::PAGE_PERSONINFO:
                if ( !$this->accessPrivManager->isLoaded() ) {
                    $this->page = modulecim_hrdb::PAGE_HRDBHOME;//PAGE_NOTALLOWED;
                }
                $this->loadPersonInfo();
                break;

            /*
             *  PeopleCampus
             */
            case modulecim_hrdb::PAGE_PEOPLECAMPUS:
                if ( !$this->accessPrivManager->isLoaded() ) {
                    $this->page = modulecim_hrdb::PAGE_HRDBHOME;//PAGE_NOTALLOWED;
                }
                $this->loadPeopleCampus();
                break;

            /*
             *  PeoplebyCampuses
             */
            case modulecim_hrdb::PAGE_PEOPLEBYCAMPUSES:
                if ( !$this->accessPrivManager->isLoaded() ) {
                    $this->page = modulecim_hrdb::PAGE_HRDBHOME;//PAGE_NOTALLOWED;
                }
                $this->loadPeoplebyCampuses();
                break;

            /*
             *  AdminPrivs
             */
            case modulecim_hrdb::PAGE_ADMINPRIVS:
                if ( !$this->accessPrivManager->isLoaded() ) {
                    $this->page = modulecim_hrdb::PAGE_HRDBHOME;//PAGE_NOTALLOWED;
                }
                $this->loadAdminPrivs();
                break;

            /*
             *  NewAccount
             */
            case modulecim_hrdb::PAGE_NEWACCOUNT:
                $this->loadNewAccount();
                break;

            /*
             *  EditMyEmergInfo
             */
            case modulecim_hrdb::PAGE_EDITMYEMERGINFO:
                $this->loadEditMyEmergInfo();
                break;

            /*
             *  EditCampusAssignmentStatusTypes
             */
            case modulecim_hrdb::PAGE_EDITCAMPUSASSIGNMENTSTATUSTYPES:
                $this->loadEditCampusAssignmentStatusTypes();
                break;

            /*
             *  EditCampusAssignment
             */
            case modulecim_hrdb::PAGE_EDITCAMPUSASSIGNMENT:
                $this->loadEditCampusAssignment();
                break;

            /*
             *  EditRegion
             */
            case modulecim_hrdb::PAGE_EDITREGION:
                $this->loadEditRegion();
                break;

            /*
             *  EditPeople
             */
            case modulecim_hrdb::PAGE_EDITPEOPLE:
                $this->loadEditPeople();
                break;

            /*
             *  EditAccessAssignment
             */
            case modulecim_hrdb::PAGE_EDITACCESSASSIGNMENT:
                $this->loadEditAccessAssignment();
                break;

            /*
             *  EditMyCampusAssignment
             */
            case modulecim_hrdb::PAGE_EDITMYCAMPUSASSIGNMENT:
                $this->loadEditMyCampusAssignment();
                break;

            /*
             *  EditMyYearInSchool
             */
            case modulecim_hrdb::PAGE_EDITMYYEARINSCHOOL:
                $this->loadEditMyYearInSchool();
                break;

            /*
             *  EditStudentYearInSchool
             */
            case modulecim_hrdb::PAGE_EDITSTUDENTYEARINSCHOOL:                
                $this->loadEditStudentYearInSchool();
                break;
                
             /*
             *  ViewStudentYearInSchool
             */
            case modulecim_hrdb::PAGE_VIEWSTUDENTYEARINSCHOOL:
                $this->loadViewStudentYearInSchool();
                break;
                
                
             /*
             *  ViewStudentYearInSchool
             */
            case modulecim_hrdb::PAGE_COUNTRIES:
                $this->loadCountries();
                break;  
                
                
            /*
             *  DownloadCSV
             */
            case modulecim_hrdb::PAGE_DOWNLOADCSV:
                $this->loadDownloadCSV();
                break;             
                
                              
            /*
             *  HrdbForms
             */
            case modulecim_hrdb::PAGE_HRDBFORMS:
                $this->loadHrdbForms();
                break;

            /*
             *  EditFormFields
             */
            case modulecim_hrdb::PAGE_EDITFORMFIELDS:
                $this->loadEditFormFields();
                break;
                
              
            /*
             *  EditFormFields
             */
            case modulecim_hrdb::PAGE_EDITFORMFIELDVALUES:
                $this->loadEditFormFieldValues();
                break;
            

            /*
             *  EditStaffActivity
             */
            case modulecim_hrdb::PAGE_EDITSTAFFACTIVITY:
                $this->loadEditStaffActivity();
                break;
                
                
            /*
             *  EditStaffSchedule
             */
            case modulecim_hrdb::PAGE_EDITSTAFFSCHEDULE:
                $this->loadEditStaffSchedule();
                break;
                
            /*
             *  ApproveStaffSchedule
             */
            case modulecim_hrdb::PAGE_APPROVESTAFFSCHEDULE:
                $this->loadApproveStaffSchedule();
                break;

            /*
             *  FormApprovalListing
             */
            case modulecim_hrdb::PAGE_FORMAPPROVALLISTING:
                $this->loadFormApprovalListing();
                break;

            /*
             *  EditStaffFormContext
             */
            case modulecim_hrdb::PAGE_EDITSTAFFFORMCONTEXT:
                $this->loadEditStaffFormContext();
                break;

            /*
             *  EditStaffFormInstructions
             */
            case modulecim_hrdb::PAGE_EDITSTAFFFORMINSTRUCTIONS:
                $this->loadEditStaffFormInstructions();
                break;
                
                
            /*
             *  EditHrdbForm
             */
            case modulecim_hrdb::PAGE_EDITHRDBFORM:
                $this->loadEditHrdbForm();
                break;
                
            /*
             *  ViewScheduleCalendar
             */
            case modulecim_hrdb::PAGE_VIEWSCHEDULECALENDAR:
                $this->loadViewScheduleCalendar();
                break;                
                
            /*
             *  ViewStaffActivities
             */
            case modulecim_hrdb::PAGE_VIEWSTAFFACTIVITIES:
                $this->loadViewStaffActivities();
                break;

            /*
             *  HrdbActivities
             */
            case modulecim_hrdb::PAGE_HRDBACTIVITIES:
                $this->loadHrdbActivities();
                break;
                
            /*
             *  ViewActivitiesByDate
             */
            case modulecim_hrdb::PAGE_VIEWACTIVITIESBYDATE:
                $this->loadViewActivitiesByDate();
                break;
                
                
            /*
             *  FormSubmittedListing
             */
            case modulecim_hrdb::PAGE_FORMSUBMITTEDLISTING:
                $this->loadFormSubmittedListing();
                break;            

            /*
             *  EditActivityTypes
             */
            case modulecim_hrdb::PAGE_EDITACTIVITYTYPES:
                $this->loadEditActivityTypes();
                break;

            /*
             *  EditCustomReports
             */
            case modulecim_hrdb::PAGE_EDITCUSTOMREPORTS:
                $this->loadEditCustomReports();
                break;
                
            /*
             *  ViewCustomReport
             */
            case modulecim_hrdb::PAGE_VIEWCUSTOMREPORT:
                $this->loadViewCustomReport();
                break;
                
                
            /*
             *  CustomReportsListing
             */
            case modulecim_hrdb::PAGE_CUSTOMREPORTSLISTING:
                $this->loadCustomReportsListing();
                break;

            /*
             *  EditStaff
             */
            case modulecim_hrdb::PAGE_EDITSTAFF:
                $this->loadEditStaff();
                break;

            /*
             *  EditCustomReportMetaData
             */
            case modulecim_hrdb::PAGE_EDITCUSTOMREPORTMETADATA:
                $this->loadEditCustomReportMetaData();
                break;

/*[RAD_PAGE_LOAD_CALL]*/


            /*
             *  Just to make sure, default the pageDisplay to
             *  the HrdbHome page.
             */
            default:
                $this->page = modulecim_hrdb::PAGE_HRDBHOME;
                $this->loadHrdbHome();
                break;

        }

        /*
         * Load SideBar Information
         */
        $this->loadSideBar();


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
	                
	                 case modulecim_hrdb::PAGE_HRDBHOME:
//                         $this->PERSON_ID = '';
// 								echo "POST = ".$_POST['person_id'];
								$this->PERSON_ID = $_POST['person_id'];
                        $this->page = modulecim_hrdb::PAGE_HRDBHOME;
                        $this->loadHrdbHome();

	
                        break;

                    case modulecim_hrdb::PAGE_EDITMYINFO:
                        $this->PERSON_ID = '';
                        $this->page = modulecim_hrdb::PAGE_HRDBHOME;
                        $this->loadHrdbHome();
                        break;

                    case modulecim_hrdb::PAGE_PROVINCES:
                        // NOTE: after a successful submit on an AdminBox style
                        // form, set the managerInit variable back to ''
                        // echo 'controller processData PAGE_PROVINCES<br/>';
                        $this->PROVINCE_ID = '';
                        $this->loadProvinces( true );
                        break;

                    case modulecim_hrdb::PAGE_COUNTRIES:
                        // NOTE: after a successful submit on an AdminBox style
                        // form, set the managerInit variable back to ''
                        // echo 'controller processData PAGE_COUNTRIES<br/>';
                        $this->COUNTRY_ID = '';
                        $this->loadCountries( true );
                        break;                        
                        

                    case modulecim_hrdb::PAGE_CAMPUSES:
                        // NOTE: after a successful submit on an AdminBox style
                        // form, set the managerInit variable back to ''
                        // echo 'controller processData PAGE_CAMPUSES<br/>';
                        $this->CAMPUS_ID = '';
                        $this->loadCampuses( true );
                        break;

                    case modulecim_hrdb::PAGE_PRIVILEGES:
                        // NOTE: after a successful submit on an AdminBox style
                        // form, set the managerInit variable back to ''
                        $this->PRIV_ID = '';
                        $this->loadPrivileges( true );
                        break;

                    case modulecim_hrdb::PAGE_PEOPLELIST:
                        // NOTE: after a successful submit on an AdminBox style
                        // form, set the managerInit variable back to ''
                        $this->PERSON_ID = '';
                        $this->loadPeopleList( true );
                        break;

                    case modulecim_hrdb::PAGE_PEOPLE:
                        /* No StateVar given for FormInit. */
                        $this->page = modulecim_hrdb::PAGE_DELETEPERSON;
                        $this->loadDeletePerson();
                        break;

                    case modulecim_hrdb::PAGE_DELETEPERSON:
                        /* No StateVar given for FormInit. */
                        $this->page = modulecim_hrdb::PAGE_PEOPLEBYCAMPUSES;
                        $this->loadPeopleByCampuses();
                        break;

                    case modulecim_hrdb::PAGE_STAFF:
                        // NOTE: after a successful submit on an AdminBox style
                        // form, set the managerInit variable back to ''
                        $this->PERSON_ID = '';
                        $this->loadStaff( true );
                        break;

                    case modulecim_hrdb::PAGE_VIEWSTAFF:
                        // NOTE: after a successful submit on an AdminBox style
                        // form, set the managerInit variable back to ''
                        $this->STAFF_ID = '';
                        $this->loadViewStaff( true );
                        break;

                    case modulecim_hrdb::PAGE_EDITPERSON:
                        $this->PERSON_ID = '';
                        $this->page = modulecim_hrdb::PAGE_PEOPLEBYCAMPUSES;
                        $this->loadPeopleByCampuses();
                        break;

                    case modulecim_hrdb::PAGE_DELETESTAFF:
                        /* No StateVar given for FormInit. */
                        $this->page = modulecim_hrdb::PAGE_STAFF;
                        $this->loadStaff();
                        break;

                    case modulecim_hrdb::PAGE_ADDSTAFF:
                        /* No StateVar given for FormInit. */
                        $this->page = modulecim_hrdb::PAGE_STAFF;
                        $this->loadStaff();
                        break;

                    case modulecim_hrdb::PAGE_DELETEADMIN:
                        /* No StateVar given for FormInit. */
                        $this->page = modulecim_hrdb::PAGE_ADMINS;
                        $this->loadAdmins();
                        break;

                    case modulecim_hrdb::PAGE_ADDADMIN:
                        /* No StateVar given for FormInit. */
                        $this->page = modulecim_hrdb::PAGE_ADMINS;
                        $this->loadAdmins();
                        break;

                    case modulecim_hrdb::PAGE_VIEWCAMPUSES:
                        // NOTE: after a successful submit on an AdminBox style
                        // form, set the managerInit variable back to ''
                        $this->CAMPUSADMIN_ID = '';
                        $this->loadViewCampuses( true );
                        break;

                    case modulecim_hrdb::PAGE_CAMPUSASSIGNMENTS:
                        // NOTE: after a successful submit on an AdminBox style
                        // form, set the managerInit variable back to ''
                        $this->ASSIGNMENT_ID = '';
                        $this->loadCampusAssignments( true );
                        break;

                    case modulecim_hrdb::PAGE_NEWPERSON:
                        /* No StateVar given for FormInit. */
                        $this->page = modulecim_hrdb::PAGE_PEOPLEBYCAMPUSES;
                        $this->loadPeopleByCampuses();
                        break;


                    case modulecim_hrdb::PAGE_PEOPLECAMPUS:
                        // NOTE: after a successful submit on an AdminBox style
                        // form, set the managerInit variable back to ''
                        $this->PROVINCE_ID = '';
                        $this->loadPeopleCampus( true );                     
                        break;

                    case modulecim_hrdb::PAGE_ADMINPRIVS:
                        // NOTE: after a successful submit on an AdminBox style
                        // form, set the managerInit variable back to ''
                        $this->ADMIN_ID = '';
                        $this->loadAdminPrivs( true );                     
                        break;

                    case modulecim_hrdb::PAGE_EDITMYEMERGINFO:
                        $this->EMERG_ID = '';
                        $this->page = modulecim_hrdb::PAGE_HRDBHOME;
                        $this->loadHrdbHome();                       
                        break;

                    case modulecim_hrdb::PAGE_EDITCAMPUSASSIGNMENTSTATUSTYPES:
                        // NOTE: after a successful submit on an AdminBox style
                        // form, set the managerInit variable back to ''
                        $this->ASSIGNSTATUS_ID = '';
                        $this->loadEditCampusAssignmentStatusTypes( true );                     
                        break;

                    case modulecim_hrdb::PAGE_EDITCAMPUSASSIGNMENT:
                        // NOTE: after a successful submit on an AdminBox style
                        // form, set the managerInit variable back to ''
                        $this->ASSIGNMENT_ID = '';
                        $this->loadEditCampusAssignment( true );                     
                        break;

                    case modulecim_hrdb::PAGE_EDITREGION:
                        // NOTE: after a successful submit on an AdminBox style
                        // form, set the managerInit variable back to ''
                        $this->REGION_ID = '';
                        $this->loadEditRegion( true );                     
                        break;

                    case modulecim_hrdb::PAGE_EDITPEOPLE:
                        // NOTE: after a successful submit on an AdminBox style
                        // form, set the managerInit variable back to ''
                        $this->PERSON_ID = '';
                        $this->loadEditPeople( true );                     
                        break;

                    case modulecim_hrdb::PAGE_EDITACCESSASSIGNMENT:
                        // NOTE: after a successful submit on an AdminBox style
                        // form, set the managerInit variable back to ''
                        $this->ACCESS_ID = '';
                        $this->loadEditAccessAssignment( true );                     
                        break;

                    case modulecim_hrdb::PAGE_EDITMYCAMPUSASSIGNMENT:
                        // NOTE: after a successful submit on an AdminBox style
                        // form, set the managerInit variable back to ''
                        $this->ASSIGNMENT_ID = '';
                        $this->loadEditMyCampusAssignment( true );                     
                        break;

                    case modulecim_hrdb::PAGE_EDITMYCAMPUSASSIGNMENT:
                        $this->ASSIGNMENT_ID = '';
                        $this->page = modulecim_hrdb::PAGE_HRDBHOME;
                        $this->loadHrdbHome();                       
                        break;

                    case modulecim_hrdb::PAGE_EDITMYYEARINSCHOOL:
                        $this->PERSON_YEAR_ID = '';
                        $this->page = modulecim_hrdb::PAGE_HRDBHOME;
                        $this->loadHrdbHome();                       
                        break;
                        
                        
                    case modulecim_hrdb::PAGE_EDITFORMFIELDS:
                        // NOTE: after a successful submit on an AdminBox style
                        // form, set the managerInit variable back to ''
                        $this->FIELD_ID = '';
                        $this->loadEditFormFields( true );                     
                        break;
                        
                        
                    case modulecim_hrdb::PAGE_EDITFORMFIELDVALUES:
                        // NOTE: after a successful submit on an AdminBox style
                        // form, set the managerInit variable back to ''
                        $this->FIELDVALUE_ID = '';
                        $this->loadHrdbHome();	//loadEditFormFieldValues( true );                     
                        break;
                        
                        
                    case modulecim_hrdb::PAGE_EDITSTAFFACTIVITY:
                        // NOTE: after a successful submit on an AdminBox style
                        // form, set the managerInit variable back to ''
                        $this->STAFFACTIVITY_ID = '';
                        $this->loadEditStaffActivity( true );                     
                        break;
                        
                     case modulecim_hrdb::PAGE_EDITSTAFFSCHEDULE:
                        // NOTE: after a successful submit on an AdminBox style
                        // form, set the managerInit variable back to ''
                        $this->STAFFACTIVITY_ID = '';
                        $this->FIELDVALUE_ID = '';
                        $this->loadEditStaffSchedule( true );                     
                        break;
                        
                    case modulecim_hrdb::PAGE_APPROVESTAFFSCHEDULE:
                        // NOTE: after a successful submit on an AdminBox style
                        // form, set the managerInit variable back to ''
                        //$this->STAFFSCHEDULE_ID = '';
                        $this->loadApproveStaffSchedule( true );                     
                        break;
                        
                    // Setup form context and then go to another page for editing specific fields
                    case modulecim_hrdb::PAGE_EDITSTAFFFORMCONTEXT:  
                    		$this->FIELDVALUE_ID = '';
                    		//$this->loadEditFormFields( );  
                    		$this->loadEditHrdbForm();
                    		break;  
                    		
                  		
                    // Setup form fields and form instructions
                    case modulecim_hrdb::PAGE_EDITHRDBFORM:
                     	$this->FIELD_ID = '';
                			$this->loadEditHrdbForm( true );
                			break;
                			
			           //case modulecim_hrdb::PAGE_VIEWSCHEDULECALENDAR:
			           
							// Setup form fields and form instructions
			            case modulecim_hrdb::PAGE_VIEWACTIVITIESBYDATE:
// 			            		echo 'REQUEST =<pre>'.print_r($_REQUEST,true).'</pre>';

// 			            	$this->STAFFACTIVITY_ID = '';
								 $this->SEARCH_STARTDATE = $_REQUEST['start_date'];
								 $this->SEARCH_ENDDATE = $_REQUEST['end_date'];
								 
			                $this->loadViewActivitiesByDate( true );
			                break;			           
             			

                    case modulecim_hrdb::PAGE_EDITACTIVITYTYPES:
                        // NOTE: after a successful submit on an AdminBox style
                        // form, set the managerInit variable back to ''
                        $this->ACTIVITYTYPE_ID = '';
                        $this->loadEditActivityTypes( true );                     
                        break;

                    case modulecim_hrdb::PAGE_EDITCUSTOMREPORTS:
                        // NOTE: after a successful submit on an AdminBox style
                        // form, set the managerInit variable back to ''
                        $this->CUSTOMFIELD_ID = '';
                        $this->loadEditCustomReports( true );                     
                        break;

                    case modulecim_hrdb::PAGE_EDITSTAFF:
                        // NOTE: after a successful submit on an AdminBox style
                        // form, set the managerInit variable back to ''
                        $this->STAFF_ID = '';
                        $this->loadEditStaff( true );                    
                        break;
                        
			            case modulecim_hrdb::PAGE_HRDBFORMS:
			            	 $this->STAFFSCHEDULETYPE_ID = '';
			                $this->loadHrdbForms( true ); 
			                break;           
			                
			            case modulecim_hrdb::PAGE_CUSTOMREPORTSLISTING:
			                $this->REPORT_ID = '';
			                $this->loadCustomReportsListing( true );
			                break;
			                
                    case modulecim_hrdb::PAGE_EDITCUSTOMREPORTMETADATA:
//                         $this->REPORT_ID = '';
                        $this->loadEditCustomReports();                     
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

        // wrap current page's html in the common html of the module
        $content = $this->pageCommonDisplay->getHTML( $content, $error_msg );

        // store HTML content as this page's content Item
        $this->addContent( $content );
        
        // add the sidebar content
        $sideBarContent = $this->sideBar->getHTML();
        $this->addSideBarContent( $sideBarContent );
         
        // Add any necessary javascripts for this page (and reset a parameter):
        switch( $this->page ) {
        
/*[RAD_PAGE_JAVASCRIPTS]*/
             case modulecim_hrdb::PAGE_PEOPLEBYCAMPUSES:
             case modulecim_hrdb::PAGE_EDITSTUDENTYEARINSCHOOL:
             case modulecim_hrdb::PAGE_VIEWSTUDENTYEARINSCHOOL:
             case modulecim_hrdb::PAGE_VIEWSCHEDULECALENDAR:
             	 $this->addScript('MM_jumpMenu.jsp');
             	 break;
             case modulecim_hrdb::PAGE_VIEWACTIVITIESBYDATE:
             case modulecim_hrdb::PAGE_EDITSTAFFSCHEDULE:
             	 $this->addScript('ImprovedCalendarPopup.js');
             	 $this->addScript('overlib_mini.js');
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
	 * 'PERSON_ID' [INTEGER] The Desired PERSON_ID of this Link.
	 * 'PROVINCE_ID' [INTEGER] The Desired PROVINCE_ID of this Link.
	 * 'GENDER_ID' [INTEGER] The Desired GENDER_ID of this Link.
	 * 'STAFF_ID' [INTEGER] The Desired STAFF_ID of this Link.
	 * 'CAMPUS_ID' [INTEGER] The Desired CAMPUS_ID of this Link.
	 * 'ADMIN_ID' [INTEGER] The Desired ADMIN_ID of this Link.
	 * 'PRIV_ID' [INTEGER] The Desired PRIV_ID of this Link.
	 * 'CAMPUSADMIN_ID' [INTEGER] The Desired CAMPUSADMIN_ID of this Link.
	 * 'USER_ID' [INTEGER] The Desired USER_ID of this Link.
	 * 'ASSIGNMENT_ID' [INTEGER] The Desired ASSIGNMENT_ID of this Link.
	 * 'REGION_ID' [INTEGER] The Desired REGION_ID of this Link.
	 * 'EMERG_ID' [INTEGER] The Desired EMERG_ID of this Link.
	 * 'ASSIGNSTATUS_ID' [INTEGER] The Desired ASSIGNSTATUS_ID of this Link.
	 * 'VIEWER_ID' [INTEGER] The Desired VIEWER_ID of this Link.
	 * 'ACCESS_ID' [INTEGER] The Desired ACCESS_ID of this Link.
	 * 'YEAR_ID' [INTEGER] The Desired YEAR_ID of this Link.
	 * 'PERSON_YEAR_ID' [INTEGER] The Desired PERSON_YEAR_ID of this Link.
	 * 'STAFFSCHEDULE_ID' [INTEGER] The Desired STAFFSCHEDULE_ID of this Link.
	 * 'STAFFACTIVITY_ID' [INTEGER] The Desired STAFFACTIVITY_ID of this Link.
	 * 'ACTIVITYTYPE_ID' [INTEGER] The Desired ACTIVITYTYPE_ID of this Link.
	 * 'STAFFSCHEDULETYPE_ID' [INTEGER] The Desired STAFFSCHEDULETYPE_ID of this Link.
	 * 'ACTIVITYSCHEDULE_ID' [INTEGER] The Desired ACTIVITYSCHEDULE_ID of this Link.
	 * 'FIELD_ID' [INTEGER] The Desired FIELD_ID of this Link.
	 * 'FIELDVALUE_ID' [INTEGER] The Desired FIELDVALUE_ID of this Link.
	 * 'FIELDTYPE_ID' [INTEGER] The Desired FIELDTYPE_ID of this Link.
	 * 'DATATYPE_ID' [INTEGER] The Desired DATATYPE_ID of this Link.
	 * 'FIELDGROUP_ID' [INTEGER] The Desired FIELDGROUP_ID of this Link.
	 * 'FIELDGROUP_MATCHES_ID' [INTEGER] The Desired FIELDGROUP_MATCHES_ID of this Link.
	 * 'STAFFDIRECTOR_ID' [INTEGER] The Desired STAFFDIRECTOR_ID of this Link.
	 * 'REPORT_ID' [INTEGER] The Desired REPORT_ID of this Link.
	 * 'CUSTOMFIELD_ID' [INTEGER] The Desired CUSTOMFIELD_ID of this Link.
	 * 'MINISTRY_ID' [INTEGER] The Desired MINISTRY_ID of this Link.
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
            $callBack = modulecim_hrdb::PAGE.'='.$page;
        }
        
        if ($sortBy != '') {
            if ($callBack != '') {
                $callBack .= '&';
            }
            $callBack .= modulecim_hrdb::SORTBY.'='.$sortBy;
        }
        
        
        if ( isset( $parameters['PERSON_ID']) ) {
            if ( $parameters['PERSON_ID'] != '' ) {
                if ($callBack != '') {
                    $callBack .= '&';
                }
                $callBack .= modulecim_hrdb::PERSON_ID.'='.$parameters['PERSON_ID'];
            }
        }

        if ( isset( $parameters['PROVINCE_ID']) ) {
            if ( $parameters['PROVINCE_ID'] != '' ) {
                if ($callBack != '') {
                    $callBack .= '&';
                }
                $callBack .= modulecim_hrdb::PROVINCE_ID.'='.$parameters['PROVINCE_ID'];
            }
        }

        if ( isset( $parameters['GENDER_ID']) ) {
            if ( $parameters['GENDER_ID'] != '' ) {
                if ($callBack != '') {
                    $callBack .= '&';
                }
                $callBack .= modulecim_hrdb::GENDER_ID.'='.$parameters['GENDER_ID'];
            }
        }

        if ( isset( $parameters['STAFF_ID']) ) {
            if ( $parameters['STAFF_ID'] != '' ) {
                if ($callBack != '') {
                    $callBack .= '&';
                }
                $callBack .= modulecim_hrdb::STAFF_ID.'='.$parameters['STAFF_ID'];
            }
        }

        if ( isset( $parameters['CAMPUS_ID']) ) {
            if ( $parameters['CAMPUS_ID'] != '' ) {
                if ($callBack != '') {
                    $callBack .= '&';
                }
                $callBack .= modulecim_hrdb::CAMPUS_ID.'='.$parameters['CAMPUS_ID'];
            }
        }

        if ( isset( $parameters['ADMIN_ID']) ) {
            if ( $parameters['ADMIN_ID'] != '' ) {
                if ($callBack != '') {
                    $callBack .= '&';
                }
                $callBack .= modulecim_hrdb::ADMIN_ID.'='.$parameters['ADMIN_ID'];
            }
        }

        if ( isset( $parameters['PRIV_ID']) ) {
            if ( $parameters['PRIV_ID'] != '' ) {
                if ($callBack != '') {
                    $callBack .= '&';
                }
                $callBack .= modulecim_hrdb::PRIV_ID.'='.$parameters['PRIV_ID'];
            }
        }

        if ( isset( $parameters['CAMPUSADMIN_ID']) ) {
            if ( $parameters['CAMPUSADMIN_ID'] != '' ) {
                if ($callBack != '') {
                    $callBack .= '&';
                }
                $callBack .= modulecim_hrdb::CAMPUSADMIN_ID.'='.$parameters['CAMPUSADMIN_ID'];
            }
        }

        if ( isset( $parameters['USER_ID']) ) {
            if ( $parameters['USER_ID'] != '' ) {
                if ($callBack != '') {
                    $callBack .= '&';
                }
                $callBack .= modulecim_hrdb::USER_ID.'='.$parameters['USER_ID'];
            }
        }

        if ( isset( $parameters['ASSIGNMENT_ID']) ) {
            if ( $parameters['ASSIGNMENT_ID'] != '' ) {
                if ($callBack != '') {
                    $callBack .= '&';
                }
                $callBack .= modulecim_hrdb::ASSIGNMENT_ID.'='.$parameters['ASSIGNMENT_ID'];
            }
        }

        if ( isset( $parameters['REGION_ID']) ) {
            if ( $parameters['REGION_ID'] != '' ) {
                if ($callBack != '') {
                    $callBack .= '&';
                }
                $callBack .= modulecim_hrdb::REGION_ID.'='.$parameters['REGION_ID'];
            }
        }

        if ( isset( $parameters['EMERG_ID']) ) {
            if ( $parameters['EMERG_ID'] != '' ) {
                if ($callBack != '') {
                    $callBack .= '&';
                }
                $callBack .= modulecim_hrdb::EMERG_ID.'='.$parameters['EMERG_ID'];
            }
        }

        if ( isset( $parameters['ASSIGNSTATUS_ID']) ) {
            if ( $parameters['ASSIGNSTATUS_ID'] != '' ) {
                if ($callBack != '') {
                    $callBack .= '&';
                }
                $callBack .= modulecim_hrdb::ASSIGNSTATUS_ID.'='.$parameters['ASSIGNSTATUS_ID'];
            }
        }

 /*       if ( isset( $parameters['CAMPUS_ID']) ) {
            if ( $parameters['CAMPUS_ID'] != '' ) {
                if ($callBack != '') {
                    $callBack .= '&';
                }
                $callBack .= modulecim_hrdb::CAMPUS_ID.'='.$parameters['CAMPUS_ID'];
            }
        }
*
        if ( isset( $parameters['ASSIGNMENT_ID']) ) {
            if ( $parameters['ASSIGNMENT_ID'] != '' ) {
                if ($callBack != '') {
                    $callBack .= '&';
                }
                $callBack .= modulecim_hrdb::ASSIGNMENT_ID.'='.$parameters['ASSIGNMENT_ID'];
            }
        }
*/
        if ( isset( $parameters['VIEWER_ID']) ) {
            if ( $parameters['VIEWER_ID'] != '' ) {
                if ($callBack != '') {
                    $callBack .= '&';
                }
                $callBack .= modulecim_hrdb::VIEWER_ID.'='.$parameters['VIEWER_ID'];
            }
        }

        if ( isset( $parameters['ACCESS_ID']) ) {
            if ( $parameters['ACCESS_ID'] != '' ) {
                if ($callBack != '') {
                    $callBack .= '&';
                }
                $callBack .= modulecim_hrdb::ACCESS_ID.'='.$parameters['ACCESS_ID'];
            }
        }
        
        if ( isset( $parameters['REG_ID']) ) {
            if ( $parameters['REG_ID'] != '' ) {
                if ($callBack != '') {
                    $callBack .= '&';
                }
                $callBack .= modulecim_hrdb::REG_ID.'='.$parameters['REG_ID'];
            }
        }        

        if ( isset( $parameters['YEAR_ID']) ) {
            if ( $parameters['YEAR_ID'] != '' ) {
                if ($callBack != '') {
                    $callBack .= '&';
                }
                $callBack .= modulecim_hrdb::YEAR_ID.'='.$parameters['YEAR_ID'];
            }
        }

        if ( isset( $parameters['PERSON_YEAR_ID']) ) {
            if ( $parameters['PERSON_YEAR_ID'] != '' ) {
                if ($callBack != '') {
                    $callBack .= '&';
                }
                $callBack .= modulecim_hrdb::PERSON_YEAR_ID.'='.$parameters['PERSON_YEAR_ID'];
            }
        }
        
        if ( isset( $parameters['COUNTRY_ID']) ) {
            if ( $parameters['COUNTRY_ID'] != '' ) {
                if ($callBack != '') {
                    $callBack .= '&';
                }
                $callBack .= modulecim_hrdb::COUNTRY_ID.'='.$parameters['COUNTRY_ID'];
            }
        } 
        
         if ( isset( $parameters['DOWNLOAD_TYPE']) ) {
            if ( $parameters['DOWNLOAD_TYPE'] != '' ) {
                if ($callBack != '') {
                    $callBack .= '&';
                }
                $callBack .= modulecim_hrdb::DOWNLOAD_TYPE.'='.$parameters['DOWNLOAD_TYPE'];
            }
        }         
 
         if ( isset( $parameters['FORMLIST_TYPE']) ) {
            if ( $parameters['FORMLIST_TYPE'] != '' ) {
                if ($callBack != '') {
                    $callBack .= '&';
                }
                $callBack .= modulecim_hrdb::FORMLIST_TYPE.'='.$parameters['FORMLIST_TYPE'];
            }
        }             
 
         if ( isset( $parameters['SEARCH_STARTDATE']) ) {
            if ( $parameters['SEARCH_STARTDATE'] != '' ) {
                if ($callBack != '') {
                    $callBack .= '&';
                }
                $callBack .= modulecim_hrdb::SEARCH_STARTDATE.'='.$parameters['SEARCH_STARTDATE'];
            }
        }             

 
         if ( isset( $parameters['SEARCH_ENDDATE']) ) {
            if ( $parameters['SEARCH_ENDDATE'] != '' ) {
                if ($callBack != '') {
                    $callBack .= '&';
                }
                $callBack .= modulecim_hrdb::SEARCH_ENDDATE.'='.$parameters['SEARCH_ENDDATE'];
            }
        }                     
        
        if ( isset( $parameters['STAFFSCHEDULE_ID']) ) {
            if ( $parameters['STAFFSCHEDULE_ID'] != '' ) {
                if ($callBack != '') {
                    $callBack .= '&';
                }
                $callBack .= modulecim_hrdb::STAFFSCHEDULE_ID.'='.$parameters['STAFFSCHEDULE_ID'];
            }
        }

        if ( isset( $parameters['STAFFACTIVITY_ID']) ) {
            if ( $parameters['STAFFACTIVITY_ID'] != '' ) {
                if ($callBack != '') {
                    $callBack .= '&';
                }
                $callBack .= modulecim_hrdb::STAFFACTIVITY_ID.'='.$parameters['STAFFACTIVITY_ID'];
            }
        }

        if ( isset( $parameters['ACTIVITYTYPE_ID']) ) {
            if ( $parameters['ACTIVITYTYPE_ID'] != '' ) {
                if ($callBack != '') {
                    $callBack .= '&';
                }
                $callBack .= modulecim_hrdb::ACTIVITYTYPE_ID.'='.$parameters['ACTIVITYTYPE_ID'];
            }
        }

        if ( isset( $parameters['STAFFSCHEDULETYPE_ID']) ) {
            if ( $parameters['STAFFSCHEDULETYPE_ID'] != '' ) {
                if ($callBack != '') {
                    $callBack .= '&';
                }
                $callBack .= modulecim_hrdb::STAFFSCHEDULETYPE_ID.'='.$parameters['STAFFSCHEDULETYPE_ID'];
            }
        }

        if ( isset( $parameters['ACTIVITYSCHEDULE_ID']) ) {
            if ( $parameters['ACTIVITYSCHEDULE_ID'] != '' ) {
                if ($callBack != '') {
                    $callBack .= '&';
                }
                $callBack .= modulecim_hrdb::ACTIVITYSCHEDULE_ID.'='.$parameters['ACTIVITYSCHEDULE_ID'];
            }
        }

        if ( isset( $parameters['FIELD_ID']) ) {
            if ( $parameters['FIELD_ID'] != '' ) {
                if ($callBack != '') {
                    $callBack .= '&';
                }
                $callBack .= modulecim_hrdb::FIELD_ID.'='.$parameters['FIELD_ID'];
            }
        }

        if ( isset( $parameters['FIELDVALUE_ID']) ) {
            if ( $parameters['FIELDVALUE_ID'] != '' ) {
                if ($callBack != '') {
                    $callBack .= '&';
                }
                $callBack .= modulecim_hrdb::FIELDVALUE_ID.'='.$parameters['FIELDVALUE_ID'];
            }
        }

        if ( isset( $parameters['FIELDTYPE_ID']) ) {
            if ( $parameters['FIELDTYPE_ID'] != '' ) {
                if ($callBack != '') {
                    $callBack .= '&';
                }
                $callBack .= modulecim_hrdb::FIELDTYPE_ID.'='.$parameters['FIELDTYPE_ID'];
            }
        }

        if ( isset( $parameters['DATATYPE_ID']) ) {
            if ( $parameters['DATATYPE_ID'] != '' ) {
                if ($callBack != '') {
                    $callBack .= '&';
                }
                $callBack .= modulecim_hrdb::DATATYPE_ID.'='.$parameters['DATATYPE_ID'];
            }
        }

        if ( isset( $parameters['FIELDGROUP_ID']) ) {
            if ( $parameters['FIELDGROUP_ID'] != '' ) {
                if ($callBack != '') {
                    $callBack .= '&';
                }
                $callBack .= modulecim_hrdb::FIELDGROUP_ID.'='.$parameters['FIELDGROUP_ID'];
            }
        }

        if ( isset( $parameters['FIELDGROUP_MATCHES_ID']) ) {
            if ( $parameters['FIELDGROUP_MATCHES_ID'] != '' ) {
                if ($callBack != '') {
                    $callBack .= '&';
                }
                $callBack .= modulecim_hrdb::FIELDGROUP_MATCHES_ID.'='.$parameters['FIELDGROUP_MATCHES_ID'];
            }
        }

        if ( isset( $parameters['STAFFDIRECTOR_ID']) ) {
            if ( $parameters['STAFFDIRECTOR_ID'] != '' ) {
                if ($callBack != '') {
                    $callBack .= '&';
                }
                $callBack .= modulecim_hrdb::STAFFDIRECTOR_ID.'='.$parameters['STAFFDIRECTOR_ID'];
            }
        }
        
        if ( isset( $parameters['MONTH_ID']) ) {
            if ( $parameters['MONTH_ID'] != '' ) {
                if ($callBack != '') {
                    $callBack .= '&';
                }
                $callBack .= modulecim_hrdb::MONTH_ID.'='.$parameters['MONTH_ID'];
            }
        }

        if ( isset( $parameters['REPORT_ID']) ) {
            if ( $parameters['REPORT_ID'] != '' ) {
                if ($callBack != '') {
                    $callBack .= '&';
                }
                $callBack .= modulecim_hrdb::REPORT_ID.'='.$parameters['REPORT_ID'];
            }
        }

        if ( isset( $parameters['CUSTOMFIELD_ID']) ) {
            if ( $parameters['CUSTOMFIELD_ID'] != '' ) {
                if ($callBack != '') {
                    $callBack .= '&';
                }
                $callBack .= modulecim_hrdb::CUSTOMFIELD_ID.'='.$parameters['CUSTOMFIELD_ID'];
            }
        }

        if ( isset( $parameters['MINISTRY_ID']) ) {
            if ( $parameters['MINISTRY_ID'] != '' ) {
                if ($callBack != '') {
                    $callBack .= '&';
                }
                $callBack .= modulecim_hrdb::MINISTRY_ID.'='.$parameters['MINISTRY_ID'];
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
        return modulecim_hrdb::MULTILINGUAL_SERIES_KEY;
    }
    
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
        $this->sideBar = new obj_AdminSideBar( $this->moduleRootPath, $this->viewer );    
        
        $links = array();
        $adminLinks = array();
        $campusLevelLinks = array();

        $parameters = array();
        // TODO make an object to do this work
        $sql = "select * from cim_hrdb_access where viewer_id = ".$this->viewer->getViewerID()." limit 1";

        $db = new Database_Site();
        $db->connectToDB( SITE_DB_NAME, SITE_DB_PATH, SITE_DB_USER, SITE_DB_PWORD );

        $db->runSQL($sql);
        // if row retrieved ...
        $personID = -1;
        if ($row = $db->retrieveRow() )
        {
            $personID = $row['person_id'];
        }
        $parameters['PERSON_ID'] = $personID;

        // echo print_r($parameters,true);

        // GROUP 1: EVERYONE.
        // ALL viewers can access this link
        $requestLink = $this->getCallBack( modulecim_hrdb::PAGE_EDITMYINFO, '' , $parameters);
        $links[ '[editMyInfo]' ] = $requestLink;

        $requestLink = $this->getCallBack( modulecim_hrdb::PAGE_EDITMYCAMPUSASSIGNMENT, '' , $parameters);
        $links[ '[editMyCampusInfo]' ] = $requestLink;
        
        $requestLink = $this->getCallBack( modulecim_hrdb::PAGE_EDITMYYEARINSCHOOL, '' , $parameters);
        $links[ '[editMyYearInSchool]' ] = $requestLink;
        
        $requestLink = $this->getCallBack( modulecim_hrdb::PAGE_EDITMYEMERGINFO, '' , $parameters);
        $links[ '[editMyEmergInfo]' ] = $requestLink;

                // GROUP 2a: STAFF AND ABOVE ONLY.   (access HRDB forms)
        if (( $this->accessPrivManager->hasSitePriv() ) || ( $this->accessPrivManager->isStaff($this->viewer->getID()) ) ){
        
	        $parameters['FORMLIST_TYPE'] = modulecim_hrdb::FORMLIST_ACCESS;
	         $requestLink = $this->getCallBack( modulecim_hrdb::PAGE_HRDBFORMS, '' , $parameters);
	        $links[ '[editMyForms]' ] = $requestLink;    	 
        }       
        
//         $parameters['FORMLIST_TYPE'] = modulecim_hrdb::FORMLIST_ACCESS;
//          $requestLink = $this->getCallBack( modulecim_hrdb::PAGE_HRDBFORMS, '' , $parameters);
//         $links[ '[editMyForms]' ] = $requestLink;       

        // GROUP 2: CAMPUS ADMINS AND ABOVE ONLY.
        if ( ( $this->accessPrivManager->hasSitePriv() ) || ( $this->accessPrivManager->hasCampusPriv($this->viewer->getID()) ) ){
          //$requestLink = $this->getCallBack( modulecim_hrdb::PAGE_PEOPLE );
          //$campusLevelLinks[ '[PeopleList]' ] = $requestLink;
          // TODO if you have 'hrdb campus' group access rights you can see these
            $requestLink = $this->getCallBack( modulecim_hrdb::PAGE_PEOPLEBYCAMPUSES );
        $campusLevelLinks[ '[PeopleByCampuses]' ] = $requestLink;
            $requestLink = $this->getCallBack( modulecim_hrdb::PAGE_EDITSTUDENTYEARINSCHOOL );
        $campusLevelLinks[ '[CampusStudentsByYear]' ] = $requestLink;    
            $requestLink = $this->getCallBack( modulecim_hrdb::PAGE_VIEWSTUDENTYEARINSCHOOL );
        $campusLevelLinks[ '[NationalStudentsByYear]' ] = $requestLink;  
        
                 
        }      
        
                // GROUP 2a: STAFF AND ABOVE ONLY.   (approve HRDB forms)
        if (( $this->accessPrivManager->hasSitePriv() ) || ( $this->accessPrivManager->isStaff($this->viewer->getID()) ) ){
        	 $parameters['FORMLIST_TYPE'] = modulecim_hrdb::FORMLIST_APPROVAL;	// modulecim_hrdb::FORMLIST_APPROVAL as well
	       $requestLink = $this->getCallBack( modulecim_hrdb::PAGE_HRDBFORMS, '' , $parameters);
	       $campusLevelLinks[ '[approveForms]' ] = $requestLink;  
	       
	       $requestLink = $this->getCallBack( modulecim_hrdb::PAGE_VIEWSCHEDULECALENDAR, '' , $parameters);
	       $campusLevelLinks[ '[viewScheduleCalendar]' ] = $requestLink; 		       
	       
	       $requestLink = $this->getCallBack( modulecim_hrdb::PAGE_HRDBACTIVITIES, '' , $parameters);
	       $campusLevelLinks[ '[viewActivitiesByType]' ] = $requestLink;     
	       
	       $requestLink = $this->getCallBack( modulecim_hrdb::PAGE_VIEWACTIVITIESBYDATE, '' , $parameters);
	       $campusLevelLinks[ '[viewActivitiesByDate]' ] = $requestLink; 

        	 $parameters['FORMLIST_TYPE'] = modulecim_hrdb::FORMLIST_SUBMITTED;     
	       $requestLink = $this->getCallBack( modulecim_hrdb::PAGE_HRDBFORMS, '' , $parameters);
	       $campusLevelLinks[ '[viewStaffMissingForms]' ] = $requestLink;  	   

        	 $parameters['FORMLIST_TYPE'] = modulecim_hrdb::FORMLIST_ACCESS;     	       
	       $requestLink = $this->getCallBack( modulecim_hrdb::PAGE_CUSTOMREPORTSLISTING, '' , $parameters);
	       $campusLevelLinks[ '[viewCustomReportsList]' ] = $requestLink;  	   	           	                 
        }

        // GROUP 3: SUPER ADMINS ONLY.
        if ( $this->accessPrivManager->hasSitePriv()){        
	        
	       $parameters['FORMLIST_TYPE'] = modulecim_hrdb::FORMLIST_EDIT;	// modulecim_hrdb::FORMLIST_APPROVAL as well
	       $requestLink = $this->getCallBack( modulecim_hrdb::PAGE_HRDBFORMS, '' , $parameters);
	       $adminLinks[ '[editForms]' ] = $requestLink;     

        	 $parameters['FORMLIST_TYPE'] = modulecim_hrdb::FORMLIST_EDIT;     	       	       
	       $requestLink = $this->getCallBack( modulecim_hrdb::PAGE_CUSTOMREPORTSLISTING, '' , $parameters);	// PAGE_EDITCUSTOMREPORTS
	       $adminLinks[ '[editReports]' ] = $requestLink;  
        	        
          $requestLink = $this->getCallBack( modulecim_hrdb::PAGE_CAMPUSES );
          $adminLinks[ '[editCampuses]' ] = $requestLink;
          
          $requestLink = $this->getCallBack( modulecim_hrdb::PAGE_COUNTRIES );
          $adminLinks[ '[editCountries]' ] = $requestLink;
          
          $requestLink = $this->getCallBack( modulecim_hrdb::PAGE_PROVINCES );
          $adminLinks[ '[editProvinces]' ] = $requestLink;
          
          $requestLink = $this->getCallBack( modulecim_hrdb::PAGE_EDITREGION );
          $adminLinks[ '[editRegions]' ] = $requestLink;  
          
//           $requestLink = $this->getCallBack( modulecim_hrdb::PAGE_EDITPEOPLE ); 
//           $adminLinks[ '[editPeople]' ] = $requestLink;              

          $requestLink = $this->getCallBack( modulecim_hrdb::PAGE_PRIVILEGES );
          $adminLinks[ '[editPrivileges]' ] = $requestLink;

          $requestLink = $this->getCallBack( modulecim_hrdb::PAGE_EDITSTAFF );
          $adminLinks[ '[Staff]' ] = $requestLink;

          $requestLink = $this->getCallBack( modulecim_hrdb::PAGE_ADMINS );
          $adminLinks[ '[Admins]' ] = $requestLink;
          
          $requestLink = $this->getCallBack( modulecim_hrdb::PAGE_EDITCAMPUSASSIGNMENT );
          $adminLinks[ '[CampusAssignments]' ] = $requestLink;   

          $requestLink = $this->getCallBack( modulecim_hrdb::PAGE_EDITCAMPUSASSIGNMENTSTATUSTYPES );
          $adminLinks[ '[AssignStatusTypes]' ] = $requestLink;          
          
          $requestLink = $this->getCallBack( modulecim_hrdb::PAGE_EDITACTIVITYTYPES );
          $adminLinks[ '[ActivityTypes]' ] = $requestLink;          
                    
          
        }

        // pass the links to the sidebar object
        $this->sideBar->setLinks( $links );
        $this->sideBar->setAdminLinks( $adminLinks );
        $this->sideBar->setCampusLevelLinks( $campusLevelLinks );

    } // end loadSideBar()

    
    
    //************************************************************************
	/**
	 * function loadEditMyInfo
	 * <pre>
	 * Initializes the EditMyInfo Page.
	 * </pre>
	 * @return [void]
	 */
    // RAD Tools: FormSingleEntry style
    function loadEditMyInfo() 
    {
        // set the pageCallBack to be without any additional parameters
        // (an AdminBox needs this so Language Switching on a page doesn't
        // pass a previous operations)
        $parameters = array('PERSON_ID'=>$this->PERSON_ID, 'PROVINCE_ID'=>$this->PROVINCE_ID, 'GENDER_ID'=>$this->GENDER_ID, 'STAFF_ID'=>$this->STAFF_ID);//[RAD_CALLBACK_PARAMS]
        $pageCallBack = $this->getCallBack(modulecim_hrdb::PAGE_EDITMYINFO, $this->sortBy, $parameters);
        $this->setPageCallBack( $pageCallBack );


        $parameters = array('PERSON_ID'=>$this->PERSON_ID, 'PROVINCE_ID'=>$this->PROVINCE_ID, 'GENDER_ID'=>$this->GENDER_ID, 'STAFF_ID'=>$this->STAFF_ID);//[RAD_CALLBACK_PARAMS]
        $formAction = $this->getCallBack(modulecim_hrdb::PAGE_EDITMYINFO, $this->sortBy, $parameters );
        // echo $formAction .'<br/>';
        $this->pageDisplay = new FormProcessor_EditMyInfo( $this->moduleRootPath, $this->viewer, $formAction, $this->PERSON_ID );//[RAD_FORMINIT_FOREIGNKEY_INIT]

    } // end loadEditMyInfo()



    //************************************************************************
	/**
	 * function loadHrdbHome
	 * <pre>
	 * Initializes the HrdbHome Page.
	 * </pre>
	 * @return [void]
	 */
    // RAD Tools: Custom style
    function loadHrdbHome( $isCreated = false )
    {
	    $reg_sys_controller = new modulecim_reg($this->db, $this->viewer, $this->labels);
	    $reg_sys_controller->setBaseCallBack( Page::getBaseURL().'?'.'p_Mod=cim_reg' );
	    
        // set the pageCallBack to be without any additional parameters
        // (an AdminBox needs this so Language Switching on a page doesn't
        // pass a previous operations)
        $parameters = array('PERSON_ID'=>$this->PERSON_ID, 'PROVINCE_ID'=>$this->PROVINCE_ID, 'GENDER_ID'=>$this->GENDER_ID, 'STAFF_ID'=>$this->STAFF_ID);//[RAD_CALLBACK_PARAMS]
        $pageCallBack = $this->getCallBack(modulecim_hrdb::PAGE_HRDBHOME, $this->sortBy, $parameters);
        $this->setPageCallBack( $pageCallBack );
        
        /** ADDED TO CREATE FORM-DATALIST PAGE **/
        
     	        // compile a formAction for the adminBox
        $parameters = array('PERSON_ID'=>$this->PERSON_ID, 'PROVINCE_ID'=>$this->PROVINCE_ID, 'GENDER_ID'=>$this->GENDER_ID, 'STAFF_ID'=>$this->STAFF_ID);//[RAD_CALLBACK_PARAMS]
        $formAction = $this->getCallBack(modulecim_hrdb::PAGE_HRDBHOME, $this->sortBy, $parameters );
	        
	        // set the pageCallBack value.  This is used by the Language switching
        // code
        $this->setPageCallBack( $formAction );
        
        // if this pageDisplay object isn't already created then 
        if ( !$isCreated ) {
	        
	        
	        if ($this->PERSON_ID == '')
	        {
	        		$this->PERSON_ID = $this->getPersonIDfromViewerID();		// default person is the viewer
        	  }
        
           // create a new pageDisplay object
           $this->pageDisplay = new page_HrdbHome( $this->moduleRootPath, $this->viewer, $formAction, $this->sortBy,  $this->PERSON_ID);//[RAD_FORMINIT_FOREIGNKEY_INIT]    
        
        } else {
        
            // otherwise just update the formAction value
            $this->pageDisplay->setFormAction( $formAction );
        }
        
        $links = array();
        
//         $parameters = array('REG_ID'=>$this->REG_ID, 'PERSON_ID'=>$this->PERSON_ID, 'PROVINCE_ID'=>$this->PROVINCE_ID, 'GENDER_ID'=>$this->GENDER_ID, 'STAFF_ID'=>$this->STAFF_ID);//[RAD_CALLBACK_PARAMS]
//         $continueLink = $this->getCallBack( modulecim_hrdb::PAGE_HRDBHOME, "", $parameters );
//         $links["cont"] = $continueLink;

        $parameters = array('REG_ID'=>$this->REG_ID, 'PERSON_ID'=>$this->PERSON_ID);	//, 'PROVINCE_ID'=>$this->PROVINCE_ID, 'GENDER_ID'=>$this->GENDER_ID, 'STAFF_ID'=>$this->STAFF_ID);//[RAD_CALLBACK_PARAMS]
        $editLink = $reg_sys_controller->getCallBack( modulecim_reg::PAGE_EDITREGISTRATIONDETAILS, $this->sortBy, $parameters );
        $editLink .= "&". modulecim_hrdb::REG_ID . "=";
        $links[ "edit" ] = $editLink;
        
        $delLink = $reg_sys_controller->getCallBack( modulecim_reg::PAGE_CONFIRMDELETEREGISTRATION, $this->sortBy, $parameters );
        $delLink .= "&". modulecim_hrdb::REG_ID . "=";
        $links[ "del" ] = $delLink;

/*[RAD_LINK_INSERT]*/

        $parameters = array('REG_ID'=>$this->REG_ID, 'PERSON_ID'=>$this->PERSON_ID, 'PROVINCE_ID'=>$this->PROVINCE_ID, 'GENDER_ID'=>$this->GENDER_ID, 'STAFF_ID'=>$this->STAFF_ID);//[RAD_CALLBACK_PARAMS]
        $sortByLink = $this->getCallBack( modulecim_hrdb::PAGE_HRDBHOME, '', $parameters );
        $sortByLink .= "&".modulecim_hrdb::SORTBY."=";
        $links["sortBy"] = $sortByLink;

        $this->pageDisplay->setLinks( $links ); 
        
        /*** END FORM-DATALIST ADD **/	        


//         $this->pageDisplay = new page_HrdbHome( $this->moduleRootPath, $this->viewer );

//         $links = array();

// /*[RAD_LINK_INSERT]*/

//         $this->pageDisplay->setLinks( $links );

    } // end loadHrdbHome()
    
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

    
    //************************************************************************
	/**
	 * function loadCountries
	 * <pre>
	 * Initializes the Countries Page.
	 * </pre>
	 * @param $isCreated [BOOL] "Is THIS pageDisplay object already created?"
	 * @return [void]
	 */
    // RAD Tools: AdminBox Style
    function loadCountries( $isCreated=false )
    {
	    
        // GROUP 3: SUPER ADMINS ONLY.
        if ( $this->accessPrivManager->hasSitePriv()){
        
	        // compile a formAction for the adminBox
	        $parameters = array('PERSON_ID'=>$this->PERSON_ID, 'GENDER_ID'=>$this->GENDER_ID, 'STAFF_ID'=>$this->STAFF_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'COUNTRY_ID'=>$this->COUNTRY_ID);//[RAD_CALLBACK_PARAMS]
	        $formAction = $this->getCallBack(modulecim_hrdb::PAGE_COUNTRIES, $this->sortBy, $parameters );
	        
	        // set the pageCallBack value.  This is used by the Language switching
	        // code
	        $this->setPageCallBack( $formAction );
	        
// 	        echo "country_id = ".$this->COUNTRY_ID;
	        
	        // if this pageDisplay object isn't already created then 
	        if ( !$isCreated ) {
	        
	            // create a new pageDisplay object
	            $this->pageDisplay = new FormProcessor_Countries( $this->moduleRootPath, $this->viewer, $formAction, $this->sortBy,  $this->COUNTRY_ID );//[RAD_FORMINIT_FOREIGNKEY_INIT]    
	        
	        } else {
	        
	            // otherwise just update the formAction value
	            $this->pageDisplay->setFormAction( $formAction );
	        }
	        
	        $links = array();
	        
	        $parameters = array( );//[RAD_CALLBACK_PARAMS_EDIT]
	        $editLink = $this->getCallBack( modulecim_hrdb::PAGE_COUNTRIES, $this->sortBy, $parameters );
	        $editLink .= "&". modulecim_hrdb::COUNTRY_ID . "=";
	        $links[ "edit" ] = $editLink;
	        
	        // NOTE: delete link is same as edit link for an AdminBox
	        $links[ "del" ] = $editLink;
	
	/*[RAD_LINK_INSERT]*/
	
	        $parameters = array('PERSON_ID'=>$this->PERSON_ID, 'GENDER_ID'=>$this->GENDER_ID, 'STAFF_ID'=>$this->STAFF_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'COUNTRY_ID'=>$this->COUNTRY_ID);//[RAD_CALLBACK_PARAMS]
	        $sortByLink = $this->getCallBack( modulecim_hrdb::PAGE_COUNTRIES, '', $parameters );
	        $sortByLink .= "&".modulecim_hrdb::SORTBY."=";
	        $links["sortBy"] = $sortByLink;
	
	        $this->pageDisplay->setLinks( $links );    
        }
        else
        {
	        $this->pageDisplay = new page_NotAuthorized($this->moduleRootPath, $this->viewer);  
        }  
	        
        
    } // end loadCountries()    
    

    //************************************************************************
	/**
	 * function loadProvinces
	 * <pre>
	 * Initializes the Provinces Page.
	 * </pre>
	 * @param $isCreated [BOOL] "Is THIS pageDisplay object already created?"
	 * @return [void]
	 */
    // RAD Tools: AdminBox Style
    function loadProvinces( $isCreated=false )
    {
	    
        // GROUP 3: SUPER ADMINS ONLY.
        if ( $this->accessPrivManager->hasSitePriv()){
        
	        // compile a formAction for the adminBox
	        $parameters = array('PERSON_ID'=>$this->PERSON_ID, 'PROVINCE_ID'=>$this->PROVINCE_ID, 'GENDER_ID'=>$this->GENDER_ID, 'STAFF_ID'=>$this->STAFF_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID);//[RAD_CALLBACK_PARAMS]
	        $formAction = $this->getCallBack(modulecim_hrdb::PAGE_PROVINCES, $this->sortBy, $parameters );
	        
	        // set the pageCallBack value.  This is used by the Language switching
	        // code
	        $this->setPageCallBack( $formAction );
	        
// 	        echo "province id = ".$this->PROVINCE_ID;
	        
	        // if this pageDisplay object isn't already created then 
	        if ( !$isCreated ) {
	        
	            // create a new pageDisplay object
	            $this->pageDisplay = new FormProcessor_Provinces( $this->moduleRootPath, $this->viewer, $formAction, $this->sortBy,  $this->PROVINCE_ID );//[RAD_FORMINIT_FOREIGNKEY_INIT]    
	        
	        } else {
	        
	            // otherwise just update the formAction value
	            $this->pageDisplay->setFormAction( $formAction );
	        }
	        
	        $links = array();
	        
	        $parameters = array( );//[RAD_CALLBACK_PARAMS_EDIT]
	        $editLink = $this->getCallBack( modulecim_hrdb::PAGE_PROVINCES, $this->sortBy, $parameters );
	        $editLink .= "&". modulecim_hrdb::PROVINCE_ID . "=";
	        $links[ "edit" ] = $editLink;
	        
	        // NOTE: delete link is same as edit link for an AdminBox
	        $links[ "del" ] = $editLink;
	
	/*[RAD_LINK_INSERT]*/
	
	        $parameters = array('PERSON_ID'=>$this->PERSON_ID, 'PROVINCE_ID'=>$this->PROVINCE_ID, 'GENDER_ID'=>$this->GENDER_ID, 'STAFF_ID'=>$this->STAFF_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID);//[RAD_CALLBACK_PARAMS]
	        $sortByLink = $this->getCallBack( modulecim_hrdb::PAGE_PROVINCES, '', $parameters );
	        $sortByLink .= "&".modulecim_hrdb::SORTBY."=";
	        $links["sortBy"] = $sortByLink;
	
	        $this->pageDisplay->setLinks( $links );    
        }
        else
        {
	        $this->pageDisplay = new page_NotAuthorized($this->moduleRootPath, $this->viewer);  
        }  
	        
        
    } // end loadProvinces()



    //************************************************************************
	/**
	 * function loadCampuses
	 * <pre>
	 * Initializes the Campuses Page.
	 * </pre>
	 * @param $isCreated [BOOL] "Is THIS pageDisplay object already created?"
	 * @return [void]
	 */
    // RAD Tools: AdminBox Style
    function loadCampuses( $isCreated=false ) 
    {
        // GROUP 3: SUPER ADMINS ONLY.
        if ( $this->accessPrivManager->hasSitePriv()){
	               
	       // echo 'Inside controller loadCampuses<br/>';
	        
	        // compile a formAction for the adminBox
	        $parameters = array('PERSON_ID'=>$this->PERSON_ID, 'PROVINCE_ID'=>$this->PROVINCE_ID, 'GENDER_ID'=>$this->GENDER_ID, 'STAFF_ID'=>$this->STAFF_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID);//[RAD_CALLBACK_PARAMS]
	        $formAction = $this->getCallBack(modulecim_hrdb::PAGE_CAMPUSES, $this->sortBy, $parameters );
	
	        // set the pageCallBack value.  This is used by the Language switching
	        // code
	        $this->setPageCallBack( $formAction );
	        
	        // if this pageDisplay object isn't already created then 
	        if ( !$isCreated ) {
	        
	            // create a new pageDisplay object
	            $this->pageDisplay = new FormProcessor_Campuses( $this->moduleRootPath, $this->viewer, $formAction, $this->sortBy,  $this->CAMPUS_ID );//[RAD_FORMINIT_FOREIGNKEY_INIT]    
	        
	        } else {
	        
	            // otherwise just update the formAction value
	            $this->pageDisplay->setFormAction( $formAction );
	        }
	        
	        $links = array();
	        
	        $parameters = array( );//[RAD_CALLBACK_PARAMS_EDIT]
	        $editLink = $this->getCallBack( modulecim_hrdb::PAGE_CAMPUSES, $this->sortBy, $parameters );
	        $editLink .= "&". modulecim_hrdb::CAMPUS_ID . "=";
	        $links[ "edit" ] = $editLink;
	        
	        // NOTE: delete link is same as edit link for an AdminBox
	        $links[ "del" ] = $editLink;
	
	/*[RAD_LINK_INSERT]*/
	
	        $parameters = array('PERSON_ID'=>$this->PERSON_ID, 'PROVINCE_ID'=>$this->PROVINCE_ID, 'GENDER_ID'=>$this->GENDER_ID, 'STAFF_ID'=>$this->STAFF_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID);//[RAD_CALLBACK_PARAMS]
	        $sortByLink = $this->getCallBack( modulecim_hrdb::PAGE_CAMPUSES, '', $parameters );
	        $sortByLink .= "&".modulecim_hrdb::SORTBY."=";
	        $links["sortBy"] = $sortByLink;
	
	        $this->pageDisplay->setLinks( $links );    
        }
        else
        {
	        $this->pageDisplay = new page_NotAuthorized($this->moduleRootPath, $this->viewer);  
        }  
                
    } // end loadCampuses()



    //************************************************************************
	/**
	 * function loadImportData
	 * <pre>
	 * Initializes the ImportData Page.
	 * </pre>
	 * @return [void]
	 */
    // RAD Tools: Custom style
    function loadImportData()
    {
        // GROUP 3: SUPER ADMINS ONLY.
        if ( $this->accessPrivManager->hasSitePriv()){	    
	    
	        // set the pageCallBack to be without any additional parameters
	        // (an AdminBox needs this so Language Switching on a page doesn't
	        // pass a previous operations)
	        $parameters = array('PERSON_ID'=>$this->PERSON_ID, 'PROVINCE_ID'=>$this->PROVINCE_ID, 'GENDER_ID'=>$this->GENDER_ID, 'STAFF_ID'=>$this->STAFF_ID);//[RAD_CALLBACK_PARAMS]
	        $pageCallBack = $this->getCallBack(modulecim_hrdb::PAGE_IMPORTDATA, $this->sortBy, $parameters);
	        $this->setPageCallBack( $pageCallBack );
	
	
	        $this->pageDisplay = new page_ImportData( $this->moduleRootPath, $this->viewer );
	
	        $links = array();
	
	/*[RAD_LINK_INSERT]*/
	
	        $this->pageDisplay->setLinks( $links );
        }
        else
        {
	        $this->pageDisplay = new page_NotAuthorized($this->moduleRootPath, $this->viewer);  
        }  

    } // end loadImportData()



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
	    
        // GROUP 3: SUPER ADMINS ONLY.
        if ( $this->accessPrivManager->hasSitePriv()){	    
		    
	        // set the pageCallBack to be without any additional parameters
	        // (an AdminBox needs this so Language Switching on a page doesn't
	        // pass a previous operations)
	        $parameters = array('PERSON_ID'=>$this->PERSON_ID, 'PROVINCE_ID'=>$this->PROVINCE_ID, 'GENDER_ID'=>$this->GENDER_ID, 'STAFF_ID'=>$this->STAFF_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID);//[RAD_CALLBACK_PARAMS]
	        $pageCallBack = $this->getCallBack(modulecim_hrdb::PAGE_NEWPERSON, $this->sortBy, $parameters);
	        $this->setPageCallBack( $pageCallBack );
	        
	
	        $parameters = array('PERSON_ID'=>$this->PERSON_ID, 'PROVINCE_ID'=>$this->PROVINCE_ID, 'GENDER_ID'=>$this->GENDER_ID, 'STAFF_ID'=>$this->STAFF_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID);//[RAD_CALLBACK_PARAMS]
	        $formAction = $this->getCallBack(modulecim_hrdb::PAGE_NEWPERSON, $this->sortBy, $parameters );
	        $this->pageDisplay = new FormProcessor_NewPerson( $this->moduleRootPath, $this->viewer, $formAction, $this->PERSON_ID, $this->CAMPUS_ID );//[RAD_FORMINIT_FOREIGNKEY_INIT]
	 
        }
        else
        {
	        $this->pageDisplay = new page_NotAuthorized($this->moduleRootPath, $this->viewer);  
        }          
               
    } // end loadNewPerson()



    //************************************************************************
	/**
	 * function loadPrivileges
	 * <pre>
	 * Initializes the Privileges Page.
	 * </pre>
	 * @param $isCreated [BOOL] "Is THIS pageDisplay object already created?"
	 * @return [void]
	 */
    // RAD Tools: AdminBox Style
    function loadPrivileges( $isCreated=false ) 
    {
        // GROUP 3: SUPER ADMINS ONLY.
        if ( $this->accessPrivManager->hasSitePriv()){	    
        
	        // compile a formAction for the adminBox
	        $parameters = array('PERSON_ID'=>$this->PERSON_ID, 'PROVINCE_ID'=>$this->PROVINCE_ID, 'GENDER_ID'=>$this->GENDER_ID, 'STAFF_ID'=>$this->STAFF_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'ADMIN_ID'=>$this->ADMIN_ID, 'PRIV_ID'=>$this->PRIV_ID, 'CAMPUSADMIN_ID'=>$this->CAMPUSADMIN_ID);//[RAD_CALLBACK_PARAMS]
	        $formAction = $this->getCallBack(modulecim_hrdb::PAGE_PRIVILEGES, $this->sortBy, $parameters );
	        
	        // set the pageCallBack value.  This is used by the Language switching
	        // code
	        $this->setPageCallBack( $formAction );
	        
	        // if this pageDisplay object isn't already created then 
	        if ( !$isCreated ) {
	        
	            // create a new pageDisplay object
	            $this->pageDisplay = new FormProcessor_Privileges( $this->moduleRootPath, $this->viewer, $formAction, $this->sortBy,  $this->PRIV_ID );//[RAD_FORMINIT_FOREIGNKEY_INIT]    
	        
	        } else {
	        
	            // otherwise just update the formAction value
	            $this->pageDisplay->setFormAction( $formAction );
	        }
	        
	        $links = array();
	        
	        $parameters = array( );//[RAD_CALLBACK_PARAMS_EDIT]
	        $editLink = $this->getCallBack( modulecim_hrdb::PAGE_PRIVILEGES, $this->sortBy, $parameters );
	        $editLink .= "&". modulecim_hrdb::PRIV_ID . "=";
	        $links[ "edit" ] = $editLink;
	        
	        // NOTE: delete link is same as edit link for an AdminBox
	        $links[ "del" ] = $editLink;
	
	/*[RAD_LINK_INSERT]*/
	
	        $parameters = array('PERSON_ID'=>$this->PERSON_ID, 'PROVINCE_ID'=>$this->PROVINCE_ID, 'GENDER_ID'=>$this->GENDER_ID, 'STAFF_ID'=>$this->STAFF_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'ADMIN_ID'=>$this->ADMIN_ID, 'PRIV_ID'=>$this->PRIV_ID, 'CAMPUSADMIN_ID'=>$this->CAMPUSADMIN_ID);//[RAD_CALLBACK_PARAMS]
	        $sortByLink = $this->getCallBack( modulecim_hrdb::PAGE_PRIVILEGES, '', $parameters );
	        $sortByLink .= "&".modulecim_hrdb::SORTBY."=";
	        $links["sortBy"] = $sortByLink;
	
	        $this->pageDisplay->setLinks( $links );    

        }
        else
        {
	        $this->pageDisplay = new page_NotAuthorized($this->moduleRootPath, $this->viewer);  
        }  	        
        
    } // end loadPrivileges()



    //************************************************************************
	/**
	 * function loadPeopleList
	 * <pre>
	 * Initializes the PeopleList Page.
	 * </pre>
	 * @param $isCreated [BOOL] "Is THIS pageDisplay object already created?"
	 * @return [void]
	 */
    // RAD Tools: AdminBox Style
    function loadPeopleList( $isCreated=false ) 
    {
        // GROUP 3: SUPER ADMINS ONLY.
        if ( $this->accessPrivManager->hasSitePriv()){
		                
	        // compile a formAction for the adminBox
	        $parameters = array('PERSON_ID'=>$this->PERSON_ID, 'PROVINCE_ID'=>$this->PROVINCE_ID, 'GENDER_ID'=>$this->GENDER_ID, 'STAFF_ID'=>$this->STAFF_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'ADMIN_ID'=>$this->ADMIN_ID, 'PRIV_ID'=>$this->PRIV_ID, 'CAMPUSADMIN_ID'=>$this->CAMPUSADMIN_ID);//[RAD_CALLBACK_PARAMS]
	        $formAction = $this->getCallBack(modulecim_hrdb::PAGE_PEOPLELIST, $this->sortBy, $parameters );
	        
	        // set the pageCallBack value.  This is used by the Language switching
	        // code
	        $this->setPageCallBack( $formAction );
	        
	        // if this pageDisplay object isn't already created then 
	        if ( !$isCreated ) {
	        
	            // create a new pageDisplay object
	            $this->pageDisplay = new FormProcessor_PeopleList( $this->moduleRootPath, $this->viewer, $formAction, $this->sortBy,  $this->PERSON_ID );//[RAD_FORMINIT_FOREIGNKEY_INIT]    
	        
	        } else {
	        
	            // otherwise just update the formAction value
	            $this->pageDisplay->setFormAction( $formAction );
	        }
	        
	        $links = array();
	        
	        $parameters = array( );//[RAD_CALLBACK_PARAMS_EDIT]
	        $editLink = $this->getCallBack( modulecim_hrdb::PAGE_PEOPLELIST, $this->sortBy, $parameters );
	        $editLink .= "&". modulecim_hrdb::PERSON_ID . "=";
	        $links[ "edit" ] = $editLink;
	        
	        // NOTE: delete link is same as edit link for an AdminBox
	        $links[ "del" ] = $editLink;
	
	/*[RAD_LINK_INSERT]*/
	
	        $parameters = array('PERSON_ID'=>$this->PERSON_ID, 'PROVINCE_ID'=>$this->PROVINCE_ID, 'GENDER_ID'=>$this->GENDER_ID, 'STAFF_ID'=>$this->STAFF_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'ADMIN_ID'=>$this->ADMIN_ID, 'PRIV_ID'=>$this->PRIV_ID, 'CAMPUSADMIN_ID'=>$this->CAMPUSADMIN_ID);//[RAD_CALLBACK_PARAMS]
	        $sortByLink = $this->getCallBack( modulecim_hrdb::PAGE_PEOPLELIST, '', $parameters );
	        $sortByLink .= "&".modulecim_hrdb::SORTBY."=";
	        $links["sortBy"] = $sortByLink;
	
	        $this->pageDisplay->setLinks( $links );    
        }
        else
        {
	        $this->pageDisplay = new page_NotAuthorized($this->moduleRootPath, $this->viewer);  
        }         
	        
    } // end loadPeopleList()



    //************************************************************************
	/**
	 * function loadDeletePerson
	 * <pre>
	 * Initializes the DeletePerson Page.
	 * </pre>
	 * @return [void]
	 */
    // RAD Tools: DeleteConf Style
    function loadDeletePerson() 
    {
        // GROUP 3: SUPER ADMINS ONLY.
        if ( $this->accessPrivManager->hasSitePriv()){	    
	        
	        // set the pageCallBack to be without any additional parameters
	        // (an AdminBox needs this so Language Switching on a page doesn't
	        // pass a previous operations)
	        $parameters = array('PERSON_ID'=>$this->PERSON_ID, 'PROVINCE_ID'=>$this->PROVINCE_ID, 'GENDER_ID'=>$this->GENDER_ID, 'STAFF_ID'=>$this->STAFF_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'ADMIN_ID'=>$this->ADMIN_ID, 'PRIV_ID'=>$this->PRIV_ID, 'CAMPUSADMIN_ID'=>$this->CAMPUSADMIN_ID);//[RAD_CALLBACK_PARAMS]
	        $pageCallBack = $this->getCallBack(modulecim_hrdb::PAGE_DELETEPERSON, $this->sortBy, $parameters);
	        $this->setPageCallBack( $pageCallBack );
	        
	        
	        $parameters = array('PERSON_ID'=>$this->PERSON_ID, 'PROVINCE_ID'=>$this->PROVINCE_ID, 'GENDER_ID'=>$this->GENDER_ID, 'STAFF_ID'=>$this->STAFF_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'ADMIN_ID'=>$this->ADMIN_ID, 'PRIV_ID'=>$this->PRIV_ID, 'CAMPUSADMIN_ID'=>$this->CAMPUSADMIN_ID);//[RAD_CALLBACK_PARAMS]
	        $formAction = $this->getCallBack(modulecim_hrdb::PAGE_DELETEPERSON, $this->sortBy, $parameters );
	        $this->pageDisplay = new page_DeletePerson( $this->moduleRootPath, $this->viewer, $formAction, $this->PERSON_ID );
        }
        else
        {
	        $this->pageDisplay = new page_NotAuthorized($this->moduleRootPath, $this->viewer);  
        }  	        
	                
    } // end loadDeletePerson()





    //************************************************************************
	/**
	 * function loadViewStaff
	 * <pre>
	 * Initializes the ViewStaff Page.
	 * </pre>
	 * @param $isCreated [BOOL] "Is THIS pageDisplay object already created?"
	 * @return [void]
	 */
    // RAD Tools: AdminBox Style
    function loadViewStaff( $isCreated=false ) 
    {

        // GROUP 3: SUPER ADMINS ONLY.
        if ( $this->accessPrivManager->hasSitePriv()){
	                
	        // compile a formAction for the adminBox
	        $parameters = array('PERSON_ID'=>$this->PERSON_ID, 'PROVINCE_ID'=>$this->PROVINCE_ID, 'GENDER_ID'=>$this->GENDER_ID, 'STAFF_ID'=>$this->STAFF_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'ADMIN_ID'=>$this->ADMIN_ID, 'PRIV_ID'=>$this->PRIV_ID, 'CAMPUSADMIN_ID'=>$this->CAMPUSADMIN_ID);//[RAD_CALLBACK_PARAMS]
	        $formAction = $this->getCallBack(modulecim_hrdb::PAGE_VIEWSTAFF, $this->sortBy, $parameters );
	        
	        // set the pageCallBack value.  This is used by the Language switching
	        // code
	        $this->setPageCallBack( $formAction );
	        
	        // if this pageDisplay object isn't already created then 
	        if ( !$isCreated ) {
	        
	            // create a new pageDisplay object
	            $this->pageDisplay = new FormProcessor_ViewStaff( $this->moduleRootPath, $this->viewer, $formAction, $this->sortBy,  $this->STAFF_ID , $this->PERSON_ID);//[RAD_FORMINIT_FOREIGNKEY_INIT]    
	        
	        } else {
	        
	            // otherwise just update the formAction value
	            $this->pageDisplay->setFormAction( $formAction );
	        }
	        
	        $links = array();
	        
	        $parameters = array( );//[RAD_CALLBACK_PARAMS_EDIT]
	        $editLink = $this->getCallBack( modulecim_hrdb::PAGE_VIEWSTAFF, $this->sortBy, $parameters );
	        $editLink .= "&". modulecim_hrdb::STAFF_ID . "=";
	        $links[ "edit" ] = $editLink;
	        
	        // NOTE: delete link is same as edit link for an AdminBox
	        $links[ "del" ] = $editLink;
	
	/*[RAD_LINK_INSERT]*/
	
	        $parameters = array('PERSON_ID'=>$this->PERSON_ID, 'PROVINCE_ID'=>$this->PROVINCE_ID, 'GENDER_ID'=>$this->GENDER_ID, 'STAFF_ID'=>$this->STAFF_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'ADMIN_ID'=>$this->ADMIN_ID, 'PRIV_ID'=>$this->PRIV_ID, 'CAMPUSADMIN_ID'=>$this->CAMPUSADMIN_ID);//[RAD_CALLBACK_PARAMS]
	        $sortByLink = $this->getCallBack( modulecim_hrdb::PAGE_VIEWSTAFF, '', $parameters );
	        $sortByLink .= "&".modulecim_hrdb::SORTBY."=";
	        $links["sortBy"] = $sortByLink;
	
	        $this->pageDisplay->setLinks( $links );    
        }
        else
        {
	        $this->pageDisplay = new page_NotAuthorized($this->moduleRootPath, $this->viewer);  
        } 	        
	        
        
    } // end loadViewStaff()





    //************************************************************************
	/**
	 * function loadAddAdmin
	 * <pre>
	 * Initializes the AddAdmin Page.
	 * </pre>
	 * @return [void]
	 */
    // RAD Tools: FormSingleEntry style
    function loadAddAdmin() 
    {

        // GROUP 3: SUPER ADMINS ONLY.
        if ( $this->accessPrivManager->hasSitePriv()){
	        	    
	        // set the pageCallBack to be without any additional parameters
	        // (an AdminBox needs this so Language Switching on a page doesn't
	        // pass a previous operations)
	        $parameters = array('PERSON_ID'=>$this->PERSON_ID, 'PROVINCE_ID'=>$this->PROVINCE_ID, 'GENDER_ID'=>$this->GENDER_ID, 'STAFF_ID'=>$this->STAFF_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'ADMIN_ID'=>$this->ADMIN_ID, 'PRIV_ID'=>$this->PRIV_ID, 'CAMPUSADMIN_ID'=>$this->CAMPUSADMIN_ID);//[RAD_CALLBACK_PARAMS]
	        $pageCallBack = $this->getCallBack(modulecim_hrdb::PAGE_ADDADMIN, $this->sortBy, $parameters);
	        $this->setPageCallBack( $pageCallBack );
	        
	        
	        $parameters = array('PERSON_ID'=>$this->PERSON_ID, 'PROVINCE_ID'=>$this->PROVINCE_ID, 'GENDER_ID'=>$this->GENDER_ID, 'STAFF_ID'=>$this->STAFF_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'ADMIN_ID'=>$this->ADMIN_ID, 'PRIV_ID'=>$this->PRIV_ID, 'CAMPUSADMIN_ID'=>$this->CAMPUSADMIN_ID);//[RAD_CALLBACK_PARAMS]
	        $formAction = $this->getCallBack(modulecim_hrdb::PAGE_ADDADMIN, $this->sortBy, $parameters );
	        $this->pageDisplay = new FormProcessor_AddAdmin( $this->moduleRootPath, $this->viewer, $formAction, $this->ADMIN_ID );//[RAD_FORMINIT_FOREIGNKEY_INIT]        
        }
        else
        {
	        $this->pageDisplay = new page_NotAuthorized($this->moduleRootPath, $this->viewer);  
        } 	        
    } // end loadAddAdmin()





    //************************************************************************
	/**
	 * function loadEditPerson
	 * <pre>
	 * Initializes the EditPerson Page.
	 * </pre>
	 * @return [void]
	 */
    // RAD Tools: FormSingleEntry style
    function loadEditPerson() 
    {
        // GROUP 3: SUPER ADMINS ONLY.
        if ( $this->accessPrivManager->hasSitePriv()){
	        	    
	        // set the pageCallBack to be without any additional parameters
	        // (an AdminBox needs this so Language Switching on a page doesn't
	        // pass a previous operations)
	        $parameters = array('PERSON_ID'=>$this->PERSON_ID, 'PROVINCE_ID'=>$this->PROVINCE_ID, 'GENDER_ID'=>$this->GENDER_ID, 'STAFF_ID'=>$this->STAFF_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'ADMIN_ID'=>$this->ADMIN_ID, 'PRIV_ID'=>$this->PRIV_ID, 'CAMPUSADMIN_ID'=>$this->CAMPUSADMIN_ID, 'USER_ID'=>$this->USER_ID);//[RAD_CALLBACK_PARAMS]
	        $pageCallBack = $this->getCallBack(modulecim_hrdb::PAGE_EDITPERSON, $this->sortBy, $parameters);
	        $this->setPageCallBack( $pageCallBack );
	        
	        
	        $parameters = array('PERSON_ID'=>$this->PERSON_ID, 'PROVINCE_ID'=>$this->PROVINCE_ID, 'GENDER_ID'=>$this->GENDER_ID, 'STAFF_ID'=>$this->STAFF_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'ADMIN_ID'=>$this->ADMIN_ID, 'PRIV_ID'=>$this->PRIV_ID, 'CAMPUSADMIN_ID'=>$this->CAMPUSADMIN_ID, 'USER_ID'=>$this->USER_ID);//[RAD_CALLBACK_PARAMS]
	        $formAction = $this->getCallBack(modulecim_hrdb::PAGE_EDITPERSON, $this->sortBy, $parameters );
	        $this->pageDisplay = new FormProcessor_EditPerson( $this->moduleRootPath, $this->viewer, $formAction, $this->PERSON_ID );//[RAD_FORMINIT_FOREIGNKEY_INIT]        
        }
        else
        {
	        $this->pageDisplay = new page_NotAuthorized($this->moduleRootPath, $this->viewer);  
        }  
	        	        
    } // end loadEditPerson()



    //************************************************************************
	/**
	 * function loadAddStaff
	 * <pre>
	 * Initializes the AddStaff Page.
	 * </pre>
	 * @return [void]
	 */
    // RAD Tools: FormSingleEntry style
    function loadAddStaff() 
    {
        // GROUP 3: SUPER ADMINS ONLY.
        if ( $this->accessPrivManager->hasSitePriv()){	    
	    
	        // set the pageCallBack to be without any additional parameters
	        // (an AdminBox needs this so Language Switching on a page doesn't
	        // pass a previous operations)
	        $parameters = array('PERSON_ID'=>$this->PERSON_ID, 'PROVINCE_ID'=>$this->PROVINCE_ID, 'GENDER_ID'=>$this->GENDER_ID, 'STAFF_ID'=>$this->STAFF_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'ADMIN_ID'=>$this->ADMIN_ID, 'PRIV_ID'=>$this->PRIV_ID, 'CAMPUSADMIN_ID'=>$this->CAMPUSADMIN_ID, 'USER_ID'=>$this->USER_ID);//[RAD_CALLBACK_PARAMS]
	        $pageCallBack = $this->getCallBack(modulecim_hrdb::PAGE_ADDSTAFF, $this->sortBy, $parameters);
	        $this->setPageCallBack( $pageCallBack );
	        
	        
	        $parameters = array('PERSON_ID'=>$this->PERSON_ID, 'PROVINCE_ID'=>$this->PROVINCE_ID, 'GENDER_ID'=>$this->GENDER_ID, 'STAFF_ID'=>$this->STAFF_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'ADMIN_ID'=>$this->ADMIN_ID, 'PRIV_ID'=>$this->PRIV_ID, 'CAMPUSADMIN_ID'=>$this->CAMPUSADMIN_ID, 'USER_ID'=>$this->USER_ID);//[RAD_CALLBACK_PARAMS]
	        $formAction = $this->getCallBack(modulecim_hrdb::PAGE_ADDSTAFF, $this->sortBy, $parameters );
	        $this->pageDisplay = new FormProcessor_AddStaff( $this->moduleRootPath, $this->viewer, $formAction, $this->STAFF_ID );//[RAD_FORMINIT_FOREIGNKEY_INIT]        
	   
        }
        else
        {
	        $this->pageDisplay = new page_NotAuthorized($this->moduleRootPath, $this->viewer);  
        }          
             
    } // end loadAddStaff()



    //************************************************************************
	/**
	 * function loadStaff
	 * <pre>
	 * Initializes the Staff Page.
	 * </pre>
	 * @return [void]
	 */
    // RAD Tools: DataListTable Style
    function loadStaff() 
    {
        // GROUP 3: SUPER ADMINS ONLY.
        if ( $this->accessPrivManager->hasSitePriv()){
	        	    	    
	        // set the pageCallBack to be without any additional parameters
	        // (an AdminBox needs this so Language Switching on a page doesn't
	        // pass a previous operations)
	        $parameters = array('PERSON_ID'=>$this->PERSON_ID, 'PROVINCE_ID'=>$this->PROVINCE_ID, 'GENDER_ID'=>$this->GENDER_ID, 'STAFF_ID'=>$this->STAFF_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'ADMIN_ID'=>$this->ADMIN_ID, 'PRIV_ID'=>$this->PRIV_ID, 'CAMPUSADMIN_ID'=>$this->CAMPUSADMIN_ID, 'USER_ID'=>$this->USER_ID);//[RAD_CALLBACK_PARAMS]
	        $pageCallBack = $this->getCallBack(modulecim_hrdb::PAGE_STAFF, $this->sortBy, $parameters);
	        $this->setPageCallBack( $pageCallBack );
	
	        
	        $this->pageDisplay = new page_Staff( $this->moduleRootPath, $this->viewer, $this->sortBy );    
	        
	        $links = array();
	        
	/*[RAD_LINK_INSERT]*/
	
	        $parameters = array('PERSON_ID'=>$this->PERSON_ID, 'PROVINCE_ID'=>$this->PROVINCE_ID, 'GENDER_ID'=>$this->GENDER_ID, 'STAFF_ID'=>$this->STAFF_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'ADMIN_ID'=>$this->ADMIN_ID, 'PRIV_ID'=>$this->PRIV_ID, 'CAMPUSADMIN_ID'=>$this->CAMPUSADMIN_ID, 'USER_ID'=>$this->USER_ID);//[RAD_CALLBACK_PARAMS]
	        
	        $delLink = $this->getCallBack( modulecim_hrdb::PAGE_DELETESTAFF, '', $parameters );
	        $delLink .= "&" . modulecim_hrdb::STAFF_ID . "=";
	        $links["del"] = $delLink;
	        
	        $linksadd = $this->getCallBack( modulecim_hrdb::PAGE_ADDSTAFF, '', $parameters );
	        $links["add"] = $linksadd;  
	
	        $sortByLink = $this->getCallBack( modulecim_hrdb::PAGE_STAFF, '', $parameters );
	        $sortByLink .= "&".modulecim_hrdb::SORTBY."=";
	        $links["sortBy"] = $sortByLink;
	
	        $this->pageDisplay->setLinks( $links ); 
        }
        else
        {
	        $this->pageDisplay = new page_NotAuthorized($this->moduleRootPath, $this->viewer);  
        }  	        
        
    } // end loadStaff()



    //************************************************************************
	/**
	 * function loadDeleteStaff
	 * <pre>
	 * Initializes the DeleteStaff Page.
	 * </pre>
	 * @return [void]
	 */
    // RAD Tools: DeleteConf Style
    function loadDeleteStaff() 
    {
        // GROUP 3: SUPER ADMINS ONLY.
        if ( $this->accessPrivManager->hasSitePriv()){
		        	    
	        // set the pageCallBack to be without any additional parameters
	        // (an AdminBox needs this so Language Switching on a page doesn't
	        // pass a previous operations)
	        $parameters = array('PERSON_ID'=>$this->PERSON_ID, 'PROVINCE_ID'=>$this->PROVINCE_ID, 'GENDER_ID'=>$this->GENDER_ID, 'STAFF_ID'=>$this->STAFF_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'ADMIN_ID'=>$this->ADMIN_ID, 'PRIV_ID'=>$this->PRIV_ID, 'CAMPUSADMIN_ID'=>$this->CAMPUSADMIN_ID, 'USER_ID'=>$this->USER_ID);//[RAD_CALLBACK_PARAMS]
	        $pageCallBack = $this->getCallBack(modulecim_hrdb::PAGE_DELETESTAFF, $this->sortBy, $parameters);
	        $this->setPageCallBack( $pageCallBack );
	        
	        
	        $parameters = array('PERSON_ID'=>$this->PERSON_ID, 'PROVINCE_ID'=>$this->PROVINCE_ID, 'GENDER_ID'=>$this->GENDER_ID, 'STAFF_ID'=>$this->STAFF_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'ADMIN_ID'=>$this->ADMIN_ID, 'PRIV_ID'=>$this->PRIV_ID, 'CAMPUSADMIN_ID'=>$this->CAMPUSADMIN_ID, 'USER_ID'=>$this->USER_ID);//[RAD_CALLBACK_PARAMS]
	        $formAction = $this->getCallBack(modulecim_hrdb::PAGE_DELETESTAFF, $this->sortBy, $parameters );
	        $this->pageDisplay = new page_DeleteStaff( $this->moduleRootPath, $this->viewer, $formAction, $this->STAFF_ID );

        }
        else
        {
	        $this->pageDisplay = new page_NotAuthorized($this->moduleRootPath, $this->viewer);  
        }  	        
	        

    } // end loadDeleteStaff()



    //************************************************************************
	/**
	 * function loadAdmins
	 * <pre>
	 * Initializes the Admins Page.
	 * </pre>
	 * @return [void]
	 */
    // RAD Tools: DataListTable Style
    function loadAdmins() 
    {

        // GROUP 3: SUPER ADMINS ONLY.
        if ( $this->accessPrivManager->hasSitePriv()){	    
	    
	        // set the pageCallBack to be without any additional parameters
	        // (an AdminBox needs this so Language Switching on a page doesn't
	        // pass a previous operations)
	        $parameters = array('PERSON_ID'=>$this->PERSON_ID, 'PROVINCE_ID'=>$this->PROVINCE_ID, 'GENDER_ID'=>$this->GENDER_ID, 'STAFF_ID'=>$this->STAFF_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'ADMIN_ID'=>$this->ADMIN_ID, 'PRIV_ID'=>$this->PRIV_ID, 'CAMPUSADMIN_ID'=>$this->CAMPUSADMIN_ID, 'USER_ID'=>$this->USER_ID);//[RAD_CALLBACK_PARAMS]
	        $pageCallBack = $this->getCallBack(modulecim_hrdb::PAGE_ADMINS, $this->sortBy, $parameters);
	        $this->setPageCallBack( $pageCallBack );
	
	        
	        $this->pageDisplay = new page_Admins( $this->moduleRootPath, $this->viewer, $this->sortBy );
	        
	        $links = array();
	        
	/*[RAD_LINK_INSERT]*/
	
	        $parameters = array('PERSON_ID'=>$this->PERSON_ID, 'PROVINCE_ID'=>$this->PROVINCE_ID, 'GENDER_ID'=>$this->GENDER_ID, 'STAFF_ID'=>$this->STAFF_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'PRIV_ID'=>$this->PRIV_ID, 'CAMPUSADMIN_ID'=>$this->CAMPUSADMIN_ID, 'USER_ID'=>$this->USER_ID);//[RAD_CALLBACK_PARAMS]
	
	        //Link to view Campuses the admin is associated with.
	        $viewCampusLink = $this->getCallBack( modulecim_hrdb::PAGE_VIEWCAMPUSES, "", $parameters );
	        $viewCampusLink .= "&" . modulecim_hrdb::ADMIN_ID . "=";
	        $links["view"] = $viewCampusLink;
	
	        $linksadd = $this->getCallBack( modulecim_hrdb::PAGE_ADDADMIN, '', $parameters );
	        $links["add"] = $linksadd;
	
	        //$parameters = array('PERSON_ID'=>$this->PERSON_ID, 'PROVINCE_ID'=>$this->PROVINCE_ID, 'GENDER_ID'=>$this->GENDER_ID, 'STAFF_ID'=>$this->STAFF_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'ADMIN_ID'=>$this->ADMIN_ID, 'PRIV_ID'=>$this->PRIV_ID, 'CAMPUSADMIN_ID'=>$this->CAMPUSADMIN_ID, 'USER_ID'=>$this->USER_ID);//[RAD_CALLBACK_PARAMS_EDIT]
	        //$editLink = $this->getCallBack( modulecim_hrdb::PAGE_ADMINS, '', $parameters );
	        //$links[ "edit" ] = $editLink;
	
	        $delLink = $this->getCallBack( modulecim_hrdb::PAGE_DELETEADMIN, '', $parameters );
	        $delLink .= "&" . modulecim_hrdb::ADMIN_ID . "=";
	        $links["del"] = $delLink;
	
	        $sortByLink = $this->getCallBack( modulecim_hrdb::PAGE_ADMINS, '', $parameters );
	        $sortByLink .= "&".modulecim_hrdb::SORTBY."=";
	        $links["sortBy"] = $sortByLink;
	
	        $this->pageDisplay->setLinks( $links );
        }
        else
        {
	        $this->pageDisplay = new page_NotAuthorized($this->moduleRootPath, $this->viewer);  
        }  	        
	        

    } // end loadAdmins()



    //************************************************************************
	/**
	 * function loadDeleteAdmin
	 * <pre>
	 * Initializes the DeleteAdmin Page.
	 * </pre>
	 * @return [void]
	 */
    // RAD Tools: DeleteConf Style
    function loadDeleteAdmin()
    {
        // GROUP 3: SUPER ADMINS ONLY.
        if ( $this->accessPrivManager->hasSitePriv()){	    
	    
	        // set the pageCallBack to be without any additional parameters
	        // (an AdminBox needs this so Language Switching on a page doesn't
	        // pass a previous operations)
	        $parameters = array('PERSON_ID'=>$this->PERSON_ID, 'PROVINCE_ID'=>$this->PROVINCE_ID, 'GENDER_ID'=>$this->GENDER_ID, 'STAFF_ID'=>$this->STAFF_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'ADMIN_ID'=>$this->ADMIN_ID, 'PRIV_ID'=>$this->PRIV_ID, 'CAMPUSADMIN_ID'=>$this->CAMPUSADMIN_ID, 'USER_ID'=>$this->USER_ID);//[RAD_CALLBACK_PARAMS]
	        $pageCallBack = $this->getCallBack(modulecim_hrdb::PAGE_DELETEADMIN, $this->sortBy, $parameters);
	        $this->setPageCallBack( $pageCallBack );
	
	        $parameters = array('PERSON_ID'=>$this->PERSON_ID, 'PROVINCE_ID'=>$this->PROVINCE_ID, 'GENDER_ID'=>$this->GENDER_ID, 'STAFF_ID'=>$this->STAFF_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'ADMIN_ID'=>$this->ADMIN_ID, 'PRIV_ID'=>$this->PRIV_ID, 'CAMPUSADMIN_ID'=>$this->CAMPUSADMIN_ID, 'USER_ID'=>$this->USER_ID);//[RAD_CALLBACK_PARAMS]
	        $formAction = $this->getCallBack(modulecim_hrdb::PAGE_DELETEADMIN, $this->sortBy, $parameters );
	        $this->pageDisplay = new page_DeleteAdmin( $this->moduleRootPath, $this->viewer, $formAction, $this->ADMIN_ID );
        }
        else
        {
	        $this->pageDisplay = new page_NotAuthorized($this->moduleRootPath, $this->viewer);  
        } 	        
	        

    } // end loadDeleteAdmin()



    //************************************************************************
	/**
	 * function loadViewCampuses
	 * <pre>
	 * Initializes the ViewCampuses Page.
	 * </pre>
	 * @param $isCreated [BOOL] "Is THIS pageDisplay object already created?"
	 * @return [void]
	 */
    // RAD Tools: AdminBox Style
    function loadViewCampuses( $isCreated=false )
    {

        // GROUP 3: SUPER ADMINS ONLY.
        if ( $this->accessPrivManager->hasSitePriv()){
	        
	        // compile a formAction for the adminBox
	        $parameters = array('PERSON_ID'=>$this->PERSON_ID, 'PROVINCE_ID'=>$this->PROVINCE_ID, 'GENDER_ID'=>$this->GENDER_ID, 'STAFF_ID'=>$this->STAFF_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'ADMIN_ID'=>$this->ADMIN_ID, 'PRIV_ID'=>$this->PRIV_ID, 'CAMPUSADMIN_ID'=>$this->CAMPUSADMIN_ID, 'USER_ID'=>$this->USER_ID);//[RAD_CALLBACK_PARAMS]
	        $formAction = $this->getCallBack(modulecim_hrdb::PAGE_VIEWCAMPUSES, $this->sortBy, $parameters );
	
	        // set the pageCallBack value.  This is used by the Language switching
	        // code
	        $this->setPageCallBack( $formAction );
	
	        // if this pageDisplay object isn't already created then
	        if ( !$isCreated ) {
	
	            // create a new pageDisplay object
	            $this->pageDisplay = new FormProcessor_ViewCampuses( $this->moduleRootPath, $this->viewer, $formAction, $this->sortBy,  $this->CAMPUSADMIN_ID , $this->ADMIN_ID);//[RAD_FORMINIT_FOREIGNKEY_INIT]
	
	        } else {
	
	            // otherwise just update the formAction value
	            $this->pageDisplay->setFormAction( $formAction );
	        }
	
	        $links = array();
	
	        $parameters = array('PERSON_ID'=>$this->PERSON_ID, 'PROVINCE_ID'=>$this->PROVINCE_ID, 'GENDER_ID'=>$this->GENDER_ID, 'STAFF_ID'=>$this->STAFF_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'ADMIN_ID'=>$this->ADMIN_ID, 'PRIV_ID'=>$this->PRIV_ID, 'CAMPUSADMIN_ID'=>$this->CAMPUSADMIN_ID, 'USER_ID'=>$this->USER_ID);//[RAD_CALLBACK_PARAMS_EDIT]
	        $editLink = $this->getCallBack( modulecim_hrdb::PAGE_VIEWCAMPUSES, $this->sortBy, $parameters );
	        $editLink .= "&". modulecim_hrdb::CAMPUSADMIN_ID . "=";
	        $links[ "edit" ] = $editLink;
	
	        $continueLink = $this->getCallBack( modulecim_hrdb::PAGE_ADMINS, "", $parameters );
	        $links["cont"] = $continueLink;
	
	        // NOTE: delete link is same as edit link for an AdminBox
	        $links[ "del" ] = $editLink;
	
	/*[RAD_LINK_INSERT]*/
	
	        $parameters = array('PERSON_ID'=>$this->PERSON_ID, 'PROVINCE_ID'=>$this->PROVINCE_ID, 'GENDER_ID'=>$this->GENDER_ID, 'STAFF_ID'=>$this->STAFF_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'ADMIN_ID'=>$this->ADMIN_ID, 'PRIV_ID'=>$this->PRIV_ID, 'CAMPUSADMIN_ID'=>$this->CAMPUSADMIN_ID, 'USER_ID'=>$this->USER_ID);//[RAD_CALLBACK_PARAMS]
	        $sortByLink = $this->getCallBack( modulecim_hrdb::PAGE_VIEWCAMPUSES, '', $parameters );
	        $sortByLink .= "&".modulecim_hrdb::SORTBY."=";
	        $links["sortBy"] = $sortByLink;
	
	        $this->pageDisplay->setLinks( $links );
        }
        else
        {
	        $this->pageDisplay = new page_NotAuthorized($this->moduleRootPath, $this->viewer);  
        }  	        

    } // end loadViewCampuses()



    //************************************************************************
	/**
	 * function loadPeople
	 * <pre>
	 * Initializes the People Page.
	 * </pre>
	 * @return [void]
	 */
    // RAD Tools: DataListTable Style
    function loadPeople()
    {
        // GROUP 3: SUPER ADMINS ONLY.
        if ( $this->accessPrivManager->hasSitePriv()){	    
	    
	        // set the pageCallBack to be without any additional parameters
	        // (an AdminBox needs this so Language Switching on a page doesn't
	        // pass a previous operations)
	        $parameters = array('PERSON_ID'=>$this->PERSON_ID, 'PROVINCE_ID'=>$this->PROVINCE_ID, 'GENDER_ID'=>$this->GENDER_ID, 'STAFF_ID'=>$this->STAFF_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID);//[RAD_CALLBACK_PARAMS]
	        $pageCallBack = $this->getCallBack(modulecim_hrdb::PAGE_PEOPLE, $this->sortBy, $parameters);
	        $this->setPageCallBack( $pageCallBack );
	
	        $this->pageDisplay = new page_People( $this->moduleRootPath, $this->viewer, $this->sortBy );
	
	        $links = array();
	
	/*[RAD_LINK_INSERT]*/
	
	        $parameters = array('PERSON_ID'=>$this->PERSON_ID, 'PROVINCE_ID'=>$this->PROVINCE_ID, 'GENDER_ID'=>$this->GENDER_ID, 'STAFF_ID'=>$this->STAFF_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID);//[RAD_CALLBACK_PARAMS]
	        $sortByLink = $this->getCallBack( modulecim_hrdb::PAGE_PEOPLE, '', $parameters );
	        $sortByLink .= "&".modulecim_hrdb::SORTBY."=";
	        $links["sortBy"] = $sortByLink;
	
	        $linksadd = $this->getCallBack( modulecim_hrdb::PAGE_NEWPERSON, '', $parameters );
	        $links["add"] = $linksadd;
	
	        $editLink = $this->getCallBack( modulecim_hrdb::PAGE_EDITPERSON, '', $parameters );
			  $editLink .= "&" . modulecim_hrdb::PERSON_ID . "=";
			  $links["edit"] = $editLink;
	
	        //Link to view Campuses the person is associated with.
	        $viewPersonLink = $this->getCallBack( modulecim_hrdb::PAGE_PERSONINFO, "", $parameters );
			  $viewPersonLink .= "&" . modulecim_hrdb::PERSON_ID . "=";
	        $links["viewmoreinfo"] = $viewPersonLink;
	
	        //Link to view Campuses the person is associated with.
	        $viewCampusLink = $this->getCallBack( modulecim_hrdb::PAGE_CAMPUSASSIGNMENTS, "", $parameters );
			  $viewCampusLink .= "&" . modulecim_hrdb::PERSON_ID . "=";
	        $links["campuses"] = $viewCampusLink;
	
	        $delLink = $this->getCallBack( modulecim_hrdb::PAGE_DELETEPERSON, '', $parameters );
			  $delLink .= "&" . modulecim_hrdb::PERSON_ID . "=";
			  $links["del"] = $delLink;
	
	        $this->pageDisplay->setLinks( $links );
        }
        else
        {
	        $this->pageDisplay = new page_NotAuthorized($this->moduleRootPath, $this->viewer);  
        } 	        

    } // end loadPeople()



    //************************************************************************
	/**
	 * function loadCampusAssignments
	 * <pre>
	 * Initializes the CampusAssignments Page.
	 * </pre>
	 * @param $isCreated [BOOL] "Is THIS pageDisplay object already created?"
	 * @return [void]
	 */
    // RAD Tools: AdminBox Style
    function loadCampusAssignments( $isCreated=false )
    {
        // GROUP 3: SUPER ADMINS ONLY.
        if ( $this->accessPrivManager->hasSitePriv()){
	    
	        // compile a formAction for the adminBox
	        $parameters = array('PERSON_ID'=>$this->PERSON_ID, 'PROVINCE_ID'=>$this->PROVINCE_ID, 'GENDER_ID'=>$this->GENDER_ID, 'STAFF_ID'=>$this->STAFF_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'ADMIN_ID'=>$this->ADMIN_ID, 'PRIV_ID'=>$this->PRIV_ID, 'CAMPUSADMIN_ID'=>$this->CAMPUSADMIN_ID, 'USER_ID'=>$this->USER_ID, 'ASSIGNMENT_ID'=>$this->ASSIGNMENT_ID);//[RAD_CALLBACK_PARAMS]
	        $formAction = $this->getCallBack(modulecim_hrdb::PAGE_CAMPUSASSIGNMENTS, $this->sortBy, $parameters );
	
	        // set the pageCallBack value.  This is used by the Language switching
	        // code
	        $this->setPageCallBack( $formAction );
	
	        // if this pageDisplay object isn't already created then
	        if ( !$isCreated ) {
	
	            // create a new pageDisplay object
	            $this->pageDisplay = new FormProcessor_CampusAssignments( $this->moduleRootPath, $this->viewer, $formAction, $this->sortBy,  $this->ASSIGNMENT_ID, $this->PERSON_ID);//[RAD_FORMINIT_FOREIGNKEY_INIT]
	        
	        } else {
	        
	            // otherwise just update the formAction value
	            $this->pageDisplay->setFormAction( $formAction );
	        }
	        
	        $links = array();
	        
	        $parameters = array('PERSON_ID'=>$this->PERSON_ID, 'PROVINCE_ID'=>$this->PROVINCE_ID, 'GENDER_ID'=>$this->GENDER_ID, 'STAFF_ID'=>$this->STAFF_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'ADMIN_ID'=>$this->ADMIN_ID, 'PRIV_ID'=>$this->PRIV_ID, 'CAMPUSADMIN_ID'=>$this->CAMPUSADMIN_ID, 'USER_ID'=>$this->USER_ID);//[RAD_CALLBACK_PARAMS_EDIT]
	        $editLink = $this->getCallBack( modulecim_hrdb::PAGE_CAMPUSASSIGNMENTS, $this->sortBy, $parameters );
	        $editLink .= "&". modulecim_hrdb::ASSIGNMENT_ID . "=";
	        $links[ "edit" ] = $editLink;
	        
	        $continueLink = $this->getCallBack( modulecim_hrdb::PAGE_PEOPLEBYCAMPUSES, "", $parameters );
	        $links["cont"] = $continueLink;
	        
	        // NOTE: delete link is same as edit link for an AdminBox
	        $links[ "del" ] = $editLink;
	
	/*[RAD_LINK_INSERT]*/
	
	        $parameters = array('PERSON_ID'=>$this->PERSON_ID, 'PROVINCE_ID'=>$this->PROVINCE_ID, 'GENDER_ID'=>$this->GENDER_ID, 'STAFF_ID'=>$this->STAFF_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'ADMIN_ID'=>$this->ADMIN_ID, 'PRIV_ID'=>$this->PRIV_ID, 'CAMPUSADMIN_ID'=>$this->CAMPUSADMIN_ID, 'USER_ID'=>$this->USER_ID, 'ASSIGNMENT_ID'=>$this->ASSIGNMENT_ID);//[RAD_CALLBACK_PARAMS]
	
	        $sortByLink = $this->getCallBack( modulecim_hrdb::PAGE_CAMPUSASSIGNMENTS, '', $parameters );
	        $sortByLink .= "&".modulecim_hrdb::SORTBY."=";
	        $links["sortBy"] = $sortByLink;
	
	        $this->pageDisplay->setLinks( $links );
        }
        else
        {
	        $this->pageDisplay = new page_NotAuthorized($this->moduleRootPath, $this->viewer);  
        }  	        
	        

    } // end loadCampusAssignments()

    //************************************************************************
	/**
	 * function loadPersonInfo
	 * <pre>
	 * Initializes the PersonInfo Page.
	 * </pre>
	 * @return [void]
	 */
    // RAD Tools: DataSingle Style
    function loadPersonInfo()
    {
        // GROUP 2: CAMPUS ADMINS AND ABOVE ONLY.
        if ( ( $this->accessPrivManager->hasSitePriv() ) || ( $this->accessPrivManager->hasCampusPriv($this->viewer->getID()) ) ){
	        
	        // set the pageCallBack to be without any additional parameters
	        // (an AdminBox needs this so Language Switching on a page doesn't
	        // pass a previous operations)
	        $parameters = array('PERSON_ID'=>$this->PERSON_ID, 'PROVINCE_ID'=>$this->PROVINCE_ID, 'GENDER_ID'=>$this->GENDER_ID, 'STAFF_ID'=>$this->STAFF_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'ADMIN_ID'=>$this->ADMIN_ID, 'PRIV_ID'=>$this->PRIV_ID, 'CAMPUSADMIN_ID'=>$this->CAMPUSADMIN_ID, 'USER_ID'=>$this->USER_ID, 'ASSIGNMENT_ID'=>$this->ASSIGNMENT_ID);//[RAD_CALLBACK_PARAMS]
	        $pageCallBack = $this->getCallBack(modulecim_hrdb::PAGE_PERSONINFO, $this->sortBy, $parameters);
	        $this->setPageCallBack( $pageCallBack );
	
	
	        $this->pageDisplay = new page_PersonInfo( $this->moduleRootPath, $this->viewer, $this->PERSON_ID );
	
	        $links = array();
	
	/*[RAD_LINK_INSERT]*/
	
	        $parameters = array('PERSON_ID'=>$this->PERSON_ID, 'PROVINCE_ID'=>$this->PROVINCE_ID, 'GENDER_ID'=>$this->GENDER_ID, 'STAFF_ID'=>$this->STAFF_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'ADMIN_ID'=>$this->ADMIN_ID, 'PRIV_ID'=>$this->PRIV_ID, 'CAMPUSADMIN_ID'=>$this->CAMPUSADMIN_ID, 'USER_ID'=>$this->USER_ID, 'ASSIGNMENT_ID'=>$this->ASSIGNMENT_ID);//[RAD_CALLBACK_PARAMS]
	        $continueLink = $this->getCallBack( modulecim_hrdb::PAGE_PEOPLEBYCAMPUSES, "", $parameters );
	        $links["cont"] = $continueLink;
	
	        $this->pageDisplay->setLinks( $links );
        }
        else
        {
	        $this->pageDisplay = new page_NotAuthorized($this->moduleRootPath, $this->viewer);  
        } 
        
    } // end loadPersonInfo()



    //************************************************************************
	/**
	 * function loadPeopleCampus
	 * <pre>
	 * Initializes the PeopleCampus Page.
	 * </pre>
	 * @param $isCreated [BOOL] "Is THIS pageDisplay object already created?"
	 * @return [void]
	 */
    // RAD Tools: AdminBox Style
    function loadPeopleCampus( $isCreated=false ) 
    {
        // GROUP 2: CAMPUS ADMINS AND ABOVE ONLY.
        if ( ( $this->accessPrivManager->hasSitePriv() ) || ( $this->accessPrivManager->hasCampusPriv($this->viewer->getID()) ) ){
		                
	        // compile a formAction for the adminBox
	        $parameters = array('PERSON_ID'=>$this->PERSON_ID, 'PROVINCE_ID'=>$this->PROVINCE_ID, 'GENDER_ID'=>$this->GENDER_ID, 'STAFF_ID'=>$this->STAFF_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'ADMIN_ID'=>$this->ADMIN_ID, 'PRIV_ID'=>$this->PRIV_ID, 'CAMPUSADMIN_ID'=>$this->CAMPUSADMIN_ID, 'USER_ID'=>$this->USER_ID, 'ASSIGNMENT_ID'=>$this->ASSIGNMENT_ID);//[RAD_CALLBACK_PARAMS]
	        $formAction = $this->getCallBack(modulecim_hrdb::PAGE_PEOPLECAMPUS, $this->sortBy, $parameters );
	        
	        // set the pageCallBack value.  This is used by the Language switching
	        // code
	        $this->setPageCallBack( $formAction );
	        
	        // if this pageDisplay object isn't already created then 
	        if ( !$isCreated ) {
	        
	            // create a new pageDisplay object
	            $this->pageDisplay = new FormProcessor_PeopleCampus( $this->moduleRootPath, $this->viewer, $formAction, $this->sortBy,  $this->PROVINCE_ID );//[RAD_FORMINIT_FOREIGNKEY_INIT]    
	        
	        } else {
	        
	            // otherwise just update the formAction value
	            $this->pageDisplay->setFormAction( $formAction );
	        }
	        
	        $links = array();
	        
	        $parameters = array( );//[RAD_CALLBACK_PARAMS_EDIT]
	        $editLink = $this->getCallBack( modulecim_hrdb::PAGE_PEOPLECAMPUS, $this->sortBy, $parameters );
	        $editLink .= "&". modulecim_hrdb::PROVINCE_ID . "=";
	        $links[ "edit" ] = $editLink;
	        
	        // NOTE: delete link is same as edit link for an AdminBox
	        $links[ "del" ] = $editLink;
	
	/*[RAD_LINK_INSERT]*/
	
	        $parameters = array('PERSON_ID'=>$this->PERSON_ID, 'PROVINCE_ID'=>$this->PROVINCE_ID, 'GENDER_ID'=>$this->GENDER_ID, 'STAFF_ID'=>$this->STAFF_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'ADMIN_ID'=>$this->ADMIN_ID, 'PRIV_ID'=>$this->PRIV_ID, 'CAMPUSADMIN_ID'=>$this->CAMPUSADMIN_ID, 'USER_ID'=>$this->USER_ID, 'ASSIGNMENT_ID'=>$this->ASSIGNMENT_ID);//[RAD_CALLBACK_PARAMS]
	        $sortByLink = $this->getCallBack( modulecim_hrdb::PAGE_PEOPLECAMPUS, '', $parameters );
	        $sortByLink .= "&".modulecim_hrdb::SORTBY."=";
	        $links["sortBy"] = $sortByLink;
	
	        $this->pageDisplay->setLinks( $links );    

        }
        else
        {
	        $this->pageDisplay = new page_NotAuthorized($this->moduleRootPath, $this->viewer);  
        }  
                
    } // end loadPeopleCampus()



    //************************************************************************
	/**
	 * function loadPeoplebyCampuses
	 * <pre>
	 * Initializes the PeoplebyCampuses Page.
	 * </pre>
	 * @return [void]
	 */
    // RAD Tools: DataListTable Style
    function loadPeoplebyCampuses() 
    {	    	    	    
        // GROUP 2: CAMPUS ADMINS AND ABOVE ONLY.
        if ( ( $this->accessPrivManager->hasSitePriv() ) || ( $this->accessPrivManager->hasCampusPriv($this->viewer->getID()) ) ){	    
		    
	        // set the pageCallBack to be without any additional parameters
	        // (an AdminBox needs this so Language Switching on a page doesn't
	        // pass a previous operations)
	        $parameters = array('PERSON_ID'=>$this->PERSON_ID, 'PROVINCE_ID'=>$this->PROVINCE_ID, 'GENDER_ID'=>$this->GENDER_ID, 'STAFF_ID'=>$this->STAFF_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'ADMIN_ID'=>$this->ADMIN_ID, 'PRIV_ID'=>$this->PRIV_ID, 'CAMPUSADMIN_ID'=>$this->CAMPUSADMIN_ID, 'USER_ID'=>$this->USER_ID, 'ASSIGNMENT_ID'=>$this->ASSIGNMENT_ID);//[RAD_CALLBACK_PARAMS]
	        $pageCallBack = $this->getCallBack(modulecim_hrdb::PAGE_PEOPLEBYCAMPUSES, $this->sortBy, $parameters);
	        $this->setPageCallBack( $pageCallBack );
	        
	        
	        $this->pageDisplay = new page_PeoplebyCampuses( $this->moduleRootPath, $this->viewer, $this->sortBy , $this->CAMPUS_ID);
	        if ($this->CAMPUS_ID == '')
	        {
		        $this->CAMPUS_ID = $this->pageDisplay->getCampusID();	// needed when page first initialized and jumplist not yet used
	        }
	        
	        $links = array();
	        
	/*[RAD_LINK_INSERT]*/
	
	        $parameters = array('PROVINCE_ID'=>$this->PROVINCE_ID, 'GENDER_ID'=>$this->GENDER_ID, 'STAFF_ID'=>$this->STAFF_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'ADMIN_ID'=>$this->ADMIN_ID, 'PRIV_ID'=>$this->PRIV_ID, 'CAMPUSADMIN_ID'=>$this->CAMPUSADMIN_ID, 'USER_ID'=>$this->USER_ID, 'ASSIGNMENT_ID'=>$this->ASSIGNMENT_ID);//[RAD_CALLBACK_PARAMS]
	        $sortByLink = $this->getCallBack( modulecim_hrdb::PAGE_PEOPLEBYCAMPUSES, '', $parameters );
	        $sortByLink .= "&".modulecim_hrdb::SORTBY."=";
	        $links["sortBy"] = $sortByLink;
	
	        $linksadd = $this->getCallBack( modulecim_hrdb::PAGE_NEWPERSON, "", $parameters );
	        $links["add"] = $linksadd;
	
	        $editLink = $this->getCallBack( modulecim_hrdb::PAGE_EDITPERSON, "", $parameters );
		$editLink .= "&" . modulecim_hrdb::PERSON_ID . "=";
		$links["edit"] = $editLink;
	
	        //Link to view Campuses the person is associated with.
	        $viewPersonLink = $this->getCallBack( modulecim_hrdb::PAGE_PERSONINFO, "", $parameters );
	        $viewPersonLink .= "&" . modulecim_hrdb::PERSON_ID . "=";
	        $links["viewmoreinfo"] = $viewPersonLink;
	
	        //Link to view Campuses the person is associated with.
	        $viewCampusLink = $this->getCallBack( modulecim_hrdb::PAGE_CAMPUSASSIGNMENTS, "", $parameters );
		$viewCampusLink .= "&" . modulecim_hrdb::PERSON_ID . "=";
	        $links["campuses"] = $viewCampusLink;
	
	        $delLink = $this->getCallBack( modulecim_hrdb::PAGE_DELETEPERSON, "", $parameters );
	        $delLink .= "&" . modulecim_hrdb::PERSON_ID . "=";
		$links["del"] = $delLink;
	
	        $jumpLink = $this->getCallBack( modulecim_hrdb::PAGE_PEOPLEBYCAMPUSES, $this->sortBy, '', '', '', '', '', '' );//[RAD_CALLBACK_PARAMS_EDIT]
	        $jumpLink .= "&". modulecim_hrdb::CAMPUS_ID . "=";
	        $links["jumpLink"] = $jumpLink;
	
	        $this->pageDisplay->setLinks( $links );
	        
	        $this->addScript('MM_jumpMenu.jsp');
        }
        else
        {
	        $this->pageDisplay = new page_NotAuthorized($this->moduleRootPath, $this->viewer);  
        }  
    } // end loadPeoplebyCampuses()
    
    
    
    
    //************************************************************************
	/**
	 * function EditStudentYearInSchool
	 * <pre>
	 * Initializes the EditStudentYearInSchool Page.
	 * </pre>
	 * @return [void]
	 */
    // RAD Tools: GridForm style
    function loadEditStudentYearInSchool() 
    {
        // GROUP 2: CAMPUS ADMINS AND ABOVE ONLY.
        if ( ( $this->accessPrivManager->hasSitePriv() ) || ( $this->accessPrivManager->hasCampusPriv($this->viewer->getID()) ) ){	    
	    	         
	        // set the pageCallBack to be without any additional parameters
	        // (an AdminBox needs this so Language Switching on a page doesn't
	        // pass a previous operations)
	        $parameters = array('PERSON_ID'=>$this->PERSON_ID, 'PROVINCE_ID'=>$this->PROVINCE_ID, 'GENDER_ID'=>$this->GENDER_ID, 'STAFF_ID'=>$this->STAFF_ID, 'REGION_ID'=>$this->REGION_ID, 'EMERG_ID'=>$this->EMERG_ID, 'ASSIGNSTATUS_ID'=>$this->ASSIGNSTATUS_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'ASSIGNMENT_ID'=>$this->ASSIGNMENT_ID, 'VIEWER_ID'=>$this->VIEWER_ID, 'ACCESS_ID'=>$this->ACCESS_ID, 'YEAR_ID'=>$this->YEAR_ID, 'PERSON_YEAR_ID'=>$this->PERSON_YEAR_ID);//[RAD_CALLBACK_PARAMS]
	        $pageCallBack = $this->getCallBack(modulecim_hrdb::PAGE_EDITSTUDENTYEARINSCHOOL, $this->sortBy, $parameters);
	        $this->setPageCallBack( $pageCallBack );
	        
	        
	        $parameters = array('PERSON_ID'=>$this->PERSON_ID, 'PROVINCE_ID'=>$this->PROVINCE_ID, 'GENDER_ID'=>$this->GENDER_ID, 'STAFF_ID'=>$this->STAFF_ID, 'REGION_ID'=>$this->REGION_ID, 'EMERG_ID'=>$this->EMERG_ID, 'ASSIGNSTATUS_ID'=>$this->ASSIGNSTATUS_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'ASSIGNMENT_ID'=>$this->ASSIGNMENT_ID, 'VIEWER_ID'=>$this->VIEWER_ID, 'ACCESS_ID'=>$this->ACCESS_ID, 'YEAR_ID'=>$this->YEAR_ID, 'PERSON_YEAR_ID'=>$this->PERSON_YEAR_ID);//[RAD_CALLBACK_PARAMS]
	        $formAction = $this->getCallBack(modulecim_hrdb::PAGE_EDITSTUDENTYEARINSCHOOL, $this->sortBy, $parameters );
	        $this->pageDisplay = new FormProcessor_EditStudentYearInSchool( $this->moduleRootPath, $this->viewer, $formAction, $this->PERSON_ID, $this->CAMPUS_ID, $this->PERSON_YEAR_ID );//[RAD_FORMINIT_FOREIGNKEY_INIT]        
	        
	        $links = array();
	        
	        
	/*[RAD_LINK_INSERT]*/        
	         
	        $jumpLink = $this->getCallBack( modulecim_hrdb::PAGE_EDITSTUDENTYEARINSCHOOL, $this->sortBy, '', '', '', '', '', '' );//[RAD_CALLBACK_PARAMS_EDIT]
	        $jumpLink .= "&". modulecim_hrdb::CAMPUS_ID . "=";
	        $links["jumpLink"] = $jumpLink;
	        
// 	        $this->DOWNLOAD_TYPE = modulecim_reg::DOWNLOAD_SCHOLARSHIP_DATA;

			  $this->DOWNLOAD_TYPE = modulecim_hrdb::DOWNLOAD_SENIORITY_LIST;
			  $this->CAMPUS_ID = $this->pageDisplay->getCampusID();		// retrieve campus id from the display page
	        $fileDownloadParameters = array('CAMPUS_ID'=>$this->CAMPUS_ID, 'DOWNLOAD_TYPE'=>$this->DOWNLOAD_TYPE);//[RAD_CALLBACK_PARAMS]              
	        $csvLink = $this->getCallBack( modulecim_hrdb::PAGE_DOWNLOADCSV, '', $fileDownloadParameters );
	        $links["DownloadSeniorityCSV"] = $csvLink;             //Campus Seniority List - for importing into Excel       
	
	        $this->pageDisplay->setLinks( $links );
	        
	        $this->addScript('MM_jumpMenu.jsp');        
        }
        else
        {
	        $this->pageDisplay = new page_NotAuthorized($this->moduleRootPath, $this->viewer);  
        }          
               
    } // end EditStudentYearInSchool()  
    
      
    //************************************************************************
	/**
	 * function ViewStudentYearInSchool
	 * <pre>
	 * Initializes the ViewStudentYearInSchool Page.
	 * </pre>
	 * @return [void]
	 */
    // RAD Tools: GridForm style
    function loadViewStudentYearInSchool() 
    {
        // GROUP 2: CAMPUS ADMINS AND ABOVE ONLY.
        if ( ( $this->accessPrivManager->hasSitePriv() ) || ( $this->accessPrivManager->hasCampusPriv($this->viewer->getID()) ) ){	    
	    
	      // echo "The personID is [".$this->PERSON_ID."]<br/>";
	         
	        // set the pageCallBack to be without any additional parameters
	        // (an AdminBox needs this so Language Switching on a page doesn't
	        // pass a previous operations)
	        $parameters = array('PERSON_ID'=>$this->PERSON_ID, 'PROVINCE_ID'=>$this->PROVINCE_ID, 'GENDER_ID'=>$this->GENDER_ID, 'STAFF_ID'=>$this->STAFF_ID, 'REGION_ID'=>$this->REGION_ID, 'EMERG_ID'=>$this->EMERG_ID, 'ASSIGNSTATUS_ID'=>$this->ASSIGNSTATUS_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'ASSIGNMENT_ID'=>$this->ASSIGNMENT_ID, 'VIEWER_ID'=>$this->VIEWER_ID, 'ACCESS_ID'=>$this->ACCESS_ID, 'YEAR_ID'=>$this->YEAR_ID, 'PERSON_YEAR_ID'=>$this->PERSON_YEAR_ID);//[RAD_CALLBACK_PARAMS]
	        $pageCallBack = $this->getCallBack(modulecim_hrdb::PAGE_VIEWSTUDENTYEARINSCHOOL, $this->sortBy, $parameters);
	        $this->setPageCallBack( $pageCallBack );
	                
	        $parameters = array('PERSON_ID'=>$this->PERSON_ID, 'PROVINCE_ID'=>$this->PROVINCE_ID, 'GENDER_ID'=>$this->GENDER_ID, 'STAFF_ID'=>$this->STAFF_ID, 'REGION_ID'=>$this->REGION_ID, 'EMERG_ID'=>$this->EMERG_ID, 'ASSIGNSTATUS_ID'=>$this->ASSIGNSTATUS_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'ASSIGNMENT_ID'=>$this->ASSIGNMENT_ID, 'VIEWER_ID'=>$this->VIEWER_ID, 'ACCESS_ID'=>$this->ACCESS_ID, 'YEAR_ID'=>$this->YEAR_ID, 'PERSON_YEAR_ID'=>$this->PERSON_YEAR_ID);//[RAD_CALLBACK_PARAMS]
	        $formAction = $this->getCallBack(modulecim_hrdb::PAGE_VIEWSTUDENTYEARINSCHOOL, $this->sortBy, $parameters );
	        $this->pageDisplay = new page_ViewStudentYearInSchool( $this->moduleRootPath, $this->viewer, $this->sortBy, $this->YEAR_ID, $this->CAMPUS_ID);	//, $this->PERSON_YEAR_ID );//[RAD_FORMINIT_FOREIGNKEY_INIT]        
	
	        $links = array();
	        
	/*[RAD_LINK_INSERT]*/        
	         
	        $jumpLink = $this->getCallBack( modulecim_hrdb::PAGE_VIEWSTUDENTYEARINSCHOOL, $this->sortBy, '', '', '', '', '', '' );//[RAD_CALLBACK_PARAMS_EDIT]
	        $jumpLink .= "&". modulecim_hrdb::YEAR_ID . "=";
	        $links["jumpLink"] = $jumpLink;
	
	        $this->pageDisplay->setLinks( $links );
	        
	        $this->addScript('MM_jumpMenu.jsp');        
        
        }
        else
        {
	        $this->pageDisplay = new page_NotAuthorized($this->moduleRootPath, $this->viewer);  
        }  
        
                       
    } // end ViewStudentYearInSchool()     
    
    
    
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
    function loadDownloadCSV( $isCreated=false ) 
    {	
	    // get privileges for the current viewer
        // GROUP 2: CAMPUS ADMINS AND ABOVE ONLY.
        if ( ( $this->accessPrivManager->hasSitePriv() ) || ( $this->accessPrivManager->hasCampusPriv($this->viewer->getID()) ) ){	    
	  	    
	       $fileName = '';
		    switch ($this->DOWNLOAD_TYPE) {
			    case modulecim_hrdb::DOWNLOAD_ACTIVITIES_LIST:
			    	$fileName = modulecim_hrdb::ACTIVITIES_DATA_FILE_NAME;
			    	break;
			    case modulecim_hrdb::DOWNLOAD_SENIORITY_LIST:
			    	$fileName = modulecim_hrdb::SENIORITY_DATA_FILE_NAME;
			    	break;			
			    case modulecim_hrdb::DOWNLOAD_CUSTOM_REPORT:
			    	$fileName = modulecim_hrdb::CUSTOMREPORT_DATA_FILE_NAME;
			    	break;				    	    
			    default:
		    }	   
	           
	        // set the pageCallBack to be without any additional parameters
	        // (an AdminBox needs this so Language Switching on a page doesn't
	        // pass a previous operations)
	        $parameters = array('PERSON_ID'=>$this->PERSON_ID, 'PROVINCE_ID'=>$this->PROVINCE_ID, 'GENDER_ID'=>$this->GENDER_ID, 'STAFF_ID'=>$this->STAFF_ID, 'REGION_ID'=>$this->REGION_ID, 'EMERG_ID'=>$this->EMERG_ID, 'ASSIGNSTATUS_ID'=>$this->ASSIGNSTATUS_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'ASSIGNMENT_ID'=>$this->ASSIGNMENT_ID, 'VIEWER_ID'=>$this->VIEWER_ID, 'ACCESS_ID'=>$this->ACCESS_ID, 'YEAR_ID'=>$this->YEAR_ID, 'PERSON_YEAR_ID'=>$this->PERSON_YEAR_ID, 'REPORT_ID'=>$this->REPORT_ID);//[RAD_CALLBACK_PARAMS]
	        $pageCallBack = $this->getCallBack(modulecim_hrdb::PAGE_DOWNLOADCSV, $this->sortBy, $parameters);
	        $this->setPageCallBack( $pageCallBack );        
	        	        
	        $links = array();
    
	        	//$this->getCallBack( modulecim_reg::PAGE_EDITCAMPUSASSIGNMENT, '', $parameters );
	// 		  $link1 = SITE_PATH_MODULES.'app_'.modulecim_reg::MODULE_KEY.'/objects_pages/'.modulecim_reg::CSV_DOWNLOAD_TOOL.'?'.modulecim_reg::EVENT_ID.'='.$this->EVENT_ID.'&'.modulecim_reg::DOWNLOAD_TYPE.'='.modulecim_reg::DOWNLOAD_EVENT_DATA;	//$this->getCallBack( modulecim_reg::PAGE_ADMINEVENTHOME, '', $fileDownloadParameters );
			  $file_name1 = rand(1,MAX_TEMP_SEED).$fileName;		//modulecim_hrdb::SENIORITY_DATA_FILE_NAME;
	//        $link1 .= "&".modulecim_reg::SORTBY."=";
// 			  $file_name2 = rand(1,MAX_TEMP_SEED).modulecim_reg::EVENT_SCHOLARSHIP_FILE_NAME;
// 			  $link2 = SITE_PATH_REPORTS.$file_name2;
			  
			  $file_names = $file_name1;		//.','.$file_name2;
			  $campusStatusFilter = '0,1,6';	//'<Undefined>, Current Student, Unknown Status';
			  
// 			  $this->DOWNLOAD_TYPE = modulecim_hrdb::DOWNLOAD_SENIORITY_LIST;
			  
			  // NOTE: file names *MUST* be set first, otherwise file cannot be downloaded by user
	        $this->pageDisplay = new page_DownloadCSV( $this->moduleRootPath, $this->viewer, $this->DOWNLOAD_TYPE, $this->CAMPUS_ID, $campusStatusFilter, $file_names, $this->REPORT_ID );    		  

	        $returnedFileName = $this->pageDisplay->getLastFileName();
	        if ($returnedFileName != '')
	        {
	        		$link1 = SITE_PATH_REPORTS.$returnedFileName;
        	  }
        	  else
        	  {
	        		$link1 = SITE_PATH_REPORTS.$file_name1;
        	  }	 
        	         	        
	/*[RAD_LINK_INSERT]*/
	       $fileName = '';
		    switch ($this->DOWNLOAD_TYPE) {
			    case modulecim_hrdb::DOWNLOAD_ACTIVITIES_LIST:
			    	$links[ "DownloadActivitiesDataDump" ] = $link1;
			    	break;
			    case modulecim_hrdb::DOWNLOAD_SENIORITY_LIST:
			    	$links[ "DownloadSeniorityDataDump" ] = $link1;
			    	break;	
			    case modulecim_hrdb::DOWNLOAD_CUSTOM_REPORT:		
			    	$links[ "DownloadCustomReportDataDump" ] = $link1;
			    	break;				    	    			    
			    default:
		    }			     
	  
// 	        $parameters = array('PERSON_ID'=>$this->PERSON_ID, 'PROVINCE_ID'=>$this->PROVINCE_ID, 'GENDER_ID'=>$this->GENDER_ID, 'STAFF_ID'=>$this->STAFF_ID, 'REGION_ID'=>$this->REGION_ID, 'EMERG_ID'=>$this->EMERG_ID, 'ASSIGNSTATUS_ID'=>$this->ASSIGNSTATUS_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'ASSIGNMENT_ID'=>$this->ASSIGNMENT_ID, 'VIEWER_ID'=>$this->VIEWER_ID, 'ACCESS_ID'=>$this->ACCESS_ID, 'YEAR_ID'=>$this->YEAR_ID, 'PERSON_YEAR_ID'=>$this->PERSON_YEAR_ID);//[RAD_CALLBACK_PARAMS]
// 	        $continueLink = $this->getCallBack( modulecim_reg::PAGE_HRDBHOME, "", $parameters );
// 	        $links["cont"] = $continueLink;		  

	        $this->pageDisplay->setLinks( $links ); 
        }
        else
        {
	        $this->pageDisplay = new page_NotAuthorized($this->moduleRootPath, $this->viewer);  
        }        
    }	  


    //************************************************************************
	/**
	 * function loadAdminPrivs
	 * <pre>
	 * Initializes the AdminPrivs Page.
	 * </pre>
	 * @param $isCreated [BOOL] "Is THIS pageDisplay object already created?"
	 * @return [void]
	 */
    // RAD Tools: AdminBox Style
    function loadAdminPrivs( $isCreated=false ) 
    {
        // GROUP 3: SUPER ADMINS ONLY.
        if ( $this->accessPrivManager->hasSitePriv()){
	                
	        // compile a formAction for the adminBox
	        $parameters = array('PERSON_ID'=>$this->PERSON_ID, 'PROVINCE_ID'=>$this->PROVINCE_ID, 'GENDER_ID'=>$this->GENDER_ID, 'STAFF_ID'=>$this->STAFF_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'ADMIN_ID'=>$this->ADMIN_ID, 'PRIV_ID'=>$this->PRIV_ID, 'CAMPUSADMIN_ID'=>$this->CAMPUSADMIN_ID, 'USER_ID'=>$this->USER_ID, 'ASSIGNMENT_ID'=>$this->ASSIGNMENT_ID);//[RAD_CALLBACK_PARAMS]
	        $formAction = $this->getCallBack(modulecim_hrdb::PAGE_ADMINPRIVS, $this->sortBy, $parameters );
	        
	        // set the pageCallBack value.  This is used by the Language switching
	        // code
	        $this->setPageCallBack( $formAction );
	        
	        // if this pageDisplay object isn't already created then 
	        if ( !$isCreated ) {
	        
	            // create a new pageDisplay object
	            $this->pageDisplay = new FormProcessor_AdminPrivs( $this->moduleRootPath, $this->viewer, $formAction, $this->sortBy,  $this->ADMIN_ID );//[RAD_FORMINIT_FOREIGNKEY_INIT]    
	        
	        } else {
	        
	            // otherwise just update the formAction value
	            $this->pageDisplay->setFormAction( $formAction );
	        }
	        
	        $links = array();
	        
	        $parameters = array( );//[RAD_CALLBACK_PARAMS_EDIT]
	        $editLink = $this->getCallBack( modulecim_hrdb::PAGE_ADMINPRIVS, $this->sortBy, $parameters );
	        $editLink .= "&". modulecim_hrdb::ADMIN_ID . "=";
	        $links[ "edit" ] = $editLink;
	        
	        // NOTE: delete link is same as edit link for an AdminBox
	        $links[ "del" ] = $editLink;
	
	/*[RAD_LINK_INSERT]*/
	
	        $parameters = array('PERSON_ID'=>$this->PERSON_ID, 'PROVINCE_ID'=>$this->PROVINCE_ID, 'GENDER_ID'=>$this->GENDER_ID, 'STAFF_ID'=>$this->STAFF_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'ADMIN_ID'=>$this->ADMIN_ID, 'PRIV_ID'=>$this->PRIV_ID, 'CAMPUSADMIN_ID'=>$this->CAMPUSADMIN_ID, 'USER_ID'=>$this->USER_ID, 'ASSIGNMENT_ID'=>$this->ASSIGNMENT_ID);//[RAD_CALLBACK_PARAMS]
	        $sortByLink = $this->getCallBack( modulecim_hrdb::PAGE_ADMINPRIVS, '', $parameters );
	        $sortByLink .= "&".modulecim_hrdb::SORTBY."=";
	        $links["sortBy"] = $sortByLink;
	
	        $this->pageDisplay->setLinks( $links );    
        }
        else
        {
	        $this->pageDisplay = new page_NotAuthorized($this->moduleRootPath, $this->viewer);  
        }          
    } // end loadAdminPrivs()



    //************************************************************************
	/**
	 * function loadNewAccount
	 * <pre>
	 * Initializes the NewAccount Page.
	 * </pre>
	 * @return [void]
	 */
    // RAD Tools: FormSingleEntry style
    function loadNewAccount() 
    {
        // GROUP 3: SUPER ADMINS ONLY.
        if ( $this->accessPrivManager->hasSitePriv()){	    
	    
	        // set the pageCallBack to be without any additional parameters
	        // (an AdminBox needs this so Language Switching on a page doesn't
	        // pass a previous operations)
	        $parameters = array('PERSON_ID'=>$this->PERSON_ID, 'PROVINCE_ID'=>$this->PROVINCE_ID, 'GENDER_ID'=>$this->GENDER_ID, 'STAFF_ID'=>$this->STAFF_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'ADMIN_ID'=>$this->ADMIN_ID, 'PRIV_ID'=>$this->PRIV_ID, 'CAMPUSADMIN_ID'=>$this->CAMPUSADMIN_ID, 'USER_ID'=>$this->USER_ID, 'ASSIGNMENT_ID'=>$this->ASSIGNMENT_ID);//[RAD_CALLBACK_PARAMS]
	        $pageCallBack = $this->getCallBack(modulecim_hrdb::PAGE_NEWACCOUNT, $this->sortBy, $parameters);
	        $this->setPageCallBack( $pageCallBack );
	        
	        
	        $parameters = array('PERSON_ID'=>$this->PERSON_ID, 'PROVINCE_ID'=>$this->PROVINCE_ID, 'GENDER_ID'=>$this->GENDER_ID, 'STAFF_ID'=>$this->STAFF_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'ADMIN_ID'=>$this->ADMIN_ID, 'PRIV_ID'=>$this->PRIV_ID, 'CAMPUSADMIN_ID'=>$this->CAMPUSADMIN_ID, 'USER_ID'=>$this->USER_ID, 'ASSIGNMENT_ID'=>$this->ASSIGNMENT_ID);//[RAD_CALLBACK_PARAMS]
	        $formAction = $this->getCallBack(modulecim_hrdb::PAGE_NEWACCOUNT, $this->sortBy, $parameters );
	        $this->pageDisplay = new FormProcessor_NewAccount( $this->moduleRootPath, $this->viewer, $formAction, $this->PERSON_ID );//[RAD_FORMINIT_FOREIGNKEY_INIT]        
         }
        else
        {
	        $this->pageDisplay = new page_NotAuthorized($this->moduleRootPath, $this->viewer);  
        }         
    } // end loadNewAccount()



    //************************************************************************
	/**
	 * function loadEditMyEmergInfo
	 * <pre>
	 * Initializes the EditMyEmergInfo Page.
	 * </pre>
	 * @return [void]
	 */
    // RAD Tools: FormSingleEntry style
    function loadEditMyEmergInfo() 
    {
        // set the pageCallBack to be without any additional parameters
        // (an AdminBox needs this so Language Switching on a page doesn't
        // pass a previous operations)
        $parameters = array('PERSON_ID'=>$this->PERSON_ID, 'PROVINCE_ID'=>$this->PROVINCE_ID, 'GENDER_ID'=>$this->GENDER_ID, 'STAFF_ID'=>$this->STAFF_ID, 'REGION_ID'=>$this->REGION_ID, 'EMERG_ID'=>$this->EMERG_ID);//[RAD_CALLBACK_PARAMS]
        $pageCallBack = $this->getCallBack(modulecim_hrdb::PAGE_EDITMYEMERGINFO, $this->sortBy, $parameters);
        $this->setPageCallBack( $pageCallBack );
        
        
        $parameters = array('PERSON_ID'=>$this->PERSON_ID, 'PROVINCE_ID'=>$this->PROVINCE_ID, 'GENDER_ID'=>$this->GENDER_ID, 'STAFF_ID'=>$this->STAFF_ID, 'REGION_ID'=>$this->REGION_ID, 'EMERG_ID'=>$this->EMERG_ID);//[RAD_CALLBACK_PARAMS]
        $formAction = $this->getCallBack(modulecim_hrdb::PAGE_EDITMYEMERGINFO, $this->sortBy, $parameters );
        $this->pageDisplay = new FormProcessor_EditMyEmergInfo( $this->moduleRootPath, $this->viewer, $formAction, $this->EMERG_ID , $this->PERSON_ID);//[RAD_FORMINIT_FOREIGNKEY_INIT]        
        
    } // end loadEditMyEmergInfo()



    //************************************************************************
	/**
	 * function loadEditCampusAssignmentStatusTypes
	 * <pre>
	 * Initializes the EditCampusAssignmentStatusTypes Page.
	 * </pre>
	 * @param $isCreated [BOOL] "Is THIS pageDisplay object already created?"
	 * @return [void]
	 */
    // RAD Tools: AdminBox Style
    function loadEditCampusAssignmentStatusTypes( $isCreated=false ) 
    {
        // GROUP 3: SUPER ADMINS ONLY.
        if ( $this->accessPrivManager->hasSitePriv()){
	                
	        // compile a formAction for the adminBox
	        $parameters = array('PERSON_ID'=>$this->PERSON_ID, 'PROVINCE_ID'=>$this->PROVINCE_ID, 'GENDER_ID'=>$this->GENDER_ID, 'STAFF_ID'=>$this->STAFF_ID, 'REGION_ID'=>$this->REGION_ID, 'EMERG_ID'=>$this->EMERG_ID, 'ASSIGNSTATUS_ID'=>$this->ASSIGNSTATUS_ID);//[RAD_CALLBACK_PARAMS]
	        $formAction = $this->getCallBack(modulecim_hrdb::PAGE_EDITCAMPUSASSIGNMENTSTATUSTYPES, $this->sortBy, $parameters );
	        
	        // set the pageCallBack value.  This is used by the Language switching
	        // code
	        $this->setPageCallBack( $formAction );
	        
	        // if this pageDisplay object isn't already created then 
	        if ( !$isCreated ) {
	        
	            // create a new pageDisplay object
	            $this->pageDisplay = new FormProcessor_EditCampusAssignmentStatusTypes( $this->moduleRootPath, $this->viewer, $formAction, $this->sortBy,  $this->ASSIGNSTATUS_ID, $this->ASSIGNSTATUS_ID );//[RAD_FORMINIT_FOREIGNKEY_INIT]    
	        
	        } else {
	        
	            // otherwise just update the formAction value
	            $this->pageDisplay->setFormAction( $formAction );
	        }
	        
	        $links = array();
	        
	        $parameters = array( );//[RAD_CALLBACK_PARAMS_EDIT]
	        $editLink = $this->getCallBack( modulecim_hrdb::PAGE_EDITCAMPUSASSIGNMENTSTATUSTYPES, $this->sortBy, $parameters );
	        $editLink .= "&". modulecim_hrdb::ASSIGNSTATUS_ID . "=";
	        $links[ "edit" ] = $editLink;
	        
	        // NOTE: delete link is same as edit link for an AdminBox
	        $links[ "del" ] = $editLink;
	
	/*[RAD_LINK_INSERT]*/
	
	        $parameters = array('PERSON_ID'=>$this->PERSON_ID, 'PROVINCE_ID'=>$this->PROVINCE_ID, 'GENDER_ID'=>$this->GENDER_ID, 'STAFF_ID'=>$this->STAFF_ID, 'REGION_ID'=>$this->REGION_ID, 'EMERG_ID'=>$this->EMERG_ID, 'ASSIGNSTATUS_ID'=>$this->ASSIGNSTATUS_ID);//[RAD_CALLBACK_PARAMS]
	        $sortByLink = $this->getCallBack( modulecim_hrdb::PAGE_EDITCAMPUSASSIGNMENTSTATUSTYPES, '', $parameters );
	        $sortByLink .= "&".modulecim_hrdb::SORTBY."=";
	        $links["sortBy"] = $sortByLink;
	
	        $this->pageDisplay->setLinks( $links );    
        }
        else
        {
	        $this->pageDisplay = new page_NotAuthorized($this->moduleRootPath, $this->viewer);  
        } 	        
        
    } // end loadEditCampusAssignmentStatusTypes()



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
        // GROUP 3: SUPER ADMINS ONLY.
        if ( $this->accessPrivManager->hasSitePriv()){
	                
	        // compile a formAction for the adminBox
	        $parameters = array('PERSON_ID'=>$this->PERSON_ID, 'PROVINCE_ID'=>$this->PROVINCE_ID, 'GENDER_ID'=>$this->GENDER_ID, 'STAFF_ID'=>$this->STAFF_ID, 'REGION_ID'=>$this->REGION_ID, 'EMERG_ID'=>$this->EMERG_ID, 'ASSIGNSTATUS_ID'=>$this->ASSIGNSTATUS_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'ASSIGNMENT_ID'=>$this->ASSIGNMENT_ID);//[RAD_CALLBACK_PARAMS]
	        $formAction = $this->getCallBack(modulecim_hrdb::PAGE_EDITCAMPUSASSIGNMENT, $this->sortBy, $parameters );
	        
	        // set the pageCallBack value.  This is used by the Language switching
	        // code
	        $this->setPageCallBack( $formAction );
	        
	        // if this pageDisplay object isn't already created then 
	        if ( !$isCreated ) {
	        
	            // create a new pageDisplay object
	            $this->pageDisplay = new FormProcessor_EditCampusAssignment( $this->moduleRootPath, $this->viewer, $formAction, $this->sortBy,  $this->ASSIGNMENT_ID);	//, $this->PERSON_ID, $this->CAMPUS_ID, $this->ASSIGNSTATUS_ID);	// , $this->ASSIGNSTATUS_ID);//[RAD_FORMINIT_FOREIGNKEY_INIT]    
	        
	        } else {
	        
	            // otherwise just update the formAction value
	            $this->pageDisplay->setFormAction( $formAction );
	        }
	        
	        $links = array();
	        
	        $parameters = array( );//[RAD_CALLBACK_PARAMS_EDIT]
	        $editLink = $this->getCallBack( modulecim_hrdb::PAGE_EDITCAMPUSASSIGNMENT, $this->sortBy, $parameters );
	        $editLink .= "&". modulecim_hrdb::ASSIGNMENT_ID . "=";
	        $links[ "edit" ] = $editLink;
	        
	        // NOTE: delete link is same as edit link for an AdminBox
	        $links[ "del" ] = $editLink;
	
	/*[RAD_LINK_INSERT]*/
	
	        $parameters = array('PERSON_ID'=>$this->PERSON_ID, 'PROVINCE_ID'=>$this->PROVINCE_ID, 'GENDER_ID'=>$this->GENDER_ID, 'STAFF_ID'=>$this->STAFF_ID, 'REGION_ID'=>$this->REGION_ID, 'EMERG_ID'=>$this->EMERG_ID, 'ASSIGNSTATUS_ID'=>$this->ASSIGNSTATUS_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'ASSIGNMENT_ID'=>$this->ASSIGNMENT_ID);//[RAD_CALLBACK_PARAMS]
	        $sortByLink = $this->getCallBack( modulecim_hrdb::PAGE_EDITCAMPUSASSIGNMENT, '', $parameters );
	        $sortByLink .= "&".modulecim_hrdb::SORTBY."=";
	        $links["sortBy"] = $sortByLink;
	
	        $this->pageDisplay->setLinks( $links );    
        }
        else
        {
	        $this->pageDisplay = new page_NotAuthorized($this->moduleRootPath, $this->viewer);  
        }          
	        
    } // end loadEditCampusAssignment()



    //************************************************************************
	/**
	 * function loadEditRegion
	 * <pre>
	 * Initializes the EditRegion Page.
	 * </pre>
	 * @param $isCreated [BOOL] "Is THIS pageDisplay object already created?"
	 * @return [void]
	 */
    // RAD Tools: AdminBox Style
    function loadEditRegion( $isCreated=false ) 
    {
        // GROUP 3: SUPER ADMINS ONLY.
        if ( $this->accessPrivManager->hasSitePriv()){
		                
	        // compile a formAction for the adminBox
	        $parameters = array('PERSON_ID'=>$this->PERSON_ID, 'PROVINCE_ID'=>$this->PROVINCE_ID, 'GENDER_ID'=>$this->GENDER_ID, 'STAFF_ID'=>$this->STAFF_ID, 'REGION_ID'=>$this->REGION_ID, 'EMERG_ID'=>$this->EMERG_ID, 'ASSIGNSTATUS_ID'=>$this->ASSIGNSTATUS_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'ASSIGNMENT_ID'=>$this->ASSIGNMENT_ID);//[RAD_CALLBACK_PARAMS]
	        $formAction = $this->getCallBack(modulecim_hrdb::PAGE_EDITREGION, $this->sortBy, $parameters );
	        
	        // set the pageCallBack value.  This is used by the Language switching
	        // code
	        $this->setPageCallBack( $formAction );
	        
	        // if this pageDisplay object isn't already created then 
	        if ( !$isCreated ) {
	        
	            // create a new pageDisplay object
	            $this->pageDisplay = new FormProcessor_EditRegion( $this->moduleRootPath, $this->viewer, $formAction, $this->sortBy,  $this->REGION_ID );//[RAD_FORMINIT_FOREIGNKEY_INIT]    
	        
	        } else {
	        
	            // otherwise just update the formAction value
	            $this->pageDisplay->setFormAction( $formAction );
	        }
	        
	        $links = array();
	        
	        $parameters = array( );//[RAD_CALLBACK_PARAMS_EDIT]
	        $editLink = $this->getCallBack( modulecim_hrdb::PAGE_EDITREGION, $this->sortBy, $parameters );
	        $editLink .= "&". modulecim_hrdb::REGION_ID . "=";
	        $links[ "edit" ] = $editLink;
	        
	        // NOTE: delete link is same as edit link for an AdminBox
	        $links[ "del" ] = $editLink;
	
	/*[RAD_LINK_INSERT]*/
	
	        $parameters = array('PERSON_ID'=>$this->PERSON_ID, 'PROVINCE_ID'=>$this->PROVINCE_ID, 'GENDER_ID'=>$this->GENDER_ID, 'STAFF_ID'=>$this->STAFF_ID, 'REGION_ID'=>$this->REGION_ID, 'EMERG_ID'=>$this->EMERG_ID, 'ASSIGNSTATUS_ID'=>$this->ASSIGNSTATUS_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'ASSIGNMENT_ID'=>$this->ASSIGNMENT_ID);//[RAD_CALLBACK_PARAMS]
	        $sortByLink = $this->getCallBack( modulecim_hrdb::PAGE_EDITREGION, '', $parameters );
	        $sortByLink .= "&".modulecim_hrdb::SORTBY."=";
	        $links["sortBy"] = $sortByLink;
	
	        $this->pageDisplay->setLinks( $links );  
        }
        else
        {
	        $this->pageDisplay = new page_NotAuthorized($this->moduleRootPath, $this->viewer);  
        }  	          
        
    } // end loadEditRegion()



    //************************************************************************
	/**
	 * function loadEditPeople
	 * <pre>
	 * Initializes the EditPeople Page.
	 * </pre>
	 * @param $isCreated [BOOL] "Is THIS pageDisplay object already created?"
	 * @return [void]
	 */
    // RAD Tools: AdminBox Style
    function loadEditPeople( $isCreated=false ) 
    {
        // GROUP 3: SUPER ADMINS ONLY.
        if ( $this->accessPrivManager->hasSitePriv()){
	                
	        // compile a formAction for the adminBox
	        $parameters = array('PERSON_ID'=>$this->PERSON_ID, 'PROVINCE_ID'=>$this->PROVINCE_ID, 'GENDER_ID'=>$this->GENDER_ID, 'STAFF_ID'=>$this->STAFF_ID, 'REGION_ID'=>$this->REGION_ID, 'EMERG_ID'=>$this->EMERG_ID, 'ASSIGNSTATUS_ID'=>$this->ASSIGNSTATUS_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'ASSIGNMENT_ID'=>$this->ASSIGNMENT_ID);//[RAD_CALLBACK_PARAMS]
	        $formAction = $this->getCallBack(modulecim_hrdb::PAGE_EDITPEOPLE, $this->sortBy, $parameters );
	        
	        // set the pageCallBack value.  This is used by the Language switching
	        // code
	        $this->setPageCallBack( $formAction );
	        
	        // if this pageDisplay object isn't already created then 
	        if ( !$isCreated ) {
	        
	            // create a new pageDisplay object
	            $this->pageDisplay = new FormProcessor_EditPeople( $this->moduleRootPath, $this->viewer, $formAction, $this->sortBy,  $this->PERSON_ID );//[RAD_FORMINIT_FOREIGNKEY_INIT]    
	        
	        } else {
	        
	            // otherwise just update the formAction value
	            $this->pageDisplay->setFormAction( $formAction );
	        }
	        
	        $links = array();
	        
	        $parameters = array( );//[RAD_CALLBACK_PARAMS_EDIT]
	        $editLink = $this->getCallBack( modulecim_hrdb::PAGE_EDITPEOPLE, $this->sortBy, $parameters );
	        $editLink .= "&". modulecim_hrdb::PERSON_ID . "=";
	        $links[ "edit" ] = $editLink;
	        
	        // NOTE: delete link is same as edit link for an AdminBox
	        $links[ "del" ] = $editLink;
	
	/*[RAD_LINK_INSERT]*/
	
	        $parameters = array('PERSON_ID'=>$this->PERSON_ID, 'PROVINCE_ID'=>$this->PROVINCE_ID, 'GENDER_ID'=>$this->GENDER_ID, 'STAFF_ID'=>$this->STAFF_ID, 'REGION_ID'=>$this->REGION_ID, 'EMERG_ID'=>$this->EMERG_ID, 'ASSIGNSTATUS_ID'=>$this->ASSIGNSTATUS_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'ASSIGNMENT_ID'=>$this->ASSIGNMENT_ID);//[RAD_CALLBACK_PARAMS]
	        $sortByLink = $this->getCallBack( modulecim_hrdb::PAGE_EDITPEOPLE, '', $parameters );
	        $sortByLink .= "&".modulecim_hrdb::SORTBY."=";
	        $links["sortBy"] = $sortByLink;
	
	        $this->pageDisplay->setLinks( $links );    
	        
        }
        else
        {
	        $this->pageDisplay = new page_NotAuthorized($this->moduleRootPath, $this->viewer);  
        }  	        
        
    } // end loadEditPeople()



    //************************************************************************
	/**
	 * function loadEditAccessAssignment
	 * <pre>
	 * Initializes the EditAccessAssignment Page.
	 * </pre>
	 * @param $isCreated [BOOL] "Is THIS pageDisplay object already created?"
	 * @return [void]
	 */
    // RAD Tools: AdminBox Style
    function loadEditAccessAssignment( $isCreated=false ) 
    {

        // GROUP 3: SUPER ADMINS ONLY.
        if ( $this->accessPrivManager->hasSitePriv()){
	        
	                // compile a formAction for the adminBox
	        $parameters = array('PERSON_ID'=>$this->PERSON_ID, 'PROVINCE_ID'=>$this->PROVINCE_ID, 'GENDER_ID'=>$this->GENDER_ID, 'STAFF_ID'=>$this->STAFF_ID, 'REGION_ID'=>$this->REGION_ID, 'EMERG_ID'=>$this->EMERG_ID, 'ASSIGNSTATUS_ID'=>$this->ASSIGNSTATUS_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'ASSIGNMENT_ID'=>$this->ASSIGNMENT_ID, 'VIEWER_ID'=>$this->VIEWER_ID, 'ACCESS_ID'=>$this->ACCESS_ID);//[RAD_CALLBACK_PARAMS]
	        $formAction = $this->getCallBack(modulecim_hrdb::PAGE_EDITACCESSASSIGNMENT, $this->sortBy, $parameters );
	        
	        // set the pageCallBack value.  This is used by the Language switching
	        // code
	        $this->setPageCallBack( $formAction );
	        
	        // if this pageDisplay object isn't already created then 
	        if ( !$isCreated ) {
	        
	            // create a new pageDisplay object
	            $this->pageDisplay = new FormProcessor_EditAccessAssignment( $this->moduleRootPath, $this->viewer, $formAction, $this->sortBy,  $this->ACCESS_ID, $this->ACCESS_ID , $this->PERSON_ID);//[RAD_FORMINIT_FOREIGNKEY_INIT]    
	        
	        } else {
	        
	            // otherwise just update the formAction value
	            $this->pageDisplay->setFormAction( $formAction );
	        }
	        
	        $links = array();
	        
	        $parameters = array( );//[RAD_CALLBACK_PARAMS_EDIT]
	        $editLink = $this->getCallBack( modulecim_hrdb::PAGE_EDITACCESSASSIGNMENT, $this->sortBy, $parameters );
	        $editLink .= "&". modulecim_hrdb::ACCESS_ID . "=";
	        $links[ "edit" ] = $editLink;
	        
	        // NOTE: delete link is same as edit link for an AdminBox
	        $links[ "del" ] = $editLink;
	
	/*[RAD_LINK_INSERT]*/
	
	        $parameters = array('PERSON_ID'=>$this->PERSON_ID, 'PROVINCE_ID'=>$this->PROVINCE_ID, 'GENDER_ID'=>$this->GENDER_ID, 'STAFF_ID'=>$this->STAFF_ID, 'REGION_ID'=>$this->REGION_ID, 'EMERG_ID'=>$this->EMERG_ID, 'ASSIGNSTATUS_ID'=>$this->ASSIGNSTATUS_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'ASSIGNMENT_ID'=>$this->ASSIGNMENT_ID, 'VIEWER_ID'=>$this->VIEWER_ID, 'ACCESS_ID'=>$this->ACCESS_ID);//[RAD_CALLBACK_PARAMS]
	        $sortByLink = $this->getCallBack( modulecim_hrdb::PAGE_EDITACCESSASSIGNMENT, '', $parameters );
	        $sortByLink .= "&".modulecim_hrdb::SORTBY."=";
	        $links["sortBy"] = $sortByLink;
	
	        $this->pageDisplay->setLinks( $links );    

        }
        else
        {
	        $this->pageDisplay = new page_NotAuthorized($this->moduleRootPath, $this->viewer);  
        }  	        
        
    } // end loadEditAccessAssignment()



    //************************************************************************
	/**
	 * function loadEditMyCampusAssignment
	 * <pre>
	 * Initializes the EditMyCampusAssignment Page.
	 * </pre>
	 * @param $isCreated [BOOL] "Is THIS pageDisplay object already created?"
	 * @return [void]
	 */
    // RAD Tools: AdminBox Style
    function loadEditMyCampusAssignment( $isCreated=false ) 
    {
    
         // echo "The personID is [".$this->PERSON_ID."]<br/>";
        
        // compile a formAction for the adminBox
        $parameters = array('PERSON_ID'=>$this->PERSON_ID, 'PROVINCE_ID'=>$this->PROVINCE_ID, 'GENDER_ID'=>$this->GENDER_ID, 'STAFF_ID'=>$this->STAFF_ID, 'REGION_ID'=>$this->REGION_ID, 'EMERG_ID'=>$this->EMERG_ID, 'ASSIGNSTATUS_ID'=>$this->ASSIGNSTATUS_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'ASSIGNMENT_ID'=>$this->ASSIGNMENT_ID, 'VIEWER_ID'=>$this->VIEWER_ID, 'ACCESS_ID'=>$this->ACCESS_ID);//[RAD_CALLBACK_PARAMS]
        $formAction = $this->getCallBack(modulecim_hrdb::PAGE_EDITMYCAMPUSASSIGNMENT, $this->sortBy, $parameters );
        
        // set the pageCallBack value.  This is used by the Language switching
        // code
        $this->setPageCallBack( $formAction );
        
        // if this pageDisplay object isn't already created then 
        if ( !$isCreated ) {
        
            // create a new pageDisplay object
            $this->pageDisplay = new FormProcessor_EditMyCampusAssignment( $this->moduleRootPath, $this->viewer, $formAction, $this->sortBy, $this->PERSON_ID, $this->ASSIGNMENT_ID);//[RAD_FORMINIT_FOREIGNKEY_INIT]    
        
        } else {
        
            // otherwise just update the formAction value
            $this->pageDisplay->setFormAction( $formAction );
        }
        
        $links = array();
        
        $parameters = array( 'PERSON_ID'=>$this->PERSON_ID  );//[RAD_CALLBACK_PARAMS_EDIT]
        $editLink = $this->getCallBack( modulecim_hrdb::PAGE_EDITMYCAMPUSASSIGNMENT, $this->sortBy, $parameters );
        $editLink .= "&". modulecim_hrdb::ASSIGNMENT_ID . "=";
        $links[ "edit" ] = $editLink;
        
        // NOTE: delete link is same as edit link for an AdminBox
        $links[ "del" ] = $editLink;

/*[RAD_LINK_INSERT]*/

        $parameters = array('PERSON_ID'=>$this->PERSON_ID, 'PROVINCE_ID'=>$this->PROVINCE_ID, 'GENDER_ID'=>$this->GENDER_ID, 'STAFF_ID'=>$this->STAFF_ID, 'REGION_ID'=>$this->REGION_ID, 'EMERG_ID'=>$this->EMERG_ID, 'ASSIGNSTATUS_ID'=>$this->ASSIGNSTATUS_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'ASSIGNMENT_ID'=>$this->ASSIGNMENT_ID, 'VIEWER_ID'=>$this->VIEWER_ID, 'ACCESS_ID'=>$this->ACCESS_ID);//[RAD_CALLBACK_PARAMS]
        $sortByLink = $this->getCallBack( modulecim_hrdb::PAGE_EDITMYCAMPUSASSIGNMENT, '', $parameters );
        $sortByLink .= "&".modulecim_hrdb::SORTBY."=";
        $links["sortBy"] = $sortByLink;

        $this->pageDisplay->setLinks( $links );    
        
    } // end loadEditMyCampusAssignment()
    



    //************************************************************************
	/**
	 * function loadEditMyYearInSchool
	 * <pre>
	 * Initializes the EditMyYearInSchool Page.
	 * </pre>
	 * @return [void]
	 */
    // RAD Tools: FormSingleEntry style
    function loadEditMyYearInSchool() 
    {
      // echo "The personID is [".$this->PERSON_ID."]<br/>";
         
        // set the pageCallBack to be without any additional parameters
        // (an AdminBox needs this so Language Switching on a page doesn't
        // pass a previous operations)
        $parameters = array('PERSON_ID'=>$this->PERSON_ID, 'PROVINCE_ID'=>$this->PROVINCE_ID, 'GENDER_ID'=>$this->GENDER_ID, 'STAFF_ID'=>$this->STAFF_ID, 'REGION_ID'=>$this->REGION_ID, 'EMERG_ID'=>$this->EMERG_ID, 'ASSIGNSTATUS_ID'=>$this->ASSIGNSTATUS_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'ASSIGNMENT_ID'=>$this->ASSIGNMENT_ID, 'VIEWER_ID'=>$this->VIEWER_ID, 'ACCESS_ID'=>$this->ACCESS_ID, 'YEAR_ID'=>$this->YEAR_ID, 'PERSON_YEAR_ID'=>$this->PERSON_YEAR_ID);//[RAD_CALLBACK_PARAMS]
        $pageCallBack = $this->getCallBack(modulecim_hrdb::PAGE_EDITMYYEARINSCHOOL, $this->sortBy, $parameters);
        $this->setPageCallBack( $pageCallBack );
        
        
        $parameters = array('PERSON_ID'=>$this->PERSON_ID, 'PROVINCE_ID'=>$this->PROVINCE_ID, 'GENDER_ID'=>$this->GENDER_ID, 'STAFF_ID'=>$this->STAFF_ID, 'REGION_ID'=>$this->REGION_ID, 'EMERG_ID'=>$this->EMERG_ID, 'ASSIGNSTATUS_ID'=>$this->ASSIGNSTATUS_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'ASSIGNMENT_ID'=>$this->ASSIGNMENT_ID, 'VIEWER_ID'=>$this->VIEWER_ID, 'ACCESS_ID'=>$this->ACCESS_ID, 'YEAR_ID'=>$this->YEAR_ID, 'PERSON_YEAR_ID'=>$this->PERSON_YEAR_ID);//[RAD_CALLBACK_PARAMS]
        $formAction = $this->getCallBack(modulecim_hrdb::PAGE_EDITMYYEARINSCHOOL, $this->sortBy, $parameters );
        $this->pageDisplay = new FormProcessor_EditMyYearInSchool( $this->moduleRootPath, $this->viewer, $formAction, $this->PERSON_YEAR_ID , $this->PERSON_ID);//[RAD_FORMINIT_FOREIGNKEY_INIT]        
        
    } // end loadEditMyYearInSchool()



    //************************************************************************
	/**
	 * function loadHrdbForms
	 * <pre>
	 * Initializes the HrdbForms Page.
	 * </pre>
	 * @return [void]
	 */
    // RAD Tools: DataListTable Style
    function loadHrdbForms( $isCreated = false) 
    {
        // set the pageCallBack to be without any additional parameters
        // (an AdminBox needs this so Language Switching on a page doesn't
        // pass a previous operations)
        $parameters = array('PERSON_ID'=>$this->PERSON_ID, 'PROVINCE_ID'=>$this->PROVINCE_ID, 'GENDER_ID'=>$this->GENDER_ID, 'STAFF_ID'=>$this->STAFF_ID, 'REGION_ID'=>$this->REGION_ID, 'EMERG_ID'=>$this->EMERG_ID, 'ASSIGNSTATUS_ID'=>$this->ASSIGNSTATUS_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'ASSIGNMENT_ID'=>$this->ASSIGNMENT_ID, 'VIEWER_ID'=>$this->VIEWER_ID, 'ACCESS_ID'=>$this->ACCESS_ID, 'YEAR_ID'=>$this->YEAR_ID, 'PERSON_YEAR_ID'=>$this->PERSON_YEAR_ID, 'STAFFSCHEDULE_ID'=>$this->STAFFSCHEDULE_ID, 'STAFFACTIVITY_ID'=>$this->STAFFACTIVITY_ID, 'ACTIVITYTYPE_ID'=>$this->ACTIVITYTYPE_ID, 'STAFFSCHEDULETYPE_ID'=>$this->STAFFSCHEDULETYPE_ID, 'ACTIVITYSCHEDULE_ID'=>$this->ACTIVITYSCHEDULE_ID);//[RAD_CALLBACK_PARAMS]
        $pageCallBack = $this->getCallBack(modulecim_hrdb::PAGE_HRDBFORMS, $this->sortBy, $parameters);
        $this->setPageCallBack( $pageCallBack );
        
        if (( $this->accessPrivManager->hasSitePriv() ) || ( $this->accessPrivManager->isStaff($this->viewer->getID()) )) {
        
	        $parameters = array('FORMLIST_TYPE'=>$this->FORMLIST_TYPE, 'PERSON_ID'=>$this->PERSON_ID, 'PROVINCE_ID'=>$this->PROVINCE_ID, 'GENDER_ID'=>$this->GENDER_ID, 'STAFF_ID'=>$this->STAFF_ID, 'REGION_ID'=>$this->REGION_ID, 'EMERG_ID'=>$this->EMERG_ID, 'ASSIGNSTATUS_ID'=>$this->ASSIGNSTATUS_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'ASSIGNMENT_ID'=>$this->ASSIGNMENT_ID, 'VIEWER_ID'=>$this->VIEWER_ID, 'ACCESS_ID'=>$this->ACCESS_ID, 'YEAR_ID'=>$this->YEAR_ID, 'PERSON_YEAR_ID'=>$this->PERSON_YEAR_ID, 'STAFFSCHEDULE_ID'=>$this->STAFFSCHEDULE_ID, 'STAFFACTIVITY_ID'=>$this->STAFFACTIVITY_ID, 'ACTIVITYTYPE_ID'=>$this->ACTIVITYTYPE_ID, 'STAFFSCHEDULETYPE_ID'=>$this->STAFFSCHEDULETYPE_ID, 'ACTIVITYSCHEDULE_ID'=>$this->ACTIVITYSCHEDULE_ID, 'FIELD_ID'=>$this->FIELD_ID, 'FIELDVALUE_ID'=>$this->FIELDVALUE_ID, 'FIELDTYPE_ID'=>$this->FIELDTYPE_ID, 'DATATYPE_ID'=>$this->DATATYPE_ID, 'COUNTRY_ID'=>$this->COUNTRY_ID);//[RAD_CALLBACK_PARAMS]	      
	        $formAction = $this->getCallBack(modulecim_hrdb::PAGE_HRDBFORMS, $this->sortBy, $parameters );        
	        
            // create a new pageDisplay object
        		$this->pageDisplay = new page_HrdbForms( $this->moduleRootPath, $this->viewer, $this->sortBy, $formAction, $this->FORMLIST_TYPE );    
     	        
	        $links = array();
	        
	/*[RAD_LINK_INSERT]*/
	
	
	        $parameters = array('PERSON_ID'=>$this->PERSON_ID, 'PROVINCE_ID'=>$this->PROVINCE_ID, 'GENDER_ID'=>$this->GENDER_ID, 'STAFF_ID'=>$this->STAFF_ID, 'REGION_ID'=>$this->REGION_ID, 'EMERG_ID'=>$this->EMERG_ID, 'ASSIGNSTATUS_ID'=>$this->ASSIGNSTATUS_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'ASSIGNMENT_ID'=>$this->ASSIGNMENT_ID, 'VIEWER_ID'=>$this->VIEWER_ID, 'ACCESS_ID'=>$this->ACCESS_ID, 'YEAR_ID'=>$this->YEAR_ID, 'PERSON_YEAR_ID'=>$this->PERSON_YEAR_ID, 'STAFFSCHEDULE_ID'=>$this->STAFFSCHEDULE_ID, 'STAFFACTIVITY_ID'=>$this->STAFFACTIVITY_ID, 'ACTIVITYTYPE_ID'=>$this->ACTIVITYTYPE_ID, 'STAFFSCHEDULETYPE_ID'=>$this->STAFFSCHEDULETYPE_ID, 'ACTIVITYSCHEDULE_ID'=>$this->ACTIVITYSCHEDULE_ID);//[RAD_CALLBACK_PARAMS]
	        $sortByLink = $this->getCallBack( modulecim_hrdb::PAGE_HRDBFORMS, '', $parameters );
	        $sortByLink .= "&".modulecim_hrdb::SORTBY."=";
	        $links["sortBy"] = $sortByLink;
	        
	        // GROUP 2: STAFF AND ABOVE ONLY.   (access HRDB forms)
	        if ($this->FORMLIST_TYPE == modulecim_hrdb::FORMLIST_ACCESS) {	// && (( $this->accessPrivManager->hasSitePriv() ) || ( $this->accessPrivManager->isStaff($this->viewer->getID()) )) ){
	
		        $parameters = array('PERSON_ID'=>$this->PERSON_ID, 'PROVINCE_ID'=>$this->PROVINCE_ID, 'GENDER_ID'=>$this->GENDER_ID, 'STAFF_ID'=>$this->STAFF_ID, 'REGION_ID'=>$this->REGION_ID, 'EMERG_ID'=>$this->EMERG_ID, 'ASSIGNSTATUS_ID'=>$this->ASSIGNSTATUS_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'ASSIGNMENT_ID'=>$this->ASSIGNMENT_ID, 'VIEWER_ID'=>$this->VIEWER_ID, 'ACCESS_ID'=>$this->ACCESS_ID, 'YEAR_ID'=>$this->YEAR_ID, 'PERSON_YEAR_ID'=>$this->PERSON_YEAR_ID, 'STAFFSCHEDULE_ID'=>$this->STAFFSCHEDULE_ID, 'STAFFACTIVITY_ID'=>$this->STAFFACTIVITY_ID, 'ACTIVITYTYPE_ID'=>$this->ACTIVITYTYPE_ID, 'STAFFSCHEDULETYPE_ID'=>$this->STAFFSCHEDULETYPE_ID, 'ACTIVITYSCHEDULE_ID'=>$this->ACTIVITYSCHEDULE_ID);//[RAD_CALLBACK_PARAMS]
		        $link = $this->getCallBack( modulecim_hrdb::PAGE_EDITSTAFFSCHEDULE, '', $parameters );
		        $link .= "&".modulecim_hrdb::STAFFSCHEDULETYPE_ID."=";
		        $links["access"] = $link;
		        
		        $this->pageDisplay->setAccessType(page_HrdbForms::ACCESS_GENERAL);
	        }
	        
	        // GROUP 2: STAFF AND ABOVE ONLY.   (approve HRDB forms)
// 	        if (( $this->accessPrivManager->hasSitePriv() ) || ( $this->accessPrivManager->isStaff($this->viewer->getID()) ) ){
		        
		        if ($this->FORMLIST_TYPE == modulecim_hrdb::FORMLIST_APPROVAL) {	    
	
			        $parameters = array('PERSON_ID'=>$this->PERSON_ID, 'PROVINCE_ID'=>$this->PROVINCE_ID, 'GENDER_ID'=>$this->GENDER_ID, 'STAFF_ID'=>$this->STAFF_ID, 'REGION_ID'=>$this->REGION_ID, 'EMERG_ID'=>$this->EMERG_ID, 'ASSIGNSTATUS_ID'=>$this->ASSIGNSTATUS_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'ASSIGNMENT_ID'=>$this->ASSIGNMENT_ID, 'VIEWER_ID'=>$this->VIEWER_ID, 'ACCESS_ID'=>$this->ACCESS_ID, 'YEAR_ID'=>$this->YEAR_ID, 'PERSON_YEAR_ID'=>$this->PERSON_YEAR_ID, 'STAFFSCHEDULE_ID'=>$this->STAFFSCHEDULE_ID, 'STAFFACTIVITY_ID'=>$this->STAFFACTIVITY_ID, 'ACTIVITYTYPE_ID'=>$this->ACTIVITYTYPE_ID, 'STAFFSCHEDULETYPE_ID'=>$this->STAFFSCHEDULETYPE_ID, 'ACTIVITYSCHEDULE_ID'=>$this->ACTIVITYSCHEDULE_ID);//[RAD_CALLBACK_PARAMS]
			        $link = $this->getCallBack( modulecim_hrdb::PAGE_FORMAPPROVALLISTING, '', $parameters );	//PAGE_APPROVESTAFFSCHEDULE
			        $link .= "&".modulecim_hrdb::STAFFSCHEDULETYPE_ID."=";
			        $links["approve"] = $link;	
			        
			        $this->pageDisplay->setAccessType(page_HrdbForms::ACCESS_DIRECTOR_APPROVAL);
		        }
		        else if ($this->FORMLIST_TYPE == modulecim_hrdb::FORMLIST_SUBMITTED) {
	
			        $parameters = array('PERSON_ID'=>$this->PERSON_ID, 'PROVINCE_ID'=>$this->PROVINCE_ID, 'GENDER_ID'=>$this->GENDER_ID, 'STAFF_ID'=>$this->STAFF_ID, 'REGION_ID'=>$this->REGION_ID, 'EMERG_ID'=>$this->EMERG_ID, 'ASSIGNSTATUS_ID'=>$this->ASSIGNSTATUS_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'ASSIGNMENT_ID'=>$this->ASSIGNMENT_ID, 'VIEWER_ID'=>$this->VIEWER_ID, 'ACCESS_ID'=>$this->ACCESS_ID, 'YEAR_ID'=>$this->YEAR_ID, 'PERSON_YEAR_ID'=>$this->PERSON_YEAR_ID, 'STAFFSCHEDULE_ID'=>$this->STAFFSCHEDULE_ID, 'STAFFACTIVITY_ID'=>$this->STAFFACTIVITY_ID, 'ACTIVITYTYPE_ID'=>$this->ACTIVITYTYPE_ID, 'STAFFSCHEDULETYPE_ID'=>$this->STAFFSCHEDULETYPE_ID, 'ACTIVITYSCHEDULE_ID'=>$this->ACTIVITYSCHEDULE_ID);//[RAD_CALLBACK_PARAMS]
			        $link = $this->getCallBack( modulecim_hrdb::PAGE_FORMSUBMITTEDLISTING, '', $parameters );	//PAGE_APPROVESTAFFSCHEDULE
			        $link .= "&".modulecim_hrdb::STAFFSCHEDULETYPE_ID."=";
			        $links["submitted"] = $link;	
			        
			        $this->pageDisplay->setAccessType(page_HrdbForms::ACCESS_DIRECTOR_SUBMITCHECK);
		        }		        
// 	        }
		                
	        
	        // GROUP 3: SUPER ADMINS ONLY.
	        if ( ($this->FORMLIST_TYPE == modulecim_hrdb::FORMLIST_EDIT) && ($this->accessPrivManager->hasSitePriv())){
		        
	        $parameters = array('PERSON_ID'=>$this->PERSON_ID, 'PROVINCE_ID'=>$this->PROVINCE_ID, 'GENDER_ID'=>$this->GENDER_ID, 'STAFF_ID'=>$this->STAFF_ID, 'REGION_ID'=>$this->REGION_ID, 'EMERG_ID'=>$this->EMERG_ID, 'ASSIGNSTATUS_ID'=>$this->ASSIGNSTATUS_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'ASSIGNMENT_ID'=>$this->ASSIGNMENT_ID, 'VIEWER_ID'=>$this->VIEWER_ID, 'ACCESS_ID'=>$this->ACCESS_ID, 'YEAR_ID'=>$this->YEAR_ID, 'PERSON_YEAR_ID'=>$this->PERSON_YEAR_ID, 'STAFFSCHEDULE_ID'=>$this->STAFFSCHEDULE_ID, 'STAFFACTIVITY_ID'=>$this->STAFFACTIVITY_ID, 'ACTIVITYTYPE_ID'=>$this->ACTIVITYTYPE_ID, 'STAFFSCHEDULETYPE_ID'=>$this->STAFFSCHEDULETYPE_ID, 'ACTIVITYSCHEDULE_ID'=>$this->ACTIVITYSCHEDULE_ID);//[RAD_CALLBACK_PARAMS]
		        $link = $this->getCallBack( modulecim_hrdb::PAGE_EDITSTAFFFORMCONTEXT, '', $parameters );	
		        $link .= "&".modulecim_hrdb::STAFFSCHEDULETYPE_ID."=";
		        $links["admin"] = $link;	
		        
		        $this->pageDisplay->setAccessType(page_HrdbForms::ACCESS_SUPERADMIN);
	// 	        $this->pageDisplay->setAdminAccess( true );
	// 	        $this->pageDisplay->setGeneralAccess( false );       
	        }          
	 
	
	        $this->pageDisplay->setLinks( $links ); 
        }
        else
        {
	        $this->pageDisplay = new page_NotAuthorized($this->moduleRootPath, $this->viewer);  
        }  
        
    } // end loadHrdbForms()



    //************************************************************************
	/**
	 * function loadEditFormFieldValues
	 * <pre>
	 * Initializes the loadEditFormFieldValues Page.
	 * </pre>
	 * @return [void]
	 */
    // RAD Tools: FormSingleEntry style
    function loadEditFormFieldValues($isCreated = false) 
    {
   
        // set the pageCallBack to be without any additional parameters
        // (an AdminBox needs this so Language Switching on a page doesn't
        // pass a previous operations)
        $parameters = array('PERSON_ID'=>$this->PERSON_ID, 'PROVINCE_ID'=>$this->PROVINCE_ID, 'GENDER_ID'=>$this->GENDER_ID, 'STAFF_ID'=>$this->STAFF_ID, 'REGION_ID'=>$this->REGION_ID, 'EMERG_ID'=>$this->EMERG_ID, 'ASSIGNSTATUS_ID'=>$this->ASSIGNSTATUS_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'ASSIGNMENT_ID'=>$this->ASSIGNMENT_ID, 'VIEWER_ID'=>$this->VIEWER_ID, 'ACCESS_ID'=>$this->ACCESS_ID, 'YEAR_ID'=>$this->YEAR_ID, 'PERSON_YEAR_ID'=>$this->PERSON_YEAR_ID, 'STAFFSCHEDULE_ID'=>$this->STAFFSCHEDULE_ID, 'STAFFACTIVITY_ID'=>$this->STAFFACTIVITY_ID, 'ACTIVITYTYPE_ID'=>$this->ACTIVITYTYPE_ID, 'STAFFSCHEDULETYPE_ID'=>$this->STAFFSCHEDULETYPE_ID, 'ACTIVITYSCHEDULE_ID'=>$this->ACTIVITYSCHEDULE_ID, 'FIELD_ID'=>$this->FIELD_ID, 'FIELDVALUE_ID'=>$this->FIELDVALUE_ID, 'FIELDTYPE_ID'=>$this->FIELDTYPE_ID, 'DATATYPE_ID'=>$this->DATATYPE_ID, 'COUNTRY_ID'=>$this->COUNTRY_ID);//[RAD_CALLBACK_PARAMS]
        $pageCallBack = $this->getCallBack(modulecim_hrdb::PAGE_EDITFORMFIELDVALUES, $this->sortBy, $parameters);
        $this->setPageCallBack( $pageCallBack );       
            
        // Edit My HRDB Form page is restricted to staff and above
        if (( $this->accessPrivManager->hasSitePriv() ) || ( $this->accessPrivManager->isStaff($this->viewer->getID()) )) {
	        
	        $parameters = array('PERSON_ID'=>$this->PERSON_ID, 'PROVINCE_ID'=>$this->PROVINCE_ID, 'GENDER_ID'=>$this->GENDER_ID, 'STAFF_ID'=>$this->STAFF_ID, 'REGION_ID'=>$this->REGION_ID, 'EMERG_ID'=>$this->EMERG_ID, 'ASSIGNSTATUS_ID'=>$this->ASSIGNSTATUS_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'ASSIGNMENT_ID'=>$this->ASSIGNMENT_ID, 'VIEWER_ID'=>$this->VIEWER_ID, 'ACCESS_ID'=>$this->ACCESS_ID, 'YEAR_ID'=>$this->YEAR_ID, 'PERSON_YEAR_ID'=>$this->PERSON_YEAR_ID, 'STAFFSCHEDULE_ID'=>$this->STAFFSCHEDULE_ID, 'STAFFACTIVITY_ID'=>$this->STAFFACTIVITY_ID, 'ACTIVITYTYPE_ID'=>$this->ACTIVITYTYPE_ID, 'STAFFSCHEDULETYPE_ID'=>$this->STAFFSCHEDULETYPE_ID, 'ACTIVITYSCHEDULE_ID'=>$this->ACTIVITYSCHEDULE_ID, 'FIELD_ID'=>$this->FIELD_ID, 'FIELDVALUE_ID'=>$this->FIELDVALUE_ID, 'FIELDTYPE_ID'=>$this->FIELDTYPE_ID, 'DATATYPE_ID'=>$this->DATATYPE_ID, 'COUNTRY_ID'=>$this->COUNTRY_ID);//[RAD_CALLBACK_PARAMS]
	        $basic_form_parameters = array('PERSON_ID'=>$this->PERSON_ID, 'STAFF_ID'=>$this->STAFF_ID, 'ASSIGNSTATUS_ID'=>$this->ASSIGNSTATUS_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'ASSIGNMENT_ID'=>$this->ASSIGNMENT_ID, 'VIEWER_ID'=>$this->VIEWER_ID, 'ACCESS_ID'=>$this->ACCESS_ID, 'STAFFSCHEDULE_ID'=>$this->STAFFSCHEDULE_ID, 'STAFFSCHEDULETYPE_ID'=>$this->STAFFSCHEDULETYPE_ID, 'FIELD_ID'=>$this->FIELD_ID, 'FIELDVALUE_ID'=>$this->FIELDVALUE_ID);//[RAD_CALLBACK_PARAMS]
	        $activity_form_parameters = array('PERSON_ID'=>$this->PERSON_ID, 'STAFF_ID'=>$this->STAFF_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'ASSIGNMENT_ID'=>$this->ASSIGNMENT_ID, 'VIEWER_ID'=>$this->VIEWER_ID, 'ACCESS_ID'=>$this->ACCESS_ID, 'STAFFSCHEDULE_ID'=>$this->STAFFSCHEDULE_ID, 'STAFFACTIVITY_ID'=>$this->STAFFACTIVITY_ID, 'ACTIVITYTYPE_ID'=>$this->ACTIVITYTYPE_ID, 'STAFFSCHEDULETYPE_ID'=>$this->STAFFSCHEDULETYPE_ID, 'ACTIVITYSCHEDULE_ID'=>$this->ACTIVITYSCHEDULE_ID);//[RAD_CALLBACK_PARAMS]
	      
	        $formAction = $this->getCallBack(modulecim_hrdb::PAGE_EDITFORMFIELDVALUES, $this->sortBy, $parameters );
	        $basicFormAction = $this->getCallBack(modulecim_hrdb::PAGE_EDITFORMFIELDVALUES, $this->sortBy, $basic_form_parameters );
	        $activityFormAction = $this->getCallBack(modulecim_hrdb::PAGE_EDITFORMFIELDVALUES, $this->sortBy, $activity_form_parameters );
	
	        $pageCallBack = $this->getCallBack(modulecim_hrdb::PAGE_EDITFORMFIELDVALUES, $this->sortBy, $parameters);
	        $this->setPageCallBack( $pageCallBack );     
	 
	        // if this pageDisplay object isn't already created then 
	        if ( !$isCreated ) {
	 	        $disableHeading = true;
		        $showActivityForm = true;
		        $showHidden = false;		// TODO: create condition for this based on privilege level
	            // create a new pageDisplay object										  
	//         		$this->pageDisplay = new FormProcessor_EditStaffScheduleForm( $this->moduleRootPath, $this->viewer, $formAction, $basicFormAction, $activityFormAction, $this->sortBy, $this->PERSON_ID, $this->STAFFSCHEDULETYPE_ID, $this->STAFFSCHEDULE_ID, $this->FIELDVALUE_ID, $this->FIELD_ID, $this->STAFFACTIVITY_ID, $showHidden, $showActivityForm);//[RAD_FORMINIT_FOREIGNKEY_INIT]        
	        		$this->pageDisplay = new FormProcessor_EditStaffScheduleForm( $this->moduleRootPath, $this->viewer, $formAction, $this->PERSON_ID, $this->STAFFSCHEDULETYPE_ID, $this->FIELDVALUE_ID, $this->FIELD_ID, $disableHeading, $showHidden);//[RAD_FORMINIT_FOREIGNKEY_INIT]        
	
	        } else {
	        
	            // otherwise just update the formAction value
	            $this->pageDisplay->setFormAction( $formAction );
	        }   
	        
	        $links = array();
	        
	         /**** BASIC STAFF SCHEDULE FORM SUB-PAGE LINKS INIT ***/
	//         $basicFormLinks = array(); 
	//          
	//         $parameters = array('PERSON_ID'=>$this->PERSON_ID, 'PROVINCE_ID'=>$this->PROVINCE_ID, 'GENDER_ID'=>$this->GENDER_ID, 'STAFF_ID'=>$this->STAFF_ID, 'REGION_ID'=>$this->REGION_ID, 'EMERG_ID'=>$this->EMERG_ID, 'ASSIGNSTATUS_ID'=>$this->ASSIGNSTATUS_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'ASSIGNMENT_ID'=>$this->ASSIGNMENT_ID, 'VIEWER_ID'=>$this->VIEWER_ID, 'ACCESS_ID'=>$this->ACCESS_ID, 'YEAR_ID'=>$this->YEAR_ID, 'PERSON_YEAR_ID'=>$this->PERSON_YEAR_ID, 'STAFFSCHEDULE_ID'=>$this->STAFFSCHEDULE_ID, 'STAFFACTIVITY_ID'=>$this->STAFFACTIVITY_ID, 'ACTIVITYTYPE_ID'=>$this->ACTIVITYTYPE_ID, 'STAFFSCHEDULETYPE_ID'=>$this->STAFFSCHEDULETYPE_ID, 'ACTIVITYSCHEDULE_ID'=>$this->ACTIVITYSCHEDULE_ID, 'FIELD_ID'=>$this->FIELD_ID, 'FIELDVALUE_ID'=>$this->FIELDVALUE_ID, 'FIELDTYPE_ID'=>$this->FIELDTYPE_ID, 'DATATYPE_ID'=>$this->DATATYPE_ID, 'COUNTRY_ID'=>$this->COUNTRY_ID);//[RAD_CALLBACK_PARAMS]
	//         $editLink = $this->getCallBack( modulecim_hrdb::PAGE_EDITFORMFIELDVALUES, $this->sortBy, $parameters );
	//         $editLink .= "&". modulecim_hrdb::STAFFSCHEDULETYPE_ID . "=";
	//         $basicFormLinks[ "edit" ] = $editLink;
	//         
	//         // NOTE: delete link is same as edit link for an AdminBox
	//         $basicFormLinks[ "del" ] = $editLink;
	
	
	//         $parameters = array('PERSON_ID'=>$this->PERSON_ID, 'PROVINCE_ID'=>$this->PROVINCE_ID, 'GENDER_ID'=>$this->GENDER_ID, 'STAFF_ID'=>$this->STAFF_ID, 'REGION_ID'=>$this->REGION_ID, 'EMERG_ID'=>$this->EMERG_ID, 'ASSIGNSTATUS_ID'=>$this->ASSIGNSTATUS_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'ASSIGNMENT_ID'=>$this->ASSIGNMENT_ID, 'VIEWER_ID'=>$this->VIEWER_ID, 'ACCESS_ID'=>$this->ACCESS_ID, 'YEAR_ID'=>$this->YEAR_ID, 'PERSON_YEAR_ID'=>$this->PERSON_YEAR_ID, 'STAFFSCHEDULE_ID'=>$this->STAFFSCHEDULE_ID, 'STAFFACTIVITY_ID'=>$this->STAFFACTIVITY_ID, 'ACTIVITYTYPE_ID'=>$this->ACTIVITYTYPE_ID, 'STAFFSCHEDULETYPE_ID'=>$this->STAFFSCHEDULETYPE_ID, 'ACTIVITYSCHEDULE_ID'=>$this->ACTIVITYSCHEDULE_ID, 'FIELD_ID'=>$this->FIELD_ID, 'FIELDVALUE_ID'=>$this->FIELDVALUE_ID, 'FIELDTYPE_ID'=>$this->FIELDTYPE_ID, 'DATATYPE_ID'=>$this->DATATYPE_ID, 'COUNTRY_ID'=>$this->COUNTRY_ID);//[RAD_CALLBACK_PARAMS]
	//         $sortByLink = $this->getCallBack( modulecim_hrdb::PAGE_EDITFORMFIELDVALUES, '', $parameters );
	//         $sortByLink .= "&".modulecim_hrdb::SORTBY."=";
	//         $basicFormLinks["sortBy"] = $sortByLink;
	        
	        
	         /**** ACTIVITY FORM SUB-PAGE LINKS INIT ***/
	//         $activityFormLinks = array(); 
	//          
	//         $parameters = array('PERSON_ID'=>$this->PERSON_ID, 'PROVINCE_ID'=>$this->PROVINCE_ID, 'GENDER_ID'=>$this->GENDER_ID, 'STAFF_ID'=>$this->STAFF_ID, 'REGION_ID'=>$this->REGION_ID, 'EMERG_ID'=>$this->EMERG_ID, 'ASSIGNSTATUS_ID'=>$this->ASSIGNSTATUS_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'ASSIGNMENT_ID'=>$this->ASSIGNMENT_ID, 'VIEWER_ID'=>$this->VIEWER_ID, 'ACCESS_ID'=>$this->ACCESS_ID, 'YEAR_ID'=>$this->YEAR_ID, 'PERSON_YEAR_ID'=>$this->PERSON_YEAR_ID, 'STAFFSCHEDULE_ID'=>$this->STAFFSCHEDULE_ID, 'STAFFACTIVITY_ID'=>$this->STAFFACTIVITY_ID, 'ACTIVITYTYPE_ID'=>$this->ACTIVITYTYPE_ID, 'STAFFSCHEDULETYPE_ID'=>$this->STAFFSCHEDULETYPE_ID, 'ACTIVITYSCHEDULE_ID'=>$this->ACTIVITYSCHEDULE_ID, 'FIELD_ID'=>$this->FIELD_ID, 'FIELDVALUE_ID'=>$this->FIELDVALUE_ID, 'FIELDTYPE_ID'=>$this->FIELDTYPE_ID, 'DATATYPE_ID'=>$this->DATATYPE_ID, 'COUNTRY_ID'=>$this->COUNTRY_ID);//[RAD_CALLBACK_PARAMS]
	//         $editLink = $this->getCallBack( modulecim_hrdb::PAGE_EDITFORMFIELDVALUES, $this->sortBy, $parameters );
	//         $editLink .= "&". modulecim_hrdb::STAFFACTIVITY_ID . "=";
	//         $activityFormLinks[ "edit" ] = $editLink;
	//         
	//         // NOTE: delete link is same as edit link for an AdminBox
	//         $activityFormLinks[ "del" ] = $editLink;
	
	// /*[RAD_LINK_INSERT]*/
	
	//         $parameters = array('PERSON_ID'=>$this->PERSON_ID, 'PROVINCE_ID'=>$this->PROVINCE_ID, 'GENDER_ID'=>$this->GENDER_ID, 'STAFF_ID'=>$this->STAFF_ID, 'REGION_ID'=>$this->REGION_ID, 'EMERG_ID'=>$this->EMERG_ID, 'ASSIGNSTATUS_ID'=>$this->ASSIGNSTATUS_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'ASSIGNMENT_ID'=>$this->ASSIGNMENT_ID, 'VIEWER_ID'=>$this->VIEWER_ID, 'ACCESS_ID'=>$this->ACCESS_ID, 'YEAR_ID'=>$this->YEAR_ID, 'PERSON_YEAR_ID'=>$this->PERSON_YEAR_ID, 'STAFFSCHEDULE_ID'=>$this->STAFFSCHEDULE_ID, 'STAFFACTIVITY_ID'=>$this->STAFFACTIVITY_ID, 'ACTIVITYTYPE_ID'=>$this->ACTIVITYTYPE_ID, 'STAFFSCHEDULETYPE_ID'=>$this->STAFFSCHEDULETYPE_ID, 'ACTIVITYSCHEDULE_ID'=>$this->ACTIVITYSCHEDULE_ID, 'FIELD_ID'=>$this->FIELD_ID, 'FIELDVALUE_ID'=>$this->FIELDVALUE_ID, 'FIELDTYPE_ID'=>$this->FIELDTYPE_ID, 'DATATYPE_ID'=>$this->DATATYPE_ID, 'COUNTRY_ID'=>$this->COUNTRY_ID);//[RAD_CALLBACK_PARAMS]
	//         $sortByLink = $this->getCallBack( modulecim_hrdb::PAGE_EDITFORMFIELDVALUES, '', $parameters );
	//         $sortByLink .= "&".modulecim_hrdb::SORTBY."=";
	//         $activityFormLinks["sortBy"] = $sortByLink;
	
	//         $this->pageDisplay->setLinks( $activityFormLinks );	    // $links, $basicFormLinks,   (DON'T NEED LINKS FOR SINGLE FORM PORTION) 
	//

        }
        else
        {
	        $this->pageDisplay = new page_NotAuthorized($this->moduleRootPath, $this->viewer);  
        }              
           
    } // end loadEditFormFieldValues()
    
    
    
    //************************************************************************
	/**
	 * function loadEditStaffSchedule
	 * <pre>
	 * Initializes the loadEditStaffSchedule Page.
	 * </pre>
	 * @return [void]
	 */
    // RAD Tools: FormSingleEntry style
    function loadEditStaffSchedule($isCreated = false) 
    {
   
        // set the pageCallBack to be without any additional parameters
        // (an AdminBox needs this so Language Switching on a page doesn't
        // pass a previous operations)
        $parameters = array('PERSON_ID'=>$this->PERSON_ID, 'PROVINCE_ID'=>$this->PROVINCE_ID, 'GENDER_ID'=>$this->GENDER_ID, 'STAFF_ID'=>$this->STAFF_ID, 'REGION_ID'=>$this->REGION_ID, 'EMERG_ID'=>$this->EMERG_ID, 'ASSIGNSTATUS_ID'=>$this->ASSIGNSTATUS_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'ASSIGNMENT_ID'=>$this->ASSIGNMENT_ID, 'VIEWER_ID'=>$this->VIEWER_ID, 'ACCESS_ID'=>$this->ACCESS_ID, 'YEAR_ID'=>$this->YEAR_ID, 'PERSON_YEAR_ID'=>$this->PERSON_YEAR_ID, 'STAFFSCHEDULE_ID'=>$this->STAFFSCHEDULE_ID, 'STAFFACTIVITY_ID'=>$this->STAFFACTIVITY_ID, 'ACTIVITYTYPE_ID'=>$this->ACTIVITYTYPE_ID, 'STAFFSCHEDULETYPE_ID'=>$this->STAFFSCHEDULETYPE_ID, 'ACTIVITYSCHEDULE_ID'=>$this->ACTIVITYSCHEDULE_ID, 'FIELD_ID'=>$this->FIELD_ID, 'FIELDVALUE_ID'=>$this->FIELDVALUE_ID, 'FIELDTYPE_ID'=>$this->FIELDTYPE_ID, 'DATATYPE_ID'=>$this->DATATYPE_ID, 'COUNTRY_ID'=>$this->COUNTRY_ID);//[RAD_CALLBACK_PARAMS]
        $pageCallBack = $this->getCallBack(modulecim_hrdb::PAGE_EDITSTAFFSCHEDULE, $this->sortBy, $parameters);
        $this->setPageCallBack( $pageCallBack );       
               
        // Edit My HRDB Form page is restricted to staff and above
        if (( $this->accessPrivManager->hasSitePriv() ) || ( $this->accessPrivManager->isStaff($this->viewer->getID()) )) {        
	        
	        $parameters = array('PERSON_ID'=>$this->PERSON_ID, 'PROVINCE_ID'=>$this->PROVINCE_ID, 'GENDER_ID'=>$this->GENDER_ID, 'STAFF_ID'=>$this->STAFF_ID, 'REGION_ID'=>$this->REGION_ID, 'EMERG_ID'=>$this->EMERG_ID, 'ASSIGNSTATUS_ID'=>$this->ASSIGNSTATUS_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'ASSIGNMENT_ID'=>$this->ASSIGNMENT_ID, 'VIEWER_ID'=>$this->VIEWER_ID, 'ACCESS_ID'=>$this->ACCESS_ID, 'YEAR_ID'=>$this->YEAR_ID, 'PERSON_YEAR_ID'=>$this->PERSON_YEAR_ID, 'STAFFSCHEDULE_ID'=>$this->STAFFSCHEDULE_ID, 'STAFFACTIVITY_ID'=>$this->STAFFACTIVITY_ID, 'ACTIVITYTYPE_ID'=>$this->ACTIVITYTYPE_ID, 'STAFFSCHEDULETYPE_ID'=>$this->STAFFSCHEDULETYPE_ID, 'ACTIVITYSCHEDULE_ID'=>$this->ACTIVITYSCHEDULE_ID, 'FIELD_ID'=>$this->FIELD_ID, 'FIELDVALUE_ID'=>$this->FIELDVALUE_ID, 'FIELDTYPE_ID'=>$this->FIELDTYPE_ID, 'DATATYPE_ID'=>$this->DATATYPE_ID, 'COUNTRY_ID'=>$this->COUNTRY_ID);//[RAD_CALLBACK_PARAMS]
	        $basic_form_parameters = array('PERSON_ID'=>$this->PERSON_ID, 'STAFF_ID'=>$this->STAFF_ID, 'ASSIGNSTATUS_ID'=>$this->ASSIGNSTATUS_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'ASSIGNMENT_ID'=>$this->ASSIGNMENT_ID, 'VIEWER_ID'=>$this->VIEWER_ID, 'ACCESS_ID'=>$this->ACCESS_ID, 'STAFFSCHEDULE_ID'=>$this->STAFFSCHEDULE_ID, 'STAFFSCHEDULETYPE_ID'=>$this->STAFFSCHEDULETYPE_ID, 'FIELD_ID'=>$this->FIELD_ID, 'FIELDVALUE_ID'=>$this->FIELDVALUE_ID);//[RAD_CALLBACK_PARAMS]
	        $activity_form_parameters = array('PERSON_ID'=>$this->PERSON_ID, 'STAFF_ID'=>$this->STAFF_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'ASSIGNMENT_ID'=>$this->ASSIGNMENT_ID, 'VIEWER_ID'=>$this->VIEWER_ID, 'ACCESS_ID'=>$this->ACCESS_ID, 'STAFFSCHEDULE_ID'=>$this->STAFFSCHEDULE_ID, 'STAFFACTIVITY_ID'=>$this->STAFFACTIVITY_ID, 'ACTIVITYTYPE_ID'=>$this->ACTIVITYTYPE_ID, 'STAFFSCHEDULETYPE_ID'=>$this->STAFFSCHEDULETYPE_ID, 'ACTIVITYSCHEDULE_ID'=>$this->ACTIVITYSCHEDULE_ID);//[RAD_CALLBACK_PARAMS]
	      
	        $formAction = $this->getCallBack(modulecim_hrdb::PAGE_EDITSTAFFSCHEDULE, $this->sortBy, $parameters );
	        $basicFormAction = $this->getCallBack(modulecim_hrdb::PAGE_EDITSTAFFSCHEDULE, $this->sortBy, $basic_form_parameters );
	        $activityFormAction = $this->getCallBack(modulecim_hrdb::PAGE_EDITSTAFFSCHEDULE, $this->sortBy, $activity_form_parameters );
	
	        $pageCallBack = $this->getCallBack(modulecim_hrdb::PAGE_EDITSTAFFSCHEDULE, $this->sortBy, $parameters);
	        $this->setPageCallBack( $pageCallBack );     
	 
	        // if this pageDisplay object isn't already created then 
	        if ( !$isCreated ) {
	// 	        $disableHeading = false;
	// 	        $showActivityForm = true;
		        $showHidden = false;		// TODO: create condition for this based on privilege level
	            // create a new pageDisplay object										  
	        		$this->pageDisplay = new FormProcessor_EditStaffScheduleForm( $this->moduleRootPath, $this->viewer, $formAction, $basicFormAction, $activityFormAction, $this->sortBy, $this->PERSON_ID, $this->STAFFSCHEDULETYPE_ID, $this->STAFFSCHEDULE_ID, $this->FIELDVALUE_ID, $this->FIELD_ID, $this->STAFFACTIVITY_ID, $showHidden);//[RAD_FORMINIT_FOREIGNKEY_INIT]        
	
	        } else {
	        
	            // otherwise just update the formAction value
	            $this->pageDisplay->setFormAction( $formAction, $basicFormAction, $activityFormAction);
	        }   
	        
	        $links = array();
	        
	         /**** BASIC STAFF SCHEDULE FORM SUB-PAGE LINKS INIT ***/
	//         $basicFormLinks = array(); 
	//          
	//         $parameters = array('PERSON_ID'=>$this->PERSON_ID, 'PROVINCE_ID'=>$this->PROVINCE_ID, 'GENDER_ID'=>$this->GENDER_ID, 'STAFF_ID'=>$this->STAFF_ID, 'REGION_ID'=>$this->REGION_ID, 'EMERG_ID'=>$this->EMERG_ID, 'ASSIGNSTATUS_ID'=>$this->ASSIGNSTATUS_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'ASSIGNMENT_ID'=>$this->ASSIGNMENT_ID, 'VIEWER_ID'=>$this->VIEWER_ID, 'ACCESS_ID'=>$this->ACCESS_ID, 'YEAR_ID'=>$this->YEAR_ID, 'PERSON_YEAR_ID'=>$this->PERSON_YEAR_ID, 'STAFFSCHEDULE_ID'=>$this->STAFFSCHEDULE_ID, 'STAFFACTIVITY_ID'=>$this->STAFFACTIVITY_ID, 'ACTIVITYTYPE_ID'=>$this->ACTIVITYTYPE_ID, 'STAFFSCHEDULETYPE_ID'=>$this->STAFFSCHEDULETYPE_ID, 'ACTIVITYSCHEDULE_ID'=>$this->ACTIVITYSCHEDULE_ID, 'FIELD_ID'=>$this->FIELD_ID, 'FIELDVALUE_ID'=>$this->FIELDVALUE_ID, 'FIELDTYPE_ID'=>$this->FIELDTYPE_ID, 'DATATYPE_ID'=>$this->DATATYPE_ID, 'COUNTRY_ID'=>$this->COUNTRY_ID);//[RAD_CALLBACK_PARAMS]
	//         $editLink = $this->getCallBack( modulecim_hrdb::PAGE_EDITFORMFIELDVALUES, $this->sortBy, $parameters );
	//         $editLink .= "&". modulecim_hrdb::STAFFSCHEDULETYPE_ID . "=";
	//         $basicFormLinks[ "edit" ] = $editLink;
	//         
	//         // NOTE: delete link is same as edit link for an AdminBox
	//         $basicFormLinks[ "del" ] = $editLink;
	
	
	//         $parameters = array('PERSON_ID'=>$this->PERSON_ID, 'PROVINCE_ID'=>$this->PROVINCE_ID, 'GENDER_ID'=>$this->GENDER_ID, 'STAFF_ID'=>$this->STAFF_ID, 'REGION_ID'=>$this->REGION_ID, 'EMERG_ID'=>$this->EMERG_ID, 'ASSIGNSTATUS_ID'=>$this->ASSIGNSTATUS_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'ASSIGNMENT_ID'=>$this->ASSIGNMENT_ID, 'VIEWER_ID'=>$this->VIEWER_ID, 'ACCESS_ID'=>$this->ACCESS_ID, 'YEAR_ID'=>$this->YEAR_ID, 'PERSON_YEAR_ID'=>$this->PERSON_YEAR_ID, 'STAFFSCHEDULE_ID'=>$this->STAFFSCHEDULE_ID, 'STAFFACTIVITY_ID'=>$this->STAFFACTIVITY_ID, 'ACTIVITYTYPE_ID'=>$this->ACTIVITYTYPE_ID, 'STAFFSCHEDULETYPE_ID'=>$this->STAFFSCHEDULETYPE_ID, 'ACTIVITYSCHEDULE_ID'=>$this->ACTIVITYSCHEDULE_ID, 'FIELD_ID'=>$this->FIELD_ID, 'FIELDVALUE_ID'=>$this->FIELDVALUE_ID, 'FIELDTYPE_ID'=>$this->FIELDTYPE_ID, 'DATATYPE_ID'=>$this->DATATYPE_ID, 'COUNTRY_ID'=>$this->COUNTRY_ID);//[RAD_CALLBACK_PARAMS]
	//         $sortByLink = $this->getCallBack( modulecim_hrdb::PAGE_EDITFORMFIELDVALUES, '', $parameters );
	//         $sortByLink .= "&".modulecim_hrdb::SORTBY."=";
	//         $basicFormLinks["sortBy"] = $sortByLink;
	        
	        
	         /**** ACTIVITY FORM SUB-PAGE LINKS INIT ***/
	        $activityFormLinks = array(); 
	         
	        $parameters = array('PERSON_ID'=>$this->PERSON_ID, 'PROVINCE_ID'=>$this->PROVINCE_ID, 'GENDER_ID'=>$this->GENDER_ID, 'STAFF_ID'=>$this->STAFF_ID, 'REGION_ID'=>$this->REGION_ID, 'EMERG_ID'=>$this->EMERG_ID, 'ASSIGNSTATUS_ID'=>$this->ASSIGNSTATUS_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'ASSIGNMENT_ID'=>$this->ASSIGNMENT_ID, 'VIEWER_ID'=>$this->VIEWER_ID, 'ACCESS_ID'=>$this->ACCESS_ID, 'YEAR_ID'=>$this->YEAR_ID, 'PERSON_YEAR_ID'=>$this->PERSON_YEAR_ID, 'STAFFSCHEDULE_ID'=>$this->STAFFSCHEDULE_ID, 'STAFFACTIVITY_ID'=>$this->STAFFACTIVITY_ID, 'ACTIVITYTYPE_ID'=>$this->ACTIVITYTYPE_ID, 'STAFFSCHEDULETYPE_ID'=>$this->STAFFSCHEDULETYPE_ID, 'ACTIVITYSCHEDULE_ID'=>$this->ACTIVITYSCHEDULE_ID, 'FIELD_ID'=>$this->FIELD_ID, 'FIELDVALUE_ID'=>$this->FIELDVALUE_ID, 'FIELDTYPE_ID'=>$this->FIELDTYPE_ID, 'DATATYPE_ID'=>$this->DATATYPE_ID, 'COUNTRY_ID'=>$this->COUNTRY_ID);//[RAD_CALLBACK_PARAMS]
	        $editLink = $this->getCallBack( modulecim_hrdb::PAGE_EDITSTAFFSCHEDULE, $this->sortBy, $parameters );
	        $editLink .= "&". modulecim_hrdb::STAFFACTIVITY_ID . "=";
	        $activityFormLinks[ "edit" ] = $editLink;
	        
	        // NOTE: delete link is same as edit link for an AdminBox
	        $activityFormLinks[ "del" ] = $editLink;
	
	/*[RAD_LINK_INSERT]*/
	
	        $parameters = array('PERSON_ID'=>$this->PERSON_ID, 'PROVINCE_ID'=>$this->PROVINCE_ID, 'GENDER_ID'=>$this->GENDER_ID, 'STAFF_ID'=>$this->STAFF_ID, 'REGION_ID'=>$this->REGION_ID, 'EMERG_ID'=>$this->EMERG_ID, 'ASSIGNSTATUS_ID'=>$this->ASSIGNSTATUS_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'ASSIGNMENT_ID'=>$this->ASSIGNMENT_ID, 'VIEWER_ID'=>$this->VIEWER_ID, 'ACCESS_ID'=>$this->ACCESS_ID, 'YEAR_ID'=>$this->YEAR_ID, 'PERSON_YEAR_ID'=>$this->PERSON_YEAR_ID, 'STAFFSCHEDULE_ID'=>$this->STAFFSCHEDULE_ID, 'STAFFACTIVITY_ID'=>$this->STAFFACTIVITY_ID, 'ACTIVITYTYPE_ID'=>$this->ACTIVITYTYPE_ID, 'STAFFSCHEDULETYPE_ID'=>$this->STAFFSCHEDULETYPE_ID, 'ACTIVITYSCHEDULE_ID'=>$this->ACTIVITYSCHEDULE_ID, 'FIELD_ID'=>$this->FIELD_ID, 'FIELDVALUE_ID'=>$this->FIELDVALUE_ID, 'FIELDTYPE_ID'=>$this->FIELDTYPE_ID, 'DATATYPE_ID'=>$this->DATATYPE_ID, 'COUNTRY_ID'=>$this->COUNTRY_ID);//[RAD_CALLBACK_PARAMS]
	        $sortByLink = $this->getCallBack( modulecim_hrdb::PAGE_EDITSTAFFSCHEDULE, '', $parameters );
	        $sortByLink .= "&".modulecim_hrdb::SORTBY."=";
	        $activityFormLinks["sortBy"] = $sortByLink;
	
	        $this->pageDisplay->setLinks( $links, $activityFormLinks );	    // $links, $basicFormLinks,   (DON'T NEED LINKS FOR SINGLE FORM PORTION) 
        }
        else
        {
	        $this->pageDisplay = new page_NotAuthorized($this->moduleRootPath, $this->viewer);  
        } 	           
           
    } // end loadEditStaffSchedule()


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
        // Edit My HRDB Form page is restricted to super admins
        if ($this->accessPrivManager->hasSitePriv() ) {	    
        
	        // compile a formAction for the adminBox
	        $parameters = array('PERSON_ID'=>$this->PERSON_ID, 'PROVINCE_ID'=>$this->PROVINCE_ID, 'GENDER_ID'=>$this->GENDER_ID, 'STAFF_ID'=>$this->STAFF_ID, 'REGION_ID'=>$this->REGION_ID, 'EMERG_ID'=>$this->EMERG_ID, 'ASSIGNSTATUS_ID'=>$this->ASSIGNSTATUS_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'ASSIGNMENT_ID'=>$this->ASSIGNMENT_ID, 'VIEWER_ID'=>$this->VIEWER_ID, 'ACCESS_ID'=>$this->ACCESS_ID, 'YEAR_ID'=>$this->YEAR_ID, 'PERSON_YEAR_ID'=>$this->PERSON_YEAR_ID, 'STAFFSCHEDULE_ID'=>$this->STAFFSCHEDULE_ID, 'STAFFACTIVITY_ID'=>$this->STAFFACTIVITY_ID, 'ACTIVITYTYPE_ID'=>$this->ACTIVITYTYPE_ID, 'STAFFSCHEDULETYPE_ID'=>$this->STAFFSCHEDULETYPE_ID, 'ACTIVITYSCHEDULE_ID'=>$this->ACTIVITYSCHEDULE_ID, 'FIELD_ID'=>$this->FIELD_ID, 'FIELDVALUE_ID'=>$this->FIELDVALUE_ID, 'FIELDTYPE_ID'=>$this->FIELDTYPE_ID, 'DATATYPE_ID'=>$this->DATATYPE_ID, 'COUNTRY_ID'=>$this->COUNTRY_ID);//[RAD_CALLBACK_PARAMS]
	        $formAction = $this->getCallBack(modulecim_hrdb::PAGE_EDITFORMFIELDS, $this->sortBy, $parameters );
	        
	        // set the pageCallBack value.  This is used by the Language switching
	        // code
	        $this->setPageCallBack( $formAction );
	        
	        // if this pageDisplay object isn't already created then 
	        if ( !$isCreated ) {
	        
	            // create a new pageDisplay object											 $fieldtype_id='', $staffscheduletype_id='', $datatypes_id='')
	            $this->pageDisplay = new FormProcessor_EditFormFields( $this->moduleRootPath, $this->viewer, $formAction, $this->sortBy,  $this->FIELD_ID, $this->STAFFSCHEDULETYPE_ID);//[RAD_FORMINIT_FOREIGNKEY_INIT]    
	        
	        } else {
	        
	            // otherwise just update the formAction value
	            $this->pageDisplay->setFormAction( $formAction );
	        }
	        
	        $links = array();
	        
	        $parameters = array('PERSON_ID'=>$this->PERSON_ID, 'PROVINCE_ID'=>$this->PROVINCE_ID, 'GENDER_ID'=>$this->GENDER_ID, 'STAFF_ID'=>$this->STAFF_ID, 'REGION_ID'=>$this->REGION_ID, 'EMERG_ID'=>$this->EMERG_ID, 'ASSIGNSTATUS_ID'=>$this->ASSIGNSTATUS_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'ASSIGNMENT_ID'=>$this->ASSIGNMENT_ID, 'VIEWER_ID'=>$this->VIEWER_ID, 'ACCESS_ID'=>$this->ACCESS_ID, 'YEAR_ID'=>$this->YEAR_ID, 'PERSON_YEAR_ID'=>$this->PERSON_YEAR_ID, 'STAFFSCHEDULE_ID'=>$this->STAFFSCHEDULE_ID, 'STAFFACTIVITY_ID'=>$this->STAFFACTIVITY_ID, 'ACTIVITYTYPE_ID'=>$this->ACTIVITYTYPE_ID, 'STAFFSCHEDULETYPE_ID'=>$this->STAFFSCHEDULETYPE_ID, 'ACTIVITYSCHEDULE_ID'=>$this->ACTIVITYSCHEDULE_ID, 'FIELD_ID'=>$this->FIELD_ID, 'FIELDVALUE_ID'=>$this->FIELDVALUE_ID, 'FIELDTYPE_ID'=>$this->FIELDTYPE_ID, 'DATATYPE_ID'=>$this->DATATYPE_ID, 'COUNTRY_ID'=>$this->COUNTRY_ID);//[RAD_CALLBACK_PARAMS]
	        $editLink = $this->getCallBack( modulecim_hrdb::PAGE_EDITFORMFIELDS, $this->sortBy, $parameters );
	        $editLink .= "&". modulecim_hrdb::FIELD_ID . "=";
	        $links[ "edit" ] = $editLink;
	        
	        // NOTE: delete link is same as edit link for an AdminBox
	        $links[ "del" ] = $editLink;
	
	/*[RAD_LINK_INSERT]*/
	
	        $parameters = array('PERSON_ID'=>$this->PERSON_ID, 'PROVINCE_ID'=>$this->PROVINCE_ID, 'GENDER_ID'=>$this->GENDER_ID, 'STAFF_ID'=>$this->STAFF_ID, 'REGION_ID'=>$this->REGION_ID, 'EMERG_ID'=>$this->EMERG_ID, 'ASSIGNSTATUS_ID'=>$this->ASSIGNSTATUS_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'ASSIGNMENT_ID'=>$this->ASSIGNMENT_ID, 'VIEWER_ID'=>$this->VIEWER_ID, 'ACCESS_ID'=>$this->ACCESS_ID, 'YEAR_ID'=>$this->YEAR_ID, 'PERSON_YEAR_ID'=>$this->PERSON_YEAR_ID, 'STAFFSCHEDULE_ID'=>$this->STAFFSCHEDULE_ID, 'STAFFACTIVITY_ID'=>$this->STAFFACTIVITY_ID, 'ACTIVITYTYPE_ID'=>$this->ACTIVITYTYPE_ID, 'STAFFSCHEDULETYPE_ID'=>$this->STAFFSCHEDULETYPE_ID, 'ACTIVITYSCHEDULE_ID'=>$this->ACTIVITYSCHEDULE_ID, 'FIELD_ID'=>$this->FIELD_ID, 'FIELDVALUE_ID'=>$this->FIELDVALUE_ID, 'FIELDTYPE_ID'=>$this->FIELDTYPE_ID, 'DATATYPE_ID'=>$this->DATATYPE_ID, 'COUNTRY_ID'=>$this->COUNTRY_ID);//[RAD_CALLBACK_PARAMS]
	        $sortByLink = $this->getCallBack( modulecim_hrdb::PAGE_EDITFORMFIELDS, '', $parameters );
	        $sortByLink .= "&".modulecim_hrdb::SORTBY."=";
	        $links["sortBy"] = $sortByLink;
	
	        $this->pageDisplay->setLinks( $links );    
        }
        else
        {
	        $this->pageDisplay = new page_NotAuthorized($this->moduleRootPath, $this->viewer);  
        }         
        
    } // end loadEditFormFields()



    //************************************************************************
	/**
	 * function loadEditStaffActivity
	 * <pre>
	 * Initializes the EditStaffActivity Page.
	 * </pre>
	 * @param $isCreated [BOOL] "Is THIS pageDisplay object already created?"
	 * @return [void]
	 */
    // RAD Tools: AdminBox Style
    function loadEditStaffActivity( $isCreated=false ) 
    {
        // Edit My HRDB Form page is restricted to staff and above
        if (( $this->accessPrivManager->hasSitePriv() ) || ( $this->accessPrivManager->isStaff($this->viewer->getID()) )) {        
	   	    
	        
	        // compile a formAction for the adminBox
	        $parameters = array('PERSON_ID'=>$this->PERSON_ID, 'PROVINCE_ID'=>$this->PROVINCE_ID, 'GENDER_ID'=>$this->GENDER_ID, 'STAFF_ID'=>$this->STAFF_ID, 'REGION_ID'=>$this->REGION_ID, 'EMERG_ID'=>$this->EMERG_ID, 'ASSIGNSTATUS_ID'=>$this->ASSIGNSTATUS_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'ASSIGNMENT_ID'=>$this->ASSIGNMENT_ID, 'VIEWER_ID'=>$this->VIEWER_ID, 'ACCESS_ID'=>$this->ACCESS_ID, 'YEAR_ID'=>$this->YEAR_ID, 'PERSON_YEAR_ID'=>$this->PERSON_YEAR_ID, 'STAFFSCHEDULE_ID'=>$this->STAFFSCHEDULE_ID, 'STAFFACTIVITY_ID'=>$this->STAFFACTIVITY_ID, 'ACTIVITYTYPE_ID'=>$this->ACTIVITYTYPE_ID, 'STAFFSCHEDULETYPE_ID'=>$this->STAFFSCHEDULETYPE_ID, 'ACTIVITYSCHEDULE_ID'=>$this->ACTIVITYSCHEDULE_ID, 'FIELD_ID'=>$this->FIELD_ID, 'FIELDVALUE_ID'=>$this->FIELDVALUE_ID, 'FIELDTYPE_ID'=>$this->FIELDTYPE_ID, 'DATATYPE_ID'=>$this->DATATYPE_ID, 'COUNTRY_ID'=>$this->COUNTRY_ID, 'FIELDGROUP_ID'=>$this->FIELDGROUP_ID, 'FIELDGROUP_MATCHES_ID'=>$this->FIELDGROUP_MATCHES_ID);//[RAD_CALLBACK_PARAMS]
	        $formAction = $this->getCallBack(modulecim_hrdb::PAGE_EDITSTAFFACTIVITY, $this->sortBy, $parameters );
	        
	        // set the pageCallBack value.  This is used by the Language switching
	        // code
	        $this->setPageCallBack( $formAction );
	        
	        // if this pageDisplay object isn't already created then 
	        if ( !$isCreated ) {
	      
		        $disableHeading = true;
	        
	            // create a new pageDisplay object
	            $this->pageDisplay = new FormProcessor_EditStaffActivity( $this->moduleRootPath, $this->viewer, $formAction, $this->sortBy,  $this->STAFFACTIVITY_ID, $this->PERSON_ID, $this->STAFFSCHEDULETYPE_ID, $this->STAFFSCHEDULE_ID, $this->ACTIVITYTYPE_ID, $disableHeading);//[RAD_FORMINIT_FOREIGNKEY_INIT]    
	
	        } else {
	        
	            // otherwise just update the formAction value
	            $this->pageDisplay->setFormAction( $formAction );
	        }
	        
	//         $links = array();
	//         
	//         $parameters = array( );//[RAD_CALLBACK_PARAMS_EDIT]
	//         $editLink = $this->getCallBack( modulecim_hrdb::PAGE_EDITSTAFFACTIVITY, $this->sortBy, $parameters );
	//         $editLink .= "&". modulecim_hrdb::STAFFACTIVITY_ID . "=";
	//         $links[ "edit" ] = $editLink;
	//         
	//         // NOTE: delete link is same as edit link for an AdminBox
	//         $links[ "del" ] = $editLink;
	
	// /*[RAD_LINK_INSERT]*/
	
	//         $parameters = array('PERSON_ID'=>$this->PERSON_ID, 'PROVINCE_ID'=>$this->PROVINCE_ID, 'GENDER_ID'=>$this->GENDER_ID, 'STAFF_ID'=>$this->STAFF_ID, 'REGION_ID'=>$this->REGION_ID, 'EMERG_ID'=>$this->EMERG_ID, 'ASSIGNSTATUS_ID'=>$this->ASSIGNSTATUS_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'ASSIGNMENT_ID'=>$this->ASSIGNMENT_ID, 'VIEWER_ID'=>$this->VIEWER_ID, 'ACCESS_ID'=>$this->ACCESS_ID, 'YEAR_ID'=>$this->YEAR_ID, 'PERSON_YEAR_ID'=>$this->PERSON_YEAR_ID, 'STAFFSCHEDULE_ID'=>$this->STAFFSCHEDULE_ID, 'STAFFACTIVITY_ID'=>$this->STAFFACTIVITY_ID, 'ACTIVITYTYPE_ID'=>$this->ACTIVITYTYPE_ID, 'STAFFSCHEDULETYPE_ID'=>$this->STAFFSCHEDULETYPE_ID, 'ACTIVITYSCHEDULE_ID'=>$this->ACTIVITYSCHEDULE_ID, 'FIELD_ID'=>$this->FIELD_ID, 'FIELDVALUE_ID'=>$this->FIELDVALUE_ID, 'FIELDTYPE_ID'=>$this->FIELDTYPE_ID, 'DATATYPE_ID'=>$this->DATATYPE_ID, 'COUNTRY_ID'=>$this->COUNTRY_ID, 'FIELDGROUP_ID'=>$this->FIELDGROUP_ID, 'FIELDGROUP_MATCHES_ID'=>$this->FIELDGROUP_MATCHES_ID);//[RAD_CALLBACK_PARAMS]
	//         $sortByLink = $this->getCallBack( modulecim_hrdb::PAGE_EDITSTAFFACTIVITY, '', $parameters );
	//         $sortByLink .= "&".modulecim_hrdb::SORTBY."=";
	//         $links["sortBy"] = $sortByLink;
	
	//         $this->pageDisplay->setLinks( $links ); 
	
        }
        else
        {
	        $this->pageDisplay = new page_NotAuthorized($this->moduleRootPath, $this->viewer);  
        }               
        
    } // end loadEditStaffActivity()


    //************************************************************************
	/**
	 * function loadApproveStaffSchedule
	 * <pre>
	 * Initializes the loadApproveStaffSchedule Page.
	 * </pre>
	 * @return [void]
	 */
    // RAD Tools: FormSingleEntry style
    function loadApproveStaffSchedule($isCreated = false) 
    {
	    
        // GROUP 2: STAFF AND ABOVE ONLY.   (approve HRDB form)
        if ((( $this->accessPrivManager->hasSitePriv() ) || ( $this->accessPrivManager->isStaff($this->viewer->getID()) )) ){	    
	    
	   
	        // set the pageCallBack to be without any additional parameters
	        // (an AdminBox needs this so Language Switching on a page doesn't
	        // pass a previous operations)
	        $parameters = array('PERSON_ID'=>$this->PERSON_ID, 'PROVINCE_ID'=>$this->PROVINCE_ID, 'GENDER_ID'=>$this->GENDER_ID, 'STAFF_ID'=>$this->STAFF_ID, 'REGION_ID'=>$this->REGION_ID, 'EMERG_ID'=>$this->EMERG_ID, 'ASSIGNSTATUS_ID'=>$this->ASSIGNSTATUS_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'ASSIGNMENT_ID'=>$this->ASSIGNMENT_ID, 'VIEWER_ID'=>$this->VIEWER_ID, 'ACCESS_ID'=>$this->ACCESS_ID, 'YEAR_ID'=>$this->YEAR_ID, 'PERSON_YEAR_ID'=>$this->PERSON_YEAR_ID, 'STAFFSCHEDULE_ID'=>$this->STAFFSCHEDULE_ID, 'STAFFACTIVITY_ID'=>$this->STAFFACTIVITY_ID, 'ACTIVITYTYPE_ID'=>$this->ACTIVITYTYPE_ID, 'STAFFSCHEDULETYPE_ID'=>$this->STAFFSCHEDULETYPE_ID, 'ACTIVITYSCHEDULE_ID'=>$this->ACTIVITYSCHEDULE_ID, 'FIELD_ID'=>$this->FIELD_ID, 'FIELDVALUE_ID'=>$this->FIELDVALUE_ID, 'FIELDTYPE_ID'=>$this->FIELDTYPE_ID, 'DATATYPE_ID'=>$this->DATATYPE_ID, 'COUNTRY_ID'=>$this->COUNTRY_ID);//[RAD_CALLBACK_PARAMS]
	        $pageCallBack = $this->getCallBack(modulecim_hrdb::PAGE_APPROVESTAFFSCHEDULE, $this->sortBy, $parameters);
	        $this->setPageCallBack( $pageCallBack );       
	               
	        
	        $parameters = array('PERSON_ID'=>$this->PERSON_ID, 'PROVINCE_ID'=>$this->PROVINCE_ID, 'GENDER_ID'=>$this->GENDER_ID, 'STAFF_ID'=>$this->STAFF_ID, 'REGION_ID'=>$this->REGION_ID, 'EMERG_ID'=>$this->EMERG_ID, 'ASSIGNSTATUS_ID'=>$this->ASSIGNSTATUS_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'ASSIGNMENT_ID'=>$this->ASSIGNMENT_ID, 'VIEWER_ID'=>$this->VIEWER_ID, 'ACCESS_ID'=>$this->ACCESS_ID, 'YEAR_ID'=>$this->YEAR_ID, 'PERSON_YEAR_ID'=>$this->PERSON_YEAR_ID, 'STAFFSCHEDULE_ID'=>$this->STAFFSCHEDULE_ID, 'STAFFACTIVITY_ID'=>$this->STAFFACTIVITY_ID, 'ACTIVITYTYPE_ID'=>$this->ACTIVITYTYPE_ID, 'STAFFSCHEDULETYPE_ID'=>$this->STAFFSCHEDULETYPE_ID, 'ACTIVITYSCHEDULE_ID'=>$this->ACTIVITYSCHEDULE_ID, 'FIELD_ID'=>$this->FIELD_ID, 'FIELDVALUE_ID'=>$this->FIELDVALUE_ID, 'FIELDTYPE_ID'=>$this->FIELDTYPE_ID, 'DATATYPE_ID'=>$this->DATATYPE_ID, 'COUNTRY_ID'=>$this->COUNTRY_ID);//[RAD_CALLBACK_PARAMS]
	        $basic_form_parameters = array('PERSON_ID'=>$this->PERSON_ID, 'STAFF_ID'=>$this->STAFF_ID, 'ASSIGNSTATUS_ID'=>$this->ASSIGNSTATUS_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'ASSIGNMENT_ID'=>$this->ASSIGNMENT_ID, 'VIEWER_ID'=>$this->VIEWER_ID, 'ACCESS_ID'=>$this->ACCESS_ID, 'STAFFSCHEDULE_ID'=>$this->STAFFSCHEDULE_ID, 'STAFFSCHEDULETYPE_ID'=>$this->STAFFSCHEDULETYPE_ID, 'FIELD_ID'=>$this->FIELD_ID, 'FIELDVALUE_ID'=>$this->FIELDVALUE_ID);//[RAD_CALLBACK_PARAMS]
	        $activity_form_parameters = array('PERSON_ID'=>$this->PERSON_ID, 'STAFF_ID'=>$this->STAFF_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'ASSIGNMENT_ID'=>$this->ASSIGNMENT_ID, 'VIEWER_ID'=>$this->VIEWER_ID, 'ACCESS_ID'=>$this->ACCESS_ID, 'STAFFSCHEDULE_ID'=>$this->STAFFSCHEDULE_ID, 'STAFFACTIVITY_ID'=>$this->STAFFACTIVITY_ID, 'ACTIVITYTYPE_ID'=>$this->ACTIVITYTYPE_ID, 'STAFFSCHEDULETYPE_ID'=>$this->STAFFSCHEDULETYPE_ID, 'ACTIVITYSCHEDULE_ID'=>$this->ACTIVITYSCHEDULE_ID);//[RAD_CALLBACK_PARAMS]
	      
	        $formAction = $this->getCallBack(modulecim_hrdb::PAGE_APPROVESTAFFSCHEDULE, $this->sortBy, $parameters );
	        $basicFormAction = $this->getCallBack(modulecim_hrdb::PAGE_APPROVESTAFFSCHEDULE, $this->sortBy, $basic_form_parameters );
	        $activityFormAction = $this->getCallBack(modulecim_hrdb::PAGE_APPROVESTAFFSCHEDULE, $this->sortBy, $activity_form_parameters );
	
	        $pageCallBack = $this->getCallBack(modulecim_hrdb::PAGE_APPROVESTAFFSCHEDULE, $this->sortBy, $parameters);
	        $this->setPageCallBack( $pageCallBack );     
	 
	        // if this pageDisplay object isn't already created then 
	//         if ( !$isCreated ) {
	// 	        $disableHeading = false;
	// 	        $showActivityForm = true;
		        $showHidden = false;		// TODO: create condition for this based on privilege level
	            // create a new pageDisplay object										  
	        		$this->pageDisplay = new FormProcessor_ApproveStaffSchedule( $this->moduleRootPath, $this->viewer, $formAction, $basicFormAction, $activityFormAction, $this->sortBy, $this->PERSON_ID, $this->STAFFSCHEDULETYPE_ID, $this->STAFFSCHEDULE_ID, $this->FIELDVALUE_ID, $this->FIELD_ID, $this->STAFFACTIVITY_ID, $showHidden);//[RAD_FORMINIT_FOREIGNKEY_INIT]        
	
	//         } else {
	//         
	//             // otherwise just update the formAction value
	//             $this->pageDisplay->setFormAction( $formAction, $basicFormAction, $activityFormAction);
	//         }   
	        
	        $links = array();
	        $continueLink = $this->getCallBack( modulecim_hrdb::PAGE_FORMAPPROVALLISTING, "", $parameters );
	        $links["cont"] = $continueLink;	        
	        
	         /**** ACTIVITY FORM SUB-PAGE LINKS INIT ***/
	        $activityFormLinks = array(); 
	         
	//         $parameters = array('PERSON_ID'=>$this->PERSON_ID, 'PROVINCE_ID'=>$this->PROVINCE_ID, 'GENDER_ID'=>$this->GENDER_ID, 'STAFF_ID'=>$this->STAFF_ID, 'REGION_ID'=>$this->REGION_ID, 'EMERG_ID'=>$this->EMERG_ID, 'ASSIGNSTATUS_ID'=>$this->ASSIGNSTATUS_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'ASSIGNMENT_ID'=>$this->ASSIGNMENT_ID, 'VIEWER_ID'=>$this->VIEWER_ID, 'ACCESS_ID'=>$this->ACCESS_ID, 'YEAR_ID'=>$this->YEAR_ID, 'PERSON_YEAR_ID'=>$this->PERSON_YEAR_ID, 'STAFFSCHEDULE_ID'=>$this->STAFFSCHEDULE_ID, 'STAFFACTIVITY_ID'=>$this->STAFFACTIVITY_ID, 'ACTIVITYTYPE_ID'=>$this->ACTIVITYTYPE_ID, 'STAFFSCHEDULETYPE_ID'=>$this->STAFFSCHEDULETYPE_ID, 'ACTIVITYSCHEDULE_ID'=>$this->ACTIVITYSCHEDULE_ID, 'FIELD_ID'=>$this->FIELD_ID, 'FIELDVALUE_ID'=>$this->FIELDVALUE_ID, 'FIELDTYPE_ID'=>$this->FIELDTYPE_ID, 'DATATYPE_ID'=>$this->DATATYPE_ID, 'COUNTRY_ID'=>$this->COUNTRY_ID);//[RAD_CALLBACK_PARAMS]
	//         $editLink = $this->getCallBack( modulecim_hrdb::PAGE_APPROVESTAFFSCHEDULE, $this->sortBy, $parameters );
	//         $editLink .= "&". modulecim_hrdb::STAFFACTIVITY_ID . "=";
	//         $activityFormLinks[ "edit" ] = $editLink;
	//         
	//         // NOTE: delete link is same as edit link for an AdminBox
	//         $activityFormLinks[ "del" ] = $editLink;
	
	/*[RAD_LINK_INSERT]*/
	
	        $parameters = array('PERSON_ID'=>$this->PERSON_ID, 'PROVINCE_ID'=>$this->PROVINCE_ID, 'GENDER_ID'=>$this->GENDER_ID, 'STAFF_ID'=>$this->STAFF_ID, 'REGION_ID'=>$this->REGION_ID, 'EMERG_ID'=>$this->EMERG_ID, 'ASSIGNSTATUS_ID'=>$this->ASSIGNSTATUS_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'ASSIGNMENT_ID'=>$this->ASSIGNMENT_ID, 'VIEWER_ID'=>$this->VIEWER_ID, 'ACCESS_ID'=>$this->ACCESS_ID, 'YEAR_ID'=>$this->YEAR_ID, 'PERSON_YEAR_ID'=>$this->PERSON_YEAR_ID, 'STAFFSCHEDULE_ID'=>$this->STAFFSCHEDULE_ID, 'STAFFACTIVITY_ID'=>$this->STAFFACTIVITY_ID, 'ACTIVITYTYPE_ID'=>$this->ACTIVITYTYPE_ID, 'STAFFSCHEDULETYPE_ID'=>$this->STAFFSCHEDULETYPE_ID, 'ACTIVITYSCHEDULE_ID'=>$this->ACTIVITYSCHEDULE_ID, 'FIELD_ID'=>$this->FIELD_ID, 'FIELDVALUE_ID'=>$this->FIELDVALUE_ID, 'FIELDTYPE_ID'=>$this->FIELDTYPE_ID, 'DATATYPE_ID'=>$this->DATATYPE_ID, 'COUNTRY_ID'=>$this->COUNTRY_ID);//[RAD_CALLBACK_PARAMS]
	        $sortByLink = $this->getCallBack( modulecim_hrdb::PAGE_APPROVESTAFFSCHEDULE, '', $parameters );
	        $sortByLink .= "&".modulecim_hrdb::SORTBY."=";
	        $activityFormLinks["sortBy"] = $sortByLink;
	
	        $this->pageDisplay->setLinks( $links, $activityFormLinks );	    // $links, $basicFormLinks,   (DON'T NEED LINKS FOR SINGLE FORM PORTION) 

        }
        else
        {
	        $this->pageDisplay = new page_NotAuthorized($this->moduleRootPath, $this->viewer);  
        }  	        
	           
           
    } // end loadApproveStaffSchedule()

    //************************************************************************
	/**
	 * function loadApproveStaffSchedule
	 * <pre>
	 * Initializes the ApproveStaffSchedule Page.
	 * </pre>
	 * @param $isCreated [BOOL] "Is THIS pageDisplay object already created?"
	 * @return [void]
	 */
    // RAD Tools: AdminBox Style
/*    function loadApproveStaffSchedule( $isCreated=false ) 
    {
        
        // compile a formAction for the adminBox
        $parameters = array('PERSON_ID'=>$this->PERSON_ID, 'PROVINCE_ID'=>$this->PROVINCE_ID, 'GENDER_ID'=>$this->GENDER_ID, 'STAFF_ID'=>$this->STAFF_ID, 'REGION_ID'=>$this->REGION_ID, 'EMERG_ID'=>$this->EMERG_ID, 'ASSIGNSTATUS_ID'=>$this->ASSIGNSTATUS_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'ASSIGNMENT_ID'=>$this->ASSIGNMENT_ID, 'VIEWER_ID'=>$this->VIEWER_ID, 'ACCESS_ID'=>$this->ACCESS_ID, 'YEAR_ID'=>$this->YEAR_ID, 'PERSON_YEAR_ID'=>$this->PERSON_YEAR_ID, 'STAFFSCHEDULE_ID'=>$this->STAFFSCHEDULE_ID, 'STAFFACTIVITY_ID'=>$this->STAFFACTIVITY_ID, 'ACTIVITYTYPE_ID'=>$this->ACTIVITYTYPE_ID, 'STAFFSCHEDULETYPE_ID'=>$this->STAFFSCHEDULETYPE_ID, 'ACTIVITYSCHEDULE_ID'=>$this->ACTIVITYSCHEDULE_ID, 'FIELD_ID'=>$this->FIELD_ID, 'FIELDVALUE_ID'=>$this->FIELDVALUE_ID, 'FIELDTYPE_ID'=>$this->FIELDTYPE_ID, 'DATATYPE_ID'=>$this->DATATYPE_ID, 'COUNTRY_ID'=>$this->COUNTRY_ID, 'FIELDGROUP_ID'=>$this->FIELDGROUP_ID, 'FIELDGROUP_MATCHES_ID'=>$this->FIELDGROUP_MATCHES_ID);//[RAD_CALLBACK_PARAMS]
        $formAction = $this->getCallBack(modulecim_hrdb::PAGE_APPROVESTAFFSCHEDULE, $this->sortBy, $parameters );
        
        // set the pageCallBack value.  This is used by the Language switching
        // code
        $this->setPageCallBack( $formAction );
        
        // if this pageDisplay object isn't already created then 
//         if ( !$isCreated ) {
        
            // create a new pageDisplay object
            $this->pageDisplay = new FormProcessor_ApproveStaffSchedule( $this->moduleRootPath, $this->viewer, $formAction, $this->sortBy, $this->STAFFSCHEDULE_ID, $this->STAFFSCHEDULETYPE_ID , $this->PERSON_ID);//[RAD_FORMINIT_FOREIGNKEY_INIT]    
//         
//         } else {
//         
//             // otherwise just update the formAction value
//             $this->pageDisplay->setFormAction( $formAction );
//         }
        
        $links = array();
        
        $parameters = array('PERSON_ID'=>$this->PERSON_ID, 'PROVINCE_ID'=>$this->PROVINCE_ID, 'GENDER_ID'=>$this->GENDER_ID, 'STAFF_ID'=>$this->STAFF_ID, 'REGION_ID'=>$this->REGION_ID, 'EMERG_ID'=>$this->EMERG_ID, 'ASSIGNSTATUS_ID'=>$this->ASSIGNSTATUS_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'ASSIGNMENT_ID'=>$this->ASSIGNMENT_ID, 'VIEWER_ID'=>$this->VIEWER_ID, 'ACCESS_ID'=>$this->ACCESS_ID, 'YEAR_ID'=>$this->YEAR_ID, 'PERSON_YEAR_ID'=>$this->PERSON_YEAR_ID, 'STAFFSCHEDULE_ID'=>$this->STAFFSCHEDULE_ID, 'STAFFACTIVITY_ID'=>$this->STAFFACTIVITY_ID, 'ACTIVITYTYPE_ID'=>$this->ACTIVITYTYPE_ID, 'STAFFSCHEDULETYPE_ID'=>$this->STAFFSCHEDULETYPE_ID, 'ACTIVITYSCHEDULE_ID'=>$this->ACTIVITYSCHEDULE_ID, 'FIELD_ID'=>$this->FIELD_ID, 'FIELDVALUE_ID'=>$this->FIELDVALUE_ID, 'FIELDTYPE_ID'=>$this->FIELDTYPE_ID, 'DATATYPE_ID'=>$this->DATATYPE_ID, 'COUNTRY_ID'=>$this->COUNTRY_ID, 'FIELDGROUP_ID'=>$this->FIELDGROUP_ID, 'FIELDGROUP_MATCHES_ID'=>$this->FIELDGROUP_MATCHES_ID);//[RAD_CALLBACK_PARAMS]
        $editLink = $this->getCallBack( modulecim_hrdb::PAGE_APPROVESTAFFSCHEDULE, $this->sortBy, $parameters );
        $editLink .= "&". modulecim_hrdb::STAFFSCHEDULE_ID . "=";
        $links[ "edit" ] = $editLink;
        
        // NOTE: delete link is same as edit link for an AdminBox
        $links[ "del" ] = $editLink;

/*[RAD_LINK_INSERT]*//*

        $parameters = array('PERSON_ID'=>$this->PERSON_ID, 'PROVINCE_ID'=>$this->PROVINCE_ID, 'GENDER_ID'=>$this->GENDER_ID, 'STAFF_ID'=>$this->STAFF_ID, 'REGION_ID'=>$this->REGION_ID, 'EMERG_ID'=>$this->EMERG_ID, 'ASSIGNSTATUS_ID'=>$this->ASSIGNSTATUS_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'ASSIGNMENT_ID'=>$this->ASSIGNMENT_ID, 'VIEWER_ID'=>$this->VIEWER_ID, 'ACCESS_ID'=>$this->ACCESS_ID, 'YEAR_ID'=>$this->YEAR_ID, 'PERSON_YEAR_ID'=>$this->PERSON_YEAR_ID, 'STAFFSCHEDULE_ID'=>$this->STAFFSCHEDULE_ID, 'STAFFACTIVITY_ID'=>$this->STAFFACTIVITY_ID, 'ACTIVITYTYPE_ID'=>$this->ACTIVITYTYPE_ID, 'STAFFSCHEDULETYPE_ID'=>$this->STAFFSCHEDULETYPE_ID, 'ACTIVITYSCHEDULE_ID'=>$this->ACTIVITYSCHEDULE_ID, 'FIELD_ID'=>$this->FIELD_ID, 'FIELDVALUE_ID'=>$this->FIELDVALUE_ID, 'FIELDTYPE_ID'=>$this->FIELDTYPE_ID, 'DATATYPE_ID'=>$this->DATATYPE_ID, 'COUNTRY_ID'=>$this->COUNTRY_ID, 'FIELDGROUP_ID'=>$this->FIELDGROUP_ID, 'FIELDGROUP_MATCHES_ID'=>$this->FIELDGROUP_MATCHES_ID);//[RAD_CALLBACK_PARAMS]
        $sortByLink = $this->getCallBack( modulecim_hrdb::PAGE_APPROVESTAFFSCHEDULE, '', $parameters );
        $sortByLink .= "&".modulecim_hrdb::SORTBY."=";
        $links["sortBy"] = $sortByLink;

        $this->pageDisplay->setLinks( $links );    
        
    } // end loadApproveStaffSchedule()

*/

    //************************************************************************
	/**
	 * function loadFormApprovalListing
	 * <pre>
	 * Initializes the FormApprovalListing Page.
	 * </pre>
	 * @return [void]
	 */
    // RAD Tools: DataListTable Style
    function loadFormApprovalListing() 
    {
        // GROUP 2: STAFF AND ABOVE ONLY.   (approve HRDB form listing )
        if ((( $this->accessPrivManager->hasSitePriv() ) || ( $this->accessPrivManager->isStaff($this->viewer->getID()) )) ){	    
	    	    	    
	        // set the pageCallBack to be without any additional parameters
	        // (an AdminBox needs this so Language Switching on a page doesn't
	        // pass a previous operations)
	        $parameters = array('PERSON_ID'=>$this->PERSON_ID, 'PROVINCE_ID'=>$this->PROVINCE_ID, 'GENDER_ID'=>$this->GENDER_ID, 'STAFF_ID'=>$this->STAFF_ID, 'REGION_ID'=>$this->REGION_ID, 'EMERG_ID'=>$this->EMERG_ID, 'ASSIGNSTATUS_ID'=>$this->ASSIGNSTATUS_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'ASSIGNMENT_ID'=>$this->ASSIGNMENT_ID, 'VIEWER_ID'=>$this->VIEWER_ID, 'ACCESS_ID'=>$this->ACCESS_ID, 'YEAR_ID'=>$this->YEAR_ID, 'PERSON_YEAR_ID'=>$this->PERSON_YEAR_ID, 'STAFFSCHEDULE_ID'=>$this->STAFFSCHEDULE_ID, 'STAFFACTIVITY_ID'=>$this->STAFFACTIVITY_ID, 'ACTIVITYTYPE_ID'=>$this->ACTIVITYTYPE_ID, 'STAFFSCHEDULETYPE_ID'=>$this->STAFFSCHEDULETYPE_ID, 'ACTIVITYSCHEDULE_ID'=>$this->ACTIVITYSCHEDULE_ID, 'FIELD_ID'=>$this->FIELD_ID, 'FIELDVALUE_ID'=>$this->FIELDVALUE_ID, 'FIELDTYPE_ID'=>$this->FIELDTYPE_ID, 'DATATYPE_ID'=>$this->DATATYPE_ID, 'COUNTRY_ID'=>$this->COUNTRY_ID, 'FIELDGROUP_ID'=>$this->FIELDGROUP_ID, 'FIELDGROUP_MATCHES_ID'=>$this->FIELDGROUP_MATCHES_ID);//[RAD_CALLBACK_PARAMS]
	        $pageCallBack = $this->getCallBack(modulecim_hrdb::PAGE_FORMAPPROVALLISTING, $this->sortBy, $parameters);
	        $this->setPageCallBack( $pageCallBack );
	        
	        
	        $this->pageDisplay = new page_FormApprovalListing( $this->moduleRootPath, $this->viewer, $this->sortBy, $this->STAFFSCHEDULETYPE_ID );    
	        
	        $links = array();
	        
	/*[RAD_LINK_INSERT]*/
	
	        $parameters = array( 'PERSON_ID'=>$this->PERSON_ID,'STAFFSCHEDULETYPE_ID'=>$this->STAFFSCHEDULETYPE_ID,'STAFFSCHEDULE_ID'=>$this->STAFFSCHEDULE_ID);//[RAD_CALLBACK_PARAMS_EDIT]
	        $viewLink = $this->getCallBack( modulecim_hrdb::PAGE_APPROVESTAFFSCHEDULE, $this->sortBy, $parameters );
	        $viewLink .= "&". modulecim_hrdb::STAFFSCHEDULE_ID . "=";
	        $links["view"] = $viewLink;			
	
	        $parameters = array('PERSON_ID'=>$this->PERSON_ID, 'PROVINCE_ID'=>$this->PROVINCE_ID, 'GENDER_ID'=>$this->GENDER_ID, 'STAFF_ID'=>$this->STAFF_ID, 'REGION_ID'=>$this->REGION_ID, 'EMERG_ID'=>$this->EMERG_ID, 'ASSIGNSTATUS_ID'=>$this->ASSIGNSTATUS_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'ASSIGNMENT_ID'=>$this->ASSIGNMENT_ID, 'VIEWER_ID'=>$this->VIEWER_ID, 'ACCESS_ID'=>$this->ACCESS_ID, 'YEAR_ID'=>$this->YEAR_ID, 'PERSON_YEAR_ID'=>$this->PERSON_YEAR_ID, 'STAFFSCHEDULE_ID'=>$this->STAFFSCHEDULE_ID, 'STAFFACTIVITY_ID'=>$this->STAFFACTIVITY_ID, 'ACTIVITYTYPE_ID'=>$this->ACTIVITYTYPE_ID, 'STAFFSCHEDULETYPE_ID'=>$this->STAFFSCHEDULETYPE_ID, 'ACTIVITYSCHEDULE_ID'=>$this->ACTIVITYSCHEDULE_ID, 'FIELD_ID'=>$this->FIELD_ID, 'FIELDVALUE_ID'=>$this->FIELDVALUE_ID, 'FIELDTYPE_ID'=>$this->FIELDTYPE_ID, 'DATATYPE_ID'=>$this->DATATYPE_ID, 'COUNTRY_ID'=>$this->COUNTRY_ID, 'FIELDGROUP_ID'=>$this->FIELDGROUP_ID, 'FIELDGROUP_MATCHES_ID'=>$this->FIELDGROUP_MATCHES_ID);//[RAD_CALLBACK_PARAMS]
	        $sortByLink = $this->getCallBack( modulecim_hrdb::PAGE_FORMAPPROVALLISTING, '', $parameters );
	        $sortByLink .= "&".modulecim_hrdb::SORTBY."=";
	        $links["sortBy"] = $sortByLink;
	
	        $this->pageDisplay->setLinks( $links ); 
        }
        else
        {
	        $this->pageDisplay = new page_NotAuthorized($this->moduleRootPath, $this->viewer);  
        }  	        
        
    } // end loadFormApprovalListing()



    //************************************************************************
	/**
	 * function loadEditStaffFormContext
	 * <pre>
	 * Initializes the EditStaffFormContext Page.
	 * </pre>
	 * @return [void]
	 */
    // RAD Tools: FormSingleEntry style
    function loadEditStaffFormContext() 
    {
        // GROUP 3: SUPER ADMINS ONLY. 
        if ( $this->accessPrivManager->hasSitePriv() ){	    
		    	    
	        // set the pageCallBack to be without any additional parameters
	        // (an AdminBox needs this so Language Switching on a page doesn't
	        // pass a previous operations)
	        $parameters = array('PERSON_ID'=>$this->PERSON_ID, 'PROVINCE_ID'=>$this->PROVINCE_ID, 'GENDER_ID'=>$this->GENDER_ID, 'STAFF_ID'=>$this->STAFF_ID, 'REGION_ID'=>$this->REGION_ID, 'EMERG_ID'=>$this->EMERG_ID, 'ASSIGNSTATUS_ID'=>$this->ASSIGNSTATUS_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'ASSIGNMENT_ID'=>$this->ASSIGNMENT_ID, 'VIEWER_ID'=>$this->VIEWER_ID, 'ACCESS_ID'=>$this->ACCESS_ID, 'YEAR_ID'=>$this->YEAR_ID, 'PERSON_YEAR_ID'=>$this->PERSON_YEAR_ID, 'STAFFSCHEDULE_ID'=>$this->STAFFSCHEDULE_ID, 'STAFFACTIVITY_ID'=>$this->STAFFACTIVITY_ID, 'ACTIVITYTYPE_ID'=>$this->ACTIVITYTYPE_ID, 'STAFFSCHEDULETYPE_ID'=>$this->STAFFSCHEDULETYPE_ID, 'ACTIVITYSCHEDULE_ID'=>$this->ACTIVITYSCHEDULE_ID, 'FIELD_ID'=>$this->FIELD_ID, 'FIELDVALUE_ID'=>$this->FIELDVALUE_ID, 'FIELDTYPE_ID'=>$this->FIELDTYPE_ID, 'DATATYPE_ID'=>$this->DATATYPE_ID, 'COUNTRY_ID'=>$this->COUNTRY_ID, 'FIELDGROUP_ID'=>$this->FIELDGROUP_ID, 'FIELDGROUP_MATCHES_ID'=>$this->FIELDGROUP_MATCHES_ID);//[RAD_CALLBACK_PARAMS]
	        $pageCallBack = $this->getCallBack(modulecim_hrdb::PAGE_EDITSTAFFFORMCONTEXT, $this->sortBy, $parameters);
	        $this->setPageCallBack( $pageCallBack );
	        
	        
	        $parameters = array('PERSON_ID'=>$this->PERSON_ID, 'PROVINCE_ID'=>$this->PROVINCE_ID, 'GENDER_ID'=>$this->GENDER_ID, 'STAFF_ID'=>$this->STAFF_ID, 'REGION_ID'=>$this->REGION_ID, 'EMERG_ID'=>$this->EMERG_ID, 'ASSIGNSTATUS_ID'=>$this->ASSIGNSTATUS_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'ASSIGNMENT_ID'=>$this->ASSIGNMENT_ID, 'VIEWER_ID'=>$this->VIEWER_ID, 'ACCESS_ID'=>$this->ACCESS_ID, 'YEAR_ID'=>$this->YEAR_ID, 'PERSON_YEAR_ID'=>$this->PERSON_YEAR_ID, 'STAFFSCHEDULE_ID'=>$this->STAFFSCHEDULE_ID, 'STAFFACTIVITY_ID'=>$this->STAFFACTIVITY_ID, 'ACTIVITYTYPE_ID'=>$this->ACTIVITYTYPE_ID, 'STAFFSCHEDULETYPE_ID'=>$this->STAFFSCHEDULETYPE_ID, 'ACTIVITYSCHEDULE_ID'=>$this->ACTIVITYSCHEDULE_ID, 'FIELD_ID'=>$this->FIELD_ID, 'FIELDVALUE_ID'=>$this->FIELDVALUE_ID, 'FIELDTYPE_ID'=>$this->FIELDTYPE_ID, 'DATATYPE_ID'=>$this->DATATYPE_ID, 'COUNTRY_ID'=>$this->COUNTRY_ID, 'FIELDGROUP_ID'=>$this->FIELDGROUP_ID, 'FIELDGROUP_MATCHES_ID'=>$this->FIELDGROUP_MATCHES_ID);//[RAD_CALLBACK_PARAMS]
	        $formAction = $this->getCallBack(modulecim_hrdb::PAGE_EDITSTAFFFORMCONTEXT, $this->sortBy, $parameters );
	        $this->pageDisplay = new FormProcessor_EditStaffFormContext( $this->moduleRootPath, $this->viewer, $formAction, $this->STAFFSCHEDULETYPE_ID );//[RAD_FORMINIT_FOREIGNKEY_INIT]        
        }
        else
        {
	        $this->pageDisplay = new page_NotAuthorized($this->moduleRootPath, $this->viewer);  
        } 

	        	        
    } // end loadEditStaffFormContext()



    //************************************************************************
	/**
	 * function loadEditStaffFormInstructions
	 * <pre>
	 * Initializes the EditStaffFormInstructions Page.
	 * </pre>
	 * @return [void]
	 */
    // RAD Tools: FormSingleEntry style
    function loadEditStaffFormInstructions() 	// NOTE: this is not called much, since this is a sub-page
    {
        // GROUP 3: SUPER ADMINS ONLY. 
        if ( $this->accessPrivManager->hasSitePriv() ){	  	    
	    
	        // set the pageCallBack to be without any additional parameters
	        // (an AdminBox needs this so Language Switching on a page doesn't
	        // pass a previous operations)
	        $parameters = array('PERSON_ID'=>$this->PERSON_ID, 'PROVINCE_ID'=>$this->PROVINCE_ID, 'GENDER_ID'=>$this->GENDER_ID, 'STAFF_ID'=>$this->STAFF_ID, 'REGION_ID'=>$this->REGION_ID, 'EMERG_ID'=>$this->EMERG_ID, 'ASSIGNSTATUS_ID'=>$this->ASSIGNSTATUS_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'ASSIGNMENT_ID'=>$this->ASSIGNMENT_ID, 'VIEWER_ID'=>$this->VIEWER_ID, 'ACCESS_ID'=>$this->ACCESS_ID, 'YEAR_ID'=>$this->YEAR_ID, 'PERSON_YEAR_ID'=>$this->PERSON_YEAR_ID, 'STAFFSCHEDULE_ID'=>$this->STAFFSCHEDULE_ID, 'STAFFACTIVITY_ID'=>$this->STAFFACTIVITY_ID, 'ACTIVITYTYPE_ID'=>$this->ACTIVITYTYPE_ID, 'STAFFSCHEDULETYPE_ID'=>$this->STAFFSCHEDULETYPE_ID, 'ACTIVITYSCHEDULE_ID'=>$this->ACTIVITYSCHEDULE_ID, 'FIELD_ID'=>$this->FIELD_ID, 'FIELDVALUE_ID'=>$this->FIELDVALUE_ID, 'FIELDTYPE_ID'=>$this->FIELDTYPE_ID, 'DATATYPE_ID'=>$this->DATATYPE_ID, 'COUNTRY_ID'=>$this->COUNTRY_ID, 'FIELDGROUP_ID'=>$this->FIELDGROUP_ID, 'FIELDGROUP_MATCHES_ID'=>$this->FIELDGROUP_MATCHES_ID);//[RAD_CALLBACK_PARAMS]
	        $pageCallBack = $this->getCallBack(modulecim_hrdb::PAGE_EDITSTAFFFORMINSTRUCTIONS, $this->sortBy, $parameters);
	        $this->setPageCallBack( $pageCallBack );
	        
	        
	        $parameters = array('PERSON_ID'=>$this->PERSON_ID, 'PROVINCE_ID'=>$this->PROVINCE_ID, 'GENDER_ID'=>$this->GENDER_ID, 'STAFF_ID'=>$this->STAFF_ID, 'REGION_ID'=>$this->REGION_ID, 'EMERG_ID'=>$this->EMERG_ID, 'ASSIGNSTATUS_ID'=>$this->ASSIGNSTATUS_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'ASSIGNMENT_ID'=>$this->ASSIGNMENT_ID, 'VIEWER_ID'=>$this->VIEWER_ID, 'ACCESS_ID'=>$this->ACCESS_ID, 'YEAR_ID'=>$this->YEAR_ID, 'PERSON_YEAR_ID'=>$this->PERSON_YEAR_ID, 'STAFFSCHEDULE_ID'=>$this->STAFFSCHEDULE_ID, 'STAFFACTIVITY_ID'=>$this->STAFFACTIVITY_ID, 'ACTIVITYTYPE_ID'=>$this->ACTIVITYTYPE_ID, 'STAFFSCHEDULETYPE_ID'=>$this->STAFFSCHEDULETYPE_ID, 'ACTIVITYSCHEDULE_ID'=>$this->ACTIVITYSCHEDULE_ID, 'FIELD_ID'=>$this->FIELD_ID, 'FIELDVALUE_ID'=>$this->FIELDVALUE_ID, 'FIELDTYPE_ID'=>$this->FIELDTYPE_ID, 'DATATYPE_ID'=>$this->DATATYPE_ID, 'COUNTRY_ID'=>$this->COUNTRY_ID, 'FIELDGROUP_ID'=>$this->FIELDGROUP_ID, 'FIELDGROUP_MATCHES_ID'=>$this->FIELDGROUP_MATCHES_ID);//[RAD_CALLBACK_PARAMS]
	        $formAction = $this->getCallBack(modulecim_hrdb::PAGE_EDITSTAFFFORMINSTRUCTIONS, $this->sortBy, $parameters );
	        $this->pageDisplay = new FormProcessor_EditStaffFormInstructions( $this->moduleRootPath, $this->viewer, $formAction, $this->STAFFSCHEDULETYPE_ID );//[RAD_FORMINIT_FOREIGNKEY_INIT]        
        }
        else
        {
	        $this->pageDisplay = new page_NotAuthorized($this->moduleRootPath, $this->viewer);  
        }         
    } // end loadEditStaffFormInstructions()
 
    
       
    //************************************************************************
	/**
	 * function loadEditHrdbForm
	 * <pre>
	 * Initializes the EditHrdbForm Page.
	 * </pre>
	 * @return [void]
	 */
    // RAD Tools: FormSingleEntry style
    function loadEditHrdbForm($isCreated=false)
    {
        // GROUP 3: SUPER ADMINS ONLY. 
        if ( $this->accessPrivManager->hasSitePriv() ){	 	    
		    
	        // set the pageCallBack to be without any additional parameters
	        // (an AdminBox needs this so Language Switching on a page doesn't
	        // pass a previous operations)
	        $parameters = array('PERSON_ID'=>$this->PERSON_ID, 'PROVINCE_ID'=>$this->PROVINCE_ID, 'GENDER_ID'=>$this->GENDER_ID, 'STAFF_ID'=>$this->STAFF_ID, 'REGION_ID'=>$this->REGION_ID, 'EMERG_ID'=>$this->EMERG_ID, 'ASSIGNSTATUS_ID'=>$this->ASSIGNSTATUS_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'ASSIGNMENT_ID'=>$this->ASSIGNMENT_ID, 'VIEWER_ID'=>$this->VIEWER_ID, 'ACCESS_ID'=>$this->ACCESS_ID, 'YEAR_ID'=>$this->YEAR_ID, 'PERSON_YEAR_ID'=>$this->PERSON_YEAR_ID, 'STAFFSCHEDULE_ID'=>$this->STAFFSCHEDULE_ID, 'STAFFACTIVITY_ID'=>$this->STAFFACTIVITY_ID, 'ACTIVITYTYPE_ID'=>$this->ACTIVITYTYPE_ID, 'STAFFSCHEDULETYPE_ID'=>$this->STAFFSCHEDULETYPE_ID, 'ACTIVITYSCHEDULE_ID'=>$this->ACTIVITYSCHEDULE_ID, 'FIELD_ID'=>$this->FIELD_ID, 'FIELDVALUE_ID'=>$this->FIELDVALUE_ID, 'FIELDTYPE_ID'=>$this->FIELDTYPE_ID, 'DATATYPE_ID'=>$this->DATATYPE_ID, 'COUNTRY_ID'=>$this->COUNTRY_ID);//[RAD_CALLBACK_PARAMS]
	        $pageCallBack = $this->getCallBack(modulecim_hrdb::PAGE_EDITHRDBFORM, $this->sortBy, $parameters);
	        $this->setPageCallBack( $pageCallBack );       
	               
	        
	        $parameters = array('PERSON_ID'=>$this->PERSON_ID, 'PROVINCE_ID'=>$this->PROVINCE_ID, 'GENDER_ID'=>$this->GENDER_ID, 'STAFF_ID'=>$this->STAFF_ID, 'REGION_ID'=>$this->REGION_ID, 'EMERG_ID'=>$this->EMERG_ID, 'ASSIGNSTATUS_ID'=>$this->ASSIGNSTATUS_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'ASSIGNMENT_ID'=>$this->ASSIGNMENT_ID, 'VIEWER_ID'=>$this->VIEWER_ID, 'ACCESS_ID'=>$this->ACCESS_ID, 'YEAR_ID'=>$this->YEAR_ID, 'PERSON_YEAR_ID'=>$this->PERSON_YEAR_ID, 'STAFFSCHEDULE_ID'=>$this->STAFFSCHEDULE_ID, 'STAFFACTIVITY_ID'=>$this->STAFFACTIVITY_ID, 'ACTIVITYTYPE_ID'=>$this->ACTIVITYTYPE_ID, 'STAFFSCHEDULETYPE_ID'=>$this->STAFFSCHEDULETYPE_ID, 'ACTIVITYSCHEDULE_ID'=>$this->ACTIVITYSCHEDULE_ID, 'FIELD_ID'=>$this->FIELD_ID, 'FIELDVALUE_ID'=>$this->FIELDVALUE_ID, 'FIELDTYPE_ID'=>$this->FIELDTYPE_ID, 'DATATYPE_ID'=>$this->DATATYPE_ID, 'COUNTRY_ID'=>$this->COUNTRY_ID);//[RAD_CALLBACK_PARAMS]
	        $instr_form_parameters = array('VIEWER_ID'=>$this->VIEWER_ID,  'STAFFSCHEDULETYPE_ID'=>$this->STAFFSCHEDULETYPE_ID, );//[RAD_CALLBACK_PARAMS]
	        $editfields_form_parameters = array('PERSON_ID'=>$this->PERSON_ID, 'STAFF_ID'=>$this->STAFF_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'ASSIGNMENT_ID'=>$this->ASSIGNMENT_ID, 'VIEWER_ID'=>$this->VIEWER_ID, 'ACCESS_ID'=>$this->ACCESS_ID, 'STAFFSCHEDULE_ID'=>$this->STAFFSCHEDULE_ID, 'STAFFACTIVITY_ID'=>$this->STAFFACTIVITY_ID, 'ACTIVITYTYPE_ID'=>$this->ACTIVITYTYPE_ID, 'STAFFSCHEDULETYPE_ID'=>$this->STAFFSCHEDULETYPE_ID, 'ACTIVITYSCHEDULE_ID'=>$this->ACTIVITYSCHEDULE_ID,  'FIELD_ID'=>$this->FIELD_ID, 'FIELDVALUE_ID'=>$this->FIELDVALUE_ID);//[RAD_CALLBACK_PARAMS]
	      
	        $formAction = $this->getCallBack(modulecim_hrdb::PAGE_EDITHRDBFORM, $this->sortBy, $parameters );
	        $instrFormAction = $this->getCallBack(modulecim_hrdb::PAGE_EDITHRDBFORM, $this->sortBy, $instr_form_parameters );
	        $editFieldsFormAction = $this->getCallBack(modulecim_hrdb::PAGE_EDITHRDBFORM, $this->sortBy, $editfields_form_parameters );
	
	        $pageCallBack = $this->getCallBack(modulecim_hrdb::PAGE_EDITHRDBFORM, $this->sortBy, $parameters);
	        $this->setPageCallBack( $pageCallBack );     
	 
	        // if this pageDisplay object isn't already created then 
	        if ( !$isCreated ) {
	
	            // create a new pageDisplay object		    
									  
	        		$this->pageDisplay = new FormProcessor_EditHrdbForm( $this->moduleRootPath, $this->viewer, $formAction, $instrFormAction, $editFieldsFormAction, $this->sortBy, $this->STAFFSCHEDULETYPE_ID, $this->FIELD_ID);//[RAD_FORMINIT_FOREIGNKEY_INIT]        
	
	        } else {
	        
	            // otherwise just update the formAction value
	            $this->pageDisplay->setFormAction( $formAction, $instrFormAction, $editFieldsFormAction);
	        }   
	        
	        $links = array();
	        $continueLink = $this->getCallBack( modulecim_hrdb::PAGE_EDITSTAFFFORMCONTEXT, "", $parameters );
	        $links["cont"] = $continueLink;
	   
	         /**** EDIT FORM-FIELDS SUB-PAGE LINKS INIT ***/
	        $formFieldlinks = array();
	        
	        $parameters = array('PERSON_ID'=>$this->PERSON_ID, 'PROVINCE_ID'=>$this->PROVINCE_ID, 'GENDER_ID'=>$this->GENDER_ID, 'STAFF_ID'=>$this->STAFF_ID, 'REGION_ID'=>$this->REGION_ID, 'EMERG_ID'=>$this->EMERG_ID, 'ASSIGNSTATUS_ID'=>$this->ASSIGNSTATUS_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'ASSIGNMENT_ID'=>$this->ASSIGNMENT_ID, 'VIEWER_ID'=>$this->VIEWER_ID, 'ACCESS_ID'=>$this->ACCESS_ID, 'YEAR_ID'=>$this->YEAR_ID, 'PERSON_YEAR_ID'=>$this->PERSON_YEAR_ID, 'STAFFSCHEDULE_ID'=>$this->STAFFSCHEDULE_ID, 'STAFFACTIVITY_ID'=>$this->STAFFACTIVITY_ID, 'ACTIVITYTYPE_ID'=>$this->ACTIVITYTYPE_ID, 'STAFFSCHEDULETYPE_ID'=>$this->STAFFSCHEDULETYPE_ID, 'ACTIVITYSCHEDULE_ID'=>$this->ACTIVITYSCHEDULE_ID, 'FIELD_ID'=>$this->FIELD_ID, 'FIELDVALUE_ID'=>$this->FIELDVALUE_ID, 'FIELDTYPE_ID'=>$this->FIELDTYPE_ID, 'DATATYPE_ID'=>$this->DATATYPE_ID, 'COUNTRY_ID'=>$this->COUNTRY_ID);//[RAD_CALLBACK_PARAMS]
	        $editLink = $this->getCallBack( modulecim_hrdb::PAGE_EDITHRDBFORM, $this->sortBy, $parameters );
	        $editLink .= "&". modulecim_hrdb::FIELD_ID . "=";
	        $formFieldlinks[ "edit" ] = $editLink;
	        
	        // NOTE: delete link is same as edit link for an AdminBox
	        $formFieldlinks[ "del" ] = $editLink;
	
	/*[RAD_LINK_INSERT]*/
	
	        $parameters = array('PERSON_ID'=>$this->PERSON_ID, 'PROVINCE_ID'=>$this->PROVINCE_ID, 'GENDER_ID'=>$this->GENDER_ID, 'STAFF_ID'=>$this->STAFF_ID, 'REGION_ID'=>$this->REGION_ID, 'EMERG_ID'=>$this->EMERG_ID, 'ASSIGNSTATUS_ID'=>$this->ASSIGNSTATUS_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'ASSIGNMENT_ID'=>$this->ASSIGNMENT_ID, 'VIEWER_ID'=>$this->VIEWER_ID, 'ACCESS_ID'=>$this->ACCESS_ID, 'YEAR_ID'=>$this->YEAR_ID, 'PERSON_YEAR_ID'=>$this->PERSON_YEAR_ID, 'STAFFSCHEDULE_ID'=>$this->STAFFSCHEDULE_ID, 'STAFFACTIVITY_ID'=>$this->STAFFACTIVITY_ID, 'ACTIVITYTYPE_ID'=>$this->ACTIVITYTYPE_ID, 'STAFFSCHEDULETYPE_ID'=>$this->STAFFSCHEDULETYPE_ID, 'ACTIVITYSCHEDULE_ID'=>$this->ACTIVITYSCHEDULE_ID, 'FIELD_ID'=>$this->FIELD_ID, 'FIELDVALUE_ID'=>$this->FIELDVALUE_ID, 'FIELDTYPE_ID'=>$this->FIELDTYPE_ID, 'DATATYPE_ID'=>$this->DATATYPE_ID, 'COUNTRY_ID'=>$this->COUNTRY_ID);//[RAD_CALLBACK_PARAMS]
	        $sortByLink = $this->getCallBack( modulecim_hrdb::PAGE_EDITHRDBFORM, '', $parameters );
	        $sortByLink .= "&".modulecim_hrdb::SORTBY."=";
	        $formFieldlinks["sortBy"] = $sortByLink;
	
	
	        $this->pageDisplay->setLinks( $links, $formFieldlinks );  // (DON'T NEED LINKS FOR SINGLE FORM PORTION) 
        }
        else
        {
	        $this->pageDisplay = new page_NotAuthorized($this->moduleRootPath, $this->viewer);  
        }     	        
     }
     
 
    //************************************************************************
	/**
	 * function loadViewScheduleCalendar
	 * <pre>
	 * Initializes the ViewScheduleCalendar Page.
	 * </pre>
	 * @return [void]
	 */
    function loadViewScheduleCalendar() 
    {
        // GROUP 2: STAFF AND ABOVE ONLY.  
        if ((( $this->accessPrivManager->hasSitePriv() ) || ( $this->accessPrivManager->isStaff($this->viewer->getID()) )) ){	    
	        
	        // set the pageCallBack to be without any additional parameters
	        // (an AdminBox needs this so Language Switching on a page doesn't
	        // pass a previous operations)
	        $parameters = array('PERSON_ID'=>$this->PERSON_ID, 'PROVINCE_ID'=>$this->PROVINCE_ID, 'GENDER_ID'=>$this->GENDER_ID, 'STAFF_ID'=>$this->STAFF_ID, 'REGION_ID'=>$this->REGION_ID, 'EMERG_ID'=>$this->EMERG_ID, 'ASSIGNSTATUS_ID'=>$this->ASSIGNSTATUS_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'ASSIGNMENT_ID'=>$this->ASSIGNMENT_ID, 'VIEWER_ID'=>$this->VIEWER_ID, 'ACCESS_ID'=>$this->ACCESS_ID, 'YEAR_ID'=>$this->YEAR_ID, 'PERSON_YEAR_ID'=>$this->PERSON_YEAR_ID);//[RAD_CALLBACK_PARAMS]
	        $pageCallBack = $this->getCallBack(modulecim_hrdb::PAGE_VIEWSCHEDULECALENDAR, $this->sortBy, $parameters);
	        $this->setPageCallBack( $pageCallBack );
	                
	        $parameters = array('PERSON_ID'=>$this->PERSON_ID, 'PROVINCE_ID'=>$this->PROVINCE_ID, 'GENDER_ID'=>$this->GENDER_ID, 'STAFF_ID'=>$this->STAFF_ID, 'REGION_ID'=>$this->REGION_ID, 'EMERG_ID'=>$this->EMERG_ID, 'ASSIGNSTATUS_ID'=>$this->ASSIGNSTATUS_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'ASSIGNMENT_ID'=>$this->ASSIGNMENT_ID, 'VIEWER_ID'=>$this->VIEWER_ID, 'ACCESS_ID'=>$this->ACCESS_ID, 'YEAR_ID'=>$this->YEAR_ID, 'PERSON_YEAR_ID'=>$this->PERSON_YEAR_ID);//[RAD_CALLBACK_PARAMS]
	        $formAction = $this->getCallBack(modulecim_hrdb::PAGE_VIEWSCHEDULECALENDAR, $this->sortBy, $parameters );
	        if ($this->MONTH_ID=='')
	        {
		        $this->MONTH_ID=date('n');	// current month
	        }
	        $this->pageDisplay = new page_ViewScheduleCalendar( $this->moduleRootPath, $this->viewer, $this->sortBy, $this->MONTH_ID);	//[RAD_FORMINIT_FOREIGNKEY_INIT]        
	
	        $links = array();
	        
	/*[RAD_LINK_INSERT]*/        
	         
	        $jumpLink = $this->getCallBack( modulecim_hrdb::PAGE_VIEWSCHEDULECALENDAR, $this->sortBy, '', '', '', '', '', '' );//[RAD_CALLBACK_PARAMS_EDIT]
	        $jumpLink .= "&". modulecim_hrdb::MONTH_ID . "=";
	        $links["jumpLink"] = $jumpLink;
	
	        $this->pageDisplay->setLinks( $links );
	        
	        $this->addScript('MM_jumpMenu.jsp');        
        
        }
        else
        {
	        $this->pageDisplay = new page_NotAuthorized($this->moduleRootPath, $this->viewer);  
        }  
        
                       
    } // end ViewStudentYearInSchool()        
                  


    //************************************************************************
	/**
	 * function loadViewStaffActivities
	 * <pre>
	 * Initializes the ViewStaffActivities Page.
	 * </pre>
	 * @return [void]
	 */
    // RAD Tools: DataListTable Style
    function loadViewStaffActivities() 
    {
        // GROUP 2: STAFF AND ABOVE ONLY.  
        if ((( $this->accessPrivManager->hasSitePriv() ) || ( $this->accessPrivManager->isStaff($this->viewer->getID()) )) ){	    
	    
	        // set the pageCallBack to be without any additional parameters
	        // (an AdminBox needs this so Language Switching on a page doesn't
	        // pass a previous operations)
	        $parameters = array('PERSON_ID'=>$this->PERSON_ID, 'PROVINCE_ID'=>$this->PROVINCE_ID, 'GENDER_ID'=>$this->GENDER_ID, 'STAFF_ID'=>$this->STAFF_ID, 'REGION_ID'=>$this->REGION_ID, 'EMERG_ID'=>$this->EMERG_ID, 'ASSIGNSTATUS_ID'=>$this->ASSIGNSTATUS_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'ASSIGNMENT_ID'=>$this->ASSIGNMENT_ID, 'VIEWER_ID'=>$this->VIEWER_ID, 'ACCESS_ID'=>$this->ACCESS_ID, 'YEAR_ID'=>$this->YEAR_ID, 'PERSON_YEAR_ID'=>$this->PERSON_YEAR_ID, 'STAFFSCHEDULE_ID'=>$this->STAFFSCHEDULE_ID, 'STAFFACTIVITY_ID'=>$this->STAFFACTIVITY_ID, 'ACTIVITYTYPE_ID'=>$this->ACTIVITYTYPE_ID, 'STAFFSCHEDULETYPE_ID'=>$this->STAFFSCHEDULETYPE_ID, 'ACTIVITYSCHEDULE_ID'=>$this->ACTIVITYSCHEDULE_ID, 'FIELD_ID'=>$this->FIELD_ID, 'FIELDVALUE_ID'=>$this->FIELDVALUE_ID, 'FIELDTYPE_ID'=>$this->FIELDTYPE_ID, 'DATATYPE_ID'=>$this->DATATYPE_ID, 'COUNTRY_ID'=>$this->COUNTRY_ID, 'FIELDGROUP_ID'=>$this->FIELDGROUP_ID, 'FIELDGROUP_MATCHES_ID'=>$this->FIELDGROUP_MATCHES_ID, 'STAFFDIRECTOR_ID'=>$this->STAFFDIRECTOR_ID);//[RAD_CALLBACK_PARAMS]
	        $pageCallBack = $this->getCallBack(modulecim_hrdb::PAGE_VIEWSTAFFACTIVITIES, $this->sortBy, $parameters);
	        $this->setPageCallBack( $pageCallBack );
	        
// 	        $this->ACTIVITYTYPE_ID = 2;			/** TEST LINE **/
	        $this->pageDisplay = new page_ViewStaffActivities( $this->moduleRootPath, $this->viewer, $this->sortBy, $this->STAFFACTIVITY_ID, $this->ACTIVITYTYPE_ID );    
	        
	        $links = array();
	        
	/*[RAD_LINK_INSERT]*/
	
	        $parameters = array('PERSON_ID'=>$this->PERSON_ID, 'PROVINCE_ID'=>$this->PROVINCE_ID, 'GENDER_ID'=>$this->GENDER_ID, 'STAFF_ID'=>$this->STAFF_ID, 'REGION_ID'=>$this->REGION_ID, 'EMERG_ID'=>$this->EMERG_ID, 'ASSIGNSTATUS_ID'=>$this->ASSIGNSTATUS_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'ASSIGNMENT_ID'=>$this->ASSIGNMENT_ID, 'VIEWER_ID'=>$this->VIEWER_ID, 'ACCESS_ID'=>$this->ACCESS_ID, 'YEAR_ID'=>$this->YEAR_ID, 'PERSON_YEAR_ID'=>$this->PERSON_YEAR_ID, 'STAFFSCHEDULE_ID'=>$this->STAFFSCHEDULE_ID, 'STAFFACTIVITY_ID'=>$this->STAFFACTIVITY_ID, 'ACTIVITYTYPE_ID'=>$this->ACTIVITYTYPE_ID, 'STAFFSCHEDULETYPE_ID'=>$this->STAFFSCHEDULETYPE_ID, 'ACTIVITYSCHEDULE_ID'=>$this->ACTIVITYSCHEDULE_ID, 'FIELD_ID'=>$this->FIELD_ID, 'FIELDVALUE_ID'=>$this->FIELDVALUE_ID, 'FIELDTYPE_ID'=>$this->FIELDTYPE_ID, 'DATATYPE_ID'=>$this->DATATYPE_ID, 'COUNTRY_ID'=>$this->COUNTRY_ID, 'FIELDGROUP_ID'=>$this->FIELDGROUP_ID, 'FIELDGROUP_MATCHES_ID'=>$this->FIELDGROUP_MATCHES_ID, 'STAFFDIRECTOR_ID'=>$this->STAFFDIRECTOR_ID);//[RAD_CALLBACK_PARAMS]
	        $sortByLink = $this->getCallBack( modulecim_hrdb::PAGE_VIEWSTAFFACTIVITIES, '', $parameters );
	        $sortByLink .= "&".modulecim_hrdb::SORTBY."=";
	        $links["sortBy"] = $sortByLink;
	
	        $this->pageDisplay->setLinks( $links );
        
        }
        else
        {
	        $this->pageDisplay = new page_NotAuthorized($this->moduleRootPath, $this->viewer);  
        }           
        
    } // end loadViewStaffActivities()



    //************************************************************************
	/**
	 * function loadHrdbActivities
	 * <pre>
	 * Initializes the HrdbActivities Page.
	 * </pre>
	 * @return [void]
	 */
    // RAD Tools: DataListTable Style
    function loadHrdbActivities() 
    {
        // GROUP 2: STAFF AND ABOVE ONLY.  
        if ((( $this->accessPrivManager->hasSitePriv() ) || ( $this->accessPrivManager->isStaff($this->viewer->getID()) )) ){	    
	    	    
	        // set the pageCallBack to be without any additional parameters
	        // (an AdminBox needs this so Language Switching on a page doesn't
	        // pass a previous operations)
	        $parameters = array('PERSON_ID'=>$this->PERSON_ID, 'PROVINCE_ID'=>$this->PROVINCE_ID, 'GENDER_ID'=>$this->GENDER_ID, 'STAFF_ID'=>$this->STAFF_ID, 'REGION_ID'=>$this->REGION_ID, 'EMERG_ID'=>$this->EMERG_ID, 'ASSIGNSTATUS_ID'=>$this->ASSIGNSTATUS_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'ASSIGNMENT_ID'=>$this->ASSIGNMENT_ID, 'VIEWER_ID'=>$this->VIEWER_ID, 'ACCESS_ID'=>$this->ACCESS_ID, 'YEAR_ID'=>$this->YEAR_ID, 'PERSON_YEAR_ID'=>$this->PERSON_YEAR_ID, 'STAFFSCHEDULE_ID'=>$this->STAFFSCHEDULE_ID, 'STAFFACTIVITY_ID'=>$this->STAFFACTIVITY_ID, 'ACTIVITYTYPE_ID'=>$this->ACTIVITYTYPE_ID, 'STAFFSCHEDULETYPE_ID'=>$this->STAFFSCHEDULETYPE_ID, 'ACTIVITYSCHEDULE_ID'=>$this->ACTIVITYSCHEDULE_ID, 'FIELD_ID'=>$this->FIELD_ID, 'FIELDVALUE_ID'=>$this->FIELDVALUE_ID, 'FIELDTYPE_ID'=>$this->FIELDTYPE_ID, 'DATATYPE_ID'=>$this->DATATYPE_ID, 'COUNTRY_ID'=>$this->COUNTRY_ID, 'FIELDGROUP_ID'=>$this->FIELDGROUP_ID, 'FIELDGROUP_MATCHES_ID'=>$this->FIELDGROUP_MATCHES_ID, 'STAFFDIRECTOR_ID'=>$this->STAFFDIRECTOR_ID);//[RAD_CALLBACK_PARAMS]
	        $pageCallBack = $this->getCallBack(modulecim_hrdb::PAGE_HRDBACTIVITIES, $this->sortBy, $parameters);
	        $this->setPageCallBack( $pageCallBack );
	        
	        
	        $this->pageDisplay = new page_HrdbActivities( $this->moduleRootPath, $this->viewer, $this->sortBy, $this->ACTIVITYTYPE_ID );    
	        
	        $links = array();
	        
	/*[RAD_LINK_INSERT]*/
	        $parameters = array('PERSON_ID'=>$this->PERSON_ID, 'PROVINCE_ID'=>$this->PROVINCE_ID, 'GENDER_ID'=>$this->GENDER_ID, 'STAFF_ID'=>$this->STAFF_ID, 'REGION_ID'=>$this->REGION_ID, 'EMERG_ID'=>$this->EMERG_ID, 'ASSIGNSTATUS_ID'=>$this->ASSIGNSTATUS_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'ASSIGNMENT_ID'=>$this->ASSIGNMENT_ID, 'VIEWER_ID'=>$this->VIEWER_ID, 'ACCESS_ID'=>$this->ACCESS_ID, 'YEAR_ID'=>$this->YEAR_ID, 'PERSON_YEAR_ID'=>$this->PERSON_YEAR_ID, 'STAFFSCHEDULE_ID'=>$this->STAFFSCHEDULE_ID, 'STAFFACTIVITY_ID'=>$this->STAFFACTIVITY_ID, 'ACTIVITYTYPE_ID'=>$this->ACTIVITYTYPE_ID, 'STAFFSCHEDULETYPE_ID'=>$this->STAFFSCHEDULETYPE_ID, 'ACTIVITYSCHEDULE_ID'=>$this->ACTIVITYSCHEDULE_ID);//[RAD_CALLBACK_PARAMS]
	        $link = $this->getCallBack( modulecim_hrdb::PAGE_VIEWSTAFFACTIVITIES, '', $parameters );
	        $link .= "&".modulecim_hrdb::ACTIVITYTYPE_ID."=";
	        $links["access"] = $link;
	        
// 	        $this->pageDisplay->setAccessLevel(page_HrdbForms::ACCESS_GENERAL);	
	
	
	        $parameters = array('PERSON_ID'=>$this->PERSON_ID, 'PROVINCE_ID'=>$this->PROVINCE_ID, 'GENDER_ID'=>$this->GENDER_ID, 'STAFF_ID'=>$this->STAFF_ID, 'REGION_ID'=>$this->REGION_ID, 'EMERG_ID'=>$this->EMERG_ID, 'ASSIGNSTATUS_ID'=>$this->ASSIGNSTATUS_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'ASSIGNMENT_ID'=>$this->ASSIGNMENT_ID, 'VIEWER_ID'=>$this->VIEWER_ID, 'ACCESS_ID'=>$this->ACCESS_ID, 'YEAR_ID'=>$this->YEAR_ID, 'PERSON_YEAR_ID'=>$this->PERSON_YEAR_ID, 'STAFFSCHEDULE_ID'=>$this->STAFFSCHEDULE_ID, 'STAFFACTIVITY_ID'=>$this->STAFFACTIVITY_ID, 'ACTIVITYTYPE_ID'=>$this->ACTIVITYTYPE_ID, 'STAFFSCHEDULETYPE_ID'=>$this->STAFFSCHEDULETYPE_ID, 'ACTIVITYSCHEDULE_ID'=>$this->ACTIVITYSCHEDULE_ID, 'FIELD_ID'=>$this->FIELD_ID, 'FIELDVALUE_ID'=>$this->FIELDVALUE_ID, 'FIELDTYPE_ID'=>$this->FIELDTYPE_ID, 'DATATYPE_ID'=>$this->DATATYPE_ID, 'COUNTRY_ID'=>$this->COUNTRY_ID, 'FIELDGROUP_ID'=>$this->FIELDGROUP_ID, 'FIELDGROUP_MATCHES_ID'=>$this->FIELDGROUP_MATCHES_ID, 'STAFFDIRECTOR_ID'=>$this->STAFFDIRECTOR_ID);//[RAD_CALLBACK_PARAMS]
	        $sortByLink = $this->getCallBack( modulecim_hrdb::PAGE_HRDBACTIVITIES, '', $parameters );
	        $sortByLink .= "&".modulecim_hrdb::SORTBY."=";
	        $links["sortBy"] = $sortByLink;
	
	        $this->pageDisplay->setLinks( $links ); 
        }
        else
        {
	        $this->pageDisplay = new page_NotAuthorized($this->moduleRootPath, $this->viewer);  
        } 
        
        
    } // end loadHrdbActivities()
    

    	   
    //************************************************************************
	/**
	 * function loadViewActivitiesByDate
	 * <pre>
	 * Initializes the ViewActivitiesByDate Page.
	 * </pre>
	 * @return [void]
	 */
    // RAD Tools: DataListTable Style
    function loadViewActivitiesByDate($isCreated = false) 
    {			                
			                
        // GROUP 2: STAFF AND ABOVE ONLY.  
        if ((( $this->accessPrivManager->hasSitePriv() ) || ( $this->accessPrivManager->isStaff($this->viewer->getID()) )) ){	    
	    	    
	        // set the pageCallBack to be without any additional parameters
	        // (an AdminBox needs this so Language Switching on a page doesn't
	        // pass a previous operations)
	        $parameters = array('PERSON_ID'=>$this->PERSON_ID, 'PROVINCE_ID'=>$this->PROVINCE_ID, 'GENDER_ID'=>$this->GENDER_ID, 'STAFF_ID'=>$this->STAFF_ID, 'REGION_ID'=>$this->REGION_ID, 'EMERG_ID'=>$this->EMERG_ID, 'ASSIGNSTATUS_ID'=>$this->ASSIGNSTATUS_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'ASSIGNMENT_ID'=>$this->ASSIGNMENT_ID, 'VIEWER_ID'=>$this->VIEWER_ID, 'ACCESS_ID'=>$this->ACCESS_ID, 'YEAR_ID'=>$this->YEAR_ID, 'PERSON_YEAR_ID'=>$this->PERSON_YEAR_ID, 'STAFFSCHEDULE_ID'=>$this->STAFFSCHEDULE_ID, 'STAFFACTIVITY_ID'=>$this->STAFFACTIVITY_ID, 'ACTIVITYTYPE_ID'=>$this->ACTIVITYTYPE_ID, 'STAFFSCHEDULETYPE_ID'=>$this->STAFFSCHEDULETYPE_ID, 'ACTIVITYSCHEDULE_ID'=>$this->ACTIVITYSCHEDULE_ID, 'FIELD_ID'=>$this->FIELD_ID, 'FIELDVALUE_ID'=>$this->FIELDVALUE_ID, 'FIELDTYPE_ID'=>$this->FIELDTYPE_ID, 'DATATYPE_ID'=>$this->DATATYPE_ID, 'COUNTRY_ID'=>$this->COUNTRY_ID, 'FIELDGROUP_ID'=>$this->FIELDGROUP_ID, 'FIELDGROUP_MATCHES_ID'=>$this->FIELDGROUP_MATCHES_ID, 'STAFFDIRECTOR_ID'=>$this->STAFFDIRECTOR_ID, 'SEARCH_STARTDATE'=>$this->SEARCH_STARTDATE, 'SEARCH_ENDDATE'=>$this->SEARCH_ENDDATE);//[RAD_CALLBACK_PARAMS]
	        $pageCallBack = $this->getCallBack(modulecim_hrdb::PAGE_VIEWACTIVITIESBYDATE, $this->sortBy, $parameters);
	        $this->setPageCallBack( $pageCallBack );
	        
	        $parameters = array('PERSON_ID'=>$this->PERSON_ID, 'PROVINCE_ID'=>$this->PROVINCE_ID, 'GENDER_ID'=>$this->GENDER_ID, 'STAFF_ID'=>$this->STAFF_ID, 'REGION_ID'=>$this->REGION_ID, 'EMERG_ID'=>$this->EMERG_ID, 'ASSIGNSTATUS_ID'=>$this->ASSIGNSTATUS_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'ASSIGNMENT_ID'=>$this->ASSIGNMENT_ID, 'VIEWER_ID'=>$this->VIEWER_ID, 'ACCESS_ID'=>$this->ACCESS_ID, 'YEAR_ID'=>$this->YEAR_ID, 'PERSON_YEAR_ID'=>$this->PERSON_YEAR_ID, 'STAFFSCHEDULE_ID'=>$this->STAFFSCHEDULE_ID, 'STAFFACTIVITY_ID'=>$this->STAFFACTIVITY_ID, 'ACTIVITYTYPE_ID'=>$this->ACTIVITYTYPE_ID, 'STAFFSCHEDULETYPE_ID'=>$this->STAFFSCHEDULETYPE_ID, 'ACTIVITYSCHEDULE_ID'=>$this->ACTIVITYSCHEDULE_ID, 'FIELD_ID'=>$this->FIELD_ID, 'FIELDVALUE_ID'=>$this->FIELDVALUE_ID, 'FIELDTYPE_ID'=>$this->FIELDTYPE_ID, 'DATATYPE_ID'=>$this->DATATYPE_ID, 'COUNTRY_ID'=>$this->COUNTRY_ID, 'SEARCH_STARTDATE'=>$this->SEARCH_STARTDATE, 'SEARCH_ENDDATE'=>$this->SEARCH_ENDDATE);//[RAD_CALLBACK_PARAMS]
	        $formAction = $this->getCallBack(modulecim_hrdb::PAGE_VIEWACTIVITIESBYDATE, $this->sortBy, $parameters );	        
	        

	        // if this pageDisplay object isn't already created then 
// 	        if ( !$isCreated ) {
	
	            // create a new pageDisplay object		    									  
	        		$this->pageDisplay = new FormProcessor_ViewActivitiesByDate( $this->moduleRootPath, $this->viewer, $formAction, $this->sortBy, $this->PERSON_ID, $this->STAFFACTIVITY_ID, $this->SEARCH_STARTDATE, $this->SEARCH_ENDDATE );    
	
// 	        } else {
// 		        
// // 		        echo 'dates = '.$this->SEARCH_STARTDATE.' and '.$this->SEARCH_ENDDATE;
// 		        
// 		        $this->pageDisplay->setStartDate($this->SEARCH_STARTDATE );
// 		        $this->pageDisplay->setEndDate($this->SEARCH_ENDDATE );
// 	        
// 	            // otherwise just update the formAction value
// 	            $this->pageDisplay->setFormAction( $formAction);
// 	        }  	        
        	        
	        $links = array();
	        
	/*[RAD_LINK_INSERT]*/
	        
// 	        $this->pageDisplay->setAccessLevel(page_HrdbForms::ACCESS_GENERAL);	

			  $this->DOWNLOAD_TYPE = modulecim_hrdb::DOWNLOAD_ACTIVITIES_LIST;
// 			  $this->START_DATE = $this->pageDisplay->getStartDate();		// TODO: retrieve activities' start date from the display page
// 			  $this->END_DATE = $this->pageDisplay->getEndDate();		// TODO: retrieve activities' end date from the display page
	        $fileDownloadParameters = array('DOWNLOAD_TYPE'=>$this->DOWNLOAD_TYPE);//[RAD_CALLBACK_PARAMS]   $this->START_DATE  , $this->END_DATE         
	        $csvLink = $this->getCallBack( modulecim_hrdb::PAGE_DOWNLOADCSV, '', $fileDownloadParameters );
	        $links["DownloadActivitiesDateCSV"] = $csvLink;             //Activities List - for importing into Excel   	
	
	        $parameters = array('PERSON_ID'=>$this->PERSON_ID, 'PROVINCE_ID'=>$this->PROVINCE_ID, 'GENDER_ID'=>$this->GENDER_ID, 'STAFF_ID'=>$this->STAFF_ID, 'REGION_ID'=>$this->REGION_ID, 'EMERG_ID'=>$this->EMERG_ID, 'ASSIGNSTATUS_ID'=>$this->ASSIGNSTATUS_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'ASSIGNMENT_ID'=>$this->ASSIGNMENT_ID, 'VIEWER_ID'=>$this->VIEWER_ID, 'ACCESS_ID'=>$this->ACCESS_ID, 'YEAR_ID'=>$this->YEAR_ID, 'PERSON_YEAR_ID'=>$this->PERSON_YEAR_ID, 'STAFFSCHEDULE_ID'=>$this->STAFFSCHEDULE_ID, 'STAFFACTIVITY_ID'=>$this->STAFFACTIVITY_ID, 'ACTIVITYTYPE_ID'=>$this->ACTIVITYTYPE_ID, 'STAFFSCHEDULETYPE_ID'=>$this->STAFFSCHEDULETYPE_ID, 'ACTIVITYSCHEDULE_ID'=>$this->ACTIVITYSCHEDULE_ID, 'FIELD_ID'=>$this->FIELD_ID, 'FIELDVALUE_ID'=>$this->FIELDVALUE_ID, 'FIELDTYPE_ID'=>$this->FIELDTYPE_ID, 'DATATYPE_ID'=>$this->DATATYPE_ID, 'COUNTRY_ID'=>$this->COUNTRY_ID, 'FIELDGROUP_ID'=>$this->FIELDGROUP_ID, 'FIELDGROUP_MATCHES_ID'=>$this->FIELDGROUP_MATCHES_ID, 'STAFFDIRECTOR_ID'=>$this->STAFFDIRECTOR_ID, 'SEARCH_STARTDATE'=>$this->SEARCH_STARTDATE, 'SEARCH_ENDDATE'=>$this->SEARCH_ENDDATE);//[RAD_CALLBACK_PARAMS]
	        $sortByLink = $this->getCallBack( modulecim_hrdb::PAGE_VIEWACTIVITIESBYDATE, '', $parameters );
	        $sortByLink .= "&".modulecim_hrdb::SORTBY."=";
	        $links["sortBy"] = $sortByLink;
	
	        $this->pageDisplay->setLinks( $links ); 
        }
        else
        {
	        $this->pageDisplay = new page_NotAuthorized($this->moduleRootPath, $this->viewer);  
        } 
     }

                
    //************************************************************************
	/**
	 * function loadFormSubmittedListing
	 * <pre>
	 * Initializes the FormSubmittedListing Page.
	 * </pre>
	 * @return [void]
	 */
    // RAD Tools: DataListTable Style
    function loadFormSubmittedListing() 
    {
        // GROUP 2: STAFF AND ABOVE ONLY.   (approve HRDB form listing )
        if ((( $this->accessPrivManager->hasSitePriv() ) || ( $this->accessPrivManager->isStaff($this->viewer->getID()) )) ){	    
	    	    	    
	        // set the pageCallBack to be without any additional parameters
	        // (an AdminBox needs this so Language Switching on a page doesn't
	        // pass a previous operations)
	        $parameters = array('PERSON_ID'=>$this->PERSON_ID, 'PROVINCE_ID'=>$this->PROVINCE_ID, 'GENDER_ID'=>$this->GENDER_ID, 'STAFF_ID'=>$this->STAFF_ID, 'REGION_ID'=>$this->REGION_ID, 'EMERG_ID'=>$this->EMERG_ID, 'ASSIGNSTATUS_ID'=>$this->ASSIGNSTATUS_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'ASSIGNMENT_ID'=>$this->ASSIGNMENT_ID, 'VIEWER_ID'=>$this->VIEWER_ID, 'ACCESS_ID'=>$this->ACCESS_ID, 'YEAR_ID'=>$this->YEAR_ID, 'PERSON_YEAR_ID'=>$this->PERSON_YEAR_ID, 'STAFFSCHEDULE_ID'=>$this->STAFFSCHEDULE_ID, 'STAFFACTIVITY_ID'=>$this->STAFFACTIVITY_ID, 'ACTIVITYTYPE_ID'=>$this->ACTIVITYTYPE_ID, 'STAFFSCHEDULETYPE_ID'=>$this->STAFFSCHEDULETYPE_ID, 'ACTIVITYSCHEDULE_ID'=>$this->ACTIVITYSCHEDULE_ID, 'FIELD_ID'=>$this->FIELD_ID, 'FIELDVALUE_ID'=>$this->FIELDVALUE_ID, 'FIELDTYPE_ID'=>$this->FIELDTYPE_ID, 'DATATYPE_ID'=>$this->DATATYPE_ID, 'COUNTRY_ID'=>$this->COUNTRY_ID, 'FIELDGROUP_ID'=>$this->FIELDGROUP_ID, 'FIELDGROUP_MATCHES_ID'=>$this->FIELDGROUP_MATCHES_ID);//[RAD_CALLBACK_PARAMS]
	        $pageCallBack = $this->getCallBack(modulecim_hrdb::PAGE_FORMSUBMITTEDLISTING, $this->sortBy, $parameters);
	        $this->setPageCallBack( $pageCallBack );
	        
	        
	        $this->pageDisplay = new page_FormSubmittedListing( $this->moduleRootPath, $this->viewer, $this->sortBy, $this->STAFFSCHEDULETYPE_ID );    
	        
	        $links = array();
	        
	/*[RAD_LINK_INSERT]*/
	
	        $parameters = array( 'PERSON_ID'=>$this->PERSON_ID,'STAFFSCHEDULETYPE_ID'=>$this->STAFFSCHEDULETYPE_ID,'STAFFSCHEDULE_ID'=>$this->STAFFSCHEDULE_ID);//[RAD_CALLBACK_PARAMS_EDIT]
	        $viewLink = $this->getCallBack( modulecim_hrdb::PAGE_EDITPERSON, $this->sortBy, $parameters );
	        $viewLink .= "&". modulecim_hrdb::PERSON_ID . "=";
	        $links["view"] = $viewLink;			
	
	        $parameters = array('PERSON_ID'=>$this->PERSON_ID, 'PROVINCE_ID'=>$this->PROVINCE_ID, 'GENDER_ID'=>$this->GENDER_ID, 'STAFF_ID'=>$this->STAFF_ID, 'REGION_ID'=>$this->REGION_ID, 'EMERG_ID'=>$this->EMERG_ID, 'ASSIGNSTATUS_ID'=>$this->ASSIGNSTATUS_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'ASSIGNMENT_ID'=>$this->ASSIGNMENT_ID, 'VIEWER_ID'=>$this->VIEWER_ID, 'ACCESS_ID'=>$this->ACCESS_ID, 'YEAR_ID'=>$this->YEAR_ID, 'PERSON_YEAR_ID'=>$this->PERSON_YEAR_ID, 'STAFFSCHEDULE_ID'=>$this->STAFFSCHEDULE_ID, 'STAFFACTIVITY_ID'=>$this->STAFFACTIVITY_ID, 'ACTIVITYTYPE_ID'=>$this->ACTIVITYTYPE_ID, 'STAFFSCHEDULETYPE_ID'=>$this->STAFFSCHEDULETYPE_ID, 'ACTIVITYSCHEDULE_ID'=>$this->ACTIVITYSCHEDULE_ID, 'FIELD_ID'=>$this->FIELD_ID, 'FIELDVALUE_ID'=>$this->FIELDVALUE_ID, 'FIELDTYPE_ID'=>$this->FIELDTYPE_ID, 'DATATYPE_ID'=>$this->DATATYPE_ID, 'COUNTRY_ID'=>$this->COUNTRY_ID, 'FIELDGROUP_ID'=>$this->FIELDGROUP_ID, 'FIELDGROUP_MATCHES_ID'=>$this->FIELDGROUP_MATCHES_ID);//[RAD_CALLBACK_PARAMS]
	        $sortByLink = $this->getCallBack( modulecim_hrdb::PAGE_FORMSUBMITTEDLISTING, '', $parameters );
	        $sortByLink .= "&".modulecim_hrdb::SORTBY."=";
	        $links["sortBy"] = $sortByLink;
	
	        $this->pageDisplay->setLinks( $links ); 
        }
        else
        {
	        $this->pageDisplay = new page_NotAuthorized($this->moduleRootPath, $this->viewer);  
        }
     }                
                
                    

    //************************************************************************
	/**
	 * function loadEditActivityTypes
	 * <pre>
	 * Initializes the EditActivityTypes Page.
	 * </pre>
	 * @param $isCreated [BOOL] "Is THIS pageDisplay object already created?"
	 * @return [void]
	 */
    // RAD Tools: AdminBox Style
    function loadEditActivityTypes( $isCreated=false ) 
    {
	    
        // GROUP 3: SUPER ADMINS ONLY.
        if ( $this->accessPrivManager->hasSitePriv()){
      
	        // compile a formAction for the adminBox
	        $parameters = array('PERSON_ID'=>$this->PERSON_ID, 'PROVINCE_ID'=>$this->PROVINCE_ID, 'GENDER_ID'=>$this->GENDER_ID, 'STAFF_ID'=>$this->STAFF_ID, 'REGION_ID'=>$this->REGION_ID, 'EMERG_ID'=>$this->EMERG_ID, 'ASSIGNSTATUS_ID'=>$this->ASSIGNSTATUS_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'ASSIGNMENT_ID'=>$this->ASSIGNMENT_ID, 'VIEWER_ID'=>$this->VIEWER_ID, 'ACCESS_ID'=>$this->ACCESS_ID, 'YEAR_ID'=>$this->YEAR_ID, 'PERSON_YEAR_ID'=>$this->PERSON_YEAR_ID, 'STAFFSCHEDULE_ID'=>$this->STAFFSCHEDULE_ID, 'STAFFACTIVITY_ID'=>$this->STAFFACTIVITY_ID, 'ACTIVITYTYPE_ID'=>$this->ACTIVITYTYPE_ID, 'STAFFSCHEDULETYPE_ID'=>$this->STAFFSCHEDULETYPE_ID, 'ACTIVITYSCHEDULE_ID'=>$this->ACTIVITYSCHEDULE_ID, 'FIELD_ID'=>$this->FIELD_ID, 'FIELDVALUE_ID'=>$this->FIELDVALUE_ID, 'FIELDTYPE_ID'=>$this->FIELDTYPE_ID, 'DATATYPE_ID'=>$this->DATATYPE_ID, 'COUNTRY_ID'=>$this->COUNTRY_ID, 'FIELDGROUP_ID'=>$this->FIELDGROUP_ID, 'FIELDGROUP_MATCHES_ID'=>$this->FIELDGROUP_MATCHES_ID, 'STAFFDIRECTOR_ID'=>$this->STAFFDIRECTOR_ID);//[RAD_CALLBACK_PARAMS]
	        $formAction = $this->getCallBack(modulecim_hrdb::PAGE_EDITACTIVITYTYPES, $this->sortBy, $parameters );
	        
	        // set the pageCallBack value.  This is used by the Language switching
	        // code
	        $this->setPageCallBack( $formAction );
	        
	        // if this pageDisplay object isn't already created then 
	        if ( !$isCreated ) {
	        
	            // create a new pageDisplay object
	            $this->pageDisplay = new FormProcessor_EditActivityTypes( $this->moduleRootPath, $this->viewer, $formAction, $this->sortBy,  $this->ACTIVITYTYPE_ID, $this->ACTIVITYTYPE_ID );//[RAD_FORMINIT_FOREIGNKEY_INIT]    
	        
	        } else {
	        
	            // otherwise just update the formAction value
	            $this->pageDisplay->setFormAction( $formAction );
	        }
	        
	        $links = array();
	        
	        $parameters = array( );//[RAD_CALLBACK_PARAMS_EDIT]
	        $editLink = $this->getCallBack( modulecim_hrdb::PAGE_EDITACTIVITYTYPES, $this->sortBy, $parameters );
	        $editLink .= "&". modulecim_hrdb::ACTIVITYTYPE_ID . "=";
	        $links[ "edit" ] = $editLink;
	        
	        // NOTE: delete link is same as edit link for an AdminBox
	        $links[ "del" ] = $editLink;
	
	/*[RAD_LINK_INSERT]*/
	
	        $parameters = array('PERSON_ID'=>$this->PERSON_ID, 'PROVINCE_ID'=>$this->PROVINCE_ID, 'GENDER_ID'=>$this->GENDER_ID, 'STAFF_ID'=>$this->STAFF_ID, 'REGION_ID'=>$this->REGION_ID, 'EMERG_ID'=>$this->EMERG_ID, 'ASSIGNSTATUS_ID'=>$this->ASSIGNSTATUS_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'ASSIGNMENT_ID'=>$this->ASSIGNMENT_ID, 'VIEWER_ID'=>$this->VIEWER_ID, 'ACCESS_ID'=>$this->ACCESS_ID, 'YEAR_ID'=>$this->YEAR_ID, 'PERSON_YEAR_ID'=>$this->PERSON_YEAR_ID, 'STAFFSCHEDULE_ID'=>$this->STAFFSCHEDULE_ID, 'STAFFACTIVITY_ID'=>$this->STAFFACTIVITY_ID, 'ACTIVITYTYPE_ID'=>$this->ACTIVITYTYPE_ID, 'STAFFSCHEDULETYPE_ID'=>$this->STAFFSCHEDULETYPE_ID, 'ACTIVITYSCHEDULE_ID'=>$this->ACTIVITYSCHEDULE_ID, 'FIELD_ID'=>$this->FIELD_ID, 'FIELDVALUE_ID'=>$this->FIELDVALUE_ID, 'FIELDTYPE_ID'=>$this->FIELDTYPE_ID, 'DATATYPE_ID'=>$this->DATATYPE_ID, 'COUNTRY_ID'=>$this->COUNTRY_ID, 'FIELDGROUP_ID'=>$this->FIELDGROUP_ID, 'FIELDGROUP_MATCHES_ID'=>$this->FIELDGROUP_MATCHES_ID, 'STAFFDIRECTOR_ID'=>$this->STAFFDIRECTOR_ID);//[RAD_CALLBACK_PARAMS]
	        $sortByLink = $this->getCallBack( modulecim_hrdb::PAGE_EDITACTIVITYTYPES, '', $parameters );
	        $sortByLink .= "&".modulecim_hrdb::SORTBY."=";
	        $links["sortBy"] = $sortByLink;
	
	        $this->pageDisplay->setLinks( $links );    
        }
        else
        {
	        $this->pageDisplay = new page_NotAuthorized($this->moduleRootPath, $this->viewer);  
        }
                
    } // end loadEditActivityTypes()



    //************************************************************************
	/**
	 * function loadEditCustomReports
	 * <pre>
	 * Initializes the EditCustomReports Page.
	 * </pre>
	 * @param $isCreated [BOOL] "Is THIS pageDisplay object already created?"
	 * @return [void]
	 */
    // RAD Tools: AdminBox Style
    function loadEditCustomReports( $isCreated=false ) 
    {
        // GROUP 3: SUPER ADMINS ONLY. 
        if ( $this->accessPrivManager->hasSitePriv() ){	 	    
		    
	                // compile a formAction for the adminBox
	        $parameters = array('PERSON_ID'=>$this->PERSON_ID, 'PROVINCE_ID'=>$this->PROVINCE_ID, 'GENDER_ID'=>$this->GENDER_ID, 'STAFF_ID'=>$this->STAFF_ID, 'REGION_ID'=>$this->REGION_ID, 'EMERG_ID'=>$this->EMERG_ID, 'ASSIGNSTATUS_ID'=>$this->ASSIGNSTATUS_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'ASSIGNMENT_ID'=>$this->ASSIGNMENT_ID, 'VIEWER_ID'=>$this->VIEWER_ID, 'ACCESS_ID'=>$this->ACCESS_ID, 'YEAR_ID'=>$this->YEAR_ID, 'PERSON_YEAR_ID'=>$this->PERSON_YEAR_ID, 'STAFFSCHEDULE_ID'=>$this->STAFFSCHEDULE_ID, 'STAFFACTIVITY_ID'=>$this->STAFFACTIVITY_ID, 'ACTIVITYTYPE_ID'=>$this->ACTIVITYTYPE_ID, 'STAFFSCHEDULETYPE_ID'=>$this->STAFFSCHEDULETYPE_ID, 'ACTIVITYSCHEDULE_ID'=>$this->ACTIVITYSCHEDULE_ID, 'FIELD_ID'=>$this->FIELD_ID, 'FIELDVALUE_ID'=>$this->FIELDVALUE_ID, 'FIELDTYPE_ID'=>$this->FIELDTYPE_ID, 'DATATYPE_ID'=>$this->DATATYPE_ID, 'COUNTRY_ID'=>$this->COUNTRY_ID, 'FIELDGROUP_ID'=>$this->FIELDGROUP_ID, 'FIELDGROUP_MATCHES_ID'=>$this->FIELDGROUP_MATCHES_ID, 'STAFFDIRECTOR_ID'=>$this->STAFFDIRECTOR_ID, 'REPORT_ID'=>$this->REPORT_ID, 'CUSTOMFIELD_ID'=>$this->CUSTOMFIELD_ID);//[RAD_CALLBACK_PARAMS]
	        $formAction = $this->getCallBack(modulecim_hrdb::PAGE_EDITCUSTOMREPORTS, $this->sortBy, $parameters );
	        
	        // set the pageCallBack value.  This is used by the Language switching
	        // code
	        $this->setPageCallBack( $formAction );
	        
	        // if this pageDisplay object isn't already created then 
	        if ( !$isCreated ) {
	        
	            // create a new pageDisplay object
	            $this->pageDisplay = new FormProcessor_EditCustomReports( $this->moduleRootPath, $this->viewer, $formAction, $this->sortBy,  $this->CUSTOMFIELD_ID, $this->REPORT_ID , $this->FIELD_ID);//[RAD_FORMINIT_FOREIGNKEY_INIT]    
	        
	        } else {
	        
	            // otherwise just update the formAction value
	            $this->pageDisplay->setFormAction( $formAction );
	        }
	        
	        $links = array();
	        
	        $parameters = array('PERSON_ID'=>$this->PERSON_ID, 'PROVINCE_ID'=>$this->PROVINCE_ID, 'GENDER_ID'=>$this->GENDER_ID, 'STAFF_ID'=>$this->STAFF_ID, 'REGION_ID'=>$this->REGION_ID, 'EMERG_ID'=>$this->EMERG_ID, 'ASSIGNSTATUS_ID'=>$this->ASSIGNSTATUS_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'ASSIGNMENT_ID'=>$this->ASSIGNMENT_ID, 'VIEWER_ID'=>$this->VIEWER_ID, 'ACCESS_ID'=>$this->ACCESS_ID, 'YEAR_ID'=>$this->YEAR_ID, 'PERSON_YEAR_ID'=>$this->PERSON_YEAR_ID, 'STAFFSCHEDULE_ID'=>$this->STAFFSCHEDULE_ID, 'STAFFACTIVITY_ID'=>$this->STAFFACTIVITY_ID, 'ACTIVITYTYPE_ID'=>$this->ACTIVITYTYPE_ID, 'STAFFSCHEDULETYPE_ID'=>$this->STAFFSCHEDULETYPE_ID, 'ACTIVITYSCHEDULE_ID'=>$this->ACTIVITYSCHEDULE_ID, 'FIELD_ID'=>$this->FIELD_ID, 'FIELDVALUE_ID'=>$this->FIELDVALUE_ID, 'FIELDTYPE_ID'=>$this->FIELDTYPE_ID, 'DATATYPE_ID'=>$this->DATATYPE_ID, 'COUNTRY_ID'=>$this->COUNTRY_ID, 'FIELDGROUP_ID'=>$this->FIELDGROUP_ID, 'FIELDGROUP_MATCHES_ID'=>$this->FIELDGROUP_MATCHES_ID, 'STAFFDIRECTOR_ID'=>$this->STAFFDIRECTOR_ID, 'REPORT_ID'=>$this->REPORT_ID, 'CUSTOMFIELD_ID'=>$this->CUSTOMFIELD_ID);//[RAD_CALLBACK_PARAMS]
	        $editLink = $this->getCallBack( modulecim_hrdb::PAGE_EDITCUSTOMREPORTS, $this->sortBy, $parameters );
	        $editLink .= "&". modulecim_hrdb::CUSTOMFIELD_ID . "=";
	        $links[ "edit" ] = $editLink;
	        
	        // NOTE: delete link is same as edit link for an AdminBox
	        $links[ "del" ] = $editLink;
	
	/*[RAD_LINK_INSERT]*/
	
	        $parameters = array('PERSON_ID'=>$this->PERSON_ID, 'PROVINCE_ID'=>$this->PROVINCE_ID, 'GENDER_ID'=>$this->GENDER_ID, 'STAFF_ID'=>$this->STAFF_ID, 'REGION_ID'=>$this->REGION_ID, 'EMERG_ID'=>$this->EMERG_ID, 'ASSIGNSTATUS_ID'=>$this->ASSIGNSTATUS_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'ASSIGNMENT_ID'=>$this->ASSIGNMENT_ID, 'VIEWER_ID'=>$this->VIEWER_ID, 'ACCESS_ID'=>$this->ACCESS_ID, 'YEAR_ID'=>$this->YEAR_ID, 'PERSON_YEAR_ID'=>$this->PERSON_YEAR_ID, 'STAFFSCHEDULE_ID'=>$this->STAFFSCHEDULE_ID, 'STAFFACTIVITY_ID'=>$this->STAFFACTIVITY_ID, 'ACTIVITYTYPE_ID'=>$this->ACTIVITYTYPE_ID, 'STAFFSCHEDULETYPE_ID'=>$this->STAFFSCHEDULETYPE_ID, 'ACTIVITYSCHEDULE_ID'=>$this->ACTIVITYSCHEDULE_ID, 'FIELD_ID'=>$this->FIELD_ID, 'FIELDVALUE_ID'=>$this->FIELDVALUE_ID, 'FIELDTYPE_ID'=>$this->FIELDTYPE_ID, 'DATATYPE_ID'=>$this->DATATYPE_ID, 'COUNTRY_ID'=>$this->COUNTRY_ID, 'FIELDGROUP_ID'=>$this->FIELDGROUP_ID, 'FIELDGROUP_MATCHES_ID'=>$this->FIELDGROUP_MATCHES_ID, 'STAFFDIRECTOR_ID'=>$this->STAFFDIRECTOR_ID, 'REPORT_ID'=>$this->REPORT_ID, 'CUSTOMFIELD_ID'=>$this->CUSTOMFIELD_ID);//[RAD_CALLBACK_PARAMS]
	        $sortByLink = $this->getCallBack( modulecim_hrdb::PAGE_EDITCUSTOMREPORTS, '', $parameters );
	        $sortByLink .= "&".modulecim_hrdb::SORTBY."=";
	        $links["sortBy"] = $sortByLink;
	
	        $this->pageDisplay->setLinks( $links ); 
        }
        else
        {
	        $this->pageDisplay = new page_NotAuthorized($this->moduleRootPath, $this->viewer);  
        }   
    
    } // end loadEditCustomReports()


    //************************************************************************
	/**
	 * function loadViewCustomReport
	 * <pre>
	 * Initializes the ViewCustomReport Page.
	 * </pre>
	 * @return [void]
	 */
    // RAD Tools: DataListTable Style
    function loadViewCustomReport() 
    {
        // GROUP 2: STAFF AND ABOVE ONLY.  
        if ((( $this->accessPrivManager->hasSitePriv() ) || ( $this->accessPrivManager->isStaff($this->viewer->getID()) )) ){	    
	    
	        // set the pageCallBack to be without any additional parameters
	        // (an AdminBox needs this so Language Switching on a page doesn't
	        // pass a previous operations)
	        $parameters = array('PERSON_ID'=>$this->PERSON_ID, 'PROVINCE_ID'=>$this->PROVINCE_ID, 'GENDER_ID'=>$this->GENDER_ID, 'STAFF_ID'=>$this->STAFF_ID, 'REGION_ID'=>$this->REGION_ID, 'EMERG_ID'=>$this->EMERG_ID, 'ASSIGNSTATUS_ID'=>$this->ASSIGNSTATUS_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'ASSIGNMENT_ID'=>$this->ASSIGNMENT_ID, 'VIEWER_ID'=>$this->VIEWER_ID, 'ACCESS_ID'=>$this->ACCESS_ID, 'YEAR_ID'=>$this->YEAR_ID, 'PERSON_YEAR_ID'=>$this->PERSON_YEAR_ID, 'STAFFSCHEDULE_ID'=>$this->STAFFSCHEDULE_ID, 'STAFFACTIVITY_ID'=>$this->STAFFACTIVITY_ID, 'ACTIVITYTYPE_ID'=>$this->ACTIVITYTYPE_ID, 'STAFFSCHEDULETYPE_ID'=>$this->STAFFSCHEDULETYPE_ID, 'ACTIVITYSCHEDULE_ID'=>$this->ACTIVITYSCHEDULE_ID, 'FIELD_ID'=>$this->FIELD_ID, 'FIELDVALUE_ID'=>$this->FIELDVALUE_ID, 'FIELDTYPE_ID'=>$this->FIELDTYPE_ID, 'DATATYPE_ID'=>$this->DATATYPE_ID, 'COUNTRY_ID'=>$this->COUNTRY_ID, 'FIELDGROUP_ID'=>$this->FIELDGROUP_ID, 'FIELDGROUP_MATCHES_ID'=>$this->FIELDGROUP_MATCHES_ID, 'STAFFDIRECTOR_ID'=>$this->STAFFDIRECTOR_ID);//[RAD_CALLBACK_PARAMS]
	        $pageCallBack = $this->getCallBack(modulecim_hrdb::PAGE_VIEWCUSTOMREPORT, $this->sortBy, $parameters);
	        $this->setPageCallBack( $pageCallBack );
	        
// 	        $this->CUSTOMREPORT_ID = 1;			/** TEST LINE **/
	        $this->pageDisplay = new page_ViewCustomReport( $this->moduleRootPath, $this->viewer, $this->REPORT_ID);    
	        
	        $links = array();
	        
	/*[RAD_LINK_INSERT]*/
			  $this->DOWNLOAD_TYPE = modulecim_hrdb::DOWNLOAD_CUSTOM_REPORT;
	        $fileDownloadParameters = array('REPORT_ID'=>$this->REPORT_ID, 'DOWNLOAD_TYPE'=>$this->DOWNLOAD_TYPE);//[RAD_CALLBACK_PARAMS]              
	        $csvLink = $this->getCallBack( modulecim_hrdb::PAGE_DOWNLOADCSV, '', $fileDownloadParameters );
	        $links["DownloadCustomReportCSV"] = $csvLink;             //Custom Report data - for importing into Excel     	
	
// 	        $parameters = array('PERSON_ID'=>$this->PERSON_ID, 'PROVINCE_ID'=>$this->PROVINCE_ID, 'GENDER_ID'=>$this->GENDER_ID, 'STAFF_ID'=>$this->STAFF_ID, 'REGION_ID'=>$this->REGION_ID, 'EMERG_ID'=>$this->EMERG_ID, 'ASSIGNSTATUS_ID'=>$this->ASSIGNSTATUS_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'ASSIGNMENT_ID'=>$this->ASSIGNMENT_ID, 'VIEWER_ID'=>$this->VIEWER_ID, 'ACCESS_ID'=>$this->ACCESS_ID, 'YEAR_ID'=>$this->YEAR_ID, 'PERSON_YEAR_ID'=>$this->PERSON_YEAR_ID, 'STAFFSCHEDULE_ID'=>$this->STAFFSCHEDULE_ID, 'STAFFACTIVITY_ID'=>$this->STAFFACTIVITY_ID, 'ACTIVITYTYPE_ID'=>$this->ACTIVITYTYPE_ID, 'STAFFSCHEDULETYPE_ID'=>$this->STAFFSCHEDULETYPE_ID, 'ACTIVITYSCHEDULE_ID'=>$this->ACTIVITYSCHEDULE_ID, 'FIELD_ID'=>$this->FIELD_ID, 'FIELDVALUE_ID'=>$this->FIELDVALUE_ID, 'FIELDTYPE_ID'=>$this->FIELDTYPE_ID, 'DATATYPE_ID'=>$this->DATATYPE_ID, 'COUNTRY_ID'=>$this->COUNTRY_ID, 'FIELDGROUP_ID'=>$this->FIELDGROUP_ID, 'FIELDGROUP_MATCHES_ID'=>$this->FIELDGROUP_MATCHES_ID, 'STAFFDIRECTOR_ID'=>$this->STAFFDIRECTOR_ID);//[RAD_CALLBACK_PARAMS]
// 	        $sortByLink = $this->getCallBack( modulecim_hrdb::PAGE_VIEWCUSTOMREPORT, '', $parameters );
// 	        $sortByLink .= "&".modulecim_hrdb::SORTBY."=";
// 	        $links["sortBy"] = $sortByLink;
	
	        $this->pageDisplay->setLinks( $links );
        
        }
        else
        {
	        $this->pageDisplay = new page_NotAuthorized($this->moduleRootPath, $this->viewer);  
        }           
        
    } // end loadViewStaffActivities()                


    //************************************************************************
	/**
	 * function loadCustomReportsListing
	 * <pre>
	 * Initializes the CustomReportsListing Page.
	 * </pre>
	 * @return [void]
	 */
    // RAD Tools: DataListTable Style
    function loadCustomReportsListing( $isCreated = false ) 
    {
	    // STAFF ONLY
        if ((( $this->accessPrivManager->hasSitePriv() ) || ( $this->accessPrivManager->isStaff($this->viewer->getID()) )) ){	 	    
	    
	        // set the pageCallBack to be without any additional parameters
	        // (an AdminBox needs this so Language Switching on a page doesn't
	        // pass a previous operations)
	        $parameters = array('REPORT_ID'=>$this->REPORT_ID, 'PERSON_ID'=>$this->PERSON_ID, 'PROVINCE_ID'=>$this->PROVINCE_ID, 'GENDER_ID'=>$this->GENDER_ID, 'STAFF_ID'=>$this->STAFF_ID, 'REGION_ID'=>$this->REGION_ID, 'EMERG_ID'=>$this->EMERG_ID, 'ASSIGNSTATUS_ID'=>$this->ASSIGNSTATUS_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'ASSIGNMENT_ID'=>$this->ASSIGNMENT_ID, 'VIEWER_ID'=>$this->VIEWER_ID, 'ACCESS_ID'=>$this->ACCESS_ID, 'YEAR_ID'=>$this->YEAR_ID, 'PERSON_YEAR_ID'=>$this->PERSON_YEAR_ID, 'STAFFSCHEDULE_ID'=>$this->STAFFSCHEDULE_ID, 'STAFFACTIVITY_ID'=>$this->STAFFACTIVITY_ID, 'ACTIVITYTYPE_ID'=>$this->ACTIVITYTYPE_ID, 'STAFFSCHEDULETYPE_ID'=>$this->STAFFSCHEDULETYPE_ID, 'ACTIVITYSCHEDULE_ID'=>$this->ACTIVITYSCHEDULE_ID);//[RAD_CALLBACK_PARAMS]
	        $pageCallBack = $this->getCallBack(modulecim_hrdb::PAGE_CUSTOMREPORTSLISTING, $this->sortBy, $parameters);
	        $this->setPageCallBack( $pageCallBack );
	        
	        $parameters = array('REPORT_ID'=>$this->REPORT_ID, 'FORMLIST_TYPE'=>$this->FORMLIST_TYPE, 'PERSON_ID'=>$this->PERSON_ID, 'PROVINCE_ID'=>$this->PROVINCE_ID, 'GENDER_ID'=>$this->GENDER_ID, 'STAFF_ID'=>$this->STAFF_ID, 'REGION_ID'=>$this->REGION_ID, 'EMERG_ID'=>$this->EMERG_ID, 'ASSIGNSTATUS_ID'=>$this->ASSIGNSTATUS_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'ASSIGNMENT_ID'=>$this->ASSIGNMENT_ID, 'VIEWER_ID'=>$this->VIEWER_ID, 'ACCESS_ID'=>$this->ACCESS_ID, 'YEAR_ID'=>$this->YEAR_ID, 'PERSON_YEAR_ID'=>$this->PERSON_YEAR_ID, 'STAFFSCHEDULE_ID'=>$this->STAFFSCHEDULE_ID, 'STAFFACTIVITY_ID'=>$this->STAFFACTIVITY_ID, 'ACTIVITYTYPE_ID'=>$this->ACTIVITYTYPE_ID, 'STAFFSCHEDULETYPE_ID'=>$this->STAFFSCHEDULETYPE_ID, 'ACTIVITYSCHEDULE_ID'=>$this->ACTIVITYSCHEDULE_ID, 'FIELD_ID'=>$this->FIELD_ID, 'FIELDVALUE_ID'=>$this->FIELDVALUE_ID, 'FIELDTYPE_ID'=>$this->FIELDTYPE_ID, 'DATATYPE_ID'=>$this->DATATYPE_ID, 'COUNTRY_ID'=>$this->COUNTRY_ID);//[RAD_CALLBACK_PARAMS]	      
	        $formAction = $this->getCallBack(modulecim_hrdb::PAGE_CUSTOMREPORTSLISTING, $this->sortBy, $parameters );              
	        
	        $this->pageDisplay = new page_CustomReportsListing( $this->moduleRootPath, $this->viewer, $this->sortBy, $formAction, $this->FORMLIST_TYPE);    
	        
	        $links = array();
	        
	/*[RAD_LINK_INSERT]*/
	
	
	        $parameters = array('PERSON_ID'=>$this->PERSON_ID, 'PROVINCE_ID'=>$this->PROVINCE_ID, 'GENDER_ID'=>$this->GENDER_ID, 'STAFF_ID'=>$this->STAFF_ID, 'REGION_ID'=>$this->REGION_ID, 'EMERG_ID'=>$this->EMERG_ID, 'ASSIGNSTATUS_ID'=>$this->ASSIGNSTATUS_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'ASSIGNMENT_ID'=>$this->ASSIGNMENT_ID, 'VIEWER_ID'=>$this->VIEWER_ID, 'ACCESS_ID'=>$this->ACCESS_ID, 'YEAR_ID'=>$this->YEAR_ID, 'PERSON_YEAR_ID'=>$this->PERSON_YEAR_ID, 'STAFFSCHEDULE_ID'=>$this->STAFFSCHEDULE_ID, 'STAFFACTIVITY_ID'=>$this->STAFFACTIVITY_ID, 'ACTIVITYTYPE_ID'=>$this->ACTIVITYTYPE_ID, 'STAFFSCHEDULETYPE_ID'=>$this->STAFFSCHEDULETYPE_ID, 'ACTIVITYSCHEDULE_ID'=>$this->ACTIVITYSCHEDULE_ID);//[RAD_CALLBACK_PARAMS]
	        $sortByLink = $this->getCallBack( modulecim_hrdb::PAGE_CUSTOMREPORTSLISTING, '', $parameters );
	        $sortByLink .= "&".modulecim_hrdb::SORTBY."=";
	        $links["sortBy"] = $sortByLink;
	        
	        // GROUP 2: STAFF AND ABOVE ONLY.   (access HRDB forms)				// $this->FORMLIST_TYPE == modulecim_hrdb::FORMLIST_ACCESS && (( 
	        if (($this->FORMLIST_TYPE == modulecim_hrdb::FORMLIST_ACCESS) && (($this->accessPrivManager->hasSitePriv() ) || ( $this->accessPrivManager->isStaff($this->viewer->getID()) )) ){
	
		        $parameters = array('PERSON_ID'=>$this->PERSON_ID, 'PROVINCE_ID'=>$this->PROVINCE_ID, 'GENDER_ID'=>$this->GENDER_ID, 'STAFF_ID'=>$this->STAFF_ID, 'REGION_ID'=>$this->REGION_ID, 'EMERG_ID'=>$this->EMERG_ID, 'ASSIGNSTATUS_ID'=>$this->ASSIGNSTATUS_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'ASSIGNMENT_ID'=>$this->ASSIGNMENT_ID, 'VIEWER_ID'=>$this->VIEWER_ID, 'ACCESS_ID'=>$this->ACCESS_ID, 'YEAR_ID'=>$this->YEAR_ID, 'PERSON_YEAR_ID'=>$this->PERSON_YEAR_ID, 'STAFFSCHEDULE_ID'=>$this->STAFFSCHEDULE_ID, 'STAFFACTIVITY_ID'=>$this->STAFFACTIVITY_ID, 'ACTIVITYTYPE_ID'=>$this->ACTIVITYTYPE_ID, 'STAFFSCHEDULETYPE_ID'=>$this->STAFFSCHEDULETYPE_ID, 'ACTIVITYSCHEDULE_ID'=>$this->ACTIVITYSCHEDULE_ID);//[RAD_CALLBACK_PARAMS]
		        $link = $this->getCallBack( modulecim_hrdb::PAGE_VIEWCUSTOMREPORT, '', $parameters );
		        $link .= "&".modulecim_hrdb::REPORT_ID."=";
		        $links["access"] = $link;
		        
	 	        $this->pageDisplay->setAccessType(page_CustomReportsListing::ACCESS_GENERAL);
	 	        
	        }    
	        
	        	        // GROUP 3: SUPER ADMINS ONLY.
	        if ( ($this->FORMLIST_TYPE == modulecim_hrdb::FORMLIST_EDIT) && ($this->accessPrivManager->hasSitePriv())){
		        
	        $parameters = array('PERSON_ID'=>$this->PERSON_ID, 'PROVINCE_ID'=>$this->PROVINCE_ID, 'GENDER_ID'=>$this->GENDER_ID, 'STAFF_ID'=>$this->STAFF_ID, 'REGION_ID'=>$this->REGION_ID, 'EMERG_ID'=>$this->EMERG_ID, 'ASSIGNSTATUS_ID'=>$this->ASSIGNSTATUS_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'ASSIGNMENT_ID'=>$this->ASSIGNMENT_ID, 'VIEWER_ID'=>$this->VIEWER_ID, 'ACCESS_ID'=>$this->ACCESS_ID, 'YEAR_ID'=>$this->YEAR_ID, 'PERSON_YEAR_ID'=>$this->PERSON_YEAR_ID, 'STAFFSCHEDULE_ID'=>$this->STAFFSCHEDULE_ID, 'STAFFACTIVITY_ID'=>$this->STAFFACTIVITY_ID, 'ACTIVITYTYPE_ID'=>$this->ACTIVITYTYPE_ID, 'STAFFSCHEDULETYPE_ID'=>$this->STAFFSCHEDULETYPE_ID, 'ACTIVITYSCHEDULE_ID'=>$this->ACTIVITYSCHEDULE_ID);//[RAD_CALLBACK_PARAMS]
		        $link = $this->getCallBack( modulecim_hrdb::PAGE_EDITCUSTOMREPORTMETADATA, '', $parameters );	
		        $link .= "&".modulecim_hrdb::REPORT_ID."=";
		        $links["admin"] = $link;	
		        
		        $this->pageDisplay->setAccessType(page_CustomReportsListing::ACCESS_SUPERADMIN);    
	        }   
	
	        $this->pageDisplay->setLinks( $links ); 
        }
        else
        {
	        $this->pageDisplay = new page_NotAuthorized($this->moduleRootPath, $this->viewer);  
        }   	        
        
    } // end loadCustomReportsListing()



    //************************************************************************
	/**
	 * function loadEditStaff
	 * <pre>
	 * Initializes the EditStaff Page.
	 * </pre>
	 * @param $isCreated [BOOL] "Is THIS pageDisplay object already created?"
	 * @return [void]
	 */
    // RAD Tools: AdminBox Style
    function loadEditStaff( $isCreated=false ) 
    {
        // SUPERADMIN ONLY.  
        if ( $this->accessPrivManager->hasSitePriv()  ){	    
	        
	        // compile a formAction for the adminBox
	        $parameters = array('PERSON_ID'=>$this->PERSON_ID, 'PROVINCE_ID'=>$this->PROVINCE_ID, 'GENDER_ID'=>$this->GENDER_ID, 'STAFF_ID'=>$this->STAFF_ID, 'REGION_ID'=>$this->REGION_ID, 'EMERG_ID'=>$this->EMERG_ID, 'ASSIGNSTATUS_ID'=>$this->ASSIGNSTATUS_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'ASSIGNMENT_ID'=>$this->ASSIGNMENT_ID, 'VIEWER_ID'=>$this->VIEWER_ID, 'ACCESS_ID'=>$this->ACCESS_ID, 'YEAR_ID'=>$this->YEAR_ID, 'PERSON_YEAR_ID'=>$this->PERSON_YEAR_ID, 'STAFFSCHEDULE_ID'=>$this->STAFFSCHEDULE_ID, 'STAFFACTIVITY_ID'=>$this->STAFFACTIVITY_ID, 'ACTIVITYTYPE_ID'=>$this->ACTIVITYTYPE_ID, 'STAFFSCHEDULETYPE_ID'=>$this->STAFFSCHEDULETYPE_ID, 'ACTIVITYSCHEDULE_ID'=>$this->ACTIVITYSCHEDULE_ID, 'FIELD_ID'=>$this->FIELD_ID, 'FIELDVALUE_ID'=>$this->FIELDVALUE_ID, 'FIELDTYPE_ID'=>$this->FIELDTYPE_ID, 'DATATYPE_ID'=>$this->DATATYPE_ID, 'COUNTRY_ID'=>$this->COUNTRY_ID, 'FIELDGROUP_ID'=>$this->FIELDGROUP_ID, 'FIELDGROUP_MATCHES_ID'=>$this->FIELDGROUP_MATCHES_ID, 'STAFFDIRECTOR_ID'=>$this->STAFFDIRECTOR_ID, 'REPORT_ID'=>$this->REPORT_ID, 'CUSTOMFIELD_ID'=>$this->CUSTOMFIELD_ID);//[RAD_CALLBACK_PARAMS]
	        $formAction = $this->getCallBack(modulecim_hrdb::PAGE_EDITSTAFF, $this->sortBy, $parameters );
	        
	        // set the pageCallBack value.  This is used by the Language switching
	        // code
	        $this->setPageCallBack( $formAction );
	        
	        // if this pageDisplay object isn't already created then 
	        if ( !$isCreated ) {
	        
	            // create a new pageDisplay object
	            $this->pageDisplay = new FormProcessor_EditStaff( $this->moduleRootPath, $this->viewer, $formAction, $this->sortBy, $this->STAFF_ID , $this->PERSON_ID);//[RAD_FORMINIT_FOREIGNKEY_INIT]    
	
	        } else {
	        
	            // otherwise just update the formAction value
	            $this->pageDisplay->setFormAction( $formAction );
	        }
	
	        
	        $links = array();
	        
	        $parameters = array( );//[RAD_CALLBACK_PARAMS_EDIT]
	        $editLink = $this->getCallBack( modulecim_hrdb::PAGE_EDITSTAFF, $this->sortBy, $parameters );
	        $editLink .= "&". modulecim_hrdb::STAFF_ID . "=";
	        $links[ "edit" ] = $editLink;
	        
	        // NOTE: delete link is same as edit link for an AdminBox
	        $links[ "del" ] = $editLink;
	
	/*[RAD_LINK_INSERT]*/
	
	        $parameters = array('PERSON_ID'=>$this->PERSON_ID, 'PROVINCE_ID'=>$this->PROVINCE_ID, 'GENDER_ID'=>$this->GENDER_ID, 'STAFF_ID'=>$this->STAFF_ID, 'REGION_ID'=>$this->REGION_ID, 'EMERG_ID'=>$this->EMERG_ID, 'ASSIGNSTATUS_ID'=>$this->ASSIGNSTATUS_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'ASSIGNMENT_ID'=>$this->ASSIGNMENT_ID, 'VIEWER_ID'=>$this->VIEWER_ID, 'ACCESS_ID'=>$this->ACCESS_ID, 'YEAR_ID'=>$this->YEAR_ID, 'PERSON_YEAR_ID'=>$this->PERSON_YEAR_ID, 'STAFFSCHEDULE_ID'=>$this->STAFFSCHEDULE_ID, 'STAFFACTIVITY_ID'=>$this->STAFFACTIVITY_ID, 'ACTIVITYTYPE_ID'=>$this->ACTIVITYTYPE_ID, 'STAFFSCHEDULETYPE_ID'=>$this->STAFFSCHEDULETYPE_ID, 'ACTIVITYSCHEDULE_ID'=>$this->ACTIVITYSCHEDULE_ID, 'FIELD_ID'=>$this->FIELD_ID, 'FIELDVALUE_ID'=>$this->FIELDVALUE_ID, 'FIELDTYPE_ID'=>$this->FIELDTYPE_ID, 'DATATYPE_ID'=>$this->DATATYPE_ID, 'COUNTRY_ID'=>$this->COUNTRY_ID, 'FIELDGROUP_ID'=>$this->FIELDGROUP_ID, 'FIELDGROUP_MATCHES_ID'=>$this->FIELDGROUP_MATCHES_ID, 'STAFFDIRECTOR_ID'=>$this->STAFFDIRECTOR_ID, 'REPORT_ID'=>$this->REPORT_ID, 'CUSTOMFIELD_ID'=>$this->CUSTOMFIELD_ID);//[RAD_CALLBACK_PARAMS]
	        $sortByLink = $this->getCallBack( modulecim_hrdb::PAGE_EDITSTAFF, '', $parameters );
	        $sortByLink .= "&".modulecim_hrdb::SORTBY."=";
	        $links["sortBy"] = $sortByLink;
	
	        $this->pageDisplay->setLinks( $links );    
        }
        else
        {
	        $this->pageDisplay = new page_NotAuthorized($this->moduleRootPath, $this->viewer);  
        }   
        
    } // end loadEditStaff()



    //************************************************************************
	/**
	 * function loadEditCustomReportMetaData
	 * <pre>
	 * Initializes the EditCustomReportMetaData Page.
	 * </pre>
	 * @return [void]
	 */
    // RAD Tools: FormSingleEntry style
    function loadEditCustomReportMetaData() 
    {
        // set the pageCallBack to be without any additional parameters
        // (an AdminBox needs this so Language Switching on a page doesn't
        // pass a previous operations)
        $parameters = array('PERSON_ID'=>$this->PERSON_ID, 'PROVINCE_ID'=>$this->PROVINCE_ID, 'GENDER_ID'=>$this->GENDER_ID, 'STAFF_ID'=>$this->STAFF_ID, 'REGION_ID'=>$this->REGION_ID, 'EMERG_ID'=>$this->EMERG_ID, 'ASSIGNSTATUS_ID'=>$this->ASSIGNSTATUS_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'ASSIGNMENT_ID'=>$this->ASSIGNMENT_ID, 'VIEWER_ID'=>$this->VIEWER_ID, 'ACCESS_ID'=>$this->ACCESS_ID, 'YEAR_ID'=>$this->YEAR_ID, 'PERSON_YEAR_ID'=>$this->PERSON_YEAR_ID, 'STAFFSCHEDULE_ID'=>$this->STAFFSCHEDULE_ID, 'STAFFACTIVITY_ID'=>$this->STAFFACTIVITY_ID, 'ACTIVITYTYPE_ID'=>$this->ACTIVITYTYPE_ID, 'STAFFSCHEDULETYPE_ID'=>$this->STAFFSCHEDULETYPE_ID, 'ACTIVITYSCHEDULE_ID'=>$this->ACTIVITYSCHEDULE_ID, 'FIELD_ID'=>$this->FIELD_ID, 'FIELDVALUE_ID'=>$this->FIELDVALUE_ID, 'FIELDTYPE_ID'=>$this->FIELDTYPE_ID, 'DATATYPE_ID'=>$this->DATATYPE_ID, 'COUNTRY_ID'=>$this->COUNTRY_ID, 'FIELDGROUP_ID'=>$this->FIELDGROUP_ID, 'FIELDGROUP_MATCHES_ID'=>$this->FIELDGROUP_MATCHES_ID, 'STAFFDIRECTOR_ID'=>$this->STAFFDIRECTOR_ID, 'REPORT_ID'=>$this->REPORT_ID, 'CUSTOMFIELD_ID'=>$this->CUSTOMFIELD_ID);//[RAD_CALLBACK_PARAMS]
        $pageCallBack = $this->getCallBack(modulecim_hrdb::PAGE_EDITCUSTOMREPORTMETADATA, $this->sortBy, $parameters);
        $this->setPageCallBack( $pageCallBack );
        
        
        $parameters = array('PERSON_ID'=>$this->PERSON_ID, 'PROVINCE_ID'=>$this->PROVINCE_ID, 'GENDER_ID'=>$this->GENDER_ID, 'STAFF_ID'=>$this->STAFF_ID, 'REGION_ID'=>$this->REGION_ID, 'EMERG_ID'=>$this->EMERG_ID, 'ASSIGNSTATUS_ID'=>$this->ASSIGNSTATUS_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'ASSIGNMENT_ID'=>$this->ASSIGNMENT_ID, 'VIEWER_ID'=>$this->VIEWER_ID, 'ACCESS_ID'=>$this->ACCESS_ID, 'YEAR_ID'=>$this->YEAR_ID, 'PERSON_YEAR_ID'=>$this->PERSON_YEAR_ID, 'STAFFSCHEDULE_ID'=>$this->STAFFSCHEDULE_ID, 'STAFFACTIVITY_ID'=>$this->STAFFACTIVITY_ID, 'ACTIVITYTYPE_ID'=>$this->ACTIVITYTYPE_ID, 'STAFFSCHEDULETYPE_ID'=>$this->STAFFSCHEDULETYPE_ID, 'ACTIVITYSCHEDULE_ID'=>$this->ACTIVITYSCHEDULE_ID, 'FIELD_ID'=>$this->FIELD_ID, 'FIELDVALUE_ID'=>$this->FIELDVALUE_ID, 'FIELDTYPE_ID'=>$this->FIELDTYPE_ID, 'DATATYPE_ID'=>$this->DATATYPE_ID, 'COUNTRY_ID'=>$this->COUNTRY_ID, 'FIELDGROUP_ID'=>$this->FIELDGROUP_ID, 'FIELDGROUP_MATCHES_ID'=>$this->FIELDGROUP_MATCHES_ID, 'STAFFDIRECTOR_ID'=>$this->STAFFDIRECTOR_ID, 'REPORT_ID'=>$this->REPORT_ID, 'CUSTOMFIELD_ID'=>$this->CUSTOMFIELD_ID);//[RAD_CALLBACK_PARAMS]
        $formAction = $this->getCallBack(modulecim_hrdb::PAGE_EDITCUSTOMREPORTMETADATA, $this->sortBy, $parameters );
        $this->pageDisplay = new FormProcessor_EditCustomReportMetaData( $this->moduleRootPath, $this->viewer, $formAction, $this->REPORT_ID );//[RAD_FORMINIT_FOREIGNKEY_INIT]        
        
    } // end loadEditCustomReportMetaData()



/*[RAD_PAGE_LOAD_FN]*/

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



}

?>