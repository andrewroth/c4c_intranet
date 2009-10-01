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
        }

        if ($_SESSION[ SESSION_ID_ID ] == '') {
            $_SESSION[ SESSION_ID_ID ] = 0;
        }

        // Get current viewer ID from session ID
        $this->viewerID = $_SESSION[ SESSION_ID_ID ];

        // attempt to load a viewerManager object with current viewerID
        $this->viewerManager = new RowManager_ViewerManager( $this->viewerID );

        if ( $this->viewerManager->isLoaded() ) {

            // Update current Session ID with current ViewerID
            $_SESSION[ SESSION_ID_ID ] = $this->viewerID;

            if ($this->viewerManager->isActive() ) {
                $this->isAuthenticated = true;
            } else {
                $this->isAuthenticated = false;
            }

        } else { // Info not stored in session, get from GCX

            $this->isAuthenticated = false;

            if(CASUser::checkAuth())
            {
                if(!empty($_SESSION['phpCAS']['guid']))
                {
                    if($this->validateLogin($_SESSION['phpCAS']['guid']))
                    {
		    	// a user with this GUID exists in our system
                        $this->isAuthenticated = true;
                    }
		    else
		    {
		    	// code added by Russ September 11, 2009
		    	// a user with this GUID does not exist in our system - create them
			
			$guid = $_SESSION['phpCAS']['guid'];
			// echo "The GUID[".$guid."]<br/>";

			$gcxUsername =  $_SESSION['phpCAS']['user'];
			// echo "The gcxUsername[".$gcxUsername."]<br/>";
			
			// the gcxUsername is (supposed to be) an email
			// check to see if there is a cim_hrdb_person record with this email
			// the comparison needs to be case insensitive (since mysql is insensitive by default, no special doctoring is needed)

			// search for person record
			$personManager = new RowManager_PersonManager();
			$foundPerson = $personManager->loadByEmail($gcxUsername);
			
			// get the personID of the person that was searched
			$personID = $personManager->getID();
			
			// if record does not exist
			// create one
			// update the personID
			if (!$foundPerson)
			{
			    // create a new person record
			    $newpersonManager = new RowManager_PersonManager();
			    $newpersonManager->setEmail( $gcxUsername );
			    $newpersonManager->createNewEntry();
			    $personID = $newpersonManager->getID();
			}
			
			// link the personID to the GUID/viewer in the cim_hrdb_access table
			// first, check to see if any entry already exists in the access table 
			// if foundPerson is true above, it's possible (may have been linked to old viewer/username but not promoted to GCX account yet)

			$accessManager = new RowManager_AccessManager();
			$accessEntryFound = $accessManager->loadByPersonID($personID);
			$viewerID = -1;
			$createNewViewer = true;
			if ( $accessEntryFound )
			{
			    $viewerID = $accessManager->getViewerID();
        		    $viewerManager = new RowManager_ViewerManager($viewerID);

			    // double check to make sure the viewer referenced in the access table actually exists
			    $viewerAlreadyExists = $viewerManager->isLoaded();
			    if ( $viewerAlreadyExists )
			    {
			    	// no need to create a new viewer
			    	$createNewViewer = false;

				// update the existing viewer with the GUID and gcxUsername
				$viewerManager->setGUID($guid);
				$viewerManager->setUserID($gcxUsername);
				$viewerManager->setLastLogin();
				$viewerManager->updateDBTable();
			    } // viewerAlreadyExists
			} // accessEntryFound

			if ( $createNewViewer )	
			{
			    // create new viewer (user)
        		    $newviewerManager = new RowManager_ViewerManager();
	        	    $newviewerManager->setPassWord( 'xxx' );
		            $newviewerManager->setUserID( $gcxUsername  );
			    $newviewerManager->setLanguageID( 1 ); // english
			    // TODO this value should not be hard-coded for the account group
			    $newviewerManager->setAccountGroupID( 15 ); // the 'unknown' group
			    $newviewerManager->setIsActive( true );
			    $newviewerManager->setGUID($guid);
			    $newviewerManager->setLastLogin();
			    $newviewerManager->createNewEntry();
			    $viewerID = $newviewerManager->getID(); // get the ID of the newly created viewer

			    if ( $accessEntryFound )
			    {
			    	// update the access table to reference the newly created viewer for the persoa
				// this is the case where an access table entry may have been orphaned due to the deletion of a viewer
				$accessManager->setViewerID($viewerID);
				$accessManager->updateDBTable();
			    }
			    else
			    {
			    	// create an access table entry
				$newaccessManager = new RowManager_AccessManager();
				$newaccessManager->setViewerID( $viewerID );
				$newaccessManager->setPersonID( $personID );
			        $newaccessManager->createNewEntry();
			    }
			}

			// put into the 'all' access group
		        $viewerAccessGroupManager = new RowManager_ViewerAccessGroupManager();
			$viewerAccessGroupManager->setViewerID( $viewerID );
			$viewerAccessGroupManager->setAccessGroupID( ALL_ACCESS_GROUP ); // add to the 'all' access group
			$viewerAccessGroupManager->createNewEntry();

		    	// Debugging code added by Russ Martin
			// echo "validate login failed<br/>";
			// echo "<pre>".print_r($_SESSION,true)."</pre>";

			// try again to see if everything updated correctly
			if ( $this->validateLogin($guid))
			{
			    // a user/viewer with this GUID now exists in our system
                            $this->isAuthenticated = true;
			}
			else
			{
			    echo "Something has gone wrong: gcxUsername[".$gcxUsername."], guid[".$guid."]<br/>";
			}
		    }
                }
		else
		{
		    // Debugging code added by Russ Martin
		    // echo "session variable for storing GUID is empty<br/>";
		}
            }
	    else
	    {
	    	// Debugging code added by Russ Martin
	    	// echo "CASUser::checkAuth() failed<br/>";
	    }
        }

        // set hasSession
        $this->hasSession = ($this->viewerID != '');

        // if no session  
        if (!$this->hasSession) {

            // User Credentials are invalid so
            // if they want me to destroy the session then
            if ($isDestroySession == true ) {
                    // Remove session
                    // session_destroy();	
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
  * @param $guid [STRING] The User's GCX GUID
  * @return [BOOL]
  */
    function validateLogin( $guid ) 
    {
        // attempt to load viewerManager with found GUID
        $this->viewerManager->loadByGUID($guid);
        
        // if viewerManager is successfully loaded then data was a 
        // valid login
        if ( $this->viewerManager->isLoaded() ) {

            // mark a valid login
            $this->isAuthenticated = true;

            // update the viewer's last login info
            $this->viewerManager->setLastLogin();
            $this->viewerManager->updateDBTable();

            // Update current Session ID with current ViewerID
            $_SESSION[ SESSION_ID_ID ] = $this->viewerManager->getID();
        } else {
            $this->isAuthenticated = false;  // Invalid Login
        }

        // return the whether or not the user was validated
        return $this->isAuthenticated;
    }
}

?>
