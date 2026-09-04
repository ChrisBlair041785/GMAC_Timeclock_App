<?php 
require_once("database.php"); 

function All_Users() {
    $conn = get_db_conn();
    $query = "SELECT * FROM users";
    $results = mysqli_query($conn, $query);
    return $results;
}

function Add_User($LastName, $FirstName, $AccessLevel) {
    $conn = get_db_conn();
    $query = "INSERT INTO users (LastName, FirstName, AccessLevel) 
        VALUES ('$LastName', '$FirstName', '$AccessLevel')";
    return mysqli_query($conn, $query);
}

function Get_User_By_ID($ID) {
    $conn = get_db_conn();
    $query = "SELECT * FROM users WHERE ID = '$ID'";
    $results = mysqli_query($conn, $query);
    return mysqli_fetch_assoc($results);
}

function Update_User($ID, $LastName, $FirstName, $AccessLevel) {
    $conn = get_db_conn();
    $query = "UPDATE users SET LastName = '$LastName', FirstName = '$FirstName', 
        AccessLevel = '$AccessLevel' WHERE ID = '$ID'";
    return mysqli_query($conn, $query);
}

function Delete_User($ID) {
    $conn = get_db_conn();
    $query = "DELETE FROM users WHERE ID = '$ID'";
    return mysqli_query($conn, $query);
}
?>
