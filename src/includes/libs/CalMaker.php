<?php

include_once("models/Appointment.php");

class CalMaker{
  public $appointments;
  
  public function __construct($appointments){
    $this->appointments = $appointments;
  }

  public function render($year, $month){
    $renderAppointments = $this->getCurrentMonthAppointments($this->appointments, $year, $month);
    $departments = $this->getFireDepartmentStrings($renderAppointments);
    $days = $this->getDaysOfMonth($year, $month);
    print_r($days);
  }

  function getCurrentMonthAppointments($appointments, $year, $month){
    $targetMonth = "$year:$month";
    $filtered = array();
    foreach ($appointments as $app){
      $compareString = date("Y:m",strtotime($app["Start"]));
      if($compareString == $targetMonth)
        $filtered[] = $app;
    }
    return $filtered;
  }

  function getFireDepartmentStrings($appointments){
    $departments = array();
    foreach($appointments as $app){
      if(!in_array($app["Feuerwehr"], $departments, true))
        $departments[] = $app["Feuerwehr"];
    }
    return $departments;
  }

  function getDaysOfMonth($year, $month){
    $days = date('t', mktime(0, 0, 0, $month, 1, $year));
    $dayArray = array();
    for($i = 1; $i <= $days; $i++)
      $dayArray[] = $i;
    return $dayArray;
  }
}


?>