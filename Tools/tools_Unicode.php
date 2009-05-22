<?php


//
//  UNICODE TOOLS
// 
//  DESCRIPTION:
//		This is a set of routines to work with Unicode data.
//
//	CONSTANTS:

//
//	VARIABLES:


//
// FUNCTIONS:
//

//  The following function was taken from the PHP web site comments.
//  It provides a way to generate UNICODE Entities for displaying non ASCII 
//  characters on a web page.
//
//  Author: ronen at greyzone dot com 
//  Date  : 01-Mar-2002 06:37  
//  Web Site Location: http://www.php.net/manual/en/function.utf8-decode.php
//
//	Author: Johnny Hausman @ Asia Impact
//  Date  : April 24, 2003
//  I have modified the given function to take an additional Argument: $ConvertAscii
//	This parameter determines if regular ASCII characters should be converted
//  to UNICODE Entities.  The Default action is NO Conversion for ASCII.
//
/*
 * takes a string of utf-8 encoded characters and converts it to a string of unicode entities
 * each unicode entitiy has the form &#nnnnn; n={0..9} and can be displayed by utf-8 supporting
 * browsers
 * @param $source string encoded using utf-8 [STRING]
 * @return string of unicode entities [STRING]
 * @access public
 */
function Unicode_utf8ToUnicodeEntities ($source, $convertAscii=false) {

	// array used to figure what number to decrement from character order value 
	// according to number of characters used to map unicode to ascii by utf-8
	$decrement[4] = 240;
	$decrement[3] = 224;
	$decrement[2] = 192;
	$decrement[1] = 0;

	// the number of bits to shift each charNum by
	$shift[1][0] = 0;
	$shift[2][0] = 6;
	$shift[2][1] = 0;
	$shift[3][0] = 12;
	$shift[3][1] = 6;
	$shift[3][2] = 0;
	$shift[4][0] = 18;
	$shift[4][1] = 12;
	$shift[4][2] = 6;
	$shift[4][3] = 0;

	$pos = 0;
	$len = strlen ($source);
	$encodedString = '';
	while ($pos < $len) {
	
		$asciiPos = ord (substr ($source, $pos, 1));
		if (($asciiPos >= 240) && ($asciiPos <= 255)) {
			// 4 chars representing one unicode character
			$thisLetter = substr ($source, $pos, 4);
			$pos += 4;
		}
		else if (($asciiPos >= 224) && ($asciiPos <= 239)) {
			// 3 chars representing one unicode character
			$thisLetter = substr ($source, $pos, 3);
			$pos += 3;
		}
		else if (($asciiPos >= 192) && ($asciiPos <= 223)) {
			// 2 chars representing one unicode character
			$thisLetter = substr ($source, $pos, 2);
			$pos += 2;
		}
		else {
			// 1 char (lower ascii)
			$thisLetter = substr ($source, $pos, 1);
			$pos += 1;
		}
		
		// process the string representing the letter to a unicode entity
		$thisLen = strlen ($thisLetter);
		$thisPos = 0;
		$decimalCode = 0;
		
		while ($thisPos < $thisLen) {
		
			$thisCharOrd = ord (substr ($thisLetter, $thisPos, 1));
			
			if ($thisPos == 0) {
			
				$charNum = intval ($thisCharOrd - $decrement[$thisLen]);
				$decimalCode += ($charNum << $shift[$thisLen][$thisPos]);
			}
			else {
			
				$charNum = intval ($thisCharOrd - 128);
				$decimalCode += ($charNum << $shift[$thisLen][$thisPos]);
			}
			
			$thisPos++;
		}
		
		if ($thisLen == 1){
			if ($convertAscii == true) {
				$encodedLetter = "&#". str_pad($decimalCode, 3, "0", STR_PAD_LEFT) . ';';
			} else {
				$encodedLetter = $thisLetter;
			}
		}else
			$encodedLetter = "&#". str_pad($decimalCode, 5, "0", STR_PAD_LEFT) . ';';
		
		$encodedString .= $encodedLetter;
	}
	
	return $encodedString;
}



/*
 * takes a string of unicode entities and converts it to a utf-8 encoded string
 * each unicode entitiy has the form &#nnn(nn); n={0..9} and can be displayed by utf-8 supporting
 * browsers.  Ascii will not be modified.
 * @param $source string of unicode entities [STRING]
 * @return a utf-8 encoded string [STRING]
 * @access public
 */
function Unicode_UnicodeToUTF8Entities($source) {
	$utf8Str = '';
	$entityArray = explode ("&#", $source);
	$size = count ($entityArray);
	for ($i = 0; $i < $size; $i++) {
		$subStr = $entityArray[$i];
		$nonEntity = strstr ($subStr, ';');
		if ($nonEntity !== false) {
			$unicode = intval (substr ($subStr, 0, (strpos ($subStr, ';') + 1)));
			// determine how many chars are needed to reprsent this unicode char
			if ($unicode < 128) {
				$utf8Substring = chr ($unicode);
			}
			else if ($unicode >= 128 && $unicode < 2048) {
				$binVal = str_pad (decbin ($unicode), 11, "0", STR_PAD_LEFT);
				$binPart1 = substr ($binVal, 0, 5);
				$binPart2 = substr ($binVal, 5);
				
				$char1 = chr (192 + bindec ($binPart1));
				$char2 = chr (128 + bindec ($binPart2));
				$utf8Substring = $char1 . $char2;
			}
			else if ($unicode >= 2048 && $unicode < 65536) {
				$binVal = str_pad (decbin ($unicode), 16, "0", STR_PAD_LEFT);
				$binPart1 = substr ($binVal, 0, 4);
				$binPart2 = substr ($binVal, 4, 6);
				$binPart3 = substr ($binVal, 10);
				
				$char1 = chr (224 + bindec ($binPart1));
				$char2 = chr (128 + bindec ($binPart2));
				$char3 = chr (128 + bindec ($binPart3));
				$utf8Substring = $char1 . $char2 . $char3;
			}
			else {
				$binVal = str_pad (decbin ($unicode), 21, "0", STR_PAD_LEFT);
				$binPart1 = substr ($binVal, 0, 3);
				$binPart2 = substr ($binVal, 3, 6);
				$binPart3 = substr ($binVal, 9, 6);
				$binPart4 = substr ($binVal, 15);
				
				$char1 = chr (240 + bindec ($binPart1));
				$char2 = chr (128 + bindec ($binPart2));
				$char3 = chr (128 + bindec ($binPart3));
				$char4 = chr (128 + bindec ($binPart4));
				$utf8Substring = $char1 . $char2 . $char3 . $char4;
			}
			
			if (strlen ($nonEntity) > 1)
				$nonEntity = substr ($nonEntity, 1); // chop the first char (';')
			else 
				$nonEntity = '';
			
			$utf8Str .= $utf8Substring . $nonEntity;
		}
		else {
			$utf8Str .= $subStr;
		}
	}
	
	return $utf8Str;
}


?>