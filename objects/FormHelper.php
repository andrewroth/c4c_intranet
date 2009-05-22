<?php

class FormHelper
{
    var $fieldInfo;
    
    var $formFieldList;
    var $formFieldHTMLType;
    var $formFieldDataType;
    var $formFieldReqd;
    var $formFieldInvalid;
    
    var $formData;
    var $formErrors;
    
    var $formDescLabels;
    
    var $formAction;
    
    var $buttonText;
    
    // constructor
    //
    function FormHelper( ) 
    {
        $this->formData = array();
        $this->formErrors = array();
        $this->formDescLabels = array();
        
        // default button text
        $this->buttonText = "Next >";
        
        return;
    }
    
    function setButtonText( $text )
    {
        $this->buttonText = $text;
    }
    
    function setFields( $fieldInfo )
    {
        $this->fieldInfo = $fieldInfo;
        
        // parse out the info contained in the fieldInfo
        
        // check for a ','
        $pos = strpos($this->fieldInfo, ',');
        if ( ( $pos === false ) && ( strlen( $this->fieldInfo ) > 0 ) )
        {
            // we assume only one entry
            // echo 'Only one entry<br/>';
            $fieldArray = array();
            $fieldArray[] = $this->fieldInfo;
        }
        else
        {
            // contains more than one entry
            $fieldArray = explode(',', $this->fieldInfo );
        }
        
        // TODO, the above code is not 'tight', there is the case where '' is passed in and we should die, not covered yet
        
        $this->formFieldList = array();
        $this->formFieldHTMLType = array();
        $this->formFieldDataType = array();
        $this->formFieldReqd = array();
        $this->formFieldInvalid = array();
        
        foreach( $fieldArray as $key=>$value )
        {
            $elements = explode('|', $value );
            // echo '<pre>'.print_r($elements, true) . '</pre>';
            
            $this->formFieldList[] = $elements[0];
            $this->formFieldHTMLType[] = $elements[1];
            $this->formFieldDataType[] = $elements[2];    
            $this->formFieldReqd[] = $elements[3];
            $this->formFieldInvalid[] = $elements[4]; 
            $this->formData[$elements[0]] = '';
            $this->formErrors[$elements[0]] = '';
            $this->formDescLabels[$elements[0]] = '';
            // echo '$elements[0]'.$elements[0].'<br/>'; 
        }
        
        return;
        
    }
    
    function setFormAction( $action )
    {
        $this->formAction = $action;
    }
    
    function setLabels( $labelArray )
    {
        $this->formDescLabels = $labelArray;
        return;
    }
    
    function setFormData( $formData )
    {
        $this->formData = $formData;
    }
    
    function isDataValid()
    {
        // assume the data is good until we prove otherwise
        $retVal = true;
        
        // go through all the fields and make sure they contain good data
        foreach( $this->formFieldList as $key=>$value )
        {
            // we want to check the data if 
            // a. the field is required
            // b. not required but contains data, but the data is not a '-' from a droplist
            if ( $this->formFieldReqd[$key] == true || ( ($this->formData[$value] != '') && $this->formData[$value] != '-' ) )
            {
                $data = $this->formData[$value];
                
                // assume no error
                $error = '';
                
                // check by the type of data
                switch ( $this->formFieldDataType[$key] )
                {
                    // must be a numeric (integer) value
                    case 'N':
                    // must have chosen an item from the drop down list
                    case 'D':                      
                        // echo 'checking N/D types <br/>';
                        
                        if ( !is_numeric($data) )
                        {
                            $error = 'Not a valid number or choice.';
                            $retVal = false;
                        }
                        
                        break;
                    
                    // should be a text string
                    case 'T':
                        // echo 'checking T type <br/>';
                        if ( ( !is_string( $data ) ) || ( $data == '' ) )
                        {
                            $error = 'Invalid string value';
                            $retVal = false;
                        }
                        break;
                        
                    default:
                        break;
                }
                $this->formErrors[$value] = $error;
                   
            } // foreach
        } // if need to check
        
        return $retVal;
    }
    
    function loadFromForm()
    {
        // echo 'Inside loadFromForm<br/>';
        foreach( $this->formFieldList as $key=>$value )
        {
            switch( $this->formFieldDataType[$key] )
            {
                case 'B':
                // Boolean Types are set to false (0 since DB Table is 
                // most likely an INTEGER) if not found..
                    if ( isset( $_REQUEST[$value] ) )
                    {
                        // echo 'setting value['.$value.'] ['.$_REQUEST[$value].'] set<br/>';
                        $this->formData[$value] = $_REQUEST[$value];
                    }
                    else
                    {
                        $this->formData[$value] = 0;
                    }
                    break;
                    
                default:
                    if ( isset( $_REQUEST[$value] ) )
                    {
                        // echo 'setting value['.$value.'] ['.$_REQUEST[$value].'] set<br/>';
                        $this->formData[$value] = $_REQUEST[$value];
                    }
                    else
                    {
                        // echo $value . ' not found<br/>';
                    }
                    break;
            } // switch
        }
        return;
    }

} // class Form

?>