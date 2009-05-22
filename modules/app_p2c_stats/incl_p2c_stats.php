<?php
		
//		
// cim_reg Includes
//
//	This file includes the required classes used by the cim_reg Module.
//


// Data Access Objects:
//------------------------
// These objects are responsible for manually working with the data in the 
// databases.  They provide a higher level interface for the Business Logic
// Objects to work with the data.
require_once( 'objects_da/StatisticManager.php' );
require_once( 'objects_da/StatValueManager.php' );
require_once( 'objects_da/FreqTypeManager.php' );
require_once( 'objects_da/FreqValueManager.php' );
require_once( 'objects_da/MeasureTypeManager.php' );
require_once( 'objects_da/ReportFilterManager.php' );
require_once( 'objects_da/ScopeManager.php' );

require_once( 'objects_da/ReportInfo.php' );
require_once( 'objects_da/MinistryManager.php' );
require_once( 'objects_da/DivisionManager.php' );
require_once( 'objects_da/StatsRegionManager.php' );
require_once( 'objects_da/LocationManager.php' );

require_once( 'objects_da/StatDataTypeManager.php' );
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
require_once( 'objects_pages/page_StatsInputFilterForm.php' );
require_once( 'objects_pages/page_StatsInput.php' );
require_once( 'objects_pages/page_StatsReportFilterForm.php' );
require_once( 'objects_pages/page_StatsReportSelectionForm.php' );
require_once( 'objects_pages/page_StatsReport.php' );
require_once( 'objects_pages/page_DownloadReport.php' );
require_once( 'objects_pages/page_GenericStatsHome.php' );
require_once( 'objects_pages/page_NotAuthorized.php' );
require_once( 'objects_pages/page_EditMinistry.php' );
require_once( 'objects_pages/page_EditDivision.php' );
require_once( 'objects_pages/page_EditRegion.php' );
require_once( 'objects_pages/page_EditLocation.php' );
require_once( 'objects_pages/page_EditStatistic.php' );
/*[RAD_INCLUDE_PAGES]*/


// Common Display Object:
// ----------------------
// This object provides a common layout for the pages in this module.  The 
// related templated file is stored in /templates/obj_CommonDisplay.php
require_once( 'objects_bl/obj_CommonDisplay.php');
require_once( 'objects_bl/obj_SideBar.php');
?>