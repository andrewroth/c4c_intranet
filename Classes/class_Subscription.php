<?php


class  Subscription extends DisplayObject_MySQLDB {
// 
//  DESCRIPTION:
//		The Subscription class handles the retrieval and display of a named 
//		subscription.
//
//	CONSTANTS:

//
//	VARIABLES:
	var $Key;		//  The Unique Subscription Label/Key
	var $LanguageID;
	var $Data;
	
//
//	CLASS CONSTRUCTOR
//

	//************************************************************************
	function Subscription( $Key='<null>', $LanguageID=1, $DBName='subscriptions', $DBPath=DB_PATH, $DBUserID=DB_USER, $DBPWord=DB_PWORD) {
	
		DisplayObject_MySQLDB::DisplayObject_MySQLDB($DBName, $DBPath, $DBUserID, $DBPWord);
		
		$this->Key = $Key;
		$this->LanguageID = $LanguageID;
		$this->Data = '';
		
		$this->InitDB();
		$this->LoadData();
	
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
		
		if ($this->Key != '<null>') {
		
			//  Retrieve Subscription
			$SQL = "SELECT * FROM subscriptions WHERE ((subscriptions.subscription_key='".$this->Key."') AND (subscriptions.language_id=".$this->LanguageID."))";
//			$SQL = "SELECT * FROM subscriptions WHERE subscriptions.subscription_key='".$this->Key."'";
			if ( $this->DB->RunSQL( $SQL ) == TRUE ) {
			
				$Row = $this->DB->RetrieveRow();
				
				if ( $Row['subscription_title'] != '' ) {	// If we retrieved a valid response ...
	
					$this->Data = $Row[ 'subscription_data' ];
								
				} else {
//echo "Subscription defaulting to ENGLISH<br>";			
						//  Try to get default Subscription entry (English)
					$SQL = "SELECT * FROM subscriptions WHERE ((subscriptions.subscription_key='".$this->Key."') AND (subscriptions.language_id=1))";
					if ( $this->DB->RunSQL( $SQL ) == TRUE ) {
					
						$Row = $this->DB->RetrieveRow();
						$this->Data = $Row[ 'subscription_data' ];
								
					} else {
						echo "Subscription [$this->Key] failed to get DEFAULT ENGLISH version.<br>";
					}
				}		
			} else {
			
				echo "Subscription [$this->Key] failed to initialize subscription!<br>";
			}
		}
	}
	
	
	
	//************************************************************************
	function DrawDirect() {
	
		$this->AddToDisplayList( $this->Data );
		
		DisplayObject::DrawDirect();
	}
	
	
	//************************************************************************
	function Draw() {
	
		$this->AddToDisplayList( $this->Data );
		
		return DisplayObject::Draw();
	}

}






?>