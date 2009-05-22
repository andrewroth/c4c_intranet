<?
/*
 * siteFormGrid.php
 *
 * This template displays grid of Form Elements.  There are rows and columns.
 * The rows are the data passed into the rowManager.  The columns are which 
 * fields of the rowManager we are working with.  Each form element is named
 * as 'FieldName'+RowManagerID.
 *
 * Required Template Variables:
 *  $formAction :   The action for the submitted form.
 *  $pageLabels :   The values of the labels to display on the page.
 *  $formFieldList: Array of fields displayed by the Form
 *  $formFieldType : Array of field Types for each of the given fields
 *
 *  $rowManagerXMLNodeName : The XML Node Name of the row List Entries
 *  $primaryKeyFieldName : The primary key field name for the rowList entries
 *  $labelFieldName : the field in the rowList to use as the row labels
 *  $rowList   :   The XML data to display in the form
 *  $dataFieldList :    Array of fields processed by the data list.
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
<?

    /*
     *  Display Column Headers
     */
     echo '<tr>';
     echo '<td>&nbsp;</td>';
     
    // for each desired field to display ..
    for ($indx=0; $indx<count( $formFieldList ); $indx++) {
        
         $itemType = $formFieldType[ $indx ];
            
        // if item type is displayable
        if ($itemType != '-' ) {

            // display the field's title
            $data = $templateTools->getPageLabel('[title_'.$formFieldList[ $indx ].']');
            echo '<td class="bold">'.$data."</td>\n";
            
        }
        
    } // next field
     
     echo '</tr>';
     
     
    /*
     *  For each row Item ...
     */
    $entryKey = $rowManagerXMLNodeName;
    
    foreach ($rowList->$entryKey as $entry) {
    
        // display row label
        echo '<tr valign="top"> 
    <td> <div align="left" class="text">'.$entry->$labelFieldName.'</div></td>';
    
        
        // for each desired field to display ..
        for ($indx=0; $indx<count( $formFieldList ); $indx++) {
        
            // get fieldname ( FieldName + RowEntryID )
            $fieldName = $formFieldList[ $indx ].$entry->$primaryKeyFieldName;
            
            $itemType = $formFieldType[ $indx ];
            
            // if item type is displayable
            if ($itemType != '-' ) {
            
                echo '<td>';
                
                $itemName = $$fieldName->$formItemName;
            // HSMIT: (below) ensures that slashes added for DB storage of apostrophes are stripped when data shown in browser
                $itemValue = stripslashes($$fieldName->$formItemValue); 
                $itemError = $$fieldName->$formItemError;
                
                // provided list of values should be named 'list_[fieldName]'
                $listName = 'list_'.$fieldName;
                if (!isset( $$listName ) ) {
                     $$listName = array();
                }
                
                
                $templateTools->showByFormType($itemType, $itemName, $itemValue, $itemError, $$listName, 2000, 2010 );
            
                echo '</td>';
                
            } // end if item type is displayable
            
        } // next field
        
      echo '</tr>';
    
    }
?> 
</table>
<hr>
<div align="middle"><input name="Add" type="submit" value="<?=$templateTools->getPageLabel('[Update]'); ?>" /></div>
</form>
