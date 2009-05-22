<?php

class PermissionManager {

	//CONSTANTS:
	const PERMISSION_NATIONAL = 45;
	const PERMISSION_REGIONAL = 44;
	const PERMISSION_CAMPUSDIRECTOR = 43;
	const PERMISSION_STATSCOORDINATOR = 42;
	const PERMISSION_ALLSTAFF = 41;

	//VARIABLES:
	
	protected $isNational;
	protected $isRegional;
	protected $isCD;
	protected $isStatsCoordinator;
	protected $isAllStaff;
	/**
	 * function constructor
	 * <pre>
	 * sets the objects variables
	 * </pre>
	 * @return [void]
	 */
	//CLASS CONSTRUCTOR
    function __construct( $viewerID ) 
    {
        $accessGroupManager = new RowManager_ViewerAccessGroupManager();
  

  
        // the permissions are scaled if you have n permission you all have any permission < n
        $this->isNational = $accessGroupManager->loadByViewerAccessGroup( $viewerID, PermissionManager::PERMISSION_NATIONAL );
        // echo 'isNational['.$isNational.']<br/>';
        $this->isRegional = $accessGroupManager->loadByViewerAccessGroup( $viewerID, PermissionManager::PERMISSION_REGIONAL ) || $this->isNational;
        // echo 'isRegional['.$isRegional.']<br/>';
        $this->isCD = $accessGroupManager->loadByViewerAccessGroup( $viewerID, PermissionManager::PERMISSION_CAMPUSDIRECTOR ) || $this->isRegional;
        // echo 'isCD['.$isCD.']<br/>';
        $this->isStatsCoordinator = $accessGroupManager->loadByViewerAccessGroup( $viewerID, PermissionManager::PERMISSION_STATSCOORDINATOR ) || $this->isCD;
        // echo 'isStatsCoordinator['.$isStatsCoordinator.']<br/>';
        $this->isAllStaff = $accessGroupManager->loadByViewerAccessGroup( $viewerID, PermissionManager::PERMISSION_ALLSTAFF ) || $this->isStatsCoordinator;
        // echo 'isAllStaff['.$isAllStaff.']<br/>';
          
          
        
    }
    /**
	 * function isNational
	 * <pre>
	 * returns if is national
	 * </pre>
	 * @return [STRING]
	 */
    function isNational()
    {
        return $this->isNational;
    }
    /**
	 * function isRegional
	 * <pre>
	 * returns if is regional
	 * </pre>
	 * @return [STRING]
	 */
    function isRegional()
    {
        return $this->isRegional;
    }
    /**
	 * function iscD
	 * <pre>
	 * returns if is a CD
	 * </pre>
	 * @return [STRING]
	 */
    function isCD()
    {
        return $this->isCD;
    }
    /**
	 * function isStatsCoordinator
	 * <pre>
	 * returns if is stats coordinator
	 * </pre>
	 * @return [STRING]
	 */
    function isStatsCoordinator()
    {
        return $this->isStatsCoordinator;
    }
    /**
	 * function isAllStaff
	 * <pre>
	 * returns if is all staff
	 * </pre>
	 * @return [STRING]
	 */
    function isAllStaff()
    {
        return $this->isAllStaff;
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
        	
}

?>