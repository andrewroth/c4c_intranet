<?
/*
 * siteAdminBox.php
 *
 * This template displays an AdminBox style form.  This type of form displays
 * a row of table data and a row of form elements at the end to enter another 
 * entery.  If an entry in the list is clicked upon, then the page refreshed
 * with the form at that entry's position to update that value.
 * 
 * The AdminBox is handy for tables with few form elements.  If there are too
 * many form elements to display properly, then use the 
 * siteFormSingleDisplayList.php template.
 *
 * Required Template Variables:
 *  $formAction :   The action for the submitted form.
 *  $linkValues :   Array of link href values. linkValue[ 'key' ] = 'href';
 *  $linkLabels :   Array of link lables. linkLabels[ 'key' ] = 'Label';
 *  $linkColumns:   Array of columns with links to other pages.
 *                  $columnEntry = $linkColumns[0];
 *                  $columnEntry['title'] = Label to display for the Title
 *                  $columnEntry['label'] = Label to display on the page
 *                  $columnEntry['link' ] = The link to use 
 *                  $columnEntry['field' ] = Name of the field to use for the 
 *                      rest of the link data.
 *  $pageLabels :   The values of the labels to display on the page.
 *  $formFieldList: Array of fields displayed by the Form
 *  $formFieldType : Array of field Types for each of the given fields
 *
 *  $rowManagerXMLNodeName : The XML Node Name of the data List Entries
 *  $primaryKeyFieldName : The primary key field name for the dataList entries
 *  $dataList   :   The XML data to display in the list
 *  $dataFieldList :    Array of fields processed by the data list.
 *  $showAddForm :  BOOL flag determining if we show the Form during a non
 *                  edit/delete mode.
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
$formItemName  = XMLObject_FormItem::XML_ELEMENT_NAME;
$formItemValue = XMLObject_FormItem::XML_ELEMENT_VALUE;
$formItemError = XMLObject_FormItem::XML_ELEMENT_ERROR;


// Initialize the row color
$rowColor = "";
$templateTools->setHeadingBGColor( $rowColor );


// load the page labels
$templateTools->loadPageLabels( $pageLabels );

$textStyle = 'text';

if (!isset($showAddForm) ) {
    $showAddForm = true;
}

if (($showAddForm) || ((!$showAddForm) && ($editEntryID != ''))) {

    /*
     *  Create the form row data ...
     */
    // open the row
    $formRowData = "<tr>\n";
    
    // for each desired field to display ...
    for ($indx=0; $indx<count( $formFieldList ); $indx++) {
    
        // get the field name
        $fieldName = $formFieldList[ $indx ];
        
        $itemType = $formFieldType[ $indx ];
        
        if ( substr($itemType,0,1) != '-' ) {
            // open the column
            $formRowData .= '<td valign="top" class="text" >'; 
        
            
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
            
            // since the template tools echo data to the output we need to capture
            // it and store it in the formRowData variable
            ob_start();                    // Start output buffering
            $templateTools->showByFormType($itemType, $itemName, $itemValue, $itemError, $$listName, $startYear, $endYear, '','', $formName );
            $formRowData .= ob_get_contents(); // Get the contents of the buffer
            ob_end_clean();    
            
            
            // close the column  
            $formRowData .= "</td>\n";
        } // end if ! hidden
    }
    
    // now add spacers for each included linkColumn
    for( $indx=0; $indx<count($linkColumns); $indx++) {
        
        $formRowData .= "<td>&nbsp;</td>\n";
    }
    
    // now add the button column
    $formRowData .= '<td valign="top" >';
    if (!isset($disableForm))
	 {  	 
	    if ($editEntryID == '' ) {
	    
	        $formRowData .= '<input name="submit" type="submit" value="'.$templateTools->getPageLabel('[Add]').'" />';
	        
	    } else {
	    
	        $formRowData .= '<input name="admOpType" type="hidden" id="admOpType" value="'.$opType.'" />';
	        if ($opType == 'U' ) {
	        
	            $formRowData .= '<input name="submit" type="submit" value="'.$templateTools->getPageLabel('[Update]').'" />';
	            
	        } else {
	        
	            $formRowData .= '<input name="submit" type="submit" value="'.$templateTools->getPageLabel('[Delete?]').'" />';
	            
	            $formRowData .= '<input name="submit" type="submit" value="'.$templateTools->getPageLabel('[Cancel]').'" />';
	        
	        }
	    }
    }
    $formRowData .= "</td>\n";
    
    // close the row
    $formRowData .= "</tr>\n";

} else {

    $formRowData = '';

} // end if (showAddForm) 


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

if (isset($notice)) 
{
	echo '<p><span class="bold">'.$notice.'</span></p>';
}

if (isset($errorMessage)) 
{
	echo '<p><span class="error">'.$errorMessage.'</span></p>';
}


} // end if !disableHeading


?>
<hr>
<? 
	$formAnchorName = "";
	if (isset($formAnchor)) 
	{ 
	   $formAnchorName = $formAnchor;
   }
   
?>

	   
<a name="<?=$formAnchorName;?>"></a>
<? $formAnchorName = '#'.$formAnchorName;		// revert if placing anchor **tags** below here (rather than in URLs) 
?>
<div id="overDiv" style="position:absolute; visibility:hidden; z-index:1000;"></div>

<form name=<? echo '"'.$formName.'"'; ?> id="Form" method="post" action="<?=$formAction.$formAnchorName;?>">
<input name="Process" type="hidden" id="Process" value="T" />
<table width="40%" border="0">
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
$sortByLink='#';
if ( isset($linkValues['sortBy']) ) {
    $sortByLink = $linkValues['sortBy'];
}

// for each desired field to display ..
for ($indx=0; $indx<count( $dataFieldList ); $indx++) {
    
    // display the field's title
    $data = $templateTools->getPageLabel('[title_'.$dataFieldList[ $indx ].']');
    if ( $sortByLink != '#' ) {
        $data = '<a href="'.$sortByLink.$dataFieldList[ $indx ].'">'.$data.'</a>';
    }
    echo '<td class="bold">'.$data."</td>\n";
}

// now add headings for each included linkColumn
for( $indx=0; $indx<count($linkColumns); $indx++) {
    
    $columnEntry = $linkColumns[ $indx ];
    $title = '&nbsp;';
    if ( isset( $columnEntry[ 'title' ] ) ) {
        $title = $columnEntry[ 'title' ];
    }
    echo '<td class="bold">'.$title."</td>\n";
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
        $displayLink = true;
        
        // if current entry is not the one being edited then
        if ( $editEntryID != $entry->$primaryKeyFieldName ) {
        
            // display entry data ...
            echo '<tr valign="top" '.$rowColor.' >';
     
            // for each data field to display
            for ($indx=0; $indx<count( $dataFieldList ); $indx++) {
                
                $data = $entry->$dataFieldList[ $indx ];
                
	             $date_regex = '/[2-9]([0-9]{3})\-[0-9]{1,2}\-[0-9]{1,2}/';	
					 if (preg_match($date_regex, $data) >= 1)
					 {
						 $time = strtotime($data);
						 $data = strftime("%d %b %Y",$time);;
					 }
					                
                
                // make sure none of the link exclusion values are met
                if ( isset( $linkExclusionCondition ) )
                {
                    if ( isset( $linkExclusionCondition[ $dataFieldList[ $indx ] ] ) )
                    {
                        $arrayOfExclusionValues = $linkExclusionCondition[ $dataFieldList[ $indx ] ];
                        foreach ( $arrayOfExclusionValues as $key=>$value)
                        {
                            if ( $data == $value )
                            {
                                $displayLink = false;
                            }
                        } // foreach
                    }
                } // isset( $linkExclusionCondition )
                
                // if the current field refers to a passed in list
                $listName = 'list_'.$dataFieldList[ $indx ];
                    
                if ( isset( $$listName ) ) {
                    if  (count($$listName) > 0) {
                    
                        $data = $templateTools->returnIndexValue( $data, $$listName);
                    }
                }
                
                // display the field's data
                echo '<td class="'.$textStyle.'">'.$data.'</td>';
            }
            
            // for each linkColumn 
            for( $indx=0; $indx<count($linkColumns); $indx++) {
                
                $columnEntry = $linkColumns[ $indx ];
                $label = $columnEntry[ 'label' ];
                $link = $columnEntry[ 'link' ];
                $fieldName = $columnEntry[ 'field' ];
                
                $data = '<a href="'.$link.$entry->$fieldName.$formAnchorName.'">'.$label.'</a>';
                echo '<td class="'.$textStyle.'">'.$data."</td>\n";
            }
    
            if ( !isset($linkValues['edit']) ) {
                $editLink = '#';
                $editLabel = '';
            } else {
                $editLink = $linkValues['edit'];
                $currentEditLink = $editLink.$entry->$primaryKeyFieldName;
                $currentEditLink .= '&admOpType=U';
                $editLabel = '<a href="'.$currentEditLink.$formAnchorName.'">'.$linkLabels[ 'edit' ].'</a>';
            }
            
            
            if ( !isset($linkValues['del']) ) {
                $deleteLink = '#';
                $deleteLabel = '';
            } else {
                $deleteLink = $linkValues['del'];
                $currentDeleteLink = $deleteLink.$entry->$primaryKeyFieldName;
                $currentDeleteLink .= '&admOpType=D';
                $deleteLabel = '<a href="'.$currentDeleteLink.$formAnchorName.'">'.$linkLabels[ 'del' ].'</a>';
            }
            
            
            echo '<td align="right" class="text">';
            
            if ( $displayLink )
            {
                echo $editLabel;
                if (($editLabel != '') && ($deleteLabel != '')) {
                    echo ' | ';
                } 
                echo $deleteLabel;
            }
            echo '</td>';
    
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
<?
    if (isset($date_error_msg))
    {
	    echo '<div class="error">'.$date_error_msg.'</div>';
    }
?>
</form>
<hr>
<? 
    
    if ( isset($linkValues['cont']) ) {
        echo '<div class="text" align="right"><a href="'.$linkValues['cont'].'">'.$linkLabels['cont'].'</a></div>';
    }
  
?>
