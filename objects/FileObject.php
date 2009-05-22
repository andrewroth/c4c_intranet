<?php
/**
 * @package AIObjects
 */ 
/**
 * class FileObject
 * <pre> 
 * This object manages an individual file.
 * </pre>
 * @author Johnny Hausman
 */
class  FileObject {

	//CONSTANTS:
	/** [CLASS_CONSTANT description] */
    const CLASS_CONSTANT = '5566';

	//VARIABLES:
	/** @var [STRING] path to the file */
	protected $path;

	/** @var [STRING] Name of file */
	protected $fileName;
	
	/** @var [STRING] Size of file */
	protected $fileSize;
	
	/** @var [BOOL] flag if File Exists */
	protected $doesFileExist;

	//CLASS CONSTRUCTOR
	//************************************************************************
	/**
	 * function __construct
	 * <pre>
	 * Initialize the File object.
	 * </pre>
	 * @param $pathToFile [STRING] A path to the file this object is to manage.
	 * @return [void]
	 */
    function __construct($pathToFile) 
    {
        // CODE
        $pathParts = pathinfo( $pathToFile );
        
        $this->path = $pathParts[ 'dirname' ] . '/';
        $this->fileName = $pathParts[ 'basename' ];
        
        
        $this->doesFileExist = ((file_exists($pathToFile)) && (!is_dir($pathToFile)));
        
        if ( $this->doesFileExist ) {
            $this->fileSize = filesize( $pathToFile );
        } else {
            $this->fileSize = -1;
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
    }  // end classMethod()
    
    
    
    //************************************************************************
	/**
	 * function delete
	 * <pre>
	 * Remove this file.
	 * </pre>
	 * @return [void]
	 */
    function delete() 
    {
        return unlink( $this->path.$this->fileName );
        
    }  // end delete()
    
    
    
    //************************************************************************
	/**
	 * function doesFileExist
	 * <pre>
	 * Returns file's existance.
	 * </pre>
	 * @return [BOOL]
	 */
    function doesFileExist() 
    {
        return $this->doesFileExist;
        
    }  // end doesFileExist()
    
    
    
    //************************************************************************
	/**
	 * function getName
	 * <pre>
	 * Returns the Current Name of the File.
	 * </pre>
	 * @return [STRING]
	 */
    function getName() 
    {
        return $this->fileName;
        
    }  // end getName()
    
    
    
    //************************************************************************
	/**
	 * function getSize
	 * <pre>
	 * Returns the Current Size of the File.
	 * </pre>
	 * @return [INTEGER]
	 */
    function getSize() 
    {
        return $this->fileSize;
        
    }  // end getSize()
    
    
    
    //************************************************************************
	/**
	 * function getFormattedSize
	 * <pre>
	 * Returns the Current Size of the File.
	 * </pre>
	 * @return [INTEGER]
	 */
    function getFormattedSize() 
    {
        return $this->size_readable( $this->fileSize );
        
    }  // end getSize()
    
    
    
    
    //************************************************************************
    /**
     * Return human readable sizes
     *
     * @param       int    $size        Size
     * @param       int    $unit        The maximum unit
     * @param       int    $retstring   The return string format
     * @author      Aidan Lister <aidan@php.net>
     * @version     1.1.0
     */
    function size_readable($size, $unit = null, $retstring = null)
    {
        // Units
        $sizes = array('B', 'KB', 'MB', 'GB', 'TB');
        $ii = count($sizes) - 1;
    
        // Max unit
        $unit = array_search((string) $unit, $sizes);
        if ($unit === null || $unit === false) {
            $unit = $ii;
        }
    
        // Return string
        if ($retstring === null) {
            $retstring = '%01.2f %s';
        }
    
        // Loop
        $i = 0;
        while ($unit != $i && $size >= 1024 && $i < $ii) {
            $size /= 1024;
            $i++;
        }
    
        return sprintf($retstring, $size, $sizes[$i]);
    }
    
    
    
    //************************************************************************
	/**
	 * function setName
	 * <pre>
	 * Changes the name of the file.
	 * </pre>
	 * @param $fileName [STRING] New file name for this file.
	 * @return [BOOL]
	 */
    function setName( $fileName ) 
    {
        $returnValue = false;
        
        // if file exists
        if ($this->doesFileExist == true ) {
        
            // if new file name does not already exist then
            if (!file_exists( $this->path.$fileName) ) {
            
                // attempt to change the name
                // if successful then
                if ( rename( $this->path.$this->fileName, $this->path.$fileName )) {
                
                    // update internal marker
                    $this->fileName = $fileName;
                    
                    // return true
                    $returnValue = true;
                    
                } // end if
                
            } // end if
            
        } // end if
        
        return $returnValue;
        
    }  // end setName()
    
    
    
    //************************************************************************
	/**
	 * function setPath
	 * <pre>
	 * Changes the path/location of the file.
	 * </pre>
	 * @param $filePath [STRING] New file path (location) for this file.
	 * @param $mode [INTEGER]   octal number representing the file permissions.
	 * @param $doCreatePath [BOOL] Create the path if it doesn't exist?
	 * @return [BOOL]
	 */
    function setPath( $filePath, $mode=0700, $doCreatePath=true ) 
    {
        $returnValue = false;
        
        // if file exists
        if ( $this->doesFileExist ) {
        
            $isGoodPath = false;
            
            //Êif Path directory doesn't exist then
            if (!( is_dir($filePath) || empty($filePath)) ) {

                // if we are to create the path then
                if ( $doCreatePath ) {
                
                    // create the path
                    // if path successfully made then
                    if ( mkdir( $filePath, $mode, true) ) {
                    
                        // mark as good path
                        $isGoodPath = true;
                        
                    } // end if 
                    
                } // end if
                
            } else {
            // else
            
                // mark it as a Good Path
                $isGoodPath = true;
        
            }

            
            // if the path is good then
            if ( $isGoodPath ) {
            
                // attempt to change the path
                // if successful then
                if ( rename( $this->path.$this->fileName, $filePath.$this->fileName )) {
                
                    // update internal marker
                    $this->path = $filePath;
                    
                    // return true
                    $returnValue = true;
                    
                } // end if successful
            
            } // end if good path
            
        } // end if file exists
        
        return $returnValue;
        
    }  // end setPath()
	
}

?>