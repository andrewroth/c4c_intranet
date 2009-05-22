<?
/*
 * page_CreatedSuccessfully..php
 *
 * This is a generic template for the page_CreatedSuccessfully..php page.
 *
 * Required Template Variables:
 *  $pageLabels :   The values of the labels to display on the page.
 *
 *  $urlRedirect : The address of where the page should redirect to.
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
<head>
<script language="JavaScript"><!--
setTimeout("top.location.href = '<?=$urlRedirect;?>'",1000);
//--></script>
</head>
<p><h1><? echo $templateTools->getPageLabel('[Title]'); ?></h1></p>
<p><? echo $templateTools->getPageLabel('[Instr]'); ?></p>
<p><a href="<?=$urlRedirect;?>"><? echo $templateTools->getPageLabel('[LoginNow]'); ?></a></p>

