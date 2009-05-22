<html>
	<body>
		<table width="100%" border="0" align="center">
			<tr>
				<td>
					<table>
						<tr>
							<form action=>
							<td>
									
<? 
	if (isset( $_REQUEST[ 'fName' ] )) {
		$fName = $_REQUEST[ 'fName' ];
		$lName = $_REQUEST[ 'lName' ];
		echo'							First Name:<input value="'.$fName.'" name="fName">
							Last Name: <input value="'.$lName.'" name="lName">
';
} else {
		echo'							<input name="fName">
							<input name="lName">
';
}
?>						
							</td>
							<td>
									<input type="submit">
							</td>
							</form>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td>
					<table width="100%" border="1">
<?	if (isset($f_name)) { 
echo'						<tr>
							<th width="16%"> First Name </th>
							<th width="16%"> Last Name </th>
							<th width="16%"> Viewer ID </th>
							<th width="16%"> Person ID </th>
							<th width="36%"> User ID </th>
						<tr>
';
		for($i=0; $i<count($viewer_id); $i++) {
echo'						<tr>
							<td width="16%">'. $f_name[$i] .'</td>
							<td width="16%">'. $l_name[$i] .'</td>
							<td width="16%">'. $viewer_id[$i] .'</td>
							<td width="16%">'. $person_id[$i] .'</td>
							<td width="36%">'. $user_id[$i] .'</td>
						</tr>
';
}
} else {
echo'						<tr>
							<td width="100%">No records found</td>
						</td>
';
}
?>
					</table>
				</td>
			</tr>
		</table>
	</body>
</html>
