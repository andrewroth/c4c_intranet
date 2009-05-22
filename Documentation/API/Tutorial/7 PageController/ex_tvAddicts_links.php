<?php
$pathFile = 'General/gen_Includes.php';
$extension = '';
    
// Attempt to find proper directory from current page to Root ...
$numAttempts = 0;
while ( (!file_exists($extension.$pathFile)) && ( $numAttempts < 5) ) {
    
    $extension = '../'.$extension;
    $numAttempts++; 
}

require ( $extension.$pathFile );

require( 'SeriesManager.php' );
require( 'page_SeriesList.php' );
require( 'page_SeriesEdit.php' );



/*
 * Define the State Variables
 */
// PAGE is the querystring variable used for indicating which page to display
define( 'PAGE', 'page' );
define( 'PAGE_SERIESLIST', 'SL' ); // the page value for the SeriesList page
define( 'PAGE_SERIESEDIT', 'SE' ); // the page value for the SeriesEdit page


// SERIESID is the querystring variable used for indicating which series we are
// to edit.
define( 'SERIES_ID', 'seriesID' );


/*
 * Define An Array to hold all the State Variable Values
 */
$stateVariables = array();



/*
 * Load the Data
 */
 
// Load in the PageController's state variables
$stateVariables[ PAGE ] = PAGE_SERIESLIST;
if ( isset( $_REQUEST[ PAGE ] ) ) {
    $stateVariables[ PAGE ] = $_REQUEST[ PAGE ];
}


// Load in the ID of the row we want to edit. 
// Init to -1 if not given.
$stateVariables[ SERIES_ID ] = '';
if ( isset( $_REQUEST[ 'seriesID' ] ) ) {
    $stateVariables[ SERIES_ID ] = $_REQUEST[ 'seriesID' ];
}


// now descide which PageDisplay object to load
switch( $stateVariables[ PAGE ] ) {
        
    case PAGE_SERIESEDIT:
        // mark the value of the call back 
        $formAction = getCallBack();
        
        // Create our nifty new PageDisplay object
        // The constructor acts like our old loadData() 
        $pageDisplay = new page_SeriesEdit( '', null, $formAction, $stateVariables[ SERIES_ID ] );
        break;
        
    case PAGE_SERIESLIST:
    default:
        // Create our nifty new PageDisplay object
        // The constructor acts like our old loadData() 
        $pageDisplay = new page_SeriesList( '', null, '');
        
        // our script is now responsible to know about the links of the 
        // application. So it creates an array of links for the template
        // to use.
        $newValues = $stateVariables;
        $newValues[ PAGE ] = PAGE_SERIESEDIT;
        $links[ 'edit' ] = getCallBack( $newValues, SERIES_ID );
        $pageDisplay->setLinks( $links );
        break;
}


// be sure to load the form values if a form was submitted
if ( isset( $_REQUEST['submit']) ) {
    $pageDisplay->loadFromForm();
}




/*
 * Process the Data
 */

// only need to processData() if this was a form Submission
if ( isset( $_REQUEST['submit']) ) {

    // if the form data was valid
    if ( $pageDisplay->isDataValid() ) {
    
        // then process the data
        $pageDisplay->processData();
    }
}




/*
 * now display the HTML
 */
echo $pageDisplay->getHTML();





//************************************************************************
/**
 * function getCallBack
 * <pre>
 * This routine parses through all the given stateVariables and produces
 * a link with these values on the querystring.
 * </pre>
 * @param $currentValues [ARRAY](optional) array of stateVariable info
 * @param $endingFieldAssignment [STRING](optional) Name of field to have
 * as ending field assignment.
 * @return [STRING]
 */
function getCallBack( $currentValues=null, $endingFieldAssignment='' ) {
    global $stateVariables;
    
    if (is_null( $currentValues ) ) {
        $currentValues = $stateVariables;
    }

    // compile every stateVariable that has a value set 
    $queryString = '';
    foreach( $currentValues as $key=>$value) {
    
        // don't include paramters used for endingFieldAssignment
        if ( ($value != '' ) && ($endingFieldAssignment != $key)) {
        
            // add it to the QueryString
            if ($queryString != '' ) {
                $queryString .= '&';
            }
            $queryString.= $key.'='.$value;
        }
    }
    
    // Now piece together the callback string
    $callBack = 'ex_tvAddicts_links.php';
    if ($queryString != '' ) {
        $callBack .= '?'.$queryString;
    }
    
    // if an ending Field assignment is requested then
    if ($endingFieldAssignment != '' ) {
    
        // figure out if we need to add an additional parameter marker or
        // querystring marker
        if ( $queryString != '' ) {
            $callBack .= '&';
        } else {
            $callBack .= '?';
        }
        
        // add requested ending field assignment
        $callBack.=$endingFieldAssignment.'=';
    }
    
    // return the Call Back Link
    return $callBack;

}

?>
