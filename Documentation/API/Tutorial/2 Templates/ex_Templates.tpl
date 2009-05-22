<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
</head>

<body>
<table width="50%"  border="1" cellspacing="1" cellpadding="1">
    <tr>
        <th scope="col">ID</th>
        <th scope="col">Labels</th>
    </tr>
<?php
    
    // for each of the entries passed in
    for ($indx=0; $indx<count( $listID ); $indx++) {
    
        // display the HTML for the row ...
        echo '<tr>
        <td>'.$listID[ $indx ].'</td>
        <td>'.$listLabels[ $indx ]."</td>
    </tr>\n";
    
    }
    
?>
</table>
</body>
</html>