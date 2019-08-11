<?php

class Category{
    public $id;
    public $description;
    public $active;
}

class City{
    public $id;
    public $zip;
    public $name;
}

class Department{
    public $id;
    public $name;
    public $city;
}

class Permission{
    public $id;
    public $description;
    public $permissionlevel;
}

class Role{
    public $id;
    public $name;
    public $permissionId;
}

class Training{
    public $id;
    public $departmentId;
    public $categoryId;
    public $creator;
    public $start;
    public $end;
    public $description;
    public $active;
    public $interregional;
    public $public;
    public $LastChange;
}

class User{
    public $id;
    public $login;
    public $name;
    public $role;
    public $mail;
    public $password;
    public $passMustChange;
}

class User_Department{
    public $userId;
    public $departmentId;
    public $roleId;
}

?>