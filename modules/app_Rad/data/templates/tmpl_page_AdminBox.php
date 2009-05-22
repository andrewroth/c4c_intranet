<?
/*
 * genAdminBox.php
 *
 * This template displays an AdminBox style form.  This type of form displays
 * a row of table data and a row of form elements at the end to enter another 
 * entery.  If an entry in the list is clicked upon, then the page refreshed
 * with the form at that entry's position to update that value.
 * 
 * The AdminBox is handy for tables with few form elements.  If there are too
 * many form elements to display properly, then use the 
 * genFormSingleDisplayList.php template.
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
$formItemName  = XMLObject_FormItem::XML_ELEMENT_NAME;
$formItemValue = XMLObject_FormItem::XML_ELEMENT_VALUE;
$formItemError = XMLObject_FormItem::XML_ELEMENT_ERROR;


// Initialize the row color
$rowColor = "";
$templateTools->setHeadingBGColor( $rowColor );


// load the page labels
$templateTools->loadPageLabels( $pageLabels );

$textStyle = 'text';


/*
 *  Create the form row data ...
 */
// open the row
$formRowData = "<tr>\n";

// for each desired field to display ...
for ($indx=0; $indx<count( $dataFieldList ); $indx++) {

    // get the field name
    $fieldName = $dataFieldList[ $indx ];
    
    // open the column
    $formRowData .= '<td>'; 

    $itemType = $formFieldType[ $indx ];
    $itemName = $$fieldName->$formItemName;
    $itemValue = $$fieldName->$formItemValue; 
    $itemError = $$fieldName->$formItemError;
    
    // provided list of values should be named 'list_[fieldName]'
    $listName = 'list_'.$fieldName;
    if (!isset( $$listName ) ) {
         $$listName = array();
    }
    
    // since the template tools echo data to the output we need to capture
    // it and store it in the formRowData variable
    ob_start();                    // Start output buffering
    $templateTools->showByFormType($itemType, $itemName, $itemValue, $itemError, $$listName, 2000, 2010 );
    $formRowData .= ob_get_contents(); // Get the contents of the buffer
    ob_end_clean();    
    
    
    // close the column  
    $formRowData .= "</td>\n";

}

// now add the button column
$formRowData .= '<td valign="top" >';
if ($editEntryID == '' ) {
    $buttonText = 'Add';
} else {
    $buttonText = 'Update';
}
$formRowData .= '<input name="Add" type="submit" value="'.$templateTools->getPageLabel('['.$buttonText.']').'" />';
$formRowData .= "</td>\n";

// close the row
$formRowData .= "</tr>\n";

?>
<p><span class="heading"><? echo $templateTools->getPageLabel('[Title]'); ?></span></p>
<p><span class="text"><? echo $templateTools->getPageLabel('[Instr]'); ?></span></p>
<hr>
<form name="Form" id="Form" method="post" action="<?=$formAction;?>">
<input name="Process" type="hidden" id="Process" value="T" />
<table width="100%" border="0">
<tr valign="top" <?
$headingColor='';
$templateTools->setHeadingBGColor( $headingColor );
echo $headingColor;
?> >

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
        
        // Put any text formatting logic here :
        // 
        // if ( $entry->[FieldName] != 'FULL' ) {
        //     $textStyle = 'error';
        // } else {
        //     $textStyle = 'text';
        // }
        
        $textStyle = 'text';
        
        // if current entry is not the one being edited then
        if ( $editEntryID != $entry->$primaryKeyFieldName ) {
        
            // display entry data ...
            echo '<tr valign="top" '.$rowColor.' >';
     
            // for each data field to display
            for ($indx=0; $indx<count( $dataFieldList ); $indx++) {
                
                // display the field's data
                echo '<td class="'.$textStyle.'">'.$entry->$dataFieldList[ $indx ].'</td>';
            }
    
            if ( !isset($editLink) ) {
                $editLink = '#';
            }
            $currentEditLink = $editLink.$entry->$primaryKeyFieldName;
            echo '<td align="right" class="text"><a href="'.$currentEditLink.'">'.$templateTools->getPageLabel('[Edit]').'</a></td>';
    
            echo '</tr>';
            
        } else {
        
            // display form data
            echo $formRowData;
        }
    
        $numEntries ++;
    }
    
    
    // If no Edit Entry ID was given then display the form now.
    if ($editEntryID == '' ) {
    
        echo $formRowData;
    }

    
?> 
</table>
</form>
<hr>
<div class="text" align="right"><? 
                    
    echo '<a href="'.$continueLink.'">'.$templateTools->getPageLabel('[Continue]').'</a>';
  
?></div>
