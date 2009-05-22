<table width="530" border="0" cellpadding="10" cellspacing="0">
        <!-- Heading not needed yet.
        <tr>
            <td colspan="2"><p class="bold">Common Display Template</p><p class="text">You will probably want to change this ...</p> <p class="smalltext"> (you can do this in the file: templates/obj_CommonDisplay.php)</p></td>
        </tr>
        -->
        <tr>
          <td width="530" height="10" colspan="2" valign="bottom"><?
		      /*
		       * Display Page Content here
		       */
		      echo $pageContent;
		      
		  ?></td>
        </tr>
        <!--
        <tr>
          <td colspan="2" valign="top">&nbsp;</td>
        </tr>
        <tr valign="bottom">
          <td width="50%" height="35"> <p>&nbsp;</p>
          <?
            if ( !isset($previousHREF) ) {

                $previousHREF = '#';
            }


            echo '<p><a href="'.$previousHREF.'" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage(\'Previous\',\'\',\''.$pathToRoot.'images/previous_on.jpg\',0)"><img src="'.$pathToRoot.'images/previous_off.jpg" alt="Previous" name="Previous" width="100" height="25" border="0"></a></p>';


         ?></td>
          <td width="50%"> <div align="right">
              <p>&nbsp;</p>
              <?
            if ( !isset($continueHREF) ) {

                $continueHREF = '#';
            }

            echo '<p><a href="'.$continueHREF.'" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage(\'Navigation\',\'\',\''.$pathToRoot.'images/continue_on.jpg\',1)"><img src="'.$pathToRoot.'images/continue_off.jpg" alt="Continue" name="Navigation" width="100" height="25" border="0"></a></p>';

         ?></div></td>

        </tr>
        -->
</table>