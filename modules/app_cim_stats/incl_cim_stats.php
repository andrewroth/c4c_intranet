<?php
		
//		
// cim_stats Includes
//
//	This file includes the required classes used by the cim_stats Module.
//

// Data Access Objects:
//------------------------
// These objects are responsible for manually working with the data in the 
// databases.  They provide a higher level interface for the Business Logic
// Objects to work with the data.
require_once( 'objects_da/WeeklyReportManager.php' );
require_once( 'objects_da/WeekManager.php' );
require_once( 'objects_da/SemesterManager.php' );
require_once( 'objects_da/SemesterReportManager.php' );
require_once( 'objects_da/PrcMethodManager.php' );
require_once( 'objects_da/PRCManager.php' );
require_once( 'objects_da/ExposureTypeManager.php' );
require_once( 'objects_da/MoreStatsManager.php' );
require_once( 'objects_da/PrivManager.php' );
// require_once( 'objects_da/AccessManager.php' );
require_once( 'objects_da/CoordinatorManager.php' );

require_once( 'objects_da/IndSemesterInfo.php');
require_once( 'objects_da/PermissionManager.php');
require_once( 'objects_da/IndCampusSemesterInfo.php');
require_once( 'objects_da/CampusExposure.php');
require_once( 'objects_da/YearManager.php' );
/*[RAD_INCLUDE_DA]*/


// Business Logic Objects:
//------------------------
// These objects are responsible for how loading data, verifying correct data,
// and directing the Data Access Objects to store the information.
/*[RAD_INCLUDE_BL]*/
//require_once( 'objects_bl/FormProcessor.php' );
//require_once( '../../site_AccountAdmin/objects_da/ViewerAccessGroupManager.php');


// Page Display Objects:
//------------------------
// These objects are responsible for the display of the HTML page.  They handle
// transferring Form data between the HTML forms and the Business Logic Objects.
// They also provide the framework from which the Business Logic objects are
// driven to perform their actions.  Each page displayed for this application
// will generally have an associated Page Display Object.
require_once( 'objects_pages/page_StaffWeeklyReport.php' );
require_once( 'objects_pages/page_StatsHome.php' );
require_once( 'objects_pages/page_SemesterReport.php' );
require_once( 'objects_pages/page_PrcMethod.php' );
require_once( 'objects_pages/page_SelectPrcSemesterCampus.php' );
require_once( 'objects_pages/page_PRC.php' );
require_once( 'objects_pages/page_ExposureTypes.php' );
require_once( 'objects_pages/page_MoreStats.php' );
require_once( 'objects_pages/page_StaffAdditionalWeeklyStats.php' );
require_once( 'objects_pages/page_PRC_ReportByCampus.php' );
require_once( 'objects_pages/page_Reports.php' );
require_once( 'objects_pages/page_StaffSemesterReport.php' );
require_once( 'objects_pages/page_RegionalSemesterReport.php' );
require_once( 'objects_pages/page_CampusWeeklyStatsReport.php' );
require_once( 'objects_pages/page_CampusYearSummary.php' );
/*[RAD_INCLUDE_PAGES]*/


// Common Display Object:
// ----------------------
// This object provides a common layout for the pages in this module.  The 
// related templated file is stored in /templates/obj_CommonDisplay.php
require_once( 'objects_bl/obj_CommonDisplay.php');

?>