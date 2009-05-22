<?php


class  EazyForm extends DisplayObject {
// 
//  DESCRIPTION:
//		This is a Macro Class designed to simplify the creation & processing of forms on a Web Page.
// 		It handles the internal Displaying of the form, the loading of data from the form, routines to 
//		check the validity of the data, etc...
//
//		It is the Next Evolution of the EasyAdmin Class...
//
//	CONSTANTS:

//
//	VARIABLES:
	var $form_callback;			// The Callback URL for this Form
	var $form_labels;			// The List of Multi Lingual Labels to display for this form
	var $viewer_id;
	var $viewer_languageID;			// The Language ID of the Viewer
	var $form_title;			// The Title of this Form....
	var $form_name;				// [STRING]  The Name of the Form.  Unique ID. <form name=$form_name > ...
								// $form_name also defines the MultiLingual Label "Page" for the Labels
		
	var $form_hiddendata;		// [DISPLAY OBJECT] Contains the HiddenData in this form.
	
	var $form_buttonlist;		// [STRING] A list of buttons to display on the form.
	var $form_button;			// [ARRAY] The $form_buttonlist in Array format.

						
	var $form_layout;			// [STRING] The HTML Layout of this Form.  This form will have several TAGS to
								// 		define where data should be placed.
								//		[[[TITLE]]]		= Tag to place the Form Title
								//		[[[DESCRIPTION]]]	= Tag to place the Form Description.
								//		[[[FORM]]]		= Tag to place the actual Form Elements
								
	
	var $form_layout_tagopen;	// [STRING]	The OPENING string of an embedded TAG: ex '[[['
	var $form_layout_tagopen_length;	// [INT] The length of the OPEN TAG: ex 3
	var $form_layout_tagclose;	// [STRING] The CLOSING string of an embedded TAG: ex ']]]'
	var $form_layout_tagclose_length;	// [INT] The length of the CLOSE TAG: ex 3
	
	var $form_isEnabled;		// [BOOL] Flag indicating if the Form should be displayed editabled or not.		
	
	var $form_isUpload;			// [BOOL] Flag indicating if this form uploads any files.
	
	var $values;				// Internal Array of values used by this form.  
	
	var $item_list;				// [STRING] Comma Seperated List of table columns used in this Form.
								//     These table column names provide the data to key for :
								//		labels, values[ column_name ], etc...
								
	var $item_item;				// [ARRAY]  The $item_list in Array format.
	var $item_typelist;			// [STRING] Comma Seperated List of table column item_type.  Each entry 
								//	correspondes to the $item_list entry.  The EntryType determines 
								//  which form element is displayed, and how it is read in from the Form.
								
	var $item_type;					// [ARRAY] The $item_typelist in Array format.
	
	var $item_invalidlist;		// [STRING] Comma Seperated list of INVALID data.
								//		To specify that a null string '' is invalid, just leave empty
								//		To specify that there is NO INVALID data, put <skip> ...
								//		ex: 1,,,<skip>,
								//			item_item[0] cannot have a 1 as it's value
								//			item_item[1,2,4] cannot be empty strings
								//			item_item[3] has no INVALID value....
	var $item_invalid;			// [ARRAY] The $item_invalidlist in Array format.
	
	// STYLES:					These styles define how each Form element will look on screen.  They contain
	//							HTML with embedded [[[TAGS]]] for the Labe, FormItem name, Data, Example, Error...
	var $style_T;				// [STRING] HTML style for the Textbox Type.
	var $style_M;				// [STRING] HTML style for the Memobox Type.
	var $style_CB;				// [STRING] HTML style for the CheckBox Type.
	var $style_L;				// [STRING] HTML style for the Label Type.
	
	var $OutPutMessages;		// [STRING] String of any Output Messages to display to the user.

//
//	CLASS CONSTRUCTOR
//

	//************************************************************************
	function EazyForm( $CallBack, $ViewerID, $LanguageID, $LabelSeries='AdminGen', $Layout='[[[FORM]]]' ) {
		
		DisplayObject::DisplayObject();		//  Call the Parent Constructor.
		
		$this->form_callback = $CallBack;
		
		$this->viewer_id = $ViewerID;
		$this->viewer_languageID = $LanguageID;
		
		$this->form_labels = new MultiLingual_Labels( 'AI', $LabelSeries, $this->form_name, $LanguageID );
	
		$this->form_title = $this->form_labels->Label('[form_title]');
		
		$this->form_hiddendata = new DisplayObject();
		
		$this->form_layout = $Layout;
		$this->form_layout_tagopen = '[[[';
		$this->form_layout_tagopen_length = strlen( $this->form_layout_tagopen );
		
		$this->form_layout_tagclose = ']]]';
		$this->form_layout_tagclose_length = strlen( $this->form_layout_tagclose );
		
		$this->form_isEnabled = true;
		$this->form_isUpload = false;
		
		$this->values = array();

		$this->form_button = explode( ',', $this->form_buttonlist );
		$this->item_item = explode(',', $this->item_list );
		$this->item_type = explode(',', $this->item_typelist );
		$this->item_invalid = explode( ',', $this->item_invalidlist);
		
		
		$BGColor = ' bgcolor="#EEEEEE" ';
		
		$this->style_T = '<tr> 
			  <td class="text" valign="top" bgcolor="#EEEEEE">[[[LABEL]]]</td>
			  <td><input name="[[[FORMITEMNAME]]]" type="text" value="[[[FORMITEMVALUE]]]" [[[ENABLE]]] >
			  <div class="error">[[[ERRORMSG]]]</div>
			  <div class="example">[[[EXAMPLE]]]</div></td>
			</tr>';
		
		$this->style_M = '<tr> 
			  <td class="text" valign="top" bgcolor="#EEEEEE">[[[LABEL]]]</td>
			  <td><textarea name="[[[FORMITEMNAME]]]" rows="5" id="[[[FORMITEMNAME]]]" [[[ENABLE]]] >[[[FORMITEMVALUE]]]</textarea>
			  <div class="error">[[[ERRORMSG]]]</div>
			  <div class="example">[[[EXAMPLE]]]</div></td>
			</tr>';
		
		$this->style_CB = '<tr> 
			  <td class="text" valign="top" bgcolor="#EEEEEE">[[[LABEL]]]</td>
			  <td><input name="[[[FORMITEMNAME]]]" type="checkbox" value="1" [[[FORMITEMVALUE]]] [[[ENABLE]]] ></td>
			</tr>';
		
		
		$this->style_L = '<tr> 
			  <td class="text" valign="top" colspan="2" bgcolor="#EEEEEE">[[[LABEL]]]</td>
			</tr>';
		
		
		$this->OutPutMessages = '';
		
		// Set Values to a default state.
		$this->initValues();
		
	}


//
//	CLASS FUNCTIONS:
//



	
	//************************************************************************
	function initValues() {
	//
	//	This function sets all the expected values to a default/ uninitialized state.
	//
	
		for( $Indx=0; $Indx<count($this->item_item) ; $Indx++) {

			$this->values[ $this->item_item[ $Indx ] ] = '';
		}
	
	}
	
	

	//************************************************************************
	function LoadFromForm() {
	
		for( $Indx=0; $Indx<count($this->item_item) ; $Indx++) {
		
			if (isset( $_REQUEST[ $this->item_item[ $Indx ] ] ) == true ) {
			
				$this->values[ $this->item_item[ $Indx ] ] =  $_REQUEST[ $this->item_item[ $Indx ] ] ;
				
			} else {
			
				$this->values[ $this->item_item[ $Indx ] ] = '';
			}
		}
	
	}
	
	
	
	//************************************************************************
	function checkValidData( $Key, $InvalidValue, $IsValidFlag) {
	//
	//	DESCRIPTION:
	//		This is a simple data validation function to verify the data in a given
	//		value.
	//
		$ReturnValue = $IsValidFlag;
		
		if ( $this->values[ $Key ] == $InvalidValue ) {
		
			$this->ErrorMessages[ $Key ] = $this->form_labels->Label('[Error_'.$Key.']');
			$ReturnValue = false;
		}
		
		return $ReturnValue;
	
	}
	
	
	//************************************************************************
	function isDataValid() {
	
		$isValid = true;
		
		// For each form item ...
		for ( $indx=0; $indx < count( $this->item_item); $indx++) {
		
			// if there exists an INVALID case for this item ...
			if ( $this->item_invalid[$indx] != '<skip>' ) {
				
				// Check it's validity ...
				$isValid = $this->checkValidData( $this->item_item[ $indx ], $this->item_invalid[ $indx ], $isValid);
			}
		}
		
		return $isValid;
	}
	
	
	
	//************************************************************************
	function returnDisplayRow( $DataType, $EntryData ) {
	//
	//  This function takes the given item and prepares the form output based upon
	//  the provided templates.
	//
	
		$Return = '';
		
		// Collect the Common Values used by the Templates ...
		$values = array();
		$values[ '[[[LABEL]]]' ] = $this->form_labels->Label('['.$EntryData.']');
		$values[ '[[[FORMITEMNAME]]]' ] = $EntryData;
		$values[ '[[[FORMITEMVALUE]]]' ] = $this->values[ $EntryData ];
		
		if ( isset( $this->ErrorMessages[ $EntryData ] ) == true ) {
			$values[ '[[[ERRORMSG]]]' ] = $this->form_labels->Label($this->ErrorMessages[ $EntryData ]);
		} else {
			$values[ '[[[ERRORMSG]]]' ] = '';
		}
		
		$values[ '[[[EXAMPLE]]]' ] = $this->form_labels->Label('[Ex'.$EntryData.']');
		
		if ( $this->form_isEnabled == true ) {
			$values[ '[[[ENABLE]]]' ] = '';
		} else {
			$values[ '[[[ENABLE]]]' ] = 'DISABLED';	
		}
		
		// Get the Data Type of this Object ... 
		//  NOTE:  it is possible that the Type is 2 parts : ex TYPE:SUBTYPE 
		$Data = explode( ':', $DataType);
		
		
		// Based on the Type, get the proper style template ...
		switch ( $Data[0] ) {
		
			case 'T':
				
				$currentTemplate = $this->style_T;
				break;
				
				
			case 'M':
				
				$currentTemplate = $this->style_M;
				break;
				
				
			case 'CB':
				
				$currentTemplate = $this->style_CB;
				
				// For a checkbox, if a value is present, we want it to display as checked.
				// Otherwise it should be unchecked.
				if ($this->values[ $EntryData ] != '') {
					$values[ '[[[FORMITEMVALUE]]]' ] = ' checked ';
				} else {
					$values[ '[[[FORMITEMVALUE]]]' ] = ' ';
				}
				break;
				
				
			case 'L':
				
				$currentTemplate = $this->style_L;
				break;
				
				
			case 'H':
				
				$this->form_hiddendata->addToDisplayList( '<input type="hidden" name="'.$EntryData.'" value="'.$this->values[ $EntryData ].'">'  );
				$currentTemplate = '';
				break;
			
		}
		
		// Now Take the Current Values and replace them with the Given Template
		$return = $currentTemplate;
		
		if ( $return != '' ) {
		
			foreach( $values as $key=>$value ) {
				$return = str_replace($key, $value, $return);
			}
		}		
		
		// Expects a DisplayObject to be returned
		$returnObject = new DisplayObject( $return );
		return $returnObject;
	
	}
	
	
	//************************************************************************
	function disableForm() {
	//
	//	This function marks the form as disabled.  All the controls will be 
	//  disabled.
	
		$this->form_isEnabled = false;
	
	}
	
	//************************************************************************
	function enableForm() {
	//
	//  This function marks the form as enabled.  All the controls will be 
	//	enabled unless specifically enabled.
	
		$this->form_isEnabled = true;
	
	}
	
	
	
	//************************************************************************
	function setValue( $value_key, $value) {
	//
	//  This function will set the value of one of a data item.  If the $value_key
	//  doesn't already exist, then it is created in  values[].
	
		$this->values[ $value_key ] = $value;
	
	}
	
	
	
	
	//************************************************************************
	function initData() {	
	//
	//  This function is called when the Draw Routines are invoked.  It prepares
	//	the actual data for display.
	//
		// Begin to recursively parse the given Form Layout
		$this->recurseLayout( $this->form_layout );

	}
	
	
	
	
	//************************************************************************
	function recurseLayout( $currentHTML) {	
	//
	//  This function recursively parses the given HTML looking for TAGS.  It will
	//	replace the default TAGS with the proper data.  When no more TAGS exist, it 
	//  will return.
	//
		
		// if there is HTML Left ...
		if ( $currentHTML != '') {
		
			// If there is NO TAG in this HTML ...
			$tag_open_position = strpos( $currentHTML, $this->form_layout_tagopen);
			if ( $tag_open_position === false ) {
			
				// Add HTML to Display Output
				$this->addToDisplayList( $currentHTML );
				
			} else {
			
				// Add HTML Before TAG to Output ...
				$html_before = substr( $currentHTML, 0, $tag_open_position );
				
				if ($html_before != '') {
					$this->addToDisplayList( $html_before );
				}
				
				$tag_close_position = strpos( $currentHTML, $this->form_layout_tagclose );
				$tag = substr( $currentHTML, $tag_open_position + $this->form_layout_tagopen_length, $tag_close_position - ( $tag_open_position +  $this->form_layout_tagopen_length ) );
				$this->processTag( $tag );
				
				// Add Remaining HTML
				$html_after = substr( $currentHTML, $tag_close_position +  $this->form_layout_tagclose_length );
				$this->recurseLayout( $html_after ); 
			
			}
		}
	}
	
	
	
	
	//************************************************************************
	function processTag( $Tag) {	
	//
	//  This function adds the proper data to the display list depending upon 
	//	the given $Tag.
	//
		
		if ( $Tag != '' ) {
		
			switch( $Tag ) {
			
				case 'TITLE':
				
					$this->AddToDisplayList( $this->form_title );
					break;
				
				case 'DESCRIPTION':
					break;
				
				case 'MESSAGES':
					
					if ($this->OutPutMessages != '') {
		
						$this->AddToDisplayList( '<p class="text">'.$this->OutPutMessages.'</p>' );
					
					}
					break;
					
				case 'FORM':
					
					// Piece Together the opening form Data ...
					$formOpeningData = '<form action="'.$this->form_callback.'" method="post" name="'.$this->form_name.'"';
					if ($this->form_isUpload == true ) {
						$formOpeningData .= ' enctype="multipart/form-data" ';
					}
					$formOpeningData .= '>
			  <input type="hidden" name="Process" value="'.$this->form_name.'">
              <table width="100%" border="0" cellspacing="3" cellpadding="3">';
			  		
					$this->addToDisplaylist( $formOpeningData );


					// Add Each Form item
					for( $Indx=0; $Indx<count($this->item_item) ; $Indx++) {
			
						$this->AddToDisplayList( $this->returnDisplayRow( $this->item_type[ $Indx ], $this->item_item[$Indx]), DISPLAYOBJECT_TYPE_OBJECT);
					
					}
					
					// close the display table
					$this->AddToDisplayList( '</table>');
					
					// Add all the Hidden Data Items
					if ($this->form_hiddendata->NumDisplayItems > 0 ) {
						$this->addToDisplayList( $this->form_hiddendata, DISPLAYOBJECT_TYPE_OBJECT );
					}
					
					// Now draw the Buttons ...
					$this->addToDisplayList( '<hr width="100%" size="1" noshade color="#223450"><div align="center">') ;
					for ($indx=0; $indx<count( $this->form_button ); $indx++ ) {
					
						$this->addToDisplayList( '<input type="submit" value="'.$this->form_labels->Label('['.$this->form_button[ $indx ].']').'" />' );
					}
					$this->addToDisplayList( '</div>');
					
					// End the form
					$this->AddToDisplayList( '</form>');
		
					break;
					
			} // end switch
		}
	}
	
	
	
	
	
	
	
	//************************************************************************
	function DrawDirect() {
	
		$this->initData();
		
		DisplayObject::DrawDirect();
	
	}
	
	
	
	
	//************************************************************************
	function Draw() {
	
		$this->initData();
		
		return DisplayObject::Draw();
	
	}
	
	
	//************************************************************************
	function TemplateName() {
	
	
	
	}
	

}



class  EazyForm_MySQLDB extends EazyForm {
// 
//  DESCRIPTION:
//		This is a type of EazyForm that also directly accesses data in a 
//		DB.
//
//	CONSTANTS:

//
//	VARIABLES:
	var $DB;
	var $DBName;
	var $DBPath;
	var $DBUserID;
	var $DBPWord;
	var $IsDBInitialized;
	
//
//	CLASS CONSTRUCTOR
//

	//************************************************************************
	function EazyForm_MySQLDB( $CallBack, $ViewerID, $LanguageID, $LabelSeries='AdminGen', $Layout='[[[FORM]]]', $DBName='', $DBPath=DB_PATH, $DBUserID=DB_USER, $DBPWord=DB_PWORD) {
	
		EazyForm::EazyForm($CallBack, $ViewerID, $LanguageID, $LabelSeries, $Layout);		//  Call the Parent Constructor.
		
		$this->DBName = $DBName;
		$this->DBPath = $DBPath;
		$this->DBUserID = $DBUserID;
		$this->DBPWord = $DBPWord;
		$this->IsDBInitialized = false;
	
	}

//
//	CLASS FUNCTIONS:
//

	//************************************************************************
	function TemplateName() {
	
	
	}
	
	
	//************************************************************************
	function initDB() {
	
		if ( $this->IsDBInitialized == false ) {
		
			$this->DB = new Database_MySQL();
			$this->DB->ConnectToDB( $this->DBName, $this->DBPath, $this->DBUserID, $this->DBPWord );
			
			$this->IsDBInitialized = true;
		}
	}
	

}



class  EazyFormTemplate extends DisplayObject {
// 
//  DESCRIPTION:
//		This is a Macro Class designed to simplify the creation & processing of forms on a Web Page.
// 		It handles the internal Displaying of the form, the loading of data from the form, routines to 
//		check the validity of the data, etc...
//
//		It is the Next Evolution of the EasyAdmin Class...
//
//	CONSTANTS:

//
//	VARIABLES:
	var $formDataStruct;		// [OBJECT] The Data Structure for passing Form data to the Template.
	
	var $formTemplatePath;		// [STRING] Path to the directory the Template file is located.
	var $formTemplateName;		// [STRING] Name of Template File to use.
	
	
	var $formLabels;			// The List of Multi Lingual Labels to display for this form
	var $viewerID;
	var $languageID;			// The Language ID of the Viewer

	var $formName;				// [STRING]  The Name of the Form.  Unique ID. <form name=$form_name > ...
								// $form_name also defines the MultiLingual Label "Page" for the Labels
		
	var $formHiddendata;		// [DISPLAY OBJECT] Contains the HiddenData in this form.
	
	var $form_buttonlist;		// [STRING] A list of buttons to display on the form.
	var $formButton;			// [ARRAY] The $form_buttonlist in Array format.

	
	var $formIsEnabled;		// [BOOL] Flag indicating if the Form should be displayed editabled or not.		
	
	var $formIsUpload;			// [BOOL] Flag indicating if this form uploads any files.
	
	var $values;				// Internal Array of values used by this form.  
	
	var $item_list;				// [STRING] Comma Seperated List of table columns used in this Form.
								//     These table column names provide the data to key for :
								//		labels, values[ column_name ], etc...
								
	var $itemItem;				// [ARRAY]  The $item_list in Array format.
	var $item_typelist;			// [STRING] Comma Seperated List of table column item_type.  Each entry 
								//	correspondes to the $item_list entry.  The EntryType determines 
								//  which form element is displayed, and how it is read in from the Form.
								
	var $itemType;					// [ARRAY] The $item_typelist in Array format.
	
	var $item_invalidlist;		// [STRING] Comma Seperated list of INVALID data.
								//		To specify that a null string '' is invalid, just leave empty
								//		To specify that there is NO INVALID data, put <skip> ...
								//		ex: 1,,,<skip>,
								//			item_item[0] cannot have a 1 as it's value
								//			item_item[1,2,4] cannot be empty strings
								//			item_item[3] has no INVALID value....
	var $itemInvalid;			// [ARRAY] The $item_invalidlist in Array format.

	
	var $formMessages;		// [STRING] String of any Output Messages to display to the user.

//
//	CLASS CONSTRUCTOR
//

	//************************************************************************
	function EazyFormTemplate( $CallBack, $ViewerID, $LanguageID, $LabelSeries='AdminGen', $templatePath='Data/Templates/', $templateName='ez_FormTemplate.php' ) {
		
		DisplayObject::DisplayObject();		//  Call the Parent Constructor.
		
		$this->formDataStruct = new EazyFormTemplate_DataStructure();
		
		
		$this->formLabels = new MultiLingual_Labels( 'AI', $LabelSeries, $this->formName, $LanguageID );

		$this->formDataStruct->name = $this->formName;
		$this->formDataStruct->title = $this->formLabels->Label('[form_title]');
		$this->formDataStruct->callback = $CallBack;
		
		$this->viewerID = $ViewerID;
		$this->languageID = $LanguageID;
		
		$this->formTemplatePath = $templatePath;
		$this->formTemplateName = $templateName;

		
		$this->values = array();

		$this->formButton = explode( ',', $this->form_buttonlist );
		$this->itemItem = explode(',', $this->item_list );
		$this->itemType = explode(',', $this->item_typelist );
		$this->itemInvalid = explode( ',', $this->item_invalidlist);
		
		// Set Values to a default state.
		$this->initValues();
		
	}


//
//	CLASS FUNCTIONS:
//

	//************************************************************************
	function initValues() {
	//
	//	This function sets all the expected values to a default/ uninitialized state.
	//
	
		for( $Indx=0; $Indx<count($this->itemItem) ; $Indx++) {

			$this->values[ $this->itemItem[ $Indx ] ] = '';
		}
	
	}
	
	

	//************************************************************************
	function LoadFromForm() {
	
		for( $Indx=0; $Indx<count($this->itemItem) ; $Indx++) {
		
			if (isset( $_REQUEST[ $this->itemItem[ $Indx ] ] ) == true ) {
			
				$this->values[ $this->itemItem[ $Indx ] ] =  $_REQUEST[ $this->itemItem[ $Indx ] ] ;
				
			} else {
			
				$this->values[ $this->itemItem[ $Indx ] ] = '';
			}
		}
	
	}
	
	
	
	//************************************************************************
	function checkValidData( $Key, $InvalidValue, $IsValidFlag) {
	//
	//	DESCRIPTION:
	//		This is a simple data validation function to verify the data in a given
	//		value.
	//
		$ReturnValue = $IsValidFlag;
		
		if ( $this->values[ $Key ] == $InvalidValue ) {
		
			$this->ErrorMessages[ $Key ] = $this->formLabels->Label('[Error_'.$Key.']');
			$ReturnValue = false;
		}
		
		return $ReturnValue;
	
	}
	
	
	//************************************************************************
	function isDataValid() {
	
		$isValid = true;
		
		// For each form item ...
		for ( $indx=0; $indx < count( $this->itemItem); $indx++) {
		
			// if there exists an INVALID case for this item ...
			if ( $this->itemInvalid[$indx] != '<skip>' ) {
				
				// Check it's validity ...
				$isValid = $this->checkValidData( $this->itemItem[ $indx ], $this->itemInvalid[ $indx ], $isValid);
			}
		}
		
		return $isValid;
	}
	
	
	
	//************************************************************************
	function processFormItem( $DataType, $EntryData ) {
	//
	//  This function takes the given Form Item and prepares the formDataStruct
	//  item entry for it.
	//
		
		// Get the Data Type of this Object ... 
		//  NOTE:  it is possible that the Type is 2 parts : ex TYPE:SUBTYPE 
		$Data = explode( ':', $DataType);
		
		
		// If DataType != Hidden Data then 
		if ($Data[0] != 'H') {
		
			// Collect the Common Values used by the Template Items ...
			$values = array();
			$values[ 'Type' ] = $Data[0];
			$values[ 'Label' ] = $this->formLabels->Label('['.$EntryData.']');
			$values[ 'Name' ] = $EntryData;
			
			
			if ( isset( $this->ErrorMessages[ $EntryData ] ) == true ) {
				$values[ 'ErrorMsg' ] = $this->formLabels->Label($this->ErrorMessages[ $EntryData ]);
			} else {
				$values[ 'ErrorMsg' ] = '';
			}
			
			$values[ 'Example' ] = $this->formLabels->Label('[Ex'.$EntryData.']');
			
			
			// Based on the Type, get the proper Value data... 
			switch ( $Data[0] ) {
			
				case 'T':
				case 'M':
					
					$values[ 'Value' ] = $this->values[ $EntryData ];
					break;
	
					
					
				case 'CB':
					
					// For a checkbox, if a value is present, we want it to display as checked.
					// Otherwise it should be unchecked.
					if ($this->values[ $EntryData ] != '') {
						$values[ 'Value' ] = ' checked ';
					} else {
						$values[ 'Value' ] = ' ';
					}
					break;
					
				case 'FU':
				    echo 'EazyForm::processFormItem() -> FileUpload Instance needs to be handled by Child.<br>';
				    // For a FileUpload Box, we attempt to put together
				    break;
					
					
				case 'L':
					$values[ 'Value' ] = '';
					break;
			}
			
			// Add to formDataStruct Item List
			$this->formDataStruct->items[] = $values;
			
		} else {
		
			// Add HiddenValue Item
			$values = array();
			$values[ 'Name' ] = $EntryData;
			$values[ 'Value' ] = $this->values[ $EntryData ];
			
			$this->formDataStruct->hiddenData[] = $values;
			
		}
		

	
	}
	
	
	//************************************************************************
	function disableForm() {
	//
	//	This function marks the form as disabled.  All the controls will be 
	//  disabled.
	
		$this->formDataStruct->isEnabled = false;
	
	}
	
	//************************************************************************
	function enableForm() {
	//
	//  This function marks the form as enabled.  All the controls will be 
	//	enabled unless specifically enabled.
	
		$this->formDataStruct->isEnabled = true;
	
	}
	
	
	
	//************************************************************************
	function setValue( $valueKey, $value) {
	//
	//  This function will set the value of one of a data item.  If the $value_key
	//  doesn't already exist, then it is created in  values[].
	
		$this->values[ $valueKey ] = $value;
	
	}
	
	
	//************************************************************************
	function addMessageByKey( $messageKey) {
	//
	//  This function will create a new message entry using a MessageKey.  The
	//  actual message is pulled from the formLabels-Label() routine.
	
		$this->formDataStruct->messages[] = $this->formLabels->Label( $messageKey );
	
	}
	
	
	
	
	//************************************************************************
	function initData() {	
	//
	//  This function is called when the Draw Routines are invoked.  It prepares
	//	the actual data to be sent to the Template Engine.
	//
		// Piece Together the opening form Data ...



		// Add Each Form item
		for( $Indx=0; $Indx<count($this->itemItem) ; $Indx++) {

			$this->processFormItem( $this->itemType[ $Indx ], $this->itemItem[$Indx]);
		
		}
					
		// Add Each Button To the Button List
		for ($indx=0; $indx<count( $this->formButton ); $indx++ ) {
					
			// Build Button Data ...
			$data = array();
			$data[ 'Type' ] = 'submit';
			$data[ 'Value' ] = $this->formLabels->Label('['.$this->formButton[ $indx ].']');
			$data[ 'Action' ] = $this->formButton[ $indx ];
			
			// Add to Data Struct
			$this->formDataStruct->buttonList[] = $data;
			
		}
					
		$template = & new Template( $this->formTemplatePath );
		$template->set( 'form', $this->formDataStruct);
		$template->set( 'labels', $this->formLabels);
		
		$returnDisplay = $template->fetch( $this->formTemplateName );
		
					
		// End the form
		$this->AddToDisplayList( $returnDisplay );

	}
	
	
	
	
	
	//************************************************************************
	function DrawDirect() {
	
		$this->initData();
		
		DisplayObject::DrawDirect();
	
	}
	
	
	//************************************************************************
	function Draw() {
	
		$this->initData();
		
		return DisplayObject::Draw();
	
	}
	

}






class  EazyFormTemplate_MySQLDB extends EazyFormTemplate {
// 
//  DESCRIPTION:
//		This is a type of EazyForm that also directly accesses data in a 
//		DB.
//
//	CONSTANTS:

//
//	VARIABLES:
	var $DB;
	var $DBName;
	var $DBPath;
	var $DBUserID;
	var $DBPWord;
	var $IsDBInitialized;
	
//
//	CLASS CONSTRUCTOR
//

	//************************************************************************
	function EazyFormTemplate_MySQLDB( $CallBack, $ViewerID, $LanguageID, $LabelSeries='AdminGen', $templatePath='Data/Templates/', $templateName='ez_FormTemplate.php', $DBName='', $DBPath=DB_PATH, $DBUserID=DB_USER, $DBPWord=DB_PWORD) {
	
	   //  Call the Parent Constructor.
		EazyFormTemplate::EazyFormTemplate( $CallBack, $ViewerID, $LanguageID, $LabelSeries, $templatePath, $templateName);	
					
		$this->DBName = $DBName;
		$this->DBPath = $DBPath;
		$this->DBUserID = $DBUserID;
		$this->DBPWord = $DBPWord;
		$this->IsDBInitialized = false;
	
	}

//
//	CLASS FUNCTIONS:
//

	//************************************************************************
	function TemplateName() {
	
	
	}
	
	
	//************************************************************************
	function initDB() {
	
		if ( $this->IsDBInitialized == false ) {
		
			$this->DB = new Database_MySQL();
			$this->DB->ConnectToDB( $this->DBName, $this->DBPath, $this->DBUserID, $this->DBPWord );
			
			$this->IsDBInitialized = true;
		}
	}
	

}




class EazyFormTemplate_DataStructure {

var $name;
var $title;
var $callBack;
var $isEnabled;
var $isUpload;

var $items;

var $hiddenData;

var $buttonList;

var $messages;


	function EazyFormTemplate_DataStructure() {
	
		// Initialize Data to default Values
		$this->name = '';
		$this->title = '';
		$this->callBack = '';
		$this->isEnabled = true;
		$this->isUpload = false;
		
		// Initialize arrays to empty arrays
		$this->items 		= array();
		$this->hiddenData 	= array();
		$this->buttonList 	= array();
		$this->messages 	= array();

	}


}



?>