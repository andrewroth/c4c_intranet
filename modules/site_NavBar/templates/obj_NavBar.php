<a href="http://www.milonic.com/"></a>
<?php
//echo 'pathToRoot=['.$pathToRoot.']<br>';
$menuList = '';

$menuList = parseMenus( $arrayGroup, "Main Menu", $pathToRoot );

echo $menuList;



// Parse Menu Item (
function parseMenus( $itemArray, $menuName, $pathToRoot ) {

    $subMenu = '';
    
    if ($menuName == 'Main Menu') {
    
        $menu = '<script>with(milonic=new menuname("'.$menuName.'")){
   style=barStyle;
   alwaysvisible=1;
   orientation="horizontal";
   overfilter="";
   position="relative";';
    
    } else {
    
        $menu = '<script>
with(milonic=new menuname("'.$menuName.'")){
   style=menuStyle;
   overflow="scroll";';
    }
    
    // foreach item
    foreach( $itemArray as $key=>$item) {
    
        // if isGroup() then
        if ( $item->isGroup() ) {
        
            // Add mainMenu Entry()
            $subMenuName = str_replace(' ', '', $item->getText()).'_menu';
            $text = $item->getText();
            $menu .= '   aI("text='    .$text.';showmenu='.$subMenuName.'");';
            
            // get list of Entries
            $entries = $item->getItems();
            
            // create SubMenu( Entries, "SubMenuName")
            $subMenu .= parseMenus( $entries, $subMenuName, $pathToRoot );
            
        } else {
        // else
        
            // Add main Menu Entry as link()
            $text = $item->getText();
            $url = $pathToRoot.$item->getURL();
            $title = $item->getTitle();
            $menu .= '  aI("text='    .$text.';url='.$url.';title='.$title.';");';
            
        }// end if
        
    } // next
    
    
    if ($menuName == 'Main Menu') {
    
        $menu .= '}

drawMenus();
</script>';
        
    } else {
    
        $menu .= '}

</script>';
    }
    
    return $subMenu . $menu;
}

?>