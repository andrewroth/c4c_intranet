<form action="<?=$pageContent->formAction;?>" method="post" name="LoginForm" id="LoginForm">
<table width="100%" height="100%" border="0">
  <tr> 
    <td width="100%" height="100%" valign="top">
<p align="center" class="heading2">&nbsp;</p>
      <p align="center" class="heading2">&nbsp;</p>
      <p align="center" class="heading2"><font color="#000000">Welcome to the 
        Registration Center!</font></p>
      <div align="center"> 
        <table width="402" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td height="177" bgcolor="#40637A"><table width="400" height="175" border="0" align="center" cellpadding="7" bgcolor="#FFFFFF">
                <tr bgcolor="#40637A"> 
                  <td colspan="3" class="text"><font color="#FFFFFF">Welcome to 
                    the Registration Center! Please enter your user ID and password 
                    to continue.</font></td>
                </tr>
                <tr> 
                  <td colspan="3" valign="top" bgcolor="EEEEEE" class="bold"> 
                    <table width="300" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
                    <?
                        if ( $pageContent->errorMessage != "" ) {
                        
                            echo '<tr bgcolor="EEEEEE"> 
                        <td colspan="3"><span class="error" align="center">'.$pageContent->errorMessage.'</span></td>
                      </tr>';
                        
                        }
                    ?>
                      <tr> 
                        <td width="84" height="42" bgcolor="EEEEEE" class="bold"><font color="#000000">User 
                          ID: </font></td>
                        <td width="140" bgcolor="EEEEEE"> <input name="<?=$pageContent->form_username;?>" type="text" id="UserID" value="<?=$pageContent->username;?>"></td>
                        <td width="140" align="left" valign="bottom" bgcolor="EEEEEE"> 
                          <div align="left"> </div></td>
                      </tr>
                      <tr> 
                        <td height="39" bgcolor="EEEEEE" class="bold"><font color="#000000">Password: 
                          </font></td>
                        <td bgcolor="EEEEEE"> <input name="<?=$pageContent->form_password;?>" type="password" id="PWord" value="<?=$pageContent->password;?>"></td>
                        <td width="140" align="left" valign="middle" bgcolor="EEEEEE"> 
                          <div align="center">
                            <input type="submit" name="Submit" value="Log In">
                          </div></td>
                      </tr>
                      <tr bgcolor="EEEEEE"> 
                        <td colspan="3"><span class="text">Forgot your password? 
                          Click <a href="mailto:mysan@dodomail.net?subject=Password%20Help">here</a> 
                          for help. </span></td>
                      </tr>
                    </table>
                    <div align="right"> </div></td>
                </tr>
              </table> </td>
          </tr>
          <tr> 
            <td><img src="images/space.gif" width="402" height="1"></td>
          </tr>
        </table>
      </div>
      </td>
  </tr>
</table>
</form>