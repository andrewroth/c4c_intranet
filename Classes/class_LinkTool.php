<?php


class  LinkTool {
// 
//  DESCRIPTION:
//		This is .....
//
//	CONSTANTS:

//
//	VARIABLES:
	var $LabelStyleOpen;
	var $LabelStyleClose;
	
//
//	CLASS CONSTRUCTOR
//

	//************************************************************************
	function LinkTool( $StyleOpen='', $StyleClose='') {
	
		$this->LabelStyleOpen	= $StyleOpen;
		$this->LabelStyleClose 	= $StyleClose;
	}

//
//	CLASS FUNCTIONS:
//

	//************************************************************************
	function TemplateName() {
	
	
	}
	
	
	
	//************************************************************************
	function CreateLink( $Link, $Label) {
	
		return '<a href="'.$Link.'">'.$this->LabelStyleOpen.$Label.$this->LabelStyleClose.'</a>';
	}
	

}






?>