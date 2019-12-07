<?php
  include_once(getViewModel("main"));
  include_once("includes/libs/CalMaker.php");

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
?>