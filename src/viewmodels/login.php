<?
    if($_SESSION['name'] != ""){
        redirect("main");
    }

    if(isset($_POST['password']) && isset($_POST['email'])){
        $email = $_POST['email'];
        $password = $_POST['password'];
        $db->where('Mail', "$email");
        $user = $db->get('User', 1)[0];
        $hash = $user['Password'];
        //echo password_hash($password, PASSWORD_DEFAULT);
        if(!empty($user) && password_verify($password, $hash)){
            // Set Session variables
            $_SESSION['name'] = $user['Name'];
            $_SESSION['mail'] = $user['Mail'];
            $_SESSION['userId'] = $user['Id'];
            echo "session set";
            if($user['PassMustChange'] != 0)
                redirect("pwchange");
            else 
                redirect("main");

        }
        else{
            $error = "Benutzername oder Passwort falsch!";
            session_destroy();
        }
    }


?>