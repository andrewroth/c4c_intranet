<?php
/**
 * @package AIobjects	
 */
/**
 * class SiteObject
 * discussion <pre>
 * Written By:	Johnny Hausman
 * Date:    17 Aug '04
 * 
 * This is a generic Site Object for all the objects in the Web Site.  It provides
 * a basic set of debugging functionality.
 *
 * </pre>
 */
class SiteObject {
// 		
//
//	CONSTANTS:
 	/** const   tag_section_all */
    const   tag_section_all = 'ALL';
//
//	VARIABLES:
		/** @var [ARRAY] An array of Sections, indicating wether or not debugging is turned on for that section. */
		protected $debugSections;
		
    
//
//	CLASS CONSTRUCTOR
//

	//************************************************************************
	/**
	 * This is the class constructor for SiteObject class
	 */
    function __construct() {
	
		$this->debugSections = array( SiteObject::tag_section_all => false );
		
	}
	
	

	//CLASS FUNCTIONS:
	//************************************************************************
	/**
	 * function classFunction
	 * <pre>
	 * [classFunction Description]
	 * </pre>
	 * <pre><code>
	 * [Put PseudoCode Here]
	 * </code></pre>
	 * @param $param1 [$param1 type][optional description of $param1]
	 * @param $param2 [$param2 type][optional description of $param2]
	 * @return [returnValue, can be void]
	 */
	 function classFunction($param1, $param2) {
        // CODE
    }

	
	
	
	//************************************************************************
	/** 
	 * function debug
	 
	 * Prints debugging info if the provided section is enabled.
	
	 * @param $debugString [STRING] The debuggin output.  example:  $debugString=  __FILE__ . ' ( ' . __LINE__ . ' )::' . __METHOD__ . '   Error Message<br>'; 
	 * @param $sectionKey [STRING] The section key this debugging string is for.
	 
	*/
	function debug( $debugString, $sectionKey=SiteObject::tag_section_all ) {
	
	   if ( $this->debugSections[ $sectionKey ] == true ) {

	       echo $debugString;
	   }
	
	}
	
	
	
	//************************************************************************
	/** 
	 * function debugDumpArray
	 
	 * Displays the information in an array.
	
	 * @param $array [ARRAY] The array of the data you want to view.
	 * @param $name  [STRING] The "Name" of the array (for display purposes).
	
	*/
	function debugDumpArray( $array, $name='', $sectionKey=SiteObject::tag_section_all ) {
	
	   if ( $this->debugSections[ $sectionKey ] == true ) {
	   
            // Start new output buffer
            ob_start();                    
//$array = array( 'one', 'two', 'three' );
            var_export( $array );
            
            // Get the contents of the buffer
            $contents = ob_get_contents(); 
            
            // close and discard buffer
            ob_end_clean();
            
            // replace line feeds with HTML <BR>
            $rows = explode( "\n", $contents);
            
            $param = ' valign="top" width="5" ';
            $flip = true;

            $output = $name."[]=\n<table>\n";
            for ($indx=0; $indx<count($rows); $indx++) {
            
                // if row is array row
                if ( substr(trim($rows[$indx]), 0, 5) == 'array') {
                
                    // output array open row
                    $output .= "<tr>\n   <td $param  >".$rows[ $indx]."</td> <td $param > <table>\n <tr><td>&nbsp;</td><td>&nbsp;</td></tr>";
                
                // if row is array closed row
                } elseif (substr(trim( $rows[$indx]), 0, 1) == ")" ) {
                
                    // output array close row
                    $output .= "</table> </td> </tr>\n   <tr>\n   <td $param >".$rows[$indx]."</td> <td $param > &nbsp; </td> \n</tr>\n";
                    
                } else {
                // otherwise 

                    // ouput standard row
                    $output .= "<tr>\n   <td $param >".$rows[ $indx ]."</td> <td $param > &nbsp; </td> \n</tr>\n";
                }
                
                
            }
            $output .= "</table>";
            
//            $contents = str_replace( "\n", "<br>\n", $contents);
//            $contents = str_replace( " ", "&nbsp;", $contents);
            
            // display to browser
            echo $output;
        }
	}
	
	
	
	//************************************************************************
	/** 
	 * function enableSection
	 
	 * Enables a given section of Debuging Info.
	
	 * @param $sectionKey [STRING] The section key to enable. Default = 'ALL'.
	
	*/
	function debugEnable( $sectionKey=SiteObject::tag_section_all ) {
	
	   $this->debugSections[ $sectionKey ] = true;	
	}
	
	
	
	//************************************************************************
	/** 
	 * function disableSection
	 
	 * Disables a given section of Debuging Info.
	
	 * @param $sectionKey [STRING] The section key to disable. Default = 'ALL'.
	
	*/
	function debugDisable( $sectionKey=SiteObject::tag_section_all ) {
	
	   $this->debugSections[ $sectionKey ] = false;	
	}
	

}

?>