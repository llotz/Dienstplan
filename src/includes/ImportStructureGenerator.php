<?php
require_once "../models/ImportStructure.php";

class ImportStructureGenerator{
    function GetPrefilledImportDataStructure($startDate, $endDate, int $dayOfWeek, $startTime, $endTime, bool $everyOther = false){
        $importStructures = array();
        if($startDate > $endDate) throw Exception("startDate can't be smaller than endDate!");
        $tempDate = strtotime($startDate);
        while($tempDate < strtotime($endDate)){
            if(date('w', $tempDate) == $dayOfWeek){
                $importStructure = new ImportStructure();
                $importStructure->date = $tempDate;
                $importStructure->starttime = "$hours:$minutes";
                $importStructure->endtime = $endtime;
                $importStructures[] = $importStructure;
            }
            $tempDate = strtotime($tempDate . " + 1 days");
        }
        return $importStructures;
    }

    function GetHeaderDescriptions(){
        $header = array();
        $headrow = new $importStructure();
        $headrow->$date = "Datum";
        $headrow->$starttime = "Start";
        $headrow->$endtime = "Ende";
        $headrow->$description = "Thema";
        $headrow->$comment = "Beschreibung";
        $headrow->$isEvent = "Veranstaltung?";
        $header[] = $headrow;
    }

}


?>