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
 *  $columnList:    Array of column information displayed on this form
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
    foreach( $columnList as $key=>$value) {
        
        // display the field's title
        $data = $templateTools->getPageLabel('[title_'.$value.']');
        echo '<td class="bold">'.$data."</td>\n";
        
    } // next field
     
     echo '</tr>';
     
     
    /*
     *  For each row Item ...
     */    
    $itemType = $formFieldType;
    foreach ($rowList as $rowKey=>$rowValue) {
    
        // display row label
        echo '<tr valign="top" '.$rowColor.' > 
    <td> <div align="left" class="text">'.$rowValue.'</div></td>';
        $templateTools->swapBGColor( $rowColor);
        
        // for each desired column to display ..
        foreach( $columnList as $colKey=>$colValue ) {
        
            // compile new Key
            $key = $rowKey.'_'.$colKey;

            if (isset( $valueList[ $key ] ) ) {
                $itemValue = $valueList[ $key ];	//TODO?: add stripslashes() around $valueList [$key] to remove slashes added for storing apostrophes
            } else {
                $itemValue = '0';
            }
            
            // if item type is displayable
            if ($itemType != '-' ) {
            
                echo '<td>';
                
                
                $templateTools->showByFormType($itemType, $key,  $itemValue, '', '' );
            
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
