<?php
include_once("BaseRepo.php");

class SectorRepo extends BaseRepo{
    public function __construct(){
        $this->tableName = "Sector";
    }
}

?>