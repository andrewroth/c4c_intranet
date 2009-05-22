<?php
/**
 * @package AIobjects	
 */
/**
 * class Database
 * <pre>
 * Written By	:	Johnny Hausman
 * Date		:    15 Aug '04
 *
 * This class handles the interaction with a Database.  It provides the 
 * ability to connect to, Run SQL queries, Retrieve SQL queries, and perform
 * basic INSERT, UPDATE, and DELETE operations on a DB.
 *
 * This class really is intended to be a BASE class that will be extended by
 * other classes.  It will provide the general common functionality needed 
 * by all Database classes, but the specific Connection requirements of
 * different DBs will need to be provided by sub classes.
 *
 * </pre>
 */
class Database extends SiteObject {
// 		
//
//	CONSTANTS:
//
//	VARIABLES:
    /** @var protected [INT] The Unique Link of this mysql Connection */
		protected $dbLink;
		
    /** @var protected [BOOL] Has the DB been set up */
		protected $isInitialized;
		
    /** @var protected [STRING] The name of the DB to connect to */
		protected $dbName;

    /** @var protected [STRING] The name of the Table to connect to */
		protected $dbTableName;
		
    /** @var protected [ARRAY] An Array of the Field Names of the Table we are  working with */
		protected $dbFields;
		
    /** @var protected [ARRAY] An Array of the Field Values of the Table we are working with */	
		protected $dbValues;
		
    /** @var protected [STRING] The sql statement to run on the DB */	
		protected $sql;
		
    /** @var protected [STRING] The condition statement for the operation */	
		protected $dbCondition;
		
    /** @var protected [MULTI] For SELECT statements, if successful this is a Recordset for use in retrieving rows.  If not successful it is FALSE.  For UPDATE/DELETE/INSERT statements this is a TRUE if successful, FALSE if not successful. */	
		protected $dbResult;
		
    /** @var protected [BOOL] Should we continue on an error (TRUE) or die (FALSE) */	
		protected $shouldSuppressErrors;
		

    /** @var protected [STRING] A custom error message stored for retrieval by calling classes */	
		protected $dbErrorMsg;		
		
	//
	//	CLASS CONSTRUCTOR
	//************************************************************************
	/**
	* This is the class constructor for Database class
	*/
    function __construct() {
	
	    parent::__construct();
	    
		$this->isInitialized 		= false;
		$this->dbName          = '';
		$this->dbTableName 		= "<null>";
		$this->dbFields		= array();
//		$this->FieldsTypeArray;  //<- Do I need this?  Or do I just rely on the programmer to condition the Values properly?
		$this->dbValues		= array();
		$this->sql 				= "<null>";
		$this->dbCondition	 	= "<null>";
		$this->dbResult	= "<null>";
		$this->dbErrorMsg = "";
		
		// Default = DONT suppress errors.
		//    NOTE: Session management set's this to TRUE -> It first attempts
		//          to INSERT session, if that returns an error it then 
		//          UPDATES the data. 
		$this->shouldSuppressErrors = false;
		
	}
	
	

//
//	CLASS FUNCTIONS:
//
	
	
	//************************************************************************
	/** 
	 * function setTableName
	 *
	 * Sets the name of the Table to work with.
	 *
	 * @param $tableName [STRING] The name of the Table
	 *
	 */
    function setTableName( $tableName ) {
	
		$this->dbTableName = $tableName;
	
	}
	
	
	//************************************************************************
	/** 
	 * function setFields
	 *
	 * Stores the fields of the Table we want to work with.
	 *
	 * @param $fieldArray [ARRAY] An array of Fields to work with
	 *
	 */
	function setFields( $fieldArray ) {
	
		$this->dbFields = $fieldArray;
	
	}
	
	
	//************************************************************************
	/** 
	 * function setValues
     *
	 * Stores the values of the Table we want to work with.
	 *
	 * @param $valueArray [ARRAY] An array of Values to work with
	 *
	 */
	function setValues( $valueArray ) {
	
		$this->dbValues = $valueArray;
	
	}
	
	
	
	//************************************************************************
	/** 
	 * function setFieldValues
	 *
	 * Takes the provided array and splits it into the fields & values.
	 *
	 * @param $fieldValues [ARRAY] An array of Fields to work with
	 *
	 */
	function setFieldValues( $fieldValues ) {

        $fieldList = array();
        $valueList = array();
        foreach( $fieldValues as $field=>$value ) {
        
            $fieldList[] = $field;
            $valueList[] = $value;
        }
        
		$this->dbFields = $fieldList;
		$this->dbValues = $valueList;
	
	}  // end setFieldValues()
	
	
	
	//************************************************************************
	/** 
	 * function setCondition
	 *
	 * Stores the condition for the SQL we want to work with.
	 *
	 * @param $condition [STRING] The Condition statement to work with
	 *
	 */
	function setCondition( $condition ) {
	
		$this->dbCondition = $condition;
	
	}	
	
	
	//************************************************************************
	/** 
	 * function setSQL
	 *
	 * Stores the SQL we want to work with.
	 *
	 * @param $sqlStatement [STRING] The SQL statement to work with.
	 *
	 */
	function setSQL( $sqlStatement ) {
	
		$this->sql = $sqlStatement;
	
	}
	
	/***
	 * function setErrorMessage
	 *
	 * Sets the custom error message 
	 *
	 * @param $db_error   the message text to set
	 */
	 function setErrorMessage($db_error)
	 {
		 $this->dbErrorMsg = $db_error;
	 }
	
	/***
	 * function getErrorMessage
	 *
	 * Returns the custom error message 
	 *
	 * @return [STRING] the error message
	 */
	 function getErrorMessage()
	 {
		 return $this->dbErrorMsg;
	 }
	
	
	
	//************************************************************************
	/** 
	 * function doSuppressErrors
	 *
	 * Set's up the DB object to ignore errors and continue.
	 *
	 */
    function doSuppressErrors() {
	
		$this->shouldSuppressErrors = true;
	
	}
	
	
	
	//************************************************************************
	/** 
	 * function dontSuppressErrors
	 *
	 * Set's up the DB object to ignore errors and continue.
	 *
	 */
    function dontSuppressErrors() {
	
		$this->shouldSuppressErrors = false;
	
	}
	
	
	
	//************************************************************************
	/** 
	 * function prepForSQL
	 *
	 * Takes the given Value and makes sure it will not break the SQL statement.
	 *
	 * @param $value [MIXED] The Value to update.
	 *
     * @return [STRING] returns the provided Value after escaping it.
	 */
	function prepForSQL( $value ) {
	
 //       $newValue = mysql_real_escape_string( $value, $this->dbLink );
        $newValue = $value;
        
        if (!is_int($value)) {
            $newValue = str_replace( "\'", "'", $newValue);
            $newValue = str_replace( "'", "''", $newValue);
            $newValue = "'".$newValue."'";
        }
		
		return $newValue;
	
	}
	
	
	
	//************************************************************************
	/** 
	 * function setFieldToValues
	 *
	 * Creates a "Field=Value" string.
	 *
	 * @param $field [STRING] The Table Field Name.
     * @param $value [STRING] The Field Value.
     *
     * @return [STRING] Returns the "Field=Value" string.
	 *
	 */
	protected 
	function setFieldToValues( $field, $value) {
	
	    $returnValue = '';
	    
	    if (($field != '') && ( (string) $value != '')) {
	    
    		$returnValue = "$field=$value";
	    } 
	   
		return $returnValue;
	}
	
	
    //************************************************************************
	/** 
	 * function createInsertSQL
	 *
	 * Combines the dbTableName, Fields, and Values into an INSERT statement.
	 *
	 */
	protected 
	function createInsertSQL() {
	
		$fields = "Field1";
		$values = "Value1";
		

		//  Create String of each element seperated by a ","
		if ( is_array( $this->dbFields ) == true ) {
		
			$fields = implode( ", ", $this->dbFields);
			
		}

		//	Create String of each this->prepForSQL( Value ) seperated by a ","
		if ( is_array( $this->dbValues ) == true ) {

			$Temp = array_map( array($this, "prepForSQL"), $this->dbValues );
			$values = implode( ", ", $Temp );
		   
		}
		
		//  Now Set the SQL Statement
		if ($this->dbName != '') {
            $this->sql = "INSERT INTO ".$this->dbName.'.'.$this->dbTableName." ( ".$fields." ) VALUES ( ".$values." )";
        } else {
            $this->sql = "INSERT INTO ".$this->dbTableName." ( ".$fields." ) VALUES ( ".$values." )";
        } // end if dbName != ''
	}
	
	
	
	//************************************************************************
	/** 
	 * function createUpdateSQL
	 *
	 * Combines the dbTableName, Fields, Values and dbCondition into an 
	 * UPDATE statement.
	 *
	 */
	protected 
	function createUpdateSQL() {
	
		//   Prepare all values for the SQL statement
		$preppedValues = array_map( array($this, "prepForSQL"), $this->dbValues );
		
		//  Create String of each element of Field & Value Array in 
		//  following form:
		//	   Field = this->prepForSQL( Value )
		$setValues = array_map( array($this, "setFieldToValues"), $this->dbFields, $preppedValues);
		$updateList = implode( ", ", $setValues);
		
		//  Now Set the SQL Statement
        if ($this->dbName != '') {
		  $this->sql = "UPDATE ".$this->dbName.'.'.$this->dbTableName.' SET  '.$updateList.'  WHERE ( '.$this->dbCondition.' )';
        } else {
            $this->sql = 'UPDATE '.$this->dbTableName.' SET  '.$updateList.'  WHERE ( '.$this->dbCondition.' )';
        }
	
	}
	
	
	
	//************************************************************************
	/** 
	 * function createDeleteSQL
	 *
	 * Combines the dbTableName and dbCondition into a DELETE statement.
	 *
	 */
	protected 
	function createDeleteSQL() {
		
		if ($this->dbName != '') {
		  $this->sql = 'DELETE FROM '.$this->dbName.'.'.$this->dbTableName.' WHERE ( '.$this->dbCondition.' )';
        } else {
            $this->sql = 'DELETE FROM '.$this->dbTableName.' WHERE ( '.$this->dbCondition.' )';
        }
	}
	
	
	//************************************************************************
	/** 
	 * function insert
	 *
	 * Creates an SQL INSERT STATMENT and executes it.
	 *
	 */
	function insert() {
	
		$this->createInsertSQL();
		$this->runSQL();
	}
	
	
	
	//************************************************************************
	/** 
	 * function update
	 *
	 * Creates an SQL UPDATE STATMENT and executes it.
	 * @return [BOOL]
	 */
	function update() {
	
		$this->createUpdateSQL();
		 return $this->runSQL();
	}
	
	
	//************************************************************************
	/** 
	 * function delete
	 *
	 * Creates an SQL DELETE STATMENT and executes it.
	 *
	 */
	function delete() {
	
		$this->createDeleteSQL();
		$this->runSQL();
	}
	
	

}


/**
 * class Database_MySQL
 * <pre>
 * Written By:	Johnny Hausman
 * Date	:    17 Aug '04
 *
 * This child of the Database class is specifically suited to work with MySQL  
 * databases.
 *
 *</pre>	
 */
class Database_MySQL extends Database {
//
//	CONSTANTS:

//
//	VARIABLES:

//
//	CLASS CONSTRUCTOR
//

	//************************************************************************
	/**
	 * This is the class constructor for Database_MySQL
	 */
    function __construct($dbName=null, $host='localhost', $userName='', $passWord='') {
	
		parent::__construct();	//  Call the parent Class Constructor
	
        // if the DB connection info was provided then
        if ($dbName !== null) {
        
            // Establish a connection to the DB
            $this->connectToDB( $dbName, $host, $userName, $passWord);
        }
	}

//
//	CLASS FUNCTIONS:
//

	//************************************************************************
	/** 
	 * function connectToDB
	 *
	 * Establishes a connection to a MySQL DB.
	 *
	 * @param $dbname [STRING] The Name of the DB.
     * @param $host [STRING] connection to the host. (localhost, or IP Address)
     * @param $userName [STRING] The UserID to use to log into the DB.
     * @param $passWord [STRING] The PWord to use to log into the DB.
	 */
	function connectToDB( $dbName, $host='localhost', $userName='', $passWord='') {
	
	    // Set the DB_Name value from given DBName.
	    $this->dbName = $dbName;
	    
		//  if DB Not already isInitialized then
		if ( $this->isInitialized == false ) {
		
			//  initialize DB
			$this->dbLink = mysql_connect( $host, $userName, $passWord) 
					or die("Can't connect to $host");
					
			$Progress = "Connected to $host ... ";
			
            // Select DB
			if (!mysql_select_db( $this->dbName, $this->dbLink ) ) {
			
                if ( !$this->shouldSuppressErrors ) {
					echo ($Progress."Can't use DB: $dbName");
//					exit;
				}
            }
			//  Mark DB as initialized
			$this->isInitialized = true;
		}
	
	}



	//************************************************************************
	/** 
	 * function runSQL
	 *
	 * Runs an SQL statement.
	 *
	 * <pre>
     *    This routine will take a given SQL statement and run it on the DB.
     *    If no SQL query is provided, then it uses the current on in 
     *    $this->sql.
     * </pre>	
	 * @param $query [STRING] The Name of the DB.
     * @return [MIXED] Returns a DataResult if successful, or Boolean FALSE 
     * if not.
	 */
	function runSQL( $query='<null>' )
	{

		//  TO DO:  Later can add support for sending multiple Queries in an Array...
		
		if ( $query <> '<null>' ) {
			$this->sql = $query;
		}
			
		$this->debug( $this->sql );
				
        // if we should not Suppress Errors then
        if ( $this->shouldSuppressErrors == false) {
        
            // run query and display errors
            
            // original code
            // $this->dbResult = mysql_query( $this->sql, $this->dbLink)
            //                or die( $this->sql." --> ".mysql_error($this->dbLink) );
            
            
            $this->setErrorMessage("");	// clear error message in preparation
            $this->dbResult = mysql_query( $this->sql, $this->dbLink );
            //error_log( mysql_error($this->dbLink), 0 );
            if ( mysql_error($this->dbLink) != "" )
            {
	            $error_msg = mysql_error($this->dbLink);
	            $FK_regex = '/foreign key/';	
					if (preg_match($FK_regex, $error_msg) >= 1)
					{
						$this->setErrorMessage("Foreign Key Constraint Violated!<BR>Please ensure all data dependencies have been deleted or updated.");						
					}
					else
					{	            
               	die( $this->sql." --> ".mysql_error($this->dbLink) );
            	}
            }
            
            
            
        } else {
        // else
        
            // run query without quitting on error
             $this->dbResult = mysql_query( $this->sql, $this->dbLink);
        }
		
		// Put Error Checking Here ...
		return $this->dbResult;
		
	}
	
	
	
	//************************************************************************
	/** 
	 * function retrieveRow
	 *
	 * Returns an associative Array of field values contained in the current Recordset Row.
	 *
	 * <pre>
     *    This routine will get the current Row from the internal record set.
     *    If there is a row to return, an associative array is returned.  If 
     *    no row is available, FALSE is returned.
     * </pre>	
	 * @param $query [STRING] The Name of the DB.
     * @return [MIXED] Associative array of 'ColumnName' => Value results if 
     * a row is available.  A BOOL false otherwise.
	 */
	function retrieveRow( )
	{
		
		// Put Error Checking Here ...
		//  Return an array fetch from the last run SQL statement.
		return mysql_fetch_array( $this->dbResult, MYSQL_ASSOC);
			
	}
	
	
	
	//************************************************************************
	/** 
	 * function retrievePrimaryKey
     *
	 * Retrieves the PrimaryKey from the last INSERT statement.
	 *
	 * <pre>
     * This function will return the new Primary Key of an entry that was just
     * INSERTed into a table.
     * </pre>	
     * @return [INT] The primary key of the last INSERT operation.
	 */
	function retrievePrimaryKey( )
	{
		return mysql_insert_id(  $this->dbLink );
	}
	
	
	
	//************************************************************************
	/** 
	 * function getPrimaryKey
     *
	 * This function provides compatibility for new naming scheme.
	 *
	 * <pre>
     * This function will return the new Primary Key of an entry that was just
     * INSERTed into a table.
     * </pre>	
     * @return [INT] The primary key of the last INSERT operation.
	 */
	function getPrimaryKey( )
	{
		return $this->retrievePrimaryKey();
	}
	
	
	
	//************************************************************************
	/**
	 * function getRowCount
	 * <pre>
	 * Returns the number of rows in the current recordset result.
	 * </pre>
	 * @return [INTEGER]
	 */
    function getRowCount() 
    {
        return mysql_num_rows( $this->dbResult );
    }  // end getRowCount()
    
    
    
    //************************************************************************
	/**
	 * function setFirstRow
	 * <pre>
	 * Rewinds the recordset result to the first entry.
	 * </pre>
	 * @return [void]
	 */
    function setFirstRow() 
    {
        // if rows exist, then 
        if ( $this->getRowCount() > 0 ) {
        
            // point to 1st row
            mysql_data_seek( $this->dbResult, 0 );
        }
    }  // end getRowCount()
	
}




/**
 * class Database_Site
 * <pre>
 * Written By	:	Johnny Hausman
 * Date		:    19 Aug '04
 * <pre>
 * This is a generic DB container for the site.  It simply extends the type of DB
 * object that this site uses.  If you want to switch DB's types later, just 
 * change this class to extend the new DB type.
 * </pre>
 */
class Database_Site extends Database_MySQL {
//
//	CONSTANTS:

//
//	VARIABLES:

//
//	CLASS CONSTRUCTOR
//

	//************************************************************************
	/**
	 * This is the class constructor for Database_Site
	 */
    function __construct($dbName=null, $host='localhost', $userName='', $passWord='') {
	
        //  Call the parent Class Constructor
		parent::__construct($dbName, $host, $userName, $passWord);		   
	}
	
}









?>