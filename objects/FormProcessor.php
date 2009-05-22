<?php
/**
 * @package AIobjects
 */ 
/**
 * class FormProcessor
 * <pre> 
 * This object manages the generic page processing routines for the 
 * Application Upload system.  Each of the content pages that process forms
 * AND use TableManagers to update the data will inherit from this object. 
 * </pre>
 * @author Johnny Hausman
 */
class  FormProcessor {

	//CONSTANTS:

	//VARIABLES:

    /** @var [ARRAY] list of fields for this form. */
	protected $formFields;
	
    /** @var [STRING] The action the form should take. */
	protected $formAction;
	
	/** @var [ARRAY] the type of each field for this form */
	protected $formFieldTypes;
	
	/** @var [ARRAY] list of invalid values for each field of this form. */
	protected $formFieldInvalid;
	
	/** @var [ARRAY] the form values  */
	protected $formValues;
	
	/** @var [ARRAY] the form errors */
	protected $formErrors;
	
	/** @var [OBJECT] the template object */
	protected $template;
	
	/** @var [OBJECT] the labels object */
	protected $labels;


	//CLASS CONSTRUCTOR
	//************************************************************************
	/**
	 * function __construct
	 * <pre>
	 * Initialize the PageDisplay Object.
	 * </pre>
	 * @param $pathToRoot [STRING] The path to the root directory 
	 * @param $pathModuleRoot [STRING] The path from the root directory to this 
	 * module's root directory.
	 * @return [void]
	 */
    function __construct( $fieldList ) 
    {
        /*
         * initializing the Page's form variables
         */
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
	 * function setFormFieldsToTemplate
	 * <pre>
	 * Stores the fields into the Template object.
	 * </pre>
	 * @param $fieldKeyModifier [STRING] modifies the formField name & key.
	 * @return [void]
	 */
    function setFormFieldsToTemplate( $fieldKeyModifier='' ) 
    {

        // for each form field ..
        for( $indx=0; $indx<count($this->formFields); $indx++) {
        
            $key = $this->formFields[$indx].$fieldKeyModifier;
            
            // create a new form item xml object
            $name = $key;
            if ( isset( $this->formValues[ $key ] )) {
                $value = $this->formValues[ $key ];
            } else {
                $value = '';
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
        // for each form field ..
        for( $indx=0; $indx<count($this->formFields); $indx++) {
        
            $key = $this->formFields[$indx].$fieldKeyModifier;
            
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
                    $this->formValues[ $key ] = $year.'-'.$month.'-'.$day;
                    break;
                    
                case 'Time':
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
                    $this->formValues[ $key ] = $hour.':'.$minute.':'.$second;
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
        
    } // end loadFromForm()
    
    
    
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
        // echo 'Inside FormProcessor::isDataValid()<br/>';
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
            
                default:
                    // echo 'Inside default case<br/>';
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
            
        } // next field
        
        
        // now return result
        // echo 'FormProcessor::isValid['.$isValid.']</br>';
        return $isValid;
        
    }  // end isDataValid()
    
    
    
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

	
}

?>