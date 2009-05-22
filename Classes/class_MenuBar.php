<?php


class  MenuBar extends DisplayObject {
// 
//  DESCRIPTION:
//		This is .....
//
//	CONSTANTS:

//
//	VARIABLES:
	var $MenuItems;			// The Menu Bar Etnries ... 
	var $MenuItemTypes;		// HTML or Object
	
//
//	CLASS CONSTRUCTOR
//

	//************************************************************************
	function MenuBar() {
	
		DisplayObject::DisplayObject();
		
		$this->MenuItems = array();
		$this->MenuItemTypes = array();
		
	
	}

//
//	CLASS FUNCTIONS:
//

	//************************************************************************
	function AddMenuEntry( $Item, $Type=DISPLAYOBJECT_TYPE_HTML) {
	
		$this->MenuItems[] = $Item;
		$this->MenuItemTypes[] = $Type;
		
	}
	
	
	
	
	//************************************************************************
	function DrawInit() {


		$this->AddToDisplayList( '<table width="100%" height="21" border="0" cellpadding="0" cellspacing="0">
		<tr> 
		  <td height="20" bgcolor="EEEEEE">
			  <table width="100%" border="0" cellspacing="2" cellpadding="3">
				<tr> 
				  <td class="navbar" valign="top"><div align="right" class="navbar">' );
				  
				  
		$this->AddToDisplayList( '<table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td align="right" valign="top" class="navbar">');

		
		// Now For each entry, add it to the Display List
		for( $Indx=0; $Indx< count( $this->MenuItems ); $Indx++) {
		
			if ( $Indx > 0 ) {
				$this->AddToDisplayList( ' | ' );
			}
			
			$this->AddToDisplayList( $this->MenuItems[$Indx], $this->MenuItemTypes[ $Indx ] );
		}
		
		
		
		$this->AddToDisplayList( '</td></tr></table>' );
		
		$this->AddToDisplayList( '</div></td>
				</tr>
			  </table></td>
		</tr>
		<tr> 
		  <td height="1" bgcolor="223450"><img src="images/space.gif" width="1" height="1"></td>
		</tr>
	  </table>' );
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
	
	
	//************************************************************************
	function TemplateName() {
	
	
	}
	

}






?>