<?php
include_once("BaseRepo.php");

class CityRepo extends BaseRepo{
    function __construct(){
        $this->tableName = "City";
    }

    function GetByDepartment($departmentId){
        global $db;

        if(!is_numeric($departmentId)) return null;

        $result = $db->rawQuery("SELECT c.* 
        FROM City c
        JOIN Department d on d.CityId = c.Id
        WHERE d.Id = {$departmentId}");
        
        if(count($result) > 0)
            return $result[0];
        else 
            return null;
    }
}

?>