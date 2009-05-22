<?php
/**
 * @package apiTutorial
 */
/*!
 @class moduleExample
 @discussion <pre>
 Written By	:	Johnny Hausman
 Date		:   6 Sept 2005
 
 This is an example of a PageContent application controller.
 
 </pre>	
*/
class moduleExample extends XMLObject_PageContent {
// 		
//
//	CONSTANTS:
        
    /*! const PAGE    The QueryString Page parameter. */
        const PAGE = "modPage";
        
    /*! const PAGE_GROUPLIST   Display the GroupList Page. */
        const PAGE_GROUPLIST = "P9";

    /*! const PAGE_LINKLIST   Display the LinkList Page. */
        const PAGE_LINKLIST = "P10";
        
//
//	VARIABLES:
        
    /*! protected $page   [STRING] The current Page of this Module. */
		protected $page;


/*[RAD_PAGE_STATEVAR_VAR]*/
		
   
    /*! protected $pageDisplay [OBJECT] The display object for the page. */
        protected $pageDisplay;
        
/*[RAD_PAGE_OBJECT_VAR]*/ 		


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
         
        // load the module's page (DEFAULT = WELCOME)
        if (isset( $_REQUEST[ moduleExample::PAGE ] ) ) {
            $this->page = $_REQUEST[ moduleExample::PAGE ];
        } else {
            $this->page = moduleExample::PAGE_GROUPLIST;
        }
        
        switch( $this->page ) {
                
            /*
             *  GroupList
             */
            case moduleExample::PAGE_GROUPLIST:
                $this->loadGroupList();
                break;

            /*
             *  LinkList
             */
            case moduleExample::PAGE_LINKLIST:
                $this->loadLinkList();
                break;

        
        }
        
        
        /*
         * Load Form Values if a ProcessData field exists
         */
        if (isset( $_REQUEST[ 'Process' ] ) ) {
        
            $this->pageDisplay->loadFromForm();
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

        // if this was a form submit ... 
        // NOTE: our forms should have a hidden variable named Process on them.
        if (isset( $_REQUEST[ 'Process' ] ) ) {
        
            // if form data is valid ...
            if ( $this->pageDisplay->isDataValid() ) {
            
                // process the data
                $this->pageDisplay->processData();
                           
            } // end if data valid
        
        }  // end if Process

	}
	
	
	
	//************************************************************************
	/*! 
	 * @function prepareDisplayData
	 *
	 * @abstract Provided function to allow an object to prepare it's data 
	 * for displaying (actually done in the <code>Page</code> Object).
     *
	 */
	function prepareDisplayData( ) 
	{
        $content = $this->pageDisplay->getHTML();

        // store HTML content as this page's content Item
        $this->addContent( $content );
        
	}

    
    
    //************************************************************************
	/**
	 * function loadGroupList
	 * <pre>
	 * Initializes the GroupList Page.
	 * </pre>
	 * @param $isCreated [BOOL] "Is THIS pageDisplay object already created?"
	 * @return [void]
	 */
    // RAD Tools: AdminBox Style
    function loadGroupList( $isCreated=false ) 
    {
        
            // create a new pageDisplay object
        $this->pageDisplay = new FormProcessor_GroupList(  );//[RAD_FORMINIT_FOREIGNKEY_INIT]    
  
        $links = array();
        
        $links["edit"] = "ex_PageContent.php?modP=P1&editID=";

        $this->pageDisplay->setLinks( $links );    
        
    } // end loadGroupList()



   



    //************************************************************************
	/**
	 * function loadLinkViewer
	 * <pre>
	 * Initializes the LinkViewer Page.
	 * </pre>
	 * @param $isCreated [BOOL] "Is THIS pageDisplay object already created?"
	 * @return [void]
	 */
    // RAD Tools: AdminBox Style
    function loadLinkList( $isCreated=false ) 
    {
        // create a new pageDisplay object
        $this->pageDisplay = new FormProcessor_LinkList( );//[RAD_FORMINIT_FOREIGNKEY_INIT]    
  
        $links = array();
        
        $links["edit"] = "ex_PageContent.php?modP=P1&editID=";

        $this->pageDisplay->setLinks( $links );       
        
    } // end loadLinkViewer()



/*[RAD_PAGE_LOAD_FN]*/		

}

?>