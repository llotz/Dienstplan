<?php
    include_once("BaseRepo.php");

    class TrainingRepo extends BaseRepo{
        public function __construct(){
            $this->tableName = "Training";
        }

        public function CheckEditPermission($trainingId){
            global $db;
            global $sessionManager;
            if(!is_numeric($trainingId)) return false;

            $sqlQuery = "SELECT t.Id 
            FROM Training t
            JOIN Department d ON t.DepartmentId = d.Id
            JOIN User_Department ud ON d.Id = ud.DepartmentId
            JOIN User u ON u.Id = ud.UserId
            JOIN Role r ON r.Id = ud.RoleId
            JOIN Permission p ON p.Id = r.PermissionId
            WHERE t.Id = {$trainingId} 
            AND u.Mail = '{$sessionManager->getMailAdress()}'
            AND p.Permissionlevel >= 50";
            $result = $db->rawQuery($sqlQuery);
            if(is_array($result) && count($result) > 0 && $result[0]["Id"] == $trainingId)
                return true;
            else 
                return false;
        }

        public function GetTrainings($where){

          global $db;

					$query = "SELECT Training.Id, 
          DATE_FORMAT(Start, '%w, %d.%m. %H:%i Uhr') as Beginn,
          Department.Name as Feuerwehr, 
          City.Name as Ort, 
          Training.Description as Thema, 
          IsEvent,
          Sector.Name as Abteilung,
          Week(Training.Start, 1) as KW,
          Start as Start,
          End as End
          from Training
          LEFT JOIN Category ON CategoryId = Category.Id
          LEFT JOIN Department ON DepartmentId = Department.Id
          LEFT JOIN User ON Creator = User.Id
          LEFT JOIN City ON City.Id = Department.CityId
          LEFT JOIN Sector ON SectorId = Sector.Id
          WHERE Training.Public = true
          $where 
					ORDER BY Start ASC;";

          $trainings = $db->rawQuery($query);
      
          $weekday = array(
              "0" => "Sonntag",
              "1" => "Montag",
              "2" => "Dienstag",
              "3" => "Mittwoch",
              "4" => "Donnerstag",
              "5" => "Freitag",
              "6" => "Samstag",
          );
          
          // replace that week day number with a string
          for($i = 0; $i < count($trainings); $i++){
              $foo = $trainings[$i]["Beginn"];
              $trainings[$i]["Beginn"] = $weekday[substr($foo, 0, 1)] . substr($foo, 1);
          }
      
          return $trainings;
        }

        public function Update($id, $values){
            global $db;
            global $sessionManager;

            $date = $values["startdate"];
            $startTime = $values["starttime"];
            $endTime = $values["endtime"];

            
            $departmentId = $values["department"];
            $categoryId = $values["category"];
            $cityId = $values["city"];
            $sectorId = $values["sector"];
            $start = GetDateTimeStringFromDateAndTimeString($date, $startTime);
            $end = GetDateTimeStringFromDateAndTimeString($date, $endTime);
            $trainingTypeId = 3;
            $isEvent = isset($values["isEvent"]);
            $creator = $sessionManager->getUserId();
            $description = mynl2br($values["topic"]);
            $comment = mynl2br($values["description"]);
            $data = Array(
                "DepartmentId" => $departmentId, 
                "CategoryId" => $categoryId,
                "CityId" => $cityId,
                "SectorId" => $sectorId,
                "Creator" => $creator,
                "Start" => $start,
                "End" => $end,
                "Description" => $description,
                "Comment" => $comment,
                "TrainingTypeId" => $trainingTypeId,
                "IsEvent" => (($isEvent)?1:0),
            );

            $db->where('Id', $id);
            if($db->update('Training', $data))
                ShowMessage("Gespeichert.");
            else
                ShowError($db->getLastError());
            return $id;
        }

        public function Insert($values){
            global $db;
            global $sessionManager;

            $date = $values["startdate"];
            if(validateDate($date, "d.m.Y"))
                $date = convertDateTimeString($date, "d.m.Y", "Y-m-d");
            $startTime = $values["starttime"];
            $endTime = $values["endtime"];

            
            $departmentId = $values["department"];
            $categoryId = $values["category"];
            $cityId = $values["city"];
            $sectorId = $values["sector"];
            $start = GetDateTimeStringFromDateAndTimeString($date, $startTime);
            $end = GetDateTimeStringFromDateAndTimeString($date, $endTime);
            $trainingTypeId = 3;
            $isEvent = isset($values["isEvent"]);
            $creator = $sessionManager->getUserId();
            $description = $db->escape(mynl2br($values["topic"]));
            $comment = $db->escape(mynl2br($values["description"]));
            $data = Array(
                "DepartmentId" => $departmentId, 
                "CategoryId" => $categoryId,
                "CityId" => $cityId,
                "SectorId" => $sectorId,
                "Creator" => $creator,
                "Start" => $start,
                "End" => $end,
                "Description" => $description,
                "Comment" => $comment,
                "TrainingTypeId" => $trainingTypeId,
                "IsEvent" => (($isEvent)?1:0),
            );

            //print_r($data);

            $id = $db->insert('Training', $data);
            return $id;
        }

        public function Delete($id){
            global $db;
            $db->where('Id', $id);
            if($db->delete('Training')){
                ShowMessage("Dienst gelöscht!", false);
            }
        }
    }
