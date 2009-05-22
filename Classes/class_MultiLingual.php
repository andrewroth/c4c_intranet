<?php


class  MultiLingual_Labels {
// 
//  DESCRIPTION:
//		This class operates on the labels for a given Site/Page.  This class
//		is responsible to extract the proper Labels based upon the given
//		Site, Series, Page and Language ID's.
//			Site = The Web Site we are working with (eg: "AI")
//			Series = The Current Page Series we are viewing (eg: "HRDB")
//			Page = The current Page in the series we are viewing (eg: "NameEntry")
//			Language ID = the proper language to return to the viewer (eg: 1 = English)
//
//
//	CONSTANTS:

//
//	VARIABLES:
	var $Site;
	var $Series;
	var $Page;
	var $Language;
	
	var $Labels;
	var $Captions;
	var $LabelFormatting;
	
	var $LabelsDB;
	var $IsLabelsDBInitialized;
	var $LabelsDBName;
	var $LabelsDBPath;
	var $LabelsDBUserID;
	var $LabelsDBPWord;
	

//
//	CLASS CONSTRUCTOR
//

	//************************************************************************
	function MultiLingual_Labels( $Site, $Series, $Page, $Language=1, $DBName='multilingual', $DBPath=DB_PATH, $DBUserID=DB_USER, $DBPWord=DB_PWORD) {
	
		$this->Site = $Site;
		$this->Series = $Series;
		$this->Page = $Page;
		$this->Language = $Language;
		
		$this->Labels = array();
		$this->Captions = array();
		$this->LabelFormatting = '';
		
		
		$this->IsLabelsDBInitialized = FALSE;
		$this->LabelsDBName = $DBName;
		$this->LabelsDBPath = $DBPath;
		$this->LabelsDBUserID = $DBUserID;
		$this->LabelsDBPWord = $DBPWord;
	
		$this->InitLabelsDB();
		
	}

//
//	CLASS FUNCTIONS:
//

	//************************************************************************
	function TemplateName() {
	
	
	}
	
	
	//************************************************************************
	function InitLabelsDB() {
	
		if ( $this->IsLabelsDBInitialized == FALSE ) {
		
			$this->LabelsDB = new Database_MySQL;
			$this->LabelsDB->ConnectToDB( $this->LabelsDBName, $this->LabelsDBPath, $this->LabelsDBUserID, $this->LabelsDBPWord );
			
			$this->IsLabelsDBInitialized = TRUE;
		}
		
		$SQL = "SELECT labels.* ";
		$SQL .= "FROM ((site INNER JOIN series ON site.site_id = series.site_id) INNER JOIN page ON series.series_id = page.series_id) INNER JOIN labels ON page.page_id = labels.page_id ";
		$SQL .= 'WHERE (((site.site_label)="'.$this->Site.'") AND ((series.series_label)="'.$this->Series.'") AND ((page.page_label)="'.$this->Page.'") AND ((labels.language_id)='.$this->Language.'))';
						
		if ( $this->LabelsDB->RunSQL( $SQL ) == TRUE ) {
			
			while( $Row = $this->LabelsDB->RetrieveRow() ) {
			
				$this->Labels[ $Row['labels_key'] ] = $Row['labels_label'];
				$this->Captions[ $Row['labels_key'] ] = $Row['labels_caption'];
			}
		} else {
						
echo "Label Connection Failed.";			
		}
						

		
	}
	
	
	
	//************************************************************************
	function Label( $Key ) {
	
		if ( array_key_exists( $Key, $this->Labels) == TRUE ) {
		
			return $this->Labels[ $Key ];
		
		} else {
		
			return $Key;
		}
	}
	
	
	
	//************************************************************************
	function Caption( $Key ) {
	
		if ( array_key_exists( $Key, $this->Captions) == TRUE ) {
		
			return $this->Captions[ $Key ];
		
		} else {
		
			return $Key.": No Caption.";
		}
	}
	
	
	
	//************************************************************************
	function Formatted( $Key ) {
	
		$Label = $this->Label( $Key );
		$Caption = $this->Caption( $Key );
		
		return "<a href=\"#\" onMouseOver=\"ML('{$Caption}','{$Label}'); return true\" onMouseOut=\"HideTip('ToolTip'); return true\"><div style=\"text-decoration: None\" class=\"FormLabel\">{$Label}</div></a>";
	}
	
}





class  MultiLingual_Buttons {
// 
//  DESCRIPTION:
//		This class will create buttons based upon the desired language of the 
//		veiwer.  It pulls the button data from the Language DB.
//
//		In general, there will be Generic buttons that are defined by the Site,
//		as well as specific buttons defined by a Series.
//
//	CONSTANTS:

//
//	VARIABLES:
	var $Site;
	var $Series;
	var $LanguageID;
	
	var $ButtonList;
	
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
	function MultiLingual_Buttons( $Site='AI', $LanguageID=1, $Series='', $DBName='multilingual', $DBPath=DB_PATH, $DBUserID=DB_USER, $DBPWord=DB_PWORD) {
	
		$this->Site = $Site;
		$this->Series = $Series;
		$this->LanguageID = $LanguageID;
		
		$this->ButtonList = array();
		
		$this->DBName = $DBName;
		$this->DBPath = $DBPath;
		$this->DBUserID = $DBUserID;
		$this->DBPWord = $DBPWord;
		$this->IsDBInitialized = FALSE;
	
		$this->InitDB();
		$this->LoadData();
	}

//
//	CLASS FUNCTIONS:
//

	//************************************************************************
	function TemplateName() {
	
	
	}
	
	
	//************************************************************************
	function InitDB() {
	
		if ( $this->IsDBInitialized == FALSE ) {
		
			$this->DB = new Database_MySQL;
			$this->DB->ConnectToDB( $this->DBName, $this->DBPath, $this->DBUserID, $this->DBPWord );
			
			$this->IsDBInitialized = TRUE;
		}
	}
	
	
	
	//************************************************************************
	function LoadData() {
	
		$this->ButtonList = array();		//  Clear Current Button List
		
		$SQL = "SELECT gen_buttons.* ";			//  Get Series Specific Buttons
		$SQL .= "FROM (site INNER JOIN gen_buttons ON site.site_id = gen_buttons.site_id) ";
		$SQL .= 'WHERE (((site.site_label)="'.$this->Site.'") AND ((gen_buttons.language_id)='.$this->LanguageID.'))';
								
		if ( $this->DB->RunSQL( $SQL ) == TRUE ) {
			
			while( $Row = $this->DB->RetrieveRow() ) {
			
				$this->ButtonList[ $Row['button_key'] ] = $Row['button_value'];
			}
		} else {	
echo "Button Connection to Site General Failed.";			
		}
		
		if ( $this->Series != '' ) {
		
			$SQL = "SELECT series_buttons.* ";			//	Get General Site buttons ... 
			$SQL .= "FROM (site INNER JOIN series ON site.site_id = series.site_id) INNER JOIN series_buttons ON series.series_id = series_buttons.series_id ";
			$SQL .= 'WHERE (((site.site_label)="'.$this->Site.'") AND ((series.series_label)="'.$this->Series.'") AND ((series_buttons.language_id)='.$this->LanguageID.'))';
							
			if ( $this->DB->RunSQL( $SQL ) == TRUE ) {
				
				while( $Row = $this->DB->RetrieveRow() ) {
				
					$this->ButtonList[ $Row['button_key'] ] = $Row['button_value'];
				}
			} else {	
echo "Button Connection to Series Failed.";			
			}
		}
	}
	
	
	//************************************************************************
	function Button( $Name, $Key ) {
	
		if ( array_key_exists( $Key, $this->ButtonList) == TRUE ) {
		
			$NewButton = new SubmitButton( $Name, $this->ButtonList[ $Key ] );
			return $NewButton;
		
		} else {
		
			$NewButton = new SubmitButton( $Name, $Key );
			return $NewButton;
		}
	}
	
	
	
	//************************************************************************
	function ButtonValue( $Key ) {
	
		if ( array_key_exists( $Key, $this->ButtonList) == TRUE ) {

			return $this->ButtonList[ $Key ];
		
		} else {

			return $Key;
		}
	}

}



class  MultiLingual_Lists {
// 
//  DESCRIPTION:
//		This class will create Drop Down Lists based upon the desired language of the 
//		veiwer.  It pulls the List data from the Language DB.
//
//	CONSTANTS:

//
//	VARIABLES:
	var $Site;
	var $Series;
	var $LanguageID;
	
	var $Labels;
	var $Values;
	
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
	function MultiLingual_Lists( $Site='AI', $Series='', $LanguageID=1, $DBName='multilingual', $DBPath=DB_PATH, $DBUserID=DB_USER, $DBPWord=DB_PWORD) {
	
		$this->Site = $Site;
		$this->Series = $Series;
		$this->LanguageID = $LanguageID;
		
		$this->Labels = array();
		$this->Values = array();
		
		$this->DBName = $DBName;
		$this->DBPath = $DBPath;
		$this->DBUserID = $DBUserID;
		$this->DBPWord = $DBPWord;
		$this->IsDBInitialized = FALSE;
	
		$this->InitDB();
	}

//
//	CLASS FUNCTIONS:
//

	//************************************************************************
	function TemplateName() {
	
	
	}
	
	
	//************************************************************************
	function InitDB() {

		if ( $this->IsDBInitialized == FALSE ) {
		
			$this->DB = new Database_MySQL;
			$this->DB->ConnectToDB( $this->DBName, $this->DBPath, $this->DBUserID, $this->DBPWord );
			
			$this->IsDBInitialized = TRUE;
		}
	}
	
	
	
	//************************************************************************
	function LoadData( $Key ) {
	
		$this->Labels = array();
		$this->Values = array();		//  Clear Current Lists
		
		if ( $this->Series != '' ) {
		
			$SQL = "SELECT series_lists.* ";			//	Get General Site buttons ... 
			$SQL .= "FROM (site INNER JOIN series ON site.site_id = series.site_id) INNER JOIN series_lists ON series.series_id = series_lists.series_id ";
			$SQL .= 'WHERE (((site.site_label)="'.$this->Site.'") AND ((series.series_label)="'.$this->Series.'") AND ( series_lists.list_key="'.$Key.'" ) AND ((series_lists.language_id)='.$this->LanguageID.')) ';
			$SQL .= 'ORDER BY list_order';
					
			if ( $this->DB->RunSQL( $SQL ) == TRUE ) {
				
				$DataExists = False;
				while( $Row = $this->DB->RetrieveRow() ) {
				
					$this->Labels[] = $Row['list_label'];
					$this->Values[] = $Row['list_value'];
					$DataExists = True;
				}
				
				// If no Data Exists in given Language then try to pull an English Version of the List
				if ($DataExists == False) {
				
					$SQL = "SELECT series_lists.* ";
					$SQL .= "FROM (site INNER JOIN series ON site.site_id = series.site_id) INNER JOIN series_lists ON series.series_id = series_lists.series_id ";
					$SQL .= 'WHERE (((site.site_label)="'.$this->Site.'") AND ((series.series_label)="'.$this->Series.'") AND ( series_lists.list_key="'.$Key.'" ) AND ((series_lists.language_id)=1)) ';
					$SQL .= 'ORDER BY list_order';
					
					$this->DB->RunSQL( $SQL );
					
					while( $Row = $this->DB->RetrieveRow() ) {
				
						$this->Labels[] = '['.$Row['list_label'].']';  // Put brackets around labels to indicate an Untranslated List
						$this->Values[] = $Row['list_value'];
						$DataExists = True;
					}
				}
			} else {	
echo "List Connection to Series Failed.";			
			}
		}
	}
	
	
	//************************************************************************
	function ListBox($Key,  $Name='', $DefaultValue='', $NumRows='1', $Parameters='' ) {
	//
	//	$Key is the Identifier of the ListBox you want to create.
	
		$this->LoadData( $Key );
		
		$NewList = new ListBox( $Name, $DefaultValue, $NumRows, $Parameters );
			
		for( $Indx=0; $Indx< count($this->Labels); $Indx++) {
			
			$NewList->AddEntry( $this->Labels[ $Indx ], $this->Values[ $Indx ] );
		}
			
		return $NewList;

	}
	
	
	//************************************************************************
	function LabelFromValue( $Key='<null>', $Value='<null>' ) {
	
		if (($Value != '<null>') && ($Value != '')) {
		
			$this->LoadData( $Key );
			
			for ($Indx=0; $Indx< count($this->Labels); $Indx++) {
			
				if ($this->Values[$Indx] == $Value ) {
					return $this->Labels[$Indx];
				}
			}
			
			return '[Error]MultiLingualLists::LabelFromValue::Value Not found.<br>';
			
		} else {
		
			return '';
		}
	}

}



class  MultiLingual_Image extends DisplayObject {
// 
//  DESCRIPTION:
//		This is an object to display multiple versions of an image depending on 
//		the given Language ID.  It depends on the Image being saved with corresponding
//		_en, _cn, or _ko tags to be properly used here.

//
//	VARIABLES:
	var $ImageFileName;
	
//
//	CLASS CONSTRUCTOR
//

	//************************************************************************
	function MultiLingual_Image( $ImageName, $ImageType, $LanguageID) {
	
		DisplayObject::DisplayObject();
		
		switch( $LanguageID ) {
			case 1: 
					$Temp = '_en';
					break;
			case 2:
					$Temp = '_cn';
					break;
			case 3: 
					$Temp = '_ko';
					break;
		}
	
		$this->ImageFileName = $ImageName.$Temp.$ImageType;
		
		// In Future Perform File Checking here, and default to _en or 
		// unmodified file names if they Exist.  If they don't then put 
		// HTML Message "Image XXX Not Found."
	
		$this->AddToDisplayList( "<img src=\"".$this->ImageFileName."\" >" );
		
	}

//
//	CLASS FUNCTIONS:
//

	//************************************************************************
	function TemplateName() {
	
	
	}
	

}


?>