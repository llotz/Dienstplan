<?
requireLogin();
include_once("biz/UserRepo.php");
$userRepo = new UserRepo();

if($_POST['oldpw'] != "")
{
    if($_POST['newpw'] != "" 
    && $_POST['newpw'] == $_POST['repeatpw'])
    {
        $user = $userRepo->GetCurrentUser();
        if(!empty($user) && password_verify($_POST['oldpw'], $user['Password'])){
            // Change PW
            $newPasswordHash = password_hash($_POST['newpw'], PASSWORD_DEFAULT);
            if($userRepo->SetNewPassword($user["Id"], $newPasswordHash))
                ShowMessage("Passwort aktualisiert!");
            else{
                ShowError("Da ist etwas fehlgeschlagen!");
            }
        }else{
            ShowError("Das aktuelle Passwort war nicht korrekt!");
        }
    }else{
        ShowError("Falsche Eingabe!");
    }
}
?>