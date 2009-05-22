<?php
/**
 * @package NSSPayRoll
 */ 
/**
 * class HrdbRenList
 * <pre> 
 * This object manages a multi table result set. Allowing you to iterate through
 * the result entries and generate the appropriate RowManagers to work with it.
 * This one pulls all NS from the hrdb.ren table
 * </pre>
 * @author Johnny Hausman/David Cheong
 */
class  HrdbRenList extends ListIterator {

    protected $requireRegion;

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
    function __construct( $requireRegion=false, $getOnlyNS=false, $includeChildren=false, $includeAlumni=false, $sortBy='', $excludeSpouse=false ) 
    {
        $this->requireRegion = $requireRegion;
        
        $multiTableManager = new MultiTableManager();
        
        // ----- STEP ONE: Deal with the ren table
        $renManager = new RowManager_HrdbRenManager();
/*        if( $getOnlyNS )
        {
            $renManager->setEmployeeStatus('NS');
        }
*/
        
        $multiTableManager->addRowManager($renManager);
        
        if( $getOnlyNS ) 
        {
            // we also need to 
            $condition = $multiTableManager->constructSearchCondition( $renManager->getFieldEmployeeStatus(), OP_EQUAL, 'NS' );
            $condition .= ' OR ';
            $condition .= $multiTableManager->constructSearchCondition( $renManager->getFieldEmployeeStatus(), OP_EQUAL, 'ANS' );
            $multiTableManager->addSearchCondition( $condition );
        }
        
        if( !$includeChildren )
        {
            $multiTableManager->constructSearchCondition( $renManager->getFieldIdentifierFamilyPosition(), OP_NOT_EQUAL, "Child", true);
        }
        if( $excludeSpouse )
        {
            $multiTableManager->constructSearchCondition( $renManager->getFieldIdentifierFamilyPosition(), OP_NOT_EQUAL, 'Spouse', true );
        }
        
        // STEP ONE COMPLETE
        
        // ----- STEP TWO: Join with the family table
        $familyManager = new RowManager_FamilyManager();
        if ( !$includeAlumni )
        {
            // we want only those who are not alumni
            $familyManager->setAlumni( false );
        }
        $multiTableManager->addRowManager($familyManager, new JoinPair( $renManager->getJoinOnFamilyID(), $familyManager->getJoinOnFamilyID() ));
        
        // STEP TWO COMPLETE
        
        // ------ STEP THREE: Check if region is needed
        if ( $requireRegion )
        {   
            // assignment     
            $assManager = new RowManager_HrdbAssignmentManager();
            $multiTableManager->addRowManager($assManager, new JoinPair( $renManager->getJoinOnAssignmentID(), $assManager->getJoinOnAssignmentID() ));
            
            // city
            $cityManager = new RowManager_HrdbCityManager();
            $multiTableManager->addRowManager($cityManager, new JoinPair( $assManager->getJoinOnCityID(), $cityManager->getJoinOnCityID() ));
            
            // province
            $provinceManager = new RowManager_ProvinceManager();
            $multiTableManager->addRowManager($provinceManager, new JoinPair( $cityManager->getJoinOnProvinceID(), $provinceManager->getJoinOnProvinceID() ));
            
            // region
            $regionManager = new RowManager_HrdbRegionManager();
            $multiTableManager->addRowManager($regionManager, new JoinPair( $provinceManager->getJoinOnRegionID(), $regionManager->getJoinOnRegionID() ));
            
        }
        // STEP THREE COMPLETE
        
        $multiTableManager->setSortOrder( $sortBy );
        
        parent::__construct( $multiTableManager, 'RowManager_HrdbRenManager' );
        
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
	 * function getDropListArray
	 * <pre>
	 * Returns the list Objects in an array (used by form templates for drop
	 * lists).
	 * </pre>
	 * @param $labels [OBJECT] a multilingual label object for converting 
	 * label into the current language.
	 * @return [ARRAY]
	 */
    function getDropListArray( $showAccountNum=false )
    {
        // create an empty array to fill out
        $resultArray = array();
        
        // for each item in the list
        $this->setFirst();
        while( $this->moveNext() ) 
        {
            // get the ren object  
            $ren = $this->getCurrent( new RowManager_HrdbRenManager() );
            
            $label = '';
            if ( $this->requireRegion )
            {
                // get the region object
                $region = $this->getCurrent( new RowManager_HrdbRegionManager() );
                if ( $showAccountNum ) 
                {
                    $label = $ren->getLabelRegionLastPrefAccount( $region->getLabel() );
                }
                else
                {
                    $label = $ren->getLabelRegionLastPref( $region->getLabel() );
                }
            }
            else
            {
                $label = $ren->getLabel();
            }
            
            // store item label as is
            $resultArray[ $ren->getID() ] = $label;
        }
        
        // return result array 
        return $resultArray;
        
    }  // end getDropListArray()
    
}

?>