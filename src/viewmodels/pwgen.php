<?php
requireAdminPermission();
$password = "";
$pwHash = "";
if(isset($_POST['password'])){
    $password = $_POST['password'];
    $pwHash = password_hash($password, PASSWORD_DEFAULT);
}
?>