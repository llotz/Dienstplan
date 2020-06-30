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
			$monthNum = intval(explode("-", $yearMonth)[1]);
			$monthName = $this->GetGermanMonthString($monthNum);
			$year = explode("-", $yearMonth)[0];
			$renderedOptionsString .= 
				"<option value='$yearMonth' $selected>$year - $monthName</option>";
		}
		return $renderedOptionsString;
	}

	public function GetGermanMonthString($monthNumber){
		$monate = array(1=>"Januar",
                2=>"Februar",
                3=>"März",
                4=>"April",
                5=>"Mai",
                6=>"Juni",
                7=>"Juli",
                8=>"August",
                9=>"September",
                10=>"Oktober",
                11=>"November",
                12=>"Dezember");
		return $monate[$monthNumber];
	}
}


?>