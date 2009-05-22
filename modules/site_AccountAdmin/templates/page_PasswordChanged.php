<?
/*
 * page_HrdbHome.php
 *
 * This is a generic template for the page_HrdbHome.php page.
 *
 * Required Template Variables:
 *  $pageLabels :   The values of the labels to display on the page.
 *
 */
 
// First load the common Template Tools object
// This object handles the common display of our form items and
// text formmatting tools.
$fileName = 'objects/TemplateTools.php';
$path = Page::findPathExtension( $fileName );
require_once( $path.$fileName);

$templateTools = new TemplateTools();


// load the page labels
$templateTools->loadPageLabels( $pageLabels );

?>
<p><span class="heading"><? echo $templateTools->getPageLabel('[Title]'); ?></span></p>
<p><span class="text"><? echo $templateTools->getPageLabel('[Instr]'); ?></span></p>
<!--
<p><span class="heading">Password Changed</span></p>
<p class="text">The password has been changed successfully.</p>
-->
<hr>
<div class="text" align="right"><?
    
    // display Continue Link if provided
    $continueLabel = '';
    if ( isset($linkValues['cont']) ) {
        $continueLabel = '<a href="'.$linkValues['cont'].'">'.$linkLabels['cont'].'</a>';
    }
    echo $continueLabel;
  
?></div>