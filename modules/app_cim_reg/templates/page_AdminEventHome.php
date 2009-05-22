<?
/*
 * page_AdminEventHome.php
 *
 * This is a generic template for the page_AdminEventHome.php page.
 *
 * Required Template Variables:
 *  $pageLabels :   The values of the labels to display on the page.
 *  $editEventDetailsLink : The link referencing the Edit Event Details page
 *  $editFieldTypesLink : The link referencing the Edit Field Types page
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


// get page-specific labels array
//$superAdminLabels = $templateTools->loadSpecialLabels( $pageLabels, $superAdminPrefix );

?>
<p><span class="heading"><? echo $templateTools->getPageLabel('[Title]'); ?></span></p>
<p><span class="text"><? echo $templateTools->getPageLabel('[Instr]'); ?></span></p>


<?php

if (isset($isEventAdmin))
{
   if (isset($needsRecalculation)||isset($isRecalculated))
	 {    
		echo '<p><span class="notice">';
		echo $recalcMessage;
		echo '</span></p>';
	 }
 }
?> 
  

<table border="0" cellpadding="5" cellspacing="2">
 
		<?
			echo '<tr><td class="text">&nbsp;&nbsp;&nbsp;<a href="'.$backLink.'">'.$templateTools->getPageLabel('[BackLink]').'</a></td></tr><tr><td></td></tr>';
    		
			if (isset($isSuperAdmin)&&(isset($superAdminLevelLinks))) {
		?>				
    <tr>
		<td class="bold"><? echo $templateTools->getPageLabel('[SuperAdminLevel]'); ?></td>
	</tr>	
		<?			
		   		
		        // super admin level links
		        foreach( $superAdminLevelLinks as $desc=>$link )
		        {
		            echo '<tr><td class="smalltext">&nbsp;&nbsp;&nbsp;<a href="'.$link.'">'.$templateTools->getPageLabel('['.$desc.']').'</a></td></tr>';
		        }
    		}
	    ?>

	 <tr></tr><tr></tr>
        <?
        
        	if (isset($isCampusAdmin)&&(isset($campusLevelLinks))) {
	      ?>	 
    <tr>
        <td class="bold"><? echo $templateTools->getPageLabel('[CampusLevel]'); ?></td>
    </tr>
    </table>

	      <? 	
	      	   echo '<span class="notice">'.$templateTools->getPageLabel('[MultiAssignNotice]').'</span><br><br>';
	        		echo '<table border="0" cellpadding="2" cellspacing="2">';
        
	        		// display summary table header
	        		echo '<tr><td class="smallBold">'.$templateTools->getPageLabel('[CampusTitle]').'</td><td class="smallBold">'.$templateTools->getPageLabel('[CampusLinkTitle]').'</td><td class="smallBold">'.$templateTools->getPageLabel('[NumMales]').'</td><td class="smallBold">'.$templateTools->getPageLabel('[NumFemales]').'</td><td class="smallBold">'.$templateTools->getPageLabel('[CampusTotal]').'</td><td class="smallBold">'.$templateTools->getPageLabel('[Cancellations]').'</td><td class="smallBold">'.$templateTools->getPageLabel('[Complete]').'</td><td class="smallBold">'.$templateTools->getPageLabel('[Incomplete]').'</td></tr>';
	        		
	            // campus level links
	            foreach( $campusLevelLinks as $desc=>$aCampus )
	            {
	                $linkText = '';
	                if ( $aCampus['regLink'] != '#' )
	                {
	                    $linkText = $templateTools->getPageLabel('[CampusLink]');
	                }
	                echo '<tr><td class="smalltext">'.$aCampus['campus_desc'].'</td><td class="smalltext"><a href="'.$aCampus['regLink'].'">'.$linkText.'</a></td><td class="smalltext">'.$aCampus['numMales'].'</td><td class="smalltext">'.$aCampus['numFemales'].'</td><td class="smalltext">'.$aCampus['campusTotal'].'</td><td class="smalltext">'.$aCampus['cancellations'].'</td><td class="smalltext">'.$aCampus['completes'].'</td><td class="smalltext">'.$aCampus['incompletes'].'</td></tr>';
	            }
	           
	            // display summary table footer (shows totals for all campuses) 
	           echo '<tr><td class="smallBold">'.$templateTools->getPageLabel('[TotalsTitle]').'</td><td class="smallBold"></td><td class="smallBold">'.$summaryTotals['numMales'].'</td><td class="smallBold">'.$summaryTotals['numFemales'].'</td><td class="smallBold">'.$summaryTotals['campusTotal'].'</td><td class="smallBold">'.$summaryTotals['cancellations'].'</td><td class="smallBold">'.$summaryTotals['completes'].'</td><td class="smallBold">'.$summaryTotals['incompletes'].'</td></tr>';

	           echo '</table>';
    		}
        
        ?>	
    <table border="0" cellpadding="5" cellspacing="2">    
    <tr></tr><tr></tr>
        <?
        
           if (isset($isEventAdmin)&&(isset($eventLevelLinks))) {
	     ?>    
    <tr>
        <td class="bold"><? echo $templateTools->getPageLabel('[EventLevel]'); ?></td>
    </tr>        
        <?	    
		        // event level links
		        foreach( $eventLevelLinks as $desc=>$link )
		        {
		            echo '<tr><td class="smalltext">&nbsp;&nbsp;&nbsp;<a href="'.$link.'">'.$templateTools->getPageLabel('['.$desc.']').'</a></td></tr>';
		        }
    		}
	    ?>
    <tr></tr><tr></tr>
	    <?
           if (isset($isFinanceAdmin)&&(isset($financeLevelLinks))) {
	    ?>    
    <tr>
        <td class="bold"><? echo $templateTools->getPageLabel('[FinanceLevel]'); ?></td>
    </tr>        
	    <?
					   // finance level links
		        foreach( $financeLevelLinks as $desc=>$link )
		        {
		            echo '<tr><td class="smalltext">&nbsp;&nbsp;&nbsp;<a href="'.$link.'">'.$templateTools->getPageLabel('['.$desc.']').'</a></td></tr>';
		        }
        	}
	    
	    ?>        

</table>
