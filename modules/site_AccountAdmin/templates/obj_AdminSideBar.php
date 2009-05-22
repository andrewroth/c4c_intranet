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
<p><span class="bold"><? echo $templateTools->getPageLabel('[Title]'); ?></span></p>
<?
  /*
   * Display SideBar Links
   */
    foreach( $links as $key=>$link) {
        
        echo '<p class="text"><a href="'.$link.'">'.$templateTools->getPageLabel($key).'</a></p>';
    }
  
?>