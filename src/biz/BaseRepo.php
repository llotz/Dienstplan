<?php

class BaseRepo{
    public $tableName;

    public function GetAll($where = "", $orderBy = ""){
        global $db;
        if($where != "") $where = "WHERE ".$where;
        if($orderBy != "") $orderBy = "ORDER BY ".$orderBy;
        $sqlQuery = "SELECT * FROM {$this->tableName} {$where} {$orderBy}";
        return $db->rawQuery($sqlQuery);
    }

    public function GetById($id){
        return $this->GetAll("ID = $id")[0];
    }
}

?>