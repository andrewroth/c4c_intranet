<?php
/**
 * @package cim_hrdb
 */ 
/**
 * class RowManager_PersonYearManager
 * <pre> 
 * Manages data associated with a person-year record
 * </pre>
 * @author CIM Team
 */
class  RowManager_PersonYearManager extends RowManager {

	//CONSTANTS:
	
	const FIRST_YEAR = 1;
	const SECOND_YEAR = 2;
	const THIRD_YEAR = 3;
	const FOURTH_YEAR = 4;
	const FIFTH_YEAR = 5;
	const FIRST_YEAR_GRAD = 6;
	const SECOND_YEAR_GRAD = 7;
	const THIRD_YEAR_GRAD = 8;
	const OTHER = 9;
	const ALUMNI = 10;
	
	/** The name of the DB Table this class manages. */
    const DB_TABLE = 'cim_hrdb_person_year';
    
    /** The SQL description of the DB Table this class manages. */
    /*
     * person_year_id [INTEGER]  a person-year's unique id
     * person_id [INTEGER]  A person's unique id
     * year_id [INTEGER]  A foreign key linked to 'cim_hrdb_year_in_school
     */
    const DB_TABLE_DESCRIPTION = " (
  person_year_id int(50) NOT NULL  auto_increment,
  person_id int(50) NOT NULL default '0',
  year_id int(50) NOT NULL default '0',
  grad_date date NOT NULL default '0000-00-00',
  PRIMARY KEY (person_year_id)
) TYPE=MyISAM";
    
    /** The fields in the DB Table this class manages. */
    const FIELD_LIST = 'personyear_id,person_id,year_id,grad_date';
    
    /** The XML node name for this entry. */
    const XML_NODE_NAME = 'person_year';
    

	//VARIABLES:


	//CLASS CONSTRUCTOR
	//************************************************************************
	/**
	 * function __construct
	 * <pre>
	 * Initialize this object.
	 * </pre>
	 * @param $PERSON_YEAR_ID [INTEGER] The unique id of the person-year we are managing.
	 * @return [void]
	 */
    function __construct( $PERSON_YEAR_ID=-1 ) 
    {
    
        $dbTableName = RowManager_PersonYearManager::DB_TABLE;
        $fieldList = RowManager_PersonYearManager::FIELD_LIST;
        $primaryKeyField = 'personyear_id';
        $primaryKeyValue = $PERSON_YEAR_ID;
        
        if (( $PERSON_YEAR_ID != -1 ) && ( $PERSON_YEAR_ID != '' )) {
        
            $condition = $primaryKeyField . '=' . $primaryKeyValue;
            
        } else {
            $condition = '';
        }
        $xmlNodeName = RowManager_PersonYearManager::XML_NODE_NAME;
        parent::__construct( $dbTableName, $fieldList, $primaryKeyField, $primaryKeyValue, $condition, $xmlNodeName);
        
        $this->dbDescription = RowManager_PersonYearManager::DB_TABLE_DESCRIPTION;

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
        //return $this->getValueByFieldName( 'applicant_codename' );
    }
    /**
	 * function loadByPerson
	 * <pre>
	 *  Loads the object with the record corresponding to the given personID
	 * </pre>
	 * @return [ void]
	 */
    function loadByPersonID( $personID )
    {
      $this->loadByCondition( 'person_id='.$personID );
      return;
    }
    
    //************************************************************************
	/**
	 * function getJoinOnPersonID
	 * <pre>
	 * returns the field used as a join condition for person_id
	 * </pre>
	 * @return [STRING]
	 */
    function getJoinOnPersonID()
    {   
        return $this->getJoinOnFieldX('person_id');
    }
    
    
   //************************************************************************
	/**
	 * function getJoinOnPersonYearID
	 * <pre>
	 * returns the field used as a join condition for person_year_id
	 * </pre>
	 * @return [STRING]
	 */
    function getJoinOnPersonYearID()
    {   
        return $this->getJoinOnFieldX('personyear_id');
    }
    
   //************************************************************************
	/**
	 * function getJoinOnYearID
	 * <pre>
	 * returns the field used as a join condition for year_id
	 * </pre>
	 * @return [STRING]
	 */
    function getJoinOnYearID()
    {   
        return $this->getJoinOnFieldX('year_id');
    }   
    


   //************************************************************************
	/**
	 * function getPersonID
	 * <pre>
	 * Gets the id for the person
	 * </pre>
	 * @param $title [INT] The person id.
	 * @return [void]
	 */
    function getPersonID()
    {
        return $this->getValueByFieldName('person_id');
    }
    
    //************************************************************************
	/**
	 * function getLabelField
	 * <pre>
	 * Returns the field to use in the label routines.
	 * </pre>
	 * @return [STRING]
	 */
    function getLabelField()
    {
        return 'year_id';
    }
    
    /**
	 * function setPersonID
	 * <pre>
	 * sets the Person's ID
	 * </pre>
	 * @return [STRING]
	 */
    function setPersonID( $personID )
    {
        $this->setValueByFieldName( 'person_id', $personID );
    }
    
    /**
	 * function setPersonYearID
	 * <pre>
	 * sets the Person's Year ID
	 * </pre>
	 * @return [void]
	 */
    function setPersonYearID( $personYearID )
    {
        $this->setValueByFieldName( 'personyear_id', $personYearID );
    }
       
    

    // usage: use RowManager_PersonYearManager::<CONSTANT> to set the year
    function setYear( $year_id )
    {
	    if (is_int($year_id)) {
		    
		    switch ( $year_id ) {
			    
			    case RowManager_PersonYearManager::FIRST_YEAR:
			    	$this->setValueByFieldName( 'year_id', RowManager_PersonYearManager::FIRST_YEAR );
			    	break;
			    	
			    case RowManager_PersonYearManager::SECOND_YEAR:
			    	$this->setValueByFieldName( 'year_id', RowManager_PersonYearManager::SECOND_YEAR );
			    	break;

			    case RowManager_PersonYearManager::THIRD_YEAR:
			    	$this->setValueByFieldName( 'year_id', RowManager_PersonYearManager::THIRD_YEAR );
			    	break;
			    	
			    case RowManager_PersonYearManager::FOURTH_YEAR:
			    	$this->setValueByFieldName( 'year_id', RowManager_PersonYearManager::FOURTH_YEAR );
			    	break;
			    		
			    case RowManager_PersonYearManager::FIRST_YEAR_GRAD:
			    	$this->setValueByFieldName( 'year_id', RowManager_PersonYearManager::SECOND_YEAR );
			    	break;

			    case RowManager_PersonYearManager::SECOND_YEAR_GRAD:
			    	$this->setValueByFieldName( 'year_id', RowManager_PersonYearManager::THIRD_YEAR );
			    	break;
			    	
			    case RowManager_PersonYearManager::THIRD_YEAR_GRAD:
			    	$this->setValueByFieldName( 'year_id', RowManager_PersonYearManager::FOURTH_YEAR );
			    	break;
			    			    	
			    case RowManager_PersonYearManager::OTHER:			    			    				    	
			    default:
			    	$this->setValueByFieldName( 'year_id', RowManager_PersonYearManager::OTHER );
		    }
		}
  		
      return;
    }   
    
    	
}

?>