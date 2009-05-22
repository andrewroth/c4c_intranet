<?
/*
 * genFormSingle.php
 *
 * This template displays a single entry style form.
 *
 * Required Template Variables:
 *  $pageLabels :   The values of the labels to display on the page.
 *  $formAction :   The action for the submitted form.
 *  $dataFieldList :    Array of fields processed by this form.
 *  $formFieldType :    Array of field Types for each of the given fields
 *  $formButtonText :   The text for the submit button.
 *
 */
 
// First load the common Template Tools object
// This object handles the common display of our form items and
// text formmatting tools.
$fileName = 'objects/TemplateTools.php';
$path = Page::findPathExtension( $fileName );
require_once( $path.$fileName);

$templateTools = new TemplateTools();


//Load the Keys for the XML based Form Item Objects
$formItemName = XMLObject_FormItem::XML_ELEMENT_NAME;
$formItemValue = XMLObject_FormItem::XML_ELEMENT_VALUE;
$formItemError = XMLObject_FormItem::XML_ELEMENT_ERROR;


// Initialize the row color
$rowColor = "";
$templateTools->swapBGColor( $rowColor);


// load the page labels
$templateTools->loadPageLabels( $pageLabels );
?>
<p><span class="heading"><? echo $templateTools->getPageLabel('[Title]'); ?></span></p>
<p><span class="text"><? echo $templateTools->getPageLabel('[Instr]'); ?></span></p>
<hr>
<form name="Form" id="Form" method="post" action="<?=$formAction;?>">
<input name="Process" type="hidden" id="Process" value="T" />
<table width="100%" border="0">
<!-- Form Data -->
<?

// for each desired field to display ..
for ($indx=0; $indx<count( $dataFieldList ); $indx++) {

    // get the field name
    $fieldName = $dataFieldList[ $indx ];
    
    // open the row
    echo '<tr valign="top" '.$rowColor.' >
        <td class="text">'; 
        
            $templateTools->swapBGColor( $rowColor);
            
            // display the field's form label
            echo $templateTools->getPageLabel('[formLabel_'.$fieldName.']'); 
    echo '</td>
        <td>'; 

            $itemType = $formFieldType[ $indx ];
            $itemName = $$fieldName->$formItemName;
            $itemValue = $$fieldName->$formItemValue; 
            $itemError = $$fieldName->$formItemError;
            
            // provided list of values should be named 'list_[fieldName]'
            $listName = 'list_'.$fieldName;
            if (!isset( $$listName ) ) {
                 $$listName = array();
            }
            $templateTools->showByFormType($itemType, $itemName, $itemValue, $itemError, $$listName );
        
    echo "</td>
    </tr>\n";

}
?>
</table>
<hr>
<input name="region_id" type="hidden" value="<?=$region_id->$formItemValue;?>" />
<div align="middle"><input name="Add" type="submit" value="<?=$templateTools->getPageLabel('['.$formButtonText.']'); ?>" /></div>
</form>
