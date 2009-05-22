<?php
/**
 * @package TemplateTools
 */ 
/**
 * class TemplateTools
 * <pre> 
 * This object provides several drawing routines common in our Template files.
 * </pre>
 * @author Johnny Hausman
 */
class  TemplateTools {

	//CONSTANTS:
	/** The list of months of the year */
    const TEMPLATE_LIST_MONTH = 'January=01,February=02,March=03,April=04,May=05,June=06,July=07,August=08,September=09,October=10,November=11,December=12';
    
    const TEMPLATE_LIST_MONTH_ALLOWED = 'January,February,March,April,May,June,July,August,September,October,November,December';
    
    const TEMPLATE_LABEL_VAR_PREFIX = '%VAR';
    const TEMPLATE_LABEL_VAR_SUFFIX = '%';

	//VARIABLES:
	/** @var [ARRAY] Array of months and values for use in drop lists */
	protected $listMonths;

	/** @var [ARRAY] Array of days for use in drop lists */
	protected $listDays;
	
	/** @var [OBJECT] viewer object */
	protected $viewer;
	
	/** @var [OBJECT] labels object */
	protected $labels;
	
	/** @var [BOOL] has gender list been loaded */
	protected $isGenderLabelsLoaded;
	
	/** @var [BOOL] has yes/no list been loaded */
	protected $isYesNoLabelsLoaded;
	
	/** @var [BOOL] has country list been loaded */
	protected $isCountryLabelsLoaded;
	
	/** @var [BOOL] has month list been loaded */
	protected $isMonthLabelsLoaded;
	
	/** @var [ARRAY] Array of labels provided by the page */
	protected $listLabels;
	
	/** @var [BOOL] has label list been loaded */
	protected $isLabelsLoaded;
	
	protected $disabled;
	

	//CLASS CONSTRUCTOR
	//************************************************************************
	/**
	 * function __construct
	 * <pre>
	 * [classConstructor Description]
	 * </pre>
	 * <pre><code>
	 * [Put PseudoCode Here]
	 * </code></pre>
	 * @param $param1 [$param1 type] [optional description of $param1]
	 * @param $param2 [$param2 type] [optional description of $param2]
	 * @return [returnValue, can be void]
	 */
    function __construct( ) 
    {
    
        $this->viewer = new Viewer();
        
        $this->labels = new XMLObject_MultilingualManager( $this->viewer->getLanguageID() );
        
        $this->listLabels = array();
        
        $this->isGenderLabelsLoaded = false;
        $this->isYesNoLabelsLoaded  = false;
        $this->isCountryLabelsLoaded = false;
        $this->isMonthLabelsLoaded  = false;
        $this->isLabelsLoaded  = false;
        
        
        /*
         * Prepare List of Days
         */
        for( $indx=1; $indx<=31; $indx++) {
            $value = sprintf( '%02d', $indx);
            $this->listDays[ $value ] = $value;
        }
        
        
        
    
    }



	//CLASS FUNCTIONS:
	//************************************************************************
	/**
	 * function classMethod
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
    function classMethod($param1, $param2) 
    {
        // CODE
    }
    
    
    
    /**
     * disables form items
     */
     function disableForm()
     {
        $this->disabled = "DISABLED";
     }
     
     /**
      * enables form items
      */
      function enableForm()
      {
        $this->disabled = "";
      }
    
    //************************************************************************
	/**
	 * function getFormTypeList
	 * <pre>
	 * This function returns an array of values for choosing which form types
	 * are supported.  This is used by the RAD Tools: Add DA Object Field
	 * page to select which form entry type a field should use.
	 * </pre>
	 * 
	 * @return [ARRAY]
	 */
    function getFormTypeList() 
    {
        // define list of possible field values
        $entryList = 'checkbox,datepicker,droplist,label,password,textarea,textbox,textbox_ro';
        
        // convert to an array
        $entries = explode( ',', $entryList);
        
        // load each entry into the $typeList array
        $typeList = array();
        for ($indx=0; $indx<count($entries); $indx++){
            $key = $entries[ $indx ];
            $typeList[ $key ] = $key;
        }
        
        // return the $typeList array
        return $typeList;
    }	
    
    
    
    //************************************************************************
	/**
	 * function getPageLabel
	 * <pre>
	 * returns the requested label.
	 * </pre>
	 * @param $key [STRING] the unique "key" of the requested label.
// DISABLED - DOESN'T WORK	 * @param $var_list [STRING] a CSV list of variables to replace %var% placeholders in label
	 * @return [void]
	 */
    function getPageLabel( $key )	//, $var_list = '' ) 
    {
    
        if ($this->isLabelsLoaded ) {
        
            if (isset( $this->listLabels[ $key ] ) ) {
                $returnValue = $this->listLabels[ $key ];
//                 if ($var_list != '')
//                 {
// 	                $returnValue = $this->setLabelVars($returnValue, $var_list);
//                 }
            } else {
                $returnValue = $key;
            }
            
        } else {
        
            $returnValue = '[Error]: Template page labels have not been loaded. Call ->loadPageLabels( $xmlObject ) first.';
        }
        
        return $returnValue;
        
    }

     //************************************************************************
	/**
	 * function setLabelVars
	 * <pre>
	 * returns the label that was inputed to have %var% strings replaced with variables
	 * </pre>
	 * @param $label [STRING] the label to be operated on
	 * @param $replacements [STRING] a CSV list of variables to replace %var% placeholders in label
	 * @return [void]
	 */
//     function setLabelVars( $label, $replacements ) 		// NOTE: DOES **NOT** CURRENTLY WORK
//     {  
// 	    $new_label = $label;
// 	    $var_values = explode(",", $replacements);
// 	    reset($var_values);
// 	    $i = 0;
// 	    foreach (array_keys($var_values) as $key)
// 	    {
// 		   $search = TemplateTools::TEMPLATE_LABEL_VAR_PREFIX.$i.TemplateTools::TEMPLATE_LABEL_VAR_SUFFIX;
// 		   $replace = current($var_values);
// 		 	$label = str_replace($search, $replace, $label); 
// 		 	
// 		 	next($var_values);
// 		 	$i++;
// 	 	 }
// 	    
// 	 	 return $new_label;
//  	 }
    
    
    //************************************************************************
	/**
	 * function loadPageLabels
	 * <pre>
	 * Loads the Page Labels into an internal array.
	 * </pre>
	 * @param $pageLabels [SimpleXMLObject] The XML page labels object.
	 * @return [void]
	 */
    function loadPageLabels( $pageLabels ) 
    {
        if (is_array( $pageLabels ) ) {

            $this->listLabels = $pageLabels;
            
        } else {

            $labelKey = RowManager_MultilingualLabelManager::XML_ELEMENT_NAME;
            foreach( $pageLabels->$labelKey as $label) {
                
                $this->listLabels[ (string) $label['key'] ] = (string) $label;
            }
        }
        
        $this->isLabelsLoaded = true;
    }    
    
    
    //************************************************************************
	/**
	 * function loadPageLabels
	 * <pre>
	 * Loads the Page Labels into an internal array.
	 * </pre>
	 * @param $pageLabels [SimpleXMLObject] The XML page labels object.
	 * @param $prefix [STRING] the prefix string limiting which labels are loaded
	 * @return [void]
	 */
/**    function loadSpecialLabels( $pageLabels, $prefix ) 
    {
	    $prefixLen = strlen($prefix);
        if (is_array( $pageLabels ) ) {
	        
	        $prefixedLabels = array();
	        foreach( $pageLabels->$labelKey as $label) {
		    	
		        $chunks = str_split($pageLabels->$labelKey, $prefixLen);
		        if ($chunks[0] = $prefix) 
		        {
		        	$prefixedLabels[$pageLabels->$labelKey] = $label;
	        	}   
	    	}

            
        } 
    
        return $prefixedLabels;
    }  
 **/
    
    //************************************************************************
	/**
	 * function returnIndexValue
	 * <pre>
	 * This method will look for an Array entry with the provided index. If 
	 * the provided index exists it will return the Array value. Otherwise it
	 * will return '-'.
	 * NOTE: this value is commonly used for display templates that want to
	 * display an array value instead of a table ID for a field.
	 * </pre>
	 * @param $index [STRING] key into the array
	 * @param $arrayList [ARRAY] array of values 
	 * @return [STRING]
	 */
    function returnIndexValue( $index, $arrayList ) 
    {
        // treat data as the index to the entry into the list.
        $data = $index;

        // find out if keys are (int) or not
        $keys = array_keys( $arrayList );
        if (is_int( $keys[0] ) ) {
            $data = (int) $data;
        } else {
            $data = (string) $data;
        }
        
        // if it is a valid entry then 
        if (isset( $arrayList[ $data ] ) ) {
        
            // retrieve the text to display
            $data = $arrayList[ $data ];
        } else {
        
            if ($data == 0) {
                $data = '-';
            }
        }

        // return the $typeList array
        return $data;
    }
    
    
    
    //************************************************************************
	/**
	 * function setHeadingBGColor
	 * <pre>
	 * Sets the parameter to the BG color for a Heading.
	 * </pre>
	 * @param $currentColor [STRING] Current Value of the color entry
	 * @return [STRING]
	 */
    function setHeadingBGColor( &$currentColor) 
    {
        $currentColor = 'bgcolor="CCCCCC"';

    }
    
    
    
    //************************************************************************
	/**
	 * function showAdminBox
	 * <pre>
	 * This method draws a listbox of days.
	 * </pre>
	 * @param $adminBox [OBJECT] A simplexml object representing the admin box
	 * @return [void]
	 */
    function showAdminBox( $adminBox ) {
        
        /*
         *  Get Edit ID
         */
        $editIDKey = XMLObject_AdminBox::XML_ELEMENT_EDITID;
        $editID = $adminBox->$editIDKey;
        
        
        $formLinkKey = XMLObject_AdminBox::XML_NODE_FORMLINKS;
        $formHiddenDataKey = XMLObject_AdminBox::XML_NODE_HIDDENDATA;;
        
        /*
         *  Start Admin Box Table def.
         */
        echo '<table width="100%" border="0" cellspacing="0" cellpadding="5">'."\n";
        
        
        /*
         *  print headers
         */ 
        echo '      <tr valign="top">'."\n";
        $headingKey = XMLObject_AdminBox::XML_ELEMENT_HEADING;
        $headingGroup = XMLObject_AdminBox::XML_NODE_HEADING;
        foreach( $adminBox->$headingGroup->$headingKey as $heading) {
        
            echo '             <td > <p class="heading3">'.$heading.'</p></td>'."\n";
        }
        echo '             <td >&nbsp;</td>'."\n";  // extra column for buttons
        echo '      </tr>'."\n";
        
        
        /*
         * now print out data rows ...
         */
        $dataGroup = XMLObject_AdminBox::XML_NODE_DATA;
        $dataRow = XMLObject_AdminBox::XML_NODE_DATAROW;
        $dataUIDKey = XMLObject_AdminBox::XML_ELEMENT_DATAUID;
        $dataValue = XMLObject_AdminBox::XML_ELEMENT_DATAVALUE;
        
        $formKey = XMLObject_AdminBox::XML_NODE_FORM;
        foreach ( $adminBox->$dataGroup->$dataRow as $row) {
        
           
            // if this row is being edited then
            $dataRowID = $row->$dataUIDKey;           
            if ( (int) $dataRowID == (int) $editID ) {
            
                // print form data here
                $this->showAdminBoxForm( $adminBox->$formKey, $adminBox->$formLinkKey, $adminBox->$formHiddenDataKey );
            
            } else {
            // else
            
                echo '      <tr valign="top">'."\n";
            
                // print out data row
                foreach( $row->$dataValue as $value) {
                     echo '             <td > <p class="smalltext">'.$value.'</p></td>'."\n";
                }
                
                echo '             <td valign="top" class="smallText">';
                
                // for each data link
                $dataLinkKey = XMLObject_AdminBox::XML_NODE_DATALINKS;
                $linkKey = XMLObject_AdminBox::XML_NODE_LINK;
                $linkLabelKey = XMLObject_AdminBox::XML_ELEMENT_LINKS_LABEL;
                $linkActionKey = XMLObject_AdminBox::XML_ELEMENT_LINKS_ACTION;
                
                $linkData = '';
                foreach( $adminBox->$dataLinkKey->$linkKey as $dataLink) {
                
                    $linkAction = $dataLink->$linkActionKey.$dataRowID;
                    if ( $linkData != '' ) {
                        $linkData .= ' | ';
                    }
                    // print out link info 
                    $linkData .= '<a href="'.$linkAction.'">'.$dataLink->$linkLabelKey.'</a>';
                    
                } // next link
                echo $linkData.'</td>'."\n";
                echo '      </tr>'."\n";
                
            } // end if this row is being edited...

        }  // next data row
        
        
        // if no row is being edited then
        if ($editID == -1) {
        
            // display form data 
            $this->showAdminBoxForm( $adminBox->$formKey, $adminBox->$formLinkKey, $adminBox->$formHiddenDataKey );
            
        } // end if
              
        echo '    </table>'."\n";
        
    }  // end showAdminBox()
    
    
    
    //************************************************************************
	/**
	 * function showAdminBoxForm
	 * <pre>
	 * displays the row of admin Box form data.
	 * </pre>
	 * @param $formData [OBJECT] simplexml object with the form data
	 * @param $formLinks [OBJECT] simplexml object with the form link data
	 * @param $hiddenData [OBJECT] simplexml object with the form's hidden data
	 * @return [void]
	 */
    function showAdminBoxForm( $formData, $formLinks, $hiddenData ) {
        
        $formItemKey =  XMLObject_AdminBox::XML_NODE_FORMITEM;
        
        $nameKey = XMLObject_AdminBox::XML_ELEMENT_FORMITEM_NAME;
        $valueKey = XMLObject_AdminBox::XML_ELEMENT_FORMITEM_VALUE;
        $errorKey = XMLObject_AdminBox::XML_ELEMENT_FORMITEM_ERROR;
        $typeKey = XMLObject_AdminBox::XML_ELEMENT_FORMITEM_TYPE;
        
        $dateStartYearKey = XMLObject_AdminBox::XML_ELEMENT_FORMITEM_DATE_STARTYEAR;
        $dateEndYearKey = XMLObject_AdminBox::XML_ELEMENT_FORMITEM_DATE_ENDYEAR;
        
        $listItemKey = XMLObject_AdminBox::XML_NODE_FORMITEM_LIST_ITEM;
        $listItemLabelKey = XMLObject_AdminBox::XML_ELEMENT_FORMITEM_LIST_ITEM_LABEL;
        $listItemValueKey = XMLObject_AdminBox::XML_ELEMENT_FORMITEM_LIST_ITEM_VALUE;
        
        echo '      <tr valign="top">'."\n";
        
        foreach ( $formData->$formItemKey as $formItem) {
        
            if ($formItem->$typeKey != 'H' ) {
                $name = $formItem->$nameKey;
                $value = $formItem->$valueKey;
                $error = $formItem->$errorKey;
                
                echo '             <td >';
                
                switch( $formItem->$typeKey ) {
                
                    case 'C':
                        $this-> showCheckBox( $name, '1', $value, $error );
                        break;
                
                    case 'T':
                        $this->showTextBox( $name, $value, $error);
                        break;
                        
                    case 'P':
                        $this->showPasswordBox( $name, $value, $error);
                        break;
                        
                    case 'M':
                        break;
                    
                    case 'D':
                        $startYear = $formItem->$dateStartYearKey;
                        $endYear = $formItem->$dateEndYearKey;
                        $this->showDateList( $name, $value, $error, $startYear, $endYear );
                        break;
                        
                    case 'L':
                        $options = array();
                        foreach( $formItem->$listItemKey as $item) {
                            $itemValue = $item->$listItemValueKey . '';
                            $options[ $itemValue ] = $item->$listItemLabelKey.'';
                        }
                        $this->showListByArray( $name, $value, $options );
                        $this->showErrorMessage( $error );
                        break;
                
                } // end switch
                
                echo '</td>'."\n";
                
            } // end if not Hidden value
            
        }  // next formItem
        
        echo '             <td class="heading3">';
        
        // show hidden data
        $hiddenKey = XMLObject_AdminBox::XML_NODE_HIDDEN;
        $hiddenNameKey = XMLObject_AdminBox::XML_ELEMENT_HIDDEN_NAME;
        $hiddenValueKey = XMLObject_AdminBox::XML_ELEMENT_HIDDEN_VALUE;
        
        foreach( $hiddenData->$hiddenKey as $hidden) {
        
            $hiddenName = $hidden->$hiddenNameKey;
            $hiddenValue = $hidden->$hiddenValueKey;
            echo '<input name="'.$hiddenName.'" type="hidden" value="'.$hiddenValue.'" />';
        }
        
        // show form links
        // for each form link
        $linkKey = XMLObject_AdminBox::XML_NODE_LINK;
        $linkLabelKey = XMLObject_AdminBox::XML_ELEMENT_LINKS_LABEL;
        $linkActionKey = XMLObject_AdminBox::XML_ELEMENT_LINKS_ACTION;
        
        $linkData = '';
        foreach( $formLinks->$linkKey as $formLink) {
        
            $linkAction = $formLink->$linkActionKey;
            if ( $linkData != '' ) {
                $linkData .= ' | ';
            }
            // print out link info 
            $linkData .= '<a href="'.$linkAction.'">'.$formLink->$linkLabelKey.'</a>';
            
        } // next link
        echo $linkData;
        
        
        echo '</td>'."\n";
        echo '      </tr>'."\n";

        
    } // end showAdminBoxForm()
    
    
    
    //************************************************************************
	/**
	 * function showByFormType
	 * <pre>
	 * This function displays the appropriate form element based upon a given
	 * field type.
	 * </pre>
	 * @param $formItemType [STRING] the type of field to display
	 * @param $formItemName [STRING] the name of the field to display
	 * @param $formItemValue [STRING] the value of the field to display
	 * @param $formItemError [STRING] the error associated with the field to display
	 * @param $listData [ARRAY] array of values for a droplist element
	 * @param $startYear [INTEGER] beginning year for a date picker
	 * @param $endYear [INTEGER] ending year for a date picker
	 * @param $script  [STRING] any other script that needs to be entered into the code (warning! only implemented for certain functions
	 * @return [void]
	 */
    function showByFormType($formItemType, $formItemName, $formItemValue, $formItemError, $listData, $startYear=2000, $endYear=2010, $script='', $notice='', $formName='') 
    {
        // based upon what form field type
        
        $pieces = explode('|', $formItemType );
        $formItemType = $pieces[0];
        $isReadOnly = false;
        
        // pieces[1,2...] contains the rest of the parameters
        
        switch( $formItemType ) {
        	     
	         case 'textbox_ro':
	         	$isReadOnly = true;
            case 'textbox':
                // display a text box
                // script variable implemented
                // parameter format:  textbox|size|maxLength
                $size = '';
                if (isset($pieces[1]))
                {
                    $size = $pieces[1];
                }
                $maxLength = '';
                if (isset($pieces[2]))
                {
                    $maxLength = $pieces[2];
                }  
                $style = '';
                if (isset($pieces[3]))
                {
                    $style = $pieces[3];
                }                  
                $this->showTextBox( $formItemName, $formItemValue, $formItemError, $size, $script, $maxLength, $isReadOnly, $style );
                break;
            	
                
            case 'textarea':
                // display a text area
                // parameter format:  textbox|numCols|numRows
                $numCols = 40;
                $numRows = 5;
                if (isset($pieces[1]))
                {
                    $numCols = $pieces[1];
                }
                if (isset($pieces[2]))
                {
                    $numRows = $pieces[2];
                }
                $this->showTextArea( $formItemName, $formItemValue, $formItemError, $numCols, $numRows );
                break;
                
            case 'checkbox':
                // display a text area
                $this->showCheckBox( $formItemName, 1, $formItemValue, $formItemError);
                break;
                
            case 'list_ro':
                // script variable implemented
                $this->showListByArray( $formItemName, $formItemValue, $listData, $script, false, '5',  true);
                $this->showErrorMessage( $formItemError );
                break; 	
                                
            case 'droplist':
                // script variable implemented
                $this->showListByArray( $formItemName, $formItemValue, $listData , $script);
                $this->showErrorMessage( $formItemError );
                break;                
                
            // jumplist case added by RM - June 21, 2006
            case 'jumplist':
                 //echo 'default value ['.$formItemValue.']<br/>';
                // $formItemValue = 'http://localhost/~Russ/phoenix/php5/index.php?p_Mod=cim_stats&P=P9&SV8=1&SV10=1';
                
                /** (below) allows user to add default dash to jumplist:  jumplist|Y  **/
                $defaultIsDash = false;
                if (isset($pieces[1]))
                {
                    if (($pieces[1] == 'Y') || ($pieces[1] == 'y'))
                    {
	                    $defaultIsDash = true;
                    }
                }                
                $this->showJumpListByArray( $formItemName, $formItemValue, $listData, $defaultIsDash);
                break;
                
            // changelist case added by HS - November 9, 2007
            case 'changelist':
            
                // display a change-list
                // script variable implemented
                // parameter format:  changelist|targetFieldName|templateVar_subsArray (i.e. the template var storing subs)
                $targetFieldName = '';
                $replacementValues = '';
                if (isset($pieces[1]))
                {
                    $targetFieldName = $pieces[1];
                }
                if (isset($pieces[2]))
                {
                    $templateVar_subsArray = $pieces[2];
                }
                
                $itemsShown = '3';		// SET DEFAULT TO BE 1 ITEM
//                 if (isset($pieces[3]))
//                 {
//                     $itemsShown = $pieces[3];
//                 }
            
            	// used to make a droplist change the values in another droplist
         	$this->showDynListByArray( $formItemName, $formItemValue, $listData, $itemsShown, $targetFieldName, $templateVar_subsArray );
	            break;
                
            case 'combolist':
                // display a text box
                // script variable implemented
                // parameter format:  combolist|itemsShown
                $itemsShown = '5';		// SET DEFAULT TO BE 5 ITEMS
                if (isset($pieces[1]))
                {
                    $itemsShown = $pieces[1];
                }
                $this->showListByArray( $formItemName, $formItemValue, $listData , $script, true, $itemsShown);
                $this->showErrorMessage( $formItemError );
                break;                   
                
            case 'password':
                
                $this->showPasswordBox( $formItemName, $formItemValue, $formItemError);
                break;
                
            case 'datepicker':
                
                $this->showDateList( $formItemName, $formItemValue, $formItemError, $startYear, $endYear);
                break;
                
           case 'datebox':
					 $this->showDateBox($formItemName, $formItemValue, $formItemError, $startYear, $endYear, false, $formName); 
					 break;           
                
            case 'label':
                
                $this->showLabel( $formItemValue, $listData );
                $this->showHidden( $formItemName, $formItemValue );
                break;
                
            // added by RM on July 13.05
            case 'hidden':
                $this->showHidden( $formItemName, $formItemValue );
                break; 
                
            
                
            case 'timepicker':
                
                $this->showTimeList( $formItemName, $formItemValue, $formItemError);
                break; 
                
            case 'datetimepicker':
                $values = explode( ' ', $formItemValue);
                
                $this->showDateList( $formItemName, $values[0], $formItemError, $startYear, $endYear);
                
                // make sure there is a default value
                if (!isset( $values[1] ) ) {
                    $values[1] = '';
                }
                $this->showTimeList( $formItemName, $values[1], $formItemError);
                break; 
                
// in future add: 
// lists: Gender, Yes/No, Country, 
// date, time
        } // end switch()
        

        if ($notice != '') 
        {
        		echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$notice;
     		}
    }
    
    
    
    //************************************************************************
	/**
	 * function showCheckBox
	 * <pre>
	 * This method draws a checkbox.
	 * </pre>
	 * @param $fieldName [STRING] The name of the textbox
	 * @param $value [STRING] The value of this textbox
	 * @param $defaultValue [STRING] The default value of this field
	 * @param $errorMSG [STRING] Error message associated with this textbox
	 * @return [void]
	 */
    function showCheckBox( $fieldName, $value, $defaultValue, $errorMSG='' ) {
    
        $checked = '';
        if ($value == $defaultValue) {
            $checked = 'checked';
        }
        
        echo '<input type="checkbox" name="'.$fieldName.'" value="'.$value.'" '.$checked.' ' . $this->disabled. '/>';

        $this->showErrorMessage( $errorMSG );
        
    }
    
    
    
    //************************************************************************
	/**
	 * function showCountryList
	 * <pre>
	 * This method draws a listbox of Countries.
	 * </pre>
	 * @param $fieldName [STRING] The name of the listbox
	 * @param $defaultValue [STRING] The default value of this listbox
	 * @return [void]
	 */
    function showCountryList( $fieldName, $defaultValue, $errorMSG ) {
        
        if ( $this->isCountryLabelsLoaded == false) {
        
            $this->labels->loadPageLabels( SITE_LABEL_SERIES_SITE, SITE_LABEL_PAGE_LIST_COUNTRY);
            $this->isCountryLabelsLoaded = true;
        }
        
        
        $list[ 'Australia' ]      = $this->labels->getLabel('[Australia]');
        $list[ 'Canada' ]         = $this->labels->getLabel('[Canada]');
        $list[ 'China' ]          = $this->labels->getLabel('[China]');
        $list[ 'Hong Kong' ]      = $this->labels->getLabel('[Hong Kong]');
        $list[ 'Japan' ]          = $this->labels->getLabel('[Japan]');
        $list[ 'Korea' ]          = $this->labels->getLabel('[Korea]');
        $list[ 'Malaysia' ]       = $this->labels->getLabel('[Malaysia]');
        $list[ 'Philippines' ]    = $this->labels->getLabel('[Philippines]');
        $list[ 'Russia' ]         = $this->labels->getLabel('[Russia]');
        $list[ 'Singapore' ]      = $this->labels->getLabel('[Singapore]');
        $list[ 'Thailand' ]       = $this->labels->getLabel('[Thailand]');
        $list[ 'United States' ]  = $this->labels->getLabel('[United States]');
        $list[ 'Other' ]          = $this->labels->getLabel('[Other]');

        $this->showListByArray( $fieldName, $defaultValue, $list);
        
        $this->showErrorMessage( $errorMSG );
        
    }
    
    
    
    //************************************************************************
	/**
	 * function showDateBox
	 * <pre>
	 * This method draws a textbox and a calendar picker for entering dates.
	 * </pre>
	 * @param $fieldName [STRING] The common name of the listbox
	 * @param $defaultDate [STRING] The default value of this listbox
	 * @param $startYear [INTEGER] The beginning year
	 * @param $endYear [INTEGER] The ending year
	 * @param $isShowOneLine [BOOL] Do you want this on 1 line?
	 * @return [void]
	 */
    function showDateBox( $fieldName, $defaultDate, $errorMSG, $startYear, $endYear, $isShowOneLine=false, $formName ) {
        
	    
        if ($defaultDate != '') {
            list( $year, $month, $day) = explode( '-', $defaultDate);
            settype($year, "integer");
            settype($month, "integer");
            settype($day, "integer");
            $popupDefault = ",'" . date('M d, Y', mktime(0, 0, 0, $month, $day, $year)) . "'";
        } else {
            $year = 'yyyy';
            $month = 'mm';
            $day = 'dd';
            $popupDefault = '';
        }
        
        $defaultValue = $year.'-'.$month.'-'.$day;
        
        if ( $isShowOneLine) {
        
            echo '<NOBR>';
        }
        
         // Display Day List
        $this->showTextBox( $fieldName, $defaultValue, '', '12');
        
        //Calender drop-down list
//         $calendarName = $fieldName.'_cal';
//         
//         $datelimit = '';
//         
//         if ($startYear != '') {
//             $datelimit .= $calendarName.'.addDisabledDates(null,"Jan 1, '. $startYear .'");'."\n";
//         }
//         if ($endYear != '') {
//             // add spacing for code
//             if ($datelimit != '' ) {
//                 $datelimit .= '            ';
//             }
//             $datelimit .= $calendarName.'.addDisabledDates("Dec 31, '. $endYear .'",null);'."\n";
//         }
        
        // up to now, the fieldName is the name of the textBox being displayed.
        // Now we are saving that value to textBox and then using fieldName
        // as the name of the date picker calendar popup.
       $textBox = $fieldName;
//        $fieldName .= 'dtpkr';
       
			//<div id="overDiv" style="position:absolute; visibility:hidden; z-index:1000;"></div>  // <-- CURRENTLY PUT IN TEMPLATE FILE AS NEEDED
		  echo '<a href="javascript:show_calendar(\''.$formName.'.'.$fieldName.'\');" onMouseOver="window.status=\'Date Picker\'; overlib(\'Click here to choose a date from a one month pop-up calendar.\'); return true;" onMouseOut="window.status=\'\'; nd(); return true;"><img src="Images/cal.gif" width=24 height=22 border=0></a>';
                 
        
//         echo '<SCRIPT LANGUAGE="JavaScript" ID="jscal1x_'.$fieldName.'"  SRC="././Data/scripts/JScript/CalendarPopup.js">
//             var '.$calendarName.' = new CalendarPopup("'.$fieldName.'");
//             document.write(getCalendarStyles());
//             '.$calendarName.'.showYearNavigation();
//             '.$calendarName.'.showYearNavigationInput();
//             '.$calendarName.'.setReturnFunction("'.$fieldName.'_setMultipleValues");
//             function '.$fieldName.'_setMultipleValues(y,m,d) {
//                 if (m < 10) {
//                     m = \'0\'+m;
//                 }
//                 if (d < 10) {
//                     d = \'0\'+d;
//                 }
//                 dateBox= document.getElementById( \''.$textBox.'\' );
//                 dateBox.value=y+\'-\'+m+\'-\'+d;
//  
//                 }
//             '. $datelimit .'
//             </SCRIPT>';
//         echo '<DIV ID="'.$fieldName.'" STYLE="position:absolute;visibility:hidden;background-color:white;layer-background-color:white;"></DIV>';
//         echo '<A HREF="#" onClick="'.$calendarName.'.showCalendar(\''.$fieldName.'anchor1x\''.$popupDefault.'); return false;" TITLE="Choose Date" NAME="'.$fieldName.'anchor1x" ID="'.$fieldName.'anchor1x"><img src="./Images/cal.gif" border="0"></A>';
//         
        if ($isShowOneLine) {
            echo '</NOBR>';
        }
        
        $this->showErrorMessage( $errorMSG );
    }
    
    
    
    //************************************************************************
	/**
	 * function showDateList
	 * <pre>
	 * This method draws a set of listboxes for selecting dates.
	 * </pre>
	 * @param $fieldName [STRING] The common name of the listbox
	 * @param $defaultDate [STRING] The default value of this listbox
	 * @param $startYear [INTEGER] The beginning year
	 * @param $endYear [INTEGER] The ending year
	 * @return [void]
	 */
    function showDateList( $fieldName, $defaultDate, $errorMSG, $startYear, $endYear ) {
        
        if (($defaultDate != '') and ($defaultDate != '-----')) {
            list( $year, $month, $day) = explode( '-', $defaultDate);
            if (is_int($year) and is_int($month) and is_int($day)) {
                $popupDefault = ",'" . date('M d, Y', mktime(0, 0, 0, $month, $day, $year)) . "'";
                } else {
                    $popupDefault = '';
                }
        } else {
            $year = '';
            $month = '';
            $day = '';
            $popupDefault = '';
        }
        
         // Display Day List
        $this->showDayList( $fieldName.'_day', $day);
        
        // Display Month List
        $this->showMonthList( $fieldName.'_month', $month );
        
        // if start != endYear then
        if ( $startYear != $endYear ) {
        
           // Display Year List
           $this->showYearList( $fieldName.'_year', $year, $startYear, $endYear );
        } else {
        // else
        
            // just show year value as a hidden value
            echo '<input id= name="'.$fieldName.'_year'.'" type="hidden" value="'.$startYear.'" />';
            
        } // end if
        
        //Calender drop-down list
/*        $calendarName = $fieldName.'_cal';
        
        $datelimit = '';
        
        if ($startYear != '') {$datelimit .= $calendarName.'.addDisabledDates(null,"Jan 1, '. $startYear .'");';}
        if ($endYear != '') {$datelimit .= $calendarName.'.addDisabledDates("Dec 31, '. $endYear .'",null);';}
        
        
        
        echo '<SCRIPT LANGUAGE="JavaScript" ID="jscal1x_'.$fieldName.'" SRC="././Data/scripts/JScript/CalendarPopup.js">
            var '.$calendarName.' = new CalendarPopup("'.$fieldName.'");
            document.write(getCalendarStyles());
            '.$calendarName.'.showYearNavigation();
            '.$calendarName.'.showYearNavigationInput();
            '.$calendarName.'.setReturnFunction("'.$fieldName.'_setMultipleValues");
            function '.$fieldName.'_setMultipleValues(y,m,d) {
                if (m < 10) {
                    m = \'0\'+m;
                }
                if (d < 10) {
                    d = \'0\'+d;
                }
                yearPicker= document.getElementById( \''.$fieldName.'_year'.'\' );
                yearPicker.value=y;
                monthPicker = document.getElementById( \''.$fieldName.'_month'.'\' );
                monthPicker.value=m;
//                document.getElementById( \''.$fieldName.'_month'.'\' ).value=m;
                dayPicker = document.getElementById( \''.$fieldName.'_day'.'\' );
                dayPicker.value=d;
//                document.forms[0].'.$fieldName.'_year'.'.value=y;
//                document.forms[0].'.$fieldName.'_month'.'.value=m;
//                document.forms[0].'.$fieldName.'_day'.'.value=d;
                }
            '. $datelimit .'
            </SCRIPT>';

        echo '<DIV ID="'.$fieldName.'" STYLE="position:absolute;visibility:hidden;background-color:white;layer-background-color:white;"></DIV>';
        if ($this->disabled != "DISABLED") {
            echo '<A HREF="#" onClick="'.$calendarName.'.showCalendar(\''.$fieldName.'anchor1x\''.$popupDefault.'); return false;" TITLE="Choose Date" NAME="'.$fieldName.'anchor1x" ID="'.$fieldName.'anchor1x"><img src="./Images/cal.gif" border="0"></A>';
            } else {
            echo '<A HREF="#" onClick="" TITLE="Choose Date" NAME="'.$fieldName.'anchor1x" ID="'.$fieldName.'anchor1x"><img src="./Images/cal.gif" border="0"></A>';
            }

        //echo '<DIV ID="'.$fieldName.'" STYLE="position:absolute;visibility:hidden;background-color:white;layer-background-color:white;"></DIV>';
        //echo '<A HREF="#" onClick="'.$calendarName.'.showCalendar(\''.$fieldName.'anchor1x\''.$popupDefault.'); return false;" TITLE="Choose Date" NAME="'.$fieldName.'anchor1x" ID="'.$fieldName.'anchor1x"><img src="./Images/cal.gif" border="0"></A>';
*/     
        $this->showErrorMessage( $errorMSG );
    }
    
    
    
    //************************************************************************
	/**
	 * function showDayList
	 * <pre>
	 * This method draws a listbox of days.
	 * </pre>
	 * @param $fieldName [STRING] The name of the listbox
	 * @param $defaultDay [STRING] The default value of this listbox
	 * @return [void]
	 */
    function showDayList( $fieldName, $defaultDay ) {
        
        $this->showListByArray( $fieldName, $defaultDay, $this->listDays);
    }
    
    
    
    //************************************************************************
	/**
	 * function showErrorMessage
	 * <pre>
	 * display the error message if it exists.
	 * </pre>
	 * @param $errorMSG [STRING] Error message to display
	 * @return [void]
	 */
    function showErrorMessage( $errorMSG ) {
        
        if ($errorMSG != '') {
            echo '<br><span class="error">'.$errorMSG.'</span>';
        }
    }
    
    
    
    //************************************************************************
	/**
	 * function showGenderList
	 * <pre>
	 * This method draws a listbox of Genders.
	 * </pre>
	 * @param $fieldName [STRING] The name of the listbox
	 * @param $defaultValue [STRING] The default value of this listbox
	 * @return [void]
	 */
    function showGenderList( $fieldName, $defaultValue, $errorMSG ) {
        
        // if Gender Labels have not been loaded yet ...
        if ( $this->isGenderLabelsLoaded == false ) {
            
            // load gender labels
            $this->labels->loadPageLabels( SITE_LABEL_SERIES_SITE, SITE_LABEL_PAGE_LIST_GENDER);
            $this->isGenderLabelsLoaded = true;
        }
        
            
        $listGender[ 'F' ] = $this->labels->getLabel('[Female]');
        $listGender[ 'M' ] = $this->labels->getLabel('[Male]');
        
        $this->showListByArray( $fieldName, $defaultValue, $listGender);
        
        $this->showErrorMessage( $errorMSG );
    }
    
    
    
    //************************************************************************
	/**
	 * function showHidden
	 * <pre>
	 * This routine displays the data as a Hidden field on the page.
	 * </pre>
	 * @param $fieldName [STRING] The name of the listbox
	 * @param $defaultValue [STRING] The default value of this listbox
	 * @return [void]
	 */
    function showHidden( $fieldName, $defaultValue ) {
        
        echo '<input type="hidden" name="'.$fieldName.'" value="'.$defaultValue.'" >';
    }
    
    
    
    //************************************************************************
	/**
	 * function showJumpListByArray
	 * <pre>
	 * This routine draws a listbox using a provided array for the options.
	 * </pre>
	 * @param $fieldName [STRING] The name of the listbox
	 * @param $defaultValue [STRING] The default value of this listbox
	 * @param $optionList [ARRAY] An array( $val=>$label, $val=>label) of the
	 * options for this list.
	 * @return [void]
	 */
    function showJumpListByArray( $fieldName, $defaultValue, $optionList, $showDashOption=true ) {

        echo '<select name="'.$fieldName.'" onchange="MM_jumpMenu(\'parent\',this,1)">';
        if ( $showDashOption )
        {
	        // takes the base URL and tacks on a (hopefully) invalid ID to force reset to '-'
            echo '<option value="'.$defaultValue.'-1">-</option>';	//HSMIT NOV 16 - not sure if $defaultValue always works...
        }
        foreach($optionList as $value=>$label) {
        
           if ($defaultValue == $value) {
           
                echo '<option value="'.$value.'" selected>'.$label.'</option>';
                
           } else {
                echo '<option value="'.$value.'">'.$label.'</option>';
           }
           
        }
        echo '</select>';
    }
    
    
    
    //************************************************************************
	/**
	 * function showLabel
	 * <pre>
	 * This routine displays the data as a label on the page.
	 * </pre>
	 * @param $fieldName [STRING] The name of the listbox
	 * @param $defaultValue [STRING] The default value of this listbox
	 * @param $optionList [ARRAY] An array( $val=>$label, $val=>label) of the
	 * options for this list.
	 * @return [void]
	 */
    function showLabel( $defaultValue, $listData ) {
        
        // if an array is given then
        if ( (is_array($listData) ) && ( count($listData) > 0) ) {
        
            // assume defaultValue is the index into the array
            echo $listData[ (int) $defaultValue ];
            
        } else {
        // else
            // just print the value
            echo $defaultValue;
        }
    }
        
    
    //************************************************************************
	/**
	 * function showListByArray
	 * <pre>
	 * This routine draws a listbox using a provided array for the options.
	 * </pre>
	 * @param $fieldName [STRING] The name of the listbox
	 * @param $defaultValue [STRING] The default value of this listbox
	 * @param $optionList [ARRAY] An array( $val=>$label, $val=>label) of the
	 * @param $script [STRING] This is a string of arbituary script that you need to add into the text box. eg. javascript code
	 * @param $allowMultiple [BOOLEAN] Indicates whether multiple selection is allowed
	 * options for this list.
	 * @return [void]
	 */
    function showListByArray( $fieldName, $defaultValue, $optionList, $script='', $allowMultiple=false, $numItemsToShow = '5', $disabled = false) {
        
// 	     $DISPLAY_TOTAL_ITEMS = 5;	//count($optionList);		// show all the elements in the list
		  $defaultValues = explode(',',$defaultValue);

	     $multiOption = '';
	     $sizeOption = '';
	     $brackets = '';
	     $disable_string = "";
	     if ($allowMultiple == true)
	     {	
		     // it's no use to display empty fields in combo-list...
		     $optionCount = count($optionList);
		     if ($optionCount < $numItemsToShow)
		     {
			  		$numItemsToShow = $optionCount;
		  	  }
		  	  
		     $multiOption = 'multiple';
		     $sizeOption = 'size="'.$numItemsToShow.'"';		//"'.$DISPLAY_TOTAL_ITEMS."'";
 		     $brackets = '[]';
	     }
	     

        echo '<select '.$multiOption.' '.$sizeOption.' id="'.$fieldName.'" name="'.$fieldName.''.$brackets.'" '.$script. ' ' . $this->disabled. '>';

	     // Disable all but possibly one item in the listbox
	     if ($disabled == true)
	     {
		     $disable_string = "DISABLED";
	     }        
        
        if ($allowMultiple == false)
        {
        		echo '<option value="-">-</option>';		// do NOT have this value if combo-list is being created
	     }
	     
        foreach($optionList as $value=>$label) {
     
	           if (in_array($value,$defaultValues)) {				// ($defaultValue == $value)
	           
	                echo '<option value="'.$value.'" selected >'.$label.'</option>';
	                
	           } else {
	                echo '<option value="'.$value.'" '.$disable_string.' >'.$label.'</option>';
	           }

        }
        echo ' </select>';
    }
    
    
    
    //************************************************************************
	/**
	 * function showDynListByArray
	 * <pre>
	 * This routine draws a listbox using a provided array for the options.
	 * Additionally, it sets the values of another droplist based on the selected option.
	 * </pre>
	 * @param $fieldName [STRING] The name of the listbox
	 * @param $defaultValue [STRING] The default value of this listbox
	 * @param $optionList [ARRAY] An array( $val=>$label, $val=>label) of the
	 * @param $numItemsToShow [INTEGER] The max number of list items to show at once
	 * @param $targetFieldName [STRING] The ID of the drop-list that will be changed by this drop-list
//	 * @param $replacementValues [STRING] The reference to the template variable storing an array of arrays keyed to the values in this drop-list;
	 *                                   The target droplist will be populated with array associated with this drop-list's selected value
	 * @return [void]
	 */
    function showDynListByArray( $fieldName, $defaultValue, $optionList, $numItemsToShow = '5', $targetFieldName, $subValuesVar ) {
	  
	    // script for limiting other droplist values using this one: 
	    $script = 'onchange="MM_changeOtherMenu($fieldName,$replacementValues,'.$subValuesVar.')"';
	    $this->showListByArray( $fieldName, $defaultValue, $optionList, $script, $allowMultiple=false, $numItemsToShow = '5' );
    }

    
    
    //************************************************************************
	/**
	 * function showMonthList
	 * <pre>
	 * This method draws a listbox of months.
	 * </pre>
	 * @param $fieldName [STRING] The name of the listbox
	 * @param $defaultMonth [STRING] The default value of this listbox
	 * @param $monthList   [STRING] comma delimited list of months for list
	 * @return [void]
	 */
    function showMonthList( $fieldName, $defaultMonth, $monthList='' ) {
        
        if ($this->isMonthLabelsLoaded == false) {
        
            $this->labels->loadPageLabels( SITE_LABEL_SERIES_SITE, SITE_LABEL_PAGE_LIST_MONTHS);
            
            /*
             * Prepare the list of Months.
             */
            $monthValues = explode( ',', TemplateTools::TEMPLATE_LIST_MONTH );
            
            if ($monthList == '') {
                $monthList = TemplateTools::TEMPLATE_LIST_MONTH_ALLOWED;
            }
            $allowedMonths = explode( ',', $monthList);
           
            for ($indx=0; $indx<count($monthValues); $indx++) {
            
                $values = explode( '=', $monthValues[ $indx ]);
                
                // if month is in list of allowed months then
                if ( in_array($values[0], $allowedMonths) ) {
                    $this->listMonths[ $values[1]] = $this->labels->getLabel( '['.$values[0].']' );
                }
                
            }
            
            $this->isMonthLabelsLoaded = true;
        } 
        
        $this->showListByArray( $fieldName, $defaultMonth, $this->listMonths);
    }
    
    
    
    //************************************************************************
	/**
	 * function showPasswordBox
	 * <pre>
	 * This method draws a password box.
	 * </pre>
	 * @param $fieldName [STRING] The name of the password box
	 * @param $defaultValue [STRING] The default value of this password box
	 * @param $errorMSG [STRING] Error message associated with this password box
	 * @return [void]
	 */
    function showPasswordBox( $fieldName, $defaultValue, $errorMSG='', $width='' ) {
    
        $sizeWidth = '';
        if ($width != '' ) {
            $sizeWidth = ' size="'.$width.'" ';
        }
        echo '<input type="password" name="'.$fieldName.'" value="'.$defaultValue.'"   '.$sizeWidth.' ' . $this->disabled . '/>';
        
        $this->showErrorMessage( $errorMSG );
        
    }
    
    
    
    
    //************************************************************************
	/**
	 * function showRadioButton
	 * <pre>
	 * This method draws a radio button.
	 * </pre>
	 * @param $fieldName [STRING] The name of the textbox
	 * @param $value [STRING] The value of this textbox
	 * @param $defaultValue [STRING] The default value of this field
	 * @param $errorMSG [STRING] Error message associated with this textbox
	 * @return [void]
	 */
    function showRadioButton( $fieldName, $value, $defaultValue, $errorMSG='' ) {
    
        $checked = '';
        if ($value == $defaultValue) {
            $checked = 'checked';
        }
        
        echo '<input type="radio" name="'.$fieldName.'" value="'.$value.'" '.$checked.' ' . $this->disabled . '/>';

        $this->showErrorMessage( $errorMSG );
        
    }
    
    
    
    //************************************************************************
	/**
	 * function showTextArea
	 * <pre>
	 * This method draws a textarea.
	 * </pre>
	 * @param $fieldName [STRING] The name of the textbox
	 * @param $defaultValue [STRING] The default value of this textbox
	 * @param $errorMSG [STRING] Error message associated with this textbox
	 * @param $numCols [INTEGER] Number of columns
	 * @param $numRows [INTEGER] Number of rows
	 * @return [void]
	 */
    function showTextArea( $fieldName, $defaultValue, $errorMSG='', $numCols=40, $numRows=5 ) {
    
        echo '<textarea name="'.$fieldName.'" cols="'.$numCols.'" rows="'.$numRows.'" ' . $this->disabled . ' >'.$defaultValue.'</textarea>';
        
        $this->showErrorMessage( $errorMSG );
        
    }
    
    
    
    //************************************************************************
	/**
	 * function showTextBox
	 * <pre>
	 * This method draws a textbox.
	 * </pre>
	 * @param $fieldName [STRING] The name of the textbox
	 * @param $defaultValue [STRING] The default value of this textbox
	 * @param $errorMSG [STRING] Error message associated with this textbox
	 * @param $width [INTEGER] How wide should the textbox be?
	 * @param $script [STRING] This is a string containing any additional scripts that you need to attach to the textbox. eg. javascript
	 * @return [void]
	 */
    function showTextBox( $fieldName, $defaultValue, $errorMSG='', $width='',$script='', $length='', $isReadOnly=false, $style='') {
    
        $defaultValue = str_replace( '"', '&quot;', $defaultValue);
        $sizeWidth = '';
        if ($width != '' ) {
            $sizeWidth = ' size="'.$width.'" ';
        }
        
        // added by HSMIT on 01 Sept 07
        $maxLength = '';
        if ($length != '')
        {
	        $maxLength = ' maxlength="'.$length.'" ';
        }
        
        $readOnly = '';
        if (!$this->disabled == 'DISABLED')
        {
	        if ($isReadOnly == true)
	        {
		        $readOnly = 'READONLY';
	        }
        }

        echo '<input type="text" id="'.$fieldName.'" name="'.$fieldName.'" '.$style.' value="'.$defaultValue.'"   '.$sizeWidth.' '.$maxLength.' '.$script.' ' . $this->disabled . $readOnly . '/>';

        $this->showErrorMessage( $errorMSG );
        
    }
    
    
    
    
    //************************************************************************
	/**
	 * function showTimeList
	 * <pre>
	 * This method draws a set of listboxes for selecting times.
	 * </pre>
	 * @param $fieldName [STRING] The common name of the listbox
	 * @param $defaultTime [STRING] The default value of this listbox
	 * @param $minuteIncrement [INTEGER] The increment for each minute entry
	 * @param $is24Hour [BOOL] Show 24 hour format?
	 * @return [void]
	 */
    function showTimeList( $fieldName, $defaultTime, $errorMSG='', $minuteIncrement=5, $is24Hour=true ) {
    
        if ($defaultTime != '') {
          
            $times = explode( ':', $defaultTime);
            if ( trim( $times[0]) != '' ) {
                $defaultHour = $times[0];
            } else {
                $defaultHour = '-';
            }
            if (isset( $times[1] )) {
                $defaultMinute = $times[1];
            } else {
                $defaultMinute = '-';
            }
            if (isset( $times[2] ) ) {
                $defaultSecond = $times[2];
            } else {
                $defaultSecond = '-';
            }
            
            $defaultHour = (int) $defaultHour;
            
             // if 24 hour format then
            if ($is24Hour) {
                $hourLimit = 23;
            } else {
                $hourLimit = 12;
                
                // now adjust hour and ampm values
                $defaultAMPM = 'am';
                
                // 12:00 - 23:00 = 12:00 pm - 11:00 pm
                if ( $defaultHour >= 12 ) {
                    $defaultAMPM = 'pm';
                }
                
                // 13:00 = 1:00 pm
                if ($defaultHour > 12 ) {
                    $defaultHour -= 12;
                }
                
                // 00:00 = 12:00 am
                if ($defaultHour == 0) {
                    $defaultHour = 12;
                }
                
            }
            
        } else {
        
            if ($is24Hour) {
                $hourLimit = 23;
            } else {
                $hourLimit = 12;
            }
            $defaultHour = '-';
            $defaultMinute= '-';
            $defaultAMPM = '-';
            $defaultSecond = '00';
        } // end if defaultTime not empty
        
        for( $indx=0; $indx<=$hourLimit; $indx++) {
            $value = sprintf( '%02d', $indx);
            $hourList[ $value ] = $value;
        }
        $this->showListByArray( $fieldName.'_hour', $defaultHour, $hourList);
        
        // create minute list
        for( $indx=0; $indx<60; $indx += $minuteIncrement ) {
            $value = sprintf( '%02d', $indx);
            $minuteList[ $value ] = $value;
        }
        $this->showListByArray( $fieldName.'_min', $defaultMinute, $minuteList);
        
        
        // if not a 24 hour format then show am/pm selection
        if ($is24Hour == false ) {
            
            $listAmPm[ 'am' ] = 'am';
            $listAmPm[ 'pm' ] = 'pm';
            $this->showListByArray( $fieldName.'_ampm', $defaultAMPM, $listAmPm);
            
        }
        $this->showErrorMessage( $errorMSG );
    }
    
    
    
    //************************************************************************
	/**
	 * function showYearList
	 * <pre>
	 * This method draws a listbox of Years.
	 * </pre>
	 * @param $fieldName [STRING] The name of the listbox
	 * @param $defaultYear [STRING] The default value of this listbox
	 * @param $startYear [INTEGER] The beginning year
	 * @param $endYear [INTEGER] The ending year
	 * @return [void]
	 */
    function showYearList( $fieldName, $defaultYear, $startYear, $endYear ) {
        
        for( $indx=$startYear; $indx<=$endYear; $indx++) {
            $listYears[$indx] = $indx;
        }
        $this->showListByArray( $fieldName, $defaultYear, $listYears);
    }
    
    
    
    //************************************************************************
	/**
	 * function showYesNoList
	 * <pre>
	 * This method draws a listbox of Genders.
	 * </pre>
	 * @param $fieldName [STRING] The name of the listbox
	 * @param $defaultValue [STRING] The default value of this listbox
	 * @return [void]
	 */
    function showYesNoList( $fieldName, $defaultValue, $errorMSG ) {
        
        // if Gender Labels have not been loaded yet ...
        if ( $this->isYesNoLabelsLoaded == false ) {
            
            // load gender labels
            $this->labels->loadPageLabels( SITE_LABEL_SERIES_SITE, SITE_LABEL_PAGE_LIST_YESNO);
            $this->isYesNoLabelsLoaded = true;
        }
        
            
        $list[ 'N' ] = $this->labels->getLabel('[no]');
        $list[ 'Y' ] = $this->labels->getLabel('[yes]');
        
        $this->showListByArray( $fieldName, $defaultValue, $list);
        
        $this->showErrorMessage( $errorMSG );
    }
    
    
    
    //************************************************************************
	/**
	 * function swapBGColor
	 * <pre>
	 * Toggles the current color entry.
	 * </pre>
	 * @param $currentColor [STRING] Current Value of the color entry
	 * @return [STRING]
	 */
    function swapBGColor( &$currentColor) 
    {
        // NOTE: we are expecting current color to hold the full parameter for
        // the background color.  Setting it to '' effectively makes it the 
        // default off color.  Setting it to a value makes it the on color.
        if ($currentColor == 'bgcolor="EEEEEE"') {
            $currentColor = '';
        } else {
            $currentColor = 'bgcolor="EEEEEE"';
        }
    }
    
    
        // Returns html for the given form item  (added from register.ciministry.com's PageFunctions on July 11, 2007 by HSMIT)
    //
    // $itemType: the type of html control to display
    //      allowable types include:
    //          - textbox
    //          - droplist
    //          - checkbox
    //          - textarea
    // $fieldName: the name to give the form's field
    // $listArray: used to populate droplists types
    //      key: value to be submited with the form
    //      value: text to be displayed to user
    //
    function drawFormHTML( $itemType, $fieldName, $fieldValue, $itemError, $listArray )
    {
        
        if ( $itemType == 'textbox' )
        {
            echo '<input type="text" name="'.$fieldName.'" value="'.$fieldValue.'" />';
        }
        else if ( $itemType == 'textbox_ro' )	// HSMIT: added read-only textbox
        {
            echo '<input type="text" name="'.$fieldName.'" value="'.$fieldValue.'" readonly />';
        }	        
        else if ( $itemType == 'password' )
        {
            echo '<input type="password" name="'.$fieldName.'" value="'.$fieldValue.'" />';
        }
        else if ( $itemType == 'droplist' )
        {
            // echo 'the default value is ['.$fieldValue.'] ['.$fieldName.']<br/>';
        
            // create the drop down list
            echo '<select id="'.$fieldName.'" name="'.$fieldName.'">';
            
            // blank option
            echo '<option value="-">-</option>';
            
            // output the list as 'options' in the droplist
            foreach( $listArray as $key=>$value )
            {
                if ( $fieldValue == $key) 
                {           
                    echo '<option value="'.$key.'" selected>'.$value.'</option>';
                } 
                else 
                {
                    echo '<option value="'.$key.'">'.$value.'</option>';
                }
            }
            echo '</select>';
        }
        else if ( $itemType == 'list_ro' )
        {
            // echo 'the default value is ['.$fieldValue.'] ['.$fieldName.']<br/>';
        
            // create the drop down list
            echo '<select id="'.$fieldName.'" name="'.$fieldName.'">';
            
            // blank option
            echo '<option value="-">-</option>';
            
            // output the list as 'options' in the droplist
            foreach( $listArray as $key=>$value )
            {
                if ( $fieldValue == $key) 
                {           
                    echo '<option value="'.$key.'" selected>'.$value.'</option>';
                } 
                else 
                {
                    echo '<option value="'.$key.'" disabled>'.$value.'</option>';
                }
            }
            echo '</select>';
        }	        
        else if ( $itemType == 'checkbox' )
        {
            // TODO - use the field value to set the checkbox's value
            $checked = '';
            if ($fieldValue == 1 ) {
                $checked = 'checked';
            }
            echo '<input type="checkbox" name="'.$fieldName.'" value="1'./*$fieldValue.*/'" '.$checked.'  />';
        }
        else if ( $itemType == 'textarea' )
        {
            echo '<textarea name="'.$fieldName.'" cols="40" rows="5">'.$fieldValue.'</textarea>';
        }
        else if ( $itemType == 'hidden' )
        {
            echo '<input name="'.$fieldName.'" type="hidden" id="" value="'.$fieldValue.'" />';
        }
        else
        {
            echo '<input type="text" name="'.$fieldName.'" value="UNKNOWN FIELD TYPE" />';
        }
        
        // display error text, if any
        if ($itemError != '') 
        {
            echo '<br><span class="error">'.$itemError.'</span>';
        }
        
    }
	
}

?>