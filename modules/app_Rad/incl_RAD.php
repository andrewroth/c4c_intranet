<?php
		
//		
// RAD Includes
//
//	This file includes the required classes used by the RAD Module.
//


// Data Access Objects:
//------------------------
// These objects are responsible for manually working with the data in the 
// databases.  They provide a higher level interface for the Business Logic
// Objects to work with the data.
require_once( 'objects_da/ModuleManager.php' );
require_once( 'objects_da/ModuleList.php' );
require_once( 'objects_da/StateVarManager.php' );
require_once( 'objects_da/StateVarList.php' );
require_once( 'objects_da/DAObjManager.php' );
require_once( 'objects_da/DAObjList.php' );
require_once( 'objects_da/DAFieldManager.php' );
require_once( 'objects_da/DAFieldList.php' );
require_once( 'objects_da/PageManager.php' );
require_once( 'objects_da/PageList.php' );
require_once( 'objects_da/PageFieldManager.php' );
require_once( 'objects_da/PageFieldList.php' );
require_once( 'objects_da/PageLabelsManager.php' );
require_once( 'objects_da/PageLabelsList.php' );
require_once( 'objects_da/TransitionsManager.php' );
require_once( 'objects_da/TransitionsList.php' );
require_once( 'objects_da/ModuleCreator.php' );
/*[RAD_INCLUDE_DA]*/


// Business Logic Objects:
//------------------------
// These objects are responsible for how loading data, verifying correct data,
// and directing the Data Access Objects to store the information.
require_once( 'objects_bl/page_ModuleList.php' );
require_once( 'objects_bl/page_AddModule.php' );
require_once( 'objects_bl/page_ViewModule.php' );
require_once( 'objects_bl/page_AddStateVar.php' );
require_once( 'objects_bl/page_DAObjList.php' );
require_once( 'objects_bl/page_AddDAObj.php' );
require_once( 'objects_bl/page_EditDAObj.php' );
require_once( 'objects_bl/page_AddDAFields.php' );
require_once( 'objects_bl/page_AddFieldLabels.php' );
require_once( 'objects_bl/page_ViewPages.php' );
require_once( 'objects_bl/page_AddPage.php' );
require_once( 'objects_bl/page_EditPage.php' );
require_once( 'objects_bl/page_ViewPageFields.php' );
require_once( 'objects_bl/page_AddPageLabels.php' );
require_once( 'objects_bl/page_Transitions.php' );
require_once( 'objects_bl/page_EditModule.php' );
require_once( 'objects_bl/page_DeleteModule.php' );
require_once( 'objects_bl/page_DeleteDAObj.php' );
require_once( 'objects_bl/page_DeletePage.php' );
/*[RAD_INCLUDE_BL]*/
//require_once( 'objects_bl/FormProcessor.php' );




?>