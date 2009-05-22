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
	<tr><td>&nbsp;</td></tr>
    <tr>
        <td><table width="100%"  border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td class="content_text"><!-- TemplateBeginEditable name="prevButtonTop" --><a href="#">Previous</a><!-- TemplateEndEditable --></td>
        <td class="content_text"><div align="right"><!-- TemplateBeginEditable name="nextButtonTop" --><a href="#">Next</a><!-- TemplateEndEditable --></div></td>
    </tr>
</table>
</td>
    </tr>
    <tr>
        <td class="content_text" ><hr size="1" noshade >
            <!-- TemplateBeginEditable name="Content" --><h1>Big Title</h1>
		<p class="content_text" >This is the Big Idea of this step of the tutorial. </p>
		<h4>What To Do</h4>
		<p class="content_text" >Explain what you will do in this step of the tutorial </p>
		<h4>Explanation of Code</h4>
		<p class="content_text" >here we step through the code to implement this step.</p>
		<span class="sourcecodebox" ><pre>
$a = 1 + $b; 
$b = new Object( $a );</pre></span>
		<h4>Links To Code Examples</h4>
		<table width="100%"  border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td><a href="#"><img src="../Documentation/Images/icn_filePHP.gif" width="24" height="31" border="0"></a></td>
                <td><a href="#"><img src="../Documentation/Images/icn_filePHP.gif" width="24" height="31" border="0"></a></td>
            </tr>
            <tr>
                <td><a href="#">filename.php</a></td>
                <td><a href="#">filename.php</a></td>
            </tr>
        </table>
		<p class="content_text" >&nbsp;</p>
            <!-- TemplateEndEditable --><hr size="1" noshade>
		 </td>
    </tr>
	<tr><td><table width="100%"  border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td class="content_text"><!-- TemplateBeginEditable name="prevButtonBottom" --><a href="#">Previous</a><!-- TemplateEndEditable --></td>
        <td class="content_text"><div align="right"><!-- TemplateBeginEditable name="nextButtonBottom" --><a href="#">Next</a><!-- TemplateEndEditable --></div></td>
    </tr>
</table></td>
	</tr>
</table>
</center>

</body>
</html>
