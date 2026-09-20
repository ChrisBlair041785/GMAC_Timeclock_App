<?php
require_once("database.php");

function All_Students() { 
    $conn = get_db_conn();
    $query = "SELECT * FROM students" ;
    $results = mysqli_query($conn, $query);
    return $results;
}

function Add_StudentDB($FirstName, $LastName, $School) { 
    $conn = get_db_conn();
    $query = "INSERT INTO students (FirstName, LastName, School) 
        VALUES ('$FirstName', '$LastName', '$School')";
    return mysqli_query($conn, $query);
}

function Add_StudentTC($StudID = null) {
    if ($StudID === null) {
        $StudID = Get_Last_Inserted_StudID();
    }
    $conn = get_db_conn();
    $query = "INSERT INTO timeclock (StudID, Arrived, Departed) 
        VALUES ('$StudID', NULL, NULL)";
    return mysqli_query($conn, $query);
}

function Get_Last_Inserted_StudID() {
    $conn = get_db_conn();
    $query = "SELECT LAST_INSERT_ID() AS StudID";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    return $row['StudID'] ?? null;
}

function Get_Student_By_ID($StudID) {
    $conn = get_db_conn();
    $query = "SELECT * FROM students WHERE StudID = '$StudID'";
    $results = mysqli_query($conn, $query);
    return mysqli_fetch_assoc($results);
}

function Update_Student($StudID, $FirstName, $LastName, $School) {
    $conn = get_db_conn();
    $query = "UPDATE students SET FirstName = '$FirstName', LastName = '$LastName', 
        School = '$School' WHERE StudID = '$StudID'";
    return mysqli_query($conn, $query);
}

function Delete_Student($StudID) {
    $conn = get_db_conn();
    $query = "DELETE FROM students WHERE StudID = '$StudID'";
    return mysqli_query($conn, $query);
}
?>