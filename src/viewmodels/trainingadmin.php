<?php
    requireLogin();
    if(!$sessionManager->isLoggedIn())
        actionNoPermission();
        
    $administeredDepartments = $db->rawQuery("SELECT d.Id, d.Name, c.Name as Stadt
    FROM Department d
    LEFT JOIN User_Department ud ON d.Id = ud.DepartmentId
    LEFT JOIN User u ON u.Id = ud.UserId
    LEFT JOIN Role r ON r.Id = ud.RoleId 
    LEFT JOIN Permission p ON p.Id = r.PermissionId
    LEFT JOIN City c ON c.Id = d.CityId
    WHERE p.Permissionlevel >=50
    AND u.Mail = '".$sessionManager->getMailAdress()."'");

    $phpGridder = new PhpGridder($administeredDepartments);
    $phpGridder->columnsToHide = array("Id");
    $phpGridder->rowLinks = array("department/%s", "Id");
    $grid = $phpGridder->renderHtml();
?>