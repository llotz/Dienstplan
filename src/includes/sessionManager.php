<?
session_start();
class SessionManager{
	public function isLoggedIn(){
		return isset($_SESSION['name']);
	}

	public function getMailAdress(){
		if(!isset($_SESSION['mail']))
				return "";    
		return $_SESSION['mail'];
	} 

	public function getLoginString(){
		if(!$this->isLoggedIn())
				return "<div class=\"login-info\">Nicht eingeloggt. <a href=\"/login\">login</a></div>";

		$loginString = 
		sprintf("Eingeloggt als %s<br>
		<a href=/%s>Einstellungen</a> | 
		<a href=/%s>Logout</a>", 
		$_SESSION["name"], 
		"usersettings",
		getView("logout"));
		$loginString = "<p class='login-info'>".$loginString."</p>";
		return $loginString;
	}

	public function getUserId(){
		return $_SESSION['userId'];
	}

	public function SetFailedLoginAttempt(){
		if(isset($_SESSION['failedLoginAttempts'])) 
			$_SESSION['failedLoginAttempts'] += 1;
		else
			$_SESSION['failedLoginAttempts'] = 1;
	}

	public function SetLastFailedLoginAttemptTime(){
		$_SESSION['lastFailedLoginAttemptTime'] = time();
	}

	public function ValidateLastLoginAttemptTime(){
		global $login_time_between_logins;
		if(!isset($_SESSION['lastFailedLoginAttemptTime']))
			return true;
		if(time() < ($_SESSION['lastFailedLoginAttemptTime'] 
				+ $login_time_between_logins))
			return false;
		return true;
	}

	public function IsTimeoutNeeded(){
		global $login_max_attempts_before_timeout;
		if(isset($_SESSION['failedLoginAttempts'])
			&& $_SESSION['failedLoginAttempts'] >= $login_max_attempts_before_timeout)
			return true;
		return false;
	}

	public function SetTimeout(){
		global $login_failed_attempts_timeout;
		$_SESSION['loginTimeout'] = time() + $login_failed_attempts_timeout;
	}

	public function ValidateTimeout(){
		if(!isset($_SESSION["loginTimeout"]))
			return true;
		if($_SESSION['loginTimeout'] >= time())
			return false;
		unset($_SESSION['loginTimeout']);
		unset($_SESSION['failedLoginAttempts']);
		return true;
	}
}
?>