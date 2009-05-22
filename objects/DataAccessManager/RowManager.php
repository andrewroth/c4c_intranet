<?php
/**
 * @package AIObjects
 */ 
/**
 * class RowManager
 * <pre> 
 * This is a generic class that manages interaction with a Table. It is designed
 * for tables where you would only manage 1 row of information at a time.
 * </pre>
 * @author Johnny Hausman / Russ Martin
 */
abstract
class  RowManager extends DataAccessManager {

	//CONSTANTS:
   

	//VARIABLES:
    /** @var [ARRAY] Values managed by this object. */
	protected $values;
	
	/** @var [ARRAY] Fields in table for this object. (serves as KEY for $values )*/
	protected $fields;
	
	/** @var [STRING] List of fields (columns)in table this object manages. */
	protected $fieldList;
	
	/** @var [STRING] The primary key value for this row. */
	protected $primaryKeyValue;
	
	/** @var [STRING] The primary key field for this row. */
	protected $primaryKeyField;
	
	/** @var [OBJECT] Database object for accessing the DB. */
	protected $db;
	
	/** @var [STRING] The SQL Condition for update & delete operations. */
	protected $dbCondition;
	
	/** @var [STRING] The SQL Creation Data for this DB table. */
	protected $dbDescription;
	
	/** @var [STRING] The Database name to manage. */
	protected $dbName;
	
    /** @var [STRING] The Database path to manage. */
	protected $dbPath;
	
    /** @var [STRING] The Database user to manage. */
	protected $dbUser;
	
    /** @var [STRING] The Database Pword to manage. */
	protected $dbPword;
	
	/** @var [STRING] The Database Table name to manage. */
	protected $dbTableName;
	
	/** @var [ARRAY] Array of additional search conditions. In case a simple
     *  value in the field isn't descriptive enough.
     */
	protected $searchCondition;
	
	/** @var [STRING] The SQL ORDER BY field for find() operations. */
	protected $sortBy;
	
	/** @var [ARRAY] The SQL GROUP BY fields for find() operations. */
	/**protected $groupBy;	// USE MultiTableManager FOR THIS FUNCTIONALITY **/
	
	/** @var [STRING] The SQL function(s) to be used in the SELECT portion of find() operations. CSV format*/
	/** protected $selectFunctions;		// USE MultiTableManager FOR THIS FUNCTIONALITY **/
	
    /** @var [STRING] The SQL ORDER BY ascending or descending for find() operations. */
	protected $ascDesc;
	
	/** @var [BOOL] Status of wether the object was successfully initialized. */
	protected $isLoaded;
	
	/** @var [STRING] Alias for this table. */
	protected $tableIdentifier;
	
	/** @var [STRING] optional template format for labels. */
	protected $labelTemplate;
	
	/** @var [STRING] optional list of fields used in labelTemplate. */
	protected $labelFields;

	//CLASS CONSTRUCTOR
	//************************************************************************
	/**
	 * function __construct
	 * <pre>
	 * Initialize this object.
	 * </pre>
	 * @param $dbTableName [STRING] The db table name this object works with.
	 * @param $fieldList [STRING] list of db table column names this object 
	 * manages.
	 * @param $primaryKeyField [STRING] The primary key field name
	 * @param $primaryKeyValue [INTEGER] The primary key value
	 * @param $condition [STRING] the condition field for sql operations
	 * @return [void]
	 */
    function __construct( $dbTableName, $fieldList, $primaryKeyField, $primaryKeyValue, $condition='', $xmlNodeName='', $dbName=SITE_DB_NAME, $dbPath=SITE_DB_PATH, $dbUser=SITE_DB_USER, $dbPword=SITE_DB_PWORD ) 
    {
        $this->dbTableName = $dbTableName;
        $this->fieldList = $fieldList;
        $this->primaryKeyField = $primaryKeyField;
        $this->primaryKeyValue = $primaryKeyValue;
        $this->dbCondition = $condition;
        
        if ( $xmlNodeName != '' )
        {
            $this->xmlNodeName = $xmlNodeName;
        }
        else
        {
            $this->xmlNodeName = get_class($this);
        }

        $this->dbName = $dbName;
        $this->dbPath = $dbPath;
        $this->dbUser = $dbUser;
        $this->dbPword = $dbPword;

        $this->db = new Database_Site();

        $this->db->connectToDB( $dbName, $dbPath, $dbUser, $dbPword );
        
        $this->values = array();
        
        $this->fields = explode( ',', $this->fieldList);
        
        $this->isLoaded = false;
        
        if ( $this->dbCondition != '') {
        
            $this->isLoaded = $this->loadFromDB();
        }
        
        $this->sortBy = '';
        $this->ascDesc= '';
        $this->tableIdentifier='';
        $this->searchCondition = array();
        
        // Label Template variables
        $this->labelTemplate = '';
        $this->labelFields = '';

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
	 * function clearValues
	 *
	 * Clears the object's data as if it was uninitialized.
	 *
	 * @return [void]
	 */
	function clearValues() 
	{
        
        // for each possible field this object manages ...
        for( $indx=0; $indx<count($this->fields); $indx++) {
        
            $key = $this->fields[$indx];
            
            $this->values[ $key ] = '';
        }
        
        $this->values[ $this->primaryKeyField ] = '';
        $this->primaryKeyValue = '';
        $this->dbCondition = '';
        
        
    } // end clearValues()
    
    
    
    //************************************************************************
	/** 
	 * function constructSearchCondition
	 *
	 * Used to construct complex search conditions for use in the find() 
	 * method
	 *
	 * @return [void]
	 */
    function constructSearchCondition( $fieldName, $op, $value, $shouldAdd=false )
    {

        if ( !is_numeric($value) )
        {
            $value = "'".$value."'";
        }
        $condition = $fieldName.$op.$value;
        
        if ( $shouldAdd )
        {
            $this->addSearchCondition($condition);
        }
        
        return $condition;
    }
    
    
    
    //************************************************************************
	/** 
	 * function constructSearchConditionFromArray
	 *
	 * Will complie an array of search condition statements into a single 
	 * statement joined together by a given operation type ($op)
	 *
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
	 * function createNewEntry
	 * <pre>
	 * Creates a new table entry in the DB for this object to manage.
	 * </pre>
	 * @param $doAllowPrimaryKeyUpdate [BOOL] allow insertion of primary key 
	 * value if present.
	 * @return [void]
	 */
    function createNewEntry( $doAllowPrimaryKeyUpdate=false ) 
    {   
        $this->db->setTableName( $this->dbTableName );
        
        $fieldValues = array();
//			echo "values = <PRE>".print_r($this->values, true)."</PRE>";

        // for each stored value
        foreach( $this->values as $key=>$value) {
        
            // if current key is not the primary field 
            //    OR we are told to allow primary key updates then 
            if (($key != $this->primaryKeyField)||($doAllowPrimaryKeyUpdate)) {
                
                // store in new array
                $fieldValues[ $key ] =  $value;
            }
        }
        $this->db->setFieldValues( $fieldValues );
        
        $this->db->insert();
        
        // now retrieve the primary key value
        $this->primaryKeyValue = $this->db->getPrimaryKey();
        
        // save in values array
        $this->values[ $this->primaryKeyField ] = $this->primaryKeyValue;
    
        // mark isLoaded as true.
        $this->isLoaded = true;
        
        // if db condition was not provided then
//        if ($this->dbCondition == '') {
            
            // set db condition to primary field & value
            $this->setDBCondition( $this->primaryKeyField.'='.$this->primaryKeyValue );
//        }

       return $this->db->getErrorMessage();
        
    } // end createNewEntry()
    
    
    
    //************************************************************************
	/**
	 * function createTable
	 * <pre>
	 * Drops the managed table if it exists.
	 * </pre>
	 * @param [BOOLEAN] $isTemp		whether to create a temporary table
	 * @return [void]
	 */
    function createTable($isTemp = false) 
    {   
	    $tempTable = '';
	     if ($isTemp == true)
	     {
		     $tempTable = "TEMPORARY";
	     }
	     
        if ($this->dbTableName != '') {
        
            if ($this->dbDescription !='') {
        
                $sql = "CREATE ".$tempTable." TABLE ".$this->dbTableName.$this->dbDescription;
//                 echo '<br>'.$sql;
                $this->db->runSQL( $sql );
            
            } else {
            
                die ('RowManager::createTable() = No Table Description!');
            }   
             
        } else {
        
            die ('RowManager::createTable() = No Table Name!');
        }
        
    }
    
    
    
    //************************************************************************
	/**
	 * function deleteEntry
	 * <pre>
	 * Removes the DB table info.
	 * </pre>
	 * @return [STRING]  error message, if there is one
	 */
    function deleteEntry() 
    {   
        if ($this->dbCondition != '') {
        
            $this->db->setTableName( $this->dbTableName );
                    
            $this->db->setCondition( $this->dbCondition );
            
            $this->db->delete();
            
            return $this->db->getErrorMessage();
            
        } else {
        
            die ('RowManager::deleteEntry() = No condition available!');
        }
        
    } // end deleteEntry()
    
    
    
    //************************************************************************
	/**
	 * function dropTable
	 * <pre>
	 * Drops the managed table if it exists.
	 * </pre>
	 * @return [void]
	 */
    function dropTable() 
    {   
        if ($this->dbTableName != '') {
        
            $sql = "DROP TABLE IF EXISTS ".$this->dbTableName;
            $this->db->runSQL( $sql );
            
        } else {
        
            die ('RowManager::dropTable() = No Table Name!');
        }
        
    }
    
    //************************************************************************
	/** 
	 * function getLastInsertID
	 * <pre>
	 * This method will return the latest auto_increment value used.
	 * Run immediately after executing the statement you want to retrieve a
	 * last insert id for.
	 * </pre>
	 * @return [INT] latest auto_increment value.
	 */    
	 function getLastInsertID()
	 {
		  $lastInsertID = -1;
        $sql = 'SELECT LAST_INSERT_ID()';
         
        // create a new DB object
        $db = new Database_Site();
        $databaseName = $this->dbName;
        if ( $databaseName == '' )
        {
            $databaseName = SITE_DB_NAME;
        }
        $db->connectToDB( $databaseName, $this->dbPath, $this->dbUser, $this->dbPword );
        
//         echo "<BR>sql = ".$sql;
        
        // run the sql
        $result = $db->runSQL( $sql );
        
			while ($row = mysql_fetch_assoc($result)) {
				$lastInsertID = $row['LAST_INSERT_ID()'];
			}

        // return auto increment value
        return $lastInsertID;
     }
     		 
    
    //************************************************************************
	/** 
	 * function find
	 * <pre>
	 * This method will return a ReadOnlyResultSet result of db rows that 
	 * match the values currently set in this object.  NOTE: if you don't 
	 * set any values for this object, then all rows will be returned.
	 * </pre>
	 * @return [OBJECT] ReadOnlyResultSet.
	 */
	function find() 
	{
	   // we don't want a leading dot if there is no database name
	   $dotText = '.';
	   if ( $this->dbName == '' )
	   {
	       $dotText = '';
	   }
		   
	    // prepare to add DB function calls if there are any stored
//		 if ($this->selectFunctions != '') 
//		 {
//			 $this->selectFunctions = ','.$this->selectFunctions;
//		 }
	   
			// removed "$this->selectFunctions." from after $this->fieldList because  functions
			// only work with MultiTableManager (you can use single RowManager with aforementioned
			// class to get single table DB function working)
        $sql = 'SELECT '.$this->fieldList.' FROM '.$this->dbName.$dotText.$this->dbTableName;    
               
        $whereClause = '';
        
        // for each possible field this object manages ...
        for( $indx=0; $indx<count($this->fields); $indx++) {
            $key = $this->fields[$indx];
            
            // if value exists
            if ( isset( $this->values[ $key ] ) ) {
            
                // if value was not empty
                if ( (string) $this->values[ $key ] != '' ) {
            
                    // add current key=>value combo to the where clause
                    if ($whereClause != '') {
                        $whereClause .= ' AND ';
                    }
                    $whereClause .=  $key . '="'. $this->values[ $key ].'"';
                
                }
            }
        } // next field
        
        
        // now process any searchConditions provided
        for ( $indx=0; $indx<count( $this->searchCondition); $indx++) {
        
            // add current key=>value combo to the where clause
            if ($whereClause != '') {
                $whereClause .= ' AND ';
            }
            $whereClause .= '('.$this->searchCondition[ $indx ].')';
        }
        
        
        // if a where clause was created then add it to the sql
        if ($whereClause != '') {
            $sql .= ' WHERE '.$whereClause;
        }
        
        
        	// removed GROUP BY clause because it only works
			// with MultiTableManager (you can use single RowManager with aforementioned
			// class to get single table GROUP BY functionality working)
        
        // if groupBy fields are given, then add it/them to the sql
/**        if (count($this->groupBy) > 0) {
	        
	        $sql .= ' GROUP BY ';
	        
	        for ( $indx=0; $indx<count( $this->groupBy); $indx++) {
		        
	        		$sql .= $this->groupBy[$indx].', ';
        		}
        		$sql = substr($sql, 0, -2);	//remove last comma+space
     		}
**/     		
        
        // if a sortBy field is given, then add it to the sql
        if ( $this->sortBy != '' ) {
            $sql .= ' ORDER BY '.$this->sortBy.' '.$this->ascDesc;
        }

        // create a new DB object
        $db = new Database_Site();
        $databaseName = $this->dbName;
        if ( $databaseName == '' )
        {
            $databaseName = SITE_DB_NAME;
        }
        $db->connectToDB( $databaseName, $this->dbPath, $this->dbUser, $this->dbPword );
        
//         echo "<BR>sql = ".$sql;
        
        // run the sql
        $db->runSQL( $sql );
        
        // create a new ReadOnlyResultSet using current db object
        $recordSet = new ReadOnlyResultSet( $db );
        
        // return this record set
        return $recordSet;
        
        
    } // end find()
    
    
    
    //************************************************************************
	/**
	 * function getArrayOfValues
	 * <pre>
	 * Returns an array of values.
	 * </pre>
	 * @return [ARRAY]
	 */
    function getArrayOfValues() 
    {   
	    
	     $fieldValues = array();
        
        // for each possible field this object manages ...
        for( $indx=0; $indx<count($this->fields); $indx++) {
            $key = $this->fields[$indx];
            
            // if value exists
            if ( isset( $this->values[ $key ] ) ) {
            
                // store in new array ...
                $fieldValues[ $key] = $this->values[ $key ];

            }
        } // next field                     
        
        return $fieldValues;
        
    } // end getArrayOfValues()
    
    
    
    //************************************************************************
	/**
	 * function getDBName
	 * <pre>
	 * Returns the name of the DB for this table.
	 * </pre>
	 * @return [STRING]
	 */
    function getDBName()
    {
        return $this->dbName;
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
	 * function getID
	 * <pre>
	 * Returns the value of the primary key field. (name is more intuitive than
	 * "getPrimaryKeyValue" ).
	 * </pre>
	 * @return [STRING]
	 */
    function getID() 
    {   
        return $this->getPrimaryKeyValue();
    } // end getID()
    
    
    
    //************************************************************************
	/**
	 * function getJoinOnFieldX
	 * <pre>
	 * Returns the tableName+fieldName combo for an SQL to properly reference
	 * this table on an SQL JOIN operation.
	 * </pre>
	 * @param $field [STRING] the name of the field to join on.
	 * @return [STRING]
	 */
    function getJoinOnFieldX($field)
    {
        return $this->getTableName().'.'.$field;
    }
    
    
    
    //************************************************************************
	/**
	 * function getLabel
	 * <pre>
	 * Returns the value commonly used for displaying as a Label (Form Grid
	 * rows, Drop List Labels, etc...).
	 * </pre>
	 * @return [STRING]
	 */
    function getLabel() 
    {
        $label = '';
        
//         echo 'template = '.$this->labelTemplate;

        // if labelFormatting is not set then
        if ( $this->labelTemplate == '' ) {
        
            $label = $this->getValueByFieldName( $this->getLabelField() ); 
        } 
        else 
        { // else
        
            $label = $this->labelTemplate;
            
            // for each given field
            $fields = explode( ',', $this->labelFields );
            for( $indx=0; $indx<count( $fields ); $indx++) {
            
                // replace label template with field value
                $key = '[' . $fields[ $indx ].']';
                $value = $this->getValueByFieldName( $fields[ $indx ] );
                $label = str_replace( $key, $value, $label );
                
            }// next field
            
        } // end if
        
        return $label;
    }
    
    
    
    //************************************************************************
	/**
	 * function getLabelField
	 * <pre>
	 * Returns the field to use in the label routines.
	 * </pre>
	 * @return [STRING]
	 */
    abstract
    function getLabelField(); // {}
    
    
    
    //************************************************************************
	/**
	 * function getLabelKey
	 * <pre>
	 * Returns the table column of the field used as a label_key. (this is for
	 * RowLabelBridge() objects to work properly)
	 * </pre>
	 * @return [STRING]
	 */
    function getLabelKey() 
    {
        return "[".$this->getLabel().']';
    }

    
    
    
    //************************************************************************
	/**
	 * function getPrimaryKeyField
	 * <pre>
	 * Returns the name of the primary key field.
	 * </pre>
	 * @return [STRING]
	 */
    function getPrimaryKeyField() 
    {   
        return $this->primaryKeyField;
    } 
    
    
    
    //************************************************************************
	/**
	 * function getPrimaryKeyValue
	 * <pre>
	 * Returns the value of the primary key field.
	 * </pre>
	 * @return [STRING]
	 */
    function getPrimaryKeyValue() 
    {   
        return $this->primaryKeyValue;
    } 
    
    
    
    //************************************************************************
	/**
	 * function getSearchConditions
	 * <pre>
	 * Returns the search conditions as an array.
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
	 * Returns the name of the DB Table this object manages.
	 * </pre>
	 * @return [STRING]
	 */
    function getTableName()
    {
        return $this->dbTableName;
    }
    
    
    
    //************************************************************************
	/**
	 * function getValueByFieldName
	 * <pre>
	 * Returns the value of this field.
	 * </pre>
	 * @param $fieldName [STRING] the key for the desired value.
	 * @return [STRING]
	 */
    function getValueByFieldName( $fieldName ) 
    {
        if (isset( $this->values[ $fieldName ]) ) {
            $returnValue = $this->values[ $fieldName ];
            
        } else {
            
            $returnValue = '';
        }
        
        return $returnValue;
    }
    
    
    
    //************************************************************************
	/** 
	 * function getXMLObject
	 *
	 * Generates an XML Object from the object's Values array.
	 *
	 * @param $isHeaderIncluded [BOOL] Determines if we include the '<?xml version="1.0"?>' header.
	 * @param $rootNodeName [STRING] The XML root node name.
	 *
	 * @return [OBJECT] Returns an XMLObject.
	 */
	function getXMLObject( $isHeaderIncluded=true, $rootNodeName='' ) 
	{
	
        // use member root node name if one is not provided.
        if ($rootNodeName == '') {
            $rootNodeName = $this->xmlNodeName;
        }
        
        $xmlObject = new XMLObject( $rootNodeName );
        
        // for each possible field this object manages ...
        for( $indx=0; $indx<count($this->fields); $indx++) {
        
            $key = $this->fields[$indx];
            
            // if value exists
            if ( isset( $this->values[ $key ] ) ) {
                // echo 'Value ['.$key.'] Exists<br/>';
                $xmlObject->addElement( $key, $this->values[ $key ] );
                
            } else {

                // echo 'Value ['.$key.'] does NOT Exist<br/>';
                $xmlObject->addElement( $key, '' );
            }
        }
        
        return $xmlObject;
        
    } // end getXMLObject()
    
    
    
    //************************************************************************
	/** 
	 * function getXML
	 *
	 * Generates an XML document from the object's Values array.
	 *
	 * @param $isHeaderIncluded [BOOL] Determines if we include the '<?xml version="1.0"?>' header.
	 * @param $rootNodeName [STRING] The XML root node name.
	 *
	 * @return [STRING] Returns an XML formatted string.
	 */
	function getXML( $isHeaderIncluded=true, $rootNodeName='' ) 
	{

        // use member root node name if one is not provided.
        if ($rootNodeName == '') {
            $rootNodeName = $this->xmlNodeName;
        }
        $xmlObject = $this->getXMLObject( $isHeaderIncluded, $rootNodeName );
                
        return $xmlObject->getXML(  $isHeaderIncluded=true );
        
    } // end getXML()
    
    
    
    //************************************************************************
	/**
	 * function isLoaded
	 * <pre>
	 * Returns the status of this objects initialization.
	 * </pre>
	 * @return [BOOL]
	 */
    function isLoaded() 
    {
        return $this->isLoaded;
    }
    
    
    
    //************************************************************************
	/**
	 * function isUniqueFieldValue
	 * <pre>
	 * Verifies that the given value is not already taken in the table.  The 
	 * value is searched in the given field.
	 * </pre>
	 * @param $value [STRING] The value to search for
	 * @param $fieldName [STRING] the column name in the table to search
	 * @param $condition [STRING] modifies the search condition (useful for
	 * narrowing the search to include other field values)
	 * @return [BOOL]
	 */
    function isUniqueFieldValue( $value, $fieldName, $condition='' ) 
    {
        // if a value wasn't given, then default to current value in obj.
        if ($value == '' ) {
            $value = $this->getValueByFieldName( $fieldName );
        }
        
        // create base lookup
        $sql = 'SELECT '.$this->primaryKeyField.' FROM '.$this->dbName.'.'.$this->dbTableName.' WHERE '.$fieldName.'="'.$value.'"';
        
        // if a condition modifier was given then add it
        if ( $condition != '' ) {
            $sql .= ' AND '.$condition;
        }
        
        // if current object has a viewer_id 
        $id = $this->primaryKeyValue;
        if ($id != '') {
        
            // remove current one from the search 
            $sql .= ' AND '.$this->primaryKeyField.'<>'.$id;
        }
        
        // run SQL
        $this->db->runSQL( $sql );
        
        // get the number or rows returned
        $numMatches = $this->db->getRowCount();
        
        $isUnique = true;
        
        // if num matches > 0 then other entries have been found.
        if ( (int) $numMatches != (int) 0 ) {
        
            $isUnique = false;
        }
        
        return $isUnique;
    }
    
    
    
    //************************************************************************
	/**
	 * function loadByCondition
	 * <pre>
	 * Loads a row of data using the given condition
	 * </pre>
	 * @param $condition [STRING] the condition to use for loading
	 * @return [BOOL] True if load successful, False otherwise.
	 */
    function loadByCondition( $condition ) 
    {   
        $returnValue = true;
        
        if ($condition != '' ) {
        
            // pull status info for this family from DB...
            $sql = 'SELECT * FROM '.$this->dbName.'.'.$this->dbTableName.' WHERE '.$condition;
        
            $this->db->runSQL( $sql );
            
            // if row retrieved ...
            if ($row = $this->db->retrieveRow() ) {
            
                $this->loadFromArray( $row );
                
                 $this->isLoaded = true;
                
                $this->primaryKeyValue = $this->values[ $this->primaryKeyField ];
                // set db condition to primary field & value
                $this->setDBCondition( $this->primaryKeyField.'='.$this->primaryKeyValue );
                            
            } else {
            
                // failed load
                $returnValue = false;
                
                $this->isLoaded = false;
                
            } // end if row retrieved ...
            
        } else {
        
            $returnValue = false;
        }
        
        return $returnValue;
        
    } // end loadByCondition()
    
    
    
    //************************************************************************
	/**
	 * function loadByID
	 * <pre>
	 * Loads a row of data using the given ID as the primary key value
	 * </pre>
	 * @param $id [STRING] the value of the primary key for the row to load
	 * @return [BOOL] True if load successful, False otherwise.
	 */
    function loadByID( $id ) 
    {   
        $returnValue = true;
        
        if ($id != '' ) {
        
            $condition = $this->getPrimaryKeyField() . '=' . $id;
        
            $returnValue = $this->loadByCondition( $condition );   
                     
        } else {
        
            $returnValue = false;
        }
        
        return $returnValue;
        
    } // end loadByCondition()
    
    
    
    //************************************************************************
	/**
	 * function loadFromArray
	 * <pre>
	 * Loads this object from a given array of data.
	 * </pre>
	 * @param $values [ARRAY] array of data: array( $field=>$value,...,$field=>$value);
	 * @return [void]
	 */
    function loadFromArray($values) 
    {
//          echo 'Row Manager Values array <pre>';
//          print_r($values);
//          echo '</pre>';
        
//          echo 'Row Manager fields array <pre>';
//          print_r($this->fields);
//          echo '</pre>';
        
        // for each possible field this object manages ...
        for( $indx=0; $indx<count($this->fields); $indx++) {
        
            $key = $this->fields[$indx];
            // echo 'Looking for key['.$key.']<br/>';
            
            // if that field has been provided 
            if (isset( $values[ $key ] ) ) {
            
                // store field into value array
                $this->values[ $key ] = $values[ $key ];	//HOBBE: utf8_encode()  added for compatibility with accents, etc
            }
        } // next field
        
        // since data is loaded from the Array, initialize the condition
        // if it is not already initialized.
 //       if ($this->dbCondition == '') {
            // echo 'Condition NOT already set<br/>';
            // echo 'The primary key is ['.$this->primaryKeyField.']<br/>';
            if (isset( $this->values[ $this->primaryKeyField ] )) {
                $this->dbCondition = $this->primaryKeyField.'="'.$this->values[ $this->primaryKeyField ].'"';
                $this->primaryKeyValue = $this->values[ $this->primaryKeyField ];
            }
            else
            {
                // echo 'Primary Key Field Not Set<br/>';
            }
//        }
//        else
//        {
            // echo 'Condition already set<br/>';
//        }
        
        // if the primaryKeyValue was set, then 
        if (isset( $this->values[ $this->primaryKeyField ] )) {
        
            // make sure it is updated from the values array
            $this->primaryKeyValue = $this->values[ $this->primaryKeyField ];
            
            // mark isLoaded as true.
            $this->isLoaded = true;
            // echo 'primaryKeyValue IS set... isLoaded==true<br/>';
        }
        else
        {
             // echo 'primaryKeyValue not set<br/>';
        }
        
        // echo 'After RowManager::loadFromArray<pre>'.print_r($this->values,true).'</pre>';
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
        $returnValue = true;
        
        // pull status info for this family from DB...
        $sql = 'SELECT * FROM '.$this->dbName.'.'.$this->dbTableName.' WHERE '.$this->dbCondition;
//        echo $sql;
        
        $this->db->runSQL( $sql );
        
        // if row retrieved ...
        if ($row = $this->db->retrieveRow() ) {
        
            $this->loadFromArray( $row );
                        
        } else {
        
            // failed load
            $returnValue = false;
            
        } // end if row retrieved ...
        
        return $returnValue;
        
    } // end loadFromDB()
    
    
    
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
        // if something is provided ...
        if ($list != '') {
        
            $acceptedFieldList = array();
            $defaultFields = explode( ',', $this->fieldList);
            
            // for each list item
            $listItems = explode( ',', $list);
            for( $indx=0; $indx<count($listItems); $indx++) {
                
                // if current field name is one of the managed fields 
                if ( in_array($listItems[$indx], $defaultFields) ) {
                
                    // add to acceptedFieldList
                    $acceptedFieldList[] = $listItems[$indx];
                    
                }
                
            }// next Item
            
            // save acceptedFieldList to fields
            $this->fields = $acceptedFieldList;
            
        } // end if provided 

    }
    
    // simple function for duplicating a field result by creating an alias;
    // useful when creating multiple template form droplists based on the same id table column
    function addFieldNameAlias($fieldName, $alias)
    {
	    $this->fieldList = $this->fieldList.','.$fieldName.' as '.$alias;
    }
    
    
    
    //************************************************************************
	/**
	 * function setLabel
	 * <pre>
	 * Sets the value commonly used for displaying as a Label.  This method
	 * is primarily used by RowLabelBridge objects.
	 * </pre>
	 * @return [void]
	 */
    function setLabel( $label ) 
    {
        $this->setValueByFieldName( $this->getLabelField(), $label );
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
        // if fieldName is given
        if ($fieldName != '') {
	        $this->sortBy = '';

	        	$sortFields = explode(',', $fieldName);
	        	reset($sortFields);
	        	foreach(array_keys($sortFields) as $k)
	        	{
		        	$fieldName = current($sortFields);
	            if ( in_array($fieldName, $this->fields) ) {
	            
	                $this->sortBy .= $fieldName.',';
	            }
	            next($sortFields);
            }
            
            if ($this->sortBy != '')
            {
	            $this->sortBy = substr($this->sortBy,0,-1);
            }
            
        } // end if fieldName given
        
    } // end setSortOrder()
    
    
    
    //************************************************************************
	/**
	 * function setAscDesc
	 * <pre>
	 * sets the ascDesc value to the given sort order  (type of ordering, descending or ascending).
	 * </pre>
	 * @param $ascDesc [STRING] way you want to order the items, whether DESC or default
     * @return [void]
	 */
	 
    function setAscDesc( $ascDesc ) 
    {
        if ($ascDesc != '') {
            
            $this->ascDesc = $ascDesc;
            
        } // end if ascDesc given
        
    } // end setSortOrder()
    
    
    
    //************************************************************************
	/**
	 * function setValueByFieldName
	 * <pre>
	 * sets the given field to the given value.
	 * </pre>
	 * @param $fieldName [STRING] the name of the field
	 * @param $fieldValue [STRING] the value of the field
	 * @return [void]
	 */
    function setValueByFieldName($fieldName, $fieldValue ) 
    {
        // if fieldName is given
        if ($fieldName != '') {
        
            // verify given field is a field we are managing
            if ( in_array($fieldName, $this->fields) ) {
                $this->values[ $fieldName ] = $fieldValue;  
            }    
            
        } // end if fieldName given
        
    } // end setValueByFieldName()
    
    
    
    //************************************************************************
	/**
	 * function setGroupBy
	 * <pre>
	 * Enables the use of a GROUP BY condition in the SQL statement and
	 * specifies the fields to use in the conditiong
	 * </pre>
	 * @param $fieldName [STRING] the name of the field to group by (can be a
	 * comma separated list).
	 * @return [void]
	 */
	 /**** NOTE: must use setGroupBy() in MultiTableManager with single RowManager ****/
	 /*** THIS FUNCTION IS A STUB **/	 
    function setGroupBy( $fieldName )	
    {
         // if fieldName is given
/**        if ($fieldName != '') {
	        $sql_fields = explode(',', $this->fieldList);
	        
	        $temp_fields = array();
	        $temp_fields = explode(',', $fieldName);
	        for( $indx=0; $indx<count($temp_fields); $indx++) {	       
        
            	if ( in_array($fieldName, $sql_fields) ) {
            
                	$this->groupBy[$indx] = $fieldName;
             	}
            }
            
        } // end if fieldName given		
**/       
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
	 /**** NOTE: must use setFunctionCall() in MultiTableManager with single RowManager ****/
	 /*** THIS FUNCTION IS A STUB **/
    function setFunctionCall( $function, $fieldName )   
    {
	     // if fieldName is NOT given
/**        if ($fieldName == '') {
	        
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
     		}	**/
        
	 }	// end setFunctionCall()    
	    
    
    
    
    //************************************************************************
	/**
	 * function setDBCondition
	 * <pre>
	 * Sets the value of the db condition field.
	 * </pre>
	 * @param $condition [STRING] New DB condition
	 * @return [void]
	 */
    function setDBCondition($condition) 
    {
        $this->dbCondition = $condition;
        
    } // end setDBCondition()
    
    
    
    //************************************************************************
	/**
	 * function setIsLoaded
	 * <pre>
	 * Sets the value of the isLoaded field.
	 * </pre>
	 * @param $isLoaded [BOOL] True or False
	 * @return [void]
	 */
    function setIsLoaded($isLoaded) 
    {
        $this->isLoaded = $isLoaded;
        
    } // end setIsLoaded()
    
    
    
    //************************************************************************
	/**
	 * function resetFieldsOfInterest
	 * <pre>
	 * sets the fields of interest to the default list.
	 * </pre>
	 * @return [void]
	 */
    function resetFieldsOfInterest() 
    {
        $this->setFieldsOfInterest( $this->fieldList );
    }
    
    
    
    //************************************************************************
	/**
	 * function updateDBTable
	 * <pre>
	 * Updates the DB table info.
	 * </pre>
	 * @return [void]
	 */
    function updateDBTable( $isDebug=false, $updateKey=false ) 
    {   
        $status = false;
        
        if ($this->dbCondition != '') {
        
            $this->db->setTableName( $this->dbTableName );
            
            $fieldValues = array();
            
            // for each possible field this object manages ...
            for( $indx=0; $indx<count($this->fields); $indx++) {
                $key = $this->fields[$indx];
                if ( ($key != $this->getPrimaryKeyField()) || ($updateKey == true) ) {	// HSMIT, Oct 10/2007: added key update condition
                    if ( isset( $this->values[ $key ] ) ) {
                        $fieldValues[ $key] = $this->values[ $key ];
                    }
                }
            } // next field
            
            $this->db->setFieldValues( $fieldValues );
            
            $this->db->setCondition( $this->dbCondition );
            
//            echo "table = ".$this->dbTableName."  values = <pre>".print_r($fieldValues,true)."</pre><br> condition = ".$this->dbCondition."<BR><BR>";
            
            $status = $this->db->update();
            
            return $this->db->getErrorMessage();
                        
        } else {
        
            die ('RowManager::updateDBTable() = No condition available!');
        }
        
        return $status;
        
    } // end updateDBTable()
    
	
}

?>