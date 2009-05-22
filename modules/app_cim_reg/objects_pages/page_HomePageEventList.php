<?php
/**
 * @package cim_reg
 */ 
/**
 * class page_HomePageEventList 
 * <pre> 
 * A list of events that will be displayed on the module's home page
 * </pre>
 * @author Russ Martin
 * Date:   05 Jul 2007
 */
class  page_HomePageEventList extends PageDisplay_DisplayList {

	//CONSTANTS:
	
	/** The list of fields to be displayed */
    const DISPLAY_FIELDS = 'event_name,event_regEnd';
    
    /** The Multilingual Page Key for labels on this page */
    const MULTILINGUAL_PAGE_KEY = 'page_HomePageEventList';
    

	//VARIABLES:
	
	/** @var [OBJECT] The viewer object. */
	protected $viewer;
	
    /** @var [STRING] The path to this module's root directory. */
	protected $pathModuleRoot;
	
	    /** @var [STRING] The unique identifier of a person linked to registration process. */
	protected $person_id;			
	
	    /** @var [STRING] The unique identifier of a ministry linked to the events to be listed. */
	protected $ministry_id;				
	
	    /** @var [STRING] Whether or not any events are being shown */
	protected $isShowingEvents;		
	
	    /** @var [STRING] The SQL condition filtering by person's affiliated countries */
	protected $countrySearchCondition;	
	
	/** @var [STRING] The SQL condition filtering by event registration start and end date-times */
	protected $timeSearchCondition;				
	
	/** @var [INTEGER] The initilization value for the listManager. */
//	protected $managerInit;
/* no List Init Variable defined for this DAObj */
		
	
	//CLASS CONSTRUCTOR
	//************************************************************************
	/**
	 * function __construct
	 * <pre>
	 * Initialize the object.
	 * </pre>
	 * @param $pathModuleRoot [STRING] The path to the module's root dir.
	 * @param $viewer [OBJECT] The viewer object.
	 * @param $sortBy [STRING] Field data to sort listManager by.
     * @param $managerInit [INTEGER] Initialization value for the listManager.
	 * @return [void]
	 */
    function __construct($pathModuleRoot, $viewer, $sortBy, $person_id, $ministry_id = '' ) 
    {
        parent::__construct( page_HomePageEventList::DISPLAY_FIELDS );
        
        $this->pathModuleRoot = $pathModuleRoot;
        $this->viewer = $viewer;
        $this->sortBy = $sortBy;
        $this->person_id = $person_id;
        $this->ministry_id = $ministry_id;
                
//        $this->managerInit = $managerInit;


         /** Disable events from being shown if registration date&time have passed **/
         
         // Filter for shown events that have closed registration or have already started
// 		   $this->timeSearchCondition = '((event_regEnd < now()) or (event_startDate < now()))';
//          
//          $events0 = new RowManager_EventManager();
//          $events0->setOnHomePage('1');
//          $events0->addSearchCondition($this->timeSearchCondition);    
//          
//          $disable_events_list = $events0->getListIterator();
//          $disable_events_array = $disable_events_list->getDataList();

//          reset($disable_events_array);
//          foreach (array_keys($disable_events_array) as $k)	// go through all events and map user registered status
//          {          
//             $record = current($disable_events_array);	
//             $eventID = $record['event_id'];
//               			
//      			$event_updater = new RowManager_EventManager($eventID);
//      			
//      			$updateValues = array();
//      			$updateValues['event_onHomePage'] = '0';	// update the event row to DISABLE display
//      			$event_updater->loadFromArray( $updateValues );
//         		$event_updater->updateDBTable();	
//         			            
//             next($disable_events_array);
//          } 


			/*** Get the countries linked to the campuses that this viewer is associated with **/
		  $eventFilter = new MultiTableManager();
		  $assignments = new RowManager_AssignmentsManager();
		  $assignments->setPersonID($this->person_id);
		  $campuses = new RowManager_CampusManager();
		  $regions = new RowManager_RegionManager();
		  $countries = new RowManager_CountryManager();
		  
		  $eventFilter->addRowManager($countries);
		  $eventFilter->addRowManager($regions, new JoinPair($countries->getJoinOnCountryID(), $regions->getJoinOnCountryID()));
		  $eventFilter->addRowManager($campuses, new JoinPair($regions->getJoinOnRegionID(), $campuses->getJoinOnRegionID()));
		  $eventFilter->addRowManager($assignments, new JoinPair($assignments->getJoinOnCampusID(), $campuses->getJoinOnCampusID()));
		  
		  $countryList = $eventFilter->getListIterator();
		  $countryArray = $countryList->getDataList();
		  
		  $country_filter = '';
		  reset($countryArray);
		  foreach( array_keys($countryArray) as $k)
		  {
			  $record = current($countryArray);
			  $country_filter .= $record['country_id'].',';
			  
			  next($countryArray);
		  }
		  $country_filter = substr($country_filter,0,-1);		          

        $dataAccessObject = new RowManager_EventManager();
        // only display those rows that are supposed to be displayed on the home page
        $dataAccessObject->setOnHomePage( true );
        if ($this->ministry_id != '')
        {
	        $dataAccessObject->setMinistryID($this->ministry_id);
        }       
        
        if ($country_filter == '')
        {
	        $country_filter = 1;
        }
        $this->countrySearchCondition = 'country_id in ('.$country_filter.')';
        $dataAccessObject->addSearchCondition( $this->countrySearchCondition );
        $dataAccessObject->setSortOrder( $sortBy );
//        $this->listManager = new EventList( $sortBy );
        $this->listManager = $dataAccessObject->getListIterator();

        $events_array = $this->listManager->getDataList();                          
         if (count($events_array)> 0)
         {
            $this->isShowingEvents = true;
         }
         else
         {
            $this->isShowingEvents = false;
         }  
                 
         // now initialize the labels for this page
         // start by loading the default field labels for this Module
         $languageID = $viewer->getLanguageID();
         $seriesKey = modulecim_reg::MULTILINGUAL_SERIES_KEY;
         $pageKey = modulecim_reg::MULTILINGUAL_PAGE_FIELDS;
         $this->labels = new MultilingualManager( $languageID, $seriesKey, $pageKey );
         
         // then load the page specific labels for this page
         $pageKey = page_HomePageEventList::MULTILINGUAL_PAGE_KEY;
         $this->labels->loadPageLabels( $pageKey );
         
         $this->labels->setSeriesKey( SITE_LABEL_SERIES_SITE );
         $this->labels->loadPageLabels( SITE_LABEL_PAGE_FORM_LINKS );
         
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
    
        // Make a new Template object
        $path = SITE_PATH_TEMPLATES;
        // Replace $path with the following line if you want to create a
        // template tailored for this page:
        //$path = $this->pathModuleRoot.'templates/';
        
        
        // store the link values
        // $this->linkValues[ 'view' ] = 'add/new/href/data/here';

        
        // store the link labels
        $this->linkLabels[ 'add' ] = $this->labels->getLabel( '[Add]' );
        $this->linkLabels[ 'edit' ] = $this->labels->getLabel( '[Edit]' );
        $this->linkLabels[ 'del'  ] = $this->labels->getLabel( '[Delete]' );
        $this->linkLabels[ 'cont' ] = $this->labels->getLabel( '[Continue]');
        // $this->linkLabels[ 'view' ] = 'new link label here';

        
        // store any additional link Columns
        // example:
            //$title = $this->labels->getLabel( '[title_groups]');
            //$columnLabel = $this->labels->getLabel( '[groups]');
            //$link = $this->linkValues[ 'groups' ];
            //$fieldName = 'accessgroup_id';
            //$this->addLinkColumn( $title, $columnLabel, $link, $fieldName);
            
            // echo "<pre>".print_r($this->linkValues, true)."</pre>";
   
            $title = $this->labels->getLabel( '[Details]');
            $columnLabel = $this->labels->getLabel( '[View]');
            $link = $this->linkValues[ 'view' ];
            $fieldName = 'event_id';
            $this->addLinkColumn( $title, $columnLabel, $link, $fieldName);

                
            $REGISTERED = 2;	//'true';
            $INCOMPLETE = 1;
            $NOT_REGISTERED = 0;	//'false';            
            
              /**  determine which events the user has already registered for...  **/
            $events = new RowManager_EventManager();
            $events->setOnHomePage('1');
            $events->addSearchCondition($this->countrySearchCondition);
//             $events->setSortOrder( $this->sortBy );	// needed to sync lists
            $regs = new RowManager_RegistrationManager();
            $regs->setPersonID($this->person_id);           
            $status = new RowManager_StatusManager();
            $status->setStatusDesc(RowManager_StatusManager::REGISTERED);
            
            $reg_events = new MultiTableManager();
            $reg_events->addRowManager($events);
            $reg_events->addRowManager($regs, new JoinPair( $events->getJoinOnEventID(), $regs->getJoinOnEventID() ));
            $reg_events->addRowManager($status, new JoinPair( $regs->getJoinOnStatus(), $status->getJoinOnStatusID()));
            
            if ((!isset($this->sortBy))||$this->sortBy == '')
            {
	            $this->sortBy = 'event_id';
            }
            $reg_events->setSortOrder($this->sortBy );// needed to sync lists
            
//             echo "reg events sql = ".$reg_events->createSQL();
            
            $regs_events_list = $reg_events->getListIterator();
            $regs_events_array = $regs_events_list->getDataList();
          
            
            /** determine which events the user has PARTIALLY completed registration for ***/
            $events2 = new RowManager_EventManager();
            $events2->setOnHomePage('1');
            $events2->addSearchCondition($this->countrySearchCondition);
//             $events->setSortOrder( $this->sortBy );	// needed to sync lists
            $regs2 = new RowManager_RegistrationManager();
            $regs2->setPersonID($this->person_id);
            $status2 = new RowManager_StatusManager();
            $status2->setStatusDesc(RowManager_StatusManager::INCOMPLETE);
            
            $reg_events2 = new MultiTableManager();
            $reg_events2->addRowManager($events2);
            $reg_events2->addRowManager($regs2, new JoinPair( $events2->getJoinOnEventID(), $regs2->getJoinOnEventID() ));
            $reg_events2->addRowManager($status2, new JoinPair( $regs2->getJoinOnStatus(), $status2->getJoinOnStatusID()));
            
            $reg_events2->setSortOrder($this->sortBy );// needed to sync lists
            
//             echo "reg events sql = ".$reg_events->createSQL():
            
            $incomplete_regs_events_list = $reg_events2->getListIterator();
            $incompete_regs_events_array = $incomplete_regs_events_list->getDataList();            
//            echo '<pre>'.print_r($incompete_regs_events_array, true).'</pre>';
          
            
            // get full event-listing for mapping isRegistered to
            $allEvents = $this->listManager->getDataList(); 
//             
//           echo 'reg events = <pre>'.print_r($regs_events_array,true).'</pre><br>';
//             echo 'all events = <pre>'.print_r($allEvents, true).'</pre><br>';
            
            $eventName_isReg_array = array();
            reset($regs_events_array);
            reset($incompete_regs_events_array);
            reset($allEvents);
            foreach (array_keys($allEvents) as $k)	// go through all events and map user registered status
            {
	            $record = current($allEvents);
	            $currentEvent = $record['event_id'];
	            
	            $record2 = current($regs_events_array);
	            $currentRegEvent = $record2['event_id'];
	            
	            $record3 = current($incompete_regs_events_array);
	            $currentIncRegEvent = $record3['event_id'];
	            
	            $eventName = $record['event_name'];
	            
	            // store event in registered array if mapping found
	            if ($currentEvent == $currentRegEvent)
	            {
	            	$eventName_isReg_array[$eventName] = $REGISTERED;
	            	next($regs_events_array);
            	}
            	else if ($currentEvent == $currentIncRegEvent)
            	{
	            	$eventName_isReg_array[$eventName] = $INCOMPLETE;
	            	next($incompete_regs_events_array);
            	}	  
            	else            	
            	{
	            	$eventName_isReg_array[$eventName] = $NOT_REGISTERED;
            	}	            	
	            
					next($allEvents);
            }

//             echo "events: <PRE>".print_r($eventName_isReg_array,true)."</PRE>";
   
            $title = $this->labels->getLabel( '[RegisterAccess]');
            $columnLabels = array();
            $columnLabels[$NOT_REGISTERED] = $this->labels->getLabel( '[Register]');
            $columnLabels[$INCOMPLETE] = $this->labels->getLabel( '[FinishReg]');
            $columnLabels[$REGISTERED] = $this->labels->getLabel( '[EditReg]');		// formerly [CancelReg]
            
            $links = array();
            $links[$NOT_REGISTERED] = $this->linkValues[ 'register' ];
            $links[$INCOMPLETE] = $this->linkValues[ 'complete' ];
            $links[$REGISTERED] = $this->linkValues[ 'edit_reg' ];		// formerly 'cancel'
            
            // field column names to map to link name (i.e. filter by event to determine if link name should change based on reg status)
            $fieldNames = array();
            $fieldNames[$NOT_REGISTERED] = 'event_id';
            $fieldNames[$INCOMPLETE] = 'event_id';
            $fieldNames[$REGISTERED] = 'event_id';

//  OLD:           $this->addLinkColumn( $title, $columnLabel, $link, $fieldName,  $useAlt, $alt_label, $link_alt, $fieldAlt);  
				$this->addDynamicLinkColumn( $title, $columnLabels, $links, $fieldNames);         

         // link an array of filters to a particular link column
        $linkColumnFilter[$title] = $eventName_isReg_array;
//          echo '<pre>'.print_r($linkColumnFilter, true).'</pre>';
          
            
        // store the page labels
        // NOTE: use this location to update any label tags ...
        // example:
            // $name = $user->getName();
            // $this->labels->setLabelTag( '[Title]', '[userName]', $name);
            
        
        $this->prepareTemplate( $path );
        
        // set the filter list used to determine which events have 'register' links and which have 'cancel' links
        $this->template->set( 'linkColumnFilter', $linkColumnFilter);
        
        // store the Row Manager's XML Node Name
        $this->template->set( 'rowManagerXMLNodeName', RowManager_EventManager::XML_NODE_NAME );
        
        // store the primary key field name for the data being displayed
        $this->template->set( 'primaryKeyFieldName', 'event_id');


        /*
         *  Set up any additional data transfer to the Template here...
         */
        $this->template->set( 'disableHeading', true );
   
        $templateName = 'siteDataList.php';
		// if you are creating a custom template for this page then 
		// replace $templateName with the following:
		//$templateName = 'page_HomePageEventList.php';
		
		return $this->template->fetch( $templateName );
        
    }
    
    public function isShowingEvents()
    {
	    return $this->isShowingEvents;
    }
    
    
}

?>