<?php
/**
 * @package AIobjects	
 */
/**
 * class OldSiteViewer
 * <pre>
 * Copies the functionality of the Viewer object but access asp's database.
 * for use when someone doesn't really login but is directed from another site (where they previously logged in)
 *
 * Written By: Russ Martin
 *
 * Date: 01 Aug '05
 * </pre>
 */
class  OldSiteViewer {
// 		
//
//	CONSTANTS:
        
//	VARIABLES:
    /** @var [INT] The Unique Login ID of each User*/
		var $viewerID;
		
    /** @var [BOOL] Is the viewer properly authenticated?*/
		var $isAuthenticated;

    /** @var [BOOL] Does the Viewer have an active Session?*/
		var $hasSession;
		
    /** @var [OBJECT] The Viewer Manger to access the viewer DB table*/
		var $viewerManager;
		
		var $db;
				
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
    function __construct( $viewerID ) 
    {		
        $this->viewerID = $viewerID;
        $this->db = new Database_MySQL();
        $this->db->connectToDB( ASP_LOGIN_DB, ASP_DB_PATH, ASP_DB_USERNAME, ASP_DB_PWD );
        return;
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
        // session_destroy();
        // do nothing... this should never be called
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
		return true;
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
	   // really means get the regionID
		return $this->getRegionID();
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
	   $languageID = -1;
	   $sql = "Select login_LanguageID from ".ASP_LOGIN_DB.".login where login_ViewerID=" . $this->viewerID;
	   if ( $this->db->runSQL( $sql ) ) 
	   {
	       $row = $this->db->retrieveRow();
	       $languageID = $row['login_LanguageID'];
	   }
	   return $languageID;
	}
	
	
	
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
        $regionID = -1;
        $sql = "Select login_RegionID from ".ASP_LOGIN_DB.".login where login_ViewerID=" . $this->viewerID;
        if ( $this->db->runSQL( $sql ) ) 
        {
            $row = $this->db->retrieveRow();
            $regionID = $row['login_RegionID'];
        }
        return $regionID;
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
        $userID = -1;
        $sql = "Select login_UserID from ".ASP_LOGIN_DB.".login where login_ViewerID=" . $this->viewerID;
        if ( $this->db->runSQL( $sql ) ) 
        {
            $row = $this->db->retrieveRow();
            $userID = $row['login_UserID'];
        }
        return $userID;
		
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
		return $this->viewerID;
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
		return true;
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
	       
        // Create UPDATE SQL
        $updateSQL = "UPDATE ".ASP_LOGIN_DB.".login SET login_LanguageID=" . $langID ." WHERE login_ViewerID=". $this->viewerID;
        // echo 'Updating DB sql['.$updateSQL.']';
        $this->db->runSQL( $updateSQL );
	}
	
	
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
     *        set return value to false
     *    end if
     * else
     *     set return value to false
     * end if
	 * </code></pre>
	 * @param $userName [STRING] The User's Login User ID.
	 * @param $passWord [STRING] The User's UNENCRYPTED password
	 * @return [BOOL]
	 */
    function validateLogin( $userName='<null>', $passWord='<null>' ) 
    {
		return true;
	}
	
}

?>