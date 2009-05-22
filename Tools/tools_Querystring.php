<?php


//
//  QUERYSTRING TOOLS
// 
//  DESCRIPTION:
//		This set of routines helps you retrieve the values passed in to 
//		the page via the Querystring.
//
//	CONSTANTS:

//
//	VARIABLES:


//
// FUNCTIONS:
//

//************************************************************************
function QueryString_LoadValue( $ValueReference, $DefaultValue) {

	if ( isset( $_REQUEST[ $ValueReference ] ) == True ) {
		$ReturnVal = $_REQUEST[ $ValueReference ];
	} else {
		$ReturnVal = $DefaultValue;
	}

	return $ReturnVal;
}
	







?>