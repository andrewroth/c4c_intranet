<?php
/**
 * @package CMS
 */ 
/**
 * class HTMLBlock
 * <pre> 
 * This class manages the HTML Block DB Tables and operation.
 * </pre>
 * @author Johnny Hausman
 */
class  HTMLBlock {

	//CONSTANTS:
	/** The name of the DB Table this class manages. */
    const DB_TABLE_HTMLBLOCK = 'cms_htmlblock_htmlblock';
    const SQL_CREATE_TABLE = " (  
    htmlblock_id int(11) NOT NULL auto_increment,  
    htmlblock_key varchar(50) NOT NULL default '',  
    htmlblock_data text NOT NULL,  
    language_id int(11) NOT NULL default '0',  
    PRIMARY KEY  (htmlblock_id)
    ) TYPE=MyISAM;";


	//VARIABLES:
	/** @var [STRING] The HTML for this HTML Block */
	protected $htmlBlockData;

	/** @var [STRING] The Unique Key identifying this HTML Block */
	protected $htmlBlockKey;
	
	/** @var [OBJECT] The DB connection object. */
	protected $db;

	//CLASS CONSTRUCTOR
	//************************************************************************
	/**
	 * function __construct
	 * <pre>
	 * Initialize a HTML Block.
	 * </pre>
	 * <pre><code>
	 * [Put PseudoCode Here]
	 * </code></pre>
	 * @param $param1 [$param1 type] [optional description of $param1]
	 * @param $param2 [$param2 type] [optional description of $param2]
	 * @return [returnValue, can be void]
	 */
    function __construct($key, $languageID) 
    {
        // CODE
        $this->htmlBlockKey = $key;
        
        $this->languageID = $languageID;
        
        $this->db = new Database_Site();
        $this->db->connectToDB( SITE_DB_NAME, SITE_DB_PATH, SITE_DB_USER, SITE_DB_PWORD);
        
        $this->htmlBlockData = array();
        
        if ( !is_null($this->htmlBlockKey) ) {
        
            $this->loadFromDB();
            
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
    }
    
    
    
     //************************************************************************
	/**
	 * function dropTable
	 * <pre>
	 * deletes this objects table
	 * </pre>
	 * 
	 */  
    function dropTable($db)
        {
        $sql = "DROP TABLE IF EXISTS " . HTMLBlock::DB_TABLE_HTMLBLOCK;
        if (!$db->runSQL( $sql ) ) 
            {
            echo '<tr><td><font color="#FF0000">'.$sql."</font></td></tr>\n";
            }
         }
    
    
     //************************************************************************
	/**
	 * function createTable
	 * <pre>
	 * creates this objects table
	 * </pre>
	 * 
	 */    
    function createTable($db)
        {
        $sql = "CREATE TABLE " . HTMLBlock::DB_TABLE_HTMLBLOCK . HTMLBlock::SQL_CREATE_TABLE;
        if (!$db->runSQL($sql) ) 
            {
            echo '<tr><td><font color="#FF0000">'.$sql."</font></td></tr>\n";
            }
        }
    
    
    
    //************************************************************************
	/**
	 * function loadFromDB
	 * <pre>
	 * Loads a HTML block from the DB.
	 * </pre>
	 * <pre><code>
	 * Create SQL to retrieve all HTML blocks linked to $this->htmlBlockKey 
	 * for each HTMLBlock
     *     store in array keyed by language ID
     * next HTMLBlock
	 * </code></pre>
	 * @return [returnValue, can be void]
	 */
    function loadFromDB() 
    {
        // Create SQL to retrieve all HTML blocks linked to $this->htmlBlockKey 
        $sql = "SELECT * FROM ".SITE_DB_NAME.'.'.HTMLBlock::DB_TABLE_HTMLBLOCK." WHERE htmlblock_key='".$this->htmlBlockKey."'";
        
        $this->db->runSQL( $sql );
        
        // for each HTMLBlock
        while( $row = $this->db->retrieveRow() ) {
        
            // store in array keyed by language ID
            $this->htmlBlockData[ $row['language_id'] ] = $row[ 'htmlblock_data' ];
        }  // next HTMLBlock
        
    } // end loadFromDB()
    
    
    
    //************************************************************************
	/**
	 * function getData
	 * <pre>
	 * Returns the requested HTML block by language (if available). Else return
	 * one of the other language versions.
	 * </pre>
	 * <pre><code>
	 *  if requested languageID is available then
     *       return HTML from this languageID
     *   else
     *       return first available language version 
     *   end if
	 * </code></pre>
	 * @return [STRING] requested HTML
	 */
    function getData() 
    {
        // if requested languageID is available then
        if ( isset( $this->htmlBlockData[ $this->languageID ] ) ) {
        
            // return HTML from this languageID
            $data = $this->htmlBlockData[ $this->languageID ];
            
        } else {
        // else
        
            // if there is an entry in the array then
            if ( count( $this->htmlBlockData) > 0 ) {
                
                // return first available language version 
                $data = current( $this->htmlBlockData );
                
            } else {
                
                $data = "&nbsp;";
            }
        
        } // end if
        
        return $data;
    }
	
}

?>