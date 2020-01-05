<?php

include_once("includes/importMassData.php");
include_once("biz/DepartmentRepo.php");
include_once('biz/SectorRepo.php');
include_once('biz/TrainingRepo.php');

$departmentRepo = new DepartmentRepo();
$sectorRepo = new SectorRepo();
$trainingRepo = new TrainingRepo();

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

	$userHasPermission = $importMassData->UserHasPermission($departments, $departmentId);
	
	if(!$userHasPermission){
		$error = $importMassData->lastError;
	}else{
		$trainings = $importMassData->GetTrainingsFromImportStructure($sectorId, $departmentId, $importStructures);
		$isValid = $importMassData->IsImportDataValid($trainings);
		if(!$isValid)
			$error = $importMassData->lastError;
		else{
			// push array to database after sanitizing inputs
			foreach($trainings as $training)
				$trainingRepo->Insert($training);
			$message = "Datensätze erfolgreich importiert";
		}
	}
}
?>