<?php
    class db{
        // Properties
        private $dbhost = 'localhost';
        private $dbuser = 'complementarias';
        private $dbpass = 'Ze3XkjBEP9o2EL60';
        private $dbname = 'complementarias';

        // Connect
        public function connect(){
            $mysql_connect_str = "mysql:host=$this->dbhost;dbname=$this->dbname";
            $dbConnection = new PDO($mysql_connect_str, $this->dbuser, $this->dbpass);
            $dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $dbConnection;
        }
    }