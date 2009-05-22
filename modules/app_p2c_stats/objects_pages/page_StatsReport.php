<?php
/**
 * @package cim_stats
 */ 
/**
 * class page_StatsReport 
 * <pre> 
 * Reports on stats for a particular locale, freq-type, and meas-type
 * </pre>
 * @author Hobbe Smit
 * Date:   2 Nov 2007
 */
 // RAD Tools: Custom Page
class  page_StatsReport extends PageDisplay {

	//CONSTANTS:
    
    /** The Multilingual Page Key for labels on this page */
    const MULTILINGUAL_PAGE_KEY = 'page_StatsReport';
    

	//VARIABLES:
	
	/** @var [OBJECT] The viewer object. */
	protected $viewer;
	
    /** @var [STRING] The path to this module's root directory. */
	protected $pathModuleRoot;
	
	protected $freq_id;
	protected $meas_id;
	
// 	protected $semester_id;
	
// 	protected $campusListIterator;
// 	protected $semesterListIterator;
	
	protected $scope_ref_array;
	protected $stats_id_array;	
	protected $stat_names_array;
	protected $filter_id_array;		
	
// 	protected $permManager;	// manages permissions
	protected $freqValManager;	// manages freq values (i.e. Week 2 of 2008, etc)
	protected $calcManager;	// manages report filters (i.e. additional calcs such as AVG, SUM, etc)
	

	//CLASS CONSTRUCTOR
	//************************************************************************
	/**
	 * function __construct
	 * <pre>
	 * Initialize the object.
	 * </pre>
	 * @param $pathModuleRoot [STRING] The path to the module's root dir.
	 * @param $viewer [OBJECT] The viewer object.
	 * @return [void]
	 */
    function __construct($pathModuleRoot, $viewer, $freq_id, $meas_id, $start_freqvalue_id, $end_freqvalue_id, $scope_ref_array, $stats_id_array, $filter_id_array ) 
    {
    
        parent::__construct();
        
        // initialzie the object values
        $this->pathModuleRoot = $pathModuleRoot;
        $this->viewer = $viewer;
        
//         $this->permManager = new PermissionManager( $this->viewer->getViewerID() );
        
        $this->freq_id = $freq_id;
        $this->meas_id = $meas_id;
        $this->scope_ref_array = $scope_ref_array;
        
        
                 // initialize the freq values to display
         $this->freqValManager = new RowManager_FreqValueManager();
         $this->freqValManager->setFreqID($freq_id);       
         $freqValRange = 'freqvalue_id between '.$start_freqvalue_id.' and '.$end_freqvalue_id;
         $this->freqValManager->addSearchCondition($freqValRange);
         $this->freqValManager->setSortByDateTime();
//          $this->freqValManager->setSortOrder('freqvalue_id');
         
        
        // initialize the statistics value RowManager to contain the values we want
        $this->dataManager = new RowManager_StatValueManager();
 
         // filter values by the statistics chosen in previous filter step
         $this->stats_id_array = $stats_id_array;
         $statFilter = '';
         reset($stats_id_array);
         foreach( array_keys($stats_id_array) as $key)
         {
	         // TODO?: use is_numeric() on $scope_ref_list elements to determine that proper value exists
	         $statFilter .= '(statistic_id = '.current($stats_id_array).') OR ';
	         
	         next($stats_id_array);
         }
         $statFilter = substr($statFilter,0,-4);	// remove ' OR ' from the end of the string
         $this->dataManager->addSearchCondition($freqValRange);
         $this->dataManager->addSearchCondition($statFilter);
         $this->dataManager->setSortOrder('statistic_id');
               
         // Retrieve stats names to be displayed
         $statNames = new RowManager_StatisticManager();
         $statNames->addSearchCondition($statFilter);
         $statNames->setSortOrder('statistic_id');
         
         $this->stat_names_array = array();
         $statNamesList = $statNames->getListIterator();
         $statNamesArray = $statNamesList->getDataList();
         reset($statNamesArray);
         $i = 0;
         foreach( array_keys($statNamesArray) as $key )
         {
	         $record = current($statNamesArray);
	         $this->stat_names_array[$i] = $record['statistic_name'];
	         next($statNamesArray);
	         $i++;
         }
//          echo "stat names array = <pre>".print_r($statNamesArray,true)."</pre>";
         
         
         // initialize the additional calculations to be made (i.e. SUM, AVG, etc)
         $this->calcManager = new RowManager_ReportFilterManager();
         
         $this->filter_id_array = $filter_id_array;
         $calcFilter = '';
         reset($filter_id_array);
         foreach( array_keys($filter_id_array) as $key)
         {
	         // TODO?: use is_numeric() on $scope_ref_list elements to determine that proper value exists
	         $calcFilter .= '(filter_id = '.current($filter_id_array).') OR ';
	         
	         next($filter_id_array);
         }
         $calcFilter = substr($calcFilter,0,-4);	// remove ' OR ' from the end of the string
         $this->calcManager->addSearchCondition($calcFilter);
 
        
        
        // now initialize the labels for this page
        // start by loading the default field labels for this Module
        $languageID = $viewer->getLanguageID();
        $seriesKey = modulep2c_stats::MULTILINGUAL_SERIES_KEY;
        $pageKey = modulep2c_stats::MULTILINGUAL_PAGE_FIELDS;
        $this->labels = new MultilingualManager( $languageID, $seriesKey, $pageKey );
        
        $pageKey = page_StatsReport::MULTILINGUAL_PAGE_KEY;
        $this->labels->loadPageLabels( $pageKey );
        
//         echo "POST values = <pre>".print_r($_POST,true)."</pre>";
         
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
        //$path = SITE_PATH_TEMPLATES;
        
        // NOTE:  this parent method prepares the $this->template with the 
        // common Form data.  
        $this->prepareTemplate( $path );
        
        
        // TODO: when implementing staff-specific stats reporting, 
        //       refer to page_StaffSemesterReport.php in app_cim_stats module
        
         
        /** The frequency values (weeks, days,.. whatever was chosen) **/
        //this->freqValManager;
        
        
//         $infoArray = array();

			$statNames = array();
        
         //ReportInfo
         $statReportInfo = new ReportInfo();

         
         
          /*** Determine which frequency is acting as the parent frequency (i.e. month is parent of week) **/
          $freqType = new RowManager_FreqTypeManager($this->freq_id);
//              $freqType->setFreqID($this->freq_id);
          
          $freqTypeList = $freqType->getListIterator();
          $freqTypeArray = $freqTypeList->getDataList();
          
          // should be only 1 match for the frequency ID
          $parent_freq_id = '';
          $date_field_id = '';
          if (count($freqTypeArray) == 1)
          {
             $record = current($freqTypeArray);
             $parent_freq_id = $record['freq_parent_freq_id'];
             $date_field_id = $record['freq_parent_date_field_index'] - 1;	//IMPORTANT: database stores 1-based index (to allow 0 default)
             
//              echo ' freqTypeArray = <pre>'.print_r($freqTypeArray,true).'</pre>';
// 	             echo ' dateFieldValues = <pre>'.print_r($dateFieldValues,true).'</pre>';
//             	 echo ' date field index = '.$date_field_id;
          }   
          
         $parentDateValues = array();      
         $parentIndex = 0;

         // calendar
         $statReportInfo->calendar = array();
         $currentParentFreqVal = 0;	// i.e. could be default starting month value if child stat is 'weekly'
         
         // actual data
         // dataArray[freqValID] = arrayOfData
         $statReportInfo->dataArray = array();          
                   
         $freqValList = new ListIterator( $this->freqValManager );
         
         $freqValList->setFirst();
         while( $freqValList->moveNext() )
         {													// TODO: check if below filters properly based on $this->freqValManager
             $freqVal = $freqValList->getCurrent( new RowManager_FreqValueManager() );	// i.e. week for weekly stats
             $freqValID = $freqVal->getID();		// i.e. weekID for weekly stats
             
             // setup stuff for the calendar in the report
             $freqVal_dateTime = $freqVal->getFreqValue();		// i.e. getEndDate for weekly stats in app_cim_stats
             
             $freqVal_date = substr($freqVal_dateTime,0,10);
             $freqVal_time = substr($freqVal_dateTime,10);
//              list( $year, $month, $day ) = explode('-', $freqVal_date );
				 $dateFieldValues	= explode('-', $freqVal_date );
				 $timeFieldValues = explode(':', $freqVal_time );
//              $month = ltrim($month, "0");		// strips '0's from in front of $month...
             // $day = ltrim($day, "0");
             
             $dateTimeValues = array_merge($dateFieldValues,$timeFieldValues);
             
             $parentDateFieldVal = 0;
             if (isset($dateFieldValues)&&($date_field_id >= 0))
             {
            	 $parentDateFieldVal = $dateFieldValues[$date_field_id];
         	 }
             
             if ( $currentParentFreqVal != $parentDateFieldVal )		// i.e.
             {
                 // echo 'start new array<br/>';
                 $currentParentFreqVal = $parentDateFieldVal;
             }
//              echo 'parent val = '.$currentParentFreqVal;

//              $currentParentFreqVal = ltrim($currentParentFreqVal,"0");	// trim any leading zeroes
             $parentDateValues[$parentIndex] = $currentParentFreqVal;

             $currentFreqVal = $dateTimeValues[$date_field_id+1];	// i.e. current freq = (some) hour if the parent = (some) day
             
             $statReportInfo->calendar[ $currentParentFreqVal ][ $currentFreqVal ] = $freqValID;	// i.e. calendar[month][day] = $weekID
             // end calendar stuff
             
             // check if an entry exists in the stat values table for the current freq. value
             $this->dataManager->clearValues();
             $this->dataManager->setFreqValueID($freqValID);
             $statsManager = new RowManager_StatisticManager();
             
             $freqVal_statVals = new MultiTableManager();
             $freqVal_statVals->addRowManager($this->dataManager);
             $freqVal_statVals->addRowManager($statsManager, new JoinPair($statsManager->getJoinOnStatID(), $this->dataManager->getJoinOnStatID()));
             
             $statValsList = $freqVal_statVals->getListIterator();
             $statValsArray = $statValsList->getDataList();
             
             // retrieve stat values associated with some freq val (used for display)
             $stat_name = '';
             $stat_val = '';
             $freqValStatValsArray = array();
//              echo '<br>stat vals array <pre>'.print_r( $statValsArray,true ).'</pre>';
             reset($statValsArray);
             foreach( array_keys($statValsArray) as $key )
             {
	             $record = current($statValsArray);
	             $stat_name = $record['statistic_name'];
	             $stat_val =  $record['statvalues_value'];
	             
	             // re-package array into simpler form for list display use
	             $freqValStatValsArray[$stat_name] = $stat_val;
	             
	             next($statValsArray);
             }
                 
             if (count($freqValStatValsArray) > 0)
             {
             	$statReportInfo->dataArray[ $freqValID ] = $freqValStatValsArray;               
//                   echo 'freq val stat vals array: <pre>'.print_r( $freqValStatValsArray,true ).'</pre>';
             }
             else
             {
                 $statReportInfo->dataArray[ $freqValID ] = null;
             }    
    
             $parentIndex++;
         }
         
//          echo 'calendar = <pre>'.print_r($statReportInfo->calendar,true).'</pre>';
         
//          $infoArray[] = $statReportInfo;

         

        /*
         * Update any label tags ...
         */
        // example:
            // $name = $user->getName();
            // $this->labels->setLabelTag( '[Title]', '[userName]', $name);

//         $campusJumpLinkSelectedValue = $this->linkValues['campusJumpLink'].$this->campus_id;
//         $semesterJumpLinkSelectedValue = $this->linkValues['semesterJumpLink'].$this->semester_id;

//         
// 			$this->template->set( 'calendar', $calendar );
// 			$this->template->set( 'dataArray', $dataArray );
//         $this->template->set( 'infoArray', $infoArray );

		$this->template->set( 'statReportInfo', $statReportInfo );
// 		echo '<br> stat report: <pre>'.print_r($statReportInfo,true).'</pre>';
		$this->template->set( 'statsArray', $this->stat_names_array );
		
		 // need to create a static array of parent frequency values (i.e. like list of months as headers for week values)
		 $parent_freqs_array = array();
		 if (isset($parent_freq_id)&&($parent_freq_id > 0))
		 {
          $parentFreqValues = new RowManager_FreqValueManager();
          $parentFreqValues->setFreqID($parent_freq_id);
          
          $parentFreqValuesList = $parentFreqValues->getListIterator();
          $parentFreqValuesArray = $parentFreqValuesList->getDataList();
          $i = 0;
          reset($parentFreqValuesArray);
          foreach( array_keys($parentFreqValuesArray) as $key )
          {
             $record = current($parentFreqValuesArray);   
               
//              $date_field_value = $parentDateValues[$i];   
//              echo "date field = ".$date_field_value;
//              echo "record = ".$record['freqvalue_desc'];
//              if ($date_field_value ==  $record['freqvalue_desc'])
//              {
//              	$parent_freqs_array[$date_field_value] = $record['freqvalue_desc'];
//              	$i++;
//           	 }

				 $freqVal_dateTime = $record['freqvalue_value'];
				 
				 $freqVal_date = substr($freqVal_dateTime,0,10);
             $freqVal_time = substr($freqVal_dateTime,10);

				 $dateFieldValues	= explode('-', $freqVal_date );
				 $timeFieldValues = explode(':', $freqVal_time );             
             $dateTimeValues = array_merge($dateFieldValues,$timeFieldValues);
             
             // setup array to have date field value (i.e. one of YYYY, MM, DD, HH, min, sec   values) as index
             // the value is the frequency type description (i.e. 'January' for MM = 01)
             $parent_freqs_array[$dateFieldValues[$date_field_id]] = $record['freqvalue_desc'];

             next($parentFreqValuesArray);            
          }
//            echo "parent freqs = <pre>".print_r($parent_freqs_array,true)."</pre>";
          $this->template->set( 'parentFreqArray', $parent_freqs_array );
          
// //           echo 'parent freq id = '.$parent_freq_id;
// // 			 echo 'parent freq array = <pre>'.print_r($parent_freqs_array, true).'</pre>';
       }           


             // setup stuff for the calendar in the report
             $freqVal_dateTime = $freqVal->getFreqValue();		// i.e. getEndDate for weekly stats in app_cim_stats
             
             $freqVal_date = substr($freqVal_dateTime,0,10);
             $freqVal_time = substr($freqVal_dateTime,10);
//              list( $year, $month, $day ) = explode('-', $freqVal_date );
				 $dateFieldValues	= explode('-', $freqVal_date );
				 $timeFieldValues = explode(':', $freqVal_time );
//              $month = ltrim($month, "0");		// strips '0's from in front of $month...
             // $day = ltrim($day, "0");
             
             $dateTimeValues = array_merge($dateFieldValues,$timeFieldValues);
             
             $parentDateFieldVal = 0;
             if (isset($dateFieldValues)&&($date_field_id >= 0))
             {
            	 $parentDateFieldVal = $dateFieldValues[$date_field_id];
         	 }
             
             if ( $currentParentFreqVal != $parentDateFieldVal )		// i.e.
             {
                 // echo 'start new array<br/>';
                 $currentParentFreqVal = $parentDateFieldVal;
             }
//              echo 'parent val = '.$currentParentFreqVal;

             $currentParentFreqVal = ltrim($currentParentFreqVal,"0");	// trim any leading zeroes
             $parentDateValues[$parentIndex] = $currentParentFreqVal;




                  
        
      // Go through scope array and set template scope names for the scopes that were user-selected
      foreach( array_keys($this->scope_ref_array) as $scope_id )
      {
	      $scope_ref_id = current($this->scope_ref_array);
	      if ($scope_ref_id > 0)
	      {
		       switch ($scope_id)
		       {
			       case RowManager_ScopeManager::SCOPE_MINISTRY:
			       	$ministries = new RowManager_MinistryManager($scope_ref_id);
			       	$ministryList = $ministries->getListIterator();
			       	$ministryArray = $ministryList->getDataList();
			       	$record = current($ministryArray);
			       	
			       	$ministryName = $record['ministry_name'];
			       	$this->template->set('ministryName', $ministryName);
			       	break;
			       
			       case RowManager_ScopeManager::SCOPE_DIVISION:
			       	$divisions = new RowManager_DivisionManager($scope_ref_id);
			       	$divList = $divisions->getListIterator();
			       	$divArray = $divList->getDataList();
			       	$record = current($divArray);
			       	
			       	$divisionName = $record['division_name'];
			       	$this->template->set('divisionName', $divisionName);
			       	break;
			       
			       case RowManager_ScopeManager::SCOPE_REGION:
			       	$regions = new RowManager_StatsRegionManager($scope_ref_id);
			       	$regionList = $regions->getListIterator();
			       	$regionArray = $regionList->getDataList();
			       	$record = current($regionArray);
			       	
			       	$regionName = $record['region_desc'];
			       	$this->template->set('regionName', $regionName);
			       	break;			       	
			       
			       case RowManager_ScopeManager::SCOPE_LOCATION:
			       	$locations = new RowManager_LocationManager($scope_ref_id);
			       	$locationList = $locations->getListIterator();
			       	$locationArray = $locationList->getDataList();
			       	$record = current($locationArray);
			       	
			       	$locationName = $record['location_desc'];
			       	$this->template->set('locationName', $locationName);
			       	break;
		       	}
	       	}
	       	next($this->scope_ref_array);
       	}				       	
  
          
        
      /** Retrieve values for  $freqDesc   and   $measName **/ 
      $freqTypes = new RowManager_FreqTypeManager();
      $freqTypes->setFreqID($this->freq_id);
      
      $freqList = $freqTypes->getListIterator();
      $freqArray = $freqList->getDataList(); 
      
      $freqDesc = '';
      if (count($freqArray) == 1)	// should be only 1 frequency per id
      {
	      $record = current($freqArray);
	      $freqDesc = $record['freq_desc'];
      }
      
      $measTypes = new RowManager_MeasureTypeManager();
      $measTypes->setMeasureID($this->meas_id);
      
      $measList = $measTypes->getListIterator();
      $measArray = $measList->getDataList(); 
      
      $measName = '';
      if (count($measArray) == 1)	// should be only 1 measure type per id
      {
	      $record = current($measArray);
	      $measName = $record['meas_name'];
      }    
      
// set [Instr] label value replacement values
//       $instrVars = $freqDesc.','.$measName;
//       $this->template->set('instrVars', $instrVars);  

 		$this->template->set('measName', $measName);  
 		$this->template->set('freqName', $freqDesc);  
      
      
      $calcList = $this->calcManager->getListIterator();
      $calcArray = $calcList->getDataList();
      reset($calcArray);
      $calcNames = array();
      $i = 0;
      foreach( array_keys($calcArray) as $key )
      {
	      $record = current($calcArray);
	      $calcNames[$i] = $record['filter_name'];
	      next($calcArray);
	      $i++;
      }

	   // set the additional calculation values (i.e. 'Total', 'Average', etc)
	   $this->template->set('calcNames', $calcNames);    
	   
 		
        // uncomment this line if you are creating a template for this page
		$templateName = 'page_StatsReport.tpl.php';
		// otherwise use the generic site template
		//$templateName = '';
		
		return $this->template->fetch( $templateName );
        
    }
	
}

?>