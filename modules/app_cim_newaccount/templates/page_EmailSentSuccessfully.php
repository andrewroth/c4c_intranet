<?
/*
 * page_EmailSentSuccessfully.php
 *
 * This is a generic template for the page_EmailSentSuccessfully.php page.
 *
 * Required Template Variables:
 *  $pageLabels :   The values of the labels to display on the page.
 *
 *  $emailSentSuccess : If the reset succeeded or failed;
 *  $emailAddress : The attempted email address;
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

<p><h1><? echo $templateTools->getPageLabel('[Title]'); ?></h1></p>
<p><? echo $templateTools->getPageLabel('[Instr]'); ?></p>

<?

if ( $emailSentSuccess == true )
{
   echo "<b>".$templateTools->getPageLabel('[SentToSuccess]') . "&nbsp;"  . $emailAddress."</b>";
}
else
{
   echo "<b>".$templateTools->getPageLabel('[NoSuccess]') . "&nbsp;" .$emailAddress."</b>";
   echo "<br/><br/>";
   echo $templateTools->getPageLabel('[ContactTechSupport]');
}

?>