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
}
?>