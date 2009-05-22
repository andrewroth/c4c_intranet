<?php
/**
 * @package RAD
 */ 
/**
 * class PersonYearList
 * <pre> 
 * This object manages the listing of the person_year table elements.
 * </pre>
 * @author Hobbe Smit
 */
class  PersonYearList {

	//CONSTANTS:
	/** The XML Root Node Name for this list of info. */
    const XML_NODE_NAME = 'PersonYearList';

	//VARIABLES:
	/** @var [OBJECT] The ReadOnlyResultSet obj returned from the RowManager. */
	protected $resultSet;
	

	//CLASS CONSTRUCTOR
	//************************************************************************
	/**
	 * function __construct
	 * <pre>
	 * Initialize the Class ...
	 * </pre>
     * @param $personyear_id [INTEGER] value used to initialize the list.
	 * @param $sortBy [STRING] the field name to sort list by
     * @return [void]
	 */
    function __construct( $campus_id=-1,  $assignment_status_list='', $sortBy='' ) 
    {
        
        // NOTE: if you need to narrow the field of the search then uncommnet
        // the following and set the proper search criteria.
        if ($campus_id == '') {
            $campus_id = -1;
        }
        if ($sortBy == '') {
            $sortBy = 'personyear_id';
        }
        
	     $personYearManager = new RowManager_PersonYearManager();
	     $campusAssignments = new RowManager_AssignmentsManager();
	     $campusAssignments->setCampusID($campus_id);	   
	     $person = new RowManager_PersonManager();  
	     
        $searchManager = new MultiTableManager();	//new RowManager_PersonYearManager();
        $searchManager->addRowManager($campusAssignments);
        $searchManager->addRowManager($personYearManager, new JoinPair($personYearManager->getJoinOnPersonID(), $campusAssignments->getJoinOnPersonID(), JOIN_TYPE_LEFT));        
        $searchManager->addRowManager( $person, new JoinPair( $person->getJoinOnPersonID(), $personYearManager->getJoinOnPersonID()));  
 
        
	     if ($assignment_status_list != '')
	     {
	     		$searchManager->addSearchCondition('assignmentstatus_id in ('.$assignment_status_list.')');	// filter results by student-campus status
     	  }        
        
        $searchManager->setSortOrder( $sortBy );

//         $this->resultSet = $searchManager->find();       
        
        $foundIterator = $searchManager->getListIterator();       
        $foundArray = $foundIterator->getDataList();
        
        /** Add new person year entries as required **/
        reset($foundArray);
        foreach ( array_keys($foundArray) as $k )
        {
	        $record = current($foundArray);
	        
	        $person_id = $record['person_id'];	// person_id must exist given join condition, personyear_id and/or year_id may not
	        $personyear_id = $record['personyear_id'];
	        
	        /** Add new person year entry if person doesn't have one yet **/
	        if ($personyear_id == "")
	        { 
		        $newPersonYear = new RowManager_PersonYearManager();
		        $newPersonYear->setPersonID($person_id);
		        $newPersonYear->setYear(RowManager_PersonYearManager::OTHER);
		        $newPersonYear->createNewEntry();
	        }       
	        
	        next($foundArray);
        }
        
        $keepList = 'campus_id';
        $searchManager->deleteValuesExceptSome($keepList);
         $this->resultSet = $searchManager->find();  
        
//         echo "record array  = <pre>".print_r($foundArray,true)."</pre>";

        	        
// 	     $searchManager->setValueByFieldName("campus_id", $campus_id );

        //$searchManager->setValueByFieldName('module_isCommonLook', '1' );

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
	 * @return [ARRAY] if exists, FALSE otherwise
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
	 * function getNext
	 * <pre>
	 * Returns next object in the list.
	 * </pre>
	 * @return [OBJECT] if exists, FALSE otherwise
	 */
    function getNext() 
    {
        return $this->resultSet->getNext( new RowManager_PersonYearManager() );
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
	function getXML( $isHeaderIncluded=true, $rootNodeName=PersonYearList::XML_NODE_NAME ) 
	{
        $xmlObject = new XMLObject( $rootNodeName);
        
        $this->resultSet->setFirst();
        while( $item = $this->resultSet->getNext( new RowManager_PersonYearManager() ) ) {
        
            $xmlObject->addXMLObject( $item->getXMLObject() );
        }// end while
        
        return $xmlObject->getXML( $isHeaderIncluded );
	
	} // end getXML()
	
}

?>