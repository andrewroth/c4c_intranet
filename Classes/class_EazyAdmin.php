<?php


class  EazyAdmin {
// 
//  DESCRIPTION:
//		This is the base Administrative Entry Class.  It handles the internal Displaying of the 
//		form, the loading of data from the form, routines to check the validity of the data, etc...
//
//	CONSTANTS:

//
//	VARIABLES:
	var $cCallBack;
	var $cLabels;
	var $cLanguageID;
	var $Title;
	var $ClassTitle;
	
	var $Values;
	var $EntryList;
	var $Entries;
	var $EntryTypes;
	var $Types;
	var $OutPutMessages;

//
//	CLASS CONSTRUCTOR
//

	//************************************************************************
	function EazyAdmin( $CallBack, $LanguageID, $LabelSeries='AdminGen' ) {
		
		$this->cCallBack = $CallBack;
		
		$this->cLanguageID = $LanguageID;
		
		$this->cLabels = new MultiLingual_Labels( 'AI', $LabelSeries, $this->ClassTitle, $LanguageID );
	
		$this->Title = $this->cLabels->Label('[Title]');
		
		$this->Values = array();

		
		$this->Entries = explode(',', $this->EntryList );
		$this->Types = explode(',', $this->EntryTypes );
		
		$this->OutPutMessages = '';
	}


//
//	CLASS FUNCTIONS:
//


	//************************************************************************
	function GetDisplayData() {	
		
		$Data = new DisplayObject();
		
		$Data->AddToDisplayList('<form action="'.$this->cCallBack.'" method="post" name="'.$this->ClassTitle.'">
			  <input type="hidden" name="Process" value="Yes">
              <table width="100%" border="0" cellspacing="6" cellpadding="6">');

		
		for( $Indx=0; $Indx<count($this->Entries) ; $Indx++) {

			$Data->AddToDisplayList( $this->ReturnDisplayRow( $this->Types[ $Indx ], $this->Entries[$Indx]), DISPLAYOBJECT_TYPE_OBJECT);
		
		}
		
		$Data->AddToDisplayList('<tr> 
                  <td>&nbsp;</td>
                  <td><input type="submit" name="Submit" value="Submit"></td>
                </tr>');
		
		$Data->AddToDisplayList( '</table></form>');
	
		if ($this->OutPutMessages != '') {
		
			$Data->AddToDisplayList( '<hr size="1" noshade color="223450"><p class="text">'.$this->OutPutMessages.'</p>' );
		
		}
	
		return $Data;
	}
	

	//************************************************************************
	function LoadFromForm() {
	
		for( $Indx=0; $Indx<count($this->Entries) ; $Indx++) {
		
			if (isset( $_REQUEST[ $this->Entries[ $Indx ] ] ) == true ) {
			
				$this->Values[ $this->Entries[ $Indx ] ] =  $_REQUEST[ $this->Entries[ $Indx ] ] ;
				
			} else {
			
				$this->Values[ $this->Entries[ $Indx ] ] = '';
			}
		}
	
	}
	
	
	//************************************************************************
	function CheckValidData( $Key, $InvalidValue, $IsValidFlag) {
	//
	//	DESCRIPTION:
	//		This is a simple data validation function to verify the data in a given
	//		value.
	//
		$ReturnValue = $IsValidFlag;
		
		if ( $this->Values[ $Key ] == $InvalidValue ) {
		
			$this->ErrorMessages[ $Key ] = $this->cLabels->Label('[Error_'.$Key.']');
			$ReturnValue = false;
		}
		
		return $ReturnValue;
	
	}
	
	
	//************************************************************************
	function ReturnDisplayRow( $DataType, $EntryData ) {
	
		$Return = '';
		
		$Data = explode( ':', $DataType);
		
		switch ( $Data[0] ) {
		
			case 'T2':  // Alternative Display Routine
				
				$Return = '<tr> 
			  <td class="text" valign="top" colspan="2">'.$this->cLabels->Label('['.$EntryData.']').'</td>
			  </tr>
			  <tr>
			  <td width="50%">&nbsp;</td>
			  <td><input name="'.$EntryData.'" type="text" value="'.$this->Values[ $EntryData ].'">';
			  
				if ( isset( $this->ErrorMessages[ $EntryData ] ) == true ) {
					$Return .= '<div class="error">'.$this->cLabels->Label($this->ErrorMessages[ $EntryData ]).'</div>';
				}
				
			   $Return .= '<div class="example">'.$this->cLabels->Label('[Ex'.$EntryData.']').'</div></td></tr>';
				break;
		
			case 'T':
				
				$Return .= '<tr> 
			  <td class="text" valign="top">'.$this->cLabels->Label('['.$EntryData.']').'</td>
			  <td><input name="'.$EntryData.'" type="text" value="'.$this->Values[ $EntryData ].'">';
			  
				if ( isset( $this->ErrorMessages[ $EntryData ] ) == true ) {
					$Return .= '<div class="error">'.$this->cLabels->Label($this->ErrorMessages[ $EntryData ]).'</div>';
				}
				
			   $Return .= '<div class="example">'.$this->cLabels->Label('[Ex'.$EntryData.']').'</div></td>
			</tr>';
				break;
				
				
			case 'M':
				
				$Return .= '<tr> 
			  <td class="text" valign="top">'.$this->cLabels->Label('['.$EntryData.']').'</td>
			  <td><textarea name="'.$EntryData.'" rows="5" id="'.$EntryData.'">'.$this->Values[ $EntryData ].'</textarea>';
			  
				if ( isset( $this->ErrorMessages[ $EntryData ] ) == true ) {
					$Return .= '<div class="error">'.$this->cLabels->Label($this->ErrorMessages[ $EntryData ]).'</div>';
				}
				
			   $Return .= '<div class="example">'.$this->cLabels->Label('[Ex'.$EntryData.']').'</div></td>
			</tr>';
				break;
				
				
			case 'CB':
				
				$Return .= '<tr> 
			  <td class="text" valign="top">'.$this->cLabels->Label('['.$EntryData.']').'</td>
			  <td><input name="'.$EntryData.'" type="checkbox" value="1"';
			  
				if ($this->Values[ $EntryData ] != '') {
					$Return .= ' checked';
				}
				
				$Return .= '></td></tr>';
				break;
				
				
			case 'L':
				
				$Return .= '<tr> 
			  <td class="text" valign="top" colspan="2">'.$this->cLabels->Label('['.$EntryData.']').'</td>
			  </tr>';
				break;
			
			case 'LB':
				break;
		}
		
		// Expects a DisplayObject to be returned
		$ReturnObject = new DisplayObject( $Return );
		return $ReturnObject;
	
	}
	
	
	
	//************************************************************************
	function TemplateName() {
	
	
	
	}
	

}






?>