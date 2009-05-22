<?php
/**
 * @package AIobjects
 */ 
/**
 * class PopUpManager
 * <pre> 
 * This object provides a site wide interface to managing popup boxes.
 * </pre>
 * @author Johnny Hausman
 * date: 07 Jan '05
 */
class  PopUpManager {

	//CONSTANTS:
	/** The name of the javascript file to use for creating a popup. This file
	 *  is intended to be included by the PageContent object's addScript() 
	 *  routine. 
	 */
    const SCRIPT_NAME = 'MM_openBrWindow.jsp';
    
    /** The name & path of the template file to use for displaying a popup. 
     *  This template is the outer most template used by the <code>Page</code>
     *  object. 
	 */
    const TEMPLATE_NAME = 'php5_sitePopUp.php';
    
    /** The name & path of the template file to use for closing a popup. */
    const TEMPLATE_CLOSE_NAME = 'php5_sitePopUpClose.php';
    
    /** The List of parameters for the popup window info */
    const PARAMETER_KEYS = 'toolbar,location,status,menubar,scrollbars,resizable,width,height';

	//VARIABLES:
	/** @var [STRING] html link of page to display in pop up window */
	protected $link;

	/** @var [STRING] Name to be displayed on the popup window */
	protected $windowName;
	
	/** @var [STRING] window parameters.  For Example: 'width=300,height=100' */
	protected $parameters;
	
	/** @var [STRING] javascript code to handle refreshing the calling page
	 *                when it is time to close the pop up.
     */
	protected $refreshUpdate;
	
	/** @var [ARRAY] array of parameter values */
	protected $parameterValues;
	
	/** @var [BOOL] indicated that parameter values have been set in the
	 *              parameterValues array.  These values will override any
	 *              previously passed in parameter values.
	 */
	protected $areParametersSet;

	//CLASS CONSTRUCTOR
	//************************************************************************
	/**
	 * function __construct
	 * <pre>
	 * [classConstructor Description]
	 * </pre>
	 * <pre><code>
	 * [Put PseudoCode Here]
	 * </code></pre>
	 * @param $link [STRING] the href link of the page to display 
	 * @param $name [STRING] the name of the window
	 * @param $params [STRING] a list of parameters to use for the window
	 * @return [void]
	 */
    function __construct($link='', $name='', $params='') 
    {
        // set initial values
        $this->link = $link;
        $this->windowName = $name;
        $this->parameters = $params;
        
        $this->refreshUpdate = '';
        
        // initialize the Parameter Values
        $this->areParametersSet = false;
        $keys = explode(',', PopUpManager::PARAMETER_KEYS);
        for ( $indx=0; $indx<count( $keys ); $indx++) {
            $this->parameterValues[$keys[$indx] ] = false;
        }
        
        // if params have been given
        if ( $params != '') {
        
            // get the label=value pairs
            $pairs = explode( ',', $params );
            
            // for each pair
            for( $pIndx=0; $pIndx<count($pairs); $pIndx++) {
            
                // take the current pair and split up into key=>value
                $parts = explode( '=', $pairs[ $pIndx ] );
                
                // if valid key 
                if (array_key_exists( $parts[0], $this->parameterValues)) {
                
                    // store key=>value into parameterValues
                    $this->parameterValues[ $parts[0] ] = $parts[1];
                    
                } // end if valid key
                
            } // next label=>value pair
            
        } // end if params are given
        
        
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
	 * function refreshCallingPage
	 * <pre>
	 * This routine sets the refresh code for the close PopUp template. If not
	 * called, then the calling Page will not be refreshed when the 
	 * <code>closePopUp()</code> routine is called.
	 * </pre>
	 * @param $hrefValue [STRING]  The url to use for the refresh. If not 
	 *        given, then the callingPage will be refreshed with current URL.
	 * @return [void]
	 */
    function refreshCallingPage( $hrefValue='window.opener.document.URL' ) 
    {
        $this->refreshUpdate = "window.opener.document.location.href = '".$hrefValue."';";
    }  // end refreshCallingPage()
    
    
    
    //************************************************************************
	/**
	 * function closePopUp
	 * <pre>
	 * This function generates the html needed to close the popup.  It 
	 * compiles the html, echo's it out to the browser and then immediately
	 * <code>exit</code>s program operation.
	 * </pre>
	 * @param $pathToRoot [STRING] path from current page to root directory
	 * @return [void]
	 */
    function closePopUp($pathToRoot) 
    {
        $template = new Template( $pathToRoot.SITE_PATH_TEMPLATES );
        
        // store the form action data
        $template->set( 'refreshCode', $this->refreshUpdate );
        
        echo $template->fetch( PopUpManager::TEMPLATE_CLOSE_NAME );
        
        exit;
        
    }  // end closePopUp()
    
    
    
    //************************************************************************
	/**
	 * function compileParameters
	 * <pre>
	 * takes any set values in the <code>parameterValues</code> array and
	 * creates the <code>parameter</code> string.
	 * </pre>
	 * @return [void]
	 */
    function compileParameters() 
    {
        $parameterString = '';
        
        // for each entry in the parameterValues array
        foreach( $this->parameterValues as $key=>$value) {
        
            // if the value is set (ie not FALSE)
            if ($value) {
            
                // add to parameterString
                if ($parameterString != '') {
                    $parameterString .= ',';
                }
                $parameterString .= $key.'='.$value;
            
            }
        }
        
        // now stor in this object's parameters member
        $this->parameters = $parameterString;
        
    }  // end compileParameters()
    
    
    
    //************************************************************************
	/**
	 * function getLink
	 * <pre>
	 * Returns the link for this popup command. It will be properly formatted
	 * for the javascript file that will process the command.
	 * NOTE: your page controller app also needs to include the proper 
	 * javascript file.
	 * </pre>
	 * @return [STRING]
	 */
    function getLink() 
    {
        
        if( $this->areParametersSet ) {
            $this->compileParameters();
            $this->areParametersSet = false;
        }
        
        $returnLink = "MM_openBrWindow('".$this->link."','" . 
                      $this->windowName."','".$this->parameters."')";
                      
        return $returnLink;
    }  // end getLink()
    
    
    
    //************************************************************************
	/**
	 * function getScriptName
	 * <pre>
	 * Returns the name of the javascript file to use for creating the popup.
	 * </pre>
	 * @return [STRING]
	 */
    function getScriptName() 
    {
        return PopUpManager::SCRIPT_NAME;
    }  // end getScriptName()
    
    
    
    //************************************************************************
	/**
	 * function getScriptPath
	 * <pre>
	 * Returns the path to the javascript file to use for creating the popup.
	 * </pre>
	 * @return [STRING]
	 */
    function getScriptPath() 
    {
        return SITE_PATH_SCRIPTS;
    }  // end getScriptPath()
    
    
    
    //************************************************************************
	/**
	 * function getTemplateName
	 * <pre>
	 * Returns the name of the template file to use for displaying the popup.
	 * </pre>
	 * @return [STRING]
	 */
    function getTemplateName() 
    {
        return SITE_PATH_TEMPLATES.PopUpManager::TEMPLATE_NAME;
    }  // end getTemplateName()
    
    
    
    //************************************************************************
	/**
	 * function setLocation
	 * <pre>
	 * Updates the <code>link</code> information.
	 * </pre>
	 * @param $link [STRING] New link info
	 * @return [void]
	 */
    function setLocation($link) 
    {
        $this->link = $link;
    }  // end setLocation()
    
    
    
    //************************************************************************
	/**
	 * function setHeight
	 * <pre>
	 * Updates the pop up window's height value.
	 * </pre>
	 * @param $height [STRING] the new height value
	 * @return [void]
	 */
    function setHeight( $height ) 
    {
        $this->parameterValues ['height'] = $height;
        $this->areParametersSet = true;
    }  // end setHeight()
    
    
    
    //************************************************************************
	/**
	 * function setWidth
	 * <pre>
	 * Updates the pop up window's width value.
	 * </pre>
	 * @param $width [STRING] the new width value
	 * @return [void]
	 */
    function setWidth( $width ) 
    {
        $this->parameterValues ['width'] = $width;
        $this->areParametersSet = true;
    }  // end setWidth()
    
    
    
    //************************************************************************
	/**
	 * function showToolbar
	 * <pre>
	 * Updates the pop up to display the tool bar.
	 * </pre>
	 * @return [void]
	 */
    function showToolbar() 
    {
        $this->parameterValues ['toolbar'] = 'yes';
        $this->areParametersSet = true;
    }  // end showToolbar()
	
}

?>