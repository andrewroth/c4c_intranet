<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html><!-- InstanceBegin template="/Templates/documentation_index.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<!-- InstanceBeginEditable name="doctitle" -->
<title>Untitled Document</title>
<!-- InstanceEndEditable --><link href="../../Data/CSS/documentation.css" rel="stylesheet" type="text/css">
<!-- InstanceBeginEditable name="head" -->
<script language="JavaScript" type="text/JavaScript">
<!--


<!--

<!--
function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}

function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}
//-->
</script>
<!-- InstanceEndEditable -->
</head>

<body onLoad="MM_preloadImages('../images/root_f2.gif','../images/index_f2.gif','../images/data_f2.gif','../images/general_f2.gif','../images/siteimages_f2.gif','../images/modules_f2.gif','../images/objects_f2.gif','../images/classes_f2.gif','../images/tools_f2.gif','../images/documentation_f2.gif','../images/templates_f2.gif','../images/test_f2.gif')">
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
			
		?><!-- InstanceBeginEditable name="NavBar" -->&gt; Structure &gt; File Layout<!-- InstanceEndEditable --></td>
    </tr>
    <tr>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td class="content_text" ><!-- InstanceBeginEditable name="Content" -->
        <h1>Asia Impact Programming API</h1>
		<h2>Structure</h2>
		<h3>File Layout</h3>
		<p class="text">The physical layout of the web site is as follows:</p>
		<table width="100%" border="0" cellspacing="2" cellpadding="2">
		    <tr>
		        <td bgcolor="#CCCCCC" ><table width="100%" border="0" cellpadding="2" cellspacing="2" class="text">
		    <tr>
		        <td colspan="2" class="unnamed1"><a href="#" onMouseOver="MM_swapImage('root','','../images/root_f2.gif',1)" onMouseOut="MM_swapImgRestore()">Root Directory</a></td>
		        </tr>
		    <tr>
		        <td width="10">&nbsp;</td>
		        <td><p>The root directory of the site. When passing path arguments between
		                applications/objects, they are generally based on the path
		                from the root. </p>
		            <p>The root directory contains several index files as well:
					   <ul><li><a href="#" onMouseOver="MM_swapImage('index','','../images/index_f2.gif',1)" onMouseOut="MM_swapImgRestore()">index.html</a>: The initial page loaded for the site. This
		                    page simply creates a framset that is used to hide
		                the actual URLs of the pages from
		                    the viewer of the site.</li>
					   </ul>
							<ul>
							    <li><a href="#" onMouseOver="MM_swapImage('index','','../images/index_f2.gif',1)" onMouseOut="MM_swapImgRestore()">index.php</a>:
							        The control page for the site. This page
							        is called with the name of the application/module
							        as a parameter and it loads that application/module
							        and runs it.</li>
							</ul>
							<ul>
							<li><a href="#" onMouseOver="MM_swapImage('index','','../images/index_f2.gif',1)" onMouseOut="MM_swapImgRestore()">index_notice.html</a>:
							    A place holder for the index.html file when you
							    want to take the site offline. It is setup to
							    remove the login info and display a notice.</li>
							</ul>
							<ul>
							<li><a href="#" onMouseOver="MM_swapImage('index','','../images/index_f2.gif',1)" onMouseOut="MM_swapImgRestore()">index_orig.html</a>:
							    A backup of the index.html file. It is easy to
							    overwrite index.html when you are replacing it
							    with index_notice.html.</li>
							</ul>
							</p></td>
		        </tr>
			<tr>
		        <td colspan="2" class="unnamed1"> <a href="#" onMouseOver="MM_swapImage('data','','../images/data_f2.gif',1)" onMouseOut="MM_swapImgRestore()">/Data</a></td>
		        </tr>
		    <tr>
		        <td>&nbsp;</td>
		        <td>A directory for the commonly shared data items found through out
		            the web site. Examples include the /Data/CSS/ style sheet definitions
		            for the web site.</td>
		        </tr>
		    <tr>
		        <td colspan="2" class="unnamed1"><a href="#" onMouseOver="MM_swapImage('general','','../images/general_f2.gif',1)" onMouseOut="MM_swapImgRestore()">/General</a></td>
		        </tr>
		    <tr>
		        <td>&nbsp;</td>
		        <td>The commonly shared definitions and the General Include file for
		            all pages on the site are located in this directory</td>
		        </tr>
		    <tr>
		        <td colspan="2" class="unnamed1"><a href="#" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('siteimages','','../images/siteimages_f2.gif',1);">/Images</a></td>
		        </tr>
		    <tr>
		        <td>&nbsp;</td>
		        <td>A directory for the commonly shared images found through out the
		            web site. Examples include commonly shared images of buttons, etc...</td>
		        </tr>
			<tr>
		        <td colspan="2" class="unnamed1"> <a href="#" onMouseOver="MM_swapImage('modules','','../images/modules_f2.gif',1)" onMouseOut="MM_swapImgRestore()">/modules</a></td>
		        </tr>
		    <tr>
		        <td>&nbsp;</td>
		        <td>A directory that holds all the modules that have been created for
		            this site. A module is a web application and all it's supporting
		            files + images + objects + templates.</td>
		        </tr>
			<tr>
		        <td colspan="2" class="unnamed1"> <a href="#" onMouseOver="MM_swapImage('objects','','../images/objects_f2.gif',1)" onMouseOut="MM_swapImgRestore()">/objects</a></td>
		        </tr>
		    <tr>
		        <td>&nbsp;</td>
		        <td>This directory contains all the objects created for the general
		            operation of the site. <ul><li>If an object is created and it is
		            intended to be called and used across multiple modules/applications,
		            then it should be stored here.</li></ul><ul> <li>If an object/function is developed
		            that is considered a service of the basic web site (user
		            login, CMS functions, Page display, XML generation, etc....)
		            they should also be stored here.</li></ul></td>
		        </tr>
		    
		    <tr>
		        <td>&nbsp;</td>
		        <td>&nbsp;</td>
		        </tr>
		    <tr>
		        <td colspan="2">Previous site compatibility</td>
		        </tr>
		    <tr>
		        <td>&nbsp;</td>
		        <td><p>The following directories are left over from our previous site
		                layout and usage. </p>
		            <table width="100%" border="0" cellspacing="2" cellpadding="2">
		                <tr>
                            <td colspan="2" class="unnamed1"><a href="#" onMouseOver="MM_swapImage('classes','','../images/classes_f2.gif',1)" onMouseOut="MM_swapImgRestore()">/Classes </a></td>
		                    </tr>
		                <tr>
                            <td>&nbsp;</td>
                            <td class="text">The commonly shared classes for
                                use by all the pages in the site is located in
                                this directory.</td>
		                    </tr>
					<tr>
		        <td colspan="2" class="unnamed1">/Application</td>
		        </tr>
		    <tr>
		        <td width="10" >&nbsp;</td>
		        <td class="text">Other applications that have been developed are in their own directory
		            in the root directory. Examples include: /Admin, /CMS, /ConfReg,
		            /HRDB, etc... </td>
		        </tr>
		    <tr>
		        <td colspan="2" class="unnamed1">/Static</td>
		        </tr>
		    <tr>
		        <td width="10">&nbsp;</td>
		        <td class="text">The static pages that are developed by other regions/users are
		            located in this directory.</td>
		        </tr>
		    <tr>
                <td colspan="2" class="unnamed1">/<a href="#" onMouseOver="MM_swapImage('tools','','../images/tools_f2.gif',1)" onMouseOut="MM_swapImgRestore()">tools</a></td>
		        </tr>
		    <tr>
                <td width="10">&nbsp;</td>
                <td class="text">A set of global functions intended to be used
                    across the web site. QueryString tools, Unicode text conversion
                    tools, etc...</td>
		        </tr>
		                <tr>
		                    <td>&nbsp;</td>
		                    <td>&nbsp;</td>
		                    </tr>
		                </table>		            <p>You should develop your applicaitons/tools
		                    in the new manner and not continue to contribute to these
		                    depreciated methods/tools.</p></td>
		        </tr>
		    </table></td>
		        <td valign="top" bgcolor="#999999" ><table border="0" cellpadding="0" cellspacing="0" width="212">
<!-- fwtable fwsrc="api_structure_filelayout.png" fwbase="api_structure_filelayout.gif" fwstyle="Dreamweaver" fwdocid = "742308039" fwnested="0" -->
  <tr>
   <td><img src="../images/spacer.gif" width="212" height="1" border="0" alt=""></td>
   <td><img src="../images/spacer.gif" width="1" height="1" border="0" alt=""></td>
  </tr>

  <tr>
   <td><img name="api_structure_fi_r1_c1" src="../images/api_structure_fi_r1_c1.gif" width="212" height="17" border="0" alt=""></td>
   <td><img src="../images/spacer.gif" width="1" height="17" border="0" alt=""></td>
  </tr>
  <tr>
   <td><a href="#" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('root','','../images/root_f2.gif',1);"><img name="root" src="../images/root.gif" width="212" height="21" border="0" alt=""></a></td>
   <td><img src="../images/spacer.gif" width="1" height="21" border="0" alt=""></td>
  </tr>
  <tr>
   <td><a href="#" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('classes','','../images/classes_f2.gif',1);"><img name="classes" src="../images/classes.gif" width="212" height="18" border="0" alt=""></a></td>
   <td><img src="../images/spacer.gif" width="1" height="18" border="0" alt=""></td>
  </tr>
  <tr>
   <td><img name="api_structure_fi_r4_c1" src="../images/api_structure_fi_r4_c1.gif" width="212" height="19" border="0" alt=""></td>
   <td><img src="../images/spacer.gif" width="1" height="19" border="0" alt=""></td>
  </tr>
  <tr>
   <td><a href="#" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('data','','../images/data_f2.gif',1);"><img name="data" src="../images/data.gif" width="212" height="19" border="0" alt=""></a></td>
   <td><img src="../images/spacer.gif" width="1" height="19" border="0" alt=""></td>
  </tr>
  <tr>
   <td><a href="#" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('documentation','','../images/documentation_f2.gif',1);"><img name="documentation" src="../images/documentation.gif" width="212" height="19" border="0" alt=""></a></td>
   <td><img src="../images/spacer.gif" width="1" height="19" border="0" alt=""></td>
  </tr>
  <tr>
   <td><a href="#" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('general','','../images/general_f2.gif',1);"><img name="general" src="../images/general.gif" width="212" height="19" border="0" alt=""></a></td>
   <td><img src="../images/spacer.gif" width="1" height="19" border="0" alt=""></td>
  </tr>
  <tr>
   <td><a href="#" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('siteimages','','../images/siteimages_f2.gif',1);"><img name="siteimages" src="../images/siteimages.gif" width="212" height="19" border="0" alt=""></a></td>
   <td><img src="../images/spacer.gif" width="1" height="19" border="0" alt=""></td>
  </tr>
  <tr>
   <td><a href="#" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('index','','../images/index_f2.gif',1);"><img name="index" src="../images/index.gif" width="212" height="76" border="0" alt=""></a></td>
   <td><img src="../images/spacer.gif" width="1" height="76" border="0" alt=""></td>
  </tr>
  <tr>
   <td><a href="#" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('modules','','../images/modules_f2.gif',1);"><img name="modules" src="../images/modules.gif" width="212" height="19" border="0" alt=""></a></td>
   <td><img src="../images/spacer.gif" width="1" height="19" border="0" alt=""></td>
  </tr>
  <tr>
   <td><a href="#" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('objects','','../images/objects_f2.gif',1);"><img name="objects" src="../images/objects.gif" width="212" height="19" border="0" alt=""></a></td>
   <td><img src="../images/spacer.gif" width="1" height="19" border="0" alt=""></td>
  </tr>
  <tr>
   <td><a href="#" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('templates','','../images/templates_f2.gif',1);"><img name="templates" src="../images/templates.gif" width="212" height="19" border="0" alt=""></a></td>
   <td><img src="../images/spacer.gif" width="1" height="19" border="0" alt=""></td>
  </tr>
  <tr>
   <td><a href="#" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('test','','../images/test_f2.gif',1);"><img name="test" src="../images/test.gif" width="212" height="19" border="0" alt=""></a></td>
   <td><img src="../images/spacer.gif" width="1" height="19" border="0" alt=""></td>
  </tr>
  <tr>
   <td><a href="#" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('tools','','../images/tools_f2.gif',1);"><img name="tools" src="../images/tools.gif" width="212" height="21" border="0" alt=""></a></td>
   <td><img src="../images/spacer.gif" width="1" height="21" border="0" alt=""></td>
  </tr>
</table></td>
		        </tr>
		    </table>
		
		<p class="text">So when you create a new scripted application, it should be
		    packaged and placed under the /modules directory. Name the directory
		    it is in after the name of the application: ex: /modules/translation</p>
		<hr align="center" size="1">
		<div align="right" class="text">
		    <p class="unnamed2"><a href="struct_appLayout.php">Next > Application Layout</a></p>
		</div>
		<p class="text">&nbsp;</p>
        <!-- InstanceEndEditable -->
		</td>
    </tr>
</table>

</center>

</body>
<!-- InstanceEnd --></html>
