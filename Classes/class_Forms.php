<?php

define("LISTBOX_NO_SORT",0);
define("LISTBOX_SORT_ASC",1);
define("LISTBOX_SORT_DESC",-1);

class  FormObject extends DisplayObject {
// 
//  DESCRIPTION:
//		The Basic Form Object for INPUT style form elements.
//		 
//
//	CONSTANTS:
	
//
//	VARIABLES:
	var $ObjectType;
	var $ObjectName;
	var $InitialValue;
	
	var $Parameters;
	
	var $IsHTMLConverting;
//
//	CLASS CONSTRUCTOR
//

	//************************************************************************
	function FormObject( $Name='',  $Value='', $Type='text', $IsConverting=FALSE) {
	
		DisplayObject::DisplayObject();		//  Call the Parent Constructor.
	
		$this->ObjectName 	= $Name;
		$this->InitialValue = $Value;
		$this->ObjectType 	= $Type;
		
		$this->IsHTMLConverting = $IsConverting;
		
		$this->Parameters = array();
		
		$this->AddParameter( "type=\"{$Type}\" " );
		$this->AddParameter( "name=\"{$Name}\" " );
		
		if ($IsConverting == FALSE ) {
			$this->AddParameter( "value=\"{$Value}\" " );
		} else {
			$this->AddParameter( "Need to Make HTML Convertable" );
		}	
	}

//
//	CLASS FUNCTIONS:
//

	//************************************************************************
	function TemplateName() {
	
	
	}
	
	
	
	//************************************************************************
	function AddParameter( $Parameter='' ) {
		
		if ($Parameter != '') {
			$this->Parameters[] = $Parameter;
		}
	}
	
	
	
	//************************************************************************
	function DrawInit() {

		$this->AddToDisplayList( '<input ' );
		
		for( $Indx=0; $Indx< count( $this->Parameters ); $Indx++) {
		
			$this->AddToDisplayList( $this->Parameters[$Indx] );
		}
		$this->AddToDisplayList( '>' );
	}
	
	
	//************************************************************************
	function DrawDirect() {
	
		$this->DrawInit();
		
		DisplayObject::DrawDirect();
	
	}
	
	
	//************************************************************************
	function Draw() {
	
		$this->DrawInit();
		
		return DisplayObject::Draw();
	
	}
	
	

}



class  TextBox extends FormObject {
// 
//  DESCRIPTION:
//		A simple TextBox Class.
//
//	CONSTANTS:

//
//	VARIABLES:
	var $NumberColumnsWide;
	
//
//	CLASS CONSTRUCTOR
//

	//************************************************************************
	function TextBox($Name='',  $Value='', $NumCols='', $IsConverting=FALSE) {
	
		FormObject::FormObject( $Name,  $Value, 'text', $IsConverting);
	
		$this->NumberColumnsWide = $NumCols;

		if ( $NumCols != '') {
			$this->AddParameter( "size=\"$NumCols\" " );
		}
	}
}


class  PasswordBox extends FormObject {
// 
//  DESCRIPTION:
//		A simple PasswordBox Class.
//
//	CONSTANTS:

//
//	VARIABLES:
	var $NumberColumnsWide;
	
//
//	CLASS CONSTRUCTOR
//

	//************************************************************************
	function PasswordBox($Name='',  $Value='', $NumCols='5', $IsConverting=FALSE) {
	
		FormObject::FormObject( $Name,  $Value, 'password', $IsConverting);
	
		$this->NumberColumnsWide = $NumCols;
		
		if ($NumCols != '') {
			$this->AddParameter( "size=\"$NumCols\" " );
		}
		
	}
}




class  FileBox extends FormObject {
// 
//  DESCRIPTION:
//		A simple FileBox Class.
//
//	CONSTANTS:

//
//	VARIABLES:
	var $NumberColumnsWide;
	
//
//	CLASS CONSTRUCTOR
//

	//************************************************************************
	function FileBox($Name='',  $Value='', $NumCols='5') {
	
		FormObject::FormObject( $Name,  $Value, 'file', FALSE);
	
		$this->NumberColumnsWide = $NumCols;
		
		$this->AddParameter( "size=\"$NumCols\" " );
	
	}
}



class  HiddenField extends FormObject {
// 
//  DESCRIPTION:
//		A simple HiddenField Class.
	
//
//	CLASS CONSTRUCTOR
//

	//************************************************************************
	function HiddenField($Name='',  $Value='' ) {
	
		FormObject::FormObject( $Name,  $Value, 'hidden', FALSE);
	}
}



class  SubmitButton extends FormObject {
// 
//  DESCRIPTION:
//		A simple SubmitButton Class.
	
//
//	CLASS CONSTRUCTOR
//

	//************************************************************************
	function SubmitButton($Name='',  $Value='' ) {
	
		FormObject::FormObject( $Name,  $Value, 'submit', FALSE);
	}
}


class  RadioButton extends FormObject {
// 
//  DESCRIPTION:
//		A simple RadioButton Class.

//
//	VARIABLES:
	var $IsChecked;
	
//
//	CLASS CONSTRUCTOR
//

	//************************************************************************
	function RadioButton($Name='',  $Value='', $IsChecked=FALSE ) {
	
		FormObject::FormObject( $Name,  $Value, 'radio', FALSE);
		
		$this->IsChecked = $IsChecked;
		
		if ( $IsChecked == TRUE ) {
			$this->AddParameter( "checked " );
		}
		
	}
}



class  CheckBox extends FormObject {
// 
//  DESCRIPTION:
//		A simple CheckBox Class.

//
//	VARIABLES:
	var $IsChecked;
	
//
//	CLASS CONSTRUCTOR
//

	//************************************************************************
	function CheckBox($Name='',  $Value='', $IsChecked=FALSE ) {
	
		FormObject::FormObject( $Name,  $Value, 'checkbox', FALSE);
		
		$this->IsChecked = $IsChecked;
		
		if ( $IsChecked == TRUE ) {
			$this->AddParameter( "checked " );
		}
		
	}
}




class  MemoBox extends FormObject {
// 
//  DESCRIPTION:
//		A simple MemoBox Class.
//		Note:  While this class is still based upon FormObject
//				it doens't use it's Constructor or DrawInit().
//
//	CONSTANTS:

//
//	VARIABLES:
	
//
//	CLASS CONSTRUCTOR
//

	//************************************************************************
	function MemoBox($Name='',  $Value='', $NumCols='25', $NumRows='5', $IsConverting=FALSE) {
	
		DisplayObject::DisplayObject();				
		
		$this->ObjectName 	= $Name;
		$this->InitialValue = $Value;
		
		$this->IsHTMLConverting = $IsConverting;
		
		$this->Parameters = array();
		
		$this->AddParameter( "name=\"{$Name}\" " );
		if ($NumCols != '') {
			$this->AddParameter( "cols=\"$NumCols\" " );
		}
		if ($NumRows != '') {
			$this->AddParameter( "rows=\"$NumRows\" " );
		}
		
		if ($IsConverting == TRUE ) {
			$this->InitialValue = "Need to Make MemoBox HTML Convertable" ;
		}
	}
	
	
	//************************************************************************
	function DrawInit() {

		$this->AddToDisplayList( '<textarea ' );
		
		for( $Indx=0; $Indx< count( $this->Parameters ); $Indx++) {
		
			$this->AddToDisplayList( $this->Parameters[$Indx] );
		}
		$this->AddToDisplayList( '>' );
		$this->AddToDisplayList( $this->InitialValue, DISPLAYOBJECT_TYPE_HTML );
		$this->AddToDisplayList( '</textarea>' );
	}
	
}


class  Form extends FormObject {
// 
//  DESCRIPTION:
//		A simple Form Class.
//
//	CONSTANTS:

//
//	VARIABLES:
	var $FormName;
	var $FormMethod;
	var $FormAction;
	var $FormData;
	
//
//	CLASS CONSTRUCTOR
//

	//************************************************************************
	function Form($Name='',  $Method='', $Action='25', $Data='', $IsUpload=FALSE) {
	
		DisplayObject::DisplayObject();				
		
		$this->FormName 	= $Name;
		$this->FormMethod 	= $Method;
		$this->FormAction	= $Action;
		$this->FormData		= $Data;
		
		$this->Parameters = array();
		
		$this->AddParameter( "name=\"{$Name}\" " );
		$this->AddParameter( "method=\"$Method\" " );
		$this->AddParameter( "action=\"$Action\" " );
		
		if ( $IsUpload == True ) {
			$this->AddParameter(  "enctype=\"multipart/form-data\" " );
		}
	}
	
	
	//************************************************************************
	function DrawInit() {

		$this->AddToDisplayList( '<form ' );
		
		for( $Indx=0; $Indx< count( $this->Parameters ); $Indx++) {
		
			$this->AddToDisplayList( $this->Parameters[$Indx] );
		}
		$this->AddToDisplayList( '>' );
		$this->AddToDisplayList( $this->FormData, DISPLAYOBJECT_TYPE_OBJECT );
		$this->AddToDisplayList( '</form>' );
	}
	
}



class  ListBox extends FormObject {
// 
//  DESCRIPTION:
//		A simple ListBox Class.
//
//	CONSTANTS:

//
//	VARIABLES:
	var $ListBoxName;
	var $ListBoxNumRows;
	var $ListBoxDefaultValue;
	var $ListBoxSortMethod;			// None, Descending, Ascending (Default)
	
	var $ListBoxEntries;
//
//	CLASS CONSTRUCTOR
//

	//************************************************************************
	function ListBox($Name='',  $DefaultValue='', $NumRows='1', $Parameter='',
							$SortMethod=LISTBOX_NO_SORT ) {
	
		DisplayObject::DisplayObject();				
		
		$this->ListBoxName 	= $Name;
		$this->ListBoxDefaultValue 	= $DefaultValue;
		$this->ListBoxNumRows	= $NumRows;
		$this->ListBoxSortMethod = $SortMethod;
		
		$this->Parameters = array();
		
		$this->AddParameter( "name=\"{$Name}\" " );
		$this->AddParameter( "size=\"$NumRows\" " );
		
		if (($Parameter != '') && ($Parameter != '<null>')) {
			$this->AddParameter( $Parameter );
		}

		$this->ListBoxEntries = array();
		
	}
	
	
	//************************************************************************
	function AddEntry($Label='',  $Value='', $Default=false ) {				
		
		$Selected = '';
		if (($Default == true) || ( strval($Value) == strval($this->ListBoxDefaultValue) ) ) {
			$Selected = 'selected ';
		}
		
		$Temp = array( $Label, $Value, $Selected );
		
		switch($this->ListBoxSortMethod) {
		
		case LISTBOX_NO_SORT:	// No sort order requested
			
			$this->ListBoxEntries[] = $Temp;
			break;
			
		case LISTBOX_SORT_ASC:	// Sort in ascending order
			
			$newArray = array();
			$newEntryInserted = false;
			foreach($this->ListBoxEntries as $Entry) {
				if(strcmp($Temp[0],$Entry[0])<=0 && $newEntryInserted==false) {
					$newArray[] = $Temp;
					$newEntryInserted = true;
				}
				$newArray[] = $Entry;
			}
			if($newEntryInserted == false)
				$newArray[] = $Temp;
			$this->ListBoxEntries = $newArray;
			break;
			
		case LISTBOX_SORT_DESC:	//Sort in descending order
			
			$newArray = array();
			$newEntryInserted = false;
			foreach($this->ListBoxEntries as $Entry) {
				if(strcmp($Temp[0],$Entry[0])>=0 && $newEntryInserted==false) {
					$newArray[] = $Temp;
					$newEntryInserted = true;
				}
				$newTemp = $Entry;
				$newArray[] = $newTemp;
			}
			if($newEntryInserted == false)
				$newArray[] = $Temp;
			$this->ListBoxEntries = $newArray;
			break;
			
		} //end switch
		
	}
	
	
	//************************************************************************
	function DrawInit() {

		$this->AddToDisplayList( '<select ' );
		
		for( $Indx=0; $Indx< count( $this->Parameters ); $Indx++) {
		
			$this->AddToDisplayList( $this->Parameters[$Indx] );
		}
		$this->AddToDisplayList( ">\n" );
		
		for ($Indx=0; $Indx < count( $this->ListBoxEntries ); $Indx++) {
		
			$Temp = '<option value="'.$this->ListBoxEntries[$Indx][1].'" '.$this->ListBoxEntries[$Indx][2]." >".$this->ListBoxEntries[$Indx][0]."</option>";
			$this->AddToDisplayList( $Temp );
		}
		$this->AddToDisplayList( '</select>' );
	}
	
}



class  NumList extends ListBox {
// 
//  DESCRIPTION:
//		A simple NumList ListBox Class.
//
//	CONSTANTS:

//
//	VARIABLES:
	var $StartNumber;
	var $EndNumber;
	var $Increment;
	var $Format;			// The format of how you want the numbers displayed.
	
//
//	CLASS CONSTRUCTOR
//

	//************************************************************************
	function NumList($Name='',  $DefaultValue='', $StartNum=1, $EndNum=31, $Increment=1, $Format='%d') {
	
		ListBox::ListBox( $Name,  $DefaultValue, '1' );

		$this->StartNumber = $StartNum;
		$this->EndNumber = $EndNum;
		$this->Increment = $Increment;
		$this->Format = $Format;
		
	
	}
	
	//************************************************************************
	function DrawInit() {


		for( $Indx=$this->StartNumber; $Indx <= $this->EndNumber; $Indx+= $this->Increment) {
			$Label = sprintf( $this->Format, $Indx);
			$this-> AddEntry( $Label,  $Indx );
		}

		ListBox::DrawInit();
	}
	
}



class  MonthList extends ListBox {
// 
//  DESCRIPTION:
//		A simple Month List ListBox Class.

//
//	CLASS CONSTRUCTOR
//
var $MonthValues;
var $StartMonth;
var $EndMonth;


	//************************************************************************
	function MonthList($Name='',  $DefaultValue='', $StartMonth=1, $EndMonth=12, $LanguageID=1) {
	
		ListBox::ListBox( $Name,  $DefaultValue, '1' );
		
		$Labels = new MultiLingual_Labels( 'AI', 'Forms', 'MonthList', $LanguageID );

		
		$this->MonthValues = array();
		$this->MonthValues[ 1 ] = $Labels->Label('[Jan.]');
		$this->MonthValues[ 2 ] = $Labels->Label('[Feb.]');
		$this->MonthValues[ 3 ] = $Labels->Label('[Mar.]');
		$this->MonthValues[ 4 ] = $Labels->Label('[Apr.]');
		$this->MonthValues[ 5 ] = $Labels->Label('[May.]');
		$this->MonthValues[ 6 ] = $Labels->Label('[Jun.]');
		$this->MonthValues[ 7 ] = $Labels->Label('[Jul.]');
		$this->MonthValues[ 8 ] = $Labels->Label('[Aug.]');
		$this->MonthValues[ 9 ] = $Labels->Label('[Sep.]');
		$this->MonthValues[ 10 ] = $Labels->Label('[Oct.]');
		$this->MonthValues[ 11 ] = $Labels->Label('[Nov.]');
		$this->MonthValues[ 12 ] = $Labels->Label('[Dec.]');
		
		$this->StartMonth = (int) $StartMonth;
		$this->EndMonth = (int) $EndMonth;
		
	}
	
	//************************************************************************
	function DrawInit() {
		
		for ($Indx=$this->StartMonth; $Indx<=$this->EndMonth; $Indx++) {
			$this->AddEntry( $this->MonthValues[ $Indx ], $Indx);
		}
		
		ListBox::DrawInit();
	}
	
}




class  DatePicker extends DisplayObject {
// 
//  DESCRIPTION:
//		A Generic Date Picker Object..

//
//	CLASS CONSTRUCTOR
//
var $Name;				// The Base name for each Date Item.  The individual Item Names
						// will be :  Day = "BaseName" + "_day"
						//   			Month = "BaseName" + "_month"
						//				Year = "BaseName" + "_year"
						
var $Value;				// in Standard MySQL Date order : YYYY-MM-DD 

var $FormatString;		// Describes how the date is to be displayed

var $LanguageID;		// Language ID for the Month Picker ...


	//************************************************************************
	function DatePicker($Name='',  $DefaultValue='0000-00-00', $FormatString='D.1.31:M.1.12:Y1.10.10', $LanguageID=1) {
	
		DisplayObject::DisplayObject();
		
		$this->Name = $Name;	
		$this->Value = $DefaultValue;
		$this->FormatString = $FormatString;
		$this->LanguageID = $LanguageID;
		
	}
	
	//************************************************************************
	function DrawInit() {
		
		if ($this->Value != '') {
			$Values = explode('-',  $this->Value);
			
			if (isset( $Values[0] ) ) { $YearValue = $Values[0]; } else { $YearValue = ''; }
			if (isset( $Values[1] ) ) { $MonthValue = $Values[1]; } else { $MonthValue = ''; }
			if (isset( $Values[2] ) ) { $DayValue = $Values[2]; } else { $DayValue = ''; }
			 
		} else {
			$YearValue = '';
			$MonthValue = '';
			$DayValue = '';
		}
			
		// For Each Date Item specified in the Format String ...
		$DateItems = explode( ':', $this->FormatString);
		
		for ($ItemIndx=0; $ItemIndx < count( $DateItems ); $ItemIndx++) {
		
			// For each Individual Item get it's Date ID
			$Data = explode( '.', $DateItems[ $ItemIndx ] );
			
			switch( $Data[0] ) {
			
				case 'D':
				case 'd':
				
					// format should be : D.Start#.End#
					if (isset( $Data[1] ) ) {
						$StartDay = $Data[1];
					} else {
						$StartDay = 1;
					}
					
					if (isset( $Data[2] ) ) {
						$EndDay = $Data[2];
					} else {
						$EndDay = 31;
					}
					
					$Name = $this->Name.'_day';
					
					$DayList = new NumList( $Name,  $DayValue, $StartDay, $EndDay);
					
					$this->AddToDisplayList( $DayList, DISPLAYOBJECT_TYPE_OBJECT);
					break;
					
				case 'M':
				case 'm':

					// format should be : M.Start#.End#
					if (isset( $Data[1] ) ) {
						$StartMonth = $Data[1];
					} else {
						$StartMonth = 1;
					}
					
					if (isset( $Data[2] ) ) {
						$EndMonth = $Data[2];
					} else {
						$EndMonth = 31;
					}
					
					$Name = $this->Name.'_month';

					$MonthList = new MonthList($Name,  $MonthValue, $StartMonth, $EndMonth, $this->LanguageID);
					
					$this->AddToDisplayList( $MonthList, DISPLAYOBJECT_TYPE_OBJECT);
					break;
				
				case 'Y1':

					// Year Style 1: 
					//    Chooses a span of years based upon current Year:
					//		Format: Y1.#YearsPrevious.#YearsAfter
					
	
					if (isset( $Data[1] ) ) {
						$StartYear = date("Y") - $Data[1];
					} else {
						$StartYear = date("Y") - 10;
					}
					
					if (isset( $Data[2] ) ) {
						$EndYear = date("Y") + $Data[2];
					} else {
						$EndYear = date("Y") + 10;
					}
					
					$Name = $this->Name.'_year';
					
					$YearList = new NumList( $Name,  $YearValue, $StartYear, $EndYear);
					
					$this->AddToDisplayList( $YearList, DISPLAYOBJECT_TYPE_OBJECT);
					break;
			}
		}
	
	}
	
	
	
	//************************************************************************
	function DrawDirect() {
	
		$this->DrawInit();
		
		DisplayObject::DrawDirect();
	
	}
	
	
	
	//************************************************************************
	function Draw() {
	
		$this->DrawInit();
		
		return DisplayObject::Draw();
	
	}
	
	
}



class  TimePicker extends DisplayObject {
// 
//  DESCRIPTION:
//		A Generic Time Picker Object.  It handles the creation of an HH:MM:AM/PM 
//		drop down list.

var $Name;				// The Base name for each Time Item.  The individual Item Names
						// will be :  	Hour = "BaseName" + "_hour"
						//   			Minute = "BaseName" + "_min"
						//				AM/PM = "BaseName" + "_ap"
						
var $Value;				// in Standard MySQL Time order : HH:MM:SS 

var $FormatString;		// Describes how the Time is to be displayed
						// ex H:M
						//		H = Hour as decimal # using 24-hour clock (00-23)
						//      I = Hour as decimal # using 12-hour clock (01-12)
						//		M = minute as a decimal #
						//		p = AM / PM chooser (useful for 12-hour clock)


//
//	CLASS CONSTRUCTOR
//



	//************************************************************************
	function TimePicker($Name='',  $DefaultValue='00:00:00', $FormatString='H:M') {
	
		DisplayObject::DisplayObject();
		
		$this->Name = $Name;	
		$this->Value = $DefaultValue;
		$this->FormatString = $FormatString;
		
	}
	
	//************************************************************************
	function DrawInit() {
		
		if ($this->Value != '') {
		
			$ValueString = strftime("%H:%M:%p", strtotime( $this->Value ));
			$Values = explode(':',  $ValueString);
			
			if (isset( $Values[0] ) ) { $HourValue = $Values[0]; } else { $HourValue = ''; }
			if (isset( $Values[1] ) ) { $MinuteValue = $Values[1]; } else { $MinuteValue = ''; }
			if (isset( $Values[2] ) ) { $AmPmValue = $Values[2]; } else { $AmPmValue = ''; }
			 
		} else {
			$HourValue = '';
			$MinuteValue = '';
			$AmPmValue = '';
		}
			
		// For Each Date Item specified in the Format String ...
		$TimeItems = explode( ':', $this->FormatString);
		
		for ($ItemIndx=0; $ItemIndx < count( $TimeItems ); $ItemIndx++) {
					
			switch( $TimeItems[ $ItemIndx ] ) {
			
				case 'H':

					$Name = $this->Name.'_hour';
					
					$HourList = new NumList( $Name,  $HourValue, 0, 23, 1, '%02d');
					
					$this->AddToDisplayList( $HourList, DISPLAYOBJECT_TYPE_OBJECT);
					break;
					

				case 'I':

					$Name = $this->Name.'_hour';
					
					$HourList = new NumList( $Name,  $HourValue, 1, 12, 1, '%02d');
					
					$this->AddToDisplayList( $HourList, DISPLAYOBJECT_TYPE_OBJECT);
					break;
					
					
				case 'M':

					$Name = $this->Name.'_min';
					
					$MinList = new NumList( $Name,  $MinuteValue, 0, 60, 1, '%02d');
					
					$this->AddToDisplayList( $MinList, DISPLAYOBJECT_TYPE_OBJECT);
					break;
					
					
				case 'p':

					$Name = $this->Name.'_ap';
					
					$AmPmList = new ListBox($Name,   $AmPmValue);
					$AmPmList->AddEntry('am', 'am');
					$AmPmList->AddEntry('pm', 'pm');
					
					$this->AddToDisplayList( $AmPmList, DISPLAYOBJECT_TYPE_OBJECT);
					break;
				
			}
		}
	
	}
	
	
	
	//************************************************************************
	function DrawDirect() {
	
		$this->DrawInit();
		
		DisplayObject::DrawDirect();
	
	}
	
	
	
	//************************************************************************
	function Draw() {
	
		$this->DrawInit();
		
		return DisplayObject::Draw();
	
	}
	
	
}




class  ListBoxDB extends ListBox {
// 
//  DESCRIPTION:
//		A ListBox Class that will gather it's values from a supplied DB Table.
//		You just need to specify the DB & Table info, The Label Key (column name
//		of the values that need to be displayed), and the Value Key (column name 
//		of the return values from the ListBox.
//
//		NOTE: the list isn't automatically generated.  You must call the InitList()
//			function.
//
//	CONSTANTS:

//
//	VARIABLES:
	var $TableName;
	var $SQLWhere;
	var $LabelKey;
	var $ValueKey;
	var $ProvidedSQL;
	var $InitListCalled;

	var $DB;
	var $DBName;
	var $DBPath;
	var $DBUserID;
	var $DBPWord;
	var $IsDBInitialized;
	
//
//	CLASS CONSTRUCTOR
//

	//************************************************************************
	function ListBoxDB($Name='',  $DefaultValue='', $NumRows='1', $Parameter='', $Table='<null>', $LabelKey='<null>', $ValueKey='<null>', $DBName='<null>', $DBPath=DB_PATH, $DBUserID=DB_USER, $DBPWord=DB_PWORD, $Where='<null>', $FirstEntry='<null>', $FirstEntryValue='#', $SortMethod=LISTBOX_NO_SORT ) {
	
		ListBox::ListBox($Name,  $DefaultValue, $NumRows, $Parameter, $SortMethod );
		
		
		$this->TableName = $Table;
		$this->SQLWhere = $Where;
		$this->LabelKey = $LabelKey;
		$this->ValueKey = $ValueKey;
		$this->ProvidedSQL = '<null>';
		
		$this->InitListCalled = false; 
		
		$this->DBName = $DBName;
		$this->DBPath = $DBPath;
		$this->DBUserID = $DBUserID;
		$this->DBPWord = $DBPWord;
		$this->IsDBInitialized = FALSE;
		
		if ($FirstEntry != '<null>') {
			$this->AddEntry( $FirstEntry, $FirstEntryValue );
		}
		
		
	}
	
	
	
//
//	CLASS FUNCTIONS:
//
	
	//************************************************************************
	function InitDB() {
	
		if ( $this->IsDBInitialized == FALSE ) {
		
			$this->DB = new Database_MySQL;
			$this->DB->ConnectToDB( $this->DBName, $this->DBPath, $this->DBUserID, $this->DBPWord );
			
			$this->IsDBInitialized = TRUE;
		}
	}
	
	
	
	//************************************************************************
	function InitList() {
	
		if ($this->InitListCalled == false ) {
		
			$this->InitDB();
			if ($this->ProvidedSQL == '<null>' ) {
				$SQL = 'SELECT * FROM '.$this->TableName;
				if ( $this->SQLWhere != '<null>') {
					$SQL .= ' WHERE '.$this->SQLWhere;
				}
				switch ($this->ListBoxSortMethod) {
				case LISTBOX_NO_SORT:
					break;
				case LISTBOX_SORT_ASC:
					$SQL .= ' ORDER BY '.$this->LabelKey;
					break;
				case LISTBOX_SORT_DESC:
					$SQL .= ' ORDER BY '.$this->LabelKey.' DESC';
					break;
				} // end switch
			} else {
				$SQL = $this->ProvidedSQL;
			}
			
			
			if ( $this->DB->RunSQL( $SQL ) == TRUE ) {
			
				while ( $Row = $this->DB->RetrieveRow() ) {
				
					$this->AddEntry( $Row[ $this->LabelKey ], $Row[ $this->ValueKey ] );
				}
			
			} else {
			
				echo "ListBoxDB [".$this->DBName."->".$this->TableName."] failed to Get Data.<br>";
			}
			
			$this->InitListCalled = true;
			
		} // End if Init List
	
	}
	
	
	//************************************************************************
	function DrawInit() {

		$this->initList();
		
		ListBox::DrawInit();
		
	}
	
		
}



class  JumpMenuDB extends ListBoxDB {
// 
//  DESCRIPTION:
//		The JumpMenuDB Class extends a normal ListBoxDB and turns it into a Jump menu.
//		It adds the proper javascript command to call the MM_jumpMenu() routine to 
//		perform the jump.
//
//		NOTE: This Class doesn't automatically generate the List.  You need to call the
//			InitList() routine.
//
//	CONSTANTS:

//
//	VARIABLES:
	var $JumpKey;		//  The page to jump to when a new selection is made.
//
//	CLASS CONSTRUCTOR
//

	//************************************************************************
	function JumpMenuDB( $Name='',  $DefaultValue='', $Parameter='', $JumpKey='', $Table='<null>', $LabelKey='<null>', $ValueKey='<null>', $DBName='<null>', $Where='<null>', $FirstEntry='<null>', $FirstEntryValue='#', $DBPath=DB_PATH, $DBUserID=DB_USER, $DBPWord=DB_PWORD, $SortMethod=LISTBOX_NO_SORT ) {
	
		ListBoxDB::ListBoxDB($Name,  $DefaultValue,'1', $Parameter, $Table, $LabelKey, $ValueKey, $DBName, $DBPath, $DBUserID, $DBPWord, $Where, $FirstEntry, $FirstEntryValue, $SortMethod );
	
		$this->AddParameter( " onChange=\"MM_jumpMenu('this',this,0)\" ");	// Add JumpMenu JScript Call.
		
		$this->JumpKey = $JumpKey;
	
	}

//
//	CLASS FUNCTIONS:
//

	//************************************************************************
	function AddEntry($Label='',  $Value='', $Default=FALSE ) {				
		
		$NewValue = $this->JumpKey.$Value;
		
		if (($Default == TRUE) || ($Value == $this->ListBoxDefaultValue) ) {
			$NewDefault = TRUE;
		} else {
			$NewDefault = FALSE;
		}
		
		ListBox::AddEntry( $Label, $NewValue, $NewDefault );

	}
	
	
	
	//************************************************************************
	function DrawInit() {

		$this->InitList();
		
		ListBox::DrawInit();
		
	}
	
	

}

class  ListBoxDB_Multilingual extends ListBoxDB {
// 
//  DESCRIPTION:
//		This class is very simliar to the ListBoxDB class except that instead of
//		the supplied DB providing the actually Label and Value Keys, it will
//		provide tags for those keys which can then be translated using the Multilingual
//		labels.
//
//		NOTE: the list isn't automatically generated.  You must call the InitList()
//			function.
//
//	CONSTANTS:
//
//	VARIABLES:
	var $Series;
	var $Page;
	var $LanguageID;

//
//	CLASS CONSTRUCTOR
//

	//************************************************************************
	function ListBoxDB_Multilingual($Name='',  $DefaultValue='', $NumRows='1', $Parameter='', $Table='<null>', $LabelKey='<null>', $ValueKey='<null>', $DBName='<null>', 
				$LanguageID=1, $Series, $Page, $SortMethod=LISTBOX_NO_SORT, $Where='<null>', $FirstEntry='<null>', $FirstEntryValue='#', $DBPath=DB_PATH, $DBUserID=DB_USER, $DBPWord=DB_PWORD ) {
	
		ListBoxDB::ListBoxDB($Name,  $DefaultValue, $NumRows, $Parameter, $Table, $LabelKey, $ValueKey, $DBName, $DBPath, $DBUserID, $DBPWord, $Where, $FirstEntry, $FirstEntryValue, $SortMethod );
		
		$this->Series = $Series;
		$this->Page = $Page;
		$this->LanguageID = $LanguageID;
		
	}
	
	
	
//
//	CLASS FUNCTIONS:
//
	
	//************************************************************************
	function InitList() {
	
		if ($this->InitListCalled == false ) {
			
			// get labels
			$listLabels = new Multilingual_Labels('AI',$this->Series,$this->Page,$this->LanguageID);
			
			$this->InitDB();
			if ($this->ProvidedSQL == '<null>' ) {
				$SQL = 'SELECT * FROM '.$this->TableName;
				if ( $this->SQLWhere != '<null>') {
					$SQL .= ' WHERE '.$this->SQLWhere;
				}
			} else {
				$SQL = $this->ProvidedSQL;
			}
			
			
			if ( $this->DB->RunSQL( $SQL ) == TRUE ) {
			
				while ( $Row = $this->DB->RetrieveRow() ) {
					
					$actualLabel = $listLabels->Label( $Row[ $this->LabelKey ] );
					$actualValue = $listLabels->Label( $Row[ $this->ValueKey ] );
					$this->AddEntry( $actualLabel, $actualValue );
				}
			
			} else {
			
				echo "ListBoxDB_Multilingual [".$this->DBName."->".$this->TableName."] failed to Get Data.<br>";
			}
			
			$this->InitListCalled = true;
			
		} // end if
	
	} // end of function InitList()
	
}




class  JumpMenuDB_Multilingual extends JumpMenuDB {
// 
//  DESCRIPTION:
//		This class is very simliar to the JumpMenuDB class except that instead of
//		the supplied DB providing the actual Label and Value Keys, it will
//		provide tags for those keys which can then be translated using the Multilingual
//		labels.
//
//		NOTE: This Class doesn't automatically generate the List.  You need to call the
//			InitList() routine.
//
//	CONSTANTS:

//
//	VARIABLES:
	var $listLabels;
//
//	CLASS CONSTRUCTOR
//

	//************************************************************************
	function JumpMenuDB_Multilingual( $Name='',  $DefaultValue='', $Parameter='', $JumpKey='', $Table='<null>', $LabelKey='<null>', $ValueKey='<null>', $DBName='<null>', 
					$LanguageID=1, $Series, $Page, $SortMethod=LISTBOX_NO_SORT, $Where='<null>', $FirstEntry='<null>', $FirstEntryValue='#', $DBPath=DB_PATH, $DBUserID=DB_USER, $DBPWord=DB_PWORD ) {
	
		JumpMenuDB::JumpMenuDB($Name,  $DefaultValue, $Parameter, $JumpKey, $Table, $LabelKey, $ValueKey, $DBName, $Where, $FirstEntry, $FirstEntryValue, $DBPath, $DBUserID, $DBPWord, $SortMethod );
	
		$this->listLabels = new Multilingual_Labels('AI',$Series,$Page,$LanguageID);
	
	}

//
//	CLASS FUNCTIONS:
//

	//************************************************************************
	function AddEntry($Label='',  $Value='', $Default=FALSE ) {				
		
		$NewValue = $this->JumpKey.$Value;
		
		if (($Default == TRUE) || ($Value == $this->ListBoxDefaultValue) ) {
			$NewDefault = TRUE;
		} else {
			$NewDefault = FALSE;
		}
		
		ListBox::AddEntry( $this->listLabels->Label($Label), $NewValue, $NewDefault );

	}
	
	
	
	//************************************************************************
	function DrawInit() {

		$this->InitList();
		
		ListBox::DrawInit();
		
	}
	
	

}




?>