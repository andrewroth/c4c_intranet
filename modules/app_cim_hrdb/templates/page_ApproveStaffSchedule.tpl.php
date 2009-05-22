<?
/*
 * page_approveStaffSchedule.tpl.php
 *
 * This template displays a Single Entry form.  This type of form displays
 * a row for each field is is gathering data for. Each row has a label, and
 * a form item.
 *
 * Required Template Variables:
 *  $formAction :   The action for the submitted form.
 *  $dataFieldList :    Array of fields processed by this form.
 *  $formFieldType :    Array of field Types for each of the given fields
 *
 *
 *  $eventName - textual description of the event being signed up for
 *  $form - an FormHelper object that contains all the necessary data
 */

// First load the common Template Tools object
// This object handles the common display of our form items and
// text formmatting tools.
$fileName = 'objects/TemplateTools.php';
$path = Page::findPathExtension( $fileName );
require_once( $path.$fileName);

$templateTools = new TemplateTools();


// Initialize the row color
$rowColor = "";
$templateTools->setHeadingBGColor( $rowColor );


// load the page labels
$templateTools->loadPageLabels( $pageLabels );



// This template displays a Title & Instr field by default.  If you don't 
// want them displayed, then you send ($disableHeading = true) to the 
// template.
// Now check to see if the disableHeading param has been sent
if (!isset( $disableHeading ) ) {

    // if not default it to false
    $disableHeading = false;
}

// if we are to display the heading ...
if (!$disableHeading) {

?>
<p><span class="heading"><? //echo $templateTools->getPageLabel('[Title]');
if ((isset($heading))&&($heading != ''))
{
	echo $heading;
}
if ((isset($subheading))&&($subheading != ''))
{
	echo '<br>( '.$subheading.' )';
}
?></span></p>
<p><span class="text"><? echo $templateTools->getPageLabel('[Instr]'); ?></span>
<? 

}// end display heading



 // display Continue Link if provided
 $continueLabel = '';
 if ( isset($linkValues['cont']) ) {		//<span class="text" align="right"></span>
     $continueLabel = '<table align="right"><tr><td align=right><a href="'.$linkValues['cont'].'"><b>'.$linkLabels['cont'].'</b></a>';
     $continueLabel .= '</td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td></tr></table><br>';
     echo $continueLabel;
     echo '<br>';   
 }
 echo '</p>';

// Show form approval status
// echo '<div align="center" class="bold">Status: '.$form_approval_msg.'</div>'; 
 
// Indicate whether form information submitted
if ( isset( $form_status_msg ) )
{
    echo '<br><div align="center" class="notice">'.$form_status_msg.'</div>';
}

?>
	<table width="100%" border="0">
<form name="Form" id="Form" method="post" action="<?=$approvalFormAction;?>">

	<!-- Data List Headings -->
	<?  $textStyle = 'text'; // set style for basic table data 
		 $boldStyle = 'bold';	// set style for important table data
	?>
	
	
	 <tr valign="top" <?= $rowColor;?> >
	 	<td colspan="1" class="<? echo $boldStyle?>" >
	 	<? echo $templateTools->getPageLabel('[ApprovalStatus]'); ?></td>
	 	<td colspan="3" class="<? echo $textStyle?>" > 	
			<input type=checkbox name="staffschedule_approved" <? if (isset($is_approved)) { echo $is_approved; } ?> 
			> 				
		</td>
	
		<td colspan="1" class="<? echo $textStyle?>" >
			<input type="hidden" name="Process" value="T" >
		   <input type="hidden" name="form_name" value="approvalForm" >
			<input name="statusSubmit" type="submit" value="<?=$approvalButtonText; ?>" />
		</td>
		
	 </tr>
	 <tr>
	 	<td colspan="1" class="<? echo $boldStyle?>" >
	 	<? echo $templateTools->getPageLabel('[ApprovalNotes]'); ?></td>	 
	 	<td colspan="4" class="<? echo $boldStyle?>" >
	 		<textarea name="staffschedule_approvalnotes" rows="3" cols="50"><? if (isset($approval_notes)) { echo $approval_notes; } ?>
	 		</textarea>
	 	</td>
	 </tr>

</form>
	</table>
	
<?
	echo '<p><div = '.$textStyle.'>';
	if (isset($approved_by))
	{
		echo '<b> '.$templateTools->getPageLabel('[Director]').'</b>: '.$approved_by.'<br>';
	}		
	if (isset($last_change))
	{
		echo '<b> '.$templateTools->getPageLabel('[ChangeTime]').'</b>: '.$last_change.'<br>';
	}
	echo '</div></p>';
?>


<!-- Data List Headings -->
<?  $textStyle = 'text'; // set style for basic table data 
	 $boldStyle = 'bold';	// set style for important table data
?>

<?
	if (isset($basicStaffForm))
	{
?>		
	<div align="center">
<?
/*
<!--		<table width="100%" border="0">
		<tr>   
		   
			<td colspan="1" width="75%" valign="top">	-->
				<table width="75%" border="0">
		          <!-- <tr><td colspan = "4"class="<? echo $boldStyle?>"><? echo $templateTools->getPageLabel('[CashTransactions]'); ?></td></tr> -->
					 <tr><td colspan = "4"> <? echo $basicStaffForm; 
					 ?></td></tr>
		          <tr><td class="<? echo $textStyle?>" colspan="1">&nbsp;</td></tr>
		 		</table>
<!--		 	</td>
		
		</tr>
		</table> -->
*/
		echo $basicStaffForm;	
?>
	</div>
<?		
	}
	
	
// indicate that the page has two forms
if (isset($formsNotice)) 
{
	echo '<div class="notice" align="center">'.$formsNotice.'</div>';
	echo '<br>';
}
?>



 <? if (isset($scheduledActivityForm))
 	 {
 ?>
 	 <div align="center">
<?
/*
<!--		<table width="100%" border = "0">
		<tr>              
		       
		       
		  <td colspan="3" width="100%" valign="top">	  --> 
		    <table width="40%" border="0">               
		      <!-- <tr><td class="<? echo $boldStyle?>" colspan="1"><? echo $templateTools->getPageLabel('[CCTransactions]'); ?></td></tr> -->
										
		       <tr><td><? echo $scheduledActivityForm; ?>
		       </td></tr>  
		
		    </table>
<!--		 </td>
		</tr>
		</table> -->
*/
		echo $scheduledActivityForm;
?>
	</div>	
<?
	}
?>

<br>
<?
    //echo '<span class="bold"><a href="'.$linkValues['cont'].'">'.$linkLabels['cont'].'</a></span>';
?>


    
    
