<?php
include_once("includes/sessionManager.php");
$sessionManager = new SessionManager();

if(isset($_SESSION['name'])){
		redirect("main");
}

if(isset($_POST['password']) && isset($_POST['email'])){
	if(!$sessionManager->ValidateLastLoginAttemptTime())
	{
		$error = "Du bist zu schnell!";
		$sessionManager->SetLastFailedLoginAttemptTime();
	}
	else if(!$sessionManager->ValidateTimeout())
		$error = "Zu viele fehlerhafte Loginversuche. Versuch es später nocheinmal.";
	else{
		$email = $_POST['email'];
		$password = $_POST['password'];
		$db->where('Mail', "$email");
		$user = $db->get('User', 1)[0];
		$hash = $user['Password'];

		if(!empty($user) && password_verify($password, $hash)){
			// Set Session variables
			$_SESSION['name'] = $user['Name'];
			$_SESSION['mail'] = $user['Mail'];
			$_SESSION['userId'] = $user['Id'];
			
			if($user['PassMustChange'] != 0)
				redirect("pwchange");
			else 
				redirect("main");
		}
		else{
			$error = "Benutzername oder Passwort falsch!";
			$sessionManager->SetFailedLoginAttempt();
			$sessionManager->SetLastFailedLoginAttemptTime();
			if($sessionManager->IsTimeoutNeeded()){
				$sessionManager->SetTimeout();
				$error = "Zu viele fehlerhafte Loginversuche. Versuch es später nocheinmal.";
			}
		}
	}

	
}


?>