<?php
/**
 * @package AIObjects
 */ 
/**
 * class TableManagerSingle
 * <pre> 
 * This is a generic class that manages interaction with a Table. It is designed
 * for tables where you would only manage 1 row of information at a time.
 * </pre>
 * @author Johnny Hausman
 */
class  TableManagerSingle  {

	//CONSTANTS:
   

	//VARIABLES:
    /** @var [ARRAY] Values managed by this object. */
	protected $values;
	
	/** @var [ARRAY] Fields in table for this object. (serves as KEY for $values )*/
	protected $fields;
	
	/** @var [STRING] List of fields (columns)in table this object manages. */
	protected $fieldList;
	
	/** @var [OBJECT] Database object for accessing the DB. */
	protected $db;
	
	/** @var [STRING] The Database Table name to manage. */
	protected $dbTableName;
	
	/** @var [STRING] The SQL Condition for update & delete operations. */
	protected $dbCondition;
	
	/** @var [BOOL] Status of wether the object was successfully initialized. */
	protected $isLoaded;
	

	//CLASS CONSTRUCTOR
	//************************************************************************
	/**
	 * function __construct
	 * <pre>
	 * Initialize this object.
	 * </pre>
	 * @param $familyID [INTEGER] The unique id of the family whose status 
	 * we are managing.
	 * @return [void]
	 */
    function __construct( $dbTableName, $fieldList, $condition='' ) 
    {
        $this->dbTableName = $dbTableName;
        $this->fieldList = $fieldList;
        $this->dbCondition = $condition;
        
        $this->db = new Database_Site();
        $this->db->connectToDB( SITE_DB_NAME, SITE_DB_PATH, SITE_DB_USER, SITE_DB_PWORD );
        
        $this->values = array();
        
        $this->fields = explode( ',', $this->fieldList);
        
        $this->isLoaded = false;
        
        if ( $this->dbCondition != '') {
        
            $this->isLoaded = $this->loadFromDB();
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
    
    
    
    //************************************************************************
	/**
	 * function createNewEntry
	 * <pre>
	 * Creates a new table entry in the DB for this object to manage.
	 * </pre>
	 * @return [void]
	 */
    function createNewEntry( ) 
    {   
        $this->db->setTableName( $this->dbTableName );
        
        $fieldValues = array();

        // for each stored value
        foreach( $this->values as $key=>$value) {
        
            // store in new array
            $fieldValues[ $key ] =  $value;
        }

        $this->db->setFieldValues( $fieldValues );
        
        $this->db->insert();
        
    } // end createNewEntry()
    
    
    
    //************************************************************************
	/**
	 * function loadFromDB
	 * <pre>
	 * Loads the row of data to manage
	 * </pre>
	 * @return [BOOL] True if load successful, False otherwise.
	 */
    function loadFromDB() 
    {
        $returnValue = true;
        
        // pull status info for this family from DB...
        $sql = 'SELECT * FROM '.SITE_DB_NAME.'.'.$this->dbTableName.' WHERE '.$this->dbCondition;
        
        $this->db->runSQL( $sql );
        
        // if row retrieved ...
        if ($row = $this->db->retrieveRow() ) {
        
            $this->loadFromArray( $row );
                        
        } else {
        
            // failed load
            $returnValue = false;
            
        } // end if row retrieved ...
        
        return $returnValue;
        
    } // end loadByFamilyID()
    
    
    
    //************************************************************************
	/**
	 * function loadFromArray
	 * <pre>
	 * Loads this object from a given array of data.
	 * </pre>
	 * @param $values [ARRAY] array of data: array( $field=>$value,...,$field=>$value);
	 * @return [void]
	 */
    function loadFromArray($values) 
    {
        // for each possible field this object manages ...
        for( $indx=0; $indx<count($this->fields); $indx++) {
        
            $key = $this->fields[$indx];
            
            // if that field has been provided 
            if (isset( $values[ $key ] ) ) {
            
                // store field into value array
                $this->values[ $key ] = $values[ $key ];
            }
        } // next field
    }
    
    
    
    //************************************************************************
	/**
	 * function updateDBTable
	 * <pre>
	 * Updates the DB table info.
	 * </pre>
	 * @return [void]
	 */
    function updateDBTable() 
    {   
        $this->db->setTableName( $this->dbTableName );
        
        $fieldValues = array();
        
        // for each possible field this object manages ...
        for( $indx=0; $indx<count($this->fields); $indx++) {
            $key = $this->fields[$indx];
            $fieldValues[ $key] = $this->values[ $key ];
        } // next field
        
        $this->db->setFieldValues( $fieldValues );
        
        $this->db->setCondition( $this->dbCondition );
        
        $this->db->update();
        
    } // end updateDBTable()
    
    
    
    //************************************************************************
	/**
	 * function deleteEntry
	 * <pre>
	 * Updates the DB table info.
	 * </pre>
	 * @return [void]
	 */
    function deleteEntry() 
    {   
        $this->db->setTableName( $this->dbTableName );
                
        $this->db->setCondition( $this->dbCondition );
        
        $this->db->delete();
        
    } // end deleteEntry()
    
    
    
    //************************************************************************
	/**
	 * function isLoaded
	 * <pre>
	 * Returns the status of this objects initialization.
	 * </pre>
	 * @return [BOOL]
	 */
    function isLoaded() 
    {
        return $this->isLoaded;
    }
    
    
    
    //************************************************************************
	/**
	 * function getArrayOfValues
	 * <pre>
	 * Returns an array of values.
	 * </pre>
	 * @return [ARRAY]
	 */
    function getArrayOfValues() 
    {   
        $fieldValues = array();
        
        // for each possible field this object manages ...
        for( $indx=0; $indx<count($this->fields); $indx++) {
            $key = $this->fields[$indx];
            
            // if value exists
            if ( isset( $this->values[ $key ] ) ) {
            
                // store in new array ...
                $fieldValues[ $key] = $this->values[ $key ];
            }
        } // next field
        
        return $fieldValues;
        
    } // end getArrayOfValues()
    
    
    
    //************************************************************************
	/**
	 * function getValueByFieldName
	 * <pre>
	 * Returns the value of this field.
	 * </pre>
	 * @param $fieldName [STRING] the key for the desired value.
	 * @return [STRING]
	 */
    function getValueByFieldName( $fieldName ) 
    {
        if (isset( $this->values[ $fieldName ]) ) {
            
            $returnValue = $this->values[ $fieldName ];
            
        } else {
            
            $returnValue = '';
        }
        
        return $returnValue;
    }
    
    
    
    //************************************************************************
	/**
	 * function setFieldsOfInterest
	 * <pre>
	 * sets the fields of interest to the provided list.
	 * </pre>
	 * @param $list [STRING] comma delimited list of fields to work with
	 * @return [void]
	 */
    function setFieldsOfInterest($list) 
    {
        // if something is provided ...
        if ($list != '') {
            
            // reset fields of interest
            $this->fields = array();
            
            // for each list item
            $listItems = explode( ',', $list);
            for( $indx=0; $indx<count($listItems); $indx++) {
                
                // add to fields of interest
                $this->fields[] = $listItems[$indx];
                
            }// next Item
            
        } // end if provided 
    }
    
    
    
    //************************************************************************
	/**
	 * function setValueByFieldName
	 * <pre>
	 * sets the given field to the given value.
	 * </pre>
	 * @param $fieldName [STRING] the name of the field
	 * @param $fieldValue [STRING] the value of the field
	 * @return [void]
	 */
    function setValueByFieldName($fieldName, $fieldValue ) 
    {
        // if fieldName is given
        if ($fieldName != '') {
        
            $this->values[ $fieldName ] = $fieldValue;
        
        } // end if fieldName given
        
    } // end setValueByFieldName()
    
    
    
    //************************************************************************
	/**
	 * function setDBCondition
	 * <pre>
	 * Sets the value of the db condition field.
	 * </pre>
	 * @param $condition [STRING] New DB condition
	 * @return [void]
	 */
    function setDBCondition($condition) 
    {
        $this->dbCondition = $condition;
        
    } // end setDBCondition()
    
    
    
    //************************************************************************
	/** 
	 * function getXMLObject
	 *
	 * Generates an XML Object from the object's Values array.
	 *
	 * @param $isHeaderIncluded [BOOL] Determines if we include the '<?xml version="1.0"?>' header.
	 * @param $rootNodeName [STRING] The XML root node name.
	 *
	 * @return [OBJECT] Returns an XMLObject.
	 */
	function getXMLObject( $isHeaderIncluded=true, $rootNodeName='' ) 
	{
        $xmlObject = new XMLObject( $rootNodeName );
        
        // for each possible field this object manages ...
        for( $indx=0; $indx<count($this->fields); $indx++) {
        
            $key = $this->fields[$indx];
            
            // if value exists
            if ( isset( $this->values[ $key ] ) ) {
            
                $xmlObject->addElement( $key, $this->values[ $key ] );
                
            } else {
            
                $xmlObject->addElement( $key, '' );
            }
        }
        
        return $xmlObject;
        
    } // end getXMLObject()
    
    
    
    //************************************************************************
	/** 
	 * function getXML
	 *
	 * Generates an XML document from the object's Values array.
	 *
	 * @param $isHeaderIncluded [BOOL] Determines if we include the '<?xml version="1.0"?>' header.
	 * @param $rootNodeName [STRING] The XML root node name.
	 *
	 * @return [STRING] Returns an XML formatted string.
	 */
	function getXML( $isHeaderIncluded=true, $rootNodeName='' ) 
	{
        $xmlObject = $this->getXMLObject( $isHeaderIncluded, $rootNodeName );
                
        return $xmlObject->getXML(  $isHeaderIncluded=true );
        
    } // end getXML()
    
	
}

?>