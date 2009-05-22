<?php

// First load the common Registration Summaries Tools object
// This object allows for efficient access to registration summary data (multi-table).
// $fileName = 'Tools/tools_RegSummaries.php';
// $path = Page::findPathExtension( $fileName );
// require_once( $path.$fileName);

/**
 * @package cim_reg
 class modulep2c_stats
 discussion <pre>
 Written By	:	Russ Martin
 Date		:   12 Feb 2007
 
 registration system module... version 2.0
 
 </pre>	
*/
class modulep2c_stats extends XMLObject_PageContent {
// 		
//
//	CONSTANTS:               

// 		  const CSV_DOWNLOAD_TOOL = 'page_Downloads.php';

    /** const EVENT_DATA_FILE_NAME The name/suffix of the file where event registration data is stored */
        const STATS_DATA_FILE_SUFFIX = 'statsDataDump.csv';
            
                
    /** const MULTILINGUAL_SERIES_KEY The Multilingual Series key for this application.. */
        const MULTILINGUAL_SERIES_KEY = 'modulep2c_stats';
        
    /** const MULTILINGUAL_PAGE_FIELDS The Multilingual Page key for the fields of this application. */
        const MULTILINGUAL_PAGE_FIELDS = 'fields_p2c_stats';
        
    /** const MODULE_KEY The Module Key for this Module.  Used for access */
        const MODULE_KEY = 'p2c_stats';
        
    /** const PAGE    The QueryString Page parameter. */
        const PAGE = "P";
 
      /** const PAGE_STATS_HOME   Display the stats home Page. */   
        const PAGE_STATS_HOME = "P72";             
                                    
      /** const PAGE_STATS_INPUTFILTER_FORM   Display the pre-input stats form page. */   
        const PAGE_STATS_INPUTFILTER_FORM = "P73";   
        
      /** const PAGE_NOTAUTHORIZED   Display the unauthorized access page. */   
        const PAGE_NOTAUTHORIZED = "P74";    
        
      /** const PAGE_STATSINPUT   Display the stats input page. */   
        const PAGE_STATSINPUT = "P75";   
        
       /** const PAGE_STATSINPUT   Display the stats report filter page. */   
        const PAGE_STATS_REPORTFILTER_FORM = "P76";     
        
        /** const PAGE_STATS_REPORTSELECTION_FORM   Display the report selection (filter #2) page. */   
        const PAGE_STATS_REPORTSELECTION_FORM = "P77";    
        
         /** const PAGE_STATS_REPORT   Display the generated report page. */   
        const PAGE_STATS_REPORT = "P78";                                     



    /** const PAGE_EDITMINISTRY   Display the EditMinistry Page. */
        const PAGE_EDITMINISTRY = "P81";

    /** const PAGE_EDITDIVISION   Display the EditDivision Page. */
        const PAGE_EDITDIVISION = "P82";

    /** const PAGE_EDITREGION   Display the EditRegion Page. */
        const PAGE_EDITREGION = "P83";

    /** const PAGE_EDITLOCATION   Display the EditLocation Page. */
        const PAGE_EDITLOCATION = "P84";


    /** const PAGE_EDITSTATISTIC   Display the EditStatistic Page. */
        const PAGE_EDITSTATISTIC = "P86";

/*[RAD_PAGE_CONST]*/

    /** const SORTBY    The QueryString SortBy parameter. */
        const SORTBY = "modSort";
 
    /*! const VIEWER_ID   The QueryString VIEWER_ID parameter. */
        const VIEWER_ID = "SV27";

    /*! const PERSON_ID   The QueryString PERSON_ID parameter. */
        const PERSON_ID = "SV43";               

    /*! const STAT_ID   The QueryString STAT_ID parameter. */
        const STAT_ID = "SV53";

    /*! const SCOPE_ID   The QueryString SCOPE_ID parameter. */
        const SCOPE_ID = "SV54";

    /*! const MINISTRY_ID   The QueryString MINISTRY_ID parameter. */
        const MINISTRY_ID = "SV55";

    /*! const DIVISION_ID   The QueryString DIVISION_ID parameter. */
        const DIVISION_ID = "SV56";

    /*! const REGION_ID   The QueryString REGION_ID parameter. */
        const REGION_ID = "SV57";

    /*! const LOCATION_ID   The QueryString LOCATION_ID parameter. */
        const LOCATION_ID = "SV58";

    /*! const FREQ_ID   The QueryString FREQ_ID parameter. */
        const FREQ_ID = "SV59";

    /*! const MEAS_ID   The QueryString MEAS_ID parameter. */
        const MEAS_ID = "SV60";
        
     /*! const STATVALUES_ID   The QueryString STATVALUES_ID parameter. */
        const STATVALUES_ID = "SV61";       

    /*! const FREQVALUE_ID   The QueryString FREQVALUE_ID parameter. */
        const FREQVALUE_ID = "SV62";

    /*! const FILTER_ID   The QueryString FILTER_ID parameter. */
        const FILTER_ID = "SV63";

    /*! const SCOPE_REF_ID   The QueryString SCOPE_REF_ID parameter. */
        const SCOPE_REF_ID = "SV64";

    /*! const STATTYPE_ID   The QueryString STATTYPE_ID parameter. */
        const STATTYPE_ID = "SV65";

/*[RAD_PAGE_STATEVAR_CONST]*/

    /*! const SCOPE_REF_MINISTRY   The constant denoting a Ministry. */
        const SCOPE_REF_MINISTRY = "1";
 
    /*! const SCOPE_REF_DIVISION   The constant denoting a Division. */
        const SCOPE_REF_DIVISION = "2";      
        
    /*! const SCOPE_REF_REGION   The constant denoting a Region. */
        const SCOPE_REF_REGION = "3";         
        
    /*! const SCOPE_REF_LOCATION   The constant denoting a Location. */
        const SCOPE_REF_LOCATION = "4";                     
     	      	          
//
//	VARIABLES:
        
    /** protected $page   [STRING] The current Mode of this Module. */
		protected $page;
		
    /** protected $sortBy [STRING] Parameter to sort displayed Lists. */
        protected $sortBy;
		
    /*! protected $STAT_ID   [INTEGER] unique identifier of statistic names */
		protected $STAT_ID;

    /*! protected $SCOPE_ID   [INTEGER] unique identifier of scope type */
		protected $SCOPE_ID;

    /*! protected $MINISTRY_ID   [INTEGER] unique identifier of ministry type */
		protected $MINISTRY_ID;

    /*! protected $DIVISION_ID   [INTEGER] unique identifier of division type */
		protected $DIVISION_ID;

    /*! protected $REGION_ID   [INTEGER] unique identifier of regions */
		protected $REGION_ID;
		
    /*! protected $LOCATION_ID   [INTEGER] unique identifier of location */
		protected $LOCATION_ID;		

    /*! protected $VIEWER_ID   [INTEGER] unique identifier of system user */
		protected $VIEWER_ID;

    /*! protected $FREQ_ID   [INTEGER] unique identifier for a frequency type (i.e. Daily, Weekly, etc) */
		protected $FREQ_ID;

    /*! protected $MEAS_ID   [INTEGER] unique identifier for a measurement type (i.e. 'Personal Ministry') */
		protected $MEAS_ID;
		
    /*! protected $STATVALUES_ID   [INTEGER] unique identifier for a particular stats value */
		protected $STATVALUES_ID;		

    /*! protected $PERSON_ID   [INTEGER] unique identifier for a person (HRDB var) */
		protected $PERSON_ID;
		

    /*! protected $FREQVALUE_ID   [INTEGER] unique identifier for a specific frequency value */
		protected $FREQVALUE_ID;

    /*! protected $FILTER_ID   [INTEGER] unique identifier for a report filter/calculation */
		protected $FILTER_ID;

    /*! protected $SCOPE_REF_ID   [INTEGER] unique identifier for some scope (could be any of the defined scopes) */
		protected $SCOPE_REF_ID;

    /*! protected $STATTYPE_ID   [INTEGER] unique identifier of a statistic data type */
		protected $STATTYPE_ID;

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
//        $this->appID = $this->getQSValue( modulep2c_stats::APPID, '' );
        
        // load the common page layout object
        $this->pageCommonDisplay = new CommonDisplay( $this->moduleRootPath, $this->pathToRoot, $this->viewer);
         
        // load the module's page (DEFAULT = WELCOME)
        $this->page = $this->getQSValue( modulep2c_stats::PAGE, modulep2c_stats::PAGE_STATS_HOME );
        
        // load the module's sortBy parameter (DEFAULT = '')
        $this->sortBy = $this->getQSValue( modulep2c_stats::SORTBY, '' );
        
        // load the module's STAT_ID variable
        $this->STAT_ID = $this->getQSValue( modulep2c_stats::STAT_ID, "" );

        // load the module's SCOPE_ID variable
        $this->SCOPE_ID = $this->getQSValue( modulep2c_stats::SCOPE_ID, "" );

        // load the module's MINISTRY_ID variable
        $this->MINISTRY_ID = $this->getQSValue( modulep2c_stats::MINISTRY_ID, "" );

        // load the module's DIVISION_ID variable
        $this->DIVISION_ID = $this->getQSValue( modulep2c_stats::DIVISION_ID, "" );

        // load the module's REGION_ID variable
        $this->REGION_ID = $this->getQSValue( modulep2c_stats::REGION_ID, "" );
        
        // load the module's LOCATION_ID variable
        $this->LOCATION_ID = $this->getQSValue( modulep2c_stats::LOCATION_ID, "" );        

        // load the module's VIEWER_ID variable
        $this->VIEWER_ID = $this->getQSValue( modulep2c_stats::VIEWER_ID, "" );

        // load the module's PERSON_ID variable
        $this->PERSON_ID = $this->getQSValue( modulep2c_stats::PERSON_ID, "" );
        
                // load the module's FREQ_ID variable
        $this->FREQ_ID = $this->getQSValue( modulep2c_stats::FREQ_ID, "" );
        
                // load the module's MEAS_ID variable
        $this->MEAS_ID = $this->getQSValue( modulep2c_stats::MEAS_ID, "" ); 

               // load the module's STATVALUES_ID variable
        $this->STATVALUES_ID = $this->getQSValue( modulep2c_stats::STATVALUES_ID, "" );            
                

        // load the module's FREQVALUE_ID variable
        $this->FREQVALUE_ID = $this->getQSValue( modulep2c_stats::FREQVALUE_ID, "" );

        // load the module's FILTER_ID variable
        $this->FILTER_ID = $this->getQSValue( modulep2c_stats::FILTER_ID, "" );

        // load the module's SCOPE_REF_ID variable
        $this->SCOPE_REF_ID = $this->getQSValue( modulep2c_stats::SCOPE_REF_ID, "" );

        // load the module's STATTYPE_ID variable
        $this->STATTYPE_ID = $this->getQSValue( modulep2c_stats::STATTYPE_ID, "" );

/*[RAD_PAGE_LOAD_STATEVAR]*/
        
        switch( $this->page ) {
	        
            /*
             *  Not Authorized page
             */
            case modulep2c_stats::PAGE_NOTAUTHORIZED:
                $this->loadNotAuthorized();
                break;	        
                
            /*
             *  StatsHome
             */
            case modulep2c_stats::PAGE_STATS_HOME:
                $this->loadStatsHome();
                break;

            /*
             *  StatsInputFilterForm
             */
            case modulep2c_stats::PAGE_STATS_INPUTFILTER_FORM:
                $this->loadStatsInputFilterForm();                                  
                break;  
                
            /*
             *  StatsInput
             */
            case modulep2c_stats::PAGE_STATSINPUT:
                $this->loadStatsInput();
                break;                   
 
            /*
             *  StatsReportFilterForm
             */
            case modulep2c_stats::PAGE_STATS_REPORTFILTER_FORM:
                $this->loadStatsReportFilterForm();
                break;                 
                  
             /*
             *  StatsReportSelectionForm
             */
            case modulep2c_stats::PAGE_STATS_REPORTSELECTION_FORM:
                $this->loadStatsReportSelectionForm();
                break;            
                
             /*
             *  StatsReport
             */                
            case modulep2c_stats::PAGE_STATS_REPORT:   
                $this->loadStatsReport();
                break;                         
                                  
             /*
             *  DownloadReport
             */
//             case modulep2c_stats::PAGE_DOWNLOADREPORT:
//                 $this->loadDownloadReport();
//                 break;                                      
                


            /*
             *  EditMinistry
             */
            case modulep2c_stats::PAGE_EDITMINISTRY:
                $this->loadEditMinistry();
                break;

            /*
             *  EditDivision
             */
            case modulep2c_stats::PAGE_EDITDIVISION:
                $this->loadEditDivision();
                break;

            /*
             *  EditRegion
             */
            case modulep2c_stats::PAGE_EDITREGION:
                $this->loadEditRegion();
                break;

            /*
             *  EditLocation
             */
            case modulep2c_stats::PAGE_EDITLOCATION:
                $this->loadEditLocation();
                break;


            /*
             *  EditStatistic
             */
            case modulep2c_stats::PAGE_EDITSTATISTIC:
                $this->loadEditStatistic();
                break;

/*[RAD_PAGE_LOAD_CALL]*/
   
                 
            /*
             *  Just to make sure, default the pageDisplay to 
             *  the Stats_home page.
             */
            default:
                $this->page = modulep2c_stats::PAGE_STATS_HOME;
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
    
                    case modulep2c_stats::PAGE_STATS_INPUTFILTER_FORM:
                   
                        $this->page = modulep2c_stats::PAGE_STATSINPUT; 
                        
                        /** Extract the ministry ID out of the jump-link URL value **/
                        $DEFAULT_INDEX = 0;
                        $INDEX_OF_MATCH = 0;
                        $INDEX_OF_MATCH_CHAR_INDEX = 1;
                        
                     	 $ministryURL = $_POST['ministry_id'];
								 $pattern = '/=[a-z]*[0-9]*/';	// search for '=<values>' in a sample key URL
								 preg_match_all($pattern, $ministryURL, $matches, PREG_OFFSET_CAPTURE);
// 									 echo '<pre>'.print_r($matches,true).'</pre>';								 
								 $last_match_index = count($matches[0]) - 1;
								 
// 								 echo '<br>matches = <pre>'.print_r($matches,true).'</pre><br>';								 
// 								 echo '<br>match index = '.$last_match_index;
								 
								 $ministry_id_from_url = 
								 substr($ministryURL,$matches[$DEFAULT_INDEX][$last_match_index][$INDEX_OF_MATCH_CHAR_INDEX]+1,strlen($ministryURL));
//  								 echo "<br>ministry id = ".$ministry_id_from_url;
                      
                        $this->MINISTRY_ID = $ministry_id_from_url;	//$_POST['ministry_id'];
                        
                        
                         /** Extract the division ID out of the jump-link URL value **/
                     	 $divisionURL = $_POST['division_id'];
								 preg_match_all($pattern, $divisionURL, $matches2, PREG_OFFSET_CAPTURE);
// 									 echo '<pre>'.print_r($matches2,true).'</pre>';								 
								 $last_match_index = count($matches2[0]) - 1;
								 
								 $division_id_from_url = 
								 substr($divisionURL,$matches2[$DEFAULT_INDEX][$last_match_index][$INDEX_OF_MATCH_CHAR_INDEX]+1,strlen($divisionURL));
//  								 echo "<br>division id = ".$division_id_from_url;                        
                        
                        $this->DIVISION_ID = $division_id_from_url;	//$_POST['division_id'];
                        
                        
                         /** Extract the region ID out of the jump-link URL value **/
                     	 $regionURL = $_POST['region_id'];
								 preg_match_all($pattern, $regionURL, $matches3, PREG_OFFSET_CAPTURE);
// 									 echo '<pre>'.print_r($matches3,true).'</pre>';								 
								 $last_match_index = count($matches3[0]) - 1;
								 
								 $region_id_from_url = 
								 substr($regionURL,$matches3[$DEFAULT_INDEX][$last_match_index][$INDEX_OF_MATCH_CHAR_INDEX]+1,strlen($regionURL));
								                         
                        $this->REGION_ID = $region_id_from_url;		//$_POST['region_id'];
                        $this->LOCATION_ID = $_POST['location_id'];
                        $this->FREQ_ID = $_POST['freq_id'];
                        $this->MEAS_ID = $_POST['meas_id'];
                                              
                        $this->loadStatsInput();       
                                     
                        break;                   

                    case modulep2c_stats::PAGE_STATSINPUT:
                        $this->page = modulep2c_stats::PAGE_STATS_HOME;
                        
                        $this->MINISTRY_ID = $_POST['ministry_id'];
                        $this->DIVISION_ID = $_POST['division_id'];
                        $this->REGION_ID = $_POST['region_id'];
                        $this->LOCATION_ID = $_POST['location_id'];
                        $this->FREQ_ID = $_POST['freq_id'];
                        $this->MEAS_ID = $_POST['meas_id'];
                        
//                         echo "POST array: <pre>".print_r($_POST,true)."</pre>";
                                              
                        $this->loadStatsHome();       
                                     
                        break;    
                        
                     case modulep2c_stats::PAGE_STATS_REPORTFILTER_FORM:
                        $this->page = modulep2c_stats::PAGE_STATS_REPORTSELECTION_FORM; 
                        
                        /** Extract the ministry ID out of the jump-link URL value **  Identical to PAGE_STATS_INPUTFILTER_FORM **/
                        $DEFAULT_INDEX = 0;
                        $INDEX_OF_MATCH = 0;
                        $INDEX_OF_MATCH_CHAR_INDEX = 1;
                        
                     	 $ministryURL = $_POST['ministry_id'];
								 $pattern = '/=[a-z]*[0-9]*/';	// search for '=<values>' in a sample key URL
								 preg_match_all($pattern, $ministryURL, $matches, PREG_OFFSET_CAPTURE);
// 									 echo '<pre>'.print_r($matches,true).'</pre>';								 
								 $last_match_index = count($matches[0]) - 1;
								 
// 								 echo '<br>matches = <pre>'.print_r($matches,true).'</pre><br>';								 
// 								 echo '<br>match index = '.$last_match_index;
								 
								 $ministry_id_from_url = 
								 substr($ministryURL,$matches[$DEFAULT_INDEX][$last_match_index][$INDEX_OF_MATCH_CHAR_INDEX]+1,strlen($ministryURL));
//  								 echo "<br>ministry id = ".$ministry_id_from_url;
                      
                        $this->MINISTRY_ID = $ministry_id_from_url;	//$_POST['ministry_id'];
                        
                        
                         /** Extract the division ID out of the jump-link URL value **/
                     	 $divisionURL = $_POST['division_id'];
								 preg_match_all($pattern, $divisionURL, $matches2, PREG_OFFSET_CAPTURE);
// 									 echo '<pre>'.print_r($matches2,true).'</pre>';								 
								 $last_match_index = count($matches2[0]) - 1;
								 
								 $division_id_from_url = 
								 substr($divisionURL,$matches2[$DEFAULT_INDEX][$last_match_index][$INDEX_OF_MATCH_CHAR_INDEX]+1,strlen($divisionURL));
//  								 echo "<br>division id = ".$division_id_from_url;                        
                        
                        $this->DIVISION_ID = $division_id_from_url;	//$_POST['division_id'];
                        
                        
                         /** Extract the region ID out of the jump-link URL value **/
                     	 $regionURL = $_POST['region_id'];
								 preg_match_all($pattern, $regionURL, $matches3, PREG_OFFSET_CAPTURE);
// 									 echo '<pre>'.print_r($matches3,true).'</pre>';								 
								 $last_match_index = count($matches3[0]) - 1;
								 
								 $region_id_from_url = 
								 substr($regionURL,$matches3[$DEFAULT_INDEX][$last_match_index][$INDEX_OF_MATCH_CHAR_INDEX]+1,strlen($regionURL));
								                         
                        $this->REGION_ID = $region_id_from_url;		//$_POST['region_id'];
                        $this->LOCATION_ID = $_POST['location_id'];
                        $this->FREQ_ID = $_POST['freq_id'];
                        $this->MEAS_ID = $_POST['meas_id'];
                        
                        /** <END>   Identical to PAGE_STATS_INPUTFILTER_FORM  **/
                                              
                        $this->loadStatsReportSelectionForm();       
                                     
                        break;                   

                    case modulep2c_stats::PAGE_STATS_REPORTSELECTION_FORM:
                        $this->page = modulep2c_stats::PAGE_STATS_REPORT;                        
                        
//                          echo "POST array: <pre>".print_r($_POST,true)."</pre>";
                                              
                        $this->loadStatsReport(false, $_POST['freqvalue_id'], $_POST['freqvalue_id_2'], $_POST['statistic_id'], $_POST['filter_id']);
                                     
                        break;                                               


                    case modulep2c_stats::PAGE_EDITMINISTRY:
                        // NOTE: after a successful submit on an AdminBox style
                        // form, set the managerInit variable back to ''
                        $this->MINISTRY_ID = '';
                        $this->loadEditMinistry( true );                     
                        break;

                    case modulep2c_stats::PAGE_EDITDIVISION:
                        // NOTE: after a successful submit on an AdminBox style
                        // form, set the managerInit variable back to ''
                        $this->DIVISION_ID = '';
								$this->MINISTRY_ID = '';
                        $this->loadEditDivision( true );                     
                        break;

                    case modulep2c_stats::PAGE_EDITREGION:
                        // NOTE: after a successful submit on an AdminBox style
                        // form, set the managerInit variable back to ''
                        $this->REGION_ID = '';
                        $this->loadEditRegion( true );                     
                        break;

                    case modulep2c_stats::PAGE_EDITLOCATION:
                        // NOTE: after a successful submit on an AdminBox style
                        // form, set the managerInit variable back to ''
                        $this->LOCATION_ID = '';
                        $this->loadEditLocation( true );                     
                        break;

                    case modulep2c_stats::PAGE_EDITSTATISTIC:
                        // NOTE: after a successful submit on an AdminBox style
                        // form, set the managerInit variable back to ''
                        $this->STAT_ID = '';
                        $this->SCOPE_ID = '';
                        $this->FREQ_ID = '';
                        $this->MEAS_ID = '';                      

                        $this->loadEditStatistic( );                     
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
        
        
//         $this->pageCommonDisplay->setEventID($this->EVENT_ID);

        // wrap current page's html in the common html of the module
        $content = $this->pageCommonDisplay->getHTML( $content );      

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
//             case modulep2c_stats::PAGE_DEFAULT:
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
	 * 'FREQVALUE_ID' [INTEGER] The Desired FREQVALUE_ID of this Link.
	 * 'FILTER_ID' [INTEGER] The Desired FILTER_ID of this Link.
	 * 'SCOPE_REF_ID' [INTEGER] The Desired SCOPE_REF_ID of this Link.
	 * 'STATTYPE_ID' [INTEGER] The Desired STATTYPE_ID of this Link.
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
            $callBack = modulep2c_stats::PAGE.'='.$page;
        }
        
        if ($sortBy != '') {
            if ($callBack != '') {
                $callBack .= '&';
            }
            $callBack .= modulep2c_stats::SORTBY.'='.$sortBy;
        }
        
        
        if ( isset( $parameters['STAT_ID']) ) {
            if ( $parameters['STAT_ID'] != '' ) {
                if ($callBack != '') {
                    $callBack .= '&';
                }
                $callBack .= modulep2c_stats::STAT_ID.'='.$parameters['STAT_ID'];
            }
        }

        if ( isset( $parameters['SCOPE_ID']) ) {
            if ( $parameters['SCOPE_ID'] != '' ) {
                if ($callBack != '') {
                    $callBack .= '&';
                }
                $callBack .= modulep2c_stats::SCOPE_ID.'='.$parameters['SCOPE_ID'];
            }
        }

        if ( isset( $parameters['MINISTRY_ID']) ) {
            if ( $parameters['MINISTRY_ID'] != '' ) {
                if ($callBack != '') {
                    $callBack .= '&';
                }
                $callBack .= modulep2c_stats::MINISTRY_ID.'='.$parameters['MINISTRY_ID'];
            }
        }

        if ( isset( $parameters['DIVISION_ID']) ) {
            if ( $parameters['DIVISION_ID'] != '' ) {
                if ($callBack != '') {
                    $callBack .= '&';
                }
                $callBack .= modulep2c_stats::DIVISION_ID.'='.$parameters['DIVISION_ID'];
            }
        }

        if ( isset( $parameters['REGION_ID']) ) {
            if ( $parameters['REGION_ID'] != '' ) {
                if ($callBack != '') {
                    $callBack .= '&';
                }
                $callBack .= modulep2c_stats::REGION_ID.'='.$parameters['REGION_ID'];
            }
        }

        if ( isset( $parameters['LOCATION_ID']) ) {
            if ( $parameters['LOCATION_ID'] != '' ) {
                if ($callBack != '') {
                    $callBack .= '&';
                }
                $callBack .= modulep2c_stats::LOCATION_ID.'='.$parameters['LOCATION_ID'];
            }
        }

        if ( isset( $parameters['VIEWER_ID']) ) {
            if ( $parameters['VIEWER_ID'] != '' ) {
                if ($callBack != '') {
                    $callBack .= '&';
                }
                $callBack .= modulep2c_stats::VIEWER_ID.'='.$parameters['VIEWER_ID'];
            }
        }


        if ( isset( $parameters['PERSON_ID']) ) {
            if ( $parameters['PERSON_ID'] != '' ) {
                if ($callBack != '') {
                    $callBack .= '&';
                }
                $callBack .= modulep2c_stats::PERSON_ID.'='.$parameters['PERSON_ID'];
            }
        }
        
        if ( isset( $parameters['FREQ_ID']) ) {
            if ( $parameters['FREQ_ID'] != '' ) {
                if ($callBack != '') {
                    $callBack .= '&';
                }
                $callBack .= modulep2c_stats::FREQ_ID.'='.$parameters['FREQ_ID'];
            }
        }
        
        if ( isset( $parameters['MEAS_ID']) ) {
            if ( $parameters['MEAS_ID'] != '' ) {
                if ($callBack != '') {
                    $callBack .= '&';
                }
                $callBack .= modulep2c_stats::MEAS_ID.'='.$parameters['MEAS_ID'];
            }
        }                

        
        if ( isset( $parameters['FREQVALUE_ID']) ) {
            if ( $parameters['FREQVALUE_ID'] != '' ) {
                if ($callBack != '') {
                    $callBack .= '&';
                }
                $callBack .= modulep2c_stats::FREQVALUE_ID.'='.$parameters['FREQVALUE_ID'];
            }
        }

        if ( isset( $parameters['FILTER_ID']) ) {
            if ( $parameters['FILTER_ID'] != '' ) {
                if ($callBack != '') {
                    $callBack .= '&';
                }
                $callBack .= modulep2c_stats::FILTER_ID.'='.$parameters['FILTER_ID'];
            }
        }

        if ( isset( $parameters['SCOPE_REF_ID']) ) {
            if ( $parameters['SCOPE_REF_ID'] != '' ) {
                if ($callBack != '') {
                    $callBack .= '&';
                }
                $callBack .= modulep2c_stats::SCOPE_REF_ID.'='.$parameters['SCOPE_REF_ID'];
            }
        }

        if ( isset( $parameters['STATTYPE_ID']) ) {
            if ( $parameters['STATTYPE_ID'] != '' ) {
                if ($callBack != '') {
                    $callBack .= '&';
                }
                $callBack .= modulep2c_stats::STATTYPE_ID.'='.$parameters['STATTYPE_ID'];
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
        return modulep2c_stats::MULTILINGUAL_SERIES_KEY;
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
//         $pageCallBack = $this->getCallBack(modulep2c_stats::PAGE_ADMINHOME, $this->sortBy, $parameters);
//         $this->setPageCallBack( $pageCallBack );
        
      
        		$this->pageDisplay = new page_NotAuthorized( $this->moduleRootPath, $this->viewer);    	        
	
// 	        $this->pageDisplay->setLinks( $links ); 
        
    } // end loadNotAuthorized()
    


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
        $parameters = array('PERSON_ID'=>$this->PERSON_ID);//[RAD_CALLBACK_PARAMS]
        $pageCallBack = $this->getCallBack(modulep2c_stats::PAGE_STATS_HOME, $this->sortBy, $parameters);
        $this->setPageCallBack( $pageCallBack );
        
        
        $this->pageDisplay = new page_GenericStatsHome( $this->moduleRootPath, $this->viewer );     

        $parameters = array();
        $viewerID = $this->viewer->getViewerID();
        // TODO make an object to do this work
//         $sql = "select * from ( ( cim_hrdb_access inner join cim_hrdb_person on cim_hrdb_access.person_id=cim_hrdb_person.person_id) inner join cim_hrdb_staff on cim_hrdb_staff.person_id=cim_hrdb_person.person_id ) where cim_hrdb_access.viewer_id = ".$viewerID." limit 1";

//         $db = new Database_Site();
//         $db->connectToDB( SITE_DB_NAME, SITE_DB_PATH, SITE_DB_USER, SITE_DB_PWORD );

//         $db->runSQL($sql);
//         // if row retrieved ...
//         $staffID = -1;
//         if ($row = $db->retrieveRow() )
//         {
//             $staffID = $row['staff_id'];
//         }
//         $parameters['STAFF_ID'] = $staffID;

//         // echo print_r($parameters,true);
//         
//         $permManager = new PermissionManager( $viewerID );
//   
//         $isNational = $permManager->isNational();
//         
//         // echo 'isNational['.$isNational.']<br/>';
//         $isRegional = $permManager->isRegional();
//         // echo 'isRegional['.$isRegional.']<br/>';
//         $isCD = $permManager->isCD();
//         // echo 'isCD['.$isCD.']<br/>';
//         $isStatsCoordinator = $permManager->isStatsCoordinator();
//         // echo 'isStatsCoordinator['.$isStatsCoordinator.']<br/>';
//         $isAllStaff = $permManager->isAllStaff();
//         // echo 'isAllStaff['.$isAllStaff.']<br/>';

        $links = array();
//         if ( $isAllStaff )
//         {
            // GROUP 1: ALL STAFF
            // All staff can access this link
            $requestLink = $this->getCallBack( modulep2c_stats::PAGE_STATS_INPUTFILTER_FORM, '' , $parameters);
            $links[ '[submitStats]' ] = $requestLink;
            
            $requestLink = $this->getCallBack( modulep2c_stats::PAGE_STATS_REPORTFILTER_FORM, '' , $parameters);
            $links[ '[generateReports]' ] = $requestLink;
            
//             $requestLink = $this->getCallBack( modulep2c_stats::PAGE_STAFFADDITIONALWEEKLYSTATS, '' , $parameters);
//             $links[ '[submitMoreWeeklyStats]' ] = $requestLink;
//             $requestLink = $this->getCallBack( modulep2c_stats::PAGE_SELECTPRCSEMESTERCAMPUS, '' , $parameters);
//             $links[ '[indicatedDecisions]' ] = $requestLink;
//             $requestLink = $this->getCallBack( modulep2c_stats::PAGE_STAFFSEMESTERREPORT, '' , $parameters);
//             $links[ '[semesterGlance]' ] = $requestLink;
//             $requestLink = $this->getCallBack( modulep2c_stats::PAGE_CAMPUSYEARSUMMARY, '' , $parameters);
//             $links[ '[yearSummary]' ] = $requestLink;
            
            
//         }
        
        $coordinatorLinks = array();
//         if ( $isStatsCoordinator || $isAllStaff )
//         {
//             // GROUP 2: CAMPUS STATS COORDINATORS
//             $requestLink = $this->getCallBack( modulep2c_stats::PAGE_MORESTATS, '' , $parameters);
//             $coordinatorLinks[ '[campusWeeklyStats]' ] = $requestLink;
//             
//             $requestLink = $this->getCallBack( modulep2c_stats::PAGE_CAMPUSWEEKLYSTATSREPORT, '' , $parameters);
//             $coordinatorLinks[ '[campusWeeklyStatsReport]' ] = $requestLink;
//             
//             $requestLink = $this->getCallBack( modulep2c_stats::PAGE_SEMESTERREPORT, '' , $parameters);
//             $coordinatorLinks[ '[submitSemesterStats]' ] = $requestLink;
//         }
//         
        $cdLinks = array();
//         if ( $isCD )
//         {
//             // GROUP 3: CAMPUS DIRECTORS
//             $requestLink = $this->getCallBack( modulep2c_stats::PAGE_STAFFSEMESTERREPORT, '' , $parameters);
//             $cdLinks[ '[semesterGlance]' ] = $requestLink;
//         }
//         
        $rtLinks = array();
//         if ( $isRegional )                
//         {
//             // GROUP 4: REGIONAL TEAM
//             $requestLink = $this->getCallBack( modulep2c_stats::PAGE_REGIONALSEMESTERREPORT, '' , $parameters);
//             $rtLinks[ '[regionalPersonalMin]' ] = $requestLink;
//         }        
//         
        $ntLinks = array();
        
         $requestLink = $this->getCallBack( modulep2c_stats::PAGE_EDITMINISTRY, '' , $parameters);
         $ntLinks[ '[editMinistry]' ] = $requestLink;
         
         $requestLink = $this->getCallBack( modulep2c_stats::PAGE_EDITDIVISION, '' , $parameters);
         $ntLinks[ '[editDivision]' ] = $requestLink;
         
         $requestLink = $this->getCallBack( modulep2c_stats::PAGE_EDITREGION, '' , $parameters);
         $ntLinks[ '[editRegion]' ] = $requestLink;
         
          $requestLink = $this->getCallBack( modulep2c_stats::PAGE_EDITLOCATION, '' , $parameters);
         $ntLinks[ '[editLocation]' ] = $requestLink;
         
         $requestLink = $this->getCallBack( modulep2c_stats::PAGE_EDITSTATISTIC, '' , $parameters);
         $ntLinks[ '[editStatistic]' ] = $requestLink;
                          
//         if ( $isNational )
//         {
//             // GROUP 5: NATIONAL TEAM
//             // echo 'Is NATIONAL<br/>';
//             
//             // Add these two links later in special admin section
//             $requestLink = $this->getCallBack( modulep2c_stats::PAGE_PRCMETHOD, '' , $parameters);
//             // $ntLinks[ '[prcMethod]' ] = $requestLink;
//             $requestLink = $this->getCallBack( modulep2c_stats::PAGE_EXPOSURETYPES, '' , $parameters);
//             // $ntLinks[ '[exposureTypes]' ] = $requestLink;
//             
//             $requestLink = $this->getCallBack( modulep2c_stats::PAGE_PRC_REPORTBYCAMPUS, '' , $parameters);
//             $ntLinks[ '[prcReportByCampus]' ] = $requestLink;
//             
//         }

        
/*[RAD_LINK_INSERT]*/

        $this->pageDisplay->setMyLinks( $links, $coordinatorLinks, $cdLinks, $rtLinks, $ntLinks ); 
//         $this->pageDisplay->setPerms( $isNational, $isRegional, $isCD, $isStatsCoordinator, $isAllStaff );    
        
    } // end loadStatsHome()    

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
//     protected function getCampusIDfromViewerID()
//     {
// 	    $campusAssign = new RowManager_AssignmentsManager();
//        $accessPriv = new RowManager_AccessManager();
//        $accessPriv->setViewerID($this->viewer->getID());
//        
//        $getCampusID = new MultiTableManager();
//        $getCampusID->addRowManager($campusAssign);
//        $getCampusID->addRowManager($accessPriv, new JoinPair( $campusAssign->getJoinOnPersonID(), $accessPriv->getJoinOnPersonID()));
//        
//        $accessPrivList = $getCampusID->getListIterator();
//        $accessPrivArray = $accessPrivList->getDataList();
//        
//        $personID = '';
//        $campusID = '';
//        reset($accessPrivArray);
//        foreach (array_keys($accessPrivArray) as $k)
//        {
//        	$record = current($accessPrivArray);
//        	$campusID = $record['campus_id'];	// NOTE: there may be more than 1 but system will just use last one...
//        	next($accessPrivArray);
//     	 }
//        
//        return $campusID;
//     }    



 
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
// 	    $regStatus = RowManager_RegistrationManager::STATUS_INCOMPLETE;
// 	    
// 	    // get privileges for the current viewer
//         $privManager = new PrivilegeManager( $this->viewer->getID() ); 	// students allowed to see sidebar for sign-up process 
//         if (($this->IS_IN_REG_PROCESS == modulep2c_stats::IS_SIGNUP)||($privManager->isCampusAdmin($this->EVENT_ID, $this->CAMPUS_ID)==true))	// check if privilege level is high enough
//         {		     

// 	//         $parameters['PERSON_ID'] = $personID;
// 	
// 				// find registration ID using person id and event_id
// 				//if ((!isset($this->REG_ID))||$this->REG_ID='')
// 				//{
// 					
// 					if ((isset($this->PERSON_ID))&&($this->PERSON_ID != '')&&((isset($this->EVENT_ID))&&($this->EVENT_ID != '')))
// 					{
// 						
// 			        // get registration ID for the rest of the reg. process
// 			        $regs = new RowManager_RegistrationManager();
// 			        $people = new RowManager_PersonManager();
// 			        $people->setPersonID($this->PERSON_ID);
// 			        $events = new RowManager_EventManager();
// 			        $events->setEventID($this->EVENT_ID);
// 			        
// 			        $personRegs = new MultiTableManager();
// 			        $personRegs->addRowManager($regs);
// 			        $personRegs->addRowManager($people, new JoinPair( $regs->getJoinOnPersonID(), $people->getJoinOnPersonID()));
// 			        $personRegs->addRowManager($events, new JoinPair( $regs->getJoinOnEventID(), $events->getJoinOnEventID()));
// 			        
// 			        $regsList = $personRegs->getListIterator( );
// 			        $regsArray = $regsList->getDataList();		
// 	// 		        echo "<pre>".print_r($regsArray,true)."</pre>"; 
// 			          			
// 			         reset($regsArray);
// 			        	foreach(array_keys($regsArray) as $k)
// 						{
// 							$registration = current($regsArray);	
// 							$this->REG_ID = $registration['registration_id'];	// NOTE: should only be one reg. per person per event (ENFORCE??)	
// 							$regStatus = $registration['registration_status'];
// 							
// 							next($regsArray);	
// 						}		
// 					}
// 				//}	
// 				
// 			 $regCompleted = false;
// 			 if ($regStatus == RowManager_RegistrationManager::STATUS_REGISTERED)
// 			 {
// 				$regCompleted = true;
// 			 }
// 	       $this->sideBar = new obj_RegProcessSideBar( $this->moduleRootPath, $this->viewer, $regCompleted);	//, $isNewRegistrant );   	
// 		
// 	        
// 	        $links = array();
// 	//         $adminLinks = array();
// 	//         $campusLevelLinks = array();
// 	
// 	        $parameters = array();					
// 	        $parameters = array('IS_IN_REG_PROCESS'=>$this->IS_IN_REG_PROCESS, 'EVENT_ID'=>$this->EVENT_ID, 'REG_ID'=>$this->REG_ID, 'PERSON_ID'=>$this->PERSON_ID,  'CAMPUS_ID'=>$this->CAMPUS_ID, 'PRIV_ID'=>$this->PRIV_ID);//[RAD_CALLBACK_PARAMS]
// 				// 'PROVINCE_ID'=>$this->PROVINCE_ID, 'GENDER_ID'=>$this->GENDER_ID, 'STAFF_ID'=>$this->STAFF_ID, 'USER_ID'=>$this->USER_ID, 'ASSIGNMENT_ID'=>$this->ASSIGNMENT_ID, 'ADMIN_ID'=>$this->ADMIN_ID, 'CAMPUSADMIN_ID'=>$this->CAMPUSADMIN_ID
// 	
// 	        // echo print_r($parameters,true);
// 	
// 	        // GROUP 1: EVERYONE.
// 	        // ALL viewers can access these links
// 		     if (($regStatus == RowManager_RegistrationManager::STATUS_REGISTERED)&&($this->IS_IN_REG_PROCESS==modulep2c_stats::IS_SIGNUP))
// 		     {
// 		        $requestLink = $this->getCallBack(modulep2c_stats::PAGE_CONFIRMCANCELREGISTRATION, '', $parameters );
// 		        $links[ '[RegCancel]' ] = $requestLink;		
// 	        }	        	        
// 	        
// 	        $requestLink = $this->getCallBack( modulep2c_stats::PAGE_EDITPERSONALINFO, '' , $parameters);
// 	        $links[ '[editMyInfo]' ] = $requestLink;
// 	        
// 	 	     // need to know if registration process requires new registrant personal info
// 		     // since this means side-bar cannot have future registration step links yet
// 		     if ((isset($this->PERSON_ID))&&($this->PERSON_ID == -1))
// 		     {
// 					// show only first link
// 		     }
// 		     else 	// show all registration process links
// 		     {		     			     
// 		        $requestLink = $this->getCallBack( modulep2c_stats::PAGE_EDITCAMPUSASSIGNMENT, '' , $parameters);
// 		        $links[ '[editCampusInfo]' ] = $requestLink;
// 		        
// 		        $requestLink = $this->getCallBack( modulep2c_stats::PAGE_EDITFIELDVALUES, '' , $parameters);
// 		        $links[ '[editFieldValues]' ] = $requestLink;   
// 		        
// 		        $requestLink = $this->getCallBack( modulep2c_stats::PAGE_PROCESSFINANCIALTRANSACTIONS, '' , $parameters);
// 		        $links[ '[processFinances]' ] = $requestLink;  
// 	     		}	         
// 	       
// 	        if ($this->IS_IN_REG_PROCESS == modulep2c_stats::IS_SIGNUP)
// 	        {
// 		        $requestLink = $this->getCallBack( modulep2c_stats::PAGE_REG_HOME, '' , $parameters);
// 		        $links[ '[backToEventList]' ] = $requestLink; 
// 	        }
// 	        else if ($this->IS_IN_REG_PROCESS == modulep2c_stats::IS_OFFLINE_REG)
// 	        {
// 		        $requestLink = $this->getCallBack( modulep2c_stats::PAGE_EDITCAMPUSREGISTRATIONS, '' , $parameters);
// 		        $links[ '[backToRegList]' ] = $requestLink;                 
// 	        }	                              
// 	
// 	//         // GROUP 2: CAMPUS ADMINS AND ABOVE ONLY.
// 	//         if ( ( $this->accessPrivManager->hasSitePriv() ) || ( $this->accessPrivManager->hasCampusPriv() ) ){
// 	//           //$requestLink = $this->getCallBack( modulecim_hrdb::PAGE_PEOPLE );
// 	//           //$campusLevelLinks[ '[PeopleList]' ] = $requestLink;
// 	//           // TODO if you have 'hrdb campus' group access rights you can see these
// 	//           $requestLink = $this->getCallBack( modulecim_hrdb::PAGE_PEOPLEBYCAMPUSES );
// 	//           $campusLevelLinks[ '[PeopleByCampuses]' ] = $requestLink;
// 	//         }
// 	
// 	//         // GROUP 3: SUPER ADMINS ONLY.
// 	//         if ( $this->accessPrivManager->hasSitePriv()){
// 	//           $requestLink = $this->getCallBack( modulecim_hrdb::PAGE_CAMPUSES );
// 	//           $adminLinks[ '[editCampuses]' ] = $requestLink;
// 	
// 	//           $requestLink = $this->getCallBack( modulecim_hrdb::PAGE_PROVINCES );
// 	//           $adminLinks[ '[editProvinces]' ] = $requestLink;
// 	
// 	//           $requestLink = $this->getCallBack( modulecim_hrdb::PAGE_PRIVILEGES );
// 	//           $adminLinks[ '[editPrivileges]' ] = $requestLink;
// 	
// 	//           $requestLink = $this->getCallBack( modulecim_hrdb::PAGE_STAFF );
// 	//           $adminLinks[ '[Staff]' ] = $requestLink;
// 	
// 	//           $requestLink = $this->getCallBack( modulecim_hrdb::PAGE_ADMINS );
// 	//           $adminLinks[ '[Admins]' ] = $requestLink;
// 	//           
// 	//           $requestLink = $this->getCallBack( modulecim_hrdb::PAGE_EDITCAMPUSASSIGNMENT );
// 	//           $adminLinks[ '[CampusAssignments]' ] = $requestLink;   
// 	
// 	//           $requestLink = $this->getCallBack( modulecim_hrdb::PAGE_EDITCAMPUSASSIGNMENTSTATUSTYPES );
// 	//           $adminLinks[ '[AssignStatusTypes]' ] = $requestLink;          
// 	//           
// 	//         }
// 	
// 	        // pass the links to the sidebar object
// 	        $this->sideBar->setLinks( $links );
// 	//         $this->sideBar->setAdminLinks( $adminLinks );
// 	//         $this->sideBar->setCampusLevelLinks( $campusLevelLinks );
// 		}

    } // end loadSideBar()
    
           
    
   //************************************************************************
	/**
	 * function loadStatsInputFilterForm
	 * <pre>
	 * Initializes the loadStatsInputFilterForm Page.
	 * </pre>
	 * @param $isCreated [BOOL] "Is THIS pageDisplay object already created?"
	 * @return [void]
	 */
    // RAD Tools: DataSingle Style
    function loadStatsInputFilterForm($isCreated=false)
    {

	    // get privileges for the current viewer
//         $privManager = new PrivilegeManager( $this->viewer->getID() );  
//         if ($privManager->isCampusAdmin($this->EVENT_ID, $this->CAMPUS_ID)==true)	// check if privilege level is high enough
//         {	
	        
	        // set the pageCallBack to be without any additional parameters
	        // (an AdminBox needs this so Language Switching on a page doesn't
	        // pass a previous operations)
	        $parameters = array('PERSON_ID'=>$this->PERSON_ID, 'SCOPE_ID'=>$this->SCOPE_ID, 'LOCATION_ID'=>$this->LOCATION_ID, 'REGION_ID'=>$this->REGION_ID, 'DIVISION_ID'=>$this->DIVISION_ID, 'MINISTRY_ID'=>$this->MINISTRY_ID, 'FREQ_ID'=>$this->FREQ_ID, 'MEAS_ID'=>$this->MEAS_ID);//[RAD_CALLBACK_PARAMS]
				// 'PROVINCE_ID'=>$this->PROVINCE_ID, 'GENDER_ID'=>$this->GENDER_ID, 'STAFF_ID'=>$this->STAFF_ID, 'USER_ID'=>$this->USER_ID, 'ASSIGNMENT_ID'=>$this->ASSIGNMENT_ID, 'ADMIN_ID'=>$this->ADMIN_ID, 'CAMPUSADMIN_ID'=>$this->CAMPUSADMIN_ID
	        $pageCallBack = $this->getCallBack(modulep2c_stats::PAGE_STATS_INPUTFILTER_FORM, $this->sortBy, $parameters);
	        $this->setPageCallBack( $pageCallBack );
	        
	        $formTo_page = '';
		     $formTo_page = modulep2c_stats::PAGE_STATS_INPUTFILTER_FORM;

	        // NOTE: making use of previous_page variable to return to a dynamic page
	        $formAction = $this->getCallBack($formTo_page, $this->sortBy, $parameters );
	        
	        
	        $this->pageDisplay = new FormProcessor_StatsInputFilter( $this->moduleRootPath, $this->viewer, $formAction, $this->PERSON_ID, $this->MINISTRY_ID, $this->DIVISION_ID, $this->REGION_ID);
	        
	        $links = array();
	
	//         $parameters = array('CAMPUS_ID'=>$this->CAMPUS_ID, 'STAFF_ID'=>$this->STAFF_ID);
	
			  $parameters = array('PERSON_ID'=>$this->PERSON_ID, 'MINISTRY_ID'=>$this->MINISTRY_ID);
	        $ministryJumpLink = $this->getCallBack( modulep2c_stats::PAGE_STATS_INPUTFILTER_FORM, $this->sortBy, $parameters);
	        $ministryJumpLink .= "&". modulep2c_stats::MINISTRY_ID . "=";
	        $links['ministryJumpLink'] = $ministryJumpLink;
	        
	        $parameters = array('PERSON_ID'=>$this->PERSON_ID, 'MINISTRY_ID'=>$this->MINISTRY_ID, 'DIVISION_ID'=>$this->DIVISION_ID);
	        $divisionJumpLink = $this->getCallBack( modulep2c_stats::PAGE_STATS_INPUTFILTER_FORM, $this->sortBy, $parameters);
	        $divisionJumpLink .= "&". modulep2c_stats::DIVISION_ID . "=";
	        $links['divisionJumpLink'] = $divisionJumpLink;	   
	        
	        $parameters = array('PERSON_ID'=>$this->PERSON_ID, 'MINISTRY_ID'=>$this->MINISTRY_ID, 'DIVISION_ID'=>$this->DIVISION_ID, 'REGION_ID'=>$this->REGION_ID);
	        $regionJumpLink = $this->getCallBack( modulep2c_stats::PAGE_STATS_INPUTFILTER_FORM, $this->sortBy, $parameters);
	        $regionJumpLink .= "&". modulep2c_stats::REGION_ID . "=";
	        $links['regionJumpLink'] = $regionJumpLink;	       
	
	        $this->pageDisplay->setLinks( $links );
	        
	        $this->addScript('MM_jumpMenu.jsp');    
//         }
//         else
//         {
// 	        $this->pageDisplay = new page_NotAuthorized($this->moduleRootPath, $this->viewer);  
//         }  
    } // end loadStatsInputFilterForm()
    
    

   //************************************************************************
	/**
	 * function loadStatsInput
	 * <pre>
	 * Initializes the loadStatsInput Page.
	 * </pre>
	 * @param $isCreated [BOOL] "Is THIS pageDisplay object already created?"
	 * @return [void]
	 */
    // RAD Tools: DataSingle Style
    function loadStatsInput($isCreated=false)
    {

	    // get privileges for the current viewer
//         $privManager = new PrivilegeManager( $this->viewer->getID() );  
//         if ($privManager->isCampusAdmin($this->EVENT_ID, $this->CAMPUS_ID)==true)	// check if privilege level is high enough
//         {	
	        
	        // set the pageCallBack to be without any additional parameters
	        // (an AdminBox needs this so Language Switching on a page doesn't
	        // pass a previous operations)
	        $parameters = array('PERSON_ID'=>$this->PERSON_ID, 'SCOPE_ID'=>$this->SCOPE_ID, 'LOCATION_ID'=>$this->LOCATION_ID, 'REGION_ID'=>$this->REGION_ID, 'DIVISION_ID'=>$this->DIVISION_ID, 'MINISTRY_ID'=>$this->MINISTRY_ID, 'FREQ_ID'=>$this->FREQ_ID, 'MEAS_ID'=>$this->MEAS_ID);//[RAD_CALLBACK_PARAMS]
				// 'PROVINCE_ID'=>$this->PROVINCE_ID, 'GENDER_ID'=>$this->GENDER_ID, 'STAFF_ID'=>$this->STAFF_ID, 'USER_ID'=>$this->USER_ID, 'ASSIGNMENT_ID'=>$this->ASSIGNMENT_ID, 'ADMIN_ID'=>$this->ADMIN_ID, 'CAMPUSADMIN_ID'=>$this->CAMPUSADMIN_ID
	        $pageCallBack = $this->getCallBack(modulep2c_stats::PAGE_STATSINPUT, $this->sortBy, $parameters);
	        $this->setPageCallBack( $pageCallBack );
	        
	        $formTo_page = '';
		     $formTo_page = modulep2c_stats::PAGE_STATSINPUT;

	        // NOTE: making use of previous_page variable to return to a dynamic page
	        $formAction = $this->getCallBack($formTo_page, $this->sortBy, $parameters );
	        
	        // Create a list of scope_ids indexing scope_ref_ids (i.e. ministry_ids, division_ids, etc)
	        // the stored ids will be used to retrieve associated statistics to generate input fields
	        $scopeRefArray = array();
	        $scopeRefArray[modulep2c_stats::SCOPE_REF_MINISTRY] = $this->MINISTRY_ID;	        
	        $scopeRefArray[modulep2c_stats::SCOPE_REF_DIVISION] = $this->DIVISION_ID;
	        $scopeRefArray[modulep2c_stats::SCOPE_REF_REGION] = $this->REGION_ID;
		     $scopeRefArray[modulep2c_stats::SCOPE_REF_LOCATION] = $this->LOCATION_ID;
		     
// 		     echo "scope refs = <pre>".print_r($scopeRefArray,true)."</pre>";
// 		     echo "<br>FREQ_ID = ".$this->FREQ_ID;
// 		     echo "<br>MEAS_ID = ".$this->MEAS_ID;
      
				// TODO: create scope_ref_list array of scope_ids with their associated scope_id
	        $this->pageDisplay = new FormProcessor_StatsInput( $this->moduleRootPath, $this->viewer, $formAction, $this->PERSON_ID, $this->STATVALUES_ID, $this->STAT_ID, $this->FREQ_ID, $this->MEAS_ID, $scopeRefArray );
	        
       
			//$this->previous_page = modulep2c_stats::PAGE_EDITPERSONALINFO;    
//         }
//         else
//         {
// 	        $this->pageDisplay = new page_NotAuthorized($this->moduleRootPath, $this->viewer);  
//         }  
    } // end loadStatsInput()   
    
    
   //************************************************************************
	/**
	 * function loadStatsReportFilterForm
	 * <pre>
	 * Initializes the StatsReportFilterForm Page.
	 * </pre>
	 * @param $isCreated [BOOL] "Is THIS pageDisplay object already created?"
	 * @return [void]
	 */
    // RAD Tools: DataSingle Style
    function loadStatsReportFilterForm($isCreated=false)
    {

	    // get privileges for the current viewer
//         $privManager = new PrivilegeManager( $this->viewer->getID() );  
//         if ($privManager->isCampusAdmin($this->EVENT_ID, $this->CAMPUS_ID)==true)	// check if privilege level is high enough
//         {	
	        
	        // set the pageCallBack to be without any additional parameters
	        // (an AdminBox needs this so Language Switching on a page doesn't
	        // pass a previous operations)
	        $parameters = array('PERSON_ID'=>$this->PERSON_ID, 'SCOPE_ID'=>$this->SCOPE_ID, 'LOCATION_ID'=>$this->LOCATION_ID, 'REGION_ID'=>$this->REGION_ID, 'DIVISION_ID'=>$this->DIVISION_ID, 'MINISTRY_ID'=>$this->MINISTRY_ID, 'FREQ_ID'=>$this->FREQ_ID, 'MEAS_ID'=>$this->MEAS_ID);//[RAD_CALLBACK_PARAMS]
				// 'PROVINCE_ID'=>$this->PROVINCE_ID, 'GENDER_ID'=>$this->GENDER_ID, 'STAFF_ID'=>$this->STAFF_ID, 'USER_ID'=>$this->USER_ID, 'ASSIGNMENT_ID'=>$this->ASSIGNMENT_ID, 'ADMIN_ID'=>$this->ADMIN_ID, 'CAMPUSADMIN_ID'=>$this->CAMPUSADMIN_ID
	        $pageCallBack = $this->getCallBack(modulep2c_stats::PAGE_STATS_REPORTFILTER_FORM, $this->sortBy, $parameters);
	        $this->setPageCallBack( $pageCallBack );
	        
	        $formTo_page = '';
		     $formTo_page = modulep2c_stats::PAGE_STATS_REPORTFILTER_FORM;

	        // NOTE: making use of previous_page variable to return to a dynamic page
	        $formAction = $this->getCallBack($formTo_page, $this->sortBy, $parameters );
	        
	        
	        $this->pageDisplay = new FormProcessor_StatsReportFilter( $this->moduleRootPath, $this->viewer, $formAction, $this->PERSON_ID, $this->MINISTRY_ID, $this->DIVISION_ID, $this->REGION_ID);
	        
	        $links = array();
	
	//         $parameters = array('CAMPUS_ID'=>$this->CAMPUS_ID, 'STAFF_ID'=>$this->STAFF_ID);
	
			  $parameters = array('PERSON_ID'=>$this->PERSON_ID, 'MINISTRY_ID'=>$this->MINISTRY_ID);
	        $ministryJumpLink = $this->getCallBack( modulep2c_stats::PAGE_STATS_REPORTFILTER_FORM, $this->sortBy, $parameters);
	        $ministryJumpLink .= "&". modulep2c_stats::MINISTRY_ID . "=";
	        $links['ministryJumpLink'] = $ministryJumpLink;
	        
	        $parameters = array('PERSON_ID'=>$this->PERSON_ID, 'MINISTRY_ID'=>$this->MINISTRY_ID, 'DIVISION_ID'=>$this->DIVISION_ID);
	        $divisionJumpLink = $this->getCallBack( modulep2c_stats::PAGE_STATS_REPORTFILTER_FORM, $this->sortBy, $parameters);
	        $divisionJumpLink .= "&". modulep2c_stats::DIVISION_ID . "=";
	        $links['divisionJumpLink'] = $divisionJumpLink;	   
	        
	        $parameters = array('PERSON_ID'=>$this->PERSON_ID, 'MINISTRY_ID'=>$this->MINISTRY_ID, 'DIVISION_ID'=>$this->DIVISION_ID, 'REGION_ID'=>$this->REGION_ID);
	        $regionJumpLink = $this->getCallBack( modulep2c_stats::PAGE_STATS_REPORTFILTER_FORM, $this->sortBy, $parameters);
	        $regionJumpLink .= "&". modulep2c_stats::REGION_ID . "=";
	        $links['regionJumpLink'] = $regionJumpLink;	       
	
	        $this->pageDisplay->setLinks( $links );
	        
	        $this->addScript('MM_jumpMenu.jsp');    
	         
//         }
//         else
//         {
// 	        $this->pageDisplay = new page_NotAuthorized($this->moduleRootPath, $this->viewer);  
//         }  
    } // end loadStatsReportFilterForm()     
    
    
    //************************************************************************
	/**
	 * function loadStatsReportSelectionForm
	 * <pre>
	 * Initializes the StatsReportSelectionForm Page.
	 * </pre>
	 * @param $isCreated [BOOL] "Is THIS pageDisplay object already created?"
	 * @return [void]
	 */
    // RAD Tools: DataSingle Style
    function loadStatsReportSelectionForm($isCreated=false)
    {

	    // get privileges for the current viewer
//         $privManager = new PrivilegeManager( $this->viewer->getID() );  
//         if ($privManager->isCampusAdmin($this->EVENT_ID, $this->CAMPUS_ID)==true)	// check if privilege level is high enough
//         {	
	        
	        // set the pageCallBack to be without any additional parameters
	        // (an AdminBox needs this so Language Switching on a page doesn't
	        // pass a previous operations)
	        $parameters = array('PERSON_ID'=>$this->PERSON_ID, 'SCOPE_ID'=>$this->SCOPE_ID, 'LOCATION_ID'=>$this->LOCATION_ID, 'REGION_ID'=>$this->REGION_ID, 'DIVISION_ID'=>$this->DIVISION_ID, 'MINISTRY_ID'=>$this->MINISTRY_ID, 'FREQ_ID'=>$this->FREQ_ID, 'MEAS_ID'=>$this->MEAS_ID);//[RAD_CALLBACK_PARAMS]
				// 'PROVINCE_ID'=>$this->PROVINCE_ID, 'GENDER_ID'=>$this->GENDER_ID, 'STAFF_ID'=>$this->STAFF_ID, 'USER_ID'=>$this->USER_ID, 'ASSIGNMENT_ID'=>$this->ASSIGNMENT_ID, 'ADMIN_ID'=>$this->ADMIN_ID, 'CAMPUSADMIN_ID'=>$this->CAMPUSADMIN_ID
	        $pageCallBack = $this->getCallBack(modulep2c_stats::PAGE_STATS_REPORTSELECTION_FORM, $this->sortBy, $parameters);
	        $this->setPageCallBack( $pageCallBack );
	        
	        $formTo_page = '';
		     $formTo_page = modulep2c_stats::PAGE_STATS_REPORTSELECTION_FORM;

	        // NOTE: making use of previous_page variable to return to a dynamic page
	        $formAction = $this->getCallBack($formTo_page, $this->sortBy, $parameters );
	        
	        // Create a list of scope_ids indexing scope_ref_ids (i.e. ministry_ids, division_ids, etc)
	        // the stored ids will be used to retrieve associated statistics to generate input fields
	        $scopeRefArray = array();
	        $scopeRefArray[modulep2c_stats::SCOPE_REF_MINISTRY] = $this->MINISTRY_ID;	        
	        $scopeRefArray[modulep2c_stats::SCOPE_REF_DIVISION] = $this->DIVISION_ID;
	        $scopeRefArray[modulep2c_stats::SCOPE_REF_REGION] = $this->REGION_ID;
		     $scopeRefArray[modulep2c_stats::SCOPE_REF_LOCATION] = $this->LOCATION_ID;
		     
// 		     echo "scope refs = <pre>".print_r($scopeRefArray,true)."</pre>";
// 		     echo "<br>FREQ_ID = ".$this->FREQ_ID;
// 		     echo "<br>MEAS_ID = ".$this->MEAS_ID;
      
				// TODO: create scope_ref_list array of scope_ids with their associated scope_id
	        $this->pageDisplay = new FormProcessor_StatsReportSelection( $this->moduleRootPath, $this->viewer, $formAction, $this->PERSON_ID, $this->STATVALUES_ID, $this->STAT_ID, $this->FREQ_ID, $this->MEAS_ID, $scopeRefArray );
	        
	/*
	        $links = array();
	
	        $parameters = array('PERSON_ID'=>$this->PERSON_ID, 'CAMPUS_ID'=>$this->CAMPUS_ID, 'PRIV_ID'=>$this->PRIV_ID);//[RAD_CALLBACK_PARAMS]
				// 'PROVINCE_ID'=>$this->PROVINCE_ID, 'GENDER_ID'=>$this->GENDER_ID, 'STAFF_ID'=>$this->STAFF_ID, 'USER_ID'=>$this->USER_ID, 'ASSIGNMENT_ID'=>$this->ASSIGNMENT_ID, 'ADMIN_ID'=>$this->ADMIN_ID, 'CAMPUSADMIN_ID'=>$this->CAMPUSADMIN_ID
	//		  $continueLink = $this->getCallBack( modulep2c_stats::PAGE_EDITPERSONALINFO, "", $parameters );
	        $links["cont"] = $continueLink;
	
	        $this->pageDisplay->setLinks( $links );
	*/       
			//$this->previous_page = modulep2c_stats::PAGE_EDITPERSONALINFO;    
//         }
//         else
//         {
// 	        $this->pageDisplay = new page_NotAuthorized($this->moduleRootPath, $this->viewer);  
//         }  
    } // end loadStatsReportSelectionForm()      
    
    
    
    //************************************************************************
	/**
	 * function loadStatsReport
	 * <pre>
	 * Initializes the StatisticsReport Page.
	 * </pre>
	 * @param $isCreated [BOOL] "Is THIS pageDisplay object already created?"
	 * @return [void]
	 */
    // RAD Tools: DataSingle Style
    function loadStatsReport($isCreated=false, $start_freqvalue_id, $end_freqvalue_id, $stats_id_array, $filter_id_array)
    {

	    // get privileges for the current viewer
//         $privManager = new PrivilegeManager( $this->viewer->getID() );  
//         if ($privManager->isCampusAdmin($this->EVENT_ID, $this->CAMPUS_ID)==true)	// check if privilege level is high enough
//         {	
	        
	        // set the pageCallBack to be without any additional parameters
	        // (an AdminBox needs this so Language Switching on a page doesn't
	        // pass a previous operations)
	        $parameters = array('PERSON_ID'=>$this->PERSON_ID, 'SCOPE_ID'=>$this->SCOPE_ID, 'LOCATION_ID'=>$this->LOCATION_ID, 'REGION_ID'=>$this->REGION_ID, 'DIVISION_ID'=>$this->DIVISION_ID, 'MINISTRY_ID'=>$this->MINISTRY_ID, 'FREQ_ID'=>$this->FREQ_ID, 'MEAS_ID'=>$this->MEAS_ID);//[RAD_CALLBACK_PARAMS]
				// 'PROVINCE_ID'=>$this->PROVINCE_ID, 'GENDER_ID'=>$this->GENDER_ID, 'STAFF_ID'=>$this->STAFF_ID, 'USER_ID'=>$this->USER_ID, 'ASSIGNMENT_ID'=>$this->ASSIGNMENT_ID, 'ADMIN_ID'=>$this->ADMIN_ID, 'CAMPUSADMIN_ID'=>$this->CAMPUSADMIN_ID
	        $pageCallBack = $this->getCallBack(modulep2c_stats::PAGE_STATS_REPORT, $this->sortBy, $parameters);
	        $this->setPageCallBack( $pageCallBack );
	        
	        $formTo_page = '';
		     $formTo_page = modulep2c_stats::PAGE_STATS_REPORT;

	        // NOTE: making use of previous_page variable to return to a dynamic page
	        $formAction = $this->getCallBack($formTo_page, $this->sortBy, $parameters );
	        
	        // Create a list of scope_ids indexing scope_ref_ids (i.e. ministry_ids, division_ids, etc)
	        // the stored ids will be used to retrieve associated statistics to generate input fields
	        $scopeRefArray = array();
	        $scopeRefArray[modulep2c_stats::SCOPE_REF_MINISTRY] = $this->MINISTRY_ID;	        
	        $scopeRefArray[modulep2c_stats::SCOPE_REF_DIVISION] = $this->DIVISION_ID;
	        $scopeRefArray[modulep2c_stats::SCOPE_REF_REGION] = $this->REGION_ID;
		     $scopeRefArray[modulep2c_stats::SCOPE_REF_LOCATION] = $this->LOCATION_ID;
		     

      
				// TODO: create scope_ref_list array of scope_ids with their associated scope_id
 	        $this->pageDisplay = new page_StatsReport($this->moduleRootPath, $this->viewer, $this->FREQ_ID, $this->MEAS_ID, $start_freqvalue_id, $end_freqvalue_id, $scopeRefArray, $stats_id_array, $filter_id_array );


		//}
	}	    
	
	
    
    //************************************************************************
	/**
	 * function loadEditMinistry
	 * <pre>
	 * Initializes the EditMinistry Page.
	 * </pre>
	 * @param $isCreated [BOOL] "Is THIS pageDisplay object already created?"
	 * @return [void]
	 */
    // RAD Tools: DataSingle Style
    function loadEditMinistry($isCreated=false)
    {

	    // get privileges for the current viewer
//         $privManager = new PrivilegeManager( $this->viewer->getID() );  
//         if ($privManager->isCampusAdmin($this->EVENT_ID, $this->CAMPUS_ID)==true)	// check if privilege level is high enough
//         {	
	        
	        // set the pageCallBack to be without any additional parameters
	        // (an AdminBox needs this so Language Switching on a page doesn't
	        // pass a previous operations)
	        $parameters = array('PERSON_ID'=>$this->PERSON_ID, 'MINISTRY_ID'=>$this->MINISTRY_ID);	//, 'SCOPE_ID'=>$this->SCOPE_ID, 'LOCATION_ID'=>$this->LOCATION_ID, 'REGION_ID'=>$this->REGION_ID, 'DIVISION_ID'=>$this->DIVISION_ID, 'MINISTRY_ID'=>$this->MINISTRY_ID, 'FREQ_ID'=>$this->FREQ_ID, 'MEAS_ID'=>$this->MEAS_ID);//[RAD_CALLBACK_PARAMS]
				// 'PROVINCE_ID'=>$this->PROVINCE_ID, 'GENDER_ID'=>$this->GENDER_ID, 'STAFF_ID'=>$this->STAFF_ID, 'USER_ID'=>$this->USER_ID, 'ASSIGNMENT_ID'=>$this->ASSIGNMENT_ID, 'ADMIN_ID'=>$this->ADMIN_ID, 'CAMPUSADMIN_ID'=>$this->CAMPUSADMIN_ID
	        $pageCallBack = $this->getCallBack(modulep2c_stats::PAGE_EDITMINISTRY, $this->sortBy, $parameters);
	        $this->setPageCallBack( $pageCallBack );
	        
	        $formTo_page = '';
		     $formTo_page = modulep2c_stats::PAGE_EDITMINISTRY;

	        // NOTE: making use of previous_page variable to return to a dynamic page
	        $formAction = $this->getCallBack($formTo_page, $this->sortBy, $parameters );
	                
	        // if this pageDisplay object isn't already created then 
	        if ( !$isCreated ) {
	        
	            // create a new pageDisplay object
 	        		$this->pageDisplay = new FormProcessor_EditMinistry($this->moduleRootPath, $this->viewer, $formAction,  $this->sortBy, $this->MINISTRY_ID );
	        
	        } else {
	        
	            // otherwise just update the formAction value
	            $this->pageDisplay->setFormAction( $formAction );
	        }
	        
	        $links = array();
	        
	        $parameters = array( 'MINISTRY_ID'=>$this->MINISTRY_ID);//[RAD_CALLBACK_PARAMS]
	        $continueLink = $this->getCallBack( modulep2c_stats::PAGE_STATS_HOME, "", $parameters );
	        $links["cont"] = $continueLink;
	
	        $parameters = array();	// 'MINISTRY_ID'=>$this->MINISTRY_ID);//[RAD_CALLBACK_PARAMS]
	        $editLink = $this->getCallBack( modulep2c_stats::PAGE_EDITMINISTRY, $this->sortBy, $parameters );
	        $editLink .= "&". modulep2c_stats::MINISTRY_ID . "=";
	        $links[ "edit" ] = $editLink;
	        
	        // NOTE: delete link is same as edit link for an AdminBox
	        $links[ "del" ] = $editLink;
	
	/*[RAD_LINK_INSERT]*/
	
// 	        $parameters = array('EVENT_ID'=>$this->EVENT_ID, 'FIELDTYPE_ID'=>$this->FIELDTYPE_ID, 'PRICERULETYPE_ID'=>$this->PRICERULETYPE_ID, 'CCTYPE_ID'=>$this->CCTYPE_ID, 'PRIV_ID'=>$this->PRIV_ID);//[RAD_CALLBACK_PARAMS]
	        $sortByLink = $this->getCallBack( modulep2c_stats::PAGE_EDITMINISTRY, '', $parameters );
	        $sortByLink .= "&".modulep2c_stats::SORTBY."=";
	        $links["sortBy"] = $sortByLink;
	
	        $this->pageDisplay->setLinks( $links );   	        
 	        
 	        
		//}
	}		
    
	
    //************************************************************************
	/**
	 * function loadEditDivision
	 * <pre>
	 * Initializes the EditDivision Page.
	 * </pre>
	 * @param $isCreated [BOOL] "Is THIS pageDisplay object already created?"
	 * @return [void]
	 */
    // RAD Tools: DataSingle Style
    function loadEditDivision($isCreated=false)
    {

	    // get privileges for the current viewer
//         $privManager = new PrivilegeManager( $this->viewer->getID() );  
//         if ($privManager->isCampusAdmin($this->EVENT_ID, $this->CAMPUS_ID)==true)	// check if privilege level is high enough
//         {	
	        
	        // set the pageCallBack to be without any additional parameters
	        // (an AdminBox needs this so Language Switching on a page doesn't
	        // pass a previous operations)
	        $parameters = array('PERSON_ID'=>$this->PERSON_ID, 'MINISTRY_ID'=>$this->MINISTRY_ID, 'DIVISION_ID'=>$this->DIVISION_ID);	//, 'SCOPE_ID'=>$this->SCOPE_ID, 'LOCATION_ID'=>$this->LOCATION_ID, 'REGION_ID'=>$this->REGION_ID, 'DIVISION_ID'=>$this->DIVISION_ID, 'MINISTRY_ID'=>$this->MINISTRY_ID, 'FREQ_ID'=>$this->FREQ_ID, 'MEAS_ID'=>$this->MEAS_ID);//[RAD_CALLBACK_PARAMS]
				// 'PROVINCE_ID'=>$this->PROVINCE_ID, 'GENDER_ID'=>$this->GENDER_ID, 'STAFF_ID'=>$this->STAFF_ID, 'USER_ID'=>$this->USER_ID, 'ASSIGNMENT_ID'=>$this->ASSIGNMENT_ID, 'ADMIN_ID'=>$this->ADMIN_ID, 'CAMPUSADMIN_ID'=>$this->CAMPUSADMIN_ID
	        $pageCallBack = $this->getCallBack(modulep2c_stats::PAGE_EDITDIVISION, $this->sortBy, $parameters);
	        $this->setPageCallBack( $pageCallBack );
	        
	        $formTo_page = '';
		     $formTo_page = modulep2c_stats::PAGE_EDITDIVISION;

	        // NOTE: making use of previous_page variable to return to a dynamic page
	        $formAction = $this->getCallBack($formTo_page, $this->sortBy, $parameters );
	                
	        // if this pageDisplay object isn't already created then 
	        if ( !$isCreated ) {
	        
	            // create a new pageDisplay object
 	        		$this->pageDisplay = new FormProcessor_EditDivision($this->moduleRootPath, $this->viewer, $formAction,  $this->sortBy, $this->DIVISION_ID, $this->MINISTRY_ID );
	        
	        } else {
	        
	            // otherwise just update the formAction value
	            $this->pageDisplay->setFormAction( $formAction );
	        }
	        
	        $links = array();
	        
	        $parameters = array('DIVISION_ID'=>$this->DIVISION_ID, 'MINISTRY_ID'=>$this->MINISTRY_ID);//[RAD_CALLBACK_PARAMS]
	        $continueLink = $this->getCallBack( modulep2c_stats::PAGE_STATS_HOME, "", $parameters );
	        $links["cont"] = $continueLink;
	
	        $parameters = array('MINISTRY_ID'=>$this->MINISTRY_ID);	// 'MINISTRY_ID'=>$this->MINISTRY_ID);//[RAD_CALLBACK_PARAMS]
	        $editLink = $this->getCallBack( modulep2c_stats::PAGE_EDITDIVISION, $this->sortBy, $parameters );
	        $editLink .= "&". modulep2c_stats::DIVISION_ID . "=";
	        $links[ "edit" ] = $editLink;
	        
	        // NOTE: delete link is same as edit link for an AdminBox
	        $links[ "del" ] = $editLink;
	
	/*[RAD_LINK_INSERT]*/
	
// 	        $parameters = array('EVENT_ID'=>$this->EVENT_ID, 'FIELDTYPE_ID'=>$this->FIELDTYPE_ID, 'PRICERULETYPE_ID'=>$this->PRICERULETYPE_ID, 'CCTYPE_ID'=>$this->CCTYPE_ID, 'PRIV_ID'=>$this->PRIV_ID);//[RAD_CALLBACK_PARAMS]
	        $sortByLink = $this->getCallBack( modulep2c_stats::PAGE_EDITDIVISION, '', $parameters );
	        $sortByLink .= "&".modulep2c_stats::SORTBY."=";
	        $links["sortBy"] = $sortByLink;
	
	        $this->pageDisplay->setLinks( $links );   	        
 	        
 	        
		//}
	}		
	
    //************************************************************************
	/**
	 * function loadEditRegion
	 * <pre>
	 * Initializes the EditRegion Page.
	 * </pre>
	 * @param $isCreated [BOOL] "Is THIS pageDisplay object already created?"
	 * @return [void]
	 */
    // RAD Tools: DataSingle Style
    function loadEditRegion($isCreated=false)
    {

	    // get privileges for the current viewer
//         $privManager = new PrivilegeManager( $this->viewer->getID() );  
//         if ($privManager->isCampusAdmin($this->EVENT_ID, $this->CAMPUS_ID)==true)	// check if privilege level is high enough
//         {	
	        
	        // set the pageCallBack to be without any additional parameters
	        // (an AdminBox needs this so Language Switching on a page doesn't
	        // pass a previous operations)
	        $parameters = array('PERSON_ID'=>$this->PERSON_ID, 'MINISTRY_ID'=>$this->MINISTRY_ID, 'DIVISION_ID'=>$this->DIVISION_ID, 'REGION_ID'=>$this->REGION_ID);	//, 'SCOPE_ID'=>$this->SCOPE_ID, 'LOCATION_ID'=>$this->LOCATION_ID, 'REGION_ID'=>$this->REGION_ID, 'DIVISION_ID'=>$this->DIVISION_ID, 'MINISTRY_ID'=>$this->MINISTRY_ID, 'FREQ_ID'=>$this->FREQ_ID, 'MEAS_ID'=>$this->MEAS_ID);//[RAD_CALLBACK_PARAMS]
				// 'PROVINCE_ID'=>$this->PROVINCE_ID, 'GENDER_ID'=>$this->GENDER_ID, 'STAFF_ID'=>$this->STAFF_ID, 'USER_ID'=>$this->USER_ID, 'ASSIGNMENT_ID'=>$this->ASSIGNMENT_ID, 'ADMIN_ID'=>$this->ADMIN_ID, 'CAMPUSADMIN_ID'=>$this->CAMPUSADMIN_ID
	        $pageCallBack = $this->getCallBack(modulep2c_stats::PAGE_EDITREGION, $this->sortBy, $parameters);
	        $this->setPageCallBack( $pageCallBack );
	        
	        $formTo_page = '';
		     $formTo_page = modulep2c_stats::PAGE_EDITREGION;

	        // NOTE: making use of previous_page variable to return to a dynamic page
	        $formAction = $this->getCallBack($formTo_page, $this->sortBy, $parameters );
	                
	        // if this pageDisplay object isn't already created then 
	        if ( !$isCreated ) {
	        
	            // create a new pageDisplay object
 	        		$this->pageDisplay = new FormProcessor_EditRegion($this->moduleRootPath, $this->viewer, $formAction,  $this->sortBy, $this->REGION_ID, $this->DIVISION_ID, $this->MINISTRY_ID );
	        
	        } else {
	        
	            // otherwise just update the formAction value
	            $this->pageDisplay->setFormAction( $formAction );
	        }
	        
	        $links = array();
	        
	        $parameters = array('REGION_ID'=>$this->REGION_ID, 'DIVISION_ID'=>$this->DIVISION_ID, 'MINISTRY_ID'=>$this->MINISTRY_ID);//[RAD_CALLBACK_PARAMS]
	        $continueLink = $this->getCallBack( modulep2c_stats::PAGE_STATS_HOME, "", $parameters );
	        $links["cont"] = $continueLink;
	
	        $parameters = array('DIVISION_ID'=>$this->DIVISION_ID, 'MINISTRY_ID'=>$this->MINISTRY_ID);	// 'MINISTRY_ID'=>$this->MINISTRY_ID);//[RAD_CALLBACK_PARAMS]
	        $editLink = $this->getCallBack( modulep2c_stats::PAGE_EDITREGION, $this->sortBy, $parameters );
	        $editLink .= "&". modulep2c_stats::REGION_ID . "=";
	        $links[ "edit" ] = $editLink;
	        
	        // NOTE: delete link is same as edit link for an AdminBox
	        $links[ "del" ] = $editLink;
	
	/*[RAD_LINK_INSERT]*/
	
// 	        $parameters = array('EVENT_ID'=>$this->EVENT_ID, 'FIELDTYPE_ID'=>$this->FIELDTYPE_ID, 'PRICERULETYPE_ID'=>$this->PRICERULETYPE_ID, 'CCTYPE_ID'=>$this->CCTYPE_ID, 'PRIV_ID'=>$this->PRIV_ID);//[RAD_CALLBACK_PARAMS]
	        $sortByLink = $this->getCallBack( modulep2c_stats::PAGE_EDITREGION, '', $parameters );
	        $sortByLink .= "&".modulep2c_stats::SORTBY."=";
	        $links["sortBy"] = $sortByLink;
	
	        $this->pageDisplay->setLinks( $links );   	        
 	        
 	        
		//}
	}		
	
	
    //************************************************************************
	/**
	 * function loadEditLocation
	 * <pre>
	 * Initializes the EditLocation Page.
	 * </pre>
	 * @param $isCreated [BOOL] "Is THIS pageDisplay object already created?"
	 * @return [void]
	 */
    // RAD Tools: DataSingle Style
    function loadEditLocation($isCreated=false)
    {

	    // get privileges for the current viewer
//         $privManager = new PrivilegeManager( $this->viewer->getID() );  
//         if ($privManager->isCampusAdmin($this->EVENT_ID, $this->CAMPUS_ID)==true)	// check if privilege level is high enough
//         {	
	        
	        // set the pageCallBack to be without any additional parameters
	        // (an AdminBox needs this so Language Switching on a page doesn't
	        // pass a previous operations)
	        $parameters = array('PERSON_ID'=>$this->PERSON_ID, 'MINISTRY_ID'=>$this->MINISTRY_ID, 'DIVISION_ID'=>$this->DIVISION_ID, 'REGION_ID'=>$this->REGION_ID, 'LOCATION_ID'=>$this->LOCATION_ID);	//, 'SCOPE_ID'=>$this->SCOPE_ID, 'LOCATION_ID'=>$this->LOCATION_ID, 'REGION_ID'=>$this->REGION_ID, 'DIVISION_ID'=>$this->DIVISION_ID, 'MINISTRY_ID'=>$this->MINISTRY_ID, 'FREQ_ID'=>$this->FREQ_ID, 'MEAS_ID'=>$this->MEAS_ID);//[RAD_CALLBACK_PARAMS]
	        $pageCallBack = $this->getCallBack(modulep2c_stats::PAGE_EDITLOCATION, $this->sortBy, $parameters);
	        $this->setPageCallBack( $pageCallBack );
	        
	        $formTo_page = '';
		     $formTo_page = modulep2c_stats::PAGE_EDITLOCATION;

	        // NOTE: making use of previous_page variable to return to a dynamic page
	        $formAction = $this->getCallBack($formTo_page, $this->sortBy, $parameters );
	                
	        // if this pageDisplay object isn't already created then 
	        if ( !$isCreated ) {
	        
	            // create a new pageDisplay object
 	        		$this->pageDisplay = new FormProcessor_EditLocation($this->moduleRootPath, $this->viewer, $formAction,  $this->sortBy, $this->LOCATION_ID, $this->REGION_ID, $this->DIVISION_ID, $this->MINISTRY_ID );
	        
	        } else {
	        
	            // otherwise just update the formAction value
	            $this->pageDisplay->setFormAction( $formAction );
	        }
	        
	        $links = array();
	        
	        $parameters = array('LOCATION_ID'=>$this->LOCATION_ID, 'REGION_ID'=>$this->REGION_ID, 'DIVISION_ID'=>$this->DIVISION_ID, 'MINISTRY_ID'=>$this->MINISTRY_ID);//[RAD_CALLBACK_PARAMS]
	        $continueLink = $this->getCallBack( modulep2c_stats::PAGE_STATS_HOME, "", $parameters );
	        $links["cont"] = $continueLink;
	
	        $parameters = array('REGION_ID'=>$this->REGION_ID, 'DIVISION_ID'=>$this->DIVISION_ID, 'MINISTRY_ID'=>$this->MINISTRY_ID);	// 'MINISTRY_ID'=>$this->MINISTRY_ID);//[RAD_CALLBACK_PARAMS]
	        $editLink = $this->getCallBack( modulep2c_stats::PAGE_EDITLOCATION, $this->sortBy, $parameters );
	        $editLink .= "&". modulep2c_stats::LOCATION_ID . "=";
	        $links[ "edit" ] = $editLink;
	        
	        // NOTE: delete link is same as edit link for an AdminBox
	        $links[ "del" ] = $editLink;
	
	/*[RAD_LINK_INSERT]*/
	
// 	        $parameters = array('EVENT_ID'=>$this->EVENT_ID, 'FIELDTYPE_ID'=>$this->FIELDTYPE_ID, 'PRICERULETYPE_ID'=>$this->PRICERULETYPE_ID, 'CCTYPE_ID'=>$this->CCTYPE_ID, 'PRIV_ID'=>$this->PRIV_ID);//[RAD_CALLBACK_PARAMS]
	        $sortByLink = $this->getCallBack( modulep2c_stats::PAGE_EDITLOCATION, '', $parameters );
	        $sortByLink .= "&".modulep2c_stats::SORTBY."=";
	        $links["sortBy"] = $sortByLink;
	
	        $this->pageDisplay->setLinks( $links );   	        
 	        
 	        
		//}
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
// 	    // get privileges for the current viewer
//         $privManager = new PrivilegeManager( $this->viewer->getID() );  
//         if ($privManager->isCampusAdmin($this->EVENT_ID, $this->CAMPUS_ID)==true)	
//         {		    
// 		    
// 	        // set the pageCallBack to be without any additional parameters
// 	        // (an AdminBox needs this so Language Switching on a page doesn't
// 	        // pass a previous operations)
// 	        $parameters = array('EVENT_ID'=>$this->EVENT_ID, 'FIELDTYPE_ID'=>$this->FIELDTYPE_ID, 'PRICERULETYPE_ID'=>$this->PRICERULETYPE_ID, 'CCTYPE_ID'=>$this->CCTYPE_ID, 'PRIV_ID'=>$this->PRIV_ID, 'VIEWER_ID'=>$this->VIEWER_ID, 'SUPERADMIN_ID'=>$this->SUPERADMIN_ID, 'EVENTADMIN_ID'=>$this->EVENTADMIN_ID, 'FIELD_ID'=>$this->FIELD_ID, 'DATATYPE_ID'=>$this->DATATYPE_ID, 'PRICERULE_ID'=>$this->PRICERULE_ID, 'CAMPUSACCESS_ID'=>$this->CAMPUSACCESS_ID, 'CASHTRANS_ID'=>$this->CASHTRANS_ID, 'CCTRANS_ID'=>$this->CCTRANS_ID, 'REG_ID'=>$this->REG_ID, 'FIELDVALUE_ID'=>$this->FIELDVALUE_ID, 'SCHOLARSHIP_ID'=>$this->SCHOLARSHIP_ID, 'STATUS_ID'=>$this->STATUS_ID, 'DOWNLOAD_TYPE'=>$this->DOWNLOAD_TYPE);//[RAD_CALLBACK_PARAMS]
// 	        $pageCallBack = $this->getCallBack(modulep2c_stats::PAGE_DOWNLOADREPORT, $this->sortBy, $parameters);
// 	        $this->setPageCallBack( $pageCallBack );        
// 	        
// 	        $this->pageDisplay = new page_DownloadReport( $this->moduleRootPath, $this->viewer, $this->DOWNLOAD_TYPE, $this->EVENT_ID, $this->CAMPUS_ID );    
// 	        
// 	        $links = array();
// 	        
// 	/*[RAD_LINK_INSERT]*/
// 	
// 	//$this->getCallBack( modulep2c_stats::PAGE_EDITCAMPUSASSIGNMENT, '', $parameters );
// 	// 		  $link1 = SITE_PATH_MODULES.'app_'.modulep2c_stats::MODULE_KEY.'/objects_pages/'.modulep2c_stats::CSV_DOWNLOAD_TOOL.'?'.modulep2c_stats::EVENT_ID.'='.$this->EVENT_ID.'&'.modulep2c_stats::DOWNLOAD_TYPE.'='.modulep2c_stats::DOWNLOAD_EVENT_DATA;	//$this->getCallBack( modulep2c_stats::PAGE_ADMINEVENTHOME, '', $fileDownloadParameters );
// 			  $link1 = SITE_PATH_REPORTS.modulep2c_stats::EVENT_DATA_FILE_NAME;
// 	//        $link1 .= "&".modulep2c_stats::SORTBY."=";
// 			  $link2 = SITE_PATH_REPORTS.modulep2c_stats::EVENT_SCHOLARSHIP_FILE_NAME;
// 	
// 	        $links[ "DownloadEventDataDump" ] = $link1;
// 			  $links[ "DownloadScholarshipDataDump" ] = $link2;
// 			  
// 	        $parameters = array( 'EVENT_ID'=>$this->EVENT_ID, 'FIELDTYPE_ID'=>$this->FIELDTYPE_ID);//[RAD_CALLBACK_PARAMS]
// 	        $continueLink = $this->getCallBack( modulep2c_stats::PAGE_ADMINEVENTHOME, "", $parameters );
// 	        $links["cont"] = $continueLink;		  
// 	
// 	        $this->pageDisplay->setLinks( $links ); 
// 	        //$this->previous_page = modulep2c_stats::PAGE_HOMEPAGEEVENTLIST;   
//         }
//         else
//         {
// 	        $this->pageDisplay = new page_NotAuthorized($this->moduleRootPath, $this->viewer);  
//         }         
    }	    





    //************************************************************************
	/**
	 * function loadEditStatistic
	 * <pre>
	 * Initializes the EditStatistic Page.
	 * </pre>
	 * @param $isCreated [BOOL] "Is THIS pageDisplay object already created?"
	 * @return [void]
	 */
    // RAD Tools: AdminBox Style
    function loadEditStatistic( $isCreated=false ) 
    {
        
        // compile a formAction for the adminBox
        $parameters = array('STAT_ID'=>$this->STAT_ID, 'SCOPE_ID'=>$this->SCOPE_ID, 'MINISTRY_ID'=>$this->MINISTRY_ID, 'DIVISION_ID'=>$this->DIVISION_ID, 'REGION_ID'=>$this->REGION_ID, 'LOCATION_ID'=>$this->LOCATION_ID, 'FREQ_ID'=>$this->FREQ_ID, 'MEAS_ID'=>$this->MEAS_ID, 'STATVALUES_ID'=>$this->STATVALUES_ID, 'FREQVALUE_ID'=>$this->FREQVALUE_ID, 'FILTER_ID'=>$this->FILTER_ID);//[RAD_CALLBACK_PARAMS]
        $formAction = $this->getCallBack(modulep2c_stats::PAGE_EDITSTATISTIC, $this->sortBy, $parameters );
        
        // set the pageCallBack value.  This is used by the Language switching
        // code
        $this->setPageCallBack( $formAction );
        
        // if this pageDisplay object isn't already created then 
        if ( !$isCreated ) {
        
            // create a new pageDisplay object
            $this->pageDisplay = new FormProcessor_EditStatistic( $this->moduleRootPath, $this->viewer, $formAction, $this->sortBy,  $this->STAT_ID, $this->SCOPE_ID, $this->SCOPE_REF_ID, $this->FREQ_ID , $this->MEAS_ID);//[RAD_FORMINIT_FOREIGNKEY_INIT]    
        
        } else {
        
            // otherwise just update the formAction value
            $this->pageDisplay->setFormAction( $formAction );
        }
        
        $links = array();
        
        $parameters = array();	//array('SCOPE_ID'=>$this->SCOPE_ID, 'MINISTRY_ID'=>$this->MINISTRY_ID, 'DIVISION_ID'=>$this->DIVISION_ID, 'REGION_ID'=>$this->REGION_ID, 'LOCATION_ID'=>$this->LOCATION_ID, 'FREQ_ID'=>$this->FREQ_ID, 'MEAS_ID'=>$this->MEAS_ID, 'STATVALUES_ID'=>$this->STATVALUES_ID, 'FREQVALUE_ID'=>$this->FREQVALUE_ID, 'FILTER_ID'=>$this->FILTER_ID);//[RAD_CALLBACK_PARAMS]
        $editLink = $this->getCallBack( modulep2c_stats::PAGE_EDITSTATISTIC, $this->sortBy, $parameters );
        $editLink .= "&". modulep2c_stats::STAT_ID . "=";
        $links[ "edit" ] = $editLink;
        
        // NOTE: delete link is same as edit link for an AdminBox
        $links[ "del" ] = $editLink;

/*[RAD_LINK_INSERT]*/

        $parameters = array('STAT_ID'=>$this->STAT_ID, 'SCOPE_ID'=>$this->SCOPE_ID, 'MINISTRY_ID'=>$this->MINISTRY_ID, 'DIVISION_ID'=>$this->DIVISION_ID, 'REGION_ID'=>$this->REGION_ID, 'LOCATION_ID'=>$this->LOCATION_ID, 'FREQ_ID'=>$this->FREQ_ID, 'MEAS_ID'=>$this->MEAS_ID, 'STATVALUES_ID'=>$this->STATVALUES_ID, 'FREQVALUE_ID'=>$this->FREQVALUE_ID, 'FILTER_ID'=>$this->FILTER_ID);//[RAD_CALLBACK_PARAMS]
        $sortByLink = $this->getCallBack( modulep2c_stats::PAGE_EDITSTATISTIC, '', $parameters );
        $sortByLink .= "&".modulep2c_stats::SORTBY."=";
        $links["sortBy"] = $sortByLink;
        
                // note: we omit the semester_id for this set of parameters
//         $parameters = array('CAMPUS_ID'=>$this->CAMPUS_ID, 'STAFF_ID'=>$this->STAFF_ID);
        $scopeJumpLink = $this->getCallBack( modulep2c_stats::PAGE_EDITSTATISTIC, $this->sortBy, $parameters);
        $scopeJumpLink .= "&". modulep2c_stats::SCOPE_ID . "=";
        $links["scopeJumpLink"] = $scopeJumpLink;

        $this->pageDisplay->setLinks( $links );
        
        $this->addScript('MM_jumpMenu.jsp');   
 
        
    } // end loadEditStatistic()



/*[RAD_PAGE_LOAD_FN]*/		

}

?>