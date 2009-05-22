<html>
	<body>
		<table width="100%" border="0" align="center">
			<tr>
				<td>
					<table>
						<tr>
							<td>
								<form action=>
									<select name="agID">
<? 
	for($i=0; $i<count($agLabel); $i++) {
		if ($agID[$i] == $selected) {
			echo'							<option value="'.$agID[$i].'" selected="selected">'.$agLabel[$i].'
';
} else {
			echo'							<option value="'.$agID[$i].'">'.$agLabel[$i].'
';
}

}
?>						
									</select>
							</td>
							<td>
									<input type="submit">
								</form>
							</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td>
					<table width="100%" border="1">
						<tr>
							<th width="14%"> Viewer ID </th>
							<th width="16%"> Account Group </th>
							<th width="24%"> User ID </th>
							<th width="16%"> Language </th>
							<th width="14%"> Active </th>
							<th width="16%"> Last Login </th>
						<tr>
<? 	
	if (isset($sqlResult)) {
		$sqlResult->setFirst();
		$viewerM = new RowManager_ViewerManager();
		for($i=0; $i<$sqlResult->getRowCount(); $i++) {
			$sqlResult->getNext($viewerM);
echo'						<tr>
							<td>'. $viewerM->getValueByFieldName('viewer_id') .'</td>
							<td>'. $viewerM->getRegionID() .'</td>
							<td>'. $viewerM->getUserID() .'</td>
							<td>'. $viewerM->getLanguageID() .'</td>
							<td>'. $viewerM->isActive() .'</td>
							<td>'. $viewerM->getValueByFieldName('viewer_lastLogin') .'</td>
						</tr>
';
		}
	}
?>
					</table>
				</td>
			</tr>
		</table>
	</body>
</html>
