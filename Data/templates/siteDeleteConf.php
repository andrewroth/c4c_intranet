<?
/*
 * siteDeleteConf.php
 *
 * This template displays a delete confirmation style form.
 *
 * Required Template Variables:
 *  $pageLabels :   The values of the labels to display on the page.
 *  $formAction :   The action for the submitted form.
 *  $dataFieldList :    Array of fields processed by this form.
 *  $dataItem   :    Array of field Types for each of the given fields
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
    echo '<tr valign="top" >
        <td class="text">'; 
            
            // display the field's form label
            echo $templateTools->getPageLabel('[title_'.$fieldName.']'); 
            
    echo '</td>
        <td class="bold" >'; 

            $data = $dataItem->$fieldName;
            
            // if the current field refers to a passed in list
            $listName = 'list_'.$fieldName;
            if (isset($$listName) ) {
            
                $data = $templateTools->returnIndexValue( $data, $$listName);

            }

            echo $data;
        
    echo "</td>
    </tr>\n";

}
?>
</table>
<hr>
<table width="100%">
<tr>
<td align="center"><input name="submit" type="submit" value="<?=$templateTools->getPageLabel('[yes]'); ?>" /></td>
<td align="center"><input name="submit" type="submit" value="<?=$templateTools->getPageLabel('[no]'); ?>" /></td>
</tr>
</table>
</form>
