<style type="text/css">
<!--
.Headings {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 14px;
	color: #000033;
	text-decoration: none;
}
.style2 {font-family: Verdana, Arial, Helvetica, sans-serif}
.style4 {color: #000000; font-weight: bold; font-size: 12px; }
.style5 {
	font-size: 12px;
	font-weight: bold;
}
.style6 {font-size: 12px}
-->
</style>

<table width="400" height="200" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="223450">
        <tr valign="top" bgcolor="white" >
            <td><img src="<?=$pageContent->pathToRoot;?>../../Images/c4c_logo_full_colour_400x200.jpg" width="400" height="200"></td>
            <td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <td valign="middle" bgcolor="white" ><img src="<?=$pageContent->pathToRoot;?>../../Images/aiacanada_logo.jpg" ></td>
        </tr>
</table>

<form action="<?=$pageContent->formAction;?>" method="post" name="LoginForm" id="LoginForm">

        <table width="400" border="0" align="center">   
        
            <tr>
                <td colspan="3">
                    <div align="left">
                        <strong>
                            <span class="style4">
                                <font face="Verdana, Arial, Helvetica, sans-serif"><?=$pageContent->errorMessage;?></font>
                            </span>
                        </strong>
                    </div>
                </td>
            </tr>         
            <tr>
                <td colspan="3">
                    <span class="style5"><font face="Verdana, Arial, Helvetica, sans-serif">Log In to Existing Account</font></span>
                </td>
            </tr>
            <tr>
				<td width="15%"> <img src="../../Images/p2c_50x50.jpg" height="50" width="50"> </td>
				<td width="85%"> <table> <tr>
                <td align="left" width="125" height="20">
				
                    <span class="style6"><font face="Verdana, Arial, Helvetica, sans-serif">User Name:</font></span>
                </td>
                <td width="200">
                    <span class="style6">
                        <font face="Verdana, Arial, Helvetica, sans-serif">
                            <input name="<?=$pageContent->form_username;?>" type="text" id="UserID" value="<?=$pageContent->username;?>" size="25">
                        </font>
                    </span>
                </td>
                <td>&nbsp;</td>
            </tr>
            <tr> 
                <td align="left" width="200" height="20">
                    <span class="style6"><font face="Verdana, Arial, Helvetica, sans-serif">Password:</font></span>
                </td>
                <td width="200">
                    <span class="style6">
                        <font face="Verdana, Arial, Helvetica, sans-serif">
                            <input name="<?=$pageContent->form_password;?>" type="password" id="PWord" value="<?=$pageContent->password;?>" size="25">
                        </font>
                    </span>
                </td>
                </tr></table></td>
            </tr>
            <tr>
                <td align="left" width="150">&nbsp;</td>
                <td align="right">
                          <span class="style6">
                              <font face="Verdana, Arial, Helvetica, sans-serif">
                                  <input type="submit" name="Submit" value="Login">
                              </font>
                          </span>
                </td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td class="text" align="right" colspan="3">
                    <? 
                    
                    //include("lost_password_notice.php");
                     
                    echo '<span class="style4"><a href="'.$pageContent->pathToRoot.'../app_cim_newaccount/index.php?P=P32&RU=https://intranet.campusforchrist.org/index.php"><font face="Verdana, Arial, Helvetica, sans-serif">Create Account?</strong></font></a></span>';
                    
                    echo ' | ';
                    
                    echo '<span class="style4"><a href="'.$pageContent->pathToRoot.'../app_cim_newaccount/index.php?P=P35"><font face="Verdana, Arial, Helvetica, sans-serif">Forgot Password?</font></a></span>';
                    
                    ?>
                    
                    
                </td>
            </tr>
            
			<tr>
                <td class="text" colspan="3">
                  <br/>
                  <strong>
                     <span class="style4">
                        <!--<font face="Verdana, Arial, Helvetica, sans-serif">Students wishing to register for Winter Conference 2007 need to create an account. If you went on a Summer Project in '07 or to Summit, you already have an account and should login using those credentials.</a></font> -->
                     </span>
                  </strong>
                </td>
			</tr>
			<tr>
                <td class="text" colspan="3">
                  <br/>
                     <span class="style6">
                        <font face="Verdana, Arial, Helvetica, sans-serif">For the summer project tool click <a href="https://spt.campusforchrist.org">here</a>.</font>
                     </span>
                </td>
         </tr>
         <tr>
                <td class="text" colspan="3">
                  <br/>
                     <span class="style6">
                        <font face="Verdana, Arial, Helvetica, sans-serif">For the online scheduler tool click <a href="http://scheduler.campusforchrist.org">here</a>.</font>
                     </span>
                </td>
            </tr>
            
            <?
            //
			   // <tr>
            //    <td class="text" colspan="3">
            //         include("student_notice.php");
            //
            //    </td>
            //
            // </tr>
            ?>
            
            
        </table>
 
</form>
