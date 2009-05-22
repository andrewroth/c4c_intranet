<h1>Add Series:</h1>
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
        echo '<input name="'.$key.'" type="text" value="'.$value.'" />';
        
        // if an error for this form Item exists, then display it:
        if ( isset( $formErrors[ $key ] ) ) {
            echo '<br><span class="error">'.$formErrors[$key].'</span>';
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
