<?php
/**
 * @package EmailTemplates
 */ 
/**
 * class RowManager_EmailTemplateManager
 * <pre> 
 * row manager for templates.
 * </pre>
 * @author Reuben Uy
 */
class  RowManager_EmailTemplateManager extends RowManager {

	//CONSTANTS:
	/** The name of the DB Table this class manages. */
    const DB_TABLE = 'emailtemplates_emailtemplate';
    
    /** The SQL description of the DB Table this class manages. */
    /*
     * template_id [INTEGER]  The primary key for templates
     * app_id [INTEGER]  Describes which app this template belongs to
     * template_key [STRING]  key for template
     * template_isactive [BOOL]  is the template active or not?
     * label_key [STRING]  key for the label
     */
    const DB_TABLE_DESCRIPTION = " (
  template_id int(11) NOT NULL  auto_increment,
  app_id varchar(50) NOT NULL  default '0',
  template_key varchar(50) NOT NULL  default '',
  template_isactive int(1) NOT NULL  default '0',
  label_key text NOT NULL  default '',
  PRIMARY KEY (template_id)
) TYPE=MyISAM";
    
    /** The fields in the DB Table this class manages. */
    const FIELD_LIST = 'template_id,app_id,template_key,template_isactive,label_key';
    
    /** The XML node name for this entry. */
    const XML_NODE_NAME = 'emailtemplate';
    

	//VARIABLES:
    protected $labels;

	//CLASS CONSTRUCTOR
	//************************************************************************
	/**
	 * function __construct
	 * <pre>
	 * Initialize this object.
	 * </pre>
	 * @param $template_id [INTEGER] The unique id of the emailtemplate we are managing.
	 * @return [void]
	 */
    function __construct( $template_id=-1, $app_id="") 
    {
    
        $dbTableName = RowManager_EmailTemplateManager::DB_TABLE;
        $fieldList = RowManager_EmailTemplateManager::FIELD_LIST;
        $primaryKeyField = 'template_id';
        $primaryKeyValue = $template_id;
        
        if (( $template_id != -1 ) && ( $template_id != '' )) {
        
            $condition = $primaryKeyField . '=' . $primaryKeyValue;
            //$condition .= " AND app_id='".$app_id."'";
        } else {
            $condition = '';
            //$condition = "app_id='" . $app_id ."'";
        }
        $xmlNodeName = RowManager_EmailTemplateManager::XML_NODE_NAME;
        parent::__construct( $dbTableName, $fieldList, $primaryKeyField, $primaryKeyValue, $condition, $xmlNodeName);
        
        $this->dbDescription = RowManager_EmailTemplateManager::DB_TABLE_DESCRIPTION;

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
	 * function getKeyField
	 * <pre>
	 * Returns the field to use in the RowLabelBridge routines.
	 * </pre>
	 * @return [STRING]
	 */
    function getKeyField() 
    {
        return "label_key";
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
        return "label_key";
    }
    
    
    
    //************************************************************************
	/**
	 * function getSeriesKey
	 * <pre>
	 * Returns the series Key for this RowManager. (used for RowLabelBridge 
	 * objects.
	 * </pre>
	 * @return [STRING]
	 */
    function getSeriesKey() 
    {
        return moduleEmailTemplates::MULTILINGUAL_SERIES_KEY;
    }
    
    
    
    
    //************************************************************************
	/**
	 * function getTemplate
	 * <pre>
	 * Returns the series Key for this RowManager. (used for RowLabelBridge 
	 * objects.
	 * </pre>
	 * @return [STRING]
	 */
    function getLabelKey() 
    {
        return $this->getValueByFieldName("label_key");
    }
    
    
    
    /*************************************************************************
     * function isActive
     * <pre>
     * tells whether or not this template is activated
     * </pre>
     * @return BOOL
     *
     */
    function isActive()
    {
        return $this->getValueByFieldName("template_isactive");
    }
    
    
    /*************************************************************************
     * function loadByKey
     * <pre>
     * loads EmailTemplate by template key
     * </pre>
     * $templateKey - STRING
     *
     */
    function loadByKey($templateKey)
    {
        $condition = "template_key='".$templateKey."'";
        $retVal = $this->loadByCondition( $condition );
        return $retVal;
    }
    
    
    
    //************************************************************************
	/**
	 * function setAppID
	 * <pre>
	 * Sets the application id for this entry.
	 * </pre>
	 * @param $appID [INTEGER] the app_id for the entry
	 * @return [void]
	 */
    function setAppID( $app_id )
    {
        $this->setValueByFieldName( 'app_id', $app_id );
        //$this->setDBCondition("app_id='".$app_id."'");
    }

    
    
    //************************************************************************
	/**
	 * function setTemplateKey
	 * <pre>
	 * Sets the application id for this entry.
	 * </pre>
	 * @param $appID [INTEGER] the app_id for the entry
	 * @return [void]
	 */
    function setTemplateKey( $template_key ) 
    {
        $this->setValueByFieldName( 'template_key', $template_key );
    }
    
    
    //************************************************************************
	/**
	 * function setIsActive
	 * <pre>
	 * Sets the activeness for this entry.
	 * </pre>
	 * @param $is_active [BOOL]
	 * @return [void]
	 */
    function setIsActive( $is_active ) 
    {
        $this->setValueByFieldName( 'template_isactive', $is_active );
    }
    
    
    
    //************************************************************************
	/**
	 * function setLabelKey
	 * <pre>
	 * Sets the Label Key for this entry.
	 * </pre>
	 * @param $label_key [INTEGER] the label_key for the entry
	 * @return [void]
	 */
    function setLabelKey($label_key)
    {
        $this->setValueByFieldName( 'label_key', $label_key );
    }
    	
}

?>