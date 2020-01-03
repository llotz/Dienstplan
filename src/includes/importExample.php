<?php
include_once("../models/ImportStructure");

class ImportExample{
	var $fileName = "Import_Beispiel.csv";
	var $data = "";
	public function __construct(){

	}

	public function RenderCsv(){
		$year = date('Y');
		$this->data .= "Datum;Start;Ende;Title;Beschreibung;Event;\r\n";
		$this->data .= "$year-10-27;19:00;21:30;UVV Unterweisung;Die jährliche UVV Unterweisung am 27. Oktober;;\r\n";
		$this->data .= "$year-10-27;19:00;21:30;Feuerwehrfest;Wir laden ein zum Feuerwehrfest;x;\r\n";

	}

	public function Show(){
		ob_end_clean();
		header("Content-Type:text/csv charset=utf-8");
		header('Content-Disposition: attachment; filename="'.$this->fileName.'"');
		header('Content-Length: '.strlen($this->data));
		header('Connection: close');
		echo $this->data;
		exit(0);
	}
}

?>