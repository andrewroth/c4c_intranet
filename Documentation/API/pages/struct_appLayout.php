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

<body onLoad="MM_preloadImages('../images/app_module_f2.gif','../images/app_applications_f2.gif','../images/app_data_f2.gif','../images/app_images_f2.gif','../images/app_app_f2.gif','../images/app_include_f2.gif','../images/app_objects_f2.gif','../images/app_templates_f2.gif')">
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
		<h3>Application Layout</h3>
		<p class="text">Creating an application for the web site involves creating
		    a Module.</p>
		<p class="text">Each module is stored under the main <a href="#" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('app_module','','../images/app_module_f2.gif',1);">/modules</a> directory in
		    it's own folder. The layout of a module's folder is as follows:</p>
		<table width="100%" border="0" cellspacing="2" cellpadding="2">
		    <tr>
		        <td valign="top" bgcolor="#CCCCCC" ><table width="100%" border="0" cellpadding="2" cellspacing="2" class="text">
		    <tr>
		        <td colspan="2" class="unnamed1"><a href="#" onMouseOver="MM_swapImage('app_applications','','../images/app_applications_f2.gif',1)" onMouseOut="MM_swapImgRestore()">Application/Module Directories</a></td>
		        </tr>
		    <tr>
		        <td width="10">&nbsp;</td>
		        <td valign="top"><p>Each Application (or Module) is stored in it's own directory
		                under the main /module directory. The name of the directory
		                is named after the function of the module.</p>
		            <p>Each Applicaiton can contain the following items/folders:</p>
		            <table width="100%" border="0" cellspacing="2" cellpadding="2">
                        <tr>
                            <td colspan="2" class="unnamed1"><a href="#" onMouseOver="MM_swapImage('app_data','','../images/app_data_f2.gif',1)" onMouseOut="MM_swapImgRestore()">/data</a></td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td valign="top" class="text"><p>A folder to store the data that
                                    is unique to this Application/Modules operation.
                                    </p>
                                <p>For example, a FileUpload module might store
                                        all the uploaded files in this directory.</p></td>
                        </tr>
                        <tr>
                            <td colspan="2" class="unnamed1"><a href="#" onMouseOver="MM_swapImage('app_images','','../images/app_images_f2.gif',1)" onMouseOut="MM_swapImgRestore()">/images</a></td>
                        </tr>
                        <tr>
                            <td width="10" >&nbsp;</td>
                            <td class="text">Images, icons, or other display
                                items that this module uses.</td>
                        </tr>
                        <tr>
                            <td colspan="2" class="unnamed1"><a href="#" onMouseOver="MM_swapImage('app_app','','../images/app_app_f2.gif',1)" onMouseOut="MM_swapImgRestore()">/&lt;appname&gt;_app.php</a></td>
                        </tr>
                        <tr>
                            <td width="10">&nbsp;</td>
                            <td class="text">The main controller module for your
                                application. This is the set of code that will
                                carry your application through the process of
                                loading data, processing that data, and preparing
                                the information for display.</td>
                        </tr>
                        <tr>
                            <td colspan="2" class="unnamed1"><a href="#" onMouseOver="MM_swapImage('app_include','','../images/app_include_f2.gif',1)" onMouseOut="MM_swapImgRestore()">/&lt;appname&gt;_include.php</a></td>
                        </tr>
                        <tr>
                            <td width="10">&nbsp;</td>
                            <td class="text">This is the list of additional objects
                                that need to be included for your module to function
                                properly.</td>
                        </tr>
                        <tr>
                            <td colspan="2" class="unnamed1"><a href="#" onMouseOver="MM_swapImage('app_objects','','../images/app_objects_f2.gif',1)" onMouseOut="MM_swapImgRestore()">/objects</a></td>
                            </tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td class="text">All the classes, objects and functions created
                                for the proper operation of your module are kept
                                in this directory.</td>
                        </tr>
                        <tr>
                            <td colspan="2" class="unnamed1"><a href="#" onMouseOver="MM_swapImage('app_templates','','../images/app_templates_f2.gif',1)" onMouseOut="MM_swapImgRestore()">/templates</a></td>
                            </tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td class="text">Any template files for the proper display of
                                your module's data are kept here.</td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>
                    </table>		            </p></td>
		        </tr>
			<tr>
		        <td colspan="2" class="unnamed1">&nbsp; </td>
		        </tr>
		    </table></td>
		        <td valign="top" bgcolor="#999999" ><table border="0" cellpadding="0" cellspacing="0" width="216">
<!-- fwtable fwsrc="api_structure_appLayout.png" fwbase="api_structure_appLayout.gif" fwstyle="Dreamweaver" fwdocid = "742308039" fwnested="0" -->
  <tr>
   <td><img src="../images/spacer.gif" width="216" height="1" border="0" alt=""></td>
   <td><img src="../images/spacer.gif" width="1" height="1" border="0" alt=""></td>
  </tr>

  <tr>
   <td><img name="api_structure_ap_r1_c1" src="../images/api_structure_ap_r1_c1.gif" width="216" height="36" border="0" alt=""></td>
   <td><img src="../images/spacer.gif" width="1" height="36" border="0" alt=""></td>
  </tr>
  <tr>
   <td><a href="#" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('app_module','','../images/app_module_f2.gif',1);"><img name="app_module" src="../images/app_module.gif" width="216" height="21" border="0" alt=""></a></td>
   <td><img src="../images/spacer.gif" width="1" height="21" border="0" alt=""></td>
  </tr>
  <tr>
   <td><a href="#" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('app_applications','','../images/app_applications_f2.gif',1);"><img name="app_applications" src="../images/app_applications.gif" width="216" height="36" border="0" alt=""></a></td>
   <td><img src="../images/spacer.gif" width="1" height="36" border="0" alt=""></td>
  </tr>
  <tr>
   <td><a href="#" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('app_data','','../images/app_data_f2.gif',1);"><img name="app_data" src="../images/app_data.gif" width="216" height="19" border="0" alt=""></a></td>
   <td><img src="../images/spacer.gif" width="1" height="19" border="0" alt=""></td>
  </tr>
  <tr>
   <td><a href="#" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('app_images','','../images/app_images_f2.gif',1);"><img name="app_images" src="../images/app_images.gif" width="216" height="20" border="0" alt=""></a></td>
   <td><img src="../images/spacer.gif" width="1" height="20" border="0" alt=""></td>
  </tr>
  <tr>
   <td><a href="#" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('app_app','','../images/app_app_f2.gif',1);"><img name="app_app" src="../images/app_app.gif" width="216" height="19" border="0" alt=""></a></td>
   <td><img src="../images/spacer.gif" width="1" height="19" border="0" alt=""></td>
  </tr>
  <tr>
   <td><a href="#" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('app_include','','../images/app_include_f2.gif',1);"><img name="app_include" src="../images/app_include.gif" width="216" height="19" border="0" alt=""></a></td>
   <td><img src="../images/spacer.gif" width="1" height="19" border="0" alt=""></td>
  </tr>
  <tr>
   <td><a href="#" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('app_objects','','../images/app_objects_f2.gif',1);"><img name="app_objects" src="../images/app_objects.gif" width="216" height="18" border="0" alt=""></a></td>
   <td><img src="../images/spacer.gif" width="1" height="18" border="0" alt=""></td>
  </tr>
  <tr>
   <td><a href="#" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('app_templates','','../images/app_templates_f2.gif',1);"><img name="app_templates" src="../images/app_templates.gif" width="216" height="20" border="0" alt=""></a></td>
   <td><img src="../images/spacer.gif" width="1" height="20" border="0" alt=""></td>
  </tr>
  <tr>
   <td><img name="api_structure_ap_r10_c1" src="../images/api_structure_ap_r10_c1.gif" width="216" height="75" border="0" alt=""></td>
   <td><img src="../images/spacer.gif" width="1" height="75" border="0" alt=""></td>
  </tr>
</table>
</td>
		        </tr>
		    </table>
		
		<p class="text">&nbsp;</p>
		<!-- InstanceEndEditable -->
		</td>
    </tr>
</table>

</center>

</body>
<!-- InstanceEnd --></html>
