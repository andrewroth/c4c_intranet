<?php
		
//		
// EmailTemplates Includes
//
//	This file includes the required classes used by the EmailTemplates Module.
//

require_once('def_EmailTemplates.php');
// Data Access Objects:
//------------------------
// These objects are responsible for manually working with the data in the 
// databases.  They provide a higher level interface for the Business Logic
// Objects to work with the data.
require_once( 'objects_da/EmailTemplateManager.php' );
require_once( 'objects_da/EmailTemplateList.php' );
/*[RAD_INCLUDE_DA]*/


// Business Logic Objects:
//------------------------
// These objects are responsible for how loading data, verifying correct data,
// and directing the Data Access Objects to store the information.
require_once( 'objects_bl/page_TemplateAdminPage.php' );
require_once( 'objects_bl/page_EditTemplate.php' );
/*[RAD_INCLUDE_BL]*/
//require_once( 'objects_bl/FormProcessor.php' );
//require_once( 'tools/Emailer.php' );
//require_once( 'tools/EmailTemplate.php' );



?>