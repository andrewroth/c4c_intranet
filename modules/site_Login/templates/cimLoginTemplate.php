<style type="text/css">
<!--

body {
	background-image: url(../Images/landing-screen_bg.gif);
	background-repeat: repeat-x;
	background-color: #0D1C42;
	color: #FFFFFF;
	font-family: tahoma, verdana, sans-serif;
	}

.Headings {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 14px;
	color: #000033;
	text-decoration: none;
	}
	
.style2 {
	font-family: Verdana, Arial, Helvetica, sans-serif
	}
	
.style4 {
	color: #000000; font-weight: bold; font-size: 12px; 
	}
	
.style5 {
	font-size: 12px;
	font-weight: bold;
	}
	
.style6 {
	font-size: 12px
	}
	
a {
	color: transparent;
	}
	
a:link, a:visited, a:focus, a:hover, a:active {
	color: transparent;
	text-decoration: none;
	}
	
/* wrap determines the sizing of the entire page --------------------------*/
#wrap {
	min-width: 500px;
	}

/* header -----------------------------------------------------------------*/
#c4clogo {
	width: 292px;
	height: 164px;
	margin: auto;
	position: relative;
	left: -140px;
	}

/* white box contains the 'login with GCX' and 'get started with GCX' buttons */
#whitebox {
	width: 500px;
	height: 300px;
	background-color: transparent;
	margin: auto;
	position: relative;
	top: 130px;
	}
	
#loginbtn {
	height: 53px;
	width: 215px;
	position: absolute;
	top: 80px;
	left: 40px;
	}
	
#loginbtn a:hover {

	}
	
#getstartedbtn {
	height: 53px;
	width: 258px;
	position: absolute;
	top: 150px;
	left: 20px;
	}

#gcxlogo {
	width: 159px;
	height: 112px;
	position: absolute;
	left: 300px;
	top: 90px;
	}

/* footer (placed directly below the white box) --------------------------*/
#footer {
	width: 500px;
	margin: auto;
	position: relative;
	top: 150px;
	color: #FFFFFF;
	text-align: right;
	}


-->
</style>

<!-- <table width="400" height="200" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="223450">
        <tr valign="top" bgcolor="transparent" >
            <td><img src="<?=$pageContent->pathToRoot;?>../../Images/c4c_logo_full_colour_400x200.jpg" width="400" height="200"></td>
            <td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <td valign="middle" bgcolor="white" ><img src="<?=$pageContent->pathToRoot;?>../../Images/aiacanada_logo.jpg" ></td>
        </tr>
</table> -->


<!-- wrap begins -->
<div id="wrap">

<!-- c4c logo (placed in header) begins -->
<div id="c4clogo">
	<img src="<?=$pageContent->pathToRoot;?>../../Images/landing-screen_c4clogo.gif" alt="Campus for Christ" width="292" height="164">
</div><!-- c4c logo ends -->

<!-- white box (with GCX login/get started buttons) begins -->
<div id="whitebox">
	<img src="<?=$pageContent->pathToRoot;?>../../Images/landing-screen_whitebox.gif" alt="white box" width="500" height="300">
	
<div id="loginbtn">
	<a href="<?php print CASUser::login_link() ?>"><img src="<?=$pageContent->pathToRoot;?>../../Images/landing-screen_btn_login.gif" alt="Login with GCX" width="215" height="53"></a>
</div>

<div id="getstartedbtn">
	<a href="https://signin.mygcx.org/sso/selfservice/ssoSignup.jsp"><img src="<?=$pageContent->pathToRoot;?>../../Images/landing-screen_btn_getstarted.gif" alt="Get Started with GCX" width="258" height="53"></a>
</div>

<div id="gcxlogo">
	<img src="<?=$pageContent->pathToRoot;?>../../Images/landing-screen_gcxlogo.gif" alt="GCX" width="159" height="112">
</div>

</div><!-- white box ends -->

<div id="footer">
Copyright 2009 Campus for Christ
</div>

</div><!-- wrap ends -->

















