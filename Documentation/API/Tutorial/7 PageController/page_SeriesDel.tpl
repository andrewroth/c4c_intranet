<h1>Delete Series:</h1>
<form action="<? echo $formAction; ?>" method="post">
<input name="<? echo AppController::FORM_KEY_PROCESS; ?>" type="hidden" id="Process" value="T" />
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
        $value = '';
        if ( isset( $formValues[ $key ] ) ) {
            $value = $formValues[ $key ];
        }
        echo $value;
        
        
        // close Form Entry Column
        echo '</td>';
        
        // close Row
        echo '</tr>';
        
    }
?>
<tr><td><input type="submit" name="Submit" value="Yes"></td><td><input type="submit" name="Submit" value="No"></td></tr>
</table>
</form>
