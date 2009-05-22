<?php
/**
 * @package [ModuleName]
 */ 
/**
 * class RowLabelBridge_[DAObj]
 * <pre> 
 * [DAObjDescription].
 * </pre>
 * @author [CreatorName]
 */
class  RowLabelBridge_[DAObj] extends RowLabelBridge {

	//CONSTANTS:
    
    /** The XML node name for this entry. */
    const XML_NODE_NAME = '[DAObj]';
    

	//VARIABLES:


	//CLASS CONSTRUCTOR
	//************************************************************************
	/**
	 * function __construct
	 * <pre>
	 * Initialize this object.
	 * </pre>
	 * @param $[RAD_STATEVAR] [INTEGER] The unique id of the dataManager.
	 * @param $languageID [INTEGER] The desired language id of the viewer
	 * @param $manager [OBJECT] A Multilingual Manager object for retrieving the label manager object.  (Highly suggest passing one in for creating multiple objects ... like the list object)
	 * @return [void]
	 */
    function __construct( $[RAD_STATEVAR]=-1, $languageID='', $manager=null ) 
    {
    
        $dataManager = new RowManager_[RowManager]( $[RAD_STATEVAR] );
        
        // if a manager object was not provided then create it
        if (is_null( $manager )) {
            $seriesKey = module[ModuleName]::MULTILINGUAL_SERIES_KEY;
            $pageKey = RowManager_[RowManager]::MULTILINGUAL_PAGE_KEY;
            $manager = new MultilingualManager( $languageID, $seriesKey, $pageKey );
        }
        
        $xmlNodeName = RowLabelBridge_[DAObj]::XML_NODE_NAME;
        
        parent::__construct( $dataManager, $manager, $xmlNodeName );
    
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
	 * function getLabel
	 * <pre>
	 * Returns the value commonly used for displaying as a Label (Form Grid
	 * rows, Drop List Labels, etc...).
	 * </pre>
	 * @return [STRING]
	 */
    function getLabel() 
    {
        return [RAD_DAOBJ_LABEL_FIELD];
    } 
    
    
    
    //************************************************************************
	/**
	 * function getLabelKey
	 * <pre>
	 * Returns the properly formatted label key.
	 * </pre>
	 * @return [STRING]
	 */
    function getLabelKey() 
    {
        return '['.$this->dataManager->get[KeyFieldName]().']';
    }    

}

?>