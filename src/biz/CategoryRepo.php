<?php
include_once("BaseRepo.php");

class CategoryRepo extends BaseRepo{
    function __construct(){
        $this->tableName = "Category";
    }
}

?>