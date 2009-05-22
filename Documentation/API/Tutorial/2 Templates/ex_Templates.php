<?php
require("../General/gen_Includes.php");
require("../modules/site_AccountAdmin/incl_accountadmin.php");



// Get a list of all the account groups for the site
$accountGroups = new AccountGroupList();
$accountGroups->setFirst();
while( $group = $accountGroups->getNext() ) {
    
    // save the ID's and Labels into two different Arrays
    $idList[] = $group->getID();
    $labelList[] = $group->getLabel();
}



// Now we create a Template object 
// NOTE: (optional parameter is to set the path to your template file )
// ex   $template = new Template( "path/to/template/files/here.php" );
//
$template = new Template( );

// Now we pass/set the values of variables in the Template
// 1st parameter is the name of the variable as it will be called in the template
// 2nd parameter is the current variable that you want to pass in
$template->set( 'listID', $idList);
$template->set( 'listLabels', $labelList );


// now we get the HTML of the Template and display that for our page.
echo $template->fetch( 'ex_Templates.tpl' );

?>
