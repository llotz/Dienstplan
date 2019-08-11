<?php
    $cities = $db->get('City');
    
    // Load Filter selections
    include_once("biz/SectorRepo.php");
    include_once("biz/DepartmentRepo.php");
    include_once("biz/TrainingRepo.php");

    $sectorRepo = new SectorRepo();
    $departmentRepo = new DepartmentRepo();
    $trainingRepo = new TrainingRepo();
    $sectors = $sectorRepo->GetAll();
    $departments = $departmentRepo->GetAll("", "NAME ASC");

    $intervalList = loadJsonAsArray("intervalList");

    $interval = 180;

    $where = "";

    if($_GET["department"] != "" && is_numeric($_GET["department"])){
        $departmentId = $_GET["department"];
        $where .= " AND DepartmentId = $departmentId ";
    }

    if($_GET["sector"] != "" && is_numeric($_GET["sector"])){
        $sectorId = $_GET["sector"];
        $where .= " AND SectorId = $sectorId ";
    }

    if($_GET["interval"] != "" && is_numeric($_GET["interval"])){
        if($_GET["interval"] > 0)
            $interval = $_GET["interval"];
    }

    //print_r($_GET);
    
    $trainings = $trainingRepo->GetTrainings($where, $interval);

    $rowDivClassConditions = array(
      array("IsEvent", "1", "event")	
    );

	$cellDivClasses = array(
		array("Thema", "topic-cell")
	);

    $kwArray = array();
    
    foreach($trainings as $training){
        if(!key_exists($training["KW"], $kwArray))
            $kwArray[$training["KW"]] = array();
        array_push($kwArray[$training["KW"]], $training);
    }
    $grid = "";

    foreach($kwArray as $kwTraining){
        $kw = $kwTraining[0]['KW'];
        $grid .= "<p class='calendar-week-hint'>KW $kw</p>";
        $phpGridder = new PhpGridder($kwTraining);
        $phpGridder->rowDivClassConditions = $rowDivClassConditions;
        $phpGridder->columnsToHide = array("Id", "IsEvent", "Ort", "KW");
		$phpGridder->cellDivClasses = $cellDivClasses;
        $phpGridder->rowLinks = array("training/%s", "Id");
        $phpGridder->columnWidths = array("Feuerwehr" => 250);
        $phpGridder->showHeadRow = false;
        $grid .= $phpGridder->renderHtml();
    }

    //print_r($kwArray);

    
?>