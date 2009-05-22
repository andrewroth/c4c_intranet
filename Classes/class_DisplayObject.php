<?php


class  DisplayObject {
// 
//  DESCRIPTION:
//		This object defines the basic display unit for items that get 
//		"Displayed".  Other objects that return displayable items are
//		based upon this object: eg: Table, FormItems, Lists, etc...
//
//		This object provides a basic display structure for the items 
//		that are being displayed.  You can have it return a single
//		concatenated string of the display data (slower), or it can 
//		return the display data directly to the screen (faster).
//
//	CONSTANTS:
		var $CONST_POS_DATATYPE;
		var $CONST_POS_DATA;
		
//
//	VARIABLES:
		var $DisplayList;
		var $NumDisplayItems;
		
//
//	CLASS CONSTRUCTOR
//

	//************************************************************************
	function DisplayObject( $Data='', $Type=DISPLAYOBJECT_TYPE_HTML ) {
	
		//  Initialize the Values of this Class constants.
		$this->CONST_POS_DATATYPE	= "DT";
		$this->CONST_POS_DATA		= "D";
		
		//  Initialize the Display Variables.
		$this->DisplayList		= array();
		$this->NumDisplayItems  = 0;
		
		if ( $Data != '' ) {
			$this->AddToDisplayList( $Data, $Type );
		}
	
	}

//
//	CLASS FUNCTIONS:
//
	
	
	//************************************************************************
	function addToDisplayList( $DisplayData, $DisplayType=DISPLAYOBJECT_TYPE_HTML) {
	
		$this->NumDisplayItems ++;
		
		$Temp = array(	$this->CONST_POS_DATATYPE 	=> $DisplayType,
						$this->CONST_POS_DATA		=> $DisplayData  );
		
		$this->DisplayList[] = $Temp;
	
	}
	
	
	//************************************************************************
	function drawDirect() {
	
		//  For Each Item in your Data List
		for ( $CurrentDisplayItem = 0; $CurrentDisplayItem < $this->NumDisplayItems; $CurrentDisplayItem++) {
		
			//  If Item is HTML type then
			if ( $this->DisplayList[ $CurrentDisplayItem ][ $this->CONST_POS_DATATYPE] == DISPLAYOBJECT_TYPE_HTML ) {
	
				//Display it
				echo $this->DisplayList[$CurrentDisplayItem][$this->CONST_POS_DATA];
				
			//Else
			} else { 
				
				// Item is another Display Object, so Call it's DrawDirect() fn.
				$this->DisplayList[$CurrentDisplayItem][$this->CONST_POS_DATA]->drawDirect();
			}
			
		}
	
	}
	
	
	
	//************************************************************************
	function draw() {
	
		$Results = "";
		
		//  For Each Item in your Data List
		for ( $CurrentDisplayItem = 0; $CurrentDisplayItem < $this->NumDisplayItems; $CurrentDisplayItem++) {
		
			//  If Item is HTML type then
			if ( $this->DisplayList[ $CurrentDisplayItem ][ $this->CONST_POS_DATATYPE] == DISPLAYOBJECT_TYPE_HTML ) {
	
				//Add to Display String
				$Results .= $this->DisplayList[$CurrentDisplayItem][$this->CONST_POS_DATA];
				
			//Else
			} else { 
				
				// Item is another Display Object, so Call it's Draw() fn and add to result
				$Results .= $this->DisplayList[$CurrentDisplayItem][$this->CONST_POS_DATA]->draw();

			}
			
		}
		
		//  Return Display String
		return $Results;
	
	}

}



class  DisplayObject_MySQLDB extends DisplayObject {
// 
//  DESCRIPTION:
//		This is a type of Display Object that also directly accesses data in a 
//		DB.
//
//	CONSTANTS:

//
//	VARIABLES:
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
	function DisplayObject_MySQLDB( $DBName, $DBPath, $DBUserID, $DBPWord) {
	
		DisplayObject::DisplayObject();		//  Call the Parent Constructor.
		
		$this->DBName = $DBName;
		$this->DBPath = $DBPath;
		$this->DBUserID = $DBUserID;
		$this->DBPWord = $DBPWord;
		$this->IsDBInitialized = false;
	
	}

//
//	CLASS FUNCTIONS:
//

	//************************************************************************
	function TemplateName() {
	
	
	}
	
	
	//************************************************************************
	function initDB() {
	
		if ( $this->IsDBInitialized == false ) {
		
			$this->DB = new Database_MySQL;
			$this->DB->ConnectToDB( $this->DBName, $this->DBPath, $this->DBUserID, $this->DBPWord );
			
			$this->IsDBInitialized = true;
		}
	}
	

}






?>