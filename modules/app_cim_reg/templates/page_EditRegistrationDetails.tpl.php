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

 // display Continue Link if provided
 $continueLabel = '';
 if ( isset($linkValues['cont']) ) {
     $continueLabel = '<p>&nbsp;&nbsp;&nbsp;&nbsp;<span class="text" align="right"><a href="'.$linkValues['cont'].'">'.$linkLabels['cont'].'</a></span></p>';
 }

echo $continueLabel;

// Any other special instructions etc...
if ( isset( $specialInfo ) )
{
    echo $specialInfo;
}

?>
<hr>

<form name="Form" id="Form" method="post" action="<?=$statusFormAction;?>">
	<table width="100%" border="0">
	<!-- Data List Headings -->
	<?  $textStyle = 'text'; // set style for basic table data 
		 $boldStyle = 'bold';	// set style for important table data
	?>
	
	
	 <tr valign="top" <?= $rowColor;?> >
	 	<td colspan="1" class="<? echo $boldStyle?>" >
	 	<? echo $templateTools->getPageLabel('[RegistrationStatus]'); ?></td>
	 	<td colspan="3" class="<? echo $textStyle?>" > 	
			<select id="registration_status" name="registration_status">
			
			<?
				$selected = '';
			
			    // for each desired field to display ... (index = status_id; value = status_desc)
			    foreach (array_keys($statusList) as $k)	//$indx=0; $indx<count( $formFieldList ); $indx++) {
				 {
					 //$record = current($statusList);
					 
					 $index = key($statusList);	
					 if ($index == $currentRegStatus)		// compare status IDs and select the one matching current reg. status
					 {
						 $selected = 'selected ';
					 }
					 else
					 {
						 $selected = '';
					 }	 
					     
				    echo '<option '.$selected.'value="'.$index.'">'.$statusList[$index].'</option>';
				    next($statusList);
			    }
			?>
			</select> 				
		</td>
	
		<td colspan="1" class="<? echo $textStyle?>" >
			<input type="hidden" name="Process" value="T" >
		   <input type="hidden" name="form_name" value="regStatusForm" >
			<input name="statusSubmit" type="submit" value="<?=$statusButtonText; ?>" />
		</td>
		
	 </tr>
	</table>
</form>


<table width="100%" border="0">
<!-- Data List Headings -->
<?  $textStyle = 'text'; // set style for basic table data 
	 $boldStyle = 'bold';	// set style for important table data
?>


 <tr valign="top" <?= $rowColor;?> >
 	<td colspan="3" class="<? echo $boldStyle?>" >
 	<? echo $templateTools->getPageLabel('[FinancialInfo]'); ?></td>
 	<td colspan="1" class="<? echo $boldStyle?>" ><? echo $templateTools->getPageLabel('[PersonalInfo]'); ?></td>
 </tr>
 <tr>
    <td colspan="1" valign="top">
      <table width="100%" border="0">
          <tr><td class="<? echo $textStyle?>" colspan="3"><? echo $templateTools->getPageLabel('[BasePriceThisReg]'); ?></td></tr>
          
          <tr><td class="<? echo $boldStyle?>" ><? echo $templateTools->getPageLabel('[Total]'); ?>
          </td><td>
          <? 
          //echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
           echo $basePriceForThisGuy;?></td>
          <td width="*">&nbsp;</td>
			</tr>
          <tr><td class="<? echo $textStyle?>" colspan="3">&nbsp;</td></tr>
          <tr><td class="<? echo $boldStyle?>" ><? echo $templateTools->getPageLabel('[TotalPaid]'); ?>
          </td><td>
		    <? //echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'; 
		    	 echo $scholarshipTotal+$cashTotal+$ccTotal;  
		    ?></td><td width="*">&nbsp;</td></tr> 			
          <tr><td class="<? echo $textStyle?>" colspan="1">&nbsp;</td></tr>
          <tr><td class="<? echo $boldStyle?>" ><? echo $templateTools->getPageLabel('[BalanceOwing]'); ?>
          </td><td>
		    <? //echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'; 
		    	 echo $basePriceForThisGuy-$scholarshipTotal-$cashTotal-$ccTotal;  
		    ?></td><td width="*">&nbsp;</td>
		    </tr>  
		    <tr><td class="<? echo $textStyle?>" colspan="3">&nbsp;</td></tr>
		</table>
    </td>         
									
<!--   <td width="20">&nbsp;</td> -->
	<td colspan="2" valign="top">	
      <table width="100%" border="0">
          <tr><td class="<? echo $textStyle?>" colspan="2"><? echo $templateTools->getPageLabel('[RulesApplied]'); ?></td></tr>
          <tr><td class="<? echo $textStyle?>" ><? echo $templateTools->getPageLabel('[EventBasePrice]'); //echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
          ?>
          </td>
          <td class="<? echo $textStyle?>" ><? 
          echo $eventBasePrice;?></td></tr>

          <?
          
          // first print out the rules the computer has applied
          foreach( $priceRules as $key=>$ruleApplied )
          {
              echo '<tr><td class="'.$textStyle.'">'. $ruleApplied['pricerules_desc'] .'</td><td class="'.$textStyle.'">'.$ruleApplied['pricerules_discount'].'</td></tr>';   
          }
          
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
                      <? echo $person['person_fname'] . " " . $person['person_lname']                      
                      ?></td>
                  </tr>
                  <tr>
                      <td colspan="1" class="<? echo $textStyle?>" >
                      <? echo $person['campus_desc'] 
                      ?></td>
                  </tr>
                  <tr>
                      <td colspan="1" class="<? echo $textStyle?>" >
                      <? echo $person['person_email'] 
                      ?></td>
                  </tr>
                  <tr>
                      <td colspan="1" class="<? echo $textStyle?>" >
                      <? echo $list_gender_id[ $person['gender_id'] ]; 
                      ?></td>
                  </tr>
                  <!-- spacer -->
                  <tr><td colspan="1">&nbsp;</td></tr>
                  <!-- end spacer -->
   			</table>
   	</span>
   	<span class="text" align="right"><a href="<? echo $linkValues['EditPersonInfo'];?>"><? echo $templateTools->getPageLabel('[EditPersonInfo]')?></a></span>
   </td>
</tr>
</table>

<table width="100%" border = "0">
<tr>   
   
	<td colspan="3" width="75%" valign="top">	
		<table width="75%" border="0">
          <tr><td colspan = "4" class="<? echo $textStyle?>" ><? echo $templateTools->getPageLabel('[Scholarships]'); ?></td></tr>
		    <tr><td colspan = "4"><? echo $scholarshipsAdminBox; 
		    ?></td></tr>
		    <tr><td colspan = "4" class="<? echo $boldStyle?>"> <? echo $templateTools->getPageLabel('[Total]'); ?>
		    <? echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'; 
		    	 echo $scholarshipTotal; 
		    ?></td></tr>
          <tr><td colspan = "4" class="<? echo $textStyle?>">&nbsp;</td></tr>
             
          <tr><td colspan = "4"class="<? echo $textStyle?>"><? echo $templateTools->getPageLabel('[CashTransactions]'); ?></td></tr>
			 <tr><td colspan = "4"><? echo $cashTransAdminBox; 
			 ?></td></tr>
		    <tr><td colspan = "1" class="<? echo $boldStyle?>" ><? echo $templateTools->getPageLabel('[TotalReceived]'); ?>
		    <? echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'; 
		    	 echo $cashTotal; 
		    ?></td>
		    <td colspan = "1" class="<? echo $boldStyle?>"><? echo $templateTools->getPageLabel('[TotalOwed]'); ?>
		    <? echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'; 
		    	 echo $cashOwed; 
		    ?></td><td colspan = "2" width="*">&nbsp;</td>
		    </tr>
          <tr><td class="<? echo $textStyle?>" colspan="1">&nbsp;</td></tr>
 		</table>
 	</td>
 	
    <td align = "center" colspan="1" width="100%" valign="top">
       <!--     <tr>
                <td align="center" width="100%">  -->
                    <table width="100%" border="1" cellpadding="0" cellspacing="0">
                        <tr style="background-color:#EAF3FF"><td>
                            <span class="'.$textStyle.'">
                            <? echo $templateTools->getPageLabel('[formLabel_person_local_addr]')?>
                            </span>
                        </td></tr>
                        <tr><td>
                            <span class="'.$textStyle.'">
                            <? echo $person['person_local_addr'] 
                            ?> <br>
                            <? echo $person['person_local_city'] . ", ";
                               if (isset($list_province_id[ $person['person_local_province_id'] ])) {
                               	echo $list_province_id[ $person['person_local_province_id'] ];
                            	 }
                            ?><br>
                            <? echo $person['person_local_pc'] 
                            ?><br>
                            </span>
                        </td></tr>
                        <tr><td>
                            <span class="'.$textStyle.'">
                            &nbsp;<? echo $person['person_local_phone'] 
                            ?>
                            </span>
                        </td></tr>
                    </table>
                    <table>
	                   <tr>
	                      <td>&nbsp;</td>
	                  </tr>                         
	                 </table>
      <!--          </td>
            </tr>  
            <tr>
                <td>&nbsp;</td>
            </tr>
            <tr> 
                <td align="center" width="100%"> -->
                    <table width="100%" border="1" cellpadding="0" cellspacing="0">
                        <tr style="background-color:#EAF3FF"><td>
                            <span class="'.$textStyle.'">
                            <? echo $templateTools->getPageLabel('[formLabel_person_addr]')
                            ?>
                            </span>
                        </tr></td>
                        <tr><td>
                            <span class="'.$textStyle.'">
                            <? echo $person['person_addr'] 
                            ?> <br>                                                        
                            <? echo $person['person_city'] . ", ";
                               if (isset($list_province_id[ $person['province_id'] ])) {
                               	echo $list_province_id[ $person['province_id'] ];
                            	 }
                            ?><br>
                            <? echo $person['person_pc'] 
                            ?> <br>
                            </span>
                        </tr></td>
                        <tr><td>
                            <span class="'.$textStyle.'">
                            <? echo $person['person_phone'] 
                            ?>
                            </span>
                        </tr></td>
                    </table>
        <!--        </td>
            </tr>   -->       
    </td>
</tr>
</table>

<table width="100%" border = "0">
<tr>       
       
       
       
  <td colspan="3" width="100%" valign="top">	   
    <table width="40%" border="0">               
       <tr><td class="<? echo $textStyle?>" colspan="1"><? echo $templateTools->getPageLabel('[CCTransactions]'); ?></td></tr>
      <? if (isset($attemptedOverpayment))
       	 {
	    ?>
       <tr><td class="notice" colspan="1"><? echo $templateTools->getPageLabel('[Overpayment]'); ?></td></tr>	
       <?
 	 		 }
 	 	 ?>
       <tr><td><? echo $ccTransAdminBox; 
       ?></td></tr>
	    <tr><td class="<? echo $boldStyle?>" ><? echo $templateTools->getPageLabel('[TotalProcessed]'); ?>
	    <? echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'; 
	    	 echo $ccTotal; 
	    ?></td></tr>
	              
       <tr><td class="<? echo $textStyle?>" colspan="1">&nbsp;</td></tr>
          
       <tr><td class="<? echo $boldStyle?>" ><? echo $templateTools->getPageLabel('[BalanceOwing]'); ?>
	    <? echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'; 
	    	 echo $basePriceForThisGuy-$scholarshipTotal-$cashTotal-$ccTotal;  
	    ?></td></tr>          

    </table>
 </td>
</tr>
</table>	
   
   
<table width="100%" border = "0">    
<tr><td>
<br>
<hr>
<p class="<? echo $textStyle?>" ><b><? echo $templateTools->getPageLabel('[EventInfo]'); ?></b>  
<span class="go">
<? //echo $updateEventInfo;
?></span>
    <? 
    
        //echo "<BR><BR>NOTE: Event-specific form information to be implemented in the future.";		
        echo $eventFieldsFormSingle;
    
    ?>
</p>


</td>
</tr>
</table>
<hr>
<?
 echo $continueLabel;
 //   echo '<span class="text"><a href="'.$linkValues['cont'].'">'.$linkLabels['cont'].'</a></span>';
?>


    
    
