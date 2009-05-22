<?php
/**
 * @package AIObjects
 */ 
/**
 * class RowLabelBridge
 * <pre> 
 * This object manages a relationship between an entry in a table ( managed by
 * a Row Manager Object) and it's related labels in the multilingual Label 
 * system.
 * </pre>
 * @author Johnny Hausman
 */
class  RowLabelBridge extends MultiTableManager {

	//CONSTANTS:
    

	//VARIABLES:
	
	
	/** @var [BOOL] Status of wether the object was successfully initialized. */
	protected $isLoaded;
	
	/** @var [OBJECT] Primary DA Object. */
	protected $dataManager;
	
	/** @var [OBJECT] Label Manager Object. */
	protected $labelManager;
	
	/** @var [OBJECT] Generic MultiLingual Manager Object. */
	protected $multiLingualManager;
	
	/** @var [STRING] XML root node name for this object. */
	protected $xmlNodeName;


	//CLASS CONSTRUCTOR
	//************************************************************************
	/**
	 * function __construct
	 * <pre>
	 * Initialize this object.  The different manager objects are expected to
	 * be provided from the child of this object.
	 * </pre>
	 * @param $rowManager [OBJECT] The Row Manager object.
	 * @param $multiLingualManager [OBJECT] Multilingual Manager Object
	 * @param $xmlNodeName [STRING] The xml node name for this object
	 * @return [void]
	 */
    function __construct( $rowManager, $multiLingualManager, $xmlNodeName='' ) 
    {
        // Prepare Parent constructor
        if ( $xmlNodeName != '' ) {
            $this->xmlNodeName = $xmlNodeName;
        } else {
            $this->xmlNodeName = get_class( $rowManager );
        }  
        parent::__construct( $xmlNodeName );
        
        $this->dataManager = $rowManager;
        
        $this->multiLingualManager = $multiLingualManager;
        $this->multiLingualManager->createContext();  

          
        $this->loadLabelManager();

        
        $this->addRowManager( $rowManager );
        
        $joinCondition = new JoinPair( $rowManager->getKeyField(), $this->labelManager->getKeyField() );
        $this->addRowManager( $this->labelManager, $joinCondition );
        
    
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
	 * function createNewEntry
	 * <pre>
	 * Creates a new table entry in the DB for these objects to manage.
	 * </pre>
     * @param $doAllowPrimaryKeyUpdate [BOOL] allow insertion of primary key
     * @param $viewerLanguageID [INTEGER] overwrite languageManager->language_id 
     * with this value
	 * @return [void]
	 */
    function createNewEntry( $doAllowPrimaryKeyUpdate=false, $viewerLanguageID=-1 ) 
    {   
        // create a new entry for the dataManager
        $this->dataManager->createNewEntry( );
        
        // use the new Unique ID of the dataManager to create a unique key
        $key = '['.$this->dataManager->getKeyField(). $this->dataManager->getID().']';
        
        // update the "PrimaryKeyField" value for the new entry
        $this->values[ $this->primaryKeyField ] = $this->dataManager->getID();
        
        // now go back and update the dataManager to have this key
        $this->dataManager->setLabel( $key );   
        $this->dataManager->updateDBTable();
        
        // store key in labelManager
        $this->labelManager->setKey( $key ); 
        
        // NOTE: in the case of the site language table, we must manage the 
        // viewerLanguageID seperatly.  If this value is passed in, then 
        // update the labelManager's language ID to this value. 
        if ($viewerLanguageID != -1 ) {
            $this->labelManager->resetFieldsOfInterest();
            $this->labelManager->setLanguageID( $viewerLanguageID );
        }
        $this->labelManager->createNewEntry();
        
        $currentLanguageID = $this->labelManager->getLanguageID();
        $currentLabel = $this->labelManager->getLabel();
        $this->labelManager->resetFieldsOfInterest();
        
        // now for each possible language on site 
        $languageManager = new RowManager_LanguageManager();
        $languageList = $languageManager->getListIterator();
        $languageList->setFirst();
        while( $language = $languageList->getNext() ) {
        
            // make sure it is not the one we just entered
            if ( $language->getID() != $currentLanguageID ) {  
            
                // set the languageID to new language         
                $this->labelManager->setLanguageID( $language->getID() );
                
                // mark label as untranslated
                $unXlatedText = '['.$language->getCode().']'.$currentLabel;
                $this->labelManager->setLabel( $unXlatedText );
                
                // create new entry
                // NOTE:  here we tell it to ignore the xlation updates
                // since we don't want our new entrys unmarking existing
                // xlation entries...
                $this->labelManager->createNewEntry( false, true);
            }  
        }
        


    }
    
    
    
    //************************************************************************
	/**
	 * function deleteEntry
	 * <pre>
	 * Updates the DB table info.
	 * </pre>
	 * @return [void]
	 */
    function deleteEntry() 
    {   
        parent::deleteEntry();
        
        // now make sure that other language versions linked to this entry
        // are also removed ...
        // make a new labelManager since current one had had it's fields limited
        // and we need to have the id fields for the load operation ...
        $labelManager = new RowManager_MultilingualLabelManager();
        $key = $this->labelManager->getKey();
        $pageID = $this->labelManager->getPageID();
        while( $labelManager->loadByKeyInfo( $pageID, $key ) )
        {
            $labelManager->deleteEntry();
        }
    }
    
    
    
    //************************************************************************
	/**
	 * function getDataManager
	 * <pre>
	 * Returns the dataManager. Primarily used in List Iterators.
	 * </pre>
	 * @return [OBJECT]
	 */ 
    function getDataManager()
    {
        return $this->dataManager;
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
    function getLabel()
    {
        if ($this->labelTemplate == '') {
        
            $label =  $this->labelManager->getLabel();
            
        } 
        else
        {
            $label = parent::getLabel();
        }
        
        return $label;
    }
    
    
    
    //************************************************************************
	/**
	 * function getListIterator
	 * <pre>
	 * Returns a ListIterator object based on this object.
	 * </pre>
	 * @param $sortBy [STRING] the name of the field to sort by (can be a
	 * comma seperated list).
	 * @return [OBJECT]
	 */
	 function getListIterator( $sortBy='' ) 
	 {
	   // for a RowLabelBridge we will default to sorting by the label
	   if ( $sortBy == '') {
    	   $sortBy = 'label_label';
	   }
	   
	   return parent::getListIterator( $sortBy );
	   
	 }
    
    
    
    //************************************************************************
	/**
	 * function getMultilingual
	 * <pre>
	 * Returns the multiLingualManager. Primarily used in List Iterators.
	 * </pre>
	 * @return [OBJECT]
	 */ 
    function getMultilingual()
    {
        return $this->multiLingualManager;
    }
    
    
    
    //************************************************************************
	/**
	 * function loadFromDB
	 * <pre>
	 * Loads the row of data to manage
	 * </pre>
	 * @return [BOOL] True if load successful, False otherwise.
	 */
    function loadFromDB() 
    {
        $isSuccessful = $this->dataManager->loadFromDB();
        
        if ( $isSuccessful ) {
            $this->loadLabelManager();
        }
        
        return $isSuccessful;
    }
    
    
    
    //************************************************************************
	/**
	 * function loadLabelManager
	 * <pre>
	 * Loads a Label Manager based on the dataManager's key
	 * </pre>
	 * @return [BOOL] True if load successful, False otherwise.
	 */
    function loadLabelManager() 
    {
        $key = $this->dataManager->getLabel();
        $this->labelManager = $this->multiLingualManager->getLabelManager( $key );
        return $this->labelManager->isLoaded();        
    }
    
    
    
    //************************************************************************
	/**
	 * function setFieldsOfInterest
	 * <pre>
	 * sets the fields of interest to the provided list.
	 * </pre>
	 * @param $list [STRING] comma delimited list of fields to work with
	 * @return [void]
	 */
    function setFieldsOfInterest($list) 
    {
        // Now a Row Manager needs to have it's key field remain in the dataManager.
        $keyField = $this->dataManager->getKeyField();
        $list .= ','.$keyField;
        
        // The labelManager also needs to keep it's key field ...
        $keyField = $this->labelManager->getKeyField();
        $list .= ','.$keyField;
             
        parent::setFieldsOfInterest( $list );
    } 
    
    
    
    //************************************************************************
	/**
	 * function updateDBTable
	 * <pre>
	 * Updates the DB table info.
	 * </pre>
	 * @return [void]
	 * /
    function updateDBTable() 
    {   
        // echo 'Inside RowLabelBridge::updateDBTable</br>';
        $this->dataManager->updateDBTable();
        
        // if the current labelManager doesn't have a page ID (it was newly 
        // created) then add the current Page ID from the multilingual Manager
        // before updating.
        $pageID = $this->labelManager->getPageID();
        // echo 'The pageID is ['.$pageID.']</br>';
        if ( $pageID <= 0 ) {
            $newPageID = $this->multiLingualManager->getPageID();
            $this->labelManager->setPageID( $newPageID );
            // echo 'The newPageID is ['.$newPageID.']</br>';
        }
        $this->labelManager->updateDBTable();        
    }
*/    

    

}

?>