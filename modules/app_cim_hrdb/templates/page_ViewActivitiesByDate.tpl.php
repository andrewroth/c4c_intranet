<?
/*
 * page_ViewActivitiesByDate.tpl.php
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
</span>
<?

    // If the download CSV link Exists ... add it here.
    if ( isset($downloadLink[ 'DownloadActivitiesDateCSV' ]) ) {
        echo '<div align="right" class="text" ><a href="'.$downloadLink[ 'DownloadActivitiesDateCSV' ].'">'.$linkLabels['DownloadActivitiesDateCSV'].'</a></div>';
    }  
 echo '</p>';


}// end display heading



 // display Continue Link if provided
 $continueLabel = '';
 if ( isset($linkValues['cont']) ) {		//<span class="text" align="right"></span>
     $continueLabel = '<table align="right"><tr><td align=right><a href="'.$linkValues['cont'].'"><b>'.$linkLabels['cont'].'</b></a>';
     $continueLabel .= '</td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td></tr></table><br>';
     echo $continueLabel;
 }

 
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

<table width="100%" border="0">
<div id="overDiv" style="position:absolute; visibility:hidden; z-index:1000;"></div>
	<form name="sample" method="post" action="<?=$daterangeFormAction;?>">
		 <tr valign="top" <?= $rowColor;?> >
		 	<td colspan="1" class="<? echo $textStyle?>" >
			Beginning date:
			</td>
			<td colspan="1" class="<? echo $textStyle?>" >
			 <input type="text" name="<?=$start_date;?>" size="20">  
			<!-- ggPosX and ggPosY not set, so popup will autolocate to the right of the graphic -->
			<a href="javascript:show_calendar('sample.<?=$start_date;?>');" onMouseOver="window.status='Date Picker'; overlib('Click here to choose a date from a one month pop-up calendar.'); return true;" onMouseOut="window.status=''; nd(); return true;"><img src="Images/cal.gif" width=24 height=22 border=0></a>
			</td>
		</tr>
		<tr valign="top" <?= $rowColor;?> >
			<td colspan="1" class="<? echo $textStyle?>" >
			Ending date:
			</td>
			<td colspan="1" class="<? echo $textStyle?>" >
			<input type="text" name="<?=$end_date;?>"	size="20">  
			<!-- ggPosX and ggPosY are set, so popup goes where you tell it -->
	<!--		<a href="javascript:ggPosX=5;ggPosY=200;show_yearly_calendar('sample.T2');" onMouseOver="window.status='Date Picker'; overlib('Click here to choose a date from a full year pop-up calendar.'); return true;" onMouseOut="window.status=''; nd(); return true;"><img src="Images/cal.gif" width=24 height=22 border=0></a> -->
			<a href="javascript:show_calendar('sample.<?=$end_date;?>');" onMouseOver="window.status='Date Picker'; overlib('Click here to choose a date from a one month pop-up calendar.'); return true;" onMouseOut="window.status=''; nd(); return true;"><img src="Images/cal.gif" width=24 height=22 border=0></a>
			</td>
		</tr>
		<tr>
			<td colspan="1" class="<? echo $textStyle?>" >
			<input type="hidden" name="Process" value="T" >
		   <input type="hidden" name="form_name" value="dateRangeForm" >
		   <input type="submit" value="<?=$submitButtonText; ?>" name="dateRangeSubmit"><input type="reset" value="Reset" name="resetForm">
		   </td>
		</tr>
	</form>
</table>



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


    
    
