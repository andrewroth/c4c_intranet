    /*
     * <?=$tableName;?> Table
     *
     * <?=$tableDescription?>
     *
<?
echo $fieldList;
?>
     */
    $<?=$tableName;?> = new RowManager_<?=$tableNameCap?>Manager();

    $<?=$tableName;?>->dropTable();
    $<?=$tableName;?>->createTable();