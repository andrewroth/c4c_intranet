<?
/*
 * page_ViewPageFields.php
 *
 * This template displays a list of available fields for a page's Form Data
 * Access Object (DAObj) as well as the page's List DAObj.  
 *
 * Required Template Variables:
 *  $pageLabels :   The values of the labels to display on the page.
 *  $formAction :   The action for the submitted form.
 *  $formFields :   XML Data of fields for the Form DAObj.
 *  $currentFormFields : XML Data of the selected fields for Form DAObj
 *  $formDAObjID :  The primary Key of the Form DAObj.
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


// load the page labels
$templateTools->loadPageLabels( $pageLabels );

$textStyle = 'text';



function isSelected( $daFieldID, $pageFieldList ) {

    $isSelected = false;
    
    $pageFieldEntryKey = RowManager_PageFieldManager::XML_NODE_NAME;
    
    // for each page field in the list 
    foreach( $pageFieldList->$pageFieldEntryKey as $pageField) {
    
        // if the daField ID's match then current daFieldID is selected.
        if ( (int) $daFieldID == (int) $pageField->dafield_id) {
            $isSelected = true;
        }
    } // end foreach
    
    return $isSelected;
}

?>
<p><span class="heading"><? echo $templateTools->getPageLabel('[Title]'); ?></span></p>
<p><span class="text"><? echo $templateTools->getPageLabel('[Instr]'); ?></span></p>
<form name="Form" id="Form" method="post" action="<?=$formAction;?>">
<input name="Process" type="hidden" id="Process" value="T" />
<p class="bold" ><? echo $templateTools->getPageLabel('[formFields]'); ?></p>
<hr>
<table width="100%" border="0">
<!-- Form Data -->
<?

    $entryKey = $rowManagerXMLNodeName;
    
    /*
     *  For each Form Field ...
     */
    foreach ($formFields->$entryKey as $entry) {
    
        $templateTools->swapBGColor( $rowColor );
    
        // open the row
        echo '<tr valign="top" '.$rowColor." >\n";
    
        // display checkbox
        echo '<td class="text" >';
        
        $isSelected = isSelected( $entry->dafield_id, $currentFormFields );
        $defaultValue = '';
        if ( $isSelected ) {
            $defaultValue = $entry->dafield_id;
        }
        $templateTools->showCheckBox( 'formField[]', $entry->dafield_id, $defaultValue);
        
        echo '</td>';
        
        // display Name
        echo '<td class="text" >';
        
        echo $entry->dafield_name;
        
        echo '</td>';
        
        // display description
        echo '<td class="text" >';
        
        echo $entry->dafield_desc;
        
        echo '</td>';
        
        // close the row
        echo "<tr>\n";
    
    } // end for each entry
?>
</table>
<p>&nbsp;</p>
<p class="bold" ><? echo $templateTools->getPageLabel('[listFields]'); ?></p>
<hr>
<table width="100%" border="0">
<!-- Form Data -->
<?

    $entryKey = $rowManagerXMLNodeName;
    
    /*
     *  For each Form Field ...
     */
    foreach ($listFields->$entryKey as $entry) {
    
        $templateTools->swapBGColor( $rowColor );
    
        // open the row
        echo '<tr valign="top" '.$rowColor." >\n";
    
        // display checkbox
        echo '<td class="text" >';
        
        $isSelected = isSelected( $entry->dafield_id, $currentListFields );
        $defaultValue = '';
        if ( $isSelected ) {
            $defaultValue = $entry->dafield_id;
        }
        $templateTools->showCheckBox( 'listField[]', $entry->dafield_id, $defaultValue);
        
        echo '</td>';
        
        // display Name
        echo '<td class="text" >';
        
        echo $entry->dafield_name;
        
        echo '</td>';
        
        // display description
        echo '<td class="text" >';
        
        echo $entry->dafield_desc;
        
        echo '</td>';
        
        // close the row
        echo "<tr>\n";
    
    } // end for each entry
?>
</table>
<input name="formDAObjID" type="hidden" value="<?=$formDAObjID;?>" />
<input name="listDAObjID" type="hidden" value="<?=$listDAObjID;?>" />
<div align="middle"><input name="Add" type="submit" value="<? 
echo $templateTools->getPageLabel('[Update]'); 
?>" /></div>
</form>

