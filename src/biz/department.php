<?php
    class Department{
        public function getPermissionLevel($departmentId){
            global $sessionManager;
            global $db;

            $userMail = $sessionManager->getMailAdress();
            if($departmentId == "" || !is_numeric($departmentId)) return 0;
            $departmentPermission = $db->rawQuery("SELECT d.Id, d.Name, c.Name as Stadt, p.Permissionlevel
            FROM Department d
            LEFT JOIN User_Department ud ON d.Id = ud.DepartmentId
            LEFT JOIN User u ON u.Id = ud.UserId
            LEFT JOIN Role r ON r.Id = ud.RoleId 
            LEFT JOIN Permission p ON p.Id = r.PermissionId
            LEFT JOIN City c ON c.Id = d.CityId
            WHERE u.Mail = '".$userMail."' AND d.Id = '".$departmentId."'");

            if(is_array($departmentPermission) && count($departmentPermission) == 1)
                return $departmentPermission[0]["Permissionlevel"];
            else 
                return 0;
        
        }
    }

    $department = new Department();
?>