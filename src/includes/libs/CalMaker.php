<?php

include_once("models/Appointment.php");

class CalMaker{
  public $appointments;
  
  public function __construct($appointments){
    $this->appointments = $appointments;
  }

  public function render(){

  }

}


?>