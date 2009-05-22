<?
    /** obj_CommonDisplay.php
     *
     *  Required Template Variables (i.e. pass them in)
     *
     *  
     * 
     *  $viewerID - username of person logged in
     *  $accessLevel - descrition of access priviledges
     *
     *
     */
     
    // note: original table width was 530
?>




<table width="730" border="0" cellpadding="10" cellspacing="0">
        <tr>
            <td colspan="2"><p class="text"> ViewerID: <b><? echo $viewerID; ?></b>&nbsp;&nbsp; AcessLevel: <b><? echo $accessLevel;?></b></p></td>
        </tr>
        <tr> 
          <td width="730" height="10" colspan="2" valign="bottom"><?
		      /*
		       * Display Page Content here
		       */
		      echo $pageContent;
		      
		  ?></td>
        </tr>
        <tr> 
          <td colspan="2" valign="top">&nbsp;</td>
        </tr>
        <tr valign="bottom"> 
          <td width="50%" height="35"> <p>&nbsp;</p>
          <?
            if ( !isset($previousHREF) ) {
            
                $previousHREF = '#';
            }
            
            
            // echo '<p><a href="'.$previousHREF.'" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage(\'Previous\',\'\',\''.$pathToRoot.'images/previous_on.jpg\',0)"><img src="'.$pathToRoot.'images/previous_off.jpg" alt="Previous" name="Previous" width="100" height="25" border="0"></a></p>';
                
            
         ?></td>
          <td width="50%"> <div align="right"> 
              <p>&nbsp;</p>
              <?
            if ( !isset($continueHREF) ) {
            
                $continueHREF = '#';
            }
            
            // echo '<p><a href="'.$continueHREF.'" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage(\'Navigation\',\'\',\''.$pathToRoot.'images/continue_on.jpg\',1)"><img src="'.$pathToRoot.'images/continue_off.jpg" alt="Continue" name="Navigation" width="100" height="25" border="0"></a></p>';
            
         ?></div></td>
        </tr>
      </table>