<?php
/**
 * @package AIobjects	
 */
/**
 * class Viewer
 * <pre>
 * The Viewer Object is responsible for tracking the information of the person
 * Viewing the page.  It manages the following:
 *  - the authentication process
 *  - verifies proper authentication of the viewer
 *  - provides necessary Viewer information to displaying pages: ViewerID & Language ID
 *
 * Written By: Johnny Hausman
 *
 * Date: 14 Aug '04
 * </pre>
 */

require_once("findGUID.php");
require_once("viewer_guid_connect.php");

class  Viewer {
// 		
//
//	CONSTANTS:
        
    /*! const DB_TABLE_LOGIN  Name of the Login Table. */
        const DB_TABLE_LOGIN = 'site_viewer_login';
        
        
//
//	VARIABLES:
    /** @var [INT] The Unique Login ID of each User*/
		var $viewerID;
		
    /** @var [BOOL] Is the viewer properly authenticated?*/
		var $isAuthenticated;

    /** @var [BOOL] Does the Viewer have an active Session?*/
		var $hasSession;
		
    /** @var [OBJECT] An object to track this viewer's permissions within a module.  This object will be created and set by the running module. */
		var $permissionsManager;
		
    /** @var [OBJECT] The Viewer Manger to access the viewer DB table*/
		var $viewerManager;
				
	//
	//	CLASS CONSTRUCTOR
	//************************************************************************
	/** 
	 * function __construct
	 * This is the class constructor for Viewer class
	 
	 * Initialize a Viewer and determine if they are properly authenticated. 	
	 * <pre><code>
	    * Save the DB connection Info
	    * If no session ID is set then
        *    set the Session ID to empty string
        * end if
        * Get current viewer ID from session ID
        * If viewer ID is empty then
        *    if isDestroySession is set then
        *        Destroy the Session
        *    end if
        *    initialize Empty UnAuthorized Viewer ID
        * else 
        *     User Credientials are valid so ...
		*	 Mark as Valid Authentication	
        *     
		*	 Prepare an SQL statement to lookup the viewer info from the DB
		*	 Now load the Data from the DB
        * end if
	 * </pre>
	 * @param $isDestroySession [BOOL] Should we destroy the session data if not authenticated?
	 * @param $dbName [STRING] The name of the database the viewer info is stored in
	 * @param $dbPath [STRING] The path of the database the viewer info is stored in
	 * @param $dbUser [STRING] The login ID for the database the viewer info is stored in
	 * @param $dbPassword [STRING] The password of the database the viewer info is stored in
	
	*/
    function __construct( $isDestroySession=true, $dbName=SITE_DB_NAME, $dbPath=SITE_DB_PATH, $dbUser=SITE_DB_USER, $dbPassword=SITE_DB_PWORD) 
    {		
		// if no session ID is set then
		if (!isset( $_SESSION[ SESSION_ID_ID ] ) ) {
	
            // set the Session ID to empty string
			$_SESSION[ SESSION_ID_ID ] = '';
			
		} // end if

		// ************** I ADDED THIS (Andrew)
        if ($_SESSION[ SESSION_ID_ID ] == '') {
            $_SESSION[ SESSION_ID_ID ] = 0;
        }
        // Get current viewer ID from session ID
		$this->viewerID = $_SESSION[ SESSION_ID_ID ]; 
    
        // attempt to load a viewerManager object with current viewerID
        $this->viewerManager = new RowManager_ViewerManager( $this->viewerID );
        
        // if viewerManager successfully loaded
        if ( $this->viewerManager->isLoaded() ) {
        
            // Update current Session ID with current ViewerID
            $_SESSION[ SESSION_ID_ID ] = $this->viewerID;
            
            if ($this->viewerManager->isActive() ) {
            
                // mark Viewer as properly authenticated
                $this->isAuthenticated = true;
            
            } else {
            
                // mark Viewer as not authenticated
                $this->isAuthenticated = false;
            }
            
        } else {
        
            // mark Viewer as not authenticated
            $this->isAuthenticated = false;
        }
        
        // set hasSession
        $this->hasSession = ($this->viewerID != '');
        
        // if no session  
		if (!$this->hasSession) {
			
			// User Credentials are invalid so
			// if they want me to destroy the session then
			if ($isDestroySession == true ) {
                // Remove session
//                session_destroy();	
			}
		}
	
	}

	//
	//	CLASS FUNCTIONS:
	//
	
	
	
	//************************************************************************
	/** 
	 * function assumeValidSession
	 * <pre>
	 * Set's the hasSession flag to true.
	 *
	 * This routine is primarily used for the Login page to have the
	 * viewer object ignore the fact that it doesn't have a Session.
     * </pre>
     * @return [void]
	 */
	function assumeValidSession() 
	{
		$this->hasSession = true;
	}
	
	
	
    //************************************************************************
	/** 
	 * function deleteSession
     * <pre>
	 * Delete this viewer's session info.  Used primarily for logout function.
	 * </pre>
	 * @return [void]
	 */
	function deleteSession() 
	{
        session_destroy();
	}
	
	
	
	//************************************************************************
	/** 
	 * function isAuthenticated
	 * <pre>
	 * Returns the value of the current Authentication status.
     * </pre>
	 * @return [BOOL]
	 */
    function isAuthenticated() 
    {
		return $this->isAuthenticated; // removed by RM on May 8, 2008
        /*echo "this->isAuthenticated[".$this->isAuthenticated."]<br/>";
        echo "phpCAS::isAuthenticated()[".phpCAS::isAuthenticated()."]<br/>";
		return (($this->isAuthenticated) || (phpCAS::isAuthenticated()));*/
	}
	
	
	
	//************************************************************************
	/** 
	 * function getAccountGroupID
	 * <pre>
	 * Returns the value of the current viewer's Account Group ID.
     * </pre>
	 * @return [INTEGER]
	 */
	function getAccountGroupID() 
	{
		return $this->viewerManager->getAccountGroupID();
	}
	
	
	
	//************************************************************************
	/** 
	 * function getID
	 * <pre>
	 * Returns the value of the current Viewer ID.
	 * </pre>
	 * @return [INTEGER]
	 */
    function getID() 
    {
		return $this->getViewerID();
	}
	
	
	
	//************************************************************************
	/** 
	 * function getLanguageID
	 * <pre>
	 * Returns the value of the current Language ID.
     * </pre>
	 * @return [INTEGER]
	 */
	function getLanguageID() 
	{
		return $this->viewerManager->getLanguageID();
	}
	
	
	
	//************************************************************************
	/** 
	 * function getPassword
	 * <pre>
	 * Returns the value of the viewers (Encrypted) password.
	 * </pre>
	 * @return [STRING]
	 */
    function getPassword() 
    {
		return $this->viewerManager->getPassword();
		
	} // end getUserID()
	
	
	
	//************************************************************************
	/** 
	 * function getPermissionsManager()
	 * <pre>
	 * Returns the permissions manager for this viewer.
	 * </pre>
	 * @return [OBJECT]
	 */
    function getPermissionsManager() 
    {
        if (isset( $this->permissionsManager ) ) {
        
            return $this->permissionsManager;
            
        } else {
        
            return false;
		}
	} // end getUserID()
	
	
	
	//************************************************************************
	/** 
	 * function getRegionID
	 * <pre>
	 * Returns the value of the current viewer's Region ID.
	 * </pre>
	 * @return [INTEGER]
	 */
    function getRegionID() 
    {
		return $this->viewerManager->getRegionID();
	}
	
	
	
	//************************************************************************
	/** 
	 * function getUserID
	 * <pre>
	 * Returns the value of the current viewer's User ID.
	 * </pre>
	 * @return [INTEGER]
	 */
    function getUserID() 
    {
		return $this->viewerManager->getUserID();
		
	} // end getUserID()
	
	
	
	//************************************************************************
	/** 
	 * function getViewerID
	 * <pre>
	 * Returns the value of the current Viewer ID.
	 * </pre>
	 * @return [INTEGER]
	 */
    function getViewerID() 
    {
		return $this->viewerManager->getID();
	}
	
	
	
	//************************************************************************
	/** 
	 * function lookupUserID
	 * <pre>
	 * Load a viewer Object from a given UserID.
	 * </pre>
	 * <pre><code>
	 * if a userName was given then
     *   check to see if the given Username is in DB
     *   if we successfully loaded then
     *       mark as Authenticated
     *       return Success
     *   else
     *       mark as UNAuthenticated
     *       return failure
     *   end if
     * else
     *   return failure
     * end if
	 * </code></pre>
	 * @param $userName [STRING] The Website User ID of the viewer
	 * @return [BOOL] True if userName was found. False otherwise.
	 */
    function lookupUserID( $userName='<null>' ) 
    {
		// if a userName was given then 
		if ( $userName != '<null>' ) {

            // have viewerManager attempt to load using that userName
            $this->viewerManager->loadByUserID( $userName );
			
            // isAuthenticated == the result of whether the viewerManager 
            // was loaded
			$this->isAuthenticated = $this->viewerManager->isLoaded();
			
		} else {
			
			// return Failure
			$this->isAuthenticated = false;
		}
		
		return $this->isAuthenticated;
	}
	
	//************************************************************************
	/** 
	 * function setGUID
	 * <pre>
	 * Sets the user's GUID. 
	 * </pre>
     * @param $GUID [STRING] New value of GUID
	 * @return [void]
	 */
	function setGUID( $GUID ) 
	{
        $this->viewerManager->setGUID( $GUID );
	}
	
	
	
	//************************************************************************
	/** 
	 * function setLanguageID
	 * <pre>
	 * Sets the value of the viewers desired Language ID.
	 * </pre>
     * @param $langID [INT] New Value of preferred Language ID
	 * @return [void]
	 */
	function setLanguageID( $langID ) 
	{
        $this->viewerManager->setLanguageID( $langID );
	}
	
	
	
	//************************************************************************
	/** 
	 * function setPermissionsManager()
	 * <pre>
	 * Sets the permissions manager for this viewer.  This is performed by
	 * the running Module.  
	 * </pre>
	 * @param $permissionsManager [OBJECT] A module defined permissions manager
	 */
    function setPermissionsManager( $permissionsManager ) 
    {
        $this->permissionsManager = $permissionsManager;
	} // end getUserID()
	
	
	
	//************************************************************************
	/** 
	 * function validateLogin
	 * <pre>
	 * This method checks to see if the given username & pword are valid.
     * </pre>
     * <pre><code>
     * If a username and password are given then
     *    encrypt the password
     *    attempt to load the data from the DB
     *    if properly loaded then
     *        mark that viewer is authenticated
     *        update user's "last Login Info"
     *    else
     *        proceed to GCX and find GUID, then attempt to load again
     *    end if
     * else
     *     set return value to false
     * end if
	 * </code></pre>
	 * @param $userName [STRING] The User's Login User ID or GCX login
	 * @param $passWord [STRING] The User's UNENCRYPTED password (or GCX's)
	 * @return [BOOL]
	 */
    function validateLogin( $userName='<null>', $passWord='<null>' ) 
    {

		// if userName and passWord were provided then 
		if ( $userName != '<null>' && $passWord != '<null>') 
		
		  {
			
			// attempt to load viewerManager with given userName & pWord
			$this->viewerManager->loadByUserIDPWord( $userName, $passWord);
			
            // if viewerManager is successfully loaded then data was a 
            // valid login
			if ( $this->viewerManager->isLoaded() ) {

				
                // mark a valid login
                $this->isAuthenticated =true;
                
                // update the viewer's last login info
                $this->viewerManager->setLastLogin();
                $this->viewerManager->updateDBTable();
            

                // Update current Session ID with current ViewerID
                $_SESSION[ SESSION_ID_ID ] = $this->viewerManager->getID();
                
       
                
 			} else {


		// if !isAuthenticated
		//		check GCX and get guid from gcx
		//		loadByGUID() // does some internal stuff
		//		setLastLogin()
		//		updateDBTable()
		
			//find GUID of the user, based on user's GCX login and password
			$guid = findUserGUID($userName,$passWord);
			
		//	echo "the guid is [".$guid."]<br/>";
			
			//If user's ID and password returns a GUID
			if ($guid) {
			
				// attempt to load viewerManager with found GUID
				$this->viewerManager->loadByGUID($guid);
				
			   // if viewerManager is successfully loaded then data was a 
	            // valid login
				if ( $this->viewerManager->isLoaded() ) {
					
			//		echo "Found a viewer with guid[".$guid."]<br/>";

	                // mark a valid login
	                $this->isAuthenticated = true;

	                // update the viewer's last login info
	                $this->viewerManager->setLastLogin();
	                $this->viewerManager->updateDBTable();

	                // Update current Session ID with current ViewerID
	                $_SESSION[ SESSION_ID_ID ] = $this->viewerManager->getID();
	
				} else {
				
					//Case: Valid GCX login, first time, now ask if user has exisitng Intranet UserID and PWord
					
		
					
					header('Location: https://intranet.campusforchrist.org/modules/app_cim_newaccount/index.php?P=P37&GUID='.$guid);	
					die;                             //go to GCXFirstLogin page. HARDCODED stuff
					
					if ($entered_correct_intranet_login)
					{ 
					    //insert GUID into exisitng viewer
					   viewer_guid_connect($guid,$viewer,false); 
					  	
					} else {
					   //creating new viewer, person, access , etc. (true stands for "please make a new viewer")
					   viewer_guid_connect($guid,0,true); 					
                    }
					
										
						//loadByGUID again
							$this->viewerManager->loadByGUID($guid);

						   // if viewerManager is successfully loaded then data was a 
				            // valid login
							if ( $this->viewerManager->isLoaded() ) 
							 {

				                // mark a valid login
				                $this->isAuthenticated = true;

				                // update the viewer's last login info
				                $this->viewerManager->setLastLogin();
				                $this->viewerManager->updateDBTable();

				                // Update current Session ID with current ViewerID
				                $_SESSION[ SESSION_ID_ID ] = $this->viewerManager->getID();
				                
				              
				
			                  }
			                  
			                 }
				        
				        
				            } else $this->isAuthenticated = false;  // both login don't match
	
			       }     
	        
	        }	 
	        
         // return the wether or not the user was validated
            return $this->isAuthenticated;
        }
    
}

?>
