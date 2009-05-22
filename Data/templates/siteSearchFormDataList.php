<?
/*
 * siteFormDataList.php
 *
 * This template displays a Form entry and a Display List.  
 * 
 * This is handy for tables with many form elements.  If there are not
 * very many form elements to display, then use the 
 * siteAdminBox.php template.
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
$templateTools->swapBGColor( $rowColor );


// load the page labels
$templateTools->loadPageLabels( $pageLabels );

$textStyle = 'text';


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

// Any other special instructions etc...
if ( isset( $specialInfo ) )
{
    echo $specialInfo;
}


?>
<hr>
<form name="Form" id="Form" method="post" action="<?=$formAction;?>">
<input name="Process" type="hidden" id="Process" value="T" />
<table width="100%" border="0">
<?

/*
 *  Create the form row data ...
 */

// for each desired field to display ...
for ($indx=0; $indx<count( $formFieldList ); $indx++) {

    // get the field name
    $fieldName = $formFieldList[ $indx ];
    
    $itemType = $formFieldType[ $indx ];
    
    if ( $itemType == 'hidden' )
    {
        $itemName = $$fieldName->$formItemName;
        $itemValue = $$fieldName->$formItemValue; 
        $itemError = $$fieldName->$formItemError;
        
        // provided list of values should be named 'list_[fieldName]'
        $listName = 'list_'.$fieldName;
        if (!isset( $$listName ) ) {
             $$listName = array();
        }
        
        $templateTools->showByFormType($itemType, $itemName, $itemValue, $itemError, $$listName );
        
    }
    else if ($itemType != '-' ) {
        
         echo '<tr valign="top"  >
        <td class="text" '.$rowColor.' >';
        
            echo $templateTools->getPageLabel('[formLabel_'.$fieldName.']');
            
            echo '</td>
        <td>'; 
    
        
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

        $noteName = 'note_'.$fieldName;
        if (!isset( $$noteName ) ) {
             $notice = '';
        }
        else
        {
	        $notice = $$noteName;
        }

        $templateTools->showByFormType($itemType, $itemName, $itemValue, $itemError, $$listName, $startYear, $endYear, '', $notice );
        
        
        // close the column & Row 
        echo "</td>
    </tr>\n";
    
    } // end if ! hidden
}


// now add the button column
echo '<tr>';
if ($editEntryID == '' ) {

    echo '<td align="center" valign="top" colspan="2" >';
    echo '<input name="submit" type="submit" value="'.$templateTools->getPageLabel('[Search]').'" />';
    echo '</td>';
    
} else {
    
    if ($opType == 'U' ) {
    
        echo '<td align="center" valign="top" colspan="2" >';
        echo '<input name="admOpType" type="hidden" id="admOpType" value="'.$opType.'" />';
        echo '<input name="submit" type="submit" value="'.$templateTools->getPageLabel('[Update]').'" />';
        echo '</td>';
        
    } else {
    
        echo '<td align="center">';
        echo '<input name="admOpType" type="hidden" id="admOpType" value="'.$opType.'" />';
        echo '<input name="submit" type="submit" value="'.$templateTools->getPageLabel('[Delete?]').'" />';
        
        echo '</td><td align="center">';
        
        echo '<input name="submit" type="submit" value="'.$templateTools->getPageLabel('[Cancel]').'" />';
        
        echo '</td>';
    
    }
}

// close the row
echo "</tr>\n";

?>
</table>
</form>
<br>
<table width="100%">
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
        
        // if current entry is not the one being edited then
        if ( $editEntryID != $entry->$primaryKeyFieldName ) {
        
            // display entry data ...
            echo '<tr valign="top" '.$rowColor.' >';
     
            // for each data field to display
            for ($indx=0; $indx<count( $dataFieldList ); $indx++) {
                
                $data = $entry->$dataFieldList[ $indx ];
                $textStyle = 'text';
                
                // check for special formatting
                if ( isset( $dataDisplayClass ) )
                {
                    if ( isset( $dataDisplayClass[ $dataFieldList[ $indx ] ] ) )
                    {
                        $arrayOfDisplayValues = $dataDisplayClass[ $dataFieldList[ $indx ] ];
                        foreach ( $arrayOfDisplayValues as $key=>$value)
                        {
                            if ( $data == $key )
                            {
                                $textStyle = $value;
                            }
                        } // foreach
                    }
                } // isset( $dataDisplayClass )
                
                // if the current field refers to a passed in list
                $listName = 'list_'.$dataFieldList[ $indx ];

                if (isset( $$listName ) ) {
                    if  (count($$listName) > 0) {
                    
    
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
                        /**** USE THE BELOW CODE TO MAKE THIS TEMPLATE WORK WITH ***JUMPLISTS**** USED IN FORM PORTION  ****/
//                         else {		// need to create the JUMPLIST index, i.e. take the base URL and append the appropriate field ID to it

// 	                         $subject = $keys[0];
// 									 $pattern = '/=[a-z]*[0-9]*/';	// search for '=<values>' in a sample key URL
// 									 preg_match_all($pattern, $subject, $matches, PREG_OFFSET_CAPTURE);
// //									 echo '<pre>'.print_r($matches,true).'</pre>';								 
// 									 $final_index = count($matches[0]) - 1;
// 									 
// 									$rootURLindex = substr($keys[0],0,$matches[0][$final_index][1]+1);	// use final match index + 1 to get base URL (inc. '=')	                         	 
// 									$data = $rootURLindex.$data;		// add data field id to the base URL of the jump link to get the array index
// 	                        
// 	                         // if it is a valid JUMPLIST entry then 
// 	                        if (isset( ${$listName}[ $data ] ) ) {

// 	                            // retrieve the text to display
// 	                            $data = ${$listName}[ $data ];		//$data = ${$listName}[ $keys[$data] ];                        
// 	                        }
//                         }
                    }
                }
                
                
                            
           // $textStyleTemp = $textStyle;
            
            if ( isset( $dataArray) )
            {
                //print_r($dataArray);
                foreach($dataArray as $value)
                {
                    $index = $entry->$primaryKeyFieldName . $dataFieldList[ $indx ];

                    //print ($index . "<br>");
                    //$index = "test";
                    if (isset($dataArray[$index]))
                    {
                        //print ("textStyle! = " . $textStyle . "<br>");
                        //$textStyle = $dataArray[$index];
                        $textStyle = $value;
                    }
                    
                }
            }
                
                // display the field's data
                echo '<td class="'.$textStyle.'">'.$data.'</td>';
            }

            
            //$textStyle = $textStyleTemp;
            
            // for each linkColumn 
            for( $indx=0; $indx<count($linkColumns); $indx++) {
                
                $columnEntry = $linkColumns[ $indx ];
                $label = $columnEntry[ 'label' ];
                $link = $columnEntry[ 'link' ];
                $fieldName = $columnEntry[ 'field' ];
                
                $data = '<a href="'.$link.$entry->$fieldName.'">'.$label.'</a>';
                echo '<td class="'.$textStyle.'">'.$data."</td>\n";
            }
            
            $displayLink = true;
            // check link inclusion conditions, these mean that the link is 
            // to be only included if the data meets one or more of the values specified
            if ( isset( $linkInclusionCondition ) )
            {
                $displayLink = false;  // assume the data doesn't meet the condition
                // try and find some data that matches
                foreach( $linkInclusionCondition as $fieldName=>$arrayOfInclusionValues  )
                {
                    // print_r($linkInclusionCondition);
                    // echo '$fieldName['.$fieldName.']<br/>';
                    $data = $entry->$fieldName;
                    // echo '$data['.$data.']<br/>';
                    // echo "exclusion condition set<br/>";
                    foreach ( $arrayOfInclusionValues as $key=>$value)
                    {
                        if ( $data == $value )
                        {
                            $displayLink = true;
                            break;
                        }
                    } // foreach   
                }
            } // isset( $linkInclusionCondition )
            
            // make sure none of the link exclusion values are met
            if ( isset( $linkExclusionCondition ) && $displayLink )
            {
                foreach( $linkExclusionCondition as $fieldName=>$arrayOfExclusionValues  )
                {
                    // echo '$fieldName['.$fieldName.']<br/>';
                    $data = $entry->$fieldName;
                    // echo '$data['.$data.']<br/>';
                    // echo "exclusion condition set<br/>";
                    foreach ( $arrayOfExclusionValues as $key=>$value)
                    {
                        if ( $data == $value )
                        {
                            $displayLink = false;
                            break;
                        }
                    } // foreach   
                }
            } // isset( $linkExclusionCondition )
    
            if ( !isset($linkValues['edit']) ) {
                $editLink = '#';
                $editLabel = '';
            } else {
                $editLink = $linkValues['edit'];
                $currentEditLink = $editLink.$entry->$primaryKeyFieldName;
                $currentEditLink .= '&admOpType=U';
                $editLabel = '<a href="'.$currentEditLink.'">'.$linkLabels[ 'edit' ].'</a>';
            }
            
            
            if ( !isset($linkValues['del']) ) {
                $deleteLink = '#';
                $deleteLabel = '';
            } else {
                $deleteLink = $linkValues['del'];
                $currentDeleteLink = $deleteLink.$entry->$primaryKeyFieldName;
                $currentDeleteLink .= '&admOpType=D';
                $deleteLabel = '<a href="'.$currentDeleteLink.'">'.$linkLabels[ 'del' ].'</a>';
            }
            
            
            echo '<td align="right" class="text">';
            
            if ( $displayLink )             
            {   echo $editLabel;
                if (($editLabel != '') && ($deleteLabel != '')) {
                    echo ' | ';
                } 
                echo $deleteLabel;
            }
            echo '</td>';
    
            echo '</tr>';
            
//        } else {
        
            // display form data
//            echo $formRowData;
        }
    
        $numEntries ++;
    }
    

    
?> 
</table>
<hr>
<? 
    
    if ( isset($linkValues['cont']) ) {
        echo '<div class="text" align="right"><a href="'.$linkValues['cont'].'">'.$linkLabels['cont'].'</a></div>';
    }
  
?>
