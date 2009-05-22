<?php

class Database {
// 
//  DESCRIPTION:
//		This class handles the interaction with a Database.  It provides the 
//		ability to connect to, Run SQL queries, Retrieve SQL queries, and perform
//		basic INSERT, UPDATE, and DELETE operations on a DB.
//
//		This class really is intended to be a BASE class that will be extended by
//		other classes.  It will provide the general common functionality needed 
//		by all Database classes, but the specific Connection requirements of
//		different DBs will need to be provided by sub classes.
//
//	CONSTANTS:



//
//	VARIABLES:
		var	$DBObject;
		var $Initialized;
		var $db_name;         // [STRING] The Database name
		var $TableName;
		var $FieldsArray;
		var $FieldsTypeArray;  //<- Do I need this?  Or do I just rely on the programmer to condition the Values properly?
		var $ValuesArray;
		var $SQL;
		var $Condition;
		var $LastQueryResult;
		
		// DEBUG VARIABLES		
		//	Here we define some variable with specific DEBUGGING purposes.
		var $Debug_ObjectName;  //Holds the specific DB Object's name.  Used to 
								//help debug problems.
								// ex:  $MyDB = &new Database;
								//		$MyDB->Debug_ObjectName = "MyDB";  //<- Use the "Name" of the variable you just created.
		var $Debug_ShowSQL;		// Flag indicating if run SQL Statements should be displayed. (True/False)
		var $Debug_SuppressErrors; //Flag indicating if Program execution should happen on 

//
//	CLASS CONSTRUCTOR
//

	//************************************************************************
	function Database() {
	
		$this->Initialized 		= false;
		$this->db_name          = '';
		$this->TableName 		= "<null>";
		$this->FieldsArray		= array();
//		$this->FieldsTypeArray;  //<- Do I need this?  Or do I just rely on the programmer to condition the Values properly?
		$this->ValuesArray		= array();
		$this->SQL 				= "<null>";
		$this->Condition	 	= "<null>";
		$this->LastQueryResult	= "<null>";
		
		
		$this->Debug_ObjectName = "<null>";
		$this->Debug_ShowSQL 	= false;
		$this->Debug_SuppressErrors = false;
		
	}
	
	

//
//	CLASS FUNCTIONS:
//

	//************************************************************************
	function HHH() {
	
	
	}
	
	
	//************************************************************************
	function setTableName( $GivenTableName ) {
	
		$this->TableName = $GivenTableName;
	
	}
	
	
	//************************************************************************
	function setFields( $GivenFieldArray ) {
	
		$this->FieldsArray = $GivenFieldArray;
	
	}
	
	
	//************************************************************************
	function setValues( $GivenValueArray ) {
	
		$this->ValuesArray = $GivenValueArray;
	
	}
	
	
	
	//************************************************************************
	function setCondition( $GivenCondition ) {
	
		$this->Condition = $GivenCondition;
	
	}	
	
	
	//************************************************************************
	function SetSQL( $GivenSQLStatement ) {
	
		$this->SQL = $GivenSQLStatement;
	
	}
	
	
	
	//************************************************************************
	function PrepForSQL( $Value ) {
	
		$NewValue = "'".str_replace("'", "''", $Value)."'";
		
		return $NewValue;
	
	}
	
	
	
	//************************************************************************
	function SetFieldToValues( $FieldName, $FieldValue) {
	
		$Return = "$FieldName=$FieldValue";
		return $Return;
	}
	
	

	//************************************************************************
	function CreateInsertSQL() {
	
		$Fields = "Field1";
		$Values = "Value1";
		

		//  Create String of each element seperated by a ","
		if ( is_array( $this->FieldsArray ) == true ) {
		
			$Fields = implode( ", ", $this->FieldsArray);
			
		}

		//	Create String of each this->PrepForSQL( Value ) seperated by a ","
		if ( is_array( $this->ValuesArray ) == true ) {

			$Temp = array_map( array($this, "PrepForSQL"), $this->ValuesArray );
			$Values = implode( ", ", $Temp );
		   
		}
		
		//  Now Set the SQL Statement
		;
		if ($this->db_name != '') {
		  $this->SQL = "INSERT INTO ".$this->db_name.'.'.$this->TableName." ( $Fields ) VALUES ( $Values )";
        } else {
            		  $this->SQL = "INSERT INTO ".$this->TableName." ( $Fields ) VALUES ( $Values )";
        }
	
	}
	
	
	//************************************************************************
	function CreateUpdateSQL() {
	
		//   Prepare all values for the SQL statement
		$PreppedValues = array_map( array($this, "PrepForSQL"), $this->ValuesArray );
		
		//  Create String of each element of Field & Value Array in following form:
		//	Field = this->PrepForSQL( Value )
		$SetValues = array_map( array($this, "SetFieldToValues"), $this->FieldsArray, $PreppedValues);
		$UpdateList = implode( ", ", $SetValues);
		
		//  Now Set the SQL Statement
        if ($this->db_name != '') {
		  $this->SQL = "UPDATE ".$this->db_name.'.'.$this->TableName." SET  $UpdateList  WHERE ( $this->Condition )";
        } else {
            $this->SQL = "UPDATE $this->TableName SET  $UpdateList  WHERE ( $this->Condition )";
        }
	
	}
	
	
	
	//************************************************************************
	function CreateDeleteSQL() {
		
		if ($this->db_name != '') {
		  $this->SQL = "DELETE FROM ".$this->db_name.'.'.$this->TableName." WHERE ( $this->Condition )";
        } else {
            $this->SQL = "DELETE FROM $this->TableName WHERE ( $this->Condition )";
        }
	}
	
	
	//************************************************************************
	function DBInsert() {
	
		$this->CreateInsertSQL();
		$this->RunSQL();
	}
	
	
	
	//************************************************************************
	function DBUpdate() {
	
		$this->CreateUpdateSQL();
		$this->RunSQL();
	}
	
	
	//************************************************************************
	function DBDelete() {
	
		$this->CreateDeleteSQL();
		$this->RunSQL();
	}
	
	
	//
	//  DEBUG FUNCTIONS
	//
	//************************************************************************
	function DebugSQL() {
	
		if ( $this->Debug_ShowSQL == true ) {
		
			print "[ $this->Debug_ObjectName ]->SQL = [ $this->SQL ];<br>";
		}
	
	}

}







class Database_MySQL extends Database {
// 
//  DESCRIPTION:
//		This child of the Database class is specifically suited to work with 
//		MySQL databases.
//
//	CONSTANTS:

//
//	VARIABLES:

//
//	CLASS CONSTRUCTOR
//

	//************************************************************************
	function Database_MySQL() {
	
		Database::Database();	//  Call the parent Class Constructor
	
	}

//
//	CLASS FUNCTIONS:
//

	//************************************************************************
	function connectToDB( $DBName, $Host='localhost', $UserName='', $PWord='') {
	
	    // Set the DB_Name value from given DBName.
	    $this->db_name = $DBName;
	    
		//  if DB Not already Initialized then
		if ( $this->Initialized == false ) {
		
			//  initialize DB
			$this->DBObject = mysql_connect( $Host, $UserName, $PWord) 
					or die("Can't connect to $Host");
					
			$Progress = "Connected to $Host ... ";
					
			mysql_select_db( $DBName, $this->DBObject ) 
					or die($Progress."Can't use DB: $DBName");
					
			//  Mark DB as initialized
			$this->Initialized = true;
		}
	
	}


	//************************************************************************
	function runSQL( $Query='<null>' ){

		//  TO DO:  Later can add support for sending multiple Queries in an Array...
		
		if ( $Query <> '<null>' ) {
			$this->SQL = $Query;
		}
			
		$this->DebugSQL();
		
		if ($this->Debug_SuppressErrors == TRUE) {
		
			$this->LastQueryResult = mysql_query( $this->SQL, $this->DBObject)
						or false;
			
		} else {
		
			$this->LastQueryResult = mysql_query( $this->SQL, $this->DBObject)
						or die( $this->SQL." --> ".mysql_error($this->DBObject) );
		}
		
		// Put Error Checking Here ...
		return $this->LastQueryResult;
		
	}
	
	
	//************************************************************************
	function retrieveSQL( $Query='<null>' ){

		// TO DO:  Later can add support for sending multiple Queries in an Array...
		
		if ( $Query <> '<null>' ) {
			$this->SQL = $Query;
		}
			
		$this->DebugSQL();
		
		$this->LastQueryResult = mysql_query( $this->SQL, $this->DBObject)
					or die( $this->SQL." --> ".mysql_error($this->DBObject) );
					
		return $this->LastQueryResult;
			
	}
	
	//************************************************************************
	function retrieveRow( ){
		
		// Put Error Checking Here ...
		//  Return an array fetch from the last run SQL statement.
		return mysql_fetch_array( $this->LastQueryResult, MYSQL_ASSOC);
			
	}
	
	
	//************************************************************************
	function retrievePrimaryKey( ){
	//
	//  This function will return the new Primary Key of an entry that was just
	//  INSERTed into a table.
	
		return mysql_insert_id(  $this->DBObject );
			
	}
	
	
		

}






class Database_ADOCOM extends Database {
// 
//  DESCRIPTION:
//		This child of the Database class is specifically suited to work with 
//		Access databases using ADO and COM.
//
//	CONSTANTS:

//
//	VARIABLES:

//
//	CLASS CONSTRUCTOR
//

	//************************************************************************
	function Database_ADOCOM() {
	
		Database::Database();	//  Call the parent Class Constructor
	
	}

//
//	CLASS FUNCTIONS:
//

	//************************************************************************
	function connectToDB( $DBName, $UserName='', $PWord='') {
	
	   $this->db_name = $DBName;
		
		//  if DB Not already Initialized then
		if ( $this->Initialized == false ) {
		
			//  initialize DB
			$this->DBObject = new COM("ADODB.Connection") or die("Cannot start ADO");
			
			$ConnectionString = "DRIVER={Microsoft Access Driver (*.mdb)}; DBQ=$DBName";
			
			if ($UserName != '')
				$ConnectionString .= "Uid=$UserName;Pwd=$PWord";
			
			//  connect to DB
			$this->DBObject->Open($ConnectionString);
			
			//  Mark DB as initialized
			$this->Initialized = true;
		}
	
	}


	//************************************************************************
	function runSQL( $Query='<null>' ){
		
		if ( $Query <> '<null>' ) {
			$this->SQL = $Query;
		}
			
		$this->DebugSQL();
		
		if ($this->Debug_SuppressErrors == TRUE) {
		
			$this->LastQueryResult = $this->DBObject->Execute($this->SQL)
						or false;
			
		} else {
		
			$this->LastQueryResult = $this->DBObject->Execute($this->SQL)
						or die( $this->SQL." --> caused a problem...");
		}
		
		return $this->LastQueryResult;
		
	}
	
	
	//*************************************************************************
	function Close() {
		
		if ($this->Initialized) {
			$this->DBObject->Close();
			$this->Initialized = false;
		}
		
	}
	
	

	
}





?>