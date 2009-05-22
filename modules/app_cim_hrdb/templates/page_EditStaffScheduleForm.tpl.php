<?
/*
 * page_editStaffScheduleForm.tpl.php
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
<p><span class="heading"><? echo $templateTools->getPageLabel('[Title]');
if ((isset($subheading))&&($subheading != ''))
{
	echo '<br>( '.$subheading.' )';
}
?></span></p>
<p><span class="text">
<?
	echo $templateTools->getPageLabel('[Instr]');

	if (isset($top_instructions))
	{
		echo '<br><br>'.$top_instructions; 
	}
?>
</span></p>
<?

}// end display heading



 // display Continue Link if provided
 $continueLabel = '';
 if ( isset($linkValues['cont']) ) {		//<span class="text" align="right"></span>
     $continueLabel = '<table align="right"><tr><td align=right><a href="'.$linkValues['cont'].'"><b>'.$linkLabels['cont'].'</b></a>';
     $continueLabel .= '</td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td></tr></table><br>';
     echo $continueLabel;
 }

// Show form approval status
echo '<div align="center">';
echo '<table><tr><td align="left"><b>Status:</b> '.$form_approval_status.'</td></tr>';
echo "<tr><td align='left'><b>Director's Approval Notes:</b><br>".$form_approval_notes."</td></tr></table>"; 
echo '</div>';
 
// Indicate whether form information submitted
if ( isset( $form_status_msg ) )
{
    echo '<br><div align="center" class="notice">'.$form_status_msg.'</div>';
}

?>

<!-- Data List Headings -->
<?  $textStyle = 'text'; // set style for basic table data 
	 $boldStyle = 'bold';	// set style for important table data
?>

<?
	if (isset($basicStaffForm))
	{
?>		
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
?>
	<div align="center">
		<? echo $basicStaffForm; ?>
	</div>
<?		
	}
	
	
// indicate that the page has two forms
if (isset($formsNotice)) 
{
	echo '<div class="notice" align="center">'.$formsNotice.'</div>';
	echo '<br>';
}

// Give basic bottom form instructions
if (isset($bottom_instructions))
{
	echo '<div class="text">'.$bottom_instructions.'</div>';
}
?>



 <? if (isset($scheduledActivityForm))
 	 {
 ?>
 	 <div align="center">
 	 	<? echo $scheduledActivityForm; 
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
		</table> --> */
		?>
	</div>	
<?
	}
?>

<br>
<?
    //echo '<span class="bold"><a href="'.$linkValues['cont'].'">'.$linkLabels['cont'].'</a></span>';
?>


    
    
