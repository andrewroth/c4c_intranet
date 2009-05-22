<?PHP

/*
 * Site Database
 *
 * Create the Site Database.
 */
require ('../General/gen_includes.php');


$dbSubscriptions = new Database_Site();
$dbSubscriptions->connectToDB( 'subscriptions', SITE_DB_PATH, SITE_DB_USER, SITE_DB_PWORD);


$db = new Database_Site();
$db->connectToDB( SITE_DB_NAME, SITE_DB_PATH, SITE_DB_USER, SITE_DB_PWORD);

// first clear out existing HTML blocks
$sql = 'DELETE FROM '.SITE_DB_NAME.'.'.HTMLBlock::DB_TABLE_HTMLBLOCK;
$db->runSQL( $sql );

// Now get all the existing Subscriptions ...
$sql = 'SELECT * FROM subscriptions.subscriptions';
$dbSubscriptions->runSQL( $sql );

// for each subscription
while( $row = $dbSubscriptions->retrieveRow() ) {

    // condition data to not break the SQL statement
    $data = $row['subscription_data'];
    $data = str_replace( "'", "''", $data);
    $data = trim( $data);
        
    // Insert into HTMLBlock table
    $sql = 'INSERT INTO '.SITE_DB_NAME.'.'.HTMLBlock::DB_TABLE_HTMLBLOCK." (htmlblock_key, htmlblock_data, language_id) VALUES ( '".$row['subscription_key']."', '".$data."', ".$row['language_id'].')';

echo '[[['.$sql.']]]<br><br><br>';

    $db->runSQL( $sql);


    
    
}
?>