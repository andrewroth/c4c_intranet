<?php
/**
 * @package cim_home
 */ 
/**
 * class CommonDisplay
 * <pre> 
 * This object manages the generic page display routines for this module.  
 * The html output of the other pageDisplay objects will be sent to this
 * object for formatting in a common layout.
 * </pre>
 * @author CIM Team
 * Date:   06 Apr 2006
 */
class  CommonDisplay {

	//CONSTANTS:
	/** The XML root node name for this object */
    const MULTILINGUAL_PAGE_KEY = 'CommonDisplay';

	//VARIABLES:
	
	/** @var [STRING] The path to this module's root directory */
	protected $pathModuleRoot;
	
	/** @var [STRING] The path to the site's root directory */
	protected $pathToRoot;
	
	/** @var [OBJECT] the template object */
	protected $template;
	
	/** @var [OBJECT] the labels object */
	protected $labels;


	//CLASS CONSTRUCTOR
	//************************************************************************
	/**
	 * function __construct
	 * <pre>
	 * Initialize the PageDisplay Object.
	 * </pre>
	 * @param $modulePath [STRING] The path from the root directory to this 
	 * module's root directory.
	 * @param $rootPath [STRING] The path to the root directory 
	 * @return [void]
	 */
    function __construct( $modulePath, $rootPath, $viewer ) 
    {
        
        $this->pathModuleRoot = $modulePath;
        $this->pathToRoot = $rootPath;
        
        
        $languageID = $viewer->getLanguageID();
        $seriesKey = modulecim_home::MULTILINGUAL_SERIES_KEY;
        $pageKey = CommonDisplay::MULTILINGUAL_PAGE_KEY;
        $this->labels = new MultilingualManager( $languageID, $seriesKey, $pageKey );
                        
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
    }	
    
    
    
    //************************************************************************
	/**
	 * function getHTML
	 * <pre>
	 * This method returns the HTML data generated by this object.
	 * </pre>
	 * @param $pageContentHTML [STRING] the html generated by the pageDisplay
	 * object.
	 * @return [STRING] HTML Display data.
	 */
    function getHTML( $pageContentHTML ) 
    {
        // Create a new Template Object
        $this->template = new Template( $this->pathModuleRoot.'templates/' );
        
        // store the page labels
        $this->template->setXML( 'pageLabels', $this->labels->getLabelXML() );
        
        // store the pageDisplay object's html 
        $this->template->set( 'pageContent', $pageContentHTML);
        
        // store the path to root.  Useful for accessing site images and
        // resources.
		$this->template->set( 'pathToRoot',$this->pathModuleRoot );
		
		// return the html from the commong display template
		return $this->template->fetch( 'obj_CommonDisplay.php' );
        
    }
	
}

?>