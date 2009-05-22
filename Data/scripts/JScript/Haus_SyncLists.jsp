function Haus_SyncLists(sNameofMainList, sNameofDependantList, sNameOfTargetList) {

  var objMain = MM_findObj(sNameofMainList);

  var objDependant = MM_findObj(sNameofDependantList);

  var objTarget = MM_findObj(sNameOfTargetList);

  

  objDependant.selectedIndex = objMain.selectedIndex;



  if (objTarget) {

      objTarget.value = objDependant.value

  }

  

}