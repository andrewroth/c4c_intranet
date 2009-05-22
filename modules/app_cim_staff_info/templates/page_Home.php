<?
/*
 * page_Home.php
 *
 * This is a generic template for the page_Home.php page.
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

				<p class="bold">Institute of Biblical Studies</p>
				<p class="text">Click <a href="http://ibs.campuscrusadeforchrist.com/index.html" class="text">here</a> for more information relating to IBS.</p>
