<?php
/**
 * @package AIObjects
 */ 
/**
 * class SystemAccess
 * <pre> 
 * This object defines a generic System Access Object for a module.  The system
 * access object is a way for a module to prepare it's content for a user 
 * account when they are added (or removed) from the system.  If a system Access 
 * object is defined for a module, then that object will be created and it's 
 * newViewer(), or removeViewer() routines run when a new web user account is 
 * created/removed.
 * </pre>
 * @author Johnny Hausman
 */
abstract
class  SystemAccess {
	
	
	//CLASS CONSTRUCTOR
	//************************************************************************
	/**
	 * function __construct
	 * <pre>
	 * Initialize the Object.
	 * </pre>
	 * @return [void]
	 */
    function __construct( ) 
    {
    
    }
    
    
    
    //************************************************************************
	/**
	 * function newViewer
	 * <pre>
	 * makes sure a proper environment is created for a new user account.
	 * </pre>
	 * @param $viewerID [INTEGER] the unique viewer_id for this new account
	 * @return [void]
	 */
    abstract
    function newViewer( $viewerID );//{} 
    // NOTE: the //{} are here to trick SubEthaEdit into recognizing these
    // as functions. php5 doesn't need them
    
    
    
    //************************************************************************
	/**
	 * function removeViewer
	 * <pre>
	 * removes any neccessary info for an account that has been removed.
	 * </pre>
	 * @param $viewerID [INTEGER] the unique viewer_id for this removed account
	 * @return [void]
	 */
    abstract
    function removeViewer( $viewerID );//{}
	// NOTE: the //{} are here to trick SubEthaEdit into recognizing these
    // as functions. php5 doesn't need them
}

?>