<?php
$pathFile = 'General/gen_Includes.php';
$extension = '';
   
// Attempt to find proper directory from current page to Root ...
while ( !file_exists($extension.$pathFile) ) {
    $extension = '../'.$extension;
}
require ( $extension.$pathFile );

$template = new Template( );
$agID = -1;
$errorMessages = array();
$selected = -1;
$sqlResult = new ReadOnlyResultSet(null);

if (isset( $_REQUEST[ 'agID' ] ) ) {
	$errorMessages = process_Form($sqlResult, $template, $agID, $errorMessages);
	$selected = $_REQUEST[ 'agID' ];
	$errorMessages = get_AG($template, $errorMessages);
	show_Form($selected, $sqlResult, $template, $errorMessages);

} else {
	$errorMessages = get_AG($template, $errorMessages);
	show_Form($selected, null, $template, $errorMessages);

}	

	function process_Form($sqlResult, $template, $agID, $errorMessages) {
	 
		$agID = $_REQUEST[ 'agID' ];
		$viewerM = new RowManager_ViewerManager();
		$viewerAccessGroupM = new RowManager_ViewerAccessGroupManager();
		$join = new JoinPair($viewerM->getJoinOnFieldX( 'viewer_id' ), $viewerAccessGroupM->getJoinOnFieldX( 'viewer_id' ));
		
		$MTM = new MultiTableManager();
		$MTM->addRowManager($viewerAccessGroupM);
		$MTM->addRowManager($viewerM, $join);
		$MTM->constructSearchCondition('accessgroup_id', '=', $agID, true);
		$MTM->addSortField('viewer_userID');
		$sqlResult = $MTM->find();

		if ( !isset( $sqlResult ) ){
			$errorMessages = 'Failed to join database to get label';
			$template->set ('sqlResult', null);
		} else {
			$template->set ('sqlResult', $sqlResult);
		}
	}

	function get_AG($template, $errorMessages) {

		$accessGroupM = new RowManager_AccessGroupManager();
		$multilingualLabelL = new RowManager_MultilingualLabelManager();
		$join = new JoinPair($multilingualLabelL->getJoinOnFieldX( 'label_key' ), $accessGroupM->getJoinOnFieldX( 'accessgroup_key' ));
		
		$MTM = new MultiTableManager();
		$MTM->addRowManager($multilingualLabelL);
		$MTM->addRowManager($accessGroupM, $join);
		$MTM->constructSearchCondition('language_id', '=', '1', true);
		$result = $MTM->find();
		
		if ( !isset( $result ) ){
			$errorMessages = 'Failed to join database to get label';
		} else {
			$result->setFirst();
			$count=0;
			while ($resultMLM = $result->getNext($multilingualLabelL)) {
				$resultAGM = $result->getCurrent($accessGroupM);
				$agLabel[] = $resultMLM->getLabel();
				$agID[] = $resultAGM->getID();
			}
			
			$template->set ('agLabel', $agLabel);
			$template->set ('agID', $agID);
			
		}	
		
		return $errorMessages;		
	}

	function show_Form($selected, $sqlResult, $template, $errorMessages) {
		
		// Now we create a Template object 
		// NOTE: (optional parameter is to set the path to your template file )
		// ex   $template = new Template( "path/to/template/files/here.php" );
		// if you don't set it, it assumes the template is in the same directory
		// as your script.
		//
		

		// Now we pass/set the values of variables in the Template
		$template->set( 'errorMessages', $errorMessages);
		$template->set ('selected', $selected);
		
		// now we get the HTML of the Template and display that for our page.
		echo $template->fetch( 'ViewerAccessGroup.tpl' );
	}
?>	