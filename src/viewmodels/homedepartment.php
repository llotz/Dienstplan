<?
requireLogin();

include_once("biz/DepartmentRepo.php");
include_once("biz/UserRepo.php");
$departmentRepo = new DepartmentRepo();
$userRepo = new UserRepo();
$user = $userRepo->GetCurrentUser();
$departmentId = $user['HomeDepartmentId'];

if($_POST['department'] != "")
{
  $departmentId = $_POST['department'];
  if(!is_numeric($departmentId)){
    ShowError("Da ist etwas fehlgeschlagen!");
    return;
  }
  
  $userId = $_SESSION['userId'];
  if($userRepo->SetHomeDepartment($userId, $departmentId))
    ShowMessage("Heimwehr gesetzt.");
}


$departments = $departmentRepo->GetWherePermittedEditing();
?>