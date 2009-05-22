<?php
/**
 * @package p2c_stats
 */ 
/**
 * class RowManager_LocationManager
 * <pre> 
 * Manages records storing Power to Change region names and descriptions
 * </pre>
 * @author Hobbe Smit (Oct 24, 2007)
 */
class  RowManager_LocationManager extends RowManager {

	//CONSTANTS:
	
	/** The name of the DB Table this class manages. */
    const DB_TABLE = 'p2c_stats_location';
    
    /** The SQL description of the DB Table this class manages. */
    /*
     * location_id [INTEGER]  Unique identifier for this particular record
     * location_name [STRING]  The name of the location
     * location_desc [STRING]  The description of the location
     * region_id [INTEGER]  The region that the location is associated with          
     * division_id [INTEGER]  The division that the location's region is associated with     
     * ministry_id [INTEGER]  The ministry that the aforementioned region's division is associated with
     */
    const DB_TABLE_DESCRIPTION = " (                                                                                           
                      `location_id` int(50) NOT NULL auto_increment,                                                                              
                      `location_name` varchar(64) collate latin1_general_ci NOT NULL,                                                             
                      `location_desc` varchar(128) collate latin1_general_ci NOT NULL,                                                            
                      `region_id` int(50) NOT NULL default '0',                                                                                   
                      `division_id` int(50) NOT NULL default '0',                                                                                 
                      `ministry_id` int(20) NOT NULL default '0',                                                                                 
                      PRIMARY KEY  (`location_id`),                                                                                               
                      KEY `FK_location_min` (`ministry_id`),                                                                                      
                      KEY `FK_location_region` (`region_id`),                                                                                     
                      CONSTRAINT `FK_location_region` FOREIGN KEY (`region_id`) REFERENCES `p2c_stats_region` (`region_id`) ON UPDATE CASCADE,    
                      CONSTRAINT `FK_location_min` FOREIGN KEY (`ministry_id`) REFERENCES `p2c_stats_ministry` (`ministry_id`) ON UPDATE CASCADE  
                    ) ENGINE=InnoDB";
    
    /** The fields in the DB Table this class manages. */
    const FIELD_LIST = 'location_id,location_name,location_desc,region_id,division_id,ministry_id';
    
    /** The XML node name for this entry. */
    const XML_NODE_NAME = 'p2c_stats_location';
    

	//VARIABLES:


	//CLASS CONSTRUCTOR
	//************************************************************************
	/**
	 * function __construct
	 * <pre>
	 * Initialize this object.
	 * </pre>
	 * @param $LOC_ID [INTEGER] The unique id of the region record we are managing.
	 * @return [void]
	 */
    function __construct( $LOC_ID=-1 ) 
    {
    
        $dbTableName = RowManager_LocationManager::DB_TABLE;
        $fieldList = RowManager_LocationManager::FIELD_LIST;
        $primaryKeyField = 'location_id';
        $primaryKeyValue = $LOC_ID;
        
        if (( $LOC_ID != -1 ) && ( $LOC_ID != '' )) {
        
            $condition = $primaryKeyField . '=' . $primaryKeyValue;
            
        } else {
            $condition = '';
        }
        $xmlNodeName = RowManager_LocationManager::XML_NODE_NAME;
        parent::__construct( $dbTableName, $fieldList, $primaryKeyField, $primaryKeyValue, $condition, $xmlNodeName);
        
        $this->dbDescription = RowManager_LocationManager::DB_TABLE_DESCRIPTION;

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
    
    
     //************************************************************************
	/**
	 * function getLocationName
	 * <pre>
	 * returns the location's name
	 * </pre>
	 * @return [STRING]
	 */
    function getLocationName()
    {   
        return $this->getValueByFieldName('location_name');
    }  
    
     //************************************************************************
	/**
	 * function getMinistryID
	 * <pre>
	 * returns the ministry ID
	 * </pre>
	 * @return [STRING]
	 */
    function getMinistryID()
    {   
        return $this->getValueByFieldName('ministry_id');
    }  
         
      //************************************************************************
	/**
	 * function getDivisionID
	 * <pre>
	 * returns the division_id
	 * </pre>
	 * @return [STRING]
	 */
    function getDivisionID()
    {   
        return $this->getValueByFieldName('division_id');
    }     
    
     //************************************************************************
	/**
	 * function getRegionID
	 * <pre>
	 * returns the region_id
	 * </pre>
	 * @return [STRING]
	 */
    function getRegionID()
    {   
        return $this->getValueByFieldName('region_id');
    } 
    
     //************************************************************************
	/**
	 * function getLocationID
	 * <pre>
	 * returns the location ID
	 * </pre>
	 * @return [STRING]
	 */
    function getLocationID()
    {   
        return $this->getValueByFieldName('location_id');
    }     
    
    
    //************************************************************************
	/**
	 * function getJoinOnLocationID
	 * <pre>
	 * returns the field used as a join condition for location ID
	 * </pre>
	 * @return [STRING]
	 */
    function getJoinOnLocationID()
    {   
        return $this->getJoinOnFieldX('location_id');
    }    
    
     //************************************************************************
	/**
	 * function getJoinOnRegionID
	 * <pre>
	 * returns the field used as a join condition for region ID
	 * </pre>
	 * @return [STRING]
	 */
    function getJoinOnRegionID()
    {   
        return $this->getJoinOnFieldX('region_id');
    }              
    
    //************************************************************************
	/**
	 * function getJoinOnDivisionID
	 * <pre>
	 * returns the field used as a join condition for division ID
	 * </pre>
	 * @return [STRING]
	 */
    function getJoinOnDivisionID()
    {   
        return $this->getJoinOnFieldX('division_id');
    }
    
    //************************************************************************
	/**
	 * function getJoinOnMinistryID
	 * <pre>
	 * returns the field used as a join condition for ministry ID
	 * </pre>
	 * @return [STRING]
	 */
    function getJoinOnMinistryID()
    {   
        return $this->getJoinOnFieldX('ministry_id');
    }

    /**
	 * function setMinistryID
	 * <pre>
	 * Set the ministry ID for the location
	 * </pre>
     *
	 * @param $ministryID		the ID of the ministry
	 */
    function setMinistryID($ministryID) 
    {
        $this->setValueByFieldName('ministry_id',$ministryID);
    }        
    
   /**
	 * function setDivisionID
	 * <pre>
	 * Set the division ID for the division
	 * </pre>
     *
	 * @param $divisionID		the ID of the division
	 */
    function setDivisionID($divisionID) 
    {
        $this->setValueByFieldName('division_id',$divisionID);
    }
    
     /**
	 * function setRegionID
	 * <pre>
	 * Set the region ID for the region
	 * </pre>
     *
	 * @param $regionID		the ID of the region
	 */
    function setRegionID($regionID) 
    {
        $this->setValueByFieldName('region_id',$regionID);
    }
    
   /**
	 * function setLocationID
	 * <pre>
	 * Set the location ID for the location
	 * </pre>
     *
	 * @param $locationID		the ID of the location
	 */
    function setLocationID($locationID) 
    {
        $this->setValueByFieldName('location_id',$locationID);
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
        return "location_name";
    }

    
    	
}

?>