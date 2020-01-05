<?php
include_once('models/ImportStructure.php');
include_once("biz/DepartmentRepo.php");

class ImportMassData{
	private $fileHandle;
	public $lastError;

	public function __construct($fileHandle){
		$this->fileHandle = $fileHandle;
	}

	public function GetContentAsImportStructure() {
		$importStructures = array();
		$lines = file($this->fileHandle);
		$delimiter = ";";
		if(strpos($lines[0], ',') !== false && !(strpos($lines[0], ';') !== false))
			$delimiter = ',';
		for($i = 1; $i < count($lines); $i++)
		{
			$splitted = explode($delimiter, $lines[$i]);
			$importStructure = new ImportStructure();
			$importStructure->date = $splitted[0];
			$importStructure->starttime = $splitted[1];
			$importStructure->endtime = $splitted[2];
			$importStructure->description = $splitted[3];
			$importStructure->comment = $splitted[4];
			$importStructure->isEvent = $splitted[5];
			array_push($importStructures, $importStructure);
		}
		return $importStructures;
	}

	public function GetTrainingsFromImportStructure($sectorId, $departmentId, $importStructures){
		$departmentRepo = new DepartmentRepo();

		$trainings = array();
		foreach($importStructures as $is){
			$training = array();
			$training['department'] = $departmentId;
			$training['category'] = 1;
			$training['city'] = $departmentRepo->GetById($departmentId)['CityId'];
			$training['sector'] = $sectorId;
			$training['startdate'] = $is->date;
			$training['starttime'] = $is->starttime;
			$training['endtime'] = $is->endtime;
			$training['topic'] = $is->description;
			$training['description'] = $is->comment;
			$training['isEvent'] = (trim($is->isEvent) == 'x')?true:false;
			$trainings[] = $training;
		}
		return $trainings;
	}

	public function IsImportDataValid($trainings){
		$isValid = true;
		foreach($trainings as $training){
			$start = GetDateTimeStringFromDateAndTimeString($training['startdate'], $training['starttime']);
			$end = GetDateTimeStringFromDateAndTimeString($training['startdate'], $training['endtime']);
			if($start > $end){
				$this->lastError = "Der Startzeitpunkt ist nach dem Endzeitpunkt definiert: $start";
				return false;
			}
		}
		return $isValid;
	}

	// TODO push array to database after sanitizing inputs
	// TODO validate date and other stuff
	// TODO CSV remove "" and split ignore commas inside ""
}

?>