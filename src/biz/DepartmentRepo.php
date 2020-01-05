<?php
include_once("BaseRepo.php");

class DepartmentRepo extends BaseRepo{
    public function __construct(){
        $this->tableName = "Department";
    }

    public function GetWherePermittedEditing(){
        global $db;
        global $sessionManager;
        
        return $db->rawQuery("SELECT d.* 
        FROM Department d
        LEFT JOIN User_Department ud ON d.Id = ud.DepartmentId
        LEFT JOIN User u ON u.Id = ud.UserId
        LEFT JOIN Role r ON r.Id = ud.RoleId 
        LEFT JOIN Permission p ON p.Id = r.PermissionId
        LEFT JOIN City c ON c.Id = d.CityId
        WHERE p.Permissionlevel >=50
        AND u.Mail = '".$sessionManager->getMailAdress()."'");
    }

    public function GetAnus(){
        return $this->tableName;
    }
}

?>