function Camp_EndDateCheck() {

   var oActive = MM_findObj('Active');



   if (oActive) {

      if (oActive.checked) {

   	Camp_showHideEndDate('hidden');

      } else {

	Camp_showHideEndDate('visible');

      }

   }

}





function Camp_showHideEndDate(state) {



   if(document.all) {

	EndDateValue.style.visibility = state;

   }

   else if(document.layers) {

	document.EndDateValue.visibility = state;

   }

   else if(isGecko()) {

	var myDivs = document.getElementsByTagName("div")

	myDivs['EndDateValue'].style.visibility = state;

   }



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





