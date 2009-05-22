<?php

class MultiRowManager extends RowManager
{

    protected $rowManagerArray;
    protected $joinPairs;
    
    protected $aliasIndex;
    protected $aliasNameArray; 
    
    protected $onlyOneRowManager;
    
    function __construct( $dbName=SITE_DB_NAME, $dbPath=SITE_DB_PATH, $dbUser=SITE_DB_USER, $dbPword=SITE_DB_PWORD )
    {
        // the index of the first alias we will give out
        $this->aliasIndex = 0;
        
        $this->onlyOneRowManager = true;
        
        // make an array of aliases a-z
        $char = 'a';
        for($i=0; $i<26; $i++)
        {
            $this->aliasNameArray[] = $char;
            $char++;
        }
        
        // print_r($this->aliasNameArray);
        
        // set the dbName
        // we set it to nothing so that the find operation works 
        // properly since the find appends the dbName to the 
        // tableName and we don't want that
        $this->dbName = '';
        $this->dbPath = $dbPath;
        $this->dbUser = $dbUser;
        $this->dbPword = $dbPword;
        
        return;
    }
    
    function addRowManager( &$rowManager )
    {
        // echo 'RowManager added<Br/>';
        // assign a table alias
        $rowManager->setTableIdentifier( $this->aliasNameArray[$this->aliasIndex] );
        $this->aliasIndex++;
        
        // add the row manager to the array
        $this->rowManagerArray[] = $rowManager;
    }
    
    function addJoinPair( $joinPair )
    {
        $this->joinPairs[] = $joinPair;
    }
    
    function getNextAlias()
    {
        return $this->aliasNameArray[$this->aliasIndex];
    }
    
    function ready()
    {
        // add on aliases to fields
        foreach( $this->rowManagerArray as $key=>$value )
        { 
            // add the alias to the table fields
            $value->addTableIdentifierToFields();
        }
    
        $this->prepareRowManager($this->rowManagerArray, $this->joinPairs);
    }
    
    private function prepareRowManager( $rowManagerArray, $joinPairs )
    {
        // note: we are going through the arrays from back to front
        
        $numElements = count($rowManagerArray);
        // echo 'numElements['.$numElements.']<br/>';
        if ( $numElements > 1 )
        {
            $this->onlyOneRowManager = false;
        
            // recursive case:
            
            // A - first element (usally comes from the recursion)
            $rowManagerA = $rowManagerArray[0];
            
            // B - second element 
            $rowManagerB = $rowManagerArray[1];
            
            $numJoinElements = count($joinPairs);
            $joinPair = $joinPairs[0];
            $joinPartA = $joinPair->getPartA();
            $joinPartB = $joinPair->getPartB();
            $joinType = $joinPair->getJoinType();
        
            $idA = $rowManagerA->getTableIdentifier();
            $idB = $rowManagerB->getTableIdentifier();
            
            // it's possible idA is '' since
            // it often comes from the recursive case
            $asText = ' as ' . $idA;
            // $joinText = $idA.'.'.$joinPartA;
            
            if ( $idA == '' )
            {
                $asText='';
            }
            $dbNameA = $rowManagerA->getDBName();
            $dbNameText = $dbNameA.'.';
            if ( $dbNameA=='' )
            {
                $dbNameText = '';
            }
        
            // set the table info
            $this->dbTableName = '('.$dbNameText.$rowManagerA->getTableName().$asText.' '.$joinType.' '.$rowManagerB->getDBName().'.'.$rowManagerB->getTableName().' as '.$idB.' ON '.$joinPartA.'='.$joinPartB . ')';
            
            // echo 'dbTableName['.$this->dbTableName.']<br/>';
            
            // set the field list
            $fieldListA = $rowManagerA->getFieldList();
            $fieldListB = $rowManagerB->getFieldList();
            
            $this->fieldList = $fieldListA .','.$fieldListB;
            
            $this->fields = array_merge($rowManagerA->getFields(), $rowManagerB->getFields() );
            
            // set the values array
            $this->values = array_merge($rowManagerA->getArrayOfValues(),$rowManagerB->getArrayOfValues() );
            
            // set the search condition array
            $this->searchCondition = array_merge($rowManagerA->getSearchConditions(), $rowManagerB->getSearchConditions() );

            // prepare for recursion
        
            // 'this' is the new first element, appended by the remainder of the array that we have not yet processed
            // note that we removed the elements we just processed
            $newArray = array();
            $newArray[] = $this;
            for ( $i=2; $i<$numElements; $i++ )
            {
                $newArray[] = $rowManagerArray[$i];
            }
            
            // joinPair array
            $newPairArray = array();
            for ($i=1; $i<$numJoinElements; $i++)
            {
                $newPairArray[] = $joinPairs[$i];
            }
            
            // recurse
            $this->prepareRowManager( $newArray, $newPairArray  );
            
        }
        else
        {
            // stop, we are at the base case
            
            if ( $this->onlyOneRowManager && (count($rowManagerArray)==1) )
            {
                // here, only one row manager has been passed
                // in, we still need to copy over the information
                $this->specialBaseCase();
            }
        }
        
                
        return;
    } // prepareRowManager
    
    private function specialBaseCase()
    {
        // echo 'Inside Special Base Case<br/>';
        $rowManagerA = $this->rowManagerArray[0];
        
        $this->dbTableName = $rowManagerA->getTableName() . ' AS ' .$rowManagerA->getTableIdentifier();
        $this->fieldList = $rowManagerA->getFieldList();
        $this->fields = $rowManagerA->getFields();
        
        // set the values array
        $this->values = $rowManagerA->getArrayOfValues();
        
        // set the search condition array
        $this->searchCondition = $rowManagerA->getSearchConditions();
    }
    
    
    function printObject()
    {
        // print the tableName
        $retString = 'table name['.$this->dbTableName.']<br/>';
        
        // print the fields
        $retString .= 'fields<pre>'.print_r($this->fields,true).'</pre>';
        
        // print the field list
        $retString .= 'field list['.$this->fieldList.']<br/>';
        
        // print the values
        $retString .= 'values<pre>'.print_r($this->values,true).'</pre>';
        
        // return the output
        return $retString;
    }

} // MultiRowManager

?>