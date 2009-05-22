//------------------------------------------------------------
function Haus_XferListBoxItem( sSourceName, sDestName) {
//
// DESCRIPTION
//	This function will Move the selected elements in the source ListBox to
//	the specified Destination ListBox.
//
// VARIABLES
  var objSource = MM_findObj(sSourceName);
  var objDest	= MM_findObj(sDestName);
  var i;
  var iNumItems;
  var objXferObject;
  var sTempLabel;
  var sTempValue;
//
// PSEUDO CODE
//   Get Current Index From Source
//	 Get Current Values From Source
//	 Add Values to Destination
//   Remove Values from Source
//   Get Destination Index
//
// CODE
//
	if (objSource){
		
		//Get Number of Items in List
		iNumItems = objSource.options.length
		
		for (i=0; i<=iNumItems-1; i++) {
			
			//if Current Index is selected
			if (objSource.options[i].selected) {
			
			//Get Current Values From Source
			sTempLabel = objSource.options[i].text;
			sTempValue = objSource.options[i].value;
			
			objXferObject = document.createElement("OPTION");
			objXferObject.text = sTempLabel;
			objXferObject.value = sTempValue;
			
			//Add Values to Destination
			//objDest.options.add(objXferObject);
			objDest.options[objDest.options.length]=objXferObject;
			
			//Remove Values from Source
			//objSource.options.remove(i);
			objSource.options[i]=null;
			
			i--
			iNumItems--
			}
		}
	}
}

