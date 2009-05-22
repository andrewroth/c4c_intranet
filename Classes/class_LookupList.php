<?php

class  LookupList extends DisplayObject_MySQLDB {
// 
//	Written By	:	
//	Date		:	
//	
//  DESCRIPTION:
//      Given an SQL statement and a list of fields, this class will generate an HTML table with the data.
//
//	CONSTANTS:
//
//	VARIABLES:
var $SQL;       // [STRING]  Holds the SQL statement for pulling data from DB
var $fieldList; // [STRING]  List of column names that you want displayed from the returned SQL statement in the order as specified in the list.
var $table_parameters; //[STRING] Defines the parameters of the table in which the data will be displayed.
var $cell_parameters; //[STRING] Defines the parameters of the cell in which the data will be displayed.
var $row_color_on;     // [STRING] The background color of a row when it is "ON"
var $row_color_off;    // [STRING] The backgound color of a row when it is "OFF"

//	CLASS CONSTRUCTOR
//

	//*********************************************************************
	function LookupList($sql, $list, $table_par='width="100%" border="0"', $cell_par='class="smallText"', $color_on=' bgcolor="#CCCCCC" ', $color_off='') {

		//echo "I am at the Lookuplist";
		// Initialize the Parent Constructor
		DisplayObject_MySQLDB::DisplayObject_MySQLDB( 'hrdb', DB_PATH, DB_USER, DB_PWORD  );

        // Receive the conditions of the data we want displayed
        // Define where to retrieve the data
        $this->SQL = $sql;
        $this->fieldList = $list;
        $this->table_parameters = $table_par;
        $this->cell_parameters = $cell_par;
        
        $this->row_color_on = $color_on;
        $this->row_color_off = $color_off;
	
	}

//
//	CLASS FUNCTIONS:
//

	//************************************************************************
	function Template() {
	// 
	// DESCRIPTION
	//	
	//	

	
	}	
	
	
// Draw Data


	//************************************************************************
	function initDisplayData() {
	// 
	// DESCRIPTION
	//	
	//	This function will create the output display information.
	
    // Get Data from DB
    $this->InitDB();        // Initialize the Connection to the DB
    
    // If data retrieved successfully then
    if ( $this->DB->runSQL( $this->SQL ) == true ) {
    
       // Create Table For Output using available classes
            // Get # of fields desired in output table
            $fields_array = explode (',', $this->fieldList);
            $fields_count = count($fields_array); 
            
            // create a table object with # of columns
            $OutputTable = new Table( $fields_count, $this->table_parameters );
            
            // Set initial row color
            $cell_parameter_color = $this->row_color_on; //' bgcolor="#CCCCCC" ';
            
            // for each Row in SQL recordset
            while( $Row = $this->DB->retrieveRow() ) {
                // Add each given field to table 
                for( $indx=0; $indx < $fields_count; $indx++) {
                
                    $OutputTable->addTableCell( $Row[ $fields_array[ $indx ] ], $cell_parameter_color.$this->cell_parameters  );
                }
                
                // Toggle Background Color
                if ($cell_parameter_color == $this->row_color_off) {
                    $cell_parameter_color = $this->row_color_on ; 
                } else {
                    $cell_parameter_color = $this->row_color_off;
                }
            } // next row
            
        // Draw Data to screen
        $this->addToDisplayList( $OutputTable, DISPLAYOBJECT_TYPE_OBJECT );
        
    } else { // else 
    
        //Display error message
        $this->addToDisplayList( 'LookupList::initDisplayData : ERROR running SQL statement ['.$this->SQL.']<br>' );
        
    } // end if
    
    
	}	
	
	
    //************************************************************************
	function draw() {
	// 
	// DESCRIPTION
	//	
	//	Here we override the Parent Draw() function to make sure the display 
	//  data is properly initialized.
	
	   $this->initDisplayData();
	   
	   DisplayObject::draw();

	}	
	
	
    //************************************************************************
	function drawDirect() {
	// 
	// DESCRIPTION
	//	
	//	Here we override the Parent drawDirect() function to make sure the display 
	//  data is properly initialized.
	//  this method is preferred over Draw - shorter time taken to draw table.
	
	//echo "I am at DrawDirect";
	
	   $this->initDisplayData();
	   
	   DisplayObject::drawDirect();

	}	

}

class  LookupList_RegionRole extends LookupList {
// 
//	Written By	:	
//	Date		:	
//	
//  DESCRIPTION:
//		The SQL will be constructed in this class
//		The fieldlist will be passed into in this class
//
//	CONSTANTS:
//
//	VARIABLES:
var $regionlist;       // [STRING]  Holds the region (or list of regions) that is being passed in.
var $rolelist;        //[STRING] Holds the role (or list of roles) that is being passed in.
var $fieldlist;			// [STRING]  Holds the list of fields to be retrieved from the db.
var $sql;				// [STRING]  Holds the sql to be executed.
var $displaytype;				// [STRING] Describes how information will need to be displayed, optional

//	CLASS CONSTRUCTOR
//

	//************************************************************************
	function LookupList_RegionRole($regions,$roles,$type='') {
	
	// so suppose we add an additional parameter: $roles  = 'RIT,ROD,RFD'
	

 	//echo "I am at the LookupList_ByReg";
 
		// Initialize the Parent Constructor
		//LookupList::LookupList('','');
		
        // Receive the region that we want to be displayed
        // Define where to retrieve the data
		
        $this->regionlist = $regions;
        $this->rolelist = $roles;
		$this->$displaytype = $type;
		if ($this->$displaytype == 'role') {
		$this->fieldlist = "region_label,ren_preferedname,ren_surname,ren_mobilephone,ren_workphone,ren_emailother";
		} else {
		$this->fieldlist = "ren_preferedname,ren_surname,region_label,ren_mobilephone,ren_workphone,ren_emailother";
		}
		$sql = $this->ConstructSQL();
		
		// echo $sql."<br />";
		LookupList::LookupList($sql,$this->fieldlist);
	}

//
//	CLASS FUNCTIONS:
//

function ConstructSQL() {

	// 
	// DESCRIPTION
	//	
	//	This function will construct the sql to retrieve the data.
	
       // Create SQL For Output
	   
	   
	   // explode role string into array
	   $roles_array = explode (',', $this->rolelist);
        $roles_count = count($roles_array); 
        
	   // for each element
	   for ($i=0; $i < $roles_count; $i++) {
	   
	   //  construct a new string for the IN clause
	       // if the string is empty
		     if (strlen($role_string) == 0) {
	      // if (isset($role_string) || (strlen($role_string) == 0) ) {
	           // then add role value
	           $role_string = "'".$roles_array[$i]."'";
	       // else ( it already has values in it)
	       } else {
	       
	           // add a comma then the next value
	           $role_string = $role_string.",'".$roles_array[$i]."'";
	           
	       // end if
	       }
	       
	   // next
	   }
	   
	   	   // explode region string into array
	   $regions_array = explode (',', $this->regionlist);
        $region_count = count($regions_array); 
        
	   // for each element
	   for ($j=0; $j < $region_count; $j++) {
	   
	   //  construct a new string for the IN clause
	       // if the string is empty
	       if (strlen($region_string) == 0) {
		  // if (isset($region_string) || (strlen($region_string) == 0) ) {
	           // then add region value
	           $region_string = "'".$regions_array[$j]."'";
	       // else ( it already has values in it)
	       } else {
	       
	           // add a comma then the next value
	           $region_string = $region_string.",'".$regions_array[$j]."'";
	           
	       // end if
	       }
	       
	   // next
	   }
	   
	   $sql = "SELECT DISTINCT a.login_viewerid, f.ren_preferedname, f.ren_surname, b.region_label, f.ren_mobilephone, f.ren_workphone, f.ren_emailother".
	" FROM login.login a, login.regions b, login.logingroups c, login.grouplist d, hrdb.access e, hrdb.ren f, hrdb.family g".
	" WHERE a.login_regionid = b.region_id AND a.login_viewerid = c.login_viewerid AND c.grouplist_id = d.grouplist_id".
	" AND a.login_viewerid = e.viewer_id AND e.ren_id = f.ren_id AND f.family_id = g.family_id AND d.grouplist_label".
	" IN (".$role_string.") AND b.region_label IN (".$region_string.") AND g.family_alumni = 0".
	" ORDER BY b.region_label, f.ren_givenname";
	
		return $sql;
	}	
	
}





?>