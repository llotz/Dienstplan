<?php
  include_once("biz/TrainingRepo.php");
  include_once("includes/libs/CalMaker.php");
  $trainingRepo = new TrainingRepo();

  $year = date("Y");
  $month = date("m");
  $lastDayOfMonth = date('t', mktime(0, 0, 0, $month, 1, $year));

  $where = " AND START BETWEEN '$year-$month-01' AND '$year-$month-$lastDayOfMonth'";

  $trainings = $trainingRepo->GetTrainings($where);

  $appointments = array();
  foreach($trainings as $training){
    $a = new Appointment();
    $a->start = $training["Start"];
    $a->end = $training["End"];
    $a->organizer = $training["Feuerwehr"];
    $a->isEvent = $training["IsEvent"];
    $a->subject = $training["Thema"];
    $appointments[] = $training;
  }
  
  $calMaker = new CalMaker($appointments);
  $calendar = $calMaker->render($year, $month);
?>