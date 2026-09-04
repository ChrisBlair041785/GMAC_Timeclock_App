<?php
function get_db_conn() {
    $hostname ="localhost";
    $username = "ecpi_user"; 
    $password = "Password1"; 
    $dbname = "SDC480_Course_Project";

    $conn = new mysqli($hostname, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    return $conn;   
}