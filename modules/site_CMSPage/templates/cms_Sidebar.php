<?php


$pageZone = array();

foreach( $CMSPage->zone as $zone) {

    $zoneContent = '<table width="100%" height="100%" border="0" cellpadding="6" cellspacing="6">';
    foreach( $zone->app as $app) {
    
        $zoneContent .=  '<tr><td>'.$app->content.'</td></tr>';
    }
    $zoneContent .= '</table>';
    
    $key = (string) $zone['name'];      // $zone['name'] doesn't seem to act as 
                                        // a string.  So I cast it here.
    $pageZone[ $key ] = $zoneContent;
    
}

echo $pageZone[ $desiredZone ];
?>