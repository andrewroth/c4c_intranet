<?php
/**
 * @package NSSPayRoll
 */ 
/**
 * class HrdbFamilyMemberList
 * <pre> 
 * This object manages the listing of the HRDB->city table elements.
 * </pre>
 * @author Johnny Hausman/David Cheong
 */
class  HrdbFamilyMemberList extends ListIterator {

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
    function __construct(  $familyID, $sortBy='' ) 
    {
        $searchManager = new RowManager_HrdbRenManager();
        
        // NOTE: if you need to narrow the field of the search then uncommnet
        // the following and set the proper search criteria.
        $searchManager->setFamilyID( $familyID );
        $searchManager->setSortOrder( $sortBy );
        
        parent::__construct( $searchManager );
        
    }
	
}

?>