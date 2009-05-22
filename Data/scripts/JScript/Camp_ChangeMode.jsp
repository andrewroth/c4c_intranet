function Camp_ChangeEditMode(newMode, newID) {
	
	var oEditMode = MM_findObj('EditMode');
	var oEditID = MM_findObj('EditID');
	
	if(document.all) {
		
		oEditMode.value = newMode;
		oEditID.value = newID;
		
	} else if(document.layers) {
		
		document.oEditMode.value = newMode;
		document.oEditID.value = newID;
		
	} else if(isGecko()) {
		
		oEditMode.value = newMode;
		oEditID.value = newID;
		
	}
	
	document.Form.submit()
}

function isGecko()  {

   var ua = navigator.userAgent.substring(0,11)

   if(ua=='Mozilla/5.0')  {

	return true;

   }

   else {

	return false;

   }

}





