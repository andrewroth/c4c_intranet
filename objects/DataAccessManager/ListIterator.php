<?php
/**
 * @package AIObjects
 */ 
/**
 * class ListIterator
 * <pre> 
 * This object manages the ability to sequentially iterate through a list of
 * data access objects.
 * </pre>
 * @author Johnny Hausman / Russ Martin
 */
class ListIterator {

    /** @var [BOOL] Marks if a search Class Name was given as a return value for getNext() operations */
	protected $isSearchClassNameProvided;

    /** @var [OBJECT] The ReadOnlyResultSet obj returned from the RowManager. */
	protected $resultSet;
    
    /**  @var [OBJECT] The DataAccess Manager used for finding a result set. */
    protected $searchManager;
    
    /**  @var [STRING] The class name of the DataAccess manager to use when returning a DA Manager as a result set. */
	protected $searchClassName;
	
	/**  @var [STRING] The XML Root Node Name for this list of info. */
    protected $xmlNodeName;

    function __construct( $searchManager, $searchClassName='' ) 
    {
        $this->searchManager = $searchManager;
        $this->searchClassName = $searchClassName;
        $this->isSearchClassNameProvided = ($searchClassName != '');
        
        // set up the RowManager type that is used
        // in the getNext and XML methods
        if ( $this->searchClassName == '' )
        {
            // default to the searchManager that was passed in
            $this->searchClassName = get_class($this->searchManager);
            // echo 'searchClassName['.$this->searchClassName.']<br/>';
        }
        
        
        $this->xmlNodeName = 'list'.get_class($this);
        // echo 'xmlNodeName['.$this->xmlNodeName.']<br/>';

        $this->resultSet = $this->searchManager->find();
        
        return;
    }
    
    
    
    //************************************************************************
	/**
	 * function getCurrent
	 * <pre>
	 * Returns current rowManager object in the list.
	 * </pre>
	 * @return [OBJECT] if exists, FALSE otherwise
	 */
    function getCurrent( $rowManager ) 
    {
        return $this->resultSet->getCurrent( $rowManager );
    }
    
    
    
    //************************************************************************
	/**
	 * function getCurrentRowXMLObject
	 * <pre>
	 * Returns current row of data as an XML Object.
	 * </pre>
	 * @return [OBJECT] if exists, FALSE otherwise
	 */
    function getCurrentRowXMLObject( $isHeaderIncluded=true, $rootNodeName='' )
    {
        $this->searchManager->loadFromArray( $this->resultSet->getCurrentRow() );
        return $this->searchManager->getXMLObject( $isHeaderIncluded, $rootNodeName );
    }
    
    
    
    //************************************************************************
	/**
	 * function getDropListArray
	 * <pre>
	 * Returns the list Objects in an array (used by form templates for drop
	 * lists).
	 * </pre>
	 * @param $labels [OBJECT] a multilingual label object for converting 
	 * label into the current language.
	 * @param $jumpLink [STRING] a link to use for the keys. (for jumplink droplists )
	 * @return [ARRAY]
	 */
    function getDropListArray( $labels=null, $jumpLink='' ) 
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
                $resultArray[ $jumpLink.$item->getID() ] = $currentLabel;
                
            } else {
            // else 
                // store item label as is
                $resultArray[ $jumpLink.$item->getID() ] = $item->getLabel();
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
        if ( $this->isSearchClassNameProvided ) {
        
            return $this->resultSet->getNext( new $this->searchClassName() );
        
        } else {      
             
            return $this->resultSet->getNext( $this->searchManager );
        }
        
    }  // end classMethod()
    
    
    
    //************************************************************************
	/**
	 * function getRowManagerXMLNodeName
	 * <pre>
	 * Returns the XMLNodeName of the searchManager.
	 * </pre>
	 * @return [OBJECT] if exists, FALSE otherwise
	 */
    function getRowManagerXMLNodeName()
    {	    
        return $this->searchManager->getXMLNodeName();
    }
    
    
    
    //************************************************************************
	/** 
	 * function getDataList
	 *
	 * Generates an Array with all the data from the elements in this list.
	 *
	 * @return [ARRAY] 
	 */
	function getDataList() 
	{	
	   $dataList = array();
            
        // if given datamanager is of type MultiTableManager then
        if ( is_a( $this->searchManager, 'MultiTableManager' ) )  {
        
            // echo 'Is a MultiTableManager<br/>';
        
            $this->resultSet->setFirst();
            while( $this->resultSet->moveNext() ) {
                
                // load the searchManager from the current row of data
                $this->searchManager->loadFromArray( $this->resultSet->getCurrentRow() );
//                echo "<br> db result row = <pre>".print_r($this->resultSet->getCurrentRow(),true)."</pre>";
                
                // store data into dataList
                $skipIndividualManagers = true;
                $dataList[ $this->searchManager->getID() ] = $this->searchManager->getArrayOfValues($skipIndividualManagers);
//                echo "<br> array row = <pre>".print_r($dataList[ $this->searchManager->getID() ],true)."</pre>";
            }
        
        } else {
        
            // echo 'Is not a MultiTableManager<br/>';
        
            // else
            $this->resultSet->setFirst();
            while( $item = $this->resultSet->getNext( new $this->searchClassName() ) ) {
            
                $dataList[ $item->getID() ] = $item->getArrayOfValues();

            }// end while
        
        } // end if (is_a() )
        
        return $dataList;
	
	} // end getDataList()
	
	function getNumRows()
	{
	   return $this->resultSet->getRowCount();
	}
    
    
    
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
	function getXML( $isHeaderIncluded=true, $rootNodeName='' ) 
	{
	
        if ( $rootNodeName == '' )
        {
           $rootNodeName = $this->xmlNodeName;
        }
        
        $xmlObject = new XMLObject( $rootNodeName);
        
        
        // if given datamanager is of type MultiTableManager then
        if ( is_a( $this->searchManager, 'MultiTableManager' ) )  {
        
            // echo 'Is a MultiTableManager<br/>';
        
            $this->resultSet->setFirst();
            while( $this->resultSet->moveNext() ) {
                
//                   $row = $this->resultSet->getCurrentRow();
//                  echo 'The row is<pre>'.print_r($row,true).'</pre>';
                $this->searchManager->loadFromArray( $this->resultSet->getCurrentRow() );
                 $skipIndividualManagers = true;
//                  $xml = $this->searchManager->getXMLObject(true,'',$skipIndividualManagers);
//                  echo 'The XML is <pre>'.print_r($xml,true).'</pre>';
                $xmlObject->addXMLObject( $this->searchManager->getXMLObject(true,'',$skipIndividualManagers) );
            }
        
        } else {
        
            // echo 'Is not a MultiTableManager<br/>';
        
            // else
            $this->resultSet->setFirst();
            while( $item = $this->resultSet->getNext( new $this->searchClassName() ) ) {
            
                $xmlObject->addXMLObject( $item->getXMLObject() );
            }// end while
        
        } // end if (is_a() )
        
        return $xmlObject->getXML( $isHeaderIncluded );
	
	} // end getXML()
	
	
    
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


}

?>