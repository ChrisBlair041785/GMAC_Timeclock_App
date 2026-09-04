<?php
require_once("database.php");

function Add_Login($Username, $Password) {
    $conn = get_db_conn();
    $query = "INSERT INTO logins (Username, Password) 
        VALUES ('$Username', '$Password')";
    return mysqli_query($conn, $query);
}

function All_Logins() {
    $conn = get_db_conn();
    $query = "SELECT * FROM logins";
    $results = mysqli_query($conn, $query);
    return $results;
}

function Get_Login_By_ID($LoginID) {
    $conn = get_db_conn();
    $query = "SELECT * FROM logins WHERE LoginID = '$LoginID'";
    $results = mysqli_query($conn, $query);
    return mysqli_fetch_assoc($results);
}

function Update_Login($LoginID, $Username, $Password) {
    $conn = get_db_conn();
    $query = "UPDATE logins SET Username = '$Username', Password = '$Password' 
        WHERE LoginID = '$LoginID'";
    return mysqli_query($conn, $query);
}

function Delete_Login($LoginID) {
    $conn = get_db_conn();
    $query = "DELETE FROM logins WHERE LoginID = '$LoginID'";
    return mysqli_query($conn, $query);
}
?>