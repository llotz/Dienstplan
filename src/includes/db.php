<?php
    // Get php Framewprk for mysql
    // https://github.com/ThingEngineer/PHP-MySQLi-Database-Class
    include_once("libs/MysqliDb.php");

    class dbConn{
        private $servername = "db";
        private $dbname = "dienstplan";
        private $username = "root";
        private $password = "root";

        
        function GetConnection(){
            return new mysqli($this->servername, $this->username, $this->password, $this->dbname, 3306, 'utf8');
        }
    }
    $dbConnectionObj = new dbConn();
    $db = new MysqliDb($dbConnectionObj->GetConnection());
    $db->setCharset("utf8");
?>