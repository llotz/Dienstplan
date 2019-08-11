<?php
include_once("BaseRepo.php");

class TrainingTypeRepo extends BaseRepo{
    function __construct(){
        $this->tableName = "TrainingType";
    }
}

?>