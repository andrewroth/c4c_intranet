<?
/*
 * genFormSingle.php
 *
 * This template displays a Single Entry form.  This type of form displays
 * a row for each field is is gathering data for. Each row has a label, and
 * a form item.
 *
 * Required Template Variables:
 *  $pageLabels :   The values of the labels to display on the page.
 *  $formAction :   The action for the submitted form.
 *  $dataFieldList :    Array of fields processed by this form.
 *  $formFieldType :    Array of field Types for each of the given fields
 */

// First load the common Template Tools object
// This object handles the common display of our form items and
// text formmatting tools.
$fileName = 'objects/TemplateTools.php';
$path = Page::findPathExtension( $fileName );
require_once( $path.$fileName);

$templateTools = new TemplateTools();
if (isset($disableForm))
{
	$templateTools->disableForm();
}


//Load the Keys for the XML based Form Item Objects
$formItemName = XMLObject_FormItem::XML_ELEMENT_NAME;
$formItemValue = XMLObject_FormItem::XML_ELEMENT_VALUE;
$formItemError = XMLObject_FormItem::XML_ELEMENT_ERROR;


// Initialize the row color
$rowColor = "";
$templateTools->swapBGColor( $rowColor);
 
 
// load the page labels
$templateTools->loadPageLabels( $pageLabels );


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
<p><span class="heading"><? echo $templateTools->getPageLabel('[Title]');
if (isset($formName)) { echo '<br>( '.$formName.' )'; } ?>
</span></p>
<p><span class="text"><? echo $templateTools->getPageLabel('[Instr]'); ?></span></p>
<?

} // end if !disableHeading

// Any other special instructions etc...
if ( isset( $specialInfo ) )
{
    echo $specialInfo;
}


$formAnchorName = "";
if (isset($formAnchor)) 
{ 
   $formAnchorName = $formAnchor;
}


?>
<hr>
<a name="<?=$formAnchorName;?>"></a>
<? $formAnchorName = '#'.$formAnchorName;		// revert if placing anchor **tags** below here (rather than in URLs) 
?>
<form name="Form" id="Form" method="post" action="<?=$formAction.$formAnchorName;?>">
<input name="Process" type="hidden" id="Process" value="T" />
<table width="100%" border="0">
<!-- [RAD_FORM_FIELDENTRIES] -->

<?

    // for each desired field to display ...
    for ($indx=0; $indx<count( $formFieldList ); $indx++) {
    
        // get the field name
        $fieldName = $formFieldList[ $indx ];
        
        $itemType = $formFieldType[ $indx ];
        
        // if item type is displayable
        if ($itemType != '-' ) {
        
            echo '<tr valign="top" '.$rowColor.' >
        <td class="text">';
        if ($itemType != 'hidden')
        {
            if ($itemType != 'label') {
	            
	            // Determine if the field is a required field (need to indicate this fact to the user)
            	if ((isset($reqFieldList))&&($reqFieldList[$fieldName] != 'skip'))
	            {
		            echo '<div class="notice">'.$formLabels['formLabel_'.$indx].'</div>';   
               }
               else
               {
                  //echo $templateTools->getPageLabel('[formLabel_'.$fieldName.']');
                  echo $formLabels['formLabel_'.$indx];                              
               }
            } else {
                //echo $templateTools->getPageLabel('[title_'.$fieldName.']');
                echo $listLabels['title_'.$indx];
            }        
         }
            echo '</td>
        <td>';
        
            
            $itemName = $$fieldName->$formItemName;
            // HSMIT: (below) ensures that slashes added for DB storage of apostrophes are stripped when data shown in browser
            $itemValue = stripslashes($$fieldName->$formItemValue);  
            $itemError = $$fieldName->$formItemError;
            
            // provided list of values should be named 'list_[fieldName]'
            $listName = 'list_'.$fieldName;
            if (!isset( $$listName ) ) {
                 $$listName = array();
            }
    
            // if a startYear value for this field was given
            $startDateName = 'startYear_'.$fieldName;
            if (isset( $$startDateName ) ) {
                $startYear = $$startDateName;
            } else {
                $startYear = 2000;
            }
            
            // if a endYear value for this field was given
            $endDateName = 'endYear_'.$fieldName;
            if (isset( $$endDateName ) ) {
                $endYear = $$endDateName;
            } else {
                $endYear = 2010;
            }
            
	         $noteName = 'note_'.$fieldName;
	        if (!isset( $$noteName ) ) {
	             $notice = '';
	        }
	        else
	        {
		        $notice = $$noteName;
	        }         
            
            $templateTools->showByFormType($itemType, $itemName, $itemValue, $itemError, $$listName, $startYear, $endYear, '', $notice );
            
            echo "</td>
    </tr>\n";

        } // end if displayable
        
    } // next field
?>
</table>


<!-- ORIGINAL SUBMIT BUTTON CODE FOR SINGLE FORM PAGE -->
<hr>
<?
if (!isset($disableForm))
{
?>
<div align="middle"><input name="formSubmit" type="submit" value="<?=$buttonText; ?>" /></div>
<?
}
?>
</form>




<?

    if (  isset( $footerContent ) )
    {
        echo $footerContent;
    }

?>