<?php

class MonthGenerator{

	public function __constructor(){

	}

	public function GetMonthRange($startYear, $startMonth, $monthRange){
		$tmpMonth = $startMonth;
		$tmpYear = $startYear;
		$monthArray = array();
		for($i; $i < $monthRange; $i++){
			if($tmpMonth == 13){
				$tmpMonth = 1;
				$tmpYear++;
			}
			$formattedMonth = sprintf('%02d', $tmpMonth);
			array_push($monthArray, "$tmpYear-$formattedMonth");
			$tmpMonth++;
		}
		return $monthArray;
	}
	
	public function GetOptionsArray($monthArray, $selectedMonth){
		$renderedOptionsString = "";
		foreach($monthArray as $yearMonth){
			$selected = "";
			if($selectedMonth == $yearMonth)
				$selected = "selected";
			$renderedOptionsString .= 
				"<option value='$yearMonth' $selected>$yearMonth</option>";
		}
		return $renderedOptionsString;
	}
}


?>