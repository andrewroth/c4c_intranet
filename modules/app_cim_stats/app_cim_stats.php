<?php
/**
 * @package cim_stats
 class modulecim_stats
 discussion <pre>
 Written By	:	Russ Martin
 Date		:   10 Jun 2006
 
 A module for managing the statistics of the campus ministry.
 
 </pre>	
*/
class modulecim_stats extends XMLObject_PageContent {
// 		
//
//	CONSTANTS:

        
    /** const MULTILINGUAL_SERIES_KEY The Multilingual Series key for this application.. */
        const MULTILINGUAL_SERIES_KEY = 'modulecim_stats';
        
    /** const MULTILINGUAL_PAGE_FIELDS The Multilingual Page key for the fields of this application. */
        const MULTILINGUAL_PAGE_FIELDS = 'fields_cim_stats';
        
    /** const MODULE_KEY The Module Key for this Module.  Used for access */
        const MODULE_KEY = 'cim_stats';
        
    /** const PAGE    The QueryString Page parameter. */
        const PAGE = "P";
        
    /** const PAGE_STAFFWEEKLYREPORT   Display the StaffWeeklyReport Page. */
        const PAGE_STAFFWEEKLYREPORT = "P7";

    /** const PAGE_STATSHOME   Display the StatsHome Page. */
        const PAGE_STATSHOME = "P8";

    /** const PAGE_SEMESTERREPORT   Display the SemesterReport Page. */
        const PAGE_SEMESTERREPORT = "P9";

    /** const PAGE_PRCMETHOD   Display the PrcMethod Page. */
        const PAGE_PRCMETHOD = "P10";

    /** const PAGE_SELECTPRCSEMESTERCAMPUS   Display the SelectPrcSemesterCampus Page. */
        const PAGE_SELECTPRCSEMESTERCAMPUS = "P11";

    /** const PAGE_PRC   Display the PRC Page. */
        const PAGE_PRC = "P12";

    /** const PAGE_EXPOSURETYPES   Display the ExposureTypes Page. */
        const PAGE_EXPOSURETYPES = "P14";

    /** const PAGE_MORESTATS   Display the MoreStats Page. */
        const PAGE_MORESTATS = "P15";

    /** const PAGE_STAFFADDITIONALWEEKLYSTATS   Display the StaffAdditionalWeeklyStats Page. */
        const PAGE_STAFFADDITIONALWEEKLYSTATS = "P16";

    /** const PAGE_PRC_REPORTBYCAMPUS   Display the PRC_ReportByCampus Page. */
        const PAGE_PRC_REPORTBYCAMPUS = "P17";

    /** const PAGE_REPORTS   Display the Reports Page. */
        const PAGE_REPORTS = "P19";

    /** const PAGE_STAFFSEMESTERREPORT   Display the StaffSemesterReport Page. */
        const PAGE_STAFFSEMESTERREPORT = "P20";

    /** const PAGE_REGIONALSEMESTERREPORT   Display the RegionalSemesterReport Page. */
        const PAGE_REGIONALSEMESTERREPORT = "P22";

    /** const PAGE_CAMPUSWEEKLYSTATSREPORT   Display the CampusWeeklyStatsReport Page. */
        const PAGE_CAMPUSWEEKLYSTATSREPORT = "P23";

    /** const PAGE_CAMPUSYEARSUMMARY   Display the CampusYearSummary Page. */
        const PAGE_CAMPUSYEARSUMMARY = "P26";

/*[RAD_PAGE_CONST]*/

    /** const SORTBY    The QueryString SortBy parameter. */
        const SORTBY = "modSort";
                

    /*! const WEEK_ID   The QueryString WEEK_ID parameter. */
        const WEEK_ID = "SV7";

    /*! const STAFF_ID   The QueryString STAFF_ID parameter. */
        const STAFF_ID = "SV8";

    /*! const SEMESTER_ID   The QueryString SEMESTER_ID parameter. */
        const SEMESTER_ID = "SV9";

    /*! const CAMPUS_ID   The QueryString CAMPUS_ID parameter. */
        const CAMPUS_ID = "SV10";

    /*! const METHOD_ID   The QueryString METHOD_ID parameter. */
        const METHOD_ID = "SV11";

    /*! const PRC_ID   The QueryString PRC_ID parameter. */
        const PRC_ID = "SV12";

    /*! const EXPOSURE_ID   The QueryString EXPOSURE_ID parameter. */
        const EXPOSURE_ID = "SV13";

    /*! const MORESTATS_ID   The QueryString MORESTATS_ID parameter. */
        const MORESTATS_ID = "SV14";

    /*! const PRIV_ID   The QueryString PRIV_ID parameter. */
        const PRIV_ID = "SV15";

    /*! const ACCESS_ID   The QueryString ACCESS_ID parameter. */
        const ACCESS_ID = "SV16";

    /*! const COORDINATOR_ID   The QueryString COORDINATOR_ID parameter. */
        const COORDINATOR_ID = "SV17";

    /*! const REGION_ID   The QueryString REGION_ID parameter. */
        const REGION_ID = "SV18";

    /*! const YEAR_ID   The QueryString YEAR_ID parameter. */
        const YEAR_ID = "SV22";

/*[RAD_PAGE_STATEVAR_CONST]*/
        
        
//
//	VARIABLES:
        
    /** protected $page   [STRING] The current Mode of this Module. */
		protected $page;
		
    /** protected $sortBy [STRING] Parameter to sort displayed Lists. */
        protected $sortBy;
		
    /*! protected $WEEK_ID   [INTEGER] the id of the week of ministry */
		protected $WEEK_ID;

    /*! protected $STAFF_ID   [INTEGER] the id of the staff member */
		protected $STAFF_ID;

    /*! protected $SEMESTER_ID   [INTEGER] the id of the semester */
		protected $SEMESTER_ID;

    /*! protected $CAMPUS_ID   [INTEGER] the id of the campus */
		protected $CAMPUS_ID;

    /*! protected $METHOD_ID   [INTEGER] the id of the prcMethod */
		protected $METHOD_ID;

    /*! protected $PRC_ID   [INTEGER] the id of a person who has prc'd */
		protected $PRC_ID;

    /*! protected $EXPOSURE_ID   [INTEGER] the id of a type of exposure */
		protected $EXPOSURE_ID;

    /*! protected $MORESTATS_ID   [INTEGER] the id of a 'more stats' item */
		protected $MORESTATS_ID;

    /*! protected $PRIV_ID   [INTEGER] the id of a access privileges item */
		protected $PRIV_ID;

    /*! protected $ACCESS_ID   [INTEGER] the id of a person who has access to the stats module */
		protected $ACCESS_ID;

    /*! protected $COORDINATOR_ID   [INTEGER] the id of a coordinator and a campus he/she has access to */
		protected $COORDINATOR_ID;

    /*! protected $REGION_ID   [INTEGER] the id of a region */
		protected $REGION_ID;

    /*! protected $YEAR_ID   [INTEGER] the id of a year */
		protected $YEAR_ID;

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
//        $this->appID = $this->getQSValue( modulecim_stats::APPID, '' );
        
        // load the common page layout object
        $this->pageCommonDisplay = new CommonDisplay( $this->moduleRootPath, $this->pathToRoot, $this->viewer);
         
        // load the module's page (DEFAULT = WELCOME)
        $this->page = $this->getQSValue( modulecim_stats::PAGE, modulecim_stats::PAGE_STATSHOME );
        
        // load the module's sortBy parameter (DEFAULT = '')
        $this->sortBy = $this->getQSValue( modulecim_stats::SORTBY, '' );
        
        // load the module's WEEK_ID variable
        $this->WEEK_ID = $this->getQSValue( modulecim_stats::WEEK_ID, "" );

        // load the module's STAFF_ID variable
        $this->STAFF_ID = $this->getQSValue( modulecim_stats::STAFF_ID, "" );

        // load the module's SEMESTER_ID variable
        $this->SEMESTER_ID = $this->getQSValue( modulecim_stats::SEMESTER_ID, "" );

        // load the module's CAMPUS_ID variable
        $this->CAMPUS_ID = $this->getQSValue( modulecim_stats::CAMPUS_ID, "" );

        // load the module's METHOD_ID variable
        $this->METHOD_ID = $this->getQSValue( modulecim_stats::METHOD_ID, "" );

        // load the module's PRC_ID variable
        $this->PRC_ID = $this->getQSValue( modulecim_stats::PRC_ID, "" );

        // load the module's EXPOSURE_ID variable
        $this->EXPOSURE_ID = $this->getQSValue( modulecim_stats::EXPOSURE_ID, "" );

        // load the module's MORESTATS_ID variable
        $this->MORESTATS_ID = $this->getQSValue( modulecim_stats::MORESTATS_ID, "" );

        // load the module's PRIV_ID variable
        $this->PRIV_ID = $this->getQSValue( modulecim_stats::PRIV_ID, "" );

        // load the module's ACCESS_ID variable
        $this->ACCESS_ID = $this->getQSValue( modulecim_stats::ACCESS_ID, "" );

        // load the module's COORDINATOR_ID variable
        $this->COORDINATOR_ID = $this->getQSValue( modulecim_stats::COORDINATOR_ID, "" );

        // load the module's REGION_ID variable
        $this->REGION_ID = $this->getQSValue( modulecim_stats::REGION_ID, "" );

        // load the module's YEAR_ID variable
        $this->YEAR_ID = $this->getQSValue( modulecim_stats::YEAR_ID, "" );

/*[RAD_PAGE_LOAD_STATEVAR]*/
        
        switch( $this->page ) {
                
            /*
             *  StaffWeeklyReport
             */
            case modulecim_stats::PAGE_STAFFWEEKLYREPORT:
                $this->loadStaffWeeklyReport();
                break;

            /*
             *  StatsHome
             */
            case modulecim_stats::PAGE_STATSHOME:
                $this->loadStatsHome();
                break;

            /*
             *  SemesterReport
             */
            case modulecim_stats::PAGE_SEMESTERREPORT:
                $this->loadSemesterReport();
                break;

            /*
             *  PrcMethod
             */
            case modulecim_stats::PAGE_PRCMETHOD:
                $this->loadPrcMethod();
                break;

            /*
             *  SelectPrcSemesterCampus
             */
            case modulecim_stats::PAGE_SELECTPRCSEMESTERCAMPUS:
                $this->loadSelectPrcSemesterCampus();
                break;

            /*
             *  PRC
             */
            case modulecim_stats::PAGE_PRC:
                $this->loadPRC();
                break;

            /*
             *  ExposureTypes
             */
            case modulecim_stats::PAGE_EXPOSURETYPES:
                $this->loadExposureTypes();
                break;

            /*
             *  MoreStats
             */
            case modulecim_stats::PAGE_MORESTATS:
                $this->loadMoreStats();
                break;

            /*
             *  StaffAdditionalWeeklyStats
             */
            case modulecim_stats::PAGE_STAFFADDITIONALWEEKLYSTATS:
                $this->loadStaffAdditionalWeeklyStats();
                break;

            /*
             *  PRC_ReportByCampus
             */
            case modulecim_stats::PAGE_PRC_REPORTBYCAMPUS:
                $this->loadPRC_ReportByCampus();
                break;

            /*
             *  Reports
             */
            case modulecim_stats::PAGE_REPORTS:
                $this->loadReports();
                break;

            /*
             *  StaffSemesterReport
             */
            case modulecim_stats::PAGE_STAFFSEMESTERREPORT:
                $this->loadStaffSemesterReport();
                break;

            /*
             *  RegionalSemesterReport
             */
            case modulecim_stats::PAGE_REGIONALSEMESTERREPORT:
                $this->loadRegionalSemesterReport();
                break;

            /*
             *  CampusWeeklyStatsReport
             */
            case modulecim_stats::PAGE_CAMPUSWEEKLYSTATSREPORT:
                $this->loadCampusWeeklyStatsReport();
                break;

            /*
             *  CampusYearSummary
             */
            case modulecim_stats::PAGE_CAMPUSYEARSUMMARY:
                $this->loadCampusYearSummary();
                break;

/*[RAD_PAGE_LOAD_CALL]*/
   
                 
            /*
             *  Just to make sure, default the pageDisplay to 
             *  the StatsHome page.
             */
            default:
                $this->page = modulecim_stats::PAGE_STATSHOME;
                $this->loadStatsHome();
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
	
	// Returns the value of a given variable name within the query string
	// $nameToLookup - the variable name to lookup
	// $qs - the query string
	function getQSValueLocal( $nameToLookup , $qs )
	{
	   $retValue = '';
        // find the ?
        $variablesPart = substr ( $qs, strpos( $qs, '?' ) + 1 );
        $pairArray = explode('&', $variablesPart);
        foreach( $pairArray as $key=>$value )
        {
            // value is of the form SV10=5
            $pieces = explode( '=', $value );
            $varName = $pieces[0];
            $varValue = $pieces[1];
            if ( $varName == $nameToLookup )
            {
                $retValue = $varValue;
                break;
            }
        }
        return $retValue;
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
    
                    case modulecim_stats::PAGE_STAFFWEEKLYREPORT:
                        $this->WEEK_ID = '';
                        $this->page = modulecim_stats::PAGE_PRC;
                        
                        // echo '<pre>'.print_r($_REQUEST, true).'</pre>';
                        // need the semester id and campus id for the PRC page
                        
                        if ( isset( $_REQUEST[ modulecim_stats::CAMPUS_ID ] ) )
                        {
                            $this->CAMPUS_ID = $_REQUEST[ modulecim_stats::CAMPUS_ID ];
                        }
                        else
                        {
                            // figure out the campus id from a query string form value
                            
                            $this->CAMPUS_ID = $this->getQSValueLocal( modulecim_stats::CAMPUS_ID, $_REQUEST['campus_id'] );
                        }
                        // echo '$this->CAMPUS_ID['.$this->CAMPUS_ID.']<br/>';
                        
                        // get the week_id                        
                        $weekID = $this->getQSValueLocal( modulecim_stats::WEEK_ID , $_REQUEST['week_id'] );
                        // create a week manager
                        $weekManager = new RowManager_WeekManager( $weekID );
                        $weekDate = $weekManager->getEndDate();
                        // echo '$weekDate['.$weekDate.']<br/>';
                        $semesterManager = new RowManager_SemesterManager();
                        if ( $semesterManager->loadByDate( $weekDate ) )
                        {
                            $this->SEMESTER_ID = $semesterManager->getID();
                        }
                        else if ( $semesterManager->checkIfFirstSemester( $weekDate ) ) 
                        {
                            $this->SEMESTER_ID = $semesterManager->getID();
                        }
                        else
                        {
                            die( 'ERROR - could not find semester - processData - staffWeeklyReport transition' );
                        } 
                        $this->SEMESTER_ID = $semesterManager->getID();
                        
                        // echo '$this->SEMESTER_ID['.$this->SEMESTER_ID.']<br/>';
                        
                        $this->loadPRC();                       
                        break;

                    case modulecim_stats::PAGE_SEMESTERREPORT:
                        $this->SEMESTER_ID = '';
                        $this->page = modulecim_stats::PAGE_STATSHOME;
                        $this->loadStatsHome();                       
                        break;

                    case modulecim_stats::PAGE_PRCMETHOD:
                        // NOTE: after a successful submit on an AdminBox style
                        // form, set the managerInit variable back to ''
                        $this->METHOD_ID = '';
                        $this->loadPrcMethod( true );                     
                        break;

                    case modulecim_stats::PAGE_PRC:
                        // NOTE: after a successful submit on an AdminBox style
                        // form, set the managerInit variable back to ''
                        $this->PRC_ID = '';
                        $this->loadPRC( true );                     
                        break;
                        
                    case modulecim_stats::PAGE_SELECTPRCSEMESTERCAMPUS:
                        // echo print_r($_REQUEST, true);
                        
                        // HACK: not really sure how else to get these values
                        $this->SEMESTER_ID = $_REQUEST['semester_id'];
                        $this->CAMPUS_ID = $_REQUEST['campus_id'];
                        
                        $this->loadPRC();
                        break;

                    case modulecim_stats::PAGE_EXPOSURETYPES:
                        // NOTE: after a successful submit on an AdminBox style
                        // form, set the managerInit variable back to ''
                        $this->EXPOSURE_ID = '';
                        $this->loadExposureTypes( true );                     
                        break;

                    case modulecim_stats::PAGE_MORESTATS:
                        // NOTE: after a successful submit on an AdminBox style
                        // form, set the managerInit variable back to ''
                        $this->MORESTATS_ID = '';
                        $this->loadMoreStats( true );                     
                        break;

                    case modulecim_stats::PAGE_STAFFADDITIONALWEEKLYSTATS:
                        $this->WEEK_ID = '';
                        $this->page = modulecim_stats::PAGE_STATSHOME;
                        $this->loadStatsHome();                       
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
                
        
        // wrap current page's html in the common html of the module
        $content = $this->pageCommonDisplay->getHTML( $content );

        // store HTML content as this page's content Item
        $this->addContent( $content );
        
         
        // Add any necessary javascripts for this page:
        switch( $this->page ) {
        
/*[RAD_PAGE_JAVASCRIPTS]*/
//             case modulecim_stats::PAGE_DEFAULT:
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
	 * 'WEEK_ID' [INTEGER] The Desired WEEK_ID of this Link.
	 * 'STAFF_ID' [INTEGER] The Desired STAFF_ID of this Link.
	 * 'SEMESTER_ID' [INTEGER] The Desired SEMESTER_ID of this Link.
	 * 'CAMPUS_ID' [INTEGER] The Desired CAMPUS_ID of this Link.
	 * 'METHOD_ID' [INTEGER] The Desired METHOD_ID of this Link.
	 * 'PRC_ID' [INTEGER] The Desired PRC_ID of this Link.
	 * 'EXPOSURE_ID' [INTEGER] The Desired EXPOSURE_ID of this Link.
	 * 'MORESTATS_ID' [INTEGER] The Desired MORESTATS_ID of this Link.
	 * 'PRIV_ID' [INTEGER] The Desired PRIV_ID of this Link.
	 * 'ACCESS_ID' [INTEGER] The Desired ACCESS_ID of this Link.
	 * 'COORDINATOR_ID' [INTEGER] The Desired COORDINATOR_ID of this Link.
	 * 'REGION_ID' [INTEGER] The Desired REGION_ID of this Link.
	 * 'YEAR_ID' [INTEGER] The Desired YEAR_ID of this Link.
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
            $callBack = modulecim_stats::PAGE.'='.$page;
        }
        
        if ($sortBy != '') {
            if ($callBack != '') {
                $callBack .= '&';
            }
            $callBack .= modulecim_stats::SORTBY.'='.$sortBy;
        }
        
        
        if ( isset( $parameters['WEEK_ID']) ) {
            if ( $parameters['WEEK_ID'] != '' ) {
                if ($callBack != '') {
                    $callBack .= '&';
                }
                $callBack .= modulecim_stats::WEEK_ID.'='.$parameters['WEEK_ID'];
            }
        }

        if ( isset( $parameters['STAFF_ID']) ) {
            if ( $parameters['STAFF_ID'] != '' ) {
                if ($callBack != '') {
                    $callBack .= '&';
                }
                $callBack .= modulecim_stats::STAFF_ID.'='.$parameters['STAFF_ID'];
            }
        }

        if ( isset( $parameters['SEMESTER_ID']) ) {
            if ( $parameters['SEMESTER_ID'] != '' ) {
                if ($callBack != '') {
                    $callBack .= '&';
                }
                $callBack .= modulecim_stats::SEMESTER_ID.'='.$parameters['SEMESTER_ID'];
            }
        }

        if ( isset( $parameters['CAMPUS_ID']) ) {
            if ( $parameters['CAMPUS_ID'] != '' ) {
                if ($callBack != '') {
                    $callBack .= '&';
                }
                $callBack .= modulecim_stats::CAMPUS_ID.'='.$parameters['CAMPUS_ID'];
            }
        }

        if ( isset( $parameters['METHOD_ID']) ) {
            if ( $parameters['METHOD_ID'] != '' ) {
                if ($callBack != '') {
                    $callBack .= '&';
                }
                $callBack .= modulecim_stats::METHOD_ID.'='.$parameters['METHOD_ID'];
            }
        }

        if ( isset( $parameters['PRC_ID']) ) {
            if ( $parameters['PRC_ID'] != '' ) {
                if ($callBack != '') {
                    $callBack .= '&';
                }
                $callBack .= modulecim_stats::PRC_ID.'='.$parameters['PRC_ID'];
            }
        }

        if ( isset( $parameters['EXPOSURE_ID']) ) {
            if ( $parameters['EXPOSURE_ID'] != '' ) {
                if ($callBack != '') {
                    $callBack .= '&';
                }
                $callBack .= modulecim_stats::EXPOSURE_ID.'='.$parameters['EXPOSURE_ID'];
            }
        }

        if ( isset( $parameters['MORESTATS_ID']) ) {
            if ( $parameters['MORESTATS_ID'] != '' ) {
                if ($callBack != '') {
                    $callBack .= '&';
                }
                $callBack .= modulecim_stats::MORESTATS_ID.'='.$parameters['MORESTATS_ID'];
            }
        }

        if ( isset( $parameters['PRIV_ID']) ) {
            if ( $parameters['PRIV_ID'] != '' ) {
                if ($callBack != '') {
                    $callBack .= '&';
                }
                $callBack .= modulecim_stats::PRIV_ID.'='.$parameters['PRIV_ID'];
            }
        }

        if ( isset( $parameters['ACCESS_ID']) ) {
            if ( $parameters['ACCESS_ID'] != '' ) {
                if ($callBack != '') {
                    $callBack .= '&';
                }
                $callBack .= modulecim_stats::ACCESS_ID.'='.$parameters['ACCESS_ID'];
            }
        }

        if ( isset( $parameters['COORDINATOR_ID']) ) {
            if ( $parameters['COORDINATOR_ID'] != '' ) {
                if ($callBack != '') {
                    $callBack .= '&';
                }
                $callBack .= modulecim_stats::COORDINATOR_ID.'='.$parameters['COORDINATOR_ID'];
            }
        }

        if ( isset( $parameters['REGION_ID']) ) {
            if ( $parameters['REGION_ID'] != '' ) {
                if ($callBack != '') {
                    $callBack .= '&';
                }
                $callBack .= modulecim_stats::REGION_ID.'='.$parameters['REGION_ID'];
            }
        }

        if ( isset( $parameters['YEAR_ID']) ) {
            if ( $parameters['YEAR_ID'] != '' ) {
                if ($callBack != '') {
                    $callBack .= '&';
                }
                $callBack .= modulecim_stats::YEAR_ID.'='.$parameters['YEAR_ID'];
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
        return modulecim_stats::MULTILINGUAL_SERIES_KEY;
    }

    
    
    //************************************************************************
	/**
	 * function loadStaffWeeklyReport
	 * <pre>
	 * Initializes the StaffWeeklyReport Page.
	 * </pre>
	 * @return [void]
	 */
    // RAD Tools: FormSingleEntry style
    function loadStaffWeeklyReport() 
    {
        // set the pageCallBack to be without any additional parameters
        // (an AdminBox needs this so Language Switching on a page doesn't
        // pass a previous operations)
        $parameters = array('WEEK_ID'=>$this->WEEK_ID, 'STAFF_ID'=>$this->STAFF_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID);//[RAD_CALLBACK_PARAMS]
        $pageCallBack = $this->getCallBack(modulecim_stats::PAGE_STAFFWEEKLYREPORT, $this->sortBy, $parameters);
        $this->setPageCallBack( $pageCallBack );
        
        $formAction = $this->getCallBack(modulecim_stats::PAGE_STAFFWEEKLYREPORT, $this->sortBy, $parameters );
        $this->pageDisplay = new FormProcessor_StaffWeeklyReport( $this->moduleRootPath, $this->viewer, $formAction, $this->STAFF_ID, $this->WEEK_ID, $this->CAMPUS_ID );//[RAD_FORMINIT_FOREIGNKEY_INIT]     
        
        // note: we omit the week_id for this set of parameters
        $parameters = array('STAFF_ID'=>$this->STAFF_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID );
        $jumpLink = $this->getCallBack( modulecim_stats::PAGE_STAFFWEEKLYREPORT, $this->sortBy, $parameters);
        $jumpLink .= "&". modulecim_stats::WEEK_ID . "=";
        $links["weekJumpLink"] = $jumpLink;
        
        // note: we omit the campus_id for this set of parameters
        $parameters = array('WEEK_ID'=>$this->WEEK_ID, 'STAFF_ID'=>$this->STAFF_ID);
        $campusJumpLink = $this->getCallBack( modulecim_stats::PAGE_STAFFWEEKLYREPORT, $this->sortBy, $parameters);
        $campusJumpLink .= "&". modulecim_stats::CAMPUS_ID . "=";
        $links["campusJumpLink"] = $campusJumpLink;

        $this->pageDisplay->setLinks( $links );
        
        $this->addScript('MM_jumpMenu.jsp');   
        
    } // end loadStaffWeeklyReport()



    //************************************************************************
	/**
	 * function loadStatsHome
	 * <pre>
	 * Initializes the StatsHome Page.
	 * </pre>
	 * @return [void]
	 */
    // RAD Tools: Custom style
    function loadStatsHome() 
    {
            
        // set the pageCallBack to be without any additional parameters
        // (an AdminBox needs this so Language Switching on a page doesn't
        // pass a previous operations)
        $parameters = array('WEEK_ID'=>$this->WEEK_ID);//[RAD_CALLBACK_PARAMS]
        $pageCallBack = $this->getCallBack(modulecim_stats::PAGE_STATSHOME, $this->sortBy, $parameters);
        $this->setPageCallBack( $pageCallBack );
        
        
        $this->pageDisplay = new page_StatsHome( $this->moduleRootPath, $this->viewer );     

        $parameters = array();
        $viewerID = $this->viewer->getViewerID();
        // TODO make an object to do this work
        $sql = "select * from ( ( cim_hrdb_access inner join cim_hrdb_person on cim_hrdb_access.person_id=cim_hrdb_person.person_id) inner join cim_hrdb_staff on cim_hrdb_staff.person_id=cim_hrdb_person.person_id ) where cim_hrdb_access.viewer_id = ".$viewerID." limit 1";

        $db = new Database_Site();
        $db->connectToDB( SITE_DB_NAME, SITE_DB_PATH, SITE_DB_USER, SITE_DB_PWORD );

        $db->runSQL($sql);
        // if row retrieved ...
        $staffID = -1;
        if ($row = $db->retrieveRow() )
        {
            $staffID = $row['staff_id'];
        }
        $parameters['STAFF_ID'] = $staffID;

        // echo print_r($parameters,true);
        
        $permManager = new PermissionManager( $viewerID );
  
        $isNational = $permManager->isNational();
        
        // echo 'isNational['.$isNational.']<br/>';
        $isRegional = $permManager->isRegional();
        // echo 'isRegional['.$isRegional.']<br/>';
        $isCD = $permManager->isCD();
        // echo 'isCD['.$isCD.']<br/>';
        $isStatsCoordinator = $permManager->isStatsCoordinator();
        // echo 'isStatsCoordinator['.$isStatsCoordinator.']<br/>';
        $isAllStaff = $permManager->isAllStaff();
        // echo 'isAllStaff['.$isAllStaff.']<br/>';

        $links = array();
        if ( $isAllStaff )
        {
            // GROUP 1: ALL STAFF
            // All staff can access this link
            $requestLink = $this->getCallBack( modulecim_stats::PAGE_STAFFWEEKLYREPORT, '' , $parameters);
            $links[ '[submitWeeklyStats]' ] = $requestLink;
            
	    // removed by RM on June 4, 2009 as we are no longer collecting these measurements
	    // $requestLink = $this->getCallBack( modulecim_stats::PAGE_STAFFADDITIONALWEEKLYSTATS, '' , $parameters);
            // $links[ '[submitMoreWeeklyStats]' ] = $requestLink;

            $requestLink = $this->getCallBack( modulecim_stats::PAGE_SELECTPRCSEMESTERCAMPUS, '' , $parameters);
            $links[ '[indicatedDecisions]' ] = $requestLink;
            $requestLink = $this->getCallBack( modulecim_stats::PAGE_STAFFSEMESTERREPORT, '' , $parameters);
            $links[ '[semesterGlance]' ] = $requestLink;
            $requestLink = $this->getCallBack( modulecim_stats::PAGE_CAMPUSYEARSUMMARY, '' , $parameters);
            $links[ '[yearSummary]' ] = $requestLink;
            
            
        }
        
        $coordinatorLinks = array();
        if ( $isStatsCoordinator || $isAllStaff )
        {
            // GROUP 2: CAMPUS STATS COORDINATORS

	    // removed by RM on June 4, 2009 as we are no longer collecting these measurements
            // $requestLink = $this->getCallBack( modulecim_stats::PAGE_MORESTATS, '' , $parameters);
            // $coordinatorLinks[ '[campusWeeklyStats]' ] = $requestLink;
            
	    // removed by RM on June 4, 2009 as we are no longer collecting these measurements
            // $requestLink = $this->getCallBack( modulecim_stats::PAGE_CAMPUSWEEKLYSTATSREPORT, '' , $parameters);
            // $coordinatorLinks[ '[campusWeeklyStatsReport]' ] = $requestLink;
            
	    // removed by RM on June 4, 2009 as we are no longer collecting these measurements
            // $requestLink = $this->getCallBack( modulecim_stats::PAGE_SEMESTERREPORT, '' , $parameters);
            // $coordinatorLinks[ '[submitSemesterStats]' ] = $requestLink;
        }
        
        $cdLinks = array();
        if ( $isCD )
        {
            // GROUP 3: CAMPUS DIRECTORS
            $requestLink = $this->getCallBack( modulecim_stats::PAGE_STAFFSEMESTERREPORT, '' , $parameters);
            $cdLinks[ '[semesterGlance]' ] = $requestLink;
        }
        
        $rtLinks = array();
        if ( $isRegional )                
        {
            // GROUP 4: REGIONAL TEAM
            $requestLink = $this->getCallBack( modulecim_stats::PAGE_REGIONALSEMESTERREPORT, '' , $parameters);
            $rtLinks[ '[regionalPersonalMin]' ] = $requestLink;
        }        
        
        $ntLinks = array();
        if ( $isNational )
        {
            // GROUP 5: NATIONAL TEAM
            // echo 'Is NATIONAL<br/>';
            
            // Add these two links later in special admin section
            $requestLink = $this->getCallBack( modulecim_stats::PAGE_PRCMETHOD, '' , $parameters);
            // $ntLinks[ '[prcMethod]' ] = $requestLink;
            $requestLink = $this->getCallBack( modulecim_stats::PAGE_EXPOSURETYPES, '' , $parameters);
            // $ntLinks[ '[exposureTypes]' ] = $requestLink;
            
            $requestLink = $this->getCallBack( modulecim_stats::PAGE_PRC_REPORTBYCAMPUS, '' , $parameters);
            $ntLinks[ '[prcReportByCampus]' ] = $requestLink;
            
        }

        
/*[RAD_LINK_INSERT]*/

        $this->pageDisplay->setMyLinks( $links, $coordinatorLinks, $cdLinks, $rtLinks, $ntLinks ); 
        $this->pageDisplay->setPerms( $isNational, $isRegional, $isCD, $isStatsCoordinator, $isAllStaff );    
        
    } // end loadStatsHome()



    //************************************************************************
	/**
	 * function loadSemesterReport
	 * <pre>
	 * Initializes the SemesterReport Page.
	 * </pre>
	 * @return [void]
	 */
    // RAD Tools: FormSingleEntry style
    function loadSemesterReport() 
    {
        // set the pageCallBack to be without any additional parameters
        // (an AdminBox needs this so Language Switching on a page doesn't
        // pass a previous operations)
        $parameters = array('WEEK_ID'=>$this->WEEK_ID, 'STAFF_ID'=>$this->STAFF_ID, 'SEMESTER_ID'=>$this->SEMESTER_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID);//[RAD_CALLBACK_PARAMS]
        $pageCallBack = $this->getCallBack(modulecim_stats::PAGE_SEMESTERREPORT, $this->sortBy, $parameters);
        $this->setPageCallBack( $pageCallBack );
        
        
        $parameters = array('WEEK_ID'=>$this->WEEK_ID, 'STAFF_ID'=>$this->STAFF_ID, 'SEMESTER_ID'=>$this->SEMESTER_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID);//[RAD_CALLBACK_PARAMS]
        $formAction = $this->getCallBack(modulecim_stats::PAGE_SEMESTERREPORT, $this->sortBy, $parameters );
        $this->pageDisplay = new FormProcessor_SemesterReport( $this->moduleRootPath, $this->viewer, $formAction, '', $this->SEMESTER_ID , $this->CAMPUS_ID, $this->STAFF_ID);//[RAD_FORMINIT_FOREIGNKEY_INIT]   
        
        // note: semester parameter is not included
        $semesterParameters = array('WEEK_ID'=>$this->WEEK_ID, 'STAFF_ID'=>$this->STAFF_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID);
        $semesterJumpLink = $this->getCallBack( modulecim_stats::PAGE_SEMESTERREPORT, $this->sortBy, $semesterParameters);
        $semesterJumpLink .= "&". modulecim_stats::SEMESTER_ID . "=";
        $links["semesterJumpLink"] = $semesterJumpLink;
        
        // note: campus paramater is not included
        $campusParameters = array('WEEK_ID'=>$this->WEEK_ID, 'STAFF_ID'=>$this->STAFF_ID, 'SEMESTER_ID'=>$this->SEMESTER_ID );
        $campusJumpLink = $this->getCallBack( modulecim_stats::PAGE_SEMESTERREPORT, $this->sortBy, $campusParameters);
        $campusJumpLink .= "&". modulecim_stats::CAMPUS_ID . "=";
        $links["campusJumpLink"] = $campusJumpLink;

        $this->pageDisplay->setLinks( $links );
        
        $this->addScript('MM_jumpMenu.jsp');     
        
    } // end loadSemesterReport()



    //************************************************************************
	/**
	 * function loadPrcMethod
	 * <pre>
	 * Initializes the PrcMethod Page.
	 * </pre>
	 * @param $isCreated [BOOL] "Is THIS pageDisplay object already created?"
	 * @return [void]
	 */
    // RAD Tools: AdminBox Style
    function loadPrcMethod( $isCreated=false ) 
    {
        
        // compile a formAction for the adminBox
        $parameters = array('WEEK_ID'=>$this->WEEK_ID, 'STAFF_ID'=>$this->STAFF_ID, 'SEMESTER_ID'=>$this->SEMESTER_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'METHOD_ID'=>$this->METHOD_ID);//[RAD_CALLBACK_PARAMS]
        $formAction = $this->getCallBack(modulecim_stats::PAGE_PRCMETHOD, $this->sortBy, $parameters );
        
        // set the pageCallBack value.  This is used by the Language switching
        // code
        $this->setPageCallBack( $formAction );
        
        // if this pageDisplay object isn't already created then 
        if ( !$isCreated ) {
        
            // create a new pageDisplay object
            $this->pageDisplay = new FormProcessor_PrcMethod( $this->moduleRootPath, $this->viewer, $formAction, $this->sortBy,  $this->METHOD_ID, $this->METHOD_ID );//[RAD_FORMINIT_FOREIGNKEY_INIT]    
        
        } else {
        
            // otherwise just update the formAction value
            $this->pageDisplay->setFormAction( $formAction );
        }
        
        $links = array();
        
        $parameters = array( 'WEEK_ID'=>$this->WEEK_ID, 'STAFF_ID'=>$this->STAFF_ID, 'SEMESTER_ID'=>$this->SEMESTER_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'METHOD_ID'=>$this->METHOD_ID);//[RAD_CALLBACK_PARAMS]
        $continueLink = $this->getCallBack( modulecim_stats::PAGE_STATSHOME, "", $parameters );
        $links["cont"] = $continueLink;

        $parameters = array( );//[RAD_CALLBACK_PARAMS_EDIT]
        $editLink = $this->getCallBack( modulecim_stats::PAGE_PRCMETHOD, $this->sortBy, $parameters );
        $editLink .= "&". modulecim_stats::METHOD_ID . "=";
        $links[ "edit" ] = $editLink;
        
        // NOTE: delete link is same as edit link for an AdminBox
        $links[ "del" ] = $editLink;

/*[RAD_LINK_INSERT]*/

        $parameters = array('WEEK_ID'=>$this->WEEK_ID, 'STAFF_ID'=>$this->STAFF_ID, 'SEMESTER_ID'=>$this->SEMESTER_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'METHOD_ID'=>$this->METHOD_ID);//[RAD_CALLBACK_PARAMS]
        $sortByLink = $this->getCallBack( modulecim_stats::PAGE_PRCMETHOD, '', $parameters );
        $sortByLink .= "&".modulecim_stats::SORTBY."=";
        $links["sortBy"] = $sortByLink;

        $this->pageDisplay->setLinks( $links );    
        
    } // end loadPrcMethod()



    //************************************************************************
	/**
	 * function loadSelectPrcSemesterCampus
	 * <pre>
	 * Initializes the SelectPrcSemesterCampus Page.
	 * </pre>
	 * @return [void]
	 */
    // RAD Tools: FormSingleEntry style
    function loadSelectPrcSemesterCampus() 
    {
        // set the pageCallBack to be without any additional parameters
        // (an AdminBox needs this so Language Switching on a page doesn't
        // pass a previous operations)
        $parameters = array('WEEK_ID'=>$this->WEEK_ID, 'STAFF_ID'=>$this->STAFF_ID, 'SEMESTER_ID'=>$this->SEMESTER_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'METHOD_ID'=>$this->METHOD_ID, 'PRC_ID'=>$this->PRC_ID);//[RAD_CALLBACK_PARAMS]
        $pageCallBack = $this->getCallBack(modulecim_stats::PAGE_SELECTPRCSEMESTERCAMPUS, $this->sortBy, $parameters);
        $this->setPageCallBack( $pageCallBack );
        
        
        $parameters = array('WEEK_ID'=>$this->WEEK_ID, 'STAFF_ID'=>$this->STAFF_ID, 'SEMESTER_ID'=>$this->SEMESTER_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'METHOD_ID'=>$this->METHOD_ID, 'PRC_ID'=>$this->PRC_ID);//[RAD_CALLBACK_PARAMS]
        $formAction = $this->getCallBack(modulecim_stats::PAGE_SELECTPRCSEMESTERCAMPUS, $this->sortBy, $parameters );
        $this->pageDisplay = new FormProcessor_SelectPrcSemesterCampus( $this->moduleRootPath, $this->viewer, $formAction, $this->PRC_ID , $this->METHOD_ID, $this->SEMESTER_ID, $this->CAMPUS_ID, $this->STAFF_ID );//[RAD_FORMINIT_FOREIGNKEY_INIT]        
        
    } // end loadSelectPrcSemesterCampus()



    //************************************************************************
	/**
	 * function loadPRC
	 * <pre>
	 * Initializes the PRC Page.
	 * </pre>
	 * @param $isCreated [BOOL] "Is THIS pageDisplay object already created?"
	 * @return [void]
	 */
    // RAD Tools: AdminBox Style
    function loadPRC( $isCreated=false ) 
    {
        // echo 'load PRC<br/>';
        // echo 'semesterID['.$this->SEMESTER_ID.']<br/>';
        // echo 'campusID['.$this->CAMPUS_ID.']<br/>';
        
        // compile a formAction for the adminBox
        $parameters = array('WEEK_ID'=>$this->WEEK_ID, 'STAFF_ID'=>$this->STAFF_ID, 'SEMESTER_ID'=>$this->SEMESTER_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'METHOD_ID'=>$this->METHOD_ID, 'PRC_ID'=>$this->PRC_ID);//[RAD_CALLBACK_PARAMS]
        $formAction = $this->getCallBack(modulecim_stats::PAGE_PRC, $this->sortBy, $parameters );
        
        // set the pageCallBack value.  This is used by the Language switching
        // code
        $this->setPageCallBack( $formAction );
        
        // if this pageDisplay object isn't already created then 
        if ( !$isCreated ) {
        
            // create a new pageDisplay object
            $this->pageDisplay = new FormProcessor_PRC( $this->moduleRootPath, $this->viewer, $formAction, $this->sortBy,  $this->PRC_ID, $this->METHOD_ID , $this->SEMESTER_ID, $this->CAMPUS_ID);//[RAD_FORMINIT_FOREIGNKEY_INIT]    
        
        } else {
        
            // otherwise just update the formAction value
            $this->pageDisplay->setFormAction( $formAction );
        }
        
        $links = array();
        
        $parameters = array( 'WEEK_ID'=>$this->WEEK_ID, 'STAFF_ID'=>$this->STAFF_ID, 'SEMESTER_ID'=>$this->SEMESTER_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'METHOD_ID'=>$this->METHOD_ID, 'PRC_ID'=>$this->PRC_ID);//[RAD_CALLBACK_PARAMS]
        $continueLink = $this->getCallBack( modulecim_stats::PAGE_STATSHOME, "", $parameters );
        $links["cont"] = $continueLink;

        // $parameters = array( );//[RAD_CALLBACK_PARAMS_EDIT]
        $editLink = $this->getCallBack( modulecim_stats::PAGE_PRC, $this->sortBy, $parameters );
        $editLink .= "&". modulecim_stats::PRC_ID . "=";
        $links[ "edit" ] = $editLink;
        
        // NOTE: delete link is same as edit link for an AdminBox
        $links[ "del" ] = $editLink;

/*[RAD_LINK_INSERT]*/

        $parameters = array('WEEK_ID'=>$this->WEEK_ID, 'STAFF_ID'=>$this->STAFF_ID, 'SEMESTER_ID'=>$this->SEMESTER_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'METHOD_ID'=>$this->METHOD_ID, 'PRC_ID'=>$this->PRC_ID);//[RAD_CALLBACK_PARAMS]
        $sortByLink = $this->getCallBack( modulecim_stats::PAGE_PRC, '', $parameters );
        $sortByLink .= "&".modulecim_stats::SORTBY."=";
        $links["sortBy"] = $sortByLink;

        $this->pageDisplay->setLinks( $links );    
        
    } // end loadPRC()



    //************************************************************************
	/**
	 * function loadExposureTypes
	 * <pre>
	 * Initializes the ExposureTypes Page.
	 * </pre>
	 * @param $isCreated [BOOL] "Is THIS pageDisplay object already created?"
	 * @return [void]
	 */
    // RAD Tools: AdminBox Style
    function loadExposureTypes( $isCreated=false ) 
    {
        
        // compile a formAction for the adminBox
        $parameters = array('WEEK_ID'=>$this->WEEK_ID, 'STAFF_ID'=>$this->STAFF_ID, 'SEMESTER_ID'=>$this->SEMESTER_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'METHOD_ID'=>$this->METHOD_ID, 'PRC_ID'=>$this->PRC_ID, 'EXPOSURE_ID'=>$this->EXPOSURE_ID);//[RAD_CALLBACK_PARAMS]
        $formAction = $this->getCallBack(modulecim_stats::PAGE_EXPOSURETYPES, $this->sortBy, $parameters );
        
        // set the pageCallBack value.  This is used by the Language switching
        // code
        $this->setPageCallBack( $formAction );
        
        // if this pageDisplay object isn't already created then 
        if ( !$isCreated ) {
        
            // create a new pageDisplay object
            $this->pageDisplay = new FormProcessor_ExposureTypes( $this->moduleRootPath, $this->viewer, $formAction, $this->sortBy,  $this->EXPOSURE_ID, $this->EXPOSURE_ID );//[RAD_FORMINIT_FOREIGNKEY_INIT]    
        
        } else {
        
            // otherwise just update the formAction value
            $this->pageDisplay->setFormAction( $formAction );
        }
        
        $links = array();
        
        $parameters = array( 'WEEK_ID'=>$this->WEEK_ID, 'STAFF_ID'=>$this->STAFF_ID, 'SEMESTER_ID'=>$this->SEMESTER_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'METHOD_ID'=>$this->METHOD_ID, 'PRC_ID'=>$this->PRC_ID, 'EXPOSURE_ID'=>$this->EXPOSURE_ID);//[RAD_CALLBACK_PARAMS]
        $continueLink = $this->getCallBack( modulecim_stats::PAGE_STATSHOME, "", $parameters );
        $links["cont"] = $continueLink;

        $parameters = array( );//[RAD_CALLBACK_PARAMS_EDIT]
        $editLink = $this->getCallBack( modulecim_stats::PAGE_EXPOSURETYPES, $this->sortBy, $parameters );
        $editLink .= "&". modulecim_stats::EXPOSURE_ID . "=";
        $links[ "edit" ] = $editLink;
        
        // NOTE: delete link is same as edit link for an AdminBox
        $links[ "del" ] = $editLink;

/*[RAD_LINK_INSERT]*/

        $parameters = array('WEEK_ID'=>$this->WEEK_ID, 'STAFF_ID'=>$this->STAFF_ID, 'SEMESTER_ID'=>$this->SEMESTER_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'METHOD_ID'=>$this->METHOD_ID, 'PRC_ID'=>$this->PRC_ID, 'EXPOSURE_ID'=>$this->EXPOSURE_ID);//[RAD_CALLBACK_PARAMS]
        $sortByLink = $this->getCallBack( modulecim_stats::PAGE_EXPOSURETYPES, '', $parameters );
        $sortByLink .= "&".modulecim_stats::SORTBY."=";
        $links["sortBy"] = $sortByLink;

        $this->pageDisplay->setLinks( $links );    
        
    } // end loadExposureTypes()



    //************************************************************************
	/**
	 * function loadMoreStats
	 * <pre>
	 * Initializes the MoreStats Page.
	 * </pre>
	 * @param $isCreated [BOOL] "Is THIS pageDisplay object already created?"
	 * @return [void]
	 */
    // RAD Tools: AdminBox Style
    function loadMoreStats( $isCreated=false ) 
    {
        // echo print_r($_REQUEST,true).'<br/>';
        // echo '$this->EXPOSURE_ID['.$this->EXPOSURE_ID.']<br/>';
        
        // compile a formAction for the adminBox
        $parameters = array('WEEK_ID'=>$this->WEEK_ID, 'STAFF_ID'=>$this->STAFF_ID, 'SEMESTER_ID'=>$this->SEMESTER_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'METHOD_ID'=>$this->METHOD_ID, 'PRC_ID'=>$this->PRC_ID, 'EXPOSURE_ID'=>$this->EXPOSURE_ID, 'MORESTATS_ID'=>$this->MORESTATS_ID);//[RAD_CALLBACK_PARAMS]
        $formAction = $this->getCallBack(modulecim_stats::PAGE_MORESTATS, $this->sortBy, $parameters );
        
        // set the pageCallBack value.  This is used by the Language switching
        // code
        $this->setPageCallBack( $formAction );
        
        // if this pageDisplay object isn't already created then 
        if ( !$isCreated ) {
        
            // create a new pageDisplay object
            $this->pageDisplay = new FormProcessor_MoreStats( $this->moduleRootPath, $this->viewer, $formAction, $this->sortBy,  $this->MORESTATS_ID, $this->CAMPUS_ID , $this->EXPOSURE_ID, $this->WEEK_ID, $this->STAFF_ID);//[RAD_FORMINIT_FOREIGNKEY_INIT]    
        
        } else {
        
            // otherwise just update the formAction value
            $this->pageDisplay->setFormAction( $formAction );
        }
        
        $links = array();
        
        $parameters = array( 'WEEK_ID'=>$this->WEEK_ID, 'STAFF_ID'=>$this->STAFF_ID, 'SEMESTER_ID'=>$this->SEMESTER_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'METHOD_ID'=>$this->METHOD_ID, 'PRC_ID'=>$this->PRC_ID, 'EXPOSURE_ID'=>$this->EXPOSURE_ID, 'MORESTATS_ID'=>$this->MORESTATS_ID);//[RAD_CALLBACK_PARAMS]
        $continueLink = $this->getCallBack( modulecim_stats::PAGE_STATSHOME, "", $parameters );
        $links["cont"] = $continueLink;

        // $parameters = array( );//[RAD_CALLBACK_PARAMS_EDIT]
        $editLink = $this->getCallBack( modulecim_stats::PAGE_MORESTATS, $this->sortBy, $parameters );
        $editLink .= "&". modulecim_stats::MORESTATS_ID . "=";
        $links[ "edit" ] = $editLink;
        
        // NOTE: delete link is same as edit link for an AdminBox
        $links[ "del" ] = $editLink;

/*[RAD_LINK_INSERT]*/

        // note: we omit the week_id for this set of parameters
        $parameters = array('STAFF_ID'=>$this->STAFF_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID );
        $jumpLink = $this->getCallBack( modulecim_stats::PAGE_MORESTATS, $this->sortBy, $parameters);
        $jumpLink .= "&". modulecim_stats::WEEK_ID . "=";
        $links["weekJumpLink"] = $jumpLink;
        
        // note: we omit the campus_id for this set of parameters
        $parameters = array('WEEK_ID'=>$this->WEEK_ID, 'STAFF_ID'=>$this->STAFF_ID);
        $campusJumpLink = $this->getCallBack( modulecim_stats::PAGE_MORESTATS, $this->sortBy, $parameters);
        $campusJumpLink .= "&". modulecim_stats::CAMPUS_ID . "=";
        $links["campusJumpLink"] = $campusJumpLink;

        $parameters = array('WEEK_ID'=>$this->WEEK_ID, 'STAFF_ID'=>$this->STAFF_ID, 'SEMESTER_ID'=>$this->SEMESTER_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'METHOD_ID'=>$this->METHOD_ID, 'PRC_ID'=>$this->PRC_ID, 'EXPOSURE_ID'=>$this->EXPOSURE_ID, 'MORESTATS_ID'=>$this->MORESTATS_ID);//[RAD_CALLBACK_PARAMS]
        $sortByLink = $this->getCallBack( modulecim_stats::PAGE_MORESTATS, '', $parameters );
        $sortByLink .= "&".modulecim_stats::SORTBY."=";
        $links["sortBy"] = $sortByLink;

        $this->pageDisplay->setLinks( $links );  
        
        $this->addScript('MM_jumpMenu.jsp');   
        
    } // end loadMoreStats()



    //************************************************************************
	/**
	 * function loadStaffAdditionalWeeklyStats
	 * <pre>
	 * Initializes the StaffAdditionalWeeklyStats Page.
	 * </pre>
	 * @return [void]
	 */
    // RAD Tools: FormSingleEntry style
    function loadStaffAdditionalWeeklyStats() 
    {
        // set the pageCallBack to be without any additional parameters
        // (an AdminBox needs this so Language Switching on a page doesn't
        // pass a previous operations)
        $parameters = array('WEEK_ID'=>$this->WEEK_ID, 'STAFF_ID'=>$this->STAFF_ID, 'SEMESTER_ID'=>$this->SEMESTER_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'METHOD_ID'=>$this->METHOD_ID, 'PRC_ID'=>$this->PRC_ID, 'EXPOSURE_ID'=>$this->EXPOSURE_ID, 'MORESTATS_ID'=>$this->MORESTATS_ID);//[RAD_CALLBACK_PARAMS]
        $pageCallBack = $this->getCallBack(modulecim_stats::PAGE_STAFFADDITIONALWEEKLYSTATS, $this->sortBy, $parameters);
        $this->setPageCallBack( $pageCallBack );
        
        
        $parameters = array('WEEK_ID'=>$this->WEEK_ID, 'STAFF_ID'=>$this->STAFF_ID, 'SEMESTER_ID'=>$this->SEMESTER_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'METHOD_ID'=>$this->METHOD_ID, 'PRC_ID'=>$this->PRC_ID, 'EXPOSURE_ID'=>$this->EXPOSURE_ID, 'MORESTATS_ID'=>$this->MORESTATS_ID);//[RAD_CALLBACK_PARAMS]
        $formAction = $this->getCallBack(modulecim_stats::PAGE_STAFFADDITIONALWEEKLYSTATS, $this->sortBy, $parameters );
        $this->pageDisplay = new FormProcessor_StaffAdditionalWeeklyStats( $this->moduleRootPath, $this->viewer, $formAction, '', $this->STAFF_ID, $this->WEEK_ID, $this->CAMPUS_ID );//[RAD_FORMINIT_FOREIGNKEY_INIT]   
        
        
        
        // note: we omit the week_id for this set of parameters
        $parameters = array('STAFF_ID'=>$this->STAFF_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID );
        $jumpLink = $this->getCallBack( modulecim_stats::PAGE_STAFFADDITIONALWEEKLYSTATS, $this->sortBy, $parameters);
        $jumpLink .= "&". modulecim_stats::WEEK_ID . "=";
        $links["weekJumpLink"] = $jumpLink;
        
        // note: we omit the campus_id for this set of parameters
        $parameters = array('WEEK_ID'=>$this->WEEK_ID, 'STAFF_ID'=>$this->STAFF_ID);
        $campusJumpLink = $this->getCallBack( modulecim_stats::PAGE_STAFFADDITIONALWEEKLYSTATS, $this->sortBy, $parameters);
        $campusJumpLink .= "&". modulecim_stats::CAMPUS_ID . "=";
        $links["campusJumpLink"] = $campusJumpLink;

        $this->pageDisplay->setLinks( $links );
        
        $this->addScript('MM_jumpMenu.jsp'); 
             
        
    } // end loadStaffAdditionalWeeklyStats()



    //************************************************************************
	/**
	 * function loadPRC_ReportByCampus
	 * <pre>
	 * Initializes the PRC_ReportByCampus Page.
	 * </pre>
	 * @return [void]
	 */
    // RAD Tools: Custom style
    function loadPRC_ReportByCampus() 
    {
        // set the pageCallBack to be without any additional parameters
        // (an AdminBox needs this so Language Switching on a page doesn't
        // pass a previous operations)
        $parameters = array('WEEK_ID'=>$this->WEEK_ID, 'STAFF_ID'=>$this->STAFF_ID, 'SEMESTER_ID'=>$this->SEMESTER_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'METHOD_ID'=>$this->METHOD_ID, 'PRC_ID'=>$this->PRC_ID, 'EXPOSURE_ID'=>$this->EXPOSURE_ID, 'MORESTATS_ID'=>$this->MORESTATS_ID, 'PRIV_ID'=>$this->PRIV_ID, 'ACCESS_ID'=>$this->ACCESS_ID, 'COORDINATOR_ID'=>$this->COORDINATOR_ID);//[RAD_CALLBACK_PARAMS]
        $pageCallBack = $this->getCallBack(modulecim_stats::PAGE_PRC_REPORTBYCAMPUS, $this->sortBy, $parameters);
        $this->setPageCallBack( $pageCallBack );
        
        
        $this->pageDisplay = new page_PRC_ReportByCampus( $this->moduleRootPath, $this->viewer, $this->SEMESTER_ID );   
        
        $links = array();
        
        $parameters = array( 'WEEK_ID'=>$this->WEEK_ID, 'STAFF_ID'=>$this->STAFF_ID, 'SEMESTER_ID'=>$this->SEMESTER_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'METHOD_ID'=>$this->METHOD_ID, 'PRC_ID'=>$this->PRC_ID, 'EXPOSURE_ID'=>$this->EXPOSURE_ID, 'MORESTATS_ID'=>$this->MORESTATS_ID, 'PRIV_ID'=>$this->PRIV_ID, 'ACCESS_ID'=>$this->ACCESS_ID, 'COORDINATOR_ID'=>$this->COORDINATOR_ID);//[RAD_CALLBACK_PARAMS]
        $continueLink = $this->getCallBack( modulecim_stats::PAGE_STATSHOME, "", $parameters );
        $links["cont"] = $continueLink;

/*[RAD_LINK_INSERT]*/

    // note: we omit the semester_id for this set of parameters
        $parameters = array('STAFF_ID'=>$this->STAFF_ID);
        $semesterJumpLink = $this->getCallBack( modulecim_stats::PAGE_PRC_REPORTBYCAMPUS, $this->sortBy, $parameters);
        $semesterJumpLink .= "&". modulecim_stats::SEMESTER_ID . "=";
        $links["semesterJumpLink"] = $semesterJumpLink;

        $this->pageDisplay->setLinks( $links );   
        
        $this->addScript('MM_jumpMenu.jsp');   
        
    } // end loadPRC_ReportByCampus()



    //************************************************************************
	/**
	 * function loadReports
	 * <pre>
	 * Initializes the Reports Page.
	 * </pre>
	 * @return [void]
	 */
    // RAD Tools: Custom style
    function loadReports() 
    {
        // set the pageCallBack to be without any additional parameters
        // (an AdminBox needs this so Language Switching on a page doesn't
        // pass a previous operations)
        $parameters = array('WEEK_ID'=>$this->WEEK_ID, 'STAFF_ID'=>$this->STAFF_ID, 'SEMESTER_ID'=>$this->SEMESTER_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'METHOD_ID'=>$this->METHOD_ID, 'PRC_ID'=>$this->PRC_ID, 'EXPOSURE_ID'=>$this->EXPOSURE_ID, 'MORESTATS_ID'=>$this->MORESTATS_ID, 'PRIV_ID'=>$this->PRIV_ID, 'ACCESS_ID'=>$this->ACCESS_ID, 'COORDINATOR_ID'=>$this->COORDINATOR_ID);//[RAD_CALLBACK_PARAMS]
        $pageCallBack = $this->getCallBack(modulecim_stats::PAGE_REPORTS, $this->sortBy, $parameters);
        $this->setPageCallBack( $pageCallBack );
        
        
        $this->pageDisplay = new page_Reports( $this->moduleRootPath, $this->viewer );   
        
        $links = array();
        
        $parameters = array( 'WEEK_ID'=>$this->WEEK_ID, 'STAFF_ID'=>$this->STAFF_ID, 'SEMESTER_ID'=>$this->SEMESTER_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'METHOD_ID'=>$this->METHOD_ID, 'PRC_ID'=>$this->PRC_ID, 'EXPOSURE_ID'=>$this->EXPOSURE_ID, 'MORESTATS_ID'=>$this->MORESTATS_ID, 'PRIV_ID'=>$this->PRIV_ID, 'ACCESS_ID'=>$this->ACCESS_ID, 'COORDINATOR_ID'=>$this->COORDINATOR_ID);//[RAD_CALLBACK_PARAMS]
        $continueLink = $this->getCallBack( modulecim_stats::PAGE_STATSHOME, "", $parameters );
        $links["cont"] = $continueLink;

/*[RAD_LINK_INSERT]*/

        $this->pageDisplay->setLinks( $links );     
        
    } // end loadReports()



    //************************************************************************
	/**
	 * function loadStaffSemesterReport
	 * <pre>
	 * Initializes the StaffSemesterReport Page.
	 * </pre>
	 * @return [void]
	 */
    // RAD Tools: Custom style
    function loadStaffSemesterReport() 
    {
        // set the pageCallBack to be without any additional parameters
        // (an AdminBox needs this so Language Switching on a page doesn't
        // pass a previous operations)
        $parameters = array('WEEK_ID'=>$this->WEEK_ID, 'STAFF_ID'=>$this->STAFF_ID, 'SEMESTER_ID'=>$this->SEMESTER_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'METHOD_ID'=>$this->METHOD_ID, 'PRC_ID'=>$this->PRC_ID, 'EXPOSURE_ID'=>$this->EXPOSURE_ID, 'MORESTATS_ID'=>$this->MORESTATS_ID, 'PRIV_ID'=>$this->PRIV_ID, 'ACCESS_ID'=>$this->ACCESS_ID, 'COORDINATOR_ID'=>$this->COORDINATOR_ID);//[RAD_CALLBACK_PARAMS]
        $pageCallBack = $this->getCallBack(modulecim_stats::PAGE_STAFFSEMESTERREPORT, $this->sortBy, $parameters);
        $this->setPageCallBack( $pageCallBack );
        
        
        $this->pageDisplay = new page_StaffSemesterReport( $this->moduleRootPath, $this->viewer, $this->STAFF_ID, $this->CAMPUS_ID, $this->SEMESTER_ID );   
        
        $links = array();
        
        $parameters = array( 'WEEK_ID'=>$this->WEEK_ID, 'STAFF_ID'=>$this->STAFF_ID, 'SEMESTER_ID'=>$this->SEMESTER_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'METHOD_ID'=>$this->METHOD_ID, 'PRC_ID'=>$this->PRC_ID, 'EXPOSURE_ID'=>$this->EXPOSURE_ID, 'MORESTATS_ID'=>$this->MORESTATS_ID, 'PRIV_ID'=>$this->PRIV_ID, 'ACCESS_ID'=>$this->ACCESS_ID, 'COORDINATOR_ID'=>$this->COORDINATOR_ID);//[RAD_CALLBACK_PARAMS]
        $continueLink = $this->getCallBack( modulecim_stats::PAGE_STATSHOME, "", $parameters );
        $links["cont"] = $continueLink;

/*[RAD_LINK_INSERT]*/
        
        // note: we omit the campus_id for this set of parameters
        $parameters = array('SEMESTER_ID'=>$this->SEMESTER_ID, 'STAFF_ID'=>$this->STAFF_ID);
        $campusJumpLink = $this->getCallBack( modulecim_stats::PAGE_STAFFSEMESTERREPORT, $this->sortBy, $parameters);
        $campusJumpLink .= "&". modulecim_stats::CAMPUS_ID . "=";
        $links["campusJumpLink"] = $campusJumpLink;
        
        // note: we omit the semester_id for this set of parameters
        $parameters = array('CAMPUS_ID'=>$this->CAMPUS_ID, 'STAFF_ID'=>$this->STAFF_ID);
        $semesterJumpLink = $this->getCallBack( modulecim_stats::PAGE_STAFFSEMESTERREPORT, $this->sortBy, $parameters);
        $semesterJumpLink .= "&". modulecim_stats::SEMESTER_ID . "=";
        $links["semesterJumpLink"] = $semesterJumpLink;

        $this->pageDisplay->setLinks( $links );
        
        $this->addScript('MM_jumpMenu.jsp');   
   
        
    } // end loadStaffSemesterReport()



    //************************************************************************
	/**
	 * function loadRegionalSemesterReport
	 * <pre>
	 * Initializes the RegionalSemesterReport Page.
	 * </pre>
	 * @return [void]
	 */
    // RAD Tools: Custom style
    function loadRegionalSemesterReport() 
    {
        // set the pageCallBack to be without any additional parameters
        // (an AdminBox needs this so Language Switching on a page doesn't
        // pass a previous operations)
        $parameters = array('WEEK_ID'=>$this->WEEK_ID, 'STAFF_ID'=>$this->STAFF_ID, 'SEMESTER_ID'=>$this->SEMESTER_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'METHOD_ID'=>$this->METHOD_ID, 'PRC_ID'=>$this->PRC_ID, 'EXPOSURE_ID'=>$this->EXPOSURE_ID, 'MORESTATS_ID'=>$this->MORESTATS_ID, 'PRIV_ID'=>$this->PRIV_ID, 'ACCESS_ID'=>$this->ACCESS_ID, 'COORDINATOR_ID'=>$this->COORDINATOR_ID, 'REGION_ID'=>$this->REGION_ID, 'YEAR_ID'=>$this->YEAR_ID);//[RAD_CALLBACK_PARAMS]
        $pageCallBack = $this->getCallBack(modulecim_stats::PAGE_REGIONALSEMESTERREPORT, $this->sortBy, $parameters);
        $this->setPageCallBack( $pageCallBack );
        
        
        $this->pageDisplay = new page_RegionalSemesterReport( $this->moduleRootPath, $this->viewer, $this->REGION_ID, $this->SEMESTER_ID );   
        
        $links = array();
        
        $parameters = array( 'WEEK_ID'=>$this->WEEK_ID, 'STAFF_ID'=>$this->STAFF_ID, 'SEMESTER_ID'=>$this->SEMESTER_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'METHOD_ID'=>$this->METHOD_ID, 'PRC_ID'=>$this->PRC_ID, 'EXPOSURE_ID'=>$this->EXPOSURE_ID, 'MORESTATS_ID'=>$this->MORESTATS_ID, 'PRIV_ID'=>$this->PRIV_ID, 'ACCESS_ID'=>$this->ACCESS_ID, 'COORDINATOR_ID'=>$this->COORDINATOR_ID, 'REGION_ID'=>$this->REGION_ID, 'YEAR_ID'=>$this->YEAR_ID);//[RAD_CALLBACK_PARAMS]
        $continueLink = $this->getCallBack( modulecim_stats::PAGE_STATSHOME, "", $parameters );
        $links["cont"] = $continueLink;

/*[RAD_LINK_INSERT]*/

        // note: we omit the region_id for this set of parameters
        $parameters = array('SEMESTER_ID'=>$this->SEMESTER_ID, 'STAFF_ID'=>$this->STAFF_ID);
        $regionJumpLink = $this->getCallBack( modulecim_stats::PAGE_REGIONALSEMESTERREPORT, $this->sortBy, $parameters);
        $regionJumpLink .= "&". modulecim_stats::REGION_ID . "=";
        $links["regionJumpLink"] = $regionJumpLink;
        
        // note: we omit the semester_id for this set of parameters
        $parameters = array('REGION_ID'=>$this->REGION_ID, 'STAFF_ID'=>$this->STAFF_ID);
        $semesterJumpLink = $this->getCallBack( modulecim_stats::PAGE_REGIONALSEMESTERREPORT, $this->sortBy, $parameters);
        $semesterJumpLink .= "&". modulecim_stats::SEMESTER_ID . "=";
        $links["semesterJumpLink"] = $semesterJumpLink;
        
        if ( $this->SEMESTER_ID == '' )
        {
            $this->SEMESTER_ID = 'SSS';
        }
	if ( $this->YEAR_ID == '' )
	{
	    $this->YEAR_ID = 'YYY';
	}
        
        $parameters = array('SEMESTER_ID'=>$this->SEMESTER_ID, 'YEAR_ID'=>$this->YEAR_ID);
        $campusSummaryJumpLink = $this->getCallBack( modulecim_stats::PAGE_CAMPUSYEARSUMMARY, $this->sortBy, $parameters);
        $campusSummaryJumpLink .= "&". modulecim_stats::CAMPUS_ID . "=";
        $links["campusSummaryJumpLink"] = $campusSummaryJumpLink;
        
        /*
        $parameters = array('SEMESTER_ID'=>$this->SEMESTER_ID);
        $campusPersonalJumpLink = $this->getCallBack( modulecim_stats::PAGE_STAFFSEMESTERREPORT, $this->sortBy, $parameters);
        $campusPersonalJumpLink .= "&". modulecim_stats::CAMPUS_ID . "=";
        $links["campusPersonalJumpLink"] = $campusPersonalJumpLink;
        
        $campusWideJumpLink = $this->getCallBack( modulecim_stats::PAGE_CAMPUSWEEKLYSTATSREPORT, $this->sortBy, $parameters);
        $campusWideJumpLink .= "&". modulecim_stats::CAMPUS_ID . "=";
        $links["campusWideJumpLink"] = $campusWideJumpLink;
        
        $indicatedDecLink = $this->getCallBack( modulecim_stats::PAGE_PRC, $this->sortBy, $parameters);
        $indicatedDecLink .= "&". modulecim_stats::CAMPUS_ID . "=";
        $links["indicatedDecLink"] = $indicatedDecLink; */

        $this->pageDisplay->setLinks( $links );   
        
        $this->addScript('MM_jumpMenu.jsp');   
        
    } // end loadRegionalSemesterReport()



    //************************************************************************
	/**
	 * function loadCampusWeeklyStatsReport
	 * <pre>
	 * Initializes the CampusWeeklyStatsReport Page.
	 * </pre>
	 * @return [void]
	 */
    // RAD Tools: Custom style
    function loadCampusWeeklyStatsReport() 
    {
        // set the pageCallBack to be without any additional parameters
        // (an AdminBox needs this so Language Switching on a page doesn't
        // pass a previous operations)
        $parameters = array('WEEK_ID'=>$this->WEEK_ID, 'STAFF_ID'=>$this->STAFF_ID, 'SEMESTER_ID'=>$this->SEMESTER_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'METHOD_ID'=>$this->METHOD_ID, 'PRC_ID'=>$this->PRC_ID, 'EXPOSURE_ID'=>$this->EXPOSURE_ID, 'MORESTATS_ID'=>$this->MORESTATS_ID, 'PRIV_ID'=>$this->PRIV_ID, 'ACCESS_ID'=>$this->ACCESS_ID, 'COORDINATOR_ID'=>$this->COORDINATOR_ID, 'REGION_ID'=>$this->REGION_ID);//[RAD_CALLBACK_PARAMS]
        $pageCallBack = $this->getCallBack(modulecim_stats::PAGE_CAMPUSWEEKLYSTATSREPORT, $this->sortBy, $parameters);
        $this->setPageCallBack( $pageCallBack );
        
        
        $this->pageDisplay = new page_CampusWeeklyStatsReport( $this->moduleRootPath, $this->viewer, $this->STAFF_ID, $this->CAMPUS_ID, $this->SEMESTER_ID );   
        
        $links = array();
        
        $parameters = array( 'WEEK_ID'=>$this->WEEK_ID, 'STAFF_ID'=>$this->STAFF_ID, 'SEMESTER_ID'=>$this->SEMESTER_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'METHOD_ID'=>$this->METHOD_ID, 'PRC_ID'=>$this->PRC_ID, 'EXPOSURE_ID'=>$this->EXPOSURE_ID, 'MORESTATS_ID'=>$this->MORESTATS_ID, 'PRIV_ID'=>$this->PRIV_ID, 'ACCESS_ID'=>$this->ACCESS_ID, 'COORDINATOR_ID'=>$this->COORDINATOR_ID, 'REGION_ID'=>$this->REGION_ID);//[RAD_CALLBACK_PARAMS]
        $continueLink = $this->getCallBack( modulecim_stats::PAGE_STATSHOME, "", $parameters );
        $links["cont"] = $continueLink;

/*[RAD_LINK_INSERT]*/

        // note: we omit the campus_id for this set of parameters
        $parameters = array('SEMESTER_ID'=>$this->SEMESTER_ID, 'STAFF_ID'=>$this->STAFF_ID);
        $campusJumpLink = $this->getCallBack( modulecim_stats::PAGE_CAMPUSWEEKLYSTATSREPORT, $this->sortBy, $parameters);
        $campusJumpLink .= "&". modulecim_stats::CAMPUS_ID . "=";
        $links["campusJumpLink"] = $campusJumpLink;
        
        // note: we omit the semester_id for this set of parameters
        $parameters = array('CAMPUS_ID'=>$this->CAMPUS_ID, 'STAFF_ID'=>$this->STAFF_ID);
        $semesterJumpLink = $this->getCallBack( modulecim_stats::PAGE_CAMPUSWEEKLYSTATSREPORT, $this->sortBy, $parameters);
        $semesterJumpLink .= "&". modulecim_stats::SEMESTER_ID . "=";
        $links["semesterJumpLink"] = $semesterJumpLink;

        $this->pageDisplay->setLinks( $links ); 
        
        $this->addScript('MM_jumpMenu.jsp');    
        
    } // end loadCampusWeeklyStatsReport()



    //************************************************************************
	/**
	 * function loadCampusYearSummary
	 * <pre>
	 * Initializes the CampusYearSummary Page.
	 * </pre>
	 * @return [void]
	 */
    // RAD Tools: Custom style
    function loadCampusYearSummary() 
    {
        // set the pageCallBack to be without any additional parameters
        // (an AdminBox needs this so Language Switching on a page doesn't
        // pass a previous operations)
        $parameters = array('YEAR_ID'=>$this->YEAR_ID, 'WEEK_ID'=>$this->WEEK_ID, 'STAFF_ID'=>$this->STAFF_ID, 'SEMESTER_ID'=>$this->SEMESTER_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'METHOD_ID'=>$this->METHOD_ID, 'PRC_ID'=>$this->PRC_ID, 'EXPOSURE_ID'=>$this->EXPOSURE_ID, 'MORESTATS_ID'=>$this->MORESTATS_ID, 'PRIV_ID'=>$this->PRIV_ID, 'ACCESS_ID'=>$this->ACCESS_ID, 'COORDINATOR_ID'=>$this->COORDINATOR_ID, 'REGION_ID'=>$this->REGION_ID);//[RAD_CALLBACK_PARAMS]
        $pageCallBack = $this->getCallBack(modulecim_stats::PAGE_CAMPUSYEARSUMMARY, $this->sortBy, $parameters);
        $this->setPageCallBack( $pageCallBack );
        
        
        $this->pageDisplay = new page_CampusYearSummary( $this->moduleRootPath, $this->viewer, $this->STAFF_ID, $this->CAMPUS_ID, $this->YEAR_ID  );   
        
        $links = array();
        
        $parameters = array( 'YEAR_ID'=>$this->YEAR_ID, 'WEEK_ID'=>$this->WEEK_ID, 'STAFF_ID'=>$this->STAFF_ID, 'SEMESTER_ID'=>$this->SEMESTER_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'METHOD_ID'=>$this->METHOD_ID, 'PRC_ID'=>$this->PRC_ID, 'EXPOSURE_ID'=>$this->EXPOSURE_ID, 'MORESTATS_ID'=>$this->MORESTATS_ID, 'PRIV_ID'=>$this->PRIV_ID, 'ACCESS_ID'=>$this->ACCESS_ID, 'COORDINATOR_ID'=>$this->COORDINATOR_ID, 'REGION_ID'=>$this->REGION_ID);//[RAD_CALLBACK_PARAMS]
        $continueLink = $this->getCallBack( modulecim_stats::PAGE_STATSHOME, "", $parameters );
        $links["cont"] = $continueLink;

/*[RAD_LINK_INSERT]*/

        // note: we omit the campus_id for this set of parameters
        $parameters = array('YEAR_ID'=>$this->YEAR_ID, 'STAFF_ID'=>$this->STAFF_ID);
        $campusJumpLink = $this->getCallBack( modulecim_stats::PAGE_CAMPUSYEARSUMMARY, $this->sortBy, $parameters);
        $campusJumpLink .= "&". modulecim_stats::CAMPUS_ID . "=";
        $links["campusJumpLink"] = $campusJumpLink;
        
        // note: we omit the year_id for this set of parameters
        $parameters = array('CAMPUS_ID'=>$this->CAMPUS_ID, 'STAFF_ID'=>$this->STAFF_ID);
        $yearJumpLink = $this->getCallBack( modulecim_stats::PAGE_CAMPUSYEARSUMMARY, $this->sortBy, $parameters);
        $yearJumpLink .= "&". modulecim_stats::YEAR_ID . "=";
        $links["yearJumpLink"] = $yearJumpLink;
        
        $parameters = array('CAMPUS_ID'=>$this->CAMPUS_ID, 'STAFF_ID'=>$this->STAFF_ID, 'YEAR_ID'=>$this->YEAR_ID );
        $links['semStatsLink'] = $this->getCallBack( modulecim_stats::PAGE_SEMESTERREPORT, $this->sortBy, $parameters) . "&". modulecim_stats::SEMESTER_ID . "=";
        $links['campusTeamLink'] = $this->getCallBack( modulecim_stats::PAGE_CAMPUSWEEKLYSTATSREPORT, $this->sortBy, $parameters). "&". modulecim_stats::SEMESTER_ID . "=";
        $links['indDecLink'] = $this->getCallBack( modulecim_stats::PAGE_PRC, $this->sortBy, $parameters) . "&". modulecim_stats::SEMESTER_ID . "=";
        $links['personalMinLink'] = $this->getCallBack( modulecim_stats::PAGE_STAFFSEMESTERREPORT, $this->sortBy, $parameters) . "&". modulecim_stats::SEMESTER_ID . "=";

        $this->pageDisplay->setLinks( $links );  
        
        $this->addScript('MM_jumpMenu.jsp');    
        
    } // end loadCampusYearSummary()



/*[RAD_PAGE_LOAD_FN]*/		

}

?>
