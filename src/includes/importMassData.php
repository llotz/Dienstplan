<?php
include_once('models/ImportStructure.php');
include_once("biz/DepartmentRepo.php");

class ImportMassData
{
	private $fileHandle;
	public $lastError;

	public function __construct($fileHandle)
	{
		$this->fileHandle = $fileHandle;
	}

	public function GetContentAsImportStructure()
	{
		$importStructures = array();
		$lines = file($this->fileHandle);
		$delimiter = ";";
		if (strpos($lines[0], ',') !== false && !(strpos($lines[0], ';') !== false))
			$delimiter = ',';
		for ($i = 1; $i < count($lines); $i++) {
			$splitted = str_getcsv($lines[$i], $delimiter);
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

	public function GetTrainingsFromImportStructure($sectorId, $departmentId, $importStructures)
	{
		$departmentRepo = new DepartmentRepo();

		$trainings = array();
		foreach ($importStructures as $is) {
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
			if (trim($is->isEvent) == 'x')
				$training['isEvent'] = true;
			$trainings[] = $training;
		}
		return $trainings;
	}

	public function UserHasPermission($allowedDepartments, $departmentToPlan)
	{
		foreach ($allowedDepartments as $department) {
			if ($department['Id'] == $departmentToPlan)
				return true;
		}
		$this->lastError = $error = "Sie haben keine Berechtigung, für diese Wehr einen Dienst zu planen!";
		return false;
	}

	public function IsImportDataValid($trainings)
	{
		$isValid = true;
		foreach ($trainings as $training) {
			$start = $training['startdate'] . ' ' . $training['starttime'];
			$end = $training['startdate'] . ' ' . $training['endtime'];

			if (!validateDate($start) && !validateDate(convertDateTimeString($start))) {
				$this->lastError =
					"Startzeit hat ein ungültiges Format: $start";
				return false;
			}

			if (!validateDate($end) && !validateDate(convertDateTimeString($end))) {
				$this->lastError =
					"Endzeit hat ein ungültiges Format: $end";
				return false;
			}

			$startString = GetDateTimeStringFromDateAndTimeString($training['startdate'], $training['starttime']);
			$endString = GetDateTimeStringFromDateAndTimeString($training['startdate'], $training['endtime']);
			$startDate = GetDateTimeFromDateAndTimeString($training['startdate'], $training['starttime']);
			$endDate =  GetDateTimeFromDateAndTimeString($training['startdate'], $training['endtime']);

			if ($startDate > $endDate) {
				$this->lastError =
					"Der Startzeitpunkt ist nach dem Endzeitpunkt 
				definiert: Start: $startString Ende: $endString";
				return false;
			}
			if ($startDate < new DateTime('now')) {
				$this->lastError =
					"Der Startzeitpunkt liegt in der Vergangenheit: 
				Start: $startString";
				return false;
			}
		}
		return $isValid;
	}
}
