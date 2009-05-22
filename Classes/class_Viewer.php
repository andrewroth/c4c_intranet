<?php
/*!
 @class Viewer
 @discussion <pre>
 The Viewer Object is responsible for tracking the information of the person
 Viewing the page.  It manages the following:
   - the authentication process
   - verifies proper authentication of the viewer
   - provides necessary Viewer information to displaying pages: ViewerID & Language ID
 
 Written By	:	Johnny Hausman
 
 Date		:    14 Aug '04
 </pre>	
*/
class  Viewer {

//
//	VARIABLES:
    /*! var $viewerID       [INT] The Unique Login ID of each User*/
		var $viewerID;
		
    /*! var $userID         [STRING] Their Website Username */
		var $userID;
				
    /*! var $passWord       [STRING] Their Website Password (encrypted) */
		var $passWord;	
		
    /*! var $languageID     [INT] The Viewer's desired Language ID */
		var $languageID;	
		
    /*! var $regionID       [INT] The viewer's region */
		var $regionID;
		
    /*! var $isActive       [BOOL] Indicates if the current User's Account is active*/
		var $Active;
		
    /*! var $isAuthenticated       [BOOL] Is the viewer properly authenticated?*/
		var $isAuthenticated;
		
    /*! var $db             [OBJECT] A DB object for access the DB. */
        var $db;
		
    /*! var $dbName         [STRING] The DB Name of the Viewer Info */
		var $dbName;
		
    /*! var $dbPath         [STRING] The connection path to the DB */      
		var $dbPath;
		
    /*! var $dbUserID       [STRING] The DB Login ID */
		var $dbUserID;
		
    /*! var $dbPassword       [STRING] The DB Password */
		var $dbPassword;
		
//
//	CLASS CONSTRUCTOR
//



    //************************************************************************
	/*! 
	 @function __contruct
	 
	 @abstract Initialize a Viewer and determine if they are properly authenticated. 	
	 @discussion <pre>
	 // If no session ID is set then
            set the Session ID to empty string
        end if
        Get current viewer ID from session ID
        If viewer ID is empty then
            if isDestroySession is set then
                Destroy the Session
            end if
            initialize Empty UnAuthorized Viewer ID
        else 
             User Credientials are valid so ...
			 Mark as Valid Authentication	
             Save the DB connection Info

			 Prepare an SQL statement to lookup the viewer info from the DB

			 Now load the Data from the DB
        end if
	 </pre>
	 @param $isDestroySession [BOOL] Should we destroy the session data if not authenticated?
	 @param $dbName [STRING] The name of the database the viewer info is stored in
	 @param $dbPath [STRING] The path of the database the viewer info is stored in
	 @param $dbUser [STRING] The login ID for the database the viewer info is stored in
	 @param $dbPassword [STRING] The password of the database the viewer info is stored in
	
	*/
	function Viewer( $isDestroySession=true, $dbName=DB_NAME_VIEWER, $dbPath=DB_PATH, $dbUser=DB_USER, $dbPassword=DB_PWORD) {
		
		// if no session ID is set then
		if (!isset( $_SESSION['ID'] ) ) {
		
            // set the Session ID to empty string
			$_SESSION['ID'] = '';
			
		} // end if


        // Get current viewer ID from session ID
		$this->viewerID = $_SESSION['ID']; 

    
        // if viewer ID is empty 
		if ($this->viewerID == "") {
			
			// User Credentials are invalid so
			// if they want me to destroy the session then
			if ($isDestroySession == true ) {
			
                // Remove session
				session_destroy();					
			}
			
			// Mark as InValid Authentication
			$this->isAuthenticated = false;		
		
		} else {
		
			// User Credientials are valid so ...
			// Mark as Valid Authentication
			$this->isAuthenticated = true;		


            // Now remember the DB connection Info
			$this->dbName	=	$dbName;		
			$this->dbPath	=	$dbPath;	
			$this->dbUserID	=	$dbUser;
			$this->dbPassword	=	$dbPassword;
			
			// Prepare an SQL statement to lookup the viewer info from the DB
			$sql = "SELECT * FROM login.login WHERE login_ViewerID=".$this->viewerID."  AND login_Active=1";
			
			// Now load the Data from the DB
			$this->loadValuesFromDB( $sql );
			
		}
	
	}

//
//	CLASS FUNCTIONS:
//
	
	
	//************************************************************************
	/*! 
	 @function loadValuesFromDB
	 
	 @abstract This method loads the objects data from the database.
    
    @discussion <pre>
        if viewer is properly authenticated then
            create a
	 </pre>
	 @param $param1 [parameter Description]
	 @param $param2 [parameter Description]
	
	 @result [BOOL] True if we were able to load the given SQL statement. False otherwise.
	*/
	function loadValuesFromDB( $sql ) {
	
	   $returnValue = false;
	

        // if this viewer had been "Authenticated" then 
        if ( $this->isAuthenticated = true ) {
        
            // Create DB connection
            $this->db = new Database_MySQL;	// Now Pull Viewer's data from the Login Table
			$this->db->connectToDB( $this->dbName, $this->dbPath, $this->dbUserID, $this->dbPassword );
			
			// Run provided SQL statement
			if ( $this->db->runSQL( $sql ) == true ) {
			
                // if a valid recordset is retrieved then
				if ( $row = $this->db->retrieveRow() ) {
   
                    // Initialize Object Data to recordset values
					$this->viewerID = $row['login_ViewerID'];
					$this->userID 	= $row['login_UserID'];	// Assign Login Data to Viewer
					$this->passWord	= $row['login_PWord'];
					$this->languageID = $row['login_LanguageID'];
					$this->regionID = $row['login_RegionID'];
					
					if ( $row['login_Active'] == 1 ) {	// Make sure Active is boolean.
						$this->isActive = true;
			   		} else {
			   			$this->isActive = false;
			   		}
			   		
			   		// Update current Session ID with current ViewerID
					$_SESSION['ID'] = $this->viewerID;
						
					$returnValue = true;
				
				} else {
				
				    // Since no row was retrieved, 
				    // initialize data to empty values
					$this->viewerID = -1;
					$this->userID 	= '';
					$this->passWord	= '';
					$this->languageID = '';
					$this->regionID = '';
					$this->isActive	= false;
				
					$returnValue = false;
				}
				 
			} else {
			
                // Unable to run the SQL statment, 
                // return false
				$returnValue = false;
			
			}
			
		} else {	

            //  Viewer Object Not Authenticated.  Give Warning and exit.
			die("[Viewer->loadFromDB()] : Viewer Object was not properly Authenticated.<br>Unable to LoadValuesFromDB();");
		
		}
		
		
		return $returnValue;
	
	}
	
	
	
	//************************************************************************
	/*! 
	 @function validateLogin
	 
	 @abstract This method checks to see if the given username & pword are valid.
    
    @discussion <pre>
        If a username and password are given then
            encrypt the password
            attempt to load the data from the DB
            if properly loaded then
                mark that viewer is authenticated
                update user's "last Login Info"
            else
                set return value to false
            end if
        else
            set return value to false
        end if
	 </pre>
	 @param $userName [STRING] The User's Login User ID.
	 @param $passWord [STRING] The User's UNENCRYPTED password
	 	
	 @result [BOOL] True if supplied userName & passWord are correct. False if not.
	*/
	function validateLogin( $userName='<null>', $passWord='<null>' ) {
	
        $returnValue = false;
        
		// if userName and passWord were provided then 
		if ( $userName != '<null>' && $passWord != '<null>') {
			
			// encrypt password
			$passWord = md5( $passWord );
			
			
			// attempt to load viewer data from the DB with given ID & Pword
			$sql = "SELECT * FROM login WHERE login_UserID='$userName' AND login_PWord='$passWord' AND login_Active=1";
			
			// if properly loaded then 
			if ( $this->loadValuesFromDB( $sql) == true ) {
			
                // mark that viewer is authenticated
				$this->isAuthenticated = true;
				
				// update this user's Last Login Info...
				$sql = "UPDATE login SET login_date='".date("Y-m-d")."' WHERE login_ViewerID=".$this->viewerID;
				$this->db->runSQL( $sql );
				
				$returnValue = true;
				
			} else {
			
				$this->isAuthenticated = false;
				$returnValue = false;	
			}
			
		} else {
			
			$returnValue = false;
		
		}
		
		// return the wether or not the user was validated
		return $returnValue;
	}
	
	
	
	//************************************************************************
	/*! 
	 @function lookupUserID
	 
	 @abstract Load a viewer Object from a given UserID.
	
	 @discussion <pre>
	 if a userName was given then
        check to see if the given Username is in DB
        if we successfully loaded then
            mark as Authenticated
            return Success
        else
            mark as UNAuthenticated
            return failure
        end if
    else
        return failure
    end if
	 </pre>
	 @param $userName [STRING] The Website User ID of the viewer
	
	 @result [BOOL] True if userName was found. False otherwise.
	*/
	function lookupUserID( $userName='<null>' ) {
	
	   $returnValue = false;
	
		// if a userName was given then 
		if ( $userName != '<null>' ) {

			// check to see if the given Username is in DB
			$sql = "SELECT * FROM login WHERE login_UserID='".$userName."' AND login_Active=1";
			
            // if we successfully loaded then
			if ( $this->loadValuesFromDB( $sql) == true ) {
			
                // mark as Authenticated 
				$this->isAuthenticated = true;
				
				// return Success
				$returnValue = true;
				
			} 
			else {
			
                // mark as UNAuthenticated
				$this->isAuthenticated = false;

                
                // return Failure
				$returnValue = false;	
			}
			
		} 
		else {
			
			// return Failure
			$returnValue = false;
		
		}
		
		return $returnValue;
	}
	
	
	
	//************************************************************************
	/*! 
	 @function isAuthenticated
	 
	 @abstract Returns the value of the current Authentication status.
	
	 @discussion <pre>
	 return the value of the current Authentication status
	 </pre>
	
	 @result [BOOL] Value of current Authentication status.
	*/
	function isAuthenticated() {

		
		return $this->isAuthenticated;
	}
	
}






?>