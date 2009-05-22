<?
/*
 * regPersonDetails.tpl.php
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
<p><span class="heading"><? echo $templateTools->getPageLabel('[Title]'); ?></span></p>
<p><span class="text"><? echo $templateTools->getPageLabel('[Instr]'); ?></span></p>
<? 

}// end display heading


// indicate the deposit amount required for the event registration
if (isset($minPayNotice)) 
{
	echo '<p><span class="notice">'.$minPayNotice.'</span></p>';
}

// indicate the maximum amount required for the event registration
if (isset($maxPayNotice)) 
{
	echo '<p><span class="text">'.$maxPayNotice.'</span></p>';
}	

 // display Continue Link if provided
 $continueLabel = '';
 if ( isset($linkValues['cont']) ) {		//<span class="text" align="right"></span>
     $continueLabel = '<table align="right"><tr><td align=right><a href="'.$linkValues['cont'].'"><b>'.$linkLabels['cont'].'</b></a>';
     $continueLabel .= '</td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td></tr></table><br>';
     echo $continueLabel;
 }

// Any other special instructions etc...
if ( isset( $specialInfo ) )
{
    echo $specialInfo;
}

?>

<!-- Data List Headings -->
<?  $textStyle = 'text'; // set style for basic table data 
	 $boldStyle = 'bold';	// set style for important table data
?>

<?
	if (isset($cashTransAdminBox))
	{
?>		
		<table width="100%" border="0">
		<tr>   
		   
			<td colspan="3" width="75%" valign="top">	
				<table width="75%" border="0">
		          <tr><td colspan = "4"class="<? echo $boldStyle?>"><? echo $templateTools->getPageLabel('[CashTransactions]'); ?></td></tr>
		          <tr><td class="notice" colspan="1">Please enter the name of the staff or student leader you will pay your deposit to.</td></tr>          
					 <tr><td colspan = "4"><? echo $cashTransAdminBox; 
					 ?></td></tr>
		          <tr><td class="<? echo $textStyle?>" colspan="1">&nbsp;</td></tr>
		 		</table>
		 	</td>
		
		</tr>
		</table>
<?		
	}
?>

<table width="100%" border = "0">
<tr>              
       
       
  <td colspan="3" width="100%" valign="top">	   
    <table width="40%" border="0">               
       <tr><td class="<? echo $boldStyle?>" colspan="1"><? echo $templateTools->getPageLabel('[CCTransactions]'); ?></td></tr>
       <tr><td class="notice" colspan="1">Please enter your credit card number as one number sequence with no spaces, dashes, or other symbols.<br>
       												Do <b>NOT</b> refresh the page in the rare case that the page load is slow after clicking 'ADD'.</td></tr>
       <? if (isset($attemptedOverpayment))
       	 {
	    ?>
       <tr><td class="notice" colspan="1"><? echo $templateTools->getPageLabel('[Overpayment]'); ?></td></tr>	
       <?
 	 		 }
 	 	 ?>											
       <tr><td><? echo $ccTransAdminBox; 
       ?></td></tr>         

    </table>
 </td>
</tr>
</table>	

<table width="100%" border="0">

<tr>   
   
	<td colspan="3" width="75%" valign="top">	
		<table width="75%" border="0">
			<?	// TODO: remove this temporary message
			$tempMsg = '<b>If you raised funds from a summer project to cover this event, '.
'please indicate that you will pay cash to a staff and your scholarship will be applied before the event starts.</b>';
			?>
             
          <tr><td colspan = "4"class="<? echo $boldStyle?>"><? echo $templateTools->getPageLabel('[Scholarships]'); ?></td></tr>
       	 <tr><td class="notice" colspan="1"><? echo $tempMsg; ?></td></tr>          
			 <tr><td colspan = "4"><? echo $scholarshipsList; 
			 ?></td></tr>
          <tr><td class="<? echo $textStyle?>" colspan="1">&nbsp;</td></tr>
 		</table>
 	</td>

</tr>
</table>

<table width="100%" border="0">
    <tr colspan="10"><td class="<? echo $boldStyle?>" ><? echo $templateTools->getPageLabel('[Total]'); ?>
    </td>
    <td width="*">&nbsp;</td>
<!--	</tr>
    <tr><td class="<? echo $textStyle?>" colspan="3">&nbsp;</td></tr> 
    <tr>  --><td class="<? echo $boldStyle?>" ><? echo $templateTools->getPageLabel('[TotalPaid]'); ?>
    </td><td width="*">&nbsp;</td> <!-- </tr> 			
    <tr><td class="<? echo $textStyle?>" colspan="1">&nbsp;</td></tr>
    <tr> --> <td class="<? echo $boldStyle?>" ><? echo $templateTools->getPageLabel('[BalanceOwing]'); ?>
    </td><td width="*">&nbsp;</td>
    </tr> 
    <tr>
		<td>
		    <? 
		    //echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
		     echo $basePriceForThisGuy;?></td>
		    <td width="*">&nbsp;</td>
		<td>
		    <? //echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'; 
		    	 echo $scholarshipTotal+$cashTotal+$ccTotal;  
		    ?></td><td width="*">&nbsp;</td>
		<td>
		    <? //echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'; 
		    	 echo $basePriceForThisGuy-$scholarshipTotal-$cashTotal-$ccTotal;  
		    ?></td><td width="*">&nbsp;</td>   
	</tr>         
</table>

<br>

<hr>
<?
    echo '<span class="bold"><a href="'.$linkValues['cont'].'">'.$linkLabels['cont'].'</a></span>';
?>


    
    
