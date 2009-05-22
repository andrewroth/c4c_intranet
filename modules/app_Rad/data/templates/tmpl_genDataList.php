<?
/*
 * genDataList.php
 *
 * This template displays a set of data in a grid.
 *
 * Required Template Variables:
 *  $pageLabels :   The values of the labels to display on the page.
 *  $dataFieldList :    Array of fields processed by this form.
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


// Initialize the row color
$rowColor = "";
$templateTools->setHeadingBGColor( $rowColor );


// load the page labels
$templateTools->loadPageLabels( $pageLabels )

?>
<p><span class="heading"><? echo $templateTools->getPageLabel('[Title]'); ?></span></p>
<p><span class="text"><? echo $templateTools->getPageLabel('[Instr]'); ?></span></p>
<div align="right" class="text" ><? 

    if (!isset($addLink)) {
        $addLink = '#';
    }
    echo '<a href="'.$addLink.'">'.$templateTools->getPageLabel('[Add]').'</a>'; 
    
?></div>
<hr>
<table width="100%" border="0">
<tr valign="top" <?= $rowColor;?> >
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
            
            $data = $entry->$dataFieldList[ $indx ];
                
            // if the current field refers to a passed in list
            $listName = 'list_'.$dataFieldList[ $indx ];
            if (isset($$listName) ) {
            
                // treat data as the index to the entry into the list.
                
                // find out if keys are (int) or not
                $keys = array_keys( ${$listName} );
                if (is_int( $keys[0] ) ) {
                    $data = (int) $data;
                } else {
                    $data = (string) $data;
                }
                
                // if it is a valid entry then 
                if (isset( ${$listName}[ $data ] ) ) {
                
                    // retrieve the text to display
                    $data = ${$listName}[ $data ];
                }
            }
            
            // display the field's data
            echo '<td class="'.$textStyle.'">'.$data.'</td>';
                
        }

        // create link for View/Edit link
        if ( !isset($editLink) ) {
            $editLink = '#';
        }
        $currentEditLink = $editLink.$entry->$primaryKeyFieldName;
        
        // Display View/Edit link
        echo '<td align="right" class="text"><a href="'.$currentEditLink.'">'.$templateTools->getPageLabel('[View]').'</a></td>';

        // close row
        echo '</tr>';
    
        $numEntries ++;
    }
?> 
</table>
<hr>
<div class="text" align="right"><? 
    
    // if the number of entries get too long (>15?) then add another 
    // ADD link to the bottom of the list.    
    if ($numEntries > 15 ) {
        echo '<a href="'.$addLink.'">'.$templateTools->getPageLabel('[Add]').'</a>&nbsp;/&nbsp;';
    }
    
    // display Continue Link
    echo '<a href="'.$continueLink.'">'.$templateTools->getPageLabel('[Continue]').'</a>';
  
?></div>
