<?php
include_once('models/ImportStructure.php');

class ImportMassData{
	private $fileHandle;

	public function __construct($fileHandle){
		$this->fileHandle = $fileHandle;
	}

	public function GetContentAsImportStructure() {
		$importStructures = array();
		$lines = file($this->fileHandle);
		$delimiter = ";";
		if(strpos($lines[0], ',') !== false && !(strpos($lines[0], ';' !== false)))
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
}

?>