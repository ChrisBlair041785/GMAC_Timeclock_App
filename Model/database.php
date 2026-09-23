<?php
class Database {
    private $host ="localhost";
    private $dbname = "SDC480_course_project";
    private $username = "ecpi_user"; 
    private $password = "Password1"; 

    private $conn;
    private $conn_error = '';

    function __construct() {
        mysqli_report(MYSQLI_REPORT_OFF);

        $this->conn = mysqli_connect($this->host, $this->username, $this->password, $this->dbname);
        if (!$this->conn) {
            $this->conn_error = 'Failed to connect to the database: ' . mysqli_connect_error();
        }
    }

    function getDBConn() { return $this->conn; }
    function getDBError() { return $this->conn_error; }

    function getDBHost() { return $this->host; }
    function getDBName() { return $this->dbname; }
    function getDBUsername() { return $this->username; }
    function getDBPassword() { return $this->password; }
}
    
