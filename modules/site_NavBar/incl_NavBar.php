<?php
		
//		
// NavBar Includes
//
//	This file includes the required classes used by the NavBar Module.
//


// Data Access Objects:
//------------------------
// These objects are responsible for manually working with the data in the 
// databases.  They provide a higher level interface for the Business Logic
// Objects to work with the data.
require_once( 'objects_da/NavBarGroupManager.php' );
//require_once( 'objects_da/NavBarGroupList.php' );
require_once( 'objects_da/NavBarLinksManager.php' );
//require_once( 'objects_da/NavBarLinksList.php' );
require_once( 'objects_da/NavLinkAccessGroupManager.php' );
//require_once( 'objects_da/NavLinkAccessGroupList.php' );
require_once( 'objects_da/NavLinkViewerManager.php' );
//require_once( 'objects_da/NavLinkViewerList.php' );
require_once( 'objects_da/NavBarCacheManager.php' );
//require_once( 'objects_da/NavBarCacheList.php' );
require_once( 'objects_da/NavBarContentDataManager.php' );
//require_once( 'objects_da/NavBarContentDataList.php' );
require_once( 'objects_da/NavBarXlateManager.php' );
//require_once( 'objects_da/NavBarXlateList.php' );
/*[RAD_INCLUDE_DA]*/


// Business Logic Objects:
//------------------------
// These objects are responsible for how loading data, verifying correct data,
// and directing the Data Access Objects to store the information.
require_once( 'objects_bl/page_GroupList.php' );
require_once( 'objects_bl/page_LinkList.php' );
require_once( 'objects_bl/page_LinkGroups.php' );
require_once( 'objects_bl/page_LinkViewer.php' );
/*[RAD_INCLUDE_BL]*/
//require_once( 'objects_bl/FormProcessor.php' );




?>