<?php


define( 'EXCEL_FORMAT_TITLE', 'Title');
define( 'EXCEL_FORMAT_SUBTITLE', 'sTitle');
define( 'EXCEL_FORMAT_HEADING', 'Heading');
define( 'EXCEL_FORMAT_TEXT_COLOR_ON', 'TextOn');
define( 'EXCEL_FORMAT_TEXT_COLOR_OFF', 'TextOff');
define( 'EXCEL_FORMAT_NOTE_SMALL', 'NoteSm');
define( 'EXCEL_FORMAT_SPACER', 'Spacer');
define( 'EXCEL_FORMAT_TEXT_MERGE', 'TextMerge');

class  EazyReport extends DisplayObject_MySQLDB {
// 
//  DESCRIPTION:
//		This is the base Administrative Entry Class.  It handles the internal Displaying of the 
//		form, the loading of data from the form, routines to check the validity of the data, etc...
//
//	CONSTANTS:

//
//	VARIABLES:

	var $ClassTitle;
	var $DatabaseName;
	
	var $LanguageID;

	var $ScopeModifier;
	
	var $Labels;
	var $Values;				// This variable holds values that have been calculated as the report
								// was run.  It is useful if there are possible values generated for 1 
								// field that might be used in the calculation of another field.
	
	var $Delimiter;
	
	var $GroupList;
	var $GroupTableLookup;
	var $GroupLabelLookup;
	var $GroupIDLookup;
	var $GroupLookupSpecial;
	var $aGroups;
	
	var $GivenFieldList;
	var $FieldLookup;
	var $FieldList;
	var $aFields;
	
	var $TableList;
	var $WhereClause;
	
	var $SessionTimeout;
	var $NumColumns;
	var $OutputTable;
	var $SpacerCell;
	var $RowColorOn;
	var $RowColorOff;
	
	var $lookUpDB;
	
	/*
	 * Excell Sheet Additions ....
	 *
	 */
	var $isExcelSheet;			// Boolean: Is this output for an Excell Sheet?
	var $ExcelWorkBook;			// The Excell Workbook...
	var $seperateMajorGroups;	// Boolean: Should we put each Main Group on to it's own sheet?
	

//
//	CLASS CONSTRUCTOR
//

	//************************************************************************
	function EazyReport( $LanguageID) {
		
		DisplayObject_MySQLDB::DisplayObject_MySQLDB( $this->DatabaseName, DB_PATH, DB_USER, DB_PWORD);
		
		$this->InitDB();
		
		set_time_limit( $this->SessionTimeout ); 

		$this->LanguageID = $LanguageID;
		
	
		$this->Title = $this->Labels->Label('['.$this->ClassTitle.']');

		// Initialize Group Data
		$this->aGroups = explode( $this->Delimiter, $this->GroupList );
		$this->InitGroupLookups();
		
		// Initialize Field Data
		$this->aFields = explode( $this->Delimiter, $this->GivenFieldList );
		$this->InitFieldLookup();
		$this->GenerateFieldList();
		
		$this->lookUpDB = new Database_MySQL();
		$this->lookUpDB->ConnectToDB( $this->DatabaseName, DB_PATH, DB_USER, DB_PWORD);
		
		$this->isExcelSheet = false;		// Default Behavior = HTML reports ...
		
		// If we haven't already set the seperateMajorGroups value then ... (make sure we don't overwrite a report setting)
		if ( isset( $this->seperateMajorGroups) == false) {
		
			$this->seperateMajorGroups = false;	// Default Behavior is to not seperate Main Groups
		}
		
	}


//
//	CLASS FUNCTIONS:
//
	
	//************************************************************************
	function InitDisplay() {
	//
	// DESCRIPTION
	//   This function prepares the Data for display.  
	//
	
		// Get the Total Number of Columns needed for the output Table...
		$this->NumColumns = (count($this->aGroups) - 1) + count($this->aFields);
	
		if ( $this->isExcelSheet == false ) {	
			// Create Output Table
			$this->OutputTable = new Table( $this->NumColumns, 'width="100%" border="0" cellpadding="1" cellspacing="1"');
		} else {
		
// Check to see if GroupList has been defined... 
// if not, then Name this sheet "Report" else Name this Sheet : Summary or Description
//
			$this->ExcelWorkBook->AddSheet( 'Description', 'Description', $this->NumColumns);
		}
	
	
		// Take the Standard WhereClause and add on any Scope Modifier
		$TempCondition = $this->WhereClause;
		if ( $this->ScopeModifier != '' ) {
			$TempCondition = '('.$TempCondition.') AND '.$this->ScopeModifier;
		}
		
		// Add Report Title 
		$this->MakeTitle();		
		
		// Now start Recursing through the Groupings to piece together the report
		$this->RecurseGroupings( 0, $TempCondition);
		
		// If this is a normal HTML Report then ...
		if ( $this->isExcelSheet == false ) {
		
			// When finished, Start piecing together the output data & Add it to the DisplayList
			$PreContent = '<table width="100%" border="0" cellpadding="6" cellspacing="6">
			<tr> 
			  <td height="30" valign="top">';
			$this->AddToDisplayList( $PreContent );
			
			$this->AddToDisplayList( $this->OutputTable, DISPLAYOBJECT_TYPE_OBJECT );
		
			$PostContent = '</td></tr></table>';
			$this->AddToDisplayList( $PostContent );
		}
	
	}
	
	
	
	//************************************************************************
	function MakeTitle() {
	// 
	// DESCRIPTION
	//   This routine draws the Title for the Reports in this site.
	//
	
		$Temp = 'Class_EazyReport::MakeTitle This function has not been defined by your Report Site.<br>';

		if ($this->isExcelSheet == false) {

			$this->OutputTable->AddTableCell( $Temp, '', DISPLAYOBJECT_TYPE_HTML, $this->NumColumns);

		} else {
		
			$this->ExcelWorkBook->AddCell( $Temp, EXCEL_FORMAT_TITLE, $this->NumColumns);		
		}
	
	}
	
	
	
	//************************************************************************
	function RecurseGroupings( $GroupIndx, $Condition) {


		// If ( we were given a group list) AND if ( we haven't processed all the groups)
		if (($this->GroupList != '') && ( $GroupIndx < count($this->aGroups) )) {
			
				// Get FieldName and ConditionStatement associated with Current Group Entry
				$GroupTable = $this->GroupTableLookup[ $this->aGroups[ $GroupIndx ] ]; //'regions';
				$GroupLabel =  $this->GroupLabelLookup[ $this->aGroups[ $GroupIndx ] ];//'region_label';
				$GroupID =  $this->GroupIDLookup[ $this->aGroups[ $GroupIndx ] ]; //'region_id';
				
				// Get associated Groups
				$SQL = 'SELECT DISTINCT '.$GroupTable.'.'.$GroupLabel.', '.$GroupTable.'.'.$GroupID.' FROM '.$this->TableList.' WHERE '.$Condition.' ORDER BY '.$GroupTable.'.'.$GroupLabel;
//echo $SQL."<br>";
				$GroupDB = new Database_MySQL();
				$GroupDB->ConnectToDB( $this->DatabaseName, DB_PATH, DB_USER, DB_PWORD);
				$GroupDB->RunSQL( $SQL );
				
				$CountDB = new Database_MySQL();
				$CountDB->ConnectToDB( $this->DatabaseName, DB_PATH, DB_USER, DB_PWORD);
				
				
				// For each Group
				while ( $Row = $GroupDB->RetrieveRow() ) {
				
					 // Add appropriate spacers for this level
					 for ($SpacerIndx=0; $SpacerIndx < $GroupIndx; $SpacerIndx++) {
					 	$this->AddSpacer();
					 }
					 
					 // Modify Condition Statement (for next Recursion call)
					 $TempCondition = '('.$Condition.') AND '.$GroupTable.'.'.$GroupID."='".$Row[ $GroupID ]."'";

					 
					 // Print Group Label
					 $TempColumns = $this->NumColumns - $GroupIndx;

					 $SQL = 'SELECT COUNT(*) as count  FROM '.$this->TableList.' WHERE '.$TempCondition;
					 $CountDB->RunSQL( $SQL );
					 $CountRow = $CountDB->RetrieveRow();
					 
					 if ($Row[ $GroupLabel ] == '' ) {
						 $TempLabel = '<span class="bold">??</span> <span class="text">| '.$CountRow['count'].' matches found:';
					 } else {
					 	
						 // if this is a normal HTML report ...
					 	if ( $this->isExcelSheet == false ) {
						
							// If NO Special Lookup is labeled ...
							if (isset( $this->GroupLookupSpecial[  $this->aGroups[ $GroupIndx ] ] ) == false ) {
								
								// The Proper Display is the actual Values of the Group Label	
								$TempLabel = '<span class="bold">'.$Row[ $GroupLabel ].'</span> <span class="text">| '.$CountRow['count'].' matches found:';
							
							} else {
							
								// The Proper Display will be defined in the ReturnSpecialGroupLookup() function.
								$TempLabel = '<span class="bold">'.$this->ReturnSpecialGroupLookup( $this->aGroups[ $GroupIndx ], $Row[ $GroupLabel ] ).'</span> <span class="text">| '.$CountRow['count'].' matches found:';
							}
							
						} else {
						
							// If NO Special Lookup is labeled ...
							if (isset( $this->GroupLookupSpecial[  $this->aGroups[ $GroupIndx ] ] ) == false ) {
								
								// The Proper Display is the actual Values of the Group Label	
								$TempLabel = $Row[ $GroupLabel ].'| '.$CountRow['count'].' matches found:';
								
								// Set the Sheet Name (used if this is GroupIndex==0)
								$TempSheetName = $Row[ $GroupLabel ];
							
							} else {
							
								// The Proper Display will be defined in the ReturnSpecialGroupLookup() function.
								$TempLabel = $this->ReturnSpecialGroupLookup( $this->aGroups[ $GroupIndx ], $Row[ $GroupLabel ] ).' | '.$CountRow['count'].' matches found:';
								
								// Set the Sheet Name (used if this is GroupIndex==0)
								$TempSheetName = $this->ReturnSpecialGroupLookup( $this->aGroups[ $GroupIndx ], $Row[ $GroupLabel ] );
							}

						}
					 }
					 
					 //
					 // OK, this next section is designed to allow you to have different types of displays for:
					 //		a) the main header ($GroupIndx==0)
					 //		b) the final group title right before the data is displayed ( $GroupIndx == (count($this->aGroups)-1))
					 //		c) any group titles in between a & b ...
					 //
					 //	However as you can see, they currently all display the same thing.  All Group Headers look
					 //	identical.  The only difference is in the Excel functions that allow you to seperate Major
					 // groups into different Sheets.
					 //					 
					 
					 // if this Group is the Top Group (1st & Largest ...) ...
					 if ( $GroupIndx == 0 ) {
					 
					 	// if this is a normal HTML report ...
					 	if ( $this->isExcelSheet == false ) {
							// Add to OutputTable ...
							$this->OutputTable->AddTableCell( $TempLabel, '', DISPLAYOBJECT_TYPE_HTML, $TempColumns);
						} else {
							
							// if we marked the seperate Major Groups flag, 
							if ($this->seperateMajorGroups == true) { 
								//then Add Label to Description
								$this->ExcelWorkBook->setCurrentSheet( 'Description' );
								$this->ExcelWorkBook->AddCell( $TempLabel, EXCEL_FORMAT_SUBTITLE, $TempColumns);
								
								// Create new Sheet with this label as Sheet Name
								$this->ExcelWorkBook->AddSheet( $TempSheetName, $TempSheetName, $this->NumColumns);
							}
							
							// Add Label to Excel Workbook
							$this->ExcelWorkBook->AddCell( $TempLabel, EXCEL_FORMAT_SUBTITLE, $TempColumns);
						}
						 
					// if this group is the last group before the data ...
					 } elseif ( $GroupIndx == (count($this->aGroups)-1)) {
					 	
						 // if this is a normal HTML report ...
					 	if ( $this->isExcelSheet == false ) {
							// Add to OutputTable ...
							$this->OutputTable->AddTableCell( $TempLabel, '', DISPLAYOBJECT_TYPE_HTML, $TempColumns);
						} else {
							// Add to Excel Workbook
							$this->ExcelWorkBook->AddCell( $TempLabel, EXCEL_FORMAT_SUBTITLE, $TempColumns);
						}
					 
					 // else this group is an intermediary group ...
					 } else {
					 
						 // if this is a normal HTML report ...
					 	if ( $this->isExcelSheet == false ) {
							// Add to OutputTable ...
							$this->OutputTable->AddTableCell( $TempLabel, '', DISPLAYOBJECT_TYPE_HTML, $TempColumns);
						} else {
							// Add to Excel Workbook
							$this->ExcelWorkBook->AddCell( $TempLabel, EXCEL_FORMAT_SUBTITLE, $TempColumns);
						}
					 }
					 
					 // Recurse the Next Level of Groups
					 $this->RecurseGroupings( $GroupIndx+1, $TempCondition);
					
				}// Next Group
				
		} else { // Else
			
			// Now display all the requested Data associated with this Query
			if ($GroupIndx > 0 ) {
				$this->PrintData( $GroupIndx-1, $Condition);
			} else {
				$this->PrintData( 0, $Condition);
			}
					
		} // end if
	
	}
	
	
	//************************************************************************
	function PrintData( $Indx, $Condition ) {
	
		// Get Data from DB
		$SQL = 'SELECT '.$this->FieldList.' FROM '.$this->TableList.' WHERE '.$Condition;
		if (isset( $this->OrderByList ) == true) {
			$SQL .= ' ORDER BY '.$this->OrderByList;
		} else {
			$SQL .= ' ORDER BY '.$this->FieldList;
		}
		
		$DataDB = new Database_MySQL();
		$DataDB->ConnectToDB( $this->DatabaseName, DB_PATH, DB_USER, DB_PWORD);
		$DataDB->RunSQL( $SQL );
		
		// if this is an HTML report ...
		if ( $this->isExcelSheet == false ) {
			// Set Color to RowColorOn...
			$BGColor = $this->RowColorOn;
		} else {
			// Set Format to EXCEL_FORMAT_TEXT_COLOR_ON
			$BGColor = EXCEL_FORMAT_TEXT_COLOR_ON;
		}
		
		// Add Leading Spacers
		for ($SpacerIndx=0; $SpacerIndx < $Indx; $SpacerIndx++) {
			$this->AddSpacer();
		}
		
		// For each Field in List
		for ($FieldIndx=0; $FieldIndx < count( $this->aFields ); $FieldIndx++) {
		
			// Add Heading for Field
			$Heading = $this->ReturnFieldHeading( $this->aFields[ $FieldIndx ] );
			
			$this->WriteHeading( $Heading, $BGColor );
			// if this is an HTML report ...
/*			if ( $this->isExcelSheet == false ) {
				// Add Header to output table...
				$this->OutputTable->AddTableCell( '<strong>'.$Heading.'</strong>', $BGColor.' class="modify" valign="bottom" ');
			} else {
				// Add Header to Excel Workbook
				$this->ExcelWorkBook->AddCell( $Heading, EXCEL_FORMAT_HEADING );
			}
*/			
		}// Next Field
		
		// For each value returned
		while ($this->Row = $DataDB->RetrieveRow() ) {
		
			$BGColor = $this->ToggleColor( $BGColor);
			
			
			// Add Leading Spacers
			for ($SpacerIndx=0; $SpacerIndx < $Indx; $SpacerIndx++) {
				$this->AddSpacer();
			}

			// For each Field in List
			for ($FieldIndx=0; $FieldIndx < count( $this->aFields ); $FieldIndx++) {
			
				// Output Value
				$TempValue = $this->ReturnFieldValue( $this->aFields[ $FieldIndx ] );
				
				// if this is an HTML report ...
				if ( $this->isExcelSheet == false ) {
				
					// Add Data to output table...
					$this->OutputTable->AddTableCell( $TempValue, $BGColor.' class="modify" valign="top" ');
					
				} else {
				
					// Add Data to Excel Workbook
					$this->ExcelWorkBook->AddCell( $TempValue, $BGColor );
				}
				
				
			}// Next Field
			
		}// next
		
		

		
		// if this is an HTML report ...
		if ( $this->isExcelSheet == false ) {
		
			for ($SpacerIndx=0; $SpacerIndx < $Indx; $SpacerIndx++) {
				$this->AddSpacer();
			}
		
			// Add a Row of Spacers ...
			$this->OutputTable->AddTableCell( '<hr width="100%" size="1" noshade color="#223450">', $this->SpacerCell, DISPLAYOBJECT_TYPE_HTML, $this->NumColumns - $SpacerIndx  );
			
		} else {
		
			// Add 2 Rows of Spaces
			for ($SpacerIndx=0; $SpacerIndx < ( $this->NumColumns * 2); $SpacerIndx++) {
				$this->AddSpacer();
			}
//			// Add Data to Excel Workbook
//			$this->ExcelWorkBook->AddCell( '-----------------------', '' ,$this->NumColumns - $SpacerIndx );
		}
		
		
	}
	
		
	
	//************************************************************************
	function GenerateFieldList() {
	//
	// DESCRIPTION
	//	This routine takes the given Fields provided by the Report, and translates
	//  them into a list of DB Column Names using the FieldLookup[] variables.
	//
		
		$InitialList = '';
		
		// Build Initial List of All Fields we want to pull from the DB.
		for ($FieldIndx=0; $FieldIndx < count( $this->aFields ); $FieldIndx++) {
		
			if ( $FieldIndx == 0) {
				$InitialList = $this->FieldLookup[ $this->aFields[$FieldIndx] ];
			} else {
				$InitialList .= ','.$this->FieldLookup[ $this->aFields[$FieldIndx] ];
			}
		}
		
		// Create Array out of Initial List
		$InitialListArray = explode( ',', $InitialList);
		
		// Create Empty Resulting Array
		$ResultArray = array();
		
		for( $Indx=0; $Indx < count( $InitialListArray ); $Indx++) {
		
			if ( in_array( $InitialListArray[$Indx], $ResultArray ) == false ) {
				$ResultArray[] = $InitialListArray[$Indx];
			}
		}
		
		// Now turn Resulting array into a String of values ...
		for ($FieldIndx=0; $FieldIndx < count( $ResultArray ); $FieldIndx++) {
		
			if ( $FieldIndx == 0) {
				$TempList = $ResultArray[$FieldIndx];
			} else {
				$TempList .= ', '.$ResultArray[$FieldIndx];
			}
		}
		
		$this->FieldList = $TempList;
	}
	
	
	
	//************************************************************************
	function ReturnFieldValue( $Key ) {
	
		$Result = 'Class_EazyReport::ReturnFieldValue This function has not been defined by your Report Site.<br>';
		
		return $Result;
	}
	
	
	//************************************************************************
	function ReturnFieldHeading( $Key ) {
	//
	// DESCRIPTION
	//   This function returns the proper Heading for the given field.
	//
	//   In this routine these headings are stored in the Multi Lingual Labels for this report.
	//
		
		$Result =  $this->Labels->Label('['.$Key.']');
		
		return $Result;
	}
	
	
	//************************************************************************
	function ToggleColor( $Color ) {
	
		// if this is an HTML report ...
		if ( $this->isExcelSheet == false ) {
			
			if ($Color == $this->RowColorOn) {
				$Return = $this->RowColorOff;
			} else {
				$Return = $this->RowColorOn;
			}
		
		} else {
			
			if ($Color == EXCEL_FORMAT_TEXT_COLOR_ON) {
				$Return = EXCEL_FORMAT_TEXT_COLOR_OFF;
			} else {
				$Return = EXCEL_FORMAT_TEXT_COLOR_ON;
			}
		}
			
		return $Return;
	}
	
	
	
	//************************************************************************
	function InitGroupLookups() {
	
		echo "Class_EazyReport::InitGroupLookups This function has not been defined by your Report Site.<br>";	
		
	}
	
	
	
	//************************************************************************
	function InitFieldLookup( ) {
		
		echo "Class_EazyReport::InitFieldLookups This function has not been defined by your Report Site.<br>";	
		
	}
	
	

	
	
	//************************************************************************
	function DrawDirect() {
	
		// Make sure all data is properly gathered and prepared....
		$this->InitDisplay();
		
		// if this is not an Excel sheet then display the HTML
		if ($this->isExcelSheet == false) {
		
			DisplayObject::DrawDirect();
			
		} else {
		
			// Send the Excel Workbook
			$this->ExcelWorkBook->DrawDirect();
		}
	}
	
	
	//************************************************************************
	function Draw() {
	
		$this->InitDisplay();
		
		if ($this->isExcelSheet == false) {
		
			DisplayObject::Draw();
			
		} else {
		
			$this->ExcelWorkBook->Draw();
		}
	
	}
	
	
	//************************************************************************
	function SetExcel( $isStored=false ) {
	// 
	// DESCRIPTION
	//	This Function will setup this report as an Excel Workbook.
	//	
		$this->isExcelSheet = true;
		
		$this->ExcelWorkBook = new ExcelDocument( $this->ClassTitle.'.xls', $isStored );
		
		// Initialze Formatting Data ...
		$this->ExcelWorkBook->SetCustomColor( 14,'#DDDDDD');  // Use the same Index as Text Color On
		
		$this->ExcelWorkBook->AddFormat( EXCEL_FORMAT_TITLE, 'Bold,FontSize:48,Italic');
		$this->ExcelWorkBook->AddFormat( EXCEL_FORMAT_SUBTITLE, 'Bold,FontSize:11');
		$this->ExcelWorkBook->AddFormat( EXCEL_FORMAT_HEADING, 'Bold,FontSize:10,CellColor:23,FontColor:8,TextWrap');
		$this->ExcelWorkBook->AddFormat( EXCEL_FORMAT_TEXT_COLOR_ON, 'FontSize:10,CellColor:14,TextWrap');
		$this->ExcelWorkBook->AddFormat( EXCEL_FORMAT_TEXT_COLOR_OFF, 'FontSize:10,TextWrap');
		$this->ExcelWorkBook->AddFormat( EXCEL_FORMAT_NOTE_SMALL, 'FontSize:10,Italic,FontColor:23');
		$this->ExcelWorkBook->AddFormat( EXCEL_FORMAT_SPACER, 'FontSize:8');
		$this->ExcelWorkBook->AddFormat( EXCEL_FORMAT_TEXT_MERGE, 'FontSize:10,Merge,TextAlignLeft');
	}
	
	
	//************************************************************************
	function AddSpacer() {
	// 
	// DESCRIPTION
	//	
	//	

		// if this is an HTML report ...
		if ( $this->isExcelSheet == false ) {
		
			// Add spacer to output table...
			$this->OutputTable->AddTableCell( '&nbsp;', $this->SpacerCell);
			
		} else {
		
			// Add empty cell to Excel Workbook
			$this->ExcelWorkBook->AddCell( ' ', EXCEL_FORMAT_SPACER );
		}
	
	}
	
	
	
	//************************************************************************
	function convertToExcelData( $Data ) {
	//			$Data		VARIABLE	The data we are wanting to convert to display properly... 
	//
	// DESCRIPTION
	//	This routine will make sure that String Data will be modified to properly
	//	display in Excel (as opposed to HTML).
	//	

		if ( is_string( $Data )  == true ) {
		
			switch ( $Data ) {
				
				case '':
				case '&nbsp;':
					$Data = ' ';
					break;
				
				default:
					$Data = str_replace( '<br>', "\n", $Data);
					break;
			}
		}
	
		return $Data;
	}
	
	
	
	//************************************************************************
	function WriteTitle( $Value ) {
	// 
	// DESCRIPTION
	//	This Function writes a Data Value out to the proper output.
	//	
	
		// if this is an HTML report ...
		if ( $this->isExcelSheet == false ) {
		

			$this->OutputTable->AddTableCell( '<span class="heading">'.$Value.'</span>', '', DISPLAYOBJECT_TYPE_HTML, $this->NumColumns);
//			$this->OutputTable->AddTableCell( '&nbsp;', '', DISPLAYOBJECT_TYPE_HTML, $this->NumColumns);

		} else {
			$this->ExcelWorkBook->AddCell( $Value, EXCEL_FORMAT_TITLE, $this->NumColumns );
		}
	
	}
	
	//************************************************************************
	function WriteHeading( $Value, $Color ) {
	// 
	// DESCRIPTION
	//	This Function writes a Data Value out to the proper output.
	//	

		// if this is an HTML report ...
		if ( $this->isExcelSheet == false ) {
		
			$this->OutputTable->AddTableCell( 				// Add Value to Output Table
											'<strong>'.$Value.'</strong>', 
											$Color.' class="modify" valign="Bottom" '
											);
		} else {
			$ConvertedValue = $this->convertToExcelData( $Value);
			$this->ExcelWorkBook->AddCell( $ConvertedValue,  $Color);
		}
	}	
	
	//************************************************************************
	function WriteValue( $Value, $Color ) {
	// 
	// DESCRIPTION
	//	This Function writes a Data Value out to the proper output.
	//	

		// if this is an HTML report ...
		if ( $this->isExcelSheet == false ) {
		
			$this->OutputTable->AddTableCell( 				// Add Value to Output Table
										$Value, 
										$Color.' class="modify" valign="Top" '
										);
		} else {
			$this->ExcelWorkBook->AddCell( $Value,  $Color);
		}
	
	}
	
	//************************************************************************
	function WriteBoldValue( $Value, $Color ) {
	// 
	// DESCRIPTION
	//	This Function writes a Data Value out to the proper output.
	//	

		// if this is an HTML report ...
		if ( $this->isExcelSheet == false ) {
		
			$this->OutputTable->AddTableCell( 				// Add Value to Output Table
											'<strong>'.$Value.'</strong>', 
											$Color.' class="modify" valign="Top" '
											);
		} else {
			$this->ExcelWorkBook->AddCell( $Value, EXCEL_FORMAT_SUBTITLE);
		}
	
	}
	
	//************************************************************************
	function WriteMergedText( $Value, $Color, $NumSpaces ) {
	// 
	// DESCRIPTION
	//	This Function writes a Data Value out to the proper output.
	//	

		// if this is an HTML report ...
		if ( $this->isExcelSheet == false ) {
		
			$this->OutputTable->AddTableCell( 				// Add Value to Output Table
											$Value, 
											$Color.' class="modify" valign="Top" ',
											DISPLAYOBJECT_TYPE_HTML,
											$NumSpaces
											);
		} else {
			$this->ExcelWorkBook->AddCell( $Value, EXCEL_FORMAT_TEXT_MERGE);	// Add Value to output
			
			for($Indx=1; $Indx<$NumSpaces; $Indx++){							// Now for NumSpaces -1 additional spaces
				$this->ExcelWorkBook->AddCell( "", EXCEL_FORMAT_TEXT_MERGE);	// add merged cells
			}
			
		}
	
	}
	
	
	//************************************************************************
	function Template() {
	// 
	// DESCRIPTION
	//	
	//	

	
	}
	

}




class  EazySummaryReport extends EazyReport {
// 
//  DESCRIPTION:
//		This is a display class for creating Summary Reports.  These reports are 
//		different from normal reports in that their method of describing them can
//		be very complex.
//
//	CONSTANTS:

//
//	VARIABLES:
var $HeaderKeys;			// ARRAY(STRING)	The Label Keys for the Headers That should be displayed
var $HeaderKeysList;		// STRING			The List of keys to be put into the HeaderKeys Array

var $Group_Title;			// ARRAY(STRING)	The Label Key for The Group Title 
var $Group_Table;			// ARRAY(STRING)	The Common Table Definitions for a Group of Summary Statements.
var $Group_Clause;			// ARRAY(STRING)	The Common Where Clause conditions for a Group of Summary Statements
var $Group_isCommonSQL;		// ARRAY(BOOL)		Indicates if the Row_Conditions are based upon (added to) the Group_Clause.
var $Group_PostProcessingFn;// ARRAY(STRING)	The Name of a function to call when this Group has been completed.
var $GroupIndx;				// INTEGER			The Current Index into the Group array ...

var $Column_ValueKey;		// ARRAY(STRING)	The actual data we want displayed for this column.
var $Column_Condition;		// ARRAY(STRING)	Additional Conditional Data for this Column

var	$Row_LabelKey;			// ARRAY(STRING)	The Label Keys for the Row Label that should be Displayed.
var	$Row_Condition;			// ARRAY(STRING)	Additional Conditional Info for data on current Row

var $BGNDColor;				// STRING			The Value to use for a Cell's Background Color
//
//	CLASS CONSTRUCTOR
//

	//************************************************************************
	function EazySummaryReport( $LanguageID, $Scope  ) {
		
		DisplayObject_MySQLDB::DisplayObject_MySQLDB( $this->DatabaseName, DB_PATH, DB_USER, DB_PWORD);
		
		$this->InitDB();
		
		set_time_limit( $this->SessionTimeout ); 

		$this->Title = $this->Labels->Label('['.$this->ClassTitle.']');

		$this->LanguageID = $LanguageID;
		
		$this->HeaderKeys = explode( $this->Delimiter, $this->HeaderKeysList);
		
			
		$this->lookUpDB = new Database_MySQL();
		$this->lookUpDB->ConnectToDB( $this->DatabaseName, DB_PATH, DB_USER, DB_PWORD);
		
		$this->isExcelSheet = false;		// Default Behavior = HTML reports ...
		
		// If we haven't already set the seperateMajorGroups value then ... (make sure we don't overwrite a report setting)
		if ( isset( $this->seperateMajorGroups) == false) {
		
			$this->seperateMajorGroups = false;	// Default Behavior is to not seperate Main Groups
		}

	}

//
//	CLASS FUNCTIONS:
//

	//************************************************************************
	function InitDisplay() {
	//
	// DESCRIPTION
	//   This function prepares the Data for display.  
	//
	
		// Get the Total Number of Columns needed for the output Table...
		$this->NumColumns = count($this->HeaderKeys);	// A column for each Header
	
		if ( $this->isExcelSheet == false ) {	
			// Create Output Table
			$this->OutputTable = new Table( $this->NumColumns, 'width="100%" border="0" cellpadding="1" cellspacing="1"');
		} else {

			$this->ExcelWorkBook->AddSheet( 'Description', 'Description', $this->NumColumns);
		}

		
		// Add Report Title 
		$this->MakeTitle();		
		
		// Now start Recursing through the Groupings to piece together the report
		$this->PrepareReport();
		
		// If this is a normal HTML Report then ...
		if ( $this->isExcelSheet == false ) {
		
			// When finished, Start piecing together the output data & Add it to the DisplayList
			$PreContent = '<table width="100%" border="0" cellpadding="6" cellspacing="6">
			<tr> 
			  <td height="30" valign="top">';
			$this->AddToDisplayList( $PreContent );
			
			$this->AddToDisplayList( $this->OutputTable, DISPLAYOBJECT_TYPE_OBJECT );
		
			$PostContent = '</td></tr></table>';
			$this->AddToDisplayList( $PostContent );
		}
	
	}
	
	
	
	//************************************************************************
	function PrepareReport() {
	// 
	// DESCRIPTION
	//	This is the routine that actually puts all the data together.
	//	

		// for each Group 
		for ( $this->GroupIndx=0; $this->GroupIndx<count($this->Group_Title); $this->GroupIndx++) {
		
		
			// if this is an HTML report ...
			if ( $this->isExcelSheet == false ) {
			
				if ($this->GroupIndx > 0) {
				
					// Add a Row of Spacers ...
					$this->OutputTable->AddTableCell( '<hr width="100%" size="1" noshade color="#223450">', $this->SpacerCell, DISPLAYOBJECT_TYPE_HTML, $this->NumColumns );
				}
			} else {
			
				$GroupName = $this->Labels->Label( '['.$this->Group_Title[$this->GroupIndx].']' );
				$this->ExcelWorkBook->AddSheet( $GroupName, $GroupName, $this->NumColumns);
	//			// Add Data to Excel Workbook
	//			$this->ExcelWorkBook->AddCell( '-----------------------', '' ,$this->NumColumns - $SpacerIndx );
			}

		
			// Print the Group Title
			$TempLabel = $this->Labels->Label( '['.$this->Group_Title[$this->GroupIndx].']' );
			$this->WriteTitle( $TempLabel );
//			$this->OutputTable->AddTableCell( '&nbsp;', '', DISPLAYOBJECT_TYPE_HTML, $this->NumColumns);
			
			// Now print the Headers
			$this->BGNDColor = $this->ToggleColor( $this->BGNDColor);
			for ($HeaderIndx=0; $HeaderIndx<count($this->HeaderKeys); $HeaderIndx++) {
			
				$Heading = $this->Labels->Label('['.$this->HeaderKeys[ $HeaderIndx ].']');
				$this->WriteHeading( $Heading, $this->BGNDColor );

			} // End Header
			
			
			$TableData = ' FROM '.$this->Group_Table[ $this->GroupIndx ];	// Only piece together the Table Info 1x per group
			
			// For Each Row ...
			for( $RowIndx=0; $RowIndx<count( $this->Row_Condition); $RowIndx++) {
				
				$this->BGNDColor = $this->ToggleColor( $this->BGNDColor);			// Toggle the Background Color
				
				if ( count( $this->Row_LabelKey) > 0 ) {			// If there are Row Labels, Display them
				
					$TempLabel = $this->Labels->Label( 
								'['.$this->Row_LabelKey[ $RowIndx ].']'
								);
					$this->OutputTable->AddTableCell( 
										'<strong>'.$TempLabel.'</strong>', 
										$this->BGNDColor.' class="modify" valign="Top" '
										);
				}
				
																	// Piece together Where Data 1x per Row
				$WhereData = ' WHERE '.$this->Group_Clause[ $this->GroupIndx ];
				if ( $this->Row_Condition[ $RowIndx ] != '' ) {
					$WhereData .= ' AND '.$this->Row_Condition[ $RowIndx ];
				}
				
				// For Each Column
				for( $ColumnIndx=0; $ColumnIndx<count($this->Column_ValueKey); $ColumnIndx++) {
				
					$SQL = 'SELECT '.$this->Column_ValueKey[ $ColumnIndx ].$TableData;
					if ($this->Column_Condition[ $ColumnIndx ] != '') {
						$SQL .= $WhereData.' AND '.$this->Column_Condition[ $ColumnIndx ];
					} else {
						$SQL .= $WhereData;
					}
					

					$this->DB->RunSQL( $SQL );						// Run SQL
					if ($Row = $this->DB->RetrieveRow() ) {			// If valid Row returned
						
						$Value = $Row['Value'];						// return Value
					
					} else {
					
						$Value = '<null>';							// return '<null>' to show no data
					}
					
					$this->WriteValue( $Value, $this->BGNDColor );			// Write Value to output
				
				} // End Column
			
			} // End Row
			
			
			// Now call the provided PostProcessingFn if it is provided ...
			if ( $this->Group_PostProcessingFn[ $this->GroupIndx ] != '' ) {
			
				$Function = $this->Group_PostProcessingFn[ $this->GroupIndx ];
				
				$this->$Function();
			}
			
			
		} // End Group
		
		
	}
	

}







?>