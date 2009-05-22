<?
/*
 * genFormSingleDisplayList.php
 *
 * This template displays a single entry style form and a data list. It is 
 * intended to replace the AdminBox style template when there are many
 * fields to display.
 *
 * Required Template Variables:
 *  $pageLabels :   The values of the labels to display on the page.
 *  $formAction :   The action for the submitted form.
 *  $dataFieldList :    Array of fields processed by this form.
 *  $formFieldType :    Array of field Types for each of the given fields
 *
 *  $rowManagerXMLNodeName : The XML Node Name of the data List Entries
 *  $dataList   :   The XML data to display in the list
 *  $primaryKeyFieldName : The primary key field name for the dataList entries
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
$templateTools->swapBGColor( $rowColor );


// load the page labels
$templateTools->loadPageLabels( $pageLabels );

$textStyle = 'text';

?>
<p><span class="heading"><? echo $templateTools->getPageLabel('[Title]'); ?></span></p>
<p><span class="text"><? echo $templateTools->getPageLabel('[Instr]'); ?></span></p>
<hr>
<form name="Form" id="Form" method="post" action="<?=$formAction;?>">
<input name="Process" type="hidden" id="Process" value="T" />
<table width="100%" border="0">
<!-- Form Data -->
<?

// for each desired field to display ...
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
            $templateTools->showByFormType($itemType, $itemName, $itemValue, $itemError, $$listName, 2000, 2010 );
        
    echo "</td>
    </tr>\n";

}
?>
</table>
<hr>
<input name="region_id" type="hidden" value="<?=$region_id;?>" />
<div align="middle"><input name="Add" type="submit" value="<? 
if ( $editEntryID != '' ) {
    echo $templateTools->getPageLabel('[Update]'); 
} else {
    echo $templateTools->getPageLabel('[Add]'); 
}
?>" /></div>
</form>
<hr>
<table width="100%" border="0">
<?
$templateTools->setHeadingBGColor( $rowColor );
?><tr valign="top" <?= $rowColor;?> >
<!-- Data List Headings -->
<?
/*
 * Display the Headings
 */
// for each desired field to display ..
for ($indx=0; $indx<count( $dataFieldList ); $indx++) {
    
    // display the field's title
    $data = $templateTools->getPageLabel('[title_'.$dataFieldList[ $indx ].']');
    echo '<td class="bold">'.$data."</td>\n";
}
?>
<td class="text">&nbsp;</td>
</tr>
<!-- Data List -->
<?
    $entryKey = $rowManagerXMLNodeName;
    /*
     *  For each entry ...
     */
    $numEntries = 0;
    foreach ($dataList->$entryKey as $entry) {
    
        $templateTools->swapBGColor( $rowColor );
        
        //
        // Put any text formatting logic here :
        // 
        $textStyle = 'text';
        
        // start a new row
        echo '<tr valign="top" '.$rowColor.' >';
        
        // for each data field to display
        for ($indx=0; $indx<count( $dataFieldList ); $indx++) {
            
            // display the 
            echo '<td class="'.$textStyle.'">'.$entry->$dataFieldList[ $indx ].'</td>';
        }

        // create link for View/Edit link
        if ( !isset($editLink) ) {
            $editLink = '#';
        }
        $currentEditLink = $editLink.$entry->$primaryKeyFieldName;
        
        // Display View/Edit link
        echo '<td align="right" class="text"><a href="'.$currentEditLink.'">'.$templateTools->getPageLabel('[Edit]').'</a></td>';

        // close row
        echo '</tr>';
    
        $numEntries ++;
    }
?> 
</table>
<hr>
<div class="text" align="right"><? 
                    
    echo '<a href="'.$continueLink.'">'.$templateTools->getPageLabel('[Continue]').'</a>';
  
?></div>
