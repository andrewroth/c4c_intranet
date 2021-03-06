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

?>
 <h1>Current TV Addictions:</h1>
 <table width="300" border="0" cellspacing="2" cellpadding="2">
     <tr>
<?php

        // Now for each desired field to display, print out the header
        for ($indx=0; $indx<count( $dataFieldList ); $indx++) {
            echo '<td bgcolor="#666666"><span class="text_white">'.$dataFieldList[ $indx ].'</span></td>';
        }

        $hasEditColumn = false;
        // if an edit link was provided then
        if (( isset( $linkValues['edit'] ) ) || (isset( $linkValues['del'] )) ) {
            
            $hasEditColumn = true;
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
        
        if ($hasEditColumn) {
        
            echo '<td valign="top" >';
            
            // if an edit link was provided then
            if ( isset( $linkValues['edit'] ) ) {
                
                // Show the Edit Link
                echo '<a href="'.$linkValues['edit'].$key.'">Edit</a>';
                
                if ( isset( $linkValues['del'] ) ) {
                    echo '&nbsp;/&nbsp;';
                }
            }
            
            
            // if a delete link was provided then
            if ( isset( $linkValues['del'] ) ) {
                
                // Show the Del Link
                echo '<a href="'.$linkValues['del'].$key.'">Del</a> ';
            }
            
            echo '</td>';
        
        }

        
        // End the Row
        echo "</tr>\n";
    
    }
    
    // if an Add link was provided then
    if ( isset( $linkValues['add'] ) ) {
        
        echo '<tr><td>';
        echo '<a href="'.$linkValues['add'].'">ADD</a> ';
        echo '</td><td>&nbsp;</td></tr>';
    }

    
?>
 </table>