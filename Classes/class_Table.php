<?php 


class Table {
// Table Class
//
//	DESCRIPTION:  
//		This class is responsible for creating a table.  It handles the Data  
//		Collection for the table, as well as it's drawing capabilities.
//
//	CLASS CONSTANTS:
		var $CONST_TABLE_DATATYPE = "dtype";
		var $CONST_TABLE_CELLDATA = "celldata";
		var $CONST_TABLE_CELLPARAMETER = "cparams";
		var $CONST_TABLE_NUMCOLS = "ncol";
		var $CONST_TABLE_NUMROWS = "nrow";

//	
//	VARIABLES:
		var $TableParameters;
		var $NumColumns;
		var $MultiRowCells;
		var $DefaultCellParameter;
		var $NumDataItems;
		var $TableData;
		
//
//	CLASS CONSTRUCTOR
//
	
	//************************************************************************
	function Table ( $NumColumns=0, $Parameters='') {
	//  The Constructor for this object.  It initially defines the Constants,  
	//	and sets the Table Values to appropriate default values.
	//
	
		$this->CONST_TABLE_DATATYPE 		= "dtype";
		$this->CONST_TABLE_CELLDATA 		= "celldata";
		$this->CONST_TABLE_CELLPARAMETER 	= "cparams";
		$this->CONST_TABLE_NUMCOLS 			= "ncol";
		$this->CONST_TABLE_NUMROWS 			= "nrow";
	
	
		if ($Parameters <> '') {
			$this->TableParameters 		= $Parameters;
		} else {
			$this->TableParameters		= 'width="100%" border="0" cellspacing="1" cellpadding="1"';
		}
		$this->NumDataItems			= 0;
		$this->DefaultCellParameter = " valign=\"top\" ";
		$this->NumColumns 			= $NumColumns;
	}
	
	
//
//	CLASS FUNCTIONS:
//
	//************************************************************************
	function setTableParameters( $Parameters ) {
	//	This function allows the programmer to manually build the Table 
	//	parameters and pass them in.
	
		$this->TableParameters = $Parameters;
		
	}
	
	
	
	//************************************************************************
	function setNumColumns( $NumCols ){
	
		$this->NumColumns = $NumCols;
		
	}
	
	
	
	//************************************************************************
	function setDefaultCellParameters( $CellParameters ){
	
		$this->DefaultCellParameter = $CellParameters;
		
	}



	//************************************************************************
	function addTableCell( $CellData, $CellParameter="[use default]", $DataType=DISPLAYOBJECT_TYPE_HTML, $NumCols=1, $NumRows=1) {

		if (($CellParameter == "[use default]") || ($CellParameter=="") ) {

			$CellParameter = $this->DefaultCellParameter;
		}
		
		$this->NumDataItems++;

		$Temp = array(	$this->CONST_TABLE_DATATYPE => $DataType, 
						$this->CONST_TABLE_CELLDATA => $CellData, 
					 	$this->CONST_TABLE_CELLPARAMETER => $CellParameter,
				 		$this->CONST_TABLE_NUMCOLS => $NumCols,
				 		$this->CONST_TABLE_NUMROWS => $NumRows );
	
		$this->TableData[] = $Temp;
	}



	//************************************************************************
	function Draw() {
	//	This function takes the values stored in the Table object and draws it 
	//	by creating a long string of the HTML representing this table.
	//
	//	If you need to draw a very large table, you might want to consider using
	//	DrawDirect() instead (it will be faster since you don't have to concat
	//	all these strings).
	//
		$CurrentCell = 1;
		$CurrentDataItem = 0;
		$CurrentRow = 1;
		$CurrentColumnNumber = 1;
		$Results = "";
		$RowAdjustments= array();
		
		//Return Table Header with Parameters
		$Results = "<table ".$this->TableParameters." >\r\n";
		
		//Begin 1st Row Marker
		$Results = $Results."<tr>\r\n";
		
		//For Each Data Element
		for ($CurrentDataItem = 0; $CurrentDataItem < $this->NumDataItems ; $CurrentDataItem++) {
		
			//if Element is HTML to display then	
			if ( $this->TableData[ $CurrentDataItem ][ $this->CONST_TABLE_DATATYPE] == DISPLAYOBJECT_TYPE_HTML ) {
			
				//Create new Table Cell with Data Item
				//Display it
				$Results = $Results."<td ".$this->TableData[$CurrentDataItem][$this->CONST_TABLE_CELLPARAMETER]." colspan=\"".$this->TableData[ $CurrentDataItem ][ $this->CONST_TABLE_NUMCOLS ].'"  rowspan="'.$this->TableData[ $CurrentDataItem ][ $this->CONST_TABLE_NUMROWS ].'" >'.$this->TableData[$CurrentDataItem][$this->CONST_TABLE_CELLDATA]."</td>";
				
			//Else
			} else { 
				
				$Results = $Results."<td ".$this->TableData[$CurrentDataItem][$this->CONST_TABLE_CELLPARAMETER]." colspan=\"".$this->TableData[ $CurrentDataItem ][ $this->CONST_TABLE_NUMCOLS ].'"  rowspan="'.$this->TableData[ $CurrentDataItem ][ $this->CONST_TABLE_NUMROWS ].'" >';
				
				//Get this Table Object
				$SubTable = $this->TableData[$CurrentDataItem][$this->CONST_TABLE_CELLDATA];
				
				//TableObject->DrawDirect();
				$Results = $Results.$SubTable->Draw();
				
				$Results = $Results."</td>";
				
			//End If
			}
			
			//CurrentColNum++;
			$CurrentColumnNumber += $this->TableData[ $CurrentDataItem ][ $this->CONST_TABLE_NUMCOLS ];

			//  Add NumRow Adjustment if needed ...
			if ( $this->TableData[ $CurrentDataItem ][ $this->CONST_TABLE_NUMROWS ] > 1) {
				$RowAdjustments[] = $this->TableData[ $CurrentDataItem ][ $this->CONST_TABLE_NUMROWS ];
			}

			//If CurrentColNum > NumCols then
			if ( $CurrentColumnNumber > $this->NumColumns) {
			
				//End Row
				$Results = $Results."\r\n</tr>\r\n";
				
				//Adjust MultiRowCells Data
				for ($Indx=0; $Indx<count($RowAdjustments); $Indx++) {
					$RowAdjustments[$Indx] -= 1;
				}
				
				//if still have more Entries to Draw then
				if ( $CurrentDataItem < ($this->NumDataItems) -1 ) {
				
					//Draw Row Beginning
					$Results = $Results."<tr>\r\n";
					
					//Calculate Col#'s by Using data in MultiRowCells total
					$CurrentColumnNumber = 1;
					
					//  For each outstanding Row Adjustment, Adjust the Column Number
					for ($Indx=0; $Indx<count($RowAdjustments); $Indx++) {
						if ($RowAdjustments[$Indx] >= 1 ) {
							$CurrentColumnNumber++;
						}
					}	
					
				//end if
				}
				
			//End If
			}
			
		} //Next Element
		
		//Finish with final Table Marker.
		$Results = $Results."</table>\r\n";
	
		return $Results;
	}



	//************************************************************************
	function DrawDirect() {
	//	This function takes the values stored in the Table object and draws it 
	//	directly to the screen.  It is intended to be called as the last drawing
	//  command to put the data directly back to the browser.  This will avoid
	//	performing a long sequence of String Concatinations and speed the display
	//	of the page.
	//
	//	If you need to draw and save the intermediate table values, use Draw() 
	//	instead.
	//
		$CurrentCell = 1;
		$CurrentDataItem = 0;
		$CurrentRow = 1;
		$CurrentColumnNumber = 1;
		$RowAdjustments = array();
		
		
		//Return Table Header with Parameters
		echo "<table ".$this->TableParameters." >\r\n";
		
		//Begin 1st Row Marker
		echo "<tr>\r\n";
		
		//For Each Data Element
		for ($CurrentDataItem = 0; $CurrentDataItem < $this->NumDataItems ; $CurrentDataItem++) {
		
			//if Element is HTML to display then	
			if ( $this->TableData[ $CurrentDataItem ][ $this->CONST_TABLE_DATATYPE] == DISPLAYOBJECT_TYPE_HTML ) {
			
				//Create new Table Cell with Data Item
				//Display it
				echo "<td ".$this->TableData[$CurrentDataItem][$this->CONST_TABLE_CELLPARAMETER]." colspan=\"".$this->TableData[ $CurrentDataItem ][ $this->CONST_TABLE_NUMCOLS ].'"  rowspan="'.$this->TableData[ $CurrentDataItem ][ $this->CONST_TABLE_NUMROWS ].'" >'.$this->TableData[$CurrentDataItem][$this->CONST_TABLE_CELLDATA]."</td>";
				
			//Else
			} else { 
				
				echo "<td ".$this->TableData[$CurrentDataItem][$this->CONST_TABLE_CELLPARAMETER]." colspan=\"".$this->TableData[ $CurrentDataItem ][ $this->CONST_TABLE_NUMCOLS ].'"  rowspan="'.$this->TableData[ $CurrentDataItem ][ $this->CONST_TABLE_NUMROWS ].'" >';
				
				//Get this Table Object
				$SubTable = $this->TableData[$CurrentDataItem][$this->CONST_TABLE_CELLDATA];
				
				//TableObject->DrawDirect();
				$SubTable->DrawDirect();
				
				echo "</td>";
				
			//End If
			}
			
			//CurrentColNum++;
			$CurrentColumnNumber += $this->TableData[ $CurrentDataItem ][ $this->CONST_TABLE_NUMCOLS ];

			//  Add NumRow Adjustment if needed ...
			if ( $this->TableData[ $CurrentDataItem ][ $this->CONST_TABLE_NUMROWS ] > 1) {
				$RowAdjustments[] = $this->TableData[ $CurrentDataItem ][ $this->CONST_TABLE_NUMROWS ];
			}
			
			//If CurrentColNum > NumCols then
			if ( $CurrentColumnNumber > $this->NumColumns) {
			
				//End Row
				echo "\r\n</tr>\r\n";
				
				//Adjust MultiRowCells Data
				for ($Indx=0; $Indx<count($RowAdjustments); $Indx++) {
					$RowAdjustments[$Indx] -= 1;
				}
				
				//if still have more Entries to Draw then
				if ( $CurrentDataItem < ($this->NumDataItems) -1 ) {
				
					//Draw Row Beginning
					echo "<tr>\r\n";
					
					//Calculate Col#'s by Using data in MultiRowCells total
					$CurrentColumnNumber = 1;
					
					//  For each outstanding Row Adjustment, Adjust the Column Number
					for ($Indx=0; $Indx<count($RowAdjustments); $Indx++) {
						if ($RowAdjustments[$Indx] >= 1 ) {
							$CurrentColumnNumber++;
						}
					}
					
					
				//end if
				}
				
			//End If
			}
			
		} //Next Element
		
		//Finish with final Table Marker.
		echo "</table>\r\n";
	
	}


}


?>
