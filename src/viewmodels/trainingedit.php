<?php
// declare a required login
requireLogin();

// Repository Import
include_once("biz/TrainingRepo.php");
include_once("biz/DepartmentRepo.php");
include_once("biz/CategoryRepo.php");
include_once("biz/CityRepo.php");
include_once("biz/SectorRepo.php");
include_once("biz/UserRepo.php");

// Repository Declaration
$trainingRepo = new TrainingRepo();
$departmentRepo = new DepartmentRepo();
$categoryRepo = new CategoryRepo();
$cityRepo = new CityRepo();
$sectorRepo = new SectorRepo();
$userRepo = new UserRepo();
//$trainingTypeRepo = new TrainingTypeRepo();

// allocate lists
$departments = $departmentRepo->GetWherePermittedEditing();
$categories = $categoryRepo->GetAll();
$cities = $cityRepo->GetAll("", "Name");
$sectors = $sectorRepo->GetAll();
//$trainingTypes = $trainingTypeRepo->GetAll();


// variable declarations from get
$id = 0;
if(isset($_GET["id"]))
    $id = $_GET["id"];

if(isset($_GET["departmentId"]))
$preSelectedDepartmentId = $_GET["departmentId"];

if(!isset($preSelectedDepartmentId)){
  $preSelectedDepartmentId = $userRepo->GetCurrentUser()["HomeDepartmentId"];
}

// empty var declaration
$training = null;
$isNew = true;
$description = "";
$departmentId = $preSelectedDepartmentId;
$categoryId = null;
$cityId = null;
$sectorId = null;
$comment = "";
//$trainingTypeId = null;
$start = strtotime(date('Y-m-d', time())." 19:00");
$end = strtotime(date('Y-m-d', time())." 21:00");
$saveButtonText = "Übernehmen";
$titleText = "Übung";
$saveButtonName = "insert";
$deleteButtonVisible = false;

if($preSelectedDepartmentId != ""){
    $departmentCity = $cityRepo->GetByDepartment($preSelectedDepartmentId);
    if(is_array($departmentCity))
    $cityId = $departmentCity["Id"];
}

// Update or Insert to Database
if(array_key_exists("insert", $_POST) ||  array_key_exists("update", $_POST)){
    if($id != 0 && !$trainingRepo->CheckEditPermission($id)){
        ShowError("Sie haben keine Berechtigungen, diesen Dienst zu editieren!", false);
    }
    else if($preSelectedDepartmentId != ""){
        include_once(getBiz("department"));
        $userPermissionLevel = $department->getPermissionLevel($_POST["department"]);
        if($userPermissionLevel < 50)
        	ShowError("Sie haben keine Berechtigungen, diesen Dienst anzulegen!", false);
    }

    // content validation
    if($_POST["topic"]==""){
      ShowError("Es muss ein Thema angegeben werden!", false);
      return;
    }  

    if(array_key_exists("insert", $_POST))
    {
      $temp = $trainingRepo->Insert($_POST);
      if($temp){
        $id = $temp;
			  ShowMessage("Dienst angelegt!", false);
      }
    }
    else if(array_key_exists("update", $_POST))
        $trainingRepo->Update($_POST["id"], $_POST);
}

if(array_key_exists("delete", $_POST)){
    if(!$trainingRepo->CheckEditPermission($id))
        ShowError("Sie haben keine Berechtigungen, diesen Dienst zu löschen!", false);
    $trainingRepo->Delete($_POST["id"]);
}
else if($id != "")
{
    $training = $trainingRepo->GetById($id);
    if(!$trainingRepo->CheckEditPermission($id))
        ShowError("Sie haben keine Berechtigungen, diesen Dienst zu editieren!", false);
    $isNew = false;
    $departmentId = $training["DepartmentId"];
    $categoryId = $training["CategoryId"];
    $cityId = $training["CityId"];
    $sectorId = $training["SectorId"];
    //$trainingTypeId = $training["TrainingTypeId"];
    $start = strtotime($training["Start"]);
    $end = strtotime($training["End"]);
    $description = mybr2nl($training["Description"]);
    $comment = mybr2nl($training["Comment"]);
    $deleteButtonVisible = true;
}

if($isNew){
    $saveButtonText = "Anlegen";
    $titleText = "Dienst anlegen";
    $saveButtonName = "insert";
}else{
    $titleText = "Dienst bearbeiten";
    $saveButtonName = "update";
}

?>