<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Addiction List</title>
<style type="text/css">
<!--
.text_white {color: #FFFFFF}
-->
</style>
</head>
<body>
 <h1>Current TV Addictions:</h1>
 <table width="300" border="0" cellspacing="2" cellpadding="2">
     <tr>
         <td bgcolor="#666666"><span class="text_white">Series</span></td>
         <td bgcolor="#666666">&nbsp;</td>
     </tr>
<?php

    foreach( $seriesList as $key=>$value ) {
    
        echo '     <tr>
         <td>' . $value . '</td>
         <td><a href="'.$editLink.$key.'">Edit</a></td>
     </tr>'."\n";
    
    }
    
?>
 </table>
</body>
</html>