<?
/*
 * page_MySchedule.php
 *
 * This is a generic template for the page_MySchedule.php page.
 *
 * Required Template Variables:
 *  $pageLabels :   The values of the labels to display on the page.
 *
 *  $groupCollectionArray: an array of GroupCollection objects
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

<form name="Form" id="Form" method="post" action="<?=$formAction?>">
<input name="Process" type="hidden" id="Process" value="T" />

<table border="0">
<tr valign="top">
	<?php 
	
	//echo "<pre>".print_r ($groupAssociationArray)."</pre>";

	 $i = 0;
	//Use this to format the long list of groups
	$countSetOfThree =0;		//Start the count at 0 and
	$countMax = 3;				//show the max of three groups in a row
	
	
	
	foreach( $groupCollectionArray as $id=>$aGroupCollection )
	{
		$countSetOfThree++;
	    echo "<td>";
	    echo "<table border='0'>";
	   	echo "<b>".$aGroupCollection->getCampusName()."[".$aGroupCollection->getCampusID()."]</b><br/>";
	    $groupArray = $aGroupCollection->getGroups();
	    foreach ($groupArray as $key=>$groupobject) {
	       echo "<tr><td><input type='checkbox' name='G_".$groupobject->getGroupID()."' value='".$groupobject->getGroupID()."'";
	   		if (isset($groupAssociationArray) && in_array($groupobject->getGroupID(),$groupAssociationArray)) {
				echo(' checked');
			}
			echo("></td>");
			echo ("<td>".$groupobject->getName()."</td></tr>\n");
	    } // groupArray
	   
	   // groupobject->getID()
	   
	   echo "</table>";
	   echo "</td>";
	   if($countSetOfThree == $countMax){
	   		//Make a new row if there is more then 3 groups
	   		echo "</tr><tr>";
	   		$countSetOfThree = 0;
	   }
	} // groupCollectionArray
	
	?>
	</tr>
	</table>
	<p>Check off the boxes indicating the times when you are busy. Make sure you check off all the times when you are unavailable, either due to class, work, or other things that are regularly in your schedule. We will use this information to try to arrange meetings so that everyone can attend one.</p>
	<table cellspacing="1" cellpadding="1" bgcolor="#000000">
	<tr>
	<td bgcolor="#CCCCCC" width="16%"></td>
	<?
		//print the week days names in the array
		foreach($timeTableBlocks['weekDaysName'] as $value){
			echo "<td bgcolor='#CCCCCC' width='10%' align='center'><b>".$value."</b></td>";
		}
	
		//$count keep tracks the array postistion for $timeTableBlocks['dbtime']
		$count =0;
		
		//For each time in the array print them out
		foreach($timeTableBlocks['times'] as $value){
			echo("<tr>\n");
			echo("<td bgcolor=\"#CCCCCC\">$value</td>\n");
				
			//for each weekDaysName which is from Monday to Friday, insert a checkbox with the appropriate value.
			for($i=0; $i<sizeof($timeTableBlocks['weekDaysName']); $i++){
					
				//$block_num contains the special number that we use to store in the database
				$block_num = $timeTableBlocks['dbtimes'][$count];
				echo("<td bgcolor='#EEEEEE' align='center'><input type='checkbox' name='TB_".$block_num."' value='".$block_num."'");
					
				//echo("<td bgcolor='#EEEEEE' align='center'><input type='text' name='TB_".$block_num."' id='TB_".$block_num."' class='timeblocks' readonly='readonly' onclick='return swCheckBox('".$block_num."')'     ");
				
				//If the user doesn't have a schedule then do not check the boxes.
				//If the user have a schedule then check if the current block number is in the $timeBlocksArray.
				//The timeBlocks Array was passed back from our database.
				if (isset($timeBlocksArray) && in_array($block_num,$timeBlocksArray)) {
					echo(' checked');
				}
				echo(" /></td>\n");
				$count++;
			}
			echo "</tr>";
		}

	?>
	
</table>
<br/>
<input type="submit" value="Submit"/>
</form>