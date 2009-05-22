<?php
/*!
 @class moduleLogin
 @discussion <pre>
 Written By	:	Johnny Hausman
 Date		:    18 Aug '04
 
 This is the Login Module class for the Login application.
 
 </pre>	
*/
class moduleLogin extends XMLObject_PageContent {
// 		
//
//	CONSTANTS:
        
    /*! const ELEMENT_CSS    NodeName for the XML CSS data. */
        const ELEMENT_CSS = 'style';
        
    /*! const MODE    The QueryString Mode parameter. */
        const MODE = "M";
        
    /*! const MODE_DISPLAY    Display the Login Form. */
        const MODE_DISPLAY = "D";
        
    /*! const MODE_SUBMIT    Process a Form Submit. */
        const MODE_SUBMIT = "S";
        
    /*! const MODE_FORM    Form Processing Mode. */
        const MODE_FORM = "F";
        
    /*! const MODE_LOGOUT  Logout of the website. */
        const MODE_LOGOUT = "Lo";
        
        
    /*! const CALLBACK   The field for the CallBack QS parameter. */
        const CALLBACK = "m_CB";
        
    /*! const FORM_USERID   The form item name for the UserID. */
        const FORM_USERID = "userid";
        
    /*! const FORM_PASSWORD   The form item name for the PassWord. */
        const FORM_PASSWORD = "password";
        

//
//	VARIABLES:

		
    /*! protected $mode   [STRING] The current Mode of this Module. */
		protected $mode;
		
    /*! protected $errorMessages    [STRING] The Error messages for this app. */
        protected $errorMessages;
        
    /*! protected $userID    [STRING] The submitted UserID for this login. */
        protected $userID;
        
    /*! protected $passWord    [STRING] The submitted PassWord for this login. */
        protected $passWord;
		
		
	
	

//
//	CLASS FUNCTIONS:
//

	
	//************************************************************************
	/*! 
	 @function loadData
	 
	 @abstract Provided function to allow object to load it's data.

	*/
	function loadData( ) 
	{

        //if the Callback Session field isn't set, then default it to NULL
        if (!isset( $_SESSION[ SESSION_ID_CALLBACK ] ) ) {
            $_SESSION[ SESSION_ID_CALLBACK ]='<null>';
        }
        
        // load the module's mode (DEFAULT = DISPLAY)
        $this->mode = $this->getQSValue( moduleLogin::MODE, moduleLogin::MODE_DISPLAY );
        
        $this->userID = $this->getQSValue( moduleLogin::FORM_USERID, "" );
        $this->passWord = $this->getQSValue( moduleLogin::FORM_PASSWORD, "" );
        
        switch( $this->mode ) {
        
            case moduleLogin::MODE_FORM:
                
                if ( $this->viewer->isAuthenticated() == false ) {
                
                    $this->mode = moduleLogin::MODE_DISPLAY;
                }
                break;
        
        }

	}
	
	
	
	//************************************************************************
	/*! 
	 * @function processData
	 * 
	 * @abstract Provided function to allow an object to process it's data.
	 *
	 */
	function processData( ) 
	{


        switch( $this->mode ) {
        
            case moduleLogin::MODE_SUBMIT:
           
                $this->viewer->assumeValidSession();
                if ( $this->viewer->validateLogin( $this->userID, $this->passWord) ) {

                    $this->processForms();
                    
                } else {
                
                    $this->errorMessages = 'Invalid UserID & Password.';			
                }
                break;
                
                
            case moduleLogin::MODE_FORM:
                
                if ( $this->viewer->isAuthenticated() == false ) {
                
                    $this->mode = moduleLogin::MODE_DISPLAY;
                }
                break;
                
            case moduleLogin::MODE_LOGOUT:
                
                $this->viewer->deleteSession();
                
                // now redirect the page BACK to the LOGIN page
                header( "Location:".Page::getLoginURL() );
                break;
        
        }

	}
	
	
	
	//************************************************************************
	/*! 
	 @function prepareDisplayData
	 
	 @abstract Provided function to allow an object to prepare it's data for diplaying (actually done int he Page Object).

	
	*/
	function prepareDisplayData( ) 
	{
        // set the page's Template to the Login Template
        $this->setPageTemplate( PAGE_TEMPLATE_LOGIN );
        
        // Compile Login Form Data as XML
        $formData = new XMLObject( 'PageContent' );
        $formData->addElement( 'formAction',  $this->getCallBack( moduleLogin::MODE_SUBMIT ) );
        $formData->addElement( 'pathToRoot', $this->moduleRootPath);
        $formData->addElement( 'errorMessage', $this->errorMessages);
        $formData->addElement( 'form_username', moduleLogin::FORM_USERID );
        $formData->addElement( 'form_password', moduleLogin::FORM_PASSWORD );
        $formData->addElement( 'username', $this->userID );
        $formData->addElement( 'password', $this->passWord );
        
        $xmlData = $formData->getXML();

        $template = new Template( $this->moduleRootPath.'templates/' );
        $template->setXML( 'pageContent', $xmlData);
		
		$content = $template->fetch( PAGE_LOGIN_TEMPLATE );

        // Finally store HTML content as this page's content Item
        $this->addElement(XMLObject_PageContent::NODE_CONTENT, $content );
	}
	
	
	
    //************************************************************************
	/**
	 * function getCallBack
	 * <pre>
	 * Builds the proper HREF link for a desired action.
	 * </pre>
	 *
	 * @param $mode [STRING] The Desired MODE of this Link.
	 * @return [STRING] The Link.
	 */
    function getCallBack($mode='') 
    {
        $returnValue = $this->baseCallBack;
        
        if ($mode != '') {
            $callBack = moduleLogin::MODE.'='.$mode;
        }
        
        if ( $callBack != '') {
            $returnValue .= '&'.$callBack;
        }
        
        return $returnValue;
    }
    
    
    
    //************************************************************************
	/**
	 * function processForms
	 * <pre>
	 * Checks to see if current Viewer has any due Site Forms.  If so, redirect
	 * page to that form.  Otherwise return to callBack page.
	 * </pre>
     *
	 * @return [Void] 
	 */
    function processForms() 
    {

//
// Left Off
//
// Implementing processForms.


//echo 'In processForms()<br>';
//exit;
        // if Viewer has forms due then
            // redirect page to current form due
            //   NOTE:  the value returned for this due form is the query string
            //          portion of the link. This gets added to $this->baseCallBack to make the actual link;
        // else
            // redirect page to callBack page.
            //  NOTE:  This is the whole link as stored by the page object.
            $returnURL = $_SESSION[ SESSION_ID_CALLBACK ];
                
            // clear out the Session ID Callback value
            $_SESSION[ SESSION_ID_CALLBACK ] = '';

            // if returnURL is an invalid entry 
            // invalid entry == (is null) OR (is empty) OR ( is NULL marker )
            if ((is_null($returnURL)) || ( $returnURL == '') || ($returnURL == '<null>')) {
                
                // set returnURL to the Default Page Module
                //  NOTE: current baseCallBack should be set to module LOGIN
                //          so here we just change the LOGIN module info to 
                //          the PAGE MODULE DEFAULT.
                $returnURL = str_replace( PAGE_MODULE_LOGIN, PAGE_MODULE_DEFAULT, $this->baseCallBack);

            }
            
            header( "Location:".$returnURL );
        // end if
    }
		

}

?>