<?php

require_once( "Spreadsheet/Excel/Writer.php");

class  ExcelDocument {
// 
//  DESCRIPTION:
//		This is a class for creating an Excel Document.
//
//	CONSTANTS:

//
//	VARIABLES:
//
var $WorkBook;			// The WorkBook Object.
var $Name;
var $isStored;

var $Format;			// Array Containing all the Format Styles available for this WorkBook.
var $WorkSheet;			// Array Containing all the Sheets in this WorkBook
var $WorkSheetData;		// Internal Data we track for this Sheet.
var $CurrentSheetTag;	// Tag marking the currently Active Sheet


//	CLASS CONSTRUCTOR
//

	//************************************************************************
	function ExcelDocument( $DocumentName, $isStored=false ) {
	//
	//	A generic Excel Document Constructor.  If this document is to be saved
	//	as a file, then provide the path+name in $DocumentName.
	//
		
		$this->Name = $DocumentName;
		$this->isStored = $isStored;
		
		
		if ($isStored == true ) {
		
/////// Add Checking for existing File here
			$this->WorkBook = new Spreadsheet_Excel_Writer( $DocumentName );
			
		} else {
		
			$this->WorkBook = new Spreadsheet_Excel_Writer();
		}
		
		$this->Format 			= array();
		$this->WorkSheet 		= array();
		$this->WorkSheetData	= array();
		$this->CurrentSheetTag	= '';
		
	}

//
//	CLASS FUNCTIONS:
//

	//************************************************************************
	function Template() {
	// 
	// DESCRIPTION
	//	
	//	

	
	}
	
	
	//************************************************************************
	function setCustomColor( $Index, $ColorString) {
	//			$Index			INT		The Color Index of the Color we will overwrite
	//									The index is 8 - 63.  Same as the index values
	//									we use for the Format Options.
	//			$ColorString	STRING	The RGB Color String of the New Color.
	//									ex: '#AABBCC'
	//										AA = Hex Red Value (00-FF)
	//										BB = Hex Green Value (00-FF)
	//										CC = Hex Blue Value (00-FF)
	// 
	// DESCRIPTION
	//	This function is used to overwrite one of the default color index values
	//	to a given value.  Setting a Value to this index in your formatting will
	//	then use this color value you set here.
	//	
		if (($Index > 7 ) && ($Index < 64)) {
		
			if ($ColorString[0] == '#') {
				$Offset = 0;
			} else {
				$Offset = 1;
			}
			
			$Red = 0 + ('0x'.$ColorString[ 1 - $Offset].$ColorString[ 2 - $Offset]);
			$Green = 0 + ('0x'.$ColorString[ 3 - $Offset].$ColorString[ 4 - $Offset]);
			$Blue = 0 + ('0x'.$ColorString[ 5 - $Offset].$ColorString[ 6 - $Offset]);

			$this->WorkBook->setCustomColor( $Index, $Red, $Green, $Blue);
			
		} else {
			die ( 'class_Excell->SetCustomColor :: Index ['.$Index.'] is out of range.');
		}
		
	
	}
	
	
	//************************************************************************
	function AddFormat( $Tag, $Description ) {
	// 			$Tag	STRING		A Reference for the Format Being created.
	//			$Description	STRING	A string of Format Commands to be used
	//									in setting up this Format.  
	//									ex: 'Bold,Merge,Size:XX,FontFamily:XXX,Italic'
	// DESCRIPTION
	//	This funciton will add a Format Object to this WorkBook.  The Tag is the 
	//	identifier for this Format object.  When adding cells to a Worksheet, use 
	//	the Format Tag to apply a format to the cell. The format description 
	//	indicates all the formatting Options for this reference.	
	//	
		
		// Move All the Description Elements into a List
		$List = explode( ',', $Description);
		
		// Create a New Format and Associate it with "Tag"
		$this->Format[ $Tag ] =& $this->WorkBook->addFormat();
		
		// For Each Description Element in the List ...
		for( $Indx=0; $Indx<count($List); $Indx++) {
		
			// Get this Element Description 
			$Element = explode( ':', $List[ $Indx ]);
			
			
			switch ( $Element[0] ) {
			
				// If this is a Bold Element then set Format to Bold
				case 'Bold':
					$this->Format[ $Tag ]->setBold();
					break;
					
				// If this is a CellColor Element then set the Cell Color
				case 'CellColor':	
				// ex "CellColor:XX"  where XX= Font Color Index
				//		The font index is Given Color Index + 8 ... go figure...
				//		see: 	http://pear.php.net/manual/en/package.fileformats.spreadsheet-excel-writer.spreadsheet-excel-writer-format.setfgcolor.php
				//				www.geocities.com/davemcritchie/excel/colors.htm
				//
					$this->Format[ $Tag ]->setFgColor( $Element[1] );
					break;	
				
					
				// If this is an Italic Element then set Format to Italic
				case 'Italic':
					$this->Format[ $Tag ]->setItalic();
					break;
					
				// If this is a FontSize Element then set font size
				case 'FontColor':	
				// ex "FontSize:XX"  where XX= Font Color Index
				//		The font index is Given Color Index + 8 ... go figure...
				//		see: 	http://pear.php.net/manual/en/package.fileformats.spreadsheet-excel-writer.spreadsheet-excel-writer-format.setfgcolor.php
				//				www.geocities.com/davemcritchie/excel/colors.htm
				//
					$this->Format[ $Tag ]->setColor( $Element[1] );
					break;
					
				// If this is a FontSize Element then set font size
				case 'FontSize':	
				// ex "FontSize:XX"  where XX= Font Size in Pixels
					$this->Format[ $Tag ]->setSize( $Element[1] );
					break;
					
				// If this is a Text Wrap Element then set Format to Text Wrap
				case 'Merge':
					$this->Format[ $Tag ]->setMerge();
					break;
					
				// If this is a Text Wrap Element then set Format to Text Wrap
				case 'TextWrap':
					$this->Format[ $Tag ]->setTextWrap();
					break;
					
				// If this is a Text Wrap Element then set Format to Text Wrap
				case 'TextAlignLeft':
					$this->Format[ $Tag ]->setAlign( 'left' );
					break;
					
				case 'TextAlignRight':
					$this->Format[ $Tag ]->setAlign( 'right' );
					break;
					
				case 'TextAlignCenter':
					$this->Format[ $Tag ]->setAlign( 'center' );
					break;

				
					
			}
		}
	
	}  // End Add Format
	
		
	//************************************************************************
	function AddSheet( $Tag, $SheetName, $NumColumns) {
	// 
	// DESCRIPTION
	//	This function will create a new sheet for this workbook.  It associates 
	//	this sheet with a provided TAG, Assigns it's name, and also tracks the 
	//	expected number of columns in this sheet.
	//	
	
		$this->WorkSheet[ $Tag ] =& $this->WorkBook->addWorksheet( $SheetName );
		$this->WorkSheetData[ $Tag ] = new ExcellSheetData( $NumColumns );
	
		// Now default this new sheet as the current Active Sheet.
		$this->CurrentSheetTag = $Tag;
	}
	
	
	//************************************************************************
	function setCurrentSheet( $Tag ) {
	// 			$Tag	STRING		The Reference Tag of the Sheet we want to write to.	
	// 
	// DESCRIPTION
	//	This function will set the CurrentSheetTag to the supplied Tag if it 
	//	is an already defined Tag.
	//		
	
		if ( array_key_exists( $Tag, $this->WorkSheet ) == true ) {
		
			$this->CurrentSheetTag = $Tag;
		}

	
	}
	
	
	//************************************************************************
	function AddCell( $Data, $FormatTag='<null>', $NumCols=1, $Row=-1, $Col=-1) {
	// 
	// DESCRIPTION
	//	This is how we add Data to a Worksheet.  Similar to Table Classes, if
	//  you have already specified the number of columns for the current sheet
	//	you can just add Data, Formatting info, and specify the # Columns for it
	//	and it will be internally tracked and displayed.
	//
	//	Optionally, you can specify a specific Row/Column to add data.
	//	

		$SheetTag = $this->CurrentSheetTag;

		// Get Current Row
		if ( $Row == -1 ) {
			$ItemRow = $this->WorkSheetData[ $SheetTag ]->CurrentRow;
		
		} else {
		
			$ItemRow = $Row;
		}
		
		// Get Current Column
		if ( $Col == -1 ) {
			$ItemCol = $this->WorkSheetData[ $SheetTag ]->CurrentColumn;
		
		} else {
		
			$ItemCol = $Col;
		}
		
		
		// If no Formatting is specified ...
		if (($FormatTag == '<null>') || ($FormatTag == '')) {
		
			$this->WorkSheet[ $SheetTag ]->write( $ItemRow, $ItemCol, $Data );
			
		} else {
		
			$this->WorkSheet[ $SheetTag ]->write( $ItemRow, $ItemCol, $Data, $this->Format[ $FormatTag ] );
		}
		
		// Update this Sheet's Row/Col info if no Row/Col data was passed in ...
		if (($Row == -1) && ($Col == -1)) {
			$this->WorkSheetData[ $SheetTag ]->UpdateRowCol( $NumCols );
		}
	
	}  // End AddCell()
	
	
	//************************************************************************
	function DrawDirect() {
	// 
	// DESCRIPTION
	//	The standard drawing function for objects that are Display Objects.
	//	
	
		if( $this->isStored == false ) {
		
			$this->WorkBook->Send( $this->Name );
		}
		
		$this->WorkBook->close();
	}

	
	
	//************************************************************************
	function Draw() {
	
		$this->DrawDirect();
	}
	
	
	//************************************************************************
	function Close() {
	
		$this->DrawDirect();
	}
	
	

}



class  ExcellSheetData {
// 
//  DESCRIPTION:
//		This is a class for tracking an Excell Sheet's display data in a Workbook.
//
//	CONSTANTS:

//
//	VARIABLES:
var $NumCols;
var $CurrentColumn;
var $CurrentRow;


//
//	CLASS CONSTRUCTOR
//

	//************************************************************************
	function ExcellSheetData( $NumColumns ) {
		
		$this->NumCols	= $NumColumns;
		$this->CurrentColumn = 0;
		$this->CurrentRow = 0;
	}

//
//	CLASS FUNCTIONS:
//

	//************************************************************************
	function Template() {
	// 
	// DESCRIPTION
	//	
	//	

	
	}	
	
	
	//************************************************************************
	function UpdateRowCol( $NumCols ) {
	// 
	// DESCRIPTION
	//	This routine will properly update the Row and Column data given the #
	//	columns provided.  It functions similarly to the Table class.
	//	

		// Increment Current Column by the NumCols
		$this->CurrentColumn += $NumCols;
		
		// If CurrentColumn beyond Max Column for this sheet ...
		if ( $this->CurrentColumn >= $this->NumCols) {	// Note: CurrentColumn is 0 based - so 0-6 are valid for a 7 column sheet.
		
			$this->CurrentRow++;			// Go to next Row
			$this->CurrentColumn=0;			// Reset Column to position 0
		}
	
	}	

}

?>