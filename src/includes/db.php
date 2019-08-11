<?php
    // Get php Framework for mysql
    // https://github.com/ThingEngineer/PHP-MySQLi-Database-Class
    include_once("libs/MysqliDb.php");

    class dbConn{
        private $servername = "localhost:3306";
        private $dbname = "dbname";
        private $username = "username";
        private $password = "password";

        function GetConnection(){
            return new mysqli($this->servername, $this->username, $this->password, $this->dbname, 3306, 'utf8');
        }
    }
    $dbConnectionObj = new dbConn();
    $db = new MysqliDb($dbConnectionObj->GetConnection());
    $db->setCharset("utf8");
?>