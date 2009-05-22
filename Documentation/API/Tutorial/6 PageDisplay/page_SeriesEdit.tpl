<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Edit Series</title>
<style type="text/css">
<!--
.style1 {color: #FF0000}
-->
</style>
</head>
<body>
<h1>Edit Series:</h1>
<form action="<? echo $formAction; ?>" method="post">
<table width="300" border="0" cellspacing="2" cellpadding="2">
<?php
    // for each field
    for ($indx=0; $indx<count( $formFields ); $indx++) {
        $key = $formFields[ $indx ];
        
        // start Row
        echo '<tr>';
        
        // print Field Label
        echo '<td valign="top" >'.$key.'</td>';
        
        
        // open Form Entry Column
        echo '<td valign="top" >';
        
        // print Form Entry 
        echo '<input name="'.$key.'" type="text" value="'.$formValues[ $key ].'" />';
        
        // if an error for this form Item exists, then display it:
        if ( isset( $formErrors[ $key ] ) ) {
            echo '<br><span class="style1">'.$formErrors[$key].'</span>';
        }
        
        // close Form Entry Column
        echo '</td>';
        
        // close Row
        echo '</tr>';
        
    }
?>
</table>
<input name="submit" type="submit" />
</form>
</body>
</html>