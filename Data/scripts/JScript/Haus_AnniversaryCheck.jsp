function Haus_AnniversaryCheck() {

   var oMarried = MM_findObj('Marital Status');

   var oMonth = MM_findObj('AMonth');

   var oDay = MM_findObj('ADay');

   var oYear = MM_findObj('AYear');



   if (oMarried) {

      if (oMarried.value == "Single") {

   	Haus_showHideAnnvDate('hidden');

        oMonth.disabled = true;

        oDay.disabled = true;

        oYear.disabled = true;

      } else {

	Haus_showHideAnnvDate('visible');

        oMonth.disabled = false;

        oDay.disabled = false;

        oYear.disabled = false;

      }

   }

}





function Haus_showHideAnnvDate(state) {



   if(document.all) {

	AnnvDateLabel.style.visibility = state;

	AnnvDateValue.style.visibility = state;

   }

   else if(document.layers) {

	document.AnnvDateLabel.visibility = state;

	document.AnnvDateValue.visibility = state;

   }

   else if(isGecko()) {

	var myDivs = document.getElementsByTagName("div")

	myDivs['AnnvDateLabel'].style.visibility = state;

	myDivs['AnnvDateValue'].style.visibility = state;

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