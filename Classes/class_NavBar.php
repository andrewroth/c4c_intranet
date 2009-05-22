<?php

define( 'NAVBAR_PATH', '[[[PATH]]]' );


class  NavBar extends DisplayObject_MySQLDB {
// 
//  DESCRIPTION:
//		This is an object for building the NavBar Data for a given ViewerID.
//
//	CONSTANTS:

//
//	VARIABLES:
	var $ViewerID;
	var $LanguageID;
	var $PathToRoot;
	var $NavBarData;

//
//	CLASS CONSTRUCTOR
//

	//************************************************************************
	function NavBar( $ViewerID, $LanguageID, $PathToRoot='../' ) {
	
		DisplayObject_MySQLDB::DisplayObject_MySQLDB( DB_NAME_NAVBAR, DB_PATH, DB_USER, DB_PWORD  );
	
		$this->ViewerID = $ViewerID;
		$this->LanguageID = $LanguageID;
		$this->PathToRoot = $PathToRoot;
		$this->NavBarData = array( "MainMenu" => "", "SubMenus" => "" );

		
		$this->InitDB();
		$this->InitBar();
		
	}

//
//	CLASS FUNCTIONS:
//

	//************************************************************************
	function TemplateName() {
	
	
	}
	
	
	//************************************************************************
	function InitBar() {
	
		// If Viewer has a Cache Entry then
		$SQL = 'SELECT * FROM login.navbarcache WHERE viewer_id='.$this->ViewerID.' AND language_id='.$this->LanguageID;
		if ( $this->DB->RunSQL( $SQL ) == true ) {
			
			if ( $Row = $this->DB->RetrieveRow() ) {
			
				//Valid Entry Exists so ....
				if ($Row['navbarcache_valid'] == 1) {
					
					$this->NavBarData['MainMenu'] = $Row['navbarcache_mainmenu_cache'];
					$this->NavBarData['SubMenus'] = $Row['navbarcache_submenus_cache'];
				
				} else {
				
					$this->CreateBar();

// NOTE:  I'm not keeping the Cache Valid while testing ...
				
					$SQL = 'UPDATE login.navbarcache SET navbarcache_mainmenu_cache=\''.$this->NavBarData['MainMenu'];
					$SQL .= '\', navbarcache_submenus_cache=\''.$this->NavBarData['SubMenus'];
					$SQL .= '\', navbarcache_valid=1, language_id='.$this->LanguageID.' WHERE viewer_id='.$this->ViewerID.' AND language_id='.$this->LanguageID;
				
					$this->DB->RunSQL( $SQL );
				}
			} else {

				$this->CreateBar();
				$SQL = 'INSERT INTO login.navbarcache ( viewer_id, navbarcache_mainmenu_cache, navbarcache_submenus_cache, navbarcache_valid, language_id) VALUES (';
				$SQL .= $this->ViewerID . ', \'' .$this->NavBarData['MainMenu'].'\', \''.$this->NavBarData['SubMenus'].'\', 1, '.$this->LanguageID.')';
				
				$this->DB->RunSQL( $SQL );	
			}
		} else {
			// Indicate that we couldn't get connected to the NavBar Cache DB.
			echo "NavBar [".$this->DBName."] failed to Get Cache Data.<br>";
		}
	}
	
	
	//************************************************************************
	function CreateBar() {

		$this->Labels = new MultiLingual_Labels( 'AI', 'NavBar', 'NavBar', $this->LanguageID );
	
		// Get List of User's Groups as a Group Clause
		$SQL = 'SELECT * FROM login.logingroups WHERE login_ViewerID='.$this->ViewerID;
		if ( $this->DB->RunSQL( $SQL ) == true ) {
		
			$GroupClause = '';
			while ( $Row = $this->DB->RetrieveRow() ) {
			
				if ( $GroupClause != '' ) {
					$GroupClause .= ' OR grouplist_id='.$Row['grouplist_id'];
				} else {
					$GroupClause = 'grouplist_id='.$Row['grouplist_id'];
				}
			
			}
			
			// make sure "All" Group (Group ID = 0) is included ...
			if ($GroupClause != '') {
				$GroupClause = '('.$GroupClause.' OR grouplist_id=0)';
			} else {
				$GroupClause = 'grouplist_id=0';
			}		
			
			// Now Get List of Menu's 
			$SQL = 'SELECT * FROM login.navbarmenu WHERE '.$GroupClause.' OR viewer_id='.$this->ViewerID;
			$SQL .= ' ORDER BY navbarmenu_order';
			if ( $this->DB->RunSQL( $SQL ) == true ) {
			
				// Begin Main Menu
				$MenuList = "with(milonic=new menuname(\"Main Menu\")){\n";
				$MenuList .= "   style=barStyle;\n";
				$MenuList .= "   alwaysvisible=1;\n";
				$MenuList .= "   orientation=\"horizontal\";\n";
				$MenuList .= "   overfilter=\"\";\n";
				$MenuList .= "   position=\"relative\";\n";
				
				$MenuListCounter = 1;
				
				// Prep a DB Object for working with MenuEntries
				$MenuEntryDB = new Database_MySQL();
				$MenuEntryDB->ConnectToDB('login', DB_PATH, DB_USER, DB_PWORD);
				$MenuEntryList = '';
				
				// For Each Menu Item
				while ( $Row = $this->DB->RetrieveRow() ) {
				
					$CurrentMenuEntries = array();
					
					// Get MenuEntries Related To this MenuItem
					$SQL = 'SELECT * FROM login.navbarentries WHERE navbarmenu_id='.$Row['navbarmenu_id'];
					$SQL .= ' AND ('.$GroupClause.' OR viewer_id='.$this->ViewerID.') ';
					$SQL .= ' ORDER BY navbarentries_order ';
					
					if ( $MenuEntryDB->RunSQL( $SQL ) == true ) {
					
						$TempMenuEntry = "with(milonic=new menuname(\"menu".$MenuListCounter."\")){\n";
						$TempMenuEntry .= "   style=menuStyle;\n";
						$TempMenuEntry .= "   overflow=\"scroll\";\n";
						
						$MenuEntryCounter = 1;
						
						while ( $EntryRow = $MenuEntryDB->RetrieveRow() ) {
						
							if ( array_key_exists( $EntryRow['navbarentries_cmd'], $CurrentMenuEntries) == false ) {
								
								$Temp = $this->Labels->Label( $EntryRow['navbarentries_label'] );
								
								// if link is local to this site then
								if ( $EntryRow['navbarentries_islocal'] == 1 ) {
								
									// add an entry with the site root path appended...
									$TempMenuEntry .= "aI(\"text=".$Temp.";url=".NAVBAR_PATH.$EntryRow['navbarentries_cmd'].";title=".$EntryRow['navbarentries_title'].";\");\n";
								
								} else {
								
									// else add an entry with http:// appended...
									$TempMenuEntry .= "aI(\"text=".$Temp.";url=http://".$EntryRow['navbarentries_cmd'].";title=".$EntryRow['navbarentries_title'].";\");\n";
								}
								
								$MenuEntryCounter++;
								
								$CurrentMenuEntries[ $EntryRow['navbarentries_cmd'] ] = 0;
							}
						}
						$TempMenuEntry .= "}\n\n";
					
					} else {
						echo ('NavBar::CreateBar:Unable to get Sub List of Main MenuList ['.$Row['navbarmenu_id'].'] ['.$SQL.']<br>');
					}
					
					// Add Current Main Menu Entry
					$Temp = $this->Labels->Label( $Row['navbarmenu_label'] );
					$MenuList .= "   aI(\"text=".$Temp.";showmenu=menu".$MenuListCounter."\");\n";
					
					// Save Current Menu Entry List
					$MenuEntryList .= $TempMenuEntry;
					
					$MenuListCounter++;
				}
				
				$MenuList .= "}\n\ndrawMenus();\n";
				
				// Now Save all this data in NavBarData ...
				$this->NavBarData['MainMenu'] = $MenuList;
				$this->NavBarData['SubMenus'] = $MenuEntryList;
			
			} else {
				echo ('NavBar::CreateBar:Unable to get Main MenuList ['.$SQL.']<br>');
			}
		} else {
			echo ('NavBar::CreateBar: Unable to get Viewer\'s List Of Groups.<br>');
		}
	}
	
	
	//************************************************************************
	function ParseDraw( $Data ) {

		//if there is a Marker in the data then
		$Position = strpos( $Data, NAVBAR_PATH);
		if ( $Position !== false ) {
		
			//Pull off the Data before the Marker & Add to Display List
			$this->AddToDisplayList( substr( $Data, 0, $Position) );
			
			//Add Current PATH TO ROOT to DisplayList
			$this->AddToDisplayList( $this->PathToRoot );
			
			//Recursively Call with remaining Data
			$this->ParseDraw( substr( $Data, $Position + strlen( NAVBAR_PATH ) ) );
			
		} else {  // else
		
			//Add all Data to Display List
			$this->AddToDisplayList( $Data );
			
		}// end if
			
	}
	
	
	//************************************************************************
	function DrawDirect() {
	
//		$this->DrawInit();
//		
//		DisplayObject::DrawDirect();
	
		echo "NavBar::DrawDirect() has not been implemented.  It may cause problems with the menu display.";

	}
	
	
	//************************************************************************
	function Draw() {
	
//		$this->DrawInit();
//		
//		DisplayObject::Draw();
	
		echo "NavBar::Draw() has not been implemented.  Instead use DrawMainMenu() and DrawSubMenus().";

	}
	
	
	//************************************************************************
	function DrawMainMenu() {
		
		// Re-initialize Display List before drawing
		$this->DisplayList=array();
		$this->NumDisplayItems  = 0;
		
		$this->ParseDraw( $this->NavBarData['MainMenu'] );
		
		return DisplayObject::Draw();
	
	}
	

	//************************************************************************
	function DrawSubMenus() {
	
		// Re-initialize Display List before drawing
		$this->DisplayList=array();
		$this->NumDisplayItems  = 0;
		
		$this->ParseDraw( $this->NavBarData['SubMenus'] );
		
		return DisplayObject::Draw();
	
	}
	

}






?>