<?php
/**
 * @package AIObjects
 */ 
/**
 * class MultiTableManager
 * <pre> 
 * This object manages the relationships between several tables and presents 
 * the data as a single unit.  It depends on individual RowManagers to gather
 * and update the data in the table.
 * </pre>
 * @author Johnny Hausman / Russ Martin
 */
class  MultiTableManager extends DataAccessManager {

    //CONSTANTS:
    const XML_NODE_NAME = 'MultiTableManager';
    
	 const SQL_AND = ' AND ';
	 const SQL_OR = ' OR  '; 
    
    
	//VARIABLES:

	/** @var [ARRAY] Array of fieldNames=>fieldValues to use as WHERE clause conditions. */
	protected $values;
	
    protected $fields;
    
    /** @var [STRING] The SQL FIELDS for find() operations. */
	protected $fieldList;
	
	/** @var [ARRAY] list of RowManagers to Manage. */
	protected $rowManagerList;
	
	/** @var [ARRAY] list of join conditions for these Row Managers */
    protected $joinPairs;
	
    /** @var [STRING] The SQL ORDER BY field for find() operations. */
	protected $sortBy;
	
	/** @var [ARRAY] The SQL GROUP BY fields for find() operations. */
	protected $groupBy;	
	
	/** @var [STRING] The SQL function(s) to be used in the SELECT portion of find() operations. CSV format*/
	protected $selectFunctions;		
	
	/** @var [STRING] The SQL ORDER BY field sorting option. */
	protected $sortByOrder;
	
	/** @var [STRING] The Database Table name to manage. */
	protected $dbTableName;
	
	/** @var [ARRAY] Array of additional search conditions. In case a simple
     *  value in the field isn't descriptive enough.
     */
	protected $searchCondition;
	
	/** @var [ARRAY] Array of additional sub-query conditions. Used to filter
     *  value IDs based on inclusion/exclusion from some set determined by a sub-query.
     */
	protected $subQuery;	
	
	/** @var [BOOL] Status of wether the object was successfully initialized. */
	protected $isLoaded;
	
	
	/** @var [OBJECT] Label Manager Object. */
	protected $labelManager;
	
	/** @var [OBJECT] Generic MultiLingual Manager Object. */
	protected $multiLingualManager;
	
	/** @var [ARRAY] List of fields and their proper mapping to the SQL. */
	protected $fieldMapping;
	
	/** @var [ARRAY] List of fields and the the original table name they came from. */
	protected $fieldMappingOriginalTable;
	
	
    /** @var [STRING] optional template format for labels. */
	protected $labelTemplate;
	
	/** @var [STRING] optional list of fields used in labelTemplate. */
	protected $labelFields;
	
	/** @var [STRING] the name of the field to use as a primary key. */
	protected $primaryKeyField;

		/** @var [BOOLEAN] whether or not to remove fields from result set (i.e. SELECT portion of SQL) */	
	protected $ignoreFields;
	
	
		/** @var [BOOLEAN] whether or not to use UNION of SQL statements */	
	protected $usesQueryUnion;	
	
	/** @var [ARRAY] SQL statements to UNION together */
	protected $unionQueries;		


	//CLASS CONSTRUCTOR
	//************************************************************************
	/**
	 * function __construct
	 * <pre>
	 * Initialize this object.  The different manager objects are expected to
	 * be provided from the child of this object.
	 * </pre>
	 * @param $xmlNodeName [STRING] The xml node name for this object
	 * @return [void]
	 */
    function __construct( $xmlNodeName='' ) 
    {

        if ( $xmlNodeName != '' )
        {
            $this->xmlNodeName = $xmlNodeName;
        }
        else
        {
            $this->xmlNodeName = MultiTableManager::XML_NODE_NAME;
        }
        
        $this->sortBy = array();
        $this->sortByOrder = array();
        
        $this->fieldMapping = array();
        $this->fieldMappingOriginalTable = array();
    
        // Label Template variables
        $this->labelTemplate = '';
        $this->labelFields = '';
        
        $this->primaryKeyField = '';
        
        $this->ignoreFields == false;
        
        $this->unionQueries = array();
        $this->usesQueryUnion = false;
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
        //return $this->getValueByFieldName( 'applicant_codename' );
    }
      
    
    
	//************************************************************************
	/**
	 * function addRowManager
	 * <pre>
	 * Adds a row manager to the list of Managers.
	 * </pre>
	 * @param $rowManager [OBJECT] new RowManager object 
	 * @return [void]
	 */
    function addRowManager($rowManager, $joinPair=null) 
    {
        // if there are no rowManagers loaded
        if( count( $this->rowManagerList ) == 0 ) {
        
            $this->rowManagerList[] = $rowManager;
            
            $this->dbTableName = $rowManager->getDBName().'.'.$rowManager->getTableName();
            $this->fieldList = $rowManager->getFieldList();
            $this->fields = $rowManager->getFields();

            //$this->values = $rowManager->getArrayOfValues();
            $this->primaryKeyField = $rowManager->getPrimaryKeyField();
            
            $valueList = $rowManager->getArrayOfValues();
            foreach($valueList as $key => $value)
            {
                if ($value != '') {
                    $newKey = $rowManager->getTableName() . "." . $key;
                    $this->values[$newKey] = $value;
                }
            }
            
            /*
             * Initialize Field mappings
             *
             * Take the initial fieldList and split it into an array of
             * fieldName=>fieldName entries.
             */
            $arrayList = explode( ',', $this->fieldList );
            for( $indx=0; $indx < count( $arrayList ); $indx++) {
                $value = $arrayList[ $indx ];
                $this->fieldMapping[ $value ] = $value;
                $this->fieldMappingOriginalTable[ $value ] = $rowManager->getTableName();
            }
            
            
        } else {
        
            $this->rowManagerList[] = $rowManager;
            
            if ( is_null($joinPair ) ) {
            
                echo 'Attempting to add RowManager without a joinPair!<br>';
                exit;
                
            } else {
            
                
// 						echo 'adding rowManager['.$rowManager->getXMLNodeName().']<br>';

                /*
                 * Database Table Compilation
                 * 
                 * We take the new table and merge it with the current one.
                 *
                 */
                
                $joinPartA = $joinPair->getPartA();
                $joinPartB = $joinPair->getPartB();
                $joinType = $joinPair->getJoinType();
                
                $this->dbTableName = '('.$this->dbTableName.' '.$joinType.' '.$rowManager->getDBName().'.'.$rowManager->getTableName().' ON '.$joinPartA.'='.$joinPartB . ')';
                

       
                /* 
                 * update FieldMappings
                 *
                 * Go through each field managed by the new rowManager and
                 * check to see if an identical field is already in the
                 * field mapping.  If so, then remap that field name to
                 * include the current rowManager's table name as a reference.
                 */
                // now take ListB and convert into an Array
                $arrayList = explode( ',', $rowManager->getFieldList() );


                
                // for each element in ListB
                for( $indx=0; $indx<count($arrayList); $indx++) {
                    
                    // if element exists in array
                    $field = $arrayList[ $indx ];
                    if ( array_key_exists( $field, $this->fieldMapping ) ) {
                    
                        $value = $this->fieldMappingOriginalTable[ $field ].'.'.$field;
                    } else {
                        $value = $field;
                        $this->fieldMappingOriginalTable[ $field ] = $rowManager->getTableName();
                    }
                    
                    // store item in final field list array
                    $this->fieldMapping[ $field ] = $value;
                }
                
                
                // Update FieldList based on current fieldMapping.
                $this->fieldList = implode( ',', $this->fieldMapping);


                
                /*
                 * Now Add Fields and Values to this object
                 *
                 * 
                 */
                // for each field given
                $fieldList = $rowManager->getFields();

                $valueList = $rowManager->getArrayOfValues();
               /* for($indx=0; $indx<count( $fieldList ); $indx++) {
                        
                    
                    $field = $fieldList[ $indx ];
                    
                    if (isset($valueList[$field]) ) {
                        
                        // if the corresponding field name != value in 
                        // fieldMapping Array then field has been mapped to a 
                        // table.  Update the values array to use that mapped 
                        // reference. 
                        if ( $field != $this->fieldMapping[ $field ] ) {
                            
                            $newFieldName = $this->fieldMapping[ $field ];
                            $this->fields[] = $newFieldName;
                            $this->values[ $newFieldName ] = $valueList[ $field ];
                            
                        } else {
                        
                            $this->fields[] = $field;
                            $this->values[ $field ] = $valueList[$field];
                        }
                        
                    } // end if isset
                    
                } // next field
                */
                
//                 echo "valuelist <pre>".print_r($valueList,true)."</pre>";
                
                
                // initialize values if possible
                foreach($valueList as $key => $value)
                {
                    $newKey = $rowManager->getTableName() . "." . $key;
                    $this->values[$newKey] = $value;
                }
                
              
                
//                 echo 'fields: <pre>'.print_r($this->fields,true).'</pre>';
//                 echo 'values: <pre>'.print_r($this->values,true).'</pre>';
                
            } // end if is_null()
            
        } // end if count 
                
    }
    
    
    
    //************************************************************************
	/**
	 * function addSearchCondition
	 * <pre>
	 * Adds a search condition for use in performing the find() method
	 * </pre>
	 * @param $condition [STRING] The additional condition to search by
	 * @return [void]
	 */
    function addSearchCondition( $condition ) 
    {
        $this->searchCondition[] = $condition;
    }
    
    //************************************************************************
	/**
	 * function addSubQuery
	 * <pre>
	 * Adds a sub-query for use in performing the find() method
	 * </pre>
	 * @param $subquery [STRING] The additional sub-query to search by
	 * @return [void]
	 */
    function addSubQuery( $subquery ) 
    {
        $this->subQuery[] = $subquery;
    }    
    
    
    
    //************************************************************************
	/**
	 * function addSortField
	 * <pre>
	 * stores an ORDER BY field to sort the SQL by.
	 * </pre>
	 * @param $fieldName [STRING] the name of the field to sort by
	 * @param $order [STRING] the order of the 
	 * @return [void]
	 */
    function addSortField( $fieldName = '', $order = 'ASC' ) 
    {
        // verify order is a valid entry
        $order = strtoupper($order);
        switch ($order) {
        
            case 'ASC':
            case 'DESC':
                break;
                
            default:
                $order = 'ASC';
                break;
        }
        
        // if fieldName is given
        if ($fieldName != '') {
            
            $this->sortBy[] = $fieldName;
            $this->sortByOrder[] = $order;
            
        } // end if fieldName given
        
    } // end setSortOrder()
    
    
    
    //************************************************************************
	/** 
	 * function clearValues
	 *
	 * Clears the object's data as if it was uninitialized.
	 *
	 * @return [void]
	 */
	function clearValues() 
	{
        for( $indx=0; $indx<count($this->rowManagerList); $indx++) {
            $this->rowManagerList[ $indx ]->clearValues();
        } 
        
        // Now Clear out the internal values array
        foreach( $this->values as $key=>$value) {
            $this->values[ $key ] = '';
        }
        
    } 
    
    //************************************************************************
	/** 
	 * function clearValues
	 *
	 * Clears the object's data as if it was uninitialized.
	 *
	 * @param [STRING] a CSV list of fields to keep
	 * @return [void]
	 */
	function deleteValuesExceptSome($keepList) 
	{
//         for( $indx=0; $indx<count($this->rowManagerList); $indx++) {
//             $this->rowManagerList[ $indx ]->deleteValues();
//         } 
        
        $keepKeyArray = explode(',',$keepList);
        $keepValueArray = array();
        $idx = 0;
        reset($this->values);
        foreach ( array_keys($this->values) as $key )
        {
	         $value = current($this->values);
	      	if (strstr($key, $keepKeyArray[$idx])!='')
	      	{
		      	$keepValueArray[$key] = $value;
	      	}
	      	next($this->values);
      	}   
        
        // Now delete the internal values array
        $this->values = array();
        $this->values = $keepValueArray;	// keep values specified        
    }     
    
    
    //************************************************************************
	/** 
	 * function ignoreFields
	 *
	 * Ignores the fields, removing them from result set, allowing for special database function calls (i.e. MAX(registration_id))
	 *
	 * @return [void]
	 */
	function ignoreFields() 
	{
		$this->ignoreFields = true;
      $this->selectFunctions = substr($this->selectFunctions,1); 	// remove ',' from front of list
    }     
    
    //************************************************************************
	/**
	 * function constructSearchCondition
	 * <pre>
	 * Compiles a search condition statement.
	 * </pre>
	 * @param $filedName [STRING] name of the field
	 * @param $op [STRING] condition type ('=', '<>', '>'...)
	 * @param $value [STRING] the value of the condition
	 * @param $shouldAdd [BOOL] should this statment be added?
	 * @param $conjunction [CONSTANT] should the clause be prefaced with AND (otherwise with OR)  // use SQL_AND  or SQL_OR	 
	 * @return [void]
	 */
    function constructSearchCondition( $fieldName, $op, $value, $shouldAdd=false, $conjunction='' )
    {
        // if the value is not a numeric value, then enclose in quotes
        if ( !is_numeric($value) )
        {
            $value = "'".$value."'";
        }
        
        // echo 'fieldMapping<pre>'.print_r($this->fieldMapping,true).'</pre>';
        if ( isset( $this->fieldMapping[ $fieldName ] ) ) {
        
            $mappedFieldName = $this->fieldMapping[ $fieldName ];
        } else {
        
            $mappedFieldName = $fieldName;
        }
        
        
        // Only allow 'and' or 'or' as valid SQL conjunctions
        if (($conjunction != MultiTableManager::SQL_AND) && ($conjunction != MultiTableManager::SQL_OR))
        {
	        $conjunction = '';
        }        
        
        // echo 'mappedFieldName['.$mappedFieldName.']<br/>';
        
        $condition = $conjunction.$mappedFieldName.$op.$value;
        
        if ( $shouldAdd )
        {
            $this->addSearchCondition($condition);
        }
        
        return $condition;
    }
    
    
    
    //************************************************************************
	/**
	 * function constructSearchConditionFromArray
	 * <pre>
	 * Compiles a search condition statement.
	 * </pre>
	 * @param $condArray [ARRAY] list of conditions to combine
	 * @param $op [STRING] condition type ('AND', 'OR' ...)
	 * @param $shouldAdd [BOOL] should this statment be added?
	 * @return [void]
	 */
    function constructSearchConditionFromArray( &$condArray, $op, $shouldAdd=false )
    {
        
        $condition = implode( ' '.$op.' ' , $condArray);
        
        if ( $shouldAdd )
        {
            $this->addSearchCondition($condition);
        }
        
        return $condition;
    }
    
    
     //************************************************************************
	/**
	 * function constructSubQuery
	 * <pre>
	 * Compiles a sub query such as the following: 'person_id not in (select person_id from cim_reg_registration)'
	 * </pre>
	 * @param $fielddName [STRING] name of the field to be filtered 
	 * @param $managerSQL [STRING] the sub-query used within the round-brackets (retrieved from another MultiTableManager)
	 * @param $shouldNegate [BOOL] should the pre-subquery parameter be negated (as in example above)?
	 * @param $shouldAdd [BOOL] should this sub-query be added?
	 * @param $conjunction [CONSTANT] should the clause be prefaced with AND (otherwise with OR)  // use SQL_AND  or SQL_OR
	 * @return [void]
	 */
    function constructSubQuery( $fieldName, $managerSQL, $shouldNegate=false, $shouldAdd=false, $conjunction = ''  )
    {
        
        // echo 'fieldMapping<pre>'.print_r($this->fieldMapping,true).'</pre>';
        if ( isset( $this->fieldMapping[ $fieldName ] ) ) {
        
            $mappedFieldName = $this->fieldMapping[ $fieldName ];
        } else {
        
            $mappedFieldName = $fieldName;
        }
        
        // echo 'mappedFieldName['.$mappedFieldName.']<br/>';
        $not = '';
        if ( $shouldNegate )
        {
	        $not = 'not ';
        }
        
        // Only allow 'and' or 'or' as valid SQL conjunctions
        if (($conjunction != MultiTableManager::SQL_AND) && ($conjunction != MultiTableManager::SQL_OR))
        {
	        $conjunction = '';
        }
        
        $subquery = $conjunction.$mappedFieldName.' '.$not.'in ('.$managerSQL.')';
        
        if ( $shouldAdd )
        {
            $this->addSubQuery($subquery);
        }
        
        return $subquery;
    }
    
    
    //************************************************************************
	/**
	 * function createNewEntry
	 * <pre>
	 * Creates a new table entry in the DB for these objects to manage.
	 * </pre>
	 * @param $doAllowPrimaryKeyUpdate [BOOL] allow insertion of primary key 
	 * @return [void]
	 */
    function createNewEntry( $doAllowPrimaryKeyUpdate=false ) 
    {   
	    $error_string = '';
	    
        for( $indx=0; $indx<count($this->rowManagerList); $indx++) {
            $error_string .= $this->rowManagerList[ $indx ]->createNewEntry( $doAllowPrimaryKeyUpdate );
            $error_string .= '<br>';
        }  
        
        return $error_string;
        
        // TO DO:
        // Need to update teh primary key value here.
//        $this->values = $this->getArrayOfValues();
    }
    
    
    
    //************************************************************************
	/**
	 * function deleteEntry
	 * <pre>
	 * Updates the DB table info.
	 * </pre>
	 * @return [void]
	 */
    function deleteEntry() 
    {   
	    $error_string = '';
	    
        for( $indx=0; $indx<count($this->rowManagerList); $indx++) {
            $error_string .= $this->rowManagerList[ $indx ]->deleteEntry();
            $error_string .= '<br>';
        }
        
        return $error_string;                
    }
    
    //************************************************************************
	/** 
	 * function createSQL
	 * <pre>
	 * This method will return the SQL statement used to retrieve DB results.
	 * </pre>
	 * @return [STRING] an SQL statement created from variables set in MultiTableManager.
	 */    
    function createSQL()
    {
// 	    echo "values = <pre>".print_r($this->values,true)."</pre>";
        /*
         * Build Initial SELECT Fields and Table Lists
         *
         */   
         
         // ignore fields if flag set (for calling special DB functions such as MAX(registration_id))
        if ($this->ignoreFields == true)
        {
	        $fields = '';
        }
        else
        {
	        $fields = $this->fieldList;
        }
        $sql = 'SELECT '.$fields.$this->selectFunctions.' FROM '.$this->dbTableName;
        
        $whereClause = '';
        
        
        
        
        /* 
         * WHERE Clause step 1
         *
         * Here we take any existing values from the Row managers and
         * treat them as initial conditions for the WHERE clause.
         */
        // for each possible field this object manages ...
        

      /*  for( $indx=0; $indx<count($this->fields); $indx++) {
            $key = $this->fields[$indx];
            
            // if value exists
            if ( isset( $this->values[ $key ] ) ) {
            
                // if value was not empty
                if ( (string) $this->values[ $key ] != '' ) {
            
                    // add current key=>value combo to the where clause
                    if ($whereClause != '') {
                        $whereClause .= ' AND ';
                    }
                    $whereClause .=  $this->fieldMapping[ $key ]. '="'. $this->values[ $key ].'"';
                
                }
            }
        } // next field
        */
        if (!empty($this->values)) 
        {
            foreach($this->values as $key => $value)
            {        
                if ($whereClause != '') {
                    $whereClause .= ' AND ';
                }
                $whereClause .= $key . "='" . $value . "'";
            }
        }
        

        /*
         * WHERE Clause part 2
         *
         * Where we process any specified searchConditions and add them 
         * to the where Clause.
         */
        // now process any searchConditions provided
        for ( $indx=0; $indx<count( $this->searchCondition); $indx++) {
	        $CONJUNCTION_LENGTH = 5;
	        $condHasConjunction = false;
	        
            $cond_length = strlen($this->searchCondition[ $indx ]);
            $conjunction = substr($this->searchCondition[ $indx ],0,$CONJUNCTION_LENGTH);
            if (($conjunction == MultiTableManager::SQL_AND) || ($conjunction == MultiTableManager::SQL_OR))
            {	  
	            $this->searchCondition[ $indx ] =  substr($this->searchCondition[ $indx ],4,$cond_length-1);
	            $condHasConjunction = true;
            }	        
        
            // add current key=>value combo to the where clause
            if ($whereClause != '') {

	            if ($condHasConjunction == true)
	            {	  
		            $whereClause .= $conjunction;
	            }
	            else
	            {          	             
                	$whereClause .= ' AND ';
             	}
            }

            $whereClause .= '('.$this->searchCondition[ $indx ].')';
        }
        
        

        /*
         * WHERE Clause part 3
         *
         * Where we process any specified sub-queries and add them 
         * to the where Clause.
         */
        // now process any subQueries provided
        for ( $indx=0; $indx<count( $this->subQuery); $indx++) {
	        $CONJUNCTION_LENGTH = 5;
	        $subqueryHasConjunction = false;
	        
            $cond_length = strlen($this->subQuery[ $indx ]);
            $conjunction = substr($this->subQuery[ $indx ],0,$CONJUNCTION_LENGTH);
            if (($conjunction == MultiTableManager::SQL_AND) || ($conjunction == MultiTableManager::SQL_OR))
            {	  
	            $this->subQuery[ $indx ] =  substr($this->subQuery[ $indx ],4,$cond_length-1);
	            $subqueryHasConjunction = true;
            }	    	        
        
            // add current key=>value combo to the where clause
            if ($whereClause != '') {

	            if ($subqueryHasConjunction == true)
	            {	  
		            $whereClause .= $conjunction;
	            }
	            else
	            {          	             
                	$whereClause .= ' AND ';
             	}
            }
            $whereClause .= $this->subQuery[ $indx ];	// e.g. person_id not in (select person_id from cim_reg_registration)
        }        
        
        
        // if a where clause was created then add it to the sql
        if ($whereClause != '') {
            $sql .= ' WHERE '.$whereClause;
        }
        
        /** GROUP BY Clause **/
        // if groupBy fields are given, then add it/them to the sql
        if (count($this->groupBy) > 0) {
	        
	        $sql .= ' GROUP BY ';
	        
	        for ( $indx=0; $indx<count( $this->groupBy); $indx++) {
		        
	        		$sql .= $this->groupBy[$indx].', ';
        		}
        		$sql = substr($sql, 0, -2);	//remove last comma+space
     		}        
        
        
        /*
         * ORDER BY Clause
         *
         * process every entry in the sort by list and create the 
         * ORDER BY clause.  If a field entry has been modified to use 
         * it's table name, then do that here as well.
         */
        // if a sortBy field is given, then add it to the sql
        $sortByClause = '';
        
        for ( $indx=0; $indx<count( $this->sortBy ); $indx++ ) {

            if ( isset( $this->fieldMapping[ $this->sortBy[ $indx ] ] ) ) {
            
                $sortField = $this->fieldMapping[ $this->sortBy[ $indx ] ];
 
                if ($sortByClause != '') {
                    $sortByClause .= ', ';
                }
                $sortByClause .= $sortField.' '.$this->sortByOrder[ $indx ];
                
            } // end if isset()
            
        } //next sortBy                
        
        if ( $sortByClause != '' ) {
            $sql .= ' ORDER BY '.$sortByClause;
        }
        
        return $sql;
     }
    
    
    
    //************************************************************************
	/** 
	 * function find
	 * <pre>
	 * This method will return a ReadOnlyResultSet result of db rows that 
	 * match the values currently set in the dataManaer object.  NOTE: if you
	 * don't set any values for this object, then all rows will be returned.
	 * </pre>
	 * @return [OBJECT] ReadOnlyResultSet.
	 */
	function find() 
	{
		if ($this->usesQueryUnion == false)
		{		
         $sql = $this->createSQL();
	            
	        /*
	         * Create And Return Recordset Object
	         *
	         * Create a db object, run the compiled sql statement and return 
	         * the results as a new ReadOnlyResultSet object.
	         */
	
	        // create a new DB object
	        $db = new Database_Site();
	        $db->connectToDB( SITE_DB_NAME, SITE_DB_PATH, SITE_DB_USER, SITE_DB_PWORD );
	        
// 	 			echo 'the sql = ['.$sql.']<br>';
	
	        // run the sql
	        $db->runSQL( $sql );
	        
	        // create a new ReadOnlyResultSet using current db object
	        $recordSet = new ReadOnlyResultSet( $db );
	        
	//         echo 'recordset = <pre>'.print_r($recordSet->getNext($this), true).'</pre>';
	                
	        // return this record set
	        return $recordSet;       
        }
        else		// use union_find() method to get union-based query results
        {
	        return $this->union_find();
        }
    }
    
    /**
     * function setUnionQueries
     * <pre>
     * Allows the data manager to use multiple queries
     * with UNION keyword separating them. End-result
     * is the union of the query result sets.
     * </pre>
     */
    function setUnionQueries($queries = array())
    {
	    $this->unionQueries = array_merge($this->unionQueries,$queries);
    }

    /**
     * function setUsesQueryUnion
     * <pre>
     * Takes a boolean parameter used to indicate
     * whether a union of queries will be used for 
     * retrieving database results.
     * </pre>
     */    
    function setUsesQueryUnion($use_union = false)
    {
	    $this->usesQueryUnion = $use_union;
    }
 
       
    //************************************************************************
	/** 
	 * function union_find
	 * <pre>
	 * This method will return a ReadOnlyResultSet result of db rows that 
	 * match the values currently set in the dataManager object, as per the UNION
	 * of the specified SQL statements
	 * NOTE: if you
	 * don't set any values for this object, then all rows will be returned.
	 * </pre>
	 * @return [OBJECT] ReadOnlyResultSet.
	 */
	function union_find() 	//$query1='', $query2='', $sortBy=''
	{
		if (isset($this->unionQueries)&&(count($this->unionQueries) > 1))
		{
			$sql = '';
			foreach (array_keys($this->unionQueries) as $key)
			{
				$query = current($this->unionQueries);
				
         	$sql .= '('.$query.')';
         	$sql .= ' UNION ';
         	next($this->unionQueries);
      	}
      	$sql = substr($sql,0,-7);	// remove the last " UNION "
         

        // if a sortBy field is given, then add it to the sql
        $sortByClause = '';
        
        for ( $indx=0; $indx<count( $this->sortBy ); $indx++ ) {
        
            if ( isset( $this->fieldMapping[ $this->sortBy[ $indx ] ] ) ) {
            
                $sortField = $this->fieldMapping[ $this->sortBy[ $indx ] ];
 
                if ($sortByClause != '') {
                    $sortByClause .= ', ';
                }
                $sortByClause .= $sortField.' '.$this->sortByOrder[ $indx ];
                
            } // end if isset()
            
        } //next sortBy                
        
        if ( $sortByClause != '' ) {
            $sql .= ' ORDER BY '.$sortByClause;
        }         
         
         
        
        /*
         * Create And Return Recordset Object
         *
         * Create a db object, run the compiled sql statement and return 
         * the results as a new ReadOnlyResultSet object.
         */

        // create a new DB object
        $db = new Database_Site();
        $db->connectToDB( SITE_DB_NAME, SITE_DB_PATH, SITE_DB_USER, SITE_DB_PWORD );
        
//  			echo 'UNION sql = ['.$sql.']<br>';

        // run the sql
        $db->runSQL( $sql );
        
        // create a new ReadOnlyResultSet using current db object
        $recordSet = new ReadOnlyResultSet( $db );
        
//         echo 'recordset = <pre>'.print_r($recordSet->getNext($this), true).'</pre>';
                
        // return this record set
        return $recordSet;       
     }
     else {
	     return;	// null
     }
    }    
    
    
    
    
    //************************************************************************
	/**
	 * function getArrayOfValues
	 * <pre>
	 * Returns an array of combined values from the dataManager & labelManager.
	 * </pre>
	 * @param	[BOOLEAN] $skipManagers		whether or not to just use values in MultiTableManager (not in RowManagers)
	 * @return [ARRAY]
	 */
    function getArrayOfValues($skipManagers = false) 
    {   
    
        $resultArray = array();
        
        if ($skipManagers == true)	// skip results from individual RowManagers
        {
	        $resultArray = $this->values;
// 	        echo "values = <pre>".print_r($resultArray, true)."</pre>";
        }
        else
        {
	        
	        for( $indx=0; $indx<count($this->rowManagerList); $indx++) {
	            
	            $resultArray = array_merge( $resultArray, $this->rowManagerList[ $indx ]->getArrayOfValues() );
	        }
        }
        
        /** add results from function calls to results array **/              
        $foundValues = array();
        $functionCalls = explode(',', $this->selectFunctions);
                
        // for each function call
        for( $indx=0; $indx<count($functionCalls); $indx++) {
            $key = $functionCalls[$indx];
            
            // if value exists
            if ( isset( $this->values[ $key ] ) ) {
            
                // store in new array ...
                $foundValues[ $key] = $this->values[ $key ];
            }
        } // find next function call result
        
        $resultArray =  array_merge( $resultArray, $foundValues );
        return $resultArray;
    } 
    
    
    
    //************************************************************************
	/**
	 * function getID
	 * <pre>
	 * Returns the value of the dataManager's primary key field. 
	 * </pre>
	 * @return [STRING]
	 */
    function getID() 
    {   
	    // there will be no proper primary key value if ignoreFields is on 
	    // because only some function result is returned, e.g. MAX(registration_id)
	    if ($this->ignoreFields == true)
	    {
		    $functions = explode(',', $this->selectFunctions);
//		    echo $functions[0];
		    return $this->values[ $functions[0] ];
	    }
	    else
	    {		    
 //       return $this->rowManagerList[0]->getID();
        return $this->values[ $this->primaryKeyField ];
       }
    }
    
    
    
    //************************************************************************
	/**
	 * function getFieldList
	 * <pre>
	 * Returns the field list. 
	 * </pre>
	 * @return [STRING]
	 */
    function getFieldList()
    {
        return $this->fieldList;
    }
    
    
    
    //************************************************************************
	/**
	 * function getFields
	 * <pre>
	 * Returns the fields. 
	 * </pre>
	 * @return [ARRAY]
	 */
    function getFields()
    {
        return $this->fields;
    }
    
    
    
    //************************************************************************
	/**
	 * function getLabel
	 * <pre>
	 * Returns the required label for DropList generation.
	 * NOTE: we assume the initial rowManager is the primary Row Manager for 
	 * these operations.
	 * </pre>
	 * @return [STRING]
	 */
    function getLabel() 
    {   
        $label = '';

        // if labelFormatting is not set then
        if ( $this->labelTemplate == '' ) {
        
            $label = $this->rowManagerList[0]->getLabel();
        } 
        else 
        { // else

            $label = $this->labelTemplate;
            
            // for each given field
            $fields = explode( ',', $this->labelFields );
            for( $indx=0; $indx<count( $fields ); $indx++) {
            
                // replace label template with field value
                $key = '[' . $fields[ $indx ].']';
                $value = $this->values[ $fields[ $indx ] ];
                $label = str_replace( $key, $value, $label );
                
            }// next field
            
        } // end if
        
        return $label;

    } 
    
    
    
    //************************************************************************
	/**
	 * function getPrimaryKeyValue
	 * <pre>
	 * Returns the value of the dataManager's primary key field.
	 * </pre>
	 * @return [STRING]
	 */
    function getPrimaryKeyValue() 
    {   
        return $this->rowManagerList[0]->getPrimaryKeyValue();
    }  
    
    
    
    //************************************************************************
	/**
	 * function getSearchConditions
	 * <pre>
	 * Returns the search conditions. 
	 * </pre>
	 * @return [ARRAY]
	 */
    function getSearchConditions()
    {
        $retArray = array();
        if ( count( $this->searchCondition ) > 0 )
        {
            $retArray = $this->searchCondition;
        }
        return $retArray;
    }
    
    
    
    //************************************************************************
	/**
	 * function getTableName
	 * <pre>
	 * Returns the table name (probably a long inner join).
	 * </pre>
	 * @return [STRING]
	 */
    function getTableName()
    {
        return $this->dbTableName;
    }
        
    
    
    //************************************************************************
	/** 
	 * function getXMLObject
	 * <pre>
	 * Generates an XML Object from the object's Values array.
	 * </pre>
	 * @param $isHeaderIncluded [BOOL] Determines if we include the '<?xml version="1.0"?>' header.
	 * @param $rootNodeName [STRING] The XML root node name.
	 * @param $skipManagers [BOOLEAN] Whether to skip reading individual manager values in favour of overall values
	 *
	 * @return [OBJECT] XMLObject
	 */
	function getXMLObject( $isHeaderIncluded=true, $rootNodeName='', $skipManagers = false ) 
	{
	
        // use member root node name if one is not provided.
        if ($rootNodeName == '') {
            $rootNodeName = $this->xmlNodeName;
        }
        
        // NOTE: Big picture here, is to make the individual XML values from
        // the XMLObjects and combine them into 1 XMLObject for a unified 
        // XML result.
        
        // for each rowManager in list
        $combinedValues = array();
        
        // only use overall result values, NOT values from individual managers (which has problems with LEFT JOINs)
        if ($skipManagers == true)
        {	     
	        $combinedValues = $this->getArrayOfValues($skipManagers);
        }
        else
        {
	//         echo "ROwManager = <pre>".print_r($this->rowManagerList,true)."</pre>";
	        
	        for ($indx=0; $indx<count( $this->rowManagerList); $indx++) {
	            
	            // pull out XMLValues array
	            $valuesArray = $this->rowManagerList[ $indx ]->getArrayOfValues();
	            
	//              echo 'The XML values<pre>'.print_r($valuesArray,true).'</pre>';
	            
	            // combine them into 1 array of Values
	            $combinedValues = array_merge($combinedValues, $valuesArray);
	        }    
	        
	//         echo 'Combined<pre>'.print_r($combinedValues,true).'</pre>';
	        // exit;	        
        }

        // create new XML Object for output
        $xmlObject = new XMLObject( $rootNodeName );
        
        // set those combined values as this Blended XML object
        foreach( $combinedValues as $key=>$value)
        {
            $xmlObject->addElement( $key, $value );
        }
        
        return $xmlObject;
        
    } 
    
    
    
    //************************************************************************
	/** 
	 * function getXML
	 * <pre>
	 * Generates an XML document from the object's Values array.
	 * </pre>
	 * @param $isHeaderIncluded [BOOL] Determines if we include the '<?xml version="1.0"?>' header.
	 * @param $rootNodeName [STRING] The XML root node name.
	 * @return [STRING]
	 */
	function getXML( $isHeaderIncluded=true, $rootNodeName='' ) 
	{

        // use member root node name if one is not provided.
        if ($rootNodeName == '') {
            $rootNodeName = $this->xmlNodeName;
        }
        $xmlObject = $this->getXMLObject( $isHeaderIncluded, $rootNodeName );
                
        return $xmlObject->getXML(  $isHeaderIncluded=true );
        
    }
    
    
    
    //************************************************************************
	/**
	 * function getXMLNodeName
	 * <pre>
	 * Returns the xml node name.
	 * </pre>
	 * <pre><code>
	 * [Put PseudoCode Here]
	 * </code></pre>
	 * @return [STRING]
	 */
    function getXMLNodeName()
    {
        return $this->xmlNodeName;
    }
    
    
    
    //************************************************************************
	/**
	 * function isLoaded
	 * <pre>
	 * Returns true if all the rowManagers have been loaded.
	 * </pre>
	 * @return [BOOL]
	 */
    function isLoaded() 
    {
        $isLoaded = true;
        
        for( $indx=0; $indx<count( $this->rowManagerList ); $indx++ ) {
        
            $isLoaded = (($isLoaded) && ($this->rowManagerList[ $indx ]->isLoaded()));
        }
        
        return $isLoaded;
    }
    
    
    
    //************************************************************************
	/**
	 * function loadFromArray
	 * <pre>
	 * Loads the objects from a given array of data.
	 * </pre>
	 * @param $values [ARRAY] array of data: array( $field=>$value,...,$field=>$value);
	 * @return [void]
	 */
    function loadFromArray($values) 
    {
	    /** HSMIT: (below) added code to MultiTableManager to ensure UTF-8 encoding is enforced **/
	    reset($values);
	    foreach (array_keys($values) as $k)
	    {
		    $values[$k] = current($values);		// utf8_encode()
		    next($values);
	    }
        $this->values = $values;	
        
//         echo 'values = <pre>'.print_r($values,true).'</pre>';
        
        for( $indx=0; $indx<count( $this->rowManagerList ); $indx++ ) {
            $this->rowManagerList[ $indx ]->loadFromArray( $values );
//             echo "rowmanager values = <pre>".print_r($this->rowManagerList[ $indx ]->getListIterator()->getDataList(),true)."</pre><BR>";
        }   
        
    }
    
    
    
    //************************************************************************
	/**
	 * function loadFromDB
	 * <pre>
	 * Loads the row of data to manage
	 * </pre>
	 * @return [BOOL] True if load successful, False otherwise.
	 */
    function loadFromDB() 
    {
    
        $isSuccessful = true;
        
        for( $indx=0; $indx<count( $this->rowManagerList ); $indx++ ) {
            $isLoaded = $this->rowManagerList[ $indx ]->loadFromDB();
            $isSuccessful = (($isSuccessful) && ($isLoaded));
        }
        
        return $isSuccessful;
    } 
    
    
    
    //************************************************************************
	/**
	 * function setFieldsOfInterest
	 * <pre>
	 * sets the fields of interest to the provided list.
	 * </pre>
	 * @param $list [STRING] comma delimited list of fields to work with
	 * @return [void]
	 */
    function setFieldsOfInterest($list) 
    {
        for( $indx=0; $indx<count( $this->rowManagerList ); $indx++ ) {
            $this->rowManagerList[ $indx ]->setFieldsOfInterest( $list );
        }
    }

    
        //************************************************************************
	/**
	 * function setFieldList
	 * <pre>
	 * sets the fields to be used when searching for data: allows user to customize list (default = all values)
	 * </pre>
	 * @param $list [STRING] comma delimited list of fields to return in query results
	 * @return [void]
	 */    
    function setFieldList($list) {
	    
	    $this->fieldList = $list;
    }
    
    
    
    //************************************************************************
	/**
	 * function setLabelTemplate
	 * <pre>
	 * Sets the formatting used for the label returned by this object.
	 * </pre>
	 * @param $fieldList [STRING] a csv list of field names used in the template
	 * @param $template [STRING] formatted 
	 * @return [void]
	 */
    function setLabelTemplate( $fieldList, $template ) 
    {
        $this->labelTemplate = $template;
        $this->labelFields = $fieldList;
    }
    
    
    
    //************************************************************************
	/**
	 * function setSortOrder
	 * <pre>
	 * sets the sortBy value to the given field.
	 * </pre>
	 * @param $fieldName [STRING] the name of the field to sort by (can be a
	 * comma seperated list).
	 * @return [void]
	 */
    function setSortOrder( $fieldName ) 
    {
        // for each fieldName given
        $fields = explode( ',', $fieldName);
        for( $indx=0; $indx<count( $fields ); $indx++ ){
            
            // field might actuall be a "field ASC/DESC" entry.
            // attempt to break field into field and option
            $parts = explode( " ", trim( $fields[ $indx ] ) );
            
            if (count($parts) > 1 ) {
                $this->addSortField( $parts[0], $parts[1]);
                
            } else {
                $this->addSortField( $parts[0] );
            }
        }
 
    }
    
   //************************************************************************
	/**
	 * function setGroupBy
	 * <pre>
	 * Enables the use of a GROUP BY condition in the SQL statement and
	 * specifies the fields to use in the conditiong
	 * </pre>
	 * @param $condition [STRING] the name of the field to group by (can be a
	 * comma separated list).
	 * @return [void]
	 */
    function setGroupBy( $fieldNames )
    {
         // if fieldName is given
        if ($fieldNames != '') {
	        
	        $sql_fields = explode(',', $this->fieldList);
	        
	        $temp_fields = array();
	        $temp_fields = explode(',', $fieldNames);
//	        echo 'tempfields = '.print_r($temp_fields,true);
	        for( $indx=0; $indx<count($temp_fields); $indx++) {	       
        
            	if ( in_array($temp_fields[$indx], $sql_fields) ) {		// replaced $fieldName with $temp_fields[$indx]
            
                	$this->groupBy[$indx] = $temp_fields[$indx];	// replaced $fieldName with $temp_fields[$indx]
             	}
            }
            
        } // end if fieldName given		
        
	 }	// end setGroupBy()
    
 
	//************************************************************************
	/**
	 * function setFunctionCall
	 * <pre>
	 * Enables the use of a DB function (i.e. COUNT(), SUM(), etc) in the SELECT portion of an SQL statement and
	 * specifies the field to use as parameter
	 * </pre>
	 * @param $function [STRING] the name of the function to use 
	 * @param $fieldName [STRING] the name of the field to use in DB function
	 * @return [void]
	 */
    function setFunctionCall( $function, $fieldName ) 
    {
         // if fieldName is NOT given
        if ($fieldName == '') {
	        
	        // specify all valid fields as parameter for function, i.e. COUNT(*)
	        $fieldName = '*';	
	        $this->selectFunctions .= ','.$function.'('.$fieldName.')';
        }
        else {
	        
	        $sql_fields = explode(',', $this->fieldList);
	        	       
	     		// determine if $fieldName is a valid table column
	      	if ( in_array($fieldName, $sql_fields) ) {
	      
	          	$this->selectFunctions .= ','.$function.'('.$fieldName.')';
	       	}
	       	else {
		       	break;	// ensures that fieldMapping is *not* updated
	       	}
     		}
     		$this->fieldMapping[ $function.'('.$fieldName.')' ] = $function.'('.$fieldName.')';
        
	 }	// end setFunctionCall()	
	 	    
    
    //************************************************************************
	/**
	 * function setDBCondition
	 * <pre>
	 * Sets the value of the db condition field (for the dataManager).
	 * </pre>
	 * @param $condition [STRING] New DB condition
	 * @return [void]
	 */
    function setDBCondition($condition) 
    {
//        $this->dataManager->setDBCondition($condition);
    }
    
    
    
    //************************************************************************
	/**
	 * function setPrimaryKeyField
	 * <pre>
	 * Sets the field key to use as a primary field ID.
	 * </pre>
	 * @param $field [STRING] New field name
	 * @return [void]
	 */
    function setPrimaryKeyField($field) 
    {
        $this->primaryKeyField = $field;
    }
    
    
    
    //************************************************************************
	/**
	 * function setValueByFieldName
	 * <pre>
	 * Sets the value of the a field in the RowManagers.
	 * </pre>
	 * @param $fieldName [STRING] field name to update
	 * @param $value [STRING] new value
	 * @return [void]
	 */
    function setValueByFieldName($fieldName, $value) 
    {    
        for( $indx=0; $indx<count($this->rowManagerList); $indx++) {
            $this->rowManagerList[ $indx ]->setValueByFieldName($fieldName, $value);
        }     
    }
  
    
    //************************************************************************
	/**
	 * function updateDBTable
	 * <pre>
	 * Updates the DB table info.
	 * </pre>
	 * @return [void]
	 */
    function updateDBTable() 
    {   
	    $error_string = '';
	    
        for( $indx=0; $indx<count( $this->rowManagerList ); $indx++ ) {
            $error_string .= $this->rowManagerList[ $indx ]->updateDBTable();
            $error_string .= '<br>';
        }
       
        return $error_string;   
    } 
    

}

?>