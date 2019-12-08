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
    $renderedTable = "<table class='cal-table'>";
    $renderedTable .= $this->renderHead($days, date('F', mktime(0, 0, 0, $month))." $year");
    foreach($departments as $department){
      $renderedTable .= "<tr>";
      $renderedTable .= "<td>$department</td>";
      foreach($days as $day){
        $dayApps = $this->getAppointmentsAtDate($renderAppointments, $department, $day, $month, $year);
        
        if(count($dayApps) > 0){
          $renderedTable .= "<td class='cal-highlightcell'>D";
        }else 
          $renderedTable .= "<td>";
        $renderedTable .= "</td>";
      }
      $renderedTable .= "</tr>";
    }
    $renderedTable .= "</table>";
    return $renderedTable;
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

  function getAppointmentsAtDate($appointments, $department, $day, $month, $year){
    $appsAtDay = array();
    $targetDay = "$year:$month:$day";
    foreach ($appointments as $app){
      if($app["Feuerwehr"]==$department){
        $dayString = date("Y:m:d",strtotime($app["Start"]));
        if($dayString == $targetDay)
          $appsAtDay[] = $app;
      }
    }
    return $appsAtDay;
  }

  function renderHead($days, $monthName){
    $renderedHead = "<tr class='cal-headrow'>";
    $renderedHead .= "<td class='cal-headcell'>$monthName</td>";
    foreach($days as $day){
      $renderedHead .= "<td class='cal-headcell'>$day</td>";
    }
    $renderedHead .= "</tr>";
    return $renderedHead;
  }
}


?>