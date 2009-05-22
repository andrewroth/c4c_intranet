<?
/*
 * DisplayRegistrationConfirmation.tpl.php
 *
 * This template displays a summary of a CC transaction or an error message if the transaction failed
 *
 * Required Template Variables:
 *  $resultMsg :   Message indicating APPROVED or DECLINED status
 *  $eventName :    textual description of the event being signed up for
 *  $campusStatus:	the status of the registrant w.r.t. the campus he/she is being registered under
 *  $campusName : 	name of the campus associated with registrant
 *  $registrantName :    Full name of registrant
 *  $regStatus:	registration process status
 *
 *  $amount: the dollar amount that was paid via credit card
 *  $timestamp: the time of the transaction
 *  $cardName: card-holder's name
 *  $cardType: credit card type
 *  $cardNum: the credit card number (masked)
 *  $cardDate: the expiry date on the card
 * 
 *  $confirmNum: the reg. confirm. #
 *  $personID: the unique ID of the registrant
 *  $seqNum: the Moneris-returned unique receipt #
 *  $approvalCode:  some sort of code indicating approval
 *  $response: a code indicating trans. status (2 ranges and NULL used for APPROVED, DECLINED, INCOMPLETE)
 *  $message: natural language description of transaction result
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

 // display Continue Link if provided
 $continueLabel = '';
 if ( isset($linkValues['cont']) ) {
     $continueLabel = '<span class="text" align="right"><a href="'.$linkValues['cont'].'">'.$linkLabels['cont'].'</a></span>';
 }
 
 // only show error message if transaction was not approved
 if (isset($error))
 {
	 // show error message
	 echo '<b>'.$templateTools->getPageLabel('[Error]').'</b>';
	 echo '<br><br>';
	 echo '<b>'.$templateTools->getPageLabel('[ResponseMsg]').':</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
	 echo $message;
 }
 else		// display receipt data
 {

	// Result messages to be shown
	if ( isset( $resultMsg ) )
	{
	    echo 'Credit card transaction status: '.$resultMsg;
	}
	
	?>
	<hr>
	
	<table width="100%" border="0">
	<!-- Data List Headings -->
	<?  $textStyle = 'text'; // set style for basic table data 
		 $boldStyle = 'bold';	// set style for important table data
	?>
	
	
	 <tr valign="top" <?= $rowColor;?> >
	 	<td colspan="4" class="<? echo $boldStyle?>" >
	 	<? echo $templateTools->getPageLabel('[TransactionInfo]'); ?></td>
	 </tr>
	 <tr>
	    <td colspan="1" valign="top">
	      <table width="100%" border="0">          
	          <tr><td class="<? echo $textStyle?>" ><? echo $templateTools->getPageLabel('[Timestamp]'); ?>
	          </td><td>
	          <? 
	          //echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
	           echo $timestamp;?></td>
	          <td width="*">&nbsp;</td>
				</tr>
				
	          <tr><td class="<? echo $textStyle?>" colspan="3">&nbsp;</td></tr>
	          <tr><td class="<? echo $textStyle?>" ><? echo $templateTools->getPageLabel('[NumTickets]'); ?>
	          </td><td>
			    <? //echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'; 
			    	 echo $numTickets;  
			    ?></td><td width="*">&nbsp;</td></tr> 				
				
	          <tr><td class="<? echo $textStyle?>" colspan="3">&nbsp;</td></tr>
	          <tr><td class="<? echo $textStyle?>" ><? echo $templateTools->getPageLabel('[CardHolder]'); ?>
	          </td><td>
			    <? //echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'; 
			    	 echo $cardName;  
			    ?></td><td width="*">&nbsp;</td></tr> 			
	          <tr><td class="<? echo $textStyle?>" colspan="1">&nbsp;</td></tr>
	          <tr><td class="<? echo $textStyle?>" ><? echo $templateTools->getPageLabel('[CardNum]'); ?>
	          </td><td>
			    <? //echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'; 
			    	 echo $cardNum;  
			    ?></td><td width="*">&nbsp;</td>
			    </tr>  
			    <tr><td class="<? echo $textStyle?>" colspan="3">&nbsp;</td></tr>
			</table>
	    </td>         
										
	<!--   <td width="20">&nbsp;</td> -->
		<td colspan="2" valign="top">	
	      <table width="100%" border="0">
	          <tr>
	          <td width="*">&nbsp;</td>
	          <td width="*">&nbsp;</td>
	          <td width="*">&nbsp;</td></tr>	      
	          <tr>
	          <td width="*">&nbsp;</td>
	          <td width="*">&nbsp;</td>
	          <td width="*">&nbsp;</td></tr>	
	          	      
	          <tr><td class="<? echo $textStyle?>" ><? echo $templateTools->getPageLabel('[Amount]'); //echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
	          ?>
	          </td>
	          <td class="<? echo $textStyle?>" ><? 
	          echo $amount;?></td><td width="*">&nbsp;</td></tr>
	          <tr><td class="<? echo $textStyle?>" colspan="1">&nbsp;</td></tr>
	          <?
	          echo '<tr><td class="'.$textStyle.'">'. $templateTools->getPageLabel('[CardType]') .'</td><td class="'.$textStyle.'">'.$cardType.'</td><td width="*">&nbsp;</td></tr>';            
	          echo '<tr><td class="<? echo $textStyle?>" colspan="1">&nbsp;</td></tr>';
	          echo '<tr><td class="'.$textStyle.'">'. $templateTools->getPageLabel('[CardExpiry]') .'</td><td class="'.$textStyle.'">'.$cardDate.'</td><td width="*">&nbsp;</td></tr>';  
	          ?>
	          <tr><td class="<? echo $textStyle?>" colspan="3">&nbsp;</td></tr>
	          
	      </table>
	    
		</td> 

	</tr>
	
	<tr valign="top" <?= $rowColor;?> >
		<td colspan="4" class="<? echo $boldStyle?>" >
		<? echo $templateTools->getPageLabel('[ReferenceInfo]'); ?></td>
		<td colspan="1" class="<? echo $textStyle?>" >&nbsp;</td>
	</tr>
	
	 <tr>
	    <td colspan="1" valign="top">
	      <table width="100%" border="0">          
	          <tr><td class="<? echo $textStyle?>" ><? echo $templateTools->getPageLabel('[ConfirmNum]'); ?>
	          </td><td>
	          <? 
	          //echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
	           echo $confirmNum;?></td>
	          <td width="*">&nbsp;</td>
				</tr>
	          <tr><td class="<? echo $textStyle?>" colspan="3">&nbsp;</td></tr>
	          <tr><td class="<? echo $textStyle?>" ><? echo $templateTools->getPageLabel('[SeqNum]'); ?>
	          </td><td>
			    <? //echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'; 
			    	 echo $seqNum;  
			    ?></td><td width="*">&nbsp;</td></tr> 			
	          <tr><td class="<? echo $textStyle?>" colspan="1">&nbsp;</td></tr>
	          <tr><td class="<? echo $textStyle?>" ><? echo $templateTools->getPageLabel('[Response]'); ?>
	          </td><td>
			    <? //echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'; 
			    	 echo $response;  
			    ?></td><td width="*">&nbsp;</td>
			    </tr>  
			    <tr><td class="<? echo $textStyle?>" colspan="3">&nbsp;</td></tr>
			</table>
	    </td>         
										
	<!--   <td width="20">&nbsp;</td> -->
		<td colspan="2" valign="top">	
	      <table width="100%" border="0">
	          <tr><td class="<? echo $textStyle?>" ><? echo $templateTools->getPageLabel('[PersonID]'); //echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
	          ?>
	          </td>
	          <td class="<? echo $textStyle?>" ><? 
	          echo $personID;?></td></tr>
	          <tr><td class="<? echo $textStyle?>" colspan="3">&nbsp;</td></tr>
	
	          <?
	          echo '<tr><td class="'.$textStyle.'">'. $templateTools->getPageLabel('[ApprovalCode]') .'</td><td class="'.$textStyle.'">'.$approvalCode.'</td></tr>';            
				 echo '<tr><td class="<? echo $textStyle?>" colspan="3">&nbsp;</td></tr>';
	          echo '<tr><td class="'.$textStyle.'">'. $templateTools->getPageLabel('[Message]') .'</td><td class="'.$textStyle.'">'.$message.'</td></tr>';  
	          ?>
	          <tr><td class="<? echo $textStyle?>" colspan="1">&nbsp;</td></tr>
	          
	      </table>
	    
		</td> 
	
		
			
			
	<!--    <td width="20">&nbsp;</td> -->
		<td colspan="1" width="25%" valign="top">	
	        <span class="<? echo $textStyle?>" >
	              <table width = "100%" border="0">
	                  <tr>
	                      <td colspan="1" class="<? echo $boldStyle?>" >
	                      &nbsp;</td>
	                  </tr>
	                  <tr>
	                      <td colspan="1" class="<? echo $textStyle?>" >
	                      &nbsp;</td>
	                  </tr>
	                  <!-- spacer -->
	                  <tr><td colspan="1">&nbsp;</td></tr>
	                  <!-- end spacer -->                  
	                  <tr>
	                      <td colspan="1" class="<? echo $textStyle?>" >
	                      &nbsp;</td>
	                  </tr>
	                  <!-- spacer -->
	                  <tr><td colspan="1">&nbsp;</td></tr>
	                  <!-- end spacer -->
	   			</table>
	   	</span>
	   </td>
	</tr>
	
	
	</table>
<?
}		// end of "if-not-error" section
?>

<?   
    if (  isset( $contactInfo ) )
    {
	    echo '<br>';
       echo $contactInfo;
       echo '<br><br>';
    }  
?>   
<hr>
<?
    echo '<span class="text"><a href="'.$linkValues['cont'].'">'.$linkLabels['cont'].'</a></span>';
?>


    
    
