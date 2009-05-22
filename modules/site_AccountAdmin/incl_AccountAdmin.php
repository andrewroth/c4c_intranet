<?php
		
//		
// AccountAdmin Includes
//
//	This file includes the required classes used by the AccountAdmin Module.
//


// Data Access Objects:
//------------------------
// These objects are responsible for manually working with the data in the 
// databases.  They provide a higher level interface for the Business Logic
// Objects to work with the data.
require_once( 'objects_da/ViewerManager.php' );
require_once( 'objects_da/ViewerList.php' );
require_once( 'objects_da/AccountGroupManager.php' );
require_once( 'objects_da/AccountGroupList.php' );
require_once( 'objects_da/AccessCategoryManager.php' );
require_once( 'objects_da/AccessCategoryList.php' );
//require_once( 'objects_da/AccessGroupManager.php' );
require_once( 'objects_da/AccessGroupList.php' );
require_once( 'objects_da/LanguageLabelManager.php' );
require_once( 'objects_da/LanguageLabelList.php' );
require_once( 'objects_da/LanguageLabelBridge.php' );
//require_once( 'objects_da/LanguageManager.php' );
//require_once( 'objects_da/LanguageList.php' );
require_once( 'objects_da/ViewerAccessGroupManager.php' );
require_once( 'objects_da/ViewerAccessGroupList.php' );
require_once( 'objects_da/AccountAdminAccessManager.php' );
require_once( 'objects_da/AccountAdminAccessList.php' );
/*[RAD_INCLUDE_DA]*/


// Business Logic Objects:
//------------------------
// These objects are responsible for how loading data, verifying correct data,
// and directing the Data Access Objects to store the information.
require_once( 'objects_bl/page_AccountList.php' );
require_once( 'objects_bl/page_AddViewer.php' );
require_once( 'objects_bl/page_EditViewer.php' );
require_once( 'objects_bl/page_EditPassword.php' );
require_once( 'objects_bl/page_DeleteViewer.php' );
require_once( 'objects_bl/page_AccessCategories.php' );
require_once( 'objects_bl/page_AccessGroup.php' );
require_once( 'objects_bl/page_LanguageList.php' );
require_once( 'objects_bl/page_AccountAccess.php' );
require_once( 'objects_bl/page_AccountGroup.php' );
require_once( 'objects_bl/page_AccessPriv.php' );
require_once( 'objects_bl/page_PasswordChanged.php' );
require_once( 'objects_bl/obj_AdminSideBar.php' );
/*[RAD_INCLUDE_BL]*/
//require_once( 'objects_bl/FormProcessor.php' );




?>