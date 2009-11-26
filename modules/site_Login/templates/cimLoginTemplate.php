<style type="text/css">
<!--

a {
	text-decoration: none;
  color: #1C55AB;
  }
  
a:hover {
	text-decoration: underline;
	}

body {
  margin:0;
	background-color: #152752;
	color: #FFFFFF;
	font-family: tahoma, verdana, sans-serif;
	}

	
/* wrap determines the sizing of the entire page --------------------------*/
#wrap {
	min-width: 500px;
	text-align: center;
	}

/* header -----------------------------------------------------------------*/
#c4clogo {
  background-color: #FFF;
  text-align: center;
	}

#yellowbar {
  background-image: url(<?=$pageContent->pathToRoot;?>../../Images/loggin_screen_yellowbar.gif);
  background-repeat: repeat-x;
  height: 25px;
  }
  
/* white box contains the 'login with GCX' and 'get started with GCX' buttons */
#whitebox {
	width: 500px;
	height: 300px;
	background-image: url(<?=$pageContent->pathToRoot;?>../../Images/loggin_screen_whitebox.gif);
	margin-top: 101px;
  margin-left: auto;
  margin-right: auto;
  color: #000;
 	font-family: tahoma, verdana, sans-serif;
 	font-weight: 300;
 	font-size: 0.75em;
 	text-align: left;
	}

#gcxSection {
	margin-top: 23px;
	}

#loginWithGXC {
  font-size: 1.5em;
  font-weight: bolder;
  margin-left: -1px;
}

#createGcxAccount {
  margin-top: 15px;
  display: block;
  }
	
#gcxlogo {
	float: left;
	margin-left: 34px;
	margin-right: 13px;
	}

#wcLogo {
	margin-left: 46px;
	margin-top: 26px;
	}

#registerForWC {
  margin-top: 5px;
  margin-left: 35px;
  display: block;
  font-weight: bold;
	font-size: 1.25em;
	color: #000;
	}

#registerForWC #WCBlue {
	color: #091863;
}

/* What is GCX section */
#whatisgcxlink
{
	margin: 10px 0 0 0 5px;
}

#whatisgcxlogin
{
	position: relative;
	z-index: 10;
	left: 25px;
	border: 2px dotted #FFC400;
	width: 400px;
	background: white;
	padding: 10px;
}

.NotShowed
{
	display: none;
}

.Showed
{
	display: block;
}


/* footer (placed directly below the white box) --------------------------*/
#footer {
	width: 500px;
	margin: 23px auto 0px auto;
	color: #FFFFFF;
	text-align: right;
	}

-->
</style>

<script>
/* Script for the What is GCX box */
function ShowWhatIsGCX()
{
	var divWIG = document.getElementById("whatisgcxlogin");
	if(divWIG.className == "NotShowed") divWIG.className = "Showed";
	else divWIG.className = "NotShowed";
}

</script>

<!-- wrap begins -->
<div id="wrap">

	<!-- c4c logo (placed in header) begins -->
	<div id="c4clogo">
		<img src="<?=$pageContent->pathToRoot;?>../../Images/loggin_screen_c4clogo.gif" alt="Campus for Christ" width="500" height="176">
	</div><!-- c4c logo ends -->
	
	<!-- yellow bar -->
	<div id="yellowbar"></div>
	
	<!-- white box (with GCX login/get started buttons) begins -->
	<div id="whitebox">
		<img id="wcLogo" src="<?=$pageContent->pathToRoot;?>../../Images/loggin_screen_wcLogo.gif" alt="Winter Conference Logo" />
		<span id="registerForWC">
			Register for <span id="WCBlue">Winter Conference:</span>
		</span>
		
		<div id="gcxSection">
			<img id="gcxlogo" src="<?=$pageContent->pathToRoot;?>../../Images/loggin_screen_GCXlogo.gif" alt="GCX" />
			<a id="loginWithGXC" href="<?php print CASUser::login_link() ?>">Log-in with GCX</a>		
			<span id="createGcxAccount">
				If you don't have an existing GCX identity: <a href="https://signin.mygcx.org/sso/selfservice/ssoSignup.jsp">Create an Account</a>
			</span>
			<a id='whatisgcxlink' href='javascript:ShowWhatIsGCX();'>What is GCX login?</a>
			<div style='position: relative;'>
				<div id='whatisgcxlogin' class='NotShowed'>
					<div style="float:right"><a href='javascript:ShowWhatIsGCX();'>close</a></div><h2>What is GCX login?</h2>
					GCX is a single sign on login that authenticates you to use Campus for Christ web applications including:
					<ul>
						<li><a target='_blank' href='https://pulse.campusforchrist.org/'>Pulse</a></li>
						<li><a target='_blank' href='https://pat.powertochange.org/'>Project Application Tool</a></li>
						<li><a target='_blank' href='http://intranet.campusforchrist.org/'>Registration/Intranet</a></li>
						<li><a target='_blank' href='http://resources.campusforchrist.org/'>Resources</a></li>
						<li><a target='_blank' href='http://mpdtool.powertochange.org/'>MPD Tool</a></li>
					</ul>
					Your GCX username will authenticate you to all these sites using one login.  You do not have to create a new one each time!  Contact us at <a href='mailto:helpdesk@c4c.ca'>helpdesk@c4c.ca</a> if you have any questions about your GCX username. <br/>Thank you!
				</div>
			</div>
	  </div>
	
	</div><!-- white box ends -->

	<div id="footer">
		Copyright 2009 Campus for Christ
	</div>

</div><!-- wrap ends -->

















