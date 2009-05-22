<?php
/**
 * @package NavBar
 */ 
/**
 * class RowManager_NavBarCacheManager
 * <pre> 
 * Stores the generated nav bar information for a user..
 * </pre>
 * @author Johnny Hausman
 */
class  RowManager_NavBarCacheManager extends RowManager {

	//CONSTANTS:
	/** The name of the DB Table this class manages. */
    const DB_TABLE = 'navbar_navbarcache';
    
    /** The SQL description of the DB Table this class manages. */
    /*
     * navbarcache_id [INTEGER]  Primary Key for this table.
     * viewer_id [INTEGER]  Foreign Key linking this cache entry to a viewer.
     * language_id [INTEGER]  Foreign Key linking this cache entry to a particular language version. (each viewer can have a cache entry for each language)
     * navbarcache_cacheMain [STRING]  Holds the main nav bar data.
     * navbarcache_cacheSub [STRING]  Holds the sub menu data cache
     * navbarcache_isValid [BOOL]  BOOL flag indicating if this cache info is valid.
     */
    const DB_TABLE_DESCRIPTION = " (
  navbarcache_id int(11) NOT NULL  auto_increment,
  viewer_id int(11) NOT NULL  default '0',
  language_id int(11) NOT NULL  default '0',
  navbarcache_cache text NOT NULL  default '',
  navbarcache_isValid int(1) NOT NULL  default '0',
  PRIMARY KEY (navbarcache_id)
) TYPE=MyISAM";
    
    /** The fields in the DB Table this class manages. */
    const FIELD_LIST = 'navbarcache_id,viewer_id,language_id,navbarcache_cache,navbarcache_isValid';
    
    /** The XML node name for this entry. */
    const XML_NODE_NAME = 'navbarcache';
    
    /** The tag for the path to root value */
    const TAG_PATHTOROOT = '[pathToRoot]';
    

	//VARIABLES:


	//CLASS CONSTRUCTOR
	//************************************************************************
	/**
	 * function __construct
	 * <pre>
	 * Initialize this object.
	 * </pre>
	 * @param $initValue [INTEGER] The unique id of the navbarcache we are managing.
	 * @return [void]
	 */
    function __construct( $initValue=-1 ) 
    {
    
        $dbTableName = RowManager_NavBarCacheManager::DB_TABLE;
        $fieldList = RowManager_NavBarCacheManager::FIELD_LIST;
        $primaryKeyField = 'navbarcache_id';
        $primaryKeyValue = $initValue;
        
        if (( $initValue != -1 ) && ( $initValue != '' )) {
        
            $condition = $primaryKeyField . '=' . $primaryKeyValue;
            
        } else {
            $condition = '';
        }
        $xmlNodeName = RowManager_NavBarCacheManager::XML_NODE_NAME;
        parent::__construct( $dbTableName, $fieldList, $primaryKeyField, $primaryKeyValue, $condition, $xmlNodeName);
        
        $this->dbDescription = RowManager_NavBarCacheManager::DB_TABLE_DESCRIPTION;
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
	 * function createCache
	 * <pre>
	 * Create a cache entry for a given viewer_id and language_id
	 * </pre>
	 * @param $viewerID [OBJECT] the viewer object of the person to make a
	 * cache entry for.
	 * @return [void]
	 */
    function createCache( $viewer ) 
    {
    
        $viewerID = $viewer->getID();
        $languageID = $viewer->getLanguageID();
        
        $groupArray = array();
        
        // Make sure all required Row Managers are included
        $accountAdminPath = SITE_PATH_MODULES.'site_AccountAdmin/objects_da/';
        $navBarPath = SITE_PATH_MODULES.'site_NavBar/objects_da/';
        $pathToRoot = Page::findPathExtension( $accountAdminPath );
        require_once( $pathToRoot.$accountAdminPath.'ViewerAccessGroupManager.php' );
        require_once( $pathToRoot.$navBarPath.'NavBarGroupManager.php' );
        require_once( $pathToRoot.$navBarPath.'NavLinkAccessGroupManager.php' );
        require_once( $pathToRoot.$navBarPath.'NavLinkViewerManager.php' );
        require_once( $pathToRoot.$navBarPath.'NavBarLinksManager.php' );
        
        // get list of Links linked to this viewer
            // array of links: link_id, link_text, link_url, group_id
        $viewerLinks = $this->getViewerLinks( $viewerID, $languageID);


        // get list of Links linked to this viewer's groups
            // array of links: link_id, link_text, link_url, group_id
        $groupLinks = $this->getGroupLinks( $viewerID, $languageID);
          
          
        /*
         * combine lists
         */
        $combinedLinks = array();
        $usedLinks = array();
        
        // for each viewerLink 
        for( $indx=0; $indx<count($viewerLinks); $indx++) {
        
            // compute a link key
            $linkKey = $viewerLinks[ $indx ][ 'navbarlink_url'].'['.$viewerLinks[$indx]['module_id'].']';
            
            // if this link key has not already been added (no duplicate links)
            if (!key_exists( $linkKey, $usedLinks ) ) {
                $usedLinks[ $linkKey ] = $linkKey;
                $combinedLinks[] = $viewerLinks[ $indx ];
            }
        }
        
        // for each groupLink
        for( $indx=0; $indx<count($groupLinks); $indx++) {
            $linkKey = $groupLinks[ $indx ][ 'navbarlink_url'].'['.$groupLinks[$indx]['module_id'].']';
            
            if (!key_exists( $linkKey, $usedLinks ) ) {
                $usedLinks[ $linkKey ] = $linkKey;
                $combinedLinks[] = $groupLinks[ $indx ];
            }
        }


        // for each link in combinedLinks
        for ($indx=0; $indx<count( $combinedLinks ); $indx++ ) {
        
            // if groupObject in GroupArray then
            $groupID = (int) $combinedLinks[ $indx ]['navbargroup_id'];
            if (!key_exists( $groupID, $groupArray) ) {
            
                // create new group Object
                $group = new GroupItem();
                $groupManager = new RowManager_NavBarGroupManager( $groupID );
                $multiLingualContext = new MultilingualManager( $languageID );
                $bridgeManager = $groupManager->getRowLabelBridge( $multiLingualContext );
                
                $group->loadFromArray( $bridgeManager->getArrayOfValues() );
                
                // store in GroupArray
                $groupArray[ $groupID ] = $group;
                
            } // end if
            
            // Add link Object to Group Object
            $link = new LinkItem();
            $link->loadFromArray( $combinedLinks[ $indx ] );
            $groupArray[ $groupID ]->addItem( $link );
            
        } // next item
        
        
        // Now manually sort the group Items since we couldn't get the SQL
        // to sort it.
        $sortedArray = array();
        foreach( $groupArray as $group ) {
            $key = $group->getOrder().$group->getText();
            $sortedArray[ $key ] = $group;
        }
        ksort( $sortedArray );


        // send array of group objects to Template
        $template = new Template( $pathToRoot.SITE_PATH_MODULES.'site_NavBar/templates/' );
        
        $template->set( 'arrayGroup', $sortedArray);
        $template->set( 'pathToRoot', $this->getPathToRootTag() );
        
        // get cache data from template
        $cacheData = $template->fetch( 'obj_NavBar.php' );
        
        $cacheData = str_replace( '[userID]', $viewer->getUserID(), $cacheData);
        $cacheData = str_replace( '[passWord]', $viewer->getPassword(), $cacheData);
        if ((int) $viewer->getLanguageID() == 1) {
            $cacheData = str_replace( '[gtsLanguageID]', 'en', $cacheData);
        } else {
            $cacheData = str_replace( '[gtsLanguageID]', 'chi', $cacheData);
        }

        // store cache data in this object
        $this->setValueByFieldName( 'navbarcache_cache', $cacheData);
//echo 'cacheData=[<pre>'.$cacheData.'</pre>]<br>';



        // set isValid to true
        $this->setCacheValid();
        $this->setViewerID( $viewerID );
        $this->setLanguageID( $languageID );
        


        // update DB Table
        if ($this->isLoaded() ) {
            $this->updateDBTable();
        } else {
            $this->createNewEntry();
        }
        
    }
    
    
    
    //************************************************************************
	/**
	 * function flushCacheEntries
	 * <pre>
	 * Marks all current cache entries as invalid.
	 * </pre>
	 * @return [void]
	 */
    function flushCacheEntries() 
    {
        $this->clearValues();
        //$this->setCacheInValid();
        $values = array();
        $values[ 'navbarcache_isValid' ] = 0;
        $oldValues = $this->values;
        $this->values = $values;
        $this->setDBCondition( 'navbarcache_id<>0' );
        $this->updateDBTable();
        $this->setDBCondition( '' );
        $this->values = $oldValues;
        
    }
    
    
    
    //************************************************************************
	/**
	 * function getCache
	 * <pre>
	 * Gets the cache data for this entry.
	 * </pre>
	 * @return [STRING]
	 */
    function getCache() 
    {
        return $this->getValueByFieldName( 'navbarcache_cache' );
    }
    
    
    
    //************************************************************************
	/**
	 * function getGroupLinks
	 * <pre>
	 * Returns an array of links linked directly to groups this viewer is 
	 * linked to.
	 * </pre>
     * @param $viewerID [INTEGER] the viewer_id of the person to make a cache
	 * entry for.
	 * @param $languageID [INTEGER] the language_id of the cache entry 
	 * @return [ARRAY]
	 */
    function getGroupLinks( $viewerID, $languageID) 
    {
        $resultArray = array();
        
        // create Link RowLabelBridge
        $linkManager = new RowManager_NavBarLinksManager( );
        $multiLingualContext = new MultilingualManager( $languageID, 'moduleNavBar', 'navBarLinks' );
        $bridgeManager = $linkManager->getRowLabelBridge( $multiLingualContext ); 

        
        // add to it the LinkAccessGroup table
        $linkGroup = new RowManager_NavLinkAccessGroupManager();
        $joinPair = new JoinPair($linkGroup->getJoinOnLinkID() , $linkManager->getJoinOnLinkID() );
        $bridgeManager->addRowManager( $linkGroup, $joinPair);     
        
        // add to it the ViewerAccessGroup Table
        $viewerAccessGroup = new RowManager_ViewerAccessGroupManager();
        $viewerAccessGroup->setViewerID( $viewerID );
        $joinPair = new JoinPair( $viewerAccessGroup->getJoinOnGroupID(), $linkGroup->getJoinOnGroupID() );
        $bridgeManager->addRowManager( $viewerAccessGroup, $joinPair);
        
        // get list of entries
        $list = $bridgeManager->getListIterator();     
        
        // for each item 
        $list->setFirst();
        while ( $link = $list->getNext() ) {
        
            // add to resultArray            
            $resultArray[] = $link->getArrayOfValues();
            
        } // next item
        
        return $resultArray;
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
        return "NoFieldMarked";
    }
    
    
    
    //************************************************************************
	/**
	 * function getPathToRootTag
	 * <pre>
	 * Returns the tag for the path to root tag.
	 * </pre>
	 * @return [STRING]
	 */
    function getPathToRootTag() 
    {
        return RowManager_NavBarCacheManager::TAG_PATHTOROOT;
    }
    
    
    
    //************************************************************************
	/**
	 * function getViewerLinks
	 * <pre>
	 * Returns an array of links linked directly to this viewer.
	 * </pre>
     * @param $viewerID [INTEGER] the viewer_id of the person to make a cache
	 * entry for.
	 * @param $languageID [INTEGER] the language_id of the cache entry 
	 * @return [ARRAY]
	 */
    function getViewerLinks( $viewerID, $languageID) 
    {
        $resultArray = array();
        
        // create Link RowLabelBridge
        $linkManager = new RowManager_NavBarLinksManager( );
        $multiLingualContext = new MultilingualManager( $languageID, 'moduleNavBar', 'navBarLinks' );
        $bridgeManager = $linkManager->getRowLabelBridge( $multiLingualContext ); 
        
        $bridgeManager->setSortOrder( 'navbargroup_id' );

        
        // add to it the LinkViewer table
        $linkViewer = new RowManager_NavLinkViewerManager();
        $linkViewer->setViewerID( $viewerID );
        
        $joinPair = new JoinPair($linkViewer->getJoinOnLinkID() , $linkManager->getJoinOnLinkID() );
        $bridgeManager->addRowManager( $linkViewer, $joinPair);     
        
        // get list of entries
        $list = $bridgeManager->getListIterator();     
        
        // for each item 
        $list->setFirst();
        while ( $link = $list->getNext() ) {
        
            // add to resultArray            
            $resultArray[] = $link->getArrayOfValues();
            
        } // next item
        
        return $resultArray;
    }
    
    
    
    //************************************************************************
	/**
	 * function isValid
	 * <pre>
	 * Returns wether or not the current item is valid.
	 * </pre>
	 * @return [BOOL]
	 */
    function isValid() 
    {
        $isValid = (int) $this->getValueByFieldName( 'navbarcache_isValid' );
        return ($isValid == 1);
    }
    
    
    
    //************************************************************************
	/**
	 * function loadByViewerID
	 * <pre>
	 * Attempt to load a NavBarCache entry for a given viewer Object
	 * </pre>
	 * @param $viewerID [INTEGER] the viewer_id of the person to get a cache
	 * entry for.
	 * @param $languageID [INTEGER] the language_id of the cache entry 
	 * @return [BOOL]
	 */
    function loadByViewerID($viewerID, $languageID) 
    {
        if ($viewerID != '') {
            $condition = 'viewer_id='.$viewerID.' AND language_id='.$languageID;
            if( $this->loadByCondition( $condition ) ) {
                return $this->isValid();
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
    
    
    
    //************************************************************************
	/**
	 * function setCacheInValid
	 * <pre>
	 * Marks the cache as being invalid.
	 * </pre>
	 * @return [void]
	 */
    function setCacheInValid() 
    {
        $this->setValueByFieldName( 'navbarcache_isValid', 0 );
    }
    
    
    
    //************************************************************************
	/**
	 * function setCacheValid
	 * <pre>
	 * Marks the cache as being Valid.
	 * </pre>
	 * @return [void]
	 */
    function setCacheValid() 
    {
        $this->setValueByFieldName( 'navbarcache_isValid', 1 );
    }
    
    
    
    //************************************************************************
	/**
	 * function setLanguageID
	 * <pre>
	 * Stores the language_id.
	 * </pre>
	 * @param $languageID [INTEGER] the language_id
	 * @return [void]
	 */
    function setLanguageID( $languageID ) 
    {
        $this->setValueByFieldName( 'language_id', $languageID );
    }
    
    
    
    //************************************************************************
	/**
	 * function setViewerID
	 * <pre>
	 * Stores the viewer_id.
	 * </pre>
	 * @param $viewerID [INTEGER] the viewer_id
	 * @return [void]
	 */
    function setViewerID( $viewerID ) 
    {
        $this->setValueByFieldName( 'viewer_id', $viewerID );
    }

    
    	
}



/**
 * class GroupItem
 * <pre> 
 * Manages a particular Group
 * </pre>
 * @author Johnny Hausman
 */
class  GroupItem {

    protected $label;
    protected $items;
    protected $order;
    
    
	//************************************************************************
	function __construct() {
        $this->label = '';
        $this->items = array();
        $this->order = 0;
	}



//
//	CLASS FUNCTIONS:
//



    //************************************************************************
	/**
	 * function addItem
	 * <pre>
	 * Stores this item in the Group
	 * </pre>
	 * @param $item [OBJECT] a Link or Group to add to this group
	 * @return [void]
	 */
	function addItem( $item ) 
	{
	   $this->items[] = $item;
	}	



    //************************************************************************
	/**
	 * function getItems
	 * <pre>
	 * Returns the array of items for this group
	 * </pre>
	 * @return [ARRAY]
	 */
	function getItems() 
	{
	   return $this->items;
	}		



    //************************************************************************
	/**
	 * function getOrder
	 * <pre>
	 * Returns the order of this group item
	 * </pre>
	 * @return [INTEGER]
	 */
	function getOrder() 
	{
	   return $this->order;
	}		



    //************************************************************************
	/**
	 * function getText
	 * <pre>
	 * Returns the text of this group
	 * </pre>
	 * @return [STRING]
	 */
	function getText() 
	{
	   return $this->label;
	}	
	
	
	
	//************************************************************************
	/**
	 * function isGroup
	 * <pre>
	 * Returns wether or not this object is a Group object
	 * </pre>
	 * @return [BOOL]
	 */
	function isGroup() 
	{
	   return true;
	}
	
	
	
	//************************************************************************
	/**
	 * function loadFromArray
	 * <pre>
	 * Initialize this object
	 * </pre>
	 * @return [void]
	 */
	function loadFromArray( $values) 
	{
        $this->label = $values[ 'label_label' ];
        $this->order = (int) $values[ 'navbargroup_order' ];
	}	

}




/**
 * class LinkItem
 * <pre> 
 * Manages a particular Link
 * </pre>
 * @author Johnny Hausman
 */
class  LinkItem {

    protected $label;
    protected $url;
    protected $order;
    protected $title;
    

	//************************************************************************
	function __construct() 
	{
	
	}

//
//	CLASS FUNCTIONS:
//
	
	
    //************************************************************************
	/**
	 * function getText
	 * <pre>
	 * Returns the text of this link
	 * </pre>
	 * @return [STRING]
	 */
	function getText() 
	{
	   return $this->label;
	}	
	
	
	
    //************************************************************************
	/**
	 * function getTitle
	 * <pre>
	 * Returns the title of this link
	 * </pre>
	 * @return [STRING]
	 */
	function getTitle() 
	{
	   return $this->title;
	}
	
	
	
	//************************************************************************
	/**
	 * function getURL
	 * <pre>
	 * Returns the url of this link
	 * </pre>
	 * @return [STRING]
	 */
	function getURL() 
	{
	   return $this->url;
	}
	
	
	
	//************************************************************************
	/**
	 * function isGroup
	 * <pre>
	 * Returns wether or not this object is a Group object
	 * </pre>
	 * @return [BOOL]
	 */
	function isGroup() 
	{
	   return false;
	}
	
	

	//************************************************************************
	/**
	 * function loadFromArray
	 * <pre>
	 * initialized the values of this link
	 * </pre>
	 * @return [STRING]
	 */
	function loadFromArray( $values ) 
	{
        
        $this->label = $values['label_label'];
        
        $url = $values[ 'navbarlink_url' ];
        if ((int) $values[ 'module_id' ] != 0) {
            
            $moduleManager = new RowManager_siteModuleManager( $values[ 'module_id' ] );
            $url = 'index.php?'.Page::QS_MODULE.'='.$moduleManager->getKey();
            
        }
        $this->url = $url;
        $this->title = $values[ 'label_label' ];
	
	}

}

?>