<? 

//echo 'Page content =['.$page->content.']';

foreach ($page->styleList->style as $style) {

echo 'style=['.$style.']<br>';

}
foreach ($page->scripts->script as $script) {

echo 'script=['.$script.']<br>';

}
?>
