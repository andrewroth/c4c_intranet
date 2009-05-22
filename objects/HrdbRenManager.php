<?php
/**
 * @package NSSPayRoll
 */ 
/**
 * class RowManager_HrdbRenManager
 * <pre> 
 * Manages entries in the HRDB->Ren table.
 * </pre>
 * @author Johnny Hausman/David Cheong/Russ Martin
 */
class  RowManager_HrdbRenManager extends RowManager {

	//CONSTANTS:
	/** The name of the DB Table this class manages. */
    const DB_TABLE = 'ren';
    
    /** The fields in the DB Table this class manages. */
    const FIELD_LIST = 'ren_id,family_id,assignment_id,ren_givenname,ren_surname,ren_preferedname,ren_familyposition,ren_employeestatus,ren_birthday,ren_datejoined,ren_staffaccount,ren_secureemail,ren_imid,ren_mobilephone';
    
    const SINGLE = 'Single';
    const SPOUSE = 'Spouse';
    const HOH = 'Head Of Household';
    
    /** The XML node name for this entry. */
    const XML_NODE_NAME = 'hrdbRen';
    

	//VARIABLES:


	//CLASS CONSTRUCTOR
	//************************************************************************
	/**
	 * function __construct
	 * <pre>
	 * Initialize this object.
	 * </pre>
	 * @param $nssRenID [INTEGER] The unique id of the nssren we are managing.
	 * @return [void]
	 */
    function __construct( $renID=-1 ) 
    {
    
        $dbTableName = RowManager_HrdbRenManager::DB_TABLE;
        $fieldList = RowManager_HrdbRenManager::FIELD_LIST;
        $primaryKeyField = 'ren_id';
        $primaryKeyValue = $renID;
        
        if (( $renID != -1 ) && ( $renID != '' )) {
        
            $condition = $primaryKeyField . '=' . $primaryKeyValue;
            
        } else {
            $condition = '';
        }
        $xmlNodeName = RowManager_HrdbRenManager::XML_NODE_NAME;
        parent::__construct( $dbTableName, $fieldList, $primaryKeyField, $primaryKeyValue, $condition, $xmlNodeName, HR_DB_NAME );
        
        if ($this->isLoaded() == false) {
        
            // uncomment this line if you want the Manager to automatically 
            // create a new entry if the given info doesn't exist.
            // $this->createNewEntry();
        }
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
	 * function getAgeInMonths
	 * <pre>
	 * Returns the ren's Age (# months)
     * </pre>
     * @param $currentDate [DATE] a date to evaluate the age against ('Y-m-d')
	 * @return [INTEGER]
	 */
    function getAgeInMonths( $currentDate=null ) 
    {
    
        if ( is_null( $currentDate ) ) {
            $currentDate = moduleNSSPayRoll::$SYSTEM_DATE;
        }
    
        $birthDate = $this->getBirthday();
        
        // if the date of birth is not set, return an error -1
        if ($birthDate=='') return -1;
        
        list( $bdayYear, $bdayMonth, $bdayDay) = explode('-', $birthDate );
        list( $nowYear, $nowMonth, $nowDay) = explode('-', $currentDate );
        
        $numMonths = ($nowYear - $bdayYear) * 12;
					
        if ( $bdayMonth > $nowMonth) {
            $numMonths = $numMonths - ( $bdayMonth - $nowMonth);
        } else {
            $numMonths = $numMonths + ( $nowMonth - $bdayMonth);
        }
        
        // NOTE: This algorithm gives you the benefit of the doubt
        // It interprets the age as being 'in the month of the 
        // parameter (currentDate) you will have lived this many 
        // months.'  The algorithm does NOT take into account the DAY
        // of the currentDate variable.
        
        return $numMonths;
    }
    


    //************************************************************************
	/**
	 * function getAssignment
	 * <pre>
	 * Returns an HRDBAssignment Object
     * </pre>
	 * @return [OBJECT]
	 */
    function getAssignment() 
    {
        $assignmentID = $this->getAssignmentID();
        return new RowManager_HrdbAssignmentManager( $assignmentID );
    }
    


    //************************************************************************
	/**
	 * function getAssignmentID
	 * <pre>
	 * Returns an assignment_id value
     * </pre>
	 * @return [INTEGER]
	 */
    function getAssignmentID() 
    {
        return (int) $this->getValueByFieldName( 'assignment_id' );
    }
    


    //************************************************************************
	/**
	 * function getBirthday
	 * <pre>
	 * Returns the ren's birthday
     * </pre>
	 * @return [DATE]
	 */
    function getBirthday() 
    {
        return $this->getValueByFieldName( 'ren_birthday' );
    }
    
    
    
    //************************************************************************
	/**
	 * function getStaffAccount
	 * <pre>
	 * Returns the ren's staff account number
     * </pre>
	 * @return [DATE]
	 */
    function getStaffAccount() 
    {
        return $this->getValueByFieldName( 'ren_staffaccount' );
    }
    
    
    


    //************************************************************************
	/**
	 * function getDateJoined
	 * <pre>
	 * Returns the ren's dateJoined
     * </pre>
	 * @return [DATE]
	 */
    function getDateJoined() 
    {
        return $this->getValueByFieldName( 'ren_datejoined' );
    }
    


    //************************************************************************
	/**
	 * function getDisplayName
	 * <pre>
	 * Returns a standard formatted name
     * </pre>
	 * @return [STRING]
	 * modified by Joshua: givenName var contains the prefered name, returning the given name if a prefered name is not found
	 */
    function getDisplayName() 
    {
        $surname = $this->getSurname();
        $givenName = $this->getPreferedName();
        return $surname.', '.$givenName;
    }



    //************************************************************************
	/**
	 * function getNameAndID
	 * <pre>
	 * Returns a standard formatted name including an StaffID for easy identification
     * </pre>
	 * @return [STRING]
     */
    function getNameAndID() 
    {
        $surname = $this->getSurname();
        $givenName = $this->getPreferedName();
        // retrieve the staffid
        $staffID = $this->getStaffAccount();
        return $surname.', '.$givenName.' - '.$staffID ;
    }
    

    function getEmailAddress()
    {
        return $this->getWebUserID() . "@dodomail.net";
    }
    
    
    
    //************************************************************************
	/**
	 * function getEmployeeStatus
	 * <pre>
	 * Returns employee status of ren
     * </pre>
	 * @return [STRING]
	 */
    function getEmployeeStatus() 
    {
        return $this->getValueByFieldName( 'ren_employeestatus' );
    }

    
    
    
    //************************************************************************
	/**
	 * function getFamilyID
	 * <pre>
	 * Returns family_id of ren
     * </pre>
	 * @return [INTEGER]
	 */
    function getFamilyID() 
    {
        return $this->getValueByFieldName( 'family_id' );
    }
    


    //************************************************************************
	/**
	 * function getFamilyMemberList
	 * <pre>
	 * Returns an HRDBFamilyMemberList Object
     * </pre>
	 * @return [OBJECT]
	 */
    function getFamilyMemberList() 
    {
        $familyID = $this->getFamilyID();
        // echo 'FamilyID['.$familyID.']<br/>';
        return new HrdbFamilyMemberList( $familyID );
    }

    
    
    
    //************************************************************************
	/**
	 * function getFamilyPosition
	 * <pre>
	 * Returns ren_familyPosition of ren
     * </pre>
	 * @return [STRING]
	 */
    function getFamilyPosition() 
    {
        return $this->getValueByFieldName( 'ren_familyposition' );
    }

    
    
    
    //************************************************************************
	/**
	 * function getFamilyPositionChild
	 * <pre>
	 * Returns the value of a Child position
     * </pre>
	 * @return [STRING]
	 */
    function getFamilyPositionChild() 
    {
        return "Child";
    }
    
    
    
    //************************************************************************
	/**
	 * function getFieldEmployeeStatus
	 * <pre>
	 * Returns the fieldname of the employee status
     * </pre>
	 * @return [STRING]
	 */
    function getFieldEmployeeStatus() 
    {
        return 'ren_employeestatus';
    }
    
    

    //************************************************************************
	/**
	 * function getGivenName
	 * <pre>
	 * Returns given name of ren
     * </pre>
	 * @return [STRING]
	 */
    function getGivenName() 
    {
        return $this->getValueByFieldName( 'ren_givenname' );
    }
    
    
    
    //************************************************************************
    function getJoinOnRenID()
    {
        return $this->getJoinOnFieldX('ren_id');
    }
    
    
    
    //************************************************************************
    function getJoinOnFamilyID()
    {
        return $this->getJoinOnFieldX('family_id');
    }
    
    
    
    //************************************************************************
    function getJoinOnAssignmentID()
    {
        return $this->getJoinOnFieldX('assignment_id');
    }
    
    
    
    //************************************************************************
	/**
	 * function getPreferedName
	 * <pre>
	 * Returns prefered name of ren
     * </pre>
	 * @return [STRING]
	 */
    function getPreferedName() 
    {
        $name = $this->getValueByFieldName( 'ren_preferedname' );
        if ($name=='') {
            $name=$this->getValueByFieldName( 'ren_givenname' );
        }
        return $name;
    }
    
    
    
    
    //************************************************************************
	/**
	 * function getIMID
	 * <pre>
	 * Returns instant messenger id of ren
     * </pre>
	 * @return [STRING]
	 */
    function getIMID() 
    {
        return $this->getValueByFieldName( 'ren_imid' );
    }
    
    
    
    //************************************************************************
	/**
	 * function getID
	 * <pre>
	 * Returns ID of ren
     * </pre>
	 * @return [STRING]
	 */
    function getID() 
    {
        return $this->getValueByFieldName( 'ren_id' );
    }
    
    
    
    //************************************************************************
    function getPayrollLabel()
    {       
        // Note: no region is included
        $labelMaster = new obj_LabelMaster();
        return $labelMaster->getNSPayrollNoRegionLabelPrefNameFirst( $this->getSurname(), $this->getPreferedName(), $this->getStaffAccount() );
    }
    
    
    
    //************************************************************************
	/**
	 * function getLabel
	 * <pre>
	 * Returns the value commonly used for displaying as a Label (Form Grid
	 * rows, Drop List Labels, etc...).
	 * </pre>
	 * @return [STRING]
	 */
    function getLabel( )
    {   
        return $this->getPayrollLabel();
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
        return "////";
    }
    
    
    
    /**
     * finds ren ID given an NS's sub account number from payroll
     */    
    function getRenIDFromSubAccount($subAccount)
    {
        //remove leading extra info from subaccount number
        $condition = "ren_staffaccount LIKE '%".$subAccount . "%'";
        //$condition = "ren_staffaccount = $subAccount";
        $this->setDBCondition($condition);
        $this->loadFromDB();
        $retVal = $this->getValueByFieldName( 'ren_id' );
        return $retVal;
    }
    
    
    
    //************************************************************************
    function getRenLabel()
    {
        $labelMaster = new obj_LabelMaster();
        return $labelMaster->getRenLabel( $this->getSurname(), $this->getPreferedName() );
    }
    
    
    
    //************************************************************************
    function getLabelRegionLastPrefAccount( $region )
    {
        $labelMaster = new obj_LabelMaster();
        return $labelMaster->getNSPayrollLabel( $this->getPreferedName(), $this->getSurname(), $this->getStaffAccount(), $region );
    }
    
    
    
    //************************************************************************
    function getLabelRegionLastPref( $region )
    {
        $labelMaster = new obj_LabelMaster();
        return $labelMaster->getRenWithRegionLabel( $this->getPreferedName(), $this->getSurname(), $region );
        
    }


    
    //************************************************************************
	/**
	 * function getMobilePhoneNumber
	 * <pre>
	 * Returns mobile phone number of ren
     * </pre>
	 * @return [STRING]
	 */
    function getMobilePhoneNumber()
    {
        return $this->getValueByFieldName( 'ren_mobilephone' );
    }
    
    
    
    //************************************************************************
	/**
	 * function getTenureInMonths
	 * <pre>
	 * Returns the ren's tenure (# months)
     * </pre>
     * @param $currentDate [DATE] a date to evaluate the age against ('Y-m-d')
	 * @return [INTEGER]
	 */
    function getTenureInMonths( $currentDate=null ) 
    {
        if ( is_null($currentDate) )
        {
            $currentDate = moduleNSSPayRoll::$SYSTEM_DATE;
        }
    
        $joinedDate = $this->getDateJoined();
        
        // if the date joined is not set, return as an error -1
        if ($joinedDate=='') return -1;
        
        list( $joinedYear, $joinedMonth, $joinedDay) = explode('-', $joinedDate );
        list( $nowYear, $nowMonth, $nowDay) = explode('-', $currentDate );
        
        $numMonths = ($nowYear - $joinedYear) * 12;
					
        if ( $joinedMonth > $nowMonth) {
            $numMonths = $numMonths - ( $joinedMonth - $nowMonth);
        } else {
            $numMonths = $numMonths + ( $nowMonth - $joinedMonth);
        }
        
        // NOTE: This algorithm gives you the benefit of the doubt
        // It interprets the tenure as being 'in the month of the 
        // parameter (currentDate) you will have served this many 
        // months'.  The algorithm does NOT take into account the DAY
        // of the currentDate variable.
        
        return $numMonths;
    }
    

    
    //************************************************************************
    function getFieldIdentifierFamilyPosition()
    {
        return 'ren_familyposition';
    }
    
    

    //************************************************************************
	/**
	 * function getSecureEmail
	 * <pre>
	 * Returns secure email address of ren
     * </pre>
	 * @return [STRING]
	 */
    function getSecureEmail() 
    {
        return $this->getValueByFieldName( 'ren_secureemail' );
    }


    
    //************************************************************************
	/**
	 * function getSpouse
	 * <pre>
	 * Returns spouse of current ren
     * </pre>
	 * @return [STRING]
	 */
    function getSpouse() 
    {
        $spouse = new RowManager_HrdbRenManager();
        
        // if current ren is not single and not child
        if ((!$this->isSingle() ) && (!$this->isChild() ) ) {
        
            // get current familyID
            $currentFamilyID = $this->getFamilyID();
            
            // get opposite familyPosition
            $currentFamilyPosition = $this->getFamilyPosition();
            switch( $currentFamilyPosition ) {
                case RowManager_HrdbRenManager::HOH:
                    $spouseFamilyPosition = RowManager_HrdbRenManager::SPOUSE;
                    break;
                    
                case RowManager_HrdbRenManager::SPOUSE:
                    $spouseFamilyPosition = RowManager_HrdbRenManager::HOH;
                    break;
                    
            }
            
            // get list of matching ren (hopefully just 1)
            $spouse->setFamilyID( $currentFamilyID );
            $spouse->setFamilyPosition( $spouseFamilyPosition );
            $list = $spouse->getListIterator();
            
            // get 1st entry
            $foundSpouse = $list->getNext();
            
            // return entry
            $spouse = $foundSpouse;
            
        } // end if
        
        return $spouse;
    }


    
    //************************************************************************
	/**
	 * function getSurname
	 * <pre>
	 * Returns surname of ren
     * </pre>
	 * @return [STRING]
	 */
    function getSurname() 
    {
        return $this->getValueByFieldName( 'ren_surname' );
    }
    
    
    
    //************************************************************************
	/**
	 * function isChild
	 * <pre>
	 * True if ren is a Child. False otherwise.
     * </pre>
	 * @return [BOOL]
	 */
    function isChild() 
    {
        $position = $this->getFamilyPosition();
        return ( $position == $this->getFamilyPositionChild() );
    }
    
    
    
    //************************************************************************
    function isHOH()
    {
        return ( $this->getFamilyPosition() == RowManager_HrdbRenManager::HOH  );
    }
    
    
    
    //************************************************************************
    function isMarried()
    {
        return ( $this->isSpouse() || $this->isHOH() );
    }
    
    
    
    //************************************************************************
    function isSingle()
    {
        return ( $this->getFamilyPosition() == RowManager_HrdbRenManager::SINGLE  );
    } // end isSpouse()
    
    
    
    //************************************************************************
    function isSpouse()
    {
        return ( $this->getFamilyPosition() == RowManager_HrdbRenManager::SPOUSE  );
    } // end isSpouse()
    
    
    
    //************************************************************************
	/**
	 * function loadByViewerID
	 * <pre>
	 * loads ren by viewerID
     * </pre>
	 * @return [STRING]
	 */
    function loadByViewerID($viewerID)
    {
        $accessManager = new RowManager_HrdbAccessManager();
        $accessManager->loadByViewerID($viewerID);
        $condition = "ren_id=".$accessManager->getRenID();
        return $this->loadByCondition($condition);
        //return $viewer;
    }
    
    
    
    //************************************************************************
	/**
	 * function setFamilyID
	 * <pre>
	 * sets family_id of ren
     * </pre>
     * @param $familyID [INTEGER] the value for the family_id
	 * @return [void]
	 */
    function setFamilyID( $familyID ) 
    {
        $this->setValueByFieldName( 'family_id', $familyID );
    }
    
    
    
    //************************************************************************
	/**
	 * function setFamilyPosition
	 * <pre>
	 * sets ren_familyposition of ren
     * </pre>
     * @param $position [STRING] the value for the family position
	 * @return [void]
	 */
    function setFamilyPosition( $position ) 
    {
        $this->setValueByFieldName( 'ren_familyposition', $position );
    }
    
    
    
    //************************************************************************
	/**
	 * function setEmployeeStatus
	 * <pre>
	 * Sets the ren's employee status 
     * </pre>
     * @param $val [STRING] the new employee status
	 * @return [void]
	 */
    function setEmployeeStatus( $val )
    {
        return $this->setValueByFieldName( 'ren_employeestatus', $val );
    }
    
    
    
    //************************************************************************
	/**
	 * function setIMID
	 * <pre>
	 * Sets the ren's instant messenger id
     * </pre>
     * @param $email [STRING] the instant messenger id
	 * @return [void]
	 */
    function setIMID( $imid ) 
    {
        $this->setValueByFieldName( 'ren_imid', $imid );
    }
    
    


    //************************************************************************
	/**
	 * function setMobilePhoneNumber
	 * <pre>
	 * Sets the ren's mobile phone number
     * </pre>
     * @param $email [STRING] the mobile phone number
	 * @return [void]
	 */
    function setMobilePhoneNumber( $mobilephonenumber ) 
    {
        $this->setValueByFieldName( 'ren_mobilephone', $mobilephonenumber );
    }

    
    //************************************************************************
	/**
	 * function setSecureEmail
	 * <pre>
	 * Sets the ren's secure email address
     * </pre>
     * @param $email [STRING] the secure email
	 * @return [void]
	 */
    function setSecureEmail( $email ) 
    {
        $this->setValueByFieldName( 'ren_secureemail', $email );
    }
    
    
    //************************************************************************
	/**
	 * function setStaffAccount
	 * <pre>
	 * Sets the ren's staff account number
     * </pre>
     * @param $account [STRING] the new Staff Account
	 * @return [void]
	 */
    function setStaffAccount( $account ) 
    {
        $this->setValueByFieldName( 'ren_staffaccount', $account );
    }

    	
}

?>