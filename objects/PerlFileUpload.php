<?php
/**
 * @package AIObjects
 */ 
/**
 * class PerlFileUpload
 * <pre> 
 * This class manages files uploaded by our Perl based File Upload scripts. In
 * order to show a progress bar during an upload, we have to let the perl script
 * handle the upload, then it turns the data over to our PHP script to process.
 * 
 * The files will be stored in the /tmp directory, and the file/form data will 
 * be passed in a special file.
 * </pre>
 * @author Johnny Hausman
 */
class  PerlFileUpload {

	//CONSTANTS:
	/** The Install Location for the perl Upload script */
    const DEF_LOCATION_UPLOAD = 'cgi-bin/tool_perlUpload.cgi';
    
    /** The Install Location for the perl Upload header script */
    const DEF_LOCATION_UPLOADHEADER = 'cgi-bin/tool_perlUploadHeader.cgi';
    
    /** The Install Location for the perl ProgressBar script */
    const DEF_LOCATION_PROGRESSBAR = 'cgi-bin/tool_perlProgressBar.cgi';
    
    /** The Install Location for the perl upload Javascript file */
    const DEF_LOCATION_JAVASCRIPT = 'Data/scripts/JScript/perlUpload.jsp';
    
    /** The Location for placing temporary files */
    const DEF_LOCATION_TEMPDIR = '/tmp/www/';
    
    /** The maximum size of files (in bytes) to be uploaded */
    const DEF_LIMIT_UPLOADSIZE = '51200000';
    
    /** The QueryString parameter for the sid */
    const DEF_QSPARAM_SID = 'sid';
    
    /** The QueryString parameter for the php_uploader */
    const DEF_QSPARAM_UPLOADER = 'php_uploader';
	
	/** The index Key for the Original Name of the file(s) */
    const KEY_NAME = 'name';
    
    /** The index Key for the current (temporary) name of the file(s) */
    const KEY_TEMPNAME = 'tmp_name';

	//VARIABLES:
	/** @var [ARRAY] The uploaded file information */
	protected $fileList;

	/** @var [STRING] Querystring of Form Field Data */
	protected $formData;
	
	/** @var [INTEGER] Number of files uploaded */
	protected $numberFilesUploaded;
	
	/** @var [STRING] a unique id for the file upload object */
	protected $sid;
	

	//CLASS CONSTRUCTOR
	//************************************************************************
	/**
	 * function __construct
	 * <pre>
	 * loads the file info
	 * </pre>
	 * @param $sid [STRING] The unique ID of the file descriptor
	 * @return [void]
	 */
    function __construct( $sid='' ) 
    {
    
        if ($sid != '') {

            $this->sid = $sid;
            
            // Get the uploaded form data from the _qstring file
            $fileName = PerlFileUpload::DEF_LOCATION_TEMPDIR;
            $fileName .= $sid.'_qstring';
            $this->formData = join("",file($fileName));
            unlink($fileName);
    
            // convert data into variables so we can get the file info.
            parse_str( $this->formData );
            
            // The Perl file upload script will store the uploaded file info in
            // an array named $file.  We set this to our member variable.
            if (isset($file) ) {
            
                $this->fileList = $file;
                $this->numberFilesUploaded = count( $this->fileList[ PerlFileUpload::KEY_NAME] );
                
            } else {
            
                $this->fileList = array();
                $this->numberFilesUploaded = 0;
            }        
            
            
        } else {
        
            // being called in a situation where we are generating the form
            $this->sid =  md5(uniqid(rand()));
            
            // now verify that the temp directory exists ... if not create it
            if( !file_exists( PerlFileUpload::DEF_LOCATION_TEMPDIR ) ) { 
                if( !mkdir( PerlFileUpload::DEF_LOCATION_TEMPDIR ) ) {
                    
                    echo 'PerlFileUpload::__construct -> ['.PerlFileUpload::DEF_LOCATION_TEMPDIR.'] didn\'t exist & I couldn\'t create it.<br>';
                    exit;
                }
            }
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
	 * function getFormData
	 * <pre>
	 * Returns the form data as a query string.
	 * </pre>
	 * @return [STRING]
	 */
    function getFormData() 
    {
        return $this->formData;
        
    }  // end getFormData()
    
    
    
    //************************************************************************
	/**
	 * function getNumberOfFiles
	 * <pre>
	 * Returns the # of files uploaded.
	 * </pre>
	 * @return [INTEGER]
	 */
    function getNumberOfFiles() 
    {
        return $this->numberFilesUploaded;
        
    }  // end getNumberOfFiles()
    
    
    //************************************************************************
	/**
	 * function setFirstFile
	 * <pre>
	 * Point to the first file uploaded.
	 * </pre>
	 * @return [void]
	 */
    function setFirstFile() 
    {
        $this->currentFile = -1;
    }  // end setFirstFile()
    
    
    
    //************************************************************************
	/**
	 * function getFile
	 * <pre>
	 * Return the current file as a FileObject.
	 * </pre>
	 * @return [OBJECT] if file exists, FALSE otherwise.
	 */
    function getFile() 
    {
        $returnValue = false;
        
        // if another file is available then
        if ( $this->currentFile < ($this->numberFilesUploaded - 1) ) {
        
            // Get file.
            $this->currentFile ++;
            
            $returnValue = new FileObject( $this->fileList[ PerLFileUpload::KEY_TEMPNAME ][$this->currentFile] );
            
            
        }
        
        return $returnValue;
                
    }  // end setFirstFile()
    
    
    
    //************************************************************************
	/**
	 * function getCurrentFileOriginalName
	 * <pre>
	 * Return the current file as a FileObject.
	 * </pre>
	 * @return [OBJECT] if file exists, FALSE otherwise.
	 */
    function getCurrentFileOriginalName() 
    {
        $returnValue = '';
        
        // if another file is available then
        if ( $this->currentFile != -1 ) {
            
            $returnValue = $this->fileList[ PerlFileUpload::KEY_NAME ][$this->currentFile];
        }
        
        return $returnValue;
                
    }  // end getCurrentFileOriginalName()
    
    
    
    //************************************************************************
	/**
	 * function getCallBackString
	 * <pre>
	 * Generates a callback string that will use the Perl tools to upload and
	 * pass back control to your page.  Send it the form action you would 
	 * use normally. This routine will return a modified version that includes
	 * the necessary parameters used by the perl tools.
	 * </pre>
	 * @param $callBack [STRING] The callback string for your form.
	 * @return [STRING]
	 */
    function getCallBackString($callBack) 
    {
        // create unique session id ($sid) for this new form.
        $this->sid =  md5(uniqid(rand()));
        
        $parts = explode( '?', $callBack);
        
        // For Live Site
        $pathToScript = Page::findPathExtension( PerlFileUpload::DEF_LOCATION_UPLOAD ) . PerlFileUpload::DEF_LOCATION_UPLOAD;
        
        // For Local testing
//        $pathToScript = 'http://localhost/' . PerlFileUpload::DEF_LOCATION_UPLOAD;
        
        $returnValue = $pathToScript . '?' . $parts[1] . '&';
        $returnValue .= PerlFileUpload::DEF_QSPARAM_SID.'='.$this->sid.'&';
        $returnValue .= PerlFileUpload::DEF_QSPARAM_UPLOADER.'='.$parts[0];
        
        return $returnValue;
        
    }  // end getCallBackString()
    
    
    
    //************************************************************************
	/**
	 * function getSessionID
	 * <pre>
	 * Returns the current Session ID
	 * </pre>
	 * @return [STRING]
	 */
    function getSessionID() 
    {
        return $this->sid;
        
    }  // end getSessionID()
    
    
    
    //************************************************************************
	/**
	 * function getScriptName
	 * <pre>
	 * Returns the name of the JavaScript file to include in your page.
	 * NOTE: this function can be called statically. 
	 * eg.. $scriptName = PerlFileUpload::getScriptName()
	 * </pre>
	 * @return [STRING]
	 */
    function getScriptName() 
    {   
        $pathParts = pathinfo( PerlFileUpload::DEF_LOCATION_JAVASCRIPT ); 
        return $pathParts['basename'];
        
    }  // end getSessionID()
	
}

?>