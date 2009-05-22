<?php
/**
 * @package AIObjects
 */ 
/**
 * class DataAccessManager
 * <pre> 
 * This object defines the necessary interfaces for a DataAccess Manager.
 * </pre>
 * @author Johnny Hausman
 */
abstract 
class  DataAccessManager {

	//CONSTANTS:


	//VARIABLES:
	
	
	
	
	/** @var [STRING] XML root node name for this object. */
	protected $xmlNodeName;


	//CLASS CONSTRUCTOR
	//************************************************************************
	/**
	 * function __construct
	 * <pre>
	 * Initialize this object.  The different manager objects are expected to
	 * be provided from the child of this object.
	 * </pre>
	 * @param $rowManager [OBJECT] The Row Manager object.
	 * @param $multiLingualManager [OBJECT] Multilingual Manager Object
	 * @param $xmlNodeName [STRING] The xml node name for this object
	 * @return [void]
	 */
    function __construct( $xmlNodeName ) 
    {

        $this->xmlNodeName = $xmlNodeName;
    
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

    
    
    
    //************************************************************************
	/**
	 * function addSearchCondition
	 * <pre>
	 * Adds a search condition for use in performing the find() method
	 * </pre>
	 * @param $condition [STRING] The additional condition to search by
	 * @return [void]
	 */
    abstract
    function addSearchCondition( $condition );//{}
    // NOTE: the //{} are here to trick SubEthaEdit into recognizing these
    // as functions. php5 doesn't need them
        
    
    
    //************************************************************************
	/** 
	 * function clearValues
	 *
	 * Clears the object's data as if it was uninitialized.
	 *
	 * @return [void]
	 */
    abstract
	function clearValues();//{}
    
    
    
    //************************************************************************
	/** 
	 * function constructSearchCondition
	 *
	 * Used to construct complex search conditions for use in the find() 
	 * method
	 *
	 * @return [void]
	 */
    abstract
    function constructSearchCondition( $fieldName, $op, $value, $shouldAdd=false );//{}
    
    
    
    //************************************************************************
	/** 
	 * function constructSearchConditionFromArray
	 *
	 * Will complie an array of search condition statements into a single 
	 * statement joined together by a given operation type ($op)
	 *
	 * @return [void]
	 */
    abstract
    function constructSearchConditionFromArray( &$condArray, $op, $shouldAdd=false );//{}
    
    
    
    //************************************************************************
	/**
	 * function createNewEntry
	 * <pre>
	 * Creates a new table entry in the DB for this object to manage.
	 * </pre>
	 * @param $doAllowPrimaryKeyUpdate [BOOL] allow insertion of primary key 
	 * value if present.
	 * @return [void]
	 */
    abstract
    function createNewEntry( $doAllowPrimaryKeyUpdate=false );//{}
    
    
    
    //************************************************************************
	/**
	 * function deleteEntry
	 * <pre>
	 * Removes managed entry from the DB table.
	 * </pre>
	 * @return [void]
	 */
    abstract
    function deleteEntry();//{}
    
    
    
    //************************************************************************
	/** 
	 * function find
	 * <pre>
	 * This method will return a ReadOnlyResultSet result of db rows that 
	 * match the values currently set in the dataManaer object.  NOTE: if you
	 * don't set any values for this object, then all rows will be returned.
	 * </pre>
	 * @return [OBJECT] ReadOnlyResultSet.
	 */
    abstract 
	function find();//{}

    
        
    //************************************************************************
	/**
	 * function getArrayOfValues
	 * <pre>
	 * Returns an array of values managed by this object.  The array should be
	 * in the format: fieldName=>value, fieldName=>value, ...
	 * </pre>
	 * @return [ARRAY]
	 */
    abstract
    function getArrayOfValues();//{}
    
    
    
    
    //************************************************************************
	/**
	 * function getID
	 * <pre>
	 * Returns the value of the dataManager's primary key field. 
	 * </pre>
	 * @return [STRING]
	 */
    abstract
    function getID();//{}
    
    
    
    //************************************************************************
	/**
	 * function getLabel
	 * <pre>
	 * Returns the value commonly used for displaying as a Label (Form Grid
	 * rows, Drop List Labels, etc...).
	 * </pre>
	 * @return [STRING]
	 */
    abstract 
    function getLabel();//{}
    
    
    
    //************************************************************************
	/**
	 * function getListIterator
	 * <pre>
	 * Returns a ListIterator object based on this object.
	 * </pre>
	 * @param $sortBy [STRING] the name of the field to sort by (can be a
	 * comma seperated list).
	 * @return [OBJECT]
	 */
	 function getListIterator( $sortBy='' ) 
	 {
	   if ( $sortBy != '') {
    	   $this->setSortOrder( $sortBy );
	   }
	   return new ListIterator( $this );
	   
	 }
    
    
    
    //************************************************************************
	/**
	 * function getRowLabelBridge
	 * <pre>
	 * Returns a RowLabelBridge object based on this object.  This is intended
	 * to be run from the single RowManager object for the table that is a 
	 * RowLabelBridge.  After getting the basic RowLabelBridge back, you can
	 * add in other tables as necessary.
	 * </pre>
	 * @param $multilingualContext [OBJECT] a MultiLingualManager defined for
	 * this rowLabelBridge.  Must at least have the viewer's languageID set.
	 * @return [OBJECT]
	 */
	 function getRowLabelBridge( $multilingualContext ) 
	 {
	   if ( ! $multilingualContext->isContextSet()) {
	       $multilingualContext->loadContextByPageKey( $this->getXMLNodeName() );
	   }
	   return new RowLabelBridge($this, $multilingualContext );
	 }
    
    
    
    //************************************************************************
	/**
	 * function getXMLNodeName
	 * <pre>
	 * Returns the xml node name.
	 * </pre>
	 * @return [STRING]
	 */
    function getXMLNodeName()
    {
        return $this->xmlNodeName;
    }
        
    
    
    //************************************************************************
	/** 
	 * function getXMLObject
	 * <pre>
	 * Generates an XML Object from the object's Values array.
	 * </pre>
	 * @param $isHeaderIncluded [BOOL] Determines if we include the '<?xml version="1.0"?>' header.
	 * @param $rootNodeName [STRING] The XML root node name.
	 *
	 * @return [OBJECT] XMLObject
	 */
    abstract
	function getXMLObject( $isHeaderIncluded=true, $rootNodeName='' );//{}
    
    
    
    //************************************************************************
	/** 
	 * function getXML
	 * <pre>
	 * Generates an XML document from the object's Values array.
	 * </pre>
	 * @param $isHeaderIncluded [BOOL] Determines if we include the '<?xml version="1.0"?>' header.
	 * @param $rootNodeName [STRING] The XML root node name.
	 * @return [STRING]
	 */
    abstract
	function getXML( $isHeaderIncluded=true, $rootNodeName='' );//{}
    
    
    
    //************************************************************************
	/**
	 * function isLoaded
	 * <pre>
	 * Returns the status of this object's initialization.
	 * </pre>
	 * @return [BOOL]
	 */
    abstract
    function isLoaded();//{}
    
    
    
    //************************************************************************
	/**
	 * function loadFromArray
	 * <pre>
	 * Loads the DataAccess manager with a given array of data.
	 * </pre>
	 * @param $values [ARRAY] array of data: array( $field=>$value,...,$field=>$value);//{}
	 * @return [void]
	 */
    abstract
    function loadFromArray($values);//{}    
    
    
    
    //************************************************************************
	/**
	 * function loadFromDB
	 * <pre>
	 * Loads the row of data to manage
	 * </pre>
	 * @return [BOOL] True if load successful, False otherwise.
	 */
    abstract
    function loadFromDB();//{}
    
    
    
    //************************************************************************
	/**
	 * function setFieldsOfInterest
	 * <pre>
	 * sets the fields of interest to the provided list. This way future 
	 * operations on this object will only work with these fields.
	 * </pre>
	 * @param $list [STRING] comma delimited list of fields to work with
	 * @return [void]
	 */
    abstract
    function setFieldsOfInterest($list);//{}    
    
    
    
    //************************************************************************
	/**
	 * function setSortOrder
	 * <pre>
	 * sets which field this DataAccess object should use in sorting it results.
	 * </pre>
	 * @param $fieldName [STRING] the name of the field to sort by (can be a
	 * comma seperated list).
	 * @return [void]
	 */
    abstract
    function setSortOrder( $fieldName );//{}
    
    
    
   //************************************************************************
	/**
	 * function setGroupBy
	 * <pre>
	 * Enables the use of a GROUP BY condition in the SQL statement and
	 * specifies the fields to use in the conditiong
	 * </pre>
	 * @param $condition [STRING] the name of the field to group by (can be a
	 * comma separated list).
	 * @return [void]
	 */
    abstract
    function setGroupBy( $fieldName );//{}
    
    
     //************************************************************************
	/**
	 * function setFunctionCall
	 * <pre>
	 * Enables the use of a DB function (i.e. COUNT(), SUM(), etc) in the SELECT portion of an SQL statement and
	 * specifies the field to use as parameter
	 * </pre>
	 * @param $function [STRING] the name of the function to use 	 
	 * @param $fieldName [STRING] the name of the field to use in DB function
	 * @return [void]
	 */
    abstract
    function setFunctionCall( $function, $fieldName );//{}  
    
    
    //************************************************************************
	/**
	 * function setDBCondition
	 * <pre>
	 * Sets the value of the db condition field (for the dataManager).
	 * </pre>
	 * @param $condition [STRING] New DB condition
	 * @return [void]
	 */
    abstract
    function setDBCondition($condition);//{}
    
    
    
    //************************************************************************
	/**
	 * function updateDBTable
	 * <pre>
	 * Updates the DB table info.
	 * </pre>
	 * @return [void]
	 */
    abstract
    function updateDBTable();//{}
    

}

?>