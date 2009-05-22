<?php
require("../General/gen_Includes.php");
require("../modules/site_AccountAdmin/incl_accountadmin.php");


/*
 * Adding a new row to a table
 */
echo 'Adding New Row to Table<br>';

// Create a new ViewerManager object to interact with the Viewer's table
// NOTE: leaving the parameters blank will create an empty class
$viewer = new RowManager_ViewerManager();

// Create a new entry for a test user
$viewer->setUserID( 'testUser' );
$viewer->setPassWord( 'test' );
$viewer->setIsActive( true );

// Now Create a new row in the table based on the current values of this obj
echo 'Primary Key before creating a new entry = '.$viewer->getID()."<br>";
$viewer->createNewEntry();
// Once an entry is created then the object's primary ID is set
echo 'Primary Key after createNewEntry = '.$viewer->getID().'<br>';



/* 
 * Using RowManager to update a row in the table
 */
echo '<br><br>Updating Row in Table<br>';
// Updating An entry in the Table:
// get the ID of the entry we just created
$viewerID = $viewer->getID();

// create a new ViewerManager with the viewerID as the primarykey of the row we
// want to work with.
$newViewer = new RowManager_ViewerManager( $viewerID );
echo 'languageID before update = '.$newViewer->getLanguageID().'<br>';

$newViewer->setLanguageID( 1 );

$newViewer->updateDBTable();

// now reload the object to get the value from the DB
$updatedViewer = new RowManager_ViewerManager( $viewerID );
echo 'languageID after update = '.$updatedViewer->getLanguageID().'<br>';




/*
 * Using a List iterator to step through a selection of rows
 */
// now lookup the MC region Access Group
// first create a list iterator based on that table
$groupManager = new RowManager_AccountGroupManager();
$accountGroups = $groupManager->getListIterator();
$accountGroups->setFirst();
$groupID=-1;
while( $group = $accountGroups->getNext() ) {

    if ($group->getLabel() == "MC" ) {
        echo '---> Found MC account group!<br>';
        $groupID = $group->getID();
    }
}
$viewer->setAccountGroupID( $groupID );
$viewer->updateDBTable();





// After running this script you should see a new entry in the site.accountadmin_viewer table.




/* 
 * Uncomment this for deleting the Row manager Entry
 */
//echo 'viewer entry Deleted!<br>';
//$viewer->deleteEntry();



?>
