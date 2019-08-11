<?php
    requireLogin();
    $userMail = $sessionManager->getMailAdress();

    $trainings = $db->rawQuery("SELECT Training.Id, 
    Department.Name as Feuerwehr, 
    
    DATE_FORMAT(Start, '%w, %d.%m. %H:%i Uhr') as Beginn, 
    Training.Description as Thema,
    City.Name as Ort,
    IsEvent,
    Sector.Name as Abteilung
    FROM Training
    LEFT JOIN Category ON CategoryId = Category.Id
    LEFT JOIN Department ON DepartmentId = Department.Id
    LEFT JOIN City ON City.Id = Department.CityId
    LEFT JOIN User_Department ud ON ud.DepartmentId = Department.Id
    LEFT JOIN Sector ON SectorId = Sector.Id
	 LEFT JOIN User ON ud.UserId = User.Id
    WHERE End > NOW()
    AND User.Mail = '".$userMail."'
    ORDER BY Start ASC;");
	// AND Start < DATE_ADD(Now(), Interval 30 DAY)

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

    $rowDivClassConditions = array(
        array("IsEvent", "1", "event")	
	);
    
    $phpGridder = new PhpGridder($trainings);
    $phpGridder->rowDivClassConditions = $rowDivClassConditions;
    $phpGridder->columnsToHide = array("Id", "IsEvent", "Ort");
    $phpGridder->rowLinks = array("/training/%s", "Id");
    $phpGridder->columnWidths = array("Feuerwehr" => 250);
    $grid = $phpGridder->renderHtml();
?>