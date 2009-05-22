<?PHP

/*
 * page_SeriesList.tpl
 *
 * This template displays a set of data as a list.
 *
 * Required Template Variables:
 *  $linkValues :   Array of link href values. linkValue[ 'key' ] = 'href';
 *  $dataFieldList :    Array of fields processed by this form.
 *  $dataList   :   The XML data to display in the list
 */

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
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
        for ($indx=0; $indx<count( $dataFieldList ); $indx++) {
            echo '<td bgcolor="#666666"><span class="text_white">'.$dataFieldList[ $indx ].'</span></td>';
        }

        // if an edit link was provided then
        if ( isset( $linkValues['edit'] ) ) {
            
            // add on an extra column for the edit links
            echo '<td bgcolor="#666666">&nbsp;</td>';
        }
?>
     </tr>
<?php

    foreach( $dataList as $key=>$value ) {
    
        // Start the Row
        echo "     <tr>\n";
        
        // for each requested field to display, print out that column data
        for ($indx=0; $indx<count( $dataFieldList ); $indx++) {
        
            $fieldKey = $dataFieldList[ $indx ];
            
            echo '<td valign="top" >' . $value[ $fieldKey ] . '</td>';
        
        }
        
        // if an edit link was provided then
        if ( isset( $linkValues['edit'] ) ) {
            
            // Show the Edit Link
            echo '<td valign="top" ><a href="'.$linkValues['edit'].$key.'">Edit</a></td>';
        }

        
        // End the Row
        echo "</tr>\n";
    
    }
    
?>
 </table>
</body>
</html>