<?php
/**
 * @package AIobjects
 */ 
/**
 * class PageDisplay_FormProcessor
 * <pre> 
 * This object manages the generic page data handling for a FormProcessor 
 * style of page.  This object provides automatic form loading, basic data 
 * validation, and template loading for pages with form data. 
 * </pre>
 * @author Johnny Hausman
 */
class  PageDisplay_FormProcessor extends PageDisplay {

	//CONSTANTS:

	//VARIABLES:

    /** @var [ARRAY] list of fields for this form. */
	protected $formFields;
	
    /** @var [STRING] The action the form should take. */
	protected $formAction;
	
	/** @var [ARRAY] the type of each field for this form */
	protected $formFieldTypes;
	
    /** @var [STRING] The field types for each of the form Fields. */
	protected $formFieldDisplayTypes;
	
	/** @var [ARRAY] list of invalid values for each field of this form. */
	protected $formFieldInvalid;
	
	protected $formFieldRequired;
	
	/** @var [ARRAY] the form values  */
	protected $formValues;
	
	/** @var [ARRAY] the form errors */
	protected $formErrors;
	
	/** @var [OBJECT] The data manager object. */
	protected $dataManager;


	//CLASS CONSTRUCTOR
	//************************************************************************
	/**
	 * function __construct
	 * <pre>
	 * Initialize the PageDisplay Object.
	 * </pre>
	 * @param $formAction [STRING] The action on a form submit
	 * @param $fieldList [STRING] The list of form fields to work with
	 * @param $fieldDisplayTypes [STRING] The list of form field Types
	 * @return [void]
	 */
    function __construct( $formAction, $fieldList, $fieldDisplayTypes ) 
    {
        // call the PageDisplay object's constructor
        parent::__construct();
        
        /*
         * initializing the Page's form variables
         */
        $this->formAction = $formAction;
        $this->formFieldDisplayTypes = $fieldDisplayTypes;

        
        // if a field list was provided then
        if ( $fieldList != '' ) {
        
            // for each field item
            $items = explode( ',', $fieldList );
            for( $indx=0; $indx<count($items); $indx++) {
            
                // break item into it's parts: key,type,invalid value
                list($fieldKey, $fieldType, $fieldInvalid) = explode('|', $items[$indx]);
                
                // store in arrays ...
                $this->formFields[] = $fieldKey;
                $this->formFieldTypes[ $fieldKey ] = $fieldType;
                $this->formFieldInvalid[ $fieldKey] = $fieldInvalid;
                $this->formFieldRequired[ $fieldKey] = substr($fieldInvalid,1,-1);
                $this->formErrors[ $fieldKey ] = '';
                
            } // next item
            
            
        } else {
        // else
            
            // initialize all arrays to empty
            $this->formFields = array();
            $this->formFieldTypes = array();
            $this->formFieldInvalid = array();
            $this->formErrors = array();
            
        }
        
        $this->formValues = array();
        
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
    
    
    
    //************************************************************************
	/**
	 * function getFieldErrorLabel
	 * <pre>
	 * Returns an error label.
	 * </pre>
	 * @param $labelKey [STRING] The label Key for this error message.
	 * @param $fieldType [STRING] The type of field this value came from
	 * @return [STRING]
	 */
    function getFieldErrorLabel( $labelKey, $fieldType ) 
    {
        // check for a label based upon the given labelKey
        $errorKey = '[error_'.$labelKey.']';
        $errorLabel = $this->labels->getLabel( $errorKey );
        
        // if the key matches the label then the label didn't exist
        if ($errorKey == $errorLabel) {
        
            // pull generic error label based upon given field type
            $errorLabel = $this->labels->getLabel( '[error_'.$fieldType.']');
        }
        
        return $errorLabel;
        
    } // end getFieldErrorLabel()
    
    
    
    //************************************************************************
	/**
	 * function getID
	 * <pre>
	 * Returns the ID of the dataManager.  Useful after processing an Add type
	 * of form to get the ID of the row just added, so the next Page can use
	 * it.
	 * </pre>
	 * @return [INTEGER]
	 */
    function getID() 
    {
        return $this->dataManager->getID();   
    } 
    
    
    
    //************************************************************************
	/**
	 * function getDateValue
	 * <pre>
	 * Returns the form value of a date field.
	 * </pre>
	 * @param $key [STRING] the field key for this date value
	 * @return [STRING]
	 */
    function getDateValue( $key ) 
    {
    
        if ( isset($_REQUEST[ $key.'_day' ]) ) {
            $day = $_REQUEST[ $key.'_day' ];
        } else {
            $day = '-';
        }
        if ( isset($_REQUEST[ $key.'_month' ]) ) {
            $month = $_REQUEST[ $key.'_month' ];
        } else {
            $month = '-';
        }
        if ( isset($_REQUEST[ $key.'_year' ]) ) {
            $year = $_REQUEST[ $key.'_year' ];
        } else {
            $year = '-';
        }
        
        return $year.'-'.$month.'-'.$day;

    } 
    
    
    
    //************************************************************************
	/**
	 * function getTimeValue
	 * <pre>
	 * Returns the form value of a time field.
	 * </pre>
	 * @param $key [STRING] the field key for this time value
	 * @return [STRING]
	 */
    function getTimeValue( $key ) 
    {
    
        // On a Time type, make sure to read in the seperate 
        // Hour & Minute values and put that together as a
        // single value.
        
        if ( isset($_REQUEST[ $key.'_hour' ]) ) {
            $hour = $_REQUEST[ $key.'_hour' ];
        } else {
            $hour = '-';
        }
        if ( isset($_REQUEST[ $key.'_min' ]) ) {
            $minute = $_REQUEST[ $key.'_min' ];
        } else {
            $minute = '-';
        }
        
        if ( isset($_REQUEST[ $key.'_sec' ]) ) {
            $second = $_REQUEST[ $key.'_sec' ];
        } else {
            
            // we commonly don't ask for seconds on forms, so 
            // assume a valid 00 if none present.
            $second = '00';
        }
        
        // NOTE: if an ampm value was returned, then time
        // was given in 12 hour format.  We need to convert to
        // 24 hour format.
        if ( isset($_REQUEST[ $key.'_ampm' ]) ) {
            $amPM = $_REQUEST[ $key.'_ampm' ];
            if ($amPM == 'am' ) {
            
                if ($hour == '12') {
                    // 12:00 am  == 00:00 in 24 hour format
                    $hour = '00';
                }
            
            } else {
            
                // 12:00 pm == 12:00 in 24 hour format
                if ($hour != '12') {
                    
                    // all other values should have +12 
                    // eg. 1:00 pm == 13:00 
                    $hour = (int) $hour + 12;
                }
            }
        }   
                         
        return $hour.':'.$minute.':'.$second;

    } 
    
    
    
    //************************************************************************
	/**
	 * function isDataValid
	 * <pre>
	 * Verifies the returned data is valid.
	 * </pre>
	  * @param $fieldKeyModifier [STRING] modifies the formField name & key.
	 * @return [BOOL]
	 */
    function isDataValid( $fieldKeyModifier='' ) 
    {
    
        // NOTE:  In this routine we start by assuming TRUE for isValid.
        // as you go through the routines to check, be sure to only set
        // isValid to FALSE when the conditions apply ... don't set it
        // back to true on any condition ...
        $isValid = true;
       
        $this->labels->loadPageLabels( SITE_LABEL_SERIES_SITE, SITE_LABEL_PAGE_FORMERRORS );
        
        // for each of this object's field of interest ...
        for( $indx=0; $indx<count($this->formFields); $indx++) {
        
            $fieldKey = $this->formFields[$indx].$fieldKeyModifier;
            
            switch( $this->formFieldTypes[ $this->formFields[$indx] ] ) {
    
                case 'D':
                
                    if ($this->formFieldInvalid[ $this->formFields[$indx] ] != '<skip>' ) {
                    
                        // make sure this is a valid date
                        list($year, $month, $day) = explode( '-', $this->formValues[ $fieldKey ]);
                        
                        // if a given value is empty then
                        if (($year == '') || ($month == '') || ($day=='')) {
                        
                            // a field was left unselected.
                            $isValid = false;
                            $errorLabel = $this->getFieldErrorLabel( $fieldKey, $this->formFieldTypes[ $this->formFields[$indx] ]);
                            $this->formErrors[ $fieldKey ] = $errorLabel;
                                
                        } else {
                        // else
                        
                            // if date is invalid then
                            if ( checkdate( (int) $month, (int) $day, (int) $year) == false ) {
                            
                                $isValid = false;
                                $errorLabel = $this->getFieldErrorLabel( $fieldKey.'_invalid', $this->formFieldTypes[ $this->formFields[$indx] ].'_invalid');
                                $this->formErrors[ $fieldKey ] = $errorLabel;
                                
                            }
                            
                        } // end if
                    }
                    break;
                    
                    
                case 'Time':
                    if ($this->formFieldInvalid[ $this->formFields[$indx] ] != '<skip>' ) {
                        // make sure this is a valid time
                        list($hour, $minute, $second) = explode( ':', $this->formValues[ $fieldKey ]);
                        
                        // if a given value is empty then
                        if (($hour == '-') || ($minute == '-')) {
                        
                            // a field was left unselected.
                            $isValid = false;
                            $errorLabel = $this->getFieldErrorLabel( $fieldKey, $this->formFieldTypes[ $this->formFields[$indx] ]);
                            $this->formErrors[ $fieldKey ] = $errorLabel;
                                
                        } // end if value is empty
                    }
                    break;
                    
                case 'C':
                    // Checkboxes are either checked or not.  We should not have
                    // to validate their data. 
                    break;
                    
                 case 'N':
                    // Numeric Data. Verify that provided data is actually 
                    // numeric ...
                    
                    // if this is not a skip entry ...
                    if ($this->formFieldInvalid[ $this->formFields[$indx] ] != '<skip>' ) {
                        
                        
                        // if that field has been provided 
                        if (isset( $this->formValues[ $fieldKey ] ) ) {
                        
                            if ( !is_numeric( $this->formValues[ $fieldKey ] ) ) {
                            
                                $isValid = false;
                                $errorLabel = $this->getFieldErrorLabel( $fieldKey, $this->formFieldTypes[ $this->formFields[$indx] ]);
                                $this->formErrors[ $fieldKey ] = $errorLabel;                                
                            }
                            
     
                            // if currentValue == inValidValue
                            if ( $this->formValues[ $fieldKey ] == $this->formFieldInvalid[ $this->formFields[$indx] ]) {
                            
                                // mark field as invalid 
                                $isValid = false;
                                $errorLabel = $this->getFieldErrorLabel( $fieldKey, $this->formFieldTypes[ $this->formFields[$indx] ]);
                                $this->formErrors[ $fieldKey ] = $errorLabel;
                            }                           
                            
                            
                        } else {
                        
                            $isValid = false;
                        }
                        
                    } // end if ! skip entry
                    
                    break;
                case 'Z':
                    // Numberic Data, greater than or equal to zero
                    
                    // if this is not a skip entry ...
                    if ($this->formFieldInvalid[ $this->formFields[$indx] ] != '<skip>' ) {
                        
                        // if that field has been provided 
                        if (isset( $this->formValues[ $fieldKey ] ) ) {
                        
                            if ( !is_numeric( $this->formValues[ $fieldKey ] ) || !( $this->formValues[ $fieldKey ] >= 0  ) ) 
                            {
                            
                                $isValid = false;
                                $errorLabel = $this->getFieldErrorLabel( $fieldKey, $this->formFieldTypes[ $this->formFields[$indx] ]);
                                $this->formErrors[ $fieldKey ] = $errorLabel;
                                
                            }
                        } else {
                        
                            $isValid = false;
                        }
                        
                    } // end if ! skip entry
                    
                    break;
                    
                case 'B':
                
                    // if this is not a skip entry ...
                    if ($this->formFieldInvalid[ $this->formFields[$indx] ] != '<skip>' ) {
                        
                        // if that field has been provided 
                        if (isset( $this->formValues[ $fieldKey ] ) ) {
                        
                            if ( !is_numeric( $this->formValues[ $fieldKey ] ) || ( ( $this->formValues[ $fieldKey ] != 0 ) && ( $this->formValues[ $fieldKey ] != 1 ) ) ) 
                            {
                            
                                $isValid = false;
                                $errorLabel = $this->getFieldErrorLabel( $fieldKey, $this->formFieldTypes[ $this->formFields[$indx] ]);
                                $this->formErrors[ $fieldKey ] = $errorLabel;
                                
                            }
                        } else {
                        
                            $isValid = false;
                        }
                        
                    } // end if ! skip entry
                    
                    break;
                    
               case 'E':
                     // this makes sure the data is an email address that is properly formatted.
                
                    // if this is not a skip entry ...
                    if ($this->formFieldInvalid[ $this->formFields[$indx] ] != '<skip>' ) {
                        
                        // if that field has been provided 
                        if (isset( $this->formValues[ $fieldKey ] ) ) {
                        
                           $email = $this->formValues[ $fieldKey ];
                        
                           if(!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $email) )
                           {
                              // echo "The e-mail was not valid";
                              $isValid = false;
                              $errorLabel = $this->getFieldErrorLabel( $fieldKey, $this->formFieldTypes[ $this->formFields[$indx] ]);
                              $this->formErrors[ $fieldKey ] = $errorLabel;
                           } 
                           else 
                           {
                              // echo "The e-mail was valid";
                              $isValid = true;
                           }

                        } else {
                        
                            $isValid = false;
                        }
                        
                    } // end if ! skip entry
                    
                    break;
                    
            
                default:

                    // if this is not a skip entry ...
                    if ($this->formFieldInvalid[ $this->formFields[$indx] ] != '<skip>' ) {
	                    

                        // if that field has been provided 
                        if (isset( $this->formValues[ $fieldKey ] ) ) {
    
                            // if currentValue == inValidValue
                            if ( $this->formValues[ $fieldKey ] == $this->formFieldInvalid[ $this->formFields[$indx] ]) {
                            
                                // mark field as invalid 
                                $isValid = false;
                                $errorLabel = $this->getFieldErrorLabel( $fieldKey, $this->formFieldTypes[ $this->formFields[$indx] ]);
                                $this->formErrors[ $fieldKey ] = $errorLabel;
                            }
                            
                        } else {
                            
                            // mark field as invalid since it wasn't there ...
                            $isValid = false;
                            $errorLabel = $this->getFieldErrorLabel('not_found', 'not_found');
                            $this->formErrors[ $fieldKey ] = $errorLabel;
                        }
                        
                    } // end if not skip
                    
                    
                    break;
            
            } // end switch
            
            // echo 'The $fieldKey['.$fieldKey.'] isValid['.$isValid.']<br/>';
            
        } // next field
        
        // now return result
        return $isValid;
        
    }  // end isDataValid()
    
    
    
    //************************************************************************
	/**
	 * function loadFromForm
	 * <pre>
	 * Loads the data from the submitted form.
	 * </pre>
	 * @param $fieldKeyModifier [STRING] modifies the formFields key
	 * @return [returnValue, can be void]
	 */
    function loadFromForm( $fieldKeyModifier='' ) 
    {
        // echo print_r($_REQUEST);
        // echo 'form display types: <pre>'.print_r($this->formFieldDisplayTypes,true).'</pre>';
        // echo 'Inside loadFromForm<br/>';
        // echo '<pre>'.print_r($this->formValues,true).'</pre>';
        //echo 'form fields: <pre>'.print_r($this->formFields,true).'</pre>';
        
        $displayTypeArray = array_combine( $this->formFields, explode(',', $this->formFieldDisplayTypes ) );
        // print_r($displayTypeArray);
        
        // for each form field ..
        for( $indx=0; $indx<count($this->formFields); $indx++) {
        
            $key = $this->formFields[$indx].$fieldKeyModifier;
            // echo 'key['.$key.']<br/>';
            
            switch( $this->formFieldTypes[ $this->formFields[$indx] ] ) {
            
                case 'B':
                // Boolean Types are set to false (0 since DB Table is 
                // most likely an INTEGER) if not found..
                
                    if ( isset($_REQUEST[ $key ]) ) {
                        $this->formValues[ $key ] = $_REQUEST[ $key ];
                    } else {
                        $this->formValues[ $key ] = '0';
                    }
                    break;
            
                
                case 'D':
                // On a Date type, make sure to read in the seperate 
                // day,month,year values and put that together as a
                // single value.
                
                    if (  $displayTypeArray[$key] == 'hidden' )
                    {
                        $this->formValues[ $key ] = $_REQUEST[ $key ];
                    }
                    else
                    {
                        $this->formValues[ $key ] = $this->getDateValue($key);
                    }
                    break;
                    
                case 'Time':
                // On a Time type, make sure to read in the seperate 
                // Hour & Minute values and put that together as a
                // single value. 
                    if (  $displayTypeArray[$key] == 'hidden' )
                    {
                        $this->formValues[ $key ] = $_REQUEST[ $key ];
                    } 
                    else 
                    {     
                        $this->formValues[ $key ] = $this->getTimeValue( $key );
                    }
                    break;
                    
                case 'DateTime':
                // On a Date Time picker, pull in each value seperatly and
                // piece together. 
                    if (  $displayTypeArray[$key] == 'hidden' )
                    {
                        $this->formValues[ $key ] = $_REQUEST[ $key ];
                    } 
                    else 
                    {     
                        $dateValue = $this->getDateValue( $key );
                        $timeValue = $this->getTimeValue( $key );
                        
                        $this->formValues[ $key ] = $dateValue. ' ' . $timeValue;
                    }
                    break;
            
                default:
                    // if found in form return data ..
                    if ( isset($_REQUEST[ $key ] ) ) {
                    
                        // save in form values
                        $this->formValues[ $key ] = $_REQUEST[ $key ];
                        
                    } else {
                    
                        // set formValues to default Invalid value
                        $this->formValues[ $key ] = $this->formFieldInvalid[ $this->formFields[$indx] ];
                
                    } // end if found
                    break;
                    
            }  // end switch
        
        } // next field 
        
        // echo 'END of loadFromForm<br/>';
        // echo '<pre>'.print_r($this->formValues,true).'</pre>';
        
    } // end loadFromForm()
    
    
    
    //************************************************************************
	/**
	 * function prepareTemplate
	 * <pre>
	 * This method prepares the template object for returning AdminBox data.
	 * </pre>
	 * @return [void]
	 */
    function prepareTemplate($path) 
    {
        
        parent::prepareTemplate( $path );
        
        // store the form action information
        $this->template->set( 'formAction', $this->formAction );
        
        // store all the fields to the template
        $this->setFormFieldsToTemplate();
        
        
        /*
         * Form related Template variables:
         */
        // save the list of form fields
        $this->template->set( 'formFieldList', $this->formFields);
        
        // save the array indicating which fields are required
         $this->template->set('reqFieldList', $this->formFieldRequired); 	// this->formFieldInvalid[ $this->formFields[$indx] ]
        
        
        // store the field types being displayed
        $fieldTypes = explode(',', $this->formFieldDisplayTypes);
        $this->template->set( 'formFieldType', $fieldTypes);
        
 
    }
    
    
    
    //************************************************************************
	/**
	 * function setFormAction
	 * <pre>
	 * Sets the value of the Form Action Link.
	 * </pre>
	 * @param $link [STRING] The HREF link for the continue link
	 * @return [void]
	 */
    function setFormAction($link) 
    {
        $this->formAction = $link;
    }
    
    
    
    //************************************************************************
	/**
	 * function setFormFieldDisplayTypes
	 * <pre>
	 * Sets the value of the Form Fields Display Types
	 * </pre>
	 * @param $types [STRING] The comma seperated list of field display types
	 * @return [void]
	 */
    function setFormFieldDisplayTypes($types) 
    {
        $this->formFieldDisplayTypes = $types;
    }
    
    
    
    //************************************************************************
	/**
	 * function setFormFieldsToTemplate
	 * <pre>
	 * Stores the fields into the Template object.
	 * </pre>
	 * @param $fieldKeyModifier [STRING] modifies the formField name & key.
	 * @return [void]
	 */
    function setFormFieldsToTemplate( $fieldKeyModifier='' ) 
    {
	    // Added so that page refresh to show FK constraint error
	    // does not keep old entry ID and cause next operation to overwrite data
	    if ($this->getIsErrorRefresh() == true)
	    {
     		$this->template->set( 'editEntryID', '' );
  		 }	  
  		   
        // for each form field ..
        for( $indx=0; $indx<count($this->formFields); $indx++) {
        
            
            $key = $this->formFields[$indx].$fieldKeyModifier;
            // echo 'key['.$key.']';
            
            // create a new form item xml object
            $name = $key;
            if ( isset( $this->formValues[ $key ] )) {
                $value = $this->formValues[ $key ];
                // echo ' value ['.$value.']<br/>';
            } else {
                // the if case is new code added by RM so that forms with a numeric value have a default value of 
                // zero if a value was not specified
                if ( isset( $this->formFieldTypes[ $key ] ) && ( ( $this->formFieldTypes[ $key ] == 'N' ) || ( $this->formFieldTypes[ $key ] == 'Z' ) ) )
                {
                    $value = 0;
                }
                else
                {
                    $value = '';
                }
            }
            
            if ( isset( $this->formErrors[ $key ] ) ) {
                $error = $this->formErrors[ $key ];
            } else {
                $error = '';
            }
            $formItem = new XMLObject_FormItem($name, $value, $error );

            // store in template
            $this->template->setXML( $key, $formItem->getXML() );
        }

    }

	
}

?>
