<?php

include_once("models/Appointment.php");

class CalMaker
{
  public $appointments;
  
  public function __construct($appointments)
  {
    $this->appointments = $appointments;
  }
  
  public function render($year, $month)
  {
    $renderAppointments = $this->getCurrentMonthAppointments($this->appointments, $year, $month);
    $departments = $this->getFireDepartmentStrings($renderAppointments);
    if (count($departments) == 0) {
      return "<p class='cal-not-found-message'>Es gibt noch keine geplanten Dienste für diesen Monat.</p>";
    }
    
    $daysTotal = $this->getDaysOfMonthString($year, $month);
    $renderedCalendar= "<div class='calendar'>";
    for ($week=0; $week<=sizeof($daysTotal)/7; $week++){
      $days = array_slice($daysTotal, $week*7, 7);      
      $renderedTable = "<table class='cal-table'>";
      $renderedTable .= $this->renderHead($days, $month, $year);
      foreach ($departments as $department) {
        $renderedTable .= "<tr class='cal-row'>";
        $renderedTable .= "<td>$department</td>";
        foreach ($days as $day) {
          $dayApps = $this->getAppointmentsAtDate($renderAppointments, $department, $day, $month, $year);
          
          if (count($dayApps) > 0) {
            $id = $dayApps[0]['Id'];
            $letter = (($dayApps[0]['IsEvent']) ? 'E' : 'D');
            $tooltip = $this->getToolTipText($dayApps);
            $renderedTable .= "
            <td class='cal-highlightcell'>
            <div class='tooltip'>
            <a href=/training/$id>$letter</a>
            <span class='tooltiptext'>$tooltip</span>
            </div>
            ";
          } else
          $renderedTable .= "<td>";
          $renderedTable .= "</td>";
        }
        $renderedTable .= "</tr>";
      }
      $renderedTable .= "</table>";
      $renderedCalendar .= $renderedTable;
    }
    $renderedCalendar .= "</div>";
    return $renderedCalendar;
  }
  
  function getToolTipText($dayApps)
  {
    $foo = "";
    foreach ($dayApps as $dayApp) {
      
      $foo .= "-------<br>" . date("H:i", strtotime($dayApp["Start"])) . ": " . $dayApp["Thema"] . "<br>";
    }
    $foo .= "-------";
    return $foo;
  }
  
  function getCurrentMonthAppointments($appointments, $year, $month)
  {
    $targetMonth = "$year:$month";
    $filtered = array();
    foreach ($appointments as $app) {
      $compareString = date("Y:m", strtotime($app["Start"]));
      if ($compareString == $targetMonth)
      $filtered[] = $app;
    }
    return $filtered;
  }
  
  function getFireDepartmentStrings($appointments)
  {
    $departments = array();
    foreach ($appointments as $app) {
      if (!in_array($app["Feuerwehr"], $departments, true))
      $departments[] = $app["Feuerwehr"];
    }
    return $departments;
  }
  
  function getDaysOfMonthString($year, $month)
  {
    $days = date('t', mktime(0, 0, 0, $month, 1, $year));
    $dayArray = array();
    $diff = $this->getDifferenceToLastMonday($year, $month);
    for ($i = 0; $i <= $diff; $i++){
      $dayArray[] = "00";
    }
    for ($i = 1; $i <= $days; $i++) {
      $dayArray[] = sprintf('%02d', $i);
    }
    
    return $dayArray;
  }
  
  function getDifferenceToLastMonday($year, $month)
  {
    for($d=1; $d<=8; $d++){
      $time = mktime(0, 0, 0, $month, (int)$d, $year);
      $dayOfWeek = date("N", $time);
      if($dayOfWeek == 1)return abs(7-$d);
    }
  }
  
  
  function getAppointmentsAtDate($appointments, $department, $day, $month, $year)
  {
    $appsAtDay = array();
    $targetDay = "$year:$month:$day";
    foreach ($appointments as $app) {
      if ($app["Feuerwehr"] == $department) {
        $dayString = date("Y:m:d", strtotime($app["Start"]));
        if ($dayString == $targetDay)
        $appsAtDay[] = $app;
      }
    }
    return $appsAtDay;
  }
  
  function renderHead($days, $month, $year)
  {
    $renderedHead = "<tr class='cal-headrow'>";
    $renderedHead .= "<td class='cal-headcell'>" . date('F', mktime(0, 0, 0, $month)) . " $year" . "</td>";
    foreach ($days as $day) {
      if($day=="00"){
        $renderedHead .= "<td class='cal-headcell'>xx<br>00</td>";
        continue;  
      }
      $time = mktime(0, 0, 0, $month, (int)$day, $year);
      $dayOfWeek = date("N", $time);
      $isToday = date("Y-m-d", $time) == date("Y-m-d", time());
      $renderedHead .= "<td class='cal-headcell" . (($isToday) ? " cal-headcell-today" : "") . "'>" . $this->getShortWeekDayName($dayOfWeek) . "<br>" . $day . "</td>";
    }
    $renderedHead .= "</tr>";
    return $renderedHead;
  }
  
  function getShortWeekDayName($dayOfWeek)
  {
    $days = array(
      1 => "Mo",
      2 => "Di",
      3 => "Mi",
      4 => "Do",
      5 => "Fr",
      6 => "Sa",
      7 => "So"
    );
    return $days[$dayOfWeek];
  }
  
}