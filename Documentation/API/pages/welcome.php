<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html><!-- InstanceBegin template="/Templates/documentation_index.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<!-- InstanceBeginEditable name="doctitle" -->
<title>Untitled Document</title>
<!-- InstanceEndEditable --><link href="../../Data/CSS/documentation.css" rel="stylesheet" type="text/css">
<!-- InstanceBeginEditable name="head" --><!-- InstanceEndEditable -->
</head>

<body>
<center>
<table width="680" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td><table width="100%"  border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td><img src="../../Images/page_header.gif"></td>
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
			
		?><!-- InstanceBeginEditable name="NavBar" --> <!-- InstanceEndEditable --></td>
    </tr>
    <tr>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td class="content_text" ><!-- InstanceBeginEditable name="Content" -->
        <h1>Asia Impact Programming API</h1>
		<h3><a name="Intro">Welcome</a></h3>
		<p>Welcome to Asia Impact&rsquo;s Programming API. In this document we will try to cover the design philosophy, site layout, and how to use our shared code in your own programs. It is intended that this document would help prepare you to quickly adapt to and be productive in developing applications for AI&rsquo;s web site.</p>
		<h3>Conventions<a name="Conventions"></a></h3>
        <p>In this document, we will use several typographical standards through out:</p>
        <p>Programming Code will be in a mono spaced format:<table class="sourcecodebox">
                    <tr><td class="sourcecodebox">for ($indx=0; $indx &lt; $numberDays; $indx++) {<br>
    &nbsp;&nbsp;&nbsp;&nbsp;$count += 4;<br>
    }</td></tr>
        </table>
        <p>Function parameters that are optional will be in italics:</p>
		<table class="sourcecodebox">
          <tr><td class="sourcecodebox">calculateDistance( $startLocation, $endLocation, <em>$metricUnit</em>);</td>
          </tr>
        </table>
		<p>When indicating some text that you are to fill in yourselves, I will enclose them in &lt;text&gt;. <br>
            For Example: <span class="sourcecodebox">class_&lt;Name&gt;.php</span> can be <span class="sourcecodebox">class_Email.php</span>, <span class="sourcecodebox">class_Table.php</span>, etc... You need to replace &lt;Name&gt; with your text.</p>
        <!-- InstanceEndEditable -->
		</td>
    </tr>
</table>

</center>

</body>
<!-- InstanceEnd --></html>
