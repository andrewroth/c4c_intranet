<?php

define('JOIN_TYPE_INNER','INNER JOIN');
define('JOIN_TYPE_LEFT', 'LEFT JOIN');
define('JOIN_TYPE_RIGHT', 'RIGHT JOIN');


class JoinPair
{
    protected $partA;
    protected $partB;
    protected $joinType;
    
    function __construct( $partA='', $partB='', $joinType=JOIN_TYPE_INNER )
    {
        $this->partA = $partA;
        $this->partB = $partB;
        $this->joinType = $joinType;
        return;
    }
    
    function compileOnCommonField( $managerA, $managerB, $fieldName, $joinType=JOIN_TYPE_INNER ) 
    {
        $this->partA = $managerA->getJoinOnFieldX( $fieldName );
        $this->partB = $managerB->getJoinOnFieldX( $fieldName );
        $this->joinType = $joinType;
    }
    
    function getPartA()
    {
        return $this->partA;
    }
    
    function getPartB()
    {
        return $this->partB;
    }
    
    function getJoinType()
    {
        return $this->joinType;
    }
}

?>