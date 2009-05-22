//------------------------------------------------------------

function Haus_ReorderListBox( objListName, sOperation) {

//

// DESCRIPTION

//	This function will Move an element in the specified ListBox either

//	'UP' one entry or 'DOWN' one entry depending on the value of sOperation.

//

//	NOTE:  Valid values for sOperation are: 

//			'-' for UP; 

//			'+' for DOWN

//

// VARIABLES

  var objListBox = MM_findObj(objListName);

  var iCurIndx;

  var iDestIndx;

  var sTempLabel;

  var sTempValue;

//

// PSEUDO CODE

//   Get Current Index

//   Get Destination Index

//   If Valid Destination then

//      Place Label and Value of Destination location in Temp Variables

//      Place Current Item in Destination Slot

//      Place Temp Label and Value in Current Slot

//      Update SelectedIndex to point to destination slot

//   End if

//

// CODE

//

  

  if (objListBox) {

     //Get Current Index

     iCurIndx = objListBox.selectedIndex;

     

     //Get Destination Index

     eval("iDestIndx = iCurIndx " + sOperation + " 1");



     //If Valid Destination then

     if ((iDestIndx >= 0) && (iDestIndx <= (objListBox.length-1))) {

     

        //Place Label and Value of destination location in Temp Variables

        sTempLabel = objListBox.options[iDestIndx].text;

        sTempValue = objListBox.options[iDestIndx].value;



        //Place Current Item In Destination Slot

        objListBox.options[iDestIndx].text = objListBox.options[iCurIndx].text;

        objListBox.options[iDestIndx].value = objListBox.options[iCurIndx].value;



        //Place Temp Label and Value into Current Slot

        objListBox.options[iCurIndx].text = sTempLabel;

        objListBox.options[iCurIndx].value = sTempValue;



        //Update SelectedIndex to point to Destination Slot

        objListBox.selectedIndex = iDestIndx;

     }

  }

}



