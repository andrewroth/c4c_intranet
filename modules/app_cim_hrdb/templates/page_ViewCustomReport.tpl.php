<?
/*
 * genDataList.php
 *
 * This template displays a set of data in a grid.
 *
 * Required Template Variables:
 *  $pageLabels :   The values of the labels to display on the page.
 *  $linkValues :   Array of link href values. linkValue[ 'key' ] = 'href';
 *  $linkLabels :   Array of link lables. linkLabels[ 'key' ] = 'Label';
 *  $linkColumns:   Array of columns with links to other pages.
 *                  $columnEntry = $linkColumns[0];
 *                  $columnEntry['title'] = Label to display for the Title
 *                  $columnEntry['label'] = Label to display on the page
 *                  $columnEntry['link' ] = The link to use 
 *                  $columnEntry['field' ] = Name of the field to use for the 
 *                      rest of the link data.
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
<p><span class="heading"><? echo $templateTools->getPageLabel('[Title]');
if ((isset($subheading))&&($subheading != ''))
{
	echo '<br>( '.$subheading.' )';
}
?></span></p>
<p><span class="text"><? echo $templateTools->getPageLabel('[Instr]'); ?></span>
<? 
    // If the download CSV link Exists ... add it here.
    if ( isset($downloadLink[ 'DownloadCustomReportCSV' ]) ) {
        echo '<div align="right" class="text" ><a href="'.$downloadLink[ 'DownloadCustomReportCSV' ].'">'.$linkLabels['DownloadCustomReportCSV'].'</a></div>';
    }  
 echo '</p>';

}// end display heading


    // If an Add Link Exists ... add it here.
    if ( isset($linkValues['add']) ) {
        echo '<div align="right" class="text" ><a href="'.$linkValues['add'].'">'.$linkLabels['add'].'</a></div>';
    } 
    
    
?>
<hr>
<table width="100%" border="0">
<tr valign="top" <?= $rowColor;?> >
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
    $data = $listLabels['title_'.$dataFieldList[ $indx ]];	//$templateTools->getPageLabel('[title_'.$dataFieldList[ $indx ].']');  NOTE: this is ONLY change made to siteDataList
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
    // echo 'the entryKey is ['. $entryKey . ']<br/>';
    /*
     *  For each entry ...
     */
    $numEntries = 0;
    //print_r($dataList->$entryKey);
    foreach ($dataList->$entryKey as $entry) {
    
//          echo '<pre>';
//          print_r($entry);
//          echo '</pre>';
        
        $templateTools->swapBGColor( $rowColor );
        
        //
        // Put any text formatting logic here :
        // 
        $textStyle = 'text';
        
        // start a new row
        echo '<tr valign="top" '.$rowColor.' >';
        
        // for each data field to display
        //echo 'The dataFieldList<br/>';
        //print_r( $dataFieldList );
        //echo "<br><br>";
        
        for ($indx=0; $indx<count( $dataFieldList ); $indx++) {
            
            $data = $entry->$dataFieldList[ $indx ];
            $textStyle = 'text';
            
          // added March 18, 2008: translates date into user-friendly format   
          $date_regex = '/[2-9]([0-9]{3})\-[0-9]{1,2}\-[0-9]{1,2}/';	
			 if (preg_match($date_regex, $data) >= 1)
			 {
				 $time = strtotime($data);
				 $data = strftime("%d %b %Y",$time);;
			 }           
            
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
            if (isset($$listName) ) {

                $data = $templateTools->returnIndexValue( $data, $$listName);

            }
            
            
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
           //print ("textStyle = " . $textStyle . "<br>");
            echo '<td class="'.$textStyle.'">'.$data.'</td>';
        }  // for each dataField 
        
       	  
        // flag indicating whether link column has alternative text to be used
//         $useAltText = false;  

        // for each linkColumn 
        for( $indx=0; $indx<count($linkColumns); $indx++) {
            
	         $keyData = '';
            $columnEntry = $linkColumns[ $indx ];
            
            // determine if the variables are inited for using alternative link text
            if (isset($linkColumnFilter)) 
            {
	            
// 	             echo "linkColumnFilter = <pre>".print_r($linkColumnFilter,true)."</pre>";
	        
					if (isset($linkColumnFilter[$columnEntry[ 'title' ]]))
					{
						$columnTitle = $columnEntry[ 'title' ];
						$filterArray = $linkColumnFilter[$columnTitle];

						$keyData = $entry->$dataFieldList[0];	// ASSUMPTION: want to use last column's data as a filter value

	            }
            }
//             
//             echo "filter_array = <pre>".print_r($filterArray,true)."</pre>";
// 					echo "data = ".$keyData."<BR>";

          
            // use alternative text and URL for the link if the field value is mapped to alternative text
   			if (isset($filterArray))
   			{
// 	   			echo "filter: <pre>".print_r($filterArray,true)."</pre>";
	   			
	   			$totalLinkTypes = $columnEntry[ 'count' ];

	   			for ($i=0; $i < $totalLinkTypes; $i++)	// set link type based on filter array element linked to prev. column's data
	   			{

		   			if ($filterArray[(string)$keyData] == $i)
		   			{
			   	      $label = $columnEntry[ 'label'.$i ];
			            $link = $columnEntry[ 'link'.$i ];
			            $fieldName = $columnEntry[ 'field'.$i ];	
		            }
	            }
            }		
            else
            {
	   	      $label = $columnEntry[ 'label' ];
	            $link = $columnEntry[ 'link' ];
	            $fieldName = $columnEntry[ 'field' ];		        
            }    
            
            $data = '<a href="'.$link.$entry->$fieldName.'">'.$label.'</a>';
            echo '<td class="'.$textStyle.'">'.$data."</td>\n";
            
            $filterArray = null;
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
        if ( isset( $linkExclusionCondition ) )
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
        
        

        // set the item's edit & delete link
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


        // close row
        echo '</tr>';

        $numEntries ++;
    
    } // for
?> 
</table>
<hr>
<div class="text" align="right"><? 
    
    // if the number of entries get too long (>15?) then add another 
    // ADD link to the bottom of the list.  
    $addLabel = '';  
    if ($numEntries > 15 ) {
        if ( isset($linkValues['add']) ) {
            $addLabel = '<a href="'.$linkValues['add'].'">'.$linkLabels['add'].'</a>';
        }
    }
    
    // display Continue Link if provided
    $continueLabel = '';
    if ( isset($linkValues['cont']) ) {
        $continueLabel = '<a href="'.$linkValues['cont'].'">'.$linkLabels['cont'].'</a>';
    }
    
    echo $addLabel;
    if (($addLabel != '') && ($continueLabel != '')) {
        echo '&nbsp;&nbsp;|&nbsp;&nbsp;';
    }
    echo $continueLabel;
  
?></div>
