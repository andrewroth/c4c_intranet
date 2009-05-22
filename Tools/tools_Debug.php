<?php


//
//  DEBUG TOOLS
// 
//  DESCRIPTION:
//		This set of routines provide features to help you debug your program.
//
//	CONSTANTS:

//
//	VARIABLES:


//
// FUNCTIONS:
//

//************************************************************************
function Debug_Template() {


}
	

//************************************************************************
function Debug_PrintArray( $Name, $Array) {

	echo "{$Name}[]=[";
	for( $Indx=0; $Indx<count($Array); $Indx++) {
		echo $Array[$Indx].", ";
	}
	echo "]<br>";
}






?>