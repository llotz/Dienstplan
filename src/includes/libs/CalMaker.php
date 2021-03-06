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
    if(count($departments) == 0){
      return "<p class='cal-not-found-message'>Es gibt noch keine geplanten Dienste für diesen Monat.</p>";
    }
    
    $days = $this->getDaysOfMonth($year, $month);
    $renderedTable = "<table class='cal-table'>";
    $renderedTable .= $this->renderHead($days, date('F', mktime(0, 0, 0, $month))." $year");
    foreach($departments as $department){
      $renderedTable .= "<tr class='cal-row'>";
      $renderedTable .= "<td>$department</td>";
      foreach($days as $day){
        $dayApps = $this->getAppointmentsAtDate($renderAppointments, $department, $day, $month, $year);
        
        if(count($dayApps) > 0){
          $id = $dayApps[0]['Id'];
          $letter = (($dayApps[0]['IsEvent'])?'E' : 'D');
          $tooltip = $this->getToolTipText($dayApps);
          $renderedTable .= "
            <td class='cal-highlightcell'>
            <div class='tooltip'>
            <a href=/training/$id>$letter</a>
            <span class='tooltiptext'>$tooltip</span>
          </div>
          ";
        }else 
          $renderedTable .= "<td>";
        $renderedTable .= "</td>";
      }
      $renderedTable .= "</tr>";
    }
    $renderedTable .= "</table>";
    return $renderedTable;
  }

  function getToolTipText($dayApps){
    return date("H:i", strtotime($dayApps[0]["Start"]))." Uhr ". $dayApps[0]["Thema"];
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
      $dayArray[] = sprintf('%02d', $i);
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