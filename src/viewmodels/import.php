<?php

include_once("includes/importMassData.php");
include_once("biz/DepartmentRepo.php");
include_once('biz/SectorRepo.php');

$departmentRepo = new DepartmentRepo();
$sectorRepo = new SectorRepo();

$sectors = $sectorRepo->GetAll();
$departments = $departmentRepo->GetWherePermittedEditing();

if($_FILES['importFile']['tmp_name'] != "" &&
	 isset($_POST['department']) && 
	 is_numeric($_POST['department']) &&
	 isset($_POST['sector']) && 
	 is_numeric($_POST['sector'])){
	
	$importMassData = new ImportMassData($_FILES['importFile']['tmp_name']);
	$importStructures=$importMassData->GetContentAsImportStructure();
	$departmentId = $_POST['department'];
	$sectorId = $_POST['sector'];

	// Check if submitted department is valid for user
	$userHasPermission = false;
	array_walk($departments, function($value){
		global $departmentId;
		global $userHasPermission;
		if($value['Id']==$departmentId)
			$userHasPermission = true;
	});

	if(!$userHasPermission)
		$error = "Sie haben keine Berechtigung, für diese Wehr einen Dienst zu planen!";
	
	$trainings = $importMassData->GetTrainingsFromImportStructure($sectorId, $departmentId, $importStructures);
	$isValid = $importMassData->IsImportDataValid($trainings);
	if(!$isValid)
		$error = $importMassData->lastError;
		
	print_r($trainings);
	
}


?>