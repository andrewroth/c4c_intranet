<?php




	 //************************************************************************
	/**    
    
     * function viewer_guid_conenct
	 * <pre>
	 * 
	 * If user has an exisitng intranet login ($new_viewer == false):
	 * Given GUID and viewer_id, inject GUID into existing viewer
	 *
	 * If user never had an intranet login ($new_viewer == true):
	 * Given a GUID, create new viewer, person, put into access group, etc.
	 *
	 * @param $guid [String] [user's GUID]
	 * @param $viewer [Int] [user's view_id]
	 * @param $new_viewer [BOO] [true when user never had an intranet login]
	 * </pre>
	 * @return [void]
     *
     *
	 */
	 
    function viewer_guid_connect ($guid, $viewer, $new_viewer)
    {
        if ($new_viewer)
            {
                 // 1. create new viewer
				        $viewerManager = new RowManager_ViewerManager();
				        $viewerManager->setGUID( $guid ); // GUID	
				        $viewerManager->setLanguageID( 1 ); // english
				        // TODO this value should not be hard-coded for the account group
				        $viewerManager->setAccountGroupID( 15 ); // the 'unknown' group
				        $viewerManager->setIsActive( true );
				        $viewerManager->createNewEntry();
				        $viewerID = $viewerManager->getID(); // get the ID of the newly created viewer
				
			
				        // 2. put into the 'all' access group
				        // PART A
				        $viewerAccessGroupManager = new RowManager_ViewerAccessGroupManager();
				        $viewerAccessGroupManager->setViewerID( $viewerID );
				        $viewerAccessGroupManager->setAccessGroupID( ALL_ACCESS_GROUP ); // add to the 'all' access group
				        $viewerAccessGroupManager->createNewEntry();
				        // PART B
				        $viewerAccessGroupManager = new RowManager_ViewerAccessGroupManager();
				        $viewerAccessGroupManager->setViewerID( $viewerID );
				        $viewerAccessGroupManager->setAccessGroupID( SPT_APPLICANT_ACCESS_GROUP ); // add to the 'SPT-Student' access group
				        $viewerAccessGroupManager->createNewEntry();
						
						   // 3. create new person (or grab person_id from existing record)
					        $personManager = new RowManager_PersonManager();
					        $personManager->setFirstName( '' );
					        $personManager->setLastName( '' );
					       
					        $personManager->setEmail( '' );
					        $personManager->setSortOrder( 'person_id' );
					        $personManager->setAscDesc( 'DESC' ); 	// sort by descending person IDs

					        $personList = $personManager->getListIterator();
					        $personArray = $personList->getDataList();
						       
				     //create new entry
						 $personManager->createNewEntry();
						 $personID = $personManager->getID(); // get the ID of the newly created person
				
					        // 4. create an access table entry for this (viewer,person) combo
					        $accessManager = new RowManager_AccessManager();
					        $accessManager->setViewerID( $viewerID );
					        $accessManager->setPersonID( $personID );
					        $accessManager->createNewEntry();
                    
                    } else {
                            
                                
                            $viewerManager = new RowManager_ViewerManager($viewer);
                            //echo ($viewerManager->getID());
                            $viewerManager->setGUID( $guid ); // GUID
                            $viewerManager->updateDBTable();
                            
                            }
                          
                          
}  
    



?>