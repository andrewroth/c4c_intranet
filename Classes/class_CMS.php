<?php


class  CMS extends DisplayObject_MySQLDB {
// 
//  DESCRIPTION:
//		This is a Content Management System object.  It will produce the page for 
//		a given CMS ID.  These CMS ID's reside in a DB table and describe the 
//		layout and content blocks included in a CMS page.
//
//	CONSTANTS:

//
//	VARIABLES:
	var $ID;
	var $LanguageID;
	var $Layout;
	var $Tags;
	var $TagTypes;
	var $TagIDs;
	var $TagData;

//
//	CLASS CONSTRUCTOR
//

	//************************************************************************
	function CMS( $PageID='', $LanguageID=1, $DBName='cms', $DBPath=DB_PATH, $DBUserID=DB_USER, $DBPWord=DB_PWORD ) {
	
		DisplayObject_MySQLDB::DisplayObject_MySQLDB($DBName, $DBPath, $DBUserID, $DBPWord);		//  Call the Parent Constructor.
		
		$this->ID			= $PageID;
		$this->LanguageID	= $LanguageID;
		$this->Layout 		= '';
		$this->Tags			= array();
		$this->TagTypes		= array();
		$this->TagIDs		= array();
		$this->TagData		= array();
		
		$this->InitDB();
		$this->LoadData();
		$this->CompileTagData();
	}

//
//	CLASS FUNCTIONS:
//

	//************************************************************************
	function TemplateName() {
	
	
	}
	
	
	
	//************************************************************************
	function LoadData() {
	
		//  Make sure DB is initialized before proceeding
		$this->InitDB();	
		
		//  Retrieve CMS Page ID & Layout
		$SQL = "SELECT * FROM pages WHERE pages.page_label='".$this->ID."'";
		if ( $this->DB->RunSQL( $SQL ) == TRUE ) {
		
			$Row = $this->DB->RetrieveRow();
			
			$this->Layout = $Row[ 'page_layout' ];
			
			//  Now Retrieve Associated TAGS
			$SQL = "SELECT * FROM tags WHERE tags.page_id=".$Row['page_id'];
			if ( $this->DB->RunSQL( $SQL ) == TRUE ) {
			
				while( $Row = $this->DB->RetrieveRow() ) {
				
					$this->Tags[] = $Row['tag_name'];
					$this->TagTypes[] = $Row['tag_type'];
					$this->TagIDs[] = $Row['tag_dataid'];
				}
			
			} else {
				
				echo "CMS [$this->ID] failed to retrieve Tags<br>";
			}			
			
		
		} else {
		
			echo "CMS [$this->ID] failed to initialize page!<br>";
		}
	}
	
	
	
	//************************************************************************
	function CompileTagData() {
	
		for ($Indx=0; $Indx<count( $this->Tags ); $Indx++) {
		
			switch( $this->TagTypes[ $Indx ] ) {
			
				case 'NB':
					
				case 'PL':
//  Replace this with proper News Blurbs and Poll Objects when ready...
$this->TagData[ $this->Tags[$Indx] ] = new DisplayObject( $this->TagTypes[$Indx]." :: ".$this->TagIDs[$Indx] );							
							break;
				case 'Sub':
							
							$TempSubscription = new Subscription($this->TagIDs[$Indx],  $this->LanguageID );
							$this->TagData[ $this->Tags[$Indx] ] = $TempSubscription;
							//$this->TagData[ $this->Tags[$Indx] ] = $this->TagTypes[$Indx]." :: ".$this->TagIDs[$Indx];
							break;
							
				case 'Label':
							$Temp_Labels = new MultiLingual_Labels( 'AI', 'cms', $this->ID, $this->LanguageID);
							$Temp = new DisplayObject( $Temp_Labels->Label( $this->TagIDs[$Indx] ) );
							$this->TagData[ $this->Tags[$Indx] ] = $Temp;
							break;
			}
		}
	}
	
	
	
	//************************************************************************
	function DrawInit( $Data ) {
	
		$Pos = strpos( $Data, "[[[" );
		
		if ( $Pos !== FALSE ) {
		
				//  Get all Data Before a Tag Marker & Add to Display List
			$PreData = substr( $Data, 0, $Pos);
			$this->AddToDisplayList( $PreData );
			
				//  Get Tag Marker Name
			$EndPos = strpos( $Data, "]]]");
			$TagID = substr( $Data, $Pos + 3, $EndPos - $Pos - 3 );
			
				//  Add Associated TAGDATA to Display List (NOTE: IT SHOULD BE A DISPLAY OBJECT)
			$this->AddToDisplayList( $this->TagData[ $TagID ], DISPLAYOBJECT_TYPE_OBJECT );
			
				//  Get Rest of String and resend it to DrawInit()
			$Rest = substr( $Data, $EndPos + 3 );
			$this->DrawInit( $Rest ); 


		} else {
		
				//  No more tag markers so just add Data to Display List
			$this->AddToDisplayList( $Data );
		}
	}
	
	
	
	//************************************************************************
	function DrawDirect() {
	
		$this->DrawInit( $this->Layout );
		
		DisplayObject::DrawDirect();
	
	}
	
	
	//************************************************************************
	function Draw() {
	
		$this->DrawInit( $this->Layout );
		
		return DisplayObject::Draw();
	
	}
}






?>