<?php
/**
 * @package cim_hrdb
 */ 
/**
 * class page_ViewCustomReport
 * <pre> 
 * A simple page to display a custom report generated from cim_hrdb_customfields table
 * </pre>
 * @author CIM Team
 * Date:   31 Mar 2008
 */
class  page_ViewCustomReport extends PageDisplay_DisplayList {

	//CONSTANTS:
	const DIRECTOR = -1;
	const UNAUTHORIZED_DIRECTOR = -2;
 	const NON_DIRECTOR = -3;
 	const SUPERADMIN = -4;
 	
 	const NO_FIELDS_SET = -9;
 	
 	const JOIN_FIELD = 'person_id';
	
	/** The list of fields to be displayed */
    const DISPLAY_FIELDS = 'person_id,value0,value1,value2';		//fields_id,fieldvalues_value';
    
    /** The Multilingual Page Key for labels on this page */
    const MULTILINGUAL_PAGE_KEY = 'page_ViewCustomReport';
    

	//VARIABLES:
	
	/** @var [STRING] The path to the module's root directory. */
	protected $pathModuleRoot;
	
	/** @var [OBJECT] The Viewer Object. */
	protected $viewer;
	
	/** @var [STRING] The sorting key. */
	protected $sortBy;	
		
    /** @var [STRING] The initialization data for the dataManager. */
	protected $fieldvalues_id;
	
	/** @var [INTEGER] Foreign Key needed by Data Manager */
	protected $fields_id;
	
	/** @var [ARRAY] Stores the field ids used by this custom report */
	protected $fields_id_array;	

	/** @var [INTEGER] Foreign Key needed by Data Manager */
	protected $person_id;
	
	/** @var [INTEGER] Foreign Key needed by Data Manager */
	protected $customreport_id;	
	
	/** @var [INTEGER] Foreign Key needed by Data Manager */
// 	protected $staffschedule_id;		


	/** @var [ARRAY] array mapping form labels to fieldvalues_ids*/
	protected $formFieldToValueIDmapper;
	
	/** @var [ARRAY] array mapping form labels to field_ids*/
	protected $formFieldToFieldIDmapper;
	
	/** @var [ARRAY] array storing the list labels */
	protected $listLabels;	

	/** @var [BOOLEAN] whether or not to disable heading (i.e. for use as a sub-page) */
	protected $disable_heading;

	/** @var [INTEGER] The access level of the current viewer */	
	protected $access_level;			
	
	/** @var [BOOLEAN] whether or not the page was loaded in error */
	protected $is_blank_page;	
	
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
    function __construct($pathModuleRoot, $viewer, $customreport_id, $disable_heading = false) 	//, $fieldvalues_id ='', $fields_id='', 
    {
	    $this->is_blank_page = false;
	     $this->disable_heading = $disable_heading;
        
		  // store field display types
        $DISPLAY_FIELDS = $this->getDisplayFields($customreport_id);
        parent::__construct($DISPLAY_FIELDS);  
//         parent::__construct( page_ViewCustomReport::DISPLAY_FIELDS );
      
        $this->pathModuleRoot = $pathModuleRoot;
        $this->viewer = $viewer;       
        $this->disableHeading = $disable_heading;
        
        $this->customreport_id = $customreport_id;  
        $this->fields_id_array = array(); 
        $this->listLabels = array();
        
        // Get fields for the custom report; required for retrieving data in column format
//         $columns = 'customfields_id,report_id,cim_hrdb_customfields.fields_id,count(person_id)';
        $groupBy = 'cim_hrdb_customfields.fields_id';
        $dbFunction = 'COUNT';
        $funcParam = 'person_id';

        $reportFields = new MultiTableManager();        
        $customfields = new RowManager_CustomFieldsManager();
        $customfields->setReportID($this->customreport_id);		// TODO?  error checking on ID
        $fieldvalues = new RowManager_FormFieldValueManager();
        
        $reportFields->addRowManager($customfields);
        $reportFields->addRowManager($fieldvalues, new JoinPair( $customfields->getJoinOnFieldID(), $fieldvalues->getJoinOnFieldID()));
        
                // use GROUP BY and $dbFunction = 'COUNT' to quickly get summary data per campus
        if ($groupBy != '') {
        		$reportFields->setGroupBy($groupBy);	//'campus_desc');
     		}
     		
     		if ($dbFunction != '') {
		     	$reportFields->setFunctionCall($dbFunction,$funcParam);
	     	}
	     	$reportFields->setSortOrder('COUNT(person_id) DESC');

	     	
// 	     $reportFields->setFieldList($columns);
        
        $customFieldsList = $reportFields->getListIterator();
        $customFieldsArray = $customFieldsList->getDataList();
        
//         echo '<pre>'.print_r($customFieldsArray,true).'</pre>';

        
        $i = 0;
        foreach (array_keys($customFieldsArray) as $key)
        {
	        $record = current($customFieldsArray);
        	  $this->fields_id_array[$i] = $record['fields_id'];
        	  $i++;	next($customFieldsArray);
     	  }
     	  
     	  // Ensure that the custom report has been given at least one field
     	  if (count($this->fields_id_array) > 0)
     	  {
     	  
	       
	       // Default sorting: by person name, since this is the only standard field
	       $this->sortBy = 'person_lname,person_fname';		// TODO: need to add person table to allow person_name sorting
	
	       
	        // Now load the access Privilege manager of this viewer
	        $this->adminManager = new RowManager_AdminManager( );
	
	        // Get the person ID
	        $accessManager = new RowManager_AccessManager( );
	        $accessManager->loadByViewerID( $this->viewer->getViewerID( ) );
	        $personID = $accessManager->getPersonID();
	
	        // Get the permissions the person has.
	        $this->adminManager->loadByPersonID( $personID );
	        $directed_staff = '';
	        $directed_people = '';
	        
	        // Super-admin
	        if ( $this->adminManager->hasSitePriv()  )
	        {
					$this->access_level = page_ViewCustomReport::SUPERADMIN;	  	  	
					
	        }        
	        else if ( $this->adminManager->isStaff($viewer->getID()) )	// Staff
	        {
		        $director_id = $this->getStaffIDfromViewerID();
		        	        
		        $staffManager = new RowManager_StaffDirectorManager();
		        $staffManager->setDirectorID($director_id);
	
		        
					/* Retrieve all directors under the current director */
		        $hierarchy_result = $staffManager->getDirectorHierarchy($director_id);	        
		        $hierarchy_result->setFirst();
		        $hierarchy_array = array();
		        $directed_staff = '';
	           while( $hierarchy_result->moveNext() ) {
		           $staff_ids = $hierarchy_result->getCurrentRow();
	// 	           echo 'array = <pre>'.print_r($hierarchy_array,true).'</pre>';
	
						for ($lvl = 1; $lvl <= MAX_DIRECTOR_LEVELS; $lvl++)
						{
							$staff_id = $staff_ids['staff_lvl'.$lvl];
							if ($staff_id != null)
							{
								$directed_staff .= $staff_id.',';
							}
						}					
	           }   
	           if ($directed_staff != '')	// if staff found under director, then simply remove comma
	           {
		          $directed_staff = substr( $directed_staff, 0, -1 );
		          $this->access_level = page_ViewCustomReport::DIRECTOR;
	           }    
	           else 	// Stop any sub-query errors or accidental loosing of control
	           {
		          $directed_staff = page_ViewCustomReport::NON_DIRECTOR;
		          $this->access_level = page_ViewCustomReport::NON_DIRECTOR;
	           }    	                   
	           
	           $personGetter = new MultiTableManager();
		        $person_info = new RowManager_PersonManager();
		        $staff = new RowManager_StaffManager();
		        $personGetter->addRowManager($person_info);
		        $personGetter->addRowManager($staff, new JoinPair($staff->getJoinOnPersonID(), $person_info->getJoinOnPersonID()));
		        $personGetter->addSearchCondition('staff_id in ('.$directed_staff.')');
		        
		        $staffPersonList = $personGetter->getListIterator();
		        $staffPersonArray = $staffPersonList->getDataList();
				  foreach( array_keys($staffPersonArray) as $key)
				  {
					  $record = current($staffPersonArray);
					  $directed_people .= $record['person_id'].',';
					  next($staffPersonArray);
				  }
				  $directed_people = substr($directed_people,0,-1);	//remove last comma
				  
	  		  }
	  		  else {
		  		  
		  		  $this->access_level = page_ViewCustomReport::UNAUTHORIZED_DIRECTOR;    
	        }        
		             
	        
	        // Retrieve custom report fields and store them in data columns for easy display
			  $dataAccessObject = new MultiTableManager();
			  $person_manager = new RowManager_PersonManager();
			  $dataAccessObject->addRowManager($person_manager);
			  
			  $fieldList = '';
			  $temp_tables = array();
			  for ($i=0; $i < count($this->fields_id_array); $i++)
			  {
				  $tempTableCreationSQLmaker = new MultiTableManager();
				  $fieldvalue_manager = new RowManager_FormFieldValueManager();
				  $fieldvalue_manager->setFieldID($this->fields_id_array[$i]);
				  
	// 			  if ($this->access_level == page_ViewCustomReport::UNAUTHORIZED_DIRECTOR)
	// 			  {				  
	//  			  		$fieldvalue_manager->setPersonID($personID);		// only show staff's own data
	// 		  	  }
	// 		  	  else if ($this->access_level == page_ViewCustomReport::DIRECTOR)
	// 		  	  {
	// 					$fieldvalue_manager->addSearchCondition('person_id in ('.$directed_people.')');		  	  
	// 		  	  }
	// 		  	  else if ($this->access_level == page_ViewCustomReport::NON_DIRECTOR)		// director with no underlings
	// 		  	  {
	// 			  	  $fieldvalue_manager->setPersonID($personID);		// only show staff's own data
	// 		  	  }		  	  
	// 		  	  else if ($this->access_level == page_ViewCustomReport::SUPERADMIN)
	// 		  	  {
	// 			  	  // no restrictions
	// 		  	  }
			  	  
			  	  // Create a temporary table from a SQL join retrieving the data for a particular form field
				  $tempTableCreationSQLmaker->addRowManager($fieldvalue_manager);
				  $fields_manager = new RowManager_FormFieldManager();
				  $tempTableCreationSQLmaker->addRowManager($fields_manager, new JoinPair($fieldvalue_manager->getJoinOnFieldID(), $fields_manager->getJoinOnFieldID()));
				  $customfields_manager = new RowManager_CustomFieldsManager();
				  $customfields_manager->setReportID($this->customreport_id);
				  $tempTableCreationSQLmaker->addRowManager($customfields_manager, new JoinPair($fieldvalue_manager->getJoinOnFieldID(),$customfields_manager->getJoinOnFieldID()));
				  $tempFieldList = 'person_id,fieldvalues_value';
				  $tempTableCreationSQLmaker->setFieldList($tempFieldList);
				  
				  $tempTableCreationSQL = $tempTableCreationSQLmaker->createSQL();
				  
				  $temp_tables[$i] = new TempTableManager( 'temptable'.$i, $tempTableCreationSQL, $tempFieldList, 'temptable'.$i); //$PRIMARY_ID=-1
				  $temp_tables[$i]->createTable(true);
				  
				  
				  // Join the temporary tables together to get a table of n+1 columns where n = count($this->field_ids_array) and the extra column stores person_id
				  if ($i > 0)
				  {
					  $fieldList .= ',temptable'.$i.'.fieldvalues_value as value'.$i;
					  $i_minus = $i - 1;
			  	  		$dataAccessObject->addRowManager($temp_tables[$i], new JoinPair($temp_tables[$i_minus]->getJoinOnFieldX(page_ViewCustomReport::JOIN_FIELD), $temp_tables[$i]->getJoinOnFieldX(page_ViewCustomReport::JOIN_FIELD), JOIN_TYPE_LEFT));
	  	  		  }
	  	  		  else {
		  	  		  $fieldList .= 'cim_hrdb_person.person_id,temptable'.$i.'.fieldvalues_value as value'.$i;
		  	  		  $dataAccessObject->addRowManager($temp_tables[0], new JoinPair($person_manager->getJoinOnFieldX(page_ViewCustomReport::JOIN_FIELD), $temp_tables[0]->getJoinOnFieldX(page_ViewCustomReport::JOIN_FIELD)));
	  	  		  }	  
		  	  }
	
		  	  // Filter results by directed people IDs (if viewer is NOT super-admin)
		  	  if ($this->access_level != page_ViewCustomReport::SUPERADMIN)
		  	  {
		  	  
// 			  	  for ($i=0; $i < count($this->fields_id_array); $i++)
// 				  {	  	  
// 					  if ($this->access_level == page_ViewCustomReport::UNAUTHORIZED_DIRECTOR)
// 					  {				  
// 						  	$dataAccessObject->addSearchCondition('temptable'.$i.'.person_id in ('.$personID.')');			// only show staff's own data
// 				  	  }
// 				  	  else if ($this->access_level == page_ViewCustomReport::DIRECTOR)
// 				  	  {		  
// 							$dataAccessObject->addSearchCondition('temptable'.$i.'.person_id in ('.$directed_people.')');		  	  
// 				  	  }
// 				  	  else if ($this->access_level == page_ViewCustomReport::NON_DIRECTOR)		// director with no underlings
// 				  	  {
// 						  	$dataAccessObject->addSearchCondition('temptable'.$i.'.person_id in ('.$personID.')');			// only show staff's own data
// 				  	  }	
// 			  	  }
					$dataAccessObject->addSearchCondition('cim_hrdb_person.person_id in ('.$directed_people.')');
		  	  }	  	  
	  
	// 	  	  echo '<pre>'.print_r($temp_tables[0]->getListIterator()->getDataList(),true).'</pre>';
	// $temp_tables[0]->db->runSQL('select * from temptable0');
		  	  
			  $dataAccessObject->setFieldList($fieldList);
			  $dataAccessObject->setSortOrder($this->sortBy);
		     $this->listManager = $dataAccessObject->getListIterator();	        

// 			echo '<pre>'.print_r($this->listManager->getDataList(),true).'</pre>';
			}
			else		// if custom report doesn't have any assigned fields
			{
			  	  $dataAccessObject = new MultiTableManager();
				  $person_manager = new RowManager_PersonManager();
				  $person_manager->setPersonID(page_ViewCustomReport::NO_FIELDS_SET);
				  $dataAccessObject->addRowManager($person_manager);
				  $dataAccessObject->setSortOrder($this->sortBy);
			     $this->listManager = $dataAccessObject->getListIterator();
			     
			     $this->is_blank_page = true;	
		   }				
         
         // now initialize the labels for this page
         // start by loading the default field labels for this Module
         $languageID = $viewer->getLanguageID();
         $seriesKey = modulecim_hrdb::MULTILINGUAL_SERIES_KEY;
         $pageKey = modulecim_hrdb::MULTILINGUAL_PAGE_FIELDS;
         $this->labels = new MultilingualManager( $languageID, $seriesKey, $pageKey );
         
         // then load the page specific labels for this page
         $pageKey = page_ViewCustomReport::MULTILINGUAL_PAGE_KEY;
         $this->labels->loadPageLabels( $pageKey );
         
         $this->labels->setSeriesKey( SITE_LABEL_SERIES_SITE );
         $this->labels->loadPageLabels( SITE_LABEL_PAGE_FORM_LINKS );
         
        $this->listLabels = $this->getListLabels($this->customreport_id);		// NOTE: parameter *required*
//        foreach (array_keys($this->listLabels,true) as $key)
//        {
// 	       $label = current($this->listLabels);
//        	 $this->labels->setLabelTag('[title_value0]', '<title in tool_setup>', 'Monthly Support Goal');   // NOTE: cannot be used because nothing set in tool_setup

//        echo 'labels = <pre>'.print_r($this->listLabels,true).'</pre>';         
         
         
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
        //$path = SITE_PATH_TEMPLATES;
        // Replace $path with the following line if you want to create a
        // template tailored for this page:
        $path = $this->pathModuleRoot.'templates/';
        
        
        // store the link values
        // $this->linkValues[ 'view' ] = 'add/new/href/data/here';

        
        // store the link labels
//         $this->linkLabels[ 'add' ] = $this->labels->getLabel( '[Add]' );
//         $this->linkLabels[ 'edit' ] = $this->labels->getLabel( '[Edit]' );
//         $this->linkLabels[ 'del'  ] = $this->labels->getLabel( '[Delete]' );
//         $this->linkLabels[ 'cont' ] = $this->labels->getLabel( '[Continue]');
        // $this->linkLabels[ 'view' ] = 'new link label here';
        
        $this->linkLabels[ 'DownloadCustomReportCSV' ] = $this->labels->getLabel( '[DownloadCustomReportCSV]' );

        
        // store any additional link Columns
        // example:
            //$title = $this->labels->getLabel( '[title_groups]');
            //$columnLabel = $this->labels->getLabel( '[groups]');
            //$link = $this->linkValues[ 'groups' ];
            //$fieldName = 'accessgroup_id';
            //$this->addLinkColumn( $title, $columnLabel, $link, $fieldName);

        
        // store the page labels
        // NOTE: use this location to update any label tags ...
        // example:
            // $name = $user->getName();
            // $this->labels->setLabelTag( '[Title]', '[userName]', $name);
            
        
        $this->prepareTemplate( $path );
        
        // Set the custom labels for the data columns
        $this->template->set( 'listLabels', $this->listLabels );  
//         $this->template->set( 'dataFieldList', $this->getFieldArray($this->customreport_id));                     

   
        // store the Row Manager's XML Node Name
//         $this->template->set( 'rowManagerXMLNodeName', MultiTableManager::XML_NODE_NAME );
        $this->template->set( 'rowManagerXMLNodeName', $this->listManager->getRowManagerXMLNodeName() );
      
             
        // Store the XML Node name for the Data Access Field List
//         $xmlNodeName = $this->dataList->getRowManagerXMLNodeName();
//         $this->template->set( 'rowManagerXMLNodeName', $xmlNodeName);       
// //         $xmlNodeName = RowManager_FormFieldValueManager::XML_NODE_NAME;
// //         $this->template->set( 'rowManagerXMLNodeName', $xmlNodeName);
//         $this->template->setXML( 'dataList', $this->dataList->getXML() );	 
//         
        
        // store the primary key field name for the data being displayed
        $this->template->set( 'primaryKeyFieldName', 'person_id');
        
        // disable the heading?
        $this->template->set( 'disableHeading', $this->disableHeading ); 

        
        // Set page sub-heading (i.e. activity type filter)
        if ($this->customreport_id != '')
        {
	        $customReports = new RowManager_CustomReportsManager($this->customreport_id);
	        $sub_heading = $customReports->getReportName();
	        
 		  		$this->template->set( 'subheading', $sub_heading);
	  	  }

        /*
         *  Set up any additional data transfer to the Template here...
         */
         $person_manager = new RowManager_PersonManager();
         $person_list = $person_manager->getListIterator();
         $person_manager->setLabelTemplateLastNameFirstName();        
         $personArray = $person_list ->getDropListArray();   
         
          /** Create and store download CSV link **/ 
        if ($this->is_blank_page == false)
        {          
	        $downloadLink = array();
			  $downloadLink[ 'DownloadCustomReportCSV' ]  = $this->linkValues[ 'DownloadCustomReportCSV' ];
			          
			  $this->template->set('linkLabels', $this->linkLabels);
	        $this->template->set('downloadLink', $downloadLink );         
        }
          
         $this->template->set( 'list_person_id', $personArray );
         
        
   
//         $templateName = 'siteDataList_dynamic.php';
		// if you are creating a custom template for this page then 
		// replace $templateName with the following:
		$templateName = 'page_ViewCustomReport.tpl.php';
		
		return $this->template->fetch( $templateName );
        
    }
    

    
    
 /*** HELPER METHODS ***/   
 
 	/**
	 * Function getDisplayFields
	 * The function used to get display fields
	 *
	 * @param [INTEGER]   $reportID      the id specifying the custom report to be used
	 *
	 * @return [ARRAY] an array containing the fields displayed in table below form (i.e. the repeatable form fields)
	 **/
	protected function getDisplayFields($reportID='')
	{
		 $TRUE = 0;
		 $FALSE = 1;
		 $skip = '';
		 
		 $displayList = 'person_id';

       $valuesArray = $this->getFieldArray($reportID);	
       
//        echo 'values = <pre>'.print_r($valuesArray,true).'</pre>';
       
       // go through results and store field descriptions as the form field labels
       // start from the first available un-used index
       $idx = 0;	//$this->total_nonrepeatable_fields;
       reset($valuesArray);
		foreach(array_keys($valuesArray) as $k)
		{
		   $fieldValue = current($valuesArray);
		   
		   $displayList .= ',value'.$idx;		//$fieldValue['fields_desc']
		
		   $idx++;
			next($valuesArray);
		}	
// 		if (count($valuesArray) > 0) {
// 			$displayList = substr($displayList,0,-1);
// 		}
// 		$displayList .= 'list_name';	//substr($fieldList,0,-1);	// remove final comma

				
		return $displayList;	// return list of form fields generated from event-specific fields
    }
    
     
 	// get custom labels for custom report display list
   protected function getListLabels($reportID) 
	{    
		$labelsArray = array();
         
		$isRepeatable = true;
      $valuesArray = $this->getFieldArray($reportID);
       
       // go through results and store field descriptions as the column display labels
      $idx = 0;				
      reset($valuesArray);
		foreach(array_keys($valuesArray) as $k)
		{
		   $fieldValue = current($valuesArray);
		   
		   $labelsArray['title_value'.$idx] = $fieldValue['fields_desc'];
		
		   $idx++;
			next($valuesArray);
		}	
		$labelsArray['title_person_id'] = 'Person Name';	// STANDARD FIELD LABEL
		
		return $labelsArray;	// return array of form field labels generated from event-specific fields
	} 	
	

	
    // return array of database records from field tables: cim_reg_fields, cim_reg_fieldtypes
    protected function getFieldArray($reportID='') 
 	 {
// 	 	 $FALSE = 0;
        $groupBy = 'cim_hrdb_fields.fields_id';
        $dbFunction = 'COUNT';
        $funcParam = 'person_id';
	 	 
		 $fields = new RowManager_FormFieldManager();
//		 $fvalues = new RowManager_FieldValueManager();
		 $ftypes = new RowManager_FieldTypeManager();
		 
// 		 $custom_reports = new RowManager_CustomReportsManager();	//$reportID
		 $custom_fields = new RowManager_CustomFieldsManager();	//$reportID		 
		 if ($reportID != '')
		 {
		 	$custom_fields->setReportID($reportID);
	 	 }
	 	 
	 	 $fieldvalues = new RowManager_FormFieldValueManager();		// "NEW" (in order to sort fields by # of values)

		 
// 		 echo "personID = ".$personID;
		 
// 		 if ($formID != '') 
// 		 {
// 			 	$fields->setFormID($formID);
// 		 		//$fvalues->setRegID($regID);
// 	    }

		 $fieldInfo = new MultiTableManager();
		 $fieldInfo->addRowManager($fields);
//		 $fieldInfo->addRowManager($fvalues, new JoinPair($fvalues->getJoinOnFieldID(), $fields->getJoinOnFieldID()));
		 $fieldInfo->addRowManager($ftypes, new JoinPair($fields->getJoinOnFieldTypeID(), $ftypes->getJoinOnFieldTypeID()));
		 $fieldInfo->addRowManager($custom_fields, new JoinPair($custom_fields->getJoinOnFieldID(), $fields->getJoinOnFieldID()));
		 $fieldInfo->addRowManager($fieldvalues, new JoinPair($fieldvalues->getJoinOnFieldID(), $fields->getJoinOnFieldID()));

        // use GROUP BY and $dbFunction = 'COUNT' to sort fields by # of values
        if ($groupBy != '') {
        		$fieldInfo->setGroupBy($groupBy);	//'campus_desc');
     		}
     		
     		if ($dbFunction != '') {
		     	$fieldInfo->setFunctionCall($dbFunction,$funcParam);
	     	}
	     	$fieldInfo->setSortOrder('COUNT(person_id) DESC');		 
		 
// 		 $fieldInfo->setSortOrder('fields_priority');
// 		 echo $fieldInfo->createSQL();
		 
       $valuesIterator = $fieldInfo->getListIterator(); 
       $valuesArray = $valuesIterator->getDataList();	
       
// 		 echo "values:<br><pre>".print_r($valuesArray,true)."</pre>";

       // map the fields_id of each field values row to the label of that particular form field
//         $idx = 0;
//         reset($valuesArray);
//         	foreach(array_keys($valuesArray) as $k)
// 			{
// 				$record = current($valuesArray);				
// 				
// 				// store mapping associating form field label with fields_id
// 				$this->formFieldToFieldIDmapper['form_field'.$idx] = $record['fields_id'];			
// 			
// 				next($valuesArray);
// 				$idx++;
// 			} 

//  		 echo "field id values:<br><pre>".print_r($this->formFieldToFieldIDmapper,true)."</pre>";



        $reportFields = new MultiTableManager();        
        $customfields = new RowManager_CustomFieldsManager();
        $customfields->setReportID($this->customreport_id);		// TODO?  error checking on ID
        $fieldvalues = new RowManager_FormFieldValueManager();
        
        $reportFields->addRowManager($customfields);
        $reportFields->addRowManager($fieldvalues, new JoinPair( $customfields->getJoinOnFieldID(), $fieldvalues->getJoinOnFieldID()));
        
                // use GROUP BY and $dbFunction = 'COUNT' to quickly get summary data per campus
        if ($groupBy != '') {
        		$reportFields->setGroupBy($groupBy);	//'campus_desc');
     		}
     		
     		if ($dbFunction != '') {
		     	$reportFields->setFunctionCall($dbFunction,$funcParam);
	     	}
	     	$reportFields->setSortOrder('COUNT(person_id) DESC');


					
       return $valuesArray;       
	}		
	
 
        // self-explanatory: system user == potential approval-qualified staff director
    protected function getStaffIDfromViewerID()
    {
	    $staffViewer = new MultiTableManager();
	    
       $accessPriv = new RowManager_AccessManager();
       $accessPriv->setViewerID($this->viewer->getID());      
       $staff = new RowManager_StaffManager();
       
       $staffViewer->addRowManager($staff);
       $staffViewer->addRowManager($accessPriv, new JoinPair($staff->getJoinOnPersonID(), $accessPriv->getJoinOnPersonID()));
       
       $staffViewerList = $staffViewer->getListIterator();
       $staffViewerArray = $staffViewerList->getDataList();
       
       $staffID = '';
       reset($staffViewerArray);
       foreach (array_keys($staffViewerArray) as $k)
       {
       	$record = current($staffViewerArray);
       	$staffID = $record['staff_id'];	// can only be 1 staff_id per viewer_id
       	next($staffViewerArray);
    	 }
       
       return $staffID;
    }        
    
}

?>