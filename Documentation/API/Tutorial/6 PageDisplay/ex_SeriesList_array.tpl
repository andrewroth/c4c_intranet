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
<?php

        // Now for each desired field to display, print out the header
        for ($indx=0; $indx<count( $showFields ); $indx++) {
            echo '<td bgcolor="#666666"><span class="text_white">'.$showFields[ $indx ].'</span></td>';
        }

        // Next be sure to add an additional column for the Edit links
?>
         <td bgcolor="#666666">&nbsp;</td>
     </tr>
<?php

    foreach( $seriesList as $key=>$value ) {
    
        // Start the Row
        echo "     <tr>\n";
        
        // for each requested field to display, print out that column data
        for ($indx=0; $indx<count( $showFields ); $indx++) {
        
            $fieldKey = $showFields[ $indx ];
            
            echo '<td valign="top" >' . $value[ $fieldKey ] . '</td>';
        
        }
        
        // Show the Edit Link
        echo '<td valign="top" ><a href="'.$editLink.$key.'">Edit</a></td>';
        
        // End the Row
        echo "</tr>\n";
    
    }
    
?>
 </table>
</body>
</html>