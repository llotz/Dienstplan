<?php

    if($_GET["id"] == "") actionNoPermission();
    $trainingId = $_GET["id"];

    $queryString = "SELECT t.Id, 
    City.Name as City, 
    DATE_FORMAT(Start, '%w, %d.%m.%Y, %H:%i Uhr') as Beginn, 
    Round(TIMESTAMPDIFF(MINUTE, Start, End)/60, 1) as Duration,
    t.Description as Thema, 
    DATE_FORMAT(t.Start, '%d.%m.%Y %H:%i') as Start, 
    DATE_FORMAT(t.End, '%d.%m.%Y %H:%i') as End,
    c.Description as Category,
    t.LastChange,
    t.Public,
    t.Comment,
    Sector.Name as Sector,
    d.Id as DepartmentId,
    d.Name as Department,
    CONCAT(Round(TIMESTAMPDIFF(MINUTE, Start, End)/60, 1),'h') as Duration,
    t.IsEvent
    FROM Training t
    LEFT JOIN Category c ON CategoryId = c.Id
    LEFT JOIN Department d ON DepartmentId = d.Id
    LEFT JOIN Sector ON Sector.Id = t.SectorId
    LEFT JOIN User ON Creator = User.Id
    LEFT JOIN City ON City.Id = t.CityId
    
    WHERE t.Id=$trainingId";

    if(!$sessionManager->isLoggedIn()) $queryString .= " AND t.Public = true";

    $trainings = $db->rawQuery($queryString);

    if(!is_array($trainings) || count($trainings) == 0) actionNoPermission();
    $training = $trainings[0];

    include_once(getBiz("department"));
    $userPermissionLevel = $department->getPermissionLevel($training["DepartmentId"]);

    $admin = ($userPermissionLevel >= 50);

    $menu = "";
    if($admin){
        $menu = "<a href='/trainingedit/$trainingId'>[Bearbeiten]</a>";
    }

	$training["Duration"] = str_replace(".0", "", $training["Duration"]);

    $weekday = array(
        "0" => "Sonntag",
        "1" => "Montag",
        "2" => "Dienstag",
        "3" => "Mittwoch",
        "4" => "Donnerstag",
        "5" => "Freitag",
        "6" => "Samstag",
    );

    $training["Beginn"] = $weekday[substr($training["Beginn"], 0, 1)] . substr($training["Beginn"], 1);

    //$trainingType = $training["IsEvent"]?"Ereignis":"Übungsdienst";
    //$title = $trainingType . ": " . $training["Thema"];
	$title = $training["Thema"];
    $comment = $training["Comment"]? (": " . strip_tags($training["Comment"])) : "";
    $description = $training["Beginn"] . ", ". $training["Sector"] . " " . $training["Department"];// . $comment;
?>