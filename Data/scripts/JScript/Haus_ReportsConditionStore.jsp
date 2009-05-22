//------------------------------------------------------------

function Haus_ConditionStore() {

//

// DESCRIPTION

//	This function will Move the selected element in the source ListBox to

//	the specified Destination ListBox.

//

// VARIABLES

  var objField = MM_findObj("Fields");

  var objOps	= MM_findObj("Ops");

  var objValue	= MM_findObj("Value");

  var objConditionList	= MM_findObj("ConditionList");

  var sTempCondition;

  var iFieldCurIndx;

  var iOpsCurIndx;

  var objXferObject;

//

// PSEUDO CODE

//   Build Condition (Field.Value + Assignment.Value + Value)

//   Add Condition to 

//

// CODE

//

  



  if (objField){

  

	//Get Current Index

	iFieldCurIndx = objField.selectedIndex;

	iOpsCurIndx = objOps.selectedIndex;

     

	sTempCondition = objField.options[iFieldCurIndx].value + objOps.options[iOpsCurIndx].value;

	sTempCondition = sTempCondition + objValue.value;

	 

	objXferObject = document.createElement("OPTION");

	objXferObject.text = sTempCondition;

	objXferObject.value = sTempCondition;

	 

	//Add Values to Destination

	objConditionList.options.add(objXferObject);	

	 

//window.prompt("Condition=[" + sTempCondition + "]","");



//	 if (iFieldCurIndx != -1) {

//	 

//		//Get Current Values From Source

//		sTempLabel = objSource.options[iCurIndx].text;

//		sTempValue = objSource.options[iCurIndx].value;

//  //   



//	 

//		//Remove Values from Source

//		objSource.options.remove(iCurIndx);

//

//		//Set Destination Index

//		iCurIndx = objDest.options.length

//		objDest.selectedIndex = iCurIndx-1;

//		

//     }

  }

}





//------------------------------------------------------------

function Haus_MoveToJoin(sJoinField) {

//

// DESCRIPTION

//	This function will Move the selected element in the source ListBox to

//	the specified Destination ListBox.

//

// VARIABLES

  var objField = MM_findObj( sJoinField );

  var objConditionList	= MM_findObj("ConditionList");

  var sTempCondition;

  var iCurIndx;

//

// PSEUDO CODE

//   Get Condition to Transfer

//	 Store in proper Join Field

//	 Remove from Condition List

//

// CODE

//

  



  if (objConditionList){

  

	//Get Condition to Transfer

	iCurIndx = objConditionList.selectedIndex;

	if (iCurIndx != -1) {

	

		sTempCondition = objConditionList.options[iCurIndx].value;

	

		//Store in Proper Join Field

		objField.value = sTempCondition;



		//Remove from Condition List

		objConditionList.options.remove(iCurIndx);	

	

	}



  }

}





//------------------------------------------------------------

function Haus_ConditionJoin() {

//

// DESCRIPTION

//	This function will join the two conditions in the Join section

//	and add the result to the Condition List.

//

// VARIABLES

  var objJoinA = MM_findObj( "JoinA" );

  var objJoinB = MM_findObj( "JoinB" );

  var objOp	= MM_findObj("JoinType");

  var objConditionList	= MM_findObj("ConditionList");

  var objXferObject;

  var sTempCondition;

  var iJoinIndx;

//

// PSEUDO CODE

//   Get Condition to Transfer

//	 Store in proper Join Field

//	 Remove from Condition List

//

// CODE

//

  



  if (objConditionList){

  

	//Get Condition to Transfer

	iJoinIndx = objOp.selectedIndex;

	sTempCondition = objJoinA.value + " " + objOp.options[iJoinIndx].value + " " + objJoinB.value;

	sTempCondition = "(" + sTempCondition + ")";

	

	//Store in Proper Join Field

	objXferObject = document.createElement("OPTION");

	objXferObject.text = sTempCondition;

	objXferObject.value = sTempCondition;

	 

	//Add Values to Destination

	objConditionList.options.add(objXferObject);





	//Remove from Join Fields

	objJoinA.value = "";

	objJoinB.value = "";



  }

}





//------------------------------------------------------------

function Haus_ConditionSave(sDest) {

//

// DESCRIPTION

//	This function will join the two conditions in the Join section

//	and add the result to the Condition List.

//

// VARIABLES

  var objField = MM_findObj( sDest );

  var objConditionList	= MM_findObj("ConditionList");

//

// PSEUDO CODE

//   Get Condition to Transfer

//	 Store in proper Join Field

//	 Remove from Condition List

//

// CODE

//

  



  if (objConditionList.length != 0){

  

	//Get Condition to Transfer

	objField.value = objConditionList.options[0].value;



  } else {

	objField.value = "";

  }

}