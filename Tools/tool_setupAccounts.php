<?PHP
$pathFile = 'General/gen_Includes.php';
$extension = '';
    
// Attempt to find proper directory from current page to Root ...
$numAttempts = 0;
while ( (!file_exists($extension.$pathFile)) && ( $numAttempts < 5) ) {
    
    $extension = '../'.$extension;
    $numAttempts++; 
}
require ( $extension.$pathFile );


echo '<table>';

$db = new Database_Site();
$db->connectToDB( SITE_DB_NAME, SITE_DB_PATH, SITE_DB_USER, SITE_DB_PWORD);

$sql = "USE ".SITE_DB_NAME;
runSQL( $sql );

// NOTE: this list is in the following format:
//       "user_id=pword,user_id2=pword2,..."
$userIDList='nancy=nancy,mysan=mysan,imay=imay,estee=estee,caleb=caleb,rebecca=rebecca,leehoong=leehoong,yenmei=yenmei,samuel=samuel';

$userData = explode( ',', $userIDList);

for( $indx=0; $indx<count($userData); $indx++) {

list($userID, $userPWord) = explode( '=', $userData[ $indx ] );

$userPWord = md5( $userPWord);


$sql = "INSERT INTO ".Viewer::DB_TABLE_LOGIN." (login_UserID, login_PWord, login_LanguageID, login_RegionID, login_Active) VALUES ('".$userID."','".$userPWord."', 1, 1, 1)";
runSQL( $sql );


}

echo '</table>';



function runSQL( $sql ) {
    global $db;
    
    if ($db->runSQL( $sql ) ) {
        echo '<tr><td><font color="#999999">'.$sql."</font></td></tr>\n";
    } else {
        echo '<tr><td><font color="#FF0000">'.$sql."</font></td></tr>\n";
    }
}

?>