<?php
/**
 * @package NSSPayRoll
 */ 
/**
 * class HrdbNssMultiList
 * <pre> 
 * This object manages a multi table result set. Allowing you to iterate through
 * the result entries and generate the appropriate RowManagers to work with it.
 * </pre>
 * @author Johnny Hausman/David Cheong
 */
class  HrdbNssMultiList {

	//CONSTANTS:
	/** The XML Root Node Name for this list of info. */
    const XML_NODE_NAME = 'HrdbNssMultiList';

	//VARIABLES:
	/** @var [OBJECT] The ReadOnlyResultSet obj returned from the RowManager. */
	protected $resultSet;
	
	/** @var [STRING] Comma Seperated List of fields requested by this object. */
	protected $fieldList;
	
	/** @var [STRING] DB Table join information. */
	protected $dbTableList;
	
	/** @var [ARRAY] Values to lookup as where condition entries. */
	protected $values;
	
	/** @var [ARRAY] Array of search conditions to add to the where clause. */
	protected $searchCondition;
	
	/** @var [STRING] The Sort Order of the recordset. */
	protected $sortBy;
	

	//CLASS CONSTRUCTOR
	//************************************************************************
	/**
	 * function __construct
	 * <pre>
	 * Initialize the Class ...
	 * </pre>
	 * @param $sortBy [STRING] the field name to sort list by
     * @return [void]
	 */
    function __construct(  $sortBy='' ) 
    {
        
        // compile the Field List
        $this->fieldList = '';
        
        
        // set the DB joining data 
        $this->dbTableList = '';
        
        
        // Now set initial conditions
        $this->values = array();
        //$this->values['key'] = $value;
        
        
        // add additional Search Conditions
        $this->searchCondition = array();
        // $this->searchCondition[] = 'ren_id=X';
        
        
        // save the SortBy field
        $this->sortBy =  $sortBy;
        
        
        $this->resultSet = $this->find();
        
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
    }  // end classMethod()
    
    
    
    //************************************************************************
	/**
	 * function find
	 * <pre>
	 * generates the SQL to gather the data from the tables you are interested
	 * in.
	 * </pre>
	 * @return [OBJECT] ReadOnlyResultSet.
	 */
	function find() 
	{
        $sql = 'SELECT '.$this->fieldList.' FROM '.$this->dbTableList;
        
        $whereClause = '';
        
        
        // for each given value to search by
        foreach( $this->values as $key=>$value) {
            if ($value != '') {
                
                // add current key=>value combo to the where clause
                if ($whereClause != '') {
                    $whereClause .= ' AND ';
                }
                $whereClause .=  $key . '="'. $value.'"';
            }
        }
        
        
        // now process any searchConditions provided
        for ( $indx=0; $indx<count( $this->searchCondition); $indx++) {
        
            // add current key=>value combo to the where clause
            if ($whereClause != '') {
                $whereClause .= ' AND ';
            }
            $whereClause .= '('.$this->searchCondition[ $indx ].')';
        }
        
        
        // if a where clause was created then add it to the sql
        if ($whereClause != '') {
            $sql .= ' WHERE '.$whereClause;
        }
        
        // if a sortBy field is given, then add it to the sql
        if ( $this->sortBy != '' ) {
            $sql .= ' ORDER BY '.$this->sortBy;
        }

        // create a new DB object
        $db = new Database_Site();
        $db->connectToDB( SITE_DB_NAME, SITE_DB_PATH, SITE_DB_USER, SITE_DB_PWORD );
        
        // run the sql
        $db->runSQL( $sql );
        
        // create a new ReadOnlyResultSet using current db object
        $recordSet = new ReadOnlyResultSet( $db );
        
        // return this record set
        return $recordSet;
        
        
    } // end find()
    
    
    
    //************************************************************************
	/**
	 * function setFirst
	 * <pre>
	 * Sets the list pointer to the first object.
	 * </pre>
	 * @return [void]
	 */
    function setFirst() 
    {
        $this->resultSet->setFirst();
    }  // end classMethod()
    
    
    
    //************************************************************************
	/**
	 * function getDropListArray
	 * <pre>
	 * Returns the list Objects in an array (used by form templates for drop
	 * lists).
	 * </pre>
	 * @param $labels [OBJECT] a multilingual label object for converting 
	 * label into the current language.
	 * @return [ARRAY]
	 */
    function getDropListArray( $labels=null ) 
    {
        // create an empty array to fill out
        $resultArray = array();
        
        // for each item in the list
        $this->setFirst();
        while( $item = $this->getNext() ) {
        
            // if a label object provided then 
            if ( $labels ) {
            
                // translate item label
                $currentLabel = $labels->getLabel( '['.$item->getLabel().']');
                $resultArray[ $item->getID() ] = $currentLabel;
                
            } else {
            // else 
            
                // store item label as is
                $resultArray[ $item->getID() ] = $item->getLabel();
            }
        }
        
        // return result array 
        return $resultArray;
        
    }  // end getDropListArray()
    
    
    
    //************************************************************************
	/**
	 * function moveNext
	 * <pre>
	 * Points to the next entry in the result set.
	 * </pre>
	 * @return [BOOL] True if exists, FALSE otherwise
	 */
    function moveNext() 
    {
        return $this->resultSet->moveNext();
    }
    
    
    
    //************************************************************************
	/**
	 * function getCurrentHRDBRen
	 * <pre>
	 * Returns current HRDB Ren object in the list.
	 * </pre>
	 * @return [OBJECT] if exists, FALSE otherwise
	 */
    function getCurrentHRDBRen() 
    {
        return $this->resultSet->getCurrent( new RowManager_HrdbRenManager() );
    }  // end classMethod()
    
    
    
    //************************************************************************
	/**
	 * function getCurrentNSSRen
	 * <pre>
	 * Returns current NSSRen object in the list.
	 * </pre>
	 * @return [OBJECT] if exists, FALSE otherwise
	 */
    function getCurrentNSSRen() 
    {
        return $this->resultSet->getCurrent( new RowManager_NssRenManager() );
    }  // end classMethod()

    
        
    //************************************************************************
	/** 
	 * function getXML
	 *
	 * Generates an XML document from the list of applicants.
	 *
	 * @param $isHeaderIncluded [BOOL] Determines if we include the '<?xml version="1.0"?>' header.
	 * @param $rootNodeName [STRING] The XML root node name.
	 *
	 * @return [STRING] Returns an XML formatted string.
	 */
	function getXML( $isHeaderIncluded=true, $rootNodeName=HrdbNssMultiList::XML_NODE_NAME ) 
	{
        $xmlObject = new XMLObject( $rootNodeName);
        
        $this->resultSet->setFirst();
        while( $item = $this->resultSet->getNext( new RowManager_NssAccessPrivManager() ) ) {
        
            $xmlObject->addXMLObject( $item->getXMLObject() );
        }// end while
        
        return $xmlObject->getXML( $isHeaderIncluded );
	
	} // end getXML()
	
}

?>