<?

$toolName = 'objects/TemplateTools.php';
$toolPath = Page::findPathExtension( $toolName );
require_once( $toolPath.$toolName);

/*
 * GenericForm.tpl.php
 *
 * This template displays a Single Entry form.  This type of form displays
 * a row for each field is is gathering data for. Each row has a label, and
 * a form item.
 *
 * Required Template Variables:
 *  $formAction :   The action for the submitted form.
 *
 *  $eventName - textual description of the event being signed up for
 *  $form - an FormHelper object that contains all the necessary data
 */

// TODO figure out what to do with this
if ( !isset($form->buttonText) )
{
    $buttonText = "Next >";
}
else
{
    $buttonText = $form->buttonText;
}

$templateTools = new TemplateTools();

// Initialize the row color
$rowColor = "";
//  $templateTools->swapBGColor( $rowColor);

// This template displays a Title & Instr field by default.  If you don't 
// want them displayed, then you send ($disableHeading = true) to the 
// template.
// Now check to see if the disableHeading param has been sent
if (!isset( $disableHeading ) ) {

    // if not default it to false
    $disableHeading = false;
}

// if we are to display the heading ...
if (!$disableHeading) {


?>
<p><span class="heading"><? echo $labels->Label('[Title]'); ?></span></p>
<p><span class="text"><? echo $labels->Label('[Instr]'); ?></span></p>
<span class="text"><? echo $labels->Label('[EventDesc]'). ': <b>'. $eventName.'</b>'; ?><br/></span>
<?

} // end if !disableHeading

if ( isset( $specialInfo ) )
{
    echo '<p class="text">'.$specialInfo.'</p>';
}

?>
<hr>
<?

if ( !isset($disableFormTag) )
{
    $disableFormTag = false;
}

if ( !$disableFormTag )
{
    echo '<form name="Form" id="Form" method="post" action="'.$form->formAction.'">';
    echo '<input name="Process" type="hidden" id="Process" value="T" />';
}
?>
<table width="100%" border="0">
<!-- [RAD_FORM_FIELDENTRIES] -->

<?
    // echo '<pre>'.print_r($form->formDescLabels, true).'</pre>';
    
    // for each desired field to display ...
    foreach( $form->formFieldList as $key=>$value )
    {
    
        // get the field name
        $fieldName = $value;
        // echo 'The fieldName['.$fieldName.']';
        
        $itemType = $form->formFieldHTMLType[$key];
        
        // if item type is displayable
        if ( ( $itemType != '-' ) ) {
        
            echo '<tr valign="top" '.$rowColor.' >
        <td class="text">';
        
            if ( isset( $form->formDescLabels[$value] ) && ( $form->formDescLabels[$value] != '' ) )
            {
                // a label is being passed in
                echo $form->formDescLabels[$value];
            }
            else
            {
                // look in the database for the label
                if ($itemType != 'label') {
                    echo $labels->Label('[formLabel_'.$fieldName.']');
                } else {
                    echo $labels->Label('[title_'.$fieldName.']');
                }
            }  
            
            // if field is required, add a *
            if ( $form->formFieldReqd[$key] == true )
            {
                echo ' *';
            }      
            echo '</td>';
        echo '<td>';
        
        // provided list of values should be named 'list_[fieldName]'
        $listName = 'list_'.$fieldName;
        if (!isset( $$listName ) ) {
             $$listName = array();
        }
        
        // fill this cell with the form type
        $fieldValue = $form->formData[$value];
        $itemError = $form->formErrors[$value];
        $templateTools->drawFormHTML( $itemType, $fieldName, $fieldValue, $itemError, $$listName );   
            
            echo "</td>
    </tr>\n";

        
        } // end if displayable
        
        
    } // next field
    
?>
</table>
<br>
<?
if ( !$disableFormTag )
{
    echo '<div align="middle"><input name="formSubmit" type="submit" value="'.$buttonText.'" /></div>';
    echo '</form>';
}
?>
    
