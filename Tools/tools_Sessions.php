<?php


//
//  SESSION TOOLS
// 
//  DESCRIPTION:
//		This set of routines helps us to store and retrieve session data 
//      into our DB.
//
//	CONSTANTS:


//
//	VARIABLES:
	$sessionDB = NULL;
	

$Session_Debug_String = "Session Debugging Data:<br>";

//
// FUNCTIONS:
//



//************************************************************************
function on_session_start( $save_path, $session_name) {

	global $sessionDB;
	
	// echo 'Called session_start()<br/>';
	
	$sessionDB = new Database_Site();
	$sessionDB->connectToDB( SITE_DB_NAME, SITE_DB_PATH, SITE_DB_USER, SITE_DB_PWORD );
	$sessionDB->doSuppressErrors();

}



//************************************************************************
function on_session_end() {

// Nothing done here...

}




//************************************************************************
function on_session_read( $key ) {

	global $sessionDB;
	global $Session_Debug_String;
	
	$Time = time();
	
	$SQL = "SELECT session_data FROM ".SITE_DB_NAME.".".DB_TABLE_SESSION." ";
	$SQL .= "WHERE session_id='$key' ";
	$SQL .= "AND session_expiration > $Time";

	$Session_Debug_String .= "on_session_read:: SQL=[ $SQL ]<br>";

	if ( $sessionDB->runSQL( $SQL ) ) {
	
		$Row = $sessionDB->retrieveRow();
	
		$SessionData = $Row['session_data'];
	
	} else {
		$SessionData = "";
	}
	
	$Session_Debug_String .= "Data Returned = [ $SessionData ]<br>";
	
	return $SessionData;

}



//************************************************************************
function on_session_write( $key, $value) {

	global $sessionDB;
//	global $Session_Debug_String;
    

	
	$value = addslashes($value);
	
	$Time = time();
	
	$aDB = new Database_Site();
	$aDB->connectToDB( SITE_DB_NAME, SITE_DB_PATH, SITE_DB_USER, SITE_DB_PWORD );

	// first try to run the Insert SQL, if it fails than there already exists
	// a session entry for this KEY, so run the Update SQL.
	//     NOTE: your DB object needs to be able to fail gracefully from 
	//           the runSQL()
	

   $selectSQL = "SELECT * FROM ".SITE_DB_NAME.".".DB_TABLE_SESSION." WHERE session_id=\"".$key."\"";
   $aDB->runSQL( $selectSQL );
   if ( $row = $aDB->retrieveRow() )
   {
      // this key already exists, do an update
      // Create UPDATE SQL
      $updateSQL = "UPDATE ".SITE_DB_NAME.".".DB_TABLE_SESSION." SET session_data='$value', ";
      $updateSQL .= "session_expiration=$Time+1800 ";
      $updateSQL .= "WHERE session_id='$key'";
      $aDB->runSQL( $updateSQL );
   }
   else
   {
      // this key does not exist, do an insert
      $insertSQL = "INSERT INTO ".SITE_DB_NAME.".".DB_TABLE_SESSION." (session_id, session_data, session_expiration) VALUES ('$key', '$value', $Time+18000)";
      $aDB->runSQL( $insertSQL );
   }

}



//************************************************************************
function on_session_destroy( $key ) {

	global $sessionDB;
	
	
	$SQL = "DELETE FROM ".SITE_DB_NAME.".".DB_TABLE_SESSION." WHERE session_id='$key'";
	$sessionDB->runSQL( $SQL );


}



//************************************************************************
function on_session_gc( $max_lifetime ) {

	global $sessionDB;
	
	$Time = time();
	
	$SQL = "DELETE FROM ".SITE_DB_NAME.".".DB_TABLE_SESSION." WHERE session_expiration < $Time";
	$sessionDB->runSQL( $SQL );
	
}


	
//************************************************************************
function sessionsCreateTable($dbUse) {
/* A fuction called to create the session table this object works with*/
    $sql = "CREATE TABLE ".DB_TABLE_SESSION." (
  session_id varchar(32) NOT NULL default '',
  session_data text NOT NULL,
  session_expiration int(11) NOT NULL default '0',
  PRIMARY KEY  (session_id)
) TYPE=MyISAM";

    if (!$dbUse->runSQL( $sql ) ) {
        echo '<tr><td><font color="#FF0000">'.$sql."</font></td></tr>\n";
    }
}




//************************************************************************
function sessionsDropTable($dbUse) {
/* A fuction called to drop the session table this object works with*/
    $sql = "DROP TABLE IF EXISTS ".DB_TABLE_SESSION;
        
    if (!$dbUse->runSQL( $sql ) ) {
        echo '<tr><td><font color="#FF0000">'.$sql."</font></td></tr>\n";
    }
}


session_set_save_handler (  "on_session_start",   "on_session_end",
							"on_session_read",    "on_session_write",
							"on_session_destroy", "on_session_gc");
							
session_start();

if ( !isset( $_SESSION['codeProfiler'] ))
{
    $_SESSION['codeProfiler'] = new CodeProfiler();
}


?>