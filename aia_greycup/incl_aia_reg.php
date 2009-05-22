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
// require_once( 'objects_da/EventManager.php' );
// require_once( 'objects_da/FieldTypeManager.php' );
// require_once( 'objects_da/PriceRuleTypeManager.php' );
// require_once( 'objects_da/CreditCardTypeManager.php' );
// require_once( 'objects_da/PrivilegeTypeManager.php' );
// require_once( 'objects_da/SuperAdminAssignmentManager.php' );
// require_once( 'objects_da/EventAdminAssignmentManager.php' );
// require_once( 'objects_da/FieldManager.php' );
// require_once( 'objects_da/DataTypeManager.php' );
// require_once( 'objects_da/PriceRuleManager.php' );
// require_once( 'objects_da/EventAdminCampusAssignmentManager.php' );
// require_once( 'objects_da/CashTransactionManager.php' );
// require_once( 'objects_da/CreditCardTransactionManager.php' );
// require_once( 'objects_da/FieldValueManager.php' );
// // require_once( 'objects_da/RegistrationManager.php' );   				// app_cim_reg versions used
// require_once( 'objects_da/ScholarshipAssignmentManager.php' );
// require_once( 'objects_da/StatusManager.php' );
// require_once( 'objects_da/ReceiptManager.php' );
// require_once( 'objects_da/ActiveRuleManager.php' );
// require_once( 'objects_da/PrivilegeManager.php' );
require_once( '../Tools/TicketsManager.php' );

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
// require_once( 'objects_pages/page_Reg_home.php' );
// require_once( 'objects_pages/page_AdminHome.php' );
// require_once( 'objects_pages/page_AdminEventHome.php' );
// require_once( 'objects_pages/page_EventDetails.php' );
// require_once( 'objects_pages/page_EditFieldTypes.php' );
// require_once( 'objects_pages/page_EditPriceRuleTypes.php' );
// require_once( 'objects_pages/page_EditCreditCardTypes.php' );
// require_once( 'objects_pages/page_EditPrivilegeTypes.php' );
// require_once( 'objects_pages/page_ViewEventDetails.php' );
// require_once( 'objects_pages/page_AddSuperAdmin.php' );
// require_once( 'objects_pages/page_AddEventAdmin.php' );
// require_once( 'objects_pages/page_EditFormFields.php' );
// require_once( 'objects_pages/page_EditPriceRules.php' );
// require_once( 'objects_pages/page_AddCampusAdmin.php' );
// require_once( 'objects_pages/page_EditStatuses.php' );
// require_once( 'objects_pages/page_HomePageEventList.php' );
// require_once( 'objects_pages/page_EditCampusRegistrations.php' );
// require_once( 'objects_pages/page_ConfirmDeleteRegistration.php' );
// require_once( 'objects_pages/page_EditRegistrationDetails.php' );
// require_once( 'objects_pages/page_EditRegistrationScholarshipList.php' );
// require_once( 'objects_pages/page_EditRegistrationCashTransactionsList.php' );
// require_once( 'objects_pages/page_EditRegistrationCCTransactionsList.php' );
// require_once( 'objects_pages/page_EditRegistrationFieldValuesForm.php' );
// //require_once( 'objects_pages/page_EditCampusRegistrations_OffflineRegBox.php' );
// require_once( 'objects_pages/page_EditPersonalInfo.php' );
// require_once( 'objects_pages/page_EditCampusAssignment.php' );
// //require_once( 'objects_pages/page_Downloads.php' );
// require_once( 'objects_pages/page_DownloadReport.php' );
// require_once( 'objects_pages/page_EditFieldValues.php' );
// require_once( 'objects_pages/page_ProcessFinancialTransactions.php' );
// require_once( 'objects_pages/page_ProcessCashTransaction.php' );
// require_once( 'objects_pages/page_ProcessCCTransaction.php' );
// require_once( 'objects_pages/page_ScholarshipDisplayList.php' );
// require_once( 'objects_pages/page_DisplayCCtransactionReceipt.php' );
// require_once( 'objects_pages/page_ConfirmCancelRegistration.php' );
// require_once( 'objects_pages/page_NotAuthorized.php' );
require_once( 'objects_pages/page_ConfirmRegistration.php' );
require_once( 'objects_pages/page_RegisterForm.php' );
/*[RAD_INCLUDE_PAGES]*/


// Common Display Object:
// ----------------------
// This object provides a common layout for the pages in this module.  The 
// related templated file is stored in /templates/obj_CommonDisplay.php
require_once( 'objects_bl/obj_CommonDisplay.php');
// require_once( 'objects_bl/obj_RegProcessSideBar.php');
?>