<table width="700" border="0" cellpadding="10" cellspacing="0">
        <tr>
            <td colspan="1" class="text">C4C Registration System v2.0!
            <br>
            <span class="smalltext">Technical Help: 
            <a href="http://resources.campusforchrist.org/index.php/Online_Registration_System" target="_blank">User Manual</a>
            &nbsp;&nbsp;&nbsp;&nbsp; or contact:
            <a href="mailto: reg@campusforchrist.org">reg@campusforchrist.org</a></span>
            <br>
            <? echo $eventName ?></pre></td>
            <td><p class="notice"><? if (isset($error_msg)) {   echo $error_msg; } ?></p></td>
            <!-- <td colspan="1" class="text" align="right">&nbsp;</td> -->
        </tr>
        <tr> 
          <td width="700" height="10" colspan="2" valign="bottom">
          <?
		      /*
		       * Display Page Content here
		       */
		      echo $pageContent;
		      
		  ?></td>
        </tr>
        <tr> 
          <td colspan="2" valign="top">&nbsp;</td>
        </tr>
    
</table>