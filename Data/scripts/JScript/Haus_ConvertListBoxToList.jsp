

//------------------------------------------------------------

function Haus_ConvertListBoxToList( sListName, sDestinationName) {

//

// DESCRIPTION

//   This function will take an existing ListBox and copy all the values

//   in order to a provided List (textbox or hidden Field).

//

// VARIABLES

   var objListBox = MM_findObj(sListName);	//The ListBox Item

   var objField = MM_findObj(sDestinationName); //The List Item

   var iIndx;					//Index for processing each item In ListBox



//

// PSEUDO CODE

//   Set Destination List to Empty Value

//   For Each Item in the Listbox

//      If this is the first Entry in the List then

//			Add Current List Item to List

//		else

//			Add "," + Current List Item to List

//		end if

//   Next

//

// CODE

//



   objField.value = "";



   for (iIndx=0; iIndx<= (objListBox.length-1); iIndx++) {



      if (objField.value == "") {

         objField.value = objField.value + objListBox.options[iIndx].value;

      } else {

         objField.value = objField.value + "," + objListBox.options[iIndx].value;

      }

   }

}