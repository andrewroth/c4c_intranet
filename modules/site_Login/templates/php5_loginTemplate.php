<table width="100%" border="0" cellspacing="1" cellpadding="1">
  <tr> 
    <td width="10%">&nbsp;</td>
    <td>&nbsp;</td>
    <td width="10%">&nbsp;</td>
  </tr>
  <tr> 
    <td width="10%">&nbsp;</td>
    <td><div align="center"><img src="<?=$pageContent->pathToRoot;?>Images/ttl_LoginBanner.gif" width="400" height="200"></div></td>
    <td width="10%">&nbsp;</td>
  </tr>
  <tr> 
    <td width="10%">&nbsp;</td>
    <td>&nbsp;</td>
    <td width="10%">&nbsp;</td>
  </tr>
  <tr> 
    <td>&nbsp;</td>
    <td><div align="center"><font color="#660000"><strong><?=$pageContent->errorMessage;?></strong></font></div></td>
    <td>&nbsp;</td>
  </tr>
  <tr> 
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><form action="<?=$pageContent->formAction;?>" method="post" name="LoginForm" id="LoginForm">
        <table width="100%" border="0" cellspacing="1" cellpadding="1">
          <tr> 
            <td align="right"><img src="<?=$pageContent->pathToRoot;?>Images/icn_UserID.gif" width="220" height="20"></td>
            <td width="50%"> <input name="<?=$pageContent->form_username;?>" type="text" id="UserID" value="<?=$pageContent->username;?>"></td>
          </tr>
          <tr> 
            <td align="right"><img src="<?=$pageContent->pathToRoot;?>Images/icn_PWord.gif" width="220" height="20"></td>
            <td width="50%"> <input name="<?=$pageContent->form_password;?>" type="password" id="PWord" value="<?=$pageContent->password;?>"></td>
          </tr>
          <tr> 
            <td colspan="2"> <div align="center">
                <input type="submit" name="Submit" value="Submit">
              </div></td>
          </tr>
        </table>
      </form></td>
    <td>&nbsp;</td>
  </tr>
</table>


