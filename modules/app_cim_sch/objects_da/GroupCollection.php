<?php

class  GroupCollection {

	//CONSTANTS:

	//VARIABLES:
	
	protected $campusName;
	protected $campusID;
	protected $arrayOfGroups;


	//CLASS CONSTRUCTOR
    function __construct( $campusName, $campusID, $arrayOfGroups ) 
    {
        $this->campusName = $campusName;
        $this->campusID = $campusID;
        $this->arrayOfGroups = $arrayOfGroups;
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
	 * function getCampusName
	 * <pre>
	 * returns the campus name
	 * </pre>
	 * @return [STRING]
	 */
    function getCampusName()
    {
        return $this->campusName;
    }
    /**
	 * function getCampusID
	 * <pre>
	 * returns the campus ID
	 * </pre>
	 * @return [STRING]
	 */
    function getCampusID()
    {
        return $this->campusID;
    }
    /**
	 * function getGroups
	 * <pre>
	 * returns the groups
	 * </pre>
	 * @return [STRING]
	 */
    function getGroups()
    {
        return $this->arrayOfGroups;
    }
}

?>