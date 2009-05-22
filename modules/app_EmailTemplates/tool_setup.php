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

require ( 'app_EmailTemplates.php' );
require ( 'incl_EmailTemplates.php');


/*
 *  Directory Setup
 *
 *  Setup any specific directories used by this module.
 */
/*
if( !file_exists( moduleEmailTemplates::DEF_DIR_DATA ) ) { 
    mkdir( moduleEmailTemplates::DEF_DIR_DATA);
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


    $module->loadByKey( moduleEmailTemplates::MODULE_KEY );
    $module->setKey( moduleEmailTemplates::MODULE_KEY );
    $module->setPath( 'modules/app_EmailTemplates/' );
    $module->setApplicationFile( 'app_EmailTemplates.php' );
    $module->setIncludeFile( 'incl_EmailTemplates.php' );
    $module->setName( 'moduleEmailTemplates' );
    $module->setParameters( '' );
    
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
$skipTables = isset($_REQUEST['skipTables']);

// if NOT then reset the tables...
if ( !$skipTables ) {


    /*
     * EmailTemplate Table
     *
     * row manager for templates
     *
     * template_id [INTEGER]  The primary key for templates
     * app_id [INTEGER]  Describes which app this template belongs to
     * template_key [STRING]  key for template
     * template_isactive [BOOL]  is the template active or not?
     * label_key [STRING]  key for the label
     */
    $EmailTemplate = new RowManager_EmailTemplateManager();

    $EmailTemplate->dropTable();
    $EmailTemplate->createTable();



/*[RAD_DAOBJ_TABLE]*/
$EmailTemplate->setAppID('moduleEmailTemplates');
$EmailTemplate->setTemplateKey(ADJUSTMENT_RESPONSE_TEMPLATE);
$EmailTemplate->setIsActive(1);
$EmailTemplate->setLabelKey('[adjustment_response]');
$EmailTemplate->createNewEntry();
$EmailTemplate->clearValues();

$EmailTemplate->setAppID('moduleEmailTemplates');
$EmailTemplate->setTemplateKey(UPDATE_RESPONSE_TEMPLATE);
$EmailTemplate->setIsActive(1);
$EmailTemplate->setLabelKey('[update_response]');
$EmailTemplate->createNewEntry();
$EmailTemplate->clearValues();

$EmailTemplate->setAppID('moduleEmailTemplates');
$EmailTemplate->setTemplateKey(UPDATE_REQUEST_TEMPLATE);
$EmailTemplate->setIsActive(1);
$EmailTemplate->setLabelKey('[update_request]');
$EmailTemplate->createNewEntry();
$EmailTemplate->clearValues();

$EmailTemplate->setAppID('moduleEmailTemplates');
$EmailTemplate->setTemplateKey(ADJUSTMENT_REQUEST_TEMPLATE);
$EmailTemplate->setIsActive(1);
$EmailTemplate->setLabelKey('[adjustment_request]');
$EmailTemplate->createNewEntry();
$EmailTemplate->clearValues();


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
    $labelManager->addSeries( moduleEmailTemplates::MULTILINGUAL_SERIES_KEY );
    
    
    
    // Create General Field labels for moduleEmailTemplates 
    $labelManager->addPage( moduleEmailTemplates::MULTILINGUAL_PAGE_FIELDS );

    
    //
    // EmailTemplate table
    //
    $labelManager->addLabel( "[title_template_id]", "TemplateID", "en" );
    $labelManager->addLabel( "[title_app_id]", "App", "en" );
    $labelManager->addLabel( "[title_template_key]", "Key", "en" );
    $labelManager->addLabel( "[title_template_isactive]", "IsActive", "en" );
    $labelManager->addLabel( "[title_label_key]", "LabelKey", "en" );


/*[RAD_FIELDS_LABEL]*/
    
    
    
    
    // Create TemplateAdminPage labels 
    $labelManager->addPage( page_TemplateAdminPage::MULTILINGUAL_PAGE_KEY );

/*[RAD_PAGE(TemplateAdminPage)_LABELS]*/



    // Create EditTemplate labels 
    $labelManager->addPage( FormProcessor_EditTemplate::MULTILINGUAL_PAGE_KEY );
    
/*[RAD_PAGE(EditTemplate)_LABELS]*/

    $labelManager->addLabel( "[Title]", "Template Editor", "en");
    $labelManager->addLabel( "[Instr]", "This page allows you to modify the template of the emails that get sent by the NSS Payroll system.  The words in brackets are variables that change depending on the person.", "en");
    
    
    
    //$labelManager->addSeries($EmailTemplate->getSeriesKey());
    $labelManager->addPage( $EmailTemplate->getXMLNodeName());

   
    //$languageManager = new RowManager_LanguageManager();
    //$languageList = $languageManager->getListIterator();
    $languageList = new LanguageList();
    $languageList->setFirst();
   
    while ($language = $languageList->getNext())
    {


        $languageKey = $language->getCode();
echo 'processing ['.$languageKey.']<br>';

         $labelManager->addLabel( "[adjustment_response]", "[".$languageKey."]NSS: Salary Adjustment Response: [adjustmentreason]

Dear [name],

Your request for a salary adjustment of $[amount] has been [status].



Reason: [reason]


Adjustment Description: [adjustmentdescription]


Thanks,

[admin]

NSS Team", $languageKey);
 


        $labelManager->addLabel( "[update_response]", "[".$languageKey."]Salary Update Response

Dear [name],

Your request for a salary adjustment has been [status].


[reason]


Details:



Consumables: [salarycalcreq_field1]  	 

Housing and Utilities: [salarycalcreq_field2] 	

Preventative Care Costs: [salarycalcreq_field3]

On-going Responsibilities: [salarycalcreq_field4]

Miscellaneous Other: [salarycalcreq_field5]

Benefits: [salarycalcreq_field6]

Taxes: [salarycalcreq_field7]



Total: [total]





Thank you,

[admin]

NSS Team", $languageKey);
     
        $labelManager->addLabel( "[update_request]", "[".$languageKey."]Request For Salary Update Submitted

Dear [name],

Your request for a salary update has been submitted.



Details:



Consumables: [salarycalcreq_field1]  	 

Housing and Utilities: [salarycalcreq_field2] 	

Preventative Care Costs: [salarycalcreq_field3]

On-going Responsibilities: [salarycalcreq_field4]

Miscellaneous Other: [salarycalcreq_field5]

Benefits: [salarycalcreq_field6]

Taxes: [salarycalcreq_field7]



Total: [total]





Thank you,

[admin]

NSS Team", $languageKey);
     
        $labelManager->addLabel( "[adjustment_request]", "[".$languageKey."]Request For Salary Adjustment: [adjustmentreason] Submitted

Dear [name],

Your request for a salary adjustment of $[amount] has been submitted.


Description: [adjustmentdescription]


Thank you,

[admin]

NSS Team", $languageKey);

    }
/*[RAD_PAGE_LABEL]*/
    
    
} else {

    echo 'Skipping Labels ... <br>';
    
} // end if !skipLabels


?>