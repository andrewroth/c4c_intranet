<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html><!-- InstanceBegin template="/Templates/documentation_index.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<!-- InstanceBeginEditable name="doctitle" -->
<title>AI Documentation</title>
<!-- InstanceEndEditable --><link href="Data/CSS/documentation.css" rel="stylesheet" type="text/css">
<!-- InstanceBeginEditable name="head" --><!-- InstanceEndEditable -->
</head>

<body>
<center>
<table width="680" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td><table width="100%"  border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td><img src="Images/page_header.gif"></td>
		<td width="200">&nbsp;</td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
    </tr>
</table>
</td>
    </tr>
    <tr>
        <td bgcolor="#CCCCCC">&nbsp;</td>
    </tr>
    <tr>
        <td class="text_navbar"><? 
			/*
			 * Find the path to the Documentation Root ...
			 */
			$pathToRoot = ''; 
			for ( $indx=0; $indx<20 && !file_exists( $pathToRoot.'Data/CSS/documentation.css'); $indx++ ) {
				$pathToRoot .= '../';
			}

		echo '<a href="'.$pathToRoot.'index.php" target="_top">AI Doc</a> &gt; <a href="'.$pathToRoot.'/API/index.html">API</a>';
			
		?><!-- InstanceBeginEditable name="NavBar" --><a href="#">AI Doc</a><!-- InstanceEndEditable --></td>
    </tr>
    <tr>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td class="content_text" ><!-- InstanceBeginEditable name="Content" -->
        <h1>Asia Impact Documentation Center </h1>
		<h3>Welcome</h3>
		<p>This is an attempt to get our hands around the growing needs to document the AI web site development process. Here we will attempt to provide you with our Programming APIs, as well as the development design and logic behind our major systems.</p>
		<h3>Where to Start<hr size="1"></h3>
		
		 <table width="100%"  border="0" cellpadding="0" cellspacing="4" class="content_text">
             <tr valign="top">
                 <td width="33%"><a href="API/index.htm">API Documentation</a> <br>
                     An overview of the programming style and methods used to develop our web site.</td>
                 <td width="33%">&nbsp;</td>
                 <td>&nbsp;</td>
             </tr>
         </table>
        <!-- InstanceEndEditable -->
		</td>
    </tr>
</table>

</center>

</body>
<!-- InstanceEnd --></html>
