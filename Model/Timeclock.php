<?php
require_once("database.php");

function All_TC_Studs() { 
    $conn = get_db_conn();
    $query = "SELECT * FROM timeclock" ;
    $results = mysqli_query($conn, $query);
    return $results;
}

function Add_TC_Student($FirstName, $LastName, $Arrived, $Departed) { 
    $conn = get_db_conn();
    $query = "INSERT INTO timeclock (FirstName, LastName, Arrived, Departed) 
        VALUES ('$FirstName', '$LastName', '$Arrived', '$Departed')";
    return mysqli_query($conn, $query);
}

function Get_TC_Student_By_ID($StudID) {
    $conn = get_db_conn();
    $query = "SELECT * FROM timeclock WHERE StudID = '$StudID'";
    $results = mysqli_query($conn, $query);
    return mysqli_fetch_assoc($results);
}

function Update_TC_Student($StudID, $FirstName, $LastName, $Arrived, $Departed) {
    $conn = get_db_conn();
    $query = "UPDATE timeclock SET FirstName = '$FirstName', LastName = '$LastName', 
        Arrived = '$Arrived', Departed = '$Departed' WHERE StudID = '$StudID'";
    return mysqli_query($conn, $query);
}

function Delete_TC_Student($StudID) {
    $conn = get_db_conn();
    $query = "DELETE FROM timeclock WHERE StudID = '$StudID'";
    return mysqli_query($conn, $query);
}
?>