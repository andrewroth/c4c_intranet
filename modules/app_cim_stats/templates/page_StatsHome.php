<?
/*
 * page_StatsHome.php
 *
 * This is a generic template for the page_StatsHome.php page.
 *
 * Required Template Variables:
 *  $pageLabels :   The values of the labels to display on the page.
 *
 */
 
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
<p><span class="heading"><? echo $templateTools->getPageLabel('[Title]'); ?></span></p>
<p><span class="text"><? echo $templateTools->getPageLabel('[Instr]'); ?></span></p>

<? 

/*
   * Display Links
   */
   
   if ( $isAllStaff )
   {
       echo '<span class="bold">'.$templateTools->getPageLabel('[AllStaff]') .'</span><br/>';
        foreach( $linkValues as $key=>$link) {
    
            echo '<span class="text"><a href="'.$link.'">'.$templateTools->getPageLabel($key).'</a></span><br/>';
        }
    }
    
    echo '<br/>';
    
    if ( $isStatsCoordinator || $isAllStaff )
    {
        echo '<span class="bold">'.$templateTools->getPageLabel('[CampusStatsCoordinator]') .'</span><br/>';
        foreach( $coordinatorLinkValues as $key=>$link) {
    
            echo '<span class="text"><a href="'.$link.'">'.$templateTools->getPageLabel($key).'</a></span><br/>';
        }
    }
    
    echo '<br/>';

    if ($isCD )
    {    
        echo '<span class="bold">'.$templateTools->getPageLabel('[CampusDirector]') .'</span><br/>';
        foreach( $cdLinkValues as $key=>$link) {
    
            echo '<span class="text"><a href="'.$link.'">'.$templateTools->getPageLabel($key).'</a></span><br/>';
        }
    }

    echo '<br/>';

    if ( $isRegional )
    {    
        echo '<span class="bold">'.$templateTools->getPageLabel('[RegionalTeam]') .'</span><br/>';
        foreach( $rtLinkValues as $key=>$link) {
    
            echo '<span class="text"><a href="'.$link.'">'.$templateTools->getPageLabel($key).'</a></span><br/>';
        }
    }

    echo '<br/>';

    if ( $isNational )
    {    
        echo '<span class="bold">'.$templateTools->getPageLabel('[NationalTeam]') .'</span><br/>';
        foreach( $ntLinkValues as $key=>$link) {
    
            echo '<span class="text"><a href="'.$link.'">'.$templateTools->getPageLabel($key).'</a></span><br/>';
        }
    }
?>

