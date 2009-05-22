<?php
		
//		
// cim_spt Includes
//
//	This file includes the required classes used by the cim_spt Module.
//


// Data Access Objects:
//------------------------
// These objects are responsible for manually working with the data in the 
// databases.  They provide a higher level interface for the Business Logic
// Objects to work with the data.
require_once( 'objects_da/TicketManager.php' );
/*[RAD_INCLUDE_DA]*/


// Business Logic Objects:
//------------------------
// These objects are responsible for how loading data, verifying correct data,
// and directing the Data Access Objects to store the information.
/*[RAD_INCLUDE_BL]*/
//require_once( 'objects_bl/FormProcessor.php' );


// Page Display Objects:
//------------------------
// These objects are responsible for the display of the HTML page.  They handle
// transferring Form data between the HTML forms and the Business Logic Objects.
// They also provide the framework from which the Business Logic objects are
// driven to perform their actions.  Each page displayed for this application
// will generally have an associated Page Display Object.
require_once( 'objects_pages/page_Spt_home.php' );
/*[RAD_INCLUDE_PAGES]*/


// Common Display Object:
// ----------------------
// This object provides a common layout for the pages in this module.  The 
// related templated file is stored in /templates/obj_CommonDisplay.php
require_once( 'objects_bl/obj_CommonDisplay.php');

?>