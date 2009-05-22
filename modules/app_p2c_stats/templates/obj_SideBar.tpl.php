<?

// First load the common Template Tools object
// This object handles the common display of our form items and
// text formmatting tools.
$fileName = 'objects/TemplateTools.php';
$path = Page::findPathExtension( $fileName );
require_once( $path.$fileName);

$templateTools = new TemplateTools();


// load the page labels
$templateTools->loadPageLabels( $pageLabels );

?>
<p><span class="bold"><? echo $templateTools->getPageLabel('[Heading]'); ?></span></p>

<?
if (!isset($regCompleted))
{
	echo '<p><span class="notice">'.$templateTools->getPageLabel('[Notice]').'</span></p>';
}

  /*
   * Display SideBar Links
   */
    foreach( $links as $key=>$link) {

        echo '<p class="text"><a href="'.$link.'">'.$templateTools->getPageLabel($key).'</a></p>';
    }

//   // only display this group if there is actually links
//   if ( count( $campusLevelLinks ) > 0 )
//   {
//      echo '<br/>';
//      echo '<p><span class="bold">'.$templateTools->getPageLabel('[CampusLevelLinks]').'</span></p>';

//   /*
//    * Display SideBar Links
//    */
//     foreach( $campusLevelLinks as $key=>$link) {

//         echo '<p class="text"><a href="'.$link.'">'.$templateTools->getPageLabel($key).'</a></p>';
//     }

//   }

//    // only display this group if there is actually links
//   if ( count( $adminLinks ) > 0 )
//   {
//      echo '<br/>';
//      echo '<p><span class="bold">'.$templateTools->getPageLabel('[AdminLinks]').'</span></p>';

//   /*
//    * Display SideBar Links
//    */
//     foreach( $adminLinks as $key=>$link) {

//         echo '<p class="text"><a href="'.$link.'">'.$templateTools->getPageLabel($key).'</a></p>';
//     }
//   }

?>