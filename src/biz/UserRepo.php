<?php
    include_once("BaseRepo.php");

    class UserRepo extends BaseRepo{
        public function __construct(){
            $this->tableName = "User";
        }

        public function SetNewPassword($userId, $passwordhash){
          global $db;
          if($passwordhash == "") return false;
          $data = Array (
            'Password' => "$passwordhash",
            'PassMustChange' => 0
          );
          $db->where('Id', $userId);
          return $db->update($this->tableName, $data);
        }

        public function SetHomeDepartment($userId, $departmentId){
          global $db;
          if(!is_numeric($departmentId))
            return false;
          $data = Array(
            'HomeDepartmentId' => "$departmentId"
          );
          $db->where('Id', $userId);
          return $db->update($this->tableName, $data);
        }

        public function GetCurrentUser(){
          global $db;
          $userId = $_SESSION['userId'];
          $db->where('Id', $userId);
          return $db->get($this->tableName)[0];
        }
    }
?>