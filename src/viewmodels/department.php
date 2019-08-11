<?php
    $departmentId = $_GET["id"];
    if($departmentId == "") actionNoPermission();
    

    include_once(getBiz("department"));
    $userPermissionLevel = $department->getPermissionLevel($departmentId);

	include_once(getBiz("DepartmentRepo"));
	$departmentRepo = new DepartmentRepo();
    $departmentName = $departmentRepo->GetAll("ID = $departmentId")[0]["Name"];
    
    if($userPermissionLevel >= 50)
        $admin = true;
 
    $trainings = $db->rawQuery("SELECT Training.Id,  
    DATE_FORMAT(Start, '%w, %d.%m. %H:%i Uhr') as Beginn, 
    Training.Description as Thema,
	City.Name as Ort
    FROM Training
    LEFT JOIN Category ON CategoryId = Category.Id
    LEFT JOIN Department ON DepartmentId = Department.Id
    LEFT JOIN User ON Creator = User.Id
    LEFT JOIN City ON City.Id = Department.CityId
    WHERE Training.Public = true
    AND End > NOW() 
    AND Department.Id = '".$departmentId."'
    ORDER BY Start ASC;");

    $weekday = array(
        "0" => "Sonntag",
        "1" => "Montag",
        "2" => "Dienstag",
        "3" => "Mittwoch",
        "4" => "Donnerstag",
        "5" => "Freitag",
        "6" => "Samstag",
    );

    for($i = 0; $i < count($trainings); $i++){
        $foo = $trainings[$i]["Beginn"];
        $trainings[$i]["Beginn"] = $weekday[substr($foo, 0, 1)] . substr($foo, 1);
    }

    $cellDivClasses = array(
		array("Thema", "topic-cell")
	);

    $phpGridder = new PhpGridder($trainings);
    $phpGridder->cellDivClasses = $cellDivClasses;
    $phpGridder->columnsToHide = array("Id", "IsEvent");
    $phpGridder->rowLinks = array("/training/%s", "Id");
    $phpGridder->columnWidths = array("Ort" => 150);
    $grid = $phpGridder->renderHtml();

    $menu = "";
    if($admin = true){
        $menu = "<a href='/trainingedit/department/{$departmentId}'>[Neu]</a>";
    }
?>