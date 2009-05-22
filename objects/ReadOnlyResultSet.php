<?php
/**
 * @package AIObjects
 */ 
/**
 * class ReadOnlyResultSet
 * <pre> 
 * This class is an iterator for a given object.  The original idea/code for
 * this object appeared on O'Reilly PHP Dev Center 
 * (http://www.onlamp.com/pub/a/php/2004/08/05/dataobjects.html?page=1 ).  
 * I have since modified it to work properly with our RowManager class as well
 * as abstracting the DB interface.
 * </pre>
 * @author Darryl Patterson
 * Modified by : Johnny Hausman
 * Modified Date: 12 Jan 2005
 */
class  ReadOnlyResultSet {

	//CONSTANTS:
	/** [CLASS_CONSTANT description] */
    const CLASS_CONSTANT = '5566';

	//VARIABLES:
	/** @var [OBJECT] The DB object that holds the recordset to iterate. */
	protected $db;
	
	/** @var [ARRAY] The Row Data from the "Current" entry in the result set. */
	protected $currentRow;



	//CLASS CONSTRUCTOR
	//************************************************************************
	/**
	 * function __construct
	 * <pre>
	 * Saves the provided DB object in the internal members.
	 * </pre>
	 * @param $db [OBJECT] The DB with the record set to iterate
	 * @return [void]
	 */
    function __construct( $db ) 
    {
        $this->db = $db;
        $this->currentRow = array();
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
	 * function getCurrent
	 * <pre>
	 * Returns a RowManager initialized with the currently available recordset 
	 * of data.  This function does NOT update the DB pointer in the recordset
	 * so you don't progress through the rows.
	 * </pre>
	 * @param $rowManager [OBJECT] a RowManager object
	 * @return [OBJECT] RowManager Object that is provided. Will return FALSE 
	 * if no more data is available.
	 */
    function getCurrent( $rowManager )
    {
    
        $returnValue = $rowManager;
        
        if ( count($this->currentRow) > 0 ) {
        
            $returnValue->loadFromArray( $this->currentRow );
        
        } else {
        
            $returnValue = false;
        }
        
        return $returnValue;
    }
    
    
    
    //************************************************************************
	/**
	 * function getCurrentRow
	 * <pre>
	 * Returns the current row array.
	 * </pre>
	 * @return [ARRAY] currentRow data.
	 */
    function getCurrentRow()
    {
        return $this->currentRow;
    }
    
    
    
    //************************************************************************
	/**
	 * function getNext
	 * <pre>
	 * Returns a RowManager initialized with the next available recordset of 
	 * data.
	 * </pre>
	 * @param $rowManager [OBJECT] a RowManager object
	 * @return [OBJECT] RowManager Object that is provided. Will return FALSE 
	 * if no more data is available.
	 */
    function getNext( $rowManager )
    {
    
        $returnValue = $rowManager;
        
        if ( $row = $this->db->retrieveRow() ) {
        
            $returnValue->loadFromArray( $row );
            $this->currentRow = $row;
        
        } else {
        
            $returnValue = false;
        }
        
        return $returnValue;
    }
    
    
    
    //************************************************************************
	/**
	 * function getRowCount
	 * <pre>
	 * Returns the number of rows returned in the current db recordset.
	 * </pre>
	 * @return [INTEGER]
	 */
    function getRowCount() 
    {
        return $this->db->getRowCount();
        
    }  // end getRowCount()
    
    
    
    //************************************************************************
	/**
	 * function moveNext
	 * <pre>
	 * Updates the CurrentRow data with the current row and moves the recordset
	 * pointer to the next entry.
	 * </pre>
	 * @return [BOOL] True if there is data in CurrentRow. False otherwise.
	 */
    function moveNext( )
    {
    
        $returnValue = true;
        
        if ( $row = $this->db->retrieveRow() ) {
        
            $this->currentRow = $row;
        
        } else {
        
            $returnValue = false;
            $this->currentRow = array();
        }
        
        return $returnValue;
    }
    
    
    
    //************************************************************************
	/**
	 * function setFirst
	 * <pre>
	 * Sets the db recordset to the first entry.
	 * </pre>
	 * @return [void]
	 */
    function setFirst() 
    {
        $this->db->setFirstRow();   
    }
	
}

?>