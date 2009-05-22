<?php
	require('../General/gen_Defines.php');
	require('../General/gen_Includes.php');
// 	require('../objects/SiteObject.php');
// 	require('../objects/Page.php');

	require('../modules/app_cim_reg/objects_da/EventManager.php');
	require('../modules/app_cim_reg/objects_da/PriceRuleManager.php');
	require('../modules/app_cim_reg/objects_da/FieldValueManager.php');
	require('../modules/app_cim_reg/objects_da/ScholarshipAssignmentManager.php');
	require('../modules/app_cim_reg/objects_da/CashTransactionManager.php');
	require('../modules/app_cim_reg/objects_da/CreditCardTransactionManager.php');
	
	

	$toolName = '../Tools/tools_Finances.php';
	$toolPath = '';	//Page::findPathExtension( $toolName );
	require_once( $toolPath.$toolName);
	
    // get privileges for the current viewer
   $privManager = new PrivilegeManager( $this->viewer->getID() );  
   if ($privManager->isCampusAdmin($this->EVENT_ID, $this->CAMPUS_ID)==true)	
   {	
	   
		/********** NOTE: make sure 60 second PHP timeout is not activated: use filters, such as event_id  ************/
		$EVENT_ID = 18;
	
		// retrieve registration records
		$regs = new RowManager_RegistrationManager();
		$regs->setEventID($EVENT_ID);
		$regsList = $regs->getListIterator();
		$regsArray = $regsList->getDataList();
		
		$priceGetter = new FinancialTools();
		
	   reset($regsArray);
	  	foreach(array_keys($regsArray) as $k)
		{
			$record = current($regsArray);
			$reg_id = $record['registration_id'];
			
			$owed = $priceGetter->simpleCalcBalanceOwing($reg_id);	
			
			// store calculated balance owing in registration record
			$singleReg = new RowManager_RegistrationManager($reg_id);
			$balance = array();
			$balance['registration_balance'] = $owed;
			$singleReg->loadFromArray( $balance );
			$singleReg->updateDBTable();			
			
			next($regsArray);
	
		}
		echo "SUCCESS!";
	}
	else 
	{
		echo "PRIVILEGE LEVEL NOT HIGH ENOUGH...";
	}
	
?>