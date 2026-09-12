<?php 
require_once("database.php"); 

function All_Users() {
    $conn = get_db_conn();
    $query = "SELECT * FROM users";
    $results = mysqli_query($conn, $query);
    return $results;
}

function Add_User($LastName, $FirstName, $Email, $Password) {
    $conn = get_db_conn();
    $query = "INSERT INTO users (LastName, FirstName, Email, Password ) 
        VALUES ('$LastName', '$FirstName', '$Email', '$Password')";
    return mysqli_query($conn, $query);
}

function Get_User_By_ID($ID) {
    $conn = get_db_conn();
    $query = "SELECT * FROM users WHERE ID = '$ID'";
    $results = mysqli_query($conn, $query);
    return mysqli_fetch_assoc($results);
}

function Update_User($ID, $LastName, $FirstName, $Email, $Password) {
    $conn = get_db_conn();
    $query = "UPDATE users SET LastName = '$LastName', FirstName = '$FirstName', 
        Email = '$Email', Password = '$Password', WHERE ID = '$ID'";
    return mysqli_query($conn, $query);
}

function Delete_User($ID) {
    $conn = get_db_conn();
    $query = "DELETE FROM users WHERE ID = '$ID'";
    return mysqli_query($conn, $query);
}

?>
