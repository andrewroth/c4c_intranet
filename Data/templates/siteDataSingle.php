<?
/*
 * siteDataSingle.php
 *
 * This template displays a list of data from a single data item.
 *
 * Required Template Variables:
 *  $pageLabels :   The values of the labels to display on the page.
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
<p><span class="heading"><? echo $templateTools->getPageLabel('[Title]'); ?></span></p>
<p><span class="text"><? echo $templateTools->getPageLabel('[Instr]'); ?></span></p>
<?

} // end if !disableHeading


?>
<hr>
<table width="100%" border="0">
<!-- Form Data -->
<?

// for each desired field to display ..
for ($indx=0; $indx<count( $dataFieldList ); $indx++) {

    // get the field name
    $fieldName = $dataFieldList[ $indx ];
    
    // open the row
    echo '<tr valign="top" >
    	<td class="bold" >'; 
        
            
            // display the field's form label
            echo $templateTools->getPageLabel('[title_'.$fieldName.']'); 
            
    echo '</td>
       		 <td class="text">'; 
            $data = $dataItem->$fieldName;
            
            // if the current field refers to a passed in list
            $listName = 'list_'.$fieldName;
            if (isset($$listName) ) {
            
                $data = $templateTools->returnIndexValue( $data, $$listName);

            }
            
            //if current field refers to a date-time object
            $dateTimeName = 'datetime_'.$fieldName;
            if (isset($$dateTimeName) ) {
	            
	        		$data = substr($dataItem->$fieldName, 0, -3);
        		}
        		
        		// if current field refers to textarea object
        		$textAreaName = 'textarea_'.$fieldName;
            if (isset($$textAreaName) ) {
	            
	            // format newline characters for displaying as newlines in browser
	            $newline = '(\n)';
	            $space = '(\s)';
	            $tab = '(\t)';

// 	            $data = html_entity_decode($data);  // supposed to turn HTML into plaintext but doesn't work
	        		$data = preg_replace($newline, '<br>', $dataItem->$fieldName);
	        		$tab_replace = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
	        		$data = preg_replace($tab, $tab_replace , $data);
	        		$data = preg_replace($space, '&nbsp;', $data);

// 	            $data = htmlspecialchars_decode($data);  
        		}       		

            echo $data;
        
    echo "</td>
    </tr>\n";

}
?>
</table>
<hr>
<? 
    
    if ( isset($linkValues['cont']) ) 
    {
        echo '<div class="text" align="right"><a href="'.$linkValues['cont'].'">'.$linkLabels['cont'].'</a></div>';
    }
  
?>


