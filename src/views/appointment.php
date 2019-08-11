<?php
include_once(getViewModel("training"));
include_once("includes/calendarItem.php");

$event = new calendarItem(
	$training["Start"],
	$training["End"],
	$training["Thema"], 
	//"Organisator: ". $training["Sector"] . " " .$training["Department"]. "\\n\\n".
	str_replace("<br />", "\\n", $training["Comment"]),
	$training["City"], 
	$training["Sector"] . " " . $training["Department"]);
$event->show();
?>