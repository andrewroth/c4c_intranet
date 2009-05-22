<?php
/**
 * @package AIobjects
 */ 
/**
 * class RowManager_siteModuleManager
 * <pre> 
 * This class manages the Site Modules table.
 * </pre>
 * @author Johnny Hausman
 */
class  RowManager_siteModuleManager extends RowManager {

	//CONSTANTS:
	/** The name of the DB Table this class manages. */
    const DB_TABLE = 'site_page_modules';
    
    /** The SQL description of the DB Table this class manages. */
    /*
     * module_id [INTEGER]  Primary Key for this table.
     * module_key [STRING]  The lookup key for this table 
     * module_path [STRING] The path to the module directory (from site root)
     * module_app [STRING] The name of the module controller file name
     * module_include [STRING] The name of the module's include file
     * module_name [STRING] The module Class Name
     * module_parameters [STRING] A list of optional parameters to call 
     *                   this module with
     */
    const DB_TABLE_DESCRIPTION = " (
  module_id int(11) NOT NULL auto_increment,
  module_key varchar(50) NOT NULL default '',
  module_path text NOT NULL,
  module_app varchar(50) NOT NULL default '',
  module_include varchar(50) NOT NULL default '',
  module_name varchar(50) NOT NULL default '',
  module_systemAccessFile varchar(50) NOT NULL default '',
  module_systemAccessObj varchar(50) NOT NULL default '',
  module_parameters text NOT NULL,
  PRIMARY KEY  (module_id)
) TYPE=MyISAM";
    
    /** The fields in the DB Table this class manages. */
    const FIELD_LIST = 'module_id,module_key,module_path,module_app,module_include,module_name,module_parameters,module_systemAccessFile,module_systemAccessObj';
    
    /** The XML node name for this entry. */
    const XML_NODE_NAME = 'module';
    

	//VARIABLES:


	//CLASS CONSTRUCTOR
	//************************************************************************
	/**
	 * function __construct
	 * <pre>
	 * Initialize this object.
	 * </pre>
	 * @param $moduleID [INTEGER] The unique id of the module we are managing.
	 * @return [void]
	 */
    function __construct( $moduleID=-1 ) 
    {
    
        $dbTableName = RowManager_siteModuleManager::DB_TABLE;
        $fieldList = RowManager_siteModuleManager::FIELD_LIST;
        $primaryKeyField = 'module_id';
        $primaryKeyValue = $moduleID;
        
        if (( $moduleID != -1 ) && ( $moduleID != '' )) {
        
            $condition = $primaryKeyField . '=' . $primaryKeyValue;
            
        } else {
            $condition = '';
        }
        $xmlNodeName = RowManager_siteModuleManager::XML_NODE_NAME;
        parent::__construct( $dbTableName, $fieldList, $primaryKeyField, $primaryKeyValue, $condition, $xmlNodeName);
        
        $this->dbDescription = RowManager_siteModuleManager::DB_TABLE_DESCRIPTION;
        
        if ($this->isLoaded() == false) {
        
            // uncomment this line if you want the Manager to automatically 
            // create a new entry if the given info doesn't exist.
            // $this->createNewEntry();
        }
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
    
    
    
    //************************************************************************
	/**
	 * function getApplicationFile
	 * <pre>
	 * Returns the module's application file name .
	 * </pre>
	 * @return [STRING]
	 */
    function getApplicationFile() 
    {
        return $this->getValueByFieldName( 'module_app' );
    }
    
    
    
    //************************************************************************
	/**
	 * function getIncludeFile
	 * <pre>
	 * Returns the module's include File .
	 * </pre>
	 * @return [STRING]
	 */
    function getIncludeFile() 
    {
        return $this->getValueByFieldName( 'module_include' );
    }
    
    
    
    //************************************************************************
	/**
	 * function getKey
	 * <pre>
	 * Returns the module's Key .
	 * </pre>
	 * @return [STRING]
	 */
    function getKey() 
    {
        return $this->getValueByFieldName( 'module_key' );
    }
    
    
    
    //************************************************************************
	/**
	 * function getLabelField
	 * <pre>
	 * Returns the field to use in the label routines.
	 * </pre>
	 * @return [STRING]
	 */
    function getLabelField() 
    {
        return 'module_key';
    }
    
    
    
    //************************************************************************
	/**
	 * function getListSystemAccessObjects
	 * <pre>
	 * Returns a list iterator of all the modules that have provided system 
	 * access object information.
	 * </pre>
	 * @return [ ListIterator ]
	 */
    function getListSystemAccessObjects() 
    {
        $this->constructSearchCondition( 'module_systemAccessFile', OP_NOT_EQUAL, '', true );
        return $this->getListIterator();
    }
    
    
    
    //************************************************************************
	/**
	 * function getName
	 * <pre>
	 * Returns the module's class name .
	 * </pre>
	 * @return [STRING]
	 */
    function getName() 
    {
        return $this->getValueByFieldName( 'module_name' );
    }
    
    
    
    //************************************************************************
	/**
	 * function getParameters
	 * <pre>
	 * Returns the module's setup parameter(s) .
	 * </pre>
	 * @return [STRING]
	 */
    function getParameters() 
    {
        return $this->getValueByFieldName( 'module_parameters' );
    }
    
    
    
    //************************************************************************
	/**
	 * function getPath
	 * <pre>
	 * Returns the module path.
	 * </pre>
	 * @return [STRING]
	 */
    function getPath() 
    {
        return $this->getValueByFieldName( 'module_path' );
    }
    
    
    
    //************************************************************************
	/**
	 * function getSystemAccessFileName
	 * <pre>
	 * Returns the module's system access object's filename.
	 * </pre>
	 * @return [STRING]
	 */
    function getSystemAccessFileName() 
    {
        return $this->getValueByFieldName( 'module_systemAccessFile' );
    }
    
    
    
    //************************************************************************
	/**
	 * function getSystemAccessObj
	 * <pre>
	 * Returns the module's system access object's name.
	 * </pre>
	 * @return [STRING]
	 */
    function getSystemAccessObj() 
    {
        return $this->getValueByFieldName( 'module_systemAccessObj' );
    }
    
    
    
    //************************************************************************
	/**
	 * function loadByKey
	 * <pre>
	 * Attempts to load this module by a given Key
	 * </pre>
	 * @param $key [STRING] the new module_key to look for
	 * @return [BOOL]
	 */
    function loadByKey( $key ) 
    {
        $condition = 'module_key="'.$key.'"';
        return $this->loadByCondition( $condition );
    }
    
    
    
    //************************************************************************
	/**
	 * function processSystemAccessNewAdmin
	 * <pre>
	 * Parses each module entry, and runs any associated system Access 
	 * object's newAdmin() routine.
	 * </pre>
	 * @param $viewerID [INTEGER] the new viewer_id add
	 * @return [void]
	 */
    function processSystemAccessNewAdmin( $viewerID ) 
    {

        // get list of all modules that have a SystemAccess Obj
        $objectList = $this->getListSystemAccessObjects();
        
        // for each one
        $objectList->setFirst();
        while( $module = $objectList->getNext() ) {
            
            // if system Access file exists 
            $path = $module->getPath();
            $fileName = $module->getSystemAccessFileName();
            if (file_exists( $path.$fileName ) ) {
            
                // include that object
                require_once( $path.$fileName );
                
                // create that new SystemAccess Object
                $objName = $module->getSystemAccessObj();
                $accessObj = new $objName();
                
                // run it's newViewer() routine
                $accessObj->newAdmin( $viewerID );
            } // end if
        } // next module
        
    }
    
    
    
    //************************************************************************
	/**
	 * function processSystemAccessNewViewer
	 * <pre>
	 * Parses each module entry, and runs any associated system Access 
	 * object's newViewer() routine.
	 * </pre>
	 * @param $viewerID [INTEGER] the new viewer_id add
	 * @return [void]
	 */
    function processSystemAccessNewViewer( $viewerID ) 
    {
        // get list of all modules that have a SystemAccess Obj
        $objectList = $this->getListSystemAccessObjects();
        
        // for each one
        $objectList->setFirst();
        while( $module = $objectList->getNext() ) {
            
            // if system Access file exists 
            $path = $module->getPath();
            $fileName = $module->getSystemAccessFileName();
            if (file_exists( $path.$fileName ) ) {
            
                // include that object
                require_once( $path.$fileName );
                
                // create that new SystemAccess Object
                $objName = $module->getSystemAccessObj();
                if ( class_exists( $objName ) ) {
                    
                    $accessObj = new $objName();
                    
                    // run it's newViewer() routine
                    $accessObj->newViewer( $viewerID );
                }
            } // end if
        } // next module
        
    }
        
    
    
    //************************************************************************
	/**
	 * function processSystemAccessRemoveAdmin
	 * <pre>
	 * Parses each module entry, and runs any associated system Access 
	 * object's removeAdmin() routine.
	 * </pre>
	 * @param $viewerID [INTEGER] the new viewer_id remove
	 * @return [void]
	 */
    function processSystemAccessRemoveAdmin( $viewerID ) 
    {
        // get list of all modules that have a SystemAccess Obj
        $objectList = $this->getListSystemAccessObjects();
        
        // for each one
        $objectList->setFirst();
        while( $module = $objectList->getNext() ) {
            
            // if system Access file exists 
            $path = $module->getPath();
            $fileName = $module->getSystemAccessFileName();
            if (file_exists( $path.$fileName ) ) {
            
                // include that object
                require_once( $path.$fileName );
                
                // create that new SystemAccess Object
                $objName = $module->getSystemAccessObj();
                $accessObj = new $objName();
                
                // run it's newViewer() routine
                $accessObj->removeAdmin( $viewerID );
            } // end if
        } // next module
        
    }
    
    
    
    //************************************************************************
	/**
	 * function processSystemAccessRemoveViewer
	 * <pre>
	 * Parses each module entry, and runs any associated system Access 
	 * object's removeViewer() routine.
	 * </pre>
	 * @param $viewerID [INTEGER] the new viewer_id remove
	 * @return [void]
	 */
    function processSystemAccessRemoveViewer( $viewerID ) 
    {
        // get list of all modules that have a SystemAccess Obj
        $objectList = $this->getListSystemAccessObjects();
        
        // for each one
        $objectList->setFirst();
        while( $module = $objectList->getNext() ) {
            
            // if system Access file exists 
            $path = $module->getPath();
            $fileName = $module->getSystemAccessFileName();
            if (file_exists( $path.$fileName ) ) {
            
                // include that object
                require_once( $path.$fileName );
                
                // create that new SystemAccess Object
                $objName = $module->getSystemAccessObj();
                if ( class_exists( $objName ) ) {
                
                    $accessObj = new $objName();
                    
                    // run it's newViewer() routine
                    $accessObj->removeViewer( $viewerID );
                }
            } // end if
        } // next module
        
    }
    
    
    
    //************************************************************************
	/**
	 * function setApplicationFile
	 * <pre>
	 * Sets the module's application file name .
	 * </pre>
     * @param $name [STRING] application file name
	 * @return [void]
	 */
    function setApplicationFile( $name ) 
    {
        $this->setValueByFieldName( 'module_app', $name );
    }
    
    
    
    //************************************************************************
	/**
	 * function setIncludeFile
	 * <pre>
	 * Sets the module's include file name .
	 * </pre>
     * @param $name [STRING] include file name
	 * @return [void]
	 */
    function setIncludeFile( $name ) 
    {
        $this->setValueByFieldName( 'module_include', $name );
    }
    
    
    
    //************************************************************************
	/**
	 * function setKey
	 * <pre>
	 * Sets the module's lookup key .
	 * </pre>
     * @param $key [STRING] the lookup key
	 * @return [void]
	 */
    function setKey( $key ) 
    {
        $this->setValueByFieldName( 'module_key', $key );
    }
    
    
    
    //************************************************************************
	/**
	 * function setName
	 * <pre>
	 * Sets the module's class name .
	 * </pre>
     * @param $className [STRING] module class name
	 * @return [void]
	 */
    function setName( $className ) 
    {
        $this->setValueByFieldName( 'module_name', $className );
    }
    
    
    
    //************************************************************************
	/**
	 * function setParameters
	 * <pre>
	 * Sets the module's parameter(s) .
	 * </pre>
     * @param $param [STRING] module parameters
	 * @return [void]
	 */
    function setParameters( $param ) 
    {
        $this->setValueByFieldName( 'module_parameters', $param );
    }
    
    
    
    //************************************************************************
	/**
	 * function setPath
	 * <pre>
	 * Sets the module's path.
	 * </pre>
     * @param $path [STRING] module parameters
	 * @return [void]
	 */
    function setPath( $path ) 
    {
        $this->setValueByFieldName( 'module_path', $path );
    }
    
    
    
    //************************************************************************
	/**
	 * function setSystemAccessFile
	 * <pre>
	 * Sets the module's system access object's filename.
	 * </pre>
     * @param $path [STRING] filename of system access object.
	 * @return [void]
	 */
    function setSystemAccessFile( $systemAccessObjFileName ) 
    {
        $this->setValueByFieldName( 'module_systemAccessFile', $systemAccessObjFileName );
    }
    
    
    
    //************************************************************************
	/**
	 * function setSystemAccessObj
	 * <pre>
	 * Sets the module's system access object's name.
	 * </pre>
     * @param $systemAccessObj [STRING] name of system access object.
	 * @return [void]
	 */
    function setSystemAccessObj( $systemAccessObj ) 
    {
        $this->setValueByFieldName( 'module_systemAccessObj', $systemAccessObj );
    }
    

    
    	
}

?>