<?PHP
$pathFile = 'General/gen_Includes.php';
$extension = '';
    
// Attempt to find proper directory from current page to Root ...
$numAttempts = 0;
while ( (!file_exists($extension.$pathFile)) && ( $numAttempts < 5) ) {
    
    $extension = '../'.$extension;
    $numAttempts++; 
}
require ( $extension.$pathFile );

// require ( 'app_cim_reg.php' );		// found in includes file now
require ( 'incl_cim_reg.php');


/*
 *  Directory Setup
 *
 *  Setup any specific directories used by this module.
 */
/*
if( !file_exists( modulecim_reg::DEF_DIR_DATA ) ) { 
    mkdir( modulecim_reg::DEF_DIR_DATA);
}
*/




// check to see if the parameter 'skipModule' was provided
$skipModule = isset($_REQUEST['skipModule']);

// if it was NOT provided then update the Modules Table
if (!$skipModule ) {

    
    /*
     * Modules Table
     *
     * Setup the Page Modules Table to include a proper entry for this app.
     */
    $module = new RowManager_siteModuleManager();


    $module->loadByKey( modulecim_reg::MODULE_KEY );
    $module->setKey( modulecim_reg::MODULE_KEY );
    $module->setPath( 'modules/app_cim_reg/' );
    $module->setApplicationFile( 'app_cim_reg.php' );
    $module->setIncludeFile( 'incl_cim_reg.php' );
    $module->setName( 'modulecim_reg' );
    $module->setParameters( '' );
    $module->setSystemAccessFile( 'objects_bl/obj_SystemAccess.php' );
    $module->setSystemAccessObj( modulecim_reg::MODULE_KEY.'Access' );
    
    // if module entry already exists then
    if ( $module->isLoaded() ) {
    
        // update current entry
        $module->updateDBTable();
        
    } else {
    
        // create new entry
        $module->createNewEntry();
    }
    

} else {

    echo 'Skipping Module Table ... <br>';
    
}




// check to see if the parameter 'skipTables' was provided
// $skipTables = isset($_REQUEST['skipTables']);
$skipTables = true;

// if NOT then reset the tables...
if ( !$skipTables ) {


    /*
     * Event Table
     *
     * Manages the information pertaining to events
     *
     * event_id [INTEGER]  unique id
     * event_name [STRING]  name of event
     * event_descBrief [STRING]  brief description
     * event_descDetail [STRING]  Detailed description of the event
     * event_startDate [DATE]  start date
     * event_endDate [DATE]  event's end date
     * event_regStart [DATE]  registration starts
     * event_regEnd [DATE]  event registration ends
     * event_website [STRING]  event website
     * event_emailConfirmText [STRING]  email confirmation text
     * event_basePrice [STRING]  base price for the event
     * event_deposit [INTEGER]  deposit req'd
     * event_contactEmail [STRING]  contact email
     * event_pricingText [STRING]  pricing text
     */
    $Event = new RowManager_EventManager();

    $Event->dropTable();
    $Event->createTable();



    /*
     * FieldType Table
     *
     * Manages field type information
     *
     * fieldtypes_id [INTEGER]  ID for field type
     * fieldtypes_desc [STRING]  Description of field type
     */
    $FieldType = new RowManager_FieldTypeManager();

    $FieldType->dropTable();
    $FieldType->createTable();



    /*
     * PriceRuleType Table
     *
     * A price rule type.
     *
     * priceruletypes_id [INTEGER]  price rule type identifier
     * priceruletypes_desc [STRING]  Describes the price rule type (i.e. frosh discount)
     */
    $PriceRuleType = new RowManager_PriceRuleTypeManager();

    $PriceRuleType->dropTable();
    $PriceRuleType->createTable();



    /*
     * CreditCardType Table
     *
     * Manages credit card type information
     *
     * cctype_id [INTEGER]  Identifier for credit card type
     * cctype_desc [STRING]  Description of the credit card type
     */
    $CreditCardType = new RowManager_CreditCardTypeManager();

    $CreditCardType->dropTable();
    $CreditCardType->createTable();



    /*
     * PrivilegeType Table
     *
     * Manages the information pertaining to registration interface admin privilege types.
     *
     * priv_id [INTEGER]  Identifier for privilege
     * priv_desc [STRING]  Description of the privilege
     */
    $PrivilegeType = new RowManager_PrivilegeTypeManager();

    $PrivilegeType->dropTable();
    $PrivilegeType->createTable();



    /*
     * SuperAdminAssignment Table
     *
     * Assigns super admin privilege to particular viewers.
     *
     * superadmin_id [INTEGER]  Unique identifier for super admin
     * viewer_id [INTEGER]  Identifier of the viewer/user assigned the super-admin role.
     */
    $SuperAdminAssignment = new RowManager_SuperAdminAssignmentManager();

    $SuperAdminAssignment->dropTable();
    $SuperAdminAssignment->createTable();



    /*
     * EventAdminAssignment Table
     *
     * Assigns a particular privilege to a particular user for some event.
     *
     * eventadmin_id [INTEGER]  unique id for event administrator privilege assignment
     * event_id [INTEGER]  id for the event for which privileges are being assigned
     * priv_id [INTEGER]  ID for a particular event privilege
     * viewer_id [INTEGER]  ID associated with a particular system user
     */
    $EventAdminAssignment = new RowManager_EventAdminAssignmentManager();

    $EventAdminAssignment->dropTable();
    $EventAdminAssignment->createTable();



    /*
     * Field Table
     *
     * A form field for a given event.
     *
     * fields_id [INTEGER]  A form field's identifier
     * fieldtype_id [INTEGER]  Identifier for a particular field type
     * fields_desc [STRING]  Description/label associated with a particular field
     * event_id [INTEGER]  The event identifier associated with the form field
     * fields_priority [INTEGER]  The priority of the form field.
     * fields_datacheck [STRING]  The type of data expected to be associated with this form field.
     * fields_reqd [INTEGER]  Whether or not this field is required.
     * fields_invalid [STRING]  Specifies invalid data not allowed in the form field.
     * fields_hidden [INTEGER]  Whether or not the form field is hidden to registrants (but not to admins).
     */
    $Field = new RowManager_FieldManager();

    $Field->dropTable();
    $Field->createTable();



    /*
     * DataType Table
     *
     * Stores some data type used for form fields, etc. Example: Number
     *
     * datatypes_id [INTEGER]  A unique identifier for the data type
     * datatypes_key [STRING]  A unique abbreviation for the data type (i.e. 'N' for 'Number')
     * datatypes_desc [STRING]  A description of the data type.
     */
    $DataType = new RowManager_DataTypeManager();

    $DataType->dropTable();
    $DataType->createTable();



    /*
     * PriceRule Table
     *
     * A pricing rule (i.e. frosh discount) for a particular event.
     *
     * pricerules_id [INTEGER]  Unique identifier for this pricing rule
     * event_id [INTEGER]  Event identifier used to identify event associated with the pricing rule.
     * priceruletypes_id [INTEGER]  Identifies the price rule type of the particular rule
     * pricerules_desc [STRING]  Description of the pricing rule
     * fields_id [INTEGER]  If not zero, refers to a form field identifier that affects the price for the event.
     * pricerules_value [STRING]  A value that is used to determine when the price rule is applied (i.e. a date or a volume total, etc.)
     * pricerules_discount [INTEGER]  The actual discount to be applied to the price based on this price rule.
     */
    $PriceRule = new RowManager_PriceRuleManager();

    $PriceRule->dropTable();
    $PriceRule->createTable();



    /*
     * EventAdminCampusAssignment Table
     *
     * Assigns the event admin privileges of some user to a particular campus.
     *
     * campusaccess_id [INTEGER]  Identifier for a particular campus assignment to some event admin
     * eventadmin_id [INTEGER]  Identifier of the event admin who will be assigned a campus
     * campus_id [INTEGER]  The unique identifier that describes a particular university campus
     */
    $EventAdminCampusAssignment = new RowManager_EventAdminCampusAssignmentManager();

    $EventAdminCampusAssignment->dropTable();
    $EventAdminCampusAssignment->createTable();



    /*
     * CashTransaction Table
     *
     * Manages financial data pertaining to cash transactions between some registrant and the event host.
     *
     * cashtransaction_id [INTEGER]  Unique identifier of a particular cash transaction from some registrant to event host
     * reg_id [INTEGER]  Value identifying the registrant from which the cash originates (if value is positive)
     * cashtransaction_staffName [STRING]  The name of the staff member receiving the cash (or dispersing if cash value is negative).
     * cashtransaction_recd [INTEGER]  Whether or not payment was received (1 or 0 for true/false).
     * cashtransaction_amtPaid [INTEGER]  Dollar amount of cash transaction.
     * cashtransaction_moddate [DATE]  Modification timestamp for cash transaction record.
     */
    $CashTransaction = new RowManager_CashTransactionManager();

    $CashTransaction->dropTable();
    $CashTransaction->createTable();



    /*
     * CreditCardTransaction Table
     *
     * Manages the details pertaining to a credit card transaction from some registrant to the appropriate event host.
     *
     * cctransaction_id [INTEGER]  Unique identifier for a particular credit card transaction record
     * reg_id [INTEGER]  Identifier of the registrant involved in the credit card transaction (generally the payee).
     * cctransaction_cardName [STRING]  Name displayed on the credit card used for this transaction.
     * cctype_id [INTEGER]  Identifier for the particular credit card type used
     * cctransaction_cardNum [STRING]  The credit card number
     * cctransaction_expiry [STRING]  The expiry date of the credit card being used.
     * cctransaction_billingPC [STRING]  Postal code of the credit card's billing address.
     * cctransaction_processed [INTEGER]  Whether or not transaction has been processed (1 = true, 0 = false).
     * cctransaction_amount [INTEGER]  The amount of money being transacted.
     * cctransaction_moddate [DATE]  The timestamp of the last modification to the transaction record.
     */
    $CreditCardTransaction = new RowManager_CreditCardTransactionManager();

    $CreditCardTransaction->dropTable();
    $CreditCardTransaction->createTable();



    /*
     * FieldValue Table
     *
     * Assigns a value to a registration form field for some registrant.
     *
     * fieldvalues_id [INTEGER]  Unique identifier for the field value stored for a particular field-registrant combination.
     * fields_id [INTEGER]  Value identifying the form field being assigned the value.
     * fieldvalues_value [STRING]  The value being assigned to a particular form field for some registration.
     * registration_id [INTEGER]  The value identifying the registration associated with the field value assignment.
     */
    $FieldValue = new RowManager_FieldValueManager();

    $FieldValue->dropTable();
    $FieldValue->createTable();



    /*
     * Registration Table
     *
     * Manages basic registration data for some person-event combination.
     *
     * registration_id [INTEGER]  Unique identifier for this particular registration record
     * event_id [INTEGER]  The event the person is registering for.
     * person_id [INTEGER]  The value identifying the person registering.
     * registration_date [DATE]  The date the registration was made.
     * registration_confirmNum [STRING]  The confirmation number for the registration.
     */
    $Registration = new RowManager_RegistrationManager();

    $Registration->dropTable();
    $Registration->createTable();



    /*
     * ScholarshipAssignment Table
     *
     * Assigns a scholarship to a registrant and manages affiliated data.
     *
     * scholarship_id [INTEGER]  Unique identifier of the scholarship being assigned.
     * registration_id [INTEGER]  Value identifying the registrant receiving the scholarship.
     * scholarship_amount [INTEGER]  The amount of money the scholarship is worth.
     * scholarship_sourceAcct [STRING]  The account number from where the scholarship originates.
     * scholarship_sourceDesc [STRING]  The description of the source account.
     */
    $ScholarshipAssignment = new RowManager_ScholarshipAssignmentManager();

    $ScholarshipAssignment->dropTable();
    $ScholarshipAssignment->createTable();



    /*
     * Status Table
     *
     * Used to describe what state a particular registration is in (unassigned, registered, cancelled, etc.)
     *
     * status_id [INTEGER]  Unique identifier of a particular registration status description
     * status_desc [STRING]  Description of some registration status
     */
    $Status = new RowManager_StatusManager();

    $Status->dropTable();
    $Status->createTable();



    /*
     * Receipt Table
     *
     * A record of an official Moneris operation associated with a particular transaction record.
     *
     * ccreceipt_sequencenum [STRING]  The unique identifier of a receipt returned by Moneris.
     * ccreceipt_authcode [STRING]  According to Moneris:
Authorization code returned from the issuing institution.
     * ccreceipt_responsecode [STRING]  According to Moneris:
Transaction Response Code
< 50: Transaction approved
>= 50: Transaction declined
NULL: Transaction was not sent for authorization
* If you would like further details on the response codes that are returned please see
the Response Codes document available at
https://www3.moneris.com/connect/en/documents/index.html
     * ccreceipt_message [STRING]  According to Moneris:
Response description returned from issuing institution.

Major types: APPROVED, DECLINED, CALL FOR, and HOLD CARD
     * ccreceipt_moddate [DATE]  The timestamp of when the receipt was created (or modified... but preferably no modifications are made).
     * cctransaction_id [INTEGER]  The unique identifier of a CC transaction to associate with this Moneris receipt.
     */
    $Receipt = new RowManager_ReceiptManager();

    $Receipt->dropTable();
    $Receipt->createTable();



    /*
     * ActiveRule Table
     *
     * Used to determine whether the associated (volume) price rule has been triggered. Also keeps track of whether balance-owing recalculation has been executed yet.
     *
     * pricerules_id [INTEGER]  Unique identifier of the associated price rule.
     * is_active [INTEGER]  Indicates whether the (volume) price rule has already been made active or not.
     * is_recalculated [INTEGER]  This is a flag indicating whether a balance-owing recalculation has been run yet with the 'is_active' flag being in its current state.
     */
    $ActiveRule = new RowManager_ActiveRuleManager();

    $ActiveRule->dropTable();
    $ActiveRule->createTable();



/*[RAD_DAOBJ_TABLE]*/

    

} else {

    echo 'Skipping Tables ... <br>';
    
} // end if !skipTables




// check to see if parameter 'skipLabel' was provided
$skipLabel = isset( $_REQUEST['skipLabel'] );

// if not, then add labels to DB ...
if (!$skipLabel) {
        
        
    /*
     *  Insert Labels in DB
     */
    // Create Application Upload Series
    $labelManager = new  MultilingualManager();
    $labelManager->addSeries( modulecim_reg::MULTILINGUAL_SERIES_KEY );
    
    
    
    // Create General Field labels for modulecim_reg 
    $labelManager->addPage( modulecim_reg::MULTILINGUAL_PAGE_FIELDS );

    $labelManager->addLabel( "[Continue]", "Continue", "en" );

    //
    // Event table
    //
	$labelManager->addLabel( "[title_ministry_id]", "Ministry", "en" );    
	$labelManager->addLabel( "[title_event_deposit]", "Deposit", "en" );
	$labelManager->addLabel( "[title_event_contactEmail]", "Contact E-mail", "en" );
	$labelManager->addLabel( "[title_event_pricingText]", "Price Details", "en" );
	$labelManager->addLabel( "[title_event_regEnd]", "Registration Ends", "en" );

	$labelManager->addLabel( "[formLabel_ministry_id]", "Ministry", "en" );    
	$labelManager->addLabel( "[formLabel_event_basePrice]", "Basic Event Price", "en" );
	$labelManager->addLabel( "[formLabel_event_deposit]", "Deposit", "en" );
	$labelManager->addLabel( "[formLabel_event_contactEmail]", "Contact E-mail", "en" );
	$labelManager->addLabel( "[formLabel_event_pricingText]", "Price Details", "en" );
	$labelManager->addLabel( "[formLabel_event_onHomePage]", "Open Event for Registration?", "en" );
	$labelManager->addLabel( "[formLabel_event_allowCash]", "Allow cash transactions?", "en" );	
		

    //
    // FieldType table
    //
    $labelManager->addLabel( "[title_fieldtypes_id]", "ID", "en" );
    $labelManager->addLabel( "[formLabel_fieldtypes_id]", "ID", "en" );
    $labelManager->addLabel( "[title_fieldtypes_desc]", "Description", "en" );
    $labelManager->addLabel( "[formLabel_fieldtypes_desc]", "Description", "en" );


    //
    // PriceRuleType table
    //
    $labelManager->addLabel( "[title_priceruletypes_id]", "Price Rule Type", "en" );
    $labelManager->addLabel( "[formLabel_priceruletypes_id]", "Price Rule Type", "en" );
    $labelManager->addLabel( "[title_priceruletypes_desc]", "Price Rule Type Description", "en" );
    $labelManager->addLabel( "[formLabel_priceruletypes_desc]", "Price Rule Type Description", "en" );


    //
    // CreditCardType table
    //
    $labelManager->addLabel( "[title_cctype_id]", "Card Type", "en" );
    $labelManager->addLabel( "[formLabel_cctype_id]", "Card Type", "en" );
    $labelManager->addLabel( "[title_cctype_desc]", "Card Type Description", "en" );
    $labelManager->addLabel( "[formLabel_cctype_desc]", "Card Type Description", "en" );


    //
    // PrivilegeType table
    //
    $labelManager->addLabel( "[title_priv_id]", "Privilege ID", "en" );
    $labelManager->addLabel( "[formLabel_priv_id]", "Privilege ID", "en" );
    $labelManager->addLabel( "[title_priv_desc]", "Privilege Description", "en" );
    $labelManager->addLabel( "[formLabel_priv_desc]", "Privilege Description", "en" );


    //
    // SuperAdminAssignment table
    //
    $labelManager->addLabel( "[title_superadmin_id]", "Super Admin ID", "en" );
    $labelManager->addLabel( "[formLabel_superadmin_id]", "Super Admin ID", "en" );
    $labelManager->addLabel( "[title_viewer_id]", "User Name", "en" );
    $labelManager->addLabel( "[formLabel_viewer_id]", "User Name", "en" );


    //
    // EventAdminAssignment table
    //
    $labelManager->addLabel( "[title_eventadmin_id]", "Event Admin ID", "en" );
    $labelManager->addLabel( "[formLabel_eventadmin_id]", "Event Admin ID", "en" );
    $labelManager->addLabel( "[title_event_id]", "Event", "en" );
    $labelManager->addLabel( "[formLabel_event_id]", "Event", "en" );
    $labelManager->addLabel( "[title_priv_id]", "Privilege ID", "en" );
    $labelManager->addLabel( "[formLabel_priv_id]", "Privilege ID", "en" );
    $labelManager->addLabel( "[title_viewer_id]", "Viewer ID", "en" );
    $labelManager->addLabel( "[formLabel_viewer_id]", "Viewer ID", "en" );


    //
    // Field table
    //
    $labelManager->addLabel( "[title_fields_id]", "Field ID", "en" );
    $labelManager->addLabel( "[formLabel_fields_id]", "Field ID", "en" );
    $labelManager->addLabel( "[title_fieldtype_id]", "Field Type ID", "en" );
    $labelManager->addLabel( "[formLabel_fieldtype_id]", "Field Type ID", "en" );
    $labelManager->addLabel( "[title_fields_desc]", "Description", "en" );
    $labelManager->addLabel( "[formLabel_fields_desc]", "Description", "en" );
    $labelManager->addLabel( "[title_event_id]", "Event ID", "en" );
    $labelManager->addLabel( "[formLabel_event_id]", "Event ID", "en" );
    $labelManager->addLabel( "[title_fields_priority]", "Field Priority", "en" );
    $labelManager->addLabel( "[formLabel_fields_priority]", "Field Priority", "en" );
    $labelManager->addLabel( "[title_fields_datacheck]", "Data Type", "en" );
    $labelManager->addLabel( "[formLabel_fields_datacheck]", "Data Type", "en" );
    $labelManager->addLabel( "[title_fields_reqd]", "Required?", "en" );
    $labelManager->addLabel( "[formLabel_fields_reqd]", "Required?", "en" );
    $labelManager->addLabel( "[title_fields_invalid]", "Invalid Data", "en" );
    $labelManager->addLabel( "[formLabel_fields_invalid]", "Invalid Data", "en" );
    $labelManager->addLabel( "[title_fields_hidden]", "Hidden?", "en" );
    $labelManager->addLabel( "[formLabel_fields_hidden]", "Hidden?", "en" );
    $labelManager->addLabel( "[formLabel_datatypes_id]", "Data Type", "en" );
    $labelManager->addLabel( "[title_datatypes_id]", "Data Type", "en" );


    //
    // DataType table
    //
    $labelManager->addLabel( "[title_datatypes_id]", "Data Type ID", "en" );
    $labelManager->addLabel( "[formLabel_datatypes_id]", "Data Type ID", "en" );
    $labelManager->addLabel( "[title_datatypes_key]", "Abbreviation", "en" );
    $labelManager->addLabel( "[formLabel_datatypes_key]", "Abbreviation", "en" );
    $labelManager->addLabel( "[title_datatypes_desc]", "Description", "en" );
    $labelManager->addLabel( "[formLabel_datatypes_desc]", "Description", "en" );


    //
    // PriceRule table
    //
    $labelManager->addLabel( "[title_pricerules_id]", "Price Rule ID", "en" );
    $labelManager->addLabel( "[formLabel_pricerules_id]", "Price Rule ID", "en" );
    $labelManager->addLabel( "[title_event_id]", "Event", "en" );
    $labelManager->addLabel( "[formLabel_event_id]", "Event", "en" );
    $labelManager->addLabel( "[title_priceruletypes_id]", "Rule Type", "en" );
    $labelManager->addLabel( "[formLabel_priceruletypes_id]", "Rule Type", "en" );
    $labelManager->addLabel( "[title_pricerules_desc]", "Description", "en" );
    $labelManager->addLabel( "[formLabel_pricerules_desc]", "Description", "en" );
    $labelManager->addLabel( "[title_fields_id]", "Field", "en" );
    $labelManager->addLabel( "[formLabel_fields_id]", "Field", "en" );
    $labelManager->addLabel( "[title_pricerules_value]", "Price Rule Value", "en" );
    $labelManager->addLabel( "[formLabel_pricerules_value]", "Price Rule Value", "en" );
    $labelManager->addLabel( "[title_pricerules_discount]", "Discount", "en" );
    $labelManager->addLabel( "[formLabel_pricerules_discount]", "Discount", "en" );


    //
    // EventAdminCampusAssignment table
    //
    $labelManager->addLabel( "[title_campusaccess_id]", "Campus Access ID", "en" );
    $labelManager->addLabel( "[formLabel_campusaccess_id]", "Campus Access ID", "en" );
    $labelManager->addLabel( "[title_eventadmin_id]", "Event Admin", "en" );
    $labelManager->addLabel( "[formLabel_eventadmin_id]", "Event Admin", "en" );
    $labelManager->addLabel( "[title_campus_id]", "Campus", "en" );
    $labelManager->addLabel( "[formLabel_campus_id]", "Campus", "en" );


    //
    // CashTransaction table
    //
    $labelManager->addLabel( "[title_cashtransaction_id]", "Cash Transaction ID", "en" );
    $labelManager->addLabel( "[formLabel_cashtransaction_id]", "Cash Transaction ID", "en" );
    $labelManager->addLabel( "[title_reg_id]", "Registration", "en" );
    $labelManager->addLabel( "[formLabel_reg_id]", "Registration", "en" );
    $labelManager->addLabel( "[title_cashtransaction_staffName]", "Staff Name", "en" );
    $labelManager->addLabel( "[formLabel_cashtransaction_staffName]", "Staff Name", "en" );
    $labelManager->addLabel( "[title_cashtransaction_recd]", "Cash Received?", "en" );
    $labelManager->addLabel( "[formLabel_cashtransaction_recd]", "Cash Received?", "en" );
    $labelManager->addLabel( "[title_cashtransaction_amtPaid]", "Amount Paid", "en" );
    $labelManager->addLabel( "[formLabel_cashtransaction_amtPaid]", "Amount Paid", "en" );
    $labelManager->addLabel( "[title_cashtransaction_moddate]", "Change Timestamp", "en" );
    $labelManager->addLabel( "[formLabel_cashtransaction_moddate]", "Change Timestamp", "en" );


    //
    // CreditCardTransaction table
    //
    $labelManager->addLabel( "[title_cctransaction_id]", "Credit Card Transaction", "en" );
    $labelManager->addLabel( "[formLabel_cctransaction_id]", "Credit Card Transaction", "en" );
    $labelManager->addLabel( "[title_reg_id]", "Registration", "en" );
    $labelManager->addLabel( "[formLabel_reg_id]", "Registration", "en" );
    $labelManager->addLabel( "[title_cctransaction_cardName]", "Card-holder Name", "en" );
    $labelManager->addLabel( "[formLabel_cctransaction_cardName]", "Card-holder Name", "en" );
    $labelManager->addLabel( "[title_cctype_id]", "Card Type", "en" );
    $labelManager->addLabel( "[formLabel_cctype_id]", "Card Type", "en" );
    $labelManager->addLabel( "[title_cctransaction_cardNum]", "Card #", "en" );
    $labelManager->addLabel( "[formLabel_cctransaction_cardNum]", "Card #", "en" );
    $labelManager->addLabel( "[title_cctransaction_expiry]", "Expiry", "en" );
    $labelManager->addLabel( "[formLabel_cctransaction_expiry]", "Expiry", "en" );
    $labelManager->addLabel( "[title_cctransaction_billingPC]", "Postal Code", "en" );
    $labelManager->addLabel( "[formLabel_cctransaction_billingPC]", "Postal Code", "en" );
    $labelManager->addLabel( "[title_cctransaction_processed]", "Credit Processed?", "en" );
    $labelManager->addLabel( "[formLabel_cctransaction_processed]", "Credit Processed?", "en" );
    $labelManager->addLabel( "[title_cctransaction_amount]", "Amount Paid", "en" );
    $labelManager->addLabel( "[formLabel_cctransaction_amount]", "Amount Paid", "en" );
    $labelManager->addLabel( "[title_cctransaction_moddate]", "Change Timestamp", "en" );
    $labelManager->addLabel( "[formLabel_cctransaction_moddate]", "Change Timestamp", "en" );


    //
    // FieldValue table
    //
    $labelManager->addLabel( "[title_fieldvalues_id]", "Field Value ID", "en" );
    $labelManager->addLabel( "[formLabel_fieldvalues_id]", "Field Value ID", "en" );
    $labelManager->addLabel( "[title_fields_id]", "Field", "en" );
    $labelManager->addLabel( "[formLabel_fields_id]", "Field", "en" );
    $labelManager->addLabel( "[title_fieldvalues_value]", "Value", "en" );
    $labelManager->addLabel( "[formLabel_fieldvalues_value]", "Value", "en" );
    $labelManager->addLabel( "[title_registration_id]", "Registration", "en" );
    $labelManager->addLabel( "[formLabel_registration_id]", "Registration", "en" );


    //
    // Registration table
    //
    $labelManager->addLabel( "[title_registration_id]", "Registration #", "en" );
    $labelManager->addLabel( "[formLabel_registration_id]", "Registration #", "en" );
    $labelManager->addLabel( "[title_event_id]", "Event", "en" );
    $labelManager->addLabel( "[formLabel_event_id]", "Event", "en" );
    $labelManager->addLabel( "[title_person_id]", "Person", "en" );
    $labelManager->addLabel( "[formLabel_person_id]", "Person", "en" );
    $labelManager->addLabel( "[title_registration_date]", "Registration Date", "en" );
    $labelManager->addLabel( "[formLabel_registration_date]", "Registration Date", "en" );
    $labelManager->addLabel( "[title_registration_confirmNum]", "Confirmation #", "en" );
    $labelManager->addLabel( "[formLabel_registration_confirmNum]", "Confirmation #", "en" );
    $labelManager->addLabel( "[title_registration_status]", "Status", "en" );    
    $labelManager->addLabel( "[formLabel_registration_status]", "Status", "en" );
    $labelManager->addLabel( "[title_registration_balance]", "Balance Owing", "en" );
     $labelManager->addLabel( "[formLabel_registration_balance]", "Balance Owing", "en" );      


    //
    // ScholarshipAssignment table
    //
    $labelManager->addLabel( "[title_scholarship_id]", "Scholarship #", "en" );
    $labelManager->addLabel( "[formLabel_scholarship_id]", "Scholarship #", "en" );
    $labelManager->addLabel( "[title_registration_id]", "Registration #", "en" );
    $labelManager->addLabel( "[formLabel_registration_id]", "Registration #", "en" );
    $labelManager->addLabel( "[title_scholarship_amount]", "Scholarship Amount", "en" );
    $labelManager->addLabel( "[formLabel_scholarship_amount]", "Scholarship Amount", "en" );
    $labelManager->addLabel( "[title_scholarship_sourceAcct]", "Source Account", "en" );
    $labelManager->addLabel( "[formLabel_scholarship_sourceAcct]", "Source Account", "en" );
    $labelManager->addLabel( "[title_scholarship_sourceDesc]", "Source Description", "en" );
    $labelManager->addLabel( "[formLabel_scholarship_sourceDesc]", "Source Description", "en" );


    //
    // Status table
    //
    $labelManager->addLabel( "[title_status_id]", "Status", "en" );
    $labelManager->addLabel( "[formLabel_status_id]", "Status", "en" );
    $labelManager->addLabel( "[title_status_desc]", "Status", "en" );
    $labelManager->addLabel( "[formLabel_status_desc]", "Status", "en" );


    //
    // Receipt table
    //
    $labelManager->addLabel( "[title_ccreceipt_sequencenum]", "Receipt ID", "en" );
    $labelManager->addLabel( "[formLabel_ccreceipt_sequencenum]", "Receipt ID", "en" );
    $labelManager->addLabel( "[title_ccreceipt_authcode]", "Auth. Code", "en" );
    $labelManager->addLabel( "[formLabel_ccreceipt_authcode]", "Auth. Code", "en" );
    $labelManager->addLabel( "[title_ccreceipt_responsecode]", "Response Code", "en" );
    $labelManager->addLabel( "[formLabel_ccreceipt_responsecode]", "Response Code", "en" );
    $labelManager->addLabel( "[title_ccreceipt_message]", "Result Message", "en" );
    $labelManager->addLabel( "[formLabel_ccreceipt_message]", "Result Message", "en" );
    $labelManager->addLabel( "[title_ccreceipt_moddate]", "Time Modified", "en" );
    $labelManager->addLabel( "[formLabel_ccreceipt_moddate]", "Time Modified", "en" );
    $labelManager->addLabel( "[title_cctransaction_id]", "CC Transaction ID", "en" );
    $labelManager->addLabel( "[formLabel_cctransaction_id]", "CC Transaction ID", "en" );


    //
    // ActiveRule table
    //
    $labelManager->addLabel( "[title_pricerules_id]", "Price Rule", "en" );
    $labelManager->addLabel( "[formLabel_pricerules_id]", "Price Rule", "en" );
    $labelManager->addLabel( "[title_is_active]", "Is rule active?", "en" );
    $labelManager->addLabel( "[formLabel_is_active]", "Is rule active?", "en" );
    $labelManager->addLabel( "[title_is_recalculated]", "Recalculation executed?", "en" );
    $labelManager->addLabel( "[formLabel_is_recalculated]", "Recalculation executed?", "en" );


/*[RAD_FIELDS_LABEL]*/
    
    
    
    
// Create CommonDisplay labels 
    $labelManager->addPage( CommonDisplay::MULTILINGUAL_PAGE_KEY );
/*
    //
    // Use this section to create your common page label information:
    //
    $labelManager->addLabel( "[Title]", "Title", "en" );
    $labelManager->addLabel( "[Instr]", "Instructions", "en" );
*/


    // Create reg_home labels 
    $labelManager->addPage( page_reg_home::MULTILINGUAL_PAGE_KEY );

    $labelManager->addLabel( "[Instr]", "Welcome to the C4C Registration System v2.0!", "en" );
    $labelManager->addLabel( "[Title]", "Registration Home", "en" );
    $labelManager->addLabel( "[RegComplete]", "Registration Status is: ", "en" );
    $labelManager->addLabel( "[Events]", "Events", "en" );
    $labelManager->addLabel( "[Admins]", "Administrative Access to Registration System", "en" );
    
    
 // Create confirmation e-mail labels (WORKS FOR EDIT CAMPUS REGISTRATIONS E-MAIL AS WELL)
    $labelManager->addLabel( "[Subject]", "Registration Confirmation", "en" ); 
    $labelManager->addLabel( "[ThankYou]", "Thank you for registering for", "en" );
    $labelManager->addLabel( "[ConfirmationNumber]", "Confirmation Number", "en" );
    
    $labelManager->addLabel( "[FinanceInfo]", "Financial Information", "en" );
    $labelManager->addLabel( "[eventBasePrice]", "Event Base Price:", "en" );  
    $labelManager->addLabel( "[BasePriceForYou]", "Base Price for You:", "en" );
    $labelManager->addLabel( "[ScholarshipsInfo]", "Your Event Scholarships", "en" );
    $labelManager->addLabel( "[cashReceived]", "Cash Received:", "en" );
    $labelManager->addLabel( "[cashNotReceived]", "Cash Owing:", "en" );
    $labelManager->addLabel( "[ccProcessed]", "Credit Card Amount Processed:", "en" );
    $labelManager->addLabel( "[ccNotProcessed]", "Credit Card Amount Pending:", "en" );
    $labelManager->addLabel( "[BalanceOwing]", "Balance Owing:", "en" );
                      
    $labelManager->addLabel( "[fName]", "First Name", "en" );
    $labelManager->addLabel( "[lName]", "Last Name", "en" );
    $labelManager->addLabel( "[campus]", "Campus", "en" );
    $labelManager->addLabel( "[ImpInfo]", "Important Information", "en" );
    $labelManager->addLabel( "[footer]", "Note that if you paid less than the full amount via cash or credit the balance is due upon arrival at your event.\n\nPlease direct any questions about the online registration to: ", "en" );
    

    
/*[RAD_PAGE(reg_home)_LABELS]*/

    // Create HomePageEventList labels 
    $labelManager->addPage( page_HomePageEventList::MULTILINGUAL_PAGE_KEY );
    
    $labelManager->addLabel( "[Details]", "Details", "en" );
    $labelManager->addLabel( "[RegisterAccess]", "Registration Access", "en" );
    $labelManager->addLabel( "[Register]", "Register Here", "en" );
    $labelManager->addLabel( "[FinishReg]", "Complete Your Registration", "en" );
    $labelManager->addLabel( "[EditReg]", "Edit Your Registration", "en" );
    $labelManager->addLabel( "[CancelReg]", "Cancel Your Registration", "en" );		// obsolte: moved to registration side-bar

/*[RAD_PAGE(HomePageEventList)_LABELS]*/



    // Create AdminHome labels 
    $labelManager->addPage( page_AdminHome::MULTILINGUAL_PAGE_KEY );

    $labelManager->addLabel( "[Title]", "Administrator Home", "en" );
    $labelManager->addLabel( "[Instr]", "You have administrative access to the following events.", "en" );
    $labelManager->addLabel( "[title_access]", "Admin Access", "en" );
    $labelManager->addLabel( "[access]", "Administrate", "en" );
    
/*[RAD_PAGE(AdminHome)_LABELS]*/



    // Create AdminEventHome labels 
    $labelManager->addPage( page_AdminEventHome::MULTILINGUAL_PAGE_KEY );

    $labelManager->addLabel( "[Title]", "Event Administration Home", "en" );
    $labelManager->addLabel( "[Instr]", "This is your home base for managing an event.", "en" );
    $labelManager->addLabel( "[BackLink]", "Go back to Administrator Home page", "en" );   
    
    $labelManager->addLabel( "[DownloadSummary]", "Download Event Registration Summary Data (PDF)", "en" );  
    $labelManager->addLabel( "[EmailRegistrants]", "Send E-mail to Registrants", "en" );    
    $labelManager->addLabel( "[AddEventAdmins]", "Assign Event Administrator Privileges", "en" );
    $labelManager->addLabel( "[AddCampusAdmins]", "Assign Campus-level Privileges to Administrators", "en" );
    
    $labelManager->addLabel( "[RecalculateBalances]", "Recalculate Balances Owing (must be run when volume rule triggered; takes 10-20 seconds to execute)", "en" );
    $labelManager->addLabel( "[RecalcCompleteMsg]", "Balances Owing Recalculation Completed", "en" ); 
    $labelManager->addLabel( "[RecalcNeededMsg]", "Volume Rule Triggered: Please Click 'Recalculate Balances Owing' Link", "en" ); 
    
    $labelManager->addLabel( "[EditEventDetails]", "Edit Event Details", "en" );
    $labelManager->addLabel( "[EditEventFormFields]", "Edit Event-Specific Form Fields", "en" );
    $labelManager->addLabel( "[EditEventPriceRules]", "Edit Event Price Rules", "en" );
    $labelManager->addLabel( "[EditFieldTypes]", "Edit Global Field Types", "en" ); 
    $labelManager->addLabel( "[EditPriceRuleTypes]", "Edit Global Price Rule Types", "en" );
    $labelManager->addLabel( "[EditCreditCardTypes]", "Edit Global Credit Card Types", "en" );
    $labelManager->addLabel( "[EditPrivilegeTypes]", "Edit Global Privilege Types", "en" );
    $labelManager->addLabel( "[AddSuperAdmins]", "Assign Super Administrator Privileges", "en" );
    $labelManager->addLabel( "[EditStatusTypes]", "Edit Global Registration Status Types", "en" );   
    
    $labelManager->addLabel( "[SuperAdminLevel]", "Super Admin Level Access", "en" );
    $labelManager->addLabel( "[CampusLevel]", "Campus Level Access", "en" );
    $labelManager->addLabel( "[MultiAssignNotice]", "Please note that a few registrants are legitimately assigned to 2 or more campuses. Their registration(s) will appear under each assigned campus.", "en" );
    $labelManager->addLabel( "[EventLevel]", "Event Level Access", "en" );
    $labelManager->addLabel( "[FinanceLevel]", "Finance Level Access", "en" ); 
 
    // campus registration summary table labels
    $labelManager->addLabel( "[CampusTitle]", "Campus", "en" );   
    $labelManager->addLabel( "[CampusLinkTitle]", "Admin", "en" );   
    $labelManager->addLabel( "[NumMales]", "Males", "en" );   
    $labelManager->addLabel( "[NumFemales]", "Females", "en" );   
    $labelManager->addLabel( "[CampusTotal]", "Total", "en" );   
    $labelManager->addLabel( "[Cancellations]", "Cancelled", "en" );   
    $labelManager->addLabel( "[Complete]", "Completed", "en" ); 
    $labelManager->addLabel( "[Incomplete]", "Incomplete", "en" ); 
    $labelManager->addLabel( "[CampusLink]", "Registrations", "en" );  
    $labelManager->addLabel( "[TotalsTitle]", "Total (Unique) Registrations", "en" );   
    
    $labelManager->addLabel( "[EventDataDump]", "Event Data Dump - for importing into Excel", "en" );
    $labelManager->addLabel( "[EventScholarshipList]", "Event Scholarship List - for importing into Excel", "en" );
     
  
          
/*[RAD_PAGE(AdminEventHome)_LABELS]*/



    // Create EventDetails labels 
    $labelManager->addPage( FormProcessor_EventDetails::MULTILINGUAL_PAGE_KEY );

    $labelManager->addLabel( "[Title]", "Setup Event Details", "en" );
    $labelManager->addLabel( "[Instr]", "Configure your event details here.", "en" );
    $labelManager->addLabel( "[formLabel_country_id]", "Country", "en" );
    $labelManager->addLabel( "[formLabel_ministry_id]", "Ministry", "en" );    

/*[RAD_PAGE(EventDetails)_LABELS]*/



    // Create EditFieldTypes labels 
    $labelManager->addPage( FormProcessor_EditFieldTypes::MULTILINGUAL_PAGE_KEY );

    $labelManager->addLabel( "[Title]", "Edit Field Types", "en" );
    $labelManager->addLabel( "[Instr]", "You can modify the field types by using the form below:", "en" );
/*[RAD_PAGE(EditFieldTypes)_LABELS]*/



    // Create EditPriceRuleTypes labels 
    $labelManager->addPage( FormProcessor_EditPriceRuleTypes::MULTILINGUAL_PAGE_KEY );

    $labelManager->addLabel( "[Title]", "Edit Price Rule Types", "en" );
    $labelManager->addLabel( "[Instr]", "You can modify the price rule types by using the form below:", "en" );
/*[RAD_PAGE(EditPriceRuleTypes)_LABELS]*/



    // Create EditCreditCardTypes labels 
    $labelManager->addPage( FormProcessor_EditCreditCardTypes::MULTILINGUAL_PAGE_KEY );

    $labelManager->addLabel( "[Title]", "Edit Credit Card Types", "en" );
    $labelManager->addLabel( "[Instr]", "You can modify the credit card types by using the form below:", "en" );
/*[RAD_PAGE(EditCreditCardTypes)_LABELS]*/



    // Create EditPrivilegeTypes labels 
    $labelManager->addPage( FormProcessor_EditPrivilegeTypes::MULTILINGUAL_PAGE_KEY );

    $labelManager->addLabel( "[Title]", "Edit Available Privileges", "en" );
    $labelManager->addLabel( "[Instr]", "You can add/modify the available privileges by using the form below:", "en" );
/*[RAD_PAGE(EditPrivilegeTypes)_LABELS]*/



    // Create ViewEventDetails labels 
    $labelManager->addPage( page_ViewEventDetails::MULTILINGUAL_PAGE_KEY );

    $labelManager->addLabel( "[Title]", "Event Details", "en" );
    $labelManager->addLabel( "[Instr]", "", "en" );
    
/*[RAD_PAGE(ViewEventDetails)_LABELS]*/



    // Create AddSuperAdmin labels 
    $labelManager->addPage( FormProcessor_AddSuperAdmin::MULTILINGUAL_PAGE_KEY );

    $labelManager->addLabel( "[Title]", "Assign Super Administrator Privilege", "en" );
    $labelManager->addLabel( "[Instr]", "Please select a user to promote to super admin:", "en" );
/*[RAD_PAGE(AddSuperAdmin)_LABELS]*/



    // Create AddEventAdmin labels 
    $labelManager->addPage( FormProcessor_AddEventAdmin::MULTILINGUAL_PAGE_KEY );

    $labelManager->addLabel( "[Title]", "Assign Event Administrator Privileges", "en" );
    $labelManager->addLabel( "[Instr]", "Use the form below to assign event administrator privileges to a particular user:", "en" );
/*[RAD_PAGE(AddEventAdmin)_LABELS]*/



    // Create EditFormFields labels 
    $labelManager->addPage( FormProcessor_EditFormFields::MULTILINGUAL_PAGE_KEY );

    $labelManager->addLabel( "[Title]", "Edit Additional Form Fields", "en" );
    $labelManager->addLabel( "[Instr]", "Use the form below to create, update, or delete special form fields:", "en" );
/*[RAD_PAGE(EditFormFields)_LABELS]*/



    // Create EditPriceRules labels 
    $labelManager->addPage( FormProcessor_EditPriceRules::MULTILINGUAL_PAGE_KEY );

    $labelManager->addLabel( "[Title]", "Edit Pricing Rules", "en" );
    $labelManager->addLabel( "[Instr]", "Use the form below to edit pricing rules:", "en" );
/*[RAD_PAGE(EditPriceRules)_LABELS]*/



    // Create AddCampusAdmin labels 
    $labelManager->addPage( FormProcessor_AddCampusAdmin::MULTILINGUAL_PAGE_KEY );

    $labelManager->addLabel( "[Title]", "Assign Campus-specific Administration Access", "en" );
    $labelManager->addLabel( "[Instr]", "Use the form below to assign campus-level access for a particular event administrator:", "en" );
/*[RAD_PAGE(AddCampusAdmin)_LABELS]*/



    // Create EditStatuses labels 
    $labelManager->addPage( FormProcessor_EditStatuses::MULTILINGUAL_PAGE_KEY );

    $labelManager->addLabel( "[Title]", "Edit Status Page", "en" );
    $labelManager->addLabel( "[Instr]", "Use the form below to edit which status descriptions are available to the system:", "en" );
/*[RAD_PAGE(EditStatuses)_LABELS]*/



    // Create EditCampusRegistrations labels 
    $labelManager->addPage( page_EditCampusRegistrations::MULTILINGUAL_PAGE_KEY );

    $labelManager->addLabel( "[Instr]", "Use this page to manage all the registrations for a particular campus.", "en" );
    $labelManager->addLabel( "[Title]", "Manage Campus Registrations", "en" );
    $labelManager->addLabel( "[title_balance_owing]", "$$ Owed", "en" );
    $labelManager->addLabel( "[CampusEventDataDump]", "Download Campus-specific Event Registration Summary", "en" );
    $labelManager->addLabel( "[CampusEventScholarshipList]", "Download Campus-specific Scholarship List", "en" );
    $labelManager->addLabel( "[EmailCampusRegistrants]", "Send E-mail to Registrants", "en" );
    $labelManager->addLabel( "[RegCompletedMsg]", "Offline Registration Process is: ", "en" );
    $labelManager->addLabel( "[GoBack]", "Go back to Event Administration Home page", "en" );
    
 // Create confirmation e-mail labels (WORKS FOR REG_HOME E-MAIL AS WELL)
    $labelManager->addLabel( "[Subject]", "Registration Confirmation", "en" ); 
    $labelManager->addLabel( "[ThankYou]", "Thank you for registering for", "en" );
    $labelManager->addLabel( "[ConfirmationNumber]", "Confirmation Number", "en" );
    
    $labelManager->addLabel( "[FinanceInfo]", "Financial Information", "en" );
    $labelManager->addLabel( "[eventBasePrice]", "Event Base Price:", "en" );  
    $labelManager->addLabel( "[BasePriceForYou]", "Base Price for You:", "en" );
    $labelManager->addLabel( "[ScholarshipsInfo]", "Your Event Scholarships", "en" );
    $labelManager->addLabel( "[cashReceived]", "Cash Received:", "en" );
    $labelManager->addLabel( "[cashNotReceived]", "Cash Owing:", "en" );
    $labelManager->addLabel( "[ccProcessed]", "Credit Card Amount Processed:", "en" );
    $labelManager->addLabel( "[ccNotProcessed]", "Credit Card Amount Pending:", "en" );
    $labelManager->addLabel( "[BalanceOwing]", "Balance Owing:", "en" );
                      
    $labelManager->addLabel( "[fName]", "First Name", "en" );
    $labelManager->addLabel( "[lName]", "Last Name", "en" );
    $labelManager->addLabel( "[campus]", "Campus", "en" );
    $labelManager->addLabel( "[ImpInfo]", "Important Information", "en" );
    $labelManager->addLabel( "[footer]", "Note that if you paid less than the full amount via cash or credit the balance is due upon arrival at your event.<br><br>Please direct any questions about the online registration to registration@campusforchrist.org", "en" );
  
/*[RAD_PAGE(EditCampusRegistrations)_LABELS]*/



    // Create ConfirmDeleteRegistration labels 
    $labelManager->addPage( page_ConfirmDeleteRegistration::MULTILINGUAL_PAGE_KEY );

    $labelManager->addLabel( "[Title]", "Confirm Registration Record Deletion", "en" );
    $labelManager->addLabel( "[Instr]", "Are you sure you want to delete this registration?", "en" );
/*[RAD_PAGE(ConfirmDeleteRegistration)_LABELS]*/

    // Create EditRegistrationDetails labels 
    $labelManager->addPage( page_EditRegistrationDetails::MULTILINGUAL_PAGE_KEY );

    $labelManager->addLabel( "[Title]", "Edit Registration Details", "en" );
    $labelManager->addLabel( "[Instr]", "Review and update registration details. You may only update one section at a time.", "en" );
    $labelManager->addLabel( "[RegistrationStatus]", "Current Registration Status: ", "en" );    
    $labelManager->addLabel( "[FinancialInfo]", "Financial Info", "en" );
    $labelManager->addLabel( "[PersonalInfo]", "Personal Info", "en" );
    $labelManager->addLabel( "[EditPersonInfo]", "Edit Personal Info", "en" );
    $labelManager->addLabel( "[BasePriceThisReg]", "Base Price for this Registrant", "en" );
    $labelManager->addLabel( "[TotalPaid]", "Total Paid", "en" );
    $labelManager->addLabel( "[TotalReceived]", "Total Received", "en" );
    $labelManager->addLabel( "[TotalProcessed]", "Total Processed", "en" );
    $labelManager->addLabel( "[TotalOwed]", "Total Owed", "en" );
    $labelManager->addLabel( "[Total]", "Total", "en" );
    $labelManager->addLabel( "[Scholarships]", "Scholarships", "en" );
    $labelManager->addLabel( "[CashTransactions]", "Cash Transactions", "en" );
    $labelManager->addLabel( "[CCTransactions]", "Credit Card Transactions", "en" );
    $labelManager->addLabel( "[Overpayment]", "<center>**<i>Attempted overpayment detected. Do not pay more than the event cost.</i>**</center>", "en" );    
    $labelManager->addLabel( "[BalanceOwing]", "Balance Owing", "en" );
    $labelManager->addLabel( "[RulesApplied]", "Rules / Discounts Applied to Calculate Base Price", "en" );
    $labelManager->addLabel( "[EventBasePrice]", "Event Defined Base Price", "en" );  
    $labelManager->addLabel( "[formLabel_person_local_addr]", "Local Address", "en" );     
    $labelManager->addLabel( "[formLabel_person_addr]", "Permanent Address", "en" );     
    $labelManager->addLabel( "[EventInfo]", "Event Info", "en" );
            
    $labelManager->addLabel( "[Title]", "Edit Registration Details", "en" );
    $labelManager->addLabel( "[Instr]", "Review and update registration details. You may only update one section at a time.", "en" );
/*[RAD_PAGE(EditRegistrationDetails)_LABELS]*/

    // Create EditRegistrationFieldValuesForm labels 
    $labelManager->addPage( FormProcessor_EditRegistrationFieldValuesForm::MULTILINGUAL_PAGE_KEY );

    $labelManager->addLabel( "[Title]", "Edit Form Field Values", "en" );
    $labelManager->addLabel( "[Instr]", "Use the form below to edit registration-specific form field values:", "en" );
/*[RAD_PAGE(EditRegistrationFieldValuesForm)_LABELS]*/

    // Create EditPersonalInfo labels 
    $labelManager->addPage( FormProcessor_EditMyInfo::MULTILINGUAL_PAGE_KEY );

    $labelManager->addLabel( "[Title]", "Add/Edit Personal Info", "en" );
    $labelManager->addLabel( "[Instr]", "Use the form below for adding/editing information:", "en" );
    $labelManager->addLabel( "[formLabel_person_local_phone]", "Local Phone Number", "en" );
    $labelManager->addLabel( "[formLabel_person_local_addr]", "Local Address", "en" );  
    $labelManager->addLabel( "[formLabel_person_local_city]", "Local City", "en" );
    $labelManager->addLabel( "[formLabel_person_local_pc]", "Local Postal Code", "en" );
    $labelManager->addLabel( "[formLabel_person_local_province_id]", "Local Province", "en" ); 

    // Create EditCampusRegistrations_OffflineRegBox labels 
//    $labelManager->addPage( FormProcessor_EditCampusRegistrations_OffflineRegBox::MULTILINGUAL_PAGE_KEY );

//    $labelManager->addLabel( "[Title]", "Select Registrant for Offline Registration", "en" );
//    $labelManager->addLabel( "[Instr]", "Choose a registrant from drop-list:", "en" );
/*[RAD_PAGE(EditCampusRegistrations_OffflineRegBox)_LABELS]*/


    // Create EditCampusAssignment labels 
    $labelManager->addPage( FormProcessor_EditCampusAssignment::MULTILINGUAL_PAGE_KEY );

    $labelManager->addLabel( "[Title]", "Edit Campus Assignment", "en" );
    $labelManager->addLabel( "[Instr]", "Use the form below to edit the campus assignment and status for a person:", "en" );
    $labelManager->addLabel( "[title_assignmentstatus_id]", "Status", "en" );
    
        // Create DownloadReport labels 
    $labelManager->addPage( page_DownloadReport::MULTILINGUAL_PAGE_KEY );

    $labelManager->addLabel( "[Title]", "Download Report", "en" );
    $labelManager->addLabel( "[Instr]", "Right-click on link below and click on 'Save Link As...' to download the report.<br>Left-click to view the data in your browser.", "en" );
    $labelManager->addLabel( "[DownloadEventDataDump]", "Download Event Registration Summary Report", "en" );
    $labelManager->addLabel( "[DownloadScholarshipDataDump]", "Download Event Scholarships Summary Report", "en" );
    $labelManager->addLabel( "[Continue]", "Continue", "en" );

    // Create EditFieldValues labels 
    $labelManager->addPage( FormProcessor_EditFieldValues::MULTILINGUAL_PAGE_KEY );
    $labelManager->addLabel( "[Title]", "Edit Event-Specific Form Values", "en" );
    $labelManager->addLabel( "[Instr]", "You can modify the event-specific form values below:", "en" );    

/*[RAD_PAGE(EditFieldValues)_LABELS]*/



    // Create ProcessCashTransaction labels 
    $labelManager->addPage( FormProcessor_ProcessCashTransaction::MULTILINGUAL_PAGE_KEY );
    $labelManager->addLabel( "[Title]", "Process Cash Transaction", "en" );
    $labelManager->addLabel( "[Instr]", "Use the form below to submit cash transaction data to be processed:", "en" );

/*[RAD_PAGE(ProcessCashTransaction)_LABELS]*/



    // Create ProcessCCTransacton labels 
    $labelManager->addPage( FormProcessor_ProcessCCTransaction::MULTILINGUAL_PAGE_KEY );

    $labelManager->addLabel( "[Title]", "Process Credit Card Transaction", "en" );
    $labelManager->addLabel( "[Instr]", "Use the form below to submit credit card transaction data to be processed:", "en" );
/*[RAD_PAGE(ProcessCCTransacton)_LABELS]*/


    // Create ProcessFinancialTransactions labels 
    $labelManager->addPage( page_ProcessFinancialTransactions::MULTILINGUAL_PAGE_KEY );

    $labelManager->addLabel( "[Title]", "Process Financial Transaction", "en" );
    $labelManager->addLabel( "[Instr]", "Use the forms below to pay for the event registration:", "en" );
    $labelManager->addLabel( "[TotalPaid]", "Total Paid", "en" );
    $labelManager->addLabel( "[Total]", "Total", "en" );
    $labelManager->addLabel( "[BalanceOwing]", "Balance Owing", "en" );
    $labelManager->addLabel( "[Scholarships]", "Scholarships", "en" );
    $labelManager->addLabel( "[CashTransactions]", "Cash Transactions", "en" );
    $labelManager->addLabel( "[CCTransactions]", "Credit Card Transactions", "en" );
    $labelManager->addLabel( "[Continue]", "<b>Registration Completed</b>", "en" );
    $labelManager->addLabel( "[Disabled]", "<i>Registration Disabled (Awaiting Deposit)</i> ", "en" );
    $labelManager->addLabel( "[Overpayment]", "<center>**<i>Attempted overpayment detected. Do not pay more than the event cost.</i>**</center>", "en" );    
        /*[RAD_PAGE(ProcessCCTransactonPage)_LABELS]*/



    // Create ScholarshipDisplayList labels 
    $labelManager->addPage( page_ScholarshipDisplayList::MULTILINGUAL_PAGE_KEY );

    $labelManager->addLabel( "[Title]", "Scholarships Listing", "en" );
/*[RAD_PAGE(ScholarshipDisplayList)_LABELS]*/



    // Create DisplayCCtransactionReceipt labels 
    $labelManager->addPage( page_DisplayCCtransactionReceipt::MULTILINGUAL_PAGE_KEY );

    $labelManager->addLabel( "[Title]", "Credit Card Transaction Receipt", "en" );
    $labelManager->addLabel( "[Instr]", "", "en" );
    $labelManager->addLabel( "[TransactionInfo]", "Transaction Information", "en" );
    $labelManager->addLabel( "[StatusInfo]", "General Status", "en" );
    $labelManager->addLabel( "[ReferenceInfo]", "Reference Information", "en" );    
    $labelManager->addLabel( "[Timestamp]", "Transaction Time", "en" );
    $labelManager->addLabel( "[Amount]", "Amount Paid", "en" );
    $labelManager->addLabel( "[CardHolder]", "Cardholder", "en" );
    $labelManager->addLabel( "[CardType]", "Card Type", "en" );
    $labelManager->addLabel( "[CardNum]", "Card Number", "en" );
    $labelManager->addLabel( "[CardExpiry]", "Card Expiry", "en" );
    $labelManager->addLabel( "[ConfirmNum]", "Confirmation #", "en" );
    $labelManager->addLabel( "[PersonID]", "Person #", "en" );
    $labelManager->addLabel( "[SeqNum]", "Reference #", "en" );
    $labelManager->addLabel( "[ApprovalCode]", "Approval Code", "en" );
    $labelManager->addLabel( "[Response]", "Response Code", "en" );
    $labelManager->addLabel( "[Message]", "Transaction Message", "en" );
    
    $labelManager->addLabel( "[Error]", "ERROR: Transaction Failed", "en" );
    $labelManager->addLabel( "[ResponseMsg]", "Transaction Response Message", "en" );    
    /*[RAD_PAGE(DisplayCCtransactionReceipt)_LABELS]*/



    // Create ConfirmCancelRegistration labels 
    $labelManager->addPage( page_ConfirmCancelRegistration::MULTILINGUAL_PAGE_KEY );

    $labelManager->addLabel( "[Title]", "Confirm Registration Cancellation", "en" );
    $labelManager->addLabel( "[Instr]", "Please note that event deposits are non-refundable and non-transferable.<br><br>Are you sure you want to cancel your registration?", "en" );
    $labelManager->addLabel( "[title_event_id]", "Event Name", "en" );
    $labelManager->addLabel( "[title_person_id]", "Person Name", "en" );

   
    
    /*[RAD_PAGE(ConfirmCancelRegistration)_LABELS]*/
    
    
        // Create DownloadAIARegReport labels 
    $labelManager->addPage( page_DownloadAIARegReport::MULTILINGUAL_PAGE_KEY );

    $labelManager->addLabel( "[Title]", "Download AIA Registrations Report", "en" );
    $labelManager->addLabel( "[Instr]", "Right-click on link below and click on 'Save Link As...' to download the report.<br>Left-click to view the data in your browser.", "en" );
    $labelManager->addLabel( "[DownloadEventDataDump]", "Download Event Registration Summary Report", "en" );
//     $labelManager->addLabel( "[DownloadScholarshipDataDump]", "Download Event Scholarships Summary Report", "en" );
    $labelManager->addLabel( "[Continue]", "Continue", "en" );

      /*[RAD_PAGE(DownloadAIARegReport)_LABELS]*/
  
      
              // Create page_PersonRecordCleanUp labels 
    $labelManager->addPage( page_PersonRecordCleanUp::MULTILINGUAL_PAGE_KEY );

    $labelManager->addLabel( "[Title]", "Database Purification Process", "en" );
    $labelManager->addLabel( "[Instr]", "Process reporting displayed below:", "en" );
    $labelManager->addLabel( "[GoBack]", "Back to Purification Filter Input", "en" );

      /*[RAD_PAGE(page_PersonRecordCleanUp)_LABELS]*/    
      
               // Create FormProcessor_PersonRecordCleanUpForm labels 
    $labelManager->addPage( FormProcessor_PersonRecordCleanUpForm::MULTILINGUAL_PAGE_KEY );

    $labelManager->addLabel( "[Title]", "Database Purification Process", "en" );
    $labelManager->addLabel( "[Instr]", "Enter data filters below (treated as search prefixes):<br>(defaults: first name = A, last name = A, e-mail = , timeout = 60 seconds)", "en" );
    $labelManager->addLabel( "[formLabel_script_timeout]", "Maximum Script Execution Time (seconds)", "en" );
      /*[RAD_PAGE(FormProcessor_PersonRecordCleanUpForm)_LABELS]*/        
      
               // Create FormProcessor_EmailComposer labels 
    $labelManager->addPage( FormProcessor_EmailComposer::MULTILINGUAL_PAGE_KEY );

    $labelManager->addLabel( "[Title]", "Event Registration Correspondence", "en" );
    $labelManager->addLabel( "[Instr]", "Use the form below to send an e-mail message to 1 or more registrants:", "en" );
    $labelManager->addLabel( "[ComboBoxInstr]", "Ctrl+click to select or deselect recipients:", "en" );
    $labelManager->addLabel( "[Back]", "Back to Event Home", "en" );    
    $labelManager->addLabel( "[formLabel_from_email]", "From:", "en" );
    $labelManager->addLabel( "[formLabel_to_email]", "To:", "en" );
    $labelManager->addLabel( "[formLabel_email_subject]", "Subject:", "en" );
    $labelManager->addLabel( "[formLabel_email_body]", "Message:", "en" );
    $labelManager->addLabel( "[SendMessage]", "Send Message", "en" );
      /*[RAD_PAGE(FormProcessor_PersonRecordCleanUpForm)_LABELS]*/             
      
      
/*[RAD_PAGE_LABEL]*/

     // load the labels for the side bar

    $labelManager->addPage( obj_RegProcessSideBar::MULTILINGUAL_PAGE_KEY );
    $labelManager->addLabel( "[Heading]", "Event Registration", "en" );
    $labelManager->addLabel( "[Notice]", "Note: You MUST click <u>".$labelManager->getLabel('[backToRegList]')."</u> at step 4 when you are done registering.", "en" );
    $labelManager->addLabel( "[RegCancel]", "Cancel Registration", "en" );	  
    $labelManager->addLabel( "[editMyInfo]", "Step 1: Personal Info", "en" );
    $labelManager->addLabel( "[editCampusInfo]", "Step 2: Campus-related Info", "en" );
    $labelManager->addLabel( "[editFieldValues]", "Step 3: Event-specific Form Values", "en" );
    $labelManager->addLabel( "[processFinances]", "Step 4: Process Finances", "en" );
    $labelManager->addLabel( "[backToRegList]", "<br><b>Registration Completed</b>", "en");	//Back to Campus Registrations", "en" );
    $labelManager->addLabel( "[backToEventList]", "<br><b>Registration Completed</b>", "en" );
    
//<br><b>Registration Completed</b>

    $labelManager->addPage( page_NotAuthorized::MULTILINGUAL_PAGE_KEY );
    $labelManager->addLabel( "[Title]", "Unauthorized Access Detected", "en" );
    $labelManager->addLabel( "[Instr]", "You do not have the required privileges for accessing this page.<br><br>You can use your browser's 'Back' button or use the menus to navigate back.", "en" );
    
    
} else {

    echo 'Skipping Labels ... <br>';
    
} // end if !skipLabels


?>