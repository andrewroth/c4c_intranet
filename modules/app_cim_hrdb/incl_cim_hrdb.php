<?php
		
//		
// cim_hrdb Includes
//
//	This file includes the required classes used by the cim_hrdb Module.
//


// Data Access Objects:
//------------------------
// These objects are responsible for manually working with the data in the 
// databases.  They provide a higher level interface for the Business Logic
// Objects to work with the data.
require_once( 'objects_da/PersonManager.php' );
require_once( 'objects_da/ProvinceManager.php' );
require_once( 'objects_da/CampusManager.php' );
require_once( 'objects_da/GenderManager.php' );
require_once( 'objects_da/AdminManager.php' );
require_once( 'objects_da/PrivManager.php' );
require_once( 'objects_da/CampusAdminManager.php' );
require_once( 'objects_da/StaffManager.php' );
require_once( 'objects_da/ViewerManager.php' );
require_once( 'objects_da/AssignmentsManager.php' );
require_once( 'objects_da/AccessManager.php' );
require_once( 'objects_da/RegionManager.php' );
require_once( 'objects_da/EmergencyInfoManager.php' );
require_once( 'objects_da/CampusAssignmentStatusManager.php' );
require_once( 'objects_da/EditCampusAssignmentManager.php' );
require_once( 'objects_da/PersonYearManager.php' );
require_once( 'objects_da/PersonYearList.php' );
require_once( 'objects_da/CountryManager.php' );

require_once( 'objects_da/YearInSchoolManager.php' );
require_once( 'objects_da/ActivityTypeManager.php' );
require_once( 'objects_da/StaffActivityManager.php' );
require_once( 'objects_da/StaffScheduleTypeManager.php' );
require_once( 'objects_da/StaffScheduleManager.php' );
require_once( 'objects_da/ActivityScheduleManager.php' );
require_once( 'objects_da/FormFieldManager.php' );
require_once( 'objects_da/FormFieldValueManager.php' );
require_once( 'objects_da/FieldGroupManager.php' );
require_once( 'objects_da/FieldGroup_MatchesManager.php' );
require_once( 'objects_da/StaffScheduleInstrManager.php' );
require_once( 'objects_da/StaffDirectorManager.php' );
require_once( 'objects_da/CustomReportsManager.php' );
require_once( 'objects_da/CustomFieldsManager.php' );
require_once( 'objects_da/MinistryManager.php' );
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
require_once( 'objects_pages/page_EditMyInfo.php' );
require_once( 'objects_pages/page_HrdbHome.php' );
require_once( 'objects_pages/page_Countries.php' );
require_once( 'objects_pages/page_Provinces.php' );
require_once( 'objects_pages/page_ImportData.php' );
require_once( 'objects_pages/page_Campuses.php' );
require_once( 'objects_pages/page_People.php' );
require_once( 'objects_pages/page_AddPerson.php' );
require_once( 'objects_pages/page_NewPerson.php' );
require_once( 'objects_pages/page_Privileges.php' );
require_once( 'objects_pages/page_People.php' );
require_once( 'objects_pages/page_PeopleList.php' );
require_once( 'objects_pages/page_DeletePerson.php' );
require_once( 'objects_pages/page_Staff.php' );
// require_once( 'objects_pages/page_ViewStaff.php' );
require_once( 'objects_pages/page_AddAdmin.php' );
require_once( 'objects_pages/page_AddAdmin.php' );
require_once( 'objects_pages/page_EditMyInfo.php' );
require_once( 'objects_pages/page_EditPerson.php' );
require_once( 'objects_pages/page_AddStaff.php' );
require_once( 'objects_pages/page_Staff.php' );
require_once( 'objects_pages/page_DeleteStaff.php' );
require_once( 'objects_pages/page_Admins.php' );
require_once( 'objects_pages/page_DeleteAdmin.php' );
require_once( 'objects_pages/page_ViewCampuses.php' );
require_once( 'objects_pages/page_People.php' );
require_once( 'objects_pages/page_CampusAssignments.php' );
require_once( 'objects_pages/page_PersonInfo.php' );
require_once( 'objects_pages/page_PeopleCampus.php' );
require_once( 'objects_pages/page_PeoplebyCampuses.php' );
require_once( 'objects_pages/page_AdminPrivs.php' );
require_once( 'objects_pages/page_NewAccount.php' );
require_once( 'objects_pages/page_EditMyEmergInfo.php' );
require_once( 'objects_pages/page_EditCampusAssignmentStatusTypes.php' );
require_once( 'objects_pages/page_EditCampusAssignment.php' );
require_once( 'objects_pages/page_EditRegion.php' );
require_once( 'objects_pages/page_EditPeople.php' );
require_once( 'objects_pages/page_EditMyCampusAssignment.php' );
require_once( 'objects_pages/page_EditMyYearInSchool.php' );
require_once( 'objects_pages/page_EditStudentYearInSchool.php' );
require_once( 'objects_pages/page_ViewStudentYearInSchool.php' );
require_once( 'objects_pages/page_NotAuthorized.php' );
require_once( 'objects_pages/page_DownloadCSV.php' );

require_once( 'objects_pages/page_HrdbForms.php' );
require_once( 'objects_pages/page_EditFormFields.php' );
require_once( 'objects_pages/page_EditBasicStaffForm.php' );
require_once( 'objects_pages/page_EditStaffScheduleForm.php' );
require_once( 'objects_pages/page_EditStaffActivity.php' );
require_once( 'objects_pages/page_ApproveStaffSchedule.php' );
require_once( 'objects_pages/page_FormApprovalListing.php' );
require_once( 'objects_pages/page_EditStaffFormContext.php' );
require_once( 'objects_pages/page_EditStaffFormInstructions.php' );
require_once( 'objects_pages/page_EditHrdbForm.php' );
require_once( 'objects_pages/page_ViewScheduleCalendar.php' );
require_once( 'objects_pages/page_ViewStaffActivities.php' );
require_once( 'objects_pages/page_HrdbActivities.php' );
require_once( 'objects_pages/page_ViewActivitiesByDate.php' );
require_once( 'objects_pages/page_FormSubmittedListing.php' );

require_once( 'objects_pages/page_EditActivityTypes.php' );
require_once( 'objects_pages/page_EditCustomReports.php' );
require_once( 'objects_pages/page_ViewCustomReport.php' );
require_once( 'objects_pages/page_CustomReportsListing.php' );
require_once( 'objects_pages/page_EditStaff.php' );
require_once( 'objects_pages/page_EditCustomReportMetaData.php' );
/*[RAD_INCLUDE_PAGES]*/


// Common Display Object:
// ----------------------
// This object provides a common layout for the pages in this module.  The
// related templated file is stored in /templates/obj_CommonDisplay.php
require_once( 'objects_bl/obj_CommonDisplay.php');
require_once( 'objects_bl/obj_AdminSideBar.php');

?>