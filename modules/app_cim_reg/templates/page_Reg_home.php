<?
/*
 * page_Reg_home.php
 *
 * This is a generic template for the page_Reg_home.php page.
 *
 * Required Template Variables:
 *  $pageLabels :   The values of the labels to display on the page.
 *
 *  $eventTable:  An html table of the current events a student can sign-up for.
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

<?
/*
<p><span class="heading"><? echo $templateTools->getPageLabel('[Title]'); ?></span></p>
<p><span class="text"><? echo $templateTools->getPageLabel('[Instr]'); ?></span></p>
*/

?>


<table border="0">

<?
/*
   NEWS SECTIONS
   <tr><td class="bold">News</td></tr>
   <tr><td>News to appear here.</td></tr>
   <tr><td>&nbsp;</td></tr>
*/
?>



    <? if (isset($regCompleted))
    	 {
	    	 echo '<tr><td><b>'.$templateTools->getPageLabel('[RegComplete]').$regStatus.'</b></td></tr>';	 
	    	 echo '<tr><td>&nbsp;</td></tr>';   	 
 			 echo '<tr><td class="notice"><b>'.$regMessage.'</b></td></tr>';
 			 echo '<tr><td>&nbsp;</td></tr>';
 		 }
 	?>   
   
   <tr><td class="bold"><? echo $templateTools->getPageLabel('[Events]'); ?></td></tr>
   <?
   	if (isset($notice))
   	{
	?>   	
   <tr><td class="notice">
   <? echo $notice ?>
   </td></tr>
   <?
		}
	?>
   <tr><td><? echo $eventTable; ?></td></tr>

</table>

<br/>
<br/>
<?
   if ( $isAdmin )
   {
?>
<a href="<? echo $adminLink; ?>"><? echo $templateTools->getPageLabel('[Admins]'); ?></a>
<?
	}
?>

