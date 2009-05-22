<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<!-- TemplateBeginEditable name="doctitle" -->
<title>Untitled Document</title>
<!-- TemplateEndEditable --><link href="../Documentation/Data/CSS/documentation.css" rel="stylesheet" type="text/css">
<!-- TemplateBeginEditable name="head" --><!-- TemplateEndEditable -->
</head>

<body>
<center>
<table width="680" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td><table width="100%"  border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td><img src="../Documentation/Images/page_header.gif"></td>
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
			
		?><!-- TemplateBeginEditable name="NavBar" -->NavBar<!-- TemplateEndEditable --></td>
    </tr>
    <tr>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td class="content_text" ><!-- TemplateBeginEditable name="Content" --><h1>Big Title</h1>
		<h2>Title</h2>
		<h3>Sub Title</h3>
		<h4>Sub Sub Title</h4>
		<p class="content_text" >Content here</p><!-- TemplateEndEditable -->
		</td>
    </tr>
</table>

</center>

</body>
</html>
