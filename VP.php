<?php
$pathFile = 'General/gen_Includes.php';
$extension = '';
   
// Attempt to find proper directory from current page to Root ...
while ( !file_exists($extension.$pathFile) ) {
    $extension = '../'.$extension;
}
require ( $extension.$pathFile );

$template = new Template( );
$errorMessages = array();
$sqlResult = new ReadOnlyResultSet(null);

if (isset( $_REQUEST[ 'fName' ] ) || isset( $_REQUEST[ 'lName' ]) ) {
	$errorMessages = process_Form($sqlResult, $template, $errorMessages);
	show_Form($template, $errorMessages);

} else {
	show_Form($template, $errorMessages);

}	

	function process_Form($sqlResult, $template, $errorMessages) {

		//get the names that are being searched
		$fName = $_REQUEST[ 'fName' ];
		$lName = $_REQUEST[ 'lName' ];

		//create the needed row managers
		$personM = new RowManager_PersonManager();
		$accessM = new RowManager_AccessManager();
		$viewerM = new RowManager_ViewerManager();

		//setup the join pair needed
		$join = new JoinPair($personM->getJoinOnFieldX( 'person_id' ), $accessM->getJoinOnFieldX( 'person_id' ));
		
		//create the multi table manager and initialize it
		$MTM = new MultiTableManager();
		$MTM->addRowManager($personM);
		$MTM->addRowManager($accessM, $join);
		
		//if there is a first name being searched - add that as a condition
		if ($fName != "") {
			$MTM->constructSearchCondition('person_fname', ' LIKE ', '%'.$fName.'%', true);
			$personM->constructSearchCondition('person_fname', ' LIKE ', '%'.$fName.'%', true);
		}
		//if there is a last name being searched - add that as a condition
		if ($lName != "") {
			$MTM->constructSearchCondition('person_lname', ' LIKE ', '%'.$lName.'%', true);
			$personM->constructSearchCondition('person_lname', ' LIKE ', '%'.$lName.'%', true);
		}
		
		//jump to a display function to show what was reteived from the database
		$rows = showContents($personM->find(), $personM, $personM->getFields());
		echo '<b>'.$rows.' accounts found in the person table.</b><br><br>';

		//jump to a display function to show what was reteived from the database
		$sqlResult = $MTM->find();
		echo '<b>'.$sqlResult->getRowCount().' connections made between person table and access groups.</b><br>';
		$rows = showContents($sqlResult, $personM, $personM->getFields());
		$sqlResult->setFirst();


		$viewM = new RowManager_ViewerManager();
 		for($i=0; $i<$sqlResult->getRowCount(); $i++) {

			$sqlResult->getNext($personM);
			$f_name[] = $personM->getValueByFieldName('person_fname');
			$l_name[] = $personM->getValueByFieldName('person_lname');
			$person_id[] = $personM->getValueByFieldName('person_id');

			
			$sqlResult->getCurrent($accessM);
			$join = new JoinPair($accessM->getJoinOnFieldX( 'viewer_id' ), $viewerM->getJoinOnFieldX( 'viewer_id' ));

			$MTM = new MultiTableManager();
			$MTM->addRowManager($accessM);
			$MTM->addRowManager($viewerM, $join);
			$MTM->constructSearchCondition('viewer_id', '=', $accessM->getValueByFieldName('viewer_id'), true);
			$sqlResult2 = $MTM->find();

			$sqlResult2->getNext($viewM);
			$viewer_id[] = $viewM->getValueByFieldName('viewer_id');
			$user_id[] = $viewM->getValueByFieldName('viewer_userID');
		}
			
		if ( $sqlResult->getRowCount() < 1 ){
			$errorMessages = 'Failed to join database to get label';
			$template->set ('f_name', null);
		} else {
			$template->set ('f_name', $f_name);
			$template->set ('l_name', $l_name);
			$template->set ('viewer_id', $viewer_id);
			$template->set ('person_id', $person_id);
			$template->set ('user_id', $user_id);
		}
	}

	function showContents($sqlResult, $manager, $fieldList) {
	
 		for($i=0; $i<$sqlResult->getRowCount(); $i++) {

			$sqlResult->getNext($manager);

			for ($j=0; $j<count($fieldList); $j++) {
				echo '"'.$manager->getValueByFieldName($fieldList[$j]).'" ';
			}
			echo '<br>';
		}
	
		return $sqlResult->getRowCount();
	}
	
	function show_Form($template, $errorMessages) {
		
		// Now we create a Template object 
		// NOTE: (optional parameter is to set the path to your template file )
		// ex   $template = new Template( "path/to/template/files/here.php" );
		// if you don't set it, it assumes the template is in the same directory
		// as your script.
		//
		

		// Now we pass/set the values of variables in the Template
		$template->set( 'errorMessages', $errorMessages);
		
		// now we get the HTML of the Template and display that for our page.
		echo $template->fetch( 'VP.tpl' );
	}
?>	