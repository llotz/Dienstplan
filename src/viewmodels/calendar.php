<?php
include_once("biz/TrainingRepo.php");
include_once("includes/libs/CalMaker.php");
include_once("includes/monthGenerator.php");
$monthGenerator = new MonthGenerator();
$trainingRepo = new TrainingRepo();

$year = date("Y");
$month = date("m");
$shownYear = $year;
$shownMonth = $month;
$selectedMonth = "$year-$month";

if(isset($_GET["month"]) && preg_match('/^\d{4}-(\d{2})$/', $_GET['month'])){
  $selectedMonth = $_GET["month"];
  $splitted = explode('-', $selectedMonth);
  $shownYear = $splitted[0];
  $shownMonth = $splitted[1];
}

$lastDayOfMonth = date('t', mktime(0, 0, 0, $month, 1, $year));
$where = " AND START BETWEEN '$shownYear-$shownMonth-01' AND '$shownYear-$shownMonth-$lastDayOfMonth'";

$trainings = $trainingRepo->GetTrainings($where);

$appointments = array();
foreach($trainings as $training){
  $a = new Appointment();
  $a->id = $training["Id"];
  $a->start = $training["Start"];
  $a->end = $training["End"];
  $a->organizer = $training["Feuerwehr"];
  $a->isEvent = $training["IsEvent"];
  $a->subject = $training["Thema"];
  $appointments[] = $training;
}

$calMaker = new CalMaker($appointments);
$calendar = $calMaker->render($shownYear, $shownMonth);

$monthOptionsArray = $monthGenerator->GetOptionsArray(
  $monthGenerator->GetMonthRange($year, $month, 9)
  ,$selectedMonth);
  
  ?>